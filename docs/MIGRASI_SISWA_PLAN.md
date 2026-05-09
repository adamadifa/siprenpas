# Rancangan Fitur Migrasi Siswa Existing ke Sipren

> **Tanggal**: 2 Mei 2026  
> **Status**: Belum dieksekusi — siap untuk implementasi  
> **Estimasi file baru**: ~14 file

---

## Keputusan Desain (Final)

| No | Keputusan | Hasil |
|----|-----------|-------|
| 1 | Enum pendaftaran | Tambah `'Migrasi'` ke enum `jenis_pendaftaran` |
| 2 | Data wilayah | **Opsional** — bisa dilengkapi nanti |
| 3 | Duplikat siswa | **Pakai data existing** — buat pendaftaran baru saja |
| 4 | NIS | **Dari Excel** — preservasi identitas lama |
| 5 | Rencana SPP | **Tidak auto-generate** — di-generate manual per siswa nanti |
| 6 | Rollback | **Ada** — bisa hapus semua data 1 batch import |
| 7 | Histori pembayaran lama | Cukup pakai **Mutasi** (tidak perlu input detail per transaksi) |

---

## Konteks Masalah

Ketika sistem Sipren pertama kali dijalankan (go-live), pesantren sudah memiliki siswa/santri aktif di berbagai tingkat (tingkat 2, 3, dst). Volume bisa ratusan hingga ribuan siswa. Input manual via form pendaftaran tidak realistis, sehingga dibutuhkan fitur **Import Excel** untuk migrasi massal.

### Alur Data Normal di Sipren (Siswa Baru):
```
Siswa → Pendaftaran → Siswa_Biaya → Rencana SPP → Pembayaran → Kelas
```

### Alur Data Migrasi (Siswa Existing):
```
Import Excel → Siswa → Pendaftaran (jenis='Migrasi') → Siswa_Biaya → [Mutasi] → [Assign Kelas]
                                                                            ↓
                                                                  Rencana SPP (manual nanti)
```

---

## Skenario Go-Live

### Skenario A: Awal Tahun Ajaran Baru (Direkomendasikan)
- Import semua siswa existing dengan tingkat saat ini
- Tagihan terbentuk full — tidak perlu mutasi
- Data bersih, paling simpel

### Skenario B: Tengah Tahun Ajaran
- Import siswa + isi Sheet 2 (status pembayaran)
- Biaya yang sudah dibayar masuk sebagai Mutasi otomatis
- Rencana SPP di-generate manual mulai bulan berjalan

---

## Tabel Database Baru

### Tabel: `migrasi_log`
Tracking per batch import.

```
id                  - bigint, auto increment, PK
nama_file           - string (nama file Excel yang diupload)
kode_ta             - char(6) → TA tujuan import
total_baris         - int
berhasil            - int
gagal               - int
status              - enum: 'pending', 'processing', 'done', 'error', 'rolled_back'
catatan_error       - json nullable (detail error per baris)
id_user             - bigint unsigned → siapa yang upload
timestamps
```

### Tabel: `migrasi_log_detail`
Tracking per record yang diimport (untuk rollback).

```
id                  - bigint, auto increment, PK
migrasi_log_id      - FK → migrasi_log.id
no_pendaftaran      - char(11) → record pendaftaran yang dibuat
id_siswa            - char(7) → record siswa
is_new_siswa        - boolean → apakah siswa baru dibuat atau pakai existing
baris_excel         - int → baris ke berapa di Excel
status              - enum: 'success', 'failed', 'rolled_back'
keterangan          - string nullable
timestamps
```

### Modifikasi: tabel `pendaftaran`
Ubah enum kolom `jenis_pendaftaran` dari `['Baru', 'Pindahan']` menjadi `['Baru', 'Pindahan', 'Migrasi']`

---

## Template Excel

### Sheet 1: Data Siswa

| Kolom | Wajib | Keterangan |
|-------|-------|-----------|
| nisn | ❌ | 10 digit |
| nama_lengkap | ✅ | |
| jenis_kelamin | ✅ | L atau P |
| tempat_lahir | ✅ | |
| tanggal_lahir | ✅ | Format: YYYY-MM-DD |
| anak_ke | ❌ | |
| jumlah_saudara | ❌ | |
| alamat | ❌ | Opsional |
| kode_pos | ❌ | |
| no_kk | ❌ | |
| nik_ayah | ❌ | |
| nama_ayah | ❌ | |
| pendidikan_ayah | ❌ | |
| pekerjaan_ayah | ❌ | |
| nik_ibu | ❌ | |
| nama_ibu | ❌ | |
| pendidikan_ibu | ❌ | |
| pekerjaan_ibu | ❌ | |
| no_hp_orang_tua | ❌ | |
| kode_unit | ✅ | Harus sesuai tabel unit (contoh: U01, U02) |
| tingkat_sekarang | ✅ | Tingkat siswa saat ini (1, 2, 3, dst) |
| nis | ❌ | NIS lama, jika kosong → auto generate |
| nama_kelas | ❌ | Nama kelas tujuan (opsional, bisa assign manual nanti) |

### Sheet 2: Status Pembayaran (Opsional — hanya jika go-live tengah TA)

| Kolom | Keterangan |
|-------|-----------|
| nama_lengkap | Untuk matching ke Sheet 1 |
| kode_unit | Untuk matching |
| kode_jenis_biaya | Kode jenis biaya (B01, B02, dll) |
| jumlah_sudah_bayar | Total yang sudah dibayar |
| keterangan | Catatan |

### Sheet Referensi (auto-generated)
- Daftar kode_unit + nama_unit
- Daftar kode_jenis_biaya + nama
- Daftar kelas yang tersedia (nama_kelas + unit + tingkat)

---

## Tahapan Implementasi

### Tahap 1: Database — Migration & Model

**File baru:**
1. `database/migrations/xxxx_add_migrasi_to_jenis_pendaftaran.php`
   - Ubah enum `jenis_pendaftaran` → tambah `'Migrasi'`

2. `database/migrations/xxxx_create_migrasi_log_table.php`
   - Buat tabel `migrasi_log`

3. `database/migrations/xxxx_create_migrasi_log_detail_table.php`
   - Buat tabel `migrasi_log_detail`

4. `app/Models/MigrasiLog.php`
   - Model dengan relasi `hasMany(MigrasiLogDetail::class)`

5. `app/Models/MigrasiLogDetail.php`
   - Model dengan relasi `belongsTo(MigrasiLog::class)`

**Verifikasi:** Jalankan `php artisan migrate` — pastikan tidak error.

---

### Tahap 2: Install Package & Template Excel

**Tasks:**
1. Install package: `composer require maatwebsite/excel`
2. Publish config: `php artisan vendor:publish --provider="Maatwebsite\Excel\ExcelServiceProvider" --tag=config`

**File baru:**
3. `app/Exports/TemplateMigrasiExport.php`
   - Multi-sheet export: Sheet 1 (Data Siswa), Sheet 2 (Pembayaran), Sheet Referensi
   - Sheet Referensi auto-fill dari database (unit, jenis biaya, kelas)

**Verifikasi:** Download template → buka di Excel → format header benar.

---

### Tahap 3: Import Logic (Core)

**File baru:**
1. `app/Imports/MigrasiSiswaImport.php`
   - Baca Sheet 1
   - Validasi: format, kode_unit valid, tingkat punya konfigurasi_biaya, NIS tidak duplikat
   - Cek duplikat siswa (nama_lengkap + tanggal_lahir) → pakai existing jika ada
   - Insert: siswa → pendaftaran (jenis='Migrasi') → siswa_biaya → kelas_siswa
   - Catat ke migrasi_log_detail

2. `app/Imports/MigrasiPembayaranImport.php`
   - Baca Sheet 2
   - Match siswa by nama_lengkap + kode_unit → dapatkan no_pendaftaran
   - Insert ke `pembayaran_pendidikan_mutasi`

**Detail proses per row:**
```
1. VALIDASI
   ├─ nama_lengkap wajib
   ├─ jenis_kelamin = L/P
   ├─ kode_unit ada di tabel unit
   ├─ tingkat punya konfigurasi_biaya di TA aktif
   └─ NIS tidak duplikat

2. CEK DUPLIKAT (nama_lengkap + tanggal_lahir)
   ├─ SUDAH ADA → pakai id_siswa existing
   └─ BELUM ADA → insert siswa baru

3. INSERT PENDAFTARAN
   ├─ no_pendaftaran = auto generate
   ├─ NIS = dari Excel (atau auto jika kosong)
   ├─ jenis_pendaftaran = 'Migrasi'
   └─ tingkat_masuk = tingkat_sekarang

4. INSERT SISWA_BIAYA
   └─ Link ke konfigurasi_biaya (unit + tingkat + TA)

5. ASSIGN KELAS (jika nama_kelas diisi)
   └─ Cari kode_kelas → insert ke kelas_siswa

6. CATAT LOG
   └─ Insert ke migrasi_log_detail
```

**Verifikasi:** Unit test dengan data sample kecil (5-10 record).

---

### Tahap 4: Controller & Routes

**File baru:**
1. `app/Http/Controllers/MigrasiSiswaController.php`

**Method-method:**

| Method | Route | HTTP | Fungsi |
|--------|-------|------|--------|
| `index()` | `/migrasi-siswa` | GET | Halaman utama + form upload |
| `downloadTemplate()` | `/migrasi-siswa/template` | GET | Download template Excel |
| `upload()` | `/migrasi-siswa/upload` | POST | Upload + validasi → simpan temp → redirect preview |
| `preview()` | `/migrasi-siswa/preview/{id}` | GET | Preview data valid + error |
| `proses()` | `/migrasi-siswa/proses/{id}` | POST | Eksekusi import (chunked per 50) |
| `riwayat()` | `/migrasi-siswa/riwayat` | GET | Daftar histori import |
| `rollback()` | `/migrasi-siswa/rollback/{id}` | POST | Hapus semua data 1 batch |

**Modifikasi:**
2. `routes/web.php` — tambah route group:
```php
Route::prefix('migrasi-siswa')
    ->middleware(['auth', 'role:super admin'])
    ->group(function () {
        Route::get('/', [MigrasiSiswaController::class, 'index']);
        Route::get('/template', [MigrasiSiswaController::class, 'downloadTemplate']);
        Route::post('/upload', [MigrasiSiswaController::class, 'upload']);
        Route::get('/preview/{id}', [MigrasiSiswaController::class, 'preview']);
        Route::post('/proses/{id}', [MigrasiSiswaController::class, 'proses']);
        Route::get('/riwayat', [MigrasiSiswaController::class, 'riwayat']);
        Route::post('/rollback/{id}', [MigrasiSiswaController::class, 'rollback']);
    });
```

**Verifikasi:** Akses semua route — tidak ada 500 error.

---

### Tahap 5: Views (UI)

**File baru:**
1. `resources/views/migrasi/index.blade.php`
   - Instruksi langkah-langkah
   - Tombol download template
   - Pilihan Tahun Ajaran
   - Form upload Excel
   - Checkbox "Include status pembayaran (Sheet 2)"

2. `resources/views/migrasi/preview.blade.php`
   - Ringkasan: total baris, valid, error
   - Tabel error (baris + alasan)
   - Tabel preview data valid (nama, unit, tingkat, kelas)
   - Tombol "Proses Import"

3. `resources/views/migrasi/proses.blade.php`
   - Progress bar
   - Counter: siswa created, pendaftaran created, biaya linked, dll
   - Hasil akhir: berhasil / gagal

4. `resources/views/migrasi/riwayat.blade.php`
   - Tabel histori import (tanggal, file, total, berhasil, gagal, status)
   - Tombol rollback per batch (dengan konfirmasi)

**Modifikasi:**
5. Sidebar navigation — tambah menu "Migrasi Siswa" di group Konfigurasi/Tools

**Verifikasi:** Visual check semua halaman.

---

### Tahap 6: Permission & Finishing

**File baru:**
1. `database/seeders/MigrasiPermissionSeeder.php`
   - Permission: `migrasi-siswa.index`, `migrasi-siswa.import`, `migrasi-siswa.rollback`
   - Assign ke role `super admin`

**Tasks:**
2. Jalankan seeder: `php artisan db:seed --class=MigrasiPermissionSeeder`
3. Tambahkan pengecekan prasyarat sebelum import:
   - TA aktif sudah ada
   - Konfigurasi biaya untuk semua tingkat yang ada di Excel sudah tersedia
   - Kelas yang direferensikan di Excel sudah ada
4. Error handling yang proper
5. Testing end-to-end

---

## Checklist Prasyarat Sebelum Import (Untuk Admin)

Sebelum menjalankan import, admin HARUS memastikan:

- [ ] Tahun Ajaran (`konfigurasi_tahun_ajaran`) sudah dibuat dan status aktif
- [ ] Tahun Ajaran PPDB (`konfigurasi_tahunajaran_ppdb`) sudah dibuat dan status aktif
- [ ] `konfigurasi_biaya` untuk **semua tingkat** di **semua unit** sudah dibuat untuk TA aktif
- [ ] `konfigurasi_biaya_detail` (rincian biaya per tingkat) sudah diisi
- [ ] `jenis_biaya` sudah lengkap
- [ ] `kelas` sudah dibuat untuk semua tingkat di TA aktif (jika mau auto-assign)
- [ ] `unit` sudah lengkap
- [ ] File Excel sudah diisi sesuai format template

---

## Checklist Verifikasi Akhir (Setelah Fitur Selesai)

- [ ] Template Excel bisa di-download dan format-nya benar
- [ ] Upload Excel dengan data valid → preview tampil benar
- [ ] Upload Excel dengan data error → error ditampilkan per baris dengan alasan jelas
- [ ] Proses import: siswa baru terbuat di tabel `siswa`
- [ ] Proses import: pendaftaran terbuat dengan `jenis_pendaftaran = 'Migrasi'`
- [ ] Proses import: `siswa_biaya` ter-link ke `konfigurasi_biaya` yang benar
- [ ] Proses import: NIS dari Excel tersimpan dengan benar
- [ ] NIS kosong di Excel → auto generate oleh sistem
- [ ] Duplikat siswa (nama + tgl lahir): menggunakan `id_siswa` existing, tidak insert baru
- [ ] Data wilayah kosong: tidak menyebabkan error
- [ ] Mutasi (Sheet 2): terbuat di `pembayaran_pendidikan_mutasi` dengan nominal benar
- [ ] Assign kelas: siswa masuk ke `kelas_siswa` yang benar
- [ ] Rollback: semua data dari 1 batch terhapus bersih (siswa baru, pendaftaran, biaya, mutasi, kelas)
- [ ] Rollback: siswa yang sudah existing sebelum import TIDAK ikut terhapus
- [ ] `migrasi_log` tercatat dengan status dan jumlah yang benar
- [ ] Setelah import, siswa muncul di halaman Pendaftaran
- [ ] Setelah import, siswa muncul di halaman Pembayaran Pendidikan
- [ ] Permission hanya untuk super admin
- [ ] Menu sidebar muncul hanya untuk user yang punya permission

---

## Daftar Lengkap File

### File Baru (~14 file)
```
database/migrations/xxxx_add_migrasi_to_jenis_pendaftaran.php
database/migrations/xxxx_create_migrasi_log_table.php
database/migrations/xxxx_create_migrasi_log_detail_table.php
app/Models/MigrasiLog.php
app/Models/MigrasiLogDetail.php
app/Exports/TemplateMigrasiExport.php
app/Imports/MigrasiSiswaImport.php
app/Imports/MigrasiPembayaranImport.php
app/Http/Controllers/MigrasiSiswaController.php
resources/views/migrasi/index.blade.php
resources/views/migrasi/preview.blade.php
resources/views/migrasi/proses.blade.php
resources/views/migrasi/riwayat.blade.php
database/seeders/MigrasiPermissionSeeder.php
```

### File Modifikasi (~2 file)
```
routes/web.php                    → tambah route group migrasi
resources/views/layouts/sidebar   → tambah menu Migrasi Siswa
```

### Package Dependency
```
composer require maatwebsite/excel
```

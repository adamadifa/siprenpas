# Fitur Prestasi Siswa

## Deskripsi
Fitur prestasi siswa memungkinkan admin untuk mengelola prestasi-prestasi yang diraih oleh siswa sekolah Al-Amin. Prestasi ini dapat ditampilkan di website untuk menunjukkan kualitas pendidikan dan prestasi siswa.

## Struktur Database

### Tabel: prestasi_siswa
- `id` - Primary key
- `id_siswa` - Foreign key ke tabel siswa (nullable, untuk input manual)
- `kode_unit` - Foreign key ke tabel unit (nullable, opsional)
- `nama_siswa` - Nama siswa (string, required)
- `prestasi` - Deskripsi prestasi (text, required)
- `tingkat` - Tingkat prestasi (enum: kecamatan, kabupaten, nasional)
- `foto` - Foto prestasi (string, nullable)
- `status` - Status aktif/nonaktif (boolean, default: 1)
- `created_at` - Timestamp pembuatan
- `updated_at` - Timestamp update

## Fitur yang Tersedia

### 1. Daftar Prestasi Siswa
- Menampilkan semua prestasi siswa dalam bentuk tabel
- Informasi: foto, nama siswa, unit, prestasi, tingkat, status
- Aksi: edit, hapus
- Warna badge tingkat: Kecamatan (biru), Kabupaten (kuning), Nasional (merah)
- Badge unit dengan warna biru

### 6. Modal Pencarian Siswa Modern
- Tampilan card modern full width untuk list siswa
- Avatar dengan ikon user untuk setiap siswa
- Informasi lengkap: nama lengkap, NISN, alamat, dan tahun masuk
- Form pencarian dengan input group yang terintegrasi
- Loading state dengan spinner
- Animasi fade-in untuk card
- Border card menggunakan Bootstrap: border-success border-1 (hijau tipis) dengan border-left biru (4px)
- Efek hover yang dinamis (hanya berlaku di modal):
  - Card terangkat dan membesar sedikit (`translateY(-3px) scale(1.02)`)
  - Shadow yang lebih dalam dan berwarna hijau
  - Efek shine/glow yang bergerak dari kiri ke kanan
  - Background gradient yang halus
  - Avatar membesar dan berubah warna menjadi gradient
  - Nama siswa bergerak ke kanan dan berubah warna hijau
  - Text kecil berubah warna menjadi biru
  - CSS menggunakan selector `#modalPilihSiswa` untuk isolasi style
- Card clickable - klik langsung pada card untuk memilih siswa
- Indikator "Klik untuk memilih" di pojok kanan atas
- Modal static - tidak bisa ditutup dengan klik backdrop atau ESC
- Hanya bisa ditutup dengan tombol close (X) atau setelah memilih siswa dari card
- Responsive design untuk semua ukuran layar

### 2. Tambah Prestasi Siswa
- Form untuk menambah prestasi siswa baru
- Pilihan siswa dari database dengan modal pencarian modern (opsional)
- Pilihan unit dari database (opsional)
- Input nama manual jika siswa tidak ada di database
- Modal pencarian siswa dengan tampilan card modern, fitur search dan pagination
- Loading state dengan spinner saat memuat data
- Animasi fade-in untuk card siswa
- Auto-fill nama siswa ketika memilih dari modal
- Upload foto (opsional)
- Validasi input

### 3. Edit Prestasi Siswa
- Form untuk mengedit prestasi siswa yang ada
- Preview foto saat ini
- Upload foto baru (opsional)
- Pilihan siswa dari database dengan modal pencarian modern (opsional)
- Modal pencarian siswa dengan tampilan card modern, fitur search dan pagination
- Loading state dengan spinner saat memuat data
- Animasi fade-in untuk card siswa
- Auto-fill nama siswa ketika memilih dari modal

### 4. Hapus Prestasi Siswa
- Konfirmasi sebelum menghapus
- Hapus foto dari storage jika ada

### 5. Detail Prestasi Siswa
- Menampilkan detail lengkap prestasi siswa
- Preview foto dalam ukuran besar
- Informasi apakah siswa terdaftar di database atau input manual

## Permission yang Diperlukan

- `prestasi-siswa.index` - Melihat daftar prestasi siswa
- `prestasi-siswa.create` - Menambah prestasi siswa
- `prestasi-siswa.edit` - Mengedit prestasi siswa
- `prestasi-siswa.delete` - Menghapus prestasi siswa

## File yang Dibuat

### Migration
- `database/migrations/2025_08_29_100127_create_prestasi_siswa_table.php`

### Model
- `app/Models/PrestasiSiswa.php`

### Controller
- `app/Http/Controllers/PrestasiSiswaController.php`

### Views
- `resources/views/website/prestasi-siswa/index.blade.php`
- `resources/views/website/prestasi-siswa/create.blade.php`
- `resources/views/website/prestasi-siswa/edit.blade.php`
- `resources/views/website/prestasi-siswa/show.blade.php`
- `resources/views/website/prestasi-siswa/partials/siswa-table.blade.php`

### Seeders
- `database/seeders/PrestasiSiswaSeeder.php`
- `database/seeders/PrestasiSiswaPermissionSeeder.php`

### Routes
- Ditambahkan ke `routes/web.php`

### Sidebar
- Ditambahkan menu Prestasi Siswa di sidebar Website

## Cara Penggunaan

1. **Akses Menu**: Login sebagai admin dan akses menu Website > Prestasi Siswa
2. **Tambah Prestasi**: 
   - Klik tombol "Tambah Prestasi Siswa"
   - Klik tombol "Cari Siswa" untuk memilih dari database (opsional) atau kosongkan untuk input manual
   - Isi nama siswa, prestasi, tingkat, unit, dan status
   - Upload foto jika ada
3. **Edit Prestasi**: Klik ikon edit pada baris prestasi yang ingin diedit
4. **Hapus Prestasi**: Klik ikon hapus dan konfirmasi penghapusan

## Data Sampel

Seeder telah menyediakan 8 data sampel prestasi siswa:
1. Ahmad Fadli - Juara 1 Lomba Matematika Tingkat Kecamatan
2. Siti Nurhaliza - Juara 2 Lomba Membaca Puisi Tingkat Kabupaten
3. Muhammad Rizki - Juara 1 Olimpiade Sains Nasional (OSN) Tingkat Nasional
4. Nurul Hidayati - Juara 3 Lomba Menulis Cerpen Tingkat Kecamatan
5. Budi Santoso - Juara 1 Lomba Robotik Tingkat Kabupaten
6. Dewi Sartika - Juara 2 Lomba Bahasa Inggris Tingkat Nasional
7. Rizki Pratama - Juara 1 Lomba Menggambar Tingkat Kecamatan
8. Anisa Putri - Juara 3 Lomba Cerdas Cermat Tingkat Kabupaten

## Storage

Foto prestasi siswa disimpan di:
- Path: `storage/app/public/prestasi-siswa/`
- URL: `/storage/prestasi-siswa/[nama_file]`

## Tingkat Prestasi

- **Kecamatan** - Badge biru
- **Kabupaten** - Badge kuning  
- **Nasional** - Badge merah

## Status

- `1` = Aktif (akan ditampilkan di website)
- `0` = Nonaktif (tidak ditampilkan di website)

## Relasi dengan Tabel Siswa dan Unit

- Jika `id_siswa` diisi, akan terhubung ke tabel siswa
- Jika `id_siswa` kosong, nama siswa diinput manual
- Foreign key: `id_siswa` → `siswa.id_siswa`
- Jika `kode_unit` diisi, akan terhubung ke tabel unit
- Foreign key: `kode_unit` → `unit.kode_unit`

## Catatan

- Foto yang diupload akan otomatis diresize dan disimpan dengan nama unik
- Saat menghapus prestasi, foto juga akan dihapus dari storage
- Semua operasi CRUD dilengkapi dengan validasi dan pesan feedback
- Auto-fill nama siswa ketika memilih dari dropdown siswa
- Mendukung input manual untuk siswa yang tidak terdaftar di database

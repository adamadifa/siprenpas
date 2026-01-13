# Fitur Hubungkan Siswa dengan Anggota - Dokumentasi

Fitur ini memungkinkan admin untuk menghubungkan data siswa dengan anggota koperasi melalui halaman `/anggota`.

## Fitur yang Tersedia

### 1. **Tampilan Tabel Anggota**
- Kolom baru "Siswa Terkait" menampilkan siswa yang sudah terhubung
- Badge hijau untuk setiap siswa yang terhubung
- Tombol "Hubungkan dengan Siswa" (ikon user-plus) di kolom aksi

### 2. **Modal Hubungkan Siswa**
- Dropdown untuk memilih siswa yang akan dihubungkan
- Daftar siswa yang sudah terhubung dengan tombol hapus
- Validasi untuk mencegah duplikasi relasi

### 3. **Fungsi CRUD Relasi**
- **Create**: Menghubungkan siswa baru dengan anggota
- **Read**: Menampilkan daftar siswa yang terhubung
- **Delete**: Menghapus hubungan siswa dengan anggota

## Struktur File yang Dimodifikasi

### 1. **View** (`resources/views/koperasi/anggota/index.blade.php`)
```php
// Kolom baru di tabel
<th>Siswa Terkait</th>

// Data siswa yang terhubung
@if($d->siswa->count() > 0)
    @foreach($d->siswa as $siswa)
        <span class="badge bg-success me-1">{{ $siswa->nama_lengkap }}</span>
    @endforeach
@else
    <span class="text-muted">Belum ada siswa</span>
@endif

// Tombol hubungkan siswa
<a href="#" class="btnHubungkanSiswa me-1" 
   no_anggota="{{ Crypt::encrypt($d->no_anggota) }}">
    <i class="ti ti-user-plus text-warning"></i>
</a>
```

### 2. **Controller** (`app/Http/Controllers/AnggotaController.php`)
```php
// Method baru yang ditambahkan:
- getSiswaOptions()           // Get daftar siswa untuk dropdown
- getSiswaTerhubung()         // Get siswa yang sudah terhubung
- hubungkanSiswa()            // Hubungkan siswa dengan anggota
- hapusHubunganSiswa()        // Hapus hubungan siswa
```

### 3. **Routes** (`routes/web.php`)
```php
// Routes baru yang ditambahkan:
Route::get('/anggota/get-siswa-options', 'getSiswaOptions');
Route::get('/anggota/get-siswa-terhubung/{no_anggota}', 'getSiswaTerhubung');
Route::post('/anggota/hubungkan-siswa', 'hubungkanSiswa');
Route::post('/anggota/hapus-hubungan-siswa', 'hapusHubunganSiswa');
```

## Cara Penggunaan

### 1. **Mengakses Fitur**
1. Buka halaman `/anggota`
2. Klik tombol ikon user-plus (🔄) di kolom aksi
3. Modal "Hubungkan Siswa dengan Anggota" akan terbuka

### 2. **Menghubungkan Siswa**
1. Pilih siswa dari dropdown "Pilih Siswa"
2. Klik tombol "Simpan"
3. Siswa akan muncul di daftar "Siswa yang Sudah Terhubung"
4. Halaman akan reload untuk menampilkan perubahan

### 3. **Menghapus Hubungan**
1. Di modal, klik tombol "Hapus" di samping nama siswa
2. Konfirmasi penghapusan
3. Hubungan akan dihapus dan halaman akan reload

## API Endpoints

### 1. **GET** `/anggota/get-siswa-options`
**Response:**
```json
[
    {
        "id_siswa": "2025001",
        "nama_lengkap": "FAYRA NATHANIA GUNAWAN"
    },
    {
        "id_siswa": "2025002", 
        "nama_lengkap": "SISWA LAIN"
    }
]
```

### 2. **GET** `/anggota/get-siswa-terhubung/{no_anggota}`
**Response:**
```json
[
    {
        "id_siswa": "2025001",
        "nama_lengkap": "FAYRA NATHANIA GUNAWAN"
    }
]
```

### 3. **POST** `/anggota/hubungkan-siswa`
**Request:**
```json
{
    "no_anggota": "encrypted_no_anggota",
    "id_siswa": "2025001"
}
```
**Response:**
```json
{
    "success": true,
    "message": "Siswa berhasil dihubungkan"
}
```

### 4. **POST** `/anggota/hapus-hubungan-siswa`
**Request:**
```json
{
    "no_anggota": "encrypted_no_anggota",
    "id_siswa": "2025001"
}
```
**Response:**
```json
{
    "success": true,
    "message": "Hubungan berhasil dihapus"
}
```

## Validasi dan Error Handling

### 1. **Validasi Input**
- Siswa harus dipilih sebelum menyimpan
- Relasi duplikat dicegah dengan pengecekan database

### 2. **Error Messages**
- "Pilih siswa terlebih dahulu" - Jika dropdown kosong
- "Siswa sudah terhubung dengan anggota ini" - Jika relasi sudah ada
- "Error: [pesan error]" - Untuk error lainnya

### 3. **Success Messages**
- "Siswa berhasil dihubungkan" - Setelah berhasil menyimpan
- "Hubungan berhasil dihapus" - Setelah berhasil menghapus

## Keuntungan

1. **User-Friendly**: Interface yang mudah digunakan dengan modal dan dropdown
2. **Real-time**: Perubahan langsung terlihat tanpa refresh manual
3. **Validasi**: Mencegah duplikasi dan error
4. **Responsive**: Bekerja di desktop dan mobile
5. **Integrated**: Terintegrasi dengan sistem koperasi yang ada

## Dependencies

- **Tabel**: `siswa_anggota` (pivot table)
- **Model**: `SiswaAnggota`, `Siswa`, `Anggota`
- **JavaScript**: jQuery untuk AJAX
- **CSS**: Bootstrap untuk styling modal dan badge

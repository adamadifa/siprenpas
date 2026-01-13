# Fitur Testimoni

## Deskripsi
Fitur testimoni memungkinkan admin untuk mengelola testimoni dari berbagai pihak tentang sekolah Al-Amin. Testimoni ini dapat ditampilkan di website untuk meningkatkan kepercayaan masyarakat terhadap sekolah.

## Struktur Database

### Tabel: testimonials
- `id` - Primary key
- `nama` - Nama pemberi testimoni (string, required)
- `testimoni` - Isi testimoni (text, required)
- `foto` - Foto pemberi testimoni (string, nullable)
- `status` - Status aktif/nonaktif (boolean, default: 1)
- `created_at` - Timestamp pembuatan
- `updated_at` - Timestamp update

## Fitur yang Tersedia

### 1. Daftar Testimoni
- Menampilkan semua testimoni dalam bentuk tabel
- Informasi: foto, nama, testimoni, status
- Aksi: edit, hapus

### 2. Tambah Testimoni
- Form untuk menambah testimoni baru
- Upload foto (opsional)
- Validasi input

### 3. Edit Testimoni
- Form untuk mengedit testimoni yang ada
- Preview foto saat ini
- Upload foto baru (opsional)

### 4. Hapus Testimoni
- Konfirmasi sebelum menghapus
- Hapus foto dari storage jika ada

### 5. Detail Testimoni
- Menampilkan detail lengkap testimoni
- Preview foto dalam ukuran besar

## Permission yang Diperlukan

- `testimonials.index` - Melihat daftar testimoni
- `testimonials.create` - Menambah testimoni
- `testimonials.edit` - Mengedit testimoni
- `testimonials.delete` - Menghapus testimoni

## File yang Dibuat

### Migration
- `database/migrations/2025_08_29_084543_create_testimonials_table.php`

### Model
- `app/Models/Testimonial.php`

### Controller
- `app/Http/Controllers/TestimonialController.php`

### Views
- `resources/views/website/testimonials/index.blade.php`
- `resources/views/website/testimonials/create.blade.php`
- `resources/views/website/testimonials/edit.blade.php`
- `resources/views/website/testimonials/show.blade.php`

### Seeders
- `database/seeders/TestimonialSeeder.php`
- `database/seeders/TestimonialPermissionSeeder.php`

### Routes
- Ditambahkan ke `routes/web.php`

### Sidebar
- Ditambahkan menu Testimoni di sidebar Website

## Cara Penggunaan

1. **Akses Menu**: Login sebagai admin dan akses menu Website > Testimoni
2. **Tambah Testimoni**: Klik tombol "Tambah Testimoni" dan isi form
3. **Edit Testimoni**: Klik ikon edit pada baris testimoni yang ingin diedit
4. **Hapus Testimoni**: Klik ikon hapus dan konfirmasi penghapusan

## Data Sampel

Seeder telah menyediakan 5 data sampel testimoni:
1. Ahmad Rizki - Kepala Sekolah
2. Siti Nurhaliza - Wali Murid
3. Dr. Muhammad Fadli - Dosen Universitas
4. Nurul Hidayati - Guru
5. Budi Santoso - Pengusaha

## Storage

Foto testimoni disimpan di:
- Path: `storage/app/public/testimonials/`
- URL: `/storage/testimonials/[nama_file]`

## Status

- `1` = Aktif (akan ditampilkan di website)
- `0` = Nonaktif (tidak ditampilkan di website)

## Catatan

- Foto yang diupload akan otomatis diresize dan disimpan dengan nama unik
- Saat menghapus testimoni, foto juga akan dihapus dari storage
- Semua operasi CRUD dilengkapi dengan validasi dan pesan feedback

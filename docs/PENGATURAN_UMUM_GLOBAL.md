# Pengaturan Umum - Akses Global

Data pengaturan umum sekarang dapat diakses secara global di semua view tanpa perlu mengambil data di setiap controller.

## Cara Menggunakan

### 1. Akses Data di View
```php
@if($pengaturan)
    <h1>{{ $pengaturan->nama_sekolah }}</h1>
    <p>{{ $pengaturan->alamat_sekolah }}</p>
    <img src="{{ asset('storage/' . $pengaturan->logo) }}" alt="Logo">
@else
    <!-- Fallback jika belum ada pengaturan -->
    <h1>Nama Sekolah Default</h1>
@endif
```

### 2. Data yang Tersedia
- `$pengaturan->nama_sekolah` - Nama sekolah
- `$pengaturan->alamat_sekolah` - Alamat sekolah  
- `$pengaturan->logo` - Path logo sekolah
- `$pengaturan->telepon` - Nomor telepon
- `$pengaturan->email` - Email sekolah
- `$pengaturan->website` - Website sekolah

### 3. Contoh Penggunaan

#### Di Title Page
```php
<title>@yield('titlepage')@if($pengaturan) - {{ $pengaturan->nama_sekolah }}@endif</title>
```

#### Di Meta Description
```php
<meta name="description" content="@if($pengaturan){{ $pengaturan->nama_sekolah }} - {{ $pengaturan->alamat_sekolah }}@else{{ config('app.name') }}@endif" />
```

#### Di Dashboard
```php
@if($pengaturan)
    <div class="school-info">
        <i class="ti ti-building me-1"></i>{{ $pengaturan->nama_sekolah }}
    </div>
@endif
```

#### Di Footer
```php
@if($pengaturan)
    © {{ date('Y') }}, {{ $pengaturan->nama_sekolah }} - {{ $pengaturan->alamat_sekolah }}
@else
    © {{ date('Y') }}, Default Company
@endif
```

## Implementasi

Data pengaturan umum diakses melalui:
- **View Composer**: `App\View\Composers\PengaturanUmumComposer`
- **Service Provider**: `App\Providers\AppServiceProvider`
- **Scope**: Semua view (`*`)

## Keuntungan

1. **Tidak perlu mengambil data di setiap controller**
2. **Konsisten di semua halaman**
3. **Mudah digunakan di view manapun**
4. **Otomatis tersedia di semua template**
5. **Performance lebih baik** (caching otomatis)

## Catatan

- Data `$pengaturan` akan `null` jika belum ada data di database
- Selalu gunakan `@if($pengaturan)` untuk mengecek keberadaan data
- Logo menggunakan path `storage/` jadi gunakan `asset('storage/' . $pengaturan->logo)`


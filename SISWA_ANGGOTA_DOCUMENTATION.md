# Tabel Siswa Anggota - Dokumentasi

Tabel `siswa_anggota` adalah tabel pivot yang menghubungkan siswa dengan anggota koperasi, memungkinkan seorang siswa menjadi anggota koperasi.

## Struktur Tabel

```sql
CREATE TABLE siswa_anggota (
    id_siswa CHAR(7) NOT NULL,
    no_anggota CHAR(10) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    PRIMARY KEY (id_siswa, no_anggota),
    FOREIGN KEY (id_siswa) REFERENCES siswa(id_siswa) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (no_anggota) REFERENCES koperasi_anggota(no_anggota) ON DELETE RESTRICT ON UPDATE CASCADE
);
```

## Model dan Relasi

### 1. Model SiswaAnggota
```php
class SiswaAnggota extends Model
{
    protected $table = 'siswa_anggota';
    protected $primaryKey = ['id_siswa', 'no_anggota'];
    public $incrementing = false;

    // Relasi ke Siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa');
    }

    // Relasi ke Anggota
    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'no_anggota', 'no_anggota');
    }
}
```

### 2. Model Siswa (Updated)
```php
class Siswa extends Model
{
    // Relasi many-to-many ke anggota koperasi
    public function anggotaKoperasi()
    {
        return $this->belongsToMany(Anggota::class, 'siswa_anggota', 'id_siswa', 'no_anggota');
    }

    // Relasi ke tabel pivot
    public function siswaAnggota()
    {
        return $this->hasMany(SiswaAnggota::class, 'id_siswa', 'id_siswa');
    }
}
```

### 3. Model Anggota (Updated)
```php
class Anggota extends Model
{
    // Relasi many-to-many ke siswa
    public function siswa()
    {
        return $this->belongsToMany(Siswa::class, 'siswa_anggota', 'no_anggota', 'id_siswa');
    }

    // Relasi ke tabel pivot
    public function siswaAnggota()
    {
        return $this->hasMany(SiswaAnggota::class, 'no_anggota', 'no_anggota');
    }
}
```

## Cara Penggunaan

### 1. Membuat Relasi Siswa dengan Anggota
```php
// Method 1: Menggunakan model SiswaAnggota
$siswaAnggota = SiswaAnggota::create([
    'id_siswa' => '2025001',
    'no_anggota' => '2112-00001'
]);

// Method 2: Menggunakan relasi many-to-many
$siswa = Siswa::find('2025001');
$anggota = Anggota::find('2112-00001');
$siswa->anggotaKoperasi()->attach($anggota->no_anggota);
```

### 2. Mengambil Data Siswa yang Menjadi Anggota
```php
$siswa = Siswa::with('anggotaKoperasi')->find('2025001');
foreach ($siswa->anggotaKoperasi as $anggota) {
    echo $anggota->nama_lengkap . ' - ' . $anggota->no_anggota;
}
```

### 3. Mengambil Data Anggota yang Terkait dengan Siswa
```php
$anggota = Anggota::with('siswa')->find('2112-00001');
foreach ($anggota->siswa as $siswa) {
    echo $siswa->nama_lengkap . ' - ' . $siswa->id_siswa;
}
```

### 4. Menghapus Relasi
```php
// Method 1: Menggunakan detach
$siswa = Siswa::find('2025001');
$siswa->anggotaKoperasi()->detach('2112-00001');

// Method 2: Menghapus langsung dari tabel pivot
SiswaAnggota::where('id_siswa', '2025001')
    ->where('no_anggota', '2112-00001')
    ->delete();
```

### 5. Query Lanjutan
```php
// Cari siswa yang menjadi anggota koperasi
$siswaAnggota = Siswa::whereHas('anggotaKoperasi')->get();

// Cari anggota yang terkait dengan siswa tertentu
$anggotaSiswa = Anggota::whereHas('siswa', function($query) {
    $query->where('id_siswa', '2025001');
})->get();

// Hitung jumlah siswa yang menjadi anggota
$jumlahSiswaAnggota = Siswa::whereHas('anggotaKoperasi')->count();
```

## Keuntungan

1. **Fleksibilitas**: Seorang siswa bisa menjadi anggota koperasi atau tidak
2. **Data Integrity**: Foreign key constraints memastikan data konsisten
3. **Relasi Many-to-Many**: Satu siswa bisa terkait dengan beberapa anggota (jika diperlukan)
4. **Audit Trail**: Timestamps untuk tracking kapan relasi dibuat/diupdate
5. **Performance**: Composite primary key untuk query yang efisien

## Use Cases

- **Siswa yang menjadi anggota koperasi** dapat melakukan transaksi simpanan, tabungan, atau pembiayaan
- **Tracking keanggotaan** siswa di koperasi
- **Laporan keanggotaan** siswa
- **Manajemen transaksi** koperasi berdasarkan status keanggotaan siswa

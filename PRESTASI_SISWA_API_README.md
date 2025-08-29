# API Prestasi Siswa

Dokumentasi API untuk mengakses data prestasi siswa secara publik tanpa autentikasi.

## Base URL
```
http://localhost:8000/api/public/prestasi-siswa
```

## Endpoints

### 1. Mendapatkan Daftar Prestasi Siswa

**GET** `/api/public/prestasi-siswa`

Mengambil semua data prestasi siswa yang aktif.

#### Query Parameters
- `limit` (optional): Jumlah data yang akan ditampilkan (default: 10)
- `tingkat` (optional): Filter berdasarkan tingkat prestasi (`kecamatan`, `kabupaten`, `nasional`)
- `unit` (optional): Filter berdasarkan kode unit

#### Contoh Request
```bash
# Semua prestasi siswa (limit 10)
GET /api/public/prestasi-siswa

# Prestasi tingkat nasional
GET /api/public/prestasi-siswa?tingkat=nasional

# Prestasi dari unit tertentu
GET /api/public/prestasi-siswa?unit=001

# Kombinasi filter
GET /api/public/prestasi-siswa?tingkat=kabupaten&limit=5&unit=002
```

#### Response Success (200)
```json
{
    "success": true,
    "message": "Data prestasi siswa berhasil diambil",
    "data": [
        {
            "id": 1,
            "nama_siswa": "Ahmad Fadli",
            "prestasi": "Juara 1 Lomba Matematika",
            "tingkat": "kecamatan",
            "foto": "prestasi_1.jpg",
            "foto_url": "http://localhost:8000/storage/prestasi-siswa/prestasi_1.jpg",
            "unit": {
                "kode_unit": "001",
                "nama_unit": "SD Al Amin 1"
            },
            "created_at": "2024-01-15T10:30:00.000000Z",
            "updated_at": "2024-01-15T10:30:00.000000Z"
        }
    ]
}
```

### 2. Mendapatkan Detail Prestasi Siswa

**GET** `/api/public/prestasi-siswa/{id}`

Mengambil detail prestasi siswa berdasarkan ID.

#### Path Parameters
- `id`: ID prestasi siswa (integer)

#### Contoh Request
```bash
GET /api/public/prestasi-siswa/1
```

#### Response Success (200)
```json
{
    "success": true,
    "message": "Detail prestasi siswa berhasil diambil",
    "data": {
        "id": 1,
        "nama_siswa": "Ahmad Fadli",
        "prestasi": "Juara 1 Lomba Matematika",
        "tingkat": "kecamatan",
        "foto": "prestasi_1.jpg",
        "foto_url": "http://localhost:8000/storage/prestasi-siswa/prestasi_1.jpg",
        "unit": {
            "kode_unit": "001",
            "nama_unit": "SD Al Amin 1"
        },
        "created_at": "2024-01-15T10:30:00.000000Z",
        "updated_at": "2024-01-15T10:30:00.000000Z"
    }
}
```

#### Response Error (404)
```json
{
    "success": false,
    "message": "Prestasi siswa tidak ditemukan"
}
```

### 3. Mendapatkan Prestasi Siswa Secara Acak

**GET** `/api/public/prestasi-siswa/random/{limit}`

Mengambil data prestasi siswa secara acak dengan limit tertentu.

#### Path Parameters
- `limit` (optional): Jumlah data yang akan ditampilkan (default: 3)

#### Query Parameters
- `tingkat` (optional): Filter berdasarkan tingkat prestasi (`kecamatan`, `kabupaten`, `nasional`)

#### Contoh Request
```bash
# 3 prestasi acak
GET /api/public/prestasi-siswa/random/3

# 5 prestasi nasional acak
GET /api/public/prestasi-siswa/random/5?tingkat=nasional
```

#### Response Success (200)
```json
{
    "success": true,
    "message": "Data prestasi siswa acak berhasil diambil",
    "data": [
        {
            "id": 3,
            "nama_siswa": "Muhammad Rizki",
            "prestasi": "Juara 1 Olimpiade Sains Nasional (OSN)",
            "tingkat": "nasional",
            "foto": "prestasi_3.jpg",
            "foto_url": "http://localhost:8000/storage/prestasi-siswa/prestasi_3.jpg",
            "unit": {
                "kode_unit": "002",
                "nama_unit": "SD Al Amin 2"
            }
        }
    ]
}
```

## Error Responses

### Server Error (500)
```json
{
    "success": false,
    "message": "Terjadi kesalahan server: [error message]"
}
```

## Data Structure

### Prestasi Siswa Object
```json
{
    "id": "integer",
    "nama_siswa": "string",
    "prestasi": "string",
    "tingkat": "string (kecamatan|kabupaten|nasional)",
    "foto": "string|null",
    "foto_url": "string|null",
    "unit": {
        "kode_unit": "string",
        "nama_unit": "string"
    },
    "created_at": "datetime",
    "updated_at": "datetime"
}
```

## Contoh Penggunaan

### JavaScript (Fetch API)
```javascript
// Mendapatkan semua prestasi siswa
fetch('/api/public/prestasi-siswa')
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Prestasi siswa:', data.data);
        }
    });

// Mendapatkan prestasi tingkat nasional
fetch('/api/public/prestasi-siswa?tingkat=nasional&limit=5')
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Prestasi nasional:', data.data);
        }
    });

// Mendapatkan detail prestasi
fetch('/api/public/prestasi-siswa/1')
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Detail prestasi:', data.data);
        }
    });
```

### PHP (cURL)
```php
// Mendapatkan semua prestasi siswa
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost:8000/api/public/prestasi-siswa');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);
if ($data['success']) {
    print_r($data['data']);
}
```

### Python (requests)
```python
import requests

# Mendapatkan prestasi acak
response = requests.get('http://localhost:8000/api/public/prestasi-siswa/random/3')
data = response.json()

if data['success']:
    for prestasi in data['data']:
        print(f"Nama: {prestasi['nama_siswa']}")
        print(f"Prestasi: {prestasi['prestasi']}")
        print(f"Tingkat: {prestasi['tingkat']}")
        print("---")
```

## Catatan Penting

1. **Tidak Memerlukan Autentikasi**: Semua endpoint bersifat publik dan tidak memerlukan token autentikasi.

2. **Hanya Data Aktif**: API hanya mengembalikan data prestasi siswa dengan status aktif (status = 1).

3. **Foto URL**: Field `foto_url` berisi URL lengkap untuk mengakses foto prestasi.

4. **Filter Tingkat**: Nilai yang valid untuk filter `tingkat` adalah `kecamatan`, `kabupaten`, dan `nasional`.

5. **Unit Filter**: Filter `unit` menggunakan kode unit (misal: "001", "002", dll).

6. **Pagination**: Endpoint utama menggunakan limit untuk membatasi jumlah data yang dikembalikan.

## Swagger Documentation

Dokumentasi lengkap dengan Swagger UI tersedia di:
```
http://localhost:8000/api/documentation
```

## File yang Dibuat

- `app/Http/Controllers/Api/PrestasiSiswaController.php` - Controller API
- Routes ditambahkan ke `routes/api.php`
- Dokumentasi Swagger otomatis ter-generate

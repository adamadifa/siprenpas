# API Dokumentasi Pengumuman

## Overview
API ini menyediakan endpoint untuk mengelola data pengumuman. API ini menggunakan format JSON untuk request dan response.

## Base URL
```
http://localhost:8000/api
```

## Endpoints

### 1. Mengambil 5 Pengumuman Terbaru

**GET** `/pengumuman/terbaru`

Mengambil 5 pengumuman terbaru berdasarkan tanggal.

#### Response
```json
{
    "success": true,
    "message": "Data pengumuman terbaru berhasil diambil",
    "data": [
        {
            "id": 1,
            "judul": "Pembayaran UKT",
            "isi": "Segera lakukan pembayaran UKT semester ganjil.",
            "tanggal": "26 Jun 2025",
            "kategori": "keuangan",
            "lokasi": "Bank Syariah Mandiri, Kampus Pusat"
        },
        {
            "id": 2,
            "judul": "Jadwal Ujian",
            "isi": "Ujian tengah semester akan dilaksanakan minggu depan.",
            "tanggal": "25 Jun 2025",
            "kategori": "akademik",
            "lokasi": "Ruang Kelas"
        }
    ]
}
```

### 2. Mengambil Semua Pengumuman (dengan Pagination)

**GET** `/pengumuman`

Mengambil semua pengumuman dengan pagination dan filter.

#### Query Parameters
- `page` (optional): Nomor halaman (default: 1)
- `per_page` (optional): Jumlah data per halaman (default: 10)
- `kategori_id` (optional): Filter berdasarkan ID kategori

#### Example Request
```
GET /api/pengumuman?page=1&per_page=5&kategori_id=1
```

#### Response
```json
{
    "success": true,
    "message": "Data pengumuman berhasil diambil",
    "data": [
        {
            "id": 1,
            "judul": "Pembayaran UKT",
            "isi": "Segera lakukan pembayaran UKT semester ganjil.",
            "tanggal": "26 Jun 2025",
            "kategori": "keuangan",
            "lokasi": "Bank Syariah Mandiri, Kampus Pusat"
        }
    ],
    "pagination": {
        "current_page": 1,
        "per_page": 5,
        "total": 25,
        "last_page": 5
    }
}
```

### 3. Mengambil Detail Pengumuman

**GET** `/pengumuman/{id}`

Mengambil detail pengumuman berdasarkan ID.

#### Path Parameters
- `id`: ID pengumuman (required)

#### Example Request
```
GET /api/pengumuman/1
```

#### Response
```json
{
    "success": true,
    "message": "Detail pengumuman berhasil diambil",
    "data": {
        "id": 1,
        "judul": "Pembayaran UKT",
        "isi": "Segera lakukan pembayaran UKT semester ganjil.",
        "tanggal": "26 Jun 2025",
        "kategori": "keuangan",
        "lokasi": "Bank Syariah Mandiri, Kampus Pusat"
    }
}
```

#### Error Response (404)
```json
{
    "success": false,
    "message": "Pengumuman tidak ditemukan"
}
```

## Error Handling

Semua endpoint mengembalikan response dengan format yang konsisten:

### Success Response
```json
{
    "success": true,
    "message": "Pesan sukses",
    "data": {}
}
```

### Error Response
```json
{
    "success": false,
    "message": "Pesan error"
}
```

## HTTP Status Codes

- `200`: Success
- `404`: Not Found
- `500`: Internal Server Error

## Data Format

### Pengumuman Object
```json
{
    "id": 1,
    "judul": "Pembayaran UKT",
    "isi": "Segera lakukan pembayaran UKT semester ganjil.",
    "tanggal": "26 Jun 2025",
    "kategori": "keuangan",
    "lokasi": "Bank Syariah Mandiri, Kampus Pusat"
}
```

## Swagger Documentation

Untuk dokumentasi interaktif yang lebih lengkap, Anda dapat mengakses Swagger UI di:

```
http://localhost:8000/api/documentation
```

## Testing API

### Menggunakan cURL

1. **Mengambil 5 pengumuman terbaru:**
```bash
curl -X GET "http://localhost:8000/api/pengumuman/terbaru"
```

2. **Mengambil semua pengumuman dengan pagination:**
```bash
curl -X GET "http://localhost:8000/api/pengumuman?page=1&per_page=5"
```

3. **Mengambil detail pengumuman:**
```bash
curl -X GET "http://localhost:8000/api/pengumuman/1"
```

### Menggunakan Postman

1. Import collection ke Postman
2. Set base URL: `http://localhost:8000/api`
3. Test endpoint sesuai kebutuhan

## Notes

- Semua tanggal dikembalikan dalam format "d M Y" (contoh: "26 Jun 2025")
- Field `lokasi` akan mengembalikan "-" jika kosong
- API ini tidak memerlukan authentication untuk saat ini
- Response selalu dalam format JSON dengan encoding UTF-8

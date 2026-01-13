# Dokumentasi API: Get List Pengumuman

## Endpoint
`GET /api/pengumuman`

## Deskripsi
Endpoint ini digunakan untuk mengambil daftar pengumuman secara lengkap dengan dukungan pagination dan filter kategori.

## Authentication
Endpoint ini publik (jika diakses melalui `public` prefix) atau memerlukan token tergantung konfigurasi route (dalam kode yang diperiksa, route ini berada dalam group `pengumuman` tanpa middleware auth eksplisit di file routes, namun umumnya API backend seperti ini dilindungi atau bisa juga public, pastikan sesuai implementasi security. Berdasarkan context file, route group `pengumuman` di lines 187 tidak di dalam `auth:sanctum` group utama).

**Headers:**
```
Accept: application/json
```

## Parameters

### Query Parameters
| Parameter | Tipe | Required | Default | Deskripsi |
| :--- | :--- | :--- | :--- | :--- |
| `page` | Integer | No | 1 | Nomor halaman untuk pagination. |
| `per_page` | Integer | No | 10 | Jumlah data yang ditampilkan per halaman. |
| `kategori_id` | Integer | No | - | ID Kategori untuk memfilter pengumuman berdasarkan kategori tertentu. |

## Contoh Request
```http
GET /api/pengumuman?page=1&per_page=5&kategori_id=2
```

## Response Structure

### Success Response (200 OK)

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
        },
        {
            "id": 2,
            "judul": "Libur Semester",
            "isi": "Libur semester dimulai tanggal 1 Juli.",
            "tanggal": "20 Jun 2025",
            "kategori": "akademik",
            "lokasi": "-"
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

#### Penjelasan Field Response:

- `success`: Status keberhasilan request (boolean).
- `message`: Pesan respon dari server (string).
- `data`: Array object berisi daftar pengumuman.
    - `id`: ID Pengumuman.
    - `judul`: Judul pengumuman.
    - `isi`: Isi/konten pengumuman.
    - `tanggal`: Tanggal pengumuman (diformat d M Y).
    - `kategori`: Nama kategori pengumuman.
    - `lokasi`: Lokasi terkait pengumuman (jika ada).
- `pagination`: Informasi pagination.
    - `current_page`: Halaman saat ini.
    - `per_page`: Jumlah data per halaman.
    - `total`: Total seluruh data pengumuman.
    - `last_page`: Halaman terakhir yang tersedia.

### Error Response

#### 500 Internal Server Error
Jika terjadi kesalahan pada server.
```json
{
    "success": false,
    "message": "Terjadi kesalahan pada server: [Error Details]"
}
```

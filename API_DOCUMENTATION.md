# API Dokumentasi Siprenpas

## Overview
API ini menyediakan endpoint untuk mengelola data aplikasi Siprenpas. API ini menggunakan format JSON untuk request dan response.

## Authentication
API menggunakan Laravel Sanctum untuk autentikasi. Untuk endpoint yang memerlukan autentikasi, tambahkan header:
```
Authorization: Bearer {token}
```

## Base URL
```
http://localhost:8000/api
```

## Base URL
```
http://localhost:8000/api
```

## Endpoints

### Authentication

#### 1. Login User
**POST** `/auth/login`

Login user dengan email dan password.

#### Request Body
```json
{
    "email": "user@email.com",
    "password": "password"
}
```

#### Response
```json
{
    "success": true,
    "message": "Login berhasil",
    "data": {
        "user": {
            "id": 1,
            "name": "User Name",
            "email": "user@email.com",
            "username": "username"
        },
        "token": "1|abc123..."
    }
}
```

#### 2. Register Orang Tua
**POST** `/auth/register-orangtua`

Register akun untuk orang tua siswa.

#### Request Body
```json
{
    "name": "Nama Orang Tua",
    "email": "ortu@email.com",
    "password": "password",
    "password_confirmation": "password",
    "nik": "1234567890123456"
}
```

#### 3. Register Siswa
**POST** `/auth/register-siswa`

Register akun untuk siswa baru.

#### Request Body
```json
{
    "name": "Ahmad Fauzi",
    "email": "siswa@email.com",
    "password": "password123",
    "password_confirmation": "password123",
    "jenis_kelamin": "L",
    "no_hp": "08123456789",
    "kode_unit": "U01"
}
```

#### 4. Ubah Password
**POST** `/auth/change-password`

Ubah password user yang sedang login.

**Authentication Required:** Bearer Token

#### Request Body
```json
{
    "current_password": "password_lama",
    "new_password": "password_baru",
    "new_password_confirmation": "password_baru"
}
```

#### Response Success
```json
{
    "success": true,
    "message": "Password berhasil diubah"
}
```

#### Response Error (401 - Password salah)
```json
{
    "success": false,
    "message": "Password saat ini salah"
}
```

#### Response Error (422 - Validasi gagal)
```json
{
    "message": "The given data was invalid.",
    "errors": {
        "current_password": ["Password saat ini wajib diisi"],
        "new_password": ["Password baru wajib diisi", "Password baru minimal 6 karakter"],
        "new_password_confirmation": ["Konfirmasi password baru tidak cocok"]
    }
}
```

### Pengumuman

#### 1. Mengambil 5 Pengumuman Terbaru

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

1. **Login user:**
```bash
curl -X POST "http://localhost:8000/api/auth/login" \
  -H "Content-Type: application/json" \
  -d '{
    "email": "user@email.com",
    "password": "password"
  }'
```

2. **Ubah password (dengan token):**
```bash
curl -X POST "http://localhost:8000/api/auth/change-password" \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -d '{
    "current_password": "password_lama",
    "new_password": "password_baru",
    "new_password_confirmation": "password_baru"
  }'
```

3. **Mengambil 5 pengumuman terbaru:**
```bash
curl -X GET "http://localhost:8000/api/pengumuman/terbaru"
```

4. **Mengambil semua pengumuman dengan pagination:**
```bash
curl -X GET "http://localhost:8000/api/pengumuman?page=1&per_page=5"
```

5. **Mengambil detail pengumuman:**
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
- Endpoint yang memerlukan authentication harus menyertakan header `Authorization: Bearer {token}`
- Token dapat diperoleh melalui endpoint login
- Response selalu dalam format JSON dengan encoding UTF-8
- Password minimal 6 karakter
- Untuk endpoint change password, user harus menyertakan password saat ini untuk verifikasi

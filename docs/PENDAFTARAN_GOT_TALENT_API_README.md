# Dokumentasi API Pendaftaran Al Amin Got Talent

## Cara Generate Dokumentasi Swagger

### 1. Generate dokumentasi menggunakan command Laravel

```bash
php artisan l5-swagger:generate
```

### 2. Akses dokumentasi Swagger

Setelah generate berhasil, dokumentasi dapat diakses melalui:

- **Swagger UI**: `http://localhost:8000/api/documentation`
- **JSON API Docs**: `http://localhost:8000/api/docs.json`
- **Web View**: `http://localhost:8000/api-docs`

### 3. File yang telah dibuat

- **Controller**: `app/Http/Controllers/Api/PendaftaranGotTalentController.php`
- **Routes**: Sudah ditambahkan di `routes/api.php`
- **Models**: Relasi sudah ditambahkan di `app/Models/PendaftaranGotTalent.php`

## Endpoints yang Tersedia

### Public Endpoints (Tidak Perlu Authentication)

#### 1. POST `/api/pendaftaran-got-talent/register`
Registrasi pendaftaran baru Al Amin Got Talent

**Request Body:**
```json
{
  "nama_lengkap": "Ahmad Fauzi",
  "tempat_lahir": "Jakarta",
  "tanggal_lahir": "2010-05-15",
  "id_jenjang": 1,
  "asal_sekolah": "SD Al Amin",
  "alamat_sekolah": "Jl. Raya No. 123",
  "alamat_rumah": "Jl. Rumah No. 456",
  "no_hp": "081234567890",
  "perlombaan": [1, 2, 3]
}
```

**Catatan:**
- `tempat_lahir`: Tempat lahir peserta (required, string, max 100 karakter)
- `tanggal_lahir`: Tanggal lahir peserta (required, format: YYYY-MM-DD, contoh: 2010-05-15)
- Email dan password akan di-generate otomatis. Email dibuat dari nomor register dengan akhiran @agt.com. Password sama dengan nomor HP yang diinput.

**Response:**
```json
{
  "success": true,
  "message": "Registrasi berhasil",
  "data": {
    "user": {...},
    "pendaftaran": {...},
    "token": "1|xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"
  }
}
```

#### 2. GET `/api/pendaftaran-got-talent/jenjang-pendidikan`
Mengambil list jenjang pendidikan

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "jenjang_pendidikan": "SD",
      "created_at": "2024-01-01 00:00:00",
      "updated_at": "2024-01-01 00:00:00"
    }
  ]
}
```

#### 3. GET `/api/pendaftaran-got-talent/perlombaan`
Mengambil list perlombaan

**Query Parameters:**
- `id_jenjang` (optional): Filter by jenjang pendidikan

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "jenis_perlombaan": "Lomba Baca Puisi",
      "id_jenjang": 1,
      "jenjang_pendidikan": {
        "id": 1,
        "jenjang_pendidikan": "SD"
      }
    }
  ]
}
```

### Protected Endpoints (Perlu Authentication)

#### 4. GET `/api/pendaftaran-got-talent/my-pendaftaran`
Mengambil data pendaftaran user yang sedang login

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "nomor_register": "GT241001",
    "nama_lengkap": "Ahmad Fauzi",
    "tempat_lahir": "Jakarta",
    "tanggal_lahir": "2010-05-15",
    "id_jenjang": 1,
    "asal_sekolah": "SD Al Amin",
    "alamat_sekolah": "Jl. Raya No. 123",
    "alamat_rumah": "Jl. Rumah No. 456",
    "no_hp": "081234567890",
    "email": "GT241001@agt.com",
    "jenjang_pendidikan": {
      "id": 1,
      "jenjang_pendidikan": "SD"
    },
    "perlombaan": [
      {
        "id": 1,
        "jenis_perlombaan": "Lomba Baca Puisi",
        "id_jenjang": 1
      }
    ]
  }
}
```

#### 5. PUT `/api/pendaftaran-got-talent/update`
Update data pendaftaran user yang sedang login

**Headers:**
```
Authorization: Bearer {token}
```

**Request Body:**
```json
{
  "nama_lengkap": "Ahmad Fauzi",
  "tempat_lahir": "Jakarta",
  "tanggal_lahir": "2010-05-15",
  "id_jenjang": 1,
  "asal_sekolah": "SD Al Amin",
  "alamat_sekolah": "Jl. Raya No. 123",
  "alamat_rumah": "Jl. Rumah No. 456",
  "no_hp": "081234567890",
  "perlombaan": [1, 2, 3]
}
```

**Catatan:**
- `tempat_lahir`: Tempat lahir peserta (required, string, max 100 karakter)
- `tanggal_lahir`: Tanggal lahir peserta (required, format: YYYY-MM-DD, contoh: 2010-05-15)

**Response:**
```json
{
  "success": true,
  "message": "Data berhasil diupdate",
  "data": {...}
}
```

## Struktur Dokumentasi Swagger

Dokumentasi telah dibuat dengan format standar OpenAPI 3.0 yang mencakup:

### Informasi API
- Title: "Pendaftaran Got Talent API"
- Tags: "Pendaftaran Got Talent"
- Security: Bearer Token (Sanctum) untuk protected endpoints

### Schema Definitions

1. **PendaftaranGotTalent** - Schema untuk data pendaftaran
2. **RegisterResponse** - Schema untuk response registrasi
3. **ErrorResponse** - Schema untuk error response

### Response Codes

- **200**: Success
- **401**: Unauthorized (untuk protected endpoints)
- **404**: Not Found
- **422**: Validation Error
- **500**: Server Error

## Testing API

Setelah dokumentasi di-generate, Anda dapat:

1. **Menggunakan Swagger UI** untuk testing langsung dari browser
2. **Copy curl commands** dari dokumentasi
3. **Import ke Postman** menggunakan OpenAPI/Swagger format
4. **Gunakan untuk frontend development** sebagai referensi

## Update Dokumentasi

Jika ada perubahan pada API:

1. Update anotasi `@OA\*` di controller
2. Jalankan kembali: `php artisan l5-swagger:generate`
3. Refresh browser untuk melihat perubahan

## Troubleshooting

Jika generate gagal:

```bash
# Clear cache
php artisan config:clear
php artisan route:clear

# Generate ulang
php artisan l5-swagger:generate

# Pastikan folder storage writable
chmod -R 755 storage/
```

## Fitur Dokumentasi yang Tersedia

✅ **Complete OpenAPI 3.0 Documentation**
✅ **Interactive Swagger UI**
✅ **Authentication Schema (Bearer Token)**
✅ **Request/Response Examples**
✅ **Parameter Documentation**
✅ **Error Response Handling**
✅ **Schema Definitions**
✅ **Ready for Export (JSON/YAML)**
✅ **Postman Collection Ready**

Dokumentasi siap digunakan untuk development, testing, dan integrasi dengan aplikasi frontend atau mobile.


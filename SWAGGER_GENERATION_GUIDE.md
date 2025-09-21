# Panduan Generate Dokumentasi Swagger API Tabungan Santri

## Cara Generate Dokumentasi Swagger

### 1. Generate dokumentasi menggunakan command Laravel

```bash
php artisan l5-swagger:generate
```

### 2. Akses dokumentasi Swagger

Setelah generate berhasil, dokumentasi dapat diakses melalui:

-   **Swagger UI**: `http://localhost:8000/api/documentation`
-   **JSON API Docs**: `http://localhost:8000/api/docs.json`
-   **Web View**: `http://localhost:8000/api-docs`

### 3. File yang telah dibuat

-   **Controller**: `app/Http/Controllers/Api/TabunganSantriController.php`
-   **Routes**: Sudah ditambahkan di `routes/api.php`
-   **Models**: Relasi sudah ditambahkan di `app/Models/Tabungan.php`

### 4. Struktur Dokumentasi Swagger

Dokumentasi telah dibuat dengan format standar OpenAPI 3.0 yang mencakup:

#### Informasi API

-   Title: "Tabungan Santri API"
-   Version: "1.0.0"
-   Description: API untuk mengelola data tabungan santri
-   Security: Bearer Token (Sanctum)

#### Endpoints yang didokumentasikan:

1. **GET /api/tabungan-santri/{id_siswa}**

    - Summary: Mendapatkan data tabungan santri berdasarkan ID Siswa
    - Authentication: Required (Bearer Token)
    - Parameters: id_siswa (path), include_transactions (query), limit_transactions (query)
    - Responses: 200, 401, 404, 500

2. **GET /api/tabungan-santri/{id_siswa}/rekening/{no_rekening}**
    - Summary: Mendapatkan detail tabungan santri berdasarkan nomor rekening
    - Authentication: Required (Bearer Token)
    - Parameters: id_siswa (path), no_rekening (path), limit_transactions (query)
    - Responses: 200, 401, 404, 500

### 5. Contoh Response Schema

Dokumentasi mencakup schema lengkap untuk:

-   Data siswa (id_siswa, nama_lengkap, nis, kelas)
-   Data tabungan (no_rekening, saldo, jenis_tabungan, anggota)
-   Data transaksi (no_transaksi, tanggal, jenis_transaksi, jumlah, saldo, berita, nama_petugas)
-   Error responses (401 Unauthenticated, 404 Not Found, 500 Server Error)

### 6. Security Schema

Dokumentasi menggunakan Bearer Token authentication:

```yaml
securityScheme: "sanctum"
type: "http"
scheme: "bearer"
bearerFormat: "JWT"
```

### 7. Testing API

Setelah dokumentasi di-generate, Anda dapat:

1. **Menggunakan Swagger UI** untuk testing langsung dari browser
2. **Copy curl commands** dari dokumentasi
3. **Import ke Postman** menggunakan OpenAPI/Swagger format
4. **Gunakan untuk frontend development** sebagai referensi

### 8. Update Dokumentasi

Jika ada perubahan pada API:

1. Update anotasi `@OA\*` di controller
2. Jalankan kembali: `php artisan l5-swagger:generate`
3. Refresh browser untuk melihat perubahan

### 9. Konfigurasi Tambahan

File konfigurasi L5-Swagger berada di:

-   `config/l5-swagger.php`
-   Storage dokumentasi: `storage/api-docs/api-docs.json`

### 10. Troubleshooting

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
✅ **Ready for Export (JSON/YAML)**
✅ **Postman Collection Ready**

Dokumentasi siap digunakan untuk development, testing, dan integrasi dengan aplikasi frontend atau mobile.


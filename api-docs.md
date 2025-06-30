# Dokumentasi API: Menampilkan Data Siswa Berdasarkan NIK Orang Tua

## Endpoint
```
GET /api/siswa-anak
```

## Deskripsi
Mengambil data seluruh siswa di mana `nik_ayah` atau `nik_ibu` sama dengan username user yang sedang login (biasanya digunakan oleh user dengan role orang tua).

## Autentikasi
- **Wajib login** menggunakan token Sanctum.
- Tambahkan header:
  ```
  Authorization: Bearer {token}
  ```

## Request
Tidak perlu mengirim parameter query atau body.

## Contoh Request (cURL)
```bash
curl -X GET http://localhost:8000/api/siswa-anak \
  -H "Authorization: Bearer {token}"
```

## Response Sukses
- **Kode:** 200 OK
- **Format:** JSON array of siswa

```json
[
  {
    "id_siswa": "2025001",
    "nisn": "1234567890",
    "nama_lengkap": "Budi Santoso",
    "nik_ayah": "1234567890123456",
    "nik_ibu": "1234567890654321",
    "...": "..."
  }
]
```

## Response Jika Tidak Ada Data
```json
[]
```

## Catatan
- Data yang diambil adalah seluruh siswa di mana `nik_ayah` atau `nik_ibu` sama dengan username user login.
- Pastikan user sudah login dan token dikirimkan dengan benar.

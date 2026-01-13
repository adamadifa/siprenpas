# Dokumentasi API: Get Biaya Siswa by No Pendaftaran

## Endpoint
`GET /api/getbiayasiswa-by-nopendaftaran`

## Deskripsi
Endpoint ini digunakan untuk mengambil detail biaya siswa berdasarkan nomor pendaftaran. Informasi yang dikembalikan mencakup detail biaya, potongan, mutasi, dan histori pembayaran yang sudah dilakukan.

## Authentication
Endpoint ini memerlukan autentikasi menggunakan Bearer Token (Sanctum).

**Headers:**
```
Authorization: Bearer {token}
Accept: application/json
```

## Parameters

| Parameter | Tipe | Required | Deskripsi |
| :--- | :--- | :--- | :--- |
| `no_pendaftaran` | String | Yes | Nomor pendaftaran siswa yang ingin dicek biayanya. |

## Contoh Request
```http
GET /api/getbiayasiswa-by-nopendaftaran?no_pendaftaran=20240001
```

## Response Structure

### Success Response (200 OK)
Response berupa array object JSON yang berisi detail biaya.

```json
[
  {
    "kode_biaya": "B001",
    "nama_biaya": "SPP Juli",
    "nominal": 500000,
    "kode_jenis_biaya": "JB01",
    "jenis_biaya": "SPP",
    "jumlah_potongan": 0,
    "jumlah_mutasi": 0,
    "jmlbayar": 500000,
    "tahun_ajaran": "2024/2025"
  },
  {
    "kode_biaya": "B002",
    "nama_biaya": "Uang Gedung",
    "nominal": 2000000,
    "kode_jenis_biaya": "JB02",
    "jenis_biaya": "Pembangunan",
    "jumlah_potongan": 500000,
    "jumlah_mutasi": 0,
    "jmlbayar": 1500000,
    "tahun_ajaran": "2024/2025"
  }
]
```

#### Penjelasan Field Response:

- `kode_biaya`: Kode unik untuk item biaya.
- `nama_biaya`: Nama dari item biaya (misal: SPP Juli, Uang Gedung).
- `nominal`: Nominal tagihan asli sebelum potongan.
- `kode_jenis_biaya`: Kode jenis kategori biaya.
- `jenis_biaya`: Nama kategori jenis biaya.
- `jumlah_potongan`: Total potongan yang didapat siswa untuk item biaya ini.
- `jumlah_mutasi`: Penyesuaian biaya (jika ada).
- `jmlbayar`: Jumlah yang sudah dibayarkan oleh siswa.
- `tahun_ajaran`: Tahun ajaran terkait biaya tersebut.

### Error Response

#### 401 Unauthorized
Jika token tidak valid atau tidak disertakan.
```json
{
    "message": "Unauthenticated."
}
```

#### 500 Internal Server Error
Jika terjadi kesalahan pada server.

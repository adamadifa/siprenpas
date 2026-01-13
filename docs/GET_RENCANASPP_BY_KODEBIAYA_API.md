# Dokumentasi API: Get Rencana SPP by Kode Biaya

## Endpoint
`GET /api/getrencanaspp-by-kodebiaya`

## Deskripsi
Endpoint ini digunakan untuk mengambil rencana pembayaran siswa (khususnya SPP atau biaya bulanan lainnya) berdasarkan kode biaya dan nomor pendaftaran. Informasi yang dikembalikan mencakup detail rincian pembayaran per bulan/termin.

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
| `kode_biaya` | String | Yes | Kode biaya yang ingin dilihat rencana pembayarannya (contoh: B001). |
| `no_pendaftaran` | String | Yes | Nomor pendaftaran siswa. |

## Contoh Request
```http
GET /api/getrencanaspp-by-kodebiaya?kode_biaya=B001&no_pendaftaran=20240001
```

## Response Structure

### Success Response (200 OK)
Response berupa array object JSON yang berisi detail rencana pembayaran.

```json
[
  {
    "kode_rencana_spp": "RSPP001",
    "kode_biaya": "B001",
    "bulan": 7,
    "tahun": 2024,
    "nominal": 500000,
    "status_bayar": "Lunas",
    "tanggal_jatuh_tempo": "2024-07-10"
  },
  {
    "kode_rencana_spp": "RSPP001",
    "kode_biaya": "B001",
    "bulan": 8,
    "tahun": 2024,
    "nominal": 500000,
    "status_bayar": "Belum Lunas",
    "tanggal_jatuh_tempo": "2024-08-10"
  }
]
```

#### Penjelasan Field Response:

- `kode_rencana_spp`: Kode unik rencana SPP.
- `kode_biaya`: Kode biaya terkait.
- `bulan`: Bulan tagihan (angka 1-12).
- `tahun`: Tahun tagihan.
- `nominal`: Nominal yang harus dibayar untuk bulan tersebut.
- `status_bayar`: Status pembayaran (misal: Lunas, Belum Lunas).
- `tanggal_jatuh_tempo`: Tanggal batas akhir pembayaran.

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

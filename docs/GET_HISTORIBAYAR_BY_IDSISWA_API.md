# Dokumentasi API: Get Histori Bayar by ID Siswa

## Endpoint
`GET /api/gethistoribayar-by-idsiswa`

## Deskripsi
Endpoint ini digunakan untuk mengambil histori pembayaran siswa berdasarkan ID siswa. Data yang dikembalikan menghimpun pembayaran yang telah dilakukan, dikelompokkan berdasarkan nomor bukti, tanggal, dan petugas yang melayani.

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
| `id_siswa` | String | Yes | ID siswa yang ingin dilihat histori pembayarannya. |

## Contoh Request
```http
GET /api/gethistoribayar-by-idsiswa?id_siswa=1
```

## Response Structure

### Success Response (200 OK)
Response berupa array object JSON yang berisi histori pembayaran.

```json
[
  {
    "no_bukti": "KW-20240101-001",
    "tanggal": "2024-01-01 10:00:00",
    "name": "Admin Keuangan",
    "jumlah": 500000,
    "keterangan": "Pembayaran SPP Januari"
  },
  {
    "no_bukti": "KW-20240201-002",
    "tanggal": "2024-02-01 11:30:00",
    "name": "Admin Keuangan",
    "jumlah": 150000,
    "keterangan": "Pembayaran Uang Gedung"
  }
]
```

#### Penjelasan Field Response:

- `no_bukti`: Nomor bukti transaksi/kwitansi.
- `tanggal`: Tanggal dan waktu transaksi.
- `name`: Nama petugas/user yang memproses transaksi.
- `jumlah`: Total nominal pembayaran pada transaksi tersebut.
- `keterangan`: Keterangan terkait pembayaran.

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

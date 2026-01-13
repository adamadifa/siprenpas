# Dokumentasi API: Get Detail Histori Bayar

## Endpoint
`GET /api/getdetailhistoribayar`

## Deskripsi
Endpoint ini digunakan untuk mengambil detail item pembayaran dalam satu transaksi berdasarkan nomor bukti. Ini memberikan rincian untuk apa saja pembayaran tersebut dilakukan (misal: rincian bulan SPP, uang gedung, dll).

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
| `no_bukti` | String | Yes | Nomor bukti transaksi yang ingin dilihat detailnya. |

## Contoh Request
```http
GET /api/getdetailhistoribayar?no_bukti=KW-20240101-001
```

## Response Structure

### Success Response (200 OK)
Response berupa array object JSON yang berisi detail item pembayaran.

```json
[
  {
    "no_bukti": "KW-20240101-001",
    "tanggal": "2024-01-01 10:00:00",
    "name": "Admin Keuangan",
    "kode_jenis_biaya": "JB01",
    "jenis_biaya": "SPP",
    "tingkat": 1,
    "tahun_ajaran": "2024/2025",
    "jumlah": 250000,
    "keterangan": "SPP Bulan Januari"
  },
  {
    "no_bukti": "KW-20240101-001",
    "tanggal": "2024-01-01 10:00:00",
    "name": "Admin Keuangan",
    "kode_jenis_biaya": "JB01",
    "jenis_biaya": "SPP",
    "tingkat": 1,
    "tahun_ajaran": "2024/2025",
    "jumlah": 250000,
    "keterangan": "SPP Bulan Februari"
  }
]
```

#### Penjelasan Field Response:

- `no_bukti`: Nomor bukti transaksi.
- `tanggal`: Tanggal transaksi.
- `name`: Nama petugas yang memproses.
- `kode_jenis_biaya`: Kode jenis biaya.
- `jenis_biaya`: Nama jenis biaya (misal: SPP, Uang Gedung).
- `tingkat`: Tingkat kelas siswa saat melakukan pembayaran.
- `tahun_ajaran`: Tahun ajaran terkait biaya tersebut.
- `jumlah`: Nominal pembayaran untuk item tersebut.
- `keterangan`: Keterangan detail (misal: "SPP Bulan ...").

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

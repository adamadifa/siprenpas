# Dokumentasi API: Get Detail Tabungan Santri

## Endpoint
`GET /api/tabungan-santri/{id_siswa}/rekening/{no_rekening}`

## Deskripsi
Endpoint ini digunakan untuk mengambil detail informasi rekening tabungan santri spesifik beserta histori transaksinya.

## Authentication
Endpoint ini memerlukan autentikasi menggunakan Bearer Token (Sanctum).

**Headers:**
```
Authorization: Bearer {token}
Accept: application/json
```

## Parameters

### Path Parameters
| Parameter | Tipe | Required | Deskripsi |
| :--- | :--- | :--- | :--- |
| `id_siswa` | String | Yes | ID Siswa pemilik tabungan. |
| `no_rekening` | String | Yes | Nomor rekening tabungan yang ingin dilihat detailnya. |

### Query Parameters
| Parameter | Tipe | Required | Default | Deskripsi |
| :--- | :--- | :--- | :--- | :--- |
| `limit_transactions` | Integer | No | 20 | Membatasi jumlah histori transaksi yang ditampilkan. |

## Contoh Request
```http
GET /api/tabungan-santri/2024001/rekening/001-2024001001?limit_transactions=10
```

## Response Structure

### Success Response (200 OK)

```json
{
    "success": true,
    "message": "Detail tabungan santri berhasil diambil",
    "data": {
        "no_rekening": "001-2024001001",
        "no_anggota": "2024001",
        "kode_tabungan": "001",
        "saldo": 250000,
        "jenis_tabungan": "Tabungan Umum",
        "nama_anggota": "Ahmad Rizki",
        "created_at": "2024-01-01T08:00:00.000000Z",
        "updated_at": "2024-01-05T08:00:00.000000Z",
        "transaksi": [
            {
                "no_transaksi": "001241201001",
                "tanggal": "2024-01-05",
                "jenis_transaksi": "S",
                "jenis_transaksi_text": "Setor",
                "jumlah": 50000,
                "saldo": 250000,
                "berita": "Setoran tabungan bulanan",
                "nama_petugas": "Admin Koperasi",
                "created_at": "2024-01-05T10:30:00.000000Z"
            },
            {
                "no_transaksi": "001241201002",
                "tanggal": "2024-01-02",
                "jenis_transaksi": "T",
                "jenis_transaksi_text": "Tarik",
                "jumlah": 20000,
                "saldo": 200000,
                "berita": "Penarikan tunai",
                "nama_petugas": "Admin Koperasi",
                "created_at": "2024-01-02T09:15:00.000000Z"
            }
        ],
        "total_transaksi": 10
    }
}
```

#### Penjelasan Field Response:

- `success`: Status keberhasilan request (boolean).
- `message`: Pesan respon dari server string).
- `data`: Object data utama.
    - `no_rekening`: Nomor rekening tabungan.
    - `no_anggota`: Nomor anggota koperasi/ID siswa.
    - `kode_tabungan`: Kode jenis tabungan.
    - `saldo`: Saldo saat ini (integer).
    - `jenis_tabungan`: Nama jenis tabungan (string).
    - `nama_anggota`: Nama lengkap pemilik rekening.
    - `created_at`: Tanggal pembuatan rekening.
    - `updated_at`: Tanggal update terakhir rekening.
    - `transaksi`: Array object berisi histori transaksi.
        - `no_transaksi`: Nomor transaksi unik.
        - `tanggal`: Tanggal transaksi (Y-m-d).
        - `jenis_transaksi`: Kode jenis transaksi ('S' = Setor, 'T' = Tarik).
        - `jenis_transaksi_text`: Teks deskriptif jenis transaksi.
        - `jumlah`: Nominal transaksi (integer).
        - `saldo`: Saldo setelah transaksi (integer).
        - `berita`: Keterangan atau berita transaksi.
        - `nama_petugas`: Nama petugas yang memproses transaksi.
        - `created_at`: Waktu detail transaksi.
    - `total_transaksi`: Jumlah total transaksi yang ditampilkan (sesuai limit atau total yang ada).

### Error Response

#### 404 Not Found
Jika rekening tidak ditemukan atau tidak milik siswa yang diminta.
```json
{
    "success": false,
    "message": "Tabungan tidak ditemukan atau tidak milik siswa ini"
}
```

#### 401 Unauthorized
Jika token tidak valid atau tidak disertakan.
```json
{
    "message": "Unauthenticated."
}
```

#### 500 Internal Server Error
Jika terjadi kesalahan pada server.
```json
{
    "success": false,
    "message": "Terjadi kesalahan server",
    "error": "Error message details" // Hanya muncul jika debug mode on
}
```

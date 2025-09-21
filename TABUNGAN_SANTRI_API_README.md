# API Tabungan Santri - Dokumentasi

API ini digunakan untuk mendapatkan data tabungan santri dari tabel `koperasi_tabungan` yang berelasi dengan `siswa_anggota` dan `koperasi_anggota` berdasarkan ID Siswa.

## Struktur Database

### Relasi Tabel

-   `koperasi_tabungan` → `koperasi_anggota` (melalui `no_anggota`)
-   `koperasi_anggota` → `siswa_anggota` (melalui `no_anggota`)
-   `siswa_anggota` → `siswa` (melalui `id_siswa`)
-   `koperasi_tabungan` → `koperasi_jenis_tabungan` (melalui `kode_tabungan`)

## Endpoints

⚠️ **Semua endpoint memerlukan autentikasi menggunakan Bearer Token (Sanctum)**

### 1. Mendapatkan Data Tabungan Santri

**GET** `/api/tabungan-santri/{id_siswa}`

Mengambil semua data tabungan santri berdasarkan ID Siswa.

**Headers Required:**

```
Authorization: Bearer {your_token}
Content-Type: application/json
```

#### Parameter Path

-   `id_siswa` (string, required): ID Siswa

#### Parameter Query

-   `include_transactions` (boolean, optional): Apakah ingin menyertakan transaksi tabungan (default: false)
-   `limit_transactions` (integer, optional): Jumlah transaksi yang ditampilkan (default: 10)

#### Contoh Request

```bash
GET /api/tabungan-santri/2024001
GET /api/tabungan-santri/2024001?include_transactions=true&limit_transactions=5
```

#### Response Sukses (200)

```json
{
    "success": true,
    "message": "Data tabungan santri berhasil diambil",
    "data": {
        "siswa": {
            "id_siswa": "2024001",
            "nama_lengkap": "Ahmad Rizki",
            "nis": "20240001",
            "kelas": "X-A"
        },
        "total_saldo": 500000,
        "jumlah_rekening": 2,
        "tabungan": [
            {
                "no_rekening": "001-2024001001",
                "no_anggota": "2024001001",
                "kode_tabungan": "001",
                "saldo": 250000,
                "created_at": "2024-01-15T08:00:00.000000Z",
                "updated_at": "2024-12-01T10:30:00.000000Z",
                "jenis_tabungan": {
                    "kode_tabungan": "001",
                    "jenis_tabungan": "Tabungan Umum",
                    "keterangan": "Tabungan untuk keperluan umum"
                },
                "anggota": {
                    "no_anggota": "2024001001",
                    "nama_lengkap": "Ahmad Rizki",
                    "alamat": "Jl. Pendidikan No. 123",
                    "no_hp": "081234567890"
                },
                "transaksi": [
                    {
                        "no_transaksi": "001241201001",
                        "tanggal": "2024-12-01",
                        "jenis_transaksi": "S",
                        "jenis_transaksi_text": "Setor",
                        "jumlah": 50000,
                        "saldo": 250000,
                        "berita": "Setoran tabungan bulanan",
                        "nama_petugas": "Admin Koperasi",
                        "created_at": "2024-12-01T10:30:00.000000Z"
                    }
                ]
            }
        ]
    }
}
```

#### Response Error (404)

```json
{
    "success": false,
    "message": "Siswa tidak ditemukan atau tidak memiliki tabungan"
}
```

### 2. Mendapatkan Detail Tabungan Santri

**GET** `/api/tabungan-santri/{id_siswa}/rekening/{no_rekening}`

Mengambil detail tabungan santri berdasarkan nomor rekening.

**Headers Required:**

```
Authorization: Bearer {your_token}
Content-Type: application/json
```

#### Parameter Path

-   `id_siswa` (string, required): ID Siswa
-   `no_rekening` (string, required): Nomor Rekening Tabungan

#### Parameter Query

-   `limit_transactions` (integer, optional): Jumlah transaksi yang ditampilkan (default: 20)

#### Contoh Request

```bash
GET /api/tabungan-santri/2024001/rekening/001-2024001001
GET /api/tabungan-santri/2024001/rekening/001-2024001001?limit_transactions=50
```

#### Response Sukses (200)

```json
{
    "success": true,
    "message": "Detail tabungan santri berhasil diambil",
    "data": {
        "no_rekening": "001-2024001001",
        "no_anggota": "2024001001",
        "kode_tabungan": "001",
        "saldo": 250000,
        "jenis_tabungan": "Tabungan Umum",
        "nama_anggota": "Ahmad Rizki",
        "created_at": "2024-01-15T08:00:00.000000Z",
        "updated_at": "2024-12-01T10:30:00.000000Z",
        "transaksi": [
            {
                "no_transaksi": "001241201001",
                "tanggal": "2024-12-01",
                "jenis_transaksi": "S",
                "jenis_transaksi_text": "Setor",
                "jumlah": 50000,
                "saldo": 250000,
                "berita": "Setoran tabungan bulanan",
                "nama_petugas": "Admin Koperasi",
                "created_at": "2024-12-01T10:30:00.000000Z"
            }
        ],
        "total_transaksi": 1
    }
}
```

#### Response Error (404)

```json
{
    "success": false,
    "message": "Tabungan tidak ditemukan atau tidak milik siswa ini"
}
```

## Status Response

-   `200 OK`: Request berhasil
-   `404 Not Found`: Data tidak ditemukan
-   `500 Internal Server Error`: Terjadi kesalahan server

## Jenis Transaksi

-   `S`: Setor (Deposit)
-   `T`: Tarik (Withdrawal)

## Catatan Implementasi

1. **Keamanan**: API ini menggunakan query builder untuk menghindari N+1 query problem
2. **Performance**: Menggunakan JOIN untuk efisiensi query database
3. **Validasi**: Memvalidasi kepemilikan tabungan oleh siswa sebelum menampilkan data
4. **Error Handling**: Menangani berbagai kemungkinan error dengan response yang informatif
5. **Flexibility**: Parameter optional untuk menyertakan transaksi sesuai kebutuhan

## Contoh Penggunaan

### JavaScript/Fetch

```javascript
// Mendapatkan tabungan santri
fetch("/api/tabungan-santri/2024001", {
    method: "GET",
    headers: {
        Authorization: "Bearer your_token_here",
        "Content-Type": "application/json",
        Accept: "application/json",
    },
})
    .then((response) => response.json())
    .then((data) => {
        if (data.success) {
            console.log("Total Saldo:", data.data.total_saldo);
            console.log("Jumlah Rekening:", data.data.jumlah_rekening);
        }
    });

// Mendapatkan detail tabungan dengan transaksi
fetch(
    "/api/tabungan-santri/2024001/rekening/001-2024001001?limit_transactions=10",
    {
        method: "GET",
        headers: {
            Authorization: "Bearer your_token_here",
            "Content-Type": "application/json",
            Accept: "application/json",
        },
    }
)
    .then((response) => response.json())
    .then((data) => {
        if (data.success) {
            console.log("Saldo:", data.data.saldo);
            console.log("Transaksi:", data.data.transaksi);
        }
    });
```

### cURL

```bash
# Mendapatkan tabungan santri
curl -X GET "http://localhost:8000/api/tabungan-santri/2024001" \
  -H "Authorization: Bearer your_token_here" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json"

# Mendapatkan tabungan santri dengan transaksi
curl -X GET "http://localhost:8000/api/tabungan-santri/2024001?include_transactions=true&limit_transactions=5" \
  -H "Authorization: Bearer your_token_here" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json"

# Mendapatkan detail tabungan
curl -X GET "http://localhost:8000/api/tabungan-santri/2024001/rekening/001-2024001001" \
  -H "Authorization: Bearer your_token_here" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json"
```

## Response Error untuk Autentikasi

### 401 Unauthorized

```json
{
    "message": "Unauthenticated."
}
```

Response ini akan dikembalikan jika:

-   Token tidak disertakan dalam header
-   Token tidak valid atau sudah expired
-   Token format salah

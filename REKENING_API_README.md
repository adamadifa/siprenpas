# API Rekening Tabungan Santri

API ini digunakan untuk mendapatkan data rekening tabungan santri berdasarkan RFID. API ini dapat diakses tanpa login terlebih dahulu, tetapi tetap memerlukan autentikasi menggunakan API token khusus.

## Endpoint

### GET /api/public/rekening/{rfid}

Mendapatkan data rekening berdasarkan RFID.

#### Headers

```
X-API-Token: sipren-api-token-2024
Content-Type: application/json
```

#### Parameters

-   `rfid` (string, required): Kode RFID tabungan yang akan dicari

#### Response Success (200)

```json
{
    "success": true,
    "message": "Data rekening berhasil diambil",
    "data": {
         "no_rekening": "TAB001",
         "no_anggota": "ANG001",
         "kode_tabungan": "T01",
         "saldo": 500000,
         "rfid": "RFID123456",
         "created_at": "2024-01-15T10:30:00.000000Z",
         "updated_at": "2024-01-15T10:30:00.000000Z",
        "jenis_tabungan": {
            "kode_tabungan": "T01",
            "jenis_tabungan": "Tabungan Pendidikan"
        },
        "anggota": {
            "no_anggota": "ANG001",
            "nama_lengkap": "Ahmad Santri",
            "alamat": "Jl. Pendidikan No. 123",
            "no_hp": "081234567890"
        }
    }
}
```

#### Response Error (404)

```json
{
    "success": false,
    "message": "Rekening dengan RFID tersebut tidak ditemukan"
}
```

#### Response Error (401)

```json
{
    "success": false,
    "message": "Unauthorized. Invalid or missing API token."
}
```

#### Response Error (500)

```json
{
    "success": false,
    "message": "Terjadi kesalahan server: [error message]"
}
```

## Konfigurasi

### Environment Variables

Tambahkan konfigurasi berikut di file `.env`:

```env
API_TOKEN=sipren-api-token-2024
```

### Default Token

Jika tidak ada konfigurasi di `.env`, API akan menggunakan token default: `sipren-api-token-2024`

## Contoh Penggunaan

### cURL

```bash
curl -X GET "http://your-domain.com/api/public/rekening/RFID123456" \
  -H "X-API-Token: sipren-api-token-2024" \
  -H "Content-Type: application/json"
```

### JavaScript (Fetch)

```javascript
fetch("http://your-domain.com/api/public/rekening/RFID123456", {
    method: "GET",
    headers: {
        "X-API-Token": "sipren-api-token-2024",
        "Content-Type": "application/json",
    },
})
    .then((response) => response.json())
    .then((data) => console.log(data))
    .catch((error) => console.error("Error:", error));
```

### PHP (Guzzle)

```php
use GuzzleHttp\Client;

$client = new Client();
$response = $client->get('http://your-domain.com/api/public/rekening/RFID123456', [
    'headers' => [
        'X-API-Token' => 'sipren-api-token-2024',
        'Content-Type' => 'application/json'
    ]
]);

$data = json_decode($response->getBody(), true);
```

## Keamanan

1. **API Token**: Semua request harus menyertakan header `X-API-Token` yang valid
2. **Rate Limiting**: API menggunakan rate limiting untuk mencegah abuse
3. **No User Data**: API hanya mengembalikan data rekening dan saldo, tidak termasuk detail transaksi

## Catatan

-   API ini tidak memerlukan login user terlebih dahulu
-   Token dapat dikonfigurasi melalui environment variable `API_TOKEN`
-   Data yang dikembalikan hanya informasi rekening dan saldo, tidak termasuk riwayat transaksi
-   API menggunakan middleware `api.token` untuk autentikasi

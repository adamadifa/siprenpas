# Program Unggulan API Documentation

API untuk mengelola Program Unggulan sekolah dengan endpoint public dan authenticated.

## Base URL

```
http://localhost:8000/api
```

## Endpoints

### Public Endpoints (Tidak memerlukan authentication)

#### 1. Mendapatkan Daftar Program Unggulan

```http
GET /public/program-unggulan
```

**Response:**

```json
{
    "success": true,
    "message": "Data program unggulan berhasil diambil",
    "data": [
        {
            "id": 1,
            "nama_program": "Pembentukan Karakter",
            "deskripsi": "Program ini fokus pada pembentukan akhlak mulia, kedisiplinan, tanggung jawab, dan etika peserta didik melalui kegiatan rutin, mentoring, dan keteladanan.",
            "urutan": 1,
            "created_at": "2024-01-01 00:00:00",
            "updated_at": "2024-01-01 00:00:00"
        },
        {
            "id": 2,
            "nama_program": "Tahsin & Tahfizh Al Quran",
            "deskripsi": "Meningkatkan kemampuan membaca Al-Quran dengan tajwid yang benar (tahsin) dan membina peserta didik agar mampu menghafal Al-Quran secara terstruktur dan konsisten (tahfizh).",
            "urutan": 2,
            "created_at": "2024-01-01 00:00:00",
            "updated_at": "2024-01-01 00:00:00"
        }
    ]
}
```

#### 2. Mendapatkan Detail Program Unggulan

```http
GET /public/program-unggulan/{id}
```

**Parameters:**

-   `id` (integer, required): ID Program Unggulan

**Response:**

```json
{
    "success": true,
    "message": "Detail program unggulan berhasil diambil",
    "data": {
        "id": 1,
        "nama_program": "Pembentukan Karakter",
        "deskripsi": "Program ini fokus pada pembentukan akhlak mulia, kedisiplinan, tanggung jawab, dan etika peserta didik melalui kegiatan rutin, mentoring, dan keteladanan.",
        "urutan": 1,
        "created_at": "2024-01-01 00:00:00",
        "updated_at": "2024-01-01 00:00:00"
    }
}
```

#### 3. Mendapatkan Program Unggulan Secara Acak

```http
GET /public/program-unggulan/random/{limit}
```

**Parameters:**

-   `limit` (integer, optional): Jumlah program unggulan yang diambil (default: 3)

**Response:**

```json
{
    "success": true,
    "message": "Data program unggulan acak berhasil diambil",
    "data": [
        {
            "id": 2,
            "nama_program": "Tahsin & Tahfizh Al Quran",
            "deskripsi": "Meningkatkan kemampuan membaca Al-Quran dengan tajwid yang benar (tahsin) dan membina peserta didik agar mampu menghafal Al-Quran secara terstruktur dan konsisten (tahfizh).",
            "urutan": 2,
            "created_at": "2024-01-01 00:00:00",
            "updated_at": "2024-01-01 00:00:00"
        },
        {
            "id": 4,
            "nama_program": "Science",
            "deskripsi": "Menumbuhkan rasa ingin tahu dan keterampilan sains melalui eksperimen, observasi, dan pembelajaran berbasis proyek yang mendorong peserta didik berpikir kritis dan kreatif.",
            "urutan": 4,
            "created_at": "2024-01-01 00:00:00",
            "updated_at": "2024-01-01 00:00:00"
        }
    ]
}
```

### Authenticated Endpoints (Memerlukan Bearer Token)

#### 1. Mendapatkan Daftar Program Unggulan (Admin)

```http
GET /program-unggulan
Authorization: Bearer {token}
```

**Response:**

```json
{
    "success": true,
    "message": "Data program unggulan berhasil diambil",
    "data": [
        {
            "id": 1,
            "nama_program": "Pembentukan Karakter",
            "deskripsi": "Program ini fokus pada pembentukan akhlak mulia...",
            "urutan": 1,
            "created_at": "2024-01-01 00:00:00",
            "updated_at": "2024-01-01 00:00:00"
        }
    ]
}
```

#### 2. Membuat Program Unggulan Baru

```http
POST /program-unggulan
Authorization: Bearer {token}
Content-Type: application/json

{
  "nama_program": "Program Baru",
  "deskripsi": "Deskripsi program baru",
  "urutan": 5
}
```

**Validation Rules:**

-   `nama_program`: required, string, max:255
-   `deskripsi`: nullable, string
-   `urutan`: required, integer, min:0

**Response:**

```json
{
    "success": true,
    "message": "Program unggulan berhasil dibuat",
    "data": {
        "id": 5,
        "nama_program": "Program Baru",
        "deskripsi": "Deskripsi program baru",
        "urutan": 5,
        "created_at": "2024-01-01 00:00:00",
        "updated_at": "2024-01-01 00:00:00"
    }
}
```

#### 3. Mengupdate Program Unggulan

```http
PUT /program-unggulan/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
  "nama_program": "Program Terupdate",
  "deskripsi": "Deskripsi program terupdate",
  "urutan": 3
}
```

**Response:**

```json
{
    "success": true,
    "message": "Program unggulan berhasil diupdate",
    "data": {
        "id": 1,
        "nama_program": "Program Terupdate",
        "deskripsi": "Deskripsi program terupdate",
        "urutan": 3,
        "created_at": "2024-01-01 00:00:00",
        "updated_at": "2024-01-01 00:00:00"
    }
}
```

#### 4. Menghapus Program Unggulan

```http
DELETE /program-unggulan/{id}
Authorization: Bearer {token}
```

**Response:**

```json
{
    "success": true,
    "message": "Program unggulan berhasil dihapus"
}
```

## Response Format

### Success Response

```json
{
  "success": true,
  "message": "Pesan sukses",
  "data": { ... }
}
```

### Error Response

```json
{
    "success": false,
    "message": "Pesan error",
    "error": "Detail error (optional)"
}
```

### Validation Error Response

```json
{
    "success": false,
    "message": "Validasi gagal",
    "errors": {
        "nama_program": ["The nama program field is required."],
        "urutan": ["The urutan field is required."]
    }
}
```

## HTTP Status Codes

-   `200` - OK (Success)
-   `201` - Created (Resource created successfully)
-   `404` - Not Found (Resource not found)
-   `422` - Unprocessable Entity (Validation failed)
-   `500` - Internal Server Error

## Authentication

Untuk endpoint yang memerlukan authentication, gunakan Bearer Token:

```http
Authorization: Bearer {your_token_here}
```

## Swagger Documentation

Dokumentasi lengkap dengan UI interaktif tersedia di:

```
http://localhost:8000/api/documentation
```

## Contoh Penggunaan

### JavaScript/Fetch

```javascript
// Mendapatkan daftar program unggulan
fetch("http://localhost:8000/api/public/program-unggulan")
    .then((response) => response.json())
    .then((data) => {
        if (data.success) {
            console.log("Program Unggulan:", data.data);
        } else {
            console.error("Error:", data.message);
        }
    })
    .catch((error) => console.error("Network Error:", error));

// Mendapatkan program unggulan acak
fetch("http://localhost:8000/api/public/program-unggulan/random/2")
    .then((response) => response.json())
    .then((data) => {
        if (data.success) {
            console.log("Program Unggulan Acak:", data.data);
        } else {
            console.error("Error:", data.message);
        }
    });

// Mendapatkan detail program unggulan
fetch("http://localhost:8000/api/public/program-unggulan/1")
    .then((response) => response.json())
    .then((data) => {
        if (data.success) {
            console.log("Detail Program:", data.data);
        } else {
            console.error("Error:", data.message);
        }
    });

// Membuat program unggulan baru (dengan authentication)
const token = "your_bearer_token_here";
fetch("http://localhost:8000/api/program-unggulan", {
    method: "POST",
    headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${token}`,
    },
    body: JSON.stringify({
        nama_program: "Program Baru",
        deskripsi: "Deskripsi program baru",
        urutan: 5,
    }),
})
    .then((response) => response.json())
    .then((data) => {
        if (data.success) {
            console.log("Program berhasil dibuat:", data.data);
        } else {
            console.error("Error:", data.message);
        }
    });
```

### PHP/cURL

```php
<?php
// Mendapatkan daftar program unggulan
function getProgramUnggulan() {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://localhost:8000/api/public/program-unggulan');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json'
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 200) {
        $data = json_decode($response, true);
        if ($data['success']) {
            return $data['data'];
        } else {
            throw new Exception($data['message']);
        }
    } else {
        throw new Exception("HTTP Error: " . $httpCode);
    }
}

// Mendapatkan program unggulan acak
function getProgramUnggulanRandom($limit = 3) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/api/public/program-unggulan/random/{$limit}");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json'
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 200) {
        $data = json_decode($response, true);
        if ($data['success']) {
            return $data['data'];
        } else {
            throw new Exception($data['message']);
        }
    } else {
        throw new Exception("HTTP Error: " . $httpCode);
    }
}

// Membuat program unggulan baru (dengan authentication)
function createProgramUnggulan($token, $data) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://localhost:8000/api/program-unggulan');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $token
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 201) {
        $result = json_decode($response, true);
        if ($result['success']) {
            return $result['data'];
        } else {
            throw new Exception($result['message']);
        }
    } else {
        throw new Exception("HTTP Error: " . $httpCode);
    }
}

// Contoh penggunaan
try {
    // Mendapatkan semua program unggulan
    $programs = getProgramUnggulan();
    echo "Program Unggulan:\n";
    foreach ($programs as $program) {
        echo "- {$program['nama_program']}\n";
    }

    // Mendapatkan program unggulan acak
    $randomPrograms = getProgramUnggulanRandom(2);
    echo "\nProgram Unggulan Acak:\n";
    foreach ($randomPrograms as $program) {
        echo "- {$program['nama_program']}\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
```

### Python/Requests

```python
import requests
import json

# Base URL
BASE_URL = "http://localhost:8000/api"

# Mendapatkan daftar program unggulan
def get_program_unggulan():
    response = requests.get(f"{BASE_URL}/public/program-unggulan")
    if response.status_code == 200:
        data = response.json()
        if data['success']:
            return data['data']
        else:
            raise Exception(data['message'])
    else:
        raise Exception(f"HTTP Error: {response.status_code}")

# Mendapatkan program unggulan acak
def get_program_unggulan_random(limit=3):
    response = requests.get(f"{BASE_URL}/public/program-unggulan/random/{limit}")
    if response.status_code == 200:
        data = response.json()
        if data['success']:
            return data['data']
        else:
            raise Exception(data['message'])
    else:
        raise Exception(f"HTTP Error: {response.status_code}")

# Membuat program unggulan baru (dengan authentication)
def create_program_unggulan(token, program_data):
    headers = {
        'Content-Type': 'application/json',
        'Authorization': f'Bearer {token}'
    }

    response = requests.post(
        f"{BASE_URL}/program-unggulan",
        headers=headers,
        data=json.dumps(program_data)
    )

    if response.status_code == 201:
        data = response.json()
        if data['success']:
            return data['data']
        else:
            raise Exception(data['message'])
    else:
        raise Exception(f"HTTP Error: {response.status_code}")

# Contoh penggunaan
try:
    # Mendapatkan semua program unggulan
    programs = get_program_unggulan()
    print("Program Unggulan:")
    for program in programs:
        print(f"- {program['nama_program']}")

    # Mendapatkan program unggulan acak
    random_programs = get_program_unggulan_random(2)
    print("\nProgram Unggulan Acak:")
    for program in random_programs:
        print(f"- {program['nama_program']}")

except Exception as e:
    print(f"Error: {e}")
```

## Data Seeder

Data program unggulan sudah diisi dengan seeder yang berisi:

1. **Pembentukan Karakter** - Program fokus pada pembentukan akhlak mulia, kedisiplinan, tanggung jawab, dan etika peserta didik melalui kegiatan rutin, mentoring, dan keteladanan.

2. **Tahsin & Tahfizh Al Quran** - Meningkatkan kemampuan membaca Al-Quran dengan tajwid yang benar (tahsin) dan membina peserta didik agar mampu menghafal Al-Quran secara terstruktur dan konsisten (tahfizh).

3. **Bahasa Asing** - Membekali peserta didik dengan kemampuan dasar dalam berbahasa Arab dan Inggris secara aktif, baik lisan maupun tulisan, melalui pembelajaran kontekstual dan praktik langsung.

4. **Science** - Menumbuhkan rasa ingin tahu dan keterampilan sains melalui eksperimen, observasi, dan pembelajaran berbasis proyek yang mendorong peserta didik berpikir kritis dan kreatif.

## Error Handling

### Common Error Responses

#### 404 - Not Found

```json
{
    "success": false,
    "message": "Program unggulan tidak ditemukan"
}
```

#### 422 - Validation Error

```json
{
    "success": false,
    "message": "Validasi gagal",
    "errors": {
        "nama_program": ["The nama program field is required."],
        "urutan": [
            "The urutan field is required.",
            "The urutan must be at least 0."
        ]
    }
}
```

#### 500 - Server Error

```json
{
    "success": false,
    "message": "Terjadi kesalahan saat mengambil data program unggulan",
    "error": "Database connection failed"
}
```

## Testing API

### Menggunakan Postman

1. **Import Collection**: Import file collection Postman untuk API Program Unggulan
2. **Set Environment**: Set base URL ke `http://localhost:8000/api`
3. **Test Public Endpoints**: Test endpoint public tanpa authentication
4. **Test Authenticated Endpoints**: Test endpoint CRUD dengan Bearer Token

### Menggunakan cURL

```bash
# Test endpoint public
curl -X GET "http://localhost:8000/api/public/program-unggulan" \
  -H "Content-Type: application/json"

# Test endpoint dengan authentication
curl -X POST "http://localhost:8000/api/program-unggulan" \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -d '{
    "nama_program": "Test Program",
    "deskripsi": "Program untuk testing",
    "urutan": 10
  }'
```

## Rate Limiting

API ini menggunakan rate limiting untuk mencegah abuse:

-   **Public Endpoints**: 100 requests per minute per IP
-   **Authenticated Endpoints**: 200 requests per minute per user

## CORS

API mendukung CORS untuk akses dari frontend:

-   **Allowed Origins**: `http://localhost:3000`, `http://localhost:8080`
-   **Allowed Methods**: GET, POST, PUT, DELETE, OPTIONS
-   **Allowed Headers**: Content-Type, Authorization, X-Requested-With

## Notes

-   Semua endpoint public tidak memerlukan authentication
-   Endpoint CRUD memerlukan Bearer Token authentication
-   Data diurutkan berdasarkan field `urutan` secara ascending
-   Timestamp menggunakan format `Y-m-d H:i:s`
-   API menggunakan Laravel Sanctum untuk authentication
-   Semua response menggunakan format JSON
-   Error handling yang konsisten di semua endpoint
-   Validasi input yang ketat untuk keamanan data

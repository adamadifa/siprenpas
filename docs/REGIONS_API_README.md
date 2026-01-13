# API Regions - Select Berjenjang (Provinsi, Kabupaten, Kecamatan, Kelurahan)

## Deskripsi

API ini menyediakan endpoint untuk mendapatkan data wilayah administratif Indonesia secara berjenjang. API ini digunakan untuk fitur select berjenjang dimana ketika user memilih provinsi, maka akan muncul daftar kabupaten/kota dari provinsi tersebut, dan seterusnya.

## Base URL

```
http://localhost:8000/api/public/regions
```

## Endpoint yang Tersedia

1. **GET /provinces** - Mendapatkan semua provinsi
2. **GET /regencies** - Mendapatkan kabupaten/kota berdasarkan provinsi
3. **GET /districts** - Mendapatkan kecamatan berdasarkan kabupaten/kota
4. **GET /villages** - Mendapatkan kelurahan/desa berdasarkan kecamatan

---

## 1. Mendapatkan Semua Provinsi

### Endpoint
```
GET /api/public/regions/provinces
```

### Deskripsi
Mengembalikan daftar semua provinsi di Indonesia. Endpoint ini digunakan sebagai langkah pertama dalam select berjenjang.

### Request
Tidak memerlukan parameter apapun.

### Response Success (200)
```json
{
  "status": "success",
  "count": 34,
  "data": [
    {
      "id": "32",
      "name": "Jawa Barat"
    },
    {
      "id": "31",
      "name": "DKI Jakarta"
    }
  ]
}
```

### Contoh Penggunaan

**cURL:**
```bash
curl -X GET "http://localhost:8000/api/public/regions/provinces"
```

**JavaScript (Fetch):**
```javascript
fetch('http://localhost:8000/api/public/regions/provinces')
  .then(response => response.json())
  .then(data => console.log(data));
```

**JavaScript (Axios):**
```javascript
axios.get('http://localhost:8000/api/public/regions/provinces')
  .then(response => console.log(response.data));
```

---

## 2. Mendapatkan Kabupaten/Kota Berdasarkan Provinsi

### Endpoint
```
GET /api/public/regions/regencies
```

### Deskripsi
Mengembalikan daftar kabupaten/kota berdasarkan provinsi yang dipilih. Endpoint ini dipanggil setelah user memilih provinsi.

### Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| province_id | string | Yes | ID Provinsi yang dipilih (contoh: "32" untuk Jawa Barat) |

### Response Success (200)
```json
{
  "status": "success",
  "count": 27,
  "data": [
    {
      "id": "3201",
      "name": "Bogor"
    },
    {
      "id": "3202",
      "name": "Sukabumi"
    }
  ]
}
```

### Response Error (400)
```json
{
  "status": "error",
  "message": "The province id field is required."
}
```

### Contoh Penggunaan

**cURL:**
```bash
curl -X GET "http://localhost:8000/api/public/regions/regencies?province_id=32"
```

**JavaScript (Fetch):**
```javascript
const provinceId = "32"; // ID dari provinsi yang dipilih
fetch(`http://localhost:8000/api/public/regions/regencies?province_id=${provinceId}`)
  .then(response => response.json())
  .then(data => console.log(data));
```

**JavaScript (Axios):**
```javascript
const provinceId = "32";
axios.get('http://localhost:8000/api/public/regions/regencies', {
  params: { province_id: provinceId }
})
  .then(response => console.log(response.data));
```

---

## 3. Mendapatkan Kecamatan Berdasarkan Kabupaten/Kota

### Endpoint
```
GET /api/public/regions/districts
```

### Deskripsi
Mengembalikan daftar kecamatan berdasarkan kabupaten/kota yang dipilih. Endpoint ini dipanggil setelah user memilih kabupaten/kota.

### Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| regency_id | string | Yes | ID Kabupaten/Kota yang dipilih (contoh: "3201" untuk Bogor) |

### Response Success (200)
```json
{
  "status": "success",
  "count": 40,
  "data": [
    {
      "id": "3201010",
      "name": "Bogor Selatan"
    },
    {
      "id": "3201020",
      "name": "Bogor Utara"
    }
  ]
}
```

### Response Error (400)
```json
{
  "status": "error",
  "message": "The regency id field is required."
}
```

### Contoh Penggunaan

**cURL:**
```bash
curl -X GET "http://localhost:8000/api/public/regions/districts?regency_id=3201"
```

**JavaScript (Fetch):**
```javascript
const regencyId = "3201"; // ID dari kabupaten yang dipilih
fetch(`http://localhost:8000/api/public/regions/districts?regency_id=${regencyId}`)
  .then(response => response.json())
  .then(data => console.log(data));
```

**JavaScript (Axios):**
```javascript
const regencyId = "3201";
axios.get('http://localhost:8000/api/public/regions/districts', {
  params: { regency_id: regencyId }
})
  .then(response => console.log(response.data));
```

---

## 4. Mendapatkan Kelurahan/Desa Berdasarkan Kecamatan

### Endpoint
```
GET /api/public/regions/villages
```

### Deskripsi
Mengembalikan daftar kelurahan/desa berdasarkan kecamatan yang dipilih. Endpoint ini dipanggil setelah user memilih kecamatan.

### Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| district_id | string | Yes | ID Kecamatan yang dipilih (contoh: "3201010" untuk Bogor Selatan) |

### Response Success (200)
```json
{
  "status": "success",
  "count": 15,
  "data": [
    {
      "id": "3201010001",
      "name": "Bojongkerta"
    },
    {
      "id": "3201010002",
      "name": "Sempur"
    }
  ]
}
```

### Response Error (400)
```json
{
  "status": "error",
  "message": "The district id field is required."
}
```

### Contoh Penggunaan

**cURL:**
```bash
curl -X GET "http://localhost:8000/api/public/regions/villages?district_id=3201010"
```

**JavaScript (Fetch):**
```javascript
const districtId = "3201010"; // ID dari kecamatan yang dipilih
fetch(`http://localhost:8000/api/public/regions/villages?district_id=${districtId}`)
  .then(response => response.json())
  .then(data => console.log(data));
```

**JavaScript (Axios):**
```javascript
const districtId = "3201010";
axios.get('http://localhost:8000/api/public/regions/villages', {
  params: { district_id: districtId }
})
  .then(response => console.log(response.data));
```

---

## Contoh Implementasi Select Berjenjang

Berikut contoh implementasi lengkap untuk membuat select berjenjang menggunakan API ini:

### HTML
```html
<div class="form-group">
  <label>Provinsi</label>
  <select id="province" onchange="loadRegencies()">
    <option value="">Pilih Provinsi</option>
  </select>
</div>

<div class="form-group">
  <label>Kabupaten/Kota</label>
  <select id="regency" onchange="loadDistricts()" disabled>
    <option value="">Pilih Kabupaten/Kota</option>
  </select>
</div>

<div class="form-group">
  <label>Kecamatan</label>
  <select id="district" onchange="loadVillages()" disabled>
    <option value="">Pilih Kecamatan</option>
  </select>
</div>

<div class="form-group">
  <label>Kelurahan/Desa</label>
  <select id="village" disabled>
    <option value="">Pilih Kelurahan/Desa</option>
  </select>
</div>
```

### JavaScript (Vanilla)
```javascript
const baseUrl = 'http://localhost:8000/api/public/regions';

// Load Provinsi saat halaman dimuat
window.onload = function() {
  loadProvinces();
};

// Load Provinsi
function loadProvinces() {
  fetch(`${baseUrl}/provinces`)
    .then(response => response.json())
    .then(data => {
      const select = document.getElementById('province');
      select.innerHTML = '<option value="">Pilih Provinsi</option>';
      data.data.forEach(province => {
        const option = document.createElement('option');
        option.value = province.id;
        option.textContent = province.name;
        select.appendChild(option);
      });
    });
}

// Load Kabupaten/Kota
function loadRegencies() {
  const provinceId = document.getElementById('province').value;
  const regencySelect = document.getElementById('regency');
  const districtSelect = document.getElementById('district');
  const villageSelect = document.getElementById('village');
  
  if (!provinceId) {
    regencySelect.disabled = true;
    regencySelect.innerHTML = '<option value="">Pilih Kabupaten/Kota</option>';
    districtSelect.disabled = true;
    villageSelect.disabled = true;
    return;
  }
  
  fetch(`${baseUrl}/regencies?province_id=${provinceId}`)
    .then(response => response.json())
    .then(data => {
      regencySelect.disabled = false;
      regencySelect.innerHTML = '<option value="">Pilih Kabupaten/Kota</option>';
      data.data.forEach(regency => {
        const option = document.createElement('option');
        option.value = regency.id;
        option.textContent = regency.name;
        regencySelect.appendChild(option);
      });
      
      // Reset select berikutnya
      districtSelect.disabled = true;
      districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
      villageSelect.disabled = true;
      villageSelect.innerHTML = '<option value="">Pilih Kelurahan/Desa</option>';
    });
}

// Load Kecamatan
function loadDistricts() {
  const regencyId = document.getElementById('regency').value;
  const districtSelect = document.getElementById('district');
  const villageSelect = document.getElementById('village');
  
  if (!regencyId) {
    districtSelect.disabled = true;
    districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
    villageSelect.disabled = true;
    return;
  }
  
  fetch(`${baseUrl}/districts?regency_id=${regencyId}`)
    .then(response => response.json())
    .then(data => {
      districtSelect.disabled = false;
      districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
      data.data.forEach(district => {
        const option = document.createElement('option');
        option.value = district.id;
        option.textContent = district.name;
        districtSelect.appendChild(option);
      });
      
      // Reset select berikutnya
      villageSelect.disabled = true;
      villageSelect.innerHTML = '<option value="">Pilih Kelurahan/Desa</option>';
    });
}

// Load Kelurahan/Desa
function loadVillages() {
  const districtId = document.getElementById('district').value;
  const villageSelect = document.getElementById('village');
  
  if (!districtId) {
    villageSelect.disabled = true;
    villageSelect.innerHTML = '<option value="">Pilih Kelurahan/Desa</option>';
    return;
  }
  
  fetch(`${baseUrl}/villages?district_id=${districtId}`)
    .then(response => response.json())
    .then(data => {
      villageSelect.disabled = false;
      villageSelect.innerHTML = '<option value="">Pilih Kelurahan/Desa</option>';
      data.data.forEach(village => {
        const option = document.createElement('option');
        option.value = village.id;
        option.textContent = village.name;
        villageSelect.appendChild(option);
      });
    });
}
```

---

## Generate Dokumentasi Swagger

API ini sudah dilengkapi dengan anotasi Swagger/OpenAPI. Untuk generate dokumentasi, jalankan perintah berikut:

```bash
php artisan l5-swagger:generate
```

Setelah generate berhasil, dokumentasi dapat diakses melalui:

- **Swagger UI**: `http://localhost:8000/api/documentation`
- **JSON API Docs**: `http://localhost:8000/api/docs.json`

### Update Dokumentasi

Jika ada perubahan pada API:

1. Update anotasi `@OA\*` di controller `app/Http/Controllers/Api/RegionController.php`
2. Jalankan kembali: `php artisan l5-swagger:generate`
3. Refresh browser untuk melihat perubahan

### Troubleshooting

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

---

## Struktur Data Response

### Format Response Umum

Semua endpoint mengembalikan response dalam format yang sama:

```json
{
  "status": "success",
  "count": <jumlah_data>,
  "data": [
    {
      "id": "<id_wilayah>",
      "name": "<nama_wilayah>"
    }
  ]
}
```

### Format ID Wilayah

- **Provinsi**: 2 digit (contoh: "32" untuk Jawa Barat)
- **Kabupaten/Kota**: 4 digit (contoh: "3201" untuk Bogor)
- **Kecamatan**: 7 digit (contoh: "3201010" untuk Bogor Selatan)
- **Kelurahan/Desa**: 10 digit (contoh: "3201010001" untuk Bojongkerta)

---

## Catatan Penting

1. **Tidak memerlukan autentikasi**: Semua endpoint di API ini adalah public dan tidak memerlukan token authentication.
2. **Urutan penggunaan**: Endpoint harus dipanggil secara berurutan (Provinsi → Kabupaten → Kecamatan → Kelurahan).
3. **Parameter required**: Semua parameter query adalah required untuk endpoint yang memerlukannya.
4. **Data diurutkan**: Semua data yang dikembalikan sudah diurutkan berdasarkan nama (name) secara ascending.

---

## File yang Terkait

- **Controller**: `app/Http/Controllers/Api/RegionController.php`
- **Routes**: `routes/api.php` (di dalam group `public`)
- **Models**: 
  - `app/Models/Province.php`
  - `app/Models/Regency.php`
  - `app/Models/District.php`
  - `app/Models/Village.php`

---

## Support

Untuk pertanyaan atau masalah terkait API ini, silakan hubungi tim development.


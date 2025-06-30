<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dokumentasi API - SIPRENPAS</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 2rem; background: #f8fafc; color: #222; }
        h1 { color: #0d6efd; }
        code, pre { background: #e9ecef; padding: 2px 6px; border-radius: 4px; }
        .endpoint { background: #fff; border: 1px solid #ddd; border-radius: 8px; padding: 1rem; margin-bottom: 2rem; }
        .method { font-weight: bold; color: #198754; }
        .url { font-family: monospace; font-size: 1.1em; }
        .section-title { color: #495057; margin-top: 2rem; }
        .param-table { border-collapse: collapse; width: 100%; margin-bottom: 1rem; }
        .param-table th, .param-table td { border: 1px solid #dee2e6; padding: 8px; }
        .param-table th { background: #f1f3f5; }
        .response { background: #f8f9fa; border-left: 4px solid #0d6efd; padding: 1rem; margin-top: 1rem; }
    </style>
</head>
<body>
    <h1>Dokumentasi API SIPRENPAS</h1>
    <p>API ini digunakan untuk aplikasi mobile (orang tua memantau siswa). Berikut dokumentasi endpoint yang tersedia.</p>

    <div class="endpoint">
        <h2>Login</h2>
        <span class="method">POST</span>
        <span class="url">/api/auth/login</span>
        <h4 class="section-title">Request Body (JSON)</h4>
        <table class="param-table">
            <tr><th>Field</th><th>Tipe</th><th>Wajib</th><th>Keterangan</th></tr>
            <tr><td>email</td><td>string</td><td>Ya</td><td>Email pengguna</td></tr>
            <tr><td>password</td><td>string</td><td>Ya</td><td>Password pengguna</td></tr>
        </table>
        <h4 class="section-title">Contoh Request</h4>
        <pre>{
  "email": "user@email.com",
  "password": "password"
}</pre>
        <h4 class="section-title">Contoh Response Sukses</h4>
        <div class="response">
<pre>{
  "success": true,
  "message": "Login berhasil",
  "data": {
    "user": {
      "id": 1,
      "name": "Nama User",
      "email": "user@email.com",
      ...
    },
    "token": "TOKEN_SANCTUM"
  }
}</pre>
        </div>
        <h4 class="section-title">Contoh Response Gagal</h4>
        <div class="response">
<pre>{
  "success": false,
  "message": "Email atau password salah"
}</pre>
        </div>
    </div>

    <div class="endpoint">
        <h2>Registrasi Orang Tua</h2>
        <span class="method">POST</span>
        <span class="url">/api/auth/register-orangtua</span>
        <h4 class="section-title">Request Body (JSON)</h4>
        <table class="param-table">
            <tr><th>Field</th><th>Tipe</th><th>Wajib</th><th>Keterangan</th></tr>
            <tr><td>name</td><td>string</td><td>Ya</td><td>Nama lengkap orang tua</td></tr>
            <tr><td>email</td><td>string</td><td>Ya</td><td>Email aktif orang tua</td></tr>
            <tr><td>password</td><td>string</td><td>Ya</td><td>Password minimal 6 karakter</td></tr>
            <tr><td>password_confirmation</td><td>string</td><td>Ya</td><td>Konfirmasi password (harus sama dengan password)</td></tr>
            <tr><td>nik</td><td>string (16 digit)</td><td>Ya</td><td>NIK ayah atau ibu sesuai data siswa</td></tr>
        </table>
        <h4 class="section-title">Contoh Request</h4>
        <pre>{
  "name": "Orang Tua Siswa",
  "email": "ortu@email.com",
  "password": "passwordku",
  "password_confirmation": "passwordku",
  "nik": "3275012345678901"
}</pre>
        <h4 class="section-title">Contoh Response Sukses</h4>
        <div class="response">
<pre>{
  "success": true,
  "message": "Registrasi berhasil",
  "data": {
    "user": {
      "id": 2,
      "name": "Orang Tua Siswa",
      "email": "ortu@email.com",
      ...
    },
    "token": "TOKEN_SANCTUM"
  }
}
</pre>
        </div>
        <h4 class="section-title">Contoh Response Gagal</h4>
        <div class="response">
<pre>{
  "success": false,
  "message": "NIK tidak ditemukan pada data siswa. Pastikan NIK ayah atau ibu sudah terdaftar di sekolah."
}
</pre>
        </div>
    </div>

    <div class="endpoint">
        <h2>Ambil Data Siswa Berdasarkan NIK Orang Tua</h2>
        <span class="method">GET</span>
        <span class="url">/api/siswa-anak</span>
        <h4 class="section-title">Deskripsi</h4>
        <p>Menampilkan seluruh data siswa di mana <code>nik_ayah</code> atau <code>nik_ibu</code> sama dengan username user yang sedang login (umumnya digunakan oleh orang tua).</p>
        <h4 class="section-title">Autentikasi</h4>
        <p>Wajib login menggunakan token Sanctum.<br>
        Tambahkan header: <code>Authorization: Bearer &#123;token&#125;</code></p>
        <h4 class="section-title">Contoh Request</h4>
        <pre>GET /api/siswa-anak
Authorization: Bearer TOKEN_SANCTUM</pre>
        <h4 class="section-title">Contoh Response Sukses</h4>
        <div class="response">
<pre>[
  {
    "id_siswa": "2025001",
    "nisn": "1234567890",
    "nama_lengkap": "Budi Santoso",
    "nik_ayah": "1234567890123456",
    "nik_ibu": "1234567890654321",
    "...": "..."
  }
]</pre>
        </div>
        <h4 class="section-title">Contoh Response Jika Tidak Ada Data</h4>
        <div class="response">
<pre>[]</pre>
        </div>
    </div>

    <div class="endpoint">
        <h2>Ambil Data Siswa Berdasarkan ID Siswa (Detail Lengkap)</h2>
        <span class="method">GET</span>
        <span class="url">/api/siswa-by-idsiswa</span>
        <h4 class="section-title">Deskripsi</h4>
        <p>Mengambil data detail siswa berdasarkan <code>id_siswa</code> yang dikirim oleh front-end melalui query string. Data yang diambil merupakan hasil join dengan tabel pendaftaran, kelas, unit, dan tahun ajaran aktif. Hanya dapat diakses oleh user yang sudah login (token Sanctum).</p>
        <h4 class="section-title">Autentikasi</h4>
        <p>Wajib login menggunakan token Sanctum.<br>
        Tambahkan header: <code>Authorization: Bearer &#123;token&#125;</code></p>
        <h4 class="section-title">Parameter Query</h4>
        <table class="param-table">
            <tr><th>Field</th><th>Tipe</th><th>Wajib</th><th>Keterangan</th></tr>
            <tr><td>id_siswa</td><td>string</td><td>Ya</td><td>ID siswa yang ingin diambil detailnya</td></tr>
        </table>
        <h4 class="section-title">Deskripsi</h4>
        <p>Menampilkan detail lengkap data siswa beserta informasi pendaftaran, kelas, unit, biaya, dan tahun ajaran aktif berdasarkan <code>id_siswa</code> yang dikirimkan oleh front-end. Data diambil dari beberapa tabel yang di-join. Hanya dapat diakses oleh user yang sudah login (token Sanctum).</p>
        <h4 class="section-title">Autentikasi</h4>
        <p>Wajib login menggunakan token Sanctum.<br>
        Tambahkan header: <code>Authorization: Bearer &#123;token&#125;</code></p>
        <h4 class="section-title">Request Body (JSON)</h4>
        <table class="param-table">
            <tr><th>Field</th><th>Tipe</th><th>Wajib</th><th>Keterangan</th></tr>
            <tr><td>id_siswa</td><td>string</td><td>Ya</td><td>ID siswa yang ingin diambil detailnya</td></tr>
        </table>
        <h4 class="section-title">Contoh Request</h4>
        <pre>GET /api/siswa-by-idsiswa?id_siswa=2025001
Authorization: Bearer TOKEN_SANCTUM
</pre>
        <h4 class="section-title">Contoh Response Sukses</h4>
        <div class="response">
<pre>[
  {
    "id_siswa": "2025001",
    "nama_lengkap": "Budi Santoso",
    "no_pendaftaran": "REG2025001",
    "tahun_ajaran": "2024/2025",
    "nis": "1234567890",
    "nama_kelas": "VII-A",
    "tingkat": "VII",
    "nama_unit": "Unit SMP",
    "logo": "logo_smp.png",
    ...
  }
]
</pre>
        </div>
        <h4 class="section-title">Contoh Response Jika Tidak Ditemukan</h4>
        <div class="response">
<pre>[]</pre>
        </div>
    </div>

    <div class="endpoint">
        <h2>Ambil Data Unit Berdasarkan ID Siswa</h2>
        <span class="method">POST</span>
        <span class="url">/api/unit-by-siswa</span>
        <h4 class="section-title">Deskripsi</h4>
        <p>Mengambil data unit berdasarkan <code>id_siswa</code> yang dikirimkan oleh front-end. Data unit diambil dari tabel <strong>pendaftaran</strong> yang di-<em>join</em> dengan tabel <strong>unit</strong>. Hasil berupa array/list unit (bisa lebih dari satu jika data pendaftaran lebih dari satu). Hanya dapat diakses oleh user yang sudah login (token Sanctum).</p>
        <h4 class="section-title">Autentikasi</h4>
        <p>Wajib login menggunakan token Sanctum.<br>
        Tambahkan header: <code>Authorization: Bearer &#123;token&#125;</code></p>
        <h4 class="section-title">Request Body (JSON)</h4>
        <table class="param-table">
            <tr><th>Field</th><th>Tipe</th><th>Wajib</th><th>Keterangan</th></tr>
            <tr><td>id_siswa</td><td>string</td><td>Ya</td><td>ID siswa yang ingin dicari unit-nya</td></tr>
        </table>
        <h4 class="section-title">Contoh Request</h4>
        <pre>POST /api/unit-by-siswa
Authorization: Bearer TOKEN_SANCTUM
Content-Type: application/json

{
  "id_siswa": "2025001"
}
</pre>
        <h4 class="section-title">Contoh Response Sukses</h4>
        <div class="response">
<pre>[
  {
    "kode_unit": "U01",
    "nama_unit": "Unit SD",
    ...
  },
  {
    "kode_unit": "U02",
    "nama_unit": "Unit SMP",
    ...
  }
]
</pre>
        </div>
        <h4 class="section-title">Contoh Response Jika Tidak Ditemukan</h4>
        <div class="response">
<pre>[]</pre>
        </div>
    </div>

    <div class="endpoint">
        <h2>Ambil Daftar Unit</h2>
        <span class="method">GET</span>
        <span class="url">/api/unit</span>
        <h4 class="section-title">Deskripsi</h4>
        <p>Menampilkan seluruh data unit (kecuali kode <code>U00</code> dan <code>U06</code>), hanya dapat diakses oleh user yang sudah login (menggunakan token Sanctum).</p>
        <h4 class="section-title">Autentikasi</h4>
        <p>Wajib login menggunakan token Sanctum.<br>
        Tambahkan header: <code>Authorization: Bearer &#123;token&#125;</code></p>
        <h4 class="section-title">Contoh Request</h4>
        <pre>GET /api/unit
Authorization: Bearer TOKEN_SANCTUM</pre>
        <h4 class="section-title">Contoh Response Sukses</h4>
        <div class="response">
<pre>[
  {
    "kode_unit": "U01",
    "nama_unit": "Unit SD",
    ...
  },
  {
    "kode_unit": "U02",
    "nama_unit": "Unit SMP",
    ...
  }
]</pre>
        </div>
        <h4 class="section-title">Contoh Response Jika Tidak Ada Data</h4>
        <div class="response">
<pre>[]</pre>
        </div>
    </div>

    <p>Untuk endpoint lain, silakan hubungi pengembang atau cek update dokumentasi ini.</p>
</body>
</html>

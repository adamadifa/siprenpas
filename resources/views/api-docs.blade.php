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

    <p>Untuk endpoint lain, silakan hubungi pengembang atau cek update dokumentasi ini.</p>
</body>
</html>

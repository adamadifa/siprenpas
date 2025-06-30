<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Endpoint API siswa-anak untuk orang tua
Route::middleware('auth:sanctum')->get('/siswa-anak', [App\Http\Controllers\Api\SiswaController::class, 'anakByNikOrtu']);

Route::apiResource('/presensi', App\Http\Controllers\Api\PresensiController::class);

// AUTH API
Route::prefix('auth')->group(function () {
    Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'login']);
    Route::post('/register-orangtua', [App\Http\Controllers\Api\AuthController::class, 'registerOrangtua']);
});

// Group endpoint yang memerlukan autentikasi
Route::middleware('auth:sanctum')->group(function () {
    // Endpoint untuk mendapatkan data unit
    Route::get('/unit', [App\Http\Controllers\Api\UnitController::class, 'index']);
    // Endpoint untuk mendapatkan unit berdasarkan id_siswa pada pendaftaran
    Route::get('/unit-by-siswa', [App\Http\Controllers\Api\PendaftaranController::class, 'unitByIdSiswa']);
    Route::get('/siswa-by-idsiswa', [App\Http\Controllers\Api\PendaftaranController::class, 'siswaByIdSiswa']);
    Route::get('/getbiayasiswa-by-nopendaftaran', [App\Http\Controllers\Api\PendaftaranController::class, 'getbiayasiswaByNoPendaftaran']);
});

Route::prefix('public')->group(function () {
    //index posts
    Route::get('/posts/getposthomepage', [App\Http\Controllers\Api\PostController::class, 'getposthomepage']);
    Route::get('/posts/getlastposthomepage', [App\Http\Controllers\Api\PostController::class, 'getlastposthomepage']);
    //show posts
    Route::get('/posts/{slug}', [App\Http\Controllers\Api\PostController::class, 'show']);
});

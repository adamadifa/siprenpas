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

// Endpoint untuk mendapatkan data unit (wajib login)
Route::middleware('auth:sanctum')->get('/unit', [App\Http\Controllers\Api\UnitController::class, 'index']);

// Endpoint untuk mendapatkan unit berdasarkan id_siswa pada pendaftaran (wajib login)
Route::middleware('auth:sanctum')->post('/unit-by-siswa', [App\Http\Controllers\Api\PendaftaranController::class, 'unitByIdSiswa']);

Route::prefix('public')->group(function () {
    //index posts
    Route::get('/posts/getposthomepage', [App\Http\Controllers\Api\PostController::class, 'getposthomepage']);
    Route::get('/posts/getlastposthomepage', [App\Http\Controllers\Api\PostController::class, 'getlastposthomepage']);
    //show posts
    Route::get('/posts/{slug}', [App\Http\Controllers\Api\PostController::class, 'show']);
});

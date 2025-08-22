<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PengumumanController;

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

/**
 * @OA\Get(
 *     path="/user",
 *     tags={"User"},
 *     summary="Ambil data user yang login",
 *     security={{"sanctum":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="User login",
 *         @OA\JsonContent(type="object")
 *     )
 * )
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
    Route::post('/register-siswa', [App\Http\Controllers\Api\AuthController::class, 'registerSiswa']);
    Route::post('/change-password', [App\Http\Controllers\Api\AuthController::class, 'changePassword'])->middleware('auth:sanctum');
});

// Group endpoint yang memerlukan autentikasi
Route::middleware('auth:sanctum')->group(function () {

    // Endpoint untuk mendapatkan unit berdasarkan id_siswa pada pendaftaran
    Route::get('/unit-by-siswa', [App\Http\Controllers\Api\PendaftaranController::class, 'unitByIdSiswa']);
    Route::get('/siswa-by-idsiswa', [App\Http\Controllers\Api\PendaftaranController::class, 'siswaByIdSiswa']);
    Route::get('/getbiayasiswa-by-nopendaftaran', [App\Http\Controllers\Api\PendaftaranController::class, 'getbiayasiswaByNoPendaftaran']);
    Route::get('/getrencanaspp-by-kodebiaya', [App\Http\Controllers\Api\PendaftaranController::class, 'getRencanasppbyKodeBiaya']);
    Route::get('/gethistoribayar-by-idsiswa', [App\Http\Controllers\Api\PendaftaranController::class, 'getHistoribayarbyIdsiswa']);
    Route::get('/getdetailhistoribayar', [App\Http\Controllers\Api\PendaftaranController::class, 'getDetailHistoribayar']);


    //Pendaftaranonline
    Route::get('/pendaftaranonline/getkonfirmasipembayaran', [App\Http\Controllers\Api\PendaftaranonlineController::class, 'getKonfirmasiPembayaran']);
    Route::post('/pendaftaranonline/konfirmasi-pembayaran', [App\Http\Controllers\Api\PendaftaranonlineController::class, 'konfirmasiPembayaran']);
    Route::delete('/pendaftaranonline/delete-pembayaran', [App\Http\Controllers\Api\PendaftaranonlineController::class, 'deletePembayaran']);
    Route::post('/pendaftaranonline/{no_register}/update', [App\Http\Controllers\Api\PendaftaranonlineController::class, 'update']);
    Route::post('/pendaftaranonline/{no_register}/update-foto', [App\Http\Controllers\Api\PendaftaranonlineController::class, 'updateFoto']);
    Route::get('/pendaftaranonline/{id_user}', [App\Http\Controllers\Api\PendaftaranonlineController::class, 'getPendaftaranonlineByIdUser']);
});

Route::prefix('public')->group(function () {
    //index posts
    Route::get('/posts', [App\Http\Controllers\Api\PostController::class, 'index']);
    Route::get('/posts/getposthomepage', [App\Http\Controllers\Api\PostController::class, 'getposthomepage']);
    Route::get('/posts/getrandompost', [App\Http\Controllers\Api\PostController::class, 'getrandompost']);
    Route::get('/posts/getlastposthomepage', [App\Http\Controllers\Api\PostController::class, 'getlastposthomepage']);
    //show posts
    Route::get('/posts/{slug}', [App\Http\Controllers\Api\PostController::class, 'show']);

    // Endpoint untuk mendapatkan data unit
});
Route::get('/unit', [App\Http\Controllers\Api\UnitController::class, 'index']);

// Pengumuman API Routes
Route::prefix('pengumuman')->group(function () {
    Route::get('/terbaru', [PengumumanController::class, 'getPengumumanTerbaru']);
    Route::get('/', [PengumumanController::class, 'index']);
    Route::get('/{id}', [PengumumanController::class, 'show']);
});

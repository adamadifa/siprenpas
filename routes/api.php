<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PengumumanController;
use App\Http\Controllers\Api\PrestasiSiswaController;
use App\Http\Controllers\Api\ProgramUnggulanController;
use App\Http\Controllers\Api\PilarPendidikanController;

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

    // Notification API Routes
    Route::post('/push-subscribe', [App\Http\Controllers\Api\NotificationController::class, 'subscribe']);
    Route::post('/push-unsubscribe', [App\Http\Controllers\Api\NotificationController::class, 'unsubscribe']);

    // Presensi API Routes
    Route::prefix('presensi')->group(function () {
        Route::get('/harian', [App\Http\Controllers\Api\PresensiController::class, 'presensiSiswa']);
        Route::get('/mapel', [App\Http\Controllers\Api\PresensiController::class, 'presensiMapel']);
    });

    // Tabungan Santri API Routes
    Route::prefix('tabungan-santri')->group(function () {
        Route::get('/{id_siswa}', [App\Http\Controllers\Api\TabunganSantriController::class, 'getTabunganByIdSiswa']);
        Route::get('/{id_siswa}/rekening/{no_rekening}', [App\Http\Controllers\Api\TabunganSantriController::class, 'getDetailTabungan']);
    });

    //Pendaftaranonline
    Route::get('/pendaftaranonline/getkonfirmasipembayaran', [App\Http\Controllers\Api\PendaftaranonlineController::class, 'getKonfirmasiPembayaran']);
    Route::post('/pendaftaranonline/konfirmasi-pembayaran', [App\Http\Controllers\Api\PendaftaranonlineController::class, 'konfirmasiPembayaran']);
    Route::delete('/pendaftaranonline/delete-pembayaran', [App\Http\Controllers\Api\PendaftaranonlineController::class, 'deletePembayaran']);
    Route::post('/pendaftaranonline/{no_register}/update', [App\Http\Controllers\Api\PendaftaranonlineController::class, 'update']);
    Route::post('/pendaftaranonline/{no_register}/update-foto', [App\Http\Controllers\Api\PendaftaranonlineController::class, 'updateFoto']);
    Route::get('/pendaftaranonline/{id_user}', [App\Http\Controllers\Api\PendaftaranonlineController::class, 'getPendaftaranonlineByIdUser']);

    //Pendaftaran Got Talent
    Route::get('/pendaftaran-got-talent', [App\Http\Controllers\Api\PendaftaranGotTalentController::class, 'index']);
    Route::get('/pendaftaran-got-talent/my-pendaftaran', [App\Http\Controllers\Api\PendaftaranGotTalentController::class, 'getMyPendaftaran']);
    Route::put('/pendaftaran-got-talent/update', [App\Http\Controllers\Api\PendaftaranGotTalentController::class, 'update']);

    // Konfirmasi Pembayaran Got Talent
    Route::post('/pendaftaran-got-talent/konfirmasi-pembayaran', [App\Http\Controllers\Api\KonfirmasiPembayaranGotTalentController::class, 'store']);
    Route::get('/pendaftaran-got-talent/get-konfirmasi-pembayaran', [App\Http\Controllers\Api\KonfirmasiPembayaranGotTalentController::class, 'show']);

    // Program Unggulan API Routes (CRUD dengan authentication)
    Route::apiResource('program-unggulan', ProgramUnggulanController::class);
});

// Public API Routes untuk Pendaftaran Got Talent
Route::prefix('pendaftaran-got-talent')->group(function () {
    Route::post('/register', [App\Http\Controllers\Api\PendaftaranGotTalentController::class, 'register']);
    Route::get('/list-by-lomba', [App\Http\Controllers\Api\PendaftaranGotTalentController::class, 'listByLomba']);
    Route::get('/jenjang-pendidikan', [App\Http\Controllers\Api\PendaftaranGotTalentController::class, 'getJenjangPendidikan']);
    Route::get('/perlombaan', [App\Http\Controllers\Api\PendaftaranGotTalentController::class, 'getPerlombaan']);
});

Route::prefix('public')->group(function () {
    Route::prefix('sebaran-alumni')->group(function () {
        Route::get('/', [App\Http\Controllers\Api\SebaranAlumniController::class, 'index']);
    });

    Route::prefix('visi-misi')->group(function () {
        Route::get('/', [App\Http\Controllers\Api\VisiMisiController::class, 'index']);
    });
    //index posts
    Route::get('/posts', [App\Http\Controllers\Api\PostController::class, 'index']);
    Route::get('/posts/getposthomepage', [App\Http\Controllers\Api\PostController::class, 'getposthomepage']);
    Route::get('/posts/getrandompost', [App\Http\Controllers\Api\PostController::class, 'getrandompost']);
    Route::get('/posts/getlastposthomepage', [App\Http\Controllers\Api\PostController::class, 'getlastposthomepage']);
    //show posts
    Route::get('/posts/{slug}', [App\Http\Controllers\Api\PostController::class, 'show']);

    Route::prefix('testimonials')->group(function () {
        Route::get('/', [App\Http\Controllers\Api\TestimonialController::class, 'index']);
        Route::get('/random/{limit?}', [App\Http\Controllers\Api\TestimonialController::class, 'random']);
        Route::get('/{id}', [App\Http\Controllers\Api\TestimonialController::class, 'show']);
    });

    Route::prefix('prestasi-siswa')->group(function () {
        Route::get('/', [App\Http\Controllers\Api\PrestasiSiswaController::class, 'index']);
        Route::get('/random/{limit?}', [App\Http\Controllers\Api\PrestasiSiswaController::class, 'random']);
        Route::get('/{id}', [App\Http\Controllers\Api\PrestasiSiswaController::class, 'show']);
    });

    // Gallery public endpoints
    Route::prefix('gallery')->group(function () {
        Route::get('/albums', [App\Http\Controllers\Api\GalleryController::class, 'getAlbums']);
        Route::get('/albums/{id}', [App\Http\Controllers\Api\GalleryController::class, 'getAlbumDetail']);
    });

    Route::prefix('program-unggulan')->group(function () {
        Route::get('/', [ProgramUnggulanController::class, 'index']);
        Route::get('/random/{limit?}', [ProgramUnggulanController::class, 'random']);
        Route::get('/{id}', [ProgramUnggulanController::class, 'show']);
    });

    Route::prefix('pilar-pendidikan')->group(function () {
        Route::get('/', [PilarPendidikanController::class, 'index']);
        Route::get('/{id}', [PilarPendidikanController::class, 'show']);
    });

    // Jenjang Pendidikan & Perlombaan API Routes
    Route::prefix('jenjang-pendidikan')->group(function () {
        Route::get('/', [App\Http\Controllers\Api\PendaftaranGotTalentController::class, 'getJenjangPendidikan']);
    });

    Route::prefix('perlombaan')->group(function () {
        Route::get('/', [App\Http\Controllers\Api\PendaftaranGotTalentController::class, 'getPerlombaan']);
    });

    // Page API Routes
    Route::prefix('pages')->group(function () {
        Route::get('/{slug}', [App\Http\Controllers\Api\PageController::class, 'show']);
    });

    // Pengaturan Umum API Routes
    Route::prefix('pengaturan-umum')->group(function () {
        Route::get('/', [App\Http\Controllers\Api\PengaturanUmumController::class, 'index']);
    });

    // Regions API Routes (Select Berjenjang: Provinsi -> Kabupaten -> Kecamatan -> Kelurahan)
    Route::prefix('regions')->group(function () {
        Route::get('/provinces', [App\Http\Controllers\Api\RegionController::class, 'getProvinces']);
        Route::get('/regencies', [App\Http\Controllers\Api\RegionController::class, 'getRegencies']);
        Route::get('/districts', [App\Http\Controllers\Api\RegionController::class, 'getDistricts']);
        Route::get('/villages', [App\Http\Controllers\Api\RegionController::class, 'getVillages']);
    });

    // Endpoint untuk mendapatkan data unit
});

// Public API Routes dengan token authentication
Route::prefix('public')->middleware('api.token')->group(function () {
    // Rekening API Routes
    Route::get('/rekening/{rfid}', [App\Http\Controllers\Api\RekeningController::class, 'getRekeningByRfid']);
    Route::post('/rekening/transfer', [App\Http\Controllers\Api\RekeningController::class, 'transfer']);
});

Route::get('/unit', [App\Http\Controllers\Api\UnitController::class, 'index']);

// Karyawan API Routes
Route::prefix('karyawan')->group(function () {
    Route::get('/aktif', [App\Http\Controllers\Api\KaryawanController::class, 'getAktif']);
});

// Pengumuman API Routes
Route::prefix('pengumuman')->group(function () {
    Route::get('/terbaru', [PengumumanController::class, 'getPengumumanTerbaru']);
    Route::get('/', [PengumumanController::class, 'index']);
    Route::get('/{id}', [PengumumanController::class, 'show']);
});

// Testimonials API Routes

// ADMS Fingerprint Machine Routes (tanpa middleware auth karena mesin yang push data)
Route::prefix('adms')->group(function () {
    // Endpoint utama untuk mesin Fingerspot JSON format
    Route::any('/capture/{any?}', [App\Http\Controllers\Api\AdmsController::class, 'capture'])->where('any', '.*');

    // Endpoint backup V1 (antisipasi)
    Route::any('/capture-v1/{any?}', [App\Http\Controllers\Api\AdmsController::class, 'captureV1'])->where('any', '.*');

    // Endpoint untuk mesin ZKTeco / Solution X100C (Plain Text ATTLOG format)
    Route::any('/x100c', [App\Http\Controllers\Api\AdmsController::class, 'receiveX100c']);

    // Endpoint debug: log raw data mentah dari mesin (tanpa proses apapun)
    Route::any('/raw-dump', [App\Http\Controllers\Api\AdmsController::class, 'rawDump']);
});

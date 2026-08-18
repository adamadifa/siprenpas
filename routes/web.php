<?php

use App\Http\Controllers\AgendakegiatanController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\AdminQuestionnaireController;
use App\Http\Controllers\AdminQuestionController;
use App\Http\Controllers\AsalsekolahController;
use App\Http\Controllers\BiayaController;
use App\Http\Controllers\ChecklistibadahController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartemenConroller;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\IzinabsenController;
use App\Http\Controllers\IzinsakitController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\JamkerjaController;
use App\Http\Controllers\JenjangPendidikanController;
use App\Http\Controllers\JenisbiayaController;
use App\Http\Controllers\PerlombaanController;
use App\Http\Controllers\JenispembiayaanController;
use App\Http\Controllers\JenissimpananController;
use App\Http\Controllers\JenistabunganController;
use App\Http\Controllers\JobdeskController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KategoriibadahController;
use App\Http\Controllers\KategoriledgerController;
use App\Http\Controllers\KategoripemasukanController;
use App\Http\Controllers\KategoripengeluaranController;
use App\Http\Controllers\KegiatanibadahController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\LaporankeuanganController;
use App\Http\Controllers\LaporankoperasiController;
use App\Http\Controllers\LaporanmsdmController;
use App\Http\Controllers\LedgerController;
use App\Http\Controllers\LedgertransaksiController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PembayaranpendidikanController;
use App\Http\Controllers\PembiayaanController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\PendaftaranGotTalentController;
use App\Http\Controllers\PendaftaranonlineController;
use App\Http\Controllers\PengajuanizinController;
use App\Http\Controllers\PengaturanUmumController;
use App\Http\Controllers\Permission_groupController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\PresensiSiswaController;
use App\Http\Controllers\PresensiMapelController;
use App\Http\Controllers\MigrasiSiswaController;
use App\Http\Controllers\PublicQuestionnaireController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgramkerjaController;
use App\Http\Controllers\RealisasikegiatanController;
use App\Http\Controllers\RegencyController;
use App\Http\Controllers\RencanasppController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SaldoawalledgerController;
use App\Http\Controllers\SimpananController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\SumberdanaController;
use App\Http\Controllers\TabunganController;
use App\Http\Controllers\TahunajaranController;
use App\Http\Controllers\TahunajaranppdbController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VillageController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\KategoriPengumumanController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\PrestasiSiswaController;
use App\Http\Controllers\ProgramUnggulanController;
use App\Http\Controllers\PilarPendidikanController;
use App\Http\Controllers\SebaranAlumniController;
use App\Http\Controllers\VisiMisiController;
use App\Http\Controllers\PpdbSettingController;
use App\Http\Controllers\PushSubscriptionController;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/




// Route::get('/', function () {
//     return view('welcome');
// });

// API Documentation
Route::get('/api-docs', function () {
    return view('api-docs');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');


// Route::middleware('guest')->group(function () {
//     Route::get('/', function () {
//         return view('auth.loginuser');
//     })->name('login');
// });


Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index')->middleware(['auth', 'verified']);
Route::get('/dashboard/guru', [DashboardController::class, 'guruDashboard'])->name('dashboard.guru')->middleware(['auth', 'verified']);
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Setings
    //Role
    Route::controller(DashboardController::class)->group(function () {
        Route::post('/dashboard/getrealisasikegiatan', 'getrealisasikegiatan')->name('dashboard.getrealisasikegiatan');
        Route::post('/dashboard/getagendakegiatan', 'getagendakegiatan')->name('dashboard.getagendakegiatan');
    });
    Route::middleware('role:super admin')->group(function () {
        Route::controller(RoleController::class)->group(function () {
            Route::get('/roles', 'index')->name('roles.index');
            Route::get('/roles/create', 'create')->name('roles.create');
            Route::post('/roles', 'store')->name('roles.store');
            Route::get('/roles/{id}/edit', 'edit')->name('roles.edit');
            Route::put('/roles/{id}/update', 'update')->name('roles.update');
            Route::delete('/roles/{id}/delete', 'destroy')->name('roles.delete');
            Route::get('/roles/{id}/createrolepermission', 'createrolepermission')->name('roles.createrolepermission');
            Route::post('/roles/{id}/storerolepermission', 'storerolepermission')->name('roles.storerolepermission');
        });
    });


    Route::controller(Permission_groupController::class)->group(function () {
        Route::get('/permissiongroups', 'index')->name('permissiongroups.index');
        Route::get('/permissiongroups/create', 'create')->name('permissiongroups.create');
        Route::post('/permissiongroups', 'store')->name('permissiongroups.store');
        Route::get('/permissiongroups/{id}/edit', 'edit')->name('permissiongroups.edit');
        Route::put('/permissiongroups/{id}/update', 'update')->name('permissiongroups.update');
        Route::delete('/permissiongroups/{id}/delete', 'destroy')->name('permissiongroups.delete');
    });


    Route::controller(PermissionController::class)->group(function () {
        Route::get('/permissions', 'index')->name('permissions.index');
        Route::get('/permissions/create', 'create')->name('permissions.create');
        Route::post('/permissions', 'store')->name('permissions.store');
        Route::get('/permissions/{id}/edit', 'edit')->name('permissions.edit');
        Route::put('/permissions/{id}/update', 'update')->name('permissions.update');
        Route::delete('/permissions/{id}/delete', 'destroy')->name('permissions.delete');
    });

    Route::middleware('role:super admin')->group(function () {
        Route::controller(UserController::class)->group(function () {
            Route::get('/users', 'index')->name('users.index');
            Route::get('/users/create', 'create')->name('users.create');
            Route::post('/users', 'store')->name('users.store');
            Route::get('/users/{id}/edit', 'edit')->name('users.edit');
            Route::put('/users/{id}/update', 'update')->name('users.update');
            Route::delete('/users/{id}/delete', 'destroy')->name('users.delete');

            Route::get('/users/{id}/editpassword', 'editpassword')->name('users.editpassword');
            Route::put('/users/{id}/updatepassword', 'updatepassword')->name('users.updatepassword');
        });
    });

    // Pengaturan Umum
    Route::controller(PengaturanUmumController::class)->group(function () {
        Route::get('/pengaturan-umum', 'index')->name('pengaturan-umum.index');
        Route::get('/pengaturan-umum/create', 'create')->name('pengaturan-umum.create');
        Route::post('/pengaturan-umum', 'store')->name('pengaturan-umum.store');
        Route::get('/pengaturan-umum/{id}', 'show')->name('pengaturan-umum.show');
        Route::get('/pengaturan-umum/{id}/edit', 'edit')->name('pengaturan-umum.edit');
        Route::put('/pengaturan-umum/{id}', 'update')->name('pengaturan-umum.update');
        Route::delete('/pengaturan-umum/{id}', 'destroy')->name('pengaturan-umum.destroy');
    });

    Route::controller(KaryawanController::class)->group(function () {
        Route::get('/karyawan', 'index')->name('karyawan.index')->can('karyawan.index');
        Route::get('/karyawan/create', 'create')->name('karyawan.create')->can('karyawan.create');
        Route::post('/karyawan', 'store')->name('karyawan.store')->can('karyawan.store');
        Route::get('/karyawan/{npp}/edit', 'edit')->name('karyawan.edit')->can('karyawan.edit');
        Route::get('/karyawan/{npp}/show', 'show')->name('karyawan.show')->can('karyawan.show');
        Route::put('/karyawan/{npp}/update', 'update')->name('karyawan.update')->can('karyawan.update');
        Route::delete('/karyawan/{npp}/delete', 'destroy')->name('karyawan.delete')->can('karyawan.delete');

        Route::get('/karyawan/{npp}/setharikerja', 'setharikerja')->name('karyawan.setharikerja');
        Route::put('/karyawan/{npp}/updateharikerja', 'updateharikerja')->name('karyawan.updateharikerja');
        Route::post('/karyawan/getjadwalkerja', 'getjadwalkerja')->name('karyawan.getjadwalkerja');
        Route::get('/karyawan/{npp}/setjamkerja', 'setjamkerja')->name('karyawan.setjamkerja');
        Route::post('/karyawan/{npp}/storejamkerjabyday', 'storejamkerjabyday')->name('karyawan.storejamkerjabyday');
        Route::post('/karyawan/storejamkerjabydate', 'storejamkerjabydate')->name('karyawan.storejamkerjabydate');
        Route::get('/karyawan/getjamkerjabydate', 'getjamkerjabydate')->name('karyawan.getjamkerjabydate');
        Route::post('/karyawan/getjamkerjabydate', 'getjamkerjabydate')->name('karyawan.getjamkerjabydate');
        Route::post('/karyawa/deletejamkerjabydate', 'deletejamkerjabydate')->name('karyawan.deletejamkerjabydate');

        Route::get('/karyawan/{npp}/createuser', 'createuser')->name('karyawan.createuser');
        Route::get('/karyawan/{npp}/resetuser', 'resetuser')->name('karyawan.resetuser');
        Route::get('/karyawan/{npp}/deleteuser', 'deleteuser')->name('karyawan.deleteuser');
        Route::get('/karyawan/{npp}/updatestatus', 'updatestatus')->name('karyawan.updatestatus');
        Route::get('/karyawan/get-by-unit', 'getKaryawanByUnit')->name('karyawan.get-by-unit');
    });

    Route::controller(SiswaController::class)->group(function () {
        Route::get('/siswa', 'index')->name('siswa.index')->can('siswa.index');
        Route::get('/siswa/create', 'create')->name('siswa.create')->can('siswa.create');
        Route::post('/siswa', 'store')->name('siswa.store')->can('siswa.store');
        Route::get('/siswa/{kode_siswa}/edit', 'edit')->name('siswa.edit')->can('siswa.edit');
        Route::get('/siswa/{kode_siswa}/show', 'show')->name('siswa.show')->can('siswa.show');
        Route::put('/siswa/{kode_siswa}/update', 'update')->name('siswa.update')->can('siswa.update');
        Route::delete('/siswa/{kode_siswa}/delete', 'destroy')->name('siswa.delete')->can('siswa.delete');

        Route::get('/siswa/{id_siswa}/getsiswa', 'getsiswa')->name('siswa.getsiswa');
    });

    Route::controller(JabatanController::class)->group(function () {
        Route::get('/jabatan', 'index')->name('jabatan.index')->can('jabatan.index');
        Route::get('/jabatan/create', 'create')->name('jabatan.create')->can('jabatan.create');
        Route::post('/jabatan', 'store')->name('jabatan.store')->can('jabatan.store');
        Route::get('/jabatan/{kode_jabatan}/edit', 'edit')->name('jabatan.edit')->can('jabatan.edit');
        Route::get('/jabatan/{kode_jabatan}/show', 'show')->name('jabatan.show')->can('jabatan.show');
        Route::put('/jabatan/{kode_jabatan}/update', 'update')->name('jabatan.update')->can('jabatan.update');
        Route::delete('/jabatan/{kode_jabatan}/delete', 'destroy')->name('jabatan.delete')->can('jabatan.delete');
    });

    Route::controller(UnitController::class)->group(function () {
        Route::get('/unit', 'index')->name('unit.index')->can('unit.index');
        Route::get('/unit/create', 'create')->name('unit.create')->can('unit.create');
        Route::post('/unit', 'store')->name('unit.store')->can('unit.store');
        Route::get('/unit/{kode_unit}/edit', 'edit')->name('unit.edit')->can('unit.edit');
        Route::get('/unit/{kode_unit}/show', 'show')->name('unit.show')->can('unit.show');
        Route::put('/unit/{kode_unit}/update', 'update')->name('unit.update')->can('unit.update');
        Route::delete('/unit/{kode_unit}/delete', 'destroy')->name('unit.delete')->can('unit.delete');

        //AJAX REQUEST
        Route::post('/unit/gettingkatbyunit', 'gettingkatbyunit')->name('unit.gettingkatbyunit');
        Route::post('/unit/getkelasbytingkat', 'getkelasbytingkat')->name('unit.getkelasbytingkat');
        Route::post('/unit/getgurubyunit', 'getgurubyunit')->name('unit.getgurubyunit');
    });

    Route::controller(JenjangPendidikanController::class)->group(function () {
        Route::get('/jenjang-pendidikan', 'index')->name('jenjang-pendidikan.index')->can('jenjangpendidikan.index');
        Route::get('/jenjang-pendidikan/create', 'create')->name('jenjang-pendidikan.create')->can('jenjangpendidikan.create');
        Route::post('/jenjang-pendidikan', 'store')->name('jenjang-pendidikan.store')->can('jenjangpendidikan.store');
        Route::get('/jenjang-pendidikan/{id}/edit', 'edit')->name('jenjang-pendidikan.edit')->can('jenjangpendidikan.edit');
        Route::put('/jenjang-pendidikan/{id}/update', 'update')->name('jenjang-pendidikan.update')->can('jenjangpendidikan.update');
        Route::delete('/jenjang-pendidikan/{id}/delete', 'destroy')->name('jenjang-pendidikan.delete')->can('jenjangpendidikan.delete');
    });

    Route::controller(PerlombaanController::class)->group(function () {
        Route::get('/perlombaan', 'index')->name('perlombaan.index')->can('perlombaan.index');
        Route::get('/perlombaan/create', 'create')->name('perlombaan.create')->can('perlombaan.create');
        Route::post('/perlombaan', 'store')->name('perlombaan.store')->can('perlombaan.store');
        Route::get('/perlombaan/{id}/edit', 'edit')->name('perlombaan.edit')->can('perlombaan.edit');
        Route::put('/perlombaan/{id}/update', 'update')->name('perlombaan.update')->can('perlombaan.update');
        Route::delete('/perlombaan/{id}/delete', 'destroy')->name('perlombaan.delete')->can('perlombaan.delete');
    });

    Route::controller(PendaftaranGotTalentController::class)->group(function () {
        Route::get('/pendaftaran-got-talent', 'index')->name('pendaftarangottalent.index')->can('pendaftarangottalent.index');
        Route::get('/pendaftaran-got-talent/export', 'export')->name('pendaftarangottalent.export')->can('pendaftarangottalent.index');
        Route::get('/pendaftaran-got-talent/create', 'create')->name('pendaftarangottalent.create')->can('pendaftarangottalent.create');
        Route::post('/pendaftaran-got-talent', 'store')->name('pendaftarangottalent.store')->can('pendaftarangottalent.store');
        Route::get('/pendaftaran-got-talent/detail-lomba/{id_lomba}', 'detailLomba')->name('pendaftarangottalent.detail-lomba')->can('pendaftarangottalent.index');
        Route::get('/pendaftaran-got-talent/{id}/show', 'show')->name('pendaftarangottalent.show')->can('pendaftarangottalent.index');
        Route::get('/pendaftaran-got-talent/{id}/edit', 'edit')->name('pendaftarangottalent.edit')->can('pendaftarangottalent.edit');
        Route::put('/pendaftaran-got-talent/{id}/update', 'update')->name('pendaftarangottalent.update')->can('pendaftarangottalent.update');
        Route::delete('/pendaftaran-got-talent/{id}/delete', 'destroy')->name('pendaftarangottalent.delete')->can('pendaftarangottalent.delete');
        Route::get('/pendaftaran-got-talent/{id}/createuser', 'createuser')->name('pendaftarangottalent.createuser')->can('pendaftarangottalent.index');
    });

    Route::controller(App\Http\Controllers\KonfirmasiPembayaranGotTalentController::class)->group(function () {
        Route::get('/konfirmasi-pembayaran-got-talent', 'index')->name('konfirmasi-pembayaran-got-talent.index')->can('pendaftarangottalent.index');
        Route::get('/konfirmasi-pembayaran-got-talent/{id}/show', 'show')->name('konfirmasi-pembayaran-got-talent.show')->can('pendaftarangottalent.index');
        Route::put('/konfirmasi-pembayaran-got-talent/{id}/update-status', 'updateStatus')->name('konfirmasi-pembayaran-got-talent.update-status')->can('pendaftarangottalent.index');
    });

    Route::controller(\App\Http\Controllers\GalleryAlbumController::class)->group(function () {
        Route::get('/gallery', 'index')->name('gallery.index');
        Route::get('/gallery/create', 'create')->name('gallery.create');
        Route::post('/gallery', 'store')->name('gallery.store');
        Route::get('/gallery/{gallery}/edit', 'edit')->name('gallery.edit');
        Route::put('/gallery/{gallery}', 'update')->name('gallery.update');
        Route::delete('/gallery/{gallery}', 'destroy')->name('gallery.destroy');
        Route::get('/gallery/{gallery}', 'show')->name('gallery.show');
        Route::post('/gallery/{gallery}/photos', 'uploadPhoto')->name('gallery.photos.upload');
        Route::delete('/gallery/{gallery}/photos/{photo}', 'destroyPhoto')->name('gallery.photos.destroy');
    });

    Route::controller(DepartemenConroller::class)->group(function () {
        Route::get('/departemen', 'index')->name('departemen.index')->can('departemen.index');
        Route::get('/departemen/create', 'create')->name('departemen.create')->can('departemen.create');
        Route::post('/departemen', 'store')->name('departemen.store')->can('departemen.store');
        Route::get('/departemen/{kode_dept}/edit', 'edit')->name('departemen.edit')->can('departemen.edit');
        Route::put('/departemen/{kode_dept}/update', 'update')->name('departemen.update')->can('departemen.update');
        Route::delete('/departemen/{kode_dept}/delete', 'destroy')->name('departemen.delete')->can('departemen.delete');
    });

    Route::controller(LedgerController::class)->group(function () {
        Route::get('/ledger', 'index')->name('ledger.index')->can('ledger.index');
        Route::get('/ledger/create', 'create')->name('ledger.create')->can('ledger.create');
        Route::post('/ledger', 'store')->name('ledger.store')->can('ledger.store');
        Route::get('/ledger/{kode_ledger}/edit', 'edit')->name('ledger.edit')->can('ledger.edit');
        Route::get('/ledger/{kode_ledger}/show', 'show')->name('ledger.show')->can('ledger.show');
        Route::put('/ledger/{kode_ledger}/update', 'update')->name('ledger.update')->can('ledger.update');
        Route::delete('/ledger/{kode_ledger}/delete', 'destroy')->name('ledger.delete')->can('ledger.delete');
    });

    Route::controller(LedgertransaksiController::class)->group(function () {
        Route::get('/ledgertransaksi', 'index')->name('ledgertransaksi.index')->can('ledgertransaksi.index');
        Route::get('/ledgertransaksi/create', 'create')->name('ledgertransaksi.create')->can('ledgertransaksi.create');
        Route::post('/ledgertransaksi', 'store')->name('ledgertransaksi.store')->can('ledgertransaksi.store');
        Route::get('/ledgertransaksi/{kode_ledgertransaksi}/edit', 'edit')->name('ledgertransaksi.edit')->can('ledgertransaksi.edit');
        Route::get('/ledgertransaksi/{kode_ledgertransaksi}/show', 'show')->name('ledgertransaksi.show')->can('ledgertransaksi.show');
        Route::put('/ledgertransaksi/{kode_ledgertransaksi}/update', 'update')->name('ledgertransaksi.update')->can('ledgertransaksi.update');
        Route::delete('/ledgertransaksi/{kode_ledgertransaksi}/delete', 'destroy')->name('ledgertransaksi.delete')->can('ledgertransaksi.delete');
    });

    Route::controller(KategoriledgerController::class)->group(function () {
        Route::get('/kategoriledger', 'index')->name('kategoriledger.index')->can('kategoriledger.index');
        Route::get('/kategoriledger/create', 'create')->name('kategoriledger.create')->can('kategoriledger.create');
        Route::post('/kategoriledger', 'store')->name('kategoriledger.store')->can('kategoriledger.store');
        Route::get('/kategoriledger/{id}/edit', 'edit')->name('kategoriledger.edit')->can('kategoriledger.edit');
        Route::get('/kategoriledger/{id}/show', 'show')->name('kategoriledger.show')->can('kategoriledger.show');
        Route::put('/kategoriledger/{id}/update', 'update')->name('kategoriledger.update')->can('kategoriledger.update');
        Route::delete('/kategoriledger/{id}/delete', 'destroy')->name('kategoriledger.delete')->can('kategoriledger.delete');

        Route::post('/kategoriledger/getkategoriledger', 'getkategoriledger')->name('kategoriledger.getkategoriledger');
    });

    Route::controller(SaldoawalledgerController::class)->group(function () {
        Route::get('/saldoawalledger', 'index')->name('saldoawalledger.index')->can('saldoawalledger.index');
        Route::get('/saldoawalledger/create', 'create')->name('saldoawalledger.create')->can('saldoawalledger.create');
        Route::post('/saldoawalledger', 'store')->name('saldoawalledger.store')->can('saldoawalledger.store');
        Route::get('/saldoawalledger/{kode_saldoawal}/edit', 'edit')->name('saldoawalledger.edit')->can('saldoawalledger.edit');
        Route::get('/saldoawalledger/{kode_saldoawal}/show', 'show')->name('saldoawalledger.show')->can('saldoawalledger.show');
        Route::put('/saldoawalledger/{kode_saldoawal}/update', 'update')->name('saldoawalledger.update')->can('saldoawalledger.update');
        Route::delete('/saldoawalledger/{kode_saldoawal}/delete', 'destroy')->name('saldoawalledger.delete')->can('saldoawalledger.delete');

        Route::post('/saldoawalledger/getsaldo', 'getsaldo')->name('saldoawalledger.getsaldo')->can('saldoawalledger.create');
    });

    Route::controller(JobdeskController::class)->group(function () {
        Route::get('/jobdesk', 'index')->name('jobdesk.index')->can('jobdesk.index');
        Route::get('/jobdesk/create', 'create')->name('jobdesk.create')->can('jobdesk.create');
        Route::post('/jobdesk', 'store')->name('jobdesk.store')->can('jobdesk.store');
        Route::get('/jobdesk/{kode_jobdesk}/edit', 'edit')->name('jobdesk.edit')->can('jobdesk.edit');
        Route::get('/jobdesk/{kode_jobdesk}/show', 'show')->name('jobdesk.show')->can('jobdesk.show');
        Route::put('/jobdesk/{kode_jobdesk}/update', 'update')->name('jobdesk.update')->can('jobdesk.update');
        Route::delete('/jobdesk/{kode_jobdesk}/delete', 'destroy')->name('jobdesk.delete')->can('jobdesk.delete');

        Route::get('/jobdesk/getjobdesk', 'getjobdesk')->name('jobdesk.getjobdesk');
        Route::post('/jobdesk/getjobdesklist', 'getjobdesklist')->name('jobdesk.getjobdesklist');
    });

    Route::controller(RealisasikegiatanController::class)->group(function () {
        Route::get('/realisasikegiatan', 'index')->name('realisasikegiatan.index')->can('realkegiatan.index');
        Route::get('/realisasikegiatan/create', 'create')->name('realisasikegiatan.create')->can('realkegiatan.create');
        Route::post('/realisasikegiatan', 'store')->name('realisasikegiatan.store')->can('realkegiatan.store');
        Route::get('/realisasikegiatan/{id}/edit', 'edit')->name('realisasikegiatan.edit')->can('realkegiatan.edit');
        Route::get('/realisasikegiatan/show/{id}', 'show')->name('realisasikegiatan.show')->can('realkegiatan.create');
        Route::put('/realisasikegiatan/{id}/update', 'update')->name('realisasikegiatan.update')->can('realkegiatan.update');
        Route::delete('/realisasikegiatan/{id}/delete', 'destroy')->name('realisasikegiatan.delete')->can('realkegiatan.delete');

        Route::post('/realisasikegiatan/getrealisasikegiatan', 'getrealisasikegiatan')->name('realisasikegiatan.getrealisasikegiatan');
        Route::get('/realisasikegiatan/{id}/takepicture', 'takepicture')->name('realisasikegiatan.takepicture');
        Route::post('/realisasikegiatan/storepicture', 'storepicture')->name('realisasikegiatan.storepicture');
    });

    Route::controller(AgendakegiatanController::class)->group(function () {
        Route::get('/agendakegiatan', 'index')->name('agendakegiatan.index')->can('agendakegiatan.index');
        Route::get('/agendakegiatan/create', 'create')->name('agendakegiatan.create')->can('agendakegiatan.create');
        Route::post('/agendakegiatan', 'store')->name('agendakegiatan.store')->can('agendakegiatan.store');
        Route::get('/agendakegiatan/{id}/edit', 'edit')->name('agendakegiatan.edit')->can('agendakegiatan.edit');
        Route::get('/agendakegiatan/show/{id}', 'show')->name('agendakegiatan.show')->can('agendakegiatan.create');
        Route::put('/agendakegiatan/{id}/update', 'update')->name('agendakegiatan.update')->can('agendakegiatan.update');
        Route::delete('/agendakegiatan/{id}/delete', 'destroy')->name('agendakegiatan.delete')->can('agendakegiatan.delete');

        Route::post('/agendakegiatan/getagendakegiatan', 'getagendakegiatan')->name('agendakegiatan.getagendakegiatan');
    });


    Route::controller(JenisbiayaController::class)->group(function () {
        Route::get('/jenisbiaya', 'index')->name('jenisbiaya.index')->can('jenisbiaya.index');
        Route::get('/jenisbiaya/create', 'create')->name('jenisbiaya.create')->can('jenisbiaya.create');
        Route::post('/jenisbiaya', 'store')->name('jenisbiaya.store')->can('jenisbiaya.store');
        Route::get('/jenisbiaya/{kode_jenis_biaya}/edit', 'edit')->name('jenisbiaya.edit')->can('jenisbiaya.edit');
        Route::put('/jenisbiaya/{kode_jenis_biaya}/update', 'update')->name('jenisbiaya.update')->can('jenisbiaya.update');
        Route::delete('/jenisbiaya/{kode_jenis_biaya}/delete', 'destroy')->name('jenisbiaya.delete')->can('jenisbiaya.delete');
    });


    Route::controller(KelasController::class)->group(function () {
        Route::get('/kelas', 'index')->name('kelas.index')->can('kelas.index');
        Route::get('/kelas/create', 'create')->name('kelas.create')->can('kelas.create');
        Route::post('/kelas', 'store')->name('kelas.store')->can('kelas.create');
        Route::get('/kelas/{kode_kelas}/edit', 'edit')->name('kelas.edit')->can('kelas.edit');
        Route::get('/kelas/{kode_kelas}/setkelas', 'setkelas')->name('kelas.setkelas')->can('kelas.edit');
        Route::get('/kelas/{kode_kelas}/tambahsiswa', 'tambahsiswa')->name('kelas.tambahsiswa')->can('kelas.edit');
        Route::post('/kelas/storetambahsiswa', 'storetambahsiswa')->name('kelas.storetambahsiswa')->can('kelas.edit');
        Route::post('/kelas/deletesiswa', 'deletesiswa')->name('kelas.deletesiswa')->can('kelas.edit');
        Route::put('/kelas/{kode_kelas}/update', 'update')->name('kelas.update')->can('kelas.edit');
        Route::post('/kelas/getsiswa', 'getsiswa')->name('kelas.getsiswa');
        Route::post('/kelas/getkelassiswa', 'getkelassiswa')->name('kelas.getkelassiswa');
        Route::post('/kelas/deletekelassiswa', 'deletekelassiswa')->name('kelas.deletekelassiswa');
        Route::delete('/kelas/{kode_kelas}/delete', 'destroy')->name('kelas.delete')->can('kelas.delete');
    });


    Route::controller(ProgramkerjaController::class)->group(function () {
        Route::get('/programkerja', 'index')->name('programkerja.index')->can('programkerja.index');
        Route::get('/programkerja/create', 'create')->name('programkerja.create')->can('programkerja.create');
        Route::post('/programkerja', 'store')->name('programkerja.store')->can('programkerja.create');
        Route::get('/programkerja/{kode_program_kerja}/edit', 'edit')->name('programkerja.edit')->can('programkerja.edit');
        Route::get('/programkerja/{kode_program_kerja}/show', 'show')->name('programkerja.show')->can('programkerja.index');
        Route::put('/programkerja/{kode_program_kerja}/update', 'update')->name('programkerja.update')->can('programkerja.edit');
        Route::delete('/programkerja/{kode_program_kerja}/delete', 'destroy')->name('programkerja.delete')->can('programkerja.delete');

        Route::get('/programkerja/getprogramkerja', 'getprogramkerja')->name('programkerja.getprogramkerja');
        Route::post('/programkerja/getprogramkerjalist', 'getprogramkerjalist')->name('programkerja.getprogramkerjalist');
    });



    Route::controller(BiayaController::class)->group(function () {
        Route::get('/biaya', 'index')->name('biaya.index')->can('biaya.index');
        Route::get('/biaya/create', 'create')->name('biaya.create')->can('biaya.create');
        Route::post('/biaya', 'store')->name('biaya.store')->can('biaya.store');
        Route::get('/biaya/{kode_biaya}/edit', 'edit')->name('biaya.edit')->can('biaya.edit');
        Route::get('/biaya/{kode_biaya}/show', 'show')->name('biaya.show')->can('biaya.show');
        Route::put('/biaya/{kode_biaya}/update', 'update')->name('biaya.update')->can('biaya.update');
        Route::delete('/biaya/{kode_biaya}/delete', 'destroy')->name('biaya.delete')->can('biaya.delete');
    });


    //Konfigurasi

    Route::controller(JamkerjaController::class)->group(function () {
        Route::get('/jamkerja', 'index')->name('jamkerja.index')->can('jamkerja.index');
        Route::get('/jamkerja/create', 'create')->name('jamkerja.create')->can('jamkerja.create');
        Route::post('/jamkerja', 'store')->name('jamkerja.store')->can('jamkerja.store');
        Route::get('/jamkerja/{kode_jamkerja}/edit', 'edit')->name('jamkerja.edit')->can('jamkerja.edit');
        Route::get('/jamkerja/{kode_jamkerja}/show', 'show')->name('jamkerja.show')->can('jamkerja.show');
        Route::put('/jamkerja/{kode_jamkerja}/update', 'update')->name('jamkerja.update')->can('jamkerja.update');
        Route::delete('/jamkerja/{kode_jamkerja}/delete', 'destroy')->name('jamkerja.delete')->can('jamkerja.delete');
    });


    Route::controller(TahunajaranController::class)->group(function () {
        Route::get('/tahunajaran', 'index')->name('tahunajaran.index')->can('tahunajaran.index');
        Route::get('/tahunajaran/create', 'create')->name('tahunajaran.create')->can('tahunajaran.create');
        Route::post('/tahunajaran', 'store')->name('tahunajaran.store')->can('tahunajaran.store');
        Route::get('/tahunajaran/{kode_ta}/edit', 'edit')->name('tahunajaran.edit')->can('tahunajaran.edit');
        Route::get('/tahunajaran/{kode_ta}/show', 'show')->name('tahunajaran.show')->can('tahunajaran.show');
        Route::put('/tahunajaran/{kode_ta}/update', 'update')->name('tahunajaran.update')->can('tahunajaran.update');
        Route::delete('/tahunajaran/{kode_ta}/delete', 'destroy')->name('tahunajaran.delete')->can('tahunajaran.delete');
        Route::get('/tahunajaran/{id}/setsemester', 'setSemester')->name('tahunajaran.setsemester')->can('tahunajaran.index');
    });

    Route::controller(TahunajaranppdbController::class)->group(function () {
        Route::get('/tahunajaranppdb', 'index')->name('tahunajaranppdb.index')->can('tahunajaranppdb.index');
        Route::get('/tahunajaranppdb/create', 'create')->name('tahunajaranppdb.create')->can('tahunajaranppdb.create');
        Route::post('/tahunajaranppdb', 'store')->name('tahunajaranppdb.store')->can('tahunajaranppdb.create');
        Route::get('/tahunajaranppdb/{kode_ta_ppdb}/edit', 'edit')->name('tahunajaranppdb.edit')->can('tahunajaranppdb.edit');
        Route::get('/tahunajaranppdb/{kode_ta_ppdb}/show', 'show')->name('tahunajaranppdb.show')->can('tahunajaranppdb.show');
        Route::put('/tahunajaranppdb/{kode_ta_ppdb}/update', 'update')->name('tahunajaranppdb.update')->can('tahunajaranppdb.edit');
        Route::delete('/tahunajaranppdb/{kode_ta_ppdb}/delete', 'destroy')->name('tahunajaranppdb.delete')->can('tahunajaranppdb.delete');
    });

    // Mesin Fingerprint
    Route::controller(App\Http\Controllers\MesinFingerprintController::class)->group(function () {
        Route::get('/mesinfingerprint', 'index')->name('mesinfingerprint.index');
        Route::get('/mesinfingerprint/create', 'create')->name('mesinfingerprint.create');
        Route::post('/mesinfingerprint', 'store')->name('mesinfingerprint.store');
        Route::get('/mesinfingerprint/{id}/edit', 'edit')->name('mesinfingerprint.edit');
        Route::put('/mesinfingerprint/{id}/update', 'update')->name('mesinfingerprint.update');
        Route::delete('/mesinfingerprint/{id}/delete', 'destroy')->name('mesinfingerprint.delete');
        Route::get('/mesinfingerprint/logmesin', 'logmesin')->name('mesinfingerprint.logmesin');
    });

    Route::controller(PendaftaranController::class)->group(function () {
        Route::get('/pendaftaran/{no_pendaftaran}/cetakpdf', 'cetakpdf')->name('pendaftaran.cetakpdf')->can('pendaftaran.show');
        Route::get('/pendaftaran/{no_pendaftaran}/cetak-id-card', 'cetakIdCard')->name('pendaftaran.cetak-id-card')->can('pendaftaran.show');
        Route::get('/pendaftaran', 'index')->name('pendaftaran.index')->can('pendaftaran.index');
        Route::get('/pendaftaran/export', 'export')->name('pendaftaran.export')->can('pendaftaran.index');
        Route::get('/pendaftaran/create', 'create')->name('pendaftaran.create')->can('pendaftaran.create');
        Route::post('/pendaftaran', 'store')->name('pendaftaran.store')->can('pendaftaran.store');
        Route::post('/pendaftaran/uploaddokumen', 'storedokumen')->name('pendaftaran.storedokumen')->can('pendaftaran.store');
        Route::get('/pendaftaran/{no_pendaftaran}/edit', 'edit')->name('pendaftaran.edit')->can('pendaftaran.edit');
        Route::get('/pendaftaran/{no_pendaftaran}/cetak', 'cetak')->name('pendaftaran.cetak')->can('pendaftaran.show');
        Route::get('/pendaftaran/{no_pendaftaran}/show', 'show')->name('pendaftaran.show')->can('pendaftaran.show');
        Route::put('/pendaftaran/{no_pendaftaran}/update', 'update')->name('pendaftaran.update')->can('pendaftaran.update');
        Route::get('/pendaftaran/{no_pendaftaran}/getdokumen', 'getdokumen')->name('pendaftaran.getdokumen')->can('pendaftaran.show');
        Route::delete('/pendaftaran/{no_pendaftaran}/delete', 'destroy')->name('pendaftaran.delete')->can('pendaftaran.delete');
        Route::post('/pendaftaran/deletedokumen', 'deletedokumen')->name('pendaftaran.deletedokumen')->can('pendaftaran.delete');
        Route::post('/pendaftaran/{no_pendaftaran}/update-rfid', 'updateRfid')->name('pendaftaran.update-rfid')->can('pendaftaran.edit');

        Route::get('/pendaftaran/getsiswa', 'getsiswa')->name('pendaftaran.getsiswa');
    });


    Route::controller(PendaftaranonlineController::class)->group(function () {
        Route::get('/pendaftaranonline', 'index')->name('pendaftaranonline.index')->can('pendaftaranonline.index');
        Route::get('/pendaftaranonline/export', 'export')->name('pendaftaranonline.export')->can('pendaftaranonline.index');
        Route::get('/pendaftaranonline/{no_register}/show', 'show')->name('pendaftaranonline.show')->can('pendaftaranonline.show');
        Route::get('/pendaftaranonline/{no_register}/edit', 'edit')->name('pendaftaranonline.edit')->can('pendaftaranonline.edit');
        Route::post('/pendaftaranonline/update', 'update')->name('pendaftaranonline.update')->can('pendaftaranonline.edit');
        Route::delete('/pendaftaranonline/{no_register}/delete', 'destroy')->name('pendaftaranonline.delete')->can('pendaftaranonline.delete');
        Route::get('pendaftaranonline/cetak/{no_register}', 'cetak')->name('pendaftaranonline.cetak');
        Route::post('pendaftaranonline/{no_register}/konfirmasi', 'konfirmasiPembayaran')->name('pendaftaranonline.konfirmasi');
        Route::post('pendaftaranonline/{no_register}/cancel', 'cancel')->name('pendaftaranonline.cancel');
    });

    Route::controller(PushSubscriptionController::class)->group(function () {
        Route::get('/push-subscriptions', 'index')->name('push-subscriptions.index');
        Route::get('/push-subscriptions/{pushSubscription}/test', 'test')->name('push-subscriptions.test');
        Route::delete('/push-subscriptions/{pushSubscription}', 'destroy')->name('push-subscriptions.destroy');
    });

    Route::controller(PembayaranpendidikanController::class)->group(function () {
        Route::get('/pembayaranpendidikan', 'index')->name('pembayaranpendidikan.index')->can('pembayaranpdd.index');
        Route::get('/pembayaranpendidikan/{no_pendaftaran}/show', 'show')->name('pembayaranpendidikan.show')->can('pembayaranpdd.show');
        Route::get('/pembayaranpendidikan/{no_pendaftaran}/getbiaya', 'getbiaya')->name('pembayaranpendidikan.getbiaya')->can('pembayaranpdd.show');
        Route::get('/pembayaranpendidikan/{no_pendaftaran}/{kode_jenis_biaya}/{kode_biaya}/inputpotongan', 'createpotongan')->name('pembayaranpendidikan.createpotongan')->can('pembayaranpdd.create');
        Route::post('/pembayaranpendidikan/storepotongan', 'storepotongan')->name('pembayaranpendidikan.storepotongan')->can('pembayaranpdd.create');
        Route::get('/pembayaranpendidikan/{no_pendaftaran}/{kode_jenis_biaya}/{kode_biaya}/inputmutasi', 'createmutasi')->name('pembayaranpendidikan.createmnutasi')->can('pembayaranpdd.create');
        Route::post('/pembayaranpendidikan/storemutasi', 'storemutasi')->name('pembayaranpendidikan.storemutasi')->can('pembayaranpdd.create');
        Route::get('/pembayaranpendidikan/{no_pendaftaran}/create', 'create')->name('pembayaranpendidikan.create')->can('pembayaranpdd.create');
        Route::post('/pembayaranpendidikan/store', 'store')->name('pembayaranpendidikan.store')->can('pembayaranpdd.create');
        Route::get('/pembayaranpendidikan/{no_pendaftaran}/gethistoribayar', 'gethistoribayar')->name('pembayaranpendidikan.gethistoribayar')->can('pembayaranpdd.create');
        Route::post('/pembayaranpendidikan/delete', 'destroy')->name('pembayaranpendidikan.delete')->can('pembayaranpdd.delete');
        Route::post('/pembayaranpendidikan/getsisatagihan', 'getsisatagihan')->name('pembayaranpendidikan.getsisatagihan')->can('pembayaranpdd.create');
        Route::get('/pembayaranpendidikan/{no_bukti}/showdetailbayar', 'showdetailbayar')->name('pembayaranpendidikan.showdetailbayar')->can('pembayaranpdd.show');
        Route::get('/pembayaranpendidikan/{no_bukti}/cetak', 'cetak')->name('pembayaranpendidikan.cetak')->can('pembayaranpdd.show');
        Route::get('/pembayaranpendidikan/{no_pendaftaran}/prosesnaikkelas', 'prosesnaikkelas')->name('pembayaranpendidikan.prosesnaikkelas')->can('pembayaranpdd.create');
        Route::get('/pembayaranpendidikan/{no_pendaftaran}/cekbiayanext', 'cekbiayanext')->name('pembayaranpendidikan.cekbiayanext')->can('pembayaranpdd.create');
        Route::post('/pembayaranpendidikan/{no_pendaftaran}/simpannaikkelas', 'simpannaikkelas')->name('pembayaranpendidikan.simpannaikkelas')->can('pembayaranpdd.create');
        Route::get('/pembayaranpendidikan/{no_pendaftaran}/batalkannaikkelas', 'batalkannaikkelas')->name('pembayaranpendidikan.batalkannaikkelas')->can('pembayaranpdd.create');
        Route::post('/pembayaranpendidikan/bulknaikkelas', 'bulknaikkelas')->name('pembayaranpendidikan.bulknaikkelas')->can('pembayaranpdd.create');

        Route::post('/pembayaranpendidikan/{no_pendaftaran}/proses-keluar', 'prosesKeluar')->name('pembayaranpendidikan.proseskeluar')->can('pembayaranpdd.create');
        Route::post('/pembayaranpendidikan/{no_pendaftaran}/batalkan-keluar', 'batalkanKeluar')->name('pembayaranpendidikan.batalkankeluar')->can('pembayaranpdd.create');
        Route::get('/pembayaranpendidikan/{no_pendaftaran}/{kode_biaya}/editbiaya', 'editbiaya')->name('pembayaranpendidikan.editbiaya')->can('pembayaranpdd.create');
        Route::post('/pembayaranpendidikan/updatebiaya', 'updatebiaya')->name('pembayaranpendidikan.updatebiaya')->can('pembayaranpdd.create');
    });

    Route::controller(RencanasppController::class)->group(function () {
        Route::get('/rencanaspp', 'index')->name('rencanaspp.index')->can('rencanaspp.index');
        Route::get('/rencanaspp/{no_pendaftaran}/create', 'create')->name('rencanaspp.create')->can('rencanaspp.create');
        Route::get('/rencanaspp/{no_pendaftaran}/getrencanaspp', 'getrencanaspp')->name('rencanaspp.getrencanaspp')->can('rencanaspp.create');
        Route::post('/rencanaspp', 'store')->name('rencanaspp.store')->can('rencanaspp.create');
        Route::get('/rencanaspp/{kode_rencana_spp}/edit', 'edit')->name('rencanaspp.edit')->can('rencanaspp.edit');
        Route::post('/rencanaspp/update', 'update')->name('rencanaspp.update')->can('rencanaspp.edit');

        Route::post('/rencanaspp/getspp', 'getspp')->name('rencanaspp.getspp')->can('rencanaspp.create');
    });

    Route::controller(RegencyController::class)->group(function () {
        Route::post('/regency/getregencybyprovince', 'getregencybyprovince')->name('regency.getregencybyprovince');
    });
    Route::controller(DistrictController::class)->group(function () {
        Route::post('/district/getdistrictbyregency', 'getdistrictbyregency')->name('regency.getdistrictbyregency');
    });

    Route::controller(VillageController::class)->group(function () {
        Route::post('/village/getvillagebydistrict', 'getvillagebydistrict')->name('regency.getvillagebydistrict');
    });

    Route::controller(AsalsekolahController::class)->group(function () {
        Route::get('/asalsekolah', 'index')->name('asalsekolah.index')->can('asalsekolah.index');
        Route::get('/asalsekolah/create', 'create')->name('asalsekolah.create')->can('asalsekolah.create');
        Route::post('/asalsekolah', 'store')->name('asalsekolah.store')->can('asalsekolah.store');
        Route::get('/asalsekolah/{kode_asalsekolah}/edit', 'edit')->name('asalsekolah.edit')->can('asalsekolah.edit');
        Route::get('/asalsekolah/{kode_asalsekolah}/show', 'show')->name('asalsekolah.show')->can('asalsekolah.show');
        Route::put('/asalsekolah/{kode_asalsekolah}/update', 'update')->name('asalsekolah.update')->can('asalsekolah.update');
        Route::delete('/asalsekolah/{kode_asalsekolah}/delete', 'destroy')->name('asalsekolah.delete')->can('asalsekolah.delete');

        Route::get('/asalsekolah/{kode_unit}/{kode_asal_sekolah}/getasalsekolahbyunit', 'getasalsekolahbyunit')->name('asalsekolah.getasalsekolahbyunit');
    });


    //Koperasi

    Route::controller(AnggotaController::class)->group(function () {
        Route::get('/anggota', 'index')->name('anggota.index')->can('anggota.index');
        Route::get('/anggota{id}/show', 'show')->name('anggota.show')->can('anggota.index');
        Route::get('/anggota/create', 'create')->name('anggota.create')->can('anggota.create');
        Route::post('/anggota', 'store')->name('anggota.store')->can('anggota.create');
        Route::get('/anggota/{id}/edit', 'edit')->name('anggota.edit')->can('anggota.edit');
        Route::put('/anggota/{id}/update', 'update')->name('anggota.update')->can('anggota.edit');
        Route::delete('/anggota/{id}/delete', 'destroy')->name('anggota.delete')->can('anggota.delete');

        Route::get('/anggota/{no_anggota}/getanggota', 'getanggota')->name('anggota.getanggota');

        // Routes untuk fitur hubungkan siswa
        Route::get('/anggota/get-siswa-options', 'getSiswaOptions')->name('anggota.get-siswa-options');
        Route::get('/anggota/get-siswa-terhubung/{no_anggota}', 'getSiswaTerhubung')->name('anggota.get-siswa-terhubung');
        Route::post('/anggota/hubungkan-siswa', 'hubungkanSiswa')->name('anggota.hubungkan-siswa');
        Route::post('/anggota/hapus-hubungan-siswa', 'hapusHubunganSiswa')->name('anggota.hapus-hubungan-siswa');

        // Routes untuk fitur hubungkan karyawan
        Route::get('/anggota/get-karyawan-options', 'getKaryawanOptions')->name('anggota.get-karyawan-options');
        Route::get('/anggota/get-karyawan-terhubung/{no_anggota}', 'getKaryawanTerhubung')->name('anggota.get-karyawan-terhubung');
        Route::post('/anggota/hubungkan-karyawan', 'hubungkanKaryawan')->name('anggota.hubungkan-karyawan');
        Route::post('/anggota/hapus-hubungan-karyawan', 'hapusHubunganKaryawan')->name('anggota.hapus-hubungan-karyawan');
    });

    Route::controller(JenissimpananController::class)->group(function () {
        Route::get('/jenissimpanan', 'index')->name('jenissimpanan.index')->can('jenissimpanan.index');
        Route::get('/jenissimpanan/create', 'create')->name('jenissimpanan.create')->can('jenissimpanan.create');
        Route::post('/jenissimpanan', 'store')->name('jenissimpanan.store')->can('jenissimpanan.store');
        Route::get('/jenissimpanan/{kode_simpanan}/edit', 'edit')->name('jenissimpanan.edit')->can('jenissimpanan.edit');
        Route::put('/jenissimpanan/{kode_simpanan}/update', 'update')->name('jenissimpanan.update')->can('jenissimpanan.update');
        Route::delete('/jenissimpanan/{kode_simpanan}/delete', 'destroy')->name('jenissimpanan.delete')->can('jenissimpanan.delete');
    });

    Route::controller(JenistabunganController::class)->group(function () {
        Route::get('/jenistabungan', 'index')->name('jenistabungan.index')->can('jenistabungan.index');
        Route::get('/jenistabungan/create', 'create')->name('jenistabungan.create')->can('jenistabungan.create');
        Route::post('/jenistabungan', 'store')->name('jenistabungan.store')->can('jenistabungan.store');
        Route::get('/jenistabungan/{kode_tabungan}/edit', 'edit')->name('jenistabungan.edit')->can('jenistabungan.edit');
        Route::put('/jenistabungan/{kode_tabungan}/update', 'update')->name('jenistabungan.update')->can('jenistabungan.update');
        Route::delete('/jenistabungan/{kode_tabungan}/delete', 'destroy')->name('jenistabungan.delete')->can('jenistabungan.delete');
    });

    Route::controller(JenispembiayaanController::class)->group(function () {
        Route::get('/jenispembiayaan', 'index')->name('jenispembiayaan.index')->can('jenispembiayaan.index');
        Route::get('/jenispembiayaan/create', 'create')->name('jenispembiayaan.create')->can('jenispembiayaan.create');
        Route::post('/jenispembiayaan', 'store')->name('jenispembiayaan.store')->can('jenispembiayaan.store');
        Route::get('/jenispembiayaan/{kode_pembiayaan}/edit', 'edit')->name('jenispembiayaan.edit')->can('jenispembiayaan.edit');
        Route::put('/jenispembiayaan/{kode_pembiayaan}/update', 'update')->name('jenispembiayaan.update')->can('jenispembiayaan.update');
        Route::delete('/jenispembiayaan/{kode_pembiayaan}/delete', 'destroy')->name('jenispembiayaan.delete')->can('jenispembiayaan.delete');
    });

    Route::controller(SimpananController::class)->group(function () {
        Route::get('/simpanan', 'index')->name('simpanan.index')->can('simpanan.index');
        Route::get('/simpanan/{no_anggota}/show', 'show')->name('simpanan.show')->can('simpanan.index');
        
        // Employee Dedicated Savings Routes
        Route::get('/simpanansaya', 'simpanansaya')->name('simpanan.simpanansaya');
        Route::get('/simpanansaya/mutasi/{kode_simpanan}', 'mutasisimpanan')->name('simpanan.mutasisimpanan');
        
        Route::get('/simpanan/{no_anggota}/{jenis_transaksi}/create', 'create')->name('simpanan.create')->can('simpanan.create');
        Route::post('/simpanan/{no_anggota}/{jenis_transaksi}/store', 'store')->name('simpanan.store')->can('simpanan.store');
        Route::get('/simpanan/{no_transaksi}/edit', 'edit')->name('simpanan.edit')->can('simpanan.edit');
        Route::put('/simpanan/{no_transaksi}/update', 'update')->name('simpanan.update')->can('simpanan.update');
        Route::delete('/simpanan/{no_transaksi}/delete', 'destroy')->name('simpanan.delete')->can('simpanan.delete');
        Route::get('/simpanan/{no_transaksi}/cetak', 'cetakkwitansi')->name('simpanan.cetakkwitansi')->can('simpanan.create');


        Route::get('/simpanan/{kode_simpanan}/mutasi', 'mutasi')->name('simpanan.mutasi')->can('simpanan.index');
        Route::get('/simpanan/{npp}/showmobile', 'showmobile')->name('simpanan.showmobile')->can('simpanan.index');
    });

    Route::controller(TabunganController::class)->group(function () {
        Route::get('/tabungan', 'index')->name('tabungan.index')->can('tabungan.index');
        Route::get('/tabungan/{no_rekening}/{jenis_transaksi}/create', 'create')->name('tabungan.create')->can('tabungan.create');
        Route::get('/tabungan/{no_rekening}/show', 'show')->name('tabungan.show')->can('simpanan.create');
        Route::post('/tabungan/{no_rekening}/{jenis_transaksi}/store', 'store')->name('tabungan.store')->can('tabungan.create');
        Route::get('/tabungan/{no_rekening}/edit', 'edit')->name('tabungan.edit')->can('tabungan.edit');
        Route::put('/tabungan/{no_rekening}/update', 'update')->name('tabungan.update')->can('tabungan.edit');
        Route::delete('/tabungan/{no_rekening}/delete', 'destroy')->name('tabungan.delete')->can('tabungan.delete');

        //Buat Rekening

        Route::get('/tabungan/createrekening', 'createrekening')->name('tabungan.createrekening')->can('tabungan.create');
        Route::post('/tabungan/storerekening', 'storerekening')->name('tabungan.storerekening')->can('tabungan.create');
        Route::delete('/tabungan/{no_rekening}/deleterekening', 'deleterekening')->name('tabungan.deleterekening')->can('tabungan.delete');


        Route::get('/tabungan/{no_anggota}/showmobile', 'showmobile')->name('tabungan.showmobile');
        Route::get('/tabungan/{no_rekening}/mutasi', 'mutasi')->name('tabungan.mutasi');
    });

    // Tabungan Santri Mobile Routes
    Route::controller(App\Http\Controllers\Api\TabunganSantriController::class)->group(function () {
        Route::get('/tabungan-santri/{id_siswa}/mobile', 'showMobile')->name('tabungan-santri.mobile');
    });

    Route::controller(PembiayaanController::class)->group(function () {
        Route::get('/pembiayaan', 'index')->name('pembiayaan.index')->can('pembiayaan.index');
        Route::get('/pembiayaan/{no_anggota}/show', 'show')->name('pembiayaan.show')->can('pembiayaan.create');
        Route::get('/pembiayaan/create', 'create')->name('pembiayaan.create')->can('pembiayaan.create');
        
        // Employee Dedicated Loan Routes
        Route::get('/pinjamansaya', 'pinjamansaya')->name('pembiayaan.pinjamansaya');
        Route::get('/pinjamansaya/create', 'createpinjaman')->name('pembiayaan.createpinjaman');
        Route::post('/pinjamansaya/store', 'storepinjaman')->name('pembiayaan.storepinjaman');

        Route::post('/pembiayaan/store', 'store')->name('pembiayaan.store')->can('pembiayaan.create');
        Route::post('/pembiayaan/storeajuan', 'storeajuan')->name('pembiayaan.storeajuan');


        Route::delete('/pembiayaan/{no_akad}/delete', 'destroy')->name('pembiayaan.delete')->can('pembiayaan.delete');

        Route::get('/pembiayaan/{no_transaksi}/cetakkwitansi', 'cetakkwitansi')->name('pembiayaan.cetakkwitansi')->can('pembiayaan.create');

        Route::get('/pembiayaan/{no_akad}/createbayar', 'createbayar')->name('pembiayaan.createbayar')->can('pembiayaan.create');
        Route::get('/pembiayaan/{no_akad}/editrencana', 'editrencana')->name('pembiayaan.editrencana')->can('pembiayaan.create');
        Route::put('/pembiayaan/{no_akad}/updaterencanacicilan', 'updaterencanacicilan')->name('pembiayaan.updaterencanacicilan')->can('pembiayaan.create');
        Route::post('/pembiayaan/{no_akad}/storebayar', 'storebayar')->name('pembiayaan.storebayar')->can('pembiayaan.create');
        Route::delete('/pembiayaan/{no_transaksi}/deletebayar', 'deletebayar')->name('pembiayaan.deletebayar')->can('pembiayaan.delete');
        Route::get('/pembiayaan/{no_akad}/updaterencana', 'updaterencana')->name('pembiayaan.updaterencana')->can('pembiayaan.edit');

        Route::get('/pembiayaan/{npp}/showmobile', 'showmobile')->name('pembiayaan.showmobile');
        Route::get('/pembiayaan/{no_akad}/showdetail', 'showdetail')->name('pembiayaan.showdetail');
        Route::get('/pembiayaan/createmobile', 'createmobile')->name('pembiayaan.createmobile');
    });

    Route::controller(App\Http\Controllers\GuruController::class)->group(function () {
        Route::get('/guru', 'index')->name('guru.index')->can('guru.index');
        Route::get('/guru/create', 'create')->name('guru.create')->can('guru.create');
        Route::post('/guru', 'store')->name('guru.store')->can('guru.store');
        Route::post('/guru', 'store')->name('guru.store')->can('guru.create');
        Route::get('/guru/{id}/edit', 'edit')->name('guru.edit')->can('guru.edit');
        Route::put('/guru/{id}/update', 'update')->name('guru.update')->can('guru.edit');
        Route::delete('/guru/{id}/delete', 'destroy')->name('guru.delete')->can('guru.delete');
        Route::get('/guru/{id}/create-user', 'createUser')->name('guru.createUser')->can('guru.create');
        Route::post('/guru/{id}/store-user', 'storeUser')->name('guru.storeUser')->can('guru.create');
        Route::get('/guru/generate-users', 'generateUsers')->name('guru.generateUsers')->can('guru.create');
    });


    Route::controller(App\Http\Controllers\MataPelajaranController::class)->group(function () {
        Route::get('/mata-pelajaran', 'index')->name('mata-pelajaran.index')->can('matapelajaran.index');
        Route::get('/mata-pelajaran/create', 'create')->name('mata-pelajaran.create')->can('matapelajaran.create');
        Route::post('/mata-pelajaran', 'store')->name('mata-pelajaran.store')->can('matapelajaran.store');
        Route::get('/mata-pelajaran/{id}/edit', 'edit')->name('mata-pelajaran.edit')->can('matapelajaran.edit');
        Route::put('/mata-pelajaran/{id}/update', 'update')->name('mata-pelajaran.update')->can('matapelajaran.edit');
        Route::delete('/mata-pelajaran/{id}/delete', 'destroy')->name('mata-pelajaran.delete')->can('matapelajaran.delete');
    });

    Route::controller(App\Http\Controllers\JadwalPelajaranController::class)->group(function () {
        Route::get('/jadwal-pelajaran', 'index')->name('jadwal-pelajaran.index');
        Route::get('/jadwal-pelajaran/create', 'create')->name('jadwal-pelajaran.create')->can('jadwalpelajaran.create');
        Route::post('/jadwal-pelajaran/get-data-by-unit', 'getDataByUnit')->name('jadwal-pelajaran.get-data-by-unit');
        Route::post('/jadwal-pelajaran', 'store')->name('jadwal-pelajaran.store')->can('jadwalpelajaran.store');
        Route::get('/jadwal-pelajaran/{id}/edit', 'edit')->name('jadwal-pelajaran.edit')->can('jadwalpelajaran.edit');
        Route::put('/jadwal-pelajaran/{id}/update', 'update')->name('jadwal-pelajaran.update')->can('jadwalpelajaran.update');
        Route::delete('/jadwal-pelajaran/{id}/delete', 'destroy')->name('jadwal-pelajaran.delete')->can('jadwalpelajaran.delete');
        Route::get('/jadwal-pelajaran/cetak-presensi/{id}', 'cetakPresensi')->name('jadwal-pelajaran.cetak-presensi');
    });

    Route::controller(App\Http\Controllers\PenilaianController::class)->group(function () {
        Route::get('/penilaian/{jadwal_id}', 'index')->name('penilaian.index');
        Route::post('/penilaian/bobot', 'storeBobot')->name('penilaian.store-bobot');
        Route::post('/penilaian/rencana', 'storeRencana')->name('penilaian.store-rencana');
        Route::delete('/penilaian/rencana/{id}', 'destroyRencana')->name('penilaian.destroy-rencana');
        Route::get('/penilaian/nilai/{rencana_id}', 'inputNilai')->name('penilaian.input-nilai');
        Route::post('/penilaian/nilai', 'storeNilai')->name('penilaian.store-nilai');
        Route::post('/penilaian/kirim', 'kirimNilai')->name('penilaian.kirim');
        Route::post('/penilaian/batal-kirim', 'batalKirimNilai')->name('penilaian.batal-kirim');
        
        // Multi Column Management
        Route::get('/penilaian/manage/{bobot_id}/{kategori}', 'manageNilai')->name('penilaian.manage');
        Route::post('/penilaian/store-multi', 'storeMultiNilai')->name('penilaian.store-multi-nilai');

        // New Rapor Grouped Route
        Route::get('/rapor', 'rapor')->name('rapor.index');
    });

    Route::controller(App\Http\Controllers\RaporSiswaController::class)->group(function () {
        Route::get('/rapor-siswa', 'index')->name('rapor-siswa.index');
        Route::get('/rapor-siswa/detail/{kode_kelas}', 'show')->name('rapor-siswa.show');
        Route::get('/rapor-siswa/nilai/{jadwal_id}', 'detailNilai')->name('rapor-siswa.nilai');
        Route::get('/rapor-siswa/preview/{no_pendaftaran}', 'previewRapor')->name('rapor-siswa.preview');
        Route::post('/rapor-siswa/cetak-pdf/{no_pendaftaran}', 'cetakRaporPdf')->name('rapor-siswa.pdf');

        // Ekstrakurikuler CRUD
        Route::post('/rapor-siswa/ekstrakurikuler', 'storeEkskul')->name('rapor-siswa.ekskul.store');
        Route::put('/rapor-siswa/ekstrakurikuler/{id}', 'updateEkskul')->name('rapor-siswa.ekskul.update');
        Route::delete('/rapor-siswa/ekstrakurikuler/{id}', 'destroyEkskul')->name('rapor-siswa.ekskul.destroy');

        // Ekstrakurikuler Grading & Student Enrollment
        Route::get('/rapor-siswa/ekstrakurikuler/{id}/nilai', 'nilaiEkskul')->name('rapor-siswa.ekskul.nilai');
        Route::post('/rapor-siswa/ekstrakurikuler/{id}/nilai/add-siswa', 'addSiswaToEkskul')->name('rapor-siswa.ekskul.add-siswa');
        Route::post('/rapor-siswa/ekstrakurikuler/{id}/nilai/save', 'saveNilaiEkskul')->name('rapor-siswa.ekskul.save-nilai');
        Route::delete('/rapor-siswa/ekstrakurikuler/nilai/{id}', 'removeSiswaFromEkskul')->name('rapor-siswa.ekskul.remove-siswa');
    });

    Route::controller(App\Http\Controllers\WaliKelasController::class)->group(function () {
        Route::get('/wali-kelas', 'index')->name('wali-kelas.index');
        Route::get('/wali-kelas/detail/{jadwal_id}', 'detailPenilaian')->name('wali-kelas.detail-penilaian');
    });

    Route::controller(App\Http\Controllers\AkademikSiswaController::class)->group(function () {
        Route::get('/akademik/siswa', 'index')->name('akademiksiswa.index')->can('akademiksiswa.index');
    });

    Route::controller(App\Http\Controllers\AsramaSiswaController::class)->group(function () {
        Route::get('/asrama/siswa', 'index')->name('asramasiswa.index')->can('asramasiswa.index');
    });

    Route::controller(App\Http\Controllers\JabatanAkademikController::class)->group(function () {
        Route::get('/jabatan-akademik', 'index')->name('jabatan-akademik.index')->can('jabatanakademik.index');
        Route::post('/jabatan-akademik', 'store')->name('jabatan-akademik.store')->can('jabatanakademik.store');
        Route::get('/jabatan-akademik/{kode_jabatan}/edit', 'edit')->name('jabatan-akademik.edit')->can('jabatanakademik.edit');
        Route::put('/jabatan-akademik/{kode_jabatan}/update', 'update')->name('jabatan-akademik.update')->can('jabatanakademik.update');
        Route::delete('/jabatan-akademik/{kode_jabatan}/delete', 'destroy')->name('jabatan-akademik.delete')->can('jabatanakademik.delete');
    });

    Route::controller(PresensiController::class)->group(function () {
        Route::get('/presensi', 'index')->name('presensi.index')->can('presensi.index');
        Route::get('/absensikaryawan', 'absensikaryawan')->name('presensi.absensikaryawan');
        Route::get('/presensi/create', 'create')->name('presensi.create')->can('presensi.create');
        Route::post('/presensi', 'store')->name('presensi.store')->can('presensi.create');
        Route::post('/presensi/update', 'update')->name('presensi.update')->can('presensi.edit');
        Route::delete('/presensi/{id}/delete', 'destroy')->name('presensi.delete')->can('presensi.delete');
        Route::get('/presensi/{id}/{status}/show', 'show')->name('presensi.show');
        Route::post('/presensi/edit', 'edit')->name('presensi.edit')->can('presensi.edit');

        Route::post('/presensi/getdatamesin', 'getdatamesin')->name('presensi.getdatamesin');
        Route::post('/presensi/{pin}/{status_scan}/updatefrommachine', 'updatefrommachine')->name('presensi.updatefrommachine');
    });

    // Route untuk Presensi Siswa
    Route::controller(PresensiSiswaController::class)->group(function () {
        Route::get('/presensisiswa', 'index')->name('presensisiswa.index');
        Route::get('/presensisiswa/create', 'create')->name('presensisiswa.create')->can('presensisiswa.create');
        Route::post('/presensisiswa', 'store')->name('presensisiswa.store')->can('presensisiswa.create');
        Route::get('/presensisiswa/{id}', 'show')->name('presensisiswa.show')->can('presensisiswa.show');
        Route::get('/presensisiswa/{id}/edit', 'edit')->name('presensisiswa.edit')->can('presensisiswa.edit');
        Route::put('/presensisiswa/{id}', 'update')->name('presensisiswa.update')->can('presensisiswa.edit');
        Route::delete('/presensisiswa/{id}', 'destroy')->name('presensisiswa.destroy')->can('presensisiswa.delete');
        Route::post('/presensisiswa/bulk-update', 'bulkUpdate')->name('presensisiswa.bulk-update')->can('presensisiswa.edit');
    });

    // Route untuk Presensi Mata Pelajaran
    Route::controller(PresensiMapelController::class)->group(function () {
        Route::get('/presensi-mapel', 'index')->name('presensi-mapel.index');
        Route::get('/presensi-mapel/create', 'create')->name('presensi-mapel.create');
        Route::post('/presensi-mapel/get-jadwal', 'getJadwal')->name('presensi-mapel.get-jadwal');
        Route::get('/presensi-mapel/{jadwal_id}/{tanggal}/input', 'input')->name('presensi-mapel.input');
        Route::post('/presensi-mapel/store', 'store')->name('presensi-mapel.store');
        Route::get('/presensi-mapel/{id}/edit', 'edit')->name('presensi-mapel.edit');
        Route::post('/presensi-mapel/{id}/update', 'update')->name('presensi-mapel.update');
        Route::delete('/presensi-mapel/{id}/delete', 'destroy')->name('presensi-mapel.delete');
    });

    Route::controller(MigrasiSiswaController::class)->group(function () {
        Route::get('/migrasi-siswa', 'index')->name('migrasi-siswa.index');
        Route::get('/migrasi-siswa/template', 'downloadTemplate')->name('migrasi-siswa.download-template');
        Route::get('/migrasi-siswa/template-horizontal', 'downloadTemplateHorizontal')->name('migrasi-siswa.download-template-horizontal');
        Route::post('/migrasi-siswa/upload', 'upload')->name('migrasi-siswa.upload');
        Route::post('/migrasi-siswa/upload-horizontal', 'uploadHorizontal')->name('migrasi-siswa.upload-horizontal');
        Route::get('/migrasi-siswa/preview/{id}', 'preview')->name('migrasi-siswa.preview');
        Route::post('/migrasi-siswa/proses/{id}', 'proses')->name('migrasi-siswa.proses');
        Route::get('/migrasi-siswa/riwayat', 'riwayat')->name('migrasi-siswa.riwayat');
        Route::post('/migrasi-siswa/rollback/{id}', 'rollback')->name('migrasi-siswa.rollback');
    });


    Route::controller(KategoriibadahController::class)->group(function () {
        Route::get('/kategoriibadah', 'index')->name('kategoriibadah.index')->can('kategoriibadah.index');
        Route::get('/kategoriibadah/create', 'create')->name('kategoriibadah.create')->can('kategoriibadah.create');
        Route::post('/kategoriibadah/store', 'store')->name('kategoriibadah.store')->can('kategoriibadah.create');
        Route::get('/kategoriibadah/{id}/edit', 'edit')->name('kategoriibadah.edit')->can('kategoriibadah.edit');
        Route::put('/kategoriibadah/{id}', 'update')->name('kategoriibadah.update')->can('kategoriibadah.edit');
        Route::delete('/kategoriibadah/{id}/delete', 'destroy')->name('kategoriibadah.delete')->can('kategoriibadah.delete');
    });

    Route::controller(KegiatanibadahController::class)->group(function () {
        Route::get('/kegiatanibadah', 'index')->name('kegiatanibadah.index')->can('kegiatanibadah.index');
        Route::get('/kegiatanibadah/create', 'create')->name('kegiatanibadah.create')->can('kegiatanibadah.create');
        Route::post('/kegiatanibadah/store', 'store')->name('kegiatanibadah.store')->can('kegiatanibadah.create');
        Route::get('/kegiatanibadah/{id}/edit', 'edit')->name('kegiatanibadah.edit')->can('kegiatanibadah.edit');
        Route::put('/kegiatanibadah/{id}', 'update')->name('kegiatanibadah.update')->can('kegiatanibadah.edit');
        Route::delete('/kegiatanibadah/{id}/delete', 'destroy')->name('kegiatanibadah.delete')->can('kegiatanibadah.delete');
    });

    Route::controller(ChecklistibadahController::class)->group(function () {
        Route::get('/checklistibadah/create', 'create')->name('checklistibadah.create');
        Route::post('/checklistibadah/getchecklistibadah', 'getchecklistibadah')->name('checklistibadah.getchecklistibadah');
        Route::post('/checklistibadah/store', 'store')->name('checklistibadah.store');
        Route::post('/checklistibadah/delete', 'delete')->name('checklistibadah.delete');
    });

    Route::controller(LaporankoperasiController::class)->group(function () {
        Route::get('/laporankoperasi', 'index')->name('laporankoperasi.index');
        Route::post('/laporankoperasi/cetaksimpanan', 'cetaksimpanan')->name('laporankoperasi.cetaksimpanan');
        Route::post('/laporankoperasi/cetaktabungan', 'cetaktabungan')->name('laporankoperasi.cetaktabungan');
        Route::post('/laporankoperasi/cetakpembiayaan', 'cetakpembiayaan')->name('laporankoperasi.cetakpembiayaan');
    });

    Route::controller(IzinabsenController::class)->group(function () {
        Route::get('/izinabsen', 'index')->name('izinabsen.index')->can('izinabsen.index');
        Route::get('/izinabsen/create', 'create')->name('izinabsen.create')->can('izinabsen.create');
        Route::post('/izinabsen', 'store')->name('izinabsen.store')->can('izinabsen.create');
        Route::get('/izinabsen/{kode_izin}/approve', 'approve')->name('izinabsen.approve')->can('izinabsen.approve');
        Route::delete('/izinabsen/{kode_izin}/cancelapprove', 'cancelapprove')->name('izinabsen.cancelapprove')->can('izinabsen.approve');
        Route::post('/izinabsen/{kode_izin}/storeapprove', 'storeapprove')->name('izinabsen.storeapprove')->can('izinabsen.approve');
        Route::get('/izinabsen/{id}/edit', 'edit')->name('izinabsen.edit')->can('izinabsen.edit');
        Route::put('/izinabsen/{id}', 'update')->name('izinabsen.update')->can('izinabsen.edit');
        Route::get('/izinabsen/{kode_izin}/show', 'show')->name('izinabsen.show')->can('izinabsen.index');
        Route::delete('/izinabsen/{id}/delete', 'destroy')->name('izinabsen.delete')->can('izinabsen.delete');
    });

    Route::controller(IzinsakitController::class)->group(function () {
        Route::get('/izinsakit', 'index')->name('izinsakit.index')->can('izinsakit.index');
        Route::get('/izinsakit/create', 'create')->name('izinsakit.create')->can('izinsakit.create');
        Route::post('/izinsakit', 'store')->name('izinsakit.store')->can('izinsakit.create');
        Route::get('/izinsakit/{kode_izin_sakit}/approve', 'approve')->name('izinsakit.approve')->can('izinsakit.approve');
        Route::delete('/izinsakit/{kode_izin_sakit}/cancelapprove', 'cancelapprove')->name('izinsakit.cancelapprove')->can('izinsakit.approve');
        Route::post('/izinsakit/{kode_izin_sakit}/storeapprove', 'storeapprove')->name('izinsakit.storeapprove')->can('izinsakit.approve');
        Route::get('/izinsakit/{id}/edit', 'edit')->name('izinsakit.edit')->can('izinsakit.edit');
        Route::put('/izinsakit/{kode_izin_sakit}', 'update')->name('izinsakit.update')->can('izinsakit.edit');
        Route::get('/izinsakit/{kode_izin_sakit}/show', 'show')->name('izinsakit.show')->can('izinsakit.index');
        Route::delete('/izinsakit/{id}/delete', 'destroy')->name('izinsakit.delete')->can('izinsakit.delete');
    });

    Route::controller(PengajuanizinController::class)->group(function () {
        Route::get('/pengajuanizin', 'index')->name('pengajuanizin.index');
    });


    Route::controller(KategoriController::class)->group(function () {
        Route::get('/kategori', 'index')->name('kategori.index')->can('kategori.index');
        Route::get('/kategori/create', 'create')->name('kategori.create')->can('kategori.create');
        Route::post('/kategori', 'store')->name('kategori.store')->can('kategori.create');
        Route::get('/kategori/{id}/edit', 'edit')->name('kategori.edit')->can('kategori.edit');
        Route::put('/kategori/{id}/update', 'update')->name('kategori.update')->can('kategori.edit');
        Route::delete('/kategori/{id}/delete', 'destroy')->name('kategori.delete')->can('kategori.delete');
    });

    Route::controller(TestimonialController::class)->group(function () {
        Route::get('/testimonials', 'index')->name('testimonials.index')->can('testimonials.index');
        Route::get('/testimonials/create', 'create')->name('testimonials.create')->can('testimonials.create');
        Route::post('/testimonials', 'store')->name('testimonials.store')->can('testimonials.create');
        Route::get('/testimonials/{testimonial}', 'show')->name('testimonials.show')->can('testimonials.index');
        Route::get('/testimonials/{testimonial}/edit', 'edit')->name('testimonials.edit')->can('testimonials.edit');
        Route::put('/testimonials/{testimonial}', 'update')->name('testimonials.update')->can('testimonials.edit');
        Route::delete('/testimonials/{testimonial}', 'destroy')->name('testimonials.destroy')->can('testimonials.delete');
    });

    Route::controller(PrestasiSiswaController::class)->group(function () {
        Route::get('/prestasisiswa', 'index')->name('prestasisiswa.index')->can('prestasisiswa.index');
        Route::get('/prestasisiswa/create', 'create')->name('prestasisiswa.create')->can('prestasisiswa.create');
        Route::post('/prestasisiswa', 'store')->name('prestasisiswa.store')->can('prestasisiswa.create');
        Route::get('/prestasisiswa/search-siswa', 'searchSiswa')->name('prestasisiswa.search-siswa')->can('prestasisiswa.create');
        Route::get('/prestasisiswa/{prestasiSiswa}', 'show')->name('prestasisiswa.show')->can('prestasisiswa.index');
        Route::get('/prestasisiswa/{prestasiSiswa}/edit', 'edit')->name('prestasisiswa.edit')->can('prestasisiswa.edit');
        Route::put('/prestasisiswa/{prestasiSiswa}', 'update')->name('prestasisiswa.update')->can('prestasisiswa.edit');
        Route::delete('/prestasisiswa/{prestasiSiswa}', 'destroy')->name('prestasisiswa.destroy')->can('prestasisiswa.delete');
    });

    Route::controller(ProgramUnggulanController::class)->group(function () {
        Route::get('/program-unggulan', 'index')->name('program-unggulan.index')->can('programunggulan.index');
        Route::get('/program-unggulan/create', 'create')->name('program-unggulan.create')->can('programunggulan.create');
        Route::post('/program-unggulan', 'store')->name('program-unggulan.store')->can('programunggulan.create');
        Route::get('/program-unggulan/{programUnggulan}', 'show')->name('program-unggulan.show')->can('programunggulan.index');
        Route::get('/program-unggulan/{programUnggulan}/edit', 'edit')->name('program-unggulan.edit')->can('programunggulan.edit');
        Route::put('/program-unggulan/{programUnggulan}', 'update')->name('program-unggulan.update')->can('programunggulan.edit');
        Route::delete('/program-unggulan/{programUnggulan}', 'destroy')->name('program-unggulan.destroy')->can('programunggulan.delete');
    });

    Route::controller(PilarPendidikanController::class)->group(function () {
        Route::get('/pilar-pendidikan', 'index')->name('pilar-pendidikan.index')->can('pilarpendidikan.index');
        Route::get('/pilar-pendidikan/create', 'create')->name('pilar-pendidikan.create')->can('pilarpendidikan.create');
        Route::post('/pilar-pendidikan', 'store')->name('pilar-pendidikan.store')->can('pilarpendidikan.create');
        Route::get('/pilar-pendidikan/{pilarPendidikan}/edit', 'edit')->name('pilar-pendidikan.edit')->can('pilarpendidikan.edit');
        Route::put('/pilar-pendidikan/{pilarPendidikan}', 'update')->name('pilar-pendidikan.update')->can('pilarpendidikan.edit');
        Route::delete('/pilar-pendidikan/{pilarPendidikan}', 'destroy')->name('pilar-pendidikan.destroy')->can('pilarpendidikan.delete');
    });

    Route::controller(PostController::class)->group(function () {
        Route::get('/post', 'index')->name('post.index')->can('post.index');
        Route::get('/post/create', 'create')->name('post.create')->can('post.create');
        Route::post('/post', 'store')->name('post.store')->can('post.create');
        Route::get('/post/{id}/edit', 'edit')->name('post.edit')->can('post.edit');
        Route::put('/post/{id}/update', 'update')->name('post.update')->can('post.edit');
        Route::delete('/post/{id}/delete', 'destroy')->name('post.delete')->can('post.delete');
    });

    // Visi & Misi
    Route::get('/visimisi', [VisiMisiController::class, 'index'])->name('visimisi.index');
    Route::post('/visimisi/visi', [VisiMisiController::class, 'storeVisi'])->name('visimisi.visi.store');
    Route::post('/visimisi/misi', [VisiMisiController::class, 'storeMisi'])->name('visimisi.misi.store');
    Route::put('/visimisi/misi/{id}', [VisiMisiController::class, 'updateMisi'])->name('visimisi.misi.update');
    Route::delete('/visimisi/misi/{id}', [VisiMisiController::class, 'deleteMisi'])->name('visimisi.misi.delete');

    // PPDB Setting
    Route::controller(PpdbSettingController::class)->group(function () {
        Route::get('/ppdb-setting', 'index')->name('ppdb-setting.index');
        Route::post('/ppdb-setting', 'store')->name('ppdb-setting.store');
    });

    // Sebaran Alumni
    Route::resource('sebaran-alumni', SebaranAlumniController::class)->parameters(['sebaran-alumni' => 'sebaranAlumni'])->middleware('auth');

    Route::controller(PageController::class)->group(function () {
        Route::get('/page', 'index')->name('pages.index')->can('pages.index');
        Route::get('/page/create', 'create')->name('pages.create')->can('pages.create');
        Route::post('/page', 'store')->name('pages.store')->can('pages.create');
        Route::get('/page/{id}/edit', 'edit')->name('pages.edit')->can('pages.edit');
        Route::put('/page/{id}/update', 'update')->name('pages.update')->can('pages.edit');
        Route::delete('/page/{id}/delete', 'destroy')->name('pages.delete')->can('pages.delete');
        Route::get('/page/{slug}/show', 'show')->name('pages.show');
        Route::get('/tentang-pesantren', 'tentangPesantren')->name('tentang-pesantren.index');
        Route::post('/tentang-pesantren', 'storeOrUpdateTentangPesantren')->name('tentang-pesantren.store-or-update');
    });

    Route::controller(LaporanmsdmController::class)->group(function () {
        Route::get('/laporanmsdm', 'index')->name('laporanmsdm.index')->can('presensi.index');
        Route::post('/laporanmsdm/cetakpresensi', 'cetakpresensi')->name('laporanmsdm.cetakpresensi')->can('presensi.index');
        Route::post('/laporanmsdm/cetakchecklistibadah', 'cetakchecklistibadah')->name('laporanmsdm.cetakchecklistibadah')->can('presensi.index');
    });


    Route::controller(LaporankeuanganController::class)->group(function () {
        Route::get('/laporankeuangan', 'index')->name('lk.index')->can('pembayaranpdd.index');
        Route::post('/laporankeuangan/cetakpembayaran', 'cetakpembayaran')->name('lk.cetakpembayaran')->can('pembayaranpdd.index');
        Route::post('/laporankeuangan/cetakrekaptagihan', 'cetakrekaptagihan')->name('lk.cetakrekaptagihan')->can('pembayaranpdd.index');
    });

    // Routes untuk Pengumuman
    Route::resource('pengumuman', PengumumanController::class);

    // Routes untuk Kategori Pengumuman
    Route::resource('kategori-pengumuman', KategoriPengumumanController::class);
});

// Route Public untuk Presensi Siswa (Tanpa Auth)
Route::controller(PresensiSiswaController::class)->group(function () {
    Route::get('/public/presensi-siswa', 'publicPresensi')->name('public.presensi-siswa');
    Route::post('/public/presensi-siswa/scan', 'scanRfid')->name('public.presensi-siswa.scan');
    Route::get('/public/presensi-siswa/status/{no_pendaftaran}', 'getPresensiStatus')->name('public.presensi-siswa.status');
    Route::get('/public/presensi-siswa/riwayat', 'getRiwayatPresensi')->name('public.presensi-siswa.riwayat');
});

// PUBLIC QUESTIONNAIRE ROUTES
Route::get('/questionnaires', [PublicQuestionnaireController::class, 'list'])->name('questionnaires.list');
Route::get('/questionnaire/{id}', [PublicQuestionnaireController::class, 'index'])->name('questionnaire.form');
Route::post('/questionnaire/{id}', [PublicQuestionnaireController::class, 'store'])->name('questionnaire.submit');

// PUBLIC GOT TALENT STATISTICS
Route::get('/got-talent/statistik', [PendaftaranGotTalentController::class, 'publicView'])->name('got-talent.public');

// ADMIN QUESTIONNAIRE ROUTES
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('questionnaires', AdminQuestionnaireController::class);
    Route::resource('questionnaires.questions', AdminQuestionController::class);
    Route::get('questionnaires/{questionnaire}/report', [AdminQuestionnaireController::class, 'report'])->name('questionnaires.report');
});

Route::get('/createrolepermission', function () {

    try {
        Role::create(['name' => 'super admin']);
        // Permission::create(['name' => 'view-karyawan']);
        // Permission::create(['name' => 'view-departemen']);
        echo "Sukses";
    } catch (\Exception $e) {
        echo "Error";
    }
});

require __DIR__ . '/auth.php';

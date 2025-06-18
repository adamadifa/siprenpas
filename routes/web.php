<?php

use App\Http\Controllers\AgendakegiatanController;
use App\Http\Controllers\AnggotaController;
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
use App\Http\Controllers\JenisbiayaController;
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
use App\Http\Controllers\LaporankoperasiController;
use App\Http\Controllers\LedgerController;
use App\Http\Controllers\LedgertransaksiController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PembayaranpendidikanController;
use App\Http\Controllers\PembiayaanController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\PendaftaranonlineController;
use App\Http\Controllers\PengajuanizinController;
use App\Http\Controllers\Permission_groupController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PresensiController;
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
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VillageController;
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

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');


// Route::middleware('guest')->group(function () {
//     Route::get('/', function () {
//         return view('auth.loginuser');
//     })->name('login');
// });


Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index')->middleware(['auth', 'verified']);
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
        Route::get('/karyawan/{npp}/updatestatus', 'updatestatus')->name('karyawan.updatestatus');
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
    });

    Route::controller(PendaftaranController::class)->group(function () {
        Route::get('/pendaftaran/{no_pendaftaran}/cetakpdf', 'cetakpdf')->name('pendaftaran.cetakpdf')->can('pendaftaran.show');
        Route::get('/pendaftaran', 'index')->name('pendaftaran.index')->can('pendaftaran.index');
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

        Route::get('/pendaftaran/getsiswa', 'getsiswa')->name('pendaftaran.getsiswa');
    });


    Route::controller(PendaftaranonlineController::class)->group(function () {
        Route::get('/pendaftaranonline', 'index')->name('pendaftaranonline.index')->can('pendaftaranonline.index');
        Route::get('/pendaftaranonline/{no_register}/show', 'show')->name('pendaftaranonline.show')->can('pendaftaranonline.show');
        Route::get('/pendaftaranonline/{no_register}/edit', 'edit')->name('pendaftaranonline.edit')->can('pendaftaranonline.edit');
        Route::post('/pendaftaranonline/update', 'update')->name('pendaftaranonline.update')->can('pendaftaranonline.edit');
        Route::delete('/pendaftaranonline/{no_register}/delete', 'destroy')->name('pendaftaranonline.delete')->can('pendaftaranonline.delete');
        Route::get('pendaftaranonline/cetak/{no_register}', 'cetak')->name('pendaftaranonline.cetak');
        Route::post('pendaftaranonline/{no_register}/konfirmasi', 'konfirmasi')->name('pendaftaranonline.konfirmasi');
        Route::post('pendaftaranonline/{no_register}/cancel', 'cancel')->name('pendaftaranonline.cancel');
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

    Route::controller(PembiayaanController::class)->group(function () {
        Route::get('/pembiayaan', 'index')->name('pembiayaan.index')->can('pembiayaan.index');
        Route::get('/pembiayaan/{no_anggota}/show', 'show')->name('pembiayaan.show')->can('pembiayaan.create');
        Route::get('/pembiayaan/create', 'create')->name('pembiayaan.create')->can('pembiayaan.create');
        Route::post('/pembiayaan/store', 'store')->name('pembiayaan.store')->can('pembiayaan.create');
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
        Route::get('/pembiayaan/createmobile','createmobile')->name('pembiayaan.createmobile');
    });

    Route::controller(PresensiController::class)->group(function () {
        Route::get('/presensi', 'index')->name('presensi.index')->can('presensi.index');
        Route::get('/presensi/create', 'create')->name('presensi.create')->can('presensi.create');
        Route::post('/presensi', 'store')->name('presensi.store')->can('presensi.create');
        Route::post('/presensi/update', 'update')->name('presensi.update')->can('presensi.edit');
        Route::delete('/presensi/{id}/delete', 'destroy')->name('presensi.delete')->can('presensi.delete');
        Route::get('/presensi/{id}/{status}/show', 'show')->name('presensi.show');
        Route::post('/presensi/edit', 'edit')->name('presensi.edit')->can('presensi.edit');

        Route::post('/presensi/getdatamesin', 'getdatamesin')->name('presensi.getdatamesin');
        Route::post('/presensi/{pin}/{status_scan}/updatefrommachine', 'updatefrommachine')->name('presensi.updatefrommachine');
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

    Route::controller(PostController::class)->group(function () {
        Route::get('/post', 'index')->name('post.index')->can('post.index');
        Route::get('/post/create', 'create')->name('post.create')->can('post.create');
        Route::post('/post', 'store')->name('post.store')->can('post.create');
        Route::get('/post/{id}/edit', 'edit')->name('post.edit')->can('post.edit');
        Route::put('/post/{id}/update', 'update')->name('post.update')->can('post.edit');
        Route::delete('/post/{id}/delete', 'destroy')->name('post.delete')->can('post.delete');
    });

    Route::controller(PageController::class)->group(function () {
        Route::get('/page', 'index')->name('pages.index')->can('pages.index');
        Route::get('/page/create', 'create')->name('pages.create')->can('pages.create');
        Route::post('/page', 'store')->name('pages.store')->can('pages.create');
        Route::get('/page/{id}/edit', 'edit')->name('pages.edit')->can('pages.edit');
        Route::put('/page/{id}/update', 'update')->name('pages.update')->can('pages.edit');
        Route::delete('/page/{id}/delete', 'destroy')->name('pages.delete')->can('pages.delete');
    });
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

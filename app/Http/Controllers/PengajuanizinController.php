<?php

namespace App\Http\Controllers;

use App\Models\Izinabsen;
use App\Models\Izinsakit;
use App\Models\User;
use App\Models\Userkaryawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengajuanizinController extends Controller
{
    public function index()
    {
        $user = User::where('id', auth()->user()->id)->first();
        $userkaryawan = Userkaryawan::where('id_user', $user->id)->first();

        $izinabsen = Izinabsen::where('npp', $userkaryawan->npp)
            ->select('kode_izin as kode', 'tanggal', 'keterangan', 'dari', 'sampai', DB::raw('\'i\' as ket'), 'status as status_izin');

        $izinsakit = Izinsakit::where('npp', $userkaryawan->npp)
            ->select('kode_izin_sakit as kode', 'tanggal', 'keterangan', 'dari', 'sampai', DB::raw('\'s\' as ket'), 'status as status_izin');



        $pengajuan_izin = $izinabsen->union($izinsakit)->orderBy('tanggal', 'desc')->get();
        $data['pengajuan_izin'] = $pengajuan_izin;
        return view('msdm.pengajuanizin.index', $data);
    }
}

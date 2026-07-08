<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Karyawananggota;
use App\Models\Tabungan;
use App\Models\Userkaryawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TabunganKaryawanController extends Controller
{
    public function getTabunganDetails(Request $request)
    {
        try {
            $user = $request->user();
            $npp = $user->npp;
            
            if (empty($npp)) {
                $userkaryawan = Userkaryawan::where('id_user', $user->id)->first();
                if ($userkaryawan) {
                    $npp = $userkaryawan->npp;
                }
            }
            
            if (empty($npp)) {
                return response()->json([
                    'success' => false,
                    'message' => 'NPP karyawan tidak ditemukan'
                ], 400);
            }
            
            $cekanggota = Karyawananggota::where('npp', $npp)->first();
            if ($cekanggota == null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda belum terdaftar sebagai Anggota Koperasi Tsarwah'
                ], 404);
            }
            
            $no_anggota = $cekanggota->no_anggota;
            
            // Get cooperative tabungan accounts for this member
            $tabungan = DB::table('koperasi_tabungan as kt')
                ->join('koperasi_jenis_tabungan as kjt', 'kt.kode_tabungan', '=', 'kjt.kode_tabungan')
                ->where('kt.no_anggota', $no_anggota)
                ->select('kt.*', 'kjt.jenis_tabungan')
                ->get();
                
            $total_saldo = $tabungan->sum('saldo');
            
            // Get last 5 transactions across all these accounts
            $noRekeningList = $tabungan->pluck('no_rekening')->toArray();
            $mutasi = collect();
            if (!empty($noRekeningList)) {
                $mutasi = DB::table('koperasi_tabungan_transaksi as ktt')
                    ->join('koperasi_tabungan as kt', 'ktt.no_rekening', '=', 'kt.no_rekening')
                    ->join('koperasi_jenis_tabungan as kjt', 'kt.kode_tabungan', '=', 'kjt.kode_tabungan')
                    ->whereIn('ktt.no_rekening', $noRekeningList)
                    ->select('ktt.*', 'kjt.jenis_tabungan')
                    ->orderBy('ktt.tanggal', 'desc')
                    ->orderBy('ktt.created_at', 'desc')
                    ->limit(5)
                    ->get();
            }
            
            return response()->json([
                'success' => true,
                'data' => [
                    'no_anggota' => $no_anggota,
                    'total_saldo' => (float)$total_saldo,
                    'tabungan' => $tabungan,
                    'mutasi' => $mutasi
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getTabunganDetail(Request $request, $no_rekening)
    {
        try {
            $user = $request->user();
            $npp = $user->npp;
            
            if (empty($npp)) {
                $userkaryawan = Userkaryawan::where('id_user', $user->id)->first();
                if ($userkaryawan) {
                    $npp = $userkaryawan->npp;
                }
            }
            
            if (empty($npp)) {
                return response()->json([
                    'success' => false,
                    'message' => 'NPP karyawan tidak ditemukan'
                ], 400);
            }
            
            $cekanggota = Karyawananggota::where('npp', $npp)->first();
            if ($cekanggota == null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda belum terdaftar sebagai Anggota Koperasi Tsarwah'
                ], 404);
            }
            
            $no_anggota = $cekanggota->no_anggota;
            
            $tabungan = DB::table('koperasi_tabungan as kt')
                ->join('koperasi_jenis_tabungan as kjt', 'kt.kode_tabungan', '=', 'kjt.kode_tabungan')
                ->where('kt.no_anggota', $no_anggota)
                ->where('kt.no_rekening', $no_rekening)
                ->select('kt.*', 'kjt.jenis_tabungan')
                ->first();
                
            if (!$tabungan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data rekening tabungan tidak ditemukan'
                ], 404);
            }
            
            $mutasi = DB::table('koperasi_tabungan_transaksi as ktt')
                ->where('ktt.no_rekening', $no_rekening)
                ->orderBy('ktt.tanggal', 'desc')
                ->orderBy('ktt.created_at', 'desc')
                ->get();
                
            return response()->json([
                'success' => true,
                'data' => [
                    'no_anggota' => $no_anggota,
                    'tabungan' => $tabungan,
                    'mutasi' => $mutasi
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}

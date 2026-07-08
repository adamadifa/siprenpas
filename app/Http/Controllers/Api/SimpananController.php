<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Karyawananggota;
use App\Models\Saldosimpanan;
use App\Models\Simpanan;
use App\Models\Userkaryawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SimpananController extends Controller
{
    public function getSimpananDetails(Request $request)
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
            
            $saldosimpanan = Saldosimpanan::where('no_anggota', $no_anggota)
                ->select('no_anggota', DB::raw('SUM(jumlah) as total_saldo'))
                ->groupBy('no_anggota')
                ->first();
                
            $saldo_simpanan = Saldosimpanan::where('no_anggota', $no_anggota)
                ->join('koperasi_jenis_simpanan', 'koperasi_saldo_simpanan.kode_simpanan', '=', 'koperasi_jenis_simpanan.kode_simpanan')
                ->select('koperasi_saldo_simpanan.*', 'koperasi_jenis_simpanan.jenis_simpanan')
                ->get();
                
            $mutasi = Simpanan::where('no_anggota', $no_anggota)
                ->join('koperasi_jenis_simpanan', 'koperasi_simpanan.kode_simpanan', '=', 'koperasi_jenis_simpanan.kode_simpanan')
                ->select('koperasi_simpanan.*', 'koperasi_jenis_simpanan.jenis_simpanan')
                ->orderBy('tanggal', 'desc')
                ->limit(5)
                ->get();
                
            return response()->json([
                'success' => true,
                'data' => [
                    'no_anggota' => $no_anggota,
                    'total_saldo' => $saldosimpanan ? (float)$saldosimpanan->total_saldo : 0,
                    'saldo_simpanan' => $saldo_simpanan,
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

    public function getSimpananDetail(Request $request, $kode_simpanan)
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
            
            $saldo = Saldosimpanan::where('no_anggota', $no_anggota)
                ->where('koperasi_saldo_simpanan.kode_simpanan', $kode_simpanan)
                ->join('koperasi_jenis_simpanan', 'koperasi_saldo_simpanan.kode_simpanan', '=', 'koperasi_jenis_simpanan.kode_simpanan')
                ->select('koperasi_saldo_simpanan.*', 'koperasi_jenis_simpanan.jenis_simpanan')
                ->first();
                
            if (!$saldo) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data simpanan tidak ditemukan'
                ], 404);
            }
            
            $mutasi = Simpanan::where('no_anggota', $no_anggota)
                ->where('koperasi_simpanan.kode_simpanan', $kode_simpanan)
                ->orderBy('tanggal', 'desc')
                ->get();
                
            return response()->json([
                'success' => true,
                'data' => [
                    'no_anggota' => $no_anggota,
                    'simpanan' => $saldo,
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

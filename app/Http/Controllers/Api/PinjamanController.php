<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Userkaryawan;
use App\Models\Karyawananggota;
use App\Models\Pembiayaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PinjamanController extends Controller
{
    public function getPinjamanDetails(Request $request)
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
            $no_anggota = null;
            if ($cekanggota) {
                $no_anggota = $cekanggota->no_anggota;
            } else {
                $karyawan = DB::table('karyawan')->where('npp', $npp)->first();
                if ($karyawan && (!empty($karyawan->no_ktp) || !empty($karyawan->no_hp))) {
                    $anggota = DB::table('koperasi_anggota')
                        ->where(function($q) use ($karyawan) {
                            if (!empty($karyawan->no_ktp)) {
                                $q->where('nik', $karyawan->no_ktp);
                            }
                            if (!empty($karyawan->no_hp)) {
                                $q->orWhere('no_hp', $karyawan->no_hp);
                            }
                        })
                        ->first();
                    if ($anggota) {
                        $no_anggota = $anggota->no_anggota;
                    }
                }
            }
            
            if ($no_anggota == null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda belum terdaftar sebagai Anggota Koperasi Tsarwah'
                ], 404);
            }
            
            // Get all loans (pembiayaan)
            $pembiayaan = Pembiayaan::where('koperasi_pembiayaan.no_anggota', $no_anggota)
                ->join('koperasi_jenis_pembiayaan', 'koperasi_pembiayaan.kode_pembiayaan', '=', 'koperasi_jenis_pembiayaan.kode_pembiayaan')
                ->leftJoin(DB::raw('(SELECT no_akad, SUM(jumlah) as jmlbayar FROM koperasi_pembiayaan_historibayar GROUP BY no_akad) as pembayaran'), 'koperasi_pembiayaan.no_akad', '=', 'pembayaran.no_akad')
                ->select(
                    'koperasi_pembiayaan.*',
                    'koperasi_jenis_pembiayaan.jenis_pembiayaan',
                    DB::raw('COALESCE(pembayaran.jmlbayar, 0) as total_bayar')
                )
                ->orderBy('tanggal', 'desc')
                ->get();
                
            $formatted_pembiayaan = [];
            $total_pinjaman = 0;
            $total_sisa = 0;
            
            foreach ($pembiayaan as $d) {
                $jumlah_pembiayaan = $d->jumlah + ($d->jumlah * ($d->persentase / 100));
                $total_bayar = floatval($d->total_bayar);
                $sisa = $jumlah_pembiayaan - $total_bayar;
                $isLunas = $total_bayar >= $jumlah_pembiayaan;
                $progress = $jumlah_pembiayaan > 0 ? min(100, round(($total_bayar / $jumlah_pembiayaan) * 100)) : 0;
                
                // Add to totals if the loan is approved (status = 1)
                if ($d->status == '1') {
                    $total_pinjaman += $jumlah_pembiayaan;
                    $total_sisa += $sisa;
                }
                
                $formatted_pembiayaan[] = [
                    'no_akad' => $d->no_akad,
                    'tanggal' => $d->tanggal,
                    'jumlah_pokok' => $d->jumlah,
                    'persentase' => $d->persentase,
                    'total_pinjaman' => $jumlah_pembiayaan,
                    'total_bayar' => $total_bayar,
                    'sisa' => $sisa,
                    'is_lunas' => $isLunas,
                    'progress' => $progress,
                    'jenis_pembiayaan' => $d->jenis_pembiayaan,
                    'keperluan' => $d->keperluan,
                    'status' => $d->status, // '1' approved, otherwise pending
                ];
            }
            
            // Get last 5 payment histories (historibayar)
            $mutasi = DB::table('koperasi_pembiayaan_historibayar')
                ->join('koperasi_pembiayaan', 'koperasi_pembiayaan_historibayar.no_akad', '=', 'koperasi_pembiayaan.no_akad')
                ->join('koperasi_jenis_pembiayaan', 'koperasi_pembiayaan.kode_pembiayaan', '=', 'koperasi_jenis_pembiayaan.kode_pembiayaan')
                ->select(
                    'koperasi_pembiayaan_historibayar.*',
                    'koperasi_jenis_pembiayaan.jenis_pembiayaan'
                )
                ->where('koperasi_pembiayaan.no_anggota', $no_anggota)
                ->orderBy('koperasi_pembiayaan_historibayar.tanggal', 'desc')
                ->limit(5)
                ->get();
                
            return response()->json([
                'success' => true,
                'data' => [
                    'no_anggota' => $no_anggota,
                    'total_pinjaman' => $total_pinjaman,
                    'total_sisa' => $total_sisa,
                    'pembiayaan' => $formatted_pembiayaan,
                    'mutasi' => $mutasi
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getPinjamanDetail(Request $request, $no_akad)
    {
        try {
            $user = $request->user();
            
            // Find the loan
            $pembiayaan = Pembiayaan::where('koperasi_pembiayaan.no_akad', $no_akad)
                ->join('koperasi_jenis_pembiayaan', 'koperasi_pembiayaan.kode_pembiayaan', '=', 'koperasi_jenis_pembiayaan.kode_pembiayaan')
                ->leftJoin(DB::raw('(SELECT no_akad, SUM(jumlah) as jmlbayar FROM koperasi_pembiayaan_historibayar GROUP BY no_akad) as pembayaran'), 'koperasi_pembiayaan.no_akad', '=', 'pembayaran.no_akad')
                ->select(
                    'koperasi_pembiayaan.*',
                    'koperasi_jenis_pembiayaan.jenis_pembiayaan',
                    DB::raw('COALESCE(pembayaran.jmlbayar, 0) as total_bayar')
                )
                ->first();
                
            if (!$pembiayaan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data pembiayaan tidak ditemukan'
                ], 404);
            }
            
            $jumlah_pembiayaan = $pembiayaan->jumlah + ($pembiayaan->jumlah * ($pembiayaan->persentase / 100));
            $total_bayar = floatval($pembiayaan->total_bayar);
            $sisa = $jumlah_pembiayaan - $total_bayar;
            $isLunas = $total_bayar >= $jumlah_pembiayaan;
            $progress = $jumlah_pembiayaan > 0 ? min(100, round(($total_bayar / $jumlah_pembiayaan) * 100)) : 0;
            
            // Get installment plan (Rencana Pembayaran)
            $rencana = DB::table('koperasi_pembiayaan_rencana')
                ->where('no_akad', $no_akad)
                ->orderBy('cicilan_ke', 'asc')
                ->get();
                
            // Get payment history (Histori Pembayaran)
            $historibayar = DB::table('koperasi_pembiayaan_historibayar')
                ->where('no_akad', $no_akad)
                ->orderBy('tanggal', 'desc')
                ->get();
                
            return response()->json([
                'success' => true,
                'data' => [
                    'pembiayaan' => [
                        'no_akad' => $pembiayaan->no_akad,
                        'tanggal' => $pembiayaan->tanggal,
                        'jumlah_pokok' => $pembiayaan->jumlah,
                        'persentase' => $pembiayaan->persentase,
                        'total_pinjaman' => $jumlah_pembiayaan,
                        'total_bayar' => $total_bayar,
                        'sisa' => $sisa,
                        'is_lunas' => $isLunas,
                        'progress' => $progress,
                        'jenis_pembiayaan' => $pembiayaan->jenis_pembiayaan,
                        'keperluan' => $pembiayaan->keperluan,
                        'status' => $pembiayaan->status,
                        'angsuran' => $pembiayaan->jangka_waktu
                    ],
                    'rencana' => $rencana,
                    'historibayar' => $historibayar
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}

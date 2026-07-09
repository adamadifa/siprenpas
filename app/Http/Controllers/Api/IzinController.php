<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Izinabsen;
use App\Models\Izinsakit;
use App\Models\Userkaryawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class IzinController extends Controller
{
    public function getIzinHistory(Request $request)
    {
        try {
            $user = $request->user();
            $userkaryawan = Userkaryawan::where('id_user', $user->id)->first();
            if (!$userkaryawan) {
                return response()->json(['success' => false, 'message' => 'Hubungan user karyawan tidak ditemukan'], 400);
            }

            $npp = $userkaryawan->npp;

            $izinAbsen = Izinabsen::where('npp', $npp)
                ->select('kode_izin as id', 'dari', 'sampai', 'keterangan', 'status', DB::raw('"izin" as jenis_izin'), 'created_at', DB::raw('NULL as doc_sid'))
                ->get();

            $izinSakit = Izinsakit::where('npp', $npp)
                ->select('kode_izin_sakit as id', 'dari', 'sampai', 'keterangan', 'status', DB::raw('"sakit" as jenis_izin'), 'created_at', 'doc_sid')
                ->get();

            $history = $izinAbsen->concat($izinSakit)->sortByDesc('created_at')->values();

            return response()->json([
                'success' => true,
                'data' => $history
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function storeIzin(Request $request)
    {
        try {
            $user = $request->user();
            $userkaryawan = Userkaryawan::where('id_user', $user->id)->first();
            if (!$userkaryawan) {
                return response()->json(['success' => false, 'message' => 'Hubungan user karyawan tidak ditemukan'], 400);
            }

            $npp = $userkaryawan->npp;

            $request->validate([
                'jenis_izin' => 'required|in:izin,sakit',
                'dari' => 'required|date',
                'sampai' => 'required|date|after_or_equal:dari',
                'keterangan' => 'required|string',
                'sid_image' => 'nullable|string'
            ]);

            $dari = $request->dari;
            $sampai = $request->sampai;

            $jmlhari = hitungHari($dari, $sampai);
            if ($jmlhari > 3) {
                return response()->json(['success' => false, 'message' => 'Pengajuan tidak boleh lebih dari 3 hari!'], 400);
            }

            // Check overlapping leave in Izinabsen
            $cek_izin_absen = Izinabsen::where('npp', $npp)
                ->where(function($query) use ($dari, $sampai) {
                    $query->whereBetween('dari', [$dari, $sampai])
                          ->orWhereBetween('sampai', [$dari, $sampai]);
                })->first();

            // Check overlapping leave in Izinsakit
            $cek_izin_sakit = Izinsakit::where('npp', $npp)
                ->where(function($query) use ($dari, $sampai) {
                    $query->whereBetween('dari', [$dari, $sampai])
                          ->orWhereBetween('sampai', [$dari, $sampai]);
                })->first();

            if ($cek_izin_absen || $cek_izin_sakit) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah mengajukan izin/sakit pada rentang tanggal tersebut!'
                ], 400);
            }

            DB::beginTransaction();

            if ($request->jenis_izin === 'izin') {
                $lastizin = Izinabsen::select('kode_izin')
                    ->whereRaw('YEAR(dari)="' . date('Y', strtotime($dari)) . '"')
                    ->whereRaw('MONTH(dari)="' . date('m', strtotime($dari)) . '"')
                    ->orderBy("kode_izin", "desc")
                    ->first();
                $last_kode_izin = $lastizin != null ? $lastizin->kode_izin : '';
                $kode_izin  = buatkode($last_kode_izin, "IA"  . date('ym', strtotime($dari)), 4);

                Izinabsen::create([
                    'kode_izin' => $kode_izin,
                    'npp' => $npp,
                    'tanggal' => $dari,
                    'dari' => $dari,
                    'sampai' => $sampai,
                    'keterangan' => $request->keterangan,
                    'status' => 0,
                ]);
            } else {
                $lastizinsakit = Izinsakit::select('kode_izin_sakit')
                    ->whereRaw('YEAR(tanggal)="' . date('Y', strtotime($dari)) . '"')
                    ->whereRaw('MONTH(tanggal)="' . date('m', strtotime($dari)) . '"')
                    ->orderBy("kode_izin_sakit", "desc")
                    ->first();
                $last_kode_izin_sakit = $lastizinsakit != null ? $lastizinsakit->kode_izin_sakit : '';
                $kode_izin_sakit  = buatkode($last_kode_izin_sakit, "IS"  . date('ym', strtotime($dari)), 4);

                $fileName = null;
                if ($request->has('sid_image') && !empty($request->sid_image)) {
                    $image = $request->sid_image;
                    $image_parts = explode(";base64,", $image);
                    if (count($image_parts) < 2) {
                        $image_parts = explode(";base64", $image);
                    }
                    $image_base64 = base64_decode($image_parts[1]);
                    
                    $extension = 'png';
                    if (preg_match('/^data:image\/(\w+);base64/', $image, $type)) {
                        $extension = strtolower($type[1]);
                    }
                    
                    $fileName = $kode_izin_sakit . "." . $extension;
                    $file = "public/uploads/sid/" . $fileName;
                    Storage::put($file, $image_base64);
                }

                Izinsakit::create([
                    'kode_izin_sakit' => $kode_izin_sakit,
                    'npp' => $npp,
                    'tanggal' => $dari,
                    'dari' => $dari,
                    'sampai' => $sampai,
                    'keterangan' => $request->keterangan,
                    'status' => 0,
                    'id_user' => $user->id,
                    'doc_sid' => $fileName
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pengajuan izin berhasil disimpan'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}

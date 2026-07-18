<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Checklistibadah;
use App\Models\Detailchecklistibadah;
use App\Models\Kegiatanibadah;
use App\Models\Userkaryawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class IbadahController extends Controller
{
    public function getIbadah(Request $request)
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

            $tanggal = $request->query('tanggal', date('Y-m-d'));

            $cekibadah = Detailchecklistibadah::join('checklist_ibadah', 'checklist_ibadah_detail.kode_checklist_ibadah', '=', 'checklist_ibadah.kode_checklist_ibadah')
                ->where('tanggal', $tanggal)
                ->where('npp', $npp)
                ->select('checklist_ibadah_detail.id_kegiatan_ibadah', 'checklist_ibadah_detail.kode_checklist_ibadah');

            $kegiatan_ibadah = Kegiatanibadah::join('kategori_ibadah', 'kegiatan_ibadah.id_kategori_ibadah', '=', 'kategori_ibadah.id')
                ->leftJoinsub($cekibadah, 'cekibadah', function ($join) {
                    $join->on('kegiatan_ibadah.id', '=', 'cekibadah.id_kegiatan_ibadah');
                })
                ->select('kegiatan_ibadah.*', 'kategori_ibadah.kategori_ibadah', 'id_kegiatan_ibadah', 'kode_checklist_ibadah')
                ->orderBy('kegiatan_ibadah.id_kategori_ibadah')
                ->orderBy('kegiatan_ibadah.id', 'asc')
                ->get();

            // Format grouped by category
            $grouped = [];
            foreach ($kegiatan_ibadah as $item) {
                $category = $item->kategori_ibadah;
                if (!isset($grouped[$category])) {
                    $grouped[$category] = [];
                }
                $grouped[$category][] = [
                    'id' => $item->id,
                    'nama_kegiatan' => $item->nama_kegiatan,
                    'id_kategori_ibadah' => $item->id_kategori_ibadah,
                    'checked' => !empty($item->id_kegiatan_ibadah),
                    'kode_checklist_ibadah' => $item->kode_checklist_ibadah
                ];
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'tanggal' => $tanggal,
                    'npp' => $npp,
                    'ibadah' => $grouped
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function toggleIbadah(Request $request)
    {
        try {
            Log::info("toggleIbadah API endpoint called");
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

            $id = $request->input('id');
            $tanggal = $request->input('tanggal', date('Y-m-d'));
            $checked = $request->input('checked'); // boolean: true = check, false = uncheck

            if (empty($id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID Kegiatan Ibadah diperlukan'
                ], 400);
            }

            DB::beginTransaction();

            // Find if there's already a checklist header for this date and npp
            $checklist_ibadah = Checklistibadah::where('tanggal', $tanggal)
                ->where('npp', $npp)
                ->first();

            $is_first_submit = false;
            if ($checked) {
                if (!$checklist_ibadah) {
                    $is_first_submit = true;
                } else {
                    $detail_count = Detailchecklistibadah::where('kode_checklist_ibadah', $checklist_ibadah->kode_checklist_ibadah)->count();
                    if ($detail_count === 0) {
                        $is_first_submit = true;
                    }
                }
            }

            if (!$checked) {
                // UNCHECK: delete from detail
                if ($checklist_ibadah) {
                    Detailchecklistibadah::where('kode_checklist_ibadah', $checklist_ibadah->kode_checklist_ibadah)
                        ->where('id_kegiatan_ibadah', $id)
                        ->delete();
                }
            } else {
                // CHECK: add to detail
                if ($checklist_ibadah) {
                    // Check if already exists to prevent duplicate
                    $exists = Detailchecklistibadah::where('kode_checklist_ibadah', $checklist_ibadah->kode_checklist_ibadah)
                        ->where('id_kegiatan_ibadah', $id)
                        ->first();
                        
                    if (!$exists) {
                        Detailchecklistibadah::create([
                            'kode_checklist_ibadah' => $checklist_ibadah->kode_checklist_ibadah,
                            'id_kegiatan_ibadah' => $id,
                        ]);
                    }
                } else {
                    // Create new header with duplicate exception handling for concurrent requests
                    try {
                        $last_checklist_ibadah = Checklistibadah::orderBy('kode_checklist_ibadah', 'desc')
                            ->first();
                        $last_kode = $last_checklist_ibadah ? $last_checklist_ibadah->kode_checklist_ibadah : '';
                        if (empty($last_kode)) {
                            $format = date('ymd', strtotime($tanggal));
                            $kode_checklist_ibadah = buatkode('', $format, 4);
                        } else {
                            $kode_checklist_ibadah = strval(intval($last_kode) + 1);
                        }
                        
                        $checklist_ibadah = Checklistibadah::create([
                            'kode_checklist_ibadah' => $kode_checklist_ibadah,
                            'tanggal' => $tanggal,
                            'npp' => $npp,
                        ]);
                    } catch (\Illuminate\Database\QueryException $e) {
                        if ($e->errorInfo[1] == 1062) {
                            $checklist_ibadah = Checklistibadah::where('tanggal', $tanggal)
                                ->where('npp', $npp)
                                ->first();
                            $is_first_submit = false; // It was already submitted by the concurrent request
                        } else {
                            throw $e;
                        }
                    }
                    
                    if ($checklist_ibadah) {
                        // Check if already exists in detail to prevent duplicate
                        $exists = Detailchecklistibadah::where('kode_checklist_ibadah', $checklist_ibadah->kode_checklist_ibadah)
                            ->where('id_kegiatan_ibadah', $id)
                            ->first();
                            
                        if (!$exists) {
                            Detailchecklistibadah::create([
                                'kode_checklist_ibadah' => $checklist_ibadah->kode_checklist_ibadah,
                                'id_kegiatan_ibadah' => $id,
                            ]);
                        }
                    }
                }
            }

            DB::commit();

            // if ($is_first_submit) {
            //     // Dispatch WhatsApp Group notification
            //     Log::info("DB transaction committed, first submit of the day. Dispatching SendChecklistIbadahJob for date: " . $tanggal);
            //     \App\Jobs\SendChecklistIbadahJob::dispatch($tanggal);
            // }

            return response()->json([
                'success' => true,
                'message' => 'Status ibadah berhasil diubah'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}

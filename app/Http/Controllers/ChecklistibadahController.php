<?php

namespace App\Http\Controllers;

use App\Models\Checklistibadah;
use App\Models\Detailchecklistibadah;
use App\Models\Kegiatanibadah;
use App\Models\User;
use App\Models\Userkaryawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;

class ChecklistibadahController extends Controller
{
    public function create()
    {
        $user = User::where('id', auth()->user()->id)->first();
        $userkaryawan = Userkaryawan::where('id_user', $user->id)->first();
        $karyawan = null;
        if ($userkaryawan) {
            $karyawan = \App\Models\Karyawan::where('karyawan.npp', $userkaryawan->npp)
                ->join('jabatan', 'karyawan.kode_jabatan', '=', 'jabatan.kode_jabatan')
                ->join('unit', 'karyawan.kode_unit', '=', 'unit.kode_unit')
                ->first();
            
            $dept = \App\Models\Departemen::where('kode_dept', $user->kode_dept)->first();
            if ($karyawan && $dept) {
                $karyawan->nama_dept = $dept->nama_dept;
            }
        }

        $data['karyawan'] = $karyawan;
        
        $agent = new Agent();
        if ($agent->isMobile()) {
            return view('checklistibadah.create_mobile', $data);
        }
        return view('checklistibadah.create', $data);
    }

    public function getchecklistibadah(Request $request)
    {

        $user = User::where('id', auth()->user()->id)->first();
        $userkaryawan = Userkaryawan::where('id_user', $user->id)->first();
        $cekibadah = Detailchecklistibadah::join('checklist_ibadah', 'checklist_ibadah_detail.kode_checklist_ibadah', '=', 'checklist_ibadah.kode_checklist_ibadah')
            ->where('tanggal', $request->tanggal)
            ->where('npp', $userkaryawan->npp)
            ->select('checklist_ibadah_detail.id_kegiatan_ibadah', 'checklist_ibadah_detail.kode_checklist_ibadah');


        $kegiatan_ibadah = Kegiatanibadah::join('kategori_ibadah', 'kegiatan_ibadah.id_kategori_ibadah', '=', 'kategori_ibadah.id')
            ->leftJoinsub($cekibadah, 'cekibadah', function ($join) {
                $join->on('kegiatan_ibadah.id', '=', 'cekibadah.id_kegiatan_ibadah');
            })
            ->select('kegiatan_ibadah.*', 'kategori_ibadah.kategori_ibadah', 'id_kegiatan_ibadah', 'kode_checklist_ibadah')
            ->orderBy('kegiatan_ibadah.id_kategori_ibadah')
            ->orderBy('kegiatan_ibadah.id', 'asc')
            ->get();
        $data['kegiatan_ibadah'] = $kegiatan_ibadah;
        return view('checklistibadah.getchecklistibadah', $data);
    }


    public function store(Request $request)
    {
        $user = User::where('id', auth()->user()->id)->first();
        $userkaryawan = Userkaryawan::where('id_user', $user->id)->first();
        DB::beginTransaction();
        try {
            $checklist_ibadah = Checklistibadah::where('tanggal', $request->tanggal)
                ->where('npp', $userkaryawan->npp)
                ->first();

            $is_first_submit = false;
            if (!$checklist_ibadah) {
                $is_first_submit = true;
            } else {
                $detail_count = Detailchecklistibadah::where('kode_checklist_ibadah', $checklist_ibadah->kode_checklist_ibadah)->count();
                if ($detail_count === 0) {
                    $is_first_submit = true;
                }
            }

            if ($checklist_ibadah) {
                Detailchecklistibadah::create([
                    'kode_checklist_ibadah' => $checklist_ibadah->kode_checklist_ibadah,
                    'id_kegiatan_ibadah' => $request->id,
                ]);
            } else {
                try {
                    $last_checklist_ibadah = Checklistibadah::orderBy('kode_checklist_ibadah', 'desc')
                        ->first();
                    $last_kode = $last_checklist_ibadah ? $last_checklist_ibadah->kode_checklist_ibadah : '';
                    if (empty($last_kode)) {
                        $format = date('ymd', strtotime($request->tanggal));
                        $kode_checklist_ibadah = buatkode('', $format, 4);
                    } else {
                        $kode_checklist_ibadah = strval(intval($last_kode) + 1);
                    }
                    $checklist_ibadah = Checklistibadah::create([
                        'kode_checklist_ibadah' => $kode_checklist_ibadah,
                        'tanggal' => $request->tanggal,
                        'npp' => $userkaryawan->npp,
                    ]);
                } catch (\Illuminate\Database\QueryException $e) {
                    if ($e->errorInfo[1] == 1062) {
                        $checklist_ibadah = Checklistibadah::where('tanggal', $request->tanggal)
                            ->where('npp', $userkaryawan->npp)
                            ->first();
                        $is_first_submit = false;
                    } else {
                        throw $e;
                    }
                }
                
                if ($checklist_ibadah) {
                    Detailchecklistibadah::create([
                        'kode_checklist_ibadah' => $checklist_ibadah->kode_checklist_ibadah,
                        'id_kegiatan_ibadah' => $request->id,
                    ]);
                }
            }
            DB::commit();

            if ($is_first_submit) {
                // Dispatch WhatsApp Group notification
                \App\Jobs\SendChecklistIbadahJob::dispatch($request->tanggal, $userkaryawan->npp);
            }

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil disimpan',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Data gagal disimpan ' . $e->getMessage(),
            ]);
        }
    }

    public function delete(Request $request)
    {
        try {
            //code...
            Detailchecklistibadah::where('kode_checklist_ibadah', $request->kode)
                ->where('id_kegiatan_ibadah', $request->id)
                ->delete();

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil dihapus',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Data gagal dihapus ' . $e->getMessage(),
            ]);
            //throw $th;
        }
    }
}

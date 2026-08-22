<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Programkerja;
use App\Models\Tahunajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProgramkerjaController extends Controller
{
    public function index(Request $request)
    {
        try {
            $user = $request->user();
            
            $query = Programkerja::query()
                ->select(
                    'program_kerja.kode_program_kerja',
                    'program_kerja.program_kerja',
                    'program_kerja.target_pencapaian',
                    'program_kerja.keterangan',
                    'program_kerja_group.kode_dept',
                    'program_kerja_group.kode_unit',
                    'unit.nama_unit',
                    'program_kerja_group.kode_jabatan',
                    'jabatan.nama_jabatan'
                )
                ->join('program_kerja_group', 'program_kerja.kode_program_kerja_group', '=', 'program_kerja_group.kode_program_kerja_group')
                ->join('unit', 'program_kerja_group.kode_unit', '=', 'unit.kode_unit')
                ->join('jabatan', 'program_kerja_group.kode_jabatan', '=', 'jabatan.kode_jabatan');

            // Filter based on user's department and unit
            $query->where('program_kerja_group.kode_dept', $user->kode_dept);
            if (!empty($user->kode_unit)) {
                $query->where('program_kerja_group.kode_unit', $user->kode_unit);
            }

            // Optional search filter
            if (!empty($request->search)) {
                $query->where('program_kerja.program_kerja', 'like', '%' . $request->search . '%');
            }

            // Optional TA filter or fallback to active TA
            $ta_aktif = Tahunajaran::where('status', 1)->first();
            if (!empty($request->kode_ta)) {
                $query->where('program_kerja_group.kode_ta', $request->kode_ta);
            } elseif ($ta_aktif) {
                $query->where('program_kerja_group.kode_ta', $ta_aktif->kode_ta);
            }

            $programs = $query->orderBy('program_kerja.created_at', 'desc')->get();

            $tahun_ajaran = Tahunajaran::orderBy('tahun_ajaran', 'desc')->get(['kode_ta', 'tahun_ajaran', 'status']);

            return response()->json([
                'success' => true,
                'data' => $programs,
                'tahun_ajaran' => $tahun_ajaran,
                'ta_aktif' => $ta_aktif ? $ta_aktif->kode_ta : null
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $user = $request->user();
            
            $request->validate([
                'program_kerja' => 'required',
                'target_pencapaian' => 'required',
                'keterangan' => 'nullable',
            ]);

            $kode_jabatan = $user->kode_jabatan;
            $kode_dept = $user->kode_dept;
            $kode_unit = $user->kode_unit;

            $ta_aktif = Tahunajaran::where('status', '1')->first();
            if (!$ta_aktif) {
                return response()->json(['success' => false, 'message' => 'Tahun ajaran aktif tidak ditemukan.'], 400);
            }

            $ta = explode("/", $ta_aktif->tahun_ajaran);
            $format = substr($ta[0], 2, 2) . substr($ta[1], 2, 2) . $kode_dept;
            $groupId = substr($ta_aktif->kode_ta . $kode_jabatan . $kode_dept . ($kode_unit ?: 'U00'), 0, 15);

            \App\Models\ProgramkerjaGroup::firstOrCreate(
                ['kode_program_kerja_group' => $groupId],
                [
                    'kode_unit' => $kode_unit,
                    'kode_dept' => $kode_dept,
                    'kode_jabatan' => $kode_jabatan,
                    'kode_ta' => $ta_aktif->kode_ta,
                    'id_user' => $user->id
                ]
            );

            $lastprogramkerja = Programkerja::where('kode_program_kerja_group', $groupId)
                ->orderBy('kode_program_kerja', 'desc')
                ->first();

            $last_kode_program_kerja = $lastprogramkerja !== null ? $lastprogramkerja->kode_program_kerja : '';
            $kode_program_kerja = buatkode($last_kode_program_kerja, $format, 4);

            $program = Programkerja::create([
                'kode_program_kerja' => $kode_program_kerja,
                'kode_program_kerja_group' => $groupId,
                'program_kerja' => $request->program_kerja,
                'target_pencapaian' => $request->target_pencapaian,
                'keterangan' => $request->keterangan,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Program kerja berhasil disimpan',
                'data' => $program
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($kode_program_kerja)
    {
        try {
            $program = Programkerja::where('kode_program_kerja', $kode_program_kerja)->first();
            if (!$program) {
                return response()->json(['success' => false, 'message' => 'Program kerja tidak ditemukan.'], 404);
            }
            
            $program->delete();

            return response()->json([
                'success' => true,
                'message' => 'Program kerja berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}

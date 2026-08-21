<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Agendakegiatan;
use Illuminate\Http\Request;

class AgendakegiatanController extends Controller
{
    public function index(Request $request)
    {
        try {
            $user = $request->user();
            $query = Agendakegiatan::query()
                ->select('agenda_kegiatan.*', 'users.name as user_name')
                ->join('departemen', 'agenda_kegiatan.kode_dept', '=', 'departemen.kode_dept')
                ->join('jabatan', 'agenda_kegiatan.kode_jabatan', '=', 'jabatan.kode_jabatan')
                ->join('users', 'agenda_kegiatan.id_user', '=', 'users.id')
                ->where('agenda_kegiatan.id_user', $user->id);

            if (!empty($request->start_date) && !empty($request->end_date)) {
                $query->whereBetween('tanggal', [$request->start_date, $request->end_date]);
            }

            $agendas = $query->orderBy('tanggal', 'desc')->get();

            return response()->json([
                'success' => true,
                'data' => $agendas
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
                'tanggal' => 'required|date',
                'nama_kegiatan' => 'required|string|max:255',
                'uraian_kegiatan' => 'required|string',
            ]);

            $agenda = Agendakegiatan::create([
                'tanggal' => $request->tanggal,
                'nama_kegiatan' => $request->nama_kegiatan,
                'kode_unit' => $user->kode_unit,
                'kode_jabatan' => $user->kode_jabatan,
                'kode_dept' => $user->kode_dept,
                'uraian_kegiatan' => $request->uraian_kegiatan,
                'id_user' => $user->id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Agenda berhasil disimpan',
                'data' => $agenda
            ], 201);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $user = $request->user();
            $agenda = Agendakegiatan::where('id', $id)
                ->where('id_user', $user->id)
                ->first();

            if (!$agenda) {
                return response()->json(['success' => false, 'message' => 'Data tidak ditemukan atau Anda tidak memiliki akses.'], 404);
            }

            $agenda->delete();

            return response()->json([
                'success' => true,
                'message' => 'Agenda berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}

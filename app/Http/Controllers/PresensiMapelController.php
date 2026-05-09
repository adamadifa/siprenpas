<?php

namespace App\Http\Controllers;

use App\Models\JadwalPelajaran;
use App\Models\PresensiMapel;
use App\Models\PresensiMapelDetail;
use App\Models\Siswa;
use App\Models\Tahunajaran;
use App\Models\Unit;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Crypt;

class PresensiMapelController extends Controller
{
    public function index(Request $request)
    {
        $query = PresensiMapel::query();

        if ($request->kode_unit) {
            $query->where('kode_unit', $request->kode_unit);
        }
        if ($request->kode_kelas) {
            $query->where('kode_kelas', $request->kode_kelas);
        }
        if ($request->tanggal) {
            $query->where('tanggal', $request->tanggal);
        }

        $presensi = $query->with(['unit', 'kelas', 'mata_pelajaran', 'guru'])
            ->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $units = Unit::all();
        $kelas = [];
        if ($request->kode_unit) {
            $kelas = Kelas::where('kode_unit', $request->kode_unit)->get();
        }

        return view('akademik.presensi_mapel.index', compact('presensi', 'units', 'kelas'));
    }

    public function create()
    {
        $units = Unit::all();
        return view('akademik.presensi_mapel.create', compact('units'));
    }

    public function getJadwal(Request $request)
    {
        $tanggal = $request->tanggal;
        $hari = date('l', strtotime($tanggal));
        $hariIndo = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Ahad',
        ];
        $hari = $hariIndo[$hari] ?? 'Senin';

        $jadwal = JadwalPelajaran::with(['mapel', 'guru', 'kelas'])
            ->where('kode_unit', $request->kode_unit)
            ->where('kode_kelas', $request->kode_kelas)
            ->where('hari', $hari)
            ->get()
            ->map(function($item) {
                $item->id_encrypted = Crypt::encrypt($item->id);
                return $item;
            });

        return response()->json($jadwal);
    }

    public function input($jadwal_id, $tanggal)
    {
        $jadwal_id = Crypt::decrypt($jadwal_id);
        $jadwal = JadwalPelajaran::with(['mapel', 'guru', 'kelas'])->findOrFail($jadwal_id);

        // Check if already exists
        $presensi = PresensiMapel::where('jadwal_pelajaran_id', $jadwal_id)
            ->where('tanggal', $tanggal)
            ->first();

        if ($presensi) {
            return Redirect::route('presensi-mapel.edit', Crypt::encrypt($presensi->id));
        }

        // Get students in this class
        $students = DB::table('kelas_siswa')
            ->join('siswa', 'kelas_siswa.id_siswa', '=', 'siswa.id_siswa')
            ->join('pendaftaran', 'siswa.id_siswa', '=', 'pendaftaran.id_siswa')
            ->where('kelas_siswa.kode_kelas', $jadwal->kode_kelas)
            ->select('pendaftaran.no_pendaftaran', 'siswa.id_siswa', 'siswa.nama_lengkap')
            ->get();

        return view('akademik.presensi_mapel.input', compact('jadwal', 'tanggal', 'students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jadwal_pelajaran_id' => 'required',
            'tanggal' => 'required',
            'status' => 'required|array',
            'status.*' => 'required'
        ]);

        $jadwal = JadwalPelajaran::findOrFail($request->jadwal_pelajaran_id);

        DB::beginTransaction();
        try {
            if (!$request->status) {
                throw new \Exception('Daftar siswa tidak boleh kosong');
            }
            $presensi = PresensiMapel::create([
                'jadwal_pelajaran_id' => $jadwal->id,
                'kode_unit' => $jadwal->kode_unit,
                'kode_kelas' => $jadwal->kode_kelas,
                'mata_pelajaran_id' => $jadwal->mata_pelajaran_id,
                'guru_id' => $jadwal->guru_id,
                'tanggal' => $request->tanggal,
                'jam_mulai' => $jadwal->jam_mulai,
                'jam_selesai' => $jadwal->jam_selesai,
                'materi' => $request->materi,
                'status_pertemuan' => 1
            ]);

            foreach ($request->status as $siswa_id => $status) {
                PresensiMapelDetail::create([
                    'presensi_mapel_id' => $presensi->id,
                    'siswa_id' => $siswa_id,
                    'status' => $status,
                    'keterangan' => $request->keterangan[$siswa_id] ?? null
                ]);
            }

            DB::commit();
            return Redirect::route('presensi-mapel.index')->with(['success' => 'Presensi Berhasil Disimpan']);
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with(['warning' => 'Error: ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $presensi = PresensiMapel::with(['details.siswa', 'mata_pelajaran', 'guru', 'kelas'])->findOrFail($id);
        
        return view('akademik.presensi_mapel.edit', compact('presensi'));
    }

    public function update(Request $request, $id)
    {
        $id = Crypt::decrypt($id);
        DB::beginTransaction();
        try {
            $presensi = PresensiMapel::findOrFail($id);
            $presensi->update(['materi' => $request->materi]);

            if ($request->status) {
                foreach ($request->status as $siswa_id => $status) {
                    PresensiMapelDetail::where('presensi_mapel_id', $id)
                        ->where('siswa_id', $siswa_id)
                        ->update([
                            'status' => $status,
                            'keterangan' => $request->keterangan[$siswa_id] ?? null
                        ]);
                }
            }

            DB::commit();
            return Redirect::route('presensi-mapel.index')->with(['success' => 'Presensi Berhasil Diupdate']);
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with(['warning' => 'Error: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        try {
            PresensiMapel::findOrFail($id)->delete();
            return Redirect::back()->with(['success' => 'Data Berhasil Dihapus']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['warning' => 'Error: ' . $e->getMessage()]);
        }
    }
}

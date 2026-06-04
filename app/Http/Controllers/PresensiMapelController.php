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

        $isGuru = auth()->user()->hasRole('guru');
        $guruId = null;
        if ($isGuru) {
            $guruModel = \App\Models\Guru::where('npp', auth()->user()->npp)->first();
            $guruId = $guruModel ? $guruModel->id : 0;
            $query->where('guru_id', $guruId);
        }

        $presensi = $query->with(['unit', 'kelas', 'mata_pelajaran', 'guru'])
            ->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        if ($isGuru) {
            $guruUnitCodes = JadwalPelajaran::where('guru_id', $guruId)->pluck('kode_unit')->unique()->toArray();
            $units = Unit::whereIn('kode_unit', $guruUnitCodes)->get();
            $kelas = [];
            if ($request->kode_unit) {
                $guruKelasCodes = JadwalPelajaran::where('guru_id', $guruId)
                    ->where('kode_unit', $request->kode_unit)
                    ->pluck('kode_kelas')
                    ->unique()
                    ->toArray();
                $kelas = Kelas::where('kode_unit', $request->kode_unit)
                    ->whereIn('kode_kelas', $guruKelasCodes)
                    ->get();
            }
        } else {
            $units = Unit::all();
            $kelas = [];
            if ($request->kode_unit) {
                $kelas = Kelas::where('kode_unit', $request->kode_unit)->get();
            }
        }

        $agent = new \Jenssegers\Agent\Agent();
        if ($agent->isMobile()) {
            return view('akademik.presensi_mapel.index_mobile', compact('presensi', 'units', 'kelas'));
        }

        return view('akademik.presensi_mapel.index', compact('presensi', 'units', 'kelas'));
    }

    public function create()
    {
        $isGuru = auth()->user()->hasRole('guru');
        if ($isGuru) {
            $guruModel = \App\Models\Guru::where('npp', auth()->user()->npp)->first();
            $guruId = $guruModel ? $guruModel->id : 0;
            $guruUnitCodes = JadwalPelajaran::where('guru_id', $guruId)->pluck('kode_unit')->unique()->toArray();
            $units = Unit::whereIn('kode_unit', $guruUnitCodes)->get();
        } else {
            $units = Unit::all();
        }
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

        $query = JadwalPelajaran::with(['mapel', 'guru', 'kelas'])
            ->where('kode_unit', $request->kode_unit)
            ->where('kode_kelas', $request->kode_kelas)
            ->where('hari', $hari);

        $isGuru = auth()->user()->hasRole('guru');
        if ($isGuru) {
            $guruModel = \App\Models\Guru::where('npp', auth()->user()->npp)->first();
            $guruId = $guruModel ? $guruModel->id : 0;
            $query->where('guru_id', $guruId);
        }

        $jadwal = $query->get()
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

        if (auth()->user()->hasRole('guru')) {
            $guruModel = \App\Models\Guru::where('npp', auth()->user()->npp)->first();
            $guruId = $guruModel ? $guruModel->id : 0;
            if ($jadwal->guru_id != $guruId) {
                abort(403, 'Akses ditolak.');
            }
        }

        // Check if already exists
        $presensi = PresensiMapel::where('jadwal_pelajaran_id', $jadwal_id)
            ->where('tanggal', $tanggal)
            ->first();

        if ($presensi) {
            return Redirect::route('presensi-mapel.edit', Crypt::encrypt($presensi->id));
        }

        // Get students in this class ordered alphabetically
        $students = DB::table('kelas_siswa')
            ->join('siswa', 'kelas_siswa.id_siswa', '=', 'siswa.id_siswa')
            ->join('pendaftaran', 'siswa.id_siswa', '=', 'pendaftaran.id_siswa')
            ->where('kelas_siswa.kode_kelas', $jadwal->kode_kelas)
            ->select('pendaftaran.no_pendaftaran', 'pendaftaran.foto', 'siswa.id_siswa', 'siswa.nama_lengkap')
            ->orderBy('siswa.nama_lengkap', 'asc')
            ->get();

        $agent = new \Jenssegers\Agent\Agent();
        if ($agent->isMobile()) {
            return view('akademik.presensi_mapel.input_mobile', compact('jadwal', 'tanggal', 'students'));
        }

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

        if (auth()->user()->hasRole('guru')) {
            $guruModel = \App\Models\Guru::where('npp', auth()->user()->npp)->first();
            $guruId = $guruModel ? $guruModel->id : 0;
            if ($jadwal->guru_id != $guruId) {
                abort(403, 'Akses ditolak.');
            }
        }

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
        $presensi = PresensiMapel::with(['details.siswa.pendaftaran', 'mata_pelajaran', 'guru', 'kelas'])->findOrFail($id);
        
        // Sort details alphabetically by student's name
        $presensi->setRelation('details', $presensi->details->sortBy(function($detail) {
            return $detail->siswa->nama_lengkap ?? '';
        }));
        
        if (auth()->user()->hasRole('guru')) {
            $guruModel = \App\Models\Guru::where('npp', auth()->user()->npp)->first();
            $guruId = $guruModel ? $guruModel->id : 0;
            if ($presensi->guru_id != $guruId) {
                abort(403, 'Akses ditolak.');
            }
        }

        $agent = new \Jenssegers\Agent\Agent();
        if ($agent->isMobile()) {
            return view('akademik.presensi_mapel.edit_mobile', compact('presensi'));
        }

        return view('akademik.presensi_mapel.edit', compact('presensi'));
    }

    public function update(Request $request, $id)
    {
        $id = Crypt::decrypt($id);
        
        if (auth()->user()->hasRole('guru')) {
            $presensi = PresensiMapel::findOrFail($id);
            $guruModel = \App\Models\Guru::where('npp', auth()->user()->npp)->first();
            $guruId = $guruModel ? $guruModel->id : 0;
            if ($presensi->guru_id != $guruId) {
                abort(403, 'Akses ditolak.');
            }
        }

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

        if (auth()->user()->hasRole('guru')) {
            $presensi = PresensiMapel::findOrFail($id);
            $guruModel = \App\Models\Guru::where('npp', auth()->user()->npp)->first();
            $guruId = $guruModel ? $guruModel->id : 0;
            if ($presensi->guru_id != $guruId) {
                abort(403, 'Akses ditolak.');
            }
        }

        try {
            PresensiMapel::findOrFail($id)->delete();
            return Redirect::back()->with(['success' => 'Data Berhasil Dihapus']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['warning' => 'Error: ' . $e->getMessage()]);
        }
    }
}

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
        $activeTa = Tahunajaran::where('status', 1)->first();
        $selectedKodeTa = $request->kode_ta ?: ($activeTa ? $activeTa->kode_ta : null);
        $semuaTa = Tahunajaran::orderBy('tahun_ajaran', 'desc')->get();

        $query = PresensiMapel::query()
            ->join('kelas', 'presensi_mapel.kode_kelas', '=', 'kelas.kode_kelas')
            ->select('presensi_mapel.*');

        $user = auth()->user();
        $guru = null;
        if (!empty($user->npp)) {
            $guru = \App\Models\Guru::where('npp', $user->npp)->first();
        }
        $isGuru = $user->hasRole('guru') || ($guru !== null);
        $guruId = $guru ? $guru->id : 0;

        if ($user->kode_unit != 'U06' && !$isGuru && !$user->hasRole('super admin')) {
            $query->where('presensi_mapel.kode_unit', $user->kode_unit);
        } else {
            if ($request->filled('kode_unit')) {
                $query->where('presensi_mapel.kode_unit', $request->kode_unit);
            }
        }

        if ($selectedKodeTa) {
            $query->where('kelas.kode_ta', $selectedKodeTa);
        }

        if ($request->filled('kode_kelas')) {
            $query->where('presensi_mapel.kode_kelas', $request->kode_kelas);
        }
        if ($request->filled('tanggal')) {
            $query->where('presensi_mapel.tanggal', $request->tanggal);
        }

        if ($isGuru) {
            $query->where('presensi_mapel.guru_id', $guruId);
        }

        $presensi = $query->with(['unit', 'kelas', 'mata_pelajaran', 'guru.karyawan', 'details'])
            ->orderBy('presensi_mapel.tanggal', 'desc')
            ->orderBy('presensi_mapel.jam_mulai', 'asc')
            ->paginate(15);

        if ($isGuru) {
            $guruUnitCodes = JadwalPelajaran::where('guru_id', $guruId)->pluck('kode_unit')->unique()->toArray();
            $units = Unit::whereIn('kode_unit', $guruUnitCodes)->get();
            $kelas = [];
            if ($request->filled('kode_unit')) {
                $guruKelasCodes = JadwalPelajaran::where('guru_id', $guruId)
                    ->where('kode_unit', $request->kode_unit)
                    ->pluck('kode_kelas')
                    ->unique()
                    ->toArray();
                $kelas = Kelas::where('kode_unit', $request->kode_unit)
                    ->where('kode_ta', $selectedKodeTa)
                    ->whereIn('kode_kelas', $guruKelasCodes)
                    ->get();
            }
        } else {
            if ($user->kode_unit != 'U06' && !$user->hasRole('super admin')) {
                $units = Unit::where('kode_unit', $user->kode_unit)->get();
                $kelas = Kelas::where('kode_unit', $user->kode_unit)
                    ->where('kode_ta', $selectedKodeTa)
                    ->get();
            } else {
                $units = Unit::all();
                $kelas = [];
                if ($request->filled('kode_unit')) {
                    $kelas = Kelas::where('kode_unit', $request->kode_unit)
                        ->where('kode_ta', $selectedKodeTa)
                        ->get();
                }
            }
        }

        $agent = new \Jenssegers\Agent\Agent();
        if ($agent->isMobile()) {
            return view('akademik.presensi_mapel.index_mobile', compact('presensi', 'units', 'kelas', 'semuaTa', 'selectedKodeTa'));
        }

        return view('akademik.presensi_mapel.index', compact('presensi', 'units', 'kelas', 'semuaTa', 'selectedKodeTa'));
    }

    public function create()
    {
        $user = auth()->user();
        $guru = null;
        if (!empty($user->npp)) {
            $guru = \App\Models\Guru::where('npp', $user->npp)->first();
        }
        $isGuru = $user->hasRole('guru') || ($guru !== null);
        $guruId = $guru ? $guru->id : 0;

        if ($isGuru) {
            $guruUnitCodes = JadwalPelajaran::where('guru_id', $guruId)->pluck('kode_unit')->unique()->toArray();
            $units = Unit::whereIn('kode_unit', $guruUnitCodes)->get();
        } else {
            if ($user->kode_unit != 'U06' && !$user->hasRole('super admin')) {
                $units = Unit::where('kode_unit', $user->kode_unit)->get();
            } else {
                $units = Unit::all();
            }
        }
        return view('akademik.presensi_mapel.create', compact('units'));
    }

    public function getJadwal(Request $request)
    {
        $tanggal = $request->tanggal ?: date('Y-m-d');
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

        $query = JadwalPelajaran::with(['mapel', 'guru.karyawan', 'kelas', 'unit'])
            ->where('kode_unit', $request->kode_unit)
            ->where('kode_kelas', $request->kode_kelas)
            ->where('hari', $hari);

        $user = auth()->user();
        $guru = null;
        if (!empty($user->npp)) {
            $guru = \App\Models\Guru::where('npp', $user->npp)->first();
        }
        $isGuru = $user->hasRole('guru') || ($guru !== null);
        if ($isGuru) {
            $guruId = $guru ? $guru->id : 0;
            $query->where('guru_id', $guruId);
        }

        $jadwal = $query->orderBy('jam_ke', 'asc')->get()
            ->map(function($item) use ($tanggal) {
                $item->id_encrypted = Crypt::encrypt($item->id);
                $presensi = PresensiMapel::where('jadwal_pelajaran_id', $item->id)
                    ->where('tanggal', $tanggal)
                    ->first();
                $item->has_presensi = $presensi ? true : false;
                $item->presensi_id_encrypted = $presensi ? Crypt::encrypt($presensi->id) : null;
                $item->materi_preview = $presensi ? $presensi->materi : null;
                return $item;
            });

        return response()->json($jadwal);
    }

    public function input($jadwal_id, $tanggal)
    {
        $jadwal_id = Crypt::decrypt($jadwal_id);
        $jadwal = JadwalPelajaran::with(['mapel', 'guru.karyawan', 'kelas.unit', 'tahunAjaran'])->findOrFail($jadwal_id);

        $user = auth()->user();
        $guru = null;
        if (!empty($user->npp)) {
            $guru = \App\Models\Guru::where('npp', $user->npp)->first();
        }
        $isGuru = $user->hasRole('guru') || ($guru !== null);
        if ($isGuru && !$user->can('jadwalpelajaran.index') && !$user->hasRole('super admin')) {
            $guruId = $guru ? $guru->id : 0;
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
            ->leftJoin('pendaftaran', 'siswa.id_siswa', '=', 'pendaftaran.id_siswa')
            ->where('kelas_siswa.kode_kelas', $jadwal->kode_kelas)
            ->select('pendaftaran.no_pendaftaran', 'pendaftaran.foto', 'siswa.id_siswa', 'siswa.nisn', 'siswa.nama_lengkap', 'siswa.jenis_kelamin')
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
            'tanggal' => 'required|date',
            'materi' => 'required|string',
            'status' => 'required|array',
            'status.*' => 'required|in:h,i,s,a'
        ], [
            'materi.required' => 'Materi / Pokok pembahasan pembelajaran wajib diisi',
            'status.required' => 'Daftar kehadiran siswa wajib diisi',
            'tanggal.required' => 'Tanggal presensi wajib ditentukan'
        ]);

        $jadwal = JadwalPelajaran::findOrFail($request->jadwal_pelajaran_id);

        $user = auth()->user();
        $guru = null;
        if (!empty($user->npp)) {
            $guru = \App\Models\Guru::where('npp', $user->npp)->first();
        }
        $isGuru = $user->hasRole('guru') || ($guru !== null);
        if ($isGuru && !$user->can('jadwalpelajaran.index') && !$user->hasRole('super admin')) {
            $guruId = $guru ? $guru->id : 0;
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
            return Redirect::route('presensi-mapel.index')->with(['success' => 'Presensi pembelajaran berhasil disimpan']);
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->withInput()->with(['warning' => 'Gagal menyimpan presensi: ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $presensi = PresensiMapel::with(['details.siswa.pendaftaran', 'mata_pelajaran', 'guru.karyawan', 'kelas.unit', 'jadwalPelajaran'])->findOrFail($id);
        
        // Sort details alphabetically by student's name
        $presensi->setRelation('details', $presensi->details->sortBy(function($detail) {
            return $detail->siswa->nama_lengkap ?? '';
        }));
        
        $user = auth()->user();
        $guru = null;
        if (!empty($user->npp)) {
            $guru = \App\Models\Guru::where('npp', $user->npp)->first();
        }
        $isGuru = $user->hasRole('guru') || ($guru !== null);
        if ($isGuru && !$user->can('jadwalpelajaran.index') && !$user->hasRole('super admin')) {
            $guruId = $guru ? $guru->id : 0;
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
        
        $request->validate([
            'materi' => 'required|string',
            'status' => 'required|array',
            'status.*' => 'required|in:h,i,s,a'
        ], [
            'materi.required' => 'Materi / Pokok pembahasan pembelajaran wajib diisi',
            'status.required' => 'Daftar kehadiran siswa wajib diisi'
        ]);

        $user = auth()->user();
        $guru = null;
        if (!empty($user->npp)) {
            $guru = \App\Models\Guru::where('npp', $user->npp)->first();
        }
        $isGuru = $user->hasRole('guru') || ($guru !== null);
        if ($isGuru && !$user->can('jadwalpelajaran.index') && !$user->hasRole('super admin')) {
            $presensi = PresensiMapel::findOrFail($id);
            $guruId = $guru ? $guru->id : 0;
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
            return Redirect::route('presensi-mapel.index')->with(['success' => 'Presensi pembelajaran berhasil diperbarui']);
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->withInput()->with(['warning' => 'Gagal memperbarui presensi: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $id = Crypt::decrypt($id);

        $user = auth()->user();
        $guru = null;
        if (!empty($user->npp)) {
            $guru = \App\Models\Guru::where('npp', $user->npp)->first();
        }
        $isGuru = $user->hasRole('guru') || ($guru !== null);
        if ($isGuru && !$user->can('jadwalpelajaran.index') && !$user->hasRole('super admin')) {
            $presensi = PresensiMapel::findOrFail($id);
            $guruId = $guru ? $guru->id : 0;
            if ($presensi->guru_id != $guruId) {
                abort(403, 'Akses ditolak.');
            }
        }

        try {
            PresensiMapel::findOrFail($id)->delete();
            return Redirect::back()->with(['success' => 'Data presensi mapel berhasil dihapus']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['warning' => 'Gagal menghapus data: ' . $e->getMessage()]);
        }
    }
}

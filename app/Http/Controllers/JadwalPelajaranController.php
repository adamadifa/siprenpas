<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Tahunajaran;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;

class JadwalPelajaranController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->can('jadwalpelajaran.index') && !auth()->user()->hasRole('guru')) {
            abort(403, 'Akses ditolak.');
        }

        // Get Active Tahun Ajaran
        $activeTa = Tahunajaran::where('status', 1)->first();
        
        $user = auth()->user();
        $guru = null;
        if ($user->hasRole('guru')) {
            $guru = Guru::where('npp', $user->npp)->first();
        }

        if ($guru) {
            $semuaTa = Tahunajaran::whereIn('kode_ta', function($q) use ($guru) {
                $q->select('kode_ta')->from('jadwal_pelajaran')->where('guru_id', $guru->id);
            })->orderBy('tahun_ajaran', 'desc')->get();
            if ($semuaTa->isEmpty() && $activeTa) {
                $semuaTa = collect([$activeTa]);
            }
        } else {
            $semuaTa = Tahunajaran::orderBy('tahun_ajaran', 'desc')->get();
        }
        
        $query = JadwalPelajaran::query();
        
        // Filter by Tahun Ajaran (Default to Active if not selected)
        $selectedKodeTa = $request->kode_ta;
        if(!$selectedKodeTa && $activeTa) {
            $selectedKodeTa = $activeTa->kode_ta;
        }

        if ($selectedKodeTa) {
            $query->where('kode_ta', $selectedKodeTa);
        }

        // Filter by Unit
        if ($request->has('kode_unit') && $request->kode_unit != '') {
            $query->where('kode_unit', $request->kode_unit);
        }

        // Filter by Kelas
        if ($request->has('kode_kelas') && $request->kode_kelas != '') {
            $query->where('kode_kelas', $request->kode_kelas);
        }

        // Filter by Guru
        if ($guru) {
            $query->where('guru_id', $guru->id);
        } else {
            if ($request->has('guru_id') && $request->guru_id != '') {
                $query->where('guru_id', $request->guru_id);
            }
        }
        
        // Filter by Hari
        if ($request->has('hari') && $request->hari != '') {
            $query->where('hari', $request->hari);
        }
        
        // Filter by Semester (Default to Active if not selected)
        $activeSemester = \App\Models\Semester::where('status', '1')->first();
        $selectedSemester = $request->semester;
        if(!$selectedSemester && $activeSemester) {
            $selectedSemester = $activeSemester->semester;
        }

        if ($selectedSemester) {
            $query->where('semester', $selectedSemester);
        }

        $jadwal = $query->with(['unit', 'kelas', 'mapel', 'guru', 'tahunAjaran'])->orderBy('hari', 'desc')->orderBy('jam_ke')->get();

        if ($guru) {
            $units = Unit::whereIn('kode_unit', function($q) use ($guru) {
                $q->select('kode_unit')->from('jadwal_pelajaran')->where('guru_id', $guru->id);
            })->get();

            $kelasQuery = Kelas::whereIn('kode_kelas', function($q) use ($guru) {
                $q->select('kode_kelas')->from('jadwal_pelajaran')->where('guru_id', $guru->id);
            });
            if ($request->has('kode_unit') && $request->kode_unit != '') {
                $kelasQuery->where('kode_unit', $request->kode_unit);
            }
            $kelas = $kelasQuery->orderBy('nama_kelas')->get();

            $gurus = [];
        } else {
            $units = Unit::all();
            if ($request->has('kode_unit') && $request->kode_unit != '') {
                $kelas = Kelas::where('kode_unit', $request->kode_unit)->orderBy('nama_kelas')->get();
                $gurus = Guru::with('karyawan')->where('kode_unit', $request->kode_unit)->where('status_aktif_ajar', 1)->get();
            } else {
                $kelas = Kelas::orderBy('nama_kelas')->get();
                $gurus = Guru::with('karyawan')->where('status_aktif_ajar', 1)->get();
            }
        }
        
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Ahad'];
        $semesters = [1, 2];
        
        $agent = new \Jenssegers\Agent\Agent();
        if ($agent->isMobile()) {
            return view('akademik.jadwal_pelajaran.index_mobile', compact('jadwal', 'units', 'kelas', 'gurus', 'activeTa', 'semuaTa', 'selectedKodeTa', 'selectedSemester', 'days', 'semesters'));
        }
        
        return view('akademik.jadwal_pelajaran.index', compact('jadwal', 'units', 'kelas', 'gurus', 'activeTa', 'semuaTa', 'selectedKodeTa', 'selectedSemester', 'days', 'semesters'));
    }

    public function create()
    {
        $activeTa = Tahunajaran::where('status', 1)->first();
        if (!$activeTa) {
            return '<div class="alert alert-danger">Tidak ada Tahun Ajaran Aktif!</div>';
        }

        $units = Unit::all();
        // Initially empty, waiting for User to select Unit
        $kelas = []; 
        $mapels = [];
        $gurus = []; // Initially empty
        
        return view('akademik.jadwal_pelajaran.create', compact('units', 'kelas', 'mapels', 'gurus', 'activeTa'));
    }

    public function getDataByUnit(Request $request)
    {
        if (!auth()->user()->can('jadwalpelajaran.index') && !auth()->user()->hasRole('guru')) {
            return response()->json([
                'status' => 'error',
                'message' => 'Akses ditolak.'
            ], 403);
        }

        $kode_unit = $request->kode_unit;
        $activeTa = Tahunajaran::where('status', 1)->first();

        if (!$activeTa || !$kode_unit) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid Request or No Active TA'
            ]);
        }

        $user = auth()->user();
        $guru = null;
        if ($user->hasRole('guru')) {
            $guru = Guru::where('npp', $user->npp)->first();
        }

        if ($guru) {
            $kelas = Kelas::where('kode_unit', $kode_unit)
                          ->whereIn('kode_kelas', function($q) use ($guru) {
                              $q->select('kode_kelas')->from('jadwal_pelajaran')->where('guru_id', $guru->id);
                          })
                          ->orderBy('nama_kelas')
                          ->get();

            $mapels = MataPelajaran::where('kode_unit', $kode_unit)
                                   ->where('aktif', 1)
                                   ->whereIn('id', function($q) use ($guru) {
                                       $q->select('mata_pelajaran_id')->from('jadwal_pelajaran')->where('guru_id', $guru->id);
                                   })
                                   ->orderBy('nama_matpel')
                                   ->get();

            $gurus = [];
        } else {
            $kelas = Kelas::where('kode_unit', $kode_unit)
                          ->where('kode_ta', $activeTa->kode_ta)
                          ->orderBy('nama_kelas')
                          ->get();

            $mapels = MataPelajaran::where('kode_unit', $kode_unit)
                                   ->where('aktif', 1)
                                   ->orderBy('nama_matpel')
                                   ->get();

            $gurus = Guru::with('karyawan')
                         ->where('kode_unit', $kode_unit)
                         ->where('status_aktif_ajar', 1)
                         ->get();
        }

        return response()->json([
            'status' => 'success',
            'kelas' => $kelas,
            'mapel' => $mapels,
            'guru' => $gurus
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_unit' => 'required',
            'kode_kelas' => 'required',
            'mata_pelajaran_id' => 'required',
            'guru_id' => 'required',
            'hari' => 'required',
            'jam_ke' => 'required|numeric',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'semester' => 'required'
        ]);

        try {
            // Get Active TA
            $activeTa = Tahunajaran::where('status', 1)->first();
            if (!$activeTa) {
                return Redirect::back()->with(['warning' => 'Data Gagal Disimpan: Tidak ada Tahun Ajaran Aktif']);
            }

            JadwalPelajaran::create([
                'kode_unit' => $request->kode_unit,
                'kode_ta' => $activeTa->kode_ta,
                'kode_kelas' => $request->kode_kelas,
                'mata_pelajaran_id' => $request->mata_pelajaran_id,
                'guru_id' => $request->guru_id,
                'hari' => $request->hari,
                'jam_ke' => $request->jam_ke,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'semester' => $request->semester
            ]);

            return Redirect::route('jadwal-pelajaran.index')->with(['success' => 'Data Berhasil Disimpan']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['warning' => 'Data Gagal Disimpan: ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $jadwal = JadwalPelajaran::findOrFail($id);
        $activeTa = Tahunajaran::where('status', 1)->first();
        
        $units = Unit::all();
        // Load kelas match Unit and TA of the jadwal
        $kelas = Kelas::where('kode_unit', $jadwal->kode_unit)
                      ->where('kode_ta', $jadwal->kode_ta)
                      ->orderBy('nama_kelas')->get();
                      
        // Load mapel match Unit
        $mapels = MataPelajaran::where('kode_unit', $jadwal->kode_unit)
                               ->where('aktif', 1)
                               ->orderBy('nama_matpel')->get();

        // Load gurus match Unit
        $gurus = Guru::with('karyawan')
                     ->where('kode_unit', $jadwal->kode_unit)
                     ->where('status_aktif_ajar', 1)
                     ->get();

        return view('akademik.jadwal_pelajaran.edit', compact('jadwal', 'units', 'kelas', 'mapels', 'gurus'));
    }

    public function update(Request $request, $id)
    {
        $id = Crypt::decrypt($id);
        $request->validate([
            'kode_unit' => 'required',
            'kode_kelas' => 'required',
            'mata_pelajaran_id' => 'required',
            'guru_id' => 'required',
            'hari' => 'required',
            'jam_ke' => 'required|numeric',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'semester' => 'required'
        ]);

        try {
            $jadwal = JadwalPelajaran::findOrFail($id);
            $jadwal->update([
                'kode_unit' => $request->kode_unit,
                'kode_kelas' => $request->kode_kelas,
                'mata_pelajaran_id' => $request->mata_pelajaran_id,
                'guru_id' => $request->guru_id,
                'hari' => $request->hari,
                'jam_ke' => $request->jam_ke,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'semester' => $request->semester
            ]);

            return Redirect::route('jadwal-pelajaran.index')->with(['success' => 'Data Berhasil Diupdate']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['warning' => 'Data Gagal Diupdate: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        try {
            $jadwal = JadwalPelajaran::findOrFail($id);
            $jadwal->delete();
            return Redirect::back()->with(['success' => 'Data Berhasil Dihapus']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['warning' => 'Data Gagal Dihapus: ' . $e->getMessage()]);
        }
    }

    public function cetakPresensi($id)
    {
        $id = Crypt::decrypt($id);
        $jadwal = JadwalPelajaran::with(['unit', 'kelas', 'mapel', 'guru.karyawan', 'tahunAjaran'])->findOrFail($id);

        $user = auth()->user();
        if (!$user->can('jadwalpelajaran.index') && !$user->hasRole('guru')) {
            abort(403, 'Akses ditolak.');
        }

        if ($user->hasRole('guru') && !$user->can('jadwalpelajaran.index')) {
            $guru = Guru::where('npp', $user->npp)->first();
            if ($guru) {
                $isWaliKelas = Kelas::where('kode_kelas', $jadwal->kode_kelas)
                    ->where('guru_id', $guru->id)
                    ->exists();
                if ($jadwal->guru_id !== $guru->id && !$isWaliKelas) {
                    abort(403, 'Akses ditolak. Anda hanya dapat mencetak presensi kelas bimbingan atau kelas Anda sendiri.');
                }
            } else {
                abort(403, 'Akses ditolak. Data guru tidak ditemukan.');
            }
        }

        // Get students in this class
        $students = \App\Models\Kelassiswa::with('siswa')
            ->where('kode_kelas', $jadwal->kode_kelas)
            ->get()
            ->sortBy(function($item) {
                return $item->siswa->nama_lengkap ?? '';
            });

        // Get attendance records for this schedule
        $presensi = \App\Models\PresensiMapel::with('details')
            ->where('jadwal_pelajaran_id', $jadwal->id)
            ->orderBy('tanggal', 'asc')
            ->get();

        // Mapping attendance status for easier access in view
        // Structure: $attMatrix[$siswa_id][$presensi_mapel_id] = status
        $attMatrix = [];
        foreach ($presensi as $p) {
            foreach ($p->details as $d) {
                $attMatrix[$d->siswa_id][$p->id] = $d->status;
            }
        }

        $isPdf = request()->has('pdf');
        if ($isPdf) {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('akademik.jadwal_pelajaran.cetak-presensi', compact('jadwal', 'students', 'presensi', 'attMatrix', 'isPdf'))
                ->setPaper('a4', 'landscape');
            return $pdf->download('Rekap_Presensi_' . str_replace(' ', '_', $jadwal->mapel->nama_matpel) . '_' . $jadwal->kelas->nama_kelas . '.pdf');
        }

        return view('akademik.jadwal_pelajaran.cetak-presensi', compact('jadwal', 'students', 'presensi', 'attMatrix', 'isPdf'));
    }
}

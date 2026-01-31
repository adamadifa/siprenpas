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
        // Get Active Tahun Ajaran
        $activeTa = Tahunajaran::where('status', 1)->first();
        $semuaTa = Tahunajaran::orderBy('tahun_ajaran', 'desc')->get();
        
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
        if ($request->has('guru_id') && $request->guru_id != '') {
            $query->where('guru_id', $request->guru_id);
        }
        
        // Filter by Hari
        if ($request->has('hari') && $request->hari != '') {
            $query->where('hari', $request->hari);
        }
        
        // Filter by Semester
        if ($request->has('semester') && $request->semester != '') {
            $query->where('semester', $request->semester);
        }

        $jadwal = $query->with(['unit', 'kelas', 'mapel', 'guru'])->orderBy('hari', 'desc')->orderBy('jam_ke')->get();

        $units = Unit::all();
        
        // Dynamic loading for Filters
        $kelas = [];
        $gurus = [];

        if ($request->has('kode_unit') && $request->kode_unit != '') {
            $kelas = Kelas::where('kode_unit', $request->kode_unit)->orderBy('nama_kelas')->get();
            $gurus = Guru::with('karyawan')->where('kode_unit', $request->kode_unit)->where('status_aktif_ajar', 1)->get();
        } else {
            // Optional: load nothing, or load all. Better load nothing to force unit selection or handle logic in view.
            // For now, let's keep it empty to encourage Unit selection first, 
            // OR if you want 'Semua Kelas' to be functional without unit, you'd need all classes.
            // But user asked for "dependent on unit".
             $kelas = Kelas::orderBy('nama_kelas')->get(); // Fallback if no unit selected, maybe show all? Or Show None? 
             // Logic update: User wanted dynamic. If no unit, maybe show all is fine, but UX wise better to be consistent. 
             // Let's sticking to "Show All" if no Unit selected for filter flexibility, 
             // BUT if Unit selected, filter them.
             
             // Re-reading request: "pada form filter juga sama dong untuk kelas dan guru berdasarkan unit yang dipilih"
             // This implies dependency. 
             // Implementation: If unit selected -> Filter. If not -> Show All (default behavior).
             $gurus = Guru::with('karyawan')->where('status_aktif_ajar', 1)->get();
        }
        
        return view('akademik.jadwal_pelajaran.index', compact('jadwal', 'units', 'kelas', 'gurus', 'activeTa', 'semuaTa', 'selectedKodeTa'));
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
        $kode_unit = $request->kode_unit;
        $activeTa = Tahunajaran::where('status', 1)->first();

        if (!$activeTa || !$kode_unit) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid Request or No Active TA'
            ]);
        }

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
}

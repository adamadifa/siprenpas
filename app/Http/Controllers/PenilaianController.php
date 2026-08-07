<?php

namespace App\Http\Controllers;

use App\Models\BobotPenilaian;
use App\Models\JadwalPelajaran;
use App\Models\Kelassiswa;
use App\Models\NilaiSiswa;
use App\Models\RencanaPenilaian;
use App\Models\Semester;
use App\Models\Tahunajaran;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PenilaianController extends Controller
{
    public function index($jadwal_id)
    {
        $jadwal = JadwalPelajaran::with(['kelas', 'mapel', 'guru', 'tahunAjaran'])->findOrFail($jadwal_id);
        
        // Find or Create Context (Bobot Penilaian)
        // We link it to Kelas, Mapel, TA, Semester.
        // Ignore Guru change for now, or maybe update it if needed.
        // We assume 1 mapel 1 active guru per class per semester.
        
        $bobot = BobotPenilaian::firstOrCreate(
            [
                'kode_kelas' => $jadwal->kode_kelas,
                'mata_pelajaran_id' => $jadwal->mata_pelajaran_id,
                'kode_ta' => $jadwal->kode_ta,
                'semester' => $jadwal->semester,
            ],
            [
                'guru_id' => $jadwal->guru_id,
                'bobot_sumatif' => 60, // Default value
                'bobot_sas' => 40, // Default value
            ]
        );

        $rencanaPenilaian = RencanaPenilaian::where('bobot_penilaian_id', $bobot->id)
            ->withCount('nilaiSiswa')
            ->orderBy('created_at')
            ->get();

        // Get All Students with Grades
        $students = Kelassiswa::where('kode_kelas', $bobot->kode_kelas)
            ->join('siswa', 'kelas_siswa.id_siswa', '=', 'siswa.id_siswa')
            ->leftJoin('pendaftaran', 'siswa.id_siswa', '=', 'pendaftaran.id_siswa')
            ->orderBy('siswa.nama_lengkap')
            ->select('siswa.id_siswa', 'pendaftaran.nis', 'siswa.nama_lengkap', 'pendaftaran.foto')
            ->get();

        // Fetch grades grouped by student and categorization
        $grades = NilaiSiswa::whereIn('rencana_penilaian_id', $rencanaPenilaian->pluck('id'))
            ->get()
            ->groupBy('id_siswa');

        // Calculate Averages per Student
        $students->map(function ($student) use ($grades, $rencanaPenilaian, $bobot) {
            $student_grades = $grades->get($student->id_siswa, collect());
            
            // Sumatif
            $sumatif_ids = $rencanaPenilaian->where('kategori_penilaian', 'SUMATIF')->pluck('id');
            $sumatif_scores = $student_grades->whereIn('rencana_penilaian_id', $sumatif_ids)->pluck('nilai');
            $avg_sumatif = $sumatif_scores->count() > 0 ? $sumatif_scores->avg() : 0;
            
            // SAS
            $sas_ids = $rencanaPenilaian->where('kategori_penilaian', 'SAS')->pluck('id');
            $sas_scores = $student_grades->whereIn('rencana_penilaian_id', $sas_ids)->pluck('nilai');
            $nilai_sas = $sas_scores->count() > 0 ? $sas_scores->avg() : 0; // Usually just one, but avg handles multiple if exists
            
            // Final Calculation
            // Rapor = (AvgSumatif * BobotSumatif%) + (NilaiSAS * BobotSAS%)
            $nilai_rapor = ($avg_sumatif * ($bobot->bobot_sumatif / 100)) + ($nilai_sas * ($bobot->bobot_sas / 100));

            $student->rata_sumatif = number_format($avg_sumatif, 0);
            $student->nilai_sas = number_format($nilai_sas, 0);
            $student->nilai_rapor = number_format($nilai_rapor, 0);
            
            // Capaian Kompetensi Check (Simple Placeholder Logic)
            $student->capaian_kompetensi = $nilai_rapor >= 75 
                ? "Menunjukkan penguasaan yang baik." 
                : "Perlu bimbingan lebih lanjut.";
                
            return $student;
        });

        $agent = new \Jenssegers\Agent\Agent();
        if ($agent->isMobile()) {
            return view('akademik.penilaian.index_mobile', compact('jadwal', 'bobot', 'rencanaPenilaian', 'students'));
        }

        return view('akademik.penilaian.index', compact('jadwal', 'bobot', 'rencanaPenilaian', 'students'));
    }

    public function storeBobot(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:bobot_penilaian,id',
            'bobot_sumatif' => 'required|numeric|min:0|max:100',
            'bobot_sas' => 'required|numeric|min:0|max:100',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        if (($request->bobot_sumatif + $request->bobot_sas) != 100) {
            return Redirect::back()->with('error', 'Total bobot harus 100%');
        }

        $bobot = BobotPenilaian::findOrFail($request->id);
        if ($bobot->status === 'terkirim') {
            return Redirect::back()->with('error', 'Nilai sudah dikirim dan tidak dapat diubah.');
        }

        $bobot->update([
            'bobot_sumatif' => $request->bobot_sumatif,
            'bobot_sas' => $request->bobot_sas,
        ]);

        return Redirect::back()->with('success', 'Bobot penilaian berhasil diperbarui');
    }

    public function storeRencana(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bobot_penilaian_id' => 'required|exists:bobot_penilaian,id',
            'nama_penilaian'     => 'required|string|max:100',
            'kode_penilaian'     => 'required|string|max:10',
            'kategori_penilaian' => 'required|in:SUMATIF,SAS',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $bobot = BobotPenilaian::findOrFail($request->bobot_penilaian_id);
        if ($bobot->status === 'terkirim') {
            return Redirect::back()->with('error', 'Nilai sudah dikirim dan tidak dapat diubah.');
        }

        RencanaPenilaian::create([
            'bobot_penilaian_id' => $request->bobot_penilaian_id,
            'nama_penilaian' => $request->nama_penilaian,
            'kode_penilaian' => $request->kode_penilaian,
            'kategori_penilaian' => $request->kategori_penilaian,
            'keterangan' => $request->keterangan,
            'tanggal_penilaian' => $request->tanggal_penilaian ?? now(),
        ]);

        return Redirect::back()->with('success', 'Rencana penilaian berhasil ditambahkan');
    }

    public function destroyRencana($id)
    {
        $rencana = RencanaPenilaian::with('bobotPenilaian')->findOrFail($id);
        if ($rencana->bobotPenilaian && $rencana->bobotPenilaian->status === 'terkirim') {
            return Redirect::back()->with('error', 'Nilai sudah dikirim dan tidak dapat diubah.');
        }

        $rencana->delete();
        return Redirect::back()->with('success', 'Rencana penilaian berhasil dihapus');
    }

    public function inputNilai($rencana_id)
    {
        $rencana = RencanaPenilaian::with('bobotPenilaian.kelas', 'bobotPenilaian.mapel')->findOrFail($rencana_id);
        $bobot = $rencana->bobotPenilaian;
        $kelas = $bobot->kelas;

        // Get Students in Class
        $students = Kelassiswa::where('kode_kelas', $bobot->kode_kelas)
            ->join('siswa', 'kelas_siswa.id_siswa', '=', 'siswa.id_siswa')
            ->leftJoin('pendaftaran', 'siswa.id_siswa', '=', 'pendaftaran.id_siswa')
            ->orderBy('siswa.nama_lengkap')
            ->select('siswa.id_siswa', 'pendaftaran.nis', 'siswa.nama_lengkap', 'siswa.jenis_kelamin', 'kelas_siswa.kode_kelas')
            ->get();

        // Get Existing Grades
        $grades = NilaiSiswa::where('rencana_penilaian_id', $rencana_id)
            ->pluck('nilai', 'id_siswa') // [id_siswa => nilai]
            ->toArray();

        return view('akademik.penilaian.input_nilai', compact('rencana', 'bobot', 'kelas', 'students', 'grades'));
    }

    public function storeNilai(Request $request)
    {
        $request->validate([
            'rencana_penilaian_id' => 'required|exists:rencana_penilaian,id',
            'nilai' => 'required|array',
            'nilai.*' => 'nullable|numeric|min:0|max:100',
        ]);

        $rencana = RencanaPenilaian::with('bobotPenilaian')->findOrFail($request->rencana_penilaian_id);
        if ($rencana->bobotPenilaian && $rencana->bobotPenilaian->status === 'terkirim') {
            return Redirect::back()->with('error', 'Nilai sudah dikirim dan tidak dapat diubah.');
        }

        DB::beginTransaction();
        try {
            foreach ($request->nilai as $id_siswa => $score) {
                if ($score !== null) {
                    NilaiSiswa::updateOrCreate(
                        [
                            'rencana_penilaian_id' => $request->rencana_penilaian_id,
                            'id_siswa' => $id_siswa
                        ],
                        [
                            'nilai' => $score
                        ]
                    );
                }
            }
            DB::commit();
            return Redirect::back()->with('success', 'Nilai berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function manageNilai($bobot_id, $kategori)
    {
        $bobot = BobotPenilaian::with(['kelas', 'mapel', 'guru'])->findOrFail($bobot_id);
        
        // Ensure valid category
        if (!in_array($kategori, ['SUMATIF', 'SAS'])) {
            return Redirect::back()->with('error', 'Kategori penilaian tidak valid');
        }
        
        // Get Rencana Penilaian for this category
        $rencanaPenilaian = RencanaPenilaian::where('bobot_penilaian_id', $bobot_id)
            ->where('kategori_penilaian', $kategori)
            ->orderBy('id')
            ->get();
            
        // Get Students
         $students = Kelassiswa::where('kode_kelas', $bobot->kode_kelas)
            ->join('siswa', 'kelas_siswa.id_siswa', '=', 'siswa.id_siswa')
            ->leftJoin('pendaftaran', 'siswa.id_siswa', '=', 'pendaftaran.id_siswa')
            ->orderBy('siswa.nama_lengkap')
            ->select('siswa.id_siswa', 'pendaftaran.nis', 'siswa.nama_lengkap', 'siswa.jenis_kelamin', 'pendaftaran.foto')
            ->get();
            
        // Get Grades for all these assessments
        $grades = NilaiSiswa::whereIn('rencana_penilaian_id', $rencanaPenilaian->pluck('id'))
            ->get()
            ->groupBy('id_siswa'); // Group by Student ID -> Collection of NilaiSiswa
            
        // Map grades to simplified structure: [student_id => [rencana_id => nilai]]
        $mappedGrades = [];
        foreach ($grades as $studentId => $studentGrades) {
            foreach ($studentGrades as $grade) {
                $mappedGrades[$studentId][$grade->rencana_penilaian_id] = $grade->nilai;
            }
        }
        
        $agent = new \Jenssegers\Agent\Agent();
        if ($agent->isMobile()) {
            return view('akademik.penilaian.manage_nilai_mobile', compact('bobot', 'kategori', 'rencanaPenilaian', 'students', 'mappedGrades'));
        }

        return view('akademik.penilaian.manage_nilai', compact('bobot', 'kategori', 'rencanaPenilaian', 'students', 'mappedGrades'));
    }
    
    public function storeMultiNilai(Request $request)
    {
        // Data format: nilai[student_id][rencana_id] = score
        $data = $request->input('nilai'); // Array
        
        if(!$data || !is_array($data)) {
             return Redirect::back()->with('success', 'Tidak ada data nilai yang disimpan');
        }

        // Check lock status
        $firstStudent = reset($data);
        if ($firstStudent && is_array($firstStudent)) {
            $firstRencanaId = key($firstStudent);
            $rencana = RencanaPenilaian::with('bobotPenilaian')->find($firstRencanaId);
            if ($rencana && $rencana->bobotPenilaian && $rencana->bobotPenilaian->status === 'terkirim') {
                return Redirect::back()->with('error', 'Nilai sudah dikirim dan tidak dapat diubah.');
            }
        }

        DB::beginTransaction();
        try {
            foreach ($data as $studentId => $rencanaScores) {
                foreach ($rencanaScores as $rencanaId => $score) {
                    if ($score !== null && $score !== '') {
                        NilaiSiswa::updateOrCreate(
                            [
                                'rencana_penilaian_id' => $rencanaId,
                                'id_siswa' => $studentId
                            ],
                            [
                                'nilai' => $score
                            ]
                        );
                    } else {
                         // Optional: Delete if empty? For now keep or ignore.
                         // Usually if user clears input, we might want to delete.
                         // But 'updateOrCreate' doesn't support delete on null.
                         // Let's assume blank means ignore or existing value stays? 
                         // No, user expects blank to be empty.
                         // Let's check existing.
                         if($score === '' || $score === null) {
                             NilaiSiswa::where('rencana_penilaian_id', $rencanaId)
                                 ->where('id_siswa', $studentId)
                                 ->delete();
                         }
                    }
                }
            }
            DB::commit();
            return Redirect::back()->with('success', 'Nilai berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function kirimNilai(Request $request)
    {
        $request->validate([
            'bobot_id' => 'required|exists:bobot_penilaian,id',
        ]);

        $bobot = BobotPenilaian::findOrFail($request->bobot_id);
        
        if ($bobot->status === 'terkirim') {
            return Redirect::back()->with('warning', 'Nilai sudah terkirim.');
        }

        $bobot->update([
            'status' => 'terkirim'
        ]);

        return Redirect::back()->with('success', 'Nilai berhasil dikirim dan dikunci.');
    }

    public function batalKirimNilai(Request $request)
    {
        $request->validate([
            'bobot_id' => 'required|exists:bobot_penilaian,id',
        ]);

        $bobot = BobotPenilaian::findOrFail($request->bobot_id);
        
        if ($bobot->status !== 'terkirim') {
            return Redirect::back()->with('warning', 'Status pengiriman nilai tidak valid atau belum dikirim.');
        }

        $bobot->update([
            'status' => 'draft'
        ]);

        return Redirect::back()->with('success', 'Status pengiriman nilai berhasil dibatalkan. Anda sekarang dapat mengedit nilai kembali.');
    }

    public function rapor(Request $request)
    {
        $activeTa = Tahunajaran::where('status', 1)->first();
        $semuaTa = Tahunajaran::orderBy('tahun_ajaran', 'desc')->get();
        
        $selectedKodeTa = $request->kode_ta;
        if(!$selectedKodeTa && $activeTa) {
            $selectedKodeTa = $activeTa->kode_ta;
        }

        $activeSemester = Semester::where('status', '1')->first();
        $selectedSemester = $request->semester;
        if(!$selectedSemester) {
            $selectedSemester = $activeSemester ? $activeSemester->semester : '1';
        }

        $user = auth()->user();
        $isGuru = $user->hasRole('guru');

        $query = JadwalPelajaran::query();

        if ($user->kode_unit != 'U06' && !$isGuru) {
            $query->where('kode_unit', $user->kode_unit);
        } else {
            if ($request->has('kode_unit') && $request->kode_unit != '') {
                $query->where('kode_unit', $request->kode_unit);
            }
        }

        if ($isGuru) {
            $guruModel = \App\Models\Guru::where('npp', $user->npp)->first();
            $guruId = $guruModel ? $guruModel->id : 0;
            $query->where('guru_id', $guruId);
        }
        
        if ($selectedKodeTa) {
            $query->where('kode_ta', $selectedKodeTa);
        }
        
        if ($selectedSemester) {
            $query->where('semester', $selectedSemester);
        }

        // Grouping by Unit, Kelas, Mapel, Guru
        // Select the MIN(id) as the representative id for the link to Penilaian
        $jadwalGrouped = $query->with(['unit', 'kelas', 'mapel', 'guru', 'tahunAjaran'])
            ->select('kode_unit', 'kode_kelas', 'mata_pelajaran_id', 'guru_id', 'kode_ta', 'semester', DB::raw('MIN(id) as id'))
            ->groupBy('kode_unit', 'kode_kelas', 'mata_pelajaran_id', 'guru_id', 'kode_ta', 'semester')
            ->get();

        // Avoid N+1 query: Fetch bobot_penilaian statuses
        $bobots = BobotPenilaian::whereIn('kode_kelas', $jadwalGrouped->pluck('kode_kelas'))
            ->whereIn('mata_pelajaran_id', $jadwalGrouped->pluck('mata_pelajaran_id'))
            ->where('kode_ta', $selectedKodeTa)
            ->where('semester', $selectedSemester)
            ->get()
            ->keyBy(function ($item) {
                return $item->kode_kelas . '_' . $item->mata_pelajaran_id;
            });

        $jadwalGrouped->map(function ($d) use ($bobots) {
            $key = $d->kode_kelas . '_' . $d->mata_pelajaran_id;
            $d->status_penilaian = isset($bobots[$key]) ? $bobots[$key]->status : 'draft';
            return $d;
        });

        if ($user->kode_unit != 'U06' && !$isGuru) {
            $units = Unit::where('kode_unit', $user->kode_unit)->get();
        } else {
            $units = Unit::all();
        }

        $agent = new \Jenssegers\Agent\Agent();
        if ($agent->isMobile()) {
            return view('akademik.rapor.index_mobile', compact('jadwalGrouped', 'units', 'activeTa', 'semuaTa', 'selectedKodeTa', 'selectedSemester'));
        }

        return view('akademik.rapor.index', compact('jadwalGrouped', 'units', 'activeTa', 'semuaTa', 'selectedKodeTa', 'selectedSemester'));
    }
}

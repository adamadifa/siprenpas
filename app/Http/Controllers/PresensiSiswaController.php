<?php

namespace App\Http\Controllers;

use App\Models\PresensiSiswa;
use App\Models\Pendaftaran;
use App\Models\Biayasiswa;
use App\Models\Tahunajaran;
use App\Models\Unit;
use App\Models\Kelassiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class PresensiSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (!auth()->user()->can('presensisiswa.index') && !auth()->user()->hasRole('guru')) {
            abort(403, 'Akses ditolak.');
        }

        $tanggal = $request->get('tanggal', date('Y-m-d'));

        // Menggunakan query yang sama seperti pembayaranpendidikan
        $ta_aktif = Tahunajaran::where('status', 1)->first();
        $kode_ta_aktif = $ta_aktif ? $ta_aktif->kode_ta : '';
        $selectedTa = $request->get('kode_ta', $kode_ta_aktif);

        $kelas_siswa = Kelassiswa::join('kelas', 'kelas_siswa.kode_kelas', 'kelas.kode_kelas')
            ->select('kelas_siswa.id_siswa', 'nama_kelas', 'kelas_siswa.kode_kelas');
        if ($selectedTa) {
            $kelas_siswa->where('kelas.kode_ta', $selectedTa);
        }

        $query = Biayasiswa::query();
        $query->select(
            'siswa.*',
            'pendaftaran.no_pendaftaran',
            'pendaftaran.foto as foto_pendaftaran',
            'tahun_ajaran',
            'villages.name as desa',
            'nama_unit',
            'districts.name as kecamatan',
            'provinces.name as provinsi',
            'regencies.name as kota',
            'logo',
            'konfigurasi_biaya.kode_unit',
            'pendaftaran.nis',
            'kelas_siswa.nama_kelas',
            'siswa_biaya.kode_biaya',
            'konfigurasi_biaya.tingkat',
            'siswa_biaya.status_naik_kelas',
            'konfigurasi_biaya.kode_ta',
            'presensi_siswa.id as presensi_id',
            'presensi_siswa.jam_in',
            'presensi_siswa.jam_out',
            'presensi_siswa.status as presensi_status'
        );
        $query->join('pendaftaran', 'siswa_biaya.no_pendaftaran', 'pendaftaran.no_pendaftaran');
        $query->join('siswa', 'pendaftaran.id_siswa', 'siswa.id_siswa');
        $query->join('unit', 'pendaftaran.kode_unit', 'unit.kode_unit');
        $query->join('konfigurasi_biaya', 'siswa_biaya.kode_biaya', 'konfigurasi_biaya.kode_biaya');
        $query->where('konfigurasi_biaya.is_pindahan', 0);
        $query->leftjoin('asal_sekolah', 'pendaftaran.kode_asal_sekolah', 'asal_sekolah.kode_asal_sekolah');
        $query->join('konfigurasi_tahun_ajaran', 'konfigurasi_biaya.kode_ta', 'konfigurasi_tahun_ajaran.kode_ta');
        $query->leftJoin('villages', 'siswa.id_village', '=', 'villages.id');
        $query->leftJoin('districts', 'siswa.id_district', '=', 'districts.id');
        $query->leftJoin('provinces', 'siswa.id_province', '=', 'provinces.id');
        $query->leftJoin('regencies', 'siswa.id_regency', '=', 'regencies.id');
        $query->leftJoinSub($kelas_siswa, 'kelas_siswa', function ($join) {
            $join->on('kelas_siswa.id_siswa', '=', 'siswa.id_siswa');
        });
        // Join dengan presensi_siswa berdasarkan tanggal
        $query->leftJoin('presensi_siswa', function ($join) use ($tanggal) {
            $join->on('pendaftaran.no_pendaftaran', '=', 'presensi_siswa.no_pendaftaran')
                ->where('presensi_siswa.tanggal', '=', $tanggal);
        });
        $query->orderBy('siswa.nama_lengkap');

        // Filter berdasarkan request
        if (!empty($request->nama_lengkap)) {
            $query->where('nama_lengkap', 'like', '%' . $request->nama_lengkap . '%');
        }

        if (!auth()->user()->hasRole('super admin')) {
            $query->where('pendaftaran.kode_unit', auth()->user()->kode_unit);
        } else {
            if (!empty($request->kode_unit)) {
                $query->where('pendaftaran.kode_unit', $request->kode_unit);
            }
        }

        if (!empty($request->kode_ta)) {
            $query->where('konfigurasi_biaya.kode_ta', $request->kode_ta);
        } elseif ($ta_aktif) {
            $query->where('konfigurasi_biaya.kode_ta', $ta_aktif->kode_ta);
        }

        if (!empty($request->tingkat)) {
            $query->where('konfigurasi_biaya.tingkat', $request->tingkat);
        }

        if (!empty($request->kode_kelas)) {
            $query->where('kelas_siswa.kode_kelas', $request->kode_kelas);
        }

        $isGuru = auth()->user()->hasRole('guru');
        $kelasBinaanUnits = [];
        if ($isGuru) {
            $guruModel = \App\Models\Guru::where('npp', auth()->user()->npp)->first();
            $guruId = $guruModel ? $guruModel->id : 0;
            
            $kelasBinaanQuery = \App\Models\Kelas::where('guru_id', $guruId);
            if (!empty($request->kode_ta)) {
                $kelasBinaanQuery->where('kode_ta', $request->kode_ta);
            } elseif ($ta_aktif) {
                $kelasBinaanQuery->where('kode_ta', $ta_aktif->kode_ta);
            }
            
            $kelasBinaan = $kelasBinaanQuery->get();
            $kelasBinaanCodes = $kelasBinaan->pluck('kode_kelas')->toArray();
            $kelasBinaanUnits = $kelasBinaan->pluck('kode_unit')->unique()->toArray();

            $query->whereIn('kelas_siswa.kode_kelas', $kelasBinaanCodes);
        }

        $pendaftaran = $query->paginate(30);
        $pendaftaran->appends($request->all());

        // Data untuk filter
        $data['pendaftaran'] = $pendaftaran;
        $data['tanggal'] = $tanggal;
        $data['tahun_ajaran'] = $ta_aktif;
        if ($isGuru) {
            $data['unit'] = Unit::whereIn('kode_unit', $kelasBinaanUnits)->get();
        } elseif (!auth()->user()->hasRole('super admin')) {
            $data['unit'] = Unit::where('kode_unit', auth()->user()->kode_unit)->get();
        } else {
            $data['unit'] = Unit::all();
        }
        $data['tahunajaran'] = Tahunajaran::orderBy('kode_ta')->get();
        $data['jenis_kelamin'] = config('global.jenis_kelamin');

        return view('presensisiswa.index', $data);
    }

    /**
     * Halaman public untuk presensi siswa dengan RFID
     */
    public function publicPresensi()
    {
        // Ambil data presensi hari ini dengan UNION untuk memisahkan jam_in dan jam_out
        $today = now()->format('Y-m-d');
        $riwayatPresensi = DB::table(DB::raw("(
            SELECT
                ps.id,
                ps.no_pendaftaran,
                s.nama_lengkap,
                k.nama_kelas,
                u.nama_unit,
                ps.tanggal,
                ps.jam_in as jam_presensi,
                ps.status,
                ps.created_at,
                'masuk' as jenis_presensi,
                p.foto as foto_siswa
            FROM presensi_siswa ps
            JOIN pendaftaran p ON ps.no_pendaftaran = p.no_pendaftaran
            JOIN siswa s ON p.id_siswa = s.id_siswa
            JOIN unit u ON p.kode_unit = u.kode_unit
            LEFT JOIN kelas_siswa ks ON s.id_siswa = ks.id_siswa
            LEFT JOIN kelas k ON ks.kode_kelas = k.kode_kelas
            WHERE ps.jam_in IS NOT NULL AND ps.tanggal = '$today'

            UNION ALL

            SELECT
                ps.id,
                ps.no_pendaftaran,
                s.nama_lengkap,
                k.nama_kelas,
                u.nama_unit,
                ps.tanggal,
                ps.jam_out as jam_presensi,
                ps.status,
                ps.updated_at as created_at,
                'keluar' as jenis_presensi,
                p.foto as foto_siswa
            FROM presensi_siswa ps
            JOIN pendaftaran p ON ps.no_pendaftaran = p.no_pendaftaran
            JOIN siswa s ON p.id_siswa = s.id_siswa
            JOIN unit u ON p.kode_unit = u.kode_unit
            LEFT JOIN kelas_siswa ks ON s.id_siswa = ks.id_siswa
            LEFT JOIN kelas k ON ks.kode_kelas = k.kode_kelas
            WHERE ps.jam_out IS NOT NULL AND ps.tanggal = '$today'
        ) as riwayat"))
            ->orderBy('created_at', 'desc')
            ->get();

        return view('public.presensi-siswa', compact('riwayatPresensi'));
    }

    /**
     * Proses scan RFID untuk presensi
     */
    public function scanRfid(Request $request)
    {
        $request->validate([
            'rfid_code' => 'required|string',
        ]);

        $rfidCode = $request->rfid_code;
        $tanggal = date('Y-m-d');
        $jamSekarang = date('H:i:s');

        // Cari siswa berdasarkan rfid_code dengan join kelas dan unit
        $siswa = DB::table('pendaftaran')
            ->join('siswa', 'pendaftaran.id_siswa', '=', 'siswa.id_siswa')
            ->join('unit', 'pendaftaran.kode_unit', '=', 'unit.kode_unit')
            ->leftJoin('kelas_siswa', 'siswa.id_siswa', '=', 'kelas_siswa.id_siswa')
            ->leftJoin('kelas', 'kelas_siswa.kode_kelas', '=', 'kelas.kode_kelas')
            ->select(
                'pendaftaran.no_pendaftaran',
                'siswa.nama_lengkap',
                'kelas.nama_kelas',
                'unit.nama_unit',
                'pendaftaran.foto as foto_siswa'
            )
            ->where('pendaftaran.rfid_code', $rfidCode)
            ->first();

        if (!$siswa) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa tidak ditemukan!',
                'data' => null
            ], 404);
        }

        // Cek apakah sudah ada presensi hari ini
        $presensiHariIni = PresensiSiswa::where('no_pendaftaran', $siswa->no_pendaftaran)
            ->where('tanggal', $tanggal)
            ->first();

        if ($presensiHariIni) {
            // Jika sudah ada presensi, update jam keluar
            if (!$presensiHariIni->jam_out) {
                $presensiHariIni->update([
                    'jam_out' => $jamSekarang,
                    'status' => 'h' // Hadir
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Presensi keluar berhasil!',
                    'data' => [
                        'nama' => $siswa->nama_lengkap,
                        'kelas' => $siswa->nama_kelas ?? '-',
                        'unit' => $siswa->nama_unit ?? '-',
                        'jam_masuk' => $presensiHariIni->jam_in,
                        'jam_keluar' => $jamSekarang,
                        'status' => 'keluar',
                        'foto_siswa' => $siswa->foto_siswa
                    ]
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah melakukan presensi keluar hari ini!',
                    'data' => [
                        'nama' => $siswa->nama_lengkap,
                        'jam_masuk' => $presensiHariIni->jam_in,
                        'jam_keluar' => $presensiHariIni->jam_out,
                        'status' => 'sudah_keluar'
                    ]
                ]);
            }
        } else {
            // Jika belum ada presensi, buat presensi masuk
            PresensiSiswa::create([
                'no_pendaftaran' => $siswa->no_pendaftaran,
                'tanggal' => $tanggal,
                'jam_in' => $jamSekarang,
                'jam_out' => null,
                'status' => 'h' // Hadir
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Presensi masuk berhasil!',
                'data' => [
                    'nama' => $siswa->nama_lengkap,
                    'kelas' => $siswa->nama_kelas ?? '-',
                    'unit' => $siswa->nama_unit ?? '-',
                    'jam_masuk' => $jamSekarang,
                    'jam_keluar' => null,
                    'status' => 'masuk',
                    'foto_siswa' => $siswa->foto_siswa
                ]
            ]);
        }
    }

    /**
     * Get status presensi siswa
     */
    public function getPresensiStatus($no_pendaftaran)
    {
        $tanggal = date('Y-m-d');

        $presensi = PresensiSiswa::where('no_pendaftaran', $no_pendaftaran)
            ->where('tanggal', $tanggal)
            ->first();

        $siswa = DB::table('pendaftaran')
            ->where('no_pendaftaran', $no_pendaftaran)
            ->first();

        if (!$siswa) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa tidak ditemukan!'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'nama' => $siswa->nama_lengkap,
                'kelas' => $siswa->kelas ?? '-',
                'presensi' => $presensi ? [
                    'jam_masuk' => $presensi->jam_in,
                    'jam_keluar' => $presensi->jam_out,
                    'status' => $presensi->status,
                    'status_label' => $presensi->status_label
                ] : null
            ]
        ]);
    }

    /**
     * Get riwayat presensi hari ini
     */
    public function getRiwayatPresensi()
    {
        $today = now()->format('Y-m-d');
        $riwayatPresensi = DB::table(DB::raw("(
            SELECT
                ps.id,
                ps.no_pendaftaran,
                s.nama_lengkap,
                k.nama_kelas,
                u.nama_unit,
                ps.tanggal,
                ps.jam_in as jam_presensi,
                ps.status,
                ps.created_at,
                'masuk' as jenis_presensi,
                p.foto as foto_siswa
            FROM presensi_siswa ps
            JOIN pendaftaran p ON ps.no_pendaftaran = p.no_pendaftaran
            JOIN siswa s ON p.id_siswa = s.id_siswa
            JOIN unit u ON p.kode_unit = u.kode_unit
            LEFT JOIN kelas_siswa ks ON s.id_siswa = ks.id_siswa
            LEFT JOIN kelas k ON ks.kode_kelas = k.kode_kelas
            WHERE ps.jam_in IS NOT NULL AND ps.tanggal = '$today'

            UNION ALL

            SELECT
                ps.id,
                ps.no_pendaftaran,
                s.nama_lengkap,
                k.nama_kelas,
                u.nama_unit,
                ps.tanggal,
                ps.jam_out as jam_presensi,
                ps.status,
                ps.updated_at as created_at,
                'keluar' as jenis_presensi,
                p.foto as foto_siswa
            FROM presensi_siswa ps
            JOIN pendaftaran p ON ps.no_pendaftaran = p.no_pendaftaran
            JOIN siswa s ON p.id_siswa = s.id_siswa
            JOIN unit u ON p.kode_unit = u.kode_unit
            LEFT JOIN kelas_siswa ks ON s.id_siswa = ks.id_siswa
            LEFT JOIN kelas k ON ks.kode_kelas = k.kode_kelas
            WHERE ps.jam_out IS NOT NULL AND ps.tanggal = '$today'
        ) as riwayat"))
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $riwayatPresensi
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $pendaftaran = Pendaftaran::orderBy('nama_lengkap')->get();
        $statusOptions = PresensiSiswa::getStatusOptions();

        // Pre-fill data jika ada parameter
        $selectedNoPendaftaran = $request->get('no_pendaftaran');
        $selectedTanggal = $request->get('tanggal', date('Y-m-d'));

        return view('presensisiswa.create', compact('pendaftaran', 'statusOptions', 'selectedNoPendaftaran', 'selectedTanggal'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'no_pendaftaran' => 'required|exists:pendaftaran,no_pendaftaran',
            'tanggal' => 'required|date',
            'jam_in' => 'nullable|date_format:H:i',
            'jam_out' => 'nullable|date_format:H:i',
            'status' => 'required|in:h,i,s,a'
        ]);

        // Cek apakah sudah ada presensi untuk no_pendaftaran dan tanggal tersebut
        $existingPresensi = PresensiSiswa::where('no_pendaftaran', $request->no_pendaftaran)
            ->where('tanggal', $request->tanggal)
            ->first();

        if ($existingPresensi) {
            return Redirect::back()->with('error', 'Presensi untuk siswa dan tanggal tersebut sudah ada.');
        }

        try {
            PresensiSiswa::create($request->all());
            return Redirect::route('presensisiswa.index')
                ->with('success', 'Presensi siswa berhasil ditambahkan.');
        } catch (\Exception $e) {
            return Redirect::back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $presensi = DB::table('presensi_siswa as ps')
            ->join('pendaftaran as p', 'ps.no_pendaftaran', '=', 'p.no_pendaftaran')
            ->select(
                'ps.*',
                'p.nama_lengkap',
                'p.kelas'
            )
            ->where('ps.id', $id)
            ->first();

        if (!$presensi) {
            abort(404);
        }

        return view('presensisiswa.show', compact('presensi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $presensi = DB::table('presensi_siswa as ps')
            ->join('pendaftaran as p', 'ps.no_pendaftaran', '=', 'p.no_pendaftaran')
            ->select(
                'ps.*',
                'p.nama_lengkap',
                'p.kelas'
            )
            ->where('ps.id', $id)
            ->first();

        if (!$presensi) {
            abort(404);
        }

        $statusOptions = PresensiSiswa::getStatusOptions();

        return view('presensisiswa.edit', compact('presensi', 'statusOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'jam_in' => 'nullable|date_format:H:i',
            'jam_out' => 'nullable|date_format:H:i',
            'status' => 'required|in:h,i,s,a'
        ]);

        try {
            $presensi = PresensiSiswa::findOrFail($id);
            $presensi->update($request->only(['jam_in', 'jam_out', 'status']));

            return Redirect::route('presensisiswa.index')
                ->with('success', 'Presensi siswa berhasil diperbarui.');
        } catch (\Exception $e) {
            return Redirect::back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $presensi = PresensiSiswa::findOrFail($id);
            $presensi->delete();

            return Redirect::route('presensisiswa.index')
                ->with('success', 'Presensi siswa berhasil dihapus.');
        } catch (\Exception $e) {
            return Redirect::back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Bulk update presensi untuk tanggal tertentu
     */
    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'presensi' => 'required|array',
            'presensi.*.no_pendaftaran' => 'required|exists:pendaftaran,no_pendaftaran',
            'presensi.*.status' => 'required|in:h,i,s,a',
            'presensi.*.jam_in' => 'nullable|date_format:H:i',
            'presensi.*.jam_out' => 'nullable|date_format:H:i',
        ]);

        try {
            foreach ($request->presensi as $data) {
                PresensiSiswa::updateOrCreate(
                    [
                        'no_pendaftaran' => $data['no_pendaftaran'],
                        'tanggal' => $request->tanggal
                    ],
                    [
                        'jam_in' => $data['jam_in'],
                        'jam_out' => $data['jam_out'],
                        'status' => $data['status']
                    ]
                );
            }

            return Redirect::route('presensisiswa.index', ['tanggal' => $request->tanggal])
                ->with('success', 'Presensi siswa berhasil diperbarui.');
        } catch (\Exception $e) {
            return Redirect::back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}

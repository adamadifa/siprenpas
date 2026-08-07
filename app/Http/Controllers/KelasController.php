<?php

namespace App\Http\Controllers;

use App\Models\Biayasiswa;
use App\Models\Kelas;
use App\Models\Kelassiswa;
use App\Models\Pendaftaran;
use App\Models\Tahunajaran;
use App\Models\Unit;
use App\Models\User;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;

class KelasController extends Controller
{
    public function index(Request $request)
    {
        $user = User::where('id', auth()->user()->id)->first();
        
        $ta_aktif = Tahunajaran::where('status', '1')->first();
        $kode_ta = $request->kode_ta ?: ($ta_aktif ? $ta_aktif->kode_ta : null);
        
        $data['ta_aktif'] = $ta_aktif ? $ta_aktif->tahun_ajaran : '';
        $data['kode_ta'] = $kode_ta;

        $data['kelas'] = Kelas::orderBy('kode_kelas')
            ->with(['waliKelas.karyawan'])
            ->join('unit', 'kelas.kode_unit', '=', 'unit.kode_unit')
            ->join('konfigurasi_tahun_ajaran', 'kelas.kode_ta', '=', 'konfigurasi_tahun_ajaran.kode_ta')
            ->select('kelas.*', 'unit.nama_unit', 'konfigurasi_tahun_ajaran.tahun_ajaran')
            ->when($user->kode_unit != 'U06', function ($query) use ($user) {
                $query->where('kelas.kode_unit', $user->kode_unit);
            })
            ->when($kode_ta, function ($query) use ($kode_ta) {
                $query->where('kelas.kode_ta', $kode_ta);
            })
            ->when($request->kode_unit_search, function ($query) use ($request) {
                $query->where('kelas.kode_unit', $request->kode_unit_search);
            })
            ->when($request->nama_kelas_search, function ($query) use ($request) {
                $query->where('kelas.nama_kelas', 'like', '%' . $request->nama_kelas_search . '%');
            })
            ->when($request->guru_id_search, function ($query) use ($request) {
                $query->where('kelas.guru_id', $request->guru_id_search);
            })

            ->get();

        if ($user->kode_unit != 'U06') {
            $data['unit'] = Unit::where('kode_unit', $user->kode_unit)->get();
        } else {
            $u = new Unit();
            $data['unit'] = $u->getUnit();
        }
        
        $data['tahunajaran'] = Tahunajaran::orderBy('kode_ta')->get();
        
        $waliQuery = Guru::with('karyawan');
        if ($user->kode_unit != 'U06') {
            $waliQuery->where('kode_unit', $user->kode_unit);
        }
        $data['wali_kelas_list'] = $waliQuery->whereIn('id', function($query) {
                $query->select('guru_id')->from('kelas')->whereNotNull('guru_id');
            })
            ->get()
            ->sortBy(function($g) {
                return $g->karyawan->nama_lengkap ?? '';
            });
        return view('datamaster.kelas.index', $data);
    }


    public function create()
    {
        $user = User::where('id', auth()->user()->id)->first();
        if ($user->kode_unit != 'U06') {
            $data['unit'] = Unit::where('kode_unit', $user->kode_unit)->get();
        } else {
            $u = new Unit();
            $data['unit'] = $u->getUnit();
        }
        $data['user'] = $user;
        
        $guruQuery = Guru::with('karyawan')->where('status_aktif_ajar', 1);
        if ($user->kode_unit != 'U06') {
            $guruQuery->where('kode_unit', $user->kode_unit);
        }
        $data['gurus'] = $guruQuery->get()->sortBy(function($g) {
            return $g->karyawan->nama_lengkap ?? '';
        });
        return view('datamaster.kelas.create', $data);
    }


    public function store(Request $request)
    {
        $user = User::where('id', auth()->user()->id)->first();
        $request->validate([
            'kode_kelas' => 'unique:kelas,kode_kelas',
            'nama_kelas' => 'required',
            'kode_unit' => 'required',
            'tingkat' => 'required',
            'guru_id' => 'nullable|exists:guru,id',
        ]);
        $ta_aktif = Tahunajaran::where('status', '1')->first();
        if (!$ta_aktif) {
            return Redirect::back()->with(messageError('Tahun ajaran aktif tidak ditemukan.'));
        }
        $tahun_ajaran = str_replace("TA", "", $ta_aktif->kode_ta);
        $kode_unit = $request->kode_unit;

        $last_kelas = Kelas::where('kode_unit', $kode_unit)->where('kode_ta', $ta_aktif->kode_ta)->orderBy('kode_kelas', 'desc')->first();
        $last_kode_kelas = $last_kelas ? $last_kelas->kode_kelas : '';
        $kode_kelas = buatkode($last_kode_kelas, $tahun_ajaran . $kode_unit, 2);
        $kode_unit = $user->kode_unit ==  'U06' ? $request->kode_unit : $user->kode_unit;
        try {
            Kelas::create([
                'kode_kelas' => $kode_kelas,
                'nama_kelas' => $request->nama_kelas,
                'kode_unit' => $kode_unit,
                'kode_ta' => $ta_aktif->kode_ta,
                'tingkat' => $request->tingkat,
                'guru_id' => $request->guru_id,
            ]);

            return Redirect::back()->with(messageSuccess('Data Berhasil Disimpan'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }

    public function edit($kode_kelas)
    {
        $kode_kelas = Crypt::decrypt($kode_kelas);
        $user = User::where('id', auth()->user()->id)->first();
        if ($user->kode_unit != 'U06') {
            $data['unit'] = Unit::where('kode_unit', $user->kode_unit)->get();
        } else {
            $u = new Unit();
            $data['unit'] = $u->getUnit();
        }
        $data['kelas'] = Kelas::where('kode_kelas', $kode_kelas)->first();
        
        $guruQuery = Guru::with('karyawan')->where('status_aktif_ajar', 1);
        if ($user->kode_unit != 'U06') {
            $guruQuery->where('kode_unit', $user->kode_unit);
        }
        $data['gurus'] = $guruQuery->get()->sortBy(function($g) {
            return $g->karyawan->nama_lengkap ?? '';
        });
        return view('datamaster.kelas.edit', $data);
    }

    public function update(Request $request, $kode_kelas)
    {
        $kode_kelas = Crypt::decrypt($kode_kelas);
        $request->validate([
            'nama_kelas' => 'required',
            'kode_unit' => 'required',
            'tingkat' => 'required',
            'guru_id' => 'nullable|exists:guru,id',
        ]);
        try {
            Kelas::where('kode_kelas', $kode_kelas)->update([
                'nama_kelas' => $request->nama_kelas,
                'kode_unit' => $request->kode_unit,
                'tingkat' => $request->tingkat,
                'guru_id' => $request->guru_id,
            ]);

            return Redirect::back()->with(messageSuccess('Data Berhasil Diupdate'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }

    public function destroy($kode_kelas)
    {
        $kode_kelas = Crypt::decrypt($kode_kelas);
        try {
            Kelas::where('kode_kelas', $kode_kelas)->delete();
            return Redirect::back()->with(['success' => 'Data Berhasil Dihapus']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => $e->getMessage()]);
        }
    }

    public function setkelas($kode_kelas)
    {
        $kode_kelas = Crypt::decrypt($kode_kelas);
        $data['kelas'] = Kelas::where('kode_kelas', $kode_kelas)
            ->join('unit', 'kelas.kode_unit', '=', 'unit.kode_unit')
            ->select('kelas.*', 'unit.nama_unit')
            ->first();
        return view('datamaster.kelas.setkelas', $data);
    }

    public function tambahsiswa($kode_kelas)
    {
        $kode_kelas = Crypt::decrypt($kode_kelas);
        return view('datamaster.kelas.tambahsiswa');
    }

    public function getsiswa(Request $request)
    {
        $kode_kelas = $request->kode_kelas;
        $nama_siswa = $request->nama_siswa;
        $kelas = Kelas::where('kode_kelas', $kode_kelas)->first();

        $kelas_siswa = Kelassiswa::where('kode_kelas', $kelas->kode_kelas);
        $siswa_pendaftar = Biayasiswa::join('pendaftaran', 'siswa_biaya.no_pendaftaran', '=', 'pendaftaran.no_pendaftaran')
            ->join('konfigurasi_biaya', 'siswa_biaya.kode_biaya', '=', 'konfigurasi_biaya.kode_biaya')
            ->join('siswa', 'pendaftaran.id_siswa', '=', 'siswa.id_siswa')
            ->leftJoinSub($kelas_siswa, 'kelas_siswa', function ($join) {
                $join->on('siswa.id_siswa', '=', 'kelas_siswa.id_siswa');
            })
            ->select('siswa.*', 'pendaftaran.nis', 'pendaftaran.foto as foto_pendaftaran', 'kelas_siswa.id_siswa as ceksiswa')
            ->where('konfigurasi_biaya.kode_ta', $kelas->kode_ta)
            ->where('konfigurasi_biaya.tingkat', $kelas->tingkat)
            ->where('pendaftaran.kode_unit', $kelas->kode_unit)
            ->where('konfigurasi_biaya.is_pindahan', 0)
            ->when(!empty($nama_siswa), function ($query) use ($nama_siswa) {
                return $query->where('siswa.nama_lengkap', 'like', '%' . $nama_siswa . '%');
            })
            ->get();


        return response()->json($siswa_pendaftar);
    }

    public function getkelassiswa(Request $request)
    {
        $kode_kelas = $request->kode_kelas;
        $kelas = Kelas::where('kode_kelas', $kode_kelas)->first();

        $biaya_siswa = Biayasiswa::where('konfigurasi_biaya.kode_ta', $kelas->kode_ta)
            ->join('pendaftaran', 'siswa_biaya.no_pendaftaran', '=', 'pendaftaran.no_pendaftaran')
            ->join('konfigurasi_biaya', 'siswa_biaya.kode_biaya', '=', 'konfigurasi_biaya.kode_biaya')
            ->where('konfigurasi_biaya.is_pindahan', 0)
            ->select('id_siswa', 'nis', 'pendaftaran.foto as foto_pendaftaran');


        $kelas_siswa = Kelassiswa::where('kode_kelas', $kode_kelas)
            ->join('siswa', 'kelas_siswa.id_siswa', '=', 'siswa.id_siswa')
            ->leftJoinSub($biaya_siswa, 'biaya_siswa', function ($join) {
                $join->on('siswa.id_siswa', '=', 'biaya_siswa.id_siswa');
            })
            ->select('siswa.*', 'biaya_siswa.nis', 'biaya_siswa.foto_pendaftaran')
            ->get();


        return response()->json($kelas_siswa);
    }

    public function storetambahsiswa(Request $request)
    {
        $request->validate([
            'id_siswa' => 'required',
            'kode_kelas' => 'required',
        ]);
        try {
            Kelassiswa::create([
                'id_siswa' => $request->id_siswa,
                'kode_kelas' => $request->kode_kelas,
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil Disimpan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function deletesiswa(Request $request)
    {
        $request->validate([
            'id_siswa' => 'required',
            'kode_kelas' => 'required',
        ]);
        try {
            Kelassiswa::where('id_siswa', $request->id_siswa)->where('kode_kelas', $request->kode_kelas)->delete();
            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil Dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function deletekelassiswa(Request $request)
    {
        $request->validate([
            'id_siswa' => 'required',
            'kode_kelas' => 'required',
        ]);
        try {
            Kelassiswa::where('id_siswa', $request->id_siswa)->where('kode_kelas', $request->kode_kelas)->delete();
            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil Dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}

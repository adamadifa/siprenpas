<?php

namespace App\Http\Controllers;

use App\Models\Biayasiswa;
use App\Models\Kelas;
use App\Models\Kelassiswa;
use App\Models\Pendaftaran;
use App\Models\Tahunajaran;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;

class KelasController extends Controller
{
    public function index()
    {
        $data['kelas'] = Kelas::orderBy('kode_kelas')
            ->join('unit', 'kelas.kode_unit', '=', 'unit.kode_unit')
            ->join('konfigurasi_tahun_ajaran', 'kelas.kode_ta', '=', 'konfigurasi_tahun_ajaran.kode_ta')
            ->select('kelas.*', 'unit.nama_unit', 'konfigurasi_tahun_ajaran.tahun_ajaran')
            ->get();
        return view('datamaster.kelas.index', $data);
    }


    public function create()
    {
        $u = new Unit();
        $data['unit'] = $u->getUnit();
        return view('datamaster.kelas.create', $data);
    }


    public function store(Request $request)
    {
        $request->validate([
            'kode_kelas' => 'unique:kelas,kode_kelas',
            'nama_kelas' => 'required',
            'kode_unit' => 'required',
            'tingkat' => 'required',
        ]);
        $ta_aktif = Tahunajaran::where('status', '1')->first();
        $tahun_ajaran = str_replace("TA", "", $ta_aktif->kode_ta);
        $kode_unit = $request->kode_unit;

        $last_kelas = Kelas::where('kode_unit', $kode_unit)->where('kode_ta', $ta_aktif->kode_ta)->orderBy('kode_kelas', 'desc')->first();
        $last_kode_kelas = $last_kelas ? $last_kelas->kode_kelas : '';
        $kode_kelas = buatkode($last_kode_kelas, $tahun_ajaran . $kode_unit, 2);
        try {
            Kelas::create([
                'kode_kelas' => $kode_kelas,
                'nama_kelas' => $request->nama_kelas,
                'kode_unit' => $request->kode_unit,
                'kode_ta' => $ta_aktif->kode_ta,
                'tingkat' => $request->tingkat,
            ]);

            return Redirect::back()->with(messageSuccess('Data Berhasil Disimpan'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }

    public function edit($kode_kelas)
    {
        $kode_kelas = Crypt::decrypt($kode_kelas);
        $u = new Unit();
        $data['unit'] = $u->getUnit();
        $data['kelas'] = Kelas::where('kode_kelas', $kode_kelas)->first();
        return view('datamaster.kelas.edit', $data);
    }

    public function update(Request $request, $kode_kelas)
    {
        $kode_kelas = Crypt::decrypt($kode_kelas);
        $request->validate([
            'nama_kelas' => 'required',
            'kode_unit' => 'required',
            'tingkat' => 'required',
        ]);
        try {
            Kelas::where('kode_kelas', $kode_kelas)->update([
                'nama_kelas' => $request->nama_kelas,
                'kode_unit' => $request->kode_unit,
                'tingkat' => $request->tingkat,
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
            ->select('siswa.*','pendaftaran.nis', 'kelas_siswa.id_siswa as ceksiswa')
            ->where('konfigurasi_biaya.kode_ta', $kelas->kode_ta)
            ->where('konfigurasi_biaya.tingkat', $kelas->tingkat)
            ->where('pendaftaran.kode_unit', $kelas->kode_unit)
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

        $pendaftaran = Pendaftaran::where('kode_ta', $kelas->kode_ta)->select('id_siswa', 'nis');
        $kelas_siswa = Kelassiswa::where('kode_kelas', $kode_kelas)
        ->join('siswa', 'kelas_siswa.id_siswa', '=', 'siswa.id_siswa')
        ->leftJoinSub($pendaftaran, 'pendaftaran', function ($join) {
            $join->on('siswa.id_siswa', '=', 'pendaftaran.id_siswa');
        })
        ->select('siswa.*','pendaftaran.nis')
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

<?php

namespace App\Http\Controllers;

use App\Models\Province;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = Siswa::query();
        if (!empty($request->nama_lengkap)) {
            $query->where('nama_lengkap', 'like', '%' . $request->nama_lengkap . '%');
        }

        if (!empty($request->tahun_masuk)) {
            $query->where('siswa.tahun_masuk', $request->tahun_masuk);
        }

        if (auth()->user()->kode_unit != 'U06') {
            $query->where('siswa.kode_unit', auth()->user()->kode_unit);
        }

        $query->orderBy('siswa.created_at', 'desc');
        $siswa = $query->paginate(15);
        $siswa->appends(request()->all());

        // Statistics
        $tahun_ppdb = config('global.tahun_ppdb');
        $stats['total_siswa'] = Siswa::count();
        $stats['laki_laki'] = Siswa::where('jenis_kelamin', 'L')->count();
        $stats['perempuan'] = Siswa::where('jenis_kelamin', 'P')->count();
        $stats['siswa_baru'] = Siswa::where('tahun_masuk', $tahun_ppdb)->count();

        $tahun_masuk = Siswa::select('tahun_masuk')->distinct()->orderBy('tahun_masuk', 'desc')->get();

        $data['siswa'] = $siswa;
        $data['stats'] = $stats;
        $data['list_tahun_masuk'] = $tahun_masuk;
        $data['jenis_kelamin'] = config('global.jenis_kelamin');
        return view('datamaster.siswa.index', $data);
    }


    public function create()
    {
        $data['provinsi'] = Province::orderBy('name')->get();
        $data['pendidikan'] = config('global.list_pendidikan ');
        return view('datamaster.siswa.create', $data);
    }

    public function store(Request $request)
    {

        $request->validate([
            'nama_lengkap' => 'required',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'anak_ke' => 'required',
            'alamat' => 'required',
            'id_province' => 'required',
            'id_regency' => 'required',
            'id_district' => 'required',
            'id_village' => 'required',
            'kode_pos' => 'required',
            'no_kk' => 'required',
            'nik_ayah' => 'required',
            'nama_ayah' => 'required',
            'pendidikan_ayah' => 'required',
            'pekerjaan_ayah' => 'required',
            'nik_ibu' => 'required',
            'nama_ibu' => 'required',
            'pendidikan_ibu' => 'required',
            'pekerjaan_ibu' => 'required',
            'no_hp_orang_tua' => 'required'
        ]);

        $tahun_masuk = config('global.tahun_ppdb');
        try {
            //Buat ID Siswa

            $last_siswa = Siswa::orderby('id_siswa', 'desc')->where('tahun_masuk', $tahun_masuk)->first();
            $last_id_siswa = $last_siswa != NULL ? $last_siswa->id_siswa : "";
            $id_siswa = buatkode($last_id_siswa, $tahun_masuk, 3);

            Siswa::create([
                'id_siswa' => $id_siswa,
                'nisn' => $request->nisn,
                'nama_lengkap' => $request->nama_lengkap,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'anak_ke' => $request->anak_ke,
                'jumlah_saudara' => $request->jumlah_saudara,
                'alamat' => $request->alamat,
                'id_province' => $request->id_province,
                'id_regency' => $request->id_regency,
                'id_district' => $request->id_district,
                'id_village' => $request->id_village,
                'kode_pos' => $request->kode_pos,
                'no_kk' => $request->no_kk,
                'nik_ayah' => $request->nik_ayah,
                'nama_ayah' => $request->nama_ayah,
                'pendidikan_ayah' => $request->pendidikan_ayah,
                'pekerjaan_ayah' => $request->pekerjaan_ayah,
                'nik_ibu' => $request->nik_ibu,
                'nama_ibu' => $request->nama_ibu,
                'pendidikan_ibu' => $request->pendidikan_ibu,
                'pekerjaan_ibu' => $request->pekerjaan_ibu,
                'no_hp_orang_tua' => $request->no_hp_orang_tua,
                'tahun_masuk' => $tahun_masuk,

            ]);

            return Redirect::back()->with(messageSuccess('Data Berhasil Disimpan'));
        } catch (\Exception $e) {
            dd($e);
            return Redirect::back()->with(messageError($e->getMessage()));
            //throw $th;
        }
    }

    public function show($id_siswa)
    {
        $id_siswa = Crypt::decrypt($id_siswa);
        $data['siswa'] = Siswa::where('id_siswa', $id_siswa)
            ->join('provinces', 'siswa.id_province', '=', 'provinces.id')
            ->join('regencies', 'siswa.id_regency', '=', 'regencies.id')
            ->join('districts', 'siswa.id_district', '=', 'districts.id')
            ->join('villages', 'siswa.id_village', '=', 'villages.id')
            ->select('siswa.*', 'provinces.name as province_name', 'regencies.name as regency_name', 'districts.name as district_name', 'villages.name as village_name')
            ->first();
        return view('datamaster.siswa.show', $data);
    }

    public function edit($id_siswa)
    {
        $id_siswa = Crypt::decrypt($id_siswa);
        $data['siswa'] = Siswa::where('id_siswa', $id_siswa)->first();
        $data['provinsi'] = Province::orderBy('name')->get();
        $data['pendidikan'] = config('global.list_pendidikan ');
        return view('datamaster.siswa.edit', $data);
    }


    public function update(Request $request, $id_siswa)
    {
        $id_siswa = Crypt::decrypt($id_siswa);
        $request->validate([
            'nama_lengkap' => 'required',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'anak_ke' => 'required',
            'alamat' => 'required',
            'id_province' => 'required',
            'id_regency' => 'required',
            'id_district' => 'required',
            'id_village' => 'required',
            'kode_pos' => 'required',
            'no_kk' => 'required',
            'nik_ayah' => 'required',
            'nama_ayah' => 'required',
            'pendidikan_ayah' => 'required',
            'pekerjaan_ayah' => 'required',
            'nik_ibu' => 'required',
            'nama_ibu' => 'required',
            'pendidikan_ibu' => 'required',
            'pekerjaan_ibu' => 'required',
            'no_hp_orang_tua' => 'required'
        ]);

        $tahun_masuk = config('global.tahun_ppdb');
        try {
            //Buat ID Siswa

            Siswa::where('id_siswa', $id_siswa)->update([
                'nisn' => $request->nisn,
                'nama_lengkap' => $request->nama_lengkap,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'anak_ke' => $request->anak_ke,
                'jumlah_saudara' => $request->jumlah_saudara,
                'alamat' => $request->alamat,
                'id_province' => $request->id_province,
                'id_regency' => $request->id_regency,
                'id_district' => $request->id_district,
                'id_village' => $request->id_village,
                'kode_pos' => $request->kode_pos,
                'no_kk' => $request->no_kk,
                'nik_ayah' => $request->nik_ayah,
                'nama_ayah' => $request->nama_ayah,
                'pendidikan_ayah' => $request->pendidikan_ayah,
                'pekerjaan_ayah' => $request->pekerjaan_ayah,
                'nik_ibu' => $request->nik_ibu,
                'nama_ibu' => $request->nama_ibu,
                'pendidikan_ibu' => $request->pendidikan_ibu,
                'pekerjaan_ibu' => $request->pekerjaan_ibu,
                'no_hp_orang_tua' => $request->no_hp_orang_tua,
                'tahun_masuk' => $tahun_masuk,

            ]);

            return Redirect::back()->with(messageSuccess('Data Berhasil Disimpan'));
        } catch (\Exception $e) {
            dd($e);
            return Redirect::back()->with(messageError($e->getMessage()));
            //throw $th;
        }
    }

    public function getsiswa($id_siswa)
    {
        $id_siswa = Crypt::decrypt($id_siswa);
        $sw = new Siswa();
        $siswa = $sw->getsiswa($id_siswa)->first();
        return response()->json($siswa);
    }

    public function destroy($id_siswa)
    {
        $id_siswa = Crypt::decrypt($id_siswa);
        try {
            Siswa::where('id_siswa', $id_siswa)->delete();
            return Redirect::back()->with(['success' => 'Data Berhasil Dihapus']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => $e->getMessage()]);
        }
    }
}

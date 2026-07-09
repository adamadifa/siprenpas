<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;
use App\Models\Siswa;
use App\Models\SiswaAnggota;
use App\Models\Karyawan;
use App\Models\Karyawananggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;

class AnggotaController extends Controller
{
    public function index(Request $request)
    {
        $query = Anggota::with(['siswa', 'karyawan']);
        $query->select('*');
        if (!empty($request->nama_lengkap)) {
            $query->where('nama_lengkap', 'like', "%" . $request->nama_lengkap . "%");
        }
        $anggota = $query->paginate(10);
        $anggota->appends($request->all());
        $data['anggota'] = $anggota;
        return view('koperasi.anggota.index', $data);
    }

    public function create()
    {
        $data['provinsi'] = Province::orderBy('name')->get();
        $data['pendidikan'] = config('global.list_pendidikan ');
        return view('koperasi.anggota.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|unique:koperasi_anggota,nik',
            'nama_lengkap' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'alamat' => 'required',
            'jenis_kelamin' => 'required',
            'pendidikan_terakhir' => 'required',
            'status_pernikahan' => 'required',
            'id_province' => 'required',
            'id_regency' => 'required',
            'id_district' => 'required',
            'id_village' => 'required',
            'status_tinggal' => 'required',
            'no_hp' => 'required|unique:koperasi_anggota,no_hp'
        ]);

        $tahun = date("Y");
        $bulan = date("m");
        if (strlen($bulan) > 1) {
            $bulan = $bulan;
        } else {
            $bulan = "0" . $bulan;
        }
        $format = substr($tahun, 2, 2) . $bulan;

        //Cek Pendaftaran Terakhir
        $lastAnggota = Anggota::select('no_anggota')
            ->whereRaw('left(no_anggota,4) = "' . $format . '"')
            ->orderBy('no_anggota', 'desc')
            ->first();


        $last_no_anggota = $lastAnggota != null ? $lastAnggota->no_anggota : '';


        $no_anggota = buatkode($last_no_anggota, $format . "-", 5);

        try {
            Anggota::create([
                'no_anggota' => $no_anggota,
                'nik' => $request->nik,
                'nama_lengkap' => $request->nama_lengkap,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'pendidikan_terakhir' => $request->pendidikan_terakhir,
                'status_pernikahan' => $request->status_pernikahan,
                'jml_tanggungan' => $request->jml_tanggungan,
                'nama_pasangan' => $request->nama_pasangan,
                'pekerjaan_pasangan' => $request->pekerjaan_pasangan,
                'nama_ibu' => $request->nama_ibu,
                'nama_saudara' => $request->nama_saudara,
                'alamat' => $request->alamat,
                'id_province' => $request->id_province,
                'id_regency' => $request->id_regency,
                'id_district' => $request->id_district,
                'id_village' => $request->id_village,
                'kode_pos' => $request->kode_pos,
                'status_tinggal' => $request->status_tinggal,
                'no_hp' => $request->no_hp
            ]);
            return Redirect::back()->with(messageSuccess('Data Berhasil Disimpan'));
        } catch (\Exception $e) {
            dd($e);
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }

    public function edit($no_anggota)
    {
        $no_anggota = Crypt::decrypt($no_anggota);
        $data['anggota'] = Anggota::where('no_anggota', $no_anggota)->first();
        $data['provinsi'] = Province::orderBy('name')->get();
        $data['pendidikan'] = config('global.list_pendidikan ');
        return view('koperasi.anggota.edit', $data);
    }


    public function update(Request $request, $no_anggota)
    {
        $no_anggota = Crypt::decrypt($no_anggota);
        $request->validate([
            'nik' => 'required|unique:koperasi_anggota,nik,' . $no_anggota . ',no_anggota',
            'nama_lengkap' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'alamat' => 'required',
            'jenis_kelamin' => 'required',
            'pendidikan_terakhir' => 'required',
            'status_pernikahan' => 'required',
            'id_province' => 'required',
            'id_regency' => 'required',
            'id_district' => 'required',
            'id_village' => 'required',
            'status_tinggal' => 'required',
            'no_hp' => 'required'
        ]);



        try {
            Anggota::where('no_anggota', $no_anggota)->update([
                'nik' => $request->nik,
                'nama_lengkap' => $request->nama_lengkap,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'pendidikan_terakhir' => $request->pendidikan_terakhir,
                'status_pernikahan' => $request->status_pernikahan,
                'jml_tanggungan' => $request->jml_tanggungan,
                'nama_pasangan' => $request->nama_pasangan,
                'pekerjaan_pasangan' => $request->pekerjaan_pasangan,
                'nama_ibu' => $request->nama_ibu,
                'nama_saudara' => $request->nama_saudara,
                'alamat' => $request->alamat,
                'id_province' => $request->id_province,
                'id_regency' => $request->id_regency,
                'id_district' => $request->id_district,
                'id_village' => $request->id_village,
                'kode_pos' => $request->kode_pos,
                'status_tinggal' => $request->status_tinggal,
                'no_hp' => $request->no_hp
            ]);
            return Redirect::back()->with(messageSuccess('Data Berhasil Di Update'));
        } catch (\Exception $e) {
            dd($e);
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }

    public function show($no_anggota)
    {
        $no_anggota = Crypt::decrypt($no_anggota);
        $anggota = Anggota::with(['siswa', 'karyawan'])
            ->where('no_anggota', $no_anggota)
            ->first();
        
        if (!$anggota) {
            return Redirect::route('anggota.index')->with(messageError('Data anggota tidak ditemukan'));
        }
        
        // Ambil data provinsi, regency, district, village
        if ($anggota->id_province) {
            $province = Province::find($anggota->id_province);
            $anggota->nama_provinsi = $province ? $province->name : null;
        }
        
        if ($anggota->id_regency) {
            $regency = Regency::find($anggota->id_regency);
            $anggota->nama_kabupaten = $regency ? $regency->name : null;
        }
        
        if ($anggota->id_district) {
            $district = District::find($anggota->id_district);
            $anggota->nama_kecamatan = $district ? $district->name : null;
        }
        
        if ($anggota->id_village) {
            $village = Village::find($anggota->id_village);
            $anggota->nama_desa = $village ? $village->name : null;
        }
        
        $data['anggota'] = $anggota;
        return view('koperasi.anggota.show', $data);
    }


    public function getanggota($no_anggota)
    {
        $no_anggota = Crypt::decrypt($no_anggota);
        $anggota = Anggota::where('no_anggota', $no_anggota)->first();
        return response()->json($anggota);
    }

    /**
     * Get daftar siswa untuk dropdown
     */
    public function getSiswaOptions()
    {
        $siswa = Siswa::select('id_siswa', 'nama_lengkap')
            ->orderBy('nama_lengkap')
            ->get();
        return response()->json($siswa);
    }

    /**
     * Get siswa yang sudah terhubung dengan anggota
     */
    public function getSiswaTerhubung($no_anggota)
    {
        $no_anggota = Crypt::decrypt($no_anggota);
        $siswa = Anggota::with('siswa')->find($no_anggota);
        return response()->json($siswa->siswa);
    }

    /**
     * Hubungkan siswa dengan anggota
     */
    public function hubungkanSiswa(Request $request)
    {
        $request->validate([
            'no_anggota' => 'required',
            'id_siswa' => 'required'
        ]);

        try {
            $no_anggota = Crypt::decrypt($request->no_anggota);

            // Cek apakah relasi sudah ada
            $existing = SiswaAnggota::where('id_siswa', $request->id_siswa)
                ->where('no_anggota', $no_anggota)
                ->first();

            if ($existing) {
                return response()->json([
                    'success' => false,
                    'message' => 'Siswa sudah terhubung dengan anggota ini'
                ]);
            }

            // Buat relasi baru
            SiswaAnggota::create([
                'id_siswa' => $request->id_siswa,
                'no_anggota' => $no_anggota
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Siswa berhasil dihubungkan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Hapus hubungan siswa dengan anggota
     */
    public function hapusHubunganSiswa(Request $request)
    {
        $request->validate([
            'no_anggota' => 'required',
            'id_siswa' => 'required'
        ]);

        try {
            $no_anggota = Crypt::decrypt($request->no_anggota);

            SiswaAnggota::where('id_siswa', $request->id_siswa)
                ->where('no_anggota', $no_anggota)
                ->delete();

            return response()->json([
                'success' => true,
                'message' => 'Hubungan berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Hapus data anggota
     */
    public function destroy($id)
    {
        try {
            $no_anggota = Crypt::decrypt($id);

            // Hapus relasi siswa_anggota & karyawan_anggota terlebih dahulu
            SiswaAnggota::where('no_anggota', $no_anggota)->delete();
            Karyawananggota::where('no_anggota', $no_anggota)->delete();

            // Hapus data anggota
            Anggota::where('no_anggota', $no_anggota)->delete();

            return Redirect::back()->with(messageSuccess('Data Berhasil Dihapus'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError('Data Gagal Dihapus: ' . $e->getMessage()));
        }
    }

    /**
     * Get daftar karyawan untuk dropdown
     */
    public function getKaryawanOptions()
    {
        $karyawan = Karyawan::select('npp', 'nama_lengkap')
            ->orderBy('nama_lengkap')
            ->get();
        return response()->json($karyawan);
    }

    /**
     * Get karyawan yang sudah terhubung dengan anggota
     */
    public function getKaryawanTerhubung($no_anggota)
    {
        $no_anggota = Crypt::decrypt($no_anggota);
        $karyawan = Anggota::with('karyawan')->find($no_anggota);
        return response()->json($karyawan->karyawan);
    }

    /**
     * Hubungkan karyawan dengan anggota
     */
    public function hubungkanKaryawan(Request $request)
    {
        $request->validate([
            'no_anggota' => 'required',
            'npp' => 'required'
        ]);

        try {
            $no_anggota = Crypt::decrypt($request->no_anggota);

            // Cek apakah relasi sudah ada
            $existing = Karyawananggota::where('npp', $request->npp)
                ->where('no_anggota', $no_anggota)
                ->first();

            if ($existing) {
                return response()->json([
                    'success' => false,
                    'message' => 'Karyawan sudah terhubung dengan anggota ini'
                ]);
            }

            // Buat relasi baru
            Karyawananggota::create([
                'npp' => $request->npp,
                'no_anggota' => $no_anggota
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Karyawan berhasil dihubungkan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Hapus hubungan karyawan dengan anggota
     */
    public function hapusHubunganKaryawan(Request $request)
    {
        $request->validate([
            'no_anggota' => 'required',
            'npp' => 'required'
        ]);

        try {
            $no_anggota = Crypt::decrypt($request->no_anggota);

            Karyawananggota::where('npp', $request->npp)
                ->where('no_anggota', $no_anggota)
                ->delete();

            return response()->json([
                'success' => true,
                'message' => 'Hubungan berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\Jamkerja;
use App\Models\Karyawan;
use App\Models\Setjamkerjabydate;
use App\Models\Setjamkerjabyday;
use App\Models\Unit;
use App\Models\User;
use App\Models\Userkaryawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class KaryawanController extends Controller
{
    public function index(Request $request)
    {
        $query = Karyawan::query();
        if (!empty($request->nama_lengkap)) {
            $query->where('nama_lengkap', 'like', '%' . $request->nama_lengkap . '%');
        }

        if (auth()->user()->kode_unit != 'U06') {
            $query->where('karyawan.kode_unit', auth()->user()->kode_unit);
        }
        $query->select('karyawan.*', 'jabatan.nama_jabatan', 'unit.nama_unit', 'id_user');
        $query->join('jabatan', 'karyawan.kode_jabatan', '=', 'jabatan.kode_jabatan');
        $query->join('unit', 'karyawan.kode_unit', '=', 'unit.kode_unit');
        $query->leftJoin('user_karyawan', 'karyawan.npp', '=', 'user_karyawan.npp');
        $query->orderBy('karyawan.nama_lengkap', 'asc');
        $karyawan = $query->paginate(15);
        $karyawan->appends(request()->all());
        return view('datamaster.karyawan.index', compact('karyawan'));
    }

    public function create()
    {
        $jabatan = Jabatan::orderBy('kode_jabatan')->where('kode_jabatan', '!=', 'J00')->get();
        $unit = Unit::orderBy('kode_unit')->get();
        return view('datamaster.karyawan.create', compact('jabatan', 'unit'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'npp' => 'required|unique:karyawan,npp',
            'no_ktp' => 'required',
            'nama_lengkap' => 'required',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'no_hp' => 'required|numeric',
            'alamat_ktp' => 'required',
            'alamat_tinggal' => 'required',
            'tmt' => 'required',
            'status_karyawan' => 'required',
            'pendidikan_terakhir' => 'required',
            'kode_jabatan' => 'required',
            'kode_unit' => 'required',

        ]);


        try {
            Karyawan::create([
                'npp' => $request->npp,
                'no_kk' => $request->no_kk,
                'no_ktp' => $request->no_ktp,
                'nama_lengkap' => $request->nama_lengkap,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'no_hp' => $request->no_hp,
                'alamat_ktp' => $request->alamat_ktp,
                'alamat_tinggal' => $request->alamat_tinggal,
                'tmt' => $request->tmt,
                'status_karyawan' => $request->status_karyawan,
                'pendidikan_terakhir' => $request->pendidikan_terakhir,
                'kode_jabatan' => $request->kode_jabatan,
                'kode_unit' => $request->kode_unit,
                'password' => bcrypt('12345678')
            ]);

            return Redirect::back()->with(messageSuccess('Data Berhasil Disimpan'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }


    public function edit($npp)
    {
        $npp = Crypt::decrypt($npp);
        $karyawan = Karyawan::where('npp', $npp)->first();
        $jabatan = Jabatan::orderBy('kode_jabatan')->where('kode_jabatan', '!=', 'J00')->get();
        $unit = Unit::orderBy('kode_unit')->get();
        return view('datamaster.karyawan.edit', compact('karyawan', 'jabatan', 'unit'));
    }

    public function update(Request $request, $npp)
    {
        $npp = Crypt::decrypt($npp);
        $userKaryawan = Userkaryawan::where('npp', $npp)->first();
        $request->validate([
            'npp' => 'required|unique:karyawan,npp,' . $npp . ',npp',
            'no_ktp' => 'required',
            'nama_lengkap' => 'required',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'no_hp' => 'required|numeric',
            'alamat_ktp' => 'required',
            'alamat_tinggal' => 'required',
            'tmt' => 'required',
            'status_karyawan' => 'required',
            'pendidikan_terakhir' => 'required',
            'kode_jabatan' => 'required',
            'kode_unit' => 'required',
            'status' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $karyawan = Karyawan::where('npp', $npp)->first();

            // Handle photo upload/deletion
            $fotoName = $karyawan->foto; // Keep existing photo by default

            // Check if user wants to delete photo
            if ($request->has('delete_photo') && $request->delete_photo == '1') {
                // Delete old photo file if exists
                if ($karyawan->foto && file_exists(public_path('storage/photos/karyawan/' . $karyawan->foto))) {
                    unlink(public_path('storage/photos/karyawan/' . $karyawan->foto));
                }
                $fotoName = null;
            }
            // Check if new photo uploaded
            elseif ($request->hasFile('foto')) {
                // Delete old photo file if exists
                if ($karyawan->foto && file_exists(public_path('storage/photos/karyawan/' . $karyawan->foto))) {
                    unlink(public_path('storage/photos/karyawan/' . $karyawan->foto));
                }

                // Upload new photo
                $file = $request->file('foto');
                $fileName = time() . '_' . $karyawan->npp . '.' . $file->getClientOriginalExtension();

                // Create directory if not exists
                $uploadPath = public_path('storage/photos/karyawan');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }

                // Move uploaded file
                $file->move($uploadPath, $fileName);
                $fotoName = $fileName;
            }

            Karyawan::where('npp', $npp)->update([
                'npp' => $request->npp,
                'no_kk' => $request->no_kk,
                'no_ktp' => $request->no_ktp,
                'nama_lengkap' => $request->nama_lengkap,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'no_hp' => $request->no_hp,
                'alamat_ktp' => $request->alamat_ktp,
                'alamat_tinggal' => $request->alamat_tinggal,
                'tmt' => $request->tmt,
                'status_karyawan' => $request->status_karyawan,
                'pendidikan_terakhir' => $request->pendidikan_terakhir,
                'kode_jabatan' => $request->kode_jabatan,
                'kode_unit' => $request->kode_unit,
                // 'password' => bcrypt('12345678'),
                'status' => $request->status,
                'foto' => $fotoName
            ]);

            User::where('id', $userKaryawan->id_user)->update([
                'name' => $request->nama_lengkap,
                'email' => strtolower(removeTitik($request->npp)) . '@persisalamin.com',
                'username' => $request->npp,
            ]);
            DB::commit();
            return Redirect::back()->with(messageSuccess('Data Berhasil Disimpan'));
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }

    public function show($npp)
    {
        $npp = Crypt::decrypt($npp);
        $karyawan = Karyawan::where('npp', $npp)
            ->join('unit', 'karyawan.kode_unit', '=', 'unit.kode_unit')
            ->join('jabatan', 'karyawan.kode_jabatan', '=', 'jabatan.kode_jabatan')
            ->first();
        return view('datamaster.karyawan.show', compact('karyawan'));
    }


    public function destroy($npp)
    {
        $npp = Crypt::decrypt($npp);
        try {
            Karyawan::where('npp', $npp)->delete();
            return Redirect::back()->with(['success' => 'Data Berhasil Dihapus']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => $e->getMessage()]);
        }
    }


    public function setharikerja($npp)
    {
        $npp = Crypt::decrypt($npp);
        $karyawan = Karyawan::where('npp', $npp)->first();
        $data['karyawan'] = $karyawan;
        return view('datamaster.karyawan.setharikerja', $data);
    }

    public function updateharikerja(Request $request, $npp)
    {
        $npp = Crypt::decrypt($npp);
        try {
            Karyawan::where('npp', $npp)->update([
                'hari_kerja' => implode(",", $request->hari),
            ]);
            return Redirect::back()->with(messageSuccess('Data Berhasil Disimpan'));
        } catch (\Exception $e) {
            dd($e);
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }

    public function getjadwalkerja(Request $request)
    {

        $hariini = date('Y-m-d');
        $nama_hari = !empty($request->hari) ? $request->hari : getnamaHari(date('D', strtotime($hariini)));
        $query = Karyawan::query();
        $query->where('hari_kerja', 'like', '%' . $nama_hari . '%');
        if (!empty($request->unit)) {
            $query->where('kode_unit', $request->unit);
        }

        $data['jadwalkerja'] = $query->get();
        return view('datamaster.karyawan.getjadwalkerja', $data);
    }

    public function createuser($npp)
    {
        $npp = Crypt::decrypt($npp);
        $karyawan = Karyawan::where('npp', $npp)->first();
        DB::beginTransaction();
        try {
            //code...
            $user = User::create([
                'name' => $karyawan->nama_lengkap,
                'kode_unit' => $karyawan->kode_unit,
                'username' => $karyawan->npp,
                'password' => Hash::make(12345678),
                'email' => strtolower(removeTitik($karyawan->npp)) . '@persisalamin.com',
            ]);

            Userkaryawan::create([
                'npp' => $npp,
                'id_user' => $user->id
            ]);

            $user->assignRole('karyawan');
            DB::commit();
            return Redirect::back()->with(messageSuccess('User Berhasil Dibuat'));
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }

    public function setjamkerja($npp)
    {
        $npp = Crypt::decrypt($npp);
        $data['karyawan'] = Karyawan::where('npp', $npp)
            ->first();
        $data['list_bulan'] = config('global.list_bulan');
        $data['start_year'] = config('global.start_year');
        $data['jamkerja'] = Jamkerja::orderBy('kode_jam_kerja')->get();
        $data['jamkerjabyday'] = Setjamkerjabyday::where('npp', $npp)->pluck('kode_jam_kerja', 'hari')->toArray();
        // dd($data['jamkerjabyday']);
        return view('datamaster.karyawan.setjamkerja', $data);
    }

    public function storejamkerjabyday(Request $request, $npp)
    {
        $npp = Crypt::decrypt($npp);
        $hari = $request->hari;
        $kode_jam_kerja = $request->kode_jam_kerja;
        DB::beginTransaction();
        try {
            Setjamkerjabyday::where('npp', $npp)->delete();
            for ($i = 0; $i < count($hari); $i++) {
                if (!empty($kode_jam_kerja[$i])) {
                    Setjamkerjabyday::create([
                        'npp' => $npp,
                        'hari' => $hari[$i],
                        'kode_jam_kerja' => $kode_jam_kerja[$i]
                    ]);
                }
            }
            DB::commit();
            return Redirect::back()->with(messageSuccess('Data Berhasil Disimpan'));
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }


    public function storejamkerjabydate(Request $request)
    {
        $cek = Setjamkerjabydate::where('npp', $request->npp)->where('tanggal', $request->tanggal)->first();
        if (!empty($cek)) {
            return response()->json(['success' => false, 'message' => 'Karyawan Sudah Memiliki Jadwal pada Tanggal Ini']);
        }
        try {
            Setjamkerjabydate::create([
                'npp' => $request->npp,
                'tanggal' => $request->tanggal,
                'kode_jam_kerja' => $request->kode_jam_kerja
            ]);

            return response()->json(['success' => true, 'message' => 'Data Berhasil Disimpan']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function getjamkerjabydate(Request $request)
    {
        $npp = $request->npp;
        $tanggal = $request->tanggal;
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $jamkerjabydate = Setjamkerjabydate::where('npp', $npp)
            ->join('konfigurasi_jam_kerja', 'presensi_jamkerja_bydate.kode_jam_kerja', '=', 'konfigurasi_jam_kerja.kode_jam_kerja')
            ->whereRaw('MONTH(tanggal) = ' . $bulan . ' AND YEAR(tanggal) = ' . $tahun)
            ->orderBy('tanggal', 'asc')
            ->get();


        return response()->json($jamkerjabydate);
    }

    public function deletejamkerjabydate(Request $request)

    {
        // dd($request);
        try {
            Setjamkerjabydate::where('npp', $request->npp)->where('tanggal', $request->tanggal)->delete();
            return response()->json(['success' => true, 'message' => 'Data Berhasil Dihapus']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function updatestatus($npp)
    {
        $npp = Crypt::decrypt($npp);
        $karyawan = Karyawan::where('npp', $npp)->first();
        if ($karyawan->status == 1) {
            $karyawan->status = 0;
        } else {
            $karyawan->status = 1;
        }
        $karyawan->save();
        return Redirect::back()->with(messageSuccess('Status Berhasil Diubah'));
    }
}

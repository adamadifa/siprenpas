<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\JabatanAkademik;
use App\Models\Karyawan;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class GuruController extends Controller
{
    public function index(Request $request)
    {
        $query = Guru::query();
        $query->select(
            'guru.*',
            'karyawan.nama_lengkap',
            'unit.nama_unit',
            'jabatan_akademik.nama_jabatan'
        );
        $query->join('karyawan', 'guru.npp', '=', 'karyawan.npp');
        $query->join('unit', 'guru.kode_unit', '=', 'unit.kode_unit');
        $query->leftJoin('jabatan_akademik', 'guru.kode_jabatan', '=', 'jabatan_akademik.kode_jabatan');

        if (!empty($request->nama_lengkap)) {
            $query->where('karyawan.nama_lengkap', 'like', '%' . $request->nama_lengkap . '%');
        }

        if (!auth()->user()->hasRole('super admin')) {
            $query->where('guru.kode_unit', auth()->user()->kode_unit);
        } else {
            if (!empty($request->kode_unit)) {
                $query->where('guru.kode_unit', $request->kode_unit);
            }
        }

        $guru = $query->paginate(15);
        $guru->appends($request->all());
        
        $unit = Unit::orderBy('kode_unit')->get();

        return view('akademik.guru.index', compact('guru', 'unit'));
    }

    public function create()
    {
        $jabatan = JabatanAkademik::orderBy('urutan')->get();
        // If user is restricting to a unit, pass that info.
        $unit = Unit::orderBy('kode_unit')->get();
        if (auth()->user()->kode_unit != 'U06') {
            $unit = Unit::where('kode_unit', auth()->user()->kode_unit)->get();
        }

        // Get employees who are not yet in guru table
        $existing_guru_npp = Guru::pluck('npp')->toArray();
        $karyawan = Karyawan::whereNotIn('npp', $existing_guru_npp)
            ->where('status', 1) // Only active employees
            ->orderBy('nama_lengkap')
            ->get();
        
        return view('akademik.guru.create', compact('jabatan', 'unit', 'karyawan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'npp' => 'required|unique:guru,npp',
            'kode_unit' => 'required',
            'kode_jabatan' => 'required',
            'file_ttd' => 'nullable|image|mimes:png,jpg,jpeg|max:2048'
        ]);

        try {
            $file_ttd = null;
            if ($request->hasFile('file_ttd')) {
                $file = $request->file('file_ttd');
                $filename = time() . '_' . $request->npp . '.' . $file->getClientOriginalExtension();
                $path = 'storage/uploads/ttd_guru/';
                $file->move(public_path($path), $filename);
                $file_ttd = $filename;
            }

            Guru::create([
                'npp' => $request->npp,
                'kode_unit' => $request->kode_unit,
                'kode_jabatan' => $request->kode_jabatan,
                'nomor_kemenag_dinas' => $request->nomor_kemenag_dinas,
                'file_ttd' => $file_ttd,
                'status_aktif_ajar' => 1
            ]);

            return Redirect::back()->with(messageSuccess('Data Guru Berhasil Disimpan'));

        } catch (\Exception $e) {
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }

    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $guru = Guru::findOrFail($id);
        $jabatan = JabatanAkademik::orderBy('urutan')->get();
        $unit = Unit::orderBy('kode_unit')->get();
        if (auth()->user()->kode_unit != 'U06') {
            $unit = Unit::where('kode_unit', auth()->user()->kode_unit)->get();
        }
        $karyawan = Karyawan::where('npp', $guru->npp)->first();

        return view('akademik.guru.edit', compact('guru', 'jabatan', 'unit', 'karyawan'));
    }

    public function update(Request $request, $id)
    {
        $id = Crypt::decrypt($id);
        $guru = Guru::findOrFail($id);

        $request->validate([
            'kode_unit' => 'required',
            'kode_jabatan' => 'required',
            'file_ttd' => 'nullable|image|mimes:png,jpg,jpeg|max:2048'
        ]);

        try {
            $file_ttd = $guru->file_ttd;
            if ($request->hasFile('file_ttd')) {
                // Delete old file if exists
                if ($guru->file_ttd && file_exists(public_path('storage/uploads/ttd_guru/' . $guru->file_ttd))) {
                    unlink(public_path('storage/uploads/ttd_guru/' . $guru->file_ttd));
                }

                $file = $request->file('file_ttd');
                $filename = time() . '_' . $guru->npp . '.' . $file->getClientOriginalExtension();
                $path = 'storage/uploads/ttd_guru/';
                $file->move(public_path($path), $filename);
                $file_ttd = $filename;
            }

            $guru->update([
                'kode_unit' => $request->kode_unit,
                'kode_jabatan' => $request->kode_jabatan,
                'nomor_kemenag_dinas' => $request->nomor_kemenag_dinas,
                'file_ttd' => $file_ttd,
                'status_aktif_ajar' => $request->status_aktif_ajar
            ]);
            
            return Redirect::back()->with(messageSuccess('Data Guru Berhasil Diupdate'));

        } catch (\Exception $e) {
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }
    
    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        $guru = Guru::findOrFail($id);
        try {
            if ($guru->file_ttd && file_exists(public_path('storage/uploads/ttd_guru/' . $guru->file_ttd))) {
                 unlink(public_path('storage/uploads/ttd_guru/' . $guru->file_ttd));
            }
            $guru->delete();
            return Redirect::back()->with(messageSuccess('Data Guru Berhasil Dihapus'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }

    public function createUser($id)
    {
        $id = Crypt::decrypt($id);
        $guru = Guru::join('karyawan', 'guru.npp', '=', 'karyawan.npp')
            ->select('guru.*', 'karyawan.nama_lengkap')
            ->where('guru.id', $id)
            ->first();
        
        return view('akademik.guru.create_user', compact('guru'));
    }

    public function storeUser(Request $request, $id)
    {
        $id = Crypt::decrypt($id);
        $guru = Guru::findOrFail($id);

        $request->validate([
            'password' => 'nullable|min:6',
        ]);

        try {
            $password = $request->password ?: $guru->npp;
            $guru->update([
                'password' => bcrypt($password),
            ]);

            return Redirect::back()->with(messageSuccess('Password Guru Berhasil Diupdate'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }

    public function generateUsers()
    {
        try {
            $guruWithoutPassword = Guru::whereNull('password')->get();

            $count = 0;
            foreach ($guruWithoutPassword as $g) {
                $g->update([
                    'password' => bcrypt($g->npp),
                ]);
                $count++;
            }

            return Redirect::back()->with(messageSuccess($count . ' Password Guru Berhasil Digenerate dengan password default sesuai NPP masing-masing'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }
}

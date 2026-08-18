<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\Jabatan;
use App\Models\Karyawan;
use App\Models\Realisasikegiatan;
use App\Models\User;
use App\Models\Userkaryawan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Jenssegers\Agent\Agent;
use Intervention\Image\Drivers\Gd\Driver; // Gunakan driver GD (bawaan PHP)
use Intervention\Image\Drivers\Gd\Encoders\JpegEncoder;

class RealisasikegiatanController extends Controller
{
    public function index(Request $request)
    {
        $user = User::where('id', auth()->user()->id)->first();
        $query = Realisasikegiatan::query();
        $query->select('realisasi_kegiatan.*', 'name', 'jobdesk', 'program_kerja');
        $query->join('departemen', 'realisasi_kegiatan.kode_dept', '=', 'departemen.kode_dept');
        $query->join('jabatan', 'realisasi_kegiatan.kode_jabatan', '=', 'jabatan.kode_jabatan');
        $query->leftJoin('jobdesk', 'realisasi_kegiatan.kode_jobdesk', '=', 'jobdesk.kode_jobdesk');
        $query->leftJoin('program_kerja', 'realisasi_kegiatan.kode_program_kerja', '=', 'program_kerja.kode_program_kerja');
        $query->join('users', 'realisasi_kegiatan.id_user', '=', 'users.id');
        if ($user->hasRole('karyawan')) {
            $userkaryawan = Userkaryawan::where('id_user', $user->id)->first();
            $karyawan = Karyawan::where('karyawan.npp', $userkaryawan->npp)
                ->join('jabatan', 'karyawan.kode_jabatan', '=', 'jabatan.kode_jabatan')
                ->join('unit', 'karyawan.kode_unit', '=', 'unit.kode_unit')
                ->first();
            
            $dept = Departemen::where('kode_dept', $user->kode_dept)->first();
            if ($karyawan && $dept) {
                $karyawan->nama_dept = $dept->nama_dept;
            }
            
            $data['karyawan'] = $karyawan;
            
            // Only show employee's own realisasi kegiatan
            $query->where('realisasi_kegiatan.id_user', $user->id);
            if (!empty($request->dari) && !empty($request->sampai)) {
                $query->whereBetween('tanggal', [$request->dari, $request->sampai]);
            }
            
            $query->orderBy('tanggal', 'desc');
            
            if ($request->cetak || $request->cetak_pdf) {
                $data['realisasikegiatan'] = $query->get();
                $data['jabatan'] = Jabatan::where('kode_jabatan', $user->kode_jabatan)->first();
                $data['departemen'] = Departemen::where('kode_dept', $user->kode_dept)->first();
                $data['dari'] = $request->dari;
                $data['sampai'] = $request->sampai;
                
                if ($request->cetak_pdf) {
                    $pdf = Pdf::loadView('realisasi_kegiatan.cetakpdf', $data)->setPaper('a4', 'landscape');
                    return $pdf->stream('realisasi_kegiatan_' . $request->dari . '_' . $request->sampai . '_' . $user->kode_dept . '.pdf');
                }
                return view('realisasi_kegiatan.cetak', $data);
            }
            
            $data['realisasikegiatan'] = $query->paginate(30)->appends($request->all());
            $data['user'] = $user;
            
            return view('realisasi_kegiatan.index_karyawan', $data);
        }

        if ($user->hasRole(['super admin', 'pimpinan pesantren', 'sekretaris'])) {
            if (!empty($request->kode_jabatan)) {
                $query->where('realisasi_kegiatan.kode_jabatan', $request->kode_jabatan);
            }
            if (!empty($request->kode_dept)) {
                $query->where('realisasi_kegiatan.kode_dept', $request->kode_dept);
            }
        } else {
            $query->where('realisasi_kegiatan.kode_jabatan', $user->kode_jabatan);
            $query->where('realisasi_kegiatan.kode_dept', $user->kode_dept);
        }

        if (!empty($request->dari) && !empty($request->sampai)) {
            $query->whereBetween('tanggal', [$request->dari, $request->sampai]);
        }

        // $query->orderBy('tanggal', 'DESC');
        if ($request->cetak || $request->cetak_pdf) {
            $query->orderBy('tanggal');
            $realisasikegiatan = $query->get();
        } else {
            $query->orderBy('tanggal', 'desc');
            $realisasikegiatan = $query->paginate(30);
            $realisasikegiatan->appends($request->all());
        }



        $data['realisasikegiatan'] = $realisasikegiatan;
        $data['jabatan'] = Jabatan::orderBy('kode_jabatan')->where('kode_jabatan', '!=', 'J00')->get();
        $data['departemen'] = Departemen::orderBy('kode_dept')->get();
        $data['user'] = $user;


        $agent = new Agent();
        if ($agent->isMobile()) {
            return view('realisasi_kegiatan.index_mobile', $data);
        }

        if ($request->cetak || $request->cetak_pdf) {
            $kode_jabatan = $user->hasRole('super admin') ? $request->kode_jabatan : $user->kode_jabatan;
            $kode_dept = $user->hasRole('super admin') ? $request->kode_dept : $user->kode_dept;
            $data['jabatan'] = Jabatan::orderBy('kode_jabatan')->where('kode_jabatan', $kode_jabatan)->first();
            $data['departemen'] = Departemen::orderBy('kode_dept')->where('kode_dept', $kode_dept)->first();
            $data['dari'] = $request->dari;
            $data['sampai'] = $request->sampai;
            if ($request->cetak_pdf) {
                $pdf = Pdf::loadView('realisasi_kegiatan.cetakpdf', $data)->setPaper('a4', 'landscape');
                return $pdf->stream('realisasi_kegiatan_' . $request->dari . '_' . $request->sampai . '_' . $kode_dept . '_' . $kode_jabatan . '.pdf');
            }
            return view('realisasi_kegiatan.cetak', $data);
        }

        return view('realisasi_kegiatan.index', $data);
    }


    public function create()
    {
        $user = User::where('id', auth()->user()->id)->first();
        $data['jabatan'] = Jabatan::orderBy('kode_jabatan')->where('kode_jabatan', '!=', 'J00')->get();
        $data['departemen'] = Departemen::orderBy('kode_dept')->get();
        $data['user'] = $user;
        $agent = new Agent();
        if ($agent->isMobile()) {
            return view('realisasi_kegiatan.create_mobile', $data);
        }
        return view('realisasi_kegiatan.create', $data);
    }

    public function store(Request $request)
    {

        $user = User::where('id', auth()->user()->id)->first();
        if ($user->hasRole('super admin')) {
            $request->validate([
                'tanggal' => 'required',
                'nama_kegiatan' => 'required',
                'kode_jabatan' => 'required',
                'kode_dept' => 'required',
                // 'kode_jobdesk' => 'required',
                'uraian_kegiatan' => 'required',
                // 'kode_program_kerja' => 'required',
                'file' => 'mimes:jpg,jpeg,png|max:1024',
            ]);
        } else {
            $request->validate([
                'tanggal' => 'required',
                'nama_kegiatan' => 'required',
                // 'kode_jobdesk' => 'required',
                // 'kode_program_kerja' => 'required',
                'uraian_kegiatan' => 'required',
                'file' => 'mimes:jpg,jpeg,png',
            ]);
        }

        if (!$user->hasRole('super admin')) {
            $kode_jabatan = auth()->user()->kode_jabatan;
            $kode_dept = auth()->user()->kode_dept;
        } else {
            $kode_jabatan = $request->kode_jabatan;
            $kode_dept = $request->kode_dept;
        }
        $agent = new Agent();

        try {
            if ($request->file('foto')) {

                $image = $request->file('foto');
                // $filename = time() . '.' . $image->getClientOriginalExtension();
                // Resize dan Kompres gambar
                // Gunakan ImageManager
                // Buat instance ImageManager dengan driver GD
                $imageManager = new ImageManager(new Driver());

                // Proses gambar
                $img = $imageManager->read($image->getRealPath());
                $img = $img->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->encode(new JpegEncoder(quality: 70)); // Kompres ke 70% kualitas


                $namafile = $request->file('foto')->getClientOriginalName();
                $file_name =  $namafile . "." . $request->file('foto')->getClientOriginalExtension();
                $destination_foto_path = "/public/realisasikegiatan/" . $kode_dept . "/";
                $file = $file_name;

                Storage::put($destination_foto_path . $file_name, (string) $img);
                //$request->file('foto')->storeAs($destination_foto_path, $file_name);
            } else {
                $file = null;
            }

            Realisasikegiatan::create([
                'tanggal' => $request->tanggal,
                'nama_kegiatan' => $request->nama_kegiatan,
                'kode_jabatan' => $kode_jabatan,
                'kode_dept' => $kode_dept,
                'kode_jobdesk' => $request->kode_jobdesk,
                'kode_program_kerja' => $request->kode_program_kerja,
                'uraian_kegiatan' => $request->uraian_kegiatan,
                'id_user' => auth()->user()->id,
                'foto' => $file
            ]);


            if ($agent->isMobile()) {
                return redirect(route('realisasikegiatan.index'))->with(messageSuccess('Data Berhasil Disimpan'));
            }
            return Redirect::back()->with(messageSuccess('Data Berhasil Disimpan'));
        } catch (\Exception $e) {
            if ($request->file('foto')) {



                $namafile = $request->file('foto')->getClientOriginalName();
                $file_name =  $namafile . "." . $request->file('foto')->getClientOriginalExtension();
                $destination_foto_path = "/public/realisasikegiatan/" . $kode_dept . "/";
                $file = $file_name;
                Storage::delete($destination_foto_path . "/" . $file_name);
            }
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }

    public function destroy($id)
    {
        $id = Crypt::decrypt($id);

        try {
            Realisasikegiatan::where('id', $id)->delete();
            return Redirect::back()->with(messageSuccess('Data Berhasil Dihapus'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }

    public function edit($id)
    {
        $user = User::where('id', auth()->user()->id)->first();
        $id = Crypt::decrypt($id);
        $data['jabatan'] = Jabatan::orderBy('kode_jabatan')->where('kode_jabatan', '!=', 'J00')->get();
        $data['departemen'] = Departemen::orderBy('kode_dept')->get();
        $data['realisasikegiatan'] = Realisasikegiatan::where('id', $id)->first();
        $data['user'] = $user;
        $agent = new Agent();
        if ($agent->isMobile()) {
            return view('realisasi_kegiatan.edit_mobile', $data);
        }
        return view('realisasi_kegiatan.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $id = Crypt::decrypt($id);
        $user = User::where('id', auth()->user()->id)->first();
        $agent = new Agent();
        if ($user->hasRole('super admin')) {
            $request->validate([
                'tanggal' => 'required',
                'nama_kegiatan' => 'required',
                'kode_jabatan' => 'required',
                'kode_dept' => 'required',
                // 'kode_jobdesk' => 'required',
                // 'kode_program_kerja' => 'required',
                'uraian_kegiatan' => 'required',
                'file' => 'mimes:jpg,jpeg,png|max:1024',
            ]);
        } else {
            $request->validate([
                'tanggal' => 'required',
                'nama_kegiatan' => 'required',
                // 'kode_jobdesk' => 'required',
                // 'kode_program_kerja' => 'required',
                'uraian_kegiatan' => 'required',
                'file' => 'mimes:jpg,jpeg,png',
            ]);
        }
        if (!$user->hasRole('super admin')) {
            $kode_jabatan = auth()->user()->kode_jabatan;
            $kode_dept = auth()->user()->kode_dept;
        } else {
            $kode_jabatan = $request->kode_jabatan;
            $kode_dept = $request->kode_dept;
        }
        try {
            $realisasikegiatan = Realisasikegiatan::find($id);
            $realisasikegiatan->update([
                'tanggal' => $request->tanggal,
                'nama_kegiatan' => $request->nama_kegiatan,
                'kode_jabatan' => $kode_jabatan,
                'kode_dept' => $kode_dept,
                'kode_jobdesk' => $request->kode_jobdesk,
                'kode_program_kerja' => $request->kode_program_kerja,
                'uraian_kegiatan' => $request->uraian_kegiatan,
                'id_user' => auth()->user()->id
            ]);
            if ($agent->isMobile()) {
                return redirect(route('realisasikegiatan.index'))->with(messageSuccess('Data Berhasil Disimpan'));
            }
            return Redirect::back()->with(messageSuccess('Data Berhasil Diupdate'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }

    public function getrealisasikegiatan(Request $request)
    {
        $user = User::where('id', auth()->user()->id)->first();
        $tanggal = $request->tanggal;
        $query = Realisasikegiatan::query();
        $query->select('realisasi_kegiatan.*', 'name', 'jobdesk');
        $query->join('departemen', 'realisasi_kegiatan.kode_dept', '=', 'departemen.kode_dept');
        $query->join('jabatan', 'realisasi_kegiatan.kode_jabatan', '=', 'jabatan.kode_jabatan');
        $query->join('jobdesk', 'realisasi_kegiatan.kode_jobdesk', '=', 'jobdesk.kode_jobdesk');
        $query->join('users', 'realisasi_kegiatan.id_user', '=', 'users.id');
        $query->where('realisasi_kegiatan.kode_jabatan', $user->kode_jabatan);
        $query->where('realisasi_kegiatan.kode_dept', $user->kode_dept);
        $query->where('realisasi_kegiatan.tanggal', $tanggal);
        $query->where('realisasi_kegiatan.id_user', auth()->user()->id);
        $query->orderBy('tanggal');
        $data['realisasikegiatan'] = $query->get();
        return view('realisasi_kegiatan.getrealisasikegiatan', $data);
    }


    public function show($id)
    {
        $id = Crypt::decrypt($id);
        $data['realisasi'] = Realisasikegiatan::where('id', $id)->first();
        return view('realisasi_kegiatan.show', $data);
    }
    //Mobile


    public function takepicture($id)
    {
        $id = Crypt::decrypt($id);
        return view('realisasi_kegiatan.takepicture', compact('id'));
    }


    public function storepicture(Request $request)
    {

        $lokasi = $request->lokasi;
        $id = Crypt::decrypt($request->id);
        $realisasikegiatan = Realisasikegiatan::find($id);
        $kode_dept = $realisasikegiatan->kode_dept;
        $lok = explode(",", $lokasi);
        $latitude = $lok[0];
        $longitude = $lok[1];
        // $kode_pelanggan = $request->kode_pelanggan;
        if (isset($request->image)) {
            $image = $request->image;
            $folderPath = "/public/realisasikegiatan/" . $kode_dept . "/";
            $formatName = $id;
            $image_parts = explode(";base64", $image);
            $image_base64 = base64_decode($image_parts[1]);
            $fileName = $formatName . ".png";
            $file = $folderPath . $fileName;
        } else {
            $fileName = null;
        }

        try {
            Realisasikegiatan::where('id', $id)->update([
                'foto' => $fileName,
            ]);
            if (isset($request->image)) {
                Storage::put($file, $image_base64);
            }


            return response()->json(['status' => 'success', 'message' => 'Data Berhasil Disimpan'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }
}

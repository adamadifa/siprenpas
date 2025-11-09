<?php

namespace App\Http\Controllers;

use App\Models\PendaftaranGotTalent;
use App\Models\JenjangPendidikan;
use App\Models\Perlombaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class PendaftaranGotTalentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = PendaftaranGotTalent::with('jenjangPendidikan');

        if (!empty($request->nomor_register_search)) {
            $query->where('nomor_register', 'like', '%' . $request->nomor_register_search . '%');
        }

        if (!empty($request->nama_lengkap_search)) {
            $query->where('nama_lengkap', 'like', '%' . $request->nama_lengkap_search . '%');
        }

        if (!empty($request->id_jenjang_search)) {
            $query->where('id_jenjang', $request->id_jenjang_search);
        }

        $pendaftaranGotTalent = $query->orderBy('created_at', 'desc')->get();
        $jenjangPendidikan = JenjangPendidikan::orderBy('jenjang_pendidikan')->get();

        return view('pendaftaran-got-talent.index', compact('pendaftaranGotTalent', 'jenjangPendidikan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jenjangPendidikan = JenjangPendidikan::orderBy('jenjang_pendidikan')->get();
        $perlombaan = Perlombaan::with('jenjangPendidikan')->orderBy('jenis_perlombaan')->get();
        return view('pendaftaran-got-talent.create', compact('jenjangPendidikan', 'perlombaan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'id_jenjang' => 'required|exists:jenjang_pendidikan,id',
            'asal_sekolah' => 'required|string|max:200',
            'alamat_sekolah' => 'required|string',
            'alamat_rumah' => 'required|string',
            'perlombaan' => 'required|array|min:1',
            'perlombaan.*' => 'exists:perlombaan,id'
        ], [
            'nama_lengkap.required' => 'Nama Lengkap harus diisi',
            'id_jenjang.required' => 'Jenjang Pendidikan harus dipilih',
            'asal_sekolah.required' => 'Asal Sekolah harus diisi',
            'alamat_sekolah.required' => 'Alamat Sekolah harus diisi',
            'alamat_rumah.required' => 'Alamat Rumah harus diisi',
            'perlombaan.required' => 'Pilihan Lomba harus dipilih minimal 1',
            'perlombaan.min' => 'Pilihan Lomba harus dipilih minimal 1'
        ]);

        try {
            DB::beginTransaction();

            // Generate nomor register
            $lastPendaftaran = PendaftaranGotTalent::select('nomor_register')
                ->orderBy('nomor_register', 'desc')
                ->first();

            $last_nomor_register = $lastPendaftaran != null ? $lastPendaftaran->nomor_register : '';
            $format = "GT" . date('y');
            $nomor_register = buatkode($last_nomor_register, $format, 4);

            $pendaftaran = PendaftaranGotTalent::create([
                'nomor_register' => $nomor_register,
                'nama_lengkap' => $request->nama_lengkap,
                'id_jenjang' => $request->id_jenjang,
                'asal_sekolah' => $request->asal_sekolah,
                'alamat_sekolah' => $request->alamat_sekolah,
                'alamat_rumah' => $request->alamat_rumah
            ]);

            // Simpan pilihan lomba ke tabel pendaftaran_lomba
            if ($request->has('perlombaan') && is_array($request->perlombaan)) {
                foreach ($request->perlombaan as $id_perlombaan) {
                    DB::table('pendaftaran_lomba')->insert([
                        'id_pendaftaran' => $pendaftaran->id,
                        'id_perlombaan' => $id_perlombaan,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }

            DB::commit();
            return Redirect::back()->with(messageSuccess('Data Berhasil Disimpan'));
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $id = Crypt::decrypt($id);
        $pendaftaranGotTalent = PendaftaranGotTalent::with('jenjangPendidikan', 'perlombaan')
            ->where('id', $id)
            ->first();

        if (!$pendaftaranGotTalent) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json(['error' => 'Data tidak ditemukan'], 404);
            }
            return Redirect::back()->with(messageError('Data tidak ditemukan'));
        }

        // Jika request dari modal (ajax), return view modal detail
        if (request()->ajax() || request()->wantsJson()) {
            return view('pendaftaran-got-talent.detail-modal', compact('pendaftaranGotTalent'));
        }

        // Jika request biasa, return view show lengkap
        return view('pendaftaran-got-talent.show', compact('pendaftaranGotTalent'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $pendaftaranGotTalent = PendaftaranGotTalent::with('perlombaan')->where('id', $id)->first();

        if (!$pendaftaranGotTalent) {
            return Redirect::back()->with(messageError('Data tidak ditemukan'));
        }

        $jenjangPendidikan = JenjangPendidikan::orderBy('jenjang_pendidikan')->get();
        $perlombaan = Perlombaan::with('jenjangPendidikan')->orderBy('jenis_perlombaan')->get();

        // Ambil ID perlombaan yang sudah dipilih
        $selectedPerlombaan = $pendaftaranGotTalent->perlombaan->pluck('id')->toArray();

        return view('pendaftaran-got-talent.edit', compact('pendaftaranGotTalent', 'jenjangPendidikan', 'perlombaan', 'selectedPerlombaan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $id = Crypt::decrypt($id);
        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'id_jenjang' => 'required|exists:jenjang_pendidikan,id',
            'asal_sekolah' => 'required|string|max:200',
            'alamat_sekolah' => 'required|string',
            'alamat_rumah' => 'required|string',
            'perlombaan' => 'required|array|min:1',
            'perlombaan.*' => 'exists:perlombaan,id'
        ], [
            'nama_lengkap.required' => 'Nama Lengkap harus diisi',
            'id_jenjang.required' => 'Jenjang Pendidikan harus dipilih',
            'asal_sekolah.required' => 'Asal Sekolah harus diisi',
            'alamat_sekolah.required' => 'Alamat Sekolah harus diisi',
            'alamat_rumah.required' => 'Alamat Rumah harus diisi',
            'perlombaan.required' => 'Pilihan Lomba harus dipilih minimal 1',
            'perlombaan.min' => 'Pilihan Lomba harus dipilih minimal 1'
        ]);

        try {
            DB::beginTransaction();

            PendaftaranGotTalent::where('id', $id)->update([
                'nama_lengkap' => $request->nama_lengkap,
                'id_jenjang' => $request->id_jenjang,
                'asal_sekolah' => $request->asal_sekolah,
                'alamat_sekolah' => $request->alamat_sekolah,
                'alamat_rumah' => $request->alamat_rumah
            ]);

            // Hapus semua relasi lomba yang lama
            DB::table('pendaftaran_lomba')
                ->where('id_pendaftaran', $id)
                ->delete();

            // Simpan pilihan lomba yang baru
            if ($request->has('perlombaan') && is_array($request->perlombaan)) {
                foreach ($request->perlombaan as $id_perlombaan) {
                    DB::table('pendaftaran_lomba')->insert([
                        'id_pendaftaran' => $id,
                        'id_perlombaan' => $id_perlombaan,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }

            DB::commit();
            return Redirect::back()->with(messageSuccess('Data Berhasil Diupdate'));
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        try {
            DB::beginTransaction();

            // Hapus relasi di tabel pendaftaran_lomba terlebih dahulu
            DB::table('pendaftaran_lomba')
                ->where('id_pendaftaran', $id)
                ->delete();

            // Hapus data pendaftaran
            PendaftaranGotTalent::where('id', $id)->delete();

            DB::commit();
            return Redirect::back()->with(messageSuccess('Data Berhasil Dihapus'));
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Perlombaan;
use App\Models\JenjangPendidikan;
use App\Models\PendaftaranGotTalent;
use App\Models\UserPendaftaranGotTalent;
use App\Models\KonfirmasiPembayaranGotTalent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class PerlombaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Perlombaan::with('jenjangPendidikan')->withCount('pendaftaran');
        if (!empty($request->jenis_perlombaan_search)) {
            $query->where('jenis_perlombaan', 'like', '%' . $request->jenis_perlombaan_search . '%');
        }
        if (!empty($request->id_jenjang_search)) {
            $query->where('id_jenjang', $request->id_jenjang_search);
        }
        $perlombaan = $query->latest()->get();
        $jenjangPendidikan = JenjangPendidikan::orderBy('jenjang_pendidikan')->get();

        $stats = [
            'total_lomba' => Perlombaan::count(),
            'total_jenjang' => JenjangPendidikan::has('perlombaan')->count(),
            'total_peserta' => \DB::table('pendaftaran_lomba')->distinct('id_pendaftaran')->count('id_pendaftaran'),
            'total_juknis' => Perlombaan::whereNotNull('juknis_juklak')->where('juknis_juklak', '!=', '')->count(),
        ];

        return view('perlombaan.index', compact('perlombaan', 'jenjangPendidikan', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jenjangPendidikan = JenjangPendidikan::orderBy('jenjang_pendidikan')->get();
        return view('perlombaan.create', compact('jenjangPendidikan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'jenis_perlombaan' => 'required',
            'id_jenjang' => 'required|exists:jenjang_pendidikan,id',
            'biaya_pendaftaran' => 'required|numeric|min:0',
            'contact_person' => 'required|string|max:255',
            'juknis_juklak' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        try {
            $data = [
                'jenis_perlombaan' => $request->jenis_perlombaan,
                'id_jenjang' => $request->id_jenjang,
                'biaya_pendaftaran' => $request->biaya_pendaftaran,
                'contact_person' => $request->contact_person,
            ];

            // Handle file upload juknis_juklak
            if ($request->hasFile('juknis_juklak')) {
                $file = $request->file('juknis_juklak');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/juknis_juklak', $fileName);
                $data['juknis_juklak'] = 'juknis_juklak/' . $fileName;
            }

            // Handle thumbnail upload
            if ($request->hasFile('thumbnail')) {
                $thumbnail = $request->file('thumbnail');
                $thumbnailName = time() . '_' . $thumbnail->getClientOriginalName();
                $thumbnail->storeAs('public/thumbnails', $thumbnailName);
                $data['thumbnail'] = 'thumbnails/' . $thumbnailName;
            }

            Perlombaan::create($data);

            return Redirect::back()->with(messageSuccess('Data Berhasil Disimpan'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $perlombaan = Perlombaan::where('id', $id)->first();
        $jenjangPendidikan = JenjangPendidikan::orderBy('jenjang_pendidikan')->get();
        return view('perlombaan.edit', compact('perlombaan', 'jenjangPendidikan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $id = Crypt::decrypt($id);
        $request->validate([
            'jenis_perlombaan' => 'required',
            'id_jenjang' => 'required|exists:jenjang_pendidikan,id',
            'biaya_pendaftaran' => 'required|numeric|min:0',
            'contact_person' => 'required|string|max:255',
            'juknis_juklak' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);
        try {
            $perlombaan = Perlombaan::where('id', $id)->first();
            
            $data = [
                'jenis_perlombaan' => $request->jenis_perlombaan,
                'id_jenjang' => $request->id_jenjang,
                'biaya_pendaftaran' => $request->biaya_pendaftaran,
                'contact_person' => $request->contact_person,
            ];

            // Handle file upload juknis_juklak
            if ($request->hasFile('juknis_juklak')) {
                // Delete old file if exists
                if ($perlombaan->juknis_juklak && Storage::exists('public/' . $perlombaan->juknis_juklak)) {
                    Storage::delete('public/' . $perlombaan->juknis_juklak);
                }

                $file = $request->file('juknis_juklak');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/juknis_juklak', $fileName);
                $data['juknis_juklak'] = 'juknis_juklak/' . $fileName;
            }

            // Handle thumbnail upload
            if ($request->hasFile('thumbnail')) {
                // Delete old thumbnail if exists
                if ($perlombaan->thumbnail && Storage::exists('public/' . $perlombaan->thumbnail)) {
                    Storage::delete('public/' . $perlombaan->thumbnail);
                }

                $thumbnail = $request->file('thumbnail');
                $thumbnailName = time() . '_' . $thumbnail->getClientOriginalName();
                $thumbnail->storeAs('public/thumbnails', $thumbnailName);
                $data['thumbnail'] = 'thumbnails/' . $thumbnailName;
            }

            Perlombaan::where('id', $id)->update($data);

            return Redirect::back()->with(messageSuccess('Data Berhasil Diupdate'));
        } catch (\Exception $e) {
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
            $perlombaan = Perlombaan::where('id', $id)->first();
            
            // Delete file if exists
            if ($perlombaan->juknis_juklak && Storage::exists('public/' . $perlombaan->juknis_juklak)) {
                Storage::delete('public/' . $perlombaan->juknis_juklak);
            }

            // Delete thumbnail if exists
            if ($perlombaan->thumbnail && Storage::exists('public/' . $perlombaan->thumbnail)) {
                Storage::delete('public/' . $perlombaan->thumbnail);
            }
            
            Perlombaan::where('id', $id)->delete();
            return Redirect::back()->with(['success' => 'Data Berhasil Dihapus']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Reset semua data Al Amin Got Talent:
     * - Perlombaan (beserta berkas juknis & thumbnail)
     * - Pendaftaran Got Talent & pivot pendaftaran_lomba
     * - Konfirmasi Pembayaran Got Talent (beserta berkas bukti pembayaran)
     * - User akun peserta Got Talent (dari relasi user_pendaftaran_got_talent maupun role 'peserta')
     */
    public function resetData()
    {
        try {
            DB::beginTransaction();

            // 1. Ambil & hapus bukti pembayaran konfirmasi got talent
            $konfirmasiList = KonfirmasiPembayaranGotTalent::all();
            foreach ($konfirmasiList as $k) {
                if ($k->bukti_pembayaran && Storage::disk('public')->exists($k->bukti_pembayaran)) {
                    Storage::disk('public')->delete($k->bukti_pembayaran);
                } elseif ($k->bukti_pembayaran && Storage::exists('public/' . $k->bukti_pembayaran)) {
                    Storage::delete('public/' . $k->bukti_pembayaran);
                }
            }
            KonfirmasiPembayaranGotTalent::query()->delete();

            // 2. Kumpulkan ID User terkait peserta Got Talent
            // a. Dari tabel penghubung user_pendaftaran_got_talent
            $userFromRelations = UserPendaftaranGotTalent::pluck('id_user')->toArray();
            
            // b. Dari users yang memiliki role 'peserta'
            $userFromRoles = [];
            try {
                $userFromRoles = User::role('peserta')->pluck('id')->toArray();
            } catch (\Exception $e) {
                // Abaikan jika spatie role peserta belum disetup
            }

            $userIdsToDelete = array_unique(array_merge($userFromRelations, $userFromRoles));

            // Kosongkan tabel relasi user_pendaftaran_got_talent
            DB::table('user_pendaftaran_got_talent')->delete();

            // Hapus user yang terkumpul
            if (!empty($userIdsToDelete)) {
                foreach ($userIdsToDelete as $userId) {
                    $u = User::find($userId);
                    if ($u) {
                        // Jangan hapus jika user tersebut adalah admin/karyawan/super admin
                        if (method_exists($u, 'hasRole') && ($u->hasRole('admin') || $u->hasRole('super admin') || $u->hasRole('administrator') || $u->hasRole('karyawan'))) {
                            continue;
                        }
                        $u->delete();
                    }
                }
            }

            // 3. Kosongkan tabel pendaftaran_lomba dan pendaftaran_got_talent
            DB::table('pendaftaran_lomba')->delete();
            DB::table('pendaftaran_got_talent')->delete();

            // 4. Hapus file lampiran di perlombaan (juknis_juklak & thumbnail) dan kosongkan tabel perlombaan
            $perlombaanList = Perlombaan::all();
            foreach ($perlombaanList as $lomba) {
                if ($lomba->juknis_juklak && Storage::exists('public/' . $lomba->juknis_juklak)) {
                    Storage::delete('public/' . $lomba->juknis_juklak);
                }
                if ($lomba->thumbnail && Storage::exists('public/' . $lomba->thumbnail)) {
                    Storage::delete('public/' . $lomba->thumbnail);
                }
            }
            DB::table('perlombaan')->delete();

            if (DB::transactionLevel() > 0) {
                DB::commit();
            }
            return Redirect::back()->with(messageSuccess('Seluruh data Al Amin Got Talent (Perlombaan, Pendaftaran, Konfirmasi Pembayaran, dan Akun Peserta) berhasil di-reset bersih.'));
        } catch (\Exception $e) {
            if (DB::transactionLevel() > 0) {
                DB::rollBack();
            }
            return Redirect::back()->with(messageError('Gagal mereset data: ' . $e->getMessage()));
        }
    }
}

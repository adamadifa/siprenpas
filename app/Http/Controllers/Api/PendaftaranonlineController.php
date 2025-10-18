<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pembayaranpendaftaranonline;
use App\Models\Pendaftaranonline;
use App\Models\User;
use App\Models\Userpendaftar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PendaftaranonlineController extends Controller
{
    /**
     * Update foto pendaftaran online berdasarkan nomor registrasi.
     *
     * @OA\Post(
     *     path="/pendaftaranonline/{no_register}/update-foto",
     *     summary="Update foto pendaftaran online",
     *     tags={"Pendaftaran Online"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="no_register",
     *         in="path",
     *         required=true,
     *         description="Nomor registrasi pendaftar yang akan diperbarui.",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"foto"},
     *                 @OA\Property(
     *                     property="foto",
     *                     type="string",
     *                     format="binary"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Foto berhasil diperbarui.",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Foto berhasil diperbarui."),
     *             @OA\Property(property="foto_url", type="string", example="/storage/foto/pendaftaran/namafile.jpg")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validasi gagal.",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Validasi gagal.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Terjadi kesalahan saat memperbarui foto.",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Terjadi kesalahan saat memperbarui foto.")
     *         )
     *     )
     * )
     */
    public function updateFoto(Request $request, $no_register)
    {
        try {
            $request->validate([
                'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $pendaftaran = Pendaftaranonline::where('no_register', $no_register)->first();
            if (!$pendaftaran) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data pendaftaran tidak ditemukan.'
                ], 404);
            }

            // Hapus foto lama jika ada
            $oldFile = 'pendaftaranonline/' . $pendaftaran->foto;
            if ($pendaftaran->foto && Storage::disk('public')->exists($oldFile)) {
                Storage::disk('public')->delete($oldFile);
            }

            $file = $request->file('foto');
            $ext = $file->getClientOriginalExtension();
            $filename = $no_register . '.' . $ext;
            $path = $file->storeAs('pendaftaranonline', $filename, 'public');

            $pendaftaran->foto = $filename;
            $pendaftaran->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Foto berhasil diperbarui.',
                'foto_url' => url(Storage::url($path)) . '?v=' . time()
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memperbarui foto.'
            ], 500);
        }
    }


    /**
     * Mendapatkan data pendaftaran online berdasarkan ID user.
     *
     * @OA\Get(
     *     path="/pendaftaranonline/{id_user}",
     *     tags={"Pendaftaran Online"},
     *     summary="Ambil data pendaftaran online berdasarkan ID user (autentikasi diperlukan)",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id_user",
     *         in="path",
     *         description="ID user",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data pendaftaran online",
     *         @OA\JsonContent(type="object")
     *     )
     * )
     *
     * @param int $id ID user
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPendaftaranonlineByIdUser($id)
    {
        $user = User::where('id', $id)->first();
        $user_pendaftar = Userpendaftar::where('id_user', $user->id)->first();
        $pendaftaranonline = Pendaftaranonline::where('no_register', $user_pendaftar->no_register)->first();
        if ($pendaftaranonline) {
            $pendaftaranonline = $pendaftaranonline->toArray();
            // Untuk menghindari CORS pada foto_url, gunakan route API khusus yang serve file dengan header CORS
            if (!empty($pendaftaranonline['foto'])) {
                // Buat endpoint khusus misal: /api/public/pendaftaranonline-foto/{filename}
                $pendaftaranonline['foto_url'] = url('/storage/pendaftaranonline/' . $pendaftaranonline['foto']);
            } else {
                $pendaftaranonline['foto_url'] = null;
            }
        }
        return response()->json($pendaftaranonline);
    }


    /**
     * Update data pendaftaran online berdasarkan nomor registrasi.
     *
     * @OA\Post(
     *     path="/pendaftaranonline/{no_register}/update",
     *     summary="Update data pendaftaran online",
     *     tags={"Pendaftaran Online"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="no_register",
     *         in="path",
     *         required=true,
     *         description="Nomor registrasi pendaftar yang akan diperbarui.",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nama_lengkap","jenis_kelamin","tempat_lahir","tanggal_lahir","anak_ke","jumlah_saudara","alamat","kode_pos","no_kk","nik_ayah","nama_ayah","pendidikan_ayah","pekerjaan_ayah","nik_ibu","nama_ibu","pendidikan_ibu","pekerjaan_ibu","no_hp","asal_sekolah","provinsi_id","kabupaten_id","kecamatan_id","desa_id"},
     *             @OA\Property(property="nama_lengkap", type="string", example="Budi Santoso"),
     *             @OA\Property(property="jenis_kelamin", type="string", enum={"L","P"}, example="L"),
     *             @OA\Property(property="tempat_lahir", type="string", example="Jakarta"),
     *             @OA\Property(property="tanggal_lahir", type="string", format="date", example="2010-01-01"),
     *             @OA\Property(property="anak_ke", type="integer", example=1),
     *             @OA\Property(property="jumlah_saudara", type="integer", example=2),
     *             @OA\Property(property="alamat", type="string", example="Jl. Merdeka No. 1"),
     *             @OA\Property(property="kode_pos", type="string", example="12345"),
     *             @OA\Property(property="no_kk", type="string", example="1234567890123456"),
     *             @OA\Property(property="nik_ayah", type="string", example="1234567890123456"),
     *             @OA\Property(property="nama_ayah", type="string", example="Agus Santoso"),
     *             @OA\Property(property="pendidikan_ayah", type="string", enum={"SD","SMP","SMA","D3","S1","S2","S3"}, example="S1"),
     *             @OA\Property(property="pekerjaan_ayah", type="string", example="Karyawan Swasta"),
     *             @OA\Property(property="nik_ibu", type="string", example="1234567890123456"),
     *             @OA\Property(property="nama_ibu", type="string", example="Siti Aminah"),
     *             @OA\Property(property="pendidikan_ibu", type="string", enum={"SD","SMP","SMA","D3","S1","S2","S3"}, example="S1"),
     *             @OA\Property(property="pekerjaan_ibu", type="string", example="Ibu Rumah Tangga"),
     *             @OA\Property(property="no_hp", type="string", example="081234567890"),
     *             @OA\Property(property="asal_sekolah", type="string", example="SDN 1 Jakarta"),
     *             @OA\Property(property="provinsi_id", type="string", example="31"),
     *             @OA\Property(property="kabupaten_id", type="string", example="3174"),
     *             @OA\Property(property="kecamatan_id", type="string", example="317405"),
     *             @OA\Property(property="desa_id", type="string", example="3174051001")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data pendaftar berhasil diperbarui.",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Data pendaftar berhasil diperbarui.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Terjadi kesalahan saat memperbarui data.",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Terjadi kesalahan saat memperbarui data: [error message]")
     *         )
     *     )
     * )
     */
    public function update(Request $request, $no_register)
    {
        DB::beginTransaction();
        try {

            $request->validate([
                'nama_lengkap' => 'required|string|min:3',
                'jenis_kelamin' => 'required|in:L,P',
                'tempat_lahir' => 'required|string|min:3',
                'tanggal_lahir' => 'required|date|before_or_equal:today',
                'anak_ke' => 'required|integer|min:1|max:20',
                'jumlah_saudara' => 'required|integer|min:0|max:20',
                'alamat' => 'required|string|min:10',
                'kode_pos' => 'required|digits:5',
                'no_kk' => 'required|digits:16',
                'nik_ayah' => 'required|digits:16',
                'nama_ayah' => 'required|string|min:3',
                'pendidikan_ayah' => 'required|in:SD,SMP,SMA,D3,S1,S2,S3',
                'pekerjaan_ayah' => 'required|string|min:3',
                'nik_ibu' => 'required|digits:16',
                'nama_ibu' => 'required|string|min:3',
                'pendidikan_ibu' => 'required|in:SD,SMP,SMA,D3,S1,S2,S3',
                'pekerjaan_ibu' => 'required|string|min:3',
                'no_hp' => ['required', 'regex:/^(\+62|62|0)8[1-9][0-9]{6,9}$/'],
                // 'asal_sekolah' => 'required|string|min:3',
                // 'provinsi_id' => 'required',
                // 'kabupaten_id' => 'required',
                // 'kecamatan_id' => 'required',
                // 'desa_id' => 'required',

            ]);


            Pendaftaranonline::where('no_register', $no_register)->update([
                'nisn' => $request->nisn,
                'nama_lengkap' => $request->nama_lengkap,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => date('Y-m-d', strtotime($request->tanggal_lahir)),
                'anak_ke' => $request->anak_ke,
                'jumlah_saudara' => $request->jumlah_saudara,
                'alamat' => $request->alamat,
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
                'no_hp' => $request->no_hp,
                'asal_sekolah' => $request->asal_sekolah,
                // 'id_province' => $request->provinsi_id,
                // 'id_regency' => $request->kabupaten_id,
                // 'id_district' => $request->kecamatan_id,
                // 'id_village' => $request->desa_id,
            ]);

            $user_pendaftar = Userpendaftar::where('no_register', $no_register)->first();

            User::where('id', $user_pendaftar->id_user)->update([
                'name' => $request->nama_lengkap,
            ]);

            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Data pendaftar berhasil diperbarui.',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Simpan konfirmasi pembayaran pendaftaran online.
     *
     * @OA\Post(
     *     path="/pendaftaranonline/konfirmasi-pembayaran",
     *     summary="Konfirmasi pembayaran pendaftaran online",
     *     tags={"Pendaftaran Online"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"jumlah_pembayaran","metode_pembayaran","bukti_pembayaran"},
     *                 @OA\Property(property="jumlah_pembayaran", type="number", format="float"),
     *                 @OA\Property(property="metode_pembayaran", type="string", enum={"transfer","tunai"}),
     *                 @OA\Property(property="bukti_pembayaran", type="string", format="binary"),
     *                 @OA\Property(property="keterangan", type="string")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Konfirmasi pembayaran berhasil disimpan.",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Konfirmasi pembayaran berhasil disimpan.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validasi gagal.",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Validasi gagal."),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
     */
    public function konfirmasiPembayaran(Request $request)
    {
        $request->validate([
            'jumlah_pembayaran' => 'required|numeric',
            'metode_pembayaran' => 'required|in:transfer,tunai',
            'bukti_pembayaran' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'keterangan' => 'nullable|string',
        ]);

        $user = Auth::user();
        $user_pendaftar = Userpendaftar::where('id_user', $user->id)->first();
        if (!$user_pendaftar) {
            return response()->json([
                'status' => 'error',
                'message' => 'User belum terdaftar sebagai pendaftar.'
            ], 404);
        }
        $no_register = $user_pendaftar->no_register;

        // Upload bukti pembayaran
        $bukti_pembayaran = $request->file('bukti_pembayaran');
        $path = $bukti_pembayaran->store('bukti_pembayaran', 'public');

        // Simpan data pembayaran
        $pembayaran = new \App\Models\Pembayaranpendaftaranonline();
        $pembayaran->no_register = $no_register;
        $pembayaran->tanggal_pembayaran = Carbon::today();
        $pembayaran->jumlah_pembayaran = $request->jumlah_pembayaran;
        $pembayaran->metode_pembayaran = $request->metode_pembayaran;
        $pembayaran->bukti_pembayaran = $path;
        $pembayaran->status = 'pending';
        $pembayaran->keterangan = $request->keterangan;
        $pembayaran->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Konfirmasi pembayaran berhasil disimpan.'
        ]);
    }


    /**
     * Ambil data konfirmasi pembayaran pendaftaran online milik user yang sedang login.
     *
     * @OA\Get(
     *     path="/pendaftaranonline/getkonfirmasipembayaran",
     *     summary="Ambil data konfirmasi pembayaran pendaftaran online milik user yang login",
     *     tags={"Pendaftaran Online"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Data konfirmasi pembayaran ditemukan.",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="no_register", type="string", example="REGU01001"),
     *             @OA\Property(property="tanggal_pembayaran", type="string", format="date", example="2024-07-10"),
     *             @OA\Property(property="jumlah_pembayaran", type="number", format="float", example=500000),
     *             @OA\Property(property="metode_pembayaran", type="string", example="transfer"),
     *             @OA\Property(property="bukti_pembayaran", type="string", example="bukti_pembayaran/abc123.jpg"),
     *             @OA\Property(property="status", type="string", example="pending"),
     *             @OA\Property(property="keterangan", type="string", example="Pembayaran awal"),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2024-07-10T10:00:00Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2024-07-10T10:00:00Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Data pembayaran tidak ditemukan.",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Data pembayaran tidak ditemukan.")
     *         )
     *     )
     * )
     */
    public function getKonfirmasiPembayaran()
    {
        $user = Auth::user();
        //return $user;
        $user_pendaftar = Userpendaftar::where('id_user', $user->id)->first();
        if (!$user_pendaftar) {
            return response()->json([
                'status' => 'error',
                'message' => 'User belum terdaftar sebagai pendaftar.'
            ], 404);
        }
        $no_register = $user_pendaftar->no_register;
        $pembayaran = \App\Models\Pembayaranpendaftaranonline::where('no_register', $no_register)->first();
        if (!$pembayaran) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data pembayaran tidak ditemukan.'
            ], 404);
        }
        $data = $pembayaran->toArray();
        if ($pembayaran->bukti_pembayaran) {
            $data['bukti_pembayaran'] = url(\Illuminate\Support\Facades\Storage::url($pembayaran->bukti_pembayaran));
        } else {
            $data['bukti_pembayaran'] = null;
        }
        return response()->json($data);
    }


    /**
     * @OA\Delete(
     *     path="/api/pendaftaranonline/delete-pembayaran",
     *     summary="Hapus konfirmasi pembayaran pendaftaran online",
     *     tags={"Pendaftaran Online"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Konfirmasi pembayaran berhasil dihapus.",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Konfirmasi pembayaran berhasil dihapus.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Data pembayaran tidak ditemukan.",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Data pembayaran tidak ditemukan.")
     *         )
     *     )
     * )
     */
    public function deletePembayaran()
    {
        $user = Auth::user();
        $user_pendaftar = Userpendaftar::where('id_user', $user->id)->first();
        if (!$user_pendaftar) {
            return response()->json([
                'status' => 'error',
                'message' => 'User belum terdaftar sebagai pendaftar.'
            ], 404);
        }
        $no_register = $user_pendaftar->no_register;
        $pembayaran = \App\Models\Pembayaranpendaftaranonline::where('no_register', $no_register)->first();
        if (!$pembayaran) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data pembayaran tidak ditemukan.'
            ], 404);
        }

        // Hapus file bukti pembayaran jika ada
        if ($pembayaran->bukti_pembayaran && \Illuminate\Support\Facades\Storage::disk('public')->exists($pembayaran->bukti_pembayaran)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($pembayaran->bukti_pembayaran);
        }

        $pembayaran->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Konfirmasi pembayaran berhasil dihapus.'
        ]);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PendaftaranGotTalent;
use App\Models\JenjangPendidikan;
use App\Models\Perlombaan;
use App\Models\User;
use App\Models\UserPendaftaranGotTalent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="Pendaftaran Got Talent",
 *     description="API endpoints untuk pendaftaran Al Amin Got Talent"
 * )
 *
 * @OA\Schema(
 *     schema="PendaftaranGotTalent",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="nomor_register", type="string", example="GT241001"),
 *     @OA\Property(property="nama_lengkap", type="string", example="Ahmad Fauzi"),
 *     @OA\Property(property="tempat_lahir", type="string", example="Jakarta"),
 *     @OA\Property(property="tanggal_lahir", type="string", format="date", example="2010-05-15"),
 *     @OA\Property(property="id_jenjang", type="integer", example=1),
 *     @OA\Property(property="asal_sekolah", type="string", example="SD Al Amin"),
 *     @OA\Property(property="alamat_sekolah", type="string", example="Jl. Raya No. 123"),
 *     @OA\Property(property="alamat_rumah", type="string", example="Jl. Rumah No. 456"),
 *     @OA\Property(property="no_hp", type="string", example="081234567890"),
 *     @OA\Property(property="email", type="string", example="GT241001@agt.com", description="Email di-generate otomatis dari nomor register dengan akhiran @agt.com"),
 *     @OA\Property(property="created_at", type="string", format="datetime", example="2024-01-01 00:00:00"),
 *     @OA\Property(property="updated_at", type="string", format="datetime", example="2024-01-01 00:00:00"),
 *     @OA\Property(
 *         property="jenjang_pendidikan",
 *         type="object",
 *         @OA\Property(property="id", type="integer", example=1),
 *         @OA\Property(property="jenjang_pendidikan", type="string", example="SD")
 *     ),
 *     @OA\Property(
 *         property="perlombaan",
 *         type="array",
 *         @OA\Items(
 *             type="object",
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="jenis_perlombaan", type="string", example="Lomba Baca Puisi"),
 *             @OA\Property(property="id_jenjang", type="integer", example=1)
 *         )
 *     )
 * )
 *
 * @OA\Schema(
 *     schema="RegisterResponse",
 *     type="object",
 *     @OA\Property(property="success", type="boolean", example=true),
 *     @OA\Property(property="message", type="string", example="Registrasi berhasil"),
 *     @OA\Property(
 *         property="data",
 *         type="object",
 *         @OA\Property(property="user", type="object"),
 *         @OA\Property(property="pendaftaran", ref="#/components/schemas/PendaftaranGotTalent"),
 *         @OA\Property(property="token", type="string", example="1|xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx")
 *     )
 * )
 *
 * @OA\Schema(
 *     schema="ErrorResponse",
 *     type="object",
 *     @OA\Property(property="success", type="boolean", example=false),
 *     @OA\Property(property="message", type="string", example="Error message"),
 *     @OA\Property(property="errors", type="object", nullable=true)
 * )
 */
class PendaftaranGotTalentController extends Controller
{
    /**
     * Register pendaftaran Al Amin Got Talent
     *
     * Catatan: Email dan password akan di-generate otomatis. Email dibuat dari nomor register dengan akhiran @agt.com (contoh: GT241001@agt.com). Password sama dengan nomor HP yang diinput.
     *
     * @OA\Post(
     *     path="/api/pendaftaran-got-talent/register",
     *     summary="Daftar Al Amin Got Talent",
     *     description="Endpoint untuk mendaftar Al Amin Got Talent. Email akan di-generate otomatis dari nomor register dengan format: {nomor_register}@agt.com. Password akan di-set sama dengan nomor HP yang diinput.",
     *     tags={"Pendaftaran Got Talent"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
 *             required={"nama_lengkap", "tempat_lahir", "tanggal_lahir", "id_jenjang", "asal_sekolah", "alamat_sekolah", "alamat_rumah", "no_hp", "perlombaan"},
 *             @OA\Property(property="nama_lengkap", type="string", example="Ahmad Fauzi", description="Nama lengkap peserta"),
 *             @OA\Property(property="tempat_lahir", type="string", example="Jakarta", description="Tempat lahir peserta"),
 *             @OA\Property(property="tanggal_lahir", type="string", format="date", example="2010-05-15", description="Tanggal lahir peserta (format: YYYY-MM-DD)"),
 *             @OA\Property(property="id_jenjang", type="integer", example=1, description="ID jenjang pendidikan"),
     *             @OA\Property(property="asal_sekolah", type="string", example="SD Al Amin", description="Nama asal sekolah"),
     *             @OA\Property(property="alamat_sekolah", type="string", example="Jl. Raya No. 123", description="Alamat sekolah"),
     *             @OA\Property(property="alamat_rumah", type="string", example="Jl. Rumah No. 456", description="Alamat rumah"),
     *             @OA\Property(property="no_hp", type="string", example="081234567890", description="Nomor HP (akan digunakan sebagai password)"),
     *             @OA\Property(property="perlombaan", type="array", @OA\Items(type="integer"), example={1, 2, 3}, description="Array ID perlombaan yang dipilih")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Registrasi berhasil. Email dan password akan dikembalikan dalam response data user.",
     *         @OA\JsonContent(
     *             allOf={
     *                 @OA\Schema(ref="#/components/schemas/RegisterResponse")
     *             },
     *             @OA\Examples(
     *                 example="success",
     *                 summary="Contoh response sukses",
     *                 value={
     *                     "success": true,
     *                     "message": "Registrasi berhasil",
     *                     "data": {
     *                         "user": {
     *                             "id": 1,
     *                             "name": "Ahmad Fauzi",
     *                             "email": "GT241001@agt.com",
     *                             "username": "GT241001@agt.com"
     *                         },
     *                         "pendaftaran": {
     *                             "id": 1,
     *                             "nomor_register": "GT241001",
     *                             "nama_lengkap": "Ahmad Fauzi",
     *                             "email": "GT241001@agt.com",
     *                             "no_hp": "081234567890"
     *                         },
     *                         "token": "1|xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"
     *                     }
     *                 }
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validasi gagal",
     *         @OA\JsonContent(
     *             ref="#/components/schemas/ErrorResponse"
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             ref="#/components/schemas/ErrorResponse"
     *         )
     *     )
     * )
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:100',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'id_jenjang' => 'required|exists:jenjang_pendidikan,id',
            'asal_sekolah' => 'required|string|max:200',
            'alamat_sekolah' => 'required|string',
            'alamat_rumah' => 'required|string',
            'no_hp' => 'required|string|max:20',
            'perlombaan' => 'required|array|min:1',
            'perlombaan.*' => 'exists:perlombaan,id'
        ], [
            'nama_lengkap.required' => 'Nama Lengkap harus diisi',
            'tempat_lahir.required' => 'Tempat Lahir harus diisi',
            'tanggal_lahir.required' => 'Tanggal Lahir harus diisi',
            'tanggal_lahir.date' => 'Format Tanggal Lahir tidak valid',
            'id_jenjang.required' => 'Jenjang Pendidikan harus dipilih',
            'id_jenjang.exists' => 'Jenjang Pendidikan tidak valid',
            'asal_sekolah.required' => 'Asal Sekolah harus diisi',
            'alamat_sekolah.required' => 'Alamat Sekolah harus diisi',
            'alamat_rumah.required' => 'Alamat Rumah harus diisi',
            'no_hp.required' => 'No. HP harus diisi',
            'perlombaan.required' => 'Pilihan Lomba harus dipilih minimal 1',
            'perlombaan.min' => 'Pilihan Lomba harus dipilih minimal 1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            // Generate nomor register
            $lastPendaftaran = PendaftaranGotTalent::select('nomor_register')
                ->orderBy('nomor_register', 'desc')
                ->first();

            $last_nomor_register = $lastPendaftaran != null ? $lastPendaftaran->nomor_register : '';
            $format = "GT" . date('y');
            $nomor_register = buatkode($last_nomor_register, $format, 4);

            // Generate email dari nomor register dengan akhiran @agt.com
            $email = $nomor_register . '@agt.com';

            // Create pendaftaran
            $pendaftaran = PendaftaranGotTalent::create([
                'nomor_register' => $nomor_register,
                'nama_lengkap' => $request->nama_lengkap,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'id_jenjang' => $request->id_jenjang,
                'asal_sekolah' => $request->asal_sekolah,
                'alamat_sekolah' => $request->alamat_sekolah,
                'alamat_rumah' => $request->alamat_rumah,
                'no_hp' => $request->no_hp,
                'email' => $email
            ]);

            // Simpan pilihan lomba
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

            // Create user dengan email dari nomor register dan password dari no_hp
            $user = User::create([
                'name' => $request->nama_lengkap,
                'username' => $email,
                'email' => $email,
                'password' => Hash::make($request->no_hp),
                'kode_unit' => 'U00',
            ]);

            $user->assignRole('peserta');

            // Simpan relasi ke tabel penghubung
            UserPendaftaranGotTalent::create([
                'id_pendaftaran' => $pendaftaran->id,
                'id_user' => $user->id
            ]);

            // Generate token
            $token = $user->createToken('got-talent')->plainTextToken;

            DB::commit();

            // Load relationships
            $pendaftaran->load('jenjangPendidikan', 'perlombaan');

            return response()->json([
                'success' => true,
                'message' => 'Registrasi berhasil',
                'data' => [
                    'user' => $user,
                    'pendaftaran' => $pendaftaran,
                    'token' => $token
                ]
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Registrasi gagal: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get pendaftaran by user yang sedang login
     *
     * @OA\Get(
     *     path="/api/pendaftaran-got-talent/my-pendaftaran",
     *     summary="Ambil data pendaftaran user yang login",
     *     tags={"Pendaftaran Got Talent"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Data pendaftaran berhasil diambil",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/PendaftaranGotTalent")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             ref="#/components/schemas/ErrorResponse"
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Data pendaftaran tidak ditemukan",
     *         @OA\JsonContent(
     *             ref="#/components/schemas/ErrorResponse"
     *         )
     *     )
     * )
     */
    public function getMyPendaftaran(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $userPendaftaran = UserPendaftaranGotTalent::where('id_user', $user->id)->first();

        if (!$userPendaftaran) {
            return response()->json([
                'success' => false,
                'message' => 'Data pendaftaran tidak ditemukan'
            ], 404);
        }

        $pendaftaran = PendaftaranGotTalent::with('jenjangPendidikan', 'perlombaan.jenjangPendidikan')
            ->where('id', $userPendaftaran->id_pendaftaran)
            ->first();

        if (!$pendaftaran) {
            return response()->json([
                'success' => false,
                'message' => 'Data pendaftaran tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $pendaftaran
        ], 200);
    }

    /**
     * Update pendaftaran
     *
     * @OA\Put(
     *     path="/api/pendaftaran-got-talent/update",
     *     summary="Update data pendaftaran",
     *     tags={"Pendaftaran Got Talent"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="nama_lengkap", type="string", example="Ahmad Fauzi"),
 *             @OA\Property(property="tempat_lahir", type="string", example="Jakarta"),
 *             @OA\Property(property="tanggal_lahir", type="string", format="date", example="2010-05-15"),
 *             @OA\Property(property="id_jenjang", type="integer", example=1),
 *             @OA\Property(property="asal_sekolah", type="string", example="SD Al Amin"),
 *             @OA\Property(property="alamat_sekolah", type="string", example="Jl. Raya No. 123"),
 *             @OA\Property(property="alamat_rumah", type="string", example="Jl. Rumah No. 456"),
 *             @OA\Property(property="no_hp", type="string", example="081234567890"),
 *             @OA\Property(property="perlombaan", type="array", @OA\Items(type="integer"), example={1, 2, 3})
 *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data berhasil diupdate",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Data berhasil diupdate"),
     *             @OA\Property(property="data", ref="#/components/schemas/PendaftaranGotTalent")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             ref="#/components/schemas/ErrorResponse"
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Data pendaftaran tidak ditemukan",
     *         @OA\JsonContent(
     *             ref="#/components/schemas/ErrorResponse"
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validasi gagal",
     *         @OA\JsonContent(
     *             ref="#/components/schemas/ErrorResponse"
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             ref="#/components/schemas/ErrorResponse"
     *         )
     *     )
     * )
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $userPendaftaran = UserPendaftaranGotTalent::where('id_user', $user->id)->first();

        if (!$userPendaftaran) {
            return response()->json([
                'success' => false,
                'message' => 'Data pendaftaran tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:100',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'id_jenjang' => 'required|exists:jenjang_pendidikan,id',
            'asal_sekolah' => 'required|string|max:200',
            'alamat_sekolah' => 'required|string',
            'alamat_rumah' => 'required|string',
            'no_hp' => 'required|string|max:20',
            'perlombaan' => 'required|array|min:1',
            'perlombaan.*' => 'exists:perlombaan,id'
        ], [
            'nama_lengkap.required' => 'Nama Lengkap harus diisi',
            'tempat_lahir.required' => 'Tempat Lahir harus diisi',
            'tanggal_lahir.required' => 'Tanggal Lahir harus diisi',
            'tanggal_lahir.date' => 'Format Tanggal Lahir tidak valid',
            'id_jenjang.required' => 'Jenjang Pendidikan harus dipilih',
            'asal_sekolah.required' => 'Asal Sekolah harus diisi',
            'alamat_sekolah.required' => 'Alamat Sekolah harus diisi',
            'alamat_rumah.required' => 'Alamat Rumah harus diisi',
            'no_hp.required' => 'No. HP harus diisi',
            'perlombaan.required' => 'Pilihan Lomba harus dipilih minimal 1',
            'perlombaan.min' => 'Pilihan Lomba harus dipilih minimal 1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            PendaftaranGotTalent::where('id', $userPendaftaran->id_pendaftaran)->update([
                'nama_lengkap' => $request->nama_lengkap,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'id_jenjang' => $request->id_jenjang,
                'asal_sekolah' => $request->asal_sekolah,
                'alamat_sekolah' => $request->alamat_sekolah,
                'alamat_rumah' => $request->alamat_rumah,
                'no_hp' => $request->no_hp
            ]);

            // Hapus semua relasi lomba yang lama
            DB::table('pendaftaran_lomba')
                ->where('id_pendaftaran', $userPendaftaran->id_pendaftaran)
                ->delete();

            // Simpan pilihan lomba yang baru
            if ($request->has('perlombaan') && is_array($request->perlombaan)) {
                foreach ($request->perlombaan as $id_perlombaan) {
                    DB::table('pendaftaran_lomba')->insert([
                        'id_pendaftaran' => $userPendaftaran->id_pendaftaran,
                        'id_perlombaan' => $id_perlombaan,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }

            DB::commit();

            $pendaftaran = PendaftaranGotTalent::with('jenjangPendidikan', 'perlombaan.jenjangPendidikan')
                ->where('id', $userPendaftaran->id_pendaftaran)
                ->first();

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diupdate',
                'data' => $pendaftaran
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Update gagal: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get list jenjang pendidikan
     *
     * @OA\Get(
     *     path="/api/pendaftaran-got-talent/jenjang-pendidikan",
     *     summary="Ambil list jenjang pendidikan",
     *     description="Mengambil semua data jenjang pendidikan yang tersedia untuk pendaftaran Got Talent",
     *     tags={"Pendaftaran Got Talent"},
     *     @OA\Response(
     *         response=200,
     *         description="List jenjang pendidikan",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="jenjang_pendidikan", type="string", example="SD"),
     *                     @OA\Property(property="created_at", type="string", format="datetime", nullable=true),
     *                     @OA\Property(property="updated_at", type="string", format="datetime", nullable=true)
     *                 )
     *             )
     *         )
     *     )
     * )
     *
     * @OA\Get(
     *     path="/api/public/jenjang-pendidikan",
     *     summary="Ambil list jenjang pendidikan (Public)",
     *     description="Mengambil semua data jenjang pendidikan yang tersedia (Public API)",
     *     tags={"Public API"},
     *     @OA\Response(
     *         response=200,
     *         description="List jenjang pendidikan",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="jenjang_pendidikan", type="string", example="SD"),
     *                     @OA\Property(property="created_at", type="string", format="datetime", nullable=true),
     *                     @OA\Property(property="updated_at", type="string", format="datetime", nullable=true)
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function getJenjangPendidikan()
    {
        $jenjangPendidikan = JenjangPendidikan::orderBy('id')->get();

        return response()->json([
            'success' => true,
            'data' => $jenjangPendidikan
        ], 200);
    }

    /**
     * Get list perlombaan
     *
     * @OA\Get(
     *     path="/api/pendaftaran-got-talent/perlombaan",
     *     summary="Ambil list perlombaan",
     *     description="Mengambil semua data perlombaan yang tersedia untuk pendaftaran Got Talent",
     *     tags={"Pendaftaran Got Talent"},
     *     @OA\Parameter(
     *         name="id_jenjang",
     *         in="query",
     *         description="Filter by jenjang pendidikan",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List perlombaan",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="jenis_perlombaan", type="string", example="Lomba Baca Puisi"),
     *                     @OA\Property(property="id_jenjang", type="integer", example=1),
     *                     @OA\Property(property="juknis_juklak", type="string", nullable=true, example="juknis_juklak/file.pdf"),
     *                     @OA\Property(property="juknis_juklak_url", type="string", nullable=true, example="http://localhost:8000/storage/juknis_juklak/file.pdf"),
     *                     @OA\Property(property="thumbnail", type="string", nullable=true, example="thumbnails/image.jpg"),
     *                     @OA\Property(property="thumbnail_url", type="string", nullable=true, example="http://localhost:8000/storage/thumbnails/image.jpg"),
     *                     @OA\Property(
     *                         property="jenjang_pendidikan",
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="jenjang_pendidikan", type="string", example="SD")
     *                     ),
     *                     @OA\Property(property="created_at", type="string", format="datetime", nullable=true),
     *                     @OA\Property(property="updated_at", type="string", format="datetime", nullable=true)
     *                 )
     *             )
     *         )
     *     )
     * )
     *
     * @OA\Get(
     *     path="/api/public/perlombaan",
     *     summary="Ambil list perlombaan (Public)",
     *     description="Mengambil semua data perlombaan yang tersedia (Public API)",
     *     tags={"Public API"},
     *     @OA\Parameter(
     *         name="id_jenjang",
     *         in="query",
     *         description="Filter by jenjang pendidikan",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List perlombaan",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="jenis_perlombaan", type="string", example="Lomba Baca Puisi"),
     *                     @OA\Property(property="id_jenjang", type="integer", example=1),
     *                     @OA\Property(property="juknis_juklak", type="string", nullable=true, example="juknis_juklak/file.pdf"),
     *                     @OA\Property(property="juknis_juklak_url", type="string", nullable=true, example="http://localhost:8000/storage/juknis_juklak/file.pdf"),
     *                     @OA\Property(property="thumbnail", type="string", nullable=true, example="thumbnails/image.jpg"),
     *                     @OA\Property(property="thumbnail_url", type="string", nullable=true, example="http://localhost:8000/storage/thumbnails/image.jpg"),
     *                     @OA\Property(
     *                         property="jenjang_pendidikan",
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="jenjang_pendidikan", type="string", example="SD")
     *                     ),
     *                     @OA\Property(property="created_at", type="string", format="datetime", nullable=true),
     *                     @OA\Property(property="updated_at", type="string", format="datetime", nullable=true)
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function getPerlombaan(Request $request)
    {
        $query = Perlombaan::with('jenjangPendidikan')->orderBy('jenis_perlombaan');

        if ($request->has('id_jenjang') && $request->id_jenjang) {
            $query->where('id_jenjang', $request->id_jenjang);
        }

        $perlombaan = $query->get();

        // Tambahkan URL lengkap untuk file juknis_juklak dan thumbnail
        $perlombaan = $perlombaan->map(function ($item) {
            if ($item->juknis_juklak) {
                $item->juknis_juklak_url = url('storage/' . $item->juknis_juklak);
            } else {
                $item->juknis_juklak_url = null;
            }

            if ($item->thumbnail) {
                $item->thumbnail_url = url('storage/' . $item->thumbnail);
            } else {
                $item->thumbnail_url = null;
            }

            return $item;
        });

        return response()->json([
            'success' => true,
            'data' => $perlombaan
        ], 200);
    }

    /**
     * Get all pendaftar Al Amin Got Talent
     *
     * @OA\Get(
     *     path="/api/pendaftaran-got-talent",
     *     summary="Ambil semua data pendaftar Al Amin Got Talent",
     *     description="Mengambil semua data pendaftar Al Amin Got Talent dengan pagination dan filter opsional",
     *     tags={"Pendaftaran Got Talent"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Nomor halaman untuk pagination",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Jumlah data per halaman",
     *         @OA\Schema(type="integer", example=10)
     *     ),
     *     @OA\Parameter(
     *         name="id_jenjang",
     *         in="query",
     *         description="Filter by jenjang pendidikan",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Pencarian berdasarkan nama lengkap, nomor register, atau email",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data pendaftar berhasil diambil",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(
     *                     property="current_page",
     *                     type="integer",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(ref="#/components/schemas/PendaftaranGotTalent")
     *                 ),
     *                 @OA\Property(
     *                     property="first_page_url",
     *                     type="string",
     *                     example="http://localhost:8000/api/pendaftaran-got-talent?page=1"
     *                 ),
     *                 @OA\Property(
     *                     property="from",
     *                     type="integer",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="last_page",
     *                     type="integer",
     *                     example=5
     *                 ),
     *                 @OA\Property(
     *                     property="last_page_url",
     *                     type="string",
     *                     example="http://localhost:8000/api/pendaftaran-got-talent?page=5"
     *                 ),
     *                 @OA\Property(
     *                     property="links",
     *                     type="array",
     *                     @OA\Items(type="object")
     *                 ),
     *                 @OA\Property(
     *                     property="next_page_url",
     *                     type="string",
     *                     nullable=true,
     *                     example="http://localhost:8000/api/pendaftaran-got-talent?page=2"
     *                 ),
     *                 @OA\Property(
     *                     property="path",
     *                     type="string",
     *                     example="http://localhost:8000/api/pendaftaran-got-talent"
     *                 ),
     *                 @OA\Property(
     *                     property="per_page",
     *                     type="integer",
     *                     example=10
     *                 ),
     *                 @OA\Property(
     *                     property="prev_page_url",
     *                     type="string",
     *                     nullable=true
     *                 ),
     *                 @OA\Property(
     *                     property="to",
     *                     type="integer",
     *                     example=10
     *                 ),
     *                 @OA\Property(
     *                     property="total",
     *                     type="integer",
     *                     example=50
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             ref="#/components/schemas/ErrorResponse"
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             ref="#/components/schemas/ErrorResponse"
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        try {
            $query = PendaftaranGotTalent::with(['jenjangPendidikan', 'perlombaan.jenjangPendidikan'])
                ->orderBy('created_at', 'desc');

            // Filter by jenjang pendidikan
            if ($request->has('id_jenjang') && $request->id_jenjang) {
                $query->where('id_jenjang', $request->id_jenjang);
            }

            // Search filter
            if ($request->has('search') && $request->search) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('nama_lengkap', 'like', '%' . $search . '%')
                        ->orWhere('nomor_register', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%')
                        ->orWhere('no_hp', 'like', '%' . $search . '%')
                        ->orWhere('asal_sekolah', 'like', '%' . $search . '%');
                });
            }

            // Pagination
            $perPage = $request->get('per_page', 10);
            $pendaftaran = $query->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $pendaftaran
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data pendaftar: ' . $e->getMessage()
            ], 500);
        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaranonline;
use App\Models\Tahunajaranppdb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Userpendaftar;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/login",
     *     tags={"Auth"},
     *     summary="Login user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", example="user@email.com"),
     *             @OA\Property(property="password", type="string", example="password")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login berhasil",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="user", type="object"),
     *                 @OA\Property(property="token", type="string")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=401, description="Email atau password salah")
     * )
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();


        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah',
            ], 401);
        }

        // Create token for API authentication (Laravel Sanctum)
        $token = $user->createToken('mobile-app')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'data' => [
                'user' => $user,
                'token' => $token,
            ],
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/register-orangtua",
     *     tags={"Auth"},
     *     summary="Register user orang tua",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "password", "password_confirmation", "nik"},
     *             @OA\Property(property="name", type="string", example="Nama Orang Tua"),
     *             @OA\Property(property="email", type="string", example="ortu@email.com"),
     *             @OA\Property(property="password", type="string", example="password"),
     *             @OA\Property(property="password_confirmation", type="string", example="password"),
     *             @OA\Property(property="nik", type="string", example="1234567890123456")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Registrasi berhasil",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="user", type="object"),
     *                 @OA\Property(property="token", type="string")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=404, description="NIK tidak ditemukan pada data siswa"),
     *     @OA\Response(response=409, description="Email atau NIK sudah terdaftar")
     * )
     */
    public function registerOrangtua(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'nik' => 'required|digits:16',
        ]);

        // Cek NIK pada tabel siswa (nik_ayah atau nik_ibu)
        $nik = $request->nik;
        $siswa = \App\Models\Siswa::where('nik_ayah', $nik)
            ->orWhere('nik_ibu', $nik)
            ->first();

        if (!$siswa) {
            return response()->json([
                'success' => false,
                'message' => 'NIK tidak ditemukan pada data siswa. Pastikan NIK ayah atau ibu sudah terdaftar di sekolah.',
            ], 404);
        }

        // Cek email sudah terdaftar
        if (User::where('email', $request->email)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Email sudah terdaftar',
            ], 409);
        }

        // Cek NIK sudah terdaftar sebagai username
        if (User::where('username', $request->nik)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'NIK sudah terdaftar',
            ], 409);
        }

        // Buat user baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->nik,
            'kode_unit' => 'U00',
            'password' => Hash::make($request->password),
        ]);

        // Assign role orang tua
        $user->assignRole('orang tua');

        // Generate token
        $token = $user->createToken('mobile-app')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Registrasi berhasil',
            'data' => [
                'user' => $user,
                'token' => $token,
            ],
        ]);
    }



    /**
     * @OA\Post(
     *     path="/api/auth/register-siswa",
     *     tags={"Auth"},
     *     summary="Register akun siswa baru",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "password", "password_confirmation", "jenis_kelamin", "no_hp", "kode_unit"},
     *             @OA\Property(property="name", type="string", example="Ahmad Fauzi"),
     *             @OA\Property(property="email", type="string", example="siswa@email.com"),
     *             @OA\Property(property="password", type="string", example="password123"),
     *             @OA\Property(property="password_confirmation", type="string", example="password123"),
     *             @OA\Property(property="jenis_kelamin", type="string", enum={"L","P"}, example="L"),
     *             @OA\Property(property="no_hp", type="string", example="08123456789"),
     *             @OA\Property(property="kode_unit", type="string", example="U01")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Registrasi berhasil",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Registrasi berhasil"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="user", type="object",
     *                     @OA\Property(property="no_register", type="string", example="OLU0125X"),
     *                     @OA\Property(property="nama_lengkap", type="string", example="Ahmad Fauzi"),
     *                     @OA\Property(property="email", type="string", example="siswa@email.com"),
     *                     @OA\Property(property="jenis_kelamin", type="string", example="L"),
     *                     @OA\Property(property="no_hp", type="string", example="08123456789"),
     *                     @OA\Property(property="kode_unit", type="string", example="U01"),
     *                     @OA\Property(property="kode_ta", type="string", example="2025")
     *                 ),
     *                 @OA\Property(property="token", type="string", example="token_autentikasi")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validasi gagal",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
     */
    public function registerSiswa(Request $request)
    {

       

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'jenis_kelamin' => ['required', 'string', 'in:L,P'],
            'no_hp' => ['required', 'string', 'max:15'],
            'kode_unit' => ['required', 'string'],
        ]);

        $ta_aktif = Tahunajaranppdb::where('status', 1)->first();
        $ta_pendaftaran = substr($ta_aktif->tahun_ajaran, 2, 2);
        $lastpendaftaran = Pendaftaranonline::select('no_register')
            ->where('kode_ta', $ta_aktif->kode_ta)
            ->where('kode_unit', $request->kode_unit)
            ->orderBy('no_register', 'desc')
            ->first();
        $last_no_register = $lastpendaftaran != null ? $lastpendaftaran->no_register : '';
        $format = "OL" . $request->kode_unit . $ta_pendaftaran;
        $no_register = buatkode($last_no_register, $format, 3);

        DB::beginTransaction();
        try {
            $pendaftar = Pendaftaranonline::create([
                'no_register' => $no_register,
                'tanggal_register' => now(),
                'nama_lengkap' => $request->name,
                'email' => $request->email,
                'jenis_kelamin' => $request->jenis_kelamin,
                'no_hp' => $request->no_hp,
                'kode_unit' => $request->kode_unit,
                'kode_ta' => $ta_aktif->kode_ta,
            ]);


            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $no_register,
                'password' => Hash::make($request->password),
                'kode_unit' => $request->kode_unit,
            ]);

            $user->assignRole('pendaftar');


            Userpendaftar::create([
                'no_register' => $no_register,
                'id_user' => $user->id,
            ]);

            // Generate token
            $token = $user->createToken('spmb')->plainTextToken;
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Registrasi berhasil',
                'data' => [
                    'user' => $user,
                    'pendaftar' => $pendaftar,
                    'token' => $token,
                ],
            ]);
           
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Registrasi gagal'  . $e->getMessage(),
                'data' => null,
            ], 500);
        }
    }
}

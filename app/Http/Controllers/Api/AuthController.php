<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Login API
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
     * Register API untuk Orang Tua
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
}

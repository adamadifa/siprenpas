<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{

    protected $id_type;
    protected function prepareForValidation()
    {
        if (filter_var($this->input('id_user'), FILTER_VALIDATE_EMAIL)) {
            $this->id_type = 'email';
        } else {
            $this->id_type = "username";
        }

        $this->merge(([
            $this->id_type => $this->input('id_user')
        ]));
    }
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'id_user' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $id_user = $this->input('id_user');
        $password = $this->input('password');

        // Tentukan apakah id_user adalah email atau username/NPP
        $isEmail = filter_var($id_user, FILTER_VALIDATE_EMAIL);

        // Cari guru berdasarkan NPP langsung (jika id_user adalah NPP)
        // ATAU cari user dengan email tersebut, dapatkan NPP-nya, lalu cari di tabel guru
        $guru = null;
        if ($isEmail) {
            $matchedUser = \App\Models\User::where('email', $id_user)->first();
            if ($matchedUser && $matchedUser->npp) {
                $guru = \App\Models\Guru::where('npp', $matchedUser->npp)->first();
            }
        } else {
            $guru = \App\Models\Guru::where('npp', $id_user)->first();
        }

        if ($guru && \Illuminate\Support\Facades\Hash::check($password, $guru->password)) {
            // Temukan atau buat user yang sesuai di tabel users
            $user = \App\Models\User::where('username', $guru->npp)
                ->orWhere('npp', $guru->npp)
                ->first();

            if (!$user) {
                // Jika user tidak ditemukan, buat user baru berdasarkan data karyawan
                $karyawan = \App\Models\Karyawan::where('npp', $guru->npp)->first();
                if ($karyawan) {
                    $user = \App\Models\User::create([
                        'name' => $karyawan->nama_lengkap,
                        'kode_unit' => $karyawan->kode_unit ?: $guru->kode_unit,
                        'username' => $karyawan->npp,
                        'npp' => $karyawan->npp,
                        'password' => $guru->password, // Samakan password dengan guru agar konsisten
                        'email' => strtolower(removeTitik($karyawan->npp)) . '@persisalamin.com',
                    ]);

                    // Buat link di user_karyawan jika belum ada
                    \App\Models\Userkaryawan::firstOrCreate([
                        'npp' => $karyawan->npp,
                        'id_user' => $user->id
                    ]);
                }
            } else {
                if (empty($user->npp)) {
                    $user->update(['npp' => $guru->npp]);
                }
            }

            if ($user) {
                // Pastikan role disinkronkan ke 'guru' agar tidak membawa role lain (karyawan/admin dll)
                $user->syncRoles(['guru']);

                // Loginkan user tersebut
                Auth::login($user, $this->boolean('remember'));
                RateLimiter::clear($this->throttleKey());
                return;
            }
        }

        if (!Auth::attempt($this->only($this->id_type, 'password'), $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'id_user' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->input('email')) . '|' . $this->ip());
    }
}

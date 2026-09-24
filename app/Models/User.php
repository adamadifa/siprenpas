<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'kode_unit',
        'kode_dept',
        'kode_jabatan',
        'npp',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'kode_unit', 'kode_unit');
    }

    public function getNppAttribute()
    {
        if (!empty($this->attributes['npp'])) {
            return $this->attributes['npp'];
        }
        $userKaryawan = \App\Models\Userkaryawan::where('id_user', $this->id)->first();
        if ($userKaryawan) {
            return $userKaryawan->npp;
        }
        return $this->username;
    }

    public function getKodeJabatanAttribute()
    {
        $karyawan = \App\Models\Karyawan::where('npp', $this->npp)->first();
        if ($karyawan) {
            return $karyawan->kode_jabatan;
        }
        return $this->attributes['kode_jabatan'] ?? null;
    }

    public function getKodeDeptAttribute()
    {
        $karyawan = \App\Models\Karyawan::where('npp', $this->npp)->first();
        if ($karyawan) {
            return $karyawan->kode_dept;
        }
        return $this->attributes['kode_dept'] ?? null;
    }

    public function getKodeUnitAttribute()
    {
        $karyawan = \App\Models\Karyawan::where('npp', $this->npp)->first();
        if ($karyawan) {
            return $karyawan->kode_unit;
        }
        return $this->attributes['kode_unit'] ?? null;
    }

    /**
     * Relasi ke unit-unit tambahan yang diizinkan untuk diakses user
     */
    public function assignedUnits()
    {
        return $this->belongsToMany(Unit::class, 'user_units', 'user_id', 'kode_unit');
    }

    /**
     * Mendapatkan daftar kode_unit yang berhak diakses oleh user ini.
     * Menggabungkan kode_unit default user + unit tambahan yang di-assign.
     * Jika role adalah 'super admin', mengembalikan null atau semua unit.
     */
    public function getAccessibleUnitCodes()
    {
        if ($this->hasRole('super admin')) {
            return Unit::whereNotIn('kode_unit', ['U00'])->pluck('kode_unit')->toArray();
        }

        $units = [];
        $defaultUnit = $this->kode_unit;
        if (!empty($defaultUnit) && $defaultUnit !== 'U00') {
            $units[] = $defaultUnit;
        }

        $extraUnits = $this->assignedUnits()->pluck('unit.kode_unit')->toArray();
        $merged = array_unique(array_merge($units, $extraUnits));

        return array_values($merged);
    }

    /**
     * Cek apakah user memiliki akses ke kode_unit tertentu
     */
    public function canAccessUnit($kodeUnit)
    {
        if ($this->hasRole('super admin')) {
            return true;
        }
        return in_array($kodeUnit, $this->getAccessibleUnitCodes());
    }

    /**
     * Relasi ke departemen utama
     */
    public function departemen()
    {
        return $this->belongsTo(Departemen::class, 'kode_dept', 'kode_dept');
    }

    /**
     * Relasi ke departemen-departemen tambahan yang diizinkan untuk diakses user
     */
    public function assignedDepartemens()
    {
        return $this->belongsToMany(Departemen::class, 'user_departemens', 'user_id', 'kode_dept');
    }

    /**
     * Mendapatkan daftar kode_dept yang berhak diakses oleh user ini.
     * Menggabungkan kode_dept default user + departemen tambahan yang di-assign.
     * Jika role adalah 'super admin', mengembalikan semua kode departemen.
     */
    public function getAccessibleDeptCodes()
    {
        if ($this->hasRole('super admin')) {
            return Departemen::pluck('kode_dept')->toArray();
        }

        $depts = [];
        $defaultDept = $this->kode_dept;
        if (!empty($defaultDept)) {
            $depts[] = $defaultDept;
        }

        $extraDepts = $this->assignedDepartemens()->pluck('departemen.kode_dept')->toArray();
        $merged = array_unique(array_merge($depts, $extraDepts));

        return array_values($merged);
    }

    /**
     * Cek apakah user memiliki akses ke kode_dept tertentu
     */
    public function canAccessDept($kodeDept)
    {
        if ($this->hasRole('super admin')) {
            return true;
        }
        return in_array($kodeDept, $this->getAccessibleDeptCodes());
    }
}

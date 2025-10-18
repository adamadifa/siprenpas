<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresensiSiswa extends Model
{
    use HasFactory;

    protected $table = 'presensi_siswa';
    protected $primaryKey = 'id';

    protected $fillable = [
        'no_pendaftaran',
        'tanggal',
        'jam_in',
        'jam_out',
        'status'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jam_in' => 'datetime:H:i',
        'jam_out' => 'datetime:H:i',
    ];

    // Status constants
    const STATUS_HADIR = 'h';
    const STATUS_IZIN = 'i';
    const STATUS_SAKIT = 's';
    const STATUS_ALPHA = 'a';

    /**
     * Get the status label
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_HADIR => 'Hadir',
            self::STATUS_IZIN => 'Izin',
            self::STATUS_SAKIT => 'Sakit',
            self::STATUS_ALPHA => 'Alpha',
            default => 'Tidak Diketahui'
        };
    }

    /**
     * Get the status options
     */
    public static function getStatusOptions(): array
    {
        return [
            self::STATUS_HADIR => 'Hadir',
            self::STATUS_IZIN => 'Izin',
            self::STATUS_SAKIT => 'Sakit',
            self::STATUS_ALPHA => 'Alpha',
        ];
    }
}

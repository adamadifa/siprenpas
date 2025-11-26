<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KonfirmasiPembayaranGotTalent extends Model
{
    use HasFactory;

    protected $table = 'konfirmasi_pembayaran_got_talent';

    protected $fillable = [
        'pendaftaran_got_talent_id',
        'tanggal_pembayaran',
        'jumlah_pembayaran',
        'metode_pembayaran',
        'bukti_pembayaran',
        'keterangan',
        'status',
        'catatan_admin',
        'diverifikasi_oleh',
        'diverifikasi_pada',
    ];

    protected $casts = [
        'tanggal_pembayaran' => 'date',
        'jumlah_pembayaran' => 'decimal:2',
        'diverifikasi_pada' => 'datetime',
    ];

    // Relationship dengan PendaftaranGotTalent
    public function pendaftaran(): BelongsTo
    {
        return $this->belongsTo(PendaftaranGotTalent::class, 'pendaftaran_got_talent_id');
    }

    // Relationship dengan User (admin yang verifikasi)
    public function verifikator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'diverifikasi_oleh');
    }

    // Accessor untuk URL bukti pembayaran
    public function getBuktiPembayaranUrlAttribute()
    {
        if ($this->bukti_pembayaran) {
            return asset('storage/' . $this->bukti_pembayaran);
        }

        return null;
    }

    // Scope untuk filter status
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeDiverifikasi($query)
    {
        return $query->where('status', 'diverifikasi');
    }

    public function scopeDitolak($query)
    {
        return $query->where('status', 'ditolak');
    }
}


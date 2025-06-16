<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Pendaftaran extends Model
{
    use HasFactory;
    protected $table = "pendaftaran";
    protected $primaryKey = "no_pendaftaran";
    protected $guarded = [];
    public $incrementing = false;

    public function getPendaftaran($no_pendaftaran = null, Request $request = null)
    {

        $ta_aktif = Tahunajaran::where('status', 1)->first();
        $query = Pendaftaran::query();
        $query->select(
            'siswa.*',
            'pendaftaran.no_pendaftaran',
            'tahun_ajaran',
            'villages.name as desa',
            'nama_unit',
            'districts.name as kecamatan',
            'provinces.name as provinsi',
            'regencies.name as kota',
            'logo'
        );
        $query->join('siswa', 'pendaftaran.id_siswa', 'siswa.id_siswa');
        $query->join('unit', 'pendaftaran.kode_unit', 'unit.kode_unit');
        $query->leftjoin('asal_sekolah', 'pendaftaran.kode_asal_sekolah', 'asal_sekolah.kode_asal_sekolah');
        $query->join('konfigurasi_tahun_ajaran', 'pendaftaran.kode_ta', 'konfigurasi_tahun_ajaran.kode_ta');
        $query->leftJoin('villages', 'siswa.id_village', '=', 'villages.id');
        $query->leftJoin('districts', 'siswa.id_district', '=', 'districts.id');
        $query->leftJoin('provinces', 'siswa.id_province', '=', 'provinces.id');
        $query->leftJoin('regencies', 'siswa.id_regency', '=', 'regencies.id');
        $query->orderBy('no_pendaftaran', 'desc');
        if (!empty($no_pendaftaran)) {
            $query->where('no_pendaftaran', $no_pendaftaran);
        }

        if (!empty($request->nama_lengkap)) {
            $query->where('nama_lengkap', 'like', '%' . $request->nama_lengkap . '%');
        }

        if (!empty($request->kode_unit)) {
            $query->where('pendaftaran.kode_unit', $request->kode_unit);
        }

        if (!empty($request->kode_ta)) {
            $query->where('pendaftaran.kode_ta', $request->kode_ta);
        } else {
            $query->where('pendaftaran.kode_ta', $ta_aktif->kode_ta);
        }
        return $query;
    }
}

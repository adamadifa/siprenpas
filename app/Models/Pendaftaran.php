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

    // Status Siswa Constants
    const STATUS_AKTIF = 1;
    const STATUS_LULUS = 2;
    const STATUS_MENGUNDURKAN_DIRI = 3;
    const STATUS_PINDAH = 4;
    const STATUS_DIKELUARKAN = 5;

    public static function getStatusLabels()
    {
        return [
            self::STATUS_AKTIF => 'Aktif',
            self::STATUS_LULUS => 'Lulus / Naik Kelas',
            self::STATUS_MENGUNDURKAN_DIRI => 'Mengundurkan Diri',
            self::STATUS_PINDAH => 'Pindah Sekolah',
            self::STATUS_DIKELUARKAN => 'Dikeluarkan',
        ];
    }

    public function getPendaftaran($no_pendaftaran = null, Request $request = null)
    {

        $user = User::where('id', auth()->user()->id)->first();
        $ta_aktif = Tahunajaranppdb::where('status', 1)->first();

        $kelas_siswa = Kelassiswa::join('kelas', 'kelas_siswa.kode_kelas', 'kelas.kode_kelas')
            ->select('kelas_siswa.id_siswa', 'nama_kelas')
            ->where('kelas.kode_ta', $ta_aktif->kode_ta);
        $query = Biayasiswa::query();
        $query->select(
            'siswa.*',
            'pendaftaran.no_pendaftaran',
            'pendaftaran.rfid_code',
            'pendaftaran.foto as foto_pendaftaran',
            'tahun_ajaran',
            'villages.name as desa',
            'nama_unit',
            'districts.name as kecamatan',
            'provinces.name as provinsi',
            'regencies.name as kota',
            'logo',
            'nama_unit',
            'pendaftaran.nis',
            'kelas_siswa.nama_kelas',
            'konfigurasi_biaya.tingkat'
        );
        $query->join('pendaftaran', 'siswa_biaya.no_pendaftaran', 'pendaftaran.no_pendaftaran');
        $query->join('siswa', 'pendaftaran.id_siswa', 'siswa.id_siswa');
        $query->join('unit', 'pendaftaran.kode_unit', 'unit.kode_unit');
        $query->join('konfigurasi_biaya', 'siswa_biaya.kode_biaya', 'konfigurasi_biaya.kode_biaya');
        $query->where('konfigurasi_biaya.is_pindahan', 0);
        $query->leftjoin('asal_sekolah', 'pendaftaran.kode_asal_sekolah', 'asal_sekolah.kode_asal_sekolah');
        $query->join('konfigurasi_tahunajaran_ppdb', 'konfigurasi_biaya.kode_ta', 'konfigurasi_tahunajaran_ppdb.kode_ta');
        $query->leftJoin('villages', 'siswa.id_village', '=', 'villages.id');
        $query->leftJoin('districts', 'siswa.id_district', '=', 'districts.id');
        $query->leftJoin('provinces', 'siswa.id_province', '=', 'provinces.id');
        $query->leftJoin('regencies', 'siswa.id_regency', '=', 'regencies.id');
        $query->leftJoinSub($kelas_siswa, 'kelas_siswa', function ($join) {
            $join->on('kelas_siswa.id_siswa', '=', 'siswa.id_siswa');
        });
        $query->orderBy('siswa.nama_lengkap');
        if (!empty($no_pendaftaran)) {
            $query->where('siswa_biaya.no_pendaftaran', $no_pendaftaran);
        } else {
            if (!empty($request->nama_lengkap)) {
                $query->where('nama_lengkap', 'like', '%' . $request->nama_lengkap . '%');
            }

            if (!empty($request->kode_unit)) {
                $query->where('pendaftaran.kode_unit', $request->kode_unit);
            }

            if (!empty($request->kode_ta)) {
                $query->where('konfigurasi_biaya.kode_ta', $request->kode_ta);
            } else {
                $query->where('konfigurasi_biaya.kode_ta', $ta_aktif->kode_ta);
            }

            if (!empty($request->tingkat)) {
                $query->where('konfigurasi_biaya.tingkat', $request->tingkat);
            }
        }

        if ($user->kode_unit != 'U06') {
            $query->where('pendaftaran.kode_unit', $user->kode_unit);
        }


        return $query;
    }



    public function getPembayaranpendidikan($no_pendaftaran = null, Request $request = null)
    {

        $ta_aktif = Tahunajaran::where('status', 1)->first();

        $kelas_siswa = Kelassiswa::join('kelas', 'kelas_siswa.kode_kelas', 'kelas.kode_kelas')
            ->select('kelas_siswa.id_siswa', 'nama_kelas')
            ->where('kelas.kode_ta', $ta_aktif->kode_ta);
        $query = Biayasiswa::query();
        $query->select(
            'siswa.*',
            'pendaftaran.no_pendaftaran',
            'pendaftaran.rfid_code',
            'tahun_ajaran',
            'villages.name as desa',
            'nama_unit',
            'districts.name as kecamatan',
            'provinces.name as provinsi',
            'regencies.name as kota',
            'logo',
            'konfigurasi_biaya.kode_unit',
            'pendaftaran.nis',
            'kelas_siswa.nama_kelas',
            'siswa_biaya.kode_biaya',
            'konfigurasi_biaya.tingkat',
            'siswa_biaya.status_naik_kelas',
            'konfigurasi_biaya.kode_ta',
            'pendaftaran.status_siswa',
            'pendaftaran.tanggal_keluar',
            'pendaftaran.alasan_keluar'
        );
        $query->join('pendaftaran', 'siswa_biaya.no_pendaftaran', 'pendaftaran.no_pendaftaran');
        $query->join('siswa', 'pendaftaran.id_siswa', 'siswa.id_siswa');
        $query->join('unit', 'pendaftaran.kode_unit', 'unit.kode_unit');
        $query->join('konfigurasi_biaya', 'siswa_biaya.kode_biaya', 'konfigurasi_biaya.kode_biaya');
        $query->where('konfigurasi_biaya.is_pindahan', 0);
        $query->leftjoin('asal_sekolah', 'pendaftaran.kode_asal_sekolah', 'asal_sekolah.kode_asal_sekolah');
        $query->join('konfigurasi_tahun_ajaran', 'konfigurasi_biaya.kode_ta', 'konfigurasi_tahun_ajaran.kode_ta');
        $query->leftJoin('villages', 'siswa.id_village', '=', 'villages.id');
        $query->leftJoin('districts', 'siswa.id_district', '=', 'districts.id');
        $query->leftJoin('provinces', 'siswa.id_province', '=', 'provinces.id');
        $query->leftJoin('regencies', 'siswa.id_regency', '=', 'regencies.id');
        $query->leftJoinSub($kelas_siswa, 'kelas_siswa', function ($join) {
            $join->on('kelas_siswa.id_siswa', '=', 'siswa.id_siswa');
        });
        $query->orderBy('siswa.nama_lengkap');
        if (!empty($no_pendaftaran)) {
            $query->where('siswa_biaya.no_pendaftaran', $no_pendaftaran);
        } else {
            if (!empty($request->nama_lengkap)) {
                $query->where('nama_lengkap', 'like', '%' . $request->nama_lengkap . '%');
            }

            if (!empty($request->kode_unit)) {
                $query->where('pendaftaran.kode_unit', $request->kode_unit);
            }

            if (!empty($request->kode_ta)) {
                $query->where('konfigurasi_biaya.kode_ta', $request->kode_ta);
            } else {
                $query->where('konfigurasi_biaya.kode_ta', $ta_aktif->kode_ta);
            }

            if (!empty($request->tingkat)) {
                $query->where('konfigurasi_biaya.tingkat', $request->tingkat);
            }
        }

        if (auth()->user()->kode_unit != 'U06') {
            $query->where('pendaftaran.kode_unit', auth()->user()->kode_unit);
        }

        return $query;
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa');
    }
}

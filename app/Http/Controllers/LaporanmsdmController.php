<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Kegiatanibadah;
use App\Models\Presensi;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanmsdmController extends Controller
{
    public function index()
    {
        $u = new Unit();
        $data['unit'] = $u->getUnit();
        $data['list_bulan'] = config('global.list_bulan');
        $data['start_year'] = config('global.start_year');
        return view('msdm.laporan.index', $data);
    }



    public function cetakpresensi(Request $request)
    {

        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $periode_dari = $tahun . '-' . $bulan . '-01';
        $periode_sampai = date('Y-m-t', strtotime($periode_dari));



        $presensi_detail  = Presensi::join('konfigurasi_jam_kerja', 'presensi.kode_jam_kerja', '=', 'konfigurasi_jam_kerja.kode_jam_kerja')
            ->leftJoin('presensi_izinabsen_approve', 'presensi.id', '=', 'presensi_izinabsen_approve.id_presensi')
            ->leftJoin('presensi_izinabsen', 'presensi_izinabsen_approve.kode_izin', '=', 'presensi_izinabsen.kode_izin')
            ->leftJoin('presensi_izinsakit_approve', 'presensi.id', '=', 'presensi_izinsakit_approve.id_presensi')
            ->leftJoin('presensi_izinsakit', 'presensi_izinsakit_approve.kode_izin_sakit', '=', 'presensi_izinsakit.kode_izin_sakit')

            ->select(
                'presensi.*',
                'nama_jam_kerja',
                'jam_masuk',
                'jam_pulang',
                'lintas_hari',
                'total_jam',
                'presensi_izinabsen.keterangan as keterangan_izin_absen',
                'presensi_izinsakit.keterangan as keterangan_izin_sakit'
            )
            ->whereBetween('presensi.tanggal', [$periode_dari, $periode_sampai]);



        $q_presensi = Karyawan::query();
        $q_presensi->select(
            'karyawan.npp',
            'nama_lengkap',
            'nama_jabatan',
            'karyawan.kode_unit',
            'nama_unit',
            'presensi.tanggal',
            'presensi.status',
            'presensi.kode_jam_kerja',
            'presensi.nama_jam_kerja',
            'presensi.jam_masuk',
            'presensi.jam_pulang',
            'presensi.jam_in',
            'presensi.jam_out',
            'presensi.lintas_hari',
            'presensi.keterangan_izin_absen',
            'presensi.keterangan_izin_sakit',
            'presensi.total_jam',
            'karyawan.status_karyawan'
        );
        $q_presensi->leftJoin('jabatan', 'karyawan.kode_jabatan', '=', 'jabatan.kode_jabatan');
        $q_presensi->leftJoin('unit', 'karyawan.kode_unit', '=', 'unit.kode_unit');
        $q_presensi->leftJoinSub($presensi_detail, 'presensi', function ($join) {
            $join->on('karyawan.npp', '=', 'presensi.npp');
        });



        if (!empty($request->kode_unit)) {
            $q_presensi->where('karyawan.kode_unit', $request->kode_unit);
        }

        if (!empty($request->npp)) {
            $q_presensi->where('karyawan.npp', $request->npp);
        }
        $q_presensi->orderBy('karyawan.nama_lengkap');
        $q_presensi->orderBy('presensi.tanggal', 'asc');
        $presensi = $q_presensi->get();


        $data['periode_dari'] = $periode_dari;
        $data['periode_sampai'] = $periode_sampai;
        $data['jmlhari'] = hitungJumlahHari($periode_dari, $periode_sampai) + 1;


        if (isset($_POST['exportButton'])) {
            header("Content-type: application/vnd-ms-excel");
            // Mendefinisikan nama file ekspor "-SahabatEkspor.xls"
            header("Content-Disposition: attachment; filename=Rekap Presensi $periode_dari - $periode_sampai.xls");
        }
        if (!empty($request->npp)) {
            $karyawan = Karyawan::join('jabatan', 'karyawan.kode_jabatan', '=', 'jabatan.kode_jabatan')
                ->join('unit', 'karyawan.kode_unit', '=', 'unit.kode_unit')
                ->where('karyawan.npp', $request->npp)
                ->first();
            $data['karyawan'] = $karyawan;
            $data['presensi'] = $presensi;
            return view('laporan.presensi_karyawan_cetak', $data);
        } else {
            $laporan_presensi = $presensi->groupBy('npp')->map(function ($rows) {
                $data = [
                    'npp' => $rows->first()->npp,
                    'nama_lengkap' => $rows->first()->nama_lengkap,
                    'nama_jabatan' => $rows->first()->nama_jabatan,
                    'kode_unit' => $rows->first()->kode_unit,
                    'nama_unit' => $rows->first()->nama_unit,
                    'status_karyawan' => $rows->first()->status_karyawan,
                ];

                foreach ($rows as $row) {
                    $data[$row->tanggal] = [
                        'status' => $row->status,
                        'kode_jam_kerja' => $row->kode_jam_kerja,
                        'nama_jam_kerja' => $row->nama_jam_kerja,
                        'jam_masuk' => $row->jam_masuk,
                        'jam_pulang' => $row->jam_pulang,
                        'jam_in' => $row->jam_in,
                        'jam_out' => $row->jam_out,
                        'istirahat' => $row->istirahat,
                        'jam_awal_istirahat' => $row->jam_awal_istirahat,
                        'jam_akhir_istirahat' => $row->jam_akhir_istirahat,
                        'lintas_hari' => $row->lintas_hari,
                        'keterangan_izin_absen' => $row->keterangan_izin_absen,
                        'keterangan_izin_sakit' => $row->keterangan_izin_sakit,
                        'keterangan_izin_cuti' => $row->keterangan_izin_cuti,
                        'total_jam' => $row->total_jam
                    ];
                }
                return $data;
            });
            $data['laporan_presensi'] = $laporan_presensi;

            // dd($data['laporan_presensi']);
            return view('msdm.laporan.presensi_cetak', $data);
        }
    }

    public function cetakchecklistibadah(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $checklistData = DB::table('karyawan as k')
            ->leftJoin('checklist_ibadah as ci', function ($join) use ($bulan, $tahun) {
                $join->on('k.npp', '=', 'ci.npp')
                    ->whereMonth('ci.tanggal', $bulan)
                    ->whereYear('ci.tanggal', $tahun);
            })
            ->leftJoin('checklist_ibadah_detail as cid', 'ci.kode_checklist_ibadah', '=', 'cid.kode_checklist_ibadah')
            ->leftJoin('kegiatan_ibadah as ki', 'cid.id_kegiatan_ibadah', '=', 'ki.id')
            ->select(
                'k.npp',
                'k.nama_lengkap',
                'ki.id as kegiatan_id',
                DB::raw('COUNT(cid.id_kegiatan_ibadah) as total')
            )
            ->when(!empty($request->kode_unit), function ($query) use ($request) {
                return $query->where('k.kode_unit', $request->kode_unit);
            })


            ->groupBy('k.npp', 'k.nama_lengkap', 'ki.id')
            ->get();

        $rekap = [];

        foreach ($checklistData as $row) {
            $rekap[$row->npp]['npp'] = $row->npp;
            $rekap[$row->npp]['nama_lengkap'] = $row->nama_lengkap;
            $rekap[$row->npp]['data'][$row->kegiatan_id] = $row->total;
        }

        $kegiatan = Kegiatanibadah::join('kategori_ibadah', 'kegiatan_ibadah.id_kategori_ibadah', '=', 'kategori_ibadah.id')->get();
        return view('msdm.laporan.checklistibadah_cetak', compact('rekap', 'kegiatan'));
    }
}

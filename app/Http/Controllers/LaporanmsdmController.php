<?php

namespace App\Http\Controllers;

use App\Models\Checklistibadah;
use App\Models\Detailchecklistibadah;
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
        // Tingkatkan memory limit untuk mengantisipasi rentang periode panjang
        ini_set('memory_limit', '1024M');

        // TENTUKAN PERIODE BERDASARKAN PILIHAN RADIO (presensi_tipe_periode)
        $tipe_periode = $request->presensi_tipe_periode ?? 'bulan';

        if ($tipe_periode === 'tanggal' && !empty($request->dari) && !empty($request->sampai)) {
            // MODE: RENTANG TANGGAL CUSTOM
            $periode_dari = date('Y-m-d', strtotime($request->dari));
            $periode_sampai = date('Y-m-d', strtotime($request->sampai));
            $bulan = date('m', strtotime($periode_dari));
            $tahun = date('Y', strtotime($periode_dari));
        } else {
            // MODE: BULANAN (DEFAULT)
            $bulan = $request->bulan ?? date('m');
            $tahun = $request->tahun ?? date('Y');
            $periode_dari = $tahun . '-' . str_pad($bulan, 2, '0', STR_PAD_LEFT) . '-01';
            $periode_sampai = date('Y-m-t', strtotime($periode_dari));
        }

        $data['periode_dari'] = $periode_dari;
        $data['periode_sampai'] = $periode_sampai;
        $data['jmlhari'] = hitungJumlahHari($periode_dari, $periode_sampai) + 1;

        $is_export = isset($_POST['exportButton']) || $request->has('exportButton');
        $data['is_export'] = $is_export;

        if ($is_export) {
            header("Content-type: application/vnd-ms-excel");
            if (!empty($request->npp)) {
                $clean_npp = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $request->npp);
                header("Content-Disposition: attachment; filename=Presensi_Karyawan_{$clean_npp}_{$periode_dari}_{$periode_sampai}.xls");
            } else {
                header("Content-Disposition: attachment; filename=Rekap_Presensi_{$periode_dari}_{$periode_sampai}.xls");
            }
        }

        // =====================================================
        // JIKA NPP DIPILIH: LAPORAN PERORANGAN (RINGAN & CEPAT)
        // =====================================================
        if (!empty($request->npp)) {
            $karyawan = Karyawan::leftJoin('jabatan', 'karyawan.kode_jabatan', '=', 'jabatan.kode_jabatan')
                ->leftJoin('unit', 'karyawan.kode_unit', '=', 'unit.kode_unit')
                ->where('karyawan.npp', $request->npp)
                ->select('karyawan.*', 'jabatan.nama_jabatan', 'unit.nama_unit')
                ->first();

            $presensi_detail = Presensi::join('konfigurasi_jam_kerja', 'presensi.kode_jam_kerja', '=', 'konfigurasi_jam_kerja.kode_jam_kerja')
                ->leftJoin('presensi_izinabsen_approve', 'presensi.id', '=', 'presensi_izinabsen_approve.id_presensi')
                ->leftJoin('presensi_izinabsen', 'presensi_izinabsen_approve.kode_izin', '=', 'presensi_izinabsen.kode_izin')
                ->leftJoin('presensi_izinsakit_approve', 'presensi.id', '=', 'presensi_izinsakit_approve.id_presensi')
                ->leftJoin('presensi_izinsakit', 'presensi_izinsakit_approve.kode_izin_sakit', '=', 'presensi_izinsakit.kode_izin_sakit')
                ->select(
                    'presensi.*',
                    'nama_jam_kerja',
                    'konfigurasi_jam_kerja.jam_masuk',
                    'konfigurasi_jam_kerja.jam_pulang',
                    'lintas_hari',
                    'total_jam',
                    'presensi_izinabsen.keterangan as keterangan_izin_absen',
                    'presensi_izinsakit.keterangan as keterangan_izin_sakit'
                )
                ->where('presensi.npp', $request->npp)
                ->whereBetween('presensi.tanggal', [$periode_dari, $periode_sampai])
                ->orderBy('presensi.tanggal', 'asc')
                ->get();

            $presensi_by_date = [];
            $stats = [
                'hadir' => 0,
                'terlambat' => 0,
                'sakit' => 0,
                'izin' => 0,
                'cuti' => 0,
                'alpa' => 0,
            ];

            foreach ($presensi_detail as $p) {
                $presensi_by_date[$p->tanggal] = [
                    'status' => $p->status,
                    'kode_jam_kerja' => $p->kode_jam_kerja,
                    'nama_jam_kerja' => $p->nama_jam_kerja,
                    'jam_masuk' => $p->jam_masuk,
                    'jam_pulang' => $p->jam_pulang,
                    'jam_in' => $p->jam_in,
                    'jam_out' => $p->jam_out,
                    'keterangan_izin_absen' => $p->keterangan_izin_absen,
                    'keterangan_izin_sakit' => $p->keterangan_izin_sakit,
                ];

                if ($p->status == 'h') {
                    $stats['hadir']++;
                    $jam_masuk_ref = $p->tanggal . ' ' . $p->jam_masuk;
                    $terlambat = hitungjamterlambat($p->jam_in, $jam_masuk_ref);
                    if ($terlambat != null && isset($terlambat['menitterlambat']) && $terlambat['menitterlambat'] > 0) {
                        $stats['terlambat']++;
                    }
                } elseif ($p->status == 'i') {
                    $stats['izin']++;
                } elseif ($p->status == 's') {
                    $stats['sakit']++;
                } elseif ($p->status == 'c') {
                    $stats['cuti']++;
                } elseif ($p->status == 'a') {
                    $stats['alpa']++;
                }
            }

            $data['karyawan'] = $karyawan;
            $data['presensi_by_date'] = $presensi_by_date;
            $data['stats'] = $stats;
            $data['bulan'] = $bulan;
            $data['tahun'] = $tahun;

            return view('msdm.laporan.presensi_karyawan_cetak', $data);
        }

        // ============================================================
        // FORMAT REKAPITULASI SEMUA KARYAWAN (MATRIKS HORIZONTAL)
        // Batasi max 62 hari agar tidak memory exhaustion
        // ============================================================
        $jumlah_hari = (strtotime($periode_sampai) - strtotime($periode_dari)) / 86400 + 1;
        if ($jumlah_hari > 62) {
            return redirect()->back()->with('warning', 'Laporan matriks semua karyawan maksimal 2 bulan (62 hari). Untuk rentang lebih panjang, silakan pilih karyawan tertentu.');
        }

        $presensi_detail = Presensi::join('konfigurasi_jam_kerja', 'presensi.kode_jam_kerja', '=', 'konfigurasi_jam_kerja.kode_jam_kerja')
            ->leftJoin('presensi_izinabsen_approve', 'presensi.id', '=', 'presensi_izinabsen_approve.id_presensi')
            ->leftJoin('presensi_izinabsen', 'presensi_izinabsen_approve.kode_izin', '=', 'presensi_izinabsen.kode_izin')
            ->leftJoin('presensi_izinsakit_approve', 'presensi.id', '=', 'presensi_izinsakit_approve.id_presensi')
            ->leftJoin('presensi_izinsakit', 'presensi_izinsakit_approve.kode_izin_sakit', '=', 'presensi_izinsakit.kode_izin_sakit')
            ->select(
                'presensi.*',
                'nama_jam_kerja',
                'konfigurasi_jam_kerja.jam_masuk',
                'konfigurasi_jam_kerja.jam_pulang',
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
        $q_presensi->orderBy('karyawan.nama_lengkap');
        $q_presensi->orderBy('presensi.tanggal', 'asc');
        $presensi = $q_presensi->get();

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

        return view('msdm.laporan.presensi_cetak', $data);
    }

    public function cetakchecklistibadah(Request $request)
    {
        if (!empty($request->dari) && !empty($request->sampai)) {
            $periode_dari = $request->dari;
            $periode_sampai = $request->sampai;
            $bulan = date('m', strtotime($periode_dari));
            $tahun = date('Y', strtotime($periode_dari));
        } else {
            $bulan = $request->bulan ?? date('m');
            $tahun = $request->tahun ?? date('Y');
            $periode_dari = $tahun . '-' . str_pad($bulan, 2, '0', STR_PAD_LEFT) . '-01';
            $periode_sampai = date('Y-m-t', strtotime($periode_dari));
        }

        $kegiatan_ibadah =  Kegiatanibadah::orderBy('id')->get();

        $selectKegiatanibadah = [];
        $selectFieldKegiatanibadah   = [];
        foreach ($kegiatan_ibadah as $k) {
            $selectKegiatanibadah[] = DB::raw('SUM(IF(id_kegiatan_ibadah = ' . $k->id . ', 1, 0)) as jml_kegiatan_' . $k->id);
            $selectFieldKegiatanibadah[] = 'jml_kegiatan_' . $k->id;
        }

        $checklistData = Detailchecklistibadah::join('checklist_ibadah', 'checklist_ibadah_detail.kode_checklist_ibadah', '=', 'checklist_ibadah.kode_checklist_ibadah')
            ->select(
                'npp',
                ...$selectKegiatanibadah
            )
            ->whereBetween('tanggal', [$periode_dari, $periode_sampai])
            ->groupBy('npp');


        $rekap = Karyawan::query();
        $rekap->select(
            'karyawan.npp',
            'karyawan.nama_lengkap',
            'jabatan.nama_jabatan',
            'unit.nama_unit',
            ...$selectFieldKegiatanibadah
        );
        $rekap->leftJoin('jabatan', 'karyawan.kode_jabatan', '=', 'jabatan.kode_jabatan');
        $rekap->leftJoin('unit', 'karyawan.kode_unit', '=', 'unit.kode_unit');
        $rekap->leftJoinSub($checklistData, 'checklist_ibadah_detail', function ($join) {
            $join->on('karyawan.npp', '=', 'checklist_ibadah_detail.npp');
        });
        if (!empty($request->kode_unit)) {
            $rekap->where('karyawan.kode_unit', $request->kode_unit);
        }

        if (!empty($request->npp)) {
            $rekap->where('karyawan.npp', $request->npp);
        }

        $rekap->orderBy('karyawan.nama_lengkap');
        $rekapkegiatanibadah = $rekap->get();

        $data['periode_dari'] = $periode_dari;
        $data['periode_sampai'] = $periode_sampai;
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        $data['kegiatan_ibadah'] = $kegiatan_ibadah;
        $data['rekapkegiatanibadah'] = $rekapkegiatanibadah;
        return view('msdm.laporan.checklistibadah_cetak', $data);
    }
}

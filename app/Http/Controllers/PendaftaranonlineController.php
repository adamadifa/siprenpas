<?php

namespace App\Http\Controllers;

use App\Models\Biaya;
use App\Models\Biayasiswa;
use App\Models\Pembayaranpendaftaranonline;
use App\Models\Pendaftaran;
use App\Models\Pendaftaranonline;
use App\Models\Pendaftaranonlineregister;
use App\Models\Siswa;
use App\Models\Tahunajaran;
use App\Models\Tahunajaranppdb;
use App\Models\Unit;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Crypt;
use Barryvdh\DomPDF\Facades\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\Mailer\Event\MessageEvent;


class PendaftaranonlineController extends Controller
{
    public function index(Request $request)
    {


        $tahunajaran = Tahunajaranppdb::where('status', 1)->first();
        $kode_ta = $tahunajaran->kode_ta;

        $qpendaftaran = Pendaftaranonline::query();
        $qpendaftaran->select(
            'pendaftaran_online.*',
            'pendaftaran_online_bayar.id as id_bayar',
            'pendaftaran_online_bayar.status as status_bayar',
            'unit.nama_unit as nama_unit',
            'konfigurasi_tahunajaran_ppdb.tahun_ajaran as tahun_ajaran',
            'pendaftaran_online_register.no_pendaftaran'
        );
        $qpendaftaran->join('unit', 'unit.kode_unit', 'pendaftaran_online.kode_unit');
        $qpendaftaran->join('konfigurasi_tahunajaran_ppdb', 'konfigurasi_tahunajaran_ppdb.kode_ta', 'pendaftaran_online.kode_ta');
        $qpendaftaran->leftJoin('pendaftaran_online_bayar', 'pendaftaran_online_bayar.no_register', 'pendaftaran_online.no_register');
        $qpendaftaran->leftJoin('pendaftaran_online_register', 'pendaftaran_online.no_register', '=', 'pendaftaran_online_register.no_register');
        $qpendaftaran->orderBy('no_register', 'desc');

        if (!empty($request->kode_ta)) {
            $qpendaftaran->where('pendaftaran_online.kode_ta', $request->kode_ta);
        } else {
            $qpendaftaran->where('pendaftaran_online.kode_ta', $kode_ta);
        }

        if (!empty($request->kode_unit)) {
            $qpendaftaran->where('pendaftaran_online.kode_unit', $request->kode_unit);
        }

        if (!empty($request->nama_lengkap)) {
            $qpendaftaran->where('pendaftaran_online.nama_lengkap', 'like', '%' . $request->nama_lengkap . '%');
        }

        if (auth()->user()->kode_unit != 'U06') {
            $qpendaftaran->where('pendaftaran_online.kode_unit', auth()->user()->kode_unit);
        }

        $pendaftaran = $qpendaftaran->get();
        $data['pendaftaran'] = $pendaftaran;
        $data['unit'] = Unit::orderBy('kode_unit')->get();
        $data['jenis_kelamin'] = config('global.jenis_kelamin');
        $data['tahunajaran'] = Tahunajaranppdb::orderBy('kode_ta')->get();
        $data['kode_ta'] = $kode_ta;

        // Rekap jumlah siswa per unit (termasuk unit yang kosong)
        $rekap_unit = DB::table('unit')
            ->leftJoin('pendaftaran_online', function ($join) use ($kode_ta, $request) {
                $ta_aktif = !empty($request->kode_ta) ? $request->kode_ta : $kode_ta;
                $join->on('unit.kode_unit', '=', 'pendaftaran_online.kode_unit')
                    ->where('pendaftaran_online.kode_ta', '=', $ta_aktif);
            })
            ->select('unit.nama_unit', 'unit.kode_unit', DB::raw('count(pendaftaran_online.no_register) as jumlah'))
            ->whereNotIn('unit.kode_unit', ['U00', 'U06'])
            ->groupBy('unit.nama_unit', 'unit.kode_unit')
            ->orderBy('unit.kode_unit')
            ->get();
        $data['rekap_unit'] = $rekap_unit;

        return view('pendaftaranonline.index', $data);
    }

    public function show($no_register)
    {
        $no_register = Crypt::decrypt($no_register);
        $data['pendaftaran'] = Pendaftaranonline::where('pendaftaran_online.no_register', $no_register)
            ->join('unit', 'unit.kode_unit', 'pendaftaran_online.kode_unit')
            ->leftJoin('provinces', 'provinces.id', 'pendaftaran_online.id_province')
            ->leftJoin('regencies', 'regencies.id', 'pendaftaran_online.id_regency')
            ->leftJoin('districts', 'districts.id', 'pendaftaran_online.id_district')
            ->leftJoin('villages', 'villages.id', 'pendaftaran_online.id_village')
            ->join('konfigurasi_tahunajaran_ppdb', 'konfigurasi_tahunajaran_ppdb.kode_ta', 'pendaftaran_online.kode_ta')
            ->leftJoin('pendaftaran_online_bayar', 'pendaftaran_online_bayar.no_register', 'pendaftaran_online.no_register')
            ->leftJoin('pendaftaran_online_register', 'pendaftaran_online.no_register', '=', 'pendaftaran_online_register.no_register')
            ->select(
                'pendaftaran_online.*',
                'nama_unit',
                'pendaftaran_online_bayar.id as id_bayar',
                'no_pendaftaran',
                'tahun_ajaran',
                'provinces.name as provinsi',
                'regencies.name as kabupaten',
                'districts.name as kecamatan',
                'villages.name as desa'
            )
            ->first();
        //dd($data['pendaftaran']);
        //dd($data['pendaftaran']);
        $data['pembayaran'] = Pembayaranpendaftaranonline::where('no_register', $no_register)->first();
        return view('pendaftaranonline.show', $data);
    }

    public function cetak($no_register)
    {
        $no_register = Crypt::decrypt($no_register);
        $pendaftaran = Pendaftaranonline::where('no_register', $no_register)
            ->select(
                'pendaftaran_online.*',
                'nama_unit',
                'tahun_ajaran',
                'provinces.name as provinsi',
                'regencies.name as kabupaten',
                'districts.name as kecamatan',
                'villages.name as desa'
            )
            ->join('unit', 'unit.kode_unit', 'pendaftaran_online.kode_unit')
            ->leftJoin('provinces', 'provinces.id', 'pendaftaran_online.id_province')
            ->leftJoin('regencies', 'regencies.id', 'pendaftaran_online.id_regency')
            ->leftJoin('districts', 'districts.id', 'pendaftaran_online.id_district')
            ->leftJoin('villages', 'villages.id', 'pendaftaran_online.id_village')
            ->join('konfigurasi_tahunajaran_pddb', 'konfigurasi_tahunajaran_pddb.kode_ta', 'pendaftaran_online.kode_ta')
            ->first();
        $pdf = FacadePdf::loadView('pendaftaranonline.cetak', compact('pendaftaran'));
        return $pdf->stream('formulir-pendaftaran-online.pdf');
    }


    public function konfirmasiPembayaran(Request $request, $no_register)
    {
        $no_register = Crypt::decrypt($no_register);
        $pendaftaran = Pendaftaranonline::where('no_register', $no_register)->first();

        $tahun_ajaran = Tahunajaranppdb::where('status', 1)->first();
        $ta_nis = substr($tahun_ajaran->tahun_ajaran, 2, 2) . substr($tahun_ajaran->tahun_ajaran, 7, 2);
        $ta_pendaftaran = substr($tahun_ajaran->tahun_ajaran, 2, 2);
        $lastpendaftaran = Pendaftaran::select('no_pendaftaran', 'nis')
            ->where('kode_ta', $tahun_ajaran->kode_ta)
            ->where('kode_unit', $request->kode_unit)
            ->orderBy('no_pendaftaran', 'desc')
            ->first();
        $last_no_pendaftaran = $lastpendaftaran != null ? $lastpendaftaran->no_pendaftaran : '';
        $last_nis = $lastpendaftaran != null ? $lastpendaftaran->nis : '';
        $format = "REG" . $pendaftaran->kode_unit . $ta_pendaftaran;
        $format_nis = $ta_nis;
        $no_pendaftaran = buatkode($last_no_pendaftaran, $format, 3);
        $nis = buatkode($last_nis, $format_nis, 3);

        $biaya = Biaya::where('kode_unit', $pendaftaran->kode_unit)
            ->where('kode_ta', $tahun_ajaran->kode_ta)
            ->where('tingkat', 1)
            ->first();

        if ($biaya == null) {
            return Redirect::back()->with(messageError('Biaya Belum ditetapkan'));
        }
        DB::beginTransaction();

        try {
            $tahun_masuk = config('global.tahun_ppdb');
            $last_siswa = Siswa::orderby('id_siswa', 'desc')->where('tahun_masuk', $tahun_masuk)->first();
            $last_id_siswa = $last_siswa != NULL ? $last_siswa->id_siswa : "";
            $id_siswa = buatkode($last_id_siswa, $tahun_masuk, 3);

            Siswa::create([
                'id_siswa' => $id_siswa,
                'nisn' => $pendaftaran->nisn,
                'nama_lengkap' => $pendaftaran->nama_lengkap,
                'jenis_kelamin' => $pendaftaran->jenis_kelamin,
                'tempat_lahir' => $pendaftaran->tempat_lahir,
                'tanggal_lahir' => $pendaftaran->tanggal_lahir,
                'anak_ke' => $pendaftaran->anak_ke,
                'jumlah_saudara' => $pendaftaran->jumlah_saudara,
                'alamat' => $pendaftaran->alamat,
                'id_province' => $pendaftaran->id_province,
                'id_regency' => $pendaftaran->id_regency,
                'id_district' => $pendaftaran->id_district,
                'id_village' => $pendaftaran->id_village,
                'kode_pos' => $pendaftaran->kode_pos,
                'no_kk' => $pendaftaran->no_kk,
                'nik_ayah' => $pendaftaran->nik_ayah,
                'nama_ayah' => $pendaftaran->nama_ayah,
                'pendidikan_ayah' => $pendaftaran->pendidikan_ayah,
                'pekerjaan_ayah' => $pendaftaran->pekerjaan_ayah,
                'nik_ibu' => $pendaftaran->nik_ibu,
                'nama_ibu' => $pendaftaran->nama_ibu,
                'pendidikan_ibu' => $pendaftaran->pendidikan_ibu,
                'pekerjaan_ibu' => $pendaftaran->pekerjaan_ibu,
                'no_hp_orang_tua' => $pendaftaran->no_hp_orang_tua,
                'tahun_masuk' => $tahun_masuk,
            ]);

            Pendaftaran::create([
                'no_pendaftaran' => $no_pendaftaran,
                'tanggal_pendaftaran' => $pendaftaran->tanggal_register,
                'nis' => $nis,
                'id_siswa' => $id_siswa,
                'kode_unit' => $pendaftaran->kode_unit,
                'kode_ta' => $tahun_ajaran->kode_ta,
                'id_user' => Auth::user()->id,
            ]);

            //Simpan Data Biaya
            Biayasiswa::create([
                'no_pendaftaran' => $no_pendaftaran,
                'kode_biaya' => $biaya->kode_biaya,
            ]);

            Pendaftaranonlineregister::create([
                'no_register' => $pendaftaran->no_register,
                'no_pendaftaran' => $no_pendaftaran
            ]);

            DB::commit();
            return Redirect::back()->with(messageSuccess('Data Berhasil Di Simpan'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return Redirect::back()->with(messageError($th->getMessage()));
        }
    }

    public function destroy($no_register)
    {
        $no_register = Crypt::decrypt($no_register);
        try {
            Pendaftaranonline::where('no_register', $no_register)->delete();
            return Redirect::back()->with(messageSuccess('Data Berhasil Dihapus'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError('Data Gagal Di Hapus', $e->getMessage()));
        }
    }


    public function cancel($no_register)
    {
        $no_register = Crypt::decrypt($no_register);
        DB::beginTransaction();
        try {
            $pendaftaran_register = Pendaftaranonlineregister::where('no_register', $no_register)->first();
            $pendaftaran = Pendaftaran::where('no_pendaftaran', $pendaftaran_register->no_pendaftaran);
            $datapendaftaran = $pendaftaran->first();
            $pendaftaran->delete();
            Siswa::where('id_siswa', $datapendaftaran->id_siswa)->delete();
            DB::commit();
            return Redirect::back()->with(messageSuccess('Data Berhasil Di Batalkan'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError('Data Berhasil Gagal Batalkan ' . $e->getMessage()));
        }
    }
}

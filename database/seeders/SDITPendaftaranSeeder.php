<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Siswa;
use App\Models\Pendaftaran;
use App\Models\Biayasiswa;
use App\Models\Biaya;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class SDITPendaftaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kode_unit = 'U03'; // SDIT
        $kode_ta = 'TA2627'; // Tahun Ajaran 2026/2027
        $tahun_ajaran_str = '2026/2027';
        $ta_ppdb = explode("/", $tahun_ajaran_str);
        $tahun_masuk = $ta_ppdb[0]; // '2026'
        
        $ta_nis = substr($tahun_ajaran_str, 2, 2) . substr($tahun_ajaran_str, 7, 2); // '2627'
        $ta_pendaftaran = substr($tahun_ajaran_str, 2, 2); // '26'
        
        // Ambil konfigurasi biaya untuk unit SDIT TA 2026/2027 tingkat 1
        $biaya = Biaya::where('kode_unit', $kode_unit)
            ->where('kode_ta', $kode_ta)
            ->where('tingkat', 1)
            ->where('is_pindahan', 0)
            ->first();
            
        if (!$biaya) {
            $this->command->error("Konfigurasi biaya untuk SDIT TA 2026/2027 Tingkat 1 belum ditetapkan!");
            return;
        }

        // Ambil ID User untuk pencatat pendaftaran (default user pertama)
        $user = User::first();
        $id_user = $user ? $user->id : 1;

        $records = [
            [
                'nama_lengkap' => 'KANAKA ALFARIZQI',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'TASIKMALAYA',
                'tanggal_lahir' => '2018-09-27',
                'alamat' => 'Gunung Asih II RT/RW 028/008 Desa Margaluyu Kec. Manonjaya',
            ],
            [
                'nama_lengkap' => 'AL FADHL ABDURRAHMAN',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'TASIKMALAYA',
                'tanggal_lahir' => '2019-10-23',
                'alamat' => 'Dusun Cihurip RT/RW 016/006 Desa Sukamanah Kec. Cipedes',
            ],
            [
                'nama_lengkap' => 'MUHAMMAD RAFAN ABQARY',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'TASIKMALAYA',
                'tanggal_lahir' => '2020-01-03',
                'alamat' => 'Dusun Cisaray RT/RW 017/005 Desa Margaluyu Kec. Manonjaya',
            ],
            [
                'nama_lengkap' => 'ZAYNA ZAKHYRA PUTRI MUNGGARAN',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'TASIKMALAYA',
                'tanggal_lahir' => '2019-10-28',
                'alamat' => 'Perum Pratama Regency H.15 RT/RW 059/009 Desa Margaluyu',
            ],
            [
                'nama_lengkap' => 'ANDHIKA AHSAN GUNAWAN',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'CIAMIS',
                'tanggal_lahir' => '2019-05-17',
                'alamat' => 'Dusun Pengkol RT/RW 020/007 Desa Sindangkasih Kec. Sindangkasih',
            ],
            [
                'nama_lengkap' => 'AFNAN MALIQ RAFIDANSYAH',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'CIAMIS',
                'tanggal_lahir' => '2019-08-09',
                'alamat' => 'Dusun Pasar Sabtu No. 189 RT/RW 001/004 Desa Sindangkasih',
            ],
            [
                'nama_lengkap' => 'MUHAMMAD DHAFIN AL-FARIZI',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'CIAMIS',
                'tanggal_lahir' => '2019-03-26',
                'alamat' => 'Dusun Cihideung I RT/RW 005/001 Desa Budiasih Kec. Sindangkasih',
            ],
            [
                'nama_lengkap' => 'QISTINA AYSILA',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'CIAMIS',
                'tanggal_lahir' => '2019-03-08',
                'alamat' => 'Dusun Ancol II RT/RW 011/004 Desa Sindangkasih Kec. Sindangkasih',
            ],
            [
                'nama_lengkap' => 'AULIYA QONITA MUMTAZAH',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'CIAMIS',
                'tanggal_lahir' => '2018-11-13',
                'alamat' => 'Perum Karya Alam Regency Blok C No. 6 Desa Margaluyu',
            ],
            [
                'nama_lengkap' => 'MAHREEN NAFISA ALMAHYRA',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'TASIKMALAYA',
                'tanggal_lahir' => '2020-02-02',
                'alamat' => 'Perum Margabakti Duta Pratama Blok I-19 Kelurahan Margabakti',
            ],
            [
                'nama_lengkap' => 'MUHAMMAD HAFIZ ALFARIZI',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'CIAMIS',
                'tanggal_lahir' => '2019-12-14',
                'alamat' => 'Perumahan Taman Aster Blok C-1 RT/RW 019/006 Desa Margaluyu',
            ],
            [
                'nama_lengkap' => 'MUHAMMAD AL FATIH',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'CIAMIS',
                'tanggal_lahir' => '2019-12-19',
                'alamat' => 'Dusun Gunung Asih I RT/RW 023/007 Desa Margaluyu',
            ],
            [
                'nama_lengkap' => 'ZIVANA ADIBA',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'CIAMIS',
                'tanggal_lahir' => '2019-12-01',
                'alamat' => 'Dusun Desa Sukasetia RT/RW 005/002 Kec. Cihaurbeuti',
            ],
            [
                'nama_lengkap' => 'MUHAMMAD SYAAMIL AL FATIH',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'TASIKMALAYA',
                'tanggal_lahir' => '2019-09-06',
                'alamat' => 'Jl. Letnan Dadi Suryatman Gunung Tanjung RT/RW 002/001',
            ],
            [
                'nama_lengkap' => 'KIRAN HAFIZAH SOLIHIN',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'CIAMIS',
                'tanggal_lahir' => '2019-10-18',
                'alamat' => 'Dusun Cihideung I RT/RW 019/003 Desa Budiasih',
            ],
            [
                'nama_lengkap' => 'KHADIJAH INSYIRAA SHIDQIA',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'BANJAR',
                'tanggal_lahir' => '2019-04-18',
                'alamat' => "Perumahan D'Village Residence Nagarasari Blok E",
            ],
            [
                'nama_lengkap' => 'BAIQ ARSYILA MEIDINA',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'TASIKMALAYA',
                'tanggal_lahir' => '2020-05-01',
                'alamat' => 'Dusun Pasar Salasa RT/RW 001/002 Desa Cikoneng',
            ],
            [
                'nama_lengkap' => 'RASHIQA ALMASSYFA HIDAYAT',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'TASIKMALAYA',
                'tanggal_lahir' => '2019-10-31',
                'alamat' => 'Dusun Cihideung I RT/RW 021/003 Desa Budiasih',
            ],
            [
                'nama_lengkap' => 'GAZALA TSABITA SIDIK',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'TASIKMALAYA',
                'tanggal_lahir' => '2020-04-17',
                'alamat' => 'Perumahan The Nirmala Garden Blok D60 RT/RW 046/012',
            ],
            [
                'nama_lengkap' => 'DAFFA SAIF ARFAN',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'CIAMIS',
                'tanggal_lahir' => '2019-05-30',
                'alamat' => 'Dusun Kidul RT/RW 002/001 Desa Gunungcupu Kec. Sindangkasih',
            ],
            [
                'nama_lengkap' => 'MUHAMMAD KENAN ALFAREZI HERMAN',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'CIAMIS',
                'tanggal_lahir' => '2019-10-31',
                'alamat' => 'Perum The Nirmala Garden Blok D42 RT/RW 046/012',
            ],
            [
                'nama_lengkap' => 'HA I MUHAMMAD ALBAIHAQI',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'BANDUNG',
                'tanggal_lahir' => '2020-04-14',
                'alamat' => 'Perum Tunas Griya Asri No. B1 Kel. Sukamanah Kec. Cipedes',
            ],
            [
                'nama_lengkap' => 'AFIYAH KAMILA RAHMAN',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'CIAMIS',
                'tanggal_lahir' => '2020-01-10',
                'alamat' => 'Perum Rancamaya Blok A No. 56 RT/RW 020/008 Desa Margaluyu',
            ],
            [
                'nama_lengkap' => 'ARSAL MALAKIAN RASYID',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'TASIKMALAYA',
                'tanggal_lahir' => '2020-03-18',
                'alamat' => 'Dusun Burujul RT/RW 025/010 Desa Sindangkasih',
            ],
            [
                'nama_lengkap' => 'MUHAMMAD HASBY AL AYUBBI',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'CIAMIS',
                'tanggal_lahir' => '2019-04-28',
                'alamat' => 'Dusun Sukahurip RT/RW 007/003 Desa Sukaresik',
            ],
            [
                'nama_lengkap' => 'ELZIO RHAFA ALGIRYA',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'TASIKMALAYA',
                'tanggal_lahir' => '2019-04-04',
                'alamat' => 'Perumahan Bukit Medina Blok D2 Kec. Cikoneng Kab. Ciamis',
            ],
            [
                'nama_lengkap' => 'NUR AINI IZZATI ANNASYA',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'SINGKAWANG',
                'tanggal_lahir' => '2019-06-19',
                'alamat' => 'Jl. Raya Cikoneng No. 117 RT/RW 005/002 Desa Margaluyu',
            ],
            [
                'nama_lengkap' => 'MUHAMMAD ALGHANI KENZO',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'TASIKMALAYA',
                'tanggal_lahir' => '2019-09-02',
                'alamat' => 'Dusun Desa Cijulang RT/RW 003/001 Kec. Cihaurbeuti',
            ],
            [
                'nama_lengkap' => 'ARSYA FIRAZ ASSHAUQI',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'KUNINGAN',
                'tanggal_lahir' => '2019-03-08',
                'alamat' => 'Perum Melati Mas Residence 2 Blok J No. 21 Kel. Sukamanah',
            ],
            [
                'nama_lengkap' => 'HANNA FATHIYYA AZ ZAHRA',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'CIAMIS',
                'tanggal_lahir' => '2019-06-21',
                'alamat' => 'Dusun Kadupugur RT/RW 035/017 Blok Popojok Desa Margaluyu',
            ],
            [
                'nama_lengkap' => 'AMARA QAILA MAHREEN',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'TASIKMALAYA',
                'tanggal_lahir' => '2020-04-30',
                'alamat' => 'Pelang RT/RW 005/026 Kel. Sukamanah Kec. Cipedes',
            ],
            [
                'nama_lengkap' => 'SHANUM ASHDYA MECCA FIRDAUS',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'CIAMIS',
                'tanggal_lahir' => '2019-06-19',
                'alamat' => 'Dusun Kadupugur RT/RW 035/017 Blok Popojok Desa Margaluyu',
            ],
            [
                'nama_lengkap' => 'BYAKTA WIKAN NATANGGUAN',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'BANJAR',
                'tanggal_lahir' => '2019-08-13',
                'alamat' => 'Dusun Burujul RT/RW 030/011 Desa Sukasenang Indah',
            ],
            [
                'nama_lengkap' => 'HAFIZA QONITA SALIHA',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'TASIKMALAYA',
                'tanggal_lahir' => '2019-11-13',
                'alamat' => 'Bantarsari Kec. Bungursari Kota Tasikmalaya',
            ],
            [
                'nama_lengkap' => 'ADZRIEL SYARIF GIBRAN',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'CIAMIS',
                'tanggal_lahir' => '2019-07-16',
                'alamat' => 'Dusun Kidul RT/RW 002/001 Desa Gunungcupu Kec. Sindangkasih',
            ],
            [
                'nama_lengkap' => 'SATRIA ALFARIZI',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => null,
                'tanggal_lahir' => null,
                'alamat' => null,
            ],
            [
                'nama_lengkap' => 'ZAIDAN RIZKI SUTRISNO',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => null,
                'tanggal_lahir' => null,
                'alamat' => null,
            ],
        ];

        $count = 0;
        foreach ($records as $data) {
            // Cek apakah siswa sudah ada untuk menghindari duplikasi data
            $existingSiswa = Siswa::where('nama_lengkap', $data['nama_lengkap'])
                ->where('tanggal_lahir', $data['tanggal_lahir'])
                ->first();

            if ($existingSiswa) {
                continue;
            }

            // Dapatkan ID Siswa berikutnya
            $last_siswa = Siswa::where('tahun_masuk', $tahun_masuk)
                ->orderBy('id_siswa', 'desc')
                ->first();
            $last_id_siswa = $last_siswa ? $last_siswa->id_siswa : "";
            $id_siswa = buatkode($last_id_siswa, $tahun_masuk, 3);

            // Dapatkan No Pendaftaran & NIS berikutnya
            $lastpendaftaran = Pendaftaran::where('kode_ta', $kode_ta)
                ->where('kode_unit', $kode_unit)
                ->orderBy('no_pendaftaran', 'desc')
                ->first();
            
            $last_no_pendaftaran = $lastpendaftaran ? $lastpendaftaran->no_pendaftaran : '';
            $last_nis = $lastpendaftaran ? $lastpendaftaran->nis : '';
            
            $format = "REG" . $kode_unit . $ta_pendaftaran;
            $format_nis = $ta_nis;
            
            $no_pendaftaran = buatkode($last_no_pendaftaran, $format, 3);
            $nis = buatkode($last_nis, $format_nis, 3);

            DB::transaction(function () use ($id_siswa, $no_pendaftaran, $nis, $data, $tahun_masuk, $kode_unit, $kode_ta, $biaya, $id_user) {
                // 1. Simpan data Siswa
                Siswa::create([
                    'id_siswa' => $id_siswa,
                    'nama_lengkap' => $data['nama_lengkap'],
                    'jenis_kelamin' => $data['jenis_kelamin'],
                    'tempat_lahir' => $data['tempat_lahir'] ?? '',
                    'tanggal_lahir' => $data['tanggal_lahir'] ?? null,
                    'alamat' => $data['alamat'] ?? '',
                    'tahun_masuk' => $tahun_masuk,
                ]);

                // 2. Simpan data Pendaftaran
                Pendaftaran::create([
                    'no_pendaftaran' => $no_pendaftaran,
                    'tanggal_pendaftaran' => date('Y-m-d'),
                    'nis' => $nis,
                    'id_siswa' => $id_siswa,
                    'kode_unit' => $kode_unit,
                    'kode_ta' => $kode_ta,
                    'id_user' => $id_user,
                    'jenis_pendaftaran' => 'Baru',
                    'tingkat_masuk' => 1,
                ]);

                // 3. Simpan data Biayasiswa (Wajib)
                Biayasiswa::create([
                    'no_pendaftaran' => $no_pendaftaran,
                    'kode_biaya' => $biaya->kode_biaya,
                ]);
            });

            $count++;
        }

        $this->command->info("Berhasil membuat seeder untuk {$count} data pendaftaran SDIT 2026/2027.");
    }
}

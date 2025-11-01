<?php

use App\Models\Produk;
use App\Models\Tutuplaporan;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;

function buatkode($nomor_terakhir, $kunci, $jumlah_karakter = 0)
{
    /* mencari nomor baru dengan memecah nomor terakhir dan menambahkan 1
    string nomor baru dibawah ini harus dengan format XXX000000
    untuk penggunaan dalam format lain anda harus menyesuaikan sendiri */
    $nomor_baru = intval(substr($nomor_terakhir, strlen($kunci))) + 1;
    //    menambahkan nol didepan nomor baru sesuai panjang jumlah karakter
    $nomor_baru_plus_nol = str_pad($nomor_baru, $jumlah_karakter, "0", STR_PAD_LEFT);
    //    menyusun kunci dan nomor baru
    $kode = $kunci . $nomor_baru_plus_nol;
    return $kode;
}

function messageSuccess($message)
{
    return ['success' => $message];
}


function messageError($message)
{
    return ['error' => $message];
}
function messageWarning($message)
{
    return ['warning' => $message];
}


// Mengubah ke Huruf Besar
function textUpperCase($value)
{
    return strtoupper(strtolower($value));
}
// Mengubah ke CamelCase
function textCamelCase($value)
{
    return ucwords(strtolower($value));
}




function getFotosiswa($file)
{
    $url = url('/storage/pelanggan/' . $file);
    return $url;
}


function getfotoKaryawan($file)
{
    if (empty($file)) {
        return asset('assets/img/avatars/No_Image_Available.jpg');
    }
    $url = url('/storage/photos/karyawan/' . $file);
    return $url;
}


function toNumber($value)
{
    if (!empty($value)) {
        return str_replace([".", ","], ["", "."], $value);
    } else {
        return 0;
    }
}


function formatRupiah($nilai)
{
    return number_format($nilai, '0', ',', '.');
}

function formatAngka($nilai)
{
    if (!empty($nilai)) {
        return number_format($nilai, '0', ',', '.');
    }
}


function formatAngkaDesimal($nilai)
{
    if (!empty($nilai)) {
        return number_format($nilai, '2', ',', '.');
    }
}

function formatAngkaDesimal3($nilai)
{
    if (!empty($nilai)) {
        return number_format($nilai, '3', ',', '.');
    }
}



function DateToIndo($date2)
{ // fungsi atau method untuk mengubah tanggal ke format indonesia
    // variabel BulanIndo merupakan variabel array yang menyimpan nama-nama bulan
    $BulanIndo2 = array(
        "Januari",
        "Februari",
        "Maret",
        "April",
        "Mei",
        "Juni",
        "Juli",
        "Agustus",
        "September",
        "Oktober",
        "November",
        "Desember"
    );

    $tahun2 = substr($date2, 0, 4); // memisahkan format tahun menggunakan substring
    $bulan2 = substr($date2, 5, 2); // memisahkan format bulan menggunakan substring
    $tgl2   = substr($date2, 8, 2); // memisahkan format tanggal menggunakan substring
    if (empty($date2)) {
        return '-';
    } else {
        $result = $tgl2 . " " . $BulanIndo2[(int)$bulan2 - 1] . " " . $tahun2;
    }
    return ($result);
}


function getbulandantahunlalu($bulan, $tahun, $show)
{
    if ($bulan == 1) {
        $bulanlalu = 12;
        $tahunlalu = $tahun - 1;
    } else {
        $bulanlalu = $bulan - 1;
        $tahunlalu = $tahun;
    }

    if ($show == "tahun") {
        return $tahunlalu;
    } elseif ($show == "bulan") {
        return $bulanlalu;
    }
}


function getbulandantahunberikutnya($bulan, $tahun, $show)
{
    if ($bulan == 12) {
        $bulanberikutnya =  1;
        $tahunberikutnya = $tahun + 1;
    } else {
        $bulanberikutnya = $bulan + 1;
        $tahunberikutnya = $tahun;
    }

    if ($show == "tahun") {
        return $tahunberikutnya;
    } elseif ($show == "bulan") {
        return $bulanberikutnya;
    }
}


function formatNama($sentence)
{
    $words = explode(' ', $sentence);
    if (count($words) >= 2) {
        return $words[0] . ' ' . $words[1];
    } else {
        return $sentence;
    }
}

function formatNama1($sentence)
{
    $words = explode(' ', $sentence);
    if (count($words) >= 2) {
        return $words[0];
    } else {
        return $sentence;
    }
}

function truncateString($string, $length = 50, $suffix = '...')
{
    // Periksa apakah panjang string lebih besar dari panjang yang diinginkan
    if (strlen($string) > $length) {
        // Potong string hingga panjang yang diinginkan dan tambahkan suffix
        return substr($string, 0, $length) . $suffix;
    }
    // Jika tidak, kembalikan string apa adanya
    return $string;
}


function removeHtmltag($string)
{
    // Menghapus tag HTML
    $string = strip_tags($string);
    // Menghapus &nbsp;
    $string = str_replace('&nbsp;', ' ', $string);
    return $string;
}


function penyebut($nilai)
{
    $nilai = abs($nilai);
    $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($nilai < 12) {
        $temp = " " . $huruf[$nilai];
    } else if ($nilai < 20) {
        $temp = penyebut($nilai - 10) . " belas";
    } else if ($nilai < 100) {
        $temp = penyebut($nilai / 10) . " puluh" . penyebut($nilai % 10);
    } else if ($nilai < 200) {
        $temp = " seratus" . penyebut($nilai - 100);
    } else if ($nilai < 1000) {
        $temp = penyebut($nilai / 100) . " ratus" . penyebut($nilai % 100);
    } else if ($nilai < 2000) {
        $temp = " seribu" . penyebut($nilai - 1000);
    } else if ($nilai < 1000000) {
        $temp = penyebut($nilai / 1000) . " ribu" . penyebut($nilai % 1000);
    } else if ($nilai < 1000000000) {
        $temp = penyebut($nilai / 1000000) . " juta" . penyebut($nilai % 1000000);
    } else if ($nilai < 1000000000000) {
        $temp = penyebut($nilai / 1000000000) . " milyar" . penyebut(fmod($nilai, 1000000000));
    } else if ($nilai < 1000000000000000) {
        $temp = penyebut($nilai / 1000000000000) . " trilyun" . penyebut(fmod($nilai, 1000000000000));
    }
    return $temp;
}

function terbilang($nilai)
{
    if ($nilai < 0) {
        $hasil = "minus " . trim(penyebut($nilai));
    } else {
        $hasil = trim(penyebut($nilai));
    }
    return $hasil;
}

function getnamaHari($hari)
{
    // $hari = date("D");

    switch ($hari) {
        case 'Sun':
            $hari_ini = "Minggu";
            break;

        case 'Mon':
            $hari_ini = "Senin";
            break;

        case 'Tue':
            $hari_ini = "Selasa";
            break;

        case 'Wed':
            $hari_ini = "Rabu";
            break;

        case 'Thu':
            $hari_ini = "Kamis";
            break;

        case 'Fri':
            $hari_ini = "Jumat";
            break;

        case 'Sat':
            $hari_ini = "Sabtu";
            break;

        default:
            $hari_ini = "Tidak di ketahui";
            break;
    }

    return $hari_ini;
}


function removeTitik($value)
{
    return str_replace('.', '', $value);
}

function hitungjarak($lat1, $lon1, $lat2, $lon2)
{
    $theta = $lon1 - $lon2;
    $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
    $miles = acos($miles);
    $miles = rad2deg($miles);
    $miles = $miles * 60 * 1.1515;
    $feet = $miles * 5280;
    $yards = $feet / 3;
    $kilometers = $miles * 1.609344;
    $meters = $kilometers * 1000;
    return compact('meters');
}


function hitungjamterlambat($jam_in, $jam_mulai)
{

    // $jam_in = date('Y-m-d H:i', strtotime($jam_in));
    // $jam_mulai = date('Y-m-d H:i', strtotime($jam_mulai));
    if (!empty($jam_in)) {
        if ($jam_in > $jam_mulai) {
            $j1 = strtotime($jam_mulai);
            $j2 = strtotime($jam_in);

            $diffterlambat = $j2 - $j1;

            $jamterlambat = floor($diffterlambat / (60 * 60));
            $menitterlambat = floor(($diffterlambat - $jamterlambat * (60 * 60)) / 60);

            $jterlambat = $jamterlambat <= 9 ? '0' . $jamterlambat : $jamterlambat;
            $mterlambat = $menitterlambat <= 9 ? '0' . $menitterlambat : $menitterlambat;

            $keterangan_terlambat =  $jterlambat . ':' . $mterlambat;
            $desimal_terlambat = $jamterlambat +   ROUND(($menitterlambat / 60), 2);


            // if ($jamterlambat < 1 && $menitterlambat <= 5) {
            //     $color_terlambat = 'text-success';
            //     $desimal_terlambat = 0;
            // } elseif ($jamterlambat < 1 && $menitterlambat > 5) {
            //     $color_terlambat = 'text-warning';
            //     $desimal_terlambat = 0;
            // } else {
            //     $color_terlambat = 'text-danger';
            //     $desimal_terlambat = $desimal_terlambat;
            // }

            $show = $desimal_terlambat < 1 ? $menitterlambat . " Menit" : formatAngkaDesimal($desimal_terlambat) . " Jam";
            return [
                'keterangan_terlambat' => $keterangan_terlambat,
                'jamterlambat' => $jamterlambat,
                'menitterlambat' => $menitterlambat  + ($jamterlambat * 60),
                'desimal_terlambat' => $desimal_terlambat,
                'show' => '<span style="color:red">' . $show . '</span>',
                'show_laporan' => 'Telat :' . $show,
                'color' => 'red'
                // 'color_terlambat' => $color_terlambat
            ];
        } else {
            return [
                'menitterlambat' => 0,
                'desimal_terlambat' => 0,
                'color' => 'green',
                'show' => '<span style="color:green">Tepat Waktu</span>',
                'show_laporan' => 'Tepat Waktu'
            ];
        }
    } else {
        return null;
    }
}

function hitungHari($startDate, $endDate)
{
    if ($startDate && $endDate) {
        $start = new DateTime($startDate);
        $end = new DateTime($endDate);

        // Tambahkan 1 hari agar penghitungan inklusif
        $interval = $start->diff($end);
        $dayDifference = $interval->days + 1;

        return  $dayDifference;
    } else {
        return 0;
    }
}

function getSid($file)
{
    $url = url('/storage/uploads/sid/' . $file);
    return $url;
}


function hitungdenda($menit_terlambat, $status_karyawan)
{
    if ($status_karyawan != 'T') {
        if ($menit_terlambat >= 1 && $menit_terlambat <= 5) {
            $denda = 5000;
        } else if ($menit_terlambat >= 6 && $menit_terlambat <= 10) {
            $denda = 10000;
        } else {
            $denda = $menit_terlambat * 1000;
        }
    } else {
        if ($menit_terlambat >= 1 && $menit_terlambat <= 10) {
            $denda = 10000;
        } else {
            $denda = $menit_terlambat * 1000;
        }
    }
    return $denda;
}


function hitungJumlahHari($tanggal_awal, $tanggal_akhir)
{
    $start_date = Carbon::parse($tanggal_awal);
    $end_date = Carbon::parse($tanggal_akhir);

    $jumlah_hari = $start_date->diffInDays($end_date);

    return $jumlah_hari;
}


function getHari($date)
{
    $days = array(
        'Sunday' => 'Minggu',
        'Monday' => 'Senin',
        'Tuesday' => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday' => 'Kamis',
        'Friday' => 'Jumat',
        'Saturday' => 'Sabtu'
    );
    $dayName = date('l', strtotime($date));
    return $days[$dayName];
}

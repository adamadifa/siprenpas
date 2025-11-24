<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Ajuan Limit Kredit </title>
    <link rel="stylesheet" href="{{ asset('assets/css/report.css') }}">
    <style>
        @page {
            size: A4
        }


        .judul {
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            font-size: 20px;
            text-align: center;
            color: #005e2f
        }

        .judul2 {
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            font-size: 16px;


        }

        .huruf {
            font-family: Verdana, Geneva, Tahoma, sans-serif;
        }

        .ukuranhuruf {
            font-size: 12px;
        }


        hr.style2 {
            border-top: 3px double #8c8b8b;
        }

        .logo-unit {
            width: 100px;
            height: 100px;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .nomorpendaftaran {
            float: right;
        }
    </style>
</head>

<body>

    @php
        $namaSekolah = optional($pengaturan)->nama_sekolah ?? 'PESANTREN PERSATUAN ISLAM 80 AL AMIN SINDANGKASIH';
        $alamatSekolah = optional($pengaturan)->alamat_sekolah ?? 'Jln. Raya Ancol No. 27 Ancol I Sindangkasih';
        $teleponSekolah = optional($pengaturan)->telepon ?? '(0265) 325285';
        $emailSekolah = optional($pengaturan)->email ?? 'peris.alamin80sinkas@gmail.com';
        $websiteSekolah = optional($pengaturan)->website ?? 'persisalamin.com';
        $logoPath = public_path('assets/img/logo/persisalamin.png');
        if (optional($pengaturan)->logo) {
            $customLogo = storage_path('app/public/' . $pengaturan->logo);
            if (file_exists($customLogo)) {
                $logoPath = $customLogo;
            }
        }
    @endphp
    <div style="text-align:center;">
        <img src="{{ $logoPath }}" alt="Logo" style="height:80px; margin-top:0;">
        <div style="font-size:1.1rem; font-weight:bold;">PANITIA PENERIMAAN SANTRI BARU (PSB)</div>
        <div style="font-size:1.1rem; font-weight:bold;">{{ strtoupper($namaSekolah) }}</div>
        <div style="font-size:1.1rem; font-weight:bold;">TINGKAT {{ $pendaftaran->nama_unit }} TAHUN
            {{ $pendaftaran->tahun_ajaran }}</div>
        <div style="font-size:0.95rem; font-style:italic; margin-top:2px;">
            {{ $alamatSekolah }}
            @if ($teleponSekolah)
                Telp. {{ $teleponSekolah }}
            @endif
            <br>
            @if ($emailSekolah)
                e-mail : {{ $emailSekolah }}
            @endif
            @if ($websiteSekolah)
                - web : {{ $websiteSekolah }}
            @endif
        </div>
        <hr style="border:1.5px solid #000; margin:10px 0 15px 0;">
    </div>
    <div class="nomor-pendaftaran">
        <h4 class="m-0 nomorpendaftaran">Nomor Pendaftaran : <span
                class="fw-bold">{{ $pendaftaran->no_pendaftaran }}</span></h4>
    </div>

    <!-- DATA PESERTA DIDIK -->
    <h5 class="m-0" style="margin-top:16px;">A. DATA PESERTA DIDIK</h5>

    <!-- Foto Peserta Didik -->
    @if (isset($foto_base64) && $foto_base64)
        <div style="margin: 15px 0; page-break-inside: avoid;">
            <div style="display: inline-block; border: 2px solid #000; padding: 5px; background: #fff; margin-left: 0;">
                <img src="{{ $foto_base64 }}" alt="Foto {{ $pendaftaran->nama_lengkap }}"
                    style="width: 120px; height: 160px; object-fit: cover; border: 1px solid #ccc;">
            </div>
        </div>
    @endif

    <table style="width:100%; font-size:1rem; margin-bottom:10px;">
        <tr>
            <td style="width:3%;">1.</td>
            <td style="width:30%;">NISN</td>
            <td style="width:3%;">:</td>
            <td>{{ $pendaftaran->nisn }}</td>
        </tr>
        <tr>
            <td>2.</td>
            <td>Nama Lengkap</td>
            <td>:</td>
            <td>{{ $pendaftaran->nama_lengkap }}</td>
        </tr>
        <tr>
            <td>3.</td>
            <td>Tempat / Tanggal Lahir</td>
            <td>:</td>
            <td>{{ textCamelCase($pendaftaran->tempat_lahir) }}, {{ DateToIndo($pendaftaran->tanggal_lahir) }}</td>
        </tr>
        <tr>
            <td>4.</td>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td>{{ $pendaftaran->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
        </tr>
        <tr>
            <td>5.</td>
            <td>Anak Ke</td>
            <td>:</td>
            <td>{{ $pendaftaran->anak_ke }}</td>
        </tr>
        <tr>
            <td>6.</td>
            <td>Jumlah Saudara</td>
            <td>:</td>
            <td>{{ $pendaftaran->jumlah_saudara }}</td>
        </tr>
    </table>

    <!-- ALAMAT -->
    <h5 class="m-0">B. ALAMAT</h5>
    <table style="width:100%; font-size:1rem; margin-bottom:10px;">
        <tr>
            <td style="width:3%;">1.</td>
            <td style="width:30%;">Kp/Jln.</td>
            <td style="width:3%;">:</td>
            <td>{{ textCamelCase($pendaftaran->alamat) }}</td>
        </tr>
        <tr>
            <td>2.</td>
            <td>Kelurahan</td>
            <td>:</td>
            <td>{{ textCamelCase($pendaftaran->desa) }}</td>
        </tr>
        <tr>
            <td>3.</td>
            <td>Kecamatan</td>
            <td>:</td>
            <td>{{ textCamelCase($pendaftaran->kecamatan) }}</td>
        </tr>
        <tr>
            <td>4.</td>
            <td>Kota</td>
            <td>:</td>
            <td>{{ textCamelCase($pendaftaran->kota) }}</td>
        </tr>
        <tr>
            <td>5.</td>
            <td>Provinsi</td>
            <td>:</td>
            <td>{{ textCamelCase($pendaftaran->provinsi) }}</td>
        </tr>
    </table>

    <!-- INFORMASI ORANG TUA -->
    <h5 class="m-0">C. INFORMASI ORANG TUA</h5>
    <table style="width:100%; font-size:1rem; margin-bottom:10px;">
        <tr>
            <td style="width:3%;">1.</td>
            <td style="width:30%;">NIK Ayah</td>
            <td style="width:3%;">:</td>
            <td>{{ textCamelCase($pendaftaran->nik_ayah) }}</td>
        </tr>
        <tr>
            <td>2.</td>
            <td>Nama Ayah</td>
            <td>:</td>
            <td>{{ textCamelCase($pendaftaran->nama_ayah) }}</td>
        </tr>
        <tr>
            <td>3.</td>
            <td>Pendidikan Ayah</td>
            <td>:</td>
            <td>{{ textCamelCase($pendaftaran->pendidikan_ayah) }}</td>
        </tr>
        <tr>
            <td>4.</td>
            <td>Pekerjaan Ayah</td>
            <td>:</td>
            <td>{{ textCamelCase($pendaftaran->pekerjaan_ayah) }}</td>
        </tr>
        <tr>
            <td>5.</td>
            <td>NIK Ibu</td>
            <td>:</td>
            <td>{{ textCamelCase($pendaftaran->nik_ibu) }}</td>
        </tr>
        <tr>
            <td>6.</td>
            <td>Nama Ibu</td>
            <td>:</td>
            <td>{{ textCamelCase($pendaftaran->nama_ibu) }}</td>
        </tr>
        <tr>
            <td>7.</td>
            <td>Pendidikan Ibu</td>
            <td>:</td>
            <td>{{ textCamelCase($pendaftaran->pendidikan_ibu) }}</td>
        </tr>
        <tr>
            <td>8.</td>
            <td>Pekerjaan Ibu</td>
            <td>:</td>
            <td>{{ textCamelCase($pendaftaran->pekerjaan_ibu) }}</td>
        </tr>
    </table>
    <div style="text-align:right;margin-top:12px;">
        {!! QrCode::size(100)->generate($pendaftaran->no_pendaftaran) !!}
    </div>
</body>



</html>

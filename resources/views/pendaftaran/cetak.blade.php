<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Ajuan Limit Kredit </title>
    <!-- Normalize or reset CSS with your favorite library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">
    <!-- Load paper.css for happy printing -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">
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

    <body class="A4">

        <!-- Each sheet element should have the class "sheet" -->
        <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
        <section class="sheet padding-10mm">
            <div style="text-align:center; margin-bottom: 10px;">
                <img src="{{ public_path('assets/img/logo/persisalamin.png') }}" alt="Logo" style="height:80px; margin-bottom:8px;">
                <div style="font-size:1.1rem; font-weight:bold;">PANITIA PENERIMAAN SANTRI BARU (PSB)</div>
                <div style="font-size:1.1rem; font-weight:bold;">PESANTREN PERSATUAN ISLAM 80 AL AMIN SINDANGKASIH</div>
                <div style="font-size:1.1rem; font-weight:bold;">TINGKAT {{ $pendaftaran->nama_unit }} TAHUN {{ $pendaftaran->tahun_ajaran }}</div>
                <div style="font-size:0.95rem; font-style:italic; margin-top:2px;">
                    Jln. Raya Ancol No. 27 Ancol I Sindangkasih Telp.-Fax. (0265) 325285 Ciamis 46268<br>
                    e-mail : peris.alamin80sinkas@gmail.com - web : persisalamin.com
                </div>
                <hr style="border:1.5px solid #000; margin:10px 0 15px 0;">
            </div>
            <div class="nomor-pendaftaran">
                <h4 class="m-0 nomorpendaftaran">Nomor Pendaftaran : <span class="fw-bold">{{ $pendaftaran->no_pendaftaran }}</span></h4>
            </div>
            <div class="datapsertadidik" style="margin-top: 100px">
                <h5 class="m-0">A. DATA PESERTA DIDK</h5>
                <table class="table table-report" style="width: auto !important; ">
                    <tr>
                        <td style="width: 1%">1.</td>
                        <td style="width:30%">NISN</td>
                        <td style="width: 1%">:</td>
                        <td style="width: 68%">{{ $pendaftaran->nisn }}</td>
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
                        <td>AnakKe</td>
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
            </div>
            <div class="dataalamat">
                <h5 class="m-0">B. ALAMAT</h5>
                <table class="table table-report" style="width: auto !important; ">
                    <tr>
                        <td style="width: 1%">1.</td>
                        <td style="width:30%">Kp/Jln.</td>
                        <td style="width: 1%">:</td>
                        <td style="width: 68%">{{ textCamelCase($pendaftaran->alamat) }}</td>
                    </tr>
                    <tr>
                        <td style="width: 1%">2.</td>
                        <td style="width:30%">Kelurahan</td>
                        <td>:</td>
                        <td>{{ textCamelCase($pendaftaran->desa) }}</td>
                    </tr>
                    <tr>
                        <td style="width: 1%">3.</td>
                        <td style="width:30%">Kecamatan</td>
                        <td>:</td>
                        <td>{{ textCamelCase($pendaftaran->kecamatan) }}</td>
                    </tr>
                    <tr>
                        <td style="width: 1%">4.</td>
                        <td style="width:30%">Kota</td>
                        <td>:</td>
                        <td>{{ textCamelCase($pendaftaran->kota) }}</td>
                    </tr>
                    <tr>
                        <td style="width: 1%">5.</td>
                        <td style="width:30%">Provinsi</td>
                        <td>:</td>
                        <td>{{ textCamelCase($pendaftaran->provinsi) }}</td>
                    </tr>

                </table>
            </div>
            <div class="dataorangtua">
                <h5 class="m-0">C. DATA ORANG TUA</h5>
                <table class="table table-report" style="width: auto !important; ">
                    <tr>
                        <td style="width: 1%">1.</td>
                        <td style="width:30%">Kp/Jln.</td>
                        <td style="width: 1%">:</td>
                        <td style="width: 68%">{{ textCamelCase($pendaftaran->alamat) }}</td>
                    </tr>
                    <tr>
                        <td style="width: 1%">2.</td>
                        <td style="width:30%">Kelurahan</td>
                        <td>:</td>
                        <td>{{ textCamelCase($pendaftaran->desa) }}</td>
                    </tr>
                    <tr>
                        <td style="width: 1%">3.</td>
                        <td style="width:30%">Kecamatan</td>
                        <td>:</td>
                        <td>{{ textCamelCase($pendaftaran->kecamatan) }}</td>
                    </tr>
                    <tr>
                        <td style="width: 1%">4.</td>
                        <td style="width:30%">Kota</td>
                        <td>:</td>
                        <td>{{ textCamelCase($pendaftaran->kota) }}</td>
                    </tr>
                    <tr>
                        <td style="width: 1%">5.</td>
                        <td style="width:30%">Provinsi</td>
                        <td>:</td>
                        <td>{{ textCamelCase($pendaftaran->provinsi) }}</td>
                    </tr>

                </table>
            </div>
            <div class="qrcode" style="float: right;">
                {!! $qrCode !!}
            </div>
        </section>
    </body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Agenda Kegiatan</title>
    <!-- Normalize or reset CSS with your favorite library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">
    <!-- Load paper.css for happy printing -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">
    <link rel="stylesheet" href="{{ asset('assets/css/report.css') }}">
    <style>
        @page {
            size: A4 landscape;
            margin-top: 10mm;

            /* Tambahkan margin atas untuk setiap halaman dalam posisi landscape */
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

        .sheet {
            overflow: visible ! important;
            height: auto ! important;
        }
    </style>
</head>

<body>

    <body class="A4 landscape">

        <!-- Each sheet element should have the class "sheet" -->
        <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
        <section class="sheet padding-10mm">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: center">
                        <h3 style="font-family:'Cambria'; line-height:0px">AGENDA KEGIATAN</h3>
                        <h3 style="font-family:'Cambria'; line-height:0px">BIDANG
                            {{ strtoupper($departemen->nama_dept) }}</h3>
                        <h3 style="font-family:'Cambria'; line-height:0px">PESANTREN PERSATUAN ISLAM 80 AL AMIN </h3>
                        <h3 style="font-family:'Cambria'; line-height:0px">SINDANGKASIH - CIAMIS</h3>
                        <h4 style="font-family:'Cambria'; line-height:0px">PERIODE {{ DateToIndo($dari) }} -
                            {{ DateToIndo($sampai) }}</h4>
                    </td>
                </tr>
            </table>
            <hr>
            <table class="datatable3" style="width: 100%">
                <thead>
                    <tr>
                        <th style="width: 1%">No.</th>
                        <th style="width: 10%">Tanggal</th>
                        <th style="width: 25">Nama Kegiatan</th>
                        <th style="width: 55%">Uraian Kegiatan</th>
                        <th>User</th>

                    </tr>
                </thead>
                <tbody>
                    @php
                        $noUrut = 1;
                    @endphp
                    @foreach ($agenda_kegiatan as $d)
                        <tr>
                            <td>{{ $noUrut++ }}</td>
                            <td>{{ date('d-m-Y', strtotime($d->tanggal)) }}</td>
                            <td>{{ strip_tags($d->nama_kegiatan) }}</td>
                            <td>{{ strip_tags($d->uraian_kegiatan) }}</td>
                            <td>{{ formatNama1($d->name) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
    </body>

</html>

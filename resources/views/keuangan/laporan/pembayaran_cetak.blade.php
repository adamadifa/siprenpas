<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Pembayaran {{ date('Y-m-d H:i:s') }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/report.css') }}">
    <style>
        p {
            line-height: 1rem !important;
            margin: 0 !important;
            padding: 0 !important;
        }
    </style>
</head>

<body>
    <div class="header" style="margin-bottom: 10px">
        <table>
            <tr>
                <td>
                
                    <img src="{{ asset('assets/img/logo/persisalamin.png') }}" alt="Logo Perusahaan"
                        style="max-width: 100px;">
                </td>
                <td>
                    <h4 style="line-height: 20px; margin-bottom: 5px">
                        LAPORAN PEMBAYARAN SANTRI
                        <br>
                        PESANTREN PERSIS AL AMIN 80 AL AMIN
                        <br>
                        SINDANGKASIH - CIAMIS
                        <br>
                        PERIODE {{ DateToIndo($dari) }} s/d {{ DateToIndo($sampai) }}
                    </h4>
                    <span style="font-style: italic;">
                        Jln. Raya Ancol No. 27 Sindangkasih - Ciamis
                    </span><br>
                    {{-- <span style="font-style: italic;">08123456789</span> --}}
                </td>
            </tr>
        </table>
    </div>
    <div class="content">
        <table class="datatable3">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>No. Bukti</th>
                    <th>Tanggal</th>
                    <th>NIS</th>
                    <th>Nama Lengkap</th>
                    <th>Jenis Biaya</th>
                    <th>Jumlah</th>
                    <th>Keterangan</th>
                  

            </thead>
            <tbody>
                @php
                    $total_pembayaran = 0;
                @endphp
                @foreach ($pembayaran as $p)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $p->no_bukti }}</td>
                        <td>{{ $p->tanggal }}</td>
                        <td>{{ $p->nis }}</td>
                        <td>{{ $p->nama_lengkap }}</td>
                        <td>{{ $p->jenis_biaya }}</td>
                        <td style="text-align: right">{{ formatAngka($p->jumlah) }}</td>
                        <td>{{ $p->keterangan }}</td>
                    </tr>
                    @php
                        $total_pembayaran += $p->jumlah;
                    @endphp
                @endforeach
            </tbody>
            <tfoot >
                <tr>
                    <th colspan="6" style="text-align: left">Total</td>
                    <th style="text-align: right">{{ formatAngka($total_pembayaran) }}</td>
                    <th></th>
                </tr>
            </tfoot>
        </table>
    </div>
</body>

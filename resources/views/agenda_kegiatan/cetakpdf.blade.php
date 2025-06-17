<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Agenda Kegiatan PDF</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 10mm;
        }
        body {
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            font-size: 12px;
            color: #222;
        }
        .kop {
            margin-bottom: 10px;
            text-align: center;
        }
        .kop-title {
            font-size: 18px;
            font-weight: bold;
            color: #005e2f;
            margin-bottom: 2px;
        }
        .kop-sub {
            font-size: 16px;
            font-weight: bold;
            color: #005e2f;
            margin-bottom: 2px;
        }
        .kop-period {
            font-size: 13px;
            color: #222;
            margin-bottom: 0;
            margin-top: 2px;
        }
        hr.style2 {
            border-top: 3px double #8c8b8b;
            margin: 12px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        th, td {
            border: 1px solid #333;
            padding: 6px 4px;
            font-size: 12px;
        }
        th {
            background: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="sheet padding-10mm">
        <div class="kop">
            <div class="kop-title">AGENDA KEGIATAN</div>
            <div class="kop-sub">BIDANG {{ strtoupper($departemen->nama_dept) }}</div>
            <div class="kop-sub">PESANTREN PERSATUAN ISLAM 80 AL AMIN</div>
            <div class="kop-sub">SINDANGKASIH - CIAMIS</div>
            <div class="kop-period">PERIODE {{ DateToIndo($dari) }} - {{ DateToIndo($sampai) }}</div>
        </div>
        <hr class="style2">
        <table>
            <thead>
                <tr>
                    <th style="width: 4%">No.</th>
                    <th style="width: 12%">Tanggal</th>
                    <th style="width: 25%">Nama Kegiatan</th>
                    <th style="width: 55%">Uraian Kegiatan</th>
                    <th>User</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($agenda_kegiatan as $d)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ date('d-m-Y', strtotime($d->tanggal)) }}</td>
                        <td>{{ strip_tags($d->nama_kegiatan) }}</td>
                        <td>{{ strip_tags($d->uraian_kegiatan) }}</td>
                        <td>{{ formatNama1($d->name) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>

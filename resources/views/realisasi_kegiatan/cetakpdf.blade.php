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
        .judul {
            font-size: 20px;
            text-align: center;
            color: #005e2f;
            margin-bottom: 0;
        }
        .judul2 {
            font-size: 16px;
            text-align: center;
            margin-bottom: 0;
        }
        .periode {
            font-size: 14px;
            text-align: center;
            margin-bottom: 12px;
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
        .no-border td {
            border: none;
        }
    </style>
</head>

<body>
    <table class="no-border">
        <tr>
            <td style="text-align: center">
                <div style="margin-bottom: 10px;">
    <div style="font-size:18px; font-weight:bold; color:#005e2f; margin-bottom:2px;">LAPORAN KEGIATAN</div>
    <div style="font-size:16px; font-weight:bold; color:#005e2f; margin-bottom:2px;">BIDANG {{ strtoupper($departemen->nama_dept) }}</div>
    <div style="font-size:16px; font-weight:bold; color:#005e2f; margin-bottom:2px;">PESANTREN PERSATUAN ISLAM 80 AL AMIN</div>
    <div style="font-size:16px; font-weight:bold; color:#005e2f; margin-bottom:2px;">SINDANGKASIH - CIAMIS</div>
    <div style="font-size:13px; font-weight:normal; color:#222; margin-bottom:0; margin-top:2px;">PERIODE {{ DateToIndo($dari) }} - {{ DateToIndo($sampai) }}</div>
</div>
            </td>
        </tr>
    </table>
    <hr class="style2">
    <table>
        <thead>
            <tr>
                <th style="width: 4%">No.</th>
                <th style="width: 12%">Tanggal</th>
                <th style="width: 20%">Nama Kegiatan</th>
                <th style="width: 28%">Uraian Kegiatan</th>
                <th style="width: 14%">Jobdesk</th>
                <th style="width: 16%">Program Kerja</th>
                <th>User</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($realisasikegiatan as $d)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ date('d-m-Y', strtotime($d->tanggal)) }}</td>
                    <td>{{ removeHtmltag($d->nama_kegiatan) }}</td>
                    <td>{{ removeHtmltag($d->uraian_kegiatan) }}</td>
                    <td>{{ removeHtmltag($d->jobdesk) }}</td>
                    <td>{{ $d->program_kerja }}</td>
                    <td>{{ formatNama1($d->name) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>

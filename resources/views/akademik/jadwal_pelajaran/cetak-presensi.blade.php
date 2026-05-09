<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Presensi - {{ $jadwal->mapel->nama_matpel }}</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 1cm;
        }
        body {
            font-family: 'Arial', sans-serif;
            font-size: 11px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
        }
        .header h2 { margin: 0; text-transform: uppercase; }
        .header p { margin: 5px 0 0; font-size: 12px; }

        .info-table {
            width: 100%;
            margin-bottom: 15px;
        }
        .info-table td {
            padding: 2px 5px;
        }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
        }
        table.data-table th, table.data-table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }
        table.data-table th {
            background-color: #f2f2f2;
        }
        .text-left { text-align: left !important; }

        /* Stacked text for dates */
        .vertical-text {
            line-height: 1.2;
            padding: 5px 0;
            font-size: 10px;
            font-weight: bold;
        }

        .summary-box {
            margin-top: 20px;
            float: right;
            width: 250px;
            text-align: center;
        }
        .summary-box p { margin: 0; }
        .signature-space { height: 60px; }

        .status-h { color: green; font-weight: bold; }
        .status-i { color: blue; }
        .status-s { color: orange; }
        .status-a { color: red; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h2>SIPRENPAS - SISTEM PRESENSI PENDIDIKAN</h2>
        <p>Laporan Rekapitulasi Presensi Mata Pelajaran</p>
    </div>

    <table class="info-table">
        <tr>
            <td width="15%">Mata Pelajaran</td>
            <td width="2%">:</td>
            <td width="33%"><strong>{{ $jadwal->mapel->nama_matpel }}</strong></td>
            <td width="15%">Tahun Ajaran</td>
            <td width="2%">:</td>
            <td width="33%">{{ $jadwal->tahunAjaran->tahun_ajaran }} ({{ $jadwal->semester == 1 ? 'Ganjil' : 'Genap' }})</td>
        </tr>
        <tr>
            <td>Kelas</td>
            <td>:</td>
            <td>{{ $jadwal->kelas->nama_kelas }}</td>
            <td>Guru Pengampu</td>
            <td>:</td>
            <td>{{ $jadwal->guru->nama_guru }}</td>
        </tr>
        <tr>
            <td>Hari / Jam</td>
            <td>:</td>
            <td>{{ $jadwal->hari }} / {{ date('H:i', strtotime($jadwal->jam_mulai)) }} - {{ date('H:i', strtotime($jadwal->jam_selesai)) }}</td>
            <td>Unit</td>
            <td>:</td>
            <td>{{ $jadwal->unit->nama_unit }}</td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th rowspan="2" width="30px">No</th>
                <th rowspan="2">Nama Siswa</th>
                <th colspan="{{ count($presensi) > 0 ? count($presensi) : 1 }}">Pertemuan Ke-</th>
                <th colspan="4">Rekap</th>
            </tr>
            <tr>
                @if(count($presensi) > 0)
                    @foreach($presensi as $index => $p)
                        <th width="30px">{{ $index + 1 }}</th>
                    @endforeach
                @else
                    <th width="30px">-</th>
                @endif
                <th width="30px">H</th>
                <th width="30px">I</th>
                <th width="30px">S</th>
                <th width="30px">A</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $index => $item)
                @php
                    $h = 0; $i = 0; $s = 0; $a = 0;
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td class="text-left">{{ $item->siswa->nama_lengkap }}</td>
                    @if(count($presensi) > 0)
                        @foreach($presensi as $p)
                            @php
                                $status = $attMatrix[$item->id_siswa][$p->id] ?? '-';
                                if($status == 'H') $h++;
                                elseif($status == 'I') $i++;
                                elseif($status == 'S') $s++;
                                elseif($status == 'A') $a++;
                            @endphp
                            <td class="status-{{ strtolower($status) }}">{{ $status }}</td>
                        @endforeach
                    @else
                        <td>-</td>
                    @endif
                    <td>{{ $h > 0 ? $h : '' }}</td>
                    <td>{{ $i > 0 ? $i : '' }}</td>
                    <td>{{ $s > 0 ? $s : '' }}</td>
                    <td>{{ $a > 0 ? $a : '' }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <!-- Baris Tanggal (DD) -->
            <tr>
                <td colspan="2" style="text-align: right; font-weight: bold;">Tgl (DD)</td>
                @if(count($presensi) > 0)
                    @foreach($presensi as $p)
                        <td style="font-weight: bold;">{{ date('d', strtotime($p->tanggal)) }}</td>
                    @endforeach
                @else
                    <td></td>
                @endif
                <td colspan="4" style="background-color: #f2f2f2;"></td>
            </tr>
            <!-- Baris Bulan (MM) -->
            <tr>
                <td colspan="2" style="text-align: right; font-weight: bold;">Bln (MM)</td>
                @if(count($presensi) > 0)
                    @foreach($presensi as $p)
                        <td style="font-weight: bold;">{{ date('m', strtotime($p->tanggal)) }}</td>
                    @endforeach
                @else
                    <td></td>
                @endif
                <td colspan="4" style="background-color: #f2f2f2;"></td>
            </tr>
            <!-- Baris Tahun (YYYY) -->
            <tr>
                <td colspan="2" style="text-align: right; font-weight: bold;">Thn (YYYY)</td>
                @if(count($presensi) > 0)
                    @foreach($presensi as $p)
                        <td style="font-size: 9px; font-weight: bold;">{{ date('Y', strtotime($p->tanggal)) }}</td>
                    @endforeach
                @else
                    <td></td>
                @endif
                <td colspan="4" style="background-color: #f2f2f2;"></td>
            </tr>
        </tfoot>
    </table>

    <div class="summary-box">
        <p>{{ $jadwal->unit->lokasi ?? 'Bandung' }}, {{ date('d F Y') }}</p>
        <p>Guru Pengampu,</p>
        <div class="signature-space"></div>
        <p><strong>{{ $jadwal->guru->nama_guru }}</strong></p>
    </div>

    <script>
        window.print();
    </script>
</body>
</html>

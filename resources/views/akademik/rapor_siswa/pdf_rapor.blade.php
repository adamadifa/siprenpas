<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rapor Siswa - {{ $siswa->nama_lengkap }}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            line-height: 1.3;
            color: #000;
        }
        @page {
            margin: 1.2cm 1.5cm 1.2cm 1.5cm;
        }
        .page-break {
            page-break-after: always;
        }
        
        /* Header Kop */
        .header-kop {
            width: 100%;
            border-bottom: 2px solid #000;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }
        .header-kop table {
            width: 100%;
            border: none;
        }
        .header-kop td {
            border: none;
            padding: 0;
        }
        .logo-kemenag {
            width: 60px;
            text-align: left;
        }
        .logo-pesantren {
            width: 60px;
            text-align: right;
        }
        .kop-text {
            text-align: center;
        }
        .kop-text h2 {
            font-size: 13px;
            margin: 0;
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 0.5px;
        }
        .kop-text h1 {
            font-size: 16px;
            margin: 3px 0;
            text-transform: uppercase;
            font-weight: bold;
            color: #0b3d24;
        }
        .kop-text p {
            font-size: 9px;
            margin: 0;
            font-style: italic;
        }

        /* Info Siswa Grid */
        .info-siswa {
            width: 100%;
            margin-bottom: 15px;
        }
        .info-siswa table {
            width: 100%;
            border: none;
        }
        .info-siswa td {
            border: none;
            padding: 2px 0;
            vertical-align: top;
        }
        .info-siswa .label {
            width: 80px;
        }
        .info-siswa .colon {
            width: 10px;
        }

        /* Title Section */
        .title-section {
            text-align: center;
            margin-bottom: 15px;
        }
        .title-section h3 {
            font-size: 14px;
            margin: 0;
            text-transform: uppercase;
            font-weight: bold;
            text-decoration: underline;
        }

        /* Table Style */
        .table-data {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .table-data th, .table-data td {
            border: 1px solid #000;
            padding: 5px;
            vertical-align: middle;
        }
        .table-data th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .fw-bold {
            font-weight: bold;
        }

        /* Box Section */
        .section-box {
            margin-bottom: 12px;
        }
        .section-box h4 {
            font-size: 11px;
            margin: 0 0 4px 0;
            font-weight: bold;
        }
        .box-content {
            border: 1px solid #000;
            padding: 6px;
            min-height: 35px;
            background-color: #fafafa;
        }

        /* Attendance Table */
        .table-attendance {
            width: 50%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }
        .table-attendance td {
            border: 1px solid #000;
            padding: 4px 8px;
        }

        /* Footer Page */
        .footer-page {
            position: absolute;
            bottom: 0;
            width: 100%;
            border-top: 1px solid #ccc;
            padding-top: 5px;
            font-size: 9px;
            color: #555;
        }
        .footer-left {
            float: left;
        }
        .footer-right {
            float: right;
        }

        /* Signatures Grid */
        .signature-section {
            width: 100%;
            margin-top: 25px;
        }
        .signature-table {
            width: 100%;
            border: none;
        }
        .signature-table td {
            border: none;
            text-align: center;
            vertical-align: top;
            padding: 0;
        }
        .signature-space {
            height: 55px;
        }
    </style>
</head>
<body>

    <!-- ================= HALAMAN 1 ================= -->
    
    <!-- Kop Surat -->
    <div class="header-kop">
        <table>
            <tr>
                <td class="logo-pesantren" style="width: 60px; text-align: left;">
                    @if($unit_logo_base64)
                        <img src="{{ $unit_logo_base64 }}" width="45">
                    @elseif($logo_base64)
                        <img src="{{ $logo_base64 }}" width="45">
                    @elseif(file_exists(public_path('assets/img/logo/persisalamin.png')))
                        <img src="{{ public_path('assets/img/logo/persisalamin.png') }}" width="45">
                    @else
                        <div style="width:45px; height:45px; border:1px dashed #ccc; text-align:center; font-size:8px;">Logo</div>
                    @endif
                </td>
                <td class="kop-text">
                    <h2>Kementerian Agama Republik Indonesia</h2>
                    <h1>{{ $unit->nama_unit ?? ($pengaturan->nama_madrasah ?? 'MTsS Persis Sindangkasih') }}</h1>
                    <p>{{ $pengaturan->alamat ?? 'Jl. Raya Ancol No. 27 Ancol I, Sindangkasih, Ciamis - Jawa Barat' }}</p>
                </td>
                <td style="width: 60px;"></td>
            </tr>
        </table>
    </div>

    <!-- Info Siswa -->
    <div class="info-siswa">
        <table style="width: 100%;">
            <tr>
                <td style="width: 50%;">
                    <table>
                        <tr>
                            <td class="label">NAMA</td>
                            <td class="colon">:</td>
                            <td class="fw-bold">{{ strtoupper($siswa->nama_lengkap) }}</td>
                        </tr>
                        <tr>
                            <td class="label">NIS/NISN</td>
                            <td class="colon">:</td>
                            <td>{{ $pendaftaran->nis ?? '-' }} / {{ $siswa->nisn ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Madrasah</td>
                            <td class="colon">:</td>
                            <td>{{ $unit->nama_unit ?? ($pengaturan->nama_madrasah ?? 'MTsS PERSIS SINDANGKASIH') }}</td>
                        </tr>
                        <tr>
                            <td class="label">Alamat</td>
                            <td class="colon">:</td>
                            <td style="font-size: 10px;">{{ $pengaturan->alamat ?? '-' }}</td>
                        </tr>
                    </table>
                </td>
                <td style="width: 50%;">
                    <table>
                        <tr>
                            <td class="label">Kelas</td>
                            <td class="colon">:</td>
                            <td>{{ $kelas->nama_kelas ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Semester</td>
                            <td class="colon">:</td>
                            <td>{{ ($activeSemester->semester ?? 1) == 1 ? 'Ganjil' : 'Genap' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Tahun Ajaran</td>
                            <td class="colon">:</td>
                            <td>{{ $activeTa->tahun_ajaran ?? '-' }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <!-- Title -->
    <div class="title-section">
        <h3>Capaian Hasil Belajar</h3>
    </div>

    <!-- Grades Table -->
    <table class="table-data">
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th>Mata Pelajaran</th>
                <th style="width: 80px;">Nilai Akhir</th>
                <th>Capaian Kompetensi</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($subjects as $mapel)
                @if ($mapel->children->count() > 0)
                    <tr style="background-color: #fafafa;">
                        <td class="text-center fw-bold">{{ $no++ }}</td>
                        <td class="fw-bold" colspan="3">{{ $mapel->nama_matpel }}</td>
                    </tr>
                    @php $letter = 'A'; @endphp
                    @foreach ($mapel->children as $child)
                        <tr>
                            <td></td>
                            <td style="padding-left: 15px;">{{ $letter++ }}. {{ $child->nama_matpel }}</td>
                            <td class="text-center fw-bold">{{ $child->grade->nilai_rapor }}</td>
                            <td style="font-size: 10px;">{{ $child->grade->capaian_kompetensi }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="text-center">{{ $no++ }}</td>
                        <td>{{ $mapel->nama_matpel }}</td>
                        <td class="text-center fw-bold">{{ $mapel->grade->nilai_rapor }}</td>
                        <td style="font-size: 10px;">{{ $mapel->grade->capaian_kompetensi }}</td>
                    </tr>
                @endif
            @endforeach
            <tr style="background-color: #f2f2f2;">
                <td class="text-center fw-bold" colspan="2">Jumlah</td>
                <td class="text-center fw-bold">{{ $totalGrade }}</td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <!-- Footer Halaman 1 -->
    <div class="footer-page">
        <div class="footer-left">
            {{ $kelas->nama_kelas ?? '-' }} _ {{ strtoupper($siswa->nama_lengkap) }} _ {{ $pendaftaran->nis ?? '-' }}
        </div>
        <div class="footer-right">
            Halaman 1
        </div>
    </div>

    <div class="page-break"></div>

    <!-- ================= HALAMAN 2 ================= -->

    <!-- Kokurikuler -->
    <div class="section-box">
        <h4>Kokurikuler</h4>
        <div class="box-content">
            {{ $kokurikuler ?: '-' }}
        </div>
    </div>

    <!-- Ekstrakurikuler -->
    <div class="section-box">
        <h4>Ekstrakurikuler</h4>
        <table class="table-data" style="margin-bottom: 5px;">
            <thead>
                <tr>
                    <th style="width: 30px;">No</th>
                    <th>Kegiatan Ekstrakurikuler</th>
                    <th style="width: 80px;">Nilai</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @php $ekskulCount = 0; @endphp
                @if(!empty($ekskul))
                    @foreach($ekskul as $index => $e)
                        @if(!empty($e['kegiatan']))
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $e['kegiatan'] }}</td>
                                <td class="text-center fw-bold">{{ $e['nilai'] }}</td>
                                <td>{{ $e['keterangan'] }}</td>
                            </tr>
                            @php $ekskulCount++; @endphp
                        @endif
                    @endforeach
                @endif
                @for($i = $ekskulCount + 1; $i <= 2; $i++)
                    <tr>
                        <td class="text-center">{{ $i }}</td>
                        <td>-</td>
                        <td class="text-center">-</td>
                        <td>-</td>
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>

    <!-- Prestasi -->
    <div class="section-box">
        <h4>Prestasi</h4>
        <table class="table-data" style="margin-bottom: 5px;">
            <thead>
                <tr>
                    <th style="width: 30px;">No</th>
                    <th style="width: 150px;">Jenis Prestasi</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @php $prestasiCount = 0; @endphp
                @if(!empty($prestasi))
                    @foreach($prestasi as $index => $p)
                        @if(!empty($p['jenis']))
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $p['jenis'] }}</td>
                                <td>{{ $p['keterangan'] }}</td>
                            </tr>
                            @php $prestasiCount++; @endphp
                        @endif
                    @endforeach
                @endif
                @for($i = $prestasiCount + 1; $i <= 3; $i++)
                    <tr>
                        <td class="text-center">{{ $i }}</td>
                        <td>-</td>
                        <td>-</td>
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>

    <!-- Ketidakhadiran -->
    <div class="section-box">
        <h4>Ketidakhadiran</h4>
        <table class="table-attendance">
            <tr>
                <td style="width: 60%;">Sakit</td>
                <td class="text-center fw-bold" style="width: 25%;">{{ $kehadiran->sakit }}</td>
                <td>Hari</td>
            </tr>
            <tr>
                <td>Izin</td>
                <td class="text-center fw-bold">{{ $kehadiran->izin }}</td>
                <td>Hari</td>
            </tr>
            <tr>
                <td>Tanpa Keterangan (Alpa)</td>
                <td class="text-center fw-bold">{{ $kehadiran->alpa }}</td>
                <td>Hari</td>
            </tr>
        </table>
    </div>

    <!-- Catatan Wali Kelas -->
    <div class="section-box">
        <h4>Catatan Wali Kelas</h4>
        <div class="box-content" style="min-height: 45px;">
            {{ $catatan_wali ?: '-' }}
        </div>
    </div>

    <!-- Tanggapan Orang Tua -->
    <div class="section-box">
        <h4>Tanggapan Orang Tua/Wali</h4>
        <div class="box-content" style="min-height: 45px;">
            {{ $tanggapan_ortu ?: '-' }}
        </div>
    </div>

    <!-- Tanda Tangan -->
    <div class="signature-section">
        <table class="signature-table">
            <tr>
                <td style="width: 33%;">
                    <p style="margin-bottom: 60px;">Orang Tua/Wali</p>
                    <p style="text-decoration: underline; font-weight: bold; margin: 0;">_____________________</p>
                </td>
                <td style="width: 34%;">
                    <p style="margin-bottom: 5px;">Mengetahui</p>
                    <p style="margin-bottom: 10px;">Kepala Madrasah</p>
                    @if($qrCode)
                        <img src="{{ $qrCode }}" style="margin-bottom: 5px;">
                    @else
                        <div class="signature-space"></div>
                    @endif
                    <p style="text-decoration: underline; font-weight: bold; margin: 0;">{{ $pengaturan->nama_kepsek ?? 'H. YADI MULYADI, S.Ag' }}</p>
                    <p style="margin: 0; font-size: 10px;">NIP. {{ $pengaturan->nip_kepsek ?? '-' }}</p>
                </td>
                <td style="width: 33%;">
                    <p style="margin-bottom: 5px;">CIAMIS, {{ $tanggal_cetak }}</p>
                    <p style="margin-bottom: 60px;">Wali Kelas</p>
                    <p style="text-decoration: underline; font-weight: bold; margin: 0;">{{ $kelas->waliKelas->nama_guru ?? 'Wali Kelas' }}</p>
                    <p style="margin: 0; font-size: 10px;">NIP. {{ $kelas->waliKelas->npp ?? '-' }}</p>
                </td>
            </tr>
        </table>
    </div>

    <!-- Footer Halaman 2 -->
    <div class="footer-page">
        <div class="footer-left">
            {{ $kelas->nama_kelas ?? '-' }} _ {{ strtoupper($siswa->nama_lengkap) }} _ {{ $pendaftaran->nis ?? '-' }}
        </div>
        <div class="footer-right">
            Halaman 2
        </div>
    </div>

</body>
</html>

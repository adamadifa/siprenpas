@php
    $is_export = $is_export ?? false;
@endphp
<!DOCTYPE html>
<html lang="id" @if($is_export) xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40" @endif>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Presensi Karyawan - {{ $karyawan->nama_lengkap }} ({{ !empty($bulan) ? getNamaBulan($bulan) : '' }} {{ $tahun ?? date('Y') }})</title>



    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css">

    <style>
        :root {
            --primary: #047857;
            --primary-dark: #064e3b;
            --primary-light: #ecfdf5;
            --primary-border: #a7f3d0;
            --text-main: #0f172a;
            --text-secondary: #334155;
            --text-muted: #64748b;
            --border-color: #cbd5e1;
            --border-light: #e2e8f0;
            --bg-zebra: #f8fafc;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', 'Inter', Calibri, Arial, sans-serif;
            color: var(--text-main);
            background-color: #0f172a08;
            background-image: radial-gradient(#cbd5e1 1px, transparent 1px);
            background-size: 20px 20px;
            font-size: 11px;
            line-height: 1.4;
            -webkit-font-smoothing: antialiased;
            min-height: 100vh;
        }

        .mso-text {
            mso-number-format: "\@";
        }

        /* Floating Action Toolbar */
        .print-toolbar {
            position: fixed;
            top: 18px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(15, 23, 42, 0.92);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            padding: 8px 18px;
            border-radius: 9999px;
            box-shadow: 0 20px 35px -5px rgba(0, 0, 0, 0.35), 0 0 0 1px rgba(255, 255, 255, 0.15);
        }

        .print-toolbar .toolbar-info {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #94a3b8;
            font-size: 11px;
            font-weight: 500;
            padding-right: 12px;
            border-right: 1px solid rgba(255, 255, 255, 0.15);
        }

        .print-toolbar .toolbar-info i {
            color: #34d399;
            font-size: 16px;
        }

        .print-toolbar .btn-tool {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 16px;
            border-radius: 9999px;
            font-size: 11.5px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.15s ease-in-out;
            white-space: nowrap;
        }

        .print-toolbar .btn-print {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.35);
        }

        .print-toolbar .btn-print:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            transform: translateY(-1px);
        }

        .print-toolbar .btn-excel {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.35);
        }

        .print-toolbar .btn-excel:hover {
            background: linear-gradient(135deg, #047857 0%, #064e3b 100%);
            transform: translateY(-1px);
        }

        .print-toolbar .btn-close-view {
            background: rgba(255, 255, 255, 0.12);
            color: #f8fafc;
        }

        .print-toolbar .btn-close-view:hover {
            background: rgba(255, 255, 255, 0.22);
            color: #ffffff;
        }

        /* Document Sheet Container (A4 Portrait Style) */
        .sheet-container {
            width: 90%;
            max-width: 960px;
            margin: 72px auto 48px auto;
            background: #ffffff;
            padding: 40px 48px;
            border-radius: 14px;
            box-shadow: 0 16px 40px -10px rgba(0, 0, 0, 0.08), 0 0 0 1px rgba(0, 0, 0, 0.04);
            position: relative;
        }

        /* Kop Surat */
        .kop-surat {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 12px;
            gap: 20px;
        }

        .kop-logo {
            width: 72px;
            height: 72px;
            object-fit: contain;
            flex-shrink: 0;
        }

        .kop-text {
            text-align: center;
            flex-grow: 1;
        }

        .kop-text .instansi-yayasan {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--primary);
            margin-bottom: 2px;
        }

        .kop-text .instansi-nama {
            font-size: 18px;
            font-weight: 800;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            line-height: 1.25;
            margin-bottom: 3px;
        }

        .kop-text .instansi-alamat {
            font-size: 10.5px;
            color: var(--text-muted);
            line-height: 1.4;
        }

        .kop-divider {
            border: none;
            border-top: 2.5px solid #0f172a;
            border-bottom: 0.75px solid #0f172a;
            height: 4.5px;
            margin-bottom: 18px;
        }

        /* Header Dokumen Title */
        .doc-header-box {
            text-align: center;
            margin-bottom: 20px;
        }

        .doc-header-box .doc-title {
            font-size: 16px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #064e3b;
            margin-bottom: 4px;
        }

        .doc-header-box .doc-subtitle {
            font-size: 11.5px;
            color: var(--text-muted);
            font-weight: 500;
        }

        /* Employee Identity Card */
        .employee-card {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 14px 20px;
            margin-bottom: 20px;
            gap: 20px;
        }

        .emp-bio-table {
            border-collapse: collapse;
            font-size: 11px;
        }

        .emp-bio-table td {
            padding: 3px 6px;
            vertical-align: top;
        }

        .emp-bio-table td.label {
            color: #64748b;
            font-weight: 600;
            width: 90px;
        }

        .emp-bio-table td.colon {
            color: #94a3b8;
            width: 10px;
            text-align: center;
        }

        .emp-bio-table td.value {
            color: #0f172a;
            font-weight: 700;
        }

        /* Monthly Summary Counters */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 10px;
            text-align: center;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02);
        }

        .stat-card.stat-h { border-top: 3px solid #059669; }
        .stat-card.stat-t { border-top: 3px solid #d97706; }
        .stat-card.stat-i { border-top: 3px solid #b45309; }
        .stat-card.stat-s { border-top: 3px solid #be185d; }
        .stat-card.stat-a { border-top: 3px solid #dc2626; }

        .stat-label {
            font-size: 9.5px;
            font-weight: 700;
            text-transform: uppercase;
            color: #64748b;
            margin-bottom: 3px;
        }

        .stat-value {
            font-family: 'JetBrains Mono', monospace;
            font-size: 18px;
            font-weight: 800;
            line-height: 1;
        }

        .stat-h .stat-value { color: #059669; }
        .stat-t .stat-value { color: #d97706; }
        .stat-i .stat-value { color: #b45309; }
        .stat-s .stat-value { color: #be185d; }
        .stat-a .stat-value { color: #dc2626; }

        /* Table Presensi Perorangan */
        .table-responsive-wrapper {
            overflow-x: auto;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
            background: #fff;
            margin-bottom: 24px;
        }

        .table-personal {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
            font-family: inherit;
        }

        .table-personal th {
            background-color: #064e3b;
            color: #ffffff;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.02em;
            padding: 8px 10px;
            text-align: center;
            border: 1px solid #047857;
            font-size: 10px;
            white-space: nowrap;
        }

        .table-personal td {
            border: 1px solid #e2e8f0;
            padding: 7px 10px;
            vertical-align: middle;
            font-size: 10.5px;
        }

        .table-personal tbody tr:nth-child(even) {
            background-color: #fbfcfd;
        }

        .table-personal tbody tr:hover {
            background-color: #f0fdf4;
        }

        /* Sekat Pemisah Antar Bulan */
        .tr-month-separator td {
            background: linear-gradient(90deg, #ecfdf5 0%, #f0fdf4 100%) !important;
            padding: 9px 14px !important;
            border-top: 2px solid #059669 !important;
            border-bottom: 1.5px solid #a7f3d0 !important;
            font-size: 11px !important;
            font-weight: 800 !important;
            color: #065f46 !important;
            letter-spacing: 0.03em;
            text-transform: uppercase;
        }

        .tr-month-separator .month-title {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .tr-month-separator .month-badge {
            background: #059669;
            color: #ffffff;
            font-size: 9px;
            padding: 2px 7px;
            border-radius: 4px;
            font-weight: 700;
        }

        .td-center { text-align: center; }
        .td-mono { font-family: 'JetBrains Mono', monospace; }

        .badge-status {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 9999px;
            font-size: 9.5px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .badge-h { background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; }
        .badge-i { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
        .badge-s { background: #fce7f3; color: #9d174d; border: 1px solid #fbcfe8; }
        .badge-c { background: #e0f2fe; color: #075985; border: 1px solid #bae6fd; }
        .badge-a { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
        .badge-libur { background: #f1f5f9; color: #64748b; }

        .late-text {
            display: inline-block;
            color: #dc2626;
            font-weight: 700;
            font-size: 10px;
            font-family: 'JetBrains Mono', monospace;
        }

        /* Footer Tanda Tangan */
        .footer-ttd-container {
            margin-top: 36px;
            display: flex;
            justify-content: space-between;
            padding: 0 30px;
        }

        .ttd-box {
            text-align: center;
            width: 220px;
            font-size: 11px;
        }

        .ttd-box .ttd-space {
            height: 65px;
        }

        .ttd-box .ttd-name {
            font-weight: 700;
            text-decoration: underline;
            color: #0f172a;
        }

        .ttd-box .ttd-sub {
            color: #64748b;
            font-size: 10px;
            margin-top: 2px;
        }

        /* Print Settings */
        @media print {
            body {
                background: #ffffff !important;
                font-size: 9.5px;
            }

            .print-toolbar {
                display: none !important;
            }

            .sheet-container {
                width: 100% !important;
                max-width: none !important;
                margin: 0 !important;
                padding: 10px 0 !important;
                box-shadow: none !important;
                border-radius: 0 !important;
            }

            .table-responsive-wrapper {
                overflow: visible !important;
                border: 1px solid #334155 !important;
                border-radius: 0 !important;
            }

            .table-personal th {
                background-color: #064e3b !important;
                color: #ffffff !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .table-personal td {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

        /* Excel-specific layout overrides */
        @if($is_export)
        body {
            background: #ffffff !important;
            font-family: Calibri, 'Segoe UI', Arial, sans-serif !important;
        }

        .sheet-container-excel {
            width: 100% !important;
            max-width: 100% !important;
            margin: 0 !important;
            padding: 10px !important;
            background: #ffffff !important;
        }

        .table-responsive-wrapper {
            overflow: visible !important;
            border: none !important;
            box-shadow: none !important;
        }

        .table-personal {
            border: 1px solid #000000 !important;
        }

        .table-personal th {
            background-color: #064e3b !important;
            color: #ffffff !important;
            border: 1px solid #000000 !important;
            font-weight: bold !important;
        }

        .table-personal td {
            border: 1px solid #000000 !important;
        }

        .tr-month-separator td {
            background-color: #d1fae5 !important;
            color: #064e3b !important;
            font-weight: bold !important;
            border: 1px solid #000000 !important;
        }
        @endif

        @page {
            size: A4 portrait;
            margin: 10mm 8mm;
        }
    </style>
</head>

<body>

@if(!$is_export)
    <!-- Floating Top Toolbar -->
    <div class="print-toolbar">
        <div class="toolbar-info">
            <i class="ti ti-user-check"></i>
            <span>Presensi Perorangan: {{ $karyawan->nama_lengkap }}</span>
        </div>
        <button onclick="window.print()" class="btn-tool btn-print">
            <i class="ti ti-printer"></i>
            <span>Cetak / Simpan PDF</span>
        </button>
        <form method="POST" action="{{ route('laporanmsdm.cetakpresensi') }}" target="_blank" style="margin: 0; padding: 0;">
            @csrf
            <input type="hidden" name="presensi_tipe_periode" value="{{ request('presensi_tipe_periode') }}">
            <input type="hidden" name="npp" value="{{ $karyawan->npp }}">
            <input type="hidden" name="dari" value="{{ $periode_dari }}">
            <input type="hidden" name="sampai" value="{{ $periode_sampai }}">
            <input type="hidden" name="bulan" value="{{ $bulan ?? '' }}">
            <input type="hidden" name="tahun" value="{{ $tahun ?? '' }}">
            <input type="hidden" name="exportButton" value="1">
            <button type="submit" class="btn-tool btn-excel">
                <i class="ti ti-file-spreadsheet"></i>
                <span>Download Excel</span>
            </button>
        </form>
        <button onclick="window.close()" class="btn-tool btn-close-view">
            <i class="ti ti-x"></i>
            <span>Tutup</span>
        </button>
    </div>
    @endif

    <!-- Sheet Container -->
    <div class="{{ $is_export ? 'sheet-container-excel' : 'sheet-container' }}">
        
        <!-- Kop Surat Resmi -->
        <div class="kop-surat">
            <img src="{{ asset('assets/img/logo/persisalamin.png') }}" alt="Logo" class="kop-logo">
            <div class="kop-text">
                <div class="instansi-yayasan">Pimpinan Cabang Persatuan Islam Sindangkasih</div>
                <div class="instansi-nama">Pesantren Persatuan Islam 80 Al-Amin</div>
                <div class="instansi-alamat">Jln. Raya Ancol No. 27 Sindangkasih - Ciamis, Jawa Barat | Telp: (0265) 771234</div>
            </div>
            <div style="width: 72px;"></div>
        </div>

        <hr class="kop-divider">

        <!-- Judul Dokumen -->
        <div class="doc-header-box">
            <h1 class="doc-title">Laporan Presensi Karyawan</h1>
            <p class="doc-subtitle">
                Periode: <strong>{{ DateToIndo($periode_dari) }}</strong> s/d <strong>{{ DateToIndo($periode_sampai) }}</strong>
            </p>
        </div>

        <!-- Kartu Identitas Karyawan -->
        @if($is_export)
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 16px;">
            <tr>
                <td style="width: 90px; color: #475569; font-weight: bold; padding: 3px 6px;">NPP</td>
                <td style="width: 10px; text-align: center;">:</td>
                <td style="font-weight: bold; padding: 3px 6px;" class="mso-text">{{ $karyawan->npp }}</td>
                <td style="width: 20px;"></td>
                <td style="width: 90px; color: #475569; font-weight: bold; padding: 3px 6px;">Unit Kerja</td>
                <td style="width: 10px; text-align: center;">:</td>
                <td style="font-weight: bold; padding: 3px 6px;">{{ $karyawan->nama_unit ?? '-' }}</td>
            </tr>
            <tr>
                <td style="color: #475569; font-weight: bold; padding: 3px 6px;">Nama Lengkap</td>
                <td style="text-align: center;">:</td>
                <td style="font-weight: bold; padding: 3px 6px;">{{ $karyawan->nama_lengkap }}</td>
                <td></td>
                <td style="color: #475569; font-weight: bold; padding: 3px 6px;">Status Kerja</td>
                <td style="text-align: center;">:</td>
                <td style="font-weight: bold; padding: 3px 6px;">{{ $karyawan->status_karyawan == 'K' ? 'Kontrak' : ($karyawan->status_karyawan == 'T' ? 'Tetap' : 'Karyawan') }}</td>
            </tr>
            <tr>
                <td style="color: #475569; font-weight: bold; padding: 3px 6px;">Jabatan</td>
                <td style="text-align: center;">:</td>
                <td style="font-weight: bold; padding: 3px 6px;">{{ $karyawan->nama_jabatan ?? '-' }}</td>
                <td></td>
                <td style="color: #475569; font-weight: bold; padding: 3px 6px;">Periode</td>
                <td style="text-align: center;">:</td>
                <td style="font-weight: bold; padding: 3px 6px;">
                    @if (!empty($periode_dari) && !empty($periode_sampai) && date('Y-m', strtotime($periode_dari)) !== date('Y-m', strtotime($periode_sampai)))
                        {{ DateToIndo($periode_dari) }} s/d {{ DateToIndo($periode_sampai) }}
                    @else
                        {{ !empty($bulan) ? getNamaBulan($bulan) : '' }} {{ $tahun ?? date('Y') }}
                    @endif
                </td>
            </tr>
        </table>
        @else
        <div class="employee-card">
            <table class="emp-bio-table">
                <tr>
                    <td class="label">NPP</td>
                    <td class="colon">:</td>
                    <td class="value td-mono mso-text">{{ $karyawan->npp }}</td>
                </tr>
                <tr>
                    <td class="label">Nama Lengkap</td>
                    <td class="colon">:</td>
                    <td class="value">{{ $karyawan->nama_lengkap }}</td>
                </tr>
                <tr>
                    <td class="label">Jabatan</td>
                    <td class="colon">:</td>
                    <td class="value">{{ $karyawan->nama_jabatan ?? '-' }}</td>
                </tr>
            </table>

            <table class="emp-bio-table">
                <tr>
                    <td class="label">Unit Kerja</td>
                    <td class="colon">:</td>
                    <td class="value">{{ $karyawan->nama_unit ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Status Kerja</td>
                    <td class="colon">:</td>
                    <td class="value">{{ $karyawan->status_karyawan == 'K' ? 'Kontrak' : ($karyawan->status_karyawan == 'T' ? 'Tetap' : 'Karyawan') }}</td>
                </tr>
                <tr>
                    <td class="label">Periode</td>
                    <td class="colon">:</td>
                    <td class="value">
                        @if (!empty($periode_dari) && !empty($periode_sampai) && date('Y-m', strtotime($periode_dari)) !== date('Y-m', strtotime($periode_sampai)))
                            {{ DateToIndo($periode_dari) }} s/d {{ DateToIndo($periode_sampai) }}
                        @else
                            {{ !empty($bulan) ? getNamaBulan($bulan) : '' }} {{ $tahun ?? date('Y') }}
                        @endif
                    </td>
                </tr>
            </table>
        </div>
        @endif

        <!-- Kartu Statistik Kehadiran Bulanan -->
        @if($is_export)
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 16px; border: 1px solid #cbd5e1;">
            <thead>
                <tr style="background-color: #f1f5f9; text-align: center;">
                    <th style="padding: 6px; border: 1px solid #cbd5e1; font-size: 10px; color: #059669; font-weight: bold;">HADIR</th>
                    <th style="padding: 6px; border: 1px solid #cbd5e1; font-size: 10px; color: #d97706; font-weight: bold;">TERLAMBAT</th>
                    <th style="padding: 6px; border: 1px solid #cbd5e1; font-size: 10px; color: #b45309; font-weight: bold;">IZIN / CUTI</th>
                    <th style="padding: 6px; border: 1px solid #cbd5e1; font-size: 10px; color: #be185d; font-weight: bold;">SAKIT</th>
                    <th style="padding: 6px; border: 1px solid #cbd5e1; font-size: 10px; color: #dc2626; font-weight: bold;">ALPA</th>
                </tr>
            </thead>
            <tbody>
                <tr style="text-align: center; font-size: 14px; font-weight: bold;">
                    <td style="padding: 8px; border: 1px solid #cbd5e1; color: #059669;">{{ $stats['hadir'] }}</td>
                    <td style="padding: 8px; border: 1px solid #cbd5e1; color: #d97706;">{{ $stats['terlambat'] }}</td>
                    <td style="padding: 8px; border: 1px solid #cbd5e1; color: #b45309;">{{ $stats['izin'] + $stats['cuti'] }}</td>
                    <td style="padding: 8px; border: 1px solid #cbd5e1; color: #be185d;">{{ $stats['sakit'] }}</td>
                    <td style="padding: 8px; border: 1px solid #cbd5e1; color: #dc2626;">{{ $stats['alpa'] }}</td>
                </tr>
            </tbody>
        </table>
        @else
        <div class="stat-grid">
            <div class="stat-card stat-h">
                <div class="stat-label">Hadir</div>
                <div class="stat-value">{{ $stats['hadir'] }}</div>
            </div>
            <div class="stat-card stat-t">
                <div class="stat-label">Terlambat</div>
                <div class="stat-value">{{ $stats['terlambat'] }}</div>
            </div>
            <div class="stat-card stat-i">
                <div class="stat-label">Izin / Cuti</div>
                <div class="stat-value">{{ $stats['izin'] + $stats['cuti'] }}</div>
            </div>
            <div class="stat-card stat-s">
                <div class="stat-label">Sakit</div>
                <div class="stat-value">{{ $stats['sakit'] }}</div>
            </div>
            <div class="stat-card stat-a">
                <div class="stat-label">Alpa</div>
                <div class="stat-value">{{ $stats['alpa'] }}</div>
            </div>
        </div>
        @endif

        <!-- Tabel Rincian Presensi Harian -->
        <div class="table-responsive-wrapper">
            <table class="table-personal">
                <thead>
                    <tr>
                        <th style="width: 35px;">No</th>
                        <th style="width: 120px; text-align: left; padding-left: 12px;">Hari & Tanggal</th>
                        <th style="width: 110px;">Jadwal Shift</th>
                        <th style="width: 75px;">Scan Masuk</th>
                        <th style="width: 75px;">Scan Pulang</th>
                        <th style="width: 110px;">Status Kehadiran</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $t_curr = strtotime($periode_dari);
                        $t_end = strtotime($periode_sampai);
                        $no = 1;
                        $max_loop = 1500;
                        $loop_count = 0;
                        $last_month_year = null;
                        $is_multi_month = date('Y-m', $t_curr) !== date('Y-m', $t_end);
                    @endphp
                    @while ($t_curr <= $t_end && $loop_count < $max_loop)
                        @php
                            $loop_count++;
                            $curr_date = date('Y-m-d', $t_curr);
                            $curr_month_year = date('Y-m', $t_curr);
                            $cell = $presensi_by_date[$curr_date] ?? null;
                            $day_name = getHari($curr_date);
                            $is_sunday = date('N', $t_curr) == 7;
                        @endphp

                        @if ($is_multi_month && $curr_month_year !== $last_month_year)
                            @php
                                $last_month_year = $curr_month_year;
                                $m_num = (int) date('m', $t_curr);
                                $m_year = date('Y', $t_curr);
                            @endphp
                            <tr class="tr-month-separator">
                                <td colspan="7">
                                    <div class="month-title">
                                        <span class="month-badge">BULAN</span>
                                        <span>{{ getNamaBulan($m_num) }} {{ $m_year }}</span>
                                    </div>
                                </td>
                            </tr>
                        @endif

                        <tr>
                            <td class="td-center">{{ $no++ }}</td>
                            <td style="font-weight: 600;">
                                <div class="{{ $is_sunday ? 'text-red-600 font-bold' : '' }}">{{ $day_name }}</div>
                                <div style="font-size: 9.5px; color: #64748b;">{{ date('d-m-Y', $t_curr) }}</div>
                            </td>

                            @if ($cell)
                                @if ($cell['status'] == 'h')
                                    @php
                                        $jam_masuk = $curr_date . ' ' . $cell['jam_masuk'];
                                        $jam_in = !empty($cell['jam_in']) ? date('H:i', strtotime($cell['jam_in'])) : null;
                                        $jam_out = !empty($cell['jam_out']) ? date('H:i', strtotime($cell['jam_out'])) : null;
                                        $terlambat = hitungjamterlambat($cell['jam_in'], $jam_masuk);
                                    @endphp
                                    <td class="td-center">
                                        <div style="font-weight: 700;">{{ $cell['nama_jam_kerja'] ?: 'Reguler' }}</div>
                                        <div style="font-size: 9px; color: #64748b;" class="td-mono">
                                            {{ substr($cell['jam_masuk'], 0, 5) }} - {{ substr($cell['jam_pulang'], 0, 5) }}
                                        </div>
                                    </td>
                                    <td class="td-center td-mono mso-text" style="color: #059669; font-weight: 700;">
                                        {{ $jam_in ?: '-' }}
                                    </td>
                                    <td class="td-center td-mono mso-text" style="color: #0284c7; font-weight: 700;">
                                        {{ $jam_out ?: '-' }}
                                    </td>
                                    <td class="td-center">
                                        <span class="badge-status badge-h">Hadir</span>
                                    </td>
                                    <td>
                                        @if ($terlambat != null && isset($terlambat['menitterlambat']) && $terlambat['menitterlambat'] > 0)
                                            <span class="late-text">Terlambat {{ $terlambat['menitterlambat'] }} menit</span>
                                        @else
                                            <span style="color: #059669; font-weight: 600;">Tepat Waktu</span>
                                        @endif
                                        @if(!empty($cell['keterangan_izin_absen']))
                                            <span style="color: #64748b;"> &bull; {{ $cell['keterangan_izin_absen'] }}</span>
                                        @endif
                                    </td>
                                @elseif ($cell['status'] == 'i')
                                    <td class="td-center">-</td>
                                    <td class="td-center">-</td>
                                    <td class="td-center">-</td>
                                    <td class="td-center">
                                        <span class="badge-status badge-i">Izin</span>
                                    </td>
                                    <td>{{ $cell['keterangan_izin_absen'] ?: 'Izin tidak masuk kerja' }}</td>
                                @elseif ($cell['status'] == 's')
                                    <td class="td-center">-</td>
                                    <td class="td-center">-</td>
                                    <td class="td-center">-</td>
                                    <td class="td-center">
                                        <span class="badge-status badge-s">Sakit</span>
                                    </td>
                                    <td>{{ $cell['keterangan_izin_sakit'] ?: 'Sakit dengan keterangan' }}</td>
                                @elseif ($cell['status'] == 'c')
                                    <td class="td-center">-</td>
                                    <td class="td-center">-</td>
                                    <td class="td-center">-</td>
                                    <td class="td-center">
                                        <span class="badge-status badge-c">Cuti</span>
                                    </td>
                                    <td>{{ $cell['keterangan_izin_cuti'] ?: 'Cuti kerja tahunan/khusus' }}</td>
                                @elseif ($cell['status'] == 'a')
                                    <td class="td-center">-</td>
                                    <td class="td-center">-</td>
                                    <td class="td-center">-</td>
                                    <td class="td-center">
                                        <span class="badge-status badge-a">Alpa</span>
                                    </td>
                                    <td style="color: #dc2626;">Tanpa Keterangan</td>
                                @else
                                    <td class="td-center">-</td>
                                    <td class="td-center">-</td>
                                    <td class="td-center">-</td>
                                    <td class="td-center">-</td>
                                    <td>-</td>
                                @endif
                            @else
                                <td class="td-center">-</td>
                                <td class="td-center">-</td>
                                <td class="td-center">-</td>
                                <td class="td-center">
                                    <span class="badge-status badge-libur">{{ $is_sunday ? 'Libur' : '-' }}</span>
                                </td>
                                <td style="color: #94a3b8;">{{ $is_sunday ? 'Hari Libur Mingguan' : '-' }}</td>
                            @endif
                        </tr>
                        @php
                            $t_curr = strtotime('+1 day', $t_curr);
                        @endphp
                    @endwhile
                </tbody>
            </table>
        </div>

        <!-- Area Tanda Tangan Dokumen -->
        <div class="footer-ttd-container">
            <div class="ttd-box">
                <div>Mengetahui,</div>
                <div class="ttd-sub">Karyawan yang bersangkutan,</div>
                <div class="ttd-space"></div>
                <div class="ttd-name">{{ $karyawan->nama_lengkap }}</div>
                <div class="ttd-sub">NPP. {{ $karyawan->npp }}</div>
            </div>

            <div class="ttd-box">
                <div>Sindangkasih, {{ DateToIndo(date('Y-m-d')) }}</div>
                <div class="ttd-sub">Kepala Bagian MSDM / Personalia,</div>
                <div class="ttd-space"></div>
                <div class="ttd-name">___________________________</div>
                <div class="ttd-sub">NIP / NPP. ................................</div>
            </div>
        </div>

    </div>

</body>
</html>

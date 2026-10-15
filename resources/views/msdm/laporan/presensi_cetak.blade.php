@php
    $is_export = $is_export ?? false;
@endphp
<!DOCTYPE html>
<html lang="id" @if($is_export) xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40" @endif>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rekap Presensi Karyawan ({{ date('d-m-Y', strtotime($periode_dari)) }} s/d {{ date('d-m-Y', strtotime($periode_sampai)) }})</title>



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
            line-height: 1.35;
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

        /* Document Sheet Container */
        .sheet-container {
            width: 98%;
            max-width: 100%;
            margin: 72px auto 48px auto;
            background: #ffffff;
            padding: 32px 36px;
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

        /* Header Dokumen Title & Metadata */
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
            font-size: 11px;
            color: var(--text-muted);
            font-weight: 500;
        }

        /* Legend Badges */
        .legend-bar {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 8px 16px;
            padding: 10px 16px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            margin-bottom: 16px;
            font-size: 10px;
            color: #475569;
        }

        .legend-item {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-weight: 600;
        }

        .legend-dot {
            width: 10px;
            height: 10px;
            border-radius: 3px;
        }

        /* Table Presensi */
        .table-responsive-wrapper {
            overflow-x: auto;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
            background: #fff;
        }

        .table-presensi {
            width: 100%;
            border-collapse: collapse;
            font-size: 10.5px;
            font-family: inherit;
        }

        .table-presensi th {
            background-color: #064e3b;
            color: #ffffff;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.02em;
            padding: 6px 4px;
            text-align: center;
            border: 1px solid #047857;
            font-size: 10px;
            white-space: nowrap;
        }

        .table-presensi th.th-fixed {
            background-color: #046c4e;
            position: sticky;
            left: 0;
            z-index: 2;
        }

        .table-presensi th.th-date {
            min-width: 82px;
            font-weight: 600;
        }

        .table-presensi th.th-sunday {
            background-color: #991b1b !important;
            border-color: #b91c1c !important;
        }

        .table-presensi td {
            border: 1px solid #e2e8f0;
            padding: 5px 4px;
            vertical-align: middle;
            font-size: 10px;
        }

        .table-presensi tbody tr:nth-child(even) {
            background-color: #fbfcfd;
        }

        .table-presensi tbody tr:hover {
            background-color: #f0fdf4;
        }

        /* ========================================================= */
        /* STICKY FREEZE COLUMNS (No, NPP, Nama, Jabatan, Unit)      */
        /* ========================================================= */
        .col-freeze-no {
            position: sticky;
            left: 0;
            width: 35px;
            min-width: 35px;
            max-width: 35px;
            z-index: 5;
        }

        .col-freeze-npp {
            position: sticky;
            left: 35px;
            width: 75px;
            min-width: 75px;
            max-width: 75px;
            z-index: 5;
        }

        .col-freeze-nama {
            position: sticky;
            left: 110px; /* 35px + 75px */
            width: 155px;
            min-width: 155px;
            max-width: 155px;
            z-index: 5;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .col-freeze-jabatan {
            position: sticky;
            left: 265px; /* 110px + 155px */
            width: 120px;
            min-width: 120px;
            max-width: 120px;
            z-index: 5;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .col-freeze-unit {
            position: sticky;
            left: 385px; /* 265px + 120px */
            width: 140px;
            min-width: 140px;
            max-width: 140px;
            z-index: 5;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            border-right: 2px solid #047857 !important;
            box-shadow: 4px 0 8px -3px rgba(0, 0, 0, 0.12);
        }

        /* Specific Z-Index for Headers */
        .table-presensi thead th.col-freeze-no,
        .table-presensi thead th.col-freeze-npp,
        .table-presensi thead th.col-freeze-nama,
        .table-presensi thead th.col-freeze-jabatan,
        .table-presensi thead th.col-freeze-unit {
            z-index: 25 !important;
            background-color: #064e3b !important;
        }

        .table-presensi thead th.col-freeze-unit {
            border-right: 2px solid #047857 !important;
        }

        /* Body Cells in Frozen Columns maintain opaque backgrounds */
        .table-presensi tbody td.col-freeze-no,
        .table-presensi tbody td.col-freeze-npp,
        .table-presensi tbody td.col-freeze-nama,
        .table-presensi tbody td.col-freeze-jabatan,
        .table-presensi tbody td.col-freeze-unit {
            background-color: #ffffff;
        }

        .table-presensi tbody tr:nth-child(even) td.col-freeze-no,
        .table-presensi tbody tr:nth-child(even) td.col-freeze-npp,
        .table-presensi tbody tr:nth-child(even) td.col-freeze-nama,
        .table-presensi tbody tr:nth-child(even) td.col-freeze-jabatan,
        .table-presensi tbody tr:nth-child(even) td.col-freeze-unit {
            background-color: #fbfcfd !important;
        }

        .table-presensi tbody tr:hover td.col-freeze-no,
        .table-presensi tbody tr:hover td.col-freeze-npp,
        .table-presensi tbody tr:hover td.col-freeze-nama,
        .table-presensi tbody tr:hover td.col-freeze-jabatan,
        .table-presensi tbody tr:hover td.col-freeze-unit {
            background-color: #f0fdf4 !important;
        }

        /* Fixed Employee Info Columns */
        .td-center {
            text-align: center;
        }

        .td-emp-name {
            font-weight: 700;
            color: #0f172a;
            white-space: nowrap;
            padding: 5px 8px !important;
        }

        .td-emp-sub {
            font-size: 9.5px;
            color: #64748b;
            font-weight: 500;
            white-space: nowrap;
        }

        /* Attendance Day Cell Styles */
        .day-cell {
            text-align: center;
            line-height: 1.25;
            padding: 4px 3px;
        }

        .day-cell .shift-name {
            font-weight: 700;
            font-size: 9px;
            color: #0f172a;
            margin-bottom: 2px;
            text-transform: uppercase;
            letter-spacing: -0.01em;
        }

        .day-cell .time-scan {
            font-family: 'JetBrains Mono', monospace;
            font-size: 9.5px;
            font-weight: 600;
        }

        .time-scan .time-in {
            color: #059669;
        }

        .time-scan .time-out {
            color: #0284c7;
        }

        .time-scan .time-empty {
            color: #dc2626;
            font-weight: 700;
        }

        .day-cell .late-badge {
            display: inline-block;
            margin-top: 2px;
            padding: 1px 4px;
            border-radius: 4px;
            background: #fee2e2;
            color: #dc2626;
            font-size: 8.5px;
            font-weight: 700;
            font-family: 'JetBrains Mono', monospace;
        }

        .day-cell .ontime-badge {
            display: inline-block;
            margin-top: 2px;
            padding: 1px 5px;
            border-radius: 4px;
            background: #ecfdf5;
            color: #059669;
            font-size: 8.5px;
            font-weight: 700;
            white-space: nowrap;
        }

        .day-cell .fine-text {
            color: #b91c1c;
            font-size: 8.5px;
            font-weight: 700;
            margin-top: 1px;
            font-family: 'JetBrains Mono', monospace;
        }

        /* Leave & Absence State Colors */
        .cell-izin {
            background-color: #fef3c7 !important;
            color: #92400e !important;
            font-weight: 600;
        }

        .cell-sakit {
            background-color: #fce7f3 !important;
            color: #9d174d !important;
            font-weight: 600;
        }

        .cell-cuti {
            background-color: #e0f2fe !important;
            color: #075985 !important;
            font-weight: 600;
        }

        .cell-alpa {
            background-color: #fee2e2 !important;
            color: #991b1b !important;
            font-weight: 700;
        }

        .cell-empty {
            background-color: #f8fafc;
            color: #cbd5e1;
            text-align: center;
        }

        .status-tag {
            display: inline-block;
            font-weight: 800;
            font-size: 9px;
            text-transform: uppercase;
            padding: 2px 6px;
            border-radius: 4px;
            margin-bottom: 2px;
        }

        .status-tag.tag-izin { background: #fde68a; color: #78350f; }
        .status-tag.tag-sakit { background: #fbcfe8; color: #831843; }
        .status-tag.tag-cuti { background: #bae6fd; color: #0c4a6e; }
        .status-tag.tag-alpa { background: #fecaca; color: #7f1d1d; }

        .status-desc {
            font-size: 8.5px;
            line-height: 1.2;
            max-width: 90px;
            margin: 0 auto;
            word-wrap: break-word;
        }

        /* Total Denda & Summary Counter Columns */
        .td-denda {
            text-align: right;
            font-family: 'JetBrains Mono', monospace;
            font-size: 10px;
            font-weight: 700;
            color: #991b1b;
            padding: 5px 8px !important;
            white-space: nowrap;
        }

        .td-stat {
            text-align: center;
            font-family: 'JetBrains Mono', monospace;
            font-size: 10px;
            font-weight: 700;
            padding: 4px 6px !important;
            white-space: nowrap;
        }

        .td-stat-h { color: #047857; background-color: #f0fdf4; }
        .td-stat-i { color: #b45309; background-color: #fffbeb; }
        .td-stat-s { color: #be185d; background-color: #fdf2f8; }
        .td-stat-c { color: #0369a1; background-color: #f0f9ff; }
        .td-stat-a { color: #b91c1c; background-color: #fef2f2; }

        .th-stat {
            min-width: 38px;
            font-size: 9.5px !important;
            padding: 4px 3px !important;
        }

        /* Footer & Signatures */
        .footer-ttd {
            margin-top: 32px;
            display: flex;
            justify-content: flex-end;
            padding-right: 40px;
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

        .ttd-box .ttd-jabatan {
            color: #64748b;
            font-size: 10px;
            margin-top: 2px;
        }

        /* Print Settings */
        @media print {
            body {
                background: #ffffff !important;
                font-size: 9px;
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

            .table-presensi th {
                background-color: #064e3b !important;
                color: #ffffff !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .table-presensi td {
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

        .table-presensi {
            border: 1px solid #000000 !important;
        }

        .table-presensi th {
            background-color: #064e3b !important;
            color: #ffffff !important;
            border: 1px solid #000000 !important;
            font-weight: bold !important;
        }

        .table-presensi td {
            border: 1px solid #000000 !important;
        }
        @endif

            @page {
                size: A4 landscape;
                margin: 8mm 6mm;
            }
        }
    </style>
</head>

<body>

@if(!$is_export)
    <!-- Floating Top Toolbar for Screen View -->
    <div class="print-toolbar">
        <div class="toolbar-info">
            <i class="ti ti-printer"></i>
            <span>Rekapitulasi Presensi Karyawan</span>
        </div>
        <button onclick="window.print()" class="btn-tool btn-print">
            <i class="ti ti-printer"></i>
            <span>Cetak / Simpan PDF</span>
        </button>
        <form method="POST" action="{{ route('laporanmsdm.cetakpresensi') }}" target="_blank" style="margin: 0; padding: 0;">
            @csrf
            <input type="hidden" name="presensi_tipe_periode" value="{{ request('presensi_tipe_periode') }}">
            <input type="hidden" name="kode_unit" value="{{ request('kode_unit') }}">
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
        
        <!-- Kop Surat -->
        <div class="kop-surat">
            <img src="{{ asset('assets/img/logo/persisalamin.png') }}" alt="Logo" class="kop-logo">
            <div class="kop-text">
                <div class="instansi-yayasan">Pimpinan Cabang Persatuan Islam Sindangkasih</div>
                <div class="instansi-nama">Pesantren Persatuan Islam 80 Al-Amin</div>
                <div class="instansi-alamat">Jln. Raya Ancol No. 27 Sindangkasih - Ciamis, Jawa Barat | Telp: (0265) 771234</div>
            </div>
            <div style="width: 72px;"></div> <!-- Balanced spacer -->
        </div>

        <hr class="kop-divider">

        <!-- Document Title -->
        <div class="doc-header-box">
            <h1 class="doc-title">Laporan Rekapitulasi Presensi Karyawan</h1>
            <p class="doc-subtitle">
                Periode: <strong>{{ DateToIndo($periode_dari) }}</strong> s/d <strong>{{ DateToIndo($periode_sampai) }}</strong> 
                &bull; Total: <strong>{{ count($laporan_presensi) }} Karyawan</strong>
            </p>
        </div>

        <!-- Legend Bar -->
        <div class="legend-bar">
            <span class="text-slate-400 font-bold uppercase text-[9px]">Keterangan:</span>
            <div class="legend-item">
                <span class="legend-dot" style="background: #059669;"></span>
                <span>Masuk (Hijau)</span>
            </div>
            <div class="legend-item">
                <span class="legend-dot" style="background: #0284c7;"></span>
                <span>Pulang (Biru)</span>
            </div>
            <div class="legend-item">
                <span class="legend-dot" style="background: #fee2e2; border: 1px solid #ef4444;"></span>
                <span>Terlambat</span>
            </div>
            <div class="legend-item">
                <span class="legend-dot" style="background: #fde68a;"></span>
                <span>Izin (I)</span>
            </div>
            <div class="legend-item">
                <span class="legend-dot" style="background: #fbcfe8;"></span>
                <span>Sakit (S)</span>
            </div>
            <div class="legend-item">
                <span class="legend-dot" style="background: #bae6fd;"></span>
                <span>Cuti (C)</span>
            </div>
            <div class="legend-item">
                <span class="legend-dot" style="background: #fecaca;"></span>
                <span>Alpa (A)</span>
            </div>
        </div>

        <!-- Table Responsive Wrapper -->
        <div class="table-responsive-wrapper">
            <table class="table-presensi">
                <thead>
                    <tr>
                        <th rowspan="2" class="col-freeze-no">No</th>
                        <th rowspan="2" class="col-freeze-npp">NPP</th>
                        <th rowspan="2" class="col-freeze-nama" style="text-align: left; padding-left: 8px;">Nama Karyawan</th>
                        <th rowspan="2" class="col-freeze-jabatan" style="text-align: left; padding-left: 8px;">Jabatan</th>
                        <th rowspan="2" class="col-freeze-unit">Unit</th>
                        <th colspan="{{ $jmlhari }}">Tanggal Presensi</th>
                        <th colspan="5" style="background-color: #046c4e;">Rekapitulasi</th>
                    </tr>
                    <tr>
                        @php
                            $curr_date = $periode_dari;
                        @endphp
                        @while (strtotime($curr_date) <= strtotime($periode_sampai))
                            @php
                                $day_name = getHari(date('Y-m-d', strtotime($curr_date)));
                                $day_num = date('d', strtotime($curr_date));
                                $is_sunday = date('N', strtotime($curr_date)) == 7;
                            @endphp
                            <th class="th-date {{ $is_sunday ? 'th-sunday' : '' }}">
                                <div>{{ $day_num }}</div>
                                <div style="font-size: 8px; opacity: 0.85;">{{ substr($day_name, 0, 3) }}</div>
                            </th>
                            @php
                                $curr_date = date('Y-m-d', strtotime('+1 day', strtotime($curr_date)));
                            @endphp
                        @endwhile
                        <th class="th-stat" title="Hadir" style="background-color: #047857;">H</th>
                        <th class="th-stat" title="Izin" style="background-color: #b45309;">I</th>
                        <th class="th-stat" title="Sakit" style="background-color: #be185d;">S</th>
                        <th class="th-stat" title="Cuti" style="background-color: #0369a1;">C</th>
                        <th class="th-stat" title="Alpa" style="background-color: #b91c1c;">A</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($laporan_presensi as $d)
                        @php
                            $total_denda = 0;
                            $total_hadir = 0;
                            $total_izin = 0;
                            $total_sakit = 0;
                            $total_cuti = 0;
                            $total_alpa = 0;
                            $curr_date = $periode_dari;
                        @endphp
                        <tr>
                            <td class="col-freeze-no td-center" style="font-weight: 600;">{{ $loop->iteration }}</td>
                            <td class="col-freeze-npp td-center mso-text" style="font-family: 'JetBrains Mono', monospace; font-size: 9.5px; color: #475569;">
                                {{ $d['npp'] }}
                            </td>
                            <td class="col-freeze-nama td-emp-name">
                                {{ $d['nama_lengkap'] }}
                            </td>
                            <td class="col-freeze-jabatan td-emp-sub">
                                {{ $d['nama_jabatan'] ?? '-' }}
                            </td>
                            <td class="col-freeze-unit td-center td-emp-sub">
                                {{ $d['nama_unit'] ?? '-' }}
                            </td>

                            <!-- Loop Dates -->
                            @while (strtotime($curr_date) <= strtotime($periode_sampai))
                                @php
                                    $cell = $d[$curr_date] ?? null;
                                    $is_sunday = date('N', strtotime($curr_date)) == 7;
                                @endphp

                                @if ($cell)
                                    @if ($cell['status'] == 'h')
                                        @php
                                            $total_hadir++;
                                            $jam_masuk = $curr_date . ' ' . $cell['jam_masuk'];
                                            $jam_in = !empty($cell['jam_in']) ? date('H:i', strtotime($cell['jam_in'])) : null;
                                            $jam_out = !empty($cell['jam_out']) ? date('H:i', strtotime($cell['jam_out'])) : null;

                                            $terlambat = hitungjamterlambat($cell['jam_in'], $jam_masuk);
                                            $denda = 0;
                                            if ($terlambat != null && isset($terlambat['menitterlambat']) && $terlambat['menitterlambat'] > 0) {
                                                $denda = hitungdenda($terlambat['menitterlambat'], $d['status_karyawan'] ?? 'T');
                                            }
                                            $total_denda += $denda;
                                        @endphp
                                        <td class="day-cell">
                                            @if (!empty($cell['nama_jam_kerja']))
                                                <div class="shift-name">{{ $cell['nama_jam_kerja'] }}</div>
                                            @endif
                                            
                                            <div class="time-scan">
                                                @if ($jam_in)
                                                    <span class="time-in">{{ $jam_in }}</span>
                                                @else
                                                    <span class="time-empty">&#10008;</span>
                                                @endif
                                                <span style="color: #94a3b8; font-weight: 400;"> - </span>
                                                @if ($jam_out)
                                                    <span class="time-out">{{ $jam_out }}</span>
                                                @else
                                                    <span class="time-empty">&#10008;</span>
                                                @endif
                                            </div>

                                            @if ($terlambat != null && isset($terlambat['menitterlambat']) && $terlambat['menitterlambat'] > 0)
                                                <div class="late-badge">
                                                    {{ $terlambat['menitterlambat'] }}m
                                                </div>
                                            @elseif($jam_in)
                                                <div class="ontime-badge">Tepat Waktu</div>
                                            @endif
                                        </td>
                                    @elseif ($cell['status'] == 'i')
                                        @php $total_izin++; @endphp
                                        <td class="day-cell cell-izin">
                                            <span class="status-tag tag-izin">IZIN</span>
                                            @if(!empty($cell['keterangan_izin_absen']))
                                                <div class="status-desc">{{ Str::limit($cell['keterangan_izin_absen'], 25) }}</div>
                                            @endif
                                        </td>
                                    @elseif ($cell['status'] == 's')
                                        @php $total_sakit++; @endphp
                                        <td class="day-cell cell-sakit">
                                            <span class="status-tag tag-sakit">SAKIT</span>
                                            @if(!empty($cell['keterangan_izin_sakit']))
                                                <div class="status-desc">{{ Str::limit($cell['keterangan_izin_sakit'], 25) }}</div>
                                            @endif
                                        </td>
                                    @elseif ($cell['status'] == 'c')
                                        @php $total_cuti++; @endphp
                                        <td class="day-cell cell-cuti">
                                            <span class="status-tag tag-cuti">CUTI</span>
                                            @if(!empty($cell['keterangan_izin_cuti']))
                                                <div class="status-desc">{{ Str::limit($cell['keterangan_izin_cuti'], 25) }}</div>
                                            @endif
                                        </td>
                                    @elseif ($cell['status'] == 'a')
                                        @php $total_alpa++; @endphp
                                        <td class="day-cell cell-alpa">
                                            <span class="status-tag tag-alpa">ALPA</span>
                                        </td>
                                    @else
                                        <td class="day-cell cell-empty">-</td>
                                    @endif
                                @else
                                    <td class="day-cell cell-empty {{ $is_sunday ? 'bg-red-50/50' : '' }}">
                                        {{ $is_sunday ? 'Libur' : '-' }}
                                    </td>
                                @endif

                                @php
                                    $curr_date = date('Y-m-d', strtotime('+1 day', strtotime($curr_date)));
                                @endphp
                            @endwhile

                            <!-- Summary Columns: Hadir, Izin, Sakit, Cuti, Alpa -->
                            <td class="td-stat td-stat-h">{{ $total_hadir }}</td>
                            <td class="td-stat td-stat-i">{{ $total_izin }}</td>
                            <td class="td-stat td-stat-s">{{ $total_sakit }}</td>
                            <td class="td-stat td-stat-c">{{ $total_cuti }}</td>
                            <td class="td-stat td-stat-a">{{ $total_alpa }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $jmlhari + 10 }}" style="text-align: center; padding: 24px; color: #94a3b8; font-weight: 600;">
                                Tidak ada data presensi untuk kriteria yang dipilih.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Tanda Tangan Section -->
        <div class="footer-ttd">
            <div class="ttd-box">
                <div>Sindangkasih, {{ DateToIndo(date('Y-m-d')) }}</div>
                <div style="font-weight: 600; margin-top: 4px;">Kepala Bagian MSDM / Personalia,</div>
                <div class="ttd-space"></div>
                <div class="ttd-name">___________________________</div>
                <div class="ttd-jabatan">NIP / NPP. ................................</div>
            </div>
        </div>

    </div>

</body>
</html>

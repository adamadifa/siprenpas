<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rekap Tagihan Santri - {{ date('d-m-Y') }}</title>

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
            font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            color: var(--text-main);
            background-color: #0f172a10;
            background-image: radial-gradient(#cbd5e1 1px, transparent 1px);
            background-size: 20px 20px;
            font-size: 10.5px;
            line-height: 1.35;
            -webkit-font-smoothing: antialiased;
            min-height: 100vh;
        }

        /* Floating Action Toolbar (Screen Only) */
        .print-toolbar {
            position: fixed;
            top: 18px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(15, 23, 42, 0.92);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            padding: 8px 16px;
            border-radius: 9999px;
            box-shadow: 0 20px 35px -5px rgba(0, 0, 0, 0.4), 0 0 0 1px rgba(255, 255, 255, 0.15);
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
            font-size: 15px;
        }

        .print-toolbar .freeze-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: rgba(4, 120, 87, 0.4);
            color: #a7f3d0;
            padding: 3px 8px;
            border-radius: 9999px;
            font-size: 10px;
            font-weight: 600;
            border: 1px solid rgba(52, 211, 153, 0.3);
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
            box-shadow: 0 6px 16px rgba(16, 185, 129, 0.45);
        }

        .print-toolbar .btn-close-view {
            background: rgba(255, 255, 255, 0.12);
            color: #f8fafc;
        }
        .print-toolbar .btn-close-view:hover {
            background: rgba(255, 255, 255, 0.22);
            color: #ffffff;
        }

        /* Paper Document Sheet */
        .sheet-container {
            width: 96%;
            max-width: 1540px;
            margin: 72px auto 48px auto;
            background: #ffffff;
            padding: 38px 44px;
            border-radius: 12px;
            box-shadow: 0 16px 40px -10px rgba(0, 0, 0, 0.1), 0 0 0 1px rgba(0, 0, 0, 0.05);
            position: relative;
        }

        /* Kop Surat Resmi */
        .kop-surat {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 12px;
            margin-bottom: 14px;
            gap: 20px;
            position: relative;
        }

        .kop-logo {
            width: 74px;
            height: 74px;
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
            font-size: 17px;
            font-weight: 800;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            line-height: 1.25;
            margin-bottom: 4px;
        }

        .kop-text .instansi-alamat {
            font-size: 10px;
            color: var(--text-muted);
            line-height: 1.45;
        }

        .kop-divider {
            border: none;
            border-top: 2.5px solid #0f172a;
            border-bottom: 0.75px solid #0f172a;
            height: 4.5px;
            margin-bottom: 18px;
        }

        /* Document Title & Metadata Section */
        .doc-header-box {
            text-align: center;
            margin-bottom: 16px;
        }

        .doc-title-wrapper {
            display: inline-block;
            position: relative;
        }

        .doc-title {
            font-size: 13.5px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--primary-dark);
            padding: 5px 20px;
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
            border: 1px solid var(--primary-border);
            border-radius: 9999px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
        }

        /* Metadata Grid */
        .meta-card {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 8px 18px;
            background: #f8fafc;
            border: 1px solid var(--border-light);
            border-radius: 10px;
            padding: 10px 16px;
            margin-bottom: 18px;
            font-size: 10.5px;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .meta-label {
            color: var(--text-muted);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .meta-label i {
            font-size: 13px;
            color: #94a3b8;
        }

        .meta-separator {
            color: #94a3b8;
        }

        .meta-value {
            font-weight: 700;
            color: var(--text-main);
        }

        /* Report Table Styling & Responsive Wrapper */
        .table-responsive-wrapper {
            width: 100%;
            overflow-x: auto;
            position: relative;
            margin-bottom: 22px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
            border-radius: 8px;
            border: 1px solid var(--border-color);
        }

        table.table-report {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 9.5px;
            background: #ffffff;
            white-space: nowrap;
        }

        table.table-report thead th {
            background-color: var(--primary);
            color: #ffffff;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 9px;
            letter-spacing: 0.03em;
            padding: 6px 6px;
            border-right: 1px solid var(--primary-dark);
            border-bottom: 1px solid var(--primary-dark);
            text-align: center;
            vertical-align: middle;
        }

        table.table-report thead tr:first-child th {
            border-top: 1px solid var(--primary-dark);
        }

        table.table-report thead tr th:first-child {
            border-left: 1px solid var(--primary-dark);
        }

        table.table-report thead tr.sub-header th {
            background-color: #065f46;
            font-size: 8.5px;
            padding: 4px 5px;
            border-color: #064e3b;
        }

        table.table-report thead tr.col-header th {
            background-color: #047857;
            font-size: 8px;
            padding: 4px 4px;
            border-color: #064e3b;
        }

        table.table-report thead th.total-group,
        table.table-report thead tr.sub-header th.total-group,
        table.table-report thead tr.col-header th.total-group {
            background-color: #064e3b;
        }

        table.table-report tbody td {
            padding: 5px 6px;
            border-right: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
            color: #1e293b;
            vertical-align: middle;
            background-color: #ffffff;
        }

        table.table-report tbody tr td:first-child {
            border-left: 1px solid var(--border-color);
        }

        table.table-report tbody td.center {
            text-align: center;
        }

        table.table-report tbody td.right,
        table.table-report tfoot th.right {
            text-align: right;
        }

        table.table-report tbody tr:nth-child(even) td {
            background-color: var(--bg-zebra);
        }

        table.table-report tbody tr:hover td {
            background-color: #f1f5f9;
        }

        table.table-report tfoot th {
            background-color: var(--primary-light);
            color: var(--primary-dark);
            font-weight: 800;
            padding: 8px 6px;
            border-right: 1px solid var(--primary-border);
            border-bottom: 1.5px solid var(--primary-border);
            border-top: 1.5px solid var(--primary-border);
            font-size: 10px;
        }

        table.table-report tfoot tr th:first-child {
            border-left: 1px solid var(--primary-border);
        }

        .mono {
            font-family: 'JetBrains Mono', monospace;
            font-variant-numeric: tabular-nums;
            font-weight: 600;
        }

        /* ========================================================= */
        /* STICKY FREEZE COLUMNS (No, NIS, Nama Santri)             */
        /* ========================================================= */
        .col-freeze-no {
            position: sticky;
            left: 0;
            width: 34px;
            min-width: 34px;
            max-width: 34px;
            z-index: 5;
        }

        .col-freeze-nis {
            position: sticky;
            left: 34px;
            width: 76px;
            min-width: 76px;
            max-width: 76px;
            z-index: 5;
        }

        .col-freeze-nama {
            position: sticky;
            left: 110px; /* 34px + 76px */
            width: 175px;
            min-width: 175px;
            max-width: 220px;
            z-index: 5;
            border-right: 2px solid #94a3b8 !important;
            box-shadow: 4px 0 8px -3px rgba(0, 0, 0, 0.14);
        }

        /* Specific Z-Index for Headers */
        table.table-report thead th.col-freeze-no,
        table.table-report thead th.col-freeze-nis,
        table.table-report thead th.col-freeze-nama {
            z-index: 25 !important;
            background-color: var(--primary) !important;
        }

        table.table-report thead th.col-freeze-nama {
            border-right: 2px solid #064e3b !important;
        }

        /* Body Cells in Frozen Columns maintain opaque backgrounds */
        table.table-report tbody td.col-freeze-no,
        table.table-report tbody td.col-freeze-nis,
        table.table-report tbody td.col-freeze-nama {
            background-color: #ffffff;
        }

        table.table-report tbody tr:nth-child(even) td.col-freeze-no,
        table.table-report tbody tr:nth-child(even) td.col-freeze-nis,
        table.table-report tbody tr:nth-child(even) td.col-freeze-nama {
            background-color: var(--bg-zebra) !important;
        }

        table.table-report tbody tr:hover td.col-freeze-no,
        table.table-report tbody tr:hover td.col-freeze-nis,
        table.table-report tbody tr:hover td.col-freeze-nama {
            background-color: #f1f5f9 !important;
        }

        /* Footer Sticky (Spans all 3 frozen columns) */
        .col-freeze-total {
            position: sticky;
            left: 0;
            width: 285px; /* 34 + 76 + 175 */
            min-width: 285px;
            max-width: 285px;
            z-index: 20 !important;
            background-color: var(--primary-light) !important;
            border-right: 2px solid #047857 !important;
            box-shadow: 4px 0 8px -3px rgba(0, 0, 0, 0.14);
        }

        /* Signature Section */
        .signature-section {
            margin-top: 28px;
            display: flex;
            justify-content: space-between;
            page-break-inside: avoid;
        }

        .signature-box {
            width: 230px;
            text-align: center;
            font-size: 10.5px;
        }

        .signature-date {
            color: var(--text-muted);
            margin-bottom: 4px;
            font-size: 10px;
        }

        .signature-role {
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 55px;
        }

        .signature-name {
            font-weight: 800;
            text-decoration: underline;
            color: #0f172a;
        }

        .signature-nip {
            color: var(--text-muted);
            font-size: 9.5px;
            margin-top: 2px;
        }

        /* Print Specific Adjustments */
        @media print {
            body {
                background: #ffffff !important;
                color: #000000 !important;
                font-size: 8pt;
            }

            .no-print,
            .print-toolbar {
                display: none !important;
            }

            .sheet-container {
                width: 100% !important;
                max-width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                box-shadow: none !important;
                border-radius: 0 !important;
            }

            .table-responsive-wrapper {
                overflow: visible !important;
                box-shadow: none !important;
                border: none !important;
            }

            table.table-report {
                font-size: 7.5pt !important;
                border-collapse: collapse !important;
            }

            /* Disable Sticky on Physical Print */
            .col-freeze-no,
            .col-freeze-nis,
            .col-freeze-nama,
            .col-freeze-total {
                position: static !important;
                box-shadow: none !important;
                border-right: 1px solid var(--border-color) !important;
            }

            table.table-report thead th {
                background-color: #047857 !important;
                color: #ffffff !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            table.table-report thead tr.sub-header th,
            table.table-report thead th.total-group {
                background-color: #064e3b !important;
                color: #ffffff !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            table.table-report tfoot th {
                background-color: #ecfdf5 !important;
                color: #064e3b !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .doc-title {
                background-color: #ecfdf5 !important;
                color: #064e3b !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            table.table-report tbody tr:nth-child(even) td {
                background-color: #f8fafc !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .kop-divider {
                border-top: 2px solid #000000 !important;
                border-bottom: 0.5px solid #000000 !important;
            }

            @page {
                size: A4 landscape;
                margin: 8mm 8mm 8mm 8mm;
            }
        }
    </style>
</head>

<body>

    <!-- On-Screen Floating Action Bar -->
    <div class="print-toolbar no-print">
        <div class="toolbar-info">
            <i class="ti ti-file-text"></i>
            <span>Mode Pratinjau Rekap (Landscape)</span>
        </div>
        <div class="freeze-badge">
            <i class="ti ti-pin"></i>
            <span>Kolom Ter-freeze</span>
        </div>
        <button type="button" class="btn-tool btn-print" onclick="window.print()">
            <i class="ti ti-printer"></i>
            <span>Cetak Dokumen</span>
        </button>
        <button type="button" class="btn-tool btn-close-view" onclick="window.close()">
            <i class="ti ti-arrow-left"></i>
            <span>Tutup / Kembali</span>
        </button>
    </div>

    <div class="sheet-container">
        @php
            $namaSekolah = optional($pengaturan)->nama_sekolah ?? 'PESANTREN PERSATUAN ISLAM 80 AL AMIN';
            $alamatSekolah = optional($pengaturan)->alamat_sekolah ?? 'Jln. Raya Ancol No. 27 Sindangkasih - Ciamis';
            $teleponSekolah = optional($pengaturan)->telepon ?? '(0265) 325285';
            $emailSekolah = optional($pengaturan)->email ?? 'persis.alamin80sinkas@gmail.com';
            $websiteSekolah = optional($pengaturan)->website ?? 'persisalamin.com';
            $logoUrl = optional($pengaturan)->logo ? asset('storage/' . $pengaturan->logo) : asset('assets/img/logo/persisalamin.png');
        @endphp

        <!-- Kop Surat -->
        <div class="kop-surat">
            <img src="{{ $logoUrl }}" alt="Logo Instansi" class="kop-logo" onerror="this.style.display='none'">
            <div class="kop-text">
                <div class="instansi-yayasan">Pondok Pesantren Persatuan Islam</div>
                <div class="instansi-nama">{{ strtoupper($namaSekolah) }}</div>
                <div class="instansi-alamat">
                    {{ $alamatSekolah }}
                    @if ($teleponSekolah) • Telp: {{ $teleponSekolah }} @endif
                    <br>
                    Email: {{ $emailSekolah }} @if ($websiteSekolah) • Web: {{ $websiteSekolah }} @endif
                </div>
            </div>
            <div style="width: 74px;" class="no-print"></div>
        </div>
        <div class="kop-divider"></div>

        <!-- Title Section -->
        <div class="doc-header-box">
            <div class="doc-title-wrapper">
                <div class="doc-title">
                    <i class="ti ti-table-alias no-print"></i>
                    <span>Laporan Rekapitulasi Tagihan Biaya Pendidikan</span>
                </div>
            </div>
        </div>

        <!-- Metadata Grid -->
        <div class="meta-card">
            <div class="meta-item">
                <span class="meta-label"><i class="ti ti-calendar"></i> T.A:</span>
                <span class="meta-value">{{ $ta ? $ta->tahun_ajaran : (Request('kode_ta') ?? '-') }}</span>
            </div>
            <div class="meta-item">
                <span class="meta-label"><i class="ti ti-building-bank"></i> Unit:</span>
                <span class="meta-value">{{ $unit ? $unit->nama_unit : (Request('kode_unit') ?? '-') }}</span>
            </div>
            <div class="meta-item">
                <span class="meta-label"><i class="ti ti-layers-subtract"></i> Tingkat:</span>
                <span class="meta-value">{{ Request('tingkat') ? 'Tingkat ' . Request('tingkat') : 'Semua Tingkat' }}</span>
            </div>
            <div class="meta-item">
                <span class="meta-label"><i class="ti ti-users"></i> Total Santri:</span>
                <span class="meta-value">{{ count($rekaptagihan) }} Santri</span>
            </div>
        </div>

        <!-- Main Data Table with Sticky Columns -->
        <div class="table-responsive-wrapper">
            <table class="table-report">
                <thead>
                    <tr>
                        <th rowspan="3" class="center col-freeze-no">No</th>
                        <th rowspan="3" class="center col-freeze-nis">NIS</th>
                        <th rowspan="3" class="col-freeze-nama" style="text-align: left; padding-left: 8px;">Nama Santri</th>
                        <th colspan="{{ count($biaya) * 5 }}">RINCIAN KOMPONEN TAGIHAN</th>
                        <th rowspan="2" colspan="5" class="total-group">TOTAL KESELURUHAN</th>
                    </tr>
                    <tr class="sub-header">
                        @foreach ($biaya as $b)
                            <th colspan="5">{{ $b->jenis_biaya }}</th>
                        @endforeach
                    </tr>
                    <tr class="col-header">
                        @foreach ($biaya as $b)
                            <th class="right">Tagihan</th>
                            <th class="right">Potongan</th>
                            <th class="right">Mutasi</th>
                            <th class="right">Bayar</th>
                            <th class="right">Sisa</th>
                        @endforeach
                        <th class="right total-group">Tagihan</th>
                        <th class="right total-group">Potongan</th>
                        <th class="right total-group">Mutasi</th>
                        <th class="right total-group">Bayar</th>
                        <th class="right total-group">Sisa</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        foreach ($biaya as $b) {
                            ${'total_tagihan_' . $b->kode_jenis_biaya} = 0;
                            ${'total_potongan_' . $b->kode_jenis_biaya} = 0;
                            ${'total_mutasi_' . $b->kode_jenis_biaya} = 0;
                            ${'total_bayar_' . $b->kode_jenis_biaya} = 0;
                            ${'total_sisa_' . $b->kode_jenis_biaya} = 0;
                        }
                    @endphp
                    @forelse ($rekaptagihan as $d)
                        <tr>
                            <td class="center col-freeze-no">{{ $loop->iteration }}</td>
                            <td class="center mono col-freeze-nis" style="color: #475569;">{{ $d->nis ?: '-' }}</td>
                            <td class="col-freeze-nama" style="font-weight: 600; color: #0f172a; padding-left: 8px;">{{ textUpperCase($d->nama_lengkap) }}</td>
                            @php
                                $total_tagihan = 0;
                                $total_potongan = 0;
                                $total_mutasi = 0;
                                $total_bayar = 0;
                                $total_sisa = 0;
                            @endphp
                            @foreach ($biaya as $b)
                                @php
                                    $tagihan_val = $d->{'jumlah_' . $b->kode_jenis_biaya} ?? 0;
                                    $potongan_val = $d->{'jumlah_potongan_' . $b->kode_jenis_biaya} ?? 0;
                                    $mutasi_val = $d->{'jumlah_mutasi_' . $b->kode_jenis_biaya} ?? 0;
                                    $bayar_val = $d->{'jumlah_bayar_' . $b->kode_jenis_biaya} ?? 0;
                                    $sisa_val = $tagihan_val - $potongan_val - $mutasi_val - $bayar_val;

                                    ${'total_tagihan_' . $b->kode_jenis_biaya} += $tagihan_val;
                                    ${'total_potongan_' . $b->kode_jenis_biaya} += $potongan_val;
                                    ${'total_mutasi_' . $b->kode_jenis_biaya} += $mutasi_val;
                                    ${'total_bayar_' . $b->kode_jenis_biaya} += $bayar_val;
                                    ${'total_sisa_' . $b->kode_jenis_biaya} += $sisa_val;

                                    $total_tagihan += $tagihan_val;
                                    $total_potongan += $potongan_val;
                                    $total_mutasi += $mutasi_val;
                                    $total_bayar += $bayar_val;
                                    $total_sisa += $sisa_val;
                                @endphp
                                <td class="right mono">{{ $tagihan_val ? formatAngka($tagihan_val) : '-' }}</td>
                                <td class="right mono" style="color: #0d9488;">{{ $potongan_val ? formatAngka($potongan_val) : '-' }}</td>
                                <td class="right mono" style="color: #0284c7;">{{ $mutasi_val ? formatAngka($mutasi_val) : '-' }}</td>
                                <td class="right mono" style="color: #065f46; font-weight: 700;">{{ $bayar_val ? formatAngka($bayar_val) : '-' }}</td>
                                <td class="right mono" style="color: {{ $sisa_val > 0 ? '#b91c1c' : '#64748b' }}; font-weight: {{ $sisa_val > 0 ? '700' : 'normal' }};">
                                    {{ $sisa_val ? formatAngka($sisa_val) : '-' }}
                                </td>
                            @endforeach
                            <td class="right mono font-bold" style="background-color: #f1f5f9;">{{ formatAngka($total_tagihan) }}</td>
                            <td class="right mono font-bold" style="color: #0d9488; background-color: #f1f5f9;">{{ formatAngka($total_potongan) }}</td>
                            <td class="right mono font-bold" style="color: #0284c7; background-color: #f1f5f9;">{{ formatAngka($total_mutasi) }}</td>
                            <td class="right mono font-bold" style="color: #065f46; background-color: #f1f5f9;">{{ formatAngka($total_bayar) }}</td>
                            <td class="right mono font-bold" style="color: {{ $total_sisa > 0 ? '#b91c1c' : '#065f46' }}; background-color: #f1f5f9;">
                                {{ formatAngka($total_sisa) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ 3 + (count($biaya) * 5) + 5 }}" class="center" style="padding: 30px; color: #94a3b8;">
                                <i class="ti ti-folder-x" style="font-size: 24px; display: block; margin-bottom: 6px;"></i>
                                <span>Tidak ada data rekap tagihan pada unit dan tingkat yang dipilih.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="center col-freeze-total">TOTAL KESELURUHAN</th>
                        @php
                            $grandtotal_tagihan = 0;
                            $grandtotal_potongan = 0;
                            $grandtotal_mutasi = 0;
                            $grandtotal_bayar = 0;
                            $grandtotal_sisa = 0;
                        @endphp
                        @foreach ($biaya as $b)
                            @php
                                $gt_tagihan = ${'total_tagihan_' . $b->kode_jenis_biaya};
                                $gt_potongan = ${'total_potongan_' . $b->kode_jenis_biaya};
                                $gt_mutasi = ${'total_mutasi_' . $b->kode_jenis_biaya};
                                $gt_bayar = ${'total_bayar_' . $b->kode_jenis_biaya};
                                $gt_sisa = ${'total_sisa_' . $b->kode_jenis_biaya};

                                $grandtotal_tagihan += $gt_tagihan;
                                $grandtotal_potongan += $gt_potongan;
                                $grandtotal_mutasi += $gt_mutasi;
                                $grandtotal_bayar += $gt_bayar;
                                $grandtotal_sisa += $gt_sisa;
                            @endphp
                            <th class="right mono">{{ formatAngka($gt_tagihan) }}</th>
                            <th class="right mono" style="color: #0d9488;">{{ formatAngka($gt_potongan) }}</th>
                            <th class="right mono" style="color: #0284c7;">{{ formatAngka($gt_mutasi) }}</th>
                            <th class="right mono" style="color: #065f46;">{{ formatAngka($gt_bayar) }}</th>
                            <th class="right mono" style="color: {{ $gt_sisa > 0 ? '#b91c1c' : '#064e3b' }};">{{ formatAngka($gt_sisa) }}</th>
                        @endforeach
                        <th class="right mono" style="font-size: 10.5px; background: #dcfce7; color: #064e3b;">{{ formatAngka($grandtotal_tagihan) }}</th>
                        <th class="right mono" style="font-size: 10.5px; background: #dcfce7; color: #0d9488;">{{ formatAngka($grandtotal_potongan) }}</th>
                        <th class="right mono" style="font-size: 10.5px; background: #dcfce7; color: #0284c7;">{{ formatAngka($grandtotal_mutasi) }}</th>
                        <th class="right mono" style="font-size: 10.5px; background: #dcfce7; color: #065f46;">{{ formatAngka($grandtotal_bayar) }}</th>
                        <th class="right mono" style="font-size: 10.5px; background: #dcfce7; color: {{ $grandtotal_sisa > 0 ? '#b91c1c' : '#064e3b' }};">
                            {{ formatAngka($grandtotal_sisa) }}
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Signature Section -->
        <div class="signature-section">
            <div class="signature-box" style="visibility: hidden;">
                <!-- Balancer -->
            </div>
            <div class="signature-box">
                <div class="signature-date">Ciamis, {{ DateToIndo(date('Y-m-d')) }}</div>
                <div class="signature-role">Bendahara / Bag. Keuangan</div>
                <div class="signature-name">{{ auth()->user()->name ?? 'Administrator Keuangan' }}</div>
                <div class="signature-nip">NPP. {{ auth()->user()->npp ?? '........................' }}</div>
            </div>
        </div>
    </div>

</body>
</html>

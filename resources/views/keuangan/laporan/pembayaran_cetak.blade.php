<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Pembayaran Pendidikan - {{ date('d-m-Y') }}</title>

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
            font-size: 11.5px;
            line-height: 1.45;
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
            max-width: 960px;
            margin: 72px auto 48px auto;
            background: #ffffff;
            padding: 44px 52px;
            border-radius: 12px;
            box-shadow: 0 16px 40px -10px rgba(0, 0, 0, 0.1), 0 0 0 1px rgba(0, 0, 0, 0.05);
            position: relative;
        }

        /* Kop Surat Resmi */
        .kop-surat {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 14px;
            margin-bottom: 16px;
            gap: 20px;
            position: relative;
        }

        .kop-logo {
            width: 78px;
            height: 78px;
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
            margin-bottom: 20px;
        }

        /* Document Title & Metadata Section */
        .doc-header-box {
            text-align: center;
            margin-bottom: 18px;
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

        .doc-subtitle {
            font-size: 11px;
            color: var(--text-muted);
            margin-top: 6px;
            font-weight: 500;
        }

        /* Metadata Grid */
        .meta-card {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px 24px;
            background: #f8fafc;
            border: 1px solid var(--border-light);
            border-radius: 10px;
            padding: 12px 18px;
            margin-bottom: 22px;
            font-size: 11px;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .meta-label {
            color: var(--text-muted);
            min-width: 105px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 5px;
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

        .meta-badge {
            display: inline-flex;
            align-items: center;
            padding: 2px 8px;
            border-radius: 6px;
            font-size: 10px;
            font-weight: 700;
            background: #e0f2fe;
            color: #0369a1;
            border: 1px solid #bae6fd;
        }

        /* Report Table Styling */
        .table-responsive-wrapper {
            width: 100%;
            overflow-x: auto;
            position: relative;
            margin-bottom: 24px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
        }

        table.table-report {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 11px;
            background: #ffffff;
            white-space: nowrap;
        }

        table.table-report thead th {
            background-color: var(--primary);
            color: #ffffff;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 10px;
            letter-spacing: 0.05em;
            padding: 9px 10px;
            border-right: 1px solid var(--primary-dark);
            border-bottom: 1px solid var(--primary-dark);
            text-align: left;
            vertical-align: middle;
        }

        table.table-report thead tr:first-child th {
            border-top: 1px solid var(--primary-dark);
        }

        table.table-report thead tr th:first-child {
            border-left: 1px solid var(--primary-dark);
        }

        table.table-report thead th.center,
        table.table-report tbody td.center {
            text-align: center;
        }

        table.table-report thead th.right,
        table.table-report tbody td.right,
        table.table-report tfoot th.right {
            text-align: right;
        }

        table.table-report tbody td {
            padding: 7px 10px;
            border-right: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
            color: #1e293b;
            vertical-align: middle;
            background-color: #ffffff;
        }

        table.table-report tbody tr td:first-child {
            border-left: 1px solid var(--border-color);
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
            padding: 10px 10px;
            border-right: 1px solid var(--primary-border);
            border-bottom: 1.5px solid var(--primary-border);
            border-top: 1.5px solid var(--primary-border);
            font-size: 11.5px;
        }

        table.table-report tfoot tr th:first-child {
            border-left: 1px solid var(--primary-border);
        }

        .mono {
            font-family: 'JetBrains Mono', monospace;
            font-variant-numeric: tabular-nums;
            font-weight: 600;
        }

        .bukti-tag {
            color: #047857;
            background: #ecfdf5;
            padding: 2px 6px;
            border-radius: 4px;
            border: 1px solid #a7f3d0;
            font-weight: 700;
            font-size: 10.5px;
        }

        /* Freeze Columns for Pembayaran */
        .col-freeze-no {
            position: sticky;
            left: 0;
            width: 38px;
            min-width: 38px;
            z-index: 5;
        }

        .col-freeze-nis {
            position: sticky;
            left: 38px;
            width: 75px;
            min-width: 75px;
            z-index: 5;
        }

        .col-freeze-nama {
            position: sticky;
            left: 113px; /* 38px + 75px */
            min-width: 140px;
            z-index: 5;
            border-right: 2px solid #94a3b8 !important;
            box-shadow: 4px 0 8px -3px rgba(0, 0, 0, 0.14);
        }

        table.table-report thead th.col-freeze-no,
        table.table-report thead th.col-freeze-nis,
        table.table-report thead th.col-freeze-nama {
            z-index: 25 !important;
            background-color: var(--primary) !important;
        }

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

        /* Summary Stats Cards (Mini) */
        .summary-stats-box {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-bottom: 22px;
        }

        .stat-card {
            background: #ffffff;
            border: 1px solid var(--border-light);
            border-radius: 8px;
            padding: 10px 14px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .stat-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: var(--primary-light);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .stat-content .stat-label {
            font-size: 10px;
            color: var(--text-muted);
            font-weight: 600;
            text-transform: uppercase;
        }

        .stat-content .stat-value {
            font-size: 13px;
            font-weight: 800;
            color: var(--text-main);
        }

        /* Signature Section */
        .signature-section {
            margin-top: 36px;
            display: flex;
            justify-content: space-between;
            page-break-inside: avoid;
        }

        .signature-box {
            width: 230px;
            text-align: center;
            font-size: 11px;
        }

        .signature-date {
            color: var(--text-muted);
            margin-bottom: 4px;
            font-size: 10.5px;
        }

        .signature-role {
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 60px;
        }

        .signature-name {
            font-weight: 800;
            text-decoration: underline;
            color: #0f172a;
        }

        .signature-nip {
            color: var(--text-muted);
            font-size: 10px;
            margin-top: 2px;
        }

        /* Print Specific Directives */
        @media print {
            body {
                background: #ffffff !important;
                color: #000000 !important;
                font-size: 9.5pt;
            }

            .no-print,
            .print-toolbar {
                display: none !important;
            }

            .sheet-container {
                max-width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                box-shadow: none !important;
                border-radius: 0 !important;
            }

            .summary-stats-box {
                display: none !important;
            }

            .table-responsive-wrapper {
                overflow: visible !important;
                box-shadow: none !important;
                border: none !important;
            }

            table.table-report {
                border-collapse: collapse !important;
            }

            .col-freeze-no,
            .col-freeze-nis,
            .col-freeze-nama {
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

            .bukti-tag {
                background-color: #ecfdf5 !important;
                color: #047857 !important;
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
                size: A4 portrait;
                margin: 12mm 12mm 12mm 12mm;
            }
        }
    </style>
</head>

<body>

    <!-- On-Screen Floating Action Bar -->
    <div class="print-toolbar no-print">
        <div class="toolbar-info">
            <i class="ti ti-file-text"></i>
            <span>Mode Pratinjau Cetak</span>
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
            
            $total_pembayaran = 0;
            foreach ($pembayaran as $p) {
                $total_pembayaran += $p->jumlah;
            }
        @endphp

        <!-- Kop Surat Resmi -->
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
            <div style="width: 78px;" class="no-print"></div>
        </div>
        <div class="kop-divider"></div>

        <!-- Title Section -->
        <div class="doc-header-box">
            <div class="doc-title-wrapper">
                <div class="doc-title">
                    <i class="ti ti-report-money no-print"></i>
                    <span>Laporan Riwayat Pembayaran Pendidikan</span>
                </div>
            </div>
        </div>

        <!-- Metadata Grid -->
        <div class="meta-card">
            <div class="meta-item">
                <span class="meta-label"><i class="ti ti-calendar-event"></i> Periode</span>
                <span class="meta-separator">:</span>
                <span class="meta-value">{{ DateToIndo($dari) }} s/d {{ DateToIndo($sampai) }}</span>
            </div>
            <div class="meta-item">
                <span class="meta-label"><i class="ti ti-clock"></i> Dicetak Pada</span>
                <span class="meta-separator">:</span>
                <span class="meta-value">{{ date('d/m/Y H:i') }} WIB</span>
            </div>
            <div class="meta-item">
                <span class="meta-label"><i class="ti ti-building-bank"></i> Unit / Tingkat</span>
                <span class="meta-separator">:</span>
                <span class="meta-value">
                    {{ $unit ? $unit->nama_unit : 'Semua Unit' }}
                    @if(isset($tingkat) && $tingkat)
                        <span class="meta-badge">Tingkat {{ $tingkat }}</span>
                    @endif
                </span>
            </div>
            <div class="meta-item">
                <span class="meta-label"><i class="ti ti-user-check"></i> Petugas</span>
                <span class="meta-separator">:</span>
                <span class="meta-value">{{ auth()->user()->name ?? 'Administrator Keuangan' }}</span>
            </div>
        </div>

        <!-- Mini Stats Summary (Screen View Highlight) -->
        <div class="summary-stats-box no-print">
            <div class="stat-card">
                <div class="stat-icon"><i class="ti ti-receipt-2"></i></div>
                <div class="stat-content">
                    <div class="stat-label">Total Transaksi</div>
                    <div class="stat-value mono">{{ count($pembayaran) }} Pembayaran</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:#ecfdf5; color:#047857;"><i class="ti ti-wallet"></i></div>
                <div class="stat-content">
                    <div class="stat-label">Total Penerimaan</div>
                    <div class="stat-value mono" style="color: #047857;">Rp {{ formatAngka($total_pembayaran) }}</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:#eff6ff; color:#0284c7;"><i class="ti ti-calendar"></i></div>
                <div class="stat-content">
                    <div class="stat-label">Rentang Waktu</div>
                    <div class="stat-value" style="font-size: 11px;">{{ date('d/m/y', strtotime($dari)) }} - {{ date('d/m/y', strtotime($sampai)) }}</div>
                </div>
            </div>
        </div>

        <!-- Main Data Table -->
        <div class="table-responsive-wrapper">
            <table class="table-report">
                <thead>
                    <tr>
                        <th class="center col-freeze-no">No</th>
                        <th class="center col-freeze-nis">NIS</th>
                        <th class="col-freeze-nama">Nama Santri</th>
                        <th style="width: 100px;">No. Bukti</th>
                        <th class="center" style="width: 80px;">Tanggal</th>
                        <th>Jenis Biaya</th>
                        <th class="right" style="width: 115px;">Nominal (Rp)</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pembayaran as $p)
                        <tr>
                            <td class="center col-freeze-no">{{ $loop->iteration }}</td>
                            <td class="center mono col-freeze-nis" style="color: #475569;">{{ $p->nis ?: '-' }}</td>
                            <td class="col-freeze-nama" style="font-weight: 600; color: #0f172a;">{{ textUpperCase($p->nama_lengkap) }}</td>
                            <td>
                                <span class="bukti-tag mono">{{ $p->no_bukti }}</span>
                            </td>
                            <td class="center">{{ date('d/m/Y', strtotime($p->tanggal)) }}</td>
                            <td>
                                <span style="font-weight: 500;">{{ $p->jenis_biaya }}</span>
                                @if($p->tahun_ajaran)
                                    <span style="font-size: 9.5px; color: #64748b;">({{ $p->tahun_ajaran }})</span>
                                @endif
                            </td>
                            <td class="right mono" style="font-weight: 700; color: #065f46;">
                                {{ formatAngka($p->jumlah) }}
                            </td>
                            <td style="color: #64748b; font-size: 10px;">{{ $p->keterangan ?: '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="center" style="padding: 30px; color: #94a3b8;">
                                <i class="ti ti-folder-x" style="font-size: 24px; display: block; margin-bottom: 6px;"></i>
                                <span>Tidak ada transaksi pembayaran pada rentang periode yang dipilih.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="6" style="text-align: left; letter-spacing: 0.04em;">TOTAL PENERIMAAN KAS</th>
                        <th class="right mono" style="font-size: 12.5px; color: #064e3b; font-weight: 800;">
                            Rp {{ formatAngka($total_pembayaran) }}
                        </th>
                        <th></th>
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

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rekap Checklist Ibadah Karyawan (Periode {{ !empty($bulan) ? getNamaBulan($bulan) : '' }} {{ $tahun ?? date('Y') }})</title>

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
            background-color: #0f172a08;
            background-image: radial-gradient(#cbd5e1 1px, transparent 1px);
            background-size: 20px 20px;
            font-size: 11px;
            line-height: 1.35;
            -webkit-font-smoothing: antialiased;
            min-height: 100vh;
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

        /* Table Checklist */
        .table-responsive-wrapper {
            overflow-x: auto;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
            background: #fff;
        }

        .table-checklist {
            width: 100%;
            border-collapse: collapse;
            font-size: 10.5px;
            font-family: inherit;
        }

        .table-checklist th {
            background-color: #064e3b;
            color: #ffffff;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.02em;
            padding: 8px 6px;
            text-align: center;
            border: 1px solid #047857;
            font-size: 10px;
            white-space: nowrap;
        }

        .table-checklist th.th-activity {
            min-width: 90px;
            font-weight: 600;
            padding: 6px 8px;
        }

        .table-checklist td {
            border: 1px solid #e2e8f0;
            padding: 6px 6px;
            vertical-align: middle;
            font-size: 10px;
        }

        .table-checklist tbody tr:nth-child(even) {
            background-color: #fbfcfd;
        }

        .table-checklist tbody tr:hover {
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
        .table-checklist thead th.col-freeze-no,
        .table-checklist thead th.col-freeze-npp,
        .table-checklist thead th.col-freeze-nama,
        .table-checklist thead th.col-freeze-jabatan,
        .table-checklist thead th.col-freeze-unit {
            z-index: 25 !important;
            background-color: #064e3b !important;
        }

        .table-checklist thead th.col-freeze-unit {
            border-right: 2px solid #047857 !important;
        }

        /* Body Cells in Frozen Columns maintain opaque backgrounds */
        .table-checklist tbody td.col-freeze-no,
        .table-checklist tbody td.col-freeze-npp,
        .table-checklist tbody td.col-freeze-nama,
        .table-checklist tbody td.col-freeze-jabatan,
        .table-checklist tbody td.col-freeze-unit {
            background-color: #ffffff;
        }

        .table-checklist tbody tr:nth-child(even) td.col-freeze-no,
        .table-checklist tbody tr:nth-child(even) td.col-freeze-npp,
        .table-checklist tbody tr:nth-child(even) td.col-freeze-nama,
        .table-checklist tbody tr:nth-child(even) td.col-freeze-jabatan,
        .table-checklist tbody tr:nth-child(even) td.col-freeze-unit {
            background-color: #fbfcfd !important;
        }

        .table-checklist tbody tr:hover td.col-freeze-no,
        .table-checklist tbody tr:hover td.col-freeze-npp,
        .table-checklist tbody tr:hover td.col-freeze-nama,
        .table-checklist tbody tr:hover td.col-freeze-jabatan,
        .table-checklist tbody tr:hover td.col-freeze-unit {
            background-color: #f0fdf4 !important;
        }

        .td-center {
            text-align: center;
        }

        .td-emp-name {
            font-weight: 700;
            color: #0f172a;
            white-space: nowrap;
            padding: 6px 10px !important;
        }

        .td-emp-sub {
            font-size: 9.5px;
            color: #64748b;
            font-weight: 500;
            white-space: nowrap;
        }

        /* Activity Cell Counter */
        .td-count {
            text-align: center;
            font-family: 'JetBrains Mono', monospace;
            font-size: 11px;
            font-weight: 700;
        }

        .td-count.has-count {
            color: #047857;
            background-color: #f0fdf4;
        }

        .td-count.empty-count {
            color: #cbd5e1;
            font-weight: 400;
        }

        .td-total-score {
            text-align: center;
            font-family: 'JetBrains Mono', monospace;
            font-size: 11px;
            font-weight: 800;
            color: #064e3b;
            background-color: #ecfdf5;
            white-space: nowrap;
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

            .table-checklist th {
                background-color: #064e3b !important;
                color: #ffffff !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .table-checklist td {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            @page {
                size: A4 landscape;
                margin: 8mm 6mm;
            }
        }
    </style>
</head>

<body>

    <!-- Floating Top Toolbar -->
    <div class="print-toolbar">
        <div class="toolbar-info">
            <i class="ti ti-printer"></i>
            <span>Rekapitulasi Checklist Ibadah</span>
        </div>
        <button onclick="window.print()" class="btn-tool btn-print">
            <i class="ti ti-printer"></i>
            <span>Cetak / Simpan PDF</span>
        </button>
        <button onclick="window.close()" class="btn-tool btn-close-view">
            <i class="ti ti-x"></i>
            <span>Tutup</span>
        </button>
    </div>

    <!-- Sheet Container -->
    <div class="sheet-container">
        
        <!-- Kop Surat -->
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

        <!-- Document Title -->
        <div class="doc-header-box">
            <h1 class="doc-title">Laporan Rekapitulasi Checklist Ibadah Karyawan</h1>
            <p class="doc-subtitle">
                Periode: <strong>{{ !empty($bulan) ? getNamaBulan($bulan) : '' }} {{ $tahun ?? date('Y') }}</strong> 
                &bull; Total: <strong>{{ count($rekapkegiatanibadah) }} Karyawan</strong>
            </p>
        </div>

        <!-- Table Responsive Wrapper -->
        <div class="table-responsive-wrapper">
            <table class="table-checklist">
                <thead>
                    <tr>
                        <th rowspan="2" class="col-freeze-no">No</th>
                        <th rowspan="2" class="col-freeze-npp">NPP</th>
                        <th rowspan="2" class="col-freeze-nama" style="text-align: left; padding-left: 10px;">Nama Karyawan</th>
                        <th rowspan="2" class="col-freeze-jabatan" style="text-align: left; padding-left: 10px;">Jabatan</th>
                        <th rowspan="2" class="col-freeze-unit">Unit</th>
                        <th colspan="{{ count($kegiatan_ibadah) }}">Daftar Kegiatan Ibadah</th>
                        <th rowspan="2" style="min-width: 75px;">Total Ibadah</th>
                    </tr>
                    <tr>
                        @foreach ($kegiatan_ibadah as $k)
                            <th class="th-activity">{{ $k->nama_kegiatan }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rekapkegiatanibadah as $d)
                        @php
                            $row_total = 0;
                        @endphp
                        <tr>
                            <td class="col-freeze-no td-center" style="font-weight: 600;">{{ $loop->iteration }}</td>
                            <td class="col-freeze-npp td-center" style="font-family: 'JetBrains Mono', monospace; font-size: 9.5px; color: #475569;">
                                {{ $d->npp }}
                            </td>
                            <td class="col-freeze-nama td-emp-name">
                                {{ $d->nama_lengkap }}
                            </td>
                            <td class="col-freeze-jabatan td-emp-sub">
                                {{ $d->nama_jabatan ?? '-' }}
                            </td>
                            <td class="col-freeze-unit td-center td-emp-sub">
                                {{ $d->nama_unit ?? '-' }}
                            </td>

                            <!-- Loop Kegiatan Ibadah -->
                            @foreach ($kegiatan_ibadah as $k)
                                @php
                                    $val = $d['jml_kegiatan_' . $k->id] ?? 0;
                                    $row_total += (int) $val;
                                @endphp
                                <td class="td-count {{ $val > 0 ? 'has-count' : 'empty-count' }}">
                                    {{ $val > 0 ? $val : '-' }}
                                </td>
                            @endforeach

                            <!-- Total Score -->
                            <td class="td-total-score">
                                {{ $row_total }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ count($kegiatan_ibadah) + 6 }}" style="text-align: center; padding: 24px; color: #94a3b8; font-weight: 600;">
                                Tidak ada data checklist ibadah untuk periode ini.
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

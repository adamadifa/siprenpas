<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bukti Pembayaran - {{ $historibayar->no_bukti }}</title>

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
            max-width: 820px;
            margin: 72px auto 48px auto;
            background: #ffffff;
            padding: 40px 48px;
            border-radius: 12px;
            box-shadow: 0 16px 40px -10px rgba(0, 0, 0, 0.1), 0 0 0 1px rgba(0, 0, 0, 0.05);
            position: relative;
        }

        /* Kop Surat */
        .kop-surat {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 12px;
            margin-bottom: 14px;
            gap: 16px;
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
            font-size: 10.5px;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--primary);
            margin-bottom: 2px;
        }

        .kop-text .instansi-nama {
            font-size: 16px;
            font-weight: 800;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            line-height: 1.25;
            margin-bottom: 3px;
        }

        .kop-text .instansi-alamat {
            font-size: 9.5px;
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

        /* Document Title Section */
        .doc-header-box {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
            padding-bottom: 10px;
            border-bottom: 1px dashed var(--border-color);
        }

        .doc-title {
            font-size: 14px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--primary-dark);
            padding: 4px 16px;
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
            border: 1px solid var(--primary-border);
            border-radius: 9999px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .doc-no-bukti {
            font-size: 11px;
            color: var(--text-muted);
            font-weight: 600;
        }

        .doc-no-bukti .bukti-val {
            font-family: 'JetBrains Mono', monospace;
            font-weight: 800;
            color: #047857;
            background: #ecfdf5;
            padding: 2px 8px;
            border-radius: 4px;
            border: 1px solid #a7f3d0;
            margin-left: 4px;
        }

        /* Metadata Grid 2-Col */
        .meta-card {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px 30px;
            background: #f8fafc;
            border: 1px solid var(--border-light);
            border-radius: 10px;
            padding: 12px 18px;
            margin-bottom: 18px;
            font-size: 11px;
        }

        .meta-col {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .meta-label {
            color: var(--text-muted);
            min-width: 90px;
            font-weight: 600;
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
            padding: 1px 7px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 700;
            background: #e0f2fe;
            color: #0369a1;
            border: 1px solid #bae6fd;
        }

        /* Table */
        table.table-receipt {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
            margin-bottom: 16px;
            background: #ffffff;
        }

        table.table-receipt thead th {
            background-color: var(--primary);
            color: #ffffff;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 10px;
            letter-spacing: 0.05em;
            padding: 8px 10px;
            border: 1px solid var(--primary-dark);
            text-align: left;
        }

        table.table-receipt thead th.center,
        table.table-receipt tbody td.center {
            text-align: center;
        }

        table.table-receipt thead th.right,
        table.table-receipt tbody td.right,
        table.table-receipt tfoot th.right {
            text-align: right;
        }

        table.table-receipt tbody td {
            padding: 7px 10px;
            border: 1px solid var(--border-color);
            color: #1e293b;
            vertical-align: middle;
        }

        table.table-receipt tbody tr:nth-child(even) {
            background-color: var(--bg-zebra);
        }

        table.table-receipt tfoot th {
            background-color: var(--primary-light);
            color: var(--primary-dark);
            font-weight: 800;
            padding: 9px 10px;
            border: 1.5px solid var(--primary-border);
            font-size: 11.5px;
        }

        .mono {
            font-family: 'JetBrains Mono', monospace;
            font-variant-numeric: tabular-nums;
            font-weight: 600;
        }

        /* Terbilang Box */
        .terbilang-box {
            background: #f8fafc;
            border-left: 3px solid var(--primary);
            border-radius: 0 8px 8px 0;
            padding: 8px 14px;
            font-size: 10.5px;
            color: var(--text-secondary);
            margin-bottom: 18px;
        }

        .terbilang-label {
            font-weight: 700;
            color: var(--primary-dark);
            text-transform: uppercase;
            font-size: 9.5px;
            letter-spacing: 0.04em;
            margin-bottom: 2px;
        }

        .terbilang-text {
            font-style: italic;
            font-weight: 600;
            color: #0f172a;
        }

        /* Footer & Signature */
        .footer-section {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-top: 24px;
            gap: 20px;
            page-break-inside: avoid;
        }

        .note-box {
            font-size: 10px;
            color: var(--text-muted);
            line-height: 1.4;
            max-width: 440px;
        }

        .note-box .note-title {
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 2px;
        }

        .signature-box {
            width: 220px;
            text-align: center;
            font-size: 10.5px;
        }

        .signature-date {
            color: var(--text-muted);
            margin-bottom: 4px;
        }

        .signature-role {
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 50px;
        }

        .signature-name {
            font-weight: 800;
            text-decoration: underline;
            color: #0f172a;
        }

        /* Print Directives */
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

            table.table-receipt thead th {
                background-color: #047857 !important;
                color: #ffffff !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            table.table-receipt tfoot th {
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

            .doc-no-bukti .bukti-val {
                background-color: #ecfdf5 !important;
                color: #047857 !important;
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
            <i class="ti ti-receipt"></i>
            <span>Kwitansi Pembayaran</span>
        </div>
        <button type="button" class="btn-tool btn-print" onclick="window.print()">
            <i class="ti ti-printer"></i>
            <span>Cetak Kwitansi</span>
        </button>
        <button type="button" class="btn-tool btn-close-view" onclick="window.close()">
            <i class="ti ti-arrow-left"></i>
            <span>Tutup</span>
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
            
            $total_bayar = 0;
            foreach ($detail as $d) {
                $total_bayar += $d->jumlah;
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
            <div style="width: 72px;" class="no-print"></div>
        </div>
        <div class="kop-divider"></div>

        <!-- Document Header & No Bukti -->
        <div class="doc-header-box">
            <div class="doc-title">
                <i class="ti ti-check-shield no-print"></i>
                <span>Bukti Pembayaran Pendidikan</span>
            </div>
            <div class="doc-no-bukti">
                <span>No. Bukti:</span>
                <span class="bukti-val">{{ $historibayar->no_bukti }}</span>
            </div>
        </div>

        <!-- Metadata Section -->
        <div class="meta-card">
            <div class="meta-col">
                <div class="meta-item">
                    <span class="meta-label">Nama Santri</span>
                    <span class="meta-separator">:</span>
                    <span class="meta-value">{{ textUpperCase($historibayar->nama_lengkap) }}</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">NIS</span>
                    <span class="meta-separator">:</span>
                    <span class="meta-value mono">{{ $historibayar->nis ?: '-' }}</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Kelas / Unit</span>
                    <span class="meta-separator">:</span>
                    <span class="meta-value">{{ $historibayar->kelas ?: '-' }}</span>
                </div>
            </div>
            <div class="meta-col">
                <div class="meta-item">
                    <span class="meta-label">Tanggal Transaksi</span>
                    <span class="meta-separator">:</span>
                    <span class="meta-value">{{ DateToIndo($historibayar->tanggal) }}</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Metode Bayar</span>
                    <span class="meta-separator">:</span>
                    <span class="meta-value">
                        <span class="meta-badge">{{ $historibayar->metode_pembayaran == 'TF' ? 'Transfer Bank' : 'Tunai / Cash' }}</span>
                    </span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Petugas Kasir</span>
                    <span class="meta-separator">:</span>
                    <span class="meta-value">{{ $historibayar->name ?? 'Petugas Keuangan' }}</span>
                </div>
            </div>
        </div>

        <!-- Payment Breakdown Table -->
        <table class="table-receipt">
            <thead>
                <tr>
                    <th class="center" style="width: 38px;">No</th>
                    <th>Komponen Biaya</th>
                    <th class="right" style="width: 140px;">Jumlah (Rp)</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($detail as $d)
                    <tr>
                        <td class="center">{{ $loop->iteration }}</td>
                        <td style="font-weight: 600;">
                            {{ $d->jenis_biaya }}
                            @if(in_array($d->kode_jenis_biaya, ['B07', 'B01']) && $d->tahun_ajaran)
                                <span style="font-size: 10px; color: #64748b; font-weight: normal;">(T.A {{ $d->tahun_ajaran }})</span>
                            @endif
                        </td>
                        <td class="right mono" style="font-weight: 700; color: #065f46;">
                            {{ formatAngka($d->jumlah) }}
                        </td>
                        <td style="color: #64748b;">{{ $d->keterangan ?: '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2" style="text-align: left; letter-spacing: 0.04em;">TOTAL DIBAYAR</th>
                    <th class="right mono" style="font-size: 12.5px; color: #064e3b; font-weight: 800;">
                        Rp {{ formatAngka($total_bayar) }}
                    </th>
                    <th></th>
                </tr>
            </tfoot>
        </table>

        <!-- Terbilang Box -->
        <div class="terbilang-box">
            <div class="terbilang-label">Terbilang :</div>
            <div class="terbilang-text"># {{ textCamelCase(terbilang($total_bayar)) }} Rupiah #</div>
        </div>

        <!-- Footer & Signatures -->
        <div class="footer-section">
            <div class="note-box">
                <div class="note-title">Catatan:</div>
                <p>• Simpanlah kwitansi ini sebagai bukti pembayaran yang sah.</p>
                <p>• Pembayaran telah diterima dan diverifikasi oleh Bagian Keuangan Pesantren.</p>
            </div>
            <div class="signature-box">
                <div class="signature-date">Sindangkasih, {{ DateToIndo($historibayar->tanggal) }}</div>
                <div class="signature-role">Petugas Penerima,</div>
                <div class="signature-name">{{ $historibayar->name ?? 'Bagian Keuangan' }}</div>
            </div>
        </div>
    </div>

</body>
</html>

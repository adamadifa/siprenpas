<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Formulir Pendaftaran Online - {{ $pendaftaran->no_register }}</title>
    <style>
        @page {
            size: A4;
            margin: 15mm 15mm 15mm 15mm;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #1e293b;
            line-height: 1.4;
        }

        .header-kop {
            text-align: center;
            border-bottom: 2px solid #0f172a;
            padding-bottom: 8px;
            margin-bottom: 12px;
        }

        .header-kop h3 {
            margin: 0;
            font-size: 14px;
            text-transform: uppercase;
            font-weight: bold;
        }

        .header-kop h2 {
            margin: 2px 0;
            font-size: 16px;
            text-transform: uppercase;
            font-weight: 900;
        }

        .header-kop p {
            margin: 0;
            font-size: 11px;
            color: #475569;
        }

        .meta-bar {
            margin-bottom: 15px;
            font-size: 12px;
        }

        .section-header {
            background-color: #064e3b;
            color: #ffffff;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            padding: 5px 8px;
            margin-top: 12px;
            margin-bottom: 6px;
            border-radius: 2px;
        }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }

        table.data-table td {
            padding: 3.5px 4px;
            vertical-align: top;
        }

        .w-num {
            width: 20px;
            text-align: center;
            color: #64748b;
        }

        .w-label {
            width: 180px;
            color: #334155;
            font-weight: 600;
        }

        .w-colon {
            width: 10px;
            text-align: center;
        }

        .val-bold {
            font-weight: bold;
            color: #0f172a;
        }
    </style>
</head>

<body>
    @php
        $namaSekolah = optional($pengaturan)->nama_sekolah ?? 'PESANTREN PERSATUAN ISLAM 80 AL AMIN SINDANGKASIH';
        $alamatSekolah = optional($pengaturan)->alamat_sekolah ?? 'Jln. Raya Ancol No. 27 Ancol I Sindangkasih';
        $teleponSekolah = optional($pengaturan)->telepon ?? '(0265) 325285';
        $emailSekolah = optional($pengaturan)->email ?? 'peris.alamin80sinkas@gmail.com';
        $websiteSekolah = optional($pengaturan)->website ?? 'persisalamin.com';
        $logoPath = public_path('assets/img/logo/persisalamin.png');
        if (optional($pengaturan)->logo) {
            $customLogo = storage_path('app/public/' . $pengaturan->logo);
            if (file_exists($customLogo)) {
                $logoPath = $customLogo;
            }
        }
    @endphp

    <div class="header-kop">
        <img src="{{ $logoPath }}" alt="Logo" style="height: 60px; margin-bottom: 4px;">
        <h3>PANITIA PENERIMAAN SANTRI BARU (PSB)</h3>
        <h2>{{ strtoupper($namaSekolah) }}</h2>
        <p style="font-weight: bold; color: #064e3b;">
            FORMULIR PENDAFTARAN ONLINE • TINGKAT {{ strtoupper($pendaftaran->nama_unit) }} • TAHUN AJARAN {{ $pendaftaran->tahun_ajaran }}
        </p>
        <p>
            {{ $alamatSekolah }}
            @if ($teleponSekolah) • Telp: {{ $teleponSekolah }} @endif
            @if ($emailSekolah) • Email: {{ $emailSekolah }} @endif
            @if ($websiteSekolah) • Web: {{ $websiteSekolah }} @endif
        </p>
    </div>

    <div class="meta-bar">
        <table style="width: 100%;">
            <tr>
                <td style="font-size: 11px;">Tanggal Registrasi: <strong>{{ DateToIndo($pendaftaran->tanggal_register) }}</strong></td>
                <td style="text-align: right; font-size: 12px;">Nomor Register: <strong style="font-size: 13px; color: #064e3b;">{{ $pendaftaran->no_register }}</strong></td>
            </tr>
        </table>
    </div>

    <!-- A. DATA PESERTA DIDIK -->
    <div class="section-header">A. DATA PRIBADI CALON SANTRI</div>
    <table class="data-table">
        <tr>
            <td class="w-num">1.</td>
            <td class="w-label">Nomor Register</td>
            <td class="w-colon">:</td>
            <td class="val-bold">{{ $pendaftaran->no_register }}</td>
        </tr>
        <tr>
            <td class="w-num">2.</td>
            <td class="w-label">NISN (Nomor Induk Siswa Nasional)</td>
            <td class="w-colon">:</td>
            <td>{{ $pendaftaran->nisn ?: '-' }}</td>
        </tr>
        <tr>
            <td class="w-num">3.</td>
            <td class="w-label">Nama Lengkap</td>
            <td class="w-colon">:</td>
            <td class="val-bold">{{ ucwords(strtolower($pendaftaran->nama_lengkap)) }}</td>
        </tr>
        <tr>
            <td class="w-num">4.</td>
            <td class="w-label">Jenis Kelamin</td>
            <td class="w-colon">:</td>
            <td>{{ $pendaftaran->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
        </tr>
        <tr>
            <td class="w-num">5.</td>
            <td class="w-label">Tempat & Tanggal Lahir</td>
            <td class="w-colon">:</td>
            <td>{{ !empty($pendaftaran->tempat_lahir) ? textCamelCase($pendaftaran->tempat_lahir) : '-' }}, {{ !empty($pendaftaran->tanggal_lahir) ? DateToIndo($pendaftaran->tanggal_lahir) : '-' }}</td>
        </tr>
        <tr>
            <td class="w-num">6.</td>
            <td class="w-label">Urutan Anak / Saudara</td>
            <td class="w-colon">:</td>
            <td>{{ $pendaftaran->anak_ke ? 'Anak ke-' . $pendaftaran->anak_ke : '-' }} {{ $pendaftaran->jumlah_saudara ? 'dari ' . $pendaftaran->jumlah_saudara . ' bersaudara' : '' }}</td>
        </tr>
        <tr>
            <td class="w-num">7.</td>
            <td class="w-label">No. Handphone / WhatsApp</td>
            <td class="w-colon">:</td>
            <td>{{ $pendaftaran->no_hp ?: '-' }}</td>
        </tr>
        <tr>
            <td class="w-num">8.</td>
            <td class="w-label">Alamat Email</td>
            <td class="w-colon">:</td>
            <td>{{ $pendaftaran->email ?: '-' }}</td>
        </tr>
    </table>

    <!-- B. ASAL SEKOLAH -->
    <div class="section-header">B. ASAL SEKOLAH</div>
    <table class="data-table">
        <tr>
            <td class="w-num">1.</td>
            <td class="w-label">Nama Asal Sekolah / Madrasah</td>
            <td class="w-colon">:</td>
            <td class="val-bold">{{ $pendaftaran->asal_sekolah ?: '-' }}</td>
        </tr>
    </table>

    <!-- C. ALAMAT DAN DOMISILI -->
    <div class="section-header">C. ALAMAT DAN DOMISILI</div>
    <table class="data-table">
        <tr>
            <td class="w-num">1.</td>
            <td class="w-label">Alamat Lengkap / Kp. / Jalan</td>
            <td class="w-colon">:</td>
            <td>{{ textCamelCase($pendaftaran->alamat ?: '-') }}</td>
        </tr>
        <tr>
            <td class="w-num">2.</td>
            <td class="w-label">Desa / Kelurahan</td>
            <td class="w-colon">:</td>
            <td>{{ textCamelCase($pendaftaran->desa ?: '-') }}</td>
        </tr>
        <tr>
            <td class="w-num">3.</td>
            <td class="w-label">Kecamatan</td>
            <td class="w-colon">:</td>
            <td>{{ textCamelCase($pendaftaran->kecamatan ?: '-') }}</td>
        </tr>
        <tr>
            <td class="w-num">4.</td>
            <td class="w-label">Kabupaten / Kota</td>
            <td class="w-colon">:</td>
            <td>{{ textCamelCase($pendaftaran->kabupaten ?: '-') }}</td>
        </tr>
        <tr>
            <td class="w-num">5.</td>
            <td class="w-label">Provinsi</td>
            <td class="w-colon">:</td>
            <td>{{ textCamelCase($pendaftaran->provinsi ?: '-') }}</td>
        </tr>
        <tr>
            <td class="w-num">6.</td>
            <td class="w-label">Kode Pos</td>
            <td class="w-colon">:</td>
            <td>{{ $pendaftaran->kode_pos ?: '-' }}</td>
        </tr>
    </table>

    <!-- D. INFORMASI ORANG TUA / WALI -->
    <div class="section-header">D. INFORMASI ORANG TUA / WALI</div>
    <table class="data-table">
        <tr>
            <td class="w-num">1.</td>
            <td class="w-label">No. Kartu Keluarga (KK)</td>
            <td class="w-colon">:</td>
            <td>{{ $pendaftaran->no_kk ?: '-' }}</td>
        </tr>
        <tr>
            <td class="w-num">2.</td>
            <td class="w-label">NIK Ayah Kandung</td>
            <td class="w-colon">:</td>
            <td>{{ $pendaftaran->nik_ayah ?: '-' }}</td>
        </tr>
        <tr>
            <td class="w-num">3.</td>
            <td class="w-label">Nama Lengkap Ayah</td>
            <td class="w-colon">:</td>
            <td class="val-bold">{{ textCamelCase($pendaftaran->nama_ayah ?: '-') }}</td>
        </tr>
        <tr>
            <td class="w-num">4.</td>
            <td class="w-label">Pendidikan & Pekerjaan Ayah</td>
            <td class="w-colon">:</td>
            <td>{{ $pendaftaran->pendidikan_ayah ?: '-' }} / {{ textCamelCase($pendaftaran->pekerjaan_ayah ?: '-') }}</td>
        </tr>
        <tr>
            <td class="w-num">5.</td>
            <td class="w-label">NIK Ibu Kandung</td>
            <td class="w-colon">:</td>
            <td>{{ $pendaftaran->nik_ibu ?: '-' }}</td>
        </tr>
        <tr>
            <td class="w-num">6.</td>
            <td class="w-label">Nama Lengkap Ibu</td>
            <td class="w-colon">:</td>
            <td class="val-bold">{{ textCamelCase($pendaftaran->nama_ibu ?: '-') }}</td>
        </tr>
        <tr>
            <td class="w-num">7.</td>
            <td class="w-label">Pendidikan & Pekerjaan Ibu</td>
            <td class="w-colon">:</td>
            <td>{{ $pendaftaran->pendidikan_ibu ?: '-' }} / {{ textCamelCase($pendaftaran->pekerjaan_ibu ?: '-') }}</td>
        </tr>
    </table>

    <div style="margin-top: 30px; width: 100%;">
        <table style="width: 100%; font-size: 11px;">
            <tr>
                <td style="width: 50%; text-align: center;">
                    Mengetahui,<br>
                    Orang Tua / Wali Calon Santri
                    <br><br><br><br>
                    ( .................................................... )
                </td>
                <td style="width: 50%; text-align: center;">
                    Sindangkasih, {{ DateToIndo(date('Y-m-d')) }}<br>
                    Panitia PSB Online
                    <br><br><br><br>
                    ( .................................................... )
                </td>
            </tr>
        </table>
    </div>

</body>
</html>

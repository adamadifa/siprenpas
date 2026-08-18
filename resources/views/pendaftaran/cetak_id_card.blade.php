<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Kartu Santri - {{ $pendaftaran->nama_lengkap }}</title>
    <!-- Include FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Include html2canvas & JsBarcode -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Amiri:wght@700&display=swap');

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f0f2f5;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            min-height: 100vh;
            padding: 40px 20px;
            overflow-y: auto;
        }

        .cards-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
            width: 100%;
            margin-bottom: 80px;
            position: relative;
        }

        .tab-btn {
            background-color: #e5e7eb;
            color: #374151;
            border: none;
            padding: 10px 24px;
            font-size: 14px;
            font-weight: bold;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .tab-btn.active {
            background-color: #064e3b;
            color: white;
            box-shadow: 0 4px 10px rgba(6, 78, 59, 0.25);
        }

        #card-back {
            display: none;
        }

        /* Printable Area - Fixed High-Res Ratio (Aspect 1.586, standard CR-80) */
        .id-card-wrapper {
            background-color: #ffffff;
            width: 1012px;
            height: 638px;
            position: relative;
            overflow: hidden;
            border-radius: 24px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
            display: flex;
            flex-direction: column;
            border: 1px solid #e0e0e0;
            /* Zoom scale on screen for preview */
            transform: scale(0.65);
            transform-origin: center;
            flex-shrink: 0;
        }

        /* Header Style */
        .header {
            background-color: #064e3b;
            color: #ffffff;
            height: 185px;
            display: flex;
            align-items: center;
            padding: 10px 30px;
            position: relative;
        }

        .header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 8px;
            background-color: #fcb900;
        }

        .logo-left, .logo-right {
            width: 115px;
            height: 115px;
            object-fit: contain;
        }

        .header-text {
            flex-grow: 1;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 0 15px;
        }

        .arabic-text {
            font-family: 'Amiri', serif;
            font-size: 26px;
            line-height: 1.1;
            color: #ffffff;
            font-weight: bold;
        }

        .arabic-logo-img {
            height: 56px;
            width: auto;
            object-fit: contain;
            margin-bottom: 2px;
            display: inline-block;
        }

        .institution-name {
            font-size: 30px;
            font-weight: 800;
            line-height: 1.2;
            color: #ffffff;
            letter-spacing: 0.5px;
            margin-top: 4px;
        }

        .address-text {
            font-size: 13.5px;
            line-height: 1.25;
            color: #e0f2fe;
            margin-top: 5px;
            font-weight: 300;
        }

        /* Body Style */
        .codes-row {
            margin-top: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 90px;
            padding-right: 15px;
        }

        .barcode-container {
            display: flex;
            align-items: center;
            height: 60px;
        }

        .barcode-container svg {
            height: 100%;
            width: auto;
        }

        .qrcode-container {
            display: flex;
            align-items: center;
            height: 90px;
        }

        .qrcode-container svg {
            height: 100%;
            width: auto;
        }

        .card-body {
            flex-grow: 1;
            display: flex;
            padding: 25px 35px 15px 35px;
            position: relative;
            background-color: #ffffff;
        }

        /* Photo Column */
        .photo-column {
            width: 250px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
        }

        .student-photo {
            width: 230px;
            height: 310px;
            object-fit: cover;
            border-radius: 16px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
            border: 2px solid #e5e7eb;
        }

        /* Info Column */
        .info-column {
            flex-grow: 1;
            padding-left: 35px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }

        .card-title {
            font-size: 34px;
            font-weight: 800;
            color: #111827;
            letter-spacing: 1px;
            margin-bottom: 18px;
            line-height: 1;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            font-size: 20px;
            line-height: 1.45;
            vertical-align: top;
            color: #1f2937;
            padding-bottom: 8px;
        }

        .label-cell {
            font-weight: 800;
            width: 140px;
            color: #111827;
        }

        .value-cell {
            font-weight: 600;
            color: #374151;
        }

        /* Footer Style */
        .footer {
            height: 72px;
            position: relative;
            background-color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: flex-end;
        }

        /* Left Yellow Wave/Decor */
        .footer-decor-left {
            position: absolute;
            bottom: 0;
            left: -10px;
            width: 230px;
            height: 65px;
            background-color: #fcb900;
            border-top-right-radius: 100%;
            z-index: 1;
        }

        /* Right Yellow Wave/Decor */
        .footer-decor-right {
            position: absolute;
            bottom: 0;
            right: -10px;
            width: 230px;
            height: 65px;
            background-color: #fcb900;
            border-top-left-radius: 100%;
            z-index: 1;
        }

        /* Dark Green Center Bar */
        .footer-bar {
            background-color: #064e3b;
            color: #ffffff;
            width: 62%;
            height: 50px;
            z-index: 2;
            border-top-left-radius: 16px;
            border-top-right-radius: 16px;
            display: flex;
            justify-content: space-evenly;
            align-items: center;
            padding: 0 20px;
            margin-bottom: 0px;
        }

        .footer-item {
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
            color: #ffffff;
            text-decoration: none;
        }

        .signature-title {
            font-size: 16px;
            color: #374151;
            margin-bottom: 55px;
            font-weight: 600;
        }

        .signature-name {
            font-size: 16px;
            font-weight: 800;
            color: #111827;
            border-bottom: 1.5px solid #111827;
            display: inline-block;
            padding: 0 10px;
        }

        /* Back Card specific styling */
        .back-card-body {
            padding: 40px 45px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background-color: #ffffff;
            position: relative;
            overflow: hidden;
            flex-grow: 1;
        }

        .watermark-logo {
            position: absolute;
            top: 45%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 320px;
            height: 320px;
            opacity: 0.05;
            pointer-events: none;
            z-index: 1;
        }

        .watermark-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .back-card-title {
            color: #064e3b;
            font-size: 26px;
            font-weight: 800;
            border-bottom: 2px solid #fcb900;
            padding-bottom: 8px;
            margin-bottom: 20px;
            letter-spacing: 0.5px;
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .back-card-rules {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 14px;
            z-index: 2;
            position: relative;
        }

        .back-card-rules li {
            display: flex;
            align-items: flex-start;
            gap: 15px;
        }

        .rule-number {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            background-color: #064e3b;
            color: #ffffff;
            font-size: 15px;
            font-weight: 800;
            border-radius: 50%;
            flex-shrink: 0;
            box-shadow: 0 3px 8px rgba(6, 78, 59, 0.2);
        }

        .rule-text {
            color: #374151;
            font-size: 18px;
            line-height: 1.5;
            font-weight: 500;
            padding-top: 3px;
            text-align: left;
        }

        .back-card-footer {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 15px;
            position: relative;
            z-index: 2;
            width: 100%;
        }

        .back-card-address {
            color: #4b5563;
            font-size: 15px;
            line-height: 1.4;
            max-width: 100%;
            text-align: center;
            width: 100%;
        }



        /* Portrait styling for back card */
        .id-card-wrapper.portrait .back-card-body {
            padding: 25px 25px !important;
            justify-content: flex-start !important;
            gap: 20px;
        }

        .id-card-wrapper.portrait .back-card-title {
            font-size: 21px !important;
            text-align: center;
        }

        .id-card-wrapper.portrait .back-card-rules {
            gap: 10px;
        }

        .id-card-wrapper.portrait .rule-number {
            width: 24px;
            height: 24px;
            font-size: 12px;
        }

        .id-card-wrapper.portrait .rule-text {
            font-size: 13px !important;
            padding-top: 1px;
        }

        .id-card-wrapper.portrait .watermark-logo {
            width: 200px;
            height: 200px;
        }

        .id-card-wrapper.portrait .back-card-footer {
            flex-direction: column !important;
            align-items: center !important;
            gap: 25px;
            margin-top: auto !important;
        }

        .id-card-wrapper.portrait .back-card-address {
            text-align: center;
            font-size: 11px !important;
            max-width: 100% !important;
        }

        .id-card-wrapper.portrait .back-card-signature {
            padding-right: 0 !important;
        }

        /* ========================================== */
        /* PORTRAIT ORIENTATION STYLES                */
        /* ========================================== */
        .id-card-wrapper.portrait {
            width: 638px;
            height: 1012px;
            transform: scale(0.55);
        }

        .id-card-wrapper.portrait .header {
            height: 155px;
            padding: 10px 15px;
        }

        .id-card-wrapper.portrait .logo-left,
        .id-card-wrapper.portrait .logo-right {
            width: 80px;
            height: 80px;
        }

        .id-card-wrapper.portrait .arabic-text {
            font-size: 18px;
        }

        .id-card-wrapper.portrait .arabic-logo-img {
            height: 38px;
        }

        .id-card-wrapper.portrait .institution-name {
            font-size: 21px;
            margin-top: 2px;
        }

        .id-card-wrapper.portrait .address-text {
            font-size: 10px;
            margin-top: 3px;
        }

        .id-card-wrapper.portrait .card-body {
            flex-direction: column;
            align-items: center;
            padding: 20px 25px;
        }

        .id-card-wrapper.portrait .photo-column {
            width: 100%;
            align-items: center;
            margin-bottom: 20px;
        }

        .id-card-wrapper.portrait .student-photo {
            width: 190px;
            height: 250px;
            border-radius: 12px;
        }

        .id-card-wrapper.portrait .info-column {
            width: 100%;
            padding-left: 0;
            align-items: center;
        }

        .id-card-wrapper.portrait .card-title {
            font-size: 26px;
            margin-bottom: 15px;
            text-align: center;
        }

        .id-card-wrapper.portrait .info-table {
            width: 100%;
        }

        .id-card-wrapper.portrait .info-table td {
            font-size: 17px;
            padding-bottom: 6px;
        }

        .id-card-wrapper.portrait .label-cell {
            width: 100px;
        }

        .id-card-wrapper.portrait .footer {
            height: 100px;
        }

        .id-card-wrapper.portrait .codes-row {
            justify-content: space-around;
            padding-right: 0;
            margin-top: 20px;
            height: 80px;
            width: 100%;
        }

        .id-card-wrapper.portrait .barcode-container {
            height: 45px;
        }

        .id-card-wrapper.portrait .qrcode-container {
            height: 80px;
        }

        .id-card-wrapper.portrait .footer-bar {
            width: 85%;
            height: 75px;
            flex-direction: column;
            justify-content: center;
            gap: 4px;
            padding: 5px;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }

        .id-card-wrapper.portrait .footer-decor-left,
        .id-card-wrapper.portrait .footer-decor-right {
            width: 130px;
            height: 50px;
        }

        /* Printing Specific Styles - Map exactly to 85.6mm x 54mm physical card */
        @media print {
            body {
                background-color: #ffffff;
                min-height: auto;
                padding: 0;
                display: block;
            }

            .id-card-wrapper {
                width: 85.6mm !important;
                height: 54mm !important;
                transform: none !important;
                box-shadow: none;
                border: none;
                margin: 0;
                border-radius: 0;
            }

            /* Proportional mm layouts for printer */
            .header { height: 15.5mm; padding: 1mm 2mm; }
            .header::after { height: 0.6mm; }
            .logo-left, .logo-right { width: 9.5mm; height: 9.5mm; }
            .arabic-text { font-size: 7.5pt; }
            .arabic-logo-img { height: 16pt; }
            .institution-name { font-size: 8.5pt; margin-top: 0.2mm; }
            .address-text { font-size: 3.5pt; margin-top: 0.3mm; }
            
            .card-body { padding: 2mm 3mm 1mm 3mm; }
            .photo-column { width: 21mm; }
            .student-photo { width: 20mm; height: 26mm; border-radius: 1.5mm; border-width: 0.5px; }
            
            .info-column { padding-left: 3mm; }
            .card-title { font-size: 11pt; margin-bottom: 1.5mm; }
            .info-table td { font-size: 6.2pt; padding-bottom: 2px; }
            .label-cell { width: 12mm; }
            
            .codes-row { height: 24mm; margin-top: 2mm; }
            .barcode-container { height: 16mm; }
            .qrcode-container { height: 24mm; }
            .footer { height: 6mm; }
            .footer-decor-left, .footer-decor-right { width: 20mm; height: 5.5mm; }
            .footer-bar { height: 4.2mm; border-top-left-radius: 1.5mm; border-top-right-radius: 1.5mm; }
            .footer-item { font-size: 3.5pt; gap: 0.5mm; }
            .footer-item i { font-size: 4pt; }
            
            /* PORTRAIT PRINT LAYOUT */
            .id-card-wrapper.portrait {
                width: 54mm !important;
                height: 85.6mm !important;
            }
            .id-card-wrapper.portrait .header {
                height: 14mm;
                padding: 1mm 2mm;
            }
            .id-card-wrapper.portrait .logo-left,
            .id-card-wrapper.portrait .logo-right {
                width: 7.5mm;
                height: 7.5mm;
            }
            .id-card-wrapper.portrait .arabic-text { font-size: 5pt; }
            .id-card-wrapper.portrait .arabic-logo-img { height: 11pt; }
            .id-card-wrapper.portrait .institution-name { font-size: 6.5pt; }
            .id-card-wrapper.portrait .address-text { font-size: 3pt; }
            
            .id-card-wrapper.portrait .codes-row { height: 18mm; margin-top: 3mm; }
            .id-card-wrapper.portrait .barcode-container { height: 10mm; }
            .id-card-wrapper.portrait .qrcode-container { height: 18mm; }
            .id-card-wrapper.portrait .card-body {
                padding: 2mm 3mm;
            }
            .id-card-wrapper.portrait .photo-column {
                margin-bottom: 1.5mm;
                width: 100%;
            }
            .id-card-wrapper.portrait .student-photo {
                width: 16mm;
                height: 21mm;
                border-radius: 1mm;
            }
            .id-card-wrapper.portrait .info-column {
                width: 100%;
                padding-left: 0;
            }
            .id-card-wrapper.portrait .card-title {
                font-size: 7.5pt;
                margin-bottom: 1mm;
            }
            .id-card-wrapper.portrait .info-table td {
                font-size: 5.2pt;
                padding-bottom: 1px;
            }
            .id-card-wrapper.portrait .label-cell {
                width: 8mm;
            }
            .id-card-wrapper.portrait .footer {
                height: 10mm;
            }
            .id-card-wrapper.portrait .footer-bar {
                width: 90%;
                height: 7mm;
                flex-direction: column;
                gap: 0.2mm;
            }
            .id-card-wrapper.portrait .footer-item {
                font-size: 3pt;
            }
            .id-card-wrapper.portrait .footer-decor-left,
            .id-card-wrapper.portrait .footer-decor-right {
                width: 10mm;
                height: 5mm;
            }

            /* Print style rules for back card elements */
            .back-card-body { padding: 3mm 4mm; }
            .back-card-title { font-size: 11pt; padding-bottom: 0.5mm; margin-bottom: 2mm; border-bottom-width: 0.5px; }
            .back-card-rules { gap: 1.8mm; }
            .rule-number { width: 4.8mm; height: 4.8mm; font-size: 5.5pt; box-shadow: none; }
            .rule-text { font-size: 7.2pt; line-height: 1.35; padding-top: 0.5mm; }
            .back-card-footer { margin-top: 2mm; display: flex; justify-content: center; width: 100%; }
            .back-card-address { font-size: 6pt; max-width: 100%; text-align: center; width: 100%; }
            .watermark-logo { width: 60mm; height: 60mm; }

            .id-card-wrapper.portrait .back-card-body { padding: 3mm 3mm !important; gap: 2.5mm; }
            .id-card-wrapper.portrait .back-card-title { font-size: 9.5pt !important; }
            .id-card-wrapper.portrait .back-card-rules { gap: 1.4mm; }
            .id-card-wrapper.portrait .rule-number { width: 3.5mm; height: 3.5mm; font-size: 4.5pt; }
            .id-card-wrapper.portrait .rule-text { font-size: 6.2pt !important; padding-top: 0.2mm; }
            .id-card-wrapper.portrait .watermark-logo { width: 40mm; height: 40mm; }

            .no-print {
                display: none;
            }

            #card-front, #card-back {
                display: flex !important;
            }

            .id-card-wrapper {
                page-break-after: always;
                break-after: page;
                margin: 0 !important;
                box-shadow: none !important;
                border: none !important;
                transform: none !important;
            }

            .id-card-wrapper.back-card {
                page-break-after: avoid;
                break-after: avoid;
            }

            body {
                padding: 0 !important;
                margin: 0 !important;
                background-color: #ffffff !important;
            }
        }

        /* Print Button Styles */
        .no-print-container {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 9999;
        }

        .print-btn {
            background-color: #064e3b;
            color: white;
            border: none;
            padding: 12px 24px;
            font-size: 15px;
            font-weight: bold;
            border-radius: 30px;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .print-btn:hover {
            background-color: #0b5e3a;
            transform: translateY(-2px);
            color: white;
        }
    </style>
</head>
<body>

    @php
        $orientation = request('orientation', 'landscape');
    @endphp

    <div class="no-print" style="margin-bottom: 20px; display: flex; gap: 15px; justify-content: center; width: 100%; max-width: 960px; z-index: 100;">
        <button class="tab-btn active" onclick="switchSide('front')" id="btn-front">
            <i class="fa-solid fa-id-card"></i> Sisi Depan
        </button>
        <button class="tab-btn" onclick="switchSide('back')" id="btn-back">
            <i class="fa-solid fa-rectangle-list"></i> Sisi Belakang
        </button>
    </div>

    <div class="cards-container">
        <!-- FRONT CARD -->
        <div id="card-front" class="id-card-wrapper {{ $orientation }}">
        <!-- Header -->
        <div class="header">
            @if ($pengaturan && $pengaturan->logo)
                <img src="{{ asset('storage/' . $pengaturan->logo) }}" alt="Logo Left" class="logo-left">
            @else
                <img src="{{ asset('assets/img/logo/persisalamin.png') }}" alt="Logo Left" class="logo-left">
            @endif
            <div class="header-text">
                <img src="{{ asset('assets/img/logo/mahad_arabic.png') }}" alt="Ma'had" class="arabic-logo-img">
                <span class="institution-name">{{ strtoupper($pendaftaran->nama_unit) }}</span>
                <span class="address-text">Jl. Ancol No.27, Sindangkasih, Kec. Sindangkasih, Kabupaten Ciamis, Jawa Barat 46268</span>
            </div>
            @if (!empty($pendaftaran->logo) && file_exists(public_path('storage/' . $pendaftaran->logo)))
                <img src="{{ asset('storage/' . $pendaftaran->logo) }}" alt="Logo Right" class="logo-right">
            @else
                <img src="{{ asset('assets/img/logo/' . strtolower($pendaftaran->kode_unit) . '.png') }}" alt="Logo Right" class="logo-right">
            @endif
        </div>

        <!-- Body -->
        <div class="card-body">
            <!-- Student Photo -->
            <div class="photo-column">
                @if ($pendaftaran->foto_pendaftaran && file_exists(public_path('storage/photos/pendaftaran/' . $pendaftaran->foto_pendaftaran)))
                    <img src="{{ asset('storage/photos/pendaftaran/' . $pendaftaran->foto_pendaftaran) }}" alt="Foto Santri" class="student-photo" onerror="this.onerror=null; this.outerHTML='<div class=\'student-photo\' style=\'display: flex; align-items: center; justify-content: center; background-color: #f3f4f6; border: 3px solid #064e3b; color: #9ca3af;\'><i class=\'fa-solid fa-user\' style=\'font-size: 80px;\'></i></div>';">
                @else
                    <div class="student-photo" style="display: flex; align-items: center; justify-content: center; background-color: #f3f4f6; border: 3px solid #064e3b; color: #9ca3af;">
                        <i class="fa-solid fa-user" style="font-size: 80px;"></i>
                    </div>
                @endif
            </div>

            <!-- Student Info -->
            <div class="info-column">
                <h3 class="card-title">KARTU SANTRI</h3>
                <table class="info-table">
                    <tr>
                        <td class="label-cell">NAMA</td>
                        <td style="width: 20px;">:</td>
                        <td class="value-cell">{{ strtoupper($pendaftaran->nama_lengkap) }}</td>
                    </tr>
                    <tr style="height: 10px;"><td></td></tr>
                    <tr>
                        <td class="label-cell">NIS</td>
                        <td>:</td>
                        <td class="value-cell">{{ $pendaftaran->nis ?? '-' }}</td>
                    </tr>
                    <tr style="height: 10px;"><td></td></tr>
                    <tr>
                        <td class="label-cell">T.T.L</td>
                        <td>:</td>
                        <td class="value-cell">{{ strtoupper($pendaftaran->tempat_lahir) }}, {{ $pendaftaran->tanggal_lahir ? date('d-m-Y', strtotime($pendaftaran->tanggal_lahir)) : '-' }}</td>
                    </tr>
                    <tr style="height: 10px;"><td></td></tr>
                    <tr>
                        <td class="label-cell">ALAMAT</td>
                        <td>:</td>
                        <td class="value-cell" style="font-size: 19px; line-height: 1.35; padding-right: 15px;">{{ strtoupper($pendaftaran->alamat) }}</td>
                    </tr>
                </table>
                <!-- Codes Row (Barcode left, QR Code right) -->
                <div class="codes-row">
                    <div class="barcode-container">
                        <svg id="barcode"></svg>
                    </div>
                    <div class="qrcode-container">
                        {!! QrCode::size(120)->margin(0)->generate($pendaftaran->id_siswa ?? $pendaftaran->nis ?? $pendaftaran->no_pendaftaran) !!}
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="footer-decor-left"></div>
            <div class="footer-decor-right"></div>
            <div class="footer-bar">
                <a href="https://persis80alamin.com" target="_blank" class="footer-item">
                    <i class="fa-solid fa-globe"></i>
                    <span>https://persis80alamin.com</span>
                </a>
                <a href="https://instagram.com/persis.alamin" target="_blank" class="footer-item">
                    <i class="fa-brands fa-instagram"></i>
                    <span>persis.alamin</span>
                </a>
                <a href="https://facebook.com" target="_blank" class="footer-item">
                    <i class="fa-brands fa-facebook"></i>
                    <span>Persis Al Amin</span>
                </a>
            </div>
        </div>
    </div>

    <!-- BACK CARD -->
    <div id="card-back" class="id-card-wrapper {{ $orientation }} back-card">

        <!-- Back Card Body -->
        <div class="card-body back-card-body">
            <!-- Watermark Logo -->
            <div class="watermark-logo">
                @if ($pengaturan && $pengaturan->logo)
                    <img src="{{ asset('storage/' . $pengaturan->logo) }}" alt="Watermark">
                @else
                    <img src="{{ asset('assets/img/logo/persisalamin.png') }}" alt="Watermark">
                @endif
            </div>

            <div>
                <h3 class="back-card-title">
                    <i class="fa-solid fa-circle-info" style="color: #fcb900;"></i>
                    KETENTUAN KARTU SANTRI
                </h3>
                <ul class="back-card-rules">
                    <li>
                        <span class="rule-number">1</span>
                        <span class="rule-text">Kartu ini adalah kartu identitas resmi Santri Pesantren Persatuan Islam 80 Al Amin.</span>
                    </li>
                    <li>
                        <span class="rule-number">2</span>
                        <span class="rule-text">Santri wajib membawa kartu ini selama berada di lingkungan Pesantren.</span>
                    </li>
                    <li>
                        <span class="rule-number">3</span>
                        <span class="rule-text">Apabila kartu ini hilang atau rusak, segera melapor ke bagian administrasi/kesantrian.</span>
                    </li>
                    <li>
                        <span class="rule-number">4</span>
                        <span class="rule-text">Penyalahgunaan kartu ini oleh pihak lain akan dikenakan sanksi tata tertib.</span>
                    </li>
                    <li>
                        <span class="rule-number">5</span>
                        <span class="rule-text">Barangsiapa menemukan kartu ini, harap mengembalikan ke alamat Pesantren.</span>
                    </li>
                </ul>
            </div>
            
            <div class="back-card-footer">
                <div class="back-card-address">
                    <strong>PESANTREN PERSATUAN ISLAM 80 AL AMIN</strong><br>
                    Jl. Ancol No.27, Sindangkasih, Kec. Sindangkasih, Kab. Ciamis, Jawa Barat 46268<br>
                    Telp: (0265) 378291 | Web: www.persis80alamin.com
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="footer-decor-left"></div>
            <div class="footer-decor-right"></div>
            <div class="footer-bar">
                <a href="https://persis80alamin.com" target="_blank" class="footer-item">
                    <i class="fa-solid fa-globe"></i>
                    <span>https://persis80alamin.com</span>
                </a>
                <a href="https://instagram.com/persis.alamin" target="_blank" class="footer-item">
                    <i class="fa-brands fa-instagram"></i>
                    <span>persis.amin</span>
                </a>
                <a href="https://facebook.com" target="_blank" class="footer-item">
                    <i class="fa-brands fa-facebook"></i>
                    <span>Persis Al Amin</span>
                </a>
            </div>
        </div>
    </div>
    </div>

    <!-- Print & Download Button Container -->
    <div class="no-print-container no-print" style="display: flex; gap: 10px;">
        @if ($orientation == 'portrait')
            <a href="{{ request()->fullUrlWithQuery(['orientation' => 'landscape']) }}" class="print-btn" style="background-color: #4b5563; color: white;">
                <i class="fa-solid fa-rotate-left"></i> Mode Landscape
            </a>
        @else
            <a href="{{ request()->fullUrlWithQuery(['orientation' => 'portrait']) }}" class="print-btn" style="background-color: #4b5563; color: white;">
                <i class="fa-solid fa-rotate-right"></i> Mode Portrait
            </a>
        @endif
        
        <button class="print-btn" onclick="window.print()">
            <i class="fa-solid fa-print"></i> Cetak Kartu (Depan & Belakang)
        </button>
        <button class="print-btn" onclick="downloadCard('front')" style="background-color: #fcb900; color: #111827;">
            <i class="fa-solid fa-download"></i> Download Depan
        </button>
        <button class="print-btn" onclick="downloadCard('back')" style="background-color: #fcb900; color: #111827;">
            <i class="fa-solid fa-download"></i> Download Belakang
        </button>
    </div>

    <script>
        // Generate Barcode at High-Res (CODE128 standard)
        window.onload = function() {
            JsBarcode("#barcode", "{{ $pendaftaran->nis ?? $pendaftaran->no_pendaftaran }}", {
                format: "CODE128",
                width: 2.0,
                height: 50,
                displayValue: false,
                fontSize: 14,
                fontOptions: "bold",
                margin: 0
            });
        };

        // Switch active side preview on screen
        function switchSide(side) {
            const front = document.getElementById('card-front');
            const back = document.getElementById('card-back');
            const btnFront = document.getElementById('btn-front');
            const btnBack = document.getElementById('btn-back');

            if (side === 'front') {
                front.style.display = 'flex';
                back.style.display = 'none';
                btnFront.classList.add('active');
                btnBack.classList.remove('active');
            } else {
                front.style.display = 'none';
                back.style.display = 'flex';
                btnFront.classList.remove('active');
                btnBack.classList.add('active');
            }
        }

        // Download Card as Image
        function downloadCard(side) {
            const selector = side === 'front' ? '#card-front' : '#card-back';
            const card = document.querySelector(selector);
            
            // Capture original display style to restore later
            const originalDisplay = card.style.display;
            
            // Temporarily reset transform scale for crisp, 1:1 render size conversion
            const originalTransform = card.style.transform;
            const originalShadow = card.style.boxShadow;
            const originalBorder = card.style.border;
            const originalMargin = card.style.margin;
            
            card.style.display = 'flex';
            card.style.transform = 'none';
            card.style.boxShadow = 'none';
            card.style.border = 'none';
            card.style.margin = '0';

            // Wait brief moment for layout changes to settle
            setTimeout(() => {
                html2canvas(card, {
                    scale: 2, // 2x of size results in high resolution (Printers require ~300-600 DPI)
                    useCORS: true,
                    allowTaint: true,
                    backgroundColor: null,
                    logging: false
                }).then(canvas => {
                    // Restore styles
                    card.style.transform = originalTransform;
                    card.style.boxShadow = originalShadow;
                    card.style.border = originalBorder;
                    card.style.margin = originalMargin;
                    card.style.display = originalDisplay;

                    // Trigger browser download
                    const link = document.createElement('a');
                    link.download = `ID_Card_${side === 'front' ? 'Depan' : 'Belakang'}_{{ str_replace(' ', '_', $pendaftaran->nama_lengkap) }}.png`;
                    link.href = canvas.toDataURL('image/png');
                    link.click();
                }).catch(err => {
                    alert('Gagal mendownload gambar: ' + err.message);
                    card.style.transform = originalTransform;
                    card.style.boxShadow = originalShadow;
                    card.style.border = originalBorder;
                    card.style.margin = originalMargin;
                    card.style.display = originalDisplay;
                });
            }, 100);
        }
    </script>

</body>
</html>

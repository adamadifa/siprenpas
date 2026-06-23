@extends('layouts.mobile.app')
@section('content')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    @php
        $bgUrl = ($pengaturan && $pengaturan->background_login) 
            ? asset('storage/' . $pengaturan->background_login) 
            : asset('images/bgalamin.png');
            
        $logoUrl = ($pengaturan && $pengaturan->logo) 
            ? asset('storage/' . $pengaturan->logo) 
            : asset('assets/img/logo/persisalamin.png');
    @endphp

    <style>
        :root {
            --primary: #064e3b;      /* Solid Dark Green */
            --primary-light: #0d6d53;
            --accent: #10b981;       /* Solid Accent Green */
            --surface: #ffffff;
            --background: #f8fafc;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
        }

        body {
            background: var(--background) !important;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
            color: var(--text-main);
        }

        #guru-dashboard {
            max-width: 480px;
            margin: 0 auto;
        }

        /* Header Greeting - SOLID OVERLAY, BG IMAGE FROM SETTINGS, SHARP */
        .guru-header {
            background: var(--primary);
            padding: 20px 20px 48px 20px;
            position: relative;
            overflow: hidden;
        }

        .dashboard-body {
            background: var(--background);
            border-radius: 30px 30px 0 0;
            margin-top: -30px;
            padding: 12px 0 100px 0;
            position: relative;
            z-index: 5;
        }

        .guru-header::before {
            content: "";
            position: absolute;
            inset: 0;
            background: url('{{ $bgUrl }}') no-repeat center center;
            background-size: cover;
            opacity: 0.05; /* Subtle background image overlay */
            z-index: 1;
            pointer-events: none;
        }

        /* Ensure all direct children are above the pseudo-element background overlay */
        .guru-header > * {
            position: relative;
            z-index: 2;
        }

        /* Top Action Bar for Logo & Logout */
        .header-top-action {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
        }

        .brand-logo-container {
            display: flex;
            align-items: center;
            height: 42px;
        }

        .brand-logo-img {
            height: 42px;
            width: auto;
            object-fit: contain;
            display: block;
        }

        .guru-logout-btn {
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 6px 12px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .guru-logout-btn:active {
            background: rgba(255, 255, 255, 0.25);
        }

        .guru-logout-btn ion-icon {
            font-size: 16px;
            color: #ffffff;
        }

        .guru-logout-btn span {
            font-size: 0.72rem;
            font-weight: 600;
            color: #ffffff;
        }

        /* Profile Row */
        .guru-header-profile {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-bottom: 4px;
        }

        .profile-left {
            flex: 1;
            min-width: 0;
        }

        .profile-right {
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .guru-greeting {
            color: rgba(255, 255, 255, 0.85);
            font-size: 0.85rem;
            font-weight: 500;
            margin-bottom: 2px;
        }

        .guru-name {
            color: #ffffff;
            font-size: 1.25rem;
            font-weight: 700;
            margin: 0 0 6px 0;
            line-height: 1.3;
        }

        .guru-badges-row {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-top: 8px;
            align-items: center;
        }

        .guru-role-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 255, 255, 0.15);
            color: #ffffff;
            font-size: 0.7rem;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 6px;
            border: 1px solid rgba(255, 255, 255, 0.25);
        }

        /* Profile Photo - Larger but symmetrical */
        .guru-avatar {
            width: 84px;
            height: 84px;
            border-radius: 50%;
            background: #ffffff;
            border: 2.5px solid #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
        }

        .guru-avatar-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .guru-avatar-placeholder {
            width: 100%;
            height: 100%;
            background: #ecfdf5;
            color: var(--primary);
            font-size: 1.85rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Homeroom Class Card Slider - Swipeable & Borderless */
        .homeroom-slider-container {
            display: flex;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
            padding: 12px 16px 16px 16px;
            gap: 12px;
        }

        .homeroom-slider-container::-webkit-scrollbar {
            display: none;
        }

        .homeroom-slider-container {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .homeroom-slider-item {
            flex: 0 0 85%;
            scroll-snap-align: start;
            transition: all 0.25s ease;
        }

        .homeroom-slider-container.single-item .homeroom-slider-item {
            flex: 0 0 100%;
        }

        a.homeroom-card {
            background: var(--surface);
            border: none;
            border-radius: 16px;
            padding: 16px;
            display: flex;
            align-items: center;
            gap: 14px;
            box-shadow: 0 4px 16px rgba(6, 78, 59, 0.05);
            position: relative;
            text-decoration: none !important;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        a.homeroom-card:active {
            transform: scale(0.97);
            background: #f8fafc;
        }

        .homeroom-icon {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            background: var(--primary);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
        }

        .homeroom-info {
            flex: 1;
            min-width: 0;
        }

        .homeroom-label {
            font-size: 0.65rem;
            font-weight: 700;
            color: var(--primary-light);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            display: block;
            margin-bottom: 2px;
        }

        .homeroom-title {
            font-size: 1.05rem;
            font-weight: 800;
            color: var(--text-main);
            margin: 0;
            line-height: 1.2;
        }

        .homeroom-students {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-muted);
            display: inline-block;
            margin-top: 2px;
        }

        .homeroom-action {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: rgba(6, 78, 59, 0.08);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            transition: all 0.2s ease;
        }

        /* Slider Dots Indicator */
        .slider-dots {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 6px;
            margin-top: -4px;
            margin-bottom: 16px;
        }

        .slider-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: rgba(6, 78, 59, 0.15);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .slider-dot.active {
            background: var(--primary);
            width: 16px;
            border-radius: 3px;
        }

        /* Section Layout */
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 16px;
            margin-top: 24px;
            margin-bottom: 12px;
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--text-main);
        }

        .section-title ion-icon {
            color: var(--primary);
            font-size: 20px;
        }

        .count-badge {
            font-size: 0.72rem;
            font-weight: 700;
            color: var(--primary);
            background: var(--surface);
            border: 1.5px solid var(--primary);
            padding: 2px 8px;
            border-radius: 6px;
        }

        /* Timeline / Agenda Style for Schedules - Connected & Clean */
        .schedule-timeline {
            padding: 0 16px;
            position: relative;
        }

        .schedule-timeline::before {
            content: "";
            position: absolute;
            left: 46px; /* Middle of 60px timeline-time + padding 16px */
            top: 20px;
            bottom: 20px;
            width: 2px;
            background: #e2e8f0;
            z-index: 0;
        }

        .timeline-item {
            display: flex;
            gap: 14px;
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
            align-items: flex-start;
        }

        .timeline-time {
            width: 60px;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background: transparent;
            border: none;
            padding: 4px 0;
            text-align: center;
            z-index: 1;
        }

        .time-hours {
            font-size: 0.95rem;
            font-weight: 800;
            color: var(--primary);
            line-height: 1;
        }

        .time-period {
            font-size: 0.65rem;
            font-weight: 700;
            color: var(--text-muted);
            margin-top: 4px;
        }

        .timeline-body {
            flex: 1;
            background: var(--surface);
            border: none;
            border-radius: 16px;
            padding: 16px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            box-shadow: 0 4px 16px rgba(6, 78, 59, 0.05);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .timeline-body:active {
            transform: scale(0.99);
        }

        .btn-action-presensi {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            font-size: 0.78rem;
            font-weight: 700;
            padding: 10px 14px;
            border-radius: 10px;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-action-presensi:active {
            transform: scale(0.97);
            opacity: 0.9;
        }

        .schedule-subject {
            font-size: 0.82rem;
            font-weight: 700;
            color: var(--text-main);
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .schedule-class {
            font-size: 0.72rem;
            font-weight: 500;
            color: var(--text-muted);
            display: block;
            margin-top: 2px;
        }

        /* Status Badge */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 0.65rem;
            font-weight: 700;
            padding: 4px 8px;
            border-radius: 6px;
            white-space: nowrap;
        }

        .status-badge.success {
            background: #ecfdf5;
            color: #047857;
            border: 1px solid #a7f3d0;
        }

        .status-badge.pending {
            background: #fffbeb;
            color: #b45309;
            border: 1px solid #fde68a;
        }

        .status-badge ion-icon {
            font-size: 11px;
        }

        .empty-state {
            background: var(--surface);
            border: 2px solid var(--border-color);
            border-radius: 12px;
            padding: 36px 16px;
            text-align: center;
            box-shadow: var(--shadow-sm);
        }

        .empty-state ion-icon {
            font-size: 40px;
            color: #cbd5e1;
            margin-bottom: 8px;
        }

        .empty-state h4 {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--text-main);
            margin: 0 0 4px;
        }

        .empty-state p {
            font-size: 0.72rem;
            color: var(--text-muted);
            margin: 0;
        }

        /* Modern Clean Bordered Menu Grid */
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            padding: 0 16px;
        }

        .menu-item {
            border-radius: 16px;
            padding: 18px 14px;
            text-align: center;
            text-decoration: none !important;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 0 2px 8px rgba(6, 78, 59, 0.02);
        }

        .menu-item:active {
            transform: scale(0.96);
        }

        /* White Card with Green Border */
        .menu-item.menu-white {
            background: var(--surface);
            border: 1.5px solid var(--primary);
        }

        .menu-item.menu-white .menu-icon {
            background: rgba(6, 78, 59, 0.08);
            color: var(--primary);
        }

        .menu-item.menu-white .menu-label {
            color: var(--text-main);
        }

        .menu-item.menu-white .menu-desc {
            color: var(--text-muted);
        }

        /* Featured Green Card */
        .menu-item.menu-featured-green {
            background: var(--primary);
            border: 1.5px solid var(--primary);
            box-shadow: 0 4px 14px rgba(6, 78, 59, 0.15);
        }

        .menu-item.menu-featured-green .menu-icon {
            background: rgba(255, 255, 255, 0.18);
            color: #ffffff;
        }

        .menu-item.menu-featured-green .menu-label {
            color: #ffffff;
        }

        .menu-item.menu-featured-green .menu-desc {
            color: rgba(255, 255, 255, 0.8);
        }

        .menu-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            font-size: 20px;
            transition: all 0.2s ease;
        }

        .menu-item:active .menu-icon {
            transform: scale(0.92);
        }

        .menu-label {
            font-size: 0.78rem;
            font-weight: 700;
            display: block;
            margin-bottom: 2px;
        }

        .menu-desc {
            font-size: 0.62rem;
            font-weight: 500;
            display: block;
        }

        /* Bottom Navigation */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: var(--surface);
            border-top: 2px solid var(--border-color);
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding: 8px 0;
            padding-bottom: max(8px, env(safe-area-inset-bottom));
            z-index: 1000;
            box-shadow: 0 -4px 10px rgba(0, 0, 0, 0.02);
        }

        .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 3px;
            text-decoration: none;
            padding: 6px 12px;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .nav-item ion-icon {
            font-size: 22px;
            color: var(--text-muted);
        }

        .nav-item span {
            font-size: 0.65rem;
            font-weight: 500;
            color: var(--text-muted);
        }

        .nav-item.active ion-icon {
            color: var(--primary);
        }

        .nav-item.active span {
            color: var(--primary);
            font-weight: 700;
        }
    </style>

    <div id="guru-dashboard">
        {{-- Header Greeting --}}
        <div class="guru-header">
            <!-- Top Action Bar for brand logo and logout button -->
            <div class="header-top-action">
                <div class="brand-logo-container">
                    <img src="{{ $logoUrl }}" alt="Logo" class="brand-logo-img">
                </div>
                <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                    @csrf
                    <a href="#" class="guru-logout-btn" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
                        <ion-icon name="log-out-outline"></ion-icon>
                        <span>Keluar</span>
                    </a>
                </form>
            </div>

            <!-- Profile Info Row (flex layout for clean symmetry) -->
            <div class="guru-header-profile">
                <div class="profile-left">
                    <div class="guru-greeting">{{ $sapaan }}</div>
                    <h2 class="guru-name">{{ $guru->nama_guru }}</h2>
                    <div class="guru-badges-row">
                        <div class="guru-role-badge">
                            <ion-icon name="school-outline"></ion-icon>
                            <span>{{ $guru->unit ? $guru->unit->nama_unit : 'Guru' }}</span>
                        </div>
                        <div class="guru-role-badge">
                            <ion-icon name="calendar-outline"></ion-icon>
                            <span>{{ $hariIni }}, {{ DateToIndo(date('Y-m-d')) }}</span>
                        </div>
                        @if($activeTa)
                            <div class="guru-role-badge">
                                <ion-icon name="bookmark-outline"></ion-icon>
                                <span>TA {{ $activeTa->tahun_ajaran }}</span>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="profile-right">
                    <div class="guru-avatar">
                        @if($guru->karyawan && $guru->karyawan->foto && \Storage::disk('public')->exists('photos/karyawan/' . $guru->karyawan->foto))
                            <img src="{{ asset('storage/photos/karyawan/' . $guru->karyawan->foto) }}" alt="{{ $guru->nama_guru }}" class="guru-avatar-img">
                        @else
                            <div class="guru-avatar-placeholder">
                                @php
                                    $names = explode(' ', $guru->nama_guru);
                                    $initials = '';
                                    if (count($names) > 0) {
                                        $initials .= strtoupper(substr($names[0], 0, 1));
                                    }
                                    if (count($names) > 1) {
                                        $initials .= strtoupper(substr($names[1], 0, 1));
                                    }
                                @endphp
                                <span>{{ $initials ?: 'G' }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="dashboard-body">
            {{-- Homeroom Section (Displayed ONLY if Guru is Wali Kelas) --}}
        @if($listKelasBinaan && $listKelasBinaan->isNotEmpty())
            <!-- Section Header for Wali Kelas -->
            <div class="section-header" style="margin-top: 24px; margin-bottom: 0;">
                <div class="section-title">
                    <ion-icon name="people-outline"></ion-icon>
                    <span>Kelas Binaan (Wali Kelas)</span>
                </div>
                <span class="count-badge">{{ $listKelasBinaan->count() }} Kelas</span>
            </div>

            <!-- Swipeable Slider Container -->
            <div class="homeroom-slider-container {{ $listKelasBinaan->count() === 1 ? 'single-item' : '' }}">
                @foreach($listKelasBinaan as $kelas)
                    <div class="homeroom-slider-item">
                        <a href="{{ route('wali-kelas.index', ['kode_kelas' => $kelas->kode_kelas]) }}" class="homeroom-card">
                            <div class="homeroom-icon">
                                <ion-icon name="school-outline"></ion-icon>
                            </div>
                            <div class="homeroom-info">
                                <span class="homeroom-label">Kelas Binaan</span>
                                <h3 class="homeroom-title">
                                    Kelas {{ $kelas->nama_kelas }}
                                </h3>
                                <span class="homeroom-students">
                                    {{ $kelas->siswa()->count() }} Siswa Terdaftar
                                </span>
                            </div>
                            <div class="homeroom-action">
                                <ion-icon name="chevron-forward-outline"></ion-icon>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <!-- Dots Indicator for Slider (only if count > 1) -->
            @if($listKelasBinaan->count() > 1)
                <div class="slider-dots">
                    @foreach($listKelasBinaan as $index => $kelas)
                        <span class="slider-dot {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}"></span>
                    @endforeach
                </div>
            @endif
        @endif

        {{-- Jadwal Hari Ini --}}
        <div class="section-header">
            <div class="section-title">
                <ion-icon name="today-outline"></ion-icon>
                <span>Jadwal Mengajar Hari Ini</span>
            </div>
            <span class="count-badge">{{ $jadwalHariIni->count() }} Jadwal</span>
        </div>

        <div class="schedule-timeline">
            @forelse ($jadwalHariIni as $jadwal)
                <div class="timeline-item">
                    <div class="timeline-time">
                        <span class="time-hours">{{ $jadwal->jam_mulai ? substr($jadwal->jam_mulai, 0, 5) : '-' }}</span>
                        <span class="time-period">Jam ke-{{ $jadwal->jam_ke }}</span>
                    </div>
                    <div class="timeline-body">
                        <!-- Top Row: Subject Info & Status Badge -->
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 8px;">
                            <div style="flex: 1; min-width: 0;">
                                <h4 class="schedule-subject" style="color: var(--text-main); font-weight: 700; margin-bottom: 4px;">
                                    {{ $jadwal->mapel ? $jadwal->mapel->nama_matpel : 'Mata Pelajaran' }}
                                </h4>
                                <span class="schedule-class" style="display: flex; align-items: center; gap: 4px; font-weight: 600; color: var(--text-muted); font-size: 0.72rem;">
                                    <ion-icon name="business-outline" style="color: var(--primary); font-size: 13px;"></ion-icon>
                                    Kelas {{ $jadwal->kelas ? $jadwal->kelas->nama_kelas : '-' }}
                                </span>
                            </div>
                            <div>
                                @if($jadwal->sudah_presensi)
                                    <span class="status-badge success">
                                        <ion-icon name="checkmark-circle-outline"></ion-icon>
                                        Selesai
                                    </span>
                                @else
                                    <span class="status-badge pending">
                                        <ion-icon name="time-outline"></ion-icon>
                                        Belum
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Action Button for Attendance Input/Edit -->
                        @if($jadwal->sudah_presensi)
                            <a href="{{ route('presensi-mapel.input', ['jadwal_id' => Crypt::encrypt($jadwal->id), 'tanggal' => date('Y-m-d')]) }}" 
                               class="btn-action-presensi" 
                               style="background: rgba(6, 78, 59, 0.08); color: var(--primary);">
                                <ion-icon name="create-outline"></ion-icon>
                                <span>Edit Presensi</span>
                            </a>
                        @else
                            <a href="{{ route('presensi-mapel.input', ['jadwal_id' => Crypt::encrypt($jadwal->id), 'tanggal' => date('Y-m-d')]) }}" 
                               class="btn-action-presensi" 
                               style="background: var(--primary); color: #ffffff; box-shadow: 0 4px 10px rgba(6, 78, 59, 0.2);">
                                <ion-icon name="checkbox-outline"></ion-icon>
                                <span>Input Presensi</span>
                            </a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <ion-icon name="calendar-outline"></ion-icon>
                    <h4>Tidak ada jadwal hari ini</h4>
                    <p>Hari ini Anda tidak memiliki jadwal mengajar</p>
                </div>
            @endforelse
        </div>

        {{-- Menu Cepat --}}
        <div class="section-header">
            <div class="section-title">
                <ion-icon name="apps-outline"></ion-icon>
                <span>Menu Cepat</span>
            </div>
        </div>

        <div class="menu-grid">
            <a href="{{ route('jadwal-pelajaran.index') }}" class="menu-item menu-white">
                <div class="menu-icon">
                    <ion-icon name="calendar-outline"></ion-icon>
                </div>
                <span class="menu-label">Jadwal Pelajaran</span>
                <span class="menu-desc">Lihat semua jadwal</span>
            </a>
            <a href="{{ route('presensi-mapel.index') }}" class="menu-item menu-featured-green">
                <div class="menu-icon">
                    <ion-icon name="checkbox-outline"></ion-icon>
                </div>
                <span class="menu-label">Presensi Siswa</span>
                <span class="menu-desc">Input kehadiran</span>
            </a>
            <a href="/rapor" class="menu-item menu-white">
                <div class="menu-icon">
                    <ion-icon name="document-text-outline"></ion-icon>
                </div>
                <span class="menu-label">Rapor</span>
                <span class="menu-desc">Kelola rapor siswa</span>
            </a>
            @if($isKoordinator)
                <a href="{{ route('rapor-siswa.index') }}" class="menu-item menu-white">
                    <div class="menu-icon">
                        <ion-icon name="star-outline"></ion-icon>
                    </div>
                    <span class="menu-label">Ekstrakurikuler</span>
                    <span class="menu-desc">Input nilai ekskul</span>
                </a>
            @endif
            @if($kelasBinaan)
                <a href="{{ route('wali-kelas.index') }}" class="menu-item menu-white">
                    <div class="menu-icon">
                        <ion-icon name="people-circle-outline"></ion-icon>
                    </div>
                    <span class="menu-label">Wali Kelas</span>
                    <span class="menu-desc">Monitoring kelas</span>
                </a>
            @else
                @if(!$isKoordinator)
                    <a href="{{ route('jadwal-pelajaran.index') }}" class="menu-item menu-white">
                        <div class="menu-icon">
                            <ion-icon name="book-outline"></ion-icon>
                        </div>
                        <span class="menu-label">Mata Pelajaran</span>
                        <span class="menu-desc">Daftar mapel</span>
                    </a>
                @endif
            @endif
        </div>
        </div>
    </div>

    {{-- Bottom Navigation --}}
    <div class="bottom-nav">
        <a href="{{ route('dashboard.index') }}" class="nav-item active">
            <ion-icon name="home"></ion-icon>
            <span>Beranda</span>
        </a>
        <a href="{{ route('jadwal-pelajaran.index') }}" class="nav-item">
            <ion-icon name="calendar-outline"></ion-icon>
            <span>Jadwal</span>
        </a>
        <a href="{{ route('presensi-mapel.index') }}" class="nav-item">
            <ion-icon name="checkbox-outline"></ion-icon>
            <span>Presensi</span>
        </a>
        <a href="{{ route('users.editpassword', Crypt::encrypt(Auth::user()->id)) }}" class="nav-item">
            <ion-icon name="person-outline"></ion-icon>
            <span>Profil</span>
        </a>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.querySelector('.homeroom-slider-container');
            const dots = document.querySelectorAll('.slider-dots .slider-dot');
            
            if (container && dots.length > 0) {
                container.addEventListener('scroll', function() {
                    const scrollLeft = container.scrollLeft;
                    const item = container.querySelector('.homeroom-slider-item');
                    if (item) {
                        const itemWidth = item.offsetWidth + 12; // width + gap
                        const activeIndex = Math.round(scrollLeft / itemWidth);
                        
                        dots.forEach((dot, idx) => {
                            if (idx === activeIndex) {
                                dot.classList.add('active');
                            } else {
                                dot.classList.remove('active');
                            }
                        });
                    }
                });
            }
        });
    </script>
@endsection

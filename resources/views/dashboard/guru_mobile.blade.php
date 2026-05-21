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
            padding: 0 0 100px 0;
            max-width: 480px;
            margin: 0 auto;
        }

        /* Header Greeting - SOLID OVERLAY, BG IMAGE FROM SETTINGS, SHARP */
        .guru-header {
            background: var(--primary);
            border-bottom: 4px solid var(--accent);
            border-radius: 0 0 20px 20px;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        .guru-header::before {
            content: "";
            position: absolute;
            inset: 0;
            background: url('{{ $bgUrl }}') no-repeat center center;
            background-size: cover;
            opacity: 0.22; /* Subtle background image overlay */
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

        .guru-date {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.75rem;
            margin-top: 12px;
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: 500;
        }

        .guru-date ion-icon {
            font-size: 14px;
        }

        .ta-badge {
            background: rgba(255, 255, 255, 0.18);
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: 600;
            font-size: 0.65rem;
            margin-left: 6px;
        }

        /* Homeroom Class Card - ONLY DISPLAYED IF WALI KELAS */
        .homeroom-card {
            background: var(--surface);
            border: 2px solid var(--border-color);
            border-radius: 14px;
            padding: 16px;
            margin: 16px 16px 0;
            display: flex;
            align-items: center;
            gap: 14px;
            box-shadow: var(--shadow-md);
            position: relative;
            transition: all 0.2s ease;
        }

        .homeroom-card:active {
            border-color: var(--primary);
            background: #f8fafc;
        }

        .homeroom-icon {
            width: 46px;
            height: 46px;
            border-radius: 10px;
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
            color: var(--text-muted);
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
            color: var(--primary-light);
            display: inline-block;
            margin-top: 2px;
        }

        .homeroom-action {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: #f1f5f9;
            color: var(--text-main);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .homeroom-card:active .homeroom-action {
            background: var(--primary);
            color: #ffffff;
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

        /* Timeline / Agenda Style for Schedules */
        .schedule-timeline {
            padding: 0 16px;
        }

        .timeline-item {
            display: flex;
            gap: 14px;
            margin-bottom: 12px;
            position: relative;
        }

        .timeline-time {
            width: 65px;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background: var(--surface);
            border: 2px solid var(--border-color);
            border-radius: 10px;
            padding: 8px 4px;
            text-align: center;
        }

        .time-hours {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--primary);
        }

        .time-period {
            font-size: 0.58rem;
            font-weight: 600;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .timeline-body {
            flex: 1;
            background: var(--surface);
            border: 2px solid var(--border-color);
            border-radius: 10px;
            padding: 10px 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            box-shadow: var(--shadow-sm);
            transition: all 0.2s ease;
        }

        .timeline-body:active {
            border-color: var(--primary);
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

        /* Menu Grid */
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            padding: 0 16px;
        }

        .menu-item {
            background: var(--surface);
            border: 2px solid var(--border-color);
            border-radius: 12px;
            padding: 16px 12px;
            text-align: center;
            text-decoration: none;
            transition: all 0.2s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: var(--shadow-sm);
        }

        .menu-item:active {
            border-color: var(--primary);
            transform: translateY(1px);
        }

        .menu-icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            background: var(--background);
            border: 1.5px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            color: var(--primary);
            font-size: 20px;
            transition: all 0.2s ease;
        }

        .menu-item:hover .menu-icon,
        .menu-item:active .menu-icon {
            background: var(--primary);
            border-color: var(--primary);
            color: #ffffff;
        }

        .menu-label {
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--text-main);
            display: block;
        }

        .menu-desc {
            font-size: 0.62rem;
            font-weight: 500;
            color: var(--text-muted);
            margin-top: 2px;
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
                    <div class="guru-greeting">{{ $sapaan }} 👋</div>
                    <h2 class="guru-name">{{ $guru->nama_guru }}</h2>
                    <div class="guru-role-badge">
                        <ion-icon name="school-outline"></ion-icon>
                        {{ $guru->unit ? $guru->unit->nama_unit : 'Guru' }}
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

            <!-- Date and Academic Year -->
            <div class="guru-date">
                <ion-icon name="calendar-outline"></ion-icon>
                <span>{{ $hariIni }}, {{ DateToIndo(date('Y-m-d')) }}</span>
                @if($activeTa)
                    <span class="ta-badge">TA {{ $activeTa->tahun_ajaran }}</span>
                @endif
            </div>
        </div>

        {{-- Homeroom Section (Displayed ONLY if Guru is Wali Kelas) --}}
        @if($kelasBinaan)
            <div class="homeroom-card">
                <div class="homeroom-icon">
                    <ion-icon name="people-outline"></ion-icon>
                </div>
                <div class="homeroom-info">
                    <span class="homeroom-label">Kelas Binaan Anda</span>
                    <h3 class="homeroom-title">
                        Kelas {{ $listKelasBinaan->pluck('nama_kelas')->implode(', ') }}
                    </h3>
                    <span class="homeroom-students">{{ $totalSiswa }} Siswa Terdaftar</span>
                </div>
                <a href="{{ route('wali-kelas.index') }}" class="homeroom-action" title="Halaman Wali Kelas">
                    <ion-icon name="chevron-forward-outline"></ion-icon>
                </a>
            </div>
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
                        <div class="schedule-details">
                            <h4 class="schedule-subject">{{ $jadwal->mapel ? $jadwal->mapel->nama_matpel : 'Mata Pelajaran' }}</h4>
                            <span class="schedule-class">Kelas {{ $jadwal->kelas ? $jadwal->kelas->nama_kelas : '-' }}</span>
                        </div>
                        <div class="schedule-action">
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
            <a href="{{ route('jadwal-pelajaran.index') }}" class="menu-item">
                <div class="menu-icon">
                    <ion-icon name="calendar-outline"></ion-icon>
                </div>
                <span class="menu-label">Jadwal Pelajaran</span>
                <span class="menu-desc">Lihat semua jadwal</span>
            </a>
            <a href="{{ route('presensi-mapel.index') }}" class="menu-item">
                <div class="menu-icon">
                    <ion-icon name="checkbox-outline"></ion-icon>
                </div>
                <span class="menu-label">Presensi Siswa</span>
                <span class="menu-desc">Input kehadiran</span>
            </a>
            <a href="{{ route('jadwal-pelajaran.index') }}" class="menu-item">
                <div class="menu-icon">
                    <ion-icon name="stats-chart-outline"></ion-icon>
                </div>
                <span class="menu-label">Penilaian</span>
                <span class="menu-desc">Kelola nilai siswa</span>
            </a>
            @if($kelasBinaan)
                <a href="{{ route('wali-kelas.index') }}" class="menu-item">
                    <div class="menu-icon">
                        <ion-icon name="people-circle-outline"></ion-icon>
                    </div>
                    <span class="menu-label">Wali Kelas</span>
                    <span class="menu-desc">Monitoring kelas</span>
                </a>
            @else
                <a href="{{ route('jadwal-pelajaran.index') }}" class="menu-item">
                    <div class="menu-icon">
                        <ion-icon name="book-outline"></ion-icon>
                    </div>
                    <span class="menu-label">Mata Pelajaran</span>
                    <span class="menu-desc">Daftar mapel</span>
                </a>
            @endif
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
@endsection

@extends('layouts.mobile.app_sipren')

@section('title', 'Wali Kelas - Sipren')
@section('header-title', 'Kelas Binaan')
@section('back-url', route('dashboard.index'))
@section('show-bottom-nav', true)

@push('styles')
    <style>
        .wali-kelas-container {
            padding: 16px;
            padding-bottom: 100px; /* Safe-area padding for bottom-nav */
        }

        /* Gradient Class Info Card */
        .info-card {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(6, 78, 59, 0.12);
            padding: 20px;
            border: none;
            color: #ffffff;
            margin-bottom: 16px;
            position: relative;
            overflow: hidden;
        }

        .info-card::after {
            content: '';
            position: absolute;
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            top: -50px;
            right: -50px;
        }

        .info-class {
            font-size: 1.35rem;
            font-weight: 800;
            margin: 0 0 6px 0;
            line-height: 1.2;
            letter-spacing: -0.02em;
        }

        .info-meta {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.85);
            font-weight: 500;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }

        .info-meta span {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Class Selector Field */
        .class-select-group {
            display: flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            padding: 8px 12px;
            margin-top: 14px;
            color: #ffffff;
        }

        .class-select-group select {
            border: none !important;
            background: transparent !important;
            color: #ffffff !important;
            font-size: 0.82rem !important;
            font-weight: 700 !important;
            outline: none !important;
            width: 100% !important;
            height: auto !important;
            box-shadow: none !important;
            margin: 0;
            cursor: pointer;
            -webkit-appearance: none;
            appearance: none;
            padding-right: 20px !important;
        }

        /* Teacher Profile Widget */
        .profile-card {
            background: var(--surface);
            border-radius: 14px;
            padding: 14px 16px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.03);
            border: 1px solid var(--border-color);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .profile-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: rgba(6, 78, 59, 0.08);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
        }

        .profile-info {
            flex: 1;
            min-width: 0;
        }

        .profile-name {
            font-size: 0.88rem;
            font-weight: 700;
            color: var(--text-main);
            margin: 0 0 2px 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .profile-npp {
            font-size: 0.72rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        /* Segment Tab Pills */
        .tab-segment {
            background: #e2e8f0;
            border-radius: 12px;
            padding: 4px;
            display: flex;
            gap: 4px;
            margin-bottom: 18px;
        }

        .segment-btn {
            flex: 1;
            border: none;
            background: transparent;
            color: var(--text-muted);
            font-size: 0.8rem;
            font-weight: 700;
            padding: 10px 4px;
            border-radius: 9px;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            outline: none !important;
        }

        .segment-btn.active {
            background: var(--surface);
            color: var(--primary);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .segment-btn ion-icon {
            font-size: 16px;
        }

        /* Tab Content Panel */
        .tab-panel {
            display: none;
        }

        .tab-panel.active {
            display: block;
        }

        /* Student Roster Cards */
        .student-card {
            background: var(--surface);
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(6, 78, 59, 0.02);
            border: 1px solid var(--border-color);
            padding: 12px 14px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .student-avatar {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--primary-light), var(--primary));
            color: #ffffff;
            font-weight: 700;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 2px 6px rgba(6, 78, 59, 0.1);
        }

        .student-photo {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            object-fit: cover;
            flex-shrink: 0;
            box-shadow: 0 2px 6px rgba(6, 78, 59, 0.1);
        }

        .student-details {
            flex: 1;
            min-width: 0;
        }

        .student-name {
            font-size: 0.88rem;
            font-weight: 700;
            color: var(--text-main);
            margin: 0 0 2px 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .student-sub {
            font-size: 0.72rem;
            color: var(--text-muted);
            font-weight: 500;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 6px;
        }

        .student-gender-badge {
            font-size: 0.65rem;
            font-weight: 700;
            padding: 1px 5px;
            border-radius: 4px;
            text-transform: uppercase;
        }

        .gender-l {
            background: rgba(13, 109, 83, 0.1);
            color: var(--primary-light);
        }

        .gender-p {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }

        /* Monitoring Rapor Cards */
        .subject-card {
            background: var(--surface);
            border-radius: 14px;
            box-shadow: 0 4px 12px rgba(6, 78, 59, 0.02);
            border: 1px solid var(--border-color);
            padding: 14px;
            margin-bottom: 12px;
        }

        .subject-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 10px;
        }

        .subject-title {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--text-main);
            margin: 0 0 2px 0;
            line-height: 1.3;
        }

        .subject-teacher {
            font-size: 0.72rem;
            color: var(--text-muted);
            font-weight: 500;
            margin: 0;
        }

        .status-badge {
            font-size: 0.68rem;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 6px;
            white-space: nowrap;
        }

        .status-lengkap {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
        }

        .status-belum-lengkap {
            background: rgba(245, 158, 11, 0.1);
            color: #f59e0b;
        }

        .status-belum-diisi {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }

        .status-rencana {
            background: rgba(100, 116, 139, 0.1);
            color: #64748b;
        }

        .rencana-counts {
            display: flex;
            gap: 8px;
            margin-bottom: 12px;
        }

        .count-tag {
            font-size: 0.68rem;
            font-weight: 600;
            background: #f1f5f9;
            color: var(--text-muted);
            padding: 3px 6px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .count-tag ion-icon {
            font-size: 12px;
            color: var(--primary-light);
        }

        /* Progress Bar wrapper */
        .progress-wrapper {
            background: #f8fafc;
            border-radius: 10px;
            padding: 8px 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 12px;
        }

        .progress-container {
            flex: 1;
            height: 6px;
            background: #e2e8f0;
            border-radius: 3px;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            border-radius: 3px;
        }

        .progress-percentage {
            font-size: 0.72rem;
            font-weight: 700;
            color: var(--text-main);
            min-width: 32px;
            text-align: right;
        }

        .progress-detail-text {
            font-size: 0.68rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        /* Subject Actions Button */
        .btn-subject-action {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            font-size: 0.75rem;
            font-weight: 700;
            background: #f8fafc;
            color: var(--primary-light);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 8px 12px;
            text-decoration: none !important;
            transition: all 0.2s;
        }

        .btn-subject-action:active {
            background: rgba(6, 78, 59, 0.05);
            color: var(--primary);
        }

        /* Monitoring Presensi Cards */
        .presence-card {
            background: var(--surface);
            border-radius: 14px;
            box-shadow: 0 4px 12px rgba(6, 78, 59, 0.02);
            border: 1px solid var(--border-color);
            padding: 14px;
            margin-bottom: 12px;
        }

        .presence-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .presence-day-badge {
            background: rgba(6, 78, 59, 0.08);
            color: var(--primary);
            font-size: 0.72rem;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .presence-jam {
            font-size: 0.68rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .presence-info-row {
            margin-bottom: 12px;
        }

        .btn-presence-print {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            font-size: 0.75rem;
            font-weight: 700;
            background: #f8fafc;
            color: #0d6d53;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 8px 12px;
            text-decoration: none !important;
            transition: all 0.2s;
            width: 100%;
        }

        .btn-presence-print:active {
            background: rgba(13, 109, 83, 0.05);
        }

        /* Custom Dropdown arrow */
        .select-wrapper {
            position: relative;
            flex: 1;
        }
    </style>
@endpush

@section('content')
    <div class="wali-kelas-container">
        
        <!-- Flash Messages -->
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show custom-alert" role="alert" style="background: rgba(16, 185, 129, 0.1); color: #10b981; border: none; border-radius: 10px; font-size: 0.8rem; font-weight: 600; padding: 12px; margin-bottom: 16px;">
                {{ $message }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: #10b981; outline: none; border: none; background: none; padding: 0 8px; position: absolute; right: 10px; top: 10px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-dismissible fade show custom-alert" role="alert" style="background: rgba(239, 68, 68, 0.1); color: #ef4444; border: none; border-radius: 10px; font-size: 0.8rem; font-weight: 600; padding: 12px; margin-bottom: 16px;">
                {{ $message }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: #ef4444; outline: none; border: none; background: none; padding: 0 8px; position: absolute; right: 10px; top: 10px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- Class Info Banner Card -->
        <div class="info-card">
            <h4 class="info-class">Kelas {{ $currentKelas->nama_kelas }}</h4>
            <div class="info-meta">
                <span>
                    <ion-icon name="business-outline"></ion-icon>
                    {{ $currentKelas->unit->nama_unit }}
                </span>
                <span>
                    <ion-icon name="people-outline"></ion-icon>
                    {{ $students->count() }} Siswa
                </span>
                <span>
                    <ion-icon name="calendar-outline"></ion-icon>
                    TA: {{ $activeTa->tahun_ajaran }}
                </span>
            </div>

            <!-- Class Binaan Selector (if teacher has > 1 classes) -->
            @if ($kelasBinaan->count() > 1)
                <form action="{{ route('wali-kelas.index') }}" method="GET" id="formSelectKelas">
                    <div class="class-select-group">
                        <div class="select-wrapper">
                            <select name="kode_kelas" onchange="document.getElementById('formSelectKelas').submit();">
                                @foreach ($kelasBinaan as $kb)
                                    <option value="{{ $kb->kode_kelas }}" {{ $currentKelas->kode_kelas == $kb->kode_kelas ? 'selected' : '' }}>
                                        Pindah Kelas: {{ $kb->nama_kelas }} ({{ $kb->unit->nama_unit }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <ion-icon name="chevron-down-outline" style="font-size: 12px; margin-left: auto; flex-shrink: 0; color: rgba(255,255,255,0.8);"></ion-icon>
                    </div>
                </form>
            @endif
        </div>

        <!-- Wali Kelas Profile Info Widget -->
        <div class="profile-card">
            <div class="profile-avatar">
                <ion-icon name="ribbon-outline"></ion-icon>
            </div>
            <div class="profile-info">
                <h6 class="profile-name">{{ $guruModel->nama_guru }}</h6>
                <span class="profile-npp">Wali Kelas | NPP: {{ $guruModel->npp ?? '-' }}</span>
            </div>
        </div>

        <!-- Segment Tab Pills -->
        <div class="tab-segment">
            <button type="button" class="segment-btn active" data-target="navs-siswa">
                <ion-icon name="people-outline"></ion-icon>
                <span>Siswa</span>
            </button>
            <button type="button" class="segment-btn" data-target="navs-monitoring">
                <ion-icon name="bar-chart-outline"></ion-icon>
                <span>Rapor</span>
            </button>
            <button type="button" class="segment-btn" data-target="navs-presensi">
                <ion-icon name="checkbox-outline"></ion-icon>
                <span>Presensi</span>
            </button>
        </div>

        <!-- TAB PANEL: DAFTAR SISWA -->
        <div class="tab-panel active" id="navs-siswa">
            @forelse ($students as $index => $student)
                @php
                    $words = explode(" ", $student->nama_lengkap);
                    $initials = "";
                    if (count($words) > 0) {
                        $initials .= strtoupper(substr($words[0], 0, 1));
                    }
                    if (count($words) > 1) {
                        $initials .= strtoupper(substr($words[1], 0, 1));
                    }
                @endphp
                <div class="student-card">
                    @if (!empty($student->foto) && Storage::disk('public')->exists('photos/pendaftaran/' . $student->foto))
                        <img src="{{ asset('storage/photos/pendaftaran/' . $student->foto) }}" class="student-photo" alt="{{ $student->nama_lengkap }}">
                    @else
                        <div class="student-avatar">
                            {{ $initials }}
                        </div>
                    @endif
                    <div class="student-details">
                        <h4 class="student-name">{{ $student->nama_lengkap }}</h4>
                        <div class="student-sub">
                            <span>NIS: {{ $student->nis ?? '-' }}</span>
                            <span class="student-gender-badge {{ (strtoupper($student->jenis_kelamin) == 'L' || strtoupper($student->jenis_kelamin) == 'LAKI-LAKI') ? 'gender-l' : 'gender-p' }}">
                                {{ (strtoupper($student->jenis_kelamin) == 'L' || strtoupper($student->jenis_kelamin) == 'LAKI-LAKI') ? 'L' : 'P' }}
                            </span>
                        </div>
                        <div class="text-muted mt-1" style="font-size: 0.68rem; font-weight: 500;">
                            Lahir: {{ $student->tempat_lahir ?? '-' }}, {{ $student->tanggal_lahir ? \Carbon\Carbon::parse($student->tanggal_lahir)->translatedFormat('d M Y') : '-' }}
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center p-5 bg-white rounded-14" style="border: 1px solid var(--border-color);">
                    <ion-icon name="people-outline" style="font-size: 40px; color: #cbd5e1; margin-bottom: 10px;"></ion-icon>
                    <h5 class="fw-bold" style="font-size: 0.95rem; color: var(--text-main); margin-bottom: 4px;">Belum Ada Siswa</h5>
                    <p class="text-muted small mb-0">Hubungi admin untuk memasukkan siswa ke kelas ini.</p>
                </div>
            @endforelse
        </div>

        <!-- TAB PANEL: MONITORING RAPOR -->
        <div class="tab-panel" id="navs-monitoring">
            @forelse ($monitoringData as $index => $item)
                @php
                    $progressBarColor = 'bg-danger';
                    if ($item->completion_rate == 100) {
                        $progressBarColor = 'bg-success';
                    } elseif ($item->completion_rate > 0) {
                        $progressBarColor = 'bg-warning';
                    }
                @endphp
                <div class="subject-card">
                    <div class="subject-header">
                        <div>
                            <h4 class="subject-title">{{ $item->mapel_nama }}</h4>
                            <p class="subject-teacher">{{ $item->guru_nama }}</p>
                        </div>
                        
                        @if ($item->status == 'Lengkap')
                            <span class="status-badge status-lengkap">Lengkap</span>
                        @elseif ($item->status == 'Belum Lengkap')
                            <span class="status-badge status-belum-lengkap">Belum Lengkap</span>
                        @elseif ($item->status == 'Belum Diisi')
                            <span class="status-badge status-belum-diisi">Belum Diisi</span>
                        @else
                            <span class="status-badge status-rencana">Belum Ada Rencana</span>
                        @endif
                    </div>

                    <!-- Assessment details count tags -->
                    <div class="rencana-counts">
                        <div class="count-tag">
                            <ion-icon name="layers-outline"></ion-icon>
                            <span>Sumatif: {{ $item->rencana_sumatif }}</span>
                        </div>
                        <div class="count-tag">
                            <ion-icon name="document-text-outline"></ion-icon>
                            <span>SAS: {{ $item->rencana_sas }}</span>
                        </div>
                    </div>

                    <!-- Progress bar wrapper -->
                    <div class="progress-wrapper">
                        <div class="progress-container">
                            <div class="progress-bar {{ $progressBarColor }}" style="width: {{ $item->completion_rate }}%;"></div>
                        </div>
                        <span class="progress-percentage">{{ $item->completion_rate }}%</span>
                    </div>

                    <!-- Details Row -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="progress-detail-text">Nilai terisi: {{ $item->nilai_count }} dari {{ $item->expected_count }} total</span>
                    </div>

                    <!-- View details link -->
                    <a href="{{ route('wali-kelas.detail-penilaian', $item->jadwal_id) }}" class="btn-subject-action">
                        <ion-icon name="eye-outline" style="font-size: 14px;"></ion-icon>
                        <span>Lihat Detail Nilai</span>
                    </a>
                </div>
            @empty
                <div class="text-center p-5 bg-white rounded-14" style="border: 1px solid var(--border-color);">
                    <ion-icon name="book-outline" style="font-size: 40px; color: #cbd5e1; margin-bottom: 10px;"></ion-icon>
                    <h5 class="fw-bold" style="font-size: 0.95rem; color: var(--text-main); margin-bottom: 4px;">Belum Ada Jadwal</h5>
                    <p class="text-muted small mb-0">Belum ada jadwal pelajaran terdaftar di kelas binaan ini.</p>
                </div>
            @endforelse
        </div>

        <!-- TAB PANEL: MONITORING PRESENSI -->
        <div class="tab-panel" id="navs-presensi">
            @forelse ($presenceSchedules as $index => $schedule)
                <div class="presence-card">
                    <div class="presence-header">
                        <span class="presence-day-badge">
                            <ion-icon name="calendar-clear-outline"></ion-icon>
                            {{ $schedule->hari }}
                        </span>
                        <span class="presence-jam">Jam ke-{{ $schedule->jam_ke }} ({{ $schedule->jam_mulai }} - {{ $schedule->jam_selesai }})</span>
                    </div>

                    <div class="presence-info-row">
                        <h4 class="subject-title" style="margin-bottom: 4px;">{{ $schedule->mapel ? $schedule->mapel->nama_matpel : 'Mapel Tidak Diketahui' }}</h4>
                        <p class="subject-teacher" style="margin-bottom: 8px;">{{ $schedule->guru ? $schedule->guru->nama_guru : 'Guru Tidak Diketahui' }}</p>
                        
                        <div class="count-tag" style="display: inline-flex;">
                            <ion-icon name="checkmark-done-circle-outline"></ion-icon>
                            <span>Pertemuan: {{ $schedule->presensi_count }} Kali</span>
                        </div>
                    </div>

                    <a href="{{ route('jadwal-pelajaran.cetak-presensi', ['id' => \Illuminate\Support\Facades\Crypt::encrypt($schedule->id), 'pdf' => 1]) }}" target="_blank" class="btn-presence-print">
                        <ion-icon name="download-outline" style="font-size: 14px;"></ion-icon>
                        <span>Unduh PDF</span>
                    </a>
                </div>
            @empty
                <div class="text-center p-5 bg-white rounded-14" style="border: 1px solid var(--border-color);">
                    <ion-icon name="calendar-outline" style="font-size: 40px; color: #cbd5e1; margin-bottom: 10px;"></ion-icon>
                    <h5 class="fw-bold" style="font-size: 0.95rem; color: var(--text-main); margin-bottom: 4px;">Belum Ada Jadwal</h5>
                    <p class="text-muted small mb-0">Belum ada jadwal pelajaran terdaftar di kelas binaan ini.</p>
                </div>
            @endforelse
        </div>

    </div>
@endsection

@push('myscript')
    <script>
        $(document).ready(function() {
            // Segment tab button toggles
            $(".segment-btn").click(function() {
                var targetId = $(this).attr("data-target");
                
                // Toggle active segment buttons
                $(".segment-btn").removeClass("active");
                $(this).addClass("active");
                
                // Toggle active tab content panels
                $(".tab-panel").removeClass("active");
                $("#" + targetId).addClass("active");
            });
        });
    </script>
@endpush

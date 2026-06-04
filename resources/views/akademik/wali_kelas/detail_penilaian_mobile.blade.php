@extends('layouts.mobile.app_sipren')

@section('title', 'Detail Nilai - Sipren')
@section('header-title', 'Detail Nilai')
@section('back-url', route('wali-kelas.index'))
@section('show-bottom-nav', true)

@push('styles')
    <style>
        .detail-nilai-container {
            padding: 16px;
            padding-bottom: 100px; /* Safe-area padding for bottom-nav */
        }

        /* Subject Details Info Card */
        .info-card {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(6, 78, 59, 0.12);
            padding: 18px 20px;
            border: none;
            color: #ffffff;
            margin-bottom: 16px;
        }

        .info-subject {
            font-size: 1.2rem;
            font-weight: 800;
            margin: 0 0 6px 0;
            line-height: 1.3;
        }

        .info-meta {
            font-size: 0.76rem;
            color: rgba(255, 255, 255, 0.85);
            font-weight: 500;
        }

        /* Bobot Panel */
        .bobot-card {
            background: var(--surface);
            border-radius: 14px;
            padding: 12px 16px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.03);
            border: 1px solid var(--border-color);
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            justify-content: space-around;
            text-align: center;
        }

        .bobot-item {
            flex: 1;
        }

        .bobot-label {
            font-size: 0.68rem;
            color: var(--text-muted);
            font-weight: 600;
            margin-bottom: 4px;
            display: block;
        }

        .bobot-badge {
            font-size: 0.82rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 8px;
        }

        /* Modern Search Input wrapper */
        .search-wrapper {
            position: relative;
            margin-bottom: 16px;
        }

        .search-wrapper ion-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 18px;
            color: var(--text-muted);
        }

        .search-input {
            width: 100%;
            background: var(--surface);
            border: 1.5px solid var(--border-color);
            border-radius: 12px;
            padding: 10px 14px 10px 42px;
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--text-main);
            outline: none;
            transition: all 0.2s;
        }

        .search-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(6, 78, 59, 0.06);
            background: #ffffff;
        }

        /* Segment Tab Pills */
        .tab-segment {
            background: #e2e8f0;
            border-radius: 12px;
            padding: 4px;
            display: flex;
            gap: 4px;
            margin-bottom: 16px;
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

        /* Student Detail Cards */
        .student-score-card {
            background: var(--surface);
            border-radius: 14px;
            box-shadow: 0 4px 12px rgba(6, 78, 59, 0.02);
            border: 1px solid var(--border-color);
            padding: 14px;
            margin-bottom: 12px;
        }

        .student-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #f1f5f9;
        }

        .student-title-name {
            font-size: 0.88rem;
            font-weight: 700;
            color: var(--text-main);
            margin: 0;
        }

        .student-title-nis {
            font-size: 0.7rem;
            color: var(--text-muted);
            margin: 2px 0 0 0;
            font-weight: 500;
        }

        .score-large-badge {
            font-size: 0.95rem;
            font-weight: 800;
            padding: 6px 12px;
            border-radius: 8px;
            min-width: 48px;
            text-align: center;
        }

        .score-good {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
        }

        .score-bad {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }

        .score-meta-grid {
            display: flex;
            gap: 12px;
            margin-bottom: 10px;
        }

        .score-meta-item {
            flex: 1;
            background: #f8fafc;
            border-radius: 8px;
            padding: 6px 10px;
            font-size: 0.72rem;
            font-weight: 500;
            color: var(--text-muted);
        }

        .score-meta-item strong {
            color: var(--text-main);
            font-size: 0.8rem;
            display: block;
            margin-top: 2px;
        }

        .competency-box {
            background: rgba(6, 78, 59, 0.03);
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 0.72rem;
            color: var(--text-muted);
            line-height: 1.4;
            border-left: 3px solid var(--primary);
        }

        /* Detail Scores Grid List */
        .detail-scores-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .detail-score-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #f8fafc;
            border-radius: 8px;
            padding: 8px 12px;
        }

        .detail-score-label {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--text-main);
            display: flex;
            flex-direction: column;
        }

        .detail-score-desc {
            font-size: 0.65rem;
            color: var(--text-muted);
            font-weight: 500;
            margin-top: 1px;
        }

        .detail-score-value {
            font-size: 0.82rem;
            font-weight: 700;
        }
    </style>
@endpush

@section('content')
    <div class="detail-nilai-container">
        
        <!-- Info Banner Card -->
        <div class="info-card">
            <h4 class="info-subject">{{ $jadwal->mapel->nama_matpel ?? '-' }}</h4>
            <div class="info-meta">
                <div style="margin-bottom: 2px;">Kelas: <strong>{{ $jadwal->kelas->nama_kelas ?? '-' }}</strong></div>
                <div>Guru: <strong>{{ $jadwal->guru->nama_guru ?? '-' }}</strong></div>
            </div>
        </div>

        <!-- Bobot Card Info -->
        <div class="bobot-card">
            <div class="bobot-item">
                <span class="bobot-label">Bobot Sumatif</span>
                <span class="bobot-badge bg-label-success text-success" style="background: rgba(16, 185, 129, 0.1);">{{ $bobot->bobot_sumatif }}%</span>
            </div>
            <div style="border-left: 1px solid var(--border-color); height: 28px;"></div>
            <div class="bobot-item">
                <span class="bobot-label">Bobot SAS</span>
                <span class="bobot-badge bg-label-info text-info" style="background: rgba(13, 109, 83, 0.1);">{{ $bobot->bobot_sas }}%</span>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="search-wrapper">
            <ion-icon name="search-outline"></ion-icon>
            <input type="text" id="searchInput" class="search-input" placeholder="Cari nama atau NIS siswa...">
        </div>

        <!-- Segment Tab Pills -->
        <div class="tab-segment">
            <button type="button" class="segment-btn active" data-target="navs-rekap">
                <ion-icon name="bar-chart-outline"></ion-icon>
                <span>Rapor</span>
            </button>
            <button type="button" class="segment-btn" data-target="navs-sumatif">
                <ion-icon name="layers-outline"></ion-icon>
                <span>Sumatif</span>
            </button>
            <button type="button" class="segment-btn" data-target="navs-sas">
                <ion-icon name="document-text-outline"></ion-icon>
                <span>SAS</span>
            </button>
        </div>

        <!-- TAB PANEL: REKAPITULASI RAPOR -->
        <div class="tab-panel active" id="navs-rekap">
            @forelse ($students as $index => $student)
                <div class="student-score-card searchable-card" data-name="{{ strtolower($student->nama_lengkap) }} {{ strtolower($student->nis) }}">
                    <div class="student-header">
                        <div>
                            <h4 class="student-title-name">{{ $student->nama_lengkap }}</h4>
                            <p class="student-title-nis">NIS: {{ $student->nis ?? '-' }}</p>
                        </div>
                        <div class="score-large-badge {{ $student->nilai_rapor >= 75 ? 'score-good' : 'score-bad' }}">
                            {{ $student->nilai_rapor }}
                        </div>
                    </div>

                    <div class="score-meta-grid">
                        <div class="score-meta-item">
                            Rata Sumatif
                            <strong>{{ $student->rata_sumatif }}</strong>
                        </div>
                        <div class="score-meta-item">
                            Nilai SAS
                            <strong>{{ $student->nilai_sas }}</strong>
                        </div>
                    </div>

                    @if(!empty($student->capaian_kompetensi))
                        <div class="competency-box">
                            <strong>Capaian Kompetensi:</strong><br>
                            {{ strip_tags($student->capaian_kompetensi) }}
                        </div>
                    @endif
                </div>
            @empty
                <div class="text-center p-5 bg-white rounded-14" style="border: 1px solid var(--border-color);">
                    <ion-icon name="people-outline" style="font-size: 40px; color: #cbd5e1; margin-bottom: 10px;"></ion-icon>
                    <h5 class="fw-bold" style="font-size: 0.95rem; color: var(--text-main); margin-bottom: 4px;">Belum Ada Siswa</h5>
                    <p class="text-muted small mb-0">Belum ada data nilai rapor untuk kelas ini.</p>
                </div>
            @endforelse
        </div>

        <!-- TAB PANEL: RINCIAN SUMATIF -->
        <div class="tab-panel" id="navs-sumatif">
            @php
                $rencanaSumatif = $rencanaPenilaian->where('kategori_penilaian', 'SUMATIF');
            @endphp

            @forelse ($students as $index => $student)
                <div class="student-score-card searchable-card" data-name="{{ strtolower($student->nama_lengkap) }} {{ strtolower($student->nis) }}">
                    <div class="student-header" style="border-bottom: none; margin-bottom: 6px; padding-bottom: 0;">
                        <div>
                            <h4 class="student-title-name">{{ $student->nama_lengkap }}</h4>
                            <p class="student-title-nis" style="margin-bottom: 4px;">NIS: {{ $student->nis ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="detail-scores-list">
                        @forelse ($rencanaSumatif as $rencana)
                            @php
                                $score = $mappedGrades[$student->id_siswa][$rencana->id] ?? null;
                            @endphp
                            <div class="detail-score-row">
                                <div class="detail-score-label">
                                    <span>{{ $rencana->kode_penilaian }}</span>
                                    <span class="detail-score-desc">{{ $rencana->nama_penilaian }}</span>
                                </div>
                                <div class="detail-score-value">
                                    @if($score !== null)
                                        <span class="{{ $score < 75 ? 'text-danger' : 'text-success' }}">{{ number_format($score, 0) }}</span>
                                    @else
                                        <span class="text-muted opacity-50">-</span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center p-3 text-muted" style="font-size: 0.72rem;">
                                Belum ada rencana penilaian sumatif dari guru pengampu.
                            </div>
                        @endforelse
                    </div>
                </div>
            @empty
                <div class="text-center p-5 bg-white rounded-14" style="border: 1px solid var(--border-color);">
                    <ion-icon name="layers-outline" style="font-size: 40px; color: #cbd5e1; margin-bottom: 10px;"></ion-icon>
                    <h5 class="fw-bold" style="font-size: 0.95rem; color: var(--text-main); margin-bottom: 4px;">Belum Ada Rencana</h5>
                    <p class="text-muted small mb-0">Belum ada rincian penilaian sumatif.</p>
                </div>
            @endforelse
        </div>

        <!-- TAB PANEL: RINCIAN SAS -->
        <div class="tab-panel" id="navs-sas">
            @php
                $rencanaSas = $rencanaPenilaian->where('kategori_penilaian', 'SAS');
            @endphp

            @forelse ($students as $index => $student)
                <div class="student-score-card searchable-card" data-name="{{ strtolower($student->nama_lengkap) }} {{ strtolower($student->nis) }}">
                    <div class="student-header" style="border-bottom: none; margin-bottom: 6px; padding-bottom: 0;">
                        <div>
                            <h4 class="student-title-name">{{ $student->nama_lengkap }}</h4>
                            <p class="student-title-nis" style="margin-bottom: 4px;">NIS: {{ $student->nis ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="detail-scores-list">
                        @forelse ($rencanaSas as $rencana)
                            @php
                                $score = $mappedGrades[$student->id_siswa][$rencana->id] ?? null;
                            @endphp
                            <div class="detail-score-row">
                                <div class="detail-score-label">
                                    <span>{{ $rencana->kode_penilaian }}</span>
                                    <span class="detail-score-desc">{{ $rencana->nama_penilaian }}</span>
                                </div>
                                <div class="detail-score-value">
                                    @if($score !== null)
                                        <span class="{{ $score < 75 ? 'text-danger' : 'text-success' }}">{{ number_format($score, 0) }}</span>
                                    @else
                                        <span class="text-muted opacity-50">-</span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center p-3 text-muted" style="font-size: 0.72rem;">
                                Belum ada rencana penilaian SAS dari guru pengampu.
                            </div>
                        @endforelse
                    </div>
                </div>
            @empty
                <div class="text-center p-5 bg-white rounded-14" style="border: 1px solid var(--border-color);">
                    <ion-icon name="document-text-outline" style="font-size: 40px; color: #cbd5e1; margin-bottom: 10px;"></ion-icon>
                    <h5 class="fw-bold" style="font-size: 0.95rem; color: var(--text-main); margin-bottom: 4px;">Belum Ada Rencana</h5>
                    <p class="text-muted small mb-0">Belum ada rincian penilaian SAS.</p>
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

            // Live filter search
            $("#searchInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $(".searchable-card").filter(function() {
                    $(this).toggle($(this).attr("data-name").indexOf(value) > -1);
                });
            });
        });
    </script>
@endpush

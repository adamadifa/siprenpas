@extends('layouts.mobile.app_sipren')

@section('title', 'Penilaian Siswa - Sipren')
@section('header-title', 'Penilaian Siswa')
@section('back-url', route('rapor.index'))
@section('show-bottom-nav', true)

@push('styles')
    <style>
        .penilaian-container {
            padding: 16px;
            padding-bottom: 80px;
        }

        /* Modern Course Details Card */
        .course-details-card {
            background: var(--primary); /* Solid green matching dashboard */
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(6, 78, 59, 0.12);
            padding: 16px;
            position: relative;
            overflow: hidden;
            border: none;
        }

        .course-subject {
            margin-bottom: 14px;
            padding-left: 2px;
        }

        .subject-badge {
            font-size: 0.65rem;
            text-transform: uppercase;
            font-weight: 700;
            color: #ffffff;
            background: rgba(255, 255, 255, 0.16);
            padding: 4px 8px;
            border-radius: 6px;
            display: inline-block;
            margin-bottom: 6px;
            letter-spacing: 0.02em;
        }

        .course-subject h3 {
            font-size: 1.15rem;
            font-weight: 800;
            color: #ffffff;
            margin: 0;
            letter-spacing: -0.01em;
            line-height: 1.3;
        }

        .course-meta-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
            background: rgba(255, 255, 255, 0.06);
            border-radius: 14px;
            padding: 14px;
            border: none;
        }

        .meta-row-split {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .course-meta-list > .meta-item {
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            padding-bottom: 12px;
        }

        .meta-item {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .meta-icon-wrapper {
            width: 32px;
            height: 32px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.12);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .meta-icon-wrapper ion-icon {
            font-size: 16px !important;
            color: #ffffff !important;
            margin-top: 0 !important;
            flex-shrink: 0;
        }

        .meta-label {
            display: block;
            font-size: 0.62rem;
            color: rgba(255, 255, 255, 0.6);
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 2px;
            letter-spacing: 0.01em;
            line-height: 1;
        }

        .meta-value {
            display: block;
            font-size: 0.82rem;
            color: #ffffff;
            font-weight: 700;
            word-break: break-word;
            line-height: 1.2;
        }

        /* Config Card styling */
        .config-card {
            border-radius: 10px !important;
            background: var(--surface);
            box-shadow: 0 4px 16px rgba(6, 78, 59, 0.04) !important;
            border: none !important;
            overflow: hidden;
        }

        .config-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 16px;
            background: #f8fafc;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .config-header:active {
            background: #f1f5f9;
        }

        .config-title {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.82rem;
            font-weight: 700;
            color: var(--text-main);
        }

        .config-title ion-icon {
            color: var(--primary);
            font-size: 16px;
        }

        /* Action Buttons Row */
        .action-buttons-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 20px;
        }

        .btn-manage-action {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            font-size: 0.78rem;
            font-weight: 700;
            border-radius: 10px;
            padding: 10px 14px;
            border: none;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
            text-decoration: none !important;
        }

        .btn-manage-action:active {
            transform: scale(0.95);
        }

        .btn-sumatif {
            background: rgba(6, 78, 59, 0.08);
            color: var(--primary) !important;
        }

        .btn-sas {
            background: rgba(14, 116, 144, 0.08);
            color: #0e7490 !important;
        }

        /* Student Item Styling */
        .student-card {
            border-radius: 10px !important;
            background: var(--surface);
            box-shadow: 0 4px 16px rgba(6, 78, 59, 0.04) !important;
            border: none !important;
            overflow: hidden;
            margin-bottom: 12px;
        }

        .student-avatar {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--primary-light), var(--primary));
            color: #ffffff;
            font-weight: 700;
            font-size: 0.82rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 2px 6px rgba(6, 78, 59, 0.15);
        }

        .student-photo {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            object-fit: cover;
            flex-shrink: 0;
            box-shadow: 0 2px 6px rgba(6, 78, 59, 0.15);
        }

        .student-name {
            font-size: 0.88rem;
            font-weight: 700;
            color: var(--text-main);
            margin: 0;
            line-height: 1.25;
        }

        .student-nis {
            font-size: 0.7rem;
            color: var(--text-muted);
            font-weight: 500;
            display: block;
            margin-top: 1px;
        }

        .student-index {
            font-size: 0.68rem;
            font-weight: 700;
            color: var(--text-muted);
            background: #f1f5f9;
            padding: 2px 6px;
            border-radius: 6px;
            align-self: flex-start;
        }

        /* Score Grid Layout */
        .score-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            background: #f8fafc;
            border-radius: 8px;
            padding: 8px;
            gap: 4px;
            margin-top: 10px;
            text-align: center;
        }

        .score-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .score-label {
            font-size: 0.62rem;
            color: var(--text-muted);
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 2px;
        }

        .score-value {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--text-main);
        }

        .score-value.highlight {
            color: var(--primary);
            font-size: 0.95rem;
        }

        /* Capaian Kompetensi Block */
        .capaian-block {
            margin-top: 10px;
            background: rgba(6, 78, 59, 0.03);
            border-radius: 8px;
            padding: 8px 10px;
            font-size: 0.72rem;
            color: #374151;
            line-height: 1.35;
        }

        .capaian-label {
            font-weight: 700;
            font-size: 0.65rem;
            text-transform: uppercase;
            color: var(--primary);
            margin-bottom: 2px;
            display: block;
        }

        /* Alert styling */
        .custom-alert {
            padding: 12px;
            border-radius: 10px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 12px;
        }
    </style>
@endpush

@section('content')
    <div class="penilaian-container">
        
        <!-- Flash Messages -->
        @if (Session::has('success'))
            <div class="alert alert-success custom-alert border-0">
                {{ Session::get('success') }}
            </div>
        @endif
        @if (Session::has('error'))
            <div class="alert alert-danger custom-alert border-0">
                {{ Session::get('error') }}
            </div>
        @endif

        <!-- Course Header Card -->
        <div class="course-details-card mb-3">
            <div class="course-info-body">
                <div class="course-subject">
                    <span class="subject-badge">Mata Pelajaran</span>
                    <h3>{{ $jadwal->mapel->nama_matpel ?? '-' }}</h3>
                </div>
                <div class="course-meta-list">
                    <!-- Guru -->
                    <div class="meta-item">
                        <div class="meta-icon-wrapper">
                            <ion-icon name="person-outline"></ion-icon>
                        </div>
                        <div>
                            <span class="meta-label">Guru</span>
                            <span class="meta-value">{{ $jadwal->guru->nama_guru ?? '-' }}</span>
                        </div>
                    </div>
                    <!-- Kelas & Unit aligned side-by-side -->
                    <div class="meta-row-split">
                        <div class="meta-item">
                            <div class="meta-icon-wrapper">
                                <ion-icon name="people-outline"></ion-icon>
                            </div>
                            <div>
                                <span class="meta-label">Kelas</span>
                                <span class="meta-value">{{ $jadwal->kelas->nama_kelas ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-icon-wrapper">
                                <ion-icon name="business-outline"></ion-icon>
                            </div>
                            <div>
                                <span class="meta-label">Unit</span>
                                <span class="meta-value">{{ $jadwal->unit->nama_unit ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                    <!-- Tahun Ajaran & Semester aligned side-by-side -->
                    <div class="meta-row-split">
                        <div class="meta-item">
                            <div class="meta-icon-wrapper">
                                <ion-icon name="calendar-outline"></ion-icon>
                            </div>
                            <div>
                                <span class="meta-label">Tahun Ajaran</span>
                                <span class="meta-value">{{ $jadwal->tahunAjaran->tahun_ajaran ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-icon-wrapper">
                                <ion-icon name="bookmark-outline"></ion-icon>
                            </div>
                            <div>
                                <span class="meta-label">Semester</span>
                                <span class="meta-value">Semester {{ $jadwal->semester ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bobot Penilaian Collapsible Card -->
        <div class="card config-card mb-3">
            <div class="config-header" data-toggle="collapse" data-target="#collapseBobot" aria-expanded="false" aria-controls="collapseBobot">
                <span class="config-title">
                    <ion-icon name="settings-outline"></ion-icon>
                    <span>Konfigurasi Bobot ({{ $bobot->bobot_sumatif }}% / {{ $bobot->bobot_sas }}%)</span>
                </span>
                <ion-icon name="chevron-down-outline" style="color: var(--text-muted); font-size: 14px;"></ion-icon>
            </div>
            <div class="collapse" id="collapseBobot">
                <div class="card-body p-3 pt-1">
                    <form action="{{ route('penilaian.store-bobot') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $bobot->id }}">
                        <div style="display: flex; flex-direction: column; gap: 12px; margin-top: 8px;">
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                                <div>
                                    <label style="font-size: 0.72rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Sumatif (%)</label>
                                    <input type="number" name="bobot_sumatif" class="form-control" value="{{ $bobot->bobot_sumatif }}" min="0" max="100" required style="border-radius: 8px; font-size: 0.85rem; padding: 8px 10px;" {{ ($bobot->status ?? 'draft') == 'terkirim' ? 'disabled' : '' }}>
                                </div>
                                <div>
                                    <label style="font-size: 0.72rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">SAS (%)</label>
                                    <input type="number" name="bobot_sas" class="form-control" value="{{ $bobot->bobot_sas }}" min="0" max="100" required style="border-radius: 8px; font-size: 0.85rem; padding: 8px 10px;" {{ ($bobot->status ?? 'draft') == 'terkirim' ? 'disabled' : '' }}>
                                </div>
                            </div>
                            @if (($bobot->status ?? 'draft') != 'terkirim')
                                <button type="submit" class="btn btn-action" style="background: var(--primary); color: white; font-weight: 700; font-size: 0.78rem; border-radius: 8px; border: none; padding: 10px; width: 100%;">
                                    Simpan Bobot
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Management Buttons Row -->
        <div class="action-buttons-row" style="{{ ($bobot->status ?? 'draft') == 'terkirim' ? '' : 'margin-bottom: 12px;' }}">
            <a href="{{ route('penilaian.manage', ['bobot_id' => $bobot->id, 'kategori' => 'SUMATIF']) }}" class="btn-manage-action btn-sumatif btn-action">
                <ion-icon name="notebook-outline" style="font-size: 16px;"></ion-icon>
                <span>Kelola Sumatif</span>
            </a>
            <a href="{{ route('penilaian.manage', ['bobot_id' => $bobot->id, 'kategori' => 'SAS']) }}" class="btn-manage-action btn-sas btn-action">
                <ion-icon name="document-text-outline" style="font-size: 16px;"></ion-icon>
                <span>Kelola SAS</span>
            </a>
        </div>

        <!-- Kirim Button / Status Badge (Mobile) -->
        <div class="mb-3">
            @if (($bobot->status ?? 'draft') == 'terkirim')
                <div class="w-100 p-2 text-center rounded bg-success text-white fw-bold d-flex align-items-center justify-content-center gap-1 mb-2" style="font-size: 0.85rem; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.15);">
                    <ion-icon name="checkmark-circle-outline" style="font-size: 18px;"></ion-icon>
                    <span>Status: Terkirim</span>
                </div>
                <form action="{{ route('penilaian.batal-kirim') }}" method="POST" id="formBatalKirimPenilaianMobile">
                    @csrf
                    <input type="hidden" name="bobot_id" value="{{ $bobot->id }}">
                    <button type="button" class="btn w-100 p-2 fw-bold text-white btn-action d-flex align-items-center justify-content-center gap-1" style="background-color: #dc3545; border: none; border-radius: 10px; font-size: 0.88rem; box-shadow: 0 4px 14px rgba(220, 53, 69, 0.2);" onclick="confirmBatalKirimMobile()">
                        <ion-icon name="arrow-back-outline" style="font-size: 16px;"></ion-icon>
                        <span>Batal Kirim Nilai</span>
                    </button>
                </form>
            @else
                <form action="{{ route('penilaian.kirim') }}" method="POST" id="formKirimPenilaianMobile">
                    @csrf
                    <input type="hidden" name="bobot_id" value="{{ $bobot->id }}">
                    <button type="button" class="btn w-100 p-2 fw-bold text-white btn-action d-flex align-items-center justify-content-center gap-1" style="background-color: #10b981; border: none; border-radius: 10px; font-size: 0.88rem; box-shadow: 0 4px 14px rgba(16, 185, 129, 0.2);" onclick="confirmKirimMobile()">
                        <ion-icon name="send-outline" style="font-size: 16px;"></ion-icon>
                        <span>Kirim Nilai</span>
                    </button>
                </form>
            @endif
        </div>

        <!-- Subheader -->
        <div style="padding: 0 0 10px 0; margin-top: 4px;">
            <span style="font-size: 0.75rem; font-weight: 700; color: var(--primary); text-transform: uppercase; letter-spacing: 0.05em;">
                Rekap Nilai Siswa
            </span>
        </div>

        <!-- Student Grade Cards -->
        <div id="student-grades-section">
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
                    <div class="card-body p-3">
                        <!-- Student Header Info -->
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                @if (!empty($student->foto) && Storage::disk('public')->exists('photos/pendaftaran/' . $student->foto))
                                    <img src="{{ asset('storage/photos/pendaftaran/' . $student->foto) }}" class="student-photo" alt="{{ $student->nama_lengkap }}">
                                @else
                                    <div class="student-avatar">
                                        {{ $initials }}
                                    </div>
                                @endif
                                <div>
                                    <h4 class="student-name">{{ $student->nama_lengkap }}</h4>
                                    <span class="student-nis">NIS: {{ $student->nis ?? '-' }}</span>
                                </div>
                            </div>
                            <span class="student-index">#{{ $index + 1 }}</span>
                        </div>

                        <!-- Grades Grid -->
                        <div class="score-grid">
                            <div class="score-item">
                                <span class="score-label">Sumatif</span>
                                <span class="score-value">{{ $student->rata_sumatif ?? '-' }}</span>
                            </div>
                            <div class="score-item">
                                <span class="score-label">SAS</span>
                                <span class="score-value">{{ $student->nilai_sas ?? '-' }}</span>
                            </div>
                            <div class="score-item">
                                <span class="score-label">Rapor</span>
                                <span class="score-value highlight">{{ $student->nilai_rapor ?? '-' }}</span>
                            </div>
                        </div>

                        <!-- Capaian Kompetensi (Deskripsi) -->
                        <div class="capaian-block">
                            <span class="capaian-label">Capaian Kompetensi</span>
                            <span>{{ strip_tags($student->capaian_kompetensi) }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <ion-icon name="people-outline" style="color: #cbd5e1; font-size: 48px;"></ion-icon>
                    <h4>Belum Ada Data Siswa</h4>
                    <p>Tidak ada siswa terdaftar di kelas ini.</p>
                </div>
            @endforelse
        </div>

    </div>

@push('myscript')
<script>
    function confirmKirimMobile() {
        Swal.fire({
            title: 'Kirim Nilai?',
            text: 'Apakah Anda yakin ingin mengirim dan mengunci nilai? Setelah dikirim, nilai untuk kelas dan mata pelajaran ini tidak dapat diubah kembali.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#064e3b',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Kirim!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('formKirimPenilaianMobile').submit();
            }
        });
    }

    function confirmBatalKirimMobile() {
        Swal.fire({
            title: 'Batal Kirim Nilai?',
            text: 'Apakah Anda yakin ingin membatalkan pengiriman nilai ini? Status nilai akan kembali menjadi draft dan dapat diedit kembali.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Batalkan!',
            cancelButtonText: 'Kembali'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('formBatalKirimPenilaianMobile').submit();
            }
        });
    }
</script>
@endpush

@endsection

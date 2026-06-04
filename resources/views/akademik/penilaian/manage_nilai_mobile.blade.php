@extends('layouts.mobile.app_sipren')

@section('title', 'Input Nilai ' . ucfirst(strtolower($kategori)) . ' - Sipren')
@section('header-title', 'Input Nilai ' . ucfirst(strtolower($kategori)))
@section('back-url', route('penilaian.index', \App\Models\JadwalPelajaran::where('kode_kelas', $bobot->kode_kelas)->where('mata_pelajaran_id', $bobot->mata_pelajaran_id)->first()->id ?? '#'))
@section('show-bottom-nav', true)

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        .manage-nilai-container {
            padding: 16px;
            padding-bottom: 160px; /* Extra padding for sticky save bar */
        }

        /* Course Info Header Card */
        .info-card {
            background: var(--primary);
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(6, 78, 59, 0.12);
            padding: 16px;
            border: none;
            color: #ffffff;
        }

        .info-subject {
            font-size: 1.1rem;
            font-weight: 800;
            margin: 0 0 6px 0;
            line-height: 1.3;
        }

        .info-meta {
            font-size: 0.76rem;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
        }

        /* Action Row styling */
        .action-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 14px;
            padding-top: 12px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .btn-add-col {
            background: rgba(255, 255, 255, 0.16);
            color: #ffffff !important;
            border: none;
            border-radius: 8px;
            font-size: 0.72rem;
            font-weight: 700;
            padding: 6px 12px;
            display: flex;
            align-items: center;
            gap: 4px;
            transition: background 0.2s;
        }

        .btn-add-col:active {
            background: rgba(255, 255, 255, 0.25);
        }

        /* Modern Search Input wrapper */
        .search-wrapper {
            position: relative;
            margin-top: 16px;
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

        /* Input Group styling inside modal */
        .filter-input-group {
            display: flex;
            align-items: center;
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: 14px;
            padding: 10px 14px;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        .filter-input-group:focus-within {
            background: #ffffff;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(6, 78, 59, 0.08);
        }

        .filter-input-group ion-icon.field-icon {
            font-size: 20px;
            color: var(--primary-light);
            margin-right: 10px;
            flex-shrink: 0;
        }

        .filter-input-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .filter-input-content label {
            font-size: 0.72rem;
            font-weight: 600;
            color: var(--text-muted);
            margin: 0 0 2px 0 !important;
            line-height: 1.2;
        }

        .filter-input-content select, 
        .filter-input-content input,
        .filter-input-content .flatpickr-input {
            border: none !important;
            background: transparent !important;
            padding: 0 !important;
            font-size: 0.88rem !important;
            font-weight: 600 !important;
            color: var(--text-main) !important;
            outline: none !important;
            width: 100% !important;
            height: auto !important;
            box-shadow: none !important;
            -webkit-appearance: none;
            appearance: none;
            margin: 0;
            line-height: 1.3;
        }

        .filter-input-content select:focus, 
        .filter-input-content input:focus,
        .filter-input-content .flatpickr-input:focus {
            outline: none !important;
            box-shadow: none !important;
        }

        /* Flatpickr Custom Green Theme */
        .flatpickr-calendar {
            border-radius: 14px !important;
            box-shadow: 0 10px 30px rgba(6, 78, 59, 0.12) !important;
            border: none !important;
            font-family: inherit;
            overflow: hidden;
            background: #ffffff !important;
        }
        .flatpickr-calendar .flatpickr-input {
            display: none !important;
        }
        .flatpickr-day.selected, 
        .flatpickr-day.selected:hover,
        .flatpickr-day.selected:focus {
            background: var(--primary) !important;
            border-color: var(--primary) !important;
            color: #ffffff !important;
        }
        .flatpickr-day.today {
            border-color: var(--primary-light) !important;
        }
        .flatpickr-day.today:hover {
            background: rgba(6, 78, 59, 0.05) !important;
            color: var(--primary) !important;
        }
        .flatpickr-day:hover {
            background: #f1f5f9 !important;
        }
        .flatpickr-months {
            background: var(--primary) !important;
        }
        .flatpickr-months .flatpickr-month {
            color: #ffffff !important;
            fill: #ffffff !important;
        }
        .flatpickr-current-month .flatpickr-monthDropdown-months {
            background: var(--primary) !important;
            color: #ffffff !important;
        }
        .flatpickr-current-month input.cur-year {
            color: #ffffff !important;
        }
        .flatpickr-months .flatpickr-prev-month, 
        .flatpickr-months .flatpickr-next-month {
            color: #ffffff !important;
            fill: #ffffff !important;
        }
        .flatpickr-weekdays {
            background: var(--primary) !important;
        }
        span.flatpickr-weekday {
            color: rgba(255, 255, 255, 0.8) !important;
            font-weight: 700;
        }
        .flatpickr-day.flatpickr-disabled, 
        .flatpickr-day.flatpickr-disabled:hover {
            color: #cbd5e1 !important;
        }

        /* Student Manage Card */
        .student-manage-card {
            background: var(--surface);
            border-radius: 10px;
            box-shadow: 0 4px 16px rgba(6, 78, 59, 0.04);
            border: none;
            margin-bottom: 16px;
            overflow: hidden;
        }

        .card-header-student {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 14px;
            border-bottom: 1px solid #f1f5f9;
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
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--text-main);
            margin: 0;
            line-height: 1.2;
        }

        .student-nis {
            font-size: 0.68rem;
            color: var(--text-muted);
            font-weight: 500;
            display: block;
            margin-top: 1px;
        }

        .student-gender {
            font-size: 0.65rem;
            font-weight: 700;
            color: var(--text-muted);
            background: #f1f5f9;
            padding: 2px 6px;
            border-radius: 5px;
        }

        .card-body-inputs {
            padding: 12px 14px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .input-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .input-label-wrapper {
            flex: 1;
            min-width: 0;
        }

        .input-code {
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--text-main);
            display: block;
        }

        .input-desc {
            font-size: 0.68rem;
            color: var(--text-muted);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: block;
        }

        /* Score numeric input styling */
        .score-input-wrapper {
            width: 70px;
            flex-shrink: 0;
        }

        .score-input {
            width: 100% !important;
            height: 36px !important;
            border: 1.5px solid var(--border-color) !important;
            border-radius: 8px !important;
            font-size: 0.85rem !important;
            font-weight: 700 !important;
            text-align: center !important;
            color: var(--text-main) !important;
            outline: none !important;
            padding: 2px !important;
            transition: all 0.2s;
            box-shadow: none !important;
        }

        .score-input:focus {
            border-color: var(--primary) !important;
            background: #ffffff !important;
            box-shadow: 0 0 0 3px rgba(6, 78, 59, 0.05) !important;
        }

        .score-input.text-success {
            color: #10b981 !important;
        }

        .score-input.text-danger {
            color: #ef4444 !important;
        }

        /* Sticky Save Bar */
        .sticky-save-bar {
            position: fixed;
            bottom: 56px; /* Above mobile bottom-nav */
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 12px 16px;
            box-shadow: 0 -4px 16px rgba(0, 0, 0, 0.06);
            z-index: 998;
            display: flex;
            justify-content: center;
        }

        .btn-save-all {
            background: var(--primary);
            color: white !important;
            border: none;
            border-radius: 10px;
            font-weight: 700;
            padding: 12px;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 0.88rem;
            box-shadow: 0 4px 14px rgba(6, 78, 59, 0.2);
            transition: all 0.2s;
        }

        .btn-save-all:active {
            transform: translateY(1px);
            box-shadow: 0 2px 6px rgba(6, 78, 59, 0.15);
        }

        /* Modal Overrides */
        #mdlAddColumn .modal-content {
            border-radius: 20px;
            border: none;
            overflow: hidden;
            box-shadow: 0 12px 36px rgba(0, 0, 0, 0.15);
        }

        /* Custom Alert */
        .custom-alert {
            padding: 12px;
            border-radius: 10px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 16px;
            border: none;
        }
    </style>
@endpush

@section('content')
    <div class="manage-nilai-container">
        
        <!-- Flash Messages -->
        @if (Session::has('success'))
            <div class="alert alert-success custom-alert">
                {{ Session::get('success') }}
            </div>
        @endif
        @if (Session::has('error'))
            <div class="alert alert-danger custom-alert">
                {{ Session::get('error') }}
            </div>
        @endif
        @if (($bobot->status ?? 'draft') == 'terkirim')
            <div class="alert alert-warning custom-alert d-flex align-items-center gap-2" style="background-color: #fffbeb; border: 1.5px solid #fef3c7; color: #b45309; padding: 12px; border-radius: 10px; font-size: 0.8rem; font-weight: 600; margin-bottom: 16px;">
                <ion-icon name="lock-closed-outline" style="font-size: 18px; flex-shrink: 0;"></ion-icon>
                <div>
                    <strong>Nilai Terkunci:</strong> Nilai kelas & mapel ini telah dikirim. Anda tidak dapat melakukan perubahan data.
                </div>
            </div>
        @endif

        <!-- Course Header Card -->
        <div class="info-card">
            <h4 class="info-subject">Nilai {{ ucfirst(strtolower($kategori)) }} Lingkup Materi</h4>
            <div class="info-meta">
                {{ $bobot->mapel->nama_matpel ?? '-' }} | Kelas {{ $bobot->kelas->nama_kelas ?? '-' }}
            </div>
            
            @if (($bobot->status ?? 'draft') != 'terkirim')
                <div class="action-row">
                    <span style="font-size: 0.7rem; font-weight: 600; color: rgba(255, 255, 255, 0.7); text-transform: uppercase;">Lingkup Materi</span>
                    <button type="button" class="btn-add-col" data-toggle="modal" data-target="#mdlAddColumn">
                        <ion-icon name="plus-outline"></ion-icon>
                        <span>Tambah Penilaian</span>
                    </button>
                </div>
            @endif
        </div>

        <!-- Search Bar -->
        <div class="search-wrapper">
            <ion-icon name="search-outline"></ion-icon>
            <input type="text" id="searchInput" class="search-input" placeholder="Cari nama atau NIS siswa...">
        </div>

        <!-- Inputs Form -->
        <form action="{{ route('penilaian.store-multi-nilai') }}" method="POST">
            @csrf
            
            <div id="students-manage-list">
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
                    <div class="student-manage-card" data-name="{{ strtolower($student->nama_lengkap) }} {{ strtolower($student->nis) }}">
                        <!-- Student Header Info -->
                        <div class="card-header-student">
                            <div style="display: flex; align-items: center; gap: 10px; min-width: 0;">
                                @if (!empty($student->foto) && Storage::disk('public')->exists('photos/pendaftaran/' . $student->foto))
                                    <img src="{{ asset('storage/photos/pendaftaran/' . $student->foto) }}" class="student-photo" alt="{{ $student->nama_lengkap }}">
                                @else
                                    <div class="student-avatar">
                                        {{ $initials }}
                                    </div>
                                @endif
                                <div style="min-width: 0;">
                                    <h4 class="student-name" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $student->nama_lengkap }}</h4>
                                    <span class="student-nis">NIS: {{ $student->nis ?? '-' }}</span>
                                </div>
                            </div>
                            <span class="student-gender">{{ $student->jenis_kelamin }}</span>
                        </div>

                        <!-- Inputs for each Rencana Penilaian -->
                        <div class="card-body-inputs">
                            @forelse ($rencanaPenilaian as $rencana)
                                @php
                                    $score = $mappedGrades[$student->id_siswa][$rencana->id] ?? '';
                                @endphp
                                <div class="input-row">
                                    <div class="input-label-wrapper">
                                        <span class="input-code">{{ $rencana->kode_penilaian }}</span>
                                        <span class="input-desc">{{ $rencana->nama_penilaian }}</span>
                                    </div>
                                    <div class="score-input-wrapper">
                                        <input type="number" step="0.01" min="0" max="100" 
                                            name="nilai[{{ $student->id_siswa }}][{{ $rencana->id }}]" 
                                            class="form-control score-input {{ $score !== '' ? ($score < 75 ? 'text-danger' : 'text-success') : '' }}" 
                                            value="{{ $score }}" placeholder="-" {{ ($bobot->status ?? 'draft') == 'terkirim' ? 'disabled' : '' }}>
                                    </div>
                                </div>
                            @empty
                                <div style="text-align: center; padding: 10px 0;">
                                    <small class="text-muted">Belum ada kolom penilaian. Ketuk "Tambah Penilaian" di atas.</small>
                                </div>
                            @endforelse
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

            <!-- Sticky Save Bar -->
            @if (($bobot->status ?? 'draft') != 'terkirim')
                <div class="sticky-save-bar">
                    <button type="submit" class="btn-save-all btn-action">
                        <ion-icon name="save-outline" style="font-size: 18px;"></ion-icon>
                        <span>Simpan Semua Nilai</span>
                    </button>
                </div>
            @endif
        </form>

    </div>

    <!-- Modal Add Column (Rencana) -->
    <div class="modal fade" id="mdlAddColumn" tabindex="-1" role="dialog" aria-labelledby="mdlAddColumnLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header text-white" style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); border-bottom: none; padding: 18px 20px; display: flex; align-items: center; justify-content: space-between;">
                    <h5 class="modal-title text-white" id="mdlAddColumnLabel" style="font-weight: 700; font-size: 1.05rem; display: flex; align-items: center; gap: 8px; margin-bottom: 0;">
                        <ion-icon name="plus-circle-outline" style="font-size: 20px; color: var(--accent);"></ion-icon>
                        Tambah Penilaian {{ ucfirst(strtolower($kategori)) }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #ffffff; opacity: 0.9; outline: none; background: none; border: none; padding: 4px; margin: 0; display: flex; align-items: center; justify-content: center;">
                        <ion-icon name="close-outline" style="font-size: 24px; color: #ffffff;"></ion-icon>
                    </button>
                </div>
                <form action="{{ route('penilaian.store-rencana') }}" method="POST">
                    @csrf
                    <input type="hidden" name="bobot_penilaian_id" value="{{ $bobot->id }}">
                    <input type="hidden" name="kategori_penilaian" value="{{ $kategori }}">
                    <div class="modal-body" style="padding: 20px; background: #ffffff;">
                        <div style="display: flex; flex-direction: column; gap: 16px;">
                            
                            <!-- Kode Penilaian -->
                            <div class="filter-input-group" style="display: flex; align-items: center; background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 14px; padding: 10px 14px; transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1); position: relative; width: 100%;">
                                <ion-icon name="keypad-outline" class="field-icon" style="font-size: 20px; color: var(--primary-light); margin-right: 10px; flex-shrink: 0;"></ion-icon>
                                <div class="filter-input-content" style="flex: 1; display: flex; flex-direction: column; min-width: 0;">
                                    <label style="font-size: 0.72rem; font-weight: 600; color: var(--text-muted); margin: 0 0 2px 0 !important; line-height: 1.2;">Kode (Singkatan)</label>
                                    <input type="text" name="kode_penilaian" placeholder="{{ $kategori == 'SUMATIF' ? 'PH...' : 'SAS' }}" required
                                        style="border: none !important; background: transparent !important; padding: 0 !important; font-size: 0.88rem !important; font-weight: 600 !important; color: var(--text-main) !important; outline: none !important; width: 100% !important; height: auto !important; box-shadow: none !important; margin: 0; line-height: 1.3;">
                                </div>
                            </div>

                            <!-- Nama Materi -->
                            <div class="filter-input-group" style="display: flex; align-items: center; background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 14px; padding: 10px 14px; transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1); position: relative; width: 100%;">
                                <ion-icon name="book-outline" class="field-icon" style="font-size: 20px; color: var(--primary-light); margin-right: 10px; flex-shrink: 0;"></ion-icon>
                                <div class="filter-input-content" style="flex: 1; display: flex; flex-direction: column; min-width: 0;">
                                    <label style="font-size: 0.72rem; font-weight: 600; color: var(--text-muted); margin: 0 0 2px 0 !important; line-height: 1.2;">Nama Materi / Keterangan</label>
                                    <input type="text" name="nama_penilaian" placeholder="Contoh: Bab 1 Bilangan Bulat" required
                                        style="border: none !important; background: transparent !important; padding: 0 !important; font-size: 0.88rem !important; font-weight: 600 !important; color: var(--text-main) !important; outline: none !important; width: 100% !important; height: auto !important; box-shadow: none !important; margin: 0; line-height: 1.3;">
                                </div>
                            </div>

                            <!-- Tanggal -->
                            <div class="filter-input-group" style="display: flex; align-items: center; background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 14px; padding: 10px 14px; transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1); position: relative; width: 100%;">
                                <ion-icon name="calendar-outline" class="field-icon" style="font-size: 20px; color: var(--primary-light); margin-right: 10px; flex-shrink: 0;"></ion-icon>
                                <div class="filter-input-content" style="flex: 1; display: flex; flex-direction: column; min-width: 0;">
                                    <label style="font-size: 0.72rem; font-weight: 600; color: var(--text-muted); margin: 0 0 2px 0 !important; line-height: 1.2;">Tanggal</label>
                                    <input type="text" id="tanggal_penilaian" name="tanggal_penilaian" value="{{ date('Y-m-d') }}" placeholder="Pilih Tanggal"
                                        style="border: none !important; background: transparent !important; padding: 0 !important; font-size: 0.88rem !important; font-weight: 600 !important; color: var(--text-main) !important; outline: none !important; width: 100% !important; height: auto !important; box-shadow: none !important; margin: 0; line-height: 1.3; cursor: pointer;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="border-top: none; padding: 12px 20px 20px 20px; background: #ffffff; display: flex; gap: 10px;">
                        <button type="button" class="btn btn-action" data-dismiss="modal" style="flex: 1; background: #f1f5f9; color: var(--text-muted); font-weight: 700; border-radius: 14px; padding: 12px; border: none; font-size: 0.85rem; height: auto; line-height: 1.2;">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-action" style="flex: 1.5; background: var(--primary); color: #ffffff; font-weight: 700; border-radius: 14px; padding: 12px; border: none; font-size: 0.85rem; height: auto; line-height: 1.2; box-shadow: 0 4px 12px rgba(6, 78, 59, 0.15);">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
@endpush

@push('myscript')
    <script>
        $(document).ready(function() {
            // Initialize Flatpickr for date input in modal to match presensi-mapel
            flatpickr("#tanggal_penilaian", {
                locale: "id",
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "d F Y",
                disableMobile: true
            });

            // Client side filter search
            $("#searchInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $(".student-manage-card").filter(function() {
                    $(this).toggle($(this).attr("data-name").indexOf(value) > -1);
                });
            });

            // Dynamic text color change on keyup for scores
            $(".score-input").on("input", function() {
                var val = parseFloat($(this).val());
                $(this).removeClass("text-success text-danger");
                if (!isNaN(val)) {
                    if (val < 75) {
                        $(this).addClass("text-danger");
                    } else {
                        $(this).addClass("text-success");
                    }
                }
            });
        });
    </script>
@endpush

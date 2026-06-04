@extends('layouts.mobile.app_sipren')

@section('title', 'Rapor Siswa - Sipren')
@section('header-title', 'Rapor Siswa')
@section('back-url', route('dashboard.index'))
@section('show-bottom-nav', true)

@push('styles')
    <style>
        .rapor-list-container {
            padding: 16px;
            padding-bottom: 80px;
        }

        /* Card active click effect */
        .btn-action {
            transition: all 0.2s ease;
            text-decoration: none !important;
        }
        .btn-action:active {
            transform: scale(0.95);
            opacity: 0.9;
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

        .filter-input-content select, .filter-input-content input {
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

        .filter-input-content select:focus, .filter-input-content input:focus {
            outline: none !important;
            box-shadow: none !important;
        }

        /* Empty state styling */
        .empty-state {
            background: var(--surface);
            border-radius: 16px;
            padding: 40px 20px;
            text-align: center;
            box-shadow: 0 4px 16px rgba(6, 78, 59, 0.03);
        }

        .empty-state ion-icon {
            font-size: 48px;
            color: #cbd5e1;
            margin-bottom: 12px;
        }

        .empty-state h4 {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--text-main);
            margin: 0 0 6px;
        }

        .empty-state p {
            font-size: 0.78rem;
            color: var(--text-muted);
            margin: 0;
        }

        /* Modal Overrides */
        #filterModal .modal-content {
            border-radius: 24px;
            border: none;
            box-shadow: 0 12px 36px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }

        /* Modernized Card Styles - 10px Rounded, No Border */
        .rapor-card {
            border-radius: 10px !important;
            background: var(--surface);
            box-shadow: 0 4px 16px rgba(6, 78, 59, 0.04) !important;
            border: none !important;
            overflow: hidden;
            transition: all 0.2s ease;
        }

        .card-header-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 8px;
        }

        .card-ta-text {
            font-size: 0.65rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.03em;
            margin-bottom: 4px;
            display: block;
        }

        .subject-title {
            font-size: 0.95rem;
            font-weight: 800;
            color: var(--text-main);
            margin: 0;
            line-height: 1.35;
            letter-spacing: -0.01em;
        }

        /* Status badges */
        .status-pill {
            font-size: 0.62rem;
            font-weight: 700;
            padding: 4px 8px;
            border-radius: 6px;
            text-transform: uppercase;
            letter-spacing: 0.02em;
            display: inline-block;
        }

        .status-pill-success {
            background: rgba(16, 185, 129, 0.08);
            color: #10b981;
            border: 1px solid rgba(16, 185, 129, 0.15);
        }

        .status-pill-secondary {
            background: rgba(100, 116, 139, 0.08);
            color: #64748b;
            border: 1px solid rgba(100, 116, 139, 0.15);
        }

        /* Meta rows */
        .card-meta-list {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px dashed var(--border-color);
        }

        .meta-row-split {
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            gap: 12px;
        }

        .meta-row {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.76rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .meta-row ion-icon {
            color: var(--primary-light);
            font-size: 14px;
            flex-shrink: 0;
        }

        /* Modernized actions */
        .card-actions-wrapper {
            margin-top: 12px;
            padding-top: 10px;
            border-top: 1px solid #f1f5f9;
            display: flex;
            justify-content: flex-end;
        }

        .btn-input-action {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            font-size: 0.8rem;
            font-weight: 700;
            background: var(--primary);
            color: #ffffff !important;
            border: none;
            border-radius: 8px;
            padding: 8px 18px;
            width: 100%;
            text-align: center;
            text-decoration: none !important;
            box-shadow: 0 4px 12px rgba(6, 78, 59, 0.15);
            transition: all 0.2s ease;
        }

        .btn-input-action:active {
            transform: scale(0.97);
            box-shadow: 0 2px 6px rgba(6, 78, 59, 0.1);
        }
    </style>
@endpush

@section('content')
    <div class="rapor-list-container">
        
        <!-- Subheader & Filter Button -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
            <span style="font-size: 0.78rem; font-weight: 700; color: var(--primary); text-transform: uppercase; letter-spacing: 0.05em;">
                Daftar Pelajaran & Rapor
            </span>
            <button class="btn btn-sm btn-action" type="button" data-toggle="modal" data-target="#filterModal"
                    style="background: #ffffff; color: var(--primary); border: 1.5px solid var(--primary); border-radius: 10px; font-weight: 700; font-size: 0.75rem; display: flex; align-items: center; gap: 4px; padding: 6px 12px; box-shadow: var(--shadow-sm); position: relative; height: auto; line-height: 1.2;">
                <ion-icon name="funnel-outline" style="font-size: 14px;"></ion-icon>
                <span>Filter</span>
                @if (request('kode_unit') || request('kode_ta') || request('semester'))
                    <span style="position: absolute; top: -3px; right: -3px; display: block; width: 8px; height: 8px; border-radius: 50%; background: var(--accent); border: 1.5px solid #ffffff;"></span>
                @endif
            </button>
        </div>

        <!-- Rapor List -->
        <div id="rapor-list-section">
            @forelse ($jadwalGrouped as $d)
                <div class="rapor-card mb-3">
                    <div class="card-body p-3">
                        <div class="card-header-top">
                            <div>
                                <span class="card-ta-text">
                                    TA: {{ $d->tahunAjaran->tahun_ajaran ?? '-' }}
                                </span>
                                <h4 class="subject-title">
                                    {{ $d->mapel->nama_matpel ?? '-' }}
                                </h4>
                            </div>
                            <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 4px;">
                                <span class="status-pill status-pill-success">
                                    {{ $d->semester == 1 ? 'Ganjil' : 'Genap' }}
                                </span>
                                @if (($d->status_penilaian ?? 'draft') == 'terkirim')
                                    <span class="badge bg-success" style="font-size: 0.6rem; font-weight: 700; text-transform: uppercase; padding: 3px 6px; border-radius: 5px; color: #ffffff; border: none;">Terkirim</span>
                                @else
                                    <span class="badge bg-warning" style="font-size: 0.6rem; font-weight: 700; text-transform: uppercase; padding: 3px 6px; border-radius: 5px; color: #ffffff; border: none;">Draft</span>
                                @endif
                            </div>
                        </div>

                        <div class="card-meta-list">
                            <!-- Kelas & Unit aligned side-by-side -->
                            <div class="meta-row-split">
                                <div class="meta-row">
                                    <ion-icon name="business-outline"></ion-icon>
                                    <span>Kelas {{ $d->kelas->nama_kelas ?? '-' }}</span>
                                </div>
                                <div class="meta-row">
                                    <ion-icon name="school-outline"></ion-icon>
                                    <span>{{ $d->unit->nama_unit ?? '-' }}</span>
                                </div>
                            </div>
                            <div class="meta-row">
                                <ion-icon name="person-outline"></ion-icon>
                                <span>Guru: {{ $d->guru->karyawan->nama_lengkap ?? $d->guru->nama_guru ?? '-' }}</span>
                            </div>
                        </div>

                        <!-- Card Actions -->
                        <div class="card-actions-wrapper">
                            <a href="{{ route('penilaian.index', $d->id) }}" 
                               class="btn-input-action btn-action">
                                <ion-icon name="create-outline" style="font-size: 15px;"></ion-icon>
                                <span>Input Nilai / Rapor</span>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <ion-icon name="document-text-outline" style="color: #cbd5e1; font-size: 48px;"></ion-icon>
                    <h4>Belum Ada Data Rapor</h4>
                    <p>Silakan sesuaikan filter atau hubungi admin akademik.</p>
                </div>
            @endforelse
        </div>

    </div>

    <!-- Filter Modal -->
    <div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: #ffffff; border-bottom: none; padding: 18px 20px; display: flex; align-items: center; justify-content: space-between;">
                    <h5 class="modal-title" id="filterModalLabel" style="font-weight: 700; font-size: 1.05rem; color: #ffffff; display: flex; align-items: center; gap: 8px; margin-bottom: 0; letter-spacing: -0.01em;">
                        <ion-icon name="funnel-outline" style="font-size: 20px; color: var(--accent);"></ion-icon>
                        Filter Rapor
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #ffffff; opacity: 0.9; outline: none; background: none; border: none; padding: 4px; margin: 0; display: flex; align-items: center; justify-content: center; transition: all 0.2s ease;">
                        <ion-icon name="close-outline" style="font-size: 24px; color: #ffffff;"></ion-icon>
                    </button>
                </div>
                <form action="{{ route('rapor.index') }}" method="GET">
                    <div class="modal-body" style="padding: 20px; background: #ffffff;">
                        <div style="display: flex; flex-direction: column; gap: 16px;">
                            
                            <!-- Unit -->
                            <div class="filter-input-group">
                                <ion-icon name="business-outline" class="field-icon"></ion-icon>
                                <div class="filter-input-content">
                                    <label>Unit</label>
                                    <select name="kode_unit" id="filter_kode_unit">
                                        <option value="">Semua Unit</option>
                                        @foreach ($units as $u)
                                            <option value="{{ $u->kode_unit }}" {{ request('kode_unit') == $u->kode_unit ? 'selected' : '' }}>
                                                {{ $u->nama_unit }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <ion-icon name="chevron-down-outline" style="font-size: 14px; color: var(--text-muted); margin-left: 8px; flex-shrink: 0;"></ion-icon>
                            </div>

                            <!-- Tahun Ajaran -->
                            <div class="filter-input-group">
                                <ion-icon name="calendar-outline" class="field-icon"></ion-icon>
                                <div class="filter-input-content">
                                    <label>Tahun Ajaran</label>
                                    <select name="kode_ta" id="filter_kode_ta">
                                        <option value="">Tahun Ajaran</option>
                                        @foreach ($semuaTa as $ta)
                                            <option value="{{ $ta->kode_ta }}" {{ $selectedKodeTa == $ta->kode_ta ? 'selected' : '' }}>
                                                {{ $ta->tahun_ajaran }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <ion-icon name="chevron-down-outline" style="font-size: 14px; color: var(--text-muted); margin-left: 8px; flex-shrink: 0;"></ion-icon>
                            </div>

                            <!-- Semester -->
                            <div class="filter-input-group">
                                <ion-icon name="bookmarks-outline" class="field-icon"></ion-icon>
                                <div class="filter-input-content">
                                    <label>Semester</label>
                                    <select name="semester" id="filter_semester">
                                        <option value="">Pilih Semester</option>
                                        <option value="1" {{ $selectedSemester == 1 ? 'selected' : '' }}>Ganjil (1)</option>
                                        <option value="2" {{ $selectedSemester == 2 ? 'selected' : '' }}>Genap (2)</option>
                                    </select>
                                </div>
                                <ion-icon name="chevron-down-outline" style="font-size: 14px; color: var(--text-muted); margin-left: 8px; flex-shrink: 0;"></ion-icon>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="border-top: none; padding: 12px 20px 20px 20px; background: #ffffff; display: flex; gap: 10px;">
                        <button type="button" class="btn btn-action" data-dismiss="modal" style="flex: 1; background: #f1f5f9; color: var(--text-muted); font-weight: 700; border-radius: 14px; padding: 12px; border: none; font-size: 0.85rem; height: auto; line-height: 1.2;">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-action" style="flex: 1.5; background: var(--primary); color: #ffffff; font-weight: 700; border-radius: 14px; padding: 12px; border: none; font-size: 0.85rem; height: auto; line-height: 1.2; box-shadow: 0 4px 12px rgba(6, 78, 59, 0.15);">
                            Terapkan Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

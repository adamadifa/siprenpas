@extends('layouts.mobile.app_sipren')

@section('title', 'Ekstrakurikuler - Sipren')
@section('header-title', 'Ekstrakurikuler')
@section('back-url', route('dashboard.index'))
@section('show-bottom-nav', true)

@push('styles')
    <style>
        .ekskul-list-container {
            padding: 16px;
            padding-bottom: 80px;
        }

        /* Card styles */
        .list-card {
            background: var(--surface);
            border-radius: 10px;
            box-shadow: 0 4px 16px rgba(6, 78, 59, 0.04);
            border: none;
            overflow: hidden;
            margin-bottom: 12px;
            padding: 14px;
        }

        .card-title-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 6px;
        }

        .card-main-title {
            font-size: 0.95rem;
            font-weight: 800;
            color: var(--text-main);
            margin: 0;
        }

        .unit-badge {
            font-size: 0.65rem;
            font-weight: 700;
            color: var(--primary);
            background: rgba(6, 78, 59, 0.08);
            padding: 2px 8px;
            border-radius: 6px;
        }

        .card-subtitle {
            font-size: 0.72rem;
            color: var(--text-muted);
            font-weight: 500;
            margin-bottom: 8px;
        }

        /* Action Buttons */
        .card-actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 12px;
            padding-top: 10px;
            border-top: 1px solid #f1f5f9;
            gap: 8px;
        }

        .btn-card-action {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            font-size: 0.72rem;
            font-weight: 700;
            padding: 6px 14px;
            border-radius: 8px;
            text-decoration: none !important;
            transition: all 0.2s ease;
        }

        .btn-primary-action {
            background: var(--primary);
            color: #ffffff !important;
            border: none;
            box-shadow: 0 4px 10px rgba(6, 78, 59, 0.15);
        }

        .btn-primary-action:active {
            transform: scale(0.97);
        }

        /* Filter trigger */
        .filter-btn {
            background: #ffffff;
            color: var(--primary);
            border: 1.5px solid var(--primary);
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            gap: 4px;
            padding: 6px 12px;
            box-shadow: var(--shadow-sm);
            position: relative;
        }

        /* Modal styling */
        .filter-input-group {
            display: flex;
            align-items: center;
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: 14px;
            padding: 10px 14px;
            transition: all 0.2s ease;
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

        .filter-input-content select {
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
        }

        .modal-content {
            border-radius: 24px;
            border: none;
            overflow: hidden;
        }
    </style>
@endpush

@section('content')
    <div class="ekskul-list-container">
        
        <!-- Header & Filter Button -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
            <span style="font-size: 0.78rem; font-weight: 700; color: var(--primary); text-transform: uppercase; letter-spacing: 0.05em;">
                Daftar Ekstrakurikuler
            </span>
            <button class="btn btn-sm filter-btn" type="button" data-toggle="modal" data-target="#filterModal">
                <ion-icon name="funnel-outline" style="font-size: 14px;"></ion-icon>
                <span>Filter</span>
                @if (request('kode_unit') || request('kode_ta'))
                    <span style="position: absolute; top: -3px; right: -3px; display: block; width: 8px; height: 8px; border-radius: 50%; background: var(--accent); border: 1.5px solid #ffffff;"></span>
                @endif
            </button>
        </div>

        <!-- Ekstrakurikuler List -->
        <div id="ekskul-list-section">
            @forelse ($ekstrakurikuler as $ekskul)
                <div class="list-card">
                    <div class="card-title-row">
                        <h4 class="card-main-title">{{ $ekskul->nama_ekstrakurikuler }}</h4>
                        <span class="unit-badge">{{ $ekskul->unit->nama_unit ?? '-' }}</span>
                    </div>
                    <div class="card-subtitle" style="margin-bottom: 4px;">
                        Koordinator: {{ $ekskul->guru->nama_guru ?? '-' }}
                    </div>
                    <div style="font-size: 0.72rem; color: var(--text-muted); font-weight: 500;">
                        TA: {{ $ekskul->tahunAjaran->tahun_ajaran ?? '-' }}
                    </div>

                    <!-- Actions -->
                    <div class="card-actions">
                        <a href="{{ route('rapor-siswa.ekskul.nilai', $ekskul->id) }}" class="btn-card-action btn-primary-action">
                            <ion-icon name="create-outline"></ion-icon>
                            <span>Input Nilai & Siswa</span>
                        </a>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <ion-icon name="star-outline" style="font-size: 48px; color: #cbd5e1;"></ion-icon>
                    <h4>Belum ada ekstrakurikuler</h4>
                    <p>Anda belum ditugaskan sebagai koordinator kegiatan ekstrakurikuler.</p>
                </div>
            @endforelse
        </div>

    </div>

    <!-- Filter Modal -->
    <div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: #ffffff; border-bottom: none; padding: 18px 20px; display: flex; align-items: center; justify-content: space-between;">
                    <h5 class="modal-title" id="filterModalLabel" style="font-weight: 700; font-size: 1.05rem; color: #ffffff; display: flex; align-items: center; gap: 8px; margin-bottom: 0;">
                        <ion-icon name="funnel-outline" style="font-size: 20px; color: var(--accent);"></ion-icon>
                        Filter Data
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #ffffff; background: none; border: none; padding: 4px; margin: 0; display: flex; align-items: center;">
                        <ion-icon name="close-outline" style="font-size: 24px; color: #ffffff;"></ion-icon>
                    </button>
                </div>
                <form action="{{ route('rapor-siswa.index') }}" method="GET">
                    <div class="modal-body" style="padding: 20px; background: #ffffff;">
                        <div style="display: flex; flex-direction: column; gap: 16px;">
                            
                            <!-- Unit -->
                            <div class="filter-input-group">
                                <ion-icon name="business-outline" class="field-icon"></ion-icon>
                                <div class="filter-input-content">
                                    <label>Unit</label>
                                    <select name="kode_unit">
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
                                <ion-icon name="bookmark-outline" class="field-icon"></ion-icon>
                                <div class="filter-input-content">
                                    <label>Tahun Ajaran</label>
                                    <select name="kode_ta">
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

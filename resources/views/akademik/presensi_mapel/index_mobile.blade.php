@extends('layouts.mobile.app_sipren')

@section('title', 'Presensi Mata Pelajaran - Sipren')
@section('header-title', 'Presensi Pelajaran')
@section('back-url', route('dashboard.index'))
@section('show-bottom-nav', true)

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        /* Flatpickr Custom Green Theme */
        .flatpickr-calendar {
            border-radius: 14px !important;
            box-shadow: 0 10px 30px rgba(6, 78, 59, 0.12) !important;
            border: none !important;
            font-family: inherit;
            overflow: hidden;
            background: #ffffff !important;
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
        .presensi-list-container {
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

        /* Pagination custom wrapper */
        .pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination-wrapper .pagination {
            gap: 4px;
        }

        .pagination-wrapper .page-item .page-link {
            border-radius: 8px;
            border: 1px solid var(--border-color);
            color: var(--text-main);
            font-size: 0.8rem;
            font-weight: 600;
            padding: 6px 12px;
        }

        .pagination-wrapper .page-item.active .page-link {
            background: var(--primary);
            border-color: var(--primary);
            color: #ffffff;
        }

        /* Modernized Card Styles - 10px Rounded (Not too rounded) */
        .attendance-card {
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

        .card-date-text {
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
            grid-template-columns: 1fr 1fr;
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
            gap: 8px;
        }

        .btn-edit-action {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            font-size: 0.72rem;
            font-weight: 700;
            background: rgba(217, 119, 6, 0.06);
            color: #d97706;
            border: 1px solid rgba(217, 119, 6, 0.12);
            border-radius: 8px;
            padding: 6px 14px;
            text-decoration: none !important;
            transition: all 0.2s ease;
        }

        .btn-edit-action:active {
            background: rgba(217, 119, 6, 0.12);
            transform: scale(0.97);
        }

        .btn-delete-action {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            font-size: 0.72rem;
            font-weight: 700;
            background: rgba(220, 38, 38, 0.06);
            color: #dc2626;
            border: 1px solid rgba(220, 38, 38, 0.12);
            border-radius: 8px;
            padding: 6px 14px;
            border: none;
            transition: all 0.2s ease;
        }

        .btn-delete-action:active {
            background: rgba(220, 38, 38, 0.12);
            transform: scale(0.97);
        }
    </style>
@endpush

@section('content')
    <div class="presensi-list-container">
        
        <!-- Subheader & Filter Button -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
            <span style="font-size: 0.78rem; font-weight: 700; color: var(--primary); text-transform: uppercase; letter-spacing: 0.05em;">
                Riwayat Presensi
            </span>
            <button class="btn btn-sm btn-action" type="button" data-toggle="modal" data-target="#filterModal"
                    style="background: #ffffff; color: var(--primary); border: 1.5px solid var(--primary); border-radius: 10px; font-weight: 700; font-size: 0.75rem; display: flex; align-items: center; gap: 4px; padding: 6px 12px; box-shadow: var(--shadow-sm); position: relative; height: auto; line-height: 1.2;">
                <ion-icon name="funnel-outline" style="font-size: 14px;"></ion-icon>
                <span>Filter</span>
                @if (request('kode_unit') || request('kode_kelas') || request('tanggal'))
                    <span style="position: absolute; top: -3px; right: -3px; display: block; width: 8px; height: 8px; border-radius: 50%; background: var(--accent); border: 1.5px solid #ffffff;"></span>
                @endif
            </button>
        </div>

        <!-- Attendance List -->
        <div id="attendance-list-section">
            @forelse ($presensi as $p)
                <div class="attendance-card mb-3">
                    <div class="card-body p-3">
                        <div class="card-header-top">
                            <div>
                                <span class="card-date-text">
                                    {{ \Carbon\Carbon::parse($p->tanggal)->translatedFormat('l, d M Y') }}
                                </span>
                                <h4 class="subject-title">
                                    {{ $p->mata_pelajaran->nama_matpel ?? '-' }}
                                </h4>
                            </div>
                            <span class="status-pill {{ $p->materi ? 'status-pill-success' : 'status-pill-secondary' }}">
                                {{ $p->materi ? 'Materi Ada' : 'Materi Kosong' }}
                            </span>
                        </div>

                        <div class="card-meta-list">
                            <div class="meta-row-split">
                                <div class="meta-row">
                                    <ion-icon name="business-outline"></ion-icon>
                                    <span>Kelas {{ $p->kelas->nama_kelas ?? '-' }} ({{ $p->unit->nama_unit ?? '-' }})</span>
                                </div>
                                <div class="meta-row">
                                    <ion-icon name="time-outline"></ion-icon>
                                    <span>{{ substr($p->jam_mulai, 0, 5) }} - {{ substr($p->jam_selesai, 0, 5) }}</span>
                                </div>
                            </div>
                            @if(!auth()->user()->hasRole('guru'))
                                <div class="meta-row" style="margin-top: 4px;">
                                    <ion-icon name="person-outline"></ion-icon>
                                    <span>{{ $p->guru->karyawan->nama_lengkap ?? '-' }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Card Actions -->
                        <div class="card-actions-wrapper">
                            <a href="{{ route('presensi-mapel.edit', Crypt::encrypt($p->id)) }}" 
                               class="btn-edit-action btn-action">
                                <ion-icon name="create-outline" style="font-size: 13px;"></ion-icon>
                                <span>Edit</span>
                            </a>
                            
                            <form action="{{ route('presensi-mapel.delete', Crypt::encrypt($p->id)) }}" method="POST" class="d-inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete-action delete-btn btn-action">
                                    <ion-icon name="trash-outline" style="font-size: 13px;"></ion-icon>
                                    <span>Hapus</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <ion-icon name="checkbox-outline" style="color: #cbd5e1; font-size: 48px;"></ion-icon>
                    <h4>Belum Ada Data Presensi</h4>
                    <p>Silakan sesuaikan filter atau tambahkan presensi dari menu jadwal.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if ($presensi->hasPages())
            <div class="pagination-wrapper">
                {{ $presensi->appends(request()->all())->links('pagination::bootstrap-4') }}
            </div>
        @endif

    </div>

    <!-- Filter Modal -->
    <div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: #ffffff; border-bottom: none; padding: 18px 20px; display: flex; align-items: center; justify-content: space-between;">
                    <h5 class="modal-title" id="filterModalLabel" style="font-weight: 700; font-size: 1.05rem; color: #ffffff; display: flex; align-items: center; gap: 8px; margin-bottom: 0; letter-spacing: -0.01em;">
                        <ion-icon name="funnel-outline" style="font-size: 20px; color: var(--accent);"></ion-icon>
                        Filter Presensi
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #ffffff; opacity: 0.9; outline: none; background: none; border: none; padding: 4px; margin: 0; display: flex; align-items: center; justify-content: center; transition: all 0.2s ease;">
                        <ion-icon name="close-outline" style="font-size: 24px; color: #ffffff;"></ion-icon>
                    </button>
                </div>
                <form action="{{ route('presensi-mapel.index') }}" method="GET">
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

                            <!-- Kelas -->
                            <div class="filter-input-group">
                                <ion-icon name="school-outline" class="field-icon"></ion-icon>
                                <div class="filter-input-content">
                                    <label>Kelas</label>
                                    <select name="kode_kelas" id="filter_kode_kelas">
                                        <option value="">Semua Kelas</option>
                                        @foreach ($kelas as $k)
                                            <option value="{{ $k->kode_kelas }}" {{ request('kode_kelas') == $k->kode_kelas ? 'selected' : '' }}>
                                                {{ $k->nama_kelas }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <ion-icon name="chevron-down-outline" style="font-size: 14px; color: var(--text-muted); margin-left: 8px; flex-shrink: 0;"></ion-icon>
                            </div>

                            <!-- Tanggal -->
                            <div class="filter-input-group">
                                <ion-icon name="calendar-outline" class="field-icon"></ion-icon>
                                <div class="filter-input-content">
                                    <label>Tanggal</label>
                                    <input type="text" id="filter_tanggal" name="tanggal" value="{{ request('tanggal') }}" placeholder="Pilih Tanggal">
                                </div>
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

@push('myscript')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Flatpickr for date filter
            flatpickr("#filter_tanggal", {
                locale: "id",
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "d F Y",
                disableMobile: true
            });

            // Delete confirmation dialog
            $('.delete-btn').click(function(e) {
                var form = $(this).closest("form");
                e.preventDefault();
                Swal.fire({
                    title: 'Hapus Presensi?',
                    text: "Data kehadiran akan dihapus secara permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, Hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });

            // Dynamic filter options by Unit Selection
            $("#filter_kode_unit").change(function() {
                var kode_unit = $(this).val();
                
                if (kode_unit) {
                    $("#filter_kode_kelas").html('<option value="">Loading...</option>').prop('disabled', true);
                    
                    $.ajax({
                        url: "{{ route('jadwal-pelajaran.get-data-by-unit') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            kode_unit: kode_unit
                        },
                        dataType: "json",
                        success: function(data) {
                            if(data.status == 'success') {
                                var kelasOptions = '<option value="">Semua Kelas</option>';
                                $.each(data.kelas, function(key, value) {
                                    kelasOptions += '<option value="'+ value.kode_kelas +'">'+ value.nama_kelas +'</option>';
                                });
                                $("#filter_kode_kelas").html(kelasOptions).prop('disabled', false);
                            }
                        }
                    });
                } else {
                    $("#filter_kode_kelas").html('<option value="">Semua Kelas</option>');
                }
            });
        });
    </script>
@endpush

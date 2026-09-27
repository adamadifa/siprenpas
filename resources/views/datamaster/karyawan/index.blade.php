@extends('layouts.app')
@section('titlepage', 'Karyawan')

@section('content')
<style>
    /* Modern Semi-Formal Karyawan Card */
    .karyawan-item-card {
        background: #ffffff;
        border-radius: 12px;
        transition: border-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
        box-shadow: 0 1px 3px rgba(15, 23, 42, 0.03);
        position: relative;
    }

    .karyawan-item-card.dropdown-open {
        z-index: 1050 !important;
    }

    .karyawan-item-card.card-status-active {
        border: 1px solid #10b981;
    }

    .karyawan-item-card.card-status-nonactive {
        border: 1px solid #ef4444;
    }

    .karyawan-item-card.card-status-active:hover {
        border-color: #059669;
        box-shadow: 0 8px 20px -4px rgba(16, 185, 129, 0.15);
        transform: translateY(-1px);
    }

    .karyawan-item-card.card-status-nonactive:hover {
        border-color: #dc2626;
        box-shadow: 0 8px 20px -4px rgba(239, 68, 68, 0.15);
        transform: translateY(-1px);
    }

    .karyawan-item-card:hover {
        z-index: 10;
    }

    .action-karyawan-btn {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        color: #475569;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        outline: none !important;
    }
    .action-karyawan-btn:hover,
    .action-karyawan-btn[aria-expanded="true"] {
        background: #0f172a;
        color: #ffffff;
        border-color: #0f172a;
    }

    .karyawan-dropdown-menu {
        border-radius: 10px;
        font-size: 0.82rem;
        z-index: 1060 !important;
        min-width: 195px;
        box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.15), 0 8px 10px -6px rgba(15, 23, 42, 0.1) !important;
    }

    .karyawan-avatar-wrapper {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        position: relative;
        overflow: hidden;
    }

    .karyawan-avatar-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .status-dot-indicator {
        position: absolute;
        bottom: 2px;
        right: 2px;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        border: 2px solid #ffffff;
    }

    .karyawan-name-title {
        font-size: 0.95rem;
        font-weight: 700;
        color: #0f172a;
        letter-spacing: -0.01em;
        line-height: 1.35;
    }

    .badge-subtle-unit {
        font-size: 0.7rem;
        font-weight: 600;
        color: #334155;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        padding: 0.2rem 0.55rem;
    }

    .badge-subtle-dept {
        font-size: 0.7rem;
        font-weight: 600;
        color: #1d4ed8;
        background: #eff6ff;
        border: 1px solid #dbeafe;
        border-radius: 6px;
        padding: 0.2rem 0.55rem;
    }

    .status-pill-toggle {
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.5px;
        border-radius: 100px;
        padding: 0.25rem 0.75rem;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        text-decoration: none;
        transition: opacity 0.2s ease;
    }
    .status-pill-toggle:hover {
        opacity: 0.85;
    }
    .status-pill-active {
        background: #ecfdf5;
        color: #047857;
        border: 1px solid #a7f3d0;
    }
    .status-pill-off {
        background: #fef2f2;
        color: #b91c1c;
        border: 1px solid #fecaca;
    }

    .action-karyawan-btn {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        color: #475569;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }
    .action-karyawan-btn:hover {
        background: #0f172a;
        color: #ffffff;
        border-color: #0f172a;
    }

    /* Unified Executive Statistics Strip */
    .karyawan-stats-strip {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(15, 23, 42, 0.03);
    }

    .karyawan-stat-item {
        padding: 1.1rem 1.5rem;
        transition: background-color 0.2s ease;
    }

    .karyawan-stat-item:hover {
        background-color: #fafbfd;
    }

    .stat-label-text {
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: #64748b;
        margin-bottom: 0.25rem;
    }

    .stat-number-display {
        font-size: 1.65rem;
        font-weight: 800;
        letter-spacing: -0.02em;
        line-height: 1.15;
    }

    .stat-indicator-pill {
        font-size: 0.68rem;
        font-weight: 600;
        padding: 0.15rem 0.55rem;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }

    .stat-icon-box {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    @media (min-width: 992px) {
        .border-start-lg {
            border-left: 1px solid #f1f5f9 !important;
        }
    }
</style>
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-users fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Data Karyawan</h4>
                        <p class="text-muted mb-0 small">Manajemen data dan akses karyawan</p>
                    </div>
                </div>
                <div class="d-flex flex-column align-items-end">
                    <nav aria-label="breadcrumb" class="mb-2">
                        <ol class="breadcrumb breadcrumb-style1 mb-0">
                            <li class="breadcrumb-item">
                                <a href="javascript:void(0);" class="text-muted">
                                    <i class="ti ti-database me-1"></i> Data Master
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                <i class="ti ti-users me-1"></i> Karyawan
                            </li>
                        </ol>
                    </nav>
                    @can('karyawan.create')
                        <button class="btn btn-primary d-flex align-items-center gap-2 shadow-sm" id="btncreateKaryawan" style="background-color: #064e3b; border-color: #064e3b; border-radius: 8px;">
                            <i class="ti ti-plus fs-5"></i>
                            <span>Tambah Karyawan</span>
                        </button>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection

<div class="row">
    <div class="col-lg-12">
        <!-- Executive Statistics Section -->
        <div class="karyawan-stats-strip mb-4 overflow-hidden">
            <div class="row g-0">
                <div class="col-sm-6 col-xl-3 border-end border-bottom border-bottom-xl-0">
                    <div class="karyawan-stat-item h-100 d-flex align-items-center justify-content-between">
                        <div>
                            <div class="stat-label-text">Total Karyawan</div>
                            <div class="d-flex align-items-baseline gap-2">
                                <h3 class="stat-number-display text-dark mb-0">{{ number_format($stats['total_karyawan']) }}</h3>
                                <span class="text-muted small" style="font-size: 0.72rem;">Orang</span>
                            </div>
                        </div>
                        <div class="stat-icon-box" style="background: #f8fafc; color: #475569; border: 1px solid #e2e8f0;">
                            <i class="ti ti-users"></i>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3 border-end-xl border-bottom border-bottom-sm-0">
                    <div class="karyawan-stat-item h-100 d-flex align-items-center justify-content-between">
                        <div>
                            <div class="stat-label-text text-success">Karyawan Aktif</div>
                            <div class="d-flex align-items-baseline gap-2">
                                <h3 class="stat-number-display text-success mb-0">{{ number_format($stats['aktif']) }}</h3>
                                <span class="stat-indicator-pill" style="background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;">
                                    <i class="ti ti-check" style="font-size: 0.7rem;"></i> Aktif
                                </span>
                            </div>
                        </div>
                        <div class="stat-icon-box" style="background: #ecfdf5; color: #059669; border: 1px solid #d1fae5;">
                            <i class="ti ti-user-check"></i>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3 border-end border-bottom border-bottom-xl-0">
                    <div class="karyawan-stat-item h-100 d-flex align-items-center justify-content-between">
                        <div>
                            <div class="stat-label-text text-danger">Karyawan Nonaktif</div>
                            <div class="d-flex align-items-baseline gap-2">
                                <h3 class="stat-number-display text-danger mb-0">{{ number_format($stats['nonaktif']) }}</h3>
                                <span class="stat-indicator-pill" style="background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca;">
                                    <i class="ti ti-x" style="font-size: 0.7rem;"></i> Off
                                </span>
                            </div>
                        </div>
                        <div class="stat-icon-box" style="background: #fef2f2; color: #dc2626; border: 1px solid #fee2e2;">
                            <i class="ti ti-user-x"></i>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="karyawan-stat-item h-100 d-flex align-items-center justify-content-between">
                        <div>
                            <div class="stat-label-text text-info">Total Unit</div>
                            <div class="d-flex align-items-baseline gap-2">
                                <h3 class="stat-number-display text-info mb-0">{{ number_format($stats['total_unit']) }}</h3>
                                <span class="text-muted small" style="font-size: 0.72rem;">Unit</span>
                            </div>
                        </div>
                        <div class="stat-icon-box" style="background: #eff6ff; color: #2563eb; border: 1px solid #dbeafe;">
                            <i class="ti ti-building"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Section (Styled like /akademik/siswa) -->
        <div class="card mb-4 shadow-none border-0 bg-transparent">
            <div class="card-body p-0">
                <form action="{{ route('karyawan.index') }}">
                    <div class="row g-3 align-items-center">
                        <div class="col">
                            <x-input-with-icon label="" value="{{ Request('nama_lengkap') }}" name="nama_lengkap"
                                placeholder="Cari Nama Karyawan" icon="ti ti-search" />
                        </div>

                        <div class="col-md-3 col-12">
                            <div class="form-group mb-3">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="ti ti-school text-muted"></i></span>
                                    <select name="kode_unit" id="kode_unit_search" class="form-select">
                                        <option value="">Semua Unit</option>
                                        @foreach ($units as $u)
                                            <option value="{{ $u->kode_unit }}" {{ Request('kode_unit') == $u->kode_unit ? 'selected' : '' }}>
                                                {{ $u->nama_unit }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-12">
                            <div class="form-group mb-3">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="ti ti-building text-muted"></i></span>
                                    <select name="kode_dept" id="kode_dept_search" class="form-select">
                                        <option value="">Semua Departemen</option>
                                        @foreach ($departemen as $dept)
                                            <option value="{{ $dept->kode_dept }}" {{ Request('kode_dept') == $dept->kode_dept ? 'selected' : '' }}>
                                                {{ $dept->nama_dept }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-auto">
                            <div class="form-group mb-3">
                                <button class="btn btn-primary d-flex align-items-center justify-content-center gap-2" style="background-color: #064e3b; border-color: #064e3b; height: 38px;">
                                    <i class="ti ti-search fs-5"></i>
                                    <span>Cari</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Data List -->
        <div class="row g-3">
            @forelse ($karyawan as $d)
                <div class="col-12">
                    <div class="karyawan-item-card {{ $d->status == 1 ? 'card-status-active' : 'card-status-nonactive' }}">
                        <div class="card-body p-3.5 p-md-4">
                            <div class="row align-items-center g-3">
                                <!-- Info Karyawan -->
                                <div class="col-lg-4 col-md-6">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="karyawan-avatar-wrapper">
                                            @if (!empty($d->foto) && Storage::disk('public')->exists('photos/karyawan/' . $d->foto))
                                                <img src="{{ getfotoKaryawan($d->foto) }}" alt="{{ $d->nama_lengkap }}">
                                            @else
                                                <span class="fw-bold text-dark" style="font-size: 1.05rem;">
                                                     {{ substr($d->nama_lengkap, 0, 1) }}
                                                </span>
                                            @endif
                                            <span class="status-dot-indicator bg-{{ $d->status == 1 ? 'success' : 'danger' }}"></span>
                                        </div>
                                        <div class="overflow-hidden">
                                            <div class="karyawan-name-title text-truncate mb-1" title="{{ $d->nama_lengkap }}">{{ $d->nama_lengkap }}</div>
                                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                                <span class="text-muted small d-inline-flex align-items-center" style="font-size: 0.75rem;"><i class="ti ti-id me-1"></i>{{ $d->npp }}</span>
                                                <span class="badge-subtle-unit">{{ $d->nama_unit }}</span>
                                                @if (!empty($d->nama_dept))
                                                    <span class="badge-subtle-dept">{{ $d->nama_dept }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Detail Karyawan -->
                                <div class="col-lg-3 col-md-6 border-start-lg ps-lg-4">
                                    <div class="d-flex flex-column gap-1.5">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="ti ti-briefcase text-success small"></i>
                                            <span class="fw-semibold text-dark small">{{ $d->nama_jabatan ?? 'Belum Ditentukan' }}</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="ti ti-calendar-event text-info small"></i>
                                            <span class="text-muted small">TMT: {{ !empty($d->tmt) ? date('d M Y', strtotime($d->tmt)) : '-' }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Contact & Status -->
                                <div class="col-lg-3 col-md-6 border-start-lg ps-lg-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div>
                                            <p class="mb-1 text-muted text-uppercase" style="font-size: 0.65rem; font-weight: 700; letter-spacing: 0.5px;">STATUS</p>
                                            <a href="{{ route('karyawan.updatestatus', Crypt::encrypt($d->npp)) }}" class="status-pill-toggle {{ $d->status == 1 ? 'status-pill-active' : 'status-pill-off' }}">
                                                <i class="ti ti-point-filled" style="font-size: 0.55rem;"></i>
                                                <span>{{ $d->status == 1 ? 'AKTIF' : 'OFF' }}</span>
                                            </a>
                                        </div>
                                        <div class="border-start ps-3">
                                            <p class="mb-1 text-muted text-uppercase" style="font-size: 0.65rem; font-weight: 700; letter-spacing: 0.5px;">HUBUNGI</p>
                                            <span class="fw-semibold small text-dark d-inline-flex align-items-center gap-1.5">
                                                <i class="ti ti-device-mobile text-muted"></i>
                                                {{ $d->no_hp ?? '-' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="col-lg-2 col-md-6 text-end">
                                    <div class="d-flex justify-content-end gap-2 align-items-center">
                                        <a href="{{ route('karyawan.show', Crypt::encrypt($d->npp)) }}" class="btn btn-xs btn-outline-secondary d-none d-xl-inline-flex align-items-center gap-1 px-2.5 py-1" style="border-radius: 6px; font-weight: 500;">
                                            <span>Detail</span>
                                        </a>

                                        <div class="dropdown">
                                            <button class="action-karyawan-btn" type="button" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false" title="Menu Opsi">
                                                <i class="ti ti-dots-vertical fs-5"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end karyawan-dropdown-menu border-0" style="border-radius: 10px; font-size: 0.82rem;">
                                                <li><h6 class="dropdown-header text-muted small text-uppercase" style="font-size: 0.6rem">Pengaturan Kerja</h6></li>
                                                @can('karyawan.create')
                                                    <li><a class="dropdown-item d-flex align-items-center gap-2 btnSetJamkerja py-1.5" href="#" npp="{{ Crypt::encrypt($d->npp) }}"><i class="ti ti-clock text-primary"></i> Atur Jam Kerja</a></li>
                                                @endcan
                                                <li><a class="dropdown-item d-flex align-items-center gap-2 btnSetharikerja py-1.5" href="#" npp="{{ Crypt::encrypt($d->npp) }}"><i class="ti ti-calendar text-warning"></i> Atur Hari Kerja</a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><h6 class="dropdown-header text-muted small text-uppercase" style="font-size: 0.6rem">Data Karyawan</h6></li>
                                                @can('karyawan.edit')
                                                    <li><a class="dropdown-item d-flex align-items-center gap-2 editKaryawan py-1.5" href="#" npp="{{ Crypt::encrypt($d->npp) }}"><i class="ti ti-edit text-success"></i> Edit Profil</a></li>
                                                @endcan
                                                @can('karyawan.show')
                                                    <li><a class="dropdown-item d-flex align-items-center gap-2 py-1.5" href="{{ route('karyawan.show', Crypt::encrypt($d->npp)) }}"><i class="ti ti-file-description text-info"></i> Detail Lengkap</a></li>
                                                @endcan
                                                @if (!empty($d->id_user))
                                                    @can('karyawan.create')
                                                        <li><a class="dropdown-item d-flex align-items-center gap-2 reset-user-confirm py-1.5" href="{{ route('karyawan.resetuser', Crypt::encrypt($d->npp)) }}"><i class="ti ti-rotate text-warning"></i> Reset Password User</a></li>
                                                        <li><a class="dropdown-item d-flex align-items-center gap-2 delete-user-confirm text-danger py-1.5" href="{{ route('karyawan.deleteuser', Crypt::encrypt($d->npp)) }}"><i class="ti ti-user-x"></i> Hapus Akses User</a></li>
                                                    @endcan
                                                @else
                                                    @can('karyawan.create')
                                                        <li><a class="dropdown-item d-flex align-items-center gap-2 py-1.5" href="{{ route('karyawan.createuser', Crypt::encrypt($d->npp)) }}"><i class="ti ti-user-plus text-primary"></i> Buat User Default</a></li>
                                                    @endcan
                                                @endif
                                                @can('karyawan.delete')
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <form method="POST" class="deleteform" action="{{ route('karyawan.delete', Crypt::encrypt($d->npp)) }}">
                                                             @csrf @method('DELETE')
                                                            <a class="dropdown-item d-flex align-items-center gap-2 delete-confirm text-danger py-1.5" href="#"><i class="ti ti-trash"></i> Hapus Karyawan</a>
                                                        </form>
                                                    </li>
                                                @endcan
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center p-5 bg-white border" style="border-radius: 12px; border-color: #e2e8f0 !important;">
                    <i class="ti ti-users-off fs-1 opacity-25 d-block mb-3"></i>
                    <h5 class="text-muted">Tidak ada data karyawan ditemukan</h5>
                    <p class="text-muted small">Coba sesuaikan kata kunci pencarian Anda</p>
                </div>
            @endforelse
            
            <div class="col-12 mt-4">
                <div class="d-flex justify-content-end">
                    {{ $karyawan->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<x-modal-form id="mdlcreateKaryawan" size="" show="loadcreateKaryawan" title="Tambah Karyawan" icon="ti ti-user-plus" />
<x-modal-form id="mdleditKaryawan" size="" show="loadeditKaryawan" title="Edit Karyawan" icon="ti ti-user-edit" />
<x-modal-form id="mdlsetharikerja" size="" show="loadsetharikerja" title="Set Hari Kerja" icon="ti ti-calendar-check" />
<x-modal-form id="modalSetJamkerja" show="loadmodalSetJamkerja" size="modal-lg" title="Set Jam Kerja" icon="ti ti-clock-plus" />

@endsection

@push('myscript')
<script>
    $(function() {
        $("#btncreateKaryawan").click(function(e) {
            e.preventDefault();
            $('#mdlcreateKaryawan').modal("show");
            $("#loadcreateKaryawan").load('/karyawan/create');
        });

        $(document).on('click', '.editKaryawan', function(e) {
            var npp = $(this).attr("npp");
            e.preventDefault();
            $('#mdleditKaryawan').modal("show");
            $("#loadeditKaryawan").load('/karyawan/' + npp + '/edit');
        });

        $(document).on('click', ".btnSetharikerja", function(e) {
            var npp = $(this).attr("npp");
            e.preventDefault();
            $('#mdlsetharikerja').modal("show");
            $("#loadsetharikerja").load('/karyawan/' + npp + '/setharikerja');
        });

        $(document).on('click', ".btnSetJamkerja", function() {
            const npp = $(this).attr("npp");
            $("#modalSetJamkerja").modal("show");
            $("#loadmodalSetJamkerja").load(`/karyawan/${npp}/setjamkerja`);
        });

        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // Delete Confirm
        $(document).on('click', ".delete-confirm", function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            Swal.fire({
                title: 'Hapus data karyawan?',
                text: "Seluruh data terkait karyawan ini akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#064e3b',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

        // Reset User Confirm
        $(document).on('click', ".reset-user-confirm", function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            Swal.fire({
                title: 'Reset Password User?',
                text: "Password user akan di-reset kembali ke default (12345678)!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#064e3b',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, reset!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        });

        // Delete User Confirm
        $(document).on('click', ".delete-user-confirm", function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            Swal.fire({
                title: 'Hapus Akses User?',
                text: "Akun login karyawan ini akan dihapus permanen, tetapi data karyawan tetap ada!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        });

        // Manage card z-index during dropdown toggle to prevent clipping and flickering
        $(document).on('show.bs.dropdown', '.dropdown', function () {
            $(this).closest('.karyawan-item-card').addClass('dropdown-open');
        });
        $(document).on('hidden.bs.dropdown', '.dropdown', function () {
            $(this).closest('.karyawan-item-card').removeClass('dropdown-open');
        });
    });
</script>
@endpush

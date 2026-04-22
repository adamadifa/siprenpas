@extends('layouts.app')
@section('titlepage', 'Laporan MSDM')

@section('content')

@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-printer fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Laporan MSDM</h4>
                        <p class="text-muted mb-0 small">Cetak dan export data presensi dan checklist ibadah karyawan</p>
                    </div>
                </div>
                <div class="d-flex flex-column align-items-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mb-0">
                            <li class="breadcrumb-item">
                                <a href="javascript:void(0);" class="text-muted">
                                    <i class="ti ti-users me-1"></i> MSDM
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                <i class="ti ti-report me-1"></i> Laporan
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

<div class="row">
    <div class="col-xl-9 col-md-11 col-sm-12">
        <div class="nav-align-left card border-0 shadow-none bg-transparent">
            <!-- Minimalist Sidebar -->
            <ul class="nav nav-tabs border-0 pe-4" role="tablist" style="min-width: 240px; background: transparent;">
                @can('presensi.index')
                    <li class="nav-item w-100 mb-0" role="presentation">
                        <button type="button" class="nav-link active py-2 px-3 rounded-3 d-flex align-items-center gap-3 border-0 w-100"
                            role="tab" data-bs-toggle="tab" data-bs-target="#presensi" aria-controls="presensi"
                            aria-selected="true" style="background: transparent;">
                            <i class="ti ti-fingerprint fs-4"></i>
                            <span class="fw-medium">Presensi</span>
                        </button>
                    </li>
                @endcan
                @can('presensi.index')
                    <li class="nav-item w-100 mb-0" role="presentation">
                        <button type="button" class="nav-link py-2 px-3 rounded-3 d-flex align-items-center gap-3 border-0 w-100"
                            role="tab" data-bs-toggle="tab" data-bs-target="#checklistibadah" aria-controls="checklistibadah"
                            aria-selected="false" style="background: transparent;">
                            <i class="ti ti-clipboard-check fs-4"></i>
                            <span class="fw-medium">Checklist Ibadah</span>
                        </button>
                    </li>
                @endcan
            </ul>

            <!-- Report Card with Dark Header -->
            <div class="tab-content ms-4 p-0 border-0 shadow-sm rounded-3 overflow-hidden" style="flex-grow: 1; background: #fff;">
                @can('presensi.index')
                    <div class="tab-pane fade active show" id="presensi" role="tabpanel">
                        <div class="card-header border-0 d-flex align-items-center gap-2 py-3 px-4" style="background: #064e3b">
                            <i class="ti ti-fingerprint text-white fs-4"></i>
                            <h6 class="mb-0 fw-bold text-white">Laporan Presensi</h6>
                        </div>
                        <div class="card-body p-4">
                            @include('msdm.laporan.presensi')
                        </div>
                    </div>
                @endcan
                @can('presensi.index')
                    <div class="tab-pane fade" id="checklistibadah" role="tabpanel">
                        <div class="card-header border-0 d-flex align-items-center gap-2 py-3 px-4" style="background: #064e3b">
                            <i class="ti ti-clipboard-check text-white fs-4"></i>
                            <h6 class="mb-0 fw-bold text-white">Laporan Checklist Ibadah</h6>
                        </div>
                        <div class="card-body p-4">
                            @include('msdm.laporan.checklistibadah')
                        </div>
                    </div>
                @endcan
            </div>
        </div>
    </div>
</div>

<style>
    .nav-tabs .nav-link {
        color: #8e959d;
        transition: all 0.2s ease;
    }

    .nav-tabs .nav-link.active {
        color: #064e3b !important;
        background: rgba(6, 78, 59, 0.05) !important;
    }

    .nav-tabs .nav-link:hover:not(.active) {
        color: #064e3b;
        background: rgba(6, 78, 59, 0.02);
    }

    .nav-tabs .nav-link i {
        font-size: 1.25rem;
    }

    /* Layout Ajustments */
    .nav-align-left.card {
        flex-direction: row;
        align-items: flex-start;
    }
    
    .nav-align-left .nav-tabs {
        border-right: none !important;
    }

    .tab-content {
        min-height: 400px;
    }
</style>

@endsection


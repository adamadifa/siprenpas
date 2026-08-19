@extends('layouts.app')
@section('titlepage', 'Laporan Kegiatan')

@section('content')

@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-printer fs-3 text-success"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Laporan Kegiatan</h4>
                        <p class="text-muted mb-0 small">Cetak dan export data realisasi kegiatan karyawan</p>
                    </div>
                </div>
                <div class="d-flex flex-column align-items-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mb-0">
                            <li class="breadcrumb-item">
                                <a href="javascript:void(0);" class="text-muted">
                                    <i class="ti ti-activity me-1"></i> Kegiatan
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                <i class="ti ti-printer me-1"></i> Laporan
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
                <li class="nav-item w-100 mb-0" role="presentation">
                    <button type="button" class="nav-link active py-2 px-3 rounded-3 d-flex align-items-center gap-3 border-0 w-100"
                        role="tab" data-bs-toggle="tab" data-bs-target="#realisasi" aria-controls="realisasi"
                        aria-selected="true" style="background: transparent;">
                        <i class="ti ti-clipboard-list fs-4"></i>
                        <span class="fw-medium">Realisasi Kegiatan</span>
                    </button>
                </li>
            </ul>

            <!-- Report Card with Dark Header -->
            <div class="tab-content ms-4 p-0 border-0 shadow-sm rounded-3 overflow-hidden" style="flex-grow: 1; background: #fff;">
                <div class="tab-pane fade show active" id="realisasi" role="tabpanel">
                    <div class="card-header border-0 d-flex align-items-center gap-2 py-3 px-4" style="background: #064e3b">
                        <i class="ti ti-clipboard-list text-white fs-4"></i>
                        <h6 class="mb-0 fw-bold text-white">Laporan Realisasi Kegiatan</h6>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('kegiatan.laporan.cetak') }}" method="POST" target="_blank">
                            @csrf
                            
                            @if(!auth()->user()->hasRole('karyawan'))
                                <!-- Department Filter (Admin) -->
                                <div class="form-group mb-3">
                                    <select name="kode_dept" id="kode_dept" class="form-select select2">
                                        <option value="">Semua Departemen</option>
                                        @foreach($departemen as $dept)
                                            <option value="{{ $dept->kode_dept }}">{{ $dept->nama_dept }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Karyawan Filter (Admin) -->
                                <div class="form-group mb-3">
                                    <select name="npp" id="npp" class="form-select select2">
                                        <option value="">Semua Karyawan</option>
                                        @foreach($karyawan as $kary)
                                            <option value="{{ $kary->npp }}">{{ $kary->nama_lengkap }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <select name="bulan" id="bulan" class="form-select">
                                            <option value="">Bulan</option>
                                            @foreach ($list_bulan as $d)
                                                <option {{ date('m') == $d['kode_bulan'] ? 'selected' : '' }} value="{{ $d['kode_bulan'] }}">
                                                    {{ $d['nama_bulan'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <select name="tahun" id="tahun" class="form-select">
                                            <option value="">Tahun</option>
                                            @for ($t = $start_year; $t <= date('Y'); $t++)
                                                <option {{ date('Y') == $t ? 'selected' : '' }} value="{{ $t }}">{{ $t }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-lg-10 col-md-12 col-sm-12 mb-2">
                                    <button type="submit" class="btn btn-primary w-100 shadow-sm border-0 d-flex align-items-center justify-content-center gap-2" style="background-color: #064e3b !important;">
                                        <i class="ti ti-printer fs-5"></i>
                                        <span>Cetak Laporan</span>
                                    </button>
                                </div>
                                <div class="col-lg-2 col-md-12 col-sm-12 mb-2">
                                    <button type="submit" name="export_excel" value="true" class="btn btn-success w-100 shadow-none border-0 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-download"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
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
        min-height: auto;
    }
</style>

@endsection

@push('myscript')
<script>
    $(function() {
        $('.select2').each(function() {
            var $this = $(this);
            $this.wrap('<div class="position-relative"></div>').select2({
                dropdownParent: $this.parent(),
                allowClear: true
            });
        });
    });
</script>
@endpush

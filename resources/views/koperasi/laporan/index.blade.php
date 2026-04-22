@extends('layouts.app')
@section('titlepage', 'Laporan Koperasi')

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
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Laporan Koperasi</h4>
                        <p class="text-muted mb-0 small">Cetak dan export data simpanan, tabungan, dan pembiayaan</p>
                    </div>
                </div>
                <div class="d-flex flex-column align-items-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mb-0">
                            <li class="breadcrumb-item">
                                <a href="javascript:void(0);" class="text-muted">
                                    <i class="ti ti-building-bank me-1"></i> Koperasi
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
            <ul class="nav nav-tabs border-0 pe-4" role="tablist" style="min-width: 220px; background: transparent;">
                @can('simpanan.index')
                    <li class="nav-item w-100 mb-0" role="presentation">
                        <button type="button" class="nav-link active py-2 px-3 rounded-3 d-flex align-items-center gap-3 border-0 w-100"
                            role="tab" data-bs-toggle="tab" data-bs-target="#simpanan" aria-controls="simpanan"
                            aria-selected="true" style="background: transparent;">
                            <i class="ti ti-database fs-4"></i>
                            <span class="fw-medium">Simpanan</span>
                        </button>
                    </li>
                @endcan
                @can('tabungan.index')
                    <li class="nav-item w-100 mb-0" role="presentation">
                        <button type="button" class="nav-link py-2 px-3 rounded-3 d-flex align-items-center gap-3 border-0 w-100"
                            role="tab" data-bs-toggle="tab" data-bs-target="#tabungan" aria-controls="tabungan"
                            aria-selected="false" style="background: transparent;">
                            <i class="ti ti-wallet fs-4"></i>
                            <span class="fw-medium">Tabungan</span>
                        </button>
                    </li>
                @endcan
                @can('pembiayaan.index')
                    <li class="nav-item w-100 mb-0" role="presentation">
                        <button type="button" class="nav-link py-2 px-3 rounded-3 d-flex align-items-center gap-3 border-0 w-100"
                            role="tab" data-bs-toggle="tab" data-bs-target="#pembiayaan" aria-controls="pembiayaan"
                            aria-selected="false" style="background: transparent;">
                            <i class="ti ti-credit-card fs-4"></i>
                            <span class="fw-medium">Pembiayaan</span>
                        </button>
                    </li>
                @endcan
            </ul>

            <!-- Report Card with Dark Header -->
            <div class="tab-content ms-4 p-0 border-0 shadow-sm rounded-3 overflow-hidden" style="flex-grow: 1; background: #fff;">
                @can('simpanan.index')
                    <div class="tab-pane fade active show" id="simpanan" role="tabpanel">
                        <div class="card-header border-0 d-flex align-items-center gap-2 py-3 px-4" style="background: #064e3b">
                            <i class="ti ti-database text-white fs-4"></i>
                            <h6 class="mb-0 fw-bold text-white">Laporan Simpanan</h6>
                        </div>
                        <div class="card-body p-4">
                            @include('koperasi.laporan.simpanan')
                        </div>
                    </div>
                @endcan
                @can('tabungan.index')
                    <div class="tab-pane fade" id="tabungan" role="tabpanel">
                        <div class="card-header border-0 d-flex align-items-center gap-2 py-3 px-4" style="background: #064e3b">
                            <i class="ti ti-wallet text-white fs-4"></i>
                            <h6 class="mb-0 fw-bold text-white">Laporan Tabungan</h6>
                        </div>
                        <div class="card-body p-4">
                            @include('koperasi.laporan.tabungan')
                        </div>
                    </div>
                @endcan
                @can('pembiayaan.index')
                    <div class="tab-pane fade" id="pembiayaan" role="tabpanel">
                        <div class="card-header border-0 d-flex align-items-center gap-2 py-3 px-4" style="background: #064e3b">
                            <i class="ti ti-credit-card text-white fs-4"></i>
                            <h6 class="mb-0 fw-bold text-white">Laporan Pembiayaan</h6>
                        </div>
                        <div class="card-body p-4">
                            @include('koperasi.laporan.pembiayaan')
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
    }

    .nav-tabs .nav-link:hover:not(.active) {
        color: #064e3b;
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
</style>

@endsection

@push('myscript')
<script>
    $(function() {
        const formLaporanSimpanan = $("#formLaporanSimpanan");
        const formLaporanTabungan = $("#formLaporanTabungan");
        const formLaporanPembiayaan = $("#formLaporanPembiayaan");

        // Initialization
        const select2Options = (placeholder) => ({
            placeholder: placeholder,
            allowClear: true,
            dropdownParent: null // will be set in each init
        });

        const initSelect2 = (selector, placeholder) => {
            const $el = $(selector);
            if ($el.length) {
                $el.each(function() {
                    const $this = $(this);
                    $this.wrap('<div class="position-relative"></div>').select2({
                        placeholder: placeholder,
                        allowClear: true,
                        dropdownParent: $this.parent()
                    });
                });
            }
        };

        initSelect2(".select2Noanggotasimpanan", "Semua Anggota");
        initSelect2(".select2Kodejenissimpanan", "Semua Jenis Simpanan");
        initSelect2(".select2Kodejenistabungan", "Semua Jenis Tabungan");

        const validateDateRange = (form) => {
            const dari = form.find('input[name="dari"]').val();
            const sampai = form.find('input[name="sampai"]').val();
            const start = new Date(dari);
            const end = new Date(sampai);

            if (dari == "") {
                Swal.fire({
                    title: "Oops!",
                    text: "Dari Tanggal Harus Diisi !",
                    icon: "warning",
                    showConfirmButton: true,
                    didClose: () => {
                        form.find('input[name="dari"]').focus();
                    },
                });
                return false;
            } else if (sampai == "") {
                Swal.fire({
                    title: "Oops!",
                    text: "Sampai Tanggal Harus Diisi !",
                    icon: "warning",
                    showConfirmButton: true,
                    didClose: () => {
                        form.find('input[name="sampai"]').focus();
                    },
                });
                return false;
            } else if (start.getTime() > end.getTime()) {
                Swal.fire({
                    title: "Oops!",
                    text: "Periode Tidak Valid !, Periode Sampai Harus Lebih Akhir dari Periode Dari",
                    icon: "warning",
                    showConfirmButton: true,
                    didClose: () => {
                        form.find('input[name="sampai"]').focus();
                    },
                });
                return false;
            }
            return true;
        };

        formLaporanSimpanan.submit(function(e) {
            if (!validateDateRange($(this))) {
                e.preventDefault();
                return false;
            }
        });

        formLaporanTabungan.submit(function(e) {
            if (!validateDateRange($(this))) {
                e.preventDefault();
                return false;
            }
        });

        formLaporanPembiayaan.submit(function(e) {
            if (!validateDateRange($(this))) {
                e.preventDefault();
                return false;
            }
        });
    });
</script>
@endpush


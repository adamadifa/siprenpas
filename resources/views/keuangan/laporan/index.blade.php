@extends('layouts.app')
@section('titlepage', 'Laporan Keuangan')

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
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Laporan Keuangan</h4>
                        <p class="text-muted mb-0 small">Cetak dan export data tagihan serta pembayaran pendidikan</p>
                    </div>
                </div>
                <div class="d-flex flex-column align-items-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mb-0">
                            <li class="breadcrumb-item">
                                <a href="javascript:void(0);" class="text-muted">
                                    <i class="ti ti-wallet me-1"></i> Keuangan
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
                @can('lk.rekaptagihan')
                    <li class="nav-item w-100 mb-0" role="presentation">
                        <button type="button" class="nav-link active py-2 px-3 rounded-3 d-flex align-items-center gap-3 border-0 w-100"
                            role="tab" data-bs-toggle="tab" data-bs-target="#rekaptagihan" aria-controls="rekaptagihan"
                            aria-selected="true" style="background: transparent;">
                            <i class="ti ti-file-invoice fs-4"></i>
                            <span class="fw-medium">Rekap Tagihan</span>
                        </button>
                    </li>
                @endcan
                @can('lk.pembayaran')
                    <li class="nav-item w-100 mb-0" role="presentation">
                        <button type="button" class="nav-link py-2 px-3 rounded-3 d-flex align-items-center gap-3 border-0 w-100"
                            role="tab" data-bs-toggle="tab" data-bs-target="#pembayaran" aria-controls="pembayaran"
                            aria-selected="false" style="background: transparent;">
                            <i class="ti ti-cash fs-4"></i>
                            <span class="fw-medium">Pembayaran</span>
                        </button>
                    </li>
                @endcan
            </ul>

            <!-- Report Card with Dark Header -->
            <div class="tab-content ms-4 p-0 border-0 shadow-sm rounded-3 overflow-hidden" style="flex-grow: 1; background: #fff;">
                @can('lk.rekaptagihan')
                    <div class="tab-pane fade active show" id="rekaptagihan" role="tabpanel">
                        <div class="card-header border-0 d-flex align-items-center gap-2 py-3 px-4" style="background: #064e3b">
                            <i class="ti ti-file-invoice text-white fs-4"></i>
                            <h6 class="mb-0 fw-bold text-white">Laporan Rekap Tagihan</h6>
                        </div>
                        <div class="card-body p-4">
                            @include('keuangan.laporan.rekaptagihan')
                        </div>
                    </div>
                @endcan
                @can('lk.pembayaran')
                    <div class="tab-pane fade" id="pembayaran" role="tabpanel">
                        <div class="card-header border-0 d-flex align-items-center gap-2 py-3 px-4" style="background: #064e3b">
                            <i class="ti ti-cash text-white fs-4"></i>
                            <h6 class="mb-0 fw-bold text-white">Laporan Pembayaran</h6>
                        </div>
                        <div class="card-body p-4">
                            @include('keuangan.laporan.pembayaran')
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
        const formRekapTagihan = $('#formRekapTagihan');
        const formPembayaran = $('#formPembayaran');

        // Initialize Select2 Helper
        const initSelect2 = (selector, placeholder) => {
            const $el = $(selector);
            if ($el.length) {
                $el.each(function() {
                    const $this = $(this);
                    $this.wrap('<div class="position-relative"></div>').select2({
                        placeholder: placeholder,
                        allowClear: true,
                        dropdownParent: $this.parent(),
                        width: '100%'
                    });
                });
            }
        };

        initSelect2(".select2Kodeunit", "Pilih Unit");
        initSelect2(".select2Tingkat", "Pilih Tingkat");
        initSelect2(".select2Kota", "Pilih Tahun Ajaran");
        $("#formRekapTagihan, #formPembayaran").find("#kode_unit").on('change', function() {
            const form = $(this).closest('form');
            getTingkatByUnit($(this).val(), '', form);
        });

        const validateForm = (form) => {
            const unit = form.find("#kode_unit").val();
            const tingkat = form.find("#tingkat").val();
            
            if (unit == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Unit tidak boleh kosong!',
                    didClose: () => form.find("#kode_unit").focus()
                });
                return false;
            }
            
            if (tingkat == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Tingkat tidak boleh kosong!',
                    didClose: () => form.find("#tingkat").focus()
                });
                return false;
            }
            
            return true;
        };

        formRekapTagihan.submit(function(e) {
            const kode_ta = $(this).find("#kode_ta_search").val();
            if (!validateForm($(this))) {
                e.preventDefault();
                return false;
            }
            if (kode_ta == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Tahun Ajaran tidak boleh kosong!',
                    didClose: () => $(this).find("#kode_ta_search").focus()
                });
                e.preventDefault();
                return false;
            }
        });

        formPembayaran.submit(function(e) {
            if (!validateForm($(this))) {
                e.preventDefault();
                return false;
            }
        });

        function getTingkatByUnit(kode_unit, selected = '', form) {
            $.ajax({
                type: "POST",
                url: "{{ route('unit.gettingkatbyunit') }}",
                cache: false,
                data: {
                    _token: "{{ csrf_token() }}",
                    kode_unit: kode_unit,
                    selected: selected
                },
                success: function(respond) {
                    form.find("#tingkat").html(respond);
                    // Re-initialize Select2 using the robust helper
                    initSelect2(form.find("#tingkat"), "Pilih Tingkat");
                }
            });
        }
    });
</script>
@endpush

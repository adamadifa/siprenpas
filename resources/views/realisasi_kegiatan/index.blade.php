@extends('layouts.app')
@section('titlepage', 'Realisasi Kegiatan')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-activity fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Realisasi Kegiatan</h4>
                        <p class="text-muted mb-0 small">Monitoring dan pencatatan realisasi kegiatan pesantren</p>
                    </div>
                </div>
                <div class="d-flex flex-column align-items-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mb-0">
                            <li class="breadcrumb-item">
                                <a href="javascript:void(0);" class="text-muted">
                                    <i class="ti ti-home-2 me-1"></i> Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                <i class="ti ti-activity me-1"></i> Realisasi Kegiatan
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

<div class="row">
    <div class="col-lg-12">
        <!-- Actions Section -->
        <div class="d-flex justify-content-start mb-3">
            @can('realkegiatan.create')
                <button class="btn d-flex align-items-center gap-2 shadow-sm text-white" id="btncreateRealisasiKegiatan"
                    style="background-color: #064e3b">
                    <i class="ti ti-plus fs-4"></i>
                    <span>Tambah Realisasi Kegiatan</span>
                </button>
            @endcan
        </div>

        <!-- Filter Section -->
        @php
            $isPrivileged = $user->hasRole(['super admin', 'pimpinan pesantren', 'sekretaris']);
        @endphp
        <div class="card mb-4 shadow-none border-0 bg-transparent">
            <div class="card-body p-0">
                <form action="{{ route('realisasikegiatan.index') }}" class="form-filter" id="myForm">
                    <div class="row g-3 align-items-center">
                        <div class="col-lg col-md-6 col-12">
                            <x-input-with-icon label="" placeholder="Dari Tanggal" name="dari" id="dari" value="{{ Request('dari') }}" datepicker="flatpickr-date" icon="ti ti-calendar" />
                        </div>
                        <div class="col-lg col-md-6 col-12">
                            <x-input-with-icon label="" placeholder="Sampai Tanggal" name="sampai" id="sampai" value="{{ Request('sampai') }}" datepicker="flatpickr-date" icon="ti ti-calendar" />
                        </div>
                        @if ($isPrivileged)
                            <div class="col-lg col-md-6 col-12">
                                <div class="form-group mb-3">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="ti ti-briefcase text-muted"></i></span>
                                        <select name="kode_jabatan" id="kode_jabatan" class="form-select">
                                            <option value="">Semua Jabatan</option>
                                            @foreach ($jabatan as $d)
                                                <option value="{{ $d->kode_jabatan }}"
                                                    {{ Request('kode_jabatan') == $d->kode_jabatan ? 'selected' : '' }}>
                                                    {{ strtoUpper($d->nama_jabatan) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg col-md-6 col-12">
                                <div class="form-group mb-3">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="ti ti-building text-muted"></i></span>
                                        <select name="kode_dept" id="kode_dept" class="form-select">
                                            <option value="">Semua Departemen</option>
                                            @foreach ($departemen as $d)
                                                <option value="{{ $d->kode_dept }}" {{ Request('kode_dept') == $d->kode_dept ? 'selected' : '' }}>
                                                    {{ strtoUpper($d->nama_dept) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="col-auto">
                            <div class="form-group mb-3">
                                <button type="submit" class="btn btn-primary d-flex align-items-center justify-content-center gap-2"
                                    style="background-color: #064e3b; border-color: #064e3b; height: 38px; padding-left: 20px; padding-right: 20px;">
                                    <i class="ti ti-search fs-5"></i>
                                    <span>Cari</span>
                                </button>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="form-group mb-3">
                                <div class="d-flex gap-2" style="height: 38px;">
                                    <button type="submit" name="cetak" value="1" id="cetakButton" class="btn btn-warning shadow-sm border-0 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                                        <i class="ti ti-printer fs-5"></i>
                                    </button>
                                    <button type="submit" name="cetak_pdf" value="1" id="cetakPdfButton" class="btn btn-danger shadow-sm border-0 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                                        <i class="ti ti-file-type-pdf fs-5"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <style>
            @media (min-width: 768px) {
                .border-end-md {
                    border-right: 1px solid #eef2f6 !important;
                }
            }
            .text-truncate-2 {
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }
            .card-realisasi {
                transition: all 0.2s ease-in-out;
            }
            .card-realisasi:hover {
                transform: translateY(-2px);
                box-shadow: 0 .5rem 1rem rgba(0,0,0,.08) !important;
            }
        </style>

        <div class="d-flex flex-column gap-3 mb-4">
            @forelse ($realisasikegiatan as $d)
                <div class="card border-0 border-start border-success border-4 shadow-sm card-realisasi">
                    <div class="card-body p-3">
                        <div class="row align-items-center g-3">
                            <!-- Left Column: Date & User -->
                            <div class="col-12 col-md-2 border-end-md">
                                <div class="d-flex flex-column">
                                    <span class="text-muted small fw-medium mb-1"><i class="ti ti-calendar me-1 text-success"></i>Tanggal</span>
                                    <span class="fw-bold text-dark mb-2">{{ date('d-m-Y', strtotime($d->tanggal)) }}</span>
                                    <span class="text-muted small fw-medium mb-1"><i class="ti ti-user me-1 text-success"></i>Oleh</span>
                                    <span class="text-dark small text-truncate" title="{{ $d->name }}">{{ $d->name }}</span>
                                </div>
                            </div>
                            
                            <!-- Middle-Left Column: Kegiatan & Uraian -->
                            <div class="col-12 col-md-4 border-end-md">
                                <div class="pe-md-3">
                                    <span class="badge bg-label-success mb-2">Kegiatan</span>
                                    <h6 class="fw-bold text-dark mb-1">{{ removeHtmltag($d->nama_kegiatan) }}</h6>
                                    <p class="text-muted small mb-0 text-truncate-2">
                                        {{ removeHtmltag($d->uraian_kegiatan) }}
                                    </p>
                                </div>
                            </div>

                            <!-- Middle-Right Column: Jobdesk & Progker -->
                            <div class="col-12 col-md-3 border-end-md">
                                <div class="pe-md-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="ti ti-briefcase me-2 text-muted"></i>
                                        <div>
                                            <span class="text-muted small d-block">Jobdesk</span>
                                            <span class="small fw-semibold text-dark">{{ removeHtmltag($d->jobdesk) }}</span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="ti ti-notebook me-2 text-primary"></i>
                                        <div>
                                            <span class="text-muted small d-block">Program Kerja</span>
                                            <span class="small fw-semibold text-primary">{{ $d->program_kerja }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column: Dept & Action -->
                            <div class="col-12 col-md-3">
                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                    <div>
                                        <span class="text-muted small d-block mb-1">Departemen</span>
                                        <span class="badge bg-success bg-opacity-10 text-success px-2 py-1">{{ $d->kode_dept }}</span>
                                    </div>
                                    
                                    <div class="d-flex gap-1 align-items-center">
                                        @can('realkegiatan.edit')
                                            <a href="#" class="btn btn-icon btn-label-success border btnEdit"
                                                style="width: 32px; height: 32px;"
                                                id="{{ Crypt::encrypt($d->id) }}"
                                                data-bs-toggle="tooltip" title="Edit">
                                                <i class="ti ti-edit fs-5"></i>
                                            </a>
                                        @endcan
                                        @can('realkegiatan.delete')
                                            <form method="POST" name="deleteform" class="deleteform m-0"
                                                action="{{ route('realisasikegiatan.delete', Crypt::encrypt($d->id)) }}">
                                                @csrf
                                                @method('DELETE')
                                                <a href="#" class="btn btn-icon btn-label-danger border delete-confirm"
                                                    style="width: 32px; height: 32px;"
                                                    data-bs-toggle="tooltip" title="Hapus">
                                                    <i class="ti ti-trash fs-5"></i>
                                                </a>
                                            </form>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center p-5">
                        <div class="mb-3">
                            <i class="ti ti-activity fs-1 text-muted opacity-50"></i>
                        </div>
                        <h5 class="fw-bold">Belum Ada Realisasi Kegiatan</h5>
                        <p class="text-muted mb-0">Silahkan tambah realisasi baru atau sesuaikan filter pencarian.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-body p-3">
                {{ $realisasikegiatan->links() }}
            </div>
        </div>
    </div>
</div>

<x-modal-form id="mdlRealisasiKegiatan" size="" show="loadRealisasiKegiatan" title="" />
@endsection
@push('myscript')
<script>
    $('#cetakButton').click(function(e) {
        e.preventDefault();
        // Ambil data form menggunakan jQuery
        const formData = $('#myForm').serialize();
        const url = "{{ URL::current() }}";
        // URL tujuan untuk cetak menggunakan jQuery
        const printUrl = url + '?' + formData + '&cetak=1';

        const kode_dept = $('#kode_dept').val();
        const dari = $('#dari').val();
        const sampai = $('#sampai').val();

        if (kode_dept == '') {
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Departemen tidak boleh kosong!',
                didClose: (e) => {
                    $('#kode_dept').focus();
                }
            });
            return false;
        } else if (dari == '' || sampai == '') {
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Tanggal tidak boleh kosong!',
                didClose: (e) => {
                    $('#dari').focus();
                }
            });
            return false;
        } else {
            window.open(printUrl, '_blank');
        }
        // Buka tab baru untuk cetak menggunakan jQuery
    });
</script>
{{-- <script src="{{ asset('assets/js/pages/roles/create.js') }}"></script> --}}
<script>
    $(function() {
        $("#btncreateRealisasiKegiatan").click(function(e) {
            e.preventDefault();
            $('#mdlRealisasiKegiatan').modal("show");
            $("#mdlRealisasiKegiatan").find(".modal-title").text("Tambah Realisasi Kegiatan");
            $("#loadRealisasiKegiatan").load('/realisasikegiatan/create');
        });

        $(".btnEdit").click(function(e) {
            var id = $(this).attr("id");
            e.preventDefault();
            $('#mdlRealisasiKegiatan').modal("show");
            $("#mdlRealisasiKegiatan").find(".modal-title").text("Edit Realisasi Kegiatan");
            $("#loadRealisasiKegiatan").load('/realisasikegiatan/' + id + '/edit');
        });
    });
</script>
@endpush

@extends('layouts.app')
@section('titlepage', 'Departemen')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-building-community fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Data Departemen</h4>
                        <p class="text-muted mb-0 small">Manajemen master data departemen organisasi</p>
                    </div>
                </div>
                <div class="d-flex flex-column align-items-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mb-0">
                            <li class="breadcrumb-item">
                                <a href="javascript:void(0);" class="text-muted">
                                    <i class="ti ti-database me-1"></i> Data Master
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                <i class="ti ti-building-community me-1"></i> Departemen
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

<div class="row">
    <div class="col-lg-6 col-md-12">
        <!-- Actions Section -->
        <div class="d-flex justify-content-start mb-3">
            @can('departemen.create')
                <button class="btn d-flex align-items-center gap-2 shadow-sm text-white" id="btncreateDepartemen"
                    style="background-color: #064e3b">
                    <i class="ti ti-plus fs-4"></i>
                    <span>Tambah Departemen</span>
                </button>
            @endcan
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form action="{{ route('departemen.index') }}">
                    <div class="row align-items-end g-3">
                        <div class="col-lg-10 col-md-9">
                            <x-input-with-icon label="Cari Nama Departemen" value="{{ Request('nama_dept') }}" name="nama_dept"
                                icon="ti ti-search" />
                        </div>
                        <div class="col-lg-2 col-md-3">
                            <button class="btn btn-primary w-100 p-2 d-flex align-items-center justify-content-center gap-2" style="background-color: #064e3b; border-color: #064e3b">
                                <i class="ti ti-search fs-5"></i>
                                <span>Cari</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header d-flex align-items-center gap-2 text-white py-3" style="background-color: #064e3b">
                <i class="ti ti-layout-grid fs-5"></i>
                <h6 class="card-title mb-0 text-white">Data Departemen</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background-color: #064e3b">
                            <tr>
                                <th class="text-white py-3">KODE</th>
                                <th class="text-white py-3">NAMA DEPARTEMEN</th>
                                <th class="text-white py-3 text-end" style="width: 100px;">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($departemen as $d)
                                <tr>
                                    <td class="py-1"><span class="fw-bold">{{ $d->kode_dept }}</span></td>
                                    <td class="py-1 text-uppercase">{{ $d->nama_dept }}</td>
                                    <td class="py-1 text-end">
                                        <div class="d-flex justify-content-end gap-1">
                                            @can('departemen.edit')
                                                <a href="#" class="btn btn-icon btn-label-success border editDepartemen"
                                                    style="width: 28px; height: 28px;"
                                                    kode_departemen="{{ Crypt::encrypt($d->kode_dept) }}">
                                                    <i class="ti ti-edit fs-6"></i>
                                                </a>
                                            @endcan
                                            @can('departemen.delete')
                                                <form method="POST" name="deleteform" class="deleteform"
                                                    action="{{ route('departemen.delete', Crypt::encrypt($d->kode_dept)) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="#" class="btn btn-icon btn-label-danger border delete-confirm"
                                                        style="width: 28px; height: 28px;">
                                                        <i class="ti ti-trash fs-6"></i>
                                                    </a>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center p-5">
                                        <div class="mb-3">
                                            <i class="ti ti-building-community fs-1 opacity-25"></i>
                                        </div>
                                        <h5>Belum Ada Data Departemen</h5>
                                        <p class="text-muted">Silahkan tambah data baru.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<x-modal-form id="mdlcreateDepartemen" size="" show="loadcreateDepartemen" title="Tambah Departemen" icon="ti ti-building-community" />
<x-modal-form id="mdleditDepartemen" size="" show="loadeditDepartemen" title="Edit Departemen" icon="ti ti-edit" />
@endsection

@push('myscript')
<script>
    $(function() {
        $("#btncreateDepartemen").click(function(e) {
            e.preventDefault();
            $('#mdlcreateDepartemen').modal("show");
            $("#loadcreateDepartemen").load("{{ route('departemen.create') }}");
        });

        $(".editDepartemen").click(function(e) {
            var kode_departemen = $(this).attr("kode_departemen");
            e.preventDefault();
            $('#mdleditDepartemen').modal("show");
            $("#loadeditDepartemen").load('/departemen/' + kode_departemen + '/edit');
        });
    });
</script>
@endpush

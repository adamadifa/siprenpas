@extends('layouts.app')
@section('titlepage', 'Jabatan')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-4">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-primary rounded-circle">
                        <i class="ti ti-briefcase fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold text-primary">Data Jabatan</h4>
                        <p class="text-muted mb-0 small">Manajemen struktur jabatan dan peran karyawan</p>
                    </div>
                </div>
                <div class="d-flex flex-column align-items-end gap-2">
                    @can('jabatan.create')
                        <button class="btn btn-primary d-flex align-items-center gap-2 shadow-sm" id="btncreateJabatan">
                            <i class="ti ti-plus fs-4"></i>
                            <span>Tambah Jabatan</span>
                        </button>
                    @endcan
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mb-0">
                            <li class="breadcrumb-item">
                                <a href="javascript:void(0);" class="text-muted">Data Master</a>
                            </li>
                            <li class="breadcrumb-item active">Jabatan</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <form action="{{ route('jabatan.index') }}">
                            <div class="row">
                                <div class="col-lg-10 col-sm-12 col-md-12">
                                    <x-input-with-icon label="Nama Jabatan" value="{{ Request('nama_jabatan') }}"
                                        name="nama_jabatan" icon="ti ti-search" />
                                </div>
                                <div class="col-lg-2 col-sm-12 col-md-12">
                                    <button class="btn btn-primary">Cari</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive mb-2">
                            <table class="table table-striped table-hover table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No.</th>
                                        <th>Kode Jabatan</th>
                                        <th>Nama Jabatan</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jabatan as $d)
                                        <tr>
                                            <td class="text-center">
                                                {{ $loop->iteration }}
                                            </td>
                                            <td>{{ $d->kode_jabatan }}</td>
                                            <td>{{ $d->nama_jabatan }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    @can('jabatan.edit')
                                                        <div>
                                                            <a href="#" class="me-2 editJabatan"
                                                                kode_jabatan="{{ Crypt::encrypt($d->kode_jabatan) }}">
                                                                <i class="ti ti-edit text-success"></i>
                                                            </a>
                                                        </div>
                                                    @endcan

                                                    @can('jabatan.delete')
                                                        <div>
                                                            <form method="POST" name="deleteform" class="deleteform"
                                                                action="{{ route('jabatan.delete', Crypt::encrypt($d->kode_jabatan)) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <a href="#" class="delete-confirm ml-1">
                                                                    <i class="ti ti-trash text-danger"></i>
                                                                </a>
                                                            </form>
                                                        </div>
                                                    @endcan


                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<x-modal-form id="mdlcreateJabatan" size="" show="loadcreateJabatan" title="Tambah Jabatan" />
<x-modal-form id="mdleditJabatan" size="" show="loadeditJabatan" title="Edit Jabatan" />
@endsection
@push('myscript')
{{-- <script src="{{ asset('assets/js/pages/roles/create.js') }}"></script> --}}
<script>
    $(function() {
        $("#btncreateJabatan").click(function(e) {
            e.preventDefault();
            $('#mdlcreateJabatan').modal("show");
            $("#loadcreateJabatan").load('/jabatan/create');
        });

        $(".editJabatan").click(function(e) {
            var kode_jabatan = $(this).attr("kode_jabatan");
            e.preventDefault();
            $('#mdleditJabatan').modal("show");
            $("#loadeditJabatan").load('/jabatan/' + kode_jabatan + '/edit');
        });
    });
</script>
@endpush

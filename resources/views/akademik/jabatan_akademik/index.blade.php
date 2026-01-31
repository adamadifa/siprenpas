@extends('layouts.app')
@section('titlepage', 'Jabatan Akademik')

@section('content')
@section('navigasi')
    <span>Jabatan Akademik</span>
@endsection
<div class="row">
    <div class="col-lg-8 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                @can('jabatanakademik.store')
                    <a href="#" class="btn btn-primary" id="btnCreateJabatan"><i class="fa fa-plus me-2"></i> Tambah Jabatan</a>
                @endcan
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                         @if (Session::get('success'))
                            <div class="alert alert-success">
                                {{ Session::get('success') }}
                            </div>
                        @endif
                        @if (Session::get('warning'))
                            <div class="alert alert-warning">
                                {{ Session::get('warning') }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive mb-2">
                            <table class="table table-striped table-hover table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No.</th>
                                        <th>Kode</th>
                                        <th>Nama Jabatan</th>
                                        <th>Urutan</th>
                                        <th>Tampil di Raport</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jabatan_akademik as $d)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $d->kode_jabatan }}</td>
                                            <td>{{ $d->nama_jabatan }}</td>
                                            <td>{{ $d->urutan }}</td>
                                            <td class="text-center">
                                                @if ($d->tampil_di_raport == 1)
                                                    <i class="ti ti-check text-success"></i>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    @can('jabatanakademik.edit')
                                                        <div>
                                                            <a href="#" class="me-2 editJabatan"
                                                                id="{{ Crypt::encrypt($d->kode_jabatan) }}">
                                                                <i class="ti ti-edit text-success"></i>
                                                            </a>
                                                        </div>
                                                    @endcan
                                                    @can('jabatanakademik.delete')
                                                        <div>
                                                            <form method="POST" name="deleteform" class="deleteform me-1"
                                                                action="{{ route('jabatan-akademik.delete', Crypt::encrypt($d->kode_jabatan)) }}">
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
<x-modal-form id="mdlCreateJabatan" size="" show="loadCreateJabatan" title="Tambah Jabatan Akademik" />
<x-modal-form id="mdlEditJabatan" size="" show="loadEditJabatan" title="Edit Jabatan Akademik" />

@endsection

@push('myscript')
<script>
    $(function() {
        $("#btnCreateJabatan").click(function(e) {
            e.preventDefault();
            $('#mdlCreateJabatan').modal("show");
            $("#loadCreateJabatan").html(`
                <form action="{{ route('jabatan-akademik.store') }}" method="POST" id="formcreateJabatan">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <x-input-with-icon label="Kode Jabatan" value="" name="kode_jabatan" icon="ti ti-barcode" />
                            <x-input-with-icon label="Nama Jabatan" value="" name="nama_jabatan" icon="ti ti-id" />
                            <x-input-with-icon label="Urutan" value="" name="urutan" icon="ti ti-list-numbers" />
                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" value="1" id="tampil_di_raport" name="tampil_di_raport">
                                <label class="form-check-label" for="tampil_di_raport">
                                    Tampil di Raport (Tanda Tangan)
                                </label>
                            </div>
                            <div class="form-group mb-3 mt-3">
                                <button class="btn btn-primary w-100"><i class="ti ti-send me-1"></i> Simpan Data</button>
                            </div>
                        </div>
                    </div>
                </form>
            `);
        });

        $(".editJabatan").click(function(e) {
            var id = $(this).attr("id");
            e.preventDefault();
            $('#mdlEditJabatan').modal("show");
            $("#loadEditJabatan").load('/jabatan-akademik/' + id + '/edit');
        });
    });
</script>
@endpush

@extends('layouts.app')
@section('titlepage', 'Kategori')

@section('content')
@section('navigasi')
    <span>Kategori</span>
@endsection
<div class="row">
    <div class="col-lg-6 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                @can('kategori.create')
                    <a href="#" class="btn btn-primary" id="btncreate"><i class="fa fa-plus me-2"></i> Tambah
                        Kategori</a>
                @endcan
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <form action="{{ route('kategori.index') }}">
                            <div class="row">
                                <div class="col-lg-10 col-sm-12 col-md-12">
                                    <x-input-with-icon label="Nama Kategori" value="{{ Request('nama_kategori') }}" name="nama_kategori"
                                        icon="ti ti-search" />
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
                                        <th>Kategori</th>
                                        <th>Slug</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kategori as $d)
                                        <tr>
                                            <td class="text-center">
                                                {{ $loop->iteration }}
                                            </td>
                                            <td>{{ $d->name }}</td>
                                            <td>{{ $d->slug }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    @can('kategori.edit')
                                                        <div>
                                                            <a href="#" class="me-2 edit" id="{{ Crypt::encrypt($d->id) }}">
                                                                <i class="ti ti-edit text-success"></i>
                                                            </a>
                                                        </div>
                                                    @endcan

                                                    @can('kategori.delete')
                                                        <div>
                                                            <form method="POST" name="deleteform" class="deleteform"
                                                                action="{{ route('kategori.delete', Crypt::encrypt($d->id)) }}">
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
<x-modal-form id="mdlcreate" size="" show="loadcreate" title="Tambah Kategori" />
<x-modal-form id="mdledit" size="" show="loadedit" title="Edit Kategori" />
@endsection
@push('myscript')
{{-- <script src="{{ asset('assets/js/pages/roles/create.js') }}"></script> --}}
<script>
    $(function() {
        $("#btncreate").click(function(e) {
            e.preventDefault();
            $('#mdlcreate').modal("show");
            $("#loadcreate").load('/kategori/create');
        });

        $(".edit").click(function(e) {
            var id = $(this).attr("id");
            e.preventDefault();
            $('#mdledit').modal("show");
            $("#loadedit").load('/kategori/' + id + '/edit');
        });
    });
</script>
@endpush

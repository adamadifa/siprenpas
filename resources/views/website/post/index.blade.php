@extends('layouts.app')
@section('titlepage', 'Post')

@section('content')
@section('navigasi')
    <span>Post</span>
@endsection
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                @can('post.create')
                    <a href="#" class="btn btn-primary" id="btncreate"><i class="fa fa-plus me-2"></i> Tambah
                        Post</a>
                @endcan
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <form action="{{ route('post.index') }}">
                            <div class="row">
                                <div class="col-lg-10 col-sm-12 col-md-12">
                                    <x-input-with-icon label="Nama Post" value="{{ Request('nama_post') }}" name="nama_post" icon="ti ti-search" />
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
                                        <th>Judul</th>
                                        <th>Kategori</th>
                                        <th>Image</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($posts as $d)
                                        <tr>
                                            <td class="text-center">
                                                {{ $loop->iteration }}
                                            </td>
                                            <td>{{ $d->title }}</td>
                                            <td>{{ $d->category->name }}</td>
                                            <th>
                                                <img src="{{ $d->image }}" alt="" class="img-thumbnail img-thumbnail-shadow"
                                                    style="width: 100px">
                                            </th>
                                            <td>
                                                <div class="d-flex">
                                                    @can('post.edit')
                                                        <div>
                                                            <a href="#" class="me-2 edit" id="{{ Crypt::encrypt($d->id) }}">
                                                                <i class="ti ti-edit text-success"></i>
                                                            </a>
                                                        </div>
                                                    @endcan

                                                    @can('post.delete')
                                                        <div>
                                                            <form method="POST" name="deleteform" class="deleteform"
                                                                action="{{ route('post.delete', Crypt::encrypt($d->id)) }}">
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
<x-modal-form id="mdlcreate" size="" show="loadcreate" title="Tambah Post" />
<x-modal-form id="mdledit" size="" show="loadedit" title="Edit Post" />
@endsection
@push('myscript')
{{-- <script src="{{ asset('assets/js/pages/roles/create.js') }}"></script> --}}
<script>
    $(function() {
        $("#btncreate").click(function(e) {
            e.preventDefault();
            $('#mdlcreate').modal("show");
            $("#loadcreate").load('/post/create');
        });

        $(".edit").click(function(e) {
            var id = $(this).attr("id");
            e.preventDefault();
            $('#mdledit').modal("show");
            $("#loadedit").load('/post/' + id + '/edit');
        });
    });
</script>
@endpush

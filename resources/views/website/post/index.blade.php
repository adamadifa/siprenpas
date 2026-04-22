@extends('layouts.app')
@section('titlepage', 'Post')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-news fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Post</h4>
                        <p class="text-muted mb-0 small">Manajemen artikel dan berita website</p>
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
                                <i class="ti ti-news me-1"></i> Post
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
            @can('post.create')
                <button class="btn d-flex align-items-center gap-2 shadow-sm text-white" id="btncreate"
                    style="background-color: #064e3b">
                    <i class="ti ti-plus fs-4"></i>
                    <span>Tambah Post</span>
                </button>
            @endcan
        </div>

        <!-- Filter Form -->
        <!-- Filter Section -->
        <style>
            .form-filter .form-group {
                margin-bottom: 0 !important;
            }
        </style>
        <div class="card mb-4 shadow-none border-0 bg-transparent">
            <div class="card-body p-0">
                <form action="{{ route('post.index') }}" class="form-filter">
                    <div class="row g-3 align-items-center">
                        <div class="col-lg-11 col-md-10">
                            <x-input-with-icon label="" value="{{ Request('title') }}" name="title"
                                placeholder="Cari Judul Artikel" icon="ti ti-search" />
                        </div>
                        <div class="col-lg-1 col-md-2">
                            <button type="submit" class="btn btn-primary w-100 p-2 d-flex align-items-center justify-content-center"
                                style="background-color: #064e3b; border-color: #064e3b">
                                <i class="ti ti-search fs-5"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header d-flex align-items-center gap-2 text-white py-3" style="background-color: #064e3b">
                <i class="ti ti-news fs-5"></i>
                <h6 class="card-title mb-0 text-white">Data Post</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background-color: #064e3b">
                            <tr>
                                <th class="text-white py-3" style="width: 1%;">NO.</th>
                                <th class="text-white py-3" style="width: 100px;">IMAGE</th>
                                <th class="text-white py-3">JUDUL</th>
                                <th class="text-white py-3">KATEGORI</th>
                                <th class="text-white py-3 text-end" style="width: 80px;">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($posts as $d)
                                <tr>
                                    <td class="py-2 text-center">{{ $loop->iteration }}</td>
                                    <td class="py-2">
                                        <div class="avatar avatar-lg rounded overflow-hidden border shadow-sm" style="width: 80px; height: 50px;">
                                            @php
                                                $imagePath = str_replace(url('/storage/'), '', $d->image);
                                            @endphp
                                            @if ($d->image && Storage::disk('public')->exists($imagePath))
                                                <img src="{{ $d->image }}" alt="{{ $d->title }}" style="object-fit: cover; width: 100%; height: 100%;">
                                            @else
                                                <div class="bg-label-success d-flex align-items-center justify-content-center h-100 w-100">
                                                    <i class="ti ti-photo fs-2"></i>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-2 fw-bold text-dark">{{ $d->title }}</td>
                                    <td class="py-2">
                                        <span class="badge bg-label-success">{{ $d->category->name }}</span>
                                    </td>
                                    <td class="py-2 text-end">
                                        <div class="d-flex justify-content-end gap-1">
                                            @can('post.edit')
                                                <a href="#" class="btn btn-icon btn-label-success border edit"
                                                    style="width: 28px; height: 28px;"
                                                    id="{{ Crypt::encrypt($d->id) }}">
                                                    <i class="ti ti-edit fs-6"></i>
                                                </a>
                                            @endcan
                                            @can('post.delete')
                                                <form method="POST" name="deleteform" class="deleteform"
                                                    action="{{ route('post.delete', Crypt::encrypt($d->id)) }}">
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
                                    <td colspan="5" class="text-center p-5">
                                        <div class="mb-3">
                                            <i class="ti ti-news fs-1 opacity-25"></i>
                                        </div>
                                        <h5>Belum Ada Post</h5>
                                        <p class="text-muted">Silahkan tambah post baru atau sesuaikan filter pencarian.</p>
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

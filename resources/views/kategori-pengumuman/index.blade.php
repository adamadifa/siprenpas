@extends('layouts.app')
@section('titlepage', 'Kategori Pengumuman')

@section('content')
@section('navigasi')
    <span>Kategori Pengumuman</span>
@endsection
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                <a href="#" class="btn btn-primary" id="btnCreate"><i class="fa fa-plus me-2"></i> Tambah
                    Kategori</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('kategori-pengumuman.index') }}">
                            <div class="row">
                                <div class="col-lg-12 col-sm-12 col-md-12">
                                    <div class="form-group mb-3">

                                        <div class="input-group">
                                            <span class="input-group-text"><i class="ti ti-search"></i></span>
                                            <input type="text" class="form-control" name="search"
                                                value="{{ Request('search') }}" placeholder="Cari nama kategori...">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="ti ti-search me-1"></i>Cari
                                            </button>
                                            <a href="{{ route('kategori-pengumuman.index') }}"
                                                class="btn btn-secondary">
                                                <i class="ti ti-refresh me-1"></i>Reset
                                            </a>
                                        </div>
                                    </div>
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
                                        <th>Nama Kategori</th>
                                        <th>Jumlah Pengumuman</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kategori as $d)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $d->nama_kategori }}</td>
                                            <td>
                                                <span class="badge bg-label-primary">{{ $d->pengumuman_count }}</span>
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="#" class="me-2 btnShow"
                                                        kategori_id="{{ $d->id }}">
                                                        <i class="ti ti-file-description text-info"></i>
                                                    </a>
                                                    <a href="#" class="btnEdit me-1"
                                                        kategori_id="{{ $d->id }}">
                                                        <i class="ti ti-edit text-success"></i>
                                                    </a>
                                                    <form method="POST" name="deleteform" class="deleteform"
                                                        action="{{ route('kategori-pengumuman.destroy', $d->id) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <a href="#" class="delete-confirm me-1">
                                                            <i class="ti ti-trash text-danger"></i>
                                                        </a>
                                                    </form>
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
<x-modal-form id="modal" size="modal-lg" show="loadmodal" title="" />
@endsection
@push('myscript')
<script>
    $(function() {
        $(document).on('show.bs.modal', '.modal', function() {
            const zIndex = 1090 + 10 * $('.modal:visible').length;
            $(this).css('z-index', zIndex);
            setTimeout(() => $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1)
                .addClass('modal-stack'));
        });

        const loading = `<div class="sk-wave sk-primary" style="margin:auto">
            <div class="sk-wave-rect"></div>
            <div class="sk-wave-rect"></div>
            <div class="sk-wave-rect"></div>
            <div class="sk-wave-rect"></div>
            <div class="sk-wave-rect"></div>
            </div>`;

        $("#btnCreate").click(function(e) {
            e.preventDefault();
            $("#modal").modal("show");
            $("#modal").find("#loadmodal").html(loading);
            $("#modal").find(".modal-title").text("Tambah Kategori Baru");
            $("#loadmodal").load(`{{ route('kategori-pengumuman.create') }}`);
        });

        $(".btnEdit").click(function(e) {
            e.preventDefault();
            const kategori_id = $(this).attr("kategori_id");
            $("#modal").modal("show");
            $("#modal").find("#loadmodal").html(loading);
            $("#modal").find(".modal-title").text("Edit Kategori");
            $("#loadmodal").load(`/kategori-pengumuman/${kategori_id}/edit`);
        });

        $(".btnShow").click(function(e) {
            e.preventDefault();
            const kategori_id = $(this).attr("kategori_id");
            $("#modal").modal("show");
            $("#modal").find("#loadmodal").html(loading);
            $("#modal").find(".modal-title").text("Detail Kategori");
            $("#loadmodal").load(`/kategori-pengumuman/${kategori_id}/show`);
        });

        // Handle delete confirmation
        $(document).on('click', '.delete-confirm', function(e) {
            e.preventDefault();
            const form = $(this).closest('form');

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data kategori akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush

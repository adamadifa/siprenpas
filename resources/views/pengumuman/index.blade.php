@extends('layouts.app')
@section('titlepage', 'Pengumuman')

@section('content')
@section('navigasi')
    <span>Pengumuman</span>
@endsection
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                <a href="#" class="btn btn-primary" id="btnCreate"><i class="fa fa-plus me-2"></i> Tambah
                    Pengumuman</a>
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

                        <form action="{{ route('pengumuman.index') }}">
                            <div class="row">
                                <div class="col-lg-6 col-sm-12 col-md-12">
                                    <x-input-with-icon label="Cari Judul Pengumuman" value="{{ Request('judul') }}"
                                        name="judul" icon="ti ti-search" />
                                </div>
                                <div class="col-lg-4 col-sm-12 col-md-12">
                                    <div class="form-group mb-3">
                                        <select name="kategori_id" id="kategori_id_search" class="form-select">
                                            <option value="">Semua Kategori</option>
                                            @foreach ($kategori ?? [] as $kat)
                                                <option value="{{ $kat->id }}"
                                                    {{ Request('kategori_id') == $kat->id ? 'selected' : '' }}>
                                                    {{ $kat->nama_kategori }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
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
                                        <th>Tanggal</th>
                                        <th>Lokasi</th>
                                        <th>Isi</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pengumuman as $d)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $d->judul }}</td>
                                            <td>
                                                <span
                                                    class="badge bg-label-primary">{{ $d->kategori->nama_kategori }}</span>
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($d->tanggal)->format('d M Y') }}</td>
                                            <td>{{ $d->lokasi ?? '-' }}</td>
                                            <td>{{ Str::limit($d->isi, 50) }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="#" class="me-2 btnShow"
                                                        pengumuman_id="{{ $d->id }}">
                                                        <i class="ti ti-file-description text-info"></i>
                                                    </a>
                                                    <a href="#" class="btnEdit me-1"
                                                        pengumuman_id="{{ $d->id }}">
                                                        <i class="ti ti-edit text-success"></i>
                                                    </a>
                                                    <form method="POST" name="deleteform" class="deleteform"
                                                        action="{{ route('pengumuman.destroy', $d->id) }}">
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
            $("#modal").find(".modal-title").text("Tambah Pengumuman Baru");
            $("#loadmodal").load(`{{ route('pengumuman.create') }}`);
        });

        $(".btnEdit").click(function(e) {
            e.preventDefault();
            const pengumuman_id = $(this).attr("pengumuman_id");
            $("#modal").modal("show");
            $("#modal").find("#loadmodal").html(loading);
            $("#modal").find(".modal-title").text("Edit Pengumuman");
            $("#loadmodal").load(`/pengumuman/${pengumuman_id}/edit`);
        });

        $(".btnShow").click(function(e) {
            e.preventDefault();
            const pengumuman_id = $(this).attr("pengumuman_id");
            $("#modal").modal("show");
            $("#modal").find("#loadmodal").html(loading);
            $("#modal").find(".modal-title").text("Detail Pengumuman");
            $("#loadmodal").load(`/pengumuman/${pengumuman_id}/show`);
        });



        // Handle delete confirmation
        $(document).on('click', '.delete-confirm', function(e) {
            e.preventDefault();
            const form = $(this).closest('form');

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data pengumuman akan dihapus permanen!",
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

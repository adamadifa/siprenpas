@extends('layouts.app')
@section('titlepage', 'Kategori Pengumuman')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-category fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Kategori Pengumuman</h4>
                        <p class="text-muted mb-0 small">Manajemen pengelompokan pengumuman lembaga</p>
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
                                <i class="ti ti-category me-1"></i> Kategori Pengumuman
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
            <a href="#" class="btn d-flex align-items-center gap-2 shadow-sm text-white" id="btnCreate"
                style="background-color: #064e3b">
                <i class="ti ti-plus fs-4"></i>
                <span>Tambah Kategori</span>
            </a>
        </div>

        <!-- Filter Section -->
        <style>
            .form-filter .form-group {
                margin-bottom: 0 !important;
            }
        </style>
        <div class="card mb-4 shadow-none border-0 bg-transparent">
            <div class="card-body p-0">
                <form action="{{ route('kategori-pengumuman.index') }}" class="form-filter">
                    <div class="row g-3 align-items-center">
                        <div class="col-lg-11 col-md-10">
                            <x-input-with-icon label="" value="{{ Request('search') }}" name="search"
                                placeholder="Cari Nama Kategori..." icon="ti ti-search" />
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
                <i class="ti ti-category fs-5"></i>
                <h6 class="card-title mb-0 text-white">Data Kategori Pengumuman</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background-color: #064e3b">
                            <tr>
                                <th class="text-white py-3" style="width: 1%;">NO.</th>
                                <th class="text-white py-3">NAMA KATEGORI</th>
                                <th class="text-white py-3 text-center">JUMLAH PENGUMUMAN</th>
                                <th class="text-white py-3 text-end" style="width: 120px;">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($kategori as $d)
                                <tr>
                                    <td class="py-2 text-center">{{ $loop->iteration }}</td>
                                    <td class="py-2 fw-bold text-dark">{{ $d->nama_kategori }}</td>
                                    <td class="py-2 text-center">
                                        <span class="badge bg-label-success">{{ $d->pengumuman_count }}</span>
                                    </td>
                                    <td class="py-2 text-end">
                                        <div class="d-flex justify-content-end gap-1 px-3">
                                            <a href="#" class="btn btn-icon btn-label-info border btnShow"
                                                style="width: 28px; height: 28px;" kategori_id="{{ $d->id }}">
                                                <i class="ti ti-file-description fs-6"></i>
                                            </a>
                                            <a href="#" class="btn btn-icon btn-label-success border btnEdit"
                                                style="width: 28px; height: 28px;" kategori_id="{{ $d->id }}">
                                                <i class="ti ti-edit fs-6"></i>
                                            </a>
                                            <form method="POST" name="deleteform" class="deleteform"
                                                action="{{ route('kategori-pengumuman.destroy', $d->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <a href="#" class="btn btn-icon btn-label-danger border delete-confirm"
                                                    style="width: 28px; height: 28px;">
                                                    <i class="ti ti-trash fs-6"></i>
                                                </a>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center p-5">
                                        <div class="mb-3">
                                            <i class="ti ti-category fs-1 opacity-25"></i>
                                        </div>
                                        <h5>Belum Ada Kategori</h5>
                                        <p class="text-muted">Silahkan tambah kategori pengumuman baru.</p>
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

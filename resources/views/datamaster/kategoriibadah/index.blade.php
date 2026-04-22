@extends('layouts.app')
@section('titlepage', 'Kategori Ibadah')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-book fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Data Kategori Ibadah</h4>
                        <p class="text-muted mb-0 small">Manajemen master data kategori ibadah</p>
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
                                <i class="ti ti-book me-1"></i> Kategori Ibadah
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

<div class="row">
    <div class="col-lg-6 col-md-12 col-sm-12">
        <!-- Actions Section -->
        <div class="d-flex justify-content-start mb-3">
            @can('kategoriibadah.create')
                <button class="btn d-flex align-items-center gap-2 shadow-sm text-white" id="btncreateKategoriIbadah"
                    style="background-color: #064e3b">
                    <i class="ti ti-plus fs-4"></i>
                    <span>Tambah Kategori Ibadah</span>
                </button>
            @endcan
        </div>

        <form action="{{ route('kategoriibadah.index') }}" class="mb-4">
            <div class="row align-items-end g-3">
                <div class="col-lg-10 col-md-9">
                    <x-input-with-icon label="Nama Kategori Ibadah" value="{{ Request('nama_kategori_ibadah') }}"
                        name="nama_kategori_ibadah" icon="ti ti-search" />
                </div>
                <div class="col-lg-2 col-md-3">
                    <button class="btn btn-primary w-100 p-2 d-flex align-items-center justify-content-center gap-2" style="background-color: #064e3b; border-color: #064e3b">
                        <i class="ti ti-search fs-5"></i>
                        <span>Cari</span>
                    </button>
                </div>
            </div>
        </form>

        <div class="card shadow-sm">
            <div class="card-header d-flex align-items-center gap-2 text-white py-3" style="background-color: #064e3b">
                <i class="ti ti-layout-grid fs-5"></i>
                <h6 class="card-title mb-0 text-white">Data Kategori Ibadah</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background-color: #064e3b">
                            <tr>
                                <th class="text-white py-3" style="width: 60px;">NO.</th>
                                <th class="text-white py-3">KATEGORI</th>
                                <th class="text-white py-3 text-end" style="width: 100px;">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($kategoriibadah as $d)
                                <tr>
                                    <td class="py-1 text-center">{{ $loop->iteration }}</td>
                                    <td class="py-1"><span class="fw-bold">{{ $d->kategori_ibadah }}</span></td>
                                    <td class="py-1 text-end">
                                        <div class="d-flex justify-content-end gap-1">
                                            @can('kategoriibadah.edit')
                                                <a href="#" class="btn btn-icon btn-label-success border editKategoriIbadah shadow-none"
                                                    style="width: 28px; height: 28px;"
                                                    id="{{ Crypt::encrypt($d->id) }}" data-bs-toggle="tooltip" title="Edit Data">
                                                    <i class="ti ti-edit fs-6"></i>
                                                </a>
                                            @endcan
                                            @can('kategoriibadah.delete')
                                                <form method="POST" class="deleteform d-inline"
                                                    action="{{ route('kategoriibadah.delete', Crypt::encrypt($d->id)) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="#" class="btn btn-icon btn-label-danger border delete-confirm shadow-none"
                                                        style="width: 28px; height: 28px;" data-bs-toggle="tooltip" title="Hapus Data">
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
                                            <i class="ti ti-book fs-1 opacity-25"></i>
                                        </div>
                                        <h5>Belum Ada Data Kategori Ibadah</h5>
                                        <p class="text-muted small">Silahkan tambah data baru.</p>
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

<x-modal-form id="mdlcreateKategoriIbadah" size="" show="loadcreateKategoriIbadah" title="Tambah Kategori Ibadah" icon="ti ti-book" />
<x-modal-form id="mdleditKategoriIbadah" size="" show="loadeditKategoriIbadah" title="Edit Kategori Ibadah" icon="ti ti-book" />
@endsection

@push('myscript')
<script>
    $(function() {
        $("#btncreateKategoriIbadah").click(function(e) {
            e.preventDefault();
            $('#mdlcreateKategoriIbadah').modal("show");
            $("#loadcreateKategoriIbadah").html(`<div class="sk-wave sk-primary" style="margin:auto">
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                </div>`);
            $("#loadcreateKategoriIbadah").load('/kategoriibadah/create');
        });

        $(".editKategoriIbadah").click(function(e) {
            var id = $(this).attr("id");
            e.preventDefault();
            $('#mdleditKategoriIbadah').modal("show");
            $("#loadeditKategoriIbadah").html(`<div class="sk-wave sk-primary" style="margin:auto">
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                </div>`);
            $("#loadeditKategoriIbadah").load('/kategoriibadah/' + id + '/edit');
        });

        // Konfirmasi Delete
        $(".delete-confirm").click(function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#064e3b',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
@endpush

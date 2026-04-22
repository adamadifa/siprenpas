@extends('layouts.app')
@section('titlepage', 'Jenis Pembiayaan')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-cash fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Data Jenis Pembiayaan</h4>
                        <p class="text-muted mb-0 small">Manajemen master data jenis pembiayaan koperasi</p>
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
                                <i class="ti ti-cash me-1"></i> Jenis Pembiayaan
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

<div class="row">
    <div class="col-lg-7 col-md-12 col-sm-12">
        <!-- Actions Section -->
        <div class="d-flex justify-content-start mb-3">
            @can('jenispembiayaan.create')
                <button class="btn d-flex align-items-center gap-2 shadow-sm text-white" id="btnCreate"
                    style="background-color: #064e3b">
                    <i class="ti ti-plus fs-4"></i>
                    <span>Tambah Jenis Pembiayaan</span>
                </button>
            @endcan
        </div>

        <form action="{{ URL::current() }}" class="mb-4">
            <div class="row align-items-end g-3">
                <div class="col-lg-10 col-md-9">
                    <x-input-with-icon label="Cari Jenis Pembiayaan" value="{{ Request('jenis_pembiayaan_search') }}" name="jenis_pembiayaan_search"
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

        <div class="card shadow-sm">
            <div class="card-header d-flex align-items-center gap-2 text-white py-3" style="background-color: #064e3b">
                <i class="ti ti-layout-grid fs-5"></i>
                <h6 class="card-title mb-0 text-white">Data Jenis Pembiayaan</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background-color: #064e3b">
                            <tr>
                                <th class="text-white py-3">KODE</th>
                                <th class="text-white py-3">JENIS PEMBIAYAAN</th>
                                <th class="text-white py-3">PERSENTASE</th>
                                <th class="text-white py-3 text-end" style="width: 120px;">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($jenispembiayaan as $d)
                                <tr>
                                    <td class="py-1"><span class="fw-bold">{{ $d->kode_pembiayaan }}</span></td>
                                    <td class="py-1">{{ $d->jenis_pembiayaan }}</td>
                                    <td class="py-1"><span class="badge bg-label-info">{{ $d->persentase }} %</span></td>
                                    <td class="py-1 text-end">
                                        <div class="d-flex justify-content-end gap-1">
                                            @can('jenispembiayaan.edit')
                                                <a href="#" class="btn btn-icon btn-label-success border btnEdit shadow-none"
                                                    style="width: 28px; height: 28px;"
                                                    kode_pembiayaan="{{ Crypt::encrypt($d->kode_pembiayaan) }}" data-bs-toggle="tooltip" title="Edit Data">
                                                    <i class="ti ti-edit fs-6"></i>
                                                </a>
                                            @endcan
                                            @can('jenispembiayaan.delete')
                                                <form method="POST" class="deleteform d-inline"
                                                    action="{{ route('jenispembiayaan.delete', Crypt::encrypt($d->kode_pembiayaan)) }}">
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
                                    <td colspan="4" class="text-center p-5">
                                        <div class="mb-3">
                                            <i class="ti ti-cash fs-1 opacity-25"></i>
                                        </div>
                                        <h5>Belum Ada Data Jenis Pembiayaan</h5>
                                        <p class="text-muted small">Silahkan tambah data baru.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-4 py-3 border-top">
                    <div style="float: right;">
                        {{ $jenispembiayaan->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<x-modal-form id="modal" size="" show="loadmodal" title="" icon="ti ti-cash" />
@endsection

@push('myscript')
<script>
    $(function() {
        $("#btnCreate").click(function(e) {
            e.preventDefault();
            $('#modal').modal("show");
            $(".modal-title").text("Tambah Data Jenis Pembiayaan");
            $("#loadmodal").html(`<div class="sk-wave sk-primary" style="margin:auto">
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                </div>`);
            $("#loadmodal").load("{{ route('jenispembiayaan.create') }}");
        });

        $(".btnEdit").click(function(e) {
            e.preventDefault();
            const kode_pembiayaan = $(this).attr('kode_pembiayaan')
            $('#modal').modal("show");
            $(".modal-title").text("Edit Jenis Pembiayaan");
            $("#loadmodal").html(`<div class="sk-wave sk-primary" style="margin:auto">
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                </div>`);
            $("#loadmodal").load(`/jenispembiayaan/${kode_pembiayaan}/edit`);
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

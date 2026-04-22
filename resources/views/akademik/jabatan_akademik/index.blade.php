@extends('layouts.app')
@section('titlepage', 'Jabatan Akademik')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-id-badge fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Jabatan Akademik</h4>
                        <p class="text-muted mb-0 small">Manajemen data jabatan akademik</p>
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
                                <i class="ti ti-id-badge me-1"></i> Jabatan Akademik
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

<div class="row">
    <div class="col-lg-8">
        <!-- Actions Section -->
        <div class="d-flex justify-content-start mb-3">
            @can('jabatanakademik.store')
                <button class="btn d-flex align-items-center gap-2 shadow-sm text-white" id="btnCreateJabatan"
                    style="background-color: #064e3b">
                    <i class="ti ti-plus fs-4"></i>
                    <span>Tambah Jabatan</span>
                </button>
            @endcan
        </div>

        <!-- Filter Form -->
        <div class="mb-4">
            <form action="{{ route('jabatan-akademik.index') }}">
                <div class="d-flex gap-2">
                    <div class="input-group input-group-merge border shadow-none rounded-2"
                        style="border-color: #e0e0e0 !important;">
                        <span class="input-group-text bg-white border-0"><i class="ti ti-search text-muted"></i></span>
                        <input type="text" name="nama_jabatan_search" class="form-control bg-white border-0 ps-2"
                            placeholder="Cari Jabatan..." value="{{ Request('nama_jabatan_search') }}">
                    </div>
                    <button type="submit" class="btn shadow-none d-flex align-items-center gap-2 text-white px-4"
                        style="background-color: #064e3b">
                        <i class="ti ti-search fs-5"></i> Cari
                    </button>
                </div>
            </form>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header d-flex align-items-center gap-2 text-white py-3" style="background-color: #064e3b">
                <i class="ti ti-layout-grid fs-5"></i>
                <h6 class="card-title mb-0 text-white">Data Jabatan Akademik</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 text-nowrap">
                        <thead style="background-color: #064e3b">
                            <tr>
                                <th class="text-white py-3">NO.</th>
                                <th class="text-white py-3">KODE</th>
                                <th class="text-white py-3">NAMA JABATAN</th>
                                <th class="text-white py-3 text-center">URUTAN</th>
                                <th class="text-white py-3 text-center">RAPORT</th>
                                <th class="text-white py-3 text-end" style="width: 100px;">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($jabatan_akademik as $d)
                                <tr>
                                    <td class="py-1">{{ $loop->iteration }}</td>
                                    <td class="py-1"><span class="fw-bold">{{ $d->kode_jabatan }}</span></td>
                                    <td class="py-1">{{ $d->nama_jabatan }}</td>
                                    <td class="py-1 text-center">{{ $d->urutan }}</td>
                                    <td class="py-1 text-center">
                                        @if ($d->tampil_di_raport == 1)
                                            <span class="badge bg-label-success p-1"><i class="ti ti-check fs-6"></i></span>
                                        @else
                                            <span class="badge bg-label-secondary p-1"><i class="ti ti-minus fs-6"></i></span>
                                        @endif
                                    </td>
                                    <td class="py-1 text-end">
                                        <div class="d-flex justify-content-end gap-1">
                                            @can('jabatanakademik.edit')
                                                <a href="#" class="btn btn-icon btn-label-success border editJabatan"
                                                    style="width: 28px; height: 28px;"
                                                    id="{{ Crypt::encrypt($d->kode_jabatan) }}">
                                                    <i class="ti ti-edit fs-6"></i>
                                                </a>
                                            @endcan
                                            @can('jabatanakademik.delete')
                                                <form method="POST" name="deleteform" class="deleteform"
                                                    action="{{ route('jabatan-akademik.delete', Crypt::encrypt($d->kode_jabatan)) }}">
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
                                    <td colspan="6" class="text-center p-5">
                                        <div class="mb-3">
                                            <i class="ti ti-id-badge fs-1 opacity-25"></i>
                                        </div>
                                        <h5>Belum Ada Data Jabatan</h5>
                                        <p class="text-muted">Silahkan tambah data baru atau sesuaikan filter pencarian.</p>
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

<x-modal-form id="mdlCreateJabatan" size="" show="loadCreateJabatan" title="Tambah Jabatan Akademik" icon="ti ti-id-badge" />
<x-modal-form id="mdlEditJabatan" size="" show="loadEditJabatan" title="Edit Jabatan Akademik" icon="ti ti-edit" />

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
                            <div class="form-check mt-3 mb-3">
                                <input class="form-check-input" type="checkbox" value="1" id="tampil_di_raport" name="tampil_di_raport">
                                <label class="form-check-label" for="tampil_di_raport">
                                    Tampil di Raport (Tanda Tangan)
                                </label>
                            </div>
                            <div class="form-group mb-3">
                                <button class="btn btn-primary w-100" style="background-color: #064e3b; border-color: #064e3b">
                                    <i class="ti ti-send me-1"></i> Simpan Data
                                </button>
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

        // Delete Confirm
        $(document).on('click', '.delete-confirm', function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data ini akan dihapus secara permanen!",
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
    });
</script>
@endpush

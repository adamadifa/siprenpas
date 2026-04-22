@extends('layouts.app')
@section('titlepage', 'Jenis Biaya')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-credit-card fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Data Jenis Biaya</h4>
                        <p class="text-muted mb-0 small">Manajemen master data jenis biaya</p>
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
                                <i class="ti ti-credit-card me-1"></i> Jenis Biaya
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

<div class="row">
    <div class="col-lg-6">
        <!-- Actions Section -->
        <div class="d-flex justify-content-start mb-3">
            @can('jenisbiaya.create')
                <button class="btn d-flex align-items-center gap-2 shadow-sm text-white" id="btnCreate"
                    style="background-color: #064e3b">
                    <i class="ti ti-plus fs-4"></i>
                    <span>Tambah Jenis Biaya</span>
                </button>
            @endcan
        </div>

        <div class="card shadow-sm">
            <div class="card-header d-flex align-items-center gap-2 text-white py-3" style="background-color: #064e3b">
                <i class="ti ti-layout-grid fs-5"></i>
                <h6 class="card-title mb-0 text-white">Data Jenis Biaya</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background-color: #064e3b">
                            <tr>
                                <th class="text-white py-3">KODE</th>
                                <th class="text-white py-3">JENIS BIAYA</th>
                                <th class="text-white py-3 text-end" style="width: 100px;">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($jenisbiaya as $d)
                                <tr>
                                    <td class="py-1"><span class="fw-bold">{{ $d->kode_jenis_biaya }}</span></td>
                                    <td class="py-1">{{ $d->jenis_biaya }}</td>
                                    <td class="py-1 text-end">
                                        <div class="d-flex justify-content-end gap-1">
                                            @can('jenisbiaya.edit')
                                                <a href="#" class="btn btn-icon btn-label-success border btnEdit"
                                                    style="width: 28px; height: 28px;"
                                                    kode_jenis_biaya="{{ Crypt::encrypt($d->kode_jenis_biaya) }}">
                                                    <i class="ti ti-edit fs-6"></i>
                                                </a>
                                            @endcan
                                            @can('jenisbiaya.delete')
                                                <form method="POST" name="deleteform" class="deleteform"
                                                    action="{{ route('jenisbiaya.delete', Crypt::encrypt($d->kode_jenis_biaya)) }}">
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
                                    <td colspan="3" class="text-center p-5">
                                        <div class="mb-3">
                                            <i class="ti ti-credit-card fs-1 opacity-25"></i>
                                        </div>
                                        <h5>Belum Ada Data Jenis Biaya</h5>
                                        <p class="text-muted">Silahkan tambah data baru.</p>
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

<x-modal-form id="modal" size="" show="loadmodal" title="" />
@endsection

@push('myscript')
<script>
    $(function() {
        $("#btnCreate").click(function(e) {
            e.preventDefault();
            $('#modal').modal("show");
            $(".modal-title").text("Tambah Data Jenis Biaya");
            $("#loadmodal").load("{{ route('jenisbiaya.create') }}");
        });

        $(".btnEdit").click(function(e) {
            e.preventDefault();
            const kode_jenis_biaya = $(this).attr('kode_jenis_biaya')
            $('#modal').modal("show");
            $(".modal-title").text("Edit Jenis Biaya");
            $("#loadmodal").load(`/jenisbiaya/${kode_jenis_biaya}/edit`);
        });
    });
</script>
@endpush
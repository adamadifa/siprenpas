@extends('layouts.app')
@section('titlepage', 'Unit')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-building-community fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Data Unit</h4>
                        <p class="text-muted mb-0 small">Manajemen data unit</p>
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
                                <i class="ti ti-building-community me-1"></i> Unit
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
            @can('unit.create')
                <button class="btn d-flex align-items-center gap-2 shadow-sm text-white" id="btncreateUnit"
                    style="background-color: #064e3b">
                    <i class="ti ti-plus fs-4"></i>
                    <span>Tambah Unit</span>
                </button>
            @endcan
        </div>

        <!-- Filter Form -->
        <div class="mb-4">
            <form action="{{ route('unit.index') }}">
                <div class="d-flex gap-2">
                    <div class="input-group input-group-merge border shadow-none rounded-2"
                        style="border-color: #e0e0e0 !important;">
                        <span class="input-group-text bg-white border-0"><i class="ti ti-search text-muted"></i></span>
                        <input type="text" name="nama_unit_search" class="form-control bg-white border-0 ps-2"
                            placeholder="Cari Unit..." value="{{ Request('nama_unit_search') }}">
                    </div>
                    <button type="submit" class="btn shadow-none d-flex align-items-center gap-2 text-white px-4"
                        style="background-color: #064e3b">
                        <i class="ti ti-search fs-5"></i> Cari
                    </button>
                </div>
            </form>
        </div>

        <div class="card shadow-sm">
            <div class="card-header d-flex align-items-center gap-2 text-white py-3" style="background-color: #064e3b">
                <i class="ti ti-layout-grid fs-5"></i>
                <h6 class="card-title mb-0 text-white">Data Unit</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 text-nowrap">
                        <thead style="background-color: #064e3b">
                            <tr>
                                <th class="text-white py-3">NO.</th>
                                <th class="text-white py-3">KODE</th>
                                <th class="text-white py-3">NAMA UNIT</th>
                                <th class="text-white py-3 text-center">LOGO</th>
                                <th class="text-white py-3 text-center">STATUS</th>
                                <th class="text-white py-3 text-end" style="width: 100px;">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($unit as $d)
                                <tr>
                                    <td class="py-1">{{ $loop->iteration }}</td>
                                    <td class="py-1"><span class="fw-bold">{{ $d->kode_unit }}</span></td>
                                    <td class="py-1">{{ $d->nama_unit }}</td>
                                    <td class="py-1 text-center">
                                        @if ($d->logo && Storage::disk('public')->exists($d->logo))
                                            <img src="{{ asset('storage/' . $d->logo) }}" alt="Logo {{ $d->nama_unit }}"
                                                class="img-fluid rounded shadow-sm" style="max-height: 30px;">
                                        @else
                                            <div class="avatar avatar-xs d-inline-block">
                                                <div class="avatar-initial rounded bg-label-secondary" style="font-size: 0.7rem;">
                                                    <i class="ti ti-building-community"></i>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="py-1 text-center">
                                        @if ($d->status == 1)
                                            <span class="badge bg-label-success small" style="font-size: 0.7rem;">Show</span>
                                        @else
                                            <span class="badge bg-label-secondary small" style="font-size: 0.7rem;">Hide</span>
                                        @endif
                                    </td>
                                    <td class="py-1 text-end">
                                        <div class="d-flex justify-content-end gap-1">
                                            @can('unit.edit')
                                                <a href="#" class="btn btn-icon btn-label-success border editUnit"
                                                    style="width: 28px; height: 28px;"
                                                    kode_unit="{{ Crypt::encrypt($d->kode_unit) }}">
                                                    <i class="ti ti-edit fs-6"></i>
                                                </a>
                                            @endcan
                                            @can('unit.delete')
                                                <form method="POST" name="deleteform" class="deleteform"
                                                    action="{{ route('unit.delete', Crypt::encrypt($d->kode_unit)) }}">
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
                                            <i class="ti ti-building-community fs-1 opacity-25"></i>
                                        </div>
                                        <h5>Belum Ada Data Unit</h5>
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

<x-modal-form id="mdlcreateUnit" size="" show="loadcreateUnit" title="Tambah Unit" />
<x-modal-form id="mdleditUnit" size="" show="loadeditUnit" title="Edit Unit" />
@endsection

@push('myscript')
<script>
    $(function() {
        $("#btncreateUnit").click(function(e) {
            e.preventDefault();
            $('#mdlcreateUnit').modal("show");
            $("#loadcreateUnit").load('/unit/create');
        });

        $(".editUnit").click(function(e) {
            var kode_unit = $(this).attr("kode_unit");
            e.preventDefault();
            $('#mdleditUnit').modal("show");
            $("#loadeditUnit").load('/unit/' + kode_unit + '/edit');
        });
    });
</script>
@endpush



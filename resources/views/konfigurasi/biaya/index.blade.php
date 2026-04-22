@extends('layouts.app')
@section('titlepage', 'Biaya')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-coin fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Data Biaya</h4>
                        <p class="text-muted mb-0 small">Manajemen konfigurasi biaya pendidikan per unit dan tingkat</p>
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
                                <i class="ti ti-coin me-1"></i> Biaya
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

<div class="row">
    <div class="col-lg-12 col-md-12">
        <!-- Actions Section -->
        <div class="d-flex justify-content-start mb-3">
            @can('biaya.create')
                <a href="#" class="btn d-flex align-items-center gap-2 shadow-sm text-white" id="btnCreate"
                    style="background-color: #064e3b">
                    <i class="ti ti-plus fs-4"></i>
                    <span>Tambah Data Biaya</span>
                </a>
            @endcan
        </div>

        <!-- Filter Section -->
        <style>
            .form-filter .form-group {
                margin-bottom: 0 !important;
            }
        </style>
        <div class="card mb-4 shadow-none border-0 bg-transparent">
            <div class="card-body p-0">
                <form action="{{ route('biaya.index') }}" class="form-filter">
                    <div class="row g-3 align-items-center">
                        <div class="col-lg-5 col-md-5">
                            <x-select label="Pilih Unit" name="kode_unit" :data="$unit" key="kode_unit" textShow="nama_unit"
                                upperCase="true" selected="{{ Request('kode_unit') }}" />
                        </div>
                        <div class="col-lg-5 col-md-5">
                            <div class="form-group">
                                <select name="kode_ta" id="kode_ta" class="form-select border-0 shadow-sm border" style="border-color: #e0e0e0 !important;">
                                    <option value="">Semua Tahun Ajaran</option>
                                    @foreach ($tahunajaran as $d)
                                        <option value="{{ $d->kode_ta }}"
                                            @if (!empty(Request('kode_ta'))) {{ Request('kode_ta') == $d->kode_ta ? 'selected' : '' }} @else {{ $d->status == '1' ? 'selected' : '' }} @endif>
                                            {{ $d->tahun_ajaran }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2">
                            <button type="submit" class="btn btn-primary w-100 p-2 d-flex align-items-center justify-content-center shadow-sm"
                                style="background-color: #064e3b; border-color: #064e3b">
                                <i class="ti ti-search fs-5 me-1"></i> Cari
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header d-flex align-items-center gap-2 text-white py-3" style="background-color: #064e3b">
                <i class="ti ti-list-details fs-5"></i>
                <h6 class="card-title mb-0 text-white">Rincian Konfigurasi Biaya</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background-color: #064e3b">
                            <tr>
                                <th class="text-white py-3">KODE BIAYA</th>
                                <th class="text-white py-3">UNIT / JENJANG</th>
                                <th class="text-white py-3 text-center">TINGKAT</th>
                                <th class="text-white py-3 text-center">ASRAMA</th>
                                <th class="text-white py-3">TAHUN AJARAN</th>
                                <th class="text-white py-3 text-end" style="width: 120px;">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($biaya as $d)
                                <tr>
                                    <td class="py-2 fw-bold text-muted small">{{ $d->kode_biaya }}</td>
                                    <td class="py-2">
                                        <span class="fw-bold text-dark">{{ $d->nama_unit }}</span>
                                    </td>
                                    <td class="py-2 text-center">
                                        <span class="badge bg-label-info">{{ $d->tingkat }}</span>
                                    </td>
                                    <td class="py-2 text-center">
                                        @if ($d->asrama)
                                            <span class="badge bg-label-success">
                                                <i class="ti ti-home me-1"></i> Asrama
                                            </span>
                                        @else
                                            <span class="text-muted small">Non-Asrama</span>
                                        @endif
                                    </td>
                                    <td class="py-2 fw-medium text-dark">{{ $d->tahun_ajaran }}</td>
                                    <td class="py-2 text-end">
                                        <div class="d-flex justify-content-end gap-1 px-3">
                                            @can('biaya.show')
                                                <a href="#" class="btn btn-icon btn-label-info border btnShow"
                                                    style="width: 28px; height: 28px;" kode_biaya="{{ Crypt::encrypt($d->kode_biaya) }}">
                                                    <i class="ti ti-file-description fs-6"></i>
                                                </a>
                                            @endcan
                                            @can('biaya.edit')
                                                <a href="#" class="btn btn-icon btn-label-success border btnEdit"
                                                    style="width: 28px; height: 28px;" kode_biaya="{{ Crypt::encrypt($d->kode_biaya) }}">
                                                    <i class="ti ti-edit fs-6"></i>
                                                </a>
                                            @endcan
                                            @can('biaya.delete')
                                                <form method="POST" name="deleteform" class="deleteform"
                                                    action="{{ route('biaya.delete', Crypt::encrypt($d->kode_biaya)) }}">
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
                                            <i class="ti ti-coin-off fs-1 opacity-25"></i>
                                        </div>
                                        <h5>Belum Ada Data Biaya</h5>
                                        <p class="text-muted">Silahkan tambah konfigurasi biaya baru atau sesuaikan filter pencarian.</p>
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
        $("#btnCreate").click(function(e) {
            e.preventDefault();
            $('#modal').modal("show");
            $(".modal-title").text("Tambah Data Biaya");
            $("#loadmodal").load("{{ route('biaya.create') }}");
        });

        $(".btnEdit").click(function(e) {
            e.preventDefault();
            const kode_biaya = $(this).attr("kode_biaya");
            $('#modal').modal("show");
            $(".modal-title").text("Edit Data Biaya");
            $("#loadmodal").load(`/biaya/${kode_biaya}/edit`);
        });

        $(".btnShow").click(function(e) {
            e.preventDefault();
            const kode_biaya = $(this).attr("kode_biaya");
            $('#modal').modal("show");
            $(".modal-title").text("Detail Data Biaya");
            $("#loadmodal").load(`/biaya/${kode_biaya}/show`);
        });
    });
</script>
@endpush

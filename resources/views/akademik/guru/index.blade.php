@extends('layouts.app')
@section('titlepage', 'Data Guru')

@section('content')
@section('navigasi')
    <span>Data Guru</span>
@endsection
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                @can('guru.create')
                    <a href="#" class="btn btn-primary" id="btnCreateGuru"><i class="fa fa-plus me-2"></i> Tambah Data Guru</a>
                @endcan
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <form action="{{ route('guru.index') }}">
                            <div class="row">
                                <div class="col-lg-6 col-sm-12 col-md-12">
                                    <x-input-with-icon label="Cari Nama Guru" value="{{ Request('nama_lengkap') }}"
                                        name="nama_lengkap" icon="ti ti-search" />
                                </div>
                                <div class="col-lg-4 col-sm-12 col-md-12">
                                    <div class="form-group mb-3">
                                        <select name="kode_unit" class="form-select">
                                            <option value="">Semua Unit</option>
                                            @foreach ($unit as $u)
                                                <option value="{{ $u->kode_unit }}" {{ Request('kode_unit') == $u->kode_unit ? 'selected' : '' }}>{{ $u->nama_unit }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-12 col-md-12">
                                    <button class="btn btn-primary w-100">Cari</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            @foreach ($guru as $d)
                            <div class="col-12">
                                <div class="card mb-2 border">
                                    <div class="card-body p-3">
                                        <div class="row align-items-center">
                                            <div class="col-lg-3 col-md-6 col-sm-12 border-end">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar me-3 rounded bg-primary text-white d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;">
                                                        <i class="ti ti-user fs-4"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0 fw-bold">{{ $d->nama_lengkap }}</h6>
                                                        <small class="text-muted">{{ $d->npp }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-sm-12 border-end">
                                                <div class="d-flex flex-column">
                                                    <span class="fw-bold text-dark">{{ $d->nama_unit }}</span>
                                                    <small class="text-muted">{{ $d->nama_jabatan }}</small>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-6 col-sm-12 border-end">
                                                <div class="d-flex flex-column">
                                                    <small class="text-muted">NIP/PegID</small>
                                                    <span class="fw-bold">{{ $d->nomor_kemenag_dinas ?? '-' }}</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3 col-sm-6 border-end text-center">
                                                @if ($d->status_aktif_ajar == 1)
                                                    <span class="badge bg-success w-100 mb-1">Aktif</span>
                                                @else
                                                    <span class="badge bg-danger w-100 mb-1">Non-Aktif</span>
                                                @endif
                                                <div>
                                                     @if (!empty($d->file_ttd))
                                                        <span class="badge bg-primary w-100">Ada TTD</span>
                                                    @else
                                                        <span class="badge bg-warning w-100">No TTD</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3 col-sm-6 text-end">
                                                 <div class="btn-group shadow-sm" role="group">
                                                     @if (!empty($d->file_ttd))
                                                        <a href="{{ asset('storage/uploads/ttd_guru/' . $d->file_ttd) }}" target="_blank" class="btn btn-sm btn-outline-success py-1 px-2 waves-effect" data-bs-toggle="tooltip" title="Lihat TTD">
                                                            <i class="ti ti-file-check"></i>
                                                        </a>
                                                    @endif
                                                    @can('guru.edit')
                                                        <a href="#" class="btn btn-sm btn-outline-warning editGuru py-1 px-2 waves-effect" id="{{ Crypt::encrypt($d->id) }}" data-bs-toggle="tooltip" title="Edit">
                                                            <i class="ti ti-edit"></i>
                                                        </a>
                                                    @endcan
                                                    @can('guru.delete')
                                                        <form method="POST" name="deleteform" class="d-inline" action="{{ route('guru.delete', Crypt::encrypt($d->id)) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger delete-confirm rounded-0 rounded-end py-1 px-2 waves-effect" data-bs-toggle="tooltip" title="Hapus">
                                                                <i class="ti ti-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endcan
                                                 </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div style="float: right;">
                            {{ $guru->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<x-modal-form id="mdlCreateGuru" size="" show="loadCreateGuru" title="Tambah Data Guru" />
<x-modal-form id="mdlEditGuru" size="" show="loadEditGuru" title="Edit Data Guru" />

@endsection

@push('myscript')
<script>
    $(function() {
        $("#btnCreateGuru").click(function(e) {
            e.preventDefault();
            $('#mdlCreateGuru').modal("show");
            $("#loadCreateGuru").load('/guru/create');
        });

        $(".editGuru").click(function(e) {
            var id = $(this).attr("id");
            e.preventDefault();
            $('#mdlEditGuru').modal("show");
            $("#loadEditGuru").load('/guru/' + id + '/edit');
        });
    });
</script>
@endpush

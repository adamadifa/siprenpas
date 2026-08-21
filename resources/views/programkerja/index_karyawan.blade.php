@extends('layouts.app')
@section('titlepage', 'Program Kerja Saya')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-4">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md rounded-circle d-flex align-items-center justify-content-center" style="background-color: #e6f4ea; color: #064e3b">
                        <i class="ti ti-notebook fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-1 fw-extrabold" style="color: #064e3b; letter-spacing: -0.5px;">Program Kerja</h4>
                        <p class="text-muted mb-0 small">Daftar rencana dan target capaian program kerja departemen Anda</p>
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
                            <li class="breadcrumb-item active fw-medium" style="color: #064e3b">
                                <i class="ti ti-notebook me-1"></i> Program Kerja
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

        <!-- Employee Profile Summary Card -->
        @if(!empty($karyawan))
            <div class="card border-0 shadow-sm mb-4 rounded-3 overflow-hidden text-white" style="background: linear-gradient(135deg, #064e3b 0%, #043e2f 100%);">
                <div class="card-body p-4">
                    <div class="row align-items-center g-4">
                        <div class="col-auto">
                            <div class="avatar avatar-xl bg-white rounded-3 d-flex align-items-center justify-content-center" style="width: 70px; height: 70px; box-shadow: 0 4px 10px rgba(0,0,0,0.15);">
                                <i class="ti ti-user-check fs-2" style="color: #064e3b;"></i>
                            </div>
                        </div>
                        <div class="col-md">
                            <h4 class="fw-bold mb-1 text-white">{{ $karyawan->nama_lengkap }}</h4>
                            <p class="text-white-50 mb-0 small">NPP: <span class="fw-semibold text-white">{{ $karyawan->npp }}</span></p>
                        </div>
                        <div class="col-md-auto ms-md-auto">
                            <div class="d-flex flex-wrap gap-2">
                                <div class="d-flex align-items-center gap-3 px-3 py-2 rounded-3" style="background: rgba(255, 255, 255, 0.12) !important; border: 1px solid rgba(255, 255, 255, 0.08);">
                                    <i class="ti ti-briefcase text-white fs-4 flex-shrink-0"></i>
                                    <div style="line-height: 1.1;">
                                        <span class="text-white-50 text-uppercase d-block mb-1" style="font-size: 0.6rem; letter-spacing: 0.5px; font-weight: 500;">Jabatan</span>
                                        <span class="fw-bold text-white" style="font-size: 0.8rem; letter-spacing: 0.2px;">{{ strtoupper($karyawan->nama_jabatan) }}</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-3 px-3 py-2 rounded-3" style="background: rgba(255, 255, 255, 0.12) !important; border: 1px solid rgba(255, 255, 255, 0.08);">
                                    <i class="ti ti-hierarchy-2 text-white fs-4 flex-shrink-0"></i>
                                    <div style="line-height: 1.1;">
                                        <span class="text-white-50 text-uppercase d-block mb-1" style="font-size: 0.6rem; letter-spacing: 0.5px; font-weight: 500;">Departemen</span>
                                        <span class="fw-bold text-white" style="font-size: 0.8rem; letter-spacing: 0.2px;">{{ strtoupper($karyawan->nama_dept) }}</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-3 px-3 py-2 rounded-3" style="background: rgba(255, 255, 255, 0.12) !important; border: 1px solid rgba(255, 255, 255, 0.08);">
                                    <i class="ti ti-building text-white fs-4 flex-shrink-0"></i>
                                    <div style="line-height: 1.1;">
                                        <span class="text-white-50 text-uppercase d-block mb-1" style="font-size: 0.6rem; letter-spacing: 0.5px; font-weight: 500;">Unit Kerja</span>
                                        <span class="fw-bold text-white" style="font-size: 0.8rem; letter-spacing: 0.2px;">{{ strtoupper($karyawan->nama_unit) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Actions & Info Header -->
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            @can('programkerja.create')
                <button class="btn d-flex align-items-center gap-2 shadow-sm text-white px-4 py-2-5 rounded-3 border-0 transition-all" id="btncreateProgramKerja"
                    style="background: linear-gradient(135deg, #064e3b 0%, #0b6e54 100%);">
                    <i class="ti ti-plus fs-5"></i>
                    <span class="fw-semibold">Tambah Program Kerja</span>
                </button>
            @endcan
            <div class="text-muted small">
                Total: <span class="fw-bold text-dark">{{ count($programkerja) }}</span> Program Kerja Terdaftar
            </div>
        </div>

        <!-- Filter Form -->
        <div class="mb-4">
            <form action="{{ route('programkerja.index') }}" id="myForm" class="form-filter">
                <div class="row g-3 align-items-center">
                    <div class="col-lg-2 col-md-6">
                        <div class="form-group">
                            <div class="input-group border rounded-2 shadow-sm bg-white" style="border-color: #e0e0e0 !important;">
                                <span class="input-group-text bg-white border-0 border-end" style="border-color: #e0e0e0 !important; color: #8e9ba5; padding-right: 12px; padding-left: 12px;"><i class="ti ti-calendar fs-5"></i></span>
                                <select name="kode_ta" id="kode_ta" class="form-select border-0 ps-2 bg-transparent" style="box-shadow: none;">
                                    @foreach ($tahunajaran as $d)
                                        <option value="{{ $d->kode_ta }}"
                                            {{ Request('kode_ta') == $d->kode_ta || $ta_aktif->kode_ta == $d->kode_ta ? 'selected' : '' }}>
                                            {{ $d->tahun_ajaran }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group">
                            <div class="input-group border rounded-2 shadow-sm bg-white" style="border-color: #e0e0e0 !important;">
                                <span class="input-group-text bg-white border-0 border-end" style="border-color: #e0e0e0 !important; color: #8e9ba5; padding-right: 12px; padding-left: 12px;"><i class="ti ti-user-check fs-5"></i></span>
                                <select name="kode_jabatan" id="kode_jabatan" class="form-select border-0 ps-2 bg-transparent" style="box-shadow: none;">
                                    <option value="">Pilih Jabatan</option>
                                    @foreach ($jabatans as $j)
                                        <option value="{{ $j->kode_jabatan }}" {{ Request('kode_jabatan') == $j->kode_jabatan ? 'selected' : '' }}>
                                            {{ strtoupper($j->nama_jabatan) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-6">
                        <x-input-with-icon label="" value="{{ Request('programkerja_search') }}" name="programkerja_search"
                            placeholder="Cari program kerja..." icon="ti ti-search" />
                    </div>
                    <div class="col-lg-2 col-md-12">
                        <div class="d-flex gap-2">
                            <button class="btn btn-success d-flex align-items-center justify-content-center gap-2 shadow-sm w-100 py-2 fw-semibold" type="submit" style="background-color: #064e3b; border-color: #064e3b; border-radius: 8px;">
                                <i class="ti ti-search fs-5"></i> Cari
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Table Card -->
        <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead style="background-color: #064e3b">
                            <tr>
                                <th class="text-center py-3 text-white font-weight-bold" style="width: 60px;">NO.</th>
                                <th class="py-3 text-white font-weight-bold" style="min-width: 250px;">PROGRAM KERJA</th>
                                <th class="py-3 text-white font-weight-bold" style="min-width: 380px;">TARGET PENCAPAIAN</th>
                                <th class="py-3 text-white font-weight-bold text-center" style="width: 120px;">DEPARTEMEN</th>
                                <th class="py-3 text-white font-weight-bold text-center" style="width: 120px;">JABATAN</th>
                                <th class="py-3 text-white font-weight-bold text-end pe-4" style="width: 110px;">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($programkerja as $d)
                                <tr>
                                    <td class="text-center text-secondary fw-semibold">{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="fw-bold text-dark mb-1" style="font-size: 0.95rem;">{!! $d->program_kerja !!}</div>
                                        <div class="text-muted small d-flex align-items-center gap-1">
                                            <i class="ti ti-tag fs-6 text-success"></i>
                                            <span>{{ $d->kode_program_kerja }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <div class="p-3 bg-light rounded-3 border-start border-3 border-success" style="font-size: 0.9rem;">
                                            {!! $d->target_pencapaian !!}
                                        </div>
                                        @if(!empty($d->keterangan))
                                            <div class="mt-2 text-muted small px-2">
                                                <i class="ti ti-info-circle me-1"></i>{{ removeHtmltag($d->keterangan) }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-label-success px-2.5 py-1 fw-bold text-uppercase" style="letter-spacing: 0.5px;">
                                            {{ $d->kode_dept }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-label-info px-2.5 py-1 fw-bold text-uppercase" style="letter-spacing: 0.5px;">
                                            {{ $d->nama_jabatan }}
                                        </span>
                                    </td>
                                    <td class="py-3 text-end pe-4">
                                        <div class="d-flex justify-content-end gap-2">
                                            @can('programkerja.edit')
                                                <a href="#" class="btn btn-icon btn-label-success border-0 shadow-sm btnEdit rounded-3"
                                                    style="width: 32px; height: 32px;"
                                                    id="{{ Crypt::encrypt($d->kode_program_kerja) }}"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Program Kerja">
                                                    <i class="ti ti-edit fs-5"></i>
                                                </a>
                                            @endcan
                                            @can('programkerja.delete')
                                                <form method="POST" name="deleteform" class="deleteform m-0"
                                                    action="{{ route('programkerja.delete', Crypt::encrypt($d->kode_program_kerja)) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-icon btn-label-danger border-0 shadow-sm delete-confirm rounded-3"
                                                        style="width: 32px; height: 32px;"
                                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Program Kerja">
                                                        <i class="ti ti-trash fs-5"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center p-5 bg-white">
                                        <div class="mb-3 text-muted">
                                            <i class="ti ti-notebook-off fs-1 opacity-50 text-success"></i>
                                        </div>
                                        <h5 class="fw-bold text-dark">Belum Ada Program Kerja</h5>
                                        <p class="text-muted small">Program kerja departemen belum terdaftar atau sesuaikan filter pencarian.</p>
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

<x-modal-form id="mdlProgramkerja" size="" show="loadProgramkerja" title="" />

@endsection

@push('myscript')
<script>
    $(function() {
        // Initialize Tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        $("#btncreateProgramKerja").click(function(e) {
            e.preventDefault();
            $('#mdlProgramkerja').modal("show");
            $("#mdlProgramkerja").find(".modal-title").text("Tambah Program Kerja {{ $ta_aktif->tahun_ajaran }}");
            $("#loadProgramkerja").load('/programkerja/create');
        });

        $(".btnEdit").click(function(e) {
            var id = $(this).attr("id");
            e.preventDefault();
            $('#mdlProgramkerja').modal("show");
            $("#mdlProgramkerja").find(".modal-title").text("Edit Program Kerja");
            $("#loadProgramkerja").load('/programkerja/' + id + '/edit');
        });
    });
</script>
@endpush

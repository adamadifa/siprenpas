@extends('layouts.app')
@section('titlepage', 'Karyawan')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-primary rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-users fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold text-primary">Data Karyawan</h4>
                        <p class="text-muted mb-0 small">Manajemen data dan akses karyawan</p>
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
                                <i class="ti ti-users me-1"></i> Karyawan
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

<div class="col-lg-12">
    <!-- Actions Section -->
    <div class="d-flex justify-content-start mb-4">
        @can('karyawan.create')
            <button class="btn btn-primary d-flex align-items-center gap-2 shadow-sm" id="btncreateKaryawan">
                <i class="ti ti-plus fs-4"></i>
                <span>Tambah Karyawan</span>
            </button>
        @endcan
    </div>

    <!-- Statistics Section -->
    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card shadow-sm border-0 hover-shadow-md transition-all">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-md bg-label-primary rounded-circle me-3 d-flex align-items-center justify-content-center">
                            <i class="ti ti-users fs-3"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 fw-bold">{{ number_format($stats['total_karyawan']) }}</h4>
                            <p class="text-muted mb-0 small">Total Karyawan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card shadow-sm border-0 hover-shadow-md transition-all">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-md bg-label-success rounded-circle me-3 d-flex align-items-center justify-content-center">
                            <i class="ti ti-user-check fs-3"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 fw-bold">{{ number_format($stats['aktif']) }}</h4>
                            <p class="text-muted mb-0 small">Karyawan Aktif</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card shadow-sm border-0 hover-shadow-md transition-all">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-md bg-label-danger rounded-circle me-3 d-flex align-items-center justify-content-center">
                            <i class="ti ti-user-x fs-3"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 fw-bold">{{ number_format($stats['nonaktif']) }}</h4>
                            <p class="text-muted mb-0 small">Karyawan Nonaktif</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card shadow-sm border-0 hover-shadow-md transition-all">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-md bg-label-info rounded-circle me-3 d-flex align-items-center justify-content-center">
                            <i class="ti ti-building fs-3"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 fw-bold">{{ number_format($stats['total_unit']) }}</h4>
                            <p class="text-muted mb-0 small">Total Unit</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('karyawan.index') }}">
                <div class="row align-items-end g-3">
                    <div class="col-lg-6 col-md-6">
                        <label class="form-label text-muted small fw-bold">Cari Berdasarkan Nama</label>
                        <div class="input-group input-group-merge border shadow-none rounded-2" style="border-color: #e0e0e0 !important;">
                            <span class="input-group-text bg-white border-0"><i class="ti ti-search text-primary"></i></span>
                            <input type="text" name="nama_lengkap" class="form-control bg-white border-0 ps-2"
                                placeholder="Ketik nama karyawan..." value="{{ Request('nama_lengkap') }}">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <label class="form-label text-muted small fw-bold">Filter Unit</label>
                        <select name="kode_unit" class="form-select border shadow-none rounded-2 select2" style="border-color: #e0e0e0 !important;">
                            <option value="">Semua Unit</option>
                            @foreach ($units as $u)
                                <option value="{{ $u->kode_unit }}" {{ Request('kode_unit') == $u->kode_unit ? 'selected' : '' }}>
                                    {{ $u->nama_unit }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-2">
                        <button type="submit" class="btn btn-primary w-100 shadow-none py-2">
                            <i class="ti ti-adjustments-horizontal me-1"></i> Cari
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

        <div class="row g-3">
            @forelse ($karyawan as $d)
                <div class="col-12">
                    <div class="card border-0 shadow-sm hover-shadow-md transition-all">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                                <!-- Info Karyawan -->
                                <div class="d-flex align-items-center gap-3 flex-grow-1">
                                    <div class="avatar avatar-xl position-relative">
                                        @if (!empty($d->foto))
                                            @if (Storage::disk('public')->exists('photos/karyawan/' . $d->foto))
                                                <img src="{{ getfotoKaryawan($d->foto) }}" alt="{{ $d->nama_lengkap }}"
                                                    class="rounded-3 object-cover shadow-sm w-100 h-100">
                                            @else
                                                <img src="{{ asset('assets/img/avatars/No_Image_Available.jpg') }}"
                                                    alt="No Image" class="rounded-3 shadow-sm w-100 h-100">
                                            @endif
                                        @else
                                            <div
                                                class="avatar-initial rounded-3 bg-label-{{ $d->status == 1 ? 'success' : 'danger' }} fw-bold fs-4">
                                                {{ substr($d->nama_lengkap, 0, 1) }}
                                            </div>
                                        @endif
                                        <div class="position-absolute bottom-0 end-0 p-1">
                                            <span class="badge badge-dot bg-{{ $d->status == 1 ? 'success' : 'danger' }} border-2 border-white"
                                                style="width: 12px; height: 12px;"></span>
                                        </div>
                                    </div>

                                    <div>
                                        <div class="d-flex align-items-center gap-2 mb-1">
                                            <h5 class="mb-0 fw-bold">{{ $d->nama_lengkap }}</h5>
                                            <span class="badge bg-label-secondary border-0 rounded-pill small px-2 py-0">
                                                {{ $d->npp }}
                                            </span>
                                        </div>
                                        <div class="d-flex flex-wrap gap-2 text-muted small mt-1">
                                            <span class="d-flex align-items-center gap-1">
                                                <i class="ti ti-briefcase text-primary fs-6"></i> {{ $d->nama_jabatan }}
                                            </span>
                                            <span class="d-none d-md-inline">•</span>
                                            <span class="d-flex align-items-center gap-1">
                                                <i class="ti ti-building text-info fs-6"></i> {{ $d->nama_unit }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Detail Karyawan (Desktop Only or Flex wrap) -->
                                <div class="d-flex align-items-center gap-4 px-3 d-none d-lg-flex">
                                    <div class="text-center">
                                        <p class="mb-0 text-muted small">TMT</p>
                                        <p class="mb-0 fw-semibold">{{ !empty($d->tmt) ? date('d M Y', strtotime($d->tmt)) : '-' }}</p>
                                    </div>
                                    <div class="text-center">
                                        <p class="mb-0 text-muted small">No. HP</p>
                                        <p class="mb-0 fw-semibold">{{ $d->no_hp ?? '-' }}</p>
                                    </div>
                                    <div class="text-center">
                                        <p class="mb-0 text-muted small">Status</p>
                                        <a href="{{ route('karyawan.updatestatus', Crypt::encrypt($d->npp)) }}">
                                            @if ($d->status == 1)
                                                <span class="badge bg-label-success rounded-pill">Aktif</span>
                                            @else
                                                <span class="badge bg-label-danger rounded-pill">Nonaktif</span>
                                            @endif
                                        </a>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="d-flex align-items-center gap-2 border-start ps-3">
                                    <div class="dropdown">
                                        <button class="btn btn-icon btn-label-primary rounded-circle shadow-none" type="button"
                                            data-bs-toggle="dropdown">
                                            <i class="ti ti-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0">
                                            <li>
                                                <h6 class="dropdown-header text-muted small text-uppercase">Opsi Jadwal</h6>
                                            </li>
                                            @can('karyawan.create')
                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center gap-2 btnSetJamkerja" href="#"
                                                        npp="{{ Crypt::encrypt($d->npp) }}">
                                                        <i class="ti ti-device-watch text-primary"></i> Atur Jam Kerja
                                                    </a>
                                                </li>
                                            @endcan
                                            <li>
                                                <a class="dropdown-item d-flex align-items-center gap-2 btnSetharikerja" href="#"
                                                    npp="{{ Crypt::encrypt($d->npp) }}">
                                                    <i class="ti ti-clock-check text-warning"></i> Atur Hari Kerja
                                                </a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li>
                                                <h6 class="dropdown-header text-muted small text-uppercase">Opsi Data</h6>
                                            </li>
                                            @can('karyawan.edit')
                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center gap-2 editKaryawan" href="#"
                                                        npp="{{ Crypt::encrypt($d->npp) }}">
                                                        <i class="ti ti-edit text-success"></i> Edit Profil
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('karyawan.show')
                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center gap-2"
                                                        href="{{ route('karyawan.show', Crypt::encrypt($d->npp)) }}">
                                                        <i class="ti ti-file-description text-info"></i> Detail Lengkap
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('karyawan.createuser')
                                                <li>
                                                    @if (empty($d->id_user))
                                                        <a class="dropdown-item d-flex align-items-center gap-2"
                                                            href="{{ route('karyawan.createuser', Crypt::encrypt($d->npp)) }}">
                                                            <i class="ti ti-user-plus text-danger"></i> Buat Akses User
                                                        </a>
                                                    @else
                                                        <span class="dropdown-item d-flex align-items-center gap-2 disabled text-muted">
                                                            <i class="ti ti-user text-muted"></i> User Sudah Ada
                                                        </span>
                                                    @endif
                                                </li>
                                            @endcan
                                            @can('karyawan.delete')
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li>
                                                    <form method="POST" name="deleteform" class="deleteform"
                                                        action="{{ route('karyawan.delete', Crypt::encrypt($d->npp)) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <a class="dropdown-item d-flex align-items-center gap-2 delete-confirm text-danger"
                                                            href="#">
                                                            <i class="ti ti-trash"></i> Hapus Karyawan
                                                        </a>
                                                    </form>
                                                </li>
                                            @endcan
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="card border-dashed p-5 text-center">
                        <div class="card-body">
                            <i class="ti ti-users-off fs-1 text-muted mb-3 d-block"></i>
                            <h5 class="text-muted">Tidak ada data karyawan ditemukan</h5>
                            <p class="text-muted mb-0 small">Coba sesuaikan kata kunci pencarian Anda</p>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="mt-4 d-flex justify-content-end">
            {{ $karyawan->links() }}
        </div>
    </div>
</div>

<style>
    .hover-shadow-md:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08) !important;
    }

    .transition-all {
        transition: all 0.2s ease-in-out;
    }

    .object-cover {
        object-fit: cover;
    }

    .avatar-xl {
        width: 60px;
        height: 60px;
    }

    .dropdown-item i {
        font-size: 1.1rem;
    }

    .cursor-pointer {
        cursor: pointer;
    }

    /* Z-index Fix for Dropdowns in Cards */
    .card {
        overflow: visible !important;
        position: relative;
    }

    .col-12:has(.dropdown-menu.show) {
        z-index: 1050;
        position: relative;
    }
</style>

<x-modal-form id="mdlcreateKaryawan" size="" show="loadcreateKaryawan" title="Tambah Karyawan" />
<x-modal-form id="mdleditKaryawan" size="" show="loadeditKaryawan" title="Edit Karyawan" />
<x-modal-form id="mdlsetharikerja" size="" show="loadsetharikerja" title="Set Hari Kerja" />
<x-modal-form id="modalSetJamkerja" show="loadmodalSetJamkerja" size="modal-lg" title="Set Jam Kerja" />
@endsection
@push('myscript')
{{-- <script src="{{ asset('assets/js/pages/roles/create.js') }}"></script> --}}
<script>
    $(function() {
        $("#btncreateKaryawan").click(function(e) {
            e.preventDefault();
            $('#mdlcreateKaryawan').modal("show");
            $("#loadcreateKaryawan").load('/karyawan/create');
        });

        $(".editKaryawan").click(function(e) {
            var npp = $(this).attr("npp");
            e.preventDefault();
            $('#mdleditKaryawan').modal("show");
            $("#loadeditKaryawan").load('/karyawan/' + npp + '/edit');
        });

        $(".btnSetharikerja").click(function(e) {
            var npp = $(this).attr("npp");
            e.preventDefault();
            $('#mdlsetharikerja').modal("show");
            $("#loadsetharikerja").load('/karyawan/' + npp + '/setharikerja');
        });

        $(".btnSetJamkerja").click(function() {
            const npp = $(this).attr("npp");
            $("#modalSetJamkerja").modal("show");
            $("#loadmodalSetJamkerja").html(`<div class="sk-wave sk-primary" style="margin:auto">
            <div class="sk-wave-rect"></div>
            <div class="sk-wave-rect"></div>
            <div class="sk-wave-rect"></div>
            <div class="sk-wave-rect"></div>
            <div class="sk-wave-rect"></div>
            </div>`);

            $("#loadmodalSetJamkerja").load(`/karyawan/${npp}/setjamkerja`);
        });
    });
</script>
@endpush

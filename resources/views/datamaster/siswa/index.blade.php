@extends('layouts.app')
@section('titlepage', 'Siswa')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-primary rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-school fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold text-primary">Data Siswa</h4>
                        <p class="text-muted mb-0 small">Manajemen data dan administrasi siswa</p>
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
                                <i class="ti ti-school me-1"></i> Siswa
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
        @can('siswa.create')
            <button class="btn btn-primary d-flex align-items-center gap-2 shadow-sm" id="btnCreate">
                <i class="ti ti-plus fs-4"></i>
                <span>Tambah Siswa</span>
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
                            <h4 class="mb-0 fw-bold">{{ number_format($stats['total_siswa']) }}</h4>
                            <p class="text-muted mb-0 small">Total Siswa</p>
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
                            <h4 class="mb-0 fw-bold">{{ number_format($stats['laki_laki']) }}</h4>
                            <p class="text-muted mb-0 small">Laki-laki</p>
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
                            <h4 class="mb-0 fw-bold">{{ number_format($stats['perempuan']) }}</h4>
                            <p class="text-muted mb-0 small">Perempuan</p>
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
                            <i class="ti ti-calendar-plus fs-3"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 fw-bold">{{ number_format($stats['siswa_baru']) }}</h4>
                            <p class="text-muted mb-0 small">Siswa Baru</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('siswa.index') }}">
                <div class="row align-items-end g-3">
                    <div class="col-lg-6 col-md-6">
                        <label class="form-label text-muted small fw-bold">Cari Berdasarkan Nama</label>
                        <div class="input-group input-group-merge border shadow-none rounded-2" style="border-color: #e0e0e0 !important;">
                            <span class="input-group-text bg-white border-0"><i class="ti ti-search text-primary"></i></span>
                            <input type="text" name="nama_lengkap" class="form-control bg-white border-0 ps-2"
                                placeholder="Ketik nama siswa..." value="{{ Request('nama_lengkap') }}">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <label class="form-label text-muted small fw-bold">Tahun Masuk</label>
                        <select name="tahun_masuk" class="form-select border shadow-none rounded-2" style="border-color: #e0e0e0 !important;">
                            <option value="">Semua Tahun</option>
                            @foreach ($list_tahun_masuk as $t)
                                <option value="{{ $t->tahun_masuk }}" {{ Request('tahun_masuk') == $t->tahun_masuk ? 'selected' : '' }}>
                                    {{ $t->tahun_masuk }}
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
        @forelse ($siswa as $d)
            <div class="col-12">
                <div class="card border-0 shadow-sm hover-shadow-md transition-all">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                            <!-- Info Siswa -->
                            <div class="d-flex align-items-center gap-3 flex-grow-1">
                                <div class="avatar avatar-xl position-relative">
                                    <div class="avatar-initial rounded-3 bg-label-{{ $d->jenis_kelamin == 'L' ? 'primary' : 'danger' }} fw-bold fs-4">
                                        {{ substr($d->nama_lengkap, 0, 1) }}
                                    </div>
                                    <div class="position-absolute bottom-0 end-0 p-1">
                                        <span class="badge badge-dot bg-{{ $d->jenis_kelamin == 'L' ? 'primary' : 'danger' }} border-2 border-white"
                                            style="width: 12px; height: 12px;"></span>
                                    </div>
                                </div>

                                <div>
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <h5 class="mb-0 fw-bold">{{ $d->nama_lengkap }}</h5>
                                        <span class="badge bg-label-secondary border-0 rounded-pill small px-2 py-0">
                                            {{ $d->id_siswa }}
                                        </span>
                                    </div>
                                    <div class="d-flex flex-wrap gap-2 text-muted small mt-1">
                                        <span class="d-flex align-items-center gap-1">
                                            <i class="ti ti-id-badge text-primary fs-6"></i> {{ $d->nisn }}
                                        </span>
                                        <span class="d-none d-md-inline">•</span>
                                        <span class="d-flex align-items-center gap-1">
                                            <i class="ti ti-calendar-event text-warning fs-6"></i> lahir: {{ !empty($d->tanggal_lahir) ? date('d M Y', strtotime($d->tanggal_lahir)) : '-' }}
                                        </span>
                                        <span class="d-none d-md-inline">•</span>
                                        <span class="d-flex align-items-center gap-1">
                                            <i class="ti ti-calendar-time text-success fs-6"></i> Masuk: {{ $d->tahun_masuk }}
                                        </span>
                                    </div>
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
                                            <h6 class="dropdown-header text-muted small text-uppercase">Opsi Data</h6>
                                        </li>
                                        @can('siswa.edit')
                                            <li>
                                                <a class="dropdown-item d-flex align-items-center gap-2 btnEdit" href="#"
                                                    id_siswa="{{ Crypt::encrypt($d->id_siswa) }}">
                                                    <i class="ti ti-edit text-success"></i> Edit Data
                                                </a>
                                            </li>
                                        @endcan
                                        @can('siswa.show')
                                            <li>
                                                <a class="dropdown-item d-flex align-items-center gap-2"
                                                    href="{{ route('siswa.show', Crypt::encrypt($d->id_siswa)) }}">
                                                    <i class="ti ti-file-description text-info"></i> Detail Lengkap
                                                </a>
                                            </li>
                                        @endcan
                                        @can('siswa.delete')
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li>
                                                <form method="POST" name="deleteform" class="deleteform"
                                                    action="{{ route('siswa.delete', Crypt::encrypt($d->id_siswa)) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a class="dropdown-item d-flex align-items-center gap-2 delete-confirm text-danger"
                                                        href="#">
                                                        <i class="ti ti-trash"></i> Hapus Siswa
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
            <div class="col-12 mt-4">
                <div class="card shadow-none bg-label-secondary border-dashed text-center p-5">
                    <div class="mb-3">
                        <i class="ti ti-users-plus fs-1 opacity-25"></i>
                    </div>
                    <h5>Belum Ada Data Siswa</h5>
                    <p class="text-muted">Silahkan tambah data baru atau sesuaikan filter pencarian.</p>
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-4 d-flex justify-content-end">
        {{ $siswa->links() }}
    </div>
</div>
<x-modal-form id="modal" size="modal-lg" show="loadmodal" title="" />
@endsection
@push('myscript')
{{-- <script src="{{ asset('assets/js/pages/roles/create.js') }}"></script> --}}
<script>
    $(function() {
        $("#btnCreate").click(function(e) {
            e.preventDefault();
            $("#modal").modal("show");
            $(".modal-title").text("Tambah Data Siswa");
            $("#loadmodal").load(`/siswa/create`);
        });

        $(".btnEdit").click(function(e) {
            e.preventDefault();
            var id_siswa = $(this).attr("id_siswa");
            e.preventDefault();
            $("#modal").modal("show");
            $(".modal-title").text("Edit Data Siswa");
            $("#loadmodal").load(`/siswa/${id_siswa}/edit`);
        });
    });
</script>
@endpush

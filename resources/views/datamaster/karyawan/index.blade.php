@extends('layouts.app')
@section('titlepage', 'Karyawan')

@section('content')
<style>
    .form-filter .form-group {
        margin-bottom: 0 !important;
    }
</style>
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-users fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Data Karyawan</h4>
                        <p class="text-muted mb-0 small">Manajemen data dan akses karyawan</p>
                    </div>
                </div>
                <div class="d-flex flex-column align-items-end">
                    <nav aria-label="breadcrumb" class="mb-2">
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
                    @can('karyawan.create')
                        <button class="btn btn-primary d-flex align-items-center gap-2 shadow-sm" id="btncreateKaryawan" style="background-color: #064e3b; border-color: #064e3b">
                            <i class="ti ti-plus fs-5"></i>
                            <span>Tambah Karyawan</span>
                        </button>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection

<div class="row">
    <div class="col-lg-12">
        <!-- Statistics Section -->
        <div class="row g-3 mb-4">
            <div class="col-sm-6 col-xl-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body py-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-md bg-label-success rounded-circle me-3 d-flex align-items-center justify-content-center">
                                <i class="ti ti-users fs-3"></i>
                            </div>
                            <div>
                                <h4 class="mb-0 fw-bold">{{ number_format($stats['total_karyawan']) }}</h4>
                                <p class="text-muted mb-0 small text-uppercase" style="font-size: 0.65rem; letter-spacing: 0.5px;">Total Karyawan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body py-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-md bg-label-success rounded-circle me-3 d-flex align-items-center justify-content-center">
                                <i class="ti ti-user-check fs-3"></i>
                            </div>
                            <div>
                                <h4 class="mb-0 fw-bold">{{ number_format($stats['aktif']) }}</h4>
                                <p class="text-muted mb-0 small text-uppercase" style="font-size: 0.65rem; letter-spacing: 0.5px;">Karyawan Aktif</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body py-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-md bg-label-danger rounded-circle me-3 d-flex align-items-center justify-content-center">
                                <i class="ti ti-user-x fs-3"></i>
                            </div>
                            <div>
                                <h4 class="mb-0 fw-bold">{{ number_format($stats['nonaktif']) }}</h4>
                                <p class="text-muted mb-0 small text-uppercase" style="font-size: 0.65rem; letter-spacing: 0.5px;">Karyawan Nonaktif</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body py-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-md bg-label-info rounded-circle me-3 d-flex align-items-center justify-content-center">
                                <i class="ti ti-building fs-3"></i>
                            </div>
                            <div>
                                <h4 class="mb-0 fw-bold">{{ number_format($stats['total_unit']) }}</h4>
                                <p class="text-muted mb-0 small text-uppercase" style="font-size: 0.65rem; letter-spacing: 0.5px;">Total Unit</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Form -->
        <div class="card mb-4 shadow-none border-0 bg-transparent">
            <div class="card-body p-0">
                <form action="{{ route('karyawan.index') }}" class="form-filter">
                    <div class="row g-3 align-items-center">
                        <div class="col-lg-4 col-md-4">
                            <x-input-with-icon label="" value="{{ Request('nama_lengkap') }}" name="nama_lengkap"
                                placeholder="Cari Nama Karyawan" icon="ti ti-search" />
                        </div>
                        <div class="col-lg-3 col-md-3">
                            <div class="form-group">
                                <select name="kode_unit" class="form-select border-0 shadow-sm border" style="border-color: #e0e0e0 !important;">
                                    <option value="">Semua Unit</option>
                                    @foreach ($units as $u)
                                        <option value="{{ $u->kode_unit }}" {{ Request('kode_unit') == $u->kode_unit ? 'selected' : '' }}>
                                            {{ $u->nama_unit }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3">
                            <div class="form-group">
                                <select name="kode_dept" class="form-select border-0 shadow-sm border" style="border-color: #e0e0e0 !important;">
                                    <option value="">Semua Departemen</option>
                                    @foreach ($departemen as $dept)
                                        <option value="{{ $dept->kode_dept }}" {{ Request('kode_dept') == $dept->kode_dept ? 'selected' : '' }}>
                                            {{ $dept->nama_dept }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2">
                            <button type="submit" class="btn btn-primary w-100 p-2 d-flex align-items-center justify-content-center gap-2" style="background-color: #064e3b; border-color: #064e3b">
                                <i class="ti ti-search fs-5"></i>
                                <span>Cari</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Data List -->
        <div class="row g-2">
            @forelse ($karyawan as $d)
                <div class="col-12">
                    <div class="card shadow-sm border-0 h-100" style="border-left: 4px solid #064e3b !important;">
                        <div class="card-body p-3">
                            <div class="row align-items-center">
                                <!-- Info Karyawan -->
                                <div class="col-lg-4 col-md-6">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-lg me-3 position-relative">
                                            @if (!empty($d->foto) && Storage::disk('public')->exists('photos/karyawan/' . $d->foto))
                                                <img src="{{ getfotoKaryawan($d->foto) }}" alt="{{ $d->nama_lengkap }}"
                                                    class="rounded object-cover shadow-sm w-100 h-100">
                                            @else
                                                <div class="avatar-initial rounded bg-label-{{ $d->status == 1 ? 'success' : 'danger' }} fw-bold">
                                                    {{ substr($d->nama_lengkap, 0, 1) }}
                                                </div>
                                            @endif
                                            <span class="position-absolute bottom-0 end-0 badge badge-dot bg-{{ $d->status == 1 ? 'success' : 'danger' }} border-2 border-white"></span>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold text-dark">{{ $d->nama_lengkap }}</h6>
                                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                                <span class="text-muted small"><i class="ti ti-id me-1"></i>{{ $d->npp }}</span>
                                                <span class="badge bg-label-secondary" style="font-size: 0.65rem">{{ $d->nama_unit }}</span>
                                                @if (!empty($d->nama_dept))
                                                    <span class="badge bg-label-primary" style="font-size: 0.65rem">{{ $d->nama_dept }}</span>
                                                @endif
                                                @if (!empty($d->id_user))
                                                    <span class="badge bg-label-success" style="font-size: 0.65rem"><i class="ti ti-shield-check me-1"></i>Has User</span>
                                                @else
                                                    <span class="badge bg-label-warning" style="font-size: 0.65rem"><i class="ti ti-shield-x me-1"></i>No User</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Detail Karyawan -->
                                <div class="col-lg-3 col-md-6 border-start-lg ps-lg-4 mt-2 mt-md-0">
                                    <div class="d-flex flex-column gap-1">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="ti ti-briefcase text-success small"></i>
                                            <span class="fw-bold text-dark small">{{ $d->nama_jabatan }}</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="ti ti-calendar-event text-info small"></i>
                                            <span class="text-muted small">TMT: {{ !empty($d->tmt) ? date('d M Y', strtotime($d->tmt)) : '-' }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Contact & Status -->
                                <div class="col-lg-3 col-md-6 border-start-lg ps-lg-4 mt-2 mt-lg-0">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="text-center">
                                            <p class="mb-1 text-muted small" style="font-size: 0.6rem">STATUS</p>
                                            <a href="{{ route('karyawan.updatestatus', Crypt::encrypt($d->npp)) }}">
                                                @if ($d->status == 1)
                                                    <span class="badge bg-label-success rounded-pill px-3">AKTIF</span>
                                                @else
                                                    <span class="badge bg-label-danger rounded-pill px-3">OFF</span>
                                                @endif
                                            </a>
                                        </div>
                                        <div class="border-start ps-3">
                                            <p class="mb-0 text-muted small" style="font-size: 0.6rem">HUBUNGI</p>
                                            <span class="fw-semibold small text-dark"><i class="ti ti-device-mobile me-1 small"></i>{{ $d->no_hp ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="col-lg-2 col-md-6 text-end mt-3 mt-lg-0">
                                    <div class="d-flex justify-content-end gap-1">
                                        <div class="dropdown">
                                            <button class="btn btn-icon btn-label-success border rounded shadow-none" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false" style="width: 32px; height: 32px;">
                                                <i class="ti ti-dots-vertical fs-5"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0">
                                                <li><h6 class="dropdown-header text-muted small text-uppercase" style="font-size: 0.6rem">Pengaturan Kerja</h6></li>
                                                @can('karyawan.create')
                                                    <li><a class="dropdown-item d-flex align-items-center gap-2 btnSetJamkerja" href="#" npp="{{ Crypt::encrypt($d->npp) }}"><i class="ti ti-clock text-primary"></i> Atur Jam Kerja</a></li>
                                                @endcan
                                                <li><a class="dropdown-item d-flex align-items-center gap-2 btnSetharikerja" href="#" npp="{{ Crypt::encrypt($d->npp) }}"><i class="ti ti-calendar text-warning"></i> Atur Hari Kerja</a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><h6 class="dropdown-header text-muted small text-uppercase" style="font-size: 0.6rem">Data Karyawan</h6></li>
                                                @can('karyawan.edit')
                                                    <li><a class="dropdown-item d-flex align-items-center gap-2 editKaryawan" href="#" npp="{{ Crypt::encrypt($d->npp) }}"><i class="ti ti-edit text-success"></i> Edit Profil</a></li>
                                                @endcan
                                                @can('karyawan.show')
                                                    <li><a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('karyawan.show', Crypt::encrypt($d->npp)) }}"><i class="ti ti-file-description text-info"></i> Detail Lengkap</a></li>
                                                @endcan
                                                @if (!empty($d->id_user))
                                                    @can('karyawan.create')
                                                        <li><a class="dropdown-item d-flex align-items-center gap-2 reset-user-confirm" href="{{ route('karyawan.resetuser', Crypt::encrypt($d->npp)) }}"><i class="ti ti-rotate text-warning"></i> Reset Password User</a></li>
                                                        <li><a class="dropdown-item d-flex align-items-center gap-2 delete-user-confirm text-danger" href="{{ route('karyawan.deleteuser', Crypt::encrypt($d->npp)) }}"><i class="ti ti-user-x"></i> Hapus Akses User</a></li>
                                                    @endcan
                                                @else
                                                    @can('karyawan.create')
                                                        <li><a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('karyawan.createuser', Crypt::encrypt($d->npp)) }}"><i class="ti ti-user-plus text-primary"></i> Buat User Default</a></li>
                                                    @endcan
                                                @endif
                                                @can('karyawan.delete')
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <form method="POST" class="deleteform" action="{{ route('karyawan.delete', Crypt::encrypt($d->npp)) }}">
                                                            @csrf @method('DELETE')
                                                            <a class="dropdown-item d-flex align-items-center gap-2 delete-confirm text-danger" href="#"><i class="ti ti-trash"></i> Hapus Karyawan</a>
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
                </div>
            @empty
                <div class="col-12 text-center p-5 bg-white rounded shadow-sm">
                    <i class="ti ti-users-off fs-1 opacity-25 d-block mb-3"></i>
                    <h5 class="text-muted">Tidak ada data karyawan ditemukan</h5>
                    <p class="text-muted small">Coba sesuaikan kata kunci pencarian Anda</p>
                </div>
            @endforelse
            
            <div class="col-12 mt-4">
                <div class="d-flex justify-content-end">
                    {{ $karyawan->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<x-modal-form id="mdlcreateKaryawan" size="" show="loadcreateKaryawan" title="Tambah Karyawan" icon="ti ti-user-plus" />
<x-modal-form id="mdleditKaryawan" size="" show="loadeditKaryawan" title="Edit Karyawan" icon="ti ti-user-edit" />
<x-modal-form id="mdlsetharikerja" size="" show="loadsetharikerja" title="Set Hari Kerja" icon="ti ti-calendar-check" />
<x-modal-form id="modalSetJamkerja" show="loadmodalSetJamkerja" size="modal-lg" title="Set Jam Kerja" icon="ti ti-clock-plus" />

@endsection

@push('myscript')
<script>
    $(function() {
        $("#btncreateKaryawan").click(function(e) {
            e.preventDefault();
            $('#mdlcreateKaryawan').modal("show");
            $("#loadcreateKaryawan").load('/karyawan/create');
        });

        $(document).on('click', '.editKaryawan', function(e) {
            var npp = $(this).attr("npp");
            e.preventDefault();
            $('#mdleditKaryawan').modal("show");
            $("#loadeditKaryawan").load('/karyawan/' + npp + '/edit');
        });

        $(document).on('click', ".btnSetharikerja", function(e) {
            var npp = $(this).attr("npp");
            e.preventDefault();
            $('#mdlsetharikerja').modal("show");
            $("#loadsetharikerja").load('/karyawan/' + npp + '/setharikerja');
        });

        $(document).on('click', ".btnSetJamkerja", function() {
            const npp = $(this).attr("npp");
            $("#modalSetJamkerja").modal("show");
            $("#loadmodalSetJamkerja").load(`/karyawan/${npp}/setjamkerja`);
        });

        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // Delete Confirm
        $(document).on('click', ".delete-confirm", function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            Swal.fire({
                title: 'Hapus data karyawan?',
                text: "Seluruh data terkait karyawan ini akan dihapus permanen!",
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

        // Reset User Confirm
        $(document).on('click', ".reset-user-confirm", function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            Swal.fire({
                title: 'Reset Password User?',
                text: "Password user akan di-reset kembali ke default (12345678)!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#064e3b',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, reset!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        });

        // Delete User Confirm
        $(document).on('click', ".delete-user-confirm", function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            Swal.fire({
                title: 'Hapus Akses User?',
                text: "Akun login karyawan ini akan dihapus permanen, tetapi data karyawan tetap ada!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        });
    });
</script>
@endpush

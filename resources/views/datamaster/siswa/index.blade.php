@extends('layouts.app')
@section('titlepage', 'Siswa')

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
                        <i class="ti ti-school fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Data Siswa</h4>
                        <p class="text-muted mb-0 small">Manajemen data dan administrasi siswa</p>
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
                                <i class="ti ti-school me-1"></i> Siswa
                            </li>
                        </ol>
                    </nav>
                    @can('siswa.create')
                        <button class="btn btn-primary d-flex align-items-center gap-2 shadow-sm" id="btnCreate" style="background-color: #064e3b; border-color: #064e3b">
                            <i class="ti ti-plus fs-5"></i>
                            <span>Tambah Siswa</span>
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
                                <h4 class="mb-0 fw-bold">{{ number_format($stats['total_siswa']) }}</h4>
                                <p class="text-muted mb-0 small text-uppercase" style="font-size: 0.65rem; letter-spacing: 0.5px;">Total Siswa</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body py-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-md bg-label-primary rounded-circle me-3 d-flex align-items-center justify-content-center">
                                <i class="ti ti-user-check fs-3"></i>
                            </div>
                            <div>
                                <h4 class="mb-0 fw-bold">{{ number_format($stats['laki_laki']) }}</h4>
                                <p class="text-muted mb-0 small text-uppercase" style="font-size: 0.65rem; letter-spacing: 0.5px;">Laki-laki</p>
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
                                <h4 class="mb-0 fw-bold">{{ number_format($stats['perempuan']) }}</h4>
                                <p class="text-muted mb-0 small text-uppercase" style="font-size: 0.65rem; letter-spacing: 0.5px;">Perempuan</p>
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
                                <i class="ti ti-calendar-plus fs-3"></i>
                            </div>
                            <div>
                                <h4 class="mb-0 fw-bold">{{ number_format($stats['siswa_baru']) }}</h4>
                                <p class="text-muted mb-0 small text-uppercase" style="font-size: 0.65rem; letter-spacing: 0.5px;">Siswa Baru</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Form -->
        <div class="card mb-4 shadow-none border-0 bg-transparent">
            <div class="card-body p-0">
                <form action="{{ route('siswa.index') }}" class="form-filter">
                    <div class="row g-3 align-items-center">
                        <div class="col-lg-7 col-md-6">
                            <x-input-with-icon label="" value="{{ Request('nama_lengkap') }}" name="nama_lengkap"
                                placeholder="Cari Nama Siswa" icon="ti ti-search" />
                        </div>
                        <div class="col-lg-3 col-md-4">
                            <div class="form-group">
                                <select name="tahun_masuk" class="form-select border-0 shadow-sm border" style="border-color: #e0e0e0 !important;">
                                    <option value="">Semua Tahun Masuk</option>
                                    @foreach ($list_tahun_masuk as $t)
                                        <option value="{{ $t->tahun_masuk }}"
                                            {{ Request('tahun_masuk') == $t->tahun_masuk ? 'selected' : '' }}>
                                            {{ $t->tahun_masuk }}
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
            @forelse ($siswa as $d)
                <div class="col-12">
                    <div class="card shadow-sm border-0 h-100" style="border-left: 4px solid #064e3b !important;">
                        <div class="card-body p-3">
                            <div class="row align-items-center">
                                <!-- Info Siswa -->
                                <div class="col-lg-4 col-md-6">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-md me-3 position-relative">
                                            <div class="avatar-initial rounded bg-label-{{ $d->jenis_kelamin == 'L' ? 'success' : 'danger' }} fw-bold">
                                                {{ substr($d->nama_lengkap, 0, 1) }}
                                            </div>
                                            <span class="position-absolute bottom-0 end-0 badge badge-dot bg-{{ $d->jenis_kelamin == 'L' ? 'success' : 'danger' }} border-2 border-white"></span>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold text-dark">{{ $d->nama_lengkap }}</h6>
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="text-muted small"><i class="ti ti-id me-1"></i>{{ $d->id_siswa }}</span>
                                                <span class="badge bg-label-secondary" style="font-size: 0.65rem">NISN: {{ $d->nisn }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Detail Siswa -->
                                <div class="col-lg-3 col-md-6 border-start-lg ps-lg-4 mt-2 mt-md-0">
                                    <div class="d-flex flex-column gap-1">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="ti ti-calendar-event text-warning small"></i>
                                            <span class="text-muted small">Lahir: {{ !empty($d->tanggal_lahir) ? date('d M Y', strtotime($d->tanggal_lahir)) : '-' }}</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="ti ti-calendar-time text-info small"></i>
                                            <span class="text-muted small">Tahun Masuk: <span class="fw-bold text-dark">{{ $d->tahun_masuk }}</span></span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Gender & Status -->
                                <div class="col-lg-3 col-md-6 border-start-lg ps-lg-4 mt-2 mt-lg-0">
                                    <div class="d-flex align-items-center gap-4">
                                        <div class="text-center">
                                            <p class="mb-1 text-muted small" style="font-size: 0.6rem">JENIS KELAMIN</p>
                                            <span class="badge bg-label-{{ $d->jenis_kelamin == 'L' ? 'success' : 'danger' }} rounded-pill px-3">
                                                {{ $d->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                            </span>
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
                                                <li><h6 class="dropdown-header text-muted small text-uppercase" style="font-size: 0.6rem">Manajemen Data</h6></li>
                                                @can('siswa.edit')
                                                    <li><a class="dropdown-item d-flex align-items-center gap-2 btnEdit" href="#" id_siswa="{{ Crypt::encrypt($d->id_siswa) }}"><i class="ti ti-edit text-success"></i> Edit Data</a></li>
                                                @endcan
                                                @can('siswa.show')
                                                    <li><a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('siswa.show', Crypt::encrypt($d->id_siswa)) }}"><i class="ti ti-file-description text-info"></i> Detail Lengkap</a></li>
                                                @endcan
                                                @can('siswa.delete')
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <form method="POST" class="deleteform" action="{{ route('siswa.delete', Crypt::encrypt($d->id_siswa)) }}">
                                                            @csrf @method('DELETE')
                                                            <a class="dropdown-item d-flex align-items-center gap-2 delete-confirm text-danger" href="#"><i class="ti ti-trash"></i> Hapus Siswa</a>
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
                    <i class="ti ti-school-off fs-1 opacity-25 d-block mb-3"></i>
                    <h5 class="text-muted">Tidak ada data siswa ditemukan</h5>
                    <p class="text-muted small">Coba sesuaikan kata kunci pencarian Anda</p>
                </div>
            @endforelse
            
            <div class="col-12 mt-4">
                <div class="d-flex justify-content-end">
                    {{ $siswa->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<x-modal-form id="modal" size="modal-lg" show="loadmodal" title="Form Data Siswa" icon="ti ti-school" />

@endsection

@push('myscript')
<script>
    $(function() {
        $("#btnCreate").click(function(e) {
            e.preventDefault();
            $("#modal").modal("show");
            $(".modal-title").text("Tambah Data Siswa");
            $("#loadmodal").load(`/siswa/create`);
        });

        $(document).on('click', ".btnEdit", function(e) {
            e.preventDefault();
            var id_siswa = $(this).attr("id_siswa");
            $("#modal").modal("show");
            $(".modal-title").text("Edit Data Siswa");
            $("#loadmodal").load(`/siswa/${id_siswa}/edit`);
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
                title: 'Hapus data siswa?',
                text: "Seluruh data akademik terkait siswa ini akan dihapus permanen!",
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

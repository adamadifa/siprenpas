@extends('layouts.app')
@section('titlepage', 'Progress Rapor Siswa')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-file-analytics fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Progress Rapor Siswa</h4>
                        <p class="text-muted mb-0 small">Monitoring pengisian nilai rapor per kelas pada tahun ajaran aktif</p>
                    </div>
                </div>
                <div class="d-flex flex-column align-items-end">
                    <nav aria-label="breadcrumb" class="mb-2">
                        <ol class="breadcrumb breadcrumb-style1 mb-0">
                            <li class="breadcrumb-item">
                                <a href="javascript:void(0);" class="text-muted">
                                    <i class="ti ti-school me-1"></i> Akademik
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                <i class="ti ti-file-analytics me-1"></i> Rapor Siswa
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
        <div class="card mb-4 shadow-none border-0 bg-transparent">
            <div class="card-body p-0">
                <form action="{{ route('rapor-siswa.index') }}" method="GET" class="form-filter">
                    <div class="row g-3 align-items-end">
                        <div class="col-lg-3 col-md-4">
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
                        <div class="col-lg-3 col-md-4">
                            <div class="form-group">
                                <select name="kode_ta" class="form-select border-0 shadow-sm border" style="border-color: #e0e0e0 !important;">
                                    <option value="">Tahun Ajaran</option>
                                    @foreach ($semuaTa as $ta)
                                        <option value="{{ $ta->kode_ta }}" {{ $selectedKodeTa == $ta->kode_ta ? 'selected' : '' }}>
                                            {{ $ta->tahun_ajaran }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4">
                            <div class="form-group">
                                <select name="semester" class="form-select border-0 shadow-sm border" style="border-color: #e0e0e0 !important;">
                                    <option value="">Pilih Semester</option>
                                    <option value="1" {{ $selectedSemester == 1 ? 'selected' : '' }}>Ganjil (1)</option>
                                    <option value="2" {{ $selectedSemester == 2 ? 'selected' : '' }}>Genap (2)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4">
                            <button type="submit" class="btn btn-primary w-100 d-flex align-items-center justify-content-center gap-2" style="background-color: #064e3b; border-color: #064e3b">
                                <i class="ti ti-filter fs-5"></i>
                                <span>Filter</span>
                            </button>
                        </div>
                        <div class="col-lg-1 col-md-4">
                            <a href="{{ route('rapor-siswa.index') }}" class="btn btn-label-secondary w-100 p-2 d-flex align-items-center justify-content-center" data-bs-toggle="tooltip" title="Reset Filter">
                                <i class="ti ti-refresh fs-5"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="ti ti-check me-1"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @php
            $isAdminOrSuper = auth()->user()->hasAnyRole(['super admin', 'admin']);
            $canViewRaporKelas = $isAdminOrSuper || (isset($isWaliKelas) && $isWaliKelas);
            $canViewEkskul = $isAdminOrSuper || (isset($isKoordinator) && $isKoordinator);
        @endphp

        <!-- Tab Navigation -->
        <div class="nav-align-top nav-tabs-shadow mb-4">
            <ul class="nav nav-tabs border-bottom" role="tablist">
                @if($canViewRaporKelas)
                    <li class="nav-item">
                        <button type="button" class="nav-link active py-3 px-4 fw-bold" role="tab" data-bs-toggle="tab" data-bs-target="#navs-progress-kelas" aria-controls="navs-progress-kelas" aria-selected="true" style="letter-spacing: 0.5px;">
                            <i class="ti ti-chart-bar me-1"></i> Monitoring Rapor Kelas
                        </button>
                    </li>
                @endif
                @if($canViewEkskul)
                    <li class="nav-item">
                        <button type="button" class="nav-link {{ !$canViewRaporKelas ? 'active' : '' }} py-3 px-4 fw-bold" role="tab" data-bs-toggle="tab" data-bs-target="#navs-ekskul" aria-controls="navs-ekskul" aria-selected="false" style="letter-spacing: 0.5px;">
                            <i class="ti ti-books me-1"></i> Pengaturan Ekstrakurikuler
                        </button>
                    </li>
                @endif
            </ul>

            <div class="tab-content p-4 bg-white shadow-sm rounded-bottom">
                @if($canViewRaporKelas)
                    <!-- Tab Panel Progress Kelas -->
                    <div class="tab-pane fade show active" id="navs-progress-kelas" role="tabpanel">
                        <div class="card mb-3 shadow-none border-0 bg-transparent">
                            <div class="card-body p-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="m-0 fw-bold" style="color: #064e3b">Monitoring Progress Pengisian Rapor</h5>
                                    <span class="badge bg-label-success">TA: {{ $activeTa->tahun_ajaran ?? '-' }} - Sem. {{ (($activeSemester->semester ?? $selectedSemester) == 1) ? 'Ganjil' : 'Genap' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Data List -->
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    @forelse ($classes as $class)
                                        <div class="col-12">
                                            <div class="card mb-2 border shadow-none transition-all hover-lift">
                                                <div class="card-body p-3">
                                                    <div class="row align-items-center">
                                                        <!-- Kelas & Icon -->
                                                        <div class="col-lg-2 col-md-6 col-sm-12 border-end">
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar me-3 rounded bg-label-success d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;">
                                                                    <i class="ti ti-chalkboard fs-4"></i>
                                                                </div>
                                                                <div>
                                                                    <h6 class="mb-0 fw-bold">{{ $class->nama_kelas }}</h6>
                                                                    <small class="text-muted"><i class="ti ti-building me-1"></i>{{ $class->unit->nama_unit ?? '-' }}</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Wali Kelas -->
                                                        <div class="col-lg-3 col-md-6 col-sm-12 border-end">
                                                            <div class="d-flex flex-column">
                                                                <small class="text-muted">Wali Kelas</small>
                                                                <span class="fw-bold">{{ $class->waliKelas->nama_guru ?? 'Belum Ditentukan' }}</span>
                                                            </div>
                                                        </div>
                                                        <!-- Total Siswa -->
                                                        <div class="col-lg-2 col-md-6 col-sm-12 border-end text-center">
                                                            <small class="d-block text-muted">Total Siswa</small>
                                                            <span class="badge bg-label-primary rounded-circle px-2 py-1">{{ $class->siswa_count }} Siswa</span>
                                                        </div>
                                                        <!-- Progress Rapor -->
                                                        <div class="col-lg-3 col-md-6 col-sm-12 border-end">
                                                            <small class="text-muted d-block">Progress Rapor</small>
                                                            <div class="d-flex align-items-center gap-2">
                                                                <div class="progress w-100" style="height: 8px;">
                                                                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $class->progress }}%;" aria-valuenow="{{ $class->progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                                </div>
                                                                <small class="fw-bold text-success">{{ $class->progress }}%</small>
                                                            </div>
                                                            <small class="text-muted small d-block" style="font-size: 0.7rem;">{{ $class->completed_subjects }}/{{ $class->total_subjects }} Mapel Selesai</small>
                                                        </div>
                                                        <!-- Actions -->
                                                        <div class="col-lg-2 col-md-12 col-sm-12 text-end">
                                                            <a href="{{ route('rapor-siswa.show', $class->kode_kelas) }}" class="btn btn-sm btn-primary py-2 px-3 fw-semibold shadow-sm" style="background-color: #064e3b; border-color: #064e3b">
                                                                <i class="ti ti-eye me-1"></i> Detail Progress
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-12">
                                            <div class="alert alert-warning text-center">
                                                <i class="ti ti-info-circle me-1"></i> Data kelas belum tersedia.
                                            </div>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if($canViewEkskul)
                    <!-- Tab Panel Ekstrakurikuler -->
                    <div class="tab-pane fade {{ !$canViewRaporKelas ? 'show active' : '' }}" id="navs-ekskul" role="tabpanel">
                        <!-- Actions Section -->
                        @if(auth()->check() && auth()->user()->hasAnyRole(['super admin', 'admin']))
                        <div class="d-flex justify-content-start mb-3">
                            <button type="button" class="btn d-flex align-items-center gap-2 shadow-sm text-white" style="background-color: #064e3b" data-bs-toggle="modal" data-bs-target="#modalAddEkskul">
                                <i class="ti ti-plus fs-4"></i>
                                <span>Tambah Ekstrakurikuler</span>
                            </button>
                        </div>
                        @endif

                        <div class="card border shadow-none">
                            <div class="card-header d-flex align-items-center gap-2 text-white py-3" style="background-color: #064e3b">
                                <i class="ti ti-books fs-5"></i>
                                <h6 class="card-title mb-0 text-white">Pengaturan Ekstrakurikuler</h6>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0 text-nowrap">
                                        <thead style="background-color: #064e3b">
                                            <tr>
                                                <th class="text-white py-3" style="width: 50px;">NO</th>
                                                <th class="text-white py-3">NAMA EKSTRAKURIKULER</th>
                                                <th class="text-white py-3">UNIT</th>
                                                <th class="text-white py-3">KOORDINATOR (GURU)</th>
                                                <th class="text-white py-3">TAHUN AJARAN</th>
                                                <th class="text-white py-3 text-end" style="width: 120px;">#</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($ekstrakurikuler as $index => $ekskul)
                                                <tr>
                                                    <td class="py-2">{{ $index + 1 }}</td>
                                                    <td class="py-2 fw-bold text-dark">{{ $ekskul->nama_ekstrakurikuler }}</td>
                                                    <td class="py-2"><span class="badge bg-label-info">{{ $ekskul->unit->nama_unit ?? '-' }}</span></td>
                                                    <td class="py-2">{{ $ekskul->guru->nama_guru ?? '-' }}</td>
                                                    <td class="py-2">{{ $ekskul->tahunAjaran->tahun_ajaran ?? '-' }}</td>
                                                    <td class="py-2 text-end">
                                                        <div class="d-flex justify-content-end gap-1">
                                                            <a href="{{ route('rapor-siswa.ekskul.nilai', $ekskul->id) }}" class="btn btn-icon btn-label-info border text-info" 
                                                                style="width: 28px; height: 28px;" title="Input Nilai & Siswa">
                                                                <i class="ti ti-users fs-6"></i>
                                                            </a>
                                                            @if(auth()->check() && auth()->user()->hasAnyRole(['super admin', 'admin']))
                                                            <button type="button" class="btn btn-icon btn-label-success border" 
                                                                style="width: 28px; height: 28px;"
                                                                data-bs-toggle="modal" data-bs-target="#modalEditEkskul{{ $ekskul->id }}" title="Edit">
                                                                <i class="ti ti-edit fs-6"></i>
                                                            </button>
                                                            <form action="{{ route('rapor-siswa.ekskul.destroy', $ekskul->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ekstrakurikuler ini?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-icon btn-label-danger border" style="width: 28px; height: 28px;" title="Hapus">
                                                                    <i class="ti ti-trash fs-6"></i>
                                                                </button>
                                                            </form>
                                                            @endif
                                                        </div>

                                                        <!-- Modal Edit Ekskul -->
                                                        <div class="modal fade" id="modalEditEkskul{{ $ekskul->id }}" tabindex="-1" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header border-bottom">
                                                                        <h5 class="modal-title fw-bold" style="color: #064e3b">Edit Ekstrakurikuler</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body text-start">
                                                                        <form action="{{ route('rapor-siswa.ekskul.update', $ekskul->id) }}" method="POST">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <div class="form-group mb-3">
                                                                                <label class="form-label fw-bold text-dark">Nama Ekstrakurikuler <span class="text-danger">*</span></label>
                                                                                <input type="text" name="nama_ekstrakurikuler" class="form-control" value="{{ $ekskul->nama_ekstrakurikuler }}" placeholder="Contoh: Pramuka, PMR, Paskibra" required>
                                                                            </div>
                                                                            <div class="form-group mb-3">
                                                                                <label class="form-label fw-bold text-dark">Unit / Jenjang <span class="text-danger">*</span></label>
                                                                                <select name="kode_unit" class="form-select" required>
                                                                                    <option value="">Pilih Unit</option>
                                                                                    @foreach ($units as $u)
                                                                                        <option value="{{ $u->kode_unit }}" {{ $ekskul->kode_unit == $u->kode_unit ? 'selected' : '' }}>
                                                                                            {{ $u->nama_unit }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group mb-3">
                                                                                <label class="form-label fw-bold text-dark">Koordinator (Guru) <span class="text-danger">*</span></label>
                                                                                <select name="guru_id" class="form-select" required>
                                                                                    <option value="">Pilih Koordinator</option>
                                                                                    @foreach ($gurus as $g)
                                                                                        <option value="{{ $g->id }}" {{ $ekskul->guru_id == $g->id ? 'selected' : '' }}>
                                                                                            {{ $g->nama_guru }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <button class="btn btn-primary w-100" type="submit" style="background-color: #064e3b; border-color: #064e3b">
                                                                                    <i class="ti ti-send me-1"></i> Simpan Perubahan
                                                                                </button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center p-5">
                                                        <div class="mb-3">
                                                            <i class="ti ti-books fs-1 opacity-25"></i>
                                                        </div>
                                                        <h5>Belum Ada Data Ekstrakurikuler</h5>
                                                        <p class="text-muted small">Silahkan tambah data baru atau sesuaikan filter pencarian.</p>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Modal Add Ekskul -->
        <div class="modal fade" id="modalAddEkskul" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header border-bottom">
                        <h5 class="modal-title fw-bold" style="color: #064e3b">Tambah Ekstrakurikuler</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-start">
                        <form action="{{ route('rapor-siswa.ekskul.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="kode_ta" value="{{ $selectedKodeTa }}">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold text-dark">Nama Ekstrakurikuler <span class="text-danger">*</span></label>
                                <input type="text" name="nama_ekstrakurikuler" class="form-control" placeholder="Contoh: Pramuka, PMR, Paskibra" required>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold text-dark">Unit / Jenjang <span class="text-danger">*</span></label>
                                <select name="kode_unit" class="form-select" required>
                                    <option value="">Pilih Unit</option>
                                    @foreach ($units as $u)
                                        <option value="{{ $u->kode_unit }}" {{ Request('kode_unit') == $u->kode_unit ? 'selected' : '' }}>{{ $u->nama_unit }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold text-dark">Koordinator (Guru) <span class="text-danger">*</span></label>
                                <select name="guru_id" class="form-select" required>
                                    <option value="">Pilih Koordinator</option>
                                    @foreach ($gurus as $g)
                                        <option value="{{ $g->id }}">{{ $g->nama_guru }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary w-100" type="submit" style="background-color: #064e3b; border-color: #064e3b">
                                    <i class="ti ti-send me-1"></i> Simpan Data
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.hover-lift {
    transition: all 0.2s ease-in-out;
}
.hover-lift:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.08) !important;
    border-color: #064e3b !important;
}
</style>

@endsection

@push('myscript')
<script>
    $(function() {
        // Restore active tab from localStorage if available
        var activeTab = localStorage.getItem('activeTabRaporSiswa');
        if (activeTab) {
            var tabEl = document.querySelector('button[data-bs-target="' + activeTab + '"]');
            if (tabEl) {
                var tab = new bootstrap.Tab(tabEl);
                tab.show();
            }
        }

        // Save active tab target to localStorage on click
        $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
            var target = $(e.target).attr('data-bs-target');
            localStorage.setItem('activeTabRaporSiswa', target);
        });
    });
</script>
@endpush

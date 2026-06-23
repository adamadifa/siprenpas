@extends('layouts.app')
@section('titlepage', 'Detail Progress Rapor')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('rapor-siswa.index') }}" class="btn btn-label-secondary btn-icon rounded-circle" style="color: #064e3b; background-color: rgba(6, 78, 59, 0.08);">
                        <i class="ti ti-arrow-left fs-4"></i>
                    </a>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Detail Progress Rapor - Kelas {{ $class->nama_kelas }}</h4>
                        <p class="text-muted mb-0 small">Monitoring pengisian nilai dan cetak rapor untuk kelas {{ $class->nama_kelas }}</p>
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
                            <li class="breadcrumb-item">
                                <a href="{{ route('rapor-siswa.index') }}" class="text-muted">Rapor Siswa</a>
                            </li>
                            <li class="breadcrumb-item active">Detail</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

<div class="row">
    <div class="col-lg-12">
        <div class="card mb-3 shadow-none border-0 bg-transparent">
            <div class="card-body p-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="m-0 fw-bold" style="color: #064e3b">Wali Kelas: <strong>{{ $class->waliKelas->nama_guru ?? 'Belum ditentukan' }}</strong></h5>
                        <small class="text-muted">Unit: {{ $class->unit->nama_unit ?? '-' }}</small>
                    </div>
                    <span class="badge bg-label-success">TA: {{ $activeTa->tahun_ajaran ?? '-' }} - Sem. {{ (($activeSemester->semester ?? 1) == 1) ? 'Ganjil' : 'Genap' }}</span>
                </div>
            </div>
        </div>

        <!-- Tab Navigation -->
        <div class="nav-align-top nav-tabs-shadow mb-4">
            <ul class="nav nav-tabs border-bottom" role="tablist">
                <li class="nav-item">
                    <button type="button" class="nav-link active py-3 px-4 fw-bold text-uppercase" role="tab" data-bs-toggle="tab" data-bs-target="#navs-progress" aria-controls="navs-progress" aria-selected="true" style="letter-spacing: 0.5px;">
                        <i class="ti ti-chart-bar me-1"></i> Progress Mapel
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link py-3 px-4 fw-bold text-uppercase" role="tab" data-bs-toggle="tab" data-bs-target="#navs-siswa" aria-controls="navs-siswa" aria-selected="false" style="letter-spacing: 0.5px;">
                        <i class="ti ti-users me-1"></i> Daftar Siswa & Cetak Rapor
                    </button>
                </li>
            </ul>

            <div class="tab-content p-0 bg-transparent shadow-none border-0 pt-3">
                <!-- Tab Panel Progress Mapel -->
                <div class="tab-pane fade show active" id="navs-progress" role="tabpanel">
                    <div class="row">
                        @forelse ($monitoringData as $data)
                            <div class="col-12">
                                <div class="card mb-2 border shadow-none transition-all hover-lift">
                                    <div class="card-body p-3">
                                        <div class="row align-items-center">
                                            <!-- Mapel & Icon -->
                                            <div class="col-lg-3 col-md-6 col-sm-12 border-end">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar me-3 rounded bg-label-success d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;">
                                                        <i class="ti ti-books fs-4"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0 fw-bold">{{ $data->mapel_nama }}</h6>
                                                        <small class="text-muted">Mata Pelajaran</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Guru Pengampu -->
                                            <div class="col-lg-3 col-md-6 col-sm-12 border-end">
                                                <div class="d-flex flex-column">
                                                    <small class="text-muted">Guru Pengampu</small>
                                                    <span class="fw-bold">{{ $data->guru_nama }}</span>
                                                </div>
                                            </div>
                                            <!-- Status Pengisian -->
                                            <div class="col-lg-2 col-md-6 col-sm-12 border-end text-center">
                                                <small class="d-block text-muted">Status</small>
                                                @if ($data->status === 'Belum Ada Rencana')
                                                    <span class="badge bg-label-danger"><i class="ti ti-alert-circle me-1"></i>Belum Ada Rencana</span>
                                                @elseif ($data->status === 'Belum Diisi')
                                                    <span class="badge bg-label-warning"><i class="ti ti-clock me-1"></i>Belum Diisi</span>
                                                @elseif ($data->status === 'Belum Lengkap')
                                                    <span class="badge bg-label-info"><i class="ti ti-edit me-1"></i>Belum Lengkap</span>
                                                @else
                                                    <span class="badge bg-label-success"><i class="ti ti-check me-1"></i>Lengkap / Terkirim</span>
                                                @endif
                                            </div>
                                            <!-- Progress Bar -->
                                            <div class="col-lg-2 col-md-6 col-sm-12 border-end">
                                                <small class="text-muted d-block">Progress Penilaian</small>
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="progress w-100" style="height: 8px;">
                                                        <div class="progress-bar {{ $data->completion_rate === 100 ? 'bg-success' : ($data->completion_rate > 0 ? 'bg-info' : 'bg-danger') }}" role="progressbar" style="width: {{ $data->completion_rate }}%;" aria-valuenow="{{ $data->completion_rate }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <small class="fw-bold {{ $data->completion_rate === 100 ? 'text-success' : ($data->completion_rate > 0 ? 'text-info' : 'text-danger') }}">{{ $data->completion_rate }}%</small>
                                                </div>
                                                <small class="text-muted small d-block" style="font-size: 0.7rem;">Rencana Penilaian: {{ $data->rencana_count }}</small>
                                            </div>
                                            <!-- Actions -->
                                            <div class="col-lg-2 col-md-12 col-sm-12 text-end">
                                                <a href="{{ route('rapor-siswa.nilai', $data->jadwal_id) }}" class="btn btn-sm btn-primary py-2 px-3 fw-semibold shadow-sm" style="background-color: #064e3b; border-color: #064e3b">
                                                    <i class="ti ti-chart-bar me-1"></i> Lihat Nilai
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-warning text-center">
                                    <i class="ti ti-info-circle me-1"></i> Tidak ada jadwal pelajaran / mata pelajaran terdaftar di kelas ini untuk semester aktif.
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Tab Panel Daftar Siswa -->
                <div class="tab-pane fade" id="navs-siswa" role="tabpanel">
                    <div class="row">
                        @forelse ($students as $student)
                            <div class="col-12">
                                <div class="card mb-2 border shadow-none transition-all hover-lift">
                                    <div class="card-body p-3">
                                        <div class="row align-items-center">
                                            <!-- Siswa & Icon -->
                                            <div class="col-lg-4 col-md-6 col-sm-12 border-end">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar me-3 rounded bg-label-primary d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;">
                                                        <i class="ti ti-user fs-4"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0 fw-bold">{{ $student->nama_lengkap }}</h6>
                                                        <small class="text-muted">NIS: {{ $student->nis ?? '-' }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Jenis Kelamin -->
                                            <div class="col-lg-3 col-md-6 col-sm-12 border-end">
                                                <div class="d-flex flex-column">
                                                    <small class="text-muted">Jenis Kelamin</small>
                                                    <span class="fw-semibold">{{ $student->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}</span>
                                                </div>
                                            </div>
                                            <!-- Pendaftaran -->
                                            <div class="col-lg-3 col-md-6 col-sm-12 border-end text-center">
                                                <small class="d-block text-muted">No. Pendaftaran</small>
                                                <span class="fw-bold text-dark">{{ $student->no_pendaftaran }}</span>
                                            </div>
                                            <!-- Actions -->
                                            <div class="col-lg-2 col-md-12 col-sm-12 text-end">
                                                <a href="{{ route('rapor-siswa.preview', Crypt::encrypt($student->no_pendaftaran)) }}" class="btn btn-sm btn-success py-2 px-3 fw-semibold shadow-sm" style="background-color: #064e3b; border-color: #064e3b">
                                                    <i class="ti ti-printer me-1"></i> Cetak Rapor
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-warning text-center">
                                    <i class="ti ti-info-circle me-1"></i> Tidak ada siswa terdaftar di kelas ini.
                                </div>
                            </div>
                        @endforelse
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

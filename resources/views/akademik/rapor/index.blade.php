@extends('layouts.app')
@section('titlepage', 'Rapor Siswa')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-file-report fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Rapor Siswa</h4>
                        <p class="text-muted mb-0 small">Manajemen penilaian berdasar mata pelajaran dan kelas</p>
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
                                <i class="ti ti-file-report me-1"></i> Rapor Siswa
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
        <!-- Filter Form -->
        <style>
            .form-filter .form-group {
                margin-bottom: 0 !important;
            }
        </style>
        <div class="card mb-4 shadow-none border-0 bg-transparent">
            <div class="card-body p-0">
                <form action="{{ route('rapor.index') }}" method="GET" class="form-filter">
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
                            <a href="{{ route('rapor.index') }}" class="btn btn-label-secondary w-100 p-2 d-flex align-items-center justify-content-center" data-bs-toggle="tooltip" title="Reset Filter">
                                <i class="ti ti-refresh fs-5"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Data List -->
        <div class="row">
            <div class="col-12">
                <div class="row text-nowrap">
                    @forelse ($jadwalGrouped as $d)
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
                                                    <h6 class="mb-0 fw-bold">{{ $d->mapel->nama_matpel ?? '-' }}</h6>
                                                    <small class="text-muted">Mata Pelajaran</small>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Kelas & Unit -->
                                        <div class="col-lg-3 col-md-6 col-sm-12 border-end">
                                            <div class="d-flex flex-column">
                                                <span class="fw-bold text-dark">Kelas {{ $d->kelas->nama_kelas ?? '-' }}</span>
                                                <small class="text-muted"><i class="ti ti-building me-1"></i>{{ $d->unit->nama_unit ?? '-' }}</small>
                                            </div>
                                        </div>
                                        <!-- Guru -->
                                        <div class="col-lg-2 col-md-6 col-sm-12 border-end">
                                            <div class="d-flex flex-column">
                                                <small class="text-muted">Guru Pengampu</small>
                                                <span class="fw-bold">{{ $d->guru->nama_guru ?? '-' }}</span>
                                            </div>
                                        </div>
                                        <!-- Tahun Ajaran -->
                                        <div class="col-lg-1 col-md-6 col-sm-12 border-end text-center">
                                            <small class="d-block text-muted">TA</small>
                                            <span class="fw-bold text-primary" style="font-size: 0.75rem;">{{ $d->tahunAjaran->tahun_ajaran ?? '-' }}</span>
                                        </div>
                                        <!-- Semester -->
                                        <div class="col-lg-1 col-md-6 col-sm-12 border-end text-center">
                                            <small class="d-block text-muted">Sem.</small>
                                            <span class="badge bg-label-secondary">{{ $d->semester == 1 ? 'Ganjil' : 'Genap' }}</span>
                                        </div>
                                        <!-- Actions -->
                                        <div class="col-lg-2 col-md-12 col-sm-12 text-end">
                                            <a href="{{ route('penilaian.index', $d->id) }}" class="btn btn-sm btn-primary py-2 px-3 fw-semibold shadow-sm" style="background-color: #064e3b; border-color: #064e3b">
                                                <i class="ti ti-edit me-1"></i> Input Nilai
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-warning text-center">
                                <i class="ti ti-info-circle me-1"></i> Data Rapor belum tersedia untuk filter ini.
                            </div>
                        </div>
                    @endforelse
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

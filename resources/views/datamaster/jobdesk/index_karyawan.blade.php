@extends('layouts.app')
@section('titlepage', 'Jobdesk Saya')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-4">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md rounded-circle d-flex align-items-center justify-content-center" style="background-color: #e6f4ea; color: #064e3b">
                        <i class="ti ti-briefcase fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-1 fw-extrabold" style="color: #064e3b; letter-spacing: -0.5px;">Jobdesk Saya</h4>
                        <p class="text-muted mb-0 small">Daftar tugas pokok dan fungsi resmi Anda</p>
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
                                <i class="ti ti-briefcase me-1"></i> Jobdesk Saya
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    .jobdesk-card {
        transition: all 0.3s ease;
        border: 1px solid rgba(0, 0, 0, 0.08) !important;
        border-radius: 12px;
    }
    .jobdesk-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(6, 78, 59, 0.08) !important;
        border-color: rgba(6, 78, 59, 0.25) !important;
    }
</style>

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

        <!-- Jobdesk List Header -->
        <div class="d-flex align-items-center justify-content-between mb-3 px-1">
            <h5 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                <i class="ti ti-list-check text-success fs-4"></i>
                <span>Tugas Pokok & Fungsi (Tupoksi)</span>
            </h5>
            <span class="badge bg-label-success fw-bold px-2-5 py-1">{{ count($jobdesk) }} Butir Tugas</span>
        </div>

        <!-- Jobdesk Items Grid -->
        <div class="row g-3">
            @forelse($jobdesk as $jd)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 bg-white jobdesk-card border-0 shadow-sm">
                        <div class="card-body p-4 d-flex align-items-start gap-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px; background-color: #e6f4ea; color: #064e3b; box-shadow: 0 2px 6px rgba(6, 78, 59, 0.1);">
                                <i class="ti ti-checklist fs-4"></i>
                            </div>
                            <div class="flex-grow-1">
                                <span class="badge bg-label-success mb-2 fw-semibold text-uppercase" style="font-size: 0.65rem;">{{ $jd->kode_jobdesk }}</span>
                                <p class="mb-0 text-dark fw-semibold" style="line-height: 1.6; font-size: 0.95rem;">{!! $jd->jobdesk !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5 bg-white rounded-3 shadow-sm border border-light">
                    <div class="mb-3 text-muted">
                        <i class="ti ti-briefcase-off fs-1 opacity-50 text-success"></i>
                    </div>
                    <h5 class="fw-bold text-dark">Belum Ada Jobdesk Yang Ditetapkan</h5>
                    <p class="text-muted small">Silakan hubungi bagian Kepegawaian (HRD) untuk informasi tugas jabatan Anda.</p>
                </div>
            @endforelse
        </div>

    </div>
</div>

@endsection

@extends('layouts.app')
@section('titlepage', 'Jobdesk')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-briefcase fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Data Jobdesk</h4>
                        <p class="text-muted mb-0 small">Manajemen data tugas pokok dan fungsi (jobdesk)</p>
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
                                <i class="ti ti-briefcase me-1"></i> Jobdesk
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

@php
    function getDeptIcon($kode) {
        $icons = [
            'KEA' => 'ti ti-book-2',
            'ADM' => 'ti ti-file-text',
            'KEU' => 'ti ti-wallet',
            'SAR' => 'ti ti-tool',
            'HUM' => 'ti ti-world',
            'PEK' => 'ti ti-settings',
        ];
        return $icons[strtoupper($kode)] ?? 'ti ti-building-community';
    }
@endphp

<style>
    .drilldown-card {
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        cursor: pointer;
        border: 1px solid rgba(0, 0, 0, 0.08) !important;
        border-radius: 12px;
    }
    .drilldown-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 20px rgba(6, 78, 59, 0.1) !important;
        border-color: #064e3b !important;
    }
    .step-section {
        display: none;
    }
    .step-section.active {
        display: block;
        animation: slideIn 0.35s ease-out;
    }
    @keyframes slideIn {
        from { opacity: 0; transform: translateY(12px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .badge-dept {
        background-color: rgba(6, 78, 59, 0.1);
        color: #064e3b;
        font-weight: 600;
    }
    .jobdesk-item-card {
        transition: all 0.2s ease-in-out;
        border: 1px solid rgba(0, 0, 0, 0.08) !important;
        border-radius: 8px;
    }
    .jobdesk-item-card:hover {
        box-shadow: 0 4px 12px rgba(6, 78, 59, 0.05) !important;
        border-color: rgba(6, 78, 59, 0.3) !important;
    }
</style>

<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <!-- Actions & Navigation Header -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <div class="d-flex align-items-center gap-2">
                @can('jobdesk.create')
                    <button class="btn d-flex align-items-center gap-2 shadow-sm text-white px-3 py-2" id="btncreateJobdesk"
                        style="background-color: #064e3b; border-radius: 8px;">
                        <i class="ti ti-plus fs-5"></i>
                        <span class="fw-semibold">Tambah Jobdesk</span>
                    </button>
                    <button class="btn btn-outline-success d-flex align-items-center gap-2 shadow-sm px-3 py-2" id="btnimportJobdesk"
                        style="border-radius: 8px; border-color: #064e3b; color: #064e3b;">
                        <i class="ti ti-file-import fs-5"></i>
                        <span class="fw-semibold">Import Jobdesk</span>
                    </button>
                @endcan

                @if(auth()->check() && auth()->user()->hasRole('super admin'))
                    <form method="POST" action="{{ route('jobdesk.reset') }}" class="d-inline-block" id="formResetJobdesk">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger d-flex align-items-center gap-2 shadow-sm px-3 py-2 btn-reset-confirm"
                            style="border-radius: 8px;">
                            <i class="ti ti-rotate fs-5"></i>
                            <span class="fw-semibold">Reset Jobdesk</span>
                        </button>
                    </form>
                @endif
            </div>
            
            <!-- Breadcrumbs Navigation -->
            @if ($selected_unit)
                <div id="flow-breadcrumbs" class="bg-white px-3 py-2 rounded shadow-xs border">
                    <nav aria-label="breadcrumb" class="mb-0">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('jobdesk.index') }}" class="text-decoration-none fw-semibold" style="color: #064e3b;"><i class="ti ti-layout-grid me-1"></i>Unit</a></li>
                            <li class="breadcrumb-item {{ !$selected_dept ? 'active' : '' }}">
                                @if ($selected_dept)
                                    <a href="{{ route('jobdesk.index', ['kode_unit' => $selected_unit->kode_unit]) }}" class="text-decoration-none fw-semibold" style="color: #064e3b;">{{ strtoupper($selected_unit->nama_unit) }}</a>
                                @else
                                    {{ strtoupper($selected_unit->nama_unit) }}
                                @endif
                            </li>
                            @if ($selected_dept)
                                <li class="breadcrumb-item {{ !$selected_jabatan ? 'active' : '' }}">
                                    @if ($selected_jabatan)
                                        <a href="{{ route('jobdesk.index', ['kode_unit' => $selected_unit->kode_unit, 'kode_dept' => $selected_dept->kode_dept]) }}" class="text-decoration-none fw-semibold" style="color: #064e3b;">{{ strtoupper($selected_dept->nama_dept) }}</a>
                                    @else
                                        {{ strtoupper($selected_dept->nama_dept) }}
                                    @endif
                                </li>
                            @endif
                            @if ($selected_jabatan)
                                <li class="breadcrumb-item active">{{ strtoupper($selected_jabatan->nama_jabatan) }}</li>
                            @endif
                        </ol>
                    </nav>
                </div>
            @endif
        </div>

        <!-- Filter Form (Integrated search) -->
        <div class="mb-4">
            <div class="input-group input-group-merge border shadow-xs rounded-3 bg-white p-1" style="border-color: #e0e0e0 !important;">
                <span class="input-group-text bg-white border-0"><i class="ti ti-search text-muted fs-4"></i></span>
                <input type="text" id="jobdesk-local-search" class="form-control bg-white border-0 ps-2 py-2"
                    placeholder="Cari jobdesk secara instan di sini...">
            </div>
        </div>

        <!-- 0. UNIT SECTION -->
        <div class="step-section {{ !$selected_unit ? 'active' : '' }}" id="unit-section">
            <div class="row g-3">
                @forelse ($unit as $u)
                    @php
                        $unitJobdesksCount = $jobdesk->where('kode_unit', $u->kode_unit)->count();
                        $unitDeptsCount = $jobdesk->where('kode_unit', $u->kode_unit)->pluck('kode_dept')->unique()->count();
                    @endphp
                    <a href="{{ route('jobdesk.index', ['kode_unit' => $u->kode_unit]) }}" class="col-xl-4 col-md-6 col-sm-12 text-decoration-none">
                        <div class="card drilldown-card shadow-sm h-100">
                            <div class="card-body p-4 d-flex align-items-start gap-3">
                                <div class="avatar avatar-lg rounded-circle d-flex align-items-center justify-content-center"
                                     style="width: 50px; height: 50px; background-color: rgba(6, 78, 59, 0.08); color: #064e3b;">
                                    <i class="ti ti-building fs-3"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="badge bg-label-primary fs-xs px-2 py-1 rounded">{{ $u->kode_unit }}</span>
                                        <span class="text-muted small fw-medium">{{ $unitJobdesksCount }} Jobdesk</span>
                                    </div>
                                    <h5 class="mb-1 fw-bold text-dark" style="font-size: 1.1rem;">{{ strtoupper($u->nama_unit) }}</h5>
                                    <p class="text-muted mb-0 small"><i class="ti ti-category me-1"></i>{{ $unitDeptsCount }} Departemen aktif</p>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-12 text-center p-5">
                        <i class="ti ti-building fs-1 opacity-25"></i>
                        <h5 class="mt-3">Belum Ada Data Unit</h5>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- 1. DEPARTEMEN SECTION -->
        <div class="step-section {{ $selected_unit && !$selected_dept ? 'active' : '' }}" id="dept-section">
            <div class="d-flex align-items-center gap-2 mb-3">
                <a href="{{ route('jobdesk.index') }}" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1 py-2 px-3" style="border-radius: 8px;">
                    <i class="ti ti-arrow-left"></i> Kembali ke Unit
                </a>
            </div>
            <div class="row g-3">
                @if ($selected_unit)
                    @forelse ($departemen as $d)
                        @php
                            $deptJobdesksCount = $jobdesk->where('kode_unit', $selected_unit->kode_unit)->where('kode_dept', $d->kode_dept)->count();
                            $deptJabatansCount = $jobdesk->where('kode_unit', $selected_unit->kode_unit)->where('kode_dept', $d->kode_dept)->pluck('kode_jabatan')->unique()->count();
                        @endphp
                        @if ($deptJobdesksCount > 0)
                            <a href="{{ route('jobdesk.index', ['kode_unit' => $selected_unit->kode_unit, 'kode_dept' => $d->kode_dept]) }}" class="col-xl-4 col-md-6 col-sm-12 text-decoration-none">
                                <div class="card drilldown-card shadow-sm h-100">
                                    <div class="card-body p-4 d-flex align-items-start gap-3">
                                        <div class="avatar avatar-lg rounded-circle d-flex align-items-center justify-content-center"
                                             style="width: 50px; height: 50px; background-color: rgba(6, 78, 59, 0.08); color: #064e3b;">
                                            <i class="{{ getDeptIcon($d->kode_dept) }} fs-3"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <span class="badge badge-dept fs-xs px-2 py-1 rounded">{{ $d->kode_dept }}</span>
                                                <span class="text-muted small fw-medium">{{ $deptJobdesksCount }} Jobdesk</span>
                                            </div>
                                            <h5 class="mb-1 fw-bold text-dark" style="font-size: 1.1rem;">{{ strtoupper($d->nama_dept) }}</h5>
                                            <p class="text-muted mb-0 small"><i class="ti ti-users me-1"></i>{{ $deptJabatansCount }} Jabatan aktif</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endif
                    @empty
                        <div class="col-12 text-center p-5">
                            <i class="ti ti-building-community fs-1 opacity-25"></i>
                            <h5 class="mt-3">Belum Ada Data Departemen</h5>
                        </div>
                    @endforelse
                @endif
            </div>
        </div>

        <!-- 2. JABATAN SECTION -->
        <div class="step-section {{ $selected_unit && $selected_dept && !$selected_jabatan ? 'active' : '' }}" id="jabatan-section">
            <div class="d-flex align-items-center gap-2 mb-3">
                <a href="{{ route('jobdesk.index', ['kode_unit' => $selected_unit->kode_unit ?? '']) }}" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1 py-2 px-3" style="border-radius: 8px;">
                    <i class="ti ti-arrow-left"></i> Kembali ke Departemen
                </a>
            </div>
            <div class="row g-3" id="jabatan-cards-container">
                @if($selected_unit && $selected_dept)
                    @foreach ($jabatan as $jab)
                        @php
                            $count = $jobdesk->where('kode_unit', $selected_unit->kode_unit)->where('kode_dept', $selected_dept->kode_dept)->where('kode_jabatan', $jab->kode_jabatan)->count();
                        @endphp
                        @if ($count > 0)
                            <a href="{{ route('jobdesk.index', ['kode_unit' => $selected_unit->kode_unit, 'kode_dept' => $selected_dept->kode_dept, 'kode_jabatan' => $jab->kode_jabatan]) }}" class="col-xl-4 col-md-6 col-sm-12 text-decoration-none">
                                <div class="card drilldown-card shadow-sm h-100">
                                    <div class="card-body p-4 d-flex align-items-center gap-3">
                                        <div class="avatar avatar-md rounded-circle d-flex align-items-center justify-content-center"
                                             style="width: 42px; height: 42px; background-color: rgba(0, 168, 204, 0.08); color: #0081a7;">
                                            <i class="ti ti-user-check fs-4"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 fw-bold text-dark">{{ strtoupper($jab->nama_jabatan) }}</h6>
                                            <span class="badge bg-label-info px-2 py-1 rounded small">{{ $count }} Jobdesk</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endif
                    @endforeach
                @endif
            </div>
        </div>

        <!-- 3. JOBDESK SECTION -->
        <div class="step-section {{ $selected_unit && $selected_dept && $selected_jabatan ? 'active' : '' }}" id="jobdesk-section">
            <div class="d-flex align-items-center gap-2 mb-4">
                <a href="{{ route('jobdesk.index', ['kode_unit' => $selected_unit->kode_unit ?? '', 'kode_dept' => $selected_dept->kode_dept ?? '']) }}" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1 py-2 px-3" style="border-radius: 8px;">
                    <i class="ti ti-arrow-left"></i> Kembali ke Jabatan
                </a>
            </div>

            @if ($selected_unit && $selected_dept && $selected_jabatan)
                <div class="card shadow-sm mb-4" style="border-radius: 12px; background: linear-gradient(135deg, rgba(6, 78, 59, 0.05) 0%, rgba(6, 78, 59, 0.01) 100%); border: 1px solid rgba(6, 78, 59, 0.15) !important;">
                    <div class="card-body py-3 px-4">
                        <div class="d-flex flex-wrap align-items-center gap-4 text-dark">
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar avatar-md rounded-circle d-flex align-items-center justify-content-center" style="background-color: rgba(6, 78, 59, 0.1); color: #064e3b; width: 38px; height: 38px;">
                                    <i class="ti ti-building fs-5"></i>
                                </div>
                                <div>
                                    <span class="text-muted fs-xs d-block lh-1 mb-0.5">UNIT</span>
                                    <span class="fw-bold text-dark fs-sm" style="color: #064e3b !important;">{{ strtoupper($selected_unit->nama_unit) }}</span>
                                </div>
                            </div>
                            <div class="border-start py-3 d-none d-md-block" style="border-color: rgba(6, 78, 59, 0.15) !important;"></div>
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar avatar-md rounded-circle d-flex align-items-center justify-content-center" style="background-color: rgba(6, 78, 59, 0.1); color: #064e3b; width: 38px; height: 38px;">
                                    <i class="ti ti-layout-grid fs-5"></i>
                                </div>
                                <div>
                                    <span class="text-muted fs-xs d-block lh-1 mb-0.5">DEPARTEMEN</span>
                                    <span class="fw-bold text-dark fs-sm" style="color: #064e3b !important;">{{ strtoupper($selected_dept->nama_dept) }}</span>
                                </div>
                            </div>
                            <div class="border-start py-3 d-none d-md-block" style="border-color: rgba(6, 78, 59, 0.15) !important;"></div>
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar avatar-md rounded-circle d-flex align-items-center justify-content-center" style="background-color: rgba(6, 78, 59, 0.1); color: #064e3b; width: 38px; height: 38px;">
                                    <i class="ti ti-user-check fs-5"></i>
                                </div>
                                <div>
                                    <span class="text-muted fs-xs d-block lh-1 mb-0.5">JABATAN</span>
                                    <span class="fw-bold text-dark fs-sm" style="color: #064e3b !important;">{{ strtoupper($selected_jabatan->nama_jabatan) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            
            <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead style="background-color: #064e3b">
                            <tr>
                                <th class="py-2 text-white font-weight-bold text-center" style="width: 120px; font-size: 0.875rem;">KODE</th>
                                <th class="py-2 text-white font-weight-bold text-center d-none" id="th-dept" style="width: 180px; font-size: 0.875rem;">DEPARTEMEN</th>
                                <th class="py-2 text-white font-weight-bold text-center d-none" id="th-jabatan" style="width: 180px; font-size: 0.875rem;">JABATAN</th>
                                <th class="py-2 text-white font-weight-bold" style="font-size: 0.875rem;">TUGAS POKOK & FUNGSI (JOBDESK)</th>
                                <th class="py-2 text-white font-weight-bold text-end pe-4" style="width: 100px; font-size: 0.875rem;">AKSI</th>
                            </tr>
                        </thead>
                        <tbody id="jobdesk-table-body">
                            @forelse ($jobdesk as $d)
                                <tr class="jobdesk-card-item transition-all" data-dept-id="{{ $d->kode_dept }}" data-jab-id="{{ $d->kode_jabatan }}" data-search-content="{{ strtolower($d->jobdesk) }} {{ strtolower($d->nama_jabatan) }} {{ strtolower($d->nama_dept) }} {{ strtolower($d->nama_unit ?? 'umum') }}">
                                    <td class="text-center py-2">
                                        <span class="badge bg-label-success px-2 py-0.5 rounded fw-semibold" style="font-size: 0.75rem;">{{ $d->kode_jobdesk }}</span>
                                    </td>
                                    <td class="text-center py-2 td-dept d-none">
                                        <span class="badge rounded-pill bg-label-secondary px-2 py-0.5 fw-semibold" style="font-size: 0.75rem;">{{ $d->nama_dept }}</span>
                                    </td>
                                    <td class="text-center py-2 td-jabatan d-none">
                                        <span class="badge rounded-pill bg-label-info px-2 py-0.5 fw-semibold" style="font-size: 0.75rem;">{{ $d->nama_jabatan }}</span>
                                    </td>
                                    <td class="py-2">
                                        <div class="text-dark fw-normal leading-relaxed" style="font-size: 0.875rem; white-space: pre-line;">{{ removeHtmltag($d->jobdesk) }}</div>
                                    </td>
                                    <td class="py-2 text-end pe-4">
                                        <div class="d-flex justify-content-end gap-2">
                                            @can('jobdesk.edit')
                                                <a href="#" class="btn btn-icon btn-label-success border-0 shadow-sm btnEdit rounded-3"
                                                    style="width: 28px; height: 28px;"
                                                    kode_jobdesk="{{ Crypt::encrypt($d->kode_jobdesk) }}"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Jobdesk">
                                                    <i class="ti ti-edit fs-6"></i>
                                                </a>
                                            @endcan
                                            @can('jobdesk.delete')
                                                <form method="POST" name="deleteform" class="deleteform m-0"
                                                    action="{{ route('jobdesk.delete', Crypt::encrypt($d->kode_jobdesk)) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-icon btn-label-danger border-0 shadow-sm delete-confirm rounded-3"
                                                        style="width: 28px; height: 28px;"
                                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Jobdesk">
                                                        <i class="ti ti-trash fs-6"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr id="jobdesk-empty-row">
                                    <td colspan="5" class="text-center p-5 bg-white">
                                        <div class="mb-3 text-muted">
                                            <i class="ti ti-briefcase fs-1 opacity-50 text-success"></i>
                                        </div>
                                        <h5 class="fw-bold text-dark">Belum Ada Data Jobdesk</h5>
                                        <p class="text-muted small">Klik tombol "Tambah Jobdesk" untuk menambahkan data baru.</p>
                                    </td>
                                </tr>
                            @endforelse
                            <tr id="jobdesk-no-results" class="d-none">
                                <td colspan="5" class="text-center p-5 bg-white">
                                    <div class="mb-3 text-muted">
                                        <i class="ti ti-search fs-1 opacity-50 text-warning"></i>
                                    </div>
                                    <h5 class="fw-bold text-dark">Hasil Pencarian Tidak Ditemukan</h5>
                                    <p class="text-muted small">Coba cari dengan kata kunci lain.</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<x-modal-form id="mdlJobdesk" size="" show="loadJobdesk" title="" />

<!-- Modal Import Jobdesk -->
<div class="modal fade" id="mdlImportJobdesk" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Import Data Jobdesk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('jobdesk.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info d-flex align-items-start gap-2 mb-3" role="alert" style="border-radius: 8px;">
                        <i class="ti ti-info-circle fs-4 mt-0.5"></i>
                        <div>
                            <span class="fw-semibold d-block">Petunjuk Impor:</span>
                            <span class="small d-block">1. Unduh template format Excel yang disediakan di bawah.</span>
                            <span class="small d-block">2. Isi kolom kode unit, departemen, jabatan, dan deskripsi tugas sesuai kode referensi pada sheet kedua.</span>
                            <span class="small d-block">3. Unggah berkas Excel yang telah diisi.</span>
                        </div>
                    </div>
                    <div class="mb-4 text-center">
                        <a href="{{ route('jobdesk.download-format') }}" class="btn btn-label-success d-inline-flex align-items-center gap-2">
                            <i class="ti ti-download fs-5"></i> Unduh Format Excel
                        </a>
                    </div>
                    <div class="form-group mb-3">
                        <label for="import-file" class="form-label fw-semibold">Pilih Berkas Excel (.xlsx)</label>
                        <input type="file" name="file" id="import-file" class="form-control" accept=".xlsx, .xls, .csv" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Mulai Impor</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('myscript')
<script>
    $(function() {
        let isSearching = false;
        const selectedUnitId = "{{ $selected_unit->kode_unit ?? '' }}";
        const selectedDeptId = "{{ $selected_dept->kode_dept ?? '' }}";
        const selectedJabId = "{{ $selected_jabatan->kode_jabatan ?? '' }}";

        // Initial setup for jobdesk table rows on page load
        if (selectedDeptId && selectedJabId) {
            $('.jobdesk-card-item').hide();
            $(`.jobdesk-card-item[data-dept-id="${selectedDeptId}"][data-jab-id="${selectedJabId}"]`).show();
        }

        // Local live search functionality
        $('#jobdesk-local-search').on('input', function() {
            let val = $(this).val().toLowerCase().trim();
            if (val.length > 0) {
                isSearching = true;
                $('#flow-breadcrumbs').fadeOut(100);
                $('.step-section').removeClass('active');
                $('#jobdesk-section').addClass('active');

                // Show table columns during global search
                $('#th-dept, #th-jabatan, .td-dept, .td-jabatan').removeClass('d-none');

                let matchedCount = 0;
                $('.jobdesk-card-item').each(function() {
                    let content = $(this).data('search-content');
                    if (content.includes(val)) {
                        $(this).show();
                        matchedCount++;
                    } else {
                        $(this).hide();
                    }
                });

                if (matchedCount === 0) {
                    $('#jobdesk-no-results').removeClass('d-none');
                } else {
                    $('#jobdesk-no-results').addClass('d-none');
                }
            } else {
                isSearching = false;
                $('#jobdesk-no-results').addClass('d-none');

                // Restore active section and breadcrumbs based on server state
                $('.step-section').removeClass('active');
                if (selectedUnitId && selectedDeptId && selectedJabId) {
                    $('#flow-breadcrumbs').fadeIn(100);
                    $('#jobdesk-section').addClass('active');
                    $('#th-dept, #th-jabatan, .td-dept, .td-jabatan').addClass('d-none');
                    $('.jobdesk-card-item').hide();
                    $(`.jobdesk-card-item[data-dept-id="${selectedDeptId}"][data-jab-id="${selectedJabId}"]`).show();
                } else if (selectedUnitId && selectedDeptId) {
                    $('#flow-breadcrumbs').fadeIn(100);
                    $('#jabatan-section').addClass('active');
                } else if (selectedUnitId) {
                    $('#flow-breadcrumbs').fadeIn(100);
                    $('#dept-section').addClass('active');
                } else {
                    $('#unit-section').addClass('active');
                }
            }
        });

        // Original logic for Modal (Add / Edit)
        $("#btncreateJobdesk").click(function(e) {
            e.preventDefault();
            $('#mdlJobdesk').modal("show");
            $("#mdlJobdesk").find(".modal-title").text("Tambah Jobdesk");
            $("#loadJobdesk").load('/jobdesk/create?kode_unit=' + selectedUnitId + '&kode_dept=' + selectedDeptId + '&kode_jabatan=' + selectedJabId);
        });

        $("#btnimportJobdesk").click(function(e) {
            e.preventDefault();
            $('#mdlImportJobdesk').modal("show");
        });

        $(document).on('click', '.btnEdit', function(e) {
            var kode_jobdesk = $(this).attr("kode_jobdesk");
            e.preventDefault();
            $('#mdlJobdesk').modal("show");
            $("#mdlJobdesk").find(".modal-title").text("Edit Jobdesk");
            $("#loadJobdesk").load('/jobdesk/' + kode_jobdesk + '/edit');
        });

        $(document).on('click', '.btn-reset-confirm', function(event) {
            var form = $(this).closest("form");
            event.preventDefault();
            Swal.fire({
                title: `Apakah Anda Yakin Ingin Mereset Semua Jobdesk ?`,
                text: "Semua data jobdesk yang ada akan dihapus secara permanen!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Ya, Reset Semua!"
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush


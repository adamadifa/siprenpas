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
                @endcan
            </div>
            
            <!-- Breadcrumbs Navigation -->
            <div id="flow-breadcrumbs" class="bg-white px-3 py-2 rounded shadow-xs border" style="display: none;">
                <nav aria-label="breadcrumb" class="mb-0">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0);" id="bc-all-dept" class="text-decoration-none fw-semibold" style="color: #064e3b;"><i class="ti ti-layout-grid me-1"></i>Departemen</a></li>
                        <li class="breadcrumb-item active" id="bc-dept" style="display: none;">Nama Dept</li>
                        <li class="breadcrumb-item active" id="bc-jabatan" style="display: none;">Nama Jabatan</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Filter Form (Integrated search) -->
        <div class="mb-4">
            <div class="input-group input-group-merge border shadow-xs rounded-3 bg-white p-1" style="border-color: #e0e0e0 !important;">
                <span class="input-group-text bg-white border-0"><i class="ti ti-search text-muted fs-4"></i></span>
                <input type="text" id="jobdesk-local-search" class="form-control bg-white border-0 ps-2 py-2"
                    placeholder="Cari jobdesk secara instan di sini...">
            </div>
        </div>

        <!-- 1. DEPARTEMEN SECTION -->
        <div class="step-section active" id="dept-section">
            <div class="row g-3">
                @forelse ($departemen as $d)
                    @php
                        $deptJobdesksCount = $jobdesk->where('kode_dept', $d->kode_dept)->count();
                        $deptJabatansCount = $jobdesk->where('kode_dept', $d->kode_dept)->pluck('kode_jabatan')->unique()->count();
                    @endphp
                    <div class="col-xl-4 col-md-6 col-sm-12 dept-card-item" data-dept-id="{{ $d->kode_dept }}" data-dept-name="{{ $d->nama_dept }}">
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
                    </div>
                @empty
                    <div class="col-12 text-center p-5">
                        <i class="ti ti-building-community fs-1 opacity-25"></i>
                        <h5 class="mt-3">Belum Ada Data Departemen</h5>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- 2. JABATAN SECTION -->
        <div class="step-section" id="jabatan-section">
            <div class="d-flex align-items-center gap-2 mb-3">
                <button class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1 btn-back-to-dept py-2 px-3" style="border-radius: 8px;">
                    <i class="ti ti-arrow-left"></i> Kembali ke Departemen
                </button>
            </div>
            <div class="row g-3" id="jabatan-cards-container">
                @foreach ($departemen as $dept)
                    @php
                        $deptJobdesks = $jobdesk->where('kode_dept', $dept->kode_dept);
                        $deptJabatans = $deptJobdesks->pluck('kode_jabatan')->unique();
                    @endphp
                    @foreach ($jabatan as $jab)
                        @php
                            $count = $deptJobdesks->where('kode_jabatan', $jab->kode_jabatan)->count();
                        @endphp
                        @if ($count > 0)
                            <div class="col-xl-4 col-md-6 col-sm-12 jabatan-card-item" data-dept-id="{{ $dept->kode_dept }}" data-jab-id="{{ $jab->kode_jabatan }}" data-jab-name="{{ $jab->nama_jabatan }}">
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
                            </div>
                        @endif
                    @endforeach
                @endforeach
            </div>
        </div>

        <!-- 3. JOBDESK SECTION -->
        <div class="step-section" id="jobdesk-section">
            <div class="d-flex align-items-center gap-2 mb-4">
                <button class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1 btn-back-to-jabatan py-2 px-3" style="border-radius: 8px;">
                    <i class="ti ti-arrow-left"></i> Kembali ke Jabatan
                </button>
            </div>
            <div class="row g-3" id="jobdesk-cards-container">
                @forelse ($jobdesk as $d)
                    <div class="col-12 jobdesk-card-item" data-dept-id="{{ $d->kode_dept }}" data-jab-id="{{ $d->kode_jabatan }}" data-search-content="{{ strtolower($d->jobdesk) }} {{ strtolower($d->nama_jabatan) }} {{ strtolower($d->nama_dept) }}">
                        <div class="card jobdesk-item-card shadow-none bg-white">
                            <div class="card-body p-3 d-flex justify-content-between align-items-center gap-3">
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                                        <span class="badge bg-label-success px-1.5 py-0.5 rounded" style="font-size: 0.75rem;">{{ $d->kode_jobdesk }}</span>
                                        <span class="text-muted small" style="font-size: 0.8rem;"><i class="ti ti-building me-1"></i>{{ $d->nama_dept }}</span>
                                        <span class="text-muted small" style="font-size: 0.8rem;"><i class="ti ti-user me-1"></i>{{ $d->nama_jabatan }}</span>
                                    </div>
                                    <p class="mb-0 text-dark fw-normal" style="font-size: 0.925rem; line-height: 1.5; white-space: pre-line;">
                                        {{ removeHtmltag($d->jobdesk) }}
                                    </p>
                                </div>
                                <div class="d-flex gap-1">
                                    @can('jobdesk.edit')
                                        <a href="#" class="btn btn-icon btn-label-success border btnEdit"
                                            style="width: 32px; height: 32px; border-radius: 6px;"
                                            kode_jobdesk="{{ Crypt::encrypt($d->kode_jobdesk) }}"
                                            title="Edit Jobdesk">
                                            <i class="ti ti-edit fs-5"></i>
                                        </a>
                                    @endcan
                                    @can('jobdesk.delete')
                                        <form method="POST" name="deleteform" class="deleteform d-inline-block"
                                            action="{{ route('jobdesk.delete', Crypt::encrypt($d->kode_jobdesk)) }}">
                                            @csrf
                                            @method('DELETE')
                                            <a href="#" class="btn btn-icon btn-label-danger border delete-confirm"
                                                style="width: 32px; height: 32px; border-radius: 6px;"
                                                title="Hapus Jobdesk">
                                                <i class="ti ti-trash fs-5"></i>
                                            </a>
                                        </form>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center p-5 bg-white rounded border">
                        <i class="ti ti-briefcase fs-1 opacity-25"></i>
                        <h5 class="mt-3">Belum Ada Data Jobdesk</h5>
                        <p class="text-muted mb-0">Klik tombol "Tambah Jobdesk" untuk menambahkan data baru.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<x-modal-form id="mdlJobdesk" size="" show="loadJobdesk" title="" />
@endsection

@push('myscript')
<script>
    $(function() {
        // Active selection state
        let selectedDeptId = null;
        let selectedDeptName = '';
        let selectedJabId = null;
        let selectedJabName = '';
        let isSearching = false;

        // Step navigation helper
        function goToStep(stepId) {
            $('.step-section').removeClass('active');
            $(`#${stepId}`).addClass('active');

            // Update breadcrumbs visibility & labels
            if (stepId === 'dept-section') {
                $('#flow-breadcrumbs').fadeOut(200);
                $('#bc-dept').hide();
                $('#bc-jabatan').hide();
            } else if (stepId === 'jabatan-section') {
                $('#flow-breadcrumbs').fadeIn(200);
                $('#bc-dept').text(selectedDeptName).show();
                $('#bc-jabatan').hide();
            } else if (stepId === 'jobdesk-section') {
                $('#flow-breadcrumbs').fadeIn(200);
                $('#bc-dept').text(selectedDeptName).show();
                $('#bc-jabatan').text(selectedJabName).show();
            }
        }

        // 1. Department Clicked
        $('.dept-card-item').click(function() {
            if (isSearching) return; // Disable drilldown while searching globally
            selectedDeptId = $(this).data('dept-id');
            selectedDeptName = $(this).data('dept-name');

            // Hide/Show correct Jabatan cards
            $('.jabatan-card-item').hide();
            let matchedJabatans = $(`.jabatan-card-item[data-dept-id="${selectedDeptId}"]`);
            matchedJabatans.show();

            // If there's only 1 Jabatan, auto-select it for a faster flow
            if (matchedJabatans.length === 1) {
                let singleJab = matchedJabatans.first();
                selectedJabId = singleJab.data('jab-id');
                selectedJabName = singleJab.data('jab-name');
                
                $('.jobdesk-card-item').hide();
                $(`.jobdesk-card-item[data-dept-id="${selectedDeptId}"][data-jab-id="${selectedJabId}"]`).show();
                goToStep('jobdesk-section');
            } else {
                goToStep('jabatan-section');
            }
        });

        // 2. Jabatan Clicked
        $('.jabatan-card-item').click(function() {
            selectedJabId = $(this).data('jab-id');
            selectedJabName = $(this).data('jab-name');

            // Hide/Show correct Jobdesk cards
            $('.jobdesk-card-item').hide();
            $(`.jobdesk-card-item[data-dept-id="${selectedDeptId}"][data-jab-id="${selectedJabId}"]`).show();

            goToStep('jobdesk-section');
        });

        // Back actions
        $('.btn-back-to-dept').click(function() {
            goToStep('dept-section');
        });

        $('.btn-back-to-jabatan').click(function() {
            goToStep('jabatan-section');
        });

        $('#bc-all-dept').click(function() {
            goToStep('dept-section');
        });

        $('#bc-dept').click(function() {
            goToStep('jabatan-section');
        });

        // Local live search functionality
        $('#jobdesk-local-search').on('input', function() {
            let val = $(this).val().toLowerCase().trim();
            if (val.length > 0) {
                isSearching = true;
                $('#flow-breadcrumbs').fadeOut(100);
                $('.step-section').removeClass('active');
                $('#jobdesk-section').addClass('active');
                $('.btn-back-to-jabatan').hide();

                $('.jobdesk-card-item').each(function() {
                    let content = $(this).data('search-content');
                    if (content.includes(val)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            } else {
                isSearching = false;
                $('.btn-back-to-jabatan').show();
                // Revert to active step
                if (selectedJabId) {
                    $('.jobdesk-card-item').hide();
                    $(`.jobdesk-card-item[data-dept-id="${selectedDeptId}"][data-jab-id="${selectedJabId}"]`).show();
                    goToStep('jobdesk-section');
                } else if (selectedDeptId) {
                    goToStep('jabatan-section');
                } else {
                    goToStep('dept-section');
                }
            }
        });

        // Original logic for Modal (Add / Edit)
        $("#btncreateJobdesk").click(function(e) {
            e.preventDefault();
            $('#mdlJobdesk').modal("show");
            $("#mdlJobdesk").find(".modal-title").text("Tambah Jobdesk");
            $("#loadJobdesk").load('/jobdesk/create');
        });

        $(document).on('click', '.btnEdit', function(e) {
            var kode_jobdesk = $(this).attr("kode_jobdesk");
            e.preventDefault();
            $('#mdlJobdesk').modal("show");
            $("#mdlJobdesk").find(".modal-title").text("Edit Jobdesk");
            $("#loadJobdesk").load('/jobdesk/' + kode_jobdesk + '/edit');
        });
    });
</script>
@endpush


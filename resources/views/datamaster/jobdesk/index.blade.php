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

<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <!-- Actions Section -->
        <div class="d-flex justify-content-start mb-3">
            @can('jobdesk.create')
                <button class="btn d-flex align-items-center gap-2 shadow-sm text-white" id="btncreateJobdesk"
                    style="background-color: #064e3b">
                    <i class="ti ti-plus fs-4"></i>
                    <span>Tambah Jobdesk</span>
                </button>
            @endcan
        </div>

        <!-- Filter Form -->
        <div class="mb-4">
            <form action="{{ route('jobdesk.index') }}">
                <div class="row g-2">
                    @hasrole(['superadmin', 'pimpinan pesantren', 'sekretaris'])
                        <div class="col-lg-3 col-md-6">
                            <select name="kode_jabatan" id="kode_jabatan" class="form-select select2Kodejabatansearch">
                                <option value="">Semua Jabatan</option>
                                @foreach ($jabatan as $d)
                                    <option value="{{ $d->kode_jabatan }}"
                                        {{ Request('kode_jabatan') == $d->kode_jabatan ? 'selected' : '' }}>
                                        {{ strtoUpper($d->nama_jabatan) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <select name="kode_dept" id="kode_dept" class="form-select select2Kodedeptsearc">
                                <option value="">Semua Departemen</option>
                                @foreach ($departemen as $d)
                                    <option value="{{ $d->kode_dept }}" {{ Request('kode_dept') == $d->kode_dept ? 'selected' : '' }}>
                                        {{ strtoUpper($d->nama_dept) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-4 col-md-8">
                    @else
                        <div class="col-lg-10 col-md-8">
                    @endhasrole
                        <div class="input-group input-group-merge border shadow-none rounded-2"
                            style="border-color: #e0e0e0 !important;">
                            <span class="input-group-text bg-white border-0"><i class="ti ti-search text-muted"></i></span>
                            <input type="text" name="jobdesk_search" class="form-control bg-white border-0 ps-2"
                                placeholder="Cari Jobdesk..." value="{{ Request('jobdesk_search') }}">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4">
                        <button type="submit" class="btn shadow-none d-flex align-items-center justify-content-center gap-2 text-white w-100"
                            style="background-color: #064e3b">
                            <i class="ti ti-search fs-5"></i> Cari
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="card shadow-sm">
            <div class="card-header d-flex align-items-center gap-2 text-white py-3" style="background-color: #064e3b">
                <i class="ti ti-layout-grid fs-5"></i>
                <h6 class="card-title mb-0 text-white">Data Jobdesk</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background-color: #064e3b">
                            <tr>
                                <th class="text-white py-3 text-nowrap" style="width: 1%;">NO.</th>
                                <th class="text-white py-3 text-nowrap" style="width: 1%;">KODE</th>
                                <th class="text-white py-3">JOBDESK</th>
                                <th class="text-white py-3 text-nowrap" style="width: 1%;">JABATAN</th>
                                <th class="text-white py-3 text-nowrap" style="width: 1%;">DEPARTEMEN</th>
                                <th class="text-white py-3 text-end" style="width: 100px;">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($jobdesk as $d)
                                <tr>
                                    <td class="py-2 text-nowrap">{{ $loop->iteration }}</td>
                                    <td class="py-2 text-nowrap"><span class="fw-bold">{{ $d->kode_jobdesk }}</span></td>
                                    <td class="py-2" style="white-space: normal; line-height: 1.5; min-width: 300px;">{{ removeHtmltag($d->jobdesk) }}</td>
                                    <td class="py-2 text-nowrap">{{ $d->nama_jabatan }}</td>
                                    <td class="py-2 text-nowrap">{{ $d->nama_dept }}</td>
                                    <td class="py-2 text-end">
                                        <div class="d-flex justify-content-end gap-1">
                                            @can('jobdesk.edit')
                                                <a href="#" class="btn btn-icon btn-label-success border btnEdit"
                                                    style="width: 28px; height: 28px;"
                                                    kode_jobdesk="{{ Crypt::encrypt($d->kode_jobdesk) }}">
                                                    <i class="ti ti-edit fs-6"></i>
                                                </a>
                                            @endcan
                                            @can('jobdesk.delete')
                                                <form method="POST" name="deleteform" class="deleteform"
                                                    action="{{ route('jobdesk.delete', Crypt::encrypt($d->kode_jobdesk)) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="#" class="btn btn-icon btn-label-danger border delete-confirm"
                                                        style="width: 28px; height: 28px;">
                                                        <i class="ti ti-trash fs-6"></i>
                                                    </a>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center p-5">
                                        <div class="mb-3">
                                            <i class="ti ti-briefcase fs-1 opacity-25"></i>
                                        </div>
                                        <h5>Belum Ada Data Jobdesk</h5>
                                        <p class="text-muted">Silahkan tambah data baru atau sesuaikan filter pencarian.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<x-modal-form id="mdlJobdesk" size="" show="loadJobdesk" title="" />
@endsection
@push('myscript')
{{-- <script src="{{ asset('assets/js/pages/roles/create.js') }}"></script> --}}
<script>
    $(function() {
        $("#btncreateJobdesk").click(function(e) {
            e.preventDefault();
            $('#mdlJobdesk').modal("show");
            $("#mdlJobdesk").find(".modal-title").text("Tambah Jobdesk");
            $("#loadJobdesk").load('/jobdesk/create');
        });

        $(".btnEdit").click(function(e) {
            var kode_jobdesk = $(this).attr("kode_jobdesk");
            e.preventDefault();
            $('#mdlJobdesk').modal("show");
            $("#mdlJobdesk").find(".modal-title").text("Edit Jobdesk");
            $("#loadJobdesk").load('/jobdesk/' + kode_jobdesk + '/edit');
        });
    });
</script>
@endpush

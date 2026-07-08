@extends('layouts.app')
@section('titlepage', 'Permission Groups')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-layout-grid fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Data Permission Groups</h4>
                        <p class="text-muted mb-0 small">Manajemen data grup hak akses</p>
                    </div>
                </div>
                <div class="d-flex flex-column align-items-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mb-0">
                            <li class="breadcrumb-item">
                                <a href="javascript:void(0);" class="text-muted">
                                    <i class="ti ti-settings me-1"></i> Konfigurasi
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                <i class="ti ti-layout-grid me-1"></i> Permission Groups
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

<div class="row">
    <div class="col-lg-8 col-md-12">
        <!-- Actions Section -->
        <div class="d-flex justify-content-start mb-3">
            <button class="btn d-flex align-items-center gap-2 shadow-sm text-white" id="btncreateGroup"
                style="background-color: #064e3b">
                <i class="ti ti-plus fs-4"></i>
                <span>Tambah Group</span>
            </button>
        </div>

        <!-- Filter Form -->
        <div class="mb-4">
            <form action="{{ route('permissiongroups.index') }}">
                <div class="d-flex gap-2">
                    <div class="input-group input-group-merge border shadow-none rounded-2"
                        style="border-color: #e0e0e0 !important;">
                        <span class="input-group-text bg-white border-0"><i class="ti ti-search text-muted"></i></span>
                        <input type="text" name="name" class="form-control bg-white border-0 ps-2"
                            placeholder="Cari Group..." value="{{ Request('name') }}">
                    </div>
                    <button type="submit" class="btn shadow-none d-flex align-items-center gap-2 text-white px-4"
                        style="background-color: #064e3b">
                        <i class="ti ti-search fs-5"></i> Cari
                    </button>
                </div>
            </form>
        </div>

        <!-- Card Table -->
        <div class="card shadow-sm">
            <div class="card-header d-flex align-items-center gap-2 text-white py-3" style="background-color: #064e3b">
                <i class="ti ti-layout-grid fs-5"></i>
                <h6 class="card-title mb-0 text-white">Data Permission Groups</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 text-nowrap">
                        <thead style="background-color: #064e3b">
                            <tr>
                                <th class="text-white py-3" style="width: 50px;">NO.</th>
                                <th class="text-white py-3">GROUP NAME</th>
                                <th class="text-white py-3 text-end" style="width: 120px;">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permission_groups as $d)
                                <tr>
                                    <td class="py-1">{{ $loop->iteration }}</td>
                                    <td class="py-1"><span class="fw-bold">{{ $d->name }}</span></td>
                                    <td class="py-1 text-end">
                                        <div class="d-flex justify-content-end gap-1">
                                            <a href="#" class="btn btn-icon btn-label-success border editGroup"
                                                style="width: 28px; height: 28px;" id="{{ Crypt::encrypt($d->id) }}" title="Edit">
                                                <i class="ti ti-edit fs-6"></i>
                                            </a>
                                            <form method="POST" name="deleteform" class="deleteform d-inline"
                                                action="{{ route('permissiongroups.delete', Crypt::encrypt($d->id)) }}">
                                                @csrf
                                                @method('DELETE')
                                                <a href="#" class="btn btn-icon btn-label-danger border delete-confirm"
                                                    style="width: 28px; height: 28px;" title="Hapus">
                                                    <i class="ti ti-trash fs-6"></i>
                                                </a>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="p-3">
                    {{ $permission_groups->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<x-modal-form id="mdlcreateGroup" size="" show="loadcreateGroup" title="Tambah Group" />
<x-modal-form id="mdleditGroup" size="" show="loadeditGroup" title="Edit Group" />
@endsection



@push('myscript')
{{-- <script src="{{ asset('assets/js/pages/permission_groups/create.js') }}"></script> --}}
<script>
    $(function() {
        $("#btncreateGroup").click(function(e) {
            $('#mdlcreateGroup').modal("show");
            $("#loadcreateGroup").load('/permissiongroups/create');
        });

        $(".editGroup").click(function(e) {
            var id = $(this).attr("id");
            e.preventDefault();
            $('#mdleditGroup').modal("show");
            $("#loadeditGroup").load('/permissiongroups/' + id + '/edit');
        });
    });
</script>
@endpush

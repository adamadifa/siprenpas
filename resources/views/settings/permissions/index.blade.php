@extends('layouts.app')
@section('titlepage', 'Roles')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-shield-lock fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Data Permissions</h4>
                        <p class="text-muted mb-0 small">Manajemen hak akses fitur sistem</p>
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
                                <i class="ti ti-shield-lock me-1"></i> Permissions
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
            <button class="btn d-flex align-items-center gap-2 shadow-sm text-white" id="btncreatePermission"
                style="background-color: #064e3b">
                <i class="ti ti-plus fs-4"></i>
                <span>Tambah Permission</span>
            </button>
        </div>

        <!-- Filter Form -->
        <div class="mb-4">
            <form action="{{ route('permissions.index') }}">
                <div class="d-flex gap-2">
                    <div class="input-group input-group-merge border shadow-none rounded-2"
                        style="border-color: #e0e0e0 !important;">
                        <span class="input-group-text bg-white border-0"><i class="ti ti-filter text-muted"></i></span>
                        <select name="id_permission_group" class="form-select bg-white border-0 ps-2">
                            <option value="">Semua Group</option>
                            @foreach ($permission_groups as $group)
                                <option value="{{ $group->id }}" {{ Request('id_permission_group') == $group->id ? 'selected' : '' }}>
                                    {{ $group->name }}
                                </option>
                            @endforeach
                        </select>
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
                <i class="ti ti-shield-lock fs-5"></i>
                <h6 class="card-title mb-0 text-white">Data Permissions</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 text-nowrap">
                        <thead style="background-color: #064e3b">
                            <tr>
                                <th class="text-white py-3" style="width: 50px;">NO.</th>
                                <th class="text-white py-3">PERMISSION NAME</th>
                                <th class="text-white py-3">GROUP</th>
                                <th class="text-white py-3 text-end" style="width: 120px;">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permissions as $d)
                                <tr>
                                    <td class="py-1">{{ $loop->iteration }}</td>
                                    <td class="py-1"><span class="fw-bold">{{ strtolower($d->name) }}</span></td>
                                    <td class="py-1">{{ $d->group_name }}</td>
                                    <td class="py-1 text-end">
                                        <div class="d-flex justify-content-end gap-1">
                                            <a href="#" class="btn btn-icon btn-label-success border editPermission"
                                                style="width: 28px; height: 28px;" id="{{ Crypt::encrypt($d->id) }}" title="Edit">
                                                <i class="ti ti-edit fs-6"></i>
                                            </a>
                                            <form method="POST" name="deleteform" class="deleteform d-inline"
                                                action="{{ route('permissions.delete', Crypt::encrypt($d->id)) }}">
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
                    {{ $permissions->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<x-modal-form id="mdlcreatePermission" size="" show="loadcreatePermission" title="Tambah Permission" />
<x-modal-form id="mdleditPermission" size="" show="loadeditPermission" title="Edit Permission" />
@endsection
@push('myscript')
{{-- <script src="{{ asset('assets/js/pages/roles/create.js') }}"></script> --}}
<script>
    $(function() {
        $("#btncreatePermission").click(function(e) {
            $('#mdlcreatePermission').modal("show");
            $("#loadcreatePermission").load('/permissions/create');
        });

        $(".editPermission").click(function(e) {
            var id = $(this).attr("id");
            e.preventDefault();
            $('#mdleditPermission').modal("show");
            $("#loadeditPermission").load('/permissions/' + id + '/edit');
        });
    });
</script>
@endpush

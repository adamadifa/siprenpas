@extends('layouts.app')
@section('titlepage', 'Roles')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-user-check fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Data Roles</h4>
                        <p class="text-muted mb-0 small">Manajemen data role pengguna</p>
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
                                <i class="ti ti-user-check me-1"></i> Roles
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
            <button class="btn d-flex align-items-center gap-2 shadow-sm text-white" id="btncreateRole"
                style="background-color: #064e3b">
                <i class="ti ti-plus fs-4"></i>
                <span>Tambah Role</span>
            </button>
        </div>

        <!-- Filter Form -->
        <div class="mb-4">
            <form action="{{ route('roles.index') }}">
                <div class="d-flex gap-2">
                    <div class="input-group input-group-merge border shadow-none rounded-2"
                        style="border-color: #e0e0e0 !important;">
                        <span class="input-group-text bg-white border-0"><i class="ti ti-search text-muted"></i></span>
                        <input type="text" name="name" class="form-control bg-white border-0 ps-2"
                            placeholder="Cari Role..." value="{{ Request('name') }}">
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
                <i class="ti ti-user-check fs-5"></i>
                <h6 class="card-title mb-0 text-white">Data Roles</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 text-nowrap">
                        <thead style="background-color: #064e3b">
                            <tr>
                                <th class="text-white py-3" style="width: 50px;">NO.</th>
                                <th class="text-white py-3">ROLE NAME</th>
                                <th class="text-white py-3">GUARD NAME</th>
                                <th class="text-white py-3 text-end" style="width: 120px;">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $d)
                                <tr>
                                    <td class="py-1">{{ $loop->iteration }}</td>
                                    <td class="py-1"><span class="fw-bold">{{ ucwords($d->name) }}</span></td>
                                    <td class="py-1">{{ $d->guard_name }}</td>
                                    <td class="py-1 text-end">
                                        <div class="d-flex justify-content-end gap-1">
                                            <a href="{{ route('roles.createrolepermission', Crypt::encrypt($d->id)) }}"
                                                class="btn btn-icon btn-label-info border text-info" style="width: 28px; height: 28px;" title="Set Permission">
                                                <i class="ti ti-shield-lock fs-6"></i>
                                            </a>
                                            <a href="#" class="btn btn-icon btn-label-success border editRole"
                                                style="width: 28px; height: 28px;" id="{{ $d->id }}" title="Edit">
                                                <i class="ti ti-edit fs-6"></i>
                                            </a>
                                            <form method="POST" name="deleteform" class="deleteform d-inline"
                                                action="{{ route('roles.delete', Crypt::encrypt($d->id)) }}">
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
                    {{ $roles->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<x-modal-form id="mdlcreateRole" size="" show="loadcreateRole" title="Tambah Role" />
<x-modal-form id="mdleditRole" size="" show="loadeditRole" title="Edit Role" />
@endsection



@push('myscript')
{{-- <script src="{{ asset('assets/js/pages/roles/create.js') }}"></script> --}}
<script>
    $(function() {
        $("#btncreateRole").click(function(e) {
            $('#mdlcreateRole').modal("show");
            $("#loadcreateRole").load('/roles/create');
        });

        $(".editRole").click(function(e) {
            var id = $(this).attr("id");
            e.preventDefault();
            $('#mdleditRole').modal("show");
            $("#loadeditRole").load('/roles/' + id + '/edit');
        });
    });
</script>
@endpush

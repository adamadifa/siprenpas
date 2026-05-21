@extends('layouts.app')
@section('titlepage', 'Users')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-users fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Data Users</h4>
                        <p class="text-muted mb-0 small">Manajemen data pengguna sistem</p>
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
                                <i class="ti ti-users me-1"></i> Users
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
        <!-- Actions Section -->
        <div class="d-flex justify-content-start mb-3">
            <button class="btn d-flex align-items-center gap-2 shadow-sm text-white" id="btncreateUser"
                style="background-color: #064e3b">
                <i class="ti ti-plus fs-4"></i>
                <span>Tambah User</span>
            </button>
        </div>

        <div class="mb-4">
            <form action="{{ route('users.index') }}">
                <div class="d-flex gap-2">
                    <div class="input-group input-group-merge border shadow-none rounded-2"
                        style="border-color: #e0e0e0 !important;">
                        <span class="input-group-text bg-white border-0"><i class="ti ti-search text-muted"></i></span>
                        <input type="text" name="name" class="form-control bg-white border-0 ps-2"
                            placeholder="Cari Nama User..." value="{{ Request('name') }}">
                    </div>
                    <div class="input-group input-group-merge border shadow-none rounded-2"
                        style="border-color: #e0e0e0 !important; width: 300px">
                        <span class="input-group-text bg-white border-0"><i class="ti ti-user-check text-muted"></i></span>
                        <select name="role" class="form-select bg-white border-0 ps-2">
                            <option value="">Semua Role</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}" {{ Request('role') == $role->name ? 'selected' : '' }}>
                                    {{ ucwords($role->name) }}
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

        <div class="card shadow-sm">
            <div class="card-header d-flex align-items-center gap-2 text-white py-3" style="background-color: #064e3b">
                <i class="ti ti-users fs-5"></i>
                <h6 class="card-title mb-0 text-white">Data Users</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 text-nowrap">
                        <thead style="background-color: #064e3b">
                            <tr>
                                <th class="text-white py-3" style="width: 1%;">NO.</th>
                                <th class="text-white py-3">NAME</th>
                                <th class="text-white py-3" style="width: 1%;">USERNAME</th>
                                <th class="text-white py-3" style="width: 1%;">EMAIL</th>
                                <th class="text-white py-3" style="width: 1%;">ROLE</th>
                                <th class="text-white py-3" style="width: 1%;">UNITS</th>
                                <th class="text-white py-3 text-end" style="width: 80px;">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $d)
                                <tr>
                                    <td class="py-2">{{ $loop->iteration + $users->firstItem() - 1 }}</td>
                                    <td class="py-2">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="avatar avatar-xs">
                                                <span class="avatar-initial rounded-circle bg-label-success">{{ substr($d->name, 0, 1) }}</span>
                                            </div>
                                            <span class="fw-bold">{{ $d->name }}</span>
                                        </div>
                                    </td>
                                    <td class="py-2">{{ $d->username }}</td>
                                    <td class="py-2">{{ $d->email }}</td>
                                    <td class="py-2">
                                        @foreach ($d->roles as $role)
                                            <span class="badge bg-label-info">{{ ucwords($role->name) }}</span>
                                        @endforeach
                                    </td>
                                    <td class="py-2">{{ $d->nama_unit }}</td>
                                    <td class="py-2 text-end">
                                        <div class="d-flex justify-content-end gap-1">
                                            <a href="#" class="btn btn-icon btn-label-success border editUser"
                                                style="width: 28px; height: 28px;"
                                                id="{{ Crypt::encrypt($d->id) }}">
                                                <i class="ti ti-edit fs-6"></i>
                                            </a>
                                            <form method="POST" name="deleteform" class="deleteform"
                                                action="{{ route('users.delete', Crypt::encrypt($d->id)) }}">
                                                @csrf
                                                @method('DELETE')
                                                <a href="#" class="btn btn-icon btn-label-danger border delete-confirm"
                                                    style="width: 28px; height: 28px;">
                                                    <i class="ti ti-trash fs-6"></i>
                                                </a>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center p-5">
                                        <div class="mb-3">
                                            <i class="ti ti-users fs-1 opacity-25"></i>
                                        </div>
                                        <h5>Belum Ada Data User</h5>
                                        <p class="text-muted">Silahkan tambah user baru atau sesuaikan filter pencarian.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-3">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<x-modal-form id="mdlcreateUser" size="" show="loadcreateUser" title="Tambah User" />
<x-modal-form id="mdleditUser" size="" show="loadeditUser" title="Edit User" />
@endsection

@push('myscript')
<script>
    $(function() {
        $("#btncreateUser").click(function(e) {
            $('#mdlcreateUser').modal("show");
            $("#loadcreateUser").load('/users/create');
        });

        $(".editUser").click(function(e) {
            var id = $(this).attr("id");
            e.preventDefault();
            $('#mdleditUser').modal("show");
            $("#loadeditUser").load('/users/' + id + '/edit');
        });
    });
</script>
@endpush

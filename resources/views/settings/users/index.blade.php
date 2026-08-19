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
            <form action="{{ route('users.index') }}" method="GET">
                @if(request('role'))
                    <input type="hidden" name="role" value="{{ request('role') }}">
                @endif
                <div class="d-flex gap-2">
                    <div class="input-group input-group-merge border shadow-none rounded-2"
                        style="border-color: #e0e0e0 !important;">
                        <span class="input-group-text bg-white border-0"><i class="ti ti-search text-muted"></i></span>
                        <input type="text" name="name" class="form-control bg-white border-0 ps-2"
                            placeholder="Cari Nama User..." value="{{ Request('name') }}">
                    </div>
                    <button type="submit" class="btn shadow-none d-flex align-items-center gap-2 text-white px-4"
                        style="background-color: #064e3b">
                        <i class="ti ti-search fs-5"></i> Cari
                    </button>
                    @if(request('name') || request('role'))
                        <a href="{{ route('users.index') }}" class="btn btn-label-secondary d-flex align-items-center justify-content-center px-3" data-bs-toggle="tooltip" title="Reset Filter">
                            <i class="ti ti-refresh fs-5"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Card Table -->
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-3 text-white py-3" style="background-color: #064e3b">
                <div class="d-flex align-items-center gap-2">
                    <i class="ti ti-users fs-5"></i>
                    <h6 class="card-title mb-0 text-white">Data Users</h6>
                </div>
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <!-- Status Filter -->
                    <div class="d-flex align-items-center gap-2">
                        <span class="small opacity-75" style="font-size: 0.8rem">Status:</span>
                        <ul class="nav nav-pills" role="tablist" style="gap: 3px;">
                            <li class="nav-item">
                                <a href="{{ route('users.index', array_merge(request()->query(), ['status' => ''])) }}" 
                                   class="nav-link py-1 px-2 {{ empty(request('status')) ? 'bg-white text-success fw-bold' : 'text-white' }}" 
                                   style="font-size: 0.8rem; {{ empty(request('status')) ? 'color: #064e3b !important; background-color: #fff !important;' : 'border: 1px solid rgba(255,255,255,0.4);' }}">
                                    Semua
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('users.index', array_merge(request()->query(), ['status' => 'aktif'])) }}" 
                                   class="nav-link py-1 px-2 {{ request('status') == 'aktif' ? 'bg-white text-success fw-bold' : 'text-white' }}" 
                                   style="font-size: 0.8rem; {{ request('status') == 'aktif' ? 'color: #064e3b !important; background-color: #fff !important;' : 'border: 1px solid rgba(255,255,255,0.4);' }}">
                                    Aktif
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('users.index', array_merge(request()->query(), ['status' => 'nonaktif'])) }}" 
                                   class="nav-link py-1 px-2 {{ request('status') == 'nonaktif' ? 'bg-white text-success fw-bold' : 'text-white' }}" 
                                   style="font-size: 0.8rem; {{ request('status') == 'nonaktif' ? 'color: #064e3b !important; background-color: #fff !important;' : 'border: 1px solid rgba(255,255,255,0.4);' }}">
                                    Nonaktif
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="vr bg-white opacity-50 my-1" style="height: 18px; width: 1px;"></div>

                    <!-- Kategori Filter -->
                    <div class="d-flex align-items-center gap-2">
                        <span class="small opacity-75" style="font-size: 0.8rem">Kategori:</span>
                        <ul class="nav nav-pills" role="tablist" style="gap: 3px;">
                            <li class="nav-item">
                                <a href="{{ route('users.index', array_merge(request()->query(), ['role' => ''])) }}" 
                                   class="nav-link py-1 px-2 {{ empty(request('role')) ? 'bg-white text-success fw-bold' : 'text-white' }}" 
                                   style="font-size: 0.8rem; {{ empty(request('role')) ? 'color: #064e3b !important; background-color: #fff !important;' : 'border: 1px solid rgba(255,255,255,0.4);' }}">
                                    Semua
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('users.index', array_merge(request()->query(), ['role' => 'karyawan'])) }}" 
                                   class="nav-link py-1 px-2 {{ request('role') == 'karyawan' ? 'bg-white text-success fw-bold' : 'text-white' }}" 
                                   style="font-size: 0.8rem; {{ request('role') == 'karyawan' ? 'color: #064e3b !important; background-color: #fff !important;' : 'border: 1px solid rgba(255,255,255,0.4);' }}">
                                    Karyawan
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('users.index', array_merge(request()->query(), ['role' => 'lainnya'])) }}" 
                                   class="nav-link py-1 px-2 {{ request('role') == 'lainnya' ? 'bg-white text-success fw-bold' : 'text-white' }}" 
                                   style="font-size: 0.8rem; {{ request('role') == 'lainnya' ? 'color: #064e3b !important; background-color: #fff !important;' : 'border: 1px solid rgba(255,255,255,0.4);' }}">
                                    Lainnya
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
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
                                <th class="text-white py-3" style="width: 1%;">STATUS</th>
                                <th class="text-white py-3 text-end" style="width: 80px;">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $d)
                                <tr>
                                    <td class="py-1">{{ $loop->iteration + $users->firstItem() - 1 }}</td>
                                    <td class="py-1">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="avatar avatar-xs">
                                                <span class="avatar-initial rounded-circle bg-label-success">{{ substr($d->name, 0, 1) }}</span>
                                            </div>
                                            <span class="fw-bold">{{ $d->name }}</span>
                                        </div>
                                    </td>
                                    <td class="py-1">{{ $d->username }}</td>
                                    <td class="py-1">{{ $d->email }}</td>
                                    <td class="py-1">
                                        @foreach ($d->roles as $role)
                                            <span class="badge bg-label-info">{{ ucwords($role->name) }}</span>
                                        @endforeach
                                    </td>
                                    <td class="py-1">{{ $d->nama_unit }}</td>
                                    <td class="py-1">
                                        <a href="{{ route('users.updatestatus', Crypt::encrypt($d->id)) }}">
                                            @if ($d->status == 1)
                                                <span class="badge bg-label-success rounded-pill px-3">AKTIF</span>
                                            @else
                                                <span class="badge bg-label-danger rounded-pill px-3">OFF</span>
                                            @endif
                                        </a>
                                    </td>
                                    <td class="py-1 text-end">
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
                                    <td colspan="8" class="text-center p-5">
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

@extends('layouts.app')
@section('titlepage', 'User Permissions')

@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-shield-lock fs-3" style="color: #064e3b"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Set Hak Akses User: {{ $user->name }}</h4>
                        <div class="d-flex align-items-center gap-2 mt-1">
                            <span class="text-muted small">Username: <strong>{{ $user->username }}</strong></span>
                            <span class="text-muted small">•</span>
                            <span class="text-muted small">Role: </span>
                            @forelse ($user->roles as $role)
                                <span class="badge bg-label-primary font-weight-bold">{{ ucwords($role->name) }}</span>
                            @empty
                                <span class="badge bg-label-secondary">Tanpa Role</span>
                            @endforelse
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-column align-items-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('users.index') }}" class="text-muted">
                                    <i class="ti ti-settings me-1"></i> Konfigurasi
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('users.index') }}" class="text-muted">Users</a>
                            </li>
                            <li class="breadcrumb-item active">Set Permission</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
<div class="alert alert-info d-flex align-items-center mb-4" role="alert">
    <i class="ti ti-info-circle fs-4 me-2"></i>
    <div>
        <strong>Informasi:</strong> Permission bertanda <span class="badge bg-label-success"><i class="ti ti-lock me-1"></i>Bawaan Role</span> sudah otomatis aktif dari role user dan <strong>terkunci</strong> (tidak dapat diubah di sini). Anda dapat mencentang permission tambahan lain khusus untuk user ini.
    </div>
</div>

<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary d-flex align-items-center gap-2 shadow-sm">
        <i class="ti ti-arrow-left fs-5"></i> Kembali
    </a>
    <div class="d-flex gap-2">
        <button type="button" class="btn btn-label-primary d-flex align-items-center gap-2 shadow-sm" id="selectAll">
            <i class="ti ti-square-check fs-5"></i> Pilih Semua (Tambahan)
        </button>
        <button type="button" class="btn btn-label-danger d-flex align-items-center gap-2 shadow-sm" id="deselectAll">
            <i class="ti ti-square-x fs-5"></i> Kosongkan Tambahan
        </button>
    </div>
</div>

<form action="{{ route('users.storeuserpermission', Crypt::encrypt($user->id)) }}" method="POST">
    @csrf

    <div class="row">
        @foreach ($permissions as $key => $d)
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4">
                <div class="card shadow-sm h-100 border-0">
                    <div class="card-header d-flex align-items-center justify-content-between text-white py-3" style="background-color: #064e3b; border-bottom: 3px solid #053e2f;">
                        <h6 class="card-title mb-0 text-white fw-bold d-flex align-items-center gap-2">
                            <i class="ti ti-folder fs-5"></i> {{ $d->group_name }}
                        </h6>
                        <div class="form-check mb-0">
                            <input class="form-check-input select-all-group border-white" type="checkbox" data-group="{{ $d->id_permission_group }}" id="selectGroup{{ $d->id_permission_group }}">
                            <label class="form-check-label text-white small cursor-pointer" for="selectGroup{{ $d->id_permission_group }}">
                                Semua
                            </label>
                        </div>
                    </div>
                    <div class="card-body pt-3">
                        @php
                            $list_permissions = explode(',', $d->permissions);
                        @endphp
                        @foreach ($list_permissions as $p)
                            @php
                                $permission = explode('-', $p);
                                $permission_id = $permission[0];
                                $permission_name = $permission[1];
                                $isFromRole = in_array($permission_name, $rolePermissions);
                                $isDirect = in_array($permission_name, $directPermissions);
                            @endphp
                            <div class="form-check mt-2 d-flex align-items-start justify-content-between">
                                <div class="w-100">
                                    @if ($isFromRole)
                                        {{-- Locked checkbox if inherited from Role --}}
                                        <input class="form-check-input permission-checkbox" type="checkbox" 
                                            value="{{ $permission_name }}" id="defaultCheck{{ $permission_id }}"
                                            data-group="{{ $d->id_permission_group }}"
                                            checked disabled>
                                        {{-- Hidden input so form value behaves consistently if needed, though role is already handled on backend --}}
                                        <label class="form-check-label text-muted py-1 d-flex align-items-center justify-content-between w-100" for="defaultCheck{{ $permission_id }}">
                                            <span>{{ $permission_name }}</span>
                                            <span class="badge bg-label-success ms-1 small" style="font-size: 0.7rem;" title="Hak akses bawaan role (permanen)"><i class="ti ti-lock me-1"></i>Role</span>
                                        </label>
                                    @else
                                        {{-- Editable checkbox for custom user permissions --}}
                                        <input class="form-check-input permission-checkbox editable-permission" type="checkbox" name="permission[]"
                                            value="{{ $permission_name }}" id="defaultCheck{{ $permission_id }}"
                                            data-group="{{ $d->id_permission_group }}"
                                            {{ $isDirect ? 'checked' : '' }}>
                                        <label class="form-check-label text-dark py-1 cursor-pointer w-100" for="defaultCheck{{ $permission_id }}">
                                            {{ $permission_name }}
                                        </label>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row mt-3 mb-5">
        <div class="col-12">
            <button type="submit" class="btn text-white w-100 py-3 shadow-md d-flex align-items-center justify-content-center gap-2" style="background-color: #064e3b; font-size: 1.1rem; font-weight: 600; border: none; border-radius: 8px;">
                <i class="ti ti-device-floppy fs-4"></i>
                Simpan Hak Akses User
            </button>
        </div>
    </div>
</form>
@endsection

@push('myscript')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectAllBtn = document.getElementById('selectAll');
        const deselectAllBtn = document.getElementById('deselectAll');
        const editableCheckboxes = document.querySelectorAll('.editable-permission');
        const allCheckboxes = document.querySelectorAll('.permission-checkbox');
        const groupCheckboxes = document.querySelectorAll('.select-all-group');

        // Initial setup for group checkboxes
        groupCheckboxes.forEach(groupCb => {
            const groupId = groupCb.getAttribute('data-group');
            const groupItemCbs = document.querySelectorAll(`.permission-checkbox[data-group="${groupId}"]`);
            updateGroupHeaderCheckbox(groupCb, groupItemCbs);

            groupCb.addEventListener('change', function () {
                const isChecked = this.checked;
                // Only toggle editable ones
                const groupEditableCbs = document.querySelectorAll(`.editable-permission[data-group="${groupId}"]`);
                groupEditableCbs.forEach(cb => {
                    cb.checked = isChecked;
                });
                updateGroupHeaderCheckbox(this, groupItemCbs);
            });
        });

        // Global Select All (only selects editable checkboxes)
        if (selectAllBtn) {
            selectAllBtn.addEventListener('click', function () {
                editableCheckboxes.forEach(cb => cb.checked = true);
                groupCheckboxes.forEach(groupCb => {
                    const groupId = groupCb.getAttribute('data-group');
                    const groupItemCbs = document.querySelectorAll(`.permission-checkbox[data-group="${groupId}"]`);
                    updateGroupHeaderCheckbox(groupCb, groupItemCbs);
                });
            });
        }

        // Global Deselect All (only unchecks editable checkboxes)
        if (deselectAllBtn) {
            deselectAllBtn.addEventListener('click', function () {
                editableCheckboxes.forEach(cb => cb.checked = false);
                groupCheckboxes.forEach(groupCb => {
                    const groupId = groupCb.getAttribute('data-group');
                    const groupItemCbs = document.querySelectorAll(`.permission-checkbox[data-group="${groupId}"]`);
                    updateGroupHeaderCheckbox(groupCb, groupItemCbs);
                });
            });
        }

        // Individual permission check listener to update group checkbox
        editableCheckboxes.forEach(cb => {
            cb.addEventListener('change', function () {
                const groupId = this.getAttribute('data-group');
                const groupCb = document.querySelector(`.select-all-group[data-group="${groupId}"]`);
                const groupItemCbs = document.querySelectorAll(`.permission-checkbox[data-group="${groupId}"]`);
                if (groupCb) {
                    updateGroupHeaderCheckbox(groupCb, groupItemCbs);
                }
            });
        });

        function updateGroupHeaderCheckbox(groupHeaderCb, itemCbs) {
            const total = itemCbs.length;
            const checkedCount = Array.from(itemCbs).filter(cb => cb.checked).length;
            
            if (checkedCount === total && total > 0) {
                groupHeaderCb.checked = true;
                groupHeaderCb.indeterminate = false;
            } else if (checkedCount > 0 && checkedCount < total) {
                groupHeaderCb.checked = false;
                groupHeaderCb.indeterminate = true;
            } else {
                groupHeaderCb.checked = false;
                groupHeaderCb.indeterminate = false;
            }
        }
    });
</script>
@endpush

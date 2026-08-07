@extends('layouts.app')
@section('titlepage', 'Roles')

@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-shield-lock fs-3" style="color: #064e3b"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Set Permission: {{ ucwords($role->name) }}</h4>
                        <p class="text-muted mb-0 small">Manajemen hak akses untuk role <strong>{{ ucwords($role->name) }}</strong></p>
                    </div>
                </div>
                <div class="d-flex flex-column align-items-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('roles.index') }}" class="text-muted">
                                    <i class="ti ti-settings me-1"></i> Konfigurasi
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('roles.index') }}" class="text-muted">Roles</a>
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
<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary d-flex align-items-center gap-2 shadow-sm">
        <i class="ti ti-arrow-left fs-5"></i> Kembali
    </a>
    <div class="d-flex gap-2">
        <button type="button" class="btn btn-label-primary d-flex align-items-center gap-2 shadow-sm" id="selectAll">
            <i class="ti ti-square-check fs-5"></i> Pilih Semua
        </button>
        <button type="button" class="btn btn-label-danger d-flex align-items-center gap-2 shadow-sm" id="deselectAll">
            <i class="ti ti-square-x fs-5"></i> Kosongkan Semua
        </button>
    </div>
</div>

<form action="{{ route('roles.storerolepermission', Crypt::encrypt($role->id)) }}" method="POST">
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
                            <label class="form-check-label text-white small" for="selectGroup{{ $d->id_permission_group }}">
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
                                $cek = in_array($permission_name, $rolepermissions);
                            @endphp
                            <div class="form-check mt-2">
                                <input class="form-check-input permission-checkbox" type="checkbox" name="permission[]"
                                    value="{{ $permission_name }}" id="defaultCheck{{ $permission_id }}"
                                    data-group="{{ $d->id_permission_group }}"
                                    {{ $cek > 0 ? 'checked' : '' }}>
                                <label class="form-check-label text-dark py-1 cursor-pointer w-100" for="defaultCheck{{ $permission_id }}">
                                    {{ $permission_name }}
                                </label>
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
                Simpan Perubahan Hak Akses
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
        const checkboxes = document.querySelectorAll('.permission-checkbox');
        const groupCheckboxes = document.querySelectorAll('.select-all-group');

        // Global Select All
        if (selectAllBtn) {
            selectAllBtn.addEventListener('click', function () {
                checkboxes.forEach(cb => cb.checked = true);
                groupCheckboxes.forEach(cb => cb.checked = true);
            });
        }

        // Global Deselect All
        if (deselectAllBtn) {
            deselectAllBtn.addEventListener('click', function () {
                checkboxes.forEach(cb => cb.checked = false);
                groupCheckboxes.forEach(cb => cb.checked = false);
            });
        }

        // Group-level Select All toggle
        groupCheckboxes.forEach(groupCb => {
            const groupId = groupCb.getAttribute('data-group');
            const groupPermissionCbs = document.querySelectorAll(`.permission-checkbox[data-group="${groupId}"]`);

            // Initialize group check state
            updateGroupHeaderCheckbox(groupCb, groupPermissionCbs);

            groupCb.addEventListener('change', function () {
                const isChecked = this.checked;
                groupPermissionCbs.forEach(cb => {
                    cb.checked = isChecked;
                });
            });
        });

        // Individual permission check listener to update group checkbox
        checkboxes.forEach(cb => {
            cb.addEventListener('change', function () {
                const groupId = this.getAttribute('data-group');
                const groupCb = document.querySelector(`.select-all-group[data-group="${groupId}"]`);
                const groupPermissionCbs = document.querySelectorAll(`.permission-checkbox[data-group="${groupId}"]`);
                if (groupCb) {
                    updateGroupHeaderCheckbox(groupCb, groupPermissionCbs);
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


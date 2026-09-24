@extends('layouts.app')
@section('titlepage', 'Hak Akses Unit & Departemen')

@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-info rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-building-community fs-3" style="color: #064e3b"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Hak Akses Unit & Departemen: {{ $user->name }}</h4>
                        <div class="d-flex align-items-center gap-2 mt-1 flex-wrap">
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
                            <li class="breadcrumb-item active">Akses Unit & Dept</li>
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
        <strong>Informasi Hak Akses:</strong>
        Secara default, user hanya dapat mengakses unit dan departemen utama miliknya (<span class="badge bg-label-success"><i class="ti ti-lock me-1"></i>Utama</span>). Anda dapat menambahkan akses ke data unit dan departemen lain dengan mencentang pilihan di bawah ini. Khusus akun dengan role <code>super admin</code> otomatis memiliki akses ke semua data.
    </div>
</div>

<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary d-flex align-items-center gap-2 shadow-sm">
        <i class="ti ti-arrow-left fs-5"></i> Kembali ke Data Users
    </a>
</div>

<form action="{{ route('users.storeuserunitdept', Crypt::encrypt($user->id)) }}" method="POST">
    @csrf

    {{-- KARTU HAK AKSES UNIT --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header d-flex align-items-center justify-content-between text-white py-3" style="background-color: #064e3b; border-bottom: 3px solid #053e2f;">
            <div class="d-flex align-items-center gap-2">
                <i class="ti ti-building fs-4"></i>
                <div>
                    <h6 class="card-title mb-0 text-white fw-bold">Hak Akses Data Unit</h6>
                    <small class="text-white opacity-75">Tentukan data unit mana saja yang diizinkan untuk diakses user</small>
                </div>
            </div>
            @if(!empty($defaultUnit))
                <span class="badge bg-white text-success fw-bold px-3 py-1">
                    <i class="ti ti-home me-1"></i> Unit Utama: {{ $user->unit->nama_unit ?? $defaultUnit }}
                </span>
            @endif
        </div>
        <div class="card-body pt-3 pb-3">
            <div class="d-flex justify-content-end mb-2 gap-2">
                <button type="button" class="btn btn-xs btn-outline-primary" id="selectAllUnits">Pilih Semua Unit</button>
                <button type="button" class="btn btn-xs btn-outline-danger" id="deselectAllUnits">Kosongkan Unit Tambahan</button>
            </div>
            <div class="row">
                @foreach ($allUnits as $u)
                    @php
                        $isDefault = ($u->kode_unit === $defaultUnit);
                        $isAssigned = in_array($u->kode_unit, $assignedUnitCodes);
                    @endphp
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 my-2">
                        <div class="p-2 rounded border d-flex align-items-center justify-content-between {{ $isDefault ? 'bg-light' : '' }}" style="border-color: #e5e7eb !important;">
                            <div class="form-check mb-0 d-flex align-items-center w-100">
                                @if ($isDefault)
                                    <input class="form-check-input me-2" type="checkbox"
                                        id="unitCheck{{ $u->kode_unit }}"
                                        checked disabled>
                                    <label class="form-check-label text-muted d-flex align-items-center justify-content-between w-100 pe-2" for="unitCheck{{ $u->kode_unit }}">
                                        <span class="fw-semibold text-dark">{{ $u->nama_unit }}</span>
                                        <span class="badge bg-label-success ms-1 small" style="font-size: 0.7rem;" title="Unit utama user (otomatis aktif)"><i class="ti ti-lock me-1"></i>Utama</span>
                                    </label>
                                @else
                                    <input class="form-check-input me-2 unit-checkbox" type="checkbox" name="unit_access[]"
                                        value="{{ $u->kode_unit }}" id="unitCheck{{ $u->kode_unit }}"
                                        {{ $isAssigned ? 'checked' : '' }}>
                                    <label class="form-check-label text-dark cursor-pointer fw-semibold w-100" for="unitCheck{{ $u->kode_unit }}">
                                        {{ $u->nama_unit }}
                                    </label>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- KARTU HAK AKSES DEPARTEMEN --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header d-flex align-items-center justify-content-between text-white py-3" style="background-color: #064e3b; border-bottom: 3px solid #053e2f;">
            <div class="d-flex align-items-center gap-2">
                <i class="ti ti-briefcase fs-4"></i>
                <div>
                    <h6 class="card-title mb-0 text-white fw-bold">Hak Akses Data Departemen</h6>
                    <small class="text-white opacity-75">Tentukan data departemen mana saja yang diizinkan untuk diakses user</small>
                </div>
            </div>
            @if(!empty($defaultDept))
                <span class="badge bg-white text-success fw-bold px-3 py-1">
                    <i class="ti ti-briefcase me-1"></i> Dept Utama: {{ $user->departemen->nama_dept ?? $defaultDept }}
                </span>
            @endif
        </div>
        <div class="card-body pt-3 pb-3">
            <div class="d-flex justify-content-end mb-2 gap-2">
                <button type="button" class="btn btn-xs btn-outline-primary" id="selectAllDepts">Pilih Semua Dept</button>
                <button type="button" class="btn btn-xs btn-outline-danger" id="deselectAllDepts">Kosongkan Dept Tambahan</button>
            </div>
            <div class="row">
                @foreach ($allDepts as $dept)
                    @php
                        $isDefault = ($dept->kode_dept === $defaultDept);
                        $isAssigned = in_array($dept->kode_dept, $assignedDeptCodes);
                    @endphp
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 my-2">
                        <div class="p-2 rounded border d-flex align-items-center justify-content-between {{ $isDefault ? 'bg-light' : '' }}" style="border-color: #e5e7eb !important;">
                            <div class="form-check mb-0 d-flex align-items-center w-100">
                                @if ($isDefault)
                                    <input class="form-check-input me-2" type="checkbox"
                                        id="deptCheck{{ $dept->kode_dept }}"
                                        checked disabled>
                                    <label class="form-check-label text-muted d-flex align-items-center justify-content-between w-100 pe-2" for="deptCheck{{ $dept->kode_dept }}">
                                        <span class="fw-semibold text-dark">{{ $dept->nama_dept }}</span>
                                        <span class="badge bg-label-success ms-1 small" style="font-size: 0.7rem;" title="Departemen utama user (otomatis aktif)"><i class="ti ti-lock me-1"></i>Utama</span>
                                    </label>
                                @else
                                    <input class="form-check-input me-2 dept-checkbox" type="checkbox" name="dept_access[]"
                                        value="{{ $dept->kode_dept }}" id="deptCheck{{ $dept->kode_dept }}"
                                        {{ $isAssigned ? 'checked' : '' }}>
                                    <label class="form-check-label text-dark cursor-pointer fw-semibold w-100" for="deptCheck{{ $dept->kode_dept }}">
                                        {{ $dept->nama_dept }}
                                    </label>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="row mt-3 mb-5">
        <div class="col-12">
            <button type="submit" class="btn text-white w-100 py-3 shadow-md d-flex align-items-center justify-content-center gap-2" style="background-color: #064e3b; font-size: 1.1rem; font-weight: 600; border: none; border-radius: 8px;">
                <i class="ti ti-device-floppy fs-4"></i>
                Simpan Hak Akses Unit & Departemen
            </button>
        </div>
    </div>
</form>
@endsection

@push('myscript')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectAllUnits = document.getElementById('selectAllUnits');
        const deselectAllUnits = document.getElementById('deselectAllUnits');
        const unitCheckboxes = document.querySelectorAll('.unit-checkbox');

        const selectAllDepts = document.getElementById('selectAllDepts');
        const deselectAllDepts = document.getElementById('deselectAllDepts');
        const deptCheckboxes = document.querySelectorAll('.dept-checkbox');

        if (selectAllUnits) {
            selectAllUnits.addEventListener('click', function () {
                unitCheckboxes.forEach(cb => cb.checked = true);
            });
        }
        if (deselectAllUnits) {
            deselectAllUnits.addEventListener('click', function () {
                unitCheckboxes.forEach(cb => cb.checked = false);
            });
        }

        if (selectAllDepts) {
            selectAllDepts.addEventListener('click', function () {
                deptCheckboxes.forEach(cb => cb.checked = true);
            });
        }
        if (deselectAllDepts) {
            deselectAllDepts.addEventListener('click', function () {
                deptCheckboxes.forEach(cb => cb.checked = false);
            });
        }
    });
</script>
@endpush

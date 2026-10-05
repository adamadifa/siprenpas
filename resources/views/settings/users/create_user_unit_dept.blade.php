@extends('layouts.app')
@section('titlepage', 'Hak Akses Unit & Departemen')

@section('content')
<div class="space-y-6">

    <!-- ================= 1. PAGE HEADER (NO CARD) WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center border border-emerald-200/80 shadow-2xs">
                    <i class="ti ti-building-community text-2xl"></i>
                </div>
                <span>Hak Akses Unit & Departemen</span>
            </h1>
            <div class="flex items-center gap-2 mt-1 text-xs text-slate-500 flex-wrap">
                <span>Pengguna: <strong class="text-slate-800">{{ $user->name }}</strong></span>
                <span>&bull;</span>
                <span>Username: <strong class="text-slate-800 font-mono">{{ $user->username }}</strong></span>
                <span>&bull;</span>
                <span>Role: </span>
                @forelse ($user->roles as $role)
                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-sky-50 text-sky-800 border border-sky-200">
                        {{ ucwords($role->name) }}
                    </span>
                @empty
                    <span class="text-slate-400 italic">Tanpa Role</span>
                @endforelse
            </div>
        </div>

        <!-- Right Side: Breadcrumb & Actions -->
        <div class="flex flex-col md:items-end gap-2.5">
            <!-- Breadcrumb Navigation -->
            <nav class="flex items-center text-xs text-slate-400 font-medium">
                <a href="{{ route('dashboard.index') }}" class="hover:text-slate-700 transition flex items-center gap-1">
                    <i class="ti ti-home text-sm"></i>
                    <span>Dashboard</span>
                </a>
                <span class="mx-2 text-slate-300">/</span>
                <span class="text-slate-500 flex items-center gap-1">
                    <i class="ti ti-settings text-sm"></i>
                    <span>Konfigurasi</span>
                </span>
                <span class="mx-2 text-slate-300">/</span>
                <a href="{{ route('users.index') }}" class="hover:text-slate-700 transition">
                    <span>Users</span>
                </a>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Akses Unit & Dept</span>
            </nav>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('users.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white hover:bg-slate-100 text-slate-700 font-bold rounded-xl text-xs border border-slate-300/90 shadow-2xs transition-all duration-200 active:scale-95">
                    <i class="ti ti-arrow-left text-base text-emerald-600"></i>
                    <span>Kembali ke Data Users</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Info Callout Alert -->
    <div class="flex items-start gap-3 p-4 bg-emerald-50/80 border border-emerald-200/90 rounded-2xl text-emerald-950">
        <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 text-base font-bold">
            <i class="ti ti-info-circle"></i>
        </div>
        <div class="text-xs space-y-1">
            <h4 class="font-bold text-emerald-950">Informasi Pembagian Hak Akses Multidatabase:</h4>
            <p class="text-emerald-800 leading-relaxed">
                Secara default, pengguna hanya memiliki akses ke <strong>Unit</strong> dan <strong>Departemen Utama</strong> miliknya (ditandai dengan badge <span class="inline-flex items-center px-1.5 py-0.5 rounded bg-emerald-100 text-emerald-800 font-bold text-[10px]"><i class="ti ti-lock text-[10px] mr-0.5"></i>Utama</span>). Anda dapat memberikan wewenang tambahan ke unit atau cabang lain dengan mencentang kotak di bawah ini. Akun dengan role <code class="bg-emerald-100/70 px-1 py-0.5 rounded font-bold">super admin</code> secara otomatis memiliki akses penuh ke seluruh data.
            </p>
        </div>
    </div>

    <!-- Form Access -->
    <form action="{{ route('users.storeuserunitdept', Crypt::encrypt($user->id)) }}" method="POST" class="space-y-6">
        @csrf

        <!-- ================= 2. KARTU HAK AKSES DATA UNIT ================= -->
        <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
            <!-- Solid Emerald Header -->
            <div class="bg-emerald-600 px-5 py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-white">
                <div class="flex items-center gap-2.5">
                    <i class="ti ti-building text-xl"></i>
                    <div>
                        <h3 class="font-bold text-sm tracking-wide text-white">Hak Akses Data Unit / Jenjang</h3>
                        <p class="text-[11px] text-emerald-100 mt-0.5">Tentukan data unit mana saja yang diizinkan untuk dikelola oleh pengguna ini</p>
                    </div>
                </div>
                
                @if(!empty($defaultUnit))
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-white text-emerald-800 shadow-2xs self-start sm:self-auto">
                        <i class="ti ti-home text-xs"></i>
                        <span>Unit Utama: {{ $user->unit->nama_unit ?? $defaultUnit }}</span>
                    </span>
                @endif
            </div>

            <div class="p-5 sm:p-6 space-y-4">
                <!-- Toolbar Quick Actions -->
                <div class="flex items-center justify-end gap-2 pb-2 border-b border-slate-100">
                    <button type="button" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-lg text-xs transition cursor-pointer" id="selectAllUnits">
                        Pilih Semua Unit
                    </button>
                    <button type="button" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold rounded-lg text-xs transition cursor-pointer" id="deselectAllUnits">
                        Kosongkan Tambahan
                    </button>
                </div>

                <!-- Units Checkbox Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                    @foreach ($allUnits as $u)
                        @php
                            $isDefault = ($u->kode_unit === $defaultUnit);
                            $isAssigned = in_array($u->kode_unit, $assignedUnitCodes);
                        @endphp
                        <div class="p-3 rounded-xl border transition-all flex items-center justify-between {{ $isDefault ? 'bg-slate-50 border-slate-200 opacity-90' : 'bg-white border-slate-200 hover:border-emerald-500/50 hover:shadow-2xs' }}">
                            <label class="flex items-center gap-2.5 w-full cursor-pointer select-none">
                                @if ($isDefault)
                                    <input type="checkbox" checked disabled class="w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500 border-slate-300 cursor-not-allowed">
                                    <div class="flex items-center justify-between w-full">
                                        <span class="font-bold text-slate-800 text-xs">{{ $u->nama_unit }}</span>
                                        <span class="inline-flex items-center gap-0.5 px-1.5 py-0.5 rounded bg-emerald-100 text-emerald-800 font-bold text-[10px]" title="Unit utama user (otomatis aktif)">
                                            <i class="ti ti-lock text-[10px]"></i>
                                            <span>Utama</span>
                                        </span>
                                    </div>
                                @else
                                    <input type="checkbox" name="unit_access[]" value="{{ $u->kode_unit }}" id="unitCheck{{ $u->kode_unit }}" {{ $isAssigned ? 'checked' : '' }} class="unit-checkbox w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500 border-slate-300 transition cursor-pointer">
                                    <span class="font-semibold text-slate-700 text-xs">{{ $u->nama_unit }}</span>
                                @endif
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- ================= 3. KARTU HAK AKSES DATA DEPARTEMEN ================= -->
        <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
            <!-- Solid Emerald Header -->
            <div class="bg-emerald-600 px-5 py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-white">
                <div class="flex items-center gap-2.5">
                    <i class="ti ti-briefcase text-xl"></i>
                    <div>
                        <h3 class="font-bold text-sm tracking-wide text-white">Hak Akses Data Departemen</h3>
                        <p class="text-[11px] text-emerald-100 mt-0.5">Tentukan departemen mana saja yang diizinkan untuk diakses user</p>
                    </div>
                </div>
                
                @if(!empty($defaultDept))
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-white text-emerald-800 shadow-2xs self-start sm:self-auto">
                        <i class="ti ti-briefcase text-xs"></i>
                        <span>Dept Utama: {{ $user->departemen->nama_dept ?? $defaultDept }}</span>
                    </span>
                @endif
            </div>

            <div class="p-5 sm:p-6 space-y-4">
                <!-- Toolbar Quick Actions -->
                <div class="flex items-center justify-end gap-2 pb-2 border-b border-slate-100">
                    <button type="button" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-lg text-xs transition cursor-pointer" id="selectAllDepts">
                        Pilih Semua Dept
                    </button>
                    <button type="button" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold rounded-lg text-xs transition cursor-pointer" id="deselectAllDepts">
                        Kosongkan Tambahan
                    </button>
                </div>

                <!-- Dept Checkbox Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                    @foreach ($allDepts as $dept)
                        @php
                            $isDefault = ($dept->kode_dept === $defaultDept);
                            $isAssigned = in_array($dept->kode_dept, $assignedDeptCodes);
                        @endphp
                        <div class="p-3 rounded-xl border transition-all flex items-center justify-between {{ $isDefault ? 'bg-slate-50 border-slate-200 opacity-90' : 'bg-white border-slate-200 hover:border-emerald-500/50 hover:shadow-2xs' }}">
                            <label class="flex items-center gap-2.5 w-full cursor-pointer select-none">
                                @if ($isDefault)
                                    <input type="checkbox" checked disabled class="w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500 border-slate-300 cursor-not-allowed">
                                    <div class="flex items-center justify-between w-full">
                                        <span class="font-bold text-slate-800 text-xs">{{ $dept->nama_dept }}</span>
                                        <span class="inline-flex items-center gap-0.5 px-1.5 py-0.5 rounded bg-emerald-100 text-emerald-800 font-bold text-[10px]" title="Departemen utama user (otomatis aktif)">
                                            <i class="ti ti-lock text-[10px]"></i>
                                            <span>Utama</span>
                                        </span>
                                    </div>
                                @else
                                    <input type="checkbox" name="dept_access[]" value="{{ $dept->kode_dept }}" id="deptCheck{{ $dept->kode_dept }}" {{ $isAssigned ? 'checked' : '' }} class="dept-checkbox w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500 border-slate-300 transition cursor-pointer">
                                    <span class="font-semibold text-slate-700 text-xs">{{ $dept->nama_dept }}</span>
                                @endif
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Submit Button Bottom Sticky -->
        <div class="flex items-center justify-end gap-3 pt-2 pb-8">
            <a href="{{ route('users.index') }}" class="px-5 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs transition inline-flex items-center gap-2 cursor-pointer">
                <i class="ti ti-x text-base"></i>
                <span>Batal</span>
            </a>
            <button type="submit" class="px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs transition-all inline-flex items-center gap-2 active:scale-95 cursor-pointer">
                <i class="ti ti-device-floppy text-base"></i>
                <span>Simpan Hak Akses Unit & Departemen</span>
            </button>
        </div>
    </form>

</div>
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


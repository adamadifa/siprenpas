@extends('layouts.app')
@section('titlepage', 'Set Permission User - ' . $user->name)

@section('content')
<div class="space-y-5">

    <!-- ================= 1. PAGE HEADER WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle with User Identity -->
        <div class="flex items-center gap-3.5">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center border border-emerald-200/80 shadow-xs shrink-0">
                <i class="ti ti-shield-lock text-2xl"></i>
            </div>
            <div>
                <div class="flex items-center gap-2 flex-wrap">
                    <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
                        Hak Akses User: <span class="text-emerald-700">{{ $user->name }}</span>
                    </h1>
                    @forelse ($user->roles as $role)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                            {{ ucwords($role->name) }}
                        </span>
                    @empty
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                            Tanpa Role
                        </span>
                    @endforelse
                </div>
                <p class="text-xs text-slate-500 mt-0.5 flex items-center gap-2">
                    <span>Username: <strong class="text-slate-700 font-bold font-mono">{{ $user->username }}</strong></span>
                    <span>•</span>
                    <span>Email: <span class="text-slate-600">{{ $user->email ?? '-' }}</span></span>
                </p>
            </div>
        </div>

        <!-- Right Side: Breadcrumb Navigation -->
        <div class="flex flex-col md:items-end gap-2.5">
            <nav class="flex items-center text-xs text-slate-400 font-medium">
                <a href="{{ route('dashboard.index') }}" class="hover:text-slate-700 transition flex items-center gap-1">
                    <i class="ti ti-home text-sm"></i>
                    <span>Dashboard</span>
                </a>
                <span class="mx-2 text-slate-300">/</span>
                <a href="{{ route('users.index') }}" class="hover:text-slate-700 transition flex items-center gap-1">
                    <i class="ti ti-users text-sm"></i>
                    <span>Users</span>
                </a>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Set Permission</span>
            </nav>
            <a href="{{ route('users.index') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white hover:bg-slate-50 text-slate-700 font-bold rounded-xl text-xs border border-slate-200 shadow-2xs transition active:scale-95">
                <i class="ti ti-arrow-left text-sm"></i>
                <span>Kembali ke Data Users</span>
            </a>
        </div>
    </div>

    <!-- ================= 2. INFO BANNER ================= -->
    <div class="flex items-start gap-3 p-3.5 bg-emerald-50/70 border border-emerald-200/80 rounded-2xl text-emerald-950 text-xs shadow-2xs">
        <div class="w-7 h-7 rounded-xl bg-emerald-600 text-white flex items-center justify-center shrink-0 shadow-xs">
            <i class="ti ti-info-circle text-base"></i>
        </div>
        <div class="flex-1 leading-relaxed">
            <span class="font-extrabold text-emerald-900">Petunjuk Permission Pengguna:</span>
            Permission bertanda <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded-md bg-emerald-100 text-emerald-800 font-bold border border-emerald-200 text-[10px]"><i class="ti ti-lock text-[10px]"></i>Role</span> sudah aktif otomatis dari Role utama dan dikunci. Centang kotak permission tambahan untuk memberikan hak akses spesifik khusus bagi pengguna ini.
        </div>
    </div>

    @php
        // Mapping Structure Menu Utama -> Sub Menu Groups yang PERSIS sama dengan urutan Sidebar Super Admin
        $menuStructure = [
            'Data Master' => [
                'icon' => 'ti ti-database',
                'groups' => ['Karyawan', 'Jabatan', 'Siswa', 'Unit', 'Jenis Biaya', 'Departemen', 'Ledger', 'jenissimpanan', 'jenistabungan', 'jenispembiayaan', 'Kategori Ibadah', 'Kegiatan Ibadah'],
            ],
            'Pendaftaran' => [
                'icon' => 'ti ti-file-description',
                'groups' => ['Pendaftaran', 'Pendaftaran Online', 'Tahun Ajaran PPDB', 'Asal Sekolah'],
            ],
            'Akademik' => [
                'icon' => 'ti ti-school',
                'groups' => ['Guru', 'Akademik Siswa', 'Jabatan Akademik', 'Presensi Siswa', 'Mata Pelajaran', 'Kelas', 'Jadwal Pelajaran', 'akademik'],
            ],
            'Koperasi' => [
                'icon' => 'ti ti-moneybag',
                'groups' => ['anggota', 'simpanan', 'tabungan', 'Pembiayaan'],
            ],
            'Keuangan' => [
                'icon' => 'ti ti-wallet',
                'groups' => ['Pembayaran Pendidikan', 'Jenis Bayar', 'Rencana SPP', 'Ledger Transaksi', 'Kategori Pemasukan', 'Kategori Pengeluaran', 'Kategori Ledger', 'Saldo Awal Ledger', 'Laporan Keuangan', 'Sumber Dana'],
            ],
            'MSDM' => [
                'icon' => 'ti ti-users',
                'groups' => ['Presensi', 'Izin Absen', 'Izin Sakit', 'Jam Kerja'],
            ],
            'Kegiatan' => [
                'icon' => 'ti ti-activity',
                'groups' => ['Jobdesk', 'Program Kerja', 'Agenda Kegiatan', 'Realisasi Kegiatan', 'Agenda'],
            ],
            'Asrama' => [
                'icon' => 'ti ti-home-check',
                'groups' => ['Asrama Siswa'],
            ],
            'Al Amin Got Talent' => [
                'icon' => 'ti ti-award',
                'groups' => ['Perlombaan', 'Pendaftaran Got Talent', 'Jenjang Pendidikan'],
            ],
            'Website' => [
                'icon' => 'ti ti-globe',
                'groups' => ['Kategori', 'Post', 'Sebaran Alumni', 'Pages', 'Tentang Pesantren', 'Visi & Misi', 'PPDB Setting', 'Testimoni', 'Prestasi Siswa', 'Program Unggulan', 'Pilar Pendidikan', 'Gallery'],
            ],
            'Pengumuman' => [
                'icon' => 'ti ti-speakerphone',
                'groups' => ['Pengumuman', 'Kategori Pengumuman', 'Push Subscription'],
            ],
            'Konfigurasi' => [
                'icon' => 'ti ti-adjustments',
                'groups' => ['Tahun Ajaran', 'Biaya', 'Mesin Fingerprint', 'Migrasi Siswa'],
            ],
            'Kuisioner' => [
                'icon' => 'ti ti-clipboard-list',
                'groups' => ['Kuisioner'],
            ],
            'Settings' => [
                'icon' => 'ti ti-settings',
                'groups' => ['Pengaturan Umum'],
            ],
            'Lainnya / Modul Tambahan' => [
                'icon' => 'ti ti-box',
                'groups' => [],
            ],
        ];

        $groupedData = [];
        $assignedGroupIds = [];

        $permissionsByGroupName = [];
        foreach ($permissions as $p) {
            $cleanName = trim($p->name);
            $permissionsByGroupName[strtolower($cleanName)] = $p;
        }

        foreach ($menuStructure as $mainMenu => $meta) {
            $groupedData[$mainMenu] = [
                'icon' => $meta['icon'],
                'items' => []
            ];
            foreach ($meta['groups'] as $gName) {
                $key = strtolower(trim($gName));
                if (isset($permissionsByGroupName[$key])) {
                    $groupedData[$mainMenu]['items'][] = $permissionsByGroupName[$key];
                    $assignedGroupIds[] = $permissionsByGroupName[$key]->id;
                }
            }
        }

        foreach ($permissions as $p) {
            if (!in_array($p->id, $assignedGroupIds)) {
                $groupedData['Lainnya / Modul Tambahan']['items'][] = $p;
            }
        }
    @endphp

    <!-- ================= 3. STICKY ACTION & SEARCH TOOLBAR ================= -->
    <div class="sticky top-16 z-30 bg-white/95 backdrop-blur-md rounded-2xl border border-slate-200/90 shadow-md p-3 sm:p-4">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
            <!-- Search Live Filter -->
            <div class="relative w-full sm:w-80">
                <i class="ti ti-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                <input type="text" id="searchPermission" 
                    placeholder="Cari modul atau permission..." 
                    class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
            </div>

            <!-- Bulk Check Actions & Save Trigger -->
            <div class="flex flex-wrap items-center gap-2 w-full sm:w-auto justify-end">
                <button type="button" id="selectAll" class="inline-flex items-center gap-1.5 px-3 py-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 font-bold rounded-xl text-xs border border-emerald-200 transition active:scale-95 cursor-pointer">
                    <i class="ti ti-checkbox text-sm"></i>
                    <span>Pilih Semua (Tambahan)</span>
                </button>
                <button type="button" id="deselectAll" class="inline-flex items-center gap-1.5 px-3 py-2 bg-rose-50 hover:bg-rose-100 text-rose-800 font-bold rounded-xl text-xs border border-rose-200 transition active:scale-95 cursor-pointer">
                    <i class="ti ti-square-x text-sm"></i>
                    <span>Kosongkan Tambahan</span>
                </button>
                <button type="button" onclick="document.getElementById('formUserPermission').submit()" class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold rounded-xl text-xs shadow-xs transition active:scale-95 cursor-pointer">
                    <i class="ti ti-device-floppy text-sm"></i>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </div>
    </div>

    <!-- ================= 4. MAIN FORM & PERMISSION GROUPS ================= -->
    <form action="{{ route('users.storeuserpermission', Crypt::encrypt($user->id)) }}" method="POST" id="formUserPermission" class="space-y-5">
        @csrf

        @foreach ($groupedData as $mainMenuTitle => $mainMenuData)
            @if (count($mainMenuData['items']) > 0)
                <div class="permission-main-section bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden transition-all">
                    
                    <!-- Solid Emerald Header of Group -->
                    <div class="bg-emerald-600 px-4 py-3 sm:px-5 sm:py-3.5 flex items-center justify-between flex-wrap gap-3">
                        <div class="flex items-center gap-2.5 text-white">
                            <div class="w-8 h-8 rounded-lg bg-white/15 flex items-center justify-center backdrop-blur-xs">
                                <i class="{{ $mainMenuData['icon'] }} text-lg"></i>
                            </div>
                            <h2 class="text-sm sm:text-base font-extrabold tracking-tight">
                                {{ $mainMenuTitle }}
                            </h2>
                            <span class="px-2 py-0.5 text-[11px] font-bold rounded-full bg-white/20 text-white border border-white/20">
                                {{ count($mainMenuData['items']) }} Sub Menu
                            </span>
                        </div>

                        <!-- Toggle Select All for this Main Menu -->
                        <label class="inline-flex items-center gap-2 cursor-pointer bg-emerald-700/60 hover:bg-emerald-700 px-3 py-1.5 rounded-xl border border-emerald-500/40 text-white text-xs font-bold transition">
                            <input class="w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500 select-all-main-menu cursor-pointer" type="checkbox" id="mainMenuCheck_{{ Str::slug($mainMenuTitle) }}">
                            <span>Pilih Semua di {{ $mainMenuTitle }}</span>
                        </label>
                    </div>

                    <!-- Sub Menus Grid -->
                    <div class="p-4 sm:p-5 bg-slate-50/40">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                            @foreach ($mainMenuData['items'] as $d)
                                <div class="sub-group-wrapper">
                                    <div class="h-full flex flex-col bg-white border border-slate-200/90 rounded-xl shadow-2xs hover:border-emerald-300 hover:shadow-xs transition duration-200">
                                        
                                        <!-- Sub Group Card Header -->
                                        <div class="px-3.5 py-2.5 bg-slate-50 border-b border-slate-200/80 rounded-t-xl flex items-center justify-between gap-2">
                                            <div class="flex items-center gap-1.5 min-w-0">
                                                <i class="ti ti-folder text-emerald-600 text-base shrink-0"></i>
                                                <h3 class="text-xs font-extrabold text-slate-800 truncate sub-group-title" title="{{ $d->name }}">
                                                    {{ $d->name }}
                                                </h3>
                                            </div>
                                            <label class="inline-flex items-center gap-1 cursor-pointer shrink-0">
                                                <input class="w-3.5 h-3.5 rounded text-emerald-600 focus:ring-emerald-500 select-all-group cursor-pointer" type="checkbox" data-group="{{ $d->id }}" id="selectGroup{{ $d->id }}">
                                                <span class="text-[11px] font-bold text-slate-500">Semua</span>
                                            </label>
                                        </div>

                                        <!-- Sub Group Card Body (Permission Items) -->
                                        <div class="p-3 space-y-1.5 flex-1">
                                            @foreach ($d->permissions as $perm)
                                                @php
                                                    $isFromRole = in_array($perm->name, $rolePermissions);
                                                    $isDirect = in_array($perm->name, $directPermissions);
                                                @endphp

                                                <div class="permission-item flex items-center justify-between gap-2 p-1.5 rounded-lg hover:bg-slate-50 transition">
                                                    @if ($isFromRole)
                                                        <!-- Inherited from Role (Locked) -->
                                                        <label class="flex items-center justify-between w-full cursor-not-allowed text-xs text-slate-500 font-medium">
                                                            <div class="flex items-center gap-2">
                                                                <input class="w-4 h-4 rounded text-emerald-600 bg-slate-200 border-slate-300 cursor-not-allowed permission-checkbox" 
                                                                    type="checkbox" 
                                                                    value="{{ $perm->name }}" 
                                                                    data-group="{{ $d->id }}"
                                                                    checked disabled>
                                                                <span class="text-slate-600 font-semibold">{{ $perm->name }}</span>
                                                            </div>
                                                            <span class="inline-flex items-center gap-0.5 px-1.5 py-0.5 rounded bg-emerald-100 text-emerald-800 text-[10px] font-bold border border-emerald-200" title="Hak akses permanen dari Role">
                                                                <i class="ti ti-lock text-[10px]"></i> Role
                                                            </span>
                                                        </label>
                                                    @else
                                                        <!-- Editable Direct Permission -->
                                                        <label for="defaultCheck{{ $perm->id }}" class="flex items-center gap-2 w-full cursor-pointer text-xs text-slate-700 font-medium hover:text-emerald-800">
                                                            <input class="w-4 h-4 rounded text-emerald-600 border-slate-300 focus:ring-emerald-500 permission-checkbox editable-permission cursor-pointer" 
                                                                type="checkbox" 
                                                                name="permission[]"
                                                                value="{{ $perm->name }}" 
                                                                id="defaultCheck{{ $perm->id }}"
                                                                data-group="{{ $d->id }}"
                                                                {{ $isDirect ? 'checked' : '' }}>
                                                            <span>{{ $perm->name }}</span>
                                                        </label>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        @endforeach

        <!-- Bottom Submit Bar -->
        <div class="pt-2 pb-8">
            <button type="submit" class="w-full py-3.5 px-6 bg-emerald-600 hover:bg-emerald-700 text-white font-black text-sm rounded-2xl shadow-sm transition active:scale-[0.99] flex items-center justify-center gap-2 cursor-pointer">
                <i class="ti ti-device-floppy text-lg"></i>
                <span>Simpan Seluruh Hak Akses User {{ $user->name }}</span>
            </button>
        </div>
    </form>
</div>
@endsection

@push('myscript')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectAllBtn = document.getElementById('selectAll');
        const deselectAllBtn = document.getElementById('deselectAll');
        const editableCheckboxes = document.querySelectorAll('.editable-permission');
        const groupCheckboxes = document.querySelectorAll('.select-all-group');
        const mainMenuCheckboxes = document.querySelectorAll('.select-all-main-menu');
        const searchInput = document.getElementById('searchPermission');

        // Global Select All (only affects editable permissions)
        if (selectAllBtn) {
            selectAllBtn.addEventListener('click', function () {
                editableCheckboxes.forEach(cb => cb.checked = true);
                updateAllGroupAndMainStates();
            });
        }

        // Global Deselect All (only affects editable permissions)
        if (deselectAllBtn) {
            deselectAllBtn.addEventListener('click', function () {
                editableCheckboxes.forEach(cb => cb.checked = false);
                updateAllGroupAndMainStates();
            });
        }

        // Main Menu Bulk Select
        mainMenuCheckboxes.forEach(mainCb => {
            mainCb.addEventListener('change', function () {
                const section = this.closest('.permission-main-section');
                const isChecked = this.checked;
                const sectionEditableCheckboxes = section.querySelectorAll('.editable-permission');

                sectionEditableCheckboxes.forEach(cb => cb.checked = isChecked);
                section.querySelectorAll('.select-all-group').forEach(groupCb => {
                    const groupId = groupCb.getAttribute('data-group');
                    const groupAllCbs = section.querySelectorAll(`.permission-checkbox[data-group="${groupId}"]`);
                    updateGroupHeaderCheckbox(groupCb, groupAllCbs);
                });
            });
        });

        // Group-level Select All toggle
        groupCheckboxes.forEach(groupCb => {
            const groupId = groupCb.getAttribute('data-group');
            const groupEditableCbs = document.querySelectorAll(`.editable-permission[data-group="${groupId}"]`);
            const groupAllCbs = document.querySelectorAll(`.permission-checkbox[data-group="${groupId}"]`);

            // Initialize group check state
            updateGroupHeaderCheckbox(groupCb, groupAllCbs);

            groupCb.addEventListener('change', function () {
                const isChecked = this.checked;
                groupEditableCbs.forEach(cb => {
                    cb.checked = isChecked;
                });
                updateGroupHeaderCheckbox(this, groupAllCbs);
                updateMainMenuState(this.closest('.permission-main-section'));
            });
        });

        // Individual permission check listener to update group checkbox & main menu checkbox
        editableCheckboxes.forEach(cb => {
            cb.addEventListener('change', function () {
                const groupId = this.getAttribute('data-group');
                const groupCb = document.querySelector(`.select-all-group[data-group="${groupId}"]`);
                const groupAllCbs = document.querySelectorAll(`.permission-checkbox[data-group="${groupId}"]`);
                if (groupCb) {
                    updateGroupHeaderCheckbox(groupCb, groupAllCbs);
                }
                updateMainMenuState(this.closest('.permission-main-section'));
            });
        });

        function updateAllGroupAndMainStates() {
            groupCheckboxes.forEach(groupCb => {
                const groupId = groupCb.getAttribute('data-group');
                const groupAllCbs = document.querySelectorAll(`.permission-checkbox[data-group="${groupId}"]`);
                updateGroupHeaderCheckbox(groupCb, groupAllCbs);
            });
            document.querySelectorAll('.permission-main-section').forEach(section => {
                updateMainMenuState(section);
            });
        }

        // Initialize all main menu checkboxes
        document.querySelectorAll('.permission-main-section').forEach(section => {
            updateMainMenuState(section);
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

        function updateMainMenuState(section) {
            if (!section) return;
            const mainCb = section.querySelector('.select-all-main-menu');
            const sectionCheckboxes = section.querySelectorAll('.permission-checkbox');
            if (!mainCb || sectionCheckboxes.length === 0) return;

            const total = sectionCheckboxes.length;
            const checkedCount = Array.from(sectionCheckboxes).filter(cb => cb.checked).length;

            if (checkedCount === total && total > 0) {
                mainCb.checked = true;
                mainCb.indeterminate = false;
            } else if (checkedCount > 0 && checkedCount < total) {
                mainCb.checked = false;
                mainCb.indeterminate = true;
            } else {
                mainCb.checked = false;
                mainCb.indeterminate = false;
            }
        }

        // Live Search Filter
        if (searchInput) {
            searchInput.addEventListener('input', function () {
                const query = this.value.toLowerCase().trim();

                document.querySelectorAll('.permission-main-section').forEach(section => {
                    let sectionHasMatch = false;

                    section.querySelectorAll('.sub-group-wrapper').forEach(subGroup => {
                        const groupTitle = subGroup.querySelector('.sub-group-title').textContent.toLowerCase();
                        let subGroupHasMatch = groupTitle.includes(query);

                        subGroup.querySelectorAll('.permission-item').forEach(item => {
                            const labelText = item.textContent.toLowerCase();
                            if (query === '' || labelText.includes(query) || groupTitle.includes(query)) {
                                item.style.display = '';
                                subGroupHasMatch = true;
                            } else {
                                item.style.display = 'none';
                            }
                        });

                        if (query === '' || subGroupHasMatch) {
                            subGroup.style.display = '';
                            sectionHasMatch = true;
                        } else {
                            subGroup.style.display = 'none';
                        }
                    });

                    if (query === '' || sectionHasMatch) {
                        section.style.display = '';
                    } else {
                        section.style.display = 'none';
                    }
                });
            });
        }
    });
</script>
@endpush

@extends('layouts.app')
@section('titlepage', 'Set Permission - ' . ucwords($role->name))

@section('content')
<div class="space-y-6 pb-20">

    <!-- ================= 1. PAGE HEADER WITH RIGHT BREADCRUMB & HERO CARD ================= -->
    <div class="relative overflow-hidden bg-gradient-to-br from-emerald-700 via-emerald-800 to-teal-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl shadow-emerald-950/10 border border-emerald-600/30">
        <!-- Ambient decorative shapes -->
        <div class="absolute -right-12 -top-12 w-64 h-64 rounded-full bg-white/5 blur-2xl pointer-events-none"></div>
        <div class="absolute right-1/4 -bottom-16 w-48 h-48 rounded-full bg-emerald-400/10 blur-xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <!-- Left: Role & Title Details -->
            <div class="space-y-3">
                <nav class="flex items-center text-xs text-emerald-200/80 font-medium space-x-2">
                    <a href="{{ route('dashboard.index') }}" class="hover:text-white transition flex items-center gap-1">
                        <i class="ti ti-home text-sm"></i>
                        <span>Dashboard</span>
                    </a>
                    <span class="text-emerald-400/60">/</span>
                    <a href="{{ route('roles.index') }}" class="hover:text-white transition flex items-center gap-1">
                        <i class="ti ti-user-check text-sm"></i>
                        <span>Roles</span>
                    </a>
                    <span class="text-emerald-400/60">/</span>
                    <span class="font-bold text-white">Set Permission</span>
                </nav>

                <div class="flex items-start sm:items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 text-emerald-200 flex items-center justify-center text-3xl shadow-inner shrink-0">
                        <i class="ti ti-shield-lock"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2.5 flex-wrap">
                            <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                                {{ ucwords($role->name) }}
                            </h1>
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-black bg-white/15 text-emerald-100 backdrop-blur-md border border-white/20">
                                <i class="ti ti-lock-access text-sm"></i> Guard: {{ $role->guard_name }}
                            </span>
                        </div>
                        <p class="text-xs sm:text-sm text-emerald-100/80 mt-1 max-w-2xl leading-relaxed">
                            Sesuaikan hak akses fitur, sub-modul operasional, dan izin aksi untuk peran ini.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Right: Fast Action & Summary Counter Badge -->
            <div class="flex flex-row md:flex-col items-center md:items-end justify-between gap-3 shrink-0">
                <a href="{{ route('roles.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white/10 hover:bg-white/20 text-white font-bold rounded-2xl text-xs backdrop-blur-md border border-white/20 shadow-sm transition-all duration-200 active:scale-95">
                    <i class="ti ti-arrow-left text-sm"></i>
                    <span>Kembali</span>
                </a>
                <div class="inline-flex items-center gap-2 bg-emerald-950/40 border border-white/10 px-3.5 py-2 rounded-2xl backdrop-blur-sm">
                    <i class="ti ti-check-double text-emerald-300 text-base"></i>
                    <span class="text-xs text-emerald-200 font-medium">Terpilih:</span>
                    <span id="selectedCountBadge" class="text-xs font-black text-white bg-emerald-500 px-2 py-0.5 rounded-lg">0</span>
                    <span class="text-xs text-emerald-300/70">/ <span id="totalCountBadge">0</span></span>
                </div>
            </div>
        </div>
    </div>

    @php
        // Mapping Structure Menu Utama -> Sub Menu Groups
        $menuStructure = [
            'Data Master' => [
                'icon' => 'ti ti-database',
                'color' => 'from-blue-500 to-indigo-600',
                'badge' => 'bg-blue-50 text-blue-700 border-blue-200',
                'groups' => ['Karyawan', 'Jabatan', 'Siswa', 'Unit', 'Jenis Biaya', 'Departemen', 'Ledger', 'jenissimpanan', 'jenistabungan', 'jenispembiayaan', 'Kategori Ibadah', 'Kegiatan Ibadah'],
            ],
            'Pendaftaran' => [
                'icon' => 'ti ti-file-description',
                'color' => 'from-emerald-500 to-teal-600',
                'badge' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                'groups' => ['Pendaftaran', 'Pendaftaran Online', 'Tahun Ajaran PPDB', 'Asal Sekolah'],
            ],
            'Akademik' => [
                'icon' => 'ti ti-school',
                'color' => 'from-amber-500 to-orange-600',
                'badge' => 'bg-amber-50 text-amber-700 border-amber-200',
                'groups' => ['Guru', 'Akademik Siswa', 'Jabatan Akademik', 'Presensi Siswa', 'Mata Pelajaran', 'Kelas', 'Jadwal Pelajaran', 'akademik'],
            ],
            'Koperasi' => [
                'icon' => 'ti ti-building-bank',
                'color' => 'from-cyan-500 to-blue-600',
                'badge' => 'bg-cyan-50 text-cyan-700 border-cyan-200',
                'groups' => ['anggota', 'simpanan', 'tabungan', 'Pembiayaan'],
            ],
            'Keuangan' => [
                'icon' => 'ti ti-wallet',
                'color' => 'from-emerald-600 to-green-700',
                'badge' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                'groups' => ['Pembayaran Pendidikan', 'Jenis Bayar', 'Rencana SPP', 'Ledger Transaksi', 'Kategori Pemasukan', 'Kategori Pengeluaran', 'Kategori Ledger', 'Saldo Awal Ledger', 'Laporan Keuangan', 'Sumber Dana'],
            ],
            'MSDM' => [
                'icon' => 'ti ti-users-group',
                'color' => 'from-purple-500 to-indigo-600',
                'badge' => 'bg-purple-50 text-purple-700 border-purple-200',
                'groups' => ['Presensi', 'Izin Absen', 'Izin Sakit', 'Jam Kerja'],
            ],
            'Kegiatan' => [
                'icon' => 'ti ti-calendar-event',
                'color' => 'from-pink-500 to-rose-600',
                'badge' => 'bg-pink-50 text-pink-700 border-pink-200',
                'groups' => ['Jobdesk', 'Program Kerja', 'Agenda Kegiatan', 'Realisasi Kegiatan', 'Agenda'],
            ],
            'Asrama' => [
                'icon' => 'ti ti-home-check',
                'color' => 'from-teal-500 to-emerald-600',
                'badge' => 'bg-teal-50 text-teal-700 border-teal-200',
                'groups' => ['Asrama Siswa'],
            ],
            'Al Amin Got Talent' => [
                'icon' => 'ti ti-trophy',
                'color' => 'from-yellow-500 to-amber-600',
                'badge' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                'groups' => ['Perlombaan', 'Pendaftaran Got Talent', 'Jenjang Pendidikan'],
            ],
            'Website' => [
                'icon' => 'ti ti-world',
                'color' => 'from-sky-500 to-indigo-600',
                'badge' => 'bg-sky-50 text-sky-700 border-sky-200',
                'groups' => ['Kategori', 'Post', 'Sebaran Alumni', 'Pages', 'Tentang Pesantren', 'Visi & Misi', 'PPDB Setting', 'Testimoni', 'Prestasi Siswa', 'Program Unggulan', 'Pilar Pendidikan', 'Gallery'],
            ],
            'Pengumuman' => [
                'icon' => 'ti ti-speakerphone',
                'color' => 'from-red-500 to-rose-600',
                'badge' => 'bg-rose-50 text-rose-700 border-rose-200',
                'groups' => ['Pengumuman', 'Kategori Pengumuman', 'Push Subscription'],
            ],
            'Konfigurasi' => [
                'icon' => 'ti ti-adjustments-horizontal',
                'color' => 'from-slate-600 to-slate-800',
                'badge' => 'bg-slate-100 text-slate-700 border-slate-200',
                'groups' => ['Tahun Ajaran', 'Biaya', 'Mesin Fingerprint', 'Migrasi Siswa'],
            ],
            'Kuisioner' => [
                'icon' => 'ti ti-clipboard-list',
                'color' => 'from-violet-500 to-purple-600',
                'badge' => 'bg-violet-50 text-violet-700 border-violet-200',
                'groups' => ['Kuisioner'],
            ],
            'Settings' => [
                'icon' => 'ti ti-settings',
                'color' => 'from-slate-700 to-zinc-800',
                'badge' => 'bg-slate-100 text-slate-700 border-slate-200',
                'groups' => ['Pengaturan Umum'],
            ],
            'Lainnya / Modul Tambahan' => [
                'icon' => 'ti ti-cube',
                'color' => 'from-slate-500 to-slate-700',
                'badge' => 'bg-slate-100 text-slate-700 border-slate-200',
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
                'color' => $meta['color'] ?? 'from-emerald-600 to-teal-700',
                'badge' => $meta['badge'] ?? 'bg-emerald-50 text-emerald-700 border-emerald-200',
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

    <!-- ================= 2. STICKY CONTROLS & LIVE SEARCH BAR ================= -->
    <div class="sticky top-16 z-30 bg-white/90 backdrop-blur-xl rounded-2xl border border-slate-200/80 shadow-lg shadow-slate-900/5 p-4 transition-all">
        <div class="flex flex-col lg:flex-row items-center justify-between gap-4">
            
            <!-- Live Search Bar -->
            <div class="relative w-full lg:w-96">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <i class="ti ti-search text-base"></i>
                </div>
                <input type="text" id="searchPermission" 
                    placeholder="Ketik untuk mencari menu atau permission..." 
                    class="w-full pl-10 pr-9 py-2.5 bg-slate-50 border border-slate-200/90 rounded-xl text-xs font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition shadow-inner">
                <button type="button" id="clearSearch" class="hidden absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600">
                    <i class="ti ti-x text-sm"></i>
                </button>
            </div>

            <!-- Module Navigation Jump Pills & Bulk Actions -->
            <div class="flex flex-wrap items-center gap-2 w-full lg:w-auto justify-end">
                <div class="inline-flex items-center p-1 bg-slate-100 rounded-xl border border-slate-200/80">
                    <button type="button" id="selectAll" class="inline-flex items-center gap-1.5 px-3 py-1.5 hover:bg-white text-emerald-700 font-bold rounded-lg text-xs transition active:scale-95 cursor-pointer">
                        <i class="ti ti-checks text-sm"></i>
                        <span>Pilih Semua</span>
                    </button>
                    <span class="text-slate-300">|</span>
                    <button type="button" id="deselectAll" class="inline-flex items-center gap-1.5 px-3 py-1.5 hover:bg-white text-rose-700 font-bold rounded-lg text-xs transition active:scale-95 cursor-pointer">
                        <i class="ti ti-square-x text-sm"></i>
                        <span>Kosongkan</span>
                    </button>
                </div>

                <button type="button" id="toggleCollapseAll" class="inline-flex items-center gap-1.5 px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs border border-slate-200 transition active:scale-95 cursor-pointer">
                    <i class="ti ti-layout-navbar-collapse text-sm"></i>
                    <span id="collapseText">Tutup Semua</span>
                </button>

                <button type="button" onclick="document.getElementById('formRolePermission').submit()" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-md shadow-emerald-600/20 transition-all active:scale-95 cursor-pointer">
                    <i class="ti ti-device-floppy text-sm"></i>
                    <span>Simpan</span>
                </button>
            </div>
        </div>

        <!-- Quick Module Jump Ribbon -->
        <div class="mt-3 pt-3 border-t border-slate-100 flex items-center gap-1.5 overflow-x-auto pb-1 text-xs no-scrollbar">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider shrink-0 mr-1">Lompat:</span>
            @foreach ($groupedData as $mainMenuTitle => $mainMenuData)
                @if (count($mainMenuData['items']) > 0)
                    <a href="#section-{{ Str::slug($mainMenuTitle) }}" 
                        class="px-2.5 py-1 rounded-lg bg-slate-50 hover:bg-emerald-50 hover:text-emerald-700 text-slate-600 font-bold border border-slate-200/80 transition whitespace-nowrap text-[11px] flex items-center gap-1">
                        <i class="{{ $mainMenuData['icon'] }} text-xs"></i>
                        <span>{{ $mainMenuTitle }}</span>
                    </a>
                @endif
            @endforeach
        </div>
    </div>

    <!-- ================= 3. MAIN FORM & PERMISSION GROUPS ================= -->
    <form action="{{ route('roles.storerolepermission', Crypt::encrypt($role->id)) }}" method="POST" id="formRolePermission" class="space-y-6">
        @csrf

        @foreach ($groupedData as $mainMenuTitle => $mainMenuData)
            @if (count($mainMenuData['items']) > 0)
                <div id="section-{{ Str::slug($mainMenuTitle) }}" class="permission-main-section bg-white border border-slate-200/90 rounded-3xl shadow-sm overflow-hidden transition-all duration-300">
                    
                    <!-- Gradient Accordion Header of Module -->
                    <div class="px-5 py-4 bg-gradient-to-r {{ $mainMenuData['color'] }} flex items-center justify-between flex-wrap gap-3 cursor-pointer select-none module-header" data-target="module-body-{{ Str::slug($mainMenuTitle) }}">
                        <div class="flex items-center gap-3 text-white">
                            <div class="w-10 h-10 rounded-xl bg-white/15 backdrop-blur-md flex items-center justify-center border border-white/20 shadow-sm shrink-0">
                                <i class="{{ $mainMenuData['icon'] }} text-xl"></i>
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <h2 class="text-base sm:text-lg font-black tracking-tight">
                                        {{ $mainMenuTitle }}
                                    </h2>
                                    <span class="px-2.5 py-0.5 text-[11px] font-bold rounded-full bg-white/20 text-white border border-white/20 backdrop-blur-xs">
                                        {{ count($mainMenuData['items']) }} Modul
                                    </span>
                                </div>
                                <p class="text-[11px] text-white/80 font-medium">Klik untuk buka / tutup modul ini</p>
                            </div>
                        </div>

                        <!-- Right Header Controls -->
                        <div class="flex items-center gap-3" onclick="event.stopPropagation()">
                            <!-- Select All within Main Menu -->
                            <label class="inline-flex items-center gap-2 cursor-pointer bg-black/20 hover:bg-black/30 px-3.5 py-1.5 rounded-xl border border-white/20 text-white text-xs font-bold transition backdrop-blur-sm">
                                <input class="w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500 select-all-main-menu cursor-pointer" type="checkbox" id="mainMenuCheck_{{ Str::slug($mainMenuTitle) }}">
                                <span>Pilih Semua di {{ $mainMenuTitle }}</span>
                            </label>

                            <!-- Collapse Chevron -->
                            <button type="button" class="w-8 h-8 rounded-xl bg-white/15 hover:bg-white/25 flex items-center justify-center text-white transition chevron-indicator">
                                <i class="ti ti-chevron-up text-base transition-transform duration-300"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Sub Modules Grid Body -->
                    <div id="module-body-{{ Str::slug($mainMenuTitle) }}" class="p-4 sm:p-6 bg-slate-50/50 module-content transition-all duration-300">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                            @foreach ($mainMenuData['items'] as $d)
                                <div class="sub-group-wrapper">
                                    <div class="h-full flex flex-col bg-white border border-slate-200/90 hover:border-emerald-400 rounded-2xl shadow-xs hover:shadow-md transition duration-200 overflow-hidden group">
                                        
                                        <!-- Sub Group Card Header -->
                                        <div class="px-4 py-3 bg-slate-50/80 border-b border-slate-100 flex items-center justify-between gap-2">
                                            <div class="flex items-center gap-2 min-w-0">
                                                <div class="w-6 h-6 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0 border border-emerald-200/60 font-black text-xs">
                                                    <i class="ti ti-folder"></i>
                                                </div>
                                                <h3 class="text-xs font-black text-slate-800 truncate sub-group-title" title="{{ $d->name }}">
                                                    {{ $d->name }}
                                                </h3>
                                            </div>
                                            <label class="inline-flex items-center gap-1.5 cursor-pointer shrink-0 bg-white hover:bg-slate-100 px-2 py-0.5 rounded-lg border border-slate-200 text-slate-600 text-[11px] font-bold transition">
                                                <input class="w-3.5 h-3.5 rounded text-emerald-600 focus:ring-emerald-500 select-all-group cursor-pointer" type="checkbox" data-group="{{ $d->id }}" id="selectGroup{{ $d->id }}">
                                                <span>Semua</span>
                                            </label>
                                        </div>

                                        <!-- Sub Group Card Body (Permission Items) -->
                                        <div class="p-3.5 space-y-2 flex-1 divide-y divide-slate-100/60">
                                            @foreach ($d->permissions as $perm)
                                                @php
                                                    $isActionChecked = in_array($perm->name, $rolepermissions ?? $rolePermissions ?? []);
                                                    // Parse readable action label
                                                    $actionLabel = $perm->name;
                                                    $badgeColor = 'bg-slate-100 text-slate-700 border-slate-200';
                                                    if (str_contains(strtolower($actionLabel), 'create') || str_contains(strtolower($actionLabel), 'tambah') || str_contains(strtolower($actionLabel), 'store')) {
                                                        $badgeColor = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                                                    } elseif (str_contains(strtolower($actionLabel), 'edit') || str_contains(strtolower($actionLabel), 'update') || str_contains(strtolower($actionLabel), 'ubah')) {
                                                        $badgeColor = 'bg-amber-50 text-amber-700 border-amber-200';
                                                    } elseif (str_contains(strtolower($actionLabel), 'delete') || str_contains(strtolower($actionLabel), 'hapus') || str_contains(strtolower($actionLabel), 'destroy')) {
                                                        $badgeColor = 'bg-rose-50 text-rose-700 border-rose-200';
                                                    } elseif (str_contains(strtolower($actionLabel), 'show') || str_contains(strtolower($actionLabel), 'index') || str_contains(strtolower($actionLabel), 'lihat')) {
                                                        $badgeColor = 'bg-blue-50 text-blue-700 border-blue-200';
                                                    }
                                                @endphp
                                                <div class="permission-item pt-2 first:pt-0">
                                                    <label for="defaultCheck{{ $perm->id }}" class="flex items-start gap-2.5 p-2 rounded-xl hover:bg-emerald-50/50 border border-transparent hover:border-emerald-200 cursor-pointer transition">
                                                        <div class="flex items-center h-5">
                                                            <input class="w-4 h-4 rounded text-emerald-600 border-slate-300 focus:ring-emerald-500 permission-checkbox cursor-pointer transition" 
                                                                type="checkbox" 
                                                                name="permission[]"
                                                                value="{{ $perm->name }}" 
                                                                id="defaultCheck{{ $perm->id }}"
                                                                data-group="{{ $d->id }}"
                                                                {{ $isActionChecked ? 'checked' : '' }}>
                                                        </div>
                                                        <div class="flex-1 min-w-0">
                                                            <span class="permission-item-label block text-xs font-semibold text-slate-800 break-words leading-snug">
                                                                {{ $perm->name }}
                                                            </span>
                                                        </div>
                                                    </label>
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

        <!-- Floating / Bottom Sticky Save Bar -->
        <div class="fixed bottom-4 left-4 right-4 md:left-72 z-40">
            <div class="max-w-5xl mx-auto bg-slate-900/90 text-white backdrop-blur-xl border border-white/10 rounded-2xl p-3.5 sm:px-6 shadow-2xl flex items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center border border-emerald-500/30 shrink-0">
                        <i class="ti ti-shield-check text-xl"></i>
                    </div>
                    <div class="hidden sm:block">
                        <div class="text-xs font-bold text-white">Simpan Pengaturan Hak Akses</div>
                        <div class="text-[11px] text-slate-400">Pastikan seluruh konfigurasi sudah sesuai sebelum menyimpan</div>
                    </div>
                </div>

                <div class="flex items-center gap-2.5 w-full sm:w-auto justify-end">
                    <a href="{{ route('roles.index') }}" class="px-4 py-2 bg-white/10 hover:bg-white/20 text-slate-200 font-bold rounded-xl text-xs transition">
                        Batal
                    </a>
                    <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white font-extrabold text-xs rounded-xl shadow-lg shadow-emerald-500/30 transition active:scale-95 cursor-pointer">
                        <i class="ti ti-device-floppy text-base"></i>
                        <span>Simpan Hak Akses</span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('myscript')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectAllBtn = document.getElementById('selectAll');
        const deselectAllBtn = document.getElementById('deselectAll');
        const checkboxes = document.querySelectorAll('.permission-checkbox');
        const groupCheckboxes = document.querySelectorAll('.select-all-group');
        const mainMenuCheckboxes = document.querySelectorAll('.select-all-main-menu');
        const searchInput = document.getElementById('searchPermission');
        const clearSearchBtn = document.getElementById('clearSearch');
        const selectedCountBadge = document.getElementById('selectedCountBadge');
        const totalCountBadge = document.getElementById('totalCountBadge');
        const toggleCollapseAllBtn = document.getElementById('toggleCollapseAll');
        const collapseText = document.getElementById('collapseText');

        let isAllCollapsed = false;

        // Update Total & Selected Counters
        function updateCounters() {
            const total = checkboxes.length;
            const checked = Array.from(checkboxes).filter(cb => cb.checked).length;
            if (totalCountBadge) totalCountBadge.textContent = total;
            if (selectedCountBadge) selectedCountBadge.textContent = checked;
        }

        updateCounters();

        // Global Select All
        if (selectAllBtn) {
            selectAllBtn.addEventListener('click', function () {
                checkboxes.forEach(cb => cb.checked = true);
                groupCheckboxes.forEach(cb => { cb.checked = true; cb.indeterminate = false; });
                mainMenuCheckboxes.forEach(cb => { cb.checked = true; cb.indeterminate = false; });
                updateCounters();
            });
        }

        // Global Deselect All
        if (deselectAllBtn) {
            deselectAllBtn.addEventListener('click', function () {
                checkboxes.forEach(cb => cb.checked = false);
                groupCheckboxes.forEach(cb => { cb.checked = false; cb.indeterminate = false; });
                mainMenuCheckboxes.forEach(cb => { cb.checked = false; cb.indeterminate = false; });
                updateCounters();
            });
        }

        // Main Menu Bulk Select
        mainMenuCheckboxes.forEach(mainCb => {
            mainCb.addEventListener('change', function () {
                const section = this.closest('.permission-main-section');
                const isChecked = this.checked;
                const sectionCheckboxes = section.querySelectorAll('.permission-checkbox');
                const sectionGroupCheckboxes = section.querySelectorAll('.select-all-group');

                sectionCheckboxes.forEach(cb => cb.checked = isChecked);
                sectionGroupCheckboxes.forEach(cb => {
                    cb.checked = isChecked;
                    cb.indeterminate = false;
                });
                updateCounters();
            });
        });

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
                updateMainMenuState(this.closest('.permission-main-section'));
                updateCounters();
            });
        });

        // Individual permission check listener
        checkboxes.forEach(cb => {
            cb.addEventListener('change', function () {
                const groupId = this.getAttribute('data-group');
                const groupCb = document.querySelector(`.select-all-group[data-group="${groupId}"]`);
                const groupPermissionCbs = document.querySelectorAll(`.permission-checkbox[data-group="${groupId}"]`);
                if (groupCb) {
                    updateGroupHeaderCheckbox(groupCb, groupPermissionCbs);
                }
                updateMainMenuState(this.closest('.permission-main-section'));
                updateCounters();
            });
        });

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

        // Accordion Collapse / Expand functionality
        document.querySelectorAll('.module-header').forEach(header => {
            header.addEventListener('click', function () {
                const targetId = this.getAttribute('data-target');
                const targetBody = document.getElementById(targetId);
                const chevron = this.querySelector('.chevron-indicator i');
                
                if (targetBody.classList.contains('hidden')) {
                    targetBody.classList.remove('hidden');
                    chevron.classList.remove('rotate-180');
                } else {
                    targetBody.classList.add('hidden');
                    chevron.classList.add('rotate-180');
                }
            });
        });

        // Toggle Collapse All
        if (toggleCollapseAllBtn) {
            toggleCollapseAllBtn.addEventListener('click', function () {
                isAllCollapsed = !isAllCollapsed;
                document.querySelectorAll('.module-content').forEach(body => {
                    if (isAllCollapsed) {
                        body.classList.add('hidden');
                    } else {
                        body.classList.remove('hidden');
                    }
                });
                document.querySelectorAll('.chevron-indicator i').forEach(chevron => {
                    if (isAllCollapsed) {
                        chevron.classList.add('rotate-180');
                    } else {
                        chevron.classList.remove('rotate-180');
                    }
                });
                collapseText.textContent = isAllCollapsed ? 'Buka Semua' : 'Tutup Semua';
            });
        }

        // Live Search Filter
        if (searchInput) {
            searchInput.addEventListener('input', function () {
                const query = this.value.toLowerCase().trim();
                
                if (clearSearchBtn) {
                    clearSearchBtn.classList.toggle('hidden', query === '');
                }

                document.querySelectorAll('.permission-main-section').forEach(section => {
                    let sectionHasMatch = false;
                    const moduleBody = section.querySelector('.module-content');

                    section.querySelectorAll('.sub-group-wrapper').forEach(subGroup => {
                        const groupTitle = subGroup.querySelector('.sub-group-title').textContent.toLowerCase();
                        let subGroupHasMatch = groupTitle.includes(query);

                        subGroup.querySelectorAll('.permission-item').forEach(item => {
                            const labelText = item.querySelector('.permission-item-label').textContent.toLowerCase();
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
                        if (query !== '' && moduleBody) {
                            moduleBody.classList.remove('hidden'); // Auto expand on search
                        }
                    } else {
                        section.style.display = 'none';
                    }
                });
            });
        }

        if (clearSearchBtn) {
            clearSearchBtn.addEventListener('click', function () {
                searchInput.value = '';
                searchInput.dispatchEvent(new Event('input'));
                searchInput.focus();
            });
        }
    });
</script>
@endpush


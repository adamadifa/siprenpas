@extends('layouts.app')
@section('titlepage', 'Progress Rapor Siswa')

@section('content')
<div class="space-y-5">

    <!-- ================= 1. PAGE HEADER (NO CARD) WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <i class="ti ti-file-analytics text-emerald-600 text-2xl"></i>
                <span>Progress Rapor Siswa</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Monitoring pengisian nilai rapor kelas &amp; pengelolaan kegiatan ekstrakurikuler
            </p>
        </div>

        <!-- Right Side: Breadcrumb Navigation -->
        <div class="flex flex-col md:items-end">
            <nav class="flex items-center text-xs text-slate-400 font-medium">
                <a href="{{ route('dashboard.index') }}" class="hover:text-slate-700 transition flex items-center gap-1">
                    <i class="ti ti-home text-sm"></i>
                    <span>Dashboard</span>
                </a>
                <span class="mx-2 text-slate-300">/</span>
                <span class="text-slate-500 flex items-center gap-1">
                    <i class="ti ti-school text-sm"></i>
                    <span>Akademik</span>
                </span>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Rapor Siswa</span>
            </nav>
        </div>
    </div>

    @php
        $isAdminOrSuper = auth()->user()->hasAnyRole(['super admin', 'admin', 'admin unit', 'admin tu']);
        $canViewRaporKelas = $isAdminOrSuper || (isset($isWaliKelas) && $isWaliKelas);
        $canViewEkskul = $isAdminOrSuper || (isset($isKoordinator) && $isKoordinator);

        // Summary calculation
        $totalClasses = $classes->count();
        $totalStudentsAll = $classes->sum('siswa_count');
        $avgProgress = $totalClasses > 0 ? round($classes->avg('progress')) : 0;
        $completedClassesCount = $classes->where('progress', 100)->count();
    @endphp

    <!-- ================= 2. STATISTIC SUMMARY (SINGLE SEAMLESS EMERALD CARD WITH TAPERED DIVIDERS & PROGRESS) ================= -->
    <div class="rounded-2xl shadow-sm bg-gradient-to-r from-emerald-800 via-emerald-700 to-teal-700 text-white p-5 sm:p-6 border border-emerald-900/30 relative overflow-hidden">
        <!-- Background watermark -->
        <div class="absolute -right-8 -bottom-10 text-white/5 pointer-events-none">
            <i class="ti ti-file-analytics text-[200px]"></i>
        </div>

        <div class="relative z-10 flex flex-wrap sm:flex-nowrap items-stretch justify-between gap-y-6">
            
            <!-- Segment 1: Total Rombel -->
            <div class="flex-1 min-w-[140px] sm:min-w-[160px] px-3 sm:px-4 flex flex-col justify-between group">
                <div>
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-[11px] font-black uppercase tracking-wider text-emerald-200 truncate">
                            Total Rombel
                        </span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-white/20 text-white border border-white/25">
                            Kelas
                        </span>
                    </div>
                    <div class="text-3xl sm:text-4xl font-black text-white tracking-tight mt-1.5">
                        {{ $totalClasses }}
                    </div>
                </div>

                <div class="mt-3.5">
                    <div class="w-full h-1.5 bg-black/20 rounded-full overflow-hidden mb-2">
                        <div class="h-full bg-white/90 rounded-full transition-all duration-500" style="width: 100%"></div>
                    </div>
                    <div class="flex items-center justify-between text-xs text-emerald-200/90">
                        <span class="font-medium text-[11px] flex items-center gap-1">
                            <i class="ti ti-calendar-event text-xs opacity-70"></i>
                            <span>TA: {{ $activeTa->tahun_ajaran ?? '-' }}</span>
                        </span>
                        <span class="font-black text-white text-[10px] bg-white/20 px-2 py-0.5 rounded-md">
                            Smtr {{ $selectedSemester }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Tapered Vertical Divider Line -->
            <div class="hidden sm:block w-[1px] bg-gradient-to-b from-transparent via-white/35 to-transparent self-center h-16 shrink-0"></div>

            <!-- Segment 2: Total Siswa Terdaftar -->
            <div class="flex-1 min-w-[140px] sm:min-w-[160px] px-3 sm:px-4 flex flex-col justify-between group">
                <div>
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-[11px] font-black uppercase tracking-wider text-emerald-200 truncate">
                            Total Santri
                        </span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-white/15 text-emerald-100 border border-white/20">
                            Siswa
                        </span>
                    </div>
                    <div class="text-3xl sm:text-4xl font-black text-white tracking-tight mt-1.5">
                        {{ number_format($totalStudentsAll, 0, ',', '.') }}
                    </div>
                </div>

                <div class="mt-3.5">
                    <div class="w-full h-1.5 bg-black/20 rounded-full overflow-hidden mb-2">
                        <div class="h-full bg-white/90 rounded-full transition-all duration-500" style="width: 100%"></div>
                    </div>
                    <div class="flex items-center justify-between text-xs text-emerald-200/90">
                        <span class="font-medium text-[11px] flex items-center gap-1">
                            <i class="ti ti-users text-xs opacity-70"></i>
                            <span>Rasio Kelas</span>
                        </span>
                        <span class="font-black text-white text-[10px] bg-white/15 px-2 py-0.5 rounded-md">
                            {{ $totalClasses > 0 ? round($totalStudentsAll / $totalClasses) : 0 }} / rombel
                        </span>
                    </div>
                </div>
            </div>

            <!-- Tapered Vertical Divider Line -->
            <div class="hidden sm:block w-[1px] bg-gradient-to-b from-transparent via-white/35 to-transparent self-center h-16 shrink-0"></div>

            <!-- Segment 3: Rata-rata Progress Nilai -->
            <div class="flex-1 min-w-[140px] sm:min-w-[160px] px-3 sm:px-4 flex flex-col justify-between group">
                <div>
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-[11px] font-black uppercase tracking-wider text-emerald-200 truncate">
                            Progress Nilai
                        </span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-white/15 text-emerald-100 border border-white/20">
                            Nilai
                        </span>
                    </div>
                    <div class="text-3xl sm:text-4xl font-black text-white tracking-tight mt-1.5 flex items-baseline gap-1.5">
                        <span>{{ $avgProgress }}%</span>
                        <span class="text-xs font-semibold text-emerald-200">terisi</span>
                    </div>
                </div>

                <div class="mt-3.5">
                    <div class="w-full h-1.5 bg-black/20 rounded-full overflow-hidden mb-2">
                        <div class="h-full bg-white/90 rounded-full transition-all duration-500" style="width: {{ $avgProgress }}%"></div>
                    </div>
                    <div class="flex items-center justify-between text-xs text-emerald-200/90">
                        <span class="font-medium text-[11px] flex items-center gap-1">
                            <i class="ti ti-chart-pie text-xs opacity-70"></i>
                            <span>Pengisian Rapor</span>
                        </span>
                        <span class="font-black text-white text-[10px] bg-white/15 px-2 py-0.5 rounded-md">
                            {{ $avgProgress >= 80 ? 'Hampir Siap' : ($avgProgress >= 50 ? 'Berjalan' : 'Proses') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Tapered Vertical Divider Line -->
            <div class="hidden sm:block w-[1px] bg-gradient-to-b from-transparent via-white/35 to-transparent self-center h-16 shrink-0"></div>

            <!-- Segment 4: Kelas Tuntas (100%) -->
            <div class="flex-1 min-w-[140px] sm:min-w-[160px] px-3 sm:px-4 flex flex-col justify-between group">
                <div>
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-[11px] font-black uppercase tracking-wider text-emerald-200 truncate">
                            Kelas Tuntas
                        </span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-white/15 text-emerald-100 border border-white/20">
                            100%
                        </span>
                    </div>
                    <div class="text-3xl sm:text-4xl font-black text-white tracking-tight mt-1.5 flex items-baseline gap-1.5">
                        <span>{{ $completedClassesCount }}</span>
                        <span class="text-xs font-semibold text-emerald-200">/ {{ $totalClasses }} Kelas</span>
                    </div>
                </div>

                <div class="mt-3.5">
                    @php
                        $tuntasRate = $totalClasses > 0 ? round(($completedClassesCount / $totalClasses) * 100) : 0;
                    @endphp
                    <div class="w-full h-1.5 bg-black/20 rounded-full overflow-hidden mb-2">
                        <div class="h-full bg-white/90 rounded-full transition-all duration-500" style="width: {{ $tuntasRate }}%"></div>
                    </div>
                    <div class="flex items-center justify-between text-xs text-emerald-200/90">
                        <span class="font-medium text-[11px] flex items-center gap-1">
                            <i class="ti ti-award text-xs opacity-70"></i>
                            <span>Ketuntasan</span>
                        </span>
                        <span class="font-black text-white text-[10px] bg-white/15 px-2 py-0.5 rounded-md">
                            {{ $tuntasRate }}%
                        </span>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- ================= 3. FILTER & SEARCH TOOLBAR ================= -->
    <form action="{{ route('rapor-siswa.index') }}" method="GET" class="w-full">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 xl:grid-cols-6 gap-2.5 sm:gap-3 w-full items-center">
            <!-- Tahun Ajaran -->
            <div class="relative">
                <i class="ti ti-calendar-event absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base pointer-events-none"></i>
                <select name="kode_ta" id="filter_kode_ta" class="w-full pl-9 pr-8 py-2.5 text-xs sm:text-sm bg-white border border-slate-300/90 rounded-lg text-slate-700 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                    <option value="">-- Tahun Ajaran --</option>
                    @foreach ($semuaTa as $ta)
                        <option value="{{ $ta->kode_ta }}" {{ $selectedKodeTa == $ta->kode_ta ? 'selected' : '' }}>
                            {{ $ta->tahun_ajaran }} {{ $ta->status == 1 ? '(Aktif)' : '' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Semester -->
            <div class="relative">
                <i class="ti ti-clock absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base pointer-events-none"></i>
                <select name="semester" id="filter_semester" class="w-full pl-9 pr-8 py-2.5 text-xs sm:text-sm bg-white border border-slate-300/90 rounded-lg text-slate-700 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                    <option value="1" {{ $selectedSemester == 1 ? 'selected' : '' }}>Semester 1 (Ganjil)</option>
                    <option value="2" {{ $selectedSemester == 2 ? 'selected' : '' }}>Semester 2 (Genap)</option>
                </select>
            </div>

            <!-- Tingkat -->
            <div class="relative">
                <i class="ti ti-chart-bar absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base pointer-events-none"></i>
                <select name="tingkat" id="tingkat" class="w-full pl-9 pr-8 py-2.5 text-xs sm:text-sm bg-white border border-slate-300/90 rounded-lg text-slate-700 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                    <option value="">Semua Tingkat</option>
                    @foreach ($tingkats as $t)
                        <option value="{{ $t }}" {{ $selectedTingkat == $t ? 'selected' : '' }}>Tingkat {{ $t }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Kelas -->
            <div class="relative">
                <i class="ti ti-door-enter absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base pointer-events-none"></i>
                <select name="kode_kelas" id="kode_kelas" class="w-full pl-9 pr-8 py-2.5 text-xs sm:text-sm bg-white border border-slate-300/90 rounded-lg text-slate-700 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                    <option value="">Semua Kelas</option>
                    @foreach ($kelasDropdown as $kd)
                        <option value="{{ $kd->kode_kelas }}" {{ $selectedKodeKelas == $kd->kode_kelas ? 'selected' : '' }}>{{ $kd->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Unit (If Admin/Super Admin) -->
            @if (auth()->user()->kode_unit == 'U06' && !auth()->user()->hasRole('guru'))
                <div class="relative">
                    <i class="ti ti-building absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base pointer-events-none"></i>
                    <select name="kode_unit" id="kode_unit" class="w-full pl-9 pr-8 py-2.5 text-xs sm:text-sm bg-white border border-slate-300/90 rounded-lg text-slate-700 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                        <option value="">Semua Unit</option>
                        @foreach ($units as $u)
                            <option value="{{ $u->kode_unit }}" {{ Request('kode_unit') == $u->kode_unit ? 'selected' : '' }}>
                                {{ $u->nama_unit }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            <!-- Submit & Reset Buttons -->
            <div class="flex items-center gap-2">
                <button type="submit" class="flex-1 py-2.5 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs sm:text-sm rounded-lg shadow-xs transition inline-flex items-center justify-center gap-1.5 cursor-pointer active:scale-95 whitespace-nowrap">
                    <i class="ti ti-filter text-base"></i>
                    <span>Filter</span>
                </button>
                <a href="{{ route('rapor-siswa.index') }}" class="py-2.5 px-3 bg-white hover:bg-slate-100 text-slate-600 border border-slate-300/90 rounded-lg font-semibold text-sm transition inline-flex items-center justify-center shrink-0 shadow-xs" title="Reset Filter">
                    <i class="ti ti-refresh text-base"></i>
                </a>
            </div>
        </div>
    </form>

    <!-- Success & Error Alert -->
    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm flex items-center gap-3">
            <i class="ti ti-circle-check text-emerald-600 text-xl shrink-0"></i>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl text-sm flex items-center gap-3">
            <i class="ti ti-alert-circle text-rose-600 text-xl shrink-0"></i>
            <span class="font-medium">{{ session('error') }}</span>
        </div>
    @endif

    <!-- ================= 4. TABBED CONTENT CONTAINER ================= -->
    <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
        
        <!-- Seamless Green Tab Navigation Bar -->
        <div class="bg-emerald-700 px-4 pt-3 flex border-b border-emerald-600/70 gap-2 overflow-x-auto text-white">
            @if($canViewRaporKelas)
                <button type="button" id="tabBtnProgressKelas" class="tab-button px-5 py-3 text-xs sm:text-sm font-bold bg-emerald-600 text-white rounded-t-xl flex items-center gap-2 transition cursor-pointer shadow-xs border-t border-x border-emerald-500/50">
                    <i class="ti ti-chart-bar text-base"></i>
                    <span>Monitoring Rapor Kelas</span>
                    <span class="px-2 py-0.5 rounded-full text-[11px] font-bold bg-white/20 text-white border border-white/20 tab-badge">
                        {{ $classes->count() }}
                    </span>
                </button>
            @endif

            @if($canViewEkskul)
                <button type="button" id="tabBtnEkskul" class="tab-button px-5 py-3 text-xs sm:text-sm font-semibold {{ !$canViewRaporKelas ? 'bg-emerald-600 text-white rounded-t-xl border-t border-x border-emerald-500/50 shadow-xs' : 'bg-emerald-800/40 text-emerald-100 hover:text-white hover:bg-emerald-600/50 rounded-t-xl' }} flex items-center gap-2 transition cursor-pointer">
                    <i class="ti ti-books text-base"></i>
                    <span>Pengaturan Ekstrakurikuler</span>
                    <span class="px-2 py-0.5 rounded-full text-[11px] font-bold {{ !$canViewRaporKelas ? 'bg-white/20 text-white border border-white/20' : 'bg-emerald-900/50 text-emerald-200' }} tab-badge">
                        {{ $ekstrakurikuler->count() }}
                    </span>
                </button>
            @endif
        </div>

        <!-- ================= TAB 1: MONITORING RAPOR KELAS ================= -->
        @if($canViewRaporKelas)
            <div id="tabPanelProgressKelas" class="tab-panel block">
                <!-- Solid Green Table Header -->
                <div class="px-5 pt-4 pb-3 bg-emerald-600 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-white">
                    <div class="flex items-center gap-2.5">
                        <div class="w-7 h-7 rounded-lg bg-white/20 text-white flex items-center justify-center text-xs font-bold border border-white/20 shadow-2xs">
                            <i class="ti ti-chalkboard"></i>
                        </div>
                        <h3 class="text-sm font-extrabold text-white tracking-tight">Daftar Progress Nilai Rapor Per Kelas</h3>
                        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-white/20 text-white border border-white/30 shadow-2xs">
                            TA: {{ $activeTa->tahun_ajaran ?? '-' }} - Sem. {{ (($activeSemester->semester ?? $selectedSemester) == 1) ? 'Ganjil' : 'Genap' }}
                        </span>
                    </div>

                    <!-- Instant Search for classes -->
                    <div class="relative w-full sm:w-64">
                        <i class="ti ti-search absolute left-3 top-1/2 -translate-y-1/2 text-emerald-200 text-sm pointer-events-none"></i>
                        <input type="text" id="searchClassInput" placeholder="Cari nama kelas / wali..." class="w-full pl-8 pr-3 py-1.5 text-xs bg-white/15 hover:bg-white/20 focus:bg-white text-white focus:text-slate-900 placeholder-emerald-100 focus:placeholder-slate-400 border border-white/20 rounded-lg outline-none transition">
                    </div>
                </div>

                <!-- Classes Table Container -->
                <div class="overflow-x-auto bg-emerald-600">
                    <table class="w-full text-left text-xs border-0 border-collapse" id="classesTable">
                        <thead class="bg-emerald-600 text-white font-bold uppercase tracking-wider text-[11px] border-0 border-b border-emerald-700/80">
                            <tr>
                                <th class="py-2 px-3 text-center w-12 text-white">NO</th>
                                <th class="py-2 px-3 text-white">KELAS &amp; UNIT</th>
                                <th class="py-2 px-3 text-white">WALI KELAS</th>
                                <th class="py-2 px-3 text-center text-white">TOTAL SISWA</th>
                                <th class="py-2 px-3 text-center text-white">MAPEL SELESAI</th>
                                <th class="py-2 px-3 text-white w-56">PROGRESS RAPOR</th>
                                <th class="py-2 px-3 text-center text-white">STATUS</th>
                                <th class="py-2 px-3 text-end text-white">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white text-slate-700 font-medium">
                            @forelse ($classes as $index => $class)
                                <tr class="odd:bg-white even:bg-slate-50/40 hover:bg-emerald-50/50 transition-colors class-row">
                                    <td class="py-2 px-3 text-center text-slate-400 font-bold text-xs">{{ $index + 1 }}</td>
                                    <td class="py-2 px-3">
                                        <div class="flex items-center gap-2">
                                            <div class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center font-bold text-xs shrink-0 border border-emerald-100/80">
                                                <i class="ti ti-chalkboard"></i>
                                            </div>
                                            <div>
                                                <span class="font-bold text-slate-900 block class-name text-xs leading-tight">{{ $class->nama_kelas }}</span>
                                                <span class="text-[10px] text-slate-400 font-medium">{{ $class->unit->nama_unit ?? '-' }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-2 px-3">
                                        <div class="flex items-center gap-1.5 text-slate-700 font-medium text-xs">
                                            <i class="ti ti-user-check text-slate-400 text-xs"></i>
                                            <span class="wali-name">{{ $class->waliKelas->nama_guru ?? 'Belum Ditentukan' }}</span>
                                        </div>
                                    </td>
                                    <td class="py-2 px-3 text-center">
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[11px] font-bold bg-sky-50 text-sky-700 border border-sky-200/70">
                                            <i class="ti ti-users text-[11px]"></i>
                                            {{ $class->siswa_count }} Siswa
                                        </span>
                                    </td>
                                    <td class="py-2 px-3 text-center">
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[11px] font-bold {{ $class->completed_subjects == $class->total_subjects && $class->total_subjects > 0 ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/70' : 'bg-amber-50 text-amber-700 border border-amber-200/70' }}">
                                            {{ $class->completed_subjects }} / {{ $class->total_subjects }}
                                        </span>
                                    </td>
                                    <td class="py-2 px-3">
                                        <div class="flex items-center gap-2">
                                            <div class="flex-1 bg-slate-100 rounded-full h-1.5 overflow-hidden">
                                                <div class="h-full rounded-full transition-all duration-300 {{ $class->progress == 100 ? 'bg-emerald-500' : ($class->progress >= 50 ? 'bg-sky-500' : 'bg-amber-500') }}" style="width: {{ $class->progress }}%"></div>
                                            </div>
                                            <span class="text-xs font-bold min-w-8 text-right {{ $class->progress == 100 ? 'text-emerald-600' : ($class->progress >= 50 ? 'text-sky-600' : 'text-amber-600') }}">
                                                {{ $class->progress }}%
                                            </span>
                                        </div>
                                    </td>
                                    <td class="py-2 px-3 text-center">
                                        @if($class->progress == 100)
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/70">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Selesai
                                            </span>
                                        @elseif($class->progress > 0)
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-50 text-amber-700 border border-amber-200/70">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Berjalan
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-rose-50 text-rose-700 border border-rose-200/70">
                                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Belum
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-2 px-3 text-end">
                                        <a href="{{ route('rapor-siswa.show', $class->kode_kelas) }}" class="inline-flex items-center gap-1 px-2.5 py-1 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-md text-xs shadow-2xs transition active:scale-95">
                                            <i class="ti ti-eye text-xs"></i>
                                            <span>Detail</span>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-10">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 mb-1.5">
                                                <i class="ti ti-school-off text-xl"></i>
                                            </div>
                                            <p class="text-xs font-bold text-slate-700">Tidak ada data kelas ditemukan</p>
                                            <p class="text-[11px] text-slate-400 mt-0.5">Silahkan sesuaikan filter tahun ajaran atau unit di atas.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <!-- ================= TAB 2: PENGATURAN EKSTRAKURIKULER ================= -->
        @if($canViewEkskul)
            <div id="tabPanelEkskul" class="tab-panel {{ !$canViewRaporKelas ? 'block' : 'hidden' }}">
                <!-- Solid Green Table Header -->
                <div class="px-5 pt-4 pb-3 bg-emerald-600 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-white">
                    <div class="flex items-center gap-2.5">
                        <div class="w-7 h-7 rounded-lg bg-white/20 text-white flex items-center justify-center text-xs font-bold border border-white/20 shadow-2xs">
                            <i class="ti ti-books"></i>
                        </div>
                        <h3 class="text-sm font-extrabold text-white tracking-tight">Daftar Kegiatan Ekstrakurikuler</h3>
                        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-white/20 text-white border border-white/30 shadow-2xs">
                            TA: {{ $activeTa->tahun_ajaran ?? '-' }}
                        </span>
                    </div>

                    @if($isAdminOrSuper)
                        <button type="button" id="btnOpenAddEkskul" class="inline-flex items-center gap-1.5 px-3 py-1 bg-white text-emerald-800 hover:bg-emerald-50 font-bold rounded-lg text-xs shadow-xs transition active:scale-95 cursor-pointer">
                            <i class="ti ti-plus text-xs"></i>
                            <span>Tambah Ekstrakurikuler</span>
                        </button>
                    @endif
                </div>

                <!-- Ekskul Table Container -->
                <div class="overflow-x-auto bg-emerald-600">
                    <table class="w-full text-left text-xs border-0 border-collapse" id="ekskulTable">
                        <thead class="bg-emerald-600 text-white font-bold uppercase tracking-wider text-[11px] border-0 border-b border-emerald-700/80">
                            <tr>
                                <th class="py-2 px-3 text-center w-12 text-white">NO</th>
                                <th class="py-2 px-3 text-white">NAMA EKSTRAKURIKULER</th>
                                <th class="py-2 px-3 text-white">UNIT / JENJANG</th>
                                <th class="py-2 px-3 text-white">KOORDINATOR (GURU)</th>
                                <th class="py-2 px-3 text-center text-white">TAHUN AJARAN</th>
                                <th class="py-2 px-3 text-end text-white">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white text-slate-700 font-medium">
                            @forelse ($ekstrakurikuler as $index => $ekskul)
                                <tr class="odd:bg-white even:bg-slate-50/40 hover:bg-emerald-50/50 transition-colors">
                                    <td class="py-2 px-3 text-center text-slate-400 font-bold text-xs">{{ $index + 1 }}</td>
                                    <td class="py-2 px-3">
                                        <div class="flex items-center gap-2">
                                            <div class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center font-bold text-xs shrink-0 border border-emerald-100/80">
                                                <i class="ti ti-award"></i>
                                            </div>
                                            <span class="font-bold text-slate-900 text-xs sm:text-sm">{{ $ekskul->nama_ekstrakurikuler }}</span>
                                        </div>
                                    </td>
                                    <td class="py-2 px-3">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-bold bg-sky-50 text-sky-700 border border-sky-200/70">
                                            {{ $ekskul->unit->nama_unit ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="py-2 px-3">
                                        <div class="flex items-center gap-1.5 text-slate-700 font-medium text-xs">
                                            <i class="ti ti-user-star text-slate-400 text-xs"></i>
                                            <span>{{ $ekskul->guru->nama_guru ?? '-' }}</span>
                                        </div>
                                    </td>
                                    <td class="py-2 px-3 text-center">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-semibold bg-slate-100 text-slate-700 border border-slate-200/60">
                                            {{ $ekskul->tahunAjaran->tahun_ajaran ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="py-2 px-3 text-end">
                                        <div class="inline-flex items-center gap-1 justify-end">
                                            <a href="{{ route('rapor-siswa.ekskul.nilai', $ekskul->id) }}" class="w-6.5 h-6.5 rounded-md bg-sky-50 hover:bg-sky-100 text-sky-700 border border-sky-200/80 flex items-center justify-center text-xs transition" title="Input Nilai & Siswa">
                                                <i class="ti ti-users text-xs"></i>
                                            </a>
                                            @if($isAdminOrSuper)
                                                <button type="button" class="btn-edit-ekskul w-6.5 h-6.5 rounded-md bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200/80 flex items-center justify-center text-xs transition cursor-pointer" 
                                                    data-id="{{ $ekskul->id }}"
                                                    data-nama="{{ $ekskul->nama_ekstrakurikuler }}"
                                                    data-unit="{{ $ekskul->kode_unit }}"
                                                    data-guru="{{ $ekskul->guru_id }}"
                                                    title="Edit">
                                                    <i class="ti ti-edit text-xs"></i>
                                                </button>
                                                <form action="{{ route('rapor-siswa.ekskul.destroy', $ekskul->id) }}" method="POST" class="inline form-delete-ekskul">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn-delete-ekskul w-6.5 h-6.5 rounded-md bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200/80 flex items-center justify-center text-xs transition cursor-pointer" title="Hapus">
                                                        <i class="ti ti-trash text-xs"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-10">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 mb-1.5">
                                                <i class="ti ti-books-off text-xl"></i>
                                            </div>
                                            <p class="text-xs font-bold text-slate-700">Belum ada data ekstrakurikuler</p>
                                            <p class="text-[11px] text-slate-400 mt-0.5">Klik tombol Tambah Ekstrakurikuler di atas untuk menambahkan kegiatan baru.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- ================= MODAL ADD EKSTRAKURIKULER ================= -->
@if($isAdminOrSuper)
    <div id="modalAddEkskul" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-xs p-4 hidden">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden animate-in fade-in zoom-in duration-150">
            <!-- Modal Header -->
            <div class="bg-emerald-600 px-5 py-4 text-white flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i class="ti ti-plus text-lg"></i>
                    <h3 class="font-bold text-base text-white">Tambah Ekstrakurikuler</h3>
                </div>
                <button type="button" class="btn-close-modal text-white/80 hover:text-white text-xl cursor-pointer">
                    <i class="ti ti-x"></i>
                </button>
            </div>

            <!-- Modal Form -->
            <form action="{{ route('rapor-siswa.ekskul.store') }}" method="POST" id="formAddEkskul" class="p-5 space-y-4">
                @csrf
                <input type="hidden" name="kode_ta" value="{{ $selectedKodeTa }}">

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Nama Ekstrakurikuler <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <i class="ti ti-award absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                        <input type="text" name="nama_ekstrakurikuler" required placeholder="Contoh: Pramuka, PMR, Futsal, Tari" class="w-full pl-10 pr-3.5 py-2.5 text-sm bg-white border border-slate-300 rounded-lg text-slate-800 font-medium placeholder-slate-400 focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Unit / Jenjang <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <i class="ti ti-school absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                        <select name="kode_unit" required class="w-full pl-10 pr-8 py-2.5 text-sm bg-white border border-slate-300 rounded-lg text-slate-700 font-medium focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                            <option value="">-- Pilih Unit --</option>
                            @foreach ($units as $u)
                                <option value="{{ $u->kode_unit }}" {{ Request('kode_unit') == $u->kode_unit ? 'selected' : '' }}>
                                    {{ $u->nama_unit }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Koordinator (Guru) <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <i class="ti ti-user-star absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                        <select name="guru_id" required class="w-full pl-10 pr-8 py-2.5 text-sm bg-white border border-slate-300 rounded-lg text-slate-700 font-medium focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                            <option value="">-- Pilih Koordinator Guru --</option>
                            @foreach ($gurus as $g)
                                <option value="{{ $g->id }}">{{ $g->nama_guru }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="pt-2 flex items-center justify-end gap-2">
                    <button type="button" class="btn-close-modal px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-lg text-xs transition cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg text-xs shadow-xs transition flex items-center gap-1.5 cursor-pointer active:scale-95">
                        <i class="ti ti-device-floppy text-base"></i>
                        <span>Simpan Data</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ================= MODAL EDIT EKSTRAKURIKULER ================= -->
    <div id="modalEditEkskul" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-xs p-4 hidden">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden animate-in fade-in zoom-in duration-150">
            <!-- Modal Header -->
            <div class="bg-emerald-600 px-5 py-4 text-white flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i class="ti ti-edit text-lg"></i>
                    <h3 class="font-bold text-base text-white">Edit Ekstrakurikuler</h3>
                </div>
                <button type="button" class="btn-close-modal text-white/80 hover:text-white text-xl cursor-pointer">
                    <i class="ti ti-x"></i>
                </button>
            </div>

            <!-- Modal Form -->
            <form action="" method="POST" id="formEditEkskul" class="p-5 space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Nama Ekstrakurikuler <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <i class="ti ti-award absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                        <input type="text" name="nama_ekstrakurikuler" id="edit_nama_ekstrakurikuler" required class="w-full pl-10 pr-3.5 py-2.5 text-sm bg-white border border-slate-300 rounded-lg text-slate-800 font-medium placeholder-slate-400 focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Unit / Jenjang <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <i class="ti ti-school absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                        <select name="kode_unit" id="edit_kode_unit" required class="w-full pl-10 pr-8 py-2.5 text-sm bg-white border border-slate-300 rounded-lg text-slate-700 font-medium focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                            <option value="">-- Pilih Unit --</option>
                            @foreach ($units as $u)
                                <option value="{{ $u->kode_unit }}">{{ $u->nama_unit }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Koordinator (Guru) <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <i class="ti ti-user-star absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                        <select name="guru_id" id="edit_guru_id" required class="w-full pl-10 pr-8 py-2.5 text-sm bg-white border border-slate-300 rounded-lg text-slate-700 font-medium focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                            <option value="">-- Pilih Koordinator Guru --</option>
                            @foreach ($gurus as $g)
                                <option value="{{ $g->id }}">{{ $g->nama_guru }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="pt-2 flex items-center justify-end gap-2">
                    <button type="button" class="btn-close-modal px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-lg text-xs transition cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg text-xs shadow-xs transition flex items-center gap-1.5 cursor-pointer active:scale-95">
                        <i class="ti ti-device-floppy text-base"></i>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endif

@push('myscript')
<script>
    $(function() {
        // Tab switcher logic
        function switchTab(tabId) {
            $('.tab-button').removeClass('bg-emerald-600 text-white font-bold border-t border-x border-emerald-500/50 shadow-xs')
                .addClass('bg-emerald-800/40 text-emerald-100 hover:text-white hover:bg-emerald-600/50 font-semibold border-none');
            $('.tab-button .tab-badge').removeClass('bg-white/20 text-white border border-white/20')
                .addClass('bg-emerald-900/50 text-emerald-200 border-none');
            $('.tab-panel').addClass('hidden').removeClass('block');

            if (tabId === 'ekskul') {
                $('#tabBtnEkskul').removeClass('bg-emerald-800/40 text-emerald-100 hover:text-white hover:bg-emerald-600/50 font-semibold border-none')
                    .addClass('bg-emerald-600 text-white font-bold border-t border-x border-emerald-500/50 shadow-xs');
                $('#tabBtnEkskul .tab-badge').removeClass('bg-emerald-900/50 text-emerald-200 border-none')
                    .addClass('bg-white/20 text-white border border-white/20');
                $('#tabPanelEkskul').removeClass('hidden').addClass('block');
                localStorage.setItem('activeTabRaporSiswa', 'ekskul');
            } else {
                $('#tabBtnProgressKelas').removeClass('bg-emerald-800/40 text-emerald-100 hover:text-white hover:bg-emerald-600/50 font-semibold border-none')
                    .addClass('bg-emerald-600 text-white font-bold border-t border-x border-emerald-500/50 shadow-xs');
                $('#tabBtnProgressKelas .tab-badge').removeClass('bg-emerald-900/50 text-emerald-200 border-none')
                    .addClass('bg-white/20 text-white border border-white/20');
                $('#tabPanelProgressKelas').removeClass('hidden').addClass('block');
                localStorage.setItem('activeTabRaporSiswa', 'progress');
            }
        }

        $('#tabBtnProgressKelas').on('click', function() {
            switchTab('progress');
        });

        $('#tabBtnEkskul').on('click', function() {
            switchTab('ekskul');
        });

        // Restore tab state
        var savedTab = localStorage.getItem('activeTabRaporSiswa');
        if (savedTab === 'ekskul' && $('#tabBtnEkskul').length > 0) {
            switchTab('ekskul');
        }

        // Live search classes in table
        $('#searchClassInput').on('keyup', function() {
            var val = $(this).val().toLowerCase();
            $('#classesTable tbody tr.class-row').filter(function() {
                var name = $(this).find('.class-name').text().toLowerCase();
                var wali = $(this).find('.wali-name').text().toLowerCase();
                $(this).toggle(name.indexOf(val) > -1 || wali.indexOf(val) > -1);
            });
        });

        // Dynamic Class dropdown fetching
        function updateKelasDropdown() {
            var kode_unit = $('#kode_unit').val();
            var tingkat = $('#tingkat').val();
            var kode_ta = "{{ $selectedKodeTa }}";
            
            if ($('#kode_unit').length === 0 || !kode_unit) {
                kode_unit = "{{ auth()->user()->kode_unit }}";
            }

            if (kode_unit) {
                $.ajax({
                    url: "{{ route('jadwal-pelajaran.get-data-by-unit') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        kode_unit: kode_unit,
                        kode_ta: kode_ta
                    },
                    success: function(res) {
                        var opt = '<option value="">Semua Kelas</option>';
                        res.kelas.forEach(function(item) {
                            if (!tingkat || item.tingkat == tingkat) {
                                opt += `<option value="${item.kode_kelas}" ${"{{ $selectedKodeKelas }}" == item.kode_kelas ? 'selected' : ''}>${item.nama_kelas}</option>`;
                            }
                        });
                        $('#kode_kelas').html(opt);
                    }
                });
            }
        }

        $(document).on('change', '#kode_unit, #tingkat', function() {
            updateKelasDropdown();
        });

        // Modal Add & Edit Ekskul
        $('#btnOpenAddEkskul').on('click', function() {
            $('#modalAddEkskul').removeClass('hidden');
        });

        $('.btn-edit-ekskul').on('click', function() {
            var id = $(this).data('id');
            var nama = $(this).data('nama');
            var unit = $(this).data('unit');
            var guru = $(this).data('guru');

            $('#formEditEkskul').attr('action', '/rapor-siswa/ekstrakurikuler/' + id);
            $('#edit_nama_ekstrakurikuler').val(nama);
            $('#edit_kode_unit').val(unit);
            $('#edit_guru_id').val(guru);

            $('#modalEditEkskul').removeClass('hidden');
        });

        $('.btn-close-modal').on('click', function() {
            $('#modalAddEkskul').addClass('hidden');
            $('#modalEditEkskul').addClass('hidden');
        });

        // SweetAlert2 confirmation for deleting extracurricular
        $(document).on('click', '.btn-delete-ekskul', function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: 'Apakah Anda yakin ingin menghapus data ekstrakurikuler ini? Data nilai di dalamnya akan ikut terhapus.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus Data',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush
@endsection

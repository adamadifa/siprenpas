@extends('layouts.app')
@section('titlepage', 'Data Siswa')

@section('content')
<div class="space-y-6">

    <!-- ================= 1. PAGE HEADER (NO CARD) WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <i class="ti ti-school text-emerald-600 text-2xl"></i>
                <span>Data Siswa Akademik</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Manajemen data siswa aktif berdasarkan pembiayaan, rombongan belajar (kelas), dan integrasi kartu RFID
            </p>
        </div>

        <!-- Right Side: Breadcrumb -->
        <div class="flex flex-col md:items-end gap-2.5">
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
                <span class="font-bold text-slate-800">Data Siswa</span>
            </nav>
        </div>
    </div>

    <!-- ================= 2. EXECUTIVE STATISTICS (SINGLE SEAMLESS EMERALD CARD WITH TAPERED DIVIDERS) ================= -->
    <div class="rounded-2xl shadow-sm bg-gradient-to-r from-emerald-800 via-emerald-700 to-teal-700 text-white p-5 sm:p-6 border border-emerald-900/30 relative overflow-hidden">
        <!-- Background watermark -->
        <div class="absolute -right-8 -bottom-10 text-white/5 pointer-events-none">
            <i class="ti ti-school text-[200px]"></i>
        </div>

        <div class="relative z-10 flex flex-wrap sm:flex-nowrap items-stretch justify-between gap-y-6">
            
            <!-- Segment 1: Total Siswa Aktif -->
            <div class="flex-1 min-w-[130px] sm:min-w-[150px] px-3 sm:px-4 flex flex-col justify-between group">
                <div>
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-[11px] font-black uppercase tracking-wider text-emerald-200 truncate">
                            Total Siswa Aktif
                        </span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-white/20 text-white border border-white/25">
                            Semua
                        </span>
                    </div>
                    <div class="text-3xl sm:text-4xl font-black text-white tracking-tight mt-1.5">
                        {{ number_format($stats['total_siswa']) }}
                    </div>
                </div>
                <div class="mt-3.5 pt-2 flex items-center justify-between text-xs text-emerald-200/90">
                    <span class="font-medium text-[11px] flex items-center gap-1">
                        <i class="ti ti-calendar text-xs opacity-70"></i>
                        <span>TA: {{ $tahun_ajaran->tahun_ajaran ?? '-' }}</span>
                    </span>
                    <span class="font-black text-white text-[10px] bg-white/20 px-2 py-0.5 rounded-md">
                        100%
                    </span>
                </div>
            </div>

            <!-- Tapered Vertical Divider Line -->
            <div class="hidden sm:block w-[1px] bg-gradient-to-b from-transparent via-white/35 to-transparent self-center h-16 shrink-0"></div>

            <!-- Segment 2: Siswa Laki-laki -->
            <div class="flex-1 min-w-[130px] sm:min-w-[150px] px-3 sm:px-4 flex flex-col justify-between group">
                <div>
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-[11px] font-black uppercase tracking-wider text-emerald-200 truncate">
                            Santriwan (L)
                        </span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-white/15 text-emerald-100 border border-white/20">
                            Laki-laki
                        </span>
                    </div>
                    <div class="text-3xl sm:text-4xl font-black text-white tracking-tight mt-1.5">
                        {{ number_format($stats['total_laki']) }}
                    </div>
                </div>
                <div class="mt-3.5 pt-2 flex items-center justify-between text-xs text-emerald-200/90">
                    <span class="font-medium text-[11px] flex items-center gap-1">
                        <i class="ti ti-gender-male text-xs opacity-70"></i>
                        <span>Proporsi L</span>
                    </span>
                    <span class="font-black text-white text-[10px] bg-white/15 px-2 py-0.5 rounded-md">
                        {{ $stats['total_siswa'] > 0 ? round(($stats['total_laki'] / $stats['total_siswa']) * 100) : 0 }}%
                    </span>
                </div>
            </div>

            <!-- Tapered Vertical Divider Line -->
            <div class="hidden sm:block w-[1px] bg-gradient-to-b from-transparent via-white/35 to-transparent self-center h-16 shrink-0"></div>

            <!-- Segment 3: Siswa Perempuan -->
            <div class="flex-1 min-w-[130px] sm:min-w-[150px] px-3 sm:px-4 flex flex-col justify-between group">
                <div>
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-[11px] font-black uppercase tracking-wider text-emerald-200 truncate">
                            Santriwati (P)
                        </span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-white/15 text-emerald-100 border border-white/20">
                            Perempuan
                        </span>
                    </div>
                    <div class="text-3xl sm:text-4xl font-black text-white tracking-tight mt-1.5">
                        {{ number_format($stats['total_perempuan']) }}
                    </div>
                </div>
                <div class="mt-3.5 pt-2 flex items-center justify-between text-xs text-emerald-200/90">
                    <span class="font-medium text-[11px] flex items-center gap-1">
                        <i class="ti ti-gender-female text-xs opacity-70"></i>
                        <span>Proporsi P</span>
                    </span>
                    <span class="font-black text-white text-[10px] bg-white/15 px-2 py-0.5 rounded-md">
                        {{ $stats['total_siswa'] > 0 ? round(($stats['total_perempuan'] / $stats['total_siswa']) * 100) : 0 }}%
                    </span>
                </div>
            </div>

            <!-- Tapered Vertical Divider Line -->
            <div class="hidden sm:block w-[1px] bg-gradient-to-b from-transparent via-white/35 to-transparent self-center h-16 shrink-0"></div>

            <!-- Segment 4: Sudah Dapat Kelas -->
            <div class="flex-1 min-w-[130px] sm:min-w-[150px] px-3 sm:px-4 flex flex-col justify-between group">
                <div>
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-[11px] font-black uppercase tracking-wider text-emerald-200 truncate">
                            Sudah Kelas
                        </span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-white/15 text-emerald-100 border border-white/20">
                            Rombel
                        </span>
                    </div>
                    <div class="text-3xl sm:text-4xl font-black text-white tracking-tight mt-1.5">
                        {{ number_format($stats['sudah_kelas']) }}
                    </div>
                </div>
                <div class="mt-3.5 pt-2 flex items-center justify-between text-xs text-emerald-200/90">
                    <span class="font-medium text-[11px] flex items-center gap-1">
                        <i class="ti ti-door-enter text-xs opacity-70"></i>
                        <span>Belum: {{ number_format($stats['belum_kelas']) }}</span>
                    </span>
                    <span class="font-black text-white text-[10px] bg-white/15 px-2 py-0.5 rounded-md">
                        {{ $stats['total_siswa'] > 0 ? round(($stats['sudah_kelas'] / $stats['total_siswa']) * 100) : 0 }}%
                    </span>
                </div>
            </div>

            <!-- Tapered Vertical Divider Line -->
            <div class="hidden sm:block w-[1px] bg-gradient-to-b from-transparent via-white/35 to-transparent self-center h-16 shrink-0"></div>

            <!-- Segment 5: Smart Card RFID -->
            <div class="flex-1 min-w-[130px] sm:min-w-[150px] px-3 sm:px-4 flex flex-col justify-between group">
                <div>
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-[11px] font-black uppercase tracking-wider text-emerald-200 truncate">
                            Smart Card RFID
                        </span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-white/15 text-emerald-100 border border-white/20">
                            RFID
                        </span>
                    </div>
                    <div class="text-3xl sm:text-4xl font-black text-white tracking-tight mt-1.5">
                        {{ number_format($stats['rfid_ready']) }}
                    </div>
                </div>
                <div class="mt-3.5 pt-2 flex items-center justify-between text-xs text-emerald-200/90">
                    <span class="font-medium text-[11px] flex items-center gap-1">
                        <i class="ti ti-id-badge text-xs opacity-70"></i>
                        <span>Terpasang RFID</span>
                    </span>
                    <span class="font-black text-white text-[10px] bg-white/15 px-2 py-0.5 rounded-md">
                        {{ $stats['total_siswa'] > 0 ? round(($stats['rfid_ready'] / $stats['total_siswa']) * 100) : 0 }}%
                    </span>
                </div>
            </div>

        </div>
    </div>

    <!-- ================= 2B. INTERACTIVE UNIT DISTRIBUTION STRIP (SINGLE SEAMLESS ORANGE GRADIENT CARD) ================= -->
    @if (auth()->user()->kode_unit == 'U06' && $rekap_unit->count() > 0)
        <div class="rounded-2xl shadow-sm bg-gradient-to-r from-orange-600 via-amber-600 to-orange-700 text-white p-5 sm:p-6 border border-orange-700/40 relative overflow-hidden">
            <!-- Background watermark -->
            <div class="absolute -right-8 -bottom-10 text-white/5 pointer-events-none">
                <i class="ti ti-layout-grid text-[200px]"></i>
            </div>

            <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5 pb-4 border-b border-white/15">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-white/20 backdrop-blur-sm border border-white/25 text-white flex items-center justify-center text-base font-bold shadow-2xs">
                        <i class="ti ti-layout-grid"></i>
                    </div>
                    <div>
                        <h3 class="text-xs font-black uppercase tracking-wider text-white leading-tight">
                            Distribusi Santri per Unit Pendidikan
                        </h3>
                        <p class="text-[11px] text-orange-100/90">Klik segmen unit di bawah untuk memfilter data santri secara instan</p>
                    </div>
                </div>

                <!-- Active Filter Reset pill if unit is filtered -->
                @if(Request('kode_unit'))
                    <a href="{{ route('akademiksiswa.index', array_merge(request()->except('kode_unit', 'page'))) }}" 
                       class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg bg-white text-orange-800 text-xs font-black transition-all duration-200 hover:bg-orange-50 shadow-sm active:scale-95">
                        <i class="ti ti-filter-off text-sm"></i>
                        <span>Reset Filter (Semua Unit)</span>
                    </a>
                @else
                    <span class="text-[11px] font-black text-white bg-white/20 border border-white/25 px-3 py-1 rounded-lg">
                        Total: {{ number_format($stats['total_siswa']) }} Santri
                    </span>
                @endif
            </div>

            <!-- Single Row Seamless Flow with Tapered Dividers -->
            <div class="relative z-10 flex flex-wrap sm:flex-nowrap items-stretch justify-between gap-y-6">
                @php
                    $unitIcons = [
                        'U01' => 'ti-mood-smile',
                        'U02' => 'ti-school',
                        'U03' => 'ti-book-2',
                        'U04' => 'ti-building-community',
                        'U05' => 'ti-certificate',
                    ];
                @endphp

                @foreach ($rekap_unit as $index => $r)
                    @php
                        $icon = $unitIcons[$r->kode_unit] ?? 'ti-school';
                        $persen = $stats['total_siswa'] > 0 ? round(($r->jumlah / $stats['total_siswa']) * 100, 1) : 0;
                        $isSelected = Request('kode_unit') == $r->kode_unit;
                    @endphp
                    
                    @if($index > 0)
                        <!-- Tapered Vertical Divider Line -->
                        <div class="hidden sm:block w-[1px] bg-gradient-to-b from-transparent via-white/35 to-transparent self-center h-16 shrink-0"></div>
                    @endif

                    <a href="{{ route('akademiksiswa.index', array_merge(request()->query(), ['kode_unit' => $isSelected ? '' : $r->kode_unit, 'page' => 1])) }}" 
                       class="flex-1 min-w-[130px] sm:min-w-[150px] px-3 sm:px-4 py-2 rounded-xl transition-all duration-200 cursor-pointer group flex flex-col justify-between relative {{ $isSelected ? 'bg-white/25 ring-2 ring-white/40 shadow-inner' : 'hover:bg-white/10' }}"
                       title="Klik untuk memfilter unit {{ $r->nama_unit }}">
                        
                        <div>
                            <div class="flex items-center justify-between gap-2">
                                <span class="text-[11px] font-black uppercase tracking-wider text-orange-100 truncate group-hover:text-white transition">
                                    {{ $r->nama_unit }}
                                </span>
                                @if($isSelected)
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-white text-orange-800 shadow-2xs">
                                        Aktif
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-white/15 text-orange-100 border border-white/20">
                                        {{ $r->kode_unit }}
                                    </span>
                                @endif
                            </div>

                            <div class="text-3xl sm:text-4xl font-black text-white tracking-tight mt-1.5 flex items-baseline gap-1">
                                {{ number_format($r->jumlah) }}
                                <span class="text-xs font-semibold text-orange-200">Santri</span>
                            </div>
                        </div>

                        <div class="mt-3.5">
                            <!-- Progress Bar -->
                            <div class="w-full h-1.5 bg-black/20 rounded-full overflow-hidden mb-2">
                                <div class="h-full bg-white/90 rounded-full transition-all duration-500" style="width: {{ min(100, max(4, $persen)) }}%"></div>
                            </div>
                            <div class="flex items-center justify-between text-xs text-orange-100/90">
                                <span class="font-medium text-[11px] flex items-center gap-1">
                                    <i class="ti {{ $icon }} text-xs opacity-80"></i>
                                    <span>Porsi</span>
                                </span>
                                <span class="font-black text-white text-[10px] bg-white/20 px-2 py-0.5 rounded-md">
                                    {{ $persen }}%
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    <!-- ================= 3. FILTER TOOLBAR ================= -->
    <form action="{{ route('akademiksiswa.index') }}" method="GET" class="w-full">
        @php
            $isU06 = auth()->user()->kode_unit == 'U06';
        @endphp
        
        <div class="flex flex-col md:flex-row items-center gap-2.5 sm:gap-3 w-full">
            <!-- Search Input -->
            <div class="flex-1 min-w-0 w-full relative">
                <i class="ti ti-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-lg pointer-events-none"></i>
                <input type="text" 
                       name="nama_lengkap" 
                       value="{{ Request('nama_lengkap') }}" 
                       placeholder="Cari Nama Siswa / NIS / NISN / No. Pendaftaran / RFID..." 
                       class="w-full pl-11 pr-4 py-2.5 sm:py-3 text-sm bg-white border border-slate-300/90 rounded-lg text-slate-800 font-medium placeholder-slate-400 shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
            </div>

            <!-- Unit Filter (If U06) -->
            @if ($isU06)
                <div class="w-full md:w-44 lg:w-48 shrink-0">
                    <select name="kode_unit" id="kode_unit_search" class="w-full px-3.5 py-2.5 sm:py-3 text-sm bg-white border border-slate-300/90 rounded-lg text-slate-800 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                        <option value="">-- Semua Unit --</option>
                        @foreach ($unit as $d)
                            <option value="{{ $d->kode_unit }}" {{ Request('kode_unit') == $d->kode_unit ? 'selected' : '' }}>
                                {{ $d->nama_unit }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            <!-- Tingkat Filter -->
            <div class="w-full md:w-36 lg:w-40 shrink-0">
                <select name="tingkat" id="tingkat" class="w-full px-3.5 py-2.5 sm:py-3 text-sm bg-white border border-slate-300/90 rounded-lg text-slate-800 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                    <option value="">-- Tingkat --</option>
                </select>
            </div>

            <!-- Kelas Filter -->
            <div class="w-full md:w-36 lg:w-40 shrink-0">
                <select name="kode_kelas" id="kode_kelas_search" class="w-full px-3.5 py-2.5 sm:py-3 text-sm bg-white border border-slate-300/90 rounded-lg text-slate-800 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                    <option value="">-- Kelas --</option>
                </select>
            </div>

            <!-- Tahun Ajaran Filter -->
            <div class="w-full md:w-44 lg:w-48 shrink-0">
                <select name="kode_ta" id="kode_ta_search" class="w-full px-3.5 py-2.5 sm:py-3 text-sm bg-white border border-slate-300/90 rounded-lg text-slate-800 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                    <option value="">-- Tahun Ajaran --</option>
                    @foreach ($tahunajaran as $d)
                        <option value="{{ $d->kode_ta }}"
                            @if(!empty(Request('kode_ta')))
                                {{ Request('kode_ta') == $d->kode_ta ? 'selected' : '' }}
                            @else
                                {{ $d->kode_ta == ($tahun_ajaran->kode_ta ?? '') ? 'selected' : '' }}
                            @endif 
                        >
                            {{ $d->tahun_ajaran }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2 shrink-0 w-full md:w-auto">
                <button type="submit" class="w-full md:w-auto px-5 py-2.5 sm:py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-lg shadow-xs transition inline-flex items-center justify-center gap-2 cursor-pointer active:scale-95 whitespace-nowrap">
                    <i class="ti ti-search text-base"></i>
                    <span>Cari</span>
                </button>
                @if(Request('nama_lengkap') || Request('kode_unit') || Request('tingkat') || Request('kode_kelas') || Request('kode_ta'))
                    <a href="{{ route('akademiksiswa.index') }}" class="py-2.5 sm:py-3 px-3 bg-white hover:bg-slate-100 text-slate-600 border border-slate-300/90 rounded-lg font-semibold text-sm transition inline-flex items-center justify-center shrink-0 shadow-xs" title="Reset Filter">
                        <i class="ti ti-refresh text-base"></i>
                    </a>
                @endif
            </div>
        </div>
    </form>

    <!-- ================= 4. DATA LIST FULL-WIDTH CARDS ================= -->
    <div class="space-y-3">
        <!-- List Header Info -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 px-1 text-xs">
            <div class="flex items-center gap-2 text-slate-500">
                <span class="font-bold text-slate-900 text-sm flex items-center gap-1.5">
                    <i class="ti ti-school text-emerald-600 text-base"></i>
                    <span>Daftar Siswa</span>
                </span>
                <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                <span>Menampilkan <strong class="text-slate-800 font-bold">{{ $pendaftaran->firstItem() ?? 0 }}-{{ $pendaftaran->lastItem() ?? 0 }}</strong> dari <strong class="text-slate-800 font-bold">{{ $pendaftaran->total() }}</strong> siswa</span>
            </div>
            <div class="text-slate-400 font-medium">
                L: <strong class="text-blue-600 font-bold">{{ $stats['total_laki'] }}</strong> | P: <strong class="text-rose-600 font-bold">{{ $stats['total_perempuan'] }}</strong> | Kelas: <strong class="text-emerald-700 font-bold">{{ $stats['sudah_kelas'] }}</strong> | RFID: <strong class="text-amber-600 font-bold">{{ $stats['rfid_ready'] }}</strong>
            </div>
        </div>

        <!-- Cards List -->
        @forelse ($pendaftaran as $d)
            <div class="bg-white border border-slate-200/90 hover:border-emerald-300 rounded-xl p-4 sm:p-5 shadow-xs hover:shadow-md transition-all duration-200 group">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                    
                    <!-- Left: Identity & Details -->
                    <div class="flex items-start sm:items-center gap-3.5 sm:gap-4 flex-1 min-w-0">
                        <!-- Row Index Badge -->
                        <div class="hidden sm:flex w-7 h-7 rounded-lg bg-slate-100 text-slate-500 text-[11px] font-bold items-center justify-center shrink-0 border border-slate-200/80">
                            {{ $loop->iteration + $pendaftaran->firstItem() - 1 }}
                        </div>

                        <!-- Photo Thumbnail with Status Dot -->
                        <div class="relative shrink-0">
                            @if (!empty($d->foto_pendaftaran) && Storage::disk('public')->exists('photos/pendaftaran/' . $d->foto_pendaftaran))
                                <img src="{{ asset('storage/photos/pendaftaran/' . $d->foto_pendaftaran) }}" alt="{{ $d->nama_lengkap }}" class="w-12 h-15 sm:w-13 sm:h-16 rounded-lg object-cover border border-slate-200 shadow-2xs">
                            @else
                                <div class="w-12 h-15 sm:w-13 sm:h-16 rounded-lg bg-emerald-50 border border-emerald-200/80 flex flex-col items-center justify-center text-emerald-800 font-bold text-base shadow-2xs">
                                    {{ strtoupper(substr($d->nama_lengkap, 0, 1)) }}
                                </div>
                            @endif

                            @if($d->jenis_kelamin == 'L')
                                <span class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full bg-blue-500 text-white flex items-center justify-center text-[10px] ring-2 ring-white" title="Laki-laki">
                                    <i class="ti ti-gender-male"></i>
                                </span>
                            @else
                                <span class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full bg-rose-500 text-white flex items-center justify-center text-[10px] ring-2 ring-white" title="Perempuan">
                                    <i class="ti ti-gender-female"></i>
                                </span>
                            @endif
                        </div>

                        <!-- Info Content -->
                        <div class="flex-1 min-w-0">
                            <!-- Name & Badges -->
                            <div class="flex flex-wrap items-center gap-2">
                                <h4 class="text-sm sm:text-base font-bold capitalize text-slate-800 group-hover:text-emerald-700 transition truncate max-w-md" title="{{ $d->nama_lengkap }}">
                                    {{ textCamelCase($d->nama_lengkap) }}
                                </h4>

                                <!-- Unit Badge -->
                                <span class="px-2.5 py-0.5 rounded-md text-[10px] font-black uppercase tracking-wider bg-slate-100 text-slate-700 border border-slate-200/80">
                                    {{ $d->nama_unit }}
                                </span>

                                <!-- Tingkat Badge -->
                                <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                    <i class="ti ti-chart-bar text-xs mr-0.5"></i>
                                    Tingkat {{ $d->tingkat }}
                                </span>

                                <!-- Kelas Badge -->
                                @if(!empty($d->nama_kelas))
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <i class="ti ti-door-enter text-xs"></i>
                                        <span>Kelas {{ $d->nama_kelas }}</span>
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold inline-flex items-center gap-1 bg-amber-50 text-amber-700 border border-amber-200">
                                        <i class="ti ti-alert-circle text-xs"></i>
                                        <span>Belum Ada Kelas</span>
                                    </span>
                                @endif

                                <!-- RFID Badge -->
                                @if(!empty($d->rfid_code))
                                    <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200 inline-flex items-center gap-1" title="Smart Card RFID Terdaftar: {{ $d->rfid_code }}">
                                        <i class="ti ti-id-badge text-xs"></i>
                                        <span>RFID: {{ $d->rfid_code }}</span>
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-slate-100 text-slate-500 border border-slate-200 inline-flex items-center gap-1" title="Kartu RFID Belum Diset">
                                        <i class="ti ti-id-badge-2 text-xs"></i>
                                        <span>Belum RFID</span>
                                    </span>
                                @endif
                            </div>

                            <!-- Meta Chips Flex -->
                            <div class="flex flex-wrap items-center gap-x-4 gap-y-1.5 mt-2 text-xs text-slate-500">
                                <div class="flex items-center gap-1.5">
                                    <span class="text-slate-400 font-medium">No. Pendaftaran:</span>
                                    <span class="font-bold text-slate-800 bg-slate-100 px-1.5 py-0.5 rounded border border-slate-200 text-[11px]">{{ $d->no_pendaftaran }}</span>
                                </div>

                                <div class="flex items-center gap-1.5">
                                    <span class="text-slate-400 font-medium">ID Siswa:</span>
                                    <code class="font-bold text-emerald-800 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200 text-[11px]">
                                        {{ $d->id_siswa }}
                                    </code>
                                </div>

                                <div class="flex items-center gap-1.5">
                                    <span class="text-slate-400 font-medium">NISN / NIS:</span>
                                    <span class="font-semibold text-slate-700 text-[11px]">
                                        {{ $d->nisn ?: '-' }} / {{ $d->nis ?: '-' }}
                                    </span>
                                </div>

                                @if(!empty($d->tanggal_lahir))
                                    <div class="flex items-center gap-1 text-[11px] text-slate-600 font-medium">
                                        <i class="ti ti-cake text-slate-400"></i>
                                        <span>{{ !empty($d->tempat_lahir) ? $d->tempat_lahir . ', ' : '' }}{{ DateToIndo($d->tanggal_lahir) }}</span>
                                    </div>
                                @endif

                                @if(!empty($d->desa) || !empty($d->kecamatan))
                                    <div class="flex items-center gap-1 text-[11px] text-slate-500 truncate max-w-xs">
                                        <i class="ti ti-map-pin text-slate-400"></i>
                                        <span>{{ $d->desa ? $d->desa . ', ' : '' }}{{ $d->kecamatan ?? '' }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Right: Action Buttons Toolbar -->
                    <div class="flex flex-wrap items-center justify-end gap-1.5 shrink-0 pt-3 lg:pt-0 border-t lg:border-t-0 border-slate-100">
                        @can('pendaftaran.edit')
                            <button type="button" 
                                    class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg {{ !empty($d->rfid_code) ? 'bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200' : 'bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200' }} text-xs font-bold transition active:scale-95 btnRfid cursor-pointer shadow-2xs"
                                    no_pendaftaran="{{ Crypt::encrypt($d->no_pendaftaran) }}"
                                    nama_siswa="{{ $d->nama_lengkap }}"
                                    rfid_code="{{ $d->rfid_code ?? '' }}"
                                    title="{{ !empty($d->rfid_code) ? 'Edit Smart Card RFID' : 'Tambah Kartu RFID' }}">
                                <i class="ti ti-id-badge text-sm"></i>
                                <span>{{ !empty($d->rfid_code) ? 'RFID' : 'Set RFID' }}</span>
                            </button>
                        @endcan

                        @can('pendaftaran.show')
                            <a href="{{ route('pendaftaran.cetak-id-card', Crypt::encrypt($d->no_pendaftaran)) }}" 
                               target="_blank" 
                               class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200 text-xs font-bold transition active:scale-95 cursor-pointer shadow-2xs"
                               title="Cetak Kartu Siswa / ID Card">
                                <i class="ti ti-printer text-sm"></i>
                                <span>ID Card</span>
                            </a>

                            <button type="button" 
                                    class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 text-xs font-bold transition active:scale-95 btnShow cursor-pointer shadow-2xs"
                                    no_pendaftaran="{{ Crypt::encrypt($d->no_pendaftaran) }}"
                                    title="Lihat Detail Data Siswa">
                                <i class="ti ti-file-description text-sm"></i>
                                <span>Detail</span>
                            </button>
                        @endcan

                        @can('pendaftaran.edit')
                            <button type="button" 
                                    class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 text-xs font-bold transition active:scale-95 btnEdit cursor-pointer shadow-2xs"
                                    no_pendaftaran="{{ Crypt::encrypt($d->no_pendaftaran) }}"
                                    title="Edit Data Pendaftaran Siswa">
                                <i class="ti ti-edit text-sm"></i>
                                <span>Edit</span>
                            </button>
                        @endcan
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white border border-slate-200/90 rounded-2xl p-12 text-center shadow-xs">
                <div class="w-16 h-16 bg-slate-50 text-slate-400 rounded-2xl flex items-center justify-center mx-auto mb-3.5 text-2xl border border-slate-200/80">
                    <i class="ti ti-users-off text-3xl"></i>
                </div>
                <h3 class="text-base font-bold text-slate-800 mb-1">Belum Ada Data Siswa</h3>
                <p class="text-xs text-slate-500 max-w-sm mx-auto mb-4">
                    Data siswa tidak ditemukan untuk kriteria filter yang Anda pilih. Silakan sesuaikan unit, tingkat, kelas, atau kata kunci pencarian.
                </p>
                <a href="{{ route('akademiksiswa.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg text-xs shadow-xs transition active:scale-95 cursor-pointer">
                    <i class="ti ti-refresh text-base"></i>
                    <span>Reset Filter Pencarian</span>
                </a>
            </div>
        @endforelse

        <!-- Pagination -->
        <div class="pt-4">
            {{ $pendaftaran->links('vendor.pagination.custom-tailwind') }}
        </div>
    </div>
</div>

<!-- ================= MODALS ================= -->
<x-modal-form id="modal" size="modal-xl" show="loadmodal" title="" icon="ti ti-user" />
<x-modal-form id="modalSekolah" size="" show="loadmodal" title="" icon="ti ti-school" />
<x-modal-form id="modalRfid" size="modal-md" show="loadmodalRfid" title="Atur Smart Card RFID" icon="ti ti-id-badge" />

@endsection

@push('myscript')
<script>
    $(function() {
        const loading = `<div class="p-8 text-center"><div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-emerald-500 border-t-transparent"></div><p class="mt-2 text-xs font-semibold text-slate-500">Memuat Formulir...</p></div>`;

        // Edit Pendaftaran Modal
        $(document).on("click", ".btnEdit", function(e) {
            e.preventDefault();
            const no_pendaftaran = $(this).attr("no_pendaftaran");
            $("#modal").modal("show");
            $("#modal").find("#loadmodal").html(loading);
            $("#modal").find(".modal-title").text("Edit Data Siswa / Pendaftaran");
            $("#loadmodal").load(`/pendaftaran/${no_pendaftaran}/edit`);
        });

        // Detail Pendaftaran Modal
        $(document).on("click", ".btnShow", function(e) {
            e.preventDefault();
            const no_pendaftaran = $(this).attr("no_pendaftaran");
            $("#modal").modal("show");
            $("#modal").find("#loadmodal").html(loading);
            $("#modal").find(".modal-title").text("Detail Data Siswa / Pendaftaran");
            $("#loadmodal").load(`/pendaftaran/${no_pendaftaran}/show`);
        });

        // RFID Modal Trigger
        $(document).on("click", ".btnRfid", function(e) {
            e.preventDefault();
            const no_pendaftaran = $(this).attr("no_pendaftaran");
            const namaSiswa = $(this).attr("nama_siswa");
            const rfidCode = $(this).attr("rfid_code");

            $("#modalRfid").modal("show");
            $("#modalRfid").find("#loadmodalRfid").html(`
                <form id="formRfid" onsubmit="event.preventDefault(); saveRfid('${no_pendaftaran}');" class="space-y-4">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Nama Siswa</label>
                        <div class="relative">
                            <i class="ti ti-user absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                            <input type="text" class="w-full pl-10 pr-4 py-2.5 text-xs bg-slate-100 border border-slate-200 rounded-lg text-slate-700 font-bold" value="${namaSiswa}" readonly>
                        </div>
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Kode RFID (Smart Card)</label>
                        <div class="relative">
                            <i class="ti ti-id-badge absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                            <input type="text" class="w-full pl-10 pr-4 py-2.5 text-xs bg-white border border-slate-300 rounded-lg text-slate-800 font-semibold focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" id="rfid_input" value="${rfidCode}" placeholder="Tempelkan kartu pada scanner atau ketik kode RFID" autocomplete="off">
                        </div>
                        <p class="text-[11px] text-slate-400">Kosongkan kolom di atas jika ingin menghapus RFID yang sudah terdaftar.</p>
                    </div>
                    <div class="flex items-center gap-2 pt-3 border-t border-slate-100">
                        <button type="button" class="flex-1 py-2.5 px-4 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-lg transition" data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="button" class="flex-1 py-2.5 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-lg transition shadow-xs" onclick="saveRfid('${no_pendaftaran}')">
                            <i class="ti ti-device-floppy mr-1"></i> Simpan RFID
                        </button>
                    </div>
                </form>
            `);
            setTimeout(() => $("#rfid_input").focus(), 400);
        });

        // Save RFID Function
        window.saveRfid = function(no_pendaftaran) {
            const rfidInput = document.getElementById('rfid_input');
            const rfidCode = rfidInput ? rfidInput.value.trim() : '';

            fetch(`/pendaftaran/${no_pendaftaran}/update-rfid`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ rfid_code: rfidCode })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        timer: 1500,
                        showConfirmButton: false,
                        customClass: {
                            popup: 'rounded-2xl shadow-2xl p-5',
                            title: 'text-base font-bold text-slate-900'
                        }
                    }).then(() => location.reload());
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: data.message || 'Gagal memperbarui RFID',
                        customClass: {
                            popup: 'rounded-2xl shadow-2xl p-5',
                            title: 'text-base font-bold text-slate-900',
                            confirmButton: 'px-4 py-2 bg-emerald-600 text-white font-bold text-xs rounded-xl shadow-xs'
                        }
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan sistem saat memperbarui RFID!',
                    customClass: {
                        popup: 'rounded-2xl shadow-2xl p-5',
                        title: 'text-base font-bold text-slate-900',
                        confirmButton: 'px-4 py-2 bg-emerald-600 text-white font-bold text-xs rounded-xl shadow-xs'
                    }
                });
            });
        };

        // Dependent dropdown: get Tingkat by Unit
        function getTingkatByUnit(kode_unit, selected = '') {
            selected = selected || "{{ Request('tingkat') }}";
            $.ajax({
                type: "POST",
                url: "{{ route('unit.gettingkatbyunit') }}",
                cache: false,
                data: {
                    _token: "{{ csrf_token() }}",
                    kode_unit: kode_unit,
                    selected: selected
                },
                success: function(respond) {
                    $("#tingkat").html(respond);
                }
            });
        }

        // Dependent dropdown: get Kelas by Tingkat
        function getKelasByTingkat(kode_unit, tingkat, kode_ta, selected = '') {
            selected = selected || "{{ Request('kode_kelas') }}";
            $.ajax({
                type: "POST",
                url: "{{ route('unit.getkelasbytingkat') }}",
                cache: false,
                data: {
                    _token: "{{ csrf_token() }}",
                    kode_unit: kode_unit,
                    tingkat: tingkat,
                    kode_ta: kode_ta,
                    selected: selected
                },
                success: function(respond) {
                    $("#kode_kelas_search").html(respond);
                }
            });
        }

        // Dropdown change handlers
        $(document).on('change', '#kode_unit_search', function() {
            const kode_unit = $(this).val();
            getTingkatByUnit(kode_unit);
            getKelasByTingkat(kode_unit, '', $('#kode_ta_search').val());
        });

        $(document).on('change', '#tingkat', function() {
            const tingkat = $(this).val();
            const kode_unit = $('#kode_unit_search').length ? $('#kode_unit_search').val() : "{{ auth()->user()->kode_unit }}";
            const kode_ta = $('#kode_ta_search').val();
            getKelasByTingkat(kode_unit, tingkat, kode_ta);
        });

        $(document).on('change', '#kode_ta_search', function() {
            const kode_ta = $(this).val();
            const kode_unit = $('#kode_unit_search').length ? $('#kode_unit_search').val() : "{{ auth()->user()->kode_unit }}";
            const tingkat = $('#tingkat').val();
            getKelasByTingkat(kode_unit, tingkat, kode_ta);
        });

        // Initialize dependent dropdowns on page load
        @if ($isU06)
            getTingkatByUnit("{{ Request('kode_unit') }}");
            getKelasByTingkat("{{ Request('kode_unit') }}", "{{ Request('tingkat') }}", "{{ Request('kode_ta') ?: ($tahun_ajaran->kode_ta ?? '') }}");
        @else
            getTingkatByUnit("{{ auth()->user()->kode_unit }}");
            getKelasByTingkat("{{ auth()->user()->kode_unit }}", "{{ Request('tingkat') }}", "{{ Request('kode_ta') ?: ($tahun_ajaran->kode_ta ?? '') }}");
        @endif
    });
</script>
@endpush

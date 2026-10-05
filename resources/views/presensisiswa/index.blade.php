@extends('layouts.app')
@section('titlepage', 'Monitoring Presensi Siswa')

@section('content')
<div class="space-y-6">

    <!-- ================= 1. PAGE HEADER (NO CARD) WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <i class="ti ti-calendar-check text-emerald-600 text-2xl"></i>
                <span>Monitoring Presensi Siswa</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Monitoring log kehadiran harian santri, jam check-in/check-out, status absensi, dan integrasi smart scanner RFID
            </p>
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
                    <i class="ti ti-school text-sm"></i>
                    <span>Akademik</span>
                </span>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Presensi Siswa</span>
            </nav>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('public.presensi-siswa') }}" target="_blank" 
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg text-xs shadow-xs transition-all duration-200 active:scale-95 cursor-pointer">
                    <i class="ti ti-scan text-base"></i>
                    <span>Layar Scan RFID</span>
                </a>
            </div>
        </div>
    </div>

    <!-- ================= 2. EXECUTIVE STATISTICS (SINGLE SEAMLESS EMERALD CARD WITH TAPERED DIVIDERS) ================= -->
    <div class="rounded-2xl shadow-sm bg-gradient-to-r from-emerald-800 via-emerald-700 to-teal-700 text-white p-5 sm:p-6 border border-emerald-900/30 relative overflow-hidden">
        <!-- Background watermark -->
        <div class="absolute -right-8 -bottom-10 text-white/5 pointer-events-none">
            <i class="ti ti-calendar-check text-[200px]"></i>
        </div>

        <div class="relative z-10 flex flex-wrap sm:flex-nowrap items-stretch justify-between gap-y-6">
            
            <!-- Segment 1: Total Santri -->
            <div class="flex-1 min-w-[120px] sm:min-w-[140px] px-2.5 sm:px-3.5 flex flex-col justify-between group">
                <div>
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-[11px] font-black uppercase tracking-wider text-emerald-200 truncate">
                            Total Santri
                        </span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-white/20 text-white border border-white/25">
                            Semua
                        </span>
                    </div>
                    <div class="text-3xl sm:text-4xl font-black text-white tracking-tight mt-1.5">
                        {{ number_format($stats['total']) }}
                    </div>
                </div>
                <div class="mt-3.5 pt-2 flex items-center justify-between text-xs text-emerald-200/90">
                    <span class="font-medium text-[11px] flex items-center gap-1">
                        <i class="ti ti-calendar text-xs opacity-70"></i>
                        <span>{{ \Carbon\Carbon::parse($tanggal)->format('d/m/y') }}</span>
                    </span>
                    <span class="font-black text-white text-[10px] bg-white/20 px-2 py-0.5 rounded-md">
                        100%
                    </span>
                </div>
            </div>

            <!-- Tapered Vertical Divider Line -->
            <div class="hidden sm:block w-[1px] bg-gradient-to-b from-transparent via-white/35 to-transparent self-center h-16 shrink-0"></div>

            <!-- Segment 2: Hadir -->
            <div class="flex-1 min-w-[120px] sm:min-w-[140px] px-2.5 sm:px-3.5 flex flex-col justify-between group">
                <div>
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-[11px] font-black uppercase tracking-wider text-emerald-200 truncate">
                            Hadir
                        </span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-white/15 text-emerald-100 border border-white/20">
                            Masuk
                        </span>
                    </div>
                    <div class="text-3xl sm:text-4xl font-black text-white tracking-tight mt-1.5">
                        {{ number_format($stats['hadir']) }}
                    </div>
                </div>
                <div class="mt-3.5 pt-2 flex items-center justify-between text-xs text-emerald-200/90">
                    <span class="font-medium text-[11px] flex items-center gap-1">
                        <i class="ti ti-circle-check text-xs opacity-70"></i>
                        <span>Presensi</span>
                    </span>
                    <span class="font-black text-white text-[10px] bg-white/15 px-2 py-0.5 rounded-md">
                        {{ $stats['total'] > 0 ? round(($stats['hadir'] / $stats['total']) * 100) : 0 }}%
                    </span>
                </div>
            </div>

            <!-- Tapered Vertical Divider Line -->
            <div class="hidden sm:block w-[1px] bg-gradient-to-b from-transparent via-white/35 to-transparent self-center h-16 shrink-0"></div>

            <!-- Segment 3: Izin -->
            <div class="flex-1 min-w-[120px] sm:min-w-[140px] px-2.5 sm:px-3.5 flex flex-col justify-between group">
                <div>
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-[11px] font-black uppercase tracking-wider text-emerald-200 truncate">
                            Izin
                        </span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-white/15 text-emerald-100 border border-white/20">
                            Izin
                        </span>
                    </div>
                    <div class="text-3xl sm:text-4xl font-black text-white tracking-tight mt-1.5">
                        {{ number_format($stats['izin']) }}
                    </div>
                </div>
                <div class="mt-3.5 pt-2 flex items-center justify-between text-xs text-emerald-200/90">
                    <span class="font-medium text-[11px] flex items-center gap-1">
                        <i class="ti ti-info-circle text-xs opacity-70"></i>
                        <span>Status Izin</span>
                    </span>
                    <span class="font-black text-white text-[10px] bg-white/15 px-2 py-0.5 rounded-md">
                        {{ $stats['total'] > 0 ? round(($stats['izin'] / $stats['total']) * 100) : 0 }}%
                    </span>
                </div>
            </div>

            <!-- Tapered Vertical Divider Line -->
            <div class="hidden sm:block w-[1px] bg-gradient-to-b from-transparent via-white/35 to-transparent self-center h-16 shrink-0"></div>

            <!-- Segment 4: Sakit -->
            <div class="flex-1 min-w-[120px] sm:min-w-[140px] px-2.5 sm:px-3.5 flex flex-col justify-between group">
                <div>
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-[11px] font-black uppercase tracking-wider text-emerald-200 truncate">
                            Sakit
                        </span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-white/15 text-emerald-100 border border-white/20">
                            Sakit
                        </span>
                    </div>
                    <div class="text-3xl sm:text-4xl font-black text-white tracking-tight mt-1.5">
                        {{ number_format($stats['sakit']) }}
                    </div>
                </div>
                <div class="mt-3.5 pt-2 flex items-center justify-between text-xs text-emerald-200/90">
                    <span class="font-medium text-[11px] flex items-center gap-1">
                        <i class="ti ti-medical-cross text-xs opacity-70"></i>
                        <span>Status Sakit</span>
                    </span>
                    <span class="font-black text-white text-[10px] bg-white/15 px-2 py-0.5 rounded-md">
                        {{ $stats['total'] > 0 ? round(($stats['sakit'] / $stats['total']) * 100) : 0 }}%
                    </span>
                </div>
            </div>

            <!-- Tapered Vertical Divider Line -->
            <div class="hidden sm:block w-[1px] bg-gradient-to-b from-transparent via-white/35 to-transparent self-center h-16 shrink-0"></div>

            <!-- Segment 5: Alpha -->
            <div class="flex-1 min-w-[120px] sm:min-w-[140px] px-2.5 sm:px-3.5 flex flex-col justify-between group">
                <div>
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-[11px] font-black uppercase tracking-wider text-emerald-200 truncate">
                            Alpha
                        </span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-white/15 text-emerald-100 border border-white/20">
                            Alpha
                        </span>
                    </div>
                    <div class="text-3xl sm:text-4xl font-black text-white tracking-tight mt-1.5">
                        {{ number_format($stats['alpha']) }}
                    </div>
                </div>
                <div class="mt-3.5 pt-2 flex items-center justify-between text-xs text-emerald-200/90">
                    <span class="font-medium text-[11px] flex items-center gap-1">
                        <i class="ti ti-circle-x text-xs opacity-70"></i>
                        <span>Tanpa Ket.</span>
                    </span>
                    <span class="font-black text-white text-[10px] bg-white/15 px-2 py-0.5 rounded-md">
                        {{ $stats['total'] > 0 ? round(($stats['alpha'] / $stats['total']) * 100) : 0 }}%
                    </span>
                </div>
            </div>

            <!-- Tapered Vertical Divider Line -->
            <div class="hidden sm:block w-[1px] bg-gradient-to-b from-transparent via-white/35 to-transparent self-center h-16 shrink-0"></div>

            <!-- Segment 6: Belum Absen -->
            <div class="flex-1 min-w-[120px] sm:min-w-[140px] px-2.5 sm:px-3.5 flex flex-col justify-between group">
                <div>
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-[11px] font-black uppercase tracking-wider text-emerald-200 truncate">
                            Belum Absen
                        </span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-white/15 text-emerald-100 border border-white/20">
                            Pending
                        </span>
                    </div>
                    <div class="text-3xl sm:text-4xl font-black text-white tracking-tight mt-1.5">
                        {{ number_format($stats['belum_absen']) }}
                    </div>
                </div>
                <div class="mt-3.5 pt-2 flex items-center justify-between text-xs text-emerald-200/90">
                    <span class="font-medium text-[11px] flex items-center gap-1">
                        <i class="ti ti-clock-play text-xs opacity-70"></i>
                        <span>Belum Log</span>
                    </span>
                    <span class="font-black text-white text-[10px] bg-white/15 px-2 py-0.5 rounded-md">
                        {{ $stats['total'] > 0 ? round(($stats['belum_absen'] / $stats['total']) * 100) : 0 }}%
                    </span>
                </div>
            </div>

        </div>
    </div>

    <!-- ================= 3. FILTER TOOLBAR ================= -->
    <form action="{{ route('presensisiswa.index') }}" method="GET" class="w-full">
        @php
            $isSuperAdmin = auth()->user()->hasRole('super admin');
        @endphp
        
        <div class="flex flex-col md:flex-row items-center gap-2.5 sm:gap-3 w-full">
            <!-- Search Input -->
            <div class="flex-1 min-w-0 w-full relative">
                <i class="ti ti-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-lg pointer-events-none"></i>
                <input type="text" 
                       name="nama_lengkap" 
                       value="{{ Request('nama_lengkap') }}" 
                       placeholder="Cari Nama Santri / NIS / NISN / No. Pendaftaran..." 
                       class="w-full pl-11 pr-4 py-2.5 sm:py-3 text-sm bg-white border border-slate-300/90 rounded-lg text-slate-800 font-medium placeholder-slate-400 shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
            </div>

            <!-- Tanggal Filter -->
            <div class="w-full md:w-44 lg:w-48 shrink-0 relative">
                <i class="ti ti-calendar absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base pointer-events-none"></i>
                <input type="text" 
                       name="tanggal" 
                       value="{{ $tanggal }}" 
                       placeholder="Pilih Tanggal" 
                       class="flatpickr-date w-full pl-10 pr-4 py-2.5 sm:py-3 text-sm bg-white border border-slate-300/90 rounded-lg text-slate-800 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition cursor-pointer">
            </div>

            <!-- Unit Filter (If Super Admin) -->
            @if ($isSuperAdmin)
                <div class="w-full md:w-40 lg:w-44 shrink-0">
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
            <div class="w-full md:w-32 lg:w-36 shrink-0">
                <select name="tingkat" id="tingkat" class="w-full px-3.5 py-2.5 sm:py-3 text-sm bg-white border border-slate-300/90 rounded-lg text-slate-800 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                    <option value="">-- Tingkat --</option>
                </select>
            </div>

            <!-- Kelas Filter -->
            <div class="w-full md:w-32 lg:w-36 shrink-0">
                <select name="kode_kelas" id="kode_kelas_search" class="w-full px-3.5 py-2.5 sm:py-3 text-sm bg-white border border-slate-300/90 rounded-lg text-slate-800 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                    <option value="">-- Kelas --</option>
                </select>
            </div>

            <!-- Tahun Ajaran Filter -->
            <div class="w-full md:w-40 lg:w-44 shrink-0">
                <select name="kode_ta" id="kode_ta_search" class="w-full px-3.5 py-2.5 sm:py-3 text-sm bg-white border border-slate-300/90 rounded-lg text-slate-800 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                    <option value="">-- Tahun Ajaran --</option>
                    @foreach ($tahunajaran as $d)
                        <option value="{{ $d->kode_ta }}"
                            @if (!empty(Request('kode_ta')))
                                {{ Request('kode_ta') == $d->kode_ta ? 'selected' : '' }}
                            @else
                                {{ ($tahun_ajaran->kode_ta ?? '') == $d->kode_ta ? 'selected' : '' }}
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
                @if(Request('nama_lengkap') || Request('kode_unit') || Request('tingkat') || Request('kode_kelas') || Request('kode_ta') || (Request('tanggal') && Request('tanggal') != date('Y-m-d')))
                    <a href="{{ route('presensisiswa.index') }}" class="py-2.5 sm:py-3 px-3 bg-white hover:bg-slate-100 text-slate-600 border border-slate-300/90 rounded-lg font-semibold text-sm transition inline-flex items-center justify-center shrink-0 shadow-xs" title="Reset Filter">
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
                    <i class="ti ti-calendar-event text-emerald-600 text-base"></i>
                    <span>Daftar Presensi: <strong>{{ DateToIndo($tanggal) }}</strong></span>
                </span>
                <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                <span>Menampilkan <strong class="text-slate-800 font-bold">{{ $pendaftaran->firstItem() ?? 0 }}-{{ $pendaftaran->lastItem() ?? 0 }}</strong> dari <strong class="text-slate-800 font-bold">{{ $pendaftaran->total() }}</strong> santri</span>
            </div>
            <div class="text-slate-400 font-medium">
                Hadir: <strong class="text-emerald-700 font-bold">{{ $stats['hadir'] }}</strong> | Izin: <strong class="text-amber-700 font-bold">{{ $stats['izin'] }}</strong> | Sakit: <strong class="text-blue-700 font-bold">{{ $stats['sakit'] }}</strong> | Alpha: <strong class="text-rose-600 font-bold">{{ $stats['alpha'] }}</strong>
            </div>
        </div>

        <!-- Cards List -->
        @forelse ($pendaftaran as $d)
            @php
                $statusCfg = match ($d->presensi_status) {
                    'h' => ['bg' => 'hover:border-emerald-300/80', 'badgeBg' => 'bg-emerald-50 text-emerald-700 border-emerald-200', 'label' => 'Hadir', 'icon' => 'ti-circle-check'],
                    'i' => ['bg' => 'hover:border-amber-300/80', 'badgeBg' => 'bg-amber-50 text-amber-700 border-amber-200', 'label' => 'Izin', 'icon' => 'ti-info-circle'],
                    's' => ['bg' => 'hover:border-blue-300/80', 'badgeBg' => 'bg-blue-50 text-blue-700 border-blue-200', 'label' => 'Sakit', 'icon' => 'ti-medical-cross'],
                    'a' => ['bg' => 'hover:border-rose-300/80', 'badgeBg' => 'bg-rose-50 text-rose-700 border-rose-200', 'label' => 'Alpha', 'icon' => 'ti-circle-x'],
                    default => ['bg' => 'hover:border-slate-300', 'badgeBg' => 'bg-slate-50 text-slate-500 border-slate-200', 'label' => 'Belum Absen', 'icon' => 'ti-clock-play']
                };
            @endphp
            <div class="bg-white border border-slate-200/90 {{ $statusCfg['bg'] }} rounded-xl p-4 sm:p-5 shadow-xs hover:shadow-md transition-all duration-200 group">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                    
                    <!-- Left: Identity & Details -->
                    <div class="flex items-start sm:items-center gap-3.5 sm:gap-4 flex-1 min-w-0">
                        <!-- Row Index Badge -->
                        <div class="hidden sm:flex w-7 h-7 rounded-lg bg-slate-100 text-slate-500 text-[11px] font-bold items-center justify-center shrink-0 border border-slate-200/80">
                            {{ $loop->iteration + $pendaftaran->firstItem() - 1 }}
                        </div>

                        <!-- Photo Thumbnail with Status Indicator -->
                        <div class="relative shrink-0">
                            @if (!empty($d->foto_pendaftaran) && Storage::disk('public')->exists('photos/pendaftaran/' . $d->foto_pendaftaran))
                                <img src="{{ asset('storage/photos/pendaftaran/' . $d->foto_pendaftaran) }}" alt="{{ $d->nama_lengkap }}" class="w-12 h-15 sm:w-13 sm:h-16 rounded-lg object-cover border border-slate-200 shadow-2xs">
                            @else
                                <div class="w-12 h-15 sm:w-13 sm:h-16 rounded-lg bg-emerald-50 border border-emerald-200/80 flex flex-col items-center justify-center text-emerald-800 font-bold text-base shadow-2xs">
                                    {{ strtoupper(substr($d->nama_lengkap, 0, 1)) }}
                                </div>
                            @endif

                            @if($d->presensi_status == 'h')
                                <span class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full bg-emerald-600 text-white flex items-center justify-center text-[10px] ring-2 ring-white" title="Hadir">
                                    <i class="ti ti-check"></i>
                                </span>
                            @elseif($d->presensi_status == 'a')
                                <span class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full bg-rose-500 text-white flex items-center justify-center text-[10px] ring-2 ring-white" title="Alpha">
                                    <i class="ti ti-x"></i>
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
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold inline-flex items-center gap-1 bg-amber-50 text-amber-700 border border-amber-200">
                                        <i class="ti ti-alert-circle text-xs"></i>
                                        <span>Belum Set Kelas</span>
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
                                    <span class="text-slate-400 font-medium">ID:</span>
                                    <code class="font-bold text-emerald-800 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200 text-[11px]">
                                        {{ $d->id_siswa }}
                                    </code>
                                </div>

                                <div class="flex items-center gap-1.5">
                                    <span class="text-slate-400 font-medium">NIS:</span>
                                    <span class="font-semibold text-slate-700 text-[11px]">{{ $d->nis ?: '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Middle: Attendance Times -->
                    <div class="flex items-center gap-4 sm:gap-6 shrink-0 py-2 lg:py-0 border-y lg:border-y-0 lg:border-x lg:px-6 border-slate-100">
                        <div class="text-center min-w-[70px]">
                            <div class="text-[11px] font-medium text-slate-400 mb-0.5 flex items-center justify-center gap-1">
                                <i class="ti ti-login text-emerald-600"></i>
                                <span>Jam Masuk</span>
                            </div>
                            @if ($d->jam_in)
                                <span class="text-sm sm:text-base font-black font-mono text-emerald-700">{{ \Carbon\Carbon::parse($d->jam_in)->format('H:i') }}</span>
                            @else
                                <span class="text-sm sm:text-base font-bold font-mono text-slate-300">-</span>
                            @endif
                        </div>
                        <div class="w-px h-8 bg-slate-200"></div>
                        <div class="text-center min-w-[70px]">
                            <div class="text-[11px] font-medium text-slate-400 mb-0.5 flex items-center justify-center gap-1">
                                <i class="ti ti-logout text-rose-500"></i>
                                <span>Jam Keluar</span>
                            </div>
                            @if ($d->jam_out)
                                <span class="text-sm sm:text-base font-black font-mono text-rose-700">{{ \Carbon\Carbon::parse($d->jam_out)->format('H:i') }}</span>
                            @else
                                <span class="text-sm sm:text-base font-bold font-mono text-slate-300">-</span>
                            @endif
                        </div>
                    </div>

                    <!-- Right: Attendance Status Badge -->
                    <div class="flex items-center justify-end shrink-0">
                        <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full font-bold text-xs border shadow-2xs {{ $statusCfg['badgeBg'] }}">
                            <i class="ti {{ $statusCfg['icon'] }} text-base"></i>
                            <span class="tracking-wide">{{ $statusCfg['label'] }}</span>
                        </span>
                    </div>

                </div>
            </div>
        @empty
            <div class="bg-white border border-slate-200/90 rounded-2xl p-12 text-center shadow-xs">
                <div class="w-16 h-16 bg-slate-50 text-slate-400 rounded-2xl flex items-center justify-center mx-auto mb-3.5 text-2xl border border-slate-200/80">
                    <i class="ti ti-calendar-off text-3xl"></i>
                </div>
                <h3 class="text-base font-bold text-slate-800 mb-1">Belum Ada Data Presensi</h3>
                <p class="text-xs text-slate-500 max-w-sm mx-auto mb-4">
                    Data presensi untuk tanggal dan filter terpilih belum ditemukan. Silakan sesuaikan tanggal atau unit pencarian.
                </p>
                <a href="{{ route('presensisiswa.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg text-xs shadow-xs transition active:scale-95 cursor-pointer">
                    <i class="ti ti-refresh text-base"></i>
                    <span>Reset Filter Presensi</span>
                </a>
            </div>
        @endforelse

        <!-- Pagination -->
        <div class="pt-4">
            {{ $pendaftaran->links('vendor.pagination.custom-tailwind') }}
        </div>
    </div>
</div>

@endsection

@push('myscript')
<script>
    $(function() {
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
        @if (auth()->user()->hasRole('super admin'))
            getTingkatByUnit("{{ Request('kode_unit') }}");
            getKelasByTingkat("{{ Request('kode_unit') }}", "{{ Request('tingkat') }}", "{{ Request('kode_ta') ?: ($tahun_ajaran->kode_ta ?? '') }}");
        @else
            getTingkatByUnit("{{ auth()->user()->kode_unit }}");
            getKelasByTingkat("{{ auth()->user()->kode_unit }}", "{{ Request('tingkat') }}", "{{ Request('kode_ta') ?: ($tahun_ajaran->kode_ta ?? '') }}");
        @endif
    });
</script>
@endpush

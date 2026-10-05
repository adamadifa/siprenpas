@extends('layouts.app')
@section('titlepage', 'Data Karyawan')

@section('content')
<div class="space-y-6">

    <!-- ================= 1. PAGE HEADER (NO CARD) WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <i class="ti ti-id-badge-2 text-emerald-600 text-2xl"></i>
                <span>Data Karyawan</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Manajemen data pegawai, jabatan, unit penempatan, jadwal kerja, dan akun akses sistem
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
                    <i class="ti ti-database text-sm"></i>
                    <span>Master Data</span>
                </span>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Karyawan</span>
            </nav>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center gap-2">
                @can('karyawan.create')
                    <button type="button" id="btncreateKaryawan" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg text-xs shadow-xs transition-all duration-200 active:scale-95 cursor-pointer">
                        <i class="ti ti-plus text-base"></i>
                        <span>Tambah Karyawan</span>
                    </button>
                @endcan
            </div>
        </div>
    </div>

    <!-- ================= 2. EXECUTIVE STATISTICS (SINGLE SEAMLESS EMERALD CARD WITH TAPERED DIVIDERS) ================= -->
    <div class="rounded-2xl shadow-sm bg-gradient-to-r from-emerald-800 via-emerald-700 to-teal-700 text-white p-5 sm:p-6 border border-emerald-900/30 relative overflow-hidden">
        <!-- Background watermark -->
        <div class="absolute -right-8 -bottom-10 text-white/5 pointer-events-none">
            <i class="ti ti-id-badge-2 text-[200px]"></i>
        </div>

        <div class="relative z-10 flex flex-wrap sm:flex-nowrap items-stretch justify-between gap-y-6">
            
            <!-- Segment 1: Total Karyawan -->
            <div class="flex-1 min-w-[140px] sm:min-w-[160px] px-3 sm:px-4 flex flex-col justify-between group">
                <div>
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-[11px] font-black uppercase tracking-wider text-emerald-200 truncate">
                            Total Karyawan
                        </span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-white/20 text-white border border-white/25">
                            Semua
                        </span>
                    </div>
                    <div class="text-3xl sm:text-4xl font-black text-white tracking-tight mt-1.5">
                        {{ number_format($stats['total_karyawan']) }}
                    </div>
                </div>
                <div class="mt-3.5 pt-2 flex items-center justify-between text-xs text-emerald-200/90">
                    <span class="font-medium text-[11px]">Semua Pegawai</span>
                    <span class="font-black text-white text-[10px] bg-white/20 px-2 py-0.5 rounded-md">
                        100%
                    </span>
                </div>
            </div>

            <!-- Tapered Vertical Divider Line -->
            <div class="hidden sm:block w-[1px] bg-gradient-to-b from-transparent via-white/35 to-transparent self-center h-16 shrink-0"></div>

            <!-- Segment 2: Karyawan Aktif -->
            <div class="flex-1 min-w-[140px] sm:min-w-[160px] px-3 sm:px-4 flex flex-col justify-between group">
                <div>
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-[11px] font-black uppercase tracking-wider text-emerald-200 truncate">
                            Karyawan Aktif
                        </span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-white/15 text-emerald-100 border border-white/20">
                            Aktif
                        </span>
                    </div>
                    <div class="text-3xl sm:text-4xl font-black text-white tracking-tight mt-1.5">
                        {{ number_format($stats['aktif']) }}
                    </div>
                </div>
                <div class="mt-3.5 pt-2 flex items-center justify-between text-xs text-emerald-200/90">
                    <span class="font-medium text-[11px] flex items-center gap-1">
                        <i class="ti ti-user-check text-xs opacity-70"></i>
                        <span>Status Bekerja</span>
                    </span>
                    <span class="font-black text-white text-[10px] bg-white/15 px-2 py-0.5 rounded-md">
                        {{ $stats['total_karyawan'] > 0 ? round(($stats['aktif'] / $stats['total_karyawan']) * 100) : 0 }}%
                    </span>
                </div>
            </div>

            <!-- Tapered Vertical Divider Line -->
            <div class="hidden sm:block w-[1px] bg-gradient-to-b from-transparent via-white/35 to-transparent self-center h-16 shrink-0"></div>

            <!-- Segment 3: Karyawan Nonaktif -->
            <div class="flex-1 min-w-[140px] sm:min-w-[160px] px-3 sm:px-4 flex flex-col justify-between group">
                <div>
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-[11px] font-black uppercase tracking-wider text-emerald-200 truncate">
                            Nonaktif / Off
                        </span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-white/15 text-emerald-100 border border-white/20">
                            Off
                        </span>
                    </div>
                    <div class="text-3xl sm:text-4xl font-black text-white tracking-tight mt-1.5">
                        {{ number_format($stats['nonaktif']) }}
                    </div>
                </div>
                <div class="mt-3.5 pt-2 flex items-center justify-between text-xs text-emerald-200/90">
                    <span class="font-medium text-[11px] flex items-center gap-1">
                        <i class="ti ti-user-x text-xs opacity-70"></i>
                        <span>Status Berhenti</span>
                    </span>
                    <span class="font-black text-white text-[10px] bg-white/15 px-2 py-0.5 rounded-md">
                        {{ $stats['total_karyawan'] > 0 ? round(($stats['nonaktif'] / $stats['total_karyawan']) * 100) : 0 }}%
                    </span>
                </div>
            </div>

            <!-- Tapered Vertical Divider Line -->
            <div class="hidden sm:block w-[1px] bg-gradient-to-b from-transparent via-white/35 to-transparent self-center h-16 shrink-0"></div>

            <!-- Segment 4: Total Unit -->
            <div class="flex-1 min-w-[140px] sm:min-w-[160px] px-3 sm:px-4 flex flex-col justify-between group">
                <div>
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-[11px] font-black uppercase tracking-wider text-emerald-200 truncate">
                            Total Unit
                        </span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-white/15 text-emerald-100 border border-white/20">
                            Unit
                        </span>
                    </div>
                    <div class="text-3xl sm:text-4xl font-black text-white tracking-tight mt-1.5">
                        {{ number_format($stats['total_unit']) }}
                    </div>
                </div>
                <div class="mt-3.5 pt-2 flex items-center justify-between text-xs text-emerald-200/90">
                    <span class="font-medium text-[11px] flex items-center gap-1">
                        <i class="ti ti-building text-xs opacity-70"></i>
                        <span>Unit Kerja</span>
                    </span>
                    <span class="font-black text-white text-[10px] bg-white/15 px-2 py-0.5 rounded-md">
                        Terdaftar
                    </span>
                </div>
            </div>

        </div>
    </div>

    <!-- ================= 3. FILTER TOOLBAR (FULL-WIDTH 1 ROW WITH EXPANDING SEARCH & COMPACT BUTTONS) ================= -->
    <form action="{{ route('karyawan.index') }}" method="GET" class="w-full">
        @php
            $isU06 = auth()->user()->kode_unit == 'U06';
        @endphp
        
        <div class="flex flex-col md:flex-row items-center gap-2.5 sm:gap-3 w-full">
            <!-- Search Input (Flex-1 expands to fill all remaining width) -->
            <div class="flex-1 min-w-0 w-full relative">
                <i class="ti ti-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-lg pointer-events-none"></i>
                <input type="text" 
                       name="nama_lengkap" 
                       value="{{ Request('nama_lengkap') }}" 
                       placeholder="Cari Nama Karyawan / NPP / No. KTP..." 
                       class="w-full pl-11 pr-4 py-2.5 sm:py-3 text-sm bg-white border border-slate-300/90 rounded-lg text-slate-800 font-medium placeholder-slate-400 shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
            </div>

            <!-- Unit Filter (If U06) -->
            @if ($isU06)
                <div class="w-full md:w-52 lg:w-60 shrink-0">
                    <select name="kode_unit" id="kode_unit_search" class="w-full px-4 py-2.5 sm:py-3 text-sm bg-white border border-slate-300/90 rounded-lg text-slate-800 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                        <option value="">-- Semua Unit --</option>
                        @foreach ($units as $u)
                            <option value="{{ $u->kode_unit }}" {{ Request('kode_unit') == $u->kode_unit ? 'selected' : '' }}>
                                {{ $u->nama_unit }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            <!-- Departemen Filter -->
            <div class="w-full md:w-52 lg:w-56 shrink-0">
                <select name="kode_dept" id="kode_dept_search" class="w-full px-4 py-2.5 sm:py-3 text-sm bg-white border border-slate-300/90 rounded-lg text-slate-800 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                    <option value="">-- Semua Departemen --</option>
                    @foreach ($departemen as $dept)
                        <option value="{{ $dept->kode_dept }}" {{ Request('kode_dept') == $dept->kode_dept ? 'selected' : '' }}>
                            {{ $dept->nama_dept }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Compact Action Buttons -->
            <div class="flex items-center gap-2 shrink-0 w-full md:w-auto">
                <button type="submit" class="w-full md:w-auto px-5 py-2.5 sm:py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-lg shadow-xs transition inline-flex items-center justify-center gap-2 cursor-pointer active:scale-95 whitespace-nowrap">
                    <i class="ti ti-search text-base"></i>
                    <span>Cari</span>
                </button>
                @if(Request('nama_lengkap') || Request('kode_unit') || Request('kode_dept'))
                    <a href="{{ route('karyawan.index') }}" class="py-2.5 sm:py-3 px-3 bg-white hover:bg-slate-100 text-slate-600 border border-slate-300/90 rounded-lg font-semibold text-sm transition inline-flex items-center justify-center shrink-0 shadow-xs" title="Reset Filter">
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
                    <i class="ti ti-id-badge text-emerald-600 text-base"></i>
                    <span>Daftar Karyawan</span>
                </span>
                <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                <span>Menampilkan <strong class="text-slate-800 font-bold">{{ $karyawan->firstItem() ?? 0 }}-{{ $karyawan->lastItem() ?? 0 }}</strong> dari <strong class="text-slate-800 font-bold">{{ $karyawan->total() }}</strong> pegawai</span>
            </div>
            <div class="text-slate-400 font-medium">
                Aktif: <strong class="text-emerald-700 font-bold">{{ $stats['aktif'] }}</strong> | Nonaktif: <strong class="text-rose-600 font-bold">{{ $stats['nonaktif'] }}</strong>
            </div>
        </div>

        <!-- Cards List -->
        @forelse ($karyawan as $d)
            <div class="bg-white border {{ $d->status == 1 ? 'border-slate-200/90 hover:border-emerald-300/90' : 'border-rose-200/80 hover:border-rose-300' }} rounded-xl p-4 sm:p-5 shadow-xs hover:shadow-md transition-all duration-200 group">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                    
                    <!-- Left: Identity & Details -->
                    <div class="flex items-start sm:items-center gap-3.5 sm:gap-4 flex-1 min-w-0">
                        <!-- Row Index Badge -->
                        <div class="hidden sm:flex w-7 h-7 rounded-lg bg-slate-100 text-slate-500 text-[11px] font-bold items-center justify-center shrink-0 border border-slate-200/80">
                            {{ $loop->iteration + $karyawan->firstItem() - 1 }}
                        </div>

                        <!-- Photo Thumbnail with Status Dot -->
                        <div class="relative shrink-0">
                            @if (!empty($d->foto) && Storage::disk('public')->exists('photos/karyawan/' . $d->foto))
                                <img src="{{ getfotoKaryawan($d->foto) }}" alt="{{ $d->nama_lengkap }}" class="w-12 h-15 sm:w-13 sm:h-16 rounded-lg object-cover border border-slate-200 shadow-2xs">
                            @else
                                <div class="w-12 h-15 sm:w-13 sm:h-16 rounded-lg bg-slate-100 border border-slate-200/80 flex flex-col items-center justify-center text-slate-700 font-bold text-base shadow-2xs">
                                    {{ strtoupper(substr($d->nama_lengkap, 0, 1)) }}
                                </div>
                            @endif

                            @if($d->status == 1)
                                <span class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full bg-emerald-600 text-white flex items-center justify-center text-[10px] ring-2 ring-white" title="Status Aktif">
                                    <i class="ti ti-check"></i>
                                </span>
                            @else
                                <span class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full bg-rose-500 text-white flex items-center justify-center text-[10px] ring-2 ring-white" title="Status Nonaktif">
                                    <i class="ti ti-x"></i>
                                </span>
                            @endif
                        </div>

                        <!-- Info Content -->
                        <div class="flex-1 min-w-0">
                            <!-- Name & Status Badges -->
                            <div class="flex flex-wrap items-center gap-2">
                                <h4 class="text-sm sm:text-base font-bold capitalize text-slate-800 group-hover:text-emerald-700 transition truncate max-w-md" title="{{ $d->nama_lengkap }}">
                                    {{ textCamelCase($d->nama_lengkap) }}
                                </h4>

                                <!-- Unit Badge -->
                                <span class="px-2.5 py-0.5 rounded-md text-[10px] font-black uppercase tracking-wider bg-slate-100 text-slate-700 border border-slate-200/80">
                                    {{ $d->nama_unit }}
                                </span>

                                <!-- Departemen Badge -->
                                @if (!empty($d->nama_dept))
                                    <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-100">
                                        {{ $d->nama_dept }}
                                    </span>
                                @endif

                                <!-- Status Toggle Pill -->
                                <a href="{{ route('karyawan.updatestatus', Crypt::encrypt($d->npp)) }}" 
                                   class="px-2.5 py-0.5 rounded-full text-[10px] font-bold transition inline-flex items-center gap-1 {{ $d->status == 1 ? 'bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100' : 'bg-rose-50 text-rose-700 border border-rose-200 hover:bg-rose-100' }}"
                                   title="Klik untuk mengubah status aktif/nonaktif">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $d->status == 1 ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                                    <span>{{ $d->status == 1 ? 'AKTIF' : 'NONAKTIF' }}</span>
                                </a>

                                <!-- User Access Badge -->
                                @if (!empty($d->id_user))
                                    <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 inline-flex items-center gap-1" title="User Login Terdaftar">
                                        <i class="ti ti-user-check"></i>
                                        <span>User Aktif</span>
                                    </span>
                                @endif
                            </div>

                            <!-- Meta Chips Flex -->
                            <div class="flex flex-wrap items-center gap-x-4 gap-y-1.5 mt-2 text-xs text-slate-500">
                                <div class="flex items-center gap-1.5">
                                    <span class="text-slate-400 font-medium">NPP:</span>
                                    <span class="font-bold text-slate-800 bg-slate-100 px-1.5 py-0.5 rounded border border-slate-200 text-[11px]">{{ $d->npp }}</span>
                                </div>

                                <div class="flex items-center gap-1.5">
                                    <span class="text-slate-400 font-medium">Jabatan:</span>
                                    <span class="font-bold text-amber-800 bg-amber-50 px-2 py-0.5 rounded border border-amber-200 text-[11px]">
                                        <i class="ti ti-briefcase text-xs"></i>
                                        <span>{{ $d->nama_jabatan ?? 'Belum Ditentukan' }}</span>
                                    </span>
                                </div>

                                @if(!empty($d->tmt))
                                    <div class="flex items-center gap-1 text-[11px] text-slate-500">
                                        <i class="ti ti-calendar text-slate-400"></i>
                                        <span>TMT: {{ DateToIndo($d->tmt) }}</span>
                                    </div>
                                @endif

                                @if(!empty($d->no_hp))
                                    <div class="flex items-center gap-1 text-[11px] text-slate-600 font-medium">
                                        <i class="ti ti-phone text-slate-400"></i>
                                        <span>{{ $d->no_hp }}</span>
                                    </div>
                                @endif

                                @if(!empty($d->hari_kerja))
                                    <div class="flex items-center gap-1 text-[11px] text-slate-400" title="Hari Kerja: {{ $d->hari_kerja }}">
                                        <i class="ti ti-calendar-check text-slate-400"></i>
                                        <span class="truncate max-w-xs">{{ $d->hari_kerja }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Right: Action Buttons Toolbar -->
                    <div class="flex flex-wrap items-center justify-end gap-1.5 shrink-0 pt-3 lg:pt-0 border-t lg:border-t-0 border-slate-100">
                        @can('karyawan.show')
                            <a href="{{ route('karyawan.show', Crypt::encrypt($d->npp)) }}" 
                               class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 text-xs font-bold transition active:scale-95 cursor-pointer"
                               title="Lihat Detail Profil Karyawan">
                                <i class="ti ti-file-description text-sm"></i>
                                <span>Detail</span>
                            </a>
                        @endcan

                        @can('karyawan.edit')
                            <button type="button" 
                                    class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 text-xs font-bold transition active:scale-95 editKaryawan cursor-pointer"
                                    npp="{{ Crypt::encrypt($d->npp) }}"
                                    title="Edit Data Profil Karyawan">
                                <i class="ti ti-edit text-sm"></i>
                                <span>Edit</span>
                            </button>
                        @endcan

                        @can('karyawan.create')
                            <button type="button" 
                                    class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200 text-xs font-bold transition active:scale-95 btnSetJamkerja cursor-pointer"
                                    npp="{{ Crypt::encrypt($d->npp) }}"
                                    title="Atur Jam Kerja Harian & Khusus">
                                <i class="ti ti-clock text-sm"></i>
                                <span>Jam Kerja</span>
                            </button>

                            <button type="button" 
                                    class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 text-xs font-bold transition active:scale-95 btnSetharikerja cursor-pointer"
                                    npp="{{ Crypt::encrypt($d->npp) }}"
                                    title="Atur Hari Kerja Mingguan">
                                <i class="ti ti-calendar text-sm"></i>
                                <span>Hari Kerja</span>
                            </button>
                        @endcan

                        <!-- User Account Menu / Quick Action -->
                        @if (!empty($d->id_user))
                            @can('karyawan.create')
                                <a href="{{ route('karyawan.resetuser', Crypt::encrypt($d->npp)) }}" 
                                   class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200 text-xs font-bold transition active:scale-95 reset-user-confirm cursor-pointer"
                                   data-name="{{ $d->nama_lengkap }}"
                                   title="Reset Password ke Default (12345678)">
                                    <i class="ti ti-rotate text-sm text-amber-600"></i>
                                    <span>Reset User</span>
                                </a>

                                <a href="{{ route('karyawan.deleteuser', Crypt::encrypt($d->npp)) }}" 
                                   class="w-8.5 h-8.5 rounded-lg bg-slate-100 hover:bg-rose-100 text-slate-500 hover:text-rose-700 border border-slate-200 flex items-center justify-center transition active:scale-95 delete-user-confirm cursor-pointer" 
                                   data-name="{{ $d->nama_lengkap }}"
                                   title="Hapus Akses Login User">
                                    <i class="ti ti-user-x text-sm"></i>
                                </a>
                            @endcan
                        @else
                            @can('karyawan.create')
                                <a href="{{ route('karyawan.createuser', Crypt::encrypt($d->npp)) }}" 
                                   class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-teal-50 hover:bg-teal-100 text-teal-700 border border-teal-200 text-xs font-bold transition active:scale-95 cursor-pointer"
                                   title="Buat Akun User Login Default">
                                    <i class="ti ti-user-plus text-sm"></i>
                                    <span>Buat User</span>
                                </a>
                            @endcan
                        @endif

                        @can('karyawan.delete')
                            <form method="POST" class="deleteform inline-block" action="{{ route('karyawan.delete', Crypt::encrypt($d->npp)) }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" 
                                        class="w-8.5 h-8.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 flex items-center justify-center transition active:scale-95 btn-delete-karyawan cursor-pointer" 
                                        data-name="{{ $d->nama_lengkap }}"
                                        data-npp="{{ $d->npp }}"
                                        title="Hapus Data Karyawan">
                                    <i class="ti ti-trash text-sm"></i>
                                </button>
                            </form>
                        @endcan
                    </div>

                </div>
            </div>
        @empty
            <div class="bg-white border border-slate-200/90 rounded-xl p-12 text-center text-slate-400 shadow-xs">
                <div class="w-14 h-14 rounded-2xl bg-slate-100 border border-slate-200 flex items-center justify-center mx-auto mb-3 text-slate-400 text-2xl">
                    <i class="ti ti-users-off"></i>
                </div>
                <h4 class="text-sm font-bold text-slate-800">Belum Ada Data Karyawan Ditemukan</h4>
                <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">Silakan sesuaikan filter pencarian atau klik tombol Tambah Karyawan di atas untuk menambahkan pegawai baru.</p>
            </div>
        @endforelse

        <!-- Pagination -->
        @if ($karyawan->hasPages())
            <div class="bg-white border border-slate-200/90 rounded-xl p-4 shadow-xs flex flex-col sm:flex-row items-center justify-between gap-3 mt-4">
                <div class="text-xs text-slate-500 font-medium">
                    Menampilkan <strong class="text-slate-800 font-bold">{{ $karyawan->firstItem() }}</strong> - <strong class="text-slate-800 font-bold">{{ $karyawan->lastItem() }}</strong> dari <strong class="text-slate-800 font-bold">{{ $karyawan->total() }}</strong> total data
                </div>
                <div>
                    {{ $karyawan->links('vendor.pagination.custom-tailwind') }}
                </div>
            </div>
        @endif
    </div>

</div>

<!-- ================= MODAL CONTAINERS ================= -->
<x-modal-form id="mdlcreateKaryawan" size="modal-xl" show="loadcreateKaryawan" title="" icon="ti ti-user-plus" />
<x-modal-form id="mdleditKaryawan" size="modal-xl" show="loadeditKaryawan" title="" icon="ti ti-user-edit" />
<x-modal-form id="mdlsetharikerja" size="modal-lg" show="loadsetharikerja" title="" icon="ti ti-calendar-check" />
<x-modal-form id="modalSetJamkerja" size="modal-xl" show="loadmodalSetJamkerja" title="" icon="ti ti-clock-plus" />

@endsection

@push('myscript')
<script>
    $(function() {
        const loading = `
            <div class="p-12 text-center bg-white">
                <div class="w-10 h-10 border-3 border-emerald-500 border-t-transparent rounded-full animate-spin mx-auto mb-3"></div>
                <div class="text-xs font-bold text-slate-700">Memuat Data Karyawan...</div>
            </div>
        `;

        $("#btncreateKaryawan").click(function(e) {
            e.preventDefault();
            e.stopPropagation();
            $('#mdlcreateKaryawan').modal("show");
            $("#mdlcreateKaryawan").find("#loadcreateKaryawan").html(loading);
            $("#mdlcreateKaryawan").find(".modal-title").text("Tambah Data Karyawan Baru");
            $("#loadcreateKaryawan").load('/karyawan/create');
        });

        $(document).on('click', '.editKaryawan', function(e) {
            e.preventDefault();
            e.stopPropagation();
            var npp = $(this).attr("npp");
            $('#mdleditKaryawan').modal("show");
            $("#mdleditKaryawan").find("#loadeditKaryawan").html(loading);
            $("#mdleditKaryawan").find(".modal-title").text("Edit Profil & Data Karyawan");
            $("#loadeditKaryawan").load('/karyawan/' + npp + '/edit');
        });

        $(document).on('click', ".btnSetharikerja", function(e) {
            e.preventDefault();
            e.stopPropagation();
            var npp = $(this).attr("npp");
            $('#mdlsetharikerja').modal("show");
            $("#mdlsetharikerja").find("#loadsetharikerja").html(loading);
            $("#mdlsetharikerja").find(".modal-title").text("Atur Hari Kerja Pegawai");
            $("#loadsetharikerja").load('/karyawan/' + npp + '/setharikerja');
        });

        $(document).on('click', ".btnSetJamkerja", function(e) {
            e.preventDefault();
            e.stopPropagation();
            const npp = $(this).attr("npp");
            $("#modalSetJamkerja").modal("show");
            $("#modalSetJamkerja").find("#loadmodalSetJamkerja").html(loading);
            $("#modalSetJamkerja").find(".modal-title").text("Atur Shift & Jadwal Jam Kerja");
            $("#loadmodalSetJamkerja").load(`/karyawan/${npp}/setjamkerja`);
        });

        // Delete Confirm with SweetAlert2
        $(document).on('click', ".btn-delete-karyawan", function(e) {
            e.preventDefault();
            e.stopPropagation();
            var form = $(this).closest('form');
            var name = $(this).data('name') || 'karyawan ini';
            var npp = $(this).data('npp') || '';

            Swal.fire({
                title: 'Hapus Data Karyawan?',
                html: `
                    <div class="text-xs sm:text-sm text-slate-600 mt-2 space-y-2 text-center">
                        <p>Apakah Anda yakin ingin menghapus data pegawai:</p>
                        <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-xl font-bold text-slate-900">
                            ${name} ${npp ? `<span class="text-xs text-slate-500 font-normal block mt-0.5">NPP: ${npp}</span>` : ''}
                        </div>
                        <p class="text-[11px] text-rose-500 font-semibold">Seluruh data presensi, akun login, dan riwayat karyawan akan dihapus permanen.</p>
                    </div>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: '<i class="ti ti-trash mr-1"></i> Ya, Hapus Data',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-2xl shadow-2xl p-5',
                    title: 'text-base font-bold text-slate-900',
                    confirmButton: 'px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs rounded-xl shadow-xs transition cursor-pointer',
                    cancelButton: 'px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Menghapus Data...',
                        text: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: () => { Swal.showLoading(); }
                    });
                    form.get(0).submit();
                }
            });
        });

        // Reset User Confirm
        $(document).on('click', ".reset-user-confirm", function(e) {
            e.preventDefault();
            e.stopPropagation();
            var url = $(this).attr('href');
            var name = $(this).data('name') || 'karyawan ini';

            Swal.fire({
                title: 'Reset Password User?',
                html: `
                    <div class="text-xs sm:text-sm text-slate-600 mt-2 space-y-2 text-center">
                        <p>Password akun login untuk pegawai:</p>
                        <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-xl font-bold text-slate-900">
                            ${name}
                        </div>
                        <p class="text-[11px] text-amber-600 font-semibold">Password akan di-reset kembali ke default: <strong class="text-slate-900">12345678</strong>.</p>
                    </div>
                `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#d97706',
                cancelButtonColor: '#64748b',
                confirmButtonText: '<i class="ti ti-rotate mr-1"></i> Ya, Reset Password',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-2xl shadow-2xl p-5',
                    title: 'text-base font-bold text-slate-900',
                    confirmButton: 'px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs rounded-xl shadow-xs transition cursor-pointer',
                    cancelButton: 'px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        });

        // Delete User Confirm
        $(document).on('click', ".delete-user-confirm", function(e) {
            e.preventDefault();
            e.stopPropagation();
            var url = $(this).attr('href');
            var name = $(this).data('name') || 'karyawan ini';

            Swal.fire({
                title: 'Hapus Akses User?',
                html: `
                    <div class="text-xs sm:text-sm text-slate-600 mt-2 space-y-2 text-center">
                        <p>Akun login sistem untuk pegawai:</p>
                        <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-xl font-bold text-slate-900">
                            ${name}
                        </div>
                        <p class="text-[11px] text-rose-500 font-semibold">Akses login akan dihapus, namun data profil karyawan tetap tersimpan.</p>
                    </div>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: '<i class="ti ti-user-x mr-1"></i> Ya, Hapus Akses',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-2xl shadow-2xl p-5',
                    title: 'text-base font-bold text-slate-900',
                    confirmButton: 'px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs rounded-xl shadow-xs transition cursor-pointer',
                    cancelButton: 'px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        });
    });
</script>
@endpush

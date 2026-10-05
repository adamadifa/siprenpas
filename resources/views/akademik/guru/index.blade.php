@extends('layouts.app')
@section('titlepage', 'Data Guru')

@section('content')
<div class="space-y-6">

    <!-- ================= 1. PAGE HEADER (NO CARD) WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <i class="ti ti-school text-emerald-600 text-2xl"></i>
                <span>Data Tenaga Pendidik (Guru)</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Manajemen data pendidik, unit homebase, jabatan akademik, status mengajar, dan TTD digital
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
                <span class="font-bold text-slate-800">Data Guru</span>
            </nav>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center gap-2">
                @can('guru.create')
                    <button type="button" id="btnCreateGuru" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg text-xs shadow-xs transition-all duration-200 active:scale-95 cursor-pointer">
                        <i class="ti ti-plus text-base"></i>
                        <span>Tambah Data Guru</span>
                    </button>
                @endcan
            </div>
        </div>
    </div>

    <!-- ================= 2. EXECUTIVE STATISTICS (SINGLE SEAMLESS EMERALD CARD WITH TAPERED DIVIDERS) ================= -->
    <div class="rounded-2xl shadow-sm bg-gradient-to-r from-emerald-800 via-emerald-700 to-teal-700 text-white p-5 sm:p-6 border border-emerald-900/30 relative overflow-hidden">
        <!-- Background watermark -->
        <div class="absolute -right-8 -bottom-10 text-white/5 pointer-events-none">
            <i class="ti ti-school text-[200px]"></i>
        </div>

        <div class="relative z-10 flex flex-wrap sm:flex-nowrap items-stretch justify-between gap-y-6">
            
            <!-- Segment 1: Total Guru -->
            <div class="flex-1 min-w-[140px] sm:min-w-[160px] px-3 sm:px-4 flex flex-col justify-between group">
                <div>
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-[11px] font-black uppercase tracking-wider text-emerald-200 truncate">
                            Total Guru
                        </span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-white/20 text-white border border-white/25">
                            Semua
                        </span>
                    </div>
                    <div class="text-3xl sm:text-4xl font-black text-white tracking-tight mt-1.5">
                        {{ number_format($stats['total_guru']) }}
                    </div>
                </div>
                <div class="mt-3.5 pt-2 flex items-center justify-between text-xs text-emerald-200/90">
                    <span class="font-medium text-[11px] flex items-center gap-1">
                        <i class="ti ti-users text-xs opacity-70"></i>
                        <span>Semua Pendidik</span>
                    </span>
                    <span class="font-black text-white text-[10px] bg-white/20 px-2 py-0.5 rounded-md">
                        100%
                    </span>
                </div>
            </div>

            <!-- Tapered Vertical Divider Line -->
            <div class="hidden sm:block w-[1px] bg-gradient-to-b from-transparent via-white/35 to-transparent self-center h-16 shrink-0"></div>

            <!-- Segment 2: Guru Aktif Mengajar -->
            <div class="flex-1 min-w-[140px] sm:min-w-[160px] px-3 sm:px-4 flex flex-col justify-between group">
                <div>
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-[11px] font-black uppercase tracking-wider text-emerald-200 truncate">
                            Aktif Mengajar
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
                        <i class="ti ti-school text-xs opacity-70"></i>
                        <span>Status Mengajar</span>
                    </span>
                    <span class="font-black text-white text-[10px] bg-white/15 px-2 py-0.5 rounded-md">
                        {{ $stats['total_guru'] > 0 ? round(($stats['aktif'] / $stats['total_guru']) * 100) : 0 }}%
                    </span>
                </div>
            </div>

            <!-- Tapered Vertical Divider Line -->
            <div class="hidden sm:block w-[1px] bg-gradient-to-b from-transparent via-white/35 to-transparent self-center h-16 shrink-0"></div>

            <!-- Segment 3: Nonaktif / Cuti -->
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
                        <span>Status Off</span>
                    </span>
                    <span class="font-black text-white text-[10px] bg-white/15 px-2 py-0.5 rounded-md">
                        {{ $stats['total_guru'] > 0 ? round(($stats['nonaktif'] / $stats['total_guru']) * 100) : 0 }}%
                    </span>
                </div>
            </div>

            <!-- Tapered Vertical Divider Line -->
            <div class="hidden sm:block w-[1px] bg-gradient-to-b from-transparent via-white/35 to-transparent self-center h-16 shrink-0"></div>

            <!-- Segment 4: TTD Digital Ready -->
            <div class="flex-1 min-w-[140px] sm:min-w-[160px] px-3 sm:px-4 flex flex-col justify-between group">
                <div>
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-[11px] font-black uppercase tracking-wider text-emerald-200 truncate">
                            TTD Digital
                        </span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-white/15 text-emerald-100 border border-white/20">
                            Digital
                        </span>
                    </div>
                    <div class="text-3xl sm:text-4xl font-black text-white tracking-tight mt-1.5">
                        {{ number_format($stats['ttd_ready']) }}
                    </div>
                </div>
                <div class="mt-3.5 pt-2 flex items-center justify-between text-xs text-emerald-200/90">
                    <span class="font-medium text-[11px] flex items-center gap-1">
                        <i class="ti ti-file-certificate text-xs opacity-70"></i>
                        <span>Scan TTD Siap</span>
                    </span>
                    <span class="font-black text-white text-[10px] bg-white/15 px-2 py-0.5 rounded-md">
                        {{ $stats['total_guru'] > 0 ? round(($stats['ttd_ready'] / $stats['total_guru']) * 100) : 0 }}%
                    </span>
                </div>
            </div>

        </div>
    </div>

    <!-- ================= 3. FILTER TOOLBAR ================= -->
    <form action="{{ route('guru.index') }}" method="GET" class="w-full">
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
                       placeholder="Cari Nama Guru / NPP / NIP / NUPTK..." 
                       class="w-full pl-11 pr-4 py-2.5 sm:py-3 text-sm bg-white border border-slate-300/90 rounded-lg text-slate-800 font-medium placeholder-slate-400 shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
            </div>

            <!-- Unit Filter (If Super Admin) -->
            @if ($isSuperAdmin)
                <div class="w-full md:w-52 lg:w-60 shrink-0">
                    <select name="kode_unit" class="w-full px-4 py-2.5 sm:py-3 text-sm bg-white border border-slate-300/90 rounded-lg text-slate-800 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                        <option value="">-- Semua Unit --</option>
                        @foreach ($unit as $u)
                            <option value="{{ $u->kode_unit }}" {{ Request('kode_unit') == $u->kode_unit ? 'selected' : '' }}>
                                {{ $u->nama_unit }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            <!-- Status Mengajar Filter -->
            <div class="w-full md:w-48 lg:w-52 shrink-0">
                <select name="status_aktif_ajar" class="w-full px-4 py-2.5 sm:py-3 text-sm bg-white border border-slate-300/90 rounded-lg text-slate-800 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                    <option value="">-- Semua Status --</option>
                    <option value="1" {{ Request('status_aktif_ajar') === '1' ? 'selected' : '' }}>Aktif Mengajar</option>
                    <option value="0" {{ Request('status_aktif_ajar') === '0' ? 'selected' : '' }}>Non-Aktif</option>
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2 shrink-0 w-full md:w-auto">
                <button type="submit" class="w-full md:w-auto px-5 py-2.5 sm:py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-lg shadow-xs transition inline-flex items-center justify-center gap-2 cursor-pointer active:scale-95 whitespace-nowrap">
                    <i class="ti ti-search text-base"></i>
                    <span>Cari</span>
                </button>
                @if(Request('nama_lengkap') || Request('kode_unit') || Request('status_aktif_ajar') !== null)
                    <a href="{{ route('guru.index') }}" class="py-2.5 sm:py-3 px-3 bg-white hover:bg-slate-100 text-slate-600 border border-slate-300/90 rounded-lg font-semibold text-sm transition inline-flex items-center justify-center shrink-0 shadow-xs" title="Reset Filter">
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
                    <span>Daftar Guru</span>
                </span>
                <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                <span>Menampilkan <strong class="text-slate-800 font-bold">{{ $guru->firstItem() ?? 0 }}-{{ $guru->lastItem() ?? 0 }}</strong> dari <strong class="text-slate-800 font-bold">{{ $guru->total() }}</strong> pendidik</span>
            </div>
            <div class="text-slate-400 font-medium">
                Aktif: <strong class="text-emerald-700 font-bold">{{ $stats['aktif'] }}</strong> | Nonaktif: <strong class="text-rose-600 font-bold">{{ $stats['nonaktif'] }}</strong> | TTD Siap: <strong class="text-blue-600 font-bold">{{ $stats['ttd_ready'] }}</strong>
            </div>
        </div>

        <!-- Cards List -->
        @forelse ($guru as $d)
            <div class="bg-white border {{ $d->status_aktif_ajar == 1 ? 'border-slate-200/90 hover:border-emerald-300/90' : 'border-rose-200/80 hover:border-rose-300' }} rounded-xl p-4 sm:p-5 shadow-xs hover:shadow-md transition-all duration-200 group">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                    
                    <!-- Left: Identity & Details -->
                    <div class="flex items-start sm:items-center gap-3.5 sm:gap-4 flex-1 min-w-0">
                        <!-- Row Index Badge -->
                        <div class="hidden sm:flex w-7 h-7 rounded-lg bg-slate-100 text-slate-500 text-[11px] font-bold items-center justify-center shrink-0 border border-slate-200/80">
                            {{ $loop->iteration + $guru->firstItem() - 1 }}
                        </div>

                        <!-- Photo Thumbnail with Status Dot -->
                        <div class="relative shrink-0">
                            @if (!empty($d->foto) && Storage::disk('public')->exists('photos/karyawan/' . $d->foto))
                                <img src="{{ getfotoKaryawan($d->foto) }}" alt="{{ $d->nama_lengkap }}" class="w-12 h-15 sm:w-13 sm:h-16 rounded-lg object-cover border border-slate-200 shadow-2xs">
                            @else
                                <div class="w-12 h-15 sm:w-13 sm:h-16 rounded-lg bg-emerald-50 border border-emerald-200/80 flex flex-col items-center justify-center text-emerald-800 font-bold text-base shadow-2xs">
                                    {{ strtoupper(substr($d->nama_lengkap, 0, 1)) }}
                                </div>
                            @endif

                            @if($d->status_aktif_ajar == 1)
                                <span class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full bg-emerald-600 text-white flex items-center justify-center text-[10px] ring-2 ring-white" title="Status Aktif Mengajar">
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
                            <!-- Name & Badges -->
                            <div class="flex flex-wrap items-center gap-2">
                                <h4 class="text-sm sm:text-base font-bold capitalize text-slate-800 group-hover:text-emerald-700 transition truncate max-w-md" title="{{ $d->nama_lengkap }}">
                                    {{ textCamelCase($d->nama_lengkap) }}
                                </h4>

                                <!-- Unit Badge -->
                                <span class="px-2.5 py-0.5 rounded-md text-[10px] font-black uppercase tracking-wider bg-slate-100 text-slate-700 border border-slate-200/80">
                                    {{ $d->nama_unit }}
                                </span>

                                <!-- Jabatan Akademik Badge -->
                                <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-amber-50 text-amber-800 border border-amber-200">
                                    <i class="ti ti-award text-xs mr-0.5"></i>
                                    {{ $d->nama_jabatan ?: 'Pendidik' }}
                                </span>

                                <!-- Status Mengajar Pill -->
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold inline-flex items-center gap-1 {{ $d->status_aktif_ajar == 1 ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-rose-50 text-rose-700 border border-rose-200' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $d->status_aktif_ajar == 1 ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                                    <span>{{ $d->status_aktif_ajar == 1 ? 'AKTIF MENGAJAR' : 'NON-AKTIF' }}</span>
                                </span>

                                <!-- TTD Digital Badge -->
                                @if (!empty($d->file_ttd))
                                    <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200 inline-flex items-center gap-1" title="Tanda Tangan Digital Tersedia">
                                        <i class="ti ti-file-check"></i>
                                        <span>TTD Siap</span>
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200 inline-flex items-center gap-1" title="Tanda Tangan Belum Diupload">
                                        <i class="ti ti-file-off"></i>
                                        <span>Belum TTD</span>
                                    </span>
                                @endif

                                <!-- Password / User Access Badge -->
                                @if (!empty($d->password))
                                    <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 inline-flex items-center gap-1" title="Password Akun Khusus Telah Diset">
                                        <i class="ti ti-lock-check"></i>
                                        <span>Akun Aktif</span>
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200 inline-flex items-center gap-1" title="Password Default (NPP)">
                                        <i class="ti ti-key"></i>
                                        <span>Default NPP</span>
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
                                    <span class="text-slate-400 font-medium">NIP / NUPTK:</span>
                                    <code class="font-bold text-emerald-800 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200 text-[11px]">
                                        {{ $d->nomor_kemenag_dinas ?: '-' }}
                                    </code>
                                </div>

                                @if(!empty($d->no_hp))
                                    <div class="flex items-center gap-1 text-[11px] text-slate-600 font-medium">
                                        <i class="ti ti-phone text-slate-400"></i>
                                        <span>{{ $d->no_hp }}</span>
                                    </div>
                                @endif

                                @if(!empty($d->jenis_kelamin))
                                    <div class="flex items-center gap-1 text-[11px] text-slate-500">
                                        <i class="ti {{ $d->jenis_kelamin == 'L' ? 'ti-gender-male text-blue-500' : 'ti-gender-female text-rose-500' }}"></i>
                                        <span>{{ $d->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Right: Action Buttons Toolbar -->
                    <div class="flex flex-wrap items-center justify-end gap-1.5 shrink-0 pt-3 lg:pt-0 border-t lg:border-t-0 border-slate-100">
                        @if (!empty($d->file_ttd))
                            <a href="{{ asset('storage/uploads/ttd_guru/' . $d->file_ttd) }}" target="_blank" 
                               class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 text-xs font-bold transition active:scale-95 cursor-pointer shadow-2xs"
                               title="Lihat Tanda Tangan Digital">
                                <i class="ti ti-file-certificate text-sm"></i>
                                <span>Lihat TTD</span>
                            </a>
                        @endif

                        @can('guru.create')
                            <button type="button" 
                                    class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg {{ empty($d->password) ? 'bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200' : 'bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200' }} text-xs font-bold transition active:scale-95 createUserGuru cursor-pointer shadow-2xs"
                                    id="{{ Crypt::encrypt($d->id) }}"
                                    title="Kelola Password / Akun Guru">
                                <i class="ti {{ empty($d->password) ? 'ti-key' : 'ti-lock-check' }} text-sm"></i>
                                <span>Password</span>
                            </button>
                        @endcan

                        @can('guru.edit')
                            <button type="button" 
                                    class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 text-xs font-bold transition active:scale-95 editGuru cursor-pointer shadow-2xs"
                                    id="{{ Crypt::encrypt($d->id) }}"
                                    title="Edit Data Guru">
                                <i class="ti ti-edit text-sm"></i>
                                <span>Edit</span>
                            </button>
                        @endcan

                        @can('guru.delete')
                            <form method="POST" class="deleteform d-inline" action="{{ route('guru.delete', Crypt::encrypt($d->id)) }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" 
                                        class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 text-xs font-bold transition active:scale-95 delete-confirm cursor-pointer shadow-2xs"
                                        data-name="{{ $d->nama_lengkap }}"
                                        data-npp="{{ $d->npp }}"
                                        title="Hapus Data Guru">
                                    <i class="ti ti-trash text-sm"></i>
                                    <span>Hapus</span>
                                </button>
                            </form>
                        @endcan
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white border border-slate-200/90 rounded-2xl p-12 text-center shadow-xs">
                <div class="w-16 h-16 bg-slate-50 text-slate-400 rounded-2xl flex items-center justify-center mx-auto mb-3.5 text-2xl border border-slate-200/80">
                    <i class="ti ti-school-off text-3xl"></i>
                </div>
                <h3 class="text-base font-bold text-slate-800 mb-1">Belum Ada Data Guru</h3>
                <p class="text-xs text-slate-500 max-w-sm mx-auto mb-5">
                    Data tenaga pendidik belum ditemukan. Silakan tambahkan tenaga pendidik baru dari master pegawai.
                </p>
                @can('guru.create')
                    <button type="button" onclick="$('#btnCreateGuru').click()" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg text-xs shadow-xs transition active:scale-95 cursor-pointer">
                        <i class="ti ti-plus text-base"></i>
                        <span>Tambah Data Guru Pertama</span>
                    </button>
                @endcan
            </div>
        @endforelse

        <!-- Pagination -->
        <div class="pt-4">
            {{ $guru->links('vendor.pagination.custom-tailwind') }}
        </div>
    </div>
</div>

<!-- ================= MODALS ================= -->
<x-modal-form id="mdlCreateGuru" size="modal-lg" show="loadCreateGuru" title="Tambah Data Guru" icon="ti ti-user-plus" />
<x-modal-form id="mdlEditGuru" size="modal-lg" show="loadEditGuru" title="Edit Data Guru" icon="ti ti-user-edit" />
<x-modal-form id="mdlCreateUserGuru" size="modal-md" show="loadCreateUserGuru" title="Kelola Password Guru" icon="ti ti-key" />

@endsection

@push('myscript')
<script>
    $(function() {
        const loading = `<div class="p-8 text-center"><div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-emerald-500 border-t-transparent"></div><p class="mt-2 text-xs font-semibold text-slate-500">Memuat Formulir...</p></div>`;

        // Create Guru Modal
        $("#btnCreateGuru").click(function(e) {
            e.preventDefault();
            $('#mdlCreateGuru').modal("show");
            $("#loadCreateGuru").html(loading);
            $("#mdlCreateGuru").find(".modal-title").text("Tambah Data Guru Baru");
            $("#loadCreateGuru").load('/guru/create', function() {
                if (typeof $.fn.select2 !== 'undefined') {
                    $('#npp').select2({
                        placeholder: '-- Cari & Pilih Pegawai (Nama / NPP) --',
                        dropdownParent: $('#mdlCreateGuru'),
                        allowClear: true,
                        width: '100%'
                    });
                }
            });
        });

        $('#mdlCreateGuru').on('shown.bs.modal', function() {
            if (typeof $.fn.select2 !== 'undefined') {
                const selectKaryawan = $('#npp');
                if (selectKaryawan.length && !selectKaryawan.hasClass('select2-hidden-accessible')) {
                    selectKaryawan.select2({
                        placeholder: '-- Cari & Pilih Pegawai (Nama / NPP) --',
                        dropdownParent: $('#mdlCreateGuru'),
                        allowClear: true,
                        width: '100%'
                    });
                }
            }
        });

        // Edit Guru Modal
        $(document).on("click", ".editGuru", function(e) {
            e.preventDefault();
            var id = $(this).attr("id");
            $('#mdlEditGuru').modal("show");
            $("#loadEditGuru").html(loading);
            $("#mdlEditGuru").find(".modal-title").text("Edit Data Guru");
            $("#loadEditGuru").load('/guru/' + id + '/edit');
        });

        // Manage Password Guru Modal
        $(document).on("click", ".createUserGuru", function(e) {
            e.preventDefault();
            var id = $(this).attr("id");
            $('#mdlCreateUserGuru').modal("show");
            $("#loadCreateUserGuru").html(loading);
            $("#mdlCreateUserGuru").find(".modal-title").text("Kelola Password & Akses Login");
            $("#loadCreateUserGuru").load('/guru/' + id + '/create-user');
        });

        // Delete Confirm SweetAlert
        $(document).on('click', ".delete-confirm", function(e) {
            e.preventDefault();
            e.stopPropagation();
            var form = $(this).closest("form");
            var name = $(this).data('name') || 'guru ini';
            var npp = $(this).data('npp') || '';

            Swal.fire({
                title: 'Hapus Data Guru?',
                html: `
                    <div class="text-xs sm:text-sm text-slate-600 mt-2 space-y-2 text-center">
                        <p>Apakah Anda yakin ingin menghapus data tenaga pendidik:</p>
                        <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-xl font-bold text-slate-900">
                            ${name} ${npp ? `<span class="text-xs text-slate-500 font-normal block mt-0.5">NPP: ${npp}</span>` : ''}
                        </div>
                        <p class="text-[11px] text-rose-500 font-semibold">Data penugasan akademik dan tanda tangan digital akan dihapus dari sistem.</p>
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
                    form.submit();
                }
            });
        });
    });
</script>
@endpush

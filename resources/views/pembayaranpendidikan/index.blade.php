@extends('layouts.app')
@section('titlepage', 'Pembayaran Pendidikan')

@section('content')
<div class="space-y-5">

    <!-- ================= 1. PAGE HEADER (NO CARD) WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <i class="ti ti-wallet text-emerald-600 text-2xl"></i>
                <span>Pembayaran Pendidikan</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Manajemen tagihan, pembayaran SPP, kenaikan kelas, dan administrasi keuangan siswa
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
                    <i class="ti ti-wallet text-sm"></i>
                    <span>Keuangan</span>
                </span>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Pembayaran Pendidikan</span>
            </nav>
        </div>
    </div>

    <!-- ================= 2. STATISTIC SUMMARY (SINGLE SEAMLESS EMERALD CARD WITH TAPERED DIVIDERS) ================= -->
    <div class="rounded-2xl shadow-sm bg-gradient-to-r from-emerald-800 via-emerald-700 to-teal-700 text-white p-5 sm:p-6 border border-emerald-900/30 relative overflow-hidden">
        <!-- Background watermark -->
        <div class="absolute -right-8 -bottom-10 text-white/5 pointer-events-none">
            <i class="ti ti-wallet text-[200px]"></i>
        </div>

        <div class="relative z-10 flex flex-wrap sm:flex-nowrap items-stretch justify-between gap-y-6">
            
            <!-- Segment 1: Total Data Siswa -->
            <div class="flex-1 min-w-[140px] sm:min-w-[160px] px-3 sm:px-4 flex flex-col justify-between group">
                <div>
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-[11px] font-black uppercase tracking-wider text-emerald-200 truncate">
                            Total Data Siswa
                        </span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-white/20 text-white border border-white/25">
                            Semua
                        </span>
                    </div>
                    <div class="text-3xl sm:text-4xl font-black text-white tracking-tight mt-1.5">
                        {{ number_format($pendaftaran->total(), 0, ',', '.') }}
                    </div>
                </div>
                <div class="mt-3.5 pt-2 flex items-center justify-between text-xs text-emerald-200/90">
                    <span class="font-medium text-[11px] flex items-center gap-1">
                        <i class="ti ti-file-analytics text-xs opacity-70"></i>
                        <span>Hal {{ $pendaftaran->currentPage() }} dari {{ max(1, $pendaftaran->lastPage()) }}</span>
                    </span>
                    <span class="font-black text-white text-[10px] bg-white/20 px-2 py-0.5 rounded-md">
                        {{ $pendaftaran->perPage() }} / hal
                    </span>
                </div>
            </div>

            <!-- Tapered Vertical Divider Line -->
            <div class="hidden sm:block w-[1px] bg-gradient-to-b from-transparent via-white/35 to-transparent self-center h-16 shrink-0"></div>

            <!-- Segment 2: Tahun Ajaran Aktif -->
            <div class="flex-1 min-w-[140px] sm:min-w-[160px] px-3 sm:px-4 flex flex-col justify-between group">
                <div>
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-[11px] font-black uppercase tracking-wider text-emerald-200 truncate">
                            TA Aktif
                        </span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-white/15 text-emerald-100 border border-white/20">
                            Aktif
                        </span>
                    </div>
                    <div class="text-3xl sm:text-4xl font-black text-white tracking-tight mt-1.5">
                        {{ $tahun_ajaran->tahun_ajaran ?? '-' }}
                    </div>
                </div>
                <div class="mt-3.5 pt-2 flex items-center justify-between text-xs text-emerald-200/90">
                    <span class="font-medium text-[11px] flex items-center gap-1">
                        <i class="ti ti-calendar-event text-xs opacity-70"></i>
                        <span>Status Sistem</span>
                    </span>
                    <span class="font-black text-white text-[10px] bg-white/15 px-2 py-0.5 rounded-md">
                        Berjalan
                    </span>
                </div>
            </div>

            <!-- Tapered Vertical Divider Line -->
            <div class="hidden sm:block w-[1px] bg-gradient-to-b from-transparent via-white/35 to-transparent self-center h-16 shrink-0"></div>

            <!-- Segment 3: TA Siswa Baru (PPDB) -->
            <div class="flex-1 min-w-[140px] sm:min-w-[160px] px-3 sm:px-4 flex flex-col justify-between group">
                <div>
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-[11px] font-black uppercase tracking-wider text-emerald-200 truncate">
                            TA Siswa Baru
                        </span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-white/15 text-emerald-100 border border-white/20">
                            PPDB
                        </span>
                    </div>
                    <div class="text-3xl sm:text-4xl font-black text-white tracking-tight mt-1.5">
                        {{ optional($ta_ppdb)->tahun_ajaran ?? '-' }}
                    </div>
                </div>
                <div class="mt-3.5 pt-2 flex items-center justify-between text-xs text-emerald-200/90">
                    <span class="font-medium text-[11px] flex items-center gap-1">
                        <i class="ti ti-user-plus text-xs opacity-70"></i>
                        <span>Kenaikan Kelas</span>
                    </span>
                    <span class="font-black text-white text-[10px] bg-white/15 px-2 py-0.5 rounded-md">
                        Siswa Baru
                    </span>
                </div>
            </div>

            <!-- Tapered Vertical Divider Line -->
            <div class="hidden sm:block w-[1px] bg-gradient-to-b from-transparent via-white/35 to-transparent self-center h-16 shrink-0"></div>

            <!-- Segment 4: Unit Terdaftar -->
            <div class="flex-1 min-w-[140px] sm:min-w-[160px] px-3 sm:px-4 flex flex-col justify-between group">
                <div>
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-[11px] font-black uppercase tracking-wider text-emerald-200 truncate">
                            Unit Terdaftar
                        </span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-white/15 text-emerald-100 border border-white/20">
                            Jenjang
                        </span>
                    </div>
                    <div class="text-3xl sm:text-4xl font-black text-white tracking-tight mt-1.5">
                        {{ count($unit) }}
                    </div>
                </div>
                <div class="mt-3.5 pt-2 flex items-center justify-between text-xs text-emerald-200/90">
                    <span class="font-medium text-[11px] flex items-center gap-1">
                        <i class="ti ti-building-community text-xs opacity-70"></i>
                        <span>Modul Keuangan</span>
                    </span>
                    <span class="font-black text-white text-[10px] bg-white/15 px-2 py-0.5 rounded-md">
                        SPP &amp; Biaya
                    </span>
                </div>
            </div>

        </div>
    </div>

    <!-- ================= 3. FILTER & SEARCH TOOLBAR ================= -->
    <form action="{{ route('pembayaranpendidikan.index') }}" method="GET" class="w-full">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-2.5 sm:gap-3 w-full items-center">
            <!-- Search Name -->
            <div class="relative">
                <i class="ti ti-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base pointer-events-none"></i>
                <input type="text" name="nama_lengkap" value="{{ Request('nama_lengkap') }}" placeholder="Cari Siswa / NIS..." class="w-full pl-9 pr-3.5 py-2.5 text-xs sm:text-sm bg-white border border-slate-300/90 rounded-lg text-slate-700 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition placeholder-slate-400">
            </div>

            <!-- Unit -->
            <div class="relative">
                <i class="ti ti-building-community absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base pointer-events-none"></i>
                <select name="kode_unit" id="kode_unit_search" class="w-full pl-9 pr-8 py-2.5 text-xs sm:text-sm bg-white border border-slate-300/90 rounded-lg text-slate-700 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                    <option value="">Semua Unit</option>
                    @foreach ($unit as $d)
                        <option value="{{ $d->kode_unit }}" {{ Request('kode_unit') == $d->kode_unit ? 'selected' : '' }}>
                            {{ $d->nama_unit }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Tingkat -->
            <div class="relative">
                <i class="ti ti-chart-bar absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base pointer-events-none"></i>
                <select name="tingkat" id="tingkat" class="w-full pl-9 pr-8 py-2.5 text-xs sm:text-sm bg-white border border-slate-300/90 rounded-lg text-slate-700 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                    <option value="">Semua Tingkat</option>
                </select>
            </div>

            <!-- Asrama / Reguler -->
            <div class="relative">
                <i class="ti ti-home-check absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base pointer-events-none"></i>
                <select name="asrama" id="asrama" class="w-full pl-9 pr-8 py-2.5 text-xs sm:text-sm bg-white border border-slate-300/90 rounded-lg text-slate-700 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                    <option value="">Semua Tipe</option>
                    <option value="1" {{ Request('asrama') == '1' ? 'selected' : '' }}>Asrama</option>
                    <option value="0" {{ Request('asrama') == '0' ? 'selected' : '' }}>Reguler / Non-Asrama</option>
                </select>
            </div>

            <!-- Tahun Ajaran -->
            <div class="relative">
                <i class="ti ti-calendar-event absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base pointer-events-none"></i>
                <select name="kode_ta" id="kode_ta_search" class="w-full pl-9 pr-8 py-2.5 text-xs sm:text-sm bg-white border border-slate-300/90 rounded-lg text-slate-700 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                    <option value="">Semua TA</option>
                    @foreach ($tahunajaran as $d)
                        <option value="{{ $d->kode_ta }}"
                            @if (!empty(Request('kode_ta'))) @if (Request('kode_ta') == $d->kode_ta) selected @endif
                            @else @if ($kode_ta == $d->kode_ta) selected @endif
                            @endif
                        >
                            {{ $d->tahun_ajaran }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Submit & Reset Buttons -->
            <div class="flex items-center gap-2">
                <button type="submit" class="flex-1 py-2.5 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs sm:text-sm rounded-lg shadow-xs transition inline-flex items-center justify-center gap-1.5 cursor-pointer active:scale-95 whitespace-nowrap">
                    <i class="ti ti-search text-base"></i>
                    <span>Cari</span>
                </button>
                <a href="{{ route('pembayaranpendidikan.index') }}" class="py-2.5 px-3 bg-white hover:bg-slate-100 text-slate-600 border border-slate-300/90 rounded-lg font-semibold text-sm transition inline-flex items-center justify-center shrink-0 shadow-xs" title="Reset Filter">
                    <i class="ti ti-refresh text-base"></i>
                </a>
            </div>
        </div>
    </form>

    <!-- Success & Error Alerts -->
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

    <!-- ================= 4. MAIN DATA TABLE CONTAINER ================= -->
    <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
        <!-- Solid Green Table Header -->
        <div class="px-5 pt-4 pb-3 bg-emerald-600 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-white">
            <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-lg bg-white/20 text-white flex items-center justify-center text-xs font-bold border border-white/20 shadow-2xs">
                    <i class="ti ti-list-check"></i>
                </div>
                <h3 class="text-sm font-extrabold text-white tracking-tight">Data Siswa &amp; Status Pembayaran</h3>
                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-white/20 text-white border border-white/30 shadow-2xs">
                    TA: {{ $tahun_ajaran->tahun_ajaran ?? '-' }}
                </span>
            </div>

            @php
                $anyCanPromote = false;
                foreach ($pendaftaran as $d) {
                    if ($d->kode_ta != optional($ta_ppdb)->kode_ta && $d->status_naik_kelas != 1 && $d->status_siswa == 1) {
                        $anyCanPromote = true;
                        break;
                    }
                }
            @endphp
            @if ($anyCanPromote)
                <button type="button" id="btnBulkNaikKelas" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-amber-400 hover:bg-amber-300 text-slate-900 font-bold rounded-lg text-xs shadow-xs transition active:scale-95 cursor-pointer">
                    <i class="ti ti-arrow-up text-sm"></i>
                    <span>Naik Kelas Massal</span>
                </button>
            @endif
        </div>

        <style>
            .table-sticky {
                border-collapse: separate;
                border-spacing: 0;
            }
            .table-sticky thead tr {
                background-color: #059669;
            }
            .table-sticky thead th {
                background-color: #059669 !important;
                color: #ffffff !important;
            }
            .table-sticky td.sticky-col-left-1,
            .table-sticky td.sticky-col-left-2,
            .table-sticky td.sticky-col-left-3,
            .table-sticky td.sticky-col-left-4,
            .table-sticky td.sticky-col-left-5,
            .table-sticky td.sticky-col-left-6 {
                background-color: #ffffff;
            }
            .table-sticky tr:nth-child(even) td.sticky-col-left-1,
            .table-sticky tr:nth-child(even) td.sticky-col-left-2,
            .table-sticky tr:nth-child(even) td.sticky-col-left-3,
            .table-sticky tr:nth-child(even) td.sticky-col-left-4,
            .table-sticky tr:nth-child(even) td.sticky-col-left-5,
            .table-sticky tr:nth-child(even) td.sticky-col-left-6 {
                background-color: #f8fafc;
            }
            .table-sticky td.sticky-col-right {
                background-color: #ffffff;
            }
            .table-sticky tr:nth-child(even) td.sticky-col-right {
                background-color: #f8fafc;
            }
            .table-sticky tbody tr:hover td,
            .table-sticky tbody tr:hover td.sticky-col-left-1,
            .table-sticky tbody tr:hover td.sticky-col-left-2,
            .table-sticky tbody tr:hover td.sticky-col-left-3,
            .table-sticky tbody tr:hover td.sticky-col-left-4,
            .table-sticky tbody tr:hover td.sticky-col-left-5,
            .table-sticky tbody tr:hover td.sticky-col-left-6,
            .table-sticky tbody tr:hover td.sticky-col-right {
                background-color: #ecfdf5 !important;
            }
            .table-sticky tr.row-danger td,
            .table-sticky tr.row-danger td.sticky-col-left-1,
            .table-sticky tr.row-danger td.sticky-col-left-2,
            .table-sticky tr.row-danger td.sticky-col-left-3,
            .table-sticky tr.row-danger td.sticky-col-left-4,
            .table-sticky tr.row-danger td.sticky-col-left-5,
            .table-sticky tr.row-danger td.sticky-col-left-6,
            .table-sticky tr.row-danger td.sticky-col-right {
                background-color: #fff1f2 !important;
            }
            .table-sticky tr.row-danger:hover td,
            .table-sticky tr.row-danger:hover td.sticky-col-left-1,
            .table-sticky tr.row-danger:hover td.sticky-col-left-2,
            .table-sticky tr.row-danger:hover td.sticky-col-left-3,
            .table-sticky tr.row-danger:hover td.sticky-col-left-4,
            .table-sticky tr.row-danger:hover td.sticky-col-left-5,
            .table-sticky tr.row-danger:hover td.sticky-col-left-6,
            .table-sticky tr.row-danger:hover td.sticky-col-right {
                background-color: #ffe4e6 !important;
            }
            .sticky-col-left-1 { position: sticky; left: 0; z-index: 2; width: 44px; min-width: 44px; max-width: 44px; }
            .sticky-col-left-2 { position: sticky; left: 44px; z-index: 2; width: 44px; min-width: 44px; max-width: 44px; }
            .sticky-col-left-3 { position: sticky; left: 88px; z-index: 2; width: 135px; min-width: 135px; max-width: 135px; }
            .sticky-col-left-4 { position: sticky; left: 223px; z-index: 2; width: 85px; min-width: 85px; max-width: 85px; }
            .sticky-col-left-5 { position: sticky; left: 308px; z-index: 2; width: 90px; min-width: 90px; max-width: 90px; }
            .sticky-col-left-6 { position: sticky; left: 398px; z-index: 2; width: 220px; min-width: 220px; max-width: 220px; box-shadow: 2px 0 5px -2px rgba(0,0,0,0.06); }
            .sticky-col-right { position: sticky; right: 0; z-index: 2; width: 110px; min-width: 110px; max-width: 110px; box-shadow: -2px 0 5px -2px rgba(0,0,0,0.06); }
            .table-sticky thead th.sticky-col-left-1,
            .table-sticky thead th.sticky-col-left-2,
            .table-sticky thead th.sticky-col-left-3,
            .table-sticky thead th.sticky-col-left-4,
            .table-sticky thead th.sticky-col-left-5,
            .table-sticky thead th.sticky-col-left-6,
            .table-sticky thead th.sticky-col-right {
                z-index: 3;
            }
        </style>

        <div class="overflow-x-auto bg-emerald-600">
            <form action="{{ route('pembayaranpendidikan.bulknaikkelas') }}" method="POST" id="formBulkNaikKelas">
                @csrf
                <table class="w-full text-left text-xs border-0 border-collapse table-sticky">
                    <thead class="bg-emerald-600 text-white font-bold uppercase tracking-wider text-[11px] border-0 border-b border-emerald-700/80">
                        <tr>
                            <th class="py-2 px-3 text-center sticky-col-left-1 text-white">
                                <input type="checkbox" id="checkAll" class="w-3.5 h-3.5 rounded text-emerald-600 focus:ring-emerald-500 cursor-pointer accent-emerald-600">
                            </th>
                            <th class="py-2 px-3 text-center sticky-col-left-2 text-white">NO.</th>
                            <th class="py-2 px-3 sticky-col-left-3 text-white">NO. DAFTAR</th>
                            <th class="py-2 px-3 sticky-col-left-4 text-white">ID SISWA</th>
                            <th class="py-2 px-3 sticky-col-left-5 text-white">NIS</th>
                            <th class="py-2 px-3 sticky-col-left-6 text-white">NAMA LENGKAP</th>
                            <th class="py-2 px-3 text-white">TIPE BIAYA</th>
                            <th class="py-2 px-3 text-white">UNIT</th>
                            <th class="py-2 px-3 text-center text-white">TNGKT</th>
                            <th class="py-2 px-3 text-white">KELAS</th>
                            <th class="py-2 px-3 text-center text-white">STATUS</th>
                            <th class="py-2 px-3 text-end sticky-col-right text-white">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white text-slate-700 font-medium">
                        @forelse ($pendaftaran as $d)
                            <tr class="odd:bg-white even:bg-slate-50/40 hover:bg-emerald-50/50 transition-colors @if(in_array($d->status_siswa, [3, 4, 5])) row-danger @endif">
                                <td class="py-2 px-3 text-center sticky-col-left-1">
                                    @if ($d->kode_ta != optional($ta_ppdb)->kode_ta && $d->status_naik_kelas != 1 && $d->status_siswa == 1)
                                        <input type="checkbox" name="no_pendaftaran[]" value="{{ $d->no_pendaftaran }}" class="checkItem w-3.5 h-3.5 rounded text-emerald-600 focus:ring-emerald-500 cursor-pointer accent-emerald-600">
                                    @elseif($d->status_naik_kelas == 1)
                                        <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold" title="Sudah Naik Kelas">
                                            <i class="ti ti-arrow-up"></i>
                                        </span>
                                    @endif
                                </td>
                                <td class="py-2 px-3 text-center text-slate-400 font-bold sticky-col-left-2">
                                    {{ $loop->iteration + ($pendaftaran->currentPage() - 1) * $pendaftaran->perPage() }}
                                </td>
                                <td class="py-2 px-3 font-mono font-bold text-slate-800 sticky-col-left-3 whitespace-nowrap">
                                    {{ $d->no_pendaftaran }}
                                </td>
                                <td class="py-2 px-3 font-mono text-slate-500 sticky-col-left-4 whitespace-nowrap">
                                    {{ $d->id_siswa }}
                                </td>
                                <td class="py-2 px-3 font-mono font-bold text-slate-800 sticky-col-left-5 whitespace-nowrap">
                                    {{ $d->nis ?? '-' }}
                                </td>
                                <td class="py-2 px-3 sticky-col-left-6">
                                    <span class="font-bold text-slate-900 block truncate max-w-[200px]" title="{{ $d->nama_lengkap }}">{{ $d->nama_lengkap }}</span>
                                </td>
                                <td class="py-2 px-3 whitespace-nowrap">
                                    @if($d->asrama == 1)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-200/70">
                                            Asrama {{ $d->is_pindahan == 1 ? '(Pindahan)' : '' }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/70">
                                            Reguler {{ $d->is_pindahan == 1 ? '(Pindahan)' : '' }}
                                        </span>
                                    @endif
                                </td>
                                <td class="py-2 px-3 whitespace-nowrap font-medium text-slate-700">
                                    {{ $d->nama_unit }}
                                </td>
                                <td class="py-2 px-3 text-center whitespace-nowrap">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-bold bg-slate-100 text-slate-700 border border-slate-200/60">
                                        {{ $d->tingkat }}
                                    </span>
                                </td>
                                <td class="py-2 px-3 whitespace-nowrap">
                                    @if (!empty($d->nama_kelas))
                                        <span class="font-semibold text-slate-800">{{ $d->nama_kelas }}</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-bold bg-amber-50 text-amber-700 border border-amber-200/70">
                                            Belum diploting
                                        </span>
                                    @endif
                                </td>
                                <td class="py-2 px-3 text-center whitespace-nowrap">
                                    @if($d->status_siswa == 1)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/70">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                                        </span>
                                    @elseif($d->status_siswa == 2)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-sky-50 text-sky-700 border border-sky-200/70">
                                            <span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span> Lulus / Naik
                                        </span>
                                    @elseif($d->status_siswa == 3)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-rose-50 text-rose-700 border border-rose-200/70" title="Alasan: {{ $d->alasan_keluar }}">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Mengundurkan Diri
                                        </span>
                                    @elseif($d->status_siswa == 4)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-rose-50 text-rose-700 border border-rose-200/70" title="Alasan: {{ $d->alasan_keluar }}">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Pindah
                                        </span>
                                    @elseif($d->status_siswa == 5)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-rose-50 text-rose-700 border border-rose-200/70" title="Alasan: {{ $d->alasan_keluar }}">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Dikeluarkan
                                        </span>
                                    @endif
                                </td>
                                <td class="py-2 px-3 text-end sticky-col-right">
                                    <div class="inline-flex items-center gap-1 justify-end">
                                        @can('pembayaranpdd.show')
                                            <a href="#" class="btnShow w-6.5 h-6.5 rounded-md bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200/80 flex items-center justify-center text-xs transition cursor-pointer"
                                                no_pendaftaran="{{ Crypt::encrypt($d->no_pendaftaran) }}"
                                                title="Pembayaran SPP & Tagihan">
                                                <i class="ti ti-wallet text-xs"></i>
                                            </a>
                                        @endcan
                                        @if ($d->kode_ta != optional($ta_ppdb)->kode_ta)
                                            @if ($d->status_naik_kelas == 1)
                                                <a href="{{ route('pembayaranpendidikan.batalkannaikkelas', Crypt::encrypt($d->no_pendaftaran)) }}"
                                                    class="w-6.5 h-6.5 rounded-md bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200/80 flex items-center justify-center text-xs transition"
                                                    onclick="return confirm('Apakah Anda yakin ingin membatalkan kenaikan kelas ini?')"
                                                    title="Batalkan Kenaikan Kelas">
                                                    <i class="ti ti-arrow-back-up text-xs"></i>
                                                </a>
                                            @else
                                                <a href="#"
                                                    class="btnNaikKelasTrigger w-6.5 h-6.5 rounded-md bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200/80 flex items-center justify-center text-xs transition cursor-pointer"
                                                    no_pendaftaran="{{ Crypt::encrypt($d->no_pendaftaran) }}"
                                                    title="Proses Naik Kelas">
                                                    <i class="ti ti-arrow-up text-xs"></i>
                                                </a>
                                            @endif
                                        @endif

                                        {{-- Tombol Aksi Keluar --}}
                                        @if($d->status_siswa == 1)
                                            <a href="#" class="btnProsesKeluarTabel w-6.5 h-6.5 rounded-md bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200/80 flex items-center justify-center text-xs transition cursor-pointer"
                                                no_pendaftaran="{{ Crypt::encrypt($d->no_pendaftaran) }}"
                                                title="Proses Siswa Keluar">
                                                <i class="ti ti-user-x text-xs"></i>
                                            </a>
                                        @elseif(in_array($d->status_siswa, [3, 4, 5]))
                                            <form action="{{ route('pembayaranpendidikan.batalkankeluar', Crypt::encrypt($d->no_pendaftaran)) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan status keluar siswa ini?')">
                                                @csrf
                                                <button type="submit" class="w-6.5 h-6.5 rounded-md bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200/80 flex items-center justify-center text-xs transition cursor-pointer"
                                                    title="Batalkan Keluar">
                                                    <i class="ti ti-rotate-clockwise text-xs"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12" class="text-center py-10">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 mb-1.5">
                                            <i class="ti ti-receipt-off text-xl"></i>
                                        </div>
                                        <p class="text-xs font-bold text-slate-700">Tidak ada data siswa ditemukan</p>
                                        <p class="text-[11px] text-slate-400 mt-0.5">Silakan sesuaikan filter pencarian, unit, atau tahun ajaran di atas.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </form>
        </div>

        <!-- Pagination Footer -->
        <div class="p-4 bg-white border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <span class="text-xs text-slate-500 font-medium">
                Menampilkan <strong>{{ $pendaftaran->firstItem() ?? 0 }}</strong> - <strong>{{ $pendaftaran->lastItem() ?? 0 }}</strong> dari <strong>{{ $pendaftaran->total() }}</strong> siswa
            </span>
            <div>
                {{ $pendaftaran->appends(request()->all())->links('vendor.pagination.custom-tailwind') }}
            </div>
        </div>
    </div>
</div>

<x-modal-form id="modal" size="modal-xl" show="loadmodal" title="" />
<x-modal-form id="modalpotongan" size="" show="loadmodalpotongan" title="" />
<x-modal-form id="modalmutasi" size="" show="loadmodalmutasi" title="" />
<x-modal-form id="modalrencanaspp" size="modal-lg" show="loadmodalrencanaspp" title="" />
<x-modal-form id="modaleditrencanaspp" size="modal-lg" show="loadeditrencanaspp" title="" />
<x-modal-form id="modalpembayaran" size="modal-xl" show="loadmodalpembayaran" title="" />
<x-modal-form id="modalDetailbayar" size="modal-xl" show="loaddetailbayar" title="" />
<x-modal-form id="modaleditbiaya" size="modal-lg" show="loadeditbiaya" title="" />

<!-- Modal Proses Keluar Tabel -->
<div class="modal fade" id="modalProsesKeluarTabel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border border-slate-200/90 shadow-2xl rounded-2xl bg-white overflow-hidden">
            <!-- Modal Header (Clean White / Rose Icon) -->
            <div class="px-6 py-4 bg-white border-b border-slate-200/90 flex items-center justify-between text-slate-900">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 border border-rose-100 flex items-center justify-center text-base shrink-0 font-bold">
                        <i class="ti ti-user-x"></i>
                    </div>
                    <h5 class="modal-title text-base font-bold text-slate-900 tracking-tight truncate mb-0">Proses Siswa Keluar</h5>
                </div>
                <button type="button" class="w-8 h-8 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 flex items-center justify-center transition-colors cursor-pointer shrink-0" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti ti-x text-lg"></i>
                </button>
            </div>

            <form action="" method="POST" id="formProsesKeluarTabel" class="p-6 space-y-4">
                @csrf
                <!-- Status Siswa Baru -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                        <i class="ti ti-user-exclamation text-sm text-slate-400"></i>
                        <span>Status Siswa Baru <span class="text-rose-500 font-bold">*</span></span>
                    </label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                            <i class="ti ti-user-exclamation text-base"></i>
                        </div>
                        <select name="status_siswa" class="w-full pl-9 pr-8 py-2.5 text-sm font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-rose-500/20 focus:border-rose-600 transition cursor-pointer" required>
                            <option value="3">Mengundurkan Diri</option>
                            <option value="4">Pindah Sekolah</option>
                            <option value="5">Dikeluarkan</option>
                        </select>
                    </div>
                </div>

                <!-- Tanggal Keluar -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                        <i class="ti ti-calendar text-sm text-slate-400"></i>
                        <span>Tanggal Keluar <span class="text-rose-500 font-bold">*</span></span>
                    </label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                            <i class="ti ti-calendar text-base"></i>
                        </div>
                        <input type="text" name="tanggal_keluar" id="tanggal_keluar" class="flatpickr-date w-full pl-9 pr-3.5 py-2.5 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-xl placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-rose-500/20 focus:border-rose-600 transition" value="{{ date('Y-m-d') }}" required placeholder="Pilih Tanggal...">
                    </div>
                </div>

                <!-- Alasan Keluar -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                        <i class="ti ti-notes text-sm text-slate-400"></i>
                        <span>Alasan Keluar <span class="text-rose-500 font-bold">*</span></span>
                    </label>
                    <textarea name="alasan_keluar" rows="3" required placeholder="Tuliskan alasan detail siswa keluar..." class="w-full px-3.5 py-2.5 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-xl placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-rose-500/20 focus:border-rose-600 transition"></textarea>
                </div>

                <!-- Footer Actions -->
                <div class="pt-4 border-t border-slate-100 flex flex-col-reverse sm:flex-row sm:items-center justify-end gap-2.5">
                    <button type="button" class="w-full sm:w-auto px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer active:scale-95" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="w-full sm:w-auto px-6 py-2.5 bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center justify-center gap-2 cursor-pointer active:scale-95">
                        <i class="ti ti-device-floppy text-base"></i>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Pilihan Biaya Naik Kelas -->
<div class="modal fade" id="modalPilihanBiayaNaikKelas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-2xl border-0 shadow-xl overflow-hidden">
            <div class="bg-emerald-600 px-5 py-4 text-white flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i class="ti ti-arrow-up text-lg"></i>
                    <h5 class="modal-title font-bold text-sm text-white">Pilih Konfigurasi Biaya Tingkat Baru</h5>
                </div>
                <button type="button" class="btn-close btn-close-white text-white/80 hover:text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="p-5 space-y-4">
                <div class="p-3.5 bg-emerald-50 border border-emerald-200 rounded-xl text-xs text-emerald-900 flex items-start gap-2.5">
                    <i class="ti ti-info-circle text-emerald-600 text-base shrink-0 mt-0.5"></i>
                    <div>
                        Siswa <strong id="naik-kelas-nama-siswa">Siswa</strong> akan dinaikkan ke <strong>Tingkat <span id="naik-kelas-tingkat-baru">X</span></strong>. 
                        Silakan pilih salah satu opsi konfigurasi biaya di bawah untuk melanjutkan.
                    </div>
                </div>
                <div class="row g-3" id="container-pilihan-biaya">
                    <!-- Cards will be loaded here via Ajax -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('myscript')
<script>
    $(function() {
        let currentNaikKelasNoPendaftaran = '';

        // Handle Klik Tombol Naik Kelas (Cek Biaya)
        $(document).on('click', '.btnNaikKelasTrigger', function(e) {
            e.preventDefault();
            var no_pendaftaran = $(this).attr('no_pendaftaran');
            currentNaikKelasNoPendaftaran = no_pendaftaran;

            Swal.fire({
                title: 'Loading...',
                text: 'Memeriksa konfigurasi biaya...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: `/pembayaranpendidikan/${no_pendaftaran}/cekbiayanext`,
                type: 'GET',
                success: function(response) {
                    Swal.close();
                    if (response.success) {
                        if (response.count === 1) {
                            // If only 1 biaya exists, ask for simple confirmation and process
                            Swal.fire({
                                title: 'Konfirmasi',
                                text: `Yakin ingin menaikkan ${response.nama_siswa} ke tingkat ${response.tingkat_baru}?`,
                                icon: 'question',
                                showCancelButton: true,
                                confirmButtonColor: '#064e3b',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Ya, Proses!'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Actually, let's extract code_biaya from button in response.html or we can call the original route.
                                    window.location.href = `/pembayaranpendidikan/${no_pendaftaran}/prosesnaikkelas`;
                                }
                            });
                        } else {
                            // If multiple biaya exist, show the modal with cards
                            $('#naik-kelas-nama-siswa').text(response.nama_siswa);
                            $('#naik-kelas-tingkat-baru').text(response.tingkat_baru);
                            $('#container-pilihan-biaya').html(response.html);
                            $('#modalPilihanBiayaNaikKelas').modal('show');
                        }
                    }
                },
                error: function(xhr) {
                    Swal.close();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON ? xhr.responseJSON.message : 'Gagal memproses data.'
                    });
                }
            });
        });

        // Handle Pemilihan Biaya pada Card
        $(document).on('click', '.btnPilihBiayaNaikKelas', function(e) {
            e.preventDefault();
            var kode_biaya = $(this).data('kode-biaya');

            Swal.fire({
                title: 'Sedang diproses...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: `/pembayaranpendidikan/${currentNaikKelasNoPendaftaran}/simpannaikkelas`,
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    kode_biaya: kode_biaya
                },
                success: function(response) {
                    Swal.close();
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                        }).then(() => {
                            $('#modalPilihanBiayaNaikKelas').modal('hide');
                            window.location.reload();
                        });
                    }
                },
                error: function(xhr) {
                    Swal.close();
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: xhr.responseJSON ? xhr.responseJSON.message : 'Terjadi kesalahan sistem.'
                    });
                }
            });
        });

        // Initialize flatpickr on date field
        $(".flatpickr-date").flatpickr({
            altInput: true,
            altFormat: "d F Y",
            dateFormat: "Y-m-d",
            defaultDate: "today"
        });

        $(document).on('click', '.btnProsesKeluarTabel', function(e) {
            e.preventDefault();
            var no_pendaftaran = $(this).attr('no_pendaftaran');
            $('#formProsesKeluarTabel').attr('action', `/pembayaranpendidikan/${no_pendaftaran}/proses-keluar`);
            $('#modalProsesKeluarTabel').modal('show');
        });

        // Multi-modal stacking & backdrop handler
        $(document).on('show.bs.modal', '.modal', function() {
            const numOpen = $('.modal.show').not(this).length;
            const modalZIndex = 1060 + (20 * numOpen);
            $(this).css('z-index', modalZIndex);
        });

        $(document).on('shown.bs.modal', '.modal', function() {
            // Re-assign z-index so backdrops layer precisely between modals
            $('.modal-backdrop').each(function(index) {
                $(this).css('z-index', 1050 + (20 * index));
            });
            $('.modal.show').each(function(index) {
                $(this).css('z-index', 1060 + (20 * index));
            });
        });

        $(document).on('hidden.bs.modal', '.modal', function() {
            if ($('.modal.show').length > 0) {
                $('body').addClass('modal-open');
                $('.modal-backdrop').each(function(index) {
                    $(this).css('z-index', 1050 + (20 * index));
                });
                $('.modal.show').each(function(index) {
                    $(this).css('z-index', 1060 + (20 * index));
                });
            }
        });

        const loading = `<div class="sk-wave sk-primary" style="margin:auto">
            <div class="sk-wave-rect"></div>
            <div class="sk-wave-rect"></div>
            <div class="sk-wave-rect"></div>
            <div class="sk-wave-rect"></div>
            <div class="sk-wave-rect"></div>
            </div>`;


        $('.btnShow').click(function(e) {
            e.preventDefault();
            var no_pendaftaran = $(this).attr('no_pendaftaran');
            $("#modal").modal("show");
            $("#modal").find("#loadmodal").html(loading);
            $.ajax({
                url: `/pembayaranpendidikan/${no_pendaftaran}/show`,
                type: 'GET',
                success: function(response) {
                    $('#loadmodal').html(response);
                    getbiaya(no_pendaftaran);
                    getrencanaspp(no_pendaftaran);
                    gethistoribayar(no_pendaftaran);
                },
                error: function(error) {
                    console.error('Error loading modal content', error);
                }
            });
        });

        // Tab Switching Delegation for Modal
        $(document).on('click', '.custom-pembayaran-tabs .tab-btn, .custom-pembayaran-tabs .nav-link', function(e) {
            e.preventDefault();
            var target = $(this).attr('data-target') || $(this).attr('data-bs-target');
            if (!target) return;

            // Activate current tab button
            $(this).closest('.custom-pembayaran-tabs').find('.tab-btn, .nav-link').removeClass('active').attr('aria-selected', 'false');
            $(this).addClass('active').attr('aria-selected', 'true');

            // Switch active pane
            var container = $(this).closest('.nav-pembayaran-container');
            if (container.length) {
                container.find('.custom-tab-content > .tab-pane').removeClass('active').css('display', 'none');
                container.find('.custom-tab-content > ' + target).addClass('active').css('display', 'block');
            } else {
                $('.tab-content .tab-pane').removeClass('show active').css('display', 'none');
                $(target).addClass('show active').css('display', 'block');
            }
        });



        function getbiaya(no_pendaftaran) {
            // $(document).find(".tabelbiaya").html(`<tr>
            //     <td colspan="12" class="text-center">
            //         Loading...
            //     </td>
            // </tr>`);
            $.ajax({
                type: 'GET',
                url: `/pembayaranpendidikan/${no_pendaftaran}/getbiaya`,
                cache: false,
                success: function(res) {
                    $(document).find(".tabelbiaya").html(res);
                }
            });
        }

        $(document).on('click', '.inputpotongan', function(e) {
            const no_pendaftaran = $(this).attr('no_pendaftaran');
            const kode_biaya = $(this).attr('kode_biaya');
            const kode_jenis_biaya = $(this).attr('kode_jenis_biaya');
            const jenis_biaya = $(this).attr('jenis_biaya');
            // alert(no_pendaftaran);
            $("#modalpotongan").modal("show");
            $("#modalpotongan").find("#loadmodalpotongan").html(loading);
            $("#modalpotongan").find(".modal-title").text("Input Potongan Biaya " + jenis_biaya);
            $("#loadmodalpotongan").load(
                `/pembayaranpendidikan/${no_pendaftaran}/${kode_jenis_biaya}/${kode_biaya}/inputpotongan`
            );
        });


        $(document).on('submit', '#formPotongan', function(e) {
            e.preventDefault();
            const data = $(this).serialize();
            const potongan = $(this).find("#potongan").val();
            const keterangan = $(this).find("#keterangan").val();

            if (potongan == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Potongan tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#potongan").focus();
                    }
                });
                return false;
            } else if (keterangan == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Keterangan tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#keterangan").focus();
                    }
                });
                return false;
            } else {
                $(this).find('button[type="submit"]').prop('disabled', true);
                $(this).find('button[type="submit"]').html(
                    '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Loading...'
                );

                $.ajax({
                    url: "{{ route('pembayaranpendidikan.storepotongan') }}",
                    type: "POST",
                    data: data,
                    cache: false,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                        });
                        getbiaya(response.no_pendaftaran);
                        $("#modalpotongan").modal("hide");
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: "Error!",
                            text: xhr.responseJSON.message,
                            icon: "error",
                            showConfirmButton: true,
                            didClose: (e) => {
                                $(document).find('#formPotongan').find(
                                    'button[type="submit"]').prop(
                                    'disabled', false);
                                $(document).find('#formPotongan').find(
                                    'button[type="submit"]').html(
                                    '<i class="ti ti-send me-2"></i> Submit'
                                );
                            }
                        });


                    }

                });
            }
        });


        $(document).on('click', '.inputmutasi', function(e) {
            const no_pendaftaran = $(this).attr('no_pendaftaran');
            const kode_jenis_biaya = $(this).attr('kode_jenis_biaya');
            const jenis_biaya = $(this).attr('jenis_biaya');
            const kode_biaya = $(this).attr('kode_biaya');
            // alert(no_pendaftaran);
            $("#modalmutasi").modal("show");
            $("#modalmutasi").find("#loadmodalmutasi").html(loading);
            $("#modalmutasi").find(".modal-title").text("Input Mutasi Biaya " + jenis_biaya);
            $("#loadmodalmutasi").load(
                `/pembayaranpendidikan/${no_pendaftaran}/${kode_jenis_biaya}/${kode_biaya}/inputmutasi`
            );
        });


        $(document).on('submit', '#formMutasi', function(e) {
            e.preventDefault();
            const data = $(this).serialize();
            const jumlah = $(this).find("#jumlah").val();
            const keterangan = $(this).find("#keterangan").val();

            if (jumlah == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Jumlah Mutasi tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#jumlah").focus();
                    }
                });
                return false;
            } else if (keterangan == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Keterangan tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#keterangan").focus();
                    }
                });
                return false;
            } else {
                $(this).find('button[type="submit"]').prop('disabled', true);
                $(this).find('button[type="submit"]').html(
                    '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Loading...'
                );

                $.ajax({
                    url: "{{ route('pembayaranpendidikan.storemutasi') }}",
                    type: "POST",
                    data: data,
                    cache: false,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                        });
                        getbiaya(response.no_pendaftaran);
                        $("#modalmutasi").modal("hide");
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: "Error!",
                            text: xhr.responseJSON.message,
                            icon: "error",
                            showConfirmButton: true,
                            didClose: (e) => {
                                $(document).find('#formMutasi').find(
                                    'button[type="submit"]').prop(
                                    'disabled', false);
                                $(document).find('#formMutasi').find(
                                    'button[type="submit"]').html(
                                    '<i class="ti ti-send me-2"></i> Submit'
                                );
                            }
                        });


                    }

                });
            }
        });


        $(document).on('click', '#buatrencanaspp', function(e) {
            e.preventDefault();
            const no_pendaftaran = $(this).attr('no_pendaftaran');
            $("#modalrencanaspp").modal("show");
            $("#modalrencanaspp").find("#loadmodalrencanaspp").html(loading);
            $("#modalrencanaspp").find(".modal-title").text("Buat Rencana SPP");
            $("#loadmodalrencanaspp").load(`/rencanaspp/${no_pendaftaran}/create`);
        });


        $(document).on('click', '#btnBayar', function(e) {
            e.preventDefault();
            const no_pendaftaran = $(this).attr('no_pendaftaran');
            $("#modalpembayaran").modal("show");
            $("#modalpembayaran").find("#loadmodalpembayaran").html(loading);
            $("#modalpembayaran").find(".modal-title").text("Pembayaran");
            $("#loadmodalpembayaran").load(`/pembayaranpendidikan/${no_pendaftaran}/create`);

        });

        function toNumber(value) {
            let cleanValue = value.replace(/\./g, '');
            return cleanValue;
        }


        $(document).on('submit', '#formBuatrencanaspp', function(e) {
            e.preventDefault();
            let kode_biaya = $(this).find("#kode_biaya").val();
            let mulai_pembayaran = $(this).find("#mulai_pembayaran").val();
            let jumlah_spp = toNumber($(this).find("#jumlah_spp").val());
            let jumlah_spp_perbulan = $(this).find("#jumlah_spp_perbulan").val();
            let jumlah_bulan = $(this).find("#jumlah_bulan").val();

            let no_pendaftaran = $(this).find("#no_pendaftaran").val();

            if (kode_biaya == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Tahun Ajaran Harus Dipilih!',
                    didClose: (e) => {
                        $(this).find("#kode_biaya").focus();
                    }
                });
                return false;
            } else if (mulai_pembayaran == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Mulai Pembayaran tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#mulai_pembayaran").focus();
                    }
                });
                return false;
            } else if (jumlah_spp_perbulan == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Jumlah SPP Perbulan tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#jumlah_spp_perbulan").focus();
                    }
                });
                return false;
            } else {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('rencanaspp.store') }}",
                    data: $(this).serialize(),
                    cache: false,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                            didClose: (e) => {
                                getrencanaspp(response.no_pendaftaran);
                            }
                        });
                    },

                    error: function(xhr) {
                        Swal.fire({
                            title: "Error!",
                            text: xhr.responseJSON.message,
                            icon: "error",
                            showConfirmButton: true,
                            didClose: (e) => {

                            }
                        });
                    }
                });
            }
        });

        function getrencanaspp(no_pendaftaran) {
            $.ajax({
                type: 'GET',
                url: `/rencanaspp/${no_pendaftaran}/getrencanaspp`,
                cache: false,
                success: function(res) {
                    $(document).find("#tabelrencanaspp").html(res);
                }
            })
        }

        $(document).on('click', '.editrencanaspp', function(e) {
            e.preventDefault();
            let kode_rencana_spp = $(this).attr('kode_rencana_spp');
            $("#modalrencanaspp").modal("show");
            $("#modalrencanaspp").find("#loadmodalrencanaspp").html(loading);
            $("#modalrencanaspp").find(".modal-title").text("Edit Rencana SPP");
            $("#loadmodalrencanaspp").load(`/rencanaspp/${kode_rencana_spp}/edit`);
        });

        $(document).on('submit', '#formEditrencanaspp', function(e) {
            e.preventDefault();
            let tagihanspppertahun = $(this).find("#tagihanspppertahun").text().replace(/[^0-9]/g, '');
            let totalspppertahun = $(this).find("#totalspppertahun").text().replace(/[^0-9]/g, '');
            if (parseInt(tagihanspppertahun) != parseInt(totalspppertahun)) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Jumlah Pembayaran melebihi jumlah SPP pada Tahun Ajaran ini!',
                    didClose: (e) => {
                        $(this).find("#tagihanspppertahun").focus();
                    }
                });
                return false;
            } else {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('rencanaspp.update') }}",
                    data: $(this).serialize(),
                    cache: false,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                            didClose: (e) => {

                            }
                        });
                        $("#modalrencanaspp").modal("hide");
                        getrencanaspp(response.no_pendaftaran);
                    },

                    error: function(xhr) {
                        Swal.fire({
                            title: "Error!",
                            text: xhr.responseJSON.message,
                            icon: "error",
                            showConfirmButton: true,
                            didClose: (e) => {
                                $("#modalrencanaspp").modal("hide");
                            }
                        });
                    }
                });
            }
        });
        let no = 1;
        $(document).on('click', '#btnTambahdetailbayar', function(e) {
            let biaya = $(document).find("#formDetailbayar").find("#kode_biaya").val();
            let databiaya = biaya.split("|");
            let kode_biaya = databiaya[1];
            let kode_jenis_biaya = databiaya[0];
            let jenis_biaya = $(document).find("#formDetailbayar").find("#kode_biaya option:selected")
                .text();
            let jumlah = $(document).find("#formDetailbayar").find("#jumlah").val().replace(/[^0-9]/g,
                '');
            let keterangan = $(document).find("#formDetailbayar").find("#keterangan").val();
            let sisa_tagihan = $(document).find("#formDetailbayar").find("#sisa_tagihan").val().replace(
                /[^0-9]/g, '');

            if (biaya == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Biaya tidak boleh kosong!',
                    didClose: (e) => {
                        $(document).find("#formDetailbayar").find("#kode_biaya").focus();
                    }
                });
                return false;
            } else if (jumlah == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Jumlah tidak boleh kosong!',
                    didClose: (e) => {
                        $(document).find("#formDetailbayar").find("#jumlah").focus();
                    }
                });
                return false;
            } else if (parseInt(jumlah) > parseInt(sisa_tagihan)) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Jumlah melebihi sisa tagihan!',
                    didClose: (e) => {
                        $(document).find("#formDetailbayar").find("#jumlah").focus();
                    }
                });
                return false;
            } else if ($(document).find(`#index_${kode_biaya+kode_jenis_biaya}`).length > 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Data Sudah Ada!',
                    didClose: (e) => {
                        $(document).find("#formDetailbayar").find("#kode_biaya").focus();
                    }
                });
                return false;
            } else {
                let data = `<tr id="index_${kode_biaya+kode_jenis_biaya}" class="hover:bg-slate-50/60 transition-colors">
                    <td class="py-2 px-3.5 font-bold text-slate-800">${jenis_biaya}</td>
                    <td class='text-end py-2 px-3.5 font-mono font-bold text-emerald-700 jmlbayar'>${convertToRupiah(jumlah)}</td>
                    <td class="py-2 px-3.5 text-slate-600 text-xs">${keterangan || '-'}</td>
                    <td class="py-2 px-3.5 text-center">
                        <input type="hidden" name="kode_biaya[]" value="${kode_biaya}" />
                        <input type="hidden" name="kode_jenis_biaya[]" value="${kode_jenis_biaya}" />
                        <input type="hidden" name="keterangan[]" value="${keterangan}" />
                        <input type="hidden" name="jumlah[]" value="${jumlah}" />
                        <a href="#" key="${kode_biaya+kode_jenis_biaya}" class="delete w-6 h-6 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200/80 inline-flex items-center justify-center transition active:scale-95 cursor-pointer shadow-2xs" title="Hapus Item">
                            <i class="ti ti-trash text-xs"></i>
                        </a>
                    </td>
                </tr>`;

                $(document).find("#detailbayar").append(data);
                no++;

                $(document).find("#formDetailbayar").find("#kode_biaya").val("").trigger("change");
                $(document).find("#formDetailbayar").find("#jumlah").val("");
                $(document).find("#formDetailbayar").find("#keterangan").val("");
                $(document).find("#formDetailbayar").find("#sisa_tagihan").val("");

                hitungTotalBayar();
            }
        });


        $(document).on('click', '.delete', function(e) {
            e.preventDefault();
            let key = $(this).attr("key");
            event.preventDefault();
            Swal.fire({
                title: `Apakah Anda Yakin Ingin Menghapus Data Ini ?`,
                text: "Jika dihapus maka data akan hilang permanent.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                showCancelButton: true,
                confirmButtonColor: "#554bbb",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Hapus Saja!"
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $(document).find(`#index_${key}`).remove();
                    hitungTotalBayar();
                }
            });
        });


        $(document).on('click', '.btnDeletebayar', function(e) {
            e.preventDefault();
            let key = $(this).attr("key");
            event.preventDefault();
            Swal.fire({
                title: `Apakah Anda Yakin Ingin Menghapus Data Ini ?`,
                text: "Jika dihapus maka data akan hilang permanent.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                showCancelButton: true,
                confirmButtonColor: "#554bbb",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Hapus Saja!"
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('pembayaranpendidikan.delete') }}",
                        data: {
                            '_token': "{{ csrf_token() }}",
                            'no_bukti': key
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Data Berhasil Dihapus',
                                didClose: (e) => {
                                    gethistoribayar(response
                                        .no_pendaftaran);
                                    getbiaya(response.no_pendaftaran);
                                    getrencanaspp(response
                                        .no_pendaftaran);
                                }
                            })
                        },
                        error: function(response) {
                            Swal.fire({
                                title: "Error!",
                                text: response.responseJSON.message,
                                icon: "error",
                                showConfirmButton: true,
                                didClose: (e) => {

                                }
                            });
                        }
                    });
                }
            });
        });
        $(document).on('click', '.btnDetailbayar', function(e) {
            let no_bukti = $(this).attr('no_bukti');
            $("#modalDetailbayar").modal('show');
            $("#loaddetailbayar").html(loading);
            $("#modalDetailbayar").find(".modal-title").text("Detail Pembayaran");
            $("#loaddetailbayar").load(`/pembayaranpendidikan/${no_bukti}/showdetailbayar`);

        });

        function convertToRupiah(number) {
            if (number) {
                var rupiah = "";
                var numberrev = number
                    .toString()
                    .split("")
                    .reverse()
                    .join("");
                for (var i = 0; i < numberrev.length; i++)
                    if (i % 3 == 0) rupiah += numberrev.substr(i, 3) + ".";
                return (
                    rupiah
                    .split("", rupiah.length - 1)
                    .reverse()
                    .join("")
                );
            } else {
                return number;
            }
        }

        function hitungTotalBayar() {
            let totalBayar = 0;
            $(document).find(".jmlbayar").each(function() {
                totalBayar += parseInt($(this).text().replace(/[^0-9]/g, ''));
            });
            $("#totalbayar").text(convertToRupiah(totalBayar));
        }

        $(document).on('submit', '#formDetailbayar', function(e) {
            e.preventDefault();
            let tanggal = $(this).find("#tanggal").val();
            let cekdetail = $(this).find('#tableDetailbayar').find('#detailbayar tr').length;
            let metode_pembayaran = $(this).find("#metode_pembayaran").val();
            if (tanggal == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Tanggal tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#tanggal").focus();
                    }
                });
                return false;
            } else if (cekdetail == 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Detail Bayar tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#kode_biaya").focus();
                    }
                });
                return false;
            } else if (metode_pembayaran == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Metode pembayaran tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#metode_pembayaran").focus();
                    }
                });
                return false;
            } else {
                $(this).find("#btnSimpan").prop('disabled', true);
                $(this).find("#btnSimpan").html(
                    '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Loading...'
                );
                $.ajax({
                    type: "POST",
                    url: "{{ route('pembayaranpendidikan.store') }}",
                    cache: false,
                    data: $(this).serialize(),
                    success: function(respond) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: respond.message,
                            didClose: (e) => {
                                $("#modalpembayaran").modal("hide");
                                gethistoribayar(respond.no_pendaftaran);
                                getrencanaspp(respond.no_pendaftaran);
                                getbiaya(respond.no_pendaftaran);

                            }
                        });
                    },
                    error: function(respond) {
                        $(this).find("#btnSimpan").prop('disabled', false);
                        Swal.fire({
                            title: "Error!",
                            text: respond.responseJSON.message,
                            icon: "error",
                            showConfirmButton: true,
                        });
                    }
                });
            }
        });

        function gethistoribayar(no_pendaftaran) {
            $.ajax({
                type: 'GET',
                url: `/pembayaranpendidikan/${no_pendaftaran}/gethistoribayar`,
                cache: false,
                success: function(res) {
                    $(document).find("#tabelhistoribayar").html(res);
                }
            });
        }

        function getTingkatByUnit(kode_unit, selected = '') {
            selected = "{{ Request('tingkat') }}"
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
                    $(document).find("#tingkat").html(respond);
                }
            });

        }
        $(document).on('change', '#kode_unit_search', function() {
            const kode_unit = $(this).val();
            getTingkatByUnit(kode_unit);
        });

        if ("{{ Request('kode_unit') }}") {
            getTingkatByUnit("{{ Request('kode_unit') }}");
        }

        // Bulk Naik Kelas Logic
        $("#checkAll").click(function() {
            $(".checkItem").prop('checked', $(this).prop('checked'));
        });

        $("#btnBulkNaikKelas").click(function() {
            const checkedCount = $(".checkItem:checked").length;
            if (checkedCount === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Silakan pilih siswa terlebih dahulu!',
                });
                return false;
            }

            Swal.fire({
                title: 'Konfirmasi',
                text: `Apakah Anda yakin ingin menaikkan ${checkedCount} siswa yang dipilih?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#064e3b',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Proses!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#formBulkNaikKelas").submit();
                }
            });
        });

        // Handle click Ubah Biaya
        $(document).on('click', '.btnEditBiaya', function(e) {
            e.preventDefault();
            const no_pendaftaran = $(this).attr('no_pendaftaran');
            const kode_biaya = $(this).attr('kode_biaya');
            $("#modaleditbiaya").modal("show");
            $("#modaleditbiaya").find("#loadeditbiaya").html(loading);
            $("#modaleditbiaya").find(".modal-title").text("Ubah Konfigurasi Biaya");
            $("#loadeditbiaya").load(`/pembayaranpendidikan/${no_pendaftaran}/${kode_biaya}/editbiaya`);
        });

        // Handle submit Form Ubah Biaya
        $(document).on('submit', '#formEditBiaya', function(e) {
            e.preventDefault();
            const data = $(this).serialize();
            $(this).find('button[type="submit"]').prop('disabled', true);
            $(this).find('button[type="submit"]').html(
                '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Loading...'
            );

            $.ajax({
                url: "{{ route('pembayaranpendidikan.updatebiaya') }}",
                type: "POST",
                data: data,
                cache: false,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message,
                    });
                    $("#modaleditbiaya").modal("hide");
                    getbiaya(response.no_pendaftaran);
                    getrencanaspp(response.no_pendaftaran);
                    gethistoribayar(response.no_pendaftaran);
                },
                error: function(xhr) {
                    Swal.fire({
                        title: "Error!",
                        text: xhr.responseJSON.message,
                        icon: "error",
                        showConfirmButton: true,
                        didClose: (e) => {
                            $(document).find('#formEditBiaya').find(
                                'button[type="submit"]').prop(
                                'disabled', false);
                            $(document).find('#formEditBiaya').find(
                                'button[type="submit"]').html(
                                'Simpan Perubahan'
                            );
                        }
                    });
                }
            });
        });
    });
</script>
@endpush

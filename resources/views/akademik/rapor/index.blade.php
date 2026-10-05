@extends('layouts.app')
@section('titlepage', 'Penilaian Pembelajaran')

@section('content')
<div class="space-y-5">

    <!-- ================= 1. PAGE HEADER (NO CARD) WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <i class="ti ti-star text-emerald-600 text-2xl"></i>
                <span>Penilaian Pembelajaran & Rapor</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Manajemen bobot penilaian, penginputan asesmen sumatif & SAS, serta status sinkronisasi nilai rapor
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
                <span class="font-bold text-slate-800">Penilaian</span>
            </nav>
        </div>
    </div>

    <!-- ================= 2. FILTER & SEARCH TOOLBAR ================= -->
    <form action="{{ route('rapor.index') }}" method="GET" class="w-full">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2.5 sm:gap-3 w-full">
            <!-- Tahun Ajaran Filter -->
            <div class="relative">
                <i class="ti ti-calendar-event absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base pointer-events-none"></i>
                <select name="kode_ta" class="w-full pl-9 pr-8 py-2.5 text-sm bg-white border border-slate-300/90 rounded-lg text-slate-700 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                    @foreach ($semuaTa as $ta)
                        <option value="{{ $ta->kode_ta }}" {{ $selectedKodeTa == $ta->kode_ta ? 'selected' : '' }}>
                            {{ $ta->tahun_ajaran }} {{ $ta->status == 1 ? '(Aktif)' : '' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Semester Filter -->
            <div class="relative">
                <i class="ti ti-clock absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base pointer-events-none"></i>
                <select name="semester" class="w-full pl-9 pr-8 py-2.5 text-sm bg-white border border-slate-300/90 rounded-lg text-slate-700 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                    <option value="1" {{ $selectedSemester == 1 ? 'selected' : '' }}>Semester 1 (Ganjil)</option>
                    <option value="2" {{ $selectedSemester == 2 ? 'selected' : '' }}>Semester 2 (Genap)</option>
                </select>
            </div>

            <!-- Unit Filter (If Super Admin / Multi-Unit) -->
            @if ((auth()->user()->kode_unit == 'U06' || auth()->user()->hasRole('super admin')) && !auth()->user()->hasRole('guru'))
                <div class="relative">
                    <i class="ti ti-building absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base pointer-events-none"></i>
                    <select name="kode_unit" class="w-full pl-9 pr-8 py-2.5 text-sm bg-white border border-slate-300/90 rounded-lg text-slate-700 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                        <option value="">Semua Unit</option>
                        @foreach ($units as $u)
                            <option value="{{ $u->kode_unit }}" {{ request('kode_unit') == $u->kode_unit ? 'selected' : '' }}>
                                {{ $u->nama_unit }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            <!-- Filter Buttons -->
            <div class="flex items-center gap-2">
                <button type="submit" class="flex-1 py-2.5 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-lg shadow-xs transition inline-flex items-center justify-center gap-1.5 cursor-pointer active:scale-95">
                    <i class="ti ti-search text-base"></i>
                    <span>Terapkan Filter</span>
                </button>

                @if(request('kode_unit') || (request('semester') && request('semester') != '1') || (request('kode_ta') && request('kode_ta') != ($activeTa->kode_ta ?? '')))
                    <a href="{{ route('rapor.index') }}" class="py-2.5 px-3 bg-white hover:bg-slate-100 text-slate-600 border border-slate-300/90 rounded-lg font-semibold text-sm transition inline-flex items-center justify-center shrink-0 shadow-xs" title="Reset Filter">
                        <i class="ti ti-refresh text-base"></i>
                    </a>
                @endif
            </div>
        </div>
    </form>

    <!-- ================= 3. DATA TABLE (SEAMLESS SOLID GREEN HEADER) ================= -->
    <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
        
        <!-- Seamless Solid Green Card Header -->
        <div class="px-5 pt-4 pb-2.5 bg-emerald-600 flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-white border-0">
            <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-lg bg-white/20 text-white flex items-center justify-center text-xs font-bold border border-white/20 shadow-2xs">
                    <i class="ti ti-clipboard-text"></i>
                </div>
                <h3 class="text-sm font-extrabold text-white tracking-tight">Daftar Rombel Penilaian Mata Pelajaran</h3>
                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-white/20 text-white border border-white/30 shadow-2xs backdrop-blur-xs">
                    {{ count($jadwalGrouped) }} rombel
                </span>
            </div>
            <div class="text-xs text-emerald-100 font-medium">
                Tahun Ajaran: <span class="font-bold text-white">{{ $semuaTa->firstWhere('kode_ta', $selectedKodeTa)->tahun_ajaran ?? '-' }}</span> | Semester: <span class="font-bold text-white">{{ $selectedSemester == 1 ? 'Ganjil' : 'Genap' }}</span>
            </div>
        </div>

        <!-- Responsive Table Container -->
        <div class="overflow-x-auto bg-emerald-600">
            <table class="w-full min-w-[1050px] text-left text-xs sm:text-sm border-0 border-collapse">
                <!-- Matching Solid Green Table Header -->
                <thead class="bg-emerald-600 text-white font-bold uppercase tracking-wider text-[11px] border-0 border-t-0 border-b border-emerald-700/80">
                    <tr class="border-0 border-t-0">
                        <th class="py-2.5 px-3.5 w-14 text-center text-emerald-100 border-0 border-t-0 whitespace-nowrap">No</th>
                        <th class="py-2.5 px-3.5 min-w-[240px] text-emerald-100 border-0 border-t-0">Mata Pelajaran</th>
                        <th class="py-2.5 px-3.5 text-center w-36 text-emerald-100 border-0 border-t-0 whitespace-nowrap">Kelas & Unit</th>
                        <th class="py-2.5 px-3.5 min-w-[220px] text-emerald-100 border-0 border-t-0">Guru Pengampu</th>
                        <th class="py-2.5 px-3.5 text-center w-36 text-emerald-100 border-0 border-t-0 whitespace-nowrap">Tahun & Semester</th>
                        <th class="py-2.5 px-3.5 text-center w-36 text-emerald-100 border-0 border-t-0 whitespace-nowrap">Status Penilaian</th>
                        <th class="py-2.5 px-3.5 text-center w-40 text-emerald-100 border-0 border-t-0 whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700 font-medium bg-white">
                    @forelse ($jadwalGrouped as $d)
                        <tr class="hover:bg-slate-50/80 transition-colors group">
                            <!-- No Index -->
                            <td class="py-3 px-3.5 text-center text-slate-400 font-bold text-xs whitespace-nowrap">
                                <span class="w-6 h-6 rounded-md bg-slate-100 group-hover:bg-emerald-50 group-hover:text-emerald-700 group-hover:border group-hover:border-emerald-200 inline-flex items-center justify-center font-bold text-slate-600 transition text-[11px]">
                                    {{ $loop->iteration }}
                                </span>
                            </td>

                            <!-- Mata Pelajaran -->
                            <td class="py-3 px-3.5">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-200/80 flex items-center justify-center text-xs shrink-0 group-hover:bg-emerald-600 group-hover:text-white transition shadow-2xs">
                                        <i class="ti ti-books text-base"></i>
                                    </div>
                                    <div>
                                        <span class="font-bold text-slate-900 group-hover:text-emerald-800 transition text-xs sm:text-sm block">
                                            {{ $d->mapel->nama_matpel ?? '-' }}
                                        </span>
                                        @if(!empty($d->mapel->kelompok))
                                            <span class="px-1.5 py-0.2 rounded text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200 inline-block mt-0.5">
                                                Kelompok {{ $d->mapel->kelompok }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <!-- Kelas & Unit -->
                            <td class="py-3 px-3.5 text-center whitespace-nowrap">
                                <span class="px-2.5 py-1 rounded-md text-[11px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-200/80 shadow-2xs block mb-1">
                                    Kelas {{ $d->kelas->nama_kelas ?? '-' }}
                                </span>
                                <span class="text-[10px] font-semibold text-slate-500 block">
                                    {{ $d->unit->nama_unit ?? '-' }}
                                </span>
                            </td>

                            <!-- Guru Pengampu -->
                            <td class="py-3 px-3.5">
                                <div class="flex items-center gap-2">
                                    <div class="w-6.5 h-6.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 flex items-center justify-center text-xs shrink-0">
                                        <i class="ti ti-user"></i>
                                    </div>
                                    <div>
                                        <span class="font-bold text-slate-800 text-xs block">
                                            {{ $d->guru->karyawan->nama_lengkap ?? ($d->guru->nama_guru ?? '-') }}
                                        </span>
                                        @if(!empty($d->guru->karyawan->npp))
                                            <span class="text-[10px] text-slate-400 font-mono">NPP: {{ $d->guru->karyawan->npp }}</span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <!-- Tahun & Semester -->
                            <td class="py-3 px-3.5 text-center whitespace-nowrap">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700 border border-slate-200 block mb-1">
                                    Semester {{ $d->semester == 1 ? 'Ganjil' : 'Genap' }}
                                </span>
                                <span class="text-[11px] font-mono font-medium text-slate-500">
                                    {{ $d->tahunAjaran->tahun_ajaran ?? '-' }}
                                </span>
                            </td>

                            <!-- Status Penilaian -->
                            <td class="py-3 px-3.5 text-center whitespace-nowrap">
                                @if(($d->status_penilaian ?? 'draft') == 'terkirim')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 shadow-2xs">
                                        <i class="ti ti-circle-check text-xs"></i> Terkirim ke Rapor
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                        <i class="ti ti-clock text-xs"></i> Draft / Belum Kirim
                                    </span>
                                @endif
                            </td>

                            <!-- Aksi -->
                            <td class="py-3 px-3.5 text-center whitespace-nowrap">
                                <a href="{{ route('penilaian.index', $d->id) }}" 
                                   class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition active:scale-95 cursor-pointer">
                                    <i class="ti ti-chart-bar text-sm"></i>
                                    <span>Kelola Nilai</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-12 text-center text-slate-400">
                                <div class="w-14 h-14 rounded-2xl bg-slate-100 border border-slate-200 flex items-center justify-center mx-auto mb-3 text-slate-400 text-2xl">
                                    <i class="ti ti-clipboard-off"></i>
                                </div>
                                <h4 class="text-sm font-bold text-slate-800">Belum Ada Rombel Penilaian</h4>
                                <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                                    Tidak ditemukan jadwal mata pelajaran aktif yang dapat dinilai pada tahun ajaran dan semester ini.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

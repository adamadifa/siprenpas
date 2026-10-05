@extends('layouts.app')
@section('titlepage', 'Jobdesk')

@section('content')
@php
    function getDeptIcon($kode) {
        $icons = [
            'KEA' => 'ti ti-book-2',
            'ADM' => 'ti ti-file-text',
            'KEU' => 'ti ti-wallet',
            'SAR' => 'ti ti-tool',
            'HUM' => 'ti ti-world',
            'PEK' => 'ti ti-settings',
        ];
        return $icons[strtoupper($kode)] ?? 'ti ti-building-community';
    }
@endphp

<div class="space-y-6">

    <!-- ================= 1. PAGE HEADER & BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <!-- Title & Subtitle -->
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-xl shrink-0 font-bold border border-emerald-200 shadow-2xs">
                <i class="ti ti-list-check"></i>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">
                    Manajemen Jobdesk
                </h1>
                <p class="text-xs text-slate-500 font-medium">
                    @if (!$selected_unit && empty(request('jobdesk_search')))
                        Pilih unit kerja untuk melihat daftar jabatan & rincian uraian tugas (jobdesk)
                    @elseif ($selected_unit && !$selected_jabatan && empty(request('jobdesk_search')))
                        Pilih jabatan pada <strong>{{ strtoupper($selected_unit->nama_unit) }}</strong> untuk melihat atau mengelola rincian tugas
                    @else
                        Rincian tugas pokok & fungsi (tupoksi) jabatan
                    @endif
                </p>
            </div>
        </div>

        <!-- Breadcrumb & Top Actions -->
        <div class="flex flex-col md:items-end gap-2.5">
            <nav class="flex items-center text-xs text-slate-400 font-medium flex-wrap">
                <a href="{{ route('dashboard.index') }}" class="hover:text-slate-700 transition flex items-center gap-1">
                    <i class="ti ti-home text-sm"></i>
                    <span>Dashboard</span>
                </a>
                <span class="mx-2 text-slate-300">/</span>
                <span class="text-slate-500">MSDM & Layanan</span>
                <span class="mx-2 text-slate-300">/</span>
                <a href="{{ route('jobdesk.index') }}" class="hover:text-slate-700 transition {{ !$selected_unit ? 'font-bold text-slate-800' : 'text-slate-500' }}">Jobdesk</a>

                @if ($selected_unit)
                    <span class="mx-2 text-slate-300">/</span>
                    <a href="{{ route('jobdesk.index', ['kode_unit' => $selected_unit->kode_unit]) }}" class="hover:text-slate-700 transition {{ !$selected_jabatan ? 'font-bold text-slate-800' : 'text-slate-500' }}">
                        {{ strtoupper($selected_unit->nama_unit) }}
                    </a>
                @endif

                @if ($selected_jabatan)
                    <span class="mx-2 text-slate-300">/</span>
                    <span class="font-bold text-slate-800">{{ strtoupper($selected_jabatan->nama_jabatan) }}</span>
                @endif
            </nav>

            <div class="flex flex-wrap items-center gap-2">
                @can('jobdesk.create')
                    <button type="button" 
                            id="btncreateJobdesk"
                            class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg text-xs shadow-xs transition active:scale-95 cursor-pointer">
                        <i class="ti ti-plus text-sm"></i>
                        <span>Tambah Jobdesk</span>
                    </button>
                    <button type="button" 
                            id="btnimportJobdesk"
                            class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-white hover:bg-slate-50 text-slate-700 font-semibold rounded-lg text-xs border border-slate-200 shadow-2xs transition active:scale-95 cursor-pointer">
                        <i class="ti ti-file-import text-sm text-emerald-600"></i>
                        <span>Import Excel</span>
                    </button>
                @endcan

                @if(auth()->check() && auth()->user()->hasRole('super admin'))
                    <form method="POST" action="{{ route('jobdesk.reset') }}" class="inline-block m-0" id="formResetJobdesk">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-rose-50 hover:bg-rose-600 text-rose-700 hover:text-white font-bold rounded-lg text-xs border border-rose-200 transition active:scale-95 cursor-pointer btn-reset-confirm"
                                title="Reset semua data jobdesk">
                            <i class="ti ti-rotate text-sm"></i>
                            <span>Reset</span>
                        </button>
                    </form>
                @endif

                @can('jobdesk.delete')
                    <button type="button" 
                            id="btnDeleteSelected" 
                            class="hidden inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-rose-600 hover:bg-rose-700 text-white font-bold rounded-lg text-xs shadow-xs transition active:scale-95 cursor-pointer">
                        <i class="ti ti-trash text-sm"></i>
                        <span>Hapus (<span id="selected-count">0</span>)</span>
                    </button>
                    <form id="formBulkDelete" method="POST" action="{{ route('jobdesk.delete-multiple') }}" class="hidden">
                        @csrf
                    </form>
                @endcan
            </div>
        </div>
    </div>


    {{-- ========================================================================= --}}
    {{-- ====================== SCREEN 1: PILIHAN UNIT KERJA ====================== --}}
    {{-- ========================================================================= --}}
    @if (!$selected_unit && empty(request('jobdesk_search')))
        <div class="space-y-4">
            <!-- Unit Header Toolbar -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-white p-3.5 border border-slate-200/90 rounded-2xl shadow-xs">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-200/80 flex items-center justify-center text-base font-bold">
                        <i class="ti ti-building"></i>
                    </div>
                    <div>
                        <h2 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Langkah 1: Pilih Unit Kerja</h2>
                        <p class="text-[11px] text-slate-400 font-medium">Klik salah satu unit kerja di bawah untuk membuka daftar jabatan</p>
                    </div>
                </div>

                <!-- Global Search Form -->
                <form action="{{ route('jobdesk.index') }}" method="GET" class="relative w-full sm:w-80 m-0">
                    <i class="ti ti-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base pointer-events-none"></i>
                    <input type="text" 
                           name="jobdesk_search" 
                           value="{{ request('jobdesk_search') }}"
                           placeholder="Cari kata kunci jobdesk langsung..." 
                           class="w-full pl-10 pr-4 py-2 text-xs bg-slate-50 border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                </form>
            </div>

            <!-- Unit Cards Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse ($unit as $u)
                    @php
                        $unitJobdesksCount = isset($jobdesk_summary) ? $jobdesk_summary->where('kode_unit', $u->kode_unit)->sum('total_jobdesk') : $jobdesk->where('kode_unit', $u->kode_unit)->count();
                        $unitJabatansCount = isset($jobdesk_summary) ? $jobdesk_summary->where('kode_unit', $u->kode_unit)->pluck('kode_jabatan')->unique()->count() : $jobdesk->where('kode_unit', $u->kode_unit)->pluck('kode_jabatan')->unique()->count();
                    @endphp
                    <a href="{{ route('jobdesk.index', ['kode_unit' => $u->kode_unit]) }}" 
                       class="group block bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs hover:shadow-md hover:border-emerald-400 transition-all duration-200 text-decoration-none">
                        <div class="flex items-start gap-4">
                            <div class="w-13 h-13 rounded-2xl bg-emerald-50 text-emerald-700 border border-emerald-200/80 flex items-center justify-center font-bold text-2xl shrink-0 group-hover:scale-105 group-hover:bg-emerald-600 group-hover:text-white transition-all duration-200 shadow-2xs">
                                <i class="ti ti-building"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between gap-2 mb-1.5">
                                    <span class="font-mono font-bold text-[11px] text-slate-600 bg-slate-100 px-2 py-0.5 rounded border border-slate-200">
                                        {{ $u->kode_unit }}
                                    </span>
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $unitJobdesksCount > 0 ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : 'bg-slate-100 text-slate-500 border border-slate-200' }}">
                                        {{ $unitJobdesksCount }} Jobdesk
                                    </span>
                                </div>
                                <h3 class="text-sm font-bold text-slate-900 group-hover:text-emerald-700 transition truncate mb-1">
                                    {{ strtoupper($u->nama_unit) }}
                                </h3>
                                <p class="text-xs text-slate-400 flex items-center gap-1.5 mb-3">
                                    <i class="ti ti-user-check text-slate-400"></i>
                                    <span>{{ $unitJabatansCount }} Jabatan terisi tupoksi</span>
                                </p>
                                <div class="pt-2.5 border-t border-slate-100 flex items-center justify-between text-xs font-bold text-emerald-600 group-hover:text-emerald-700">
                                    <span>Buka Daftar Jabatan</span>
                                    <i class="ti ti-arrow-right text-sm group-hover:translate-x-1 transition-transform"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full bg-white border border-slate-200/90 rounded-2xl p-12 text-center shadow-xs">
                        <div class="w-16 h-16 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center text-3xl mb-3 mx-auto">
                            <i class="ti ti-building-off"></i>
                        </div>
                        <h4 class="text-sm font-bold text-slate-800 mb-1">Belum Ada Data Unit</h4>
                        <p class="text-xs text-slate-400">Data unit kerja belum terdaftar pada sistem.</p>
                    </div>
                @endforelse
            </div>
        </div>


    {{-- ========================================================================= --}}
    {{-- ===================== SCREEN 2: PILIHAN JABATAN DI UNIT ================== --}}
    {{-- ========================================================================= --}}
    @elseif ($selected_unit && !$selected_jabatan && empty(request('jobdesk_search')))
        <div class="space-y-4">
            <!-- Unit Navigation & Filter Banner -->
            <div class="bg-white border border-slate-200/90 rounded-2xl p-4 sm:p-5 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center gap-3.5">
                    <a href="{{ route('jobdesk.index') }}" 
                       class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold border border-slate-200 transition shrink-0" 
                       title="Kembali ke Pilihan Unit">
                        <i class="ti ti-arrow-left text-lg"></i>
                    </a>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-600 font-mono border border-slate-200">
                                {{ $selected_unit->kode_unit }}
                            </span>
                            <span class="text-xs font-bold text-emerald-700 uppercase tracking-wider">Unit Kerja Terpilih</span>
                        </div>
                        <h2 class="text-lg font-bold text-slate-900 tracking-tight">
                            {{ strtoupper($selected_unit->nama_unit) }}
                        </h2>
                    </div>
                </div>

                <!-- Instant Jabatan Filter Box -->
                <div class="relative w-full md:w-80">
                    <i class="ti ti-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base pointer-events-none"></i>
                    <input type="text" 
                           id="filterJabatanInput" 
                           placeholder="Cari nama jabatan..." 
                           class="w-full pl-10 pr-4 py-2 text-xs bg-slate-50 border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                </div>
            </div>

            <!-- Jabatan Cards Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4" id="jabatanGridContainer">
                @forelse ($jabatan_unit as $jab)
                    @php
                        $jabJobdesksCount = isset($jobdesk_summary) 
                            ? $jobdesk_summary->where('kode_unit', $selected_unit->kode_unit)->where('kode_jabatan', $jab->kode_jabatan)->sum('total_jobdesk')
                            : $jobdesk->where('kode_unit', $selected_unit->kode_unit)->where('kode_jabatan', $jab->kode_jabatan)->count();
                    @endphp
                    <a href="{{ route('jobdesk.index', ['kode_unit' => $selected_unit->kode_unit, 'kode_dept' => 'all', 'kode_jabatan' => $jab->kode_jabatan]) }}" 
                       class="jabatan-card group block bg-white border border-slate-200/90 rounded-2xl p-4 sm:p-5 shadow-xs hover:shadow-md hover:border-emerald-400 transition-all duration-200 text-decoration-none"
                       data-jabatan-name="{{ strtolower($jab->nama_jabatan) }}">
                        <div class="flex items-start gap-3.5">
                            <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-200/80 flex items-center justify-center font-bold text-lg shrink-0 group-hover:scale-105 group-hover:bg-emerald-600 group-hover:text-white transition-all duration-200 shadow-2xs">
                                <i class="ti ti-briefcase"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between gap-2 mb-1">
                                    <span class="font-mono font-bold text-[10px] text-slate-500 bg-slate-100 px-1.5 py-0.5 rounded border border-slate-200">
                                        {{ $jab->kode_jabatan }}
                                    </span>
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $jabJobdesksCount > 0 ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : 'bg-slate-100 text-slate-500 border border-slate-200' }}">
                                        {{ $jabJobdesksCount > 0 ? $jabJobdesksCount . ' Butir Jobdesk' : 'Belum ada jobdesk' }}
                                    </span>
                                </div>
                                <h4 class="text-sm font-bold text-slate-900 group-hover:text-emerald-700 transition truncate mb-2">
                                    {{ strtoupper($jab->nama_jabatan) }}
                                </h4>
                                <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-xs font-bold text-emerald-600 group-hover:text-emerald-700">
                                    <span>Lihat Rincian Jobdesk</span>
                                    <i class="ti ti-arrow-right text-sm group-hover:translate-x-1 transition-transform"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full bg-white border border-slate-200/90 rounded-2xl p-12 text-center shadow-xs">
                        <div class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center text-2xl mb-3 mx-auto">
                            <i class="ti ti-briefcase-off"></i>
                        </div>
                        <h4 class="text-sm font-bold text-slate-800 mb-1">Belum Ada Jabatan Terdaftar di Unit Ini</h4>
                        <p class="text-xs text-slate-400 max-w-sm mx-auto">Belum ada data karyawan dengan jabatan pada unit kerja ini.</p>
                    </div>
                @endforelse
            </div>
        </div>


    {{-- ========================================================================= --}}
    {{-- ================== SCREEN 3: RINCIAN BUTIR DETAIL JOBDESK ================ --}}
    {{-- ========================================================================= --}}
    @else
        <div class="space-y-4">
            <!-- Navigation Back Bar & Position Info -->
            <div class="bg-white border border-slate-200/90 rounded-2xl p-3.5 sm:p-4 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    @if ($selected_unit)
                        <a href="{{ route('jobdesk.index', ['kode_unit' => $selected_unit->kode_unit]) }}" 
                           class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold border border-slate-200 transition shrink-0" 
                           title="Kembali ke Daftar Jabatan">
                            <i class="ti ti-arrow-left text-base"></i>
                        </a>
                    @else
                        <a href="{{ route('jobdesk.index') }}" 
                           class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold border border-slate-200 transition shrink-0" 
                           title="Kembali ke Pilihan Unit">
                            <i class="ti ti-arrow-left text-base"></i>
                        </a>
                    @endif

                    <div>
                        <div class="flex items-center gap-2 text-[11px] font-bold text-emerald-700 uppercase tracking-wider">
                            <span>{{ $selected_unit->nama_unit ?? 'Semua Unit' }}</span>
                            @if ($selected_dept)
                                <span>•</span>
                                <span>{{ $selected_dept->nama_dept }}</span>
                            @endif
                        </div>
                        <h2 class="text-base font-bold text-slate-900 tracking-tight">
                            @if ($selected_jabatan)
                                Jabatan: {{ strtoupper($selected_jabatan->nama_jabatan) }}
                            @else
                                Hasil Pencarian: "{{ request('jobdesk_search') }}"
                            @endif
                        </h2>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                        {{ count($jobdesk) }} Butir Jobdesk Ditemukan
                    </span>
                    @if (request('jobdesk_search'))
                        <a href="{{ route('jobdesk.index') }}" class="px-3 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-lg transition">
                            Reset Filter
                        </a>
                    @endif
                </div>
            </div>

            <!-- Jobdesk Table Container -->
            <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
                <!-- Table Header Bar -->
                <div class="px-4 py-2.5 bg-emerald-600 flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-white">
                    <div class="flex items-center gap-2">
                        <div class="w-6 h-6 rounded-lg bg-white/20 text-white flex items-center justify-center text-xs font-bold border border-white/20 shadow-2xs">
                            <i class="ti ti-list"></i>
                        </div>
                        <h3 class="text-xs sm:text-sm font-bold text-white tracking-tight">Daftar Rincian Uraian Tugas Pokok & Fungsi</h3>
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto bg-emerald-600">
                    <table class="w-full text-left text-xs border-0 border-collapse">
                        <thead class="bg-emerald-600 text-white font-bold uppercase tracking-wider text-[10.5px] border-0 border-t border-b border-emerald-700/80">
                            <tr class="border-0">
                                @can('jobdesk.delete')
                                    <th class="py-2 px-3 w-10 text-center text-emerald-100">
                                        <input type="checkbox" id="check-all-jobdesk" class="rounded text-emerald-600 focus:ring-emerald-500">
                                    </th>
                                @endcan
                                <th class="py-2 px-3 w-20 text-center text-emerald-100 whitespace-nowrap">Kode</th>
                                @if (empty($selected_jabatan) || request('jobdesk_search'))
                                    <th class="py-2 px-3 text-center text-emerald-100 whitespace-nowrap">Jabatan</th>
                                    <th class="py-2 px-3 text-center text-emerald-100 whitespace-nowrap">Departemen</th>
                                    <th class="py-2 px-3 text-center text-emerald-100 whitespace-nowrap">Unit</th>
                                @endif
                                <th class="py-2 px-3 text-emerald-100">Uraian Tugas Pokok & Fungsi (Jobdesk)</th>
                                <th class="py-2 px-3 text-center w-24 text-emerald-100 whitespace-nowrap">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="jobdesk-table-body" class="divide-y divide-slate-100 text-slate-700 font-medium bg-white text-xs">
                            @forelse ($jobdesk as $d)
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    @can('jobdesk.delete')
                                        <td class="py-1.5 px-3 text-center">
                                            <input type="checkbox" class="jobdesk-checkbox rounded text-emerald-600 focus:ring-emerald-500" value="{{ Crypt::encrypt($d->kode_jobdesk) }}">
                                        </td>
                                    @endcan

                                    <td class="py-1.5 px-3 text-center whitespace-nowrap">
                                        <span class="font-mono font-bold text-slate-700 bg-slate-100 px-2 py-0.5 rounded text-[10.5px] border border-slate-200">
                                            {{ $d->kode_jobdesk }}
                                        </span>
                                    </td>

                                    @if (empty($selected_jabatan) || request('jobdesk_search'))
                                        <td class="py-1.5 px-3 text-center whitespace-nowrap">
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                                {{ $d->nama_jabatan }}
                                            </span>
                                        </td>
                                        <td class="py-1.5 px-3 text-center whitespace-nowrap">
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                                {{ $d->nama_dept }}
                                            </span>
                                        </td>
                                        <td class="py-1.5 px-3 text-center whitespace-nowrap">
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                                {{ $d->nama_unit ?? 'Umum' }}
                                            </span>
                                        </td>
                                    @endif

                                    <td class="py-1.5 px-3 leading-snug text-slate-800 font-medium whitespace-pre-line text-xs">
                                        {{ removeHtmltag($d->jobdesk) }}
                                    </td>

                                    <td class="py-1.5 px-3 text-center whitespace-nowrap">
                                        <div class="inline-flex items-center gap-1">
                                            @can('jobdesk.edit')
                                                <button type="button" 
                                                        class="btnEdit inline-flex items-center justify-center w-6.5 h-6.5 rounded-md bg-blue-50 hover:bg-blue-600 text-blue-700 hover:text-white border border-blue-200 font-bold transition-all duration-150 active:scale-95 cursor-pointer shadow-2xs"
                                                        kode_jobdesk="{{ Crypt::encrypt($d->kode_jobdesk) }}" 
                                                        title="Edit Jobdesk">
                                                    <i class="ti ti-edit text-xs"></i>
                                                </button>
                                            @endcan
                                            @can('jobdesk.delete')
                                                <form method="POST" 
                                                      action="{{ route('jobdesk.delete', Crypt::encrypt($d->kode_jobdesk)) }}" 
                                                      class="inline-block m-0 deleteform">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="delete-confirm inline-flex items-center justify-center w-6.5 h-6.5 rounded-md bg-rose-50 hover:bg-rose-600 text-rose-700 hover:text-white border border-rose-200 font-bold transition-all duration-150 active:scale-95 cursor-pointer shadow-2xs"
                                                            title="Hapus Jobdesk">
                                                        <i class="ti ti-trash text-xs"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ auth()->user()->can('jobdesk.delete') ? 6 : 5 }}" class="py-8 px-4 text-center bg-white">
                                        <div class="flex flex-col items-center justify-center max-w-sm mx-auto">
                                            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl mb-2 border border-emerald-100 shadow-2xs">
                                                <i class="ti ti-briefcase"></i>
                                            </div>
                                            <h4 class="text-xs font-bold text-slate-800 mb-0.5">Belum Ada Data Jobdesk</h4>
                                            <p class="text-[11px] text-slate-400 text-center leading-relaxed mb-2.5">
                                                Belum ada uraian tugas untuk posisi ini. Silakan tambahkan data baru.
                                            </p>
                                            @can('jobdesk.create')
                                                <button type="button" 
                                                        class="btncreateJobdeskDirect inline-flex items-center gap-1 px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg text-xs shadow-xs transition active:scale-95 cursor-pointer">
                                                    <i class="ti ti-plus text-xs"></i>
                                                    <span>Tambah Jobdesk Sekarang</span>
                                                </button>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

</div>

<!-- Modal Container -->
<x-modal-form id="mdlJobdesk" size="" show="loadJobdesk" title="" />

<!-- Modal Import Jobdesk -->
<div class="modal fade" id="mdlImportJobdesk" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-2xl border-0 shadow-lg overflow-hidden">
            <div class="px-5 py-4 bg-emerald-600 text-white flex items-center justify-between">
                <h5 class="text-sm font-bold text-white mb-0 flex items-center gap-2">
                    <i class="ti ti-file-import text-lg"></i>
                    <span>Import Data Jobdesk</span>
                </h5>
                <button type="button" class="text-white/80 hover:text-white" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti ti-x text-lg"></i>
                </button>
            </div>
            <form action="{{ route('jobdesk.import') }}" method="POST" enctype="multipart/form-data" class="p-5 space-y-4">
                @csrf
                <div class="p-3 bg-emerald-50/80 border border-emerald-200/80 rounded-xl text-xs text-emerald-800 space-y-1">
                    <span class="font-bold block">Petunjuk Impor Excel:</span>
                    <span>1. Unduh template Excel yang disediakan di bawah.</span><br>
                    <span>2. Isi kolom kode unit, departemen, jabatan, dan deskripsi tugas sesuai referensi.</span><br>
                    <span>3. Upload berkas Excel (.xlsx) yang telah diisi.</span>
                </div>

                <div class="text-center">
                    <a href="{{ route('jobdesk.download-format') }}" 
                       class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-bold rounded-xl text-xs border border-emerald-200 transition">
                        <i class="ti ti-download text-sm"></i>
                        <span>Unduh Format Excel</span>
                    </a>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Pilih Berkas Excel (.xlsx)</label>
                    <input type="file" name="file" id="import-file" class="w-full px-3 py-2 text-xs bg-white border border-slate-300 rounded-xl text-slate-800" accept=".xlsx, .xls, .csv" required>
                </div>

                <div class="grid grid-cols-2 gap-3 pt-2">
                    <button type="button" class="py-2.5 px-4 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="py-2.5 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition">
                        Mulai Impor
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('myscript')
<script>
    $(function() {
        const loadingSpinner = `
            <div class="flex items-center justify-center p-8">
                <div class="w-8 h-8 border-4 border-emerald-600 border-t-transparent rounded-full animate-spin"></div>
            </div>
        `;

        const selectedUnitId = "{{ $selected_unit->kode_unit ?? '' }}";
        const selectedDeptId = "{{ $selected_dept->kode_dept ?? '' }}";
        const selectedJabId = "{{ $selected_jabatan->kode_jabatan ?? '' }}";

        // Filter local jabatans on Screen 2
        $('#filterJabatanInput').on('input', function() {
            let query = $(this).val().toLowerCase().trim();
            $('.jabatan-card').each(function() {
                let name = $(this).attr('data-jabatan-name') || '';
                if (name.includes(query)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        // Create modal
        $(document).on("click", "#btncreateJobdesk, .btncreateJobdeskDirect", function(e) {
            e.preventDefault();
            let url = "{{ route('jobdesk.create') }}";
            let params = [];
            if (selectedUnitId) params.push(`kode_unit=${selectedUnitId}`);
            if (selectedDeptId) params.push(`kode_dept=${selectedDeptId}`);
            if (selectedJabId) params.push(`kode_jabatan=${selectedJabId}`);
            if (params.length > 0) url += '?' + params.join('&');

            $("#mdlJobdesk").modal("show");
            $("#mdlJobdesk").find(".modal-title").text("Tambah Jobdesk Baru");
            $("#loadJobdesk").html(loadingSpinner);
            $("#loadJobdesk").load(url);
        });

        // Import modal
        $("#btnimportJobdesk").click(function(e) {
            e.preventDefault();
            $("#mdlImportJobdesk").modal("show");
        });

        // Edit modal
        $(document).on("click", ".btnEdit", function(e) {
            e.preventDefault();
            let kode_jobdesk = $(this).attr("kode_jobdesk");
            $("#mdlJobdesk").modal("show");
            $("#mdlJobdesk").find(".modal-title").text("Edit Data Jobdesk");
            $("#loadJobdesk").html(loadingSpinner);
            $("#loadJobdesk").load(`/jobdesk/${kode_jobdesk}/edit`);
        });

        // Bulk delete check all
        $("#check-all-jobdesk").on("change", function() {
            let isChecked = $(this).is(":checked");
            $(".jobdesk-checkbox:visible").prop("checked", isChecked);
            updateBulkDeleteState();
        });

        $(document).on("change", ".jobdesk-checkbox", function() {
            updateBulkDeleteState();
        });

        function updateBulkDeleteState() {
            let checkedCount = $(".jobdesk-checkbox:checked").length;
            $("#selected-count").text(checkedCount);
            if (checkedCount > 0) {
                $("#btnDeleteSelected").removeClass("hidden").addClass("inline-flex");
            } else {
                $("#btnDeleteSelected").addClass("hidden").removeClass("inline-flex");
            }
        }

        $("#btnDeleteSelected").on("click", function(e) {
            e.preventDefault();
            let selected = [];
            $(".jobdesk-checkbox:checked").each(function() {
                selected.push($(this).val());
            });

            if (selected.length === 0) return;

            Swal.fire({
                title: 'Hapus Jobdesk Terpilih?',
                text: `Anda akan menghapus ${selected.length} butir jobdesk sekaligus!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus Semua!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    let form = $("#formBulkDelete");
                    form.empty();
                    form.append(`@csrf`);
                    selected.forEach(function(val) {
                        form.append(`<input type="hidden" name="selected_jobdesks[]" value="${val}">`);
                    });
                    form.submit();
                }
            });
        });

        // Reset confirmation
        $(".btn-reset-confirm").on("click", function(e) {
            e.preventDefault();
            let form = $(this).closest("form");
            Swal.fire({
                title: 'Reset Semua Jobdesk?',
                text: "Seluruh data jobdesk akan dihapus dari sistem dan tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Reset Data!',
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

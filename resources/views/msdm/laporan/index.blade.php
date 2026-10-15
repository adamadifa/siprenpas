@extends('layouts.app')
@section('titlepage', 'Laporan MSDM')

@section('content')
<div class="space-y-6">

    <!-- ================= 1. PAGE HEADER & BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <!-- Title & Subtitle -->
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-xl shrink-0 font-bold border border-emerald-200 shadow-2xs">
                <i class="ti ti-printer"></i>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">
                    Laporan MSDM
                </h1>
                <p class="text-xs text-slate-500 font-medium">
                    Cetak dan export data rekapitulasi presensi karyawan serta checklist ibadah harian
                </p>
            </div>
        </div>

        <!-- Breadcrumb Navigation -->
        <div class="flex flex-col md:items-end">
            <nav class="flex items-center text-xs text-slate-400 font-medium">
                <a href="{{ route('dashboard.index') }}" class="hover:text-slate-700 transition flex items-center gap-1">
                    <i class="ti ti-home text-sm"></i>
                    <span>Dashboard</span>
                </a>
                <span class="mx-2 text-slate-300">/</span>
                <span class="text-slate-500">MSDM & Layanan</span>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Laporan MSDM</span>
            </nav>
        </div>
    </div>

    <!-- ================= 2. MAIN REPORT CONTAINER WITH TABS ================= -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- Left Tab Selection Nav -->
        <div class="lg:col-span-4 xl:col-span-3 space-y-3">
            <div class="bg-white p-2 border border-slate-200/90 rounded-2xl shadow-xs space-y-1.5">
                <button type="button" 
                        class="tab-btn active w-full flex items-center gap-3 px-3.5 py-3 rounded-xl font-bold text-xs transition-all duration-200 text-left cursor-pointer active:scale-98" 
                        data-target="#tab-presensi">
                    <div class="tab-icon w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-base shrink-0 font-bold">
                        <i class="ti ti-fingerprint"></i>
                    </div>
                    <div>
                        <span class="block text-slate-900 text-xs font-bold leading-tight">Rekap Presensi</span>
                        <span class="block text-[11px] text-slate-400 font-normal mt-0.5">Kehadiran, jam & izin absen</span>
                    </div>
                </button>

                <button type="button" 
                        class="tab-btn w-full flex items-center gap-3 px-3.5 py-3 rounded-xl font-bold text-xs transition-all duration-200 text-left cursor-pointer active:scale-98" 
                        data-target="#tab-checklistibadah">
                    <div class="tab-icon w-8 h-8 rounded-lg bg-slate-100 text-slate-500 flex items-center justify-center text-base shrink-0 font-bold">
                        <i class="ti ti-clipboard-check"></i>
                    </div>
                    <div>
                        <span class="block text-slate-900 text-xs font-bold leading-tight">Checklist Ibadah</span>
                        <span class="block text-[11px] text-slate-400 font-normal mt-0.5">Rekap pembiasaan ibadah</span>
                    </div>
                </button>
            </div>

            <!-- Helpful Information Card -->
            <div class="p-4 bg-emerald-50/70 border border-emerald-200/70 rounded-2xl text-xs space-y-2">
                <div class="flex items-center gap-2 font-bold text-emerald-900">
                    <i class="ti ti-info-circle text-base text-emerald-600"></i>
                    <span>Petunjuk Cetak Laporan</span>
                </div>
                <p class="text-[11px] text-emerald-800 leading-relaxed">
                    Pilih periode bulan dan tahun yang diinginkan. Anda dapat memfilter unit kerja atau langsung spesifik ke salah satu karyawan.
                </p>
                <div class="pt-2 border-t border-emerald-200/60 flex items-center gap-2 text-[11px] text-emerald-700 font-medium">
                    <i class="ti ti-file-spreadsheet text-sm"></i>
                    <span>Mendukung cetak langsung & export Excel</span>
                </div>
            </div>
        </div>

        <!-- Right Form Content Box -->
        <div class="lg:col-span-8 xl:col-span-9">
            
            {{-- TAB 1: LAPORAN REKAP PRESENSI --}}
            <div id="tab-presensi" class="tab-pane-content bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
                <!-- Header Card -->
                <div class="px-5 py-4 bg-emerald-600 flex items-center justify-between text-white">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-white/20 text-white flex items-center justify-center text-sm font-bold border border-white/20 shadow-2xs">
                            <i class="ti ti-fingerprint"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-white tracking-tight">Form Cetak Laporan Presensi Karyawan</h3>
                            <p class="text-[11px] text-emerald-100 font-medium">Rekapitulasi absensi harian, jam kerja, keterlambatan, dan izin</p>
                        </div>
                    </div>
                </div>

                <!-- Form Body -->
                <div class="p-5 sm:p-6">
                    @if (session('warning'))
                        <div class="mb-4 p-3.5 bg-amber-50 border border-amber-300 text-amber-800 rounded-xl text-xs sm:text-sm font-semibold flex items-start gap-2">
                            <i class="ti ti-alert-triangle text-amber-500 text-lg flex-shrink-0 mt-0.5"></i>
                            <span>{{ session('warning') }}</span>
                        </div>
                    @endif
                    <form action="{{ route('laporanmsdm.cetakpresensi') }}" method="POST" target="_blank" class="space-y-4" id="formPresensi">
                        @csrf
                        
                        <!-- Filter Unit & Karyawan -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Unit Filter -->
                            <div class="space-y-1.5">
                                <label for="presensi_kode_unit" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                                    <i class="ti ti-building text-sm text-slate-400"></i>
                                    <span>Unit Kerja <span class="text-slate-400 font-normal text-[11px]">(Opsional)</span></span>
                                </label>
                                @if (auth()->user()->kode_unit != 'U06')
                                    <input type="hidden" name="kode_unit" id="presensi_kode_unit" value="{{ auth()->user()->kode_unit }}">
                                    <div class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm font-semibold text-slate-700 flex items-center gap-2">
                                        <i class="ti ti-lock text-slate-400"></i>
                                        <span>{{ textUpperCase(auth()->user()->unit->nama_unit ?? 'Unit Anda') }}</span>
                                    </div>
                                @else
                                    <div class="relative">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                            <i class="ti ti-building text-base"></i>
                                        </div>
                                        <select name="kode_unit" id="presensi_kode_unit" class="select-unit w-full pl-9 pr-8 py-2.5 text-xs sm:text-sm font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                                            <option value="">Semua Unit</option>
                                            @foreach ($unit as $d)
                                                <option value="{{ $d->kode_unit }}">{{ textUpperCase($d->nama_unit) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                            </div>

                            <!-- Karyawan Filter -->
                            <div class="space-y-1.5">
                                <label for="presensi_npp" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                                    <i class="ti ti-user text-sm text-slate-400"></i>
                                    <span>Karyawan <span class="text-slate-400 font-normal text-[11px]">(Opsional)</span></span>
                                </label>
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                        <i class="ti ti-user text-base"></i>
                                    </div>
                                    <select name="npp" id="presensi_npp" class="w-full pl-9 pr-8 py-2.5 text-xs sm:text-sm font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                                        <option value="">Semua Karyawan</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Pilihan Tipe Filter Periode -->
                        <div class="pt-1">
                            <label class="block text-xs font-bold text-slate-700 mb-2">Pilihan Filter Waktu</label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="flex items-center gap-2 p-2.5 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50 transition has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50/50">
                                    <input type="radio" name="presensi_tipe_periode" value="bulan" class="accent-emerald-600 radio-tipe-periode" data-target="#presensi_container_bulan" data-alt="#presensi_container_tanggal" checked>
                                    <span class="text-xs font-semibold text-slate-800">Bulanan (Bulan & Tahun)</span>
                                </label>
                                <label class="flex items-center gap-2 p-2.5 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50 transition has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50/50">
                                    <input type="radio" name="presensi_tipe_periode" value="tanggal" class="accent-emerald-600 radio-tipe-periode" data-target="#presensi_container_tanggal" data-alt="#presensi_container_bulan">
                                    <span class="text-xs font-semibold text-slate-800">Rentang Tanggal (Dari - Sampai)</span>
                                </label>
                            </div>
                        </div>

                        <!-- Periode 1: Bulan & Tahun -->
                        <div id="presensi_container_bulan" class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-1">
                            <!-- Bulan -->
                            <div class="space-y-1.5">
                                <label for="presensi_bulan" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                                    <i class="ti ti-calendar text-sm text-slate-400"></i>
                                    <span>Bulan</span>
                                </label>
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                        <i class="ti ti-calendar text-base"></i>
                                    </div>
                                    <select name="bulan" id="presensi_bulan" class="w-full pl-9 pr-8 py-2.5 text-xs sm:text-sm font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                                        <option value="">-- Pilih Bulan --</option>
                                        @foreach ($list_bulan as $d)
                                            <option {{ date('m') == $d['kode_bulan'] ? 'selected' : '' }} value="{{ $d['kode_bulan'] }}">
                                                {{ $d['nama_bulan'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Tahun -->
                            <div class="space-y-1.5">
                                <label for="presensi_tahun" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                                    <i class="ti ti-calendar-event text-sm text-slate-400"></i>
                                    <span>Tahun</span>
                                </label>
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                        <i class="ti ti-calendar-event text-base"></i>
                                    </div>
                                    <select name="tahun" id="presensi_tahun" class="w-full pl-9 pr-8 py-2.5 text-xs sm:text-sm font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                                        <option value="">-- Pilih Tahun --</option>
                                        @for ($t = $start_year; $t <= date('Y'); $t++)
                                            <option {{ date('Y') == $t ? 'selected' : '' }} value="{{ $t }}">{{ $t }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Periode 2: Rentang Tanggal (Custom Date Range) -->
                        <div id="presensi_container_tanggal" class="hidden grid grid-cols-1 sm:grid-cols-2 gap-4 pt-1">
                            <!-- Dari Tanggal -->
                            <div class="space-y-1.5">
                                <label for="presensi_dari" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                                    <i class="ti ti-calendar-time text-sm text-slate-400"></i>
                                    <span>Dari Tanggal</span>
                                </label>
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                        <i class="ti ti-calendar-time text-base"></i>
                                    </div>
                                    <input type="date" name="dari" id="presensi_dari" value="{{ date('Y-m-01') }}" class="w-full pl-9 pr-4 py-2.5 text-xs sm:text-sm font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                                </div>
                            </div>

                            <!-- Sampai Tanggal -->
                            <div class="space-y-1.5">
                                <label for="presensi_sampai" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                                    <i class="ti ti-calendar-time text-sm text-slate-400"></i>
                                    <span>Sampai Tanggal</span>
                                </label>
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                        <i class="ti ti-calendar-time text-base"></i>
                                    </div>
                                    <input type="date" name="sampai" id="presensi_sampai" value="{{ date('Y-m-t') }}" class="w-full pl-9 pr-4 py-2.5 text-xs sm:text-sm font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="pt-4 mt-6 border-t border-slate-100 flex flex-col sm:flex-row items-center gap-3">
                            <button type="submit" name="submitButton" value="1" class="w-full sm:flex-1 py-2.5 px-5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs sm:text-sm rounded-xl shadow-xs transition inline-flex items-center justify-center gap-2 cursor-pointer active:scale-95">
                                <i class="ti ti-printer text-base"></i>
                                <span>Cetak Laporan Presensi</span>
                            </button>
                            <button type="submit" name="exportButton" value="1" class="w-full sm:w-auto py-2.5 px-5 bg-white hover:bg-emerald-50 text-emerald-700 border border-emerald-300 font-bold text-xs sm:text-sm rounded-xl shadow-2xs transition inline-flex items-center justify-center gap-2 cursor-pointer active:scale-95">
                                <i class="ti ti-file-spreadsheet text-base"></i>
                                <span>Export Excel</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- TAB 2: LAPORAN CHECKLIST IBADAH --}}
            <div id="tab-checklistibadah" class="tab-pane-content hidden bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
                <!-- Header Card -->
                <div class="px-5 py-4 bg-emerald-600 flex items-center justify-between text-white">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-white/20 text-white flex items-center justify-center text-sm font-bold border border-white/20 shadow-2xs">
                            <i class="ti ti-clipboard-check"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-white tracking-tight">Form Cetak Laporan Checklist Ibadah</h3>
                            <p class="text-[11px] text-emerald-100 font-medium">Rekapitulasi pelaksanaan ibadah wajib dan sunnah karyawan</p>
                        </div>
                    </div>
                </div>

                <!-- Form Body -->
                <div class="p-5 sm:p-6">
                    <form action="{{ route('laporanmsdm.cetakchecklistibadah') }}" method="POST" target="_blank" class="space-y-4" id="formChecklistIbadah">
                        @csrf
                        
                        <!-- Filter Unit & Karyawan -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Unit Filter -->
                            <div class="space-y-1.5">
                                <label for="ibadah_kode_unit" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                                    <i class="ti ti-building text-sm text-slate-400"></i>
                                    <span>Unit Kerja <span class="text-slate-400 font-normal text-[11px]">(Opsional)</span></span>
                                </label>
                                @if (auth()->user()->kode_unit != 'U06')
                                    <input type="hidden" name="kode_unit" id="ibadah_kode_unit" value="{{ auth()->user()->kode_unit }}">
                                    <div class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm font-semibold text-slate-700 flex items-center gap-2">
                                        <i class="ti ti-lock text-slate-400"></i>
                                        <span>{{ textUpperCase(auth()->user()->unit->nama_unit ?? 'Unit Anda') }}</span>
                                    </div>
                                @else
                                    <div class="relative">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                            <i class="ti ti-building text-base"></i>
                                        </div>
                                        <select name="kode_unit" id="ibadah_kode_unit" class="select-unit w-full pl-9 pr-8 py-2.5 text-xs sm:text-sm font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                                            <option value="">Semua Unit</option>
                                            @foreach ($unit as $d)
                                                <option value="{{ $d->kode_unit }}">{{ textUpperCase($d->nama_unit) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                            </div>

                            <!-- Karyawan Filter -->
                            <div class="space-y-1.5">
                                <label for="ibadah_npp" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                                    <i class="ti ti-user text-sm text-slate-400"></i>
                                    <span>Karyawan <span class="text-slate-400 font-normal text-[11px]">(Opsional)</span></span>
                                </label>
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                        <i class="ti ti-user text-base"></i>
                                    </div>
                                    <select name="npp" id="ibadah_npp" class="w-full pl-9 pr-8 py-2.5 text-xs sm:text-sm font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                                        <option value="">Semua Karyawan</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Pilihan Tipe Filter Periode -->
                        <div class="pt-1">
                            <label class="block text-xs font-bold text-slate-700 mb-2">Pilihan Filter Waktu</label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="flex items-center gap-2 p-2.5 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50 transition has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50/50">
                                    <input type="radio" name="ibadah_tipe_periode" value="bulan" class="accent-emerald-600 radio-tipe-periode" data-target="#ibadah_container_bulan" data-alt="#ibadah_container_tanggal" checked>
                                    <span class="text-xs font-semibold text-slate-800">Bulanan (Bulan & Tahun)</span>
                                </label>
                                <label class="flex items-center gap-2 p-2.5 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50 transition has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50/50">
                                    <input type="radio" name="ibadah_tipe_periode" value="tanggal" class="accent-emerald-600 radio-tipe-periode" data-target="#ibadah_container_tanggal" data-alt="#ibadah_container_bulan">
                                    <span class="text-xs font-semibold text-slate-800">Rentang Tanggal (Dari - Sampai)</span>
                                </label>
                            </div>
                        </div>

                        <!-- Periode 1: Bulan & Tahun -->
                        <div id="ibadah_container_bulan" class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-1">
                            <!-- Bulan -->
                            <div class="space-y-1.5">
                                <label for="ibadah_bulan" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                                    <i class="ti ti-calendar text-sm text-slate-400"></i>
                                    <span>Bulan</span>
                                </label>
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                        <i class="ti ti-calendar text-base"></i>
                                    </div>
                                    <select name="bulan" id="ibadah_bulan" class="w-full pl-9 pr-8 py-2.5 text-xs sm:text-sm font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                                        <option value="">-- Pilih Bulan --</option>
                                        @foreach ($list_bulan as $d)
                                            <option {{ date('m') == $d['kode_bulan'] ? 'selected' : '' }} value="{{ $d['kode_bulan'] }}">
                                                {{ $d['nama_bulan'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Tahun -->
                            <div class="space-y-1.5">
                                <label for="ibadah_tahun" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                                    <i class="ti ti-calendar-event text-sm text-slate-400"></i>
                                    <span>Tahun</span>
                                </label>
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                        <i class="ti ti-calendar-event text-base"></i>
                                    </div>
                                    <select name="tahun" id="ibadah_tahun" class="w-full pl-9 pr-8 py-2.5 text-xs sm:text-sm font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                                        <option value="">-- Pilih Tahun --</option>
                                        @for ($t = $start_year; $t <= date('Y'); $t++)
                                            <option {{ date('Y') == $t ? 'selected' : '' }} value="{{ $t }}">{{ $t }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Periode 2: Rentang Tanggal (Custom Date Range) -->
                        <div id="ibadah_container_tanggal" class="hidden grid grid-cols-1 sm:grid-cols-2 gap-4 pt-1">
                            <!-- Dari Tanggal -->
                            <div class="space-y-1.5">
                                <label for="ibadah_dari" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                                    <i class="ti ti-calendar-time text-sm text-slate-400"></i>
                                    <span>Dari Tanggal</span>
                                </label>
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                        <i class="ti ti-calendar-time text-base"></i>
                                    </div>
                                    <input type="date" name="dari" id="ibadah_dari" value="{{ date('Y-m-01') }}" class="w-full pl-9 pr-4 py-2.5 text-xs sm:text-sm font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                                </div>
                            </div>

                            <!-- Sampai Tanggal -->
                            <div class="space-y-1.5">
                                <label for="ibadah_sampai" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                                    <i class="ti ti-calendar-time text-sm text-slate-400"></i>
                                    <span>Sampai Tanggal</span>
                                </label>
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                        <i class="ti ti-calendar-time text-base"></i>
                                    </div>
                                    <input type="date" name="sampai" id="ibadah_sampai" value="{{ date('Y-m-t') }}" class="w-full pl-9 pr-4 py-2.5 text-xs sm:text-sm font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="pt-4 mt-6 border-t border-slate-100 flex flex-col sm:flex-row items-center gap-3">
                            <button type="submit" name="submitButton" value="1" class="w-full sm:flex-1 py-2.5 px-5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs sm:text-sm rounded-xl shadow-xs transition inline-flex items-center justify-center gap-2 cursor-pointer active:scale-95">
                                <i class="ti ti-printer text-base"></i>
                                <span>Cetak Rekap Checklist Ibadah</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('myscript')
<script>
    $(document).ready(function() {
        // Tab switching logic with smooth transition
        $('.tab-btn').on('click', function() {
            var targetId = $(this).data('target');

            $('.tab-btn').removeClass('active bg-emerald-50/70 text-emerald-800 border-emerald-200');
            $('.tab-btn .tab-icon').removeClass('bg-emerald-100 text-emerald-700').addClass('bg-slate-100 text-slate-500');

            $(this).addClass('active bg-emerald-50/70 text-emerald-800');
            $(this).find('.tab-icon').removeClass('bg-slate-100 text-slate-500').addClass('bg-emerald-100 text-emerald-700');

            // Show target pane
            $('.tab-pane-content').addClass('hidden');
            $(targetId).removeClass('hidden');
        });

        // Initialize active tab styling
        $('.tab-btn.active').addClass('bg-emerald-50/70 text-emerald-800');

        // Disable inputs di container tersembunyi pada page load
        // (Rentang Tanggal container hidden by default, jadi disable inputnya)
        $('#presensi_container_tanggal').find('input').prop('disabled', true);
        $('#ibadah_container_tanggal').find('input').prop('disabled', true);

        // Toggle antara Filter Bulanan vs Rentang Tanggal
        $('.radio-tipe-periode').on('change', function() {
            var target = $(this).data('target');
            var alt = $(this).data('alt');

            $(alt).addClass('hidden');
            $(target).removeClass('hidden');

            // Disable inputs di container tersembunyi agar tidak terkirim ke server
            $(alt).find('select, input').prop('disabled', true);
            $(target).find('select, input').prop('disabled', false);

            // Kosongkan value select di container yang disembunyikan
            if ($(this).val() === 'tanggal') {
                $(alt).find('select').val('');
            }
        });

        // Helper to load karyawan dynamically based on selected unit
        function setupKaryawanLoader(unitSelector, nppSelector) {
            let $unit = $(unitSelector);
            let $npp = $(nppSelector);

            function load(kodeUnit) {
                $npp.empty().append('<option value="">Semua Karyawan</option>');

                if (kodeUnit) {
                    $npp.prop('disabled', true);
                    $npp.html('<option value="">Memuat data karyawan...</option>');

                    $.ajax({
                        url: '{{ route("karyawan.get-by-unit") }}',
                        method: 'GET',
                        data: { kode_unit: kodeUnit },
                        success: function(res) {
                            $npp.prop('disabled', false);
                            $npp.empty().append('<option value="">Semua Karyawan</option>');

                            if (res.success && res.data.length > 0) {
                                $.each(res.data, function(idx, k) {
                                    $npp.append(
                                        $('<option></option>')
                                            .attr('value', k.npp)
                                            .text(k.nama + (k.jabatan ? ' - ' + k.jabatan : ''))
                                    );
                                });
                            }
                        },
                        error: function() {
                            $npp.prop('disabled', false);
                            $npp.empty().append('<option value="">Gagal memuat karyawan</option>');
                        }
                    });
                } else {
                    $npp.prop('disabled', false);
                }
            }

            $unit.on('change', function() {
                load($(this).val());
            });

            // Trigger on initial load if pre-selected or locked to user's unit
            let initialUnit = $unit.val();
            if (initialUnit) {
                load(initialUnit);
            }
        }

        // Setup loaders for both tabs
        setupKaryawanLoader('#presensi_kode_unit', '#presensi_npp');
        setupKaryawanLoader('#ibadah_kode_unit', '#ibadah_npp');
    });
</script>
@endpush

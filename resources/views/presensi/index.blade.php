@extends('layouts.app')
@section('titlepage', 'Monitoring Presensi')

@section('content')
@php
    $selectedTanggal = Request('tanggal', date('Y-m-d'));
    
    // Calculate Attendance Statistics
    $hadirCount = 0;
    $izinCount = 0;
    $sakitCount = 0;
    $alphaCount = 0;
    $terlambatCount = 0;

    foreach ($karyawan as $item) {
        $st = strtolower($item->status ?? '');
        if ($st === 'h') {
            $hadirCount++;
            if (!empty($item->jam_in) && !empty($item->jam_masuk)) {
                $jam_masuk_ref = $selectedTanggal . ' ' . $item->jam_masuk;
                $tlt = hitungjamterlambat($item->jam_in, $jam_masuk_ref);
                if ($tlt && ($tlt['menitterlambat'] ?? 0) > 0) {
                    $terlambatCount++;
                }
            }
        } elseif ($st === 'i' || $st === 'c') {
            $izinCount++;
        } elseif ($st === 's') {
            $sakitCount++;
        } elseif ($st === 'a') {
            $alphaCount++;
        }
    }
@endphp

<div class="space-y-6">

    <!-- ================= 1. PAGE HEADER & BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <!-- Title & Subtitle -->
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-xl shrink-0 font-bold border border-emerald-200 shadow-2xs">
                <i class="ti ti-fingerprint"></i>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">
                    Monitoring Presensi
                </h1>
                <p class="text-xs text-slate-500 font-medium">
                    Monitoring log absensi harian, jam masuk & pulang, integrasi mesin biometrik, dan status kehadiran
                </p>
            </div>
        </div>

        <!-- Breadcrumb & Actions -->
        <div class="flex flex-col md:items-end gap-2.5">
            <nav class="flex items-center text-xs text-slate-400 font-medium">
                <a href="{{ route('dashboard.index') }}" class="hover:text-slate-700 transition flex items-center gap-1">
                    <i class="ti ti-home text-sm"></i>
                    <span>Dashboard</span>
                </a>
                <span class="mx-2 text-slate-300">/</span>
                <span class="text-slate-500">MSDM & Layanan</span>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Monitoring Presensi</span>
            </nav>

            <div class="flex flex-wrap items-center gap-2">
                @can('izinabsen.index')
                    <a href="{{ route('izinabsen.index') }}" 
                       class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-white hover:bg-slate-50 text-slate-700 font-semibold rounded-lg text-xs border border-slate-200 shadow-2xs transition active:scale-95 cursor-pointer">
                        <i class="ti ti-calendar-minus text-sm text-emerald-600"></i>
                        <span>Pengajuan Izin/Absen</span>
                    </a>
                @endcan
                <a href="{{ route('laporanmsdm.index') }}" 
                   class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-white hover:bg-slate-50 text-slate-700 font-semibold rounded-lg text-xs border border-slate-200 shadow-2xs transition active:scale-95 cursor-pointer">
                    <i class="ti ti-file-text text-sm text-emerald-600"></i>
                    <span>Rekap Laporan</span>
                </a>
            </div>
        </div>
    </div>

    <!-- ================= 2. EXECUTIVE STATISTICS SUMMARY (UNIFIED EMERALD CANVAS) ================= -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-emerald-800 via-emerald-700 to-teal-700 p-5 sm:p-6 text-white shadow-lg shadow-emerald-900/15 border border-emerald-600/30">
        <!-- Ambient Decorative Elements -->
        <div class="absolute -right-10 -bottom-10 w-48 h-48 rounded-full bg-white/5 blur-2xl pointer-events-none"></div>
        <div class="absolute right-8 top-1/2 -translate-y-1/2 opacity-10 pointer-events-none">
            <i class="ti ti-fingerprint text-9xl"></i>
        </div>

        <div class="relative z-10 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-y-6 sm:gap-y-4">
            
            <!-- Segment 1: Total Karyawan -->
            <div class="flex items-center gap-3.5 pr-2">
                <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-white/10 backdrop-blur-md flex items-center justify-center text-white shrink-0 border border-white/20 shadow-inner">
                    <i class="ti ti-users text-lg sm:text-xl"></i>
                </div>
                <div class="min-w-0">
                    <div class="text-[11px] font-semibold text-emerald-200/80 uppercase tracking-wider truncate">Total Karyawan</div>
                    <div class="text-xl sm:text-2xl font-black text-white tracking-tight leading-tight mt-0.5">{{ $karyawan->total() }}</div>
                    <div class="text-[10px] text-emerald-100/70 font-medium flex items-center gap-1 mt-0.5 truncate">
                        <i class="ti ti-calendar text-[11px]"></i>
                        <span>{{ DateToIndo($selectedTanggal) }}</span>
                    </div>
                </div>
            </div>

            <!-- Divider 1 -->
            <div class="hidden sm:block w-[1px] bg-gradient-to-b from-transparent via-white/35 to-transparent self-center h-14 shrink-0 mx-auto"></div>

            <!-- Segment 2: Hadir (Masuk) -->
            <div class="flex items-center gap-3.5 px-2">
                <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-white/10 backdrop-blur-md flex items-center justify-center text-white shrink-0 border border-white/20 shadow-inner">
                    <i class="ti ti-circle-check text-lg sm:text-xl text-emerald-300"></i>
                </div>
                <div class="min-w-0">
                    <div class="text-[11px] font-semibold text-emerald-200/80 uppercase tracking-wider truncate">Hadir (Masuk)</div>
                    <div class="text-xl sm:text-2xl font-black text-white tracking-tight leading-tight mt-0.5">{{ $hadirCount }}</div>
                    <div class="text-[10px] text-emerald-100/70 font-medium flex items-center gap-1 mt-0.5 truncate">
                        <i class="ti ti-chart-pie text-[11px]"></i>
                        <span>{{ count($karyawan) > 0 ? round(($hadirCount / count($karyawan)) * 100) : 0 }}% tingkat hadir</span>
                    </div>
                </div>
            </div>

            <!-- Divider 2 -->
            <div class="hidden lg:block w-[1px] bg-gradient-to-b from-transparent via-white/35 to-transparent self-center h-14 shrink-0 mx-auto"></div>

            <!-- Segment 3: Terlambat -->
            <div class="flex items-center gap-3.5 px-2">
                <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-white/10 backdrop-blur-md flex items-center justify-center text-white shrink-0 border border-white/20 shadow-inner">
                    <i class="ti ti-clock-exclamation text-lg sm:text-xl text-rose-300"></i>
                </div>
                <div class="min-w-0">
                    <div class="text-[11px] font-semibold text-emerald-200/80 uppercase tracking-wider truncate">Terlambat</div>
                    <div class="text-xl sm:text-2xl font-black text-white tracking-tight leading-tight mt-0.5">{{ $terlambatCount }}</div>
                    <div class="text-[10px] text-emerald-100/70 font-medium flex items-center gap-1 mt-0.5 truncate">
                        <i class="ti ti-alert-triangle text-[11px] text-rose-200"></i>
                        <span>Check-in melebihi jadwal</span>
                    </div>
                </div>
            </div>

            <!-- Divider 3 -->
            <div class="hidden sm:block w-[1px] bg-gradient-to-b from-transparent via-white/35 to-transparent self-center h-14 shrink-0 mx-auto"></div>

            <!-- Segment 4: Izin / Cuti -->
            <div class="flex items-center gap-3.5 px-2">
                <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-white/10 backdrop-blur-md flex items-center justify-center text-white shrink-0 border border-white/20 shadow-inner">
                    <i class="ti ti-info-circle text-lg sm:text-xl text-amber-300"></i>
                </div>
                <div class="min-w-0">
                    <div class="text-[11px] font-semibold text-emerald-200/80 uppercase tracking-wider truncate">Izin / Cuti</div>
                    <div class="text-xl sm:text-2xl font-black text-white tracking-tight leading-tight mt-0.5">{{ $izinCount }}</div>
                    <div class="text-[10px] text-emerald-100/70 font-medium flex items-center gap-1 mt-0.5 truncate">
                        <i class="ti ti-clipboard-check text-[11px]"></i>
                        <span>Tercatat disetujui</span>
                    </div>
                </div>
            </div>

            <!-- Divider 4 -->
            <div class="hidden lg:block w-[1px] bg-gradient-to-b from-transparent via-white/35 to-transparent self-center h-14 shrink-0 mx-auto"></div>

            <!-- Segment 5: Sakit -->
            <div class="flex items-center gap-3.5 pl-2">
                <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-white/10 backdrop-blur-md flex items-center justify-center text-white shrink-0 border border-white/20 shadow-inner">
                    <i class="ti ti-medical-cross text-lg sm:text-xl text-blue-300"></i>
                </div>
                <div class="min-w-0">
                    <div class="text-[11px] font-semibold text-emerald-200/80 uppercase tracking-wider truncate">Sakit</div>
                    <div class="text-xl sm:text-2xl font-black text-white tracking-tight leading-tight mt-0.5">{{ $sakitCount }}</div>
                    <div class="text-[10px] text-emerald-100/70 font-medium flex items-center gap-1 mt-0.5 truncate">
                        <i class="ti ti-file-certificate text-[11px]"></i>
                        <span>Surat dokter</span>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- ================= 3. CONSISTENT HORIZONTAL FILTER TOOLBAR ================= -->
    <form action="{{ route('presensi.index') }}" method="GET" class="w-full">
        <div class="flex flex-col sm:flex-row gap-2.5 sm:gap-3 w-full">
            
            <!-- Tanggal Input -->
            <div class="w-full sm:w-52 relative">
                <i class="ti ti-calendar absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-lg pointer-events-none"></i>
                <input type="text" 
                       name="tanggal" 
                       value="{{ Request('tanggal', date('Y-m-d')) }}" 
                       placeholder="Pilih Tanggal..." 
                       class="flatpickr-date w-full pl-11 pr-4 py-2.5 sm:py-3 text-sm bg-white border border-slate-300/90 rounded-xl text-slate-800 font-medium placeholder-slate-400 shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
            </div>

            <!-- Unit Kerja Dropdown -->
            <div class="w-full sm:w-60 relative">
                <select name="kode_unit" 
                        id="kode_unit" 
                        class="select2Kodeunit w-full py-2.5 sm:py-3 text-sm bg-white border border-slate-300/90 rounded-xl text-slate-800 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                    <option value="">Semua Unit Kerja</option>
                    @foreach ($unit as $u)
                        <option value="{{ $u->kode_unit }}" {{ Request('kode_unit') == $u->kode_unit ? 'selected' : '' }}>
                            {{ strtoupper($u->nama_unit) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Search Nama / NPP -->
            <div class="flex-1 min-w-0 w-full relative">
                <i class="ti ti-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-lg pointer-events-none"></i>
                <input type="text" 
                       name="nama_karyawan" 
                       value="{{ Request('nama_karyawan') }}" 
                       placeholder="Cari Nama Karyawan atau NPP..." 
                       class="w-full pl-11 pr-4 py-2.5 sm:py-3 text-sm bg-white border border-slate-300/90 rounded-xl text-slate-800 font-medium placeholder-slate-400 shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2 shrink-0 w-full sm:w-auto">
                <button type="submit" class="w-full sm:w-auto px-5 py-2.5 sm:py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl shadow-xs transition inline-flex items-center justify-center gap-2 cursor-pointer active:scale-95 whitespace-nowrap">
                    <i class="ti ti-search text-base"></i>
                    <span>Cari</span>
                </button>
                @if(Request('tanggal') || Request('kode_unit') || Request('nama_karyawan'))
                    <a href="{{ route('presensi.index') }}" class="py-2.5 sm:py-3 px-3 bg-white hover:bg-slate-100 text-slate-600 border border-slate-300/90 rounded-xl font-semibold text-sm transition inline-flex items-center justify-center shrink-0 shadow-xs cursor-pointer" title="Reset Pencarian">
                        <i class="ti ti-refresh text-base"></i>
                    </a>
                @endif
            </div>

        </div>
    </form>

    <!-- ================= 4. DATA TABLE (SOLID GREEN HEADER) ================= -->
    <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
        
        <!-- Table Header Bar -->
        <div class="px-5 py-3.5 bg-emerald-600 flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-white">
            <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-lg bg-white/20 text-white flex items-center justify-center text-xs font-bold border border-white/20 shadow-2xs">
                    <i class="ti ti-list"></i>
                </div>
                <h3 class="text-sm font-bold text-white tracking-tight">Daftar Kehadiran Karyawan</h3>
                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-white/20 text-white border border-white/30">
                    {{ $karyawan->total() }} total data
                </span>
            </div>

            <div class="text-xs text-emerald-100 font-medium">
                Tanggal: <span class="font-bold text-white">{{ DateToIndo($selectedTanggal) }}</span>
            </div>
        </div>

        <!-- Responsive Table -->
        <div class="overflow-x-auto bg-emerald-600">
            <table class="w-full text-left text-xs sm:text-sm border-0 border-collapse whitespace-nowrap">
                <thead class="bg-emerald-600 text-white font-bold uppercase tracking-wider text-[11px] border-0 border-t border-b border-emerald-700/80">
                    <tr class="border-0">
                        <th class="py-3 px-3.5 w-12 text-center text-emerald-100 whitespace-nowrap">#</th>
                        <th class="py-3 px-3.5 text-emerald-100 whitespace-nowrap">Karyawan</th>
                        <th class="py-3 px-3.5 text-emerald-100 whitespace-nowrap">Jadwal Kerja</th>
                        <th class="py-3 px-3.5 text-emerald-100 whitespace-nowrap">Scan Masuk (IN)</th>
                        <th class="py-3 px-3.5 text-emerald-100 whitespace-nowrap">Scan Pulang (OUT)</th>
                        <th class="py-3 px-3.5 text-center text-emerald-100 whitespace-nowrap">Status</th>
                        <th class="py-3 px-3.5 text-center w-28 text-emerald-100 whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700 font-medium bg-white text-xs">
                    @forelse ($karyawan as $d)
                        @php
                            $tanggal_presensi = Request('tanggal', date('Y-m-d'));
                            $jam_masuk_ref = $tanggal_presensi . ' ' . $d->jam_masuk;
                            $terlambat = hitungjamterlambat($d->jam_in, $jam_masuk_ref);
                            $st = strtolower($d->status ?? '');
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            
                            <!-- No -->
                            <td class="py-3 px-3.5 text-center font-bold text-slate-500 whitespace-nowrap">
                                {{ $loop->iteration + $karyawan->firstItem() - 1 }}
                            </td>

                            <!-- Karyawan Info -->
                            <td class="py-3 px-3.5 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-200/80 flex items-center justify-center font-bold text-xs shrink-0 shadow-2xs">
                                        {{ strtoupper(substr($d->nama_lengkap, 0, 1)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <div class="font-bold text-slate-900 text-xs sm:text-sm truncate" title="{{ $d->nama_lengkap }}">
                                            {{ $d->nama_lengkap }}
                                        </div>
                                        <div class="flex items-center gap-2 text-[11px] text-slate-500 mt-0.5">
                                            <span class="font-mono font-semibold text-slate-700">{{ $d->npp }}</span>
                                            <span>•</span>
                                            <span>{{ $d->nama_jabatan ?: ($d->nama_unit ?: '-') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Jadwal Kerja -->
                            <td class="py-3 px-3.5 whitespace-nowrap">
                                @if($d->nama_jam_kerja)
                                    <div class="font-semibold text-slate-800 text-xs">
                                        {{ $d->nama_jam_kerja }}
                                    </div>
                                    <div class="text-[11px] text-slate-400 font-mono mt-0.5">
                                        {{ substr($d->jam_masuk, 0, 5) }} - {{ substr($d->jam_pulang, 0, 5) }}
                                    </div>
                                @else
                                    <span class="text-slate-400 text-xs">-</span>
                                @endif
                            </td>

                            <!-- Scan Masuk (IN) -->
                            <td class="py-3 px-3.5 whitespace-nowrap">
                                @if($d->jam_in)
                                    <div class="flex items-center gap-2">
                                        <button type="button" 
                                                class="btnShowpresensi_in inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-200/80 text-xs font-bold transition active:scale-95 cursor-pointer shadow-2xs"
                                                id="{{ $d->id }}" 
                                                status="in"
                                                title="Lihat Foto & Lokasi Masuk">
                                            <i class="ti ti-login-2 text-sm text-emerald-600"></i>
                                            <span>{{ date('H:i', strtotime($d->jam_in)) }}</span>
                                        </button>
                                        
                                        @if($terlambat && ($terlambat['menitterlambat'] ?? 0) > 0)
                                            <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                                Telat {{ $terlambat['menitterlambat'] }}m
                                            </span>
                                        @else
                                            <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                Tepat Waktu
                                            </span>
                                        @endif
                                    </div>
                                @else
                                    <span class="inline-flex items-center gap-1 text-slate-400 text-xs font-mono">
                                        <i class="ti ti-minus"></i>
                                        <span>--:--</span>
                                    </span>
                                @endif
                            </td>

                            <!-- Scan Pulang (OUT) -->
                            <td class="py-3 px-3.5 whitespace-nowrap">
                                @if($d->jam_out)
                                    <button type="button" 
                                            class="btnShowpresensi_in inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-800 border border-blue-200/80 text-xs font-bold transition active:scale-95 cursor-pointer shadow-2xs"
                                            id="{{ $d->id }}" 
                                            status="out"
                                            title="Lihat Foto & Lokasi Pulang">
                                        <i class="ti ti-logout-2 text-sm text-blue-600"></i>
                                        <span>{{ date('H:i', strtotime($d->jam_out)) }}</span>
                                    </button>
                                @else
                                    <span class="inline-flex items-center gap-1 text-slate-400 text-xs font-mono">
                                        <i class="ti ti-minus"></i>
                                        <span>--:--</span>
                                    </span>
                                @endif
                            </td>

                            <!-- Status Kehadiran -->
                            <td class="py-3 px-3.5 text-center whitespace-nowrap">
                                @if($st === 'h')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        <span>Hadir</span>
                                    </span>
                                @elseif($st === 'i')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        <span>Izin</span>
                                    </span>
                                @elseif($st === 's')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                        <span>Sakit</span>
                                    </span>
                                @elseif($st === 'c')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-cyan-50 text-cyan-700 border border-cyan-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-cyan-500"></span>
                                        <span>Cuti</span>
                                    </span>
                                @elseif($st === 'a')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                        <span>Alpha</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-medium bg-slate-100 text-slate-600 border border-slate-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                        <span>Belum Absen</span>
                                    </span>
                                @endif
                            </td>

                            <!-- Aksi -->
                            <td class="py-3 px-3.5 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-1.5">
                                    
                                    <!-- Koreksi Presensi -->
                                    <button type="button" 
                                            class="koreksiPresensi w-7 h-7 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200/80 flex items-center justify-center transition active:scale-95 cursor-pointer shadow-2xs" 
                                            npp="{{ Crypt::encrypt($d->npp) }}" 
                                            tanggal="{{ $selectedTanggal }}" 
                                            title="Koreksi Presensi">
                                        <i class="ti ti-edit text-xs"></i>
                                    </button>

                                    <!-- Data Mesin Fingerspot -->
                                    <button type="button" 
                                            class="btngetDatamesin w-7 h-7 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200/80 flex items-center justify-center transition active:scale-95 cursor-pointer shadow-2xs" 
                                            pin="{{ $d->pin }}" 
                                            tanggal="{{ $selectedTanggal }}" 
                                            title="Cek Log Mesin Biometrik">
                                        <i class="ti ti-device-desktop-analytics text-xs"></i>
                                    </button>

                                    <!-- Hapus Presensi -->
                                    @if($d->id)
                                        <form action="{{ route('presensi.delete', $d->id) }}" method="POST" class="formDeletePresensi m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" 
                                                    class="btnDeletePresensi w-7 h-7 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200/80 flex items-center justify-center transition active:scale-95 cursor-pointer shadow-2xs" 
                                                    title="Hapus Presensi Hari Ini">
                                                <i class="ti ti-trash text-xs"></i>
                                            </button>
                                        </form>
                                    @endif

                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400 text-xs">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center text-xl">
                                        <i class="ti ti-fingerprint-off"></i>
                                    </div>
                                    <span class="font-bold text-slate-600">Tidak ada data karyawan / presensi ditemukan</span>
                                    <span class="text-[11px] text-slate-400">Silakan sesuaikan tanggal atau kriteria pencarian Anda.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination & Footer -->
        <div class="px-5 py-4 bg-slate-50 border-t border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs text-slate-500">
            <div>
                Menampilkan <strong class="text-slate-800">{{ $karyawan->firstItem() ?? 0 }}</strong> - <strong class="text-slate-800">{{ $karyawan->lastItem() ?? 0 }}</strong> dari <strong class="text-slate-800">{{ $karyawan->total() }}</strong> karyawan
            </div>
            <div>
                {{ $karyawan->links() }}
            </div>
        </div>

    </div>

</div>

<!-- Modal Form Component -->
<x-modal-form id="modal" size="modal-lg" show="loadmodal" title="" />
@endsection

@push('myscript')
<script>
    $(function() {
        const loadingSpinner = `
            <div class="flex items-center justify-center p-8">
                <div class="w-8 h-8 border-4 border-emerald-600 border-t-transparent rounded-full animate-spin"></div>
            </div>
        `;

        $(".flatpickr-date").flatpickr({
            dateFormat: "Y-m-d",
            allowInput: true
        });

        // Koreksi Presensi Modal
        $(document).on('click', '.koreksiPresensi', function(e) {
            e.preventDefault();
            let npp = $(this).attr('npp');
            let tanggal = $(this).attr('tanggal');
            
            $('#modal').modal('show');
            $('#modal').find('.modal-title').text('Koreksi Presensi Karyawan');
            $('#loadmodal').html(loadingSpinner);

            $.ajax({
                type: 'POST',
                url: "{{ route('presensi.edit') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    npp: npp,
                    tanggal: tanggal
                },
                cache: false,
                success: function(res) {
                    $('#loadmodal').html(res);
                },
                error: function() {
                    $('#loadmodal').html('<div class="p-4 text-center text-rose-600 text-xs">Gagal memuat data koreksi.</div>');
                }
            });
        });

        // Detail Presensi (Foto In & Out)
        $(document).on('click', '.btnShowpresensi_in, .btnShowpresensi_out', function(e) {
            e.preventDefault();
            const id = $(this).attr("id");
            const status = $(this).attr("status");
            
            $("#modal").modal("show");
            $("#modal").find(".modal-title").text("Detail Presensi & Lokasi (" + (status === 'in' ? 'Masuk' : 'Pulang') + ")");
            $("#loadmodal").html(loadingSpinner);
            $("#loadmodal").load(`/presensi/${id}/${status}/show`);
        });

        // Data Mesin Fingerspot
        $(document).on('click', '.btngetDatamesin', function(e) {
            e.preventDefault();
            var pin = $(this).attr("pin");
            var tanggal = $(this).attr("tanggal");

            $("#modal").modal("show");
            $("#modal").find(".modal-title").text("Log Data Mesin Biometrik");
            $("#loadmodal").html(loadingSpinner);

            $.ajax({
                type: 'POST',
                url: '/presensi/getdatamesin',
                data: {
                    _token: "{{ csrf_token() }}",
                    pin: pin,
                    tanggal: tanggal
                },
                cache: false,
                success: function(respond) {
                    $("#loadmodal").html(respond);
                },
                error: function() {
                    $("#loadmodal").html('<div class="p-4 text-center text-rose-600 text-xs">Gagal mengambil data mesin biometrik.</div>');
                }
            });
        });

        // Hapus Presensi Confirmation
        $(document).on('click', '.btnDeletePresensi', function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            Swal.fire({
                title: 'Hapus Data Presensi?',
                text: "Rekam kehadiran karyawan ini pada tanggal yang dipilih akan dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#064e3b',
                cancelButtonColor: '#e11d48',
                confirmButtonText: 'Ya, Hapus!',
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

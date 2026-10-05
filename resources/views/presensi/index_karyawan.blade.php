@extends('layouts.app')
@section('titlepage', 'Presensi & Absensi Saya')

@section('content')
<div class="space-y-6">

    <!-- ================= 1. PAGE HEADER & BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <!-- Title & Subtitle -->
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-xl shrink-0 font-bold border border-emerald-200 shadow-2xs">
                <i class="ti ti-device-watch-stats"></i>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">
                    Presensi & Absensi Saya
                </h1>
                <p class="text-xs text-slate-500 font-medium">
                    Histori kehadiran bulanan, scan jam masuk & pulang, foto log biometrik, serta status keterlambatan Anda
                </p>
            </div>
        </div>

        <!-- Breadcrumb & Quick Actions -->
        <div class="flex flex-col md:items-end gap-2.5">
            <nav class="flex items-center text-xs text-slate-400 font-medium">
                <a href="{{ route('dashboard.index') }}" class="hover:text-slate-700 transition flex items-center gap-1">
                    <i class="ti ti-home text-sm"></i>
                    <span>Dashboard</span>
                </a>
                <span class="mx-2 text-slate-300">/</span>
                <span class="text-slate-500">MSDM & Layanan</span>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Presensi & Absensi</span>
            </nav>

            <div class="flex items-center gap-2">
                @can('izinabsen.index')
                    <a href="{{ route('izinabsen.index') }}" 
                       class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-white hover:bg-slate-50 text-slate-700 font-semibold rounded-lg text-xs border border-slate-200 shadow-2xs transition active:scale-95 cursor-pointer">
                        <i class="ti ti-calendar-minus text-sm text-emerald-600"></i>
                        <span>Pengajuan Izin/Absen</span>
                    </a>
                @endcan
            </div>
        </div>
    </div>

    <!-- ================= 2. EMPLOYEE EXECUTIVE SHOWCASE BANNER ================= -->
    @if(!empty($karyawan))
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-emerald-800 via-emerald-700 to-teal-700 p-5 sm:p-6 text-white shadow-lg shadow-emerald-900/15 border border-emerald-600/30">
            <!-- Decorative Glow & Watermark -->
            <div class="absolute -right-10 -bottom-10 w-48 h-48 rounded-full bg-white/5 blur-2xl pointer-events-none"></div>
            <div class="absolute right-8 top-1/2 -translate-y-1/2 opacity-10 pointer-events-none">
                <i class="ti ti-fingerprint text-9xl"></i>
            </div>

            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                <!-- User Identity -->
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-white/10 backdrop-blur-md p-1 border border-white/25 shadow-inner flex items-center justify-center shrink-0 overflow-hidden">
                        @if (!empty($karyawan->foto) && file_exists(public_path('storage/' . $karyawan->foto)))
                            <img src="{{ asset('storage/' . $karyawan->foto) }}" alt="Foto" class="w-full h-full object-cover rounded-xl">
                        @else
                            <div class="w-full h-full rounded-xl bg-emerald-600/50 flex items-center justify-center text-white font-extrabold text-xl">
                                {{ strtoupper(substr($karyawan->nama_lengkap ?? 'U', 0, 2)) }}
                            </div>
                        @endif
                    </div>
                    <div class="min-w-0">
                        <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-500/30 border border-emerald-400/30 text-[10px] font-bold text-emerald-200 uppercase tracking-wider mb-1">
                            <i class="ti ti-id-badge text-xs"></i>
                            <span>Rekap Presensi Karyawan</span>
                        </div>
                        <h2 class="text-lg sm:text-xl font-black text-white tracking-tight leading-tight truncate">
                            {{ $karyawan->nama_lengkap }}
                        </h2>
                        <div class="flex items-center gap-2 mt-0.5 text-xs text-emerald-100/80 font-medium">
                            <span>NPP: <b class="text-white font-mono">{{ $karyawan->npp }}</b></span>
                        </div>
                    </div>
                </div>

                <!-- Position Badges with Floating Vertical Dividers -->
                <div class="flex flex-wrap items-center gap-3 sm:gap-4">
                    <!-- Jabatan -->
                    <div class="flex items-center gap-3 px-3.5 py-2 rounded-xl bg-white/10 backdrop-blur-md border border-white/15">
                        <div class="w-8 h-8 rounded-lg bg-emerald-500/20 text-emerald-300 flex items-center justify-center shrink-0">
                            <i class="ti ti-briefcase text-base"></i>
                        </div>
                        <div class="min-w-0">
                            <span class="block text-[9px] font-bold uppercase tracking-wider text-emerald-200/75">Jabatan</span>
                            <span class="block text-xs font-bold text-white truncate">{{ strtoupper($karyawan->nama_jabatan) }}</span>
                        </div>
                    </div>

                    <!-- Departemen -->
                    <div class="flex items-center gap-3 px-3.5 py-2 rounded-xl bg-white/10 backdrop-blur-md border border-white/15">
                        <div class="w-8 h-8 rounded-lg bg-teal-500/20 text-teal-300 flex items-center justify-center shrink-0">
                            <i class="ti ti-hierarchy-2 text-base"></i>
                        </div>
                        <div class="min-w-0">
                            <span class="block text-[9px] font-bold uppercase tracking-wider text-emerald-200/75">Departemen</span>
                            <span class="block text-xs font-bold text-white truncate">{{ strtoupper($karyawan->nama_dept) }}</span>
                        </div>
                    </div>

                    <!-- Unit Kerja -->
                    <div class="flex items-center gap-3 px-3.5 py-2 rounded-xl bg-white/10 backdrop-blur-md border border-white/15">
                        <div class="w-8 h-8 rounded-lg bg-emerald-400/20 text-emerald-200 flex items-center justify-center shrink-0">
                            <i class="ti ti-building text-base"></i>
                        </div>
                        <div class="min-w-0">
                            <span class="block text-[9px] font-bold uppercase tracking-wider text-emerald-200/75">Unit Kerja</span>
                            <span class="block text-xs font-bold text-white truncate">{{ strtoupper($karyawan->nama_unit) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- ================= 3. MONTHLY ATTENDANCE STATS (UNIFIED EMERALD CANVAS) ================= -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-emerald-800 via-emerald-700 to-teal-700 p-5 sm:p-6 text-white shadow-lg shadow-emerald-900/15 border border-emerald-600/30">
        <!-- Ambient Background Glow -->
        <div class="absolute -right-8 -bottom-8 w-44 h-44 rounded-full bg-white/5 blur-2xl pointer-events-none"></div>

        <div class="relative z-10 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-y-6 sm:gap-y-4">
            
            <!-- Segment 1: Hadir -->
            <div class="flex items-center gap-3.5 pr-2">
                <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-white/10 backdrop-blur-md flex items-center justify-center text-white shrink-0 border border-white/20 shadow-inner">
                    <i class="ti ti-circle-check text-lg sm:text-xl text-emerald-300"></i>
                </div>
                <div class="min-w-0">
                    <div class="text-[11px] font-semibold text-emerald-200/80 uppercase tracking-wider truncate">Hadir</div>
                    <div class="text-xl sm:text-2xl font-black text-white tracking-tight leading-tight mt-0.5">{{ $stats['hadir'] }}</div>
                    <div class="text-[10px] text-emerald-100/70 font-medium truncate">Hari Masuk</div>
                </div>
            </div>

            <!-- Divider 1 -->
            <div class="hidden sm:block w-[1px] bg-gradient-to-b from-transparent via-white/35 to-transparent self-center h-14 shrink-0 mx-auto"></div>

            <!-- Segment 2: Terlambat -->
            <div class="flex items-center gap-3.5 px-2">
                <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-white/10 backdrop-blur-md flex items-center justify-center text-white shrink-0 border border-white/20 shadow-inner">
                    <i class="ti ti-clock-exclamation text-lg sm:text-xl text-amber-300"></i>
                </div>
                <div class="min-w-0">
                    <div class="text-[11px] font-semibold text-emerald-200/80 uppercase tracking-wider truncate">Terlambat</div>
                    <div class="text-xl sm:text-2xl font-black text-white tracking-tight leading-tight mt-0.5">{{ $stats['terlambat'] }}</div>
                    <div class="text-[10px] text-emerald-100/70 font-medium truncate">Check-in Lewat</div>
                </div>
            </div>

            <!-- Divider 2 -->
            <div class="hidden lg:block w-[1px] bg-gradient-to-b from-transparent via-white/35 to-transparent self-center h-14 shrink-0 mx-auto"></div>

            <!-- Segment 3: Sakit -->
            <div class="flex items-center gap-3.5 px-2">
                <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-white/10 backdrop-blur-md flex items-center justify-center text-white shrink-0 border border-white/20 shadow-inner">
                    <i class="ti ti-medical-cross text-lg sm:text-xl text-blue-300"></i>
                </div>
                <div class="min-w-0">
                    <div class="text-[11px] font-semibold text-emerald-200/80 uppercase tracking-wider truncate">Sakit</div>
                    <div class="text-xl sm:text-2xl font-black text-white tracking-tight leading-tight mt-0.5">{{ $stats['sakit'] }}</div>
                    <div class="text-[10px] text-emerald-100/70 font-medium truncate">Surat Dokter</div>
                </div>
            </div>

            <!-- Divider 3 -->
            <div class="hidden sm:block w-[1px] bg-gradient-to-b from-transparent via-white/35 to-transparent self-center h-14 shrink-0 mx-auto"></div>

            <!-- Segment 4: Izin -->
            <div class="flex items-center gap-3.5 px-2">
                <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-white/10 backdrop-blur-md flex items-center justify-center text-white shrink-0 border border-white/20 shadow-inner">
                    <i class="ti ti-info-circle text-lg sm:text-xl text-teal-300"></i>
                </div>
                <div class="min-w-0">
                    <div class="text-[11px] font-semibold text-emerald-200/80 uppercase tracking-wider truncate">Izin / Cuti</div>
                    <div class="text-xl sm:text-2xl font-black text-white tracking-tight leading-tight mt-0.5">{{ $stats['izin'] }}</div>
                    <div class="text-[10px] text-emerald-100/70 font-medium truncate">Disetujui</div>
                </div>
            </div>

            <!-- Divider 4 -->
            <div class="hidden lg:block w-[1px] bg-gradient-to-b from-transparent via-white/35 to-transparent self-center h-14 shrink-0 mx-auto"></div>

            <!-- Segment 5: Alfa -->
            <div class="flex items-center gap-3.5 pl-2">
                <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-white/10 backdrop-blur-md flex items-center justify-center text-white shrink-0 border border-white/20 shadow-inner">
                    <i class="ti ti-alert-triangle text-lg sm:text-xl text-rose-300"></i>
                </div>
                <div class="min-w-0">
                    <div class="text-[11px] font-semibold text-emerald-200/80 uppercase tracking-wider truncate">Alfa</div>
                    <div class="text-xl sm:text-2xl font-black text-white tracking-tight leading-tight mt-0.5">{{ $stats['alfa'] }}</div>
                    <div class="text-[10px] text-emerald-100/70 font-medium truncate">Tanpa Keterangan</div>
                </div>
            </div>

        </div>
    </div>

    <!-- ================= 4. FILTER TOOLBAR ================= -->
    <div class="bg-white border border-slate-200/80 rounded-2xl p-4 sm:p-5 shadow-xs">
        <form action="{{ route('presensi.absensikaryawan') }}" method="GET" autocomplete="off" class="flex flex-col sm:flex-row items-center justify-between gap-3">
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-base border border-emerald-100 shrink-0">
                    <i class="ti ti-filter"></i>
                </div>
                <span class="text-xs font-bold text-slate-800">Filter Periode Bulan</span>
            </div>

            <div class="flex flex-wrap sm:flex-nowrap items-center gap-2.5 w-full sm:w-auto">
                <!-- Select Bulan -->
                <div class="relative flex-1 sm:w-48">
                    <div class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">
                        <i class="ti ti-calendar text-sm"></i>
                    </div>
                    <select name="bulan" class="w-full bg-slate-50 border border-slate-200/90 rounded-xl py-2 pl-9 pr-8 text-xs font-semibold text-slate-700 outline-none focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 cursor-pointer">
                        @foreach ($list_bulan as $key => $val)
                            <option value="{{ $key }}" {{ $bulan == $key ? 'selected' : '' }}>{{ $val }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Select Tahun -->
                <div class="relative w-28">
                    <div class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">
                        <i class="ti ti-calendar-event text-sm"></i>
                    </div>
                    <select name="tahun" class="w-full bg-slate-50 border border-slate-200/90 rounded-xl py-2 pl-9 pr-8 text-xs font-semibold text-slate-700 outline-none focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 cursor-pointer">
                        @for ($y = date('Y'); $y >= 2020; $y--)
                            <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="py-2 px-4 rounded-xl bg-emerald-700 hover:bg-emerald-800 active:scale-95 text-white font-bold text-xs shadow-sm transition flex items-center justify-center gap-1.5 cursor-pointer shrink-0">
                    <i class="ti ti-search text-sm"></i>
                    <span>Tampilkan</span>
                </button>
            </div>
        </form>
    </div>

    <!-- ================= 5. ATTENDANCE LOG CARDS GRID ================= -->
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-base font-bold">
                    <i class="ti ti-calendar-time"></i>
                </div>
                <h3 class="text-base font-bold text-slate-900 tracking-tight">
                    Catatan Kehadiran Harian ({{ count($presensi) }} Hari)
                </h3>
            </div>
            <span class="text-xs font-semibold text-slate-400">Periode {{ $list_bulan[$bulan] ?? $bulan }} {{ $tahun }}</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5">
            @forelse ($presensi as $key => $d)
                @php
                    $jam_masuk_kerja = $d->jam_masuk;
                    $jam_in_scan = $d->jam_in;
                    $terlambat = '';
                    if ($d->status == 'h' && $jam_masuk_kerja && $jam_in_scan) {
                        $in = strtotime($jam_in_scan);
                        $msk = strtotime($jam_masuk_kerja);
                        if ($in > $msk) {
                            $diff = $in - $msk;
                            $min = round($diff / 60);
                            $terlambat = $min . ' Menit';
                        }
                    }
                    
                    // Status themes
                    $st = strtolower($d->status ?? '');
                    if ($st == 'h') {
                        $badgeBg = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                        $statusLabel = 'HADIR';
                        $statusIcon = 'ti-circle-check';
                    } elseif ($st == 'i' || $st == 'c') {
                        $badgeBg = 'bg-amber-50 text-amber-700 border-amber-200';
                        $statusLabel = 'IZIN / CUTI';
                        $statusIcon = 'ti-info-circle';
                    } elseif ($st == 's') {
                        $badgeBg = 'bg-blue-50 text-blue-700 border-blue-200';
                        $statusLabel = 'SAKIT';
                        $statusIcon = 'ti-medical-cross';
                    } else {
                        $badgeBg = 'bg-rose-50 text-rose-700 border-rose-200';
                        $statusLabel = 'ALFA';
                        $statusIcon = 'ti-alert-triangle';
                    }
                @endphp

                <!-- Attendance Log Card -->
                <div class="bg-white border border-slate-200/80 rounded-2xl p-4 sm:p-5 shadow-xs flex flex-col justify-between transition-all duration-200 hover:shadow-md hover:border-emerald-300">
                    
                    <!-- Top Header -->
                    <div>
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-3">
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 text-[10px] font-black font-mono">
                                    #{{ $key + 1 }}
                                </span>
                                <span class="text-xs sm:text-sm font-bold text-slate-800">
                                    {{ date('d M Y', strtotime($d->tanggal)) }}
                                </span>
                            </div>

                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full {{ $badgeBg }} border text-[10px] font-black tracking-wider uppercase">
                                <i class="ti {{ $statusIcon }} text-xs"></i>
                                <span>{{ $statusLabel }}</span>
                            </span>
                        </div>

                        <!-- Shift / Schedule Info -->
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 space-y-1 mb-3">
                            <div class="flex items-center justify-between text-[11px]">
                                <span class="text-slate-400 font-medium">Jadwal Shift:</span>
                                <span class="font-bold text-slate-800">{{ $d->nama_jam_kerja ?: 'Reguler' }}</span>
                            </div>
                            <div class="flex items-center justify-between text-[11px]">
                                <span class="text-slate-400 font-medium">Jam Kerja:</span>
                                <span class="font-mono font-semibold text-slate-600">
                                    {{ $d->jam_masuk ? substr($d->jam_masuk, 0, 5) : '--:--' }} - {{ $d->jam_pulang ? substr($d->jam_pulang, 0, 5) : '--:--' }}
                                </span>
                            </div>
                        </div>

                        <!-- Scan In & Scan Out Timestamps & Photos -->
                        <div class="grid grid-cols-2 gap-2 pt-1">
                            <!-- Scan Masuk -->
                            <div class="p-2.5 rounded-xl bg-emerald-50/40 border border-emerald-100/70 space-y-1.5">
                                <span class="block text-[10px] font-bold text-emerald-800 uppercase tracking-wider">Scan Masuk</span>
                                <div class="flex items-center gap-2">
                                    @if ($d->foto_in)
                                        @php $foto_in_path = Storage::url('uploads/absensi/' . $d->foto_in); @endphp
                                        <a href="{{ $foto_in_path }}" target="_blank" class="shrink-0 group/img">
                                            <img src="{{ $foto_in_path }}" class="w-8 h-8 rounded-lg object-cover border border-emerald-300 shadow-2xs group-hover/img:scale-110 transition" alt="In">
                                        </a>
                                    @else
                                        <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-400 flex items-center justify-center text-xs shrink-0 border border-slate-200">
                                            <i class="ti ti-camera-off"></i>
                                        </div>
                                    @endif
                                    <span class="font-mono font-bold text-xs {{ $d->jam_in ? 'text-slate-900' : 'text-slate-400' }}">
                                        {{ $d->jam_in ? substr($d->jam_in, 0, 5) : '--:--' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Scan Pulang -->
                            <div class="p-2.5 rounded-xl bg-teal-50/40 border border-teal-100/70 space-y-1.5">
                                <span class="block text-[10px] font-bold text-teal-800 uppercase tracking-wider">Scan Pulang</span>
                                <div class="flex items-center gap-2">
                                    @if ($d->foto_out)
                                        @php $foto_out_path = Storage::url('uploads/absensi/' . $d->foto_out); @endphp
                                        <a href="{{ $foto_out_path }}" target="_blank" class="shrink-0 group/img">
                                            <img src="{{ $foto_out_path }}" class="w-8 h-8 rounded-lg object-cover border border-teal-300 shadow-2xs group-hover/img:scale-110 transition" alt="Out">
                                        </a>
                                    @else
                                        <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-400 flex items-center justify-center text-xs shrink-0 border border-slate-200">
                                            <i class="ti ti-camera-off"></i>
                                        </div>
                                    @endif
                                    <span class="font-mono font-bold text-xs {{ $d->jam_out ? 'text-slate-900' : 'text-slate-400' }}">
                                        {{ $d->jam_out ? substr($d->jam_out, 0, 5) : '--:--' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Late or Timely Indicator -->
                    <div class="mt-4 pt-2.5 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="text-slate-400 font-medium text-[11px]">Ketepatan Waktu</span>
                        @if ($terlambat)
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-rose-50 text-rose-700 border border-rose-200 text-[10px] font-bold font-mono">
                                <i class="ti ti-clock-exclamation text-xs"></i>
                                <span>Terlambat {{ $terlambat }}</span>
                            </span>
                        @elseif ($d->status == 'h')
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-bold">
                                <i class="ti ti-check text-xs"></i>
                                <span>Tepat Waktu</span>
                            </span>
                        @else
                            <span class="text-slate-400 font-mono text-[11px]">-</span>
                        @endif
                    </div>

                </div>
            @empty
                <div class="col-span-full text-center py-12 bg-white border border-slate-200/80 rounded-2xl shadow-xs">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto mb-3 text-2xl border border-emerald-100">
                        <i class="ti ti-calendar-cancel"></i>
                    </div>
                    <h4 class="text-sm font-bold text-slate-800">Tidak Ada Rekap Data Presensi</h4>
                    <p class="text-xs text-slate-400 font-medium mt-1">
                        Belum ada catatan log absensi untuk periode bulan {{ $list_bulan[$bulan] ?? $bulan }} {{ $tahun }}.
                    </p>
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection

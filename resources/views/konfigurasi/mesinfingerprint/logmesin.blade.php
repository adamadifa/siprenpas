@extends('layouts.app')
@section('titlepage', 'Log Mesin Presensi')

@section('content')
<div class="space-y-5">

    <!-- ================= 1. PAGE HEADER (NO CARD) WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center border border-emerald-200/80 shadow-2xs">
                    <i class="ti ti-history text-2xl"></i>
                </div>
                <span>Log Aktivitas Mesin Presensi</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Histori sinkronisasi dan catatan transaksi log absensi dari seluruh unit mesin fingerprint
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
                <a href="{{ route('mesinfingerprint.index') }}" class="hover:text-slate-700 transition flex items-center gap-1">
                    <i class="ti ti-fingerprint text-sm"></i>
                    <span>Mesin Fingerprint</span>
                </a>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Log Mesin</span>
            </nav>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('mesinfingerprint.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white hover:bg-slate-100 text-slate-700 font-bold rounded-xl text-xs border border-slate-300/90 shadow-2xs transition-all duration-200 active:scale-95">
                    <i class="ti ti-arrow-left text-base text-emerald-600"></i>
                    <span>Kembali ke Data Mesin</span>
                </a>
            </div>
        </div>
    </div>

    <!-- ================= 2. FILTER & SEARCH TOOLBAR ================= -->
    <form action="{{ route('mesinfingerprint.logmesin') }}" method="GET" class="w-full">
        <div class="flex flex-col sm:flex-row items-center gap-2.5 sm:gap-3 w-full">
            <!-- Date Filter Input -->
            <div class="flex-1 min-w-0 w-full relative">
                <i class="ti ti-calendar absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-lg pointer-events-none"></i>
                <input type="date" 
                       name="tanggal" 
                       value="{{ request('tanggal', date('Y-m-d')) }}" 
                       class="w-full pl-11 pr-4 py-2.5 sm:py-3 text-sm bg-white border border-slate-300/90 rounded-xl text-slate-800 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition cursor-pointer"
                       onchange="this.form.submit()">
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2 shrink-0 w-full sm:w-auto">
                <button type="submit" class="w-full sm:w-auto px-5 py-2.5 sm:py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl shadow-xs transition inline-flex items-center justify-center gap-2 cursor-pointer active:scale-95 whitespace-nowrap">
                    <i class="ti ti-filter text-base"></i>
                    <span>Filter Tanggal</span>
                </button>
                @if(request()->filled('tanggal') && request('tanggal') != date('Y-m-d'))
                    <a href="{{ route('mesinfingerprint.logmesin') }}" class="py-2.5 sm:py-3 px-3.5 bg-white hover:bg-slate-100 text-slate-600 border border-slate-300/90 rounded-xl font-semibold text-sm transition inline-flex items-center justify-center shrink-0 shadow-xs" title="Hari Ini">
                        <i class="ti ti-refresh text-base"></i>
                    </a>
                @endif
            </div>
        </div>
    </form>

    <!-- ================= 3. SOLID EMERALD TABLE CARD ================= -->
    <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
        <!-- Solid Emerald Header -->
        <div class="bg-emerald-600 px-5 py-4 flex items-center justify-between text-white">
            <div class="flex items-center gap-2.5">
                <i class="ti ti-database text-xl"></i>
                <h3 class="font-bold text-sm tracking-wide text-white">Data Log Sinkronisasi Mesin</h3>
            </div>
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-white/20 text-white backdrop-blur-xs">
                Tanggal: {{ date('d M Y', strtotime(request('tanggal', date('Y-m-d')))) }}
            </span>
        </div>

        <!-- Table Container -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse whitespace-nowrap">
                <thead>
                    <tr class="bg-emerald-600 text-white uppercase text-[11px] font-extrabold tracking-wider border-t border-emerald-500/50">
                        <th class="py-2.5 px-3.5 w-12 text-center whitespace-nowrap">NO</th>
                        <th class="py-2.5 px-4 whitespace-nowrap">WAKTU SISTEM</th>
                        <th class="py-2.5 px-3 text-center whitespace-nowrap">PIN SANTRI / STAF</th>
                        <th class="py-2.5 px-3 text-center whitespace-nowrap">JAM ABSEN</th>
                        <th class="py-2.5 px-3 text-center whitespace-nowrap">SCAN</th>
                        <th class="py-2.5 px-4 whitespace-nowrap">NAMA PERANGKAT</th>
                        <th class="py-2.5 px-3.5 text-center whitespace-nowrap">STATUS</th>
                        <th class="py-2.5 px-4 whitespace-nowrap">KETERANGAN</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                    @forelse ($logmesin as $d)
                        <tr class="hover:bg-slate-50/80 transition-colors group">
                            <!-- No -->
                            <td class="py-2.5 px-3.5 text-center font-bold text-slate-400 whitespace-nowrap">
                                {{ $loop->iteration + ($logmesin->currentPage() - 1) * $logmesin->perPage() }}
                            </td>

                            <!-- Waktu Sistem -->
                            <td class="py-2.5 px-4 whitespace-nowrap font-medium">
                                <span class="text-slate-800 font-bold">{{ $d->created_at ? $d->created_at->format('d/m/Y') : '-' }}</span>
                                <span class="text-slate-400 font-mono text-[11px] ml-1">{{ $d->created_at ? $d->created_at->format('H:i:s') : '' }}</span>
                            </td>

                            <!-- PIN -->
                            <td class="py-2.5 px-3 text-center whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg bg-slate-100 text-slate-800 font-mono text-xs font-bold border border-slate-200">
                                    {{ $d->pin }}
                                </span>
                            </td>

                            <!-- Jam Absen -->
                            <td class="py-2.5 px-3 text-center whitespace-nowrap">
                                <span class="inline-flex items-center gap-1 font-mono font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-200/70">
                                    <i class="ti ti-clock text-xs"></i>
                                    {{ $d->jam_absen }}
                                </span>
                            </td>

                            <!-- Scan Status -->
                            <td class="py-2.5 px-3 text-center whitespace-nowrap">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-bold bg-sky-50 text-sky-700 border border-sky-200">
                                    {{ $d->status_scan }}
                                </span>
                            </td>

                            <!-- Perangkat Mesin -->
                            <td class="py-2.5 px-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-md bg-emerald-50 text-emerald-700 flex items-center justify-center font-bold text-xs">
                                        <i class="ti ti-cpu"></i>
                                    </div>
                                    <span class="font-bold text-slate-800">{{ $d->nama_mesin ?? 'Unknown' }}</span>
                                    <span class="text-slate-400 font-mono text-[11px]">({{ $d->sn ?? '-' }})</span>
                                </div>
                            </td>

                            <!-- Status Sync -->
                            <td class="py-2.5 px-3.5 text-center whitespace-nowrap">
                                @if ($d->status == 1)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-300">
                                        <i class="ti ti-circle-check text-xs"></i>
                                        <span>Berhasil</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-rose-100 text-rose-800 border border-rose-300">
                                        <i class="ti ti-circle-x text-xs"></i>
                                        <span>Gagal</span>
                                    </span>
                                @endif
                            </td>

                            <!-- Keterangan -->
                            <td class="py-2.5 px-4 whitespace-nowrap text-slate-600">
                                <span class="text-xs truncate max-w-xs block" title="{{ $d->keterangan }}">
                                    {{ $d->keterangan ?: '-' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 px-4 text-center">
                                <div class="w-16 h-16 mx-auto mb-3 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-3xl">
                                    <i class="ti ti-database-off"></i>
                                </div>
                                <h4 class="font-bold text-slate-800 text-sm">Tidak Ada Data Log Mesin</h4>
                                <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">
                                    Tidak ditemukan catatan aktivitas atau sinkronisasi presensi pada tanggal yang dipilih.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($logmesin->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $logmesin->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>
@endsection


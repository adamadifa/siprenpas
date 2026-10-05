@extends('layouts.app')
@section('titlepage', 'Data Simpanan Koperasi')

@section('content')
<div class="space-y-5">

    <!-- ================= 1. PAGE HEADER (NO CARD) WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <i class="ti ti-wallet text-emerald-600 text-2xl"></i>
                <span>Data Simpanan Koperasi</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Manajemen buku simpanan, mutasi transaksi setoran & penarikan, serta pemantauan saldo simpanan anggota
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
                    <i class="ti ti-building-bank text-sm"></i>
                    <span>Koperasi</span>
                </span>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Simpanan</span>
            </nav>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center gap-2">
                @can('jenissimpanan.index')
                    <a href="{{ route('jenissimpanan.index') }}" 
                       class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white hover:bg-slate-50 text-slate-700 font-bold rounded-xl text-xs border border-slate-300 shadow-2xs transition active:scale-95 cursor-pointer">
                        <i class="ti ti-settings text-sm text-slate-500"></i>
                        <span>Jenis Simpanan</span>
                    </a>
                @endcan
            </div>
        </div>
    </div>

    <!-- ================= 2. KPI SUMMARY CARDS (SOLID ELEGANT CLEAN) ================= -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <!-- Total Saldo Simpanan (Solid Emerald) -->
        <div class="bg-emerald-600 border border-emerald-500/80 rounded-2xl p-4 sm:p-5 shadow-xs flex items-center justify-between gap-4 text-white">
            <div class="space-y-1">
                <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-100/90">Total Simpanan Koperasi</span>
                <div class="text-lg sm:text-2xl font-black text-white font-mono tracking-tight">
                    Rp {{ formatRupiah($total_saldo_simpanan) }}
                </div>
                <div class="text-[11px] text-emerald-100/80 font-medium">Akumulasi seluruh jenis simpanan</div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-white/15 text-white flex items-center justify-center text-xl shrink-0 font-bold border border-white/20 shadow-2xs">
                <i class="ti ti-wallet"></i>
            </div>
        </div>

        <!-- Anggota Memiliki Saldo (Solid Deep Teal) -->
        <div class="bg-teal-700 border border-teal-600/80 rounded-2xl p-4 sm:p-5 shadow-xs flex items-center justify-between gap-4 text-white">
            <div class="space-y-1">
                <span class="text-[11px] font-bold uppercase tracking-wider text-teal-100/90">Anggota Memiliki Saldo</span>
                <div class="text-lg sm:text-2xl font-black text-white font-mono tracking-tight">
                    {{ number_format($anggota_dengan_saldo) }} <span class="text-xs font-semibold text-teal-200">Orang</span>
                </div>
                <div class="text-[11px] text-teal-100/80 font-medium">Anggota dengan saldo aktif &gt; 0</div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-white/15 text-white flex items-center justify-center text-xl shrink-0 font-bold border border-white/20 shadow-2xs">
                <i class="ti ti-user-check"></i>
            </div>
        </div>

        <!-- Total Anggota Terdaftar (Solid Slate) -->
        <div class="bg-slate-800 border border-slate-700/80 rounded-2xl p-4 sm:p-5 shadow-xs flex items-center justify-between gap-4 text-white">
            <div class="space-y-1">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-300">Total Anggota Koperasi</span>
                <div class="text-lg sm:text-2xl font-black text-white font-mono tracking-tight">
                    {{ number_format($total_anggota) }} <span class="text-xs font-semibold text-slate-400">Orang</span>
                </div>
                <div class="text-[11px] text-slate-400 font-medium">Basis nasabah terdaftar di sistem</div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-white/10 text-white flex items-center justify-center text-xl shrink-0 font-bold border border-white/10 shadow-2xs">
                <i class="ti ti-users"></i>
            </div>
        </div>
    </div>

    <!-- ================= 3. FILTER & SEARCH TOOLBAR ================= -->
    <form action="{{ route('simpanan.index') }}" method="GET" class="w-full">
        <div class="flex flex-col sm:flex-row items-center gap-2.5 sm:gap-3 w-full">
            <!-- Search Input -->
            <div class="flex-1 min-w-0 w-full relative">
                <i class="ti ti-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-lg pointer-events-none"></i>
                <input type="text" 
                       name="nama_lengkap" 
                       value="{{ Request('nama_lengkap') }}" 
                       placeholder="Cari Nama Anggota, No. Anggota, NIK, atau No. HP..." 
                       class="w-full pl-11 pr-4 py-2.5 sm:py-3 text-sm bg-white border border-slate-300/90 rounded-xl text-slate-800 font-medium placeholder-slate-400 shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2 shrink-0 w-full sm:w-auto">
                <button type="submit" class="w-full sm:w-auto px-5 py-2.5 sm:py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl shadow-xs transition inline-flex items-center justify-center gap-2 cursor-pointer active:scale-95 whitespace-nowrap">
                    <i class="ti ti-search text-base"></i>
                    <span>Cari</span>
                </button>
                @if(Request('nama_lengkap'))
                    <a href="{{ route('simpanan.index') }}" class="py-2.5 sm:py-3 px-3 bg-white hover:bg-slate-100 text-slate-600 border border-slate-300/90 rounded-xl font-semibold text-sm transition inline-flex items-center justify-center shrink-0 shadow-xs cursor-pointer" title="Reset Pencarian">
                        <i class="ti ti-refresh text-base"></i>
                    </a>
                @endif
            </div>
        </div>
    </form>

    <!-- ================= 4. COMPACT DATA TABLE (SINGLE LINE PER CELL, SEPARATE COLUMNS) ================= -->
    <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
        
        <!-- Seamless Solid Green Card Header -->
        <div class="px-5 pt-3.5 pb-2.5 bg-emerald-600 flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-white border-0">
            <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-lg bg-white/20 text-white flex items-center justify-center text-xs font-bold border border-white/20 shadow-2xs">
                    <i class="ti ti-wallet"></i>
                </div>
                <h3 class="text-sm font-extrabold text-white tracking-tight">Daftar Rekening Simpanan Anggota</h3>
                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-white/20 text-white border border-white/30 shadow-2xs backdrop-blur-xs">
                    {{ $anggota->total() }} data
                </span>
            </div>
            <div class="text-xs text-emerald-100 font-medium">
                Pilih anggota untuk mengelola mutasi setoran & penarikan simpanan
            </div>
        </div>

        <!-- Responsive Table Container with Max Width & No Wrapping -->
        <div class="overflow-x-auto bg-emerald-600">
            <table class="w-full text-left text-xs sm:text-sm border-0 border-collapse whitespace-nowrap">
                <!-- Matching Solid Green Table Header -->
                <thead class="bg-emerald-600 text-white font-bold uppercase tracking-wider text-[11px] border-0 border-t-0 border-b border-emerald-700/80">
                    <tr class="border-0 border-t-0">
                        <th class="py-2.5 px-3 w-10 text-center text-emerald-100 border-0 border-t-0 whitespace-nowrap">No</th>
                        <th class="py-2.5 px-3 text-emerald-100 border-0 border-t-0 whitespace-nowrap">No. Anggota</th>
                        <th class="py-2.5 px-3 text-emerald-100 border-0 border-t-0 whitespace-nowrap">Nama Lengkap</th>
                        <th class="py-2.5 px-3 text-emerald-100 border-0 border-t-0 whitespace-nowrap">NIK</th>
                        <th class="py-2.5 px-3 text-emerald-100 border-0 border-t-0 whitespace-nowrap">Tempat, Tanggal Lahir</th>
                        <th class="py-2.5 px-3 text-emerald-100 border-0 border-t-0 whitespace-nowrap">No. HP / WA</th>
                        <th class="py-2.5 px-3 text-right text-emerald-100 border-0 border-t-0 whitespace-nowrap">Total Saldo Simpanan</th>
                        <th class="py-2.5 px-3 text-center w-32 text-emerald-100 border-0 border-t-0 whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700 font-medium bg-white text-xs">
                    @forelse ($anggota as $d)
                        <tr class="hover:bg-slate-50/80 transition-colors group">
                            <!-- No Index (Compact) -->
                            <td class="py-2 px-3 text-center text-slate-400 font-bold whitespace-nowrap">
                                <span class="w-5.5 h-5.5 rounded-md bg-slate-100 group-hover:bg-emerald-50 group-hover:text-emerald-700 group-hover:border group-hover:border-emerald-200 inline-flex items-center justify-center font-bold text-slate-600 transition text-[11px]">
                                    {{ $loop->iteration + $anggota->firstItem() - 1 }}
                                </span>
                            </td>

                            <!-- No. Anggota (Single Line) -->
                            <td class="py-2 px-3 whitespace-nowrap">
                                <span class="px-2 py-0.5 rounded-md text-[11px] font-black font-mono tracking-wider bg-emerald-50 text-emerald-800 border border-emerald-200/80 shadow-2xs">
                                    {{ $d->no_anggota }}
                                </span>
                            </td>

                            <!-- Nama Lengkap (Single Line, Clickable) -->
                            <td class="py-2 px-3 whitespace-nowrap">
                                <a href="{{ route('simpanan.show', Crypt::encrypt($d->no_anggota)) }}" 
                                   class="font-bold text-slate-900 uppercase hover:text-emerald-700 transition">
                                    {{ $d->nama_lengkap }}
                                </a>
                            </td>

                            <!-- NIK (Dedicated Column, Single Line) -->
                            <td class="py-2 px-3 font-mono text-slate-600 whitespace-nowrap">
                                {{ $d->nik ?: '-' }}
                            </td>

                            <!-- Tempat, Tanggal Lahir (Dedicated Column, Single Line) -->
                            <td class="py-2 px-3 text-slate-700 whitespace-nowrap">
                                {{ $d->tempat_lahir ? $d->tempat_lahir . ', ' : '' }}{{ $d->tanggal_lahir ? DateToIndo($d->tanggal_lahir) : '-' }}
                            </td>

                            <!-- No. HP / WA (Dedicated Column, Single Line) -->
                            <td class="py-2 px-3 font-mono text-slate-700 whitespace-nowrap">
                                @if($d->no_hp)
                                    <span class="inline-flex items-center gap-1.5">
                                        <i class="ti ti-brand-whatsapp text-emerald-600 text-sm"></i>
                                        <span>{{ $d->no_hp }}</span>
                                    </span>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>

                            <!-- Total Saldo Simpanan (Single Line, Right Aligned) -->
                            <td class="py-2 px-3 text-right whitespace-nowrap">
                                @if($d->jml_saldo && $d->jml_saldo > 0)
                                    <span class="font-black font-mono text-emerald-700 text-xs sm:text-sm">
                                        Rp {{ formatRupiah($d->jml_saldo) }}
                                    </span>
                                @else
                                    <span class="font-bold font-mono text-slate-400 text-xs">
                                        Rp 0
                                    </span>
                                @endif
                            </td>

                            <!-- Aksi (Compact Button) -->
                            <td class="py-2 px-3 text-center whitespace-nowrap">
                                @can('simpanan.create')
                                    <a href="{{ route('simpanan.show', Crypt::encrypt($d->no_anggota)) }}" 
                                       class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-50 hover:bg-emerald-600 text-emerald-700 hover:text-white border border-emerald-200/90 font-bold rounded-lg text-xs shadow-2xs transition-all duration-150 active:scale-95 cursor-pointer group/btn"
                                       title="Buka Buku Simpanan">
                                        <i class="ti ti-book-2 text-sm text-emerald-600 group-hover/btn:text-white transition"></i>
                                        <span>Buku Simpanan</span>
                                    </a>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-10 text-center whitespace-nowrap">
                                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 border border-emerald-100 flex items-center justify-center mx-auto mb-2 text-xl shadow-2xs">
                                    <i class="ti ti-wallet-off"></i>
                                </div>
                                <h4 class="text-xs font-bold text-slate-800 mb-0.5">Data Simpanan Tidak Ditemukan</h4>
                                <p class="text-[11px] text-slate-400 max-w-sm mx-auto">
                                    Tidak ada data anggota simpanan yang cocok dengan kriteria pencarian Anda.
                                </p>
                                @if(Request('nama_lengkap'))
                                    <div class="mt-3">
                                        <a href="{{ route('simpanan.index') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer">
                                            <i class="ti ti-refresh text-xs"></i>
                                            <span>Reset Pencarian</span>
                                        </a>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Section -->
        <div class="px-5 py-3 bg-slate-50 border-t border-slate-200/80 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
            <div>
                Menampilkan <span class="font-bold text-slate-800">{{ $anggota->firstItem() ?? 0 }}</span> - <span class="font-bold text-slate-800">{{ $anggota->lastItem() ?? 0 }}</span> dari <span class="font-bold text-slate-800">{{ $anggota->total() }}</span> anggota
            </div>
            <div>
                {{ $anggota->links() }}
            </div>
        </div>
    </div>

</div>
@endsection

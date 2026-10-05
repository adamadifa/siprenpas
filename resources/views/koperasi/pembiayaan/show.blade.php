@extends('layouts.app')
@section('titlepage', 'Detail Pembiayaan')

@section('content')
@php
    $margin_nominal = $pembiayaan->jumlah * ($pembiayaan->persentase / 100);
    $jumlah_pembiayaan = $pembiayaan->jumlah + $margin_nominal;
    $total_bayar_akumulasi = $histori->sum('jumlah');
    $sisa_tagihan_total = max(0, $jumlah_pembiayaan - $total_bayar_akumulasi);
    $progressPercent = $jumlah_pembiayaan > 0 ? min(100, round(($total_bayar_akumulasi / $jumlah_pembiayaan) * 100, 1)) : 0;
    $isLunas = $sisa_tagihan_total <= 0;
@endphp

<div class="space-y-6">

    <!-- ================= 1. TOP HEADER & BREADCRUMB ================= -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <!-- Title & Subtitle -->
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-xl shrink-0 font-bold border border-emerald-200 shadow-2xs">
                <i class="ti ti-cash"></i>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">
                    Detail Pembiayaan
                </h1>
                <p class="text-xs text-slate-500 font-medium">
                    Monitoring rincian akad, rencana angsuran cicilan, dan rekam histori pembayaran nasabah
                </p>
            </div>
        </div>

        <!-- Breadcrumb & Back -->
        <div class="flex flex-col sm:items-end gap-2">
            <nav class="flex items-center text-xs text-slate-400 font-medium">
                <a href="{{ route('dashboard.index') }}" class="hover:text-slate-700 transition flex items-center gap-1">
                    <i class="ti ti-home text-sm"></i>
                    <span>Dashboard</span>
                </a>
                <span class="mx-2 text-slate-300">/</span>
                <a href="{{ route('pembiayaan.index') }}" class="hover:text-slate-700 transition flex items-center gap-1">
                    <i class="ti ti-cash-banknote text-sm"></i>
                    <span>Pembiayaan</span>
                </a>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Detail</span>
            </nav>

            <div class="flex items-center gap-2">
                <a href="{{ route('pembiayaan.index') }}" 
                   class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-white hover:bg-slate-50 text-slate-700 font-semibold rounded-lg text-xs border border-slate-200 shadow-2xs transition active:scale-95 cursor-pointer">
                    <i class="ti ti-arrow-left text-sm"></i>
                    <span>Kembali</span>
                </a>
                <a href="{{ route('anggota.show', Crypt::encrypt($anggota->no_anggota)) }}" 
                   class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-white hover:bg-slate-50 text-slate-700 font-semibold rounded-lg text-xs border border-slate-200 shadow-2xs transition active:scale-95 cursor-pointer">
                    <i class="ti ti-user text-sm"></i>
                    <span>Profil Anggota</span>
                </a>
            </div>
        </div>
    </div>

    <!-- ================= 2. MEMBER PROFILE BANNER & QUICK ACTIONS (SOLID GREEN) ================= -->
    <div class="bg-emerald-600 border border-emerald-500 rounded-2xl shadow-xs p-5 sm:p-6 text-white">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-5">
            <!-- Left: Avatar & Identity -->
            <div class="flex items-center gap-4 sm:gap-5 min-w-0">
                <!-- Avatar -->
                @if ($anggota->foto && Storage::disk('public')->exists('/anggota/' . $anggota->foto))
                    <img src="{{ getfotoKaryawan($anggota->foto) }}" alt="{{ $anggota->nama_lengkap }}" 
                         class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl object-cover shadow-xs shrink-0 ring-4 ring-white/20 border-2 border-white">
                @else
                    <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-white text-emerald-800 flex items-center justify-center font-bold text-2xl sm:text-3xl shadow-xs shrink-0 ring-4 ring-white/20">
                        {{ strtoupper(substr($anggota->nama_lengkap, 0, 1)) }}
                    </div>
                @endif

                <!-- Info -->
                <div class="space-y-1.5 min-w-0">
                    <div class="flex items-center gap-2.5 flex-wrap">
                        <h2 class="text-base sm:text-lg font-bold text-white uppercase tracking-tight truncate">
                            {{ $anggota->nama_lengkap }}
                        </h2>
                        <span class="px-2.5 py-0.5 rounded-lg text-xs font-bold tracking-wider bg-white/20 text-white border border-white/30 shadow-2xs">
                            {{ $anggota->no_anggota }}
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $isLunas ? 'bg-white text-emerald-800' : 'bg-amber-400 text-amber-950' }} shadow-2xs">
                            <span class="w-1.5 h-1.5 rounded-full {{ $isLunas ? 'bg-emerald-600' : 'bg-amber-800' }}"></span> 
                            {{ $isLunas ? 'Akad Lunas' : 'Akad Berjalan' }}
                        </span>
                    </div>

                    <div class="flex items-center gap-3 text-emerald-100 text-xs flex-wrap font-medium">
                        <span class="inline-flex items-center gap-1">
                            <i class="ti ti-id text-emerald-200"></i>
                            <span class="text-emerald-200">NIK:</span>
                            <strong class="text-white font-bold">{{ $anggota->nik ?: '-' }}</strong>
                        </span>
                        <span class="text-emerald-300">•</span>
                        <span class="inline-flex items-center gap-1">
                            @if ($anggota->no_hp)
                                <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $anggota->no_hp)) }}" 
                                   target="_blank" 
                                   class="inline-flex items-center gap-1 text-white font-bold hover:text-emerald-100 hover:underline">
                                    <i class="ti ti-brand-whatsapp text-emerald-200"></i>
                                    <span>{{ $anggota->no_hp }}</span>
                                </a>
                            @else
                                <i class="ti ti-phone text-emerald-200"></i>
                                <span class="text-emerald-200">-</span>
                            @endif
                        </span>
                        <span class="text-emerald-300">•</span>
                        <span class="inline-flex items-center gap-1">
                            <i class="ti ti-map-pin text-emerald-200"></i>
                            <span class="text-emerald-100">{{ $anggota->regency_name ?: ($anggota->alamat ?: 'Alamat belum diisi') }}</span>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Right: Quick Actions -->
            <div class="flex flex-wrap items-center gap-2.5 shrink-0 pt-3 lg:pt-0 border-t lg:border-t-0 border-white/20">
                <a href="{{ route('pembiayaan.updaterencana', Crypt::encrypt($pembiayaan->no_akad)) }}" 
                   id="btnupdateRencana"
                   class="inline-flex items-center justify-center gap-1.5 px-4 py-2.5 bg-white/20 hover:bg-white/30 text-white font-bold rounded-xl text-xs border border-white/30 shadow-2xs transition active:scale-95 cursor-pointer">
                    <i class="ti ti-refresh text-sm"></i>
                    <span>Update Rencana</span>
                </a>

                @if ($pembiayaan->jmlbayar == 0)
                    <button type="button" 
                            id="btnEditrencana" 
                            no_akad="{{ Crypt::encrypt($pembiayaan->no_akad) }}"
                            class="inline-flex items-center justify-center gap-1.5 px-4 py-2.5 bg-white/20 hover:bg-white/30 text-white font-bold rounded-xl text-xs border border-white/30 shadow-2xs transition active:scale-95 cursor-pointer">
                        <i class="ti ti-edit text-sm"></i>
                        <span>Edit Rencana</span>
                    </button>
                @endif

                @if (!$isLunas)
                    <button type="button" 
                            id="btncreateBayar"
                            class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-white hover:bg-emerald-50 text-emerald-800 font-bold rounded-xl text-xs shadow-sm hover:shadow-md transition active:scale-95 cursor-pointer border border-white">
                        <i class="ti ti-wallet text-sm text-emerald-700"></i>
                        <span>+ Input Pembayaran</span>
                    </button>
                @endif
            </div>
        </div>

        <!-- Akad Metadata Strip inside Banner -->
        <div class="mt-4 pt-4 border-t border-white/20 grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 text-xs text-emerald-100">
            <!-- No. Akad -->
            <div class="flex items-center gap-2.5 min-w-0">
                <i class="ti ti-file-certificate text-emerald-200 text-lg shrink-0"></i>
                <div class="min-w-0">
                    <span class="text-emerald-200 block text-[11px] font-medium leading-tight">No. Akad</span>
                    <span class="font-bold text-white text-xs sm:text-sm truncate block mt-0.5">{{ $pembiayaan->no_akad }}</span>
                </div>
            </div>

            <!-- Jenis Pembiayaan -->
            <div class="flex items-center gap-2.5 min-w-0">
                <i class="ti ti-tags text-emerald-200 text-lg shrink-0"></i>
                <div class="min-w-0">
                    <span class="text-emerald-200 block text-[11px] font-medium leading-tight">Jenis Pembiayaan</span>
                    <span class="font-bold text-white text-xs sm:text-sm truncate block mt-0.5">{{ $pembiayaan->jenis_pembiayaan }}</span>
                </div>
            </div>

            <!-- Tanggal Akad -->
            <div class="flex items-center gap-2.5 min-w-0">
                <i class="ti ti-calendar-event text-emerald-200 text-lg shrink-0"></i>
                <div class="min-w-0">
                    <span class="text-emerald-200 block text-[11px] font-medium leading-tight">Tanggal Akad</span>
                    <span class="font-bold text-white text-xs sm:text-sm truncate block mt-0.5">{{ DateToIndo($pembiayaan->tanggal) }}</span>
                </div>
            </div>

            <!-- Keperluan & Jaminan -->
            <div class="flex items-center gap-2.5 min-w-0">
                <i class="ti ti-shield-check text-emerald-200 text-lg shrink-0"></i>
                <div class="min-w-0">
                    <span class="text-emerald-200 block text-[11px] font-medium leading-tight">Keperluan & Jaminan</span>
                    <span class="font-bold text-white text-xs sm:text-sm truncate block mt-0.5" title="{{ $pembiayaan->keperluan }}">
                        {{ $pembiayaan->keperluan ?: '-' }} ({{ $pembiayaan->jaminan ?: '-' }})
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= 3. SOLID FINANCIAL METRICS CARDS WITH SUBTLE ORNAMENTS ================= -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- Metric 1: Pokok Pembiayaan -->
        <div class="bg-emerald-600 border border-emerald-500 rounded-2xl p-5 text-white shadow-xs flex flex-col justify-between relative overflow-hidden group">
            <!-- Subtle Clean Watermark & Ring Ornaments -->
            <div class="absolute -right-6 -bottom-6 w-24 h-24 rounded-full border border-white/10 pointer-events-none"></div>
            <i class="ti ti-coin text-white/10 text-6xl absolute -right-2 -bottom-2 pointer-events-none"></i>

            <div class="flex items-center justify-between relative z-10">
                <span class="text-xs font-bold text-emerald-100 uppercase tracking-wider">Pokok Pembiayaan</span>
                <div class="w-8 h-8 rounded-lg bg-white/20 text-white flex items-center justify-center text-base border border-white/20 shadow-2xs">
                    <i class="ti ti-coin"></i>
                </div>
            </div>
            <div class="mt-3 relative z-10">
                <div class="text-xl sm:text-2xl font-bold text-white tracking-tight">
                    Rp {{ formatRupiah($pembiayaan->jumlah) }}
                </div>
                <div class="text-[11px] text-emerald-200 mt-1.5 font-medium flex items-center gap-1.5">
                    <span>Margin: <strong class="text-white">{{ $pembiayaan->persentase }}%</strong></span>
                    <span class="text-emerald-300">•</span>
                    <span>Tenor: <strong class="text-white">{{ $pembiayaan->jangka_waktu }} Bln</strong></span>
                </div>
            </div>
        </div>

        <!-- Metric 2: Total Tagihan (+Margin) -->
        <div class="bg-emerald-600 border border-emerald-500 rounded-2xl p-5 text-white shadow-xs flex flex-col justify-between relative overflow-hidden group">
            <!-- Subtle Clean Watermark & Ring Ornaments -->
            <div class="absolute -right-6 -bottom-6 w-24 h-24 rounded-full border border-white/10 pointer-events-none"></div>
            <i class="ti ti-receipt text-white/10 text-6xl absolute -right-2 -bottom-2 pointer-events-none"></i>

            <div class="flex items-center justify-between relative z-10">
                <span class="text-xs font-bold text-emerald-100 uppercase tracking-wider">Total Tagihan</span>
                <div class="w-8 h-8 rounded-lg bg-white/20 text-white flex items-center justify-center text-base border border-white/20 shadow-2xs">
                    <i class="ti ti-receipt"></i>
                </div>
            </div>
            <div class="mt-3 relative z-10">
                <div class="text-xl sm:text-2xl font-bold text-white tracking-tight">
                    Rp {{ formatRupiah($jumlah_pembiayaan) }}
                </div>
                <div class="text-[11px] text-emerald-200 mt-1.5 font-medium">
                    Pokok + Jasa Koperasi (Rp {{ formatRupiah($margin_nominal) }})
                </div>
            </div>
        </div>

        <!-- Metric 3: Total Terbayar -->
        <div class="bg-emerald-600 border border-emerald-500 rounded-2xl p-5 text-white shadow-xs flex flex-col justify-between relative overflow-hidden group">
            <!-- Subtle Clean Watermark & Ring Ornaments -->
            <div class="absolute -right-6 -bottom-6 w-24 h-24 rounded-full border border-white/10 pointer-events-none"></div>
            <i class="ti ti-wallet text-white/10 text-6xl absolute -right-2 -bottom-2 pointer-events-none"></i>

            <div class="flex items-center justify-between relative z-10">
                <span class="text-xs font-bold text-emerald-100 uppercase tracking-wider">Total Terbayar</span>
                <div class="w-8 h-8 rounded-lg bg-white/20 text-white flex items-center justify-center text-base border border-white/20 shadow-2xs">
                    <i class="ti ti-wallet"></i>
                </div>
            </div>
            <div class="mt-3 relative z-10">
                <div class="text-xl sm:text-2xl font-bold text-white tracking-tight">
                    Rp {{ formatRupiah($total_bayar_akumulasi) }}
                </div>
                <!-- Mini Progress Bar -->
                <div class="mt-2.5 space-y-1">
                    <div class="flex items-center justify-between text-[11px] text-emerald-200 font-medium">
                        <span>Progress</span>
                        <span class="font-bold text-white">{{ $progressPercent }}%</span>
                    </div>
                    <div class="w-full h-1.5 bg-emerald-800/60 rounded-full overflow-hidden">
                        <div class="h-full bg-white rounded-full transition-all duration-300" style="width: {{ $progressPercent }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Metric 4: Sisa Tagihan -->
        <div class="bg-emerald-600 border border-emerald-500 rounded-2xl p-5 text-white shadow-xs flex flex-col justify-between relative overflow-hidden group">
            <!-- Subtle Clean Watermark & Ring Ornaments -->
            <div class="absolute -right-6 -bottom-6 w-24 h-24 rounded-full border border-white/10 pointer-events-none"></div>
            <i class="ti {{ $isLunas ? 'ti-check' : 'ti-hourglass-empty' }} text-white/10 text-6xl absolute -right-2 -bottom-2 pointer-events-none"></i>

            <div class="flex items-center justify-between relative z-10">
                <span class="text-xs font-bold text-emerald-100 uppercase tracking-wider">Sisa Tagihan</span>
                <div class="w-8 h-8 rounded-lg bg-white/20 text-white flex items-center justify-center text-base border border-white/20 shadow-2xs">
                    <i class="ti {{ $isLunas ? 'ti-check' : 'ti-alert-circle' }}"></i>
                </div>
            </div>
            <div class="mt-3 relative z-10">
                <div class="text-xl sm:text-2xl font-bold text-white tracking-tight">
                    Rp {{ formatRupiah($sisa_tagihan_total) }}
                </div>
                <div class="text-[11px] mt-1.5 font-medium text-emerald-200">
                    {{ $isLunas ? 'Semua cicilan lunas' : count($rencana->where('bayar', '<', 'jumlah')) . ' angsuran tersisa' }}
                </div>
            </div>
        </div>

    </div>

    <!-- ================= 4. RENCANA ANGSURAN & HISTORI PEMBAYARAN TABLES ================= -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Left: Rencana Angsuran Table Card (7 cols) -->
        <div class="lg:col-span-7 space-y-3">
            <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
                <!-- Card Header -->
                <div class="px-5 py-3.5 bg-emerald-600 flex items-center justify-between text-white">
                    <div class="flex items-center gap-2.5">
                        <div class="w-7 h-7 rounded-lg bg-white/20 text-white flex items-center justify-center text-xs font-bold border border-white/20 shadow-2xs">
                            <i class="ti ti-list-check"></i>
                        </div>
                        <h3 class="text-sm font-bold text-white tracking-tight">Rencana Angsuran Cicilan</h3>
                    </div>
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-white/20 text-white border border-white/30">
                        {{ count($rencana) }} cicilan
                    </span>
                </div>

                <!-- Responsive Table -->
                <div class="overflow-x-auto bg-emerald-600">
                    <table class="w-full text-left text-xs sm:text-sm border-0 border-collapse whitespace-nowrap">
                        <thead class="bg-emerald-600 text-white font-bold uppercase tracking-wider text-[11px] border-0 border-t border-b border-emerald-700/80">
                            <tr class="border-0">
                                <th class="py-2.5 px-3.5 w-12 text-center text-emerald-100 whitespace-nowrap">Ke</th>
                                <th class="py-2.5 px-3.5 text-emerald-100 whitespace-nowrap">Jatuh Tempo</th>
                                <th class="py-2.5 px-3.5 text-right text-emerald-100 whitespace-nowrap">Tagihan (Rp)</th>
                                <th class="py-2.5 px-3.5 text-right text-emerald-100 whitespace-nowrap">Bayar (Rp)</th>
                                <th class="py-2.5 px-3.5 text-right text-emerald-100 whitespace-nowrap">Sisa (Rp)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700 font-medium bg-white text-xs">
                            @php $total_rencana = 0; $total_bayar = 0; $total_sisa = 0; @endphp
                            @forelse ($rencana as $d)
                                @php
                                    $bulanCicilan = (int)$d->bulan;
                                    $tahunCicilan = (int)$d->tahun;
                                    if ($bulanCicilan > 12) {
                                        $tahunCicilan += intdiv($bulanCicilan - 1, 12);
                                        $bulanCicilan = (($bulanCicilan - 1) % 12) + 1;
                                    }
                                    $jatuh_tempo = sprintf('%04d-%02d-05', $tahunCicilan, $bulanCicilan);
                                    $sisa_tagihan = $d->jumlah - $d->bayar;
                                    $total_rencana += $d->jumlah;
                                    $total_bayar += $d->bayar;
                                    $total_sisa += $sisa_tagihan;
                                    $isRowLunas = ($sisa_tagihan <= 0);
                                @endphp
                                <tr class="hover:bg-slate-50/80 transition-colors {{ $isRowLunas ? 'bg-emerald-50/20' : '' }}">
                                    <td class="py-2.5 px-3.5 text-center font-bold text-slate-500 whitespace-nowrap">
                                        {{ $d->cicilan_ke }}
                                    </td>
                                    <td class="py-2.5 px-3.5 whitespace-nowrap text-slate-700 font-medium">
                                        {{ DateToIndo($jatuh_tempo) }}
                                    </td>
                                    <td class="py-2.5 px-3.5 text-right font-bold text-slate-800 whitespace-nowrap">
                                        {{ formatRupiah($d->jumlah) }}
                                    </td>
                                    <td class="py-2.5 px-3.5 text-right font-bold text-emerald-700 whitespace-nowrap">
                                        {{ $d->bayar > 0 ? formatRupiah($d->bayar) : '-' }}
                                    </td>
                                    <td class="py-2.5 px-3.5 text-right font-bold {{ $sisa_tagihan > 0 ? 'text-rose-600' : 'text-slate-400' }} whitespace-nowrap">
                                        {{ formatRupiah($sisa_tagihan) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-8 text-center text-slate-400 text-xs">Belum ada rencana angsuran yang digenerate.</td>
                                </tr>
                            @endforelse
                        </tbody>
                        @if(count($rencana) > 0)
                            <tfoot class="bg-slate-50 font-bold border-t border-slate-200 text-xs text-slate-800">
                                <tr>
                                    <td colspan="2" class="py-2.5 px-3.5 text-center uppercase tracking-wider text-[11px] text-slate-600">Total</td>
                                    <td class="py-2.5 px-3.5 text-right text-slate-900">{{ formatRupiah($total_rencana) }}</td>
                                    <td class="py-2.5 px-3.5 text-right text-emerald-700">{{ formatRupiah($total_bayar) }}</td>
                                    <td class="py-2.5 px-3.5 text-right text-rose-600">{{ formatRupiah($total_sisa) }}</td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>

        <!-- Right: Histori Bayar Table Card (5 cols) -->
        <div class="lg:col-span-5 space-y-3">
            <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
                <!-- Card Header -->
                <div class="px-5 py-3.5 bg-emerald-600 flex items-center justify-between text-white">
                    <div class="flex items-center gap-2.5">
                        <div class="w-7 h-7 rounded-lg bg-white/20 text-white flex items-center justify-center text-xs font-bold border border-white/20 shadow-2xs">
                            <i class="ti ti-history"></i>
                        </div>
                        <h3 class="text-sm font-bold text-white tracking-tight">Histori Pembayaran</h3>
                    </div>
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-white/20 text-white border border-white/30">
                        {{ count($histori) }} data
                    </span>
                </div>

                <!-- Responsive Table -->
                <div class="overflow-x-auto bg-emerald-600">
                    <table class="w-full text-left text-xs sm:text-sm border-0 border-collapse whitespace-nowrap">
                        <thead class="bg-emerald-600 text-white font-bold uppercase tracking-wider text-[11px] border-0 border-t border-b border-emerald-700/80">
                            <tr class="border-0">
                                <th class="py-2.5 px-3.5 text-emerald-100 whitespace-nowrap">Tanggal</th>
                                <th class="py-2.5 px-3.5 text-right text-emerald-100 whitespace-nowrap">Jumlah (Rp)</th>
                                <th class="py-2.5 px-3.5 text-center w-20 text-emerald-100 whitespace-nowrap">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700 font-medium bg-white text-xs">
                            @forelse ($histori as $d)
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <td class="py-2.5 px-3.5 whitespace-nowrap text-slate-700 font-medium">
                                        {{ DateToIndo($d->tanggal) }}
                                    </td>
                                    <td class="py-2.5 px-3.5 text-right font-bold text-emerald-700 whitespace-nowrap">
                                        Rp {{ formatRupiah($d->jumlah) }}
                                    </td>
                                    <td class="py-2.5 px-3.5 text-center whitespace-nowrap">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <!-- Cetak Kwitansi -->
                                            <a href="{{ route('pembiayaan.cetakkwitansi', Crypt::encrypt($d->no_transaksi)) }}" 
                                               target="_blank" 
                                               class="w-6.5 h-6.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 flex items-center justify-center transition active:scale-95 shadow-2xs" 
                                               title="Cetak Kwitansi">
                                                <i class="ti ti-printer text-xs"></i>
                                            </a>

                                            <!-- Delete Payment (If today and last transaction) -->
                                            @can('pembiayaan.delete')
                                                @if ($lasttransaksi && $d->no_transaksi == $lasttransaksi->no_transaksi && date('Y-m-d', strtotime($d->created_at)) == date('Y-m-d'))
                                                    <form method="POST" class="deleteform m-0"
                                                          action="{{ route('pembiayaan.deletebayar', Crypt::encrypt($d->no_transaksi)) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" 
                                                                class="delete-confirm w-6.5 h-6.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200/80 flex items-center justify-center transition active:scale-95 cursor-pointer shadow-2xs" 
                                                                title="Hapus Pembayaran">
                                                            <i class="ti ti-trash text-xs"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-8 text-center text-slate-400 text-xs">Belum ada histori transaksi pembayaran.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

</div>

<!-- Modals -->
<x-modal-form id="mdlBerita" size="" show="loadmodalberita" title="" />
<x-modal-form id="mdlPembiayaan" size="" show="loadmodalPembiayaan" title="" />
<x-modal-form id="mdlRencanapembiayaan" size="" show="loadrencanapembiayaan" title="" />
@endsection

@push('myscript')
<script>
    $(function() {
        const loading = `
            <div class="flex items-center justify-center p-8">
                <div class="w-8 h-8 border-4 border-emerald-600 border-t-transparent rounded-full animate-spin"></div>
            </div>
        `;

        $(document).on('click', '.btnShowberita', function(e) {
            e.preventDefault();
            var berita = $(this).attr("berita");
            $("#mdlBerita").modal("show");
            $("#mdlBerita").find(".modal-title").text("Keterangan");
            $("#loadmodalberita").html(`
                <div class="p-4 text-slate-800 text-sm leading-relaxed bg-slate-50 rounded-xl border border-slate-200">
                    <div class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Isi Berita:</div>
                    <div>${berita || 'Tidak ada keterangan tambahan.'}</div>
                </div>
            `);
        });

        $(document).on('click', '#btncreateBayar', function(e) {
            e.preventDefault();
            let no_akad = "{{ Crypt::encrypt($pembiayaan->no_akad) }}";
            $('#mdlPembiayaan').modal("show");
            $("#loadmodalPembiayaan").html(loading);
            $("#mdlPembiayaan").find(".modal-title").text("Input Pembayaran Angsuran");
            $("#loadmodalPembiayaan").load("/pembiayaan/" + no_akad + "/createbayar");
        });

        $(document).on('click', '#btnEditrencana', function(e) {
            e.preventDefault();
            let no_akad = "{{ Crypt::encrypt($pembiayaan->no_akad) }}";
            $('#mdlRencanapembiayaan').modal("show");
            $("#loadrencanapembiayaan").html(loading);
            $("#mdlRencanapembiayaan").find(".modal-title").text("Edit Rencana Pembayaran");
            $("#loadrencanapembiayaan").load("/pembiayaan/" + no_akad + "/editrencana");
        });

        // Delete Confirm
        $(document).on('click', '.delete-confirm', function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            Swal.fire({
                title: 'Hapus Pembayaran?',
                text: "Data pembayaran terakhir akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#064e3b',
                cancelButtonColor: '#e11d48',
                confirmButtonText: 'Ya, Hapus',
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

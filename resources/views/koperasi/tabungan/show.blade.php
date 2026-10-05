@extends('layouts.app')
@section('titlepage', 'Buku Tabungan Anggota')

@section('content')
<div class="space-y-6">

    <!-- ================= 1. TOP HEADER & NAVIGATION ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <!-- Title & Subtitle -->
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-xl shrink-0 font-bold border border-emerald-200 shadow-2xs">
                <i class="ti ti-wallet"></i>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
                    Buku Tabungan Anggota
                </h1>
                <p class="text-xs text-slate-500 mt-0.5 font-medium">
                    Informasi saldo rekening tabungan, mutasi setoran & penarikan, serta histori transaksi nasabah
                </p>
            </div>
        </div>

        <!-- Right: Breadcrumb & Actions -->
        <div class="flex flex-col md:items-end gap-2.5">
            <!-- Breadcrumb Navigation -->
            <nav class="flex items-center text-xs text-slate-400 font-medium">
                <a href="{{ route('dashboard.index') }}" class="hover:text-slate-700 transition flex items-center gap-1">
                    <i class="ti ti-home text-sm"></i>
                    <span>Dashboard</span>
                </a>
                <span class="mx-2 text-slate-300">/</span>
                <a href="{{ route('tabungan.index') }}" class="hover:text-slate-700 transition flex items-center gap-1">
                    <i class="ti ti-wallet text-sm"></i>
                    <span>Tabungan</span>
                </a>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Detail Tabungan</span>
            </nav>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('tabungan.index') }}" 
                   class="inline-flex items-center gap-1.5 px-4 py-2 bg-white hover:bg-slate-50 text-slate-700 font-bold rounded-xl text-xs border border-slate-200/90 shadow-2xs transition active:scale-95 cursor-pointer">
                    <i class="ti ti-arrow-left text-sm"></i>
                    <span>Kembali</span>
                </a>
                <a href="{{ route('anggota.show', Crypt::encrypt($anggota->no_anggota)) }}" 
                   class="inline-flex items-center gap-1.5 px-4 py-2 bg-white hover:bg-slate-50 text-slate-700 font-bold rounded-xl text-xs border border-slate-200/90 shadow-2xs transition active:scale-95 cursor-pointer">
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
            <div class="flex items-center gap-4 sm:gap-5">
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
                        <h2 class="text-lg sm:text-xl font-black text-white uppercase tracking-tight truncate">
                            {{ $anggota->nama_lengkap }}
                        </h2>
                        <span class="px-2.5 py-0.5 rounded-lg text-xs font-bold tracking-wider bg-white/20 text-white border border-white/30 shadow-2xs backdrop-blur-xs font-mono">
                            {{ $anggota->no_anggota }}
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-white text-emerald-800 shadow-2xs">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span> Anggota Aktif
                        </span>
                    </div>

                    <div class="flex items-center gap-2 sm:gap-3 text-emerald-100 text-xs flex-wrap font-medium">
                        <span class="inline-flex items-center gap-1.5">
                            <i class="ti ti-id text-emerald-200 text-sm"></i>
                            <span class="text-emerald-200">NIK:</span>
                            <strong class="text-white font-bold font-mono">{{ $anggota->nik ?: '-' }}</strong>
                        </span>
                        <span class="text-emerald-400">•</span>
                        <span class="inline-flex items-center gap-1.5">
                            @if ($anggota->no_hp)
                                <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $anggota->no_hp)) }}" 
                                   target="_blank" 
                                   class="inline-flex items-center gap-1 text-white font-bold hover:text-emerald-100 hover:underline">
                                    <i class="ti ti-brand-whatsapp text-emerald-200 text-sm"></i>
                                    <span>{{ $anggota->no_hp }}</span>
                                </a>
                            @else
                                <i class="ti ti-phone text-emerald-200 text-sm"></i>
                                <span class="text-emerald-200">-</span>
                            @endif
                        </span>
                        <span class="text-emerald-400">•</span>
                        <span class="inline-flex items-center gap-1.5">
                            <i class="ti ti-map-pin text-emerald-200 text-sm"></i>
                            <span class="text-emerald-100">{{ $anggota->regency_name ?: ($anggota->alamat ?: 'Alamat belum diisi') }}</span>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Right: Quick Transaction Actions -->
            <div class="flex items-center gap-3 shrink-0">
                <button type="button" 
                        id="createSetoran"
                        class="inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-white hover:bg-emerald-50 text-emerald-800 font-bold rounded-xl text-xs sm:text-sm shadow-sm hover:shadow-md transition active:scale-95 cursor-pointer border border-white">
                    <i class="ti ti-download text-base sm:text-lg text-emerald-700"></i>
                    <span>+ Input Setoran</span>
                </button>
                <button type="button" 
                        id="createPenarikan"
                        class="inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-rose-500 hover:bg-rose-600 text-white font-bold rounded-xl text-xs sm:text-sm shadow-sm hover:shadow-md transition active:scale-95 cursor-pointer border border-rose-400">
                    <i class="ti ti-upload text-base sm:text-lg"></i>
                    <span>- Input Penarikan</span>
                </button>
            </div>
        </div>
    </div>

    <!-- ================= 3. ATM DEBIT CARDS (TABUNGAN ACCOUNTS) ================= -->
    <div class="space-y-3">
        <!-- Section Header with Active Rekening Indicator -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-sm font-bold shadow-2xs">
                    <i class="ti ti-credit-card"></i>
                </div>
                <h3 class="text-sm font-bold text-slate-900">Kartu Rekening Tabungan</h3>
            </div>
            <div class="px-3.5 py-1.5 rounded-xl bg-emerald-50 border border-emerald-200/80 text-xs font-bold text-emerald-800 flex items-center gap-2 self-start sm:self-auto shadow-2xs">
                <span class="text-slate-500 font-medium">Saldo Rekening Terpilih:</span>
                <span class="font-bold text-emerald-700 text-sm">Rp {{ formatRupiah($tabungan->saldo ?? 0) }}</span>
            </div>
        </div>

        <!-- ATM Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5">
            @forelse ($all_tabungan as $l)
                @php
                    $isActive = ($l->no_rekening == $tabungan->no_rekening);
                @endphp
                <div class="bg-gradient-to-br from-emerald-600 to-emerald-700 border border-emerald-500 rounded-2xl sm:rounded-3xl p-5 sm:p-6 text-white shadow-xs hover:shadow-md hover:-translate-y-1 transition-all duration-300 relative overflow-hidden flex flex-col justify-between min-h-[220px] sm:min-h-[230px] select-none group">
                    
                    <!-- Subtle Glow & Soft Watermark Ring -->
                    <div class="absolute -right-8 -top-8 w-36 h-36 rounded-full bg-white/5 blur-xl pointer-events-none"></div>
                    <div class="absolute -right-6 -bottom-6 w-32 h-32 rounded-full border border-white/10 pointer-events-none"></div>
                    <div class="absolute -right-1 -bottom-1 w-20 h-20 rounded-full border border-white/15 pointer-events-none"></div>

                    <!-- Top Row: Bank Brand & NFC / Status -->
                    <div class="flex items-center justify-between gap-2 relative z-10">
                        <div class="flex items-center gap-2.5">
                            <div class="w-7 h-7 rounded-lg bg-white/20 backdrop-blur-xs flex items-center justify-center border border-white/30 text-white shadow-2xs">
                                <i class="ti ti-building-bank text-sm"></i>
                            </div>
                            <div>
                                <span class="text-[11px] font-black tracking-widest text-white uppercase block leading-tight">
                                    KOPERASI TSARWAH
                                </span>
                                <span class="text-[8px] font-bold tracking-wider text-emerald-200 uppercase block">
                                    TABUNGAN AL AMIN
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center gap-1.5">
                            @if ($isActive)
                                <span class="px-2.5 py-0.5 rounded-full text-[9px] font-extrabold tracking-wider bg-white text-emerald-800 shadow-2xs flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span> REKENING INI
                                </span>
                            @else
                                <a href="{{ route('tabungan.show', Crypt::encrypt($l->no_rekening)) }}" 
                                   class="px-2.5 py-0.5 rounded-full text-[9px] font-bold tracking-wider bg-white/20 hover:bg-white/30 text-white border border-white/30 transition">
                                    Pilih &rarr;
                                </a>
                            @endif
                            <i class="ti ti-nfc text-base text-white/80" title="NFC Contactless"></i>
                        </div>
                    </div>

                    <!-- Middle Row: Metallic EMV Chip & Savings Category Name -->
                    <div class="flex items-center justify-between gap-3 my-auto pt-3 pb-2 relative z-10">
                        <!-- Golden EMV Chip Graphic -->
                        <div class="relative w-11 h-8 rounded-md bg-gradient-to-br from-amber-300 via-yellow-400 to-amber-500 p-[2px] shadow-sm border border-amber-200/80 overflow-hidden shrink-0 flex items-center justify-center">
                            <div class="w-full h-[1px] bg-amber-900/40 absolute top-1/2 -translate-y-1/2"></div>
                            <div class="h-full w-[1px] bg-amber-900/40 absolute left-[35%]"></div>
                            <div class="h-full w-[1px] bg-amber-900/40 absolute right-[35%]"></div>
                            <div class="w-4 h-3 rounded-[3px] border border-amber-900/40 bg-amber-200/50 shadow-inner z-10"></div>
                        </div>

                        <!-- Savings Category -->
                        <div class="text-right">
                            <span class="text-[9px] font-bold text-emerald-200 uppercase tracking-widest block leading-tight">
                                Jenis Tabungan
                            </span>
                            <span class="text-xs sm:text-sm font-black text-white uppercase tracking-wider block truncate max-w-[170px]" title="{{ $l->jenis_tabungan }}">
                                {{ $l->jenis_tabungan }}
                            </span>
                        </div>
                    </div>

                    <!-- Balance Row: Saldo Tabungan -->
                    <div class="relative z-10 mb-3">
                        <div class="text-[9px] uppercase font-bold tracking-widest text-emerald-200 flex items-center gap-1.5">
                            <span>Saldo Rekening</span>
                            <span class="inline-block w-1.5 h-1.5 rounded-full bg-emerald-300 animate-pulse"></span>
                        </div>
                        <div class="text-2xl sm:text-3xl font-black text-white tracking-tight font-sans drop-shadow-xs mt-0.5">
                            Rp {{ formatRupiah($l->saldo) }}
                        </div>
                    </div>

                    <!-- Bottom Row: Cardholder Name & No. Rekening -->
                    <div class="pt-3 border-t border-white/20 flex items-end justify-between gap-3 text-white relative z-10">
                        <div class="min-w-0">
                            <div class="text-[8px] uppercase tracking-widest text-emerald-200 font-bold leading-tight">
                                Pemegang Rekening
                            </div>
                            <div class="text-xs font-extrabold text-white uppercase tracking-wider truncate max-w-[150px] sm:max-w-[180px] drop-shadow-xs" title="{{ $anggota->nama_lengkap }}">
                                {{ $anggota->nama_lengkap }}
                            </div>
                        </div>

                        <div class="text-right shrink-0">
                            <div class="text-[8px] uppercase tracking-widest text-emerald-200 font-bold leading-tight">
                                No. Rekening
                            </div>
                            <div class="text-xs font-mono font-black text-white/95 tracking-wider">
                                {{ $l->no_rekening }}
                            </div>
                        </div>
                    </div>

                </div>
            @empty
                <div class="col-span-full p-8 bg-white border border-dashed border-slate-200 rounded-3xl text-center text-slate-400 text-xs font-medium flex flex-col items-center justify-center gap-2">
                    <div class="w-10 h-10 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center text-lg">
                        <i class="ti ti-credit-card-off"></i>
                    </div>
                    <span>Belum ada rekening tabungan yang tercatat untuk anggota ini.</span>
                </div>
            @endforelse
        </div>
    </div>

    <!-- ================= 4. FILTER MUTASI & DATA TABLE ================= -->
    <div class="space-y-3">
        
        <!-- Filter Bar -->
        <form action="{{ URL::current() }}" method="GET" class="w-full">
            <div class="bg-white border border-slate-200/90 rounded-xl p-5 sm:p-6 shadow-xs flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                <!-- Left Title with Icon -->
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-200 flex items-center justify-center text-base font-bold shadow-2xs shrink-0">
                        <i class="ti ti-calendar-search"></i>
                    </div>
                    <div>
                        <span class="text-xs sm:text-sm font-bold text-slate-800 block">Filter Rentang Tanggal Mutasi Tabungan</span>
                        <span class="text-[11px] text-slate-400 font-medium">Rekening: <strong class="text-slate-700 font-mono">{{ $tabungan->no_rekening }}</strong> ({{ $tabungan->jenis_tabungan }})</span>
                    </div>
                </div>
                
                <!-- Right Inputs & Action Controls -->
                <div class="flex flex-wrap items-center gap-3 w-full lg:w-auto">
                    <!-- Dari Tanggal Input -->
                    <div class="flex items-center gap-2 flex-1 sm:flex-initial">
                        <div class="relative flex-1 sm:w-40">
                            <i class="ti ti-calendar text-slate-400 text-sm absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                            <input type="text" 
                                   name="dari" 
                                   value="{{ Request('dari', date('Y-m-d', strtotime('-60 days'))) }}" 
                                   class="flatpickr-date w-full pl-9 pr-3.5 py-2.5 text-xs font-bold text-slate-800 bg-slate-50 hover:bg-white border border-slate-300 rounded-lg shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                   placeholder="Dari Tanggal">
                        </div>
                    </div>
                    
                    <span class="text-xs text-slate-400 font-semibold px-0.5">s/d</span>

                    <!-- Sampai Tanggal Input -->
                    <div class="flex items-center gap-2 flex-1 sm:flex-initial">
                        <div class="relative flex-1 sm:w-40">
                            <i class="ti ti-calendar text-slate-400 text-sm absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                            <input type="text" 
                                   name="sampai" 
                                   value="{{ Request('sampai', date('Y-m-d')) }}" 
                                   class="flatpickr-date w-full pl-9 pr-3.5 py-2.5 text-xs font-bold text-slate-800 bg-slate-50 hover:bg-white border border-slate-300 rounded-lg shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                   placeholder="Sampai Tanggal">
                        </div>
                    </div>

                    <!-- Submit & Reset Action Buttons -->
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <button type="submit" 
                                class="flex-1 sm:flex-initial px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-lg shadow-xs hover:shadow-sm transition inline-flex items-center justify-center gap-2 cursor-pointer active:scale-95">
                            <i class="ti ti-search text-sm"></i>
                            <span>Terapkan Filter</span>
                        </button>

                        @if(Request('dari') || Request('sampai'))
                            <a href="{{ URL::current() }}" 
                               class="p-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg text-xs font-bold transition inline-flex items-center justify-center shrink-0 border border-slate-200 cursor-pointer active:scale-95" 
                               title="Reset Rentang Tanggal">
                                <i class="ti ti-rotate-2 text-sm"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </form>

        <!-- Mutasi Table Card -->
        <div class="bg-white border border-slate-200/90 rounded-xl shadow-xs overflow-hidden">
            <!-- Seamless Solid Green Card Header -->
            <div class="px-5 py-3.5 bg-emerald-600 flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-white">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-lg bg-white/20 text-white flex items-center justify-center text-xs font-bold border border-white/20 shadow-2xs">
                        <i class="ti ti-history"></i>
                    </div>
                    <h3 class="text-sm font-extrabold text-white tracking-tight">Riwayat Mutasi Saldo Tabungan</h3>
                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-white/20 text-white border border-white/30 shadow-2xs backdrop-blur-xs">
                        {{ count($transaksitabungan) }} data
                    </span>
                </div>
                <div class="text-xs text-emerald-100 font-medium">
                    No. Rek: <span class="font-mono font-bold text-white">{{ $tabungan->no_rekening }}</span> ({{ $tabungan->jenis_tabungan }})
                </div>
            </div>

            <!-- Responsive Table -->
            <div class="overflow-x-auto bg-emerald-600">
                <table class="w-full text-left text-xs sm:text-sm border-0 border-collapse whitespace-nowrap">
                    <!-- Matching Solid Green Table Header -->
                    <thead class="bg-emerald-600 text-white font-bold uppercase tracking-wider text-[11px] border-0 border-t border-b border-emerald-700/80">
                        <tr class="border-0">
                            <th class="py-2.5 px-3.5 w-32 text-emerald-100 whitespace-nowrap">No. Transaksi</th>
                            <th class="py-2.5 px-3.5 w-28 text-emerald-100 whitespace-nowrap">Tanggal</th>
                            <th class="py-2.5 px-3.5 text-emerald-100 whitespace-nowrap">Keterangan / Berita</th>
                            <th class="py-2.5 px-3.5 text-emerald-100 whitespace-nowrap">Petugas</th>
                            <th class="py-2.5 px-3.5 text-right text-emerald-100 whitespace-nowrap">Setor (Rp)</th>
                            <th class="py-2.5 px-3.5 text-right text-emerald-100 whitespace-nowrap">Tarik (Rp)</th>
                            <th class="py-2.5 px-3.5 text-right text-emerald-100 whitespace-nowrap">Saldo Akhir (Rp)</th>
                            <th class="py-2.5 px-3.5 text-center w-24 text-emerald-100 whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700 font-medium bg-white text-xs">
                        
                        <!-- Saldo Awal Row -->
                        <tr class="bg-emerald-50/50 font-bold border-b border-emerald-100/60">
                            <td colspan="4" class="py-2.5 px-3.5 text-center text-xs uppercase tracking-wider text-emerald-800 whitespace-nowrap">
                                <i class="ti ti-corner-down-right text-emerald-600 mr-1"></i> Saldo Awal Periode
                            </td>
                            <td class="py-2.5 px-3.5 text-right text-slate-400 text-xs whitespace-nowrap">-</td>
                            <td class="py-2.5 px-3.5 text-right text-slate-400 text-xs whitespace-nowrap">-</td>
                            <td class="py-2.5 px-3.5 text-right font-bold text-emerald-800 text-xs whitespace-nowrap font-mono">
                                Rp {{ formatRupiah($saldo_awal) }}
                            </td>
                            <td class="py-2.5 px-3.5 whitespace-nowrap"></td>
                        </tr>

                        <!-- Mutasi Records -->
                        @forelse ($transaksitabungan as $d)
                            @php
                                $setor = $d->jenis_transaksi == 'S' ? $d->jumlah : 0;
                                $tarik = $d->jenis_transaksi == 'T' ? $d->jumlah : 0;
                            @endphp
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <!-- No. Transaksi -->
                                <td class="py-2.5 px-3.5 whitespace-nowrap font-bold font-mono text-slate-800">
                                    {{ $d->no_transaksi }}
                                </td>

                                <!-- Tanggal -->
                                <td class="py-2.5 px-3.5 whitespace-nowrap text-slate-600">
                                    {{ DateToIndo($d->tanggal) }}
                                </td>

                                <!-- Berita -->
                                <td class="py-2.5 px-3.5 whitespace-nowrap text-slate-800">
                                    {{ $d->berita }}
                                </td>

                                <!-- Petugas -->
                                <td class="py-2.5 px-3.5 whitespace-nowrap text-slate-500">
                                    {{ $d->name ?: '-' }}
                                </td>

                                <!-- Setor -->
                                <td class="py-2.5 px-3.5 text-right whitespace-nowrap font-bold font-mono">
                                    @if($setor > 0)
                                        <span class="text-emerald-700">+{{ formatRupiah($setor) }}</span>
                                    @else
                                        <span class="text-slate-300">-</span>
                                    @endif
                                </td>

                                <!-- Tarik -->
                                <td class="py-2.5 px-3.5 text-right whitespace-nowrap font-bold font-mono">
                                    @if($tarik > 0)
                                        <span class="text-rose-600">-{{ formatRupiah($tarik) }}</span>
                                    @else
                                        <span class="text-slate-300">-</span>
                                    @endif
                                </td>

                                <!-- Saldo Akhir -->
                                <td class="py-2.5 px-3.5 text-right whitespace-nowrap font-bold font-mono text-slate-900">
                                    Rp {{ formatRupiah($d->saldo) }}
                                </td>

                                <!-- Aksi -->
                                <td class="py-2.5 px-3.5 text-center whitespace-nowrap">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <!-- Cetak Kwitansi -->
                                        <a href="{{ route('simpanan.cetakkwitansi', Crypt::encrypt($d->no_transaksi)) }}"
                                           target="_blank"
                                           class="w-6.5 h-6.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 flex items-center justify-center transition active:scale-95 shadow-2xs"
                                           title="Cetak Kwitansi">
                                            <i class="ti ti-printer text-xs"></i>
                                        </a>

                                        <!-- Show Berita Modal -->
                                        <button type="button" 
                                                class="btnShowberita w-6.5 h-6.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200/80 flex items-center justify-center transition active:scale-95 cursor-pointer shadow-2xs"
                                                berita="{{ $d->berita }}" 
                                                title="Detail Keterangan">
                                            <i class="ti ti-file-text text-xs"></i>
                                        </button>

                                        <!-- Delete (If today & last transaction) -->
                                        @can('tabungan.delete')
                                            @if ($lasttransaksi && $d->no_transaksi == $lasttransaksi->no_transaksi && $d->tanggal == date('Y-m-d'))
                                                <form method="POST" class="deleteform m-0"
                                                      action="{{ route('tabungan.delete', Crypt::encrypt($d->no_transaksi)) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" 
                                                            class="delete-confirm w-6.5 h-6.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200/80 flex items-center justify-center transition active:scale-95 cursor-pointer shadow-2xs"
                                                            title="Hapus Transaksi">
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
                                <td colspan="8" class="py-12 text-center text-slate-400">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center text-xl">
                                            <i class="ti ti-receipt-off"></i>
                                        </div>
                                        <span class="text-xs font-semibold text-slate-600">Tidak ada riwayat mutasi transaksi</span>
                                        <span class="text-[11px] text-slate-400">Silakan pilih rentang tanggal lain atau input transaksi baru</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-5 py-3 bg-slate-50 border-t border-slate-100 flex items-center justify-between text-slate-500 text-xs">
                <span class="font-medium">* Mutasi yang ditampilkan adalah rekam jejak transaksi pada periode yang dipilih.</span>
            </div>
        </div>
    </div>

</div>

<!-- Modals -->
<x-modal-form id="mdlBerita" size="" show="loadmodalberita" title="" />
<x-modal-form id="mdlSetoran" size="" show="loadmodalSetoran" title="" />
@endsection

@push('myscript')
<script>
    $(function() {
        const loading = `
            <div class="flex items-center justify-center p-8">
                <div class="w-8 h-8 border-4 border-emerald-600 border-t-transparent rounded-full animate-spin"></div>
            </div>
        `;

        $(".flatpickr-date").flatpickr({
            dateFormat: "Y-m-d",
            allowInput: true
        });

        $(document).on('click', '.btnShowberita', function(e) {
            e.preventDefault();
            var berita = $(this).attr("berita");
            $("#mdlBerita").modal("show");
            $("#mdlBerita").find(".modal-title").text("Keterangan Transaksi");
            $("#loadmodalberita").html(`
                <div class="p-4 text-slate-800 text-sm leading-relaxed bg-slate-50 rounded-xl border border-slate-200">
                    <div class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Isi Berita / Catatan:</div>
                    <div>${berita || 'Tidak ada keterangan tambahan.'}</div>
                </div>
            `);
        });

        $(document).on('click', '#createSetoran', function(e) {
            e.preventDefault();
            let no_rekening = "{{ Crypt::encrypt($tabungan->no_rekening) }}";
            let jenis_transaksi = "S";
            $('#mdlSetoran').modal("show");
            $("#loadmodalSetoran").html(loading);
            $("#mdlSetoran").find(".modal-title").text("Pencatatan Setoran Tabungan");
            $("#loadmodalSetoran").load("/tabungan/" + no_rekening + "/" + jenis_transaksi + "/create");
        });

        $(document).on('click', '#createPenarikan', function(e) {
            e.preventDefault();
            let no_rekening = "{{ Crypt::encrypt($tabungan->no_rekening) }}";
            let jenis_transaksi = "T";
            $('#mdlSetoran').modal("show");
            $("#loadmodalSetoran").html(loading);
            $("#mdlSetoran").find(".modal-title").text("Pencatatan Penarikan Tabungan");
            $("#loadmodalSetoran").load("/tabungan/" + no_rekening + "/" + jenis_transaksi + "/create");
        });

        // Delete Confirm
        $(document).on('click', '.delete-confirm', function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            Swal.fire({
                title: 'Hapus Transaksi?',
                text: "Anda akan menghapus transaksi terakhir ini. Saldo tabungan akan otomatis disesuaikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#064e3b',
                cancelButtonColor: '#e11d48',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                customClass: {
                    confirmButton: 'px-4 py-2 bg-emerald-700 text-white font-bold rounded-lg text-xs',
                    cancelButton: 'px-4 py-2 bg-rose-600 text-white font-bold rounded-lg text-xs'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush

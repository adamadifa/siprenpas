@extends('layouts.app')
@section('titlepage', 'Simpanan Saya')

@section('content')
<div class="space-y-6">

    <!-- ================= 1. PAGE HEADER & BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <!-- Title & Subtitle -->
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-xl shrink-0 font-bold border border-emerald-200 shadow-2xs">
                <i class="ti ti-wallet"></i>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">
                    Simpanan Saya
                </h1>
                <p class="text-xs text-slate-500 font-medium">
                    Pantau akumulasi saldo simpanan, rincian produk, dan histori mutasi Koperasi Tsarwah Anda
                </p>
            </div>
        </div>

        <!-- Breadcrumb -->
        <div class="flex flex-col md:items-end gap-2.5">
            <nav class="flex items-center text-xs text-slate-400 font-medium">
                <a href="{{ route('dashboard.index') }}" class="hover:text-slate-700 transition flex items-center gap-1">
                    <i class="ti ti-home text-sm"></i>
                    <span>Dashboard</span>
                </a>
                <span class="mx-2 text-slate-300">/</span>
                <span class="text-slate-500">Koperasi Syariah</span>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Simpanan Saya</span>
            </nav>
        </div>
    </div>

    <!-- ================= 2. EMPLOYEE EXECUTIVE PROFILE SHOWCASE BANNER ================= -->
    @if(!empty($karyawan))
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-emerald-800 via-emerald-700 to-teal-700 p-5 sm:p-6 text-white shadow-lg shadow-emerald-900/15 border border-emerald-600/30">
            <!-- Decorative Glow & Watermark -->
            <div class="absolute -right-10 -bottom-10 w-48 h-48 rounded-full bg-white/5 blur-2xl pointer-events-none"></div>
            <div class="absolute right-8 top-1/2 -translate-y-1/2 opacity-10 pointer-events-none">
                <i class="ti ti-building-bank text-9xl"></i>
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
                            <span>Anggota Koperasi Tsarwah</span>
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

    @if (!$is_member)
        <!-- ================= NOT REGISTERED NOTICE ================= -->
        <div class="p-8 sm:p-12 text-center bg-white border border-slate-200/80 rounded-2xl shadow-xs space-y-4">
            <div class="w-16 h-16 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center mx-auto text-3xl border border-amber-200 shadow-inner">
                <i class="ti ti-alert-triangle"></i>
            </div>
            <div class="max-w-md mx-auto space-y-1.5">
                <h3 class="text-base sm:text-lg font-bold text-slate-800">
                    Belum Terdaftar Sebagai Anggota Koperasi
                </h3>
                <p class="text-xs sm:text-sm text-slate-500 leading-relaxed font-medium">
                    Status keanggotaan Koperasi Tsarwah Anda belum aktif. Silakan hubungi pengurus koperasi untuk pendaftaran nomor anggota agar dapat mengakses portofolio simpanan.
                </p>
            </div>
        </div>
    @else
        <!-- ================= 3. OVERVIEW: TOTAL SALDO CANVAS & RECENT TRANSACTIONS ================= -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
            
            <!-- Total Saldo Card (4 Cols) -->
            <div class="lg:col-span-4 relative overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-800 via-emerald-700 to-teal-800 text-white p-6 shadow-lg shadow-emerald-900/15 border border-emerald-600/30 flex flex-col justify-between">
                <div class="absolute -right-8 -bottom-8 w-36 h-36 rounded-full bg-white/5 blur-xl pointer-events-none"></div>
                <div class="absolute right-4 top-4 opacity-10 pointer-events-none">
                    <i class="ti ti-wallet text-7xl"></i>
                </div>

                <div class="relative z-10 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="px-2.5 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-[10px] font-black uppercase tracking-wider text-emerald-200">
                            Total Saldo Akumulasi
                        </span>
                        <div class="w-7 h-7 rounded-lg bg-white/10 flex items-center justify-center text-emerald-200 border border-white/15">
                            <i class="ti ti-coin text-sm"></i>
                        </div>
                    </div>

                    <div class="pt-2">
                        <div class="text-xs text-emerald-200/80 font-medium">Saldo Semua Jenis Simpanan</div>
                        <div class="text-2xl sm:text-3xl font-black text-white font-mono tracking-tight leading-tight mt-1">
                            Rp {{ number_format($total_saldo, 0, ',', '.') }}
                        </div>
                    </div>
                </div>

                <div class="relative z-10 mt-6 pt-4 border-t border-white/15 flex items-center justify-between text-[11px] text-emerald-100/75">
                    <span class="font-medium">Koperasi Tsarwah Al Amin</span>
                    <i class="ti ti-shield-check text-emerald-300 text-sm"></i>
                </div>
            </div>

            <!-- Recent 5 Transactions Mini Table (8 Cols) -->
            <div class="lg:col-span-8 bg-white border border-slate-200/80 rounded-2xl shadow-xs overflow-hidden flex flex-col justify-between">
                <div>
                    <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-base border border-emerald-100">
                                <i class="ti ti-history"></i>
                            </div>
                            <h3 class="text-sm font-bold text-slate-800">5 Transaksi Simpanan Terakhir</h3>
                        </div>
                        <span class="text-[11px] font-semibold text-slate-400">Mutasi Rekening</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs border-collapse">
                            <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider text-[10px] border-b border-slate-100">
                                <tr>
                                    <th class="py-2.5 px-4">Tanggal</th>
                                    <th class="py-2.5 px-4">Jenis Simpanan</th>
                                    <th class="py-2.5 px-4 text-center">Tipe</th>
                                    <th class="py-2.5 px-4 text-right">Nominal (Rp)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                                @forelse ($mutasi as $m)
                                    <tr class="hover:bg-slate-50/80 transition-colors">
                                        <td class="py-3 px-4 text-slate-500 whitespace-nowrap">
                                            {{ date('d-m-Y', strtotime($m->tanggal)) }}
                                        </td>
                                        <td class="py-3 px-4 font-bold text-slate-900">
                                            {{ $m->jenis_simpanan }}
                                        </td>
                                        <td class="py-3 px-4 text-center">
                                            @if ($m->jenis_transaksi == 'D' || $m->jenis_transaksi == 'S')
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-black bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                    <i class="ti ti-arrow-down-left text-[10px]"></i>
                                                    SETORAN
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-black bg-rose-50 text-rose-700 border border-rose-200">
                                                    <i class="ti ti-arrow-up-right text-[10px]"></i>
                                                    TARIK
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4 text-right font-mono font-bold whitespace-nowrap {{ ($m->jenis_transaksi == 'D' || $m->jenis_transaksi == 'S') ? 'text-emerald-600' : 'text-rose-600' }}">
                                            {{ ($m->jenis_transaksi == 'D' || $m->jenis_transaksi == 'S') ? '+' : '-' }} Rp {{ number_format($m->jumlah, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-8 text-center text-slate-400">
                                            Belum ada riwayat transaksi simpanan tercatat.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        <!-- ================= 4. RINCIAN SIMPANAN ANGGOTA GRID ================= -->
        <div class="space-y-4 pt-2">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-base font-bold">
                        <i class="ti ti-coins"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 tracking-tight">Rincian Simpanan Anggota</h3>
                </div>
                <span class="text-xs font-semibold text-slate-400">{{ count($saldo_simpanan) }} Jenis Simpanan</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($saldo_simpanan as $index => $s)
                    @php
                        // Cycle through distinct luxury bank card gradient palettes
                        $cardThemes = [
                            [
                                'bg' => 'bg-gradient-to-br from-emerald-900 via-emerald-800 to-teal-950',
                                'border' => 'border-emerald-500/40',
                                'chip' => 'from-amber-300 via-amber-400 to-yellow-500',
                                'accent' => 'text-emerald-300',
                                'badge_bg' => 'bg-emerald-400/20 text-emerald-200 border-emerald-300/30',
                                'glow' => 'bg-emerald-500/15',
                                'type_tag' => 'EMERALD PLATINUM'
                            ],
                            [
                                'bg' => 'bg-gradient-to-br from-slate-900 via-slate-800 to-emerald-950',
                                'border' => 'border-slate-500/40',
                                'chip' => 'from-amber-200 via-yellow-400 to-amber-600',
                                'accent' => 'text-amber-300',
                                'badge_bg' => 'bg-amber-400/20 text-amber-200 border-amber-300/30',
                                'glow' => 'bg-teal-500/15',
                                'type_tag' => 'BLACK PRIORITY'
                            ],
                            [
                                'bg' => 'bg-gradient-to-br from-teal-900 via-cyan-950 to-emerald-950',
                                'border' => 'border-teal-500/40',
                                'chip' => 'from-yellow-300 via-amber-400 to-yellow-600',
                                'accent' => 'text-teal-300',
                                'badge_bg' => 'bg-teal-400/20 text-teal-200 border-teal-300/30',
                                'glow' => 'bg-cyan-500/15',
                                'type_tag' => 'CYBER SYARIAH'
                            ],
                        ];
                        $theme = $cardThemes[$index % count($cardThemes)];
                        $maskedCardNumber = '6080 ' . str_pad($s->kode_simpanan, 4, '0', STR_PAD_LEFT) . ' ' . substr(str_replace('-', '', $karyawan->npp ?? '88888888'), 0, 4) . ' ' . rand(1000, 9999);
                    @endphp

                    <!-- ATM / DEBIT CARD WRAPPER -->
                    <div class="relative group">
                        
                        <!-- ATM Card Container (Aspect Ratio Standard Credit Card) -->
                        <div class="relative overflow-hidden rounded-2xl {{ $theme['bg'] }} p-6 text-white shadow-xl shadow-slate-950/20 border {{ $theme['border'] }} transition-all duration-300 transform group-hover:-translate-y-1.5 group-hover:shadow-2xl flex flex-col justify-between min-h-[220px]">
                            
                            <!-- Ambient Glow & Pattern Textures -->
                            <div class="absolute -right-12 -bottom-12 w-40 h-40 rounded-full {{ $theme['glow'] }} blur-2xl pointer-events-none"></div>
                            <div class="absolute -left-12 -top-12 w-40 h-40 rounded-full bg-white/5 blur-2xl pointer-events-none"></div>
                            <div class="absolute inset-0 bg-radial-pattern opacity-10 pointer-events-none" style="background-image: radial-gradient(rgba(255,255,255,0.4) 1px, transparent 1px); background-size: 16px 16px;"></div>

                            <!-- CARD TOP: Institution Name & Chip / Contactless -->
                            <div class="relative z-10 flex items-start justify-between gap-2">
                                <div class="space-y-0.5">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-lg bg-white/10 backdrop-blur-md p-1 border border-white/20 flex items-center justify-center">
                                            <i class="ti ti-building-bank text-xs text-white"></i>
                                        </div>
                                        <span class="font-extrabold text-xs tracking-wider text-white uppercase">
                                            TSARWAH SYARIAH
                                        </span>
                                    </div>
                                    <span class="text-[9px] font-semibold text-emerald-200/70 tracking-widest block uppercase pl-8">
                                        {{ $theme['type_tag'] }}
                                    </span>
                                </div>

                                <!-- Contactless Wave & Card Type Badge -->
                                <div class="flex items-center gap-2">
                                    <i class="ti ti-wifi text-lg text-white/70 rotate-90"></i>
                                    <span class="px-2 py-0.5 rounded-full {{ $theme['badge_bg'] }} border text-[10px] font-mono font-bold tracking-wider">
                                        {{ $s->kode_simpanan }}
                                    </span>
                                </div>
                            </div>

                            <!-- CARD MIDDLE: EMV Metallic Chip & Hologram -->
                            <div class="relative z-10 flex items-center justify-between my-3">
                                <!-- Realistic Metallic Chip -->
                                <div class="relative w-11 h-8 rounded-md bg-gradient-to-tr {{ $theme['chip'] }} p-0.5 shadow-sm border border-yellow-200/60 overflow-hidden">
                                    <div class="w-full h-full border border-yellow-800/40 rounded-[3px] grid grid-cols-2 gap-0.5 p-0.5 opacity-80">
                                        <div class="border-b border-r border-yellow-900/50"></div>
                                        <div class="border-b border-yellow-900/50"></div>
                                        <div class="border-r border-yellow-900/50"></div>
                                        <div></div>
                                    </div>
                                    <div class="absolute inset-0 bg-white/20 transform -skew-x-12"></div>
                                </div>

                                <!-- Product Name Tag -->
                                <div class="text-right">
                                    <span class="text-[10px] uppercase tracking-wider text-white/60 font-semibold block">Jenis Simpanan</span>
                                    <h4 class="text-sm font-bold text-white tracking-tight leading-tight">
                                        {{ $s->jenis_simpanan }}
                                    </h4>
                                </div>
                            </div>

                            <!-- CARD NUMBERS (Embossed Monospace Style) -->
                            <div class="relative z-10 my-1">
                                <div class="font-mono text-sm sm:text-base tracking-[0.2em] font-black text-white/95 drop-shadow-[0_1px_2px_rgba(0,0,0,0.8)]">
                                    {{ $maskedCardNumber }}
                                </div>
                            </div>

                            <!-- CARD BOTTOM: Cardholder Name & Saldo -->
                            <div class="relative z-10 pt-2 border-t border-white/10 flex items-end justify-between">
                                <div>
                                    <span class="block text-[8px] font-bold uppercase tracking-widest text-emerald-200/70">Cardholder</span>
                                    <div class="text-xs font-bold text-white tracking-wide uppercase truncate max-w-[150px]">
                                        {{ $karyawan->nama_lengkap ?? 'Anggota Koperasi' }}
                                    </div>
                                </div>

                                <div class="text-right">
                                    <span class="block text-[8px] font-bold uppercase tracking-widest text-emerald-200/70">Saldo Rekening</span>
                                    <div class="text-base sm:text-lg font-black font-mono text-white tracking-tight drop-shadow-sm leading-tight">
                                        Rp {{ number_format($s->jumlah, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Quick Action Button Bar Below Card -->
                        <div class="mt-2.5">
                            <button type="button" 
                                    class="w-full py-2.5 px-4 rounded-xl bg-white hover:bg-slate-50 active:scale-[0.99] text-slate-800 font-bold text-xs border border-slate-200/90 shadow-2xs hover:border-emerald-300 hover:text-emerald-800 transition-all flex items-center justify-center gap-2 cursor-pointer btn-view-mutasi"
                                    data-id="{{ $s->kode_simpanan }}">
                                <i class="ti ti-receipt text-emerald-600 text-sm"></i>
                                <span>Cek Mutasi Rekening {{ $s->kode_simpanan }}</span>
                                <i class="ti ti-arrow-right text-slate-400 text-xs ml-auto"></i>
                            </button>
                        </div>

                    </div>
                @empty
                    <div class="col-span-full text-center py-12 bg-white border border-slate-200/80 rounded-2xl shadow-xs">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto mb-3 text-2xl border border-emerald-100">
                            <i class="ti ti-credit-card-off"></i>
                        </div>
                        <h4 class="text-sm font-bold text-slate-800">Kartu Simpanan Belum Tersedia</h4>
                        <p class="text-xs text-slate-400 font-medium mt-1">
                            Rincian saldo simpanan belum terdaftar pada akun koperasi Anda.
                        </p>
                    </div>
                @endforelse
            </div>
        </div>
    @endif

</div>

<!-- Modal Form Mutasi Rekening -->
<x-modal-form id="mdlMutasiSimpanan" size="modal-lg" show="loadMutasiSimpanan" title="Mutasi Rekening Simpanan" />

@endsection

@push('myscript')
<script>
    $(function() {
        $(".btn-view-mutasi").click(function(e) {
            e.preventDefault();
            var kode_simpanan = $(this).attr("data-id");
            $('#mdlMutasiSimpanan').modal("show");
            $("#loadMutasiSimpanan").html(`
                <div class="p-8 text-center">
                    <i class="ti ti-loader-2 text-3xl text-emerald-600 animate-spin mb-2"></i>
                    <p class="text-xs text-slate-500 font-medium">Memuat mutasi rekening simpanan...</p>
                </div>
            `);
            $("#loadMutasiSimpanan").load('/simpanansaya/mutasi/' + kode_simpanan);
        });
    });
</script>
@endpush

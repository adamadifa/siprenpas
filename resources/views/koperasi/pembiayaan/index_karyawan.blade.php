@extends('layouts.app')
@section('titlepage', 'Pinjaman Saya')

@section('content')
<div class="space-y-6">

    <!-- ================= 1. PAGE HEADER & BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <!-- Title & Subtitle -->
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-xl shrink-0 font-bold border border-emerald-200 shadow-2xs">
                <i class="ti ti-credit-card"></i>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">
                    Pinjaman & Pembiayaan Saya
                </h1>
                <p class="text-xs text-slate-500 font-medium">
                    Pantau status pembiayaan syariah, rincian sisa tagihan, dan histori jadwal cicilan Koperasi Tsarwah Anda
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
                <span class="font-bold text-slate-800">Pinjaman Saya</span>
            </nav>
        </div>
    </div>

    <!-- ================= 2. EMPLOYEE EXECUTIVE SHOWCASE BANNER ================= -->
    @if(!empty($karyawan))
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-emerald-800 via-emerald-700 to-teal-700 p-5 sm:p-6 text-white shadow-lg shadow-emerald-900/15 border border-emerald-600/30">
            <!-- Decorative Glow & Watermark -->
            <div class="absolute -right-10 -bottom-10 w-48 h-48 rounded-full bg-white/5 blur-2xl pointer-events-none"></div>
            <div class="absolute right-8 top-1/2 -translate-y-1/2 opacity-10 pointer-events-none">
                <i class="ti ti-receipt-tax text-9xl"></i>
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
                            <span>Portofolio Pembiayaan</span>
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
                    Status keanggotaan Koperasi Tsarwah Anda belum aktif. Silakan hubungi pengurus koperasi untuk pendaftaran nomor anggota terlebih dahulu agar dapat mengajukan dan memantau pembiayaan.
                </p>
            </div>
        </div>
    @else
        <!-- ================= 3. DAFTAR KARTU PEMBIAYAAN & CICILAN ================= -->
        <div class="space-y-4 pt-1">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-base font-bold">
                        <i class="ti ti-receipt-2"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 tracking-tight">Daftar Akad Pembiayaan Anda</h3>
                </div>
                <span class="text-xs font-semibold text-slate-400">{{ count($pembiayaan) }} Akad Terdaftar</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($pembiayaan as $index => $d)
                    @php
                        $jumlah_pembiayaan = $d->jumlah + ($d->jumlah * ($d->persentase / 100));
                        $total_bayar = $d->total_bayar ?? 0;
                        $sisa_tagihan = max(0, $jumlah_pembiayaan - $total_bayar);
                        $persen_progress = $jumlah_pembiayaan > 0 ? min(100, round(($total_bayar / $jumlah_pembiayaan) * 100)) : 0;
                        $isLunas = $sisa_tagihan <= 0;

                        // Theme per card
                        $cardThemes = [
                            [
                                'bg' => 'bg-gradient-to-br from-emerald-900 via-emerald-800 to-teal-950',
                                'border' => 'border-emerald-500/40',
                                'chip' => 'from-amber-300 via-amber-400 to-yellow-500',
                                'badge' => 'EMERALD CONTRACT',
                            ],
                            [
                                'bg' => 'bg-gradient-to-br from-slate-900 via-slate-800 to-emerald-950',
                                'border' => 'border-slate-500/40',
                                'chip' => 'from-amber-200 via-yellow-400 to-amber-600',
                                'badge' => 'PLATINUM CONTRACT',
                            ],
                            [
                                'bg' => 'bg-gradient-to-br from-teal-900 via-cyan-950 to-emerald-950',
                                'border' => 'border-teal-500/40',
                                'chip' => 'from-yellow-300 via-amber-400 to-yellow-600',
                                'badge' => 'SYARIAH CONTRACT',
                            ],
                        ];
                        $theme = $cardThemes[$index % count($cardThemes)];
                    @endphp

                    <!-- LUXURY ATM / AKAD CARD WRAPPER -->
                    <div class="relative group">
                        <div class="relative overflow-hidden rounded-2xl {{ $theme['bg'] }} p-6 text-white shadow-xl shadow-slate-950/20 border {{ $theme['border'] }} transition-all duration-300 transform group-hover:-translate-y-1.5 group-hover:shadow-2xl flex flex-col justify-between min-h-[260px]">
                            
                            <!-- Ambient Glow & Pattern Textures -->
                            <div class="absolute -right-12 -bottom-12 w-40 h-40 rounded-full bg-white/5 blur-2xl pointer-events-none"></div>
                            <div class="absolute -left-12 -top-12 w-40 h-40 rounded-full bg-emerald-500/10 blur-2xl pointer-events-none"></div>
                            <div class="absolute inset-0 bg-radial-pattern opacity-10 pointer-events-none" style="background-image: radial-gradient(rgba(255,255,255,0.4) 1px, transparent 1px); background-size: 16px 16px;"></div>

                            <!-- CARD TOP: Institution & Status Badge -->
                            <div class="relative z-10 flex items-start justify-between gap-2">
                                <div class="space-y-0.5">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-lg bg-white/10 backdrop-blur-md p-1 border border-white/20 flex items-center justify-center">
                                            <i class="ti ti-receipt-tax text-xs text-white"></i>
                                        </div>
                                        <span class="font-extrabold text-xs tracking-wider text-white uppercase">
                                            PEMBIAYAAN SYARIAH
                                        </span>
                                    </div>
                                    <span class="text-[9px] font-semibold text-emerald-200/70 tracking-widest block uppercase pl-8">
                                        {{ $theme['badge'] }}
                                    </span>
                                </div>

                                <!-- Status Pill -->
                                <div>
                                    @if($isLunas)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-emerald-500/30 border border-emerald-400 text-emerald-200 text-[10px] font-black tracking-wider uppercase shadow-xs">
                                            <i class="ti ti-circle-check text-xs"></i> LUNAS
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-amber-500/30 border border-amber-400 text-amber-200 text-[10px] font-black tracking-wider uppercase shadow-xs animate-pulse">
                                            <i class="ti ti-clock text-xs"></i> BERJALAN
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- CARD MIDDLE: Metallic Chip & Akad Details -->
                            <div class="relative z-10 flex items-center justify-between my-2">
                                <!-- Metallic Chip -->
                                <div class="relative w-11 h-8 rounded-md bg-gradient-to-tr {{ $theme['chip'] }} p-0.5 shadow-sm border border-yellow-200/60 overflow-hidden shrink-0">
                                    <div class="w-full h-full border border-yellow-800/40 rounded-[3px] grid grid-cols-2 gap-0.5 p-0.5 opacity-80">
                                        <div class="border-b border-r border-yellow-900/50"></div>
                                        <div class="border-b border-yellow-900/50"></div>
                                        <div class="border-r border-yellow-900/50"></div>
                                        <div></div>
                                    </div>
                                </div>

                                <div class="text-right min-w-0 pl-2">
                                    <span class="text-[9px] uppercase tracking-wider text-emerald-200/70 font-semibold block">Jenis Pembiayaan</span>
                                    <h4 class="text-xs sm:text-sm font-bold text-white tracking-tight leading-tight truncate">
                                        {{ $d->jenis_pembiayaan }}
                                    </h4>
                                </div>
                            </div>

                            <!-- AKAD NUMBER (Embossed Monospace) -->
                            <div class="relative z-10 my-0.5 flex items-center justify-between text-xs">
                                <div class="font-mono tracking-[0.15em] font-black text-white/95 drop-shadow-[0_1px_2px_rgba(0,0,0,0.8)]">
                                    {{ $d->no_akad }}
                                </div>
                                <div class="text-[10px] text-white/70 font-medium">
                                    {{ $d->jangka_waktu }} Bln &bull; {{ date('d/m/Y', strtotime($d->tanggal)) }}
                                </div>
                            </div>

                            <!-- FINANCIAL METRICS -->
                            <div class="relative z-10 pt-2.5 border-t border-white/10 space-y-2">
                                <div class="grid grid-cols-3 gap-1 text-[10px]">
                                    <div>
                                        <span class="text-white/60 block text-[8px] uppercase">Total Akad</span>
                                        <span class="font-bold font-mono text-white text-xs">Rp {{ formatAngka($jumlah_pembiayaan) }}</span>
                                    </div>
                                    <div>
                                        <span class="text-white/60 block text-[8px] uppercase">Terbayar</span>
                                        <span class="font-bold font-mono text-emerald-300 text-xs">Rp {{ formatAngka($total_bayar) }}</span>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-white/60 block text-[8px] uppercase">Sisa Tagihan</span>
                                        <span class="font-bold font-mono text-rose-300 text-xs">Rp {{ formatAngka($sisa_tagihan) }}</span>
                                    </div>
                                </div>

                                <!-- Progress Bar -->
                                <div class="space-y-1">
                                    <div class="flex items-center justify-between text-[9px] text-emerald-100/80">
                                        <span>Progress Cicilan</span>
                                        <span class="font-black">{{ $persen_progress }}%</span>
                                    </div>
                                    <div class="w-full h-1.5 bg-black/30 rounded-full overflow-hidden">
                                        <div class="h-full bg-gradient-to-r from-emerald-400 to-teal-300 rounded-full transition-all duration-500" style="width: {{ $persen_progress }}%;"></div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Action Button Bar -->
                        <div class="mt-2.5">
                            <button type="button" 
                                    class="w-full py-2.5 px-4 rounded-xl bg-white hover:bg-slate-50 active:scale-[0.99] text-slate-800 font-bold text-xs border border-slate-200/90 shadow-2xs hover:border-emerald-300 hover:text-emerald-800 transition-all flex items-center justify-center gap-2 cursor-pointer btn-view-plan"
                                    data-id="{{ Crypt::encrypt($d->no_akad) }}">
                                <i class="ti ti-calendar-stats text-emerald-600 text-sm"></i>
                                <span>Lihat Rencana Angsuran & Cicilan</span>
                                <i class="ti ti-arrow-right text-slate-400 text-xs ml-auto"></i>
                            </button>
                        </div>

                    </div>
                @empty
                    <div class="col-span-full text-center py-12 bg-white border border-slate-200/80 rounded-2xl shadow-xs">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto mb-3 text-2xl border border-emerald-100">
                            <i class="ti ti-credit-card-off"></i>
                        </div>
                        <h4 class="text-sm font-bold text-slate-800">Belum Ada Riwayat Pembiayaan</h4>
                        <p class="text-xs text-slate-400 font-medium mt-1">
                            Anda belum memiliki riwayat pembiayaan atau pinjaman aktif di Koperasi Tsarwah.
                        </p>
                    </div>
                @endforelse
            </div>
        </div>
    @endif

</div>

<!-- Modal Form Rencana Angsuran -->
<x-modal-form id="mdlRencanaAngsuran" size="modal-xl" show="loadRencanaAngsuran" title="Rencana & Riwayat Angsuran Pembiayaan" />

@endsection

@push('myscript')
<script>
    $(function() {
        $(".btn-view-plan").click(function(e) {
            e.preventDefault();
            var no_akad = $(this).attr("data-id");
            $('#mdlRencanaAngsuran').modal("show");
            $("#loadRencanaAngsuran").html(`
                <div class="p-8 text-center">
                    <i class="ti ti-loader-2 text-3xl text-emerald-600 animate-spin mb-2"></i>
                    <p class="text-xs text-slate-500 font-medium">Memuat rincian jadwal cicilan & akad...</p>
                </div>
            `);
            $("#loadRencanaAngsuran").load('/pembiayaan/' + no_akad + '/showdetail');
        });
    });
</script>
@endpush

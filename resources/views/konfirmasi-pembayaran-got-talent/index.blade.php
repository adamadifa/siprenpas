@extends('layouts.app')
@section('titlepage', 'Konfirmasi Pembayaran Got Talent')

@section('content')
<div class="space-y-5">

    <!-- ================= 1. PAGE HEADER (NO CARD) WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <i class="ti ti-receipt-tax text-emerald-600 text-2xl"></i>
                <span>Konfirmasi Pembayaran Got Talent</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Verifikasi bukti transfer dan pembayaran registrasi peserta Al Amin Got Talent
            </p>
        </div>

        <!-- Right Side: Breadcrumb -->
        <div class="flex flex-col md:items-end gap-2.5">
            <nav class="flex items-center text-xs text-slate-400 font-medium">
                <a href="{{ route('dashboard.index') }}" class="hover:text-slate-700 transition flex items-center gap-1">
                    <i class="ti ti-home text-sm"></i>
                    <span>Dashboard</span>
                </a>
                <span class="mx-2 text-slate-300">/</span>
                <span class="text-slate-500 flex items-center gap-1">
                    <i class="ti ti-sparkles text-sm"></i>
                    <span>Al Amin Got Talent</span>
                </span>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Konfirmasi Pembayaran</span>
            </nav>
        </div>
    </div>

    <!-- ================= 2. EXECUTIVE STATISTICS SUMMARY (SOLID & CLEAN CARDS) ================= -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
        <!-- Total Konfirmasi -->
        <div class="bg-slate-800 hover:bg-slate-900 text-white rounded-2xl p-4 shadow-xs hover:shadow-md transition-all duration-200 relative overflow-hidden flex flex-col justify-between">
            <div class="absolute -right-5 -bottom-5 w-24 h-24 rounded-full bg-white/[0.06] pointer-events-none"></div>
            <div class="relative z-10 flex items-start justify-between gap-2">
                <div class="min-w-0 flex-1">
                    <span class="text-[10.5px] font-bold uppercase tracking-wider text-slate-300 block truncate">
                        Total Konfirmasi
                    </span>
                    <div class="text-2xl sm:text-3xl font-black text-white tracking-tight mt-1 flex items-baseline gap-1.5">
                        <span>{{ $totalKonfirmasi ?? 0 }}</span>
                        <span class="text-xs font-semibold text-slate-300">transaksi</span>
                    </div>
                </div>
                <div class="w-9 h-9 rounded-xl bg-white/10 text-white flex items-center justify-center text-lg font-bold border border-white/10 shadow-2xs backdrop-blur-xs">
                    <i class="ti ti-receipt-tax"></i>
                </div>
            </div>
            <div class="relative z-10 mt-3 pt-2.5 border-t border-slate-700 text-slate-300 flex items-center justify-between text-[11px]">
                <span>Total pengajuan masuk</span>
                <span class="font-bold text-white">Semua</span>
            </div>
        </div>

        <!-- Pending Verifikasi -->
        <div class="bg-amber-500 hover:bg-amber-600 text-white rounded-2xl p-4 shadow-xs hover:shadow-md transition-all duration-200 relative overflow-hidden flex flex-col justify-between">
            <div class="absolute -right-5 -bottom-5 w-24 h-24 rounded-full bg-white/[0.08] pointer-events-none"></div>
            <div class="relative z-10 flex items-start justify-between gap-2">
                <div class="min-w-0 flex-1">
                    <span class="text-[10.5px] font-bold uppercase tracking-wider text-amber-100 block truncate">
                        Menunggu Verifikasi
                    </span>
                    <div class="text-2xl sm:text-3xl font-black text-white tracking-tight mt-1 flex items-baseline gap-1.5">
                        <span>{{ $totalPending ?? 0 }}</span>
                        <span class="text-xs font-semibold text-amber-200">pending</span>
                    </div>
                </div>
                <div class="w-9 h-9 rounded-xl bg-white/20 text-white flex items-center justify-center text-lg font-bold border border-white/20 shadow-2xs backdrop-blur-xs">
                    <i class="ti ti-clock-hour-4"></i>
                </div>
            </div>
            <div class="relative z-10 mt-3 pt-2.5 border-t border-amber-400/80 text-amber-100 flex items-center justify-between text-[11px]">
                <span>Perlu diperiksa admin</span>
                <span class="font-bold bg-white/20 px-2 py-0.5 rounded-md backdrop-blur-xs text-white">Action</span>
            </div>
        </div>

        <!-- Diverifikasi (Berhasil) -->
        <div class="bg-emerald-600 hover:bg-emerald-700 text-white rounded-2xl p-4 shadow-xs hover:shadow-md transition-all duration-200 relative overflow-hidden flex flex-col justify-between">
            <div class="absolute -right-5 -bottom-5 w-24 h-24 rounded-full bg-white/[0.08] pointer-events-none"></div>
            <div class="relative z-10 flex items-start justify-between gap-2">
                <div class="min-w-0 flex-1">
                    <span class="text-[10.5px] font-bold uppercase tracking-wider text-emerald-100 block truncate">
                        Diverifikasi (Valid)
                    </span>
                    <div class="text-2xl sm:text-3xl font-black text-white tracking-tight mt-1 flex items-baseline gap-1.5">
                        <span>{{ $totalDiverifikasi ?? 0 }}</span>
                        <span class="text-xs font-semibold text-emerald-200">disetujui</span>
                    </div>
                </div>
                <div class="w-9 h-9 rounded-xl bg-white/20 text-white flex items-center justify-center text-lg font-bold border border-white/20 shadow-2xs backdrop-blur-xs">
                    <i class="ti ti-circle-check"></i>
                </div>
            </div>
            <div class="relative z-10 mt-3 pt-2.5 border-t border-emerald-500/80 text-emerald-100 flex items-center justify-between text-[11px]">
                <span>Total Dana Valid:</span>
                <span class="font-bold text-white">Rp {{ formatRupiah($totalDanaMasuk ?? 0) }}</span>
            </div>
        </div>

        <!-- Ditolak -->
        <div class="bg-rose-600 hover:bg-rose-700 text-white rounded-2xl p-4 shadow-xs hover:shadow-md transition-all duration-200 relative overflow-hidden flex flex-col justify-between">
            <div class="absolute -right-5 -bottom-5 w-24 h-24 rounded-full bg-white/[0.08] pointer-events-none"></div>
            <div class="relative z-10 flex items-start justify-between gap-2">
                <div class="min-w-0 flex-1">
                    <span class="text-[10.5px] font-bold uppercase tracking-wider text-rose-100 block truncate">
                        Ditolak / Tidak Valid
                    </span>
                    <div class="text-2xl sm:text-3xl font-black text-white tracking-tight mt-1 flex items-baseline gap-1.5">
                        <span>{{ $totalDitolak ?? 0 }}</span>
                        <span class="text-xs font-semibold text-rose-200">transaksi</span>
                    </div>
                </div>
                <div class="w-9 h-9 rounded-xl bg-white/20 text-white flex items-center justify-center text-lg font-bold border border-white/20 shadow-2xs backdrop-blur-xs">
                    <i class="ti ti-circle-x"></i>
                </div>
            </div>
            <div class="relative z-10 mt-3 pt-2.5 border-t border-rose-500/80 text-rose-100 flex items-center justify-between text-[11px]">
                <span>Bukti tidak sesuai</span>
                <span class="font-bold text-white">Ditolak</span>
            </div>
        </div>
    </div>

    <!-- ================= 3. FILTER & SEARCH TOOLBAR ================= -->
    <form action="{{ route('konfirmasi-pembayaran-got-talent.index') }}" method="GET" class="w-full">
        <div class="flex flex-col sm:flex-row items-center gap-2.5 sm:gap-3 w-full">
            <!-- Search Input -->
            <div class="flex-1 min-w-0 w-full relative">
                <i class="ti ti-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-lg pointer-events-none"></i>
                <input type="text" 
                       name="search" 
                       value="{{ Request('search') }}" 
                       placeholder="Cari Nama Lengkap, No. Register, atau Email..." 
                       class="w-full pl-11 pr-4 py-2.5 sm:py-3 text-sm bg-white border border-slate-300 rounded-xl text-slate-800 font-medium placeholder-slate-400 shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
            </div>

            <!-- Filter Status -->
            <div class="w-full sm:w-56 relative">
                <i class="ti ti-filter absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-lg pointer-events-none"></i>
                <select name="status" 
                        class="w-full pl-11 pr-8 py-2.5 sm:py-3 text-sm bg-white border border-slate-300 rounded-xl text-slate-800 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition appearance-none">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ Request('status') == 'pending' ? 'selected' : '' }}>Pending (Menunggu)</option>
                    <option value="diverifikasi" {{ Request('status') == 'diverifikasi' ? 'selected' : '' }}>Diverifikasi</option>
                    <option value="ditolak" {{ Request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
                <i class="ti ti-chevron-down absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
            </div>

            <!-- Submit & Reset Buttons -->
            <div class="flex items-center gap-2 shrink-0 w-full sm:w-auto">
                <button type="submit" class="w-full sm:w-auto px-5 py-2.5 sm:py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl shadow-xs transition inline-flex items-center justify-center gap-2 cursor-pointer active:scale-95 whitespace-nowrap">
                    <i class="ti ti-search text-base"></i>
                    <span>Cari</span>
                </button>
                @if(Request('search') || Request('status'))
                    <a href="{{ route('konfirmasi-pembayaran-got-talent.index') }}" class="py-2.5 sm:py-3 px-3 bg-white hover:bg-slate-100 text-slate-600 border border-slate-300 rounded-xl font-semibold text-sm transition inline-flex items-center justify-center shrink-0 shadow-xs" title="Reset Filter">
                        <i class="ti ti-refresh text-base"></i>
                    </a>
                @endif
            </div>
        </div>
    </form>

    <!-- ================= 4. DATA TABLE SECTION (SEAMLESS SOLID GREEN HEADER) ================= -->
    <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
        
        <!-- Seamless Solid Green Card Header -->
        <div class="px-5 pt-4 pb-2.5 bg-emerald-600 flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-white border-0">
            <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-lg bg-white/20 text-white flex items-center justify-center text-xs font-bold border border-white/20 shadow-2xs">
                    <i class="ti ti-receipt-2"></i>
                </div>
                <h3 class="text-sm font-extrabold text-white tracking-tight">Daftar Konfirmasi Pembayaran</h3>
                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-white/20 text-white border border-white/30 shadow-2xs backdrop-blur-xs">
                    {{ $konfirmasi->total() }} data
                </span>
            </div>
            <div class="text-xs text-emerald-100 font-medium">
                Pemeriksaan bukti transfer & validasi pembayaran peserta
            </div>
        </div>

        <!-- Responsive Table Container -->
        <div class="overflow-x-auto bg-emerald-600">
            <table class="w-full text-left text-xs sm:text-sm border-0 border-collapse">
                <!-- Matching Solid Green Table Header -->
                <thead class="bg-emerald-600 text-white font-bold uppercase tracking-wider text-[11px] border-0 border-t-0 border-b border-emerald-700/80">
                    <tr class="border-0 border-t-0">
                        <th class="py-2 px-3.5 w-10 text-center text-emerald-100 border-0 border-t-0">No</th>
                        <th class="py-2 px-3.5 w-24 whitespace-nowrap text-emerald-100 border-0 border-t-0">Tgl Bayar</th>
                        <th class="py-2 px-3.5 w-28 text-emerald-100 border-0 border-t-0">No. Register</th>
                        <th class="py-2 px-3.5 text-emerald-100 border-0 border-t-0">Nama Peserta</th>
                        <th class="py-2 px-3.5 w-28 text-emerald-100 border-0 border-t-0">Jenjang</th>
                        <th class="py-2 px-3.5 w-32 text-right text-emerald-100 border-0 border-t-0">Jumlah</th>
                        <th class="py-2 px-3.5 w-24 text-emerald-100 border-0 border-t-0">Metode</th>
                        <th class="py-2 px-3.5 text-center w-24 text-emerald-100 border-0 border-t-0">Status</th>
                        <th class="py-2 px-3.5 text-center w-20 text-emerald-100 border-0 border-t-0">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700 font-medium bg-white">
                    @forelse ($konfirmasi as $d)
                        <tr class="hover:bg-slate-50/80 transition-colors group">
                            <!-- No -->
                            <td class="py-2 px-3.5 text-center text-slate-400 font-bold text-xs">
                                <span class="w-5.5 h-5.5 rounded-md bg-slate-100 group-hover:bg-emerald-50 group-hover:text-emerald-700 group-hover:border group-hover:border-emerald-200 inline-flex items-center justify-center font-bold text-slate-600 transition text-[11px]">
                                    {{ $loop->iteration + ($konfirmasi->currentPage() - 1) * $konfirmasi->perPage() }}
                                </span>
                            </td>

                            <!-- Tanggal Pembayaran -->
                            <td class="py-2 px-3.5 whitespace-nowrap">
                                <div class="text-xs text-slate-600 font-semibold flex items-center gap-1">
                                    <i class="ti ti-calendar text-slate-400 text-xs"></i>
                                    <span>{{ $d->tanggal_pembayaran ? DateToIndo($d->tanggal_pembayaran) : '-' }}</span>
                                </div>
                            </td>

                            <!-- Nomor Register -->
                            <td class="py-2 px-3.5 whitespace-nowrap">
                                <span class="px-2 py-0.5 rounded-md text-[11px] font-black font-mono tracking-wider bg-emerald-50 text-emerald-800 border border-emerald-200/80 shadow-2xs">
                                    {{ $d->pendaftaran->nomor_register ?? '-' }}
                                </span>
                            </td>

                            <!-- Nama Lengkap -->
                            <td class="py-2 px-3.5">
                                <span class="font-bold text-slate-900 group-hover:text-emerald-800 transition text-xs sm:text-sm line-clamp-1">
                                    {{ $d->pendaftaran->nama_lengkap ?? '-' }}
                                </span>
                            </td>

                            <!-- Jenjang Pendidikan -->
                            <td class="py-2 px-3.5 whitespace-nowrap">
                                @if(!empty($d->pendaftaran->jenjangPendidikan))
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[11px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-100 shadow-2xs">
                                        <i class="ti ti-school text-[11px]"></i>
                                        <span>{{ $d->pendaftaran->jenjangPendidikan->jenjang_pendidikan }}</span>
                                    </span>
                                @else
                                    <span class="text-slate-400 italic text-xs">-</span>
                                @endif
                            </td>

                            <!-- Jumlah Pembayaran -->
                            <td class="py-2 px-3.5 text-right whitespace-nowrap">
                                <span class="font-mono font-bold text-xs sm:text-sm text-slate-900">
                                    Rp {{ formatRupiah($d->jumlah_pembayaran) }}
                                </span>
                            </td>

                            <!-- Metode Pembayaran -->
                            <td class="py-2 px-3.5 whitespace-nowrap">
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[11px] font-bold bg-slate-100 text-slate-700 border border-slate-200 shadow-2xs">
                                    <i class="ti ti-credit-card text-xs text-slate-500"></i>
                                    <span>{{ ucfirst($d->metode_pembayaran ?? 'Transfer') }}</span>
                                </span>
                            </td>

                            <!-- Status -->
                            <td class="py-2 px-3.5 text-center whitespace-nowrap">
                                @if ($d->status == 'pending')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200 shadow-2xs">
                                        <i class="ti ti-clock-hour-4 text-[11px]"></i>
                                        <span>Pending</span>
                                    </span>
                                @elseif ($d->status == 'diverifikasi')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 shadow-2xs">
                                        <i class="ti ti-circle-check text-[11px]"></i>
                                        <span>Diverifikasi</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200 shadow-2xs">
                                        <i class="ti ti-circle-x text-[11px]"></i>
                                        <span>Ditolak</span>
                                    </span>
                                @endif
                            </td>

                            <!-- Action Buttons -->
                            <td class="py-2 px-3.5 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-1.5">
                                    <!-- Lihat Halaman Show/Verifikasi -->
                                    <a href="{{ route('konfirmasi-pembayaran-got-talent.show', Crypt::encrypt($d->id)) }}" 
                                       class="w-7.5 h-7.5 rounded-lg bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200/80 flex items-center justify-center transition active:scale-95 shadow-2xs"
                                       title="Lihat Detail & Verifikasi">
                                        <i class="ti ti-eye text-sm"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="py-12 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-14 h-14 rounded-2xl bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-400 text-2xl mb-3">
                                        <i class="ti ti-receipt-off"></i>
                                    </div>
                                    <p class="font-bold text-slate-700 text-sm">Belum Ada Data Konfirmasi Pembayaran</p>
                                    <p class="text-xs text-slate-400 mt-0.5">Belum ada peserta yang mengunggah bukti pembayaran atau data tidak cocok dengan filter.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Footer -->
        @if ($konfirmasi->hasPages())
            <div class="px-5 py-3.5 bg-slate-50 border-t border-slate-100 flex items-center justify-between">
                <div class="text-xs text-slate-500">
                    Menampilkan <span class="font-bold text-slate-800">{{ $konfirmasi->firstItem() }}</span> - <span class="font-bold text-slate-800">{{ $konfirmasi->lastItem() }}</span> dari <span class="font-bold text-slate-800">{{ $konfirmasi->total() }}</span> data
                </div>
                <div>
                    {{ $konfirmasi->links('pagination::tailwind') }}
                </div>
            </div>
        @endif
    </div>

</div>
@endsection

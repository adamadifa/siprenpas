@extends('layouts.app')
@section('titlepage', 'Pengajuan Izin Absen')

@section('content')
<div class="space-y-6">

    <!-- ================= 1. PAGE HEADER & BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <!-- Title & Subtitle -->
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-xl shrink-0 font-bold border border-emerald-200 shadow-2xs">
                <i class="ti ti-calendar-event"></i>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">
                    Pengajuan Izin Absen
                </h1>
                <p class="text-xs text-slate-500 font-medium">
                    Manajemen dan persetujuan data permohonan izin absen & cuti karyawan
                </p>
            </div>
        </div>

        <!-- Breadcrumb & Top Actions -->
        <div class="flex flex-col md:items-end gap-2.5">
            <nav class="flex items-center text-xs text-slate-400 font-medium">
                <a href="{{ route('dashboard.index') }}" class="hover:text-slate-700 transition flex items-center gap-1">
                    <i class="ti ti-home text-sm"></i>
                    <span>Dashboard</span>
                </a>
                <span class="mx-2 text-slate-300">/</span>
                <span class="text-slate-500">MSDM & Layanan</span>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Izin Absen</span>
            </nav>

            @can('izinabsen.create')
                <button type="button" 
                        id="btnCreate"
                        class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg text-xs shadow-xs transition active:scale-95 cursor-pointer">
                    <i class="ti ti-plus text-sm"></i>
                    <span>Tambah Pengajuan</span>
                </button>
            @endcan
        </div>
    </div>

    <!-- ================= 2. TAB MENU NAVIGATION ================= -->
    @include('layouts.navigation.nav_pengajuan_absen')

    <!-- ================= 3. EXECUTIVE STATISTICS SUMMARY CARDS (SOLID STATUS THEMED) ================= -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
        
        <!-- Total Pengajuan (Solid Slate/Dark) -->
        <div class="bg-slate-800 border border-slate-700 rounded-2xl p-4 sm:p-5 text-white shadow-xs flex flex-col justify-between relative overflow-hidden group">
            <div class="absolute -right-6 -bottom-6 w-20 h-20 rounded-full border border-white/10 pointer-events-none"></div>
            <i class="ti ti-files text-white/10 text-5xl absolute -right-2 -bottom-2 pointer-events-none"></i>

            <div class="flex items-center justify-between relative z-10">
                <span class="text-[11px] font-bold text-slate-300 uppercase tracking-wider">Total Pengajuan</span>
                <div class="w-7 h-7 rounded-lg bg-white/20 text-white flex items-center justify-center text-sm font-bold border border-white/20 shadow-2xs">
                    <i class="ti ti-files"></i>
                </div>
            </div>
            <div class="mt-2.5 relative z-10">
                <div class="text-2xl sm:text-3xl font-bold text-white tracking-tight">
                    {{ $statTotal ?? $izinabsen->total() }}
                </div>
                <div class="text-[11px] text-slate-300 mt-0.5 font-medium">
                    Seluruh permohonan izin
                </div>
            </div>
        </div>

        <!-- Menunggu Persetujuan (Solid Amber/Orange) -->
        <div class="bg-amber-500 border border-amber-400 rounded-2xl p-4 sm:p-5 text-white shadow-xs flex flex-col justify-between relative overflow-hidden group">
            <div class="absolute -right-6 -bottom-6 w-20 h-20 rounded-full border border-white/10 pointer-events-none"></div>
            <i class="ti ti-hourglass-high text-white/10 text-5xl absolute -right-2 -bottom-2 pointer-events-none"></i>

            <div class="flex items-center justify-between relative z-10">
                <span class="text-[11px] font-bold text-amber-100 uppercase tracking-wider">Menunggu (Pending)</span>
                <div class="w-7 h-7 rounded-lg bg-white/20 text-white flex items-center justify-center text-sm font-bold border border-white/20 shadow-2xs">
                    <i class="ti ti-hourglass-high"></i>
                </div>
            </div>
            <div class="mt-2.5 relative z-10">
                <div class="text-2xl sm:text-3xl font-bold text-white tracking-tight">
                    {{ $statPending ?? 0 }}
                </div>
                <div class="text-[11px] text-amber-100 mt-0.5 font-medium">
                    Perlu verifikasi & tindakan
                </div>
            </div>
        </div>

        <!-- Disetujui (Solid Emerald) -->
        <div class="bg-emerald-600 border border-emerald-500 rounded-2xl p-4 sm:p-5 text-white shadow-xs flex flex-col justify-between relative overflow-hidden group">
            <div class="absolute -right-6 -bottom-6 w-20 h-20 rounded-full border border-white/10 pointer-events-none"></div>
            <i class="ti ti-circle-check text-white/10 text-5xl absolute -right-2 -bottom-2 pointer-events-none"></i>

            <div class="flex items-center justify-between relative z-10">
                <span class="text-[11px] font-bold text-emerald-100 uppercase tracking-wider">Disetujui</span>
                <div class="w-7 h-7 rounded-lg bg-white/20 text-white flex items-center justify-center text-sm font-bold border border-white/20 shadow-2xs">
                    <i class="ti ti-circle-check"></i>
                </div>
            </div>
            <div class="mt-2.5 relative z-10">
                <div class="text-2xl sm:text-3xl font-bold text-white tracking-tight">
                    {{ $statApproved ?? 0 }}
                </div>
                <div class="text-[11px] text-emerald-100 mt-0.5 font-medium">
                    Tercatat dalam presensi
                </div>
            </div>
        </div>

        <!-- Ditolak (Solid Rose/Red) -->
        <div class="bg-rose-600 border border-rose-500 rounded-2xl p-4 sm:p-5 text-white shadow-xs flex flex-col justify-between relative overflow-hidden group">
            <div class="absolute -right-6 -bottom-6 w-20 h-20 rounded-full border border-white/10 pointer-events-none"></div>
            <i class="ti ti-circle-x text-white/10 text-5xl absolute -right-2 -bottom-2 pointer-events-none"></i>

            <div class="flex items-center justify-between relative z-10">
                <span class="text-[11px] font-bold text-rose-100 uppercase tracking-wider">Ditolak</span>
                <div class="w-7 h-7 rounded-lg bg-white/20 text-white flex items-center justify-center text-sm font-bold border border-white/20 shadow-2xs">
                    <i class="ti ti-circle-x"></i>
                </div>
            </div>
            <div class="mt-2.5 relative z-10">
                <div class="text-2xl sm:text-3xl font-bold text-white tracking-tight">
                    {{ $statRejected ?? 0 }}
                </div>
                <div class="text-[11px] text-rose-100 mt-0.5 font-medium">
                    Permohonan ditolak
                </div>
            </div>
        </div>

    </div>

    <!-- ================= 4. CONSISTENT HORIZONTAL FILTER TOOLBAR ================= -->
    <form action="{{ route('izinabsen.index') }}" method="GET" class="w-full">
        <div class="flex flex-col lg:flex-row gap-2.5 sm:gap-3 w-full">
            
            <!-- Dari Tanggal Input -->
            <div class="w-full lg:w-44 relative">
                <i class="ti ti-calendar absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-lg pointer-events-none"></i>
                <input type="text" 
                       name="dari" 
                       value="{{ Request('dari') }}" 
                       placeholder="Dari Tanggal..." 
                       class="flatpickr-date w-full pl-11 pr-4 py-2.5 sm:py-3 text-sm bg-white border border-slate-300/90 rounded-xl text-slate-800 font-medium placeholder-slate-400 shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
            </div>

            <!-- Sampai Tanggal Input -->
            <div class="w-full lg:w-44 relative">
                <i class="ti ti-calendar absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-lg pointer-events-none"></i>
                <input type="text" 
                       name="sampai" 
                       value="{{ Request('sampai') }}" 
                       placeholder="Sampai Tanggal..." 
                       class="flatpickr-date w-full pl-11 pr-4 py-2.5 sm:py-3 text-sm bg-white border border-slate-300/90 rounded-xl text-slate-800 font-medium placeholder-slate-400 shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
            </div>

            <!-- Unit Kerja Dropdown -->
            <div class="w-full lg:w-48 relative">
                <select name="kode_unit" 
                        id="kode_unit" 
                        class="w-full py-2.5 sm:py-3 px-3 text-sm bg-white border border-slate-300/90 rounded-xl text-slate-800 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                    <option value="">Semua Unit Kerja</option>
                    @foreach ($unit as $u)
                        <option value="{{ $u->kode_unit }}" {{ Request('kode_unit') == $u->kode_unit ? 'selected' : '' }}>
                            {{ strtoupper($u->nama_unit) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Status Dropdown -->
            <div class="w-full lg:w-44 relative">
                <select name="status" 
                        id="status" 
                        class="w-full py-2.5 sm:py-3 px-3 text-sm bg-white border border-slate-300/90 rounded-xl text-slate-800 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                    <option value="">Semua Status</option>
                    <option value="0" {{ Request('status') === '0' ? 'selected' : '' }}>Pending (Menunggu)</option>
                    <option value="1" {{ Request('status') == '1' ? 'selected' : '' }}>Disetujui</option>
                    <option value="2" {{ Request('status') == '2' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>

            <!-- Search Nama / NPP / Kode Izin -->
            <div class="flex-1 min-w-0 w-full relative">
                <i class="ti ti-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-lg pointer-events-none"></i>
                <input type="text" 
                       name="nama_lengkap" 
                       value="{{ Request('nama_lengkap') }}" 
                       placeholder="Cari Nama Karyawan, NPP, Kode..." 
                       class="w-full pl-11 pr-4 py-2.5 sm:py-3 text-sm bg-white border border-slate-300/90 rounded-xl text-slate-800 font-medium placeholder-slate-400 shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2 shrink-0 w-full lg:w-auto">
                <button type="submit" class="w-full lg:w-auto px-5 py-2.5 sm:py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl shadow-xs transition inline-flex items-center justify-center gap-2 cursor-pointer active:scale-95 whitespace-nowrap">
                    <i class="ti ti-search text-base"></i>
                    <span>Cari</span>
                </button>
                @if(Request('dari') || Request('sampai') || Request('kode_unit') || Request('status') !== null && Request('status') !== '' || Request('nama_lengkap'))
                    <a href="{{ route('izinabsen.index') }}" class="py-2.5 sm:py-3 px-3 bg-white hover:bg-slate-100 text-slate-600 border border-slate-300/90 rounded-xl font-semibold text-sm transition inline-flex items-center justify-center shrink-0 shadow-xs cursor-pointer" title="Reset Pencarian">
                        <i class="ti ti-refresh text-base"></i>
                    </a>
                @endif
            </div>

        </div>
    </form>

    <!-- ================= 5. FULL-WIDTH DATA CARDS LIST ================= -->
    <div class="space-y-3">
        
        <!-- List Header Bar -->
        <div class="px-5 py-3.5 bg-emerald-600 rounded-2xl flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-white shadow-xs">
            <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-lg bg-white/20 text-white flex items-center justify-center text-xs font-bold border border-white/20 shadow-2xs">
                    <i class="ti ti-layout-list"></i>
                </div>
                <h3 class="text-sm font-bold text-white tracking-tight">Daftar Pengajuan Izin Absen</h3>
                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-white/20 text-white border border-white/30">
                    {{ $izinabsen->total() }} total data
                </span>
            </div>

            <div class="text-xs text-emerald-100 font-medium">
                Halaman: <span class="font-bold text-white">{{ $izinabsen->currentPage() }}</span> dari <span class="font-bold text-white">{{ $izinabsen->lastPage() }}</span>
            </div>
        </div>

        <!-- Cards List -->
        @forelse ($izinabsen as $d)
            @php
                $lama = hitungHari($d->dari, $d->sampai);
                $statusConfig = [
                    '0' => [
                        'badge' => 'bg-amber-50 text-amber-700 border-amber-200',
                        'dot' => 'bg-amber-500',
                        'label' => 'Menunggu Persetujuan',
                        'icon' => 'ti-hourglass-high'
                    ],
                    '1' => [
                        'badge' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                        'dot' => 'bg-emerald-500',
                        'label' => 'Disetujui',
                        'icon' => 'ti-circle-check'
                    ],
                    '2' => [
                        'badge' => 'bg-rose-50 text-rose-700 border-rose-200',
                        'dot' => 'bg-rose-500',
                        'label' => 'Ditolak',
                        'icon' => 'ti-circle-x'
                    ],
                ];
                $status = $statusConfig[$d->status] ?? $statusConfig['0'];
            @endphp
            
            <div class="w-full bg-white border border-slate-200/90 rounded-2xl p-4 sm:p-5 shadow-xs hover:shadow-md hover:border-slate-300 transition-all duration-200 flex flex-col gap-3.5 relative">
                
                <!-- Main Header: Identity + Status & Actions -->
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 border-b border-slate-100 pb-3">
                    
                    <!-- Left: Employee Info -->
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-800 border border-emerald-200/80 flex items-center justify-center font-bold text-sm shrink-0 shadow-2xs">
                            {{ strtoupper(substr($d->nama_lengkap, 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-2 mb-0.5">
                                <h4 class="text-sm sm:text-base font-bold text-slate-900 truncate">
                                    {{ $d->nama_lengkap }}
                                </h4>
                                <span class="font-mono font-bold text-slate-700 bg-slate-100 px-2 py-0.5 rounded text-[11px] border border-slate-200">
                                    {{ $d->kode_izin }}
                                </span>
                            </div>
                            <div class="flex flex-wrap items-center gap-2 text-xs text-slate-500">
                                <span class="font-mono font-semibold text-slate-700">{{ $d->npp }}</span>
                                <span>•</span>
                                <span>{{ $d->nama_jabatan ?: '-' }}</span>
                                <span>•</span>
                                <span class="text-emerald-700 font-semibold">{{ $d->nama_unit ?: '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Status Badge & Action Group -->
                    <div class="flex flex-wrap items-center justify-between md:justify-end gap-2.5 shrink-0 pt-2 md:pt-0 border-t md:border-t-0 border-slate-100">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold border shadow-2xs {{ $status['badge'] }}">
                            <span class="w-2 h-2 rounded-full {{ $status['dot'] }}"></span>
                            <i class="ti {{ $status['icon'] }}"></i>
                            <span>{{ $status['label'] }}</span>
                        </span>

                        <div class="flex items-center gap-1.5">
                            
                            <!-- Approve Button (If Pending) -->
                            @can('izinabsen.approve')
                                @if ($d->status == 0)
                                    <button type="button" 
                                            class="btnApprove inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs transition-all duration-150 active:scale-95 cursor-pointer shadow-2xs"
                                            kode_izin="{{ Crypt::encrypt($d->kode_izin) }}" 
                                            title="Verifikasi & Persetujuan">
                                        <i class="ti ti-check text-sm"></i>
                                        <span>Proses</span>
                                    </button>
                                @elseif($d->status == 1)
                                    <form method="POST" 
                                          action="{{ route('izinabsen.cancelapprove', Crypt::encrypt($d->kode_izin)) }}" 
                                          class="inline-block m-0 formCancelApprove">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                class="btnCancelApprove inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-amber-50 hover:bg-amber-600 text-amber-800 hover:text-white border border-amber-300 font-bold text-xs transition-all duration-150 active:scale-95 cursor-pointer shadow-2xs"
                                                title="Batalkan Persetujuan">
                                            <i class="ti ti-rotate-clockwise text-sm"></i>
                                            <span>Batalkan</span>
                                        </button>
                                    </form>
                                @endif
                            @endcan

                            <!-- Detail Modal Button -->
                            <button type="button" 
                                    class="btnShow inline-flex items-center justify-center w-8 h-8 rounded-xl bg-slate-50 hover:bg-slate-700 text-slate-600 hover:text-white border border-slate-200 font-bold transition-all duration-150 active:scale-95 cursor-pointer shadow-2xs"
                                    kode_izin="{{ Crypt::encrypt($d->kode_izin) }}" 
                                    title="Lihat Detail Permohonan">
                                <i class="ti ti-file-text text-base"></i>
                            </button>

                            <!-- Edit Button (If Pending) -->
                            @can('izinabsen.edit')
                                @if ($d->status == 0)
                                    <button type="button" 
                                            class="btnEdit inline-flex items-center justify-center w-8 h-8 rounded-xl bg-blue-50 hover:bg-blue-600 text-blue-700 hover:text-white border border-blue-200 font-bold transition-all duration-150 active:scale-95 cursor-pointer shadow-2xs"
                                            kode_izin="{{ Crypt::encrypt($d->kode_izin) }}" 
                                            title="Edit Pengajuan">
                                        <i class="ti ti-edit text-base"></i>
                                    </button>
                                @endif
                            @endcan

                            <!-- Delete Button (If Pending) -->
                            @can('izinabsen.delete')
                                @if ($d->status == 0)
                                    <form method="POST" 
                                          action="{{ route('izinabsen.delete', Crypt::encrypt($d->kode_izin)) }}" 
                                          class="inline-block m-0 formDeleteIzin">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                class="btnDeleteIzin inline-flex items-center justify-center w-8 h-8 rounded-xl bg-rose-50 hover:bg-rose-600 text-rose-700 hover:text-white border border-rose-200 font-bold transition-all duration-150 active:scale-95 cursor-pointer shadow-2xs"
                                                title="Hapus Permohonan">
                                            <i class="ti ti-trash text-base"></i>
                                        </button>
                                    </form>
                                @endif
                            @endcan

                        </div>
                    </div>

                </div>

                <!-- Card Body: Date Metadata & Keterangan / Alasan -->
                <div class="grid grid-cols-1 md:grid-cols-12 gap-3.5 items-start">
                    
                    <!-- Left info: Dates & Duration -->
                    <div class="md:col-span-4 lg:col-span-3 space-y-2 text-xs">
                        <div class="flex items-center justify-between sm:justify-start gap-2 text-slate-500">
                            <span class="text-slate-400 font-medium flex items-center gap-1.5 shrink-0">
                                <i class="ti ti-calendar"></i> Pengajuan:
                            </span>
                            <span class="font-semibold text-slate-800">
                                {{ DateToIndo($d->tanggal) }}
                            </span>
                        </div>
                        <div class="space-y-1">
                            <div class="text-slate-400 font-medium flex items-center gap-1.5">
                                <i class="ti ti-calendar-event text-emerald-600"></i> Periode Izin:
                            </div>
                            <div class="flex flex-wrap items-center gap-1.5">
                                <span class="font-bold text-slate-900">{{ DateToIndo($d->dari) }}</span>
                                <span class="text-slate-400 text-[11px]">s/d</span>
                                <span class="font-bold text-slate-900">{{ DateToIndo($d->sampai) }}</span>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                    {{ $lama }} Hari
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Right info: Keterangan / Alasan -->
                    <div class="md:col-span-8 lg:col-span-9">
                        <div class="bg-slate-50/80 border border-slate-200/80 rounded-xl p-3 text-xs">
                            <div class="flex items-center gap-1.5 text-slate-400 font-semibold mb-1">
                                <i class="ti ti-notes text-emerald-600"></i>
                                <span>Alasan / Keterangan:</span>
                            </div>
                            <p class="text-slate-700 font-medium leading-relaxed whitespace-pre-line">
                                {{ $d->keterangan }}
                            </p>
                        </div>
                    </div>

                </div>

            </div>
        @empty
            <div class="bg-white border border-slate-200/90 rounded-2xl p-12 text-center shadow-xs">
                <div class="flex flex-col items-center justify-center max-w-sm mx-auto">
                    <div class="w-16 h-16 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-3xl mb-3 border border-emerald-100 shadow-2xs">
                        <i class="ti ti-calendar-off"></i>
                    </div>
                    <h4 class="text-sm font-bold text-slate-800 mb-1">
                        Belum Ada Pengajuan Izin Absen
                    </h4>
                    <p class="text-xs text-slate-400 text-center leading-relaxed">
                        Data pengajuan izin absen karyawan untuk kriteria pencarian ini belum ditemukan.
                    </p>
                </div>
            </div>
        @endforelse

        <!-- Pagination Bar -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-4 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs">
            <div class="text-slate-500 font-medium">
                Menampilkan <span class="font-bold text-slate-800">{{ $izinabsen->firstItem() ?? 0 }}</span> - <span class="font-bold text-slate-800">{{ $izinabsen->lastItem() ?? 0 }}</span> dari <span class="font-bold text-slate-800">{{ $izinabsen->total() }}</span> data
            </div>
            <div>
                {{ $izinabsen->links() }}
            </div>
        </div>

    </div>

</div>

<!-- Modal Container -->
<x-modal-form id="modal" size="" show="loadmodal" title="" />

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

        // Tambah Pengajuan
        $("#btnCreate").click(function(e) {
            e.preventDefault();
            $("#modal").modal("show");
            $("#modal").find(".modal-title").text("Tambah Pengajuan Izin Absen");
            $("#loadmodal").html(loadingSpinner);
            $("#loadmodal").load("/izinabsen/create");
        });

        // Approve Modal
        $(document).on("click", ".btnApprove", function(e) {
            e.preventDefault();
            const kode_izin = $(this).attr("kode_izin");
            $("#modal").modal("show");
            $("#modal").find(".modal-title").text("Verifikasi & Persetujuan Izin Absen");
            $("#loadmodal").html(loadingSpinner);
            $("#loadmodal").load(`/izinabsen/${kode_izin}/approve`);
        });

        // Detail Modal
        $(document).on("click", ".btnShow", function(e) {
            e.preventDefault();
            const kode_izin = $(this).attr("kode_izin");
            $("#modal").modal("show");
            $("#modal").find(".modal-title").text("Detail Pengajuan Izin Absen");
            $("#loadmodal").html(loadingSpinner);
            $("#loadmodal").load(`/izinabsen/${kode_izin}/show`);
        });

        // Edit Modal
        $(document).on("click", ".btnEdit", function(e) {
            e.preventDefault();
            const kode_izin = $(this).attr("kode_izin");
            $("#modal").modal("show");
            $("#modal").find(".modal-title").text("Edit Pengajuan Izin Absen");
            $("#loadmodal").html(loadingSpinner);
            $("#loadmodal").load(`/izinabsen/${kode_izin}/edit`);
        });

        // Batalkan Persetujuan Confirmation
        $(document).on("click", ".btnCancelApprove", function(e) {
            e.preventDefault();
            const form = $(this).closest("form");
            Swal.fire({
                title: "Batalkan Persetujuan?",
                text: "Status izin akan dikembalikan ke pending dan presensi terkait akan dibatalkan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#064e3b",
                cancelButtonColor: "#e11d48",
                confirmButtonText: "Ya, Batalkan!",
                cancelButtonText: "Tutup"
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

        // Hapus Pengajuan Confirmation
        $(document).on("click", ".btnDeleteIzin", function(e) {
            e.preventDefault();
            const form = $(this).closest("form");
            Swal.fire({
                title: "Hapus Pengajuan Izin?",
                text: "Data pengajuan izin ini akan dihapus secara permanen!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#e11d48",
                cancelButtonColor: "#64748b",
                confirmButtonText: "Ya, Hapus!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush

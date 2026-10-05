@extends('layouts.app')
@section('titlepage', 'Pendaftaran Online')

@section('content')
<div class="space-y-6">

    <!-- ================= 1. PAGE HEADER (NO CARD) WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <i class="ti ti-world text-emerald-600 text-2xl"></i>
                <span>Data Pendaftaran Online</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Manajemen pendaftaran calon santri via website, validasi data, dan verifikasi pembayaran
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
                    <i class="ti ti-school text-sm"></i>
                    <span>Akademik</span>
                </span>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Pendaftaran Online</span>
            </nav>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('pendaftaranonline.export', request()->all()) }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white hover:bg-slate-50 text-slate-700 font-bold border border-slate-300 rounded-lg text-xs shadow-xs transition-all duration-200 active:scale-95 cursor-pointer">
                    <i class="ti ti-file-spreadsheet text-base text-emerald-600"></i>
                    <span>Export Excel</span>
                </a>
            </div>
        </div>
    </div>

    <!-- ================= 2. UNIT RECAP STATISTICS (SINGLE SEAMLESS EMERALD GRADIENT CARD) ================= -->
    @php
        // Filter out Asrama / Pesantren from recap stats
        $filteredUnits = isset($rekap_unit) ? $rekap_unit->filter(function($r) {
            $nama = strtolower($r->nama_unit);
            return !str_contains($nama, 'asrama') && !str_contains($nama, 'pesantren');
        }) : collect();
        $totalPendaftarUnit = $filteredUnits->sum('jumlah');

        // Unit icon mappings
        $unitIcons = [
            'U01' => 'ti ti-mood-smile',
            'U02' => 'ti ti-school',
            'U03' => 'ti ti-book-2',
            'U04' => 'ti ti-building-community',
            'U05' => 'ti ti-certificate',
        ];
    @endphp

    @if ($filteredUnits->count() > 0)
        <div class="rounded-2xl shadow-sm bg-gradient-to-r from-emerald-800 via-emerald-700 to-teal-700 text-white p-5 sm:p-6 border border-emerald-900/30 relative overflow-hidden">
            <!-- Background watermark -->
            <div class="absolute -right-8 -bottom-10 text-white/5 pointer-events-none">
                <i class="ti ti-world text-[200px]"></i>
            </div>

            <div class="relative z-10 flex flex-wrap lg:flex-nowrap items-stretch justify-between gap-y-6">
                
                <!-- Item 1: Total Semua Unit -->
                <div class="flex-1 min-w-[140px] sm:min-w-[160px] px-3 sm:px-4 flex flex-col justify-between group">
                    <div>
                        <div class="flex items-center justify-between gap-2">
                            <span class="text-[11px] font-black uppercase tracking-wider text-emerald-200 truncate">
                                Total Online
                            </span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-white/20 text-white border border-white/25">
                                Semua
                            </span>
                        </div>
                        <div class="text-3xl sm:text-4xl font-black text-white tracking-tight mt-1.5">
                            {{ number_format($totalPendaftarUnit, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="mt-3.5 pt-2 flex items-center justify-between text-xs text-emerald-200/90">
                        <span class="font-medium text-[11px]">TA: {{ $tahun_ajaran->tahun_ajaran ?? '-' }}</span>
                        <span class="font-black text-white text-[10px] bg-white/20 px-2 py-0.5 rounded-md">
                            100%
                        </span>
                    </div>
                </div>

                <!-- Items 2..N: Per Unit with Tapered Gradient Divider -->
                @foreach ($filteredUnits as $r)
                    @php
                        $persen = $totalPendaftarUnit > 0 ? round(($r->jumlah / $totalPendaftarUnit) * 100) : 0;
                        $icon = $unitIcons[$r->kode_unit] ?? 'ti ti-school';
                    @endphp
                    
                    <!-- Vertical Tapered Divider Line (Faded top and bottom, pointed in the center) -->
                    <div class="hidden lg:block w-[1px] bg-gradient-to-b from-transparent via-white/35 to-transparent self-center h-16 shrink-0"></div>

                    <div class="flex-1 min-w-[140px] sm:min-w-[160px] px-3 sm:px-4 flex flex-col justify-between group">
                        <div>
                            <div class="flex items-center justify-between gap-2">
                                <span class="text-[11px] font-black uppercase tracking-wider text-emerald-200 truncate" title="{{ $r->nama_unit }}">
                                    {{ $r->nama_unit }}
                                </span>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-white/15 text-emerald-100 border border-white/20">
                                    {{ $r->kode_unit }}
                                </span>
                            </div>
                            <div class="text-3xl sm:text-4xl font-black text-white tracking-tight mt-1.5">
                                {{ number_format($r->jumlah, 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="mt-3.5 pt-2 flex items-center justify-between text-xs text-emerald-200/90">
                            <span class="font-medium text-[11px] flex items-center gap-1">
                                <i class="{{ $icon }} text-xs opacity-70"></i>
                                <span>Santri</span>
                            </span>
                            <span class="font-black text-white text-[10px] bg-white/15 px-2 py-0.5 rounded-md">
                                {{ $persen }}%
                            </span>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    @endif

    <!-- ================= 3. FILTER TOOLBAR (FULL-WIDTH 1 ROW WITH EXPANDING SEARCH & COMPACT BUTTONS) ================= -->
    <form action="{{ route('pendaftaranonline.index') }}" method="GET" class="w-full">
        @php
            $isU06 = auth()->user()->kode_unit == 'U06';
        @endphp
        
        <div class="flex flex-col md:flex-row items-center gap-2.5 sm:gap-3 w-full">
            <!-- Search Input (Flex-1 expands to fill all remaining width) -->
            <div class="flex-1 min-w-0 w-full relative">
                <i class="ti ti-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-lg pointer-events-none"></i>
                <input type="text" 
                       name="nama_lengkap" 
                       value="{{ Request('nama_lengkap') }}" 
                       placeholder="Cari Nama Siswa / No. Register / NISN / No. HP..." 
                       class="w-full pl-11 pr-4 py-2.5 sm:py-3 text-sm bg-white border border-slate-300/90 rounded-lg text-slate-800 font-medium placeholder-slate-400 shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
            </div>

            <!-- Unit Filter (If U06) -->
            @if ($isU06)
                <div class="w-full md:w-52 lg:w-60 shrink-0">
                    <select name="kode_unit" id="kode_unit_search" class="w-full px-4 py-2.5 sm:py-3 text-sm bg-white border border-slate-300/90 rounded-lg text-slate-800 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                        <option value="">-- Semua Unit --</option>
                        @foreach ($unit as $d)
                            <option value="{{ $d->kode_unit }}" {{ Request('kode_unit') == $d->kode_unit ? 'selected' : '' }}>
                                {{ $d->nama_unit }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            <!-- Tahun Ajaran Filter -->
            <div class="w-full md:w-44 lg:w-48 shrink-0">
                <select name="kode_ta" id="kode_ta_search" class="w-full px-4 py-2.5 sm:py-3 text-sm bg-white border border-slate-300/90 rounded-lg text-slate-800 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                    <option value="">-- Tahun Ajaran --</option>
                    @foreach ($tahunajaran as $d)
                        <option value="{{ $d->kode_ta }}"
                            @if(!empty(Request('kode_ta')))
                                {{ Request('kode_ta') == $d->kode_ta ? 'selected' : '' }}
                            @else
                                {{ $d->kode_ta == ($tahun_ajaran->kode_ta ?? $kode_ta) ? 'selected' : '' }}
                            @endif 
                        >
                            {{ $d->tahun_ajaran }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Compact Action Buttons -->
            <div class="flex items-center gap-2 shrink-0 w-full md:w-auto">
                <button type="submit" class="w-full md:w-auto px-5 py-2.5 sm:py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-lg shadow-xs transition inline-flex items-center justify-center gap-2 cursor-pointer active:scale-95 whitespace-nowrap">
                    <i class="ti ti-search text-base"></i>
                    <span>Cari</span>
                </button>
                @if(Request('nama_lengkap') || Request('kode_unit') || (Request('kode_ta') && Request('kode_ta') != ($tahun_ajaran->kode_ta ?? $kode_ta)))
                    <a href="{{ route('pendaftaranonline.index') }}" class="py-2.5 sm:py-3 px-3 bg-white hover:bg-slate-100 text-slate-600 border border-slate-300/90 rounded-lg font-semibold text-sm transition inline-flex items-center justify-center shrink-0 shadow-xs" title="Reset Filter">
                        <i class="ti ti-refresh text-base"></i>
                    </a>
                @endif
            </div>
        </div>
    </form>

    <!-- ================= 4. DATA LIST FULL-WIDTH CARDS ================= -->
    <div class="space-y-3">
        <!-- List Header Info -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 px-1 text-xs">
            <div class="flex items-center gap-2 text-slate-500">
                <span class="font-bold text-slate-900 text-sm flex items-center gap-1.5">
                    <i class="ti ti-users text-emerald-600 text-base"></i>
                    <span>Daftar Calon Santri Online</span>
                </span>
                <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                <span>Menampilkan <strong class="text-slate-800 font-bold">{{ $pendaftaran->firstItem() ?? 0 }}-{{ $pendaftaran->lastItem() ?? 0 }}</strong> dari <strong class="text-slate-800 font-bold">{{ $pendaftaran->total() }}</strong> calon santri</span>
            </div>
            <div class="text-slate-400 font-medium">
                Tahun Ajaran: <strong class="text-slate-700 font-bold">{{ $tahun_ajaran->tahun_ajaran ?? '-' }}</strong>
            </div>
        </div>

        <!-- Cards List -->
        @forelse ($pendaftaran as $d)
            <div class="bg-white border border-slate-200/90 hover:border-slate-300/90 rounded-xl p-4 sm:p-5 shadow-xs hover:shadow-md transition-all duration-200 group">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                    
                    <!-- Left: Identity & Details -->
                    <div class="flex items-start sm:items-center gap-3.5 sm:gap-4 flex-1 min-w-0">
                        <!-- Row Index Badge -->
                        <div class="hidden sm:flex w-7 h-7 rounded-lg bg-slate-100 text-slate-500 text-[11px] font-bold items-center justify-center shrink-0 border border-slate-200/80">
                            {{ $loop->iteration + $pendaftaran->firstItem() - 1 }}
                        </div>

                        <!-- Photo Thumbnail with Gender Indicator -->
                        <div class="relative shrink-0">
                            @php
                                $fotoSantri = $d->foto ?? $d->foto_pendaftaran ?? null;
                            @endphp
                            @if ($fotoSantri && Storage::disk('public')->exists('photos/pendaftaran/' . $fotoSantri))
                                <img src="{{ asset('storage/photos/pendaftaran/' . $fotoSantri) }}" alt="{{ $d->nama_lengkap }}" class="w-12 h-15 sm:w-13 sm:h-16 rounded-lg object-cover border border-slate-200 shadow-2xs">
                            @else
                                <div class="w-12 h-15 sm:w-13 sm:h-16 rounded-lg bg-slate-100 border border-slate-200/80 flex flex-col items-center justify-center text-slate-400 shadow-2xs">
                                    <i class="ti ti-user text-xl sm:text-2xl text-slate-400"></i>
                                </div>
                            @endif

                            @if($d->jenis_kelamin == 'L')
                                <span class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full bg-blue-600 text-white flex items-center justify-center text-[10px] ring-2 ring-white" title="Laki-laki">
                                    <i class="ti ti-gender-male"></i>
                                </span>
                            @else
                                <span class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full bg-rose-500 text-white flex items-center justify-center text-[10px] ring-2 ring-white" title="Perempuan">
                                    <i class="ti ti-gender-female"></i>
                                </span>
                            @endif
                        </div>

                        <!-- Info Content -->
                        <div class="flex-1 min-w-0">
                            <!-- Name & Status Badges -->
                            <div class="flex flex-wrap items-center gap-2">
                                <h4 class="text-sm sm:text-base font-bold capitalize text-slate-800 group-hover:text-emerald-700 transition truncate max-w-md" title="{{ $d->nama_lengkap }}">
                                    {{ ucwords(strtolower($d->nama_lengkap)) }}
                                </h4>

                                <!-- Unit Badge -->
                                <span class="px-2.5 py-0.5 rounded-md text-[10px] font-black uppercase tracking-wider bg-slate-100 text-slate-700 border border-slate-200/80">
                                    {{ $d->nama_unit }}
                                </span>

                                <!-- Gender Badge -->
                                @if($d->jenis_kelamin == 'L')
                                    <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-100">
                                        Laki-laki
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-100">
                                        Perempuan
                                    </span>
                                @endif

                                <!-- Status Badge -->
                                @if (!empty($d->no_pendaftaran))
                                    <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 inline-flex items-center gap-1" title="Sudah diverifikasi dan tercatat di database pendaftaran utama">
                                        <i class="ti ti-checks"></i>
                                        <span>Terverifikasi ({{ $d->no_pendaftaran }})</span>
                                    </span>
                                @else
                                    @if (!empty($d->id_bayar) || $d->status_bayar == 'approved' || $d->status_bayar == '1')
                                        <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200 inline-flex items-center gap-1" title="Pembayaran sudah dikonfirmasi, menunggu verifikasi santri">
                                            <i class="ti ti-clock"></i>
                                            <span>Menunggu Verifikasi</span>
                                        </span>
                                    @else
                                        <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200 inline-flex items-center gap-1" title="Belum upload bukti / belum konfirmasi pembayaran">
                                            <i class="ti ti-alert-circle"></i>
                                            <span>Belum Konfirmasi</span>
                                        </span>
                                    @endif
                                @endif
                            </div>

                            <!-- Meta Chips Flex -->
                            <div class="flex flex-wrap items-center gap-x-4 gap-y-1.5 mt-2 text-xs text-slate-500">
                                <div class="flex items-center gap-1.5">
                                    <span class="text-slate-400 font-medium">No. Register:</span>
                                    <span class="font-bold text-slate-800 bg-slate-100 px-1.5 py-0.5 rounded border border-slate-200 text-[11px]">{{ $d->no_register }}</span>
                                </div>

                                <div class="flex items-center gap-1.5">
                                    <span class="text-slate-400 font-medium">NISN:</span>
                                    <span class="font-semibold text-slate-700 text-[11px]">{{ $d->nisn ?: '-' }}</span>
                                </div>

                                @if(!empty($d->tanggal_register))
                                    <div class="flex items-center gap-1 text-[11px] text-slate-400">
                                        <i class="ti ti-calendar text-slate-400"></i>
                                        <span>Register: {{ DateToIndo($d->tanggal_register) }}</span>
                                    </div>
                                @endif

                                @if(!empty($d->no_hp))
                                    <div class="flex items-center gap-1 text-[11px] text-slate-600 font-medium">
                                        <i class="ti ti-phone text-slate-400"></i>
                                        <span>{{ $d->no_hp }}</span>
                                    </div>
                                @endif

                                @if(!empty($d->asal_sekolah))
                                    <div class="flex items-center gap-1 text-[11px] text-slate-500">
                                        <i class="ti ti-school text-slate-400"></i>
                                        <span class="truncate max-w-xs">{{ $d->asal_sekolah }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Right: Action Buttons Toolbar -->
                    <div class="flex flex-wrap items-center justify-end gap-1.5 shrink-0 pt-3 lg:pt-0 border-t lg:border-t-0 border-slate-100">
                        @can('pendaftaranonline.edit')
                            <button type="button" 
                                    class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 text-xs font-bold transition active:scale-95 btnEdit cursor-pointer"
                                    no_register="{{ Crypt::encrypt($d->no_register) }}"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    title="Edit Biodata Pendaftaran Online">
                                <i class="ti ti-edit text-sm"></i>
                                <span>Edit</span>
                            </button>
                        @endcan

                        @can('pendaftaranonline.show')
                            <button type="button" 
                                    class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 text-xs font-bold transition active:scale-95 btnShow cursor-pointer"
                                    no_register="{{ Crypt::encrypt($d->no_register) }}"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    title="Lihat Lembar Formulir & Verifikasi">
                                <i class="ti ti-file-description text-sm"></i>
                                <span>Detail</span>
                            </button>

                            <a href="{{ route('pendaftaranonline.cetak', Crypt::encrypt($d->no_register)) }}" 
                               target="_blank" 
                               class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200 text-xs font-bold transition active:scale-95 cursor-pointer"
                               data-bs-toggle="tooltip"
                               data-bs-placement="top"
                               title="Cetak Formulir PDF Online">
                                <i class="ti ti-printer text-sm"></i>
                                <span>Cetak PDF</span>
                            </a>
                        @endcan

                        @can('pendaftaranonline.delete')
                            @if (empty($d->no_pendaftaran))
                                <form method="POST" class="deleteform inline-block" action="/pendaftaranonline/{{ Crypt::encrypt($d->no_register) }}/delete">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" 
                                            class="w-8.5 h-8.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 flex items-center justify-center transition active:scale-95 btn-delete-pendaftaranonline cursor-pointer" 
                                            data-name="{{ $d->nama_lengkap }}"
                                            data-no="{{ $d->no_register }}"
                                            data-bs-toggle="tooltip" 
                                            data-bs-placement="top"
                                            title="Hapus Data Pendaftaran Online">
                                        <i class="ti ti-trash text-sm"></i>
                                    </button>
                                </form>
                            @endif
                        @endcan
                    </div>

                </div>
            </div>
        @empty
            <div class="bg-white border border-slate-200/90 rounded-xl p-12 text-center text-slate-400 shadow-xs">
                <div class="w-14 h-14 rounded-2xl bg-slate-100 border border-slate-200 flex items-center justify-center mx-auto mb-3 text-slate-400 text-2xl">
                    <i class="ti ti-world-off"></i>
                </div>
                <h4 class="text-sm font-bold text-slate-800">Belum Ada Data Pendaftaran Online</h4>
                <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">Silakan sesuaikan filter pencarian atau tunggu pendaftaran baru yang masuk dari calon santri.</p>
            </div>
        @endforelse

        <!-- Pagination -->
        @if ($pendaftaran->hasPages())
            <div class="bg-white border border-slate-200/90 rounded-xl p-4 shadow-xs flex flex-col sm:flex-row items-center justify-between gap-3 mt-4">
                <div class="text-xs text-slate-500 font-medium">
                    Menampilkan <strong class="text-slate-800 font-bold">{{ $pendaftaran->firstItem() }}</strong> - <strong class="text-slate-800 font-bold">{{ $pendaftaran->lastItem() }}</strong> dari <strong class="text-slate-800 font-bold">{{ $pendaftaran->total() }}</strong> total data
                </div>
                <div>
                    {{ $pendaftaran->links('vendor.pagination.custom-tailwind') }}
                </div>
            </div>
        @endif
    </div>

</div>

<!-- ================= MODAL CONTAINERS ================= -->
<x-modal-form id="modal" size="modal-xl" show="loadmodal" title="" icon="ti ti-world" />
@endsection

@push('myscript')
<script>
    $(function() {
        const loading = `
            <div class="p-12 text-center bg-white">
                <div class="w-10 h-10 border-3 border-emerald-500 border-t-transparent rounded-full animate-spin mx-auto mb-3"></div>
                <div class="text-xs font-bold text-slate-700">Memuat Data Pendaftaran Online...</div>
            </div>
        `;

        $(document).on('click', '.btnEdit', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const no_register = $(this).attr("no_register");
            $("#modal").modal("show");
            $("#modal").find("#loadmodal").html(loading);
            $("#modal").find(".modal-title").text("Edit Data Calon Santri Online");
            $("#loadmodal").load(`/pendaftaranonline/${no_register}/edit`, function() {
                if (typeof flatpickr !== 'undefined') {
                    $(".flatpickr-date").flatpickr({
                        dateFormat: "Y-m-d",
                        altInput: true,
                        altFormat: "d-m-Y",
                        allowInput: true
                    });
                }
            });
        });

        $(document).on('click', '.btnShow', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const no_register = $(this).attr("no_register");
            $("#modal").modal("show");
            $("#modal").find("#loadmodal").html(loading);
            $("#modal").find(".modal-title").text("Detail Formulir Pendaftaran Online");
            $("#loadmodal").load(`/pendaftaranonline/${no_register}/show`);
        });

        // Konfirmasi Delete Pendaftaran Online with SweetAlert2
        $(document).on('click', '.btn-delete-pendaftaranonline', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const form = $(this).closest('form');
            const name = $(this).data('name') || 'calon santri ini';
            const noRegister = $(this).data('no') || '';

            Swal.fire({
                title: 'Hapus Pendaftaran Online?',
                html: `
                    <div class="text-xs sm:text-sm text-slate-600 mt-2 space-y-2 text-center">
                        <p>Apakah Anda yakin ingin menghapus data pendaftaran online untuk:</p>
                        <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-xl font-bold text-slate-900">
                            ${name} ${noRegister ? `<span class="text-xs text-slate-500 font-normal block mt-0.5">No. Register: ${noRegister}</span>` : ''}
                        </div>
                        <p class="text-[11px] text-rose-500 font-semibold">Data yang dihapus tidak dapat dipulihkan kembali.</p>
                    </div>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: '<i class="ti ti-trash mr-1"></i> Ya, Hapus Data',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-2xl shadow-2xl p-5',
                    title: 'text-base font-bold text-slate-900',
                    confirmButton: 'px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs rounded-xl shadow-xs transition cursor-pointer',
                    cancelButton: 'px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Menghapus Data...',
                        text: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    form.get(0).submit();
                }
            });
        });

        // Initialize Bootstrap tooltips
        if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }
    });
</script>
@endpush

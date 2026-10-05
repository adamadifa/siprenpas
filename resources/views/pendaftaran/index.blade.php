@extends('layouts.app')
@section('titlepage', 'Data Pendaftaran')

@section('content')
<div class="space-y-6">

    <!-- ================= 1. PAGE HEADER (NO CARD) WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <i class="ti ti-clipboard-list text-emerald-600 text-2xl"></i>
                <span>Data Pendaftaran</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Manajemen pendaftaran santri baru, biodata lengkap, dan kartu identitas santri
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
                <span class="font-bold text-slate-800">Pendaftaran</span>
            </nav>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center gap-2">
                @can('pendaftaran.create')
                    <button type="button" id="btnCreate" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg text-xs shadow-xs transition-all duration-200 active:scale-95 cursor-pointer">
                        <i class="ti ti-plus text-base"></i>
                        <span>Tambah Pendaftaran</span>
                    </button>
                @endcan
                <a href="{{ route('pendaftaran.export', request()->all()) }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white hover:bg-slate-50 text-slate-700 font-bold border border-slate-300 rounded-lg text-xs shadow-xs transition-all duration-200 active:scale-95 cursor-pointer">
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
                <i class="ti ti-clipboard-check text-[200px]"></i>
            </div>

            <div class="relative z-10 flex flex-wrap lg:flex-nowrap items-stretch justify-between gap-y-6">
                
                <!-- Item 1: Total Semua Unit -->
                <div class="flex-1 min-w-[140px] sm:min-w-[160px] px-3 sm:px-4 flex flex-col justify-between group">
                    <div>
                        <div class="flex items-center justify-between gap-2">
                            <span class="text-[11px] font-black uppercase tracking-wider text-emerald-200 truncate">
                                Total Pendaftar
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
    <form action="{{ route('pendaftaran.index') }}" method="GET" class="w-full">
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
                       placeholder="Cari Nama Siswa / No. Daftar / NISN..." 
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
                                {{ $d->kode_ta == $tahun_ajaran->kode_ta ? 'selected' : '' }}
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
                @if(Request('nama_lengkap') || Request('kode_unit') || (Request('kode_ta') && Request('kode_ta') != $tahun_ajaran->kode_ta))
                    <a href="{{ route('pendaftaran.index') }}" class="py-2.5 sm:py-3 px-3 bg-white hover:bg-slate-100 text-slate-600 border border-slate-300/90 rounded-lg font-semibold text-sm transition inline-flex items-center justify-center shrink-0 shadow-xs" title="Reset Filter">
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
                    <span>Daftar Santri Pendaftar</span>
                </span>
                <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                <span>Menampilkan <strong class="text-slate-800 font-bold">{{ $pendaftaran->firstItem() ?? 0 }}-{{ $pendaftaran->lastItem() ?? 0 }}</strong> dari <strong class="text-slate-800 font-bold">{{ $pendaftaran->total() }}</strong> santri</span>
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
                            @if ($d->foto_pendaftaran && Storage::disk('public')->exists('photos/pendaftaran/' . $d->foto_pendaftaran))
                                <img src="{{ asset('storage/photos/pendaftaran/' . $d->foto_pendaftaran) }}" alt="{{ $d->nama_lengkap }}" class="w-12 h-15 sm:w-13 sm:h-16 rounded-lg object-cover border border-slate-200 shadow-2xs">
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
                            </div>

                            <!-- Meta Chips Grid/Flex -->
                            <div class="flex flex-wrap items-center gap-x-4 gap-y-1.5 mt-2 text-xs text-slate-500">
                                <div class="flex items-center gap-1.5">
                                    <span class="text-slate-400 font-medium">No. Daftar:</span>
                                    <span class="font-bold text-slate-800 bg-slate-100 px-1.5 py-0.5 rounded border border-slate-200 text-[11px]">{{ $d->no_pendaftaran }}</span>
                                </div>

                                <div class="flex items-center gap-1.5">
                                    <span class="text-slate-400 font-medium">ID Siswa:</span>
                                    <span class="font-bold text-slate-700 text-[11px]">{{ $d->id_siswa }}</span>
                                </div>

                                <div class="flex items-center gap-1.5">
                                    <span class="text-slate-400 font-medium">NISN:</span>
                                    <span class="font-semibold text-slate-700 text-[11px]">{{ $d->nisn ?? '-' }}</span>
                                </div>

                                @if(!empty($d->tanggal_pendaftaran))
                                    <div class="flex items-center gap-1 text-[11px] text-slate-400">
                                        <i class="ti ti-calendar text-slate-400"></i>
                                        <span>Daftar: {{ DateToIndo($d->tanggal_pendaftaran) }}</span>
                                    </div>
                                @endif

                                @if(!empty($d->rfid_code))
                                    <div class="flex items-center gap-1 text-[11px] font-bold text-amber-700 bg-amber-50 px-2 py-0.5 rounded border border-amber-200">
                                        <i class="ti ti-nfc"></i>
                                        <span>RFID: {{ $d->rfid_code }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Right: Action Buttons Toolbar -->
                    <div class="flex flex-wrap items-center justify-end gap-1.5 shrink-0 pt-3 lg:pt-0 border-t lg:border-t-0 border-slate-100">
                        @can('pendaftaran.edit')
                            <button type="button" 
                                    class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 text-xs font-bold transition active:scale-95 btnEdit cursor-pointer"
                                    no_pendaftaran="{{ Crypt::encrypt($d->no_pendaftaran) }}">
                                <i class="ti ti-edit text-sm"></i>
                                <span>Edit</span>
                            </button>
                        @endcan

                        @can('pendaftaran.show')
                            <button type="button" 
                                    class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 text-xs font-bold transition active:scale-95 btnShow cursor-pointer"
                                    no_pendaftaran="{{ Crypt::encrypt($d->no_pendaftaran) }}">
                                <i class="ti ti-file-description text-sm"></i>
                                <span>Detail</span>
                            </button>

                            <a href="{{ route('pendaftaran.cetak-id-card', Crypt::encrypt($d->no_pendaftaran)) }}" 
                               target="_blank" 
                               class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200 text-xs font-bold transition active:scale-95 cursor-pointer">
                                <i class="ti ti-id-badge text-sm"></i>
                                <span>ID Card</span>
                            </a>
                        @endcan

                        @can('pendaftaran.edit')
                            <button type="button" 
                                    class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg {{ !empty($d->rfid_code) ? 'bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200' : 'bg-slate-100 hover:bg-slate-200 text-slate-600 border border-slate-200' }} text-xs font-bold transition active:scale-95 btnRfid cursor-pointer"
                                    no_pendaftaran="{{ Crypt::encrypt($d->no_pendaftaran) }}"
                                    nama_siswa="{{ $d->nama_lengkap }}" 
                                    rfid_code="{{ $d->rfid_code ?? '' }}">
                                <i class="ti ti-nfc text-sm"></i>
                                <span>RFID</span>
                            </button>
                        @endcan

                        @can('pendaftaran.delete')
                            <form method="POST" class="deleteform inline-block" action="/pendaftaran/{{ Crypt::encrypt($d->no_pendaftaran) }}/delete">
                                @csrf
                                @method('DELETE')
                                <button type="button" 
                                        class="w-8.5 h-8.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 flex items-center justify-center transition active:scale-95 btn-delete-pendaftaran cursor-pointer" 
                                        data-name="{{ $d->nama_lengkap }}"
                                        data-no="{{ $d->no_pendaftaran }}"
                                        data-bs-toggle="tooltip" 
                                        data-bs-placement="top"
                                        title="Hapus Data Pendaftaran">
                                    <i class="ti ti-trash text-sm"></i>
                                </button>
                            </form>
                        @endcan
                    </div>

                </div>
            </div>
        @empty
            <div class="bg-white border border-slate-200/90 rounded-xl p-12 text-center text-slate-400 shadow-xs">
                <div class="w-14 h-14 rounded-2xl bg-slate-100 border border-slate-200 flex items-center justify-center mx-auto mb-3 text-slate-400 text-2xl">
                    <i class="ti ti-folder-off"></i>
                </div>
                <h4 class="text-sm font-bold text-slate-800">Belum Ada Data Pendaftaran</h4>
                <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">Silakan sesuaikan filter pencarian atau klik tombol Tambah Pendaftaran di atas untuk mendaftarkan santri baru.</p>
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
<x-modal-form id="modal" size="modal-xl" show="loadmodal" title="" icon="ti ti-clipboard-list" />
<x-modal-form id="modalSekolah" size="modal-lg" show="loadmodalSekolah" title="" icon="ti ti-building-skyscraper" />
<x-modal-form id="modalRfid" size="modal-md" show="loadmodalRfid" title="" icon="ti ti-id-badge" />

<div class="modal fade" id="modalSiswa" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border border-slate-200/90 shadow-2xl rounded-2xl overflow-hidden bg-white">
            <div class="px-6 py-4 bg-white border-b border-slate-200/90 flex items-center justify-between text-slate-900">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-100 flex items-center justify-center text-base shrink-0 font-bold">
                        <i class="ti ti-users"></i>
                    </div>
                    <h5 class="modal-title text-base font-bold text-slate-900 tracking-tight mb-0">Pilih Data Siswa</h5>
                </div>
                <button type="button" class="w-8 h-8 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 flex items-center justify-center transition-colors cursor-pointer" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti ti-x text-lg"></i>
                </button>
            </div>
            <div class="modal-body p-6">
                <div class="table-responsive">
                    <table class="w-full text-left border-collapse" id="tabelsiswa">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-xs font-bold text-slate-600 uppercase">
                                <th class="py-2.5 px-3">ID Siswa</th>
                                <th class="py-2.5 px-3">Nama Lengkap</th>
                                <th class="py-2.5 px-3">Jenis Kelamin</th>
                                <th class="py-2.5 px-3">Tahun Masuk</th>
                                <th class="py-2.5 px-3 text-center">#</th>
                            </tr>
                        </thead>
                        <tbody class="text-xs"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('myscript')
<script>
    $(function() {
        const loading = `
            <div class="p-12 text-center bg-white">
                <div class="w-10 h-10 border-3 border-emerald-500 border-t-transparent rounded-full animate-spin mx-auto mb-3"></div>
                <div class="text-xs font-bold text-slate-700">Memuat Formulir Pendaftaran...</div>
            </div>
        `;

        $("#btnCreate").click(function(e) {
            e.preventDefault();
            e.stopPropagation();
            const tahun_ajaran = "{{ $tahun_ajaran->tahun_ajaran ?? '' }}";
            $("#modal").modal("show");
            $("#modal").find("#loadmodal").html(loading);
            $("#modal").find(".modal-title").text("Pendaftaran Santri Baru - TA " + tahun_ajaran);
            $("#loadmodal").load(`/pendaftaran/create`);
        });

        $(document).on('click', '.btnEdit', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const no_pendaftaran = $(this).attr("no_pendaftaran");
            $("#modal").modal("show");
            $("#modal").find("#loadmodal").html(loading);
            $("#modal").find(".modal-title").text("Edit Data Pendaftaran Santri");
            $("#loadmodal").load(`/pendaftaran/${no_pendaftaran}/edit`);
        });

        $(document).on('click', '.btnShow', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const no_pendaftaran = $(this).attr("no_pendaftaran");
            $("#modal").modal("show");
            $("#modal").find("#loadmodal").html(loading);
            $("#modal").find(".modal-title").text("Detail Formulir Pendaftaran");
            $("#loadmodal").load(`/pendaftaran/${no_pendaftaran}/show`);
        });

        $(document).on('click', '.btnRfid', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const no_pendaftaran = $(this).attr("no_pendaftaran");
            const namaSiswa = $(this).attr("nama_siswa");
            const rfidCode = $(this).attr("rfid_code") || '';

            $("#modalRfid").modal("show");
            $("#modalRfid").find(".modal-title").text("Atur Kartu RFID Santri");
            $("#modalRfid").find("#loadmodalRfid").html(`
                <form id="formRfid" onsubmit="event.preventDefault(); saveRfid('${no_pendaftaran}');" class="space-y-4">
                    @csrf
                    <!-- Nama Santri (Readonly) -->
                    <div class="space-y-1">
                        <label class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                            <i class="ti ti-user text-sm text-slate-400"></i>
                            <span>Nama Lengkap Santri</span>
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <i class="ti ti-user text-base"></i>
                            </div>
                            <input type="text" 
                                   value="${namaSiswa}" 
                                   readonly 
                                   class="w-full pl-9 pr-3.5 py-2 text-sm font-bold text-slate-600 bg-slate-100 border border-slate-300 rounded-lg shadow-2xs cursor-not-allowed">
                        </div>
                    </div>

                    <!-- Kode Kartu RFID -->
                    <div class="space-y-1">
                        <label for="rfid_input" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                            <i class="ti ti-nfc text-sm text-slate-400"></i>
                            <span>Kode Kartu RFID <span class="text-slate-400 font-normal">(Scan / Ketik)</span></span>
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <i class="ti ti-nfc text-base"></i>
                            </div>
                            <input type="text" 
                                   id="rfid_input" 
                                   value="${rfidCode}" 
                                   placeholder="Tempelkan kartu pada scanner atau ketik kode..." 
                                   autocomplete="off" 
                                   class="w-full pl-9 pr-3.5 py-2 text-sm font-bold text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                        </div>
                    </div>

                    <!-- Hint Callout -->
                    <div class="p-3 bg-slate-50 border border-slate-200/90 rounded-xl flex items-start gap-2 text-xs text-slate-500">
                        <i class="ti ti-info-circle text-emerald-600 text-base shrink-0 mt-0.5"></i>
                        <span class="leading-relaxed">Tempelkan kartu RFID pada alat scan, atau ketikkan kode secara manual. Kosongkan isian jika ingin menghapus kaitan kartu dari santri ini.</span>
                    </div>

                    <!-- Modal Actions Footer -->
                    <div class="pt-4 border-t border-slate-200/90 flex items-center justify-end gap-2.5">
                        <button type="button" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer active:scale-95" data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" id="btnSaveRfid" class="px-4 py-2 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs rounded-xl shadow-2xs transition flex items-center gap-1.5 cursor-pointer active:scale-95">
                            <i class="ti ti-device-floppy text-base"></i>
                            <span>Simpan RFID</span>
                        </button>
                    </div>
                </form>
            `);
            setTimeout(() => $("#rfid_input").focus(), 300);
        });

        // Initialize DataTables for modalSiswa only if DataTable library is loaded
        if (typeof $.fn.DataTable !== 'undefined' && $('#tabelsiswa').length) {
            $('#tabelsiswa').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("pendaftaran.getsiswa") }}',
                columns: [
                    { data: 'id_siswa', name: 'id_siswa' },
                    { data: 'nama_lengkap', name: 'nama_lengkap' },
                    { data: 'jenis_kelamin', name: 'jenis_kelamin' },
                    { data: 'tahun_masuk', name: 'tahun_masuk' },
                    { data: 'action', name: 'action', className: 'text-center' }
                ],
                language: {
                    search: "Cari Siswa:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data"
                }
            });
        }

        // Konfirmasi Delete Pendaftaran with SweetAlert2
        $(document).on('click', '.btn-delete-pendaftaran', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const form = $(this).closest('form');
            const name = $(this).data('name') || 'santri ini';
            const noDaftar = $(this).data('no') || '';

            Swal.fire({
                title: 'Hapus Data Pendaftaran?',
                html: `
                    <div class="text-xs sm:text-sm text-slate-600 mt-2 space-y-2 text-center">
                        <p>Apakah Anda yakin ingin menghapus data pendaftaran untuk:</p>
                        <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-xl font-bold text-slate-900">
                            ${name} ${noDaftar ? `<span class="text-xs text-slate-500 font-normal block mt-0.5">No. Daftar: ${noDaftar}</span>` : ''}
                        </div>
                        <p class="text-[11px] text-rose-500 font-semibold">Seluruh data santri dan berkas persyaratan akan dihapus secara permanen.</p>
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

        window.saveRfid = function(no_pendaftaran) {
            const rfidInput = document.getElementById('rfid_input');
            const rfidCode = rfidInput ? rfidInput.value.trim() : '';
            const btnSave = $("#btnSaveRfid");

            btnSave.prop('disabled', true).html('<div class="w-3.5 h-3.5 border-2 border-white border-t-transparent rounded-full animate-spin"></div> <span>Menyimpan...</span>');

            fetch(`/pendaftaran/${no_pendaftaran}/update-rfid`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ rfid_code: rfidCode })
            })
            .then(response => response.json())
            .then(data => {
                btnSave.prop('disabled', false).html('<i class="ti ti-device-floppy text-base"></i> <span>Simpan RFID</span>');
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        timer: 1500,
                        showConfirmButton: false,
                        customClass: { popup: 'rounded-2xl shadow-2xl' }
                    }).then(() => location.reload());
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: data.message,
                        confirmButtonColor: '#059669',
                        customClass: { popup: 'rounded-2xl shadow-2xl' }
                    });
                }
            })
            .catch(error => {
                btnSave.prop('disabled', false).html('<i class="ti ti-device-floppy text-base"></i> <span>Simpan RFID</span>');
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan pada server saat menyimpan RFID.',
                    confirmButtonColor: '#059669',
                    customClass: { popup: 'rounded-2xl shadow-2xl' }
                });
            });
        };

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

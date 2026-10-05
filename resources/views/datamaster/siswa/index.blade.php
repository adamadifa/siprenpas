@extends('layouts.app')
@section('titlepage', 'Data Siswa')

@section('content')
<div class="space-y-6">

    <!-- ================= 1. PAGE HEADER (NO CARD) WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <i class="ti ti-school text-emerald-600 text-2xl"></i>
                <span>Data Siswa</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Manajemen data induk siswa, biodata lengkap, dan riwayat administrasi santri
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
                    <i class="ti ti-database text-sm"></i>
                    <span>Master Data</span>
                </span>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Siswa</span>
            </nav>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center gap-2">
                @can('siswa.create')
                    <button type="button" id="btnCreate" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg text-xs shadow-xs transition-all duration-200 active:scale-95 cursor-pointer">
                        <i class="ti ti-plus text-base"></i>
                        <span>Tambah Siswa</span>
                    </button>
                @endcan
            </div>
        </div>
    </div>

    <!-- ================= 2. STATISTICS RECAP (SINGLE SEAMLESS EMERALD CARD WITH TAPERED DIVIDERS) ================= -->
    @php
        $totalSiswa = $stats['total_siswa'] ?? 0;
        $lakiPersen = $totalSiswa > 0 ? round((($stats['laki_laki'] ?? 0) / $totalSiswa) * 100) : 0;
        $perempuanPersen = $totalSiswa > 0 ? round((($stats['perempuan'] ?? 0) / $totalSiswa) * 100) : 0;
    @endphp
    <div class="rounded-2xl shadow-sm bg-gradient-to-r from-emerald-800 via-emerald-700 to-teal-700 text-white p-5 sm:p-6 border border-emerald-900/30 relative overflow-hidden">
        <!-- Background watermark -->
        <div class="absolute -right-8 -bottom-10 text-white/5 pointer-events-none">
            <i class="ti ti-school text-[200px]"></i>
        </div>

        <div class="relative z-10 flex flex-wrap sm:flex-nowrap items-stretch justify-between gap-y-6">
            
            <!-- Segment 1: Total Siswa -->
            <div class="flex-1 min-w-[140px] sm:min-w-[160px] px-3 sm:px-4 flex flex-col justify-between group">
                <div>
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-[11px] font-black uppercase tracking-wider text-emerald-200 truncate">
                            Total Siswa
                        </span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-white/20 text-white border border-white/25">
                            Semua
                        </span>
                    </div>
                    <div class="text-3xl sm:text-4xl font-black text-white tracking-tight mt-1.5">
                        {{ number_format($stats['total_siswa'] ?? 0, 0, ',', '.') }}
                    </div>
                </div>
                <div class="mt-3.5 pt-2 flex items-center justify-between text-xs text-emerald-200/90">
                    <span class="font-medium text-[11px]">Semua Angkatan</span>
                    <span class="font-black text-white text-[10px] bg-white/20 px-2 py-0.5 rounded-md">
                        100%
                    </span>
                </div>
            </div>

            <!-- Tapered Vertical Divider Line -->
            <div class="hidden sm:block w-[1px] bg-gradient-to-b from-transparent via-white/35 to-transparent self-center h-16 shrink-0"></div>

            <!-- Segment 2: Laki-laki (Putra) -->
            <div class="flex-1 min-w-[140px] sm:min-w-[160px] px-3 sm:px-4 flex flex-col justify-between group">
                <div>
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-[11px] font-black uppercase tracking-wider text-emerald-200 truncate">
                            Laki-Laki
                        </span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-white/15 text-emerald-100 border border-white/20">
                            Putra
                        </span>
                    </div>
                    <div class="text-3xl sm:text-4xl font-black text-white tracking-tight mt-1.5">
                        {{ number_format($stats['laki_laki'] ?? 0, 0, ',', '.') }}
                    </div>
                </div>
                <div class="mt-3.5 pt-2 flex items-center justify-between text-xs text-emerald-200/90">
                    <span class="font-medium text-[11px] flex items-center gap-1">
                        <i class="ti ti-mood-boy text-xs opacity-70"></i>
                        <span>Santri Putra</span>
                    </span>
                    <span class="font-black text-white text-[10px] bg-white/15 px-2 py-0.5 rounded-md">
                        {{ $lakiPersen }}%
                    </span>
                </div>
            </div>

            <!-- Tapered Vertical Divider Line -->
            <div class="hidden sm:block w-[1px] bg-gradient-to-b from-transparent via-white/35 to-transparent self-center h-16 shrink-0"></div>

            <!-- Segment 3: Perempuan (Putri) -->
            <div class="flex-1 min-w-[140px] sm:min-w-[160px] px-3 sm:px-4 flex flex-col justify-between group">
                <div>
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-[11px] font-black uppercase tracking-wider text-emerald-200 truncate">
                            Perempuan
                        </span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-white/15 text-emerald-100 border border-white/20">
                            Putri
                        </span>
                    </div>
                    <div class="text-3xl sm:text-4xl font-black text-white tracking-tight mt-1.5">
                        {{ number_format($stats['perempuan'] ?? 0, 0, ',', '.') }}
                    </div>
                </div>
                <div class="mt-3.5 pt-2 flex items-center justify-between text-xs text-emerald-200/90">
                    <span class="font-medium text-[11px] flex items-center gap-1">
                        <i class="ti ti-mood-kid text-xs opacity-70"></i>
                        <span>Santri Putri</span>
                    </span>
                    <span class="font-black text-white text-[10px] bg-white/15 px-2 py-0.5 rounded-md">
                        {{ $perempuanPersen }}%
                    </span>
                </div>
            </div>

            <!-- Tapered Vertical Divider Line -->
            <div class="hidden sm:block w-[1px] bg-gradient-to-b from-transparent via-white/35 to-transparent self-center h-16 shrink-0"></div>

            <!-- Segment 4: Siswa Baru (Santri Baru) -->
            <div class="flex-1 min-w-[140px] sm:min-w-[160px] px-3 sm:px-4 flex flex-col justify-between group">
                <div>
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-[11px] font-black uppercase tracking-wider text-emerald-200 truncate">
                            Siswa Baru
                        </span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-white/15 text-emerald-100 border border-white/20">
                            Baru
                        </span>
                    </div>
                    <div class="text-3xl sm:text-4xl font-black text-white tracking-tight mt-1.5">
                        {{ number_format($stats['siswa_baru'] ?? 0, 0, ',', '.') }}
                    </div>
                </div>
                <div class="mt-3.5 pt-2 flex items-center justify-between text-xs text-emerald-200/90">
                    <span class="font-medium text-[11px] flex items-center gap-1">
                        <i class="ti ti-sparkles text-xs opacity-70"></i>
                        <span>Tahun Masuk</span>
                    </span>
                    <span class="font-black text-white text-[10px] bg-white/15 px-2 py-0.5 rounded-md">
                        {{ config('global.tahun_ppdb') ?? date('Y') }}
                    </span>
                </div>
            </div>

        </div>
    </div>

    <!-- ================= 3. FILTER TOOLBAR (FULL-WIDTH 1 ROW WITH EXPANDING SEARCH & COMPACT BUTTONS) ================= -->
    <form action="{{ route('siswa.index') }}" method="GET" class="w-full">
        <div class="flex flex-col md:flex-row items-center gap-2.5 sm:gap-3 w-full">
            <!-- Search Input (Flex-1 expands to fill all remaining width) -->
            <div class="flex-1 min-w-0 w-full relative">
                <i class="ti ti-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-lg pointer-events-none"></i>
                <input type="text" 
                       name="nama_lengkap" 
                       value="{{ Request('nama_lengkap') }}" 
                       placeholder="Cari Nama Siswa / ID Siswa / NISN..." 
                       class="w-full pl-11 pr-4 py-2.5 sm:py-3 text-sm bg-white border border-slate-300/90 rounded-lg text-slate-800 font-medium placeholder-slate-400 shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
            </div>

            <!-- Tahun Masuk Filter -->
            <div class="w-full md:w-52 lg:w-56 shrink-0">
                <select name="tahun_masuk" id="tahun_masuk" class="w-full px-4 py-2.5 sm:py-3 text-sm bg-white border border-slate-300/90 rounded-lg text-slate-800 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                    <option value="">-- Semua Tahun Masuk --</option>
                    @foreach ($list_tahun_masuk as $t)
                        <option value="{{ $t->tahun_masuk }}" {{ Request('tahun_masuk') == $t->tahun_masuk ? 'selected' : '' }}>
                            Tahun Masuk {{ $t->tahun_masuk }}
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
                @if(Request('nama_lengkap') || Request('tahun_masuk'))
                    <a href="{{ route('siswa.index') }}" class="py-2.5 sm:py-3 px-3 bg-white hover:bg-slate-100 text-slate-600 border border-slate-300/90 rounded-lg font-semibold text-sm transition inline-flex items-center justify-center shrink-0 shadow-xs" title="Reset Filter">
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
                    <span>Daftar Siswa Terdaftar</span>
                </span>
                <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                <span>Menampilkan <strong class="text-slate-800 font-bold">{{ $siswa->firstItem() ?? 0 }}-{{ $siswa->lastItem() ?? 0 }}</strong> dari <strong class="text-slate-800 font-bold">{{ $siswa->total() }}</strong> siswa</span>
            </div>
            <div class="text-slate-400 font-medium">
                @if(Request('tahun_masuk'))
                    Tahun Masuk: <strong class="text-slate-700 font-bold">{{ Request('tahun_masuk') }}</strong>
                @else
                    Semua Angkatan Siswa
                @endif
            </div>
        </div>

        <!-- Cards List -->
        @forelse ($siswa as $d)
            @php
                $fotoSiswa = null;
                if (!empty($d->pendaftaran) && !empty($d->pendaftaran->foto)) {
                    $fotoSiswa = $d->pendaftaran->foto;
                } elseif (!empty($d->foto)) {
                    $fotoSiswa = $d->foto;
                }
            @endphp
            <div class="bg-white border border-slate-200/90 hover:border-slate-300/90 rounded-xl p-4 sm:p-5 shadow-xs hover:shadow-md transition-all duration-200 group">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                    
                    <!-- Left: Identity & Details -->
                    <div class="flex items-start sm:items-center gap-3.5 sm:gap-4 flex-1 min-w-0">
                        <!-- Row Index Badge -->
                        <div class="hidden sm:flex w-7 h-7 rounded-lg bg-slate-100 text-slate-500 text-[11px] font-bold items-center justify-center shrink-0 border border-slate-200/80">
                            {{ $loop->iteration + $siswa->firstItem() - 1 }}
                        </div>

                        <!-- Photo Thumbnail with Gender Indicator -->
                        <div class="relative shrink-0">
                            @if ($fotoSiswa && Storage::disk('public')->exists('photos/pendaftaran/' . $fotoSiswa))
                                <img src="{{ asset('storage/photos/pendaftaran/' . $fotoSiswa) }}" alt="{{ $d->nama_lengkap }}" class="w-12 h-15 sm:w-13 sm:h-16 rounded-lg object-cover border border-slate-200 shadow-2xs">
                            @elseif ($fotoSiswa && Storage::disk('public')->exists('photos/siswa/' . $fotoSiswa))
                                <img src="{{ asset('storage/photos/siswa/' . $fotoSiswa) }}" alt="{{ $d->nama_lengkap }}" class="w-12 h-15 sm:w-13 sm:h-16 rounded-lg object-cover border border-slate-200 shadow-2xs">
                            @else
                                <div class="w-12 h-15 sm:w-13 sm:h-16 rounded-lg {{ $d->jenis_kelamin == 'L' ? 'bg-emerald-50/70 border-emerald-200/80 text-emerald-700' : 'bg-rose-50/70 border-rose-200/80 text-rose-700' }} border flex flex-col items-center justify-center shadow-2xs">
                                    <span class="text-base sm:text-lg font-black">{{ strtoupper(substr($d->nama_lengkap, 0, 1)) }}</span>
                                    <span class="text-[9px] font-bold text-slate-400 mt-0.5">{{ $d->jenis_kelamin == 'L' ? 'L' : 'P' }}</span>
                                </div>
                            @endif

                            @if($d->jenis_kelamin == 'L')
                                <span class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full bg-blue-600 text-white flex items-center justify-center text-[10px] ring-2 ring-white shadow-xs" title="Laki-laki">
                                    <i class="ti ti-gender-male"></i>
                                </span>
                            @else
                                <span class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full bg-rose-500 text-white flex items-center justify-center text-[10px] ring-2 ring-white shadow-xs" title="Perempuan">
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

                                <!-- Tahun Masuk Badge -->
                                @if(!empty($d->tahun_masuk))
                                    <span class="px-2.5 py-0.5 rounded-md text-[10px] font-black uppercase tracking-wider bg-slate-100 text-slate-700 border border-slate-200/80">
                                        Masuk: {{ $d->tahun_masuk }}
                                    </span>
                                @endif
                            </div>

                            <!-- Meta Chips Grid/Flex -->
                            <div class="flex flex-wrap items-center gap-x-4 gap-y-1.5 mt-2 text-xs text-slate-500">
                                <div class="flex items-center gap-1.5">
                                    <span class="text-slate-400 font-medium">ID Siswa:</span>
                                    <span class="font-bold text-slate-800 bg-slate-100 px-1.5 py-0.5 rounded border border-slate-200 text-[11px] font-mono">{{ $d->id_siswa }}</span>
                                </div>

                                <div class="flex items-center gap-1.5">
                                    <span class="text-slate-400 font-medium">NISN:</span>
                                    <span class="font-semibold text-slate-700 text-[11px]">{{ $d->nisn ?? '-' }}</span>
                                </div>

                                @if(!empty($d->tanggal_lahir))
                                    <div class="flex items-center gap-1 text-[11px] text-slate-500">
                                        <i class="ti ti-calendar text-slate-400"></i>
                                        <span>Lahir: {{ DateToIndo($d->tanggal_lahir) }}</span>
                                    </div>
                                @endif

                                @if(!empty($d->tempat_lahir))
                                    <div class="flex items-center gap-1 text-[11px] text-slate-500">
                                        <i class="ti ti-map-pin text-slate-400"></i>
                                        <span>{{ $d->tempat_lahir }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Right: Action Buttons Toolbar -->
                    <div class="flex flex-wrap items-center justify-end gap-1.5 shrink-0 pt-3 lg:pt-0 border-t lg:border-t-0 border-slate-100">
                        @can('siswa.edit')
                            <button type="button" 
                                    class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 text-xs font-bold transition active:scale-95 btnEdit cursor-pointer"
                                    id_siswa="{{ Crypt::encrypt($d->id_siswa) }}">
                                <i class="ti ti-edit text-sm"></i>
                                <span>Edit</span>
                            </button>
                        @endcan

                        @can('siswa.show')
                            <a href="{{ route('siswa.show', Crypt::encrypt($d->id_siswa)) }}" 
                               class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 text-xs font-bold transition active:scale-95 cursor-pointer">
                                <i class="ti ti-file-description text-sm"></i>
                                <span>Detail</span>
                            </a>
                        @endcan

                        @can('siswa.delete')
                            <form method="POST" class="deleteform inline-block" action="{{ route('siswa.delete', Crypt::encrypt($d->id_siswa)) }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" 
                                        class="w-8.5 h-8.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 flex items-center justify-center transition active:scale-95 btn-delete-siswa cursor-pointer" 
                                        data-name="{{ $d->nama_lengkap }}"
                                        data-id="{{ $d->id_siswa }}"
                                        data-bs-toggle="tooltip" 
                                        data-bs-placement="top"
                                        title="Hapus Data Siswa">
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
                    <i class="ti ti-school-off"></i>
                </div>
                <h4 class="text-sm font-bold text-slate-800">Belum Ada Data Siswa</h4>
                <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">Silakan sesuaikan kata kunci pencarian atau klik tombol Tambah Siswa di atas untuk menambahkan data siswa baru.</p>
            </div>
        @endforelse

        <!-- Pagination -->
        @if ($siswa->hasPages())
            <div class="bg-white border border-slate-200/90 rounded-xl p-4 shadow-xs flex flex-col sm:flex-row items-center justify-between gap-3 mt-4">
                <div class="text-xs text-slate-500 font-medium">
                    Menampilkan <strong class="text-slate-800 font-bold">{{ $siswa->firstItem() }}</strong> - <strong class="text-slate-800 font-bold">{{ $siswa->lastItem() }}</strong> dari <strong class="text-slate-800 font-bold">{{ $siswa->total() }}</strong> total data
                </div>
                <div>
                    {{ $siswa->links('vendor.pagination.custom-tailwind') }}
                </div>
            </div>
        @endif
    </div>

</div>

<!-- ================= MODAL CONTAINER ================= -->
<x-modal-form id="modal" size="modal-xl" show="loadmodal" title="" icon="ti ti-school" />

@endsection

@push('myscript')
<script>
    $(function() {
        const loading = `
            <div class="p-12 text-center bg-white">
                <div class="w-10 h-10 border-3 border-emerald-500 border-t-transparent rounded-full animate-spin mx-auto mb-3"></div>
                <div class="text-xs font-bold text-slate-700">Memuat Formulir Data Siswa...</div>
            </div>
        `;

        $("#btnCreate").click(function(e) {
            e.preventDefault();
            e.stopPropagation();
            $("#modal").modal("show");
            $("#modal").find("#loadmodal").html(loading);
            $("#modal").find(".modal-title").text("Tambah Data Siswa Baru");
            $("#loadmodal").load(`/siswa/create`);
        });

        $(document).on('click', ".btnEdit", function(e) {
            e.preventDefault();
            e.stopPropagation();
            var id_siswa = $(this).attr("id_siswa");
            $("#modal").modal("show");
            $("#modal").find("#loadmodal").html(loading);
            $("#modal").find(".modal-title").text("Edit Data Siswa");
            $("#loadmodal").load(`/siswa/${id_siswa}/edit`);
        });

        // Delete Confirm with SweetAlert2
        $(document).on('click', ".btn-delete-siswa", function(e) {
            e.preventDefault();
            e.stopPropagation();
            var form = $(this).closest('form');
            var name = $(this).data('name') || 'siswa ini';
            var idSiswa = $(this).data('id') || '';

            Swal.fire({
                title: 'Hapus Data Siswa?',
                html: `
                    <div class="text-xs sm:text-sm text-slate-600 mt-2 space-y-2 text-center">
                        <p>Apakah Anda yakin ingin menghapus data siswa:</p>
                        <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-xl font-bold text-slate-900">
                            ${name} ${idSiswa ? `<span class="text-xs text-slate-500 font-mono block mt-0.5">ID: ${idSiswa}</span>` : ''}
                        </div>
                        <p class="text-[11px] text-rose-500 font-semibold">Seluruh data akademik, presensi, dan riwayat yang terkait dengan siswa ini akan dihapus secara permanen.</p>
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

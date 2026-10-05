@extends('layouts.app')
@section('titlepage', 'Master Perlombaan Got Talent')

@section('content')
<div class="space-y-6">

    <!-- ================= 1. PAGE HEADER & BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <i class="ti ti-trophy text-emerald-600 text-2xl"></i>
                <span>Master Perlombaan</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Kelola kategori cabang perlombaan Al Amin Got Talent, ketentuan biaya, berkas juknis & kontak narahubung
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
                    <i class="ti ti-sparkles text-sm"></i>
                    <span>Got Talent</span>
                </span>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Perlombaan</span>
            </nav>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center gap-2">
                @can('perlombaan.create')
                    <button type="button" id="btncreatePerlombaan" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs hover:shadow-md transition-all duration-200 active:scale-95 cursor-pointer">
                        <i class="ti ti-plus text-base"></i>
                        <span>Tambah Perlombaan</span>
                    </button>
                @endcan
            </div>
        </div>
    </div>

    <!-- ================= 2. EXECUTIVE STATISTICS SUMMARY (SOLID COLOR CARDS) ================= -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4">
        <!-- Card 1: Total Lomba (Solid Emerald) -->
        <div class="bg-emerald-600 rounded-2xl p-4 sm:p-5 shadow-sm hover:shadow-lg transition-all duration-200 group text-white relative overflow-hidden">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-extrabold uppercase tracking-wider text-emerald-100">Total Cabang</span>
                <div class="w-8 h-8 rounded-xl bg-white/20 text-white flex items-center justify-center text-base font-bold border border-white/20 group-hover:scale-110 transition-transform backdrop-blur-xs">
                    <i class="ti ti-trophy"></i>
                </div>
            </div>
            <div class="text-2xl sm:text-3xl font-black text-white tracking-tight mt-2">
                {{ $stats['total_lomba'] ?? $perlombaan->count() }}
            </div>
            <div class="mt-2.5 pt-2 border-t border-emerald-500/80 flex items-center justify-between text-[11px] text-emerald-100">
                <span>Kategori Aktif</span>
                <span class="font-bold bg-white/20 px-2 py-0.5 rounded-md backdrop-blur-xs text-white">Lomba</span>
            </div>
        </div>

        <!-- Card 2: Total Jenjang Terbuka (Solid Indigo) -->
        <div class="bg-indigo-600 rounded-2xl p-4 sm:p-5 shadow-sm hover:shadow-lg transition-all duration-200 group text-white relative overflow-hidden">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-extrabold uppercase tracking-wider text-indigo-100">Jenjang Peserta</span>
                <div class="w-8 h-8 rounded-xl bg-white/20 text-white flex items-center justify-center text-base font-bold border border-white/20 group-hover:scale-110 transition-transform backdrop-blur-xs">
                    <i class="ti ti-school"></i>
                </div>
            </div>
            <div class="text-2xl sm:text-3xl font-black text-white tracking-tight mt-2">
                {{ $stats['total_jenjang'] ?? '-' }}
            </div>
            <div class="mt-2.5 pt-2 border-t border-indigo-500/80 flex items-center justify-between text-[11px] text-indigo-100">
                <span>Tingkat Sasaran</span>
                <span class="font-bold bg-white/20 px-2 py-0.5 rounded-md backdrop-blur-xs text-white">Jenjang</span>
            </div>
        </div>

        <!-- Card 3: Total Pendaftar (Solid Sky/Blue) -->
        <div class="bg-sky-600 rounded-2xl p-4 sm:p-5 shadow-sm hover:shadow-lg transition-all duration-200 group text-white relative overflow-hidden">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-extrabold uppercase tracking-wider text-sky-100">Total Pendaftar</span>
                <div class="w-8 h-8 rounded-xl bg-white/20 text-white flex items-center justify-center text-base font-bold border border-white/20 group-hover:scale-110 transition-transform backdrop-blur-xs">
                    <i class="ti ti-users"></i>
                </div>
            </div>
            <div class="text-2xl sm:text-3xl font-black text-white tracking-tight mt-2">
                {{ $stats['total_peserta'] ?? 0 }}
            </div>
            <div class="mt-2.5 pt-2 border-t border-sky-500/80 flex items-center justify-between text-[11px] text-sky-100">
                <span>Peserta Terdaftar</span>
                <span class="font-bold bg-white/20 px-2 py-0.5 rounded-md backdrop-blur-xs text-white">Orang</span>
            </div>
        </div>

        <!-- Card 4: Dokumen Juknis (Solid Amber/Orange) -->
        <div class="bg-amber-500 rounded-2xl p-4 sm:p-5 shadow-sm hover:shadow-lg transition-all duration-200 group text-white relative overflow-hidden">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-extrabold uppercase tracking-wider text-amber-100">Juknis Terunggah</span>
                <div class="w-8 h-8 rounded-xl bg-white/20 text-white flex items-center justify-center text-base font-bold border border-white/20 group-hover:scale-110 transition-transform backdrop-blur-xs">
                    <i class="ti ti-file-certificate"></i>
                </div>
            </div>
            <div class="text-2xl sm:text-3xl font-black text-white tracking-tight mt-2">
                {{ $stats['total_juknis'] ?? '-' }}
            </div>
            <div class="mt-2.5 pt-2 border-t border-amber-400/80 flex items-center justify-between text-[11px] text-amber-100">
                <span>Panduan Lomba</span>
                <span class="font-bold bg-white/20 px-2 py-0.5 rounded-md backdrop-blur-xs text-white">Berkas</span>
            </div>
        </div>
    </div>

    <!-- ================= 3. FILTER TOOLBAR ================= -->
    <form action="{{ route('perlombaan.index') }}" method="GET" class="w-full">
        <div class="flex flex-col sm:flex-row items-center gap-2.5 sm:gap-3 w-full">
            <!-- Search Input -->
            <div class="flex-1 min-w-0 w-full relative">
                <i class="ti ti-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-lg pointer-events-none"></i>
                <input type="text" 
                       name="jenis_perlombaan_search" 
                       value="{{ Request('jenis_perlombaan_search') }}" 
                       placeholder="Cari cabang perlombaan..." 
                       class="w-full pl-11 pr-4 py-2.5 sm:py-3 text-sm bg-white border border-slate-300 rounded-xl text-slate-800 font-medium placeholder-slate-400 shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
            </div>

            <!-- Jenjang Filter -->
            <div class="w-full sm:w-64 shrink-0 relative">
                <i class="ti ti-school absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-lg pointer-events-none"></i>
                <select name="id_jenjang_search" 
                        class="w-full pl-11 pr-8 py-2.5 sm:py-3 text-sm bg-white border border-slate-300 rounded-xl text-slate-800 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition appearance-none">
                    <option value="">Semua Jenjang Pendidikan</option>
                    @foreach ($jenjangPendidikan as $d)
                        <option value="{{ $d->id }}" {{ Request('id_jenjang_search') == $d->id ? 'selected' : '' }}>
                            {{ $d->jenjang_pendidikan }}
                        </option>
                    @endforeach
                </select>
                <i class="ti ti-chevron-down absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2 shrink-0 w-full sm:w-auto">
                <button type="submit" class="w-full sm:w-auto px-5 py-2.5 sm:py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl shadow-xs transition inline-flex items-center justify-center gap-2 cursor-pointer active:scale-95 whitespace-nowrap">
                    <i class="ti ti-search text-base"></i>
                    <span>Cari</span>
                </button>
                @if(Request('jenis_perlombaan_search') || Request('id_jenjang_search'))
                    <a href="{{ route('perlombaan.index') }}" class="py-2.5 sm:py-3 px-3.5 bg-white hover:bg-slate-100 text-slate-600 border border-slate-300 rounded-xl font-semibold text-sm transition inline-flex items-center justify-center shrink-0 shadow-xs" title="Reset Filter">
                        <i class="ti ti-refresh text-base"></i>
                    </a>
                @endif
            </div>
        </div>
    </form>

    <!-- ================= 4. DATA LIST GRID CARDS (KOTAK-KOTAK MODERN) ================= -->
    <div class="space-y-4">
        <!-- Grid Header Counter -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 px-1 text-xs">
            <div class="flex items-center gap-2 text-slate-500 font-medium">
                <span class="font-bold text-slate-900 text-sm flex items-center gap-1.5">
                    <i class="ti ti-layout-grid text-emerald-600 text-base"></i>
                    <span>Daftar Cabang Lomba</span>
                </span>
                <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                <span>Menampilkan <strong class="text-slate-800 font-bold">{{ $perlombaan->count() }}</strong> cabang perlombaan</span>
            </div>
            <div class="text-slate-400 font-medium">
                Al Amin Got Talent Series
            </div>
        </div>

        @if($perlombaan->count() > 0)
            <!-- Grid Card Container (Kotak-Kotak 1 to 4 cols) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-5">
                @foreach ($perlombaan as $d)
                    <div class="bg-white border border-slate-200/90 hover:border-emerald-300/90 rounded-2xl p-4 shadow-xs hover:shadow-xl transition-all duration-300 flex flex-col justify-between group relative overflow-hidden">
                        
                        <!-- Top Accent Bar (Gradient line) -->
                        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-emerald-500 to-teal-400 opacity-80 group-hover:h-1.5 transition-all"></div>

                        <!-- Card Header: Image & Badges -->
                        <div>
                            <!-- Poster & Top Badges Container -->
                            <div class="relative w-full aspect-video rounded-xl overflow-hidden bg-slate-100 border border-slate-200/80 mb-3.5 group/img">
                                @if ($d->thumbnail)
                                    <img src="{{ asset('storage/' . $d->thumbnail) }}" alt="{{ $d->jenis_perlombaan }}" 
                                         class="w-full h-full object-cover group-hover/img:scale-105 transition-transform duration-300 cursor-pointer"
                                         onclick="showPosterPreview('{{ asset('storage/' . $d->thumbnail) }}', '{{ addslashes($d->jenis_perlombaan) }}')">
                                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover/img:opacity-100 transition-opacity flex items-center justify-center cursor-pointer pointer-events-none">
                                        <span class="px-2.5 py-1 bg-white/90 text-slate-900 rounded-lg text-xs font-bold shadow-md flex items-center gap-1">
                                            <i class="ti ti-zoom-in text-emerald-600"></i>
                                            <span>Lihat Poster</span>
                                        </span>
                                    </div>
                                @else
                                    <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 bg-gradient-to-br from-slate-50 to-slate-100">
                                        <i class="ti ti-trophy text-3xl text-emerald-500/60 mb-1"></i>
                                        <span class="text-[11px] font-semibold text-slate-400">Got Talent</span>
                                    </div>
                                @endif

                                <!-- Badge Jenjang (Top Left) -->
                                @if($d->jenjangPendidikan)
                                    <div class="absolute top-2 left-2">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[11px] font-bold bg-white/95 text-indigo-700 shadow-sm backdrop-blur-xs border border-indigo-100">
                                            <i class="ti ti-school text-xs"></i>
                                            <span>{{ $d->jenjangPendidikan->jenjang_pendidikan }}</span>
                                        </span>
                                    </div>
                                @endif

                                <!-- Badge Biaya (Top Right) -->
                                <div class="absolute top-2 right-2">
                                    @if (!is_null($d->biaya_pendaftaran) && $d->biaya_pendaftaran > 0)
                                        <span class="px-2.5 py-1 rounded-lg text-[11px] font-bold bg-emerald-600 text-white shadow-sm font-mono">
                                            Rp {{ formatRupiah($d->biaya_pendaftaran) }}
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-lg text-[11px] font-bold bg-emerald-500 text-white shadow-sm">
                                            Gratis
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Title -->
                            <h3 class="font-black text-slate-900 text-base leading-snug group-hover:text-emerald-700 transition line-clamp-2" title="{{ $d->jenis_perlombaan }}">
                                {{ $d->jenis_perlombaan }}
                            </h3>

                            <!-- Key Specs / Information Items -->
                            <div class="mt-3.5 space-y-2 pt-3 border-t border-slate-100 text-xs">
                                
                                <!-- Contact Person -->
                                <div class="flex items-center justify-between gap-2">
                                    <span class="text-slate-400 flex items-center gap-1.5 shrink-0 text-[11px]">
                                        <i class="ti ti-user-check text-slate-400 text-sm"></i>
                                        <span>Kontak:</span>
                                    </span>
                                    @if ($d->contact_person)
                                        @php
                                            preg_match('/\d{9,15}/', $d->contact_person, $phoneMatches);
                                            $cleanPhone = !empty($phoneMatches[0]) ? preg_replace('/^0/', '62', $phoneMatches[0]) : null;
                                        @endphp
                                        @if ($cleanPhone)
                                            <a href="https://wa.me/{{ $cleanPhone }}" target="_blank" 
                                               class="font-semibold text-emerald-700 hover:text-emerald-800 hover:underline flex items-center gap-1 truncate" title="Hubungi via WhatsApp">
                                                <i class="ti ti-brand-whatsapp text-emerald-600 text-sm shrink-0"></i>
                                                <span class="truncate">{{ $d->contact_person }}</span>
                                            </a>
                                        @else
                                            <span class="font-medium text-slate-700 truncate">{{ $d->contact_person }}</span>
                                        @endif
                                    @else
                                        <span class="text-slate-400 italic">-</span>
                                    @endif
                                </div>

                                <!-- Peserta Terdaftar -->
                                <div class="flex items-center justify-between gap-2">
                                    <span class="text-slate-400 flex items-center gap-1.5 shrink-0 text-[11px]">
                                        <i class="ti ti-users text-slate-400 text-sm"></i>
                                        <span>Pendaftar:</span>
                                    </span>
                                    <span class="font-bold {{ ($d->pendaftaran_count ?? 0) > 0 ? 'text-sky-700 bg-sky-50 px-2 py-0.5 rounded-md border border-sky-200/80 text-[11px]' : 'text-slate-500' }}">
                                        {{ $d->pendaftaran_count ?? 0 }} Peserta
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Card Footer Actions -->
                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between gap-2">
                            <!-- Download Juknis Button -->
                            @if ($d->juknis_juklak)
                                <a href="{{ asset('storage/' . $d->juknis_juklak) }}" target="_blank" 
                                   class="flex-1 inline-flex items-center justify-center gap-1.5 py-2 px-3 bg-teal-50 hover:bg-teal-100 text-teal-800 font-bold rounded-xl text-xs border border-teal-200/80 transition active:scale-95 shadow-2xs"
                                   title="Unduh Panduan Juknis">
                                    <i class="ti ti-download text-sm text-teal-600"></i>
                                    <span>Juknis</span>
                                </a>
                            @else
                                <span class="flex-1 inline-flex items-center justify-center gap-1 py-2 px-3 bg-slate-100 text-slate-400 font-medium rounded-xl text-xs cursor-not-allowed">
                                    <i class="ti ti-file-off text-sm"></i>
                                    <span>No Juknis</span>
                                </span>
                            @endif

                            <!-- Edit & Delete Action Buttons -->
                            <div class="flex items-center gap-1.5 shrink-0">
                                @can('perlombaan.edit')
                                    <button type="button" 
                                            class="w-8 h-8 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200/80 flex items-center justify-center transition active:scale-95 cursor-pointer shadow-2xs editPerlombaan"
                                            id_perlombaan="{{ Crypt::encrypt($d->id) }}"
                                            title="Edit Cabang Perlombaan">
                                        <i class="ti ti-edit text-sm"></i>
                                    </button>
                                @endcan

                                @can('perlombaan.delete')
                                    <form method="POST" name="deleteform" class="deleteform inline-block"
                                          action="{{ route('perlombaan.delete', Crypt::encrypt($d->id)) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                class="w-8 h-8 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200/80 flex items-center justify-center transition active:scale-95 cursor-pointer shadow-2xs delete-confirm"
                                                title="Hapus Cabang Perlombaan">
                                            <i class="ti ti-trash text-sm"></i>
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State Card -->
            <div class="bg-white border border-slate-200/90 rounded-2xl p-12 text-center shadow-xs">
                <div class="w-16 h-16 rounded-2xl bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-400 text-3xl mx-auto mb-3.5">
                    <i class="ti ti-trophy-off"></i>
                </div>
                <h4 class="font-extrabold text-slate-800 text-base">Belum Ada Cabang Perlombaan</h4>
                <p class="text-xs text-slate-400 mt-1 max-w-md mx-auto">
                    Data cabang perlombaan belum tersedia atau tidak cocok dengan filter pencarian. Klik tombol Tambah Perlombaan untuk mulai membuat.
                </p>
            </div>
        @endif
    </div>

</div>

<!-- Poster Preview Modal -->
<div class="modal fade" id="mdlPosterPreview" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border border-slate-200/90 shadow-2xl rounded-2xl bg-white overflow-hidden">
            <div class="px-5 py-3.5 bg-white border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-2 font-bold text-slate-900 text-sm">
                    <i class="ti ti-photo text-emerald-600 text-base"></i>
                    <span id="posterPreviewTitle">Poster Perlombaan</span>
                </div>
                <button type="button" class="w-7 h-7 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 flex items-center justify-center transition cursor-pointer" data-bs-dismiss="modal">
                    <i class="ti ti-x text-base"></i>
                </button>
            </div>
            <div class="p-4 bg-slate-50 flex items-center justify-center">
                <img id="posterPreviewImg" src="" alt="Poster" class="max-h-[75vh] w-auto rounded-xl object-contain shadow-md border border-slate-200">
            </div>
        </div>
    </div>
</div>

<!-- Modal Form Create & Edit -->
<x-modal-form id="mdlcreatePerlombaan" size="" show="loadcreatePerlombaan" title="Tambah Cabang Perlombaan" icon="ti ti-trophy" />
<x-modal-form id="mdleditPerlombaan" size="" show="loadeditPerlombaan" title="Edit Cabang Perlombaan" icon="ti ti-edit" />

@endsection

@push('myscript')
<script>
    function showPosterPreview(url, title) {
        $('#posterPreviewImg').attr('src', url);
        $('#posterPreviewTitle').text(title);
        $('#mdlPosterPreview').modal('show');
    }

    $(function() {
        $("#btncreatePerlombaan").click(function(e) {
            e.preventDefault();
            $('#mdlcreatePerlombaan').modal("show");
            $("#loadcreatePerlombaan").html(`
                <div class="text-center py-6">
                    <div class="spinner-border text-emerald-600" role="status">
                        <span class="visually-hidden">Memuat...</span>
                    </div>
                    <p class="mt-2 text-xs text-slate-500">Memuat formulir...</p>
                </div>
            `);
            $("#loadcreatePerlombaan").load('{{ route("perlombaan.create") }}');
        });

        $(document).on("click", ".editPerlombaan", function(e) {
            var id_perlombaan = $(this).attr("id_perlombaan");
            e.preventDefault();
            $('#mdleditPerlombaan').modal("show");
            $("#loadeditPerlombaan").html(`
                <div class="text-center py-6">
                    <div class="spinner-border text-emerald-600" role="status">
                        <span class="visually-hidden">Memuat...</span>
                    </div>
                    <p class="mt-2 text-xs text-slate-500">Memuat formulir...</p>
                </div>
            `);
            $("#loadeditPerlombaan").load('/perlombaan/' + id_perlombaan + '/edit');
        });

        // SweetAlert Delete Confirmation
        $(document).on("click", ".delete-confirm", function(e) {
            e.preventDefault();
            var form = $(this).closest("form");
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "Data cabang perlombaan ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus!',
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

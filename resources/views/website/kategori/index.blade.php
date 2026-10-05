@extends('layouts.app')
@section('titlepage', 'Kategori Berita & Konten')

@section('content')
<div class="space-y-5">

    <!-- ================= 1. PAGE HEADER (NO CARD) WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center border border-emerald-200/80 shadow-2xs">
                    <i class="ti ti-category text-2xl"></i>
                </div>
                <span>Kategori Berita & Konten</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Kelola taksonomi dan pengelompokan warta, rilis berita, serta artikel website
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
                    <i class="ti ti-world text-sm"></i>
                    <span>Website</span>
                </span>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Kategori</span>
            </nav>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center gap-2">
                @can('kategori.create')
                    <button type="button" id="btncreate" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs transition-all duration-200 active:scale-95 cursor-pointer">
                        <i class="ti ti-plus text-base"></i>
                        <span>Tambah Kategori Baru</span>
                    </button>
                @endcan
            </div>
        </div>
    </div>

    <!-- ================= 2. FILTER & SEARCH TOOLBAR ================= -->
    <form action="{{ route('kategori.index') }}" method="GET" class="w-full">
        <div class="flex flex-col sm:flex-row items-center gap-2.5 sm:gap-3 w-full">
            <!-- Search Input -->
            <div class="flex-1 min-w-0 w-full relative">
                <i class="ti ti-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-lg pointer-events-none"></i>
                <input type="text" 
                       name="nama_kategori" 
                       value="{{ Request('nama_kategori') }}" 
                       placeholder="Cari nama atau slug kategori berita..." 
                       class="w-full pl-11 pr-4 py-2.5 sm:py-3 text-sm bg-white border border-slate-300/90 rounded-xl text-slate-800 font-medium placeholder-slate-400 shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2 shrink-0 w-full sm:w-auto">
                <button type="submit" class="w-full sm:w-auto px-5 py-2.5 sm:py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl shadow-xs transition inline-flex items-center justify-center gap-2 cursor-pointer active:scale-95 whitespace-nowrap">
                    <i class="ti ti-search text-base"></i>
                    <span>Cari</span>
                </button>
                @if(request()->filled('nama_kategori'))
                    <a href="{{ route('kategori.index') }}" class="py-2.5 sm:py-3 px-3.5 bg-white hover:bg-slate-100 text-slate-600 border border-slate-300/90 rounded-xl font-semibold text-sm transition inline-flex items-center justify-center shrink-0 shadow-xs" title="Reset Filter">
                        <i class="ti ti-refresh text-base"></i>
                    </a>
                @endif
            </div>
        </div>
    </form>

    <!-- ================= 3. SOLID EMERALD TABLE CARD ================= -->
    <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
        <!-- Solid Emerald Header -->
        <div class="bg-emerald-600 px-5 py-4 flex items-center justify-between text-white">
            <div class="flex items-center gap-2.5">
                <i class="ti ti-folder-check text-xl"></i>
                <h3 class="font-bold text-sm tracking-wide text-white">Daftar Kategori Berita</h3>
            </div>
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-white/20 text-white backdrop-blur-xs">
                Total: {{ $kategori->total() }} Data
            </span>
        </div>

        <!-- Table Container -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-emerald-600 text-white uppercase text-[11px] font-extrabold tracking-wider border-t border-emerald-500/50">
                        <th class="py-3.5 px-4 w-14 text-center">NO</th>
                        <th class="py-3.5 px-5 min-w-[240px]">NAMA KATEGORI</th>
                        <th class="py-3.5 px-5 min-w-[200px]">SLUG URL</th>
                        <th class="py-3.5 px-4 text-center w-40">JUMLAH POST</th>
                        <th class="py-3.5 px-4 text-center w-28">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                    @forelse ($kategori as $d)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <!-- No -->
                            <td class="py-4 px-4 text-center font-bold text-slate-400">
                                {{ $loop->iteration + $kategori->firstItem() - 1 }}
                            </td>

                            <!-- Nama Kategori -->
                            <td class="py-4 px-5">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0 border border-emerald-100 font-bold text-xs">
                                        <i class="ti ti-tag"></i>
                                    </div>
                                    <span class="font-bold text-slate-800 text-sm leading-snug">
                                        {{ $d->name }}
                                    </span>
                                </div>
                            </td>

                            <!-- Slug URL -->
                            <td class="py-4 px-5">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-slate-100 text-slate-600 font-mono text-[11px] border border-slate-200">
                                    <i class="ti ti-link text-slate-400"></i>
                                    {{ $d->slug }}
                                </span>
                            </td>

                            <!-- Jumlah Post -->
                            <td class="py-4 px-4 text-center">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold {{ $d->posts_count > 0 ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/80' : 'bg-slate-100 text-slate-500 border border-slate-200' }}">
                                    <i class="ti ti-news text-[13px]"></i>
                                    {{ $d->posts_count }} Artikel
                                </span>
                            </td>

                            <!-- Aksi -->
                            <td class="py-4 px-4 text-center">
                                <div class="inline-flex items-center justify-center gap-1.5">
                                    @can('kategori.edit')
                                        <a href="#" 
                                           class="w-8 h-8 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 flex items-center justify-center transition-colors border border-emerald-200/60 edit" 
                                           id="{{ Crypt::encrypt($d->id) }}"
                                           title="Edit Kategori">
                                            <i class="ti ti-edit text-base"></i>
                                        </a>
                                    @endcan

                                    @can('kategori.delete')
                                        <form method="POST" name="deleteform" class="deleteform inline-block"
                                              action="{{ route('kategori.delete', Crypt::encrypt($d->id)) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" 
                                                    class="w-8 h-8 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 flex items-center justify-center transition-colors border border-rose-200/60 delete-confirm cursor-pointer"
                                                    title="Hapus Kategori">
                                                <i class="ti ti-trash text-base"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center">
                                <div class="flex flex-col items-center justify-center gap-3">
                                    <div class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center">
                                        <i class="ti ti-folder-x text-3xl"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-700 text-sm">Belum Ada Data Kategori</p>
                                        <p class="text-xs text-slate-400 mt-0.5">Silahkan klik tombol Tambah Kategori Baru untuk membuat taksonomi artikel.</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Footer -->
        @if ($kategori->hasPages())
            <div class="px-5 py-3.5 border-t border-slate-100 bg-slate-50/50">
                {{ $kategori->links() }}
            </div>
        @endif
    </div>
</div>

<x-modal-form id="mdlcreate" size="" show="loadcreate" title="Tambah Kategori Berita" />
<x-modal-form id="mdledit" size="" show="loadedit" title="Edit Kategori Berita" />

@endsection

@push('myscript')
<script>
    $(function() {
        $("#btncreate").click(function(e) {
            e.preventDefault();
            $('#mdlcreate').modal("show");
            $("#loadcreate").html(`
                <div class="p-8 text-center text-slate-400">
                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-emerald-500 border-t-transparent mb-2"></div>
                    <p class="text-xs font-semibold">Memuat formulir...</p>
                </div>
            `);
            $("#loadcreate").load('/kategori/create');
        });

        $(document).on("click", ".edit", function(e) {
            var id = $(this).attr("id");
            e.preventDefault();
            $('#mdledit').modal("show");
            $("#loadedit").html(`
                <div class="p-8 text-center text-slate-400">
                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-emerald-500 border-t-transparent mb-2"></div>
                    <p class="text-xs font-semibold">Memuat formulir edit...</p>
                </div>
            `);
            $("#loadedit").load('/kategori/' + id + '/edit');
        });
    });
</script>
@endpush

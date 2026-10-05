@extends('layouts.app')
@section('titlepage', 'Data Post & Berita')

@section('content')
<div class="space-y-5">

    <!-- ================= 1. PAGE HEADER (NO CARD) WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center border border-emerald-200/80 shadow-2xs">
                    <i class="ti ti-news text-2xl"></i>
                </div>
                <span>Data Post & Berita</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Kelola publikasi warta, artikel edukasi, agenda, dan rilis kegiatan unit pesantren
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
                <span class="font-bold text-slate-800">Post</span>
            </nav>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center gap-2">
                @can('post.create')
                    <button type="button" id="btncreate" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs transition-all duration-200 active:scale-95 cursor-pointer">
                        <i class="ti ti-plus text-base"></i>
                        <span>Tambah Post Baru</span>
                    </button>
                @endcan
            </div>
        </div>
    </div>

    <!-- ================= 2. FILTER & SEARCH TOOLBAR ================= -->
    <form action="{{ route('post.index') }}" method="GET" class="w-full">
        <div class="flex flex-col sm:flex-row items-center gap-2.5 sm:gap-3 w-full">
            <!-- Search Input -->
            <div class="flex-1 min-w-0 w-full relative">
                <i class="ti ti-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-lg pointer-events-none"></i>
                <input type="text" 
                       name="title" 
                       value="{{ Request('title') }}" 
                       placeholder="Cari judul warta atau artikel..." 
                       class="w-full pl-11 pr-4 py-2.5 sm:py-3 text-sm bg-white border border-slate-300/90 rounded-xl text-slate-800 font-medium placeholder-slate-400 shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
            </div>

            <!-- Unit Filter -->
            <div class="w-full sm:w-64">
                <select name="kode_unit" class="w-full py-2.5 sm:py-3 px-3 text-sm bg-white border border-slate-300/90 rounded-xl text-slate-800 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition cursor-pointer" onchange="this.form.submit()">
                    <option value="">Semua Unit</option>
                    @foreach ($units as $u)
                        <option value="{{ $u->kode_unit }}" {{ Request('kode_unit') == $u->kode_unit ? 'selected' : '' }}>
                            {{ $u->nama_unit }} ({{ $u->kode_unit }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2 shrink-0 w-full sm:w-auto">
                <button type="submit" class="w-full sm:w-auto px-5 py-2.5 sm:py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl shadow-xs transition inline-flex items-center justify-center gap-2 cursor-pointer active:scale-95 whitespace-nowrap">
                    <i class="ti ti-search text-base"></i>
                    <span>Cari</span>
                </button>
                @if(Request('title') || Request('kode_unit'))
                    <a href="{{ route('post.index') }}" class="py-2.5 sm:py-3 px-3 bg-white hover:bg-slate-100 text-slate-600 border border-slate-300/90 rounded-xl font-semibold text-sm transition inline-flex items-center justify-center shrink-0 shadow-xs" title="Reset Filter">
                        <i class="ti ti-refresh text-base"></i>
                    </a>
                @endif
            </div>
        </div>
    </form>

    <!-- ================= 3. DATA TABLE (SEAMLESS SOLID GREEN HEADER) ================= -->
    <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
        
        <!-- Seamless Solid Green Card Header -->
        <div class="px-5 pt-4 pb-3 bg-emerald-600 flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-white border-0">
            <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-lg bg-white/20 text-white flex items-center justify-center text-xs font-bold border border-white/20 shadow-2xs">
                    <i class="ti ti-news"></i>
                </div>
                <h3 class="text-sm font-extrabold text-white tracking-tight">Daftar Publikasi Post Berita</h3>
                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-white/20 text-white border border-white/30 shadow-2xs backdrop-blur-xs">
                    {{ $posts->total() }} Post
                </span>
            </div>
            <div class="text-xs text-emerald-100 font-medium">
                Format gambar terkompresi otomatis menjadi WebP untuk performa website optimal
            </div>
        </div>

        <!-- Responsive Table Container -->
        <div class="overflow-x-auto bg-emerald-600">
            <table class="w-full text-left text-xs sm:text-sm border-0 border-collapse">
                <!-- Matching Solid Green Table Header -->
                <thead class="bg-emerald-600 text-white font-bold uppercase tracking-wider text-[11px] border-0 border-t-0 border-b border-emerald-700/80">
                    <tr>
                        <th class="py-3 px-4 text-center w-12 text-emerald-100 font-extrabold">NO</th>
                        <th class="py-3 px-4 w-28 text-emerald-100 font-extrabold">COVER</th>
                        <th class="py-3 px-4 text-emerald-100 font-extrabold">JUDUL & SLUG</th>
                        <th class="py-3 px-4 w-40 text-emerald-100 font-extrabold">UNIT</th>
                        <th class="py-3 px-4 w-36 text-emerald-100 font-extrabold">KATEGORI</th>
                        <th class="py-3 px-4 w-36 text-emerald-100 font-extrabold">PENULIS / TANGGAL</th>
                        <th class="py-3 px-4 text-center w-24 text-emerald-100 font-extrabold">AKSI</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-100">
                    @forelse ($posts as $d)
                        <tr class="hover:bg-emerald-50/40 transition-colors group">
                            <!-- Nomor -->
                            <td class="py-3.5 px-4 text-center font-bold text-slate-500 text-xs">
                                {{ ($posts->currentPage() - 1) * $posts->perPage() + $loop->iteration }}
                            </td>

                            <!-- Cover Image Thumbnail -->
                            <td class="py-3.5 px-4">
                                <div class="w-20 h-14 rounded-xl overflow-hidden bg-slate-100 border border-slate-200 shadow-2xs relative group/img">
                                    @php
                                        $imagePath = str_replace(url('/storage/'), '', $d->image);
                                    @endphp
                                    @if ($d->image && Storage::disk('public')->exists($imagePath))
                                        <img src="{{ $d->image }}" alt="{{ $d->title }}" class="w-full h-full object-cover group-hover/img:scale-110 transition-transform duration-300">
                                    @else
                                        <div class="bg-emerald-50 text-emerald-700 d-flex flex-col align-items-center justify-content-center h-100 w-100 text-center p-1">
                                            <i class="ti ti-photo fs-4 mb-0"></i>
                                            <span style="font-size: 8px;">No Image</span>
                                        </div>
                                    @endif
                                </div>
                            </td>

                            <!-- Judul & Slug -->
                            <td class="py-3.5 px-4 min-w-[220px]">
                                <h4 class="text-sm font-bold text-slate-900 group-hover:text-emerald-700 transition-colors line-clamp-2 leading-snug mb-1">
                                    {{ $d->title }}
                                </h4>
                                <span class="text-[11px] text-slate-400 font-mono block truncate max-w-xs">
                                    /{{ $d->slug }}
                                </span>
                            </td>

                            <!-- Unit -->
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200/70">
                                    <i class="ti ti-building text-xs"></i>
                                    {{ $d->unit->nama_unit ?? $d->kode_unit ?? 'Umum' }}
                                </span>
                            </td>

                            <!-- Kategori -->
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200/80">
                                    <i class="ti ti-bookmark text-xs text-emerald-600"></i>
                                    {{ $d->category->name ?? 'Warta' }}
                                </span>
                            </td>

                            <!-- Penulis & Tanggal -->
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <div class="text-xs font-semibold text-slate-800">
                                    {{ $d->user->name ?? 'Redaksi' }}
                                </div>
                                <div class="text-[11px] text-slate-400 mt-0.5 flex items-center gap-1">
                                    <i class="ti ti-calendar text-xs"></i>
                                    {{ $d->created_at ? $d->created_at->translatedFormat('d M Y') : '-' }}
                                </div>
                            </td>

                            <!-- Action -->
                            <td class="py-3.5 px-4 text-center">
                                <div class="inline-flex items-center justify-center gap-1.5">
                                    @can('post.edit')
                                        <button type="button" 
                                                class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-600 hover:text-white border border-emerald-200/80 flex items-center justify-center transition-all duration-150 active:scale-90 edit cursor-pointer shadow-2xs"
                                                id="{{ Crypt::encrypt($d->id) }}"
                                                title="Edit Post">
                                            <i class="ti ti-edit text-base"></i>
                                        </button>
                                    @endcan
                                    
                                    @can('post.delete')
                                        <form method="POST" name="deleteform" class="deleteform m-0 inline"
                                              action="{{ route('post.delete', Crypt::encrypt($d->id)) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white border border-rose-200/80 flex items-center justify-center transition-all duration-150 active:scale-90 delete-confirm cursor-pointer shadow-2xs"
                                                    title="Hapus Post">
                                                <i class="ti ti-trash text-base"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-14 text-center bg-white">
                                <div class="w-16 h-16 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3 text-2xl shadow-inner">
                                    <i class="ti ti-news-off"></i>
                                </div>
                                <h4 class="text-sm font-bold text-slate-800 mb-1">Belum Ada Post Berita</h4>
                                <p class="text-xs text-slate-400 max-w-sm mx-auto">
                                    Silahkan tambahkan post baru atau sesuaikan kata kunci filter pencarian.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($posts->hasPages())
            <div class="px-5 py-4 bg-white border-t border-slate-100 flex items-center justify-between">
                <div class="text-xs text-slate-500">
                    Menampilkan <span class="font-bold text-slate-700">{{ $posts->firstItem() }}</span> - <span class="font-bold text-slate-700">{{ $posts->lastItem() }}</span> dari <span class="font-bold text-slate-700">{{ $posts->total() }}</span> post
                </div>
                <div>
                    {{ $posts->links() }}
                </div>
            </div>
        @endif
    </div>

</div>

<x-modal-form id="mdlcreate" size="modal-lg" show="loadcreate" title="Tambah Post Baru" />
<x-modal-form id="mdledit" size="modal-lg" show="loadedit" title="Edit Data Post" />
@endsection

@push('myscript')
<script>
    $(function() {
        $("#btncreate").click(function(e) {
            e.preventDefault();
            $('#mdlcreate').modal("show");
            $("#loadcreate").load('/post/create');
        });

        $(document).on('click', '.edit', function(e) {
            var id = $(this).attr("id");
            e.preventDefault();
            $('#mdledit').modal("show");
            $("#loadedit").load('/post/' + id + '/edit');
        });
    });
</script>
@endpush

@extends('layouts.app')
@section('titlepage', 'Galeri Kegiatan')

@section('content')
<div class="space-y-5">

    <!-- ================= 1. PAGE HEADER (NO CARD) WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center border border-emerald-200/80 shadow-2xs">
                    <i class="ti ti-photo-album text-2xl"></i>
                </div>
                <span>Galeri Kegiatan & Dokumentasi</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Kelola album foto momen kegiatan, rilis dokumentasi santri, dan foto animasi hero website
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
                <span class="font-bold text-slate-800">Galeri Kegiatan</span>
            </nav>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('gallery.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs transition-all duration-200 active:scale-95 cursor-pointer">
                    <i class="ti ti-plus text-base"></i>
                    <span>Tambah Album Baru</span>
                </a>
            </div>
        </div>
    </div>

    <!-- ================= 2. ALBUM GRID DISPLAY ================= -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
        @forelse ($albums as $album)
            <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden flex flex-col justify-between hover:shadow-md hover:border-emerald-300/80 transition-all duration-300 group">
                <div>
                    <!-- Album Cover Thumbnail -->
                    <div class="relative h-48 w-full bg-slate-100 overflow-hidden">
                        @if($album->cover)
                            <img src="{{ asset('storage/' . $album->cover) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="{{ $album->title }}">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 bg-slate-50">
                                <i class="ti ti-photo text-4xl mb-1 text-slate-300"></i>
                                <span class="text-[11px] font-medium">Belum ada cover</span>
                            </div>
                        @endif

                        <!-- Photo Count Badge -->
                        <span class="absolute top-3 right-3 inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-slate-900/70 text-white backdrop-blur-md shadow-xs border border-white/20">
                            <i class="ti ti-photo text-xs text-emerald-400"></i>
                            {{ $album->photos_count }} Foto
                        </span>
                    </div>

                    <!-- Album Content -->
                    <div class="p-4 space-y-2">
                        <h3 class="font-bold text-slate-900 text-sm group-hover:text-emerald-700 transition-colors line-clamp-1 leading-snug">
                            {{ $album->title }}
                        </h3>
                        <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                            {{ $album->description ?: 'Tidak ada deskripsi singkat.' }}
                        </p>
                    </div>
                </div>

                <!-- Card Footer Actions -->
                <div class="p-4 pt-0 border-t border-slate-100/80 mt-2 flex items-center justify-between gap-2">
                    <span class="text-[11px] text-slate-400 font-medium">
                        {{ $album->created_at ? $album->created_at->translatedFormat('d M Y') : '-' }}
                    </span>
                    <div class="flex items-center gap-1.5">
                        <a href="{{ route('gallery.edit', $album->id) }}" 
                           class="w-8 h-8 rounded-lg bg-slate-50 hover:bg-slate-100 text-slate-600 flex items-center justify-center transition-colors border border-slate-200 shadow-2xs" 
                           title="Edit Album">
                            <i class="ti ti-edit text-sm"></i>
                        </a>
                        <a href="{{ route('gallery.show', $album->id) }}" 
                           class="inline-flex items-center gap-1 px-3 py-1.5 bg-emerald-50 hover:bg-emerald-600 text-emerald-700 hover:text-white font-bold rounded-lg text-xs border border-emerald-200/80 transition-all duration-150 shadow-2xs">
                            <i class="ti ti-photo-cog text-sm"></i>
                            <span>Kelola</span>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center bg-white border border-slate-200/90 rounded-2xl shadow-xs">
                <div class="w-16 h-16 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3 text-3xl shadow-inner">
                    <i class="ti ti-photo-off"></i>
                </div>
                <h4 class="font-bold text-slate-800 text-base mb-1">Belum Ada Album Foto</h4>
                <p class="text-xs text-slate-400 max-w-sm mx-auto mb-4">
                    Dokumentasikan kegiatan santri dan pesantren dengan membuat album baru.
                </p>
                <a href="{{ route('gallery.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs transition">
                    <i class="ti ti-plus text-base"></i>
                    <span>Tambah Album Pertama</span>
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if ($albums->hasPages())
        <div class="mt-4">
            {{ $albums->links() }}
        </div>
    @endif
</div>
@endsection

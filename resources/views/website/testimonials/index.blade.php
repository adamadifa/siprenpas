@extends('layouts.app')
@section('titlepage', 'Testimoni & Ulasan')

@section('content')
<div class="space-y-5">

    <!-- ================= 1. PAGE HEADER (NO CARD) WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center border border-emerald-200/80 shadow-2xs">
                    <i class="ti ti-message-quote text-2xl"></i>
                </div>
                <span>Testimoni & Ulasan</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Kelola cerita pengalaman, ulasan, dan testimoni apresiasi dari wali santri, alumni, dan tokoh masyarakat
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
                <span class="font-bold text-slate-800">Testimoni</span>
            </nav>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center gap-2">
                @can('testimonials.create')
                    <a href="{{ route('testimonials.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs transition-all duration-200 active:scale-95 cursor-pointer">
                        <i class="ti ti-plus text-base"></i>
                        <span>Tambah Testimoni Baru</span>
                    </a>
                @endcan
            </div>
        </div>
    </div>

    <!-- ================= 2. FILTER & SEARCH TOOLBAR ================= -->
    <form action="{{ route('testimonials.index') }}" method="GET" class="w-full">
        <div class="flex flex-col sm:flex-row items-center gap-2.5 sm:gap-3 w-full">
            <!-- Search Input -->
            <div class="flex-1 min-w-0 w-full relative">
                <i class="ti ti-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-lg pointer-events-none"></i>
                <input type="text" 
                       name="nama" 
                       value="{{ Request('nama') }}" 
                       placeholder="Cari nama pemberi testimoni..." 
                       class="w-full pl-11 pr-4 py-2.5 sm:py-3 text-sm bg-white border border-slate-300/90 rounded-xl text-slate-800 font-medium placeholder-slate-400 shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
            </div>

            <!-- Filter Status -->
            <div class="w-full sm:w-56 shrink-0">
                <select name="status" class="w-full py-2.5 sm:py-3 px-3 text-sm bg-white border border-slate-300/90 rounded-xl text-slate-800 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition cursor-pointer">
                    <option value="">Semua Status</option>
                    <option value="1" {{ Request('status') === '1' ? 'selected' : '' }}>Aktif (Tampil)</option>
                    <option value="0" {{ Request('status') === '0' ? 'selected' : '' }}>Nonaktif (Draft)</option>
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2 shrink-0 w-full sm:w-auto">
                <button type="submit" class="w-full sm:w-auto px-5 py-2.5 sm:py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl shadow-xs transition inline-flex items-center justify-center gap-2 cursor-pointer active:scale-95 whitespace-nowrap">
                    <i class="ti ti-search text-base"></i>
                    <span>Cari</span>
                </button>
                @if(request()->filled('nama') || request()->filled('status'))
                    <a href="{{ route('testimonials.index') }}" class="py-2.5 sm:py-3 px-3.5 bg-white hover:bg-slate-100 text-slate-600 border border-slate-300/90 rounded-xl font-semibold text-sm transition inline-flex items-center justify-center shrink-0 shadow-xs" title="Reset Filter">
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
                <i class="ti ti-quote text-xl"></i>
                <h3 class="font-bold text-sm tracking-wide text-white">Daftar Testimoni & Ulasan</h3>
            </div>
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-white/20 text-white backdrop-blur-xs">
                Total: {{ $testimonials->total() }} Ulasan
            </span>
        </div>

        <!-- Table Container -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-emerald-600 text-white uppercase text-[11px] font-extrabold tracking-wider border-t border-emerald-500/50">
                        <th class="py-3.5 px-4 w-14 text-center">NO</th>
                        <th class="py-3.5 px-4 w-20 text-center">FOTO</th>
                        <th class="py-3.5 px-5 w-64 min-w-[220px]">NAMA TOKOH / WALI</th>
                        <th class="py-3.5 px-5 min-w-[340px]">ISI TESTIMONI</th>
                        <th class="py-3.5 px-4 text-center w-32">STATUS</th>
                        <th class="py-3.5 px-4 text-center w-28">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                    @forelse ($testimonials as $d)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <!-- No -->
                            <td class="py-4 px-4 text-center font-bold text-slate-400">
                                {{ $loop->iteration + $testimonials->firstItem() - 1 }}
                            </td>

                            <!-- Foto -->
                            <td class="py-4 px-4 text-center">
                                <div class="flex justify-center">
                                    @if ($d->foto && Storage::disk('public')->exists('testimonials/' . $d->foto))
                                        <div class="w-11 h-11 rounded-full bg-white border border-slate-200/80 p-0.5 shadow-2xs overflow-hidden">
                                            <img src="{{ asset('storage/testimonials/' . $d->foto) }}" 
                                                 alt="{{ $d->nama }}" 
                                                 class="w-full h-full object-cover rounded-full">
                                        </div>
                                    @else
                                        <div class="w-11 h-11 rounded-full bg-emerald-100/70 border border-emerald-200/70 text-emerald-700 flex items-center justify-center font-bold text-sm">
                                            {{ strtoupper(substr($d->nama, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                            </td>

                            <!-- Nama & Info -->
                            <td class="py-4 px-5">
                                <span class="font-bold text-slate-800 text-sm block leading-snug">
                                    {{ $d->nama }}
                                </span>
                                <span class="text-[11px] text-slate-400 mt-0.5 block">
                                    {{ $d->created_at ? $d->created_at->format('d M Y') : '-' }}
                                </span>
                            </td>

                            <!-- Isi Testimoni -->
                            <td class="py-4 px-5">
                                <div class="p-3.5 bg-slate-50/80 rounded-xl border border-slate-100 text-slate-600 leading-relaxed font-medium relative">
                                    <i class="ti ti-quote text-slate-300 text-base absolute top-2 right-2"></i>
                                    "{{ Str::limit($d->testimoni, 180) }}"
                                </div>
                            </td>

                            <!-- Status -->
                            <td class="py-4 px-4 text-center">
                                @if ($d->status)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/80">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                        <span>Aktif</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-slate-100 text-slate-500 border border-slate-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                        <span>Nonaktif</span>
                                    </span>
                                @endif
                            </td>

                            <!-- Aksi -->
                            <td class="py-4 px-4 text-center">
                                <div class="inline-flex items-center justify-center gap-1.5">
                                    <a href="{{ route('testimonials.show', $d->id) }}" 
                                       class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 flex items-center justify-center transition-colors border border-slate-200/80" 
                                       title="Lihat Detail Testimoni">
                                        <i class="ti ti-eye text-base"></i>
                                    </a>

                                    @can('testimonials.edit')
                                        <a href="{{ route('testimonials.edit', $d->id) }}" 
                                           class="w-8 h-8 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 flex items-center justify-center transition-colors border border-emerald-200/60" 
                                           title="Edit Testimoni">
                                            <i class="ti ti-edit text-base"></i>
                                        </a>
                                    @endcan

                                    @can('testimonials.delete')
                                        <form method="POST" name="deleteform" class="deleteform inline-block"
                                              action="{{ route('testimonials.destroy', $d->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" 
                                                    class="w-8 h-8 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 flex items-center justify-center transition-colors border border-rose-200/60 delete-confirm cursor-pointer"
                                                    title="Hapus Testimoni">
                                                <i class="ti ti-trash text-base"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center">
                                <div class="flex flex-col items-center justify-center gap-3">
                                    <div class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center">
                                        <i class="ti ti-message-off text-3xl"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-700 text-sm">Belum Ada Data Testimoni</p>
                                        <p class="text-xs text-slate-400 mt-0.5">Silahkan klik tombol Tambah Testimoni Baru untuk membuat ulasan pertama.</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Footer -->
        @if ($testimonials->hasPages())
            <div class="px-5 py-3.5 border-t border-slate-100 bg-slate-50/50">
                {{ $testimonials->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

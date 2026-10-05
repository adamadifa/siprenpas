@extends('layouts.app')
@section('titlepage', 'Sebaran Alumni Perguruan Tinggi')

@section('content')
<div class="space-y-5">

    <!-- ================= 1. PAGE HEADER (NO CARD) WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center border border-emerald-200/80 shadow-2xs">
                    <i class="ti ti-school text-2xl"></i>
                </div>
                <span>Sebaran Alumni</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Kelola daftar universitas dan perguruan tinggi tempat santri/alumni melanjutkan studi
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
                <span class="font-bold text-slate-800">Sebaran Alumni</span>
            </nav>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center gap-2">
                @can('sebaran-alumni.create')
                    <a href="{{ route('sebaran-alumni.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs transition-all duration-200 active:scale-95 cursor-pointer">
                        <i class="ti ti-plus text-base"></i>
                        <span>Tambah Universitas Baru</span>
                    </a>
                @endcan
            </div>
        </div>
    </div>

    <!-- ================= 2. FILTER & SEARCH TOOLBAR ================= -->
    <form action="{{ route('sebaran-alumni.index') }}" method="GET" class="w-full">
        <div class="flex flex-col sm:flex-row items-center gap-2.5 sm:gap-3 w-full">
            <!-- Search Input -->
            <div class="flex-1 min-w-0 w-full relative">
                <i class="ti ti-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-lg pointer-events-none"></i>
                <input type="text" 
                       name="nama_universitas" 
                       value="{{ Request('nama_universitas') }}" 
                       placeholder="Cari nama universitas / perguruan tinggi..." 
                       class="w-full pl-11 pr-4 py-2.5 sm:py-3 text-sm bg-white border border-slate-300/90 rounded-xl text-slate-800 font-medium placeholder-slate-400 shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2 shrink-0 w-full sm:w-auto">
                <button type="submit" class="w-full sm:w-auto px-5 py-2.5 sm:py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl shadow-xs transition inline-flex items-center justify-center gap-2 cursor-pointer active:scale-95 whitespace-nowrap">
                    <i class="ti ti-search text-base"></i>
                    <span>Cari</span>
                </button>
                @if(request()->filled('nama_universitas'))
                    <a href="{{ route('sebaran-alumni.index') }}" class="py-2.5 sm:py-3 px-3.5 bg-white hover:bg-slate-100 text-slate-600 border border-slate-300/90 rounded-xl font-semibold text-sm transition inline-flex items-center justify-center shrink-0 shadow-xs" title="Reset Filter">
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
                <i class="ti ti-building-community text-xl"></i>
                <h3 class="font-bold text-sm tracking-wide text-white">Daftar Sebaran Perguruan Tinggi Alumni</h3>
            </div>
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-white/20 text-white backdrop-blur-xs">
                Total: {{ $items->total() }} Kampus
            </span>
        </div>

        <!-- Table Container -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-emerald-600 text-white uppercase text-[11px] font-extrabold tracking-wider border-t border-emerald-500/50">
                        <th class="py-3.5 px-4 w-14 text-center">NO</th>
                        <th class="py-3.5 px-4 text-center w-28">LOGO</th>
                        <th class="py-3.5 px-5 min-w-[320px]">NAMA UNIVERSITAS / INSTITUSI</th>
                        <th class="py-3.5 px-4 text-center w-28">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                    @forelse ($items as $d)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <!-- No -->
                            <td class="py-4 px-4 text-center font-bold text-slate-400">
                                {{ $loop->iteration + $items->firstItem() - 1 }}
                            </td>

                            <!-- Logo -->
                            <td class="py-4 px-4 text-center">
                                <div class="flex justify-center">
                                    @if ($d->logo && Storage::disk('public')->exists($d->logo))
                                        <div class="w-12 h-12 rounded-xl bg-white border border-slate-200/80 p-1.5 shadow-2xs flex items-center justify-center">
                                            <img src="{{ asset('storage/' . $d->logo) }}" 
                                                 alt="{{ $d->nama_universitas }}" 
                                                 class="max-w-full max-h-full object-contain">
                                        </div>
                                    @else
                                        <div class="w-12 h-12 rounded-xl bg-slate-100 border border-slate-200/80 text-slate-400 flex items-center justify-center">
                                            <i class="ti ti-building-community text-xl"></i>
                                        </div>
                                    @endif
                                </div>
                            </td>

                            <!-- Nama Universitas -->
                            <td class="py-4 px-5">
                                <div class="flex flex-col">
                                    <span class="font-bold text-slate-800 text-sm leading-snug">
                                        {{ $d->nama_universitas }}
                                    </span>
                                    <span class="text-[11px] text-slate-400 mt-0.5">
                                        Diperbarui: {{ $d->updated_at ? $d->updated_at->format('d M Y') : '-' }}
                                    </span>
                                </div>
                            </td>

                            <!-- Aksi -->
                            <td class="py-4 px-4 text-center">
                                <div class="inline-flex items-center justify-center gap-1.5">
                                    @can('sebaran-alumni.edit')
                                        <a href="{{ route('sebaran-alumni.edit', $d->id) }}" 
                                           class="w-8 h-8 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 flex items-center justify-center transition-colors border border-emerald-200/60" 
                                           title="Edit Universitas">
                                            <i class="ti ti-edit text-base"></i>
                                        </a>
                                    @endcan

                                    @can('sebaran-alumni.delete')
                                        <form method="POST" name="deleteform" class="deleteform inline-block"
                                              action="{{ route('sebaran-alumni.destroy', $d->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" 
                                                    class="w-8 h-8 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 flex items-center justify-center transition-colors border border-rose-200/60 delete-confirm cursor-pointer"
                                                    title="Hapus Universitas">
                                                <i class="ti ti-trash text-base"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center">
                                <div class="flex flex-col items-center justify-center gap-3">
                                    <div class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center">
                                        <i class="ti ti-school-off text-3xl"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-700 text-sm">Belum Ada Data Sebaran Alumni</p>
                                        <p class="text-xs text-slate-400 mt-0.5">Silahkan klik tombol Tambah Universitas Baru untuk menambahkan data kampus.</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Footer -->
        @if ($items->hasPages())
            <div class="px-5 py-3.5 border-t border-slate-100 bg-slate-50/50">
                {{ $items->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

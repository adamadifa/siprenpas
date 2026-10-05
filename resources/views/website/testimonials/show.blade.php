@extends('layouts.app')
@section('titlepage', 'Detail Testimoni')

@section('content')
<div class="max-w-3xl mx-auto space-y-5">

    <!-- ================= 1. PAGE HEADER (NO CARD) WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center border border-emerald-200/80 shadow-2xs">
                    <i class="ti ti-eye text-2xl"></i>
                </div>
                <span>Detail Testimoni</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Informasi lengkap ulasan dan data profil pemberi testimoni
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
                <a href="{{ route('testimonials.index') }}" class="hover:text-slate-700 transition">
                    <span>Testimoni</span>
                </a>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Detail</span>
            </nav>

            <!-- Back Button -->
            <a href="{{ route('testimonials.index') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs transition cursor-pointer">
                <i class="ti ti-arrow-left text-sm"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <!-- ================= 2. DETAIL CARD ================= -->
    <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
        <!-- Solid Emerald Header -->
        <div class="bg-emerald-600 px-5 py-4 flex items-center justify-between text-white">
            <div class="flex items-center gap-2.5">
                <i class="ti ti-user-check text-xl"></i>
                <h3 class="font-bold text-sm tracking-wide text-white">Profil & Kutipan Testimoni</h3>
            </div>
            @if ($testimonial->status)
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-white/20 text-white backdrop-blur-xs">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-300"></span> Status: Aktif
                </span>
            @else
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-white/20 text-white backdrop-blur-xs">
                    <span class="w-1.5 h-1.5 rounded-full bg-rose-300"></span> Status: Nonaktif
                </span>
            @endif
        </div>

        <div class="p-6 sm:p-8 space-y-6">
            <!-- Header Profil User -->
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5 pb-6 border-b border-slate-100">
                <div class="w-20 h-20 rounded-full bg-white border-2 border-emerald-500/30 p-1 shadow-xs shrink-0 overflow-hidden">
                    @if ($testimonial->foto && Storage::disk('public')->exists('testimonials/' . $testimonial->foto))
                        <img src="{{ asset('storage/testimonials/' . $testimonial->foto) }}" alt="{{ $testimonial->nama }}" class="w-full h-full object-cover rounded-full">
                    @else
                        <div class="w-full h-full rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-xl">
                            {{ strtoupper(substr($testimonial->nama, 0, 1)) }}
                        </div>
                    @endif
                </div>

                <div class="text-center sm:text-left space-y-1">
                    <h2 class="text-lg font-black text-slate-800">{{ $testimonial->nama }}</h2>
                    <p class="text-xs text-slate-400 flex items-center justify-center sm:justify-start gap-3">
                        <span><i class="ti ti-calendar me-1"></i> Ditambahkan: {{ $testimonial->created_at->format('d F Y, H:i') }}</span>
                        <span>•</span>
                        <span><i class="ti ti-refresh me-1"></i> Diperbarui: {{ $testimonial->updated_at->format('d F Y, H:i') }}</span>
                    </p>
                </div>
            </div>

            <!-- Kutipan Ulasan -->
            <div class="space-y-2">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Kutipan Testimoni</label>
                <div class="p-5 bg-slate-50/80 rounded-2xl border border-slate-200/80 text-slate-700 leading-relaxed font-medium text-sm relative">
                    <i class="ti ti-quote text-3xl text-emerald-200 absolute top-4 right-4"></i>
                    "{{ $testimonial->testimoni }}"
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="pt-4 flex items-center justify-end gap-2.5">
                @can('testimonials.edit')
                    <a href="{{ route('testimonials.edit', $testimonial->id) }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs transition-all active:scale-95">
                        <i class="ti ti-edit text-base"></i>
                        <span>Edit Testimoni</span>
                    </a>
                @endcan
                <a href="{{ route('testimonials.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs transition">
                    Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

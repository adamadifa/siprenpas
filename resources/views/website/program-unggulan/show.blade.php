@extends('layouts.app')
@section('titlepage', 'Detail Program Unggulan')

@section('content')
<div class="space-y-5 w-full">

    <!-- ================= 1. PAGE HEADER (FULL WIDTH) WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1 w-full">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center border border-emerald-200/80 shadow-2xs">
                    <i class="ti ti-star text-2xl"></i>
                </div>
                <span>Detail Program Unggulan</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Informasi lengkap detail program unggulan pesantren
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
                <a href="{{ route('program-unggulan.index') }}" class="hover:text-slate-700 transition">
                    <span>Program Unggulan</span>
                </a>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Detail</span>
            </nav>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2">
                <a href="{{ route('program-unggulan.index') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs transition cursor-pointer">
                    <i class="ti ti-arrow-left text-sm"></i>
                    <span>Kembali</span>
                </a>
                @can('programunggulan.edit')
                    <a href="{{ route('program-unggulan.edit', $programUnggulan->id) }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs transition cursor-pointer">
                        <i class="ti ti-edit text-sm"></i>
                        <span>Edit Program</span>
                    </a>
                @endcan
            </div>
        </div>
    </div>

    <!-- ================= 2. DETAIL CARD (LEFT-ALIGNED WITH COMPACT MAX-WIDTH) ================= -->
    <div class="max-w-3xl">
        <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
            <!-- Solid Emerald Header -->
            <div class="bg-emerald-600 px-5 py-4 flex items-center justify-between text-white">
                <div class="flex items-center gap-2.5">
                    <i class="ti ti-file-description text-xl"></i>
                    <h3 class="font-bold text-sm tracking-wide text-white">Data Program: {{ $programUnggulan->nama_program }}</h3>
                </div>
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-white/20 text-white backdrop-blur-xs">
                    Urutan #{{ $programUnggulan->urutan }}
                </span>
            </div>

            <div class="p-5 sm:p-7 space-y-5">
                <!-- Nama Program Highlight -->
                <div class="p-4 bg-emerald-50/70 border border-emerald-200/70 rounded-2xl flex items-start gap-3.5">
                    <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center shrink-0 shadow-2xs">
                        <i class="ti ti-star-filled text-xl"></i>
                    </div>
                    <div>
                        <span class="text-[11px] font-bold text-emerald-800 uppercase tracking-wider">Nama Program Unggulan</span>
                        <h3 class="text-base sm:text-lg font-black text-slate-900 mt-0.5 leading-snug">{{ $programUnggulan->nama_program }}</h3>
                    </div>
                </div>

                <!-- Detail Items Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="p-4 bg-slate-50 border border-slate-200/80 rounded-xl space-y-1">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Urutan Tampil</span>
                        <div class="text-sm font-bold text-slate-800 flex items-center gap-2">
                            <span class="w-6 h-6 rounded-md bg-emerald-100 text-emerald-800 flex items-center justify-center text-xs font-black">
                                {{ $programUnggulan->urutan }}
                            </span>
                            <span>Prioritas ke-{{ $programUnggulan->urutan }}</span>
                        </div>
                    </div>

                    <div class="p-4 bg-slate-50 border border-slate-200/80 rounded-xl space-y-1">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Waktu Dibuat & Pembaruan</span>
                        <div class="text-xs font-bold text-slate-700 space-y-0.5">
                            <div class="flex items-center gap-1.5 text-slate-600">
                                <i class="ti ti-calendar-plus text-slate-400"></i>
                                <span>Dibuat: {{ $programUnggulan->created_at ? $programUnggulan->created_at->translatedFormat('d F Y H:i') : '-' }}</span>
                            </div>
                            <div class="flex items-center gap-1.5 text-slate-500 font-medium">
                                <i class="ti ti-history text-slate-400"></i>
                                <span>Update: {{ $programUnggulan->updated_at ? $programUnggulan->updated_at->translatedFormat('d F Y H:i') : '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Deskripsi Content -->
                <div class="p-4 bg-slate-50 border border-slate-200/80 rounded-xl space-y-2">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Deskripsi & Penjelasan Program</span>
                    <div class="text-xs sm:text-sm text-slate-700 leading-relaxed whitespace-pre-line">
                        @if ($programUnggulan->deskripsi)
                            {{ $programUnggulan->deskripsi }}
                        @else
                            <span class="italic text-slate-400">Tidak ada deskripsi yang dicantumkan.</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

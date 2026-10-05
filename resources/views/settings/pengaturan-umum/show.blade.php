@extends('layouts.app')
@section('titlepage', 'Detail Pengaturan Umum')

@section('content')
<div class="space-y-6 pb-20">

    <!-- ================= 1. PAGE HEADER WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center border border-emerald-200/80 shadow-2xs">
                    <i class="ti ti-settings text-2xl"></i>
                </div>
                <span>Detail Konfigurasi Sistem</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Informasi lengkap identitas lembaga, branding visual, dan metadata konfigurasi aplikasi
            </p>
        </div>

        <!-- Right Side: Breadcrumb Navigation & Action -->
        <div class="flex flex-col md:items-end gap-2.5">
            <nav class="flex items-center text-xs text-slate-400 font-medium">
                <a href="{{ route('dashboard.index') }}" class="hover:text-slate-700 transition flex items-center gap-1">
                    <i class="ti ti-home text-sm"></i>
                    <span>Dashboard</span>
                </a>
                <span class="mx-2 text-slate-300">/</span>
                <a href="{{ route('pengaturan-umum.index') }}" class="hover:text-slate-700 transition">
                    Pengaturan Umum
                </a>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Detail</span>
            </nav>

            <div class="flex items-center gap-2">
                <a href="{{ route('pengaturan-umum.index') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2.5 bg-white hover:bg-slate-50 text-slate-700 font-bold rounded-xl text-xs border border-slate-200 shadow-2xs transition active:scale-95">
                    <i class="ti ti-arrow-left text-sm"></i>
                    <span>Kembali</span>
                </a>
                <a href="{{ route('pengaturan-umum.edit', $pengaturan->id) }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs transition-all duration-200 active:scale-95 cursor-pointer border-0">
                    <i class="ti ti-edit text-base"></i>
                    <span>Edit Konfigurasi</span>
                </a>
            </div>
        </div>
    </div>

    <!-- ================= 2. CARD CONTENT ================= -->
    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div class="bg-emerald-600 px-6 py-4 flex items-center justify-between text-white">
            <div class="flex items-center gap-2.5">
                <i class="ti ti-file-certificate text-xl"></i>
                <h2 class="text-base font-extrabold tracking-tight text-white">
                    Data Konfigurasi {{ $pengaturan->nama_sekolah }}
                </h2>
            </div>
            <span class="px-3 py-1 rounded-full text-xs font-bold bg-white/20 text-white border border-white/20">
                ID: #{{ $pengaturan->id }}
            </span>
        </div>

        <div class="p-6 sm:p-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Logo Showcase Frame -->
                <div class="flex flex-col items-center justify-center p-6 bg-slate-50/70 rounded-2xl border border-slate-200/80 text-center">
                    <div class="w-40 h-40 rounded-2xl bg-white p-3 border border-slate-200 shadow-sm flex items-center justify-center mb-3">
                        @if ($pengaturan->logo && Storage::disk('public')->exists($pengaturan->logo))
                            <img src="{{ asset('storage/' . $pengaturan->logo) }}" alt="Logo" class="max-w-full max-h-full object-contain">
                        @else
                            <div class="text-slate-400">
                                <i class="ti ti-photo text-4xl mb-1 block"></i>
                                <span class="text-xs font-bold">Tidak ada logo</span>
                            </div>
                        @endif
                    </div>
                    <span class="text-xs font-extrabold text-slate-800">Logo Resmi Lembaga</span>
                    <span class="text-[11px] text-slate-400 mt-0.5">Digunakan pada header & cetak dokumen</span>
                </div>

                <!-- Detailed Specs -->
                <div class="md:col-span-2 space-y-4 text-xs divide-y divide-slate-100">
                    <div class="py-2.5 first:pt-0 grid grid-cols-1 sm:grid-cols-3 gap-1">
                        <span class="font-bold text-slate-500 flex items-center gap-1.5"><i class="ti ti-building text-emerald-600"></i> Nama Lembaga:</span>
                        <span class="sm:col-span-2 font-black text-slate-900 text-sm">{{ $pengaturan->nama_sekolah }}</span>
                    </div>
                    <div class="py-2.5 grid grid-cols-1 sm:grid-cols-3 gap-1">
                        <span class="font-bold text-slate-500 flex items-center gap-1.5"><i class="ti ti-device-laptop text-emerald-600"></i> Nama Aplikasi:</span>
                        <span class="sm:col-span-2 font-bold text-slate-800">{{ $pengaturan->nama_aplikasi ?? '-' }}</span>
                    </div>
                    <div class="py-2.5 grid grid-cols-1 sm:grid-cols-3 gap-1">
                        <span class="font-bold text-slate-500 flex items-center gap-1.5"><i class="ti ti-map-pin text-emerald-600"></i> Alamat Lengkap:</span>
                        <span class="sm:col-span-2 font-semibold text-slate-700 leading-relaxed">{{ $pengaturan->alamat_sekolah }}</span>
                    </div>
                    <div class="py-2.5 grid grid-cols-1 sm:grid-cols-3 gap-1">
                        <span class="font-bold text-slate-500 flex items-center gap-1.5"><i class="ti ti-phone text-emerald-600"></i> Telepon:</span>
                        <span class="sm:col-span-2 font-bold text-slate-800">{{ $pengaturan->telepon ?: '-' }}</span>
                    </div>
                    <div class="py-2.5 grid grid-cols-1 sm:grid-cols-3 gap-1">
                        <span class="font-bold text-slate-500 flex items-center gap-1.5"><i class="ti ti-mail text-emerald-600"></i> Email:</span>
                        <span class="sm:col-span-2 font-bold text-slate-800">{{ $pengaturan->email ?: '-' }}</span>
                    </div>
                    <div class="py-2.5 grid grid-cols-1 sm:grid-cols-3 gap-1">
                        <span class="font-bold text-slate-500 flex items-center gap-1.5"><i class="ti ti-world text-emerald-600"></i> Website:</span>
                        <span class="sm:col-span-2 font-bold text-emerald-700">
                            @if ($pengaturan->website)
                                <a href="{{ $pengaturan->website }}" target="_blank" class="hover:underline">{{ $pengaturan->website }}</a>
                            @else
                                -
                            @endif
                        </span>
                    </div>
                    <div class="py-2.5 grid grid-cols-1 sm:grid-cols-3 gap-1">
                        <span class="font-bold text-slate-500 flex items-center gap-1.5"><i class="ti ti-clock text-emerald-600"></i> Session Timeout:</span>
                        <span class="sm:col-span-2">
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-lg text-xs font-bold bg-amber-50 text-amber-800 border border-amber-200">
                                {{ $pengaturan->session_lifetime ?? 120 }} Menit
                            </span>
                        </span>
                    </div>
                    <div class="py-2.5 grid grid-cols-1 sm:grid-cols-3 gap-1">
                        <span class="font-bold text-slate-500 flex items-center gap-1.5"><i class="ti ti-calendar text-emerald-600"></i> Waktu Pembuatan:</span>
                        <span class="sm:col-span-2 text-slate-600">{{ $pengaturan->created_at ? $pengaturan->created_at->format('d F Y, H:i') : '-' }} WIB</span>
                    </div>
                    <div class="py-2.5 last:pb-0 grid grid-cols-1 sm:grid-cols-3 gap-1">
                        <span class="font-bold text-slate-500 flex items-center gap-1.5"><i class="ti ti-refresh text-emerald-600"></i> Terakhir Diperbarui:</span>
                        <span class="sm:col-span-2 text-slate-600">{{ $pengaturan->updated_at ? $pengaturan->updated_at->format('d F Y, H:i') : '-' }} WIB</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

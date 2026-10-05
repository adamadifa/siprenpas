@extends('layouts.app')
@section('titlepage', 'Detail Prestasi Siswa')

@section('content')
<div class="max-w-4xl mx-auto space-y-5">

    <!-- ================= 1. PAGE HEADER (NO CARD) WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center border border-emerald-200/80 shadow-2xs">
                    <i class="ti ti-eye text-2xl"></i>
                </div>
                <span>Detail Prestasi Santri</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Informasi komprehensif rekam jejak capaian penghargaan dan sertifikat santri
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
                <a href="{{ route('prestasisiswa.index') }}" class="hover:text-slate-700 transition">
                    <span>Prestasi Santri</span>
                </a>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Detail</span>
            </nav>

            <!-- Back Button -->
            <a href="{{ route('prestasisiswa.index') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs transition cursor-pointer">
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
                <i class="ti ti-award text-xl"></i>
                <h3 class="font-bold text-sm tracking-wide text-white">Profil & Bukti Capaian Prestasi</h3>
            </div>
            @if ($prestasiSiswa->status)
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-white/20 text-white backdrop-blur-xs">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-300"></span> Status: Publikasi Aktif
                </span>
            @else
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-white/20 text-white backdrop-blur-xs">
                    <span class="w-1.5 h-1.5 rounded-full bg-rose-300"></span> Status: Nonaktif (Draft)
                </span>
            @endif
        </div>

        <div class="p-6 sm:p-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start pb-6 border-b border-slate-100">
                <!-- Foto Piagam / Dokumentasi -->
                <div class="text-center space-y-2">
                    <div class="w-full aspect-4/3 rounded-2xl bg-slate-50 border border-slate-200/80 p-2 shadow-2xs flex items-center justify-center overflow-hidden">
                        @if ($prestasiSiswa->foto && Storage::disk('public')->exists('prestasi-siswa/' . $prestasiSiswa->foto))
                            <img src="{{ asset('storage/prestasi-siswa/' . $prestasiSiswa->foto) }}" 
                                 alt="Foto {{ $prestasiSiswa->nama_siswa }}" 
                                 class="max-w-full max-h-full object-contain rounded-xl">
                        @else
                            <div class="flex flex-col items-center justify-center text-slate-400 py-8">
                                <i class="ti ti-photo-off text-3xl"></i>
                                <span class="text-xs font-medium mt-1">Tidak ada lampiran foto</span>
                            </div>
                        @endif
                    </div>
                    @if ($prestasiSiswa->foto && Storage::disk('public')->exists('prestasi-siswa/' . $prestasiSiswa->foto))
                        <a href="{{ asset('storage/prestasi-siswa/' . $prestasiSiswa->foto) }}" target="_blank" class="inline-flex items-center gap-1 text-xs font-bold text-emerald-700 hover:text-emerald-800">
                            <i class="ti ti-external-link"></i> Buka Foto Ukuran Penuh
                        </a>
                    @endif
                </div>

                <!-- Info Identitas Santri -->
                <div class="md:col-span-2 space-y-4">
                    <div>
                        <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">Nama Santri / Siswa</span>
                        <h2 class="text-xl font-black text-slate-800 mt-0.5">{{ $prestasiSiswa->nama_siswa }}</h2>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Unit Jenjang</span>
                            <span class="font-bold text-slate-800 text-xs mt-1 block">
                                {{ $prestasiSiswa->unit ? $prestasiSiswa->unit->nama_unit : '-' }}
                            </span>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Tingkat Kejuaraan</span>
                            <div class="mt-1">
                                @if ($prestasiSiswa->tingkat == 'nasional')
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-extrabold uppercase bg-rose-50 text-rose-700 border border-rose-200">
                                        <i class="ti ti-award text-xs"></i> Nasional
                                    </span>
                                @elseif ($prestasiSiswa->tingkat == 'kabupaten')
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-extrabold uppercase bg-amber-50 text-amber-700 border border-amber-200">
                                        <i class="ti ti-award text-xs"></i> Kabupaten
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-extrabold uppercase bg-blue-50 text-blue-700 border border-blue-200">
                                        <i class="ti ti-award text-xs"></i> Kecamatan
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if($prestasiSiswa->siswa)
                        <div class="p-3 bg-emerald-50/50 rounded-xl border border-emerald-200/60 flex items-center justify-between">
                            <div class="text-xs">
                                <span class="font-bold text-emerald-950 block">Terhubung dengan Database Siswa</span>
                                <span class="text-emerald-700/80 text-[11px]">NISN: {{ $prestasiSiswa->siswa->nisn ?? '-' }}</span>
                            </div>
                            <span class="px-2 py-1 rounded-md bg-white text-emerald-800 font-mono text-[10px] font-bold border border-emerald-200">
                                ID: #{{ $prestasiSiswa->siswa->id_siswa }}
                            </span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Uraian Capaian Prestasi -->
            <div class="space-y-2">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Deskripsi Capaian Prestasi</label>
                <div class="p-5 bg-slate-50/80 rounded-2xl border border-slate-200/80 text-slate-800 leading-relaxed font-semibold text-sm">
                    {{ $prestasiSiswa->prestasi }}
                </div>
            </div>

            <!-- Metadata Timestamp -->
            <div class="flex items-center justify-between text-[11px] text-slate-400 pt-2 border-t border-slate-100">
                <span><i class="ti ti-calendar me-1"></i> Dicatat pada: {{ $prestasiSiswa->created_at->format('d F Y, H:i') }}</span>
                <span><i class="ti ti-refresh me-1"></i> Terakhir diperbarui: {{ $prestasiSiswa->updated_at->format('d F Y, H:i') }}</span>
            </div>

            <!-- Actions Footer -->
            <div class="pt-4 flex items-center justify-end gap-2.5">
                @can('prestasisiswa.edit')
                    <a href="{{ route('prestasisiswa.edit', $prestasiSiswa->id) }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs transition-all active:scale-95">
                        <i class="ti ti-edit text-base"></i>
                        <span>Edit Prestasi</span>
                    </a>
                @endcan
                <a href="{{ route('prestasisiswa.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs transition">
                    Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

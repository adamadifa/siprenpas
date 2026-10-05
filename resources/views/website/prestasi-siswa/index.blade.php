@extends('layouts.app')
@section('titlepage', 'Prestasi & Penghargaan Santri')

@section('content')
<div class="space-y-5">

    <!-- ================= 1. PAGE HEADER (NO CARD) WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center border border-emerald-200/80 shadow-2xs">
                    <i class="ti ti-trophy text-2xl"></i>
                </div>
                <span>Prestasi & Penghargaan Santri</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Kelola rekam jejak capaian prestasi akademik, keagamaan, seni, sains, dan olahraga santri pesantren
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
                <span class="font-bold text-slate-800">Prestasi Santri</span>
            </nav>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center gap-2">
                @can('prestasisiswa.create')
                    <a href="{{ route('prestasisiswa.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs transition-all duration-200 active:scale-95 cursor-pointer">
                        <i class="ti ti-plus text-base"></i>
                        <span>Tambah Prestasi Baru</span>
                    </a>
                @endcan
            </div>
        </div>
    </div>

    <!-- ================= 2. FILTER & SEARCH TOOLBAR ================= -->
    <form action="{{ route('prestasisiswa.index') }}" method="GET" class="w-full">
        <div class="flex flex-col sm:flex-row items-center gap-2.5 sm:gap-3 w-full">
            <!-- Search Input -->
            <div class="flex-1 min-w-0 w-full relative">
                <i class="ti ti-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-lg pointer-events-none"></i>
                <input type="text" 
                       name="nama_siswa" 
                       value="{{ Request('nama_siswa') }}" 
                       placeholder="Cari nama santri atau judul penghargaan..." 
                       class="w-full pl-11 pr-4 py-2.5 sm:py-3 text-sm bg-white border border-slate-300/90 rounded-xl text-slate-800 font-medium placeholder-slate-400 shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
            </div>

            <!-- Filter Unit -->
            <div class="w-full sm:w-60 shrink-0">
                <select name="kode_unit" class="w-full py-2.5 sm:py-3 px-3 text-sm bg-white border border-slate-300/90 rounded-xl text-slate-800 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition cursor-pointer">
                    <option value="">Semua Unit Jenjang</option>
                    @foreach ($unit as $u)
                        <option value="{{ $u->kode_unit }}" {{ Request('kode_unit') == $u->kode_unit ? 'selected' : '' }}>
                            {{ $u->nama_unit }}
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
                @if(request()->filled('nama_siswa') || request()->filled('kode_unit'))
                    <a href="{{ route('prestasisiswa.index') }}" class="py-2.5 sm:py-3 px-3.5 bg-white hover:bg-slate-100 text-slate-600 border border-slate-300/90 rounded-xl font-semibold text-sm transition inline-flex items-center justify-center shrink-0 shadow-xs" title="Reset Filter">
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
                <i class="ti ti-trophy text-xl"></i>
                <h3 class="font-bold text-sm tracking-wide text-white">Daftar Rekam Prestasi Santri</h3>
            </div>
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-white/20 text-white backdrop-blur-xs">
                Total: {{ $prestasiSiswa->total() }} Prestasi
            </span>
        </div>

        <!-- Table Container -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-emerald-600 text-white uppercase text-[11px] font-extrabold tracking-wider border-t border-emerald-500/50">
                        <th class="py-3.5 px-4 w-14 text-center">NO</th>
                        <th class="py-3.5 px-4 w-20 text-center">FOTO</th>
                        <th class="py-3.5 px-5 w-60 min-w-[200px]">NAMA SANTRI</th>
                        <th class="py-3.5 px-4 w-36">UNIT</th>
                        <th class="py-3.5 px-5 min-w-[320px]">CAPAIAN PRESTASI</th>
                        <th class="py-3.5 px-4 text-center w-36">TINGKAT</th>
                        <th class="py-3.5 px-4 text-center w-28">STATUS</th>
                        <th class="py-3.5 px-4 text-center w-28">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                    @forelse ($prestasiSiswa as $d)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <!-- No -->
                            <td class="py-4 px-4 text-center font-bold text-slate-400">
                                {{ $loop->iteration + $prestasiSiswa->firstItem() - 1 }}
                            </td>

                            <!-- Foto -->
                            <td class="py-4 px-4 text-center">
                                <div class="flex justify-center">
                                    @if ($d->foto && Storage::disk('public')->exists('prestasi-siswa/' . $d->foto))
                                        <div class="w-12 h-12 rounded-xl bg-white border border-slate-200/80 p-0.5 shadow-2xs overflow-hidden">
                                            <img src="{{ asset('storage/prestasi-siswa/' . $d->foto) }}" 
                                                 alt="{{ $d->nama_siswa }}" 
                                                 class="w-full h-full object-cover rounded-lg">
                                        </div>
                                    @else
                                        <div class="w-12 h-12 rounded-xl bg-emerald-50 border border-emerald-200/70 text-emerald-700 flex items-center justify-center font-bold text-sm">
                                            <i class="ti ti-medal text-lg"></i>
                                        </div>
                                    @endif
                                </div>
                            </td>

                            <!-- Nama Santri -->
                            <td class="py-4 px-5">
                                <span class="font-bold text-slate-800 text-sm block leading-snug">
                                    {{ $d->nama_siswa }}
                                </span>
                                @if($d->siswa && $d->siswa->nisn)
                                    <span class="text-[11px] text-slate-400 font-mono">NISN: {{ $d->siswa->nisn }}</span>
                                @endif
                            </td>

                            <!-- Unit -->
                            <td class="py-4 px-4">
                                @if ($d->unit)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 font-bold text-[11px] border border-emerald-200/80 whitespace-nowrap">
                                        <i class="ti ti-school text-xs"></i>
                                        {{ $d->unit->nama_unit }}
                                    </span>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>

                            <!-- Prestasi -->
                            <td class="py-4 px-5">
                                <span class="text-slate-700 font-semibold leading-relaxed block">
                                    {{ $d->prestasi }}
                                </span>
                            </td>

                            <!-- Tingkat -->
                            <td class="py-4 px-4 text-center whitespace-nowrap">
                                @if ($d->tingkat == 'nasional')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase bg-rose-50 text-rose-700 border border-rose-200">
                                        <i class="ti ti-award text-xs"></i> Nasional
                                    </span>
                                @elseif ($d->tingkat == 'kabupaten')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase bg-amber-50 text-amber-700 border border-amber-200">
                                        <i class="ti ti-award text-xs"></i> Kabupaten
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase bg-blue-50 text-blue-700 border border-blue-200">
                                        <i class="ti ti-award text-xs"></i> Kecamatan
                                    </span>
                                @endif
                            </td>

                            <!-- Status -->
                            <td class="py-4 px-4 text-center whitespace-nowrap">
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
                                    <a href="{{ route('prestasisiswa.show', $d->id) }}" 
                                       class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 flex items-center justify-center transition-colors border border-slate-200/80" 
                                       title="Lihat Detail">
                                        <i class="ti ti-eye text-base"></i>
                                    </a>

                                    @can('prestasisiswa.edit')
                                        <a href="{{ route('prestasisiswa.edit', $d->id) }}" 
                                           class="w-8 h-8 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 flex items-center justify-center transition-colors border border-emerald-200/60" 
                                           title="Edit Prestasi">
                                            <i class="ti ti-edit text-base"></i>
                                        </a>
                                    @endcan

                                    @can('prestasisiswa.delete')
                                        <form method="POST" name="deleteform" class="deleteform inline-block"
                                              action="{{ route('prestasisiswa.destroy', $d->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" 
                                                    class="w-8 h-8 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 flex items-center justify-center transition-colors border border-rose-200/60 delete-confirm cursor-pointer"
                                                    title="Hapus Prestasi">
                                                <i class="ti ti-trash text-base"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center">
                                <div class="flex flex-col items-center justify-center gap-3">
                                    <div class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center">
                                        <i class="ti ti-trophy-off text-3xl"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-700 text-sm">Belum Ada Data Prestasi Santri</p>
                                        <p class="text-xs text-slate-400 mt-0.5">Silahkan klik tombol Tambah Prestasi Baru untuk menambahkan rekam capaian.</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Footer -->
        @if ($prestasiSiswa->hasPages())
            <div class="px-5 py-3.5 border-t border-slate-100 bg-slate-50/50">
                {{ $prestasiSiswa->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

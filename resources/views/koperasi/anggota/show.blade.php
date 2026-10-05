@extends('layouts.app')
@section('titlepage', 'Detail Anggota Koperasi')

@section('content')
<div class="space-y-6">

    <!-- ================= 1. TOP HEADER & NAVIGATION ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <i class="ti ti-id-badge-2 text-emerald-600 text-2xl"></i>
                <span>Detail Anggota Koperasi</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Informasi profil lengkap, identitas kependudukan, alamat domisili, dan relasi santri/karyawan
            </p>
        </div>

        <!-- Right: Breadcrumb & Actions -->
        <div class="flex flex-col md:items-end gap-2.5">
            <!-- Breadcrumb Navigation -->
            <nav class="flex items-center text-xs text-slate-400 font-medium">
                <a href="{{ route('dashboard.index') }}" class="hover:text-slate-700 transition flex items-center gap-1">
                    <i class="ti ti-home text-sm"></i>
                    <span>Dashboard</span>
                </a>
                <span class="mx-2 text-slate-300">/</span>
                <a href="{{ route('anggota.index') }}" class="hover:text-slate-700 transition flex items-center gap-1">
                    <i class="ti ti-building-bank text-sm"></i>
                    <span>Anggota</span>
                </a>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Detail</span>
            </nav>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('anggota.index') }}" 
                   class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white hover:bg-slate-50 text-slate-700 font-bold rounded-xl text-xs border border-slate-300 shadow-2xs transition active:scale-95 cursor-pointer">
                    <i class="ti ti-arrow-left text-sm"></i>
                    <span>Kembali</span>
                </a>
                @can('anggota.edit')
                    <button type="button" 
                            class="btnEditAnggota inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs transition active:scale-95 cursor-pointer"
                            no_anggota="{{ Crypt::encrypt($anggota->no_anggota) }}">
                        <i class="ti ti-edit text-sm"></i>
                        <span>Edit Profil</span>
                    </button>
                @endcan
            </div>
        </div>
    </div>

    <!-- ================= 2. MEMBER PROFILE CARD (SOLID GREEN) ================= -->
    <div class="bg-emerald-600 border border-emerald-500 rounded-2xl shadow-xs p-5 sm:p-6 text-white">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <!-- Left: Avatar & Primary Info -->
            <div class="flex items-center gap-4 sm:gap-5">
                <!-- Avatar -->
                <div class="w-16 h-16 sm:w-18 sm:h-18 rounded-2xl bg-white text-emerald-800 flex items-center justify-center font-black text-2xl sm:text-3xl shadow-xs shrink-0 ring-4 ring-white/20">
                    {{ strtoupper(substr($anggota->nama_lengkap, 0, 1)) }}
                </div>

                <!-- Details -->
                <div class="space-y-1.5 min-w-0">
                    <div class="flex items-center gap-2.5 flex-wrap">
                        <h2 class="text-lg sm:text-xl font-black text-white uppercase tracking-tight truncate">
                            {{ $anggota->nama_lengkap }}
                        </h2>
                        <span class="px-2.5 py-0.5 rounded-lg text-xs font-bold tracking-wider bg-white/20 text-white border border-white/30 shadow-2xs backdrop-blur-xs">
                            {{ $anggota->no_anggota }}
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-white text-emerald-800 shadow-2xs">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span> Anggota Aktif
                        </span>
                    </div>

                    <div class="flex items-center gap-2 sm:gap-3 text-emerald-100 text-xs flex-wrap font-medium">
                        <span class="inline-flex items-center gap-1.5">
                            <i class="ti ti-id text-emerald-200"></i>
                            <span class="text-emerald-200">NIK:</span>
                            <strong class="text-white font-bold">{{ $anggota->nik ?: '-' }}</strong>
                        </span>
                        <span class="text-emerald-400">•</span>
                        <span class="inline-flex items-center gap-1.5">
                            <i class="ti ti-gender-bigender text-emerald-200"></i>
                            <span>{{ $anggota->jenis_kelamin == 'P' ? 'Perempuan' : ($anggota->jenis_kelamin == 'L' ? 'Laki-Laki' : '-') }}</span>
                        </span>
                        <span class="text-emerald-400">•</span>
                        <span class="inline-flex items-center gap-1.5">
                            <i class="ti ti-school text-emerald-200"></i>
                            <span>{{ $anggota->pendidikan_terakhir ?: '-' }}</span>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Right: WhatsApp Fast Contact -->
            <div class="flex items-center gap-3">
                @if ($anggota->no_hp)
                    <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $anggota->no_hp)) }}" 
                       target="_blank" 
                       class="inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-white hover:bg-emerald-50 text-emerald-800 font-bold rounded-xl text-xs sm:text-sm shadow-sm hover:shadow-md transition active:scale-95 shrink-0 cursor-pointer border border-white">
                        <i class="ti ti-brand-whatsapp text-emerald-600 text-base sm:text-lg"></i>
                        <span>WhatsApp ({{ $anggota->no_hp }})</span>
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- ================= 3. DETAILS GRID ================= -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">
        
        <!-- LEFT COLUMN: Data Pribadi & Data Keluarga -->
        <div class="space-y-6">

            <!-- Card 1: Data Pribadi -->
            <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
                <div class="px-5 py-3.5 bg-slate-50/80 border-b border-slate-200/90 flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-sm font-bold shadow-2xs">
                            <i class="ti ti-user-check"></i>
                        </div>
                        <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider">Data Pribadi</h3>
                    </div>
                    <span class="text-[11px] font-bold text-slate-400">Identitas</span>
                </div>

                <div class="divide-y divide-slate-100 text-xs">
                    <!-- No. Anggota -->
                    <div class="px-5 py-3 flex items-center justify-between gap-4 hover:bg-slate-50/50 transition">
                        <span class="text-slate-500 font-semibold flex items-center gap-2">
                            <i class="ti ti-hash text-slate-400 text-sm"></i> No. Anggota
                        </span>
                        <span class="font-bold text-emerald-800 bg-emerald-50 px-2.5 py-0.5 rounded-md border border-emerald-200">
                            {{ $anggota->no_anggota }}
                        </span>
                    </div>

                    <!-- NIK -->
                    <div class="px-5 py-3 flex items-center justify-between gap-4 hover:bg-slate-50/50 transition">
                        <span class="text-slate-500 font-semibold flex items-center gap-2">
                            <i class="ti ti-id text-slate-400 text-sm"></i> NIK (Nomor Induk Kependudukan)
                        </span>
                        <span class="font-bold text-slate-800">
                            {{ $anggota->nik ?: '-' }}
                        </span>
                    </div>

                    <!-- Nama Lengkap -->
                    <div class="px-5 py-3 flex items-center justify-between gap-4 hover:bg-slate-50/50 transition">
                        <span class="text-slate-500 font-semibold flex items-center gap-2">
                            <i class="ti ti-user text-slate-400 text-sm"></i> Nama Lengkap
                        </span>
                        <span class="font-bold text-slate-900 uppercase">
                            {{ $anggota->nama_lengkap }}
                        </span>
                    </div>

                    <!-- Tempat, Tanggal Lahir -->
                    <div class="px-5 py-3 flex items-center justify-between gap-4 hover:bg-slate-50/50 transition">
                        <span class="text-slate-500 font-semibold flex items-center gap-2">
                            <i class="ti ti-calendar text-slate-400 text-sm"></i> Tempat, Tanggal Lahir
                        </span>
                        <span class="font-semibold text-slate-800 text-right">
                            @if ($anggota->tempat_lahir || $anggota->tanggal_lahir)
                                {{ $anggota->tempat_lahir ?: '-' }}, {{ $anggota->tanggal_lahir ? DateToIndo($anggota->tanggal_lahir) : '-' }}
                            @else
                                -
                            @endif
                        </span>
                    </div>

                    <!-- Jenis Kelamin -->
                    <div class="px-5 py-3 flex items-center justify-between gap-4 hover:bg-slate-50/50 transition">
                        <span class="text-slate-500 font-semibold flex items-center gap-2">
                            <i class="ti ti-gender-bigender text-slate-400 text-sm"></i> Jenis Kelamin
                        </span>
                        <span>
                            @if ($anggota->jenis_kelamin == 'L')
                                <span class="px-2.5 py-0.5 rounded-md text-[11px] font-bold bg-sky-50 text-sky-700 border border-sky-200">
                                    Laki-Laki
                                </span>
                            @elseif ($anggota->jenis_kelamin == 'P')
                                <span class="px-2.5 py-0.5 rounded-md text-[11px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                    Perempuan
                                </span>
                            @else
                                <span class="text-slate-400">-</span>
                            @endif
                        </span>
                    </div>

                    <!-- Pendidikan Terakhir -->
                    <div class="px-5 py-3 flex items-center justify-between gap-4 hover:bg-slate-50/50 transition">
                        <span class="text-slate-500 font-semibold flex items-center gap-2">
                            <i class="ti ti-school text-slate-400 text-sm"></i> Pendidikan Terakhir
                        </span>
                        <span class="font-bold text-slate-800">
                            {{ $anggota->pendidikan_terakhir ?: '-' }}
                        </span>
                    </div>

                    <!-- Status Pernikahan -->
                    <div class="px-5 py-3 flex items-center justify-between gap-4 hover:bg-slate-50/50 transition">
                        <span class="text-slate-500 font-semibold flex items-center gap-2">
                            <i class="ti ti-heart text-slate-400 text-sm"></i> Status Pernikahan
                        </span>
                        <span>
                            @if($anggota->status_pernikahan == 'M')
                                <span class="px-2.5 py-0.5 rounded-md text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    Menikah
                                </span>
                            @elseif($anggota->status_pernikahan == 'BM')
                                <span class="px-2.5 py-0.5 rounded-md text-[11px] font-bold bg-sky-50 text-sky-700 border border-sky-200">
                                    Belum Menikah
                                </span>
                            @elseif($anggota->status_pernikahan == 'JD')
                                <span class="px-2.5 py-0.5 rounded-md text-[11px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                    Janda / Duda
                                </span>
                            @else
                                <span class="text-slate-400">-</span>
                            @endif
                        </span>
                    </div>

                    <!-- Nomor WhatsApp / HP -->
                    <div class="px-5 py-3 flex items-center justify-between gap-4 hover:bg-slate-50/50 transition">
                        <span class="text-slate-500 font-semibold flex items-center gap-2">
                            <i class="ti ti-phone text-slate-400 text-sm"></i> No. HP / WhatsApp
                        </span>
                        <span class="font-bold text-emerald-700">
                            {{ $anggota->no_hp ?: '-' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Card 2: Data Keluarga & Kerabat -->
            <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
                <div class="px-5 py-3.5 bg-slate-50/80 border-b border-slate-200/90 flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-sm font-bold shadow-2xs">
                            <i class="ti ti-users-group"></i>
                        </div>
                        <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider">Data Keluarga & Kerabat</h3>
                    </div>
                    <span class="text-[11px] font-bold text-slate-400">Keluarga</span>
                </div>

                <div class="divide-y divide-slate-100 text-xs">
                    <!-- Nama Pasangan -->
                    <div class="px-5 py-3 flex items-center justify-between gap-4 hover:bg-slate-50/50 transition">
                        <span class="text-slate-500 font-semibold flex items-center gap-2">
                            <i class="ti ti-heart-handshake text-slate-400 text-sm"></i> Nama Pasangan
                        </span>
                        <span class="font-bold text-slate-900 uppercase">
                            {{ $anggota->nama_pasangan ?: '-' }}
                        </span>
                    </div>

                    <!-- Pekerjaan Pasangan -->
                    <div class="px-5 py-3 flex items-center justify-between gap-4 hover:bg-slate-50/50 transition">
                        <span class="text-slate-500 font-semibold flex items-center gap-2">
                            <i class="ti ti-briefcase text-slate-400 text-sm"></i> Pekerjaan Pasangan
                        </span>
                        <span class="font-semibold text-slate-800">
                            {{ $anggota->pekerjaan_pasangan ?: '-' }}
                        </span>
                    </div>

                    <!-- Nama Ibu Kandung -->
                    <div class="px-5 py-3 flex items-center justify-between gap-4 hover:bg-slate-50/50 transition">
                        <span class="text-slate-500 font-semibold flex items-center gap-2">
                            <i class="ti ti-woman text-slate-400 text-sm"></i> Nama Ibu Kandung
                        </span>
                        <span class="font-bold text-slate-900 uppercase">
                            {{ $anggota->nama_ibu ?: '-' }}
                        </span>
                    </div>

                    <!-- Nama Saudara -->
                    <div class="px-5 py-3 flex items-center justify-between gap-4 hover:bg-slate-50/50 transition">
                        <span class="text-slate-500 font-semibold flex items-center gap-2">
                            <i class="ti ti-user-plus text-slate-400 text-sm"></i> Nama Saudara
                        </span>
                        <span class="font-bold text-slate-900 uppercase">
                            {{ $anggota->nama_saudara ?: '-' }}
                        </span>
                    </div>

                    <!-- Jumlah Tanggungan -->
                    <div class="px-5 py-3 flex items-center justify-between gap-4 hover:bg-slate-50/50 transition">
                        <span class="text-slate-500 font-semibold flex items-center gap-2">
                            <i class="ti ti-users text-slate-400 text-sm"></i> Jumlah Tanggungan
                        </span>
                        <span class="font-bold text-slate-900">
                            {{ $anggota->jml_tanggungan ? $anggota->jml_tanggungan . ' Jiwa' : '0 Jiwa' }}
                        </span>
                    </div>
                </div>
            </div>

        </div>

        <!-- RIGHT COLUMN: Alamat & Relasi Terhubung -->
        <div class="space-y-6">

            <!-- Card 3: Alamat & Domisili (STYLE SAMAIN DENGAN CARD LAIN) -->
            <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
                <div class="px-5 py-3.5 bg-slate-50/80 border-b border-slate-200/90 flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-sm font-bold shadow-2xs">
                            <i class="ti ti-map-pin"></i>
                        </div>
                        <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider">Alamat & Tempat Tinggal</h3>
                    </div>
                    <span class="text-[11px] font-bold text-slate-400">Domisili</span>
                </div>

                <div class="divide-y divide-slate-100 text-xs">
                    <!-- Alamat Lengkap -->
                    <div class="px-5 py-3 flex items-start justify-between gap-4 hover:bg-slate-50/50 transition">
                        <span class="text-slate-500 font-semibold flex items-center gap-2 shrink-0">
                            <i class="ti ti-map-pin text-slate-400 text-sm"></i> Alamat Lengkap
                        </span>
                        <span class="font-semibold text-slate-900 text-right leading-relaxed">
                            {{ $anggota->alamat ?: '-' }}
                        </span>
                    </div>

                    <!-- Desa / Kelurahan -->
                    <div class="px-5 py-3 flex items-center justify-between gap-4 hover:bg-slate-50/50 transition">
                        <span class="text-slate-500 font-semibold flex items-center gap-2">
                            <i class="ti ti-building text-slate-400 text-sm"></i> Desa / Kelurahan
                        </span>
                        <span class="font-bold text-slate-900 uppercase">
                            {{ $anggota->nama_desa ?: '-' }}
                        </span>
                    </div>

                    <!-- Kecamatan -->
                    <div class="px-5 py-3 flex items-center justify-between gap-4 hover:bg-slate-50/50 transition">
                        <span class="text-slate-500 font-semibold flex items-center gap-2">
                            <i class="ti ti-building-community text-slate-400 text-sm"></i> Kecamatan
                        </span>
                        <span class="font-bold text-slate-900 uppercase">
                            {{ $anggota->nama_kecamatan ?: '-' }}
                        </span>
                    </div>

                    <!-- Kabupaten / Kota -->
                    <div class="px-5 py-3 flex items-center justify-between gap-4 hover:bg-slate-50/50 transition">
                        <span class="text-slate-500 font-semibold flex items-center gap-2">
                            <i class="ti ti-building-monument text-slate-400 text-sm"></i> Kabupaten / Kota
                        </span>
                        <span class="font-bold text-slate-900 uppercase">
                            {{ $anggota->nama_kabupaten ?: '-' }}
                        </span>
                    </div>

                    <!-- Provinsi -->
                    <div class="px-5 py-3 flex items-center justify-between gap-4 hover:bg-slate-50/50 transition">
                        <span class="text-slate-500 font-semibold flex items-center gap-2">
                            <i class="ti ti-map text-slate-400 text-sm"></i> Provinsi
                        </span>
                        <span class="font-bold text-slate-900 uppercase">
                            {{ $anggota->nama_provinsi ?: '-' }}
                        </span>
                    </div>

                    <!-- Kode Pos -->
                    <div class="px-5 py-3 flex items-center justify-between gap-4 hover:bg-slate-50/50 transition">
                        <span class="text-slate-500 font-semibold flex items-center gap-2">
                            <i class="ti ti-mail text-slate-400 text-sm"></i> Kode Pos
                        </span>
                        <span class="font-bold text-slate-800">
                            {{ $anggota->kode_pos ?: '-' }}
                        </span>
                    </div>

                    <!-- Status Tempat Tinggal -->
                    <div class="px-5 py-3 flex items-center justify-between gap-4 hover:bg-slate-50/50 transition">
                        <span class="text-slate-500 font-semibold flex items-center gap-2">
                            <i class="ti ti-home text-slate-400 text-sm"></i> Status Tempat Tinggal
                        </span>
                        <span>
                            @if($anggota->status_tinggal == 'MS')
                                <span class="px-2.5 py-0.5 rounded-md text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    Milik Sendiri
                                </span>
                            @elseif($anggota->status_tinggal == 'MK')
                                <span class="px-2.5 py-0.5 rounded-md text-[11px] font-bold bg-sky-50 text-sky-700 border border-sky-200">
                                    Milik Keluarga
                                </span>
                            @elseif($anggota->status_tinggal == 'SK')
                                <span class="px-2.5 py-0.5 rounded-md text-[11px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                    Sewa / Kontrak
                                </span>
                            @else
                                <span class="text-slate-400">-</span>
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            <!-- Card 4: Santri / Siswa Terhubung -->
            <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
                <div class="px-5 py-3.5 bg-slate-50/80 border-b border-slate-200/90 flex items-center justify-between gap-2">
                    <div class="flex items-center gap-2.5">
                        <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-sm font-bold shadow-2xs">
                            <i class="ti ti-school"></i>
                        </div>
                        <div>
                            <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider">Santri / Siswa Terhubung</h3>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="px-2.5 py-0.5 rounded-md text-[11px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                            {{ $anggota->siswa ? $anggota->siswa->count() : 0 }} Santri
                        </span>
                        <button type="button" 
                                class="btnHubungkanSiswa inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg text-xs shadow-2xs transition active:scale-95 cursor-pointer"
                                no_anggota="{{ Crypt::encrypt($anggota->no_anggota) }}">
                            <i class="ti ti-plus text-xs"></i>
                            <span>Hubungkan</span>
                        </button>
                    </div>
                </div>

                <div class="p-4">
                    @if($anggota->siswa && $anggota->siswa->count() > 0)
                        <div class="space-y-2.5">
                            @foreach($anggota->siswa as $siswa)
                                <div class="flex items-center justify-between p-3.5 bg-white border border-slate-200/90 rounded-xl shadow-2xs hover:border-emerald-300 transition">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold text-xs shrink-0 shadow-2xs">
                                            <i class="ti ti-school text-base"></i>
                                        </div>
                                        <div class="min-w-0">
                                            <div class="font-bold text-slate-900 text-xs sm:text-sm uppercase truncate">{{ $siswa->nama_lengkap }}</div>
                                            <div class="text-slate-400 text-[11px] flex items-center gap-2 mt-0.5">
                                                <span>ID: <strong class="text-slate-700">{{ $siswa->id_siswa }}</strong></span>
                                                @if($siswa->nisn)
                                                    <span>•</span>
                                                    <span>NISN: <strong class="text-slate-700">{{ $siswa->nisn }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" 
                                            class="btnHapusHubungan w-8 h-8 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200/80 flex items-center justify-center transition active:scale-95 cursor-pointer shadow-2xs shrink-0" 
                                            data-id-siswa="{{ $siswa->id_siswa }}" 
                                            title="Putuskan Hubungan">
                                        <i class="ti ti-trash text-sm"></i>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-6 bg-slate-50/50 border border-dashed border-slate-200 rounded-xl text-center text-slate-400">
                            <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-2 text-lg">
                                <i class="ti ti-school-off"></i>
                            </div>
                            <div class="text-xs font-bold text-slate-700">Belum Ada Santri Terhubung</div>
                            <p class="text-[11px] text-slate-400 mt-0.5 max-w-xs mx-auto">Relasikan anggota koperasi dengan santri untuk integrasi data.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Card 5: Guru / Karyawan Terhubung -->
            <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
                <div class="px-5 py-3.5 bg-slate-50/80 border-b border-slate-200/90 flex items-center justify-between gap-2">
                    <div class="flex items-center gap-2.5">
                        <div class="w-7 h-7 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center text-sm font-bold shadow-2xs">
                            <i class="ti ti-briefcase"></i>
                        </div>
                        <div>
                            <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider">Guru / Karyawan Terhubung</h3>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="px-2.5 py-0.5 rounded-md text-[11px] font-bold bg-indigo-50 text-indigo-800 border border-indigo-200">
                            {{ $anggota->karyawan ? $anggota->karyawan->count() : 0 }} Pegawai
                        </span>
                        <button type="button" 
                                class="btnHubungkanKaryawan inline-flex items-center gap-1.5 px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg text-xs shadow-2xs transition active:scale-95 cursor-pointer"
                                no_anggota="{{ Crypt::encrypt($anggota->no_anggota) }}">
                            <i class="ti ti-plus text-xs"></i>
                            <span>Hubungkan</span>
                        </button>
                    </div>
                </div>

                <div class="p-4">
                    @if($anggota->karyawan && $anggota->karyawan->count() > 0)
                        <div class="space-y-2.5">
                            @foreach($anggota->karyawan as $karyawan)
                                <div class="flex items-center justify-between p-3.5 bg-white border border-slate-200/90 rounded-xl shadow-2xs hover:border-indigo-300 transition">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <div class="w-9 h-9 rounded-xl bg-indigo-100 text-indigo-800 flex items-center justify-center font-bold text-xs shrink-0 shadow-2xs">
                                            <i class="ti ti-briefcase text-base"></i>
                                        </div>
                                        <div class="min-w-0">
                                            <div class="font-bold text-slate-900 text-xs sm:text-sm uppercase truncate">{{ $karyawan->nama_lengkap }}</div>
                                            <div class="text-slate-400 text-[11px] flex items-center gap-2 mt-0.5">
                                                <span>NPP: <strong class="text-slate-700">{{ $karyawan->npp }}</strong></span>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" 
                                            class="btnHapusHubunganKaryawan w-8 h-8 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200/80 flex items-center justify-center transition active:scale-95 cursor-pointer shadow-2xs shrink-0" 
                                            data-npp="{{ $karyawan->npp }}" 
                                            title="Putuskan Hubungan">
                                        <i class="ti ti-trash text-sm"></i>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-6 bg-slate-50/50 border border-dashed border-slate-200 rounded-xl text-center text-slate-400">
                            <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-2 text-lg">
                                <i class="ti ti-user-off"></i>
                            </div>
                            <div class="text-xs font-bold text-slate-700">Belum Ada Pegawai Terhubung</div>
                            <p class="text-[11px] text-slate-400 mt-0.5 max-w-xs mx-auto">Relasikan anggota koperasi dengan data karyawan untuk integrasi simpan pinjam.</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

</div>

<!-- Modal Form Edit -->
<x-modal-form id="mdlAnggota" size="modal-xl" show="loadmodalAnggota" title="Edit Anggota Koperasi" icon="ti ti-users" />

<!-- Modal Hubungkan Siswa -->
<div class="modal fade" id="mdlHubungkanSiswa" tabindex="-1" aria-labelledby="mdlHubungkanSiswaLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border border-slate-200/90 shadow-2xl rounded-2xl bg-white overflow-hidden">
            <!-- Modal Header -->
            <div class="px-6 py-4 bg-white border-b border-slate-200/90 flex items-center justify-between text-slate-900">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-100 flex items-center justify-center text-base shrink-0 font-bold">
                        <i class="ti ti-school"></i>
                    </div>
                    <div>
                        <h5 class="modal-title text-base font-bold text-slate-900 tracking-tight truncate mb-0" id="mdlHubungkanSiswaLabel">Hubungkan Santri / Siswa</h5>
                        <p class="text-[11px] text-slate-500 mb-0">Relasikan anggota koperasi dengan data santri terdaftar</p>
                    </div>
                </div>
                <button type="button" class="w-8 h-8 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 flex items-center justify-center transition-colors cursor-pointer shrink-0" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti ti-x text-lg"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body p-6 bg-white space-y-5">
                <!-- 1. Form Hubungkan Santri Baru -->
                <div class="bg-slate-50/80 border border-slate-200/90 rounded-xl p-4 sm:p-5 space-y-3.5">
                    <div class="flex items-center gap-2.5 pb-2.5 border-b border-slate-200/80">
                        <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-sm font-bold shadow-2xs">
                            <i class="ti ti-link"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-900 leading-tight">1. Tambah Relasi Santri</h3>
                            <p class="text-[11px] text-slate-500">Pilih santri untuk direlasikan dengan akun anggota ini</p>
                        </div>
                    </div>

                    <form id="formHubungkanSiswa" class="space-y-3">
                        <input type="hidden" id="no_anggota_hidden" name="no_anggota" value="{{ Crypt::encrypt($anggota->no_anggota) }}">

                        <div class="space-y-1.5">
                            <label for="id_siswa" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                                <i class="ti ti-school text-sm text-slate-400"></i>
                                <span>Pilih Santri / Siswa <span class="text-rose-500 font-bold">*</span></span>
                            </label>
                            <div class="flex flex-col sm:flex-row gap-2.5 items-stretch sm:items-center">
                                <div class="relative flex-1 min-w-0">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 z-10">
                                        <i class="ti ti-school text-base"></i>
                                    </div>
                                    <select class="form-select select2 w-full" id="id_siswa" name="id_siswa" required>
                                        <option value="">-- Cari Nama Siswa / ID --</option>
                                    </select>
                                </div>
                                <button type="button" 
                                        class="inline-flex items-center justify-center gap-2 px-5 h-[42px] bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs transition active:scale-95 cursor-pointer shrink-0" 
                                        id="btnSimpanHubungan">
                                    <i class="ti ti-link text-sm"></i>
                                    <span>Hubungkan Santri</span>
                                </button>
                            </div>
                        </div>

                        <div class="p-3 bg-emerald-50/70 border border-emerald-200/80 rounded-xl flex items-start gap-2 text-xs text-emerald-900">
                            <i class="ti ti-info-circle text-emerald-600 text-base shrink-0 mt-0.5"></i>
                            <span>Satu anggota koperasi dapat terhubung dengan beberapa santri (misal: orang tua / wali santri).</span>
                        </div>
                    </form>
                </div>

                <!-- 2. Daftar Santri Yang Sudah Terhubung -->
                <div class="bg-slate-50/80 border border-slate-200/90 rounded-xl p-4 sm:p-5 space-y-3.5">
                    <div class="flex items-center justify-between pb-2.5 border-b border-slate-200/80">
                        <div class="flex items-center gap-2.5">
                            <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-sm font-bold shadow-2xs">
                                <i class="ti ti-list-check"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-900 leading-tight">2. Santri Yang Sudah Terhubung</h3>
                                <p class="text-[11px] text-slate-500">Daftar santri yang saat ini terhubung dengan anggota</p>
                            </div>
                        </div>
                    </div>

                    <div id="siswa-terhubung" class="space-y-2.5 max-h-64 overflow-y-auto pr-1"></div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="px-6 py-3.5 bg-white border-t border-slate-200/90 flex justify-end">
                <button type="button" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer active:scale-95" data-bs-dismiss="modal">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Hubungkan Karyawan -->
<div class="modal fade" id="mdlHubungkanKaryawan" tabindex="-1" aria-labelledby="mdlHubungkanKaryawanLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border border-slate-200/90 shadow-2xl rounded-2xl bg-white overflow-hidden">
            <!-- Modal Header -->
            <div class="px-6 py-4 bg-white border-b border-slate-200/90 flex items-center justify-between text-slate-900">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-700 border border-indigo-100 flex items-center justify-center text-base shrink-0 font-bold">
                        <i class="ti ti-briefcase"></i>
                    </div>
                    <div>
                        <h5 class="modal-title text-base font-bold text-slate-900 tracking-tight truncate mb-0" id="mdlHubungkanKaryawanLabel">Hubungkan Guru / Karyawan</h5>
                        <p class="text-[11px] text-slate-500 mb-0">Relasikan anggota koperasi dengan data pegawai/karyawan terdaftar</p>
                    </div>
                </div>
                <button type="button" class="w-8 h-8 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 flex items-center justify-center transition-colors cursor-pointer shrink-0" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti ti-x text-lg"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body p-6 bg-white space-y-5">
                <!-- 1. Form Hubungkan Karyawan Baru -->
                <div class="bg-slate-50/80 border border-slate-200/90 rounded-xl p-4 sm:p-5 space-y-3.5">
                    <div class="flex items-center gap-2.5 pb-2.5 border-b border-slate-200/80">
                        <div class="w-7 h-7 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center text-sm font-bold shadow-2xs">
                            <i class="ti ti-link"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-900 leading-tight">1. Tambah Relasi Karyawan</h3>
                            <p class="text-[11px] text-slate-500">Pilih pegawai untuk direlasikan dengan akun anggota ini</p>
                        </div>
                    </div>

                    <form id="formHubungkanKaryawan" class="space-y-3">
                        <input type="hidden" id="no_anggota_hidden_karyawan" name="no_anggota" value="{{ Crypt::encrypt($anggota->no_anggota) }}">

                        <div class="space-y-1.5">
                            <label for="npp" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                                <i class="ti ti-briefcase text-sm text-slate-400"></i>
                                <span>Pilih Pegawai / Karyawan <span class="text-rose-500 font-bold">*</span></span>
                            </label>
                            <div class="flex flex-col sm:flex-row gap-2.5 items-stretch sm:items-center">
                                <div class="relative flex-1 min-w-0">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 z-10">
                                        <i class="ti ti-briefcase text-base"></i>
                                    </div>
                                    <select class="form-select select2 w-full" id="npp" name="npp" required>
                                        <option value="">-- Cari Nama Karyawan / NPP --</option>
                                    </select>
                                </div>
                                <button type="button" 
                                        class="inline-flex items-center justify-center gap-2 px-5 h-[42px] bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-xs shadow-xs transition active:scale-95 cursor-pointer shrink-0" 
                                        id="btnSimpanHubunganKaryawan">
                                    <i class="ti ti-link text-sm"></i>
                                    <span>Hubungkan Karyawan</span>
                                </button>
                            </div>
                        </div>

                        <div class="p-3 bg-indigo-50/70 border border-indigo-200/80 rounded-xl flex items-start gap-2 text-xs text-indigo-900">
                            <i class="ti ti-info-circle text-indigo-600 text-base shrink-0 mt-0.5"></i>
                            <span>Menghubungkan anggota dengan data karyawan memudahkan integrasi simpanan dan pembiayaan koperasi.</span>
                        </div>
                    </form>
                </div>

                <!-- 2. Daftar Karyawan Yang Sudah Terhubung -->
                <div class="bg-slate-50/80 border border-slate-200/90 rounded-xl p-4 sm:p-5 space-y-3.5">
                    <div class="flex items-center justify-between pb-2.5 border-b border-slate-200/80">
                        <div class="flex items-center gap-2.5">
                            <div class="w-7 h-7 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center text-sm font-bold shadow-2xs">
                                <i class="ti ti-list-check"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-900 leading-tight">2. Karyawan Yang Sudah Terhubung</h3>
                                <p class="text-[11px] text-slate-500">Daftar pegawai yang saat ini terhubung dengan anggota</p>
                            </div>
                        </div>
                    </div>

                    <div id="karyawan-terhubung" class="space-y-2.5 max-h-64 overflow-y-auto pr-1"></div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="px-6 py-3.5 bg-white border-t border-slate-200/90 flex justify-end">
                <button type="button" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer active:scale-95" data-bs-dismiss="modal">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('myscript')
<script>
    $(function() {
        // Initialize Select2 in Modals
        $('#id_siswa').select2({
            dropdownParent: $('#mdlHubungkanSiswa'),
            placeholder: '-- Cari Nama Siswa / ID --',
            allowClear: true,
            width: '100%'
        });

        $('#npp').select2({
            dropdownParent: $('#mdlHubungkanKaryawan'),
            placeholder: '-- Cari Nama Karyawan / NPP --',
            allowClear: true,
            width: '100%'
        });

        // Edit Modal
        $(".btnEditAnggota").click(function(e) {
            var no_anggota = $(this).attr("no_anggota");
            e.preventDefault();
            $('#mdlAnggota').modal("show");
            $("#loadmodalAnggota").html(`
                <div class="flex flex-col items-center justify-center p-12 text-center bg-white">
                    <div class="w-9 h-9 border-3 border-emerald-500 border-t-transparent rounded-full animate-spin mb-3"></div>
                    <span class="text-slate-500 text-xs font-semibold">Memuat data profil...</span>
                </div>
            `);
            $("#loadmodalAnggota").load('/anggota/' + no_anggota + '/edit');
        });

        // Hubungkan Siswa Modal
        $(document).on('click', '.btnHubungkanSiswa', function(e) {
            e.preventDefault();
            var no_anggota = $(this).attr("no_anggota");
            $('#no_anggota_hidden').val(no_anggota);
            $('#mdlHubungkanSiswa').modal("show");

            loadSiswaOptions();
            loadSiswaTerhubung(no_anggota);
        });

        function loadSiswaOptions() {
            $.get('/anggota/get-siswa-options', function(data) {
                $('#id_siswa').html('<option value="">-- Cari Nama Siswa / ID --</option>');
                $.each(data, function(index, siswa) {
                    $('#id_siswa').append('<option value="' + siswa.id_siswa + '">' + siswa.nama_lengkap + ' (' + siswa.id_siswa + ')</option>');
                });
                $('#id_siswa').val('').trigger('change');
            });
        }

        function loadSiswaTerhubung(no_anggota) {
            $("#siswa-terhubung").html(`
                <div class="text-center py-6 text-xs text-slate-400">
                    <div class="w-6 h-6 border-2 border-emerald-500 border-t-transparent rounded-full animate-spin mx-auto mb-2"></div>
                    <span>Memuat santri terhubung...</span>
                </div>
            `);
            $.get('/anggota/get-siswa-terhubung/' + no_anggota, function(data) {
                var html = '';
                if (data.length > 0) {
                    $.each(data, function(index, siswa) {
                        html += `
                            <div class="flex items-center justify-between p-3.5 bg-white border border-slate-200/90 rounded-xl shadow-2xs hover:border-emerald-300 transition">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold text-xs shrink-0 shadow-2xs">
                                        <i class="ti ti-school text-base"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="font-bold text-slate-900 text-xs sm:text-sm uppercase truncate">${siswa.nama_lengkap}</div>
                                        <div class="text-slate-400 text-[11px] flex items-center gap-2 mt-0.5">
                                            <span>ID: <strong class="text-slate-700">${siswa.id_siswa}</strong></span>
                                            ${siswa.nisn ? `<span>•</span><span>NISN: <strong class="text-slate-700">${siswa.nisn}</strong></span>` : ''}
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btnHapusHubungan w-8 h-8 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200/80 flex items-center justify-center transition active:scale-95 cursor-pointer shadow-2xs shrink-0" data-id-siswa="${siswa.id_siswa}" title="Putuskan Hubungan">
                                    <i class="ti ti-trash text-sm"></i>
                                </button>
                            </div>
                        `;
                    });
                } else {
                    html = `
                        <div class="p-6 bg-slate-50/50 border border-dashed border-slate-200 rounded-xl text-center text-slate-400">
                            <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-2 text-lg">
                                <i class="ti ti-school-off"></i>
                            </div>
                            <div class="text-xs font-bold text-slate-700">Belum Ada Santri Terhubung</div>
                            <p class="text-[11px] text-slate-400 mt-0.5 max-w-xs mx-auto">Relasikan anggota koperasi dengan santri untuk integrasi data.</p>
                        </div>
                    `;
                }
                $('#siswa-terhubung').html(html);
            });
        }

        $('#btnSimpanHubungan').click(function() {
            var btn = $(this);
            var no_anggota = $('#no_anggota_hidden').val();
            var id_siswa = $('#id_siswa').val();

            if (!id_siswa) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Silahkan pilih santri/siswa terlebih dahulu',
                    confirmButtonColor: '#059669',
                    customClass: {
                        popup: 'rounded-2xl shadow-2xl p-5',
                        confirmButton: 'px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition cursor-pointer'
                    }
                });
                return;
            }

            btn.prop('disabled', true).html('<div class="w-3.5 h-3.5 border-2 border-white border-t-transparent rounded-full animate-spin"></div><span>Menyimpan...</span>');

            $.post('/anggota/hubungkan-siswa', {
                _token: $('meta[name="csrf-token"]').attr('content'),
                no_anggota: no_anggota,
                id_siswa: id_siswa
            }, function(response) {
                btn.prop('disabled', false).html('<i class="ti ti-link text-sm"></i><span>Hubungkan Santri</span>');
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Santri berhasil dihubungkan!',
                        timer: 1500,
                        showConfirmButton: false,
                        customClass: {
                            popup: 'rounded-2xl shadow-2xl p-5'
                        }
                    });
                    loadSiswaTerhubung(no_anggota);
                    $('#id_siswa').val('').trigger('change');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: response.message || 'Gagal menghubungkan siswa',
                        confirmButtonColor: '#059669',
                        customClass: {
                            popup: 'rounded-2xl shadow-2xl p-5',
                            confirmButton: 'px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition cursor-pointer'
                        }
                    });
                }
            }).fail(function() {
                btn.prop('disabled', false).html('<i class="ti ti-link text-sm"></i><span>Hubungkan Santri</span>');
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan sistem saat menghubungkan data',
                    confirmButtonColor: '#059669',
                    customClass: {
                        popup: 'rounded-2xl shadow-2xl p-5',
                        confirmButton: 'px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition cursor-pointer'
                    }
                });
            });
        });

        $(document).on('click', '.btnHapusHubungan', function() {
            var id_siswa = $(this).data('id-siswa');
            var no_anggota = $('#no_anggota_hidden').val() || "{{ Crypt::encrypt($anggota->no_anggota) }}";

            Swal.fire({
                title: 'Putuskan Hubungan Santri?',
                text: "Yakin ingin memutuskan hubungan santri ini dari anggota?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',
                confirmButtonText: '<i class="ti ti-trash mr-1"></i> Ya, Putuskan',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-2xl shadow-2xl p-5',
                    title: 'text-base font-bold text-slate-900',
                    confirmButton: 'px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs rounded-xl shadow-xs transition cursor-pointer',
                    cancelButton: 'px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post('/anggota/hapus-hubungan-siswa', {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        no_anggota: no_anggota,
                        id_siswa: id_siswa
                    }, function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Hubungan santri berhasil dihapus!',
                                timer: 1500,
                                showConfirmButton: false,
                                customClass: {
                                    popup: 'rounded-2xl shadow-2xl p-5'
                                }
                            });
                            location.reload();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: response.message || 'Gagal menghapus hubungan',
                                confirmButtonColor: '#059669',
                                customClass: {
                                    popup: 'rounded-2xl shadow-2xl p-5',
                                    confirmButton: 'px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition cursor-pointer'
                                }
                            });
                        }
                    });
                }
            });
        });

        // Hubungkan Karyawan Modal
        $(document).on('click', '.btnHubungkanKaryawan', function(e) {
            e.preventDefault();
            var no_anggota = $(this).attr("no_anggota");
            $('#no_anggota_hidden_karyawan').val(no_anggota);
            $('#mdlHubungkanKaryawan').modal("show");

            loadKaryawanOptions();
            loadKaryawanTerhubung(no_anggota);
        });

        function loadKaryawanOptions() {
            $.get('/anggota/get-karyawan-options', function(data) {
                $('#npp').html('<option value="">-- Cari Nama Karyawan / NPP --</option>');
                $.each(data, function(index, karyawan) {
                    $('#npp').append('<option value="' + karyawan.npp + '">' + karyawan.nama_lengkap + ' (' + karyawan.npp + ')</option>');
                });
                $('#npp').val('').trigger('change');
            });
        }

        function loadKaryawanTerhubung(no_anggota) {
            $("#karyawan-terhubung").html(`
                <div class="text-center py-6 text-xs text-slate-400">
                    <div class="w-6 h-6 border-2 border-indigo-500 border-t-transparent rounded-full animate-spin mx-auto mb-2"></div>
                    <span>Memuat karyawan terhubung...</span>
                </div>
            `);
            $.get('/anggota/get-karyawan-terhubung/' + no_anggota, function(data) {
                var html = '';
                if (data.length > 0) {
                    $.each(data, function(index, karyawan) {
                        html += `
                            <div class="flex items-center justify-between p-3.5 bg-white border border-slate-200/90 rounded-xl shadow-2xs hover:border-indigo-300 transition">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="w-9 h-9 rounded-xl bg-indigo-100 text-indigo-800 flex items-center justify-center font-bold text-xs shrink-0 shadow-2xs">
                                        <i class="ti ti-briefcase text-base"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="font-bold text-slate-900 text-xs sm:text-sm uppercase truncate">${karyawan.nama_lengkap}</div>
                                        <div class="text-slate-400 text-[11px] flex items-center gap-2 mt-0.5">
                                            <span>NPP: <strong class="text-slate-700">${karyawan.npp}</strong></span>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btnHapusHubunganKaryawan w-8 h-8 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200/80 flex items-center justify-center transition active:scale-95 cursor-pointer shadow-2xs shrink-0" data-npp="${karyawan.npp}" title="Putuskan Hubungan">
                                    <i class="ti ti-trash text-sm"></i>
                                </button>
                            </div>
                        `;
                    });
                } else {
                    html = `
                        <div class="p-6 bg-slate-50/50 border border-dashed border-slate-200 rounded-xl text-center text-slate-400">
                            <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-2 text-lg">
                                <i class="ti ti-user-off"></i>
                            </div>
                            <div class="text-xs font-bold text-slate-700">Belum Ada Pegawai Terhubung</div>
                            <p class="text-[11px] text-slate-400 mt-0.5 max-w-xs mx-auto">Relasikan anggota koperasi dengan data karyawan untuk integrasi simpan pinjam.</p>
                        </div>
                    `;
                }
                $('#karyawan-terhubung').html(html);
            });
        }

        $('#btnSimpanHubunganKaryawan').click(function() {
            var btn = $(this);
            var no_anggota = $('#no_anggota_hidden_karyawan').val();
            var npp = $('#npp').val();

            if (!npp) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Silahkan pilih karyawan terlebih dahulu',
                    confirmButtonColor: '#059669',
                    customClass: {
                        popup: 'rounded-2xl shadow-2xl p-5',
                        confirmButton: 'px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition cursor-pointer'
                    }
                });
                return;
            }

            btn.prop('disabled', true).html('<div class="w-3.5 h-3.5 border-2 border-white border-t-transparent rounded-full animate-spin"></div><span>Menyimpan...</span>');

            $.post('/anggota/hubungkan-karyawan', {
                _token: $('meta[name="csrf-token"]').attr('content'),
                no_anggota: no_anggota,
                npp: npp
            }, function(response) {
                btn.prop('disabled', false).html('<i class="ti ti-link text-sm"></i><span>Hubungkan Karyawan</span>');
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Karyawan berhasil dihubungkan!',
                        timer: 1500,
                        showConfirmButton: false,
                        customClass: {
                            popup: 'rounded-2xl shadow-2xl p-5'
                        }
                    });
                    loadKaryawanTerhubung(no_anggota);
                    $('#npp').val('').trigger('change');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: response.message || 'Gagal menghubungkan karyawan',
                        confirmButtonColor: '#059669',
                        customClass: {
                            popup: 'rounded-2xl shadow-2xl p-5',
                            confirmButton: 'px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition cursor-pointer'
                        }
                    });
                }
            }).fail(function() {
                btn.prop('disabled', false).html('<i class="ti ti-link text-sm"></i><span>Hubungkan Karyawan</span>');
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan sistem saat menghubungkan data',
                    confirmButtonColor: '#059669',
                    customClass: {
                        popup: 'rounded-2xl shadow-2xl p-5',
                        confirmButton: 'px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition cursor-pointer'
                    }
                });
            });
        });

        $(document).on('click', '.btnHapusHubunganKaryawan', function() {
            var npp = $(this).data('npp');
            var no_anggota = $('#no_anggota_hidden_karyawan').val() || "{{ Crypt::encrypt($anggota->no_anggota) }}";

            Swal.fire({
                title: 'Putuskan Hubungan Karyawan?',
                text: "Yakin ingin memutuskan hubungan karyawan ini dari anggota?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',
                confirmButtonText: '<i class="ti ti-trash mr-1"></i> Ya, Putuskan',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-2xl shadow-2xl p-5',
                    title: 'text-base font-bold text-slate-900',
                    confirmButton: 'px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs rounded-xl shadow-xs transition cursor-pointer',
                    cancelButton: 'px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post('/anggota/hapus-hubungan-karyawan', {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        no_anggota: no_anggota,
                        npp: npp
                    }, function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Hubungan karyawan berhasil dihapus!',
                                timer: 1500,
                                showConfirmButton: false,
                                customClass: {
                                    popup: 'rounded-2xl shadow-2xl p-5'
                                }
                            });
                            location.reload();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: response.message || 'Gagal menghapus hubungan',
                                confirmButtonColor: '#059669',
                                customClass: {
                                    popup: 'rounded-2xl shadow-2xl p-5',
                                    confirmButton: 'px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition cursor-pointer'
                                }
                            });
                        }
                    });
                }
            });
        });

        // Reload page on modal dismiss if connections changed
        $('#mdlHubungkanSiswa, #mdlHubungkanKaryawan').on('hidden.bs.modal', function () {
            location.reload();
        });
    });
</script>
@endpush

@extends('layouts.app')
@section('titlepage', 'Detail Siswa - ' . $siswa->nama_lengkap)

@section('content')
<div class="space-y-6">

    <!-- ================= 1. PAGE HEADER & BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <i class="ti ti-school text-emerald-600 text-2xl"></i>
                <span>Profil & Biodata Siswa</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Informasi detail biodata, domisili, dan data orang tua santri
            </p>
        </div>

        <div class="flex flex-col md:items-end gap-2.5">
            <nav class="flex items-center text-xs text-slate-400 font-medium">
                <a href="{{ route('dashboard.index') }}" class="hover:text-slate-700 transition flex items-center gap-1">
                    <i class="ti ti-home text-sm"></i>
                    <span>Dashboard</span>
                </a>
                <span class="mx-2 text-slate-300">/</span>
                <a href="{{ route('siswa.index') }}" class="hover:text-slate-700 transition flex items-center gap-1">
                    <i class="ti ti-database text-sm"></i>
                    <span>Siswa</span>
                </a>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Detail</span>
            </nav>

            <div class="flex items-center gap-2">
                <a href="{{ route('siswa.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white hover:bg-slate-50 text-slate-700 font-bold border border-slate-300 rounded-lg text-xs shadow-xs transition active:scale-95">
                    <i class="ti ti-arrow-left text-base"></i>
                    <span>Kembali ke Data Siswa</span>
                </a>
            </div>
        </div>
    </div>

    <!-- ================= 2. PROFILE HERO BANNER CARD ================= -->
    @php
        $fotoSiswa = null;
        if (!empty($siswa->foto)) {
            $fotoSiswa = $siswa->foto;
        }
    @endphp
    <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
        <!-- Top Gradient Strip -->
        <div class="h-28 sm:h-36 bg-gradient-to-r from-emerald-700 via-emerald-600 to-teal-600 relative overflow-hidden">
            <div class="absolute inset-0 opacity-15 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px]"></div>
            <div class="absolute -right-8 -bottom-8 w-40 h-40 rounded-full bg-white/10 blur-xl"></div>
        </div>

        <!-- Profile Info Bar -->
        <div class="px-6 pb-6 pt-0 relative">
            <div class="flex flex-col sm:flex-row items-center sm:items-end justify-between gap-4 -mt-14 sm:-mt-16 mb-4">
                
                <!-- Avatar & Identity -->
                <div class="flex flex-col sm:flex-row items-center sm:items-end gap-4 text-center sm:text-left">
                    <div class="relative w-28 h-32 sm:w-32 sm:h-36 rounded-2xl bg-white p-1.5 shadow-xl border border-slate-200/80 shrink-0">
                        @if ($fotoSiswa && Storage::disk('public')->exists('photos/pendaftaran/' . $fotoSiswa))
                            <img src="{{ asset('storage/photos/pendaftaran/' . $fotoSiswa) }}" alt="{{ $siswa->nama_lengkap }}" class="w-full h-full object-cover rounded-xl">
                        @elseif ($fotoSiswa && Storage::disk('public')->exists('photos/siswa/' . $fotoSiswa))
                            <img src="{{ asset('storage/photos/siswa/' . $fotoSiswa) }}" alt="{{ $siswa->nama_lengkap }}" class="w-full h-full object-cover rounded-xl">
                        @else
                            <div class="w-full h-full rounded-xl {{ $siswa->jenis_kelamin == 'L' ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700' }} flex flex-col items-center justify-center font-black text-3xl shadow-inner">
                                {{ strtoupper(substr($siswa->nama_lengkap, 0, 1)) }}
                            </div>
                        @endif

                        @if($siswa->jenis_kelamin == 'L')
                            <span class="absolute -bottom-1.5 -right-1.5 w-7 h-7 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs ring-4 ring-white shadow-sm" title="Laki-laki">
                                <i class="ti ti-gender-male"></i>
                            </span>
                        @else
                            <span class="absolute -bottom-1.5 -right-1.5 w-7 h-7 rounded-full bg-rose-500 text-white flex items-center justify-center text-xs ring-4 ring-white shadow-sm" title="Perempuan">
                                <i class="ti ti-gender-female"></i>
                            </span>
                        @endif
                    </div>

                    <div class="space-y-1.5 pb-1">
                        <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2">
                            <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
                                {{ ucwords(strtolower($siswa->nama_lengkap)) }}
                            </h2>
                            @if($siswa->jenis_kelamin == 'L')
                                <span class="px-2.5 py-0.5 rounded-md text-[11px] font-bold bg-blue-50 text-blue-700 border border-blue-100">
                                    Laki-laki
                                </span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-md text-[11px] font-bold bg-rose-50 text-rose-700 border border-rose-100">
                                    Perempuan
                                </span>
                            @endif
                        </div>

                        <div class="flex flex-wrap items-center justify-center sm:justify-start gap-x-4 gap-y-1 text-xs text-slate-500">
                            <div class="flex items-center gap-1.5">
                                <span class="text-slate-400">ID Siswa:</span>
                                <span class="font-bold text-slate-800 font-mono bg-slate-100 px-2 py-0.5 rounded border border-slate-200">{{ $siswa->id_siswa }}</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <span class="text-slate-400">NISN:</span>
                                <span class="font-semibold text-slate-700">{{ $siswa->nisn ?? '-' }}</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <span class="text-slate-400">Tahun Masuk:</span>
                                <span class="font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200">{{ $siswa->tahun_masuk ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- ================= 3. DETAIL CONTENT GRID ================= -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Left: Biodata & Wilayah -->
        <div class="space-y-6">
            <!-- Biodata Diri Card -->
            <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs p-5 space-y-4">
                <div class="flex items-center gap-2.5 pb-3 border-b border-slate-100 text-slate-900">
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-100 flex items-center justify-center text-base font-bold">
                        <i class="ti ti-user"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900">Biodata Lengkap Santri</h3>
                        <p class="text-[11px] text-slate-400">Data pribadi kelahiran dan status dalam keluarga</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div class="space-y-1">
                        <span class="text-slate-400 block font-medium">Tempat Lahir</span>
                        <span class="font-bold text-slate-800 text-sm">{{ $siswa->tempat_lahir ?? '-' }}</span>
                    </div>

                    <div class="space-y-1">
                        <span class="text-slate-400 block font-medium">Tanggal Lahir</span>
                        <span class="font-bold text-slate-800 text-sm">
                            {{ !empty($siswa->tanggal_lahir) ? DateToIndo($siswa->tanggal_lahir) : '-' }}
                        </span>
                    </div>

                    <div class="space-y-1">
                        <span class="text-slate-400 block font-medium">Anak Ke-</span>
                        <span class="font-bold text-slate-800 text-sm">{{ $siswa->anak_ke ?? '-' }}</span>
                    </div>

                    <div class="space-y-1">
                        <span class="text-slate-400 block font-medium">Jumlah Saudara</span>
                        <span class="font-bold text-slate-800 text-sm">{{ $siswa->jumlah_saudara ?? '-' }} orang</span>
                    </div>
                </div>
            </div>

            <!-- Domisili & Wilayah Card -->
            <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs p-5 space-y-4">
                <div class="flex items-center gap-2.5 pb-3 border-b border-slate-100 text-slate-900">
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-100 flex items-center justify-center text-base font-bold">
                        <i class="ti ti-map-pins"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900">Alamat & Domisili</h3>
                        <p class="text-[11px] text-slate-400">Lokasi tempat tinggal dan wilayah administratif</p>
                    </div>
                </div>

                <div class="space-y-3 text-xs">
                    <div class="space-y-1">
                        <span class="text-slate-400 block font-medium">Alamat Lengkap</span>
                        <p class="font-semibold text-slate-800 text-sm leading-relaxed p-3 bg-slate-50 rounded-xl border border-slate-100">
                            {{ $siswa->alamat ?? '-' }}
                        </p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 pt-1">
                        <div class="space-y-1">
                            <span class="text-slate-400 block font-medium">Provinsi</span>
                            <span class="font-bold text-slate-800">{{ $siswa->province_name ?? '-' }}</span>
                        </div>

                        <div class="space-y-1">
                            <span class="text-slate-400 block font-medium">Kabupaten / Kota</span>
                            <span class="font-bold text-slate-800">{{ $siswa->regency_name ?? '-' }}</span>
                        </div>

                        <div class="space-y-1">
                            <span class="text-slate-400 block font-medium">Kecamatan</span>
                            <span class="font-bold text-slate-800">{{ $siswa->district_name ?? '-' }}</span>
                        </div>

                        <div class="space-y-1">
                            <span class="text-slate-400 block font-medium">Desa / Kelurahan</span>
                            <span class="font-bold text-slate-800">{{ $siswa->village_name ?? '-' }}</span>
                        </div>

                        <div class="space-y-1">
                            <span class="text-slate-400 block font-medium">Kode Pos</span>
                            <span class="font-bold text-slate-800 font-mono">{{ $siswa->kode_pos ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Data Orang Tua / Wali -->
        <div class="space-y-6">
            <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs p-5 space-y-4">
                <div class="flex items-center gap-2.5 pb-3 border-b border-slate-100 text-slate-900">
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-100 flex items-center justify-center text-base font-bold">
                        <i class="ti ti-users-group"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900">Data Orang Tua / Wali</h3>
                        <p class="text-[11px] text-slate-400">Informasi keluarga, ayah, ibu, dan kontak darurat</p>
                    </div>
                </div>

                <!-- No KK & Kontak -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs p-3.5 bg-slate-50 rounded-xl border border-slate-200/80">
                    <div class="space-y-1">
                        <span class="text-slate-400 block font-medium">Nomor Kartu Keluarga (KK)</span>
                        <span class="font-bold text-slate-800 font-mono text-sm">{{ $siswa->no_kk ?? '-' }}</span>
                    </div>

                    <div class="space-y-1">
                        <span class="text-slate-400 block font-medium">No. WhatsApp / HP Orang Tua</span>
                        <span class="font-bold text-emerald-700 text-sm flex items-center gap-1.5">
                            <i class="ti ti-brand-whatsapp text-base"></i>
                            <span>{{ $siswa->no_hp_orang_tua ?? '-' }}</span>
                        </span>
                    </div>
                </div>

                <!-- Ayah Card -->
                <div class="p-4 bg-slate-50/70 rounded-xl border border-slate-200 space-y-3 text-xs">
                    <div class="flex items-center gap-2 font-bold text-emerald-800 border-b border-slate-200/80 pb-2">
                        <i class="ti ti-user-check text-base"></i>
                        <span>Data Ayah Kandung</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="space-y-0.5">
                            <span class="text-slate-400 block">Nama Ayah</span>
                            <span class="font-bold text-slate-900 text-sm">{{ $siswa->nama_ayah ?? '-' }}</span>
                        </div>
                        <div class="space-y-0.5">
                            <span class="text-slate-400 block">NIK Ayah</span>
                            <span class="font-semibold text-slate-700 font-mono">{{ $siswa->nik_ayah ?? '-' }}</span>
                        </div>
                        <div class="space-y-0.5">
                            <span class="text-slate-400 block">Pendidikan</span>
                            <span class="font-semibold text-slate-700">{{ $siswa->pendidikan_ayah ?? '-' }}</span>
                        </div>
                        <div class="space-y-0.5">
                            <span class="text-slate-400 block">Pekerjaan</span>
                            <span class="font-semibold text-slate-700">{{ $siswa->pekerjaan_ayah ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Ibu Card -->
                <div class="p-4 bg-slate-50/70 rounded-xl border border-slate-200 space-y-3 text-xs">
                    <div class="flex items-center gap-2 font-bold text-rose-800 border-b border-slate-200/80 pb-2">
                        <i class="ti ti-user-heart text-base"></i>
                        <span>Data Ibu Kandung</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="space-y-0.5">
                            <span class="text-slate-400 block">Nama Ibu</span>
                            <span class="font-bold text-slate-900 text-sm">{{ $siswa->nama_ibu ?? '-' }}</span>
                        </div>
                        <div class="space-y-0.5">
                            <span class="text-slate-400 block">NIK Ibu</span>
                            <span class="font-semibold text-slate-700 font-mono">{{ $siswa->nik_ibu ?? '-' }}</span>
                        </div>
                        <div class="space-y-0.5">
                            <span class="text-slate-400 block">Pendidikan</span>
                            <span class="font-semibold text-slate-700">{{ $siswa->pendidikan_ibu ?? '-' }}</span>
                        </div>
                        <div class="space-y-0.5">
                            <span class="text-slate-400 block">Pekerjaan</span>
                            <span class="font-semibold text-slate-700">{{ $siswa->pekerjaan_ibu ?? '-' }}</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

</div>
@endsection

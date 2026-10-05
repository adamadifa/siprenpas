@extends('layouts.app')
@section('titlepage', 'Pengaturan Umum')

@section('content')
<div class="space-y-6">

    <!-- ================= 1. PAGE HEADER WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center border border-emerald-200/80 shadow-2xs">
                    <i class="ti ti-settings text-2xl"></i>
                </div>
                <span>Pengaturan Umum Sistem</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Kelola identitas lembaga, konfigurasi branding, sesi keamanan, dan aset visual aplikasi
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
                <span class="text-slate-500 flex items-center gap-1">
                    <i class="ti ti-settings text-sm"></i>
                    <span>Konfigurasi</span>
                </span>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Pengaturan Umum</span>
            </nav>

            @if ($pengaturan)
                <a href="{{ route('pengaturan-umum.edit', $pengaturan->id) }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs transition-all duration-200 active:scale-95 cursor-pointer border-0">
                    <i class="ti ti-edit text-base"></i>
                    <span>Edit Konfigurasi</span>
                </a>
            @else
                <a href="{{ route('pengaturan-umum.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs transition-all duration-200 active:scale-95 cursor-pointer border-0">
                    <i class="ti ti-plus text-base"></i>
                    <span>Inisialisasi Pengaturan</span>
                </a>
            @endif
        </div>
    </div>

    @if ($pengaturan)
        <!-- ================= 2. HERO BRANDING OVERVIEW CARD ================= -->
        <div class="relative overflow-hidden bg-gradient-to-br from-emerald-800 via-emerald-900 to-teal-950 rounded-3xl p-6 sm:p-8 text-white shadow-xl shadow-emerald-950/10 border border-emerald-700/30">
            <div class="absolute -right-16 -top-16 w-64 h-64 rounded-full bg-white/5 blur-2xl pointer-events-none"></div>
            <div class="absolute right-1/3 -bottom-20 w-56 h-56 rounded-full bg-emerald-400/10 blur-xl pointer-events-none"></div>

            <div class="relative z-10 flex flex-col md:flex-row items-center md:items-start gap-6">
                <!-- Logo Display Frame -->
                <div class="w-32 h-32 sm:w-36 sm:h-36 rounded-2xl bg-white p-3 shadow-2xl flex items-center justify-center shrink-0 border border-white/30">
                    @if ($pengaturan->logo && Storage::disk('public')->exists($pengaturan->logo))
                        <img src="{{ asset('storage/' . $pengaturan->logo) }}" alt="Logo" class="max-w-full max-h-full object-contain">
                    @else
                        <div class="text-slate-400 flex flex-col items-center gap-1">
                            <i class="ti ti-building text-4xl"></i>
                            <span class="text-[10px] font-bold">No Logo</span>
                        </div>
                    @endif
                </div>

                <!-- Main Info Details -->
                <div class="flex-1 text-center md:text-left space-y-2.5">
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-2.5">
                        <h2 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                            {{ $pengaturan->nama_sekolah }}
                        </h2>
                        @if ($pengaturan->nama_aplikasi)
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-white/15 text-emerald-200 border border-white/20 backdrop-blur-xs">
                                App: {{ $pengaturan->nama_aplikasi }}
                            </span>
                        @endif
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-500/30 text-emerald-300 border border-emerald-400/30 backdrop-blur-xs flex items-center gap-1">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            Sistem Aktif
                        </span>
                    </div>

                    <p class="text-xs sm:text-sm text-emerald-100/80 leading-relaxed max-w-3xl flex items-center justify-center md:justify-start gap-1.5">
                        <i class="ti ti-map-pin shrink-0 text-emerald-300 text-sm"></i>
                        <span>{{ $pengaturan->alamat_sekolah }}</span>
                    </p>

                    <!-- Quick Metrics Chips -->
                    <div class="pt-2 flex flex-wrap items-center justify-center md:justify-start gap-2">
                        @if ($pengaturan->telepon)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-white/10 text-emerald-100 text-xs border border-white/15">
                                <i class="ti ti-phone text-emerald-300"></i> {{ $pengaturan->telepon }}
                            </span>
                        @endif
                        @if ($pengaturan->email)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-white/10 text-emerald-100 text-xs border border-white/15">
                                <i class="ti ti-mail text-emerald-300"></i> {{ $pengaturan->email }}
                            </span>
                        @endif
                        @if ($pengaturan->website)
                            <a href="{{ $pengaturan->website }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-emerald-500/30 hover:bg-emerald-500/50 text-white text-xs border border-white/20 transition">
                                <i class="ti ti-world text-emerald-300"></i> {{ $pengaturan->website }}
                            </a>
                        @endif
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-amber-500/20 text-amber-200 text-xs border border-amber-400/20">
                            <i class="ti ti-clock text-amber-300"></i> Session: {{ $pengaturan->session_lifetime ?? 120 }} Menit
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= 3. DETAILS GRID SECTIONS ================= -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Left: Kontak & Informasi Lembaga (2 Cols on LG) -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Info Lembaga Card -->
                <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
                    <div class="bg-emerald-600 px-5 py-3.5 flex items-center justify-between text-white">
                        <div class="flex items-center gap-2.5">
                            <i class="ti ti-info-circle text-lg"></i>
                            <h3 class="font-extrabold text-sm tracking-tight text-white">Identitas & Informasi Kontak</h3>
                        </div>
                    </div>

                    <div class="p-5 sm:p-6 divide-y divide-slate-100 text-xs">
                        <div class="py-3 first:pt-0 grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-4">
                            <span class="font-bold text-slate-500 flex items-center gap-2">
                                <i class="ti ti-layout-grid text-emerald-600"></i> Nama Aplikasi
                            </span>
                            <span class="sm:col-span-2 font-bold text-slate-900">
                                {{ $pengaturan->nama_aplikasi ?? '-' }}
                            </span>
                        </div>
                        <div class="py-3 grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-4">
                            <span class="font-bold text-slate-500 flex items-center gap-2">
                                <i class="ti ti-building text-emerald-600"></i> Nama Lembaga
                            </span>
                            <span class="sm:col-span-2 font-bold text-slate-900">
                                {{ $pengaturan->nama_sekolah }}
                            </span>
                        </div>
                        <div class="py-3 grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-4">
                            <span class="font-bold text-slate-500 flex items-center gap-2">
                                <i class="ti ti-map-pin text-emerald-600"></i> Alamat Lengkap
                            </span>
                            <span class="sm:col-span-2 font-semibold text-slate-700 leading-relaxed">
                                {{ $pengaturan->alamat_sekolah }}
                            </span>
                        </div>
                        <div class="py-3 grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-4">
                            <span class="font-bold text-slate-500 flex items-center gap-2">
                                <i class="ti ti-phone text-emerald-600"></i> Nomor Telepon
                            </span>
                            <span class="sm:col-span-2 font-semibold text-slate-800">
                                {{ $pengaturan->telepon ?: '-' }}
                            </span>
                        </div>
                        <div class="py-3 grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-4">
                            <span class="font-bold text-slate-500 flex items-center gap-2">
                                <i class="ti ti-mail text-emerald-600"></i> Email Resmi
                            </span>
                            <span class="sm:col-span-2 font-semibold text-slate-800">
                                {{ $pengaturan->email ?: '-' }}
                            </span>
                        </div>
                        <div class="py-3 grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-4">
                            <span class="font-bold text-slate-500 flex items-center gap-2">
                                <i class="ti ti-world text-emerald-600"></i> Website
                            </span>
                            <span class="sm:col-span-2 font-semibold text-slate-800">
                                @if($pengaturan->website)
                                    <a href="{{ $pengaturan->website }}" target="_blank" class="text-emerald-700 hover:underline font-bold">
                                        {{ $pengaturan->website }}
                                    </a>
                                @else
                                    -
                                @endif
                            </span>
                        </div>
                        <div class="py-3 last:pb-0 grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-4">
                            <span class="font-bold text-slate-500 flex items-center gap-2">
                                <i class="ti ti-shield-lock text-emerald-600"></i> Session Timeout
                            </span>
                            <span class="sm:col-span-2">
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-lg text-xs font-bold bg-amber-50 text-amber-800 border border-amber-200">
                                    <i class="ti ti-clock text-sm"></i> {{ $pengaturan->session_lifetime ?? 120 }} Menit (Auto Logout)
                                </span>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Media Sosial Card -->
                <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
                    <div class="bg-emerald-600 px-5 py-3.5 flex items-center justify-between text-white">
                        <div class="flex items-center gap-2.5">
                            <i class="ti ti-share text-lg"></i>
                            <h3 class="font-extrabold text-sm tracking-tight text-white">Tautan Media Sosial Resmi</h3>
                        </div>
                    </div>

                    <div class="p-5 sm:p-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Facebook -->
                        <div class="p-3.5 rounded-xl border border-slate-200/80 bg-slate-50/50 flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center text-xl shrink-0 shadow-2xs">
                                <i class="ti ti-brand-facebook"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <span class="block text-[11px] font-bold text-slate-400 uppercase">Facebook</span>
                                @if ($pengaturan->facebook)
                                    <a href="{{ $pengaturan->facebook }}" target="_blank" class="text-xs font-bold text-blue-700 hover:underline truncate block">
                                        {{ $pengaturan->facebook }}
                                    </a>
                                @else
                                    <span class="text-xs text-slate-400 font-medium">Belum diatur</span>
                                @endif
                            </div>
                        </div>

                        <!-- Instagram -->
                        <div class="p-3.5 rounded-xl border border-slate-200/80 bg-slate-50/50 flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-amber-500 via-rose-500 to-purple-600 text-white flex items-center justify-center text-xl shrink-0 shadow-2xs">
                                <i class="ti ti-brand-instagram"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <span class="block text-[11px] font-bold text-slate-400 uppercase">Instagram</span>
                                @if ($pengaturan->instagram)
                                    <a href="{{ $pengaturan->instagram }}" target="_blank" class="text-xs font-bold text-rose-700 hover:underline truncate block">
                                        {{ $pengaturan->instagram }}
                                    </a>
                                @else
                                    <span class="text-xs text-slate-400 font-medium">Belum diatur</span>
                                @endif
                            </div>
                        </div>

                        <!-- YouTube -->
                        <div class="p-3.5 rounded-xl border border-slate-200/80 bg-slate-50/50 flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-red-600 text-white flex items-center justify-center text-xl shrink-0 shadow-2xs">
                                <i class="ti ti-brand-youtube"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <span class="block text-[11px] font-bold text-slate-400 uppercase">YouTube Channel</span>
                                @if ($pengaturan->youtube)
                                    <a href="{{ $pengaturan->youtube }}" target="_blank" class="text-xs font-bold text-red-700 hover:underline truncate block">
                                        {{ $pengaturan->youtube }}
                                    </a>
                                @else
                                    <span class="text-xs text-slate-400 font-medium">Belum diatur</span>
                                @endif
                            </div>
                        </div>

                        <!-- TikTok -->
                        <div class="p-3.5 rounded-xl border border-slate-200/80 bg-slate-50/50 flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center text-xl shrink-0 shadow-2xs">
                                <i class="ti ti-brand-tiktok"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <span class="block text-[11px] font-bold text-slate-400 uppercase">TikTok</span>
                                @if ($pengaturan->tiktok)
                                    <a href="{{ $pengaturan->tiktok }}" target="_blank" class="text-xs font-bold text-slate-900 hover:underline truncate block">
                                        {{ $pengaturan->tiktok }}
                                    </a>
                                @else
                                    <span class="text-xs text-slate-400 font-medium">Belum diatur</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Visual Branding & Assets (1 Col on LG) -->
            <div class="space-y-6">
                <!-- Background Login Preview -->
                <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
                    <div class="bg-emerald-600 px-5 py-3.5 flex items-center justify-between text-white">
                        <div class="flex items-center gap-2">
                            <i class="ti ti-wallpaper text-lg"></i>
                            <h3 class="font-extrabold text-sm tracking-tight text-white">Background Login</h3>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="relative w-full h-40 rounded-xl overflow-hidden bg-slate-100 border border-slate-200 shadow-inner flex items-center justify-center">
                            @if ($pengaturan->background_login && Storage::disk('public')->exists($pengaturan->background_login))
                                <img src="{{ asset('storage/' . $pengaturan->background_login) }}" alt="Background Login" class="w-full h-full object-cover">
                            @else
                                <div class="text-center text-slate-400">
                                    <i class="ti ti-photo-off text-3xl mb-1 block"></i>
                                    <span class="text-xs font-semibold">Menggunakan default background</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Model Hero Photos Preview -->
                <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
                    <div class="bg-emerald-600 px-5 py-3.5 flex items-center justify-between text-white">
                        <div class="flex items-center gap-2">
                            <i class="ti ti-users text-lg"></i>
                            <h3 class="font-extrabold text-sm tracking-tight text-white">Foto Model Hero</h3>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="grid grid-cols-2 gap-3">
                            @for ($i = 1; $i <= 4; $i++)
                                @php $field = 'model_' . $i; @endphp
                                <div class="relative aspect-4/3 rounded-xl overflow-hidden bg-slate-100 border border-slate-200 flex items-center justify-center group">
                                    @if ($pengaturan->$field && Storage::disk('public')->exists($pengaturan->$field))
                                        <img src="{{ asset('storage/' . $pengaturan->$field) }}" alt="Model {{ $i }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                        <span class="absolute bottom-1.5 left-1.5 px-2 py-0.5 rounded-md bg-black/60 text-[10px] font-bold text-white backdrop-blur-xs">
                                            Model {{ $i }}
                                        </span>
                                    @else
                                        <div class="text-center text-slate-400">
                                            <i class="ti ti-user text-xl"></i>
                                            <span class="text-[10px] font-bold block">Model {{ $i }}</span>
                                        </div>
                                    @endif
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>

                <!-- Quick Danger Zone / Reset -->
                <div class="bg-rose-50 border border-rose-200/80 rounded-2xl p-4 text-xs space-y-3">
                    <div class="flex items-center gap-2 text-rose-800 font-black">
                        <i class="ti ti-alert-triangle text-base"></i>
                        <span>Zona Pengaturan Lanjutan</span>
                    </div>
                    <p class="text-rose-700/80 leading-relaxed text-[11px]">
                        Menghapus data konfigurasi ini akan mengembalikan setelan identitas sistem ke nilai bawaan.
                    </p>
                    <form action="{{ route('pengaturan-umum.destroy', $pengaturan->id) }}" method="POST" class="deleteform">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full py-2.5 px-3 bg-white hover:bg-rose-100 text-rose-700 font-bold rounded-xl border border-rose-300 shadow-2xs transition active:scale-95 flex items-center justify-center gap-2 cursor-pointer delete-confirm">
                            <i class="ti ti-trash text-sm"></i>
                            <span>Hapus Konfigurasi Ini</span>
                        </button>
                    </form>
                </div>
            </div>

        </div>
    @else
        <!-- ================= EMPTY STATE ================= -->
        <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm p-10 text-center max-w-xl mx-auto my-12 space-y-4">
            <div class="w-20 h-20 rounded-3xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-4xl mx-auto border border-emerald-200/80 shadow-inner">
                <i class="ti ti-settings-cog"></i>
            </div>
            <div class="space-y-1">
                <h3 class="text-lg font-black text-slate-900">Belum Ada Pengaturan Sistem</h3>
                <p class="text-xs text-slate-500 leading-relaxed max-w-md mx-auto">
                    Inisialisasi pengaturan umum pertama untuk mengonfigurasi identitas lembaga, logo resmi, durasi session login, dan media sosial.
                </p>
            </div>
            <div class="pt-2">
                <a href="{{ route('pengaturan-umum.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold rounded-2xl text-xs shadow-md shadow-emerald-600/20 transition active:scale-95">
                    <i class="ti ti-plus text-base"></i>
                    <span>Buat Konfigurasi Sekarang</span>
                </a>
            </div>
        </div>
    @endif

</div>
@endsection

@push('myscript')
<script>
    $(function() {
        $(".delete-confirm").click(function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Menghapus pengaturan ini akan mengembalikan ke setelan default sistem!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#059669',
                cancelButtonColor: '#e11d48',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    confirmButton: 'rounded-xl font-bold px-4 py-2',
                    cancelButton: 'rounded-xl font-bold px-4 py-2'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush


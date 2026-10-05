@extends('layouts.app')
@section('titlepage', 'Tambah Pengaturan Umum')

@section('content')
<div class="space-y-6 pb-24">

    <!-- ================= 1. PAGE HEADER WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center border border-emerald-200/80 shadow-2xs">
                    <i class="ti ti-settings text-2xl"></i>
                </div>
                <span>Inisialisasi Pengaturan Umum</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Atur identitas lembaga, konfigurasi branding, media sosial, dan aset visual aplikasi pertama kali
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
                <span class="font-bold text-slate-800">Tambah</span>
            </nav>

            <a href="{{ route('pengaturan-umum.index') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white hover:bg-slate-50 text-slate-700 font-bold rounded-xl text-xs border border-slate-200 shadow-2xs transition active:scale-95">
                <i class="ti ti-arrow-left text-sm"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <!-- ================= 2. CREATE FORM ================= -->
    <form action="{{ route('pengaturan-umum.store') }}" method="POST" enctype="multipart/form-data" id="formCreatePengaturan" class="space-y-6">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Left: Main Settings (2 Columns on LG) -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Section 1: Dasar & Kontak -->
                <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
                    <div class="bg-emerald-600 px-5 py-3.5 flex items-center justify-between text-white">
                        <div class="flex items-center gap-2.5">
                            <i class="ti ti-building text-lg"></i>
                            <h3 class="font-extrabold text-sm tracking-tight text-white">Informasi Dasar & Kontak</h3>
                        </div>
                        <span class="text-[11px] font-bold text-emerald-100/80 bg-white/10 px-2.5 py-0.5 rounded-full border border-white/15">
                            Identitas Utama
                        </span>
                    </div>

                    <div class="p-5 sm:p-6 space-y-4 text-xs">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Nama Aplikasi -->
                            <div>
                                <label for="nama_aplikasi" class="block text-xs font-bold text-slate-700 mb-1.5">
                                    Nama Aplikasi Sistem
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                                        <i class="ti ti-device-laptop text-base"></i>
                                    </span>
                                    <input type="text" id="nama_aplikasi" name="nama_aplikasi" 
                                        value="{{ old('nama_aplikasi', 'SIPREN PAS') }}"
                                        class="w-full pl-10 pr-3.5 py-2.5 bg-slate-50/70 border border-slate-300/90 rounded-xl text-xs font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition"
                                        placeholder="Contoh: SIPREN PAS...">
                                </div>
                                @error('nama_aplikasi')<p class="text-[11px] text-rose-500 mt-1 font-semibold">{{ $message }}</p>@enderror
                            </div>

                            <!-- Nama Lembaga -->
                            <div>
                                <label for="nama_sekolah" class="block text-xs font-bold text-slate-700 mb-1.5">
                                    Nama Lembaga / Pesantren <span class="text-rose-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                                        <i class="ti ti-building text-base"></i>
                                    </span>
                                    <input type="text" id="nama_sekolah" name="nama_sekolah" required
                                        value="{{ old('nama_sekolah') }}"
                                        class="w-full pl-10 pr-3.5 py-2.5 bg-slate-50/70 border border-slate-300/90 rounded-xl text-xs font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition"
                                        placeholder="Contoh: Pondok Pesantren Al Amin...">
                                </div>
                                @error('nama_sekolah')<p class="text-[11px] text-rose-500 mt-1 font-semibold">{{ $message }}</p>@enderror
                            </div>

                            <!-- Telepon -->
                            <div>
                                <label for="telepon" class="block text-xs font-bold text-slate-700 mb-1.5">
                                    Nomor Telepon
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                                        <i class="ti ti-phone text-base"></i>
                                    </span>
                                    <input type="text" id="telepon" name="telepon" 
                                        value="{{ old('telepon') }}"
                                        class="w-full pl-10 pr-3.5 py-2.5 bg-slate-50/70 border border-slate-300/90 rounded-xl text-xs font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition"
                                        placeholder="Contoh: (021) 1234567 atau 0812...">
                                </div>
                                @error('telepon')<p class="text-[11px] text-rose-500 mt-1 font-semibold">{{ $message }}</p>@enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-xs font-bold text-slate-700 mb-1.5">
                                    Alamat Email Resmi
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                                        <i class="ti ti-mail text-base"></i>
                                    </span>
                                    <input type="email" id="email" name="email" 
                                        value="{{ old('email') }}"
                                        class="w-full pl-10 pr-3.5 py-2.5 bg-slate-50/70 border border-slate-300/90 rounded-xl text-xs font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition"
                                        placeholder="Contoh: info@alamin.sch.id">
                                </div>
                                @error('email')<p class="text-[11px] text-rose-500 mt-1 font-semibold">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <!-- Website -->
                        <div>
                            <label for="website" class="block text-xs font-bold text-slate-700 mb-1.5">
                                Website Resmi
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                                    <i class="ti ti-world text-base"></i>
                                </span>
                                <input type="url" id="website" name="website" 
                                    value="{{ old('website') }}"
                                    class="w-full pl-10 pr-3.5 py-2.5 bg-slate-50/70 border border-slate-300/90 rounded-xl text-xs font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition"
                                    placeholder="https://alamin.sch.id">
                            </div>
                            @error('website')<p class="text-[11px] text-rose-500 mt-1 font-semibold">{{ $message }}</p>@enderror
                        </div>

                        <!-- Alamat Lengkap -->
                        <div>
                            <label for="alamat_sekolah" class="block text-xs font-bold text-slate-700 mb-1.5">
                                Alamat Lengkap Lembaga <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <textarea id="alamat_sekolah" name="alamat_sekolah" rows="3" required
                                    class="w-full p-3 bg-slate-50/70 border border-slate-300/90 rounded-xl text-xs font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition"
                                    placeholder="Tuliskan alamat lengkap jalan, nomor, kelurahan, kecamatan, kota/kabupaten...">{{ old('alamat_sekolah') }}</textarea>
                            </div>
                            @error('alamat_sekolah')<p class="text-[11px] text-rose-500 mt-1 font-semibold">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <!-- Section 2: Media Sosial -->
                <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
                    <div class="bg-emerald-600 px-5 py-3.5 flex items-center justify-between text-white">
                        <div class="flex items-center gap-2.5">
                            <i class="ti ti-share text-lg"></i>
                            <h3 class="font-extrabold text-sm tracking-tight text-white">Tautan Media Sosial</h3>
                        </div>
                    </div>

                    <div class="p-5 sm:p-6 space-y-4 text-xs">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Facebook -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Facebook URL</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-blue-600">
                                        <i class="ti ti-brand-facebook text-base"></i>
                                    </span>
                                    <input type="url" name="facebook" value="{{ old('facebook') }}"
                                        class="w-full pl-10 pr-3.5 py-2.5 bg-slate-50/70 border border-slate-300/90 rounded-xl text-xs font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition"
                                        placeholder="https://facebook.com/...">
                                </div>
                            </div>

                            <!-- Instagram -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Instagram URL</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-rose-500">
                                        <i class="ti ti-brand-instagram text-base"></i>
                                    </span>
                                    <input type="url" name="instagram" value="{{ old('instagram') }}"
                                        class="w-full pl-10 pr-3.5 py-2.5 bg-slate-50/70 border border-slate-300/90 rounded-xl text-xs font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition"
                                        placeholder="https://instagram.com/...">
                                </div>
                            </div>

                            <!-- YouTube -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">YouTube Channel</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-red-600">
                                        <i class="ti ti-brand-youtube text-base"></i>
                                    </span>
                                    <input type="url" name="youtube" value="{{ old('youtube') }}"
                                        class="w-full pl-10 pr-3.5 py-2.5 bg-slate-50/70 border border-slate-300/90 rounded-xl text-xs font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition"
                                        placeholder="https://youtube.com/@...">
                                </div>
                            </div>

                            <!-- TikTok -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">TikTok Profile</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-900">
                                        <i class="ti ti-brand-tiktok text-base"></i>
                                    </span>
                                    <input type="url" name="tiktok" value="{{ old('tiktok') }}"
                                        class="w-full pl-10 pr-3.5 py-2.5 bg-slate-50/70 border border-slate-300/90 rounded-xl text-xs font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition"
                                        placeholder="https://tiktok.com/@...">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Keamanan & Sesi -->
                <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
                    <div class="bg-emerald-600 px-5 py-3.5 flex items-center justify-between text-white">
                        <div class="flex items-center gap-2.5">
                            <i class="ti ti-shield-lock text-lg"></i>
                            <h3 class="font-extrabold text-sm tracking-tight text-white">Sesi & Keamanan Pengguna</h3>
                        </div>
                    </div>

                    <div class="p-5 sm:p-6 space-y-3 text-xs">
                        <div>
                            <label for="session_lifetime" class="block text-xs font-bold text-slate-700 mb-1.5">
                                Durasi Timeout Sesi Login (Menit) <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative w-full sm:w-64">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                                    <i class="ti ti-clock text-base"></i>
                                </span>
                                <input type="number" id="session_lifetime" name="session_lifetime" min="1" required
                                    value="{{ old('session_lifetime', 120) }}"
                                    class="w-full pl-10 pr-16 py-2.5 bg-slate-50/70 border border-slate-300/90 rounded-xl text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                                <span class="absolute inset-y-0 right-0 flex items-center pr-3.5 pointer-events-none text-slate-400 font-bold text-[11px]">
                                    Menit
                                </span>
                            </div>
                            <p class="text-[11px] text-slate-500 mt-1.5">
                                <i class="ti ti-info-circle text-emerald-600"></i> Pengguna akan logout otomatis jika tidak ada aktivitas dalam durasi ini (Bawaan: 120 Menit).
                            </p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right: Assets & Media (1 Column on LG) -->
            <div class="space-y-6">

                <!-- Logo Uploader Card -->
                <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
                    <div class="bg-emerald-600 px-5 py-3.5 flex items-center justify-between text-white">
                        <div class="flex items-center gap-2">
                            <i class="ti ti-photo text-lg"></i>
                            <h3 class="font-extrabold text-sm tracking-tight text-white">Logo Lembaga</h3>
                        </div>
                    </div>

                    <div class="p-5 text-center space-y-3">
                        <div class="w-32 h-32 mx-auto rounded-2xl bg-slate-50 border-2 border-dashed border-slate-200 p-3 flex items-center justify-center overflow-hidden">
                            <div class="text-slate-400">
                                <i class="ti ti-photo text-3xl"></i>
                                <p class="text-[10px] font-bold mt-1">Upload Logo</p>
                            </div>
                        </div>
                        <input type="file" name="logo" accept="image/*"
                            class="block w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3.5 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer">
                        <p class="text-[10px] text-slate-400">Format: PNG, JPG, WEBP (Maks: 2MB)</p>
                    </div>
                </div>

                <!-- Background Login Uploader Card -->
                <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
                    <div class="bg-emerald-600 px-5 py-3.5 flex items-center justify-between text-white">
                        <div class="flex items-center gap-2">
                            <i class="ti ti-wallpaper text-lg"></i>
                            <h3 class="font-extrabold text-sm tracking-tight text-white">Background Login</h3>
                        </div>
                    </div>

                    <div class="p-5 text-center space-y-3">
                        <div class="w-full h-28 rounded-xl bg-slate-50 border-2 border-dashed border-slate-200 flex items-center justify-center overflow-hidden">
                            <div class="text-slate-400">
                                <i class="ti ti-wallpaper text-3xl"></i>
                                <p class="text-[10px] font-bold mt-1">Upload Wallpaper</p>
                            </div>
                        </div>
                        <input type="file" name="background_login" accept="image/*"
                            class="block w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3.5 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer">
                        <p class="text-[10px] text-slate-400">Format: JPG, PNG, WEBP (Maks: 4MB)</p>
                    </div>
                </div>

                <!-- Foto Model Hero Section -->
                <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
                    <div class="bg-emerald-600 px-5 py-3.5 flex items-center justify-between text-white">
                        <div class="flex items-center gap-2">
                            <i class="ti ti-users text-lg"></i>
                            <h3 class="font-extrabold text-sm tracking-tight text-white">Foto Model Hero</h3>
                        </div>
                    </div>

                    <div class="p-5 space-y-4">
                        <div class="grid grid-cols-2 gap-3">
                            @for ($i = 1; $i <= 4; $i++)
                                @php $field = 'model_' . $i; @endphp
                                <div class="p-2.5 bg-slate-50/70 border border-slate-200/80 rounded-xl space-y-2">
                                    <span class="block text-[11px] font-bold text-slate-700">Model {{ $i }}</span>
                                    <div class="w-full h-16 rounded-lg bg-white border border-slate-200 flex items-center justify-center overflow-hidden">
                                        <i class="ti ti-user text-slate-300 text-xl"></i>
                                    </div>
                                    <input type="file" name="{{ $field }}" accept="image/*"
                                        class="block w-full text-[10px] text-slate-500 file:mr-1.5 file:py-1 file:px-2 file:rounded-md file:border-0 file:text-[10px] file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer">
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <!-- Floating Sticky Action Bar -->
        <div class="fixed bottom-4 left-4 right-4 md:left-72 z-40">
            <div class="max-w-5xl mx-auto bg-slate-900/90 text-white backdrop-blur-xl border border-white/10 rounded-2xl p-3.5 sm:px-6 shadow-2xl flex items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center border border-emerald-500/30 shrink-0">
                        <i class="ti ti-adjustments-plus text-xl"></i>
                    </div>
                    <div class="hidden sm:block">
                        <div class="text-xs font-bold text-white">Simpan Pengaturan Sistem</div>
                        <div class="text-[11px] text-slate-400">Pastikan informasi identitas lembaga telah terisi dengan benar</div>
                    </div>
                </div>

                <div class="flex items-center gap-2.5 w-full sm:w-auto justify-end">
                    <a href="{{ route('pengaturan-umum.index') }}" class="px-4 py-2 bg-white/10 hover:bg-white/20 text-slate-200 font-bold rounded-xl text-xs transition">
                        Batal
                    </a>
                    <button type="submit" id="btnSubmitPengaturan" class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white font-extrabold text-xs rounded-xl shadow-lg shadow-emerald-500/30 transition active:scale-95 cursor-pointer border-0">
                        <i class="ti ti-device-floppy text-base"></i>
                        <span>Simpan Pengaturan</span>
                    </button>
                </div>
            </div>
        </div>

    </form>
</div>
@endsection

@push('myscript')
<script>
    $(function() {
        $("#formCreatePengaturan").submit(function() {
            $("#btnSubmitPengaturan").prop("disabled", true).html('<i class="ti ti-loader animate-spin text-base"></i> Menyimpan...');
        });
    });
</script>
@endpush

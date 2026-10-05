@extends('layouts.app')
@section('titlepage', 'Setting Landing Page - ' . $unit->nama_unit)

@push('styles')
<style>
    /* Styling Standar Admin Dashboard Profesional - Tailwind Emerald Theme */
    .landing-sidebar-col {
        position: sticky !important;
        top: 85px !important;
        z-index: 40 !important;
        align-self: flex-start !important;
    }

    .nav-landing-menu .nav-link {
        display: flex !important;
        align-items: center !important;
        justify-content: flex-start !important;
        text-align: left !important;
        gap: 12px;
        padding: 10px 14px !important;
        font-size: 0.8125rem;
        font-weight: 600;
        color: #475569;
        border-radius: 0.75rem;
        border: 1px solid transparent;
        transition: all 0.2s ease;
        width: 100%;
        box-shadow: none !important;
        background: transparent;
        cursor: pointer;
    }
    .nav-landing-menu .nav-link i {
        font-size: 1.15rem;
        color: #94a3b8;
        flex-shrink: 0;
        line-height: 1;
        width: 20px;
        text-align: center;
        transition: color 0.2s ease;
    }
    .nav-landing-menu .nav-link span {
        flex: 1;
        text-align: left !important;
    }
    .nav-landing-menu .nav-link:hover {
        background-color: #f1f5f9 !important;
        color: #0f172a !important;
    }
    .nav-landing-menu .nav-link:hover i {
        color: #059669 !important;
    }
    .nav-landing-menu .nav-link.active {
        background-color: #059669 !important;
        color: #ffffff !important;
        font-weight: 700 !important;
        box-shadow: 0 4px 6px -1px rgba(5, 150, 105, 0.2) !important;
    }
    .nav-landing-menu .nav-link.active i {
        color: #ffffff !important;
    }
    
    .dynamic-item-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 1rem;
        transition: all 0.2s ease;
    }
    .dynamic-item-card:hover {
        border-color: #cbd5e1;
        box-shadow: 0 4px 12px -2px rgba(0, 0, 0, 0.05);
    }
</style>
@endpush

@section('content')
<div class="space-y-6 pb-24">

    <!-- ================= 1. PAGE HEADER & BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center border border-emerald-200/80 shadow-2xs">
                    <i class="ti ti-browser text-2xl"></i>
                </div>
                <span>Pengaturan Landing Page Unit</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Kustomisasi konten, banner visual, foto sarana prasarana & ulasan santri untuk unit <strong class="text-slate-800 font-bold">{{ $unit->nama_unit }}</strong>
            </p>
        </div>

        <!-- Right: Breadcrumbs & Action -->
        <div class="flex flex-col md:items-end gap-2.5">
            <nav class="flex items-center text-xs text-slate-400 font-medium">
                <a href="{{ route('dashboard.index') }}" class="hover:text-slate-700 transition flex items-center gap-1">
                    <i class="ti ti-home text-sm"></i>
                    <span>Dashboard</span>
                </a>
                @can('unit.index')
                    <span class="mx-2 text-slate-300">/</span>
                    <a href="{{ route('unit.index') }}" class="hover:text-slate-700 transition">
                        Data Master Unit
                    </a>
                @endcan
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Setting Landing</span>
            </nav>

            @can('unit.index')
                <a href="{{ route('unit.index') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white hover:bg-slate-50 text-slate-700 font-bold rounded-xl text-xs border border-slate-200 shadow-2xs transition active:scale-95">
                    <i class="ti ti-arrow-left text-sm"></i>
                    <span>Kembali ke Unit</span>
                </a>
            @else
                <a href="{{ route('dashboard.index') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white hover:bg-slate-50 text-slate-700 font-bold rounded-xl text-xs border border-slate-200 shadow-2xs transition active:scale-95">
                    <i class="ti ti-arrow-left text-sm"></i>
                    <span>Kembali ke Dashboard</span>
                </a>
            @endcan
        </div>
    </div>

    <!-- ================= 2. MAIN FORM ================= -->
    <form action="{{ route('unit.update-landing-setting', Crypt::encrypt($unit->kode_unit)) }}" method="POST" enctype="multipart/form-data" id="formLandingSetting">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            
            <!-- Sidebar Navigation Tabs (4 Cols on LG) -->
            <div class="lg:col-span-4 xl:col-span-3 landing-sidebar-col space-y-4">
                <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
                    
                    <!-- Unit Profile Card in Sidebar -->
                    <div class="p-4 bg-slate-50/70 border-b border-slate-200/80 flex items-center gap-3">
                        @if ($unit->logo && Storage::disk('public')->exists($unit->logo))
                            <div class="w-10 h-10 rounded-xl bg-white p-1 border border-slate-200 flex items-center justify-center shrink-0 shadow-2xs">
                                <img src="{{ asset('storage/' . $unit->logo) }}" alt="Logo" class="w-full h-full object-contain">
                            </div>
                        @else
                            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0 border border-emerald-200 shadow-2xs font-black text-xs">
                                <i class="ti ti-building-community text-xl"></i>
                            </div>
                        @endif
                        <div class="min-w-0 flex-1">
                            <span class="inline-block px-2 py-0.5 text-[10px] font-mono font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-md">
                                {{ $unit->kode_unit }}
                            </span>
                            <div class="font-bold text-slate-900 text-xs truncate mt-0.5" title="{{ $unit->nama_unit }}">
                                {{ $unit->nama_unit }}
                            </div>
                        </div>
                    </div>

                    <!-- Tab Navigation Menu -->
                    <div class="p-2.5 nav nav-pills nav-landing-menu flex flex-col gap-1" id="landingTab" role="tablist">
                        <button class="nav-link active" id="hero-tab" data-bs-toggle="pill" data-bs-target="#tab-hero" type="button" role="tab">
                            <i class="ti ti-device-laptop"></i>
                            <span>Hero & Visual Model</span>
                        </button>
                        <button class="nav-link" id="stats-tab" data-bs-toggle="pill" data-bs-target="#tab-stats" type="button" role="tab">
                            <i class="ti ti-chart-bar"></i>
                            <span>Statistik & Angka</span>
                        </button>
                        <button class="nav-link" id="prakata-tab" data-bs-toggle="pill" data-bs-target="#tab-prakata" type="button" role="tab">
                            <i class="ti ti-user-check"></i>
                            <span>Prakata Pimpinan</span>
                        </button>
                        <button class="nav-link" id="program-tab" data-bs-toggle="pill" data-bs-target="#tab-program" type="button" role="tab">
                            <i class="ti ti-stars"></i>
                            <span>Program Unggulan</span>
                        </button>
                        <button class="nav-link" id="fasilitas-tab" data-bs-toggle="pill" data-bs-target="#tab-fasilitas" type="button" role="tab">
                            <i class="ti ti-building"></i>
                            <span>Fasilitas & Foto</span>
                        </button>
                        <button class="nav-link" id="testimoni-tab" data-bs-toggle="pill" data-bs-target="#tab-testimoni" type="button" role="tab">
                            <i class="ti ti-message-2"></i>
                            <span>Testimoni & Avatar</span>
                        </button>
                        <button class="nav-link" id="cta-tab" data-bs-toggle="pill" data-bs-target="#tab-cta" type="button" role="tab">
                            <i class="ti ti-speakerphone"></i>
                            <span>Banner CTA & Kontak</span>
                        </button>
                    </div>

                    <!-- Sidebar Save & Action Footer -->
                    <div class="p-3.5 bg-slate-50 border-t border-slate-200/80 space-y-2">
                        <button type="submit" class="w-full py-2.5 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center justify-center gap-2 cursor-pointer active:scale-95">
                            <i class="ti ti-device-floppy text-base"></i>
                            <span>Simpan Perubahan</span>
                        </button>
                        @can('unit.index')
                            <a href="{{ route('unit.index') }}" class="w-full py-2 px-4 bg-white hover:bg-slate-100 text-slate-700 font-bold text-xs rounded-xl border border-slate-200 shadow-2xs transition flex items-center justify-center gap-1.5 active:scale-95">
                                <i class="ti ti-arrow-left text-sm"></i>
                                <span>Kembali ke Unit</span>
                            </a>
                        @else
                            <a href="{{ route('dashboard.index') }}" class="w-full py-2 px-4 bg-white hover:bg-slate-100 text-slate-700 font-bold text-xs rounded-xl border border-slate-200 shadow-2xs transition flex items-center justify-center gap-1.5 active:scale-95">
                                <i class="ti ti-arrow-left text-sm"></i>
                                <span>Kembali ke Dashboard</span>
                            </a>
                        @endcan
                    </div>
                </div>
            </div>

            <!-- Tab Content Area (8 Cols on LG) -->
            <div class="lg:col-span-8 xl:col-span-9">
                <div class="tab-content" id="landingTabContent">

                    <!-- ================= TAB 1: HERO & MODEL ================= -->
                    <div class="tab-pane fade show active" id="tab-hero" role="tabpanel">
                        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
                            <div class="bg-emerald-600 px-5 py-3.5 flex items-center justify-between text-white">
                                <div class="flex items-center gap-2.5">
                                    <i class="ti ti-device-laptop text-lg"></i>
                                    <h3 class="font-extrabold text-sm tracking-tight text-white">Hero Section & Visual Model</h3>
                                </div>
                                <span class="text-[11px] font-bold text-emerald-100/90 bg-white/15 px-2.5 py-0.5 rounded-full border border-white/20">
                                    Bagian Teratas Web
                                </span>
                            </div>

                            <div class="p-5 sm:p-6 space-y-5 text-xs">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Hero Tag / Kategori Kecil</label>
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                                            <i class="ti ti-tag text-base"></i>
                                        </span>
                                        <input type="text" class="w-full pl-10 pr-3.5 py-2.5 bg-slate-50/70 border border-slate-300 rounded-xl text-xs font-semibold text-slate-800 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                               name="hero_tag" value="{{ old('hero_tag', $setting->hero_tag) }}" placeholder="Contoh: Pendidikan Anak Usia Dini Berkarakter Islami">
                                    </div>
                                    <p class="text-[11px] text-slate-400 mt-1">Muncul sebagai pill badge di bagian atas headline.</p>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Judul Prefix (Teks Normal)</label>
                                        <input type="text" class="w-full px-3.5 py-2.5 bg-slate-50/70 border border-slate-300 rounded-xl text-xs font-semibold text-slate-800 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                               name="hero_title_prefix" value="{{ old('hero_title_prefix', $setting->hero_title_prefix) }}" placeholder="Contoh: Membentuk Karakter & Potensi">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Judul Highlight (Teks Warna / Aksen)</label>
                                        <input type="text" class="w-full px-3.5 py-2.5 bg-slate-50/70 border border-slate-300 rounded-xl text-xs font-semibold text-slate-800 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                               name="hero_title_highlight" value="{{ old('hero_title_highlight', $setting->hero_title_highlight) }}" placeholder="Contoh: Anak Usia Dini Islami">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Deskripsi Hero</label>
                                    <textarea class="w-full p-3 bg-slate-50/70 border border-slate-300 rounded-xl text-xs font-medium text-slate-800 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                              name="hero_description" rows="3" placeholder="Tuliskan deskripsi memikat mengenai keunggulan unit...">{{ old('hero_description', $setting->hero_description) }}</textarea>
                                </div>

                                <!-- Background Image Hero -->
                                <div class="bg-slate-50/80 rounded-2xl p-4 sm:p-5 border border-slate-200">
                                    <div class="flex items-center gap-2 pb-3 mb-4 border-b border-slate-200">
                                        <i class="ti ti-photo text-emerald-600 text-lg"></i>
                                        <h4 class="font-extrabold text-xs text-slate-800 uppercase tracking-wide">Foto Background Hero Section (Latar Belakang)</h4>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                                        <div class="md:col-span-7 space-y-2">
                                            <label class="block text-xs font-bold text-slate-700">Upload Foto Background Baru (Landscape)</label>
                                            <input type="file" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-xs font-medium text-slate-700 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer" name="hero_background_image" accept="image/*">
                                            <div class="flex items-center gap-2 p-2.5 rounded-xl bg-emerald-50/80 border border-emerald-200/80 text-emerald-800 text-[11px]">
                                                <i class="ti ti-info-circle text-base shrink-0 text-emerald-600"></i>
                                                <span>Disarankan resolusi landscape (min. 1920x1080px). Sistem otomatis mengompresi ke <b>WebP</b>.</span>
                                            </div>
                                        </div>
                                        <div class="md:col-span-5">
                                            <label class="block text-xs font-bold text-slate-700 mb-1.5 text-center md:text-left">Background Aktif</label>
                                            <div class="w-full h-28 rounded-xl bg-white border-2 border-dashed border-slate-200 flex items-center justify-center p-1.5 overflow-hidden">
                                                @if ($setting->hero_background_image && Storage::disk('public')->exists($setting->hero_background_image))
                                                    <img src="{{ asset('storage/' . $setting->hero_background_image) }}" alt="Hero Background" class="w-full h-full object-cover rounded-lg">
                                                @else
                                                    <span class="text-slate-400 text-[11px] flex items-center gap-1"><i class="ti ti-photo-off"></i> Default template</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Visual Model Hero -->
                                <div class="bg-slate-50/80 rounded-2xl p-4 sm:p-5 border border-slate-200">
                                    <div class="flex items-center gap-2 pb-3 mb-4 border-b border-slate-200">
                                        <i class="ti ti-camera text-emerald-600 text-lg"></i>
                                        <h4 class="font-extrabold text-xs text-slate-800 uppercase tracking-wide">Foto Model Hero Siswa / Siswi</h4>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                                        <div class="md:col-span-7 space-y-2">
                                            <label class="block text-xs font-bold text-slate-700">Upload Foto Model Baru (Transparan PNG / WebP)</label>
                                            <input type="file" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-xs font-medium text-slate-700 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer" name="hero_model_image" accept="image/*">
                                            <div class="flex items-center gap-2 p-2.5 rounded-xl bg-emerald-50/80 border border-emerald-200/80 text-emerald-800 text-[11px]">
                                                <i class="ti ti-info-circle text-base shrink-0 text-emerald-600"></i>
                                                <span>Sistem otomatis mengompresi ke <b>WebP kualitas tinggi</b> untuk loading super cepat.</span>
                                            </div>
                                        </div>
                                        <div class="md:col-span-5">
                                            <label class="block text-xs font-bold text-slate-700 mb-1.5 text-center md:text-left">Foto Model Aktif</label>
                                            <div class="w-full h-28 rounded-xl bg-white border-2 border-dashed border-slate-200 flex items-center justify-center p-1.5 overflow-hidden">
                                                @if ($setting->hero_model_image && Storage::disk('public')->exists($setting->hero_model_image))
                                                    <img src="{{ asset('storage/' . $setting->hero_model_image) }}" alt="Hero Model" class="h-full max-w-full object-contain">
                                                @else
                                                    <span class="text-slate-400 text-[11px] flex items-center gap-1"><i class="ti ti-photo-off"></i> Default template</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Badges Floating Hero -->
                                <div class="bg-slate-50/80 rounded-2xl p-4 sm:p-5 border border-slate-200 space-y-3">
                                    <div class="flex items-center gap-2 pb-2 border-b border-slate-200">
                                        <i class="ti ti-sparkles text-amber-500 text-lg"></i>
                                        <h4 class="font-extrabold text-xs text-slate-800 uppercase tracking-wide">Badge Aksen Pendaftaran (Floating Hero)</h4>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                        <div>
                                            <label class="block text-xs font-bold text-slate-700 mb-1">Teks Badge Utama</label>
                                            <input type="text" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-xs font-semibold text-slate-800 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                                   name="hero_badge_text" value="{{ old('hero_badge_text', $setting->hero_badge_text) }}" placeholder="Contoh: Buka Pendaftaran">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-700 mb-1">Subteks Badge</label>
                                            <input type="text" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-xs font-semibold text-slate-800 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                                   name="hero_badge_subtext" value="{{ old('hero_badge_subtext', $setting->hero_badge_subtext) }}" placeholder="Contoh: Tahun Ajaran 2026/2027">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-700 mb-1">Status Badge</label>
                                            <input type="text" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-xs font-semibold text-slate-800 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                                   name="hero_badge_status" value="{{ old('hero_badge_status', $setting->hero_badge_status) }}" placeholder="Contoh: Kuota Terbatas">
                                        </div>
                                    </div>
                                </div>

                                <!-- 3 Feature Cards on Bottom Hero -->
                                <div class="bg-slate-50/80 rounded-2xl p-4 sm:p-5 border border-slate-200 space-y-3">
                                    <div class="pb-2 border-b border-slate-200">
                                        <div class="flex items-center gap-2">
                                            <i class="ti ti-badge text-emerald-600 text-lg"></i>
                                            <h4 class="font-extrabold text-xs text-slate-800 uppercase tracking-wide">3 Kartu Fitur Hero Section (Bawah Tombol CTA)</h4>
                                        </div>
                                        <p class="text-[11px] text-slate-400 mt-0.5">3 pilar poin ringkas yang tampil di baris bawah teks Hero (Contoh: Kurikulum Terpadu, Pendidik Berdedikasi, Lingkungan Kondusif).</p>
                                    </div>

                                    @php
                                        $defaultHeroFeatures = [
                                            ['icon' => 'ti-book', 'title' => 'Kurikulum Terpadu', 'desc' => 'Kemenag & Pesantren'],
                                            ['icon' => 'ti-certificate', 'title' => 'Pendidik Berdedikasi', 'desc' => 'Hufadz & Profesional'],
                                            ['icon' => 'ti-shield-check', 'title' => 'Lingkungan Kondusif', 'desc' => 'Boarding & Full Day'],
                                        ];
                                        $currFeatures = (!empty($setting->hero_features) && count($setting->hero_features) > 0)
                                            ? $setting->hero_features
                                            : $defaultHeroFeatures;
                                    @endphp

                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                        @for($hf = 0; $hf < 3; $hf++)
                                            @php
                                                $fVal = $currFeatures[$hf] ?? ($defaultHeroFeatures[$hf] ?? ['icon' => 'ti-star', 'title' => '', 'desc' => '']);
                                            @endphp
                                            <div class="bg-white rounded-xl p-3.5 border border-slate-200/90 shadow-2xs space-y-2.5">
                                                <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                                                    <span class="px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-700 font-bold text-[10px] font-mono">Fitur {{ $hf + 1 }}</span>
                                                </div>
                                                <div>
                                                    <label class="block text-[11px] font-bold text-slate-600 mb-1">Icon Tabler</label>
                                                    <input type="text" class="w-full px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-xs font-semibold text-slate-800" 
                                                           name="hero_features[{{ $hf }}][icon]" value="{{ old("hero_features.{$hf}.icon", $fVal['icon'] ?? 'ti-star') }}" placeholder="ti-book">
                                                </div>
                                                <div>
                                                    <label class="block text-[11px] font-bold text-slate-600 mb-1">Judul Fitur</label>
                                                    <input type="text" class="w-full px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-xs font-semibold text-slate-800" 
                                                           name="hero_features[{{ $hf }}][title]" value="{{ old("hero_features.{$hf}.title", $fVal['title'] ?? '') }}" placeholder="Contoh: Kurikulum Terpadu">
                                                </div>
                                                <div>
                                                    <label class="block text-[11px] font-bold text-slate-600 mb-1">Subjudul / Keterangan</label>
                                                    <input type="text" class="w-full px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-xs font-medium text-slate-800" 
                                                           name="hero_features[{{ $hf }}][desc]" value="{{ old("hero_features.{$hf}.desc", $fVal['desc'] ?? '') }}" placeholder="Contoh: Kemenag & Pesantren">
                                                </div>
                                            </div>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ================= TAB 2: STATISTIK & ANGKA ================= -->
                    <div class="tab-pane fade" id="tab-stats" role="tabpanel">
                        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
                            <div class="bg-emerald-600 px-5 py-3.5 flex items-center justify-between text-white">
                                <div class="flex items-center gap-2.5">
                                    <i class="ti ti-chart-bar text-lg"></i>
                                    <h3 class="font-extrabold text-sm tracking-tight text-white">Statistik & Highlight Angka</h3>
                                </div>
                                <span class="text-[11px] font-bold text-emerald-100/90 bg-white/15 px-2.5 py-0.5 rounded-full border border-white/20">
                                    Counter Kredibilitas
                                </span>
                            </div>

                            <div class="p-5 sm:p-6 space-y-5 text-xs">
                                <p class="text-xs text-slate-500 font-medium">4 kartu highlight angka di bawah hero section untuk memperkuat citra dan reputasi keunggulan unit.</p>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <!-- Highlight 1 -->
                                    <div class="bg-slate-50/80 rounded-xl p-4 border border-slate-200/90 space-y-3">
                                        <div class="flex items-center gap-2 pb-2 border-b border-slate-200/70">
                                            <span class="w-6 h-6 rounded-md bg-emerald-600 text-white font-black text-xs flex items-center justify-center font-mono">01</span>
                                            <h4 class="font-extrabold text-xs text-slate-800">Highlight 1</h4>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-700 mb-1">Nilai / Angka Highlight</label>
                                            <input type="text" class="w-full px-3.5 py-2 bg-white border border-slate-300 rounded-xl text-xs font-bold text-emerald-700 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                                   name="stat_1_val" value="{{ old('stat_1_val', $setting->stat_1_val) }}" placeholder="Contoh: A / 100%">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-700 mb-1">Keterangan Label</label>
                                            <input type="text" class="w-full px-3.5 py-2 bg-white border border-slate-300 rounded-xl text-xs font-semibold text-slate-800 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                                   name="stat_1_label" value="{{ old('stat_1_label', $setting->stat_1_label) }}" placeholder="Contoh: Akreditasi BAN-SM">
                                        </div>
                                    </div>

                                    <!-- Highlight 2 -->
                                    <div class="bg-slate-50/80 rounded-xl p-4 border border-slate-200/90 space-y-3">
                                        <div class="flex items-center gap-2 pb-2 border-b border-slate-200/70">
                                            <span class="w-6 h-6 rounded-md bg-emerald-600 text-white font-black text-xs flex items-center justify-center font-mono">02</span>
                                            <h4 class="font-extrabold text-xs text-slate-800">Highlight 2</h4>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-700 mb-1">Nilai / Angka Highlight</label>
                                            <input type="text" class="w-full px-3.5 py-2 bg-white border border-slate-300 rounded-xl text-xs font-bold text-emerald-700 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                                   name="stat_2_val" value="{{ old('stat_2_val', $setting->stat_2_val) }}" placeholder="Contoh: 1:10 / 15+">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-700 mb-1">Keterangan Label</label>
                                            <input type="text" class="w-full px-3.5 py-2 bg-white border border-slate-300 rounded-xl text-xs font-semibold text-slate-800 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                                   name="stat_2_label" value="{{ old('stat_2_label', $setting->stat_2_label) }}" placeholder="Contoh: Rasio Guru & Siswa">
                                        </div>
                                    </div>

                                    <!-- Highlight 3 -->
                                    <div class="bg-slate-50/80 rounded-xl p-4 border border-slate-200/90 space-y-3">
                                        <div class="flex items-center gap-2 pb-2 border-b border-slate-200/70">
                                            <span class="w-6 h-6 rounded-md bg-emerald-600 text-white font-black text-xs flex items-center justify-center font-mono">03</span>
                                            <h4 class="font-extrabold text-xs text-slate-800">Highlight 3</h4>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-700 mb-1">Nilai / Angka Highlight</label>
                                            <input type="text" class="w-full px-3.5 py-2 bg-white border border-slate-300 rounded-xl text-xs font-bold text-emerald-700 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                                   name="stat_3_val" value="{{ old('stat_3_val', $setting->stat_3_val) }}" placeholder="Contoh: 30+ / 10+">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-700 mb-1">Keterangan Label</label>
                                            <input type="text" class="w-full px-3.5 py-2 bg-white border border-slate-300 rounded-xl text-xs font-semibold text-slate-800 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                                   name="stat_3_label" value="{{ old('stat_3_label', $setting->stat_3_label) }}" placeholder="Contoh: Program & Kegiatan Seru">
                                        </div>
                                    </div>

                                    <!-- Highlight 4 -->
                                    <div class="bg-slate-50/80 rounded-xl p-4 border border-slate-200/90 space-y-3">
                                        <div class="flex items-center gap-2 pb-2 border-b border-slate-200/70">
                                            <span class="w-6 h-6 rounded-md bg-emerald-600 text-white font-black text-xs flex items-center justify-center font-mono">04</span>
                                            <h4 class="font-extrabold text-xs text-slate-800">Highlight 4</h4>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-700 mb-1">Nilai / Angka Highlight</label>
                                            <input type="text" class="w-full px-3.5 py-2 bg-white border border-slate-300 rounded-xl text-xs font-bold text-emerald-700 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                                   name="stat_4_val" value="{{ old('stat_4_val', $setting->stat_4_val) }}" placeholder="Contoh: 500+ / 98%">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-700 mb-1">Keterangan Label</label>
                                            <input type="text" class="w-full px-3.5 py-2 bg-white border border-slate-300 rounded-xl text-xs font-semibold text-slate-800 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                                   name="stat_4_label" value="{{ old('stat_4_label', $setting->stat_4_label) }}" placeholder="Contoh: Lulusan Berprestasi">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ================= TAB 3: PRAKATA PIMPINAN ================= -->
                    <div class="tab-pane fade" id="tab-prakata" role="tabpanel">
                        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
                            <div class="bg-emerald-600 px-5 py-3.5 flex items-center justify-between text-white">
                                <div class="flex items-center gap-2.5">
                                    <i class="ti ti-user-check text-lg"></i>
                                    <h3 class="font-extrabold text-sm tracking-tight text-white">Prakata Kepala Sekolah / Pimpinan</h3>
                                </div>
                                <span class="text-[11px] font-bold text-emerald-100/90 bg-white/15 px-2.5 py-0.5 rounded-full border border-white/20">
                                    Sambutan Resmi
                                </span>
                            </div>

                            <div class="p-5 sm:p-6 space-y-5 text-xs">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Tag Prakata</label>
                                        <input type="text" class="w-full px-3.5 py-2.5 bg-slate-50/70 border border-slate-300 rounded-xl text-xs font-semibold text-slate-800 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                               name="prakata_tag" value="{{ old('prakata_tag', $setting->prakata_tag) }}" placeholder="Contoh: Sambutan Kepala Sekolah">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Judul Sambutan</label>
                                        <input type="text" class="w-full px-3.5 py-2.5 bg-slate-50/70 border border-slate-300 rounded-xl text-xs font-semibold text-slate-800 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                               name="prakata_title" value="{{ old('prakata_title', $setting->prakata_title) }}" placeholder="Contoh: Membina Fitrah, Menemani Langkah">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Quote Singkat (Highlight Box)</label>
                                    <input type="text" class="w-full px-3.5 py-2.5 bg-slate-50/70 border border-slate-300 rounded-xl text-xs font-semibold text-slate-800 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                           name="prakata_quote" value="{{ old('prakata_quote', $setting->prakata_quote) }}" placeholder="Contoh: Setiap anak adalah amanah berharga yang membawa potensi unik masing-masing.">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Teks Sambutan Lengkap</label>
                                    <textarea class="w-full p-3.5 bg-slate-50/70 border border-slate-300 rounded-xl text-xs font-medium text-slate-800 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                              name="prakata_content" rows="6" placeholder="Tuliskan isi sambutan lengkap kepala sekolah...">{{ old('prakata_content', $setting->prakata_content) }}</textarea>
                                </div>

                                <!-- Foto & Identitas Kepala Sekolah -->
                                <div class="bg-slate-50/80 rounded-2xl p-4 sm:p-5 border border-slate-200">
                                    <div class="flex items-center gap-2 pb-3 mb-4 border-b border-slate-200">
                                        <i class="ti ti-user text-emerald-600 text-lg"></i>
                                        <h4 class="font-extrabold text-xs text-slate-800 uppercase tracking-wide">Identitas & Foto Kepala Sekolah (Opsional Override)</h4>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                                        <div class="md:col-span-4 space-y-1">
                                            <label class="block text-xs font-bold text-slate-700">Nama Lengkap & Gelar</label>
                                            <input type="text" class="w-full px-3.5 py-2 bg-white border border-slate-300 rounded-xl text-xs font-semibold text-slate-800 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                                   name="prakata_custom_nama" value="{{ old('prakata_custom_nama', $setting->prakata_custom_nama) }}" placeholder="Contoh: Ustzh. Siti Aminah, S.Pd.I">
                                        </div>
                                        <div class="md:col-span-4 space-y-1">
                                            <label class="block text-xs font-bold text-slate-700">Jabatan</label>
                                            <input type="text" class="w-full px-3.5 py-2 bg-white border border-slate-300 rounded-xl text-xs font-semibold text-slate-800 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                                   name="prakata_custom_jabatan" value="{{ old('prakata_custom_jabatan', $setting->prakata_custom_jabatan) }}" placeholder="Contoh: Kepala Sekolah TK Calisa Rabbani">
                                        </div>
                                        <div class="md:col-span-4 space-y-1">
                                            <label class="block text-xs font-bold text-slate-700">Upload Foto Khusus</label>
                                            <input type="file" class="w-full px-3 py-1.5 bg-white border border-slate-300 rounded-xl text-xs font-medium text-slate-700 file:mr-3 file:py-0.5 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer" name="prakata_custom_foto" accept="image/*">
                                        </div>
                                        <div class="md:col-span-12 pt-2">
                                            <div class="h-20 rounded-xl bg-white border-2 border-dashed border-slate-200 flex items-center justify-center p-1.5">
                                                @if ($setting->prakata_custom_foto && Storage::disk('public')->exists($setting->prakata_custom_foto))
                                                    <img src="{{ asset('storage/' . $setting->prakata_custom_foto) }}" alt="Foto Kepala Sekolah" class="h-full max-w-full object-contain rounded">
                                                @else
                                                    <span class="text-slate-400 text-[11px] flex items-center gap-1"><i class="ti ti-user"></i> Menggunakan foto dari data master karyawan jika ada</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ================= TAB 4: PROGRAM UNGGULAN (DYNAMIC REPEATER) ================= -->
                    <div class="tab-pane fade" id="tab-program" role="tabpanel">
                        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
                            <div class="bg-emerald-600 px-5 py-3.5 flex items-center justify-between text-white">
                                <div class="flex items-center gap-2.5">
                                    <i class="ti ti-stars text-lg"></i>
                                    <h3 class="font-extrabold text-sm tracking-tight text-white">Header & Daftar Program Unggulan</h3>
                                </div>
                                <span class="text-[11px] font-bold text-emerald-100/90 bg-white/15 px-2.5 py-0.5 rounded-full border border-white/20">
                                    Dinamis
                                </span>
                            </div>

                            <div class="p-5 sm:p-6 space-y-5 text-xs">
                                <!-- Header Program -->
                                <div class="space-y-4 pb-4 border-b border-slate-200">
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                        <div>
                                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Tag Seksi</label>
                                            <input type="text" class="w-full px-3.5 py-2.5 bg-slate-50/70 border border-slate-300 rounded-xl text-xs font-semibold text-slate-800 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                                   name="program_tag" value="{{ old('program_tag', $setting->program_tag) }}" placeholder="Contoh: Kurikulum & Pembelajaran">
                                        </div>
                                        <div class="sm:col-span-2">
                                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Judul Seksi</label>
                                            <input type="text" class="w-full px-3.5 py-2.5 bg-slate-50/70 border border-slate-300 rounded-xl text-xs font-semibold text-slate-800 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                                   name="program_title" value="{{ old('program_title', $setting->program_title) }}" placeholder="Contoh: Program Unggulan TK">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Deskripsi Pengantar</label>
                                        <textarea class="w-full p-3 bg-slate-50/70 border border-slate-300 rounded-xl text-xs font-medium text-slate-800 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                                  name="program_description" rows="2" placeholder="Deskripsi pengantar seksi program unggulan...">{{ old('program_description', $setting->program_description) }}</textarea>
                                    </div>
                                </div>

                                <!-- Repeater Header -->
                                <div class="flex items-center justify-between pt-1">
                                    <div class="flex items-center gap-2">
                                        <i class="ti ti-list-check text-emerald-600 text-lg"></i>
                                        <h4 class="font-extrabold text-xs text-slate-800 uppercase tracking-wide">Item Kartu Program Unggulan</h4>
                                    </div>
                                    <button type="button" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-bold rounded-xl text-xs border border-emerald-200 transition cursor-pointer active:scale-95" id="btn-add-program">
                                        <i class="ti ti-plus text-sm"></i>
                                        <span>Tambah Program</span>
                                    </button>
                                </div>

                                @php
                                    $currentPrograms = $setting->custom_programs ?? [
                                        ['title' => 'Tahfidz & Doa Harian', 'badge' => 'Target: Juz 30', 'desc' => 'Bimbingan hafalan surat-surat pendek, doa harian, dan hadits adab dengan metode talaqqi ceria berirama.', 'item_1' => 'Talaqqi', 'item_2' => 'Tahsin & Adab', 'icon' => 'ti ti-book-2', 'image' => ''],
                                        ['title' => 'Calistung Ceria (Fun Literacy)', 'badge' => 'Usia: 3-6 Tahun', 'desc' => 'Mengenal huruf, kata, membaca suku kata, dan berhitung angka melalui permainan edukatif yang mengasyikkan.', 'item_1' => 'Sentra', 'item_2' => 'Interaktif', 'icon' => 'ti ti-pencil', 'image' => ''],
                                        ['title' => 'Adab, Motorik & Outing Class', 'badge' => 'Karakter Rabbani', 'desc' => 'Praktek shalat dhuha bersama, pembiasaan kemandirian, senam motorik, manasik haji cilik, dan eksplorasi alam terbuka.', 'item_1' => 'Harian', 'item_2' => 'Outbound', 'icon' => 'ti ti-compass', 'image' => ''],
                                    ];
                                @endphp

                                <div id="program-container" class="space-y-4">
                                    @foreach($currentPrograms as $pIdx => $pVal)
                                        <div class="dynamic-item-card p-4 sm:p-5 program-item space-y-4" data-index="{{ $pIdx }}">
                                            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                                                <div class="flex items-center gap-2.5">
                                                    <span class="w-6 h-6 rounded-md bg-emerald-600 text-white font-black text-xs flex items-center justify-center font-mono item-number">{{ $pIdx + 1 }}</span>
                                                    <h5 class="font-extrabold text-xs text-slate-800 item-title">Program {{ $pIdx + 1 }}: {{ $pVal['title'] ?? '' }}</h5>
                                                </div>
                                                <button type="button" class="inline-flex items-center gap-1 px-2.5 py-1 text-rose-600 hover:bg-rose-50 border border-rose-200 rounded-lg text-xs font-bold transition btn-remove-program cursor-pointer" title="Hapus Program">
                                                    <i class="ti ti-trash text-sm"></i>
                                                    <span>Hapus</span>
                                                </button>
                                            </div>

                                            <input type="hidden" name="program_items[{{ $pIdx }}][old_image]" value="{{ $pVal['image'] ?? '' }}">

                                            <div class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
                                                <div class="sm:col-span-5">
                                                    <label class="block text-[11px] font-bold text-slate-700 mb-1">Nama Program</label>
                                                    <input type="text" class="w-full px-3 py-2 bg-slate-50/70 border border-slate-300 rounded-xl text-xs font-semibold text-slate-800 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                                           name="program_items[{{ $pIdx }}][title]" value="{{ old("program_items.{$pIdx}.title", $pVal['title'] ?? '') }}" placeholder="Contoh: Tahfidz Ceria">
                                                </div>
                                                <div class="sm:col-span-3">
                                                    <label class="block text-[11px] font-bold text-slate-700 mb-1">Badge / Target</label>
                                                    <input type="text" class="w-full px-3 py-2 bg-slate-50/70 border border-slate-300 rounded-xl text-xs font-semibold text-slate-800 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                                           name="program_items[{{ $pIdx }}][badge]" value="{{ old("program_items.{$pIdx}.badge", $pVal['badge'] ?? '') }}" placeholder="Contoh: Target: Juz 30">
                                                </div>
                                                <div class="sm:col-span-4">
                                                    <label class="block text-[11px] font-bold text-slate-700 mb-1">Upload Foto Program</label>
                                                    <input type="file" class="w-full px-2.5 py-1.5 bg-white border border-slate-300 rounded-xl text-xs font-medium text-slate-700 file:mr-2 file:py-0.5 file:px-2 file:rounded file:border-0 file:text-[11px] file:font-bold file:bg-emerald-50 file:text-emerald-700 cursor-pointer" name="program_items[{{ $pIdx }}][image]" accept="image/*">
                                                </div>

                                                <div class="sm:col-span-3">
                                                    <label class="block text-[11px] font-bold text-slate-700 mb-1">Poin 1 (Metode)</label>
                                                    <input type="text" class="w-full px-3 py-1.5 bg-slate-50/70 border border-slate-300 rounded-xl text-xs font-semibold text-slate-800" 
                                                           name="program_items[{{ $pIdx }}][item_1]" value="{{ old("program_items.{$pIdx}.item_1", $pVal['item_1'] ?? '') }}" placeholder="Contoh: Talaqqi">
                                                </div>
                                                <div class="sm:col-span-3">
                                                    <label class="block text-[11px] font-bold text-slate-700 mb-1">Poin 2 (Fokus)</label>
                                                    <input type="text" class="w-full px-3 py-1.5 bg-slate-50/70 border border-slate-300 rounded-xl text-xs font-semibold text-slate-800" 
                                                           name="program_items[{{ $pIdx }}][item_2]" value="{{ old("program_items.{$pIdx}.item_2", $pVal['item_2'] ?? '') }}" placeholder="Contoh: Tahsin & Adab">
                                                </div>
                                                <div class="sm:col-span-3">
                                                    <label class="block text-[11px] font-bold text-slate-700 mb-1">Icon Tabler (Opsional)</label>
                                                    <input type="text" class="w-full px-3 py-1.5 bg-slate-50/70 border border-slate-300 rounded-xl text-xs font-semibold text-slate-800" 
                                                           name="program_items[{{ $pIdx }}][icon]" value="{{ old("program_items.{$pIdx}.icon", $pVal['icon'] ?? 'ti ti-star') }}" placeholder="ti ti-book-2">
                                                </div>
                                                <div class="sm:col-span-3">
                                                    <label class="block text-[11px] font-bold text-slate-700 mb-1">Foto Saat Ini</label>
                                                    <div class="h-10 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-center p-1">
                                                        @if(!empty($pVal['image']))
                                                            <img src="{{ str_starts_with($pVal['image'], 'http') ? $pVal['image'] : asset('storage/' . $pVal['image']) }}" alt="Foto" class="h-full max-w-full object-cover rounded">
                                                        @else
                                                            <span class="text-slate-400 text-[10px] flex items-center gap-1"><i class="ti ti-photo"></i> Default</span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="sm:col-span-12">
                                                    <label class="block text-[11px] font-bold text-slate-700 mb-1">Deskripsi Singkat Program</label>
                                                    <textarea class="w-full p-2.5 bg-slate-50/70 border border-slate-300 rounded-xl text-xs font-medium text-slate-800 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                                              name="program_items[{{ $pIdx }}][desc]" rows="2" placeholder="Jelaskan mengenai program ini...">{{ old("program_items.{$pIdx}.desc", $pVal['desc'] ?? '') }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ================= TAB 5: FASILITAS & FOTO ================= -->
                    <div class="tab-pane fade" id="tab-fasilitas" role="tabpanel">
                        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
                            <div class="bg-emerald-600 px-5 py-3.5 flex items-center justify-between text-white">
                                <div class="flex items-center gap-2.5">
                                    <i class="ti ti-building text-lg"></i>
                                    <h3 class="font-extrabold text-sm tracking-tight text-white">Fasilitas Belajar & Upload Foto Sarana</h3>
                                </div>
                                <span class="text-[11px] font-bold text-emerald-100/90 bg-white/15 px-2.5 py-0.5 rounded-full border border-white/20">
                                    Dinamis
                                </span>
                            </div>

                            <div class="p-5 sm:p-6 space-y-5 text-xs">
                                <!-- Header Fasilitas -->
                                <div class="space-y-4 pb-4 border-b border-slate-200">
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                        <div>
                                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Tag Seksi Fasilitas</label>
                                            <input type="text" class="w-full px-3.5 py-2.5 bg-slate-50/70 border border-slate-300 rounded-xl text-xs font-semibold text-slate-800 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                                   name="fasilitas_tag" value="{{ old('fasilitas_tag', $setting->fasilitas_tag) }}" placeholder="Contoh: Lingkungan & Sarana">
                                        </div>
                                        <div class="sm:col-span-2">
                                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Judul Seksi Fasilitas</label>
                                            <input type="text" class="w-full px-3.5 py-2.5 bg-slate-50/70 border border-slate-300 rounded-xl text-xs font-semibold text-slate-800 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                                   name="fasilitas_title" value="{{ old('fasilitas_title', $setting->fasilitas_title) }}" placeholder="Contoh: Fasilitas Ramah Anak">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Deskripsi Pengantar</label>
                                        <textarea class="w-full p-3 bg-slate-50/70 border border-slate-300 rounded-xl text-xs font-medium text-slate-800 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                                  name="fasilitas_description" rows="2" placeholder="Deskripsi sarana belajar...">{{ old('fasilitas_description', $setting->fasilitas_description) }}</textarea>
                                    </div>
                                </div>

                                <!-- Repeater Header -->
                                <div class="flex items-center justify-between pt-1">
                                    <div class="flex items-center gap-2">
                                        <i class="ti ti-photo-plus text-emerald-600 text-lg"></i>
                                        <h4 class="font-extrabold text-xs text-slate-800 uppercase tracking-wide">Item Kartu Fasilitas (Foto & Deskripsi)</h4>
                                    </div>
                                    <button type="button" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-bold rounded-xl text-xs border border-emerald-200 transition cursor-pointer active:scale-95" id="btn-add-fasilitas">
                                        <i class="ti ti-plus text-sm"></i>
                                        <span>Tambah Fasilitas</span>
                                    </button>
                                </div>

                                @php
                                    $currentFasilitas = $setting->custom_fasilitas ?? [
                                        ['tag' => 'RUANG KELAS', 'name' => 'Ruang Belajar Ber-AC & Nyaman', 'desc' => 'Ruang kelas berpendingin udara dengan pencahayaan alami yang cerah dan media peraga edukatif lengkap.', 'image' => ''],
                                        ['tag' => 'PLAYGROUND', 'name' => 'Area Bermain & Stimulasi Motorik', 'desc' => 'Wahana permainan luar dan dalam ruangan yang aman untuk melatih ketangkasan serta sosialisasi santri.', 'image' => ''],
                                        ['tag' => 'IBADAH', 'name' => 'Sentra Ibadah & Tempat Wudhu Cilik', 'desc' => 'Tempat wudhu khusus anak dan ruang shalat berjamaah untuk menanamkan kedisiplinan ibadah sejak dini.', 'image' => ''],
                                    ];
                                @endphp

                                <div id="fasilitas-container" class="space-y-4">
                                    @foreach($currentFasilitas as $fIdx => $fVal)
                                        <div class="dynamic-item-card p-4 sm:p-5 fasilitas-item space-y-4" data-index="{{ $fIdx }}">
                                            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                                                <div class="flex items-center gap-2.5">
                                                    <span class="w-6 h-6 rounded-md bg-emerald-600 text-white font-black text-xs flex items-center justify-center font-mono item-number">{{ $fIdx + 1 }}</span>
                                                    <h5 class="font-extrabold text-xs text-slate-800 item-title">Fasilitas {{ $fIdx + 1 }}: {{ $fVal['name'] ?? '' }}</h5>
                                                </div>
                                                <button type="button" class="inline-flex items-center gap-1 px-2.5 py-1 text-rose-600 hover:bg-rose-50 border border-rose-200 rounded-lg text-xs font-bold transition btn-remove-fasilitas cursor-pointer" title="Hapus Fasilitas">
                                                    <i class="ti ti-trash text-sm"></i>
                                                    <span>Hapus</span>
                                                </button>
                                            </div>

                                            <input type="hidden" name="fasilitas_items[{{ $fIdx }}][old_image]" value="{{ $fVal['image'] ?? '' }}">

                                            <div class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
                                                <div class="sm:col-span-3">
                                                    <label class="block text-[11px] font-bold text-slate-700 mb-1">Tag Stiker Atas</label>
                                                    <input type="text" class="w-full px-3 py-2 bg-slate-50/70 border border-slate-300 rounded-xl text-xs font-semibold text-slate-800 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                                           name="fasilitas_items[{{ $fIdx }}][tag]" value="{{ old("fasilitas_items.{$fIdx}.tag", $fVal['tag'] ?? '') }}" placeholder="Contoh: RUANG KELAS">
                                                </div>
                                                <div class="sm:col-span-5">
                                                    <label class="block text-[11px] font-bold text-slate-700 mb-1">Nama Fasilitas</label>
                                                    <input type="text" class="w-full px-3 py-2 bg-slate-50/70 border border-slate-300 rounded-xl text-xs font-semibold text-slate-800 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                                           name="fasilitas_items[{{ $fIdx }}][name]" value="{{ old("fasilitas_items.{$fIdx}.name", $fVal['name'] ?? '') }}" placeholder="Contoh: Ruang Belajar Nyaman">
                                                </div>
                                                <div class="sm:col-span-4">
                                                    <label class="block text-[11px] font-bold text-slate-700 mb-1">Ganti / Upload Foto Sarana</label>
                                                    <input type="file" class="w-full px-2.5 py-1.5 bg-white border border-slate-300 rounded-xl text-xs font-medium text-slate-700 file:mr-2 file:py-0.5 file:px-2 file:rounded file:border-0 file:text-[11px] file:font-bold file:bg-emerald-50 file:text-emerald-700 cursor-pointer" name="fasilitas_items[{{ $fIdx }}][image]" accept="image/*">
                                                </div>

                                                <div class="sm:col-span-9">
                                                    <label class="block text-[11px] font-bold text-slate-700 mb-1">Deskripsi Fasilitas</label>
                                                    <textarea class="w-full p-2.5 bg-slate-50/70 border border-slate-300 rounded-xl text-xs font-medium text-slate-800 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                                              name="fasilitas_items[{{ $fIdx }}][desc]" rows="2" placeholder="Jelaskan fasilitas ini...">{{ old("fasilitas_items.{$fIdx}.desc", $fVal['desc'] ?? '') }}</textarea>
                                                </div>
                                                <div class="sm:col-span-3">
                                                    <label class="block text-[11px] font-bold text-slate-700 mb-1">Foto Saat Ini</label>
                                                    <div class="h-12 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-center p-1">
                                                        @if(!empty($fVal['image']))
                                                            <img src="{{ str_starts_with($fVal['image'], 'http') ? $fVal['image'] : asset('storage/' . $fVal['image']) }}" alt="Foto" class="h-full max-w-full object-cover rounded">
                                                        @else
                                                            <span class="text-slate-400 text-[10px] flex items-center gap-1"><i class="ti ti-photo"></i> Default</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ================= TAB 6: TESTIMONI & AVATAR ================= -->
                    <div class="tab-pane fade" id="tab-testimoni" role="tabpanel">
                        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
                            <div class="bg-emerald-600 px-5 py-3.5 flex items-center justify-between text-white">
                                <div class="flex items-center gap-2.5">
                                    <i class="ti ti-message-2-heart text-lg"></i>
                                    <h3 class="font-extrabold text-sm tracking-tight text-white">Testimoni Wali Santri & Foto Profil</h3>
                                </div>
                                <span class="text-[11px] font-bold text-emerald-100/90 bg-white/15 px-2.5 py-0.5 rounded-full border border-white/20">
                                    Dinamis
                                </span>
                            </div>

                            <div class="p-5 sm:p-6 space-y-5 text-xs">
                                <!-- Header Testimoni -->
                                <div class="space-y-4 pb-4 border-b border-slate-200">
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                        <div>
                                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Tag Seksi Testimoni</label>
                                            <input type="text" class="w-full px-3.5 py-2.5 bg-slate-50/70 border border-slate-300 rounded-xl text-xs font-semibold text-slate-800 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                                   name="testimoni_tag" value="{{ old('testimoni_tag', $setting->testimoni_tag) }}" placeholder="Contoh: Testimoni & Pengalaman">
                                        </div>
                                        <div class="sm:col-span-2">
                                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Judul Seksi Testimoni</label>
                                            <input type="text" class="w-full px-3.5 py-2.5 bg-slate-50/70 border border-slate-300 rounded-xl text-xs font-semibold text-slate-800 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                                   name="testimoni_title" value="{{ old('testimoni_title', $setting->testimoni_title) }}" placeholder="Contoh: Apa Kata Orang Tua Santri?">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Deskripsi Pengantar</label>
                                        <textarea class="w-full p-3 bg-slate-50/70 border border-slate-300 rounded-xl text-xs font-medium text-slate-800 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                                  name="testimoni_description" rows="2" placeholder="Deskripsi kata orang tua...">{{ old('testimoni_description', $setting->testimoni_description) }}</textarea>
                                    </div>
                                </div>

                                <!-- 3 Foto Galeri Kegiatan Samping Testimoni -->
                                <div class="bg-slate-50/80 rounded-2xl p-4 sm:p-5 border border-slate-200 space-y-3">
                                    <div class="flex items-center gap-2 pb-2 border-b border-slate-200">
                                        <i class="ti ti-photo-plus text-emerald-600 text-lg"></i>
                                        <h4 class="font-extrabold text-xs text-slate-800 uppercase tracking-wide">3 Foto Dokumentasi Kegiatan (Samping Testimoni)</h4>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                        <!-- Foto 1 -->
                                        <div class="bg-white rounded-xl p-3 border border-slate-200/90 shadow-2xs space-y-2">
                                            <label class="block text-[11px] font-bold text-slate-700">Foto Galeri 1 (Kiri)</label>
                                            <input type="file" class="w-full px-2.5 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-xs font-medium text-slate-700 file:mr-2 file:py-0.5 file:px-2 file:rounded file:border-0 file:text-[10px] file:font-bold file:bg-emerald-50 file:text-emerald-700 cursor-pointer" name="testimoni_image_1" accept="image/*">
                                            <div class="h-20 rounded-lg bg-slate-50 border border-slate-200 flex items-center justify-center p-1 overflow-hidden">
                                                @if ($setting->testimoni_image_1 && Storage::disk('public')->exists($setting->testimoni_image_1))
                                                    <img src="{{ asset('storage/' . $setting->testimoni_image_1) }}" alt="Foto 1" class="w-full h-full object-cover rounded">
                                                @else
                                                    <span class="text-slate-400 text-[10px] flex items-center gap-1"><i class="ti ti-photo"></i> Default 1</span>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Foto 2 -->
                                        <div class="bg-white rounded-xl p-3 border border-slate-200/90 shadow-2xs space-y-2">
                                            <label class="block text-[11px] font-bold text-slate-700">Foto Galeri 2 (Tengah)</label>
                                            <input type="file" class="w-full px-2.5 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-xs font-medium text-slate-700 file:mr-2 file:py-0.5 file:px-2 file:rounded file:border-0 file:text-[10px] file:font-bold file:bg-emerald-50 file:text-emerald-700 cursor-pointer" name="testimoni_image_2" accept="image/*">
                                            <div class="h-20 rounded-lg bg-slate-50 border border-slate-200 flex items-center justify-center p-1 overflow-hidden">
                                                @if ($setting->testimoni_image_2 && Storage::disk('public')->exists($setting->testimoni_image_2))
                                                    <img src="{{ asset('storage/' . $setting->testimoni_image_2) }}" alt="Foto 2" class="w-full h-full object-cover rounded">
                                                @else
                                                    <span class="text-slate-400 text-[10px] flex items-center gap-1"><i class="ti ti-photo"></i> Default 2</span>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Foto 3 -->
                                        <div class="bg-white rounded-xl p-3 border border-slate-200/90 shadow-2xs space-y-2">
                                            <label class="block text-[11px] font-bold text-slate-700">Foto Galeri 3 (Kanan)</label>
                                            <input type="file" class="w-full px-2.5 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-xs font-medium text-slate-700 file:mr-2 file:py-0.5 file:px-2 file:rounded file:border-0 file:text-[10px] file:font-bold file:bg-emerald-50 file:text-emerald-700 cursor-pointer" name="testimoni_image_3" accept="image/*">
                                            <div class="h-20 rounded-lg bg-slate-50 border border-slate-200 flex items-center justify-center p-1 overflow-hidden">
                                                @if ($setting->testimoni_image_3 && Storage::disk('public')->exists($setting->testimoni_image_3))
                                                    <img src="{{ asset('storage/' . $setting->testimoni_image_3) }}" alt="Foto 3" class="w-full h-full object-cover rounded">
                                                @else
                                                    <span class="text-slate-400 text-[10px] flex items-center gap-1"><i class="ti ti-photo"></i> Default 3</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Repeater Header -->
                                <div class="flex items-center justify-between pt-1">
                                    <div class="flex items-center gap-2">
                                        <i class="ti ti-user-circle text-emerald-600 text-lg"></i>
                                        <h4 class="font-extrabold text-xs text-slate-800 uppercase tracking-wide">Item Kartu Testimoni (Foto Orang Tua & Ulasan)</h4>
                                    </div>
                                    <button type="button" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-bold rounded-xl text-xs border border-emerald-200 transition cursor-pointer active:scale-95" id="btn-add-testimoni">
                                        <i class="ti ti-plus text-sm"></i>
                                        <span>Tambah Testimoni</span>
                                    </button>
                                </div>

                                @php
                                    $currentTesti = $setting->custom_testimoni ?? [
                                        ['nama' => 'Bunda Faris', 'role' => 'Wali Santri TK B', 'quote' => 'Alhamdulillah sejak sekolah di TK Calisa, ananda jadi rajin shalat, hafal surat-surat pendek dengan tartil, dan sangat mandiri.', 'avatar' => ''],
                                        ['nama' => 'Ayah Rasyid', 'role' => 'Wali Santri TK A', 'quote' => 'Guru-gurunya sangat ramah, sabar, dan komunikatif. Laporan perkembangan anak setiap minggu sangat membantu kami mendampingi anak.', 'avatar' => ''],
                                        ['nama' => 'Mama Aisha', 'role' => 'Wali Santri Playgroup', 'quote' => 'Fasilitas bermainnya bersih dan aman. Program calistungnya tidak membebani tapi justru membuat anak penasaran dan suka membaca.', 'avatar' => ''],
                                    ];
                                @endphp

                                <div id="testimoni-container" class="space-y-4">
                                    @foreach($currentTesti as $tIdx => $tVal)
                                        <div class="dynamic-item-card p-4 sm:p-5 testimoni-item space-y-4" data-index="{{ $tIdx }}">
                                            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                                                <div class="flex items-center gap-2.5">
                                                    <span class="w-6 h-6 rounded-md bg-emerald-600 text-white font-black text-xs flex items-center justify-center font-mono item-number">{{ $tIdx + 1 }}</span>
                                                    <h5 class="font-extrabold text-xs text-slate-800 item-title">Testimoni {{ $tIdx + 1 }}: {{ $tVal['nama'] ?? '' }}</h5>
                                                </div>
                                                <button type="button" class="inline-flex items-center gap-1 px-2.5 py-1 text-rose-600 hover:bg-rose-50 border border-rose-200 rounded-lg text-xs font-bold transition btn-remove-testimoni cursor-pointer" title="Hapus Testimoni">
                                                    <i class="ti ti-trash text-sm"></i>
                                                    <span>Hapus</span>
                                                </button>
                                            </div>

                                            <input type="hidden" name="testimoni_items[{{ $tIdx }}][old_avatar]" value="{{ $tVal['avatar'] ?? '' }}">

                                            <div class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
                                                <div class="sm:col-span-4">
                                                    <label class="block text-[11px] font-bold text-slate-700 mb-1">Nama Orang Tua / Wali</label>
                                                    <input type="text" class="w-full px-3 py-2 bg-slate-50/70 border border-slate-300 rounded-xl text-xs font-semibold text-slate-800 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                                           name="testimoni_items[{{ $tIdx }}][nama]" value="{{ old("testimoni_items.{$tIdx}.nama", $tVal['nama'] ?? '') }}" placeholder="Contoh: Bunda Faris">
                                                </div>
                                                <div class="sm:col-span-4">
                                                    <label class="block text-[11px] font-bold text-slate-700 mb-1">Status / Keterangan</label>
                                                    <input type="text" class="w-full px-3 py-2 bg-slate-50/70 border border-slate-300 rounded-xl text-xs font-semibold text-slate-800 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                                           name="testimoni_items[{{ $tIdx }}][role]" value="{{ old("testimoni_items.{$tIdx}.role", $tVal['role'] ?? '') }}" placeholder="Contoh: Wali Santri TK B">
                                                </div>
                                                <div class="sm:col-span-4">
                                                    <label class="block text-[11px] font-bold text-slate-700 mb-1">Upload Foto Profil / Avatar</label>
                                                    <input type="file" class="w-full px-2.5 py-1.5 bg-white border border-slate-300 rounded-xl text-xs font-medium text-slate-700 file:mr-2 file:py-0.5 file:px-2 file:rounded file:border-0 file:text-[11px] file:font-bold file:bg-emerald-50 file:text-emerald-700 cursor-pointer" name="testimoni_items[{{ $tIdx }}][avatar]" accept="image/*">
                                                </div>

                                                <div class="sm:col-span-9">
                                                    <label class="block text-[11px] font-bold text-slate-700 mb-1">Isi Kutipan Ulasan / Testimoni</label>
                                                    <textarea class="w-full p-2.5 bg-slate-50/70 border border-slate-300 rounded-xl text-xs font-medium text-slate-800 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                                              name="testimoni_items[{{ $tIdx }}][quote]" rows="2" placeholder="Tuliskan ulasan orang tua...">{{ old("testimoni_items.{$tIdx}.quote", $tVal['quote'] ?? '') }}</textarea>
                                                </div>
                                                <div class="sm:col-span-3">
                                                    <label class="block text-[11px] font-bold text-slate-700 mb-1">Avatar Saat Ini</label>
                                                    <div class="h-12 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-center p-1">
                                                        @if(!empty($tVal['avatar']))
                                                            <img src="{{ str_starts_with($tVal['avatar'], 'http') ? $tVal['avatar'] : asset('storage/' . $tVal['avatar']) }}" alt="Avatar" class="w-10 h-10 rounded-full object-cover">
                                                        @else
                                                            <span class="text-slate-400 text-[10px] flex items-center gap-1"><i class="ti ti-user"></i> Inisial</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ================= TAB 7: BANNER CTA & KONTAK ================= -->
                    <div class="tab-pane fade" id="tab-cta" role="tabpanel">
                        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
                            <div class="bg-emerald-600 px-5 py-3.5 flex items-center justify-between text-white">
                                <div class="flex items-center gap-2.5">
                                    <i class="ti ti-speakerphone text-lg"></i>
                                    <h3 class="font-extrabold text-sm tracking-tight text-white">Banner Call-to-Action & Kontak Unit</h3>
                                </div>
                                <span class="text-[11px] font-bold text-emerald-100/90 bg-white/15 px-2.5 py-0.5 rounded-full border border-white/20">
                                    Konversi Pendaftaran
                                </span>
                            </div>

                            <div class="p-5 sm:p-6 space-y-5 text-xs">
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Tag Banner</label>
                                        <input type="text" class="w-full px-3.5 py-2.5 bg-slate-50/70 border border-slate-300 rounded-xl text-xs font-semibold text-slate-800 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                               name="cta_tag" value="{{ old('cta_tag', $setting->cta_tag) }}" placeholder="Contoh: Buka Pendaftaran Siswa Baru">
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Judul Utama Banner</label>
                                        <input type="text" class="w-full px-3.5 py-2.5 bg-slate-50/70 border border-slate-300 rounded-xl text-xs font-semibold text-slate-800 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                               name="cta_title" value="{{ old('cta_title', $setting->cta_title) }}" placeholder="Contoh: Butuh Bantuan / Skema Pembayaran Bertahap?">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Deskripsi Banner</label>
                                    <textarea class="w-full p-3.5 bg-slate-50/70 border border-slate-300 rounded-xl text-xs font-medium text-slate-800 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                              name="cta_description" rows="3" placeholder="Deskripsi konsultasi & ajakan pendaftaran...">{{ old('cta_description', $setting->cta_description) }}</textarea>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Teks Tombol Aksi Utama</label>
                                        <input type="text" class="w-full px-3.5 py-2.5 bg-slate-50/70 border border-slate-300 rounded-xl text-xs font-semibold text-slate-800 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                               name="cta_button_text" value="{{ old('cta_button_text', $setting->cta_button_text) }}" placeholder="Contoh: Daftar Santri Baru">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 mb-1.5">URL / Link Tombol Aksi</label>
                                        <input type="text" class="w-full px-3.5 py-2.5 bg-slate-50/70 border border-slate-300 rounded-xl text-xs font-semibold text-slate-800 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                               name="cta_button_url" value="{{ old('cta_button_url', $setting->cta_button_url) }}" placeholder="Contoh: /register">
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Pesan Otomatis WhatsApp</label>
                                        <input type="text" class="w-full px-3.5 py-2.5 bg-slate-50/70 border border-slate-300 rounded-xl text-xs font-semibold text-slate-800 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                               name="cta_wa_text" value="{{ old('cta_wa_text', $setting->cta_wa_text) }}" placeholder="Contoh: Halo Admin, saya ingin tanya rincian pendaftaran...">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Nomor WhatsApp CS Khusus Unit</label>
                                        <input type="text" class="w-full px-3.5 py-2.5 bg-slate-50/70 border border-slate-300 rounded-xl text-xs font-semibold text-slate-800 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                               name="unit_whatsapp" value="{{ old('unit_whatsapp', $setting->unit_whatsapp) }}" placeholder="08xxxxxxxxxx">
                                    </div>
                                </div>

                                <!-- Foto Model Banner CTA -->
                                <div class="bg-slate-50/80 rounded-2xl p-4 sm:p-5 border border-slate-200">
                                    <div class="flex items-center gap-2 pb-3 mb-4 border-b border-slate-200">
                                        <i class="ti ti-camera text-emerald-600 text-lg"></i>
                                        <h4 class="font-extrabold text-xs text-slate-800 uppercase tracking-wide">Foto Model Banner CTA (Ajakan Daftar)</h4>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                                        <div class="md:col-span-7 space-y-2">
                                            <label class="block text-xs font-bold text-slate-700">Upload Foto Model Banner Baru (Transparan PNG / WebP)</label>
                                            <input type="file" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-xs font-medium text-slate-700 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer" name="cta_model_image" accept="image/*">
                                            <div class="flex items-center gap-2 p-2.5 rounded-xl bg-emerald-50/80 border border-emerald-200/80 text-emerald-800 text-[11px]">
                                                <i class="ti ti-info-circle text-base shrink-0 text-emerald-600"></i>
                                                <span>Foto model/maskot santri ceria untuk Banner CTA penutup. Otomatis dikompresi ke <b>WebP</b>.</span>
                                            </div>
                                        </div>
                                        <div class="md:col-span-5">
                                            <label class="block text-xs font-bold text-slate-700 mb-1.5 text-center md:text-left">Foto Model CTA Aktif</label>
                                            <div class="w-full h-28 rounded-xl bg-white border-2 border-dashed border-slate-200 flex items-center justify-center p-1.5 overflow-hidden">
                                                @if ($setting->cta_model_image && Storage::disk('public')->exists($setting->cta_model_image))
                                                    <img src="{{ asset('storage/' . $setting->cta_model_image) }}" alt="CTA Model" class="h-full max-w-full object-contain">
                                                @else
                                                    <span class="text-slate-400 text-[11px] flex items-center gap-1 text-center"><i class="ti ti-photo-off"></i> Memakai model hero / default</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Media Sosial & Kontak -->
                                <div class="bg-slate-50/80 rounded-2xl p-4 sm:p-5 border border-slate-200 space-y-4">
                                    <div class="flex items-center gap-2 pb-2 border-b border-slate-200">
                                        <i class="ti ti-brand-instagram text-rose-500 text-lg"></i>
                                        <h4 class="font-extrabold text-xs text-slate-800 uppercase tracking-wide">Media Sosial & Kontak Tambahan</h4>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                        <div>
                                            <label class="block text-xs font-bold text-slate-700 mb-1">Telepon Kantor</label>
                                            <input type="text" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-xs font-semibold text-slate-800 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                                   name="unit_phone" value="{{ old('unit_phone', $setting->unit_phone) }}" placeholder="(0265) xxxxxx">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-700 mb-1">Email Unit</label>
                                            <input type="email" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-xs font-semibold text-slate-800 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                                   name="unit_email" value="{{ old('unit_email', $setting->unit_email) }}" placeholder="unit@alamin.sch.id">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-700 mb-1">Instagram</label>
                                            <input type="text" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-xs font-semibold text-slate-800 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                                   name="unit_instagram" value="{{ old('unit_instagram', $setting->unit_instagram) }}" placeholder="@tkcalisarabbani">
                                        </div>
                                        <div class="sm:col-span-1">
                                            <label class="block text-xs font-bold text-slate-700 mb-1">Facebook</label>
                                            <input type="text" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-xs font-semibold text-slate-800 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                                   name="unit_facebook" value="{{ old('unit_facebook', $setting->unit_facebook) }}" placeholder="facebook.com/tkcalisa">
                                        </div>
                                        <div class="sm:col-span-2">
                                            <label class="block text-xs font-bold text-slate-700 mb-1">YouTube Channel</label>
                                            <input type="text" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-xs font-semibold text-slate-800 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                                   name="unit_youtube" value="{{ old('unit_youtube', $setting->unit_youtube) }}" placeholder="youtube.com/@channel">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </form>
</div>

@push('myscript')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- 1. REPEATER PROGRAM UNGGULAN ---
        const programContainer = document.getElementById('program-container');
        const btnAddProgram = document.getElementById('btn-add-program');

        if (btnAddProgram) {
            btnAddProgram.addEventListener('click', function() {
                const count = programContainer.querySelectorAll('.program-item').length;
                const newIndex = count > 0 ? Date.now() : 0;
                const num = count + 1;

                const template = `
                    <div class="dynamic-item-card p-4 sm:p-5 program-item space-y-4" data-index="${newIndex}">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <div class="flex items-center gap-2.5">
                                <span class="w-6 h-6 rounded-md bg-emerald-600 text-white font-black text-xs flex items-center justify-center font-mono item-number">${num}</span>
                                <h5 class="font-extrabold text-xs text-slate-800 item-title">Program Baru ${num}</h5>
                            </div>
                            <button type="button" class="inline-flex items-center gap-1 px-2.5 py-1 text-rose-600 hover:bg-rose-50 border border-rose-200 rounded-lg text-xs font-bold transition btn-remove-program cursor-pointer" title="Hapus Program">
                                <i class="ti ti-trash text-sm"></i>
                                <span>Hapus</span>
                            </button>
                        </div>
                        <input type="hidden" name="program_items[${newIndex}][old_image]" value="">
                        <div class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
                            <div class="sm:col-span-5">
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Nama Program</label>
                                <input type="text" class="w-full px-3 py-2 bg-slate-50/70 border border-slate-300 rounded-xl text-xs font-semibold text-slate-800 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                       name="program_items[${newIndex}][title]" placeholder="Contoh: Tahfidz Ceria">
                            </div>
                            <div class="sm:col-span-3">
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Badge / Target</label>
                                <input type="text" class="w-full px-3 py-2 bg-slate-50/70 border border-slate-300 rounded-xl text-xs font-semibold text-slate-800 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                       name="program_items[${newIndex}][badge]" placeholder="Contoh: Target: Juz 30">
                            </div>
                            <div class="sm:col-span-4">
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Upload Foto Program</label>
                                <input type="file" class="w-full px-2.5 py-1.5 bg-white border border-slate-300 rounded-xl text-xs font-medium text-slate-700 file:mr-2 file:py-0.5 file:px-2 file:rounded file:border-0 file:text-[11px] file:font-bold file:bg-emerald-50 file:text-emerald-700 cursor-pointer" name="program_items[${newIndex}][image]" accept="image/*">
                            </div>

                            <div class="sm:col-span-3">
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Poin 1 (Metode)</label>
                                <input type="text" class="w-full px-3 py-1.5 bg-slate-50/70 border border-slate-300 rounded-xl text-xs font-semibold text-slate-800" 
                                       name="program_items[${newIndex}][item_1]" placeholder="Contoh: Talaqqi">
                            </div>
                            <div class="sm:col-span-3">
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Poin 2 (Fokus)</label>
                                <input type="text" class="w-full px-3 py-1.5 bg-slate-50/70 border border-slate-300 rounded-xl text-xs font-semibold text-slate-800" 
                                       name="program_items[${newIndex}][item_2]" placeholder="Contoh: Tahsin & Adab">
                            </div>
                            <div class="sm:col-span-3">
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Icon Tabler (Opsional)</label>
                                <input type="text" class="w-full px-3 py-1.5 bg-slate-50/70 border border-slate-300 rounded-xl text-xs font-semibold text-slate-800" 
                                       name="program_items[${newIndex}][icon]" value="ti ti-star" placeholder="ti ti-star">
                            </div>
                            <div class="sm:col-span-3">
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Foto Saat Ini</label>
                                <div class="h-10 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-center p-1">
                                    <span class="text-slate-400 text-[10px] flex items-center gap-1"><i class="ti ti-photo"></i> Baru</span>
                                </div>
                            </div>

                            <div class="sm:col-span-12">
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Deskripsi Singkat Program</label>
                                <textarea class="w-full p-2.5 bg-slate-50/70 border border-slate-300 rounded-xl text-xs font-medium text-slate-800 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                          name="program_items[${newIndex}][desc]" rows="2" placeholder="Jelaskan mengenai program ini..."></textarea>
                            </div>
                        </div>
                    </div>
                `;
                programContainer.insertAdjacentHTML('beforeend', template);
            });

            programContainer.addEventListener('click', function(e) {
                if (e.target.closest('.btn-remove-program')) {
                    const item = e.target.closest('.program-item');
                    item.remove();
                    programContainer.querySelectorAll('.program-item').forEach((el, idx) => {
                        el.querySelector('.item-number').textContent = idx + 1;
                    });
                }
            });
        }

        // --- 2. REPEATER FASILITAS ---
        const fasilitasContainer = document.getElementById('fasilitas-container');
        const btnAddFasilitas = document.getElementById('btn-add-fasilitas');

        if (btnAddFasilitas) {
            btnAddFasilitas.addEventListener('click', function() {
                const count = fasilitasContainer.querySelectorAll('.fasilitas-item').length;
                const newIndex = count > 0 ? Date.now() : 0;
                const num = count + 1;

                const template = `
                    <div class="dynamic-item-card p-4 sm:p-5 fasilitas-item space-y-4" data-index="${newIndex}">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <div class="flex items-center gap-2.5">
                                <span class="w-6 h-6 rounded-md bg-emerald-600 text-white font-black text-xs flex items-center justify-center font-mono item-number">${num}</span>
                                <h5 class="font-extrabold text-xs text-slate-800 item-title">Fasilitas Baru ${num}</h5>
                            </div>
                            <button type="button" class="inline-flex items-center gap-1 px-2.5 py-1 text-rose-600 hover:bg-rose-50 border border-rose-200 rounded-lg text-xs font-bold transition btn-remove-fasilitas cursor-pointer" title="Hapus Fasilitas">
                                <i class="ti ti-trash text-sm"></i>
                                <span>Hapus</span>
                            </button>
                        </div>
                        <input type="hidden" name="fasilitas_items[${newIndex}][old_image]" value="">
                        <div class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
                            <div class="sm:col-span-3">
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Tag Stiker Atas</label>
                                <input type="text" class="w-full px-3 py-2 bg-slate-50/70 border border-slate-300 rounded-xl text-xs font-semibold text-slate-800 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                       name="fasilitas_items[${newIndex}][tag]" placeholder="Contoh: LAB KOMPUTER">
                            </div>
                            <div class="sm:col-span-5">
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Nama Fasilitas</label>
                                <input type="text" class="w-full px-3 py-2 bg-slate-50/70 border border-slate-300 rounded-xl text-xs font-semibold text-slate-800 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                       name="fasilitas_items[${newIndex}][name]" placeholder="Contoh: Laboratorium Digital">
                            </div>
                            <div class="sm:col-span-4">
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Upload Foto Sarana</label>
                                <input type="file" class="w-full px-2.5 py-1.5 bg-white border border-slate-300 rounded-xl text-xs font-medium text-slate-700 file:mr-2 file:py-0.5 file:px-2 file:rounded file:border-0 file:text-[11px] file:font-bold file:bg-emerald-50 file:text-emerald-700 cursor-pointer" name="fasilitas_items[${newIndex}][image]" accept="image/*">
                            </div>

                            <div class="sm:col-span-9">
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Deskripsi Fasilitas</label>
                                <textarea class="w-full p-2.5 bg-slate-50/70 border border-slate-300 rounded-xl text-xs font-medium text-slate-800 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                          name="fasilitas_items[${newIndex}][desc]" rows="2" placeholder="Jelaskan fasilitas ini..."></textarea>
                            </div>
                            <div class="sm:col-span-3">
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Foto Saat Ini</label>
                                <div class="h-12 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-center p-1">
                                    <span class="text-slate-400 text-[10px] flex items-center gap-1"><i class="ti ti-photo"></i> Baru</span>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                fasilitasContainer.insertAdjacentHTML('beforeend', template);
            });

            fasilitasContainer.addEventListener('click', function(e) {
                if (e.target.closest('.btn-remove-fasilitas')) {
                    const item = e.target.closest('.fasilitas-item');
                    item.remove();
                    fasilitasContainer.querySelectorAll('.fasilitas-item').forEach((el, idx) => {
                        el.querySelector('.item-number').textContent = idx + 1;
                    });
                }
            });
        }

        // --- 3. REPEATER TESTIMONI ---
        const testimoniContainer = document.getElementById('testimoni-container');
        const btnAddTestimoni = document.getElementById('btn-add-testimoni');

        if (btnAddTestimoni) {
            btnAddTestimoni.addEventListener('click', function() {
                const count = testimoniContainer.querySelectorAll('.testimoni-item').length;
                const newIndex = count > 0 ? Date.now() : 0;
                const num = count + 1;

                const template = `
                    <div class="dynamic-item-card p-4 sm:p-5 testimoni-item space-y-4" data-index="${newIndex}">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <div class="flex items-center gap-2.5">
                                <span class="w-6 h-6 rounded-md bg-emerald-600 text-white font-black text-xs flex items-center justify-center font-mono item-number">${num}</span>
                                <h5 class="font-extrabold text-xs text-slate-800 item-title">Testimoni Baru ${num}</h5>
                            </div>
                            <button type="button" class="inline-flex items-center gap-1 px-2.5 py-1 text-rose-600 hover:bg-rose-50 border border-rose-200 rounded-lg text-xs font-bold transition btn-remove-testimoni cursor-pointer" title="Hapus Testimoni">
                                <i class="ti ti-trash text-sm"></i>
                                <span>Hapus</span>
                            </button>
                        </div>
                        <input type="hidden" name="testimoni_items[${newIndex}][old_avatar]" value="">
                        <div class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
                            <div class="sm:col-span-4">
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Nama Orang Tua / Wali</label>
                                <input type="text" class="w-full px-3 py-2 bg-slate-50/70 border border-slate-300 rounded-xl text-xs font-semibold text-slate-800 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                       name="testimoni_items[${newIndex}][nama]" placeholder="Contoh: Ibu Zahra">
                            </div>
                            <div class="sm:col-span-4">
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Status / Keterangan</label>
                                <input type="text" class="w-full px-3 py-2 bg-slate-50/70 border border-slate-300 rounded-xl text-xs font-semibold text-slate-800 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                       name="testimoni_items[${newIndex}][role]" placeholder="Contoh: Wali Santri">
                            </div>
                            <div class="sm:col-span-4">
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Upload Foto Profil / Avatar</label>
                                <input type="file" class="w-full px-2.5 py-1.5 bg-white border border-slate-300 rounded-xl text-xs font-medium text-slate-700 file:mr-2 file:py-0.5 file:px-2 file:rounded file:border-0 file:text-[11px] file:font-bold file:bg-emerald-50 file:text-emerald-700 cursor-pointer" name="testimoni_items[${newIndex}][avatar]" accept="image/*">
                            </div>

                            <div class="sm:col-span-9">
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Isi Kutipan Ulasan / Testimoni</label>
                                <textarea class="w-full p-2.5 bg-slate-50/70 border border-slate-300 rounded-xl text-xs font-medium text-slate-800 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                          name="testimoni_items[${newIndex}][quote]" rows="2" placeholder="Tuliskan ulasan orang tua..."></textarea>
                            </div>
                            <div class="sm:col-span-3">
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Avatar Saat Ini</label>
                                <div class="h-12 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-center p-1">
                                    <span class="text-slate-400 text-[10px] flex items-center gap-1"><i class="ti ti-user"></i> Baru</span>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                testimoniContainer.insertAdjacentHTML('beforeend', template);
            });

            testimoniContainer.addEventListener('click', function(e) {
                if (e.target.closest('.btn-remove-testimoni')) {
                    const item = e.target.closest('.testimoni-item');
                    item.remove();
                    testimoniContainer.querySelectorAll('.testimoni-item').forEach((el, idx) => {
                        el.querySelector('.item-number').textContent = idx + 1;
                    });
                }
            });
        }

        // Scroll viewport ke atas tab-content saat tab berpindah
        const tabBtns = document.querySelectorAll('#landingTab button[data-bs-toggle="pill"]');
        tabBtns.forEach(btn => {
            btn.addEventListener('focus', function(e) {
                e.preventDefault();
            }, { passive: false });

            btn.addEventListener('shown.bs.tab', function(e) {
                const targetSelector = e.target.getAttribute('data-bs-target');
                const targetPane = document.querySelector(targetSelector);
                if (targetPane) {
                    const rect = targetPane.getBoundingClientRect();
                    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                    const navbarHeight = 75;
                    const targetTop = rect.top + scrollTop - navbarHeight - 10;
                    window.scrollTo({ top: Math.max(0, targetTop), behavior: 'smooth' });
                }
            });
        });

        window.scrollTo({ top: 0, behavior: 'instant' });
    });
</script>
@endpush
@endsection

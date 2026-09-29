@extends('layouts.app')
@section('titlepage', 'Setting Landing Page Unit - ' . $unit->nama_unit)

@push('myscript')
<style>
    /* Styling Standar Admin Dashboard Profesional - Clean & Semi-Formal */
    .landing-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }
    .landing-sidebar-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        overflow: hidden;
    }
    .sidebar-unit-header {
        background-color: #ffffff;
        border-bottom: 1px solid #f1f5f9;
        padding: 14px 16px;
    }
    .nav-landing-menu {
        display: flex;
        flex-direction: column;
        gap: 3px;
        padding: 10px;
    }
    .nav-landing-menu .nav-link {
        display: flex !important;
        align-items: center !important;
        justify-content: flex-start !important;
        text-align: left !important;
        gap: 12px;
        padding: 10px 14px !important;
        font-size: 0.875rem;
        font-weight: 500;
        color: #334155;
        border-radius: 8px;
        border: 1px solid transparent;
        transition: all 0.15s ease;
        width: 100%;
        box-shadow: none !important;
    }
    .nav-landing-menu .nav-link i {
        font-size: 1.2rem;
        color: #64748b;
        flex-shrink: 0;
        line-height: 1;
        width: 20px;
        text-align: center;
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
        color: #064e3b !important;
    }
    .nav-landing-menu .nav-link.active {
        background-color: #064e3b !important;
        color: #ffffff !important;
        font-weight: 600 !important;
    }
    .nav-landing-menu .nav-link.active i {
        color: #ffffff !important;
    }
    .section-banner-title {
        background-color: #ffffff;
        border-bottom: 1px solid #f1f5f9;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
        padding: 14px 20px;
    }
    .form-label-custom {
        font-weight: 600;
        font-size: 0.84rem;
        color: #1e293b;
        margin-bottom: 5px;
    }
    .form-control-custom {
        border: 1px solid #d1d5db;
        border-radius: 8px;
        padding: 8px 12px;
        font-size: 0.875rem;
        color: #1f2937;
        background-color: #ffffff;
        transition: border-color 0.15s ease, box-shadow 0.15s ease;
    }
    .form-control-custom:focus {
        border-color: #064e3b;
        background-color: #ffffff;
        box-shadow: 0 0 0 3px rgba(6, 78, 59, 0.12);
        outline: none;
    }
    .form-control-custom::placeholder {
        color: #94a3b8;
    }
    .form-sub-section {
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 18px 20px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .form-sub-section:hover {
        border-color: #cbd5e1;
    }
    .form-sub-section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
        padding-bottom: 12px;
        border-bottom: 1px solid #f1f5f9;
    }
    .preview-box-custom {
        border: 2px dashed #e2e8f0;
        border-radius: 10px;
        background-color: #fafbfc;
        transition: all 0.2s ease;
    }
    .preview-box-custom:hover {
        border-color: #10b981;
        background-color: #f0fdf4;
    }
    .dynamic-item-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        transition: border-color 0.15s ease, box-shadow 0.15s ease;
    }
    .dynamic-item-card:hover {
        border-color: #cbd5e1;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.04);
    }
</style>
@endpush

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md rounded-circle d-flex align-items-center justify-content-center text-white" style="background-color: #064e3b; width: 42px; height: 42px;">
                        <i class="ti ti-settings fs-4"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold text-dark">Pengaturan Landing Page Unit</h4>
                        <p class="text-muted mb-0 small">Kustomisasi konten, banner, foto fasilitas & testimoni unit <strong class="text-dark">{{ $unit->nama_unit }}</strong></p>
                    </div>
                </div>
                <div class="d-flex flex-column align-items-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('unit.index') }}" class="text-muted">
                                    <i class="ti ti-building-community me-1"></i> Data Master Unit
                                </a>
                            </li>
                            <li class="breadcrumb-item active text-dark fw-semibold">
                                <i class="ti ti-browser me-1"></i> Setting Landing
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

<form action="{{ route('unit.update-landing-setting', Crypt::encrypt($unit->kode_unit)) }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row g-4">
        <!-- Sidebar Navigation Tabs -->
        <div class="col-lg-3 col-md-4">
            <div class="landing-sidebar-card sticky-top" style="top: 20px; z-index: 10;">
                <div class="sidebar-unit-header d-flex align-items-center gap-3">
                    @if ($unit->logo && Storage::disk('public')->exists($unit->logo))
                        <div class="p-1 bg-white rounded-2 border flex-shrink-0">
                            <img src="{{ asset('storage/' . $unit->logo) }}" alt="Logo" style="height: 32px; width: 32px; object-fit: contain;">
                        </div>
                    @else
                        <div class="avatar avatar-sm bg-label-success rounded-2 flex-shrink-0">
                            <i class="ti ti-building-community fs-5"></i>
                        </div>
                    @endif
                    <div class="overflow-hidden">
                        <span class="badge bg-label-success font-monospace px-1.5 py-0.5" style="font-size: 0.7rem;">{{ $unit->kode_unit }}</span>
                        <div class="fw-bold text-dark text-truncate small mt-0.5">{{ $unit->nama_unit }}</div>
                    </div>
                </div>

                <div class="nav nav-pills nav-landing-menu" id="landingTab" role="tablist">
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

                <div class="p-3 border-top bg-white">
                    <button type="submit" class="btn text-white w-100 d-flex align-items-center justify-content-center gap-2 py-2 fw-semibold shadow-none" style="background-color: #064e3b; border-radius: 8px;">
                        <i class="ti ti-device-floppy fs-5"></i>
                        <span>Simpan Perubahan</span>
                    </button>
                    <a href="{{ route('unit.index') }}" class="btn btn-outline-secondary w-100 mt-2 py-1.5" style="border-radius: 8px; font-size: 0.85rem;">
                        <i class="ti ti-arrow-left me-1"></i> Kembali ke Unit
                    </a>
                </div>
            </div>
        </div>

        <!-- Tab Content Area -->
        <div class="col-lg-9 col-md-8">
            <div class="tab-content p-0 shadow-none border-0" id="landingTabContent">

                <!-- TAB 1: HERO & MODEL -->
                <div class="tab-pane fade show active" id="tab-hero" role="tabpanel">
                    <div class="landing-card p-4 mb-4">
                        <div class="section-banner-title d-flex align-items-center justify-content-between mb-4">
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar avatar-xs bg-success text-white rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="ti ti-device-laptop fs-6"></i>
                                </div>
                                <h6 class="mb-0 fw-bold text-success">Hero Section & Visual Model</h6>
                            </div>
                            <span class="badge bg-white text-success border border-success border-opacity-25 px-2.5 py-1">Bagian Teratas Web</span>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label-custom">Hero Tag / Kategori Kecil</label>
                                <input type="text" class="form-control form-control-custom" name="hero_tag" value="{{ old('hero_tag', $setting->hero_tag) }}" placeholder="Contoh: Pendidikan Anak Usia Dini Berkarakter Islami">
                                <small class="text-muted">Muncul sebagai pill badge di bagian atas headline.</small>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label-custom">Judul Prefix (Teks Normal)</label>
                                <input type="text" class="form-control form-control-custom" name="hero_title_prefix" value="{{ old('hero_title_prefix', $setting->hero_title_prefix) }}" placeholder="Contoh: Membentuk Karakter & Potensi">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label-custom">Judul Highlight (Teks Warna / Aksen)</label>
                                <input type="text" class="form-control form-control-custom" name="hero_title_highlight" value="{{ old('hero_title_highlight', $setting->hero_title_highlight) }}" placeholder="Contoh: Anak Usia Dini Islami">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label-custom">Deskripsi Hero</label>
                                <textarea class="form-control form-control-custom" name="hero_description" rows="3" placeholder="Tuliskan deskripsi memikat mengenai keunggulan unit...">{{ old('hero_description', $setting->hero_description) }}</textarea>
                            </div>

                            <!-- Upload Background Image Hero -->
                            <div class="col-md-12 mt-4">
                                <div class="form-sub-section">
                                    <div class="form-sub-section-header">
                                        <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                                            <i class="ti ti-photo text-success"></i> Foto Background Hero Section (Latar Belakang)
                                        </h6>
                                    </div>
                                    <div class="row align-items-center g-3">
                                        <div class="col-md-7">
                                            <label class="form-label-custom">Upload Foto Background Baru (Landscape JPG / PNG / WebP)</label>
                                            <input type="file" class="form-control form-control-custom" name="hero_background_image" accept="image/*">
                                            <div class="alert alert-success border border-success border-opacity-25 py-2 px-3 mt-2 mb-0 d-flex align-items-center gap-2" style="background-color: #f0fdf4; border-color: #bbf7d0;">
                                                <i class="ti ti-info-circle text-success fs-5"></i>
                                                <small style="color: #166534;">Disarankan resolusi landscape (min. 1920x1080px). Sistem otomatis mengompresi ke <strong>WebP</strong>.</small>
                                            </div>
                                        </div>
                                        <div class="col-md-5 text-center">
                                            <label class="form-label-custom d-block text-start">Background Aktif</label>
                                            <div class="preview-box-custom p-2 d-flex align-items-center justify-content-center" style="min-height: 130px;">
                                                @if ($setting->hero_background_image && Storage::disk('public')->exists($setting->hero_background_image))
                                                    <img src="{{ asset('storage/' . $setting->hero_background_image) }}" alt="Hero Background" class="img-fluid rounded" style="max-height: 120px; width: 100%; object-fit: cover;">
                                                @else
                                                    <span class="text-muted small"><i class="ti ti-photo-off me-1"></i> Menggunakan background default template</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Upload Visual Model -->
                            <div class="col-md-12 mt-3">
                                <div class="form-sub-section">
                                    <div class="form-sub-section-header">
                                        <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                                            <i class="ti ti-camera text-success"></i> Foto Model Hero Siswa / Siswi
                                        </h6>
                                    </div>
                                    <div class="row align-items-center g-3">
                                        <div class="col-md-7">
                                            <label class="form-label-custom">Upload Foto Model Baru (Transparan PNG / WebP)</label>
                                            <input type="file" class="form-control form-control-custom" name="hero_model_image" accept="image/*">
                                            <div class="alert alert-success border border-success border-opacity-25 py-2 px-3 mt-2 mb-0 d-flex align-items-center gap-2" style="background-color: #f0fdf4; border-color: #bbf7d0;">
                                                <i class="ti ti-info-circle text-success fs-5"></i>
                                                <small style="color: #166534;">Sistem otomatis mengompresi ke <strong>WebP kualitas tinggi</strong> untuk loading cepat.</small>
                                            </div>
                                        </div>
                                        <div class="col-md-5 text-center">
                                            <label class="form-label-custom d-block text-start">Foto Model Aktif</label>
                                            <div class="preview-box-custom p-2 d-flex align-items-center justify-content-center" style="min-height: 130px;">
                                                @if ($setting->hero_model_image && Storage::disk('public')->exists($setting->hero_model_image))
                                                    <img src="{{ asset('storage/' . $setting->hero_model_image) }}" alt="Hero Model" class="img-fluid rounded" style="max-height: 120px; object-fit: contain;">
                                                @else
                                                    <span class="text-muted small"><i class="ti ti-photo-off me-1"></i> Menggunakan model default template</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Badges Hero -->
                            <div class="col-md-12 mt-3">
                                <div class="form-sub-section">
                                    <div class="form-sub-section-header">
                                        <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                                            <i class="ti ti-sparkles text-warning"></i> Badge Aksen Pendaftaran (Floating Hero)
                                        </h6>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="form-label-custom">Teks Badge Utama</label>
                                            <input type="text" class="form-control form-control-custom" name="hero_badge_text" value="{{ old('hero_badge_text', $setting->hero_badge_text) }}" placeholder="Contoh: Buka Pendaftaran">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label-custom">Subteks Badge</label>
                                            <input type="text" class="form-control form-control-custom" name="hero_badge_subtext" value="{{ old('hero_badge_subtext', $setting->hero_badge_subtext) }}" placeholder="Contoh: Tahun Ajaran 2026/2027">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label-custom">Status Badge</label>
                                            <input type="text" class="form-control form-control-custom" name="hero_badge_status" value="{{ old('hero_badge_status', $setting->hero_badge_status) }}" placeholder="Contoh: Kuota Terbatas">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 3 Feature Badges on Bottom Hero Section -->
                            <div class="col-md-12 mt-3">
                                <div class="form-sub-section">
                                        <div class="form-sub-section-header">
                                            <div>
                                                <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                                                    <i class="ti ti-badge text-success"></i> 3 Kartu Fitur Hero Section (Bawah Tombol CTA)
                                                </h6>
                                                <small class="text-muted">3 pilar poin ringkas yang tampil di baris bawah teks Hero (Contoh: Kurikulum Terpadu, Pendidik Berdedikasi, Lingkungan Kondusif).</small>
                                            </div>
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
                                        <div class="row g-3">
                                            @for($hf = 0; $hf < 3; $hf++)
                                                @php
                                                    $fVal = $currFeatures[$hf] ?? ($defaultHeroFeatures[$hf] ?? ['icon' => 'ti-star', 'title' => '', 'desc' => '']);
                                                @endphp
                                                <div class="col-md-4">
                                                    <div class="dynamic-item-card p-3 h-100">
                                                        <div class="d-flex align-items-center gap-2 mb-2 pb-2 border-bottom">
                                                            <span class="badge bg-success bg-opacity-10 text-success fw-bold">Fitur {{ $hf + 1 }}</span>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="form-label-custom">Icon Tabler</label>
                                                            <input type="text" class="form-control form-control-custom" name="hero_features[{{ $hf }}][icon]" value="{{ old("hero_features.{$hf}.icon", $fVal['icon'] ?? 'ti-star') }}" placeholder="Contoh: ti-book / ti-certificate">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="form-label-custom">Judul Fitur</label>
                                                            <input type="text" class="form-control form-control-custom" name="hero_features[{{ $hf }}][title]" value="{{ old("hero_features.{$hf}.title", $fVal['title'] ?? '') }}" placeholder="Contoh: Kurikulum Terpadu">
                                                        </div>
                                                        <div>
                                                            <label class="form-label-custom">Subjudul / Keterangan</label>
                                                            <input type="text" class="form-control form-control-custom" name="hero_features[{{ $hf }}][desc]" value="{{ old("hero_features.{$hf}.desc", $fVal['desc'] ?? '') }}" placeholder="Contoh: Kemenag & Pesantren">
                                                        </div>
                                                    </div>
                                                </div>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 2: STATISTIK & ANGKA -->
                <div class="tab-pane fade" id="tab-stats" role="tabpanel">
                    <div class="landing-card p-4 mb-4">
                        <div class="section-banner-title d-flex align-items-center justify-content-between mb-4">
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar avatar-xs bg-success text-white rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="ti ti-chart-bar fs-6"></i>
                                </div>
                                <h6 class="mb-0 fw-bold text-success">Statistik & Highlight Angka</h6>
                            </div>
                            <span class="badge bg-white text-success border border-success border-opacity-25 px-2.5 py-1">Counter Kredibilitas</span>
                        </div>

                        <p class="text-muted small mb-4">4 kartu highlight angka di bawah hero section untuk memperkuat citra dan reputasi keunggulan unit.</p>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="dynamic-item-card p-3">
                                    <div class="d-flex align-items-center gap-2 mb-2 pb-2 border-bottom">
                                        <span class="badge bg-success bg-opacity-10 text-success fw-bold">01</span>
                                        <h6 class="mb-0 fw-bold text-dark">Highlight 1</h6>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label-custom">Nilai / Angka Highlight</label>
                                        <input type="text" class="form-control form-control-custom" name="stat_1_val" value="{{ old('stat_1_val', $setting->stat_1_val) }}" placeholder="Contoh: A / 100%">
                                    </div>
                                    <div>
                                        <label class="form-label-custom">Keterangan Label</label>
                                        <input type="text" class="form-control form-control-custom" name="stat_1_label" value="{{ old('stat_1_label', $setting->stat_1_label) }}" placeholder="Contoh: Akreditasi BAN-SM">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="dynamic-item-card p-3">
                                    <div class="d-flex align-items-center gap-2 mb-2 pb-2 border-bottom">
                                        <span class="badge bg-success bg-opacity-10 text-success fw-bold">02</span>
                                        <h6 class="mb-0 fw-bold text-dark">Highlight 2</h6>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label-custom">Nilai / Angka Highlight</label>
                                        <input type="text" class="form-control form-control-custom" name="stat_2_val" value="{{ old('stat_2_val', $setting->stat_2_val) }}" placeholder="Contoh: 1:10 / 15+">
                                    </div>
                                    <div>
                                        <label class="form-label-custom">Keterangan Label</label>
                                        <input type="text" class="form-control form-control-custom" name="stat_2_label" value="{{ old('stat_2_label', $setting->stat_2_label) }}" placeholder="Contoh: Rasio Guru & Siswa">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="dynamic-item-card p-3">
                                    <div class="d-flex align-items-center gap-2 mb-2 pb-2 border-bottom">
                                        <span class="badge bg-success bg-opacity-10 text-success fw-bold">03</span>
                                        <h6 class="mb-0 fw-bold text-dark">Highlight 3</h6>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label-custom">Nilai / Angka Highlight</label>
                                        <input type="text" class="form-control form-control-custom" name="stat_3_val" value="{{ old('stat_3_val', $setting->stat_3_val) }}" placeholder="Contoh: 30+ / 10+">
                                    </div>
                                    <div>
                                        <label class="form-label-custom">Keterangan Label</label>
                                        <input type="text" class="form-control form-control-custom" name="stat_3_label" value="{{ old('stat_3_label', $setting->stat_3_label) }}" placeholder="Contoh: Program & Kegiatan Seru">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="dynamic-item-card p-3">
                                    <div class="d-flex align-items-center gap-2 mb-2 pb-2 border-bottom">
                                        <span class="badge bg-success bg-opacity-10 text-success fw-bold">04</span>
                                        <h6 class="mb-0 fw-bold text-dark">Highlight 4</h6>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label-custom">Nilai / Angka Highlight</label>
                                        <input type="text" class="form-control form-control-custom" name="stat_4_val" value="{{ old('stat_4_val', $setting->stat_4_val) }}" placeholder="Contoh: 500+ / 98%">
                                    </div>
                                    <div>
                                        <label class="form-label-custom">Keterangan Label</label>
                                        <input type="text" class="form-control form-control-custom" name="stat_4_label" value="{{ old('stat_4_label', $setting->stat_4_label) }}" placeholder="Contoh: Lulusan Berprestasi">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 3: PRAKATA PIMPINAN -->
                <div class="tab-pane fade" id="tab-prakata" role="tabpanel">
                    <div class="landing-card p-4 mb-4">
                        <div class="section-banner-title d-flex align-items-center justify-content-between mb-4">
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar avatar-xs bg-success text-white rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="ti ti-user-check fs-6"></i>
                                </div>
                                <h6 class="mb-0 fw-bold text-success">Prakata Kepala Sekolah / Pimpinan</h6>
                            </div>
                            <span class="badge bg-white text-success border border-success border-opacity-25 px-2.5 py-1">Sambutan Resmi</span>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label-custom">Tag Prakata</label>
                                <input type="text" class="form-control form-control-custom" name="prakata_tag" value="{{ old('prakata_tag', $setting->prakata_tag) }}" placeholder="Contoh: Sambutan Kepala Sekolah">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom">Judul Sambutan</label>
                                <input type="text" class="form-control form-control-custom" name="prakata_title" value="{{ old('prakata_title', $setting->prakata_title) }}" placeholder="Contoh: Membina Fitrah, Menemani Langkah">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label-custom">Quote Singkat (Highlight Box)</label>
                                <input type="text" class="form-control form-control-custom" name="prakata_quote" value="{{ old('prakata_quote', $setting->prakata_quote) }}" placeholder="Contoh: Setiap anak adalah amanah berharga yang membawa potensi unik masing-masing.">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label-custom">Teks Sambutan Lengkap</label>
                                <textarea class="form-control form-control-custom" name="prakata_content" rows="6" placeholder="Tuliskan isi sambutan lengkap kepala sekolah...">{{ old('prakata_content', $setting->prakata_content) }}</textarea>
                            </div>

                            <div class="col-md-12 mt-3">
                                <div class="form-sub-section">
                                    <div class="form-sub-section-header">
                                        <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                                            <i class="ti ti-user text-success"></i> Identitas & Foto Kepala Sekolah (Opsional Override)
                                        </h6>
                                    </div>
                                    <div class="row align-items-center g-3">
                                        <div class="col-md-4">
                                            <label class="form-label-custom">Nama Lengkap & Gelar</label>
                                            <input type="text" class="form-control form-control-custom" name="prakata_custom_nama" value="{{ old('prakata_custom_nama', $setting->prakata_custom_nama) }}" placeholder="Contoh: Ustzh. Siti Aminah, S.Pd.I">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label-custom">Jabatan</label>
                                            <input type="text" class="form-control form-control-custom" name="prakata_custom_jabatan" value="{{ old('prakata_custom_jabatan', $setting->prakata_custom_jabatan) }}" placeholder="Contoh: Kepala Sekolah TK Calisa Rabbani">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label-custom">Upload Foto Khusus</label>
                                            <input type="file" class="form-control form-control-custom" name="prakata_custom_foto" accept="image/*">
                                        </div>
                                        <div class="col-md-12 text-center mt-2">
                                            <div class="preview-box-custom p-2 d-flex align-items-center justify-content-center" style="min-height: 90px;">
                                                @if ($setting->prakata_custom_foto && Storage::disk('public')->exists($setting->prakata_custom_foto))
                                                    <img src="{{ asset('storage/' . $setting->prakata_custom_foto) }}" alt="Foto Kepala Sekolah" class="img-fluid rounded" style="max-height: 80px; object-fit: contain;">
                                                @else
                                                    <span class="text-muted small"><i class="ti ti-user me-1"></i> Menggunakan foto dari data master karyawan jika ada</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 4: PROGRAM UNGGULAN (DYNAMIC REPEATER) -->
                <div class="tab-pane fade" id="tab-program" role="tabpanel">
                    <div class="landing-card p-4 mb-4">
                        <div class="section-banner-title d-flex align-items-center justify-content-between mb-4">
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar avatar-xs bg-success text-white rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="ti ti-stars fs-6"></i>
                                </div>
                                <h6 class="mb-0 fw-bold text-success">Header & Daftar Program Unggulan</h6>
                            </div>
                            <span class="badge bg-white text-success border border-success border-opacity-25 px-2.5 py-1">Dinamis</span>
                        </div>

                        <!-- Header Program -->
                        <div class="row g-3 mb-4 pb-3 border-bottom">
                            <div class="col-md-4">
                                <label class="form-label-custom">Tag Seksi</label>
                                <input type="text" class="form-control form-control-custom" name="program_tag" value="{{ old('program_tag', $setting->program_tag) }}" placeholder="Contoh: Kurikulum & Pembelajaran">
                            </div>
                            <div class="col-md-8">
                                <label class="form-label-custom">Judul Seksi</label>
                                <input type="text" class="form-control form-control-custom" name="program_title" value="{{ old('program_title', $setting->program_title) }}" placeholder="Contoh: Program Unggulan TK">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label-custom">Deskripsi Pengantar</label>
                                <textarea class="form-control form-control-custom" name="program_description" rows="2" placeholder="Deskripsi pengantar seksi program unggulan...">{{ old('program_description', $setting->program_description) }}</textarea>
                            </div>
                        </div>

                        <!-- Repeater Program Items -->
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                                <i class="ti ti-list-check text-success"></i> Item Kartu Program Unggulan
                            </h6>
                            <button type="button" class="btn btn-sm btn-outline-success d-flex align-items-center gap-1.5 fw-semibold" id="btn-add-program">
                                <i class="ti ti-plus"></i> Tambah Program
                            </button>
                        </div>

                        @php
                            $currentPrograms = $setting->custom_programs ?? [
                                ['title' => 'Tahfidz & Doa Harian', 'badge' => 'Target: Juz 30', 'desc' => 'Bimbingan hafalan surat-surat pendek, doa harian, dan hadits adab dengan metode talaqqi ceria berirama.', 'item_1' => 'Talaqqi', 'item_2' => 'Tahsin & Adab', 'icon' => 'ti ti-book-2', 'image' => ''],
                                ['title' => 'Calistung Ceria (Fun Literacy)', 'badge' => 'Usia: 3-6 Tahun', 'desc' => 'Mengenal huruf, kata, membaca suku kata, dan berhitung angka melalui permainan edukatif yang mengasyikkan.', 'item_1' => 'Sentra', 'item_2' => 'Interaktif', 'icon' => 'ti ti-pencil', 'image' => ''],
                                ['title' => 'Adab, Motorik & Outing Class', 'badge' => 'Karakter Rabbani', 'desc' => 'Praktek shalat dhuha bersama, pembiasaan kemandirian, senam motorik, manasik haji cilik, dan eksplorasi alam terbuka.', 'item_1' => 'Harian', 'item_2' => 'Outbound', 'icon' => 'ti ti-compass', 'image' => ''],
                            ];
                        @endphp

                        <div id="program-container" class="d-flex flex-column gap-3">
                            @foreach($currentPrograms as $pIdx => $pVal)
                                <div class="dynamic-item-card p-3 program-item" data-index="{{ $pIdx }}">
                                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="badge bg-success text-white fw-bold item-number">{{ $pIdx + 1 }}</span>
                                            <h6 class="mb-0 fw-bold text-dark item-title">Program {{ $pIdx + 1 }}: {{ $pVal['title'] ?? '' }}</h6>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-label-danger border btn-remove-program px-2 py-1" title="Hapus Program">
                                            <i class="ti ti-trash fs-6"></i> Hapus
                                        </button>
                                    </div>

                                    <input type="hidden" name="program_items[{{ $pIdx }}][old_image]" value="{{ $pVal['image'] ?? '' }}">

                                    <div class="row g-3 align-items-center">
                                        <div class="col-md-5">
                                            <label class="form-label-custom">Nama Program</label>
                                            <input type="text" class="form-control form-control-custom" name="program_items[{{ $pIdx }}][title]" value="{{ old("program_items.{$pIdx}.title", $pVal['title'] ?? '') }}" placeholder="Contoh: Tahfidz Ceria">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label-custom">Badge / Target</label>
                                            <input type="text" class="form-control form-control-custom" name="program_items[{{ $pIdx }}][badge]" value="{{ old("program_items.{$pIdx}.badge", $pVal['badge'] ?? '') }}" placeholder="Contoh: Target: Juz 30">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label-custom">Upload Foto Program</label>
                                            <input type="file" class="form-control form-control-custom bg-white" name="program_items[{{ $pIdx }}][image]" accept="image/*">
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label-custom">Poin 1 (Metode)</label>
                                            <input type="text" class="form-control form-control-custom" name="program_items[{{ $pIdx }}][item_1]" value="{{ old("program_items.{$pIdx}.item_1", $pVal['item_1'] ?? '') }}" placeholder="Contoh: Talaqqi">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label-custom">Poin 2 (Fokus)</label>
                                            <input type="text" class="form-control form-control-custom" name="program_items[{{ $pIdx }}][item_2]" value="{{ old("program_items.{$pIdx}.item_2", $pVal['item_2'] ?? '') }}" placeholder="Contoh: Tahsin & Adab">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label-custom">Icon Tabler (Opsional)</label>
                                            <input type="text" class="form-control form-control-custom" name="program_items[{{ $pIdx }}][icon]" value="{{ old("program_items.{$pIdx}.icon", $pVal['icon'] ?? 'ti ti-star') }}" placeholder="ti ti-book-2">
                                        </div>
                                        <div class="col-md-3 text-center">
                                            <label class="form-label-custom d-block text-start">Foto Saat Ini</label>
                                            <div class="preview-box-custom p-1 d-flex align-items-center justify-content-center" style="height: 48px;">
                                                @if(!empty($pVal['image']))
                                                    <img src="{{ str_starts_with($pVal['image'], 'http') ? $pVal['image'] : asset('storage/' . $pVal['image']) }}" alt="Foto" class="rounded" style="max-height: 40px; max-width: 100%; object-fit: cover;">
                                                @else
                                                    <span class="text-muted small" style="font-size: 0.75rem;"><i class="ti ti-photo me-1"></i> Default</span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <label class="form-label-custom">Deskripsi Singkat Program</label>
                                            <textarea class="form-control form-control-custom" name="program_items[{{ $pIdx }}][desc]" rows="2" placeholder="Jelaskan mengenai program ini...">{{ old("program_items.{$pIdx}.desc", $pVal['desc'] ?? '') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- TAB 5: FASILITAS & FOTO (DYNAMIC REPEATER) -->
                <div class="tab-pane fade" id="tab-fasilitas" role="tabpanel">
                    <div class="landing-card p-4 mb-4">
                        <div class="section-banner-title d-flex align-items-center justify-content-between mb-4">
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar avatar-xs bg-success text-white rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="ti ti-building fs-6"></i>
                                </div>
                                <h6 class="mb-0 fw-bold text-success">Fasilitas Belajar & Upload Foto Sarana</h6>
                            </div>
                            <span class="badge bg-white text-success border border-success border-opacity-25 px-2.5 py-1">Dinamis</span>
                        </div>

                        <!-- Header Fasilitas -->
                        <div class="row g-3 mb-4 pb-3 border-bottom">
                            <div class="col-md-4">
                                <label class="form-label-custom">Tag Seksi Fasilitas</label>
                                <input type="text" class="form-control form-control-custom" name="fasilitas_tag" value="{{ old('fasilitas_tag', $setting->fasilitas_tag) }}" placeholder="Contoh: Lingkungan & Sarana">
                            </div>
                            <div class="col-md-8">
                                <label class="form-label-custom">Judul Seksi Fasilitas</label>
                                <input type="text" class="form-control form-control-custom" name="fasilitas_title" value="{{ old('fasilitas_title', $setting->fasilitas_title) }}" placeholder="Contoh: Fasilitas Ramah Anak">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label-custom">Deskripsi Pengantar</label>
                                <textarea class="form-control form-control-custom" name="fasilitas_description" rows="2" placeholder="Deskripsi sarana belajar...">{{ old('fasilitas_description', $setting->fasilitas_description) }}</textarea>
                            </div>
                        </div>

                        <!-- Repeater Fasilitas Items -->
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                                <i class="ti ti-photo-plus text-success"></i> Item Kartu Fasilitas (Foto & Deskripsi)
                            </h6>
                            <button type="button" class="btn btn-sm btn-outline-success d-flex align-items-center gap-1.5 fw-semibold" id="btn-add-fasilitas">
                                <i class="ti ti-plus"></i> Tambah Fasilitas
                            </button>
                        </div>

                        @php
                            $currentFasilitas = $setting->custom_fasilitas ?? [
                                ['tag' => 'RUANG KELAS', 'name' => 'Ruang Belajar Ber-AC & Nyaman', 'desc' => 'Ruang kelas berpendingin udara dengan pencahayaan alami yang cerah dan media peraga edukatif lengkap.', 'image' => ''],
                                ['tag' => 'PLAYGROUND', 'name' => 'Area Bermain & Stimulasi Motorik', 'desc' => 'Wahana permainan luar dan dalam ruangan yang aman untuk melatih ketangkasan serta sosialisasi santri.', 'image' => ''],
                                ['tag' => 'IBADAH', 'name' => 'Sentra Ibadah & Tempat Wudhu Cilik', 'desc' => 'Tempat wudhu khusus anak dan ruang shalat berjamaah untuk menanamkan kedisiplinan ibadah sejak dini.', 'image' => ''],
                            ];
                        @endphp

                        <div id="fasilitas-container" class="d-flex flex-column gap-3">
                            @foreach($currentFasilitas as $fIdx => $fVal)
                                <div class="dynamic-item-card p-3 fasilitas-item" data-index="{{ $fIdx }}">
                                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="badge bg-success text-white fw-bold item-number">{{ $fIdx + 1 }}</span>
                                            <h6 class="mb-0 fw-bold text-dark item-title">Fasilitas {{ $fIdx + 1 }}: {{ $fVal['name'] ?? '' }}</h6>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-label-danger border btn-remove-fasilitas px-2 py-1" title="Hapus Fasilitas">
                                            <i class="ti ti-trash fs-6"></i> Hapus
                                        </button>
                                    </div>

                                    <input type="hidden" name="fasilitas_items[{{ $fIdx }}][old_image]" value="{{ $fVal['image'] ?? '' }}">

                                    <div class="row g-3 align-items-center">
                                        <div class="col-md-3">
                                            <label class="form-label-custom">Tag Stiker Atas</label>
                                            <input type="text" class="form-control form-control-custom" name="fasilitas_items[{{ $fIdx }}][tag]" value="{{ old("fasilitas_items.{$fIdx}.tag", $fVal['tag'] ?? '') }}" placeholder="Contoh: RUANG KELAS">
                                        </div>
                                        <div class="col-md-5">
                                            <label class="form-label-custom">Nama Fasilitas</label>
                                            <input type="text" class="form-control form-control-custom" name="fasilitas_items[{{ $fIdx }}][name]" value="{{ old("fasilitas_items.{$fIdx}.name", $fVal['name'] ?? '') }}" placeholder="Contoh: Ruang Belajar Nyaman">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label-custom">Ganti / Upload Foto Sarana</label>
                                            <input type="file" class="form-control form-control-custom bg-white" name="fasilitas_items[{{ $fIdx }}][image]" accept="image/*">
                                        </div>

                                        <div class="col-md-9">
                                            <label class="form-label-custom">Deskripsi Fasilitas</label>
                                            <textarea class="form-control form-control-custom" name="fasilitas_items[{{ $fIdx }}][desc]" rows="2" placeholder="Jelaskan fasilitas ini...">{{ old("fasilitas_items.{$fIdx}.desc", $fVal['desc'] ?? '') }}</textarea>
                                        </div>
                                        <div class="col-md-3 text-center">
                                            <label class="form-label-custom d-block text-start">Foto Saat Ini</label>
                                            <div class="preview-box-custom p-1 d-flex align-items-center justify-content-center" style="height: 52px;">
                                                @if(!empty($fVal['image']))
                                                    <img src="{{ str_starts_with($fVal['image'], 'http') ? $fVal['image'] : asset('storage/' . $fVal['image']) }}" alt="Foto" class="rounded" style="max-height: 44px; max-width: 100%; object-fit: cover;">
                                                @else
                                                    <span class="text-muted small" style="font-size: 0.75rem;"><i class="ti ti-photo me-1"></i> Default</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- TAB 6: TESTIMONI & AVATAR (DYNAMIC REPEATER) -->
                <div class="tab-pane fade" id="tab-testimoni" role="tabpanel">
                    <div class="landing-card p-4 mb-4">
                        <div class="section-banner-title d-flex align-items-center justify-content-between mb-4">
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar avatar-xs bg-success text-white rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="ti ti-message-2-heart fs-6"></i>
                                </div>
                                <h6 class="mb-0 fw-bold text-success">Testimoni Wali Santri & Foto Profil</h6>
                            </div>
                            <span class="badge bg-white text-success border border-success border-opacity-25 px-2.5 py-1">Dinamis</span>
                        </div>

                        <!-- Header Testimoni -->
                        <div class="row g-3 mb-4 pb-3 border-bottom">
                            <div class="col-md-4">
                                <label class="form-label-custom">Tag Seksi Testimoni</label>
                                <input type="text" class="form-control form-control-custom" name="testimoni_tag" value="{{ old('testimoni_tag', $setting->testimoni_tag) }}" placeholder="Contoh: Testimoni & Pengalaman">
                            </div>
                            <div class="col-md-8">
                                <label class="form-label-custom">Judul Seksi Testimoni</label>
                                <input type="text" class="form-control form-control-custom" name="testimoni_title" value="{{ old('testimoni_title', $setting->testimoni_title) }}" placeholder="Contoh: Apa Kata Orang Tua Santri?">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label-custom">Deskripsi Pengantar</label>
                                <textarea class="form-control form-control-custom" name="testimoni_description" rows="2" placeholder="Deskripsi kata orang tua...">{{ old('testimoni_description', $setting->testimoni_description) }}</textarea>
                            </div>
                        </div>

                        <!-- Foto Galeri Samping Testimoni (3 Foto Galeri / Kegiatan Santri) -->
                        <div class="form-sub-section mb-4">
                            <div class="form-sub-section-header">
                                <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                                    <i class="ti ti-photo-plus text-success"></i> 3 Foto Dokumentasi Kegiatan (Samping Testimoni)
                                </h6>
                            </div>
                            <div class="row g-3">
                                <!-- Foto 1 -->
                                <div class="col-md-4">
                                    <label class="form-label-custom">Foto Galeri 1 (Kiri Atas)</label>
                                    <input type="file" class="form-control form-control-custom bg-white" name="testimoni_image_1" accept="image/*">
                                    <div class="preview-box-custom p-1.5 mt-2 d-flex align-items-center justify-content-center" style="height: 90px;">
                                        @if ($setting->testimoni_image_1 && Storage::disk('public')->exists($setting->testimoni_image_1))
                                            <img src="{{ asset('storage/' . $setting->testimoni_image_1) }}" alt="Testimoni Foto 1" class="img-fluid rounded" style="max-height: 80px; width: 100%; object-fit: cover;">
                                        @else
                                            <span class="text-muted small" style="font-size: 0.75rem;"><i class="ti ti-photo me-1"></i> Foto Default 1</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Foto 2 -->
                                <div class="col-md-4">
                                    <label class="form-label-custom">Foto Galeri 2 (Tengah)</label>
                                    <input type="file" class="form-control form-control-custom bg-white" name="testimoni_image_2" accept="image/*">
                                    <div class="preview-box-custom p-1.5 mt-2 d-flex align-items-center justify-content-center" style="height: 90px;">
                                        @if ($setting->testimoni_image_2 && Storage::disk('public')->exists($setting->testimoni_image_2))
                                            <img src="{{ asset('storage/' . $setting->testimoni_image_2) }}" alt="Testimoni Foto 2" class="img-fluid rounded" style="max-height: 80px; width: 100%; object-fit: cover;">
                                        @else
                                            <span class="text-muted small" style="font-size: 0.75rem;"><i class="ti ti-photo me-1"></i> Foto Default 2</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Foto 3 -->
                                <div class="col-md-4">
                                    <label class="form-label-custom">Foto Galeri 3 (Kanan Bawah)</label>
                                    <input type="file" class="form-control form-control-custom bg-white" name="testimoni_image_3" accept="image/*">
                                    <div class="preview-box-custom p-1.5 mt-2 d-flex align-items-center justify-content-center" style="height: 90px;">
                                        @if ($setting->testimoni_image_3 && Storage::disk('public')->exists($setting->testimoni_image_3))
                                            <img src="{{ asset('storage/' . $setting->testimoni_image_3) }}" alt="Testimoni Foto 3" class="img-fluid rounded" style="max-height: 80px; width: 100%; object-fit: cover;">
                                        @else
                                            <span class="text-muted small" style="font-size: 0.75rem;"><i class="ti ti-photo me-1"></i> Foto Default 3</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Repeater Testimoni Items -->
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                                <i class="ti ti-user-circle text-success"></i> Item Kartu Testimoni (Foto Orang Tua & Ulasan)
                            </h6>
                            <button type="button" class="btn btn-sm btn-outline-success d-flex align-items-center gap-1.5 fw-semibold" id="btn-add-testimoni">
                                <i class="ti ti-plus"></i> Tambah Testimoni
                            </button>
                        </div>

                        @php
                            $currentTesti = $setting->custom_testimoni ?? [
                                ['nama' => 'Bunda Faris', 'role' => 'Wali Santri TK B', 'quote' => 'Alhamdulillah sejak sekolah di TK Calisa, ananda jadi rajin shalat, hafal surat-surat pendek dengan tartil, dan sangat mandiri.', 'avatar' => ''],
                                ['nama' => 'Ayah Rasyid', 'role' => 'Wali Santri TK A', 'quote' => 'Guru-gurunya sangat ramah, sabar, dan komunikatif. Laporan perkembangan anak setiap minggu sangat membantu kami mendampingi anak.', 'avatar' => ''],
                                ['nama' => 'Mama Aisha', 'role' => 'Wali Santri Playgroup', 'quote' => 'Fasilitas bermainnya bersih dan aman. Program calistungnya tidak membebani tapi justru membuat anak penasaran dan suka membaca.', 'avatar' => ''],
                            ];
                        @endphp

                        <div id="testimoni-container" class="d-flex flex-column gap-3">
                            @foreach($currentTesti as $tIdx => $tVal)
                                <div class="dynamic-item-card p-3 testimoni-item" data-index="{{ $tIdx }}">
                                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="badge bg-success text-white fw-bold item-number">{{ $tIdx + 1 }}</span>
                                            <h6 class="mb-0 fw-bold text-dark item-title">Testimoni {{ $tIdx + 1 }}: {{ $tVal['nama'] ?? '' }}</h6>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-label-danger border btn-remove-testimoni px-2 py-1" title="Hapus Testimoni">
                                            <i class="ti ti-trash fs-6"></i> Hapus
                                        </button>
                                    </div>

                                    <input type="hidden" name="testimoni_items[{{ $tIdx }}][old_avatar]" value="{{ $tVal['avatar'] ?? '' }}">

                                    <div class="row g-3 align-items-center">
                                        <div class="col-md-4">
                                            <label class="form-label-custom">Nama Orang Tua / Wali</label>
                                            <input type="text" class="form-control form-control-custom" name="testimoni_items[{{ $tIdx }}][nama]" value="{{ old("testimoni_items.{$tIdx}.nama", $tVal['nama'] ?? '') }}" placeholder="Contoh: Bunda Faris">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label-custom">Status / Keterangan</label>
                                            <input type="text" class="form-control form-control-custom" name="testimoni_items[{{ $tIdx }}][role]" value="{{ old("testimoni_items.{$tIdx}.role", $tVal['role'] ?? '') }}" placeholder="Contoh: Wali Santri TK B">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label-custom">Upload Foto Profil / Avatar</label>
                                            <input type="file" class="form-control form-control-custom bg-white" name="testimoni_items[{{ $tIdx }}][avatar]" accept="image/*">
                                        </div>

                                        <div class="col-md-9">
                                            <label class="form-label-custom">Isi Kutipan Ulasan / Testimoni</label>
                                            <textarea class="form-control form-control-custom" name="testimoni_items[{{ $tIdx }}][quote]" rows="2" placeholder="Tuliskan ulasan orang tua...">{{ old("testimoni_items.{$tIdx}.quote", $tVal['quote'] ?? '') }}</textarea>
                                        </div>
                                        <div class="col-md-3 text-center">
                                            <label class="form-label-custom d-block text-start">Avatar Saat Ini</label>
                                            <div class="preview-box-custom p-1 d-flex align-items-center justify-content-center" style="height: 52px;">
                                                @if(!empty($tVal['avatar']))
                                                    <img src="{{ str_starts_with($tVal['avatar'], 'http') ? $tVal['avatar'] : asset('storage/' . $tVal['avatar']) }}" alt="Avatar" class="rounded-circle" style="height: 44px; width: 44px; object-fit: cover;">
                                                @else
                                                    <span class="text-muted small" style="font-size: 0.75rem;"><i class="ti ti-user me-1"></i> Inisial</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- TAB 7: BANNER CTA & KONTAK -->
                <div class="tab-pane fade" id="tab-cta" role="tabpanel">
                    <div class="landing-card p-4 mb-4">
                        <div class="section-banner-title d-flex align-items-center justify-content-between mb-4">
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar avatar-xs bg-success text-white rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="ti ti-speakerphone fs-6"></i>
                                </div>
                                <h6 class="mb-0 fw-bold text-success">Banner Call-to-Action & Kontak Unit</h6>
                            </div>
                            <span class="badge bg-white text-success border border-success border-opacity-25 px-2.5 py-1">Konversi Pendaftaran</span>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label-custom">Tag Banner</label>
                                <input type="text" class="form-control form-control-custom" name="cta_tag" value="{{ old('cta_tag', $setting->cta_tag) }}" placeholder="Contoh: Buka Pendaftaran Siswa Baru">
                            </div>
                            <div class="col-md-8">
                                <label class="form-label-custom">Judul Utama Banner</label>
                                <input type="text" class="form-control form-control-custom" name="cta_title" value="{{ old('cta_title', $setting->cta_title) }}" placeholder="Contoh: Butuh Bantuan / Skema Pembayaran Bertahap?">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label-custom">Deskripsi Banner</label>
                                <textarea class="form-control form-control-custom" name="cta_description" rows="3" placeholder="Deskripsi konsultasi & ajakan pendaftaran...">{{ old('cta_description', $setting->cta_description) }}</textarea>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label-custom">Pesan Otomatis WhatsApp</label>
                                <input type="text" class="form-control form-control-custom" name="cta_wa_text" value="{{ old('cta_wa_text', $setting->cta_wa_text) }}" placeholder="Contoh: Halo Admin, saya ingin tanya rincian pendaftaran...">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom">Nomor WhatsApp CS Khusus Unit</label>
                                <input type="text" class="form-control form-control-custom" name="unit_whatsapp" value="{{ old('unit_whatsapp', $setting->unit_whatsapp) }}" placeholder="08xxxxxxxxxx">
                            </div>

                            <div class="col-md-12 mt-3">
                                <div class="form-sub-section">
                                    <div class="form-sub-section-header">
                                        <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                                            <i class="ti ti-brand-instagram text-danger"></i> Media Sosial & Kontak Tambahan
                                        </h6>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="form-label-custom">Telepon Kantor</label>
                                            <input type="text" class="form-control form-control-custom" name="unit_phone" value="{{ old('unit_phone', $setting->unit_phone) }}" placeholder="(0265) xxxxxx">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label-custom">Email Unit</label>
                                            <input type="email" class="form-control form-control-custom" name="unit_email" value="{{ old('unit_email', $setting->unit_email) }}" placeholder="unit@alamin.sch.id">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label-custom">Instagram</label>
                                            <input type="text" class="form-control form-control-custom" name="unit_instagram" value="{{ old('unit_instagram', $setting->unit_instagram) }}" placeholder="@tkcalisarabbani">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label-custom">Facebook</label>
                                            <input type="text" class="form-control form-control-custom" name="unit_facebook" value="{{ old('unit_facebook', $setting->unit_facebook) }}" placeholder="facebook.com/tkcalisa">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label-custom">YouTube Channel</label>
                                            <input type="text" class="form-control form-control-custom" name="unit_youtube" value="{{ old('unit_youtube', $setting->unit_youtube) }}" placeholder="youtube.com/@channel">
                                        </div>
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
                    <div class="dynamic-item-card p-3 program-item" data-index="${newIndex}">
                        <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-success text-white fw-bold item-number">${num}</span>
                                <h6 class="mb-0 fw-bold text-dark item-title">Program Baru ${num}</h6>
                            </div>
                            <button type="button" class="btn btn-sm btn-label-danger border btn-remove-program px-2 py-1" title="Hapus Program">
                                <i class="ti ti-trash fs-6"></i> Hapus
                            </button>
                        </div>
                        <input type="hidden" name="program_items[${newIndex}][old_image]" value="">
                        <div class="row g-3 align-items-center">
                            <div class="col-md-5">
                                <label class="form-label-custom">Nama Program</label>
                                <input type="text" class="form-control form-control-custom" name="program_items[${newIndex}][title]" placeholder="Contoh: Tahfidz Ceria">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label-custom">Badge / Target</label>
                                <input type="text" class="form-control form-control-custom" name="program_items[${newIndex}][badge]" placeholder="Contoh: Target: Juz 30">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label-custom">Upload Foto Program</label>
                                <input type="file" class="form-control form-control-custom bg-white" name="program_items[${newIndex}][image]" accept="image/*">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label-custom">Poin 1 (Metode)</label>
                                <input type="text" class="form-control form-control-custom" name="program_items[${newIndex}][item_1]" placeholder="Contoh: Talaqqi">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label-custom">Poin 2 (Fokus)</label>
                                <input type="text" class="form-control form-control-custom" name="program_items[${newIndex}][item_2]" placeholder="Contoh: Tahsin & Adab">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label-custom">Icon Tabler (Opsional)</label>
                                <input type="text" class="form-control form-control-custom" name="program_items[${newIndex}][icon]" value="ti ti-star" placeholder="ti ti-star">
                            </div>
                            <div class="col-md-3 text-center">
                                <label class="form-label-custom d-block text-start">Foto Saat Ini</label>
                                <div class="preview-box-custom p-1 d-flex align-items-center justify-content-center" style="height: 48px;">
                                    <span class="text-muted small" style="font-size: 0.75rem;"><i class="ti ti-photo me-1"></i> Baru</span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label-custom">Deskripsi Singkat Program</label>
                                <textarea class="form-control form-control-custom" name="program_items[${newIndex}][desc]" rows="2" placeholder="Jelaskan mengenai program ini..."></textarea>
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
                    // Re-number items
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
                    <div class="dynamic-item-card p-3 fasilitas-item" data-index="${newIndex}">
                        <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-success text-white fw-bold item-number">${num}</span>
                                <h6 class="mb-0 fw-bold text-dark item-title">Fasilitas Baru ${num}</h6>
                            </div>
                            <button type="button" class="btn btn-sm btn-label-danger border btn-remove-fasilitas px-2 py-1" title="Hapus Fasilitas">
                                <i class="ti ti-trash fs-6"></i> Hapus
                            </button>
                        </div>
                        <input type="hidden" name="fasilitas_items[${newIndex}][old_image]" value="">
                        <div class="row g-3 align-items-center">
                            <div class="col-md-3">
                                <label class="form-label-custom">Tag Stiker Atas</label>
                                <input type="text" class="form-control form-control-custom" name="fasilitas_items[${newIndex}][tag]" placeholder="Contoh: LAB KOMPUTER">
                            </div>
                            <div class="col-md-5">
                                <label class="form-label-custom">Nama Fasilitas</label>
                                <input type="text" class="form-control form-control-custom" name="fasilitas_items[${newIndex}][name]" placeholder="Contoh: Laboratorium Digital">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label-custom">Upload Foto Sarana</label>
                                <input type="file" class="form-control form-control-custom bg-white" name="fasilitas_items[${newIndex}][image]" accept="image/*">
                            </div>
                            <div class="col-md-9">
                                <label class="form-label-custom">Deskripsi Fasilitas</label>
                                <textarea class="form-control form-control-custom" name="fasilitas_items[${newIndex}][desc]" rows="2" placeholder="Jelaskan fasilitas ini..."></textarea>
                            </div>
                            <div class="col-md-3 text-center">
                                <label class="form-label-custom d-block text-start">Foto Saat Ini</label>
                                <div class="preview-box-custom p-1 d-flex align-items-center justify-content-center" style="height: 52px;">
                                    <span class="text-muted small" style="font-size: 0.75rem;"><i class="ti ti-photo me-1"></i> Baru</span>
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
                    // Re-number items
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
                    <div class="dynamic-item-card p-3 testimoni-item" data-index="${newIndex}">
                        <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-success text-white fw-bold item-number">${num}</span>
                                <h6 class="mb-0 fw-bold text-dark item-title">Testimoni Baru ${num}</h6>
                            </div>
                            <button type="button" class="btn btn-sm btn-label-danger border btn-remove-testimoni px-2 py-1" title="Hapus Testimoni">
                                <i class="ti ti-trash fs-6"></i> Hapus
                            </button>
                        </div>
                        <input type="hidden" name="testimoni_items[${newIndex}][old_avatar]" value="">
                        <div class="row g-3 align-items-center">
                            <div class="col-md-4">
                                <label class="form-label-custom">Nama Orang Tua / Wali</label>
                                <input type="text" class="form-control form-control-custom" name="testimoni_items[${newIndex}][nama]" placeholder="Contoh: Ibu Zahra">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label-custom">Status / Keterangan</label>
                                <input type="text" class="form-control form-control-custom" name="testimoni_items[${newIndex}][role]" placeholder="Contoh: Wali Santri">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label-custom">Upload Foto Profil / Avatar</label>
                                <input type="file" class="form-control form-control-custom bg-white" name="testimoni_items[${newIndex}][avatar]" accept="image/*">
                            </div>
                            <div class="col-md-9">
                                <label class="form-label-custom">Isi Kutipan Ulasan / Testimoni</label>
                                <textarea class="form-control form-control-custom" name="testimoni_items[${newIndex}][quote]" rows="2" placeholder="Tuliskan ulasan orang tua..."></textarea>
                            </div>
                            <div class="col-md-3 text-center">
                                <label class="form-label-custom d-block text-start">Avatar Saat Ini</label>
                                <div class="preview-box-custom p-1 d-flex align-items-center justify-content-center" style="height: 52px;">
                                    <span class="text-muted small" style="font-size: 0.75rem;"><i class="ti ti-user me-1"></i> Baru</span>
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
                    // Re-number items
                    testimoniContainer.querySelectorAll('.testimoni-item').forEach((el, idx) => {
                        el.querySelector('.item-number').textContent = idx + 1;
                    });
                }
            });
        }
    });
</script>
@endpush
@endsection

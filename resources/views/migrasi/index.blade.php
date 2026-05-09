@extends('layouts.app')
@section('titlepage', 'Migrasi Siswa')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-primary rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-database-import fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold">Migrasi Data Siswa</h4>
                        <p class="text-muted mb-0 small">Import data siswa lama secara massal ke dalam sistem Sipren</p>
                    </div>
                </div>
                <div class="d-flex flex-column align-items-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mb-0">
                            <li class="breadcrumb-item">
                                <a href="javascript:void(0);" class="text-muted">
                                    <i class="ti ti-home-2 me-1"></i> Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item">Konfigurasi</li>
                            <li class="breadcrumb-item active">Migrasi Siswa</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

<div class="row">
    <!-- Instructions Column -->
    <div class="col-lg-6 col-md-12 mb-4">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-header bg-label-info py-3">
                <h6 class="card-title mb-0 d-flex align-items-center gap-2">
                    <i class="ti ti-info-circle fs-5"></i>
                    Petunjuk Migrasi
                </h6>
            </div>
            <div class="card-body mt-3">
                <p>Fitur ini digunakan untuk memasukkan data siswa yang <b>sudah ada sebelum sistem Sipren digunakan</b>. Jangan gunakan fitur ini untuk Pendaftaran Siswa Baru (PPDB).</p>
                
                <div class="alert alert-success d-flex align-items-start mt-3 mb-3" role="alert">
                    <span class="alert-icon rounded-circle">
                        <i class="ti ti-star fs-5"></i>
                    </span>
                    <div class="ms-2">
                        <h6 class="alert-heading mb-1 fw-bold">Template Horizontal (Rekomendasi)</h6>
                        <p class="mb-0 small">Gunakan <b>Template Horizontal</b> untuk kemudahan input. Cukup 1 sheet, data siswa di kolom kiri dan kolom Tahun Ajaran melebar ke kanan dengan sub-kolom: <b>Tagihan</b>, <b>Jumlah Bayar</b>, dan <b>Sisa</b>.</p>
                    </div>
                </div>
                
                <h6 class="fw-bold mt-4">Tahapan (Horizontal):</h6>
                <ol class="ps-3 text-muted">
                    <li class="mb-2">Download <b>Template Horizontal</b>. Lihat sheet "Referensi" untuk kode Unit & TA.</li>
                    <li class="mb-2">Isi data siswa (NISN, Nama, JK, dll) di kolom A-G. <b>Satu baris = satu siswa.</b></li>
                    <li class="mb-2">Di kolom Tahun Ajaran, isi <b>Tagihan & Jumlah Bayar</b> untuk setiap TA yang siswa ikuti. Tingkat otomatis increment dari "Tingkat Masuk".</li>
                    <li class="mb-2">Upload file via form <b>"Upload Horizontal"</b>.</li>
                    <li>Sistem akan menampilkan Preview. Jika sudah benar, klik "Konfirmasi".</li>
                </ol>

                <div class="alert alert-info d-flex align-items-start mt-4 mb-3" role="alert">
                    <span class="alert-icon rounded-circle">
                        <i class="ti ti-bulb fs-5"></i>
                    </span>
                    <div class="ms-2">
                        <h6 class="alert-heading mb-1 fw-bold">Contoh: Siswa Tingkat 3 MTs</h6>
                        <p class="mb-0 small">Cukup isi 1 baris. Kolom A-G untuk data siswa, lalu:<br>
                        TA 2023/2024: Tagihan=250.000, Bayar=250.000, Sisa=0<br>
                        TA 2024/2025: Tagihan=250.000, Bayar=200.000, Sisa=50.000<br>
                        TA 2025/2026: Tagihan=250.000, Bayar=0, Sisa=250.000
                        </p>
                    </div>
                </div>

                <div class="alert alert-warning d-flex align-items-start mb-0" role="alert">
                    <span class="alert-icon bg-warning text-white rounded-circle">
                        <i class="ti ti-alert-triangle fs-5"></i>
                    </span>
                    <div class="ms-2">
                        <h6 class="alert-heading mb-1 fw-bold">Perhatian!</h6>
                        <p class="mb-0 small">Pastikan <b>Konfigurasi Biaya</b> sudah dibuat untuk <b>setiap TA dan tingkat</b> yang akan di-import.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions Column -->
    <div class="col-lg-6 col-md-12 mb-4">
        <div class="row">
            <!-- Step 1: Download Template Horizontal (Recommended) -->
            <div class="col-12 mb-4">
                <div class="card shadow-sm border-0 border-start border-success border-4">
                    <div class="card-body">
                        <h6 class="fw-bold"><span class="badge bg-success me-2">1</span> Download Template Horizontal <span class="badge bg-label-success ms-1">Rekomendasi</span></h6>
                        <p class="text-muted small mb-3">Template 1 sheet — data siswa di kiri, tahun ajaran melebar ke kanan. Lebih mudah dipahami dan diisi.</p>
                        <a href="{{ route('migrasi-siswa.download-template-horizontal') }}" class="btn btn-success w-100 shadow-sm d-flex align-items-center justify-content-center gap-2">
                            <i class="ti ti-download fs-5"></i> Download Template Horizontal
                        </a>
                    </div>
                </div>
            </div>

            <!-- Step 2: Upload Horizontal -->
            <div class="col-12 mb-4">
                <div class="card shadow-sm border-0 border-start border-primary border-4">
                    <div class="card-body">
                        <h6 class="fw-bold"><span class="badge bg-primary me-2">2</span> Upload File Horizontal</h6>
                        <p class="text-muted small mb-3">Upload file Excel horizontal yang sudah Anda isi. Tingkat naik otomatis dari tingkat masuk ke TA berikutnya.</p>
                        
                        <form action="{{ route('migrasi-siswa.upload-horizontal') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <label class="form-label fw-bold">File Excel Horizontal <span class="text-danger">*</span></label>
                                <input type="file" name="file_excel" class="form-control" accept=".xls,.xlsx" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 shadow-sm d-flex align-items-center justify-content-center gap-2">
                                <i class="ti ti-upload fs-5"></i> Upload dan Validasi Data
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Legacy: Multi-Sheet Template -->
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between" data-bs-toggle="collapse" data-bs-target="#legacyTemplate" style="cursor: pointer;">
                            <div>
                                <h6 class="fw-bold mb-0"><i class="ti ti-archive me-2 text-muted"></i>Template Multi-Sheet (Lama)</h6>
                                <p class="text-muted small mb-0">Klik untuk membuka template lama dengan format 3 sheet terpisah</p>
                            </div>
                            <i class="ti ti-chevron-down text-muted"></i>
                        </div>
                        <div class="collapse mt-3" id="legacyTemplate">
                            <div class="row g-2">
                                <div class="col-6">
                                    <a href="{{ route('migrasi-siswa.download-template') }}" class="btn btn-outline-secondary w-100 btn-sm d-flex align-items-center justify-content-center gap-1">
                                        <i class="ti ti-download"></i> Download Template
                                    </a>
                                </div>
                                <div class="col-6">
                                    <form action="{{ route('migrasi-siswa.upload') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="file" name="file_excel" class="form-control form-control-sm mb-2" accept=".xls,.xlsx" required>
                                        <button type="submit" class="btn btn-outline-secondary w-100 btn-sm d-flex align-items-center justify-content-center gap-1">
                                            <i class="ti ti-upload"></i> Upload
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-1 fw-bold">Butuh melihat data import sebelumnya?</h6>
                    <p class="text-muted mb-0 small">Akses menu Riwayat untuk melihat log import atau melakukan rollback data.</p>
                </div>
                <a href="{{ route('migrasi-siswa.riwayat') }}" class="btn btn-outline-secondary d-flex align-items-center gap-2">
                    <i class="ti ti-history fs-5"></i> Riwayat Migrasi
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

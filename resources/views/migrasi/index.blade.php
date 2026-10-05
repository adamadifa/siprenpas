@extends('layouts.app')
@section('titlepage', 'Migrasi Data Siswa')

@section('content')
<div class="space-y-6">

    <!-- ================= 1. PAGE HEADER (NO CARD) WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center border border-emerald-200/80 shadow-2xs">
                    <i class="ti ti-database-import text-2xl"></i>
                </div>
                <span>Migrasi Data Siswa</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Import dan inisialisasi data santri / siswa terdahulu secara massal ke dalam sistem Sipren
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
                    <i class="ti ti-settings text-sm"></i>
                    <span>Konfigurasi</span>
                </span>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Migrasi Siswa</span>
            </nav>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('migrasi-siswa.riwayat') }}" class="inline-flex items-center gap-2 px-3.5 py-2.5 bg-white hover:bg-slate-100 text-slate-700 font-bold rounded-xl text-xs border border-slate-300/90 shadow-2xs transition-all duration-200 active:scale-95">
                    <i class="ti ti-history text-base text-emerald-600"></i>
                    <span>Riwayat & Log Migrasi</span>
                </a>
            </div>
        </div>
    </div>

    <!-- ================= 2. MAIN GRID (INSTRUCTIONS & UPLOAD PANELS) ================= -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- Left Panel: Instructions (6 cols) -->
        <div class="lg:col-span-6 bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
            <!-- Solid Emerald Header -->
            <div class="bg-emerald-600 px-5 py-4 flex items-center justify-between text-white">
                <div class="flex items-center gap-2.5">
                    <i class="ti ti-info-circle text-xl"></i>
                    <h3 class="font-bold text-sm tracking-wide text-white">Panduan & Petunjuk Migrasi Data</h3>
                </div>
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-white/20 text-white backdrop-blur-xs">
                    Wajib Dibaca
                </span>
            </div>

            <div class="p-5 sm:p-6 space-y-4 text-xs text-slate-600 leading-relaxed">
                <p class="font-medium text-slate-700">
                    Fitur migrasi ini dirancang khusus untuk memasukkan data santri/siswa yang <strong class="text-slate-900">sudah aktif sebelum sistem Sipren digunakan</strong>. Jangan gunakan menu ini untuk pendaftaran santri baru (PPDB).
                </p>

                <!-- Recommendation Callout -->
                <div class="flex items-start gap-3 p-4 bg-emerald-50/80 border border-emerald-200/90 rounded-xl text-emerald-950">
                    <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 text-base font-bold">
                        <i class="ti ti-star"></i>
                    </div>
                    <div class="space-y-1">
                        <h4 class="font-bold text-emerald-950 text-xs">Format Horizontal (Sangat Direkomendasikan)</h4>
                        <p class="text-[11px] text-emerald-800 leading-normal">
                            Cukup gunakan 1 sheet! Data santri diletakkan pada kolom sebelah kiri, dan riwayat Tahun Ajaran melebar ke samping kanan dengan sub-kolom: <strong class="text-emerald-950">Tagihan</strong>, <strong class="text-emerald-950">Jumlah Bayar</strong>, dan <strong class="text-emerald-950">Sisa</strong>.
                        </p>
                    </div>
                </div>

                <!-- Step-by-Step Guide -->
                <div class="space-y-2 pt-2">
                    <h4 class="font-bold text-slate-900 text-xs uppercase tracking-wider flex items-center gap-1.5">
                        <i class="ti ti-list-numbers text-emerald-600"></i>
                        <span>Langkah-Langkah Import (Format Horizontal):</span>
                    </h4>
                    <ol class="space-y-2.5 list-none pl-0">
                        <li class="flex items-start gap-2.5">
                            <span class="w-5 h-5 rounded-full bg-slate-100 text-slate-700 flex items-center justify-center shrink-0 text-[11px] font-bold border border-slate-200">1</span>
                            <span>Download <strong class="text-slate-800">Template Horizontal</strong>. Periksa sheet <em>"Referensi"</em> untuk melihat daftar Kode Unit & Tahun Ajaran.</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <span class="w-5 h-5 rounded-full bg-slate-100 text-slate-700 flex items-center justify-center shrink-0 text-[11px] font-bold border border-slate-200">2</span>
                            <span>Isi data santri (NISN, Nama, JK, Tingkat Masuk, dll) pada kolom A–G. <strong class="text-slate-800">1 baris = 1 santri.</strong></span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <span class="w-5 h-5 rounded-full bg-slate-100 text-slate-700 flex items-center justify-center shrink-0 text-[11px] font-bold border border-slate-200">3</span>
                            <span>Pada kolom Tahun Ajaran, isi rincian <strong class="text-slate-800">Tagihan & Bayar</strong> pada setiap periode yang pernah dijalani santri tersebut.</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <span class="w-5 h-5 rounded-full bg-slate-100 text-slate-700 flex items-center justify-center shrink-0 text-[11px] font-bold border border-slate-200">4</span>
                            <span>Upload file melalui form di panel sebelah kanan. Sistem akan memvalidasi dan menampilkan <strong class="text-slate-800">Preview Data</strong>.</span>
                        </li>
                    </ol>
                </div>

                <!-- Example Simulation -->
                <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-xl space-y-1.5">
                    <div class="flex items-center gap-1.5 font-bold text-slate-800 text-xs">
                        <i class="ti ti-bulb text-amber-500 text-sm"></i>
                        <span>Contoh Kasus: Santri Tingkat 3 MTs</span>
                    </div>
                    <div class="font-mono text-[11px] text-slate-600 bg-white p-2.5 rounded-lg border border-slate-200/80 space-y-1">
                        <div>TA 2023/2024: Tagihan = 250.000 | Bayar = 250.000 | Sisa = 0</div>
                        <div>TA 2024/2025: Tagihan = 250.000 | Bayar = 200.000 | Sisa = 50.000</div>
                        <div>TA 2025/2026: Tagihan = 250.000 | Bayar = 0 | Sisa = 250.000</div>
                    </div>
                </div>

                <!-- Warning Notice -->
                <div class="flex items-start gap-3 p-3.5 bg-amber-50/80 border border-amber-200/90 rounded-xl text-amber-950">
                    <i class="ti ti-alert-triangle text-amber-600 text-base shrink-0 mt-0.5"></i>
                    <p class="text-[11px] text-amber-900 leading-normal">
                        <strong class="font-bold">Penting:</strong> Pastikan menu <a href="{{ route('biaya.index') }}" class="underline font-bold text-amber-950 hover:text-emerald-700">Konfigurasi Biaya</a> telah dibuat lengkap untuk setiap unit, tingkat, dan Tahun Ajaran yang dicantumkan pada file Excel.
                    </p>
                </div>
            </div>
        </div>

        <!-- Right Panel: Download & Upload Actions (6 cols) -->
        <div class="lg:col-span-6 space-y-5">
            
            <!-- Step 1: Download Horizontal Template -->
            <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden border-l-4 border-l-emerald-600 p-5 sm:p-6 space-y-4">
                <div class="flex items-start justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-emerald-600 text-white font-black flex items-center justify-center text-sm shadow-2xs">
                            1
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 text-sm flex items-center gap-2">
                                <span>Unduh Template Horizontal</span>
                                <span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 font-extrabold text-[10px] rounded-full uppercase">Rekomendasi</span>
                            </h3>
                            <p class="text-xs text-slate-500 mt-0.5">Template 1 sheet praktis dengan referensi kode terpadu</p>
                        </div>
                    </div>
                </div>

                <a href="{{ route('migrasi-siswa.download-template-horizontal') }}" class="w-full py-3 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs transition-all flex items-center justify-center gap-2 active:scale-98">
                    <i class="ti ti-download text-base"></i>
                    <span>Download File Template Excel</span>
                </a>
            </div>

            <!-- Step 2: Upload Horizontal File -->
            <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden border-l-4 border-l-emerald-600 p-5 sm:p-6 space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-emerald-600 text-white font-black flex items-center justify-center text-sm shadow-2xs">
                        2
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 text-sm">Upload & Validasi Data Siswa</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Pilih berkas Excel horizontal yang telah diisi lengkap</p>
                    </div>
                </div>

                <form action="{{ route('migrasi-siswa.upload-horizontal') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                            <i class="ti ti-file-spreadsheet text-slate-400"></i>
                            <span>Pilih File Excel (.xls, .xlsx) <span class="text-rose-500">*</span></span>
                        </label>
                        <input type="file" 
                               name="file_excel" 
                               accept=".xls,.xlsx" 
                               required
                               class="w-full text-xs text-slate-600 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 file:cursor-pointer border border-slate-300 rounded-xl bg-white shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                    </div>

                    <button type="submit" class="w-full py-3 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs transition-all flex items-center justify-center gap-2 active:scale-98 cursor-pointer">
                        <i class="ti ti-upload text-base"></i>
                        <span>Upload & Mulai Validasi Data</span>
                    </button>
                </form>
            </div>

            <!-- Legacy Multi-sheet Template (Collapsible) -->
            <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
                <details class="group">
                    <summary class="flex items-center justify-between p-4 cursor-pointer select-none bg-slate-50/70 hover:bg-slate-100/70 transition">
                        <div class="flex items-center gap-2 text-xs font-bold text-slate-600">
                            <i class="ti ti-archive text-slate-400 text-base"></i>
                            <span>Template Multi-Sheet (Format Lama 3-Sheet)</span>
                        </div>
                        <i class="ti ti-chevron-down text-slate-400 transition-transform duration-200 group-open:rotate-180"></i>
                    </summary>
                    <div class="p-4 border-t border-slate-100 space-y-3 bg-white">
                        <p class="text-[11px] text-slate-500">
                            Gunakan format lama ini hanya jika Anda telah memiliki berkas 3 sheet (Data Siswa, History TA, Tagihan).
                        </p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                            <a href="{{ route('migrasi-siswa.download-template') }}" class="py-2 px-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold text-xs transition flex items-center justify-center gap-1.5">
                                <i class="ti ti-download"></i>
                                <span>Download Format Lama</span>
                            </a>
                            <form action="{{ route('migrasi-siswa.upload') }}" method="POST" enctype="multipart/form-data" class="flex gap-2">
                                @csrf
                                <input type="file" name="file_excel" accept=".xls,.xlsx" required class="text-[11px] text-slate-500 w-full file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:bg-slate-200 file:text-slate-700 file:font-semibold">
                                <button type="submit" class="px-3 py-1.5 bg-slate-800 hover:bg-slate-900 text-white rounded-xl font-bold text-xs shrink-0 cursor-pointer">
                                    Upload
                                </button>
                            </form>
                        </div>
                    </div>
                </details>
            </div>

        </div>

    </div>

    <!-- ================= 3. BOTTOM BANNER FOR AUDIT LOGS ================= -->
    <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs p-5 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-3.5">
            <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center shrink-0 border border-slate-200 text-xl font-bold">
                <i class="ti ti-history"></i>
            </div>
            <div>
                <h4 class="font-bold text-slate-900 text-xs sm:text-sm">Riwayat & Log Migrasi Terdahulu</h4>
                <p class="text-xs text-slate-500 mt-0.5">Lihat berkas yang pernah di-import, rekap status keberhasilan, atau lakukan Rollback data jika diperlukan.</p>
            </div>
        </div>
        <a href="{{ route('migrasi-siswa.riwayat') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs transition shrink-0">
            <i class="ti ti-list-details text-base"></i>
            <span>Buka Riwayat Migrasi</span>
        </a>
    </div>

</div>
@endsection


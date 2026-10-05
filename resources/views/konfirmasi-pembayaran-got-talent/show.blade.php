@extends('layouts.app')
@section('titlepage', 'Detail Konfirmasi Pembayaran Got Talent')

@section('content')
<div class="space-y-5">

    <!-- ================= 1. PAGE HEADER (NO CARD) WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <i class="ti ti-receipt-tax text-emerald-600 text-2xl"></i>
                <span>Detail Verifikasi Pembayaran</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Informasi detail peserta, tagihan cabang perlombaan, bukti transfer & verifikasi status
            </p>
        </div>

        <!-- Right Side: Breadcrumb & Back Action -->
        <div class="flex flex-col md:items-end gap-2.5">
            <nav class="flex items-center text-xs text-slate-400 font-medium">
                <a href="{{ route('dashboard.index') }}" class="hover:text-slate-700 transition flex items-center gap-1">
                    <i class="ti ti-home text-sm"></i>
                    <span>Dashboard</span>
                </a>
                <span class="mx-2 text-slate-300">/</span>
                <a href="{{ route('konfirmasi-pembayaran-got-talent.index') }}" class="hover:text-slate-700 transition">
                    Konfirmasi Pembayaran
                </a>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Detail</span>
            </nav>

            <a href="{{ route('konfirmasi-pembayaran-got-talent.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-300 rounded-xl font-bold text-xs shadow-xs transition active:scale-95">
                <i class="ti ti-arrow-left text-sm"></i>
                <span>Kembali ke Daftar</span>
            </a>
        </div>
    </div>

    <!-- ================= 2. HERO HIGHLIGHT STATUS CARD (INVOICE STYLE) ================= -->
    @php
        $isVerified = $konfirmasi->status == 'diverifikasi';
        $isRejected = $konfirmasi->status == 'ditolak';
        $isPending  = $konfirmasi->status == 'pending';
    @endphp
    
    <div class="relative overflow-hidden rounded-3xl p-6 text-white shadow-md
        {{ $isVerified ? 'bg-gradient-to-br from-emerald-600 via-emerald-700 to-teal-800' : ($isRejected ? 'bg-gradient-to-br from-rose-600 via-rose-700 to-red-800' : 'bg-gradient-to-br from-amber-500 via-amber-600 to-orange-700') }}">
        
        <!-- Ambient Decorative Vector Watermarks -->
        <div class="absolute -right-10 -bottom-10 w-48 h-48 rounded-full bg-white/[0.08] pointer-events-none"></div>
        <div class="absolute right-24 -top-12 w-36 h-36 rounded-full bg-white/[0.05] pointer-events-none"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <!-- Left: Participant Hero Info -->
            <div class="flex items-start sm:items-center gap-4">
                <div class="w-16 h-16 rounded-2xl bg-white/20 border border-white/30 backdrop-blur-md flex items-center justify-center text-3xl font-black text-white shrink-0 shadow-lg">
                    <i class="{{ $isVerified ? 'ti ti-discount-check' : ($isRejected ? 'ti ti-circle-x' : 'ti ti-clock-hour-4') }}"></i>
                </div>
                <div>
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="px-2.5 py-0.5 rounded-md text-[11px] font-black font-mono tracking-wider bg-white/20 text-white border border-white/30 backdrop-blur-xs">
                            {{ $konfirmasi->pendaftaran->nomor_register ?? '-' }}
                        </span>
                        <span class="px-2.5 py-0.5 rounded-md text-[11px] font-bold uppercase tracking-wider bg-black/20 text-white/90 backdrop-blur-xs">
                            {{ $konfirmasi->pendaftaran->jenjangPendidikan->jenjang_pendidikan ?? '-' }}
                        </span>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-black text-white tracking-tight mt-1.5">
                        {{ $konfirmasi->pendaftaran->nama_lengkap ?? '-' }}
                    </h2>
                    <p class="text-xs text-white/80 mt-0.5 flex items-center gap-1.5">
                        <i class="ti ti-building-community text-sm"></i>
                        <span>{{ $konfirmasi->pendaftaran->asal_sekolah ?? '-' }}</span>
                    </p>
                </div>
            </div>

            <!-- Right: Amount & Status Badge -->
            <div class="flex flex-col sm:flex-row lg:flex-col items-start sm:items-center lg:items-end justify-between gap-3 border-t lg:border-t-0 border-white/20 pt-4 lg:pt-0">
                <div class="text-left lg:text-right">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-white/80 block">
                        Nominal Transfer Terkonfirmasi
                    </span>
                    <div class="text-2xl sm:text-3xl font-black tracking-tight text-white font-mono mt-0.5">
                        Rp {{ formatRupiah($konfirmasi->jumlah_pembayaran) }}
                    </div>
                </div>

                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider bg-white shadow-md {{ $isVerified ? 'text-emerald-700' : ($isRejected ? 'text-rose-700' : 'text-amber-700') }}">
                    <span class="w-2 h-2 rounded-full animate-ping {{ $isVerified ? 'bg-emerald-500' : ($isRejected ? 'bg-rose-500' : 'bg-amber-500') }}"></span>
                    <span>Status: {{ $konfirmasi->status }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= 3. TWO COLUMN DETAILED CARDS ================= -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
        
        <!-- ================= LEFT COLUMN: DETAILS & COMPETITIONS (7 COLS) ================= -->
        <div class="lg:col-span-7 space-y-5">
            
            <!-- Card 1: Cabang Perlombaan yang Diikuti -->
            <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
                <div class="px-5 py-3.5 bg-slate-50/90 border-b border-slate-200/80 flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-sm font-bold">
                            <i class="ti ti-trophy"></i>
                        </div>
                        <h3 class="text-xs font-black text-slate-800 uppercase tracking-wider">
                            Pilihan Cabang Perlombaan
                        </h3>
                    </div>
                    <span class="px-2 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                        {{ $konfirmasi->pendaftaran && $konfirmasi->pendaftaran->perlombaan ? $konfirmasi->pendaftaran->perlombaan->count() : 0 }} Lomba Dipilih
                    </span>
                </div>

                <div class="p-4 sm:p-5">
                    @if ($konfirmasi->pendaftaran && $konfirmasi->pendaftaran->perlombaan && $konfirmasi->pendaftaran->perlombaan->count() > 0)
                        <div class="space-y-2.5">
                            @php $totalBiayaLomba = 0; @endphp
                            @foreach ($konfirmasi->pendaftaran->perlombaan as $lomba)
                                @php $totalBiayaLomba += (float) $lomba->biaya_pendaftaran; @endphp
                                <div class="p-3 bg-slate-50/80 hover:bg-emerald-50/40 border border-slate-200/90 rounded-xl flex items-center justify-between gap-3 transition">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <div class="w-8 h-8 rounded-lg bg-emerald-600 text-white flex items-center justify-center text-sm font-bold shrink-0 shadow-2xs">
                                            <i class="ti ti-medal"></i>
                                        </div>
                                        <div class="min-w-0">
                                            <div class="text-xs font-bold text-slate-900 truncate">
                                                {{ $lomba->jenis_perlombaan }}
                                            </div>
                                            <div class="text-[11px] text-slate-500 flex items-center gap-1.5 mt-0.5">
                                                <i class="ti ti-school text-xs text-indigo-500"></i>
                                                <span>{{ $lomba->jenjangPendidikan->jenjang_pendidikan ?? '-' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right shrink-0">
                                        <span class="font-mono font-bold text-xs {{ !empty($lomba->biaya_pendaftaran) ? 'text-slate-800' : 'text-emerald-700 font-black' }}">
                                            {{ !empty($lomba->biaya_pendaftaran) ? 'Rp ' . formatRupiah($lomba->biaya_pendaftaran) : 'Gratis' }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                            
                            <!-- Total Calculation Summary Bar -->
                            <div class="p-3.5 bg-emerald-50/60 border border-emerald-200/80 rounded-xl flex items-center justify-between text-xs mt-3">
                                <span class="font-bold text-emerald-900 flex items-center gap-1.5">
                                    <i class="ti ti-calculator text-emerald-700 text-sm"></i>
                                    <span>Total Biaya Registrasi Terdaftar:</span>
                                </span>
                                <span class="font-mono font-black text-sm text-emerald-800">
                                    Rp {{ formatRupiah($totalBiayaLomba) }}
                                </span>
                            </div>
                        </div>
                    @else
                        <p class="text-xs text-slate-400 italic text-center py-4">Tidak ada data cabang perlombaan terkait.</p>
                    @endif
                </div>
            </div>

            <!-- Card 2: Rincian Lengkap Biodata Peserta -->
            <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
                <div class="px-5 py-3.5 bg-slate-50/90 border-b border-slate-200/80 flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center text-sm font-bold">
                        <i class="ti ti-id-badge-2"></i>
                    </div>
                    <h3 class="text-xs font-black text-slate-800 uppercase tracking-wider">
                        Biodata & Kontak Peserta
                    </h3>
                </div>

                <div class="p-5 divide-y divide-slate-100 text-xs">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between py-2.5 gap-1">
                        <span class="text-slate-500 font-medium">Tempat, Tanggal Lahir</span>
                        <span class="font-semibold text-slate-800">
                            {{ $konfirmasi->pendaftaran->tempat_lahir ?? '-' }}, {{ $konfirmasi->pendaftaran->tanggal_lahir ? date('d M Y', strtotime($konfirmasi->pendaftaran->tanggal_lahir)) : '-' }}
                        </span>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between py-2.5 gap-1">
                        <span class="text-slate-500 font-medium">Nomor WhatsApp / HP</span>
                        <span class="font-semibold text-slate-800">
                            @if ($konfirmasi->pendaftaran && $konfirmasi->pendaftaran->no_hp)
                                @php
                                    preg_match('/\d{9,15}/', $konfirmasi->pendaftaran->no_hp, $phoneMatches);
                                    $cleanPhone = !empty($phoneMatches[0]) ? preg_replace('/^0/', '62', $phoneMatches[0]) : null;
                                @endphp
                                @if ($cleanPhone)
                                    <a href="https://wa.me/{{ $cleanPhone }}" target="_blank" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-200/80 hover:bg-emerald-100 transition shadow-2xs">
                                        <i class="ti ti-brand-whatsapp text-emerald-600 text-sm"></i>
                                        <span>{{ $konfirmasi->pendaftaran->no_hp }} (Chat WA)</span>
                                    </a>
                                @else
                                    <span>{{ $konfirmasi->pendaftaran->no_hp }}</span>
                                @endif
                            @else
                                <span class="text-slate-400">-</span>
                            @endif
                        </span>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between py-2.5 gap-1">
                        <span class="text-slate-500 font-medium">Email Aktif</span>
                        <span class="font-semibold text-slate-800">
                            {{ $konfirmasi->pendaftaran->email ?? '-' }}
                        </span>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-start justify-between py-2.5 gap-1">
                        <span class="text-slate-500 font-medium shrink-0">Alamat Rumah</span>
                        <span class="font-medium text-slate-800 text-right sm:max-w-xs">
                            {{ $konfirmasi->pendaftaran->alamat_rumah ?? '-' }}
                        </span>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-start justify-between py-2.5 gap-1">
                        <span class="text-slate-500 font-medium shrink-0">Alamat Asal Sekolah</span>
                        <span class="font-medium text-slate-800 text-right sm:max-w-xs">
                            {{ $konfirmasi->pendaftaran->alamat_sekolah ?? '-' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Card 3: Rincian Pengiriman Pembayaran -->
            <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
                <div class="px-5 py-3.5 bg-slate-50/90 border-b border-slate-200/80 flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-sm font-bold">
                        <i class="ti ti-receipt"></i>
                    </div>
                    <h3 class="text-xs font-black text-slate-800 uppercase tracking-wider">
                        Rincian Pengiriman Pembayaran
                    </h3>
                </div>

                <div class="p-5 divide-y divide-slate-100 text-xs">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between py-2.5 gap-1">
                        <span class="text-slate-500 font-medium">Tanggal Transfer</span>
                        <span class="font-semibold text-slate-800 flex items-center gap-1.5">
                            <i class="ti ti-calendar text-slate-400 text-sm"></i>
                            <span>{{ $konfirmasi->tanggal_pembayaran ? DateToIndo($konfirmasi->tanggal_pembayaran) : '-' }}</span>
                        </span>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between py-2.5 gap-1">
                        <span class="text-slate-500 font-medium">Metode Pembayaran</span>
                        <span class="font-bold text-slate-800 uppercase bg-slate-100 px-2.5 py-0.5 rounded-md border border-slate-200 shadow-2xs">
                            {{ $konfirmasi->metode_pembayaran ?? 'Transfer Bank' }}
                        </span>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between py-2.5 gap-1">
                        <span class="text-slate-500 font-medium">Waktu Unggah Bukti</span>
                        <span class="font-semibold text-slate-800">
                            {{ $konfirmasi->created_at ? $konfirmasi->created_at->translatedFormat('d M Y, H:i') : '-' }} WIB
                        </span>
                    </div>
                    @if ($konfirmasi->keterangan)
                    <div class="py-3">
                        <span class="text-slate-500 font-medium block mb-1.5">Catatan / Keterangan dari Pengirim:</span>
                        <div class="p-3.5 bg-slate-50 border border-slate-200/90 rounded-xl text-slate-700 font-medium italic text-xs leading-relaxed">
                            "{{ $konfirmasi->keterangan }}"
                        </div>
                    </div>
                    @endif
                </div>
            </div>

        </div>

        <!-- ================= RIGHT COLUMN: PROOF PREVIEW & VERIFICATION FORM (5 COLS) ================= -->
        <div class="lg:col-span-5 space-y-5">
            
            <!-- Card 4: Bukti Transfer File / Viewer -->
            <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
                <div class="px-5 py-3.5 bg-slate-50/90 border-b border-slate-200/80 flex items-center justify-between gap-2">
                    <div class="flex items-center gap-2.5">
                        <div class="w-7 h-7 rounded-lg bg-sky-100 text-sky-700 flex items-center justify-center text-sm font-bold">
                            <i class="ti ti-photo"></i>
                        </div>
                        <h3 class="text-xs font-black text-slate-800 uppercase tracking-wider">
                            Bukti Transfer Fisik
                        </h3>
                    </div>
                    @if ($konfirmasi->bukti_pembayaran)
                        <a href="{{ config('app.web_url') . '/storage/' . $konfirmasi->bukti_pembayaran }}" target="_blank" 
                           class="px-2.5 py-1 bg-white hover:bg-slate-100 text-slate-700 border border-slate-300 rounded-lg text-[11px] font-bold inline-flex items-center gap-1 transition shadow-2xs">
                            <i class="ti ti-external-link text-xs"></i>
                            <span>Buka Tab Baru</span>
                        </a>
                    @endif
                </div>

                <div class="p-6 text-center">
                    @if ($konfirmasi->bukti_pembayaran)
                        @php
                            $ext = strtolower(pathinfo($konfirmasi->bukti_pembayaran, PATHINFO_EXTENSION));
                            $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                            $imageUrl = config('app.web_url') . '/storage/' . $konfirmasi->bukti_pembayaran;
                        @endphp
                        @if ($isImage)
                            <!-- Container Image with Javascript Fallback if file doesn't exist -->
                            <div class="relative w-full">
                                <div id="preview-image-box" class="relative group p-2 bg-slate-900/5 border border-slate-200 rounded-2xl overflow-hidden inline-block w-full">
                                    <a href="{{ $imageUrl }}" target="_blank">
                                        <img src="{{ $imageUrl }}" 
                                             alt="Bukti Transfer" 
                                             onerror="this.style.display='none'; document.getElementById('preview-image-box').style.display='none'; document.getElementById('preview-fallback-box').style.display='flex';"
                                             class="rounded-xl max-h-80 w-auto mx-auto object-contain shadow-xs group-hover:scale-102 transition duration-200 cursor-zoom-in">
                                    </a>
                                    <div class="mt-2 text-[11px] text-slate-500 font-medium">
                                        Klik gambar untuk melihat dalam resolusi penuh
                                    </div>
                                </div>

                                <!-- Fallback Placeholder if Image File Doesn't Exist on Server -->
                                <div id="preview-fallback-box" style="display: none;" class="py-6 flex-col items-center justify-center text-slate-400">
                                    <div class="w-14 h-14 rounded-2xl bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-400 text-3xl mb-2.5 mx-auto">
                                        <i class="ti ti-photo-off"></i>
                                    </div>
                                    <span class="text-xs font-bold text-slate-700">Berkas Foto Tidak Ditemukan</span>
                                    <span class="text-[11px] text-slate-400 mt-0.5">File bukti transfer fisik tidak tersedia di penyimpanan server</span>
                                    <span class="mt-2 font-mono text-[10.5px] text-slate-500 bg-slate-100 px-2.5 py-0.5 rounded-md border border-slate-200">
                                        {{ basename($konfirmasi->bukti_pembayaran) }}
                                    </span>
                                </div>
                            </div>
                        @else
                            <div class="p-6 bg-slate-50 border border-slate-200 rounded-2xl flex flex-col items-center justify-center">
                                <div class="w-12 h-12 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-400 text-2xl mb-2">
                                    <i class="ti ti-file-text"></i>
                                </div>
                                <p class="text-xs font-bold text-slate-800 mb-0.5">Dokumen Lampiran Transfer</p>
                                <p class="text-[11px] text-slate-400 mb-3 font-mono">Format: .{{ strtoupper($ext) }}</p>
                                <a href="{{ $imageUrl }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-xs shadow-xs transition active:scale-95">
                                    <i class="ti ti-download text-sm"></i>
                                    <span>Download Bukti File</span>
                                </a>
                            </div>
                        @endif
                    @else
                        <!-- Simple Clean Placeholder Icon When No Proof Stored -->
                        <div class="py-6 flex flex-col items-center justify-center text-slate-400">
                            <div class="w-14 h-14 rounded-2xl bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-400 text-3xl mb-2.5">
                                <i class="ti ti-photo-off"></i>
                            </div>
                            <span class="text-xs font-bold text-slate-600">Bukti Transfer Belum Tersedia</span>
                            <span class="text-[11px] text-slate-400 mt-0.5">Tidak ada foto atau berkas yang diunggah</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Card 5: Form Verifikasi & Audit Log Status -->
            <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
                <div class="px-5 py-3.5 bg-emerald-600 text-white flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <div class="w-7 h-7 rounded-lg bg-white/20 text-white flex items-center justify-center text-sm font-bold border border-white/20 shadow-2xs">
                            <i class="ti ti-shield-check"></i>
                        </div>
                        <h3 class="text-xs font-black text-white tracking-wide uppercase">
                            Panel Verifikasi Admin
                        </h3>
                    </div>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-white/20 text-white border border-white/30 backdrop-blur-xs">
                        Audit Pembayaran
                    </span>
                </div>

                <div class="p-5">
                    @if ($konfirmasi->status == 'pending')
                        <form action="{{ route('konfirmasi-pembayaran-got-talent.update-status', Crypt::encrypt($konfirmasi->id)) }}" method="POST" class="space-y-4">
                            @csrf
                            @method('PUT')

                            <div class="space-y-1.5">
                                <label for="status" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                                    <i class="ti ti-check text-sm text-slate-400"></i>
                                    <span>Keputusan Verifikasi <span class="text-rose-500 font-bold">*</span></span>
                                </label>
                                <div class="relative">
                                    <select name="status" id="status" required
                                            class="w-full pl-3.5 pr-8 py-2.5 text-sm font-bold bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition appearance-none">
                                        <option value="diverifikasi" class="font-bold text-emerald-700">✓ Diverifikasi (Setujui Pembayaran)</option>
                                        <option value="ditolak" class="font-bold text-rose-700">✗ Ditolak (Tidak Valid / Tidak Sesuai)</option>
                                    </select>
                                    <i class="ti ti-chevron-down absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
                                </div>
                            </div>

                            <div class="space-y-1.5">
                                <label for="catatan_admin" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                                    <i class="ti ti-notes text-sm text-slate-400"></i>
                                    <span>Catatan Verifikasi (Opsional)</span>
                                </label>
                                <textarea name="catatan_admin" id="catatan_admin" rows="3" 
                                          placeholder="Tuliskan catatan alasan jika ditolak atau keterangan tambahan untuk peserta..." 
                                          class="w-full p-3 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-xl placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition"></textarea>
                            </div>

                            <button type="submit" class="w-full py-3 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl shadow-xs transition flex items-center justify-center gap-2 cursor-pointer active:scale-98">
                                <i class="ti ti-device-floppy text-base"></i>
                                <span>Simpan Keputusan Verifikasi</span>
                            </button>
                        </form>
                    @else
                        <div class="space-y-3.5 text-xs">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between py-2 border-b border-slate-100 gap-1">
                                <span class="text-slate-500 font-medium">Diverifikasi Oleh</span>
                                <span class="font-bold text-slate-900 flex items-center gap-1.5">
                                    <div class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-[10px]">
                                        <i class="ti ti-user"></i>
                                    </div>
                                    <span>{{ $konfirmasi->verifikator->name ?? 'Administrator' }}</span>
                                </span>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between py-2 border-b border-slate-100 gap-1">
                                <span class="text-slate-500 font-medium">Waktu Verifikasi</span>
                                <span class="font-semibold text-slate-800">
                                    {{ $konfirmasi->diverifikasi_pada ? $konfirmasi->diverifikasi_pada->translatedFormat('d M Y, H:i') : '-' }} WIB
                                </span>
                            </div>
                            @if ($konfirmasi->catatan_admin)
                                <div class="py-2.5">
                                    <span class="text-slate-500 font-medium block mb-1.5">Catatan Verifikator:</span>
                                    <div class="p-3.5 bg-slate-50 border border-slate-200/90 rounded-xl text-slate-800 font-medium text-xs leading-relaxed">
                                        {{ $konfirmasi->catatan_admin }}
                                    </div>
                                </div>
                            @endif

                            <!-- Option to re-verify if needed -->
                            <div class="pt-3 border-t border-slate-100">
                                <button type="button" onclick="$('#form-reverify').slideToggle()" class="w-full py-2.5 px-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs transition cursor-pointer flex items-center justify-center gap-2 active:scale-98">
                                    <i class="ti ti-edit text-sm"></i>
                                    <span>Koreksi / Ubah Status Verifikasi</span>
                                </button>
                                
                                <form id="form-reverify" style="display: none;" action="{{ route('konfirmasi-pembayaran-got-talent.update-status', Crypt::encrypt($konfirmasi->id)) }}" method="POST" class="mt-3 pt-3 border-t border-slate-100 space-y-3">
                                    @csrf
                                    @method('PUT')
                                    <div class="space-y-1">
                                        <label class="block text-[11px] font-bold text-slate-700">Status Baru</label>
                                        <select name="status" class="w-full p-2.5 text-xs font-bold bg-white border border-slate-300 rounded-xl shadow-2xs">
                                            <option value="diverifikasi" {{ $konfirmasi->status == 'diverifikasi' ? 'selected' : '' }}>✓ Diverifikasi (Setujui)</option>
                                            <option value="ditolak" {{ $konfirmasi->status == 'ditolak' ? 'selected' : '' }}>✗ Ditolak (Tidak Valid)</option>
                                        </select>
                                    </div>
                                    <div class="space-y-1">
                                        <label class="block text-[11px] font-bold text-slate-700">Catatan Perubahan</label>
                                        <textarea name="catatan_admin" rows="2" class="w-full p-2.5 text-xs font-medium bg-white border border-slate-300 rounded-xl shadow-2xs" placeholder="Alasan perubahan status...">{{ $konfirmasi->catatan_admin }}</textarea>
                                    </div>
                                    <button type="submit" class="w-full py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs transition active:scale-98">
                                        Simpan Perubahan
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>

    </div>

</div>
@endsection

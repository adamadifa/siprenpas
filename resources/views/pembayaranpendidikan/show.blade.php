<div class="bg-gradient-to-r from-emerald-50/60 via-slate-50/50 to-teal-50/40 border border-emerald-100/80 rounded-2xl p-4 sm:p-5 mb-5 shadow-2xs">
    <div class="flex flex-col sm:flex-row items-center sm:items-start gap-4">
        <!-- Student Avatar -->
        <div class="relative shrink-0">
            <img src="{{ asset('assets/img/avatars/No_Image_Available.jpg') }}" 
                alt="{{ $pendaftaran->nama_lengkap }}" 
                class="w-20 h-20 sm:w-22 sm:h-22 rounded-2xl object-cover shadow-xs border-2 border-white ring-2 ring-emerald-600/10">
            <span class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full bg-emerald-500 border-2 border-white flex items-center justify-center text-white text-[10px]" title="Siswa Aktif">
                <i class="ti ti-check"></i>
            </span>
        </div>

        <!-- Student Info -->
        <div class="flex-1 text-center sm:text-left">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                <div>
                    <h3 class="text-base sm:text-lg font-black text-slate-900 tracking-tight uppercase">{{ $pendaftaran->nama_lengkap }}</h3>
                    <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2 mt-1">
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md text-xs font-mono font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                            <i class="ti ti-barcode text-xs"></i> {{ $pendaftaran->no_pendaftaran }}
                        </span>
                        <span class="text-xs text-slate-500">
                            NISN: <strong class="text-slate-800 font-mono">{{ $pendaftaran->nisn ?: '-' }}</strong>
                        </span>
                        @if(!empty($pendaftaran->nis))
                            <span class="text-slate-300">•</span>
                            <span class="text-xs text-slate-500">
                                NIS: <strong class="text-slate-800 font-mono">{{ $pendaftaran->nis }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Tahun Ajaran Badge -->
                <div class="shrink-0">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-white border border-slate-200 shadow-2xs text-xs font-bold text-slate-800">
                        <i class="ti ti-school text-emerald-600 text-sm"></i>
                        <span>TA: {{ $pendaftaran->tahun_ajaran }}</span>
                    </span>
                </div>
            </div>

            <!-- Meta Badges Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5 mt-3.5 pt-3 border-t border-slate-200/60 text-xs">
                <div class="flex items-center gap-2 text-slate-600">
                    <div class="w-6 h-6 rounded-md bg-white border border-slate-200 flex items-center justify-center text-emerald-600 shadow-2xs shrink-0">
                        <i class="ti ti-gender-femme text-xs"></i>
                    </div>
                    <div>
                        <span class="text-[11px] text-slate-400 block leading-tight">Jenis Kelamin</span>
                        <span class="font-bold text-slate-800">{{ $pendaftaran->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                    </div>
                </div>

                <div class="flex items-center gap-2 text-slate-600">
                    <div class="w-6 h-6 rounded-md bg-white border border-slate-200 flex items-center justify-center text-emerald-600 shadow-2xs shrink-0">
                        <i class="ti ti-calendar-event text-xs"></i>
                    </div>
                    <div>
                        <span class="text-[11px] text-slate-400 block leading-tight">Tempat, Tgl Lahir</span>
                        <span class="font-bold text-slate-800 truncate block max-w-[180px]" title="{{ textCamelCase($pendaftaran->tempat_lahir) }}, {{ DateToIndo($pendaftaran->tanggal_lahir) }}">
                            {{ textCamelCase($pendaftaran->tempat_lahir) }}, {{ DateToIndo($pendaftaran->tanggal_lahir) }}
                        </span>
                    </div>
                </div>

                <div class="flex items-center gap-2 text-slate-600">
                    <div class="w-6 h-6 rounded-md bg-white border border-slate-200 flex items-center justify-center text-emerald-600 shadow-2xs shrink-0">
                        <i class="ti ti-building-community text-xs"></i>
                    </div>
                    <div>
                        <span class="text-[11px] text-slate-400 block leading-tight">Jenjang / Unit</span>
                        <span class="font-bold text-slate-800 uppercase">{{ $pendaftaran->nama_unit }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .custom-pembayaran-tabs .tab-btn {
        border: none !important;
        border-radius: 8px !important;
        padding: 8px 16px !important;
        font-weight: 700 !important;
        font-size: 0.8125rem !important;
        color: #64748b !important;
        background: transparent !important;
        transition: all 0.2s ease !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 6px !important;
        cursor: pointer !important;
    }
    .custom-pembayaran-tabs .tab-btn:hover {
        color: #059669 !important;
        background-color: #f0fdf4 !important;
    }
    .custom-pembayaran-tabs .tab-btn.active {
        color: #ffffff !important;
        background-color: #059669 !important;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1) !important;
    }

    /* Strict isolation so only active tab-pane is displayed */
    .custom-tab-content > .tab-pane {
        display: none !important;
    }
    .custom-tab-content > .tab-pane.active {
        display: block !important;
    }
</style>

<div class="mt-2 nav-pembayaran-container">
    <!-- Unified Emerald Tab Navigation -->
    <div class="custom-pembayaran-tabs bg-slate-100/80 p-1 rounded-xl inline-flex flex-wrap gap-1 mb-4 border border-slate-200/60" role="tablist">
        <button type="button" class="tab-btn active cursor-pointer" data-target="#tab-detail-biaya" role="tab" aria-selected="true">
            <i class="ti ti-report-money text-base"></i>
            <span>Detail Biaya</span>
        </button>
        <button type="button" class="tab-btn cursor-pointer" data-target="#tab-rencana-spp" role="tab" aria-selected="false">
            <i class="ti ti-wallet text-base"></i>
            <span>Rencana SPP</span>
        </button>
        <button type="button" class="tab-btn cursor-pointer" data-target="#tab-riwayat-pembayaran" role="tab" aria-selected="false">
            <i class="ti ti-history text-base"></i>
            <span>Riwayat Pembayaran</span>
        </button>
    </div>

    <!-- Tab Contents -->
    <div class="custom-tab-content">
        <!-- ================= 1. DETAIL BIAYA TAB ================= -->
        <div class="tab-pane active" id="tab-detail-biaya" role="tabpanel">
            <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
                <div class="px-4 py-3 bg-emerald-600 flex items-center justify-between text-white">
                    <div class="flex items-center gap-2">
                        <i class="ti ti-list text-base"></i>
                        <h6 class="text-xs sm:text-sm font-extrabold text-white tracking-tight m-0">Rincian Komponen Biaya Pendidikan</h6>
                    </div>
                    <span class="text-[11px] font-medium text-emerald-100">
                        Tagihan &amp; Potongan
                    </span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead class="bg-slate-100/80 text-slate-700 font-bold uppercase tracking-wider text-[11px] border-b border-slate-200">
                            <tr>
                                <th class="py-2.5 px-3">Kode</th>
                                <th class="py-2.5 px-3">Jenis Biaya</th>
                                <th class="py-2.5 px-3 text-end">Jumlah</th>
                                <th class="py-2.5 px-3 text-end">Potongan</th>
                                <th class="py-2.5 px-3 text-end">Total Biaya</th>
                                <th class="py-2.5 px-3 text-end">Mutasi</th>
                                <th class="py-2.5 px-3 text-end">Bayar</th>
                                <th class="py-2.5 px-3 text-end">Sisa Tagihan</th>
                            </tr>
                        </thead>
                        <tbody class="tabelbiaya divide-y divide-slate-100"></tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ================= 2. SPP TAB ================= -->
        <div class="tab-pane" id="tab-rencana-spp" role="tabpanel">
            <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
                <div class="px-4 py-3 bg-emerald-600 flex items-center justify-between text-white">
                    <div class="flex items-center gap-2">
                        <i class="ti ti-calendar-stats text-base"></i>
                        <h6 class="text-xs sm:text-sm font-extrabold text-white tracking-tight m-0">Jadwal &amp; Rencana Tagihan SPP Bulanan</h6>
                    </div>
                    <button type="button" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-amber-400 hover:bg-amber-300 text-slate-900 font-bold rounded-lg text-xs shadow-xs transition active:scale-95 cursor-pointer" id="buatrencanaspp"
                        no_pendaftaran="{{ Crypt::encrypt($pendaftaran->no_pendaftaran) }}">
                        <i class="ti ti-plus text-xs"></i>
                        <span>Buat Rencana SPP</span>
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead class="bg-slate-100/80 text-slate-700 font-bold uppercase tracking-wider text-[11px] border-b border-slate-200">
                            <tr>
                                <th class="py-2.5 px-3">Bulan / Tahun</th>
                                <th class="py-2.5 px-3 text-end">Tagihan</th>
                                <th class="py-2.5 px-3 text-end">Bayar</th>
                                <th class="py-2.5 px-3 text-end">Sisa Tagihan</th>
                                <th class="py-2.5 px-3 text-center">Jatuh Tempo</th>
                            </tr>
                        </thead>
                        <tbody id="tabelrencanaspp" class="divide-y divide-slate-100"></tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ================= 3. RIWAYAT PEMBAYARAN TAB ================= -->
        <div class="tab-pane" id="tab-riwayat-pembayaran" role="tabpanel">
            <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
                <div class="px-4 py-3 bg-emerald-600 flex items-center justify-between text-white">
                    <div class="flex items-center gap-2">
                        <i class="ti ti-history text-base"></i>
                        <h6 class="text-xs sm:text-sm font-extrabold text-white tracking-tight m-0">Log Riwayat Transaksi Pembayaran</h6>
                    </div>
                    <a href="#" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-amber-400 hover:bg-amber-300 text-slate-900 font-bold rounded-lg text-xs shadow-xs transition active:scale-95 cursor-pointer" id="btnBayar"
                        no_pendaftaran="{{ Crypt::encrypt($pendaftaran->no_pendaftaran) }}">
                        <i class="ti ti-plus text-xs"></i>
                        <span>Input Pembayaran Baru</span>
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead class="bg-slate-100/80 text-slate-700 font-bold uppercase tracking-wider text-[11px] border-b border-slate-200">
                            <tr>
                                <th class="py-2.5 px-3">No. Bukti</th>
                                <th class="py-2.5 px-3">Tanggal</th>
                                <th class="py-2.5 px-3 text-end">Jumlah Bayar</th>
                                <th class="py-2.5 px-3">Keterangan</th>
                                <th class="py-2.5 px-3">Petugas Kasir</th>
                                <th class="py-2.5 px-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tabelhistoribayar" class="divide-y divide-slate-100"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Proses Keluar -->
<div class="modal fade" id="modalProsesKeluar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border border-slate-200/90 shadow-2xl rounded-2xl bg-white overflow-hidden">
            <!-- Modal Header (Clean White / Rose Icon) -->
            <div class="px-6 py-4 bg-white border-b border-slate-200/90 flex items-center justify-between text-slate-900">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 border border-rose-100 flex items-center justify-center text-base shrink-0 font-bold">
                        <i class="ti ti-user-x"></i>
                    </div>
                    <h5 class="modal-title text-base font-bold text-slate-900 tracking-tight truncate mb-0">Proses Siswa Keluar</h5>
                </div>
                <button type="button" class="w-8 h-8 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 flex items-center justify-center transition-colors cursor-pointer shrink-0" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti ti-x text-lg"></i>
                </button>
            </div>

            <form action="{{ route('pembayaranpendidikan.proseskeluar', Crypt::encrypt($pendaftaran->no_pendaftaran)) }}" method="POST" class="p-6 space-y-4">
                @csrf
                <!-- Status Siswa Baru -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                        <i class="ti ti-user-exclamation text-sm text-slate-400"></i>
                        <span>Status Siswa Baru <span class="text-rose-500 font-bold">*</span></span>
                    </label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                            <i class="ti ti-user-exclamation text-base"></i>
                        </div>
                        <select name="status_siswa" class="w-full pl-9 pr-8 py-2.5 text-sm font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-rose-500/20 focus:border-rose-600 transition cursor-pointer" required>
                            <option value="3">Mengundurkan Diri</option>
                            <option value="4">Pindah Sekolah</option>
                            <option value="5">Dikeluarkan</option>
                        </select>
                    </div>
                </div>

                <!-- Tanggal Keluar -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                        <i class="ti ti-calendar text-sm text-slate-400"></i>
                        <span>Tanggal Keluar <span class="text-rose-500 font-bold">*</span></span>
                    </label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                            <i class="ti ti-calendar text-base"></i>
                        </div>
                        <input type="date" name="tanggal_keluar" class="w-full pl-9 pr-3.5 py-2.5 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-xl placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-rose-500/20 focus:border-rose-600 transition" value="{{ date('Y-m-d') }}" required>
                    </div>
                </div>

                <!-- Alasan Keluar -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                        <i class="ti ti-notes text-sm text-slate-400"></i>
                        <span>Alasan Keluar <span class="text-rose-500 font-bold">*</span></span>
                    </label>
                    <textarea name="alasan_keluar" rows="3" required placeholder="Tuliskan alasan detail siswa keluar..." class="w-full px-3.5 py-2.5 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-xl placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-rose-500/20 focus:border-rose-600 transition"></textarea>
                </div>

                <!-- Footer Actions -->
                <div class="pt-4 border-t border-slate-100 flex flex-col-reverse sm:flex-row sm:items-center justify-end gap-2.5">
                    <button type="button" class="w-full sm:w-auto px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer active:scale-95" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="w-full sm:w-auto px-6 py-2.5 bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center justify-center gap-2 cursor-pointer active:scale-95">
                        <i class="ti ti-device-floppy text-base"></i>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(function() {
        $('#btnProsesKeluar').click(function(e) {
            e.preventDefault();
            $('#modalProsesKeluar').modal('show');
        });

        // Tab Switching Handler
        $(document).off('click', '.custom-pembayaran-tabs .tab-btn').on('click', '.custom-pembayaran-tabs .tab-btn', function(e) {
            e.preventDefault();
            var target = $(this).attr('data-target');
            if (!target) return;

            // Toggle active state on tab buttons
            $(this).closest('.custom-pembayaran-tabs').find('.tab-btn').removeClass('active').attr('aria-selected', 'false');
            $(this).addClass('active').attr('aria-selected', 'true');

            // Switch active tab pane
            var container = $(this).closest('.nav-pembayaran-container');
            container.find('.custom-tab-content > .tab-pane').removeClass('active').css('display', 'none');
            container.find('.custom-tab-content > ' + target).addClass('active').css('display', 'block');
        });
    });
</script>

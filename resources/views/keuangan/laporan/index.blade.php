@extends('layouts.app')
@section('titlepage', 'Laporan Keuangan')

@section('content')
<div class="space-y-5">

    <!-- ================= 1. PAGE HEADER & BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <i class="ti ti-printer text-emerald-600 text-2xl"></i>
                <span>Laporan Keuangan</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Pusat cetak dan ekspor rekapitulasi tagihan biaya santri serta histori transaksi pembayaran
            </p>
        </div>

        <!-- Right Breadcrumb Navigation -->
        <nav class="flex items-center text-xs text-slate-400 font-medium">
            <a href="{{ route('dashboard.index') }}" class="hover:text-slate-700 transition flex items-center gap-1">
                <i class="ti ti-home text-sm"></i>
                <span>Dashboard</span>
            </a>
            <span class="mx-2 text-slate-300">/</span>
            <span class="text-slate-500 flex items-center gap-1">
                <i class="ti ti-wallet text-sm"></i>
                <span>Keuangan</span>
            </span>
            <span class="mx-2 text-slate-300">/</span>
            <span class="font-bold text-slate-800">Laporan</span>
        </nav>
    </div>

    <!-- ================= 2. MAIN TWO-COLUMN LAYOUT ================= -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-start">
        
        <!-- LEFT: REPORT NAVIGATION TABS (4 Cols on LG) -->
        <div class="lg:col-span-4 space-y-4">
            
            <!-- Navigation Card -->
            <div class="bg-white border border-slate-200/90 rounded-2xl p-3 shadow-xs">
                <div class="px-3 pt-2 pb-2 text-[11px] font-extrabold uppercase tracking-wider text-slate-400">
                    Pilih Jenis Laporan
                </div>

                <div class="space-y-1.5" id="reportNavList">
                    @can('lk.rekaptagihan')
                        <button type="button" 
                                class="report-nav-btn active w-full flex items-center justify-between p-3 rounded-xl text-left transition-all duration-150 cursor-pointer"
                                data-target="#rekaptagihan" 
                                data-report-title="Laporan Rekap Tagihan Santri"
                                data-report-subtitle="Rekapitulasi tagihan, potongan, mutasi, dan total saldo berjalan per unit & tingkat"
                                data-report-icon="ti ti-file-invoice">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="nav-icon-box w-9 h-9 rounded-xl flex items-center justify-center text-lg font-bold shrink-0 transition-colors">
                                    <i class="ti ti-file-invoice"></i>
                                </div>
                                <div class="min-w-0">
                                    <div class="nav-title text-xs font-bold tracking-tight truncate">Rekap Tagihan</div>
                                    <div class="nav-desc text-[11px] truncate">Per Unit & Tingkat Kelas</div>
                                </div>
                            </div>
                            <i class="ti ti-chevron-right nav-arrow text-sm shrink-0 transition-transform"></i>
                        </button>
                    @endcan

                    @can('lk.pembayaran')
                        <button type="button" 
                                class="report-nav-btn @cannot('lk.rekaptagihan') active @endcannot w-full flex items-center justify-between p-3 rounded-xl text-left transition-all duration-150 cursor-pointer"
                                data-target="#pembayaran" 
                                data-report-title="Laporan Transaksi Pembayaran"
                                data-report-subtitle="Daftar histori transaksi penerimaan pembayaran santri berdasarkan rentang periode"
                                data-report-icon="ti ti-cash">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="nav-icon-box w-9 h-9 rounded-xl flex items-center justify-center text-lg font-bold shrink-0 transition-colors">
                                    <i class="ti ti-cash"></i>
                                </div>
                                <div class="min-w-0">
                                    <div class="nav-title text-xs font-bold tracking-tight truncate">Pembayaran</div>
                                    <div class="nav-desc text-[11px] truncate">Histori Kas Masuk / Periode</div>
                                </div>
                            </div>
                            <i class="ti ti-chevron-right nav-arrow text-sm shrink-0 transition-transform"></i>
                        </button>
                    @endcan
                </div>
            </div>

            <!-- Helpful Guide Card -->
            <div class="bg-gradient-to-br from-slate-900 to-slate-800 text-white rounded-2xl p-4 shadow-sm border border-slate-700/60 relative overflow-hidden">
                <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-emerald-500/10 rounded-full blur-xl pointer-events-none"></div>
                <div class="flex items-center gap-2.5 mb-2">
                    <div class="w-6 h-6 rounded-lg bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-xs font-bold">
                        <i class="ti ti-bulb"></i>
                    </div>
                    <span class="text-xs font-bold text-slate-200">Tips Cetak & Ekspor</span>
                </div>
                <ul class="text-[11px] text-slate-300 space-y-1.5 list-disc pl-4 leading-relaxed">
                    <li>Gunakan tombol <b>Cetak</b> untuk membuka tampilan preview cetak siap print (Ctrl+P / Save as PDF).</li>
                    <li>Gunakan tombol <b>Export Excel</b> untuk mengunduh format spreadsheet (.xls) agar mudah diolah lebih lanjut.</li>
                </ul>
            </div>
        </div>

        <!-- RIGHT: ACTIVE REPORT FORM CARD (8 Cols on LG) -->
        <div class="lg:col-span-8">
            <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
                
                <!-- Seamless Solid Emerald Header -->
                <div class="px-5 py-4 bg-emerald-600 text-white flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-0">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-white/20 text-white flex items-center justify-center text-base font-bold border border-white/20 shadow-2xs shrink-0">
                            <i class="ti ti-printer" id="activeHeaderIcon"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-extrabold text-white tracking-tight" id="activeReportTitle">
                                Laporan Rekap Tagihan Santri
                            </h3>
                            <p class="text-[11px] text-emerald-100 font-medium mt-0.5" id="activeReportSubtitle">
                                Rekapitulasi tagihan, potongan, mutasi, dan total saldo berjalan per unit & tingkat
                            </p>
                        </div>
                    </div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-white/20 text-white border border-white/30 shadow-2xs backdrop-blur-xs shrink-0 self-start sm:self-auto">
                        <i class="ti ti-file-analytics text-xs"></i>
                        <span>Form Filter</span>
                    </span>
                </div>

                <!-- Form Content Panes -->
                <div class="p-5 sm:p-6 bg-white" id="reportPanels">
                    @can('lk.rekaptagihan')
                        <div class="report-panel block" id="rekaptagihan">
                            @include('keuangan.laporan.rekaptagihan')
                        </div>
                    @endcan

                    @can('lk.pembayaran')
                        <div class="report-panel @can('lk.rekaptagihan') hidden @else block @endcan" id="pembayaran">
                            @include('keuangan.laporan.pembayaran')
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Modern Tab Button Styles -->
<style>
    /* Report Navigation Tab Button Styles */
    .report-nav-btn {
        background: transparent;
        color: #475569;
        border: 1px solid transparent;
    }
    .report-nav-btn:hover:not(.active) {
        background: #f8fafc;
        color: #0f172a;
        border-color: #f1f5f9;
    }
    .report-nav-btn .nav-icon-box {
        background: #f1f5f9;
        color: #64748b;
        border: 1px solid #e2e8f0;
    }
    .report-nav-btn .nav-title {
        color: #1e293b;
    }
    .report-nav-btn .nav-desc {
        color: #94a3b8;
    }
    .report-nav-btn .nav-arrow {
        color: #cbd5e1;
    }

    /* Active Tab Button */
    .report-nav-btn.active {
        background: #ecfdf5 !important;
        border: 1px solid #a7f3d0 !important;
        box-shadow: 0 1px 3px rgba(5, 150, 105, 0.08);
    }
    .report-nav-btn.active .nav-icon-box {
        background: #059669 !important;
        color: #ffffff !important;
        border-color: #059669 !important;
        box-shadow: 0 2px 4px rgba(5, 150, 105, 0.25);
    }
    .report-nav-btn.active .nav-title {
        color: #065f46 !important;
        font-weight: 800 !important;
    }
    .report-nav-btn.active .nav-desc {
        color: #047857 !important;
        font-weight: 600 !important;
    }
    .report-nav-btn.active .nav-arrow {
        color: #059669 !important;
        transform: translateX(3px);
    }
</style>

@endsection

@push('myscript')
<script>
    $(function() {
        // Tab switching logic
        $(document).on('click', '.report-nav-btn', function(e) {
            e.preventDefault();
            const $btn = $(this);
            const targetId = $btn.data('target');
            if (!targetId) return;

            // 1. Update tab buttons
            $('.report-nav-btn').removeClass('active');
            $btn.addClass('active');

            // 2. Switch panels
            $('.report-panel').addClass('hidden').removeClass('block');
            $(targetId).removeClass('hidden').addClass('block');

            // 3. Update header content
            const title = $btn.data('report-title') || 'Laporan Keuangan';
            const subtitle = $btn.data('report-subtitle') || 'Silakan tentukan parameter filter laporan di bawah ini';
            const iconClass = $btn.data('report-icon') || 'ti ti-printer';

            $('#activeReportTitle').text(title);
            $('#activeReportSubtitle').text(subtitle);
            $('#activeHeaderIcon').attr('class', iconClass);
        });

        // Initialize active header on page load
        const $initialActive = $('.report-nav-btn.active').first();
        if ($initialActive.length) {
            $('#activeReportTitle').text($initialActive.data('report-title'));
            $('#activeReportSubtitle').text($initialActive.data('report-subtitle'));
            $('#activeHeaderIcon').attr('class', $initialActive.data('report-icon'));
        }

        // Tingkat AJAX Loading Handler
        function loadTingkat(kode_unit, targetSelect) {
            const $select = $(targetSelect);
            if (!kode_unit) {
                $select.html('<option value="">-- Pilih Tingkat --</option>');
                return;
            }

            $.ajax({
                type: "POST",
                url: "{{ route('unit.gettingkatbyunit') }}",
                cache: false,
                data: {
                    _token: "{{ csrf_token() }}",
                    kode_unit: kode_unit
                },
                success: function(respond) {
                    $select.html(respond);
                },
                error: function() {
                    $select.html('<option value="">-- Gagal memuat tingkat --</option>');
                }
            });
        }

        // Event for Unit change in Rekap Tagihan form
        $('#kode_unit_rekap').on('change', function() {
            loadTingkat($(this).val(), '#tingkat_rekap');
        });

        // Event for Unit change in Pembayaran form
        $('#kode_unit_bayar').on('change', function() {
            loadTingkat($(this).val(), '#tingkat_bayar');
        });

        // Form Validation for Rekap Tagihan
        $('#formRekapTagihan').on('submit', function(e) {
            const unit = $('#kode_unit_rekap').val();
            const tingkat = $('#tingkat_rekap').val();
            const kode_ta = $('#kode_ta_rekap').val();

            if (!unit) {
                e.preventDefault();
                if (window.showWarningAlert) {
                    window.showWarningAlert("Silakan pilih Unit Sekolah terlebih dahulu!", "Unit Belum Dipilih");
                } else {
                    Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Unit Sekolah tidak boleh kosong!' });
                }
                $('#kode_unit_rekap').focus();
                return false;
            }

            if (!tingkat) {
                e.preventDefault();
                if (window.showWarningAlert) {
                    window.showWarningAlert("Silakan pilih Tingkat / Jenjang terlebih dahulu!", "Tingkat Belum Dipilih");
                } else {
                    Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Tingkat tidak boleh kosong!' });
                }
                $('#tingkat_rekap').focus();
                return false;
            }

            if (!kode_ta) {
                e.preventDefault();
                if (window.showWarningAlert) {
                    window.showWarningAlert("Silakan pilih Tahun Ajaran terlebih dahulu!", "Tahun Ajaran Kosong");
                } else {
                    Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Tahun Ajaran tidak boleh kosong!' });
                }
                $('#kode_ta_rekap').focus();
                return false;
            }
        });

        // Form Validation for Pembayaran
        $('#formPembayaran').on('submit', function(e) {
            const dari = $('#dari').val();
            const sampai = $('#sampai').val();

            if (!dari) {
                e.preventDefault();
                if (window.showWarningAlert) {
                    window.showWarningAlert("Silakan isi Dari Tanggal periode pembayaran!", "Tanggal Awal Kosong");
                } else {
                    Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Dari Tanggal harus diisi!' });
                }
                $('#dari').focus();
                return false;
            }

            if (!sampai) {
                e.preventDefault();
                if (window.showWarningAlert) {
                    window.showWarningAlert("Silakan isi Sampai Tanggal periode pembayaran!", "Tanggal Akhir Kosong");
                } else {
                    Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Sampai Tanggal harus diisi!' });
                }
                $('#sampai').focus();
                return false;
            }

            if (new Date(dari) > new Date(sampai)) {
                e.preventDefault();
                if (window.showWarningAlert) {
                    window.showWarningAlert("Rentang tanggal tidak valid! Tanggal akhir tidak boleh lebih awal dari tanggal awal.", "Periode Tidak Valid");
                } else {
                    Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Periode Sampai harus lebih akhir dari Dari Tanggal!' });
                }
                $('#sampai').focus();
                return false;
            }
        });
    });
</script>
@endpush


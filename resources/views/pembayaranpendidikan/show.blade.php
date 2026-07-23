<div class="card border-0 shadow-none mb-4" style="background: rgba(6, 78, 59, 0.04); border-radius: 16px;">
    <div class="card-body p-4">
        <div class="row align-items-center">
            <div class="col-md-auto text-center mb-3 mb-md-0 pe-md-4 border-end-md">
                <div class="position-relative d-inline-block">
                    <img src="{{ asset('assets/img/avatars/No_Image_Available.jpg') }}" 
                        alt="{{ $pendaftaran->nama_lengkap }}" 
                        class="rounded-circle shadow-sm border border-4 border-white" 
                        style="width: 100px; height: 100px; object-fit: cover;">
                </div>
            </div>
            <div class="col-md ps-md-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h4 class="mb-1 fw-bold text-dark text-uppercase lh-1" style="letter-spacing: 0.7px;">{{ $pendaftaran->nama_lengkap }}</h4>
                        <div class="d-flex align-items-center gap-2 mt-2">
                            <span class="badge bg-label-success px-2 py-1 border border-success border-opacity-10 shadow-none"><i class="ti ti-barcode fs-tiny"></i> {{ $pendaftaran->no_pendaftaran }}</span>
                            <span class="text-muted small">| NISN: <span class="fw-bold text-dark">{{ $pendaftaran->nisn ?: '-' }}</span></span>
                        </div>
                    </div>
                    <div class="text-md-end d-none d-sm-block">
                        <span class="badge bg-white text-dark shadow-sm p-2 border-0 rounded-pill px-3 fw-bold"> 
                            <i class="ti ti-school fs-6 text-success me-1"></i> TA: {{ $pendaftaran->tahun_ajaran }}
                        </span>
                    </div>
                </div>
                <!-- Info Grid -->
                <div class="row g-3 mt-1">
                    <div class="col-md-4 col-sm-6">
                        <div class="d-flex align-items-center gap-2">
                            <div class="avatar avatar-sm bg-white shadow-sm rounded-circle text-success d-flex align-items-center justify-content-center">
                                <i class="ti ti-gender-femme fs-5"></i>
                            </div>
                            <div>
                                <p class="mb-0 text-muted small lh-1">Jenis Kelamin</p>
                                <span class="fw-bold text-dark small">{{ $pendaftaran->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="d-flex align-items-center gap-2">
                            <div class="avatar avatar-sm bg-white shadow-sm rounded-circle text-success d-flex align-items-center justify-content-center">
                                <i class="ti ti-calendar-event fs-5"></i>
                            </div>
                            <div>
                                <p class="mb-0 text-muted small lh-1">Tempat/Tgl Lahir</p>
                                <span class="fw-bold text-dark small">{{ textCamelCase($pendaftaran->tempat_lahir) }}, {{ DateToIndo($pendaftaran->tanggal_lahir) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="d-flex align-items-center gap-2">
                            <div class="avatar avatar-sm bg-white shadow-sm rounded-circle text-success d-flex align-items-center justify-content-center">
                                <i class="ti ti-building-community fs-5"></i>
                            </div>
                            <div>
                                <p class="mb-0 text-muted small lh-1">Jenjang/Unit</p>
                                <span class="fw-bold text-dark small text-uppercase">{{ $pendaftaran->nama_unit }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .table-report td {
        border: none !important;
        padding: 4px 8px !important;
    }
    .nav-tabs .nav-link {
        border: none;
        padding: 1rem 1.5rem;
        color: #8e959d;
        font-weight: 600;
        transition: all 0.2s ease;
        border-bottom: 2px solid transparent;
        font-size: 0.9rem;
    }
    .nav-tabs .nav-link.active {
        background-color: transparent !important;
        color: #064e3b !important;
        border-bottom: 3px solid #064e3b;
    }
    .nav-tabs .nav-link:hover:not(.active) {
        color: #064e3b;
    }
    .border-end-md {
        border-right: 1px solid #eee;
    }
    @media (max-width: 768px) {
        .border-end-md { border-right: none; }
    }
    
    .card-merged {
        border-radius: 12px !important;
        overflow: hidden !important;
        border: none !important;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
    }
    .card-merged .card-header {
        background-color: #064e3b !important;
        padding: 0.75rem 1.15rem !important;
        border-bottom: none !important;
    }
    .table-compact {
        font-size: 0.875rem !important;
    }
    .table-compact th, .table-compact td {
        padding-left: 1.15rem !important;
        padding-right: 1.15rem !important;
        padding-top: 0.5rem !important;
        padding-bottom: 0.5rem !important;
    }
</style>

<div class="row mt-4">
    <div class="col">
        <div class="nav-align-top mb-0">
            <ul class="nav nav-tabs border-bottom mb-4" role="tablist">
                <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                        data-bs-target="#navs-justified-home" aria-controls="navs-justified-home" aria-selected="true">
                        <i class="ti ti-report-money me-1 fs-5"></i> Detail Biaya
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-profile"
                        aria-controls="navs-justified-profile" aria-selected="false">
                        <i class="ti ti-wallet me-1 fs-5"></i> SPP
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-messages"
                        aria-controls="navs-justified-messages" aria-selected="false">
                        <i class="ti ti-history me-1 fs-5"></i> Riwayat Pembayaran
                    </button>
                </li>
            </ul>
            <div class="tab-content p-0 bg-transparent shadow-none border-0">
                <!-- Detail Biaya Tab -->
                <div class="tab-pane fade show active" id="navs-justified-home" role="tabpanel">
                    <div class="card card-merged">
                        <div class="card-header d-flex align-items-center gap-2">
                            <i class="ti ti-list text-white fs-5"></i>
                            <h6 class="card-title mb-0 text-white small">Rincian Biaya Pendidikan</h6>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 text-nowrap table-compact">
                                <thead style="background-color: #064e3b">
                                    <tr>
                                        <th class="text-white py-3">Kode</th>
                                        <th class="text-white py-3">Jenis Biaya</th>
                                        <th class="text-white py-3 text-end">Jumlah</th>
                                        <th class="text-white py-3 text-end">Potongan</th>
                                        <th class="text-white py-3 text-end">Total</th>
                                        <th class="text-white py-3 text-end">Mutasi</th>
                                        <th class="text-white py-3 text-end">Bayar</th>
                                        <th class="text-white py-3 text-end">Tagihan</th>
                                    </tr>
                                </thead>
                                <tbody class="tabelbiaya"></tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- SPP Tab -->
                <div class="tab-pane fade" id="navs-justified-profile" role="tabpanel">
                    <div class="d-flex justify-content-between align-items-center mb-3 px-1">
                        <h6 class="mb-0 fw-bold"><i class="ti ti-calendar-stats me-1"></i> Rencana SPP</h6>
                        <button class="btn btn-sm text-white" id="buatrencanaspp" style="background-color: #064e3b"
                            no_pendaftaran="{{ Crypt::encrypt($pendaftaran->no_pendaftaran) }}">
                            <i class="ti ti-plus me-1"></i> Buat Rencana
                        </button>
                    </div>
                    <div class="card card-merged">
                        <div class="card-header d-flex align-items-center gap-2">
                            <i class="ti ti-list text-white fs-5"></i>
                            <h6 class="card-title mb-0 text-white small">Jadwal Tagihan SPP</h6>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 text-nowrap table-compact">
                                <thead style="background-color: #064e3b">
                                    <tr>
                                        <th class="text-white py-3">Bulan</th>
                                        <th class="text-white py-3 text-end">Tagihan</th>
                                        <th class="text-white py-3 text-end">Bayar</th>
                                        <th class="text-white py-3 text-end">Sisa</th>
                                        <th class="text-white py-3 text-center">Jatuh Tempo</th>
                                    </tr>
                                </thead>
                                <tbody id="tabelrencanaspp"></tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Riwayat Tab -->
                <div class="tab-pane fade" id="navs-justified-messages" role="tabpanel">
                    <div class="d-flex justify-content-between align-items-center mb-3 px-1">
                        <h6 class="mb-0 fw-bold"><i class="ti ti-history me-1"></i> Log Pembayaran</h6>
                        <a href="#" class="btn btn-sm text-white" id="btnBayar" style="background-color: #064e3b"
                            no_pendaftaran="{{ Crypt::encrypt($pendaftaran->no_pendaftaran) }}">
                            <i class="ti ti-plus me-1"></i> Input Pembayaran
                        </a>
                    </div>
                    <div class="card card-merged">
                        <div class="card-header d-flex align-items-center gap-2">
                            <i class="ti ti-list text-white fs-5"></i>
                            <h6 class="card-title mb-0 text-white small">Histori Transaksi</h6>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 text-nowrap table-compact">
                                <thead style="background-color: #064e3b">
                                    <tr>
                                        <th class="text-white py-3">No. Bukti</th>
                                        <th class="text-white py-3">Tanggal</th>
                                        <th class="text-white py-3 text-end">Jumlah</th>
                                        <th class="text-white py-3">Keterangan</th>
                                        <th class="text-white py-3">Petugas</th>
                                        <th class="text-white py-3 text-center">#</th>
                                    </tr>
                                </thead>
                                <tbody id="tabelhistoribayar"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Proses Keluar -->
<div class="modal fade" id="modalProsesKeluar" tabindex="-1" aria-hidden="true" style="z-index: 1100;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Proses Siswa Keluar / Mengundur Diri</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('pembayaranpendidikan.proseskeluar', Crypt::encrypt($pendaftaran->no_pendaftaran)) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Status Siswa Baru</label>
                        <select name="status_siswa" class="form-select" required>
                            <option value="3">Mengundurkan Diri</option>
                            <option value="4">Pindah Sekolah</option>
                            <option value="5">Dikeluarkan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Keluar</label>
                        <input type="date" name="tanggal_keluar" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alasan Keluar</label>
                        <textarea name="alasan_keluar" class="form-control" rows="3" required placeholder="Tuliskan alasan detail siswa keluar..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Simpan Perubahan</button>
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
    });
</script>

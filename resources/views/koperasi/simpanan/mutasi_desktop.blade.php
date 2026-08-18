@php
    $saldo = $saldo_simpanan ? $saldo_simpanan->jumlah : 0;
    $nama_simpanan = $saldo_simpanan ? $saldo_simpanan->jenis_simpanan : 'Simpanan';
@endphp

<div class="row g-4">
    <!-- Summary Header Cards -->
    <div class="col-12">
        <div class="card border-0 p-3 rounded-3" style="background-color: #f4faf6; border: 1px solid #cce8d9 !important;">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <h5 class="fw-bold mb-1" style="color: #064e3b;">{{ $nama_simpanan }}</h5>
                    <p class="text-secondary small mb-0">Rincian mutasi rekening simpanan Koperasi Tsarwah</p>
                </div>
                <div class="text-md-end">
                    <span class="text-secondary small d-block">Saldo Akumulasi Saat Ini</span>
                    <h4 class="fw-extrabold text-success font-monospace mb-0">Rp {{ number_format($saldo, 0, ',', '.') }}</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Mutasi Transactions Table -->
    <div class="col-12">
        <div class="card border-0 p-3 rounded-3" style="border: 1px solid #eef2f6 !important; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
            <h6 class="fw-bold mb-3" style="color: #064e3b;">Riwayat Transaksi</h6>
            
            <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                <table class="table table-sm table-hover align-middle">
                    <thead class="sticky-top bg-white border-bottom" style="z-index: 10; border-bottom: 2px solid #064e3b !important;">
                        <tr class="small" style="color: #064e3b; font-weight: 600;">
                            <th class="py-2">Tanggal</th>
                            <th class="py-2">No. Transaksi</th>
                            <th class="py-2 text-center">Jenis Transaksi</th>
                            <th class="py-2 text-end">Jumlah</th>
                            <th class="py-2 text-end">Saldo Akhir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($mutasi as $d)
                            <tr>
                                <td class="py-2 small">{{ date('d M Y', strtotime($d->tanggal)) }}</td>
                                <td class="py-2 font-monospace text-secondary small">{{ $d->no_transaksi }}</td>
                                <td class="py-2 text-center">
                                    @if ($d->jenis_transaksi == 'D')
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill fw-bold small">SIMPANAN (DEBET)</span>
                                    @else
                                        <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill fw-bold small">PENARIKAN (KREDIT)</span>
                                    @endif
                                </td>
                                <td class="py-2 text-end font-monospace fw-bold text-dark small">
                                    {{ $d->jenis_transaksi == 'D' ? '+' : '-' }} Rp {{ number_format($d->jumlah, 0, ',', '.') }}
                                </td>
                                <td class="py-2 text-end font-monospace text-success fw-bold small">
                                    Rp {{ number_format($d->saldo, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted small">Belum ada riwayat mutasi transaksi untuk simpanan ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

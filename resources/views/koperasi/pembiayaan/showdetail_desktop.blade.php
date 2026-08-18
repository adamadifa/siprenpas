@php
    $jumlah_pembiayaan = $pembiayaan->jumlah + ($pembiayaan->persentase / 100) * $pembiayaan->jumlah;
    $isLunas = $pembiayaan->jmlbayar >= $jumlah_pembiayaan;
    $progress = $jumlah_pembiayaan > 0 ? min(100, round(($pembiayaan->jmlbayar / $jumlah_pembiayaan) * 100)) : 0;
@endphp

<div class="row g-4">
    <!-- Left side: Summary Info -->
    <div class="col-md-5">
        <div class="card border-0 p-3 rounded-3 h-100" style="background-color: #f4faf6; border: 1px solid #cce8d9 !important;">
            <h5 class="fw-bold mb-3 border-bottom pb-2 d-flex justify-content-between align-items-center" style="color: #064e3b; border-bottom-color: rgba(6,78,59,0.1) !important;">
                <span>Informasi Akad</span>
                @if ($isLunas)
                    <span class="badge bg-success small">LUNAS</span>
                @else
                    <span class="badge bg-danger small">BELUM LUNAS</span>
                @endif
            </h5>
            
            <table class="table table-sm table-borderless text-secondary small">
                <tr>
                    <td class="py-1">No. Akad</td>
                    <td class="py-1 fw-bold text-dark text-end">{{ $pembiayaan->no_akad }}</td>
                </tr>
                <tr>
                    <td class="py-1">Tanggal Akad</td>
                    <td class="py-1 fw-bold text-dark text-end">{{ DateToIndo($pembiayaan->tanggal) }}</td>
                </tr>
                <tr>
                    <td class="py-1">Jenis Pembiayaan</td>
                    <td class="py-1 fw-bold text-dark text-end text-success">{{ $pembiayaan->jenis_pembiayaan }}</td>
                </tr>
                <tr>
                    <td class="py-1">Tenor Waktu</td>
                    <td class="py-1 fw-bold text-dark text-end">{{ $pembiayaan->jangka_waktu }} Bulan</td>
                </tr>
                <tr>
                    <td class="py-1">Pokok Pembiayaan</td>
                    <td class="py-1 fw-bold text-dark text-end font-monospace">Rp {{ formatAngka($pembiayaan->jumlah) }}</td>
                </tr>
                <tr>
                    <td class="py-1">Jasa Koperasi</td>
                    <td class="py-1 fw-bold text-dark text-end font-monospace">{{ $pembiayaan->persentase }}% (Rp {{ formatAngka($jumlah_pembiayaan - $pembiayaan->jumlah) }})</td>
                </tr>
                <tr class="border-top">
                    <td class="py-2 fw-bold text-dark">Total Pembiayaan</td>
                    <td class="py-2 fw-extrabold text-success text-end font-monospace" style="font-size: 1rem;">Rp {{ formatAngka($jumlah_pembiayaan) }}</td>
                </tr>
                <tr>
                    <td class="py-1">Sudah Dibayar</td>
                    <td class="py-1 fw-bold text-primary text-end font-monospace">Rp {{ formatAngka($pembiayaan->jmlbayar) }}</td>
                </tr>
                <tr class="border-top">
                    <td class="py-2 fw-bold text-dark">Sisa Tagihan</td>
                    <td class="py-2 fw-extrabold text-danger text-end font-monospace" style="font-size: 1rem;">Rp {{ formatAngka($jumlah_pembiayaan - $pembiayaan->jmlbayar) }}</td>
                </tr>
            </table>

            <div class="mt-3">
                <div class="d-flex justify-content-between align-items-center mb-1 text-secondary small">
                    <span>Progress Pembayaran</span>
                    <span class="fw-bold text-success">{{ $progress }}%</span>
                </div>
                <div class="progress rounded-pill" style="height: 8px;">
                    <div class="progress-bar bg-success rounded-pill" role="progressbar" style="width: {{ $progress }}%;" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right side: Instalment Schedule Table -->
    <div class="col-md-7">
        <div class="card border-0 p-3 rounded-3 h-100" style="border: 1px solid #eef2f6 !important; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
            <h5 class="fw-bold mb-3 border-bottom pb-2" style="color: #064e3b; border-bottom-color: rgba(6,78,59,0.1) !important;">Rencana & Riwayat Cicilan</h5>
            
            <div class="table-responsive" style="max-height: 380px; overflow-y: auto;">
                <table class="table table-sm table-hover align-middle">
                    <thead class="sticky-top bg-white border-bottom" style="z-index: 10; border-bottom: 2px solid #064e3b !important;">
                        <tr class="small" style="color: #064e3b; font-weight: 600;">
                            <th class="py-2 text-center">Cicilan Ke</th>
                            <th class="py-2">Jatuh Tempo</th>
                            <th class="py-2 text-end">Tagihan</th>
                            <th class="py-2 text-end">Bayar</th>
                            <th class="py-2 text-end">Sisa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rencanapembiayaan as $d)
                            @php
                                $jatuhtempo = $d->tahun . '-' . $d->bulan . '-05';
                                $tagihan = $d->jumlah ?? 0;
                                $bayar = $d->bayar ?? 0;
                                $sisa = $tagihan - $bayar;
                            @endphp
                            <tr style="background-color: {{ $sisa <= 0 ? '#f3fdf6' : '#ffffff' }}">
                                <td class="py-2 text-center fw-bold text-secondary">{{ $d->cicilan_ke }}</td>
                                <td class="py-2 small">{{ date('d M Y', strtotime($jatuhtempo)) }}</td>
                                <td class="py-2 text-end font-monospace small">Rp {{ formatAngka($tagihan) }}</td>
                                <td class="py-2 text-end text-success fw-bold font-monospace small">Rp {{ formatAngka($bayar) }}</td>
                                <td class="py-2 text-end text-danger fw-bold font-monospace small">Rp {{ formatAngka($sisa) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

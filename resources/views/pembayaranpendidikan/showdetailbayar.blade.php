@php
    $namaSekolah = optional($pengaturan)->nama_sekolah ?? 'Pesantren Persis 80 Al-Amin';
    $alamatSekolah = optional($pengaturan)->alamat_sekolah ?? 'Jl. Raya Ancol No. 27 Sindangkasih Ciamis';
    $logoUrl = optional($pengaturan)->logo
        ? asset('storage/' . $pengaturan->logo)
        : asset('assets/img/logo/persisalamin.png');
@endphp

<div class="p-2 p-md-4">
    <!-- Receipt Container -->
    <div class="card border shadow-none" style="border-style: dashed !important; border-width: 2px !important; border-radius: 15px;">
        <div class="card-body p-4">
            <!-- Branding Header -->
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div class="d-flex align-items-center gap-3">
                    <img src="{{ $logoUrl }}" alt="Logo" style="height: 65px; width: auto; object-fit: contain;">
                    <div>
                        <h5 class="mb-0 fw-bold text-dark">{{ $namaSekolah }}</h5>
                        <p class="mb-0 text-muted small" style="max-width: 300px;">{{ $alamatSekolah }}</p>
                    </div>
                </div>
                <div class="text-end">
                    <h4 class="mb-0 fw-bold text-success text-uppercase" style="letter-spacing: 1px;">Kwitansi</h4>
                    <span class="badge bg-label-secondary border">#{{ $historibayar->no_bukti }}</span>
                </div>
            </div>

            <hr class="my-4" style="border-top: 2px dashed #eee;">

            <!-- Transaction Meta -->
            <div class="row g-4 mb-4">
                <div class="col-sm-6">
                    <div class="mb-3">
                        <p class="text-muted small text-uppercase mb-1 fw-semibold">Diterima Dari:</p>
                        <h6 class="mb-0 fw-bold text-dark text-uppercase">{{ $historibayar->nama_lengkap }}</h6>
                        <p class="mb-0 text-muted small">Reg: {{ $historibayar->no_pendaftaran }} | NISN: {{ $historibayar->nisn ?: '-' }}</p>
                    </div>
                </div>
                <div class="col-sm-6 text-sm-end">
                    <div class="mb-3">
                        <p class="text-muted small text-uppercase mb-1 fw-semibold">Tanggal Transaksi:</p>
                        <h6 class="mb-0 fw-bold text-dark">{{ DateToIndo($historibayar->tanggal) }}</h6>
                        <p class="mb-0 text-muted small">Waktu: {{ date('H:i', strtotime($historibayar->created_at)) }} WIB</p>
                    </div>
                </div>
            </div>

            <!-- Items Table -->
            <div class="table-responsive mb-4">
                <table class="table table-sm border-top border-bottom">
                    <thead class="bg-light">
                        <tr>
                            <th class="py-2 px-3 text-uppercase small fw-bold">Rincian Pembayaran</th>
                            <th class="py-2 px-3 text-end text-uppercase small fw-bold" style="width: 150px;">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @php $total = 0; @endphp
                        @foreach ($detail as $d)
                            @php $total += $d->jumlah; @endphp
                            <tr>
                                <td class="py-3 px-3">
                                    <span class="fw-bold d-block text-dark">{{ $d->jenis_biaya }}</span>
                                    <small class="text-muted">{{ $d->keterangan }} {{ in_array($d->kode_jenis_biaya, ['B07', 'B01']) ? ' - ' . $d->tahun_ajaran : '' }}</small>
                                </td>
                                <td class="py-3 px-3 text-end align-middle fw-bold text-dark">
                                    {{ formatAngka($d->jumlah) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-light border-top border-dark border-opacity-10">
                            <td class="py-3 px-3 text-end fw-bold text-uppercase small">Total Pembayaran</td>
                            <td class="py-3 px-3 text-end fw-bold text-success fs-5">
                                <small>Rp</small> {{ formatAngka($total) }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Footnote & Signatures -->
            <div class="row align-items-end mt-5">
                <div class="col-sm-7 small">
                    <div class="p-3 bg-light rounded-3 border">
                        <p class="mb-1 fw-bold text-muted text-uppercase" style="font-size: 10px;">Catatan:</p>
                        <p class="mb-0 text-muted" style="font-size: 11px; line-height: 1.4;">
                            * Simpan kwitansi ini sebagai bukti pembayaran yang sah.<br>
                            * Pembayaran telah diverifikasi secara sistem oleh bendahara sekolah.
                        </p>
                    </div>
                </div>
                <div class="col-sm-5 text-center">
                    <p class="text-muted small mb-0">{{ textCamelCase($historibayar->nama_lengkap) }}, {{ date('d/m/Y') }}</p>
                    <p class="mb-5 fw-semibold text-dark small">Bendahara / Penerima,</p>
                    <div class="mt-4 pt-2 border-top d-inline-block px-5">
                        <h6 class="mb-0 fw-bold text-dark">{{ $historibayar->name }}</h6>
                        <small class="text-muted">Administrator</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .modal-body {
        background-color: #f8f9fa !important;
    }
</style>

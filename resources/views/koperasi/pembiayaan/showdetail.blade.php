@extends('layouts.mobile.app')
@section('content')
    <style>
        .avatar {
            position: relative;
            width: 2.5rem;
            height: 2.5rem;
            cursor: pointer;
        }


        .avatar-sm {
            width: 2rem;
            height: 2rem;
        }

        .avatar-sm .avatar-initial {
            font-size: .8125rem;
        }

        .avatar .avatar-initial {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            text-transform: uppercase;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            background-color: #eeedf0;
            font-size: .9375rem;
        }

        .rounded-circle {
            border-radius: 50% !important;
        }

        .bg-label-warning {
            background-color: #fff0e1 !important;
            color: #ff9f43 !important;
        }

        .transactions {
            height: 100% !important;
        }
    </style>
    <div id="header-section">
        <div class="appHeader bg-primary text-light">
            <div class="left">
                <a href="javascript:;" class="headerButton goBack">
                    <ion-icon name="chevron-back-outline"></ion-icon>
                </a>
            </div>
            <div class="pageTitle">Pembiayaan</div>
            <div class="right"></div>
        </div>
    </div>
    <style>
        .detail-card {
            border-radius: 18px;
            box-shadow: 0 4px 16px #e0f7fa99;
            background: linear-gradient(135deg, #fff 80%, #e0f7fa 100%);
            padding: 20px 18px 16px 18px;
            margin-bottom: 20px;
            position: relative;
            border: 1.5px solid #d1f5e0;
        }

        .detail-card .badge {
            border-radius: 8px;
            font-size: 0.92em;
            padding: 4px 10px;
            font-weight: 600;
            margin-left: 6px;
        }

        .detail-card .badge-lunas {
            background: #3ac79b;
            color: #fff;
        }

        .detail-card .badge-belum {
            background: #ff5252;
            color: #fff;
        }

        .detail-card .badge-disetujui {
            background: #4caf50;
            color: #fff;
        }

        .detail-card .badge-belumsetujui {
            background: #ffe082;
            color: #333;
        }

        .detail-card .row-label {
            color: #888;
            font-size: 0.97em;
            min-width: 110px;
        }

        .detail-card .row-value {
            color: #1a1a1a;
            font-weight: 600;
            font-size: 1.05em;
            text-align: right;
        }

        .detail-card .progress {
            height: 8px;
            border-radius: 8px;
            background: #e0e0e0;
            margin-top: 12px;
            margin-bottom: 4px;
            overflow: hidden;
        }

        .detail-card .progress-bar {
            background: linear-gradient(90deg, #3ac79b, #00bfae 90%);
        }

        .cicilan-list {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .cicilan-list li {
            border-bottom: 1px solid #e0f7fa;
            padding: 10px 0 7px 0;
            display: flex;
            align-items: center;
            font-size: 0.98em;
        }

        .cicilan-list li:last-child {
            border-bottom: none;
        }

        .cicilan-label {
            color: #888;
            min-width: 90px;
            font-size: 0.97em;
        }

        .cicilan-value {
            flex: 1;
            text-align: right;
            font-weight: 600;
            color: #222;
        }
    </style>
    <div id="content-section" style="padding-top:64px;padding-left:8px;padding-right:8px;">
        <div class="detail-card">
            <div style="display:flex;align-items:center;gap:7px;justify-content:space-between;">
                <div style="font-size:1.1em;font-weight:700;color:#222;">Detail Pembiayaan</div>
                <div>
                    @php
                        $jumlah_pembiayaan =
                            $pembiayaan->jumlah + ($pembiayaan->persentase / 100) * $pembiayaan->jumlah;
                        $isLunas = $pembiayaan->jmlbayar >= $jumlah_pembiayaan;
                    @endphp
                    @if (isset($pembiayaan->status))
                        @if ($pembiayaan->status == '1')
                            <span class="badge badge-disetujui"><ion-icon name="checkmark-circle-outline"></ion-icon>
                                Disetujui</span>
                        @else
                            <span class="badge badge-belumsetujui"><ion-icon name="time-outline"></ion-icon> Belum
                                Disetujui</span>
                        @endif
                    @endif
                    @if ($isLunas)
                        <span class="badge badge-lunas"><ion-icon name="checkmark-done-outline"></ion-icon> LUNAS</span>
                    @else
                        <span class="badge badge-belum"><ion-icon name="alert-circle-outline"></ion-icon> BELUM LUNAS</span>
                    @endif
                </div>
            </div>
            <div style="margin-top:18px;display:grid;grid-template-columns:1fr 1fr;row-gap:8px;column-gap:16px;">
                <div class="row-label">No. Akad</div>
                <div class="row-value">{{ $pembiayaan->no_akad }}</div>
                <div class="row-label">Tanggal</div>
                <div class="row-value">{{ DateToIndo($pembiayaan->tanggal) }}</div>
                <div class="row-label">Jenis</div>
                <div class="row-value">{{ $pembiayaan->jenis_pembiayaan }}</div>
                <div class="row-label">Jumlah</div>
                <div class="row-value">Rp{{ formatAngka($pembiayaan->jumlah) }}</div>
                <div class="row-label">Persentase</div>
                <div class="row-value">{{ $pembiayaan->persentase }}%</div>
                <div class="row-label">Total</div>
                <div class="row-value">Rp{{ formatAngka($jumlah_pembiayaan) }}</div>
                <div class="row-label">Terbayar</div>
                <div class="row-value">Rp{{ formatAngka($pembiayaan->jmlbayar) }}</div>
                <div class="row-label">Sisa</div>
                <div class="row-value">Rp{{ formatAngka($jumlah_pembiayaan - $pembiayaan->jmlbayar) }}</div>
            </div>
            @php
                $progress =
                    $jumlah_pembiayaan > 0 ? min(100, round(($pembiayaan->jmlbayar / $jumlah_pembiayaan) * 100)) : 0;
            @endphp
            <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%;"
                    aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div style="font-size:0.98em;color:#888;margin-top:2px;">Progress pembayaran: <b>{{ $progress }}%</b></div>
        </div>

        <div class="detail-card" style="padding-bottom:8px;">
    <div style="font-size:1.08em;font-weight:600;color:#222;margin-bottom:10px;">Rencana & Riwayat Pembayaran</div>
    <div class="cicilan-list" style="margin-bottom:2px;">
        <li style="display:flex;align-items:center;font-size:0.99em;font-weight:600;color:#3ac79b;background:#f7fffb;border-bottom:2px solid #e0f7fa;padding:7px 0 7px 0;">
            <span class="cicilan-label" style="color:#3ac79b;">Tanggal</span>
            <span class="cicilan-value" style="color:#3ac79b;">Tagihan</span>
            <span class="cicilan-value" style="color:#3ac79b;">Bayar</span>
            <span class="cicilan-value" style="color:#3ac79b;">Sisa</span>
        </li>
        @foreach ($rencanapembiayaan as $d)
            @php
                $jatuhtempo = $d->tahun . '-' . $d->bulan . '-05';
                $tagihan = $d->jumlah ?? 0;
                $bayar = $d->bayar ?? 0;
                $sisa = $tagihan - $bayar;
            @endphp
            <li>
                <span class="cicilan-label">{{ date('d/m/y', strtotime($jatuhtempo)) }}</span>
                <span class="cicilan-value">Rp{{ formatAngka($tagihan) }}</span>
                <span class="cicilan-value" style="color:#3ac79b;font-weight:500;">Rp{{ formatAngka($bayar) }}</span>
                <span class="cicilan-value" style="color:#ff9800;font-weight:500;">Rp{{ formatAngka($sisa) }}</span>
            </li>
        @endforeach
    </div>
</div>
    </div>

@endsection

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
    <style>
        .pembiayaan-card {
            border-radius: 18px;
            box-shadow: 0 4px 16px #e0f7fa99;
            background: linear-gradient(135deg, #fff 80%, #e0f7fa 100%);
            display: flex;
            align-items: center;
            padding: 18px 16px;
            border: 1.5px solid #d1f5e0;
            margin-bottom: 18px;
            transition: box-shadow 0.2s, transform 0.2s;
            position: relative;
            overflow: hidden;
        }

        .pembiayaan-card:hover {
            box-shadow: 0 8px 28px #3ac79b33;
            transform: translateY(-2px) scale(1.01);
            border-color: #3ac79b;
        }

        .pembiayaan-card .avatar {
            background: linear-gradient(135deg, #3ac79b 70%, #00bfae 100%);
            box-shadow: 0 2px 8px #3ac79b33;
            border: 2.5px solid #fff;
        }

        .pembiayaan-card .progress {
            height: 7px;
            border-radius: 8px;
            background: #e0e0e0;
            margin-top: 8px;
            margin-bottom: 0;
            overflow: hidden;
        }

        .pembiayaan-card .progress-bar {
            background: linear-gradient(90deg, #3ac79b, #00bfae 90%);
        }

        .pembiayaan-card .badge {
            border-radius: 8px;
            font-size: 0.92em;
            padding: 4px 10px;
            font-weight: 600;
            box-shadow: 0 1px 4px #e0f7fa55;
            letter-spacing: 0.5px;
        }

        .pembiayaan-card .badge-lunas {
            background: #3ac79b;
            color: #fff;
        }

        .pembiayaan-card .badge-belum {
            background: #ff5252;
            color: #fff;
        }

        .pembiayaan-card .icon-status {
            font-size: 1.2em;
            margin-right: 4px;
            vertical-align: middle;
        }

        .pembiayaan-card .sisa {
            color: #ff9800;
            font-weight: 700;
        }

        .pembiayaan-card .total {
            color: #3ac79b;
            font-weight: 700;
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
    <div id="content-section">
        <div class="row mb-2" style="margin-top: 70px">
            <div class="col">
                <a href="{{ route('pembiayaan.createmobile') }}" class="btn btn-primary w-100">
                    <ion-icon name="document-outline"></ion-icon>
                    Ajukan Pembiayaan</a>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="transactions">

                    @foreach ($pembiayaan as $d)
                        @php
                            $jumlah_pembiayaan = $d->jumlah + $d->jumlah * ($d->persentase / 100);
                            $total_bayar = $d->jmlbayar ?? 0;
                            $sisa = $jumlah_pembiayaan - $total_bayar;
                            $isLunas = $total_bayar >= $jumlah_pembiayaan;
                            $progress =
                                $jumlah_pembiayaan > 0 ? min(100, round(($total_bayar / $jumlah_pembiayaan) * 100)) : 0;
                        @endphp
                        <a href="{{ route('pembiayaan.showdetail', Crypt::encrypt($d->no_akad)) }}" class="pembiayaan-card"
                            style="position:relative;">
                            @if (isset($d->status))
                                @if ($d->status == '1')
                                    <span style="position:absolute;top:10px;right:14px;z-index:2;"
                                        class="badge badge-success" title="Disetujui">
                                        <ion-icon name="checkmark-circle-outline"
                                            style="vertical-align:middle;font-size:1.1em;"></ion-icon> Disetujui
                                    </span>
                                @else
                                    <span style="position:absolute;top:10px;right:14px;z-index:2;"
                                        class="badge badge-warning" title="Belum Disetujui">
                                        <ion-icon name="time-outline"
                                            style="vertical-align:middle;font-size:1.1em;"></ion-icon> Belum Disetujui
                                    </span>
                                @endif
                            @endif

                            <div style="flex:1; min-width:0;">
                                <div style="flex:1; min-width:0;">
                                    <div
                                        style="font-size:1.08em; font-weight:700; color:#222; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; margin-bottom:2px;">
                                        {{ DateToIndo($d->tanggal) }} <span
                                            style="font-size:0.93em; color:#888; font-weight:400;">({{ $d->jenis_pembiayaan }})</span>
                                    </div>
                                    <div
                                        style="font-size:0.99em; color:#555; margin-bottom:2px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                        {{ $d->keperluan }}
                                    </div>
                                    <div
                                        style="display:flex; gap:8px; align-items:center; flex-wrap:wrap; margin-bottom:2px;">
                                        <span class="total">Total: Rp{{ formatAngka($jumlah_pembiayaan) }}</span>
                                        <span class="sisa">Sisa: <b>Rp{{ formatAngka($sisa) }}</b></span>
                                        @if ($isLunas)
                                            <span class="badge badge-lunas" title="Sudah Lunas"><ion-icon
                                                    name="checkmark-done-outline"
                                                    class="icon-status"></ion-icon>LUNAS</span>
                                        @else
                                            <span class="badge badge-belum" title="Belum Lunas"><ion-icon
                                                    name="alert-circle-outline" class="icon-status"></ion-icon>BELUM
                                                LUNAS</span>
                                        @endif
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%;"
                                            aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                            <div style="margin-left:14px;">
                                <i class="fa fa-chevron-right" style="color:#bbb; font-size:1.2em;"></i>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

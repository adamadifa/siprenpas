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
    <div id="content-section">
        <div class="row mb-2" style="margin-top: 70px">
            <div class="col">
                <a href="{{route('pembiayaan.createmobile')}}" class="btn btn-primary w-100">
                    <ion-icon name="document-outline"></ion-icon>
                    Ajukan Pembiayaan</a>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="transactions">
                    <!-- item -->
                    @foreach ($pembiayaan as $d)
                        <a href="{{ route('pembiayaan.showdetail', Crypt::encrypt($d->no_akad)) }}" class="item">
                            <div class="detail">
                                <div class="avatar avatar-sm me-4"><span class="avatar-initial rounded-circle bg-success">
                                        PB
                                    </span></div>
                                <div>
                                    <strong>{{ DateToIndo($d->tanggal) }}</strong>
                                    <p>{{ $d->keperluan }} ({{ $d->jenis_pembiayaan }})</p>
                                </div>
                            </div>
                            <div class="right">
                                <div class="price">
                                    @php
                                        $jumlah_pembiayaan = $d->jumlah + $d->jumlah * ($d->persentase / 100);
                                    @endphp
                                    {{ formatAngka($jumlah_pembiayaan) }}
                                </div>
                                <div class="status">
                                    @if ($d->jmlbayar == $jumlah_pembiayaan)
                                        <span class="badge bg-success">LUNAS</span>
                                    @else
                                        <span class="badge bg-danger">BELUM LUNAS</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
@endsection

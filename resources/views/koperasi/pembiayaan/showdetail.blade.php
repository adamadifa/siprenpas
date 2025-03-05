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
        <div class="row" style="margin-top: 70px">
            <div class="col">
                <table class="table">
                    <tr>
                        <th>No. Akad</th>
                        <td class="text-right">{{ $pembiayaan->no_akad }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal</th>
                        <td class="text-right">{{ DateToIndo($pembiayaan->tanggal) }}</td>
                    </tr>

                    <tr>
                        <th>Jumlah</th>
                        <td class="text-right">{{ formatAngka($pembiayaan->jumlah) }}</td>
                    </tr>
                    <tr>
                        <th>Jenis Pembiayaan</th>
                        <td class="text-right">{{ $pembiayaan->jenis_pembiayaan }}</td>
                    </tr>
                    <tr>
                        <th>Persentase</th>
                        <td class="text-right">{{ $pembiayaan->persentase }} %</td>
                    </tr>
                    <tr>
                        @php
                            $jumlah_pembiayaan = $pembiayaan->jumlah + ($pembiayaan->persentase / 100) * $pembiayaan->jumlah;
                        @endphp
                        <th>Total</th>
                        <td class="text-right">{{ formatAngka($jumlah_pembiayaan) }}</td>
                    </tr>
                    <tr>
                        <th>Jml Bayar</th>
                        <td class="text-right">{{ formatAngka($pembiayaan->jmlbayar) }}</td>
                    </tr>
                    <tr></tr>
                    <th>Sisa</th>
                    <td class="text-right">{{ formatAngka($jumlah_pembiayaan - $pembiayaan->jmlbayar) }}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Jatuh Tempo</th>
                            <th>Jumlah</th>
                            <th>Bayar</th>
                            <th>Sisa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rencanapembiayaan as $d)
                            @php
                                $jatuhtempo = $d->tahun . '-' . $d->bulan . '-05';
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ date('d/m/y', strtotime($jatuhtempo)) }}</td>
                                <td class="text-end">{{ formatAngka($d->jumlah) }}</td>
                                <td class="text-end">{{ formatAngka($d->bayar) }}</td>
                                <td class="text-end">{{ formatAngka($d->jumlah - $d->bayar) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

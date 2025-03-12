@extends('layouts.mobile.app')
@section('content')
    <style>
        #section-user {
            display: flex;
            align-items: center;
            gap: 10px
        }

        #user-info {
            margin-left: 0px !important;
            line-height: 2px;
        }

        #user-info h3 {
            color: var(--bg-indicator);
        }

        #user-info span {
            color: var(--color-nav);
        }

        #header {
            height: 100px;
            padding: 0px 20px 0px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        #section-card {
            padding: 0px 20px 0px 20px;
        }

        .swiper-slide {
            width: 85% !important;
        }

        .logout-btn {
            color: var(--bg-indicator);
            font-size: 30px;
            text-decoration: none;
        }

        .logout-btn:hover {
            color: var(--color-nav-hover);

        }

        .transactions {
            padding-right: 10px;
            padding-left: 10px;
            padding-bottom: 100px;
            /* background-color: red; */
            height: 50vh;
            /* background-color: red; */
            overflow: scroll;
        }

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
    </style>
    <div id="header">
        <div id="section-user">
            <div class="avatar">
                <img src="{{ asset('assets/template/img/sample/avatar/avatar1.jpg') }}" alt="avatar" class="imaged w32 rounded">
            </div>
            <div id="user-info">
                <h3 id="user-name">{{ $karyawan->nama_lengkap }}👋</h3>
                <span id="user-role">{{ $karyawan->nama_jabatan }}</span>
                <span id="user-role">({{ $karyawan->nama_unit }})</span>
            </div>
        </div>
        <div id="section-logout">
            <a href="/proseslogout" class="logout-btn">
                <ion-icon name="exit-outline"></ion-icon>
            </a>
        </div>
    </div>
    <div id="#section-card">
        <div class="row">
            <div class="col">
                <div class="card dark-bg">
                    <img src="{{ asset('assets/template/img/tsarwah.png') }}" alt="" class="imaged"
                        style="position: absolute; top:75px; right:30px; width: 55px">
                    <div class="row mt-3 mr-3">
                        <div class=" col align-self-center text-right">
                            <p class="text-uppercase mb-3" style="font-size: 16px;line-height: 0px">Validity</p>
                            <p class="text-white" style="font-size: 14px; line-height: 0px">Unlimited</p>
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col text-center">
                            <h1 class="text-white mb-2" style="line-height: 0px">
                                {{ formatAngka($saldosimpanan->total_saldo) }}
                            </h1>
                            <h3 class="mb-0 text-white">
                                {{ $saldosimpanan->no_anggota }}
                            </h3>
                            <span class="text-white mt-5" style="font-size: 18px">
                                SIMPANAN KOPERASI
                            </span>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col align-self-center text-center">
                            <h4 class="text-white">KOPONTREN TSARWAH AL AMIN</h4>
                        </div>
                    </div>

                </div>
                <div class="row mt-3">
                    <div class="col">
                        <div
                            class="swiper-container cardswiper swiper-container-initialized swiper-container-horizontal swiper-container-ios swiper-container-pointer-events">
                            <div class="swiper-wrapper" id="swiper-wrapper-e7c52537e6cf4732" aria-live="polite"
                                style="transform: translate3d(0px, 0px, 0px); transition-duration: 0ms;">
                                @foreach ($saldo_simpanan as $s)
                                    <div class="swiper-slide {{ $loop->first ? 'swiper-slide-active' : '' }}" role="group"
                                        aria-label="{{ $loop->index }} / {{ count($saldo_simpanan) }} }}">
                                        <a href="{{ route('simpanan.mutasi', Crypt::encrypt($s->kode_simpanan)) }}">
                                            <div class="card theme-radial-gradient">
                                                <div class="card-body p-0">
                                                    <div class="row pl-2 pr-2 pt-2">
                                                        <div class="col-auto align-self-center">
                                                            <img src="{{ asset('assets/template/img/masterocard.png') }}" alt="">
                                                        </div>
                                                        <div class=" col align-self-center text-right">
                                                            <p class="small">
                                                                <span class="text-uppercase text-white" style="font-size: 14px">Validity</span><br>
                                                                <span class="text-white" style="font-size: 14px">Unlimited</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="row ml-2">
                                                        <div class="col-12">
                                                            <h2 class="fw-normal mb-1 text-white">
                                                                {{ formatAngka($s->jumlah) }}
                                                                <span class="text-white" style="font-size: 24px">Rp</span>
                                                            </h2>
                                                            <p class="mb-0 text-white" style="font-size: 14px">
                                                                {{ $s->kode_simpanan }}</p>
                                                            <p class="text-white" style="font-size: 16px;">{{ $s->jenis_simpanan }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <h4 style="padding: 3px 20px">5 Transaksi Terakhir</h4>
    <div class="transactions">
        <!-- item -->

        @foreach ($mutasi as $d)
            <a href="#" class="item">
                <div class="detail">
                    <div class="avatar avatar-sm me-4"><span
                            class="avatar-initial rounded-circle {{ $d->jenis_transaksi == 'S' ? 'bg-success' : 'bg-danger' }}">
                            {{ $d->jenis_transaksi == 'S' ? 'S' : 'T' }}
                        </span></div>
                    <div>
                        <strong>{{ DateToIndo($d->tanggal) }}</strong>
                        <p>{{ $d->jenis_transaksi == 'S' ? 'Setoran' : 'Penarikan' }} {{ $d->jenis_simpanan }}</p>
                    </div>
                </div>
                <div class="right">
                    <div class="price {{ $d->jenis_transaksi == 'S' ? 'text-success' : 'text-dangger' }}"> {{ $d->jenis_transaksi == 'S' ? '+' : '-' }}
                        {{ formatAngka($d->jumlah) }}</div>
                </div>
            </a>
        @endforeach

    </div>
@endsection

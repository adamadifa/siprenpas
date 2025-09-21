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
            padding: 0px 10px;
            height: calc(100vh - 300px);
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

        /* Credit Card Style */
        .credit-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            padding: 25px 25px 35px 25px;
            color: white;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            aspect-ratio: 16/10;
            min-height: 240px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .credit-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .card-chip {
            width: 40px;
            height: 30px;
            background: linear-gradient(45deg, #ffd700, #ffed4e);
            border-radius: 6px;
            position: relative;
            margin-bottom: 20px;
        }

        .card-chip::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 20px;
            height: 15px;
            background: linear-gradient(45deg, #c0c0c0, #e8e8e8);
            border-radius: 3px;
        }

        .card-number {
            font-family: 'Courier New', monospace;
            font-size: 18px;
            letter-spacing: 3px;
            margin: 15px 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .card-holder {
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }

        .card-type {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .card-validity {
            position: absolute;
            bottom: 20px;
            right: 20px;
            text-align: right;
        }

        .validity-label {
            font-size: 8px;
            opacity: 0.8;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .validity-value {
            font-size: 12px;
            font-weight: bold;
        }

        .card-balance {
            font-size: 24px;
            font-weight: bold;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            margin: 10px 0;
        }

        .card-account {
            font-size: 12px;
            opacity: 0.9;
            margin-bottom: 5px;
        }

        .swiper-container {
            padding: 10px 0;
        }

        .swiper-slide {
            padding: 0 5px;
        }
    </style>

    <div id="header">
        <div id="section-user">
            <div class="avatar">
                <img src="{{ asset('assets/template/img/sample/avatar/avatar1.jpg') }}" alt="avatar"
                    class="imaged w32 rounded">
            </div>
            <div id="user-info">
                <h3 id="user-name">{{ $siswa->nama_lengkap }}👋</h3>
                <span id="user-role">{{ $siswa->nis ?? 'Siswa' }}</span>
                <span id="user-role">({{ $siswa->kelas ?? 'Kelas' }})</span>
            </div>
        </div>
        <div id="section-logout">
            <a href="/proseslogout" class="logout-btn">
                <ion-icon name="exit-outline"></ion-icon>
            </a>
        </div>
    </div>

    <div id="section-card">
        <div class="row">
            <div class="col">
                <!-- Summary Card -->
                <div class="credit-card mb-3">
                    <div class="card-type">TABUNGAN SANTRI</div>
                    <div class="card-chip"></div>
                    <div class="card-balance">
                        {{ formatRupiah($data['total_saldo']) }}
                    </div>
                    <div class="card-account">
                        Total Saldo dari {{ $data['jumlah_rekening'] }} Rekening
                    </div>
                    <div class="card-validity">
                        <div class="validity-label">Valid Until</div>
                        <div class="validity-value">Unlimited</div>
                    </div>
                </div>

                <!-- Individual Tabungan Cards -->
                <div class="row mt-1">
                    <div class="col">
                        <div class="swiper-container cardswiper">
                            <div class="swiper-wrapper">
                                @foreach ($data['tabungan'] as $tabungan)
                                    <div class="swiper-slide {{ $loop->first ? 'swiper-slide-active' : '' }}" role="group"
                                        aria-label="{{ $loop->index }} / {{ count($data['tabungan']) }}">
                                        <a href="{{ route('tabungan.mutasi', Crypt::encrypt($tabungan['no_rekening'])) }}">
                                            <div class="credit-card"
                                                style="background: linear-gradient(135deg, {{ $loop->index % 2 == 0 ? '#667eea 0%, #764ba2 100%' : '#f093fb 0%, #f5576c 100%' }});">
                                                <div class="card-type">{{ $tabungan['jenis_tabungan']['jenis_tabungan'] }}
                                                </div>
                                                <div class="card-chip"></div>
                                                <div class="card-number">
                                                    {{ str_pad(substr($tabungan['no_rekening'], -4), 16, '*', STR_PAD_LEFT) }}
                                                </div>
                                                <div class="card-holder">{{ $tabungan['anggota']['nama_lengkap'] }}</div>
                                                <div class="card-balance">
                                                    {{ formatRupiah($tabungan['saldo']) }}
                                                </div>
                                                <div class="card-account">
                                                    {{ $tabungan['no_rekening'] }}
                                                </div>
                                                <div class="card-validity">
                                                    <div class="validity-label">Valid Until</div>
                                                    <div class="validity-value">Unlimited</div>
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
        @if (isset($transaksi) && count($transaksi) > 0)
            @foreach ($transaksi as $d)
                <a href="#" class="item">
                    <div class="detail">
                        <div class="avatar avatar-sm me-4">
                            <span
                                class="avatar-initial rounded-circle {{ $d['jenis_transaksi'] == 'S' ? 'bg-success' : 'bg-danger' }}">
                                {{ $d['jenis_transaksi'] == 'S' ? 'S' : 'T' }}
                            </span>
                        </div>
                        <div>
                            <strong>{{ DateToIndo($d['tanggal']) }}</strong>
                            <p>{{ $d['jenis_transaksi'] == 'S' ? 'Setoran' : 'Penarikan' }}
                                {{ $d['jenis_tabungan'] ?? '' }}</p>
                        </div>
                    </div>
                    <div class="right">
                        <div class="price {{ $d['jenis_transaksi'] == 'S' ? 'text-success' : 'text-danger' }}">
                            {{ $d['jenis_transaksi'] == 'S' ? '+' : '-' }}
                            {{ formatRupiah($d['jumlah']) }}
                        </div>
                    </div>
                </a>
            @endforeach
        @else
            <div class="text-center text-muted py-4">
                <p>Tidak ada transaksi terbaru</p>
            </div>
        @endif
    </div>
@endsection

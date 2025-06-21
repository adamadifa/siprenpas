@extends('layouts.mobile.app')
@section('content')
    <style>
        :root {
            --bg-body: #dff9fb;
            --bg-nav: #ffffff;
            --color-nav: #32745e;
            --color-nav-active: #58907D;
            --bg-indicator: #32745e;
            --color-nav-hover: #3ab58c;
        }








        #section-user {
            margin-top: 50px;
            display: flex;
            justify-content: space-between
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

        #section-presensi {
            margin-top: 15px;
        }

        #presensi-today {
            display: flex;
            justify-content: space-between
        }

        #presensi-today h4 {
            color: #32745e;
            font-weight: bold;
            margin: 0
        }

        #presensi-today #presensi-text {
            color: #12855f;
        }

        #presensi-data {
            display: flex;
            justify-content: space-around
        }

        #presensi-icon {
            font-size: 30px;
            margin-right: 10px;
        }


        #rekap-section {

            margin-top: 50px;
            padding: 20px;
            position: relative;
        }

        #rekap-section #title {
            color: var(--bg-indicator);
        }

        #histori-section {
            padding: 0px 20px;
            position: relative;
        }

        #app-section {
            margin-top: 110px;
            margin-bottom: 0px !important;
            padding: 20px 20px 5px 20px;
            position: relative;
        }


        #app-section2 {
            margin-top: 0;
            padding: 0px 20px 20px 20px;
        }

        #app-section #title {
            color: var(--bg-indicator);
        }

        .iconpresence {
            color: #32745e
        }

        #jam {
            color: var(--bg-indicator);
            font-weight: bold;
            font-size: 48px;

        }

        #section-logout {
            position: absolute;
            right: 15px;
            top: 15px;
        }

        .logout-btn {
            color: var(--bg-indicator);
            font-size: 30px;
            text-decoration: none;
        }

        .logout-btn:hover {
            color: var(--color-nav-hover);

        }

        #header-section {
            height: 180px;
            padding: 20px;
            position: relative;
        }
    </style>
    <div id="header-section">
        <div id="section-logout">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="#" class="logout-btn"
                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                    <ion-icon name="exit-outline"></ion-icon>
                </a>
            </form>
        </div>
        <div id="section-user">
            <div id="user-info">
                <h3 id="user-name">{{ $karyawan->nama_lengkap }}👋</h3>
                <span id="user-role">{{ $karyawan->nama_jabatan }}</span>
                <span id="user-role">({{ $karyawan->nama_unit }})</span>

            </div>
            <div class="avatar">
                <img src="{{ asset('assets/template/img/sample/avatar/avatar1.jpg') }}" alt="avatar"
                    class="imaged w64 rounded">
            </div>
        </div>
        <div id="section-jam " class="text-center mt-1">
            <h2 id="jam" style="text-shadow: 0px 0px 2px #04ab86b7; line-height: 1rem"></h2>
            <span>Hari ini : {{ getNamaHari(date('D')) }}, {{ DateToIndo(date('Y-m-d')) }}</span>
        </div>
        <div id="section-presensi">
            <div class="card">
                <div class="card-body" id="presensi-today">
                    <div id="presensi-data">
                        <div id="presensi-icon">
                            @php
                                $jam_in = $presensi && $presensi->jam_in != null ? $presensi->jam_in : null;
                            @endphp
                            @if ($presensi && $presensi->foto_in != null)
                                @php
                                    $path = Storage::url('uploads/absensi/' . $presensi->foto_in);
                                @endphp
                                <img src="{{ url($path) }}" alt="" class="imaged w48">
                            @else
                                <ion-icon name="camera"></ion-icon>
                            @endif
                        </div>
                        <div id="presensi-detail">
                            <h4>Jam Masuk</h4>
                            <span class="presensi-text">
                                @if ($jam_in != null)
                                    {{ date('H:i', strtotime($jam_in)) }}
                                @else
                                    <ion-icon name="hourglass-outline"></ion-icon> Belum Absen
                                @endif
                            </span>
                        </div>

                    </div>
                    <div class="outer">
                        <div class="inner"></div>
                    </div>
                    <div id="presensi-data">
                        <div id="presensi-icon">
                            @php
                                $jam_out = $presensi && $presensi->jam_out != null ? $presensi->jam_out : null;
                            @endphp
                            @if ($presensi && $presensi->foto_out != null)
                                @php
                                    $path = Storage::url('uploads/absensi/' . $presensi->foto_out);
                                @endphp
                                <img src="{{ url($path) }}" alt="" class="imaged w48">
                            @else
                                <ion-icon name="camera"></ion-icon>
                            @endif
                        </div>
                        <div id="presensi-detail">
                            <h4>Jam Pulang</h4>
                            <span class="presensi-text">
                                @if ($jam_out != null)
                                    {{ date('H:i', strtotime($jam_out)) }}
                                @else
                                    <ion-icon name="hourglass-outline"></ion-icon> Belum Absen
                                @endif
                            </span>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="app-section">
        <div class="row">
            <div class="col-3">
                <div class="card">
                    <div class="card-body text-center" style="padding: 5px 5px !important; line-height:0.8rem">
                        <img src="{{ asset('assets/template/img/3d/hadir.webp') }}" alt="" style="width: 50px"
                            class="mb-1">
                        <br>
                        <span style="font-size: 0.8rem; font-weight:500">
                            Hadir
                        </span>
                        <span class="badge bg-success" style="position: absolute; top: 5px; right: 5px">
                            {{ $rekappresensi ? $rekappresensi->hadir : 0 }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card">
                    <div class="card-body text-center" style="padding: 5px 5px !important; line-height:0.8rem">
                        <img src="{{ asset('assets/template/img/3d/sakit.png') }}" alt="" style="width: 50px"
                            class="mb-1">
                        <br>
                        <span style="font-size: 0.8rem; font-weight:500">Sakit</span>
                        <span class="badge bg-success" style="position: absolute; top: 5px; right: 5px">
                            {{ $rekappresensi ? $rekappresensi->sakit : 0 }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card">
                    <div class="card-body text-center" style="padding: 5px 5px !important; line-height:0.8rem">
                        <img src="{{ asset('assets/template/img/3d/izin.webp') }}" alt="" style="width: 50px"
                            class="mb-1">
                        <br>
                        <span style="font-size: 0.8rem; font-weight:500">Izin</span>
                        <span class="badge bg-success" style="position: absolute; top: 5px; right: 5px">
                            {{ $rekappresensi ? $rekappresensi->izin : 0 }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card">
                    <div class="card-body text-center" style="padding: 5px 5px !important; line-height:0.8rem">
                        <img src="{{ asset('assets/template/img/3d/cuti.png') }}" alt="" style="width: 50px"
                            class="mb-1">
                        <br>
                        <span style="font-size: 0.8rem; font-weight:500">Cuti</span>
                        <span class="badge bg-success" style="position: absolute; top: 5px; right: 5px">
                            {{ $rekappresensi ? $rekappresensi->cuti : 0 }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="app-section2">
        <div class="row">
            <div class="col-3">
                <a href="{{ route('checklistibadah.create') }}">
                    <div class="card">
                        <div class="card-body text-center" style="padding: 5px 5px !important; line-height:0.8rem">
                            <img src="{{ asset('assets/template/img/3d/prayingman64.png') }}" alt=""
                                style="width: 50px" class="mb-1">
                            <br>
                            <span style="font-size: 0.8rem; font-weight:500">
                                Ibadah
                            </span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-3">
                <a href="{{ route('simpanan.showmobile', Crypt::encrypt($karyawan->npp)) }}">
                    {{-- {{ $karyawan->nik }} --}}
                    <div class="card">
                        <div class="card-body text-center" style="padding: 5px 5px !important; line-height:0.8rem">
                            <img src="{{ asset('assets/template/img/3d/simpanan.png') }}" alt=""
                                style="width: 50px" class="mb-1">
                            <br>
                            <span style="font-size: 0.8rem; font-weight:500">Simpanan</span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-3">
                <a href="{{ route('pembiayaan.showmobile', Crypt::encrypt($karyawan->npp)) }}">
                    <div class="card">
                        <div class="card-body text-center" style="padding: 5px 5px !important; line-height:0.8rem">
                            <img src="{{ asset('assets/template/img/3d/pinjaman.png') }}" alt=""
                                style="width: 50px" class="mb-1">
                            <br>
                            <span style="font-size: 0.8rem; font-weight:500">Pinjaman</span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-3">
                <a href="{{ route('tabungan.showmobile', Crypt::encrypt($karyawan->npp)) }}">
                    <div class="card">
                        <div class="card-body text-center" style="padding: 5px 5px !important; line-height:0.8rem">
                            <img src="{{ asset('assets/template/img/3d/slipgaji.png') }}" alt=""
                                style="width: 50px" class="mb-1">
                            <br>
                            <span style="font-size: 0.8rem; font-weight:500">Tabungan</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div id="histori-section">
        <div class="tab-pane fade show active" id="pilled" role="tabpanel">
            <ul class="nav nav-tabs style1" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#historipresensi" role="tab">
                        30 Hari terakhir
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#profile" role="tab">
                        Lembur
                    </a>
                </li>
            </ul>
        </div>
        <div class="tab-content mt-2" style="margin-bottom:100px;">
            <div class="tab-pane fade show active" id="historipresensi" role="tabpanel">
                <div class="row mb-1">
                    <div class="col">
                        {{-- {{ $d->jam_out != null ? 'historibordergreen' : 'historiborderred' }} --}}
                        @foreach ($datapresensi as $d)
                            @if ($d->status == 'h')
                                @php
                                    $jam_in = date('Y-m-d H:i', strtotime($d->jam_in));
                                    $jam_masuk = date('Y-m-d H:i', strtotime($d->tanggal . ' ' . $d->jam_masuk));
                                @endphp
                                <div class="card historicard historibordergreen mb-1">
                                    <div class="historicontent">
                                        <div class="historidetail1">
                                            <div class="iconpresence">
                                                <ion-icon name="finger-print-outline" style="font-size: 48px"></ion-icon>
                                            </div>
                                            <div class="datepresence">
                                                <h4>{{ DateToIndo($d->tanggal) }}</h4>
                                                <span class="timepresence">
                                                    @if ($d->jam_in != null)
                                                        {{ date('H:i', strtotime($d->jam_in)) }}
                                                    @else
                                                        <ion-icon name="hourglass-outline"></ion-icon> Belum Absen
                                                    @endif
                                                    -
                                                    @if ($d->jam_out != null)
                                                        {{ date('H:i', strtotime($d->jam_out)) }}
                                                    @else
                                                        <span class="text-danger">
                                                            <ion-icon name="hourglass-outline"></ion-icon> Belum Absen
                                                        </span>
                                                    @endif
                                                </span>
                                                <br>
                                                @if ($d->jam_in != null)
                                                    @php
                                                        $terlambat = hitungjamterlambat(
                                                            date('H:i', strtotime($jam_in)),
                                                            date('H:i', strtotime($jam_masuk)),
                                                        );

                                                    @endphp
                                                    @if (!empty($terlambat))
                                                        @if ($terlambat['menitterlambat'] > 0)
                                                        <span style="color:red">Terlambat {!! $terlambat['show'] !!} </span>
                                                        <br>
                                                        @php
                                                            $menit_terlambat = $terlambat['menitterlambat'];
                                                            $denda = hitungdenda(
                                                                $menit_terlambat,
                                                                $karyawan->status_karyawan,
                                                            );
                                                        @endphp
                                                        <span style="color:red">Denda: {{ formatAngka($denda) }}</span>
                                                        @else
                                                        <span style="color:green">Tepat Waktu</span>
                                                        @endif
                                                    @endif
                                                @endif


                                            </div>
                                        </div>
                                        <div class="historidetail2">
                                            <h4>REGULER</h4>
                                            <span class="timepresence">
                                                {{ date('H:i', strtotime($d->jam_masuk)) }} -
                                                {{ date('H:i', strtotime($d->jam_pulang)) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @elseif($d->status == 'i')
                                <div class="card historicard historibordergreen mb-1">
                                    <div class="historicontent">
                                        <div class="historidetail1">
                                            <div class="iconpresence">
                                                <ion-icon name="document-text-outline"
                                                    style="font-size: 48px; color: #1f7ee4"></ion-icon>
                                            </div>
                                            <div class="datepresence">
                                                <h4>{{ DateToIndo($d->tanggal) }}</h4>
                                                <h4 class="timepresence">
                                                    Izin Absen
                                                </h4>
                                                <span>{{ $d->keterangan_izin }}</span>
                                            </div>
                                        </div>
                                        <div class="historidetail2">
                                            <h4>REGULER</h4>
                                            <span class="timepresence">
                                                {{ date('H:i', strtotime($d->jam_masuk)) }} -
                                                {{ date('H:i', strtotime($d->jam_pulang)) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @elseif($d->status == 's')
                                <div class="card historicard historibordergreen mb-1">
                                    <div class="historicontent">
                                        <div class="historidetail1">
                                            <div class="iconpresence">
                                                <ion-icon name="bag-add-outline"
                                                    style="font-size: 48px; color: #d4095a"></ion-icon>
                                            </div>
                                            <div class="datepresence">
                                                <h4>{{ DateToIndo($d->tanggal) }}</h4>
                                                <h4 class="timepresence">
                                                    Izin Sakit
                                                </h4>
                                                <span>{{ $d->keterangan_sakit }}</span>
                                            </div>
                                        </div>
                                        <div class="historidetail2">
                                            <h4>REGULER</h4>
                                            <span class="timepresence">
                                                {{ date('H:i', strtotime($d->jam_masuk)) }} -
                                                {{ date('H:i', strtotime($d->jam_pulang)) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('myscript')
    <script type="text/javascript">
        window.onload = function() {
            jam();
        }

        function jam() {
            var e = document.getElementById('jam'),
                d = new Date(),
                h, m, s;
            h = d.getHours();
            m = set(d.getMinutes());
            s = set(d.getSeconds());

            e.innerHTML = h + ':' + m + ':' + s;

            setTimeout('jam()', 1000);
        }

        function set(e) {
            e = e < 10 ? '0' + e : e;
            return e;
        }
    </script>
@endpush

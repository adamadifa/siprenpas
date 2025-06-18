@extends('layouts.app')
@section('titlepage', 'Monitoring Presensi')

@section('content')
@section('navigasi')
    <span>Monitoring Presensi</span>
@endsection
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-header">
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <form action="{{ route('presensi.index') }}">
                            <x-input-with-icon label="Tanggal" value="{{ Request('tanggal') }}" name="tanggal"
                                icon="ti ti-calendar" datepicker="flatpickr-date" />
                            <div class="row">
                                <div class="col-lg-12 col-sm-12 col-md-12">
                                    <x-select label="Unit" name="kode_unit" :data="$unit" key="kode_unit"
                                        textShow="nama_unit" selected="{{ Request('kode_unit') }}" upperCase="true"
                                        select2="select2Kodeunit" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-sm-12 col-md-12">
                                    <x-input-with-icon label="Cari Nama Karyawan" value="{{ Request('nama_karyawan') }}"
                                        name="nama_karyawan" icon="ti ti-search" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <button class="btn btn-primary w-100"><i
                                            class="ti ti-icons ti-search me-1"></i>Cari</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive mb-2">
                            <table class="table table-bordered table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>NPP</th>
                                        <th>Nama Karyawan</th>
                                        <th>Jabatan</th>
                                        <th>Unit</th>
                                        <th class="text-center">Jam Kerja</th>
                                        <th class="text-center">Jam Masuk</th>
                                        <th class="text-center">Jam Pulang</th>
                                        <th class="text-center">Status</th>
                                        {{-- <th class="text-center">Keluar</th> --}}
                                        <th class="text-center">Terlambat</th>
                                        <th>Denda</th>
                                        {{-- <th class="text-center">Total</th> --}}
                                        <th class="text-center">#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($karyawan as $d)
                                        @php
                                            $tanggal_presensi = !empty(Request('tanggal'))
                                                ? Request('tanggal')
                                                : date('Y-m-d');
                                        @endphp
                                        <tr>
                                            <td>{{ $d->npp }}</td>
                                            <td>{{ $d->nama_lengkap }}</td>
                                            <td>{{ $d->nama_jabatan }}</td>
                                            <td>{{ $d->nama_unit }}</td>
                                            <td class="text-center">
                                                @if ($d->kode_jam_kerja != null)
                                                    {{ $d->nama_jam_kerja }} {{ date('H:i', strtotime($d->jam_masuk)) }}
                                                    -
                                                    {{ date('H:i', strtotime($d->jam_pulang)) }}
                                                @else
                                                    <i class="ti ti-hourglass-low text-warning"></i>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($d->jam_in != null)
                                                    <a href="#" class="btnShowpresensi_in"
                                                        id="{{ $d->id }}" status="in">
                                                        {{ date('H:i', strtotime($d->jam_in)) }}
                                                    </a>
                                                @else
                                                    <i class="ti ti-hourglass-low text-warning"></i>
                                                @endif

                                            </td>
                                            <td class="text-center">
                                                @if ($d->jam_out != null)
                                                    <a href="#" class="btnShowpresensi_in"
                                                        id="{{ $d->id }}" status="out">
                                                        {{ date('H:i', strtotime($d->jam_out)) }}
                                                    </a>
                                                @else
                                                    <i class="ti ti-hourglass-low text-warning"></i>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($d->status == 'h')
                                                    <span class="badge bg-success">H</span>
                                                @elseif($d->status == 'i')
                                                    <span class="badge bg-info">I</span>
                                                @elseif($d->status == 's')
                                                    <span class="badge bg-warning">S</span>
                                                @elseif($d->status == 'a')
                                                    <span class="badge bg-danger">A</span>
                                                @else
                                                    <i class="ti ti-hourglass-low text-warning"></i>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @php
                                                    $jam_masuk = $tanggal_presensi . ' ' . $d->jam_masuk;
                                                    $terlambat = hitungjamterlambat($d->jam_in, $jam_masuk);
                                                @endphp
                                                {!! $terlambat != null ? $terlambat['show'] : '<i class="ti ti-hourglass-low text-warning"></i>' !!}
                                            </td>
                                            <td class="text-end text-danger">
                                                @php
                                                    $menit_terlambat =
                                                        $terlambat != null ? $terlambat['menitterlambat'] : 0;
                                                    $denda = hitungdenda($menit_terlambat, $d->status_karyawan);
                                                @endphp
                                                {{ formatAngka($denda) }}
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="#" class="me-1 koreksiPresensi"
                                                        npp="{{ Crypt::encrypt($d->npp) }}"
                                                        tanggal="{{ $tanggal_presensi }}"><i
                                                            class="ti ti-edit text-success"></i> </a>

                                                    <a href="#" class="btngetDatamesin" pin="{{ $d->pin }}"
                                                        tanggal="{{ !empty(Request('tanggal')) ? Request('tanggal') : date('Y-m-d') }}">
                                                        <i class="ti ti-device-desktop text-primary"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <div style="float: right;">
                            {{ $karyawan->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<x-modal-form id="modal" size="modal-lg" show="loadmodal" title="" />
@endsection
@push('myscript')
<script>
    $(document).on('click', '.koreksiPresensi', function(e) {
        e.preventDefault();
        let npp = $(this).attr('npp');
        let tanggal = $(this).attr('tanggal');
        $.ajax({
            type: 'POST',
            url: "{{ route('presensi.edit') }}",
            data: {
                _token: "{{ csrf_token() }}",
                npp: npp,
                tanggal: tanggal
            },
            cache: false,
            success: function(res) {
                $('#modal').modal('show');
                $('#modal').find('.modal-title').text('Koreksi Presensi');
                $('#loadmodal').html(res);
            }
        });
    });
    $(".btnShowpresensi_in, .btnShowpresensi_out").click(function(e) {
        e.preventDefault();
        const id = $(this).attr("id");
        const status = $(this).attr("status");
        $("#loadmodal").html(`<div class="sk-wave sk-primary" style="margin:auto">
        <div class="sk-wave-rect"></div>
        <div class="sk-wave-rect"></div>
        <div class="sk-wave-rect"></div>
        <div class="sk-wave-rect"></div>
        <div class="sk-wave-rect"></div>
      </div>`);
        //alert(kode_jadwal);
        $("#modal").modal("show");
        $(".modal-title").text("Data Presensi");
        $("#loadmodal").load(`/presensi/${id}/${status}/show`);
    });

    $(".btngetDatamesin").click(function(e) {
        e.preventDefault();
        var pin = $(this).attr("pin");
        var tanggal = $(this).attr("tanggal");
        // var kode_jadwal = $(this).attr("kode_jadwal");
        $("#loadmodal").html(`<div class="sk-wave sk-primary" style="margin:auto">
            <div class="sk-wave-rect"></div>
            <div class="sk-wave-rect"></div>
            <div class="sk-wave-rect"></div>
            <div class="sk-wave-rect"></div>
            <div class="sk-wave-rect"></div>
        </div>`);
        //alert(kode_jadwal);
        $("#modal").modal("show");
        $(".modal-title").text("Get Data Mesin");
        $.ajax({
            type: 'POST',
            url: '/presensi/getdatamesin',
            data: {
                _token: "{{ csrf_token() }}",
                pin: pin,
                tanggal: tanggal,
                // kode_jadwal: kode_jadwal
            },
            cache: false,
            success: function(respond) {
                console.log(respond);
                $("#loadmodal").html(respond);
            }
        });
    });
</script>
@endpush
{{-- @push('myscript')
<script>
    $(function() {
        $(document).on('click', '.koreksiPresensi', function() {
            let nik = $(this).attr('nik');
            let tanggal = $(this).attr('tanggal');
            $.ajax({
                type: 'POST',
                url: "{{ route('presensi.edit') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    nik: nik,
                    tanggal: tanggal
                },
                cache: false,
                success: function(res) {
                    $('#modal').modal('show');
                    $('#modal').find('.modal-title').text('Koreksi Presensi');
                    $('#loadmodal').html(res);
                }
            });
        });


        $(document).on('click', '.btnShow', function() {
            let nik = $(this).attr('nik');
            let tanggal = $(this).attr('tanggal');
            $.ajax({
                type: 'POST',
                url: "{{ route('presensi.show') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    nik: nik,
                    tanggal: tanggal
                },
                cache: false,
                success: function(res) {
                    $('#modal').modal('show');
                    $('#modal').find('.modal-title').text('Detail Presensi');
                    $('#loadmodal').html(res);
                }
            });
        });
    });
</script>
@endpush --}}

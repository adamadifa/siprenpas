@extends('layouts.app')
@section('titlepage', 'Pendaftaran Online')

@section('content')
@section('navigasi')
    <span>Pendaftaran Online</span>
@endsection
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="card">

            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <form action="{{ route('pendaftaranonline.index') }}">
                            <div class="row">
                                <div class="col-lg-4 col-sm-12 col-md-12">
                                    <x-input-with-icon label="Cari Nama Siswa" value="{{ Request('nama_lengkap') }}"
                                        name="nama_lengkap" icon="ti ti-search" />
                                </div>
                                <div class="col-lg-4 col-sm-12 col-md-12">
                                    <div class="form-group mb-3">
                                        <select name="kode_unit" id="kode_unit_search" class="form-select">
                                            <option value="">Semua Unit</option>
                                            @foreach ($unit as $d)
                                                <option value="{{ $d->kode_unit }}"
                                                    {{ Request('kode_unit') == $d->kode_unit ? 'selected' : '' }}>
                                                    {{ $d->nama_unit }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-12 col-md-12">
                                    <div class="form-group mb-3">
                                        <select name="kode_ta" id="kode_ta_search" class="form-select">
                                            <option value="">Tahun Ajaran</option>
                                            @foreach ($tahunajaran as $d)
                                                <option value="{{ $d->kode_ta }}"
                                                    {{ Request('kode_ta') == $d->kode_ta ? 'selected' : '' }}>
                                                    {{ $d->tahun_ajaran }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-12 col-md-12">
                                    <button class="btn btn-primary">Cari</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive mb-2">
                            <table class="table table-striped table-hover table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No.</th>
                                        <th>No. Register</th>
                                        <th>Tanggal</th>
                                        <th>Nama Lengkap</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Unit</th>
                                        <th>TA</th>
                                        <th>Status</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pendaftaran as $d)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $d->no_register }}</td>
                                            <td>{{ date('d-m-Y', strtotime($d->tanggal_register)) }}</td>
                                            <td>{{ $d->nama_lengkap }}</td>
                                            <td>{{ !empty($d->tanggal_lahir) ? DateToIndo($d->tanggal_lahir) : '' }}
                                            </td>
                                            <td>{{ !empty($d->jenis_kelamin) ? $jenis_kelamin[$d->jenis_kelamin] : '' }}
                                            </td>
                                            <td>{{ $d->nama_unit }}</td>
                                            <td>{{ $d->tahun_ajaran }}</td>
                                            <td>
                                                @if (!empty($d->id_bayar))
                                                    @if ($d->status_bayar == 1)
                                                        <span class="badge bg-success">Sudah Bayar</span>
                                                    @else
                                                        <span class="badge bg-warning">Sudah Konfirmasi</span>
                                                    @endif
                                                @else
                                                    <span class="badge bg-danger">Belum Bayar</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    @can('pendaftaranonline.edit')
                                                        <a href="#"
                                                            no_register="{{ Crypt::encrypt($d->no_register) }}"
                                                            class="btnEdit me-1">
                                                            <i class="ti ti-edit text-success"></i>
                                                        </a>
                                                    @endcan
                                                    @can('pendaftaranonline.show')
                                                        <a href="#" class="me-2 btnShow"
                                                            no_register="{{ Crypt::encrypt($d->no_register) }}">
                                                            <i class="ti ti-file-description text-info"></i>
                                                        </a>
                                                    @endcan
                                                    @can('pendaftaranonline.delete')
                                                        <form method="POST" name="deleteform" class="deleteform"
                                                            action="/pendaftaranonline/{{ Crypt::encrypt($d->no_register) }}/delete">
                                                            @csrf
                                                            @method('DELETE')
                                                            <a href="#" class="delete-confirm me-1">
                                                                <i class="ti ti-trash text-danger"></i>
                                                            </a>
                                                        </form>
                                                    @endcan

                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div style="float: right;">
                            {{-- {{ $siswa->links() }} --}}
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
    $(function() {
        $(document).on('show.bs.modal', '.modal', function() {
            const zIndex = 1090 + 10 * $('.modal:visible').length;
            $(this).css('z-index', zIndex);
            setTimeout(() => $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1)
                .addClass('modal-stack'));
        });

        const loading = `<div class="sk-wave sk-primary" style="margin:auto">
            <div class="sk-wave-rect"></div>
            <div class="sk-wave-rect"></div>
            <div class="sk-wave-rect"></div>
            <div class="sk-wave-rect"></div>
            <div class="sk-wave-rect"></div>
            </div>`;

        $(".btnEdit").click(function(e) {
            e.preventDefault();
            const no_register = $(this).attr("no_register");
            $("#modal").modal("show");
            $("#modal").find("#loadmodal").html(loading);
            $("#modal").find(".modal-title").text("Edit Pendaftaran ");
            $("#loadmodal").load(`/pendaftaranonline/${no_register}/edit`);
        });



        $(".btnShow").click(function(e) {
            e.preventDefault();
            const no_register = $(this).attr("no_register");
            $("#modal").modal("show");
            $("#modal").find("#loadmodal").html(loading);
            $("#modal").find(".modal-title").text("");
            $("#loadmodal").load(`/pendaftaranonline/${no_register}/show`);
        });
    });
</script>
@endpush

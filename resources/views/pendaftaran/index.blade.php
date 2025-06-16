@extends('layouts.app')
@section('titlepage', 'Pendaftaran')

@section('content')
@section('navigasi')
    <span>Pendaftaran</span>
@endsection
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <style>
            .rekap-card-green {
                background: linear-gradient(135deg, #1B5E20 0%, #0A3D0A 100%) !important;
                color: #fff !important;
                border: none;
            }
            .rekap-card-green .card-body,
            .rekap-card-green .fs-4,
            .rekap-card-green .display-6,
            .rekap-card-green .small {
                color: #fff !important;
            }
        </style>
        <div class="mb-3">
            <div class="mb-2 fw-bold fs-5">Rekap Jumlah Siswa per Unit</div>
            <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-3">
                @forelse ($rekap_unit as $r)
                    <div class="col">
                        <div class="card h-100 text-center @if($r->jumlah == 0) border-secondary bg-light text-muted @else rekap-card-green @endif">
                            <div class="card-body">
                                <div class="fs-4 fw-bold mb-1">{{ $r->nama_unit }}</div>
                                <div class="display-6 fw-bold mb-1">{{ $r->jumlah }}</div>
                                <div class="small">Siswa</div>
                                @if($r->jumlah == 0)
                                    <div class="badge bg-secondary mt-2">Belum ada siswa</div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col">
                        <div class="alert alert-warning">Tidak ada data unit.</div>
                    </div>
                @endforelse
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                @can('pendaftaran.create')
                    <a href="#" class="btn btn-primary" id="btnCreate"><i class="fa fa-plus me-2"></i> Tambah
                        Pendaftaran</a>
                @endcan
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <form action="{{ route('pendaftaran.index') }}">
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
                                        <th>No. Pendaftaran</th>
                                        <th>ID Siswa</th>
                                        <th>NISN</th>
                                        <th>NIS</th>
                                        <th>Nama Lengkap</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Unit</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pendaftaran as $d)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $d->no_pendaftaran }}</td>
                                            <td>{{ $d->id_siswa }}</td>
                                            <td>{{ $d->nisn }}</td>
                                            <td>{{ $d->nis }}</td>
                                            <td>{{ $d->nama_lengkap }}</td>
                                            <td>{{ !empty($d->tanggal_lahir) ? DateToIndo($d->tanggal_lahir) : '' }}
                                            </td>
                                            <td>{{ !empty($d->jenis_kelamin) ? $jenis_kelamin[$d->jenis_kelamin] : '' }}
                                            </td>
                                            <td>{{ $d->nama_unit }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    @can('pendaftaran.edit')
                                                        <a href="#"
                                                            no_pendaftaran="{{ Crypt::encrypt($d->no_pendaftaran) }}"
                                                            class="btnEdit me-1">
                                                            <i class="ti ti-edit text-success"></i>
                                                        </a>
                                                    @endcan
                                                    @can('pendaftaran.show')
                                                        <a href="#" class="me-2 btnShow"
                                                            no_pendaftaran="{{ Crypt::encrypt($d->no_pendaftaran) }}">
                                                            <i class="ti ti-file-description text-info"></i>
                                                        </a>
                                                    @endcan
                                                    @can('pendaftaran.delete')
                                                        <form method="POST" name="deleteform" class="deleteform"
                                                            action="/pendaftaran/{{ Crypt::encrypt($d->no_pendaftaran) }}/delete">
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
<x-modal-form id="modalSekolah" size="" show="loadmodal" title="" />
<div class="modal fade" id="modalSiswa" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel18">Data Siswa</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered" id="tabelsiswa">
                    <thead class="table-dark">
                        <tr>
                            <th>ID Siswa</th>
                            <th>Nama Lengkap</th>
                            <th>Jenis Kelamin</th>
                            <th>Tahun Masuk</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
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

        $("#btnCreate").click(function(e) {
            e.preventDefault();
            const tahun_ajaran = "{{ $tahun_ajaran->tahun_ajaran }}";
            $("#modal").modal("show");
            $("#modal").find("#loadmodal").html(loading);
            $("#modal").find(".modal-title").text("Pendaftaran Tahun Ajaran " + tahun_ajaran);
            $("#loadmodal").load(`/pendaftaran/create`);
        });

        $(".btnEdit").click(function(e) {
            e.preventDefault();
            const no_pendaftaran = $(this).attr("no_pendaftaran");
            $("#modal").modal("show");
            $("#modal").find("#loadmodal").html(loading);
            $("#modal").find(".modal-title").text("Edit Pendaftaran ");
            $("#loadmodal").load(`/pendaftaran/${no_pendaftaran}/edit`);
        });



        $(".btnShow").click(function(e) {
            e.preventDefault();
            const no_pendaftaran = $(this).attr("no_pendaftaran");
            $("#modal").modal("show");
            $("#modal").find("#loadmodal").html(loading);
            $("#modal").find(".modal-title").text("");
            $("#loadmodal").load(`/pendaftaran/${no_pendaftaran}/show`);
        });

        $('#tabelsiswa').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ url()->current() }}', // memanggil route yang menampilkan data json
            columns: [{ // mengambil & menampilkan kolom sesuai tabel database
                    data: 'id_siswa',
                    name: 'id_siswa'
                },
                {
                    data: 'nama_lengkap',
                    name: 'nama_lengkap'
                },
                {
                    data: 'jenis_kelamin',
                    name: 'jenis_kelamin'
                },
                {
                    data: 'tahun_masuk',
                    name: 'tahun_masuk'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ]
        });
    });
</script>
@endpush

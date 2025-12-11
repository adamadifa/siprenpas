@extends('layouts.app')
@section('titlepage', 'Pendaftaran Got Talent')

@section('content')
@section('navigasi')
    <span>Pendaftaran Got Talent</span>
@endsection

<style>
    .lomba-stat-card {
        border-radius: 0.75rem;
        border: none;
        transition: all 0.3s ease;
        cursor: pointer;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .lomba-stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.12);
    }

    .lomba-stat-card.has-peserta {
        background: linear-gradient(135deg, #1B5E20 0%, #0A3D0A 100%);
        color: #fff;
    }

    .lomba-stat-card.no-peserta {
        background: linear-gradient(135deg, #dc3545 0%, #b02a37 100%);
        color: #fff;
    }

    .lomba-stat-card .card-body {
        padding: 1.25rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .lomba-stat-content {
        flex: 1;
    }

    .lomba-stat-title {
        font-size: 0.75rem;
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
        opacity: 0.9;
    }

    .lomba-stat-number {
        font-size: 2rem;
        font-weight: 700;
        line-height: 1;
        margin-bottom: 0.25rem;
    }

    .lomba-stat-info {
        font-size: 0.75rem;
        opacity: 0.8;
        display: flex;
        align-items: center;
        gap: 0.25rem;
        margin-top: 0.5rem;
    }

    .lomba-stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        flex-shrink: 0;
    }

    .lomba-stat-card.has-peserta .lomba-stat-icon {
        background: rgba(255, 255, 255, 0.2);
        color: #fff;
    }

    .lomba-stat-card.no-peserta .lomba-stat-icon {
        background: rgba(255, 255, 255, 0.2);
        color: #fff;
    }

    .lomba-stat-card.no-peserta .lomba-stat-title,
    .lomba-stat-card.no-peserta .lomba-stat-number,
    .lomba-stat-card.no-peserta .lomba-stat-info {
        color: #fff;
    }
</style>

<!-- Statistik Cards -->
<div class="mb-3">
    <div class="mb-2 fw-bold fs-5">
        <i class="ti ti-trophy me-2"></i>Statistik Peserta per Lomba
    </div>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-3">
        @forelse ($statistikLomba as $stat)
            <div class="col">
                <div class="card lomba-stat-card @if ($stat->jumlah_peserta == 0) no-peserta @else has-peserta @endif detail-lomba-card"
                    data-id-lomba="{{ $stat->id }}" data-nama-lomba="{{ $stat->jenis_perlombaan }}" data-jenjang="{{ $stat->jenjang_pendidikan }}">
                    <div class="card-body">
                        <div class="lomba-stat-content">
                            <div class="lomba-stat-title">{{ $stat->jenis_perlombaan }}</div>
                            <div class="lomba-stat-number">{{ $stat->jumlah_peserta }}</div>
                            <div class="lomba-stat-info">
                                <i class="ti ti-school"></i>
                                <span>{{ $stat->jenjang_pendidikan }}</span>
                            </div>
                        </div>
                        <div class="lomba-stat-icon">
                            @if ($stat->jumlah_peserta == 0)
                                <i class="ti ti-users-off"></i>
                            @else
                                <i class="ti ti-trophy"></i>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="ti ti-info-circle me-2"></i>Belum ada data lomba
                </div>
            </div>
        @endforelse
    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                @can('pendaftarangottalent.create')
                    <a href="#" class="btn btn-primary" id="btncreatePendaftaranGotTalent"><i class="fa fa-plus me-2"></i>
                        Tambah
                        Pendaftaran</a>
                @endcan
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <form action="{{ route('pendaftarangottalent.index') }}">
                            <div class="row">
                                <div class="col-lg-4 col-sm-12 col-md-12">
                                    <x-input-with-icon label="Nomor Register" value="{{ Request('nomor_register_search') }}"
                                        name="nomor_register_search" icon="ti ti-search" />
                                </div>
                                <div class="col-lg-4 col-sm-12 col-md-12">
                                    <x-input-with-icon label="Nama Lengkap" value="{{ Request('nama_lengkap_search') }}" name="nama_lengkap_search"
                                        icon="ti ti-search" />
                                </div>
                                <div class="col-lg-3 col-sm-12 col-md-12">
                                    <select name="id_jenjang_search" id="id_jenjang_search" class="form-select">
                                        <option value="">Jenjang Pendidikan</option>
                                        @foreach ($jenjangPendidikan as $d)
                                            <option value="{{ $d->id }}" {{ Request('id_jenjang_search') == $d->id ? 'selected' : '' }}>
                                                {{ $d->jenjang_pendidikan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-1 col-sm-12 col-md-12">
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
                                        <th>Nomor Register</th>
                                        <th>Nama Lengkap</th>
                                        <th>Jenjang Pendidikan</th>
                                        <th>Asal Sekolah</th>
                                        <th>No. HP</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pendaftaranGotTalent as $d)
                                        <tr>
                                            <td class="text-center">
                                                {{ $loop->iteration }}
                                            </td>
                                            <td>{{ $d->nomor_register }}</td>
                                            <td>{{ $d->nama_lengkap }}</td>
                                            <td>{{ $d->jenjangPendidikan->jenjang_pendidikan ?? '-' }}</td>
                                            <td>{{ $d->asal_sekolah ?? '-' }}</td>
                                            <td>{{ $d->no_hp ?? '-' }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    @can('pendaftarangottalent.index')
                                                        <div>
                                                            <a href="#" class="me-2 showDetailPendaftaranGotTalent"
                                                                id_pendaftaran="{{ Crypt::encrypt($d->id) }}">
                                                                <i class="ti ti-info-circle text-info" title="Detail Peserta & Lomba"></i>
                                                            </a>
                                                        </div>
                                                        <div>
                                                            <a href="{{ route('pendaftarangottalent.show', Crypt::encrypt($d->id)) }}" class="me-2">
                                                                <i class="ti ti-eye text-primary" title="Lihat Detail"></i>
                                                            </a>
                                                        </div>
                                                    @endcan

                                                    @can('pendaftarangottalent.edit')
                                                        <div>
                                                            <a href="#" class="me-2 editPendaftaranGotTalent"
                                                                id_pendaftaran="{{ Crypt::encrypt($d->id) }}">
                                                                <i class="ti ti-edit text-success" title="Edit"></i>
                                                            </a>
                                                        </div>
                                                    @endcan

                                                    @can('pendaftarangottalent.index')
                                                        @if (empty($d->id_user))
                                                            <div>
                                                                <a href="{{ route('pendaftarangottalent.createuser', Crypt::encrypt($d->id)) }}"
                                                                    class="me-2" title="Buat User Peserta">
                                                                    <i class="ti ti-user-plus text-warning"></i>
                                                                </a>
                                                            </div>
                                                        @else
                                                            <div>
                                                                <i class="ti ti-user text-success me-2" title="User sudah dibuat"></i>
                                                            </div>
                                                        @endif
                                                    @endcan

                                                    @can('pendaftarangottalent.delete')
                                                        <div>
                                                            <form method="POST" name="deleteform" class="deleteform"
                                                                action="{{ route('pendaftarangottalent.delete', Crypt::encrypt($d->id)) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <a href="#" class="delete-confirm ml-1">
                                                                    <i class="ti ti-trash text-danger" title="Hapus"></i>
                                                                </a>
                                                            </form>
                                                        </div>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<x-modal-form id="mdlcreatePendaftaranGotTalent" size="" show="loadcreatePendaftaranGotTalent" title="Tambah Pendaftaran Got Talent" />
<x-modal-form id="mdleditPendaftaranGotTalent" size="" show="loadeditPendaftaranGotTalent" title="Edit Pendaftaran Got Talent" />
<x-modal-form id="mdlshowDetailPendaftaranGotTalent" size="modal-xl" show="loadshowDetailPendaftaranGotTalent" title="Detail Peserta & Lomba" />
<x-modal-form id="mdlDetailPesertaLomba" size="modal-xl" show="loadDetailPesertaLomba" title="Detail Peserta Lomba" />
@endsection
@push('myscript')
<script>
    $(function() {
        $("#btncreatePendaftaranGotTalent").click(function(e) {
            e.preventDefault();
            $('#mdlcreatePendaftaranGotTalent').modal("show");
            $("#loadcreatePendaftaranGotTalent").load("{{ route('pendaftarangottalent.create') }}");
        });

        $(".editPendaftaranGotTalent").click(function(e) {
            var id_pendaftaran = $(this).attr("id_pendaftaran");
            e.preventDefault();
            $('#mdleditPendaftaranGotTalent').modal("show");
            $("#loadeditPendaftaranGotTalent").load("{{ url('/pendaftaran-got-talent') }}/" + id_pendaftaran + "/edit");
        });

        $(".showDetailPendaftaranGotTalent").click(function(e) {
            var id_pendaftaran = $(this).attr("id_pendaftaran");
            e.preventDefault();
            $('#mdlshowDetailPendaftaranGotTalent').modal("show");
            $("#loadshowDetailPendaftaranGotTalent").load("{{ url('/pendaftaran-got-talent') }}/" + id_pendaftaran + "/show");
        });

        // Handle klik pada card lomba untuk menampilkan detail peserta
        $(".detail-lomba-card").click(function(e) {
            e.preventDefault();
            var id_lomba = $(this).data("id-lomba");
            var nama_lomba = $(this).data("nama-lomba");
            var jenjang = $(this).data("jenjang");

            $('#mdlDetailPesertaLomba .modal-title').text('Detail Peserta - ' + nama_lomba + ' (' + jenjang + ')');
            $('#mdlDetailPesertaLomba').modal("show");

            $("#loadDetailPesertaLomba").html(`
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2 text-muted">Memuat data...</p>
                </div>
            `);

            $("#loadDetailPesertaLomba").load("{{ url('/pendaftaran-got-talent/detail-lomba') }}/" + id_lomba);
        });
    });
</script>
@endpush

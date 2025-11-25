@extends('layouts.app')
@section('titlepage', 'Perlombaan')

@section('content')
@section('navigasi')
    <span>Perlombaan</span>
@endsection
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                @can('perlombaan.create')
                    <a href="#" class="btn btn-primary" id="btncreatePerlombaan"><i class="fa fa-plus me-2"></i> Tambah
                        Perlombaan</a>
                @endcan
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <form action="{{ route('perlombaan.index') }}">
                            <div class="row">
                                <div class="col-lg-4 col-sm-12 col-md-12 mb-2">
                                    <x-input-with-icon label="Jenis Perlombaan"
                                        value="{{ Request('jenis_perlombaan_search') }}" name="jenis_perlombaan_search"
                                        icon="ti ti-search" />
                                </div>
                                <div class="col-lg-4 col-sm-12 col-md-12 mb-2">
                                    <select name="id_jenjang_search" id="id_jenjang_search" class="form-select">
                                        <option value="">Jenjang Pendidikan</option>
                                        @foreach ($jenjangPendidikan as $d)
                                            <option value="{{ $d->id }}"
                                                {{ Request('id_jenjang_search') == $d->id ? 'selected' : '' }}>
                                                {{ $d->jenjang_pendidikan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-2 col-sm-12 col-md-12 mb-2">
                                    <button class="btn btn-primary w-100">Cari</button>
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
                                        <th>Thumbnail</th>
                                        <th>Jenis Perlombaan</th>
                                        <th>Jenjang Pendidikan</th>
                                        <th>Biaya Pendaftaran</th>
                                        <th>Contact Person</th>
                                        <th>Juknis & Juklak</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($perlombaan as $d)
                                        <tr>
                                            <td class="text-center">
                                                {{ $loop->iteration }}
                                            </td>
                                            <td class="text-center">
                                                @if ($d->thumbnail)
                                                    <img src="{{ asset('storage/' . $d->thumbnail) }}" alt="Thumbnail" class="img-thumbnail" style="max-width: 80px; max-height: 80px; object-fit: cover;">
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>{{ $d->jenis_perlombaan }}</td>
                                            <td>{{ $d->jenjangPendidikan->jenjang_pendidikan ?? '-' }}</td>
                                            <td class="text-end">
                                                @if (!is_null($d->biaya_pendaftaran))
                                                    Rp {{ formatRupiah($d->biaya_pendaftaran) }}
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>{{ $d->contact_person ?? '-' }}</td>
                                            <td>
                                                @if ($d->juknis_juklak)
                                                    <a href="{{ asset('storage/' . $d->juknis_juklak) }}" target="_blank" class="btn btn-sm btn-info">
                                                        <i class="ti ti-download me-1"></i>Download
                                                    </a>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    @can('perlombaan.edit')
                                                        <div>
                                                            <a href="#" class="me-2 editPerlombaan"
                                                                id_perlombaan="{{ Crypt::encrypt($d->id) }}">
                                                                <i class="ti ti-edit text-success"></i>
                                                            </a>
                                                        </div>
                                                    @endcan

                                                    @can('perlombaan.delete')
                                                        <div>
                                                            <form method="POST" name="deleteform" class="deleteform"
                                                                action="{{ route('perlombaan.delete', Crypt::encrypt($d->id)) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <a href="#" class="delete-confirm ml-1">
                                                                    <i class="ti ti-trash text-danger"></i>
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
<x-modal-form id="mdlcreatePerlombaan" size="" show="loadcreatePerlombaan" title="Tambah Perlombaan" />
<x-modal-form id="mdleditPerlombaan" size="" show="loadeditPerlombaan" title="Edit Perlombaan" />
@endsection
@push('myscript')
<script>
    $(function() {
        $("#btncreatePerlombaan").click(function(e) {
            e.preventDefault();
            $('#mdlcreatePerlombaan').modal("show");
            $("#loadcreatePerlombaan").load('/perlombaan/create');
        });

        $(".editPerlombaan").click(function(e) {
            var id_perlombaan = $(this).attr("id_perlombaan");
            e.preventDefault();
            $('#mdleditPerlombaan').modal("show");
            $("#loadeditPerlombaan").load('/perlombaan/' + id_perlombaan + '/edit');
        });
    });
</script>
@endpush

@extends('layouts.app')
@section('titlepage', 'Detail Anggota Koperasi')

@section('content')
@section('navigasi')
    <span>Anggota Koperasi</span>
@endsection

<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('anggota.index') }}" class="btn btn-secondary">
                    <i class="ti ti-arrow-left me-2"></i> Kembali
                </a>
                @can('anggota.edit')
                    <a href="#" class="btn btn-primary btnEditAnggota ms-2"
                        no_anggota="{{ Crypt::encrypt($anggota->no_anggota) }}">
                        <i class="ti ti-edit me-2"></i> Edit
                    </a>
                @endcan
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <div class="divider text-start mb-3">
                            <div class="divider-text">
                                <i class="ti ti-user"></i> Data Anggota
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="40%">No. Anggota</th>
                                    <td><strong>{{ $anggota->no_anggota }}</strong></td>
                                </tr>
                                <tr>
                                    <th>NIK</th>
                                    <td>{{ $anggota->nik ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Lengkap</th>
                                    <td>{{ $anggota->nama_lengkap ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Tempat, Tanggal Lahir</th>
                                    <td>
                                        {{ $anggota->tempat_lahir ?? '-' }},
                                        {{ $anggota->tanggal_lahir ? date('d-m-Y', strtotime($anggota->tanggal_lahir)) : '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Jenis Kelamin</th>
                                    <td>
                                        @if($anggota->jenis_kelamin == 'L')
                                            Laki - Laki
                                        @elseif($anggota->jenis_kelamin == 'P')
                                            Perempuan
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Pendidikan Terakhir</th>
                                    <td>{{ $anggota->pendidikan_terakhir ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Status Pernikahan</th>
                                    <td>
                                        @if($anggota->status_pernikahan == 'M')
                                            Menikah
                                        @elseif($anggota->status_pernikahan == 'BM')
                                            Belum Menikah
                                        @elseif($anggota->status_pernikahan == 'JD')
                                            Janda/Duda
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Jumlah Tanggungan</th>
                                    <td>{{ $anggota->jml_tanggungan ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Pasangan</th>
                                    <td>{{ $anggota->nama_pasangan ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Pekerjaan Pasangan</th>
                                    <td>{{ $anggota->pekerjaan_pasangan ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Ibu</th>
                                    <td>{{ $anggota->nama_ibu ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Saudara</th>
                                    <td>{{ $anggota->nama_saudara ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>No. HP</th>
                                    <td>{{ $anggota->no_hp ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <div class="divider text-start mb-3">
                            <div class="divider-text">
                                <i class="ti ti-map-pin"></i> Data Alamat
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="40%">Alamat</th>
                                    <td>{{ $anggota->alamat ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Provinsi</th>
                                    <td>{{ $anggota->nama_provinsi ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Kabupaten / Kota</th>
                                    <td>{{ $anggota->nama_kabupaten ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Kecamatan</th>
                                    <td>{{ $anggota->nama_kecamatan ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Desa / Kelurahan</th>
                                    <td>{{ $anggota->nama_desa ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Kode Pos</th>
                                    <td>{{ $anggota->kode_pos ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Status Tinggal</th>
                                    <td>
                                        @if($anggota->status_tinggal == 'MS')
                                            Milik Sendiri
                                        @elseif($anggota->status_tinggal == 'MK')
                                            Milik Keluarga
                                        @elseif($anggota->status_tinggal == 'SK')
                                            Sewa / Kontrak
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-lg-12">
                        <div class="divider text-start mb-3">
                            <div class="divider-text">
                                <i class="ti ti-users"></i> Siswa Terkait
                            </div>
                        </div>
                        @if($anggota->siswa && $anggota->siswa->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>ID Siswa</th>
                                            <th>Nama Lengkap</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($anggota->siswa as $index => $siswa)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td>{{ $siswa->id_siswa ?? '-' }}</td>
                                                <td>{{ $siswa->nama_lengkap ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info">
                                <i class="ti ti-info-circle me-2"></i>
                                Belum ada siswa yang terhubung dengan anggota ini.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<x-modal-form id="mdlAnggota" size="modal-lg" show="loadmodalAnggota" title="" />

@endsection

@push('myscript')
<script>
    $(function() {
        $(".btnEditAnggota").click(function(e) {
            var no_anggota = $(this).attr("no_anggota");
            e.preventDefault();
            $('#mdlAnggota').modal("show");
            $("#loadmodalAnggota").html(`<div class="sk-wave sk-primary" style="margin:auto">
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                </div>`);
            $("#modalAnggota").find(".modal-title").text("Edit Anggota Koperasi");
            $("#loadmodalAnggota").load('/anggota/' + no_anggota + '/edit');
        });
    });
</script>
@endpush


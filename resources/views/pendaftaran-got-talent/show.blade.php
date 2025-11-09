@extends('layouts.app')
@section('titlepage', 'Detail Pendaftaran Got Talent')

@section('content')
@section('navigasi')
    <span>Pendaftaran Got Talent</span>
@endsection
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('pendaftaran-got-talent.index') }}" class="btn btn-secondary">
                    <i class="ti ti-arrow-left me-2"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <table class="table table-bordered">
                            <tr>
                                <th width="40%">Nomor Register</th>
                                <td>{{ $pendaftaranGotTalent->nomor_register }}</td>
                            </tr>
                            <tr>
                                <th>Nama Lengkap</th>
                                <td>{{ $pendaftaranGotTalent->nama_lengkap }}</td>
                            </tr>
                            <tr>
                                <th>Jenjang Pendidikan</th>
                                <td>{{ $pendaftaranGotTalent->jenjangPendidikan->jenjang_pendidikan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Asal Sekolah</th>
                                <td>{{ $pendaftaranGotTalent->asal_sekolah ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Alamat Sekolah</th>
                                <td>{{ $pendaftaranGotTalent->alamat_sekolah ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Alamat Rumah</th>
                                <td>{{ $pendaftaranGotTalent->alamat_rumah ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Daftar</th>
                                <td>{{ $pendaftaranGotTalent->created_at ? date('d-m-Y H:i:s', strtotime($pendaftaranGotTalent->created_at)) : '-' }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                @if ($pendaftaranGotTalent->perlombaan && $pendaftaranGotTalent->perlombaan->count() > 0)
                    <div class="row mt-3">
                        <div class="col-12">
                            <h5>Perlombaan yang Diikuti</h5>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>No.</th>
                                            <th>Jenis Perlombaan</th>
                                            <th>Jenjang Pendidikan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pendaftaranGotTalent->perlombaan as $perlombaan)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td>{{ $perlombaan->jenis_perlombaan }}</td>
                                                <td>{{ $perlombaan->jenjangPendidikan->jenjang_pendidikan ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection


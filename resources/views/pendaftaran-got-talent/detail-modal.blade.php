<div class="row">
    <div class="col-lg-12">
        <h5 class="mb-3"><i class="ti ti-user me-2"></i>Data Peserta</h5>
        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    <th width="30%">Nomor Register</th>
                    <td><strong>{{ $pendaftaranGotTalent->nomor_register }}</strong></td>
                </tr>
                <tr>
                    <th>Nama Lengkap</th>
                    <td>{{ $pendaftaranGotTalent->nama_lengkap }}</td>
                </tr>
                <tr>
                    <th>Tempat Lahir</th>
                    <td>{{ $pendaftaranGotTalent->tempat_lahir ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Tanggal Lahir</th>
                    <td>{{ $pendaftaranGotTalent->tanggal_lahir ? date('d-m-Y', strtotime($pendaftaranGotTalent->tanggal_lahir)) : '-' }}</td>
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
                    <th>No. HP</th>
                    <td>{{ $pendaftaranGotTalent->no_hp ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $pendaftaranGotTalent->email ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Tanggal Daftar</th>
                    <td>{{ $pendaftaranGotTalent->created_at ? date('d-m-Y H:i:s', strtotime($pendaftaranGotTalent->created_at)) : '-' }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>

@if ($pendaftaranGotTalent->perlombaan && $pendaftaranGotTalent->perlombaan->count() > 0)
    <div class="row mt-4">
        <div class="col-lg-12">
            <h5 class="mb-3"><i class="ti ti-trophy me-2"></i>Lomba yang Diikuti</h5>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th width="5%">No.</th>
                            <th>Jenis Perlombaan</th>
                            <th>Jenjang Pendidikan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pendaftaranGotTalent->perlombaan as $perlombaan)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td><strong>{{ $perlombaan->jenis_perlombaan }}</strong></td>
                                <td>{{ $perlombaan->jenjangPendidikan->jenjang_pendidikan ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@else
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="alert alert-warning">
                <i class="ti ti-alert-circle me-2"></i>Belum ada lomba yang dipilih
            </div>
        </div>
    </div>
@endif




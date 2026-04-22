@extends('layouts.app')
@section('titlepage', 'Detail Anggota Koperasi')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-user-search fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Detail Anggota Koperasi</h4>
                        <p class="text-muted mb-0 small">Informasi lengkap dan data profil anggota</p>
                    </div>
                </div>
                <div class="d-flex flex-column align-items-end">
                    <div class="d-flex gap-2">
                        <a href="{{ route('anggota.index') }}" class="btn btn-label-secondary d-flex align-items-center gap-2">
                            <i class="ti ti-arrow-left fs-4"></i>
                            <span>Kembali</span>
                        </a>
                        @can('anggota.edit')
                            <button class="btn btn-primary btnEditAnggota d-flex align-items-center gap-2 shadow-sm"
                                no_anggota="{{ Crypt::encrypt($anggota->no_anggota) }}" style="background-color: #064e3b; border-color: #064e3b">
                                <i class="ti ti-edit fs-4"></i>
                                <span>Edit Profil</span>
                            </button>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="card shadow-sm border-0 overflow-hidden">
            <div class="card-header py-3" style="background-color: #064e3b">
                <div class="d-flex align-items-center gap-2">
                    <i class="ti ti-id-badge text-white fs-4"></i>
                    <h6 class="card-title mb-0 text-white fw-bold text-uppercase">Informasi Profil : {{ $anggota->nama_lengkap }}</h6>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <div class="divider text-start mb-4">
                            <div class="divider-text fw-bold text-primary text-uppercase small">
                                <i class="ti ti-user me-2"></i> Data Pribadi
                            </div>
                        </div>
                        <div class="table-responsive border rounded-3 overflow-hidden">
                            <table class="table table-striped table-hover mb-0">
                                <tr>
                                    <th width="40%" class="bg-light py-2 px-3 fw-bold small text-muted">NOMOR ANGGOTA</th>
                                    <td class="py-2 px-3"><span class="badge bg-label-success fw-bold">{{ $anggota->no_anggota }}</span></td>
                                </tr>
                                <tr>
                                    <th class="bg-light py-2 px-3 fw-bold small text-muted">NOMOR IDENTITAS (NIK)</th>
                                    <td class="py-2 px-3 fw-bold">{{ $anggota->nik ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light py-2 px-3 fw-bold small text-muted">NAMA LENGKAP</th>
                                    <td class="py-2 px-3 text-uppercase fw-bold">{{ $anggota->nama_lengkap ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light py-2 px-3 fw-bold small text-muted">TEMPAT, TANGGAL LAHIR</th>
                                    <td class="py-2 px-3">
                                        <i class="ti ti-calendar me-1 text-muted"></i>
                                        {{ $anggota->tempat_lahir ?? '-' }},
                                        {{ $anggota->tanggal_lahir ? date('d-m-Y', strtotime($anggota->tanggal_lahir)) : '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light py-2 px-3 fw-bold small text-muted">JENIS KELAMIN</th>
                                    <td class="py-2 px-3">
                                        @if($anggota->jenis_kelamin == 'L')
                                            <span class="badge bg-label-primary px-2"><i class="ti ti-gender-male me-1"></i> Laki-Laki</span>
                                        @elseif($anggota->jenis_kelamin == 'P')
                                            <span class="badge bg-label-danger px-2"><i class="ti ti-gender-female me-1"></i> Perempuan</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light py-2 px-3 fw-bold small text-muted">PENDIDIKAN TERAKHIR</th>
                                    <td class="py-2 px-3">{{ $anggota->pendidikan_terakhir ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light py-2 px-3 fw-bold small text-muted">STATUS PERNIKAHAN</th>
                                    <td class="py-2 px-3">
                                        @if($anggota->status_pernikahan == 'M')
                                            Menikah
                                        @elseif($anggota->status_pernikahan == 'BM')
                                            Belum Menikah
                                        @elseif($anggota->status_pernikahan == 'JD')
                                            Janda / Duda
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light py-2 px-3 fw-bold small text-muted">NOMOR HP / WA</th>
                                    <td class="py-2 px-3 text-primary fw-bold">
                                        <i class="ti ti-brand-whatsapp me-1"></i>
                                        {{ $anggota->no_hp ?? '-' }}
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="divider text-start mb-4 mt-4">
                            <div class="divider-text fw-bold text-primary text-uppercase small">
                                <i class="ti ti-heart me-2"></i> Data Keluarga
                            </div>
                        </div>
                        <div class="table-responsive border rounded-3 overflow-hidden">
                            <table class="table table-striped table-hover mb-0">
                                <tr>
                                    <th width="40%" class="bg-light py-2 px-3 fw-bold small text-muted">NAMA PASANGAN</th>
                                    <td class="py-2 px-3 text-uppercase small">{{ $anggota->nama_pasangan ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light py-2 px-3 fw-bold small text-muted">PEKERJAAN PASANGAN</th>
                                    <td class="py-2 px-3 text-uppercase small">{{ $anggota->pekerjaan_pasangan ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light py-2 px-3 fw-bold small text-muted">NAMA IBU KANDUNG</th>
                                    <td class="py-2 px-3 text-uppercase small">{{ $anggota->nama_ibu ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light py-2 px-3 fw-bold small text-muted">NAMA SAUDARA</th>
                                    <td class="py-2 px-3 text-uppercase small">{{ $anggota->nama_saudara ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light py-2 px-3 fw-bold small text-muted">JUMLAH TANGGUNGAN</th>
                                    <td class="py-2 px-3">{{ $anggota->jml_tanggungan ?? '0' }} Jiwa</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <div class="divider text-start mb-4">
                            <div class="divider-text fw-bold text-primary text-uppercase small">
                                <i class="ti ti-map-pin me-2"></i> Data Alamat & Domisili
                            </div>
                        </div>
                        <div class="table-responsive border rounded-3 overflow-hidden">
                            <table class="table table-striped table-hover mb-0">
                                <tr>
                                    <th width="40%" class="bg-light py-2 px-3 fw-bold small text-muted">ALAMAT LENGKAP</th>
                                    <td class="py-2 px-3 small">{{ $anggota->alamat ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light py-2 px-3 fw-bold small text-muted">PROVINSI</th>
                                    <td class="py-2 px-3 text-uppercase small">{{ $anggota->nama_provinsi ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light py-2 px-3 fw-bold small text-muted">KABUPATEN / KOTA</th>
                                    <td class="py-2 px-3 text-uppercase small">{{ $anggota->nama_kabupaten ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light py-2 px-3 fw-bold small text-muted">KECAMATAN</th>
                                    <td class="py-2 px-3 text-uppercase small">{{ $anggota->nama_kecamatan ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light py-2 px-3 fw-bold small text-muted">DESA / KELURAHAN</th>
                                    <td class="py-2 px-3 text-uppercase small">{{ $anggota->nama_desa ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light py-2 px-3 fw-bold small text-muted">KODE POS</th>
                                    <td class="py-2 px-3">{{ $anggota->kode_pos ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light py-2 px-3 fw-bold small text-muted">STATUS TINGGAL</th>
                                    <td class="py-2 px-3">
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

                        <div class="divider text-start mb-4 mt-4">
                            <div class="divider-text fw-bold text-primary text-uppercase small">
                                <i class="ti ti-users me-2"></i> Siswa Terkait
                            </div>
                        </div>
                        @if($anggota->siswa && $anggota->siswa->count() > 0)
                            <div class="table-responsive border rounded-3 overflow-hidden">
                                <table class="table table-hover mb-0">
                                    <thead style="background-color: #064e3b">
                                        <tr>
                                            <th class="text-white py-2 px-3 small" style="width: 50px;">NO</th>
                                            <th class="text-white py-2 px-3 small">ID SISWA</th>
                                            <th class="text-white py-2 px-3 small">NAMA LENGKAP</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($anggota->siswa as $index => $siswa)
                                            <tr>
                                                <td class="text-center py-2 px-3 small fw-bold">{{ $loop->iteration }}</td>
                                                <td class="py-2 px-3 small fw-bold text-primary">{{ $siswa->id_siswa ?? '-' }}</td>
                                                <td class="py-2 px-3 text-uppercase small fw-bold">{{ $siswa->nama_lengkap ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info d-flex align-items-center mb-0 p-3 shadow-none border rounded-3">
                                <i class="ti ti-info-circle me-3 fs-3"></i>
                                <div class="small fw-bold">Belum ada siswa yang terhubung dengan anggota ini.</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<x-modal-form id="mdlAnggota" size="modal-lg" show="loadmodalAnggota" title="Edit Anggota Koperasi" icon="ti ti-users" />
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
            $("#loadmodalAnggota").load('/anggota/' + no_anggota + '/edit');
        });
    });
</script>
@endpush

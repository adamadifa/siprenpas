@extends('layouts.app')
@section('titlepage', 'Detail Konfirmasi Pembayaran Got Talent')

@section('content')
@section('navigasi')
    <span>Konfirmasi Pembayaran Got Talent</span>
@endsection
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('konfirmasi-pembayaran-got-talent.index') }}" class="btn btn-secondary">
                    <i class="ti ti-arrow-left me-1"></i>Kembali
                </a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <h5 class="mb-3">Informasi Pendaftaran</h5>
                        <table class="table table-bordered">
                            <tr>
                                <td style="width: 40%"><strong>Nomor Register</strong></td>
                                <td>{{ $konfirmasi->pendaftaran->nomor_register ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Nama Lengkap</strong></td>
                                <td>{{ $konfirmasi->pendaftaran->nama_lengkap ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Email</strong></td>
                                <td>{{ $konfirmasi->pendaftaran->email ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>No. HP</strong></td>
                                <td>{{ $konfirmasi->pendaftaran->no_hp ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Jenjang Pendidikan</strong></td>
                                <td>{{ $konfirmasi->pendaftaran->jenjangPendidikan->jenjang_pendidikan ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-lg-6">
                        <h5 class="mb-3">Informasi Pembayaran</h5>
                        <table class="table table-bordered">
                            <tr>
                                <td style="width: 40%"><strong>Tanggal Pembayaran</strong></td>
                                <td>{{ DateToIndo($konfirmasi->tanggal_pembayaran) }}</td>
                            </tr>
                            <tr>
                                <td><strong>Jumlah Pembayaran</strong></td>
                                <td class="fw-bold">Rp {{ formatRupiah($konfirmasi->jumlah_pembayaran) }}</td>
                            </tr>
                            <tr>
                                <td><strong>Metode Pembayaran</strong></td>
                                <td>{{ ucfirst($konfirmasi->metode_pembayaran) }}</td>
                            </tr>
                            <tr>
                                <td><strong>Status</strong></td>
                                <td>
                                    @if ($konfirmasi->status == 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif ($konfirmasi->status == 'diverifikasi')
                                        <span class="badge bg-success">Diverifikasi</span>
                                    @else
                                        <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </td>
                            </tr>
                            @if ($konfirmasi->keterangan)
                            <tr>
                                <td><strong>Keterangan</strong></td>
                                <td>{{ $konfirmasi->keterangan }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-lg-6">
                        <h5 class="mb-3">Bukti Pembayaran</h5>
                        @if ($konfirmasi->bukti_pembayaran)
                            <div class="mb-3">
                                <a href="{{ asset('storage/' . $konfirmasi->bukti_pembayaran) }}" target="_blank" class="btn btn-info">
                                    <i class="ti ti-download me-1"></i>Lihat/Download Bukti Pembayaran
                                </a>
                            </div>
                            @if (in_array(strtolower(pathinfo($konfirmasi->bukti_pembayaran, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif']))
                                <img src="{{ asset('storage/' . $konfirmasi->bukti_pembayaran) }}" alt="Bukti Pembayaran" class="img-fluid rounded" style="max-width: 500px;">
                            @endif
                        @else
                            <p class="text-muted">Tidak ada bukti pembayaran</p>
                        @endif
                    </div>
                    <div class="col-lg-6">
                        @if ($konfirmasi->status == 'pending')
                            <h5 class="mb-3">Verifikasi Pembayaran</h5>
                            <form action="{{ route('konfirmasi-pembayaran-got-talent.update-status', Crypt::encrypt($konfirmasi->id)) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" id="status" class="form-select" required>
                                        <option value="diverifikasi">Diverifikasi</option>
                                        <option value="ditolak">Ditolak</option>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">Catatan Admin</label>
                                    <textarea name="catatan_admin" id="catatan_admin" class="form-control" rows="3" placeholder="Masukkan catatan (opsional)"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-check me-1"></i>Update Status
                                </button>
                            </form>
                        @else
                            <h5 class="mb-3">Informasi Verifikasi</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <td style="width: 40%"><strong>Diverifikasi Oleh</strong></td>
                                    <td>{{ $konfirmasi->verifikator->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Diverifikasi Pada</strong></td>
                                    <td>{{ $konfirmasi->diverifikasi_pada ? $konfirmasi->diverifikasi_pada->format('d M Y H:i:s') : '-' }}</td>
                                </tr>
                                @if ($konfirmasi->catatan_admin)
                                <tr>
                                    <td><strong>Catatan Admin</strong></td>
                                    <td>{{ $konfirmasi->catatan_admin }}</td>
                                </tr>
                                @endif
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


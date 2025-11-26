@extends('layouts.app')
@section('titlepage', 'Konfirmasi Pembayaran Got Talent')

@section('content')
@section('navigasi')
    <span>Konfirmasi Pembayaran Got Talent</span>
@endsection
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <form action="{{ route('konfirmasi-pembayaran-got-talent.index') }}">
                            <div class="row">
                                <div class="col-lg-4 col-sm-12 col-md-12 mb-2">
                                    <x-input-with-icon label="Cari (Nama/Email/No. Register)"
                                        value="{{ Request('search') }}" name="search"
                                        icon="ti ti-search" />
                                </div>
                                <div class="col-lg-3 col-sm-12 col-md-12 mb-2">
                                    <select name="status" id="status" class="form-select">
                                        <option value="">Semua Status</option>
                                        <option value="pending" {{ Request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="diverifikasi" {{ Request('status') == 'diverifikasi' ? 'selected' : '' }}>Diverifikasi</option>
                                        <option value="ditolak" {{ Request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
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
                                        <th>Nomor Register</th>
                                        <th>Nama Lengkap</th>
                                        <th>Tanggal Pembayaran</th>
                                        <th>Jumlah</th>
                                        <th>Metode</th>
                                        <th>Status</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($konfirmasi as $d)
                                        <tr>
                                            <td class="text-center">
                                                {{ $loop->iteration + ($konfirmasi->currentPage() - 1) * $konfirmasi->perPage() }}
                                            </td>
                                            <td>{{ $d->pendaftaran->nomor_register ?? '-' }}</td>
                                            <td>{{ $d->pendaftaran->nama_lengkap ?? '-' }}</td>
                                            <td>{{ DateToIndo($d->tanggal_pembayaran) }}</td>
                                            <td class="text-end">Rp {{ formatRupiah($d->jumlah_pembayaran) }}</td>
                                            <td>{{ ucfirst($d->metode_pembayaran) }}</td>
                                            <td>
                                                @if ($d->status == 'pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @elseif ($d->status == 'diverifikasi')
                                                    <span class="badge bg-success">Diverifikasi</span>
                                                @else
                                                    <span class="badge bg-danger">Ditolak</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <div>
                                                        <a href="{{ route('konfirmasi-pembayaran-got-talent.show', Crypt::encrypt($d->id)) }}"
                                                            class="me-2">
                                                            <i class="ti ti-eye text-primary" title="Lihat Detail"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {{ $konfirmasi->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


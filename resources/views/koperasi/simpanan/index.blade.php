@extends('layouts.app')
@section('titlepage', 'Data Simpanan Koperasi')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-wallet fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Data Simpanan</h4>
                        <p class="text-muted mb-0 small">Manajemen data simpanan anggota koperasi</p>
                    </div>
                </div>
                <div class="d-flex flex-column align-items-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mb-0">
                            <li class="breadcrumb-item">
                                <a href="javascript:void(0);" class="text-muted">
                                    <i class="ti ti-building-bank me-1"></i> Koperasi
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                <i class="ti ti-wallet me-1"></i> Simpanan
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

<div class="row">
    <div class="col-lg-12">
        <!-- Filter Form -->
        <div class="card mb-4 shadow-none border-0 bg-transparent">
            <div class="card-body p-0">
                <form action="{{ URL::current() }}">
                    <div class="row g-3 align-items-center">
                        <div class="col-lg-10 col-md-9">
                            <x-input-with-icon label="" value="{{ Request('nama_lengkap') }}" name="nama_lengkap"
                                placeholder="Cari Nama Anggota Koperasi" icon="ti ti-search" />
                        </div>
                        <div class="col-lg-2 col-md-3">
                            <button type="submit" class="btn btn-primary w-100 p-2 d-flex align-items-center justify-content-center gap-2" 
                                style="background-color: #064e3b; border-color: #064e3b">
                                <i class="ti ti-search fs-5"></i>
                                <span>Cari</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header d-flex align-items-center gap-2 text-white py-3" style="background-color: #064e3b">
                <i class="ti ti-layout-grid fs-5"></i>
                <h6 class="card-title mb-0 text-white">Data Anggota Simpanan</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 text-nowrap">
                        <thead style="background-color: #064e3b">
                            <tr>
                                <th class="text-white py-3">NO</th>
                                <th class="text-white py-3">NO. ANGGOTA</th>
                                <th class="text-white py-3">NIK</th>
                                <th class="text-white py-3">NAMA LENGKAP</th>
                                <th class="text-white py-3">TTL</th>
                                <th class="text-white py-3">NO. HP</th>
                                <th class="text-white py-3 text-end">SALDO</th>
                                <th class="text-white py-3 text-center" style="width: 80px;">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($anggota as $d)
                                <tr>
                                    <td class="text-center py-2">{{ $loop->iteration + $anggota->firstItem() - 1 }}</td>
                                    <td class="py-2 text-dark fw-bold">{{ $d->no_anggota }}</td>
                                    <td class="py-2">{{ $d->nik }}</td>
                                    <td class="py-2">
                                        <a href="{{ route('simpanan.show', Crypt::encrypt($d->no_anggota)) }}" class="text-dark fw-bold">
                                            {{ $d->nama_lengkap }}
                                        </a>
                                    </td>
                                    <td class="py-2 small">{{ $d->tempat_lahir }}, {{ $d->tanggal_lahir }}</td>
                                    <td class="py-2">{{ $d->no_hp }}</td>
                                    <td class="py-2 text-end text-success fw-bold">{{ formatAngka($d->jml_saldo) }}</td>
                                    <td class="py-2 text-center">
                                        @can('simpanan.create')
                                            <a href="{{ route('simpanan.show', Crypt::encrypt($d->no_anggota)) }}" 
                                               class="btn btn-icon btn-label-success border"
                                               style="width: 28px; height: 28px;" title="Lihat Simpanan">
                                                <i class="ti ti-book fs-6"></i>
                                            </a>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center p-5">
                                        <div class="mb-3">
                                            <i class="ti ti-folder-off fs-1 opacity-25"></i>
                                        </div>
                                        <h5>Data tidak ditemukan</h5>
                                        <p class="text-muted small">Silahkan sesuaikan filter pencarian anggota.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer py-2">
                <div class="d-flex justify-content-end">
                    {{ $anggota->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
<x-modal-form id="mdlAnggota" size="modal-lg" show="loadmodalAnggota" title="" />
@endsection

@extends('layouts.app')

@section('title', 'Pengaturan Umum')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Pengaturan Umum</h5>
                        @if (!$pengaturan)
                            <a href="{{ route('pengaturan-umum.create') }}" class="btn btn-primary">
                                <i class="ti ti-plus me-1"></i>
                                Tambah Pengaturan
                            </a>
                        @endif
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if ($pengaturan)
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="text-center">
                                        @if ($pengaturan->logo)
                                            <img src="{{ asset('storage/' . $pengaturan->logo) }}" alt="Logo Sekolah" class="img-fluid rounded mb-3"
                                                style="max-height: 200px;">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center mb-3" style="height: 200px;">
                                                <i class="ti ti-photo text-muted" style="font-size: 3rem;"></i>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td width="30%"><strong>Nama Sekolah:</strong></td>
                                            <td>{{ $pengaturan->nama_sekolah }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Alamat:</strong></td>
                                            <td>{{ $pengaturan->alamat_sekolah }}</td>
                                        </tr>
                                        @if ($pengaturan->telepon)
                                            <tr>
                                                <td><strong>Telepon:</strong></td>
                                                <td>{{ $pengaturan->telepon }}</td>
                                            </tr>
                                        @endif
                                        @if ($pengaturan->email)
                                            <tr>
                                                <td><strong>Email:</strong></td>
                                                <td>{{ $pengaturan->email }}</td>
                                            </tr>
                                        @endif
                                        @if ($pengaturan->website)
                                            <tr>
                                                <td><strong>Website:</strong></td>
                                                <td>
                                                    <a href="{{ $pengaturan->website }}" target="_blank" class="text-primary">
                                                        {{ $pengaturan->website }}
                                                    </a>
                                                </td>
                                            </tr>
                                        @endif
                                    </table>

                                    <div class="mt-3">
                                        <a href="{{ route('pengaturan-umum.edit', $pengaturan->id) }}" class="btn btn-warning me-2">
                                            <i class="ti ti-edit me-1"></i>
                                            Edit
                                        </a>
                                        <a href="{{ route('pengaturan-umum.show', $pengaturan->id) }}" class="btn btn-info me-2">
                                            <i class="ti ti-eye me-1"></i>
                                            Detail
                                        </a>
                                        <form action="{{ route('pengaturan-umum.destroy', $pengaturan->id) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengaturan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                <i class="ti ti-trash me-1"></i>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="ti ti-settings text-muted" style="font-size: 4rem;"></i>
                                <h5 class="mt-3 text-muted">Belum ada pengaturan umum</h5>
                                <p class="text-muted">Silakan tambah pengaturan umum untuk mengatur logo, nama sekolah, dan alamat sekolah.</p>
                                <a href="{{ route('pengaturan-umum.create') }}" class="btn btn-primary">
                                    <i class="ti ti-plus me-1"></i>
                                    Tambah Pengaturan
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

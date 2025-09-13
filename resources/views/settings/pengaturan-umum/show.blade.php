@extends('layouts.app')

@section('title', 'Detail Pengaturan Umum')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Detail Pengaturan Umum</h5>
                        <a href="{{ route('pengaturan-umum.index') }}" class="btn btn-secondary">
                            <i class="ti ti-arrow-left me-1"></i>
                            Kembali
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="text-center">
                                    @if ($pengaturan->logo)
                                        <img src="{{ asset('storage/' . $pengaturan->logo) }}" alt="Logo Sekolah" class="img-fluid rounded mb-3"
                                            style="max-height: 250px;">
                                    @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center mb-3" style="height: 250px;">
                                            <i class="ti ti-photo text-muted" style="font-size: 4rem;"></i>
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
                                    <tr>
                                        <td><strong>Dibuat:</strong></td>
                                        <td>{{ $pengaturan->created_at->format('d M Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Diperbarui:</strong></td>
                                        <td>{{ $pengaturan->updated_at->format('d M Y H:i') }}</td>
                                    </tr>
                                </table>

                                <div class="mt-4">
                                    <a href="{{ route('pengaturan-umum.edit', $pengaturan->id) }}" class="btn btn-warning me-2">
                                        <i class="ti ti-edit me-1"></i>
                                        Edit
                                    </a>
                                    <a href="{{ route('pengaturan-umum.index') }}" class="btn btn-info">
                                        <i class="ti ti-list me-1"></i>
                                        Daftar Pengaturan
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


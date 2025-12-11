@extends('layouts.app')
@section('titlepage', 'Detail Prestasi Siswa')

@section('content')
@section('navigasi')
    <span>Prestasi Siswa</span>
@endsection

<div class="row">
    <div class="col-lg-8 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Detail Prestasi Siswa</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 text-center mb-3">
                        @if ($prestasiSiswa->foto)
                            <img src="{{ asset('storage/prestasi-siswa/' . $prestasiSiswa->foto) }}" alt="Foto {{ $prestasiSiswa->nama_siswa }}"
                                class="img-fluid rounded" style="max-width: 300px;">
                        @else
                            <div class="bg-light text-center p-5 rounded">
                                <i class="ti ti-trophy" style="font-size: 5rem; color: #ccc;"></i>
                                <p class="text-muted mt-2">Tidak ada foto</p>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-8">
                        <table class="table table-borderless">
                            <tr>
                                <td width="30%"><strong>Nama Siswa:</strong></td>
                                <td>{{ $prestasiSiswa->nama_siswa }}</td>
                            </tr>
                            <tr>
                                <td><strong>Unit:</strong></td>
                                <td>
                                    @if ($prestasiSiswa->unit)
                                        <span class="badge bg-primary">{{ $prestasiSiswa->unit->nama_unit }}</span>
                                    @else
                                        <span class="text-muted">Tidak ada unit</span>
                                    @endif
                                </td>
                            </tr>
                            @if ($prestasiSiswa->siswa)
                                <tr>
                                    <td><strong>Data Siswa:</strong></td>
                                    <td>
                                        <span class="badge bg-info">Terdaftar sebagai siswa</span><br>
                                        <small class="text-muted">NISN: {{ $prestasiSiswa->siswa->nisn ?? '-' }}</small>
                                    </td>
                                </tr>
                            @else
                                <tr>
                                    <td><strong>Data Siswa:</strong></td>
                                    <td>
                                        <span class="badge bg-warning">Input manual</span>
                                    </td>
                                </tr>
                            @endif
                            <tr>
                                <td><strong>Prestasi:</strong></td>
                                <td>{{ $prestasiSiswa->prestasi }}</td>
                            </tr>
                            <tr>
                                <td><strong>Tingkat:</strong></td>
                                <td>
                                    @if ($prestasiSiswa->tingkat == 'nasional')
                                        <span class="badge bg-danger">{{ ucfirst($prestasiSiswa->tingkat) }}</span>
                                    @elseif ($prestasiSiswa->tingkat == 'kabupaten')
                                        <span class="badge bg-warning">{{ ucfirst($prestasiSiswa->tingkat) }}</span>
                                    @else
                                        <span class="badge bg-info">{{ ucfirst($prestasiSiswa->tingkat) }}</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Status:</strong></td>
                                <td>
                                    @if ($prestasiSiswa->status)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger">Nonaktif</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Dibuat:</strong></td>
                                <td>{{ $prestasiSiswa->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Diperbarui:</strong></td>
                                <td>{{ $prestasiSiswa->updated_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <a href="{{ route('prestasisiswa.edit', $prestasiSiswa->id) }}" class="btn btn-primary">
                            <i class="ti ti-edit me-1"></i> Edit
                        </a>
                        <a href="{{ route('prestasisiswa.index') }}" class="btn btn-secondary">
                            <i class="ti ti-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

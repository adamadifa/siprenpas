@extends('layouts.app')
@section('titlepage', 'Detail Testimoni')

@section('content')
@section('navigasi')
    <span>Testimoni</span>
@endsection

<div class="row">
    <div class="col-lg-8 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Detail Testimoni</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 text-center mb-3">
                        @if ($testimonial->foto)
                            <img src="{{ asset('storage/testimonials/' . $testimonial->foto) }}" alt="Foto {{ $testimonial->nama }}"
                                class="img-fluid rounded" style="max-width: 300px;">
                        @else
                            <div class="bg-light text-center p-5 rounded">
                                <i class="ti ti-user" style="font-size: 5rem; color: #ccc;"></i>
                                <p class="text-muted mt-2">Tidak ada foto</p>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-8">
                        <table class="table table-borderless">
                            <tr>
                                <td width="30%"><strong>Nama:</strong></td>
                                <td>{{ $testimonial->nama }}</td>
                            </tr>
                            <tr>
                                <td><strong>Testimoni:</strong></td>
                                <td>{{ $testimonial->testimoni }}</td>
                            </tr>
                            <tr>
                                <td><strong>Status:</strong></td>
                                <td>
                                    @if ($testimonial->status)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger">Nonaktif</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Dibuat:</strong></td>
                                <td>{{ $testimonial->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Diperbarui:</strong></td>
                                <td>{{ $testimonial->updated_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <a href="{{ route('testimonials.edit', $testimonial->id) }}" class="btn btn-primary">
                            <i class="ti ti-edit me-1"></i> Edit
                        </a>
                        <a href="{{ route('testimonials.index') }}" class="btn btn-secondary">
                            <i class="ti ti-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

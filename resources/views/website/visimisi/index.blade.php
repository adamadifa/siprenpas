@extends('layouts.app')
@section('titlepage', 'Visi & Misi')

@section('content')
@section('navigasi')
    <span>Visi & Misi</span>
@endsection
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Visi</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('visimisi.visi.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Deskripsi Visi <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" rows="3" required>{{ old('deskripsi', optional($visi)->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Maksimal hanya 1 visi yang disimpan. Menyimpan ulang akan menimpa visi sebelumnya.</div>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Simpan Visi</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Misi</h5>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalMisi">
                    <i class="ti ti-plus me-1"></i> Tambah Misi
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive mb-2">
                    <table class="table table-striped table-hover table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th width="5%">No.</th>
                                <th width="25%">Judul</th>
                                <th>Deskripsi</th>
                                <th width="10%">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($misi as $d)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $d->judul }}</td>
                                    <td>{{ $d->deskripsi }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="#" class="me-2" data-bs-toggle="modal"
                                                data-bs-target="#modalEditMisi{{ $d->id }}">
                                                <i class="ti ti-edit text-success"></i>
                                            </a>
                                            <form method="POST" class="deleteform" action="{{ route('visimisi.misi.delete', $d->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <a href="#" class="delete-confirm ml-1">
                                                    <i class="ti ti-trash text-danger"></i>
                                                </a>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <div class="modal fade" id="modalEditMisi{{ $d->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('visimisi.misi.update', $d->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Misi</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Judul</label>
                                                        <input type="text" class="form-control" name="judul" value="{{ $d->judul }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Deskripsi <span class="text-danger">*</span></label>
                                                        <textarea class="form-control" name="deskripsi" rows="3" required>{{ $d->deskripsi }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada data misi</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalMisi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('visimisi.misi.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Misi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Judul</label>
                        <input type="text" class="form-control" name="judul">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="deskripsi" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

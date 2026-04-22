@extends('layouts.app')
@section('titlepage', 'Visi & Misi')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-target fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Visi & Misi</h4>
                        <p class="text-muted mb-0 small">Manajemen visi dan misi lembaga pendidikan</p>
                    </div>
                </div>
                <div class="d-flex flex-column align-items-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mb-0">
                            <li class="breadcrumb-item">
                                <a href="javascript:void(0);" class="text-muted">
                                    <i class="ti ti-home-2 me-1"></i> Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                <i class="ti ti-target me-1"></i> Visi & Misi
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

<div class="row">
    <!-- Visi Section -->
    <div class="col-lg-12 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-header d-flex align-items-center gap-2 text-white py-3" style="background-color: #064e3b">
                <i class="ti ti-eye fs-5"></i>
                <h6 class="card-title mb-0 text-white">Visi Lembaga</h6>
            </div>
            <div class="card-body pt-4">
                <form action="{{ route('visimisi.visi.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold">Deskripsi Visi <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" rows="4"
                            placeholder="Masukkan visi lembaga..." required
                            style="border-radius: 8px; border: 1px solid #e0e0e0; padding: 12px;">{{ old('deskripsi', optional($visi)->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text mt-2">
                            <i class="ti ti-info-circle me-1"></i> Maksimal hanya 1 visi yang aktif. Menyimpan ulang akan memperbarui data visi saat ini.
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary d-flex align-items-center gap-2 ms-auto"
                            style="background-color: #064e3b; border-color: #064e3b">
                            <i class="ti ti-device-floppy fs-5"></i>
                            <span>Simpan Visi</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Misi Section -->
    <div class="col-lg-12">
        <div class="card shadow-sm border-0">
            <div class="card-header d-flex justify-content-between align-items-center text-white py-3"
                style="background-color: #064e3b">
                <div class="d-flex align-items-center gap-2">
                    <i class="ti ti-list-check fs-5"></i>
                    <h6 class="card-title mb-0 text-white">Misi Lembaga</h6>
                </div>
                <button type="button" class="btn btn-sm btn-white text-dark d-flex align-items-center gap-1"
                    data-bs-toggle="modal" data-bs-target="#modalMisi" style="background: white; border: none;">
                    <i class="ti ti-plus fs-6"></i>
                    <span class="fw-bold">Tambah Misi</span>
                </button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background-color: #064e3b">
                            <tr>
                                <th class="py-3 text-center text-white" style="width: 5%;">NO.</th>
                                <th class="py-3 text-white" style="width: 25%;">JUDUL MISI</th>
                                <th class="py-3 text-white">DESKRIPSI</th>
                                <th class="py-3 text-end text-white" style="width: 100px;">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($misi as $d)
                                <tr>
                                    <td class="text-center py-3">{{ $loop->iteration }}</td>
                                    <td class="py-3 fw-bold text-dark">{{ $d->judul ?: '-' }}</td>
                                    <td class="py-3">
                                        <div class="small text-muted text-wrap" style="max-width: 600px;">{{ $d->deskripsi }}</div>
                                    </td>
                                    <td class="text-end py-3">
                                        <div class="d-flex justify-content-end gap-1 px-3">
                                            <a href="#" class="btn btn-icon btn-label-success border"
                                                style="width: 28px; height: 28px;" data-bs-toggle="modal"
                                                data-bs-target="#modalEditMisi{{ $d->id }}">
                                                <i class="ti ti-edit fs-6"></i>
                                            </a>
                                            <form method="POST" class="deleteform"
                                                action="{{ route('visimisi.misi.delete', $d->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <a href="#" class="btn btn-icon btn-label-danger border delete-confirm"
                                                    style="width: 28px; height: 28px;">
                                                    <i class="ti ti-trash fs-6"></i>
                                                </a>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="modalEditMisi{{ $d->id }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow">
                                            <form action="{{ route('visimisi.misi.update', $d->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header border-bottom py-3"
                                                    style="background-color: #064e3b">
                                                    <h5 class="modal-title text-white">Edit Misi</h5>
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body p-4">
                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Judul Misi (Opsional)</label>
                                                        <input type="text" class="form-control" name="judul"
                                                            value="{{ $d->judul }}" placeholder="Masukkan judul misi...">
                                                    </div>
                                                    <div class="mb-0">
                                                        <label class="form-label fw-bold">Deskripsi Misi <span
                                                                class="text-danger">*</span></label>
                                                        <textarea class="form-control" name="deskripsi" rows="4" placeholder="Masukkan deskripsi lengkap misi..."
                                                            required>{{ $d->deskripsi }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-top p-3">
                                                    <button type="button" class="btn btn-label-secondary"
                                                        data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary"
                                                        style="background-color: #064e3b; border-color: #064e3b">Update
                                                        Misi</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center p-5">
                                        <div class="mb-3">
                                            <i class="ti ti-list-check fs-1 opacity-25"></i>
                                        </div>
                                        <h5>Belum Ada Data Misi</h5>
                                        <p class="text-muted">Klik tombol "Tambah Misi" untuk menambahkan misi baru.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="modalMisi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form action="{{ route('visimisi.misi.store') }}" method="POST">
                @csrf
                <div class="modal-header border-bottom py-3" style="background-color: #064e3b">
                    <h5 class="modal-title text-white">Tambah Misi Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul Misi (Opsional)</label>
                        <input type="text" class="form-control" name="judul" placeholder="Masukkan judul misi...">
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-bold">Deskripsi Misi <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="deskripsi" rows="4" placeholder="Masukkan deskripsi lengkap misi..."
                            required></textarea>
                    </div>
                </div>
                <div class="modal-footer border-top p-3">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"
                        style="background-color: #064e3b; border-color: #064e3b">Simpan Misi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('myscript')
    <script>
        $(function() {
            $(".delete-confirm").click(function(e) {
                e.preventDefault();
                var form = $(this).closest('form');
                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Misi ini akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush

@extends('layouts.app')
@section('titlepage', 'Data Guru')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-user-star fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Data Guru</h4>
                        <p class="text-muted mb-0 small">Manajemen tenaga pendidik akademik</p>
                    </div>
                </div>
                <div class="d-flex flex-column align-items-end">
                    <nav aria-label="breadcrumb" class="mb-2">
                        <ol class="breadcrumb breadcrumb-style1 mb-0">
                            <li class="breadcrumb-item">
                                <a href="javascript:void(0);" class="text-muted">
                                    <i class="ti ti-school me-1"></i> Akademik
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                <i class="ti ti-user-star me-1"></i> Guru
                            </li>
                        </ol>
                    </nav>
                    @can('guru.create')
                        <a href="#" class="btn btn-primary d-flex align-items-center gap-2 shadow-sm" id="btnCreateGuru" style="background-color: #064e3b; border-color: #064e3b">
                            <i class="ti ti-plus fs-5"></i>
                            <span>Tambah Data Guru</span>
                        </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection

<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        
        <!-- Filter Section -->
        <div class="card mb-4 shadow-none border-0 bg-transparent">
            <div class="card-body p-0">
                <form action="{{ route('guru.index') }}">
                    <div class="row g-3 align-items-center">
                        <div class="col-lg-5 col-md-6">
                            <x-input-with-icon label="" value="{{ Request('nama_lengkap') }}" name="nama_lengkap"
                                placeholder="Cari Nama Guru" icon="ti ti-search" />
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group mb-3">
                                <select name="kode_unit" class="form-select border-0 shadow-sm border" style="border-color: #e0e0e0 !important;">
                                    <option value="">Semua Unit</option>
                                    @foreach ($unit as $u)
                                        <option value="{{ $u->kode_unit }}" {{ Request('kode_unit') == $u->kode_unit ? 'selected' : '' }}>{{ $u->nama_unit }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <button class="btn btn-primary w-100 p-2 d-flex align-items-center justify-content-center gap-2 mb-3" style="background-color: #064e3b; border-color: #064e3b">
                                <i class="ti ti-search fs-5"></i>
                                <span>Cari Data</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Data List -->
        <div class="row g-3">
            @forelse ($guru as $d)
                <div class="col-12">
                    <div class="card shadow-sm border-0 h-100 overflow-hidden" style="border-left: 4px solid #064e3b !important;">
                        <div class="card-body p-3">
                            <div class="row align-items-center">
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="d-flex align-items-center mb-2 mb-lg-0">
                                        <div class="avatar avatar-md me-3 rounded bg-label-success d-flex justify-content-center align-items-center">
                                            <i class="ti ti-user fs-3"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold text-dark">{{ $d->nama_lengkap }}</h6>
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="text-muted small"><i class="ti ti-id me-1"></i>{{ $d->npp }}</span>
                                                <span class="badge bg-label-secondary" style="font-size: 0.65rem;">{{ $d->nama_unit }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12 border-start-lg ps-lg-4">
                                    <div class="d-flex flex-column">
                                        <div class="text-muted small">Jabatan / NIP</div>
                                        <span class="fw-bold text-dark">{{ $d->nama_jabatan ?: 'Pendidik' }}</span>
                                        <code class="text-primary small fw-bold">{{ $d->nomor_kemenag_dinas ?: '-' }}</code>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12 border-start-lg ps-lg-4 mt-2 mt-md-0">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="text-center">
                                            <div class="text-muted small mb-1">Status</div>
                                            @if ($d->status_aktif_ajar == 1)
                                                <span class="badge bg-label-success rounded-pill px-3">
                                                    <i class="ti ti-checks me-1" style="font-size: 0.75rem;"></i>Aktif
                                                </span>
                                            @else
                                                <span class="badge bg-label-danger rounded-pill px-3">Non-Aktif</span>
                                            @endif
                                        </div>
                                        <div class="text-center border-start ps-3">
                                            <div class="text-muted small mb-1">TTD Digital</div>
                                            @if (!empty($d->file_ttd))
                                                <span class="badge bg-label-info rounded-pill px-3" data-bs-toggle="tooltip" title="Tanda Tangan Tersedia">
                                                    <i class="ti ti-file-check me-1" style="font-size: 0.75rem;"></i>Ready
                                                </span>
                                            @else
                                                <span class="badge bg-label-warning rounded-pill px-3">Missing</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6 col-sm-12 text-end mt-3 mt-lg-0">
                                    <div class="d-flex justify-content-end gap-1">
                                        @if (!empty($d->file_ttd))
                                            <a href="{{ asset('storage/uploads/ttd_guru/' . $d->file_ttd) }}" target="_blank" 
                                               class="btn btn-icon btn-label-success border shadow-none" 
                                               style="width: 32px; height: 32px;" data-bs-toggle="tooltip" title="Lihat TTD">
                                                <i class="ti ti-file-certificate fs-5"></i>
                                            </a>
                                        @endif
                                        @can('guru.edit')
                                            <a href="#" class="btn btn-icon btn-label-warning border editGuru shadow-none" 
                                               style="width: 32px; height: 32px;" id="{{ Crypt::encrypt($d->id) }}"
                                               data-bs-toggle="tooltip" title="Edit Data">
                                                <i class="ti ti-edit fs-5"></i>
                                            </a>
                                        @endcan
                                        @can('guru.delete')
                                            <form method="POST" class="deleteform d-inline" action="{{ route('guru.delete', Crypt::encrypt($d->id)) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-icon btn-label-danger border delete-confirm shadow-none" 
                                                        style="width: 32px; height: 32px;" data-bs-toggle="tooltip" title="Hapus Data">
                                                    <i class="ti ti-trash fs-5"></i>
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="card shadow-none border-0 text-center p-5 bg-white">
                        <div class="mb-3">
                            <i class="ti ti-user-x fs-1 opacity-25"></i>
                        </div>
                        <h5>Belum Ada Data Guru</h5>
                        <p class="text-muted small">Klik tombol "Tambah Data Guru" untuk mulai menambahkan.</p>
                    </div>
                </div>
            @endforelse
            
            <div class="col-12 mt-4">
                <div class="d-flex justify-content-end">
                    {{ $guru->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<x-modal-form id="mdlCreateGuru" size="" show="loadCreateGuru" title="Tambah Data Guru" icon="ti ti-user-plus" />
<x-modal-form id="mdlEditGuru" size="" show="loadEditGuru" title="Edit Data Guru" icon="ti ti-user-edit" />

@endsection

@push('myscript')
<script>
    $(function() {
        $("#btnCreateGuru").click(function(e) {
            e.preventDefault();
            $('#mdlCreateGuru').modal("show");
            $("#loadCreateGuru").load('/guru/create');
        });

        $(".editGuru").click(function(e) {
            var id = $(this).attr("id");
            e.preventDefault();
            $('#mdlEditGuru').modal("show");
            $("#loadEditGuru").load('/guru/' + id + '/edit');
        });

        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // Delete Confirm
        $(".delete-confirm").click(function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data guru akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#064e3b',
                cancelButtonColor: '#d33',
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

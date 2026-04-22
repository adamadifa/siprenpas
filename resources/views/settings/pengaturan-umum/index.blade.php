@extends('layouts.app')

@section('titlepage', 'Pengaturan Umum')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-settings fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Pengaturan Umum</h4>
                        <p class="text-muted mb-0 small">Manajemen konfigurasi sistem dan informasi lembaga</p>
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
                                <i class="ti ti-settings me-1"></i> Pengaturan Umum
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
        <div class="card shadow-sm border-0">
            <div class="card-header d-flex justify-content-between align-items-center text-white py-3"
                style="background-color: #064e3b">
                <div class="d-flex align-items-center gap-2">
                    <i class="ti ti-adjustments-horizontal fs-5"></i>
                    <h6 class="card-title mb-0 text-white">Konfigurasi Sistem</h6>
                </div>
                @if (!$pengaturan)
                    <a href="{{ route('pengaturan-umum.create') }}" class="btn btn-sm btn-white text-dark fw-bold"
                        style="background: white; border: none;">
                        <i class="ti ti-plus me-1"></i> Tambah Pengaturan
                    </a>
                @else
                    <a href="{{ route('pengaturan-umum.edit', $pengaturan->id) }}" class="btn btn-sm btn-white text-dark fw-bold"
                        style="background: white; border: none;">
                        <i class="ti ti-edit me-1"></i> Edit Konfigurasi
                    </a>
                @endif
            </div>
            <div class="card-body pt-4">
                @if ($pengaturan)
                    <div class="row g-4">
                        <!-- Logo & Visual -->
                        <div class="col-lg-4">
                            <div class="card bg-label-success border-0 h-100 shadow-none">
                                <div class="card-body text-center d-flex flex-column align-items-center justify-content-center p-4">
                                    <h6 class="text-dark fw-bold mb-3">Logo Lembaga</h6>
                                    <div class="avatar-wrapper mb-3 p-3 bg-white rounded-3 shadow-sm" style="width: 200px; height: 200px;">
                                        @if ($pengaturan->logo && Storage::disk('public')->exists($pengaturan->logo))
                                            <img src="{{ asset('storage/' . $pengaturan->logo) }}" alt="Logo" class="img-fluid" style="max-height: 100%; object-fit: contain;">
                                        @else
                                            <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                                                <i class="ti ti-photo fs-1"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <span class="badge bg-success shadow-sm">Aktif</span>
                                </div>
                            </div>
                        </div>

                        <!-- Details -->
                        <div class="col-lg-8">
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="35%" class="text-muted"><i class="ti ti-building me-2"></i>Nama Lembaga</td>
                                        <td class="fw-bold text-dark">: {{ $pengaturan->nama_sekolah }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted"><i class="ti ti-map-pin me-2"></i>Alamat Lengkap</td>
                                        <td class="text-dark">: {{ $pengaturan->alamat_sekolah }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted"><i class="ti ti-phone me-2"></i>No. Telepon</td>
                                        <td class="text-dark">: {{ $pengaturan->telepon ?: '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted"><i class="ti ti-mail me-2"></i>Alamat Email</td>
                                        <td class="text-dark">: {{ $pengaturan->email ?: '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted"><i class="ti ti-world me-2"></i>Website Resmi</td>
                                        <td>: 
                                            @if($pengaturan->website)
                                                <a href="{{ $pengaturan->website }}" target="_blank" class="badge bg-label-primary">{{ $pengaturan->website }}</a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted"><i class="ti ti-clock-hour-4 me-2"></i>Session Lifetime</td>
                                        <td>: <span class="badge bg-label-warning">{{ $pengaturan->session_lifetime }} Menit</span></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><hr class="my-2"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted"><i class="ti ti-share me-2"></i>Media Sosial</td>
                                        <td>:
                                            <div class="d-flex gap-2 mt-1">
                                                @if($pengaturan->facebook)
                                                    <a href="{{ $pengaturan->facebook }}" target="_blank" class="avatar avatar-sm bg-label-primary rounded-circle"><i class="ti ti-brand-facebook"></i></a>
                                                @endif
                                                @if($pengaturan->instagram)
                                                    <a href="{{ $pengaturan->instagram }}" target="_blank" class="avatar avatar-sm bg-label-danger rounded-circle"><i class="ti ti-brand-instagram"></i></a>
                                                @endif
                                                @if($pengaturan->youtube)
                                                    <a href="{{ $pengaturan->youtube }}" target="_blank" class="avatar avatar-sm bg-label-danger rounded-circle"><i class="ti ti-brand-youtube"></i></a>
                                                @endif
                                                @if($pengaturan->tiktok)
                                                    <a href="{{ $pengaturan->tiktok }}" target="_blank" class="avatar avatar-sm bg-label-dark rounded-circle"><i class="ti ti-brand-tiktok"></i></a>
                                                @endif
                                                @if(!$pengaturan->facebook && !$pengaturan->instagram && !$pengaturan->youtube && !$pengaturan->tiktok)
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <div class="mt-4 d-flex gap-2 justify-content-end">
                                <a href="{{ route('pengaturan-umum.show', $pengaturan->id) }}" class="btn btn-label-info d-flex align-items-center gap-2">
                                    <i class="ti ti-eye fs-5"></i> Detail Lengkap
                                </a>
                                <form action="{{ route('pengaturan-umum.destroy', $pengaturan->id) }}" method="POST" class="deleteform">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-label-danger d-flex align-items-center gap-2 delete-confirm">
                                        <i class="ti ti-trash fs-5"></i> Hapus Konfigurasi
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="avatar avatar-xl bg-label-secondary mx-auto mb-4">
                            <i class="ti ti-settings-off fs-1"></i>
                        </div>
                        <h5 class="text-dark fw-bold">Belum Ada Pengaturan</h5>
                        <p class="text-muted">Silakan buat pengaturan umum pertama Anda untuk memulai konfigurasi sistem.</p>
                        <a href="{{ route('pengaturan-umum.create') }}" class="btn btn-primary px-4 shadow-sm" style="background-color: #064e3b; border-color: #064e3b">
                            <i class="ti ti-plus me-1"></i> Buat Pengaturan
                        </a>
                    </div>
                @endif
            </div>
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
                text: "Menghapus pengaturan ini akan mengembalikan ke setelan default sistem!",
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

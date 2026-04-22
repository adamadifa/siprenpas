@extends('layouts.app')
@section('titlepage', 'Mesin Fingerprint')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-fingerprint fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Mesin Fingerprint</h4>
                        <p class="text-muted mb-0 small">Konfigurasi dan pemantauan perangkat absensi biometrik</p>
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
                                <i class="ti ti-fingerprint me-1"></i> Mesin Fingerprint
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

<div class="row">
    <div class="col-lg-12 col-md-12">
        <!-- Actions Section -->
        <div class="d-flex justify-content-start gap-2 mb-3">
            @can('mesinfingerprint.create')
                <a href="#" class="btn d-flex align-items-center gap-2 shadow-sm text-white" id="btnCreate"
                    style="background-color: #064e3b">
                    <i class="ti ti-plus fs-4"></i>
                    <span>Tambah Mesin</span>
                </a>
            @endcan
            <a href="{{ route('mesinfingerprint.logmesin') }}" class="btn btn-label-info d-flex align-items-center gap-2 shadow-sm border">
                <i class="ti ti-list-details fs-4"></i>
                <span>Log Mesin</span>
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header d-flex align-items-center gap-2 text-white py-3" style="background-color: #064e3b">
                <i class="ti ti-device-laptop fs-5"></i>
                <h6 class="card-title mb-0 text-white">Daftar Perangkat Terhubung</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background-color: #064e3b">
                            <tr>
                                <th class="text-white py-3 text-center" style="width: 1%;">NO.</th>
                                <th class="text-white py-3">NAMA MESIN</th>
                                <th class="text-white py-3">SERIAL NUMBER (SN)</th>
                                <th class="text-white py-3">KOORDINAT LOKASI</th>
                                <th class="text-white py-3 text-center">STATUS</th>
                                <th class="text-white py-3 text-end" style="width: 100px;">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($mesin as $d)
                                <tr>
                                    <td class="py-2 text-center">{{ $loop->iteration }}</td>
                                    <td class="py-2">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="avatar avatar-xs bg-label-success rounded-circle">
                                                <i class="ti ti-cpu fs-6"></i>
                                            </div>
                                            <span class="fw-bold text-dark">{{ $d->nama_mesin }}</span>
                                        </div>
                                    </td>
                                    <td class="py-2"><code class="bg-light px-2 py-1 rounded small text-danger fw-bold">{{ $d->sn }}</code></td>
                                    <td class="py-2">
                                        @if($d->titik_koordinat)
                                            <span class="small text-muted"><i class="ti ti-map-pin me-1"></i>{{ $d->titik_koordinat }}</span>
                                        @else
                                            <span class="text-muted small italic">Belum diatur</span>
                                        @endif
                                    </td>
                                    <td class="py-2 text-center">
                                        @if ($d->status == 'Aktif')
                                            <span class="badge bg-success rounded-pill px-3">
                                                <i class="ti ti-circle-check me-1"></i> Aktif
                                            </span>
                                        @else
                                            <span class="badge bg-label-danger rounded-pill px-3">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td class="py-2 text-end">
                                        <div class="d-flex justify-content-end gap-1 px-3">
                                            @can('mesinfingerprint.edit')
                                                <a href="#" class="btn btn-icon btn-label-success border btnEdit"
                                                    style="width: 28px; height: 28px;" data-id="{{ Crypt::encrypt($d->id) }}">
                                                    <i class="ti ti-edit fs-6"></i>
                                                </a>
                                            @endcan
                                            @can('mesinfingerprint.delete')
                                                <form method="POST" name="deleteform" class="deleteform"
                                                    action="{{ route('mesinfingerprint.delete', Crypt::encrypt($d->id)) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="#" class="btn btn-icon btn-label-danger border delete-confirm"
                                                        style="width: 28px; height: 28px;">
                                                        <i class="ti ti-trash fs-6"></i>
                                                    </a>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center p-5">
                                        <div class="mb-3">
                                            <i class="ti ti-fingerprint-off fs-1 opacity-25"></i>
                                        </div>
                                        <h5>Belum Ada Mesin Terdaftar</h5>
                                        <p class="text-muted">Silahkan tambah mesin fingerprint baru untuk sinkronisasi data presensi.</p>
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

<x-modal-form id="mdlCreate" size="" show="loadCreate" title="Tambah Mesin Fingerprint" />
<x-modal-form id="mdlEdit" size="" show="loadEdit" title="Edit Mesin Fingerprint" />
@endsection

@push('myscript')
<script>
    $(function() {
        $("#btnCreate").click(function(e) {
            e.preventDefault();
            $('#mdlCreate').modal("show");
            $("#loadCreate").load("{{ route('mesinfingerprint.create') }}");
        });

        $(".btnEdit").click(function(e) {
            var id = $(this).attr("data-id");
            e.preventDefault();
            $('#mdlEdit').modal("show");
            $("#loadEdit").load('/mesinfingerprint/' + id + '/edit');
        });

        $(document).on('click', '.delete-confirm', function(e) {
            e.preventDefault();
            const form = $(this).closest('form');
            Swal.fire({
                title: 'Hapus Mesin?',
                text: "Sinkronisasi data dari mesin ini mungkin akan terganggu!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
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

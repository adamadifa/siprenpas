@extends('layouts.app')
@section('titlepage', 'Tahun Ajaran PPDB')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-school fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Tahun Ajaran PPDB</h4>
                        <p class="text-muted mb-0 small">Manajemen periode pendaftaran peserta didik baru</p>
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
                                <i class="ti ti-school me-1"></i> Tahun Ajaran PPDB
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
        <!-- Actions Section -->
        <div class="d-flex justify-content-start mb-3">
            @can('tahunajaran.create')
                <a href="#" class="btn d-flex align-items-center gap-2 shadow-sm text-white" id="btnCreate"
                    style="background-color: #064e3b">
                    <i class="ti ti-plus fs-4"></i>
                    <span>Tambah Tahun Ajaran PPDB</span>
                </a>
            @endcan
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header d-flex align-items-center gap-2 text-white py-3" style="background-color: #064e3b">
                <i class="ti ti-calendar-event fs-5"></i>
                <h6 class="card-title mb-0 text-white">Data Tahun Ajaran PPDB</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background-color: #064e3b">
                            <tr>
                                <th class="text-white py-3 text-center" style="width: 1%;">NO.</th>
                                <th class="text-white py-3">KODE</th>
                                <th class="text-white py-3">TAHUN AJARAN</th>
                                <th class="text-white py-3 text-center">STATUS</th>
                                <th class="text-white py-3 text-end" style="width: 100px;">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tahun_ajaran as $d)
                                <tr class="{{ $d->status == '1' ? 'bg-label-success' : '' }}">
                                    <td class="py-2 text-center">{{ $loop->iteration }}</td>
                                    <td class="py-2 fw-bold text-muted small">{{ $d->kode_ta }}</td>
                                    <td class="py-2 fw-bold text-dark">{{ $d->tahun_ajaran }}</td>
                                    <td class="py-2 text-center">
                                        @if ($d->status == '1')
                                            <span class="badge bg-success rounded-pill px-3">
                                                <i class="ti ti-check me-1"></i> Aktif
                                            </span>
                                        @else
                                            <span class="badge bg-label-danger rounded-pill px-3">Non-Aktif</span>
                                        @endif
                                    </td>
                                    <td class="py-2 text-end">
                                        <div class="d-flex justify-content-end gap-1 px-3">
                                            @can('tahunajaran.edit')
                                                <a href="#" class="btn btn-icon btn-label-success border btnEdit"
                                                    style="width: 28px; height: 28px;"
                                                    kode_ta="{{ Crypt::encrypt($d->kode_ta) }}">
                                                    <i class="ti ti-edit fs-6"></i>
                                                </a>
                                            @endcan
                                            @can('tahunajaran.delete')
                                                <form method="POST" name="deleteform" class="deleteform"
                                                    action="{{ route('tahunajaranppdb.delete', Crypt::encrypt($d->kode_ta)) }}">
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
                                    <td colspan="5" class="text-center p-5">
                                        <div class="mb-3">
                                            <i class="ti ti-school-off fs-1 opacity-25"></i>
                                        </div>
                                        <h5>Belum Ada Data</h5>
                                        <p class="text-muted">Silahkan tambah tahun ajaran PPDB baru.</p>
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

<x-modal-form id="modal" size="" show="loadmodal" title="" />
@endsection

@push('myscript')
<script>
    $(function() {
        $("#btnCreate").click(function(e) {
            e.preventDefault();
            $('#modal').modal("show");
            $(".modal-title").text("Tambah Tahun Ajaran PPDB");
            $("#loadmodal").load("{{ route('tahunajaranppdb.create') }}");
        });

        $(".btnEdit").click(function(e) {
            e.preventDefault();
            const kode_ta = $(this).attr('kode_ta')
            $('#modal').modal("show");
            $(".modal-title").text("Edit Tahun Ajaran PPDB");
            $("#loadmodal").load(`/tahunajaranppdb/${kode_ta}/edit`);
        });

        $(document).on('click', '.delete-confirm', function(e) {
            e.preventDefault();
            const form = $(this).closest('form');
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data ini akan dihapus permanen!",
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
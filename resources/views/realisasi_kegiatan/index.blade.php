@extends('layouts.app')
@section('titlepage', 'Realisasi Kegiatan')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-activity fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Realisasi Kegiatan</h4>
                        <p class="text-muted mb-0 small">Monitoring dan pencatatan realisasi kegiatan pesantren</p>
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
                                <i class="ti ti-activity me-1"></i> Realisasi Kegiatan
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
            @can('realkegiatan.create')
                <button class="btn d-flex align-items-center gap-2 shadow-sm text-white" id="btncreateRealisasiKegiatan"
                    style="background-color: #064e3b">
                    <i class="ti ti-plus fs-4"></i>
                    <span>Tambah Realisasi Kegiatan</span>
                </button>
            @endcan
        </div>

        <!-- Filter Section -->
        <style>
            .form-filter .form-group {
                margin-bottom: 0 !important;
            }
        </style>
        <div class="card mb-4 shadow-none border-0 bg-transparent">
            <div class="card-body p-0">
                <form action="{{ route('realisasikegiatan.index') }}" class="form-filter" id="myForm">
                    <div class="row g-3 align-items-center">
                        <div class="col-lg-2 col-md-6">
                            <div class="form-group">
                                <input type="text" name="dari" id="dari" class="form-control border-0 shadow-sm border flatpickr-date"
                                    placeholder="Dari" value="{{ Request('dari') }}" style="border-color: #e0e0e0 !important;">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6">
                            <div class="form-group">
                                <input type="text" name="sampai" id="sampai" class="form-control border-0 shadow-sm border flatpickr-date"
                                    placeholder="Sampai" value="{{ Request('sampai') }}" style="border-color: #e0e0e0 !important;">
                            </div>
                        </div>
                        @if ($user->hasRole(['super admin', 'pimpinan pesantren', 'sekretaris']))
                            <div class="col-lg-2 col-md-6">
                                <div class="form-group">
                                    <select name="kode_jabatan" id="kode_jabatan" class="form-select border-0 shadow-sm border" style="border-color: #e0e0e0 !important;">
                                        <option value="">Semua Jabatan</option>
                                        @foreach ($jabatan as $d)
                                            <option value="{{ $d->kode_jabatan }}"
                                                {{ Request('kode_jabatan') == $d->kode_jabatan ? 'selected' : '' }}>
                                                {{ strtoUpper($d->nama_jabatan) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-6">
                                <div class="form-group">
                                    <select name="kode_dept" id="kode_dept" class="form-select border-0 shadow-sm border" style="border-color: #e0e0e0 !important;">
                                        <option value="">Semua Departemen</option>
                                        @foreach ($departemen as $d)
                                            <option value="{{ $d->kode_dept }}" {{ Request('kode_dept') == $d->kode_dept ? 'selected' : '' }}>
                                                {{ strtoUpper($d->nama_dept) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                        <div class="col-lg-1 col-md-3">
                            <button type="submit" class="btn btn-primary w-100 p-2 d-flex align-items-center justify-content-center"
                                style="background-color: #064e3b; border-color: #064e3b">
                                <i class="ti ti-search fs-5"></i>
                            </button>
                        </div>
                        <div class="col-lg-2 col-md-12">
                            <div class="d-flex gap-2">
                                <button type="submit" name="cetak" value="1" id="cetakButton" class="btn btn-warning shadow-sm border-0 flex-grow-1 p-2">
                                    <i class="ti ti-printer fs-5"></i>
                                </button>
                                <button type="submit" name="cetak_pdf" value="1" id="cetakPdfButton" class="btn btn-danger shadow-sm border-0 flex-grow-1 p-2">
                                    <i class="ti ti-file-type-pdf fs-5"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header d-flex align-items-center gap-2 text-white py-3" style="background-color: #064e3b">
                <i class="ti ti-activity fs-5"></i>
                <h6 class="card-title mb-0 text-white">Data Realisasi Kegiatan</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background-color: #064e3b">
                            <tr>
                                <th class="text-white py-3" style="width: 1%;">NO.</th>
                                <th class="text-white py-3" style="width: 10%;">TANGGAL</th>
                                <th class="text-white py-3">KEGIATAN & URAIAN</th>
                                <th class="text-white py-3">JOBDESK & PROGKER</th>
                                <th class="text-white py-3" style="width: 1%;">DEPT</th>
                                <th class="text-white py-3" style="width: 1%;">USER</th>
                                <th class="text-white py-3 text-end" style="width: 80px;">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($realisasikegiatan as $d)
                                <tr>
                                    <td class="py-2">{{ $loop->iteration }}</td>
                                    <td class="py-2 text-nowrap">{{ date('d-m-Y', strtotime($d->tanggal)) }}</td>
                                    <td class="py-2">
                                        <div class="fw-bold text-dark mb-1">{{ removeHtmltag($d->nama_kegiatan) }}</div>
                                        <div class="small text-muted" style="min-width: 250px;">{{ removeHtmltag($d->uraian_kegiatan) }}</div>
                                    </td>
                                    <td class="py-2">
                                        <div class="small mb-1"><i class="ti ti-briefcase me-1 opacity-50"></i>{{ removeHtmltag($d->jobdesk) }}</div>
                                        <div class="small text-primary"><i class="ti ti-notebook me-1 opacity-50"></i>{{ $d->program_kerja }}</div>
                                    </td>
                                    <td class="py-2 text-center">
                                        <span class="badge bg-label-success">{{ $d->kode_dept }}</span>
                                    </td>
                                    <td class="py-2 text-nowrap small">{{ formatNama1($d->name) }}</td>
                                    <td class="py-2 text-end">
                                        <div class="d-flex justify-content-end gap-1">
                                            @can('realkegiatan.edit')
                                                <a href="#" class="btn btn-icon btn-label-success border btnEdit"
                                                    style="width: 28px; height: 28px;"
                                                    id="{{ Crypt::encrypt($d->id) }}">
                                                    <i class="ti ti-edit fs-6"></i>
                                                </a>
                                            @endcan
                                            @can('realkegiatan.delete')
                                                <form method="POST" name="deleteform" class="deleteform"
                                                    action="{{ route('realisasikegiatan.delete', Crypt::encrypt($d->id)) }}">
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
                                    <td colspan="7" class="text-center p-5">
                                        <div class="mb-3">
                                            <i class="ti ti-activity fs-1 opacity-25"></i>
                                        </div>
                                        <h5>Belum Ada Realisasi Kegiatan</h5>
                                        <p class="text-muted">Silahkan tambah realisasi baru atau sesuaikan filter pencarian.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-3">
                    {{ $realisasikegiatan->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<x-modal-form id="mdlRealisasiKegiatan" size="" show="loadRealisasiKegiatan" title="" />
@endsection
@push('myscript')
<script>
    $('#cetakButton').click(function(e) {
        e.preventDefault();
        // Ambil data form menggunakan jQuery
        const formData = $('#myForm').serialize();
        const url = "{{ URL::current() }}";
        // URL tujuan untuk cetak menggunakan jQuery
        const printUrl = url + '?' + formData + '&cetak=1';

        const kode_dept = $('#kode_dept').val();
        const dari = $('#dari').val();
        const sampai = $('#sampai').val();

        if (kode_dept == '') {
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Departemen tidak boleh kosong!',
                didClose: (e) => {
                    $('#kode_dept').focus();
                }
            });
            return false;
        } else if (dari == '' || sampai == '') {
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Tanggal tidak boleh kosong!',
                didClose: (e) => {
                    $('#dari').focus();
                }
            });
            return false;
        } else {
            window.open(printUrl, '_blank');
        }
        // Buka tab baru untuk cetak menggunakan jQuery
    });
</script>
{{-- <script src="{{ asset('assets/js/pages/roles/create.js') }}"></script> --}}
<script>
    $(function() {
        $("#btncreateRealisasiKegiatan").click(function(e) {
            e.preventDefault();
            $('#mdlRealisasiKegiatan').modal("show");
            $("#mdlRealisasiKegiatan").find(".modal-title").text("Tambah Realisasi Kegiatan");
            $("#loadRealisasiKegiatan").load('/realisasikegiatan/create');
        });

        $(".btnEdit").click(function(e) {
            var id = $(this).attr("id");
            e.preventDefault();
            $('#mdlRealisasiKegiatan').modal("show");
            $("#mdlRealisasiKegiatan").find(".modal-title").text("Edit Realisasi Kegiatan");
            $("#loadRealisasiKegiatan").load('/realisasikegiatan/' + id + '/edit');
        });
    });
</script>
@endpush

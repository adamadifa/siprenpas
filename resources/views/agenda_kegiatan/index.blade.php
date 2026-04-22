@extends('layouts.app')
@section('titlepage', 'Agenda Kegiatan')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-calendar-event fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Agenda Kegiatan</h4>
                        <p class="text-muted mb-0 small">Manajemen perencanaan agenda dan kegiatan pesantren</p>
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
                                <i class="ti ti-calendar-event me-1"></i> Agenda Kegiatan
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
            @can('agendakegiatan.create')
                <button class="btn d-flex align-items-center gap-2 shadow-sm text-white" id="btncreateAgendaKegiatan"
                    style="background-color: #064e3b">
                    <i class="ti ti-plus fs-4"></i>
                    <span>Tambah Agenda Kegiatan</span>
                </button>
            @endcan
        </div>

        <!-- Filter Form -->
        <div class="card shadow-none border mb-4">
            <div class="card-body p-3">
                <form action="{{ route('agendakegiatan.index') }}" id="myForm">
                    <div class="row g-2">
                        <div class="col-lg-2 col-md-6">
                            <div class="input-group input-group-merge border rounded-2">
                                <span class="input-group-text bg-white border-0"><i class="ti ti-calendar text-muted"></i></span>
                                <input type="text" name="dari" class="form-control bg-white border-0 ps-2 flatpickr-date"
                                    placeholder="Dari" value="{{ Request('dari') }}">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6">
                            <div class="input-group input-group-merge border rounded-2">
                                <span class="input-group-text bg-white border-0"><i class="ti ti-calendar text-muted"></i></span>
                                <input type="text" name="sampai" class="form-control bg-white border-0 ps-2 flatpickr-date"
                                    placeholder="Sampai" value="{{ Request('sampai') }}">
                            </div>
                        </div>
                        @if ($user->hasRole('super admin'))
                            <div class="col-lg-2 col-md-6">
                                <select name="kode_jabatan" id="kode_jabatan" class="form-select select2">
                                    <option value="">Semua Jabatan</option>
                                    @foreach ($jabatan as $d)
                                        <option value="{{ $d->kode_jabatan }}"
                                            {{ Request('kode_jabatan') == $d->kode_jabatan ? 'selected' : '' }}>
                                            {{ strtoUpper($d->nama_jabatan) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-2 col-md-6">
                                <select name="kode_dept" id="kode_dept" class="form-select select2">
                                    <option value="">Semua Departemen</option>
                                    @foreach ($departemen as $d)
                                        <option value="{{ $d->kode_dept }}"
                                            {{ Request('kode_dept') == $d->kode_dept ? 'selected' : '' }}>
                                            {{ strtoUpper($d->nama_dept) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <div class="col-lg-{{ $user->hasRole('super admin') ? '2' : '6' }} col-md-6">
                            <button type="submit" class="btn shadow-none w-100 text-white" style="background-color: #064e3b">
                                <i class="ti ti-search fs-5 me-1"></i> Cari
                            </button>
                        </div>
                        <div class="col-lg-2 col-md-12">
                            <div class="d-flex gap-2">
                                <button type="submit" name="cetak" value="1" id="cetakButton" class="btn btn-warning shadow-none flex-grow-1">
                                    <i class="ti ti-printer fs-5"></i>
                                </button>
                                <button type="submit" name="cetak_pdf" value="1" id="cetakPdfButton" class="btn btn-danger shadow-none flex-grow-1">
                                    <i class="ti ti-file-text fs-5"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header d-flex align-items-center gap-2 text-white py-3" style="background-color: #064e3b">
                <i class="ti ti-calendar-event fs-5"></i>
                <h6 class="card-title mb-0 text-white">Data Agenda Kegiatan</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background-color: #064e3b">
                            <tr>
                                <th class="text-white py-3" style="width: 1%;">NO.</th>
                                <th class="text-white py-3" style="width: 10%;">TANGGAL</th>
                                <th class="text-white py-3">NAMA KEGIATAN</th>
                                <th class="text-white py-3">URAIAN KEGIATAN</th>
                                <th class="text-white py-3" style="width: 1%;">DEPT</th>
                                <th class="text-white py-3" style="width: 1%;">USER</th>
                                <th class="text-white py-3 text-end" style="width: 80px;">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($agenda_kegiatan as $d)
                                <tr>
                                    <td class="py-2">{{ $loop->iteration }}</td>
                                    <td class="py-2 text-nowrap">{{ date('d-m-Y', strtotime($d->tanggal)) }}</td>
                                    <td class="py-2 fw-bold text-dark">{{ strip_tags($d->nama_kegiatan) }}</td>
                                    <td class="py-2 small text-muted" style="min-width: 300px;">{{ strip_tags($d->uraian_kegiatan) }}</td>
                                    <td class="py-2">
                                        <span class="badge bg-label-success">{{ $d->kode_dept }}</span>
                                    </td>
                                    <td class="py-2 text-nowrap small">{{ formatNama1($d->name) }}</td>
                                    <td class="py-2 text-end">
                                        <div class="d-flex justify-content-end gap-1">
                                            @can('agendakegiatan.edit')
                                                <a href="#" class="btn btn-icon btn-label-success border btnEdit"
                                                    style="width: 28px; height: 28px;"
                                                    id="{{ Crypt::encrypt($d->id) }}">
                                                    <i class="ti ti-edit fs-6"></i>
                                                </a>
                                            @endcan
                                            @can('agendakegiatan.delete')
                                                <form method="POST" name="deleteform" class="deleteform"
                                                    action="{{ route('agendakegiatan.delete', Crypt::encrypt($d->id)) }}">
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
                                            <i class="ti ti-calendar-event fs-1 opacity-25"></i>
                                        </div>
                                        <h5>Belum Ada Agenda Kegiatan</h5>
                                        <p class="text-muted">Silahkan tambah agenda baru atau sesuaikan filter pencarian.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-3">
                    {{ $agenda_kegiatan->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<x-modal-form id="mdlAgendaKegiatan" size="" show="loadAgendaKegiatan" title="" />

@endsection
@push('myscript')
{{-- <script src="{{ asset('assets/js/pages/roles/create.js') }}"></script> --}}
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
<script>
    $(function() {
        $("#btncreateAgendaKegiatan").click(function(e) {
            e.preventDefault();
            $('#mdlAgendaKegiatan').modal("show");
            $("#mdlAgendaKegiatan").find(".modal-title").text("Tambah Agenda Kegiatan");
            $("#loadAgendaKegiatan").load('/agendakegiatan/create');
        });

        $(".btnEdit").click(function(e) {
            var id = $(this).attr("id");
            e.preventDefault();
            $('#mdlAgendaKegiatan').modal("show");
            $("#mdlAgendaKegiatan").find(".modal-title").text("Edit Agenda Kegiatan");
            $("#loadAgendaKegiatan").load('/agendakegiatan/' + id + '/edit');
        });
    });
</script>
@endpush

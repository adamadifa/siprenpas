@extends('layouts.app')
@section('titlepage', 'Pendaftaran Online')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-world fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Data Pendaftaran Online</h4>
                        <p class="text-muted mb-0 small">Manajemen pendaftaran siswa via website</p>
                    </div>
                </div>
                <div class="d-flex flex-column align-items-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mb-0">
                            <li class="breadcrumb-item">
                                <a href="javascript:void(0);" class="text-muted">
                                    <i class="ti ti-school me-1"></i> Akademik
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                <i class="ti ti-world me-1"></i> Pendaftaran Online
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        
        <!-- Modern Statistics Section -->
        @if (auth()->user()->kode_unit == 'U06')
            <div class="card shadow-sm border-0 mb-4 overflow-hidden">
                <div class="card-body p-0">
                    <div class="d-flex align-items-center flex-nowrap overflow-x-auto py-4 px-2" style="scrollbar-width: none; -ms-overflow-style: none;">
                        @forelse ($rekap_unit as $r)
                            <div class="stat-item flex-grow-1 px-4 {{ !$loop->last ? 'border-end' : '' }}" style="min-width: 200px;">
                                <div class="text-uppercase text-muted fw-bold mb-1" style="font-size: 0.7rem; letter-spacing: 0.5px;">
                                    {{ $r->nama_unit }}
                                </div>
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <h3 class="mb-0 fw-bold text-dark" style="font-size: 1.75rem;">
                                        {{ number_format($r->jumlah, 0, ',', '.') }}
                                    </h3>
                                    <span class="badge bg-label-success rounded-pill px-2" style="font-size: 0.65rem;">
                                        <i class="ti ti-device-laptop me-1" style="font-size: 0.75rem;"></i>{{ $r->jumlah > 0 ? 'Online' : '0' }}
                                    </span>
                                </div>
                                <div class="text-muted small d-flex align-items-center gap-1">
                                    <span class="small">Total Pendaftar Online</span>
                                </div>
                            </div>
                        @empty
                            <div class="p-4 w-100 text-center text-muted">Belum ada data unit</div>
                        @endforelse
                    </div>
                </div>
            </div>
        @endif

        <!-- Filter Section -->
        <div class="card mb-4 shadow-none border-0 bg-transparent">
            <div class="card-body p-0">
                <form action="{{ route('pendaftaranonline.index') }}">
                    <div class="row g-3 align-items-center">
                        @php
                            $isU06 = auth()->user()->kode_unit == 'U06';
                        @endphp
                        
                        <div class="{{ $isU06 ? 'col-lg-3' : 'col-lg-4' }} col-md-6">
                            <x-input-with-icon label="" value="{{ Request('nama_lengkap') }}" name="nama_lengkap"
                                placeholder="Cari Nama Siswa" icon="ti ti-search" />
                        </div>

                        @if ($isU06)
                            <div class="col-lg-3 col-md-6">
                                <div class="form-group">
                                    <select name="kode_unit" id="kode_unit_search" class="form-select border-0 shadow-sm border" style="border-color: #e0e0e0 !important;">
                                        <option value="">Semua Unit</option>
                                        @foreach ($unit as $d)
                                            <option value="{{ $d->kode_unit }}" {{ Request('kode_unit') == $d->kode_unit ? 'selected' : '' }}>
                                                {{ $d->nama_unit }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif

                        <div class="col-lg-2 col-md-6">
                            <div class="form-group">
                                <select name="kode_ta" id="kode_ta_search" class="form-select border-0 shadow-sm border" style="border-color: #e0e0e0 !important;">
                                    <option value="">Pilih Tahun Ajaran</option>
                                    @foreach ($tahunajaran as $d)
                                        <option value="{{ $d->kode_ta }}"
                                            {{ (Request('kode_ta') ?? $kode_ta) == $d->kode_ta ? 'selected' : '' }}>
                                            {{ $d->tahun_ajaran }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="d-flex gap-2">
                                <button class="btn btn-primary flex-grow-1 p-2 d-flex align-items-center justify-content-center gap-2" style="background-color: #064e3b; border-color: #064e3b">
                                    <i class="ti ti-search fs-5"></i>
                                    <span>Cari</span>
                                </button>
                                <button type="submit" class="btn btn-label-success flex-grow-1 p-2 d-flex align-items-center justify-content-center gap-2" formaction="{{ route('pendaftaranonline.export') }}">
                                    <i class="ti ti-file-spreadsheet fs-5"></i>
                                    <span>Export Excel</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table Data -->
        <div class="card shadow-sm">
            <div class="card-header d-flex align-items-center gap-2 text-white py-3" style="background-color: #064e3b">
                <i class="ti ti-layout-grid fs-5"></i>
                <h6 class="card-title mb-0 text-white">Data Pendaftaran Online</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background-color: #064e3b">
                            <tr>
                                <th class="text-white py-3">NO.</th>
                                <th class="text-white py-3">FOTO</th>
                                <th class="text-white py-3 text-nowrap">NO. REGISTER</th>
                                <th class="text-white py-3">TANGGAL</th>
                                <th class="text-white py-3">NAMA LENGKAP</th>
                                <th class="text-white py-3">J. KELAMIN</th>
                                <th class="text-white py-3">UNIT</th>
                                <th class="text-white py-3">STATUS</th>
                                <th class="text-white py-3 text-end" style="width: 120px;">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pendaftaran as $d)
                                <tr>
                                    <td class="py-1">{{ $loop->iteration }}</td>
                                    <td class="py-1">
                                        @if ($d->foto_pendaftaran && Storage::disk('public')->exists('photos/pendaftaran/' . $d->foto_pendaftaran))
                                            <div class="avatar avatar-md border rounded overflow-hidden shadow-sm" style="width: 40px; height: 50px;">
                                                <img src="{{ asset('storage/photos/pendaftaran/' . $d->foto_pendaftaran) }}" alt="Foto" style="width: 100%; height: 100%; object-fit: cover;">
                                            </div>
                                        @else
                                            <div class="avatar avatar-md d-flex align-items-center justify-content-center bg-label-secondary border rounded shadow-none" style="width: 40px; height: 50px;">
                                                <i class="ti ti-user fs-4 opacity-50"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="py-1"><span class="fw-bold">{{ $d->no_register }}</span></td>
                                    <td class="py-1">{{ date('d-m-Y', strtotime($d->tanggal_register)) }}</td>
                                    <td class="py-1">
                                        <div class="fw-bold text-dark text-nowrap">{{ $d->nama_lengkap }}</div>
                                        <div class="small text-muted">{{ !empty($d->tanggal_lahir) ? DateToIndo($d->tanggal_lahir) : '-' }}</div>
                                    </td>
                                    <td class="py-1">
                                        @if($d->jenis_kelamin == 'L')
                                            <span class="badge bg-label-info">Laki-laki</span>
                                        @else
                                            <span class="badge bg-label-danger">Perempuan</span>
                                        @endif
                                    </td>
                                    <td class="py-1">
                                        <div class="fw-bold">{{ $d->nama_unit }}</div>
                                        <div class="small text-muted">{{ $d->tahun_ajaran }}</div>
                                    </td>
                                    <td class="py-1">
                                        @if (!empty($d->no_pendaftaran))
                                            <span class="badge bg-label-success">
                                                <i class="ti ti-checks me-1"></i>Terverifikasi
                                            </span>
                                        @else
                                            @if (!empty($d->id_bayar))
                                                <span class="badge bg-label-warning">Sudah Konfirmasi</span>
                                            @else
                                                <span class="badge bg-label-danger">Belum Konfirmasi</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="py-1 text-end">
                                        <div class="d-flex justify-content-end gap-1">
                                            @can('pendaftaranonline.edit')
                                                <a href="#" class="btn btn-icon btn-label-success border btnEdit shadow-none"
                                                    style="width: 28px; height: 28px;"
                                                    no_register="{{ Crypt::encrypt($d->no_register) }}" data-bs-toggle="tooltip" title="Edit Data">
                                                    <i class="ti ti-edit fs-6"></i>
                                                </a>
                                            @endcan
                                            @can('pendaftaranonline.show')
                                                <a href="#" class="btn btn-icon btn-label-info border btnShow shadow-none"
                                                    style="width: 28px; height: 28px;"
                                                    no_register="{{ Crypt::encrypt($d->no_register) }}" data-bs-toggle="tooltip" title="Detail Data">
                                                    <i class="ti ti-file-description fs-6"></i>
                                                </a>
                                            @endcan
                                            @can('pendaftaranonline.delete')
                                                @if (empty($d->no_pendaftaran))
                                                    <form method="POST" class="deleteform d-inline" action="/pendaftaranonline/{{ Crypt::encrypt($d->no_register) }}/delete">
                                                        @csrf
                                                        @method('DELETE')
                                                        <a href="#" class="btn btn-icon btn-label-danger border delete-confirm shadow-none"
                                                            style="width: 28px; height: 28px;" data-bs-toggle="tooltip" title="Hapus Data">
                                                            <i class="ti ti-trash fs-6"></i>
                                                        </a>
                                                    </form>
                                                @endif
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center p-5">
                                        <div class="mb-3">
                                            <i class="ti ti-world fs-1 opacity-25"></i>
                                        </div>
                                        <h5>Belum Ada Data Pendaftaran Online</h5>
                                        <p class="text-muted small">Silahkan sesuaikan filter atau cek kembali nanti.</p>
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

<x-modal-form id="modal" size="modal-lg" show="loadmodal" title="" icon="ti ti-world" />

@endsection

@push('myscript')
<script>
    $(function() {
        $(document).on('show.bs.modal', '.modal', function() {
            const zIndex = 1090 + 10 * $('.modal:visible').length;
            $(this).css('z-index', zIndex);
            setTimeout(() => $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1)
                .addClass('modal-stack'));
        });

        const loading = `<div class="sk-wave sk-primary" style="margin:auto">
            <div class="sk-wave-rect"></div>
            <div class="sk-wave-rect"></div>
            <div class="sk-wave-rect"></div>
            <div class="sk-wave-rect"></div>
            <div class="sk-wave-rect"></div>
            </div>`;

        $(".btnEdit").click(function(e) {
            e.preventDefault();
            const no_register = $(this).attr("no_register");
            $("#modal").modal("show");
            $("#modal").find("#loadmodal").html(loading);
            $("#modal").find(".modal-title").text("Edit Pendaftaran Online");
            $("#loadmodal").load(`/pendaftaranonline/${no_register}/edit`, function() {
                if (typeof flatpickr !== 'undefined') {
                    $(".flatpickr-date").flatpickr();
                }
            });
        });

        $(".btnShow").click(function(e) {
            e.preventDefault();
            const no_register = $(this).attr("no_register");
            $("#modal").modal("show");
            $("#modal").find("#loadmodal").html(loading);
            $("#modal").find(".modal-title").text("Detail Pendaftaran Online");
            $("#loadmodal").load(`/pendaftaranonline/${no_register}/show`);
        });

        // Konfirmasi Delete
        $(".delete-confirm").click(function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data pendaftaran online akan dihapus permanen!",
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

        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>
@endpush

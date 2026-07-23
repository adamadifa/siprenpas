@extends('layouts.app')
@section('titlepage', 'Pembayaran Pendidikan')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-moneybag fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Pembayaran Pendidikans</h4>
                        <p class="text-muted mb-0 small">Manajemen pembayaran SPP dan biaya lainnya</p>
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
                                <i class="ti ti-moneybag me-1"></i> Pembayaran
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

<!-- Filter Section -->
<div class="mb-4">
    <form action="{{ route('pembayaranpendidikan.index') }}">
        <div class="row g-2">
            <div class="col-lg-3 col-md-6 col-12">
                <x-input-with-icon label="" placeholder="Cari Nama Siswa" value="{{ Request('nama_lengkap') }}"
                    name="nama_lengkap" icon="ti ti-search" />
            </div>
            <div class="col-lg-2 col-md-6 col-12">
                <select name="kode_unit" id="kode_unit_search" class="form-select">
                    <option value="">Unit</option>
                    @foreach ($unit as $d)
                        <option value="{{ $d->kode_unit }}"
                            {{ Request('kode_unit') == $d->kode_unit ? 'selected' : '' }}>
                            {{ $d->nama_unit }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-2 col-md-6 col-12">
                <select name="tingkat" id="tingkat" class="form-select">
                    <option value="">Tingkat</option>
                </select>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <select name="kode_ta" id="kode_ta_search" class="form-select">
                    <option value="">Tahun Ajaran</option>
                    @foreach ($tahunajaran as $d)
                        <option value="{{ $d->kode_ta }}"
                            @if (!empty(Request('kode_ta'))) @if (Request('kode_ta') == $d->kode_ta)
                                    selected @endif
                        @else @if ($kode_ta == $d->kode_ta) selected @endif
                            @endif
                            >
                            {{ $d->tahun_ajaran }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-2 col-md-12 col-12">
                <button class="btn shadow-sm d-flex align-items-center justify-content-center gap-2 text-white w-100" 
                    style="background-color: #064e3b; height: 38px;">
                    <i class="ti ti-search fs-5"></i> Cari
                </button>
            </div>
        </div>
    </form>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header d-flex align-items-center justify-content-between text-white py-3" style="background-color: #064e3b">
                <div class="d-flex align-items-center gap-2">
                    <i class="ti ti-list fs-5"></i>
                    <h6 class="card-title mb-0 text-white">Data Siswa & Status Pembayaran</h6>
                </div>
                @php
                    $anyCanPromote = false;
                    foreach ($pendaftaran as $d) {
                        if ($d->kode_ta != optional($ta_ppdb)->kode_ta && $d->status_naik_kelas != 1) {
                            $anyCanPromote = true;
                            break;
                        }
                    }
                @endphp
                @if ($anyCanPromote)
                    <button type="button" class="btn btn-sm btn-warning" id="btnBulkNaikKelas">
                        <i class="ti ti-arrow-up me-1"></i> Naik Kelas Massal
                    </button>
                @endif
            </div>
            <div class="card-body p-0">
                <style>
                    .table-sticky {
                        border-collapse: separate;
                        border-spacing: 0;
                    }
                    .table-sticky tbody tr {
                        background-color: #ffffff;
                    }
                    .table-sticky thead tr {
                        background-color: #064e3b;
                    }
                    .table-sticky thead th {
                        background-color: #064e3b !important;
                        color: #fff !important;
                    }
                    
                    /* Explicit solid background-color for sticky columns */
                    .table-sticky td.sticky-col-left-1,
                    .table-sticky td.sticky-col-left-2,
                    .table-sticky td.sticky-col-left-3,
                    .table-sticky td.sticky-col-left-4,
                    .table-sticky td.sticky-col-left-5,
                    .table-sticky td.sticky-col-left-6,
                    .table-sticky td.sticky-col-right {
                        background-color: #ffffff !important;
                    }

                    /* Hover states */
                    .table-sticky tbody tr:hover td {
                        background-color: #f8f9fa !important;
                    }

                    /* Row danger / inactive status states */
                    .table-sticky tr.row-danger td {
                        background-color: #fef5f5 !important;
                    }
                    .table-sticky tr.row-danger td.sticky-col-left-1,
                    .table-sticky tr.row-danger td.sticky-col-left-2,
                    .table-sticky tr.row-danger td.sticky-col-left-3,
                    .table-sticky tr.row-danger td.sticky-col-left-4,
                    .table-sticky tr.row-danger td.sticky-col-left-5,
                    .table-sticky tr.row-danger td.sticky-col-left-6,
                    .table-sticky tr.row-danger td.sticky-col-right {
                        background-color: #fef5f5 !important;
                    }

                    /* Row danger hover states */
                    .table-sticky tr.row-danger:hover td {
                        background-color: #fde8e8 !important;
                    }
                    
                    .sticky-col-left-1 { position: sticky; left: 0; z-index: 2; width: 45px; min-width: 45px; max-width: 45px; }
                    .sticky-col-left-2 { position: sticky; left: 45px; z-index: 2; width: 45px; min-width: 45px; max-width: 45px; }
                    .sticky-col-left-3 { position: sticky; left: 90px; z-index: 2; width: 140px; min-width: 140px; max-width: 140px; }
                    .sticky-col-left-4 { position: sticky; left: 230px; z-index: 2; width: 90px; min-width: 90px; max-width: 90px; }
                    .sticky-col-left-5 { position: sticky; left: 320px; z-index: 2; width: 95px; min-width: 95px; max-width: 95px; }
                    .sticky-col-left-6 { 
                        position: sticky; 
                        left: 415px; 
                        z-index: 2; 
                        width: 300px; 
                        min-width: 300px; 
                        max-width: 300px; 
                    }
                    .sticky-col-right { position: sticky; right: 0; z-index: 2; width: 120px; min-width: 120px; max-width: 120px; border-left: 1px solid #e0e0e0; }
                    
                    .table-sticky thead th.sticky-col-left-1,
                    .table-sticky thead th.sticky-col-left-2,
                    .table-sticky thead th.sticky-col-left-3,
                    .table-sticky thead th.sticky-col-left-4,
                    .table-sticky thead th.sticky-col-left-5,
                    .table-sticky thead th.sticky-col-left-6,
                    .table-sticky thead th.sticky-col-right {
                        z-index: 3;
                    }
                </style>
                <div class="table-responsive">
                    <form action="{{ route('pembayaranpendidikan.bulknaikkelas') }}" method="POST" id="formBulkNaikKelas">
                        @csrf
                        <table class="table table-hover mb-0 text-nowrap table-sticky">
                        <thead style="background-color: #064e3b">
                            <tr>
                                <th class="text-white py-3 sticky-col-left-1">
                                    <input type="checkbox" class="form-check-input" id="checkAll">
                                </th>
                                <th class="text-white py-3 sticky-col-left-2">NO.</th>
                                <th class="text-white py-3 sticky-col-left-3">NO. PENDAFTARAN</th>
                                <th class="text-white py-3 sticky-col-left-4">ID SISWA</th>
                                <th class="text-white py-3 sticky-col-left-5">NIS</th>
                                <th class="text-white py-3 sticky-col-left-6">NAMA LENGKAP</th>
                                <th class="text-white py-3">TIPE BIAYA</th>
                                <th class="text-white py-3">UNIT</th>
                                <th class="text-white py-3">TNGKT</th>
                                <th class="text-white py-3">KELAS</th>
                                <th class="text-white py-3">STATUS</th>
                                <th class="text-white py-3 text-end sticky-col-right" style="width: 100px;">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pendaftaran as $d)
                                <tr class="@if(in_array($d->status_siswa, [3, 4, 5])) row-danger @endif">
                                    <td class="py-1 text-center sticky-col-left-1">
                                        @if ($d->kode_ta != optional($ta_ppdb)->kode_ta && $d->status_naik_kelas != 1 && $d->status_siswa == 1)
                                            <input type="checkbox" name="no_pendaftaran[]" value="{{ $d->no_pendaftaran }}" class="form-check-input checkItem">
                                        @elseif($d->status_naik_kelas == 1)
                                            <i class="ti ti-arrow-up text-success fs-4" data-bs-toggle="tooltip" title="Sudah Naik Kelas"></i>
                                        @endif
                                    </td>
                                    <td class="py-1 sticky-col-left-2">{{ $loop->iteration + ($pendaftaran->currentPage() - 1) * $pendaftaran->perPage() }}</td>
                                    <td class="py-1 sticky-col-left-3">{{ $d->no_pendaftaran }}</td>
                                    <td class="py-1 sticky-col-left-4">{{ $d->id_siswa }}</td>
                                    <td class="py-1 sticky-col-left-5">{{ $d->nis }}</td>
                                    <td class="py-1 sticky-col-left-6">
                                        <div class="fw-bold">{{ $d->nama_lengkap }}</div>
                                    </td>
                                    <td class="py-1">
                                        @if($d->asrama == 1)
                                            <span class="badge bg-label-primary">Asrama {{ $d->is_pindahan == 1 ? '(Pindahan)' : '' }}</span>
                                        @else
                                            <span class="badge bg-label-success">Reguler {{ $d->is_pindahan == 1 ? '(Pindahan)' : '' }}</span>
                                        @endif
                                    </td>
                                    <td class="py-1">{{ $d->nama_unit }}</td>
                                    <td class="py-1">{{ $d->tingkat }}</td>
                                    <td class="py-1">{{ $d->nama_kelas }}</td>
                                    <td class="py-1">
                                        @if($d->status_siswa == 1)
                                            <span class="badge bg-label-success">Aktif</span>
                                        @elseif($d->status_siswa == 2)
                                            <span class="badge bg-label-info">Lulus / Naik</span>
                                        @elseif($d->status_siswa == 3)
                                            <span class="badge bg-label-danger" data-bs-toggle="tooltip" title="Alasan: {{ $d->alasan_keluar }}">Mengundurkan Diri</span>
                                        @elseif($d->status_siswa == 4)
                                            <span class="badge bg-label-danger" data-bs-toggle="tooltip" title="Alasan: {{ $d->alasan_keluar }}">Pindah</span>
                                        @elseif($d->status_siswa == 5)
                                            <span class="badge bg-label-danger" data-bs-toggle="tooltip" title="Alasan: {{ $d->alasan_keluar }}">Dikeluarkan</span>
                                        @endif
                                    </td>
                                    <td class="py-1 text-end sticky-col-right">
                                        <div class="d-flex justify-content-end gap-1">
                                            @can('pembayaranpdd.show')
                                                <a href="#" class="btn btn-icon btn-label-info border btnShow"
                                                    no_pendaftaran="{{ Crypt::encrypt($d->no_pendaftaran) }}"
                                                    style="width: 28px; height: 28px;">
                                                    <i class="ti ti-moneybag fs-6"></i>
                                                </a>
                                            @endcan
                                            @if ($d->kode_ta != optional($ta_ppdb)->kode_ta)
                                                @if ($d->status_naik_kelas == 1)
                                                    <a href="{{ route('pembayaranpendidikan.batalkannaikkelas', Crypt::encrypt($d->no_pendaftaran)) }}"
                                                        class="btn btn-icon btn-label-danger border"
                                                        style="width: 28px; height: 28px;"
                                                        onclick="return confirm('Apakah Anda yakin ingin membatalkan kenaikan kelas ini?')">
                                                        <i class="ti ti-arrow-back-up fs-6"></i>
                                                    </a>
                                                @else
                                                    <a href="#"
                                                        class="btn btn-icon btn-label-warning border btnNaikKelasTrigger"
                                                        no_pendaftaran="{{ Crypt::encrypt($d->no_pendaftaran) }}"
                                                        style="width: 28px; height: 28px;"
                                                        data-bs-toggle="tooltip" title="Proses Naik Kelas">
                                                        <i class="ti ti-arrow-up fs-6"></i>
                                                    </a>
                                                @endif
                                            @endif

                                            {{-- Tombol Aksi Keluar --}}
                                            @if($d->status_siswa == 1)
                                                <a href="#" class="btn btn-icon btn-label-danger border btnProsesKeluarTabel"
                                                    no_pendaftaran="{{ Crypt::encrypt($d->no_pendaftaran) }}"
                                                    style="width: 28px; height: 28px;"
                                                    data-bs-toggle="tooltip" title="Proses Siswa Keluar">
                                                    <i class="ti ti-user-x fs-6"></i>
                                                </a>
                                            @elseif(in_array($d->status_siswa, [3, 4, 5]))
                                                <form action="{{ route('pembayaranpendidikan.batalkankeluar', Crypt::encrypt($d->no_pendaftaran)) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan status keluar siswa ini?')">
                                                    @csrf
                                                    <button type="submit" class="btn btn-icon btn-label-warning border"
                                                        style="width: 28px; height: 28px;"
                                                        data-bs-toggle="tooltip" title="Batalkan Keluar">
                                                        <i class="ti ti-rotate-clockwise fs-6"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        </table>
                    </form>
                </div>
            </div>
            <div class="card-footer px-4 py-3">
                <div style="float: right;">
                    {{ $pendaftaran->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
<x-modal-form id="modal" size="modal-xl" show="loadmodal" title="" />
<x-modal-form id="modalpotongan" size="" show="loadmodalpotongan" title="" />
<x-modal-form id="modalmutasi" size="" show="loadmodalmutasi" title="" />
<x-modal-form id="modalrencanaspp" size="" show="loadmodalrencanaspp" title="" />
<x-modal-form id="modaleditrencanaspp" size="" show="loadeditrencanaspp" title="" />
<x-modal-form id="modalpembayaran" size="modal-lg" show="loadmodalpembayaran" title="" />
<x-modal-form id="modalDetailbayar" size="modal-lg" show="loaddetailbayar" title="" />
<x-modal-form id="modaleditbiaya" size="" show="loadeditbiaya" title="" />

<!-- Modal Proses Keluar Tabel -->
<div class="modal fade" id="modalProsesKeluarTabel" tabindex="-1" aria-hidden="true" style="z-index: 1150;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Proses Siswa Keluar / Mengundur Diri</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" id="formProsesKeluarTabel">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Status Siswa Baru <span class="text-danger">*</span></label>
                        <select name="status_siswa" class="form-select" required>
                            <option value="3">Mengundurkan Diri</option>
                            <option value="4">Pindah Sekolah</option>
                            <option value="5">Dikeluarkan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tanggal Keluar <span class="text-danger">*</span></label>
                        <input type="text" name="tanggal_keluar" id="tanggal_keluar" class="form-control flatpickr-date" value="{{ date('Y-m-d') }}" required placeholder="Pilih Tanggal">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Alasan Keluar <span class="text-danger">*</span></label>
                        <textarea name="alasan_keluar" class="form-control" rows="3" required placeholder="Tuliskan alasan detail siswa keluar..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Pilihan Biaya Naik Kelas -->
<div class="modal fade" id="modalPilihanBiayaNaikKelas" tabindex="-1" aria-hidden="true" style="z-index: 1160;">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white py-3">
                <h5 class="modal-title text-white">Pilih Konfigurasi Biaya Tingkat Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info py-2 small d-flex align-items-center mb-4">
                    <i class="ti ti-info-circle fs-4 me-2"></i>
                    <div>
                        Siswa <strong id="naik-kelas-nama-siswa">Siswa</strong> akan dinaikkan ke <strong>Tingkat <span id="naik-kelas-tingkat-baru">X</span></strong>. 
                        Silakan pilih salah satu opsi biaya di bawah untuk melanjutkan.
                    </div>
                </div>
                <div class="row" id="container-pilihan-biaya">
                    <!-- Cards will be loaded here via Ajax -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('myscript')
<script>
    $(function() {
        let currentNaikKelasNoPendaftaran = '';

        // Handle Klik Tombol Naik Kelas (Cek Biaya)
        $(document).on('click', '.btnNaikKelasTrigger', function(e) {
            e.preventDefault();
            var no_pendaftaran = $(this).attr('no_pendaftaran');
            currentNaikKelasNoPendaftaran = no_pendaftaran;

            Swal.fire({
                title: 'Loading...',
                text: 'Memeriksa konfigurasi biaya...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: `/pembayaranpendidikan/${no_pendaftaran}/cekbiayanext`,
                type: 'GET',
                success: function(response) {
                    Swal.close();
                    if (response.success) {
                        if (response.count === 1) {
                            // If only 1 biaya exists, ask for simple confirmation and process
                            Swal.fire({
                                title: 'Konfirmasi',
                                text: `Yakin ingin menaikkan ${response.nama_siswa} ke tingkat ${response.tingkat_baru}?`,
                                icon: 'question',
                                showCancelButton: true,
                                confirmButtonColor: '#064e3b',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Ya, Proses!'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    execNaikKelas(no_pendaftaran, response.html); // response.html in this case holds nothing or default, we can trigger simpannaikkelas with the only code
                                    // Actually, let's extract code_biaya from button in response.html or we can call the original route.
                                    window.location.href = `/pembayaranpendidikan/${no_pendaftaran}/prosesnaikkelas`;
                                }
                            });
                        } else {
                            // If multiple biaya exist, show the modal with cards
                            $('#naik-kelas-nama-siswa').text(response.nama_siswa);
                            $('#naik-kelas-tingkat-baru').text(response.tingkat_baru);
                            $('#container-pilihan-biaya').html(response.html);
                            $('#modalPilihanBiayaNaikKelas').modal('show');
                        }
                    }
                },
                error: function(xhr) {
                    Swal.close();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON ? xhr.responseJSON.message : 'Gagal memproses data.'
                    });
                }
            });
        });

        // Handle Pemilihan Biaya pada Card
        $(document).on('click', '.btnPilihBiayaNaikKelas', function(e) {
            e.preventDefault();
            var kode_biaya = $(this).data('kode-biaya');

            Swal.fire({
                title: 'Sedang diproses...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: `/pembayaranpendidikan/${currentNaikKelasNoPendaftaran}/simpannaikkelas`,
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    kode_biaya: kode_biaya
                },
                success: function(response) {
                    Swal.close();
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                        }).then(() => {
                            $('#modalPilihanBiayaNaikKelas').modal('hide');
                            window.location.reload();
                        });
                    }
                },
                error: function(xhr) {
                    Swal.close();
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: xhr.responseJSON ? xhr.responseJSON.message : 'Terjadi kesalahan sistem.'
                    });
                }
            });
        });

        // Initialize flatpickr on date field
        $(".flatpickr-date").flatpickr({
            altInput: true,
            altFormat: "d F Y",
            dateFormat: "Y-m-d",
            defaultDate: "today"
        });

        $(document).on('click', '.btnProsesKeluarTabel', function(e) {
            e.preventDefault();
            var no_pendaftaran = $(this).attr('no_pendaftaran');
            $('#formProsesKeluarTabel').attr('action', `/pembayaranpendidikan/${no_pendaftaran}/proses-keluar`);
            $('#modalProsesKeluarTabel').modal('show');
        });

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


        $('.btnShow').click(function(e) {
            e.preventDefault();
            var no_pendaftaran = $(this).attr('no_pendaftaran');
            $("#modal").modal("show");
            $("#modal").find("#loadmodal").html(loading);
            $.ajax({
                url: `/pembayaranpendidikan/${no_pendaftaran}/show`,
                type: 'GET',
                success: function(response) {

                    $('#loadmodal').html(response);
                    getbiaya(no_pendaftaran);
                    getrencanaspp(no_pendaftaran);
                    gethistoribayar(no_pendaftaran);

                },
                error: function(error) {
                    console.error('Error loading modal content', error);
                }
            });
            // $("#modal").modal("show");
            // $("#modal").find("#loadmodal").html(loading);
            // $("#modal").find(".modal-title").text("Data Pembayaran Pendidikan");
            // $("#loadmodal").load(`/pembayaranpendidikan/${no_pendaftaran}/show`);
            // getbiaya(no_pendaftaran);

        });



        function getbiaya(no_pendaftaran) {
            // $(document).find(".tabelbiaya").html(`<tr>
            //     <td colspan="12" class="text-center">
            //         Loading...
            //     </td>
            // </tr>`);
            $.ajax({
                type: 'GET',
                url: `/pembayaranpendidikan/${no_pendaftaran}/getbiaya`,
                cache: false,
                success: function(res) {
                    $(document).find(".tabelbiaya").html(res);
                }
            });
        }

        $(document).on('click', '.inputpotongan', function(e) {
            const no_pendaftaran = $(this).attr('no_pendaftaran');
            const kode_biaya = $(this).attr('kode_biaya');
            const kode_jenis_biaya = $(this).attr('kode_jenis_biaya');
            const jenis_biaya = $(this).attr('jenis_biaya');
            // alert(no_pendaftaran);
            $("#modalpotongan").modal("show");
            $("#modalpotongan").find("#loadmodalpotongan").html(loading);
            $("#modalpotongan").find(".modal-title").text("Input Potongan Biaya " + jenis_biaya);
            $("#loadmodalpotongan").load(
                `/pembayaranpendidikan/${no_pendaftaran}/${kode_jenis_biaya}/${kode_biaya}/inputpotongan`
            );
        });


        $(document).on('submit', '#formPotongan', function(e) {
            e.preventDefault();
            const data = $(this).serialize();
            const potongan = $(this).find("#potongan").val();
            const keterangan = $(this).find("#keterangan").val();

            if (potongan == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Potongan tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#potongan").focus();
                    }
                });
                return false;
            } else if (keterangan == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Keterangan tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#keterangan").focus();
                    }
                });
                return false;
            } else {
                $(this).find('button[type="submit"]').prop('disabled', true);
                $(this).find('button[type="submit"]').html(
                    '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Loading...'
                );

                $.ajax({
                    url: "{{ route('pembayaranpendidikan.storepotongan') }}",
                    type: "POST",
                    data: data,
                    cache: false,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                        });
                        getbiaya(response.no_pendaftaran);
                        $("#modalpotongan").modal("hide");
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: "Error!",
                            text: xhr.responseJSON.message,
                            icon: "error",
                            showConfirmButton: true,
                            didClose: (e) => {
                                $(document).find('#formPotongan').find(
                                    'button[type="submit"]').prop(
                                    'disabled', false);
                                $(document).find('#formPotongan').find(
                                    'button[type="submit"]').html(
                                    '<i class="ti ti-send me-2"></i> Submit'
                                );
                            }
                        });


                    }

                });
            }
        });


        $(document).on('click', '.inputmutasi', function(e) {
            const no_pendaftaran = $(this).attr('no_pendaftaran');
            const kode_jenis_biaya = $(this).attr('kode_jenis_biaya');
            const jenis_biaya = $(this).attr('jenis_biaya');
            const kode_biaya = $(this).attr('kode_biaya');
            // alert(no_pendaftaran);
            $("#modalmutasi").modal("show");
            $("#modalmutasi").find("#loadmodalmutasi").html(loading);
            $("#modalmutasi").find(".modal-title").text("Input Mutasi Biaya " + jenis_biaya);
            $("#loadmodalmutasi").load(
                `/pembayaranpendidikan/${no_pendaftaran}/${kode_jenis_biaya}/${kode_biaya}/inputmutasi`
            );
        });


        $(document).on('submit', '#formMutasi', function(e) {
            e.preventDefault();
            const data = $(this).serialize();
            const jumlah = $(this).find("#jumlah").val();
            const keterangan = $(this).find("#keterangan").val();

            if (jumlah == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Jumlah Mutasi tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#jumlah").focus();
                    }
                });
                return false;
            } else if (keterangan == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Keterangan tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#keterangan").focus();
                    }
                });
                return false;
            } else {
                $(this).find('button[type="submit"]').prop('disabled', true);
                $(this).find('button[type="submit"]').html(
                    '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Loading...'
                );

                $.ajax({
                    url: "{{ route('pembayaranpendidikan.storemutasi') }}",
                    type: "POST",
                    data: data,
                    cache: false,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                        });
                        getbiaya(response.no_pendaftaran);
                        $("#modalmutasi").modal("hide");
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: "Error!",
                            text: xhr.responseJSON.message,
                            icon: "error",
                            showConfirmButton: true,
                            didClose: (e) => {
                                $(document).find('#formMutasi').find(
                                    'button[type="submit"]').prop(
                                    'disabled', false);
                                $(document).find('#formMutasi').find(
                                    'button[type="submit"]').html(
                                    '<i class="ti ti-send me-2"></i> Submit'
                                );
                            }
                        });


                    }

                });
            }
        });


        $(document).on('click', '#buatrencanaspp', function(e) {
            e.preventDefault();
            const no_pendaftaran = $(this).attr('no_pendaftaran');
            $("#modalrencanaspp").modal("show");
            $("#modalrencanaspp").find("#loadmodalrencanaspp").html(loading);
            $("#modalrencanaspp").find(".modal-title").text("Buat Rencana SPP");
            $("#loadmodalrencanaspp").load(`/rencanaspp/${no_pendaftaran}/create`);
        });


        $(document).on('click', '#btnBayar', function(e) {
            e.preventDefault();
            const no_pendaftaran = $(this).attr('no_pendaftaran');
            $("#modalpembayaran").modal("show");
            $("#modalpembayaran").find("#loadmodalpembayaran").html(loading);
            $("#modalpembayaran").find(".modal-title").text("Pembayaran");
            $("#loadmodalpembayaran").load(`/pembayaranpendidikan/${no_pendaftaran}/create`);

        });

        function toNumber(value) {
            let cleanValue = value.replace(/\./g, '');
            return cleanValue;
        }


        $(document).on('submit', '#formBuatrencanaspp', function(e) {
            e.preventDefault();
            let kode_biaya = $(this).find("#kode_biaya").val();
            let mulai_pembayaran = $(this).find("#mulai_pembayaran").val();
            let jumlah_spp = toNumber($(this).find("#jumlah_spp").val());
            let jumlah_spp_perbulan = $(this).find("#jumlah_spp_perbulan").val();
            let jumlah_bulan = $(this).find("#jumlah_bulan").val();

            let no_pendaftaran = $(this).find("#no_pendaftaran").val();

            if (kode_biaya == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Tahun Ajaran Harus Dipilih!',
                    didClose: (e) => {
                        $(this).find("#kode_biaya").focus();
                    }
                });
                return false;
            } else if (mulai_pembayaran == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Mulai Pembayaran tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#mulai_pembayaran").focus();
                    }
                });
                return false;
            } else if (jumlah_spp_perbulan == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Jumlah SPP Perbulan tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#jumlah_spp_perbulan").focus();
                    }
                });
                return false;
            } else {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('rencanaspp.store') }}",
                    data: $(this).serialize(),
                    cache: false,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                            didClose: (e) => {
                                getrencanaspp(response.no_pendaftaran);
                            }
                        });
                    },

                    error: function(xhr) {
                        Swal.fire({
                            title: "Error!",
                            text: xhr.responseJSON.message,
                            icon: "error",
                            showConfirmButton: true,
                            didClose: (e) => {

                            }
                        });
                    }
                });
            }
        });

        function getrencanaspp(no_pendaftaran) {
            $.ajax({
                type: 'GET',
                url: `/rencanaspp/${no_pendaftaran}/getrencanaspp`,
                cache: false,
                success: function(res) {
                    $(document).find("#tabelrencanaspp").html(res);
                }
            })
        }

        $(document).on('click', '.editrencanaspp', function(e) {
            e.preventDefault();
            let kode_rencana_spp = $(this).attr('kode_rencana_spp');
            $("#modalrencanaspp").modal("show");
            $("#modalrencanaspp").find("#loadmodalrencanaspp").html(loading);
            $("#modalrencanaspp").find(".modal-title").text("Edit Rencana SPP");
            $("#loadmodalrencanaspp").load(`/rencanaspp/${kode_rencana_spp}/edit`);
        });

        $(document).on('submit', '#formEditrencanaspp', function(e) {
            e.preventDefault();
            let tagihanspppertahun = $(this).find("#tagihanspppertahun").text().replace(/[^0-9]/g, '');
            let totalspppertahun = $(this).find("#totalspppertahun").text().replace(/[^0-9]/g, '');
            if (parseInt(tagihanspppertahun) != parseInt(totalspppertahun)) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Jumlah Pembayaran melebihi jumlah SPP pada Tahun Ajaran ini!',
                    didClose: (e) => {
                        $(this).find("#tagihanspppertahun").focus();
                    }
                });
                return false;
            } else {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('rencanaspp.update') }}",
                    data: $(this).serialize(),
                    cache: false,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                            didClose: (e) => {

                            }
                        });
                        $("#modalrencanaspp").modal("hide");
                        getrencanaspp(response.no_pendaftaran);
                    },

                    error: function(xhr) {
                        Swal.fire({
                            title: "Error!",
                            text: xhr.responseJSON.message,
                            icon: "error",
                            showConfirmButton: true,
                            didClose: (e) => {
                                $("#modalrencanaspp").modal("hide");
                            }
                        });
                    }
                });
            }
        });
        let no = 1;
        $(document).on('click', '#btnTambahdetailbayar', function(e) {
            let biaya = $(document).find("#formDetailbayar").find("#kode_biaya").val();
            let databiaya = biaya.split("|");
            let kode_biaya = databiaya[1];
            let kode_jenis_biaya = databiaya[0];
            let jenis_biaya = $(document).find("#formDetailbayar").find("#kode_biaya option:selected")
                .text();
            let jumlah = $(document).find("#formDetailbayar").find("#jumlah").val().replace(/[^0-9]/g,
                '');
            let keterangan = $(document).find("#formDetailbayar").find("#keterangan").val();
            let sisa_tagihan = $(document).find("#formDetailbayar").find("#sisa_tagihan").val().replace(
                /[^0-9]/g, '');

            if (biaya == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Biaya tidak boleh kosong!',
                    didClose: (e) => {
                        $(document).find("#formDetailbayar").find("#kode_biaya").focus();
                    }
                });
                return false;
            } else if (jumlah == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Jumlah tidak boleh kosong!',
                    didClose: (e) => {
                        $(document).find("#formDetailbayar").find("#jumlah").focus();
                    }
                });
                return false;
            } else if (parseInt(jumlah) > parseInt(sisa_tagihan)) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Jumlah melebihi sisa tagihan!',
                    didClose: (e) => {
                        $(document).find("#formDetailbayar").find("#jumlah").focus();
                    }
                });
                return false;
            } else if ($(document).find(`#index_${kode_biaya+kode_jenis_biaya}`).length > 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Data Sudah Ada!',
                    didClose: (e) => {
                        $(document).find("#formDetailbayar").find("#kode_biaya").focus();
                    }
                });
                return false;
            } else {
                let data = `<tr id="index_${kode_biaya+kode_jenis_biaya}">
                <td>${jenis_biaya}</td>
                <td class='text-end jmlbayar'>${convertToRupiah(jumlah)}</td>
                <td>${keterangan}</td>
                <td>
                    <input type="hidden" name="kode_biaya[]" value="${kode_biaya}" />
                    <input type="hidden" name="kode_jenis_biaya[]" value="${kode_jenis_biaya}" />
                    <input type="hidden" name="keterangan[]" value="${keterangan}" />
                    <input type="hidden" name="jumlah[]" value="${jumlah}" />
                    <a href="#" key="${kode_biaya+kode_jenis_biaya}" class="delete"><i class="ti ti-trash text-danger"></i></a>
                </td>
            </tr>`;

                $(document).find("#detailbayar").append(data);
                no++;

                $(document).find("#formDetailbayar").find("#kode_biaya").val("").trigger("change");
                $(document).find("#formDetailbayar").find("#jumlah").val("");
                $(document).find("#formDetailbayar").find("#keterangan").val("");
                $(document).find("#formDetailbayar").find("#sisa_tagihan").val("");

                hitungTotalBayar();
            }
        });


        $(document).on('click', '.delete', function(e) {
            e.preventDefault();
            let key = $(this).attr("key");
            event.preventDefault();
            Swal.fire({
                title: `Apakah Anda Yakin Ingin Menghapus Data Ini ?`,
                text: "Jika dihapus maka data akan hilang permanent.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                showCancelButton: true,
                confirmButtonColor: "#554bbb",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Hapus Saja!"
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $(document).find(`#index_${key}`).remove();
                    hitungTotalBayar();
                }
            });
        });


        $(document).on('click', '.btnDeletebayar', function(e) {
            e.preventDefault();
            let key = $(this).attr("key");
            event.preventDefault();
            Swal.fire({
                title: `Apakah Anda Yakin Ingin Menghapus Data Ini ?`,
                text: "Jika dihapus maka data akan hilang permanent.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                showCancelButton: true,
                confirmButtonColor: "#554bbb",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Hapus Saja!"
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('pembayaranpendidikan.delete') }}",
                        data: {
                            '_token': "{{ csrf_token() }}",
                            'no_bukti': key
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Data Berhasil Dihapus',
                                didClose: (e) => {
                                    gethistoribayar(response
                                        .no_pendaftaran);
                                    getbiaya(response.no_pendaftaran);
                                    getrencanaspp(response
                                        .no_pendaftaran);
                                }
                            })
                        },
                        error: function(response) {
                            Swal.fire({
                                title: "Error!",
                                text: response.responseJSON.message,
                                icon: "error",
                                showConfirmButton: true,
                                didClose: (e) => {

                                }
                            });
                        }
                    });
                }
            });
        });
        $(document).on('click', '.btnDetailbayar', function(e) {
            let no_bukti = $(this).attr('no_bukti');
            $("#modalDetailbayar").modal('show');
            $("#loaddetailbayar").html(loading);
            $("#modalDetailbayar").find(".modal-title").text("Detail Pembayaran");
            $("#loaddetailbayar").load(`/pembayaranpendidikan/${no_bukti}/showdetailbayar`);

        });

        function convertToRupiah(number) {
            if (number) {
                var rupiah = "";
                var numberrev = number
                    .toString()
                    .split("")
                    .reverse()
                    .join("");
                for (var i = 0; i < numberrev.length; i++)
                    if (i % 3 == 0) rupiah += numberrev.substr(i, 3) + ".";
                return (
                    rupiah
                    .split("", rupiah.length - 1)
                    .reverse()
                    .join("")
                );
            } else {
                return number;
            }
        }

        function hitungTotalBayar() {
            let totalBayar = 0;
            $(document).find(".jmlbayar").each(function() {
                totalBayar += parseInt($(this).text().replace(/[^0-9]/g, ''));
            });
            $("#totalbayar").text(convertToRupiah(totalBayar));
        }

        $(document).on('submit', '#formDetailbayar', function(e) {
            e.preventDefault();
            let tanggal = $(this).find("#tanggal").val();
            let cekdetail = $(this).find('#tableDetailbayar').find('#detailbayar tr').length;
            let metode_pembayaran = $(this).find("#metode_pembayaran").val();
            if (tanggal == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Tanggal tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#tanggal").focus();
                    }
                });
                return false;
            } else if (cekdetail == 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Detail Bayar tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#kode_biaya").focus();
                    }
                });
                return false;
            } else if (metode_pembayaran == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Metode pembayaran tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#metode_pembayaran").focus();
                    }
                });
                return false;
            } else {
                $(this).find("#btnSimpan").prop('disabled', true);
                $(this).find("#btnSimpan").html(
                    '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Loading...'
                );
                $.ajax({
                    type: "POST",
                    url: "{{ route('pembayaranpendidikan.store') }}",
                    cache: false,
                    data: $(this).serialize(),
                    success: function(respond) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: respond.message,
                            didClose: (e) => {
                                $("#modalpembayaran").modal("hide");
                                gethistoribayar(respond.no_pendaftaran);
                                getrencanaspp(respond.no_pendaftaran);
                                getbiaya(respond.no_pendaftaran);

                            }
                        });
                    },
                    error: function(respond) {
                        $(this).find("#btnSimpan").prop('disabled', false);
                        Swal.fire({
                            title: "Error!",
                            text: respond.responseJSON.message,
                            icon: "error",
                            showConfirmButton: true,
                        });
                    }
                });
            }
        });

        function gethistoribayar(no_pendaftaran) {
            $.ajax({
                type: 'GET',
                url: `/pembayaranpendidikan/${no_pendaftaran}/gethistoribayar`,
                cache: false,
                success: function(res) {
                    $(document).find("#tabelhistoribayar").html(res);
                }
            });
        }

        function getTingkatByUnit(kode_unit, selected = '') {
            selected = "{{ Request('tingkat') }}"
            $.ajax({
                type: "POST",
                url: "{{ route('unit.gettingkatbyunit') }}",
                cache: false,
                data: {
                    _token: "{{ csrf_token() }}",
                    kode_unit: kode_unit,
                    selected: selected
                },
                success: function(respond) {
                    $(document).find("#tingkat").html(respond);
                }
            });

        }
        $(document).on('change', '#kode_unit_search', function() {
            const kode_unit = $(this).val();
            getTingkatByUnit(kode_unit);
        });

        getTingkatByUnit("{{ Request('kode_unit') }}");

        // Bulk Naik Kelas Logic
        $("#checkAll").click(function() {
            $(".checkItem").prop('checked', $(this).prop('checked'));
        });

        $("#btnBulkNaikKelas").click(function() {
            const checkedCount = $(".checkItem:checked").length;
            if (checkedCount === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Silakan pilih siswa terlebih dahulu!',
                });
                return false;
            }

            Swal.fire({
                title: 'Konfirmasi',
                text: `Apakah Anda yakin ingin menaikkan ${checkedCount} siswa yang dipilih?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#064e3b',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Proses!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#formBulkNaikKelas").submit();
                }
            });
        });

        // Handle click Ubah Biaya
        $(document).on('click', '.btnEditBiaya', function(e) {
            e.preventDefault();
            const no_pendaftaran = $(this).attr('no_pendaftaran');
            const kode_biaya = $(this).attr('kode_biaya');
            $("#modaleditbiaya").modal("show");
            $("#modaleditbiaya").find("#loadeditbiaya").html(loading);
            $("#modaleditbiaya").find(".modal-title").text("Ubah Konfigurasi Biaya");
            $("#loadeditbiaya").load(`/pembayaranpendidikan/${no_pendaftaran}/${kode_biaya}/editbiaya`);
        });

        // Handle submit Form Ubah Biaya
        $(document).on('submit', '#formEditBiaya', function(e) {
            e.preventDefault();
            const data = $(this).serialize();
            $(this).find('button[type="submit"]').prop('disabled', true);
            $(this).find('button[type="submit"]').html(
                '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Loading...'
            );

            $.ajax({
                url: "{{ route('pembayaranpendidikan.updatebiaya') }}",
                type: "POST",
                data: data,
                cache: false,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message,
                    });
                    $("#modaleditbiaya").modal("hide");
                    getbiaya(response.no_pendaftaran);
                    getrencanaspp(response.no_pendaftaran);
                    gethistoribayar(response.no_pendaftaran);
                },
                error: function(xhr) {
                    Swal.fire({
                        title: "Error!",
                        text: xhr.responseJSON.message,
                        icon: "error",
                        showConfirmButton: true,
                        didClose: (e) => {
                            $(document).find('#formEditBiaya').find(
                                'button[type="submit"]').prop(
                                'disabled', false);
                            $(document).find('#formEditBiaya').find(
                                'button[type="submit"]').html(
                                'Simpan Perubahan'
                            );
                        }
                    });
                }
            });
        });
    });
</script>
@endpush

@extends('layouts.app')
@section('titlepage', 'Anggota Koperasi')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-users fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Data Anggota Koperasi</h4>
                        <p class="text-muted mb-0 small">Manajemen master data anggota koperasi unit</p>
                    </div>
                </div>
                <div class="d-flex flex-column align-items-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mb-0">
                            <li class="breadcrumb-item">
                                <a href="javascript:void(0);" class="text-muted">
                                    <i class="ti ti-database me-1"></i> Data Master
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                <i class="ti ti-users me-1"></i> Anggota Koperasi
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
        <!-- Actions Section -->
        <div class="d-flex justify-content-start mb-3">
            @can('anggota.create')
                <button class="btn d-flex align-items-center gap-2 shadow-sm text-white" id="btncreateAnggota"
                    style="background-color: #064e3b">
                    <i class="ti ti-plus fs-4"></i>
                    <span>Tambah Anggota Koperasi</span>
                </button>
            @endcan
        </div>

        <form action="{{ route('anggota.index') }}" class="mb-4">
            <div class="row align-items-end g-3">
                <div class="col-lg-10 col-md-9">
                    <x-input-with-icon label="Cari Nama Anggota Koperasi" value="{{ Request('nama_lengkap') }}" name="nama_lengkap"
                        icon="ti ti-search" />
                </div>
                <div class="col-lg-2 col-md-3">
                    <button class="btn btn-primary w-100 p-2 d-flex align-items-center justify-content-center gap-2" style="background-color: #064e3b; border-color: #064e3b">
                        <i class="ti ti-search fs-5"></i>
                        <span>Cari</span>
                    </button>
                </div>
            </div>
        </form>

        <div class="card shadow-sm">
            <div class="card-header d-flex align-items-center gap-2 text-white py-3" style="background-color: #064e3b">
                <i class="ti ti-layout-grid fs-5"></i>
                <h6 class="card-title mb-0 text-white">Data Anggota Koperasi</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background-color: #064e3b">
                            <tr>
                                <th class="text-white py-3">NO</th>
                                <th class="text-white py-3">NO. ANGGOTA</th>
                                <th class="text-white py-3">NIK</th>
                                <th class="text-white py-3">NAMA LENGKAP</th>
                                <th class="text-white py-3">TTL</th>
                                <th class="text-white py-3">NO. HP</th>
                                <th class="text-white py-3">SISWA TERKAIT</th>
                                <th class="text-white py-3">KARYAWAN TERKAIT</th>
                                <th class="text-white py-3 text-end" style="width: 150px;">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($anggota as $d)
                                <tr>
                                    <td class="text-center py-1">{{ $loop->iteration + $anggota->firstItem() - 1 }}</td>
                                    <td class="py-1"><span class="fw-bold">{{ $d->no_anggota }}</span></td>
                                    <td class="py-1">{{ $d->nik }}</td>
                                    <td class="py-1"><a href="{{ route('anggota.show', Crypt::encrypt($d->no_anggota)) }}" class="text-primary fw-bold text-uppercase">{{ $d->nama_lengkap }}</a></td>
                                    <td class="py-1 small">{{ $d->tempat_lahir }}, {{ $d->tanggal_lahir }}</td>
                                    <td class="py-1">{{ $d->no_hp }}</td>
                                    <td class="py-1">
                                         @if ($d->siswa->count() > 0)
                                             <div class="d-flex flex-wrap gap-1">
                                                 @foreach ($d->siswa as $siswa)
                                                     <span class="badge bg-label-success small" style="font-size: 0.75rem">{{ $siswa->nama_lengkap }}</span>
                                                 @endforeach
                                             </div>
                                         @else
                                             <span class="text-muted small">Belum ada siswa</span>
                                         @endif
                                     </td>
                                     <td class="py-1">
                                         @if ($d->karyawan->count() > 0)
                                             <div class="d-flex flex-wrap gap-1">
                                                 @foreach ($d->karyawan as $karyawan)
                                                     <span class="badge bg-label-info small" style="font-size: 0.75rem">{{ $karyawan->nama_lengkap }}</span>
                                                 @endforeach
                                             </div>
                                         @else
                                             <span class="text-muted small">Belum ada karyawan</span>
                                         @endif
                                     </td>
                                    <td class="py-1 text-end">
                                        <div class="d-flex justify-content-end gap-1">
                                            @can('anggota.edit')
                                                <a href="#" class="btn btn-icon btn-label-success border btnEditAnggota shadow-none"
                                                    style="width: 28px; height: 28px;"
                                                    no_anggota="{{ Crypt::encrypt($d->no_anggota) }}" data-bs-toggle="tooltip" title="Edit Data">
                                                    <i class="ti ti-edit fs-6"></i>
                                                </a>
                                            @endcan

                                            <a href="{{ route('anggota.show', Crypt::encrypt($d->no_anggota)) }}" 
                                                class="btn btn-icon btn-label-info border shadow-none"
                                                style="width: 28px; height: 28px;" data-bs-toggle="tooltip" title="Detail Anggota">
                                                <i class="ti ti-file-description fs-6"></i>
                                            </a>

                                            <a href="#" class="btn btn-icon btn-label-warning border btnHubungkanSiswa shadow-none"
                                                style="width: 28px; height: 28px;"
                                                no_anggota="{{ Crypt::encrypt($d->no_anggota) }}" data-bs-toggle="tooltip"
                                                title="Hubungkan Siswa">
                                                <i class="ti ti-user-plus fs-6"></i>
                                            </a>

                                            <a href="#" class="btn btn-icon btn-label-primary border btnHubungkanKaryawan shadow-none"
                                                style="width: 28px; height: 28px;"
                                                no_anggota="{{ Crypt::encrypt($d->no_anggota) }}" data-bs-toggle="tooltip"
                                                title="Hubungkan Karyawan">
                                                <i class="ti ti-user-check fs-6"></i>
                                            </a>

                                            @can('anggota.delete')
                                                <form method="POST" class="deleteform d-inline"
                                                    action="{{ route('anggota.delete', Crypt::encrypt($d->no_anggota)) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="#" class="btn btn-icon btn-label-danger border delete-confirm shadow-none"
                                                        style="width: 28px; height: 28px;" data-bs-toggle="tooltip" title="Hapus Data">
                                                        <i class="ti ti-trash fs-6"></i>
                                                    </a>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center p-5">
                                        <div class="mb-3">
                                            <i class="ti ti-users fs-1 opacity-25"></i>
                                        </div>
                                        <h5>Belum Ada Data Anggota</h5>
                                        <p class="text-muted small">Silahkan tambah data anggota baru.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-4 py-3 border-top">
                    <div style="float: right;">
                        {{ $anggota->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<x-modal-form id="mdlAnggota" size="modal-lg" show="loadmodalAnggota" title="" icon="ti ti-users" />

<!-- Modal Hubungkan Siswa -->
<div class="modal fade" id="mdlHubungkanSiswa" tabindex="-1" aria-labelledby="mdlHubungkanSiswaLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content overflow-hidden">
            <div class="modal-header py-3 d-flex align-items-center justify-content-between" style="background-color: #064e3b; border-bottom: none;">
                <div class="d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 38px; height: 38px; background-color: rgba(255, 255, 255, 0.15)">
                        <i class="ti ti-user-plus text-white fs-3"></i>
                    </div>
                    <h5 class="modal-title shadow-none text-white mb-0 fw-bold" id="mdlHubungkanSiswaLabel">Hubungkan Siswa</h5>
                </div>
                <button type="button" class="btn border-0 p-0 text-white shadow-none" data-bs-dismiss="modal" aria-label="Close" style="background: transparent;">
                    <i class="ti ti-x fs-5"></i>
                </button>
            </div>
            <div class="modal-body p-4">
                <form id="formHubungkanSiswa">
                    <input type="hidden" id="no_anggota_hidden" name="no_anggota">

                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase">Pilih Siswa</label>
                        <select class="form-select form-select-lg select2" id="id_siswa" name="id_siswa" required>
                            <option value="">-- Pilih Siswa --</option>
                        </select>
                    </div>

                    <div class="divider text-start mb-3">
                        <div class="divider-text fw-bold text-muted small text-uppercase">
                            Siswa yang Sudah Terhubung
                        </div>
                    </div>
                    
                    <div id="siswa-terhubung" class="mb-3">
                        <!-- Daftar siswa yang sudah terhubung akan dimuat di sini -->
                    </div>
                </form>
            </div>
            <div class="modal-footer p-3 bg-light border-top">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="btnSimpanHubungan" style="background-color: #064e3b; border-color: #064e3b">
                    <i class="ti ti-link me-2"></i>Hubungkan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Hubungkan Karyawan -->
<div class="modal fade" id="mdlHubungkanKaryawan" tabindex="-1" aria-labelledby="mdlHubungkanKaryawanLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content overflow-hidden">
            <div class="modal-header py-3 d-flex align-items-center justify-content-between" style="background-color: #064e3b; border-bottom: none;">
                <div class="d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 38px; height: 38px; background-color: rgba(255, 255, 255, 0.15)">
                        <i class="ti ti-user-check text-white fs-3"></i>
                    </div>
                    <h5 class="modal-title shadow-none text-white mb-0 fw-bold" id="mdlHubungkanKaryawanLabel">Hubungkan Karyawan</h5>
                </div>
                <button type="button" class="btn border-0 p-0 text-white shadow-none" data-bs-dismiss="modal" aria-label="Close" style="background: transparent;">
                    <i class="ti ti-x fs-5"></i>
                </button>
            </div>
            <div class="modal-body p-4">
                <form id="formHubungkanKaryawan">
                    <input type="hidden" id="no_anggota_hidden_karyawan" name="no_anggota">

                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase">Pilih Karyawan</label>
                        <select class="form-select form-select-lg select2" id="npp" name="npp" required>
                            <option value="">-- Pilih Karyawan --</option>
                        </select>
                    </div>

                    <div class="divider text-start mb-3">
                        <div class="divider-text fw-bold text-muted small text-uppercase">
                            Karyawan yang Sudah Terhubung
                        </div>
                    </div>
                    
                    <div id="karyawan-terhubung" class="mb-3">
                        <!-- Daftar karyawan yang sudah terhubung akan dimuat di sini -->
                    </div>
                </form>
            </div>
            <div class="modal-footer p-3 bg-light border-top">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="btnSimpanHubunganKaryawan" style="background-color: #064e3b; border-color: #064e3b">
                    <i class="ti ti-link me-2"></i>Hubungkan
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('myscript')
<script>
    $(function() {
        $('#id_siswa').wrap('<div class="position-relative"></div>').select2({
            dropdownParent: $('#mdlHubungkanSiswa')
        });
        $('#npp').wrap('<div class="position-relative"></div>').select2({
            dropdownParent: $('#mdlHubungkanKaryawan')
        });

        $("#btncreateAnggota").click(function(e) {
            e.preventDefault();
            $('#mdlAnggota').modal("show");
            $("#mdlAnggota").find(".modal-title").text("Tambah Anggota Koperasi");
            $("#loadmodalAnggota").html(`<div class="sk-wave sk-primary" style="margin:auto">
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                </div>`);
            $("#loadmodalAnggota").load("{{ route('anggota.create') }}");
        });

        $(".btnEditAnggota").click(function(e) {
            var no_anggota = $(this).attr("no_anggota");
            e.preventDefault();
            $('#mdlAnggota').modal("show");
            $("#mdlAnggota").find(".modal-title").text("Edit Anggota Koperasi");
            $("#loadmodalAnggota").html(`<div class="sk-wave sk-primary" style="margin:auto">
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                </div>`);
            $("#loadmodalAnggota").load('/anggota/' + no_anggota + '/edit');
        });

        // Fitur Hubungkan Siswa
        $(".btnHubungkanSiswa").click(function(e) {
            e.preventDefault();
            var no_anggota = $(this).attr("no_anggota");
            $('#no_anggota_hidden').val(no_anggota);
            $('#mdlHubungkanSiswa').modal("show");

            // Load data siswa dan siswa yang sudah terhubung
            loadSiswaOptions();
            loadSiswaTerhubung(no_anggota);
        });

        // Load daftar siswa untuk dropdown
        function loadSiswaOptions() {
            $.get('/anggota/get-siswa-options', function(data) {
                $('#id_siswa').html('<option value="">-- Pilih Siswa --</option>');
                $.each(data, function(index, siswa) {
                    $('#id_siswa').append('<option value="' + siswa.id_siswa + '">' + siswa.nama_lengkap + ' (' + siswa
                        .id_siswa + ')</option>');
                });
                $('#id_siswa').trigger('change');
            });
        }

        // Load siswa yang sudah terhubung
        function loadSiswaTerhubung(no_anggota) {
            $("#siswa-terhubung").html('<div class="text-center p-3 small text-muted"><div class="spinner-border spinner-border-sm text-secondary me-2" role="status"></div>Memuat data...</div>');
            $.get('/anggota/get-siswa-terhubung/' + no_anggota, function(data) {
                var html = '';
                if (data.length > 0) {
                    $.each(data, function(index, siswa) {
                        html += '<div class="d-flex justify-content-between align-items-center mb-2 p-3 border rounded-3 bg-white shadow-xs">';
                        html += '<div>';
                        html += '<div class="fw-bold text-uppercase" style="font-size: 0.85rem">' + siswa.nama_lengkap + '</div>';
                        html += '<div class="text-muted small">' + siswa.id_siswa + '</div>';
                        html += '</div>';
                        html += '<button type="button" class="btn btn-icon btn-label-danger border btnHapusHubungan" data-id-siswa="' + siswa
                            .id_siswa + '" style="width: 28px; height: 28px;">';
                        html += '<i class="ti ti-trash fs-6"></i>';
                        html += '</button>';
                        html += '</div>';
                    });
                } else {
                    html = '<div class="text-center p-4 bg-light rounded-3 text-muted small mt-2">Belum ada siswa yang terhubung</div>';
                }
                $('#siswa-terhubung').html(html);
            });
        }

        // Simpan hubungan siswa dengan anggota
        $('#btnSimpanHubungan').click(function() {
            var btn = $(this);
            var no_anggota = $('#no_anggota_hidden').val();
            var id_siswa = $('#id_siswa').val();

            if (!id_siswa) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Silahkan pilih siswa terlebih dahulu'
                });
                return;
            }

            btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2" role="status"></span>Memproses...');

            $.post('/anggota/hubungkan-siswa', {
                _token: $('meta[name="csrf-token"]').attr('content'),
                no_anggota: no_anggota,
                id_siswa: id_siswa
            }, function(response) {
                btn.prop('disabled', false).html('<i class="ti ti-link me-2"></i>Hubungkan');
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Siswa berhasil dihubungkan',
                        timer: 1500,
                        showConfirmButton: false
                    });
                    loadSiswaTerhubung(no_anggota);
                    $('#id_siswa').val('');
                    // location.reload(); // Hanya reload jika memang perlu update tampilan utama
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Error: ' + response.message
                    });
                }
            });
        });

        // Hapus hubungan siswa
        $(document).on('click', '.btnHapusHubungan', function() {
            var id_siswa = $(this).data('id-siswa');
            var no_anggota = $('#no_anggota_hidden').val();

            Swal.fire({
                title: 'Hapus Hubungan?',
                text: "Yakin ingin menghapus hubungan siswa ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post('/anggota/hapus-hubungan-siswa', {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        no_anggota: no_anggota,
                        id_siswa: id_siswa
                    }, function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Hubungan berhasil dihapus',
                                timer: 1500,
                                showConfirmButton: false
                            });
                            loadSiswaTerhubung(no_anggota);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Error: ' + response.message
                            });
                        }
                    });
                }
            });
        });

        // Fitur Hubungkan Karyawan
        $(".btnHubungkanKaryawan").click(function(e) {
            e.preventDefault();
            var no_anggota = $(this).attr("no_anggota");
            $('#no_anggota_hidden_karyawan').val(no_anggota);
            $('#mdlHubungkanKaryawan').modal("show");

            // Load data karyawan dan karyawan yang sudah terhubung
            loadKaryawanOptions();
            loadKaryawanTerhubung(no_anggota);
        });

        // Load daftar karyawan untuk dropdown
        function loadKaryawanOptions() {
            $.get('/anggota/get-karyawan-options', function(data) {
                $('#npp').html('<option value="">-- Pilih Karyawan --</option>');
                $.each(data, function(index, karyawan) {
                    $('#npp').append('<option value="' + karyawan.npp + '">' + karyawan.nama_lengkap + ' (' + karyawan.npp + ')</option>');
                });
                $('#npp').trigger('change');
            });
        }

        // Load karyawan yang sudah terhubung
        function loadKaryawanTerhubung(no_anggota) {
            $("#karyawan-terhubung").html('<div class="text-center p-3 small text-muted"><div class="spinner-border spinner-border-sm text-secondary me-2" role="status"></div>Memuat data...</div>');
            $.get('/anggota/get-karyawan-terhubung/' + no_anggota, function(data) {
                var html = '';
                if (data.length > 0) {
                    $.each(data, function(index, karyawan) {
                        html += '<div class="d-flex justify-content-between align-items-center mb-2 p-3 border rounded-3 bg-white shadow-xs">';
                        html += '<div>';
                        html += '<div class="fw-bold text-uppercase" style="font-size: 0.85rem">' + karyawan.nama_lengkap + '</div>';
                        html += '<div class="text-muted small">' + karyawan.npp + '</div>';
                        html += '</div>';
                        html += '<button type="button" class="btn btn-icon btn-label-danger border btnHapusHubunganKaryawan" data-npp="' + karyawan.npp + '" style="width: 28px; height: 28px;">';
                        html += '<i class="ti ti-trash fs-6"></i>';
                        html += '</button>';
                        html += '</div>';
                    });
                } else {
                    html = '<div class="text-center p-4 bg-light rounded-3 text-muted small mt-2">Belum ada karyawan yang terhubung</div>';
                }
                $('#karyawan-terhubung').html(html);
            });
        }

        // Simpan hubungan karyawan dengan anggota
        $('#btnSimpanHubunganKaryawan').click(function() {
            var btn = $(this);
            var no_anggota = $('#no_anggota_hidden_karyawan').val();
            var npp = $('#npp').val();

            if (!npp) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Silahkan pilih karyawan terlebih dahulu'
                });
                return;
            }

            btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2" role="status"></span>Memproses...');

            $.post('/anggota/hubungkan-karyawan', {
                _token: $('meta[name="csrf-token"]').attr('content'),
                no_anggota: no_anggota,
                npp: npp
            }, function(response) {
                btn.prop('disabled', false).html('<i class="ti ti-link me-2"></i>Hubungkan');
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Karyawan berhasil dihubungkan',
                        timer: 1500,
                        showConfirmButton: false
                    });
                    loadKaryawanTerhubung(no_anggota);
                    $('#npp').val('');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Error: ' + response.message
                    });
                }
            });
        });

        // Hapus hubungan karyawan
        $(document).on('click', '.btnHapusHubunganKaryawan', function() {
            var npp = $(this).data('npp');
            var no_anggota = $('#no_anggota_hidden_karyawan').val();

            Swal.fire({
                title: 'Hapus Hubungan?',
                text: "Yakin ingin menghapus hubungan karyawan ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post('/anggota/hapus-hubungan-karyawan', {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        no_anggota: no_anggota,
                        npp: npp
                    }, function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Hubungan berhasil dihapus',
                                timer: 1500,
                                showConfirmButton: false
                            });
                            loadKaryawanTerhubung(no_anggota);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Error: ' + response.message
                            });
                        }
                    });
                }
            });
        });

        // Reload page when closing modals to update main table
        $('#mdlHubungkanSiswa, #mdlHubungkanKaryawan').on('hidden.bs.modal', function () {
            location.reload();
        });

        // Konfirmasi delete anggota
        $(".delete-confirm").click(function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Semua data terkait termasuk tabungan & simpanan akan terpengaruh!",
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
        })
    });
</script>
@endpush

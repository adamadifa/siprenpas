@extends('layouts.app')
@section('titlepage', 'Set Anggota Kelas')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center" style="background-color: #e6f4ea !important;">
                        <i class="ti ti-layout-grid-add fs-3" style="color: #064e3b;"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Set Anggota Kelas</h4>
                        <p class="text-muted mb-0 small">Atur dan kelola siswa untuk kelas {{ $kelas->nama_kelas }}</p>
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
                            <li class="breadcrumb-item">
                                <a href="{{ route('kelas.index') }}" class="text-muted">Kelas</a>
                            </li>
                            <li class="breadcrumb-item active text-dark">Set Anggota</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

<div class="row">
    <div class="col-lg-7 col-md-10 col-12">
        <!-- Class Info Badges -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-3">
                <div class="row g-3 align-items-center">
                    <div class="col-md-3">
                        <div class="d-flex align-items-center gap-2">
                            <div class="avatar avatar-sm rounded d-flex align-items-center justify-content-center" style="background-color: #f0fdf4; width: 38px; height: 38px;">
                                <i class="ti ti-door-enter fs-4" style="color: #064e3b;"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block" style="font-size: 0.75rem;">Kelas</small>
                                <span class="fw-bold text-dark">{{ $kelas->nama_kelas }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center gap-2">
                            <div class="avatar avatar-sm rounded d-flex align-items-center justify-content-center" style="background-color: #f0fdf4; width: 38px; height: 38px;">
                                <i class="ti ti-chart-bar fs-4" style="color: #064e3b;"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block" style="font-size: 0.75rem;">Tingkat</small>
                                <span class="fw-bold text-dark">Tingkat {{ $kelas->tingkat }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center gap-2">
                            <div class="avatar avatar-sm rounded d-flex align-items-center justify-content-center" style="background-color: #f0fdf4; width: 38px; height: 38px;">
                                <i class="ti ti-school fs-4" style="color: #064e3b;"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block" style="font-size: 0.75rem;">Unit / Jenjang</small>
                                <span class="fw-bold text-dark">{{ $kelas->nama_unit }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 text-md-end text-start">
                        @can('kelas.create')
                            <button class="btn btn-primary d-inline-flex align-items-center justify-content-center gap-2 shadow-sm" id="btnAddsiswa" style="background-color: #064e3b; border-color: #064e3b; height: 38px;">
                                <i class="ti ti-plus fs-5"></i>
                                <span>Tambah Siswa</span>
                            </button>
                        @endcan
                    </div>
                </div>
            </div>
        </div>

        <!-- Student List Card -->
        <div class="card shadow-sm border-0">
            <div class="card-header d-flex align-items-center gap-2 text-white py-3" style="background-color: #064e3b">
                <i class="ti ti-users fs-5"></i>
                <h6 class="card-title mb-0 text-white">Daftar Siswa Kelas {{ $kelas->nama_kelas }}</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 text-nowrap">
                        <thead style="background-color: #064e3b">
                            <tr>
                                <th class="py-3 text-white" style="width: 60px;">NO.</th>
                                <th class="py-3 text-white" style="width: 120px;">NIS</th>
                                <th class="py-3 text-white">NAMA LENGKAP</th>
                                <th class="py-3 text-white text-center" style="width: 80px;">AKSI</th>
                            </tr>
                        </thead>
                        <tbody id="loadkelassiswa">
                            <tr>
                                <td colspan="4" class="text-center p-5">
                                    <div class="spinner-border text-primary" role="status" style="color: #064e3b !important;">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Siswa -->
<div class="modal fade animate__animated animate__fadeIn" id="modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header text-white py-3" style="background-color: #064e3b">
                <h5 class="modal-title text-white d-flex align-items-center gap-2">
                    <i class="ti ti-user-plus fs-4"></i> Tambah Data Siswa
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="#" id="frmTambahSiswa">
                    <div class="mb-3">
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="ti ti-search text-muted"></i></span>
                            <input type="text" class="form-control" id="nama_siswa" name="nama_siswa" placeholder="Ketik nama siswa untuk mencari..." autocomplete="off">
                        </div>
                    </div>
                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                        <table class="table table-hover table-sm">
                            <thead style="background-color: #064e3b; position: sticky; top: 0; z-index: 1;">
                                <tr>
                                    <th class="py-2 text-white" style="width: 60px;">NO.</th>
                                    <th class="py-2 text-white" style="width: 90px;">ID</th>
                                    <th class="py-2 text-white" style="width: 120px;">NIS</th>
                                    <th class="py-2 text-white">NAMA SISWA</th>
                                    <th class="py-2 text-white text-center" style="width: 80px;">AKSI</th>
                                </tr>
                            </thead>
                            <tbody id="loadsiswa">
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">Ketik pencarian di atas...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('myscript')
<script>
    $(function() {
        $("#btnAddsiswa").click(function(e) {
            e.preventDefault();
            $('#modal').modal("show");
            getSiswa();
        });

        function getSiswa() {
            const kode_kelas = "{{ $kelas->kode_kelas }}";
            const nama_siswa = $(document).find("#nama_siswa").val();
            
            $.ajax({
                type: 'POST',
                url: `/kelas/getsiswa`,
                data: {
                    _token: "{{ csrf_token() }}",
                    kode_kelas: kode_kelas,
                    nama_siswa: nama_siswa
                },
                cache: false,
                success: function(respond) {
                    let no = 1;
                    $(document).find("#loadsiswa").html("");
                    if(respond.length === 0) {
                        $(document).find("#loadsiswa").html(`<tr><td colspan="5" class="text-center py-4 text-muted">Siswa tidak ditemukan atau sudah terdaftar di kelas lain</td></tr>`);
                        return;
                    }
                    respond.forEach(element => {
                        const avatarHtml = element.foto_pendaftaran ? 
                            `<div class="avatar rounded overflow-hidden shadow-sm" style="width: 28px; height: 35px; min-width: 28px;">
                                <img src="/storage/photos/pendaftaran/${element.foto_pendaftaran}" alt="Foto" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>` : 
                            `<div class="avatar avatar-xs bg-label-success rounded-circle d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; background-color: #f0fdf4 !important; color: #064e3b;">
                                <i class="ti ti-user fs-6"></i>
                            </div>`;
                        $(document).find("#loadsiswa").append(`
                            <tr>
                                <td class="align-middle">${no++}</td>
                                <td class="align-middle"><span class="badge bg-label-secondary" style="font-size: 0.75rem;">${element.id_siswa}</span></td>
                                <td class="align-middle fw-semibold text-dark">${element.nis ?? '-'}</td>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center gap-2">
                                        ${avatarHtml}
                                        <span class="text-dark fw-semibold">${element.nama_lengkap.toUpperCase()}</span>
                                    </div>
                                </td>
                                <td class="align-middle text-center">
                                ${element.ceksiswa == null ? 
                                    `<button type="button" class="btn btn-sm btn-icon btn-success tambahsiswa" id_siswa="${element.id_siswa}" title="Tambahkan"><i class="ti ti-plus"></i></button>` : 
                                    `<button type="button" class="btn btn-sm btn-icon btn-danger hapussiswa" id_siswa="${element.id_siswa}" title="Batalkan"><i class="ti ti-minus"></i></button>`
                                }
                                </td>
                            </tr>
                        `);
                    });
                }
            })
        }

        function getkelassiswa() {
            const kode_kelas = "{{ $kelas->kode_kelas }}";
            $.ajax({
                type: 'POST',
                url: `/kelas/getkelassiswa`,
                data: {
                    _token: "{{ csrf_token() }}",
                    kode_kelas: kode_kelas
                },
                cache: false,
                success: function(respond) {
                    let no = 1;
                    $(document).find("#loadkelassiswa").html("");
                    if(respond.length === 0) {
                        $(document).find("#loadkelassiswa").html(`<tr><td colspan="4" class="text-center py-5 text-muted">Belum ada siswa di kelas ini. Klik "Tambah Siswa" untuk mengisi anggota kelas.</td></tr>`);
                        return;
                    }
                    respond.forEach(element => {
                        const avatarHtml = element.foto_pendaftaran ? 
                            `<div class="avatar rounded overflow-hidden shadow-sm" style="width: 28px; height: 35px; min-width: 28px;">
                                <img src="/storage/photos/pendaftaran/${element.foto_pendaftaran}" alt="Foto" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>` : 
                            `<div class="avatar avatar-xs bg-label-success rounded-circle d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; background-color: #f0fdf4 !important; color: #064e3b;">
                                <i class="ti ti-user fs-6"></i>
                            </div>`;
                        $(document).find("#loadkelassiswa").append(`
                            <tr>
                                <td class="align-middle">${no++}</td>
                                <td class="align-middle fw-bold text-dark">${element.nis ?? '-'}</td>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center gap-2">
                                        ${avatarHtml}
                                        <span class="text-dark fw-semibold">${element.nama_lengkap.toUpperCase()}</span>
                                    </div>
                                </td>
                                <td class="align-middle text-center">
                                    <button type="button" class="btn btn-sm btn-icon btn-label-danger hapuskelassiswa" id_siswa="${element.id_siswa}" title="Hapus Siswa">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        `);
                    });
                }
            })
        }

        getkelassiswa();    

        $(document).on("click", ".tambahsiswa", function(e) {
            e.preventDefault();
            const id_siswa = $(this).attr("id_siswa");
            const kode_kelas = "{{ $kelas->kode_kelas }}";
            $.ajax({
                type: 'POST',
                url: `/kelas/storetambahsiswa`,
                data: {
                    _token: "{{ csrf_token() }}",
                    id_siswa: id_siswa,
                    kode_kelas: kode_kelas
                },
                cache: false,
                success: function(respond) {
                    if (respond.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: respond.message,
                            timer: 1500,
                            showConfirmButton: false
                        });
                        getSiswa();
                        getkelassiswa();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: respond.message
                        });
                    }
                }
            })
        });

        $(document).on("click", ".hapussiswa", function(e) {
            e.preventDefault();
            const id_siswa = $(this).attr("id_siswa");
            const kode_kelas = "{{ $kelas->kode_kelas }}";
            $.ajax({
                type: 'POST',
                url: `/kelas/deletesiswa`,
                data: {
                    _token: "{{ csrf_token() }}",
                    id_siswa: id_siswa,
                    kode_kelas: kode_kelas
                },
                cache: false,
                success: function(respond) {
                    if (respond.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: respond.message,
                            timer: 1500,
                            showConfirmButton: false
                        });
                        getSiswa();
                        getkelassiswa();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: respond.message
                        });
                    }
                }
            })
        });

        $(document).on("click", ".hapuskelassiswa", function(e) {
            e.preventDefault();
            const id_siswa = $(this).attr("id_siswa");
            const kode_kelas = "{{ $kelas->kode_kelas }}";
            
            Swal.fire({
                title: 'Keluarkan Siswa?',
                text: "Siswa akan dikeluarkan dari anggota kelas ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#064e3b',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, keluarkan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: `/kelas/deletekelassiswa`,
                        data: {
                            _token: "{{ csrf_token() }}",
                            id_siswa: id_siswa,
                            kode_kelas: kode_kelas
                        },
                        cache: false,
                        success: function(respond) {
                            if (respond.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: respond.message,
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                                getkelassiswa();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: respond.message
                                });
                            }
                        }
                    });
                }
            });
        });

        let typingTimer;
        const doneTypingInterval = 300; 
        const $input = $(document).find("#nama_siswa");

        $input.on("keyup", function() {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(getSiswa, doneTypingInterval);
        });

        $input.on("keydown", function() {
            clearTimeout(typingTimer);
        });
    });
</script>
@endpush

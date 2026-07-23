@extends('layouts.app')
@section('titlepage', 'Pendaftaran')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-clipboard-list fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Data Pendaftaran</h4>
                        <p class="text-muted mb-0 small">Manajemen pendaftaran siswa baru</p>
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
                                <i class="ti ti-clipboard-list me-1"></i> Pendaftaran
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
                                        <i class="ti ti-arrow-up-right me-1" style="font-size: 0.75rem;"></i>{{ $r->jumlah > 0 ? 'Aktif' : '0' }}
                                    </span>
                                </div>
                                <div class="text-muted small d-flex align-items-center gap-1">
                                    <span class="small">Total Pendaftar (Siswa)</span>
                                </div>
                            </div>
                        @empty
                            <div class="p-4 w-100 text-center text-muted">Belum ada data unit</div>
                        @endforelse
                    </div>
                </div>
            </div>
        @endif

        <!-- Actions Section -->
        <div class="d-flex justify-content-start gap-2 mb-3">
            @can('pendaftaran.create')
                <button class="btn d-flex align-items-center gap-2 shadow-sm text-white" id="btnCreate"
                    style="background-color: #064e3b">
                    <i class="ti ti-plus fs-4"></i>
                    <span>Tambah Pendaftaran</span>
                </button>
            @endcan
            <a href="{{ route('pendaftaran.export', request()->all()) }}" class="btn btn-success d-flex align-items-center gap-2 shadow-sm text-white" style="background-color: #1b5e20; border-color: #1b5e20;">
                <i class="ti ti-file-spreadsheet fs-4"></i>
                <span>Export Excel</span>
            </a>
        </div>

        <!-- Filter Section -->
        <div class="card mb-4 shadow-none border-0 bg-transparent">
            <div class="card-body p-0">
                <form action="{{ route('pendaftaran.index') }}">
                    <div class="row g-3 align-items-center">
                        @php
                            $isU06 = auth()->user()->kode_unit == 'U06';
                        @endphp
                        
                        <div class="{{ $isU06 ? 'col-lg-3' : 'col-lg-4' }} col-md-6">
                            <x-input-with-icon label="" value="{{ Request('nama_lengkap') }}" name="nama_lengkap"
                                placeholder="Cari Nama Siswa" icon="ti ti-search" />
                        </div>

                        @if ($isU06)
                            <div class="col-lg-2 col-md-6">
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

                        <div class="{{ $isU06 ? 'col-lg-2' : 'col-lg-3' }} col-md-6">
                            <div class="form-group">
                                <select name="tingkat" id="tingkat" class="form-select border-0 shadow-sm border" style="border-color: #e0e0e0 !important;">
                                    <option value="">Tingkat</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <select name="kode_ta" id="kode_ta_search" class="form-select border-0 shadow-sm border" style="border-color: #e0e0e0 !important;">
                                    <option value="">Pilih Tahun Ajaran</option>
                                    @foreach ($tahunajaran as $d)
                                        <option value="{{ $d->kode_ta }}"
                                            @if(!empty(Request('kode_ta')))
                                                {{ Request('kode_ta') == $d->kode_ta ? 'selected' : '' }}
                                            @else
                                                {{ $d->kode_ta == $tahun_ajaran->kode_ta ? 'selected' : '' }}
                                            @endif 
                                        >
                                            {{ $d->tahun_ajaran }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-2 col-md-6">
                            <button class="btn btn-primary w-100 p-2 d-flex align-items-center justify-content-center gap-2" style="background-color: #064e3b; border-color: #064e3b">
                                <i class="ti ti-search fs-5"></i>
                                <span>Cari</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table Data Master -->
        <div class="card shadow-sm">
            <div class="card-header d-flex align-items-center gap-2 text-white py-3" style="background-color: #064e3b">
                <i class="ti ti-layout-grid fs-5"></i>
                <h6 class="card-title mb-0 text-white">Data Pendaftaran</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background-color: #064e3b">
                            <tr>
                                <th class="text-white py-3">NO.</th>
                                <th class="text-white py-3">FOTO</th>
                                <th class="text-white py-3">NO. PENDAFTARAN</th>
                                <th class="text-white py-3">ID SISWA</th>
                                <th class="text-white py-3">NISN/NIS</th>
                                <th class="text-white py-3">NAMA LENGKAP</th>
                                <th class="text-white py-3">J. KELAMIN</th>
                                <th class="text-white py-3">UNIT</th>
                                <th class="text-white py-3 text-end" style="width: 150px;">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pendaftaran as $d)
                                <tr>
                                    <td class="py-1">{{ $loop->iteration + $pendaftaran->firstItem() - 1 }}</td>
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
                                    <td class="py-1"><span class="fw-bold">{{ $d->no_pendaftaran }}</span></td>
                                    <td class="py-1">{{ $d->id_siswa }}</td>
                                    <td class="py-1">
                                        <div class="small text-muted">NISN: {{ $d->nisn ?? '-' }}</div>
                                        <div class="small fw-bold">NIS: {{ $d->nis ?? '-' }}</div>
                                    </td>
                                    <td class="py-1">
                                        <span class="fw-bold text-dark">{{ $d->nama_lengkap }}</span>
                                        <div class="small text-muted">{{ !empty($d->tanggal_lahir) ? DateToIndo($d->tanggal_lahir) : '-' }}</div>
                                    </td>
                                    <td class="py-1">
                                        @if($d->jenis_kelamin == 'L')
                                            <span class="badge bg-label-info">Laki-laki</span>
                                        @else
                                            <span class="badge bg-label-danger">Perempuan</span>
                                        @endif
                                    </td>
                                    <td class="py-1">{{ $d->nama_unit }}</td>
                                    <td class="py-1 text-end">
                                        <div class="d-flex justify-content-end gap-1">
                                            @can('pendaftaran.edit')
                                                <a href="#" class="btn btn-icon btn-label-success border btnEdit shadow-none"
                                                    style="width: 28px; height: 28px;"
                                                    no_pendaftaran="{{ Crypt::encrypt($d->no_pendaftaran) }}" data-bs-toggle="tooltip" title="Edit Data">
                                                    <i class="ti ti-edit fs-6"></i>
                                                </a>
                                            @endcan
                                            @can('pendaftaran.show')
                                                <a href="#" class="btn btn-icon btn-label-info border btnShow shadow-none"
                                                    style="width: 28px; height: 28px;"
                                                    no_pendaftaran="{{ Crypt::encrypt($d->no_pendaftaran) }}" data-bs-toggle="tooltip" title="Detail Data">
                                                    <i class="ti ti-file-description fs-6"></i>
                                                </a>
                                                <a href="{{ route('pendaftaran.cetak-id-card', Crypt::encrypt($d->no_pendaftaran)) }}" target="_blank" class="btn btn-icon btn-label-primary border shadow-none"
                                                    style="width: 28px; height: 28px;" data-bs-toggle="tooltip" title="Cetak ID Card">
                                                    <i class="ti ti-id-badge fs-6"></i>
                                                </a>
                                            @endcan
                                            @can('pendaftaran.delete')
                                                <form method="POST" class="deleteform d-inline" action="/pendaftaran/{{ Crypt::encrypt($d->no_pendaftaran) }}/delete">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="#" class="btn btn-icon btn-label-danger border delete-confirm shadow-none"
                                                        style="width: 28px; height: 28px;" data-bs-toggle="tooltip" title="Hapus Data">
                                                        <i class="ti ti-trash fs-6"></i>
                                                    </a>
                                                </form>
                                            @endcan
                                            @can('pendaftaran.edit')
                                                <a href="#" class="btn btn-icon btn-label-warning border btnRfid shadow-none"
                                                    style="width: 28px; height: 28px;"
                                                    no_pendaftaran="{{ Crypt::encrypt($d->no_pendaftaran) }}"
                                                    nama_siswa="{{ $d->nama_lengkap }}" rfid_code="{{ $d->rfid_code ?? '' }}"
                                                    data-bs-toggle="tooltip" title="{{ $d->rfid_code ? 'Edit RFID' : 'Tambah RFID' }}">
                                                    <i class="ti ti-id-badge fs-6 {{ $d->rfid_code ? 'text-success' : '' }}"></i>
                                                </a>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center p-5">
                                        <div class="mb-3">
                                            <i class="ti ti-clipboard-list fs-1 opacity-25"></i>
                                        </div>
                                        <h5>Belum Ada Data Pendaftaran</h5>
                                        <p class="text-muted small">Silahkan sesuaikan filter atau tambah data baru.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-4 py-3 border-top">
                    <div style="float: right;">
                        {{ $pendaftaran->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<x-modal-form id="modal" size="modal-lg" show="loadmodal" title="" icon="ti ti-clipboard-list" />
<x-modal-form id="modalSekolah" size="" show="loadmodal" title="" icon="ti ti-school" />
<x-modal-form id="modalRfid" size="modal-md" show="loadmodalRfid" title="" icon="ti ti-id-badge" />

<div class="modal fade" id="modalSiswa" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header py-3" style="background-color: #064e3b">
                <h4 class="modal-title mb-0 text-white" id="myModalLabel18">
                    <i class="ti ti-users me-2"></i>Data Siswa
                </h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <table class="table table-hover table-bordered" id="tabelsiswa">
                    <thead style="background-color: #064e3b">
                        <tr>
                            <th class="text-white">ID SISWA</th>
                            <th class="text-white">NAMA LENGKAP</th>
                            <th class="text-white">JENIS KELAMIN</th>
                            <th class="text-white">TAHUN MASUK</th>
                            <th class="text-white text-center">#</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
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

        $("#btnCreate").click(function(e) {
            e.preventDefault();
            const tahun_ajaran = "{{ $tahun_ajaran->tahun_ajaran }}";
            $("#modal").modal("show");
            $("#modal").find("#loadmodal").html(loading);
            $("#modal").find(".modal-title").text("Pendaftaran Tahun Ajaran " + tahun_ajaran);
            $("#loadmodal").load(`/pendaftaran/create`);
        });

        $(".btnEdit").click(function(e) {
            e.preventDefault();
            const no_pendaftaran = $(this).attr("no_pendaftaran");
            $("#modal").modal("show");
            $("#modal").find("#loadmodal").html(loading);
            $("#modal").find(".modal-title").text("Edit Pendaftaran ");
            $("#loadmodal").load(`/pendaftaran/${no_pendaftaran}/edit`);
        });

        $(".btnShow").click(function(e) {
            e.preventDefault();
            const no_pendaftaran = $(this).attr("no_pendaftaran");
            $("#modal").modal("show");
            $("#modal").find("#loadmodal").html(loading);
            $("#modal").find(".modal-title").text("Detail Pendaftaran");
            $("#loadmodal").load(`/pendaftaran/${no_pendaftaran}/show`);
        });

        $(".btnRfid").click(function(e) {
            e.preventDefault();
            const no_pendaftaran = $(this).attr("no_pendaftaran");
            const namaSiswa = $(this).attr("nama_siswa");
            const rfidCode = $(this).attr("rfid_code");

            $("#modalRfid").modal("show");
            $("#modalRfid").find("#loadmodalRfid").html(`
                <form id="formRfid" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Nama Siswa</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text bg-light text-muted"><i class="ti ti-user"></i></span>
                            <input type="text" class="form-control bg-light" value="${namaSiswa}" readonly>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">RFID Code</label>
                        <div class="input-group input-group-merge border rounded shadow-none" style="border-color: #e0e0e0 !important;">
                            <span class="input-group-text bg-white border-0"><i class="ti ti-id-badge"></i></span>
                            <input type="text" class="form-control border-0 ps-2" id="rfid_input" value="${rfidCode}" placeholder="Scan atau Ketik Kode RFID" autocomplete="off">
                        </div>
                        <div class="form-text mt-1 text-muted small">Kosongkan untuk menghapus RFID</div>
                    </div>
                    <div class="form-group d-flex gap-2">
                        <button type="button" class="btn btn-label-secondary flex-grow-1" data-bs-dismiss="modal">
                            <i class="ti ti-x me-1"></i> Batal
                        </button>
                        <button type="button" class="btn btn-primary flex-grow-1" style="background-color: #064e3b; border-color: #064e3b" onclick="saveRfid('${no_pendaftaran}')">
                            <i class="ti ti-device-floppy me-1"></i> Simpan
                        </button>
                    </div>
                </form>
            `);
            $("#modalRfid").find(".modal-title").text("Atur RFID");
            setTimeout(() => $("#rfid_input").focus(), 500);
        });

        // Initialize DataTables for modalSiswa
        $('#tabelsiswa').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ url()->current() }}',
            columns: [
                { data: 'id_siswa', name: 'id_siswa' },
                { data: 'nama_lengkap', name: 'nama_lengkap' },
                { data: 'jenis_kelamin', name: 'jenis_kelamin' },
                { data: 'tahun_masuk', name: 'tahun_masuk' },
                { data: 'action', name: 'action', className: 'text-center' }
            ],
            language: {
                search: "Cari Siswa:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data"
            }
        });

        // Konfirmasi Delete
        $(".delete-confirm").click(function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data pendaftaran akan dihapus secara permanen!",
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

        window.saveRfid = function(no_pendaftaran) {
            const rfidCode = document.getElementById('rfid_input').value.trim();

            fetch(`/pendaftaran/${no_pendaftaran}/update-rfid`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ rfid_code: rfidCode })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        timer: 2000,
                        showConfirmButton: false,
                        confirmButtonColor: '#064e3b'
                    }).then(() => location.reload());
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: data.message,
                        confirmButtonColor: '#064e3b'
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan pada server!',
                    confirmButtonColor: '#064e3b'
                });
            });
        };

        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        function getTingkatByUnit(kode_unit, selected = '') {
            selected = "{{ Request('tingkat') }}";
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

        @if ($isU06)
            getTingkatByUnit("{{ Request('kode_unit') }}");
        @else
            getTingkatByUnit("{{ auth()->user()->kode_unit }}");
        @endif
    });
</script>
@endpush

@extends('layouts.app')
@section('titlepage', 'Data Siswa')

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
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Data Siswa</h4>
                        <p class="text-muted mb-0 small">Manajemen data siswa aktif berdasarkan biaya</p>
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
                                <i class="ti ti-users me-1"></i> Data Siswa
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
                                    <span class="small">Total Siswa</span>
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
                <form action="{{ route('akademiksiswa.index') }}">
                    <div class="row g-3 align-items-center">
                        @php
                            $isU06 = auth()->user()->kode_unit == 'U06';
                        @endphp
                        
                        <div class="col">
                            <x-input-with-icon label="" value="{{ Request('nama_lengkap') }}" name="nama_lengkap"
                                placeholder="Cari Nama Siswa" icon="ti ti-search" />
                        </div>

                        @if ($isU06)
                            <div class="col-md-2 col-12">
                                <div class="form-group mb-3">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="ti ti-school text-muted"></i></span>
                                        <select name="kode_unit" id="kode_unit_search" class="form-select">
                                            <option value="">Semua Unit</option>
                                            @foreach ($unit as $d)
                                                <option value="{{ $d->kode_unit }}" {{ Request('kode_unit') == $d->kode_unit ? 'selected' : '' }}>
                                                    {{ $d->nama_unit }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="col-md-2 col-6">
                            <div class="form-group mb-3">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="ti ti-chart-bar text-muted"></i></span>
                                    <select name="tingkat" id="tingkat" class="form-select">
                                        <option value="">Tingkat</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2 col-6">
                            <div class="form-group mb-3">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="ti ti-door-enter text-muted"></i></span>
                                    <select name="kode_kelas" id="kode_kelas_search" class="form-select">
                                        <option value="">Kelas</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2 col-6">
                            <div class="form-group mb-3">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="ti ti-calendar-event text-muted"></i></span>
                                    <select name="kode_ta" id="kode_ta_search" class="form-select">
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
                        </div>

                        <div class="col-auto">
                            <div class="form-group mb-3">
                                <button class="btn btn-primary d-flex align-items-center justify-content-center gap-2" style="background-color: #064e3b; border-color: #064e3b; height: 38px;">
                                    <i class="ti ti-search fs-5"></i>
                                    <span>Cari</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Data List (Modern Cards) -->
        <div class="row g-3">
            @forelse ($pendaftaran as $d)
                <div class="col-12">
                    <div class="card shadow-sm border h-100 overflow-hidden" style="background-color: #ffffff; border-color: #e2e8f0 !important;">
                        <div class="card-body p-3">
                            <div class="row align-items-center">
                                <!-- Photo & Primary Info -->
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="d-flex align-items-center">
                                        <!-- Nomor Urut -->
                                        <div class="d-flex align-items-center justify-content-center rounded-circle me-3 fw-bold shadow-sm" style="width: 32px; height: 32px; min-width: 32px; font-size: 0.85rem; background-color: #f0fdf4; color: #064e3b; border: 1px dashed #064e3b;">
                                            {{ $loop->iteration + $pendaftaran->firstItem() - 1 }}
                                        </div>

                                        @if ($d->foto_pendaftaran && Storage::disk('public')->exists('photos/pendaftaran/' . $d->foto_pendaftaran))
                                            <div class="avatar border rounded overflow-hidden shadow-sm me-3" style="width: 48px; height: 60px; min-width: 48px;">
                                                <img src="{{ asset('storage/photos/pendaftaran/' . $d->foto_pendaftaran) }}" alt="Foto" style="width: 100%; height: 100%; object-fit: cover;">
                                            </div>
                                        @else
                                            <div class="avatar d-flex align-items-center justify-content-center bg-label-success border rounded shadow-none me-3" style="width: 48px; height: 60px; min-width: 48px;">
                                                <i class="ti ti-user fs-3 opacity-75" style="color: #064e3b;"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <h6 class="mb-1 fw-bold text-dark" style="font-size: 0.95rem;">{{ $d->nama_lengkap }}</h6>
                                            <div class="d-flex flex-wrap align-items-center gap-2">
                                                <span class="badge bg-label-success d-inline-flex align-items-center" style="font-size: 0.65rem;">
                                                    <i class="ti ti-school me-1" style="font-size: 0.75rem;"></i>{{ $d->nama_unit }}
                                                </span>
                                                <span class="badge bg-label-primary d-inline-flex align-items-center" style="font-size: 0.65rem;">
                                                    <i class="ti ti-chart-bar me-1" style="font-size: 0.75rem;"></i>Tingkat {{ $d->tingkat }}
                                                </span>
                                                @if($d->jenis_kelamin == 'L')
                                                    <span class="badge bg-label-info d-inline-flex align-items-center" style="font-size: 0.65rem;">
                                                        <i class="ti ti-gender-male me-1" style="font-size: 0.75rem;"></i>Laki-laki
                                                    </span>
                                                @else
                                                    <span class="badge bg-label-danger d-inline-flex align-items-center" style="font-size: 0.65rem;">
                                                        <i class="ti ti-gender-female me-1" style="font-size: 0.75rem;"></i>Perempuan
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Identity & Date of Birth -->
                                <div class="col-lg-3 col-md-6 col-sm-12 border-start-lg ps-lg-4 mt-3 mt-md-0">
                                    <div class="d-flex flex-column gap-1">
                                        <div class="text-muted small">ID / TTL</div>
                                        <span class="fw-bold text-dark d-inline-flex align-items-center gap-1" style="font-size: 0.85rem;">
                                            <i class="ti ti-fingerprint text-success" style="font-size: 1rem;"></i> {{ $d->id_siswa }}
                                        </span>
                                        <span class="text-muted small d-inline-flex align-items-center gap-1">
                                            <i class="ti ti-cake text-warning" style="font-size: 0.85rem;"></i> {{ !empty($d->tanggal_lahir) ? DateToIndo($d->tanggal_lahir) : '-' }}
                                        </span>
                                    </div>
                                </div>
                                
                                <!-- NIS/NISN & Kelas -->
                                <div class="col-lg-3 col-md-6 col-sm-12 border-start-lg ps-lg-4 mt-3 mt-lg-0">
                                    <div class="row">
                                        <div class="col-6 d-flex flex-column gap-1">
                                            <div class="text-muted small">Nomor Induk</div>
                                            <div class="small text-dark d-flex align-items-center gap-1" style="font-size: 0.8rem;">
                                                <i class="ti ti-id text-muted" style="font-size: 0.85rem;"></i>NISN: <span class="fw-bold">{{ $d->nisn ?? '-' }}</span>
                                            </div>
                                            <div class="small text-dark d-flex align-items-center gap-1" style="font-size: 0.8rem;">
                                                <i class="ti ti-hash text-muted" style="font-size: 0.85rem;"></i>NIS: <span class="fw-bold">{{ $d->nis ?? '-' }}</span>
                                            </div>
                                        </div>
                                        <div class="col-6 border-start ps-3">
                                            <div class="text-muted small">Kelas</div>
                                            <span class="badge bg-success text-white px-3 py-1 mt-1 d-inline-flex align-items-center gap-1" style="background-color: #064e3b !important; font-size: 0.75rem;">
                                                <i class="ti ti-door-enter" style="font-size: 0.85rem;"></i> {{ $d->nama_kelas ?? 'Belum Set' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Actions -->
                                <div class="col-lg-2 col-md-6 col-sm-12 text-end mt-3 mt-lg-0">
                                    <div class="d-flex justify-content-end gap-1">
                                        @can('pendaftaran.edit')
                                            <a href="#" class="btn btn-icon btn-label-success border btnEdit shadow-none"
                                                style="width: 32px; height: 32px;"
                                                no_pendaftaran="{{ Crypt::encrypt($d->no_pendaftaran) }}" data-bs-toggle="tooltip" title="Edit Data">
                                                <i class="ti ti-edit fs-5"></i>
                                            </a>
                                        @endcan
                                        @can('pendaftaran.show')
                                            <a href="#" class="btn btn-icon btn-label-info border btnShow shadow-none"
                                                style="width: 32px; height: 32px;"
                                                no_pendaftaran="{{ Crypt::encrypt($d->no_pendaftaran) }}" data-bs-toggle="tooltip" title="Detail Data">
                                                <i class="ti ti-file-description fs-5"></i>
                                            </a>
                                            <a href="{{ route('pendaftaran.cetak-id-card', Crypt::encrypt($d->no_pendaftaran)) }}" target="_blank" class="btn btn-icon btn-label-primary border shadow-none"
                                                style="width: 32px; height: 32px;" data-bs-toggle="tooltip" title="Cetak ID Card">
                                                <i class="ti ti-id-badge fs-5"></i>
                                            </a>
                                        @endcan
                                        @can('pendaftaran.edit')
                                            <a href="#" class="btn btn-icon btn-label-warning border btnRfid shadow-none"
                                                style="width: 32px; height: 32px;"
                                                no_pendaftaran="{{ Crypt::encrypt($d->no_pendaftaran) }}"
                                                nama_siswa="{{ $d->nama_lengkap }}" rfid_code="{{ $d->rfid_code ?? '' }}"
                                                data-bs-toggle="tooltip" title="{{ $d->rfid_code ? 'Edit RFID' : 'Tambah RFID' }}">
                                                <i class="ti ti-id-badge fs-5 {{ $d->rfid_code ? 'text-success' : '' }}"></i>
                                            </a>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-body text-center p-5">
                            <div class="mb-3">
                                <i class="ti ti-users fs-1 opacity-25" style="color: #064e3b;"></i>
                            </div>
                            <h5>Belum Ada Data Siswa</h5>
                            <p class="text-muted small mb-0">Silahkan sesuaikan filter pencarian Anda.</p>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-end mt-4 mb-5">
            {{ $pendaftaran->links() }}
        </div>

    </div>
</div>

<x-modal-form id="modal" size="modal-lg" show="loadmodal" title="" icon="ti ti-clipboard-list" />
<x-modal-form id="modalSekolah" size="" show="loadmodal" title="" icon="ti ti-school" />
<x-modal-form id="modalRfid" size="modal-md" show="loadmodalRfid" title="" icon="ti ti-id-badge" />

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

        function getKelasByTingkat(kode_unit, tingkat, kode_ta, selected = '') {
            selected = "{{ Request('kode_kelas') }}";
            $.ajax({
                type: "POST",
                url: "{{ route('unit.getkelasbytingkat') }}",
                cache: false,
                data: {
                    _token: "{{ csrf_token() }}",
                    kode_unit: kode_unit,
                    tingkat: tingkat,
                    kode_ta: kode_ta,
                    selected: selected
                },
                success: function(respond) {
                    $(document).find("#kode_kelas_search").html(respond);
                }
            });
        }

        $(document).on('change', '#kode_unit_search', function() {
            const kode_unit = $(this).val();
            getTingkatByUnit(kode_unit);
            getKelasByTingkat(kode_unit, '', $('#kode_ta_search').val());
        });

        $(document).on('change', '#tingkat', function() {
            const tingkat = $(this).val();
            const kode_unit = $('#kode_unit_search').length ? $('#kode_unit_search').val() : "{{ auth()->user()->kode_unit }}";
            const kode_ta = $('#kode_ta_search').val();
            getKelasByTingkat(kode_unit, tingkat, kode_ta);
        });

        $(document).on('change', '#kode_ta_search', function() {
            const kode_ta = $(this).val();
            const kode_unit = $('#kode_unit_search').length ? $('#kode_unit_search').val() : "{{ auth()->user()->kode_unit }}";
            const tingkat = $('#tingkat').val();
            getKelasByTingkat(kode_unit, tingkat, kode_ta);
        });

        @if ($isU06)
            getTingkatByUnit("{{ Request('kode_unit') }}");
            getKelasByTingkat("{{ Request('kode_unit') }}", "{{ Request('tingkat') }}", "{{ Request('kode_ta') ?: ($tahun_ajaran->kode_ta ?? '') }}");
        @else
            getTingkatByUnit("{{ auth()->user()->kode_unit }}");
            getKelasByTingkat("{{ auth()->user()->kode_unit }}", "{{ Request('tingkat') }}", "{{ Request('kode_ta') ?: ($tahun_ajaran->kode_ta ?? '') }}");
        @endif
    });
</script>
@endpush

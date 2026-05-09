@extends('layouts.app')
@section('titlepage', 'Presensi Mata Pelajaran')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-checklist fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Presensi Mata Pelajaran</h4>
                        <p class="text-muted mb-0 small">Monitoring kehadiran siswa per mata pelajaran</p>
                    </div>
                </div>
                <div class="d-flex flex-column align-items-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mb-0">
                            <li class="breadcrumb-item">
                                <a href="javascript:void(0);" class="text-muted">
                                    <i class="ti ti-database me-1"></i> Akademik
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                <i class="ti ti-checklist me-1"></i> Presensi Mata Pelajaran
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
            <button class="btn d-flex align-items-center gap-2 shadow-sm text-white" id="btnInputPresensi"
                style="background-color: #064e3b">
                <i class="ti ti-plus fs-4"></i>
                <span>Input Presensi</span>
            </button>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form action="{{ route('presensi-mapel.index') }}" method="GET">
                    <div class="row g-2">
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <select name="kode_unit" id="kode_unit" class="form-select select2">
                                <option value="">Semua Unit</option>
                                @foreach ($units as $u)
                                    <option value="{{ $u->kode_unit }}" {{ Request('kode_unit') == $u->kode_unit ? 'selected' : '' }}>
                                        {{ $u->nama_unit }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <select name="kode_kelas" id="kode_kelas" class="form-select select2">
                                <option value="">Semua Kelas</option>
                                @foreach ($kelas as $k)
                                    <option value="{{ $k->kode_kelas }}" {{ Request('kode_kelas') == $k->kode_kelas ? 'selected' : '' }}>
                                        {{ $k->nama_kelas }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="input-group input-group-merge border shadow-none rounded-2" style="border-color: #ced4da !important;">
                                <span class="input-group-text bg-white border-0"><i class="ti ti-calendar text-muted"></i></span>
                                <input type="text" name="tanggal" class="form-control bg-white border-0 ps-2 flatpickr-date"
                                    value="{{ Request('tanggal') }}" placeholder="Pilih Tanggal">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <button type="submit" class="btn btn-primary w-100 shadow-none" style="background-color: #064e3b; border-color: #064e3b">
                                <i class="ti ti-search me-1"></i> Cari
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row text-nowrap">
            @forelse ($presensi as $p)
                <div class="col-12">
                    <div class="card mb-2 border shadow-none hover-shadow transition">
                        <div class="card-body p-3">
                            <div class="row align-items-center">
                                <!-- Tanggal & Waktu -->
                                <div class="col-lg-3 col-md-6 col-sm-12 border-end">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar me-3 rounded bg-label-info d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;">
                                            <i class="ti ti-calendar-event fs-4"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold text-dark">{{ \Carbon\Carbon::parse($p->tanggal)->translatedFormat('l, d M Y') }}</h6>
                                            <small class="text-muted"><i class="ti ti-clock me-1 small"></i>{{ substr($p->jam_mulai, 0, 5) }} - {{ substr($p->jam_selesai, 0, 5) }}</small>
                                        </div>
                                    </div>
                                </div>
                                <!-- Mapel & Kelas -->
                                <div class="col-lg-3 col-md-6 col-sm-12 border-end">
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold text-dark">{{ $p->mata_pelajaran->nama_matpel ?? '-' }}</span>
                                        <small class="text-muted"><i class="ti ti-chalkboard me-1 small"></i>{{ $p->kelas->nama_kelas ?? '-' }} ({{ $p->unit->nama_unit }})</small>
                                    </div>
                                </div>
                                <!-- Guru -->
                                <div class="col-lg-3 col-md-6 col-sm-12 border-end">
                                    <div class="d-flex flex-column">
                                        <small class="text-muted small">Guru Pengampu</small>
                                        <span class="fw-bold text-dark">{{ $p->guru->karyawan->nama_lengkap ?? '-' }}</span>
                                    </div>
                                </div>
                                <!-- Materi -->
                                <div class="col-lg-1 col-md-6 col-sm-12 border-end text-center">
                                    <small class="d-block text-muted small">Materi</small>
                                    <span class="badge {{ $p->materi ? 'bg-label-success' : 'bg-label-secondary' }}">{{ $p->materi ? 'Ada' : 'Kosong' }}</span>
                                </div>
                                <!-- Actions -->
                                <div class="col-lg-2 col-md-12 col-sm-12 text-end">
                                    <div class="btn-group shadow-sm" role="group">
                                        <a href="{{ route('presensi-mapel.edit', Crypt::encrypt($p->id)) }}" 
                                            class="btn btn-sm btn-outline-warning py-1 px-2 waves-effect" 
                                            data-bs-toggle="tooltip" title="Edit">
                                            <i class="ti ti-edit"></i>
                                        </a>
                                        <form action="{{ route('presensi-mapel.delete', Crypt::encrypt($p->id)) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger py-1 px-2 waves-effect rounded-0 rounded-end delete-confirm" 
                                                data-bs-toggle="tooltip" title="Hapus">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="card shadow-none border p-5 text-center">
                        <div class="mb-3">
                            <i class="ti ti-checklist fs-1 opacity-25 text-muted"></i>
                        </div>
                        <h5>Belum Ada Data Presensi</h5>
                        <p class="text-muted">Silahkan tambah data baru atau sesuaikan filter pencarian.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="mt-3">
            {{ $presensi->appends(request()->all())->links() }}
        </div>
    </div>
</div>

<x-modal-form id="mdlInputPresensi" size="modal-lg" show="loadInputPresensi" title="Pilih Jadwal Pelajaran" />

@push('myscript')
<script>
    $(function() {
        $('.select2').select2();

        $('#btnInputPresensi').click(function(e) {
            e.preventDefault();
            $('#mdlInputPresensi').modal('show');
            $('#loadInputPresensi').load("{{ route('presensi-mapel.create') }}");
        });

        $('#kode_unit').change(function() {
            var kode_unit = $(this).val();
            if (kode_unit) {
                $.ajax({
                    url: "{{ route('jadwal-pelajaran.get-data-by-unit') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        kode_unit: kode_unit
                    },
                    success: function(res) {
                        var opt = '<option value="">Semua Kelas</option>';
                        res.kelas.forEach(function(item) {
                            opt += `<option value="${item.kode_kelas}">${item.nama_kelas}</option>`;
                        });
                        $('#kode_kelas').html(opt);
                    }
                });
            }
        });

        $('.delete-confirm').click(function(e) {
            var form = $(this).closest("form");
            e.preventDefault();
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data presensi akan dihapus permanen!",
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
            })
        });
    });
</script>
@endpush
@endsection

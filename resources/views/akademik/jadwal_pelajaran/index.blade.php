@extends('layouts.app')
@section('titlepage', 'Jadwal Pelajaran')

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
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Jadwal Pelajaran</h4>
                        <p class="text-muted mb-0 small">Manajemen waktu dan agenda mata pelajaran</p>
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
                                <i class="ti ti-calendar-event me-1"></i> Jadwal Pelajaran
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
            @can('jadwalpelajaran.create')
                <button class="btn d-flex align-items-center gap-2 shadow-sm text-white" id="btnCreate"
                    style="background-color: #064e3b">
                    <i class="ti ti-plus fs-4"></i>
                    <span>Tambah Jadwal</span>
                </button>
            @endcan
        </div>

        <!-- Filter Form -->
        <div class="card mb-4 shadow-none border-0 bg-transparent">
            <div class="card-body p-0">
                <form action="{{ route('jadwal-pelajaran.index') }}" method="GET" class="form-filter">
                    <div class="row g-3 align-items-center">
                        <div class="col-md col-12">
                            <div class="form-group mb-3">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="ti ti-calendar-event text-muted"></i></span>
                                    <select name="kode_ta" class="form-select">
                                        @foreach ($semuaTa as $ta)
                                            <option value="{{ $ta->kode_ta }}" {{ $selectedKodeTa == $ta->kode_ta ? 'selected' : '' }}>{{ $ta->tahun_ajaran }} {{ $ta->status == 1 ? '(Aktif)' : '' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        @if (auth()->user()->kode_unit == 'U06' && !auth()->user()->hasRole('guru'))
                            <div class="col-md col-12">
                                <div class="form-group mb-3">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="ti ti-school text-muted"></i></span>
                                        <select name="kode_unit" id="filter_kode_unit" class="form-select">
                                            <option value="">Semua Unit</option>
                                            @foreach ($units as $unit)
                                                <option value="{{ $unit->kode_unit }}" {{ request('kode_unit') == $unit->kode_unit ? 'selected' : '' }}>{{ $unit->nama_unit }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="col-md col-12">
                            <div class="form-group mb-3">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="ti ti-door-enter text-muted"></i></span>
                                    <select name="kode_kelas" id="filter_kode_kelas" class="form-select">
                                        <option value="">Semua Kelas</option>
                                        @foreach ($kelas as $k)
                                            <option value="{{ $k->kode_kelas }}" {{ request('kode_kelas') == $k->kode_kelas ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        @if (!auth()->user()->hasRole('guru'))
                            <div class="col-md col-12">
                                <div class="form-group mb-3">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="ti ti-user text-muted"></i></span>
                                        <select name="guru_id" id="filter_guru_id" class="form-select">
                                            <option value="">Semua Guru</option>
                                            @foreach ($gurus as $guru)
                                                <option value="{{ $guru->id }}" {{ request('guru_id') == $guru->id ? 'selected' : '' }}>{{ $guru->nama_guru }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="col-md col-12">
                            <div class="form-group mb-3">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="ti ti-calendar text-muted"></i></span>
                                    <select name="hari" id="filter_hari" class="form-select">
                                        <option value="">Semua Hari</option>
                                        @foreach ($days as $day)
                                            <option value="{{ $day }}" {{ request('hari') == $day ? 'selected' : '' }}>{{ $day }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md col-12">
                            <div class="form-group mb-3">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="ti ti-clock text-muted"></i></span>
                                    <select name="semester" id="filter_semester" class="form-select">
                                        <option value="">Semua Semester</option>
                                        @foreach ($semesters as $sem)
                                            <option value="{{ $sem }}" {{ request('semester') == $sem ? 'selected' : '' }}>{{ $sem == 1 ? 'Ganjil' : 'Genap' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-auto">
                            <div class="form-group mb-3">
                                <button type="submit" class="btn btn-primary d-flex align-items-center justify-content-center gap-2" style="background-color: #064e3b; border-color: #064e3b; height: 38px;">
                                    <i class="ti ti-search fs-5"></i>
                                    <span>Cari</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row text-nowrap">
                            @forelse ($jadwal as $item)
                            <div class="col-12">
                                <div class="card mb-2 border">
                                    <div class="card-body p-3">
                                        <div class="row align-items-center">
                                            <!-- Hari & Jam -->
                                            <div class="col-lg-3 col-md-6 col-sm-12 border-end">
                                               <div class="d-flex align-items-center">
                                                    <div class="avatar me-3 rounded bg-label-info d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;">
                                                        <i class="ti ti-calendar-time fs-4"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0 fw-bold">{{ $item->hari }}</h6>
                                                        <small class="text-muted">Jam Ke-{{ $item->jam_ke }} ({{ date('H:i', strtotime($item->jam_mulai)) }}-{{ date('H:i', strtotime($item->jam_selesai)) }})</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Mapel & Kelas -->
                                            <div class="col-lg-3 col-md-6 col-sm-12 border-end">
                                                 <div class="d-flex flex-column">
                                                    <span class="fw-bold text-dark">{{ $item->mapel->nama_matpel ?? '-' }}</span>
                                                    <small class="text-muted"><i class="ti ti-chalkboard me-1"></i>Kelas {{ $item->kelas->nama_kelas ?? '-' }}</small>
                                                </div>
                                            </div>
                                            <!-- Guru -->
                                            <div class="col-lg-2 col-md-6 col-sm-12 border-end">
                                                 <div class="d-flex flex-column">
                                                    <small class="text-muted">Guru Pengampu</small>
                                                    <span class="fw-bold">{{ $item->guru->nama_guru ?? '-' }}</span>
                                                </div>
                                            </div>
                                            <!-- Tahun Ajaran -->
                                            <div class="col-lg-1 col-md-6 col-sm-12 border-end text-center">
                                                <small class="d-block text-muted">TA</small>
                                                <span class="fw-bold text-primary" style="font-size: 0.75rem;">{{ $item->tahunAjaran->tahun_ajaran ?? '-' }}</span>
                                            </div>
                                            <!-- Semester -->
                                            <div class="col-lg-1 col-md-6 col-sm-12 border-end text-center">
                                                <small class="d-block text-muted">Sem.</small>
                                                <span class="badge bg-label-secondary">{{ $item->semester == 1 ? 'Ganjil' : 'Genap' }}</span>
                                            </div>
                                            <!-- Actions -->
                                            <div class="col-lg-2 col-md-12 col-sm-12 text-end">
                                                <div class="btn-group shadow-sm" role="group">
                                                     @if (auth()->check() && (auth()->user()->can('jadwalpelajaran.index') || auth()->user()->hasRole('guru')))
                                                         <a href="{{ route('presensi-mapel.input', [Crypt::encrypt($item->id), date('Y-m-d')]) }}" class="btn btn-sm btn-outline-success py-1 px-2 waves-effect" data-bs-toggle="tooltip" title="Presensi">
                                                             <i class="ti ti-checklist"></i>
                                                         </a>
                                                         <a href="{{ route('jadwal-pelajaran.cetak-presensi', Crypt::encrypt($item->id)) }}" target="_blank" class="btn btn-sm btn-outline-info py-1 px-2 waves-effect" data-bs-toggle="tooltip" title="Cetak Presensi">
                                                             <i class="ti ti-printer"></i>
                                                         </a>
                                                         <a href="{{ route('penilaian.index', $item->id) }}" class="btn btn-sm btn-outline-primary py-1 px-2 waves-effect" data-bs-toggle="tooltip" title="Penilaian">
                                                             <i class="ti ti-chart-bar"></i>
                                                         </a>
                                                     @endif
                                                    @can('jadwalpelajaran.edit')
                                                        <a href="#" class="btn btn-sm btn-outline-warning btnEdit py-1 px-2 waves-effect" data-id="{{ Crypt::encrypt($item->id) }}" data-bs-toggle="tooltip" title="Edit">
                                                            <i class="ti ti-edit"></i>
                                                        </a>
                                                    @endcan
                                                    @can('jadwalpelajaran.delete')
                                                        <form action="{{ route('jadwal-pelajaran.delete', Crypt::encrypt($item->id)) }}" method="POST" class="d-inline delete-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger delete-confirm rounded-0 rounded-end py-1 px-2 waves-effect" data-bs-toggle="tooltip" title="Hapus">
                                                                <i class="ti ti-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endcan
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-12">
                                <div class="alert alert-warning text-center">
                                    Data Jadwal Pelajaran belum tersedia.
                                </div>
                            </div>
                            @endforelse
                        </div>
    </div>
</div>

<x-modal-form id="mdlCreateJadwal" size="" show="loadCreateJadwal" title="Tambah Jadwal Pelajaran" />
<x-modal-form id="mdlEditJadwal" size="" show="loadEditJadwal" title="Edit Jadwal Pelajaran" />

@endsection

@push('myscript')
<script>
    $(document).ready(function() {
        $('.select2').select2();

         // Dynamic Filter: Unit -> Kelas & Guru
         $("#filter_kode_unit").change(function() {
            var kode_unit = $(this).val();
            
            if(kode_unit) {
                // Show loading state
                $("#filter_kode_kelas").html('<option value="">Loading...</option>').prop('disabled', true);
                $("#filter_guru_id").html('<option value="">Loading...</option>').prop('disabled', true);
                
                $.ajax({
                    url: "{{ route('jadwal-pelajaran.get-data-by-unit') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        kode_unit: kode_unit
                    },
                    dataType: "json",
                    success: function(data) {
                        if(data.status == 'success') {
                            // Populate Kelas
                            var kelasOptions = '<option value="">Semua Kelas</option>';
                            $.each(data.kelas, function(key, value) {
                                kelasOptions += '<option value="'+ value.kode_kelas +'">'+ value.nama_kelas +'</option>';
                            });
                            $("#filter_kode_kelas").html(kelasOptions).prop('disabled', false);

                            // Populate Guru
                            var guruOptions = '<option value="">Semua Guru</option>';
                            $.each(data.guru, function(key, value) {
                                guruOptions += '<option value="'+ value.id +'">'+ value.nama_guru +'</option>';
                            });
                            $("#filter_guru_id").html(guruOptions).prop('disabled', false);

                        } else {
                            alert("Error: " + data.message);
                        }
                    },
                    error: function() {
                        alert("Terjadi kesalahan saat mengambil data.");
                        $("#filter_kode_kelas").html('<option value="">Semua Kelas</option>').prop('disabled', false);
                        $("#filter_guru_id").html('<option value="">Semua Guru</option>').prop('disabled', false);
                    }
                });
            } else {
                 window.location.href = "{{ route('jadwal-pelajaran.index') }}";
            }
        });

         // Delete Confirmation
         $(document).on('click', '.delete-confirm', function(e) {
            var form = $(this).closest("form");
            e.preventDefault();
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data jadwal pelajaran akan dihapus permanen!",
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

        // Create
        $('#btnCreate').on('click', function(e) {
            e.preventDefault();
            $('#mdlCreateJadwal').modal('show');
            $('#loadCreateJadwal').load('{{ route("jadwal-pelajaran.create") }}');
        });

        // Edit
        $(document).on('click', '.btnEdit', function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            $('#mdlEditJadwal').modal('show');
            $('#loadEditJadwal').load('/jadwal-pelajaran/' + id + '/edit');
        });
    });
</script>
@endpush

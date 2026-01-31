@extends('layouts.app')
@section('titlepage', 'Jadwal Pelajaran')

@section('content')
@section('navigasi')
    <span>Jadwal Pelajaran</span>
@endsection
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="card">
             <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                         @if ($semuaTa->count() > 0)
                            @php
                                $currentTa = $semuaTa->firstWhere('kode_ta', $selectedKodeTa);
                            @endphp
                            @if($currentTa)
                               <span class="badge bg-label-primary">{{ $currentTa->tahun_ajaran }} ({{ $currentTa->semester == 1 ? 'Ganjil' : 'Genap' }})</span>
                            @else
                                <span class="badge bg-label-danger">Tahun Ajaran Tidak Ditemukan</span>
                            @endif
                        @else
                            <span class="badge bg-label-danger">Tidak ada Tahun Ajaran</span>
                        @endif
                    </div>
                    @can('jadwalpelajaran.create')
                        <a href="#" class="btn btn-primary" id="btnCreate"><i class="fa fa-plus me-2"></i> Tambah Jadwal</a>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                         <form action="{{ route('jadwal-pelajaran.index') }}" method="GET">
                             <div class="row">
                                 <div class="col-lg-12 col-sm-12 col-md-12 mb-1">
                                     <select name="kode_ta" class="form-select select2">
                                         @foreach ($semuaTa as $ta)
                                             <option value="{{ $ta->kode_ta }}" {{ $selectedKodeTa == $ta->kode_ta ? 'selected' : '' }}>{{ $ta->tahun_ajaran }} ({{ $ta->semester == 1 ? 'Ganjil' : 'Genap' }}) {{ $ta->status == 1 ? '(Aktif)' : '' }}</option>
                                         @endforeach
                                     </select>
                                 </div>
                                 <div class="col-lg-3 col-sm-12 col-md-12 mb-1">
                                     <select name="kode_unit" id="filter_kode_unit" class="form-select select2">
                                        <option value="">Semua Unit</option>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->kode_unit }}" {{ request('kode_unit') == $unit->kode_unit ? 'selected' : '' }}>{{ $unit->nama_unit }}</option>
                                        @endforeach
                                    </select>
                                 </div>
                                 <div class="col-lg-2 col-sm-12 col-md-12 mb-1">
                                      <select name="kode_kelas" id="filter_kode_kelas" class="form-select select2">
                                        <option value="">Semua Kelas</option>
                                        @foreach ($kelas as $k)
                                            <option value="{{ $k->kode_kelas }}" {{ request('kode_kelas') == $k->kode_kelas ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                                        @endforeach
                                    </select>
                                 </div>
                                  <div class="col-lg-3 col-sm-12 col-md-12 mb-1">
                                      <select name="guru_id" id="filter_guru_id" class="form-select select2">
                                        <option value="">Semua Guru</option>
                                        @foreach ($gurus as $guru)
                                            <option value="{{ $guru->id }}" {{ request('guru_id') == $guru->id ? 'selected' : '' }}>{{ $guru->nama_guru }}</option>
                                        @endforeach
                                    </select>
                                 </div>
                                  <div class="col-lg-2 col-sm-12 col-md-12 mb-1">
                                      <select name="hari" id="filter_hari" class="form-select select2">
                                        <option value="">Semua Hari</option>
                                        @php
                                            $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Ahad'];
                                        @endphp
                                        @foreach ($days as $day)
                                            <option value="{{ $day }}" {{ request('hari') == $day ? 'selected' : '' }}>{{ $day }}</option>
                                        @endforeach
                                    </select>
                                 </div>
                                 <div class="col-lg-2 col-sm-12 col-md-12 mb-1">
                                    <select name="semester" id="filter_semester" class="form-select select2">
                                      <option value="">Semua Semester</option>
                                      <option value="1" {{ request('semester') == '1' ? 'selected' : '' }}>Ganjil</option>
                                      <option value="2" {{ request('semester') == '2' ? 'selected' : '' }}>Genap</option>
                                  </select>
                               </div>
                                 <div class="col-lg-12 col-sm-12 col-md-12 mb-3">
                                     <button type="submit" class="btn btn-primary w-100"><i class="ti ti-search me-1"></i> Cari</button>
                                 </div>
                             </div>
                        </form>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="row">
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
                                            <div class="col-lg-3 col-md-6 col-sm-12 border-end">
                                                 <div class="d-flex flex-column">
                                                    <small class="text-muted">Guru Pengampu</small>
                                                    <span class="fw-bold">{{ $item->guru->nama_guru ?? '-' }}</span>
                                                </div>
                                            </div>
                                            <!-- Semester -->
                                            <div class="col-lg-1 col-md-6 col-sm-12 border-end text-center">
                                                <small class="d-block text-muted">Sem.</small>
                                                <span class="badge bg-label-secondary">{{ $item->semester == 1 ? 'Ganjil' : 'Genap' }}</span>
                                            </div>
                                            <!-- Actions -->
                                            <div class="col-lg-2 col-md-12 col-sm-12 text-end">
                                                <div class="btn-group shadow-sm" role="group">
                                                    @can('jadwalpelajaran.index') <!-- adjust permission if needed -->
                                                        <a href="{{ route('penilaian.index', $item->id) }}" class="btn btn-sm btn-outline-primary py-1 px-2 waves-effect" data-bs-toggle="tooltip" title="Penilaian">
                                                            <i class="ti ti-chart-bar"></i>
                                                        </a>
                                                    @endcan
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
            </div>
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
                 // If "Semua Unit" selected, maybe reset or keep all? 
                 // Current logic backend sends all if no unit selected during page load. 
                 // But here we are client side. Hard to revert to "All" without reloading page or fetching all.
                 // Simplest UX: Reload page or fetch All.
                 // Let's reload page to reset filters cleanly or just clear them.
                 // For now, let's clear them to encourage selection, OR fetch all.
                 // To avoid complexity, let's just reload the page if they switch back to 'Semua Unit' to get fresh 'All' data
                 window.location.href = "{{ route('jadwal-pelajaran.index') }}";
            }
        });

         // Delete Confirmation
         $('.delete-confirm').click(function(e) {
            var form = $(this).closest("form");
            e.preventDefault();
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!'
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
        $('.btnEdit').on('click', function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            $('#mdlEditJadwal').modal('show');
            $('#loadEditJadwal').load('/jadwal-pelajaran/' + id + '/edit');
        });
    });
</script>
@endpush

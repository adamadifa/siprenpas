@extends('layouts.app')
@section('titlepage', 'Monitoring Presensi Siswa')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-calendar-check fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Monitoring Presensi Siswa</h4>
                        <p class="text-muted mb-0 small">Monitoring kehadiran harian siswa</p>
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
                                <i class="ti ti-calendar-check me-1"></i> Monitoring Presensi
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
        <!-- Filter Form -->
        <style>
            .form-filter .form-group {
                margin-bottom: 0 !important;
            }
        </style>
        <div class="card mb-4 shadow-none border-0 bg-transparent">
            <div class="card-body p-0">
                <form action="{{ route('presensisiswa.index') }}" class="form-filter">
                    <div class="row g-3 align-items-center">
                        <div class="col-lg-3 col-md-6">
                            <x-input-with-icon label="" value="{{ Request('nama_lengkap') }}" name="nama_lengkap"
                                placeholder="Cari Nama Siswa" icon="ti ti-user" />
                        </div>
                        <div class="col-lg-2 col-md-3">
                            <div class="form-group">
                                <select name="kode_unit" id="kode_unit_search" class="form-select border-0 shadow-sm border" style="border-color: #e0e0e0 !important;">
                                    <option value="">Semue Unit</option>
                                    @foreach ($unit as $d)
                                        <option value="{{ $d->kode_unit }}" {{ Request('kode_unit') == $d->kode_unit ? 'selected' : '' }}>
                                            {{ $d->nama_unit }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3">
                            <div class="form-group">
                                <select name="tingkat" id="tingkat" class="form-select border-0 shadow-sm border" style="border-color: #e0e0e0 !important;">
                                    <option value="">Tingkat</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4">
                            <div class="form-group">
                                <input type="date" name="tanggal" class="form-control border-0 shadow-sm border" value="{{ $tanggal }}" style="border-color: #e0e0e0 !important;">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-5">
                            <div class="form-group">
                                <select name="kode_ta" id="kode_ta_search" class="form-select border-0 shadow-sm border" style="border-color: #e0e0e0 !important;">
                                    <option value="">Tahun Ajaran</option>
                                    @foreach ($tahunajaran as $d)
                                        <option value="{{ $d->kode_ta }}"
                                            @if (!empty(Request('kode_ta'))) @if (Request('kode_ta') == $d->kode_ta)
                                                    selected @endif
                                        @else @if ($tahun_ajaran->kode_ta == $d->kode_ta) selected @endif @endif
                                            >
                                            {{ $d->tahun_ajaran }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-1 col-md-3">
                            <button type="submit" class="btn btn-primary w-100 p-2 d-flex align-items-center justify-content-center" style="background-color: #064e3b; border-color: #064e3b">
                                <i class="ti ti-search fs-5"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header d-flex align-items-center gap-2 text-white py-3" style="background-color: #064e3b">
                <i class="ti ti-layout-grid fs-5"></i>
                <h6 class="card-title mb-0 text-white">Data Presensi Siswa</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 text-nowrap">
                        <thead style="background-color: #064e3b">
                            <tr>
                                <th class="text-white py-3">NO.</th>
                                <th class="text-white py-3">ID SISWA</th>
                                <th class="text-white py-3">NIS</th>
                                <th class="text-white py-3">NAMA LENGKAP</th>
                                <th class="text-white py-3">UNIT/TINGKAT</th>
                                <th class="text-white py-3">KELAS</th>
                                <th class="text-white py-3 text-center">MASUK</th>
                                <th class="text-white py-3 text-center">KELUAR</th>
                                <th class="text-white py-3 text-center">STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pendaftaran as $d)
                                <tr>
                                    <td class="py-2">{{ $loop->iteration + ($pendaftaran->currentPage() - 1) * $pendaftaran->perPage() }}</td>
                                    <td class="py-2">{{ $d->id_siswa }}</td>
                                    <td class="py-2">{{ $d->nis }}</td>
                                    <td class="py-2 fw-bold text-dark">{{ $d->nama_lengkap }}</td>
                                    <td class="py-2">
                                        {{ $d->nama_unit }} - <span class="badge bg-label-info" style="font-size: 0.65rem;">Tingkat {{ $d->tingkat }}</span>
                                    </td>
                                    <td class="py-2">{{ $d->nama_kelas }}</td>
                                    <td class="py-2 text-center">
                                        @if ($d->jam_in)
                                            <span class="fw-semibold text-success">{{ \Carbon\Carbon::parse($d->jam_in)->format('H:i') }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="py-2 text-center">
                                        @if ($d->jam_out)
                                            <span class="fw-semibold text-danger">{{ \Carbon\Carbon::parse($d->jam_out)->format('H:i') }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="py-2 text-center">
                                        @if ($d->presensi_status)
                                            @php
                                                $statusClass = match ($d->presensi_status) {
                                                    'h' => 'success',
                                                    'i' => 'warning',
                                                    's' => 'info',
                                                    'a' => 'danger',
                                                    default => 'secondary',
                                                };
                                                $statusLabel = match ($d->presensi_status) {
                                                    'h' => 'Hadir',
                                                    'i' => 'Izin',
                                                    's' => 'Sakit',
                                                    'a' => 'Alpha',
                                                    default => 'Unknown',
                                                };
                                            @endphp
                                            <span class="badge bg-{{ $statusClass }} rounded-pill px-3" style="font-size: 0.7rem;">
                                                {{ $statusLabel }}
                                            </span>
                                        @else
                                            <span class="badge bg-label-secondary rounded-pill px-3" style="font-size: 0.7rem;">Belum Absen</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center p-5">
                                        <div class="mb-3">
                                            <i class="ti ti-calendar-off fs-1 opacity-25"></i>
                                        </div>
                                        <h5>Belum Ada Data Presensi</h5>
                                        <p class="text-muted small">Data presensi untuk tanggal dan filter terpilih belum tersedia.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer py-3">
                <div class="d-flex justify-content-end">
                    {{ $pendaftaran->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('myscript')
<script>
    $(function() {
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
    });
</script>
@endpush

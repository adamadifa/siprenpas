@extends('layouts.app')
@section('titlepage', 'Monitoring Presensi Siswa')

@section('content')
@section('navigasi')
    <span>Monitoring Presensi Siswa</span>
@endsection
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <form action="{{ route('presensisiswa.index') }}">
                            <div class="row">
                                <div class="col-lg-3 col-sm-12 col-md-12">
                                    <x-input-with-icon label="Cari Nama Siswa" value="{{ Request('nama_lengkap') }}" name="nama_lengkap"
                                        icon="ti ti-search" />
                                </div>
                                <div class="col-lg-2 col-sm-12 col-md-12">
                                    <div class="form-group mb-3">
                                        <select name="kode_unit" id="kode_unit_search" class="form-select">
                                            <option value="">Unit</option>
                                            @foreach ($unit as $d)
                                                <option value="{{ $d->kode_unit }}" {{ Request('kode_unit') == $d->kode_unit ? 'selected' : '' }}>
                                                    {{ $d->nama_unit }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-12 col-md-12">
                                    <div class="form-group mb-3">
                                        <select name="tingkat" id="tingkat" class="form-select">
                                            <option value="">Tingkat</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-12 col-md-12">
                                    <div class="form-group mb-3">
                                        <input type="date" name="tanggal" class="form-control" value="{{ $tanggal }}">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-12 col-md-12">
                                    <div class="form-group mb-3">
                                        <select name="kode_ta" id="kode_ta_search" class="form-select">
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
                                <div class="col-lg-1 col-sm-12 col-md-12">
                                    <button class="btn btn-primary">Cari</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive mb-2">
                            <table class="table table-striped table-hover table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No.</th>
                                        <th>ID Siswa</th>
                                        <th>NIS</th>
                                        <th>Nama Lengkap</th>
                                        <th>Unit</th>
                                        <th>Tingkat</th>
                                        <th>Kelas</th>
                                        <th>Jam Masuk</th>
                                        <th>Jam Keluar</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pendaftaran as $d)
                                        <tr>
                                            <td>{{ $loop->iteration + ($pendaftaran->currentPage() - 1) * $pendaftaran->perPage() }}</td>
                                            <td>{{ $d->id_siswa }}</td>
                                            <td>{{ $d->nis }}</td>
                                            <td>{{ $d->nama_lengkap }}</td>
                                            <td>{{ $d->nama_unit }}</td>
                                            <td>{{ $d->tingkat }}</td>
                                            <td>{{ $d->nama_kelas }}</td>
                                            <td>
                                                @if ($d->jam_in)
                                                    {{ \Carbon\Carbon::parse($d->jam_in)->format('H:i') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if ($d->jam_out)
                                                    {{ \Carbon\Carbon::parse($d->jam_out)->format('H:i') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
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
                                                            default => 'Tidak Diketahui',
                                                        };
                                                    @endphp
                                                    <span class="badge bg-{{ $statusClass }}">
                                                        {{ $statusLabel }}
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary">Belum Absen</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div style="float: right;">
                            {{ $pendaftaran->links() }}
                        </div>
                    </div>
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

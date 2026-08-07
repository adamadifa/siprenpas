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
        <div class="card mb-4 shadow-none border-0 bg-transparent">
            <div class="card-body p-0">
                <form action="{{ route('presensisiswa.index') }}" class="form-filter">
                    <div class="row g-3 align-items-center">
                        <div class="col">
                            <x-input-with-icon label="" value="{{ Request('nama_lengkap') }}" name="nama_lengkap"
                                placeholder="Cari Nama Siswa" icon="ti ti-user" />
                        </div>
                        @if (auth()->user()->hasRole('super admin'))
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
                                    <span class="input-group-text"><i class="ti ti-calendar text-muted"></i></span>
                                    <input type="text" name="tanggal" class="form-control flatpickr-date" value="{{ $tanggal }}" placeholder="Pilih Tanggal">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 col-6">
                            <div class="form-group mb-3">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="ti ti-calendar-event text-muted"></i></span>
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
                        </div>
                        <div class="col-auto">
                            <div class="form-group mb-3">
                                <button type="submit" class="btn btn-primary d-flex align-items-center justify-content-center" style="background-color: #064e3b; border-color: #064e3b; height: 38px; width: 45px;">
                                    <i class="ti ti-search fs-5"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Data List (Modern & Colorful Cards) -->
        <div class="row g-3">
            @forelse ($pendaftaran as $d)
                @php
                    $statusColor = match ($d->presensi_status) {
                        'h' => ['bg' => '#f0fdf4', 'border' => '#bbf7d0', 'text' => '#166534', 'label' => 'Hadir', 'badge' => 'success', 'icon' => 'ti-circle-check'],
                        'i' => ['bg' => '#fffbeb', 'border' => '#fde68a', 'text' => '#9a3412', 'label' => 'Izin', 'badge' => 'warning', 'icon' => 'ti-info-circle'],
                        's' => ['bg' => '#f0f9ff', 'border' => '#bae6fd', 'text' => '#075985', 'label' => 'Sakit', 'badge' => 'info', 'icon' => 'ti-medical-cross'],
                        'a' => ['bg' => '#fef2f2', 'border' => '#fecaca', 'text' => '#991b1b', 'label' => 'Alpha', 'badge' => 'danger', 'icon' => 'ti-circle-x'],
                        default => ['bg' => '#ffffff', 'border' => '#e2e8f0', 'text' => '#64748b', 'label' => 'Belum Absen', 'badge' => 'secondary', 'icon' => 'ti-clock-play']
                    };
                @endphp
                <div class="col-12">
                    <div class="card shadow-sm border h-100 overflow-hidden" style="background-color: {{ $statusColor['bg'] }}; border-color: {{ $statusColor['border'] }} !important;">
                        <div class="card-body p-3">
                            <div class="row align-items-center">
                                <!-- Photo/Index & Primary Info -->
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <div class="d-flex align-items-center">
                                        <div class="d-flex align-items-center justify-content-center rounded-circle me-3 fw-bold shadow-sm" style="width: 32px; height: 32px; min-width: 32px; font-size: 0.85rem; background-color: #ffffff; color: #064e3b; border: 1px dashed #064e3b;">
                                            {{ $loop->iteration + ($pendaftaran->currentPage() - 1) * $pendaftaran->perPage() }}
                                        </div>

                                        @if ($d->foto_pendaftaran && Storage::disk('public')->exists('photos/pendaftaran/' . $d->foto_pendaftaran))
                                            <div class="avatar border rounded overflow-hidden shadow-sm me-3" style="width: 48px; height: 60px; min-width: 48px;">
                                                <img src="{{ asset('storage/photos/pendaftaran/' . $d->foto_pendaftaran) }}" alt="Foto" style="width: 100%; height: 100%; object-fit: cover;">
                                            </div>
                                        @else
                                            <div class="avatar d-flex align-items-center justify-content-center bg-label-success border rounded shadow-none me-3" style="width: 48px; height: 60px; min-width: 48px; background-color: #ffffff !important;">
                                                <i class="ti ti-user fs-3 opacity-75" style="color: #064e3b;"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <h6 class="mb-1 fw-bold text-dark" style="font-size: 0.95rem;">{{ $d->nama_lengkap }}</h6>
                                            <div class="d-flex flex-wrap align-items-center gap-2">
                                                <span class="badge bg-label-success d-inline-flex align-items-center" style="font-size: 0.65rem; background-color: #ffffff !important; border: 1px solid #bbf7d0;">
                                                    <i class="ti ti-school me-1" style="font-size: 0.75rem;"></i>{{ $d->nama_unit }}
                                                </span>
                                                <span class="badge bg-label-primary d-inline-flex align-items-center" style="font-size: 0.65rem; background-color: #ffffff !important; border: 1px solid #dbeafe;">
                                                    <i class="ti ti-chart-bar me-1" style="font-size: 0.75rem;"></i>Tingkat {{ $d->tingkat }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Identity & Class Info -->
                                <div class="col-lg-3 col-md-6 col-sm-12 border-start-lg ps-lg-4 mt-3 mt-md-0">
                                    <div class="row">
                                        <div class="col-6 d-flex flex-column gap-1">
                                            <div class="text-muted small">ID / NIS</div>
                                            <span class="fw-semibold text-dark d-inline-flex align-items-center gap-1" style="font-size: 0.8rem;">
                                                <i class="ti ti-fingerprint text-muted" style="font-size: 0.9rem;"></i> {{ $d->id_siswa }}
                                            </span>
                                            <span class="text-muted small d-inline-flex align-items-center gap-1" style="font-size: 0.8rem;">
                                                <i class="ti ti-id text-muted" style="font-size: 0.9rem;"></i> {{ $d->nis ?? '-' }}
                                            </span>
                                        </div>
                                        <div class="col-6 border-start ps-3">
                                            <div class="text-muted small">Kelas</div>
                                            <span class="badge bg-success text-white px-3 py-1 mt-1 d-inline-flex align-items-center gap-1" style="background-color: #064e3b !important; font-size: 0.75rem;">
                                                <i class="ti ti-door-enter" style="font-size: 0.85rem;"></i> {{ $d->nama_kelas ?? 'Belum Set' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Attendance Times -->
                                <div class="col-lg-4 col-md-6 col-sm-12 border-start-lg ps-lg-4 mt-3 mt-lg-0">
                                    <div class="row">
                                        <div class="col-6 text-center border-end">
                                            <div class="text-muted small mb-1"><i class="ti ti-login text-success me-1"></i>Jam Masuk</div>
                                            @if ($d->jam_in)
                                                <span class="fw-bold text-success" style="font-size: 1.1rem;">{{ \Carbon\Carbon::parse($d->jam_in)->format('H:i') }}</span>
                                            @else
                                                <span class="text-muted fw-bold" style="font-size: 1.1rem;">-</span>
                                            @endif
                                        </div>
                                        <div class="col-6 text-center">
                                            <div class="text-muted small mb-1"><i class="ti ti-logout text-danger me-1"></i>Jam Keluar</div>
                                            @if ($d->jam_out)
                                                <span class="fw-bold text-danger" style="font-size: 1.1rem;">{{ \Carbon\Carbon::parse($d->jam_out)->format('H:i') }}</span>
                                            @else
                                                <span class="text-muted fw-bold" style="font-size: 1.1rem;">-</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Attendance Status Badge -->
                                <div class="col-lg-2 col-md-6 col-sm-12 text-end mt-3 mt-lg-0">
                                    <div class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill fw-bold shadow-xs border" style="background-color: #ffffff; color: {{ $statusColor['text'] }}; border-color: {{ $statusColor['border'] }}; font-size: 0.85rem;">
                                        <i class="ti {{ $statusColor['icon'] }}" style="font-size: 1.1rem;"></i>
                                        <span>{{ $statusColor['label'] }}</span>
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
                                <i class="ti ti-calendar-off fs-1 opacity-25" style="color: #064e3b;"></i>
                            </div>
                            <h5>Belum Ada Data Presensi</h5>
                            <p class="text-muted small mb-0">Data presensi untuk tanggal dan filter terpilih belum tersedia.</p>
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

        @if (auth()->user()->hasRole('super admin'))
            getTingkatByUnit("{{ Request('kode_unit') }}");
            getKelasByTingkat("{{ Request('kode_unit') }}", "{{ Request('tingkat') }}", "{{ Request('kode_ta') ?: ($tahun_ajaran->kode_ta ?? '') }}");
        @else
            getTingkatByUnit("{{ auth()->user()->kode_unit }}");
            getKelasByTingkat("{{ auth()->user()->kode_unit }}", "{{ Request('tingkat') }}", "{{ Request('kode_ta') ?: ($tahun_ajaran->kode_ta ?? '') }}");
        @endif
    });
</script>
@endpush

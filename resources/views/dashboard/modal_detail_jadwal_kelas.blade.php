<div class="modal-header px-4 py-3 bg-white border-bottom">
    <div class="d-flex align-items-center justify-content-between w-100">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge bg-label-success p-1.5 rounded"><i class="ti ti-calendar-event fs-5"></i></span>
                <h5 class="modal-title fw-bold text-dark mb-0" style="letter-spacing: -0.2px;">
                    Status Setting Jadwal Pelajaran
                </h5>
            </div>
            <div class="text-muted d-flex align-items-center gap-2" style="font-size: 0.8rem;">
                <span>Unit: <strong class="text-dark">{{ $unit ? $unit->nama_unit : '-' }}</strong></span>
                <span>•</span>
                <span>Tahun Ajaran: <strong class="text-dark">{{ $ta ? $ta->tahun_ajaran : '-' }}</strong></span>
                <span>•</span>
                <span class="badge bg-label-primary px-2">{{ $kelasList->count() }} Rombel Kelas</span>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
</div>

<div class="modal-body p-4 bg-light bg-opacity-25" style="max-height: 520px; overflow-y: auto;">
    {{-- Top Action Bar inside Modal --}}
    <div class="d-flex align-items-center justify-content-between mb-4 bg-white p-3 rounded-3 border">
        <div class="d-flex align-items-center gap-2" style="font-size: 0.83rem; color: #475569;">
            <i class="ti ti-info-circle text-primary fs-5"></i>
            <span>Daftar rombel kelas dan rincian mata pelajaran yang telah dijadwalkan oleh admin.</span>
        </div>
        <a href="{{ route('jadwal-pelajaran.index', ['kode_unit' => $unit ? $unit->kode_unit : '', 'kode_ta' => $ta ? $ta->kode_ta : '']) }}" target="_blank" class="btn btn-sm btn-dark d-flex align-items-center gap-1.5 fw-semibold shadow-none" style="border-radius: 8px;">
            <i class="ti ti-external-link fs-6"></i> <span>Buka Menu Jadwal</span>
        </a>
    </div>

    {{-- Cards Grid Layout --}}
    <div class="row g-3">
        @forelse ($kelasList as $index => $k)
            @php
                $hasJadwal = $k->total_jadwal > 0;
            @endphp
            <div class="col-12 col-md-6 col-xl-4">
                <div class="card h-100 bg-white border rounded-3 p-3 shadow-none d-flex flex-column justify-content-between">
                    <div>
                        {{-- Card Header: Nama Kelas & Status --}}
                        <div class="d-flex align-items-center justify-content-between pb-2 mb-3 border-bottom">
                            <div>
                                <h6 class="fw-bold text-dark mb-0 fs-6">{{ $k->nama_kelas }}</h6>
                                <div class="text-muted" style="font-size: 0.74rem;">Kode: {{ $k->kode_kelas }} • Tingkat {{ $k->tingkat }}</div>
                            </div>
                            @if ($hasJadwal)
                                <span class="badge bg-label-success px-2 py-0.5" style="font-size: 0.72rem;"><i class="ti ti-check me-0.5"></i> Terjadwal</span>
                            @else
                                <span class="badge bg-label-danger px-2 py-0.5" style="font-size: 0.72rem;"><i class="ti ti-x me-0.5"></i> Belum Ada</span>
                            @endif
                        </div>

                        {{-- Card Body Metrics --}}
                        <div class="d-flex flex-column gap-2 mb-3" style="font-size: 0.82rem;">
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="text-muted"><i class="ti ti-user me-1"></i> Wali Kelas:</span>
                                @if ($k->waliKelas && $k->waliKelas->karyawan)
                                    <span class="fw-semibold text-dark text-truncate" style="max-width: 140px;" title="{{ $k->waliKelas->karyawan->nama_lengkap }}">
                                        {{ $k->waliKelas->karyawan->nama_lengkap }}
                                    </span>
                                @else
                                    <span class="badge bg-label-secondary" style="font-size: 0.7rem;">Belum Ditunjuk</span>
                                @endif
                            </div>

                            <div class="d-flex align-items-center justify-content-between">
                                <span class="text-muted"><i class="ti ti-users me-1"></i> Jumlah Santri:</span>
                                <span class="badge bg-label-info fw-semibold">{{ $k->total_siswa }} Santri</span>
                            </div>

                            <div class="d-flex align-items-center justify-content-between">
                                <span class="text-muted"><i class="ti ti-book me-1"></i> Mapel Masuk:</span>
                                <span class="fw-bold {{ $hasJadwal ? 'text-dark' : 'text-danger' }}">
                                    {{ $k->total_mapel }} Mapel
                                </span>
                            </div>

                            <div class="d-flex align-items-center justify-content-between">
                                <span class="text-muted"><i class="ti ti-clock me-1"></i> Total Jam:</span>
                                <span class="fw-semibold text-dark">{{ $k->total_sesi }} Sesi Jam</span>
                            </div>
                        </div>
                    </div>

                    {{-- Card Footer Action --}}
                    <div class="pt-2 border-top">
                        <a href="{{ route('jadwal-pelajaran.create', ['kode_unit' => $unit ? $unit->kode_unit : '', 'kode_ta' => $ta ? $ta->kode_ta : '', 'kode_kelas' => $k->kode_kelas]) }}" target="_blank" class="btn btn-xs btn-outline-primary w-100 fw-semibold d-flex align-items-center justify-content-center gap-1" style="border-radius: 6px; padding: 0.35rem;">
                            <i class="ti ti-calendar-plus"></i> <span>Atur Jadwal Kelas</span>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card p-5 text-center bg-white border rounded-3 shadow-none">
                    <i class="ti ti-calendar-off fs-1 text-secondary d-block mb-2"></i>
                    <div class="fw-bold text-dark fs-6">Belum Ada Rombel Kelas</div>
                    <small class="text-muted">Kelas belum dibuat atau belum ada pada unit ini untuk TA ini.</small>
                </div>
            </div>
        @endforelse
    </div>
</div>

<div class="modal-footer px-4 py-3 bg-white border-top d-flex justify-content-end">
    <button type="button" class="btn btn-sm btn-outline-secondary fw-semibold px-3" data-bs-dismiss="modal" style="border-radius: 8px;">Tutup</button>
</div>

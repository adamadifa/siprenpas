<div class="modal-header px-4 py-3 bg-white border-bottom">
    <div class="d-flex align-items-center justify-content-between w-100">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge bg-label-primary p-1.5 rounded"><i class="ti ti-users-minus fs-5"></i></span>
                <h5 class="modal-title fw-bold text-dark mb-0" style="letter-spacing: -0.2px;">
                    Santri Belum Masuk Rombel (Kelas)
                </h5>
            </div>
            <div class="text-muted d-flex align-items-center gap-2" style="font-size: 0.8rem;">
                <span>Unit: <strong class="text-dark">{{ $unit ? $unit->nama_unit : '-' }}</strong></span>
                <span>•</span>
                <span>Tahun Ajaran: <strong class="text-dark">{{ $ta ? $ta->tahun_ajaran : '-' }}</strong></span>
                <span>•</span>
                <span class="badge bg-label-danger px-2">{{ $students->count() }} Santri Belum Di-Plot</span>
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
            <span>Daftar santri aktif yang belum dimasukkan ke dalam rombongan belajar (kelas).</span>
        </div>
        <a href="{{ route('kelas.index', ['kode_unit_search' => $unit ? $unit->kode_unit : '', 'kode_ta' => $ta ? $ta->kode_ta : '']) }}" target="_blank" class="btn btn-sm btn-dark d-flex align-items-center gap-1.5 fw-semibold shadow-none" style="border-radius: 8px;">
            <i class="ti ti-external-link fs-6"></i> <span>Buka Ploting Kelas</span>
        </a>
    </div>

    {{-- Cards Grid Layout --}}
    <div class="row g-3">
        @forelse ($students as $index => $s)
            <div class="col-12 col-md-6 col-xl-4">
                <div class="card h-100 bg-white border rounded-3 p-3 shadow-none d-flex flex-column justify-content-between">
                    <div>
                        {{-- Santri Header --}}
                        <div class="d-flex align-items-center gap-2.5 pb-2 mb-3 border-bottom">
                            @if (!empty($s->foto_pendaftaran))
                                <img src="{{ asset('storage/' . $s->foto_pendaftaran) }}" alt="Foto" class="rounded-circle" style="width: 38px; height: 38px; object-fit: cover; border: 1px solid #e2e8f0;">
                            @else
                                <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-secondary" style="width: 38px; height: 38px; font-size: 0.85rem; background-color: #f1f5f9; border: 1px solid #e2e8f0;">
                                    {{ substr($s->nama_lengkap, 0, 1) }}
                                </div>
                            @endif
                            <div class="overflow-hidden">
                                <div class="fw-bold text-dark text-truncate" title="{{ $s->nama_lengkap }}">{{ $s->nama_lengkap }}</div>
                                <div class="text-muted" style="font-size: 0.74rem;">NIS: {{ $s->nis ?? '-' }} • ID: {{ $s->id_siswa }}</div>
                            </div>
                        </div>

                        {{-- Details --}}
                        <div class="d-flex flex-column gap-2 mb-3" style="font-size: 0.82rem;">
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="text-muted">No. Pendaftaran:</span>
                                <span class="badge bg-label-secondary font-monospace" style="font-size: 0.74rem;">{{ $s->no_pendaftaran }}</span>
                            </div>

                            <div class="d-flex align-items-center justify-content-between">
                                <span class="text-muted">Jenis Kelamin:</span>
                                @if ($s->jenis_kelamin == 'L')
                                    <span class="badge bg-label-info px-2 py-0.5">Laki-laki</span>
                                @elseif ($s->jenis_kelamin == 'P')
                                    <span class="badge bg-label-danger px-2 py-0.5">Perempuan</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </div>

                            <div class="d-flex align-items-center justify-content-between">
                                <span class="text-muted">Tingkat Kelas:</span>
                                <span class="badge bg-label-primary">Tingkat {{ $s->tingkat ?? '-' }}</span>
                            </div>

                            <div class="d-flex align-items-center justify-content-between">
                                <span class="text-muted">Status Rombel:</span>
                                <span class="badge bg-label-danger px-2 py-0.5"><i class="ti ti-alert-triangle me-0.5"></i> Belum Masuk Kelas</span>
                            </div>
                        </div>
                    </div>

                    {{-- Card Footer Action --}}
                    <div class="pt-2 border-top">
                        <a href="{{ route('kelas.index', ['kode_unit_search' => $s->kode_unit, 'kode_ta' => $ta ? $ta->kode_ta : '']) }}" target="_blank" class="btn btn-xs btn-outline-primary w-100 fw-semibold d-flex align-items-center justify-content-center gap-1" style="border-radius: 6px; padding: 0.35rem;">
                            <i class="ti ti-user-plus"></i> <span>Ploting ke Rombel</span>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card p-5 text-center bg-white border rounded-3 shadow-none">
                    <i class="ti ti-circle-check fs-1 text-success d-block mb-2"></i>
                    <div class="fw-bold text-dark fs-6">Seluruh Santri Sudah Masuk Rombel</div>
                    <small class="text-muted">Tidak ada santri yang tertinggal dalam penempatan kelas.</small>
                </div>
            </div>
        @endforelse
    </div>
</div>

<div class="modal-footer px-4 py-3 bg-white border-top d-flex justify-content-end">
    <button type="button" class="btn btn-sm btn-outline-secondary fw-semibold px-3" data-bs-dismiss="modal" style="border-radius: 8px;">Tutup</button>
</div>

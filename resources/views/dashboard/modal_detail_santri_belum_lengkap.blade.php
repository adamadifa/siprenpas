<div class="modal-header px-4 py-3.5 bg-white border-bottom">
    <div class="d-flex align-items-center justify-content-between w-100">
        <div class="d-flex align-items-center gap-3">
            <div class="rounded-3 bg-label-warning d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                <i class="ti ti-user-exclamation fs-4"></i>
            </div>
            <div>
                <h5 class="modal-title fw-bold text-dark mb-0" style="letter-spacing: -0.2px;">
                    Data Profil Santri Belum Lengkap
                </h5>
                <div class="text-muted d-flex align-items-center gap-2 mt-0.5" style="font-size: 0.82rem;">
                    <span>Unit: <strong class="text-dark">{{ $unit ? $unit->nama_unit : '-' }}</strong></span>
                    <span>&bull;</span>
                    <span>Tahun Ajaran: <strong class="text-dark">{{ $ta ? $ta->tahun_ajaran : '-' }}</strong></span>
                    <span>&bull;</span>
                    <span class="badge bg-label-danger px-2 py-0.5 rounded-pill">{{ $listBelumLengkap->count() }} Santri Perlu Dilengkapi</span>
                </div>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
</div>

<div class="modal-body p-4 bg-light bg-opacity-25" style="max-height: 600px; overflow-y: auto;">
    {{-- Info Alert Card --}}
    <div class="card mb-4 bg-white border rounded-3 shadow-none" style="border-color: #e2e8f0 !important; padding: 1.25rem 1.5rem;">
        <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3.5">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-3 bg-label-primary d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px;">
                    <i class="ti ti-info-circle fs-4"></i>
                </div>
                <div style="font-size: 0.85rem; color: #334155; line-height: 1.55;">
                    Daftar santri di bawah ini memiliki data pokok/keluarga yang masih kosong. Klik tombol <strong class="text-dark">Lengkapi Data Santri</strong> pada kartu santri untuk menuju formulir pengisian.
                </div>
            </div>
            <div class="flex-shrink-0 ps-lg-3">
                <a href="{{ route('siswa.index', ['kode_unit' => $unit ? $unit->kode_unit : '']) }}" target="_blank" class="btn btn-sm btn-dark d-inline-flex align-items-center gap-2 fw-semibold shadow-none px-3.5 py-2" style="border-radius: 8px; font-size: 0.82rem; white-space: nowrap;">
                    <i class="ti ti-external-link fs-6"></i> <span>Buka Menu Siswa</span>
                </a>
            </div>
        </div>
    </div>

    {{-- Cards Grid Layout --}}
    <div class="row g-4">
        @forelse ($listBelumLengkap as $index => $s)
            @php
                // Grouping field detail formal
                $fieldGroups = [
                    'Identitas Pokok' => [
                        ['label' => 'Nama Lengkap', 'valid' => !empty($s->nama_lengkap), 'val' => $s->nama_lengkap],
                        ['label' => 'Jenis Kelamin', 'valid' => !empty($s->jenis_kelamin), 'val' => $s->jenis_kelamin],
                        ['label' => 'Tempat Lahir', 'valid' => !empty($s->tempat_lahir), 'val' => $s->tempat_lahir],
                        ['label' => 'Tanggal Lahir', 'valid' => !empty($s->tanggal_lahir), 'val' => $s->tanggal_lahir],
                        ['label' => 'NISN', 'valid' => !empty($s->nisn), 'val' => $s->nisn],
                        ['label' => 'No. KK', 'valid' => !empty($s->no_kk), 'val' => $s->no_kk],
                        ['label' => 'Foto Santri', 'valid' => !empty($s->foto_pendaftaran), 'val' => $s->foto_pendaftaran ? 'Tersedia' : null],
                    ],
                    'Orang Tua & Kontak' => [
                        ['label' => 'Nama Ayah', 'valid' => !empty($s->nama_ayah), 'val' => $s->nama_ayah],
                        ['label' => 'NIK Ayah', 'valid' => !empty($s->nik_ayah), 'val' => $s->nik_ayah],
                        ['label' => 'Nama Ibu', 'valid' => !empty($s->nama_ibu), 'val' => $s->nama_ibu],
                        ['label' => 'NIK Ibu', 'valid' => !empty($s->nik_ibu), 'val' => $s->nik_ibu],
                        ['label' => 'No. HP Ortu', 'valid' => !empty($s->no_hp_orang_tua), 'val' => $s->no_hp_orang_tua],
                    ],
                    'Alamat & Domisili' => [
                        ['label' => 'Alamat Jalan', 'valid' => !empty($s->alamat), 'val' => $s->alamat],
                        ['label' => 'Provinsi', 'valid' => !empty($s->id_province), 'val' => $s->id_province ? 'Terpilih' : null],
                        ['label' => 'Kab / Kota', 'valid' => !empty($s->id_regency), 'val' => $s->id_regency ? 'Terpilih' : null],
                        ['label' => 'Kecamatan', 'valid' => !empty($s->id_district), 'val' => $s->id_district ? 'Terpilih' : null],
                        ['label' => 'Desa / Kel', 'valid' => !empty($s->id_village), 'val' => $s->id_village ? 'Terpilih' : null],
                    ]
                ];

                $totalItem = 0;
                $filledItem = 0;
                foreach ($fieldGroups as $group) {
                    foreach ($group as $item) {
                        $totalItem++;
                        if ($item['valid']) {
                            $filledItem++;
                        }
                    }
                }
                $persen = round(($filledItem / $totalItem) * 100);
            @endphp
            <div class="col-12 col-xl-6">
                <div class="card h-100 bg-white border rounded-3 p-4 shadow-none d-flex flex-column justify-content-between" style="border-color: #e2e8f0 !important;">
                    <div>
                        {{-- Santri Header --}}
                        <div class="d-flex align-items-center justify-content-between pb-3 mb-3 border-bottom" style="border-color: #f1f5f9 !important;">
                            <div class="d-flex align-items-center gap-3 overflow-hidden">
                                @if (!empty($s->foto_pendaftaran))
                                    <img src="{{ asset('storage/' . $s->foto_pendaftaran) }}" alt="Foto" class="rounded-circle flex-shrink-0" style="width: 44px; height: 44px; object-fit: cover; border: 1px solid #e2e8f0;">
                                @else
                                    <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-secondary flex-shrink-0" style="width: 44px; height: 44px; font-size: 0.95rem; background-color: #f8fafc; border: 1px solid #e2e8f0;">
                                        {{ substr($s->nama_lengkap, 0, 1) }}
                                    </div>
                                @endif
                                <div class="overflow-hidden">
                                    <div class="fw-bold text-dark text-truncate" title="{{ $s->nama_lengkap }}" style="font-size: 0.95rem; letter-spacing: -0.2px;">{{ $s->nama_lengkap }}</div>
                                    <div class="text-muted mt-0.5" style="font-size: 0.78rem;">NIS: <span class="text-dark fw-semibold">{{ $s->nis ?? '-' }}</span> &bull; ID: {{ $s->id_siswa }}</div>
                                </div>
                            </div>
                            <div class="text-end flex-shrink-0 ps-3">
                                <span class="badge {{ $persen == 100 ? 'bg-label-success' : 'bg-label-danger' }} px-3 py-1.5 rounded-2 fw-bold" style="font-size: 0.75rem;">
                                    {{ $filledItem }}/{{ $totalItem }} Field ({{ $persen }}%)
                                </span>
                            </div>
                        </div>

                        {{-- Per Field Structured List (Formal & Clean 2-Col Grid) --}}
                        <div class="d-flex flex-column gap-3 mb-4">
                            @foreach ($fieldGroups as $groupTitle => $groupItems)
                                <div>
                                    <div class="fw-bold text-dark mb-2 text-uppercase" style="font-size: 0.73rem; letter-spacing: 0.6px; color: #475569 !important;">
                                        {{ $groupTitle }}
                                    </div>
                                    <div class="row g-2">
                                        @foreach ($groupItems as $f)
                                            <div class="col-6">
                                                <div class="d-flex align-items-center justify-content-between p-2 rounded-2 border {{ $f['valid'] ? 'bg-white' : 'bg-danger bg-opacity-10 border-danger border-opacity-25' }}" style="border-color: #e2e8f0 !important; min-height: 38px;">
                                                    <div class="d-flex align-items-center gap-2 overflow-hidden me-2">
                                                        <i class="ti {{ $f['valid'] ? 'ti-circle-check text-success' : 'ti-circle-x text-danger' }} fs-5 flex-shrink-0"></i>
                                                        <span class="text-truncate fw-semibold {{ $f['valid'] ? 'text-dark' : 'text-danger' }}" style="font-size: 0.78rem; color: {{ $f['valid'] ? '#1e293b' : '#dc2626' }} !important;" title="{{ $f['label'] }}">
                                                            {{ $f['label'] }}
                                                        </span>
                                                    </div>
                                                    <div class="flex-shrink-0 text-end">
                                                        @if ($f['valid'])
                                                            <span class="fw-medium text-secondary" style="font-size: 0.74rem; color: #475569 !important;">
                                                                {{ is_string($f['val']) && strlen($f['val']) > 12 ? substr($f['val'], 0, 12) . '...' : ($f['val'] ?? 'Ada') }}
                                                            </span>
                                                        @else
                                                            <span class="badge bg-danger text-white px-2 py-0.5 rounded fw-bold" style="font-size: 0.68rem;">
                                                                Kosong
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Card Footer Action --}}
                    <div class="pt-3 border-top" style="border-color: #f1f5f9 !important;">
                        <button type="button" class="btn btn-outline-dark w-100 fw-semibold d-flex align-items-center justify-content-center gap-2 shadow-none py-2 btn-edit-siswa-modal" 
                                data-no-pendaftaran="{{ Crypt::encrypt($s->no_pendaftaran) }}" style="border-radius: 8px; font-size: 0.82rem;">
                            <i class="ti ti-edit fs-6"></i> <span>Lengkapi Data Santri</span>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card p-5 text-center bg-white border rounded-3 shadow-none">
                    <i class="ti ti-circle-check fs-1 text-success d-block mb-2"></i>
                    <div class="fw-bold text-dark fs-6">Seluruh Data Santri 100% Lengkap</div>
                    <small class="text-muted">Semua profil santri pada unit ini telah terisi lengkap tanpa ada field yang kosong.</small>
                </div>
            </div>
        @endforelse
    </div>
</div>

<div class="modal-footer px-4 py-3 bg-white border-top d-flex justify-content-end">
    <button type="button" class="btn btn-outline-secondary fw-semibold px-4 py-2" data-bs-dismiss="modal" style="border-radius: 8px; font-size: 0.85rem;">Tutup</button>
</div>

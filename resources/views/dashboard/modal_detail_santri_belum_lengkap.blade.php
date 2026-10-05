{{-- Modal Detail Santri Belum Lengkap: 100% Tailwind CSS --}}
@php
    $unitLogo = null;
    if ($unit) {
        if (!empty($unit->logo) && Storage::disk('public')->exists($unit->logo)) {
            $unitLogo = asset('storage/' . $unit->logo);
        } elseif (!empty($unit->logo) && file_exists(public_path('storage/' . $unit->logo))) {
            $unitLogo = asset('storage/' . $unit->logo);
        } else {
            $namaLower = strtolower($unit->nama_unit);
            if (str_contains($namaLower, 'tk') || str_contains($namaLower, 'calisa') || str_contains($namaLower, 'rabbani')) {
                $unitLogo = asset('assets/img/logo/tk.png');
            } elseif (str_contains($namaLower, 'sd') || str_contains($namaLower, 'sdit')) {
                $unitLogo = asset('assets/img/logo/sdit.png');
            } elseif (str_contains($namaLower, 'mdu')) {
                $unitLogo = asset('assets/img/logo/mdu.png');
            } elseif (str_contains($namaLower, 'mts')) {
                $unitLogo = asset('assets/img/logo/mts.png');
            } elseif (str_contains($namaLower, 'ma') || str_contains($namaLower, 'aliyah')) {
                $unitLogo = asset('assets/img/logo/ma.png');
            } elseif (str_contains($namaLower, 'asrama') || str_contains($namaLower, 'pesantren')) {
                $unitLogo = asset('assets/img/logo/asrama.png');
            } elseif (file_exists(public_path('assets/img/logo/persisalamin.png'))) {
                $unitLogo = asset('assets/img/logo/persisalamin.png');
            }
        }
    }
@endphp
<div class="px-6 py-4 bg-white border-b border-slate-100 flex items-center justify-between">
    <div class="flex items-center gap-3.5">
        @if ($unitLogo)
            <div class="w-11 h-11 rounded-2xl bg-white border border-slate-200/90 shadow-2xs flex items-center justify-center p-1.5 overflow-hidden shrink-0">
                <img src="{{ $unitLogo }}" alt="Logo" class="w-full h-full object-contain filter drop-shadow-2xs">
            </div>
        @else
            <div class="w-10 h-10 rounded-xl bg-amber-50 border border-amber-200/80 text-amber-600 flex items-center justify-center text-xl shrink-0">
                <i class="ti ti-user-exclamation"></i>
            </div>
        @endif
        <div>
            <h3 class="text-base font-bold text-slate-900 tracking-tight">
                Data Profil Santri Belum Lengkap
            </h3>
            <div class="flex flex-wrap items-center gap-2 mt-0.5 text-xs text-slate-500">
                <span>Unit: <strong class="text-slate-800 font-semibold">{{ $unit ? $unit->nama_unit : '-' }}</strong></span>
                <span class="text-slate-300">•</span>
                <span>Tahun Ajaran: <strong class="text-slate-800 font-semibold">{{ $ta ? $ta->tahun_ajaran : '-' }}</strong></span>
                <span class="text-slate-300">•</span>
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-bold bg-rose-50 text-rose-600 border border-rose-100">
                    {{ $listBelumLengkap->count() }} Santri Perlu Dilengkapi
                </span>
            </div>
        </div>
    </div>
    <button type="button" class="w-8 h-8 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 flex items-center justify-center transition-colors cursor-pointer" data-bs-dismiss="modal" aria-label="Close">
        <i class="ti ti-x text-lg"></i>
    </button>
</div>

<div class="p-6 bg-slate-50/60 space-y-4 max-h-[calc(85vh-130px)] overflow-y-auto">
    {{-- Info Alert Banner --}}
    <div class="bg-white border border-slate-200/90 rounded-xl p-4 shadow-2xs flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
        <div class="flex items-start gap-3">
            <div class="w-9 h-9 rounded-lg bg-blue-50 text-blue-600 border border-blue-100 flex items-center justify-center text-lg shrink-0 mt-0.5">
                <i class="ti ti-info-circle"></i>
            </div>
            <div class="text-xs text-slate-600 leading-relaxed">
                <p class="font-medium text-slate-800">Lengkapi data pokok, identitas keluarga, dan domisili santri.</p>
                <p class="text-slate-500 mt-0.5">Klik tombol <strong class="text-slate-700">Lengkapi Data Santri</strong> pada kartu santri untuk membuka formulir pengisian.</p>
            </div>
        </div>
        <div class="flex items-center gap-2 shrink-0 self-end sm:self-center">
            <a href="{{ route('siswa.index', ['kode_unit' => $unit ? $unit->kode_unit : '']) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-900 hover:bg-slate-800 text-white rounded-lg text-xs font-semibold shadow-2xs transition">
                <i class="ti ti-external-link text-sm"></i>
                <span>Buka Menu Siswa</span>
            </a>
        </div>
    </div>

    {{-- Filter / Search Bar --}}
    <div class="bg-white border border-slate-200/90 rounded-xl p-3 shadow-2xs flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
        <div class="relative flex-1">
            <i class="ti ti-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
            <input type="text" id="searchSantriLengkap" placeholder="Cari santri berdasarkan nama / NIS / No. Pendaftaran..." class="w-full pl-9 pr-3 py-1.5 text-xs bg-slate-50 border border-slate-200 rounded-lg text-slate-700 focus:outline-hidden focus:border-amber-500 focus:bg-white transition">
        </div>
        <div class="text-xs text-slate-500 flex items-center gap-1.5 shrink-0 px-1">
            <span>Menampilkan:</span>
            <span class="font-bold text-slate-800" id="santriBelumLengkapVisible">{{ $listBelumLengkap->count() }}</span>
            <span class="text-slate-400">/ {{ $listBelumLengkap->count() }} santri</span>
        </div>
    </div>

    {{-- Cards Grid Layout --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="santriBelumLengkapGrid">
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
            <div class="santri-item-card bg-white border border-slate-200/90 rounded-2xl p-4 shadow-2xs hover:border-slate-300 transition flex flex-col justify-between"
                 data-search="{{ strtolower($s->nama_lengkap . ' ' . ($s->nis ?? '') . ' ' . $s->no_pendaftaran) }}">
                <div>
                    {{-- Santri Header --}}
                    <div class="flex items-center justify-between pb-3 mb-3 border-b border-slate-100 gap-3">
                        <div class="flex items-center gap-3 min-w-0">
                            @if (!empty($s->foto_pendaftaran) && Storage::disk('public')->exists('photos/pendaftaran/' . $s->foto_pendaftaran))
                                <img src="{{ asset('storage/photos/pendaftaran/' . $s->foto_pendaftaran) }}" alt="Foto" class="w-10 h-10 rounded-full object-cover border border-slate-200 shadow-2xs shrink-0">
                            @elseif (!empty($s->foto_pendaftaran) && Storage::disk('public')->exists($s->foto_pendaftaran))
                                <img src="{{ asset('storage/' . $s->foto_pendaftaran) }}" alt="Foto" class="w-10 h-10 rounded-full object-cover border border-slate-200 shadow-2xs shrink-0">
                            @else
                                <div class="w-10 h-10 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center font-bold text-slate-500 text-xs shrink-0 shadow-2xs">
                                    {{ substr($s->nama_lengkap, 0, 1) }}
                                </div>
                            @endif
                            <div class="min-w-0">
                                <h4 class="text-xs sm:text-sm font-bold text-slate-900 truncate" title="{{ $s->nama_lengkap }}">
                                    {{ $s->nama_lengkap }}
                                </h4>
                                <div class="text-[11px] text-slate-400 mt-0.5 truncate">
                                    NIS: <span class="font-semibold text-slate-700">{{ $s->nis ?? '-' }}</span> • ID: {{ $s->id_siswa }}
                                </div>
                            </div>
                        </div>
                        <div class="shrink-0 text-right">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-extrabold {{ $persen == 100 ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-amber-50 text-amber-700 border border-amber-200' }}">
                                {{ $filledItem }}/{{ $totalItem }} ({{ $persen }}%)
                            </span>
                        </div>
                    </div>

                    {{-- Per Field Structured List (2-Col Grid per group) --}}
                    <div class="space-y-3 mb-4">
                        @foreach ($fieldGroups as $groupTitle => $groupItems)
                            <div>
                                <div class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-1.5 flex items-center gap-1.5">
                                    <span>{{ $groupTitle }}</span>
                                    <div class="flex-1 h-px bg-slate-100"></div>
                                </div>
                                <div class="grid grid-cols-2 gap-1.5">
                                    @foreach ($groupItems as $f)
                                        <div class="flex items-center justify-between p-1.5 px-2 rounded-lg border text-[11px] {{ $f['valid'] ? 'bg-slate-50/70 border-slate-100 text-slate-700' : 'bg-rose-50/70 border-rose-200/80 text-rose-700' }}">
                                            <div class="flex items-center gap-1.5 min-w-0 mr-1">
                                                <i class="ti {{ $f['valid'] ? 'ti-circle-check text-emerald-500' : 'ti-circle-x text-rose-500' }} text-sm shrink-0"></i>
                                                <span class="truncate {{ $f['valid'] ? 'text-slate-600 font-medium' : 'text-rose-700 font-semibold' }}" title="{{ $f['label'] }}">
                                                    {{ $f['label'] }}
                                                </span>
                                            </div>
                                            <div class="shrink-0 text-right">
                                                @if ($f['valid'])
                                                    <span class="text-[10px] text-slate-400 font-mono truncate block max-w-[65px]" title="{{ $f['val'] }}">
                                                        {{ is_string($f['val']) && strlen($f['val']) > 8 ? substr($f['val'], 0, 8) . '...' : ($f['val'] ?? 'Ada') }}
                                                    </span>
                                                @else
                                                    <span class="inline-block px-1.5 py-0.2 bg-rose-600 text-white rounded text-[9px] font-extrabold uppercase tracking-tight">
                                                        Kosong
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Card Footer Action --}}
                <div class="pt-3 border-t border-slate-100">
                    <button type="button" 
                            class="btn-edit-siswa-modal w-full py-2 px-3 bg-slate-900 hover:bg-slate-800 text-white font-semibold rounded-xl text-xs flex items-center justify-center gap-1.5 shadow-2xs transition active:scale-[0.99] cursor-pointer" 
                            data-no-pendaftaran="{{ Crypt::encrypt($s->no_pendaftaran) }}">
                        <i class="ti ti-edit text-sm"></i>
                        <span>Lengkapi Data Santri</span>
                    </button>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white border border-slate-200/90 rounded-2xl p-10 text-center text-slate-400">
                <i class="ti ti-circle-check text-4xl text-emerald-500 block mb-2 mx-auto"></i>
                <h4 class="text-sm font-bold text-slate-800">Seluruh Data Santri 100% Lengkap</h4>
                <p class="text-xs text-slate-500 mt-1">Semua profil santri pada unit ini telah terisi lengkap tanpa ada field yang kosong.</p>
            </div>
        @endforelse

        {{-- Empty Search State --}}
        <div class="col-span-full bg-white border border-slate-200/90 rounded-2xl p-10 text-center text-slate-400 hidden" id="santriBelumLengkapEmptySearch">
            <i class="ti ti-search-off text-4xl text-slate-300 block mb-2 mx-auto"></i>
            <h4 class="text-sm font-bold text-slate-800">Tidak Ada Santri Yang Cocok</h4>
            <p class="text-xs text-slate-500 mt-1">Silakan sesuaikan kata kunci pencarian nama atau NIS.</p>
        </div>
    </div>
</div>

<div class="px-6 py-3.5 bg-white border-t border-slate-100 flex items-center justify-between">
    <div class="text-xs text-slate-400">
        Total <strong class="text-slate-700 font-semibold">{{ $listBelumLengkap->count() }}</strong> santri tercatat
    </div>
    <button type="button" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition cursor-pointer" data-bs-dismiss="modal">
        Tutup
    </button>
</div>

<script>
    (function() {
        $('#searchSantriLengkap').on('input', function() {
            let q = $(this).val().toLowerCase().trim();
            let visibleCount = 0;

            $('.santri-item-card').each(function() {
                let text = $(this).data('search') ? $(this).data('search').toString() : '';
                if (!q || text.includes(q)) {
                    $(this).removeClass('hidden');
                    visibleCount++;
                } else {
                    $(this).addClass('hidden');
                }
            });

            $('#santriBelumLengkapVisible').text(visibleCount);

            if (visibleCount === 0 && $('.santri-item-card').length > 0) {
                $('#santriBelumLengkapEmptySearch').removeClass('hidden');
            } else {
                $('#santriBelumLengkapEmptySearch').addClass('hidden');
            }
        });
    })();
</script>

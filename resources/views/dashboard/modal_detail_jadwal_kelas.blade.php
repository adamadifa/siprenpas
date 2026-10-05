{{-- Modal Detail Jadwal Pelajaran Per Rombel: 100% Tailwind CSS --}}
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
            <div class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-200/80 text-emerald-600 flex items-center justify-center text-xl shrink-0">
                <i class="ti ti-calendar-event"></i>
            </div>
        @endif
        <div>
            <h3 class="text-base font-bold text-slate-900 tracking-tight">
                Status Setting Jadwal Pelajaran
            </h3>
            <div class="flex flex-wrap items-center gap-2 mt-0.5 text-xs text-slate-500">
                <span>Unit: <strong class="text-slate-800 font-semibold">{{ $unit ? $unit->nama_unit : '-' }}</strong></span>
                <span class="text-slate-300">•</span>
                <span>Tahun Ajaran: <strong class="text-slate-800 font-semibold">{{ $ta ? $ta->tahun_ajaran : '-' }}</strong></span>
                <span class="text-slate-300">•</span>
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-bold bg-blue-50 text-blue-600 border border-blue-100">
                    {{ $kelasList->count() }} Rombel Kelas
                </span>
            </div>
        </div>
    </div>
    <button type="button" class="w-8 h-8 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 flex items-center justify-center transition-colors cursor-pointer" data-bs-dismiss="modal" aria-label="Close">
        <i class="ti ti-x text-lg"></i>
    </button>
</div>

<div class="p-6 bg-slate-50/60 space-y-4 max-h-[calc(85vh-130px)] overflow-y-auto">
    {{-- Top Action Banner inside Modal --}}
    <div class="bg-white border border-slate-200/90 rounded-xl p-4 shadow-2xs flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
        <div class="flex items-start gap-3">
            <div class="w-9 h-9 rounded-lg bg-emerald-50 text-emerald-600 border border-emerald-100 flex items-center justify-center text-lg shrink-0 mt-0.5">
                <i class="ti ti-info-circle"></i>
            </div>
            <div class="text-xs text-slate-600 leading-relaxed">
                <p class="font-medium text-slate-800">Daftar rombongan belajar dan status kelengkapan jadwal pelajaran mingguan.</p>
                <p class="text-slate-500 mt-0.5">Pastikan setiap kelas memiliki mata pelajaran dan guru pengajar yang telah terjadwal.</p>
            </div>
        </div>
        <div class="flex items-center gap-2 shrink-0 self-end sm:self-center">
            <a href="{{ route('jadwal-pelajaran.index', ['kode_unit' => $unit ? $unit->kode_unit : '', 'kode_ta' => $ta ? $ta->kode_ta : '']) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-900 hover:bg-slate-800 text-white rounded-lg text-xs font-semibold shadow-2xs transition">
                <i class="ti ti-external-link text-sm"></i>
                <span>Buka Menu Jadwal</span>
            </a>
        </div>
    </div>

    {{-- Filter & Search Bar --}}
    <div class="bg-white border border-slate-200/90 rounded-xl p-3 shadow-2xs flex flex-col md:flex-row items-stretch md:items-center justify-between gap-3">
        <div class="flex flex-wrap items-center gap-1.5" id="filterJadwalContainer">
            <span class="text-xs font-bold text-slate-400 mr-1 flex items-center gap-1">
                <i class="ti ti-filter text-sm"></i> Status:
            </span>
            <button type="button" class="btn-filter-jadwal px-2.5 py-1 text-xs font-bold rounded-lg transition bg-emerald-600 text-white shadow-2xs" data-status="all">
                Semua (<span id="count-jadwal-all">{{ $kelasList->count() }}</span>)
            </button>
            <button type="button" class="btn-filter-jadwal px-2.5 py-1 text-xs font-semibold rounded-lg transition bg-slate-100 hover:bg-slate-200 text-slate-600" data-status="terjadwal">
                Terjadwal (<span id="count-jadwal-ok">{{ $kelasList->where('total_jadwal', '>', 0)->count() }}</span>)
            </button>
            <button type="button" class="btn-filter-jadwal px-2.5 py-1 text-xs font-semibold rounded-lg transition bg-slate-100 hover:bg-slate-200 text-slate-600" data-status="belum">
                Belum (<span id="count-jadwal-empty">{{ $kelasList->where('total_jadwal', '<=', 0)->count() }}</span>)
            </button>
        </div>
        <div class="relative w-full md:w-64">
            <i class="ti ti-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
            <input type="text" id="searchJadwalKelas" class="w-full pl-9 pr-3 py-1.5 text-xs bg-slate-50 border border-slate-200 rounded-lg text-slate-700 focus:outline-hidden focus:border-emerald-500 focus:bg-white transition" placeholder="Cari nama kelas...">
        </div>
    </div>

    {{-- Cards Grid Layout --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3.5" id="jadwalKelasGrid">
        @forelse ($kelasList as $index => $k)
            @php
                $hasJadwal = $k->total_jadwal > 0;
            @endphp
            <div class="jadwal-card-item bg-white border border-slate-200/90 rounded-2xl p-4 shadow-2xs hover:border-slate-300 transition flex flex-col justify-between"
                 data-status="{{ $hasJadwal ? 'terjadwal' : 'belum' }}"
                 data-search="{{ strtolower($k->nama_kelas . ' ' . $k->kode_kelas . ' tingkat ' . $k->tingkat) }}">
                <div>
                    {{-- Card Header: Nama Kelas & Status --}}
                    <div class="flex items-center justify-between pb-3 mb-3 border-b border-slate-100 gap-2">
                        <div class="min-w-0">
                            <h4 class="text-xs sm:text-sm font-bold text-slate-900 truncate">{{ $k->nama_kelas }}</h4>
                            <div class="text-[11px] text-slate-400 mt-0.5 truncate">Kode: {{ $k->kode_kelas }} • Tk. {{ $k->tingkat }}</div>
                        </div>
                        @if ($hasJadwal)
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 text-[10px] font-extrabold rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 shrink-0">
                                <i class="ti ti-check text-xs"></i> Terjadwal
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 text-[10px] font-extrabold rounded-full bg-rose-50 text-rose-700 border border-rose-200 shrink-0">
                                <i class="ti ti-x text-xs"></i> Belum Ada
                            </span>
                        @endif
                    </div>

                    {{-- Card Body Metrics --}}
                    <div class="space-y-2 mb-3.5 text-xs">
                        <div class="flex items-center justify-between">
                            <span class="text-slate-400 text-[11px] flex items-center gap-1">
                                <i class="ti ti-user-check text-xs"></i> Wali Kelas:
                            </span>
                            @if ($k->waliKelas && $k->waliKelas->karyawan)
                                <span class="font-semibold text-slate-800 truncate max-w-[130px]" title="{{ $k->waliKelas->karyawan->nama_lengkap }}">
                                    {{ $k->waliKelas->karyawan->nama_lengkap }}
                                </span>
                            @else
                                <span class="text-[10px] font-medium text-slate-400 italic">Belum Ditunjuk</span>
                            @endif
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-slate-400 text-[11px] flex items-center gap-1">
                                <i class="ti ti-users text-xs"></i> Jumlah Santri:
                            </span>
                            <span class="px-2 py-0.5 text-[10px] font-bold rounded-md bg-slate-100 text-slate-700">
                                {{ $k->total_siswa }} Santri
                            </span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-slate-400 text-[11px] flex items-center gap-1">
                                <i class="ti ti-book text-xs"></i> Mapel Masuk:
                            </span>
                            <span class="font-bold {{ $hasJadwal ? 'text-emerald-600' : 'text-rose-500' }}">
                                {{ $k->total_mapel }} Mapel
                            </span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-slate-400 text-[11px] flex items-center gap-1">
                                <i class="ti ti-clock text-xs"></i> Total Jam:
                            </span>
                            <span class="font-bold text-slate-800">
                                {{ $k->total_sesi }} Sesi Jam
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Card Footer Action --}}
                <div class="pt-3 border-t border-slate-100">
                    <a href="{{ route('jadwal-pelajaran.create', ['kode_unit' => $unit ? $unit->kode_unit : '', 'kode_ta' => $ta ? $ta->kode_ta : '', 'kode_kelas' => $k->kode_kelas]) }}" target="_blank" class="w-full py-2 px-3 bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 text-xs font-semibold rounded-xl transition flex items-center justify-center gap-1.5 shadow-2xs">
                        <i class="ti ti-calendar-plus text-sm"></i>
                        <span>Atur Jadwal Kelas</span>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white border border-slate-200/90 rounded-2xl p-10 text-center text-slate-400">
                <i class="ti ti-calendar-off text-4xl text-slate-300 block mb-2 mx-auto"></i>
                <h4 class="text-sm font-bold text-slate-800">Belum Ada Rombel Kelas</h4>
                <p class="text-xs text-slate-500 mt-1">Kelas belum dibuat atau belum ada pada unit ini untuk TA ini.</p>
            </div>
        @endforelse

        {{-- Empty Search State --}}
        <div class="col-span-full bg-white border border-slate-200/90 rounded-2xl p-10 text-center text-slate-400 hidden" id="jadwalKelasEmptySearch">
            <i class="ti ti-search-off text-4xl text-slate-300 block mb-2 mx-auto"></i>
            <h4 class="text-sm font-bold text-slate-800">Tidak Ada Kelas Yang Cocok</h4>
            <p class="text-xs text-slate-500 mt-1">Silakan sesuaikan kata kunci pencarian atau filter status.</p>
        </div>
    </div>
</div>

<div class="px-6 py-3.5 bg-white border-t border-slate-100 flex items-center justify-between">
    <div class="text-xs text-slate-400">
        Menampilkan <strong class="text-slate-700 font-semibold" id="count-visible-jadwal">{{ $kelasList->count() }}</strong> kelas
    </div>
    <button type="button" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition cursor-pointer" data-bs-dismiss="modal">
        Tutup
    </button>
</div>

<script>
    (function() {
        let activeStatus = 'all';
        let searchQuery = '';

        function filterJadwal() {
            let visibleCount = 0;
            $('.jadwal-card-item').each(function() {
                let cardStatus = $(this).data('status') ? $(this).data('status').toString() : '';
                let cardSearch = $(this).data('search') ? $(this).data('search').toString() : '';

                let matchesStatus = (activeStatus === 'all' || cardStatus === activeStatus);
                let matchesSearch = (!searchQuery || cardSearch.includes(searchQuery));

                if (matchesStatus && matchesSearch) {
                    $(this).removeClass('hidden');
                    visibleCount++;
                } else {
                    $(this).addClass('hidden');
                }
            });

            $('#count-visible-jadwal').text(visibleCount);

            if (visibleCount === 0 && $('.jadwal-card-item').length > 0) {
                $('#jadwalKelasEmptySearch').removeClass('hidden');
            } else {
                $('#jadwalKelasEmptySearch').addClass('hidden');
            }
        }

        $(document).off('click', '.btn-filter-jadwal').on('click', '.btn-filter-jadwal', function() {
            $('.btn-filter-jadwal').removeClass('bg-emerald-600 text-white shadow-2xs').addClass('bg-slate-100 text-slate-600 hover:bg-slate-200');
            $(this).removeClass('bg-slate-100 text-slate-600 hover:bg-slate-200').addClass('bg-emerald-600 text-white shadow-2xs');

            activeStatus = $(this).data('status').toString();
            filterJadwal();
        });

        $(document).off('input', '#searchJadwalKelas').on('input', '#searchJadwalKelas', function() {
            searchQuery = $(this).val().toLowerCase().trim();
            filterJadwal();
        });
    })();
</script>

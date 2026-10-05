1{{-- Modal Detail Santri Belum Masuk Rombel: 100% Tailwind CSS --}}
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
            <div class="w-10 h-10 rounded-xl bg-indigo-50 border border-indigo-200/80 text-indigo-600 flex items-center justify-center text-xl shrink-0">
                <i class="ti ti-users-minus"></i>
            </div>
        @endif
        <div>
            <h3 class="text-base font-bold text-slate-900 tracking-tight">
                Santri Belum Masuk Rombel (Kelas)
            </h3>
            <div class="flex flex-wrap items-center gap-2 mt-0.5 text-xs text-slate-500">
                <span>Unit: <strong class="text-slate-800 font-semibold">{{ $unit ? $unit->nama_unit : '-' }}</strong></span>
                <span class="text-slate-300">•</span>
                <span>Tahun Ajaran: <strong class="text-slate-800 font-semibold">{{ $ta ? $ta->tahun_ajaran : '-' }}</strong></span>
                <span class="text-slate-300">•</span>
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-bold bg-rose-50 text-rose-600 border border-rose-100">
                    {{ $students->count() }} Santri Belum Di-Plot
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
            <div class="w-9 h-9 rounded-lg bg-indigo-50 text-indigo-600 border border-indigo-100 flex items-center justify-center text-lg shrink-0 mt-0.5">
                <i class="ti ti-info-circle"></i>
            </div>
            <div class="text-xs text-slate-600 leading-relaxed">
                <p class="font-medium text-slate-800">Daftar santri aktif yang belum dimasukkan ke dalam rombel kelas.</p>
                <p class="text-slate-500 mt-0.5">Anda dapat memplot langsung kelas dari daftar di bawah ini atau melalui menu manajemen rombel.</p>
            </div>
        </div>
        <div class="flex items-center gap-2 shrink-0 self-end sm:self-center">
            <a href="{{ route('kelas.index', ['kode_unit_search' => $unit ? $unit->kode_unit : '', 'kode_ta' => $ta ? $ta->kode_ta : '']) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-900 hover:bg-slate-800 text-white rounded-lg text-xs font-semibold shadow-2xs transition">
                <i class="ti ti-external-link text-sm"></i>
                <span>Buka Ploting Kelas</span>
            </a>
        </div>
    </div>

    {{-- Filter Bar (Tingkat & Cari) --}}
    @php
        $tingkatList = $students->pluck('tingkat')->filter()->unique()->sort()->values();
    @endphp
    <div class="bg-white border border-slate-200/90 rounded-xl p-3 shadow-2xs flex flex-col md:flex-row items-stretch md:items-center justify-between gap-3">
        <div class="flex flex-wrap items-center gap-1.5" id="filterTingkatContainer">
            <span class="text-xs font-bold text-slate-400 mr-1 flex items-center gap-1">
                <i class="ti ti-filter text-sm"></i> Filter:
            </span>
            <button type="button" class="btn-filter-tingkat px-2.5 py-1 text-xs font-bold rounded-lg transition bg-indigo-600 text-white shadow-2xs" data-tingkat="all">
                Semua (<span id="count-all">{{ $students->count() }}</span>)
            </button>
            @foreach ($tingkatList as $t)
                @php $countTingkat = $students->where('tingkat', $t)->count(); @endphp
                <button type="button" class="btn-filter-tingkat px-2.5 py-1 text-xs font-semibold rounded-lg transition bg-slate-100 hover:bg-slate-200 text-slate-600" data-tingkat="{{ $t }}">
                    Tk. {{ $t }} (<span class="count-tingkat">{{ $countTingkat }}</span>)
                </button>
            @endforeach
        </div>
        <div class="relative w-full md:w-64">
            <i class="ti ti-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
            <input type="text" id="searchSantriBelumPlot" class="w-full pl-9 pr-3 py-1.5 text-xs bg-slate-50 border border-slate-200 rounded-lg text-slate-700 focus:outline-hidden focus:border-indigo-500 focus:bg-white transition" placeholder="Cari nama / NIS / No. daftar...">
        </div>
    </div>

    {{-- Cards Grid Layout --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3.5" id="santriBelumPlotGrid">
        @forelse ($students as $index => $s)
            <div class="santri-card-item bg-white border border-slate-200/90 rounded-2xl p-4 shadow-2xs hover:border-slate-300 transition flex flex-col justify-between" 
                 data-tingkat="{{ $s->tingkat ?? '' }}" 
                 data-search="{{ strtolower($s->nama_lengkap . ' ' . ($s->nis ?? '') . ' ' . $s->no_pendaftaran) }}">
                <div>
                    {{-- Santri Header --}}
                    <div class="flex items-center gap-3 pb-3 mb-3 border-b border-slate-100">
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
                            <h4 class="text-xs font-bold text-slate-900 truncate" title="{{ $s->nama_lengkap }}">{{ $s->nama_lengkap }}</h4>
                            <div class="text-[11px] text-slate-400 mt-0.5 truncate">NIS: <span class="font-semibold text-slate-700">{{ $s->nis ?? '-' }}</span> • ID: {{ $s->id_siswa }}</div>
                        </div>
                    </div>

                    {{-- Details Info Rows --}}
                    <div class="space-y-2 mb-3.5 text-xs">
                        <div class="flex items-center justify-between">
                            <span class="text-slate-400 text-[11px]">No. Daftar:</span>
                            <span class="font-mono text-[10px] font-bold px-2 py-0.5 bg-slate-100 text-slate-600 rounded-md">{{ $s->no_pendaftaran }}</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-slate-400 text-[11px]">Jenis Kelamin:</span>
                            @if ($s->jenis_kelamin == 'L')
                                <span class="px-2 py-0.5 text-[10px] font-bold rounded-md bg-blue-50 text-blue-700 border border-blue-100">Laki-laki</span>
                            @elseif ($s->jenis_kelamin == 'P')
                                <span class="px-2 py-0.5 text-[10px] font-bold rounded-md bg-rose-50 text-rose-700 border border-rose-100">Perempuan</span>
                            @else
                                <span class="text-slate-400">-</span>
                            @endif
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-slate-400 text-[11px]">Tingkat:</span>
                            <span class="px-2 py-0.5 text-[10px] font-bold rounded-md bg-indigo-50 text-indigo-700 border border-indigo-100">Tingkat {{ $s->tingkat ?? '-' }}</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-slate-400 text-[11px]">Status:</span>
                            <span class="px-2 py-0.5 text-[10px] font-bold rounded-md bg-rose-50 text-rose-700 border border-rose-200 inline-flex items-center gap-1">
                                <i class="ti ti-alert-triangle text-xs"></i> Belum Masuk Kelas
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Card Footer Action (Quick Plotting) --}}
                @php
                    $matchingKelas = $kelasList->where('tingkat', $s->tingkat);
                @endphp
                <div class="pt-3 border-t border-slate-100">
                    @if ($matchingKelas->count() > 0)
                        <div class="flex items-center gap-1.5">
                            <select class="select-plot-kelas flex-1 text-xs bg-slate-50 border border-slate-200 rounded-lg px-2.5 py-1.5 text-slate-700 font-medium focus:outline-hidden focus:border-indigo-500 focus:bg-white transition">
                                <option value="">-- Pilih Rombel --</option>
                                @foreach ($matchingKelas as $k)
                                    <option value="{{ $k->kode_kelas }}">
                                        {{ $k->nama_kelas }} (Tk.{{ $k->tingkat }})
                                    </option>
                                @endforeach
                            </select>
                            <button type="button" 
                                    class="btn-do-plot-kelas px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg text-xs shadow-2xs transition shrink-0 cursor-pointer active:scale-95" 
                                    data-id-siswa="{{ $s->id_siswa }}" 
                                    data-nama-siswa="{{ $s->nama_lengkap }}" 
                                    title="Simpan ke Kelas">
                                <i class="ti ti-check text-sm"></i>
                            </button>
                        </div>
                    @else
                        <div class="flex items-center justify-between gap-1.5 bg-amber-50/70 border border-amber-200/80 rounded-lg p-2 text-amber-800">
                            <div class="text-[11px] font-semibold flex items-center gap-1">
                                <i class="ti ti-alert-circle text-sm text-amber-600"></i>
                                <span>Belum ada kelas Tk.{{ $s->tingkat }}</span>
                            </div>
                            <a href="{{ route('kelas.index', ['kode_unit_search' => $s->kode_unit ?? ($unit ? $unit->kode_unit : ''), 'kode_ta' => $ta ? $ta->kode_ta : '']) }}" target="_blank" class="px-2 py-0.5 bg-white hover:bg-slate-50 border border-amber-300 text-amber-900 rounded text-[10px] font-bold transition">
                                Buat
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white border border-slate-200/90 rounded-2xl p-10 text-center text-slate-400" id="emptyStateAllDone">
                <i class="ti ti-circle-check text-4xl text-emerald-500 block mb-2 mx-auto"></i>
                <h4 class="text-sm font-bold text-slate-800">Seluruh Santri Sudah Masuk Rombel</h4>
                <p class="text-xs text-slate-500 mt-1">Tidak ada santri yang tertinggal dalam penempatan kelas.</p>
            </div>
        @endforelse

        {{-- Empty Search State --}}
        <div class="col-span-full bg-white border border-slate-200/90 rounded-2xl p-10 text-center text-slate-400 hidden" id="santriBelumPlotEmptySearch">
            <i class="ti ti-search-off text-4xl text-slate-300 block mb-2 mx-auto"></i>
            <h4 class="text-sm font-bold text-slate-800">Tidak Ada Santri Yang Cocok</h4>
            <p class="text-xs text-slate-500 mt-1">Coba ubah kata kunci pencarian atau filter tingkat kelas.</p>
        </div>
    </div>
</div>

<div class="px-6 py-3.5 bg-white border-t border-slate-100 flex items-center justify-between">
    <div class="text-xs text-slate-400">
        Menampilkan <strong class="text-slate-700 font-semibold" id="count-visible-santri">{{ $students->count() }}</strong> santri
    </div>
    <button type="button" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition cursor-pointer" data-bs-dismiss="modal">
        Tutup
    </button>
</div>

<script>
    (function() {
        let activeTingkat = 'all';
        let searchQuery = '';

        function filterSantri() {
            let visibleCount = 0;
            $('.santri-card-item').each(function() {
                let cardTingkat = $(this).data('tingkat') ? $(this).data('tingkat').toString() : '';
                let cardSearch = $(this).data('search') ? $(this).data('search').toString() : '';

                let matchesTingkat = (activeTingkat === 'all' || cardTingkat === activeTingkat);
                let matchesSearch = (!searchQuery || cardSearch.includes(searchQuery));

                if (matchesTingkat && matchesSearch) {
                    $(this).removeClass('hidden');
                    visibleCount++;
                } else {
                    $(this).addClass('hidden');
                }
            });

            $('#count-visible-santri').text(visibleCount);

            if (visibleCount === 0 && $('.santri-card-item').length > 0) {
                $('#santriBelumPlotEmptySearch').removeClass('hidden');
            } else {
                $('#santriBelumPlotEmptySearch').addClass('hidden');
            }
        }

        $(document).off('click', '.btn-filter-tingkat').on('click', '.btn-filter-tingkat', function() {
            $('.btn-filter-tingkat').removeClass('bg-indigo-600 text-white shadow-2xs').addClass('bg-slate-100 text-slate-600 hover:bg-slate-200');
            $(this).removeClass('bg-slate-100 text-slate-600 hover:bg-slate-200').addClass('bg-indigo-600 text-white shadow-2xs');

            activeTingkat = $(this).data('tingkat').toString();
            filterSantri();
        });

        $(document).off('input', '#searchSantriBelumPlot').on('input', '#searchSantriBelumPlot', function() {
            searchQuery = $(this).val().toLowerCase().trim();
            filterSantri();
        });

        // Direct Ploting Action via AJAX
        $(document).off('click', '.btn-do-plot-kelas').on('click', '.btn-do-plot-kelas', function(e) {
            e.preventDefault();
            let $btn = $(this);
            let $card = $btn.closest('.santri-card-item');
            let $select = $card.find('.select-plot-kelas');
            let kode_kelas = $select.val();
            let id_siswa = $btn.data('id-siswa');
            let nama_siswa = $btn.data('nama-siswa');
            let nama_kelas = $select.find('option:selected').text().trim();
            let tingkatSantri = $card.data('tingkat') ? $card.data('tingkat').toString() : '';

            if (!kode_kelas) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Pilih Kelas',
                    text: 'Silakan pilih kelas rombel tujuan terlebih dahulu.',
                    customClass: { confirmButton: 'btn btn-warning' }
                });
                return;
            }

            $btn.prop('disabled', true).html('<i class="ti ti-loader-2 animate-spin text-sm"></i>');

            $.ajax({
                method: "POST",
                url: "{{ route('kelas.storetambahsiswa') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    id_siswa: id_siswa,
                    kode_kelas: kode_kelas
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil Masuk Rombel',
                            text: `${nama_siswa} berhasil dimasukkan ke ${nama_kelas}`,
                            timer: 1800,
                            showConfirmButton: false
                        });

                        // Animasi hilang card santri
                        $card.fadeOut(300, function() {
                            $card.remove();

                            // Update Badge Counter & Filter Counts
                            let totalLeft = $('.santri-card-item').length;
                            $('#count-all').text(totalLeft);

                            if (tingkatSantri) {
                                let $btnTingkat = $(`.btn-filter-tingkat[data-tingkat="${tingkatSantri}"]`);
                                let countForTingkat = $(`.santri-card-item[data-tingkat="${tingkatSantri}"]`).length;
                                $btnTingkat.find('.count-tingkat').text(countForTingkat);
                            }

                            filterSantri();

                            if (totalLeft === 0) {
                                $('#santriBelumPlotGrid').html(`
                                    <div class="col-span-full bg-white border border-slate-200/90 rounded-2xl p-10 text-center text-slate-400" id="emptyStateAllDone">
                                        <i class="ti ti-circle-check text-4xl text-emerald-500 block mb-2 mx-auto"></i>
                                        <h4 class="text-sm font-bold text-slate-800">Seluruh Santri Sudah Masuk Rombel</h4>
                                        <p class="text-xs text-slate-500 mt-1">Tidak ada santri yang tertinggal dalam penempatan kelas.</p>
                                    </div>
                                `);
                            }
                        });
                    } else {
                        $btn.prop('disabled', false).html('<i class="ti ti-check text-sm"></i>');
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.message || 'Terjadi kesalahan saat memploting santri.',
                            customClass: { confirmButton: 'btn btn-danger' }
                        });
                    }
                },
                error: function(xhr) {
                    $btn.prop('disabled', false).html('<i class="ti ti-check text-sm"></i>');
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan server saat menyimpan data.',
                        customClass: { confirmButton: 'btn btn-danger' }
                    });
                }
            });
        });
    })();
</script>

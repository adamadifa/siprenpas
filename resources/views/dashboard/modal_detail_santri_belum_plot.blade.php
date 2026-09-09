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
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-3 bg-white p-3 rounded-3 border">
        <div class="d-flex align-items-center gap-2" style="font-size: 0.83rem; color: #475569;">
            <i class="ti ti-info-circle text-primary fs-5"></i>
            <span>Daftar santri aktif yang belum dimasukkan ke dalam rombongan belajar (kelas).</span>
        </div>
        <a href="{{ route('kelas.index', ['kode_unit_search' => $unit ? $unit->kode_unit : '', 'kode_ta' => $ta ? $ta->kode_ta : '']) }}" target="_blank" class="btn btn-sm btn-dark d-flex align-items-center gap-1.5 fw-semibold shadow-none flex-shrink-0" style="border-radius: 8px;">
            <i class="ti ti-external-link fs-6"></i> <span>Buka Ploting Kelas</span>
        </a>
    </div>

    {{-- Filter Bar (Tingkat & Cari) --}}
    @php
        $tingkatList = $students->pluck('tingkat')->filter()->unique()->sort()->values();
    @endphp
    <div class="card mb-3 bg-white border rounded-3 shadow-none p-3">
        <div class="row g-2 align-items-center">
            <div class="col-12 col-md-auto">
                <span class="text-muted fw-bold d-flex align-items-center gap-1" style="font-size: 0.8rem;">
                    <i class="ti ti-filter fs-6"></i> Filter Tingkat:
                </span>
            </div>
            <div class="col-12 col-md d-flex flex-wrap gap-1.5 align-items-center" id="filterTingkatContainer">
                <button type="button" class="btn btn-xs btn-primary btn-filter-tingkat active" data-tingkat="all" style="border-radius: 6px;">
                    Semua (<span id="count-all">{{ $students->count() }}</span>)
                </button>
                @foreach ($tingkatList as $t)
                    @php $countTingkat = $students->where('tingkat', $t)->count(); @endphp
                    <button type="button" class="btn btn-xs btn-outline-secondary btn-filter-tingkat" data-tingkat="{{ $t }}" style="border-radius: 6px;">
                        Tingkat {{ $t }} (<span class="count-tingkat">{{ $countTingkat }}</span>)
                    </button>
                @endforeach
            </div>
            <div class="col-12 col-md-4 ms-auto">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-white border-end-0"><i class="ti ti-search text-muted"></i></span>
                    <input type="text" id="searchSantriBelumPlot" class="form-control bg-white border-start-0 ps-0" placeholder="Cari nama / NIS / No. daftar..." style="font-size: 0.8rem;">
                </div>
            </div>
        </div>
    </div>

    {{-- Cards Grid Layout --}}
    <div class="row g-3" id="santriBelumPlotGrid">
        @forelse ($students as $index => $s)
            <div class="col-12 col-md-6 col-xl-4 santri-card-item" data-tingkat="{{ $s->tingkat ?? '' }}" data-search="{{ strtolower($s->nama_lengkap . ' ' . ($s->nis ?? '') . ' ' . $s->no_pendaftaran) }}">
                <div class="card h-100 bg-white border rounded-3 p-3 shadow-none d-flex flex-column justify-content-between">
                    <div>
                        {{-- Santri Header --}}
                        <div class="d-flex align-items-center gap-3 pb-2 mb-3 border-bottom">
                            @if (!empty($s->foto_pendaftaran) && Storage::disk('public')->exists('photos/pendaftaran/' . $s->foto_pendaftaran))
                                <img src="{{ asset('storage/photos/pendaftaran/' . $s->foto_pendaftaran) }}" alt="Foto" class="rounded-circle flex-shrink-0 me-1" style="width: 42px; height: 42px; object-fit: cover; border: 1px solid #e2e8f0;">
                            @elseif (!empty($s->foto_pendaftaran) && Storage::disk('public')->exists($s->foto_pendaftaran))
                                <img src="{{ asset('storage/' . $s->foto_pendaftaran) }}" alt="Foto" class="rounded-circle flex-shrink-0 me-1" style="width: 42px; height: 42px; object-fit: cover; border: 1px solid #e2e8f0;">
                            @else
                                <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-secondary flex-shrink-0 me-1" style="width: 42px; height: 42px; font-size: 0.9rem; background-color: #f1f5f9; border: 1px solid #e2e8f0;">
                                    {{ substr($s->nama_lengkap, 0, 1) }}
                                </div>
                            @endif
                            <div class="overflow-hidden">
                                <div class="fw-bold text-dark text-truncate" title="{{ $s->nama_lengkap }}">{{ $s->nama_lengkap }}</div>
                                <div class="text-muted mt-0.5" style="font-size: 0.74rem;">NIS: {{ $s->nis ?? '-' }} • ID: {{ $s->id_siswa }}</div>
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
                    @php
                        // Filter kelas yang sesuai dengan tingkat santri
                        $matchingKelas = $kelasList->where('tingkat', $s->tingkat);
                    @endphp
                    <div class="pt-2 border-top">
                        @if ($matchingKelas->count() > 0)
                            <div class="input-group input-group-sm">
                                <select class="form-select select-plot-kelas" style="font-size: 0.78rem;">
                                    <option value="">-- Pilih Kelas --</option>
                                    @foreach ($matchingKelas as $k)
                                        <option value="{{ $k->kode_kelas }}">
                                            {{ $k->nama_kelas }} (Tk.{{ $k->tingkat }})
                                        </option>
                                    @endforeach
                                </select>
                                <button type="button" class="btn btn-primary btn-do-plot-kelas px-2.5" data-id-siswa="{{ $s->id_siswa }}" data-nama-siswa="{{ $s->nama_lengkap }}" title="Simpan ke Kelas">
                                    <i class="ti ti-check"></i>
                                </button>
                            </div>
                        @else
                            <div class="d-flex align-items-center justify-content-between gap-1">
                                <small class="text-danger" style="font-size: 0.73rem;"><i class="ti ti-alert-circle"></i> Belum ada kelas Tk.{{ $s->tingkat }}</small>
                                <a href="{{ route('kelas.index', ['kode_unit_search' => $s->kode_unit ?? ($unit ? $unit->kode_unit : ''), 'kode_ta' => $ta ? $ta->kode_ta : '']) }}" target="_blank" class="btn btn-xs btn-outline-secondary" style="font-size: 0.72rem;">
                                    Buat Kelas
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12" id="emptyStateAllDone">
                <div class="card p-5 text-center bg-white border rounded-3 shadow-none">
                    <i class="ti ti-circle-check fs-1 text-success d-block mb-2"></i>
                    <div class="fw-bold text-dark fs-6">Seluruh Santri Sudah Masuk Rombel</div>
                    <small class="text-muted">Tidak ada santri yang tertinggal dalam penempatan kelas.</small>
                </div>
            </div>
        @endforelse

        {{-- Empty Filter State (Hidden by default) --}}
        <div class="col-12 d-none" id="santriBelumPlotEmptySearch">
            <div class="card p-5 text-center bg-white border rounded-3 shadow-none">
                <i class="ti ti-search-off fs-1 text-muted d-block mb-2"></i>
                <div class="fw-bold text-dark fs-6">Tidak Ada Santri Yang Cocok</div>
                <small class="text-muted">Coba ubah kata kunci pencarian atau filter tingkat kelas.</small>
            </div>
        </div>
    </div>
</div>

<div class="modal-footer px-4 py-3 bg-white border-top d-flex justify-content-between align-items-center">
    <div class="text-muted" style="font-size: 0.8rem;">
        Menampilkan <strong class="text-dark" id="count-visible-santri">{{ $students->count() }}</strong> santri
    </div>
    <button type="button" class="btn btn-sm btn-outline-secondary fw-semibold px-3" data-bs-dismiss="modal" style="border-radius: 8px;">Tutup</button>
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
                    $(this).removeClass('d-none');
                    visibleCount++;
                } else {
                    $(this).addClass('d-none');
                }
            });

            $('#count-visible-santri').text(visibleCount);

            if (visibleCount === 0 && $('.santri-card-item').length > 0) {
                $('#santriBelumPlotEmptySearch').removeClass('d-none');
            } else {
                $('#santriBelumPlotEmptySearch').addClass('d-none');
            }
        }

        $(document).off('click', '.btn-filter-tingkat').on('click', '.btn-filter-tingkat', function() {
            $('.btn-filter-tingkat').removeClass('btn-primary active').addClass('btn-outline-secondary');
            $(this).removeClass('btn-outline-secondary').addClass('btn-primary active');

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

            $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status"></span>');

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
                                    <div class="col-12" id="emptyStateAllDone">
                                        <div class="card p-5 text-center bg-white border rounded-3 shadow-none">
                                            <i class="ti ti-circle-check fs-1 text-success d-block mb-2"></i>
                                            <div class="fw-bold text-dark fs-6">Seluruh Santri Sudah Masuk Rombel</div>
                                            <small class="text-muted">Tidak ada santri yang tertinggal dalam penempatan kelas.</small>
                                        </div>
                                    </div>
                                `);
                            }
                        });
                    } else {
                        $btn.prop('disabled', false).html('<i class="ti ti-check"></i>');
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.message || 'Terjadi kesalahan saat memploting santri.',
                            customClass: { confirmButton: 'btn btn-danger' }
                        });
                    }
                },
                error: function(xhr) {
                    $btn.prop('disabled', false).html('<i class="ti ti-check"></i>');
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



@extends('layouts.app')
@section('titlepage', 'Input Nilai ' . ucfirst(strtolower($kategori)))

@section('content')
<div class="space-y-5">

    <!-- ================= 1. PAGE HEADER (NO CARD) WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle with Back Button -->
        <div class="flex items-center gap-3.5">
            <a href="{{ route('penilaian.index', \App\Models\JadwalPelajaran::where('kode_kelas', $bobot->kode_kelas)->where('mata_pelajaran_id', $bobot->mata_pelajaran_id)->first()->id ?? '#') }}" 
               class="w-10 h-10 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 flex items-center justify-center transition shadow-2xs active:scale-95 shrink-0"
               title="Kembali ke Rekap Nilai">
                <i class="ti ti-arrow-left text-lg"></i>
            </a>
            <div>
                <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2">
                    <span>Input Nilai {{ ucfirst(strtolower($kategori)) }}</span>
                </h1>
                <p class="text-xs text-slate-500 mt-0.5">
                    Mata Pelajaran: <span class="font-bold text-slate-800">{{ $bobot->mapel->nama_matpel ?? '-' }}</span> • Kelas: <span class="font-bold text-slate-800">{{ $bobot->kelas->nama_kelas ?? '-' }}</span> ({{ $bobot->unit->nama_unit ?? '-' }})
                </p>
            </div>
        </div>

        <!-- Right Side: Breadcrumb & Add Column Action -->
        <div class="flex flex-col md:items-end gap-2.5">
            <nav class="flex items-center text-xs text-slate-400 font-medium">
                <a href="{{ route('dashboard.index') }}" class="hover:text-slate-700 transition flex items-center gap-1">
                    <i class="ti ti-home text-sm"></i>
                    <span>Dashboard</span>
                </a>
                <span class="mx-2 text-slate-300">/</span>
                <a href="{{ route('rapor.index') }}" class="hover:text-slate-700 transition flex items-center gap-1">
                    <i class="ti ti-school text-sm"></i>
                    <span>Penilaian</span>
                </a>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Input {{ ucfirst(strtolower($kategori)) }}</span>
            </nav>

            @if (($bobot->status ?? 'draft') != 'terkirim')
                <div class="flex items-center gap-2">
                    <button type="button" 
                            id="btnTambahKolom" 
                            data-bs-toggle="modal" 
                            data-bs-target="#mdlAddColumn"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg text-xs shadow-xs transition-all duration-200 active:scale-95 cursor-pointer">
                        <i class="ti ti-plus text-base"></i>
                        <span>Tambah Kolom Asesmen</span>
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- Alert if grades are locked -->
    @if (($bobot->status ?? 'draft') == 'terkirim')
        <div class="p-4 bg-amber-50 border border-amber-200 rounded-2xl flex items-center gap-3 text-amber-900 shadow-2xs">
            <div class="w-9 h-9 rounded-xl bg-amber-500 text-white flex items-center justify-center shrink-0">
                <i class="ti ti-lock text-lg"></i>
            </div>
            <div>
                <h4 class="text-xs font-bold text-amber-950">Nilai Terkunci (Telah Terkirim ke Rapor)</h4>
                <p class="text-[11px] text-amber-800 mt-0.5">
                    Nilai untuk mata pelajaran dan rombel kelas ini telah dikirimkan ke wali kelas. Untuk mengedit kembali, silakan buka kunci pengiriman di halaman rekap nilai.
                </p>
            </div>
        </div>
    @endif

    <!-- ================= 2. MATRIX GRADE ENTRY TABLE CARD ================= -->
    <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
        
        <!-- Seamless Solid Green Card Header & Live Search -->
        <div class="px-5 pt-4 pb-3 bg-emerald-600 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-white border-0">
            <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-lg bg-white/20 text-white flex items-center justify-center text-xs font-bold border border-white/20 shadow-2xs">
                    <i class="ti ti-notebook"></i>
                </div>
                <div>
                    <h3 class="text-sm font-extrabold text-white tracking-tight">Matriks Nilai {{ ucfirst(strtolower($kategori)) }}</h3>
                    <span class="text-[11px] text-emerald-100 font-medium">{{ count($students) }} Siswa • {{ $rencanaPenilaian->count() }} Kolom Asesmen</span>
                </div>
            </div>

            <!-- Instant Live Search Bar -->
            <div class="relative w-full sm:w-72">
                <i class="ti ti-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm pointer-events-none"></i>
                <input type="text" 
                       id="searchInput" 
                       placeholder="Cari nama atau NIS siswa..." 
                       class="w-full pl-8 pr-3 py-1.5 text-xs bg-white text-slate-800 font-medium rounded-xl border border-white/20 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-300 transition placeholder:text-slate-400">
            </div>
        </div>

        <form action="{{ route('penilaian.store-multi-nilai') }}" method="POST" id="formMatrixNilai" novalidate>
            @csrf
            
            <div class="overflow-x-auto bg-emerald-600">
                <table class="w-full text-left text-xs border-0 border-collapse" id="nilaiTable">
                    <!-- Matching Solid Green Table Header -->
                    <thead class="bg-emerald-600 text-white font-bold uppercase tracking-wider text-[11px] border-0 border-t-0 border-b border-emerald-700/80">
                        <tr class="border-0 border-t-0">
                            <th class="py-2.5 px-3.5 w-12 text-center text-emerald-100 border-0 border-t-0 whitespace-nowrap" rowspan="2">No</th>
                            <th class="py-2.5 px-3.5 w-28 text-center text-emerald-100 border-0 border-t-0 whitespace-nowrap" rowspan="2">NIS</th>
                            <th class="py-2.5 px-3.5 min-w-[220px] text-emerald-100 border-0 border-t-0" rowspan="2">Santri / Siswa</th>
                            <th class="py-2.5 px-3.5 w-12 text-center text-emerald-100 border-0 border-t-0 whitespace-nowrap" rowspan="2">L/P</th>
                            @if($rencanaPenilaian->count() > 0)
                                <th class="py-2 px-3 text-center text-emerald-100 border-0 border-t-0 border-b border-emerald-700/50" colspan="{{ $rencanaPenilaian->count() }}">
                                    Kolom Asesmen (Lingkup Materi)
                                </th>
                            @else
                                <th class="py-2.5 px-3.5 text-center text-emerald-100 border-0 border-t-0">Asesmen</th>
                            @endif
                        </tr>
                        @if($rencanaPenilaian->count() > 0)
                            <tr class="border-0 border-t-0 bg-emerald-700/60">
                                @foreach ($rencanaPenilaian as $colIndex => $rencana)
                                    <th class="py-2 px-3 text-center text-emerald-50 min-w-[110px] border-0 border-t-0">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="flex items-center gap-1 font-mono font-bold text-xs">
                                                <span>{{ $rencana->kode_penilaian }}</span>
                                                @if (($bobot->status ?? 'draft') != 'terkirim')
                                                    <button type="button" 
                                                            class="text-rose-300 hover:text-rose-100 transition p-0.5 btn-delete-column cursor-pointer" 
                                                            data-id="{{ $rencana->id }}" 
                                                            data-nama="{{ $rencana->nama_penilaian }}"
                                                            title="Hapus Kolom {{ $rencana->kode_penilaian }}">
                                                        <i class="ti ti-x text-[11px]"></i>
                                                    </button>
                                                @endif
                                            </div>
                                            <span class="text-[9px] font-normal text-emerald-200 truncate max-w-[100px]" title="{{ $rencana->nama_penilaian }}">
                                                {{ $rencana->nama_penilaian }}
                                            </span>
                                        </div>
                                    </th>
                                @endforeach
                            </tr>
                        @endif
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700 font-medium bg-white">
                        @forelse ($students as $rowIndex => $student)
                            <tr class="hover:bg-slate-50/80 transition-colors group student-row" data-row="{{ $rowIndex }}">
                                <!-- No -->
                                <td class="py-2.5 px-3.5 text-center text-slate-400 font-bold text-xs whitespace-nowrap">
                                    <span class="w-6 h-6 rounded-md bg-slate-100 group-hover:bg-emerald-50 group-hover:text-emerald-700 group-hover:border group-hover:border-emerald-200 inline-flex items-center justify-center font-bold text-slate-600 transition text-[11px]">
                                        {{ $rowIndex + 1 }}
                                    </span>
                                </td>

                                <!-- NIS -->
                                <td class="py-2.5 px-3.5 text-center font-mono font-bold text-xs text-slate-600 whitespace-nowrap">
                                    {{ $student->nis ?? $student->id_siswa }}
                                </td>

                                <!-- Nama Lengkap -->
                                <td class="py-2.5 px-3.5 font-bold text-slate-900 group-hover:text-emerald-800 transition text-xs whitespace-nowrap">
                                    {{ strtoupper($student->nama_lengkap) }}
                                </td>

                                <!-- L/P -->
                                <td class="py-2.5 px-3.5 text-center whitespace-nowrap">
                                    <span class="px-1.5 py-0.5 rounded text-[10px] font-bold {{ $student->jenis_kelamin == 'L' ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'bg-rose-50 text-rose-700 border border-rose-200' }}">
                                        {{ $student->jenis_kelamin ?? '-' }}
                                    </span>
                                </td>

                                <!-- Dynamic Assessment Columns -->
                                @forelse ($rencanaPenilaian as $colIndex => $rencana)
                                    @php
                                        $score = $mappedGrades[$student->id_siswa][$rencana->id] ?? '';
                                    @endphp
                                    <td class="p-1.5 text-center">
                                        <input type="number" 
                                               step="0.01" 
                                               min="0" 
                                               max="100" 
                                               data-row="{{ $rowIndex }}"
                                               data-col="{{ $colIndex }}"
                                               name="nilai[{{ $student->id_siswa }}][{{ $rencana->id }}]" 
                                               value="{{ $score }}" 
                                               placeholder="-"
                                               class="w-20 px-2 py-1.5 text-center font-bold font-mono text-xs rounded-lg border transition score-input {{ $score !== '' ? ($score < 75 ? 'bg-rose-50 border-rose-300 text-rose-700' : 'bg-emerald-50 border-emerald-300 text-emerald-800') : 'bg-slate-50 border-slate-200 text-slate-800 focus:bg-white focus:border-emerald-600 focus:ring-2 focus:ring-emerald-500/20' }}"
                                               {{ ($bobot->status ?? 'draft') == 'terkirim' ? 'disabled' : '' }}>
                                    </td>
                                @empty
                                    <td class="p-8 text-center text-slate-400 italic text-xs">
                                        Belum ada kolom asesmen. Klik tombol <strong>+ Tambah Kolom Asesmen</strong> di kanan atas.
                                    </td>
                                @endforelse
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ 4 + max(1, $rencanaPenilaian->count()) }}" class="p-12 text-center text-slate-400">
                                    <div class="w-12 h-12 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center mx-auto mb-2 text-slate-400 text-xl">
                                        <i class="ti ti-users-minus"></i>
                                    </div>
                                    <h5 class="text-xs font-bold text-slate-700">Tidak Ada Data Siswa</h5>
                                    <p class="text-[11px] text-slate-400 mt-0.5">Tidak ditemukan santri yang terdaftar di rombel kelas ini.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Sticky Save Bar -->
            @if (($bobot->status ?? 'draft') != 'terkirim' && $rencanaPenilaian->count() > 0)
                <div class="p-4 bg-slate-50 border-t border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3 sticky bottom-0 z-10 shadow-lg">
                    <p class="text-xs text-slate-500 flex items-center gap-1.5">
                        <i class="ti ti-info-circle text-emerald-600 text-base"></i>
                        <span>Pastikan rentang nilai berada di antara 0 - 100, lalu tekan tombol Simpan Semua Nilai.</span>
                    </p>
                    <button type="submit" id="btnSaveMulti" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition inline-flex items-center justify-center gap-2 cursor-pointer active:scale-95">
                        <i class="ti ti-device-floppy text-base"></i>
                        <span>Simpan Semua Nilai</span>
                    </button>
                </div>
            @endif
        </form>
    </div>

</div>

<!-- ================= MODAL TAMBAH KOLOM ASESMEN ================= -->
<div class="modal fade" id="mdlAddColumn" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-2xl border-0 shadow-2xl overflow-hidden bg-white">
            <!-- Modal Header -->
            <div class="px-5 py-4 bg-emerald-600 text-white flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-lg bg-white/20 text-white flex items-center justify-center text-xs font-bold border border-white/20 shadow-2xs">
                        <i class="ti ti-plus"></i>
                    </div>
                    <h5 class="text-sm font-extrabold text-white">Tambah Kolom Penilaian {{ ucfirst(strtolower($kategori)) }}</h5>
                </div>
                <button type="button" class="w-7 h-7 rounded-lg bg-white/20 hover:bg-white/30 text-white flex items-center justify-center transition cursor-pointer text-xs" data-bs-dismiss="modal">
                    <i class="ti ti-x"></i>
                </button>
            </div>
            
            <form action="{{ route('penilaian.store-rencana') }}" method="POST" id="formAddColumn" class="space-y-4" novalidate>
                @csrf
                <input type="hidden" name="bobot_penilaian_id" value="{{ $bobot->id }}">
                <input type="hidden" name="kategori_penilaian" value="{{ $kategori }}">
                
                <div class="p-5 space-y-4">
                    <!-- Kode Singkatan -->
                    <div class="space-y-1.5">
                        <label for="create_kode_penilaian" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                            <i class="ti ti-hash text-sm text-slate-400"></i>
                            <span>Kode / Singkatan Kolom <span class="text-rose-500 font-bold">*</span></span>
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <i class="ti ti-numbers text-base"></i>
                            </div>
                            <input type="text" 
                                   id="create_kode_penilaian"
                                   name="kode_penilaian" 
                                   placeholder="{{ $kategori == 'SUMATIF' ? 'Contoh: PH1, TP1, UTS' : 'Contoh: SAS, PAS' }}" 
                                   maxlength="10"
                                   class="w-full pl-9 pr-3.5 py-2.5 text-sm font-bold font-mono text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition uppercase" 
                                   required>
                        </div>
                        <span class="text-[11px] text-slate-400 block">Maksimal 10 karakter untuk judul kolom header tabel.</span>
                    </div>

                    <!-- Nama Materi -->
                    <div class="space-y-1.5">
                        <label for="create_nama_penilaian" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                            <i class="ti ti-notebook text-sm text-slate-400"></i>
                            <span>Nama Materi / Pokok Bahasan <span class="text-rose-500 font-bold">*</span></span>
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <i class="ti ti-book-2 text-base"></i>
                            </div>
                            <input type="text" 
                                   id="create_nama_penilaian"
                                   name="nama_penilaian" 
                                   placeholder="Contoh: Bab 1 Bilangan Bulat & Pecahan" 
                                   maxlength="100"
                                   class="w-full pl-9 pr-3.5 py-2.5 text-sm font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                                   required>
                        </div>
                    </div>

                    <!-- Tanggal Pelaksanaan -->
                    <div class="space-y-1.5">
                        <label for="create_tanggal_penilaian" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                            <i class="ti ti-calendar text-sm text-slate-400"></i>
                            <span>Tanggal Pelaksanaan <span class="text-rose-500 font-bold">*</span></span>
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <i class="ti ti-calendar-event text-base"></i>
                            </div>
                            <input type="text" 
                                   id="create_tanggal_penilaian"
                                   name="tanggal_penilaian" 
                                   value="{{ date('Y-m-d') }}" 
                                   class="w-full pl-9 pr-3.5 py-2.5 text-sm font-bold font-mono text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition flatpickr-col-date" 
                                   required>
                        </div>
                    </div>
                </div>

                <!-- Modal Actions Footer -->
                <div class="px-5 py-3.5 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-2">
                    <button type="button" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer active:scale-95" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" id="btnSubmitAddColumn" class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition cursor-pointer active:scale-95 inline-flex items-center gap-1.5">
                        <i class="ti ti-device-floppy text-base"></i>
                        <span>Simpan Kolom</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Hidden Delete Column Form -->
<form id="formDeleteColumn" action="" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

@push('myscript')
<script>
    $(function() {
        // Initialize Flatpickr in modal
        if (typeof flatpickr === 'function') {
            $('.flatpickr-col-date').flatpickr({
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "d-m-Y"
            });
        }

        // Live Search Filtering
        $("#searchInput").on("keyup", function() {
            var val = $(this).val().toLowerCase().trim();
            $(".student-row").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(val) > -1);
            });
        });

        // Validation Rules for Add Column Form
        const columnValidationRules = {
            'kode_penilaian': { required: true, message: 'Kode atau singkatan penilaian wajib diisi' },
            'nama_penilaian': { required: true, message: 'Nama materi / pokok bahasan wajib diisi' },
            'tanggal_penilaian': { required: true, message: 'Tanggal pelaksanaan wajib ditentukan' }
        };

        function showColumnError(element, message) {
            const $el = $(element);
            const $container = $el.closest('.space-y-1\\.5').length ? $el.closest('.space-y-1\\.5') : $el.parent();
            
            $el.addClass('border-rose-500 ring-2 ring-rose-500/20 bg-rose-50/20')
               .removeClass('border-slate-300 focus:ring-emerald-500/20 focus:border-emerald-600');
            
            $el.siblings('.pointer-events-none').find('i').addClass('text-rose-500').removeClass('text-slate-400');
            $container.find('.error-msg').remove();
            $container.append(`
                <p class="error-msg text-[11px] font-semibold text-rose-500 mt-1 flex items-center gap-1 animate-in fade-in duration-200">
                    <i class="ti ti-alert-circle text-xs shrink-0"></i>
                    <span>${message}</span>
                </p>
            `);
        }

        function clearColumnError(element) {
            const $el = $(element);
            const $container = $el.closest('.space-y-1\\.5').length ? $el.closest('.space-y-1\\.5') : $el.parent();
            
            $el.removeClass('border-rose-500 ring-2 ring-rose-500/20 bg-rose-50/20')
               .addClass('border-slate-300 focus:ring-emerald-500/20 focus:border-emerald-600');
            
            $el.siblings('.pointer-events-none').find('i').removeClass('text-rose-500').addClass('text-slate-400');
            $container.find('.error-msg').remove();
        }

        function validateColumnField(el) {
            const $el = $(el);
            const name = $el.attr('name');
            const val = ($el.val() || '').toString().trim();

            const rule = columnValidationRules[name];
            if (!rule) {
                clearColumnError($el);
                return true;
            }

            if (rule.required && !val) {
                showColumnError($el, rule.message);
                return false;
            }

            clearColumnError($el);
            return true;
        }

        // Realtime trigger for Add Column form
        $('#formAddColumn').on('input change blur', 'input', function(e) {
            const $this = $(this);
            const hasError = $this.hasClass('border-rose-500');
            const val = ($this.val() || '').toString().trim();
            
            if (e.type === 'blur' || val !== '' || hasError) {
                validateColumnField(this);
            }
        });

        // Add Column Form Submission
        $('#formAddColumn').on('submit', function(e) {
            let isValid = true;
            let firstInvalidEl = null;

            Object.keys(columnValidationRules).forEach(function(fieldName) {
                const $el = $('#formAddColumn').find(`[name="${fieldName}"]`);
                if ($el.length > 0) {
                    const valid = validateColumnField($el);
                    if (!valid) {
                        isValid = false;
                        if (!firstInvalidEl) {
                            firstInvalidEl = $el;
                        }
                    }
                }
            });

            if (!isValid) {
                e.preventDefault();
                if (firstInvalidEl) {
                    firstInvalidEl.focus();
                }
                return false;
            }

            const btn = $('#btnSubmitAddColumn');
            btn.html('<div class="w-3.5 h-3.5 border-2 border-white border-t-transparent rounded-full animate-spin"></div> <span>Menyimpan...</span>');
            setTimeout(() => {
                btn.prop('disabled', true);
            }, 50);
        });

        // ================= SCORE INPUT VALIDATION & MATRIX NAVIGATION =================
        function formatScoreCell($input) {
            const val = $input.val().trim();
            if (val === '') {
                $input.removeClass('bg-rose-50 border-rose-400 text-rose-700 bg-emerald-50 border-emerald-300 text-emerald-800 ring-2 ring-rose-400/20')
                      .addClass('bg-slate-50 border-slate-200 text-slate-800');
                return true;
            }

            const num = parseFloat(val);
            if (isNaN(num) || num < 0 || num > 100) {
                $input.addClass('bg-rose-100 border-rose-500 text-rose-800 ring-2 ring-rose-500/30')
                      .removeClass('bg-emerald-50 border-emerald-300 text-emerald-800 bg-slate-50 border-slate-200 text-slate-800');
                return false;
            } else if (num < 75) {
                $input.addClass('bg-rose-50 border-rose-300 text-rose-700')
                      .removeClass('bg-emerald-50 border-emerald-300 text-emerald-800 bg-slate-50 border-slate-200 text-slate-800 bg-rose-100 border-rose-500 text-rose-800 ring-2 ring-rose-500/30');
                return true;
            } else {
                $input.addClass('bg-emerald-50 border-emerald-300 text-emerald-800')
                      .removeClass('bg-rose-50 border-rose-300 text-rose-700 bg-slate-50 border-slate-200 text-slate-800 bg-rose-100 border-rose-500 text-rose-800 ring-2 ring-rose-500/30');
                return true;
            }
        }

        // Live input formatting
        $('.score-input').on('input change', function() {
            formatScoreCell($(this));
        });

        // Keyboard Navigation (Enter, Arrow Up, Arrow Down)
        $('.score-input').on('keydown', function(e) {
            const row = parseInt($(this).data('row'));
            const col = parseInt($(this).data('col'));

            if (e.key === 'Enter' || e.key === 'ArrowDown') {
                e.preventDefault();
                const nextRowInput = $(`input.score-input[data-row="${row + 1}"][data-col="${col}"]`);
                if (nextRowInput.length) {
                    nextRowInput.focus().select();
                }
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                const prevRowInput = $(`input.score-input[data-row="${row - 1}"][data-col="${col}"]`);
                if (prevRowInput.length) {
                    prevRowInput.focus().select();
                }
            }
        });

        // Matrix Form Submit Validation
        $('#formMatrixNilai').on('submit', function(e) {
            let hasInvalidScore = false;
            let firstInvalid = null;

            $('.score-input').each(function() {
                const val = $(this).val().trim();
                if (val !== '') {
                    const num = parseFloat(val);
                    if (isNaN(num) || num < 0 || num > 100) {
                        hasInvalidScore = true;
                        if (!firstInvalid) firstInvalid = $(this);
                        formatScoreCell($(this));
                    }
                }
            });

            if (hasInvalidScore) {
                e.preventDefault();
                Swal.fire({
                    title: 'Nilai Tidak Valid!',
                    text: 'Terdapat nilai siswa yang berada di luar rentang 0 - 100. Silakan periksa kembali nilai yang ditandai merah.',
                    icon: 'warning',
                    confirmButtonColor: '#e11d48',
                    confirmButtonText: 'Perbaiki'
                });
                if (firstInvalid) {
                    firstInvalid.focus().select();
                }
                return false;
            }

            const btn = $('#btnSaveMulti');
            btn.html('<div class="w-3.5 h-3.5 border-2 border-white border-t-transparent rounded-full animate-spin"></div> <span>Menyimpan Semua Nilai...</span>');
            setTimeout(() => {
                btn.prop('disabled', true);
            }, 50);
        });

        // Delete Column Confirmation
        $('.btn-delete-column').click(function(e) {
            e.preventDefault();
            e.stopPropagation();
            const id = $(this).data('id');
            const nama = $(this).data('nama');

            Swal.fire({
                title: 'Hapus Kolom Asesmen?',
                html: `
                    <div class="text-xs sm:text-sm text-slate-600 mt-2 space-y-2 text-center">
                        <p>Apakah Anda yakin ingin menghapus kolom penilaian:</p>
                        <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-xl font-bold text-slate-900">
                            ${nama}
                        </div>
                        <p class="text-[11px] text-rose-500 font-semibold">Semua nilai siswa pada kolom ini akan terhapus secara permanen.</p>
                    </div>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: '<i class="ti ti-trash mr-1"></i> Ya, Hapus Kolom',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-2xl shadow-2xl p-5',
                    title: 'text-base font-bold text-slate-900',
                    confirmButton: 'px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs rounded-xl shadow-xs transition cursor-pointer',
                    cancelButton: 'px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const deleteForm = $('#formDeleteColumn');
                    deleteForm.attr('action', `/penilaian/rencana/${id}`);
                    deleteForm.submit();
                }
            });
        });
    });
</script>
@endpush
@endsection

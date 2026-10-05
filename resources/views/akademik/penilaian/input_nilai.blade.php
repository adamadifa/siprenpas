@extends('layouts.app')
@section('titlepage', 'Input Nilai ' . ($rencana->nama_penilaian ?? 'Asesmen'))

@section('content')
<div class="space-y-5">

    <!-- ================= 1. PAGE HEADER (NO CARD) WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle with Back Button -->
        <div class="flex items-center gap-3.5">
            <a href="{{ route('penilaian.index', $bobot->id) }}" 
               class="w-10 h-10 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 flex items-center justify-center transition shadow-2xs active:scale-95 shrink-0"
               title="Kembali ke Rekap Nilai">
                <i class="ti ti-arrow-left text-lg"></i>
            </a>
            <div>
                <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2">
                    <span>Input Nilai {{ ucfirst(strtolower($rencana->kategori_penilaian)) }} - {{ $rencana->nama_penilaian }}</span>
                </h1>
                <p class="text-xs text-slate-500 mt-0.5">
                    Mata Pelajaran: <span class="font-bold text-slate-800">{{ $bobot->mapel->nama_matpel ?? '-' }}</span> • Kelas: <span class="font-bold text-slate-800">{{ $kelas->nama_kelas ?? '-' }}</span> ({{ $kelas->unit->nama_unit ?? '-' }})
                </p>
            </div>
        </div>

        <!-- Right Side: Breadcrumb Navigation -->
        <div class="flex flex-col md:items-end">
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
                <span class="font-bold text-slate-800">{{ $rencana->kode_penilaian }}</span>
            </nav>
        </div>
    </div>

    <!-- Alert if locked -->
    @if (($bobot->status ?? 'draft') == 'terkirim')
        <div class="p-4 bg-amber-50 border border-amber-200 rounded-2xl flex items-center gap-3 text-amber-900 shadow-2xs">
            <div class="w-9 h-9 rounded-xl bg-amber-500 text-white flex items-center justify-center shrink-0">
                <i class="ti ti-lock text-lg"></i>
            </div>
            <div>
                <h4 class="text-xs font-bold text-amber-950">Nilai Terkunci (Telah Terkirim ke Rapor)</h4>
                <p class="text-[11px] text-amber-800 mt-0.5">
                    Nilai untuk mata pelajaran dan kelas ini telah dikirimkan ke wali kelas. Anda tidak dapat melakukan perubahan data.
                </p>
            </div>
        </div>
    @endif

    <!-- ================= 2. SCORE ENTRY CARD ================= -->
    <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
        
        <!-- Seamless Solid Green Card Header & Search -->
        <div class="px-5 pt-4 pb-3 bg-emerald-600 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-white border-0">
            <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-lg bg-white/20 text-white flex items-center justify-center text-xs font-bold border border-white/20 shadow-2xs">
                    <i class="ti ti-notebook"></i>
                </div>
                <div>
                    <h3 class="text-sm font-extrabold text-white tracking-tight">Formulir Nilai: {{ $rencana->kode_penilaian }} ({{ $rencana->nama_penilaian }})</h3>
                    <span class="text-[11px] text-emerald-100 font-medium">{{ count($students) }} Siswa Terdaftar</span>
                </div>
            </div>

            <!-- Instant Search -->
            <div class="relative w-full sm:w-72">
                <i class="ti ti-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm pointer-events-none"></i>
                <input type="text" 
                       id="searchSingleInput" 
                       placeholder="Cari nama atau NIS siswa..." 
                       class="w-full pl-8 pr-3 py-1.5 text-xs bg-white text-slate-800 font-medium rounded-xl border border-white/20 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-300 transition placeholder:text-slate-400">
            </div>
        </div>

        <form action="{{ route('penilaian.store-nilai') }}" method="POST" id="formSingleNilai" novalidate>
            @csrf
            <input type="hidden" name="rencana_penilaian_id" value="{{ $rencana->id }}">
            
            <div class="overflow-x-auto bg-emerald-600">
                <table class="w-full text-left text-xs border-0 border-collapse" id="singleNilaiTable">
                    <!-- Matching Solid Green Table Header -->
                    <thead class="bg-emerald-600 text-white font-bold uppercase tracking-wider text-[11px] border-0 border-t-0 border-b border-emerald-700/80">
                        <tr class="border-0 border-t-0">
                            <th class="py-2.5 px-3.5 w-14 text-center text-emerald-100 border-0 border-t-0 whitespace-nowrap">No</th>
                            <th class="py-2.5 px-3.5 w-32 text-center text-emerald-100 border-0 border-t-0 whitespace-nowrap">NIS</th>
                            <th class="py-2.5 px-3.5 min-w-[280px] text-emerald-100 border-0 border-t-0">Santri / Siswa</th>
                            <th class="py-2.5 px-3.5 w-16 text-center text-emerald-100 border-0 border-t-0 whitespace-nowrap">L/P</th>
                            <th class="py-2.5 px-3.5 text-center w-36 text-emerald-100 border-0 border-t-0 whitespace-nowrap">Nilai (0 - 100)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700 font-medium bg-white">
                        @forelse ($students as $index => $student)
                            @php
                                $nilai = $grades[$student->id_siswa] ?? '';
                            @endphp
                            <tr class="hover:bg-slate-50/80 transition-colors group single-student-row" data-row="{{ $index }}">
                                <!-- No -->
                                <td class="py-3 px-3.5 text-center text-slate-400 font-bold text-xs whitespace-nowrap">
                                    <span class="w-6 h-6 rounded-md bg-slate-100 group-hover:bg-emerald-50 group-hover:text-emerald-700 group-hover:border group-hover:border-emerald-200 inline-flex items-center justify-center font-bold text-slate-600 transition text-[11px]">
                                        {{ $index + 1 }}
                                    </span>
                                </td>

                                <!-- NIS -->
                                <td class="py-3 px-3.5 text-center font-mono font-bold text-xs text-slate-600 whitespace-nowrap">
                                    {{ $student->nis ?? $student->id_siswa }}
                                </td>

                                <!-- Nama Lengkap -->
                                <td class="py-3 px-3.5 font-bold text-slate-900 group-hover:text-emerald-800 transition text-xs sm:text-sm">
                                    {{ strtoupper($student->nama_lengkap) }}
                                </td>

                                <!-- L/P -->
                                <td class="py-3 px-3.5 text-center whitespace-nowrap">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $student->jenis_kelamin == 'L' ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'bg-rose-50 text-rose-700 border border-rose-200' }}">
                                        {{ $student->jenis_kelamin ?? '-' }}
                                    </span>
                                </td>

                                <!-- Input Nilai -->
                                <td class="py-3 px-3.5 text-center whitespace-nowrap">
                                    <input type="number" 
                                           step="0.01" 
                                           min="0" 
                                           max="100" 
                                           data-row="{{ $index }}"
                                           name="nilai[{{ $student->id_siswa }}]" 
                                           value="{{ $nilai }}" 
                                           placeholder="-"
                                           class="w-24 px-3 py-1.5 text-center font-bold font-mono text-sm rounded-xl border transition single-score-input {{ $nilai !== '' ? ($nilai < 75 ? 'bg-rose-50 border-rose-300 text-rose-700' : 'bg-emerald-50 border-emerald-300 text-emerald-800') : 'bg-slate-50 border-slate-200 text-slate-800 focus:bg-white focus:border-emerald-600 focus:ring-2 focus:ring-emerald-500/20' }}"
                                           {{ ($bobot->status ?? 'draft') == 'terkirim' ? 'disabled' : '' }}>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-12 text-center text-slate-400">
                                    <div class="w-12 h-12 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center mx-auto mb-2 text-slate-400 text-xl">
                                        <i class="ti ti-users-minus"></i>
                                    </div>
                                    <h5 class="text-xs font-bold text-slate-700">Tidak Ada Data Siswa</h5>
                                    <p class="text-[11px] text-slate-400 mt-0.5">Tidak ada santri yang terdaftar di rombel kelas ini.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Card Actions Footer -->
            @if (($bobot->status ?? 'draft') != 'terkirim')
                <div class="p-4 bg-slate-50 border-t border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3 sticky bottom-0 z-10 shadow-lg">
                    <p class="text-xs text-slate-500 flex items-center gap-1.5">
                        <i class="ti ti-info-circle text-emerald-600 text-base"></i>
                        <span>Pastikan rentang nilai berada di antara 0 - 100, lalu tekan Simpan Nilai.</span>
                    </p>
                    <button type="submit" id="btnSaveSingle" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition inline-flex items-center justify-center gap-2 cursor-pointer active:scale-95">
                        <i class="ti ti-device-floppy text-base"></i>
                        <span>Simpan Nilai</span>
                    </button>
                </div>
            @endif
        </form>
    </div>

</div>

@push('myscript')
<script>
    $(function() {
        // Search Filter
        $("#searchSingleInput").on("keyup", function() {
            var val = $(this).val().toLowerCase().trim();
            $(".single-student-row").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(val) > -1);
            });
        });

        // Single Score Input Formatting
        function formatSingleCell($input) {
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

        $('.single-score-input').on('input change', function() {
            formatSingleCell($(this));
        });

        // Keyboard Navigation (Enter, Arrow Down, Arrow Up)
        $('.single-score-input').on('keydown', function(e) {
            const row = parseInt($(this).data('row'));
            if (e.key === 'Enter' || e.key === 'ArrowDown') {
                e.preventDefault();
                const next = $(`input.single-score-input[data-row="${row + 1}"]`);
                if (next.length) next.focus().select();
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                const prev = $(`input.single-score-input[data-row="${row - 1}"]`);
                if (prev.length) prev.focus().select();
            }
        });

        // Form Submit Validation
        $('#formSingleNilai').on('submit', function(e) {
            let hasInvalid = false;
            let firstInvalid = null;

            $('.single-score-input').each(function() {
                const val = $(this).val().trim();
                if (val !== '') {
                    const num = parseFloat(val);
                    if (isNaN(num) || num < 0 || num > 100) {
                        hasInvalid = true;
                        if (!firstInvalid) firstInvalid = $(this);
                        formatSingleCell($(this));
                    }
                }
            });

            if (hasInvalid) {
                e.preventDefault();
                Swal.fire({
                    title: 'Nilai Tidak Valid!',
                    text: 'Terdapat nilai yang berada di luar rentang 0 - 100. Silakan periksa kembali.',
                    icon: 'warning',
                    confirmButtonColor: '#e11d48',
                    confirmButtonText: 'Perbaiki'
                });
                if (firstInvalid) firstInvalid.focus().select();
                return false;
            }

            const btn = $('#btnSaveSingle');
            btn.html('<div class="w-3.5 h-3.5 border-2 border-white border-t-transparent rounded-full animate-spin"></div> <span>Menyimpan Nilai...</span>');
            setTimeout(() => {
                btn.prop('disabled', true);
            }, 50);
        });
    });
</script>
@endpush
@endsection

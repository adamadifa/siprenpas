@extends('layouts.app')
@section('titlepage', 'Rekapitulasi Nilai Siswa')

@section('content')
<div class="space-y-5">

    <!-- ================= 1. PAGE HEADER (NO CARD) WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle with Back Button -->
        <div class="flex items-center gap-3.5">
            <a href="{{ route('rapor.index') }}" 
               class="w-10 h-10 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 flex items-center justify-center transition shadow-2xs active:scale-95 shrink-0"
               title="Kembali ke Daftar Penilaian">
                <i class="ti ti-arrow-left text-lg"></i>
            </a>
            <div>
                <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2">
                    <span>Rekapitulasi Nilai Siswa</span>
                </h1>
                <p class="text-xs text-slate-500 mt-0.5">
                    Mata Pelajaran: <span class="font-bold text-slate-800">{{ $jadwal->mapel->nama_matpel ?? '-' }}</span> • Kelas: <span class="font-bold text-slate-800">{{ $jadwal->kelas->nama_kelas ?? '-' }}</span> ({{ $jadwal->unit->nama_unit ?? '-' }})
                </p>
            </div>
        </div>

        <!-- Right Side: Breadcrumb & Primary Action Buttons -->
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
                <span class="font-bold text-slate-800">Rekap Nilai</span>
            </nav>

            <!-- Action Buttons Toolbar -->
            <div class="flex flex-wrap items-center gap-2">
                <!-- Manage Sumatif Button -->
                <a href="{{ route('penilaian.manage', ['bobot_id' => $bobot->id, 'kategori' => 'SUMATIF']) }}" 
                   class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-sky-600 hover:bg-sky-700 text-white font-bold text-xs rounded-xl shadow-xs transition active:scale-95">
                    <i class="ti ti-notebook text-sm"></i>
                    <span>Kelola Sumatif</span>
                </a>

                <!-- Manage SAS Button -->
                <a href="{{ route('penilaian.manage', ['bobot_id' => $bobot->id, 'kategori' => 'SAS']) }}" 
                   class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-xl shadow-xs transition active:scale-95">
                    <i class="ti ti-file-certificate text-sm"></i>
                    <span>Kelola SAS</span>
                </a>

                <!-- Kirim / Batal Kirim Nilai -->
                @if (($bobot->status ?? 'draft') == 'terkirim')
                    <form action="{{ route('penilaian.batal-kirim') }}" method="POST" id="formBatalKirimPenilaian" class="inline-block">
                        @csrf
                        <input type="hidden" name="bobot_id" value="{{ $bobot->id }}">
                        <button type="button" 
                                class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs rounded-xl shadow-xs transition active:scale-95 cursor-pointer btn-batal-kirim">
                            <i class="ti ti-arrow-back text-sm"></i>
                            <span>Batal Kirim</span>
                        </button>
                    </form>
                @else
                    <form action="{{ route('penilaian.kirim') }}" method="POST" id="formKirimPenilaian" class="inline-block">
                        @csrf
                        <input type="hidden" name="bobot_id" value="{{ $bobot->id }}">
                        <button type="button" 
                                class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition active:scale-95 cursor-pointer btn-kirim-nilai">
                            <i class="ti ti-send text-sm"></i>
                            <span>Kirim ke Rapor</span>
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <!-- ================= 2. SUMMARY & BOBOT CONFIGURATION PANEL ================= -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-4">
        <!-- Metadata Overview Card (7 cols) -->
        <div class="lg:col-span-7 bg-white border border-slate-200/90 rounded-2xl p-4 shadow-xs">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div class="p-3 bg-slate-50 border border-slate-100 rounded-xl flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-800 flex items-center justify-center shrink-0">
                        <i class="ti ti-books text-base"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <span class="text-[9px] uppercase font-bold text-slate-400 block tracking-wider">Mata Pelajaran</span>
                        <span class="text-xs font-bold text-slate-900 truncate block">{{ $jadwal->mapel->nama_matpel ?? '-' }}</span>
                    </div>
                </div>

                <div class="p-3 bg-slate-50 border border-slate-100 rounded-xl flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-800 flex items-center justify-center shrink-0">
                        <i class="ti ti-school text-base"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <span class="text-[9px] uppercase font-bold text-slate-400 block tracking-wider">Kelas & Unit</span>
                        <span class="text-xs font-bold text-slate-900 truncate block">Kelas {{ $jadwal->kelas->nama_kelas ?? '-' }} ({{ $jadwal->unit->nama_unit ?? '-' }})</span>
                    </div>
                </div>

                <div class="p-3 bg-slate-50 border border-slate-100 rounded-xl flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-800 flex items-center justify-center shrink-0">
                        <i class="ti ti-calendar text-base"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <span class="text-[9px] uppercase font-bold text-slate-400 block tracking-wider">TA / Semester</span>
                        <span class="text-xs font-bold text-slate-900 truncate block">{{ $jadwal->tahunAjaran->tahun_ajaran ?? '-' }} (Sem. {{ $jadwal->semester ?? '1' }})</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bobot Configuration Form Card (5 cols) -->
        <div class="lg:col-span-5 bg-white border border-slate-200/90 rounded-2xl p-4 shadow-xs flex flex-col justify-between">
            <div class="flex items-center justify-between pb-2 border-b border-slate-100 mb-2.5">
                <h4 class="text-xs font-bold text-slate-800 flex items-center gap-1.5">
                    <i class="ti ti-adjustments-horizontal text-emerald-600"></i>
                    <span>Konfigurasi Bobot Penilaian</span>
                </h4>
                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full {{ ($bobot->bobot_sumatif + $bobot->bobot_sas) == 100 ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                    Total: {{ $bobot->bobot_sumatif + $bobot->bobot_sas }}%
                </span>
            </div>

            <form action="{{ route('penilaian.store-bobot') }}" method="POST" id="formBobotPenilaian" class="flex items-center gap-2" novalidate>
                @csrf
                <input type="hidden" name="id" value="{{ $bobot->id }}">
                
                <div class="flex-1">
                    <label for="input_bobot_sumatif" class="block text-[10px] font-bold text-slate-500 mb-0.5">Sumatif (%)</label>
                    <input type="number" 
                           id="input_bobot_sumatif"
                           name="bobot_sumatif" 
                           value="{{ $bobot->bobot_sumatif }}" 
                           min="0" 
                           max="100" 
                           class="w-full px-2.5 py-1.5 text-xs font-bold text-slate-800 bg-slate-50 border border-slate-300 rounded-lg focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 font-mono bobot-calc-input"
                           {{ ($bobot->status ?? 'draft') == 'terkirim' ? 'disabled' : '' }} required>
                </div>

                <div class="flex-1">
                    <label for="input_bobot_sas" class="block text-[10px] font-bold text-slate-500 mb-0.5">SAS (%)</label>
                    <input type="number" 
                           id="input_bobot_sas"
                           name="bobot_sas" 
                           value="{{ $bobot->bobot_sas }}" 
                           min="0" 
                           max="100" 
                           class="w-full px-2.5 py-1.5 text-xs font-bold text-slate-800 bg-slate-50 border border-slate-300 rounded-lg focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 font-mono bobot-calc-input"
                           {{ ($bobot->status ?? 'draft') == 'terkirim' ? 'disabled' : '' }} required>
                </div>

                @if (($bobot->status ?? 'draft') != 'terkirim')
                    <div class="self-end">
                        <button type="submit" id="btnSubmitBobot" class="px-3.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-lg shadow-2xs transition active:scale-95 cursor-pointer">
                            Simpan
                        </button>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <!-- ================= 3. REKAP NILAI SISWA TABLE ================= -->
    <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
        
        <!-- Seamless Solid Green Card Header -->
        <div class="px-5 pt-4 pb-2.5 bg-emerald-600 flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-white border-0">
            <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-lg bg-white/20 text-white flex items-center justify-center text-xs font-bold border border-white/20 shadow-2xs">
                    <i class="ti ti-users"></i>
                </div>
                <h3 class="text-sm font-extrabold text-white tracking-tight">Rekapitulasi Nilai Siswa</h3>
                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-white/20 text-white border border-white/30 shadow-2xs backdrop-blur-xs">
                    {{ count($students) }} siswa
                </span>
            </div>
            <div>
                @if (($bobot->status ?? 'draft') == 'terkirim')
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-white text-emerald-800 shadow-2xs">
                        <i class="ti ti-circle-check text-sm text-emerald-600"></i> Nilai Terkirim ke Rapor
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-white/20 text-white border border-white/30 shadow-2xs">
                        <i class="ti ti-pencil text-sm"></i> Status: Draft (Dapat Diedit)
                    </span>
                @endif
            </div>
        </div>

        <!-- Responsive Table Container -->
        <div class="overflow-x-auto bg-emerald-600">
            <table class="w-full min-w-[950px] text-left text-xs border-0 border-collapse">
                <!-- Matching Solid Green Table Header -->
                <thead class="bg-emerald-600 text-white font-bold uppercase tracking-wider text-[11px] border-0 border-t-0 border-b border-emerald-700/80">
                    <tr class="border-0 border-t-0">
                        <th class="py-2.5 px-3 w-12 text-center text-emerald-100 border-0 border-t-0 whitespace-nowrap">No</th>
                        <th class="py-2.5 px-3 w-32 text-center text-emerald-100 border-0 border-t-0 whitespace-nowrap">NIS</th>
                        <th class="py-2.5 px-3 min-w-[240px] text-emerald-100 border-0 border-t-0">Santri / Siswa</th>
                        <th class="py-2.5 px-3 text-center w-28 text-emerald-100 border-0 border-t-0 whitespace-nowrap">Rata Sumatif</th>
                        <th class="py-2.5 px-3 text-center w-28 text-emerald-100 border-0 border-t-0 whitespace-nowrap">Nilai SAS</th>
                        <th class="py-2.5 px-3 text-center w-32 text-emerald-100 border-0 border-t-0 whitespace-nowrap">Nilai Rapor</th>
                        <th class="py-2.5 px-3 min-w-[220px] text-emerald-100 border-0 border-t-0">Capaian Kompetensi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700 font-medium bg-white">
                    @forelse ($students as $student)
                        <tr class="hover:bg-slate-50/80 transition-colors group">
                            <!-- No Index -->
                            <td class="py-2.5 px-3 text-center text-slate-400 font-bold text-xs whitespace-nowrap">
                                <span class="w-6 h-6 rounded-md bg-slate-100 group-hover:bg-emerald-50 group-hover:text-emerald-700 group-hover:border group-hover:border-emerald-200 inline-flex items-center justify-center font-bold text-slate-600 transition text-[11px]">
                                    {{ $loop->iteration }}
                                </span>
                            </td>

                            <!-- NIS / ID -->
                            <td class="py-2.5 px-3 text-center font-mono font-bold text-xs text-slate-600 whitespace-nowrap">
                                {{ $student->nis ?? $student->id_siswa }}
                            </td>

                            <!-- Santri Profile -->
                            <td class="py-2.5 px-3 font-bold text-slate-900 group-hover:text-emerald-800 transition text-xs whitespace-nowrap">
                                {{ strtoupper($student->nama_lengkap) }}
                            </td>

                            <!-- Rata Sumatif -->
                            <td class="py-2.5 px-3 text-center font-mono font-bold text-xs text-sky-700 whitespace-nowrap">
                                <span class="px-2 py-0.5 rounded-md bg-sky-50 border border-sky-200/80 font-bold">
                                    {{ $student->rata_sumatif ?? '0' }}
                                </span>
                            </td>

                            <!-- Nilai SAS -->
                            <td class="py-2.5 px-3 text-center font-mono font-bold text-xs text-indigo-700 whitespace-nowrap">
                                <span class="px-2 py-0.5 rounded-md bg-indigo-50 border border-indigo-200/80 font-bold">
                                    {{ $student->nilai_sas ?? '0' }}
                                </span>
                            </td>

                            <!-- Nilai Akhir Rapor -->
                            <td class="py-2.5 px-3 text-center whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-black font-mono {{ ($student->nilai_rapor ?? 0) >= 75 ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/80 shadow-2xs' : 'bg-rose-50 text-rose-700 border border-rose-200/80' }}">
                                    {{ $student->nilai_rapor ?? '0' }}
                                </span>
                            </td>

                            <!-- Capaian Kompetensi -->
                            <td class="py-2.5 px-3 text-[11px] text-slate-600 leading-relaxed">
                                {{ $student->capaian_kompetensi ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-10 text-center text-slate-400">
                                <div class="w-12 h-12 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center mx-auto mb-2 text-slate-400 text-xl">
                                    <i class="ti ti-users-minus"></i>
                                </div>
                                <h5 class="text-xs font-bold text-slate-700">Belum Ada Data Siswa</h5>
                                <p class="text-[11px] text-slate-400 mt-0.5">
                                    Tidak ditemukan data siswa terdaftar pada rombel kelas ini.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@push('myscript')
<script>
    $(function() {
        // Realtime Bobot Sum Calculation
        function updateBobotSum() {
            const sumatif = parseFloat($('#input_bobot_sumatif').val()) || 0;
            const sas = parseFloat($('#input_bobot_sas').val()) || 0;
            const total = sumatif + sas;
            
            const badge = $('#formBobotPenilaian').closest('.bg-white').find('h4').siblings('span');
            badge.text(`Total: ${total}%`);
            
            if (total === 100) {
                badge.removeClass('bg-rose-100 text-rose-800').addClass('bg-emerald-100 text-emerald-800');
            } else {
                badge.removeClass('bg-emerald-100 text-emerald-800').addClass('bg-rose-100 text-rose-800');
            }
        }

        $('.bobot-calc-input').on('input change', function() {
            updateBobotSum();
        });

        // Submit Bobot Form Validation
        $('#formBobotPenilaian').on('submit', function(e) {
            const sumatif = parseFloat($('#input_bobot_sumatif').val()) || 0;
            const sas = parseFloat($('#input_bobot_sas').val()) || 0;
            const total = sumatif + sas;

            if (total !== 100) {
                e.preventDefault();
                Swal.fire({
                    title: 'Total Bobot Harus 100%',
                    text: `Total bobot saat ini adalah ${total}%. Jumlah Sumatif (%) dan SAS (%) harus bernilai tepat 100%.`,
                    icon: 'warning',
                    confirmButtonColor: '#e11d48',
                    confirmButtonText: 'Perbaiki'
                });
                return false;
            }

            const btn = $('#btnSubmitBobot');
            btn.html('<div class="w-3.5 h-3.5 border-2 border-white border-t-transparent rounded-full animate-spin"></div>');
            setTimeout(() => {
                btn.prop('disabled', true);
            }, 50);
        });

        // Confirmation for Sending Grades
        $('.btn-kirim-nilai').click(function(e) {
            e.preventDefault();
            const form = $(this).closest('form');

            Swal.fire({
                title: 'Kirim Nilai ke Rapor?',
                text: 'Setelah nilai dikirim, data akan terkunci dan dapat diakses oleh wali kelas untuk pencetakan rapor.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#059669',
                cancelButtonColor: '#64748b',
                confirmButtonText: '<i class="ti ti-send mr-1"></i> Ya, Kirim Nilai',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-2xl shadow-2xl p-5',
                    title: 'text-base font-bold text-slate-900',
                    confirmButton: 'px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition cursor-pointer',
                    cancelButton: 'px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Mengirim Nilai...',
                        text: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => { Swal.showLoading(); }
                    });
                    form.submit();
                }
            });
        });

        // Confirmation for Cancelling Sent Grades
        $('.btn-batal-kirim').click(function(e) {
            e.preventDefault();
            const form = $(this).closest('form');

            Swal.fire({
                title: 'Batal Kirim Nilai?',
                text: 'Status nilai akan dikembalikan menjadi draft sehingga Anda dapat mengedit kembali nilai siswa.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: '<i class="ti ti-arrow-back mr-1"></i> Ya, Buka Kunci',
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
                    form.submit();
                }
            });
        });
    });
</script>
@endpush
@endsection

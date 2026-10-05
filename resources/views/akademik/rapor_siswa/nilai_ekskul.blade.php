@extends('layouts.app')
@section('titlepage', 'Input Nilai Ekstrakurikuler')

@section('content')
<div class="space-y-5">

    <!-- ================= 1. PAGE HEADER (NO CARD) WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle with Back Button -->
        <div class="flex items-center gap-3">
            <a href="{{ route('rapor-siswa.index') }}" class="w-10 h-10 rounded-xl bg-white border border-slate-200/90 text-slate-700 hover:text-emerald-700 hover:bg-emerald-50 hover:border-emerald-200 flex items-center justify-center transition shrink-0 shadow-xs" title="Kembali">
                <i class="ti ti-arrow-left text-lg"></i>
            </a>
            <div>
                <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2">
                    <span>Input Nilai - {{ $ekskul->nama_ekstrakurikuler }}</span>
                </h1>
                <p class="text-xs text-slate-500 mt-0.5">
                    Koordinator: <strong class="text-slate-800">{{ $ekskul->guru->nama_guru ?? '-' }}</strong> | Unit: <strong class="text-slate-800">{{ $ekskul->unit->nama_unit ?? '-' }}</strong> | TA: <strong class="text-slate-800">{{ $ekskul->tahunAjaran->tahun_ajaran ?? '-' }}</strong>
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
                <a href="{{ route('rapor-siswa.index') }}" class="hover:text-slate-700 transition flex items-center gap-1">
                    <i class="ti ti-file-analytics text-sm"></i>
                    <span>Rapor Siswa</span>
                </a>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Nilai Ekstrakurikuler</span>
            </nav>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm flex items-center gap-3">
            <i class="ti ti-circle-check text-emerald-600 text-xl shrink-0"></i>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl text-sm flex items-center gap-3">
            <i class="ti ti-alert-circle text-rose-600 text-xl shrink-0"></i>
            <span class="font-medium">{{ session('error') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-start">
        <!-- ================= PANEL TAMBAH ANGGOTA SISWA (KIRI) ================= -->
        <div class="lg:col-span-4 bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
            <div class="px-5 py-3.5 bg-emerald-600 text-white flex items-center gap-2">
                <i class="ti ti-user-plus text-lg"></i>
                <h3 class="font-extrabold text-sm text-white tracking-tight">Tambah Anggota Siswa</h3>
            </div>

            <div class="p-5 space-y-4">
                <!-- Dropdown Pilih Kelas -->
                <form action="{{ route('rapor-siswa.ekskul.nilai', $ekskul->id) }}" method="GET">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Pilih Kelas / Rombel
                    </label>
                    <div class="relative">
                        <i class="ti ti-door-enter absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base pointer-events-none"></i>
                        <select name="kode_kelas" class="w-full pl-10 pr-8 py-2.5 text-sm bg-white border border-slate-300 rounded-lg text-slate-700 font-medium focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition" onchange="this.form.submit()">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach ($classes as $c)
                                <option value="{{ $c->kode_kelas }}" {{ $selectedKodeKelas == $c->kode_kelas ? 'selected' : '' }}>
                                    Kelas {{ $c->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>

                @if($selectedKodeKelas)
                    <form action="{{ route('rapor-siswa.ekskul.add-siswa', $ekskul->id) }}" method="POST" id="formAddSiswaEkskul" class="space-y-3">
                        @csrf
                        <input type="hidden" name="nama_ekskul" value="{{ $ekskul->nama_ekstrakurikuler }}">

                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-700 uppercase tracking-wider">Daftar Siswa Kelas</span>
                            <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                {{ $availableStudents->count() }} Belum Terdaftar
                            </span>
                        </div>

                        @if($availableStudents->count() > 0)
                            <div class="p-2.5 rounded-lg bg-slate-50 border border-slate-200 flex items-center gap-2">
                                <input type="checkbox" id="checkAllSiswa" class="w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500 cursor-pointer accent-emerald-600">
                                <label for="checkAllSiswa" class="text-xs font-bold text-slate-800 cursor-pointer select-none">
                                    Pilih Semua Siswa
                                </label>
                            </div>
                        @endif

                        <div class="max-h-72 overflow-y-auto space-y-2 border border-slate-200 p-2.5 rounded-xl bg-slate-50/50">
                            @forelse ($availableStudents as $student)
                                <div class="p-2.5 rounded-lg border border-slate-200 bg-white hover:bg-emerald-50/70 hover:border-emerald-200 flex items-center gap-2.5 transition cursor-pointer">
                                    <input type="checkbox" name="student_ids[]" value="{{ $student->id_siswa }}" id="checkSiswa{{ $student->id_siswa }}" class="student-checkbox w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500 cursor-pointer accent-emerald-600">
                                    <label for="checkSiswa{{ $student->id_siswa }}" class="text-xs font-semibold text-slate-800 cursor-pointer select-none flex-1">
                                        {{ $student->nama_lengkap }}
                                    </label>
                                </div>
                            @empty
                                <div class="text-center py-6">
                                    <i class="ti ti-user-check text-emerald-600 text-2xl mb-1 block"></i>
                                    <p class="text-xs font-medium text-slate-500">Semua siswa di kelas ini sudah terdaftar ke ekskul.</p>
                                </div>
                            @endforelse
                        </div>

                        @if($availableStudents->count() > 0)
                            <button type="submit" id="btnSubmitAddSiswa" class="w-full py-2.5 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg text-xs shadow-xs transition flex items-center justify-center gap-2 cursor-pointer active:scale-95">
                                <i class="ti ti-user-plus text-base"></i>
                                <span>Tambahkan Siswa Terpilih</span>
                            </button>
                        @endif
                    </form>
                @else
                    <div class="p-6 bg-slate-50 rounded-xl border border-slate-200 text-center">
                        <i class="ti ti-hand-click text-2xl text-slate-400 mb-1 block"></i>
                        <p class="text-xs font-medium text-slate-500">Pilih rombel / kelas di atas untuk memuat data siswa.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- ================= PANEL DAFTAR SISWA & PENILAIAN (KANAN) ================= -->
        <div class="lg:col-span-8 bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
            <!-- Solid Green Header -->
            <div class="px-5 pt-4 pb-3 bg-emerald-600 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-white">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-lg bg-white/20 text-white flex items-center justify-center text-xs font-bold border border-white/20 shadow-2xs">
                        <i class="ti ti-users"></i>
                    </div>
                    <h3 class="text-sm font-extrabold text-white tracking-tight">Anggota &amp; Penilaian Ekstrakurikuler</h3>
                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-white/20 text-white border border-white/30 shadow-2xs">
                        {{ $enrolledStudents->count() }} Siswa
                    </span>
                </div>

                <!-- Search Input -->
                <div class="relative w-full sm:w-56">
                    <i class="ti ti-search absolute left-3 top-1/2 -translate-y-1/2 text-emerald-200 text-sm pointer-events-none"></i>
                    <input type="text" id="searchEnrolledInput" placeholder="Cari siswa..." class="w-full pl-8 pr-3 py-1.5 text-xs bg-white/15 hover:bg-white/20 focus:bg-white text-white focus:text-slate-900 placeholder-emerald-100 focus:placeholder-slate-400 border border-white/20 rounded-lg outline-none transition">
                </div>
            </div>

            <!-- Enrolled Students Table Form -->
            <form action="{{ route('rapor-siswa.ekskul.save-nilai', $ekskul->id) }}" method="POST" id="formSaveNilaiEkskul">
                @csrf
                <div class="overflow-x-auto bg-emerald-600">
                    <table class="w-full text-left text-xs border-0 border-collapse" id="enrolledTable">
                        <thead class="bg-emerald-600 text-white font-bold uppercase tracking-wider text-[11px] border-0 border-b border-emerald-700/80">
                            <tr>
                                <th class="py-2 px-3 text-center w-12 text-white">NO</th>
                                <th class="py-2 px-3 text-white">NAMA SISWA</th>
                                <th class="py-2 px-3 text-white w-24">KELAS</th>
                                <th class="py-2 px-3 text-white w-40">PREDIKAT (A-D)</th>
                                <th class="py-2 px-3 text-white">KETERANGAN / CAPAIAN</th>
                                <th class="py-2 px-3 text-end text-white w-12">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white text-slate-700 font-medium">
                            @forelse ($enrolledStudents as $index => $enrolled)
                                <tr class="odd:bg-white even:bg-slate-50/40 hover:bg-emerald-50/50 transition-colors enrolled-row">
                                    <td class="py-2 px-3 text-center text-slate-400 font-bold text-xs">{{ $index + 1 }}</td>
                                    <td class="py-2 px-3">
                                        <span class="font-bold text-slate-900 enrolled-name text-xs sm:text-sm">{{ $enrolled->siswa->nama_lengkap ?? '-' }}</span>
                                    </td>
                                    <td class="py-2 px-3">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-bold bg-sky-50 text-sky-700 border border-sky-200/70">
                                            {{ $enrolled->nama_kelas }}
                                        </span>
                                    </td>
                                    <td class="py-2 px-3">
                                        <select name="nilai[{{ $enrolled->id_siswa }}]" class="select-grade w-full px-2 py-1 text-xs bg-white border border-slate-300 rounded-md text-slate-800 font-bold focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none" data-student-id="{{ $enrolled->id_siswa }}">
                                            <option value="A" {{ $enrolled->nilai == 'A' ? 'selected' : '' }}>A (Sangat Baik)</option>
                                            <option value="B" {{ $enrolled->nilai == 'B' ? 'selected' : '' }}>B (Baik)</option>
                                            <option value="C" {{ $enrolled->nilai == 'C' ? 'selected' : '' }}>C (Cukup Baik)</option>
                                            <option value="D" {{ $enrolled->nilai == 'D' ? 'selected' : '' }}>D (Kurang Baik)</option>
                                        </select>
                                    </td>
                                    <td class="py-2 px-3">
                                        <input type="text" name="keterangan[{{ $enrolled->id_siswa }}]" id="remark{{ $enrolled->id_siswa }}" value="{{ $enrolled->keterangan ?? 'Sangat Baik dalam mengikuti kegiatan ' . $ekskul->nama_ekstrakurikuler }}" class="w-full px-2.5 py-1 text-xs bg-white border border-slate-300 rounded-md text-slate-700 font-medium focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none">
                                    </td>
                                    <td class="py-2 px-3 text-end">
                                        <button type="button" class="btn-remove-member w-6.5 h-6.5 rounded-md bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200/80 flex items-center justify-center text-xs transition cursor-pointer" data-nilai-id="{{ $enrolled->id }}" data-student-name="{{ $enrolled->siswa->nama_lengkap ?? 'Siswa' }}" title="Keluarkan Siswa">
                                            <i class="ti ti-trash text-xs"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-10">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 mb-1.5">
                                                <i class="ti ti-users-minus text-xl"></i>
                                            </div>
                                            <p class="text-xs font-bold text-slate-700">Belum ada siswa terdaftar</p>
                                            <p class="text-[11px] text-slate-400 mt-0.5">Pilih kelas di panel sebelah kiri untuk menambahkan siswa ke kegiatan ekstrakurikuler ini.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($enrolledStudents->count() > 0)
                    <div class="p-4 bg-slate-50 border-t border-slate-200 flex items-center justify-between">
                        <span class="text-xs font-semibold text-slate-500">Total: <strong>{{ $enrolledStudents->count() }}</strong> Siswa</span>
                        <button type="submit" id="btnSaveNilai" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg text-xs shadow-xs transition flex items-center gap-1.5 cursor-pointer active:scale-95">
                            <i class="ti ti-device-floppy text-base"></i>
                            <span>Simpan Semua Nilai</span>
                        </button>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>

<!-- Form hidden untuk delete siswa -->
<form id="deleteStudentForm" action="" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

@push('myscript')
<script>
    $(function() {
        var ekskulName = "{{ $ekskul->nama_ekstrakurikuler }}";

        // "Pilih Semua" checkbox toggle
        $('#checkAllSiswa').on('change', function() {
            var isChecked = $(this).is(':checked');
            $('.student-checkbox').prop('checked', isChecked);
        });

        $('.student-checkbox').on('change', function() {
            var total = $('.student-checkbox').length;
            var checked = $('.student-checkbox:checked').length;
            $('#checkAllSiswa').prop('checked', total > 0 && total === checked);
        });

        // Search enrolled students
        $('#searchEnrolledInput').on('keyup', function() {
            var val = $(this).val().toLowerCase();
            $('#enrolledTable tbody tr.enrolled-row').filter(function() {
                var name = $(this).find('.enrolled-name').text().toLowerCase();
                $(this).toggle(name.indexOf(val) > -1);
            });
        });

        // Auto-change description based on grade selection
        $(document).on('change', '.select-grade', function() {
            var grade = $(this).val();
            var studentId = $(this).data('student-id');
            var desc = '';
            if (grade === 'A') {
                desc = 'Sangat Baik dalam mengikuti kegiatan ' + ekskulName;
            } else if (grade === 'B') {
                desc = 'Baik dalam mengikuti kegiatan ' + ekskulName;
            } else if (grade === 'C') {
                desc = 'Cukup Baik dalam mengikuti kegiatan ' + ekskulName;
            } else if (grade === 'D') {
                desc = 'Kurang Baik dalam mengikuti kegiatan ' + ekskulName;
            }
            $('#remark' + studentId).val(desc);
        });

        // Delete confirmation with SweetAlert2
        $(document).on('click', '.btn-remove-member', function(e) {
            e.preventDefault();
            var id = $(this).data('nilai-id');
            var studentName = $(this).data('student-name');
            Swal.fire({
                title: 'Konfirmasi Pengeluaran',
                text: 'Apakah Anda yakin ingin mengeluarkan ' + studentName + ' dari kegiatan ekstrakurikuler ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Keluarkan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    var deleteForm = $('#deleteStudentForm');
                    deleteForm.attr('action', '/rapor-siswa/ekstrakurikuler/nilai/' + id);
                    deleteForm.submit();
                }
            });
        });

        $('#formSaveNilaiEkskul').on('submit', function() {
            $('#btnSaveNilai').prop('disabled', true).html('<i class="ti ti-loader animate-spin text-base"></i><span>Menyimpan...</span>');
        });

        $('#formAddSiswaEkskul').on('submit', function(e) {
            var checkedCount = $('.student-checkbox:checked').length;
            if (checkedCount === 0) {
                e.preventDefault();
                Swal.fire({
                    icon: 'info',
                    title: 'Peringatan',
                    text: 'Silahkan centang minimal satu siswa untuk ditambahkan.',
                    confirmButtonColor: '#059669'
                });
                return false;
            }
            $('#btnSubmitAddSiswa').prop('disabled', true).html('<i class="ti ti-loader animate-spin text-base"></i><span>Menambahkan...</span>');
        });
    });
</script>
@endpush
@endsection

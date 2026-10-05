@extends('layouts.app')
@section('titlepage', 'Input Presensi Pelajaran')

@section('content')
<div class="space-y-5">

    <!-- ================= 1. PAGE HEADER (NO CARD) WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle with Back Button -->
        <div class="flex items-center gap-3.5">
            <a href="{{ route('presensi-mapel.index') }}" 
               class="w-10 h-10 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 flex items-center justify-center transition shadow-2xs active:scale-95 shrink-0"
               title="Kembali ke Daftar Presensi">
                <i class="ti ti-arrow-left text-lg"></i>
            </a>
            <div>
                <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2">
                    <span>Input Presensi Pembelajaran</span>
                </h1>
                <p class="text-xs text-slate-500 mt-0.5">
                    Mata Pelajaran: <span class="font-bold text-slate-800">{{ $jadwal->mapel->nama_matpel ?? '-' }}</span> • Kelas: <span class="font-bold text-slate-800">{{ $jadwal->kelas->nama_kelas ?? '-' }}</span> ({{ $jadwal->unit->nama_unit ?? '-' }})
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
                <a href="{{ route('presensi-mapel.index') }}" class="hover:text-slate-700 transition flex items-center gap-1">
                    <i class="ti ti-school text-sm"></i>
                    <span>Presensi Mapel</span>
                </a>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Input</span>
            </nav>
        </div>
    </div>

    <!-- ================= 2. FORM CONTAINER ================= -->
    <form action="{{ route('presensi-mapel.store') }}" method="POST" id="formPresensiMapel">
        @csrf
        <input type="hidden" name="jadwal_pelajaran_id" value="{{ $jadwal->id }}">
        <input type="hidden" name="tanggal" value="{{ $tanggal }}">

        <div class="space-y-5">
            <!-- Information & Lesson Summary Card -->
            <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
                    <!-- Left: Meeting Metadata (7 cols) -->
                    <div class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-3.5 pr-0 lg:pr-3 lg:border-r lg:border-slate-100">
                        <!-- Guru Pengampu -->
                        <div class="p-3 bg-slate-50 border border-slate-100 rounded-xl flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-emerald-100 text-emerald-800 flex items-center justify-center text-base shrink-0">
                                <i class="ti ti-user-check"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <span class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider">Guru Pengampu</span>
                                <span class="text-xs font-bold text-slate-900 truncate block">
                                    {{ $jadwal->guru->karyawan->nama_lengkap ?? ($jadwal->guru->nama_guru ?? '-') }}
                                </span>
                            </div>
                        </div>

                        <!-- Hari & Tanggal -->
                        <div class="p-3 bg-slate-50 border border-slate-100 rounded-xl flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-blue-100 text-blue-800 flex items-center justify-center text-base shrink-0">
                                <i class="ti ti-calendar"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <span class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider">Hari & Tanggal</span>
                                <span class="text-xs font-bold text-slate-900 truncate block">
                                    {{ $jadwal->hari }}, {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d M Y') }}
                                </span>
                            </div>
                        </div>

                        <!-- Waktu Pertemuan -->
                        <div class="p-3 bg-slate-50 border border-slate-100 rounded-xl flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-amber-100 text-amber-800 flex items-center justify-center text-base shrink-0">
                                <i class="ti ti-clock"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <span class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider">Jam Pertemuan</span>
                                <span class="text-xs font-bold text-slate-900 font-mono block">
                                    Jam ke-{{ $jadwal->jam_ke }} ({{ substr($jadwal->jam_mulai, 0, 5) }} - {{ substr($jadwal->jam_selesai, 0, 5) }})
                                </span>
                            </div>
                        </div>

                        <!-- Kelas & Unit -->
                        <div class="p-3 bg-slate-50 border border-slate-100 rounded-xl flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-indigo-100 text-indigo-800 flex items-center justify-center text-base shrink-0">
                                <i class="ti ti-school"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <span class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider">Kelas & Unit</span>
                                <span class="text-xs font-bold text-slate-900 truncate block">
                                    Kelas {{ $jadwal->kelas->nama_kelas ?? '-' }} • {{ $jadwal->unit->nama_unit ?? '-' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Materi / Pembahasan (5 cols) -->
                    <div class="lg:col-span-5 flex flex-col justify-between">
                        <div class="space-y-1.5">
                            <label for="materi" class="block text-xs font-bold text-slate-800 flex items-center justify-between">
                                <span class="flex items-center gap-1.5">
                                    <i class="ti ti-notes text-emerald-600"></i>
                                    <span>Materi / Pokok Pembahasan <span class="text-rose-500 font-bold">*</span></span>
                                </span>
                                <span class="text-[10px] text-slate-400 font-medium">Jurnal Guru</span>
                            </label>
                            <textarea name="materi" 
                                      id="materi" 
                                      rows="3" 
                                      placeholder="Tuliskan pokok materi, bab pelajaran, atau kegiatan belajar mengajar hari ini..."
                                      class="w-full p-3 text-xs sm:text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition resize-none" 
                                      required>{{ old('materi') }}</textarea>
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1 flex items-center gap-1">
                            <i class="ti ti-info-circle text-slate-400"></i>
                            <span>Catatan jurnal ini akan tersimpan ke dalam rekapitulasi presensi mapel.</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Student Attendance Table Card -->
            <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
                <!-- Solid Green Header with Bulk Action -->
                <div class="px-5 py-3 bg-emerald-600 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-white">
                    <div class="flex items-center gap-2.5">
                        <div class="w-7 h-7 rounded-lg bg-white/20 text-white flex items-center justify-center text-xs font-bold border border-white/20 shadow-2xs">
                            <i class="ti ti-users"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-extrabold text-white tracking-tight">Daftar Kehadiran Santri / Siswa</h3>
                            <span class="text-[11px] text-emerald-100 font-medium">Total: {{ count($students) }} Siswa Terdaftar</span>
                        </div>
                    </div>
                    <div>
                        <button type="button" 
                                id="btnHadirAll" 
                                class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-white hover:bg-emerald-50 text-emerald-800 font-bold text-xs rounded-lg shadow-2xs transition-all active:scale-95 cursor-pointer">
                            <i class="ti ti-checks text-base text-emerald-600"></i>
                            <span>Set Semua Hadir (H)</span>
                        </button>
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto bg-emerald-600">
                    <table class="w-full min-w-[850px] text-left text-xs sm:text-sm border-0 border-collapse">
                        <thead class="bg-emerald-600 text-white font-bold uppercase tracking-wider text-[11px] border-0 border-b border-emerald-700/80">
                            <tr>
                                <th class="py-2.5 px-3.5 w-14 text-center text-emerald-100 whitespace-nowrap">No</th>
                                <th class="py-2.5 px-3.5 min-w-[280px] text-emerald-100">Santri / Siswa</th>
                                <th class="py-2.5 px-3.5 text-center w-80 text-emerald-100 whitespace-nowrap">Status Kehadiran</th>
                                <th class="py-2.5 px-3.5 min-w-[200px] text-emerald-100">Keterangan / Catatan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700 font-medium bg-white">
                            @forelse ($students as $s)
                                <tr class="hover:bg-slate-50/80 transition-colors group">
                                    <!-- No -->
                                    <td class="py-3 px-3.5 text-center text-slate-400 font-bold text-xs whitespace-nowrap">
                                        <span class="w-6 h-6 rounded-md bg-slate-100 group-hover:bg-emerald-50 group-hover:text-emerald-700 group-hover:border group-hover:border-emerald-200 inline-flex items-center justify-center font-bold text-slate-600 transition text-[11px]">
                                            {{ $loop->iteration }}
                                        </span>
                                    </td>

                                    <!-- Siswa Profile -->
                                    <td class="py-3 px-3.5">
                                        <div class="flex items-center gap-3">
                                            @if(!empty($s->foto) && file_exists(public_path('storage/photos/pendaftaran/' . $s->foto)))
                                                <div class="w-9 h-11 rounded-lg overflow-hidden border border-slate-200 shadow-2xs shrink-0 bg-slate-100">
                                                    <img src="{{ asset('storage/photos/pendaftaran/' . $s->foto) }}" alt="{{ $s->nama_lengkap }}" class="w-full h-full object-cover">
                                                </div>
                                            @else
                                                <div class="w-9 h-9 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center font-bold text-xs shrink-0 border border-slate-200 shadow-2xs">
                                                    {{ strtoupper(substr($s->nama_lengkap ?? 'S', 0, 2)) }}
                                                </div>
                                            @endif
                                            <div>
                                                <div class="font-bold text-slate-900 group-hover:text-emerald-800 transition text-xs sm:text-sm">
                                                    {{ strtoupper($s->nama_lengkap) }}
                                                </div>
                                                <div class="flex items-center gap-2 mt-0.5 text-[11px] text-slate-400">
                                                    <span class="font-mono">ID: {{ $s->id_siswa }}</span>
                                                    @if(!empty($s->nisn))
                                                        <span>•</span>
                                                        <span class="font-mono">NISN: {{ $s->nisn }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Status Kehadiran Radio Pills -->
                                    <td class="py-3 px-3.5 text-center whitespace-nowrap">
                                        <div class="inline-flex p-1 bg-slate-100 rounded-xl border border-slate-200/80 gap-1">
                                            <!-- Hadir (H) -->
                                            <label class="cursor-pointer">
                                                <input type="radio" 
                                                       name="status[{{ $s->id_siswa }}]" 
                                                       value="h" 
                                                       class="peer sr-only status-radio status-h" 
                                                       checked>
                                                <span class="px-3.5 py-1.5 rounded-lg text-xs font-bold text-slate-600 transition inline-flex items-center justify-center peer-checked:bg-emerald-600 peer-checked:text-white peer-checked:shadow-xs hover:text-emerald-700">
                                                    Hadir
                                                </span>
                                            </label>

                                            <!-- Izin (I) -->
                                            <label class="cursor-pointer">
                                                <input type="radio" 
                                                       name="status[{{ $s->id_siswa }}]" 
                                                       value="i" 
                                                       class="peer sr-only status-radio status-i">
                                                <span class="px-3.5 py-1.5 rounded-lg text-xs font-bold text-slate-600 transition inline-flex items-center justify-center peer-checked:bg-blue-600 peer-checked:text-white peer-checked:shadow-xs hover:text-blue-700">
                                                    Izin
                                                </span>
                                            </label>

                                            <!-- Sakit (S) -->
                                            <label class="cursor-pointer">
                                                <input type="radio" 
                                                       name="status[{{ $s->id_siswa }}]" 
                                                       value="s" 
                                                       class="peer sr-only status-radio status-s">
                                                <span class="px-3.5 py-1.5 rounded-lg text-xs font-bold text-slate-600 transition inline-flex items-center justify-center peer-checked:bg-amber-500 peer-checked:text-white peer-checked:shadow-xs hover:text-amber-700">
                                                    Sakit
                                                </span>
                                            </label>

                                            <!-- Alpa (A) -->
                                            <label class="cursor-pointer">
                                                <input type="radio" 
                                                       name="status[{{ $s->id_siswa }}]" 
                                                       value="a" 
                                                       class="peer sr-only status-radio status-a">
                                                <span class="px-3.5 py-1.5 rounded-lg text-xs font-bold text-slate-600 transition inline-flex items-center justify-center peer-checked:bg-rose-600 peer-checked:text-white peer-checked:shadow-xs hover:text-rose-700">
                                                    Alpa
                                                </span>
                                            </label>
                                        </div>
                                    </td>

                                    <!-- Keterangan -->
                                    <td class="py-3 px-3.5">
                                        <input type="text" 
                                               name="keterangan[{{ $s->id_siswa }}]" 
                                               placeholder="Catatan tambahan (opsional)..." 
                                               class="w-full px-3 py-1.5 text-xs text-slate-800 bg-slate-50/50 hover:bg-white focus:bg-white border border-slate-200 focus:border-emerald-600 rounded-lg shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 transition">
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-10 text-center text-slate-400">
                                        <div class="w-12 h-12 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center mx-auto mb-2 text-slate-400 text-xl">
                                            <i class="ti ti-users-minus"></i>
                                        </div>
                                        <h5 class="text-xs font-bold text-slate-700">Tidak Ada Siswa di Kelas Ini</h5>
                                        <p class="text-[11px] text-slate-400 mt-0.5">Belum ada data anggota siswa yang dimasukkan ke rombel kelas ini.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Card Footer Actions -->
                <div class="p-4 bg-slate-50 border-t border-slate-200 flex flex-col-reverse sm:flex-row sm:items-center justify-between gap-3">
                    <a href="{{ route('presensi-mapel.index') }}" class="px-5 py-2.5 bg-white hover:bg-slate-100 text-slate-700 font-bold text-xs rounded-xl border border-slate-300 transition text-center shadow-2xs cursor-pointer active:scale-95">
                        Batal & Kembali
                    </a>
                    <button type="submit" id="btnSubmitPresensi" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition inline-flex items-center justify-center gap-2 cursor-pointer active:scale-95">
                        <i class="ti ti-device-floppy text-base"></i>
                        <span>Simpan Presensi Pembelajaran</span>
                    </button>
                </div>
            </div>
        </div>
    </form>

</div>

@push('myscript')
<script>
    $(function() {
        // Quick "Hadir Semua" bulk button
        $('#btnHadirAll').click(function(e) {
            e.preventDefault();
            $('.status-h').prop('checked', true).trigger('change');
            
            // Visual pulse feedback
            $(this).addClass('scale-95');
            setTimeout(() => {
                $(this).removeClass('scale-95');
            }, 150);
        });

        // Form Submit Loading Feedback
        $('#formPresensiMapel').submit(function(e) {
            const materi = $('#materi').val().trim();
            if (!materi) {
                e.preventDefault();
                Swal.fire({
                    title: 'Materi Wajib Diisi',
                    text: 'Silakan tuliskan pokok pembahasan atau materi pertemuan hari ini.',
                    icon: 'warning',
                    confirmButtonColor: '#059669',
                    confirmButtonText: 'Mengerti'
                });
                $('#materi').focus();
                return false;
            }

            const btn = $('#btnSubmitPresensi');
            btn.html('<div class="w-3.5 h-3.5 border-2 border-white border-t-transparent rounded-full animate-spin"></div> <span>Menyimpan Presensi...</span>');
            setTimeout(() => {
                btn.prop('disabled', true);
            }, 50);
        });
    });
</script>
@endpush
@endsection

@extends('layouts.app')
@section('titlepage', 'Jadwal Pelajaran')

@section('content')
<div class="space-y-5">

    <!-- ================= 1. PAGE HEADER (NO CARD) WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <i class="ti ti-calendar-time text-emerald-600 text-2xl"></i>
                <span>Jadwal Pelajaran</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Manajemen alokasi waktu mata pelajaran, ruang kelas, guru pengampu, dan presensi pembelajaran
            </p>
        </div>

        <!-- Right Side: Breadcrumb & Actions -->
        <div class="flex flex-col md:items-end gap-2.5">
            <!-- Breadcrumb Navigation -->
            <nav class="flex items-center text-xs text-slate-400 font-medium">
                <a href="{{ route('dashboard.index') }}" class="hover:text-slate-700 transition flex items-center gap-1">
                    <i class="ti ti-home text-sm"></i>
                    <span>Dashboard</span>
                </a>
                <span class="mx-2 text-slate-300">/</span>
                <span class="text-slate-500 flex items-center gap-1">
                    <i class="ti ti-school text-sm"></i>
                    <span>Akademik</span>
                </span>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Jadwal Pelajaran</span>
            </nav>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('presensi-mapel.create') }}" id="btnInputPresensiQuick" class="inline-flex items-center gap-2 px-3.5 py-2.5 bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-emerald-700 font-bold rounded-lg text-xs shadow-xs transition-all duration-200 active:scale-95 cursor-pointer">
                    <i class="ti ti-checklist text-emerald-600 text-base"></i>
                    <span>Input Presensi</span>
                </a>
                @can('jadwalpelajaran.create')
                    <button type="button" id="btnCreateJadwal" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg text-xs shadow-xs transition-all duration-200 active:scale-95 cursor-pointer">
                        <i class="ti ti-plus text-base"></i>
                        <span>Tambah Jadwal</span>
                    </button>
                @endcan
            </div>
        </div>
    </div>

    <!-- ================= 2. FILTER & SEARCH TOOLBAR ================= -->
    <form action="{{ route('jadwal-pelajaran.index') }}" method="GET" class="w-full">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-2.5 sm:gap-3 w-full">
            <!-- Tahun Ajaran Filter -->
            <div class="relative">
                <i class="ti ti-calendar-event absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base pointer-events-none"></i>
                <select name="kode_ta" class="w-full pl-9 pr-8 py-2.5 text-sm bg-white border border-slate-300/90 rounded-lg text-slate-700 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                    @foreach ($semuaTa as $ta)
                        <option value="{{ $ta->kode_ta }}" {{ $selectedKodeTa == $ta->kode_ta ? 'selected' : '' }}>
                            {{ $ta->tahun_ajaran }} {{ $ta->status == 1 ? '(Aktif)' : '' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Unit Filter (If Super Admin) -->
            @if (auth()->user()->kode_unit == 'U06' && !auth()->user()->hasRole('guru'))
                <div class="relative">
                    <i class="ti ti-building absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base pointer-events-none"></i>
                    <select name="kode_unit" id="filter_kode_unit" class="w-full pl-9 pr-8 py-2.5 text-sm bg-white border border-slate-300/90 rounded-lg text-slate-700 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                        <option value="">Semua Unit</option>
                        @foreach ($units as $unit)
                            <option value="{{ $unit->kode_unit }}" {{ request('kode_unit') == $unit->kode_unit ? 'selected' : '' }}>
                                {{ $unit->nama_unit }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            <!-- Kelas Filter -->
            <div class="relative">
                <i class="ti ti-door-enter absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base pointer-events-none"></i>
                <select name="kode_kelas" id="filter_kode_kelas" class="w-full pl-9 pr-8 py-2.5 text-sm bg-white border border-slate-300/90 rounded-lg text-slate-700 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                    <option value="">Semua Kelas</option>
                    @foreach ($kelas as $k)
                        <option value="{{ $k->kode_kelas }}" {{ request('kode_kelas') == $k->kode_kelas ? 'selected' : '' }}>
                            {{ $k->nama_kelas }} ({{ $k->unit->nama_unit ?? '-' }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Guru Filter (If not guru role) -->
            @if (!auth()->user()->hasRole('guru'))
                <div class="relative">
                    <i class="ti ti-user-check absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base pointer-events-none"></i>
                    <select name="guru_id" id="filter_guru_id" class="w-full pl-9 pr-8 py-2.5 text-sm bg-white border border-slate-300/90 rounded-lg text-slate-700 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                        <option value="">Semua Guru</option>
                        @foreach ($gurus as $guru)
                            <option value="{{ $guru->id }}" {{ request('guru_id') == $guru->id ? 'selected' : '' }}>
                                {{ $guru->nama_guru }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            <!-- Hari Filter -->
            <div class="relative">
                <i class="ti ti-calendar absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base pointer-events-none"></i>
                <select name="hari" id="filter_hari" class="w-full pl-9 pr-8 py-2.5 text-sm bg-white border border-slate-300/90 rounded-lg text-slate-700 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                    <option value="">Semua Hari</option>
                    @foreach ($days as $day)
                        <option value="{{ $day }}" {{ request('hari') == $day ? 'selected' : '' }}>
                            {{ $day }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Semester Filter & Action Buttons -->
            <div class="flex items-center gap-2">
                <div class="relative flex-1">
                    <i class="ti ti-clock absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base pointer-events-none"></i>
                    <select name="semester" id="filter_semester" class="w-full pl-9 pr-7 py-2.5 text-sm bg-white border border-slate-300/90 rounded-lg text-slate-700 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                        <option value="">Semester</option>
                        @foreach ($semesters as $sem)
                            <option value="{{ $sem }}" {{ $selectedSemester == $sem ? 'selected' : '' }}>
                                {{ $sem == 1 ? 'Ganjil' : 'Genap' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-lg shadow-xs transition inline-flex items-center justify-center gap-1.5 cursor-pointer active:scale-95 whitespace-nowrap">
                    <i class="ti ti-search text-base"></i>
                    <span class="hidden sm:inline">Cari</span>
                </button>

                @if(request('kode_unit') || request('kode_kelas') || request('guru_id') || request('hari') || request('semester') || (request('kode_ta') && request('kode_ta') != ($activeTa->kode_ta ?? '')))
                    <a href="{{ route('jadwal-pelajaran.index') }}" class="py-2.5 px-3 bg-white hover:bg-slate-100 text-slate-600 border border-slate-300/90 rounded-lg font-semibold text-sm transition inline-flex items-center justify-center shrink-0 shadow-xs" title="Reset Filter">
                        <i class="ti ti-refresh text-base"></i>
                    </a>
                @endif
            </div>
        </div>
    </form>

    <!-- ================= 3. DATA TABLE (SEAMLESS SOLID GREEN HEADER) ================= -->
    <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
        
        <!-- Seamless Solid Green Card Header -->
        <div class="px-5 pt-4 pb-2.5 bg-emerald-600 flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-white border-0">
            <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-lg bg-white/20 text-white flex items-center justify-center text-xs font-bold border border-white/20 shadow-2xs">
                    <i class="ti ti-calendar-time"></i>
                </div>
                <h3 class="text-sm font-extrabold text-white tracking-tight">Daftar Jadwal Pelajaran</h3>
                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-white/20 text-white border border-white/30 shadow-2xs backdrop-blur-xs">
                    {{ count($jadwal) }} data
                </span>
            </div>
            <div class="text-xs text-emerald-100 font-medium">
                Tahun Ajaran: <span class="font-bold text-white">{{ $activeTa->tahun_ajaran ?? '-' }}</span> | Semester: <span class="font-bold text-white">{{ $selectedSemester == 1 ? 'Ganjil' : 'Genap' }}</span>
            </div>
        </div>

        <!-- Responsive Table Container -->
        <div class="overflow-x-auto bg-emerald-600">
            <table class="w-full min-w-[1050px] text-left text-xs sm:text-sm border-0 border-collapse">
                <!-- Matching Solid Green Table Header -->
                <thead class="bg-emerald-600 text-white font-bold uppercase tracking-wider text-[11px] border-0 border-t-0 border-b border-emerald-700/80">
                    <tr class="border-0 border-t-0">
                        <th class="py-2.5 px-3.5 w-14 text-center text-emerald-100 border-0 border-t-0 whitespace-nowrap">No</th>
                        <th class="py-2.5 px-3.5 w-52 text-emerald-100 border-0 border-t-0 whitespace-nowrap">Hari & Waktu</th>
                        <th class="py-2.5 px-3.5 min-w-[240px] text-emerald-100 border-0 border-t-0">Mata Pelajaran</th>
                        <th class="py-2.5 px-3.5 text-center w-36 text-emerald-100 border-0 border-t-0 whitespace-nowrap">Kelas & Unit</th>
                        <th class="py-2.5 px-3.5 min-w-[220px] text-emerald-100 border-0 border-t-0">Guru Pengampu</th>
                        <th class="py-2.5 px-3.5 text-center w-36 text-emerald-100 border-0 border-t-0 whitespace-nowrap">Semester & TA</th>
                        <th class="py-2.5 px-3.5 text-center w-48 text-emerald-100 border-0 border-t-0 whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700 font-medium bg-white">
                    @forelse ($jadwal as $item)
                        <tr class="hover:bg-slate-50/80 transition-colors group">
                            <!-- No Index -->
                            <td class="py-2.5 px-3.5 text-center text-slate-400 font-bold text-xs whitespace-nowrap">
                                <span class="w-6 h-6 rounded-md bg-slate-100 group-hover:bg-emerald-50 group-hover:text-emerald-700 group-hover:border group-hover:border-emerald-200 inline-flex items-center justify-center font-bold text-slate-600 transition text-[11px]">
                                    {{ $loop->iteration }}
                                </span>
                            </td>

                            <!-- Hari & Waktu -->
                            <td class="py-2.5 px-3.5 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-200/80 flex items-center justify-center text-xs shrink-0 group-hover:bg-emerald-600 group-hover:text-white transition shadow-2xs">
                                        <i class="ti ti-calendar-time text-sm"></i>
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-1.5">
                                            <span class="font-black text-slate-900 text-xs">{{ $item->hari }}</span>
                                            <span class="px-1.5 py-0.2 rounded text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                                Jam ke-{{ $item->jam_ke }}
                                            </span>
                                        </div>
                                        <span class="text-[11px] font-mono font-bold text-emerald-700 block mt-0.5">
                                            {{ date('H:i', strtotime($item->jam_mulai)) }} - {{ date('H:i', strtotime($item->jam_selesai)) }}
                                        </span>
                                    </div>
                                </div>
                            </td>

                            <!-- Mata Pelajaran -->
                            <td class="py-2.5 px-3.5">
                                <div class="flex items-center gap-2">
                                    <div class="w-6.5 h-6.5 rounded-md bg-slate-100 text-slate-600 flex items-center justify-center text-xs shrink-0">
                                        <i class="ti ti-book text-emerald-600"></i>
                                    </div>
                                    <div class="flex flex-wrap items-center gap-1.5">
                                        <span class="font-bold text-slate-900 group-hover:text-emerald-800 transition text-xs sm:text-sm">
                                            {{ $item->mapel->nama_matpel ?? '-' }}
                                        </span>
                                        @if(!empty($item->mapel->kelompok))
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200 whitespace-nowrap">
                                                Kelompok {{ $item->mapel->kelompok }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <!-- Kelas & Unit -->
                            <td class="py-2.5 px-3.5 text-center whitespace-nowrap">
                                <span class="px-2.5 py-1 rounded-md text-[11px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-200/80 shadow-2xs block mb-1">
                                    Kelas {{ $item->kelas->nama_kelas ?? '-' }}
                                </span>
                                <span class="text-[10px] font-semibold text-slate-500 block">
                                    {{ $item->unit->nama_unit ?? '-' }}
                                </span>
                            </td>

                            <!-- Guru Pengampu -->
                            <td class="py-2.5 px-3.5">
                                <div class="flex items-center gap-2">
                                    <div class="w-6.5 h-6.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 flex items-center justify-center text-xs shrink-0">
                                        <i class="ti ti-user"></i>
                                    </div>
                                    <div>
                                        <span class="font-bold text-slate-800 text-xs block">
                                            {{ $item->guru->nama_guru ?? '-' }}
                                        </span>
                                        @if(!empty($item->guru->karyawan->npp))
                                            <span class="text-[10px] text-slate-400 font-mono">NPP: {{ $item->guru->karyawan->npp }}</span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <!-- Semester & TA -->
                            <td class="py-2.5 px-3.5 text-center whitespace-nowrap">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700 border border-slate-200 block mb-1">
                                    Semester {{ $item->semester == 1 ? 'Ganjil' : 'Genap' }}
                                </span>
                                <span class="text-[11px] font-mono font-medium text-slate-500">
                                    {{ $item->tahunAjaran->tahun_ajaran ?? '-' }}
                                </span>
                            </td>

                            <!-- Aksi -->
                            <td class="py-2.5 px-3.5 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-1.5">
                                    @if (auth()->check() && (auth()->user()->can('jadwalpelajaran.index') || auth()->user()->hasRole('guru') || ($isGuru ?? false)))
                                        <!-- Presensi Mapel -->
                                        <a href="{{ route('presensi-mapel.input', [Crypt::encrypt($item->id), date('Y-m-d')]) }}" 
                                           class="w-7 h-7 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200/80 flex items-center justify-center transition active:scale-95 shadow-2xs"
                                           title="Input Presensi Pelajaran">
                                            <i class="ti ti-checklist text-xs"></i>
                                        </a>

                                        <!-- Cetak Presensi -->
                                        <a href="{{ route('jadwal-pelajaran.cetak-presensi', Crypt::encrypt($item->id)) }}" 
                                           target="_blank"
                                           class="w-7 h-7 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200/80 flex items-center justify-center transition active:scale-95 shadow-2xs"
                                           title="Cetak Presensi Siswa">
                                            <i class="ti ti-printer text-xs"></i>
                                        </a>

                                        <!-- Penilaian -->
                                        <a href="{{ route('penilaian.index', $item->id) }}" 
                                           class="w-7 h-7 rounded-lg bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200/80 flex items-center justify-center transition active:scale-95 shadow-2xs"
                                           title="Input Penilaian & Rapor">
                                            <i class="ti ti-chart-bar text-xs"></i>
                                        </a>
                                    @endif

                                    @can('jadwalpelajaran.edit')
                                        <button type="button" 
                                                class="w-7 h-7 rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200/80 flex items-center justify-center transition active:scale-95 btnEditJadwal cursor-pointer shadow-2xs"
                                                data-id="{{ Crypt::encrypt($item->id) }}"
                                                title="Edit Jadwal">
                                            <i class="ti ti-edit text-xs"></i>
                                        </button>
                                    @endcan

                                    @can('jadwalpelajaran.delete')
                                        <form method="POST" action="{{ route('jadwal-pelajaran.delete', Crypt::encrypt($item->id)) }}" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" 
                                                    class="w-7 h-7 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200/80 flex items-center justify-center transition active:scale-95 btn-delete-jadwal cursor-pointer shadow-2xs"
                                                    data-mapel="{{ $item->mapel->nama_matpel ?? 'Mata Pelajaran' }}"
                                                    data-kelas="{{ $item->kelas->nama_kelas ?? '' }}"
                                                    data-hari="{{ $item->hari }}"
                                                    title="Hapus Jadwal">
                                                <i class="ti ti-trash text-xs"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-12 text-center text-slate-400">
                                <div class="w-14 h-14 rounded-2xl bg-slate-100 border border-slate-200 flex items-center justify-center mx-auto mb-3 text-slate-400 text-2xl">
                                    <i class="ti ti-calendar-off"></i>
                                </div>
                                <h4 class="text-sm font-bold text-slate-800">Belum Ada Data Jadwal Pelajaran</h4>
                                <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                                    Silakan tambahkan jadwal pelajaran baru melalui tombol Tambah Jadwal di atas atau sesuaikan filter pencarian.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- ================= MODAL CONTAINER ================= -->
<x-modal-form id="modalJadwal" size="modal-lg" show="loadmodalJadwal" title="" icon="ti ti-calendar-event" />

@endsection

@push('myscript')
<script>
    $(function() {
        const loading = `
            <div class="p-10 text-center bg-white">
                <div class="w-9 h-9 border-3 border-emerald-500 border-t-transparent rounded-full animate-spin mx-auto mb-2.5"></div>
                <div class="text-xs font-bold text-slate-700">Memuat Data Jadwal...</div>
            </div>
        `;

        // Dynamic Filter: Unit -> Kelas & Guru
        $("#filter_kode_unit").change(function() {
            const kode_unit = $(this).val();
            if(kode_unit) {
                $("#filter_kode_kelas").html('<option value="">Memuat...</option>').prop('disabled', true);
                $("#filter_guru_id").html('<option value="">Memuat...</option>').prop('disabled', true);
                
                $.ajax({
                    url: "{{ route('jadwal-pelajaran.get-data-by-unit') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        kode_unit: kode_unit
                    },
                    dataType: "json",
                    success: function(data) {
                        if(data.status === 'success') {
                            let kelasOptions = '<option value="">Semua Kelas</option>';
                            $.each(data.kelas, function(key, value) {
                                kelasOptions += `<option value="${value.kode_kelas}">${value.nama_kelas}</option>`;
                            });
                            $("#filter_kode_kelas").html(kelasOptions).prop('disabled', false);

                            let guruOptions = '<option value="">Semua Guru</option>';
                            $.each(data.guru, function(key, value) {
                                guruOptions += `<option value="${value.id}">${value.nama_guru}</option>`;
                            });
                            $("#filter_guru_id").html(guruOptions).prop('disabled', false);
                        }
                    },
                    error: function() {
                        $("#filter_kode_kelas").html('<option value="">Semua Kelas</option>').prop('disabled', false);
                        $("#filter_guru_id").html('<option value="">Semua Guru</option>').prop('disabled', false);
                    }
                });
            } else {
                window.location.href = "{{ route('jadwal-pelajaran.index') }}";
            }
        });

        // Input Presensi Quick Modal
        $("#btnInputPresensiQuick").click(function(e) {
            e.preventDefault();
            e.stopPropagation();
            $('#modalJadwal').modal("show");
            $("#modalJadwal").find("#loadmodalJadwal").html(loading);
            $("#modalJadwal").find(".modal-title").text("Pilih Jadwal Presensi Siswa");
            $("#loadmodalJadwal").load("{{ route('presensi-mapel.create') }}");
        });

        // Tambah Jadwal Modal
        $("#btnCreateJadwal").click(function(e) {
            e.preventDefault();
            e.stopPropagation();
            $('#modalJadwal').modal("show");
            $("#modalJadwal").find("#loadmodalJadwal").html(loading);
            $("#modalJadwal").find(".modal-title").text("Tambah Jadwal Pelajaran Baru");
            $("#loadmodalJadwal").load("{{ route('jadwal-pelajaran.create') }}");
        });

        // Edit Jadwal Modal
        $(document).on('click', '.btnEditJadwal', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const id = $(this).data('id');
            $('#modalJadwal').modal("show");
            $("#modalJadwal").find("#loadmodalJadwal").html(loading);
            $("#modalJadwal").find(".modal-title").text("Edit Jadwal Pelajaran");
            $("#loadmodalJadwal").load(`/jadwal-pelajaran/${id}/edit`);
        });

        // Delete Jadwal with SweetAlert2
        $(document).on('click', '.btn-delete-jadwal', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const form = $(this).closest('form');
            const mapel = $(this).data('mapel') || 'Mata Pelajaran';
            const kelas = $(this).data('kelas') || '';
            const hari = $(this).data('hari') || '';

            Swal.fire({
                title: 'Hapus Jadwal Pelajaran?',
                html: `
                    <div class="text-xs sm:text-sm text-slate-600 mt-2 space-y-2 text-center">
                        <p>Apakah Anda yakin ingin menghapus jadwal pelajaran:</p>
                        <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-xl font-bold text-slate-900">
                            ${mapel} ${kelas ? `- Kelas ${kelas}` : ''}
                            ${hari ? `<span class="text-xs text-slate-500 font-semibold block mt-0.5">Hari ${hari}</span>` : ''}
                        </div>
                        <p class="text-[11px] text-rose-500 font-semibold">Tindakan ini tidak dapat dibatalkan.</p>
                    </div>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: '<i class="ti ti-trash mr-1"></i> Ya, Hapus Data',
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
                    Swal.fire({
                        title: 'Menghapus Data...',
                        text: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: () => { Swal.showLoading(); }
                    });
                    form.get(0).submit();
                }
            });
        });
    });
</script>
@endpush

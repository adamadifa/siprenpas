@extends('layouts.app')
@section('titlepage', 'Presensi Mata Pelajaran')

@section('content')
<div class="space-y-5">

    <!-- ================= 1. PAGE HEADER (NO CARD) WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <i class="ti ti-checklist text-emerald-600 text-2xl"></i>
                <span>Presensi Mata Pelajaran</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Monitoring, rekapitulasi, dan pencatatan presensi siswa per mata pelajaran & jadwal kelas
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
                <span class="font-bold text-slate-800">Presensi Mapel</span>
            </nav>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center gap-2">
                <button type="button" id="btnInputPresensi" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg text-xs shadow-xs transition-all duration-200 active:scale-95 cursor-pointer">
                    <i class="ti ti-plus text-base"></i>
                    <span>Input Presensi</span>
                </button>
            </div>
        </div>
    </div>

    <!-- ================= 2. FILTER & SEARCH TOOLBAR ================= -->
    <form action="{{ route('presensi-mapel.index') }}" method="GET" class="w-full">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-2.5 sm:gap-3 w-full">
            <!-- Tahun Ajaran Filter -->
            <div class="relative">
                <i class="ti ti-calendar-event absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base pointer-events-none"></i>
                <select name="kode_ta" id="filter_kode_ta" class="w-full pl-9 pr-8 py-2.5 text-sm bg-white border border-slate-300/90 rounded-lg text-slate-700 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                    @foreach ($semuaTa as $ta)
                        <option value="{{ $ta->kode_ta }}" {{ $selectedKodeTa == $ta->kode_ta ? 'selected' : '' }}>
                            {{ $ta->tahun_ajaran }} {{ $ta->status == 1 ? '(Aktif)' : '' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Unit Filter (If Super Admin / Multi-Unit) -->
            @if ((auth()->user()->kode_unit == 'U06' || auth()->user()->hasRole('super admin')) && !auth()->user()->hasRole('guru'))
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

            <!-- Tanggal Filter -->
            <div class="relative">
                <i class="ti ti-calendar absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base pointer-events-none"></i>
                <input type="text" 
                       name="tanggal" 
                       id="filter_tanggal"
                       value="{{ request('tanggal') }}" 
                       placeholder="Pilih Tanggal..." 
                       class="w-full pl-9 pr-3.5 py-2.5 text-sm bg-white border border-slate-300/90 rounded-lg text-slate-700 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition flatpickr-date">
            </div>

            <!-- Filter Buttons -->
            <div class="flex items-center gap-2">
                <button type="submit" class="flex-1 py-2.5 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-lg shadow-xs transition inline-flex items-center justify-center gap-1.5 cursor-pointer active:scale-95">
                    <i class="ti ti-search text-base"></i>
                    <span>Cari Data</span>
                </button>

                @if(request('kode_unit') || request('kode_kelas') || request('tanggal') || (request('kode_ta') && request('kode_ta') != ($semuaTa->firstWhere('status', 1)->kode_ta ?? '')))
                    <a href="{{ route('presensi-mapel.index') }}" class="py-2.5 px-3 bg-white hover:bg-slate-100 text-slate-600 border border-slate-300/90 rounded-lg font-semibold text-sm transition inline-flex items-center justify-center shrink-0 shadow-xs" title="Reset Filter">
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
                    <i class="ti ti-checklist"></i>
                </div>
                <h3 class="text-sm font-extrabold text-white tracking-tight">Daftar Presensi Mata Pelajaran</h3>
                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-white/20 text-white border border-white/30 shadow-2xs backdrop-blur-xs">
                    {{ $presensi->total() }} data
                </span>
            </div>
            <div class="text-xs text-emerald-100 font-medium">
                Tahun Ajaran: <span class="font-bold text-white">{{ $semuaTa->firstWhere('kode_ta', $selectedKodeTa)->tahun_ajaran ?? '-' }}</span>
            </div>
        </div>

        <!-- Responsive Table Container -->
        <div class="overflow-x-auto bg-emerald-600">
            <table class="w-full min-w-[1050px] text-left text-xs sm:text-sm border-0 border-collapse">
                <!-- Matching Solid Green Table Header -->
                <thead class="bg-emerald-600 text-white font-bold uppercase tracking-wider text-[11px] border-0 border-t-0 border-b border-emerald-700/80">
                    <tr class="border-0 border-t-0">
                        <th class="py-2.5 px-3.5 w-14 text-center text-emerald-100 border-0 border-t-0 whitespace-nowrap">No</th>
                        <th class="py-2.5 px-3.5 w-52 text-emerald-100 border-0 border-t-0 whitespace-nowrap">Tanggal & Waktu</th>
                        <th class="py-2.5 px-3.5 min-w-[220px] text-emerald-100 border-0 border-t-0">Mata Pelajaran</th>
                        <th class="py-2.5 px-3.5 text-center w-36 text-emerald-100 border-0 border-t-0 whitespace-nowrap">Kelas & Unit</th>
                        <th class="py-2.5 px-3.5 min-w-[200px] text-emerald-100 border-0 border-t-0">Guru Pengampu</th>
                        <th class="py-2.5 px-3.5 min-w-[240px] text-emerald-100 border-0 border-t-0">Materi / Pembahasan</th>
                        <th class="py-2.5 px-3.5 text-center w-28 text-emerald-100 border-0 border-t-0 whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700 font-medium bg-white">
                    @forelse ($presensi as $p)
                        <tr class="hover:bg-slate-50/80 transition-colors group">
                            <!-- No Index -->
                            <td class="py-2.5 px-3.5 text-center text-slate-400 font-bold text-xs whitespace-nowrap">
                                <span class="w-6 h-6 rounded-md bg-slate-100 group-hover:bg-emerald-50 group-hover:text-emerald-700 group-hover:border group-hover:border-emerald-200 inline-flex items-center justify-center font-bold text-slate-600 transition text-[11px]">
                                    {{ $loop->iteration + ($presensi->currentPage() - 1) * $presensi->perPage() }}
                                </span>
                            </td>

                            <!-- Tanggal & Waktu -->
                            <td class="py-2.5 px-3.5 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-200/80 flex items-center justify-center text-xs shrink-0 group-hover:bg-emerald-600 group-hover:text-white transition shadow-2xs">
                                        <i class="ti ti-calendar-time text-sm"></i>
                                    </div>
                                    <div>
                                        <span class="font-black text-slate-900 text-xs block">
                                            {{ \Carbon\Carbon::parse($p->tanggal)->translatedFormat('l, d M Y') }}
                                        </span>
                                        <span class="text-[11px] font-mono font-bold text-emerald-700 block mt-0.5">
                                            <i class="ti ti-clock text-[10px] mr-0.5"></i>{{ substr($p->jam_mulai, 0, 5) }} - {{ substr($p->jam_selesai, 0, 5) }}
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
                                    <div>
                                        <span class="font-bold text-slate-900 group-hover:text-emerald-800 transition text-xs sm:text-sm block">
                                            {{ $p->mata_pelajaran->nama_matpel ?? '-' }}
                                        </span>
                                        @if(!empty($p->mata_pelajaran->kelompok))
                                            <span class="px-1.5 py-0.2 rounded text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200 inline-block mt-0.5">
                                                Kelompok {{ $p->mata_pelajaran->kelompok }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <!-- Kelas & Unit -->
                            <td class="py-2.5 px-3.5 text-center whitespace-nowrap">
                                <span class="px-2.5 py-1 rounded-md text-[11px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-200/80 shadow-2xs block mb-1">
                                    Kelas {{ $p->kelas->nama_kelas ?? '-' }}
                                </span>
                                <span class="text-[10px] font-semibold text-slate-500 block">
                                    {{ $p->unit->nama_unit ?? '-' }}
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
                                            {{ $p->guru->karyawan->nama_lengkap ?? ($p->guru->nama_guru ?? '-') }}
                                        </span>
                                        @if(!empty($p->guru->karyawan->npp))
                                            <span class="text-[10px] text-slate-400 font-mono">NPP: {{ $p->guru->karyawan->npp }}</span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <!-- Materi / Pembahasan -->
                            <td class="py-2.5 px-3.5">
                                @if(!empty($p->materi))
                                    <div class="space-y-1">
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <i class="ti ti-check text-[10px]"></i> Ada Materi
                                        </span>
                                        <p class="text-xs text-slate-600 line-clamp-2 max-w-xs font-normal">
                                            {{ $p->materi }}
                                        </p>
                                    </div>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-500 border border-slate-200">
                                        <i class="ti ti-minus text-[10px]"></i> Tanpa Materi
                                    </span>
                                @endif
                            </td>

                            <!-- Aksi -->
                            <td class="py-2.5 px-3.5 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-1.5">
                                    <!-- Edit Presensi -->
                                    <a href="{{ route('presensi-mapel.edit', Crypt::encrypt($p->id)) }}" 
                                       class="w-7 h-7 rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200/80 flex items-center justify-center transition active:scale-95 shadow-2xs"
                                       title="Edit Presensi">
                                        <i class="ti ti-edit text-xs"></i>
                                    </a>

                                    <!-- Delete Presensi -->
                                    <form method="POST" action="{{ route('presensi-mapel.delete', Crypt::encrypt($p->id)) }}" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                class="w-7 h-7 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200/80 flex items-center justify-center transition active:scale-95 btn-delete-presensi cursor-pointer shadow-2xs"
                                                data-mapel="{{ $p->mata_pelajaran->nama_matpel ?? 'Mata Pelajaran' }}"
                                                data-kelas="{{ $p->kelas->nama_kelas ?? '' }}"
                                                data-tanggal="{{ \Carbon\Carbon::parse($p->tanggal)->translatedFormat('l, d M Y') }}"
                                                title="Hapus Presensi">
                                            <i class="ti ti-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-12 text-center text-slate-400">
                                <div class="w-14 h-14 rounded-2xl bg-slate-100 border border-slate-200 flex items-center justify-center mx-auto mb-3 text-slate-400 text-2xl">
                                    <i class="ti ti-calendar-off"></i>
                                </div>
                                <h4 class="text-sm font-bold text-slate-800">Belum Ada Data Presensi Pembelajaran</h4>
                                <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                                    Silakan lakukan pencatatan presensi siswa dengan menekan tombol Input Presensi di atas.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Section -->
        @if ($presensi->hasPages())
            <div class="px-5 py-3.5 bg-slate-50 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
                <div>
                    Menampilkan <span class="font-bold text-slate-700">{{ $presensi->firstItem() ?? 0 }}</span> sampai <span class="font-bold text-slate-700">{{ $presensi->lastItem() ?? 0 }}</span> dari <span class="font-bold text-slate-700">{{ $presensi->total() }}</span> data
                </div>
                <div>
                    {{ $presensi->links() }}
                </div>
            </div>
        @endif
    </div>

</div>

<!-- ================= MODAL CONTAINER ================= -->
<x-modal-form id="mdlInputPresensi" size="modal-lg" show="loadInputPresensi" title="" icon="ti ti-calendar-plus" />

@endsection

@push('myscript')
<script>
    $(function() {
        // Initialize Flatpickr for date filter
        if (typeof flatpickr === 'function') {
            $('#filter_tanggal').flatpickr({
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "d-m-Y",
                allowInput: true
            });
        }

        const loading = `
            <div class="p-10 text-center bg-white">
                <div class="w-9 h-9 border-3 border-emerald-500 border-t-transparent rounded-full animate-spin mx-auto mb-2.5"></div>
                <div class="text-xs font-bold text-slate-700">Memuat Formulir Presensi...</div>
            </div>
        `;

        // Modal Input Presensi Trigger
        $("#btnInputPresensi").click(function(e) {
            e.preventDefault();
            e.stopPropagation();
            $('#mdlInputPresensi').modal("show");
            $("#mdlInputPresensi").find("#loadInputPresensi").html(loading);
            $("#mdlInputPresensi").find(".modal-title").text("Pilih Jadwal Presensi Siswa");
            $("#loadInputPresensi").load("{{ route('presensi-mapel.create') }}");
        });

        // Dynamic Filter: Unit -> Kelas
        $("#filter_kode_unit, #filter_kode_ta").change(function() {
            var kode_unit = $("#filter_kode_unit").val();
            var kode_ta = $("#filter_kode_ta").val();

            if (!$("#filter_kode_unit").length) {
                kode_unit = "{{ auth()->user()->kode_unit }}";
            }

            if (kode_unit) {
                $("#filter_kode_kelas").html('<option value="">Memuat Kelas...</option>').prop('disabled', true);
                $.ajax({
                    url: "{{ route('jadwal-pelajaran.get-data-by-unit') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        kode_unit: kode_unit,
                        kode_ta: kode_ta
                    },
                    success: function(res) {
                        var opt = '<option value="">Semua Kelas</option>';
                        if (res.kelas && res.kelas.length > 0) {
                            $.each(res.kelas, function(idx, item) {
                                opt += `<option value="${item.kode_kelas}">${item.nama_kelas}</option>`;
                            });
                        }
                        $("#filter_kode_kelas").html(opt).prop('disabled', false);
                    },
                    error: function() {
                        $("#filter_kode_kelas").html('<option value="">Semua Kelas</option>').prop('disabled', false);
                    }
                });
            }
        });

        // Delete Confirmation with SweetAlert2
        $(document).on('click', '.btn-delete-presensi', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const form = $(this).closest('form');
            const mapel = $(this).data('mapel') || 'Mata Pelajaran';
            const kelas = $(this).data('kelas') || '';
            const tanggal = $(this).data('tanggal') || '';

            Swal.fire({
                title: 'Hapus Data Presensi?',
                html: `
                    <div class="text-xs sm:text-sm text-slate-600 mt-2 space-y-2 text-center">
                        <p>Apakah Anda yakin ingin menghapus catatan presensi:</p>
                        <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-xl font-bold text-slate-900">
                            ${mapel} ${kelas ? `- Kelas ${kelas}` : ''}
                            ${tanggal ? `<span class="text-xs text-slate-500 font-semibold block mt-0.5">${tanggal}</span>` : ''}
                        </div>
                        <p class="text-[11px] text-rose-500 font-semibold">Semua data kehadiran siswa pada pertemuan ini akan dihapus permanen.</p>
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

@extends('layouts.app')
@section('titlepage', 'Data Kelas')

@section('content')
<div class="space-y-5">

    <!-- ================= 1. PAGE HEADER (NO CARD) WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <i class="ti ti-door-enter text-emerald-600 text-2xl"></i>
                <span>Data Kelas</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Manajemen rombongan belajar, alokasi tingkat, unit pendidikan, dan penugasan wali kelas
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
                    <i class="ti ti-database text-sm"></i>
                    <span>Data Master</span>
                </span>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Kelas</span>
            </nav>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center gap-2">
                @can('kelas.create')
                    <button type="button" id="btnCreateKelas" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg text-xs shadow-xs transition-all duration-200 active:scale-95 cursor-pointer">
                        <i class="ti ti-plus text-base"></i>
                        <span>Tambah Kelas</span>
                    </button>
                @endcan
            </div>
        </div>
    </div>

    <!-- ================= 2. FILTER & SEARCH TOOLBAR ================= -->
    <form action="{{ route('kelas.index') }}" method="GET" class="w-full">
        <div class="flex flex-col lg:flex-row items-center gap-2.5 sm:gap-3 w-full">
            <!-- Search Input (Flex-1 expands to fill width) -->
            <div class="flex-1 min-w-0 w-full relative">
                <i class="ti ti-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-lg pointer-events-none"></i>
                <input type="text" 
                       name="nama_kelas_search" 
                       value="{{ Request('nama_kelas_search') }}" 
                       placeholder="Cari Nama Kelas atau Kode..." 
                       class="w-full pl-11 pr-4 py-2.5 sm:py-3 text-sm bg-white border border-slate-300/90 rounded-lg text-slate-800 font-medium placeholder-slate-400 shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
            </div>

            <!-- Unit Filter (If Super Admin) -->
            @if (auth()->user()->kode_unit == 'U06' || count($unit) > 1)
                <div class="w-full lg:w-48 shrink-0 relative">
                    <i class="ti ti-building absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base pointer-events-none"></i>
                    <select name="kode_unit_search" class="w-full pl-10 pr-8 py-2.5 sm:py-3 text-sm bg-white border border-slate-300/90 rounded-lg text-slate-700 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                        <option value="">Semua Unit</option>
                        @foreach ($unit as $d)
                            <option value="{{ $d->kode_unit }}" {{ Request('kode_unit_search') == $d->kode_unit ? 'selected' : '' }}>
                                {{ $d->nama_unit }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            <!-- Wali Kelas Filter -->
            <div class="w-full lg:w-56 shrink-0 relative">
                <i class="ti ti-user-check absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base pointer-events-none"></i>
                <select name="guru_id_search" class="w-full pl-10 pr-8 py-2.5 sm:py-3 text-sm bg-white border border-slate-300/90 rounded-lg text-slate-700 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                    <option value="">Semua Wali Kelas</option>
                    @foreach ($wali_kelas_list as $wkl)
                        <option value="{{ $wkl->id }}" {{ Request('guru_id_search') == $wkl->id ? 'selected' : '' }}>
                            {{ $wkl->nama_guru }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Tahun Ajaran Filter -->
            <div class="w-full lg:w-48 shrink-0 relative">
                <i class="ti ti-calendar-event absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base pointer-events-none"></i>
                <select name="kode_ta" class="w-full pl-10 pr-8 py-2.5 sm:py-3 text-sm bg-white border border-slate-300/90 rounded-lg text-slate-700 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                    <option value="">Semua Tahun Ajaran</option>
                    @foreach ($tahunajaran as $d)
                        <option value="{{ $d->kode_ta }}" {{ (Request('kode_ta') == $d->kode_ta || (!Request('kode_ta') && $kode_ta == $d->kode_ta)) ? 'selected' : '' }}>
                            {{ $d->tahun_ajaran }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2 shrink-0 w-full lg:w-auto">
                <button type="submit" class="w-full lg:w-auto px-5 py-2.5 sm:py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-lg shadow-xs transition inline-flex items-center justify-center gap-2 cursor-pointer active:scale-95 whitespace-nowrap">
                    <i class="ti ti-search text-base"></i>
                    <span>Cari</span>
                </button>
                @if(Request('nama_kelas_search') || Request('kode_unit_search') || Request('guru_id_search') || Request('kode_ta'))
                    <a href="{{ route('kelas.index') }}" class="py-2.5 sm:py-3 px-3 bg-white hover:bg-slate-100 text-slate-600 border border-slate-300/90 rounded-lg font-semibold text-sm transition inline-flex items-center justify-center shrink-0 shadow-xs" title="Reset Filter">
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
                    <i class="ti ti-door-enter"></i>
                </div>
                <h3 class="text-sm font-extrabold text-white tracking-tight">Daftar Data Kelas</h3>
                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-white/20 text-white border border-white/30 shadow-2xs backdrop-blur-xs">
                    {{ count($kelas) }} data
                </span>
            </div>
            <div class="text-xs text-emerald-100 font-medium">
                Tahun Ajaran Aktif: <span class="font-bold text-white">{{ $ta_aktif ?: '-' }}</span>
            </div>
        </div>

        <!-- Responsive Table Container -->
        <div class="overflow-x-auto bg-emerald-600">
            <table class="w-full min-w-[960px] text-left text-xs sm:text-sm border-0 border-collapse">
                <!-- Matching Solid Green Table Header -->
                <thead class="bg-emerald-600 text-white font-bold uppercase tracking-wider text-[11px] border-0 border-t-0 border-b border-emerald-700/80">
                    <tr class="border-0 border-t-0">
                        <th class="py-2.5 px-3.5 w-14 text-center text-emerald-100 border-0 border-t-0 whitespace-nowrap">No</th>
                        <th class="py-2.5 px-3.5 w-36 text-emerald-100 border-0 border-t-0 whitespace-nowrap">Kode Kelas</th>
                        <th class="py-2.5 px-3.5 min-w-[180px] text-emerald-100 border-0 border-t-0">Nama Kelas</th>
                        <th class="py-2.5 px-3.5 text-center w-28 text-emerald-100 border-0 border-t-0 whitespace-nowrap">Tingkat</th>
                        <th class="py-2.5 px-3.5 w-40 text-emerald-100 border-0 border-t-0 whitespace-nowrap">Unit</th>
                        <th class="py-2.5 px-3.5 min-w-[220px] text-emerald-100 border-0 border-t-0">Wali Kelas</th>
                        <th class="py-2.5 px-3.5 text-center w-36 text-emerald-100 border-0 border-t-0 whitespace-nowrap">Tahun Ajaran</th>
                        <th class="py-2.5 px-3.5 text-center w-32 text-emerald-100 border-0 border-t-0 whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700 font-medium bg-white">
                    @forelse ($kelas as $d)
                        <tr class="hover:bg-slate-50/80 transition-colors group">
                            <!-- No Index -->
                            <td class="py-2.5 px-3.5 text-center text-slate-400 font-bold text-xs whitespace-nowrap">
                                <span class="w-6 h-6 rounded-md bg-slate-100 group-hover:bg-emerald-50 group-hover:text-emerald-700 group-hover:border group-hover:border-emerald-200 inline-flex items-center justify-center font-bold text-slate-600 transition text-[11px]">
                                    {{ $loop->iteration }}
                                </span>
                            </td>

                            <!-- Kode Kelas -->
                            <td class="py-2.5 px-3.5 whitespace-nowrap">
                                <span class="px-2.5 py-1 rounded-md text-[11px] font-black font-mono tracking-wider bg-emerald-50 text-emerald-800 border border-emerald-200/80 shadow-2xs">
                                    {{ $d->kode_kelas }}
                                </span>
                            </td>

                            <!-- Nama Kelas -->
                            <td class="py-2.5 px-3.5">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-200/80 flex items-center justify-center text-xs shrink-0 group-hover:bg-emerald-600 group-hover:text-white transition shadow-2xs">
                                        <i class="ti ti-door-enter text-sm"></i>
                                    </div>
                                    <span class="font-bold text-slate-900 group-hover:text-emerald-800 transition text-xs sm:text-sm">
                                        Kelas {{ $d->nama_kelas }}
                                    </span>
                                </div>
                            </td>

                            <!-- Tingkat -->
                            <td class="py-2.5 px-3.5 text-center whitespace-nowrap">
                                <span class="px-2.5 py-1 rounded-md text-[11px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-200/80 shadow-2xs">
                                    Tingkat {{ $d->tingkat }}
                                </span>
                            </td>

                            <!-- Unit -->
                            <td class="py-2.5 px-3.5 whitespace-nowrap">
                                <span class="px-2.5 py-1 rounded-md text-[11px] font-bold bg-slate-100 text-slate-700 border border-slate-200/80">
                                    {{ $d->nama_unit }}
                                </span>
                            </td>

                            <!-- Wali Kelas -->
                            <td class="py-2.5 px-3.5">
                                @if ($d->waliKelas)
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-md bg-slate-100 text-slate-600 flex items-center justify-center text-xs shrink-0">
                                            <i class="ti ti-user-check text-emerald-600"></i>
                                        </div>
                                        <span class="font-bold text-slate-800 text-xs">
                                            {{ $d->waliKelas->nama_guru }}
                                        </span>
                                    </div>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md text-[11px] font-medium bg-amber-50 text-amber-700 border border-amber-200">
                                        <i class="ti ti-alert-circle text-xs"></i>
                                        <span>Belum Ditentukan</span>
                                    </span>
                                @endif
                            </td>

                            <!-- Tahun Ajaran -->
                            <td class="py-2.5 px-3.5 text-center whitespace-nowrap">
                                <span class="px-2.5 py-1 rounded-md text-[11px] font-mono font-medium bg-slate-50 text-slate-600 border border-slate-200/70">
                                    {{ $d->tahun_ajaran }}
                                </span>
                            </td>

                            <!-- Aksi -->
                            <td class="py-2.5 px-3.5 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-1.5">
                                    @can('kelas.edit')
                                        <a href="{{ route('kelas.setkelas', Crypt::encrypt($d->kode_kelas)) }}"
                                           class="w-7 h-7 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200/80 flex items-center justify-center transition active:scale-95 shadow-2xs"
                                           title="Atur Siswa Kelas">
                                            <i class="ti ti-users text-xs"></i>
                                        </a>
                                    @endcan

                                    @can('kelas.edit')
                                        <button type="button" 
                                                class="w-7 h-7 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200/80 flex items-center justify-center transition active:scale-95 btnEditKelas cursor-pointer shadow-2xs"
                                                kode_kelas="{{ Crypt::encrypt($d->kode_kelas) }}"
                                                kode_unit="{{ $d->kode_unit }}"
                                                tingkat="{{ $d->tingkat }}"
                                                title="Edit Kelas">
                                            <i class="ti ti-edit text-xs"></i>
                                        </button>
                                    @endcan

                                    @can('kelas.delete')
                                        <form method="POST" action="{{ route('kelas.delete', Crypt::encrypt($d->kode_kelas)) }}" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" 
                                                    class="w-7 h-7 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200/80 flex items-center justify-center transition active:scale-95 btn-delete-kelas cursor-pointer shadow-2xs"
                                                    data-nama="{{ $d->nama_kelas }}"
                                                    data-unit="{{ $d->nama_unit }}"
                                                    data-kode="{{ $d->kode_kelas }}"
                                                    title="Hapus Kelas">
                                                <i class="ti ti-trash text-xs"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-12 text-center text-slate-400">
                                <div class="w-14 h-14 rounded-2xl bg-slate-100 border border-slate-200 flex items-center justify-center mx-auto mb-3 text-slate-400 text-2xl">
                                    <i class="ti ti-door-off"></i>
                                </div>
                                <h4 class="text-sm font-bold text-slate-800">Belum Ada Data Kelas</h4>
                                <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                                    Silakan tambahkan data kelas baru melalui tombol Tambah Kelas di atas.
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
<x-modal-form id="modalKelas" size="modal-md" show="loadmodalKelas" title="" icon="ti ti-door-enter" />

@endsection

@push('myscript')
<script>
    $(function() {
        const loading = `
            <div class="p-10 text-center bg-white">
                <div class="w-9 h-9 border-3 border-emerald-500 border-t-transparent rounded-full animate-spin mx-auto mb-2.5"></div>
                <div class="text-xs font-bold text-slate-700">Memuat Data Kelas...</div>
            </div>
        `;

        function getTingkatByUnit(kode_unit, selected = '') {
            $.ajax({
                type: "POST",
                url: "{{ route('unit.gettingkatbyunit') }}",
                cache: false,
                data: {
                    _token: "{{ csrf_token() }}",
                    kode_unit: kode_unit,
                    selected: selected
                },
                success: function(respond) {
                    $(document).find("#tingkat").html(respond);
                }
            });
        }

        function getGuruByUnit(kode_unit, selected = '') {
            $.ajax({
                type: "POST",
                url: "{{ route('unit.getgurubyunit') }}",
                cache: false,
                data: {
                    _token: "{{ csrf_token() }}",
                    kode_unit: kode_unit,
                    selected: selected
                },
                success: function(respond) {
                    $(document).find("#guru_id").html(respond);
                }
            });
        }

        $(document).on('change', '#kode_unit', function() {
            const kode_unit = $(this).val();
            getTingkatByUnit(kode_unit);
            if (kode_unit) {
                $('#wali_kelas_group').slideDown();
                getGuruByUnit(kode_unit);
            } else {
                $('#wali_kelas_group').slideUp();
                $('#guru_id').html('<option value="">Pilih Wali Kelas</option>');
            }
        });

        // Tambah Kelas Modal
        $("#btnCreateKelas").click(function(e) {
            e.preventDefault();
            e.stopPropagation();
            $('#modalKelas').modal("show");
            $("#modalKelas").find("#loadmodalKelas").html(loading);
            $("#modalKelas").find(".modal-title").text("Tambah Data Kelas Baru");
            $("#loadmodalKelas").load("{{ route('kelas.create') }}", function() {
                const initialUnit = $(this).find('#kode_unit').val();
                if (initialUnit) {
                    getTingkatByUnit(initialUnit);
                    getGuruByUnit(initialUnit);
                }
            });
        });

        // Edit Kelas Modal
        $(document).on('click', '.btnEditKelas', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const kode_kelas = $(this).attr('kode_kelas');
            const kode_unit = $(this).attr('kode_unit');
            const tingkat = $(this).attr('tingkat');

            $('#modalKelas').modal("show");
            $("#modalKelas").find("#loadmodalKelas").html(loading);
            $("#modalKelas").find(".modal-title").text("Edit Data Kelas");
            $("#loadmodalKelas").load(`/kelas/${kode_kelas}/edit`, function() {
                getTingkatByUnit(kode_unit, tingkat);
            });
        });

        // Delete Kelas with SweetAlert2
        $(document).on('click', '.btn-delete-kelas', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const form = $(this).closest('form');
            const nama = $(this).data('nama') || 'kelas ini';
            const unit = $(this).data('unit') || '';
            const kode = $(this).data('kode') || '';

            Swal.fire({
                title: 'Hapus Data Kelas?',
                html: `
                    <div class="text-xs sm:text-sm text-slate-600 mt-2 space-y-2 text-center">
                        <p>Apakah Anda yakin ingin menghapus data rombongan belajar:</p>
                        <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-xl font-bold text-slate-900">
                            Kelas ${nama} ${unit ? `(${unit})` : ''}
                            ${kode ? `<span class="text-xs text-slate-500 font-mono block mt-0.5">Kode: ${kode}</span>` : ''}
                        </div>
                        <p class="text-[11px] text-rose-500 font-semibold">Data siswa di dalam kelas ini akan otomatis dikeluarkan dari kelas.</p>
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

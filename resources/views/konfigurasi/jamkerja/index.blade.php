@extends('layouts.app')
@section('titlepage', 'Jam Kerja')

@section('content')
<div class="space-y-5">

    <!-- ================= 1. PAGE HEADER (NO CARD) WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center border border-emerald-200/80 shadow-2xs">
                    <i class="ti ti-clock-pause text-2xl"></i>
                </div>
                <span>Pengaturan Jam Kerja</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Kelola jadwal shift, jam masuk, jam pulang, total durasi kerja, dan toleransi lintas hari karyawan
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
                    <i class="ti ti-settings text-sm"></i>
                    <span>Konfigurasi</span>
                </span>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Jam Kerja</span>
            </nav>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center gap-2">
                @can('jamkerja.create')
                    <a href="#" id="btnCreate" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs transition-all duration-200 active:scale-95 cursor-pointer">
                        <i class="ti ti-plus text-base"></i>
                        <span>Tambah Jam Kerja</span>
                    </a>
                @endcan
            </div>
        </div>
    </div>

    <!-- ================= 2. FILTER & SEARCH TOOLBAR ================= -->
    <form action="{{ route('jamkerja.index') }}" method="GET" class="w-full">
        <div class="flex flex-col sm:flex-row items-center gap-2.5 sm:gap-3 w-full">
            <!-- Search Input -->
            <div class="flex-1 min-w-0 w-full relative">
                <i class="ti ti-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-lg pointer-events-none"></i>
                <input type="text" 
                       name="nama_jam_kerja" 
                       value="{{ Request('nama_jam_kerja') }}" 
                       placeholder="Cari kode atau nama shift jam kerja..." 
                       class="w-full pl-11 pr-4 py-2.5 sm:py-3 text-sm bg-white border border-slate-300/90 rounded-xl text-slate-800 font-medium placeholder-slate-400 shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2 shrink-0 w-full sm:w-auto">
                <button type="submit" class="w-full sm:w-auto px-5 py-2.5 sm:py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl shadow-xs transition inline-flex items-center justify-center gap-2 cursor-pointer active:scale-95 whitespace-nowrap">
                    <i class="ti ti-search text-base"></i>
                    <span>Cari</span>
                </button>
                @if(request()->filled('nama_jam_kerja'))
                    <a href="{{ route('jamkerja.index') }}" class="py-2.5 sm:py-3 px-3.5 bg-white hover:bg-slate-100 text-slate-600 border border-slate-300/90 rounded-xl font-semibold text-sm transition inline-flex items-center justify-center shrink-0 shadow-xs" title="Reset Filter">
                        <i class="ti ti-refresh text-base"></i>
                    </a>
                @endif
            </div>
        </div>
    </form>

    <!-- ================= 3. SOLID EMERALD TABLE CARD ================= -->
    <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
        <!-- Solid Emerald Header -->
        <div class="bg-emerald-600 px-5 py-4 flex items-center justify-between text-white">
            <div class="flex items-center gap-2.5">
                <i class="ti ti-clock-pause text-xl"></i>
                <h3 class="font-bold text-sm tracking-wide text-white">Daftar Jadwal Jam Kerja</h3>
            </div>
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-white/20 text-white backdrop-blur-xs">
                Total: {{ count($jamkerja) }} Shift
            </span>
        </div>

        <!-- Table Container -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-emerald-600 text-white uppercase text-[11px] font-extrabold tracking-wider border-t border-emerald-500/50">
                        <th class="py-3.5 px-4 w-14 text-center">NO</th>
                        <th class="py-3.5 px-4 w-28 text-center">KODE</th>
                        <th class="py-3.5 px-5 min-w-[220px]">NAMA JAM KERJA</th>
                        <th class="py-3.5 px-4 text-center w-36">JAM MASUK</th>
                        <th class="py-3.5 px-4 text-center w-36">JAM PULANG</th>
                        <th class="py-3.5 px-4 text-center w-32">TOTAL JAM</th>
                        <th class="py-3.5 px-4 text-center w-32">LINTAS HARI</th>
                        <th class="py-3.5 px-4 text-center w-28">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                    @forelse ($jamkerja as $d)
                        <tr class="hover:bg-slate-50/80 transition-colors group">
                            <!-- No -->
                            <td class="py-4 px-4 text-center font-bold text-slate-400">
                                {{ $loop->iteration }}
                            </td>

                            <!-- Kode -->
                            <td class="py-4 px-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 font-mono text-[11px] font-bold border border-slate-200">
                                    {{ $d->kode_jam_kerja }}
                                </span>
                            </td>

                            <!-- Nama Jam Kerja -->
                            <td class="py-4 px-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0 border border-emerald-100 font-bold text-xs">
                                        <i class="ti ti-clock"></i>
                                    </div>
                                    <h4 class="font-bold text-slate-900 text-sm group-hover:text-emerald-700 transition-colors leading-snug">
                                        {{ $d->nama_jam_kerja }}
                                    </h4>
                                </div>
                            </td>

                            <!-- Jam Masuk -->
                            <td class="py-4 px-4 text-center">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/80">
                                    <i class="ti ti-login text-xs"></i>
                                    {{ $d->jam_masuk }}
                                </span>
                            </td>

                            <!-- Jam Pulang -->
                            <td class="py-4 px-4 text-center">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200/80">
                                    <i class="ti ti-logout text-xs"></i>
                                    {{ $d->jam_pulang }}
                                </span>
                            </td>

                            <!-- Total Jam -->
                            <td class="py-4 px-4 text-center font-bold text-slate-800">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 border border-slate-200">
                                    <i class="ti ti-hourglass-low text-xs text-slate-400"></i>
                                    {{ $d->total_jam }} Jam
                                </span>
                            </td>

                            <!-- Lintas Hari -->
                            <td class="py-4 px-4 text-center">
                                @if ($d->lintas_hari == 1)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-50 text-amber-800 border border-amber-200">
                                        <i class="ti ti-moon text-xs text-amber-600"></i> Ya
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                        <i class="ti ti-sun text-xs text-slate-400"></i> Tidak
                                    </span>
                                @endif
                            </td>

                            <!-- Aksi -->
                            <td class="py-4 px-4 text-center">
                                <div class="inline-flex items-center justify-center gap-1.5">
                                    @can('jamkerja.edit')
                                        <a href="#" 
                                           class="w-8 h-8 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 flex items-center justify-center transition-colors border border-emerald-200/60 btnEdit cursor-pointer" 
                                           kode_jam_kerja="{{ Crypt::encrypt($d->kode_jam_kerja) }}"
                                           title="Edit Jam Kerja">
                                            <i class="ti ti-edit text-base"></i>
                                        </a>
                                    @endcan

                                    @can('jamkerja.delete')
                                        <form method="POST" name="deleteform" class="deleteform inline-block m-0"
                                              action="{{ route('jamkerja.delete', Crypt::encrypt($d->kode_jam_kerja)) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" 
                                                    class="w-8 h-8 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 flex items-center justify-center transition-colors border border-rose-200/60 delete-confirm cursor-pointer"
                                                    title="Hapus Jam Kerja">
                                                <i class="ti ti-trash text-base"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-14 text-center bg-white">
                                <div class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3 text-2xl shadow-inner">
                                    <i class="ti ti-clock-off"></i>
                                </div>
                                <h4 class="font-bold text-slate-800 text-sm mb-1">Belum Ada Data Jam Kerja</h4>
                                <p class="text-xs text-slate-400 max-w-sm mx-auto">
                                    Silahkan klik tombol Tambah Jam Kerja untuk membuat jadwal shift presensi baru.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<x-modal-form id="mdlCreate" size="" show="loadCreate" title="Buat Jam Kerja" />
<x-modal-form id="mdlEdit" size="" show="loadEdit" title="Edit Jam Kerja" />
@endsection

@push('myscript')
<script>
    $(function() {
        const loading = `
            <div class="p-8 text-center text-slate-400">
                <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-emerald-500 border-t-transparent mb-2"></div>
                <p class="text-xs font-semibold">Memuat formulir...</p>
            </div>`;

        $("#btnCreate").click(function(e) {
            e.preventDefault();
            $('#mdlCreate').modal("show");
            $("#mdlCreate").find("#loadCreate").html(loading);
            $("#loadCreate").load("{{ route('jamkerja.create') }}");
        });

        $(document).on("click", ".btnEdit", function(e) {
            var kode_jam_kerja = $(this).attr("kode_jam_kerja");
            e.preventDefault();
            $('#mdlEdit').modal("show");
            $("#mdlEdit").find("#loadEdit").html(loading);
            $("#loadEdit").load('/jamkerja/' + kode_jam_kerja + '/edit');
        });

        // Handle delete confirmation
        $(document).on('click', '.delete-confirm', function(e) {
            e.preventDefault();
            const form = $(this).closest('form');

            Swal.fire({
                title: 'Hapus Jam Kerja?',
                text: "Data jadwal jam kerja ini akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#059669',
                cancelButtonColor: '#e11d48',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    confirmButton: 'px-4 py-2 bg-emerald-600 text-white font-bold rounded-xl text-xs mr-2',
                    cancelButton: 'px-4 py-2 bg-slate-200 text-slate-700 font-bold rounded-xl text-xs'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush

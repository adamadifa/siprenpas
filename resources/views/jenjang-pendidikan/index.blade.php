@extends('layouts.app')
@section('titlepage', 'Jenjang Pendidikan')

@section('content')
<div class="space-y-5">

    <!-- ================= 1. PAGE HEADER (NO CARD) WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <i class="ti ti-stairs text-emerald-600 text-2xl"></i>
                <span>Jenjang Pendidikan</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Manajemen data tingkatan dan kategori jenjang pendidikan peserta lomba Al Amin Got Talent
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
                    <i class="ti ti-sparkles text-sm"></i>
                    <span>Al Amin Got Talent</span>
                </span>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Jenjang Pendidikan</span>
            </nav>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center gap-2">
                @can('jenjang-pendidikan.create')
                    <button type="button" id="btnCreateJenjangPendidikan" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs transition-all duration-200 active:scale-95 cursor-pointer">
                        <i class="ti ti-plus text-base"></i>
                        <span>Tambah Jenjang</span>
                    </button>
                @endcan
            </div>
        </div>
    </div>

    <!-- ================= 2. FILTER & SEARCH TOOLBAR ================= -->
    <form action="{{ route('jenjang-pendidikan.index') }}" method="GET" class="w-full">
        <div class="flex flex-col sm:flex-row items-center gap-2.5 sm:gap-3 w-full">
            <!-- Search Input (Flex-1 expands to fill width) -->
            <div class="flex-1 min-w-0 w-full relative">
                <i class="ti ti-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-lg pointer-events-none"></i>
                <input type="text" 
                       name="jenjang_pendidikan_search" 
                       value="{{ Request('jenjang_pendidikan_search') }}" 
                       placeholder="Cari Jenjang Pendidikan (Contoh: SD, SMP, SMA, Umum)..." 
                       class="w-full pl-11 pr-4 py-2.5 sm:py-3 text-sm bg-white border border-slate-300 rounded-xl text-slate-800 font-medium placeholder-slate-400 shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2 shrink-0 w-full sm:w-auto">
                <button type="submit" class="w-full sm:w-auto px-5 py-2.5 sm:py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl shadow-xs transition inline-flex items-center justify-center gap-2 cursor-pointer active:scale-95 whitespace-nowrap">
                    <i class="ti ti-search text-base"></i>
                    <span>Cari</span>
                </button>
                @if(Request('jenjang_pendidikan_search'))
                    <a href="{{ route('jenjang-pendidikan.index') }}" class="py-2.5 sm:py-3 px-3 bg-white hover:bg-slate-100 text-slate-600 border border-slate-300 rounded-xl font-semibold text-sm transition inline-flex items-center justify-center shrink-0 shadow-xs" title="Reset Filter">
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
                    <i class="ti ti-stairs"></i>
                </div>
                <h3 class="text-sm font-extrabold text-white tracking-tight">Daftar Jenjang Pendidikan</h3>
                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-white/20 text-white border border-white/30 shadow-2xs backdrop-blur-xs">
                    {{ count($jenjangPendidikan) }} data
                </span>
            </div>
            <div class="text-xs text-emerald-100 font-medium">
                Data master klasifikasi tingkat pendidikan peserta Got Talent
            </div>
        </div>

        <!-- Responsive Table Container -->
        <div class="overflow-x-auto bg-emerald-600">
            <table class="w-full text-left text-xs sm:text-sm border-0 border-collapse">
                <!-- Matching Solid Green Table Header -->
                <thead class="bg-emerald-600 text-white font-bold uppercase tracking-wider text-[11px] border-0 border-t-0 border-b border-emerald-700/80">
                    <tr class="border-0 border-t-0">
                        <th class="py-2 px-3.5 w-12 text-center text-emerald-100 border-0 border-t-0">No</th>
                        <th class="py-2 px-3.5 text-emerald-100 border-0 border-t-0">Jenjang Pendidikan</th>
                        <th class="py-2 px-3.5 text-center w-28 text-emerald-100 border-0 border-t-0">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700 font-medium bg-white">
                    @forelse ($jenjangPendidikan as $d)
                        <tr class="hover:bg-slate-50/80 transition-colors group">
                            <!-- No Index -->
                            <td class="py-2.5 px-3.5 text-center text-slate-400 font-bold text-xs">
                                <span class="w-5.5 h-5.5 rounded-md bg-slate-100 group-hover:bg-emerald-50 group-hover:text-emerald-700 group-hover:border group-hover:border-emerald-200 inline-flex items-center justify-center font-bold text-slate-600 transition text-[11px]">
                                    {{ $loop->iteration }}
                                </span>
                            </td>

                            <!-- Jenjang Pendidikan -->
                            <td class="py-2.5 px-3.5">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 rounded-lg bg-indigo-50 text-indigo-700 flex items-center justify-center text-xs shrink-0 group-hover:bg-emerald-100 group-hover:text-emerald-700 transition">
                                        <i class="ti ti-school"></i>
                                    </div>
                                    <span class="font-bold text-slate-900 group-hover:text-emerald-800 transition text-xs sm:text-sm">
                                        {{ $d->jenjang_pendidikan }}
                                    </span>
                                </div>
                            </td>

                            <!-- Aksi -->
                            <td class="py-2.5 px-3.5 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-1.5">
                                    @can('jenjang-pendidikan.edit')
                                        <button type="button" 
                                                class="w-7.5 h-7.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200/80 flex items-center justify-center transition active:scale-95 btnEditJenjang cursor-pointer shadow-2xs"
                                                id_jenjang="{{ Crypt::encrypt($d->id) }}"
                                                title="Edit Jenjang">
                                            <i class="ti ti-edit text-sm"></i>
                                        </button>
                                    @endcan

                                    @can('jenjang-pendidikan.delete')
                                        <form method="POST" action="{{ route('jenjang-pendidikan.delete', Crypt::encrypt($d->id)) }}" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" 
                                                    class="w-7.5 h-7.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200/80 flex items-center justify-center transition active:scale-95 btn-delete-jenjang cursor-pointer shadow-2xs"
                                                    data-nama="{{ $d->jenjang_pendidikan }}"
                                                    title="Hapus Jenjang">
                                                <i class="ti ti-trash text-sm"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="p-12 text-center text-slate-400">
                                <div class="w-14 h-14 rounded-2xl bg-slate-100 border border-slate-200 flex items-center justify-center mx-auto mb-3 text-slate-400 text-2xl">
                                    <i class="ti ti-stairs"></i>
                                </div>
                                <h4 class="text-sm font-bold text-slate-800">Belum Ada Data Jenjang Pendidikan</h4>
                                <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                                    Silakan tambahkan data jenjang pendidikan baru melalui tombol Tambah Jenjang di atas.
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
<x-modal-form id="modalJenjangPendidikan" size="modal-md" show="loadmodalJenjangPendidikan" title="" icon="ti ti-stairs" />

@endsection

@push('myscript')
<script>
    $(function() {
        const loading = `
            <div class="p-10 text-center bg-white">
                <div class="w-9 h-9 border-3 border-emerald-500 border-t-transparent rounded-full animate-spin mx-auto mb-2.5"></div>
                <div class="text-xs font-bold text-slate-700">Memuat Data...</div>
            </div>
        `;

        // Tambah Jenjang Pendidikan Modal
        $("#btnCreateJenjangPendidikan").click(function(e) {
            e.preventDefault();
            e.stopPropagation();
            $('#modalJenjangPendidikan').modal("show");
            $("#modalJenjangPendidikan").find("#loadmodalJenjangPendidikan").html(loading);
            $("#modalJenjangPendidikan").find(".modal-title").text("Tambah Jenjang Pendidikan");
            $("#loadmodalJenjangPendidikan").load("{{ route('jenjang-pendidikan.create') }}");
        });

        // Edit Jenjang Pendidikan Modal
        $(document).on('click', '.btnEditJenjang', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const id_jenjang = $(this).attr('id_jenjang');
            $('#modalJenjangPendidikan').modal("show");
            $("#modalJenjangPendidikan").find("#loadmodalJenjangPendidikan").html(loading);
            $("#modalJenjangPendidikan").find(".modal-title").text("Edit Jenjang Pendidikan");
            $("#loadmodalJenjangPendidikan").load(`/jenjang-pendidikan/${id_jenjang}/edit`);
        });

        // Delete Jenjang with SweetAlert2
        $(document).on('click', '.btn-delete-jenjang', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const form = $(this).closest('form');
            const nama = $(this).data('nama') || 'jenjang ini';

            Swal.fire({
                title: 'Hapus Jenjang Pendidikan?',
                html: `
                    <div class="text-xs sm:text-sm text-slate-600 mt-2 space-y-2 text-center">
                        <p>Apakah Anda yakin ingin menghapus data jenjang pendidikan:</p>
                        <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-xl font-bold text-slate-900">
                            ${nama}
                        </div>
                        <p class="text-[11px] text-rose-500 font-semibold">Pastikan tidak ada data perlombaan atau pendaftar yang terkait dengan jenjang ini.</p>
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

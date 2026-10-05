@extends('layouts.app')
@section('titlepage', 'Data Mata Pelajaran')

@section('content')
<div class="space-y-5">

    <!-- ================= 1. PAGE HEADER (NO CARD) WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <i class="ti ti-book text-emerald-600 text-2xl"></i>
                <span>Data Mata Pelajaran</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Manajemen struktur kurikulum, kelompok mata pelajaran, materi induk (parent), dan status keaktifan pembelajaran
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
                <span class="font-bold text-slate-800">Mata Pelajaran</span>
            </nav>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center gap-2">
                @if (auth()->user()->can('matapelajaran.create') || auth()->user()->can('matapelajaran.store'))
                    <button type="button" id="btnCreateMatpel" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg text-xs shadow-xs transition-all duration-200 active:scale-95 cursor-pointer">
                        <i class="ti ti-plus text-base"></i>
                        <span>Tambah Mata Pelajaran</span>
                    </button>
                @endif
            </div>
        </div>
    </div>

    <!-- ================= 2. FILTER & SEARCH TOOLBAR ================= -->
    <form action="{{ route('mata-pelajaran.index') }}" method="GET" class="w-full">
        <div class="flex flex-col lg:flex-row items-center gap-2.5 sm:gap-3 w-full">
            <!-- Search Input (Flex-1 expands to fill width) -->
            <div class="flex-1 min-w-0 w-full relative">
                <i class="ti ti-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-lg pointer-events-none"></i>
                <input type="text" 
                       name="nama_matpel" 
                       value="{{ Request('nama_matpel') }}" 
                       placeholder="Cari Mata Pelajaran atau Kode Mapel..." 
                       class="w-full pl-11 pr-4 py-2.5 sm:py-3 text-sm bg-white border border-slate-300/90 rounded-lg text-slate-800 font-medium placeholder-slate-400 shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
            </div>

            <!-- Unit Filter (If Super Admin or multiple units) -->
            @if (auth()->user()->hasRole('super admin') || count($units) > 1)
                <div class="w-full lg:w-56 shrink-0 relative">
                    <i class="ti ti-building absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base pointer-events-none"></i>
                    <select name="kode_unit" class="w-full pl-10 pr-8 py-2.5 sm:py-3 text-sm bg-white border border-slate-300/90 rounded-lg text-slate-700 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                        <option value="">Semua Unit</option>
                        @foreach ($units as $u)
                            <option value="{{ $u->kode_unit }}" {{ Request('kode_unit') == $u->kode_unit ? 'selected' : '' }}>
                                {{ $u->nama_unit }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            <!-- Kelompok Filter -->
            <div class="w-full lg:w-48 shrink-0 relative">
                <i class="ti ti-category absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base pointer-events-none"></i>
                <select name="kelompok" class="w-full pl-10 pr-8 py-2.5 sm:py-3 text-sm bg-white border border-slate-300/90 rounded-lg text-slate-700 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                    <option value="">Semua Kelompok</option>
                    <option value="A" {{ Request('kelompok') == 'A' ? 'selected' : '' }}>Kelompok A</option>
                    <option value="B" {{ Request('kelompok') == 'B' ? 'selected' : '' }}>Kelompok B</option>
                    <option value="C" {{ Request('kelompok') == 'C' ? 'selected' : '' }}>Kelompok C</option>
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2 shrink-0 w-full lg:w-auto">
                <button type="submit" class="w-full lg:w-auto px-5 py-2.5 sm:py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-lg shadow-xs transition inline-flex items-center justify-center gap-2 cursor-pointer active:scale-95 whitespace-nowrap">
                    <i class="ti ti-search text-base"></i>
                    <span>Cari</span>
                </button>
                @if(Request('nama_matpel') || Request('kode_unit') || Request('kelompok'))
                    <a href="{{ route('mata-pelajaran.index') }}" class="py-2.5 sm:py-3 px-3 bg-white hover:bg-slate-100 text-slate-600 border border-slate-300/90 rounded-lg font-semibold text-sm transition inline-flex items-center justify-center shrink-0 shadow-xs" title="Reset Filter">
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
                    <i class="ti ti-book"></i>
                </div>
                <h3 class="text-sm font-extrabold text-white tracking-tight">Daftar Mata Pelajaran</h3>
                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-white/20 text-white border border-white/30 shadow-2xs backdrop-blur-xs">
                    {{ count($matapelajaran) }} Mapel Utama
                </span>
            </div>
            <div class="text-xs text-emerald-100 font-medium">
                Struktur hierarki kurikulum & sub-materi pembelajaran
            </div>
        </div>

        <!-- Responsive Table Container -->
        <div class="overflow-x-auto bg-emerald-600">
            <table class="w-full min-w-[960px] text-left text-xs sm:text-sm border-0 border-collapse">
                <!-- Matching Solid Green Table Header -->
                <thead class="bg-emerald-600 text-white font-bold uppercase tracking-wider text-[11px] border-0 border-t-0 border-b border-emerald-700/80">
                    <tr class="border-0 border-t-0">
                        <th class="py-2.5 px-3.5 w-14 text-center text-emerald-100 border-0 border-t-0 whitespace-nowrap">No</th>
                        <th class="py-2.5 px-3.5 w-36 text-emerald-100 border-0 border-t-0 whitespace-nowrap">Kode Mapel</th>
                        <th class="py-2.5 px-3.5 min-w-[300px] text-emerald-100 border-0 border-t-0">Nama Mata Pelajaran</th>
                        <th class="py-2.5 px-3.5 text-center w-36 text-emerald-100 border-0 border-t-0 whitespace-nowrap">Kelompok</th>
                        <th class="py-2.5 px-3.5 w-44 text-emerald-100 border-0 border-t-0 whitespace-nowrap">Unit</th>
                        <th class="py-2.5 px-3.5 text-center w-24 text-emerald-100 border-0 border-t-0 whitespace-nowrap">Urutan</th>
                        <th class="py-2.5 px-3.5 text-center w-32 text-emerald-100 border-0 border-t-0 whitespace-nowrap">Status</th>
                        <th class="py-2.5 px-3.5 text-center w-28 text-emerald-100 border-0 border-t-0 whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700 font-medium bg-white">
                    @forelse ($matapelajaran as $mp)
                        <!-- Parent Row -->
                        <tr class="hover:bg-slate-50/90 transition-colors group bg-slate-50/40">
                            <!-- No Index -->
                            <td class="py-2.5 px-3.5 text-center text-slate-400 font-bold text-xs whitespace-nowrap">
                                <span class="w-6 h-6 rounded-md bg-slate-100 group-hover:bg-emerald-50 group-hover:text-emerald-700 group-hover:border group-hover:border-emerald-200 inline-flex items-center justify-center font-bold text-slate-600 transition text-[11px]">
                                    {{ $loop->iteration }}
                                </span>
                            </td>

                            <!-- Kode Mapel -->
                            <td class="py-2.5 px-3.5 whitespace-nowrap">
                                <span class="px-2.5 py-1 rounded-md text-[11px] font-black font-mono tracking-wider bg-emerald-50 text-emerald-800 border border-emerald-200/80 shadow-2xs">
                                    {{ $mp->kode_matpel }}
                                </span>
                            </td>

                            <!-- Nama Mapel -->
                            <td class="py-2.5 px-3.5">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-200/80 flex items-center justify-center text-xs shrink-0 group-hover:bg-emerald-600 group-hover:text-white transition shadow-2xs">
                                        <i class="ti ti-book text-sm"></i>
                                    </div>
                                    <div class="flex flex-wrap items-center gap-1.5">
                                        <span class="font-bold text-slate-900 group-hover:text-emerald-800 transition text-xs sm:text-sm">
                                            {{ $mp->nama_matpel }}
                                        </span>
                                        @if(count($mp->children) > 0)
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-200 whitespace-nowrap">
                                                {{ count($mp->children) }} Sub-Materi
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <!-- Kelompok -->
                            <td class="py-2.5 px-3.5 text-center whitespace-nowrap">
                                <span class="px-2.5 py-1 rounded-md text-[11px] font-bold bg-slate-100 text-slate-700 border border-slate-200/80">
                                    Kelompok {{ $mp->kelompok }}
                                </span>
                            </td>

                            <!-- Unit -->
                            <td class="py-2.5 px-3.5 whitespace-nowrap">
                                <span class="px-2.5 py-1 rounded-md text-[11px] font-bold bg-slate-100 text-slate-700 border border-slate-200/80">
                                    {{ $mp->unit->nama_unit ?? '-' }}
                                </span>
                            </td>

                            <!-- Urutan -->
                            <td class="py-2.5 px-3.5 text-center whitespace-nowrap">
                                <span class="w-6 h-6 rounded-md bg-slate-100 text-slate-700 inline-flex items-center justify-center font-mono font-bold text-xs border border-slate-200/70">
                                    {{ $mp->urutan }}
                                </span>
                            </td>

                            <!-- Status -->
                            <td class="py-2.5 px-3.5 text-center whitespace-nowrap">
                                @if ($mp->aktif)
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 shadow-2xs">
                                        <i class="ti ti-check text-xs"></i>
                                        <span>Aktif</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-[11px] font-bold bg-rose-50 text-rose-700 border border-rose-200 shadow-2xs">
                                        <i class="ti ti-x text-xs"></i>
                                        <span>Non-Aktif</span>
                                    </span>
                                @endif
                            </td>

                            <!-- Aksi -->
                            <td class="py-2.5 px-3.5 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-1.5">
                                    @can('matapelajaran.edit')
                                        <button type="button" 
                                                class="w-7 h-7 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200/80 flex items-center justify-center transition active:scale-95 btnEditMatpel cursor-pointer shadow-2xs"
                                                data-id="{{ Crypt::encrypt($mp->id) }}"
                                                title="Edit Mata Pelajaran">
                                            <i class="ti ti-edit text-xs"></i>
                                        </button>
                                    @endcan

                                    @can('matapelajaran.delete')
                                        <form method="POST" action="{{ route('mata-pelajaran.delete', Crypt::encrypt($mp->id)) }}" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" 
                                                    class="w-7 h-7 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200/80 flex items-center justify-center transition active:scale-95 btn-delete-matpel cursor-pointer shadow-2xs"
                                                    data-nama="{{ $mp->nama_matpel }}"
                                                    data-kode="{{ $mp->kode_matpel }}"
                                                    data-children="{{ count($mp->children) }}"
                                                    title="Hapus Mata Pelajaran">
                                                <i class="ti ti-trash text-xs"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>

                        <!-- Children (Sub-Materi) Rows -->
                        @foreach ($mp->children as $child)
                            <tr class="hover:bg-slate-50/80 transition-colors group bg-white">
                                <!-- No Sub -->
                                <td class="py-2 px-3.5 text-center text-slate-300 whitespace-nowrap">
                                    <i class="ti ti-point text-base"></i>
                                </td>

                                <!-- Sub Kode Mapel -->
                                <td class="py-2 px-3.5 whitespace-nowrap">
                                    <span class="px-2 py-0.5 rounded-md text-[10px] font-bold font-mono tracking-wider bg-slate-100 text-slate-600 border border-slate-200">
                                        {{ $child->kode_matpel }}
                                    </span>
                                </td>

                                <!-- Sub Nama Mapel (Indented with Branch Icon) -->
                                <td class="py-2 px-3.5 pl-6 sm:pl-8">
                                    <div class="flex items-center gap-2">
                                        <i class="ti ti-corner-down-right text-emerald-600 text-sm shrink-0"></i>
                                        <span class="font-semibold text-slate-800 group-hover:text-emerald-700 transition text-xs">
                                            {{ $child->nama_matpel }}
                                        </span>
                                        <span class="text-[10px] text-slate-400 font-medium italic whitespace-nowrap">
                                            (Sub dari: {{ $mp->nama_matpel }})
                                        </span>
                                    </div>
                                </td>

                                <!-- Kelompok -->
                                <td class="py-2 px-3.5 text-center whitespace-nowrap">
                                    <span class="px-2.5 py-0.5 rounded text-[10px] font-medium bg-slate-50 text-slate-600 border border-slate-200/60">
                                        Kelompok {{ $child->kelompok }}
                                    </span>
                                </td>

                                <!-- Unit -->
                                <td class="py-2 px-3.5 whitespace-nowrap">
                                    <span class="text-xs text-slate-600">
                                        {{ $child->unit->nama_unit ?? '-' }}
                                    </span>
                                </td>

                                <!-- Urutan -->
                                <td class="py-2 px-3.5 text-center whitespace-nowrap">
                                    <span class="text-xs font-mono font-medium text-slate-500">
                                        {{ $child->urutan }}
                                    </span>
                                </td>

                                <!-- Status -->
                                <td class="py-2 px-3.5 text-center whitespace-nowrap">
                                    @if ($child->aktif)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <i class="ti ti-check text-[10px]"></i>
                                            <span>Aktif</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                            <i class="ti ti-x text-[10px]"></i>
                                            <span>Non-Aktif</span>
                                        </span>
                                    @endif
                                </td>

                                <!-- Aksi -->
                                <td class="py-2 px-3.5 text-center whitespace-nowrap">
                                    <div class="flex items-center justify-center gap-1.5">
                                        @can('matapelajaran.edit')
                                            <button type="button" 
                                                    class="w-6.5 h-6.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200/80 flex items-center justify-center transition active:scale-95 btnEditMatpel cursor-pointer shadow-2xs"
                                                    data-id="{{ Crypt::encrypt($child->id) }}"
                                                    title="Edit Sub-Mata Pelajaran">
                                                <i class="ti ti-edit text-xs"></i>
                                            </button>
                                        @endcan

                                        @can('matapelajaran.delete')
                                            <form method="POST" action="{{ route('mata-pelajaran.delete', Crypt::encrypt($child->id)) }}" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" 
                                                        class="w-6.5 h-6.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200/80 flex items-center justify-center transition active:scale-95 btn-delete-matpel cursor-pointer shadow-2xs"
                                                        data-nama="{{ $child->nama_matpel }}"
                                                        data-kode="{{ $child->kode_matpel }}"
                                                        data-children="0"
                                                        title="Hapus Sub-Mata Pelajaran">
                                                    <i class="ti ti-trash text-xs"></i>
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="8" class="p-12 text-center text-slate-400">
                                <div class="w-14 h-14 rounded-2xl bg-slate-100 border border-slate-200 flex items-center justify-center mx-auto mb-3 text-slate-400 text-2xl">
                                    <i class="ti ti-book-off"></i>
                                </div>
                                <h4 class="text-sm font-bold text-slate-800">Belum Ada Data Mata Pelajaran</h4>
                                <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                                    Silakan tambahkan struktur mata pelajaran baru melalui tombol Tambah Mata Pelajaran di atas.
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
<x-modal-form id="modalMatpel" size="modal-lg" show="loadmodalMatpel" title="" icon="ti ti-book" />

@endsection

@push('myscript')
<script>
    $(function() {
        const loading = `
            <div class="p-10 text-center bg-white">
                <div class="w-9 h-9 border-3 border-emerald-500 border-t-transparent rounded-full animate-spin mx-auto mb-2.5"></div>
                <div class="text-xs font-bold text-slate-700">Memuat Data Mata Pelajaran...</div>
            </div>
        `;

        // Tambah Mata Pelajaran Modal
        $("#btnCreateMatpel").click(function(e) {
            e.preventDefault();
            e.stopPropagation();
            $('#modalMatpel').modal("show");
            $("#modalMatpel").find("#loadmodalMatpel").html(loading);
            $("#modalMatpel").find(".modal-title").text("Tambah Mata Pelajaran Baru");
            $("#loadmodalMatpel").load("{{ route('mata-pelajaran.create') }}");
        });

        // Edit Mata Pelajaran Modal
        $(document).on('click', '.btnEditMatpel', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const id = $(this).data('id');
            $('#modalMatpel').modal("show");
            $("#modalMatpel").find("#loadmodalMatpel").html(loading);
            $("#modalMatpel").find(".modal-title").text("Edit Data Mata Pelajaran");
            $("#loadmodalMatpel").load(`/mata-pelajaran/${id}/edit`);
        });

        // Delete Mata Pelajaran with SweetAlert2
        $(document).on('click', '.btn-delete-matpel', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const form = $(this).closest('form');
            const nama = $(this).data('nama') || 'mata pelajaran ini';
            const kode = $(this).data('kode') || '';
            const childrenCount = parseInt($(this).data('children') || 0);

            let extraWarning = '';
            if (childrenCount > 0) {
                extraWarning = `<p class="text-[11px] text-rose-600 font-bold bg-rose-50 p-2 rounded-lg border border-rose-200 mt-2">
                    <i class="ti ti-alert-triangle mr-1"></i> Perhatian: Mapel ini memiliki ${childrenCount} sub-materi yang juga akan ikut terhapus!
                </p>`;
            }

            Swal.fire({
                title: 'Hapus Mata Pelajaran?',
                html: `
                    <div class="text-xs sm:text-sm text-slate-600 mt-2 space-y-2 text-center">
                        <p>Apakah Anda yakin ingin menghapus data mata pelajaran:</p>
                        <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-xl font-bold text-slate-900">
                            ${nama} ${kode ? `<span class="text-xs text-slate-500 font-mono block mt-0.5">Kode: ${kode}</span>` : ''}
                        </div>
                        ${extraWarning}
                        <p class="text-[11px] text-slate-500">Tindakan ini tidak dapat dibatalkan.</p>
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

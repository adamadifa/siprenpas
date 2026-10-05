@extends('layouts.app')
@section('titlepage', 'Pengumuman Resmi')

@section('content')
<div class="space-y-5">

    <!-- ================= 1. PAGE HEADER (NO CARD) WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center border border-emerald-200/80 shadow-2xs">
                    <i class="ti ti-speakerphone text-2xl"></i>
                </div>
                <span>Pengumuman Lembaga</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Kelola rilis pengumuman resmi, edaran wali santri, dan informasi kedinasan pesantren
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
                    <i class="ti ti-bell text-sm"></i>
                    <span>Informasi</span>
                </span>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Pengumuman</span>
            </nav>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center gap-2">
                @can('pengumuman.create')
                    <a href="#" id="btnCreate" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs transition-all duration-200 active:scale-95 cursor-pointer">
                        <i class="ti ti-plus text-base"></i>
                        <span>Tambah Pengumuman</span>
                    </a>
                @endcan
            </div>
        </div>
    </div>

    <!-- ================= 2. FILTER & SEARCH TOOLBAR ================= -->
    <form action="{{ route('pengumuman.index') }}" method="GET" class="w-full">
        <div class="flex flex-col sm:flex-row items-center gap-2.5 sm:gap-3 w-full">
            <!-- Search Input -->
            <div class="flex-1 min-w-0 w-full relative">
                <i class="ti ti-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-lg pointer-events-none"></i>
                <input type="text" 
                       name="judul" 
                       value="{{ Request('judul') }}" 
                       placeholder="Cari judul pengumuman..." 
                       class="w-full pl-11 pr-4 py-2.5 sm:py-3 text-sm bg-white border border-slate-300/90 rounded-xl text-slate-800 font-medium placeholder-slate-400 shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
            </div>

            <!-- Filter Kategori -->
            <div class="w-full sm:w-60 shrink-0">
                <select name="kategori_id" class="w-full py-2.5 sm:py-3 px-3 text-sm bg-white border border-slate-300/90 rounded-xl text-slate-800 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition cursor-pointer" onchange="this.form.submit()">
                    <option value="">Semua Kategori</option>
                    @foreach ($kategori ?? [] as $kat)
                        <option value="{{ $kat->id }}" {{ Request('kategori_id') == $kat->id ? 'selected' : '' }}>
                            {{ $kat->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2 shrink-0 w-full sm:w-auto">
                <button type="submit" class="w-full sm:w-auto px-5 py-2.5 sm:py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl shadow-xs transition inline-flex items-center justify-center gap-2 cursor-pointer active:scale-95 whitespace-nowrap">
                    <i class="ti ti-search text-base"></i>
                    <span>Cari</span>
                </button>
                @if(request()->filled('judul') || request()->filled('kategori_id'))
                    <a href="{{ route('pengumuman.index') }}" class="py-2.5 sm:py-3 px-3.5 bg-white hover:bg-slate-100 text-slate-600 border border-slate-300/90 rounded-xl font-semibold text-sm transition inline-flex items-center justify-center shrink-0 shadow-xs" title="Reset Filter">
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
                <i class="ti ti-speakerphone text-xl"></i>
                <h3 class="font-bold text-sm tracking-wide text-white">Daftar Pengumuman Resmi</h3>
            </div>
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-white/20 text-white backdrop-blur-xs">
                Total: {{ count($pengumuman) }} Data
            </span>
        </div>

        <!-- Table Container -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-emerald-600 text-white uppercase text-[11px] font-extrabold tracking-wider border-t border-emerald-500/50">
                        <th class="py-3.5 px-4 w-14 text-center">NO</th>
                        <th class="py-3.5 px-5 min-w-[260px]">JUDUL PENGUMUMAN</th>
                        <th class="py-3.5 px-5 w-48">KATEGORI</th>
                        <th class="py-3.5 px-4 text-center w-36">TANGGAL</th>
                        <th class="py-3.5 px-5 w-52">LOKASI</th>
                        <th class="py-3.5 px-4 text-center w-28">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                    @forelse ($pengumuman as $d)
                        <tr class="hover:bg-slate-50/80 transition-colors group">
                            <!-- No -->
                            <td class="py-4 px-4 text-center font-bold text-slate-400">
                                {{ $loop->iteration }}
                            </td>

                            <!-- Judul -->
                            <td class="py-4 px-5">
                                <div class="flex items-start gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0 border border-emerald-100 font-bold text-xs mt-0.5">
                                        <i class="ti ti-bell"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-900 text-sm leading-snug group-hover:text-emerald-700 transition-colors line-clamp-1">
                                            {{ $d->judul }}
                                        </h4>
                                        <span class="text-[11px] text-slate-400 line-clamp-1 mt-0.5">
                                            {{ Str::limit(strip_tags($d->isi), 90) }}
                                        </span>
                                    </div>
                                </div>
                            </td>

                            <!-- Kategori -->
                            <td class="py-4 px-5 whitespace-nowrap">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200/70">
                                    <i class="ti ti-category text-xs"></i>
                                    {{ $d->kategori->nama_kategori ?? 'Umum' }}
                                </span>
                            </td>

                            <!-- Tanggal -->
                            <td class="py-4 px-4 text-center whitespace-nowrap">
                                <span class="inline-flex items-center gap-1.5 text-slate-600 font-medium">
                                    <i class="ti ti-calendar text-slate-400"></i>
                                    {{ \Carbon\Carbon::parse($d->tanggal)->translatedFormat('d M Y') }}
                                </span>
                            </td>

                            <!-- Lokasi -->
                            <td class="py-4 px-5">
                                @if($d->lokasi)
                                    <span class="inline-flex items-center gap-1.5 text-slate-700 text-xs font-medium">
                                        <i class="ti ti-map-pin text-xs text-slate-400"></i>
                                        {{ $d->lokasi }}
                                    </span>
                                @else
                                    <span class="text-slate-400 italic text-xs">-</span>
                                @endif
                            </td>

                            <!-- Aksi -->
                            <td class="py-4 px-4 text-center">
                                <div class="inline-flex items-center justify-center gap-1.5">
                                    @can('pengumuman.show')
                                        <a href="#" 
                                           class="w-8 h-8 rounded-lg bg-sky-50 hover:bg-sky-100 text-sky-600 flex items-center justify-center transition-colors border border-sky-200/60 btnShow" 
                                           pengumuman_id="{{ $d->id }}"
                                           title="Lihat Detail">
                                            <i class="ti ti-file-description text-base"></i>
                                        </a>
                                    @endcan

                                    @can('pengumuman.edit')
                                        <a href="#" 
                                           class="w-8 h-8 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 flex items-center justify-center transition-colors border border-emerald-200/60 btnEdit" 
                                           pengumuman_id="{{ $d->id }}"
                                           title="Edit Pengumuman">
                                            <i class="ti ti-edit text-base"></i>
                                        </a>
                                    @endcan

                                    @can('pengumuman.destroy')
                                        <form method="POST" name="deleteform" class="deleteform inline-block m-0"
                                              action="{{ route('pengumuman.destroy', $d->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" 
                                                    class="w-8 h-8 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 flex items-center justify-center transition-colors border border-rose-200/60 delete-confirm cursor-pointer"
                                                    title="Hapus Pengumuman">
                                                <i class="ti ti-trash text-base"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-14 text-center bg-white">
                                <div class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3 text-2xl shadow-inner">
                                    <i class="ti ti-bell-off"></i>
                                </div>
                                <h4 class="font-bold text-slate-800 text-sm mb-1">Belum Ada Pengumuman</h4>
                                <p class="text-xs text-slate-400 max-w-sm mx-auto">
                                    Silahkan klik tombol Tambah Pengumuman untuk membuat edaran baru.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<x-modal-form id="modal" size="modal-lg" show="loadmodal" title="" />
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
            $("#modal").modal("show");
            $("#modal").find("#loadmodal").html(loading);
            $("#modal").find(".modal-title").text("Tambah Pengumuman Baru");
            $("#loadmodal").load(`{{ route('pengumuman.create') }}`);
        });

        $(document).on("click", ".btnEdit", function(e) {
            e.preventDefault();
            const pengumuman_id = $(this).attr("pengumuman_id");
            $("#modal").modal("show");
            $("#modal").find("#loadmodal").html(loading);
            $("#modal").find(".modal-title").text("Edit Pengumuman");
            $("#loadmodal").load(`/pengumuman/${pengumuman_id}/edit`);
        });

        $(document).on("click", ".btnShow", function(e) {
            e.preventDefault();
            const pengumuman_id = $(this).attr("pengumuman_id");
            $("#modal").modal("show");
            $("#modal").find("#loadmodal").html(loading);
            $("#modal").find(".modal-title").text("Detail Pengumuman");
            $("#loadmodal").load(`/pengumuman/${pengumuman_id}/show`);
        });

        // Handle delete confirmation
        $(document).on('click', '.delete-confirm', function(e) {
            e.preventDefault();
            const form = $(this).closest('form');

            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data pengumuman akan dihapus secara permanen!",
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

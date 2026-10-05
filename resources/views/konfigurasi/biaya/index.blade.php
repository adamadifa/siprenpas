@extends('layouts.app')
@section('titlepage', 'Biaya Pendidikan')

@section('content')
<div class="space-y-6">

    <!-- ================= 1. PAGE HEADER (NO CARD) WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center border border-emerald-200/80 shadow-2xs">
                    <i class="ti ti-coin text-2xl"></i>
                </div>
                <span>Data Biaya Pendidikan</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Kelola paket konfigurasi tarif biaya pendidikan santri per unit, tingkat, asrama, dan periode PPDB
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
                <span class="font-bold text-slate-800">Biaya Pendidikan</span>
            </nav>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center gap-2">
                @can('biaya.create')
                    <button type="button" id="btnCreate" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs transition-all duration-200 active:scale-95 cursor-pointer border-0">
                        <i class="ti ti-plus text-base"></i>
                        <span>Tambah Data Biaya</span>
                    </button>
                @endcan
            </div>
        </div>
    </div>

    <!-- ================= 2. FILTER & SEARCH TOOLBAR ================= -->
    <form action="{{ route('biaya.index') }}" method="GET" class="w-full">
        <div class="flex flex-col sm:flex-row items-center gap-2.5 sm:gap-3 w-full">
            <!-- Filter Unit -->
            <div class="flex-1 min-w-0 w-full relative">
                <i class="ti ti-building absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-lg pointer-events-none"></i>
                <select name="kode_unit" 
                        class="w-full pl-11 pr-4 py-2.5 sm:py-3 text-sm bg-white border border-slate-300/90 rounded-xl text-slate-800 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition cursor-pointer"
                        onchange="this.form.submit()">
                    <option value="">Semua Jenjang / Unit</option>
                    @foreach ($unit as $u)
                        <option value="{{ $u->kode_unit }}" {{ Request('kode_unit') == $u->kode_unit ? 'selected' : '' }}>
                            {{ strtoupper($u->nama_unit) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Tahun Ajaran -->
            <div class="w-full sm:w-72 shrink-0 relative">
                <i class="ti ti-calendar absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-lg pointer-events-none"></i>
                <select name="kode_ta" 
                        id="kode_ta" 
                        class="w-full pl-11 pr-4 py-2.5 sm:py-3 text-sm bg-white border border-slate-300/90 rounded-xl text-slate-800 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition cursor-pointer"
                        onchange="this.form.submit()">
                    <option value="">Semua Tahun Ajaran</option>
                    @foreach ($tahunajaran as $d)
                        <option value="{{ $d->kode_ta }}"
                            @if (!empty(Request('kode_ta'))) {{ Request('kode_ta') == $d->kode_ta ? 'selected' : '' }} @else {{ $d->status == '1' ? 'selected' : '' }} @endif>
                            {{ $d->tahun_ajaran }} {{ $d->status == '1' ? '(Aktif)' : '' }}
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
                @if(request()->filled('kode_unit') || request()->filled('kode_ta'))
                    <a href="{{ route('biaya.index') }}" class="py-2.5 sm:py-3 px-3.5 bg-white hover:bg-slate-100 text-slate-600 border border-slate-300/90 rounded-xl font-semibold text-sm transition inline-flex items-center justify-center shrink-0 shadow-xs" title="Reset Filter">
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
                <i class="ti ti-list-details text-xl"></i>
                <h3 class="font-bold text-sm tracking-wide text-white">Daftar Konfigurasi Paket Biaya</h3>
            </div>
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-white/20 text-white backdrop-blur-xs">
                Total: {{ count($biaya) }} Paket Biaya
            </span>
        </div>

        <!-- Table Container -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse whitespace-nowrap">
                <thead>
                    <tr class="bg-emerald-600 text-white uppercase text-[11px] font-extrabold tracking-wider border-t border-emerald-500/50">
                        <th class="py-2.5 px-3.5 w-12 text-center whitespace-nowrap">NO</th>
                        <th class="py-2.5 px-3.5 whitespace-nowrap">KODE BIAYA</th>
                        <th class="py-2.5 px-4 whitespace-nowrap">UNIT / JENJANG</th>
                        <th class="py-2.5 px-3 text-center whitespace-nowrap">TINGKAT</th>
                        <th class="py-2.5 px-3 text-center whitespace-nowrap">PINDAHAN</th>
                        <th class="py-2.5 px-3 text-center whitespace-nowrap">ASRAMA</th>
                        <th class="py-2.5 px-3.5 text-center whitespace-nowrap">TAHUN AJARAN</th>
                        <th class="py-2.5 px-3.5 text-center w-28 whitespace-nowrap">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                    @forelse ($biaya as $d)
                        <tr class="hover:bg-slate-50/80 transition-colors group">
                            <!-- No -->
                            <td class="py-2.5 px-3.5 text-center font-bold text-slate-400 whitespace-nowrap">
                                {{ $loop->iteration }}
                            </td>

                            <!-- Kode Biaya -->
                            <td class="py-2.5 px-3.5 whitespace-nowrap">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-lg bg-slate-100 text-slate-700 font-mono text-[11px] font-bold border border-slate-200">
                                    {{ $d->kode_biaya }}
                                </span>
                            </td>

                            <!-- Unit / Jenjang -->
                            <td class="py-2.5 px-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <i class="ti ti-building text-slate-400"></i>
                                    <span class="font-bold text-slate-900 text-xs group-hover:text-emerald-700 transition-colors">
                                        {{ $d->nama_unit }}
                                    </span>
                                </div>
                            </td>

                            <!-- Tingkat -->
                            <td class="py-2.5 px-3 text-center whitespace-nowrap">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-bold bg-sky-50 text-sky-700 border border-sky-200">
                                    Kelas {{ $d->tingkat }}
                                </span>
                            </td>

                            <!-- Status Pindahan (Kolom Terpisah) -->
                            <td class="py-2.5 px-3 text-center whitespace-nowrap">
                                @if ($d->is_pindahan)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-800 border border-amber-200">
                                        <i class="ti ti-arrows-transfer-down text-xs text-amber-600"></i>
                                        <span>Ya (Pindahan)</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-slate-100 text-slate-500 border border-slate-200">
                                        Reguler / Baru
                                    </span>
                                @endif
                            </td>

                            <!-- Asrama -->
                            <td class="py-2.5 px-3 text-center whitespace-nowrap">
                                @if ($d->asrama)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <i class="ti ti-home text-xs"></i>
                                        <span>Asrama</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-slate-100 text-slate-500 border border-slate-200">
                                        Non-Asrama
                                    </span>
                                @endif
                            </td>

                            <!-- Tahun Ajaran -->
                            <td class="py-2.5 px-3.5 text-center font-bold text-slate-800 whitespace-nowrap">
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg bg-slate-100 text-slate-700 border border-slate-200 font-mono text-[11px]">
                                    <i class="ti ti-calendar text-xs text-slate-400"></i>
                                    {{ $d->tahun_ajaran }}
                                </span>
                            </td>

                            <!-- Aksi -->
                            <td class="py-2.5 px-3.5 text-center whitespace-nowrap">
                                <div class="inline-flex items-center justify-center gap-1.5">
                                    @can('biaya.show')
                                        <button type="button" 
                                           class="w-7 h-7 rounded-lg bg-sky-50 hover:bg-sky-100 text-sky-700 flex items-center justify-center transition-colors border border-sky-200/60 btnShow cursor-pointer" 
                                           kode_biaya="{{ Crypt::encrypt($d->kode_biaya) }}"
                                           title="Rincian Detail Biaya">
                                            <i class="ti ti-file-description text-sm"></i>
                                        </button>
                                    @endcan

                                    @can('biaya.edit')
                                        <button type="button" 
                                           class="w-7 h-7 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 flex items-center justify-center transition-colors border border-emerald-200/60 btnEdit cursor-pointer" 
                                           kode_biaya="{{ Crypt::encrypt($d->kode_biaya) }}"
                                           title="Edit Paket Biaya">
                                            <i class="ti ti-edit text-sm"></i>
                                        </button>
                                    @endcan

                                    @can('biaya.delete')
                                        <form method="POST" name="deleteform" class="deleteform inline-block m-0"
                                              action="{{ route('biaya.delete', Crypt::encrypt($d->kode_biaya)) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" 
                                                    class="w-7 h-7 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 flex items-center justify-center transition-colors border border-rose-200/60 delete-confirm cursor-pointer"
                                                    title="Hapus Paket Biaya">
                                                <i class="ti ti-trash text-sm"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center bg-white">
                                <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-2 text-xl shadow-inner">
                                    <i class="ti ti-coin-off"></i>
                                </div>
                                <h4 class="font-bold text-slate-800 text-sm mb-1">Belum Ada Data Biaya</h4>
                                <p class="text-xs text-slate-400 max-w-sm mx-auto">
                                    Silahkan klik tombol Tambah Data Biaya untuk membuat konfigurasi paket tarif baru atau sesuaikan filter pencarian.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<x-modal-form id="mdlCreate" size="modal-lg" show="loadCreate" title="Tambah Data Biaya" />
<x-modal-form id="mdlEdit" size="modal-lg" show="loadEdit" title="Edit Data Biaya" />
<x-modal-form id="mdlShow" size="modal-lg" show="loadShow" title="Rincian Data Biaya" />
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
            $("#loadCreate").load("{{ route('biaya.create') }}");
        });

        $(document).on("click", ".btnEdit", function(e) {
            e.preventDefault();
            const kode_biaya = $(this).attr("kode_biaya");
            $('#mdlEdit').modal("show");
            $("#mdlEdit").find("#loadEdit").html(loading);
            $("#loadEdit").load(`/biaya/${kode_biaya}/edit`);
        });

        $(document).on("click", ".btnShow", function(e) {
            e.preventDefault();
            const kode_biaya = $(this).attr("kode_biaya");
            $('#mdlShow').modal("show");
            $("#mdlShow").find("#loadShow").html(loading);
            $("#loadShow").load(`/biaya/${kode_biaya}/show`);
        });

        $(document).on('click', '.delete-confirm', function(e) {
            e.preventDefault();
            const form = $(this).closest('form');
            Swal.fire({
                title: 'Hapus Paket Biaya?',
                text: "Data konfigurasi biaya beserta rincian tarifnya akan dihapus permanen!",
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

@extends('layouts.app')
@section('titlepage', 'Realisasi Kegiatan')

@section('content')
<div class="space-y-6">

    <!-- ================= 1. PAGE HEADER & BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <!-- Title & Subtitle -->
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-xl shrink-0 font-bold border border-emerald-200 shadow-2xs">
                <i class="ti ti-activity"></i>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">
                    Realisasi Kegiatan
                </h1>
                <p class="text-xs text-slate-500 font-medium">
                    Monitoring dan pencatatan laporan realisasi kegiatan seluruh departemen pesantren
                </p>
            </div>
        </div>

        <!-- Breadcrumb & Top Actions -->
        <div class="flex flex-col md:items-end gap-2.5">
            <nav class="flex items-center text-xs text-slate-400 font-medium">
                <a href="{{ route('dashboard.index') }}" class="hover:text-slate-700 transition flex items-center gap-1">
                    <i class="ti ti-home text-sm"></i>
                    <span>Dashboard</span>
                </a>
                <span class="mx-2 text-slate-300">/</span>
                <span class="text-slate-500">MSDM & Layanan</span>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Realisasi Kegiatan</span>
            </nav>

            <div class="flex flex-wrap items-center gap-2">
                @can('realkegiatan.create')
                    <button type="button" 
                            id="btncreateRealisasiKegiatan"
                            class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg text-xs shadow-xs transition active:scale-95 cursor-pointer">
                        <i class="ti ti-plus text-sm"></i>
                        <span>Tambah Realisasi</span>
                    </button>
                @endcan

                @if(auth()->check() && auth()->user()->hasRole('super admin'))
                    <form method="POST" action="{{ route('realisasikegiatan.reset') }}" class="inline-block m-0" id="formResetRealisasi">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-rose-50 hover:bg-rose-600 text-rose-700 hover:text-white font-bold rounded-lg text-xs border border-rose-200 transition active:scale-95 cursor-pointer btn-reset-confirm"
                                title="Reset semua data realisasi kegiatan">
                            <i class="ti ti-rotate text-sm"></i>
                            <span>Reset</span>
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <!-- ================= 2. FILTER & SEARCH TOOLBAR ================= -->
    <form action="{{ route('realisasikegiatan.index') }}" method="GET" id="myForm" class="w-full">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 {{ $user->hasRole(['super admin', 'pimpinan pesantren', 'sekretaris']) ? 'lg:grid-cols-6' : 'lg:grid-cols-3' }} gap-2.5 sm:gap-3 w-full items-center">
            
            <!-- Dari Tanggal -->
            <div class="relative">
                <i class="ti ti-calendar absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base pointer-events-none"></i>
                <input type="text" 
                       name="dari" 
                       id="dari" 
                       value="{{ request('dari') }}" 
                       placeholder="Dari Tanggal" 
                       class="w-full pl-9 pr-3.5 py-2.5 text-xs sm:text-sm bg-white border border-slate-300/90 rounded-lg text-slate-700 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition placeholder-slate-400 flatpickr-date">
            </div>

            <!-- Sampai Tanggal -->
            <div class="relative">
                <i class="ti ti-calendar-due absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base pointer-events-none"></i>
                <input type="text" 
                       name="sampai" 
                       id="sampai" 
                       value="{{ request('sampai') }}" 
                       placeholder="Sampai Tanggal" 
                       class="w-full pl-9 pr-3.5 py-2.5 text-xs sm:text-sm bg-white border border-slate-300/90 rounded-lg text-slate-700 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition placeholder-slate-400 flatpickr-date">
            </div>

            @if ($user->hasRole(['super admin', 'pimpinan pesantren', 'sekretaris']))
                <!-- Departemen Filter -->
                <div class="relative">
                    <i class="ti ti-sitemap absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base pointer-events-none"></i>
                    <select name="kode_dept" id="kode_dept" class="w-full pl-9 pr-8 py-2.5 text-xs sm:text-sm bg-white border border-slate-300/90 rounded-lg text-slate-700 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                        <option value="">Semua Departemen</option>
                        @foreach ($departemen as $d)
                            <option value="{{ $d->kode_dept }}" {{ request('kode_dept') == $d->kode_dept ? 'selected' : '' }}>
                                {{ strtoupper($d->nama_dept) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Jabatan Filter -->
                <div class="relative">
                    <i class="ti ti-briefcase absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base pointer-events-none"></i>
                    <select name="kode_jabatan" id="kode_jabatan" class="w-full pl-9 pr-8 py-2.5 text-xs sm:text-sm bg-white border border-slate-300/90 rounded-lg text-slate-700 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                        <option value="">Semua Jabatan</option>
                        @foreach ($jabatan as $j)
                            <option value="{{ $j->kode_jabatan }}" {{ request('kode_jabatan') == $j->kode_jabatan ? 'selected' : '' }}>
                                {{ strtoupper($j->nama_jabatan) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Empty space on large screens to align buttons nicely -->
                <div class="hidden lg:block"></div>
            @endif

            <!-- Action Buttons (Cari, Cetak Print, Cetak PDF, Reset) -->
            <div class="flex items-center gap-1.5">
                <button type="submit" 
                        class="flex-1 py-2.5 px-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs sm:text-sm rounded-lg shadow-xs transition inline-flex items-center justify-center gap-1.5 cursor-pointer active:scale-95 whitespace-nowrap"
                        title="Terapkan Filter">
                    <i class="ti ti-search text-base"></i>
                    <span>Cari</span>
                </button>
                <button type="submit" 
                        name="cetak" 
                        value="1" 
                        id="cetakButton" 
                        class="py-2.5 px-2.5 bg-white hover:bg-slate-50 text-slate-700 hover:text-emerald-700 border border-slate-300/90 font-bold rounded-lg text-xs sm:text-sm shadow-xs transition inline-flex items-center justify-center cursor-pointer active:scale-95 shrink-0"
                        title="Cetak Laporan">
                    <i class="ti ti-printer text-base"></i>
                </button>
                <button type="submit" 
                        name="cetak_pdf" 
                        value="1" 
                        id="cetakPdfButton" 
                        class="py-2.5 px-2.5 bg-white hover:bg-slate-50 text-slate-700 hover:text-rose-700 border border-slate-300/90 font-bold rounded-lg text-xs sm:text-sm shadow-xs transition inline-flex items-center justify-center cursor-pointer active:scale-95 shrink-0"
                        title="Cetak PDF">
                    <i class="ti ti-file-text text-base"></i>
                </button>
                @if(request('dari') || request('sampai') || request('kode_dept') || request('kode_jabatan'))
                    <a href="{{ route('realisasikegiatan.index') }}" class="py-2.5 px-2.5 bg-white hover:bg-slate-100 text-slate-600 border border-slate-300/90 rounded-lg font-semibold text-xs sm:text-sm transition inline-flex items-center justify-center shrink-0 shadow-xs" title="Reset Filter">
                        <i class="ti ti-refresh text-base"></i>
                    </a>
                @endif
            </div>

        </div>
    </form>

    <!-- ================= 3. DATA TABLE CONTAINER ================= -->
    <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
        <!-- Table Header Bar -->
        <div class="px-4 py-2.5 bg-emerald-600 flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-white">
            <div class="flex items-center gap-2">
                <div class="w-6 h-6 rounded-lg bg-white/20 text-white flex items-center justify-center text-xs font-bold border border-white/20 shadow-2xs">
                    <i class="ti ti-activity"></i>
                </div>
                <h3 class="text-xs sm:text-sm font-bold text-white tracking-tight">Daftar Realisasi Kegiatan Pesantren</h3>
            </div>
            <div class="text-[11px] font-semibold text-emerald-100">
                Total: <span class="font-bold text-white">{{ $realisasikegiatan->total() }}</span> Realisasi Terdaftar
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto bg-emerald-600">
            <table class="w-full text-left text-xs border-0 border-collapse">
                <thead class="bg-emerald-600 text-white font-bold uppercase tracking-wider text-[10.5px] border-0 border-t border-b border-emerald-700/80">
                    <tr class="border-0">
                        <th class="py-2 px-3 w-12 text-center text-emerald-100 whitespace-nowrap">No.</th>
                        <th class="py-2 px-3 text-emerald-100 w-32 whitespace-nowrap">Tanggal</th>
                        <th class="py-2 px-3 text-emerald-100 min-w-[180px]">Realisasi Kegiatan</th>
                        <th class="py-2 px-3 text-emerald-100 min-w-[240px]">Uraian & Capaian</th>
                        <th class="py-2 px-3 text-emerald-100 min-w-[200px]">Terkait Jobdesk & Progker</th>
                        <th class="py-2 px-3 text-center text-emerald-100 whitespace-nowrap">Departemen</th>
                        <th class="py-2 px-3 text-emerald-100 whitespace-nowrap">Oleh</th>
                        <th class="py-2 px-3 text-center w-24 text-emerald-100 whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700 font-medium bg-white text-xs">
                    @forelse ($realisasikegiatan as $d)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-2 px-3 text-center whitespace-nowrap font-mono text-slate-500 font-bold">
                                {{ $loop->iteration + ($realisasikegiatan->currentPage() - 1) * $realisasikegiatan->perPage() }}
                            </td>
                            <td class="py-2 px-3 whitespace-nowrap">
                                <div class="font-bold text-slate-900 flex items-center gap-1.5">
                                    <i class="ti ti-calendar text-emerald-600 text-sm"></i>
                                    <span>{{ date('d-m-Y', strtotime($d->tanggal)) }}</span>
                                </div>
                                <div class="text-[11px] text-slate-400 mt-0.5 flex items-center gap-1 font-normal">
                                    <i class="ti ti-clock text-xs shrink-0"></i>
                                    <span>{{ date('H:i', strtotime($d->created_at)) }} WIB</span>
                                </div>
                            </td>
                            <td class="py-2 px-3">
                                <div class="font-bold text-slate-900 leading-snug">
                                    {{ removeHtmltag($d->nama_kegiatan) }}
                                </div>
                                @if(!empty($d->foto))
                                    <div class="mt-1">
                                        <a href="{{ url('storage/realisasikegiatan/' . $d->kode_dept . '/' . $d->foto) }}" target="_blank" class="inline-flex items-center gap-1 text-[11px] text-emerald-600 hover:text-emerald-700 font-bold">
                                            <i class="ti ti-photo text-xs"></i>
                                            <span>Lihat Foto</span>
                                        </a>
                                    </div>
                                @endif
                            </td>
                            <td class="py-2 px-3 leading-snug text-slate-800 font-medium whitespace-pre-line">
                                <div class="bg-slate-50/70 p-2 rounded-lg border border-slate-100 text-xs">
                                    {{ removeHtmltag($d->uraian_kegiatan) }}
                                </div>
                            </td>
                            <td class="py-2 px-3">
                                <div class="space-y-1">
                                    @if(!empty($d->jobdesk))
                                        <div class="flex items-start gap-1 text-[11px] text-slate-600">
                                            <i class="ti ti-list-check text-slate-400 text-xs mt-0.5 shrink-0"></i>
                                            <span class="line-clamp-2">{{ removeHtmltag($d->jobdesk) }}</span>
                                        </div>
                                    @endif
                                    @if(!empty($d->program_kerja))
                                        <div class="flex items-start gap-1 text-[11px] text-emerald-700 font-semibold">
                                            <i class="ti ti-notebook text-emerald-600 text-xs mt-0.5 shrink-0"></i>
                                            <span class="line-clamp-1">{{ $d->program_kerja }}</span>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="py-2 px-3 text-center whitespace-nowrap">
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                    {{ $d->kode_dept }}
                                </span>
                            </td>
                            <td class="py-2 px-3 whitespace-nowrap">
                                <div class="font-semibold text-slate-800 text-xs flex items-center gap-1.5">
                                    <i class="ti ti-user text-xs text-slate-400"></i>
                                    <span class="truncate max-w-[120px]" title="{{ $d->name }}">{{ $d->name }}</span>
                                </div>
                            </td>
                            <td class="py-2 px-3 text-center whitespace-nowrap">
                                <div class="inline-flex items-center gap-1">
                                    @can('realkegiatan.edit')
                                        <button type="button" 
                                                class="btnEdit inline-flex items-center justify-center w-6.5 h-6.5 rounded-md bg-blue-50 hover:bg-blue-600 text-blue-700 hover:text-white border border-blue-200 font-bold transition-all duration-150 active:scale-95 cursor-pointer shadow-2xs"
                                                id="{{ Crypt::encrypt($d->id) }}" 
                                                title="Edit Realisasi">
                                            <i class="ti ti-edit text-xs"></i>
                                        </button>
                                    @endcan
                                    @can('realkegiatan.delete')
                                        <form method="POST" 
                                              action="{{ route('realisasikegiatan.delete', Crypt::encrypt($d->id)) }}" 
                                              class="inline-block m-0 deleteform">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="delete-confirm inline-flex items-center justify-center w-6.5 h-6.5 rounded-md bg-rose-50 hover:bg-rose-600 text-rose-700 hover:text-white border border-rose-200 font-bold transition-all duration-150 active:scale-95 cursor-pointer shadow-2xs"
                                                    title="Hapus Realisasi">
                                                <i class="ti ti-trash text-xs"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-10 px-4 text-center bg-white">
                                <div class="flex flex-col items-center justify-center max-w-sm mx-auto">
                                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl mb-2 border border-emerald-100 shadow-2xs">
                                        <i class="ti ti-activity text-2xl"></i>
                                    </div>
                                    <h4 class="text-xs font-bold text-slate-800 mb-0.5">Belum Ada Realisasi Kegiatan</h4>
                                    <p class="text-[11px] text-slate-400 text-center leading-relaxed mb-2.5">
                                        Tidak ada laporan realisasi kegiatan yang tercatat sesuai kriteria pencarian / filter.
                                    </p>
                                    @can('realkegiatan.create')
                                        <button type="button" 
                                                class="btncreateRealisasiKegiatanDirect inline-flex items-center gap-1 px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg text-xs shadow-xs transition active:scale-95 cursor-pointer">
                                            <i class="ti ti-plus text-xs"></i>
                                            <span>Tambah Realisasi Kegiatan</span>
                                        </button>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($realisasikegiatan->hasPages())
            <div class="p-3 border-t border-slate-100 bg-white">
                {{ $realisasikegiatan->links() }}
            </div>
        @endif
    </div>

</div>

<!-- Modal Container -->
<x-modal-form id="mdlRealisasiKegiatan" size="" show="loadRealisasiKegiatan" title="" />

@endsection

@push('myscript')
<script>
    $(function() {
        const loadingSpinner = `
            <div class="flex items-center justify-center p-8">
                <div class="w-8 h-8 border-4 border-emerald-600 border-t-transparent rounded-full animate-spin"></div>
            </div>
        `;

        // Init flatpickr
        $(".flatpickr-date").flatpickr({
            dateFormat: "Y-m-d",
            allowInput: true
        });

        // Create Modal Trigger
        $(document).on("click", "#btncreateRealisasiKegiatan, .btncreateRealisasiKegiatanDirect", function(e) {
            e.preventDefault();
            $('#mdlRealisasiKegiatan').modal("show");
            $("#mdlRealisasiKegiatan").find(".modal-title").text("Tambah Realisasi Kegiatan");
            $("#loadRealisasiKegiatan").html(loadingSpinner);
            $("#loadRealisasiKegiatan").load('/realisasikegiatan/create');
        });

        // Edit Modal Trigger
        $(document).on("click", ".btnEdit", function(e) {
            e.preventDefault();
            var id = $(this).attr("id");
            $('#mdlRealisasiKegiatan').modal("show");
            $("#mdlRealisasiKegiatan").find(".modal-title").text("Edit Realisasi Kegiatan");
            $("#loadRealisasiKegiatan").html(loadingSpinner);
            $("#loadRealisasiKegiatan").load('/realisasikegiatan/' + id + '/edit');
        });

        // Reset Confirmation
        $(document).on('click', '.btn-reset-confirm', function(event) {
            var form = $(this).closest("form");
            event.preventDefault();
            Swal.fire({
                title: `Reset Semua Realisasi Kegiatan?`,
                text: "Seluruh data realisasi kegiatan akan dihapus secara permanen dari sistem!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#e11d48",
                cancelButtonColor: "#64748b",
                confirmButtonText: "Ya, Reset Semua!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

        // Cetak Validation
        $('#cetakButton, #cetakPdfButton').on('click', function(e) {
            const kode_dept = $('#kode_dept').val();
            const dari = $('#dari').val();
            const sampai = $('#sampai').val();

            @if ($user->hasRole('super admin'))
                if (kode_dept == '') {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Pilih Departemen',
                        text: 'Silakan pilih departemen terlebih dahulu sebelum mencetak laporan.'
                    });
                    return false;
                }
            @endif

            if (dari == '' || sampai == '') {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Pilih Rentang Tanggal',
                    text: 'Silakan isi tanggal dari dan sampai terlebih dahulu.'
                });
                return false;
            }
        });
    });
</script>
@endpush

@extends('layouts.app')
@section('titlepage', 'Agenda Kegiatan Saya')

@section('content')
<div class="space-y-6">

    <!-- ================= 1. PAGE HEADER & BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <!-- Title & Subtitle -->
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-xl shrink-0 font-bold border border-emerald-200 shadow-2xs">
                <i class="ti ti-calendar-event"></i>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">
                    Agenda Kegiatan Saya
                </h1>
                <p class="text-xs text-slate-500 font-medium">
                    Monitoring dan pencatatan agenda rencana kegiatan kerja Anda
                </p>
            </div>
        </div>

        <!-- Breadcrumb & Top Action -->
        <div class="flex flex-col md:items-end gap-2.5">
            <nav class="flex items-center text-xs text-slate-400 font-medium">
                <a href="{{ route('dashboard.index') }}" class="hover:text-slate-700 transition flex items-center gap-1">
                    <i class="ti ti-home text-sm"></i>
                    <span>Dashboard</span>
                </a>
                <span class="mx-2 text-slate-300">/</span>
                <span class="text-slate-500">MSDM & Layanan</span>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Agenda Kegiatan</span>
            </nav>

            @can('agendakegiatan.create')
                <button type="button" 
                        id="btncreateAgendaKegiatan"
                        class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg text-xs shadow-xs transition active:scale-95 cursor-pointer">
                    <i class="ti ti-plus text-sm"></i>
                    <span>Tambah Agenda</span>
                </button>
            @endcan
        </div>
    </div>

    <!-- ================= 2. EMPLOYEE PROFILE HERO BANNER ================= -->
    @if(!empty($karyawan))
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-emerald-800 to-teal-900 text-white p-5 sm:p-6 shadow-md border border-emerald-700/50">
            <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center text-2xl text-emerald-300 shrink-0 shadow-inner">
                        <i class="ti ti-user-check"></i>
                    </div>
                    <div>
                        <h2 class="text-lg sm:text-xl font-bold tracking-tight text-white flex items-center gap-2">
                            <span>{{ $karyawan->nama_lengkap }}</span>
                        </h2>
                        <div class="flex items-center gap-2 mt-0.5 text-xs text-emerald-200">
                            <span class="font-mono font-semibold bg-emerald-950/40 px-2 py-0.5 rounded border border-emerald-500/30">NPP: {{ $karyawan->npp }}</span>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-2.5">
                    <div class="px-3.5 py-2 rounded-xl bg-white/10 backdrop-blur-md border border-white/15">
                        <span class="block text-[10px] font-medium text-emerald-200 uppercase tracking-wider">Jabatan</span>
                        <span class="text-xs font-bold text-white">{{ strtoupper($karyawan->nama_jabatan) }}</span>
                    </div>
                    <div class="px-3.5 py-2 rounded-xl bg-white/10 backdrop-blur-md border border-white/15">
                        <span class="block text-[10px] font-medium text-emerald-200 uppercase tracking-wider">Departemen</span>
                        <span class="text-xs font-bold text-white">{{ strtoupper($karyawan->nama_dept) }}</span>
                    </div>
                    <div class="px-3.5 py-2 rounded-xl bg-white/10 backdrop-blur-md border border-white/15">
                        <span class="block text-[10px] font-medium text-emerald-200 uppercase tracking-wider">Unit Kerja</span>
                        <span class="text-xs font-bold text-white">{{ strtoupper($karyawan->nama_unit) }}</span>
                    </div>
                </div>
            </div>
            
            <!-- Subtle background decorative shapes -->
            <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-emerald-500/10 rounded-full blur-2xl pointer-events-none"></div>
            <div class="absolute right-1/3 -top-10 w-36 h-36 bg-teal-400/10 rounded-full blur-xl pointer-events-none"></div>
        </div>
    @endif

    <!-- ================= 3. FILTER & SEARCH TOOLBAR ================= -->
    <form action="{{ route('agendakegiatan.index') }}" method="GET" id="myForm" class="w-full">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2.5 sm:gap-3 w-full items-center">
            
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

            <!-- Empty spacer for lg screens -->
            <div class="hidden lg:block"></div>

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
                @if(request('dari') || request('sampai'))
                    <a href="{{ route('agendakegiatan.index') }}" class="py-2.5 px-2.5 bg-white hover:bg-slate-100 text-slate-600 border border-slate-300/90 rounded-lg font-semibold text-xs sm:text-sm transition inline-flex items-center justify-center shrink-0 shadow-xs" title="Reset Filter">
                        <i class="ti ti-refresh text-base"></i>
                    </a>
                @endif
            </div>

        </div>
    </form>

    <!-- ================= 4. DATA TABLE CONTAINER ================= -->
    <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
        <!-- Table Header Bar -->
        <div class="px-4 py-2.5 bg-emerald-600 flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-white">
            <div class="flex items-center gap-2">
                <div class="w-6 h-6 rounded-lg bg-white/20 text-white flex items-center justify-center text-xs font-bold border border-white/20 shadow-2xs">
                    <i class="ti ti-calendar-event"></i>
                </div>
                <h3 class="text-xs sm:text-sm font-bold text-white tracking-tight">Daftar Agenda Kegiatan Saya</h3>
            </div>
            <div class="text-[11px] font-semibold text-emerald-100">
                Total: <span class="font-bold text-white">{{ $agenda_kegiatan->total() }}</span> Agenda
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto bg-emerald-600">
            <table class="w-full text-left text-xs border-0 border-collapse">
                <thead class="bg-emerald-600 text-white font-bold uppercase tracking-wider text-[10.5px] border-0 border-t border-b border-emerald-700/80">
                    <tr class="border-0">
                        <th class="py-2 px-3 w-12 text-center text-emerald-100 whitespace-nowrap">No.</th>
                        <th class="py-2 px-3 text-emerald-100 w-32 whitespace-nowrap">Tanggal & Waktu</th>
                        <th class="py-2 px-3 text-emerald-100 min-w-[220px]">Agenda Kegiatan</th>
                        <th class="py-2 px-3 text-emerald-100 min-w-[300px]">Uraian Kegiatan</th>
                        <th class="py-2 px-3 text-center w-24 text-emerald-100 whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700 font-medium bg-white text-xs">
                    @forelse ($agenda_kegiatan as $d)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-2 px-3 text-center whitespace-nowrap font-mono text-slate-500 font-bold">
                                {{ $loop->iteration + ($agenda_kegiatan->currentPage() - 1) * $agenda_kegiatan->perPage() }}
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
                                    {{ strip_tags($d->nama_kegiatan) }}
                                </div>
                            </td>
                            <td class="py-2 px-3 leading-snug text-slate-800 font-medium whitespace-pre-line">
                                <div class="bg-slate-50/70 p-2 rounded-lg border border-slate-100 text-xs">
                                    {{ strip_tags($d->uraian_kegiatan) }}
                                </div>
                            </td>
                            <td class="py-2 px-3 text-center whitespace-nowrap">
                                <div class="inline-flex items-center gap-1">
                                    @can('agendakegiatan.edit')
                                        <button type="button" 
                                                class="btnEdit inline-flex items-center justify-center w-6.5 h-6.5 rounded-md bg-blue-50 hover:bg-blue-600 text-blue-700 hover:text-white border border-blue-200 font-bold transition-all duration-150 active:scale-95 cursor-pointer shadow-2xs"
                                                id="{{ Crypt::encrypt($d->id) }}" 
                                                title="Edit Agenda">
                                            <i class="ti ti-edit text-xs"></i>
                                        </button>
                                    @endcan
                                    @can('agendakegiatan.delete')
                                        <form method="POST" 
                                              action="{{ route('agendakegiatan.delete', Crypt::encrypt($d->id)) }}" 
                                              class="inline-block m-0 deleteform">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="delete-confirm inline-flex items-center justify-center w-6.5 h-6.5 rounded-md bg-rose-50 hover:bg-rose-600 text-rose-700 hover:text-white border border-rose-200 font-bold transition-all duration-150 active:scale-95 cursor-pointer shadow-2xs"
                                                    title="Hapus Agenda">
                                                <i class="ti ti-trash text-xs"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-10 px-4 text-center bg-white">
                                <div class="flex flex-col items-center justify-center max-w-sm mx-auto">
                                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl mb-2 border border-emerald-100 shadow-2xs">
                                        <i class="ti ti-calendar-off"></i>
                                    </div>
                                    <h4 class="text-xs font-bold text-slate-800 mb-0.5">Belum Ada Agenda Kegiatan</h4>
                                    <p class="text-[11px] text-slate-400 text-center leading-relaxed mb-2.5">
                                        Tidak ada agenda kegiatan yang Anda catat pada rentang tanggal ini.
                                    </p>
                                    @can('agendakegiatan.create')
                                        <button type="button" 
                                                class="btncreateAgendaKegiatanDirect inline-flex items-center gap-1 px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg text-xs shadow-xs transition active:scale-95 cursor-pointer">
                                            <i class="ti ti-plus text-xs"></i>
                                            <span>Tambah Agenda Kegiatan</span>
                                        </button>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($agenda_kegiatan->hasPages())
            <div class="p-3 border-t border-slate-100 bg-white">
                {{ $agenda_kegiatan->links() }}
            </div>
        @endif
    </div>

</div>

<!-- Modal Container -->
<x-modal-form id="mdlAgendaKegiatan" size="" show="loadAgendaKegiatan" title="" />

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
        $(document).on("click", "#btncreateAgendaKegiatan, .btncreateAgendaKegiatanDirect", function(e) {
            e.preventDefault();
            $('#mdlAgendaKegiatan').modal("show");
            $("#mdlAgendaKegiatan").find(".modal-title").text("Tambah Agenda Kegiatan");
            $("#loadAgendaKegiatan").html(loadingSpinner);
            $("#loadAgendaKegiatan").load('/agendakegiatan/create');
        });

        // Edit Modal Trigger
        $(document).on("click", ".btnEdit", function(e) {
            e.preventDefault();
            var id = $(this).attr("id");
            $('#mdlAgendaKegiatan').modal("show");
            $("#mdlAgendaKegiatan").find(".modal-title").text("Edit Agenda Kegiatan");
            $("#loadAgendaKegiatan").html(loadingSpinner);
            $("#loadAgendaKegiatan").load('/agendakegiatan/' + id + '/edit');
        });

        // Cetak Validation
        $('#cetakButton, #cetakPdfButton').on('click', function(e) {
            const dari = $('#dari').val();
            const sampai = $('#sampai').val();

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

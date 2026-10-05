@extends('layouts.app')
@section('titlepage', 'Data Jabatan')

@section('content')
<div class="space-y-5">

    <!-- ================= 1. PAGE HEADER (NO CARD) WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <i class="ti ti-briefcase text-emerald-600 text-2xl"></i>
                <span>Data Jabatan</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Manajemen struktur jabatan pegawai, hierarki organisasi, dan wewenang penempatan tugas
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
                    <span>Master Data</span>
                </span>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Jabatan</span>
            </nav>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center gap-2">
                @can('jabatan.create')
                    <button type="button" id="btnCreateJabatan" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg text-xs shadow-xs transition-all duration-200 active:scale-95 cursor-pointer">
                        <i class="ti ti-plus text-base"></i>
                        <span>Tambah Jabatan</span>
                    </button>
                @endcan
            </div>
        </div>
    </div>

    <!-- ================= 2. FILTER & SEARCH TOOLBAR ================= -->
    <form action="{{ route('jabatan.index') }}" method="GET" class="w-full">
        <div class="flex flex-col sm:flex-row items-center gap-2.5 sm:gap-3 w-full">
            <!-- Search Input (Flex-1 expands to fill width) -->
            <div class="flex-1 min-w-0 w-full relative">
                <i class="ti ti-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-lg pointer-events-none"></i>
                <input type="text" 
                       name="nama_jabatan" 
                       value="{{ Request('nama_jabatan') }}" 
                       placeholder="Cari Nama Jabatan atau Kode..." 
                       class="w-full pl-11 pr-4 py-2.5 sm:py-3 text-sm bg-white border border-slate-300/90 rounded-lg text-slate-800 font-medium placeholder-slate-400 shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2 shrink-0 w-full sm:w-auto">
                <button type="submit" class="w-full sm:w-auto px-5 py-2.5 sm:py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-lg shadow-xs transition inline-flex items-center justify-center gap-2 cursor-pointer active:scale-95 whitespace-nowrap">
                    <i class="ti ti-search text-base"></i>
                    <span>Cari</span>
                </button>
                @if(Request('nama_jabatan'))
                    <a href="{{ route('jabatan.index') }}" class="py-2.5 sm:py-3 px-3 bg-white hover:bg-slate-100 text-slate-600 border border-slate-300/90 rounded-lg font-semibold text-sm transition inline-flex items-center justify-center shrink-0 shadow-xs" title="Reset Filter">
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
                    <i class="ti ti-briefcase"></i>
                </div>
                <h3 class="text-sm font-extrabold text-white tracking-tight">Daftar Struktur Jabatan</h3>
                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-white/20 text-white border border-white/30 shadow-2xs backdrop-blur-xs">
                    {{ count($jabatan) }} data
                </span>
            </div>
            <div class="text-xs text-emerald-100 font-medium">
                Gunakan kode jabatan untuk penugasan pada profil karyawan
            </div>
        </div>

        <!-- Responsive Table Container -->
        <div class="overflow-x-auto bg-emerald-600">
            <table class="w-full text-left text-xs sm:text-sm border-0 border-collapse">
                <!-- Matching Solid Green Table Header -->
                <thead class="bg-emerald-600 text-white font-bold uppercase tracking-wider text-[11px] border-0 border-t-0 border-b border-emerald-700/80">
                    <tr class="border-0 border-t-0">
                        <th class="py-2 px-3.5 w-12 text-center text-emerald-100 border-0 border-t-0">No</th>
                        <th class="py-2 px-3.5 w-32 text-emerald-100 border-0 border-t-0">Kode Jabatan</th>
                        <th class="py-2 px-3.5 text-emerald-100 border-0 border-t-0">Nama Jabatan</th>
                        <th class="py-2 px-3.5 text-center w-24 text-emerald-100 border-0 border-t-0">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700 font-medium bg-white">
                    @forelse ($jabatan as $d)
                        <tr class="hover:bg-slate-50/80 transition-colors group">
                            <!-- No Index -->
                            <td class="py-2 px-3.5 text-center text-slate-400 font-bold text-xs">
                                <span class="w-5.5 h-5.5 rounded-md bg-slate-100 group-hover:bg-emerald-50 group-hover:text-emerald-700 group-hover:border group-hover:border-emerald-200 inline-flex items-center justify-center font-bold text-slate-600 transition text-[11px]">
                                    {{ $loop->iteration }}
                                </span>
                            </td>

                            <!-- Kode Jabatan -->
                            <td class="py-2 px-3.5">
                                <span class="px-2 py-0.5 rounded-md text-[11px] font-black font-mono tracking-wider bg-emerald-50 text-emerald-800 border border-emerald-200/80 shadow-2xs">
                                    {{ $d->kode_jabatan }}
                                </span>
                            </td>

                            <!-- Nama Jabatan -->
                            <td class="py-2 px-3.5">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-md bg-slate-100 text-slate-500 flex items-center justify-center text-xs shrink-0 group-hover:bg-emerald-100 group-hover:text-emerald-700 transition">
                                        <i class="ti ti-briefcase"></i>
                                    </div>
                                    <span class="font-bold text-slate-900 group-hover:text-emerald-800 transition text-xs sm:text-sm">
                                        {{ $d->nama_jabatan }}
                                    </span>
                                </div>
                            </td>

                            <!-- Aksi -->
                            <td class="py-2 px-3.5 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    @can('jabatan.edit')
                                        <button type="button" 
                                                class="w-7 h-7 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200/80 flex items-center justify-center transition active:scale-95 btnEditJabatan cursor-pointer shadow-2xs"
                                                kode_jabatan="{{ Crypt::encrypt($d->kode_jabatan) }}"
                                                title="Edit Jabatan">
                                            <i class="ti ti-edit text-xs"></i>
                                        </button>
                                    @endcan

                                    @can('jabatan.delete')
                                        <form method="POST" action="{{ route('jabatan.delete', Crypt::encrypt($d->kode_jabatan)) }}" class="inline-block">
                                             @csrf
                                             @method('DELETE')
                                             <button type="button" 
                                                     class="w-7 h-7 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200/80 flex items-center justify-center transition active:scale-95 btn-delete-jabatan cursor-pointer shadow-2xs"
                                                     data-nama="{{ $d->nama_jabatan }}"
                                                     data-kode="{{ $d->kode_jabatan }}"
                                                     title="Hapus Jabatan">
                                                 <i class="ti ti-trash text-xs"></i>
                                             </button>
                                         </form>
                                     @endcan
                                 </div>
                             </td>
                         </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-12 text-center text-slate-400">
                                <div class="w-14 h-14 rounded-2xl bg-slate-100 border border-slate-200 flex items-center justify-center mx-auto mb-3 text-slate-400 text-2xl">
                                    <i class="ti ti-briefcase-off"></i>
                                </div>
                                <h4 class="text-sm font-bold text-slate-800">Belum Ada Data Jabatan</h4>
                                <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                                    Silakan tambahkan data struktur jabatan baru melalui tombol Tambah Jabatan di atas.
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
<x-modal-form id="modalJabatan" size="modal-md" show="loadmodalJabatan" title="" icon="ti ti-briefcase" />

@endsection

@push('myscript')
<script>
    $(function() {
        const loading = `
            <div class="p-10 text-center bg-white">
                <div class="w-9 h-9 border-3 border-emerald-500 border-t-transparent rounded-full animate-spin mx-auto mb-2.5"></div>
                <div class="text-xs font-bold text-slate-700">Memuat Data Jabatan...</div>
            </div>
        `;

        // Tambah Jabatan Modal
        $("#btnCreateJabatan").click(function(e) {
            e.preventDefault();
            e.stopPropagation();
            $('#modalJabatan').modal("show");
            $("#modalJabatan").find("#loadmodalJabatan").html(loading);
            $("#modalJabatan").find(".modal-title").text("Tambah Data Jabatan Baru");
            $("#loadmodalJabatan").load("{{ route('jabatan.create') }}");
        });

        // Edit Jabatan Modal
        $(document).on('click', '.btnEditJabatan', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const kode_jabatan = $(this).attr('kode_jabatan');
            $('#modalJabatan').modal("show");
            $("#modalJabatan").find("#loadmodalJabatan").html(loading);
            $("#modalJabatan").find(".modal-title").text("Edit Data Jabatan");
            $("#loadmodalJabatan").load(`/jabatan/${kode_jabatan}/edit`);
        });

        // Delete Jabatan with SweetAlert2
        $(document).on('click', '.btn-delete-jabatan', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const form = $(this).closest('form');
            const nama = $(this).data('nama') || 'jabatan ini';
            const kode = $(this).data('kode') || '';

            Swal.fire({
                title: 'Hapus Data Jabatan?',
                html: `
                    <div class="text-xs sm:text-sm text-slate-600 mt-2 space-y-2 text-center">
                        <p>Apakah Anda yakin ingin menghapus struktur jabatan:</p>
                        <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-xl font-bold text-slate-900">
                            ${nama} ${kode ? `<span class="text-xs text-slate-500 font-mono block mt-0.5">Kode: ${kode}</span>` : ''}
                        </div>
                        <p class="text-[11px] text-rose-500 font-semibold">Pastikan tidak ada data karyawan yang masih terkait dengan jabatan ini.</p>
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

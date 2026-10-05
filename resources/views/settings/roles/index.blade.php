@extends('layouts.app')
@section('titlepage', 'Manajemen Role')

@section('content')
<div class="space-y-5">

    <!-- ================= 1. PAGE HEADER WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center border border-emerald-200/80 shadow-2xs">
                    <i class="ti ti-user-check text-2xl"></i>
                </div>
                <span>Data Roles (Peran Pengguna)</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Kelola hak otorisasi peran, penugasan izin modul, dan struktur akses pengguna sistem
            </p>
        </div>

        <!-- Right Side: Breadcrumb Navigation & Action -->
        <div class="flex flex-col md:items-end gap-2.5">
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
                <span class="font-bold text-slate-800">Roles</span>
            </nav>

            <button type="button" id="btncreateRole" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs transition-all duration-200 active:scale-95 cursor-pointer border-0">
                <i class="ti ti-plus text-base"></i>
                <span>Tambah Role</span>
            </button>
        </div>
    </div>

    <!-- ================= 2. SEARCH TOOLBAR ================= -->
    <form action="{{ route('roles.index') }}" method="GET" class="w-full">
        <div class="flex flex-col sm:flex-row items-center gap-2.5 sm:gap-3 w-full">
            <!-- Search Input -->
            <div class="flex-1 min-w-0 w-full relative">
                <i class="ti ti-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-lg pointer-events-none"></i>
                <input type="text" 
                       name="name" 
                       value="{{ request('name') }}" 
                       placeholder="Cari nama role (misal: admin, guru, bendahara)..." 
                       class="w-full pl-11 pr-4 py-2.5 sm:py-3 text-sm bg-white border border-slate-300/90 rounded-xl text-slate-800 font-medium placeholder-slate-400 shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2 shrink-0 w-full sm:w-auto">
                <button type="submit" class="w-full sm:w-auto px-5 py-2.5 sm:py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl shadow-xs transition inline-flex items-center justify-center gap-2 cursor-pointer active:scale-95 whitespace-nowrap border-0">
                    <i class="ti ti-search text-base"></i>
                    <span>Cari</span>
                </button>
                @if(request('name'))
                    <a href="{{ route('roles.index') }}" class="py-2.5 sm:py-3 px-3.5 bg-white hover:bg-slate-100 text-slate-600 border border-slate-300/90 rounded-xl font-semibold text-sm transition inline-flex items-center justify-center shrink-0 shadow-xs" title="Reset Pencarian">
                        <i class="ti ti-refresh text-base"></i>
                    </a>
                @endif
            </div>
        </div>
    </form>

    <!-- ================= 3. CARD TABLE LIST ================= -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
        <!-- Solid Emerald Card Header -->
        <div class="bg-emerald-600 px-4 py-3 sm:px-5 sm:py-3.5 flex items-center justify-between flex-wrap gap-2.5">
            <div class="flex items-center gap-2 text-white">
                <i class="ti ti-user-check text-lg"></i>
                <h2 class="text-sm sm:text-base font-extrabold tracking-tight">
                    Daftar Role Terdaftar
                </h2>
                <span class="px-2 py-0.5 text-[11px] font-bold rounded-full bg-white/20 text-white border border-white/20">
                    {{ $roles->total() }} Role
                </span>
            </div>
        </div>

        <!-- Table Responsive -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700 border-collapse">
                <thead class="bg-emerald-600 text-white uppercase text-[11px] font-extrabold tracking-wider border-t border-emerald-500/50">
                    <tr>
                        <th class="py-2.5 px-3.5 text-center w-12">NO.</th>
                        <th class="py-2.5 px-3.5">NAMA ROLE</th>
                        <th class="py-2.5 px-3.5">GUARD NAME</th>
                        <th class="py-2.5 px-3.5 text-center">TOTAL PERMISSION</th>
                        <th class="py-2.5 px-3.5 text-center w-36">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-[12px]">
                    @forelse ($roles as $d)
                        <tr class="hover:bg-emerald-50/40 transition-colors">
                            <!-- Number -->
                            <td class="py-2.5 px-3.5 text-center font-bold text-slate-500 whitespace-nowrap">
                                {{ $loop->iteration + ($roles->currentPage() - 1) * $roles->perPage() }}
                            </td>

                            <!-- Role Name -->
                            <td class="py-2.5 px-3.5 whitespace-nowrap font-bold text-slate-900">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center font-black text-xs border border-emerald-200">
                                        {{ strtoupper(substr($d->name, 0, 2)) }}
                                    </div>
                                    <span class="text-xs">{{ ucwords($d->name) }}</span>
                                </div>
                            </td>

                            <!-- Guard Name -->
                            <td class="py-2.5 px-3.5 whitespace-nowrap text-slate-600">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-mono font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                                    {{ $d->guard_name }}
                                </span>
                            </td>

                            <!-- Permission Count -->
                            <td class="py-2.5 px-3.5 text-center whitespace-nowrap">
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    <i class="ti ti-shield-check text-xs"></i>
                                    {{ $d->permissions_count ?? $d->permissions->count() }} Izin
                                </span>
                            </td>

                            <!-- Actions -->
                            <td class="py-2.5 px-3.5 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-1.5">
                                    <!-- Set Permission -->
                                    <a href="{{ route('roles.createrolepermission', Crypt::encrypt($d->id)) }}" 
                                        class="w-7 h-7 inline-flex items-center justify-center rounded-lg bg-blue-50 text-blue-700 border border-blue-200 hover:bg-blue-600 hover:text-white transition active:scale-95 shadow-2xs" 
                                        title="Atur Hak Akses / Permission">
                                        <i class="ti ti-shield-lock text-sm"></i>
                                    </a>

                                    <!-- Edit Role Name -->
                                    <button type="button" class="w-7 h-7 inline-flex items-center justify-center rounded-lg bg-amber-50 text-amber-700 border border-amber-200 hover:bg-amber-600 hover:text-white transition active:scale-95 shadow-2xs editRole cursor-pointer" 
                                        id="{{ $d->id }}" 
                                        title="Edit Role">
                                        <i class="ti ti-edit text-sm"></i>
                                    </button>

                                    <!-- Delete Role -->
                                    <form method="POST" name="deleteform" class="deleteform inline" action="{{ route('roles.delete', Crypt::encrypt($d->id)) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="w-7 h-7 inline-flex items-center justify-center rounded-lg bg-rose-50 text-rose-700 border border-rose-200 hover:bg-rose-600 hover:text-white transition active:scale-95 shadow-2xs delete-confirm cursor-pointer" title="Hapus Role">
                                            <i class="ti ti-trash text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400 text-2xl">
                                        <i class="ti ti-user-x"></i>
                                    </div>
                                    <span class="text-xs font-semibold text-slate-500">Tidak ada data role ditemukan</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($roles->hasPages())
            <div class="p-3.5 border-t border-slate-100 bg-slate-50/50">
                {{ $roles->links() }}
            </div>
        @endif
    </div>
</div>

<x-modal-form id="mdlcreateRole" size="" show="loadcreateRole" title="Tambah Role Baru" />
<x-modal-form id="mdleditRole" size="" show="loadeditRole" title="Edit Role" />
@endsection

@push('myscript')
<script>
    $(function() {
        // Modal Trigger Tambah Role
        $("#btncreateRole").click(function(e) {
            e.preventDefault();
            $('#mdlcreateRole').modal("show");
            $("#loadcreateRole").html('<div class="p-8 text-center"><div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-emerald-600 border-t-transparent"></div><p class="text-xs text-slate-500 mt-2 font-medium">Memuat form...</p></div>');
            $("#loadcreateRole").load('/roles/create');
        });

        // Modal Trigger Edit Role
        $(".editRole").click(function(e) {
            e.preventDefault();
            var id = $(this).attr("id");
            $('#mdleditRole').modal("show");
            $("#loadeditRole").html('<div class="p-8 text-center"><div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-emerald-600 border-t-transparent"></div><p class="text-xs text-slate-500 mt-2 font-medium">Memuat form...</p></div>');
            $("#loadeditRole").load('/roles/' + id + '/edit');
        });

        // SweetAlert2 Konfirmasi Hapus
        $('.delete-confirm').click(function(e) {
            e.preventDefault();
            var form = $(this).closest("form");
            Swal.fire({
                title: 'Hapus Role Ini?',
                text: "Role yang dihapus dapat mempengaruhi pengguna yang memiliki peran tersebut!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#064e3b',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    confirmButton: 'px-4 py-2 bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs',
                    cancelButton: 'px-4 py-2 bg-rose-600 text-white font-bold rounded-xl text-xs shadow-xs ms-2'
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

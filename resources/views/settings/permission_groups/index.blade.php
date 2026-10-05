@extends('layouts.app')
@section('titlepage', 'Permission Groups')

@section('content')
<div class="space-y-5">

    <!-- ================= 1. PAGE HEADER WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center border border-emerald-200/80 shadow-2xs">
                    <i class="ti ti-folders text-2xl"></i>
                </div>
                <span>Group Permission (Kelompok Hak Akses)</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Kelola kategori modul dan pengelompokan permission fitur sistem
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
                <span class="font-bold text-slate-800">Permission Groups</span>
            </nav>

            <div class="flex items-center gap-2">
                <a href="{{ route('permissions.index') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2.5 bg-white hover:bg-slate-50 text-slate-700 font-bold rounded-xl text-xs border border-slate-200 shadow-2xs transition active:scale-95">
                    <i class="ti ti-shield-lock text-base text-emerald-600"></i>
                    <span>Item Permission</span>
                </a>
                <button type="button" id="btncreateGroup" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs transition-all duration-200 active:scale-95 cursor-pointer border-0">
                    <i class="ti ti-plus text-base"></i>
                    <span>Tambah Group</span>
                </button>
            </div>
        </div>
    </div>

    <!-- ================= 2. SEARCH TOOLBAR ================= -->
    <form action="{{ route('permissiongroups.index') }}" method="GET" class="w-full">
        <div class="flex flex-col sm:flex-row items-center gap-2.5 sm:gap-3 w-full">
            <!-- Search Input -->
            <div class="flex-1 min-w-0 w-full relative">
                <i class="ti ti-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-lg pointer-events-none"></i>
                <input type="text" 
                       name="name" 
                       value="{{ request('name') }}" 
                       placeholder="Cari nama group permission..." 
                       class="w-full pl-11 pr-4 py-2.5 sm:py-3 text-sm bg-white border border-slate-300/90 rounded-xl text-slate-800 font-medium placeholder-slate-400 shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2 shrink-0 w-full sm:w-auto">
                <button type="submit" class="w-full sm:w-auto px-5 py-2.5 sm:py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl shadow-xs transition inline-flex items-center justify-center gap-2 cursor-pointer active:scale-95 whitespace-nowrap border-0">
                    <i class="ti ti-search text-base"></i>
                    <span>Cari</span>
                </button>
                @if(request('name'))
                    <a href="{{ route('permissiongroups.index') }}" class="py-2.5 sm:py-3 px-3.5 bg-white hover:bg-slate-100 text-slate-600 border border-slate-300/90 rounded-xl font-semibold text-sm transition inline-flex items-center justify-center shrink-0 shadow-xs" title="Reset Pencarian">
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
                <i class="ti ti-folders text-lg"></i>
                <h2 class="text-sm sm:text-base font-extrabold tracking-tight">
                    Daftar Group Permission
                </h2>
                <span class="px-2 py-0.5 text-[11px] font-bold rounded-full bg-white/20 text-white border border-white/20">
                    {{ $permission_groups->total() }} Group
                </span>
            </div>
        </div>

        <!-- Table Responsive -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700 border-collapse">
                <thead class="bg-emerald-600 text-white uppercase text-[11px] font-extrabold tracking-wider border-t border-emerald-500/50">
                    <tr>
                        <th class="py-2.5 px-3.5 text-center w-12">NO.</th>
                        <th class="py-2.5 px-3.5">NAMA GROUP PERMISSION</th>
                        <th class="py-2.5 px-3.5 text-center w-28">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-[12px]">
                    @forelse ($permission_groups as $d)
                        <tr class="hover:bg-emerald-50/40 transition-colors">
                            <!-- Number -->
                            <td class="py-2.5 px-3.5 text-center font-bold text-slate-500 whitespace-nowrap">
                                {{ $loop->iteration + ($permission_groups->currentPage() - 1) * $permission_groups->perPage() }}
                            </td>

                            <!-- Group Name -->
                            <td class="py-2.5 px-3.5 whitespace-nowrap font-bold text-slate-900">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center font-black text-xs border border-emerald-200">
                                        <i class="ti ti-folder"></i>
                                    </div>
                                    <span class="text-xs">{{ $d->name }}</span>
                                </div>
                            </td>

                            <!-- Actions -->
                            <td class="py-2.5 px-3.5 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-1.5">
                                    <!-- Edit -->
                                    <a href="#" class="editGroup w-8 h-8 rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-700 flex items-center justify-center border border-amber-200 shadow-2xs transition active:scale-95"
                                        id="{{ Crypt::encrypt($d->id) }}" title="Edit Group">
                                        <i class="ti ti-edit text-base"></i>
                                    </a>

                                    <!-- Delete -->
                                    <form method="POST" name="deleteform" class="deleteform inline"
                                        action="{{ route('permissiongroups.delete', Crypt::encrypt($d->id)) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-confirm w-8 h-8 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 flex items-center justify-center border border-rose-200 shadow-2xs transition active:scale-95 cursor-pointer" title="Hapus">
                                            <i class="ti ti-trash text-base"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-8 text-center text-slate-400 text-xs">
                                <i class="ti ti-folder-off text-3xl mb-1 block"></i>
                                Tidak ada data group permission yang ditemukan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($permission_groups->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $permission_groups->links() }}
            </div>
        @endif
    </div>
</div>

<x-modal-form id="mdlcreateGroup" size="" show="loadcreateGroup" title="Tambah Group" />
<x-modal-form id="mdleditGroup" size="" show="loadeditGroup" title="Edit Group" />
@endsection

@push('myscript')
<script>
    $(function() {
        $("#btncreateGroup").click(function(e) {
            $('#mdlcreateGroup').modal("show");
            $("#loadcreateGroup").load('/permissiongroups/create');
        });

        $(".editGroup").click(function(e) {
            var id = $(this).attr("id");
            e.preventDefault();
            $('#mdleditGroup').modal("show");
            $("#loadeditGroup").load('/permissiongroups/' + id + '/edit');
        });
    });
</script>
@endpush


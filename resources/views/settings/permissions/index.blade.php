@extends('layouts.app')
@section('titlepage', 'Manajemen Permission')

@section('content')
<div class="space-y-5">

    <!-- ================= 1. PAGE HEADER WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center border border-emerald-200/80 shadow-2xs">
                    <i class="ti ti-shield-lock text-2xl"></i>
                </div>
                <span>Data Permissions (Hak Akses)</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Kelola master item hak akses fitur, sub-modul sistem, dan relasi group permission
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
                <span class="font-bold text-slate-800">Permissions</span>
            </nav>

            <div class="flex items-center gap-2">
                <a href="{{ route('permissiongroups.index') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2.5 bg-white hover:bg-slate-50 text-slate-700 font-bold rounded-xl text-xs border border-slate-200 shadow-2xs transition active:scale-95">
                    <i class="ti ti-folders text-base text-emerald-600"></i>
                    <span>Kelola Group</span>
                </a>
                <button type="button" id="btncreatePermission" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs transition-all duration-200 active:scale-95 cursor-pointer border-0">
                    <i class="ti ti-plus text-base"></i>
                    <span>Tambah Permission</span>
                </button>
            </div>
        </div>
    </div>

    <!-- ================= 2. SEARCH & FILTER TOOLBAR ================= -->
    <form action="{{ route('permissions.index') }}" method="GET" class="w-full">
        <div class="flex flex-col md:flex-row items-center gap-2.5 sm:gap-3 w-full">
            <!-- Search Name Input -->
            <div class="flex-1 min-w-0 w-full relative">
                <i class="ti ti-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-lg pointer-events-none"></i>
                <input type="text" 
                       name="name" 
                       value="{{ request('name') }}" 
                       placeholder="Cari nama permission (misal: users.index, roles.create)..." 
                       class="w-full pl-11 pr-4 py-2.5 sm:py-3 text-sm bg-white border border-slate-300/90 rounded-xl text-slate-800 font-medium placeholder-slate-400 shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
            </div>

            <!-- Group Filter -->
            <div class="w-full md:w-56 lg:w-64 shrink-0">
                <select name="id_permission_group" 
                    class="w-full px-4 py-2.5 sm:py-3 text-sm bg-white border border-slate-300/90 rounded-xl text-slate-800 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                    <option value="">-- Semua Group Modul --</option>
                    @foreach ($permission_groups as $group)
                        <option value="{{ $group->id }}" {{ Request('id_permission_group') == $group->id ? 'selected' : '' }}>
                            {{ $group->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2 shrink-0 w-full md:w-auto">
                <button type="submit" class="w-full md:w-auto px-5 py-2.5 sm:py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl shadow-xs transition inline-flex items-center justify-center gap-2 cursor-pointer active:scale-95 whitespace-nowrap border-0">
                    <i class="ti ti-search text-base"></i>
                    <span>Cari</span>
                </button>
                @if(request('name') || request('id_permission_group'))
                    <a href="{{ route('permissions.index') }}" class="py-2.5 sm:py-3 px-3.5 bg-white hover:bg-slate-100 text-slate-600 border border-slate-300/90 rounded-xl font-semibold text-sm transition inline-flex items-center justify-center shrink-0 shadow-xs" title="Reset Filter">
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
                <i class="ti ti-shield-lock text-lg"></i>
                <h2 class="text-sm sm:text-base font-extrabold tracking-tight">
                    Daftar Item Permission
                </h2>
                <span class="px-2 py-0.5 text-[11px] font-bold rounded-full bg-white/20 text-white border border-white/20">
                    {{ $permissions->total() }} Item
                </span>
            </div>
        </div>

        <!-- Table Responsive -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700 border-collapse">
                <thead class="bg-emerald-600 text-white uppercase text-[11px] font-extrabold tracking-wider border-t border-emerald-500/50">
                    <tr>
                        <th class="py-2.5 px-3.5 text-center w-12">NO.</th>
                        <th class="py-2.5 px-3.5">PERMISSION NAME</th>
                        <th class="py-2.5 px-3.5">GROUP MODUL</th>
                        <th class="py-2.5 px-3.5 text-center w-28">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-[12px]">
                    @forelse ($permissions as $d)
                        <tr class="hover:bg-emerald-50/40 transition-colors">
                            <!-- Number -->
                            <td class="py-2.5 px-3.5 text-center font-bold text-slate-500 whitespace-nowrap">
                                {{ $loop->iteration + ($permissions->currentPage() - 1) * $permissions->perPage() }}
                            </td>

                            <!-- Permission Name -->
                            <td class="py-2.5 px-3.5 whitespace-nowrap font-bold text-slate-900">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-md bg-emerald-50 text-emerald-700 flex items-center justify-center font-bold text-xs border border-emerald-200">
                                        <i class="ti ti-key text-xs"></i>
                                    </div>
                                    <code class="text-xs font-semibold text-emerald-800 bg-emerald-50/70 px-2 py-0.5 rounded-md border border-emerald-200/60">
                                        {{ strtolower($d->name) }}
                                    </code>
                                </div>
                            </td>

                            <!-- Group Name -->
                            <td class="py-2.5 px-3.5 whitespace-nowrap">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                                    <i class="ti ti-folder text-slate-500"></i>
                                    {{ $d->group_name ?? '-' }}
                                </span>
                            </td>

                            <!-- Actions -->
                            <td class="py-2.5 px-3.5 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-1.5">
                                    <!-- Edit -->
                                    <a href="#" class="editPermission w-8 h-8 rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-700 flex items-center justify-center border border-amber-200 shadow-2xs transition active:scale-95"
                                        id="{{ Crypt::encrypt($d->id) }}" title="Edit Permission">
                                        <i class="ti ti-edit text-base"></i>
                                    </a>

                                    <!-- Delete -->
                                    <form method="POST" name="deleteform" class="deleteform inline"
                                        action="{{ route('permissions.delete', Crypt::encrypt($d->id)) }}">
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
                            <td colspan="4" class="py-8 text-center text-slate-400 text-xs">
                                <i class="ti ti-folder-off text-3xl mb-1 block"></i>
                                Tidak ada data permission yang ditemukan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($permissions->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $permissions->links() }}
            </div>
        @endif
    </div>
</div>

<x-modal-form id="mdlcreatePermission" size="" show="loadcreatePermission" title="Tambah Permission" />
<x-modal-form id="mdleditPermission" size="" show="loadeditPermission" title="Edit Permission" />
@endsection

@push('myscript')
<script>
    $(function() {
        $("#btncreatePermission").click(function(e) {
            $('#mdlcreatePermission').modal("show");
            $("#loadcreatePermission").load('/permissions/create');
        });

        $(".editPermission").click(function(e) {
            var id = $(this).attr("id");
            e.preventDefault();
            $('#mdleditPermission').modal("show");
            $("#loadeditPermission").load('/permissions/' + id + '/edit');
        });
    });
</script>
@endpush


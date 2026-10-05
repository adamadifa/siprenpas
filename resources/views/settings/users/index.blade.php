@extends('layouts.app')
@section('titlepage', 'Manajemen User')

@section('content')
<div class="space-y-5">

    <!-- ================= 1. PAGE HEADER (NO CARD) WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center border border-emerald-200/80 shadow-2xs">
                    <i class="ti ti-users text-2xl"></i>
                </div>
                <span>Data Pengguna (Users)</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Kelola akun autentikasi, hak akses role, unit departemen, dan permission khusus pengguna sistem
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
                <span class="font-bold text-slate-800">Users</span>
            </nav>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center gap-2">
                <form action="{{ route('users.reset-password-siswa') }}" method="POST" id="formResetPasswordSiswa" class="inline">
                    @csrf
                    <button type="button" id="btnResetPasswordSiswa" class="inline-flex items-center gap-2 px-3.5 py-2.5 bg-amber-50 hover:bg-amber-100 text-amber-800 font-bold rounded-xl text-xs border border-amber-200/80 shadow-2xs transition-all duration-200 active:scale-95 cursor-pointer">
                        <i class="ti ti-key text-base text-amber-600"></i>
                        <span>Reset Password Siswa</span>
                    </button>
                </form>

                <button type="button" id="btncreateUser" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs transition-all duration-200 active:scale-95 cursor-pointer border-0">
                    <i class="ti ti-plus text-base"></i>
                    <span>Tambah User</span>
                </button>
            </div>
        </div>
    </div>

    <!-- ================= 2. FILTER & SEARCH TOOLBAR ================= -->
    <form action="{{ route('users.index') }}" method="GET" class="w-full">
        <!-- Preserve Other Filters -->
        @if(request('role'))
            <input type="hidden" name="role" value="{{ request('role') }}">
        @endif
        @if(request('status'))
            <input type="hidden" name="status" value="{{ request('status') }}">
        @endif

        <div class="flex flex-col sm:flex-row items-center gap-2.5 sm:gap-3 w-full">
            <!-- Search Name / Username / Email -->
            <div class="flex-1 min-w-0 w-full relative">
                <i class="ti ti-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-lg pointer-events-none"></i>
                <input type="text" 
                       name="name" 
                       value="{{ Request('name') }}" 
                       placeholder="Cari nama lengkap, username, atau email..." 
                       class="w-full pl-11 pr-4 py-2.5 sm:py-3 text-sm bg-white border border-slate-300/90 rounded-xl text-slate-800 font-medium placeholder-slate-400 shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2 shrink-0 w-full sm:w-auto">
                <button type="submit" class="w-full sm:w-auto px-5 py-2.5 sm:py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl shadow-xs transition inline-flex items-center justify-center gap-2 cursor-pointer active:scale-95 whitespace-nowrap">
                    <i class="ti ti-search text-base"></i>
                    <span>Cari</span>
                </button>
                @if(request()->filled('name') || request()->filled('role') || request()->filled('status'))
                    <a href="{{ route('users.index') }}" class="py-2.5 sm:py-3 px-3.5 bg-white hover:bg-slate-100 text-slate-600 border border-slate-300/90 rounded-xl font-semibold text-sm transition inline-flex items-center justify-center shrink-0 shadow-xs" title="Reset Semua Filter">
                        <i class="ti ti-refresh text-base"></i>
                    </a>
                @endif
            </div>
        </div>
    </form>

    <!-- ================= 3. SOLID EMERALD TABLE CARD ================= -->
    <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
        <!-- Solid Emerald Header with Filter Tabs -->
        <div class="bg-emerald-600 px-5 py-3.5 flex flex-col md:flex-row md:items-center justify-between gap-3 text-white">
            <div class="flex items-center gap-2.5">
                <i class="ti ti-users text-xl"></i>
                <h3 class="font-bold text-sm tracking-wide text-white">Daftar Pengguna Sistem</h3>
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-bold bg-white/20 text-white backdrop-blur-xs ml-1">
                    {{ $users->total() }} User
                </span>
            </div>

            <!-- Filter Pills (Status & Category) -->
            <div class="flex items-center gap-3 flex-wrap text-xs">
                <!-- Status Filter Pills -->
                <div class="flex items-center gap-1 bg-emerald-700/80 p-1 rounded-xl border border-emerald-500/50">
                    <span class="text-[10px] font-extrabold uppercase px-1.5 text-emerald-200">Status:</span>
                    <a href="{{ route('users.index', array_merge(request()->query(), ['status' => ''])) }}" 
                       class="px-2.5 py-1 rounded-lg font-bold text-[11px] transition {{ empty(request('status')) ? 'bg-white text-emerald-800 shadow-2xs' : 'text-emerald-100 hover:bg-emerald-600/60' }}">
                        Semua
                    </a>
                    <a href="{{ route('users.index', array_merge(request()->query(), ['status' => 'aktif'])) }}" 
                       class="px-2.5 py-1 rounded-lg font-bold text-[11px] transition {{ request('status') == 'aktif' ? 'bg-white text-emerald-800 shadow-2xs' : 'text-emerald-100 hover:bg-emerald-600/60' }}">
                        Aktif
                    </a>
                    <a href="{{ route('users.index', array_merge(request()->query(), ['status' => 'nonaktif'])) }}" 
                       class="px-2.5 py-1 rounded-lg font-bold text-[11px] transition {{ request('status') == 'nonaktif' ? 'bg-white text-emerald-800 shadow-2xs' : 'text-emerald-100 hover:bg-emerald-600/60' }}">
                        Nonaktif
                    </a>
                </div>

                <!-- Kategori Role Filter Pills -->
                <div class="flex items-center gap-1 bg-emerald-700/80 p-1 rounded-xl border border-emerald-500/50">
                    <span class="text-[10px] font-extrabold uppercase px-1.5 text-emerald-200">Kategori:</span>
                    <a href="{{ route('users.index', array_merge(request()->query(), ['role' => ''])) }}" 
                       class="px-2.5 py-1 rounded-lg font-bold text-[11px] transition {{ empty(request('role')) ? 'bg-white text-emerald-800 shadow-2xs' : 'text-emerald-100 hover:bg-emerald-600/60' }}">
                        Semua
                    </a>
                    <a href="{{ route('users.index', array_merge(request()->query(), ['role' => 'karyawan'])) }}" 
                       class="px-2.5 py-1 rounded-lg font-bold text-[11px] transition {{ request('role') == 'karyawan' ? 'bg-white text-emerald-800 shadow-2xs' : 'text-emerald-100 hover:bg-emerald-600/60' }}">
                        Karyawan
                    </a>
                    <a href="{{ route('users.index', array_merge(request()->query(), ['role' => 'lainnya'])) }}" 
                       class="px-2.5 py-1 rounded-lg font-bold text-[11px] transition {{ request('role') == 'lainnya' ? 'bg-white text-emerald-800 shadow-2xs' : 'text-emerald-100 hover:bg-emerald-600/60' }}">
                        Lainnya
                    </a>
                </div>
            </div>
        </div>

        <!-- Table Container -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse whitespace-nowrap">
                <thead>
                    <tr class="bg-emerald-600 text-white uppercase text-[11px] font-extrabold tracking-wider border-t border-emerald-500/50">
                        <th class="py-2.5 px-3.5 w-12 text-center whitespace-nowrap">NO</th>
                        <th class="py-2.5 px-4 whitespace-nowrap">NAMA PENGGUNA</th>
                        <th class="py-2.5 px-4 whitespace-nowrap">USERNAME</th>
                        <th class="py-2.5 px-4 whitespace-nowrap">EMAIL</th>
                        <th class="py-2.5 px-3.5 text-center whitespace-nowrap">ROLE</th>
                        <th class="py-2.5 px-4 whitespace-nowrap">UNIT UTAMA</th>
                        <th class="py-2.5 px-4 whitespace-nowrap">DEPARTEMEN</th>
                        <th class="py-2.5 px-3.5 text-center whitespace-nowrap">STATUS</th>
                        <th class="py-2.5 px-3.5 text-center w-36 whitespace-nowrap">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                    @forelse ($users as $d)
                        <tr class="hover:bg-slate-50/80 transition-colors group">
                            <!-- No -->
                            <td class="py-2.5 px-3.5 text-center font-bold text-slate-400 whitespace-nowrap">
                                {{ $loop->iteration + $users->firstItem() - 1 }}
                            </td>

                            <!-- Nama -->
                            <td class="py-2.5 px-4 whitespace-nowrap">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 rounded-full bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold text-xs uppercase shrink-0 border border-emerald-200/80">
                                        {{ substr($d->name, 0, 1) }}
                                    </div>
                                    <span class="font-bold text-slate-900 group-hover:text-emerald-700 transition-colors">
                                        {{ $d->name }}
                                    </span>
                                </div>
                            </td>

                            <!-- Username -->
                            <td class="py-2.5 px-4 whitespace-nowrap font-mono text-[11px] text-slate-600">
                                {{ $d->username }}
                            </td>

                            <!-- Email -->
                            <td class="py-2.5 px-4 whitespace-nowrap text-slate-500 font-mono text-[11px]">
                                {{ $d->email ?: '-' }}
                            </td>

                            <!-- Roles -->
                            <td class="py-2.5 px-3.5 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-1 flex-wrap">
                                    @forelse ($d->roles as $role)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-bold bg-sky-50 text-sky-800 border border-sky-200/80">
                                            {{ ucwords($role->name) }}
                                        </span>
                                    @empty
                                        <span class="text-slate-400 italic text-[11px]">No Role</span>
                                    @endforelse
                                </div>
                            </td>

                            <!-- Unit -->
                            <td class="py-2.5 px-4 whitespace-nowrap">
                                <span class="font-medium text-slate-700">{{ $d->nama_unit ?? '-' }}</span>
                            </td>

                            <!-- Dept -->
                            <td class="py-2.5 px-4 whitespace-nowrap">
                                <span class="text-slate-600">{{ $d->nama_dept ?? '-' }}</span>
                            </td>

                            <!-- Status -->
                            <td class="py-2.5 px-3.5 text-center whitespace-nowrap">
                                <a href="{{ route('users.updatestatus', Crypt::encrypt($d->id)) }}" title="Klik untuk mengubah status">
                                    @if ($d->status == 1)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-300/80 hover:bg-emerald-200 transition">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                            <span>Aktif</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-rose-100 text-rose-800 border border-rose-300/80 hover:bg-rose-200 transition">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                            <span>Nonaktif</span>
                                        </span>
                                    @endif
                                </a>
                            </td>

                            <!-- Aksi -->
                            <td class="py-2.5 px-3.5 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-1">
                                    <!-- View As / Impersonate -->
                                    @if ($d->id !== auth()->id())
                                        <a href="{{ route('users.impersonate', Crypt::encrypt($d->id)) }}" 
                                           class="w-7 h-7 rounded-lg bg-sky-50 hover:bg-sky-100 text-sky-700 flex items-center justify-center transition active:scale-95 border border-sky-200/60"
                                           title="Masuk Sebagai (View As)">
                                            <i class="ti ti-eye text-sm"></i>
                                        </a>
                                    @endif

                                    <!-- Akses Unit & Dept -->
                                    <a href="{{ route('users.createuserunitdept', Crypt::encrypt($d->id)) }}"
                                       class="w-7 h-7 rounded-lg bg-indigo-50 hover:bg-indigo-100 text-indigo-700 flex items-center justify-center transition active:scale-95 border border-indigo-200/60"
                                       title="Akses Unit & Departemen">
                                        <i class="ti ti-building-community text-sm"></i>
                                    </a>

                                    <!-- Permission Khusus -->
                                    <a href="{{ route('users.createuserpermission', Crypt::encrypt($d->id)) }}"
                                       class="w-7 h-7 rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-700 flex items-center justify-center transition active:scale-95 border border-amber-200/60"
                                       title="Set Permission Khusus">
                                        <i class="ti ti-shield-lock text-sm"></i>
                                    </a>

                                    <!-- Edit -->
                                    @can('users.edit')
                                        <button type="button" 
                                                class="w-7 h-7 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 flex items-center justify-center transition active:scale-95 editUser cursor-pointer border border-emerald-200/60" 
                                                id="{{ Crypt::encrypt($d->id) }}"
                                                title="Edit User">
                                            <i class="ti ti-pencil text-sm"></i>
                                        </button>
                                    @endcan

                                    <!-- Delete -->
                                    @can('users.delete')
                                        <form method="POST" action="{{ route('users.delete', Crypt::encrypt($d->id)) }}" class="inline deleteform">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" 
                                                    class="w-7 h-7 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 flex items-center justify-center transition active:scale-95 delete-confirm cursor-pointer border border-rose-200/60" 
                                                    data-nama="{{ $d->name }}"
                                                    title="Hapus User">
                                                <i class="ti ti-trash text-sm"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="py-12 px-4 text-center">
                                <div class="w-16 h-16 mx-auto mb-3 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-3xl">
                                    <i class="ti ti-users-minus"></i>
                                </div>
                                <h4 class="font-bold text-slate-800 text-sm">Belum Ada Data User</h4>
                                <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">
                                    Tidak ditemukan pengguna yang sesuai dengan kriteria pencarian atau filter yang dipilih.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Footer -->
        @if($users->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $users->links() }}
            </div>
        @endif
    </div>

</div>

<x-modal-form id="mdlcreateUser" size="" show="loadcreateUser" title="Tambah User Baru" />
<x-modal-form id="mdleditUser" size="" show="loadeditUser" title="Edit Data Pengguna" />
@endsection

@push('myscript')
<script>
    $(function() {
        $("#btncreateUser").click(function(e) {
            e.preventDefault();
            $('#mdlcreateUser').modal("show");
            $("#loadcreateUser").html(`
                <div class="py-10 text-center">
                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-emerald-500 border-t-transparent"></div>
                    <p class="text-xs text-slate-500 mt-2 font-medium">Memuat form user...</p>
                </div>
            `);
            $("#loadcreateUser").load('/users/create');
        });

        $(".editUser").click(function(e) {
            e.preventDefault();
            var id = $(this).attr("id");
            $('#mdleditUser').modal("show");
            $("#loadeditUser").html(`
                <div class="py-10 text-center">
                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-emerald-500 border-t-transparent"></div>
                    <p class="text-xs text-slate-500 mt-2 font-medium">Memuat data user...</p>
                </div>
            `);
            $("#loadeditUser").load('/users/' + id + '/edit');
        });

        $(document).on('click', '.delete-confirm', function(e) {
            e.preventDefault();
            const form = $(this).closest('form');
            const nama = $(this).data('nama') || 'user ini';

            Swal.fire({
                title: 'Hapus User?',
                text: `Apakah Anda yakin ingin menghapus akun "${nama}"? Tindakan ini tidak dapat dibatalkan!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-2xl shadow-xl border border-slate-100',
                    confirmButton: 'px-4 py-2 font-bold rounded-xl text-xs',
                    cancelButton: 'px-4 py-2 font-bold rounded-xl text-xs'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

        $("#btnResetPasswordSiswa").click(function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Reset Password Seluruh Siswa?',
                text: "Semua akun pengguna dengan role Siswa akan di-reset kata sandinya menjadi 12345678!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d97706',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Reset Semua!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-2xl shadow-xl border border-slate-100',
                    confirmButton: 'px-5 py-2 font-bold rounded-xl text-xs',
                    cancelButton: 'px-5 py-2 font-bold rounded-xl text-xs'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#btnResetPasswordSiswa").prop('disabled', true).addClass('opacity-75 cursor-not-allowed').html(`
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-amber-800 inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>Memproses Reset...</span>
                    `);
                    $("#formResetPasswordSiswa").submit();
                }
            });
        });
    });
</script>
@endpush


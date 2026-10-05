@extends('layouts.app')
@section('titlepage', 'Data Anggota Koperasi')

@section('content')
<div class="space-y-5">

    <!-- ================= 1. PAGE HEADER (NO CARD) WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <i class="ti ti-users text-emerald-600 text-2xl"></i>
                <span>Data Anggota Koperasi</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Manajemen keanggotaan koperasi, afiliasi santri/karyawan, dan rekening simpan pinjam
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
                    <i class="ti ti-building-bank text-sm"></i>
                    <span>Koperasi</span>
                </span>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Anggota</span>
            </nav>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center gap-2">
                @can('anggota.create')
                    <button type="button" id="btncreateAnggota" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg text-xs shadow-xs transition-all duration-200 active:scale-95 cursor-pointer">
                        <i class="ti ti-plus text-base"></i>
                        <span>Tambah Anggota</span>
                    </button>
                @endcan
            </div>
        </div>
    </div>

    <!-- ================= 2. FILTER & SEARCH TOOLBAR ================= -->
    <form action="{{ route('anggota.index') }}" method="GET" class="w-full">
        <div class="flex flex-col sm:flex-row items-center gap-2.5 sm:gap-3 w-full">
            <!-- Search Input -->
            <div class="flex-1 min-w-0 w-full relative">
                <i class="ti ti-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-lg pointer-events-none"></i>
                <input type="text" 
                       name="nama_lengkap" 
                       value="{{ Request('nama_lengkap') }}" 
                       placeholder="Cari Nama Anggota, NIK, No. Anggota, atau No. HP..." 
                       class="w-full pl-11 pr-4 py-2.5 sm:py-3 text-sm bg-white border border-slate-300/90 rounded-lg text-slate-800 font-medium placeholder-slate-400 shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2 shrink-0 w-full sm:w-auto">
                <button type="submit" class="w-full sm:w-auto px-5 py-2.5 sm:py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-lg shadow-xs transition inline-flex items-center justify-center gap-2 cursor-pointer active:scale-95 whitespace-nowrap">
                    <i class="ti ti-search text-base"></i>
                    <span>Cari</span>
                </button>
                @if(Request('nama_lengkap'))
                    <a href="{{ route('anggota.index') }}" class="py-2.5 sm:py-3 px-3 bg-white hover:bg-slate-100 text-slate-600 border border-slate-300/90 rounded-lg font-semibold text-sm transition inline-flex items-center justify-center shrink-0 shadow-xs" title="Reset Pencarian">
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
                    <i class="ti ti-users"></i>
                </div>
                <h3 class="text-sm font-extrabold text-white tracking-tight">Daftar Anggota Koperasi</h3>
                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-white/20 text-white border border-white/30 shadow-2xs backdrop-blur-xs">
                    {{ $anggota->total() }} data
                </span>
            </div>
            <div class="text-xs text-emerald-100 font-medium">
                Data master keanggotaan unit koperasi pesantren
            </div>
        </div>

        <!-- Responsive Table Container with Max Width & No Wrapping -->
        <div class="overflow-x-auto bg-emerald-600">
            <table class="w-full text-left text-xs sm:text-sm border-0 border-collapse whitespace-nowrap">
                <!-- Matching Solid Green Table Header -->
                <thead class="bg-emerald-600 text-white font-bold uppercase tracking-wider text-[11px] border-0 border-t-0 border-b border-emerald-700/80">
                    <tr class="border-0 border-t-0">
                        <th class="py-2.5 px-3 w-10 text-center text-emerald-100 border-0 border-t-0 whitespace-nowrap">No</th>
                        <th class="py-2.5 px-3 text-emerald-100 border-0 border-t-0 whitespace-nowrap">No. Anggota</th>
                        <th class="py-2.5 px-3 text-emerald-100 border-0 border-t-0 whitespace-nowrap">Nama Lengkap</th>
                        <th class="py-2.5 px-3 text-emerald-100 border-0 border-t-0 whitespace-nowrap">NIK</th>
                        <th class="py-2.5 px-3 text-emerald-100 border-0 border-t-0 whitespace-nowrap">Tempat, Tanggal Lahir</th>
                        <th class="py-2.5 px-3 text-emerald-100 border-0 border-t-0 whitespace-nowrap">No. HP / WA</th>
                        <th class="py-2.5 px-3 text-emerald-100 border-0 border-t-0 whitespace-nowrap">Siswa Terkait</th>
                        <th class="py-2.5 px-3 text-emerald-100 border-0 border-t-0 whitespace-nowrap">Karyawan Terkait</th>
                        <th class="py-2.5 px-3 text-center w-36 text-emerald-100 border-0 border-t-0 whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700 font-medium bg-white text-xs">
                    @forelse ($anggota as $d)
                        <tr class="hover:bg-slate-50/80 transition-colors group">
                            <!-- No Index -->
                            <td class="py-2 px-3 text-center text-slate-400 font-bold whitespace-nowrap">
                                <span class="w-5.5 h-5.5 rounded-md bg-slate-100 group-hover:bg-emerald-50 group-hover:text-emerald-700 group-hover:border group-hover:border-emerald-200 inline-flex items-center justify-center font-bold text-slate-600 transition text-[11px]">
                                    {{ $loop->iteration + $anggota->firstItem() - 1 }}
                                </span>
                            </td>

                            <!-- No. Anggota -->
                            <td class="py-2 px-3 whitespace-nowrap">
                                <span class="px-2 py-0.5 rounded-md text-[11px] font-black font-mono tracking-wider bg-emerald-50 text-emerald-800 border border-emerald-200/80 shadow-2xs">
                                    {{ $d->no_anggota }}
                                </span>
                            </td>

                            <!-- Nama Lengkap -->
                            <td class="py-2 px-3 whitespace-nowrap">
                                <a href="{{ route('anggota.show', Crypt::encrypt($d->no_anggota)) }}" 
                                   class="font-bold text-slate-900 uppercase hover:text-emerald-700 transition">
                                    {{ $d->nama_lengkap }}
                                </a>
                            </td>

                            <!-- NIK -->
                            <td class="py-2 px-3 font-mono text-slate-600 whitespace-nowrap">
                                {{ $d->nik ?: '-' }}
                            </td>

                            <!-- TTL -->
                            <td class="py-2 px-3 text-slate-700 whitespace-nowrap">
                                {{ $d->tempat_lahir ? $d->tempat_lahir . ', ' : '' }}{{ $d->tanggal_lahir ? date('d/m/Y', strtotime($d->tanggal_lahir)) : '-' }}
                            </td>

                            <!-- No. HP / WA -->
                            <td class="py-2 px-3 font-mono text-slate-700 whitespace-nowrap">
                                @if ($d->no_hp)
                                    <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $d->no_hp)) }}" 
                                       target="_blank" 
                                       class="inline-flex items-center gap-1.5 text-emerald-700 font-semibold hover:underline">
                                        <i class="ti ti-brand-whatsapp text-emerald-600 text-sm"></i>
                                        <span>{{ $d->no_hp }}</span>
                                    </a>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>

                            <!-- Siswa Terkait -->
                            <td class="py-2 px-3 whitespace-nowrap">
                                @if ($d->siswa && $d->siswa->count() > 0)
                                    <div class="inline-flex items-center gap-1">
                                        @foreach ($d->siswa as $siswa)
                                            <span class="px-2 py-0.5 rounded-md text-[11px] font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200/80">
                                                {{ textUpperCase($siswa->nama_lengkap) }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-slate-400 italic">Belum ada</span>
                                @endif
                            </td>

                            <!-- Karyawan Terkait -->
                            <td class="py-2 px-3 whitespace-nowrap">
                                @if ($d->karyawan && $d->karyawan->count() > 0)
                                    <div class="inline-flex items-center gap-1">
                                        @foreach ($d->karyawan as $karyawan)
                                            <span class="px-2 py-0.5 rounded-md text-[11px] font-semibold bg-indigo-50 text-indigo-800 border border-indigo-200/80">
                                                {{ textUpperCase($karyawan->nama_lengkap) }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-slate-400 italic">Belum ada</span>
                                @endif
                            </td>

                            <!-- Action Buttons -->
                            <td class="py-2 px-3 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-1">
                                    <!-- Detail -->
                                    <a href="{{ route('anggota.show', Crypt::encrypt($d->no_anggota)) }}" 
                                       class="w-6.5 h-6.5 rounded-lg bg-sky-50 hover:bg-sky-100 text-sky-700 border border-sky-200/80 flex items-center justify-center transition active:scale-95 cursor-pointer shadow-2xs"
                                       title="Detail Anggota">
                                        <i class="ti ti-file-description text-xs"></i>
                                    </a>

                                    <!-- Edit -->
                                    @can('anggota.edit')
                                        <button type="button" 
                                                class="btnEditAnggota w-6.5 h-6.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200/80 flex items-center justify-center transition active:scale-95 cursor-pointer shadow-2xs"
                                                no_anggota="{{ Crypt::encrypt($d->no_anggota) }}"
                                                title="Edit Anggota">
                                            <i class="ti ti-edit text-xs"></i>
                                        </button>
                                    @endcan

                                    <!-- Hubungkan Siswa -->
                                    <button type="button" 
                                            class="btnHubungkanSiswa w-6.5 h-6.5 rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200/80 flex items-center justify-center transition active:scale-95 cursor-pointer shadow-2xs"
                                            no_anggota="{{ Crypt::encrypt($d->no_anggota) }}"
                                            title="Hubungkan Siswa">
                                        <i class="ti ti-school text-xs"></i>
                                    </button>

                                    <!-- Hubungkan Karyawan -->
                                    <button type="button" 
                                            class="btnHubungkanKaryawan w-6.5 h-6.5 rounded-lg bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200/80 flex items-center justify-center transition active:scale-95 cursor-pointer shadow-2xs"
                                            no_anggota="{{ Crypt::encrypt($d->no_anggota) }}"
                                            title="Hubungkan Karyawan">
                                        <i class="ti ti-user-check text-xs"></i>
                                    </button>

                                    <!-- Delete -->
                                    @can('anggota.delete')
                                        <form method="POST" 
                                              action="{{ route('anggota.delete', Crypt::encrypt($d->no_anggota)) }}" 
                                              class="inline-block deleteform m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" 
                                                    class="delete-confirm w-6.5 h-6.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200/80 flex items-center justify-center transition active:scale-95 cursor-pointer shadow-2xs"
                                                    title="Hapus Anggota">
                                                <i class="ti ti-trash text-xs"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="py-12 text-center text-slate-400 bg-white">
                                <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3 text-2xl">
                                    <i class="ti ti-users-minus"></i>
                                </div>
                                <h4 class="text-sm font-bold text-slate-700">Belum Ada Data Anggota</h4>
                                <p class="text-xs text-slate-400 mt-1">Data anggota koperasi belum ditambahkan atau tidak sesuai filter.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Footer -->
        @if ($anggota->hasPages() || $anggota->total() > 0)
            <div class="px-4 py-3 border-t border-slate-200/80 bg-slate-50/50 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
                <div>
                    Menampilkan <span class="font-bold text-slate-700">{{ $anggota->firstItem() ?? 0 }}</span> - <span class="font-bold text-slate-700">{{ $anggota->lastItem() ?? 0 }}</span> dari <span class="font-bold text-slate-700">{{ $anggota->total() }}</span> data
                </div>
                <div>
                    {{ $anggota->links() }}
                </div>
            </div>
        @endif

    </div>

</div>

<!-- Modal Form Create & Edit (Dynamic Modal) -->
<x-modal-form id="mdlAnggota" size="modal-xl" show="loadmodalAnggota" title="" icon="ti ti-users" />

<!-- Modal Hubungkan Siswa -->
<div class="modal fade" id="mdlHubungkanSiswa" tabindex="-1" aria-labelledby="mdlHubungkanSiswaLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border border-slate-200/90 shadow-2xl rounded-2xl bg-white overflow-hidden">
            <!-- Modal Header -->
            <div class="px-6 py-4 bg-white border-b border-slate-200/90 flex items-center justify-between text-slate-900">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-100 flex items-center justify-center text-base shrink-0 font-bold">
                        <i class="ti ti-school"></i>
                    </div>
                    <div>
                        <h5 class="modal-title text-base font-bold text-slate-900 tracking-tight truncate mb-0" id="mdlHubungkanSiswaLabel">Hubungkan Santri / Siswa</h5>
                        <p class="text-[11px] text-slate-500 mb-0">Relasikan akun anggota koperasi dengan data santri terdaftar</p>
                    </div>
                </div>
                <button type="button" class="w-8 h-8 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 flex items-center justify-center transition-colors cursor-pointer shrink-0" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti ti-x text-lg"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body p-6 bg-white space-y-5">
                <!-- 1. Form Hubungkan Santri Baru -->
                <div class="bg-slate-50/80 border border-slate-200/90 rounded-xl p-4 sm:p-5 space-y-3.5">
                    <div class="flex items-center gap-2.5 pb-2.5 border-b border-slate-200/80">
                        <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-sm font-bold shadow-2xs">
                            <i class="ti ti-link"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-900 leading-tight">1. Tambah Relasi Santri</h3>
                            <p class="text-[11px] text-slate-500">Pilih santri untuk direlasikan dengan akun anggota ini</p>
                        </div>
                    </div>

                    <form id="formHubungkanSiswa" class="space-y-3">
                        <input type="hidden" id="no_anggota_hidden" name="no_anggota">

                        <div class="space-y-1.5">
                            <label for="id_siswa" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                                <i class="ti ti-school text-sm text-slate-400"></i>
                                <span>Pilih Santri / Siswa <span class="text-rose-500 font-bold">*</span></span>
                            </label>
                            <div class="flex flex-col sm:flex-row gap-2.5 items-stretch sm:items-center">
                                <div class="relative flex-1 min-w-0">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 z-10">
                                        <i class="ti ti-school text-base"></i>
                                    </div>
                                    <select class="form-select select2 w-full" id="id_siswa" name="id_siswa" required>
                                        <option value="">-- Cari Nama Siswa / ID --</option>
                                    </select>
                                </div>
                                <button type="button" 
                                        class="inline-flex items-center justify-center gap-2 px-5 h-[42px] bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs transition active:scale-95 cursor-pointer shrink-0" 
                                        id="btnSimpanHubungan">
                                    <i class="ti ti-link text-sm"></i>
                                    <span>Hubungkan Santri</span>
                                </button>
                            </div>
                        </div>

                        <div class="p-3 bg-emerald-50/70 border border-emerald-200/80 rounded-xl flex items-start gap-2 text-xs text-emerald-900">
                            <i class="ti ti-info-circle text-emerald-600 text-base shrink-0 mt-0.5"></i>
                            <span>Satu anggota koperasi dapat terhubung dengan beberapa santri (misal: orang tua / wali santri).</span>
                        </div>
                    </form>
                </div>

                <!-- 2. Daftar Santri Yang Sudah Terhubung -->
                <div class="bg-slate-50/80 border border-slate-200/90 rounded-xl p-4 sm:p-5 space-y-3.5">
                    <div class="flex items-center justify-between pb-2.5 border-b border-slate-200/80">
                        <div class="flex items-center gap-2.5">
                            <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-sm font-bold shadow-2xs">
                                <i class="ti ti-list-check"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-900 leading-tight">2. Santri Yang Sudah Terhubung</h3>
                                <p class="text-[11px] text-slate-500">Daftar santri yang saat ini terhubung dengan anggota</p>
                            </div>
                        </div>
                    </div>

                    <div id="siswa-terhubung" class="space-y-2.5 max-h-64 overflow-y-auto pr-1">
                        <!-- Dynamic list of connected students -->
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="px-6 py-3.5 bg-white border-t border-slate-200/90 flex justify-end">
                <button type="button" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer active:scale-95" data-bs-dismiss="modal">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Hubungkan Karyawan -->
<div class="modal fade" id="mdlHubungkanKaryawan" tabindex="-1" aria-labelledby="mdlHubungkanKaryawanLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border border-slate-200/90 shadow-2xl rounded-2xl bg-white overflow-hidden">
            <!-- Modal Header -->
            <div class="px-6 py-4 bg-white border-b border-slate-200/90 flex items-center justify-between text-slate-900">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-700 border border-indigo-100 flex items-center justify-center text-base shrink-0 font-bold">
                        <i class="ti ti-briefcase"></i>
                    </div>
                    <div>
                        <h5 class="modal-title text-base font-bold text-slate-900 tracking-tight truncate mb-0" id="mdlHubungkanKaryawanLabel">Hubungkan Guru / Karyawan</h5>
                        <p class="text-[11px] text-slate-500 mb-0">Relasikan anggota koperasi dengan data pegawai/karyawan terdaftar</p>
                    </div>
                </div>
                <button type="button" class="w-8 h-8 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 flex items-center justify-center transition-colors cursor-pointer shrink-0" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti ti-x text-lg"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body p-6 bg-white space-y-5">
                <!-- 1. Form Hubungkan Karyawan Baru -->
                <div class="bg-slate-50/80 border border-slate-200/90 rounded-xl p-4 sm:p-5 space-y-3.5">
                    <div class="flex items-center gap-2.5 pb-2.5 border-b border-slate-200/80">
                        <div class="w-7 h-7 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center text-sm font-bold shadow-2xs">
                            <i class="ti ti-link"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-900 leading-tight">1. Tambah Relasi Karyawan</h3>
                            <p class="text-[11px] text-slate-500">Pilih pegawai untuk direlasikan dengan akun anggota ini</p>
                        </div>
                    </div>

                    <form id="formHubungkanKaryawan" class="space-y-3">
                        <input type="hidden" id="no_anggota_hidden_karyawan" name="no_anggota">

                        <div class="space-y-1.5">
                            <label for="npp" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                                <i class="ti ti-briefcase text-sm text-slate-400"></i>
                                <span>Pilih Pegawai / Karyawan <span class="text-rose-500 font-bold">*</span></span>
                            </label>
                            <div class="flex flex-col sm:flex-row gap-2.5 items-stretch sm:items-center">
                                <div class="relative flex-1 min-w-0">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 z-10">
                                        <i class="ti ti-briefcase text-base"></i>
                                    </div>
                                    <select class="form-select select2 w-full" id="npp" name="npp" required>
                                        <option value="">-- Cari Nama Karyawan / NPP --</option>
                                    </select>
                                </div>
                                <button type="button" 
                                        class="inline-flex items-center justify-center gap-2 px-5 h-[42px] bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-xs shadow-xs transition active:scale-95 cursor-pointer shrink-0" 
                                        id="btnSimpanHubunganKaryawan">
                                    <i class="ti ti-link text-sm"></i>
                                    <span>Hubungkan Karyawan</span>
                                </button>
                            </div>
                        </div>

                        <div class="p-3 bg-indigo-50/70 border border-indigo-200/80 rounded-xl flex items-start gap-2 text-xs text-indigo-900">
                            <i class="ti ti-info-circle text-indigo-600 text-base shrink-0 mt-0.5"></i>
                            <span>Menghubungkan anggota dengan data karyawan memudahkan integrasi simpanan dan pembiayaan koperasi.</span>
                        </div>
                    </form>
                </div>

                <!-- 2. Daftar Karyawan Yang Sudah Terhubung -->
                <div class="bg-slate-50/80 border border-slate-200/90 rounded-xl p-4 sm:p-5 space-y-3.5">
                    <div class="flex items-center justify-between pb-2.5 border-b border-slate-200/80">
                        <div class="flex items-center gap-2.5">
                            <div class="w-7 h-7 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center text-sm font-bold shadow-2xs">
                                <i class="ti ti-list-check"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-900 leading-tight">2. Karyawan Yang Sudah Terhubung</h3>
                                <p class="text-[11px] text-slate-500">Daftar pegawai yang saat ini terhubung dengan anggota</p>
                            </div>
                        </div>
                    </div>

                    <div id="karyawan-terhubung" class="space-y-2.5 max-h-64 overflow-y-auto pr-1">
                        <!-- Dynamic list of connected employees -->
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="px-6 py-3.5 bg-white border-t border-slate-200/90 flex justify-end">
                <button type="button" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer active:scale-95" data-bs-dismiss="modal">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('myscript')
<script>
    $(function() {
        // Initialize Select2 in Modals
        $('#id_siswa').select2({
            dropdownParent: $('#mdlHubungkanSiswa'),
            placeholder: '-- Cari Nama Siswa / ID --',
            allowClear: true,
            width: '100%'
        });

        $('#npp').select2({
            dropdownParent: $('#mdlHubungkanKaryawan'),
            placeholder: '-- Cari Nama Karyawan / NPP --',
            allowClear: true,
            width: '100%'
        });

        // Open Modal Create
        $("#btncreateAnggota").click(function(e) {
            e.preventDefault();
            $('#mdlAnggota').modal("show");
            $("#mdlAnggota").find(".modal-title").text("Tambah Anggota Koperasi");
            $("#loadmodalAnggota").html(`
                <div class="flex flex-col items-center justify-center p-12 text-center bg-white">
                    <div class="w-9 h-9 border-3 border-emerald-500 border-t-transparent rounded-full animate-spin mb-3"></div>
                    <span class="text-slate-500 text-xs font-semibold">Memuat formulir anggota...</span>
                </div>
            `);
            $("#loadmodalAnggota").load("{{ route('anggota.create') }}");
        });

        // Open Modal Edit
        $(document).on('click', '.btnEditAnggota', function(e) {
            e.preventDefault();
            var no_anggota = $(this).attr("no_anggota");
            $('#mdlAnggota').modal("show");
            $("#mdlAnggota").find(".modal-title").text("Edit Anggota Koperasi");
            $("#loadmodalAnggota").html(`
                <div class="flex flex-col items-center justify-center p-12 text-center bg-white">
                    <div class="w-9 h-9 border-3 border-emerald-500 border-t-transparent rounded-full animate-spin mb-3"></div>
                    <span class="text-slate-500 text-xs font-semibold">Memuat data profil...</span>
                </div>
            `);
            $("#loadmodalAnggota").load('/anggota/' + no_anggota + '/edit');
        });

        // ==========================================
        // FITUR HUBUNGKAN SISWA / SANTRI
        // ==========================================
        $(document).on('click', '.btnHubungkanSiswa', function(e) {
            e.preventDefault();
            var no_anggota = $(this).attr("no_anggota");
            $('#no_anggota_hidden').val(no_anggota);
            $('#mdlHubungkanSiswa').modal("show");

            loadSiswaOptions();
            loadSiswaTerhubung(no_anggota);
        });

        function loadSiswaOptions() {
            $.get('/anggota/get-siswa-options', function(data) {
                $('#id_siswa').html('<option value="">-- Pilih / Cari Siswa --</option>');
                $.each(data, function(index, siswa) {
                    $('#id_siswa').append('<option value="' + siswa.id_siswa + '">' + siswa.nama_lengkap + ' (' + siswa.id_siswa + ')</option>');
                });
                $('#id_siswa').val('').trigger('change');
            });
        }

        function loadSiswaTerhubung(no_anggota) {
            $("#siswa-terhubung").html(`
                <div class="text-center py-6 text-xs text-slate-400">
                    <div class="w-6 h-6 border-2 border-emerald-500 border-t-transparent rounded-full animate-spin mx-auto mb-2"></div>
                    <span>Memuat siswa terhubung...</span>
                </div>
            `);
            $.get('/anggota/get-siswa-terhubung/' + no_anggota, function(data) {
                var html = '';
                if (data.length > 0) {
                    $.each(data, function(index, siswa) {
                        html += `
                            <div class="flex items-center justify-between p-3.5 bg-white border border-slate-200/90 rounded-xl shadow-2xs hover:border-emerald-300 transition">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold text-xs shrink-0">
                                        <i class="ti ti-school text-sm"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="font-bold text-slate-800 text-xs sm:text-sm uppercase truncate">${siswa.nama_lengkap}</div>
                                        <div class="text-slate-400 text-[11px] flex items-center gap-2 mt-0.5">
                                            <span>ID: <strong class="text-slate-600">${siswa.id_siswa}</strong></span>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btnHapusHubungan w-8 h-8 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200/80 flex items-center justify-center transition active:scale-95 cursor-pointer shadow-2xs shrink-0" data-id-siswa="${siswa.id_siswa}" title="Putuskan Hubungan">
                                    <i class="ti ti-trash text-sm"></i>
                                </button>
                            </div>
                        `;
                    });
                } else {
                    html = `
                        <div class="p-6 bg-white border border-dashed border-slate-200/90 rounded-xl text-center text-slate-400">
                            <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-2 text-lg">
                                <i class="ti ti-school-off"></i>
                            </div>
                            <div class="text-xs font-bold text-slate-700">Belum Ada Santri Terhubung</div>
                            <p class="text-[11px] text-slate-400 mt-0.5">Pilih santri pada form di atas untuk menghubungkan data.</p>
                        </div>
                    `;
                }
                $('#siswa-terhubung').html(html);
            });
        }

        $('#btnSimpanHubungan').click(function() {
            var btn = $(this);
            var no_anggota = $('#no_anggota_hidden').val();
            var id_siswa = $('#id_siswa').val();

            if (!id_siswa) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Silahkan pilih santri/siswa terlebih dahulu',
                    confirmButtonColor: '#059669',
                    customClass: {
                        popup: 'rounded-2xl shadow-2xl p-5',
                        confirmButton: 'px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition cursor-pointer'
                    }
                });
                return;
            }

            btn.prop('disabled', true).html('<div class="w-3.5 h-3.5 border-2 border-white border-t-transparent rounded-full animate-spin"></div><span>Menyimpan...</span>');

            $.post('/anggota/hubungkan-siswa', {
                _token: $('meta[name="csrf-token"]').attr('content'),
                no_anggota: no_anggota,
                id_siswa: id_siswa
            }, function(response) {
                btn.prop('disabled', false).html('<i class="ti ti-link text-sm"></i><span>Hubungkan Santri</span>');
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Santri berhasil dihubungkan!',
                        timer: 1500,
                        showConfirmButton: false,
                        customClass: {
                            popup: 'rounded-2xl shadow-2xl p-5'
                        }
                    });
                    loadSiswaTerhubung(no_anggota);
                    $('#id_siswa').val('').trigger('change');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: response.message || 'Gagal menghubungkan siswa',
                        confirmButtonColor: '#059669',
                        customClass: {
                            popup: 'rounded-2xl shadow-2xl p-5',
                            confirmButton: 'px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition cursor-pointer'
                        }
                    });
                }
            }).fail(function() {
                btn.prop('disabled', false).html('<i class="ti ti-link text-sm"></i><span>Hubungkan Santri</span>');
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan sistem saat menghubungkan data',
                    confirmButtonColor: '#059669',
                    customClass: {
                        popup: 'rounded-2xl shadow-2xl p-5',
                        confirmButton: 'px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition cursor-pointer'
                    }
                });
            });
        });

        $(document).on('click', '.btnHapusHubungan', function() {
            var id_siswa = $(this).data('id-siswa');
            var no_anggota = $('#no_anggota_hidden').val();

            Swal.fire({
                title: 'Putuskan Hubungan Santri?',
                text: "Yakin ingin memutuskan hubungan santri ini dari anggota?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',
                confirmButtonText: '<i class="ti ti-trash mr-1"></i> Ya, Putuskan',
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
                    $.post('/anggota/hapus-hubungan-siswa', {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        no_anggota: no_anggota,
                        id_siswa: id_siswa
                    }, function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Hubungan siswa berhasil dihapus!',
                                timer: 1500,
                                showConfirmButton: false,
                                customClass: {
                                    popup: 'rounded-2xl shadow-2xl p-5'
                                }
                            });
                            loadSiswaTerhubung(no_anggota);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: response.message || 'Gagal menghapus hubungan',
                                confirmButtonColor: '#059669',
                                customClass: {
                                    popup: 'rounded-2xl shadow-2xl p-5',
                                    confirmButton: 'px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition cursor-pointer'
                                }
                            });
                        }
                    });
                }
            });
        });

        // ==========================================
        // FITUR HUBUNGKAN KARYAWAN / PEGAWAI
        // ==========================================
        $(document).on('click', '.btnHubungkanKaryawan', function(e) {
            e.preventDefault();
            var no_anggota = $(this).attr("no_anggota");
            $('#no_anggota_hidden_karyawan').val(no_anggota);
            $('#mdlHubungkanKaryawan').modal("show");

            loadKaryawanOptions();
            loadKaryawanTerhubung(no_anggota);
        });

        function loadKaryawanOptions() {
            $.get('/anggota/get-karyawan-options', function(data) {
                $('#npp').html('<option value="">-- Pilih / Cari Karyawan --</option>');
                $.each(data, function(index, karyawan) {
                    $('#npp').append('<option value="' + karyawan.npp + '">' + karyawan.nama_lengkap + ' (' + karyawan.npp + ')</option>');
                });
                $('#npp').val('').trigger('change');
            });
        }

        function loadKaryawanTerhubung(no_anggota) {
            $("#karyawan-terhubung").html(`
                <div class="text-center py-6 text-xs text-slate-400">
                    <div class="w-6 h-6 border-2 border-indigo-500 border-t-transparent rounded-full animate-spin mx-auto mb-2"></div>
                    <span>Memuat karyawan terhubung...</span>
                </div>
            `);
            $.get('/anggota/get-karyawan-terhubung/' + no_anggota, function(data) {
                var html = '';
                if (data.length > 0) {
                    $.each(data, function(index, karyawan) {
                        html += `
                            <div class="flex items-center justify-between p-3.5 bg-white border border-slate-200/90 rounded-xl shadow-2xs hover:border-indigo-300 transition">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-800 flex items-center justify-center font-bold text-xs shrink-0">
                                        <i class="ti ti-briefcase text-sm"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="font-bold text-slate-800 text-xs sm:text-sm uppercase truncate">${karyawan.nama_lengkap}</div>
                                        <div class="text-slate-400 text-[11px] flex items-center gap-2 mt-0.5">
                                            <span>NPP: <strong class="text-slate-600">${karyawan.npp}</strong></span>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btnHapusHubunganKaryawan w-8 h-8 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200/80 flex items-center justify-center transition active:scale-95 cursor-pointer shadow-2xs shrink-0" data-npp="${karyawan.npp}" title="Putuskan Hubungan">
                                    <i class="ti ti-trash text-sm"></i>
                                </button>
                            </div>
                        `;
                    });
                } else {
                    html = `
                        <div class="p-6 bg-white border border-dashed border-slate-200/90 rounded-xl text-center text-slate-400">
                            <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-2 text-lg">
                                <i class="ti ti-user-off"></i>
                            </div>
                            <div class="text-xs font-bold text-slate-700">Belum Ada Karyawan Terhubung</div>
                            <p class="text-[11px] text-slate-400 mt-0.5">Pilih pegawai pada form di atas untuk menghubungkan data.</p>
                        </div>
                    `;
                }
                $('#karyawan-terhubung').html(html);
            });
        }

        $('#btnSimpanHubunganKaryawan').click(function() {
            var btn = $(this);
            var no_anggota = $('#no_anggota_hidden_karyawan').val();
            var npp = $('#npp').val();

            if (!npp) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Silahkan pilih karyawan terlebih dahulu',
                    confirmButtonColor: '#059669',
                    customClass: {
                        popup: 'rounded-2xl shadow-2xl p-5',
                        confirmButton: 'px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition cursor-pointer'
                    }
                });
                return;
            }

            btn.prop('disabled', true).html('<div class="w-3.5 h-3.5 border-2 border-white border-t-transparent rounded-full animate-spin"></div><span>Menyimpan...</span>');

            $.post('/anggota/hubungkan-karyawan', {
                _token: $('meta[name="csrf-token"]').attr('content'),
                no_anggota: no_anggota,
                npp: npp
            }, function(response) {
                btn.prop('disabled', false).html('<i class="ti ti-link text-sm"></i><span>Hubungkan Karyawan</span>');
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Karyawan berhasil dihubungkan!',
                        timer: 1500,
                        showConfirmButton: false,
                        customClass: {
                            popup: 'rounded-2xl shadow-2xl p-5'
                        }
                    });
                    loadKaryawanTerhubung(no_anggota);
                    $('#npp').val('').trigger('change');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: response.message || 'Gagal menghubungkan karyawan',
                        confirmButtonColor: '#059669',
                        customClass: {
                            popup: 'rounded-2xl shadow-2xl p-5',
                            confirmButton: 'px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition cursor-pointer'
                        }
                    });
                }
            }).fail(function() {
                btn.prop('disabled', false).html('<i class="ti ti-link text-sm"></i><span>Hubungkan Karyawan</span>');
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan sistem saat menghubungkan data',
                    confirmButtonColor: '#059669',
                    customClass: {
                        popup: 'rounded-2xl shadow-2xl p-5',
                        confirmButton: 'px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition cursor-pointer'
                    }
                });
            });
        });

        $(document).on('click', '.btnHapusHubunganKaryawan', function() {
            var npp = $(this).data('npp');
            var no_anggota = $('#no_anggota_hidden_karyawan').val();

            Swal.fire({
                title: 'Putuskan Hubungan Karyawan?',
                text: "Yakin ingin memutuskan hubungan karyawan ini dari anggota?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',
                confirmButtonText: '<i class="ti ti-trash mr-1"></i> Ya, Putuskan',
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
                    $.post('/anggota/hapus-hubungan-karyawan', {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        no_anggota: no_anggota,
                        npp: npp
                    }, function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Hubungan karyawan berhasil dihapus!',
                                timer: 1500,
                                showConfirmButton: false,
                                customClass: {
                                    popup: 'rounded-2xl shadow-2xl p-5'
                                }
                            });
                            loadKaryawanTerhubung(no_anggota);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: response.message || 'Gagal menghapus hubungan',
                                confirmButtonColor: '#059669',
                                customClass: {
                                    popup: 'rounded-2xl shadow-2xl p-5',
                                    confirmButton: 'px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition cursor-pointer'
                                }
                            });
                        }
                    });
                }
            });
        });

        // Reload page on modal dismiss if connections changed
        $('#mdlHubungkanSiswa, #mdlHubungkanKaryawan').on('hidden.bs.modal', function () {
            location.reload();
        });

        // Konfirmasi Delete Anggota
        $(document).on('click', '.delete-confirm', function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data anggota beserta relasi rekening dan simpan pinjam akan terhapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#059669',
                cancelButtonColor: '#dc2626',
                confirmButtonText: 'Ya, Hapus Data!',
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
                    form.submit();
                }
            });
        });
    });
</script>
@endpush

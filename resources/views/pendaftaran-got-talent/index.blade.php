@extends('layouts.app')
@section('titlepage', 'Pendaftaran Al Amin Got Talent')

@section('content')
<div class="space-y-6">

    <!-- ================= 1. PAGE HEADER & BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <i class="ti ti-sparkles text-emerald-600 text-2xl"></i>
                <span>Pendaftaran Got Talent</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Kelola data registrasi peserta lomba, rincian cabang yang diikuti, dan pembuatan akun peserta
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
                    <i class="ti ti-sparkles text-sm"></i>
                    <span>Got Talent</span>
                </span>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Pendaftaran</span>
            </nav>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center gap-2">
                @can('pendaftarangottalent.create')
                    <button type="button" id="btncreatePendaftaranGotTalent" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs hover:shadow-md transition-all duration-200 active:scale-95 cursor-pointer">
                        <i class="ti ti-plus text-base"></i>
                        <span>Tambah Pendaftaran</span>
                    </button>
                @endcan
                @can('pendaftarangottalent.index')
                    <a href="{{ route('pendaftarangottalent.export', request()->all()) }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white hover:bg-slate-50 text-emerald-800 border border-emerald-200 font-bold rounded-xl text-xs shadow-xs transition-all duration-200 active:scale-95">
                        <i class="ti ti-file-excel text-emerald-600 text-base"></i>
                        <span>Export Excel</span>
                    </a>
                @endcan
            </div>
        </div>
    </div>

    <!-- ================= 2. EXECUTIVE STATISTICS SUMMARY (SOLID COLOR CARDS) ================= -->
    <div class="space-y-3">
        <div class="flex items-center justify-between px-1">
            <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
                <i class="ti ti-trophy text-emerald-600 text-base"></i>
                <span>Statistik Pendaftar per Cabang Lomba</span>
            </h3>
            <span class="text-[11px] text-slate-500 font-semibold">
                Total Registrasi: <strong class="text-emerald-700">{{ $totalPendaftar }} Peserta</strong>
            </span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-4">
            @forelse ($statistikLomba as $stat)
                @php
                    $hasPeserta = $stat->jumlah_peserta > 0;
                @endphp
                <div class="{{ $hasPeserta ? 'bg-emerald-600 hover:bg-emerald-700 text-white' : 'bg-rose-600 hover:bg-rose-700 text-white' }} rounded-2xl p-4 shadow-xs hover:shadow-md transition-all duration-200 cursor-pointer detail-lomba-card group relative overflow-hidden flex flex-col justify-between"
                     data-id-lomba="{{ $stat->id }}" data-nama-lomba="{{ $stat->jenis_perlombaan }}" data-jenjang="{{ $stat->jenjang_pendidikan }}">
                    
                    <!-- Subtle Clean Background Ornament (Minimal Watermark & Glow) -->
                    <div class="absolute -right-5 -bottom-5 w-24 h-24 rounded-full bg-white/[0.08] pointer-events-none"></div>
                    
                    <!-- Clean Vector Wave Accent (Subtle & Elegant) -->
                    <div class="absolute right-0 bottom-0 left-0 h-11 pointer-events-none overflow-hidden opacity-10 group-hover:opacity-20 transition-opacity">
                        <svg viewBox="0 0 200 40" preserveAspectRatio="none" class="w-full h-full text-white fill-current">
                            <path d="M0,25 C50,38 120,8 200,20 L200,40 L0,40 Z"></path>
                        </svg>
                    </div>

                    <!-- Card Body -->
                    <div class="relative z-10 flex items-start justify-between gap-2">
                        <div class="min-w-0 flex-1">
                            <span class="text-[10.5px] font-bold uppercase tracking-wider {{ $hasPeserta ? 'text-emerald-100' : 'text-rose-100' }} block truncate" title="{{ $stat->jenis_perlombaan }}">
                                {{ $stat->jenis_perlombaan }}
                            </span>
                            <div class="text-2xl sm:text-3xl font-black text-white tracking-tight mt-1 flex items-baseline gap-1.5">
                                <span>{{ $stat->jumlah_peserta }}</span>
                                <span class="text-xs font-semibold {{ $hasPeserta ? 'text-emerald-200' : 'text-rose-200' }}">peserta</span>
                            </div>
                        </div>
                        <div class="w-9 h-9 rounded-xl bg-white/20 text-white flex items-center justify-center text-lg font-bold border border-white/20 group-hover:scale-105 transition-transform shrink-0 backdrop-blur-xs shadow-2xs">
                            <i class="{{ $hasPeserta ? 'ti ti-trophy' : 'ti ti-users-off' }}"></i>
                        </div>
                    </div>

                    <!-- Card Footer -->
                    <div class="relative z-10 mt-3 pt-2.5 border-t {{ $hasPeserta ? 'border-emerald-500/80 text-emerald-100' : 'border-rose-500/80 text-rose-100' }} flex items-center justify-between text-[11px]">
                        <span class="inline-flex items-center gap-1 truncate font-medium">
                            <i class="ti ti-school text-xs"></i>
                            <span class="truncate">{{ $stat->jenjang_pendidikan }}</span>
                        </span>
                        <span class="font-bold bg-white/20 hover:bg-white/30 px-2 py-0.5 rounded-md backdrop-blur-xs text-white shrink-0 shadow-2xs transition">
                            {{ $hasPeserta ? 'Detail' : 'Kosong' }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="p-6 bg-white border border-slate-200 rounded-2xl text-center text-slate-400 text-xs">
                        <i class="ti ti-info-circle text-lg mb-1 block"></i>
                        <span>Belum ada data cabang perlombaan untuk dihitung statistiknya.</span>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <!-- ================= 3. FILTER & SEARCH TOOLBAR ================= -->
    <form action="{{ route('pendaftarangottalent.index') }}" method="GET" class="w-full">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-2.5 sm:gap-3 w-full">
            <!-- Search No Register -->
            <div class="lg:col-span-3 relative">
                <i class="ti ti-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-lg pointer-events-none"></i>
                <input type="text" 
                       name="nomor_register_search" 
                       value="{{ Request('nomor_register_search') }}" 
                       placeholder="Cari No. Register..." 
                       class="w-full pl-11 pr-4 py-2.5 sm:py-3 text-sm bg-white border border-slate-300 rounded-xl text-slate-800 font-medium placeholder-slate-400 shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
            </div>

            <!-- Search Nama Lengkap -->
            <div class="lg:col-span-3 relative">
                <i class="ti ti-user absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-lg pointer-events-none"></i>
                <input type="text" 
                       name="nama_lengkap_search" 
                       value="{{ Request('nama_lengkap_search') }}" 
                       placeholder="Cari nama peserta..." 
                       class="w-full pl-11 pr-4 py-2.5 sm:py-3 text-sm bg-white border border-slate-300 rounded-xl text-slate-800 font-medium placeholder-slate-400 shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
            </div>

            <!-- Jenjang Filter -->
            <div class="lg:col-span-2 relative">
                <i class="ti ti-school absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-lg pointer-events-none"></i>
                <select name="id_jenjang_search" 
                        class="w-full pl-11 pr-8 py-2.5 sm:py-3 text-sm bg-white border border-slate-300 rounded-xl text-slate-800 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition appearance-none">
                    <option value="">Semua Jenjang</option>
                    @foreach ($jenjangPendidikan as $d)
                        <option value="{{ $d->id }}" {{ Request('id_jenjang_search') == $d->id ? 'selected' : '' }}>
                            {{ $d->jenjang_pendidikan }}
                        </option>
                    @endforeach
                </select>
                <i class="ti ti-chevron-down absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
            </div>

            <!-- Lomba Filter -->
            <div class="lg:col-span-3 relative">
                <i class="ti ti-trophy absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-lg pointer-events-none"></i>
                <select name="id_lomba_search" 
                        class="w-full pl-11 pr-8 py-2.5 sm:py-3 text-sm bg-white border border-slate-300 rounded-xl text-slate-800 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition appearance-none">
                    <option value="">Semua Cabang Lomba</option>
                    @foreach ($perlombaan as $l)
                        <option value="{{ $l->id }}" {{ Request('id_lomba_search') == $l->id ? 'selected' : '' }}>
                            {{ $l->jenis_perlombaan }} ({{ $l->jenjangPendidikan->jenjang_pendidikan ?? '-' }})
                        </option>
                    @endforeach
                </select>
                <i class="ti ti-chevron-down absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
            </div>

            <!-- Submit & Reset Buttons -->
            <div class="lg:col-span-1 flex items-center gap-2">
                <button type="submit" class="w-full py-2.5 sm:py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl shadow-xs transition inline-flex items-center justify-center cursor-pointer active:scale-95" title="Cari Data">
                    <i class="ti ti-search text-base"></i>
                </button>
                @if(Request('nomor_register_search') || Request('nama_lengkap_search') || Request('id_jenjang_search') || Request('id_lomba_search'))
                    <a href="{{ route('pendaftarangottalent.index') }}" class="py-2.5 sm:py-3 px-3 bg-white hover:bg-slate-100 text-slate-600 border border-slate-300 rounded-xl font-semibold text-sm transition inline-flex items-center justify-center shrink-0 shadow-xs" title="Reset Filter">
                        <i class="ti ti-refresh text-base"></i>
                    </a>
                @endif
            </div>
        </div>
    </form>

    <!-- ================= 4. DATA TABLE SECTION (SEAMLESS SOLID GREEN HEADER) ================= -->
    <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
        <!-- Seamless Solid Green Card Header -->
        <div class="px-5 pt-4 pb-2.5 bg-emerald-600 flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-white border-0">
            <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-lg bg-white/20 text-white flex items-center justify-center text-xs font-bold border border-white/20 shadow-2xs">
                    <i class="ti ti-users"></i>
                </div>
                <h3 class="text-sm font-extrabold text-white tracking-tight">Daftar Pendaftar Got Talent</h3>
                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-white/20 text-white border border-white/30 shadow-2xs backdrop-blur-xs">
                    {{ $pendaftaranGotTalent->count() }} peserta
                </span>
            </div>
            <div class="text-xs text-emerald-100 font-medium">
                Data registrasi peserta Al Amin Got Talent
            </div>
        </div>

        <!-- Responsive Table Container -->
        <div class="overflow-x-auto bg-emerald-600">
            <table class="w-full text-left text-xs sm:text-sm border-0 border-collapse">
                <!-- Matching Solid Green Table Header -->
                <thead class="bg-emerald-600 text-white font-bold uppercase tracking-wider text-[11px] border-0 border-t-0 border-b border-emerald-700/80">
                    <tr class="border-0 border-t-0">
                        <th class="py-2 px-3.5 w-10 text-center text-emerald-100 border-0 border-t-0">No</th>
                        <th class="py-2 px-3.5 w-24 whitespace-nowrap text-emerald-100 border-0 border-t-0">Tgl Daftar</th>
                        <th class="py-2 px-3.5 w-28 text-emerald-100 border-0 border-t-0">No. Register</th>
                        <th class="py-2 px-3.5 text-emerald-100 border-0 border-t-0">Nama Lengkap</th>
                        <th class="py-2 px-3.5 w-28 text-emerald-100 border-0 border-t-0">Jenjang</th>
                        <th class="py-2 px-3.5 w-36 text-emerald-100 border-0 border-t-0">Asal Sekolah</th>
                        <th class="py-2 px-3.5 w-32 text-emerald-100 border-0 border-t-0">No. HP / WA</th>
                        <th class="py-2 px-3.5 text-center w-24 text-emerald-100 border-0 border-t-0">Status</th>
                        <th class="py-2 px-3.5 text-center w-28 text-emerald-100 border-0 border-t-0">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700 font-medium bg-white">
                    @forelse ($pendaftaranGotTalent as $d)
                        <tr class="hover:bg-slate-50/80 transition-colors group">
                            <!-- No -->
                            <td class="py-2 px-3.5 text-center text-slate-400 font-bold text-xs">
                                <span class="w-5.5 h-5.5 rounded-md bg-slate-100 group-hover:bg-emerald-50 group-hover:text-emerald-700 group-hover:border group-hover:border-emerald-200 inline-flex items-center justify-center font-bold text-slate-600 transition text-[11px]">
                                    {{ $loop->iteration }}
                                </span>
                            </td>

                            <!-- Tanggal Daftar -->
                            <td class="py-2 px-3.5 whitespace-nowrap">
                                <div class="text-xs text-slate-600 font-semibold flex items-center gap-1">
                                    <i class="ti ti-calendar text-slate-400 text-xs"></i>
                                    <span>{{ $d->created_at ? $d->created_at->translatedFormat('d/m/Y') : '-' }}</span>
                                </div>
                            </td>

                            <!-- Nomor Register -->
                            <td class="py-2 px-3.5 whitespace-nowrap">
                                <span class="px-2 py-0.5 rounded-md text-[11px] font-black font-mono tracking-wider bg-emerald-50 text-emerald-800 border border-emerald-200/80 shadow-2xs">
                                    {{ $d->nomor_register }}
                                </span>
                            </td>

                            <!-- Nama Lengkap -->
                            <td class="py-2 px-3.5">
                                <span class="font-bold text-slate-900 group-hover:text-emerald-800 transition text-xs sm:text-sm line-clamp-1">
                                    {{ $d->nama_lengkap }}
                                </span>
                            </td>

                            <!-- Jenjang Pendidikan -->
                            <td class="py-2 px-3.5 whitespace-nowrap">
                                @if($d->jenjangPendidikan)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[11px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-100 shadow-2xs">
                                        <i class="ti ti-school text-[11px]"></i>
                                        <span>{{ $d->jenjangPendidikan->jenjang_pendidikan }}</span>
                                    </span>
                                @else
                                    <span class="text-slate-400 italic text-xs">-</span>
                                @endif
                            </td>

                            <!-- Asal Sekolah -->
                            <td class="py-2 px-3.5 text-slate-700 font-medium text-xs">
                                <span class="line-clamp-1" title="{{ $d->asal_sekolah ?? '-' }}">
                                    {{ $d->asal_sekolah ?? '-' }}
                                </span>
                            </td>

                            <!-- No. HP -->
                            <td class="py-2 px-3.5 whitespace-nowrap">
                                @if ($d->no_hp)
                                    @php
                                        preg_match('/\d{9,15}/', $d->no_hp, $phoneMatches);
                                        $cleanPhone = !empty($phoneMatches[0]) ? preg_replace('/^0/', '62', $phoneMatches[0]) : null;
                                    @endphp
                                    @if ($cleanPhone)
                                        <a href="https://wa.me/{{ $cleanPhone }}" target="_blank" 
                                           class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[11px] font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200/80 hover:bg-emerald-100 transition shadow-2xs">
                                            <i class="ti ti-brand-whatsapp text-emerald-600 text-xs"></i>
                                            <span>{{ $d->no_hp }}</span>
                                        </a>
                                    @else
                                        <span class="text-xs">{{ $d->no_hp }}</span>
                                    @endif
                                @else
                                    <span class="text-slate-400 text-xs">-</span>
                                @endif
                            </td>

                            <!-- Status User -->
                            <td class="py-2 px-3.5 text-center whitespace-nowrap">
                                @if (!empty($d->id_user))
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <i class="ti ti-check text-[10px]"></i>
                                        <span>Aktif</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                        <i class="ti ti-clock text-[10px]"></i>
                                        <span>Belum Buat</span>
                                    </span>
                                @endif
                            </td>

                            <!-- Action Buttons -->
                            <td class="py-2 px-3.5 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-1.5">
                                    <!-- Detail Modal Preview -->
                                    <button type="button" 
                                            class="w-7.5 h-7.5 rounded-lg bg-sky-50 hover:bg-sky-100 text-sky-700 border border-sky-200/80 flex items-center justify-center transition active:scale-95 cursor-pointer shadow-2xs showDetailPendaftaranGotTalent"
                                            id_pendaftaran="{{ Crypt::encrypt($d->id) }}"
                                            title="Detail Peserta & Lomba">
                                        <i class="ti ti-info-circle text-sm"></i>
                                    </button>

                                    <!-- Lihat Halaman Show -->
                                    <a href="{{ route('pendaftarangottalent.show', Crypt::encrypt($d->id)) }}" 
                                       class="w-7.5 h-7.5 rounded-lg bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200/80 flex items-center justify-center transition active:scale-95 shadow-2xs"
                                       title="Lihat Detail Lengkap">
                                        <i class="ti ti-eye text-sm"></i>
                                    </a>

                                    <!-- Edit -->
                                    @can('pendaftarangottalent.edit')
                                        <button type="button" 
                                                class="w-7.5 h-7.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200/80 flex items-center justify-center transition active:scale-95 cursor-pointer shadow-2xs editPendaftaranGotTalent"
                                                id_pendaftaran="{{ Crypt::encrypt($d->id) }}"
                                                title="Edit Pendaftaran">
                                            <i class="ti ti-edit text-sm"></i>
                                        </button>
                                    @endcan

                                    <!-- Buat Akun User -->
                                    @can('pendaftarangottalent.index')
                                        @if (empty($d->id_user))
                                            <a href="{{ route('pendaftarangottalent.createuser', Crypt::encrypt($d->id)) }}"
                                               class="w-7.5 h-7.5 rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200/80 flex items-center justify-center transition active:scale-95 shadow-2xs" 
                                               title="Buat Akun Login Peserta">
                                                <i class="ti ti-user-plus text-sm"></i>
                                            </a>
                                        @endif
                                    @endcan

                                    <!-- Hapus -->
                                    @can('pendaftarangottalent.delete')
                                        <form method="POST" name="deleteform" class="deleteform inline-block"
                                              action="{{ route('pendaftarangottalent.delete', Crypt::encrypt($d->id)) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" 
                                                    class="w-7.5 h-7.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200/80 flex items-center justify-center transition active:scale-95 cursor-pointer shadow-2xs delete-confirm"
                                                    title="Hapus Pendaftaran">
                                                <i class="ti ti-trash text-sm"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="py-12 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-14 h-14 rounded-2xl bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-400 text-2xl mb-3">
                                        <i class="ti ti-user-x"></i>
                                    </div>
                                    <p class="font-bold text-slate-700 text-sm">Belum Ada Data Pendaftar</p>
                                    <p class="text-xs text-slate-400 mt-0.5">Data registrasi peserta belum tersedia atau tidak cocok dengan filter pencarian.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Modal Dialogs -->
<x-modal-form id="mdlcreatePendaftaranGotTalent" size="modal-lg" show="loadcreatePendaftaranGotTalent" title="Tambah Pendaftaran Got Talent" icon="ti ti-user-plus" />
<x-modal-form id="mdleditPendaftaranGotTalent" size="modal-lg" show="loadeditPendaftaranGotTalent" title="Edit Pendaftaran Got Talent" icon="ti ti-edit" />
<x-modal-form id="mdlshowDetailPendaftaranGotTalent" size="modal-lg" show="loadshowDetailPendaftaranGotTalent" title="Detail Peserta & Lomba" icon="ti ti-id" />
<x-modal-form id="mdlDetailPesertaLomba" size="modal-xl" show="loadDetailPesertaLomba" title="Detail Peserta Lomba" icon="ti ti-trophy" />

@endsection

@push('myscript')
<script>
    $(function() {
        $("#btncreatePendaftaranGotTalent").click(function(e) {
            e.preventDefault();
            $('#mdlcreatePendaftaranGotTalent').modal("show");
            $("#loadcreatePendaftaranGotTalent").html(`
                <div class="text-center py-6">
                    <div class="spinner-border text-emerald-600" role="status">
                        <span class="visually-hidden">Memuat...</span>
                    </div>
                    <p class="mt-2 text-xs text-slate-500">Memuat formulir...</p>
                </div>
            `);
            $("#loadcreatePendaftaranGotTalent").load("{{ route('pendaftarangottalent.create') }}");
        });

        $(document).on("click", ".editPendaftaranGotTalent", function(e) {
            var id_pendaftaran = $(this).attr("id_pendaftaran");
            e.preventDefault();
            $('#mdleditPendaftaranGotTalent').modal("show");
            $("#loadeditPendaftaranGotTalent").html(`
                <div class="text-center py-6">
                    <div class="spinner-border text-emerald-600" role="status">
                        <span class="visually-hidden">Memuat...</span>
                    </div>
                    <p class="mt-2 text-xs text-slate-500">Memuat formulir...</p>
                </div>
            `);
            $("#loadeditPendaftaranGotTalent").load("{{ url('/pendaftaran-got-talent') }}/" + id_pendaftaran + "/edit");
        });

        $(document).on("click", ".showDetailPendaftaranGotTalent", function(e) {
            var id_pendaftaran = $(this).attr("id_pendaftaran");
            e.preventDefault();
            $('#mdlshowDetailPendaftaranGotTalent').modal("show");
            $("#loadshowDetailPendaftaranGotTalent").html(`
                <div class="text-center py-6">
                    <div class="spinner-border text-emerald-600" role="status">
                        <span class="visually-hidden">Memuat...</span>
                    </div>
                    <p class="mt-2 text-xs text-slate-500">Memuat rincian...</p>
                </div>
            `);
            $("#loadshowDetailPendaftaranGotTalent").load("{{ url('/pendaftaran-got-talent') }}/" + id_pendaftaran + "/show");
        });

        // Handle klik pada card lomba untuk menampilkan detail peserta
        $(document).on("click", ".detail-lomba-card", function(e) {
            e.preventDefault();
            var id_lomba = $(this).data("id-lomba");
            var nama_lomba = $(this).data("nama-lomba");
            var jenjang = $(this).data("jenjang");

            $('#mdlDetailPesertaLomba .modal-title').text('Detail Peserta - ' + nama_lomba + ' (' + jenjang + ')');
            $('#mdlDetailPesertaLomba').modal("show");

            $("#loadDetailPesertaLomba").html(`
                <div class="text-center py-6">
                    <div class="spinner-border text-emerald-600" role="status">
                        <span class="visually-hidden">Memuat...</span>
                    </div>
                    <p class="mt-2 text-xs text-slate-500">Memuat data peserta lomba...</p>
                </div>
            `);

            $("#loadDetailPesertaLomba").load("{{ url('/pendaftaran-got-talent/detail-lomba') }}/" + id_lomba);
        });

        // SweetAlert Delete Confirmation
        $(document).on("click", ".delete-confirm", function(e) {
            e.preventDefault();
            var form = $(this).closest("form");
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "Data registrasi pendaftaran ini akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush

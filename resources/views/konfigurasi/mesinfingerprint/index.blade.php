@extends('layouts.app')
@section('titlepage', 'Mesin Fingerprint')

@section('content')
<div class="space-y-5">

    <!-- ================= 1. PAGE HEADER (NO CARD) WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center border border-emerald-200/80 shadow-2xs">
                    <i class="ti ti-fingerprint text-2xl"></i>
                </div>
                <span>Mesin Fingerprint</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Konfigurasi perangkat biometrik absensi dan pemantauan status sinkronisasi presensi santri / pegawai
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
                <span class="font-bold text-slate-800">Mesin Fingerprint</span>
            </nav>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('mesinfingerprint.logmesin') }}" class="inline-flex items-center gap-2 px-3.5 py-2.5 bg-white hover:bg-slate-100 text-slate-700 font-bold rounded-xl text-xs border border-slate-300/90 shadow-2xs transition-all duration-200 active:scale-95">
                    <i class="ti ti-history text-base text-emerald-600"></i>
                    <span>Log Aktivitas Mesin</span>
                </a>
                @can('mesinfingerprint.create')
                    <button type="button" id="btnCreate" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs transition-all duration-200 active:scale-95 cursor-pointer border-0">
                        <i class="ti ti-plus text-base"></i>
                        <span>Tambah Mesin</span>
                    </button>
                @endcan
            </div>
        </div>
    </div>

    <!-- ================= 2. SOLID EMERALD TABLE CARD ================= -->
    <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
        <!-- Solid Emerald Header -->
        <div class="bg-emerald-600 px-5 py-4 flex items-center justify-between text-white">
            <div class="flex items-center gap-2.5">
                <i class="ti ti-device-laptop text-xl"></i>
                <h3 class="font-bold text-sm tracking-wide text-white">Daftar Perangkat Mesin Terhubung</h3>
            </div>
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-white/20 text-white backdrop-blur-xs">
                Total: {{ count($mesin) }} Perangkat
            </span>
        </div>

        <!-- Table Container -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse whitespace-nowrap">
                <thead>
                    <tr class="bg-emerald-600 text-white uppercase text-[11px] font-extrabold tracking-wider border-t border-emerald-500/50">
                        <th class="py-2.5 px-3.5 w-12 text-center whitespace-nowrap">NO</th>
                        <th class="py-2.5 px-4 whitespace-nowrap">NAMA MESIN</th>
                        <th class="py-2.5 px-4 whitespace-nowrap">SERIAL NUMBER (SN)</th>
                        <th class="py-2.5 px-4 whitespace-nowrap">TITIK KOORDINAT</th>
                        <th class="py-2.5 px-3.5 text-center whitespace-nowrap">STATUS</th>
                        <th class="py-2.5 px-3.5 text-center w-28 whitespace-nowrap">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                    @forelse ($mesin as $d)
                        <tr class="hover:bg-slate-50/80 transition-colors group">
                            <!-- No -->
                            <td class="py-2.5 px-3.5 text-center font-bold text-slate-400 whitespace-nowrap">
                                {{ $loop->iteration }}
                            </td>

                            <!-- Nama Mesin -->
                            <td class="py-2.5 px-4 whitespace-nowrap">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0 border border-emerald-100 font-bold text-sm">
                                        <i class="ti ti-cpu"></i>
                                    </div>
                                    <span class="font-bold text-slate-900 group-hover:text-emerald-700 transition-colors">
                                        {{ $d->nama_mesin }}
                                    </span>
                                </div>
                            </td>

                            <!-- Serial Number (SN) -->
                            <td class="py-2.5 px-4 whitespace-nowrap">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 font-mono text-[11px] font-bold border border-slate-200">
                                    <i class="ti ti-barcode text-slate-400"></i>
                                    {{ $d->sn }}
                                </span>
                            </td>

                            <!-- Titik Koordinat -->
                            <td class="py-2.5 px-4 whitespace-nowrap">
                                @if($d->titik_koordinat)
                                    <span class="inline-flex items-center gap-1.5 font-mono text-slate-600 bg-slate-50 px-2 py-1 rounded-md border border-slate-200/80">
                                        <i class="ti ti-map-pin text-rose-500"></i>
                                        {{ $d->titik_koordinat }}
                                    </span>
                                @else
                                    <span class="text-slate-400 italic text-[11px]">Belum diatur</span>
                                @endif
                            </td>

                            <!-- Status -->
                            <td class="py-2.5 px-3.5 text-center whitespace-nowrap">
                                @if ($d->status == 'Aktif')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100/80 text-emerald-800 border border-emerald-300/60">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                        <span>Aktif</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-slate-100 text-slate-600 border border-slate-300">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                        <span>Nonaktif</span>
                                    </span>
                                @endif
                            </td>

                            <!-- Aksi -->
                            <td class="py-2.5 px-3.5 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-1.5">
                                    @can('mesinfingerprint.edit')
                                        <button type="button" 
                                                class="w-7 h-7 rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-700 flex items-center justify-center transition active:scale-95 btnEdit cursor-pointer border border-amber-200/60" 
                                                data-id="{{ Crypt::encrypt($d->id) }}"
                                                title="Edit Mesin">
                                            <i class="ti ti-pencil text-sm"></i>
                                        </button>
                                    @endcan

                                    @can('mesinfingerprint.delete')
                                        <form method="POST" action="{{ route('mesinfingerprint.delete', Crypt::encrypt($d->id)) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" 
                                                    class="w-7 h-7 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 flex items-center justify-center transition active:scale-95 delete-confirm cursor-pointer border border-rose-200/60" 
                                                    data-nama="{{ $d->nama_mesin }}"
                                                    title="Hapus Mesin">
                                                <i class="ti ti-trash text-sm"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 px-4 text-center">
                                <div class="w-16 h-16 mx-auto mb-3 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-3xl">
                                    <i class="ti ti-fingerprint-off"></i>
                                </div>
                                <h4 class="font-bold text-slate-800 text-sm">Belum Ada Mesin Terdaftar</h4>
                                <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">
                                    Silahkan tambahkan data mesin fingerprint baru untuk mengaktifkan sinkronisasi kehadiran santri / staf.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<x-modal-form id="mdlCreate" size="" show="loadCreate" title="Tambah Mesin Fingerprint" />
<x-modal-form id="mdlEdit" size="" show="loadEdit" title="Edit Mesin Fingerprint" />
@endsection

@push('myscript')
<script>
    $(function() {
        $("#btnCreate").click(function(e) {
            e.preventDefault();
            $('#mdlCreate').modal("show");
            $("#loadCreate").html(`
                <div class="py-10 text-center">
                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-emerald-500 border-t-transparent"></div>
                    <p class="text-xs text-slate-500 mt-2 font-medium">Memuat form...</p>
                </div>
            `);
            $("#loadCreate").load("{{ route('mesinfingerprint.create') }}");
        });

        $(".btnEdit").click(function(e) {
            e.preventDefault();
            var id = $(this).attr("data-id");
            $('#mdlEdit').modal("show");
            $("#loadEdit").html(`
                <div class="py-10 text-center">
                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-emerald-500 border-t-transparent"></div>
                    <p class="text-xs text-slate-500 mt-2 font-medium">Memuat data mesin...</p>
                </div>
            `);
            $("#loadEdit").load('/mesinfingerprint/' + id + '/edit');
        });

        $(document).on('click', '.delete-confirm', function(e) {
            e.preventDefault();
            const form = $(this).closest('form');
            const nama = $(this).data('nama') || 'mesin ini';

            Swal.fire({
                title: 'Hapus Mesin Fingerprint?',
                text: `Apakah Anda yakin ingin menghapus "${nama}"? Sinkronisasi absensi dari mesin ini akan terputus!`,
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
    });
</script>
@endpush


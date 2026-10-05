@extends('layouts.app')
@section('titlepage', 'Tahun Ajaran & Semester')

@section('content')
<div class="space-y-6">

    <!-- ================= 1. PAGE HEADER (NO CARD) WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center border border-emerald-200/80 shadow-2xs">
                    <i class="ti ti-calendar-event text-2xl"></i>
                </div>
                <span>Tahun Ajaran & Semester</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Kelola periode kalender tahun ajaran dan status semester akademik aktif
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
                <span class="font-bold text-slate-800">Tahun Ajaran</span>
            </nav>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center gap-2">
                @can('tahunajaran.create')
                    <button type="button" id="btnCreate" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs transition-all duration-200 active:scale-95 cursor-pointer border-0">
                        <i class="ti ti-plus text-base"></i>
                        <span>Tambah Tahun Ajaran</span>
                    </button>
                @endcan
            </div>
        </div>
    </div>

    <!-- ================= 2. MAIN DUAL-COLUMN GRID ================= -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- KOLOM KIRI: TABEL TAHUN AJARAN (7 Kolom) -->
        <div class="lg:col-span-7 bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
            <!-- Solid Emerald Header -->
            <div class="bg-emerald-600 px-5 py-4 flex items-center justify-between text-white">
                <div class="flex items-center gap-2.5">
                    <i class="ti ti-calendar-stats text-xl"></i>
                    <h3 class="font-bold text-sm tracking-wide text-white">Data Periode Tahun Ajaran</h3>
                </div>
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-white/20 text-white backdrop-blur-xs">
                    Total: {{ count($tahun_ajaran) }} Periode
                </span>
            </div>

            <!-- Table Container -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-emerald-600 text-white uppercase text-[11px] font-extrabold tracking-wider border-t border-emerald-500/50">
                            <th class="py-3.5 px-4 w-12 text-center">NO</th>
                            <th class="py-3.5 px-4 w-28 text-center">KODE</th>
                            <th class="py-3.5 px-5">TAHUN AJARAN</th>
                            <th class="py-3.5 px-4 text-center w-32">STATUS</th>
                            <th class="py-3.5 px-4 text-center w-28">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                        @forelse ($tahun_ajaran as $d)
                            <tr class="hover:bg-slate-50/80 transition-colors group {{ $d->status == '1' ? 'bg-emerald-50/40' : '' }}">
                                <!-- No -->
                                <td class="py-4 px-4 text-center font-bold text-slate-400">
                                    {{ $loop->iteration }}
                                </td>

                                <!-- Kode TA -->
                                <td class="py-4 px-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 font-mono text-[11px] font-bold border border-slate-200">
                                        {{ $d->kode_ta }}
                                    </span>
                                </td>

                                <!-- Tahun Ajaran -->
                                <td class="py-4 px-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0 border border-emerald-100 font-bold text-xs">
                                            <i class="ti ti-calendar"></i>
                                        </div>
                                        <h4 class="font-bold text-slate-900 text-sm group-hover:text-emerald-700 transition-colors leading-snug">
                                            {{ $d->tahun_ajaran }}
                                        </h4>
                                    </div>
                                </td>

                                <!-- Status -->
                                <td class="py-4 px-4 text-center">
                                    @if ($d->status == '1')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-500 text-white shadow-2xs">
                                            <i class="ti ti-check text-xs"></i>
                                            <span>Aktif</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-slate-100 text-slate-500 border border-slate-200">
                                            Non-Aktif
                                        </span>
                                    @endif
                                </td>

                                <!-- Aksi -->
                                <td class="py-4 px-4 text-center">
                                    <div class="inline-flex items-center justify-center gap-1.5">
                                        @can('tahunajaran.edit')
                                            <button type="button" 
                                               class="w-8 h-8 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 flex items-center justify-center transition-colors border border-emerald-200/60 btnEdit cursor-pointer" 
                                               kode_ta="{{ Crypt::encrypt($d->kode_ta) }}"
                                               title="Edit Tahun Ajaran">
                                                <i class="ti ti-edit text-base"></i>
                                            </button>
                                        @endcan

                                        @can('tahunajaran.delete')
                                            <form method="POST" name="deleteform" class="deleteform inline-block m-0"
                                                  action="{{ route('tahunajaran.delete', Crypt::encrypt($d->kode_ta)) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" 
                                                        class="w-8 h-8 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 flex items-center justify-center transition-colors border border-rose-200/60 delete-confirm cursor-pointer"
                                                        title="Hapus Tahun Ajaran">
                                                    <i class="ti ti-trash text-base"></i>
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-14 text-center bg-white">
                                    <div class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3 text-2xl shadow-inner">
                                        <i class="ti ti-calendar-off"></i>
                                    </div>
                                    <h4 class="font-bold text-slate-800 text-sm mb-1">Belum Ada Data Tahun Ajaran</h4>
                                    <p class="text-xs text-slate-400 max-w-sm mx-auto">
                                        Silahkan klik tombol Tambah Tahun Ajaran untuk memasukkan periode akademik baru.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- KOLOM KANAN: KONFIGURASI SEMESTER (5 Kolom) -->
        <div class="lg:col-span-5 bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
            <!-- Solid Emerald Header -->
            <div class="bg-emerald-600 px-5 py-4 flex items-center justify-between text-white">
                <div class="flex items-center gap-2.5">
                    <i class="ti ti-adjustments-horizontal text-xl"></i>
                    <h3 class="font-bold text-sm tracking-wide text-white">Konfigurasi Semester</h3>
                </div>
            </div>

            <!-- Card Body -->
            <div class="p-5 space-y-4">
                <div class="space-y-3">
                    @foreach ($semester as $s)
                        @php
                            $isActive = $s->status == '1';
                            $label = $s->semester == 1 ? 'Ganjil' : 'Genap';
                            $icon = $s->semester == 1 ? 'ti-sun' : 'ti-moon-stars';
                        @endphp
                        <div class="p-4 rounded-xl border transition-all duration-200 {{ $isActive ? 'border-emerald-600 bg-emerald-50/40 shadow-xs ring-2 ring-emerald-500/20' : 'border-slate-200 bg-white hover:border-slate-300 hover:shadow-xs' }}">
                            <div class="flex items-center justify-between gap-3">
                                <div class="flex items-center gap-3.5">
                                    <div class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0 border {{ $isActive ? 'bg-emerald-600 text-white border-emerald-600 shadow-2xs' : 'bg-slate-100 text-slate-500 border-slate-200' }}">
                                        <i class="ti {{ $icon }} text-xl"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-sm {{ $isActive ? 'text-slate-900' : 'text-slate-700' }}">
                                            Semester {{ $label }}
                                        </h4>
                                        <p class="text-xs {{ $isActive ? 'text-emerald-700 font-semibold' : 'text-slate-400' }}">
                                            {{ $isActive ? 'Sedang Berjalan (Aktif)' : 'Periode Semester ' . $label }}
                                        </p>
                                    </div>
                                </div>
                                <div>
                                    @if ($isActive)
                                        <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-bold bg-emerald-600 text-white shadow-2xs">
                                            <i class="ti ti-circle-check text-xs"></i>
                                            <span>AKTIF</span>
                                        </span>
                                    @else
                                        <a href="{{ route('tahunajaran.setsemester', $s->id) }}" 
                                           class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-white hover:bg-emerald-600 hover:text-white text-emerald-700 border border-emerald-300 hover:border-emerald-600 rounded-xl text-xs font-bold transition shadow-2xs active:scale-95">
                                            <i class="ti ti-rotate-clockwise text-xs"></i>
                                            <span>Aktifkan</span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Info Notice Box -->
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/90 flex items-start gap-3 text-xs">
                    <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-800 flex items-center justify-center shrink-0 mt-0.5 font-bold">
                        <i class="ti ti-info-circle text-base"></i>
                    </div>
                    <div class="space-y-1">
                        <h5 class="font-bold text-slate-800">Informasi Penting</h5>
                        <p class="text-slate-500 leading-relaxed">
                            Perubahan semester aktif berdampak langsung secara real-time pada seluruh modul penilaian raport santri, absensi, dan jadwal belajar mengajar.
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<x-modal-form id="mdlCreate" size="" show="loadCreate" title="Tambah Tahun Ajaran" />
<x-modal-form id="mdlEdit" size="" show="loadEdit" title="Edit Tahun Ajaran" />
@endsection

@push('myscript')
<script>
    $(function() {
        const loading = `
            <div class="p-8 text-center text-slate-400">
                <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-emerald-500 border-t-transparent mb-2"></div>
                <p class="text-xs font-semibold">Memuat formulir...</p>
            </div>`;

        $("#btnCreate").click(function(e) {
            e.preventDefault();
            $('#mdlCreate').modal("show");
            $("#mdlCreate").find("#loadCreate").html(loading);
            $("#loadCreate").load("{{ route('tahunajaran.create') }}");
        });

        $(document).on("click", ".btnEdit", function(e) {
            e.preventDefault();
            const kode_ta = $(this).attr('kode_ta');
            $('#mdlEdit').modal("show");
            $("#mdlEdit").find("#loadEdit").html(loading);
            $("#loadEdit").load(`/tahunajaran/${kode_ta}/edit`);
        });

        $(document).on('click', '.delete-confirm', function(e) {
            e.preventDefault();
            const form = $(this).closest("form");
            Swal.fire({
                title: 'Hapus Tahun Ajaran?',
                text: "Data tahun ajaran ini akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#059669',
                cancelButtonColor: '#e11d48',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    confirmButton: 'px-4 py-2 bg-emerald-600 text-white font-bold rounded-xl text-xs mr-2',
                    cancelButton: 'px-4 py-2 bg-slate-200 text-slate-700 font-bold rounded-xl text-xs'
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
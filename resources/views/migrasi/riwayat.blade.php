@extends('layouts.app')
@section('titlepage', 'Riwayat Migrasi Data Siswa')

@section('content')
<div class="space-y-6">

    <!-- ================= 1. PAGE HEADER (NO CARD) WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center border border-emerald-200/80 shadow-2xs">
                    <i class="ti ti-history text-2xl"></i>
                </div>
                <span>Riwayat & Log Migrasi Siswa</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Daftar berkas Excel yang pernah di-import, rekapitulasi baris data, dan kontrol Rollback batch
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
                <a href="{{ route('migrasi-siswa.index') }}" class="hover:text-slate-700 transition flex items-center gap-1">
                    <i class="ti ti-database-import text-sm"></i>
                    <span>Migrasi Siswa</span>
                </a>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Riwayat</span>
            </nav>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('migrasi-siswa.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs transition-all duration-200 active:scale-95">
                    <i class="ti ti-plus text-base"></i>
                    <span>Import File Baru</span>
                </a>
            </div>
        </div>
    </div>

    <!-- ================= 2. SOLID EMERALD TABLE CARD ================= -->
    <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
        <!-- Solid Emerald Header -->
        <div class="bg-emerald-600 px-5 py-4 flex items-center justify-between text-white">
            <div class="flex items-center gap-2.5">
                <i class="ti ti-list-details text-xl"></i>
                <h3 class="font-bold text-sm tracking-wide text-white">Daftar Log Riwayat Import Excel</h3>
            </div>
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-white/20 text-white backdrop-blur-xs">
                Total: {{ $riwayat->total() }} Batch
            </span>
        </div>

        <!-- Table Container -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse whitespace-nowrap">
                <thead>
                    <tr class="bg-emerald-600 text-white uppercase text-[11px] font-extrabold tracking-wider border-t border-emerald-500/50">
                        <th class="py-2.5 px-3.5 w-12 text-center whitespace-nowrap">NO</th>
                        <th class="py-2.5 px-4 whitespace-nowrap">WAKTU IMPORT</th>
                        <th class="py-2.5 px-4 whitespace-nowrap">NAMA BERKAS</th>
                        <th class="py-2.5 px-3.5 text-center whitespace-nowrap">TAHUN AJARAN</th>
                        <th class="py-2.5 px-3 text-center whitespace-nowrap">TOTAL</th>
                        <th class="py-2.5 px-3 text-center whitespace-nowrap">BERHASIL</th>
                        <th class="py-2.5 px-3 text-center whitespace-nowrap">GAGAL</th>
                        <th class="py-2.5 px-3.5 text-center whitespace-nowrap">STATUS</th>
                        <th class="py-2.5 px-3.5 text-center w-28 whitespace-nowrap">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                    @forelse($riwayat as $log)
                        <tr class="hover:bg-slate-50/80 transition-colors group">
                            <!-- No -->
                            <td class="py-2.5 px-3.5 text-center font-bold text-slate-400 whitespace-nowrap">
                                {{ $loop->iteration + $riwayat->firstItem() - 1 }}
                            </td>

                            <!-- Waktu Import -->
                            <td class="py-2.5 px-4 whitespace-nowrap font-medium">
                                <div class="font-bold text-slate-900">{{ $log->created_at->format('d M Y') }}</div>
                                <div class="text-slate-400 text-[11px]">
                                    {{ $log->created_at->format('H:i:s') }} &bull; {{ $log->user->name ?? 'System' }}
                                </div>
                            </td>

                            <!-- Nama File -->
                            <td class="py-2.5 px-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center font-bold text-xs shrink-0">
                                        <i class="ti ti-file-spreadsheet"></i>
                                    </div>
                                    <span class="font-semibold text-slate-800 truncate max-w-xs block" title="{{ $log->nama_file }}">
                                        {{ $log->nama_file }}
                                    </span>
                                </div>
                            </td>

                            <!-- Tahun Ajaran -->
                            <td class="py-2.5 px-3.5 text-center whitespace-nowrap">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-lg bg-slate-100 text-slate-700 font-mono text-[11px] font-bold border border-slate-200">
                                    {{ $log->kode_ta }}
                                </span>
                            </td>

                            <!-- Total Baris -->
                            <td class="py-2.5 px-3 text-center font-bold text-slate-700 whitespace-nowrap">
                                {{ $log->total_baris }}
                            </td>

                            <!-- Berhasil -->
                            <td class="py-2.5 px-3 text-center whitespace-nowrap">
                                <span class="font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-200/80">
                                    {{ $log->berhasil }}
                                </span>
                            </td>

                            <!-- Gagal -->
                            <td class="py-2.5 px-3 text-center whitespace-nowrap">
                                @if($log->gagal > 0)
                                    <span class="font-bold text-rose-700 bg-rose-50 px-2 py-0.5 rounded-md border border-rose-200/80">
                                        {{ $log->gagal }}
                                    </span>
                                @else
                                    <span class="text-slate-300 font-bold">0</span>
                                @endif
                            </td>

                            <!-- Status -->
                            <td class="py-2.5 px-3.5 text-center whitespace-nowrap">
                                @if($log->status == 'done')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-300">
                                        <i class="ti ti-circle-check text-xs"></i>
                                        <span>Selesai</span>
                                    </span>
                                @elseif($log->status == 'processing')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-100 text-amber-800 border border-amber-300 animate-pulse">
                                        <i class="ti ti-loader text-xs"></i>
                                        <span>Memproses</span>
                                    </span>
                                @elseif($log->status == 'error')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-rose-100 text-rose-800 border border-rose-300">
                                        <i class="ti ti-alert-triangle text-xs"></i>
                                        <span>Error</span>
                                    </span>
                                @elseif($log->status == 'rolled_back')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-slate-100 text-slate-600 border border-slate-300">
                                        <i class="ti ti-arrow-back-up text-xs"></i>
                                        <span>Rolled Back</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-bold bg-sky-100 text-sky-800">
                                        {{ ucfirst($log->status) }}
                                    </span>
                                @endif
                            </td>

                            <!-- Aksi -->
                            <td class="py-2.5 px-3.5 text-center whitespace-nowrap">
                                @if($log->status == 'done' && $log->berhasil > 0)
                                    <form action="{{ route('migrasi-siswa.rollback', $log->id) }}" method="POST" class="inline rollback-form">
                                        @csrf
                                        <button type="button" 
                                                class="px-2.5 py-1 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold text-[11px] border border-rose-200 transition inline-flex items-center gap-1 btn-rollback cursor-pointer active:scale-95"
                                                title="Hapus / Rollback Seluruh Data Batch Ini">
                                            <i class="ti ti-arrow-back-up text-xs"></i>
                                            <span>Rollback</span>
                                        </button>
                                    </form>
                                @elseif($log->status == 'processing')
                                    <a href="{{ route('migrasi-siswa.preview', $log->id) }}" class="px-2.5 py-1 rounded-lg bg-sky-50 hover:bg-sky-100 text-sky-700 font-bold text-[11px] border border-sky-200 transition inline-flex items-center gap-1">
                                        <i class="ti ti-eye text-xs"></i>
                                        <span>Lihat Validasi</span>
                                    </a>
                                @else
                                    <span class="text-slate-400 text-xs">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="py-12 px-4 text-center">
                                <div class="w-16 h-16 mx-auto mb-3 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-3xl">
                                    <i class="ti ti-file-off"></i>
                                </div>
                                <h4 class="font-bold text-slate-800 text-sm">Belum Ada Riwayat Migrasi</h4>
                                <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">
                                    Berkas Excel yang pernah Anda import dan validasi akan tersimpan dalam daftar ini.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($riwayat->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $riwayat->links() }}
            </div>
        @endif
    </div>

</div>
@endsection

@push('myscript')
<script>
    $(document).ready(function() {
        $('.btn-rollback').click(function(e) {
            e.preventDefault();
            let form = $(this).closest('form');
            
            Swal.fire({
                title: "Konfirmasi Rollback Migrasi?",
                html: "Anda akan melakukan <b>Rollback data</b>.<br><br>Seluruh data pendaftaran, tagihan biaya, dan mutasi dari batch berkas ini akan <span class='text-rose-600 font-bold'>DIHAPUS PERMANEN</span> dari sistem.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#e11d48",
                cancelButtonColor: "#64748b",
                confirmButtonText: "Ya, Hapus Permanen!",
                cancelButtonText: "Batal",
                customClass: {
                    popup: 'rounded-2xl shadow-xl border border-slate-100',
                    confirmButton: 'px-5 py-2 font-bold rounded-xl text-xs',
                    cancelButton: 'px-5 py-2 font-bold rounded-xl text-xs'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Memproses Rollback...',
                        text: 'Mohon tunggu, jangan menutup jendela browser.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading()
                        }
                    });
                    
                    form.submit();
                }
            });
        });
    });
</script>
@endpush


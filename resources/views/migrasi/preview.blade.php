@extends('layouts.app')
@section('titlepage', 'Preview Migrasi Siswa')

@section('content')
<div class="space-y-6">

    <!-- ================= 1. PAGE HEADER (NO CARD) WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center border border-emerald-200/80 shadow-2xs">
                    <i class="ti ti-file-analytics text-2xl"></i>
                </div>
                <span>Hasil Validasi Migrasi Data</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Nama Berkas: <strong class="text-slate-800 font-mono">{{ $log->nama_file }}</strong>
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
                <span class="font-bold text-slate-800">Preview Validasi</span>
            </nav>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('migrasi-siswa.index') }}" class="inline-flex items-center gap-2 px-3.5 py-2.5 bg-white hover:bg-slate-100 text-slate-700 font-bold rounded-xl text-xs border border-slate-300/90 shadow-2xs transition-all duration-200 active:scale-95">
                    <i class="ti ti-arrow-left text-base text-emerald-600"></i>
                    <span>Kembali / Batal</span>
                </a>
            </div>
        </div>
    </div>

    <!-- ================= 2. SUMMARY METRICS CARDS ================= -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <!-- Total Rows -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-700 flex items-center justify-center text-2xl font-black shrink-0 border border-slate-200">
                <i class="ti ti-list"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Baris Diproses</p>
                <h3 class="text-2xl font-black text-slate-800 tracking-tight mt-0.5">{{ $log->total_baris }}</h3>
            </div>
        </div>

        <!-- Valid Rows -->
        <div class="bg-white border border-emerald-200/90 rounded-2xl p-5 shadow-xs flex items-center gap-4 border-l-4 border-l-emerald-600">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-2xl font-black shrink-0 border border-emerald-200/80">
                <i class="ti ti-check"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-emerald-600 uppercase tracking-wider">Data Valid (Siap Simpan)</p>
                <h3 class="text-2xl font-black text-emerald-800 tracking-tight mt-0.5">{{ $log->berhasil }}</h3>
            </div>
        </div>

        <!-- Error Rows -->
        <div class="bg-white border border-rose-200/90 rounded-2xl p-5 shadow-xs flex items-center gap-4 border-l-4 border-l-rose-500">
            <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-2xl font-black shrink-0 border border-rose-200/80">
                <i class="ti ti-alert-triangle"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-rose-500 uppercase tracking-wider">Data Gagal / Error</p>
                <h3 class="text-2xl font-black text-rose-700 tracking-tight mt-0.5">{{ $log->gagal }}</h3>
            </div>
        </div>
    </div>

    <!-- ================= 3. ERROR TABLE SECTION (IF ANY) ================= -->
    @if($log->gagal > 0)
        <div class="bg-white border border-rose-200/90 rounded-2xl shadow-xs overflow-hidden">
            <!-- Header Rose -->
            <div class="bg-rose-600 px-5 py-4 flex items-center justify-between text-white">
                <div class="flex items-center gap-2.5">
                    <i class="ti ti-alert-circle text-xl"></i>
                    <h3 class="font-bold text-sm tracking-wide text-white">Daftar Baris yang Mengalami Error ({{ $log->gagal }} Data)</h3>
                </div>
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-white/20 text-white backdrop-blur-xs">
                    Perlu Perbaikan
                </span>
            </div>

            <!-- Table Container -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse whitespace-nowrap">
                    <thead>
                        <tr class="bg-rose-600 text-white uppercase text-[11px] font-extrabold tracking-wider border-t border-rose-500/50">
                            <th class="py-2.5 px-3.5 w-24 text-center whitespace-nowrap">BARIS EXCEL</th>
                            <th class="py-2.5 px-4 whitespace-nowrap">KETERANGAN / ESTIMASI</th>
                            <th class="py-2.5 px-4 whitespace-nowrap">DESKRIPSI PENYEBAB GAGAL</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-rose-100 text-xs text-slate-700">
                        @foreach($error_data as $err)
                            <tr class="hover:bg-rose-50/40 transition-colors">
                                <td class="py-2.5 px-3.5 text-center font-mono font-bold text-rose-700 whitespace-nowrap">
                                    <span class="px-2 py-0.5 bg-rose-50 rounded border border-rose-200">
                                        Baris {{ $err->baris_excel }}
                                    </span>
                                </td>
                                <td class="py-2.5 px-4 whitespace-nowrap text-slate-500 italic">
                                    Cek baris ke-{{ $err->baris_excel }} pada file Excel Anda
                                </td>
                                <td class="py-2.5 px-4 whitespace-nowrap text-rose-600 font-semibold">
                                    {{ $err->keterangan }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-3.5 bg-rose-50/60 border-t border-rose-100 text-[11px] text-rose-800 font-medium flex items-center gap-2">
                <i class="ti ti-info-circle text-rose-600 text-base shrink-0"></i>
                <span>Data yang error <strong class="underline">tidak akan disimpan</strong> ke database. Anda dapat memperbaiki file Excel dan upload ulang, atau melanjutkan import untuk data yang valid saja.</span>
            </div>
        </div>
    @endif

    <!-- ================= 4. VALID DATA PREVIEW TABLE ================= -->
    @if($log->berhasil > 0)
        <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
            <!-- Solid Emerald Header -->
            <div class="bg-emerald-600 px-5 py-4 flex items-center justify-between text-white">
                <div class="flex items-center gap-2.5">
                    <i class="ti ti-circle-check text-xl"></i>
                    <h3 class="font-bold text-sm tracking-wide text-white">Preview Data Valid yang Siap Disimpan</h3>
                </div>
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-white/20 text-white backdrop-blur-xs">
                    {{ $valid_data->count() }} Data Siap
                </span>
            </div>

            <!-- Table Container -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse whitespace-nowrap">
                    <thead>
                        <tr class="bg-emerald-600 text-white uppercase text-[11px] font-extrabold tracking-wider border-t border-emerald-500/50">
                            <th class="py-2.5 px-3.5 w-24 text-center whitespace-nowrap">BARIS</th>
                            <th class="py-2.5 px-4 whitespace-nowrap">NO PENDAFTARAN / NIS</th>
                            <th class="py-2.5 px-4 whitespace-nowrap">ID SISWA</th>
                            <th class="py-2.5 px-3.5 text-center whitespace-nowrap">STATUS SISWA</th>
                            <th class="py-2.5 px-4 whitespace-nowrap">KETERANGAN IMPORT</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                        @foreach($valid_data->take(50) as $valid)
                            <tr class="hover:bg-slate-50/80 transition-colors group">
                                <td class="py-2.5 px-3.5 text-center font-bold text-slate-400 font-mono whitespace-nowrap">
                                    {{ $valid->baris_excel }}
                                </td>
                                <td class="py-2.5 px-4 whitespace-nowrap">
                                    <div class="font-bold text-slate-900 group-hover:text-emerald-700 transition-colors">
                                        {{ $valid->no_pendaftaran }}
                                    </div>
                                    @if(isset($valid->pendaftaran->nis))
                                        <div class="text-[11px] font-mono text-slate-400">NIS: {{ $valid->pendaftaran->nis }}</div>
                                    @endif
                                </td>
                                <td class="py-2.5 px-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-lg bg-slate-100 text-slate-700 font-mono text-[11px] font-bold border border-slate-200">
                                        {{ $valid->id_siswa }}
                                    </span>
                                </td>
                                <td class="py-2.5 px-3.5 text-center whitespace-nowrap">
                                    @if($valid->is_new_siswa)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-300/80">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                            <span>Siswa Baru</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-100 text-amber-800 border border-amber-300/80">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                            <span>Sudah Ada</span>
                                        </span>
                                    @endif
                                </td>
                                <td class="py-2.5 px-4 whitespace-nowrap text-slate-600 text-xs">
                                    {{ $valid->keterangan }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($valid_data->count() > 50)
                <div class="p-3.5 bg-slate-50 border-t border-slate-100 text-center text-xs text-slate-500">
                    Menampilkan 50 data valid pertama dari total <strong class="text-slate-800">{{ $valid_data->count() }}</strong> baris valid.
                </div>
            @endif
        </div>
    @endif

    <!-- ================= 5. ACTION BUTTONS ================= -->
    <div class="flex items-center justify-end gap-3 pt-2 pb-6">
        <a href="{{ route('migrasi-siswa.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs transition inline-flex items-center gap-2 cursor-pointer">
            <i class="ti ti-x text-base"></i>
            <span>Batalkan Migrasi</span>
        </a>
        
        @if($log->berhasil > 0)
            <form action="{{ route('migrasi-siswa.proses', $log->id) }}" method="POST" id="formKonfirmasiMigrasi">
                @csrf
                <button type="submit" id="btnKonfirmasiMigrasi" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs transition-all inline-flex items-center gap-2 active:scale-95 cursor-pointer">
                    <i class="ti ti-device-floppy text-base"></i>
                    <span>Konfirmasi & Simpan Permanen ({{ $log->berhasil }} Siswa)</span>
                </button>
            </form>
        @endif
    </div>

</div>
@endsection

@push('myscript')
<script>
    $(function() {
        $('#formKonfirmasiMigrasi').on('submit', function() {
            const $btn = $('#btnKonfirmasiMigrasi');
            $btn.prop('disabled', true).addClass('opacity-75 cursor-not-allowed');
            $btn.html(`
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Menyimpan Seluruh Data ke Database...</span>
            `);
        });
    });
</script>
@endpush


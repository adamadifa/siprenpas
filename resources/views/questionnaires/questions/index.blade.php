@extends('layouts.app')
@section('titlepage', 'Kelola Butir Pertanyaan')

@section('content')
<div class="space-y-5">

    <!-- ================= 1. PAGE HEADER WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center border border-emerald-200/80 shadow-2xs">
                    <i class="ti ti-list-details text-2xl"></i>
                </div>
                <span>Kelola Butir Pertanyaan</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Kuisioner: <strong class="text-emerald-700 font-bold">{{ $questionnaire->title }}</strong>
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
                <a href="{{ route('admin.questionnaires.index') }}" class="hover:text-slate-700 transition">Kuisioner</a>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Butir Pertanyaan</span>
            </nav>

            <div class="flex items-center gap-2">
                <a href="{{ route('admin.questionnaires.index') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white hover:bg-slate-50 text-slate-700 font-bold rounded-xl text-xs border border-slate-200 shadow-2xs transition active:scale-95">
                    <i class="ti ti-arrow-left text-base text-slate-500"></i>
                    <span>Kembali ke Kuisioner</span>
                </a>
                <a href="{{ route('admin.questionnaires.questions.create', $questionnaire->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs transition-all duration-200 active:scale-95 cursor-pointer border-0">
                    <i class="ti ti-plus text-base"></i>
                    <span>Tambah Pertanyaan</span>
                </a>
            </div>
        </div>
    </div>

    <!-- ================= 2. SUMMARY CARD ================= -->
    <div class="p-4 bg-emerald-50/70 border border-emerald-200/80 rounded-2xl flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="flex items-start gap-3">
            <div class="w-9 h-9 rounded-xl bg-emerald-600 text-white flex items-center justify-center shrink-0 shadow-xs">
                <i class="ti ti-clipboard-text text-lg"></i>
            </div>
            <div>
                <h3 class="text-xs font-black text-slate-900 leading-snug">{{ $questionnaire->title }}</h3>
                <p class="text-[11px] text-slate-500 mt-0.5 leading-relaxed">
                    {{ $questionnaire->description ?: 'Tidak ada deskripsi kuisioner.' }}
                </p>
            </div>
        </div>
        <div class="flex items-center gap-2 shrink-0 self-start sm:self-auto">
            <span class="px-3 py-1 rounded-xl text-xs font-bold bg-white text-emerald-800 border border-emerald-200 shadow-2xs">
                Total: {{ $questionnaire->questions->count() }} Butir Soal
            </span>
            <a href="{{ route('admin.questionnaires.report', $questionnaire->id) }}" class="px-3 py-1 rounded-xl text-xs font-bold bg-emerald-600 hover:bg-emerald-700 text-white shadow-2xs transition flex items-center gap-1">
                <i class="ti ti-chart-bar text-sm"></i>
                <span>Lihat Hasil</span>
            </a>
        </div>
    </div>

    <!-- ================= 3. CARD TABLE LIST ================= -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
        <!-- Solid Emerald Card Header -->
        <div class="bg-emerald-600 px-4 py-3 sm:px-5 sm:py-3.5 flex items-center justify-between flex-wrap gap-2.5">
            <div class="flex items-center gap-2 text-white">
                <i class="ti ti-help-circle text-lg"></i>
                <h2 class="text-sm sm:text-base font-extrabold tracking-tight">
                    Daftar Pertanyaan & Pilihan Jawaban
                </h2>
                <span class="px-2 py-0.5 text-[11px] font-bold rounded-full bg-white/20 text-white border border-white/20">
                    {{ $questionnaire->questions->count() }} Pertanyaan
                </span>
            </div>
        </div>

        <!-- Table Responsive -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700 border-collapse">
                <thead class="bg-emerald-600 text-white uppercase text-[11px] font-extrabold tracking-wider border-t border-emerald-500/50">
                    <tr>
                        <th class="py-2.5 px-3.5 text-center w-12">NO.</th>
                        <th class="py-2.5 px-3.5 min-w-[300px]">TEKS PERTANYAAN</th>
                        <th class="py-2.5 px-3.5 min-w-[320px]">OPSI JAWABAN</th>
                        <th class="py-2.5 px-3.5 text-center w-36">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-[12px]">
                    @forelse($questionnaire->questions as $q)
                        <tr class="hover:bg-emerald-50/40 transition-colors">
                            <!-- Number -->
                            <td class="py-3 px-3.5 text-center font-bold text-slate-500 whitespace-nowrap align-top">
                                {{ $loop->iteration }}
                            </td>

                            <!-- Question Text -->
                            <td class="py-3 px-3.5 font-bold text-slate-900 align-top">
                                <div class="flex items-start gap-2.5">
                                    <div class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center font-black text-xs border border-emerald-200 shrink-0 mt-0.5">
                                        Q{{ $loop->iteration }}
                                    </div>
                                    <div class="text-xs font-bold text-slate-900 leading-relaxed">
                                        {{ $q->question }}
                                    </div>
                                </div>
                            </td>

                            <!-- Options Badges -->
                            <td class="py-3 px-3.5 align-top">
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach($q->options as $idx => $opt)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold bg-slate-50 text-slate-700 border border-slate-200/90 shadow-2xs">
                                            <span class="w-4 h-4 rounded-md bg-emerald-600 text-white text-[10px] font-bold flex items-center justify-center shrink-0">
                                                {{ chr(65 + $idx) }}
                                            </span>
                                            <span>{{ $opt->option_text }}</span>
                                        </span>
                                    @endforeach
                                </div>
                            </td>

                            <!-- Actions -->
                            <td class="py-3 px-3.5 text-center whitespace-nowrap align-top">
                                <div class="flex items-center justify-center gap-1.5">
                                    <!-- Edit -->
                                    <a href="{{ route('admin.questionnaires.questions.edit', [$questionnaire->id, $q->id]) }}" 
                                        class="w-8 h-8 rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-700 flex items-center justify-center border border-amber-200 shadow-2xs transition active:scale-95"
                                        title="Edit Pertanyaan & Opsi">
                                        <i class="ti ti-edit text-base"></i>
                                    </a>

                                    <!-- Delete -->
                                    <form action="{{ route('admin.questionnaires.questions.destroy', [$questionnaire->id, $q->id]) }}" method="POST" class="deleteform inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-confirm w-8 h-8 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 flex items-center justify-center border border-rose-200 shadow-2xs transition active:scale-95 cursor-pointer" title="Hapus Pertanyaan">
                                            <i class="ti ti-trash text-base"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center text-slate-400 text-xs">
                                <i class="ti ti-help-off text-4xl mb-2 block text-slate-300"></i>
                                Belum ada butir pertanyaan untuk kuisioner ini.
                                <div class="mt-3">
                                    <a href="{{ route('admin.questionnaires.questions.create', $questionnaire->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg text-xs shadow-xs transition">
                                        <i class="ti ti-plus text-sm"></i>
                                        <span>Tambah Pertanyaan Sekarang</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('myscript')
<script>
    $(document).ready(function() {
        $(".delete-confirm").click(function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            Swal.fire({
                title: 'Hapus Pertanyaan?',
                text: "Butir pertanyaan beserta pilihan dan jawaban responden terkait akan dihapus secara permanen.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#059669',
                cancelButtonColor: '#e11d48',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    confirmButton: 'rounded-xl font-bold px-4 py-2',
                    cancelButton: 'rounded-xl font-bold px-4 py-2'
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

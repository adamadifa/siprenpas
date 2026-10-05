@extends('layouts.app')
@section('titlepage', 'Edit Pertanyaan Kuisioner')

@section('content')
<div class="space-y-5 max-w-4xl mx-auto">

    <!-- ================= 1. PAGE HEADER WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center border border-emerald-200/80 shadow-2xs">
                    <i class="ti ti-edit text-2xl"></i>
                </div>
                <span>Edit Pertanyaan Kuisioner</span>
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
                <a href="{{ route('admin.questionnaires.questions.index', $questionnaire->id) }}" class="hover:text-slate-700 transition">Butir Pertanyaan</a>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Edit</span>
            </nav>

            <a href="{{ route('admin.questionnaires.questions.index', $questionnaire->id) }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white hover:bg-slate-50 text-slate-700 font-bold rounded-xl text-xs border border-slate-200 shadow-2xs transition active:scale-95">
                <i class="ti ti-arrow-left text-base text-slate-500"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <!-- ================= 2. FORM CARD ================= -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
        <!-- Header banner -->
        <div class="bg-emerald-600 px-5 py-3.5 flex items-center gap-2 text-white">
            <i class="ti ti-edit text-lg"></i>
            <h2 class="text-sm font-extrabold tracking-tight">Perbarui Pertanyaan & Opsi Jawaban</h2>
        </div>

        <form action="{{ route('admin.questionnaires.questions.update', [$questionnaire->id, $question->id]) }}" method="POST" id="formEditQuestion" class="p-5 sm:p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Pertanyaan Field -->
            <div>
                <label for="question" class="block text-xs font-bold text-slate-700 mb-1.5">
                    Teks Pertanyaan <span class="text-rose-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                        <i class="ti ti-help text-base"></i>
                    </span>
                    <input type="text" 
                           name="question" 
                           id="question" 
                           value="{{ old('question', $question->question) }}" 
                           required 
                           autofocus
                           placeholder="Masukkan teks pertanyaan..."
                           class="w-full pl-11 pr-4 py-2.5 bg-slate-50/70 border @error('question') border-rose-400 bg-rose-50/30 @else border-slate-300 @enderror rounded-xl text-xs font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                </div>
                @error('question')
                    <div class="text-rose-500 text-[11px] font-semibold mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Opsi Jawaban Section -->
            <div class="space-y-3 pt-2">
                <div class="flex items-center justify-between">
                    <div>
                        <label class="block text-xs font-bold text-slate-700">
                            Pilihan Opsi Jawaban <span class="text-rose-500">*</span>
                        </label>
                        <p class="text-[11px] text-slate-500">Minimal 2 pilihan opsi jawaban</p>
                    </div>
                    <button type="button" id="btn-tambah-opsi" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-bold rounded-xl text-xs border border-emerald-200 shadow-2xs transition active:scale-95 cursor-pointer">
                        <i class="ti ti-plus text-sm"></i>
                        <span>Tambah Opsi</span>
                    </button>
                </div>

                <div id="opsi-list" class="space-y-2.5">
                    @foreach ($question->options as $idx => $opt)
                        <div class="flex items-center gap-2 option-row">
                            <span class="w-8 h-9 rounded-xl bg-emerald-600 text-white text-xs font-black flex items-center justify-center shrink-0 shadow-2xs option-letter">
                                {{ chr(65 + $idx) }}
                            </span>
                            <input type="text" 
                                   name="options[]" 
                                   value="{{ old('options.' . $idx, $opt->option_text) }}" 
                                   required 
                                   placeholder="Pilihan opsi..." 
                                   class="flex-1 px-3.5 py-2 bg-slate-50/70 border @error('options.' . $idx) border-rose-400 @else border-slate-300 @enderror rounded-xl text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                            <button type="button" class="btn-remove-opsi w-9 h-9 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-600 flex items-center justify-center border border-rose-200 transition active:scale-95 cursor-pointer shrink-0" title="Hapus Opsi">
                                <i class="ti ti-trash text-base"></i>
                            </button>
                        </div>
                    @endforeach
                </div>
                @error('options')
                    <div class="text-rose-500 text-[11px] font-semibold mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Bottom Actions -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-between gap-3">
                <a href="{{ route('admin.questionnaires.questions.index', $questionnaire->id) }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs transition active:scale-95">
                    Batal
                </a>
                <button type="submit" id="btnSubmit" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs transition active:scale-95 flex items-center gap-2 cursor-pointer border-0">
                    <i class="ti ti-device-floppy text-base"></i>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('myscript')
<script>
    $(document).ready(function() {
        function updateOptionLetters() {
            $('#opsi-list .option-row').each(function(i, el) {
                $(el).find('.option-letter').text(String.fromCharCode(65 + i));
            });
        }

        // Tambah opsi baru
        $('#btn-tambah-opsi').click(function() {
            let idx = $('#opsi-list .option-row').length;
            let letter = String.fromCharCode(65 + idx);
            let html = `
                <div class="flex items-center gap-2 option-row animate-fadein">
                    <span class="w-8 h-9 rounded-xl bg-emerald-600 text-white text-xs font-black flex items-center justify-center shrink-0 shadow-2xs option-letter">
                        ${letter}
                    </span>
                    <input type="text" 
                           name="options[]" 
                           required 
                           placeholder="Pilihan opsi ${letter}..." 
                           class="flex-1 px-3.5 py-2 bg-slate-50/70 border border-slate-300 rounded-xl text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                    <button type="button" class="btn-remove-opsi w-9 h-9 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-600 flex items-center justify-center border border-rose-200 transition active:scale-95 cursor-pointer shrink-0" title="Hapus Opsi">
                        <i class="ti ti-trash text-base"></i>
                    </button>
                </div>`;
            $('#opsi-list').append(html);
        });

        // Hapus opsi
        $(document).on('click', '.btn-remove-opsi', function() {
            if ($('#opsi-list .option-row').length <= 2) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Minimal harus ada 2 opsi jawaban!',
                    confirmButtonColor: '#059669'
                });
                return;
            }
            $(this).closest('.option-row').remove();
            updateOptionLetters();
        });

        $('#formEditQuestion').on('submit', function() {
            $('#btnSubmit').prop('disabled', true).html('<i class="ti ti-loader animate-spin text-base"></i> Menyimpan...');
        });
    });
</script>
@endpush

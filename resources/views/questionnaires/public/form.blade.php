@extends('questionnaires.public.layout')
@section('title', $questionnaire->title)

@section('content')
<div class="max-w-2xl w-full mx-auto space-y-6">

    <!-- Header Banner -->
    <div class="bg-white rounded-2xl border border-slate-200/90 p-5 sm:p-6 shadow-xs space-y-2">
        <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-800 text-[11px] font-bold border border-emerald-200">
            <i class="ti ti-survey text-xs"></i>
            <span>Formulir Pengisian Survei</span>
        </div>
        <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
            {{ $questionnaire->title }}
        </h1>
        @if($questionnaire->description)
            <p class="text-xs sm:text-sm text-slate-500 leading-relaxed pt-1">
                {{ $questionnaire->description }}
            </p>
        @endif
    </div>

    <!-- Questionnaire Form -->
    <form action="{{ route('questionnaire.submit', $questionnaire->id) }}" method="POST" id="formPublicKuisioner" class="space-y-5">
        @csrf

        <!-- Responden Info Card (Optional Name & Email) -->
        <div class="bg-white rounded-2xl border border-slate-200/90 p-5 sm:p-6 shadow-xs space-y-4">
            <h2 class="text-xs font-bold uppercase tracking-wider text-slate-400 flex items-center gap-1.5">
                <i class="ti ti-user text-emerald-600 text-sm"></i>
                <span>Data Responden (Opsional)</span>
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                <div>
                    <label for="name" class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap</label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           placeholder="Nama Anda (opsional)" 
                           class="w-full px-3.5 py-2.5 bg-slate-50/70 border border-slate-300 rounded-xl text-xs font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                </div>
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 mb-1">Email / Kontak</label>
                    <input type="email" 
                           name="email" 
                           id="email" 
                           placeholder="alamat@email.com (opsional)" 
                           class="w-full px-3.5 py-2.5 bg-slate-50/70 border border-slate-300 rounded-xl text-xs font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                </div>
            </div>
        </div>

        <!-- Questions List -->
        @foreach($questionnaire->questions as $i => $question)
            <div class="bg-white rounded-2xl border border-slate-200/90 p-5 sm:p-6 shadow-xs space-y-3.5">
                <div class="flex items-start gap-3">
                    <span class="w-6 h-6 rounded-lg bg-emerald-600 text-white font-black text-xs flex items-center justify-center shrink-0 mt-0.5 shadow-2xs">
                        {{ $i + 1 }}
                    </span>
                    <h3 class="text-sm font-extrabold text-slate-900 leading-snug">
                        {{ $question->question }}
                    </h3>
                </div>

                <div class="space-y-2 pt-1 pl-9">
                    @foreach($question->options as $optIdx => $option)
                        <label class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 bg-slate-50/60 hover:bg-emerald-50/60 hover:border-emerald-300 transition cursor-pointer group">
                            <input type="radio" 
                                   name="answers[{{ $question->id }}]" 
                                   value="{{ $option->id }}" 
                                   required 
                                   class="w-4 h-4 text-emerald-600 border-slate-300 focus:ring-emerald-500">
                            <span class="text-xs font-bold text-slate-700 group-hover:text-emerald-900 transition">
                                {{ $option->option_text }}
                            </span>
                        </label>
                    @endforeach
                </div>
            </div>
        @endforeach

        <!-- Submit Button -->
        <div class="pt-2">
            <button type="submit" 
                    id="btnSubmitPublic" 
                    class="w-full py-3.5 px-6 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold rounded-2xl text-sm shadow-md transition active:scale-98 flex items-center justify-center gap-2 cursor-pointer border-0">
                <i class="ti ti-send text-base"></i>
                <span>Kirim Jawaban Kuisioner</span>
            </button>
        </div>
    </form>

</div>
@endsection

@push('myscript')
<script>
    document.getElementById('formPublicKuisioner')?.addEventListener('submit', function() {
        const btn = document.getElementById('btnSubmitPublic');
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<i class="ti ti-loader animate-spin text-base"></i> Mengirim Jawaban...';
        }
    });
</script>
@endpush

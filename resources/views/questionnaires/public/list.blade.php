@extends('questionnaires.public.layout')
@section('title', 'Daftar Kuisioner & Survei')

@section('content')
<div class="max-w-2xl w-full mx-auto space-y-6">

    <!-- Header Card -->
    <div class="text-center space-y-2">
        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold border border-emerald-200">
            <i class="ti ti-clipboard-check text-sm"></i>
            <span>Instrumen Survei & Evaluasi</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
            Daftar Kuisioner Publik
        </h1>
        <p class="text-xs sm:text-sm text-slate-500 max-w-md mx-auto">
            Silakan pilih kuisioner di bawah ini untuk memberikan penilaian dan masukan Anda demi peningkatan mutu kami.
        </p>
    </div>

    <!-- Questionnaire List -->
    <div class="space-y-3">
        @forelse($questionnaires as $q)
            <a href="{{ route('questionnaire.form', $q->id) }}" class="group block p-4 sm:p-5 bg-white hover:bg-emerald-50/50 rounded-2xl border border-slate-200/90 hover:border-emerald-300 shadow-xs hover:shadow-md transition-all duration-200">
                <div class="flex items-center justify-between gap-4">
                    <div class="flex items-start gap-3.5">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 group-hover:bg-emerald-600 text-emerald-700 group-hover:text-white flex items-center justify-center shrink-0 border border-emerald-200/80 transition shadow-2xs">
                            <i class="ti ti-notes text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-sm sm:text-base font-extrabold text-slate-900 group-hover:text-emerald-700 transition">
                                {{ $q->title }}
                            </h2>
                            <p class="text-xs text-slate-500 mt-1 line-clamp-2">
                                {{ $q->description ?: 'Klik untuk mulai mengisi kuisioner ini.' }}
                            </p>
                        </div>
                    </div>

                    <div class="shrink-0 flex items-center gap-2 text-slate-400 group-hover:text-emerald-600 group-hover:translate-x-1 transition">
                        <span class="text-xs font-bold hidden sm:inline">Mulai Isi</span>
                        <i class="ti ti-chevron-right text-lg"></i>
                    </div>
                </div>
            </a>
        @empty
            <div class="bg-white rounded-2xl border border-slate-200 p-8 text-center text-slate-400">
                <i class="ti ti-clipboard-off text-4xl mb-2 text-slate-300 block"></i>
                <h3 class="text-sm font-bold text-slate-700">Belum Ada Kuisioner Aktif</h3>
                <p class="text-xs text-slate-400 mt-1">Saat ini belum ada survei atau kuisioner yang dapat diisi.</p>
            </div>
        @endforelse
    </div>

</div>
@endsection

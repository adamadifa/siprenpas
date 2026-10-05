@extends('questionnaires.public.layout')
@section('title', 'Terima Kasih Atas Partisipasi Anda')

@section('content')
<div class="max-w-xl w-full mx-auto">
    <div class="bg-white rounded-3xl border border-slate-200/90 p-8 sm:p-10 shadow-lg text-center space-y-6">
        
        <!-- Lottie / Icon Animation -->
        <div class="flex justify-center">
            <lottie-player
                src="https://lottie.host/1e84c075-52db-498d-9bac-af30c05f9f20/U8vf0bmZcE.json"
                background="transparent"
                speed="1"
                style="width: 140px; height: 140px;"
                autoplay
                loop
            ></lottie-player>
        </div>

        <div class="space-y-2">
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold border border-emerald-200">
                <i class="ti ti-check text-sm"></i>
                <span>Jawaban Berhasil Dikirim</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                Terima Kasih!
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 max-w-sm mx-auto leading-relaxed">
                Jawaban survei Anda telah kami simpan. Setiap tanggapan Anda sangat berharga bagi peningkatan kualitas layanan Pesantren Persis Al-Amin.
            </p>
        </div>

        <div class="pt-2">
            <a href="{{ route('questionnaires.list') }}"
                class="inline-flex items-center justify-center gap-2 w-full sm:w-auto px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition active:scale-95">
                <i class="ti ti-arrow-left text-sm"></i>
                <span>Kembali ke Daftar Kuisioner</span>
            </a>
        </div>
    </div>
</div>
@endsection

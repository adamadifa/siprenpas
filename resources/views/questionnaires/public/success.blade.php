@extends('questionnaires.public.layout')
@section('title', 'Sukses')
@section('content')
<div class="flex-1 min-h-0 flex items-center justify-center px-2 mt-16">
    <div class="max-w-2xl w-full mx-auto bg-white rounded-2xl shadow-2xl p-10 border border-gray-100 animate-fadein-card relative z-10">
        <!-- Lottie Success Animation -->
        <lottie-player
            src="https://lottie.host/1e84c075-52db-498d-9bac-af30c05f9f20/U8vf0bmZcE.json"
            background="transparent"
            speed="1"
            style="width: 160px; height: 160px; margin: 0 auto 1.5rem auto;"
            autoplay
            loop
        ></lottie-player>
        <div class="text-3xl font-extrabold mb-2 text-sidebar-green tracking-tight">Terima Kasih!</div>
        <div class="text-lg text-gray-500 mb-6">Jawaban Anda sudah kami terima. Terima kasih atas partisipasi Anda dalam
            mengisi kuisioner ini.</div>
        <a href="{{ route('questionnaires.list') }}"
            class="inline-block mt-2 px-8 py-3 bg-sidebar-green text-white rounded-xl font-bold text-lg shadow-lg hover:bg-green-900 transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-sidebar-green">Kembali
            ke Daftar Kuisioners</a>
    </div>
</div>
@endsection

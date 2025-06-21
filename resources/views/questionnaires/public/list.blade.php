@extends('questionnaires.public.layout')
@section('title', 'Daftar Kuisioner Publik')
@section('content')
    <div class="flex-1 min-h-0 flex items-center justify-center px-2 mt-16">
        <div class="max-w-2xl w-full mx-auto bg-white rounded-2xl shadow-2xl p-10 border border-gray-100 animate-fadein-card relative z-10">
            <div class="flex flex-col items-center mb-8 animate-fadein-slide">
                <img src="{{ asset('assets/img/logo/persisalamin.png') }}" alt="Logo Persis Al-Amin" class="w-20 h-20 mb-2 rounded-full shadow border-2 border-sidebar-green bg-white object-contain" />
                <h2 class="text-3xl font-extrabold mb-1 text-sidebar-green tracking-tight">Daftar Kuisioner Publik</h2>
                <p class="text-gray-500 text-lg text-center">Pilih kuisioner yang ingin Anda isi di bawah ini.</p>
            </div>
            <ul class="space-y-4">
                @foreach($questionnaires as $q)
                    <li class="opacity-0 translate-y-4 animate-fadein-slide flex items-center bg-gray-50 hover:bg-sidebar-green hover:text-white transition-all duration-300 rounded-xl shadow-sm border border-gray-200 hover:border-sidebar-green px-4 py-3">
                        <span class="flex-shrink-0 w-12 h-12 rounded-full bg-sidebar-green flex items-center justify-center mr-4 shadow-md">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 9.4A5 5 0 1 0 12 17v1m0 0v1m0-1h1m-1 0h-1"/></svg>
                        </span>
                        <a href="{{ route('questionnaire.form', $q->id) }}" class="flex-1 block font-semibold text-lg focus:outline-none focus:ring-2 focus:ring-sidebar-green rounded">{{ $q->title }}</a>
                    </li>
                @endforeach
            </ul>
            <style>
            @keyframes fadein-card {
                0% { opacity:0; transform:scale(0.96) translateY(32px); }
                100% { opacity:1; transform:scale(1) translateY(0); }
            }
            .animate-fadein-card {
                animation: fadein-card 0.9s cubic-bezier(.4,2,.6,1) forwards;
            }
            @keyframes fadein-slide {
                0% { opacity:0; transform:translateY(32px); }
                100% { opacity:1; transform:translateY(0); }
            }
            .animate-fadein-slide {
                animation: fadein-slide 0.7s cubic-bezier(.4,2,.6,1) forwards;
            }
            ul.space-y-4 > li { animation-delay: calc(var(--i, 0) * 0.08s); }
            </style>
            <script>
            // Beri delay animasi per item agar efek staggered
            document.querySelectorAll('ul.space-y-4 > li').forEach((li, i) => li.style.setProperty('--i', i));
            </script>
        </div>
    </div>
@endsection

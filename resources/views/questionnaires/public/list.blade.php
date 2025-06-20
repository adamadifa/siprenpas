@extends('questionnaires.public.layout')
@section('title', 'Daftar Kuisioner Publik')
@section('content')
    <div class="max-w-2xl mx-auto bg-white rounded shadow p-6 mt-8">
        <h2 class="text-2xl font-bold mb-4 text-sidebar-green">Daftar Kuisioner Publik</h2>
        <ul class="space-y-3">
            @foreach($questionnaires as $q)
                <li class="opacity-0 translate-y-4 animate-fadein-slide flex items-center">
                    <span class="flex-shrink-0 w-10 h-10 rounded-full bg-sidebar-green flex items-center justify-center mr-3 shadow-md">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 9.4A5 5 0 1 0 12 17v1m0 0v1m0-1h1m-1 0h-1"/></svg>
                    </span>
                    <a href="{{ route('questionnaire.form', $q->id) }}" class="flex-1 block p-4 bg-white rounded border border-sidebar-green text-sidebar-green font-semibold shadow-sm hover:bg-sidebar-green hover:text-white hover:scale-[1.03] transition-all duration-200">{{ $q->title }}</a>
                </li>
            @endforeach
        </ul>
        <style>
        @keyframes fadein-slide {
            0% { opacity:0; transform:translateY(32px); }
            100% { opacity:1; transform:translateY(0); }
        }
        .animate-fadein-slide {
            animation: fadein-slide 0.7s cubic-bezier(.4,2,.6,1) forwards;
        }
        ul.space-y-3 > li { animation-delay: calc(var(--i, 0) * 0.08s); }
        </style>
        <script>
        // Beri delay animasi per item agar efek staggered
        document.querySelectorAll('ul.space-y-3 > li').forEach((li, i) => li.style.setProperty('--i', i));
        </script>
    </div>
@endsection

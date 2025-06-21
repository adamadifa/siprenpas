@extends('questionnaires.public.layout')
@section('title', $questionnaire->title)
@section('content')
    <div class="flex-1 min-h-0 flex items-center justify-center px-2 mt-16">
        <div class="max-w-2xl w-full mx-auto bg-white rounded-2xl shadow-2xl p-10 border border-gray-100 animate-fadein-card relative z-10">
            <div class="flex flex-col items-center mb-8 animate-fadein-slide">
                <img src="{{ asset('assets/img/logo/persisalamin.png') }}" alt="Logo Persis Al-Amin" class="w-20 h-20 mb-2 rounded-full shadow border-2 border-sidebar-green bg-white object-contain" />
                <h2 class="text-3xl font-extrabold mb-1 text-sidebar-green tracking-tight">{{ $questionnaire->title }}</h2>
                <p class="text-gray-500 text-lg text-center">{{ $questionnaire->description }}</p>
            </div>
            <form action="{{ route('questionnaire.submit', $questionnaire->id) }}" method="POST" class="space-y-8">
                @csrf
                @foreach($questionnaire->questions as $i => $question)
                    <div class="animate-fadein-slide" style="animation-delay: {{ ($i+1)*0.1 }}s;">
                        <label class="block font-semibold mb-3 text-sidebar-green text-lg">{{ $question->question }}</label>
                        <div class="space-y-3">
                            @foreach($question->options as $option)
                                <label class="flex items-center space-x-3 bg-gray-50 hover:bg-green-50 rounded-lg px-4 py-2 transition-colors cursor-pointer shadow-sm border border-gray-200">
                                    <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option->id }}" class="form-radio text-sidebar-green focus:ring-sidebar-green" required>
                                    <span class="text-base">{{ $option->option_text }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach
                <div class="flex justify-center mt-8">
                    <button type="submit" class="px-8 py-3 bg-sidebar-green text-white rounded-xl font-bold text-lg shadow-lg hover:bg-green-900 transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-sidebar-green">Kirim Jawaban</button>
                </div>
            </form>
        </div>
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
        </style>
    </div>
@endsection

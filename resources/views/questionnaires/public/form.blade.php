@extends('questionnaires.public.layout')
@section('title', $questionnaire->title)
@section('content')
    <div class="max-w-2xl mx-auto bg-white rounded shadow p-6 mt-8">
        <h2 class="text-2xl font-bold mb-2 text-sidebar-green">{{ $questionnaire->title }}</h2>
        <p class="mb-4 text-gray-600">{{ $questionnaire->description }}</p>
        <form action="{{ route('questionnaire.submit', $questionnaire->id) }}" method="POST" class="space-y-6">
            @csrf
            @foreach($questionnaire->questions as $question)
                <div>
                    <label class="block font-semibold mb-2">{{ $question->question }}</label>
                    <div class="space-y-2">
                        @foreach($question->options as $option)
                            <label class="flex items-center space-x-2">
                                <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option->id }}" class="form-radio text-blue-600" required>
                                <span>{{ $option->option_text }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach
            <button type="submit" class="px-6 py-2 bg-sidebar-green text-white rounded hover:bg-green-800">Kirim Jawaban</button>
        </form>
    </div>
@endsection

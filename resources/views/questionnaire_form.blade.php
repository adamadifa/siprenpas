@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <h2>{{ $questionnaire->title }}</h2>
    <p>{{ $questionnaire->description }}</p>
    <form action="{{ route('questionnaire.submit', $questionnaire->id) }}" method="POST">
        @csrf

        @foreach($questionnaire->questions as $question)
            <div class="mb-3">
                <label><strong>{{ $question->question }}</strong></label>
                <div>
                @foreach($question->options as $option)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]" value="{{ $option->id }}" required>
                        <label class="form-check-label">{{ $option->option_text }}</label>
                    </div>
                @endforeach
                </div>
            </div>
        @endforeach
        <button type="submit" class="btn btn-success">Kirim Jawaban</button>
    </form>
</div>
@endsection

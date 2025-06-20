@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <h2>Pertanyaan untuk: {{ $questionnaire->title }}</h2>
    <a href="{{ route('admin.questionnaires.questions.create', $questionnaire->id) }}" class="btn btn-success mb-3">Tambah Pertanyaan</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Pertanyaan</th>
                <th>Opsi Jawaban</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($questionnaire->questions as $question)
                <tr>
                    <td>{{ $question->question }}</td>
                    <td>
                        <ul>
                        @foreach($question->options as $option)
                            <li>{{ $option->option_text }}</li>
                        @endforeach
                        </ul>
                    </td>
                    <td>
                        <a href="{{ route('admin.questionnaires.questions.edit', [$questionnaire->id, $question->id]) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.questionnaires.questions.destroy', [$questionnaire->id, $question->id]) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin hapus pertanyaan ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

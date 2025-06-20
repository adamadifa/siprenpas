@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <h3>Pertanyaan untuk Kuisioner: {{ $questionnaire->title }}</h3>
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
            @foreach($questionnaire->questions as $q)
                <tr>
                    <td>{{ $q->question }}</td>
                    <td>
                        <ul>
                            @foreach($q->options as $opt)
                                <li>{{ $opt->option_text }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        <a href="#" class="btn btn-warning btn-sm disabled">Edit</a>
                        <form action="{{ route('admin.questionnaires.questions.destroy', [$questionnaire->id, $q->id]) }}" method="POST" style="display:inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus pertanyaan?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

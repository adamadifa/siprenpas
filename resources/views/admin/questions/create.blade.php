@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <h2>Tambah Pertanyaan untuk: {{ $questionnaire->title }}</h2>
    <form action="{{ route('admin.questionnaires.questions.store', $questionnaire->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="question" class="form-label">Pertanyaan</label>
            <input type="text" class="form-control" name="question" required>
        </div>
        <div class="mb-3">
            <label for="options[]" class="form-label">Opsi Jawaban</label>
            <div id="options-list">
                <input type="text" name="options[]" class="form-control mb-2" placeholder="Opsi 1" required>
                <input type="text" name="options[]" class="form-control mb-2" placeholder="Opsi 2" required>
            </div>
            <button type="button" class="btn btn-secondary btn-sm" onclick="addOption()">Tambah Opsi</button>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Pertanyaan</button>
    </form>
</div>
<script>
function addOption() {
    var idx = document.querySelectorAll('#options-list input').length + 1;
    var input = document.createElement('input');
    input.type = 'text';
    input.name = 'options[]';
    input.className = 'form-control mb-2';
    input.placeholder = 'Opsi ' + idx;
    input.required = true;
    document.getElementById('options-list').appendChild(input);
}
</script>
@endsection

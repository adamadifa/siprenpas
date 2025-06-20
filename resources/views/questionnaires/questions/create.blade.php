@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <h3>Tambah Pertanyaan untuk Kuisioner: {{ $questionnaire->title }}</h3>
    <form action="{{ route('admin.questionnaires.questions.store', $questionnaire->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Pertanyaan</label>
            <input type="text" name="question" class="form-control" required>
        </div>
        <div id="options">
            <div class="mb-2">
                <input type="text" name="options[]" class="form-control d-inline-block" style="width:80%" placeholder="Opsi jawaban" required>
                <button type="button" class="btn btn-danger btn-sm" onclick="this.parentElement.remove()">Hapus</button>
            </div>
            <div class="mb-2">
                <input type="text" name="options[]" class="form-control d-inline-block" style="width:80%" placeholder="Opsi jawaban" required>
                <button type="button" class="btn btn-danger btn-sm" onclick="this.parentElement.remove()">Hapus</button>
            </div>
        </div>
        <button type="button" class="btn btn-secondary btn-sm mb-3" onclick="addOption()">Tambah Opsi</button>
        <br>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.questionnaires.questions.index', $questionnaire->id) }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
<script>
function addOption() {
    var html = `<div class="mb-2">
        <input type="text" name="options[]" class="form-control d-inline-block" style="width:80%" placeholder="Opsi jawaban" required>
        <button type="button" class="btn btn-danger btn-sm" onclick="this.parentElement.remove()">Hapus</button>
    </div>`;
    document.getElementById('options').insertAdjacentHTML('beforeend', html);
}
</script>
@endsection

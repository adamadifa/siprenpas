@extends('layouts.app')
@section('titlepage', 'Edit Pertanyaan')
@section('navigasi')
    <span>Manajemen Kuisioner</span> &raquo; <a
        href="{{ route('admin.questionnaires.questions.index', $questionnaire->id) }}">Kelola Pertanyaan</a> &raquo;
    <span>Edit Pertanyaan</span>
@endsection
@section('content')
    <div class="row py-4">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h4 class="fw-bold mb-0">Edit Pertanyaan</h4>
                    <div class="text-muted small">Kuisioner: <span class="fw-semibold">{{ $questionnaire->title }}</span>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.questionnaires.questions.update', [$questionnaire->id, $question->id]) }}"
                        method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="question" class="form-label">Pertanyaan</label>
                            <input type="text" name="question" id="question"
                                class="form-control @error('question') is-invalid @enderror"
                                value="{{ old('question', $question->question) }}" required autofocus>
                            @error('question')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Opsi Jawaban</label>
                            <div id="opsi-list">
                                @foreach ($question->options as $idx => $opt)
                                    <div class="input-group mb-2">
                                        <span class="input-group-text">{{ chr(65 + $idx) }}</span>
                                        <input type="text" name="options[]"
                                            class="form-control @error('options.' . $idx) is-invalid @enderror"
                                            value="{{ old('options.' . $idx, $opt->option_text) }}" required>
                                        <button type="button" class="btn btn-outline-danger btn-remove-opsi"><i
                                                class="fa fa-times"></i></button>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-outline-primary mt-2" id="btn-tambah-opsi"><i
                                    class="fa fa-plus"></i> Tambah Opsi</button>
                            @error('options')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.questionnaires.questions.index', $questionnaire->id) }}"
                                class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-success px-4 fw-bold">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('myscript')
    <script>
        $(document).ready(function() {
            // Tambah opsi baru
            $('#btn-tambah-opsi').click(function() {
                let idx = $('#opsi-list .input-group').length;
                let html = `<div class="input-group mb-2">
                        <span class="input-group-text">${String.fromCharCode(65+idx)}</span>
                        <input type="text" name="options[]" class="form-control" required>
                        <button type="button" class="btn btn-outline-danger btn-remove-opsi"><i class="fa fa-times"></i></button>
                    </div>`;
                $('#opsi-list').append(html);
            });
            // Hapus opsi
            $(document).on('click', '.btn-remove-opsi', function() {
                $(this).closest('.input-group').remove();
                // Update label huruf
                $('#opsi-list .input-group').each(function(i, el) {
                    $(el).find('.input-group-text').text(String.fromCharCode(65 + i));
                });
            });
        });
    </script>
@endpush

@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <h2>Edit Kuisioner</h2>
    <form action="{{ route('admin.questionnaires.update', $questionnaire->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="title" class="form-label">Judul</label>
            <input type="text" class="form-control" name="title" value="{{ $questionnaire->title }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea class="form-control" name="description">{{ $questionnaire->description }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection

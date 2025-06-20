@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <h2>Daftar Kuisioner</h2>
    <ul class="list-group">
        @foreach($questionnaires as $q)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>{{ $q->title }}</span>
                <a href="{{ route('questionnaire.form', $q->id) }}" class="btn btn-primary btn-sm">Isi Kuisioner</a>
            </li>
        @endforeach
    </ul>
</div>
@endsection

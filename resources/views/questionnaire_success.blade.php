@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <div class="alert alert-success">
        Terima kasih sudah mengisi kuisioner!
    </div>
    <a href="{{ route('questionnaires.list') }}" class="btn btn-primary">Kembali ke Daftar Kuisioner</a>
</div>
@endsection

@extends('questionnaires.public.layout')
@section('title', 'Sukses')
@section('content')
    <div class="max-w-lg mx-auto bg-white rounded shadow p-8 mt-16 text-center">
        <div class="text-sidebar-green text-4xl mb-4">✔</div>
        <div class="text-lg font-semibold mb-2">Terima kasih, jawaban Anda sudah kami terima!</div>
        <a href="{{ route('questionnaires.list') }}" class="inline-block mt-4 px-6 py-2 bg-sidebar-green text-white rounded hover:bg-green-800">Kembali ke Daftar Kuisioner</a>
    </div>
@endsection

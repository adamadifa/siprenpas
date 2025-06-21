@extends('layouts.app')
@section('content')
<div class="container d-flex justify-content-center align-items-center min-vh-100" style="background: #f8fafc;">
    <div class="card shadow-lg p-4 rounded-4" style="min-width: 400px; max-width: 500px; width: 100%; background: #fff;">
        <h2 class="mb-4 fw-bold text-center" style="letter-spacing: 1px;">Tambah Kuisioner</h2>
        <form action="{{ route('admin.questionnaires.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label fw-semibold">Judul</label>
                <input type="text" class="form-control form-control-lg rounded-3 shadow-sm" name="title" placeholder="Masukkan judul kuisioner" required autofocus>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label fw-semibold">Deskripsi</label>
                <textarea class="form-control rounded-3 shadow-sm" name="description" rows="3" placeholder="Deskripsi singkat kuisioner..."></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-lg w-100 rounded-3 fw-bold shadow-sm" style="transition: background 0.2s;">Simpan</button>
        </form>
    </div>
</div>
@endsection

@extends('layouts.app')
@section('content')
    <div class="container mt-4">
        <h2>Manajemen Kuisioner</h2>
        <a href="{{ route('admin.questionnaires.create') }}" class="btn btn-success mb-3">Tambah Kuisioner</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Deskripsi</th>
                    <th>Jumlah Pertanyaan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($questionnaires as $q)
                    <tr>
                        <td>{{ $q->title }}</td>
                        <td>{{ $q->description }}</td>
                        <td>{{ $q->questions->count() }}</td>
                        <td>
                            <a href="{{ route('admin.questionnaires.edit', $q->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <a href="{{ route('admin.questionnaires.questions.index', $q->id) }}"
                                class="btn btn-secondary btn-sm">Kelola Pertanyaan</a>
                            <a href="{{ route('admin.questionnaires.show', $q->id) }}" class="btn btn-info btn-sm">Detail</a>
                            <a href="{{ route('admin.questionnaires.report', $q->id) }}"
                                class="btn btn-success btn-sm">Report</a>
                            <form action="{{ route('admin.questionnaires.destroy', $q->id) }}" method="POST"
                                style="display:inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

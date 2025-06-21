@extends('layouts.app')
@section('content')
<div class="row mt-4">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <a href="{{ route('admin.questionnaires.create') }}" class="btn btn-primary me-2">
                        <i class="fa fa-plus me-2"></i>Tambah Kuisioner
                    </a>
                </div>
                <h2 class="mb-0 fw-bold" style="font-size:1.4rem"><i class="fa fa-list-alt text-success me-2"></i> Manajemen Kuisioners</h2>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-lg-6 col-md-8 col-sm-12">
                        <form action="" method="GET">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Cari Judul/Deskripsi Kuisioner..." value="{{ request('search') }}">
                                <button class="btn btn-primary px-4" type="submit"><i class="fa fa-search"></i> Cari</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="table-responsive mb-2">
                    <table class="table table-striped table-hover table-bordered align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th style="min-width:180px">Judul</th>
                                <th style="min-width:220px">Deskripsi</th>
                                <th class="text-center" style="width:60px">Jumlah Pertanyaan</th>
                                <th class="text-end" style="width:220px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($questionnaires as $q)
                            <tr>
                                <td>{{ $q->title }}</td>
                                <td>{{ $q->description }}</td>
                                <td class="text-center">{{ $q->questions->count() }}</td>
                                <td class="text-end">
                                    <a href="{{ route('admin.questionnaires.edit', $q->id) }}" class="btn btn-warning btn-sm me-1" title="Edit">
                                        <i class="fa fa-edit fa-lg"></i>
                                    </a>
                                    <a href="{{ route('admin.questionnaires.questions.index', $q->id) }}" class="btn btn-secondary btn-sm me-1" title="Kelola Pertanyaan">
                                        <i class="fa fa-tasks fa-lg"></i>
                                    </a>
                                    <a href="{{ route('admin.questionnaires.show', $q->id) }}" class="btn btn-info btn-sm me-1" title="Detail">
                                        <i class="fa fa-info-circle fa-lg"></i>
                                    </a>
                                    <a href="{{ route('admin.questionnaires.report', $q->id) }}" class="btn btn-success btn-sm me-1" title="Report">
                                        <i class="fa fa-chart-bar fa-lg"></i>
                                    </a>
                                    <form action="{{ route('admin.questionnaires.destroy', $q->id) }}" method="POST" style="display:inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('Yakin ingin menghapus?')">
                                            <i class="fa fa-trash fa-lg"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">Belum ada data kuisioner.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

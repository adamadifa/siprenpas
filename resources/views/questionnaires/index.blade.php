@extends('layouts.app')
@section('titlepage', 'Manajemen Kuisioner')
@section('navigasi')
    <span>Manajemen Kuisioner</span>
@endsection
@section('content')
    <div class="row py-4">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('admin.questionnaires.create') }}" class="btn btn-primary" id="btncreateKuisioner">
                        <i class="fa fa-plus me-2"></i> Tambah Kuisioner
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <form action="" method="GET" class="mb-4">
                                <div class="input-group shadow-sm rounded">
                                    <span class="input-group-text bg-white border-end-0"><i
                                            class="fa fa-search text-muted"></i></span>
                                    <input type="text" name="search" class="form-control border-start-0"
                                        placeholder="Cari Judul/Deskripsi Kuisioner..." value="{{ request('search') }}">
                                    <button class="btn btn-primary px-4" type="submit">Cari</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive mb-2">
                                <table class="table table-striped table-hover table-bordered align-middle">
                                    <thead class="table-dark">
                                        <tr>
                                            <th style="min-width:180px">Judul</th>
                                            <th style="min-width:220px">Deskripsi</th>
                                            <th class="text-center" style="width:60px">Jumlah Pertanyaan</th>
                                            <th class="text-end" style="width:380px;white-space:nowrap">Aksi</th>
                                        </tr>
                                    </thead>
                                    @forelse($questionnaires as $q)
                                        <tr>
                                            <td>{{ $q->title }}</td>
                                            <td>{{ $q->description }}</td>
                                            <td class="text-center">{{ $q->questions->count() }}</td>
                                            <td class="text-end" style="width:380px;white-space:nowrap">
                                                <div class="d-flex justify-content-end gap-1">
                                                    <a href="{{ route('admin.questionnaires.edit', $q->id) }}"
                                                        class="btn btn-warning btn-sm">Edit</a>
                                                    <a href="{{ route('admin.questionnaires.questions.index', $q->id) }}"
                                                        class="btn btn-secondary btn-sm">Kelola Pertanyaan</a>
                                                    <a href="{{ route('admin.questionnaires.show', $q->id) }}"
                                                        class="btn btn-info btn-sm">Detail</a>
                                                    <a href="{{ route('admin.questionnaires.report', $q->id) }}"
                                                        class="btn btn-success btn-sm">Report</a>
                                                    <form action="{{ route('admin.questionnaires.destroy', $q->id) }}"
                                                        method="POST" style="display:inline-block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                                    </form>
                                                </div>
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
        </div>
    </div>
@endsection

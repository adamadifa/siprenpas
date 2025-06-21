@extends('layouts.app')
@section('titlepage', 'Kelola Pertanyaan')
@section('navigasi')
    <span>Manajemen Kuisioner</span> &raquo; <span>Kelola Pertanyaan</span>
@endsection
@section('content')
<div class="row py-4">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <a href="{{ route('admin.questionnaires.questions.create', $questionnaire->id) }}" class="btn btn-primary">
                    <i class="fa fa-plus me-2"></i> Tambah Pertanyaan
                </a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <form action="" method="GET" class="mb-4">
                            <div class="input-group shadow-sm rounded">
                                <span class="input-group-text bg-white border-end-0"><i class="fa fa-search text-muted"></i></span>
                                <input type="text" name="search" class="form-control border-start-0" placeholder="Cari Pertanyaan/Opsi..." value="{{ request('search') }}">
                                <button class="btn btn-primary px-4" type="submit">Cari</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="table-responsive mb-2">
                    <table class="table table-striped table-hover table-bordered align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th style="min-width:320px">Pertanyaan</th>
                                <th style="min-width:220px">Opsi Jawaban</th>
                                <th class="text-end" style="width:180px;white-space:nowrap">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                                @forelse($questionnaire->questions as $q)
                                    <tr class="table-row-hover">
                                        <td class="fw-semibold">{{ $q->question }}</td>
                                        <td>
                                            @foreach($q->options as $idx => $opt)
                                                <span class="badge bg-success me-1 mb-1 px-2 py-1 fs-7" style="font-size:0.75rem;">{{ $opt->option_text }}</span>
                                            @endforeach
                                        </td>
                                        <td class="text-end" style="width:180px;white-space:nowrap">
                                            <div class="d-flex">
    <div>
        <a href="{{ route('admin.questionnaires.questions.edit', [$questionnaire->id, $q->id]) }}" class="me-2" title="Edit">
            <i class="ti ti-edit text-success"></i>
        </a>
    </div>
    <div>
        <form method="POST" name="deleteform" class="deleteform me-1" action="{{ route('admin.questionnaires.questions.destroy', [$questionnaire->id, $q->id]) }}" style="display:inline-block">
            @csrf
            @method('DELETE')
            <a href="#" class="delete-confirm ml-1" title="Hapus" onclick="event.preventDefault(); if(confirm('Yakin ingin menghapus pertanyaan?')) this.closest('form').submit();">
                <i class="ti ti-trash text-danger"></i>
            </a>
        </form>
    </div>
</div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-4">
                                            <i class="fa fa-inbox fa-2x mb-2"></i><br>
                                            Belum ada pertanyaan untuk kuisioner ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
    .table-row-hover:hover {
        background: #eaf6ff !important;
        transition: background 0.15s;
    }
    </style>
</div>
@endsection

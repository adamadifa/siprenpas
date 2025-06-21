@extends('layouts.app')
@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm border-0">
                <div class="card-header d-flex justify-content-between align-items-center bg-white border-bottom-0 pb-0">
                    <div>
                        <h4 class="fw-bold mb-0">Kelola Pertanyaan</h4>
                        <div class="text-muted small">Kuisioner: <span class="fw-semibold">{{ $questionnaire->title }}</span></div>
                    </div>
                    <a href="{{ route('admin.questionnaires.questions.create', $questionnaire->id) }}" class="btn btn-success btn-lg">
                        <i class="fa fa-plus me-1"></i> Tambah Pertanyaan
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive mb-2">
                        <table class="table table-striped table-hover table-borderless align-middle">
                            <thead class="table-primary">
                                <tr>
                                    <th style="width:45%">Pertanyaan</th>
                                    <th style="width:40%">Opsi Jawaban</th>
                                    <th class="text-end" style="width:15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($questionnaire->questions as $q)
                                    <tr class="table-row-hover">
                                        <td class="fw-semibold">{{ $q->question }}</td>
                                        <td>
                                            @foreach($q->options as $idx => $opt)
                                                <span class="badge bg-{{ ['primary','success','warning','info','danger','secondary','dark'][$idx%7] }} me-1 mb-1">{{ $opt->option_text }}</span>
                                            @endforeach
                                        </td>
                                        <td class="text-end">
                                            <a href="#" class="btn btn-warning btn-sm me-1 disabled"><i class="fa fa-edit me-1"></i>Edit</a>
                                            <form action="{{ route('admin.questionnaires.questions.destroy', [$questionnaire->id, $q->id]) }}" method="POST" style="display:inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus pertanyaan?')"><i class="fa fa-trash me-1"></i>Hapus</button>
                                            </form>
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

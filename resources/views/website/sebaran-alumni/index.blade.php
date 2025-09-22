@extends('layouts.app')

@section('titlepage', 'Sebaran Alumni')

@section('content')
@section('navigasi')
    <span>Sebaran Alumni</span>
@endsection
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('sebaran-alumni.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus me-2"></i> Tambah Sebaran Alumni
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive mb-2">
                    <table class="table table-striped table-hover table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th width="5%">No.</th>
                                <th width="15%">Logo</th>
                                <th>Nama Universitas</th>
                                <th width="10%">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($items as $d)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">
                                        @if ($d->logo)
                                            <img src="{{ asset('storage/' . $d->logo) }}" alt="{{ $d->nama_universitas }}" class="img-thumbnail"
                                                style="max-width: 80px; max-height: 80px;">
                                        @else
                                            <div class="bg-light text-center p-2 rounded">
                                                <i class="ti ti-building" style="font-size: 2rem;"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{ $d->nama_universitas }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('sebaran-alumni.edit', $d->id) }}" class="me-2">
                                                <i class="ti ti-edit text-success"></i>
                                            </a>
                                            <form method="POST" class="deleteform" action="{{ route('sebaran-alumni.destroy', $d->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <a href="#" class="delete-confirm ml-1">
                                                    <i class="ti ti-trash text-danger"></i>
                                                </a>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $items->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

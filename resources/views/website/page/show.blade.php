@extends('layouts.app')
@section('titlepage', $page->title)

@section('content')
@section('navigasi')
    <span>{{ $page->title }}</span>
@endsection

<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">{{ $page->title }}</h5>
                <div class="d-flex gap-2">
                    @can('pages.edit')
                        @php
                            $pageId = Crypt::encrypt($page->id);
                        @endphp
                        <a href="{{ route('pages.edit', $pageId) }}" class="btn btn-warning">
                            <i class="ti ti-pencil me-1"></i>
                            Edit
                        </a>
                    @endcan
                    <a href="{{ route('pages.index') }}" class="btn btn-secondary">
                        <i class="ti ti-arrow-left me-1"></i>
                        Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group mb-3">
                            <div class="form-control-plaintext">
                                {!! $page->content !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">Dibuat</label>
                            <p class="form-control-plaintext">{{ $page->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">Diperbarui</label>
                            <p class="form-control-plaintext">{{ $page->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


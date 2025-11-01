@extends('layouts.app')
@section('titlepage', 'Tentang Pesantren')

@section('content')
@section('navigasi')
    <span>Tentang Pesantren</span>
@endsection

<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">{{ $page ? 'Edit' : 'Tambah' }} Tentang Pesantren</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('tentang-pesantren.store-or-update') }}" method="POST" id="formTentangPesantren">
                    @csrf
                    <x-input-with-icon-label icon="ti ti-file-text" label="Judul" name="title"
                        value="{{ old('title', $page ? $page->title : 'Tentang Pesantren') }}" />
                    <div class="mb-3">
                        <label for="content" class="form-label">Konten</label>
                        <textarea class="form-control" id="content" name="content" rows="8"
                            placeholder="Masukkan konten tentang pesantren...">{{ old('content', $page ? $page->content : '') }}</textarea>
                    </div>
                    <div class="form-group mb-3">
                        <button class="btn btn-primary w-100" type="submit">
                            <ion-icon name="send-outline" class="me-1"></ion-icon>
                            {{ $page ? 'Update' : 'Simpan' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection
@push('myscript')
<script>
    $(function() {
        $("#content").summernote({
            height: 300,
            placeholder: 'Masukkan konten tentang pesantren...'
        });
    });
</script>
@endpush

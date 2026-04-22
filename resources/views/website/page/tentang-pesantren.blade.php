@extends('layouts.app')
@section('titlepage', 'Tentang Pesantren')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-info-circle fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Tentang Pesantren</h4>
                        <p class="text-muted mb-0 small">Manajemen profil dan informasi lembaga pesantren</p>
                    </div>
                </div>
                <div class="d-flex flex-column align-items-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mb-0">
                            <li class="breadcrumb-item">
                                <a href="javascript:void(0);" class="text-muted">
                                    <i class="ti ti-home-2 me-1"></i> Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                <i class="ti ti-info-circle me-1"></i> Tentang Pesantren
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card shadow-sm border-0">
            <div class="card-header d-flex align-items-center gap-2 text-white py-3" style="background-color: #064e3b">
                <i class="ti ti-edit fs-5"></i>
                <h6 class="card-title mb-0 text-white">Konfigurasi Halaman Tentang Pesantren</h6>
            </div>
            <div class="card-body pt-4">
                <form action="{{ route('tentang-pesantren.store-or-update') }}" method="POST" id="formTentangPesantren">
                    @csrf
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Judul Halaman <span class="text-danger">*</span></label>
                            <div class="input-group input-group-merge shadow-none border" style="border-radius: 8px; overflow: hidden;">
                                <span class="input-group-text border-0 bg-transparent text-muted">
                                    <i class="ti ti-file-text fs-5"></i>
                                </span>
                                <input type="text" class="form-control border-0 ps-0 py-2" name="title"
                                    value="{{ old('title', $page ? $page->title : 'Tentang Pesantren') }}"
                                    placeholder="Masukkan judul halaman..." required>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-12">
                            <label for="content" class="form-label fw-bold">Konten Profil Pesantren <span class="text-danger">*</span></label>
                            <div class="border rounded-3 p-1" style="border-color: #e0e0e0 !important;">
                                <textarea class="form-control" id="content" name="content" rows="15"
                                    placeholder="Masukkan konten lengkap tentang pesantren...">{{ old('content', $page ? $page->content : '') }}</textarea>
                            </div>
                            <div class="form-text mt-2">
                                <i class="ti ti-info-circle me-1"></i> Gunakan editor di atas untuk memformat teks, menambahkan gambar, atau link.
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-primary d-flex align-items-center gap-2 px-4 py-2 shadow-sm" type="submit"
                                style="background-color: #064e3b; border-color: #064e3b">
                                <i class="ti ti-device-floppy fs-5"></i>
                                <span class="fw-bold">{{ $page ? 'Perbarui Profil' : 'Simpan Profil' }}</span>
                            </button>
                        </div>
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
            height: 400,
            placeholder: 'Tuliskan sejarah, profil, dan informasi detail pesantren di sini...',
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            styleTags: [
                'p',
                { title: 'Blockquote', tag: 'blockquote', className: 'blockquote', value: 'blockquote' },
                'pre', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'
            ],
        });
    });
</script>
<style>
    .note-editor.note-frame {
        border: none !important;
    }
    .note-toolbar {
        background-color: #f8f9fa !important;
        border-bottom: 1px solid #e0e0e0 !important;
    }
    .note-btn {
        background-color: white !important;
        border: 1px solid #e0e0e0 !important;
        color: #4b5563 !important;
    }
    .note-btn:hover {
        background-color: #f3f4f6 !important;
    }
</style>
@endpush

@extends('layouts.app')
@section('titlepage', 'Kelola Album: ' . $album->title)

@section('content')
<div class="space-y-5 w-full">

    <!-- ================= 1. PAGE HEADER (FULL WIDTH) WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1 w-full">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center border border-emerald-200/80 shadow-2xs">
                    <i class="ti ti-photo text-2xl"></i>
                </div>
                <span>{{ $album->title }}</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                {{ $album->description ?: 'Kelola koleksi foto dokumentasi dalam album ini' }}
            </p>
        </div>

        <!-- Right Side: Breadcrumb & Actions -->
        <div class="flex flex-col md:items-end gap-2.5">
            <!-- Breadcrumb Navigation -->
            <nav class="flex items-center text-xs text-slate-400 font-medium">
                <a href="{{ route('dashboard.index') }}" class="hover:text-slate-700 transition flex items-center gap-1">
                    <i class="ti ti-home text-sm"></i>
                    <span>Dashboard</span>
                </a>
                <span class="mx-2 text-slate-300">/</span>
                <span class="text-slate-500 flex items-center gap-1">
                    <i class="ti ti-world text-sm"></i>
                    <span>Website</span>
                </span>
                <span class="mx-2 text-slate-300">/</span>
                <a href="{{ route('gallery.index') }}" class="hover:text-slate-700 transition">
                    <span>Galeri Kegiatan</span>
                </a>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Kelola Foto</span>
            </nav>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2">
                <a href="{{ route('gallery.index') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs transition cursor-pointer">
                    <i class="ti ti-arrow-left text-sm"></i>
                    <span>Kembali</span>
                </a>
                <a href="{{ route('gallery.edit', $album->id) }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs transition cursor-pointer">
                    <i class="ti ti-edit text-sm"></i>
                    <span>Edit Album</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="flex items-center justify-between p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-xs font-semibold">
            <div class="flex items-center gap-2">
                <i class="ti ti-circle-check text-base text-emerald-600"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-700 hover:text-emerald-900 cursor-pointer">
                <i class="ti ti-x text-sm"></i>
            </button>
        </div>
    @endif

    <!-- Callout Info Hero Section Website -->
    <div class="flex items-start gap-3.5 p-4 bg-emerald-50/80 border border-emerald-200/80 rounded-2xl text-emerald-900 shadow-2xs">
        <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 text-base font-bold">
            <i class="ti ti-sparkles"></i>
        </div>
        <div class="text-xs">
            <p class="font-bold text-emerald-950">Info Hero Marquee Website Utama</p>
            <p class="text-emerald-700/90 mt-0.5 leading-relaxed">
                Aktifkan tombol <strong>"Tampil di Hero"</strong> pada foto dokumentasi pilihan untuk ditampilkan pada animasi banner hero section halaman utama website Al-Amin.
            </p>
        </div>
    </div>

    <!-- ================= 2. UPLOAD MULTIPLE PHOTOS CARD ================= -->
    <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
        <!-- Solid Emerald Header -->
        <div class="bg-emerald-600 px-5 py-3.5 flex items-center justify-between text-white">
            <div class="flex items-center gap-2">
                <i class="ti ti-cloud-upload text-lg"></i>
                <h3 class="font-bold text-xs sm:text-sm tracking-wide text-white">Upload Foto Baru ke Album Ini</h3>
            </div>
            <span class="text-[11px] font-medium text-emerald-100">Bisa pilih banyak foto sekaligus</span>
        </div>

        <form action="{{ route('gallery.photos.upload', $album->id) }}" method="POST" enctype="multipart/form-data" class="p-5 space-y-4">
            @csrf
            <div>
                <input type="file" 
                       name="photos[]" 
                       multiple 
                       required 
                       accept="image/*"
                       class="w-full p-2.5 text-xs text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition cursor-pointer @error('photos.*') border-rose-400 bg-rose-50/20 @enderror">
                <p class="text-[11px] text-slate-400 mt-1">Format gambar: JPG, PNG, WEBP, GIF. Maksimal 4MB per file foto.</p>
                @error('photos.*')
                    <p class="text-[11px] font-semibold text-rose-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs transition-all duration-200 active:scale-95 cursor-pointer">
                    <i class="ti ti-upload text-base"></i>
                    <span>Mulai Unggah Foto</span>
                </button>
            </div>
        </form>
    </div>

    <!-- ================= 3. PHOTOS GRID LIST ================= -->
    <div class="space-y-3">
        <div class="flex items-center justify-between">
            <h3 class="font-bold text-sm text-slate-800 flex items-center gap-2">
                <i class="ti ti-photo-circle text-emerald-600"></i>
                <span>Daftar Foto dalam Album ({{ $album->photos->count() }} Foto)</span>
            </h3>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @forelse ($album->photos as $photo)
                <div class="bg-white border rounded-2xl shadow-xs overflow-hidden flex flex-col justify-between transition-all duration-200 {{ $photo->is_hero ? 'border-emerald-500 ring-2 ring-emerald-500/20 shadow-md' : 'border-slate-200/90' }}" id="photo-card-{{ $photo->id }}">
                    <!-- Photo Image Preview -->
                    <div class="relative h-44 w-full bg-slate-100 overflow-hidden group">
                        <img src="{{ asset('storage/' . $photo->path) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" alt="{{ $photo->title ?? 'Photo' }}">
                        
                        <!-- Hero Indicator Badge -->
                        <span id="hero-badge-{{ $photo->id }}" class="absolute top-2 left-2 inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[10px] font-bold bg-emerald-600 text-white shadow-xs backdrop-blur-md {{ $photo->is_hero ? '' : 'hidden' }}">
                            <i class="ti ti-sparkles text-xs"></i> Tampil di Hero
                        </span>
                    </div>

                    <!-- Photo Card Actions -->
                    <div class="p-3.5 space-y-2 bg-white">
                        <!-- Toggle Hero Form -->
                        <form action="{{ route('gallery.photos.toggle-hero', [$album->id, $photo->id]) }}" method="POST" class="form-toggle-hero m-0" data-photo-id="{{ $photo->id }}">
                            @csrf
                            <button type="submit" 
                                    id="btn-hero-{{ $photo->id }}"
                                    class="w-full inline-flex items-center justify-center gap-1.5 px-3 py-1.5 font-bold rounded-xl text-xs transition cursor-pointer {{ $photo->is_hero ? 'bg-emerald-600 text-white hover:bg-emerald-700 shadow-2xs' : 'bg-slate-100 text-slate-700 hover:bg-emerald-50 hover:text-emerald-700 border border-slate-200' }}">
                                <i class="ti {{ $photo->is_hero ? 'ti-check' : 'ti-plus' }} text-sm" id="icon-hero-{{ $photo->id }}"></i>
                                <span id="text-hero-{{ $photo->id }}">{{ $photo->is_hero ? 'Tampil di Hero (Aktif)' : 'Tampilkan di Hero' }}</span>
                            </button>
                        </form>

                        <!-- Delete Form -->
                        <form action="{{ route('gallery.photos.destroy', [$album->id, $photo->id]) }}" method="POST" class="delete-photo-form m-0">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="w-full inline-flex items-center justify-center gap-1.5 px-3 py-1.5 bg-rose-50 hover:bg-rose-600 text-rose-600 hover:text-white font-bold rounded-xl text-xs border border-rose-200/70 transition cursor-pointer btn-delete-photo">
                                <i class="ti ti-trash text-sm"></i>
                                <span>Hapus Foto</span>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center bg-white border border-slate-200/90 rounded-2xl shadow-xs">
                    <div class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-2 text-2xl">
                        <i class="ti ti-photo-off"></i>
                    </div>
                    <h4 class="font-bold text-slate-800 text-sm mb-0.5">Belum Ada Foto dalam Album</h4>
                    <p class="text-xs text-slate-400">Silakan unggah file foto kegiatan menggunakan form upload di atas.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

@push('myscript')
<script>
$(function () {
    // Ajax Toggle Hero Status
    $('.form-toggle-hero').on('submit', function (e) {
        e.preventDefault();
        const $form = $(this);
        const photoId = $form.data('photo-id');
        const $btn = $('#btn-hero-' + photoId);
        const $icon = $('#icon-hero-' + photoId);
        const $text = $('#text-hero-' + photoId);
        const $badge = $('#hero-badge-' + photoId);
        const $card = $('#photo-card-' + photoId);

        $btn.prop('disabled', true).addClass('opacity-75');

        $.ajax({
            url: $form.attr('action'),
            type: 'POST',
            data: $form.serialize(),
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            success: function (data) {
                $btn.prop('disabled', false).removeClass('opacity-75');
                if (data.success) {
                    if (data.is_hero) {
                        $btn.attr('class', 'w-full inline-flex items-center justify-center gap-1.5 px-3 py-1.5 font-bold rounded-xl text-xs transition cursor-pointer bg-emerald-600 text-white hover:bg-emerald-700 shadow-2xs');
                        $icon.attr('class', 'ti ti-check text-sm');
                        $text.text('Tampil di Hero (Aktif)');
                        $badge.removeClass('hidden');
                        $card.addClass('border-emerald-500 ring-2 ring-emerald-500/20 shadow-md').removeClass('border-slate-200/90');
                    } else {
                        $btn.attr('class', 'w-full inline-flex items-center justify-center gap-1.5 px-3 py-1.5 font-bold rounded-xl text-xs transition cursor-pointer bg-slate-100 text-slate-700 hover:bg-emerald-50 hover:text-emerald-700 border border-slate-200');
                        $icon.attr('class', 'ti ti-plus text-sm');
                        $text.text('Tampilkan di Hero');
                        $badge.addClass('hidden');
                        $card.removeClass('border-emerald-500 ring-2 ring-emerald-500/20 shadow-md').addClass('border-slate-200/90');
                    }
                }
            },
            error: function () {
                $btn.prop('disabled', false).removeClass('opacity-75');
                $form.off('submit').submit();
            }
        });
    });

    // Delete Photo Confirmation with SweetAlert
    $('.btn-delete-photo').on('click', function(e) {
        e.preventDefault();
        const $form = $(this).closest('form');
        Swal.fire({
            title: 'Hapus foto ini?',
            text: "Foto yang dihapus tidak dapat dipulihkan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#059669',
            cancelButtonColor: '#e11d48',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            customClass: {
                confirmButton: 'px-4 py-2 bg-emerald-600 text-white font-bold rounded-xl text-xs mr-2',
                cancelButton: 'px-4 py-2 bg-slate-200 text-slate-700 font-bold rounded-xl text-xs'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                $form.submit();
            }
        });
    });
});
</script>
@endpush

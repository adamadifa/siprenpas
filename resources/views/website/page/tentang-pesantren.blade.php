@extends('layouts.app')
@section('titlepage', 'Tentang Pesantren')

@section('content')
<div class="max-w-5xl mx-auto space-y-5">

    <!-- ================= 1. PAGE HEADER (NO CARD) WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center border border-emerald-200/80 shadow-2xs">
                    <i class="ti ti-info-circle text-2xl"></i>
                </div>
                <span>Tentang Pesantren</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Kelola naskah profil, sejarah pendirian, nilai-nilai, dan informasi kelembagaan Pesantren Persatuan Islam 80 Al-Amin
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
                <span class="font-bold text-slate-800">Tentang Pesantren</span>
            </nav>
        </div>
    </div>

    <!-- ================= 2. MAIN CONFIGURATION CARD ================= -->
    <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
        <!-- Solid Emerald Header -->
        <div class="bg-emerald-600 px-5 py-4 flex items-center justify-between text-white">
            <div class="flex items-center gap-2.5">
                <i class="ti ti-edit text-xl"></i>
                <h3 class="font-bold text-sm tracking-wide text-white">Konfigurasi Halaman Profil Lembaga</h3>
            </div>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-white/20 text-white backdrop-blur-xs">
                <i class="ti ti-check-circle text-xs"></i> {{ $page ? 'Terakhir diperbarui: ' . $page->updated_at->format('d M Y') : 'Profil Baru' }}
            </span>
        </div>

        <!-- Form Body -->
        <form action="{{ route('tentang-pesantren.store-or-update') }}" method="POST" id="formTentangPesantren" novalidate class="p-5 sm:p-7 space-y-6">
            @csrf

            <!-- Callout Info -->
            <div class="flex items-start gap-3.5 p-4 bg-emerald-50/80 border border-emerald-200/80 rounded-xl text-emerald-900">
                <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 text-base font-bold">
                    <i class="ti ti-bulb"></i>
                </div>
                <div class="text-xs">
                    <p class="font-bold text-emerald-950">Informasi Publik Halaman Tentang Kami</p>
                    <p class="text-emerald-700/90 mt-0.5 leading-relaxed">
                        Halaman ini dapat diakses secara publik oleh calon santri, wali santri, dan masyarakat umum. Pastikan menyajikan sejarah, visi misi kelembagaan, serta fasilitas pendukung dengan gaya penulisan yang rapi dan menarik.
                    </p>
                </div>
            </div>

            <!-- Judul Halaman -->
            <div class="space-y-1.5" id="group_title">
                <label for="title" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                    <i class="ti ti-heading text-slate-400"></i>
                    <span>Judul Halaman <span class="text-rose-500">*</span></span>
                </label>
                <div class="relative">
                    <i class="ti ti-file-text text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 text-base transition-colors" id="icon_title"></i>
                    <input type="text" 
                           name="title" 
                           id="title" 
                           value="{{ old('title', $page ? $page->title : 'Tentang Pesantren Persatuan Islam 80 Al-Amin') }}"
                           placeholder="Masukkan judul halaman tentang pesantren..." 
                           autocomplete="off"
                           class="w-full pl-9 pr-3.5 py-2.5 text-xs font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all placeholder:font-normal placeholder:text-slate-400 @error('title') border-rose-400 bg-rose-50/20 @enderror">
                </div>
                @error('title')
                    <p class="text-[11px] font-semibold text-rose-500 mt-1 flex items-center gap-1">
                        <i class="ti ti-alert-circle text-xs"></i> {{ $message }}
                    </p>
                @enderror
                <p class="text-[11px] font-semibold text-rose-500 hidden mt-1 flex items-center gap-1" id="error_title"></p>
            </div>

            <!-- Konten Lengkap Profil Summernote -->
            <div class="space-y-1.5" id="group_content">
                <div class="flex items-center justify-between">
                    <label for="content" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                        <i class="ti ti-article text-slate-400"></i>
                        <span>Naskah Lengkap Profil Pesantren <span class="text-rose-500">*</span></span>
                    </label>
                    <span class="text-[11px] text-slate-400 font-medium">Summernote Rich Text Editor</span>
                </div>
                
                <div class="border border-slate-300 rounded-xl overflow-hidden shadow-2xs transition-all" id="editor_wrapper">
                    <textarea id="content" name="content" class="hidden">{{ old('content', $page ? $page->content : '') }}</textarea>
                </div>

                <div class="flex items-center justify-between pt-1">
                    <p class="text-[11px] text-slate-400 flex items-center gap-1">
                        <i class="ti ti-info-circle text-xs text-slate-400"></i>
                        <span>Gunakan tombol toolbar di atas untuk format teks (heading, bold, list, tabel, foto, atau video).</span>
                    </p>
                </div>

                @error('content')
                    <p class="text-[11px] font-semibold text-rose-500 mt-1 flex items-center gap-1">
                        <i class="ti ti-alert-circle text-xs"></i> {{ $message }}
                    </p>
                @enderror
                <p class="text-[11px] font-semibold text-rose-500 hidden mt-1 flex items-center gap-1" id="error_content"></p>
            </div>

            <!-- Form Actions -->
            <div class="pt-5 border-t border-slate-100 flex items-center justify-end gap-2.5">
                <button type="submit" id="btnSubmitTentang" class="inline-flex items-center gap-2 px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs transition-all duration-200 cursor-pointer active:scale-95">
                    <i class="ti ti-device-floppy text-base"></i>
                    <span>{{ $page ? 'Perbarui Profil Pesantren' : 'Simpan Profil Pesantren' }}</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('myscript')
<script>
    $(function() {
        // Initialize Summernote with Emerald Theme
        $('#content').summernote({
            height: 480,
            dialogsInBody: true,
            placeholder: 'Tuliskan sejarah berdirinya pesantren, pimpinan, jenjang pendidikan, kurikulum kepesantrenan, program unggulan, dan fasilitas santri secara komprehensif...',
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video', 'hr']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            styleTags: [
                'p',
                { title: 'Blockquote', tag: 'blockquote', className: 'blockquote', value: 'blockquote' },
                'pre', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'
            ],
            callbacks: {
                onChange: function(contents) {
                    const isEmpty = $('#content').summernote('isEmpty');
                    if (!isEmpty) {
                        clearErrorEditor();
                    }
                }
            }
        });

        // Realtime Title Validation
        $("#title").on("input", function() {
            if ($(this).val().trim() !== "") {
                clearErrorInput($("#title"), $("#group_title"), $("#error_title"), $("#icon_title"));
            }
        });

        function showErrorInput($input, $group, $errorMsg, $icon, message) {
            $input.removeClass("border-slate-300 focus:border-emerald-600 focus:ring-emerald-500/20")
                  .addClass("border-rose-400 bg-rose-50/20 focus:border-rose-500 focus:ring-rose-500/20");
            $icon.removeClass("text-slate-400").addClass("text-rose-500");
            $errorMsg.html(`<i class="ti ti-alert-circle text-xs"></i> ${message}`).removeClass("hidden");
        }

        function clearErrorInput($input, $group, $errorMsg, $icon) {
            $input.removeClass("border-rose-400 bg-rose-50/20 focus:border-rose-500 focus:ring-rose-500/20")
                  .addClass("border-slate-300 focus:border-emerald-600 focus:ring-emerald-500/20");
            $icon.removeClass("text-rose-500").addClass("text-slate-400");
            $errorMsg.addClass("hidden").html("");
        }

        function showErrorEditor(message) {
            $("#editor_wrapper").addClass("border-rose-400 ring-2 ring-rose-500/20").removeClass("border-slate-300");
            $("#error_content").html(`<i class="ti ti-alert-circle text-xs"></i> ${message}`).removeClass("hidden");
        }

        function clearErrorEditor() {
            $("#editor_wrapper").removeClass("border-rose-400 ring-2 ring-rose-500/20").addClass("border-slate-300");
            $("#error_content").addClass("hidden").html("");
        }

        $('#formTentangPesantren').on('submit', function(e) {
            let titleVal = $("#title").val().trim();
            let isContentEmpty = $('#content').summernote('isEmpty');
            let isValid = true;

            if (titleVal === "") {
                showErrorInput($("#title"), $("#group_title"), $("#error_title"), $("#icon_title"), "Judul halaman tentang pesantren wajib diisi!");
                $("#title").focus();
                isValid = false;
            } else if (titleVal.length < 5) {
                showErrorInput($("#title"), $("#group_title"), $("#error_title"), $("#icon_title"), "Judul halaman minimal 5 karakter!");
                $("#title").focus();
                isValid = false;
            } else {
                clearErrorInput($("#title"), $("#group_title"), $("#error_title"), $("#icon_title"));
            }

            if (isContentEmpty) {
                showErrorEditor("Naskah profil atau konten tentang pesantren wajib diisi!");
                if (isValid) {
                    $('#content').summernote('focus');
                }
                isValid = false;
            } else {
                clearErrorEditor();
            }

            if (!isValid) {
                e.preventDefault();
                return false;
            }

            $("#btnSubmitTentang").prop("disabled", true).addClass("opacity-75 cursor-not-allowed");
            $("#btnSubmitTentang").html(`
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Menyimpan Profil...</span>
            `);
        });
    });
</script>
@endpush

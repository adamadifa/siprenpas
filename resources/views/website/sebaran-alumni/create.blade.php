@extends('layouts.app')
@section('titlepage', 'Tambah Sebaran Alumni')

@section('content')
<div class="max-w-3xl mx-auto space-y-5">

    <!-- ================= 1. PAGE HEADER (NO CARD) WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center border border-emerald-200/80 shadow-2xs">
                    <i class="ti ti-school text-2xl"></i>
                </div>
                <span>Tambah Sebaran Alumni</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Tambahkan profil universitas atau perguruan tinggi tempat alumni/santri melanjutkan studi
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
                <a href="{{ route('sebaran-alumni.index') }}" class="hover:text-slate-700 transition">
                    <span>Sebaran Alumni</span>
                </a>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Tambah</span>
            </nav>

            <!-- Back Button -->
            <a href="{{ route('sebaran-alumni.index') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs transition cursor-pointer">
                <i class="ti ti-arrow-left text-sm"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <!-- ================= 2. MAIN FORM CARD ================= -->
    <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
        <!-- Solid Emerald Header -->
        <div class="bg-emerald-600 px-5 py-4 flex items-center justify-between text-white">
            <div class="flex items-center gap-2.5">
                <i class="ti ti-forms text-xl"></i>
                <h3 class="font-bold text-sm tracking-wide text-white">Formulir Universitas Baru</h3>
            </div>
            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-white/20 text-white backdrop-blur-xs">
                <i class="ti ti-asterisk text-[10px]"></i> Wajib Diisi
            </span>
        </div>

        <!-- Form Body -->
        <form action="{{ route('sebaran-alumni.store') }}" method="POST" enctype="multipart/form-data" id="formSebaranAlumni" novalidate class="p-5 sm:p-7 space-y-6">
            @csrf

            <!-- Callout Info -->
            <div class="flex items-start gap-3.5 p-4 bg-emerald-50/80 border border-emerald-200/80 rounded-xl text-emerald-900">
                <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 text-base font-bold">
                    <i class="ti ti-info-circle"></i>
                </div>
                <div class="text-xs">
                    <p class="font-bold text-emerald-950">Petunjuk Pengisian</p>
                    <p class="text-emerald-700/90 mt-0.5 leading-relaxed">
                        Pastikan nama universitas ditulis secara lengkap dan resmi. Upload logo berlatar transparan (PNG/SVG/WebP) agar tampil proporsional di landing page portal.
                    </p>
                </div>
            </div>

            <!-- Nama Universitas -->
            <div class="space-y-1.5" id="group_nama_universitas">
                <label for="nama_universitas" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                    <i class="ti ti-building-community text-slate-400"></i>
                    <span>Nama Universitas / Institusi <span class="text-rose-500">*</span></span>
                </label>
                <div class="relative">
                    <i class="ti ti-school text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 text-base transition-colors" id="icon_nama_universitas"></i>
                    <input type="text" 
                           name="nama_universitas" 
                           id="nama_universitas" 
                           value="{{ old('nama_universitas') }}"
                           placeholder="Contoh: Universitas Indonesia, Universitas Al-Azhar Kairo, ITB" 
                           autocomplete="off"
                           class="w-full pl-9 pr-3.5 py-2.5 text-xs font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all placeholder:font-normal placeholder:text-slate-400 @error('nama_universitas') border-rose-400 bg-rose-50/20 @enderror">
                </div>
                @error('nama_universitas')
                    <p class="text-[11px] font-semibold text-rose-500 mt-1 flex items-center gap-1">
                        <i class="ti ti-alert-circle text-xs"></i> {{ $message }}
                    </p>
                @enderror
                <p class="text-[11px] font-semibold text-rose-500 hidden mt-1 flex items-center gap-1" id="error_nama_universitas"></p>
            </div>

            <!-- Upload Logo Universitas -->
            <div class="space-y-1.5" id="group_logo">
                <label class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                    <i class="ti ti-photo text-slate-400"></i>
                    <span>Logo Universitas (Opsional)</span>
                </label>

                <!-- Dropzone Area -->
                <div class="mt-1 flex flex-col sm:flex-row items-center gap-5 p-4 bg-slate-50/70 border-2 border-dashed border-slate-200 hover:border-emerald-500/60 rounded-2xl transition-all group">
                    <!-- Preview Container -->
                    <div class="w-24 h-24 rounded-xl bg-white border border-slate-200/90 shadow-2xs flex items-center justify-center p-2 shrink-0 overflow-hidden relative" id="preview_box">
                        <img id="image_preview" src="#" alt="Preview Logo" class="max-w-full max-h-full object-contain hidden">
                        <div id="preview_placeholder" class="flex flex-col items-center justify-center text-slate-400">
                            <i class="ti ti-photo-plus text-2xl group-hover:text-emerald-600 transition-colors"></i>
                            <span class="text-[10px] font-medium mt-1">Belum Ada</span>
                        </div>
                    </div>

                    <!-- Upload Controls -->
                    <div class="flex-1 text-center sm:text-left space-y-2 w-full">
                        <div class="flex flex-col sm:flex-row sm:items-center gap-2.5">
                            <label for="logo" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-white hover:bg-slate-100 text-slate-700 font-bold rounded-xl text-xs border border-slate-300 shadow-2xs transition-all cursor-pointer">
                                <i class="ti ti-upload text-sm text-emerald-600"></i>
                                <span>Pilih Berkas Logo</span>
                            </label>
                            <span class="text-[11px] text-slate-400" id="file_name_display">Format PNG, JPG, WebP, SVG (Maks. 4MB)</span>
                        </div>
                        <input type="file" name="logo" id="logo" class="hidden" accept="image/png,image/jpeg,image/webp,image/svg+xml">
                        <p class="text-[11px] text-slate-400 leading-normal">
                            Sistem secara otomatis mengoptimasi & mengonversi logo menjadi WebP berkualitas tinggi.
                        </p>
                    </div>
                </div>
                @error('logo')
                    <p class="text-[11px] font-semibold text-rose-500 mt-1 flex items-center gap-1">
                        <i class="ti ti-alert-circle text-xs"></i> {{ $message }}
                    </p>
                @enderror
                <p class="text-[11px] font-semibold text-rose-500 hidden mt-1 flex items-center gap-1" id="error_logo"></p>
            </div>

            <!-- Form Actions -->
            <div class="pt-5 border-t border-slate-100 flex items-center justify-end gap-2.5">
                <a href="{{ route('sebaran-alumni.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs transition cursor-pointer">
                    Batal
                </a>
                <button type="submit" id="btnSubmitAlumni" class="inline-flex items-center gap-2 px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs transition-all duration-200 cursor-pointer">
                    <i class="ti ti-device-floppy text-base"></i>
                    <span>Simpan Data</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('myscript')
<script>
    $(function() {
        // Logo preview handler
        $("#logo").on("change", function(e) {
            const file = e.target.files[0];
            if (file) {
                // Validate size (max 4MB)
                if (file.size > 4 * 1024 * 1024) {
                    showError($("#nama_universitas"), $("#group_logo"), $("#error_logo"), $("#icon_nama_universitas"), "Ukuran logo maksimal 4MB!");
                    $(this).val("");
                    return;
                } else {
                    $("#error_logo").addClass("hidden").html("");
                }

                $("#file_name_display").text(file.name).addClass("font-bold text-slate-700");
                const reader = new FileReader();
                reader.onload = function(e) {
                    $("#image_preview").attr("src", e.target.result).removeClass("hidden");
                    $("#preview_placeholder").addClass("hidden");
                }
                reader.readAsDataURL(file);
            }
        });

        // Realtime validation
        $("#nama_universitas").on("input", function() {
            if ($(this).val().trim() !== "") {
                clearError($("#nama_universitas"), $("#group_nama_universitas"), $("#error_nama_universitas"), $("#icon_nama_universitas"));
            }
        });

        function showError($input, $group, $errorMsg, $icon, message) {
            $input.removeClass("border-slate-300 focus:border-emerald-600 focus:ring-emerald-500/20")
                  .addClass("border-rose-400 bg-rose-50/20 focus:border-rose-500 focus:ring-rose-500/20");
            $icon.removeClass("text-slate-400").addClass("text-rose-500");
            $errorMsg.html(`<i class="ti ti-alert-circle text-xs"></i> ${message}`).removeClass("hidden");
        }

        function clearError($input, $group, $errorMsg, $icon) {
            $input.removeClass("border-rose-400 bg-rose-50/20 focus:border-rose-500 focus:ring-rose-500/20")
                  .addClass("border-slate-300 focus:border-emerald-600 focus:ring-emerald-500/20");
            $icon.removeClass("text-rose-500").addClass("text-slate-400");
            $errorMsg.addClass("hidden").html("");
        }

        $('#formSebaranAlumni').on('submit', function(e) {
            let univVal = $("#nama_universitas").val().trim();
            let isValid = true;

            if (univVal === "") {
                showError($("#nama_universitas"), $("#group_nama_universitas"), $("#error_nama_universitas"), $("#icon_nama_universitas"), "Nama universitas wajib diisi!");
                $("#nama_universitas").focus();
                isValid = false;
            } else if (univVal.length < 3) {
                showError($("#nama_universitas"), $("#group_nama_universitas"), $("#error_nama_universitas"), $("#icon_nama_universitas"), "Nama universitas minimal 3 karakter!");
                $("#nama_universitas").focus();
                isValid = false;
            } else {
                clearError($("#nama_universitas"), $("#group_nama_universitas"), $("#error_nama_universitas"), $("#icon_nama_universitas"));
            }

            if (!isValid) {
                e.preventDefault();
                return false;
            }

            $("#btnSubmitAlumni").prop("disabled", true).addClass("opacity-75 cursor-not-allowed");
            $("#btnSubmitAlumni").html(`
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Menyimpan...</span>
            `);
        });
    });
</script>
@endpush

@extends('layouts.app')
@section('titlepage', 'Tambah Testimoni')

@section('content')
<div class="max-w-3xl mx-auto space-y-5">

    <!-- ================= 1. PAGE HEADER (NO CARD) WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center border border-emerald-200/80 shadow-2xs">
                    <i class="ti ti-message-plus text-2xl"></i>
                </div>
                <span>Tambah Testimoni</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Tambahkan ulasan baru dari wali santri, alumni, penguji, atau tokoh masyarakat
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
                <a href="{{ route('testimonials.index') }}" class="hover:text-slate-700 transition">
                    <span>Testimoni</span>
                </a>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Tambah</span>
            </nav>

            <!-- Back Button -->
            <a href="{{ route('testimonials.index') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs transition cursor-pointer">
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
                <h3 class="font-bold text-sm tracking-wide text-white">Formulir Testimoni Baru</h3>
            </div>
            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-white/20 text-white backdrop-blur-xs">
                <i class="ti ti-asterisk text-[10px]"></i> Wajib Diisi
            </span>
        </div>

        <!-- Form Body -->
        <form action="{{ route('testimonials.store') }}" method="POST" enctype="multipart/form-data" id="formTestimonial" novalidate class="p-5 sm:p-7 space-y-6">
            @csrf

            <!-- Callout Info -->
            <div class="flex items-start gap-3.5 p-4 bg-emerald-50/80 border border-emerald-200/80 rounded-xl text-emerald-900">
                <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 text-base font-bold">
                    <i class="ti ti-info-circle"></i>
                </div>
                <div class="text-xs">
                    <p class="font-bold text-emerald-950">Petunjuk Pengisian</p>
                    <p class="text-emerald-700/90 mt-0.5 leading-relaxed">
                        Tuliskan nama lengkap beserta profil singkat (misal: *Wali Santri Kelas VII*, *Alumni Angkatan 2022*). Foto berbentuk portrait/persegi berlatar rapi disarankan.
                    </p>
                </div>
            </div>

            <!-- Nama Lengkap & Peran -->
            <div class="space-y-1.5" id="group_nama">
                <label for="nama" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                    <i class="ti ti-user text-slate-400"></i>
                    <span>Nama & Identitas <span class="text-rose-500">*</span></span>
                </label>
                <div class="relative">
                    <i class="ti ti-user-check text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 text-base transition-colors" id="icon_nama"></i>
                    <input type="text" 
                           name="nama" 
                           id="nama" 
                           value="{{ old('nama') }}"
                           placeholder="Contoh: H. Ahmad Fauzi (Wali Santri Tsanawiyyah)" 
                           autocomplete="off"
                           class="w-full pl-9 pr-3.5 py-2.5 text-xs font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all placeholder:font-normal placeholder:text-slate-400 @error('nama') border-rose-400 bg-rose-50/20 @enderror">
                </div>
                @error('nama')
                    <p class="text-[11px] font-semibold text-rose-500 mt-1 flex items-center gap-1">
                        <i class="ti ti-alert-circle text-xs"></i> {{ $message }}
                    </p>
                @enderror
                <p class="text-[11px] font-semibold text-rose-500 hidden mt-1 flex items-center gap-1" id="error_nama"></p>
            </div>

            <!-- Isi Testimoni -->
            <div class="space-y-1.5" id="group_testimoni">
                <label for="testimoni" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                    <i class="ti ti-quote text-slate-400"></i>
                    <span>Ulasan / Isi Testimoni <span class="text-rose-500">*</span></span>
                </label>
                <div class="relative">
                    <textarea name="testimoni" 
                              id="testimoni" 
                              rows="4" 
                              placeholder="Tuliskan pengalaman, kesan, atau apresiasi selama menempuh pendidikan di pesantren..." 
                              class="w-full p-3.5 text-xs font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all placeholder:font-normal placeholder:text-slate-400 @error('testimoni') border-rose-400 bg-rose-50/20 @enderror">{{ old('testimoni') }}</textarea>
                </div>
                @error('testimoni')
                    <p class="text-[11px] font-semibold text-rose-500 mt-1 flex items-center gap-1">
                        <i class="ti ti-alert-circle text-xs"></i> {{ $message }}
                    </p>
                @enderror
                <p class="text-[11px] font-semibold text-rose-500 hidden mt-1 flex items-center gap-1" id="error_testimoni"></p>
            </div>

            <!-- Upload Foto Profil -->
            <div class="space-y-1.5" id="group_foto">
                <label class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                    <i class="ti ti-photo text-slate-400"></i>
                    <span>Foto Profil (Opsional)</span>
                </label>

                <!-- Dropzone Area -->
                <div class="mt-1 flex flex-col sm:flex-row items-center gap-5 p-4 bg-slate-50/70 border-2 border-dashed border-slate-200 hover:border-emerald-500/60 rounded-2xl transition-all group">
                    <!-- Preview Container -->
                    <div class="w-20 h-20 rounded-full bg-white border border-slate-200/90 shadow-2xs flex items-center justify-center p-1 shrink-0 overflow-hidden relative" id="preview_box">
                        <img id="image_preview" src="#" alt="Preview Foto" class="w-full h-full object-cover rounded-full hidden">
                        <div id="preview_placeholder" class="flex flex-col items-center justify-center text-slate-400">
                            <i class="ti ti-user text-2xl group-hover:text-emerald-600 transition-colors"></i>
                        </div>
                    </div>

                    <!-- Upload Controls -->
                    <div class="flex-1 text-center sm:text-left space-y-2 w-full">
                        <div class="flex flex-col sm:flex-row sm:items-center gap-2.5">
                            <label for="foto" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-white hover:bg-slate-100 text-slate-700 font-bold rounded-xl text-xs border border-slate-300 shadow-2xs transition-all cursor-pointer">
                                <i class="ti ti-upload text-sm text-emerald-600"></i>
                                <span>Pilih Berkas Foto</span>
                            </label>
                            <span class="text-[11px] text-slate-400" id="file_name_display">Format PNG, JPG, GIF (Maks. 2MB)</span>
                        </div>
                        <input type="file" name="foto" id="foto" class="hidden" accept="image/png,image/jpeg,image/gif">
                        <p class="text-[11px] text-slate-400 leading-normal">
                            Disarankan foto wajah jelas dan proporsional persegi (1:1).
                        </p>
                    </div>
                </div>
                @error('foto')
                    <p class="text-[11px] font-semibold text-rose-500 mt-1 flex items-center gap-1">
                        <i class="ti ti-alert-circle text-xs"></i> {{ $message }}
                    </p>
                @enderror
                <p class="text-[11px] font-semibold text-rose-500 hidden mt-1 flex items-center gap-1" id="error_foto"></p>
            </div>

            <!-- Status Publikasi -->
            <div class="space-y-1.5" id="group_status">
                <label for="status" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                    <i class="ti ti-toggle-left text-slate-400"></i>
                    <span>Status Publikasi <span class="text-rose-500">*</span></span>
                </label>
                <div class="relative">
                    <select name="status" 
                            id="status" 
                            class="w-full px-3.5 py-2.5 text-xs font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all cursor-pointer">
                        <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Aktif (Tampilkan di Website)</option>
                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Nonaktif (Simpan sebagai Draft)</option>
                    </select>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="pt-5 border-t border-slate-100 flex items-center justify-end gap-2.5">
                <a href="{{ route('testimonials.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs transition cursor-pointer">
                    Batal
                </a>
                <button type="submit" id="btnSubmitTesti" class="inline-flex items-center gap-2 px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs transition-all duration-200 cursor-pointer">
                    <i class="ti ti-device-floppy text-base"></i>
                    <span>Simpan Testimoni</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('myscript')
<script>
    $(function() {
        // Foto preview handler
        $("#foto").on("change", function(e) {
            const file = e.target.files[0];
            if (file) {
                if (file.size > 2 * 1024 * 1024) {
                    showError($("#nama"), $("#group_foto"), $("#error_foto"), $("#icon_nama"), "Ukuran foto maksimal 2MB!");
                    $(this).val("");
                    return;
                } else {
                    $("#error_foto").addClass("hidden").html("");
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
        $("#nama").on("input", function() {
            if ($(this).val().trim() !== "") {
                clearError($("#nama"), $("#group_nama"), $("#error_nama"), $("#icon_nama"));
            }
        });

        $("#testimoni").on("input", function() {
            if ($(this).val().trim() !== "") {
                clearError($("#testimoni"), $("#group_testimoni"), $("#error_testimoni"), null);
            }
        });

        function showError($input, $group, $errorMsg, $icon, message) {
            $input.removeClass("border-slate-300 focus:border-emerald-600 focus:ring-emerald-500/20")
                  .addClass("border-rose-400 bg-rose-50/20 focus:border-rose-500 focus:ring-rose-500/20");
            if ($icon) $icon.removeClass("text-slate-400").addClass("text-rose-500");
            $errorMsg.html(`<i class="ti ti-alert-circle text-xs"></i> ${message}`).removeClass("hidden");
        }

        function clearError($input, $group, $errorMsg, $icon) {
            $input.removeClass("border-rose-400 bg-rose-50/20 focus:border-rose-500 focus:ring-rose-500/20")
                  .addClass("border-slate-300 focus:border-emerald-600 focus:ring-emerald-500/20");
            if ($icon) $icon.removeClass("text-rose-500").addClass("text-slate-400");
            $errorMsg.addClass("hidden").html("");
        }

        $('#formTestimonial').on('submit', function(e) {
            let namaVal = $("#nama").val().trim();
            let testiVal = $("#testimoni").val().trim();
            let isValid = true;

            if (namaVal === "") {
                showError($("#nama"), $("#group_nama"), $("#error_nama"), $("#icon_nama"), "Nama pemberi testimoni wajib diisi!");
                $("#nama").focus();
                isValid = false;
            } else {
                clearError($("#nama"), $("#group_nama"), $("#error_nama"), $("#icon_nama"));
            }

            if (testiVal === "") {
                showError($("#testimoni"), $("#group_testimoni"), $("#error_testimoni"), null, "Isi testimoni wajib diisi!");
                if (isValid) $("#testimoni").focus();
                isValid = false;
            } else {
                clearError($("#testimoni"), $("#group_testimoni"), $("#error_testimoni"), null);
            }

            if (!isValid) {
                e.preventDefault();
                return false;
            }

            $("#btnSubmitTesti").prop("disabled", true).addClass("opacity-75 cursor-not-allowed");
            $("#btnSubmitTesti").html(`
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Menyimpan Testimoni...</span>
            `);
        });
    });
</script>
@endpush

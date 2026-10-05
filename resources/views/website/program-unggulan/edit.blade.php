@extends('layouts.app')
@section('titlepage', 'Edit Program Unggulan')

@section('content')
<div class="space-y-5 w-full">

    <!-- ================= 1. PAGE HEADER (FULL WIDTH) WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1 w-full">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center border border-emerald-200/80 shadow-2xs">
                    <i class="ti ti-edit text-2xl"></i>
                </div>
                <span>Edit Program Unggulan</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Perbarui nama, urutan urut, atau deskripsi informasi program unggulan
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
                <a href="{{ route('program-unggulan.index') }}" class="hover:text-slate-700 transition">
                    <span>Program Unggulan</span>
                </a>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Edit</span>
            </nav>

            <!-- Back Button -->
            <a href="{{ route('program-unggulan.index') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs transition cursor-pointer">
                <i class="ti ti-arrow-left text-sm"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <!-- ================= 2. MAIN FORM CARD (LEFT-ALIGNED WITH COMPACT MAX-WIDTH) ================= -->
    <div class="max-w-3xl">
        <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
            <!-- Solid Emerald Header -->
            <div class="bg-emerald-600 px-5 py-4 flex items-center justify-between text-white">
                <div class="flex items-center gap-2.5">
                    <i class="ti ti-edit text-xl"></i>
                    <h3 class="font-bold text-sm tracking-wide text-white">Edit Program: {{ $programUnggulan->nama_program }}</h3>
                </div>
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-white/20 text-white backdrop-blur-xs">
                    <i class="ti ti-asterisk text-[10px]"></i> Wajib Diisi
                </span>
            </div>

            <!-- Form Body -->
            <form action="{{ route('program-unggulan.update', $programUnggulan->id) }}" method="POST" id="formProgramUnggulanEdit" novalidate class="p-5 sm:p-7 space-y-6">
                @csrf
                @method('PUT')

                <!-- Callout Info -->
                <div class="flex items-start gap-3.5 p-4 bg-emerald-50/80 border border-emerald-200/80 rounded-xl text-emerald-900">
                    <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 text-base font-bold">
                        <i class="ti ti-info-circle"></i>
                    </div>
                    <div class="text-xs">
                        <p class="font-bold text-emerald-950">Informasi Pembaruan</p>
                        <p class="text-emerald-700/90 mt-0.5 leading-relaxed">
                            Perubahan pada nama dan urutan akan langsung mempengaruhi susunan program unggulan di landing page website.
                        </p>
                    </div>
                </div>

                <!-- Nama Program -->
                <div class="space-y-1.5" id="group_nama_program_edit">
                    <label for="nama_program_edit" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                        <i class="ti ti-star text-slate-400"></i>
                        <span>Nama Program Unggulan <span class="text-rose-500">*</span></span>
                    </label>
                    <div class="relative">
                        <i class="ti ti-bookmark text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 text-base transition-colors" id="icon_nama_program_edit"></i>
                        <input type="text" 
                               name="nama_program" 
                               id="nama_program_edit" 
                               value="{{ old('nama_program', $programUnggulan->nama_program) }}"
                               placeholder="Contoh: Tahfidz Al-Qur'an 30 Juz Bersanad" 
                               autocomplete="off"
                               class="w-full pl-9 pr-3.5 py-2.5 text-xs font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all placeholder:font-normal placeholder:text-slate-400 @error('nama_program') border-rose-400 bg-rose-50/20 @enderror">
                    </div>
                    @error('nama_program')
                        <p class="text-[11px] font-semibold text-rose-500 mt-1 flex items-center gap-1">
                            <i class="ti ti-alert-circle text-xs"></i> {{ $message }}
                        </p>
                    @enderror
                    <p class="text-[11px] font-semibold text-rose-500 hidden mt-1 flex items-center gap-1" id="error_nama_program_edit"></p>
                </div>

                <!-- Urutan -->
                <div class="space-y-1.5" id="group_urutan_edit">
                    <label for="urutan_edit" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                        <i class="ti ti-arrows-sort text-slate-400"></i>
                        <span>Nomor Urut Tampil <span class="text-rose-500">*</span></span>
                    </label>
                    <div class="relative">
                        <i class="ti ti-sort-ascending-numbers text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 text-base transition-colors" id="icon_urutan_edit"></i>
                        <input type="number" 
                               name="urutan" 
                               id="urutan_edit" 
                               min="0"
                               value="{{ old('urutan', $programUnggulan->urutan) }}"
                               placeholder="0" 
                               class="w-full pl-9 pr-3.5 py-2.5 text-xs font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all @error('urutan') border-rose-400 bg-rose-50/20 @enderror">
                    </div>
                    <p class="text-[11px] text-slate-400">Semakin kecil angka urutan (misal: 1, 2, 3), semakin awal program muncul di halaman utama.</p>
                    @error('urutan')
                        <p class="text-[11px] font-semibold text-rose-500 mt-1 flex items-center gap-1">
                            <i class="ti ti-alert-circle text-xs"></i> {{ $message }}
                        </p>
                    @enderror
                    <p class="text-[11px] font-semibold text-rose-500 hidden mt-1 flex items-center gap-1" id="error_urutan_edit"></p>
                </div>

                <!-- Deskripsi -->
                <div class="space-y-1.5" id="group_deskripsi_edit">
                    <label for="deskripsi_edit" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                        <i class="ti ti-notes text-slate-400"></i>
                        <span>Deskripsi & Ulasan Program</span>
                    </label>
                    <textarea name="deskripsi" 
                              id="deskripsi_edit" 
                              rows="4" 
                              placeholder="Jelaskan secara ringkas kurikulum, target capaian, metode pembelajaran, atau keunggulan dari program ini..." 
                              class="w-full p-3.5 text-xs text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all placeholder:text-slate-400 leading-relaxed @error('deskripsi') border-rose-400 bg-rose-50/20 @enderror">{{ old('deskripsi', $programUnggulan->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <p class="text-[11px] font-semibold text-rose-500 mt-1 flex items-center gap-1">
                            <i class="ti ti-alert-circle text-xs"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-end gap-2.5">
                    <a href="{{ route('program-unggulan.index') }}" 
                       class="w-full sm:w-auto px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs transition inline-flex items-center justify-center cursor-pointer">
                        Batal
                    </a>
                    <button type="submit" 
                            id="btnSubmitEdit" 
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs transition-all duration-200 active:scale-95 cursor-pointer">
                        <i class="ti ti-device-floppy text-base"></i>
                        <span>Perbarui Program Unggulan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('myscript')
<script>
    $(function() {
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

        $("#nama_program_edit").on("input", function() {
            if ($(this).val().trim() !== "") {
                clearError($("#nama_program_edit"), $("#group_nama_program_edit"), $("#error_nama_program_edit"), $("#icon_nama_program_edit"));
            }
        });

        $("#urutan_edit").on("input", function() {
            if ($(this).val().trim() !== "") {
                clearError($("#urutan_edit"), $("#group_urutan_edit"), $("#error_urutan_edit"), $("#icon_urutan_edit"));
            }
        });

        $('#formProgramUnggulanEdit').on('submit', function(e) {
            let namaProgram = $("#nama_program_edit").val().trim();
            let urutan = $("#urutan_edit").val().trim();
            let isValid = true;

            if (namaProgram === "") {
                showError($("#nama_program_edit"), $("#group_nama_program_edit"), $("#error_nama_program_edit"), $("#icon_nama_program_edit"), "Nama program unggulan wajib diisi!");
                $("#nama_program_edit").focus();
                isValid = false;
            } else {
                clearError($("#nama_program_edit"), $("#group_nama_program_edit"), $("#error_nama_program_edit"), $("#icon_nama_program_edit"));
            }

            if (urutan === "") {
                showError($("#urutan_edit"), $("#group_urutan_edit"), $("#error_urutan_edit"), $("#icon_urutan_edit"), "Urutan nomor tampil wajib diisi!");
                if (isValid) $("#urutan_edit").focus();
                isValid = false;
            } else {
                clearError($("#urutan_edit"), $("#group_urutan_edit"), $("#error_urutan_edit"), $("#icon_urutan_edit"));
            }

            if (!isValid) {
                e.preventDefault();
                return false;
            }

            $("#btnSubmitEdit").prop("disabled", true).addClass("opacity-75 cursor-not-allowed");
            $("#btnSubmitEdit").html(`
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Memperbarui...</span>
            `);
        });
    });
</script>
@endpush

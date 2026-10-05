@extends('layouts.app')
@section('titlepage', 'Tambah Prestasi Siswa')

@section('content')
<div class="max-w-4xl mx-auto space-y-5">

    <!-- ================= 1. PAGE HEADER (NO CARD) WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center border border-emerald-200/80 shadow-2xs">
                    <i class="ti ti-trophy text-2xl"></i>
                </div>
                <span>Tambah Prestasi Santri</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Catat capaian juara, kejuaraan, medali, dan sertifikasi santri/siswa
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
                <a href="{{ route('prestasisiswa.index') }}" class="hover:text-slate-700 transition">
                    <span>Prestasi Santri</span>
                </a>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Tambah</span>
            </nav>

            <!-- Back Button -->
            <a href="{{ route('prestasisiswa.index') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs transition cursor-pointer">
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
                <h3 class="font-bold text-sm tracking-wide text-white">Formulir Catatan Prestasi Santri</h3>
            </div>
            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-white/20 text-white backdrop-blur-xs">
                <i class="ti ti-asterisk text-[10px]"></i> Wajib Diisi
            </span>
        </div>

        <!-- Form Body -->
        <form action="{{ route('prestasisiswa.store') }}" method="POST" enctype="multipart/form-data" id="formPrestasiSiswa" novalidate class="p-5 sm:p-7 space-y-6">
            @csrf

            <!-- Callout Info -->
            <div class="flex items-start gap-3.5 p-4 bg-emerald-50/80 border border-emerald-200/80 rounded-xl text-emerald-900">
                <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 text-base font-bold">
                    <i class="ti ti-info-circle"></i>
                </div>
                <div class="text-xs">
                    <p class="font-bold text-emerald-950">Integrasi Data Santri</p>
                    <p class="text-emerald-700/90 mt-0.5 leading-relaxed">
                        Anda dapat memilih santri dari database induk santri aktif untuk otomatis mengisi nama & unit sekolah, atau mengisi kolom nama santri secara manual.
                    </p>
                </div>
            </div>

            <!-- Pilih Siswa Database (Opsional) -->
            <div class="space-y-1.5" id="group_search_siswa">
                <label class="text-xs font-bold text-slate-700 flex items-center justify-between">
                    <span class="flex items-center gap-1.5">
                        <i class="ti ti-user-search text-slate-400"></i>
                        <span>Pilih Santri Terdaftar (Opsional)</span>
                    </span>
                    <span class="text-[11px] text-slate-400 font-normal">Sinkronisasi Database Siswa</span>
                </label>
                <div class="flex items-center gap-2">
                    <div class="relative flex-1">
                        <i class="ti ti-user text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 text-base"></i>
                        <input type="text" 
                               id="nama_siswa_search" 
                               placeholder="Klik tombol cari untuk memilih santri dari database..." 
                               readonly
                               class="w-full pl-9 pr-3.5 py-2.5 text-xs font-bold text-slate-800 bg-slate-50 border border-slate-300 rounded-xl outline-none cursor-pointer">
                        <input type="hidden" id="id_siswa" name="id_siswa" value="{{ old('id_siswa') }}">
                    </div>
                    <button type="button" 
                            id="btnSearchSiswa" 
                            class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-bold rounded-xl text-xs border border-emerald-300 shadow-2xs transition-all cursor-pointer">
                        <i class="ti ti-search text-sm"></i>
                        <span>Cari Santri</span>
                    </button>
                    <button type="button" 
                            id="btnClearSiswa" 
                            class="inline-flex items-center gap-1 px-3 py-2.5 bg-slate-100 hover:bg-rose-50 hover:text-rose-600 text-slate-600 font-bold rounded-xl text-xs border border-slate-200 transition-all cursor-pointer">
                        <i class="ti ti-x text-sm"></i>
                        <span>Reset</span>
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <!-- Unit Jenjang -->
                <div class="space-y-1.5" id="group_kode_unit">
                    <label for="kode_unit" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                        <i class="ti ti-school text-slate-400"></i>
                        <span>Unit Jenjang Sekolah <span class="text-rose-500">*</span></span>
                    </label>
                    <select name="kode_unit" 
                            id="kode_unit" 
                            class="w-full px-3.5 py-2.5 text-xs font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all cursor-pointer @error('kode_unit') border-rose-400 bg-rose-50/20 @enderror">
                        <option value="">-- Pilih Unit Sekolah --</option>
                        @foreach ($units as $u)
                            <option value="{{ $u->kode_unit }}" {{ old('kode_unit') == $u->kode_unit ? 'selected' : '' }}>
                                {{ $u->nama_unit }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-[11px] font-semibold text-rose-500 hidden mt-1 flex items-center gap-1" id="error_kode_unit"></p>
                </div>

                <!-- Tingkat Prestasi -->
                <div class="space-y-1.5" id="group_tingkat">
                    <label for="tingkat" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                        <i class="ti ti-award text-slate-400"></i>
                        <span>Tingkat Kompetisi / Kejuaraan <span class="text-rose-500">*</span></span>
                    </label>
                    <select name="tingkat" 
                            id="tingkat" 
                            class="w-full px-3.5 py-2.5 text-xs font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all cursor-pointer @error('tingkat') border-rose-400 bg-rose-50/20 @enderror">
                        <option value="">-- Pilih Tingkat --</option>
                        <option value="kecamatan" {{ old('tingkat') == 'kecamatan' ? 'selected' : '' }}>Tingkat Kecamatan / Wilayah</option>
                        <option value="kabupaten" {{ old('tingkat') == 'kabupaten' ? 'selected' : '' }}>Tingkat Kabupaten / Kota</option>
                        <option value="nasional" {{ old('tingkat') == 'nasional' ? 'selected' : '' }}>Tingkat Provinsi / Nasional</option>
                    </select>
                    <p class="text-[11px] font-semibold text-rose-500 hidden mt-1 flex items-center gap-1" id="error_tingkat"></p>
                </div>
            </div>

            <!-- Nama Siswa -->
            <div class="space-y-1.5" id="group_nama_siswa">
                <label for="nama_siswa" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                    <i class="ti ti-user-check text-slate-400"></i>
                    <span>Nama Santri / Siswa <span class="text-rose-500">*</span></span>
                </label>
                <div class="relative">
                    <i class="ti ti-user text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 text-base transition-colors" id="icon_nama_siswa"></i>
                    <input type="text" 
                           name="nama_siswa" 
                           id="nama_siswa" 
                           value="{{ old('nama_siswa') }}"
                           placeholder="Contoh: Muhammad Raihan Al-Ghifari" 
                           autocomplete="off"
                           class="w-full pl-9 pr-3.5 py-2.5 text-xs font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all placeholder:font-normal placeholder:text-slate-400 @error('nama_siswa') border-rose-400 bg-rose-50/20 @enderror">
                </div>
                <p class="text-[11px] font-semibold text-rose-500 hidden mt-1 flex items-center gap-1" id="error_nama_siswa"></p>
            </div>

            <!-- Judul Capaian Prestasi -->
            <div class="space-y-1.5" id="group_prestasi">
                <label for="prestasi" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                    <i class="ti ti-medal text-slate-400"></i>
                    <span>Capaian / Gelar Prestasi <span class="text-rose-500">*</span></span>
                </label>
                <textarea name="prestasi" 
                          id="prestasi" 
                          rows="3" 
                          placeholder="Contoh: Juara 1 Musabaqah Hifdzil Qur'an (MHQ) 10 Juz Tingkat Provinsi Jawa Barat 2026" 
                          class="w-full p-3.5 text-xs font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all placeholder:font-normal placeholder:text-slate-400 @error('prestasi') border-rose-400 bg-rose-50/20 @enderror">{{ old('prestasi') }}</textarea>
                <p class="text-[11px] font-semibold text-rose-500 hidden mt-1 flex items-center gap-1" id="error_prestasi"></p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 items-start">
                <!-- Upload Foto Piagam / Dokumentasi -->
                <div class="space-y-1.5" id="group_foto">
                    <label class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                        <i class="ti ti-photo text-slate-400"></i>
                        <span>Foto Dokumentasi / Piagam (Opsional)</span>
                    </label>

                    <div class="flex items-center gap-4 p-3.5 bg-slate-50/70 border-2 border-dashed border-slate-200 hover:border-emerald-500/60 rounded-2xl transition-all">
                        <div class="w-16 h-16 rounded-xl bg-white border border-slate-200 shadow-2xs flex items-center justify-center p-1 shrink-0 overflow-hidden relative">
                            <img id="image_preview" src="#" alt="Preview" class="w-full h-full object-cover rounded-lg hidden">
                            <div id="preview_placeholder" class="text-slate-400">
                                <i class="ti ti-photo-plus text-xl"></i>
                            </div>
                        </div>

                        <div class="flex-1 space-y-1.5">
                            <label for="foto" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white hover:bg-slate-100 text-slate-700 font-bold rounded-lg text-xs border border-slate-300 shadow-2xs transition-all cursor-pointer">
                                <i class="ti ti-upload text-xs text-emerald-600"></i>
                                <span>Pilih Berkas Foto</span>
                            </label>
                            <input type="file" name="foto" id="foto" class="hidden" accept="image/*">
                            <p class="text-[11px] text-slate-400" id="file_name_display">Maksimal 2MB (JPG, PNG)</p>
                        </div>
                    </div>
                    <p class="text-[11px] font-semibold text-rose-500 hidden mt-1 flex items-center gap-1" id="error_foto"></p>
                </div>

                <!-- Status Publikasi -->
                <div class="space-y-1.5" id="group_status">
                    <label for="status" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                        <i class="ti ti-toggle-left text-slate-400"></i>
                        <span>Status Publikasi <span class="text-rose-500">*</span></span>
                    </label>
                    <select name="status" 
                            id="status" 
                            class="w-full px-3.5 py-2.5 text-xs font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all cursor-pointer">
                        <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Aktif (Tampilkan di Website)</option>
                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Nonaktif (Draft)</option>
                    </select>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="pt-5 border-t border-slate-100 flex items-center justify-end gap-2.5">
                <a href="{{ route('prestasisiswa.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs transition cursor-pointer">
                    Batal
                </a>
                <button type="submit" id="btnSubmitPrestasi" class="inline-flex items-center gap-2 px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs transition-all duration-200 cursor-pointer">
                    <i class="ti ti-device-floppy text-base"></i>
                    <span>Simpan Prestasi</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Search Siswa -->
<div class="modal fade" id="modalPilihSiswa" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-2xl border-0 shadow-xl overflow-hidden">
            <!-- Modal Header Solid Emerald -->
            <div class="bg-emerald-600 px-5 py-4 flex items-center justify-between text-white">
                <div class="flex items-center gap-2">
                    <i class="ti ti-user-search text-xl"></i>
                    <h5 class="modal-title font-bold text-sm text-white">Pilih Santri dari Database</h5>
                </div>
                <button type="button" class="text-white/80 hover:text-white transition cursor-pointer" data-bs-dismiss="modal">
                    <i class="ti ti-x text-lg"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-5 space-y-4">
                <div class="relative">
                    <i class="ti ti-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-lg"></i>
                    <input type="text" 
                           id="search_siswa_input" 
                           placeholder="Ketik nama lengkap atau NISN santri..." 
                           class="w-full pl-10 pr-4 py-2.5 text-xs font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none">
                </div>

                <div id="siswa_search_results" class="max-h-[380px] overflow-y-auto space-y-2 pr-1">
                    <div class="text-center py-8 text-slate-400">
                        <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-emerald-500 border-t-transparent mb-2"></div>
                        <p class="text-xs font-semibold">Memuat data santri...</p>
                    </div>
                </div>

                <div id="siswa_search_pagination" class="pt-2 flex justify-center"></div>
            </div>
        </div>
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
                    showError($("#nama_siswa"), $("#error_foto"), "Ukuran foto maksimal 2MB!");
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

        // Search Siswa Modal Logic
        $("#btnSearchSiswa, #nama_siswa_search").on("click", function() {
            $("#modalPilihSiswa").modal("show");
            loadSiswaData();
        });

        $("#btnClearSiswa").on("click", function() {
            $("#id_siswa").val("");
            $("#nama_siswa_search").val("");
            $("#nama_siswa").val("");
            clearError($("#nama_siswa"), $("#error_nama_siswa"), $("#icon_nama_siswa"));
        });

        let searchTimeout;
        $("#search_siswa_input").on("input", function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                loadSiswaData(1, $(this).val());
            }, 300);
        });

        function loadSiswaData(page = 1, search = '') {
            $.ajax({
                url: "{{ route('prestasisiswa.search-siswa') }}",
                type: "GET",
                data: { page: page, search: search },
                success: function(response) {
                    $("#siswa_search_results").html(response.html);
                    $("#siswa_search_pagination").html(response.pagination);
                }
            });
        }

        $(document).on("click", ".clickable-card", function() {
            const id = $(this).data("id");
            const nama = $(this).data("nama");
            const nisn = $(this).data("nisn");
            const kodeUnit = $(this).data("kode-unit");

            $("#id_siswa").val(id);
            $("#nama_siswa_search").val(`${nama} (${nisn})`);
            $("#nama_siswa").val(nama);
            clearError($("#nama_siswa"), $("#error_nama_siswa"), $("#icon_nama_siswa"));

            if (kodeUnit && $("#kode_unit option[value='" + kodeUnit + "']").length > 0) {
                $("#kode_unit").val(kodeUnit);
                clearError($("#kode_unit"), $("#error_kode_unit"));
            }

            $("#modalPilihSiswa").modal("hide");
        });

        $(document).on("click", "#siswa_search_pagination a", function(e) {
            e.preventDefault();
            const page = $(this).attr("href").split("page=")[1];
            loadSiswaData(page, $("#search_siswa_input").val());
        });

        // Realtime validation
        function showError($input, $errorMsg, message, $icon = null) {
            $input.removeClass("border-slate-300 focus:border-emerald-600 focus:ring-emerald-500/20")
                  .addClass("border-rose-400 bg-rose-50/20 focus:border-rose-500 focus:ring-rose-500/20");
            if ($icon) $icon.removeClass("text-slate-400").addClass("text-rose-500");
            $errorMsg.html(`<i class="ti ti-alert-circle text-xs"></i> ${message}`).removeClass("hidden");
        }

        function clearError($input, $errorMsg, $icon = null) {
            $input.removeClass("border-rose-400 bg-rose-50/20 focus:border-rose-500 focus:ring-rose-500/20")
                  .addClass("border-slate-300 focus:border-emerald-600 focus:ring-emerald-500/20");
            if ($icon) $icon.removeClass("text-rose-500").addClass("text-slate-400");
            $errorMsg.addClass("hidden").html("");
        }

        $("#kode_unit").on("change", function() {
            if ($(this).val() !== "") clearError($(this), $("#error_kode_unit"));
        });

        $("#tingkat").on("change", function() {
            if ($(this).val() !== "") clearError($(this), $("#error_tingkat"));
        });

        $("#nama_siswa").on("input", function() {
            if ($(this).val().trim() !== "") clearError($(this), $("#error_nama_siswa"), $("#icon_nama_siswa"));
        });

        $("#prestasi").on("input", function() {
            if ($(this).val().trim() !== "") clearError($(this), $("#error_prestasi"));
        });

        $("#formPrestasiSiswa").on("submit", function(e) {
            let isValid = true;

            if ($("#kode_unit").val() === "") {
                showError($("#kode_unit"), $("#error_kode_unit"), "Unit jenjang sekolah wajib dipilih!");
                isValid = false;
            }
            if ($("#tingkat").val() === "") {
                showError($("#tingkat"), $("#error_tingkat"), "Tingkat kejuaraan wajib dipilih!");
                isValid = false;
            }
            if ($("#nama_siswa").val().trim() === "") {
                showError($("#nama_siswa"), $("#error_nama_siswa"), "Nama santri wajib diisi!", $("#icon_nama_siswa"));
                isValid = false;
            }
            if ($("#prestasi").val().trim() === "") {
                showError($("#prestasi"), $("#error_prestasi"), "Capaian prestasi wajib diisi!");
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
                return false;
            }

            $("#btnSubmitPrestasi").prop("disabled", true).addClass("opacity-75 cursor-not-allowed");
            $("#btnSubmitPrestasi").html(`
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Menyimpan Prestasi...</span>
            `);
        });
    });
</script>
@endpush

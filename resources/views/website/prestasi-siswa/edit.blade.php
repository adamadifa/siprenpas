@extends('layouts.app')
@section('titlepage', 'Edit Prestasi Siswa')

@section('content')
<div class="max-w-4xl mx-auto space-y-5">

    <!-- ================= 1. PAGE HEADER (NO CARD) WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center border border-emerald-200/80 shadow-2xs">
                    <i class="ti ti-edit text-2xl"></i>
                </div>
                <span>Edit Prestasi Santri</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Perbarui data rekam capaian, tingkat lomba, unit sekolah, atau foto piagam penghargaan
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
                <span class="font-bold text-slate-800">Edit</span>
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
                <i class="ti ti-edit text-xl"></i>
                <h3 class="font-bold text-sm tracking-wide text-white">Edit Data Prestasi: {{ $prestasiSiswa->nama_siswa }}</h3>
            </div>
            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-white/20 text-white backdrop-blur-xs">
                <i class="ti ti-asterisk text-[10px]"></i> Wajib Diisi
            </span>
        </div>

        <!-- Form Body -->
        <form action="{{ route('prestasisiswa.update', $prestasiSiswa->id) }}" method="POST" enctype="multipart/form-data" id="formPrestasiSiswaEdit" novalidate class="p-5 sm:p-7 space-y-6">
            @csrf
            @method('PUT')

            <!-- Callout Info -->
            <div class="flex items-start gap-3.5 p-4 bg-emerald-50/80 border border-emerald-200/80 rounded-xl text-emerald-900">
                <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 text-base font-bold">
                    <i class="ti ti-info-circle"></i>
                </div>
                <div class="text-xs">
                    <p class="font-bold text-emerald-950">Informasi Perubahan Data</p>
                    <p class="text-emerald-700/90 mt-0.5 leading-relaxed">
                        Biarkan kolom foto kosong jika tidak ingin memperbarui berkas piagam/dokumentasi prestasi yang sudah tersimpan.
                    </p>
                </div>
            </div>

            <!-- Pilih Siswa Database (Opsional) -->
            <div class="space-y-1.5" id="group_search_siswa_edit">
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
                               id="nama_siswa_search_edit" 
                               placeholder="Klik tombol cari untuk memilih santri dari database..." 
                               readonly
                               value="{{ $prestasiSiswa->id_siswa ? ($prestasiSiswa->siswa ? $prestasiSiswa->siswa->nama_lengkap . ' (' . ($prestasiSiswa->siswa->nisn ?? '-') . ')' : '') : '' }}"
                               class="w-full pl-9 pr-3.5 py-2.5 text-xs font-bold text-slate-800 bg-slate-50 border border-slate-300 rounded-xl outline-none cursor-pointer">
                        <input type="hidden" id="id_siswa_edit" name="id_siswa" value="{{ old('id_siswa', $prestasiSiswa->id_siswa) }}">
                    </div>
                    <button type="button" 
                            id="btnSearchSiswaEdit" 
                            class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-bold rounded-xl text-xs border border-emerald-300 shadow-2xs transition-all cursor-pointer">
                        <i class="ti ti-search text-sm"></i>
                        <span>Cari Santri</span>
                    </button>
                    <button type="button" 
                            id="btnClearSiswaEdit" 
                            class="inline-flex items-center gap-1 px-3 py-2.5 bg-slate-100 hover:bg-rose-50 hover:text-rose-600 text-slate-600 font-bold rounded-xl text-xs border border-slate-200 transition-all cursor-pointer">
                        <i class="ti ti-x text-sm"></i>
                        <span>Reset</span>
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <!-- Unit Jenjang -->
                <div class="space-y-1.5" id="group_kode_unit_edit">
                    <label for="kode_unit_edit" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                        <i class="ti ti-school text-slate-400"></i>
                        <span>Unit Jenjang Sekolah <span class="text-rose-500">*</span></span>
                    </label>
                    <select name="kode_unit" 
                            id="kode_unit_edit" 
                            class="w-full px-3.5 py-2.5 text-xs font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all cursor-pointer @error('kode_unit') border-rose-400 bg-rose-50/20 @enderror">
                        <option value="">-- Pilih Unit Sekolah --</option>
                        @foreach ($units as $u)
                            <option value="{{ $u->kode_unit }}" {{ old('kode_unit', $prestasiSiswa->kode_unit) == $u->kode_unit ? 'selected' : '' }}>
                                {{ $u->nama_unit }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-[11px] font-semibold text-rose-500 hidden mt-1 flex items-center gap-1" id="error_kode_unit_edit"></p>
                </div>

                <!-- Tingkat Prestasi -->
                <div class="space-y-1.5" id="group_tingkat_edit">
                    <label for="tingkat_edit" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                        <i class="ti ti-award text-slate-400"></i>
                        <span>Tingkat Kompetisi / Kejuaraan <span class="text-rose-500">*</span></span>
                    </label>
                    <select name="tingkat" 
                            id="tingkat_edit" 
                            class="w-full px-3.5 py-2.5 text-xs font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all cursor-pointer @error('tingkat') border-rose-400 bg-rose-50/20 @enderror">
                        <option value="">-- Pilih Tingkat --</option>
                        <option value="kecamatan" {{ old('tingkat', $prestasiSiswa->tingkat) == 'kecamatan' ? 'selected' : '' }}>Tingkat Kecamatan / Wilayah</option>
                        <option value="kabupaten" {{ old('tingkat', $prestasiSiswa->tingkat) == 'kabupaten' ? 'selected' : '' }}>Tingkat Kabupaten / Kota</option>
                        <option value="nasional" {{ old('tingkat', $prestasiSiswa->tingkat) == 'nasional' ? 'selected' : '' }}>Tingkat Provinsi / Nasional</option>
                    </select>
                    <p class="text-[11px] font-semibold text-rose-500 hidden mt-1 flex items-center gap-1" id="error_tingkat_edit"></p>
                </div>
            </div>

            <!-- Nama Siswa -->
            <div class="space-y-1.5" id="group_nama_siswa_edit">
                <label for="nama_siswa_edit" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                    <i class="ti ti-user-check text-slate-400"></i>
                    <span>Nama Santri / Siswa <span class="text-rose-500">*</span></span>
                </label>
                <div class="relative">
                    <i class="ti ti-user text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 text-base transition-colors" id="icon_nama_siswa_edit"></i>
                    <input type="text" 
                           name="nama_siswa" 
                           id="nama_siswa_edit" 
                           value="{{ old('nama_siswa', $prestasiSiswa->nama_siswa) }}"
                           placeholder="Contoh: Muhammad Raihan Al-Ghifari" 
                           autocomplete="off"
                           class="w-full pl-9 pr-3.5 py-2.5 text-xs font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all placeholder:font-normal placeholder:text-slate-400 @error('nama_siswa') border-rose-400 bg-rose-50/20 @enderror">
                </div>
                <p class="text-[11px] font-semibold text-rose-500 hidden mt-1 flex items-center gap-1" id="error_nama_siswa_edit"></p>
            </div>

            <!-- Judul Capaian Prestasi -->
            <div class="space-y-1.5" id="group_prestasi_edit">
                <label for="prestasi_edit" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                    <i class="ti ti-medal text-slate-400"></i>
                    <span>Capaian / Gelar Prestasi <span class="text-rose-500">*</span></span>
                </label>
                <textarea name="prestasi" 
                          id="prestasi_edit" 
                          rows="3" 
                          placeholder="Contoh: Juara 1 Musabaqah Hifdzil Qur'an (MHQ) 10 Juz..." 
                          class="w-full p-3.5 text-xs font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all placeholder:font-normal placeholder:text-slate-400 @error('prestasi') border-rose-400 bg-rose-50/20 @enderror">{{ old('prestasi', $prestasiSiswa->prestasi) }}</textarea>
                <p class="text-[11px] font-semibold text-rose-500 hidden mt-1 flex items-center gap-1" id="error_prestasi_edit"></p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 items-start">
                <!-- Upload Foto Piagam / Dokumentasi -->
                <div class="space-y-1.5" id="group_foto_edit">
                    <label class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                        <i class="ti ti-photo text-slate-400"></i>
                        <span>Foto Dokumentasi / Piagam</span>
                    </label>

                    <div class="flex items-center gap-4 p-3.5 bg-slate-50/70 border-2 border-dashed border-slate-200 hover:border-emerald-500/60 rounded-2xl transition-all">
                        <div class="w-16 h-16 rounded-xl bg-white border border-slate-200 shadow-2xs flex items-center justify-center p-1 shrink-0 overflow-hidden relative">
                            @if ($prestasiSiswa->foto && Storage::disk('public')->exists('prestasi-siswa/' . $prestasiSiswa->foto))
                                <img id="image_preview_edit" src="{{ asset('storage/prestasi-siswa/' . $prestasiSiswa->foto) }}" alt="Preview" class="w-full h-full object-cover rounded-lg">
                                <div id="preview_placeholder_edit" class="text-slate-400 hidden">
                                    <i class="ti ti-photo-plus text-xl"></i>
                                </div>
                            @else
                                <img id="image_preview_edit" src="#" alt="Preview" class="w-full h-full object-cover rounded-lg hidden">
                                <div id="preview_placeholder_edit" class="text-slate-400">
                                    <i class="ti ti-photo-plus text-xl"></i>
                                </div>
                            @endif
                        </div>

                        <div class="flex-1 space-y-1.5">
                            <label for="foto_edit" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white hover:bg-slate-100 text-slate-700 font-bold rounded-lg text-xs border border-slate-300 shadow-2xs transition-all cursor-pointer">
                                <i class="ti ti-upload text-xs text-emerald-600"></i>
                                <span>Ganti Berkas Foto</span>
                            </label>
                            <input type="file" name="foto" id="foto_edit" class="hidden" accept="image/*">
                            <p class="text-[11px] text-slate-400" id="file_name_display_edit">Kosongkan bila tidak ada pergantian foto</p>
                        </div>
                    </div>
                    <p class="text-[11px] font-semibold text-rose-500 hidden mt-1 flex items-center gap-1" id="error_foto_edit"></p>
                </div>

                <!-- Status Publikasi -->
                <div class="space-y-1.5" id="group_status_edit">
                    <label for="status_edit" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                        <i class="ti ti-toggle-left text-slate-400"></i>
                        <span>Status Publikasi <span class="text-rose-500">*</span></span>
                    </label>
                    <select name="status" 
                            id="status_edit" 
                            class="w-full px-3.5 py-2.5 text-xs font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all cursor-pointer">
                        <option value="1" {{ old('status', $prestasiSiswa->status) == '1' ? 'selected' : '' }}>Aktif (Tampilkan di Website)</option>
                        <option value="0" {{ old('status', $prestasiSiswa->status) == '0' ? 'selected' : '' }}>Nonaktif (Draft)</option>
                    </select>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="pt-5 border-t border-slate-100 flex items-center justify-end gap-2.5">
                <a href="{{ route('prestasisiswa.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs transition cursor-pointer">
                    Batal
                </a>
                <button type="submit" id="btnSubmitPrestasiEdit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs transition-all duration-200 cursor-pointer">
                    <i class="ti ti-device-floppy text-base"></i>
                    <span>Perbarui Prestasi</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Search Siswa Edit -->
<div class="modal fade" id="modalPilihSiswaEdit" tabindex="-1" aria-hidden="true">
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
                           id="search_siswa_input_edit" 
                           placeholder="Ketik nama lengkap atau NISN santri..." 
                           class="w-full pl-10 pr-4 py-2.5 text-xs font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none">
                </div>

                <div id="siswa_search_results_edit" class="max-h-[380px] overflow-y-auto space-y-2 pr-1">
                    <div class="text-center py-8 text-slate-400">
                        <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-emerald-500 border-t-transparent mb-2"></div>
                        <p class="text-xs font-semibold">Memuat data santri...</p>
                    </div>
                </div>

                <div id="siswa_search_pagination_edit" class="pt-2 flex justify-center"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('myscript')
<script>
    $(function() {
        // Foto preview handler
        $("#foto_edit").on("change", function(e) {
            const file = e.target.files[0];
            if (file) {
                if (file.size > 2 * 1024 * 1024) {
                    showError($("#nama_siswa_edit"), $("#error_foto_edit"), "Ukuran foto maksimal 2MB!");
                    $(this).val("");
                    return;
                } else {
                    $("#error_foto_edit").addClass("hidden").html("");
                }

                $("#file_name_display_edit").text(file.name).addClass("font-bold text-slate-700");
                const reader = new FileReader();
                reader.onload = function(e) {
                    $("#image_preview_edit").attr("src", e.target.result).removeClass("hidden");
                    $("#preview_placeholder_edit").addClass("hidden");
                }
                reader.readAsDataURL(file);
            }
        });

        // Search Siswa Modal Logic
        $("#btnSearchSiswaEdit, #nama_siswa_search_edit").on("click", function() {
            $("#modalPilihSiswaEdit").modal("show");
            loadSiswaDataEdit();
        });

        $("#btnClearSiswaEdit").on("click", function() {
            $("#id_siswa_edit").val("");
            $("#nama_siswa_search_edit").val("");
            $("#nama_siswa_edit").val("");
            clearError($("#nama_siswa_edit"), $("#error_nama_siswa_edit"), $("#icon_nama_siswa_edit"));
        });

        let searchTimeoutEdit;
        $("#search_siswa_input_edit").on("input", function() {
            clearTimeout(searchTimeoutEdit);
            searchTimeoutEdit = setTimeout(() => {
                loadSiswaDataEdit(1, $(this).val());
            }, 300);
        });

        function loadSiswaDataEdit(page = 1, search = '') {
            $.ajax({
                url: "{{ route('prestasisiswa.search-siswa') }}",
                type: "GET",
                data: { page: page, search: search },
                success: function(response) {
                    $("#siswa_search_results_edit").html(response.html);
                    $("#siswa_search_pagination_edit").html(response.pagination);
                }
            });
        }

        $(document).on("click", "#modalPilihSiswaEdit .clickable-card", function() {
            const id = $(this).data("id");
            const nama = $(this).data("nama");
            const nisn = $(this).data("nisn");
            const kodeUnit = $(this).data("kode-unit");

            $("#id_siswa_edit").val(id);
            $("#nama_siswa_search_edit").val(`${nama} (${nisn})`);
            $("#nama_siswa_edit").val(nama);
            clearError($("#nama_siswa_edit"), $("#error_nama_siswa_edit"), $("#icon_nama_siswa_edit"));

            if (kodeUnit && $("#kode_unit_edit option[value='" + kodeUnit + "']").length > 0) {
                $("#kode_unit_edit").val(kodeUnit);
                clearError($("#kode_unit_edit"), $("#error_kode_unit_edit"));
            }

            $("#modalPilihSiswaEdit").modal("hide");
        });

        $(document).on("click", "#siswa_search_pagination_edit a", function(e) {
            e.preventDefault();
            const page = $(this).attr("href").split("page=")[1];
            loadSiswaDataEdit(page, $("#search_siswa_input_edit").val());
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

        $("#kode_unit_edit").on("change", function() {
            if ($(this).val() !== "") clearError($(this), $("#error_kode_unit_edit"));
        });

        $("#tingkat_edit").on("change", function() {
            if ($(this).val() !== "") clearError($(this), $("#error_tingkat_edit"));
        });

        $("#nama_siswa_edit").on("input", function() {
            if ($(this).val().trim() !== "") clearError($(this), $("#error_nama_siswa_edit"), $("#icon_nama_siswa_edit"));
        });

        $("#prestasi_edit").on("input", function() {
            if ($(this).val().trim() !== "") clearError($(this), $("#error_prestasi_edit"));
        });

        $("#formPrestasiSiswaEdit").on("submit", function(e) {
            let isValid = true;

            if ($("#kode_unit_edit").val() === "") {
                showError($("#kode_unit_edit"), $("#error_kode_unit_edit"), "Unit jenjang sekolah wajib dipilih!");
                isValid = false;
            }
            if ($("#tingkat_edit").val() === "") {
                showError($("#tingkat_edit"), $("#error_tingkat_edit"), "Tingkat kejuaraan wajib dipilih!");
                isValid = false;
            }
            if ($("#nama_siswa_edit").val().trim() === "") {
                showError($("#nama_siswa_edit"), $("#error_nama_siswa_edit"), "Nama santri wajib diisi!", $("#icon_nama_siswa_edit"));
                isValid = false;
            }
            if ($("#prestasi_edit").val().trim() === "") {
                showError($("#prestasi_edit"), $("#error_prestasi_edit"), "Capaian prestasi wajib diisi!");
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
                return false;
            }

            $("#btnSubmitPrestasiEdit").prop("disabled", true).addClass("opacity-75 cursor-not-allowed");
            $("#btnSubmitPrestasiEdit").html(`
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Memperbarui Prestasi...</span>
            `);
        });
    });
</script>
@endpush

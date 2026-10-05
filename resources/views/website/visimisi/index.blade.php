@extends('layouts.app')
@section('titlepage', 'Visi & Misi Lembaga')

@section('content')
<div class="space-y-6">

    <!-- ================= 1. PAGE HEADER (NO CARD) WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center border border-emerald-200/80 shadow-2xs">
                    <i class="ti ti-target text-2xl"></i>
                </div>
                <span>Visi & Misi Lembaga</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Kelola arah tujuan strategis, cita-cita luhur, dan butir-butir misi Pesantren Persatuan Islam 80 Al-Amin
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
                <span class="font-bold text-slate-800">Visi & Misi</span>
            </nav>
        </div>
    </div>

    <!-- ================= 2. VISI LEMBAGA CARD ================= -->
    <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
        <!-- Solid Emerald Header -->
        <div class="bg-emerald-600 px-5 py-4 flex items-center justify-between text-white">
            <div class="flex items-center gap-2.5">
                <i class="ti ti-eye text-xl"></i>
                <h3 class="font-bold text-sm tracking-wide text-white">Visi Utama Pesantren</h3>
            </div>
            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-white/20 text-white backdrop-blur-xs">
                <i class="ti ti-sparkles text-xs"></i> Rumusan Utama
            </span>
        </div>

        <!-- Form Body -->
        <form action="{{ route('visimisi.visi.store') }}" method="POST" id="formVisi" novalidate class="p-5 sm:p-7 space-y-4">
            @csrf

            <!-- Callout Info -->
            <div class="flex items-start gap-3.5 p-4 bg-emerald-50/80 border border-emerald-200/80 rounded-xl text-emerald-900">
                <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 text-base font-bold">
                    <i class="ti ti-info-circle"></i>
                </div>
                <div class="text-xs">
                    <p class="font-bold text-emerald-950">Pedoman Perumusan Visi</p>
                    <p class="text-emerald-700/90 mt-0.5 leading-relaxed">
                        Hanya terdapat 1 (satu) rumusan Visi lembaga yang aktif. Menyimpan formulir ini secara otomatis akan memperbarui visi yang tampil di website utama.
                    </p>
                </div>
            </div>

            <!-- Textarea Visi -->
            <div class="space-y-1.5" id="group_visi">
                <label for="deskripsi_visi" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                    <i class="ti ti-quote text-slate-400"></i>
                    <span>Teks Rumusan Visi Lembaga <span class="text-rose-500">*</span></span>
                </label>
                <div class="relative">
                    <textarea name="deskripsi" 
                              id="deskripsi_visi" 
                              rows="3" 
                              placeholder="Tuliskan rumusan visi pesantren..." 
                              class="w-full p-3.5 text-xs font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all placeholder:font-normal placeholder:text-slate-400 @error('deskripsi') border-rose-400 bg-rose-50/20 @enderror">{{ old('deskripsi', optional($visi)->deskripsi) }}</textarea>
                </div>
                @error('deskripsi')
                    <p class="text-[11px] font-semibold text-rose-500 mt-1 flex items-center gap-1">
                        <i class="ti ti-alert-circle text-xs"></i> {{ $message }}
                    </p>
                @enderror
                <p class="text-[11px] font-semibold text-rose-500 hidden mt-1 flex items-center gap-1" id="error_visi"></p>
            </div>

            <!-- Action Button -->
            <div class="pt-2 flex justify-end">
                <button type="submit" id="btnSubmitVisi" class="inline-flex items-center gap-2 px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs transition-all duration-200 cursor-pointer active:scale-95">
                    <i class="ti ti-device-floppy text-base"></i>
                    <span>Simpan Visi Lembaga</span>
                </button>
            </div>
        </form>
    </div>

    <!-- ================= 3. MISI LEMBAGA CARD & TABLE ================= -->
    <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
        <!-- Solid Emerald Header -->
        <div class="bg-emerald-600 px-5 py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-white">
            <div class="flex items-center gap-2.5">
                <i class="ti ti-list-check text-xl"></i>
                <div>
                    <h3 class="font-bold text-sm tracking-wide text-white">Butir-Butir Misi Pesantren</h3>
                    <p class="text-[11px] text-emerald-100 font-medium">Daftar langkah strategis pelaksanaan visi</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-white/20 text-white backdrop-blur-xs">
                    Total: {{ count($misi) }} Misi
                </span>
                <button type="button" 
                        data-bs-toggle="modal" 
                        data-bs-target="#modalMisi" 
                        class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-white hover:bg-emerald-50 text-emerald-800 font-bold rounded-xl text-xs shadow-xs transition-all active:scale-95 cursor-pointer">
                    <i class="ti ti-plus text-sm"></i>
                    <span>Tambah Misi</span>
                </button>
            </div>
        </div>

        <!-- Table Container -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-emerald-600 text-white uppercase text-[11px] font-extrabold tracking-wider border-t border-emerald-500/50">
                        <th class="py-3.5 px-4 w-14 text-center">NO</th>
                        <th class="py-3.5 px-5 w-64 min-w-[200px]">POIN / JUDUL MISI</th>
                        <th class="py-3.5 px-5 min-w-[360px]">URAIAN DESKRIPSI MISI</th>
                        <th class="py-3.5 px-4 text-center w-28">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                    @forelse ($misi as $d)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <!-- No -->
                            <td class="py-4 px-4 text-center font-bold text-slate-400">
                                {{ $loop->iteration }}
                            </td>

                            <!-- Judul Misi -->
                            <td class="py-4 px-5">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-md bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0 font-bold text-[11px] border border-emerald-200/80">
                                        {{ $loop->iteration }}
                                    </div>
                                    <span class="font-bold text-slate-800 text-xs">
                                        {{ $d->judul ?: 'Misi ke-' . $loop->iteration }}
                                    </span>
                                </div>
                            </td>

                            <!-- Deskripsi Misi -->
                            <td class="py-4 px-5">
                                <p class="text-slate-600 text-xs leading-relaxed font-medium">
                                    {{ $d->deskripsi }}
                                </p>
                            </td>

                            <!-- Aksi -->
                            <td class="py-4 px-4 text-center">
                                <div class="inline-flex items-center justify-center gap-1.5">
                                    <button type="button" 
                                            class="w-8 h-8 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 flex items-center justify-center transition-colors border border-emerald-200/60 cursor-pointer" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalEditMisi{{ $d->id }}"
                                            title="Edit Misi">
                                        <i class="ti ti-edit text-base"></i>
                                    </button>

                                    <form method="POST" class="deleteform inline-block" action="{{ route('visimisi.misi.delete', $d->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                class="w-8 h-8 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 flex items-center justify-center transition-colors border border-rose-200/60 delete-confirm cursor-pointer"
                                                title="Hapus Misi">
                                            <i class="ti ti-trash text-base"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <!-- Edit Modal for this Misi -->
                        <div class="modal fade" id="modalEditMisi{{ $d->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content rounded-2xl border-0 shadow-lg overflow-hidden">
                                    <!-- Modal Header Solid Emerald -->
                                    <div class="bg-emerald-600 px-5 py-3.5 flex items-center justify-between text-white">
                                        <div class="flex items-center gap-2">
                                            <i class="ti ti-edit text-lg"></i>
                                            <h5 class="modal-title font-bold text-sm text-white">Edit Butir Misi #{{ $loop->iteration }}</h5>
                                        </div>
                                        <button type="button" class="text-white/80 hover:text-white transition cursor-pointer" data-bs-dismiss="modal">
                                            <i class="ti ti-x text-lg"></i>
                                        </button>
                                    </div>

                                    <!-- Modal Form -->
                                    <form action="{{ route('visimisi.misi.update', $d->id) }}" method="POST" class="formEditMisi space-y-4 p-5">
                                        @csrf
                                        @method('PUT')

                                        <!-- Judul -->
                                        <div class="space-y-1.5">
                                            <label class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                                                <i class="ti ti-heading text-slate-400"></i>
                                                <span>Poin / Judul Misi (Opsional)</span>
                                            </label>
                                            <input type="text" 
                                                   name="judul" 
                                                   value="{{ $d->judul }}" 
                                                   placeholder="Contoh: Pendidikan Berbasis Adab"
                                                   class="w-full px-3.5 py-2.5 text-xs font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all placeholder:font-normal placeholder:text-slate-400">
                                        </div>

                                        <!-- Deskripsi -->
                                        <div class="space-y-1.5 group_deskripsi_edit">
                                            <label class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                                                <i class="ti ti-file-text text-slate-400"></i>
                                                <span>Uraian Deskripsi Misi <span class="text-rose-500">*</span></span>
                                            </label>
                                            <textarea name="deskripsi" 
                                                      rows="4" 
                                                      placeholder="Tuliskan uraian misi secara komprehensif..." 
                                                      class="deskripsi_misi_input w-full p-3.5 text-xs font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all placeholder:font-normal placeholder:text-slate-400" 
                                                      required>{{ $d->deskripsi }}</textarea>
                                            <p class="error_misi_edit text-[11px] font-semibold text-rose-500 hidden mt-1 flex items-center gap-1"></p>
                                        </div>

                                        <!-- Modal Footer -->
                                        <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                                            <button type="button" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs transition cursor-pointer" data-bs-dismiss="modal">
                                                Batal
                                            </button>
                                            <button type="submit" class="btnSubmitEditMisi inline-flex items-center gap-2 px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs transition-all duration-200 cursor-pointer">
                                                <i class="ti ti-device-floppy text-sm"></i>
                                                <span>Perbarui Misi</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center">
                                <div class="flex flex-col items-center justify-center gap-3">
                                    <div class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center">
                                        <i class="ti ti-list-details text-3xl"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-700 text-sm">Belum Ada Butir Misi</p>
                                        <p class="text-xs text-slate-400 mt-0.5">Silahkan klik tombol Tambah Misi di atas untuk menambahkan poin misi lembaga.</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ================= ADD MISI MODAL ================= -->
<div class="modal fade" id="modalMisi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-2xl border-0 shadow-lg overflow-hidden">
            <!-- Modal Header Solid Emerald -->
            <div class="bg-emerald-600 px-5 py-3.5 flex items-center justify-between text-white">
                <div class="flex items-center gap-2">
                    <i class="ti ti-plus text-lg"></i>
                    <h5 class="modal-title font-bold text-sm text-white">Tambah Butir Misi Baru</h5>
                </div>
                <button type="button" class="text-white/80 hover:text-white transition cursor-pointer" data-bs-dismiss="modal">
                    <i class="ti ti-x text-lg"></i>
                </button>
            </div>

            <!-- Modal Form -->
            <form action="{{ route('visimisi.misi.store') }}" method="POST" id="formAddMisi" novalidate class="space-y-4 p-5">
                @csrf

                <!-- Judul Misi -->
                <div class="space-y-1.5">
                    <label for="judul_misi_add" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                        <i class="ti ti-heading text-slate-400"></i>
                        <span>Poin / Judul Misi (Opsional)</span>
                    </label>
                    <input type="text" 
                           name="judul" 
                           id="judul_misi_add" 
                           placeholder="Contoh: Penguatan Bahasa Arab & Inggris"
                           class="w-full px-3.5 py-2.5 text-xs font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all placeholder:font-normal placeholder:text-slate-400">
                </div>

                <!-- Deskripsi Misi -->
                <div class="space-y-1.5" id="group_deskripsi_add">
                    <label for="deskripsi_misi_add" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                        <i class="ti ti-file-text text-slate-400"></i>
                        <span>Uraian Deskripsi Misi <span class="text-rose-500">*</span></span>
                    </label>
                    <textarea name="deskripsi" 
                              id="deskripsi_misi_add" 
                              rows="4" 
                              placeholder="Tuliskan butir langkah strategis misi lembaga..." 
                              class="w-full p-3.5 text-xs font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all placeholder:font-normal placeholder:text-slate-400"></textarea>
                    <p class="text-[11px] font-semibold text-rose-500 hidden mt-1 flex items-center gap-1" id="error_misi_add"></p>
                </div>

                <!-- Modal Footer -->
                <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                    <button type="button" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs transition cursor-pointer" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" id="btnSubmitAddMisi" class="inline-flex items-center gap-2 px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs transition-all duration-200 cursor-pointer">
                        <i class="ti ti-device-floppy text-sm"></i>
                        <span>Simpan Misi</span>
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
        // Realtime validation helper
        function showError($input, $errorMsg, message) {
            $input.removeClass("border-slate-300 focus:border-emerald-600 focus:ring-emerald-500/20")
                  .addClass("border-rose-400 bg-rose-50/20 focus:border-rose-500 focus:ring-rose-500/20");
            $errorMsg.html(`<i class="ti ti-alert-circle text-xs"></i> ${message}`).removeClass("hidden");
        }

        function clearError($input, $errorMsg) {
            $input.removeClass("border-rose-400 bg-rose-50/20 focus:border-rose-500 focus:ring-rose-500/20")
                  .addClass("border-slate-300 focus:border-emerald-600 focus:ring-emerald-500/20");
            $errorMsg.addClass("hidden").html("");
        }

        // Form Visi validation
        $("#deskripsi_visi").on("input", function() {
            if ($(this).val().trim() !== "") {
                clearError($("#deskripsi_visi"), $("#error_visi"));
            }
        });

        $("#formVisi").on("submit", function(e) {
            let visiVal = $("#deskripsi_visi").val().trim();
            if (visiVal === "") {
                e.preventDefault();
                showError($("#deskripsi_visi"), $("#error_visi"), "Deskripsi visi pesantren wajib diisi!");
                $("#deskripsi_visi").focus();
                return false;
            } else if (visiVal.length < 5) {
                e.preventDefault();
                showError($("#deskripsi_visi"), $("#error_visi"), "Deskripsi visi minimal 5 karakter!");
                $("#deskripsi_visi").focus();
                return false;
            } else {
                clearError($("#deskripsi_visi"), $("#error_visi"));
            }

            $("#btnSubmitVisi").prop("disabled", true).addClass("opacity-75 cursor-not-allowed");
            $("#btnSubmitVisi").html(`
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Menyimpan Visi...</span>
            `);
        });

        // Form Add Misi validation
        $("#deskripsi_misi_add").on("input", function() {
            if ($(this).val().trim() !== "") {
                clearError($("#deskripsi_misi_add"), $("#error_misi_add"));
            }
        });

        $("#formAddMisi").on("submit", function(e) {
            let misiVal = $("#deskripsi_misi_add").val().trim();
            if (misiVal === "") {
                e.preventDefault();
                showError($("#deskripsi_misi_add"), $("#error_misi_add"), "Deskripsi misi wajib diisi!");
                $("#deskripsi_misi_add").focus();
                return false;
            }

            $("#btnSubmitAddMisi").prop("disabled", true).addClass("opacity-75 cursor-not-allowed");
            $("#btnSubmitAddMisi").html(`
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Menyimpan...</span>
            `);
        });

        // Form Edit Misi validation
        $(".formEditMisi").on("submit", function(e) {
            let $input = $(this).find(".deskripsi_misi_input");
            let $err = $(this).find(".error_misi_edit");
            let val = $input.val().trim();

            if (val === "") {
                e.preventDefault();
                showError($input, $err, "Deskripsi misi wajib diisi!");
                $input.focus();
                return false;
            }

            let $btn = $(this).find(".btnSubmitEditMisi");
            $btn.prop("disabled", true).addClass("opacity-75 cursor-not-allowed");
            $btn.html(`
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Memperbarui...</span>
            `);
        });

        // Delete confirmation
        $(".delete-confirm").click(function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            Swal.fire({
                title: 'Hapus Butir Misi?',
                text: "Butir misi yang dihapus tidak dapat dipulihkan kembali!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush

<form action="{{ route('perlombaan.store') }}" id="formcreatePerlombaan" method="POST" enctype="multipart/form-data" class="space-y-4">
    @csrf

    <!-- Jenis Perlombaan -->
    <div>
        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
            Jenis Perlombaan <span class="text-rose-500">*</span>
        </label>
        <div class="relative">
            <i class="ti ti-trophy absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-lg pointer-events-none"></i>
            <input type="text" name="jenis_perlombaan" id="jenis_perlombaan" 
                   placeholder="Contoh: MHQ 5 Juz, Pidato Bahasa Arab..." 
                   class="w-full pl-11 pr-4 py-2.5 text-sm bg-white border border-slate-300 rounded-xl text-slate-800 font-medium placeholder-slate-400 focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
        </div>
    </div>

    <!-- Jenjang Pendidikan -->
    <div>
        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
            Jenjang Pendidikan <span class="text-rose-500">*</span>
        </label>
        <div class="relative">
            <i class="ti ti-school absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-lg pointer-events-none"></i>
            <select name="id_jenjang" id="id_jenjang" 
                    class="w-full pl-11 pr-4 py-2.5 text-sm bg-white border border-slate-300 rounded-xl text-slate-800 font-medium focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition appearance-none">
                <option value="">-- Pilih Jenjang Pendidikan --</option>
                @foreach ($jenjangPendidikan as $d)
                    <option value="{{ $d->id }}">{{ $d->jenjang_pendidikan }}</option>
                @endforeach
            </select>
            <i class="ti ti-chevron-down absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
        </div>
    </div>

    <!-- Grid 2 Col: Biaya & Contact Person -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <!-- Biaya Pendaftaran -->
        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                Biaya Pendaftaran (Rp) <span class="text-rose-500">*</span>
            </label>
            <div class="relative">
                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 font-bold text-xs pointer-events-none">Rp</span>
                <input type="number" name="biaya_pendaftaran" id="biaya_pendaftaran" min="0" placeholder="0" 
                       class="w-full pl-10 pr-4 py-2.5 text-sm text-right bg-white border border-slate-300 rounded-xl text-slate-800 font-semibold focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
            </div>
            <p class="text-[11px] text-slate-400 mt-1">Isi 0 jika gratis / tanpa biaya</p>
        </div>

        <!-- Contact Person -->
        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                Contact Person (WhatsApp) <span class="text-rose-500">*</span>
            </label>
            <div class="relative">
                <i class="ti ti-brand-whatsapp absolute left-3.5 top-1/2 -translate-y-1/2 text-emerald-600 text-lg pointer-events-none"></i>
                <input type="text" name="contact_person" id="contact_person" 
                       placeholder="Contoh: 08123456789 (Ustadz Fauzan)" 
                       class="w-full pl-11 pr-4 py-2.5 text-sm bg-white border border-slate-300 rounded-xl text-slate-800 font-medium placeholder-slate-400 focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
            </div>
        </div>
    </div>

    <!-- Upload Files Section (Juknis & Thumbnail) -->
    <div class="p-4 bg-slate-50/80 border border-slate-200/80 rounded-2xl space-y-4">
        <!-- File Juknis & Juklak -->
        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                Dokumen Juknis & Juklak
            </label>
            <div class="relative">
                <input type="file" name="juknis_juklak" id="juknis_juklak" accept=".pdf,.doc,.docx"
                       class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3.5 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 border border-slate-200 rounded-xl bg-white transition cursor-pointer">
            </div>
            <p class="text-[11px] text-slate-400 mt-1 flex items-center gap-1">
                <i class="ti ti-info-circle text-xs"></i>
                <span>Format: PDF, DOC, DOCX (Maks: 10MB)</span>
            </p>
        </div>

        <!-- File Thumbnail -->
        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                Poster / Banner Thumbnail
            </label>
            <div class="relative">
                <input type="file" name="thumbnail" id="thumbnail" accept="image/*"
                       class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3.5 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 border border-slate-200 rounded-xl bg-white transition cursor-pointer">
            </div>
            <p class="text-[11px] text-slate-400 mt-1 flex items-center gap-1">
                <i class="ti ti-info-circle text-xs"></i>
                <span>Format: JPEG, PNG, WEBP (Maks: 2MB)</span>
            </p>
            <div id="thumbnail-preview" class="mt-2.5 hidden">
                <div class="inline-block p-1.5 bg-white border border-slate-200 rounded-xl shadow-xs">
                    <img id="img-preview" src="" alt="Preview" class="h-28 w-auto rounded-lg object-cover">
                </div>
            </div>
        </div>
    </div>

    <!-- Submit Button -->
    <div class="pt-2">
        <button class="w-full py-3 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl shadow-xs transition-all duration-200 active:scale-98 flex items-center justify-center gap-2 cursor-pointer" type="submit">
            <i class="ti ti-device-floppy text-lg"></i>
            <span>Simpan Data Perlombaan</span>
        </button>
    </div>
</form>

<script>
    $(function() {
        $("#formcreatePerlombaan").submit(function(e) {
            var jenis_perlombaan = $("#jenis_perlombaan").val().trim();
            var id_jenjang = $("#id_jenjang").val();
            var biaya_pendaftaran = $("#biaya_pendaftaran").val();
            var contact_person = $("#contact_person").val().trim();

            if (jenis_perlombaan == "") {
                Swal.fire({
                    title: 'Perhatian!',
                    text: 'Jenis Perlombaan wajib diisi!',
                    icon: 'warning',
                    confirmButtonColor: '#059669',
                    confirmButtonText: 'Mengerti'
                }).then(() => {
                    $("#jenis_perlombaan").focus();
                });
                return false;
            }

            if (id_jenjang == "") {
                Swal.fire({
                    title: 'Perhatian!',
                    text: 'Jenjang Pendidikan harus dipilih!',
                    icon: 'warning',
                    confirmButtonColor: '#059669',
                    confirmButtonText: 'Mengerti'
                }).then(() => {
                    $("#id_jenjang").focus();
                });
                return false;
            }

            if (biaya_pendaftaran === "") {
                Swal.fire({
                    title: 'Perhatian!',
                    text: 'Biaya Pendaftaran wajib diisi (isi 0 jika gratis)!',
                    icon: 'warning',
                    confirmButtonColor: '#059669',
                    confirmButtonText: 'Mengerti'
                }).then(() => {
                    $("#biaya_pendaftaran").focus();
                });
                return false;
            }

            if (contact_person == "") {
                Swal.fire({
                    title: 'Perhatian!',
                    text: 'Contact Person WhatsApp wajib diisi!',
                    icon: 'warning',
                    confirmButtonColor: '#059669',
                    confirmButtonText: 'Mengerti'
                }).then(() => {
                    $("#contact_person").focus();
                });
                return false;
            }
        });

        // Preview thumbnail
        $("#thumbnail").change(function(e) {
            var file = e.target.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $("#img-preview").attr('src', e.target.result);
                    $("#thumbnail-preview").removeClass('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                $("#thumbnail-preview").addClass('hidden');
                $("#img-preview").attr('src', '');
            }
        });
    });
</script>

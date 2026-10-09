<form action="{{ route('biaya.store') }}" method="POST" id="formduplicateBiaya" novalidate class="space-y-4">
    @csrf

    <!-- Callout Info -->
    <div class="flex items-start gap-3 p-3.5 bg-indigo-50/80 border border-indigo-200/80 rounded-xl text-indigo-900">
        <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center shrink-0 text-base font-bold">
            <i class="ti ti-copy"></i>
        </div>
        <div class="text-xs">
            <p class="font-bold text-indigo-950">Duplikat Paket Biaya</p>
            <p class="text-indigo-700/90 mt-0.5 leading-relaxed">
                Menyalin konfigurasi dari paket <strong>{{ $biaya->kode_biaya }}</strong>. Silakan tentukan Tahun Ajaran PPDB baru atau sesuaikan tarif komponen sebelum menyimpan.
            </p>
        </div>
    </div>

    <!-- Baris 1: Jenjang & Tingkat -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
        <!-- Jenjang / Unit -->
        <div class="space-y-1.5" id="group_kode_unit_dup">
            <label for="kode_unit_dup_item" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-building text-slate-400"></i>
                <span>Jenjang / Unit <span class="text-rose-500">*</span></span>
            </label>
            <div class="relative">
                <select name="kode_unit" 
                        id="kode_unit_dup_item" 
                        class="w-full py-2.5 px-3.5 text-xs font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 outline-none transition cursor-pointer">
                    <option value="">-- Pilih Jenjang / Unit --</option>
                    @foreach ($unit as $u)
                        <option value="{{ $u->kode_unit }}" {{ $biaya->kode_unit == $u->kode_unit ? 'selected' : '' }}>
                            {{ strtoupper($u->nama_unit) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <p class="text-[11px] font-semibold text-rose-500 hidden mt-1 flex items-center gap-1" id="error_kode_unit_dup"></p>
        </div>

        <!-- Tingkat Kelas -->
        <div class="space-y-1.5" id="group_tingkat_dup">
            <label for="tingkat_dup_item" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-stairs text-slate-400"></i>
                <span>Tingkat Kelas <span class="text-rose-500">*</span></span>
            </label>
            <div class="relative">
                <select name="tingkat" 
                        id="tingkat_dup_item" 
                        class="w-full py-2.5 px-3.5 text-xs font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 outline-none transition cursor-pointer">
                    <option value="">-- Memuat Tingkat --</option>
                </select>
            </div>
            <p class="text-[11px] font-semibold text-rose-500 hidden mt-1 flex items-center gap-1" id="error_tingkat_dup"></p>
        </div>
    </div>

    <!-- Baris 2: Asrama & Tahun Ajaran -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
        <!-- Asrama / Non-Asrama -->
        <div class="space-y-1.5" id="group_asrama_dup">
            <label for="asrama_dup_item" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-home text-slate-400"></i>
                <span>Tipe Hunian <span class="text-rose-500">*</span></span>
            </label>
            <div class="relative">
                <select name="asrama" 
                        id="asrama_dup_item" 
                        class="w-full py-2.5 px-3.5 text-xs font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 outline-none transition cursor-pointer">
                    <option value="">-- Pilih Status Asrama --</option>
                    <option value="1" {{ $biaya->asrama == '1' ? 'selected' : '' }}>Asrama (Mukim)</option>
                    <option value="0" {{ $biaya->asrama == '0' ? 'selected' : '' }}>Non Asrama (Non-Mukim)</option>
                </select>
            </div>
            <p class="text-[11px] font-semibold text-rose-500 hidden mt-1 flex items-center gap-1" id="error_asrama_dup"></p>
        </div>

        <!-- Tahun Ajaran Tujuan -->
        <div class="space-y-1.5" id="group_kode_ta_dup">
            <label for="kode_ta_dup_item" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-calendar text-slate-400"></i>
                <span>Tahun Ajaran PPDB Baru <span class="text-rose-500">*</span></span>
            </label>
            <div class="relative">
                <select name="kode_ta" 
                        id="kode_ta_dup_item" 
                        class="w-full py-2.5 px-3.5 text-xs font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 outline-none transition cursor-pointer">
                    <option value="">-- Pilih Tahun Ajaran Baru --</option>
                    @foreach ($tahunajaran as $d)
                        <option value="{{ $d->kode_ta }}" {{ $d->status == '1' ? 'selected' : '' }}>
                            {{ $d->tahun_ajaran }} {{ $d->status == '1' ? '(Aktif)' : '' }}
                        </option>
                    @endforeach
                </select>
            </div>
            <p class="text-[11px] font-semibold text-rose-500 hidden mt-1 flex items-center gap-1" id="error_kode_ta_dup"></p>
        </div>
    </div>

    <!-- Checkbox Pindahan -->
    <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl flex items-center gap-3">
        <input type="checkbox" name="is_pindahan" value="1" id="is_pindahan_dup" {{ $biaya->is_pindahan == 1 ? 'checked' : '' }} class="w-4 h-4 text-indigo-600 rounded border-slate-300 focus:ring-indigo-500 cursor-pointer">
        <label for="is_pindahan_dup" class="text-xs font-bold text-slate-700 select-none cursor-pointer">
            Paket Biaya Khusus Santri Pindahan (Transfer)
        </label>
    </div>

    <!-- Divider Section: Detail Biaya -->
    <div class="pt-2">
        <div class="flex items-center gap-3 mb-3">
            <div class="h-px bg-slate-200 flex-1"></div>
            <span class="text-xs font-extrabold uppercase text-slate-400 tracking-wider flex items-center gap-1.5">
                <i class="ti ti-list-check text-indigo-600"></i>
                Rincian Komponen Biaya (Bisa Diedit / Ditambah)
            </span>
            <div class="h-px bg-slate-200 flex-1"></div>
        </div>

        <!-- Toolbar Tambah Komponen -->
        <div class="p-3.5 bg-slate-50 border border-slate-200/90 rounded-2xl space-y-3">
            <div class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-end">
                <!-- Jenis Biaya -->
                <div class="sm:col-span-6 space-y-1.5">
                    <label for="kode_jenis_biaya_dup" class="text-xs font-bold text-slate-700">Jenis Biaya</label>
                    <select id="kode_jenis_biaya_dup" class="w-full py-2.5 px-3 text-xs font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 outline-none transition cursor-pointer">
                        <option value="">-- Pilih Jenis Biaya --</option>
                        @foreach ($jenisbiaya as $jb)
                            <option value="{{ $jb->kode_jenis_biaya }}">{{ strtoupper($jb->jenis_biaya) }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Nominal Biaya -->
                <div class="sm:col-span-4 space-y-1.5">
                    <label for="jumlah_dup" class="text-xs font-bold text-slate-700">Jumlah Biaya (Rp)</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-xs font-bold text-slate-400">Rp</span>
                        <input type="text" 
                               id="jumlah_dup" 
                               placeholder="0" 
                               autocomplete="off"
                               class="w-full pl-9 pr-3.5 py-2.5 text-xs font-mono font-bold text-right text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 outline-none transition">
                    </div>
                </div>

                <!-- Tombol Tambah -->
                <div class="sm:col-span-2">
                    <button type="button" id="tambahbiaya_dup" class="w-full py-2.5 px-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center justify-center gap-1.5 cursor-pointer active:scale-95">
                        <i class="ti ti-plus text-sm"></i>
                        <span>Tambah</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Komponen Biaya -->
    <div class="border border-slate-200 rounded-2xl overflow-hidden shadow-2xs bg-white">
        <table class="w-full text-left border-collapse" id="tabledetail_dup">
            <thead>
                <tr class="bg-slate-100 text-slate-700 text-[11px] font-extrabold uppercase border-b border-slate-200">
                    <th class="py-2.5 px-3 w-28 text-center">KODE</th>
                    <th class="py-2.5 px-4">JENIS BIAYA</th>
                    <th class="py-2.5 px-4 text-right w-44">JUMLAH (RP)</th>
                    <th class="py-2.5 px-3 text-center w-16">AKSI</th>
                </tr>
            </thead>
            <tbody id="loaddetail_dup" class="divide-y divide-slate-100 text-xs text-slate-700">
                @foreach ($detail as $d)
                    <tr id="index_{{ $d->kode_jenis_biaya }}" class="hover:bg-slate-50 transition">
                        <td class="py-2.5 px-3 text-center">
                            <input type="hidden" name="kode_jenis_biaya[]" value="{{ $d->kode_jenis_biaya }}" />
                            <span class="inline-flex items-center px-2 py-0.5 rounded-lg bg-slate-100 text-slate-700 font-mono text-[11px] font-bold border border-slate-200">
                                {{ $d->kode_jenis_biaya }}
                            </span>
                        </td>
                        <td class="py-2.5 px-4 font-bold text-slate-800">{{ $d->jenis_biaya }}</td>
                        <td class="py-2.5 px-4 text-right font-mono font-bold text-slate-800">
                            <input type="hidden" name="jml[]" value="{{ formatRupiah($d->jumlah) }}" />
                            Rp {{ formatRupiah($d->jumlah) }}
                        </td>
                        <td class="py-2.5 px-3 text-center">
                            <button type="button" kode_jenis_biaya="{{ $d->kode_jenis_biaya }}" class="w-7 h-7 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 inline-flex items-center justify-center transition border border-rose-200/60 delete cursor-pointer" title="Hapus">
                                <i class="ti ti-trash text-sm"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="bg-slate-900 text-white font-extrabold text-xs">
                    <td colspan="2" class="py-3 px-4 text-left uppercase tracking-wider">Total Biaya Pendidikan</td>
                    <td class="py-3 px-4 text-right font-mono text-sm text-indigo-300" id="totalbiaya_dup">Rp 0</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Checkbox Agreement & Submit Actions -->
    <div class="pt-3 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="flex items-center gap-2.5">
            <input type="checkbox" name="aggrement" value="aggrement" id="checkAgreementDup" class="agreement w-4 h-4 text-indigo-600 rounded border-slate-300 focus:ring-indigo-500 cursor-pointer">
            <label for="checkAgreementDup" class="text-xs font-bold text-slate-700 select-none cursor-pointer">
                Konfirmasi rincian biaya telah sesuai & siap disimpan
            </label>
        </div>

        <div class="flex items-center justify-end gap-2.5">
            <button type="button" data-bs-dismiss="modal" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs transition cursor-pointer">
                Batal
            </button>
            <button type="submit" id="btnSimpanDup" class="inline-flex items-center gap-2 px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-xs shadow-xs transition-all duration-200 cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed">
                <i class="ti ti-device-floppy text-base"></i>
                <span>Simpan Paket Hasil Duplikat</span>
            </button>
        </div>
    </div>
</form>

<script>
    $(function() {
        const form = $("#formduplicateBiaya");

        form.find("#jumlah_dup").maskMoney({thousands:'.', decimal:',', precision:0});

        function loadTingkat(kode_unit, selectedTingkat = '') {
            if(!kode_unit) {
                form.find("#tingkat_dup_item").html('<option value="">-- Pilih Unit Terlebih Dahulu --</option>');
                return;
            }
            $.ajax({
                type: "POST",
                url: "{{ route('unit.gettingkatbyunit') }}",
                cache: false,
                data: {
                    _token: "{{ csrf_token() }}",
                    kode_unit: kode_unit,
                    selected: selectedTingkat
                },
                success: function(respond) {
                    form.find("#tingkat_dup_item").html(respond);
                }
            });
        }

        // Initial load tingkat
        loadTingkat("{{ $biaya->kode_unit }}", "{{ $biaya->tingkat }}");

        form.find("#kode_unit_dup_item").change(function() {
            const kode_unit = $(this).val();
            loadTingkat(kode_unit);
        });

        function addBiaya() {
            const biaya = form.find("#kode_jenis_biaya_dup :selected");
            const kode_jenis_biaya = $(biaya).val();
            const jenis_biaya = $(biaya).text();
            const jumlah = form.find("#jumlah_dup").val();

            let listbiaya = `
                <tr id="index_${kode_jenis_biaya}" class="hover:bg-slate-50 transition">
                    <td class="py-2.5 px-3 text-center">
                        <input type="hidden" name="kode_jenis_biaya[]" value="${kode_jenis_biaya}" />
                        <span class="inline-flex items-center px-2 py-0.5 rounded-lg bg-slate-100 text-slate-700 font-mono text-[11px] font-bold border border-slate-200">
                            ${kode_jenis_biaya}
                        </span>
                    </td>
                    <td class="py-2.5 px-4 font-bold text-slate-800">${jenis_biaya}</td>
                    <td class="py-2.5 px-4 text-right font-mono font-bold text-slate-800">
                        <input type="hidden" name="jml[]" value="${jumlah}" />
                        Rp ${jumlah}
                    </td>
                    <td class="py-2.5 px-3 text-center">
                        <button type="button" kode_jenis_biaya="${kode_jenis_biaya}" class="w-7 h-7 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 inline-flex items-center justify-center transition border border-rose-200/60 delete cursor-pointer" title="Hapus">
                            <i class="ti ti-trash text-sm"></i>
                        </button>
                    </td>
                </tr>
            `;

            $("#loaddetail_dup").prepend(listbiaya);
            form.find("#kode_jenis_biaya_dup").val("");
            form.find("#jumlah_dup").val("");
            getTotalBiaya();
        }

        function getTotalBiaya() {
            let totalbiaya = 0;
            $("#loaddetail_dup tr").each(function() {
                let jumlah = $(this).find("input[name='jml[]']").val();
                if(jumlah) {
                    jumlah = jumlah.toString().replace(/\./g, '');
                    totalbiaya += parseInt(jumlah) || 0;
                }
            });
            $("#totalbiaya_dup").text('Rp ' + totalbiaya.toLocaleString('id-ID'));
        }

        // Calculate initial total
        getTotalBiaya();

        $("#tambahbiaya_dup").click(function(e) {
            e.preventDefault();
            const kode_jenis_biaya = form.find("#kode_jenis_biaya_dup").val();
            const jumlah = form.find("#jumlah_dup").val();
            const cekdetail = form.find('#tabledetail_dup').find('#index_' + kode_jenis_biaya).length;
            if (kode_jenis_biaya == "") {
                Swal.fire({
                    title: "Pilih Komponen!",
                    text: "Silahkan pilih jenis biaya terlebih dahulu.",
                    icon: "warning",
                    confirmButtonColor: "#4f46e5"
                });
            } else if (jumlah == "" || jumlah === "0") {
                Swal.fire({
                    title: "Jumlah Nominal Kosong!",
                    text: "Nominal biaya tidak boleh 0 atau kosong.",
                    icon: "warning",
                    confirmButtonColor: "#4f46e5"
                });
            } else if (cekdetail > 0) {
                Swal.fire({
                    title: "Komponen Sudah Ada!",
                    text: "Jenis biaya ini sudah ditambahkan ke dalam rincian.",
                    icon: "warning",
                    confirmButtonColor: "#4f46e5"
                });
            } else {
                addBiaya();
            }
        });

        form.on('click', '.delete', function(e) {
            e.preventDefault();
            var kode_jenis_biaya = $(this).attr("kode_jenis_biaya");
            $(`#index_${kode_jenis_biaya}`).remove();
            getTotalBiaya();
        });

        form.find("#btnSimpanDup").prop("disabled", true);
        form.find('.agreement').change(function() {
            form.find("#btnSimpanDup").prop("disabled", !this.checked);
        });

        form.submit(function(e) {
            const kode_unit = form.find("#kode_unit_dup_item").val();
            const tingkat = form.find("#tingkat_dup_item").val();
            const asrama = form.find("#asrama_dup_item").val();
            const kode_ta = form.find("#kode_ta_dup_item").val();
            const detail = form.find('#loaddetail_dup tr').length;

            if (!kode_unit) {
                Swal.fire({ title: "Oops!", text: "Jenjang / Unit wajib dipilih!", icon: "warning", confirmButtonColor: "#4f46e5" });
                return false;
            } else if (!tingkat) {
                Swal.fire({ title: "Oops!", text: "Tingkat kelas wajib dipilih!", icon: "warning", confirmButtonColor: "#4f46e5" });
                return false;
            } else if (asrama === "") {
                Swal.fire({ title: "Oops!", text: "Tipe hunian (Asrama) wajib dipilih!", icon: "warning", confirmButtonColor: "#4f46e5" });
                return false;
            } else if (!kode_ta) {
                Swal.fire({ title: "Oops!", text: "Tahun ajaran baru wajib dipilih!", icon: "warning", confirmButtonColor: "#4f46e5" });
                return false;
            } else if (detail === 0) {
                Swal.fire({ title: "Detail Masih Kosong!", text: "Silahkan tambahkan minimal 1 komponen jenis biaya!", icon: "warning", confirmButtonColor: "#4f46e5" });
                return false;
            }

            $("#btnSimpanDup").prop("disabled", true).html(`
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Menyimpan Paket...</span>
            `);
        });
    });
</script>

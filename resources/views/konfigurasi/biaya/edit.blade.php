<form action="{{ route('biaya.update', Crypt::encrypt($biaya->kode_biaya)) }}" method="POST" id="formeditBiaya" novalidate class="space-y-4">
    @csrf
    @method('PUT')

    <!-- Header Overview Card -->
    <div class="p-4 bg-slate-50 border border-slate-200/90 rounded-2xl">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0 border border-emerald-100 font-bold">
                    <i class="ti ti-building text-xl"></i>
                </div>
                <div>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Jenjang / Unit</span>
                    <span class="text-xs font-black text-slate-800">{{ $biaya->nama_unit }}</span>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-sky-50 text-sky-700 flex items-center justify-center shrink-0 border border-sky-100 font-bold">
                    <i class="ti ti-stairs text-xl"></i>
                </div>
                <div>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Tingkat Kelas</span>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-bold bg-sky-100 text-sky-800 mt-0.5">
                        Kelas {{ $biaya->tingkat }}
                    </span>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center shrink-0 border border-slate-200 font-bold">
                    <i class="ti ti-calendar text-xl"></i>
                </div>
                <div>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Tahun Ajaran</span>
                    <span class="text-xs font-mono font-bold text-slate-800">{{ $biaya->tahun_ajaran }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Checkbox Pindahan -->
    <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl flex items-center gap-3">
        <input type="checkbox" name="is_pindahan" value="1" id="is_pindahan" class="w-4 h-4 text-emerald-600 rounded border-slate-300 focus:ring-emerald-500 cursor-pointer" {{ $biaya->is_pindahan ? 'checked' : '' }}>
        <label for="is_pindahan" class="text-xs font-bold text-slate-700 select-none cursor-pointer">
            Paket Biaya Khusus Santri Pindahan (Transfer)
        </label>
    </div>

    <!-- Divider Section: Detail Biaya -->
    <div class="pt-2">
        <div class="flex items-center gap-3 mb-3">
            <div class="h-px bg-slate-200 flex-1"></div>
            <span class="text-xs font-extrabold uppercase text-slate-400 tracking-wider flex items-center gap-1.5">
                <i class="ti ti-list-check text-emerald-600"></i>
                Edit Rincian Komponen Biaya
            </span>
            <div class="h-px bg-slate-200 flex-1"></div>
        </div>

        <!-- Toolbar Tambah Komponen Baru -->
        <div class="p-3.5 bg-slate-50 border border-slate-200/90 rounded-2xl space-y-3">
            <div class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-end">
                <!-- Jenis Biaya -->
                <div class="sm:col-span-6 space-y-1.5">
                    <label for="kode_jenis_biaya" class="text-xs font-bold text-slate-700">Tambah Jenis Biaya</label>
                    <select id="kode_jenis_biaya" class="w-full py-2.5 px-3 text-xs font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition cursor-pointer">
                        <option value="">-- Pilih Jenis Biaya --</option>
                        @foreach ($jenisbiaya as $jb)
                            <option value="{{ $jb->kode_jenis_biaya }}">{{ strtoupper($jb->jenis_biaya) }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Nominal Biaya -->
                <div class="sm:col-span-4 space-y-1.5">
                    <label for="jumlah" class="text-xs font-bold text-slate-700">Jumlah Biaya (Rp)</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-xs font-bold text-slate-400">Rp</span>
                        <input type="text" 
                               id="jumlah" 
                               placeholder="0" 
                               autocomplete="off"
                               class="w-full pl-9 pr-3.5 py-2.5 text-xs font-mono font-bold text-right text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition">
                    </div>
                </div>

                <!-- Tombol Tambah -->
                <div class="sm:col-span-2">
                    <button type="button" id="tambahbiaya" class="w-full py-2.5 px-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center justify-center gap-1.5 cursor-pointer active:scale-95">
                        <i class="ti ti-plus text-sm"></i>
                        <span>Tambah</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Komponen Biaya -->
    <div class="border border-slate-200 rounded-2xl overflow-hidden shadow-2xs bg-white">
        <table class="w-full text-left border-collapse" id="tabledetail">
            <thead>
                <tr class="bg-slate-100 text-slate-700 text-[11px] font-extrabold uppercase border-b border-slate-200">
                    <th class="py-2.5 px-3 w-28 text-center">KODE</th>
                    <th class="py-2.5 px-4">JENIS BIAYA</th>
                    <th class="py-2.5 px-4 text-right w-44">JUMLAH (RP)</th>
                    <th class="py-2.5 px-3 text-center w-16">AKSI</th>
                </tr>
            </thead>
            <tbody id="loaddetail" class="divide-y divide-slate-100 text-xs text-slate-700">
                @foreach ($detail as $d)
                    <tr id="index_{{ $d->kode_jenis_biaya }}" class="hover:bg-slate-50 transition">
                        <td class="py-2.5 px-3 text-center">
                            <input type="hidden" name="kode_jenis_biaya[]" value="{{ $d->kode_jenis_biaya }}">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-lg bg-slate-100 text-slate-700 font-mono text-[11px] font-bold border border-slate-200">
                                {{ $d->kode_jenis_biaya }}
                            </span>
                        </td>
                        <td class="py-2.5 px-4 font-bold text-slate-800">{{ strtoupper($d->jenis_biaya) }}</td>
                        <td class="py-2.5 px-4 text-right">
                            <input type="text" name="jml[]" class="money w-full py-1.5 px-2.5 text-xs font-mono font-bold text-right text-slate-800 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition" value="{{ formatAngka($d->jumlah) }}">
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
                    <td class="py-3 px-4 text-right font-mono text-sm text-emerald-400" id="totalbiaya">Rp 0</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Checkbox Agreement & Submit Actions -->
    <div class="pt-3 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="flex items-center gap-2.5">
            <input type="checkbox" name="aggrement" value="aggrement" id="defaultCheck3" class="agreement w-4 h-4 text-emerald-600 rounded border-slate-300 focus:ring-emerald-500 cursor-pointer">
            <label for="defaultCheck3" class="text-xs font-bold text-slate-700 select-none cursor-pointer">
                Konfirmasi perubahan rincian biaya telah sesuai & siap disimpan
            </label>
        </div>

        <div class="flex items-center justify-end gap-2.5">
            <button type="button" data-bs-dismiss="modal" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs transition cursor-pointer">
                Batal
            </button>
            <button type="submit" id="btnSimpan" class="inline-flex items-center gap-2 px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs transition-all duration-200 cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed">
                <i class="ti ti-device-floppy text-base"></i>
                <span>Simpan Perubahan</span>
            </button>
        </div>
    </div>
</form>

<script>
    $(function() {
        const form = $("#formeditBiaya");

        form.find("#jumlah").maskMoney({thousands:'.', decimal:',', precision:0});
        form.find(".money").maskMoney({thousands:'.', decimal:',', precision:0});

        function addBiaya() {
            const biaya = form.find("#kode_jenis_biaya :selected");
            const kode_jenis_biaya = $(biaya).val();
            const jenis_biaya = $(biaya).text();
            const jumlah = form.find("#jumlah").val();

            let listbiaya = `
                <tr id="index_${kode_jenis_biaya}" class="hover:bg-slate-50 transition">
                    <td class="py-2.5 px-3 text-center">
                        <input type="hidden" name="kode_jenis_biaya[]" value="${kode_jenis_biaya}" />
                        <span class="inline-flex items-center px-2 py-0.5 rounded-lg bg-slate-100 text-slate-700 font-mono text-[11px] font-bold border border-slate-200">
                            ${kode_jenis_biaya}
                        </span>
                    </td>
                    <td class="py-2.5 px-4 font-bold text-slate-800">${jenis_biaya}</td>
                    <td class="py-2.5 px-4 text-right">
                        <input type="text" name="jml[]" class="money w-full py-1.5 px-2.5 text-xs font-mono font-bold text-right text-slate-800 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition" value="${jumlah}">
                    </td>
                    <td class="py-2.5 px-3 text-center">
                        <button type="button" kode_jenis_biaya="${kode_jenis_biaya}" class="w-7 h-7 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 inline-flex items-center justify-center transition border border-rose-200/60 delete cursor-pointer" title="Hapus">
                            <i class="ti ti-trash text-sm"></i>
                        </button>
                    </td>
                </tr>
            `;

            $("#loaddetail").prepend(listbiaya);
            $("#loaddetail").find(".money").maskMoney({thousands:'.', decimal:',', precision:0});
            form.find("#kode_jenis_biaya").val("");
            form.find("#jumlah").val("");
            getTotalBiaya();
        }

        function getTotalBiaya() {
            let totalbiaya = 0;
            $("#loaddetail tr").each(function() {
                let jumlah = $(this).find("input[name='jml[]']").val();
                if(jumlah) {
                    jumlah = jumlah.replace(/\./g, '');
                    totalbiaya += parseInt(jumlah) || 0;
                }
            });
            $("#totalbiaya").text('Rp ' + totalbiaya.toLocaleString('id-ID'));
        }

        getTotalBiaya();

        $(document).on("keyup", "#loaddetail input[name='jml[]']", function() {
            getTotalBiaya();
        });

        $("#tambahbiaya").click(function(e) {
            e.preventDefault();
            const kode_jenis_biaya = form.find("#kode_jenis_biaya").val();
            const jumlah = form.find("#jumlah").val();
            const cekdetail = form.find('#tabledetail').find('#index_' + kode_jenis_biaya).length;
            if (kode_jenis_biaya == "") {
                Swal.fire({
                    title: "Pilih Komponen!",
                    text: "Silahkan pilih jenis biaya terlebih dahulu.",
                    icon: "warning",
                    confirmButtonColor: "#059669"
                });
            } else if (jumlah == "" || jumlah === "0") {
                Swal.fire({
                    title: "Jumlah Nominal Kosong!",
                    text: "Nominal biaya tidak boleh 0 atau kosong.",
                    icon: "warning",
                    confirmButtonColor: "#059669"
                });
            } else if (cekdetail > 0) {
                Swal.fire({
                    title: "Komponen Sudah Ada!",
                    text: "Jenis biaya ini sudah ditambahkan ke dalam rincian.",
                    icon: "warning",
                    confirmButtonColor: "#059669"
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

        form.find("#btnSimpan").prop("disabled", true);
        form.find('.agreement').change(function() {
            form.find("#btnSimpan").prop("disabled", !this.checked);
        });

        form.submit(function(e) {
            const detail = form.find('#loaddetail tr').length;
            if (detail === 0) {
                Swal.fire({ title: "Detail Masih Kosong!", text: "Silahkan tambahkan minimal 1 komponen jenis biaya!", icon: "warning", confirmButtonColor: "#059669" });
                return false;
            }

            $("#btnSimpan").prop("disabled", true).html(`
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Menyimpan...</span>
            `);
        });
    });
</script>

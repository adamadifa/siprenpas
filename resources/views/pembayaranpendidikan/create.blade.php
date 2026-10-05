<form action="#" id="formDetailbayar" method="POST" class="space-y-4">
    @csrf
    <input type="hidden" name="no_pendaftaran" id="no_pendaftaran" value="{{ Crypt::encrypt($no_pendaftaran) }}">

    <!-- ================= 1. TRANSACTION META HEADER ================= -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <!-- No Bukti -->
        <div class="space-y-1">
            <label for="no_bukti" class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider flex items-center gap-1.5">
                <i class="ti ti-barcode text-emerald-600 text-sm"></i>
                <span>Nomor Bukti Transaksi</span>
            </label>
            <div class="relative group">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <i class="ti ti-hash text-base"></i>
                </div>
                <input type="text" 
                       id="no_bukti" 
                       name="no_bukti" 
                       value="Auto Generate (Otomatis)" 
                       disabled 
                       class="w-full pl-9 pr-3.5 py-2 text-xs font-mono font-bold text-slate-500 bg-slate-100/90 border border-slate-200/80 rounded-xl shadow-2xs cursor-not-allowed select-none">
            </div>
        </div>

        <!-- Tanggal Pembayaran -->
        <div class="space-y-1">
            <label for="tanggal" class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider flex items-center gap-1.5">
                <i class="ti ti-calendar text-emerald-600 text-sm"></i>
                <span>Tanggal Pembayaran <span class="text-rose-500">*</span></span>
            </label>
            <div class="relative group">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-emerald-600 group-focus-within:text-emerald-700 transition">
                    <i class="ti ti-calendar-event text-base"></i>
                </div>
                <input type="text" 
                       id="tanggal" 
                       name="tanggal" 
                       value="{{ date('Y-m-d') }}" 
                       required 
                       placeholder="Pilih Tanggal..." 
                       class="flatpickr-date w-full pl-9 pr-3.5 py-2 text-xs font-bold text-slate-800 bg-white border border-slate-300/90 rounded-xl placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
            </div>
        </div>
    </div>

    <!-- ================= 2. ITEM BUILDER CARD ================= -->
    <div class="bg-gradient-to-br from-emerald-50/40 via-white to-slate-50/60 border border-emerald-200/70 rounded-2xl p-4 space-y-3.5 shadow-2xs">
        <!-- Section Title Badge -->
        <div class="flex items-center justify-between pb-2.5 border-b border-emerald-100/80">
            <div class="flex items-center gap-2">
                <div class="w-6.5 h-6.5 rounded-lg bg-emerald-600 text-white flex items-center justify-center text-xs font-bold shadow-2xs">
                    <i class="ti ti-plus"></i>
                </div>
                <div>
                    <h6 class="text-xs font-extrabold text-slate-900 tracking-tight m-0">Tambah Item Pembayaran</h6>
                    <p class="text-[10px] text-slate-500 font-medium leading-none mt-0.5">Pilih pos biaya dan tentukan jumlah yang dibayarkan</p>
                </div>
            </div>
            <span class="hidden sm:inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-bold bg-emerald-100/70 text-emerald-800 border border-emerald-200/60">
                <i class="ti ti-info-circle text-xs"></i> Multi-item
            </span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <!-- Pilih Jenis Biaya -->
            <div class="sm:col-span-6 space-y-1">
                <label for="kode_biaya" class="block text-[11px] font-bold text-slate-700 flex items-center gap-1.5">
                    <i class="ti ti-receipt-2 text-slate-400 text-sm"></i>
                    <span>Pos / Jenis Biaya <span class="text-rose-500 font-bold">*</span></span>
                </label>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-emerald-600">
                        <i class="ti ti-layers-subtract text-base"></i>
                    </div>
                    <select name="kode_biaya" id="kode_biaya" 
                            class="w-full pl-9 pr-8 py-2 text-xs font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition cursor-pointer">
                        <option value="">-- Pilih Pos Biaya --</option>
                        @foreach ($biaya as $d)
                            <option value="{{ $d->kode_jenis_biaya . '|' . $d->kode_biaya }}">
                                {{ $d->jenis_biaya }} {{ in_array($d->kode_jenis_biaya, ['B01', 'B07']) ? '(' . $d->tahun_ajaran . ')' : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Sisa Tagihan -->
            <div class="sm:col-span-3 space-y-1">
                <label for="sisa_tagihan" class="block text-[11px] font-bold text-slate-500 flex items-center gap-1.5">
                    <i class="ti ti-clock-pause text-slate-400 text-sm"></i>
                    <span>Sisa Tagihan</span>
                </label>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-xs font-black font-mono text-slate-400">
                        Rp
                    </div>
                    <input type="text" 
                           id="sisa_tagihan" 
                           name="sisa_tagihan" 
                           placeholder="0" 
                           readonly 
                           class="w-full pl-9 pr-3.5 py-2 text-xs font-mono font-bold text-right text-slate-600 bg-slate-100/90 border border-slate-200/80 rounded-xl shadow-2xs cursor-not-allowed select-none">
                </div>
            </div>

            <!-- Jumlah Bayar -->
            <div class="sm:col-span-3 space-y-1">
                <label for="jumlah" class="block text-[11px] font-bold text-emerald-900 flex items-center gap-1.5">
                    <i class="ti ti-cash text-emerald-600 text-sm"></i>
                    <span>Jumlah Bayar <span class="text-rose-500 font-bold">*</span></span>
                </label>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-xs font-black font-mono text-emerald-700">
                        Rp
                    </div>
                    <input type="text" 
                           id="jumlah" 
                           name="jumlah" 
                           placeholder="0" 
                           class="money w-full pl-9 pr-3.5 py-2 text-xs font-mono font-black text-right text-emerald-950 bg-white border border-emerald-300 rounded-xl placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                </div>
            </div>
        </div>

        <!-- Catatan / Keterangan -->
        <div class="space-y-1">
            <label for="keterangan" class="block text-[11px] font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-notes text-slate-400 text-sm"></i>
                <span>Catatan / Keterangan Item (Opsional)</span>
            </label>
            <div class="relative">
                <input type="text" 
                       id="keterangan" 
                       name="keterangan" 
                       placeholder="Contoh: Cicilan ke-1 / Pembayaran Tunai..." 
                       class="w-full px-3.5 py-2 text-xs font-medium text-slate-800 bg-white border border-slate-300 rounded-xl placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
            </div>
        </div>

        <!-- Tombol Tambah Item -->
        <div class="pt-1">
            <button type="button" 
                    id="btnTambahdetailbayar" 
                    class="w-full py-2 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center justify-center gap-2 cursor-pointer active:scale-95">
                <i class="ti ti-plus text-sm"></i>
                <span>Tambahkan ke Keranjang Pembayaran</span>
            </button>
        </div>
    </div>

    <!-- ================= 3. TABEL ITEM KERANJANG ================= -->
    <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
        <div class="px-4 py-2.5 bg-emerald-600 flex items-center justify-between text-white">
            <div class="flex items-center gap-2">
                <div class="w-6 h-6 rounded-md bg-white/20 text-white flex items-center justify-center text-xs font-bold shadow-2xs">
                    <i class="ti ti-shopping-cart text-sm"></i>
                </div>
                <h6 class="text-xs font-extrabold text-white tracking-tight m-0 uppercase">Daftar Item yang Akan Dibayar</h6>
            </div>
            <span class="text-[11px] font-semibold text-emerald-100">Item Terpilih</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse" id="tableDetailbayar">
                <thead class="bg-emerald-600 text-white font-bold uppercase tracking-wider text-[11px] border-b border-emerald-700/80">
                    <tr>
                        <th class="py-2 px-3.5 text-emerald-100">Jenis Biaya</th>
                        <th class="py-2 px-3.5 text-end w-40 text-emerald-100">Jumlah Bayar</th>
                        <th class="py-2 px-3.5 text-emerald-100">Keterangan</th>
                        <th class="py-2 px-3.5 text-center w-16 text-emerald-100">Aksi</th>
                    </tr>
                </thead>
                <tbody id="detailbayar" class="divide-y divide-slate-100 bg-white"></tbody>
                <tfoot class="bg-emerald-700 text-white font-bold border-t-2 border-emerald-800 text-xs shadow-xs">
                    <tr>
                        <td class="py-2.5 px-3.5 text-end uppercase tracking-wider text-emerald-100 font-extrabold">TOTAL PEMBAYARAN</td>
                        <td class="py-2.5 px-3.5 text-end font-mono font-black text-amber-300 text-sm" id="totalbayar">Rp 0</td>
                        <td colspan="2"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- ================= 4. METODE PEMBAYARAN ================= -->
    <div class="space-y-1.5">
        <label for="metode_pembayaran" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-wallet text-emerald-600 text-sm"></i>
            <span>Metode Pembayaran <span class="text-rose-500 font-bold">*</span></span>
        </label>
        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                <i class="ti ti-credit-card text-base"></i>
            </div>
            <select name="metode_pembayaran" id="metode_pembayaran" 
                    class="w-full pl-9 pr-8 py-2 text-xs font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition cursor-pointer" required>
                <option value="">-- Pilih Metode Pembayaran --</option>
                <option value="TF">TRANSFER BANK</option>
                <option value="TN">TUNAI / CASH</option>
            </select>
        </div>
    </div>

    <!-- ================= 5. ACTION BUTTONS FOOTER ================= -->
    <div class="pt-3.5 border-t border-slate-100 flex flex-col-reverse sm:flex-row sm:items-center justify-end gap-2.5">
        <button type="button" class="w-full sm:w-auto px-5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer active:scale-95" data-bs-dismiss="modal">
            Batal
        </button>
        <button type="submit" id="btnSimpan" class="w-full sm:w-auto px-6 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center justify-center gap-2 cursor-pointer active:scale-95">
            <i class="ti ti-device-floppy text-base"></i>
            <span>Simpan Pembayaran</span>
        </button>
    </div>
</form>

<style>
    .flatpickr-calendar {
        z-index: 9999 !important;
    }
</style>

<script>
    $(function() {
        let sisatagihan;

        function convertToRupiah(number) {
            if (number) {
                var rupiah = "";
                var numberrev = number
                    .toString()
                    .split("")
                    .reverse()
                    .join("");
                for (var i = 0; i < numberrev.length; i++)
                    if (i % 3 == 0) rupiah += numberrev.substr(i, 3) + ".";
                return (
                    rupiah
                    .split("", rupiah.length - 1)
                    .reverse()
                    .join("")
                );
            } else {
                return number;
            }
        }

        $("#jumlah").maskMoney({
            thousands: '.',
            decimal: ',',
            precision: 0
        });

        $(".flatpickr-date").flatpickr({
            altInput: true,
            altFormat: "d F Y",
            dateFormat: "Y-m-d",
            defaultDate: "today"
        });

        function getsisatagihan() {
            let val = $("#formDetailbayar").find("#kode_biaya").val();
            if (!val) {
                $("#formDetailbayar").find("#sisa_tagihan").val('');
                return;
            }
            let biaya = val.split("|");
            let kode_jenis_biaya = biaya[0];
            let kode_biaya = biaya[1];
            let no_pendaftaran = $("#formDetailbayar").find("#no_pendaftaran").val();

            $.ajax({
                type: 'POST',
                url: "{{ route('pembayaranpendidikan.getsisatagihan') }}",
                cache: false,
                data: {
                    _token: "{{ csrf_token() }}",
                    no_pendaftaran: no_pendaftaran,
                    kode_jenis_biaya: kode_jenis_biaya,
                    kode_biaya: kode_biaya
                },
                success: function(data) {
                    $("#formDetailbayar").find("#sisa_tagihan").val(convertToRupiah(data.sisatagihan));
                    sisatagihan = data.sisatagihan;
                }
            });
        }

        $("#kode_biaya").change(function() {
            if ($(this).val() != "") {
                getsisatagihan();
            } else {
                $("#formDetailbayar").find("#sisa_tagihan").val('');
            }
        });
    });
</script>

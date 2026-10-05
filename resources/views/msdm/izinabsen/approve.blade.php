<form action="{{ route('izinabsen.storeapprove', Crypt::encrypt($izinabsen->kode_izin)) }}" method="POST" id="formApproveizin" class="space-y-4">
    @csrf

    <!-- Employee Information Header Card -->
    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 flex items-center gap-3.5">
        <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-800 border border-emerald-200 flex items-center justify-center font-bold text-base shrink-0 shadow-2xs">
            {{ strtoupper(substr($izinabsen->nama_lengkap, 0, 1)) }}
        </div>
        <div class="min-w-0 flex-1">
            <h4 class="text-sm font-bold text-slate-900 truncate mb-0.5">
                {{ $izinabsen->nama_lengkap }}
            </h4>
            <div class="flex flex-wrap items-center gap-2 text-xs text-slate-500">
                <span class="font-mono font-semibold text-slate-700">{{ $izinabsen->npp }}</span>
                <span>•</span>
                <span>{{ $izinabsen->nama_jabatan ?? '-' }}</span>
                <span>•</span>
                <span class="text-emerald-700 font-medium">{{ $izinabsen->nama_unit ?? '-' }}</span>
            </div>
        </div>
    </div>

    <!-- Request Details Grid -->
    @php
        $lama = hitungHari($izinabsen->dari, $izinabsen->sampai);
    @endphp
    <div class="rounded-xl border border-slate-200/90 overflow-hidden divide-y divide-slate-100 text-xs">
        <div class="flex items-center justify-between px-3.5 py-2.5 bg-white">
            <span class="text-slate-500 font-medium flex items-center gap-1.5">
                <i class="ti ti-barcode text-slate-400"></i> Kode Izin
            </span>
            <span class="font-mono font-bold text-slate-800 bg-slate-100 px-2 py-0.5 rounded text-[11px]">
                {{ $izinabsen->kode_izin }}
            </span>
        </div>
        <div class="flex items-center justify-between px-3.5 py-2.5 bg-white">
            <span class="text-slate-500 font-medium flex items-center gap-1.5">
                <i class="ti ti-calendar text-slate-400"></i> Tanggal Pengajuan
            </span>
            <span class="font-semibold text-slate-800">
                {{ DateToIndo($izinabsen->tanggal) }}
            </span>
        </div>
        <div class="flex items-center justify-between px-3.5 py-2.5 bg-white">
            <span class="text-slate-500 font-medium flex items-center gap-1.5">
                <i class="ti ti-calendar-event text-slate-400"></i> Periode Izin
            </span>
            <div class="text-right">
                <span class="font-bold text-emerald-700">
                    {{ DateToIndo($izinabsen->dari) }}
                </span>
                <span class="text-slate-400 mx-1">s/d</span>
                <span class="font-bold text-emerald-700">
                    {{ DateToIndo($izinabsen->sampai) }}
                </span>
                <span class="ml-1.5 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                    {{ $lama }} Hari
                </span>
            </div>
        </div>
        <div class="flex flex-col px-3.5 py-2.5 bg-white gap-1">
            <span class="text-slate-500 font-medium flex items-center gap-1.5">
                <i class="ti ti-notes text-slate-400"></i> Alasan / Keterangan
            </span>
            <p class="text-slate-800 font-medium bg-slate-50 p-2.5 rounded-lg border border-slate-200/60 mt-1 whitespace-pre-line leading-relaxed">
                {{ $izinabsen->keterangan }}
            </p>
        </div>
    </div>

    <!-- Catatan Persetujuan (Optional) -->
    <div class="space-y-1.5">
        <label class="block text-xs font-bold text-slate-700">
            Catatan Persetujuan <span class="text-slate-400 font-normal">(Opsional)</span>
        </label>
        <textarea name="catatan" 
                  rows="2" 
                  placeholder="Tambahkan catatan jika diperlukan..." 
                  class="w-full px-3 py-2 text-xs bg-white border border-slate-300 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition"></textarea>
    </div>

    <!-- Approval Action Buttons -->
    <div class="grid grid-cols-2 gap-3 pt-2">
        <button type="submit" 
                name="approve" 
                value="approve" 
                id="btnSubmitApprove"
                class="w-full py-2.5 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs hover:shadow transition inline-flex items-center justify-center gap-2 cursor-pointer active:scale-95">
            <i class="ti ti-circle-check text-base"></i>
            <span>Setujui Izin</span>
        </button>
        <button type="submit" 
                name="tolak" 
                value="tolak" 
                id="btnSubmitTolak"
                class="w-full py-2.5 px-4 bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs rounded-xl shadow-xs hover:shadow transition inline-flex items-center justify-center gap-2 cursor-pointer active:scale-95">
            <i class="ti ti-circle-x text-base"></i>
            <span>Tolak Pengajuan</span>
        </button>
    </div>
</form>

<script>
    $(document).ready(function() {
        $('#formApproveizin button[type="submit"]').on('click', function(e) {
            const btn = $(this);
            const isApprove = btn.val() === 'approve';
            
            // Disable opposite button
            if (isApprove) {
                $('#btnSubmitTolak').prop('disabled', true).addClass('opacity-50');
                btn.html('<i class="ti ti-loader animate-spin text-base"></i> Memproses...');
            } else {
                $('#btnSubmitApprove').prop('disabled', true).addClass('opacity-50');
                btn.html('<i class="ti ti-loader animate-spin text-base"></i> Memproses...');
            }
        });
    });
</script>

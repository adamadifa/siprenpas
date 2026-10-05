@php
    $lama = hitungHari($izinabsen->dari, $izinabsen->sampai);
    $statusMap = [
        '0' => [
            'label' => 'Menunggu Persetujuan',
            'badge' => 'bg-amber-50 text-amber-700 border-amber-200',
            'icon' => 'ti-hourglass-high',
        ],
        '1' => [
            'label' => 'Disetujui',
            'badge' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
            'icon' => 'ti-circle-check',
        ],
        '2' => [
            'label' => 'Ditolak',
            'badge' => 'bg-rose-50 text-rose-700 border-rose-200',
            'icon' => 'ti-circle-x',
        ],
    ];
    $st = $statusMap[$izinabsen->status] ?? $statusMap['0'];
@endphp

<div class="space-y-4">
    <!-- Employee Header Card -->
    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 flex items-center justify-between gap-3">
        <div class="flex items-center gap-3.5 min-w-0">
            <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-800 border border-emerald-200 flex items-center justify-center font-bold text-base shrink-0 shadow-2xs">
                {{ strtoupper(substr($izinabsen->nama_lengkap, 0, 1)) }}
            </div>
            <div class="min-w-0">
                <h4 class="text-sm font-bold text-slate-900 truncate mb-0.5">
                    {{ $izinabsen->nama_lengkap }}
                </h4>
                <div class="flex flex-wrap items-center gap-2 text-xs text-slate-500">
                    <span class="font-mono font-semibold text-slate-700">{{ $izinabsen->npp }}</span>
                    <span>•</span>
                    <span>{{ $izinabsen->nama_jabatan ?? '-' }}</span>
                </div>
            </div>
        </div>

        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold border shadow-2xs shrink-0 {{ $st['badge'] }}">
            <i class="ti {{ $st['icon'] }}"></i>
            <span>{{ $st['label'] }}</span>
        </span>
    </div>

    <!-- Metadata Details -->
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
                <i class="ti ti-building text-slate-400"></i> Unit Kerja
            </span>
            <span class="font-bold text-slate-800">
                {{ $izinabsen->nama_unit ?? '-' }}
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
            <p class="text-slate-800 font-medium bg-slate-50 p-3 rounded-lg border border-slate-200/60 mt-1 whitespace-pre-line leading-relaxed">
                {{ $izinabsen->keterangan }}
            </p>
        </div>
    </div>

    <!-- Close button -->
    <div class="pt-2">
        <button type="button" 
                data-bs-dismiss="modal" 
                class="w-full py-2.5 px-4 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer active:scale-95">
            Tutup
        </button>
    </div>
</div>

<div class="space-y-4">
    <!-- Header Card Box -->
    <div class="p-4 bg-emerald-50/80 border border-emerald-200/80 rounded-2xl flex items-start gap-3.5 shadow-2xs">
        <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center shrink-0 shadow-2xs">
            <i class="ti ti-speakerphone text-xl"></i>
        </div>
        <div class="flex-1 min-w-0">
            <div class="flex flex-wrap items-center gap-2 mb-1">
                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                    <i class="ti ti-category text-xs"></i>
                    {{ $pengumuman->kategori->nama_kategori }}
                </span>
                <span class="text-[11px] text-slate-400 font-medium flex items-center gap-1">
                    <i class="ti ti-calendar text-xs"></i>
                    {{ \Carbon\Carbon::parse($pengumuman->tanggal)->translatedFormat('d F Y') }}
                </span>
            </div>
            <h3 class="text-base font-extrabold text-slate-900 leading-snug">
                {{ $pengumuman->judul }}
            </h3>
        </div>
    </div>

    <!-- Metadata Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-lg bg-white border border-slate-200 text-slate-600 flex items-center justify-center shrink-0 text-sm">
                <i class="ti ti-map-pin"></i>
            </div>
            <div class="min-w-0">
                <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider block">Lokasi Acara / Tempat</span>
                <span class="text-xs font-bold text-slate-800 truncate block">{{ $pengumuman->lokasi ?: 'Semua Unit / Umum' }}</span>
            </div>
        </div>

        <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-lg bg-white border border-slate-200 text-slate-600 flex items-center justify-center shrink-0 text-sm">
                <i class="ti ti-clock"></i>
            </div>
            <div class="min-w-0">
                <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider block">Waktu Diterbitkan</span>
                <span class="text-xs font-bold text-slate-800 truncate block">{{ $pengumuman->created_at ? $pengumuman->created_at->translatedFormat('d M Y H:i') : '-' }}</span>
            </div>
        </div>
    </div>

    <!-- Content Box -->
    <div class="space-y-1.5">
        <label class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-notes text-slate-400"></i>
            <span>Isi Pengumuman Lengkap</span>
        </label>
        <div class="p-4 bg-slate-50 border border-slate-200 rounded-2xl text-xs sm:text-sm text-slate-800 leading-relaxed whitespace-pre-line shadow-2xs font-normal">
            {!! nl2br(e($pengumuman->isi)) !!}
        </div>
    </div>

    <!-- Modal Footer -->
    <div class="pt-3 border-t border-slate-100 flex items-center justify-end">
        <button type="button" data-bs-dismiss="modal" class="px-5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs transition cursor-pointer">
            Tutup
        </button>
    </div>
</div>

<div class="space-y-4">
    <!-- Header Card Box -->
    <div class="p-4 bg-emerald-50/80 border border-emerald-200/80 rounded-2xl flex items-start gap-3.5 shadow-2xs">
        <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center shrink-0 shadow-2xs">
            <i class="ti ti-folder-check text-xl"></i>
        </div>
        <div class="flex-1 min-w-0">
            <span class="text-[11px] font-bold text-emerald-800 uppercase tracking-wider block">Kategori Pengumuman</span>
            <h3 class="text-base font-extrabold text-slate-900 leading-snug mt-0.5">
                {{ $kategoriPengumuman->nama_kategori }}
            </h3>
        </div>
        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-emerald-600 text-white shadow-2xs">
            <i class="ti ti-speakerphone text-xs"></i>
            {{ $kategoriPengumuman->pengumuman->count() }} Pengumuman
        </span>
    </div>

    <!-- Metadata Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-lg bg-white border border-slate-200 text-slate-600 flex items-center justify-center shrink-0 text-sm">
                <i class="ti ti-calendar-plus"></i>
            </div>
            <div class="min-w-0">
                <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider block">Tanggal Dibuat</span>
                <span class="text-xs font-bold text-slate-800 truncate block">{{ $kategoriPengumuman->created_at ? $kategoriPengumuman->created_at->translatedFormat('d F Y H:i') : '-' }}</span>
            </div>
        </div>

        <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-lg bg-white border border-slate-200 text-slate-600 flex items-center justify-center shrink-0 text-sm">
                <i class="ti ti-history"></i>
            </div>
            <div class="min-w-0">
                <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider block">Terakhir Diperbarui</span>
                <span class="text-xs font-bold text-slate-800 truncate block">{{ $kategoriPengumuman->updated_at ? $kategoriPengumuman->updated_at->translatedFormat('d F Y H:i') : '-' }}</span>
            </div>
        </div>
    </div>

    <!-- Daftar Pengumuman Terkait -->
    <div class="space-y-2">
        <label class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-list text-slate-400"></i>
            <span>Daftar Pengumuman Terkait ({{ $kategoriPengumuman->pengumuman->count() }})</span>
        </label>

        @if ($kategoriPengumuman->pengumuman->count() > 0)
            <div class="border border-slate-200 rounded-xl overflow-hidden">
                <table class="w-full text-left text-xs border-collapse">
                    <thead class="bg-slate-50 text-slate-600 uppercase text-[10px] font-bold border-b border-slate-200">
                        <tr>
                            <th class="py-2.5 px-3 text-center w-10">NO</th>
                            <th class="py-2.5 px-3">JUDUL PENGUMUMAN</th>
                            <th class="py-2.5 px-3 text-center w-28">TANGGAL</th>
                            <th class="py-2.5 px-3 w-36">LOKASI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($kategoriPengumuman->pengumuman as $index => $pengumuman)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="py-2.5 px-3 text-center font-bold text-slate-400">{{ $index + 1 }}</td>
                                <td class="py-2.5 px-3 font-semibold text-slate-800">{{ $pengumuman->judul }}</td>
                                <td class="py-2.5 px-3 text-center text-slate-500 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($pengumuman->tanggal)->translatedFormat('d/m/Y') }}
                                </td>
                                <td class="py-2.5 px-3 text-slate-600">{{ $pengumuman->lokasi ?: '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-6 text-center bg-slate-50 border border-slate-200 rounded-xl">
                <i class="ti ti-speakerphone-off text-2xl text-slate-400 block mb-1"></i>
                <p class="text-xs text-slate-400">Belum ada pengumuman yang menggunakan kategori ini.</p>
            </div>
        @endif
    </div>

    <!-- Modal Footer -->
    <div class="pt-3 border-t border-slate-100 flex items-center justify-end">
        <button type="button" data-bs-dismiss="modal" class="px-5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs transition cursor-pointer">
            Tutup
        </button>
    </div>
</div>

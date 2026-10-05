<div class="space-y-4">
    <!-- Header Banner Info Peserta -->
    <div class="p-4 bg-emerald-50/70 border border-emerald-100 rounded-2xl flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-2xl bg-emerald-600 text-white flex items-center justify-center text-xl font-bold shadow-2xs">
                <i class="ti ti-user-check"></i>
            </div>
            <div>
                <h4 class="text-base font-black text-slate-900">{{ $pendaftaranGotTalent->nama_lengkap }}</h4>
                <div class="flex items-center gap-2 mt-0.5 text-xs text-slate-500">
                    <span class="font-mono font-bold text-emerald-800">{{ $pendaftaranGotTalent->nomor_register }}</span>
                    <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                    <span>{{ $pendaftaranGotTalent->asal_sekolah }}</span>
                </div>
            </div>
        </div>
        @if($pendaftaranGotTalent->jenjangPendidikan)
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-100 self-start sm:self-center">
                <i class="ti ti-school text-sm"></i>
                <span>{{ $pendaftaranGotTalent->jenjangPendidikan->jenjang_pendidikan }}</span>
            </span>
        @endif
    </div>

    <!-- Data Detail Grid Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
        <div class="p-3.5 bg-white border border-slate-200/90 rounded-xl space-y-2">
            <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Identitas & Kontak</div>
            <div class="space-y-1.5">
                <div class="flex justify-between py-1 border-b border-slate-100">
                    <span class="text-slate-500">Tempat, Tgl Lahir</span>
                    <span class="font-bold text-slate-800">{{ $pendaftaranGotTalent->tempat_lahir ?? '-' }}, {{ $pendaftaranGotTalent->tanggal_lahir ? date('d M Y', strtotime($pendaftaranGotTalent->tanggal_lahir)) : '-' }}</span>
                </div>
                <div class="flex justify-between py-1 border-b border-slate-100">
                    <span class="text-slate-500">WhatsApp / HP</span>
                    @if($pendaftaranGotTalent->no_hp)
                        @php
                            preg_match('/\d{9,15}/', $pendaftaranGotTalent->no_hp, $phoneMatches);
                            $cleanPhone = !empty($phoneMatches[0]) ? preg_replace('/^0/', '62', $phoneMatches[0]) : null;
                        @endphp
                        <a href="https://wa.me/{{ $cleanPhone }}" target="_blank" class="font-bold text-emerald-700 hover:underline flex items-center gap-1">
                            <i class="ti ti-brand-whatsapp text-emerald-600"></i>
                            <span>{{ $pendaftaranGotTalent->no_hp }}</span>
                        </a>
                    @else
                        <span class="font-bold text-slate-800">-</span>
                    @endif
                </div>
                <div class="flex justify-between py-1">
                    <span class="text-slate-500">Email</span>
                    <span class="font-bold text-slate-800">{{ $pendaftaranGotTalent->email ?? '-' }}</span>
                </div>
            </div>
        </div>

        <div class="p-3.5 bg-white border border-slate-200/90 rounded-xl space-y-2">
            <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Lokasi & Waktu Pendaftaran</div>
            <div class="space-y-1.5">
                <div class="flex justify-between py-1 border-b border-slate-100">
                    <span class="text-slate-500">Alamat Sekolah</span>
                    <span class="font-bold text-slate-800 text-right max-w-[60%] truncate" title="{{ $pendaftaranGotTalent->alamat_sekolah }}">{{ $pendaftaranGotTalent->alamat_sekolah ?? '-' }}</span>
                </div>
                <div class="flex justify-between py-1 border-b border-slate-100">
                    <span class="text-slate-500">Alamat Rumah</span>
                    <span class="font-bold text-slate-800 text-right max-w-[60%] truncate" title="{{ $pendaftaranGotTalent->alamat_rumah }}">{{ $pendaftaranGotTalent->alamat_rumah ?? '-' }}</span>
                </div>
                <div class="flex justify-between py-1">
                    <span class="text-slate-500">Waktu Mendaftar</span>
                    <span class="font-bold text-slate-800">{{ $pendaftaranGotTalent->created_at ? $pendaftaranGotTalent->created_at->translatedFormat('d F Y, H:i') : '-' }} WIB</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Cabang Perlombaan yang Diikuti -->
    <div class="p-4 bg-slate-50 border border-slate-200/90 rounded-2xl space-y-3">
        <div class="flex items-center justify-between">
            <h5 class="text-xs font-black text-slate-900 uppercase tracking-wider flex items-center gap-1.5">
                <i class="ti ti-trophy text-emerald-600 text-sm"></i>
                <span>Cabang Lomba yang Diikuti</span>
            </h5>
            <span class="text-xs font-bold text-emerald-800 bg-emerald-100/70 px-2.5 py-0.5 rounded-full">
                {{ $pendaftaranGotTalent->perlombaan ? $pendaftaranGotTalent->perlombaan->count() : 0 }} Lomba
            </span>
        </div>

        @if ($pendaftaranGotTalent->perlombaan && $pendaftaranGotTalent->perlombaan->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                @foreach ($pendaftaranGotTalent->perlombaan as $perlombaan)
                    <div class="p-3 bg-white border border-slate-200/90 rounded-xl flex items-center justify-between gap-2 shadow-2xs">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <span class="w-6 h-6 rounded-lg bg-emerald-50 text-emerald-700 font-bold flex items-center justify-center text-[11px] shrink-0 border border-emerald-100">
                                {{ $loop->iteration }}
                            </span>
                            <div class="min-w-0">
                                <div class="font-extrabold text-slate-900 text-xs truncate">{{ $perlombaan->jenis_perlombaan }}</div>
                                <div class="text-[11px] text-indigo-600 font-semibold">{{ $perlombaan->jenjangPendidikan->jenjang_pendidikan ?? '-' }}</div>
                            </div>
                        </div>
                        <span class="font-mono font-bold text-xs text-slate-800 shrink-0">
                            {{ !empty($perlombaan->biaya_pendaftaran) ? 'Rp ' . formatRupiah($perlombaan->biaya_pendaftaran) : 'Gratis' }}
                        </span>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-4 text-xs text-slate-400 italic">
                Belum ada cabang perlombaan yang dipilih.
            </div>
        @endif
    </div>
</div>




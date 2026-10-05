@if ($siswa->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        @foreach ($siswa as $s)
            @php
                $pendaftaran = $s->pendaftaran;
                $unit = $pendaftaran ? $pendaftaran->unit : null;
                $kodeUnit = $pendaftaran ? $pendaftaran->kode_unit : '';
                $namaUnit = $unit ? $unit->nama_unit : '';
            @endphp
            <div class="clickable-card bg-white border border-slate-200/90 hover:border-emerald-500 rounded-xl p-3.5 shadow-2xs hover:shadow-md transition-all duration-200 cursor-pointer group flex flex-col justify-between relative overflow-hidden"
                 data-id="{{ $s->id_siswa }}"
                 data-nama="{{ $s->nama_lengkap }}"
                 data-nisn="{{ $s->nisn ?? '-' }}"
                 data-kode-unit="{{ $kodeUnit }}"
                 data-nama-unit="{{ $namaUnit }}">
                
                <!-- Card Header: Avatar, Name, and Quick Action -->
                <div class="flex items-start gap-3">
                    <!-- Avatar Initials -->
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 group-hover:bg-emerald-600 text-emerald-700 group-hover:text-white border border-emerald-200/80 group-hover:border-emerald-600 flex items-center justify-center font-black text-sm shrink-0 transition-colors shadow-2xs">
                        {{ strtoupper(substr($s->nama_lengkap, 0, 1)) }}
                    </div>

                    <!-- Name & NISN -->
                    <div class="min-w-0 flex-1">
                        <div class="flex items-center justify-between gap-1">
                            <h4 class="text-xs font-black text-slate-800 group-hover:text-emerald-700 transition truncate leading-snug" title="{{ $s->nama_lengkap }}">
                                {{ $s->nama_lengkap }}
                            </h4>
                            <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-600 opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                                <span>Pilih</span>
                                <i class="ti ti-arrow-right text-xs"></i>
                            </span>
                        </div>
                        <div class="flex items-center gap-2 mt-0.5">
                            <span class="inline-flex items-center gap-1 text-[10px] font-mono text-slate-500 bg-slate-100 px-1.5 py-0.5 rounded border border-slate-200">
                                <i class="ti ti-id text-[11px] text-slate-400"></i>
                                <span>NISN: {{ $s->nisn ?: '-' }}</span>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Card Body: Unit & Details -->
                <div class="mt-3 pt-2.5 border-t border-slate-100 grid grid-cols-2 gap-2 text-[11px]">
                    <div class="min-w-0">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Unit Sekolah</span>
                        <span class="font-bold text-slate-700 truncate block mt-0.5">
                            {{ $namaUnit ?: 'Belum Terdata' }}
                        </span>
                    </div>
                    <div class="min-w-0 text-right">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Tahun Masuk</span>
                        <span class="font-semibold text-slate-600 truncate block mt-0.5">
                            {{ $s->tahun_masuk ? 'Th. ' . $s->tahun_masuk : '-' }}
                        </span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="py-12 text-center">
        <div class="flex flex-col items-center justify-center gap-2.5">
            <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center text-xl">
                <i class="ti ti-user-x"></i>
            </div>
            <div>
                <p class="font-bold text-slate-700 text-xs">Data Santri Tidak Ditemukan</p>
                <p class="text-[11px] text-slate-400 mt-0.5">Coba gunakan kata kunci pencarian nama lengkap atau NISN yang lain.</p>
            </div>
        </div>
    </div>
@endif

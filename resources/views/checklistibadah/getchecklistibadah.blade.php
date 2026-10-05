@php
    $total = count($kegiatan_ibadah);
    $checked = $kegiatan_ibadah->filter(function($item) {
        return !empty($item->id_kegiatan_ibadah);
    })->count();
    $percent = $total > 0 ? round(($checked / $total) * 100) : 0;
@endphp

<!-- Progress Indicator Hidden Data -->
<input type="hidden" id="ibadah-progress-percent" value="{{ $percent }}">
<input type="hidden" id="ibadah-progress-text" value="{{ $checked }} dari {{ $total }} kegiatan selesai">

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5">
    @forelse ($kegiatan_ibadah->groupBy('kategori_ibadah') as $kategori => $items)
        @php
            $catChecked = $items->whereNotNull('id_kegiatan_ibadah')->count();
            $catTotal = $items->count();
            $catPercent = $catTotal > 0 ? round(($catChecked / $catTotal) * 100) : 0;
            $isComplete = ($catChecked === $catTotal && $catTotal > 0);
        @endphp

        <!-- Category Card -->
        <div class="bg-white border {{ $isComplete ? 'border-emerald-300/90 shadow-emerald-600/5' : 'border-slate-200/80' }} rounded-2xl p-4 sm:p-5 shadow-xs flex flex-col justify-between transition-all duration-200 hover:shadow-md">
            
            <!-- Category Header -->
            <div>
                <div class="flex items-center justify-between pb-3.5 border-b border-slate-100 mb-3">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <div class="w-8 h-8 rounded-xl {{ $isComplete ? 'bg-emerald-600 text-white' : 'bg-emerald-50 text-emerald-700' }} flex items-center justify-center text-sm font-bold shrink-0 shadow-2xs">
                            <i class="ti ti-heart-handshake"></i>
                        </div>
                        <h3 class="text-sm font-bold text-slate-800 tracking-tight truncate">
                            {{ $kategori }}
                        </h3>
                    </div>
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full {{ $isComplete ? 'bg-emerald-100 text-emerald-800 border border-emerald-300' : 'bg-slate-100 text-slate-600 border border-slate-200' }} text-[11px] font-black shrink-0">
                        @if ($isComplete)
                            <i class="ti ti-check text-xs"></i>
                        @endif
                        <span>{{ $catChecked }}/{{ $catTotal }}</span>
                    </span>
                </div>

                <!-- Item List -->
                <div class="space-y-2">
                    @foreach ($items as $d)
                        @php
                            $isChecked = !empty($d->id_kegiatan_ibadah);
                        @endphp
                        
                        <label for="cb-{{ $d->id }}" 
                               class="checklist-item-card flex items-center justify-between p-3 rounded-xl border transition-all duration-200 cursor-pointer select-none {{ $isChecked ? 'bg-emerald-50/70 border-emerald-300/80 ring-1 ring-emerald-500/20' : 'bg-white hover:bg-slate-50 border-slate-200/80' }}">
                            
                            <!-- Left: Icon & Name -->
                            <div class="flex items-center gap-3 min-w-0 pr-2">
                                <div class="item-icon-wrapper w-7 h-7 rounded-lg flex items-center justify-center text-xs shrink-0 border transition-colors duration-150 {{ $isChecked ? 'bg-emerald-100 text-emerald-700 border-emerald-300' : 'bg-slate-100 text-slate-400 border-slate-200' }}">
                                    <i class="ti ti-{{ $isChecked ? 'check' : 'circle-dot' }}"></i>
                                </div>
                                <span class="text-xs font-bold {{ $isChecked ? 'text-emerald-950' : 'text-slate-700' }} leading-snug">
                                    {{ $d->nama_kegiatan }}
                                </span>
                            </div>

                            <!-- Right: Modern Switch Toggle -->
                            <div class="relative inline-flex items-center cursor-pointer shrink-0">
                                <input type="checkbox" 
                                       id="cb-{{ $d->id }}"
                                       class="sr-only peer checklist" 
                                       data-id="{{ $d->id }}" 
                                       data-kode="{{ $d->kode_checklist_ibadah }}"
                                       {{ $isChecked ? 'checked' : '' }}>
                                <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-600"></div>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Category Bottom Mini-Progress -->
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-400 font-medium">
                <span>{{ $catPercent }}% selesai</span>
                <div class="w-16 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                    <div class="h-full bg-emerald-500 rounded-full transition-all duration-300" style="width: {{ $catPercent }}%;"></div>
                </div>
            </div>

        </div>
    @empty
        <div class="col-span-full text-center py-12 bg-white border border-slate-200/80 rounded-2xl shadow-xs">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto mb-3 text-2xl border border-emerald-100">
                <i class="ti ti-clipboard-off"></i>
            </div>
            <h4 class="text-sm font-bold text-slate-800">Belum Ada Daftar Kegiatan Ibadah</h4>
            <p class="text-xs text-slate-400 font-medium mt-1">
                Silakan hubungi administrator untuk mendaftarkan kategori dan butir mutaba'ah ibadah harian.
            </p>
        </div>
    @endforelse
</div>

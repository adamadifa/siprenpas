@if (auth()->user()->hasAnyPermission(['izinabsen.index', 'izinsakit.index']))
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-white p-2 sm:p-2.5 border border-slate-200/90 rounded-2xl shadow-xs">
        
        <!-- Segmented Tab Navigation -->
        <div class="inline-flex p-1 bg-slate-100/90 rounded-xl gap-1">
            @can('izinabsen.index')
                <a href="{{ route('izinabsen.index') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-xs font-bold transition-all duration-150 {{ request()->is('izinabsen*') ? 'bg-emerald-600 text-white shadow-2xs' : 'text-slate-600 hover:text-slate-900 hover:bg-white/80' }}">
                    <i class="ti ti-calendar-event text-sm"></i>
                    <span>Izin Absen</span>
                    @if (auth()->user()->kode_unit == 'U06' && !empty($notifikasi_izinabsen))
                        <span class="px-1.5 py-0.2 rounded-full text-[10px] font-black {{ request()->is('izinabsen*') ? 'bg-white text-emerald-800' : 'bg-rose-600 text-white' }}">
                            {{ $notifikasi_izinabsen }}
                        </span>
                    @endif
                </a>
            @endcan
            @can('izinsakit.index')
                <a href="{{ route('izinsakit.index') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-xs font-bold transition-all duration-150 {{ request()->is('izinsakit*') ? 'bg-emerald-600 text-white shadow-2xs' : 'text-slate-600 hover:text-slate-900 hover:bg-white/80' }}">
                    <i class="ti ti-first-aid-kit text-sm"></i>
                    <span>Izin Sakit</span>
                    @if (auth()->user()->kode_unit == 'U06' && !empty($notifikasi_izinsakit))
                        <span class="px-1.5 py-0.2 rounded-full text-[10px] font-black {{ request()->is('izinsakit*') ? 'bg-white text-emerald-800' : 'bg-rose-600 text-white' }}">
                            {{ $notifikasi_izinsakit }}
                        </span>
                    @endif
                </a>
            @endcan
        </div>

        <!-- Right Side Action Buttons -->
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('presensi.index') }}" 
               class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-slate-50 hover:bg-slate-100 text-slate-700 font-semibold rounded-xl text-xs border border-slate-200 shadow-2xs transition active:scale-95 cursor-pointer">
                <i class="ti ti-fingerprint text-sm text-emerald-600"></i>
                <span>Monitoring Presensi</span>
            </a>
            @yield('action_button')
        </div>

    </div>
@endif

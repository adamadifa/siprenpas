<div class="space-y-3">
    <div class="overflow-x-auto border border-slate-200 rounded-xl shadow-2xs bg-white">
        <table class="w-full text-left text-xs sm:text-sm border-collapse whitespace-nowrap">
            <thead class="bg-emerald-600 text-white font-bold uppercase text-[11px] border-b border-emerald-700">
                <tr>
                    <th class="py-2.5 px-3.5 text-emerald-100">Waktu & Mesin</th>
                    <th class="py-2.5 px-3.5 text-center text-emerald-100">Tipe</th>
                    <th class="py-2.5 px-3.5 text-emerald-100">Status / Keterangan</th>
                    <th class="py-2.5 px-3.5 text-center text-emerald-100 w-36">Aksi Tarik</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-xs">
                @forelse ($filtered_array as $d)
                    @php
                        $is_in = in_array($d->status_scan, [0, 2, 4, 6, 8]);
                        $log_status = $d->status == 1;
                    @endphp
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <!-- Waktu & Mesin -->
                        <td class="py-2.5 px-3.5">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-200/80 flex items-center justify-center text-sm shrink-0 shadow-2xs">
                                    <i class="ti ti-clock-check"></i>
                                </div>
                                <div>
                                    <div class="font-bold text-slate-900 font-mono text-xs">
                                        {{ date('H:i:s', strtotime($d->jam_absen)) }}
                                    </div>
                                    <div class="text-[11px] text-slate-500 flex items-center gap-1 mt-0.5">
                                        <i class="ti ti-device-desktop text-slate-400"></i>
                                        <span>{{ $d->nama_mesin ?? 'Fingerspot Mesin' }}</span>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <!-- Tipe Scan (IN / OUT) -->
                        <td class="py-2.5 px-3.5 text-center">
                            @if($is_in)
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    <i class="ti ti-login-2 text-xs"></i>
                                    <span>IN</span>
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                    <i class="ti ti-logout-2 text-xs"></i>
                                    <span>OUT</span>
                                </span>
                            @endif
                        </td>

                        <!-- Status & Keterangan -->
                        <td class="py-2.5 px-3.5">
                            <div class="flex items-center gap-1.5 font-bold text-[11px] {{ $log_status ? 'text-emerald-700' : 'text-rose-600' }}">
                                <i class="ti {{ $log_status ? 'ti-circle-check' : 'ti-circle-x' }} text-xs"></i>
                                <span>{{ $log_status ? 'BERHASIL' : 'GAGAL' }}</span>
                            </div>
                            <div class="text-[11px] text-slate-500 truncate max-w-xs mt-0.5" title="{{ $d->keterangan }}">
                                {{ $d->keterangan ?? '-' }}
                            </div>
                        </td>

                        <!-- Aksi Tarik -->
                        <td class="py-2.5 px-3.5 text-center">
                            <div class="flex items-center justify-center gap-1.5">
                                <!-- Tarik Masuk -->
                                <form method="POST" class="updatemasuk m-0" action="{{ route('presensi.updatefrommachine', [Crypt::encrypt($d->pin), 0]) }}">
                                    @csrf
                                    <input type="hidden" name="scan_date" value="{{ date('Y-m-d H:i:s', strtotime($d->jam_absen)) }}">
                                    <button type="submit" 
                                            class="inline-flex items-center gap-1 px-2.5 py-1 bg-emerald-600 hover:bg-emerald-700 text-white text-[11px] font-bold rounded-lg shadow-2xs transition active:scale-95 cursor-pointer" 
                                            title="Tarik log ini sebagai Jam Masuk">
                                        <i class="ti ti-login-2 text-xs"></i>
                                        <span>Masuk</span>
                                    </button>
                                </form>

                                <!-- Tarik Pulang -->
                                <form method="POST" class="updatepulang m-0" action="{{ route('presensi.updatefrommachine', [Crypt::encrypt($d->pin), 1]) }}">
                                    @csrf
                                    <input type="hidden" name="scan_date" value="{{ date('Y-m-d H:i:s', strtotime($d->jam_absen)) }}">
                                    <button type="submit" 
                                            class="inline-flex items-center gap-1 px-2.5 py-1 bg-blue-600 hover:bg-blue-700 text-white text-[11px] font-bold rounded-lg shadow-2xs transition active:scale-95 cursor-pointer" 
                                            title="Tarik log ini sebagai Jam Pulang">
                                        <i class="ti ti-logout-2 text-xs"></i>
                                        <span>Pulang</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-8 text-slate-400">
                            <div class="flex flex-col items-center justify-center gap-1.5">
                                <i class="ti ti-device-desktop-off text-2xl text-slate-300"></i>
                                <span class="font-bold text-slate-600 text-xs">Tidak ada log mesin biometrik</span>
                                <span class="text-[11px] text-slate-400">Pastikan mesin fingerspot terhubung atau data telah tersinkronisasi.</span>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

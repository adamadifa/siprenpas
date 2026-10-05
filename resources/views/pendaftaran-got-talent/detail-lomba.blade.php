<div class="space-y-4">
    @if ($peserta->count() > 0)
        <!-- Alert Info Header -->
        <div class="p-3.5 bg-emerald-50/80 border border-emerald-100 rounded-xl flex items-center justify-between">
            <div class="flex items-center gap-2.5 text-xs text-emerald-900 font-bold">
                <i class="ti ti-users text-emerald-600 text-base"></i>
                <span>Total <strong class="text-emerald-700 font-black">{{ $peserta->count() }} Peserta</strong> Terdaftar pada Cabang Ini</span>
            </div>
            <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-white text-emerald-700 border border-emerald-200 shadow-2xs">
                Data Terverifikasi
            </span>
        </div>

        <!-- Table List Peserta -->
        <div class="border border-slate-200/90 rounded-xl overflow-hidden shadow-2xs">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse whitespace-nowrap">
                    <thead class="bg-slate-50 text-slate-700 font-bold uppercase tracking-wider text-[11px] border-b border-slate-200">
                        <tr>
                            <th class="py-2.5 px-3 w-10 text-center text-slate-400">No</th>
                            <th class="py-2.5 px-3">No. Register</th>
                            <th class="py-2.5 px-3">Nama Lengkap</th>
                            <th class="py-2.5 px-3">Jenjang</th>
                            <th class="py-2.5 px-3">Asal Sekolah</th>
                            <th class="py-2.5 px-3">No. HP / WA</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700 font-medium bg-white">
                        @foreach ($peserta as $index => $p)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-2.5 px-3 text-center text-slate-400 font-bold">
                                    {{ $index + 1 }}
                                </td>
                                <td class="py-2.5 px-3 font-mono font-bold text-emerald-800">
                                    {{ $p->nomor_register }}
                                </td>
                                <td class="py-2.5 px-3 font-bold text-slate-900">
                                    {{ $p->nama_lengkap }}
                                </td>
                                <td class="py-2.5 px-3">
                                    <span class="px-2 py-0.5 rounded-md text-[10.5px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-100">
                                        {{ $p->jenjangPendidikan->jenjang_pendidikan ?? '-' }}
                                    </span>
                                </td>
                                <td class="py-2.5 px-3 text-slate-600">
                                    {{ $p->asal_sekolah }}
                                </td>
                                <td class="py-2.5 px-3">
                                    @if ($p->no_hp)
                                        @php
                                            preg_match('/\d{9,15}/', $p->no_hp, $phoneMatches);
                                            $cleanPhone = !empty($phoneMatches[0]) ? preg_replace('/^0/', '62', $phoneMatches[0]) : null;
                                        @endphp
                                        @if($cleanPhone)
                                            <a href="https://wa.me/{{ $cleanPhone }}" target="_blank" class="inline-flex items-center gap-1 text-emerald-700 font-semibold hover:underline">
                                                <i class="ti ti-brand-whatsapp text-emerald-600"></i>
                                                <span>{{ $p->no_hp }}</span>
                                            </a>
                                        @else
                                            <span>{{ $p->no_hp }}</span>
                                        @endif
                                    @else
                                        <span class="text-slate-400">-</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="py-10 text-center text-slate-400">
            <div class="w-14 h-14 rounded-2xl bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-400 text-2xl mx-auto mb-3">
                <i class="ti ti-users-off"></i>
            </div>
            <h5 class="font-extrabold text-slate-700 text-sm">Belum Ada Peserta</h5>
            <p class="text-xs text-slate-400 mt-0.5">Cabang perlombaan ini belum memiliki peserta yang terdaftar.</p>
        </div>
    @endif
</div>

<div class="mt-4 pt-3 border-t border-slate-100 flex justify-end">
    <button type="button" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer" data-bs-dismiss="modal">
        Tutup
    </button>
</div>

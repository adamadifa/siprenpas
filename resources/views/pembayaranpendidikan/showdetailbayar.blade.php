@php
    $namaSekolah = optional($pengaturan)->nama_sekolah ?? 'Pesantren Persis 80 Al-Amin';
    $alamatSekolah = optional($pengaturan)->alamat_sekolah ?? 'Jl. Raya Ancol No. 27 Sindangkasih Ciamis';
    $logoUrl = optional($pengaturan)->logo
        ? asset('storage/' . $pengaturan->logo)
        : asset('assets/img/logo/persisalamin.png');
@endphp

<div class="p-2 sm:p-4">
    <!-- Receipt Container with Modern Clean Border -->
    <div class="bg-white border-2 border-dashed border-emerald-300 rounded-2xl p-5 sm:p-6 shadow-xs relative overflow-hidden">
        
        <!-- Watermark/Badge in Top Right -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-dashed border-slate-200">
            <div class="flex items-center gap-3.5">
                <img src="{{ $logoUrl }}" alt="Logo" class="h-14 w-auto object-contain shrink-0">
                <div>
                    <h4 class="text-sm sm:text-base font-black text-slate-900 leading-tight">{{ $namaSekolah }}</h4>
                    <p class="text-xs text-slate-500 mt-0.5 leading-relaxed max-w-sm">{{ $alamatSekolah }}</p>
                </div>
            </div>
            <div class="text-left sm:text-right">
                <span class="inline-block text-xs font-black tracking-widest text-emerald-700 uppercase bg-emerald-50 border border-emerald-200 px-3 py-1 rounded-full">
                    KWITANSI PEMBAYARAN
                </span>
                <p class="text-xs font-mono font-bold text-slate-700 mt-1">
                    #{{ $historibayar->no_bukti }}
                </p>
            </div>
        </div>

        <!-- Meta Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 my-4 py-3 bg-slate-50/80 rounded-xl p-3.5 border border-slate-200/60 text-xs">
            <div>
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Diterima Dari</span>
                <h5 class="text-sm font-black text-slate-900 uppercase mt-0.5">{{ $historibayar->nama_lengkap }}</h5>
                <p class="text-slate-500 font-mono mt-0.5">
                    No. Reg: <strong>{{ $historibayar->no_pendaftaran }}</strong> | NISN: <strong>{{ $historibayar->nisn ?: '-' }}</strong>
                </p>
            </div>
            <div class="sm:text-right">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Tanggal &amp; Waktu Transaksi</span>
                <h5 class="text-sm font-bold text-slate-900 mt-0.5">{{ DateToIndo($historibayar->tanggal) }}</h5>
                <p class="text-slate-500 font-mono mt-0.5">
                    Pukul {{ date('H:i', strtotime($historibayar->created_at)) }} WIB
                </p>
            </div>
        </div>

        <!-- Items Table -->
        <div class="overflow-x-auto rounded-xl border border-slate-200/90 mb-4">
            <table class="w-full text-left text-xs border-collapse">
                <thead class="bg-slate-100/90 text-slate-700 font-bold uppercase tracking-wider text-[11px] border-b border-slate-200">
                    <tr>
                        <th class="py-2.5 px-3.5">Rincian Pembayaran</th>
                        <th class="py-2.5 px-3.5 text-end w-40">Jumlah</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @php $total = 0; @endphp
                    @foreach ($detail as $d)
                        @php $total += $d->jumlah; @endphp
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="py-2.5 px-3.5">
                                <span class="font-bold text-slate-900 block text-xs">{{ $d->jenis_biaya }}</span>
                                <span class="text-[11px] text-slate-500">
                                    {{ $d->keterangan }} {{ in_array($d->kode_jenis_biaya, ['B07', 'B01']) ? '- ' . $d->tahun_ajaran : '' }}
                                </span>
                            </td>
                            <td class="py-2.5 px-3.5 text-end font-mono font-bold text-slate-900">
                                {{ formatAngka($d->jumlah) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-emerald-50/80 border-t-2 border-emerald-200">
                    <tr>
                        <td class="py-3 px-3.5 text-end font-black text-emerald-950 uppercase tracking-wider text-xs">Total Pembayaran</td>
                        <td class="py-3 px-3.5 text-end font-mono font-black text-emerald-700 text-sm">
                            Rp {{ formatAngka($total) }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Footnote & Signatures -->
        <div class="grid grid-cols-1 sm:grid-cols-12 gap-4 items-end mt-5 pt-3 border-t border-dashed border-slate-200 text-xs">
            <div class="sm:col-span-7">
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200/80 text-[11px] text-slate-500 space-y-1">
                    <p class="font-bold text-slate-700 uppercase tracking-wider">Catatan Penting:</p>
                    <p>• Simpan lembar kwitansi digital ini sebagai bukti sah pembayaran administrasi pendidikan.</p>
                    <p>• Pembayaran telah diverifikasi secara otomatis oleh sistem administrasi keuangan sekolah.</p>
                </div>
            </div>
            <div class="sm:col-span-5 text-center">
                <p class="text-[11px] text-slate-500 mb-1">Ciamis, {{ date('d F Y', strtotime($historibayar->tanggal)) }}</p>
                <p class="text-xs font-bold text-slate-700 mb-12">Petugas Penerima / Kasir</p>
                <div class="inline-block border-t border-slate-400 pt-1 px-6">
                    <p class="text-xs font-bold text-slate-900">{{ $historibayar->name }}</p>
                    <span class="text-[10px] text-slate-400">Bagian Keuangan</span>
                </div>
            </div>
        </div>
    </div>
</div>

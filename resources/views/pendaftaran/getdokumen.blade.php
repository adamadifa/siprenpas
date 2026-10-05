@forelse ($dokumen as $d)
    <tr class="border-b border-slate-100 hover:bg-slate-50/80 transition text-xs">
        <td class="py-2.5 px-3.5 font-semibold text-slate-800">
            <div class="flex items-center gap-2">
                <div class="w-6 h-6 rounded-md bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                    <i class="ti ti-file-text text-sm"></i>
                </div>
                <span>{{ $d->jenis_dokumen }}</span>
            </div>
        </td>
        <td class="py-2.5 px-3.5">
            @if (!empty($d->nama_file))
                @if (Storage::disk('public')->exists('/pendaftaran/persyaratan/' . $d->nama_file))
                    @php
                        $url = url('/storage/pendaftaran/persyaratan/' . $d->nama_file);
                    @endphp
                    <a href="{{ $url }}" target="_blank" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200/80 transition shadow-2xs">
                        <i class="ti ti-eye text-sm"></i>
                        <span>Lihat Dokumen</span>
                    </a>
                @else
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold bg-rose-50 text-rose-600 border border-rose-100">
                        <i class="ti ti-alert-triangle text-xs"></i>
                        <span>File Rusak / Hilang</span>
                    </span>
                @endif
            @else
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold bg-slate-100 text-slate-500">
                    <i class="ti ti-x text-xs"></i>
                    <span>Belum Ada File</span>
                </span>
            @endif
        </td>
        <td class="py-2.5 px-3.5 text-center">
            <button type="button" class="deletedokumen w-7 h-7 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 inline-flex items-center justify-center transition shadow-2xs cursor-pointer active:scale-95" no_pendaftaran="{{ $d->no_pendaftaran }}" kode_dokumen="{{ $d->kode_dokumen }}" title="Hapus Dokumen">
                <i class="ti ti-trash text-sm"></i>
            </button>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="3" class="py-8 text-center text-slate-400 text-xs font-medium">
            <i class="ti ti-files-off text-3xl block mb-1.5 text-slate-300 mx-auto"></i>
            Belum ada dokumen persyaratan yang diunggah
        </td>
    </tr>
@endforelse

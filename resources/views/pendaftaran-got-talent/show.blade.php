@extends('layouts.app')
@section('titlepage', 'Detail Pendaftaran Peserta Got Talent')

@section('content')
<div class="space-y-6">

    <!-- ================= 1. PAGE HEADER & ACTIONS ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <i class="ti ti-id text-emerald-600 text-2xl"></i>
                <span>Detail Pendaftaran Peserta</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Informasi lengkap identitas peserta, kontak sekolah, serta cabang perlombaan yang diikuti
            </p>
        </div>

        <div class="flex items-center gap-2.5">
            <a href="{{ route('pendaftarangottalent.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white hover:bg-slate-50 text-slate-700 font-bold rounded-xl text-xs border border-slate-300 shadow-xs transition active:scale-95">
                <i class="ti ti-arrow-left text-base"></i>
                <span>Kembali ke Daftar</span>
            </a>
            @can('pendaftarangottalent.edit')
                <button type="button" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs transition active:scale-95 cursor-pointer editPendaftaranGotTalent"
                        id_pendaftaran="{{ Crypt::encrypt($pendaftaranGotTalent->id) }}">
                    <i class="ti ti-edit text-base"></i>
                    <span>Edit Data Peserta</span>
                </button>
            @endcan
        </div>
    </div>

    <!-- ================= 2. MAIN DETAIL CARD ================= -->
    <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
        <!-- Top Gradient Banner -->
        <div class="p-6 bg-gradient-to-r from-emerald-600 to-teal-600 text-white flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-white/20 text-white flex items-center justify-center text-2xl font-bold border border-white/20 shadow-2xs backdrop-blur-xs">
                    <i class="ti ti-user-check"></i>
                </div>
                <div>
                    <h2 class="text-xl font-black text-white tracking-tight">{{ $pendaftaranGotTalent->nama_lengkap }}</h2>
                    <div class="flex flex-wrap items-center gap-3 mt-1 text-xs text-emerald-100 font-medium">
                        <span class="font-mono font-bold bg-white/20 px-2.5 py-0.5 rounded-lg text-white border border-white/20">
                            {{ $pendaftaranGotTalent->nomor_register }}
                        </span>
                        <span>Asal: <strong>{{ $pendaftaranGotTalent->asal_sekolah }}</strong></span>
                    </div>
                </div>
            </div>

            @if($pendaftaranGotTalent->jenjangPendidikan)
                <span class="px-3.5 py-1.5 rounded-xl text-xs font-bold bg-white text-indigo-700 shadow-xs self-start md:self-center inline-flex items-center gap-1.5">
                    <i class="ti ti-school text-sm"></i>
                    <span>{{ $pendaftaranGotTalent->jenjangPendidikan->jenjang_pendidikan }}</span>
                </span>
            @endif
        </div>

        <!-- Content Grid Section -->
        <div class="p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs sm:text-sm">
                <!-- Kolom Kiri: Biodata Peserta -->
                <div class="space-y-4">
                    <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider flex items-center gap-2 pb-2 border-b border-slate-200">
                        <i class="ti ti-user text-emerald-600 text-base"></i>
                        <span>Biodata & Informasi Pribadi</span>
                    </h3>

                    <div class="space-y-2.5">
                        <div class="flex justify-between py-1.5 border-b border-slate-100">
                            <span class="text-slate-500 font-medium">Tempat, Tanggal Lahir</span>
                            <span class="font-bold text-slate-800">{{ $pendaftaranGotTalent->tempat_lahir ?? '-' }}, {{ $pendaftaranGotTalent->tanggal_lahir ? date('d F Y', strtotime($pendaftaranGotTalent->tanggal_lahir)) : '-' }}</span>
                        </div>
                        <div class="flex justify-between py-1.5 border-b border-slate-100">
                            <span class="text-slate-500 font-medium">No. Handphone / WA</span>
                            @if ($pendaftaranGotTalent->no_hp)
                                @php
                                    preg_match('/\d{9,15}/', $pendaftaranGotTalent->no_hp, $phoneMatches);
                                    $cleanPhone = !empty($phoneMatches[0]) ? preg_replace('/^0/', '62', $phoneMatches[0]) : null;
                                @endphp
                                @if ($cleanPhone)
                                    <a href="https://wa.me/{{ $cleanPhone }}" target="_blank" 
                                       class="inline-flex items-center gap-1.5 font-bold text-emerald-700 hover:underline">
                                        <i class="ti ti-brand-whatsapp text-emerald-600 text-sm"></i>
                                        <span>{{ $pendaftaranGotTalent->no_hp }}</span>
                                    </a>
                                @else
                                    <span class="font-bold text-slate-800">{{ $pendaftaranGotTalent->no_hp }}</span>
                                @endif
                            @else
                                <span class="font-bold text-slate-400">-</span>
                            @endif
                        </div>
                        <div class="flex justify-between py-1.5 border-b border-slate-100">
                            <span class="text-slate-500 font-medium">Email</span>
                            <span class="font-bold text-slate-800">{{ $pendaftaranGotTalent->email ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between py-1.5">
                            <span class="text-slate-500 font-medium">Alamat Domisili</span>
                            <span class="font-bold text-slate-800 text-right max-w-[65%]">{{ $pendaftaranGotTalent->alamat_rumah ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Informasi Sekolah & Registrasi -->
                <div class="space-y-4">
                    <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider flex items-center gap-2 pb-2 border-b border-slate-200">
                        <i class="ti ti-building-community text-emerald-600 text-base"></i>
                        <span>Asal Sekolah & Pendaftaran</span>
                    </h3>

                    <div class="space-y-2.5">
                        <div class="flex justify-between py-1.5 border-b border-slate-100">
                            <span class="text-slate-500 font-medium">Nama Sekolah Asal</span>
                            <span class="font-bold text-slate-800">{{ $pendaftaranGotTalent->asal_sekolah ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between py-1.5 border-b border-slate-100">
                            <span class="text-slate-500 font-medium">Alamat Sekolah</span>
                            <span class="font-bold text-slate-800 text-right max-w-[65%]">{{ $pendaftaranGotTalent->alamat_sekolah ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between py-1.5 border-b border-slate-100">
                            <span class="text-slate-500 font-medium">Waktu Mendaftar</span>
                            <span class="font-bold text-slate-800">{{ $pendaftaranGotTalent->created_at ? $pendaftaranGotTalent->created_at->translatedFormat('d F Y, H:i') : '-' }} WIB</span>
                        </div>
                        <div class="flex justify-between py-1.5">
                            <span class="text-slate-500 font-medium">Terakhir Diperbarui</span>
                            <span class="font-bold text-slate-800">{{ $pendaftaranGotTalent->updated_at ? $pendaftaranGotTalent->updated_at->translatedFormat('d F Y, H:i') : '-' }} WIB</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cabang Perlombaan yang Diikuti -->
            <div class="pt-4 border-t border-slate-200/90 space-y-3">
                <div class="flex items-center justify-between">
                    <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
                        <i class="ti ti-trophy text-emerald-600 text-base"></i>
                        <span>Cabang Perlombaan yang Diikuti</span>
                    </h3>
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                        {{ $pendaftaranGotTalent->perlombaan ? $pendaftaranGotTalent->perlombaan->count() : 0 }} Cabang Dipilih
                    </span>
                </div>

                @if ($pendaftaranGotTalent->perlombaan && $pendaftaranGotTalent->perlombaan->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3.5">
                        @foreach ($pendaftaranGotTalent->perlombaan as $perlombaan)
                            <div class="p-4 bg-slate-50/80 border border-slate-200/90 rounded-2xl flex items-start justify-between gap-3 group hover:border-emerald-300 transition">
                                <div class="flex items-start gap-3 min-w-0">
                                    <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-800 font-bold flex items-center justify-center text-xs shrink-0 mt-0.5">
                                        {{ $loop->iteration }}
                                    </div>
                                    <div class="min-w-0">
                                        <div class="font-extrabold text-slate-900 text-sm group-hover:text-emerald-700 transition">
                                            {{ $perlombaan->jenis_perlombaan }}
                                        </div>
                                        <div class="text-xs text-indigo-600 font-semibold mt-0.5">
                                            {{ $perlombaan->jenjangPendidikan->jenjang_pendidikan ?? '-' }}
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right shrink-0">
                                    @if (!is_null($perlombaan->biaya_pendaftaran) && $perlombaan->biaya_pendaftaran > 0)
                                        <span class="font-mono font-bold text-xs text-slate-900 bg-white px-2.5 py-1 rounded-lg border border-slate-200 block shadow-2xs">
                                            Rp {{ formatRupiah($perlombaan->biaya_pendaftaran) }}
                                        </span>
                                    @else
                                        <span class="font-bold text-xs text-emerald-700 bg-emerald-100/60 px-2.5 py-1 rounded-lg block">
                                            Gratis
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-6 bg-slate-50 border border-slate-200 rounded-2xl text-center text-slate-400 text-xs">
                        <i class="ti ti-trophy-off text-2xl mb-1 block"></i>
                        <span>Peserta belum memilih cabang perlombaan.</span>
                    </div>
                @endif
            </div>
        </div>
    </div>

</div>

<!-- Modal Form Edit -->
<x-modal-form id="mdleditPendaftaranGotTalent" size="modal-lg" show="loadeditPendaftaranGotTalent" title="Edit Pendaftaran Got Talent" icon="ti ti-edit" />

@endsection

@push('myscript')
<script>
    $(function() {
        $(document).on("click", ".editPendaftaranGotTalent", function(e) {
            var id_pendaftaran = $(this).attr("id_pendaftaran");
            e.preventDefault();
            $('#mdleditPendaftaranGotTalent').modal("show");
            $("#loadeditPendaftaranGotTalent").html(`
                <div class="text-center py-6">
                    <div class="spinner-border text-emerald-600" role="status">
                        <span class="visually-hidden">Memuat...</span>
                    </div>
                    <p class="mt-2 text-xs text-slate-500">Memuat formulir...</p>
                </div>
            `);
            $("#loadeditPendaftaranGotTalent").load("{{ url('/pendaftaran-got-talent') }}/" + id_pendaftaran + "/edit");
        });
    });
</script>
@endpush


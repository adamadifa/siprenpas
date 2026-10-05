@extends('layouts.app')
@section('titlepage', 'Data Pembiayaan Koperasi')

@section('content')
<div class="space-y-6">

    <!-- ================= 1. TOP HEADER & NAVIGATION ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <!-- Title & Subtitle -->
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-xl shrink-0 font-bold border border-emerald-200 shadow-2xs">
                <i class="ti ti-cash-banknote"></i>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
                    Data Pembiayaan Koperasi
                </h1>
                <p class="text-xs text-slate-500 mt-0.5 font-medium">
                    Manajemen akad pembiayaan, monitoring angsuran, serta histori cicilan anggota
                </p>
            </div>
        </div>

        <!-- Right: Breadcrumb & Actions -->
        <div class="flex flex-col md:items-end gap-2.5">
            <!-- Breadcrumb Navigation -->
            <nav class="flex items-center text-xs text-slate-400 font-medium">
                <a href="{{ route('dashboard.index') }}" class="hover:text-slate-700 transition flex items-center gap-1">
                    <i class="ti ti-home text-sm"></i>
                    <span>Dashboard</span>
                </a>
                <span class="mx-2 text-slate-300">/</span>
                <span class="text-slate-500 flex items-center gap-1">
                    <i class="ti ti-building-bank text-sm"></i>
                    <span>Koperasi</span>
                </span>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Pembiayaan</span>
            </nav>

            <!-- Action Button -->
            <div>
                @can('pembiayaan.create')
                    <button type="button" 
                            id="btncreatePembiayaan"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs hover:shadow-sm transition active:scale-95 cursor-pointer">
                        <i class="ti ti-plus text-base"></i>
                        <span>Input Pembiayaan Baru</span>
                    </button>
                @endcan
            </div>
        </div>
    </div>

    <!-- ================= 2. FILTER & SEARCH TOOLBAR ================= -->
    <form action="{{ route('pembiayaan.index') }}" method="GET" class="w-full">
        <div class="flex flex-col sm:flex-row items-center gap-2.5 sm:gap-3 w-full">
            
            <!-- Search Input -->
            <div class="flex-1 min-w-0 w-full relative">
                <i class="ti ti-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-lg pointer-events-none"></i>
                <input type="text" 
                       name="nama_anggota" 
                       value="{{ Request('nama_anggota') }}" 
                       placeholder="Cari Nama Anggota, No. Akad, atau No. Anggota..." 
                       class="w-full pl-11 pr-4 py-2.5 sm:py-3 text-sm bg-white border border-slate-300/90 rounded-xl text-slate-800 font-medium placeholder-slate-400 shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2 shrink-0 w-full sm:w-auto">
                <button type="submit" class="w-full sm:w-auto px-5 py-2.5 sm:py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl shadow-xs transition inline-flex items-center justify-center gap-2 cursor-pointer active:scale-95 whitespace-nowrap">
                    <i class="ti ti-search text-base"></i>
                    <span>Cari</span>
                </button>
                @if(Request('nama_anggota'))
                    <a href="{{ route('pembiayaan.index') }}" class="py-2.5 sm:py-3 px-3 bg-white hover:bg-slate-100 text-slate-600 border border-slate-300/90 rounded-xl font-semibold text-sm transition inline-flex items-center justify-center shrink-0 shadow-xs cursor-pointer" title="Reset Pencarian">
                        <i class="ti ti-refresh text-base"></i>
                    </a>
                @endif
            </div>

        </div>
    </form>

    <!-- ================= 3. DATA TABLE CARD ================= -->
    <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
        
        <!-- Seamless Solid Green Card Header -->
        <div class="px-5 py-3.5 bg-emerald-600 flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-white">
            <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-lg bg-white/20 text-white flex items-center justify-center text-xs font-bold border border-white/20 shadow-2xs">
                    <i class="ti ti-cash-banknote"></i>
                </div>
                <h3 class="text-sm font-extrabold text-white tracking-tight">Daftar Akad Pembiayaan Anggota</h3>
                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-white/20 text-white border border-white/30 shadow-2xs backdrop-blur-xs">
                    {{ $pembiayaan->total() }} data
                </span>
            </div>
            <div class="text-xs text-emerald-100 font-medium">
                Pilih akad untuk melihat jadwal cicilan dan input angsuran
            </div>
        </div>

        <!-- Responsive Table -->
        <div class="overflow-x-auto bg-emerald-600">
            <table class="w-full text-left text-xs sm:text-sm border-0 border-collapse whitespace-nowrap">
                <!-- Matching Solid Green Table Header -->
                <thead class="bg-emerald-600 text-white font-bold uppercase tracking-wider text-[11px] border-0 border-t border-b border-emerald-700/80">
                    <tr class="border-0">
                        <th class="py-2.5 px-3.5 w-12 text-center text-emerald-100 whitespace-nowrap">No</th>
                        <th class="py-2.5 px-3.5 text-emerald-100 whitespace-nowrap">No. Akad</th>
                        <th class="py-2.5 px-3.5 text-emerald-100 whitespace-nowrap">Tanggal</th>
                        <th class="py-2.5 px-3.5 text-emerald-100 whitespace-nowrap">No. Anggota</th>
                        <th class="py-2.5 px-3.5 text-emerald-100 whitespace-nowrap">Nama Anggota</th>
                        <th class="py-2.5 px-3.5 text-emerald-100 whitespace-nowrap">Jenis Pembiayaan</th>
                        <th class="py-2.5 px-3.5 text-right text-emerald-100 whitespace-nowrap">Pokok (Rp)</th>
                        <th class="py-2.5 px-3.5 text-right text-emerald-100 whitespace-nowrap">Total Tagihan (Rp)</th>
                        <th class="py-2.5 px-3.5 text-right text-emerald-100 whitespace-nowrap">Bayar (Rp)</th>
                        <th class="py-2.5 px-3.5 text-right text-emerald-100 whitespace-nowrap">Sisa (Rp)</th>
                        <th class="py-2.5 px-3.5 text-center text-emerald-100 whitespace-nowrap">Status</th>
                        <th class="py-2.5 px-3.5 text-center w-24 text-emerald-100 whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700 font-medium bg-white text-xs">
                    @forelse ($pembiayaan as $d)
                        @php
                            $jumlah_pembiayaan = $d->jumlah + $d->jumlah * ($d->persentase / 100);
                            $total_bayar = $d->total_bayar ?: 0;
                            $sisa_tagihan = $jumlah_pembiayaan - $total_bayar;
                            $isLunas = ($total_bayar >= $jumlah_pembiayaan);
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <!-- No -->
                            <td class="py-2.5 px-3.5 text-center text-slate-500 font-medium whitespace-nowrap">
                                {{ $loop->iteration + $pembiayaan->firstItem() - 1 }}
                            </td>

                            <!-- No. Akad -->
                            <td class="py-2.5 px-3.5 font-bold font-mono text-slate-900 whitespace-nowrap">
                                {{ $d->no_akad }}
                            </td>

                            <!-- Tanggal -->
                            <td class="py-2.5 px-3.5 whitespace-nowrap text-slate-600">
                                {{ DateToIndo($d->tanggal) }}
                            </td>

                            <!-- No. Anggota -->
                            <td class="py-2.5 px-3.5 font-mono text-slate-600 whitespace-nowrap">
                                {{ $d->no_anggota }}
                            </td>

                            <!-- Nama Anggota -->
                            <td class="py-2.5 px-3.5 font-bold text-slate-800 whitespace-nowrap">
                                {{ $d->nama_lengkap }}
                            </td>

                            <!-- Jenis Pembiayaan -->
                            <td class="py-2.5 px-3.5 whitespace-nowrap">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                    {{ $d->jenis_pembiayaan }}
                                </span>
                            </td>

                            <!-- Pokok -->
                            <td class="py-2.5 px-3.5 text-right font-bold font-mono text-slate-800 whitespace-nowrap">
                                {{ formatRupiah($d->jumlah) }}
                            </td>

                            <!-- Total Tagihan -->
                            <td class="py-2.5 px-3.5 text-right font-bold font-mono text-emerald-700 whitespace-nowrap">
                                {{ formatRupiah($jumlah_pembiayaan) }}
                            </td>

                            <!-- Total Bayar -->
                            <td class="py-2.5 px-3.5 text-right font-bold font-mono text-slate-700 whitespace-nowrap">
                                {{ $total_bayar > 0 ? formatRupiah($total_bayar) : '-' }}
                            </td>

                            <!-- Sisa Tagihan -->
                            <td class="py-2.5 px-3.5 text-right font-bold font-mono {{ $sisa_tagihan > 0 ? 'text-rose-600' : 'text-slate-400' }} whitespace-nowrap">
                                {{ formatRupiah($sisa_tagihan) }}
                            </td>

                            <!-- Status Pelunasan -->
                            <td class="py-2.5 px-3.5 text-center whitespace-nowrap">
                                @if ($isLunas)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span> Lunas
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-600"></span> Belum Lunas
                                    </span>
                                @endif
                            </td>

                            <!-- Aksi -->
                            <td class="py-2.5 px-3.5 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-1.5">
                                    <!-- Detail Pembiayaan -->
                                    @can('tabungan.index')
                                        <a href="{{ route('pembiayaan.show', Crypt::encrypt($d->no_akad)) }}" 
                                           class="w-6.5 h-6.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200/80 flex items-center justify-center transition active:scale-95 shadow-2xs cursor-pointer" 
                                           title="Detail Pembiayaan & Angsuran">
                                            <i class="ti ti-book-2 text-xs"></i>
                                        </a>
                                    @endcan

                                    <!-- Delete Akad (If zero payment) -->
                                    @can('tabungan.delete')
                                        @if ($d->jmlbayar == 0)
                                            <form method="POST" class="deleteform m-0"
                                                  action="{{ route('pembiayaan.delete', Crypt::encrypt($d->no_akad)) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" 
                                                        class="delete-confirm w-6.5 h-6.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200/80 flex items-center justify-center transition active:scale-95 shadow-2xs cursor-pointer" 
                                                        title="Hapus Akad Pembiayaan">
                                                    <i class="ti ti-trash text-xs"></i>
                                                </button>
                                            </form>
                                        @endif
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="py-12 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center text-xl">
                                        <i class="ti ti-history-off"></i>
                                    </div>
                                    <span class="text-xs font-semibold text-slate-600">Data pembiayaan tidak ditemukan</span>
                                    <span class="text-[11px] text-slate-400">Silakan sesuaikan kata kunci pencarian atau input akad baru</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Card Footer & Pagination -->
        <div class="px-5 py-3.5 bg-slate-50 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs text-slate-500">
            <div class="font-medium">
                Menampilkan {{ $pembiayaan->firstItem() ?? 0 }} - {{ $pembiayaan->lastItem() ?? 0 }} dari {{ $pembiayaan->total() }} akad
            </div>
            <div>
                {{ $pembiayaan->links() }}
            </div>
        </div>

    </div>

</div>

<!-- Modals -->
<x-modal-form id="mdlPembiayaan" size="modal-lg" show="loadmodalPembiayaan" title="" />

<!-- Modal Cari Anggota (DataTables) -->
<div class="modal fade" id="mdlAnggota" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content rounded-2xl border-0 shadow-lg overflow-hidden">
            <div class="bg-emerald-600 px-5 py-4 text-white flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-white/20 text-white flex items-center justify-center font-bold text-sm">
                        <i class="ti ti-users"></i>
                    </div>
                    <div>
                        <h4 class="text-sm sm:text-base font-bold text-white mb-0">Pilih Anggota Koperasi</h4>
                        <p class="text-[11px] text-emerald-100 mb-0">Pilih anggota untuk pengajuan akad pembiayaan</p>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white cursor-pointer" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 sm:p-5">
                <div class="overflow-x-auto border border-slate-200 rounded-xl">
                    <table class="w-full text-left text-xs sm:text-sm border-collapse" id="tabelanggota">
                        <thead class="bg-slate-100 text-slate-700 font-bold uppercase text-[11px] border-b border-slate-200">
                            <tr>
                                <th class="py-2.5 px-3">No. Anggota</th>
                                <th class="py-2.5 px-3">NIK</th>
                                <th class="py-2.5 px-3">Nama Lengkap</th>
                                <th class="py-2.5 px-3">No. HP</th>
                                <th class="py-2.5 px-3 text-center w-20">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-xs"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('myscript')
<script>
    $(function() {
        const loading = `
            <div class="flex items-center justify-center p-8">
                <div class="w-8 h-8 border-4 border-emerald-600 border-t-transparent rounded-full animate-spin"></div>
            </div>
        `;

        $("#btncreatePembiayaan").click(function(e) {
            e.preventDefault();
            $('#mdlPembiayaan').modal("show");
            $("#mdlPembiayaan").find(".modal-title").text("Input Data Pembiayaan Baru");
            $("#loadmodalPembiayaan").html(loading);
            $("#loadmodalPembiayaan").load("{{ route('pembiayaan.create') }}");
        });

        $(document).on('show.bs.modal', '.modal', function() {
            const zIndex = 1090 + 10 * $('.modal:visible').length;
            $(this).css('z-index', zIndex);
            setTimeout(() => $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack'));
        });

        $(document).on('click', '#no_anggota_search', function() {
            $('#mdlAnggota').modal("show");
        });

        $('#tabelanggota').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ url()->current() }}',
            columns: [
                { data: 'no_anggota', name: 'no_anggota', className: 'font-mono font-bold text-slate-800' },
                { data: 'nik', name: 'nik', className: 'font-mono text-slate-600' },
                { data: 'nama_lengkap', name: 'nama_lengkap', className: 'font-bold text-slate-800' },
                { data: 'no_hp', name: 'no_hp', className: 'text-slate-600' },
                { 
                    data: 'action', 
                    name: 'action', 
                    className: 'text-center',
                    render: function(data, type, row) {
                        return `<a href="javascript:void(0)" class="px-3 py-1 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg text-xs transition inline-flex items-center gap-1 pilihAnggota cursor-pointer shadow-2xs" no_anggota="${row.no_anggota}"><i class="ti ti-check text-xs"></i> Pilih</a>`;
                    }
                }
            ],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Cari Anggota...",
                lengthMenu: "Tampil _MENU_ data",
                info: "Menampilkan _START_ s/d _END_ dari _TOTAL_ anggota",
                paginate: {
                    first: "«",
                    last: "»",
                    next: "›",
                    previous: "‹"
                }
            }
        });

        function getAnggota(no_anggota) {
            $.ajax({
                url: `/anggota/${no_anggota}/getanggota`,
                type: "GET",
                cache: false,
                success: function(response) {
                    const form = $(document).find("#formPembiayaan");
                    form.find("#no_anggota").val(response.no_anggota);
                    form.find("#nik").val(response.nik);
                    form.find("#nama_lengkap").val(response.nama_lengkap);
                    form.find("#no_hp").val(response.no_hp);
                    form.find("#tempat_lahir").val(response.tempat_lahir);
                    form.find("#tanggal_lahir").val(response.tanggal_lahir);
                    form.find("#jenis_kelamin").val(response.jenis_kelamin);
                    form.find("#pendidikan_terakhir").val(response.pendidikan_terakhir);
                    form.find("#status_pernikahan").val(response.status_pernikahan);
                    form.find("#jml_tanggungan").val(response.jml_tanggungan);
                    form.find("#nama_pasangan").val(response.nama_pasangan);
                    form.find("#pekerjaan_pasangan").val(response.pekerjaan_pasangan);
                    form.find("#nama_ibu").val(response.nama_ibu);
                    form.find("#nama_saudara").val(response.nama_saudara);
                    form.find("#alamat").val(response.alamat);
                    form.find("#id_province").val(response.id_province).trigger('change');
                    getRegency(response.id_province, response.id_regency);
                    getDistrict(response.id_regency, response.id_district);
                    getVillage(response.id_district, response.id_village);
                    form.find("#kode_pos").val(response.kode_pos);
                    form.find("#status_tinggal").val(response.status_tinggal);
                    enableFields();
                    $("#mdlAnggota").modal("hide");
                }
            });
        }

        function getRegency(id_province, id_regency) {
            $.ajax({
                type: 'POST',
                url: '/regency/getregencybyprovince',
                data: { _token: "{{ csrf_token() }}", id_province: id_province, id_regency: id_regency },
                cache: false,
                success: function(respond) { $(document).find("#formPembiayaan").find("#id_regency").html(respond); }
            });
        }

        function getDistrict(id_regency, id_district) {
            $.ajax({
                type: 'POST',
                url: '/district/getdistrictbyregency',
                data: { _token: "{{ csrf_token() }}", id_regency: id_regency, id_district: id_district },
                cache: false,
                success: function(respond) { $(document).find("#formPembiayaan").find("#id_district").html(respond); }
            });
        }

        function getVillage(id_district, id_village) {
            $.ajax({
                type: 'POST',
                url: '/village/getvillagebydistrict',
                data: { _token: "{{ csrf_token() }}", id_district: id_district, id_village: id_village },
                cache: false,
                success: function(respond) { $(document).find("#formPembiayaan").find("#id_village").html(respond); }
            });
        }

        $(document).on('change', '#id_province', function() { getRegency($(this).val(), ""); });
        $(document).on('change', '#id_regency', function() { getDistrict($(this).val(), ""); });
        $(document).on('change', '#id_district', function() { getVillage($(this).val(), ""); });

        $('#tabelanggota tbody').on('click', '.pilihAnggota', function(e) {
            e.preventDefault();
            let no_anggota = $(this).attr('no_anggota');
            getAnggota(no_anggota);
        });

        $(document).on('change', '#kode_pembiayaan', function() {
            let persentase = $('option:selected', this).attr('persentase') || 0;
            const form = $(document).find("#formPembiayaan");
            form.find("#persentase").val(persentase);
            let jml = form.find("#jumlah").val() || "0";
            let jumlah = jml.replace(/\./g, '');
            var jumlah_pengembalian = parseInt(jumlah) + (parseInt(jumlah) * (parseInt(persentase) / 100));
            form.find("#jumlah_pengembalian").val(convertToRupiah(jumlah_pengembalian || 0));
        });

        $(document).on('keyup keydown', '#jumlah', function() {
            const form = $(document).find("#formPembiayaan");
            let persentase = form.find("#persentase").val() || 0;
            let jml = $(this).val() || "0";
            let jumlah = jml.replace(/\./g, '');
            var jumlah_pengembalian = parseInt(jumlah) + (parseInt(jumlah) * (parseInt(persentase) / 100));
            form.find("#jumlah_pengembalian").val(convertToRupiah(jumlah_pengembalian || 0));
        });

        function convertToRupiah(number) {
            if (number) {
                var rupiah = "";
                var numberrev = number.toString().split("").reverse().join("");
                for (var i = 0; i < numberrev.length; i++)
                    if (i % 3 == 0) rupiah += numberrev.substr(i, 3) + ".";
                return rupiah.split("", rupiah.length - 1).reverse().join("");
            } else {
                return number;
            }
        }

        // Delete Confirm
        $(document).on('click', '.delete-confirm', function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            Swal.fire({
                title: 'Hapus Akad Pembiayaan?',
                text: "Data akad pembiayaan akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#064e3b',
                cancelButtonColor: '#e11d48',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) { form.submit(); }
            });
        });

        function enableFields() {
            const form = $(document).find("#formPembiayaan");
            form.find('input, select, textarea').removeAttr('disabled');
        }
    });
</script>
@endpush

@extends('layouts.app')
@section('titlepage', 'Data Tabungan Koperasi')

@section('content')
<div class="space-y-6">

    <!-- ================= 1. TOP HEADER & NAVIGATION ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <!-- Title & Subtitle -->
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-xl shrink-0 font-bold border border-emerald-200 shadow-2xs">
                <i class="ti ti-wallet"></i>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
                    Data Rekening Tabungan
                </h1>
                <p class="text-xs text-slate-500 mt-0.5 font-medium">
                    Manajemen simpanan sukarela, rekening tabungan, mutasi saldo, serta registrasi kartu RFID anggota
                </p>
            </div>
        </div>

        <!-- Right: Breadcrumb & Action -->
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
                <span class="font-bold text-slate-800">Tabungan</span>
            </nav>

            <!-- Action Button -->
            <div>
                @can('tabungan.create')
                    <button type="button" 
                            id="btncreateRekening"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs hover:shadow-sm transition active:scale-95 cursor-pointer">
                        <i class="ti ti-plus text-base"></i>
                        <span>Buka Rekening Baru</span>
                    </button>
                @endcan
            </div>
        </div>
    </div>

    <!-- ================= 2. FILTER & SEARCH TOOLBAR ================= -->
    <form action="{{ route('tabungan.index') }}" method="GET" class="w-full">
        <div class="flex flex-col sm:flex-row items-center gap-2.5 sm:gap-3 w-full">
            
            <!-- Search Input -->
            <div class="flex-1 min-w-0 w-full relative">
                <i class="ti ti-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-lg pointer-events-none"></i>
                <input type="text" 
                       name="nama_lengkap" 
                       value="{{ Request('nama_lengkap') }}" 
                       placeholder="Cari Nama Anggota, No. Rekening, atau No. Anggota..." 
                       class="w-full pl-11 pr-4 py-2.5 sm:py-3 text-sm bg-white border border-slate-300/90 rounded-xl text-slate-800 font-medium placeholder-slate-400 shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
            </div>

            <!-- Select Jenis Tabungan -->
            <div class="w-full sm:w-64 relative">
                <select name="kode_tabungan" 
                        id="kode_tabungan" 
                        class="select2Kodetabungan w-full py-2.5 sm:py-3 text-sm bg-white border border-slate-300/90 rounded-xl text-slate-800 font-medium shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                    <option value="">Semua Jenis Tabungan</option>
                    @foreach ($jenis_tabungan as $item)
                        <option {{ Request('kode_tabungan') == $item->kode_tabungan ? 'selected' : '' }}
                            value="{{ $item->kode_tabungan }}">{{ $item->kode_tabungan }} - {{ $item->jenis_tabungan }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2 shrink-0 w-full sm:w-auto">
                <button type="submit" class="w-full sm:w-auto px-5 py-2.5 sm:py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl shadow-xs transition inline-flex items-center justify-center gap-2 cursor-pointer active:scale-95 whitespace-nowrap">
                    <i class="ti ti-search text-base"></i>
                    <span>Cari</span>
                </button>
                @if(Request('nama_lengkap') || Request('kode_tabungan'))
                    <a href="{{ route('tabungan.index') }}" class="py-2.5 sm:py-3 px-3 bg-white hover:bg-slate-100 text-slate-600 border border-slate-300/90 rounded-xl font-semibold text-sm transition inline-flex items-center justify-center shrink-0 shadow-xs cursor-pointer" title="Reset Pencarian">
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
                    <i class="ti ti-wallet"></i>
                </div>
                <h3 class="text-sm font-extrabold text-white tracking-tight">Daftar Rekening Tabungan Anggota</h3>
                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-white/20 text-white border border-white/30 shadow-2xs backdrop-blur-xs">
                    {{ $tabungan->total() }} data
                </span>
            </div>
            <div class="text-xs text-emerald-100 font-medium">
                Kelola mutasi transaksi dan integrasi kartu RFID
            </div>
        </div>

        <!-- Responsive Table -->
        <div class="overflow-x-auto bg-emerald-600">
            <table class="w-full text-left text-xs sm:text-sm border-0 border-collapse whitespace-nowrap">
                <!-- Matching Solid Green Table Header -->
                <thead class="bg-emerald-600 text-white font-bold uppercase tracking-wider text-[11px] border-0 border-t border-b border-emerald-700/80">
                    <tr class="border-0">
                        <th class="py-2.5 px-3.5 w-12 text-center text-emerald-100 whitespace-nowrap">No</th>
                        <th class="py-2.5 px-3.5 text-emerald-100 whitespace-nowrap">No. Rekening</th>
                        <th class="py-2.5 px-3.5 text-emerald-100 whitespace-nowrap">No. Anggota</th>
                        <th class="py-2.5 px-3.5 text-emerald-100 whitespace-nowrap">Nama Lengkap</th>
                        <th class="py-2.5 px-3.5 text-emerald-100 whitespace-nowrap">Jenis Tabungan</th>
                        <th class="py-2.5 px-3.5 text-right text-emerald-100 whitespace-nowrap">Saldo (Rp)</th>
                        <th class="py-2.5 px-3.5 text-center text-emerald-100 whitespace-nowrap">RFID Smart Card</th>
                        <th class="py-2.5 px-3.5 text-center w-28 text-emerald-100 whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700 font-medium bg-white text-xs">
                    @forelse ($tabungan as $d)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <!-- No -->
                            <td class="py-2.5 px-3.5 text-center text-slate-500 font-medium whitespace-nowrap">
                                {{ $loop->iteration + $tabungan->firstItem() - 1 }}
                            </td>

                            <!-- No. Rekening -->
                            <td class="py-2.5 px-3.5 font-bold font-mono text-slate-900 whitespace-nowrap">
                                {{ $d->no_rekening }}
                            </td>

                            <!-- No. Anggota -->
                            <td class="py-2.5 px-3.5 font-mono text-slate-600 whitespace-nowrap">
                                {{ $d->no_anggota }}
                            </td>

                            <!-- Nama Lengkap -->
                            <td class="py-2.5 px-3.5 font-bold text-slate-800 whitespace-nowrap">
                                {{ $d->nama_lengkap }}
                            </td>

                            <!-- Jenis Tabungan -->
                            <td class="py-2.5 px-3.5 whitespace-nowrap">
                                <div class="flex items-center gap-1.5">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                        {{ $d->kode_tabungan }}
                                    </span>
                                    <span class="text-slate-700 font-medium">{{ $d->jenis_tabungan }}</span>
                                </div>
                            </td>

                            <!-- Saldo -->
                            <td class="py-2.5 px-3.5 text-right font-bold font-mono text-emerald-700 whitespace-nowrap">
                                Rp {{ formatRupiah($d->saldo) }}
                            </td>

                            <!-- RFID -->
                            <td class="py-2.5 px-3.5 text-center whitespace-nowrap">
                                @if($d->rfid)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-mono font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <i class="ti ti-nfc text-xs"></i>
                                        <span>{{ $d->rfid }}</span>
                                    </span>
                                @else
                                    <span class="text-slate-300 font-semibold">-</span>
                                @endif
                            </td>

                            <!-- Aksi -->
                            <td class="py-2.5 px-3.5 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-1.5">
                                    <!-- Detail Tabungan -->
                                    @can('tabungan.index')
                                        <a href="{{ route('tabungan.show', Crypt::encrypt($d->no_rekening)) }}" 
                                           class="w-6.5 h-6.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200/80 flex items-center justify-center transition active:scale-95 shadow-2xs cursor-pointer" 
                                           title="Buku Tabungan / Mutasi">
                                            <i class="ti ti-book-2 text-xs"></i>
                                        </a>
                                    @endcan

                                    <!-- Edit RFID -->
                                    @can('tabungan.edit')
                                        <button type="button" 
                                                class="btnEditRfid w-6.5 h-6.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200/80 flex items-center justify-center transition active:scale-95 shadow-2xs cursor-pointer"
                                                data-no-rekening="{{ Crypt::encrypt($d->no_rekening) }}" 
                                                title="Edit Kode RFID">
                                            <i class="ti ti-nfc text-xs"></i>
                                        </button>
                                    @endcan

                                    <!-- Delete Rekening -->
                                    @can('tabungan.delete')
                                        <form method="POST" class="deleteform m-0"
                                              action="{{ route('tabungan.deleterekening', Crypt::encrypt($d->no_rekening)) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" 
                                                    class="delete-confirm w-6.5 h-6.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200/80 flex items-center justify-center transition active:scale-95 shadow-2xs cursor-pointer"
                                                    title="Hapus Rekening">
                                                <i class="ti ti-trash text-xs"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center text-xl">
                                        <i class="ti ti-folder-off"></i>
                                    </div>
                                    <span class="text-xs font-semibold text-slate-600">Data rekening tabungan tidak ditemukan</span>
                                    <span class="text-[11px] text-slate-400">Silakan sesuaikan kata kunci pencarian atau jenis tabungan</span>
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
                Menampilkan {{ $tabungan->firstItem() ?? 0 }} - {{ $tabungan->lastItem() ?? 0 }} dari {{ $tabungan->total() }} rekening
            </div>
            <div>
                {{ $tabungan->links() }}
            </div>
        </div>

    </div>

</div>

<!-- ================= 4. MODALS ================= -->

<!-- Modal Buat Rekening -->
<x-modal-form id="mdlRekening" size="" show="loadmodalRekening" title="" />

<!-- Modal Cari Anggota (DataTables) -->
<div class="modal fade" id="mdlAnggota" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content rounded-2xl border-0 shadow-lg overflow-hidden">
            <!-- Modal Header -->
            <div class="bg-emerald-600 px-5 py-4 text-white flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-white/20 text-white flex items-center justify-center font-bold text-sm">
                        <i class="ti ti-users"></i>
                    </div>
                    <div>
                        <h4 class="text-sm sm:text-base font-bold text-white mb-0">Pilih Anggota Koperasi</h4>
                        <p class="text-[11px] text-emerald-100 mb-0">Cari dan pilih anggota untuk pembukaan rekening tabungan</p>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white cursor-pointer" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body with Table -->
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

<!-- Modal Edit RFID -->
<div class="modal fade" id="mdlEditRfid" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-2xl border-0 shadow-lg overflow-hidden">
            <!-- Modal Header -->
            <div class="bg-emerald-600 px-5 py-4 text-white flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-white/20 text-white flex items-center justify-center font-bold text-sm">
                        <i class="ti ti-nfc"></i>
                    </div>
                    <div>
                        <h4 class="text-sm sm:text-base font-bold text-white mb-0">Edit Kartu RFID Tabungan</h4>
                        <p class="text-[11px] text-emerald-100 mb-0">Tautkan kartu pintar / RFID untuk transaksi tabungan</p>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white cursor-pointer" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Form Body -->
            <div class="modal-body p-5">
                <form id="formEditRfid" class="space-y-4" novalidate>
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_no_rekening" name="no_rekening">

                    <!-- Info Preview Box -->
                    <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl space-y-1">
                        <div class="text-[11px] text-slate-500 font-medium">Nasabah:</div>
                        <div class="text-xs font-bold text-slate-900" id="edit_nama_lengkap_display">-</div>
                        <div class="text-[11px] text-slate-600 font-mono">No. Rek: <strong id="edit_no_rekening_display" class="text-emerald-700">-</strong></div>
                    </div>

                    <!-- RFID Input -->
                    <div class="space-y-1.5">
                        <label for="edit_rfid" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                            <i class="ti ti-credit-card text-sm text-slate-400"></i>
                            <span>Kode RFID Smart Card</span>
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                <i class="ti ti-nfc text-base"></i>
                            </div>
                            <input type="text" 
                                   id="edit_rfid" 
                                   name="rfid" 
                                   maxlength="20"
                                   class="w-full pl-10 pr-3.5 py-2.5 text-xs sm:text-sm font-mono font-bold text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition uppercase" 
                                   placeholder="Scan kartu RFID atau ketik kode...">
                        </div>
                        <p class="text-[11px] text-slate-400 font-medium">
                            Kode RFID harus unik dan maksimal 20 karakter. Kosongkan jika tidak memakai kartu.
                        </p>
                    </div>

                    <!-- Modal Actions -->
                    <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2.5">
                        <button type="button" 
                                class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-lg transition cursor-pointer active:scale-95" 
                                data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="button" 
                                id="btnUpdateRfid" 
                                class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-lg shadow-xs transition flex items-center justify-center gap-1.5 cursor-pointer active:scale-95">
                            <i class="ti ti-device-floppy text-sm"></i>
                            <span>Simpan Perubahan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('myscript')
<script>
    $(function() {
        // Modal stacking z-index helper
        $(document).on('show.bs.modal', '.modal', function() {
            const zIndex = 1090 + 10 * $('.modal:visible').length;
            $(this).css('z-index', zIndex);
            setTimeout(() => $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack'));
        });

        const loading = `
            <div class="flex items-center justify-center p-8">
                <div class="w-8 h-8 border-4 border-emerald-600 border-t-transparent rounded-full animate-spin"></div>
            </div>
        `;

        // Select2 for filter
        if ($('.select2Kodetabungan').length) {
            $('.select2Kodetabungan').select2({
                placeholder: 'Semua Jenis Tabungan',
                allowClear: true,
                width: '100%'
            });
        }

        // Open Buat Rekening Modal
        $("#btncreateRekening").click(function(e) {
            e.preventDefault();
            $('#mdlRekening').modal("show");
            $("#loadmodalRekening").html(loading);
            $("#mdlRekening").find(".modal-title").text("Buka Rekening Tabungan Baru");
            $("#loadmodalRekening").load("{{ route('tabungan.createrekening') }}");
        });

        // Trigger Anggota Search Modal from Createrekening Form
        $(document).on('click', '#no_anggota_search', function() {
            $('#mdlAnggota').modal("show");
        });

        // DataTables Anggota
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

        // Fetch selected member info
        function getAnggota(no_anggota) {
            $.ajax({
                url: `/anggota/${no_anggota}/getanggota`,
                type: "GET",
                cache: false,
                success: function(response) {
                    const $form = $(document).find("#formTabungan");
                    $form.find("#no_anggota").val(response.no_anggota);
                    $form.find("#no_anggota_text").text(response.no_anggota);
                    $form.find("#nama_lengkap_text").text(response.nama_lengkap);
                    $form.find("#nik_text").text('NIK: ' + (response.nik || '-'));
                    $form.find("#memberPreviewCard").removeClass('hidden');

                    // Clear error on no_anggota input
                    $form.find("#no_anggota").removeClass('border-rose-500 ring-2 ring-rose-500/20 bg-rose-50/20')
                         .addClass('border-slate-300 focus:ring-emerald-500/20 focus:border-emerald-600');
                    $form.find("#no_anggota").closest('.space-y-1\\.5').find('.error-msg').remove();

                    $("#mdlAnggota").modal("hide");
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Gagal memuat detail anggota. Silakan coba lagi.'
                    });
                }
            });
        }

        $('#tabelanggota tbody').on('click', '.pilihAnggota', function(e) {
            e.preventDefault();
            let no_anggota = $(this).attr('no_anggota');
            getAnggota(no_anggota);
        });

        // Handle Edit RFID Modal
        $(document).on('click', '.btnEditRfid', function(e) {
            e.preventDefault();
            let no_rekening = $(this).data('no-rekening');
            
            $('#formEditRfid')[0].reset();
            $('#edit_rfid').removeClass('border-rose-500 ring-2 ring-rose-500/20 bg-rose-50/20');
            $('#formEditRfid').find('.error-msg').remove();
            $('#edit_no_rekening').val(no_rekening);
            
            $.ajax({
                url: `{{ url('tabungan') }}/${no_rekening}/edit`,
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        let data = response.data;
                        $('#edit_nama_lengkap_display').text(data.nama_lengkap || '-');
                        $('#edit_no_rekening_display').text(data.no_rekening + ' (' + (data.jenis_tabungan || '') + ')');
                        $('#edit_rfid').val(data.rfid || '');
                        $('#mdlEditRfid').modal('show');
                    } else {
                        Swal.fire({ icon: 'error', title: 'Error', text: response.message });
                    }
                },
                error: function() {
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Gagal memuat data tabungan' });
                }
            });
        });

        // Handle Update RFID
        $('#btnUpdateRfid').click(function() {
            let form = $('#formEditRfid');
            let no_rekening = $('#edit_no_rekening').val();
            let rfid = $('#edit_rfid').val().trim();
            
            $('#edit_rfid').removeClass('border-rose-500 ring-2 ring-rose-500/20 bg-rose-50/20');
            form.find('.error-msg').remove();
            
            if (rfid && rfid.length > 20) {
                $('#edit_rfid').addClass('border-rose-500 ring-2 ring-rose-500/20 bg-rose-50/20');
                $('#edit_rfid').closest('.space-y-1\\.5').append(`
                    <p class="error-msg text-[11px] font-semibold text-rose-500 mt-1 flex items-center gap-1">
                        <i class="ti ti-alert-circle text-xs shrink-0"></i>
                        <span>Kode RFID maksimal 20 karakter</span>
                    </p>
                `);
                return;
            }
            
            const $btn = $(this);
            $btn.prop('disabled', true).html(`
                <div class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                <span>Menyimpan...</span>
            `);
            
            $.ajax({
                url: `{{ url('tabungan') }}/${no_rekening}/update`,
                type: 'PUT',
                data: form.serialize(),
                success: function(response) {
                    if (response.success) {
                        $('#mdlEditRfid').modal('hide');
                        Swal.fire({ 
                            icon: 'success', 
                            title: 'Berhasil', 
                            text: response.message, 
                            timer: 1800,
                            showConfirmButton: false 
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({ icon: 'error', title: 'Error', text: response.message });
                    }
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON?.errors;
                    if (errors && errors.rfid) {
                        $('#edit_rfid').addClass('border-rose-500 ring-2 ring-rose-500/20 bg-rose-50/20');
                        $('#edit_rfid').closest('.space-y-1\\.5').append(`
                            <p class="error-msg text-[11px] font-semibold text-rose-500 mt-1 flex items-center gap-1">
                                <i class="ti ti-alert-circle text-xs shrink-0"></i>
                                <span>${errors.rfid[0]}</span>
                            </p>
                        `);
                    } else {
                        Swal.fire({ icon: 'error', title: 'Error', text: 'Gagal memperbarui data RFID' });
                    }
                },
                complete: function() {
                    $btn.prop('disabled', false).html('<i class="ti ti-device-floppy text-sm"></i> <span>Simpan Perubahan</span>');
                }
            });
        });

        // Delete Confirm
        $(document).on('click', '.delete-confirm', function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            Swal.fire({
                title: 'Hapus Rekening Tabungan?',
                text: "Data rekening beserta histori mutasi akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#064e3b',
                cancelButtonColor: '#e11d48',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

        $('#edit_rfid').on('input', function() {
            this.value = this.value.toUpperCase();
        });
    });
</script>
@endpush

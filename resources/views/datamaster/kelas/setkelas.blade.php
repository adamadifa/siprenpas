@extends('layouts.app')
@section('titlepage', 'Set Anggota Kelas ' . $kelas->nama_kelas)

@section('content')
<div class="space-y-5">

    <!-- ================= 1. PAGE HEADER (NO CARD) WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <div class="flex items-center gap-2 mb-1">
                <a href="{{ route('kelas.index') }}" class="inline-flex items-center gap-1 text-xs font-bold text-slate-500 hover:text-emerald-700 transition">
                    <i class="ti ti-arrow-left"></i>
                    <span>Kembali ke Data Kelas</span>
                </a>
            </div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <i class="ti ti-users text-emerald-600 text-2xl"></i>
                <span>Anggota Kelas: {{ $kelas->nama_kelas }}</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Atur dan kelola penempatan siswa pada rombongan belajar Kelas {{ $kelas->nama_kelas }} ({{ $kelas->nama_unit }})
            </p>
        </div>

        <!-- Right Side: Breadcrumb & Actions -->
        <div class="flex flex-col md:items-end gap-2.5">
            <!-- Breadcrumb Navigation -->
            <nav class="flex items-center text-xs text-slate-400 font-medium">
                <a href="{{ route('dashboard.index') }}" class="hover:text-slate-700 transition flex items-center gap-1">
                    <i class="ti ti-home text-sm"></i>
                    <span>Dashboard</span>
                </a>
                <span class="mx-2 text-slate-300">/</span>
                <a href="{{ route('kelas.index') }}" class="hover:text-slate-700 transition">
                    <span>Kelas</span>
                </a>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Set Anggota</span>
            </nav>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center gap-2">
                @can('kelas.create')
                    <button type="button" id="btnAddsiswa" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg text-xs shadow-xs transition-all duration-200 active:scale-95 cursor-pointer">
                        <i class="ti ti-user-plus text-base"></i>
                        <span>Tambah Siswa ke Kelas</span>
                    </button>
                @endcan
            </div>
        </div>
    </div>

    <!-- ================= 2. CLASS SUMMARY STRIP ================= -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        <!-- Kelas Name -->
        <div class="bg-white border border-slate-200/90 rounded-xl p-3.5 shadow-2xs flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-200/80 flex items-center justify-center text-lg shrink-0">
                <i class="ti ti-door-enter"></i>
            </div>
            <div>
                <span class="text-[11px] font-semibold text-slate-400 block leading-tight">Nama Kelas</span>
                <span class="text-sm font-black text-slate-800 mt-0.5 block">Kelas {{ $kelas->nama_kelas }}</span>
            </div>
        </div>

        <!-- Tingkat -->
        <div class="bg-white border border-slate-200/90 rounded-xl p-3.5 shadow-2xs flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-700 border border-indigo-200/80 flex items-center justify-center text-lg shrink-0">
                <i class="ti ti-chart-bar"></i>
            </div>
            <div>
                <span class="text-[11px] font-semibold text-slate-400 block leading-tight">Tingkat Jenjang</span>
                <span class="text-sm font-black text-slate-800 mt-0.5 block">Tingkat {{ $kelas->tingkat }}</span>
            </div>
        </div>

        <!-- Unit -->
        <div class="bg-white border border-slate-200/90 rounded-xl p-3.5 shadow-2xs flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-700 border border-slate-200/80 flex items-center justify-center text-lg shrink-0">
                <i class="ti ti-school"></i>
            </div>
            <div>
                <span class="text-[11px] font-semibold text-slate-400 block leading-tight">Unit Pendidikan</span>
                <span class="text-sm font-black text-slate-800 mt-0.5 block truncate max-w-[140px]" title="{{ $kelas->nama_unit }}">
                    {{ $kelas->nama_unit }}
                </span>
            </div>
        </div>

        <!-- Kode Kelas -->
        <div class="bg-white border border-slate-200/90 rounded-xl p-3.5 shadow-2xs flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-700 border border-amber-200/80 flex items-center justify-center text-lg shrink-0">
                <i class="ti ti-barcode"></i>
            </div>
            <div>
                <span class="text-[11px] font-semibold text-slate-400 block leading-tight">Kode Kelas</span>
                <span class="text-sm font-black font-mono text-emerald-800 mt-0.5 block">{{ $kelas->kode_kelas }}</span>
            </div>
        </div>
    </div>

    <!-- ================= 3. DATA TABLE (SEAMLESS SOLID GREEN HEADER) ================= -->
    <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden max-w-4xl">
        
        <!-- Seamless Solid Green Card Header -->
        <div class="px-5 pt-4 pb-2.5 bg-emerald-600 flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-white border-0">
            <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-lg bg-white/20 text-white flex items-center justify-center text-xs font-bold border border-white/20 shadow-2xs">
                    <i class="ti ti-users"></i>
                </div>
                <h3 class="text-sm font-extrabold text-white tracking-tight">Daftar Anggota Siswa</h3>
                <span id="badgeCountSiswa" class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-white/20 text-white border border-white/30 shadow-2xs backdrop-blur-xs">
                    Memuat data...
                </span>
            </div>
            <div class="text-xs text-emerald-100 font-medium">
                Siswa terdaftar aktif pada kelas ini
            </div>
        </div>

        <!-- Responsive Table Container -->
        <div class="overflow-x-auto bg-emerald-600">
            <table class="w-full text-left text-xs sm:text-sm border-0 border-collapse">
                <!-- Matching Solid Green Table Header -->
                <thead class="bg-emerald-600 text-white font-bold uppercase tracking-wider text-[11px] border-0 border-t-0 border-b border-emerald-700/80">
                    <tr class="border-0 border-t-0">
                        <th class="py-2.5 px-3.5 w-14 text-center text-emerald-100 border-0 border-t-0 whitespace-nowrap">No</th>
                        <th class="py-2.5 px-3.5 w-36 text-emerald-100 border-0 border-t-0 whitespace-nowrap">NIS</th>
                        <th class="py-2.5 px-3.5 text-emerald-100 border-0 border-t-0">Nama Siswa</th>
                        <th class="py-2.5 px-3.5 text-center w-24 text-emerald-100 border-0 border-t-0 whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody id="loadkelassiswa" class="divide-y divide-slate-100 text-slate-700 font-medium bg-white">
                    <tr>
                        <td colspan="4" class="p-10 text-center text-slate-400">
                            <div class="w-8 h-8 border-3 border-emerald-500 border-t-transparent rounded-full animate-spin mx-auto mb-2"></div>
                            <span class="text-xs font-bold text-slate-600">Memuat Daftar Siswa...</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- ================= MODAL TAMBAH SISWA KE KELAS ================= -->
<div class="modal fade" id="modalTambahSiswa" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-2xl rounded-2xl overflow-hidden">
            <!-- Modal Header -->
            <div class="px-5 py-3.5 bg-emerald-600 text-white flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-white/20 text-white flex items-center justify-center text-base border border-white/20">
                        <i class="ti ti-user-plus"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-extrabold text-white">Tambah Siswa ke Kelas</h4>
                        <p class="text-[11px] text-emerald-100">Cari dan masukkan siswa yang belum memiliki kelas</p>
                    </div>
                </div>
                <button type="button" class="w-7 h-7 rounded-lg bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition cursor-pointer" data-bs-dismiss="modal">
                    <i class="ti ti-x text-sm"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-4 sm:p-5 space-y-4">
                <!-- Search Box -->
                <div class="relative">
                    <i class="ti ti-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base pointer-events-none"></i>
                    <input type="text" 
                           id="nama_siswa" 
                           placeholder="Ketik Nama Siswa atau NIS untuk mencari..." 
                           autocomplete="off"
                           class="w-full pl-10 pr-4 py-2.5 text-sm bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                </div>

                <!-- Table of available students -->
                <div class="border border-slate-200 rounded-xl overflow-hidden max-h-96 overflow-y-auto shadow-2xs">
                    <table class="w-full text-left text-xs sm:text-sm border-collapse">
                        <thead class="bg-slate-50 sticky top-0 z-10 text-slate-600 font-bold uppercase text-[11px] border-b border-slate-200">
                            <tr>
                                <th class="py-2.5 px-3 text-center w-12">No</th>
                                <th class="py-2.5 px-3 w-28">ID Siswa</th>
                                <th class="py-2.5 px-3 w-32">NIS</th>
                                <th class="py-2.5 px-3">Nama Lengkap</th>
                                <th class="py-2.5 px-3 text-center w-24">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="loadsiswa" class="divide-y divide-slate-100 font-medium">
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-400">
                                    <div class="w-6 h-6 border-2 border-emerald-500 border-t-transparent rounded-full animate-spin mx-auto mb-1.5"></div>
                                    <span class="text-xs">Memuat data siswa...</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="px-5 py-3 bg-slate-50 border-t border-slate-200/80 flex items-center justify-end">
                <button type="button" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer" data-bs-dismiss="modal">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('myscript')
<script>
    $(function() {
        // Open Tambah Siswa Modal
        $("#btnAddsiswa").click(function(e) {
            e.preventDefault();
            $('#modalTambahSiswa').modal("show");
            getSiswa();
        });

        function getSiswa() {
            const kode_kelas = "{{ $kelas->kode_kelas }}";
            const nama_siswa = $("#nama_siswa").val();
            
            $("#loadsiswa").html(`
                <tr>
                    <td colspan="5" class="py-8 text-center text-slate-400">
                        <div class="w-6 h-6 border-2 border-emerald-500 border-t-transparent rounded-full animate-spin mx-auto mb-1.5"></div>
                        <span class="text-xs">Memuat data siswa...</span>
                    </td>
                </tr>
            `);

            $.ajax({
                type: 'POST',
                url: `/kelas/getsiswa`,
                data: {
                    _token: "{{ csrf_token() }}",
                    kode_kelas: kode_kelas,
                    nama_siswa: nama_siswa
                },
                cache: false,
                success: function(respond) {
                    let no = 1;
                    $("#loadsiswa").html("");
                    if(respond.length === 0) {
                        $("#loadsiswa").html(`
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-400">
                                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center mx-auto mb-2 text-slate-400">
                                        <i class="ti ti-user-x text-lg"></i>
                                    </div>
                                    <p class="text-xs font-bold text-slate-700">Tidak ada siswa yang sesuai</p>
                                    <p class="text-[11px] text-slate-400 mt-0.5">Siswa mungkin sudah terdaftar di kelas lain atau belum aktif.</p>
                                </td>
                            </tr>
                        `);
                        return;
                    }
                    respond.forEach(element => {
                        const avatarHtml = element.foto_pendaftaran ? 
                            `<img src="/storage/photos/pendaftaran/${element.foto_pendaftaran}" alt="${element.nama_lengkap}" class="w-7 h-8.5 rounded object-cover border border-slate-200 shrink-0">` : 
                            `<div class="w-7 h-8.5 rounded bg-emerald-50 border border-emerald-200 text-emerald-800 font-bold text-xs flex items-center justify-center shrink-0">${element.nama_lengkap.charAt(0).toUpperCase()}</div>`;

                        const isAlreadyMember = element.ceksiswa != null;
                        const actionBtn = isAlreadyMember ?
                            `<button type="button" class="px-2.5 py-1 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 font-bold text-xs inline-flex items-center gap-1 transition active:scale-95 hapussiswa cursor-pointer shadow-2xs" id_siswa="${element.id_siswa}">
                                <i class="ti ti-minus text-xs"></i> <span>Batal</span>
                            </button>` :
                            `<button type="button" class="px-2.5 py-1 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 font-bold text-xs inline-flex items-center gap-1 transition active:scale-95 tambahsiswa cursor-pointer shadow-2xs" id_siswa="${element.id_siswa}">
                                <i class="ti ti-plus text-xs"></i> <span>Pilih</span>
                            </button>`;

                        $("#loadsiswa").append(`
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-2.5 px-3 text-center text-slate-400 font-bold text-xs">${no++}</td>
                                <td class="py-2.5 px-3">
                                    <code class="px-1.5 py-0.5 rounded text-[11px] font-bold bg-slate-100 text-slate-700 border border-slate-200">${element.id_siswa}</code>
                                </td>
                                <td class="py-2.5 px-3 font-mono font-semibold text-slate-700 text-xs">${element.nis ?? '-'}</td>
                                <td class="py-2.5 px-3">
                                    <div class="flex items-center gap-2">
                                        ${avatarHtml}
                                        <span class="font-bold text-slate-900 capitalize text-xs sm:text-sm">${element.nama_lengkap.toLowerCase()}</span>
                                    </div>
                                </td>
                                <td class="py-2.5 px-3 text-center">${actionBtn}</td>
                            </tr>
                        `);
                    });
                }
            });
        }

        function getkelassiswa() {
            const kode_kelas = "{{ $kelas->kode_kelas }}";
            $.ajax({
                type: 'POST',
                url: `/kelas/getkelassiswa`,
                data: {
                    _token: "{{ csrf_token() }}",
                    kode_kelas: kode_kelas
                },
                cache: false,
                success: function(respond) {
                    let no = 1;
                    $("#loadkelassiswa").html("");
                    $("#badgeCountSiswa").text(`${respond.length} Siswa`);

                    if(respond.length === 0) {
                        $("#loadkelassiswa").html(`
                            <tr>
                                <td colspan="4" class="p-10 text-center text-slate-400">
                                    <div class="w-12 h-12 rounded-2xl bg-slate-100 border border-slate-200 flex items-center justify-center mx-auto mb-2.5 text-slate-400 text-xl">
                                        <i class="ti ti-users-off"></i>
                                    </div>
                                    <h4 class="text-sm font-bold text-slate-800">Belum Ada Siswa di Kelas Ini</h4>
                                    <p class="text-xs text-slate-500 mt-0.5">Klik tombol "Tambah Siswa ke Kelas" di atas untuk menambahkan anggota.</p>
                                </td>
                            </tr>
                        `);
                        return;
                    }

                    respond.forEach(element => {
                        const avatarHtml = element.foto_pendaftaran ? 
                            `<img src="/storage/photos/pendaftaran/${element.foto_pendaftaran}" alt="${element.nama_lengkap}" class="w-7 h-8.5 rounded object-cover border border-slate-200 shrink-0">` : 
                            `<div class="w-7 h-8.5 rounded bg-emerald-50 border border-emerald-200 text-emerald-800 font-bold text-xs flex items-center justify-center shrink-0">${element.nama_lengkap.charAt(0).toUpperCase()}</div>`;

                        $("#loadkelassiswa").append(`
                            <tr class="hover:bg-slate-50/80 transition group">
                                <td class="py-2.5 px-3.5 text-center text-slate-400 font-bold text-xs">
                                    <span class="w-6 h-6 rounded-md bg-slate-100 group-hover:bg-emerald-50 group-hover:text-emerald-700 group-hover:border group-hover:border-emerald-200 inline-flex items-center justify-center font-bold text-slate-600 transition text-[11px]">
                                        ${no++}
                                    </span>
                                </td>
                                <td class="py-2.5 px-3.5 font-mono font-bold text-slate-800 text-xs">${element.nis ?? '-'}</td>
                                <td class="py-2.5 px-3.5">
                                    <div class="flex items-center gap-2.5">
                                        ${avatarHtml}
                                        <div>
                                            <span class="font-bold text-slate-900 group-hover:text-emerald-800 transition text-xs sm:text-sm capitalize block">
                                                ${element.nama_lengkap.toLowerCase()}
                                            </span>
                                            <span class="text-[10px] text-slate-400 font-mono">ID: ${element.id_siswa}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-2.5 px-3.5 text-center">
                                    <button type="button" 
                                            class="w-7 h-7 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200/80 inline-flex items-center justify-center transition active:scale-95 hapuskelassiswa cursor-pointer shadow-2xs" 
                                            id_siswa="${element.id_siswa}" 
                                            data-nama="${element.nama_lengkap}"
                                            title="Keluarkan Siswa dari Kelas">
                                        <i class="ti ti-trash text-xs"></i>
                                    </button>
                                </td>
                            </tr>
                        `);
                    });
                }
            });
        }

        getkelassiswa();    

        // Add student to class
        $(document).on("click", ".tambahsiswa", function(e) {
            e.preventDefault();
            const id_siswa = $(this).attr("id_siswa");
            const kode_kelas = "{{ $kelas->kode_kelas }}";
            const $btn = $(this);
            $btn.prop('disabled', true).html('<i class="ti ti-loader animate-spin text-xs"></i>');

            $.ajax({
                type: 'POST',
                url: `/kelas/storetambahsiswa`,
                data: {
                    _token: "{{ csrf_token() }}",
                    id_siswa: id_siswa,
                    kode_kelas: kode_kelas
                },
                cache: false,
                success: function(respond) {
                    if (respond.success) {
                        getSiswa();
                        getkelassiswa();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: respond.message
                        });
                        $btn.prop('disabled', false);
                    }
                },
                error: function() {
                    $btn.prop('disabled', false);
                }
            });
        });

        // Cancel student from class in modal
        $(document).on("click", ".hapussiswa", function(e) {
            e.preventDefault();
            const id_siswa = $(this).attr("id_siswa");
            const kode_kelas = "{{ $kelas->kode_kelas }}";
            const $btn = $(this);
            $btn.prop('disabled', true).html('<i class="ti ti-loader animate-spin text-xs"></i>');

            $.ajax({
                type: 'POST',
                url: `/kelas/deletesiswa`,
                data: {
                    _token: "{{ csrf_token() }}",
                    id_siswa: id_siswa,
                    kode_kelas: kode_kelas
                },
                cache: false,
                success: function(respond) {
                    if (respond.success) {
                        getSiswa();
                        getkelassiswa();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: respond.message
                        });
                        $btn.prop('disabled', false);
                    }
                },
                error: function() {
                    $btn.prop('disabled', false);
                }
            });
        });

        // Remove student from class table with SweetAlert2
        $(document).on("click", ".hapuskelassiswa", function(e) {
            e.preventDefault();
            const id_siswa = $(this).attr("id_siswa");
            const nama = $(this).data("nama") || 'siswa ini';
            const kode_kelas = "{{ $kelas->kode_kelas }}";
            
            Swal.fire({
                title: 'Keluarkan Siswa?',
                html: `
                    <div class="text-xs sm:text-sm text-slate-600 mt-2 space-y-2 text-center">
                        <p>Apakah Anda yakin ingin mengeluarkan siswa dari anggota kelas:</p>
                        <div class="p-2 bg-slate-50 border border-slate-200 rounded-xl font-bold text-slate-900 capitalize">
                            ${nama.toLowerCase()}
                        </div>
                    </div>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: '<i class="ti ti-trash mr-1"></i> Ya, Keluarkan',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-2xl shadow-2xl p-5',
                    title: 'text-base font-bold text-slate-900',
                    confirmButton: 'px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs rounded-xl shadow-xs transition cursor-pointer',
                    cancelButton: 'px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: `/kelas/deletekelassiswa`,
                        data: {
                            _token: "{{ csrf_token() }}",
                            id_siswa: id_siswa,
                            kode_kelas: kode_kelas
                        },
                        cache: false,
                        success: function(respond) {
                            if (respond.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: respond.message,
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                                getkelassiswa();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: respond.message
                                });
                            }
                        }
                    });
                }
            });
        });

        // Search debounce
        let typingTimer;
        const doneTypingInterval = 300; 
        const $input = $("#nama_siswa");

        $input.on("keyup", function() {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(getSiswa, doneTypingInterval);
        });

        $input.on("keydown", function() {
            clearTimeout(typingTimer);
        });
    });
</script>
@endpush

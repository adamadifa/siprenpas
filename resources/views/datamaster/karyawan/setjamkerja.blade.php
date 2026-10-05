<div class="space-y-5">

    <!-- ================= 1. INFORMASI PEGAWAI ================= -->
    <div class="bg-slate-50/80 border border-slate-200/90 rounded-xl p-4 sm:p-5">
        <div class="flex items-center gap-3.5">
            <div class="w-11 h-14 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-lg border border-emerald-200 shrink-0">
                @if (!empty($karyawan->foto) && Storage::disk('public')->exists('photos/karyawan/' . $karyawan->foto))
                    <img src="{{ getfotoKaryawan($karyawan->foto) }}" alt="{{ $karyawan->nama_lengkap }}" class="w-full h-full object-cover rounded-lg">
                @else
                    {{ strtoupper(substr($karyawan->nama_lengkap, 0, 1)) }}
                @endif
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex flex-wrap items-center gap-2">
                    <h4 class="text-sm sm:text-base font-bold text-slate-900 truncate">
                        {{ textCamelCase($karyawan->nama_lengkap) }}
                    </h4>
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-200 text-slate-700">
                        {{ $karyawan->npp }}
                    </span>
                </div>
                <p class="text-xs text-slate-500 mt-0.5">
                    Konfigurasi jam masuk, jam pulang, dan shift kerja harian maupun tanggal khusus.
                </p>
            </div>
        </div>
    </div>

    <!-- ================= 2. TAB NAVIGATION ================= -->
    <div class="flex border-b border-slate-200 gap-2">
        <button type="button" 
                id="tabBtnDay" 
                class="tab-btn pb-3 px-3 text-xs sm:text-sm font-bold border-b-2 border-emerald-600 text-emerald-700 flex items-center gap-2 transition cursor-pointer">
            <i class="ti ti-calendar-event text-base"></i>
            <span>Jadwal Harian (Reguler)</span>
        </button>
        <button type="button" 
                id="tabBtnDate" 
                class="tab-btn pb-3 px-3 text-xs sm:text-sm font-bold border-b-2 border-transparent text-slate-500 hover:text-slate-700 flex items-center gap-2 transition cursor-pointer">
            <i class="ti ti-calendar-time text-base"></i>
            <span>Jadwal Khusus (By Date)</span>
        </button>
    </div>

    <!-- ================= TAB CONTENT 1: REGULER BY DAY ================= -->
    <div id="tabContentDay" class="space-y-4">
        <form action="{{ route('karyawan.storejamkerjabyday', Crypt::encrypt($karyawan->npp)) }}" id="formSetJamkerja" method="POST" class="space-y-4" novalidate>
            @csrf

            <div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-2xs divide-y divide-slate-100">
                @php
                    $nama_hari = [
                        ['day' => 'Senin', 'icon' => 'ti-calendar'],
                        ['day' => 'Selasa', 'icon' => 'ti-calendar'],
                        ['day' => 'Rabu', 'icon' => 'ti-calendar'],
                        ['day' => 'Kamis', 'icon' => 'ti-calendar'],
                        ['day' => 'Jumat', 'icon' => 'ti-calendar'],
                        ['day' => 'Sabtu', 'icon' => 'ti-calendar-check'],
                        ['day' => 'Minggu', 'icon' => 'ti-calendar-x'],
                    ];
                @endphp

                @foreach ($nama_hari as $item)
                    @php
                        $hari = $item['day'];
                        $currentJam = array_key_exists($hari, $jamkerjabyday) ? $jamkerjabyday[$hari] : '';
                    @endphp
                    <div class="p-3 sm:p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3 hover:bg-slate-50/60 transition">
                        <!-- Day Label -->
                        <div class="flex items-center gap-2.5 sm:w-44 shrink-0">
                            <input type="hidden" name="hari[]" value="{{ $hari }}">
                            <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center text-sm font-bold border border-slate-200/80">
                                <i class="ti {{ $item['icon'] }}"></i>
                            </div>
                            <span class="text-sm font-bold text-slate-800">{{ $hari }}</span>
                        </div>

                        <!-- Jam Kerja Select -->
                        <div class="flex-1 min-w-0">
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                    <i class="ti ti-clock text-base"></i>
                                </div>
                                <select name="kode_jam_kerja[]" 
                                        class="w-full appearance-none pl-9 pr-9 py-2 text-xs sm:text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition cursor-pointer">
                                    <option value="">-- Libur / Tidak Ada Jadwal --</option>
                                    @foreach ($jamkerja as $d)
                                        <option value="{{ $d->kode_jam_kerja }}" {{ $currentJam == $d->kode_jam_kerja ? 'selected' : '' }}>
                                            {{ $d->nama_jam_kerja }} ({{ $d->jam_masuk }} - {{ $d->jam_pulang }})
                                        </option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400">
                                    <i class="ti ti-chevron-down text-sm"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Submit Button -->
            <div class="pt-4 border-t border-slate-200/90 flex flex-col-reverse sm:flex-row sm:items-center justify-end gap-2.5">
                <button type="button" class="w-full sm:w-auto px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer active:scale-95" data-bs-dismiss="modal">
                    Batal
                </button>
                <button type="submit" id="btnSimpanJamKerja" class="w-full sm:w-auto px-6 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center justify-center gap-2 cursor-pointer active:scale-95">
                    <i class="ti ti-device-floppy text-base"></i>
                    <span>Simpan Jadwal Harian</span>
                </button>
            </div>
        </form>
    </div>

    <!-- ================= TAB CONTENT 2: BY DATE ================= -->
    <div id="tabContentDate" class="space-y-4 hidden">
        <!-- Month & Year Filter Strip -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 p-3.5 bg-slate-50/80 border border-slate-200 rounded-xl">
            <div class="space-y-1">
                <label class="block text-xs font-semibold text-slate-600">Pilih Bulan</label>
                <div class="relative">
                    <select name="bulan" id="bulan" class="w-full appearance-none pl-3 pr-8 py-2 text-xs sm:text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition cursor-pointer">
                        <option value="">-- Pilih Bulan --</option>
                        @foreach ($list_bulan as $d)
                            <option {{ $d['kode_bulan'] == date('m') ? 'selected' : '' }} value="{{ $d['kode_bulan'] }}">
                                {{ $d['nama_bulan'] }}
                            </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400">
                        <i class="ti ti-chevron-down text-sm"></i>
                    </div>
                </div>
            </div>

            <div class="space-y-1">
                <label class="block text-xs font-semibold text-slate-600">Pilih Tahun</label>
                <div class="relative">
                    <select name="tahun" id="tahun" class="w-full appearance-none pl-3 pr-8 py-2 text-xs sm:text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition cursor-pointer">
                        <option value="">-- Pilih Tahun --</option>
                        @for ($t = $start_year; $t <= date('Y') + 1; $t++)
                            <option {{ $t == date('Y') ? 'selected' : '' }} value="{{ $t }}">{{ $t }}</option>
                        @endfor
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400">
                        <i class="ti ti-chevron-down text-sm"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Shift By Date Form -->
        <div class="p-4 bg-emerald-50/40 border border-emerald-200/80 rounded-xl space-y-3">
            <h5 class="text-xs font-bold text-emerald-950 flex items-center gap-1.5">
                <i class="ti ti-calendar-plus text-emerald-600 text-sm"></i>
                <span>Tambah Jadwal Khusus Tanggal</span>
            </h5>
            <form action="#" id="formJamkerjabydate" class="grid grid-cols-1 sm:grid-cols-12 gap-2.5 items-end">
                <div class="sm:col-span-5 space-y-1">
                    <label class="block text-[11px] font-semibold text-slate-600">Tanggal <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                            <i class="ti ti-calendar text-base"></i>
                        </div>
                        <input type="text" 
                               id="tanggal" 
                               name="tanggal" 
                               placeholder="Pilih tanggal..." 
                               autocomplete="off"
                               class="flatpickr-date w-full pl-9 pr-3.5 py-2 text-xs sm:text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition cursor-pointer">
                    </div>
                </div>

                <div class="sm:col-span-5 space-y-1">
                    <label class="block text-[11px] font-semibold text-slate-600">Shift Jam Kerja <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                            <i class="ti ti-clock text-base"></i>
                        </div>
                        <select name="kode_jam_kerja" id="kode_jam_kerja_bydate" class="w-full appearance-none pl-9 pr-8 py-2 text-xs sm:text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition cursor-pointer">
                            <option value="">-- Pilih Jam Kerja --</option>
                            @foreach ($jamkerja as $d)
                                <option value="{{ $d->kode_jam_kerja }}">{{ $d->nama_jam_kerja }} ({{ $d->jam_masuk }} - {{ $d->jam_pulang }})</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400">
                            <i class="ti ti-chevron-down text-sm"></i>
                        </div>
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <button type="button" id="btnAddjamkerjabydate" class="w-full py-2 px-3 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs rounded-lg shadow-xs transition flex items-center justify-center gap-1.5 cursor-pointer active:scale-95">
                        <i class="ti ti-plus text-sm"></i>
                        <span>Tambah</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Table Listing Schedules By Date -->
        <div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-2xs">
            <div class="p-3 bg-slate-50 border-b border-slate-200 flex items-center justify-between text-xs">
                <span class="font-bold text-slate-800">Daftar Jadwal Khusus Pada Bulan Ini</span>
                <span id="countByDate" class="text-slate-500 font-medium">0 jadwal</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-xs text-left">
                    <thead class="bg-slate-100/80 text-slate-700 font-bold border-b border-slate-200">
                        <tr>
                            <th class="py-2.5 px-4">Tanggal</th>
                            <th class="py-2.5 px-4">Shift Jam Kerja</th>
                            <th class="py-2.5 px-4 text-center w-16">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="getjamkerjabydate" class="divide-y divide-slate-100 text-slate-700">
                        <tr>
                            <td colspan="3" class="py-6 text-center text-slate-400">
                                <div class="w-6 h-6 border-2 border-emerald-500 border-t-transparent rounded-full animate-spin mx-auto mb-1.5"></div>
                                <span>Memuat data...</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script>
    $(document).ready(function() {
        if (typeof window.initFlatpickr === 'function') {
            window.initFlatpickr(document);
        } else if (typeof flatpickr !== 'undefined') {
            $(".flatpickr-date").each(function() {
                $(this).attr('autocomplete', 'off');
                flatpickr(this, {
                    dateFormat: "Y-m-d",
                    allowInput: true,
                    disableMobile: "true"
                });
            });
        }

        // Tab Switching
        $("#tabBtnDay").click(function() {
            $(this).addClass('border-emerald-600 text-emerald-700').removeClass('border-transparent text-slate-500');
            $("#tabBtnDate").removeClass('border-emerald-600 text-emerald-700').addClass('border-transparent text-slate-500');
            $("#tabContentDay").removeClass('hidden');
            $("#tabContentDate").addClass('hidden');
        });

        $("#tabBtnDate").click(function() {
            $(this).addClass('border-emerald-600 text-emerald-700').removeClass('border-transparent text-slate-500');
            $("#tabBtnDay").removeClass('border-emerald-600 text-emerald-700').addClass('border-transparent text-slate-500');
            $("#tabContentDate").removeClass('hidden');
            $("#tabContentDay").addClass('hidden');
            loadjamkerjabydate();
        });

        // Form Set Jam Kerja Reguler Submit
        $("#formSetJamkerja").submit(function() {
            $("#btnSimpanJamKerja").prop("disabled", true).html(
                `<div class="w-3.5 h-3.5 border-2 border-white border-t-transparent rounded-full animate-spin"></div> <span>Menyimpan...</span>`
            );
        });

        // Add Jam Kerja By Date
        const formJamkerjabydate = $("#formJamkerjabydate");
        $("#btnAddjamkerjabydate").click(function(e) {
            e.preventDefault();
            let npp = "{{ $karyawan->npp }}";
            let tanggal = formJamkerjabydate.find("#tanggal").val();
            let kode_jam_kerja = formJamkerjabydate.find("#kode_jam_kerja_bydate").val();

            if (!tanggal) {
                Swal.fire({
                    title: "Tanggal Wajib Diisi",
                    text: "Silakan pilih tanggal jadwal kerja terlebih dahulu!",
                    icon: "warning",
                    confirmButtonColor: '#059669',
                    customClass: { popup: 'rounded-2xl shadow-2xl' }
                });
                return false;
            }

            if (!kode_jam_kerja) {
                Swal.fire({
                    title: "Jam Kerja Wajib Dipilih",
                    text: "Silakan pilih shift jam kerja yang ingin diterapkan!",
                    icon: "warning",
                    confirmButtonColor: '#059669',
                    customClass: { popup: 'rounded-2xl shadow-2xl' }
                });
                return false;
            }

            const $btn = $(this);
            $btn.prop('disabled', true).html('<div class="w-3.5 h-3.5 border-2 border-white border-t-transparent rounded-full animate-spin"></div>');

            $.ajax({
                type: 'POST',
                url: "{{ route('karyawan.storejamkerjabydate') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    npp: npp,
                    tanggal: tanggal,
                    kode_jam_kerja: kode_jam_kerja
                },
                cache: false,
                success: function(respond) {
                    $btn.prop('disabled', false).html('<i class="ti ti-plus text-sm"></i> <span>Tambah</span>');
                    if (respond.success == false) {
                        Swal.fire({
                            title: "Perhatian",
                            text: respond.message,
                            icon: "warning",
                            confirmButtonColor: '#059669',
                            customClass: { popup: 'rounded-2xl shadow-2xl' }
                        });
                    } else {
                        Swal.fire({
                            title: "Berhasil!",
                            text: "Jadwal kerja khusus berhasil ditambahkan",
                            icon: "success",
                            timer: 1500,
                            showConfirmButton: false,
                            customClass: { popup: 'rounded-2xl shadow-2xl' }
                        });
                        formJamkerjabydate.find("#tanggal").val("");
                        formJamkerjabydate.find("#kode_jam_kerja_bydate").val("");
                        loadjamkerjabydate();
                    }
                },
                error: function(xhr) {
                    $btn.prop('disabled', false).html('<i class="ti ti-plus text-sm"></i> <span>Tambah</span>');
                    Swal.fire({
                        title: "Gagal Menambahkan",
                        text: xhr.responseJSON?.message || "Terjadi kesalahan server",
                        icon: "error",
                        confirmButtonColor: '#e11d48',
                        customClass: { popup: 'rounded-2xl shadow-2xl' }
                    });
                }
            });
        });

        $("#bulan, #tahun").change(function() {
            loadjamkerjabydate();
        });

        function loadjamkerjabydate() {
            let bulan = $("#bulan").val();
            let tahun = $("#tahun").val();
            let npp = "{{ $karyawan->npp }}";

            $("#getjamkerjabydate").html(`
                <tr>
                    <td colspan="3" class="py-6 text-center text-slate-400">
                        <div class="w-6 h-6 border-2 border-emerald-500 border-t-transparent rounded-full animate-spin mx-auto mb-1.5"></div>
                        <span>Memuat data jadwal...</span>
                    </td>
                </tr>
            `);

            $.ajax({
                type: 'POST',
                url: "{{ route('karyawan.getjamkerjabydate') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    npp: npp,
                    bulan: bulan,
                    tahun: tahun
                },
                cache: false,
                success: function(respond) {
                    $("#getjamkerjabydate").html("");
                    $("#countByDate").text(respond.length + " jadwal");

                    if (respond.length === 0) {
                        $("#getjamkerjabydate").html(`
                            <tr>
                                <td colspan="3" class="py-8 text-center text-slate-400">
                                    <i class="ti ti-calendar-off text-2xl block mb-1"></i>
                                    <span>Belum ada jadwal khusus pada bulan ini</span>
                                </td>
                            </tr>
                        `);
                        return;
                    }

                    respond.forEach(function(d) {
                        $("#getjamkerjabydate").append(`
                            <tr class="hover:bg-slate-50 transition">
                                <td class="py-2.5 px-4 font-bold text-slate-800 flex items-center gap-1.5">
                                    <i class="ti ti-calendar text-emerald-600 text-sm"></i>
                                    <span>${d.tanggal}</span>
                                </td>
                                <td class="py-2.5 px-4 font-medium text-slate-700">
                                    <span class="font-bold text-slate-900">${d.nama_jam_kerja}</span>
                                    <span class="text-slate-400 ml-1">(${d.jam_masuk} - ${d.jam_pulang})</span>
                                </td>
                                <td class="py-2.5 px-4 text-center">
                                    <button type="button" 
                                            class="w-7 h-7 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200 inline-flex items-center justify-center transition active:scale-95 deletejamkerjabydate cursor-pointer" 
                                            tanggal="${d.tanggal}" 
                                            npp="${d.npp}"
                                            title="Hapus Jadwal Tanggal Ini">
                                        <i class="ti ti-trash text-xs"></i>
                                    </button>
                                </td>
                            </tr>
                        `);
                    });
                },
                error: function() {
                    $("#getjamkerjabydate").html(`
                        <tr>
                            <td colspan="3" class="py-4 text-center text-rose-500">
                                Gagal memuat data jadwal khusus
                            </td>
                        </tr>
                    `);
                }
            });
        }

        // Delete Jam Kerja By Date with SweetAlert2
        $(document).on("click", ".deletejamkerjabydate", function(e) {
            e.preventDefault();
            let tanggal = $(this).attr("tanggal");
            let npp = $(this).attr("npp");

            Swal.fire({
                title: "Hapus Jadwal Tanggal Ini?",
                html: `Jadwal khusus tanggal <strong>${tanggal}</strong> akan dihapus dari sistem.`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#e11d48",
                cancelButtonColor: "#64748b",
                confirmButtonText: "Ya, Hapus",
                cancelButtonText: "Batal",
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
                        url: "{{ route('karyawan.deletejamkerjabydate') }}",
                        type: "POST",
                        data: {
                            npp: npp,
                            tanggal: tanggal,
                            _token: "{{ csrf_token() }}",
                        },
                        success: function(response) {
                            Swal.fire({
                                title: "Berhasil!",
                                text: response.message,
                                icon: "success",
                                timer: 1200,
                                showConfirmButton: false,
                                customClass: { popup: 'rounded-2xl shadow-2xl' }
                            });
                            loadjamkerjabydate();
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: "Gagal Menghapus",
                                text: xhr.responseJSON?.message || "Terjadi kesalahan",
                                icon: "error",
                                customClass: { popup: 'rounded-2xl shadow-2xl' }
                            });
                        },
                    });
                }
            });
        });
    });
</script>

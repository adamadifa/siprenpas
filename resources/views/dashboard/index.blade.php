@extends('layouts.app')
@section('titlepage', 'Dashboard Eksekutif')

@section('content')
<div class="space-y-6">

    <!-- ================= 1. EXECUTIVE WELCOME HEADER ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs">
        <div class="flex items-start sm:items-center gap-4">
            <!-- User Avatar -->
            <div class="relative w-12 h-12 rounded-2xl bg-gradient-to-tr from-amber-500 via-orange-500 to-rose-500 flex items-center justify-center text-white font-extrabold text-base shadow-sm overflow-hidden flex-shrink-0">
                @if (auth()->check() && auth()->user()->foto)
                    <img src="{{ asset('storage/' . auth()->user()->foto) }}" alt="Avatar" class="w-full h-full object-cover">
                @else
                    <span>{{ auth()->check() ? strtoupper(substr(auth()->user()->name, 0, 2)) : 'AD' }}</span>
                @endif
                <span class="absolute bottom-0 right-0 w-3 h-3 bg-emerald-500 border-2 border-white rounded-full"></span>
            </div>

            <div>
                <div class="flex items-center gap-2.5 flex-wrap">
                    <h1 class="text-lg sm:text-xl font-extrabold text-slate-900 tracking-tight flex items-center gap-2">
                        <span>Selamat Datang, {{ auth()->user()->name }}</span>
                        <span class="inline-block animate-wave origin-[70%_70%]">👋</span>
                    </h1>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        {{ auth()->user()->getRoleNames()->first() ?? 'Pengguna' }}
                    </span>
                </div>
                <div class="flex items-center gap-2 text-xs text-slate-500 mt-1 flex-wrap">
                    <span class="font-medium text-slate-700">{{ $pengaturan->nama_sekolah ?? 'Pesantren Persatuan Islam 80 Al Amin' }}</span>
                    <span class="text-slate-300">•</span>
                    <span>Monitoring Administrasi & Kesiapan 4 Pilar Data</span>
                </div>
            </div>
        </div>

        <!-- Live Clock & Date Widget -->
        <div class="flex items-center gap-3 self-end md:self-auto bg-slate-50 border border-slate-200/80 rounded-xl px-4 py-2.5 text-right">
            <div class="w-9 h-9 rounded-lg bg-orange-100/60 text-orange-600 flex items-center justify-center text-lg flex-shrink-0">
                <i class="ti ti-clock-play"></i>
            </div>
            <div>
                <div id="currentDate" class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider"></div>
                <div id="currentTime" class="text-base sm:text-lg font-extrabold text-slate-900 font-mono tracking-tight leading-none mt-0.5"></div>
            </div>
        </div>
    </div>

    <!-- ================= 2. FILTER TOOLBAR CARD ================= -->
    <div class="bg-white border border-slate-200/80 rounded-2xl p-4 sm:p-5 shadow-xs">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            
            <!-- Left Info -->
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-orange-50 text-orange-600 border border-orange-200/60 flex items-center justify-center text-xl flex-shrink-0">
                    <i class="ti ti-chart-dots-3"></i>
                </div>
                <div>
                    <h2 class="text-sm sm:text-base font-bold text-slate-900 leading-snug">Monitoring Kesiapan 4 Pilar Data</h2>
                    <p class="text-xs text-slate-500">Evaluasi kurikulum, jadwal pelajaran, kelengkapan santri & ploting rombel</p>
                </div>
            </div>

            <!-- Right Controls -->
            <div class="flex flex-wrap items-center gap-2.5">
                <!-- Filter Tahun Ajaran -->
                <div class="relative flex items-center">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i class="ti ti-calendar text-sm"></i>
                    </div>
                    <select id="filter_kode_ta" 
                            class="pl-8 pr-8 py-2 text-xs font-semibold bg-slate-50 hover:bg-slate-100/80 focus:bg-white border border-slate-200 rounded-xl text-slate-800 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition cursor-pointer">
                        @foreach ($tahunajaran as $ta)
                            <option value="{{ $ta->kode_ta }}" {{ ($activeTa && $activeTa->kode_ta == $ta->kode_ta) ? 'selected' : '' }}>
                                TA {{ $ta->tahun_ajaran }} {{ $ta->status == '1' ? '(Aktif)' : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Unit (Jika Super Admin / Semua Unit) -->
                @if (auth()->user()->kode_unit == 'U06' || auth()->user()->hasRole('super admin'))
                    <div class="relative flex items-center">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <i class="ti ti-school text-sm"></i>
                        </div>
                        <select id="filter_kode_unit" 
                                class="pl-8 pr-8 py-2 text-xs font-semibold bg-slate-50 hover:bg-slate-100/80 focus:bg-white border border-slate-200 rounded-xl text-slate-800 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition cursor-pointer">
                            <option value="">Semua Unit / Jenjang</option>
                            @foreach ($units as $u)
                                <option value="{{ $u->kode_unit }}">{{ $u->nama_unit }}</option>
                            @endforeach
                        </select>
                    </div>
                @else
                    <input type="hidden" id="filter_kode_unit" value="{{ auth()->user()->kode_unit }}">
                @endif

                <!-- Refresh Button -->
                <button type="button" 
                        id="btnRefreshReport" 
                        class="px-4 py-2 bg-slate-900 hover:bg-slate-800 active:scale-95 text-white text-xs font-semibold rounded-xl transition-all duration-150 shadow-xs flex items-center gap-1.5 cursor-pointer">
                    <i class="ti ti-refresh text-sm transition-transform duration-300" id="refreshIcon"></i>
                    <span>Segarkan Data</span>
                </button>
            </div>

        </div>
    </div>

    <!-- ================= 3. CONTAINER AJAX REPORT KELENGKAPAN ================= -->
    <div id="loadReportKelengkapan" class="transition-opacity duration-200">
        <!-- Skeleton Loading Card -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-10 text-center shadow-xs">
            <div class="w-12 h-12 border-3 border-orange-500 border-t-transparent rounded-full animate-spin mx-auto mb-4"></div>
            <h3 class="text-sm font-bold text-slate-800">Menghitung Kesiapan 4 Pilar Data...</h3>
            <p class="text-xs text-slate-400 mt-1 max-w-md mx-auto">Memvalidasi kurikulum, jadwal pelajaran, kelengkapan berkas santri & ploting rombel per jenjang.</p>
        </div>
    </div>

    <!-- ================= 4. MODAL DRILL-DOWN REPORT ================= -->
    <div class="modal fade" id="modalDetailReport" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-2xl rounded-2xl overflow-hidden" id="modalDetailReportContent">
                <div class="p-8 text-center bg-white">
                    <div class="w-10 h-10 border-3 border-orange-500 border-t-transparent rounded-full animate-spin mx-auto mb-3"></div>
                    <p class="text-xs font-bold text-slate-700">Memuat Detail Data...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= 5. MODAL EDIT SISWA IN-PLACE ================= -->
    <x-modal-form id="modalEditSiswa" size="modal-lg" show="loadmodaleditsiswa" title="Edit Data Siswa" icon="ti ti-user-edit" />
    <x-modal-form id="modalSekolah" size="" show="loadmodal" title="" icon="ti ti-school" />

</div>
@endsection

@push('myscript')
<script>
    $(function() {
        // Realtime Clock & Date Update
        function updateDateTime() {
            const now = new Date();
            const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

            const dayName = days[now.getDay()];
            const day = String(now.getDate()).padStart(2, '0');
            const monthName = months[now.getMonth()];
            const year = now.getFullYear();

            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');

            $('#currentDate').text(`${dayName}, ${day} ${monthName} ${year}`);
            $('#currentTime').text(`${hours}:${minutes}:${seconds}`);
        }

        updateDateTime();
        setInterval(updateDateTime, 1000);

        // AJAX REPORT KELENGKAPAN 4 PILAR DATA
        function getReportKelengkapan() {
            let kode_ta = $('#filter_kode_ta').val();
            let kode_unit = $('#filter_kode_unit').val();
            let $refreshIcon = $('#refreshIcon');

            $refreshIcon.addClass('animate-spin');

            $("#loadReportKelengkapan").html(`
                <div class="bg-white border border-slate-200/80 rounded-2xl p-10 text-center shadow-xs">
                    <div class="w-12 h-12 border-3 border-orange-500 border-t-transparent rounded-full animate-spin mx-auto mb-4"></div>
                    <h3 class="text-sm font-bold text-slate-800">Menghitung Kesiapan 4 Pilar Data...</h3>
                    <p class="text-xs text-slate-400 mt-1 max-w-md mx-auto">
                        Tahun Ajaran: <span class="font-bold text-slate-700">${$('#filter_kode_ta option:selected').text().trim()}</span>
                    </p>
                </div>
            `);

            $.ajax({
                method: "POST",
                url: "{{ route('dashboard.getReportKelengkapan') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    kode_ta: kode_ta,
                    kode_unit: kode_unit
                },
                cache: false,
                success: function(response) {
                    $refreshIcon.removeClass('animate-spin');
                    $('#loadReportKelengkapan').html(response);
                },
                error: function(xhr) {
                    $refreshIcon.removeClass('animate-spin');
                    $('#loadReportKelengkapan').html(`
                        <div class="p-4 bg-rose-50 border border-rose-200 rounded-2xl text-rose-700 text-xs flex items-center gap-3">
                            <i class="ti ti-alert-circle text-xl flex-shrink-0"></i>
                            <div>
                                <strong>Gagal memuat rekap kelengkapan data.</strong> Silakan klik Segarkan Data atau periksa koneksi.
                            </div>
                        </div>
                    `);
                }
            });
        }

        $('#filter_kode_ta, #filter_kode_unit').on('change', function() {
            getReportKelengkapan();
        });

        $('#btnRefreshReport').on('click', function() {
            getReportKelengkapan();
        });

        // Initial Load
        getReportKelengkapan();

        // DRILL-DOWN MODALS HANDLER
        // 1. Santri Belum Lengkap
        $(document).on('click', '.btn-view-santri-belum-lengkap', function() {
            let kode_unit = $(this).data('kode-unit');
            let kode_ta = $('#filter_kode_ta').val();

            $('#modalDetailReportContent').html(`
                <div class="p-8 text-center bg-white">
                    <div class="w-10 h-10 border-3 border-amber-500 border-t-transparent rounded-full animate-spin mx-auto mb-3"></div>
                    <div class="text-xs font-bold text-slate-800">Memuat Data Santri Belum Lengkap...</div>
                </div>
            `);
            $('#modalDetailReport').modal('show');

            $.ajax({
                method: "POST",
                url: "{{ route('dashboard.getDetailSantriBelumLengkap') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    kode_unit: kode_unit,
                    kode_ta: kode_ta
                },
                success: function(html) {
                    $('#modalDetailReportContent').html(html);
                },
                error: function() {
                    $('#modalDetailReportContent').html(`
                        <div class="p-6 text-center text-rose-600 text-xs">
                            <i class="ti ti-alert-circle text-3xl block mb-2 mx-auto"></i>
                            Gagal mengambil detail data santri.
                        </div>
                    `);
                }
            });
        });

        // 2. Santri Belum Ploting Kelas
        $(document).on('click', '.btn-view-santri-belum-plot', function() {
            let kode_unit = $(this).data('kode-unit');
            let kode_ta = $('#filter_kode_ta').val();

            $('#modalDetailReportContent').html(`
                <div class="p-8 text-center bg-white">
                    <div class="w-10 h-10 border-3 border-blue-500 border-t-transparent rounded-full animate-spin mx-auto mb-3"></div>
                    <div class="text-xs font-bold text-slate-800">Memuat Data Santri Belum Masuk Rombel...</div>
                </div>
            `);
            $('#modalDetailReport').modal('show');

            $.ajax({
                method: "POST",
                url: "{{ route('dashboard.getDetailSantriBelumPlot') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    kode_unit: kode_unit,
                    kode_ta: kode_ta
                },
                success: function(html) {
                    $('#modalDetailReportContent').html(html);
                },
                error: function() {
                    $('#modalDetailReportContent').html(`
                        <div class="p-6 text-center text-rose-600 text-xs">
                            <i class="ti ti-alert-circle text-3xl block mb-2 mx-auto"></i>
                            Gagal mengambil detail data santri.
                        </div>
                    `);
                }
            });
        });

        // 3. Detail Jadwal Per Kelas
        $(document).on('click', '.btn-view-jadwal', function() {
            let kode_unit = $(this).data('kode-unit');
            let kode_ta = $('#filter_kode_ta').val();

            $('#modalDetailReportContent').html(`
                <div class="p-8 text-center bg-white">
                    <div class="w-10 h-10 border-3 border-emerald-500 border-t-transparent rounded-full animate-spin mx-auto mb-3"></div>
                    <div class="text-xs font-bold text-slate-800">Memuat Data Jadwal Kelas...</div>
                </div>
            `);
            $('#modalDetailReport').modal('show');

            $.ajax({
                method: "POST",
                url: "{{ route('dashboard.getDetailJadwalKelas') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    kode_unit: kode_unit,
                    kode_ta: kode_ta
                },
                success: function(html) {
                    $('#modalDetailReportContent').html(html);
                },
                error: function() {
                    $('#modalDetailReportContent').html(`
                        <div class="p-6 text-center text-rose-600 text-xs">
                            <i class="ti ti-alert-circle text-3xl block mb-2 mx-auto"></i>
                            Gagal mengambil detail jadwal kelas.
                        </div>
                    `);
                }
            });
        });

        // 4. Modal Edit Santri In-Place
        $(document).on('click', '.btn-edit-siswa-modal', function(e) {
            e.preventDefault();
            let no_pendaftaran = $(this).data('no-pendaftaran');
            $('#modalEditSiswa').modal('show');
            $('#modalEditSiswa').find('.modal-title').text('Edit Pendaftaran & Data Siswa');
            $('#loadmodaleditsiswa').html(`
                <div class="p-8 text-center">
                    <div class="w-10 h-10 border-3 border-orange-500 border-t-transparent rounded-full animate-spin mx-auto mb-3"></div>
                    <div class="text-xs font-semibold text-slate-500">Memuat Formulir Pendaftaran Siswa...</div>
                </div>
            `);
            $('#loadmodaleditsiswa').load(`/pendaftaran/${no_pendaftaran}/edit`);
        });
    });
</script>
@endpush

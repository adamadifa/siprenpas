@extends('layouts.app')
@section('titlepage', 'Checklist Ibadah Saya')

@section('content')
<div class="space-y-6">

    <!-- ================= 1. PAGE HEADER & BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <!-- Title & Subtitle -->
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-xl shrink-0 font-bold border border-emerald-200 shadow-2xs">
                <i class="ti ti-heart-handshake"></i>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">
                    Checklist Ibadah Saya
                </h1>
                <p class="text-xs text-slate-500 font-medium">
                    Pantau mutaba'ah harian, isi amal ibadah Anda secara teratur dan konsisten setiap hari
                </p>
            </div>
        </div>

        <!-- Breadcrumb & Quick Action -->
        <div class="flex flex-col md:items-end gap-2.5">
            <nav class="flex items-center text-xs text-slate-400 font-medium">
                <a href="{{ route('dashboard.index') }}" class="hover:text-slate-700 transition flex items-center gap-1">
                    <i class="ti ti-home text-sm"></i>
                    <span>Dashboard</span>
                </a>
                <span class="mx-2 text-slate-300">/</span>
                <span class="text-slate-500">MSDM & Layanan</span>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Checklist Ibadah</span>
            </nav>

            <div class="flex items-center gap-2">
                <a href="{{ route('laporanmsdm.index') }}" 
                   class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-white hover:bg-slate-50 text-slate-700 font-semibold rounded-lg text-xs border border-slate-200 shadow-2xs transition active:scale-95 cursor-pointer">
                    <i class="ti ti-file-analytics text-sm text-emerald-600"></i>
                    <span>Rekap Laporan</span>
                </a>
            </div>
        </div>
    </div>

    <!-- ================= 2. EMPLOYEE EXECUTIVE SHOWCASE PROFILE CARD ================= -->
    @if(!empty($karyawan))
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-emerald-800 via-emerald-700 to-teal-700 p-5 sm:p-6 text-white shadow-lg shadow-emerald-900/15 border border-emerald-600/30">
            <!-- Decorative Glow & Watermark -->
            <div class="absolute -right-10 -bottom-10 w-48 h-48 rounded-full bg-white/5 blur-2xl pointer-events-none"></div>
            <div class="absolute right-8 top-1/2 -translate-y-1/2 opacity-10 pointer-events-none">
                <i class="ti ti-sparkles text-9xl"></i>
            </div>

            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                <!-- User Identity -->
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-white/10 backdrop-blur-md p-1 border border-white/25 shadow-inner flex items-center justify-center shrink-0 overflow-hidden">
                        @if (!empty($karyawan->foto) && file_exists(public_path('storage/' . $karyawan->foto)))
                            <img src="{{ asset('storage/' . $karyawan->foto) }}" alt="Foto" class="w-full h-full object-cover rounded-xl">
                        @else
                            <div class="w-full h-full rounded-xl bg-emerald-600/50 flex items-center justify-center text-white font-extrabold text-xl">
                                {{ strtoupper(substr($karyawan->nama_lengkap ?? 'U', 0, 2)) }}
                            </div>
                        @endif
                    </div>
                    <div class="min-w-0">
                        <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-500/30 border border-emerald-400/30 text-[10px] font-bold text-emerald-200 uppercase tracking-wider mb-1">
                            <i class="ti ti-user-check text-xs"></i>
                            <span>Mutaba'ah Personel</span>
                        </div>
                        <h2 class="text-lg sm:text-xl font-black text-white tracking-tight leading-tight truncate">
                            {{ $karyawan->nama_lengkap }}
                        </h2>
                        <div class="flex items-center gap-2 mt-0.5 text-xs text-emerald-100/80 font-medium">
                            <span>NPP: <b class="text-white font-mono">{{ $karyawan->npp }}</b></span>
                        </div>
                    </div>
                </div>

                <!-- Position Badges with Floating Vertical Dividers -->
                <div class="flex flex-wrap items-center gap-3 sm:gap-4">
                    <!-- Jabatan -->
                    <div class="flex items-center gap-3 px-3.5 py-2 rounded-xl bg-white/10 backdrop-blur-md border border-white/15">
                        <div class="w-8 h-8 rounded-lg bg-emerald-500/20 text-emerald-300 flex items-center justify-center shrink-0">
                            <i class="ti ti-briefcase text-base"></i>
                        </div>
                        <div class="min-w-0">
                            <span class="block text-[9px] font-bold uppercase tracking-wider text-emerald-200/75">Jabatan</span>
                            <span class="block text-xs font-bold text-white truncate">{{ strtoupper($karyawan->nama_jabatan) }}</span>
                        </div>
                    </div>

                    <!-- Departemen -->
                    <div class="flex items-center gap-3 px-3.5 py-2 rounded-xl bg-white/10 backdrop-blur-md border border-white/15">
                        <div class="w-8 h-8 rounded-lg bg-teal-500/20 text-teal-300 flex items-center justify-center shrink-0">
                            <i class="ti ti-hierarchy-2 text-base"></i>
                        </div>
                        <div class="min-w-0">
                            <span class="block text-[9px] font-bold uppercase tracking-wider text-emerald-200/75">Departemen</span>
                            <span class="block text-xs font-bold text-white truncate">{{ strtoupper($karyawan->nama_dept) }}</span>
                        </div>
                    </div>

                    <!-- Unit Kerja -->
                    <div class="flex items-center gap-3 px-3.5 py-2 rounded-xl bg-white/10 backdrop-blur-md border border-white/15">
                        <div class="w-8 h-8 rounded-lg bg-emerald-400/20 text-emerald-200 flex items-center justify-center shrink-0">
                            <i class="ti ti-building text-base"></i>
                        </div>
                        <div class="min-w-0">
                            <span class="block text-[9px] font-bold uppercase tracking-wider text-emerald-200/75">Unit Kerja</span>
                            <span class="block text-xs font-bold text-white truncate">{{ strtoupper($karyawan->nama_unit) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- ================= 3. INTERACTIVE CALENDAR STRIP & PROGRESS GAUGES ================= -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-4">
        
        <!-- Left: Interactive Weekly Date Strip (8 Cols) -->
        <div class="lg:col-span-8 bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs flex flex-col justify-between">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg shrink-0 border border-emerald-100">
                        <i class="ti ti-calendar-event"></i>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold text-emerald-700 uppercase tracking-wider" id="selected-day-name">HARI INI</span>
                        <h3 class="text-base sm:text-lg font-bold text-slate-800" id="selected-date-indo">15 Agustus 2026</h3>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <!-- Hidden HTML5 native date picker -->
                    <input type="date" class="hidden" name="tanggal" id="datePicker" value="{{ date('Y-m-d') }}" />
                    <button type="button" id="btn-show-picker" 
                            class="inline-flex items-center gap-1.5 px-3 py-2 bg-slate-50 hover:bg-slate-100 active:scale-95 text-slate-700 font-semibold rounded-xl text-xs border border-slate-200 shadow-2xs transition cursor-pointer">
                        <i class="ti ti-calendar text-emerald-600 text-sm"></i>
                        <span>Pilih Tanggal Lain</span>
                    </button>
                </div>
            </div>

            <!-- Weekly Strip Container (Rendered dynamically via JS) -->
            <div class="grid grid-cols-7 gap-2 pt-1" id="weekly-strip-container">
                <!-- Days 1 to 7 rendered via JS -->
            </div>
        </div>

        <!-- Right: Realtime Mutaba'ah Progress Gauge (4 Cols) -->
        <div class="lg:col-span-4 bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between gap-2 mb-2">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-base border border-emerald-100">
                            <i class="ti ti-chart-donut-2"></i>
                        </div>
                        <h4 class="text-sm font-bold text-slate-800">Progress Mutaba'ah</h4>
                    </div>
                    <span class="text-xs font-black text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-200/60" id="progress-percent-display">0%</span>
                </div>
                <p class="text-xs text-slate-500 font-medium">
                    Amal ibadah yang telah diselesaikan untuk hari ini.
                </p>
            </div>

            <div class="mt-4 pt-3 border-t border-slate-100 space-y-2">
                <div class="flex items-center justify-between text-xs">
                    <span class="font-semibold text-slate-600" id="progress-text-display">0 dari 0 kegiatan</span>
                    <span class="text-[11px] font-bold text-slate-400">Target 100%</span>
                </div>
                <!-- Progress Bar -->
                <div class="w-full h-3 bg-slate-100 rounded-full overflow-hidden p-0.5 border border-slate-200/60">
                    <div id="progress-bar-display" 
                         class="h-full bg-gradient-to-r from-emerald-600 to-teal-500 rounded-full transition-all duration-500 ease-out shadow-xs" 
                         style="width: 0%;"></div>
                </div>
            </div>
        </div>

    </div>

    <!-- ================= 4. CHECKLIST ITEMS CONTENT CONTAINER (LOADED VIA AJAX) ================= -->
    <div id="loadchecklistibadah">
        <!-- Default Loading Skeleton / Spinner State -->
        <div class="p-12 text-center bg-white border border-slate-200/80 rounded-2xl shadow-xs">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 mb-3 animate-spin">
                <i class="ti ti-loader-2 text-2xl"></i>
            </div>
            <h4 class="text-sm font-bold text-slate-800">Memuat Butir Mutaba'ah...</h4>
            <p class="text-xs text-slate-400 font-medium mt-1">Mengambil daftar kegiatan ibadah harian Anda</p>
        </div>
    </div>

</div>
@endsection

@push('myscript')
<script>
    $(function() {
        // Datepicker trigger
        $('#btn-show-picker').click(function() {
            $('#datePicker').click();
        });

        // Event listener for date picker change
        $('#datePicker').change(function() {
            var selectedDate = $(this).val();
            updateDateDisplays(selectedDate);
            renderWeeklyStrip(selectedDate);
            loadchecklistibadah(selectedDate);
        });

        // Initial load
        var initialDate = $('#datePicker').val();
        updateDateDisplays(initialDate);
        renderWeeklyStrip(initialDate);
        loadchecklistibadah(initialDate);

        // Update visual display text
        function updateDateDisplays(dateStr) {
            const dateObj = new Date(dateStr);
            const daysLong = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const monthsLong = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            
            $('#selected-day-name').text(daysLong[dateObj.getDay()].toUpperCase());
            $('#selected-date-indo').text(dateObj.getDate() + ' ' + monthsLong[dateObj.getMonth()] + ' ' + dateObj.getFullYear());
        }

        // Render sleek weekly strip
        function renderWeeklyStrip(selectedDateStr) {
            const current = new Date(selectedDateStr);
            const startOfWeek = new Date(current);
            const day = current.getDay();
            // Set to Monday of selected week
            const diff = current.getDate() - day + (day === 0 ? -6 : 1);
            startOfWeek.setDate(diff);

            const names = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
            let html = '';

            for (let i = 0; i < 7; i++) {
                const dateObj = new Date(startOfWeek);
                dateObj.setDate(startOfWeek.getDate() + i);
                
                // Format YYYY-MM-DD
                const offset = dateObj.getTimezoneOffset();
                const localDateObj = new Date(dateObj.getTime() - (offset * 60 * 1000));
                const dateStr = localDateObj.toISOString().split('T')[0];
                
                const dayNum = dateObj.getDate();
                const isActive = (dateStr === selectedDateStr);

                if (isActive) {
                    html += `
                        <button type="button" 
                                class="week-day-btn py-3 px-1 rounded-xl flex flex-col items-center justify-center text-center transition cursor-pointer bg-gradient-to-b from-emerald-600 to-teal-700 text-white shadow-md shadow-emerald-700/20 border border-emerald-500" 
                                data-date="${dateStr}">
                            <span class="text-[10px] font-bold text-emerald-100 uppercase tracking-wider">${names[i]}</span>
                            <span class="text-base sm:text-lg font-black tracking-tight mt-0.5">${dayNum}</span>
                        </button>
                    `;
                } else {
                    html += `
                        <button type="button" 
                                class="week-day-btn py-3 px-1 rounded-xl flex flex-col items-center justify-center text-center transition cursor-pointer bg-slate-50 hover:bg-emerald-50/60 text-slate-700 hover:text-emerald-800 border border-slate-200/80 hover:border-emerald-300" 
                                data-date="${dateStr}">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">${names[i]}</span>
                            <span class="text-base sm:text-lg font-bold tracking-tight mt-0.5">${dayNum}</span>
                        </button>
                    `;
                }
            }
            $('#weekly-strip-container').html(html);
        }

        // Click handler for weekly strip days
        $(document).on('click', '.week-day-btn', function() {
            const dateStr = $(this).attr('data-date');
            $('#datePicker').val(dateStr);
            renderWeeklyStrip(dateStr);
            updateDateDisplays(dateStr);
            loadchecklistibadah(dateStr);
        });

        // Function to load checklist from server
        function loadchecklistibadah(date) {
            var tanggal = date || $("#datePicker").val();
            $.ajax({
                type: 'POST',
                url: '{{ route("checklistibadah.getchecklistibadah") }}',
                data: {
                    _token: "{{ csrf_token() }}",
                    tanggal: tanggal
                },
                cache: false,
                success: function(respond) {
                    $("#loadchecklistibadah").html(respond);
                    
                    // Update progress card from loaded view values
                    const percent = $('#ibadah-progress-percent').val() || 0;
                    const text = $('#ibadah-progress-text').val() || '0 dari 0 kegiatan';
                    
                    $('#progress-percent-display').text(percent + '%');
                    $('#progress-text-display').text(text);
                    $('#progress-bar-display').css('width', percent + '%');
                }
            });
        }

        // Checklist toggle handler
        $(document).on('change', '.checklist', function() {
            var tanggal = $("#datePicker").val();
            var id = $(this).attr("data-id");
            var kode = $(this).attr("data-kode");
            var checkbox = $(this);
            var parentDiv = checkbox.closest('.checklist-item-card');
            var iconCircle = parentDiv.find('.item-icon-wrapper');
            var iconItem = iconCircle.find('i');

            if (checkbox.prop("checked") == true) {
                // Instantly style optimistic update
                parentDiv.removeClass('bg-white border-slate-200/80').addClass('bg-emerald-50/70 border-emerald-300/80 ring-1 ring-emerald-500/20');
                iconCircle.removeClass('bg-slate-100 text-slate-400 border-slate-200').addClass('bg-emerald-100 text-emerald-700 border-emerald-300');
                iconItem.removeClass('ti-circle-dot').addClass('ti-check');

                $.ajax({
                    type: 'POST',
                    url: '{{ route("checklistibadah.store") }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        tanggal: tanggal,
                        id: id
                    },
                    cache: false,
                    success: function() {
                        loadchecklistibadah(tanggal);
                    }
                });
            } else {
                // Instantly style optimistic update
                parentDiv.removeClass('bg-emerald-50/70 border-emerald-300/80 ring-1 ring-emerald-500/20').addClass('bg-white border-slate-200/80');
                iconCircle.removeClass('bg-emerald-100 text-emerald-700 border-emerald-300').addClass('bg-slate-100 text-slate-400 border-slate-200');
                iconItem.removeClass('ti-check').addClass('ti-circle-dot');

                $.ajax({
                    type: 'POST',
                    url: '{{ route("checklistibadah.delete") }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        kode: kode,
                        id: id
                    },
                    cache: false,
                    success: function() {
                        loadchecklistibadah(tanggal);
                    }
                });
            }
        });
    });
</script>
@endpush

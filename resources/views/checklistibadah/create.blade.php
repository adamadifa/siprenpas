@extends('layouts.app')
@section('titlepage', 'Checklist Ibadah Saya')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-4">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md rounded-circle d-flex align-items-center justify-content-center" style="background-color: #e6f4ea; color: #064e3b">
                        <i class="ti ti-heart-handshake fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-1 fw-extrabold" style="color: #064e3b; letter-spacing: -0.5px;">Checklist Ibadah Saya</h4>
                        <p class="text-muted mb-0 small">Pantau mutaba'ah harian, isi amal ibadah Anda secara teratur setiap hari</p>
                    </div>
                </div>
                <div class="d-flex flex-column align-items-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mb-0">
                            <li class="breadcrumb-item">
                                <a href="javascript:void(0);" class="text-muted">
                                    <i class="ti ti-home-2 me-1"></i> Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item active fw-medium" style="color: #064e3b">
                                <i class="ti ti-heart-handshake me-1"></i> Checklist Ibadah
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    .week-day-btn {
        transition: all 0.2s ease;
        border: 1px solid rgba(0, 0, 0, 0.06);
        cursor: pointer;
        background-color: #ffffff;
        min-width: 55px;
    }
    .week-day-btn:hover {
        background-color: #f8f9fa;
        border-color: #064e3b;
    }
    .week-day-btn.active {
        background-color: #064e3b !important;
        color: #ffffff !important;
        border-color: #064e3b !important;
        box-shadow: 0 4px 8px rgba(6, 78, 59, 0.2);
    }
    .hover-bg-light {
        transition: all 0.2s ease-in-out;
    }
    .hover-bg-light:hover {
        background-color: #f8f9fa !important;
        transform: translateX(3px);
    }
</style>

<div class="row">
    <div class="col-lg-12">

        <!-- Employee Profile Summary Card -->
        @if(!empty($karyawan))
            <div class="card border-0 shadow-sm mb-4 rounded-3 overflow-hidden text-white" style="background: linear-gradient(135deg, #064e3b 0%, #043e2f 100%);">
                <div class="card-body p-4">
                    <div class="row align-items-center g-4">
                        <div class="col-auto">
                            <div class="avatar avatar-xl bg-white rounded-3 d-flex align-items-center justify-content-center" style="width: 70px; height: 70px; box-shadow: 0 4px 10px rgba(0,0,0,0.15);">
                                <i class="ti ti-user-check fs-2" style="color: #064e3b;"></i>
                            </div>
                        </div>
                        <div class="col-md">
                            <h4 class="fw-bold mb-1 text-white">{{ $karyawan->nama_lengkap }}</h4>
                            <p class="text-white-50 mb-0 small">NPP: <span class="fw-semibold text-white">{{ $karyawan->npp }}</span></p>
                        </div>
                        <div class="col-md-auto ms-md-auto">
                            <div class="d-flex flex-wrap gap-2">
                                <div class="d-flex align-items-center gap-3 px-3 py-2 rounded-3" style="background: rgba(255, 255, 255, 0.12) !important; border: 1px solid rgba(255, 255, 255, 0.08);">
                                    <i class="ti ti-briefcase text-white fs-4 flex-shrink-0"></i>
                                    <div style="line-height: 1.1;">
                                        <span class="text-white-50 text-uppercase d-block mb-1" style="font-size: 0.6rem; letter-spacing: 0.5px; font-weight: 500;">Jabatan</span>
                                        <span class="fw-bold text-white" style="font-size: 0.8rem; letter-spacing: 0.2px;">{{ strtoupper($karyawan->nama_jabatan) }}</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-3 px-3 py-2 rounded-3" style="background: rgba(255, 255, 255, 0.12) !important; border: 1px solid rgba(255, 255, 255, 0.08);">
                                    <i class="ti ti-hierarchy-2 text-white fs-4 flex-shrink-0"></i>
                                    <div style="line-height: 1.1;">
                                        <span class="text-white-50 text-uppercase d-block mb-1" style="font-size: 0.6rem; letter-spacing: 0.5px; font-weight: 500;">Departemen</span>
                                        <span class="fw-bold text-white" style="font-size: 0.8rem; letter-spacing: 0.2px;">{{ strtoupper($karyawan->nama_dept) }}</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-3 px-3 py-2 rounded-3" style="background: rgba(255, 255, 255, 0.12) !important; border: 1px solid rgba(255, 255, 255, 0.08);">
                                    <i class="ti ti-building text-white fs-4 flex-shrink-0"></i>
                                    <div style="line-height: 1.1;">
                                        <span class="text-white-50 text-uppercase d-block mb-1" style="font-size: 0.6rem; letter-spacing: 0.5px; font-weight: 500;">Unit Kerja</span>
                                        <span class="fw-bold text-white" style="font-size: 0.8rem; letter-spacing: 0.2px;">{{ strtoupper($karyawan->nama_unit) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="row g-4 mb-4">
            <!-- Left Side: Weekly Strip & Progress Card -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-3 p-4 bg-white">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <span class="text-muted small fw-bold text-uppercase d-block" id="selected-day-name">MINGGU</span>
                            <h5 class="fw-bold text-dark mb-0" id="selected-date-indo">15 Agustus 2026</h5>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <!-- Hidden date input for actual value -->
                            <input type="date" class="form-control tanggal d-none" name="tanggal" id="datePicker" value="{{ date('Y-m-d') }}" />
                            <button class="btn btn-light border d-flex align-items-center justify-content-center" id="btn-show-picker" style="height: 38px; border-radius: 8px;">
                                <i class="ti ti-calendar fs-5 me-1"></i> Pilih Tanggal
                            </button>
                        </div>
                    </div>

                    <!-- Weekly Date Strip -->
                    <div class="d-flex justify-content-between align-items-center gap-2 py-2 overflow-auto" id="weekly-strip-container">
                        <!-- Rendered by JS -->
                    </div>
                </div>
            </div>

            <!-- Right Side: Progress Card -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-3 p-4 bg-white h-100 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="ti ti-chart-donut text-success fs-4"></i>
                            <h6 class="fw-bold text-dark mb-0">Progress Mutaba'ah</h6>
                        </div>
                        <p class="text-muted small mb-3">Amal ibadah harian yang telah diselesaikan hari ini.</p>
                    </div>
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-bold text-dark" id="progress-text-display">0 dari 0 kegiatan</span>
                            <span class="fw-extrabold text-success" id="progress-percent-display" style="font-size: 1.2rem;">0%</span>
                        </div>
                        <div class="progress rounded-pill" style="height: 10px;">
                            <div class="progress-bar bg-success progress-bar-striped progress-bar-animated rounded-pill" role="progressbar" id="progress-bar-display" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Checklist Content Container -->
        <div id="loadchecklistibadah">
            <!-- Loaded via AJAX -->
            <div class="text-center py-5 bg-white rounded-3 shadow-sm">
                <div class="spinner-border text-success mb-3" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <h6 class="text-muted">Memuat daftar kegiatan ibadah...</h6>
            </div>
        </div>

    </div>
</div>

@endsection

@push('myscript')
<script>
    $(function() {
        // Set up Datepicker trigger
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

        // Initialize date displays
        var initialDate = $('#datePicker').val();
        updateDateDisplays(initialDate);
        renderWeeklyStrip(initialDate);
        loadchecklistibadah(initialDate);

        // Function to update visual dates
        function updateDateDisplays(dateStr) {
            const dateObj = new Date(dateStr);
            const daysLong = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const monthsLong = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            
            $('#selected-day-name').text(daysLong[dateObj.getDay()].toUpperCase());
            $('#selected-date-indo').text(dateObj.getDate() + ' ' + monthsLong[dateObj.getMonth()] + ' ' + dateObj.getFullYear());
        }

        // Function to render weekly strip
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
                const isActive = (dateStr === selectedDateStr) ? 'active' : '';

                html += `
                    <div class="week-day-btn rounded-3 p-2 d-flex flex-column align-items-center justify-content-center flex-grow-1 text-dark ${isActive}" data-date="${dateStr}">
                        <span class="small opacity-75 fw-bold" style="font-size: 0.7rem;">${names[i]}</span>
                        <span class="fs-5 fw-extrabold mt-1">${dayNum}</span>
                    </div>
                `;
            }
            $('#weekly-strip-container').html(html);
        }

        // Click handler for weekly strip days
        $(document).on('click', '.week-day-btn', function() {
            const dateStr = $(this).attr('data-date');
            $('#datePicker').val(dateStr);
            $('.week-day-btn').removeClass('active');
            $(this).addClass('active');
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
                    $('#progress-bar-display').css('width', percent + '%').attr('aria-valuenow', percent);
                }
            });
        }

        // Checklist toggle handler
        $(document).on('change', '.checklist', function() {
            var tanggal = $("#datePicker").val();
            var id = $(this).attr("data-id");
            var kode = $(this).attr("data-kode");
            var checkbox = $(this);
            var parentDiv = checkbox.closest('.hover-bg-light');
            var iconCircle = parentDiv.find('.rounded-circle');
            var iconItem = iconCircle.find('i');

            if (checkbox.prop("checked") == true) {
                // Instantly style optimistic update
                parentDiv.css('background-color', '#f3fdf6');
                iconCircle.css({'background-color': '#e6f4ea', 'color': '#064e3b'});
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
                        // Reload to recalculate accurate progress
                        loadchecklistibadah(tanggal);
                    }
                });
            } else {
                // Instantly style optimistic update
                parentDiv.css('background-color', '#ffffff');
                iconCircle.css({'background-color': '#f8f9fa', 'color': '#a1a1a1'});
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
                        // Reload to recalculate accurate progress
                        loadchecklistibadah(tanggal);
                    }
                });
            }
        });
    });
</script>
@endpush

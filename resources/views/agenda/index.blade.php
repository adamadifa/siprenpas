@extends('layouts.app')
@section('titlepage', 'Agenda')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-calendar fs-3 text-success"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Agenda Pesantren</h4>
                        <p class="text-muted mb-0 small">Manajemen perencanaan agenda dan jadwal kegiatan pesantren</p>
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
                            <li class="breadcrumb-item active">
                                <i class="ti ti-calendar me-1"></i> Agenda
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" />
    <style>
        #calendar {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }
        /* Custom calendar event colors */
        .fc-event {
            cursor: pointer !important;
            padding: 6px 10px !important;
            border-radius: 6px !important;
            background-color: #064e3b !important;
            border-color: #064e3b !important;
            color: #ffffff !important;
            border-left: 4px solid #ff8c00 !important;
        }
        .fc-daygrid-event {
            display: flex !important;
            flex-direction: column !important;
            align-items: flex-start !important;
        }
        .fc-daygrid-event-dot {
            display: none !important;
        }
        .fc-event-main {
            display: flex !important;
            flex-direction: column !important;
            align-items: flex-start !important;
            width: 100% !important;
        }
        .fc-event-time {
            font-size: 0.75rem !important;
            font-weight: 500 !important;
            color: rgba(255, 255, 255, 0.85) !important;
            margin-bottom: 2px !important;
            white-space: nowrap !important;
        }
        .fc-event-title {
            font-size: 0.85rem !important;
            font-weight: 700 !important;
            white-space: normal !important;
            word-break: break-word !important;
            line-height: 1.2 !important;
        }
        .fc-event:hover {
            opacity: 0.95;
        }
        .fc-header-toolbar {
            margin-bottom: 1.5rem !important;
        }
        .fc-button-primary {
            background-color: #064e3b !important;
            border-color: #064e3b !important;
        }
        .fc-button-primary:hover {
            background-color: #0b6e54 !important;
            border-color: #0b6e54 !important;
        }
        .fc-button-primary:disabled {
            background-color: #064e3b !important;
            border-color: #064e3b !important;
            opacity: 0.65;
        }
        .fc-button-active {
            background-color: #ff8c00 !important;
            border-color: #ff8c00 !important;
        }
    </style>
@endpush

<div class="row">
    <div class="col-lg-12">
        <!-- Actions Section -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            @can('agenda.create')
                <button class="btn d-flex align-items-center gap-2 shadow-sm text-white" id="btncreateAgenda"
                    style="background-color: #064e3b">
                    <i class="ti ti-plus fs-4"></i>
                    <span>Tambah Agenda</span>
                </button>
            @endcan
            <span class="text-muted small"><i class="ti ti-info-circle text-info me-1"></i>Anda dapat melakukan klik pada tanggal kosong untuk menambah agenda, klik event untuk edit, atau drag & drop untuk memindahkan agenda.</span>
        </div>

        <!-- Calendar Card -->
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
</div>

<x-modal-form id="mdlAgenda" size="" show="loadAgenda" title="" />

@endsection

@push('myscript')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script>
    $(function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            editable: {{ auth()->user()->can('agenda.edit') ? 'true' : 'false' }},
            droppable: {{ auth()->user()->can('agenda.edit') ? 'true' : 'false' }},
            selectable: {{ auth()->user()->can('agenda.create') ? 'true' : 'false' }},
            selectMirror: {{ auth()->user()->can('agenda.create') ? 'true' : 'false' }},
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: "{{ route('agenda.getevents') }}",
            displayEventEnd: true,
            eventTimeFormat: {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            },
            
            // Drag and drop event
            eventDrop: function(info) {
                updateEventDate(info.event);
            },
            
            // Resize event
            eventResize: function(info) {
                updateEventDate(info.event);
            },

            // Click empty date (create event)
            select: function(info) {
                @can('agenda.create')
                var start = new Date(info.startStr);
                var end = new Date(info.endStr);
                // Subtract 1 day because FullCalendar endStr is exclusive for selection
                end.setDate(end.getDate() - 1);
                
                var tzoffset = start.getTimezoneOffset() * 60000;
                var startDateStr = (new Date(start.getTime() - tzoffset)).toISOString().slice(0, 10);
                var endDateStr = (new Date(end.getTime() - tzoffset)).toISOString().slice(0, 10);

                $('#mdlAgenda').modal("show");
                $("#mdlAgenda").find(".modal-title").text("Tambah Agenda");
                $("#loadAgenda").load('/agenda/create', function() {
                    $('#tanggal').val(startDateStr);
                    $('#tanggal_selesai').val(endDateStr);
                });
                calendar.unselect();
                @endcan
            },

            // Click event (edit event / view details)
            eventClick: function(info) {
                @can('agenda.edit')
                var id = info.event.extendedProps.encrypted_id;
                $('#mdlAgenda').modal("show");
                $("#mdlAgenda").find(".modal-title").text("Edit Agenda");
                $("#loadAgenda").load('/agenda/' + id + '/edit');
                @else
                var title = info.event.title;
                var start = info.event.start;
                var end = info.event.end;
                var desc = info.event.extendedProps.description || '-';
                var loc = info.event.extendedProps.location || '-';
                
                var formattedDate = start.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
                var formattedTime = info.event.allDay ? 'Seharian Penuh' : start.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
                if (end && !info.event.allDay) {
                    // Adjust end date for display if it's multiple days
                    var adjustEnd = new Date(end.getTime());
                    if (info.event.allDay) {
                        adjustEnd.setDate(adjustEnd.getDate() - 1);
                    }
                    formattedTime += ' - ' + adjustEnd.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
                }

                Swal.fire({
                    title: '<strong style="color:#064e3b">' + title + '</strong>',
                    html:
                        '<div style="text-align: left; font-size: 0.9rem; line-height: 1.6;">' +
                        '<strong><i class="ti ti-calendar text-success me-1"></i> Tanggal:</strong> ' + formattedDate + '<br>' +
                        '<strong><i class="ti ti-clock text-success me-1"></i> Waktu:</strong> ' + formattedTime + '<br>' +
                        '<strong><i class="ti ti-map-pin text-warning me-1"></i> Tempat:</strong> ' + loc + '<br>' +
                        '<strong><i class="ti ti-info-circle text-info me-1"></i> Keterangan:</strong><br>' + desc +
                        '</div>',
                    showCloseButton: true,
                    confirmButtonText: 'Tutup',
                    confirmButtonColor: '#064e3b'
                });
                @endcan
            }
        });

        calendar.render();

        function updateEventDate(event) {
            var id = event.id;
            var start = event.start;
            var end = event.end;

            // Format date to YYYY-MM-DD
            var tzoffset = start.getTimezoneOffset() * 60000; //offset in milliseconds
            var localISOTime = (new Date(start.getTime() - tzoffset)).toISOString().slice(0, 10);
            var tanggal = localISOTime;

            // Format end date (if multiday or dragged/resized)
            var end_date = end ? new Date(end.getTime()) : new Date(start.getTime());
            if (event.allDay && end) {
                // Subtract 1 day because FullCalendar end date is exclusive for all-day events
                end_date.setDate(end_date.getDate() - 1);
            }
            var localISOEndTime = (new Date(end_date.getTime() - tzoffset)).toISOString().slice(0, 10);
            var tanggal_selesai = localISOEndTime;
            
            // Format time to HH:MM:SS
            var jam_mulai = event.allDay ? null : start.toTimeString().split(' ')[0];
            var jam_selesai = null;
            if (end && !event.allDay) {
                jam_selesai = end.toTimeString().split(' ')[0];
            }

            $.ajax({
                url: "{{ route('agenda.update-date') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                    tanggal: tanggal,
                    tanggal_selesai: tanggal_selesai,
                    jam_mulai: jam_mulai,
                    jam_selesai: jam_selesai
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Jadwal agenda berhasil diperbarui!',
                        timer: 1500,
                        showConfirmButton: false
                    });
                },
                error: function(err) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Gagal memperbarui jadwal agenda.'
                    });
                    calendar.refetchEvents();
                }
            });
        }

        $("#btncreateAgenda").click(function(e) {
            e.preventDefault();
            $('#mdlAgenda').modal("show");
            $("#mdlAgenda").find(".modal-title").text("Tambah Agenda");
            $("#loadAgenda").load('/agenda/create');
        });
    });
</script>
@endpush

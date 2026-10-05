@extends('layouts.app')
@section('titlepage', 'Agenda Pesantren')

@section('content')
<div class="space-y-6">

    <!-- ================= 1. PAGE HEADER & BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <!-- Title & Subtitle -->
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-xl shrink-0 font-bold border border-emerald-200 shadow-2xs">
                <i class="ti ti-calendar-event"></i>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">
                    Agenda Pesantren
                </h1>
                <p class="text-xs text-slate-500 font-medium">
                    Manajemen perencanaan agenda, jadwal kegiatan, dan kalender kegiatan terpadu pesantren
                </p>
            </div>
        </div>

        <!-- Breadcrumb & Top Actions -->
        <div class="flex flex-col md:items-end gap-2.5">
            <nav class="flex items-center text-xs text-slate-400 font-medium">
                <a href="{{ route('dashboard.index') }}" class="hover:text-slate-700 transition flex items-center gap-1">
                    <i class="ti ti-home text-sm"></i>
                    <span>Dashboard</span>
                </a>
                <span class="mx-2 text-slate-300">/</span>
                <span class="text-slate-500">Kegiatan & Pesantren</span>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Agenda Pesantren</span>
            </nav>

            <div class="flex flex-wrap items-center gap-2">
                @can('agenda.create')
                    <button type="button" 
                            id="btncreateAgenda"
                            class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg text-xs shadow-xs transition active:scale-95 cursor-pointer">
                        <i class="ti ti-plus text-sm"></i>
                        <span>Tambah Agenda</span>
                    </button>
                @endcan

                @if(auth()->check() && auth()->user()->hasRole('super admin'))
                    <form method="POST" action="{{ route('agenda.reset') }}" class="inline-block m-0" id="formResetAgenda">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-rose-50 hover:bg-rose-600 text-rose-700 hover:text-white font-bold rounded-lg text-xs border border-rose-200 transition active:scale-95 cursor-pointer btn-reset-confirm"
                                title="Reset semua data agenda pesantren">
                            <i class="ti ti-rotate text-sm"></i>
                            <span>Reset</span>
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <!-- ================= 2. CALENDAR INFORMATION BANNER ================= -->
    <div class="p-3.5 bg-emerald-50/70 border border-emerald-200/80 rounded-xl flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs text-emerald-900">
        <div class="flex items-center gap-2.5 font-medium">
            <div class="w-7 h-7 rounded-lg bg-emerald-600 text-white flex items-center justify-center shrink-0 text-sm shadow-2xs">
                <i class="ti ti-bulb"></i>
            </div>
            <span><strong>Tips Navigasi:</strong> Klik tanggal untuk menambah agenda baru, klik event untuk detail/edit, atau seret (drag & drop) event untuk mengubah jadwal.</span>
        </div>
        <div class="flex items-center gap-2 shrink-0">
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-white border border-emerald-200 text-[11px] font-semibold text-emerald-800">
                <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                <span>Agenda Terjadwal</span>
            </span>
        </div>
    </div>

    <!-- ================= 3. CALENDAR CARD CONTAINER ================= -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-2xs overflow-hidden">
        <div class="p-4 sm:p-6">
            <div id="calendar" class="fc-modern-theme"></div>
        </div>
    </div>

</div>

<x-modal-form id="mdlAgenda" size="" show="loadAgenda" title="" />

@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" />
    <style>
        /* Modern FullCalendar Theme Overrides */
        .fc-modern-theme {
            font-family: inherit;
        }
        .fc-theme-standard .fc-scrollgrid {
            border: 1px solid #e2e8f0 !important;
            border-radius: 0.75rem !important;
            overflow: hidden !important;
        }
        .fc-theme-standard th {
            background-color: #f8fafc !important;
            border-color: #e2e8f0 !important;
            padding: 10px 0 !important;
            font-size: 0.75rem !important;
            font-weight: 700 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.05em !important;
            color: #475569 !important;
        }
        .fc-theme-standard td {
            border-color: #f1f5f9 !important;
        }
        .fc-day-today {
            background-color: #ecfdf5 !important;
        }
        .fc-daygrid-day-number {
            font-size: 0.8rem !important;
            font-weight: 700 !important;
            color: #334155 !important;
            padding: 6px 8px !important;
        }
        .fc .fc-button {
            border-radius: 0.5rem !important;
            font-size: 0.8rem !important;
            font-weight: 700 !important;
            padding: 0.45rem 0.85rem !important;
            transition: all 0.15s ease-in-out !important;
            text-transform: capitalize !important;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
        }
        .fc .fc-button-primary {
            background-color: #059669 !important;
            border-color: #059669 !important;
            color: #ffffff !important;
        }
        .fc .fc-button-primary:hover {
            background-color: #047857 !important;
            border-color: #047857 !important;
        }
        .fc .fc-button-primary:focus {
            box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.2) !important;
        }
        .fc .fc-button-primary:disabled {
            background-color: #94a3b8 !important;
            border-color: #94a3b8 !important;
            opacity: 0.6 !important;
        }
        .fc .fc-button-active, .fc .fc-button-primary:not(:disabled):active {
            background-color: #064e3b !important;
            border-color: #064e3b !important;
        }
        .fc-toolbar-title {
            font-size: 1.2rem !important;
            font-weight: 800 !important;
            color: #0f172a !important;
            letter-spacing: -0.02em !important;
        }
        .fc-header-toolbar {
            margin-bottom: 1.25rem !important;
            flex-wrap: wrap !important;
            gap: 0.75rem !important;
        }

        /* Custom calendar event cards */
        .fc-event {
            cursor: pointer !important;
            padding: 4px 8px !important;
            border-radius: 6px !important;
            background-color: #064e3b !important;
            border: 1px solid #047857 !important;
            border-left: 3.5px solid #10b981 !important;
            color: #ffffff !important;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08) !important;
            margin: 2px 3px !important;
            transition: transform 0.1s ease, box-shadow 0.1s ease !important;
        }
        .fc-event:hover {
            transform: translateY(-1px) !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.12) !important;
            opacity: 0.96 !important;
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
            font-size: 0.7rem !important;
            font-weight: 600 !important;
            color: #a7f3d0 !important;
            margin-bottom: 1px !important;
            white-space: nowrap !important;
        }
        .fc-event-title {
            font-size: 0.78rem !important;
            font-weight: 700 !important;
            white-space: normal !important;
            word-break: break-word !important;
            line-height: 1.25 !important;
            color: #ffffff !important;
        }
    </style>
@endpush

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

        $(document).on('click', '.btn-reset-confirm', function(event) {
            var form = $(this).closest("form");
            event.preventDefault();
            Swal.fire({
                title: `Apakah Anda Yakin Ingin Mereset Semua Agenda ?`,
                text: "Semua data agenda akan dihapus secara permanen!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Ya, Reset Semua!"
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush

@extends('layouts.mobile.app_sipren')

@section('title', 'Jadwal Pelajaran - Sipren')
@section('header-title', 'Jadwal Pelajaran')
@section('back-url', route('dashboard.index'))
@section('show-bottom-nav', true)

@push('styles')
    <style>
        /* Day Tabs styling */
        .day-tabs-scroll {
            display: flex;
            overflow-x: auto;
            gap: 8px;
            padding: 12px 16px;
            -webkit-overflow-scrolling: touch;
        }

        .day-tabs-scroll::-webkit-scrollbar {
            display: none;
        }

        .day-tabs-scroll {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .day-tab-btn {
            flex: 0 0 auto;
            border-radius: 12px;
            padding: 8px 16px;
            font-weight: 600;
            font-size: 0.85rem;
            border: none;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            background: #ffffff;
            color: var(--text-muted);
            box-shadow: var(--shadow-sm);
        }

        .day-tab-btn.active {
            background: var(--primary) !important;
            color: #ffffff !important;
            box-shadow: 0 4px 12px rgba(6, 78, 59, 0.2) !important;
        }

        /* Card active click effect */
        .btn-action {
            transition: all 0.2s ease;
            text-decoration: none !important;
        }
        .btn-action:active {
            transform: scale(0.95);
            opacity: 0.9;
        }

        /* Input Group styling inside modal */
        .filter-input-group {
            display: flex;
            align-items: center;
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: 14px;
            padding: 10px 14px;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        .filter-input-group:focus-within {
            background: #ffffff;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(6, 78, 59, 0.08);
        }

        .filter-input-group ion-icon.field-icon {
            font-size: 20px;
            color: var(--primary-light);
            margin-right: 10px;
            flex-shrink: 0;
        }

        .filter-input-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .filter-input-content label {
            font-size: 0.72rem;
            font-weight: 600;
            color: var(--text-muted);
            margin: 0 0 2px 0 !important;
            line-height: 1.2;
        }

        .filter-input-content select {
            border: none !important;
            background: transparent !important;
            padding: 0 !important;
            font-size: 0.88rem !important;
            font-weight: 600 !important;
            color: var(--text-main) !important;
            outline: none !important;
            width: 100% !important;
            height: auto !important;
            box-shadow: none !important;
            -webkit-appearance: none;
            appearance: none;
            cursor: pointer;
            margin: 0;
            line-height: 1.3;
        }

        .filter-input-content select:focus {
            outline: none !important;
            box-shadow: none !important;
        }

        /* Empty state styling */
        .empty-state {
            background: var(--surface);
            border-radius: 16px;
            padding: 40px 20px;
            text-align: center;
            box-shadow: 0 4px 16px rgba(6, 78, 59, 0.03);
            margin: 0 16px;
        }

        .empty-state ion-icon {
            font-size: 48px;
            color: #cbd5e1;
            margin-bottom: 12px;
        }

        .empty-state h4 {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--text-main);
            margin: 0 0 6px;
        }

        .empty-state p {
            font-size: 0.78rem;
            color: var(--text-muted);
            margin: 0;
        }

        /* Modal Overrides */
        #filterModal .modal-content {
            border-radius: 24px;
            border: none;
            box-shadow: 0 12px 36px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }
    </style>
@endpush

@section('content')
    @php
        $hariIni = getHari(date('Y-m-d'));
        if (!in_array($hariIni, $days)) {
            $hariIni = 'Senin';
        }
    @endphp

    <!-- Subheader & Filter Button -->
    <div style="padding: 16px 16px 4px 16px; display: flex; justify-content: space-between; align-items: center; margin-top: 4px;">
        <span style="font-size: 0.78rem; font-weight: 700; color: var(--primary); text-transform: uppercase; letter-spacing: 0.05em;">
            Agenda Kelas
        </span>
        <button class="btn btn-sm btn-action" type="button" data-toggle="modal" data-target="#filterModal"
                style="background: #ffffff; color: var(--primary); border: 1.5px solid var(--primary); border-radius: 10px; font-weight: 700; font-size: 0.75rem; display: flex; align-items: center; gap: 4px; padding: 6px 12px; box-shadow: var(--shadow-sm); position: relative; height: auto; line-height: 1.2;">
            <ion-icon name="funnel-outline" style="font-size: 14px;"></ion-icon>
            <span>Filter</span>
            @if (request('kode_unit') || request('kode_kelas') || request('guru_id') || request('semester'))
                <span style="position: absolute; top: -3px; right: -3px; display: block; width: 8px; height: 8px; border-radius: 50%; background: var(--accent); border: 1.5px solid #ffffff;"></span>
            @endif
        </button>
    </div>

    <!-- Horizontal Swipeable Day Tabs -->
    <div class="day-tabs-scroll mb-2">
        @foreach ($days as $day)
            <button type="button" class="day-tab-btn {{ $day == $hariIni ? 'active' : '' }}" data-day="{{ $day }}">
                {{ $day }}
            </button>
        @endforeach
    </div>

    <!-- Schedule Agenda List -->
    <div id="schedule-list-section" style="padding: 0 16px;">
        @forelse ($jadwal as $item)
            <div class="schedule-card-wrapper" data-hari="{{ $item->hari }}">
                <div class="card mb-3 border-0" style="border-radius: 16px; background: var(--surface); box-shadow: 0 4px 16px rgba(6, 78, 59, 0.04); overflow: hidden;">
                    <div class="card-body p-3">
                        <div style="display: flex; gap: 14px; align-items: flex-start;">
                            <!-- Left Column: Jam Ke & Waktu -->
                            <div style="width: 70px; flex-shrink: 0; text-align: center; border-right: 1.5px solid var(--border-color); padding-right: 10px; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                <span style="font-size: 0.92rem; font-weight: 800; color: var(--primary); display: block; line-height: 1.1;">
                                    {{ $item->jam_mulai ? date('H:i', strtotime($item->jam_mulai)) : '-' }}
                                </span>
                                <span style="font-size: 0.7rem; color: var(--text-muted); display: block; margin-top: 1px; font-weight: 500;">
                                    s/d {{ $item->jam_selesai ? date('H:i', strtotime($item->jam_selesai)) : '-' }}
                                </span>
                                <span class="badge mt-2" style="font-size: 0.65rem; font-weight: 700; border-radius: 6px; padding: 4px 6px; background: rgba(6, 78, 59, 0.08); color: var(--primary);">
                                    Jam {{ $item->jam_ke }}
                                </span>
                            </div>
                            
                            <!-- Right Column: Detail Pelajaran -->
                            <div style="flex: 1; min-width: 0;">
                                <h4 style="font-size: 0.92rem; font-weight: 700; color: var(--text-main); margin: 0 0 6px 0; line-height: 1.3; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $item->mapel->nama_matpel ?? '-' }}
                                </h4>
                                
                                <div style="display: flex; flex-direction: column; gap: 4px;">
                                    <span style="font-size: 0.75rem; color: var(--text-muted); display: flex; align-items: center; gap: 5px; font-weight: 500;">
                                        <ion-icon name="business-outline" style="color: var(--primary); font-size: 14px; flex-shrink: 0;"></ion-icon>
                                        Kelas {{ $item->kelas->nama_kelas ?? '-' }}
                                    </span>
                                    
                                    @if(!auth()->user()->hasRole('guru'))
                                        <span style="font-size: 0.75rem; color: var(--text-muted); display: flex; align-items: center; gap: 5px; font-weight: 500;">
                                            <ion-icon name="person-outline" style="color: var(--primary); font-size: 14px; flex-shrink: 0;"></ion-icon>
                                            {{ $item->guru->nama_guru ?? '-' }}
                                        </span>
                                    @endif

                                    <span style="font-size: 0.72rem; color: var(--text-muted); display: flex; align-items: center; gap: 5px; font-weight: 500;">
                                        <ion-icon name="calendar-clear-outline" style="color: var(--primary); font-size: 14px; flex-shrink: 0;"></ion-icon>
                                        Sem. {{ $item->semester == 1 ? 'Ganjil' : 'Genap' }} (TA {{ $item->tahunAjaran->tahun_ajaran ?? '-' }})
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Card Actions -->
                        @if (auth()->check() && (auth()->user()->can('jadwalpelajaran.index') || auth()->user()->hasRole('guru')))
                            <div style="margin-top: 14px; padding-top: 12px; border-top: 1.5px solid var(--border-color); display: flex; gap: 8px;">
                                <a href="{{ route('presensi-mapel.input', [Crypt::encrypt($item->id), date('Y-m-d')]) }}" 
                                   class="btn-action" 
                                   style="flex: 2; display: flex; align-items: center; justify-content: center; gap: 4px; font-size: 0.75rem; font-weight: 700; background: var(--primary); color: #ffffff; border-radius: 10px; padding: 8px 12px; text-decoration: none; box-shadow: 0 4px 10px rgba(6, 78, 59, 0.15);">
                                    <ion-icon name="checkbox-outline" style="font-size: 15px;"></ion-icon>
                                    <span>Presensi</span>
                                </a>
                                
                                <a href="{{ route('jadwal-pelajaran.cetak-presensi', Crypt::encrypt($item->id)) }}" 
                                   target="_blank" 
                                   class="btn-action" 
                                   style="flex: 1.2; display: flex; align-items: center; justify-content: center; gap: 4px; font-size: 0.75rem; font-weight: 600; background: rgba(6, 78, 59, 0.05); color: var(--primary); border: 1px solid rgba(6, 78, 59, 0.12); border-radius: 10px; padding: 8px 6px; text-decoration: none;">
                                    <ion-icon name="print-outline" style="font-size: 14px;"></ion-icon>
                                    <span>Cetak</span>
                                </a>
                                
                                <a href="{{ route('penilaian.index', $item->id) }}" 
                                   class="btn-action" 
                                   style="flex: 1; display: flex; align-items: center; justify-content: center; gap: 4px; font-size: 0.75rem; font-weight: 600; background: rgba(6, 78, 59, 0.05); color: var(--primary); border: 1px solid rgba(6, 78, 59, 0.12); border-radius: 10px; padding: 8px 6px; text-decoration: none;">
                                    <ion-icon name="bar-chart-outline" style="font-size: 14px;"></ion-icon>
                                    <span>Nilai</span>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div id="server-empty-state" class="empty-state">
                <ion-icon name="calendar-outline"></ion-icon>
                <h4>Jadwal Belum Tersedia</h4>
                <p>Data jadwal pelajaran belum ditambahkan</p>
            </div>
        @endforelse

        <!-- Client-side filter fallback empty state -->
        <div id="empty-state" class="empty-state" style="display: none;">
            <ion-icon name="calendar-clear-outline"></ion-icon>
            <h4>Tidak Ada Jadwal</h4>
            <p>Tidak ada jadwal mengajar pada hari <span class="day-name" style="font-weight: 700;"></span></p>
        </div>
    </div>

    <!-- Filter Modal -->
    <div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: #ffffff; border-bottom: none; padding: 18px 20px; display: flex; align-items: center; justify-content: space-between;">
                    <h5 class="modal-title" id="filterModalLabel" style="font-weight: 700; font-size: 1.05rem; color: #ffffff; display: flex; align-items: center; gap: 8px; margin-bottom: 0; letter-spacing: -0.01em;">
                        <ion-icon name="funnel-outline" style="font-size: 20px; color: var(--accent);"></ion-icon>
                        Filter Jadwal
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #ffffff; opacity: 0.9; outline: none; background: none; border: none; padding: 4px; margin: 0; display: flex; align-items: center; justify-content: center; transition: all 0.2s ease;">
                        <ion-icon name="close-outline" style="font-size: 24px; color: #ffffff;"></ion-icon>
                    </button>
                </div>
                <form action="{{ route('jadwal-pelajaran.index') }}" method="GET">
                    <div class="modal-body" style="padding: 20px; background: #ffffff;">
                        <div style="display: flex; flex-direction: column; gap: 16px;">
                            
                            <!-- Tahun Ajaran -->
                            <div class="filter-input-group">
                                <ion-icon name="calendar-outline" class="field-icon"></ion-icon>
                                <div class="filter-input-content">
                                    <label>Tahun Ajaran</label>
                                    <select name="kode_ta">
                                        @foreach ($semuaTa as $ta)
                                            <option value="{{ $ta->kode_ta }}" {{ $selectedKodeTa == $ta->kode_ta ? 'selected' : '' }}>
                                                {{ $ta->tahun_ajaran }} {{ $ta->status == 1 ? '(Aktif)' : '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <ion-icon name="chevron-down-outline" style="font-size: 14px; color: var(--text-muted); margin-left: 8px; flex-shrink: 0;"></ion-icon>
                            </div>

                            <!-- Semester -->
                            <div class="filter-input-group">
                                <ion-icon name="time-outline" class="field-icon"></ion-icon>
                                <div class="filter-input-content">
                                    <label>Semester</label>
                                    <select name="semester" id="filter_semester">
                                        <option value="">Semua Semester</option>
                                        @foreach ($semesters as $sem)
                                            <option value="{{ $sem }}" {{ request('semester') == $sem ? 'selected' : '' }}>
                                                {{ $sem == 1 ? 'Ganjil' : 'Genap' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <ion-icon name="chevron-down-outline" style="font-size: 14px; color: var(--text-muted); margin-left: 8px; flex-shrink: 0;"></ion-icon>
                            </div>

                            <!-- Unit -->
                            <div class="filter-input-group">
                                <ion-icon name="business-outline" class="field-icon"></ion-icon>
                                <div class="filter-input-content">
                                    <label>Unit</label>
                                    <select name="kode_unit" id="filter_kode_unit">
                                        <option value="">Semua Unit</option>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->kode_unit }}" {{ request('kode_unit') == $unit->kode_unit ? 'selected' : '' }}>
                                                {{ $unit->nama_unit }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <ion-icon name="chevron-down-outline" style="font-size: 14px; color: var(--text-muted); margin-left: 8px; flex-shrink: 0;"></ion-icon>
                            </div>

                            <!-- Kelas -->
                            <div class="filter-input-group">
                                <ion-icon name="school-outline" class="field-icon"></ion-icon>
                                <div class="filter-input-content">
                                    <label>Kelas</label>
                                    <select name="kode_kelas" id="filter_kode_kelas">
                                        <option value="">Semua Kelas</option>
                                        @foreach ($kelas as $k)
                                            <option value="{{ $k->kode_kelas }}" {{ request('kode_kelas') == $k->kode_kelas ? 'selected' : '' }}>
                                                {{ $k->nama_kelas }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <ion-icon name="chevron-down-outline" style="font-size: 14px; color: var(--text-muted); margin-left: 8px; flex-shrink: 0;"></ion-icon>
                            </div>

                            <!-- Guru Pengampu -->
                            @if (!auth()->user()->hasRole('guru'))
                                <div class="filter-input-group">
                                    <ion-icon name="person-outline" class="field-icon"></ion-icon>
                                    <div class="filter-input-content">
                                        <label>Guru Pengampu</label>
                                        <select name="guru_id" id="filter_guru_id">
                                            <option value="">Semua Guru</option>
                                            @foreach ($gurus as $g)
                                                <option value="{{ $g->id }}" {{ request('guru_id') == $g->id ? 'selected' : '' }}>
                                                    {{ $g->nama_guru }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <ion-icon name="chevron-down-outline" style="font-size: 14px; color: var(--text-muted); margin-left: 8px; flex-shrink: 0;"></ion-icon>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer" style="border-top: none; padding: 12px 20px 20px 20px; background: #ffffff; display: flex; gap: 10px;">
                        <button type="button" class="btn btn-action" data-dismiss="modal" style="flex: 1; background: #f1f5f9; color: var(--text-muted); font-weight: 700; border-radius: 14px; padding: 12px; border: none; font-size: 0.85rem; height: auto; line-height: 1.2;">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-action" style="flex: 1.5; background: var(--primary); color: #ffffff; font-weight: 700; border-radius: 14px; padding: 12px; border: none; font-size: 0.85rem; height: auto; line-height: 1.2; box-shadow: 0 4px 12px rgba(6, 78, 59, 0.15);">
                            Terapkan Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('myscript')
    <!-- App Logic -->
    <script>
        $(document).ready(function() {
            // Client-side day filter logic
            function filterSchedules(day) {
                var totalCards = $('.schedule-card-wrapper').length;
                
                if (totalCards === 0) {
                    $('#server-empty-state').show();
                    $('#empty-state').hide();
                    return;
                } else {
                    $('#server-empty-state').hide();
                }

                var count = 0;
                $('.schedule-card-wrapper').each(function() {
                    var cardDay = $(this).data('hari');
                    if (cardDay === day) {
                        $(this).show();
                        count++;
                    } else {
                        $(this).hide();
                    }
                });

                if (count === 0) {
                    $('#empty-state').show().find('.day-name').text(day);
                } else {
                    $('#empty-state').hide();
                }
            }

            // Initial Filter
            var activeDay = $('.day-tab-btn.active').data('day');
            if (activeDay) {
                filterSchedules(activeDay);
            }

            // Day button handler
            $('.day-tab-btn').click(function() {
                $('.day-tab-btn').removeClass('active');
                $(this).addClass('active');
                
                var selectedDay = $(this).data('day');
                filterSchedules(selectedDay);
            });

            // Dynamic filter options by Unit Selection
            $("#filter_kode_unit").change(function() {
                var kode_unit = $(this).val();
                
                if (kode_unit) {
                    $("#filter_kode_kelas").html('<option value="">Loading...</option>').prop('disabled', true);
                    $("#filter_guru_id").html('<option value="">Loading...</option>').prop('disabled', true);
                    
                    $.ajax({
                        url: "{{ route('jadwal-pelajaran.get-data-by-unit') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            kode_unit: kode_unit
                        },
                        dataType: "json",
                        success: function(data) {
                            if(data.status == 'success') {
                                var kelasOptions = '<option value="">Semua Kelas</option>';
                                $.each(data.kelas, function(key, value) {
                                    kelasOptions += '<option value="'+ value.kode_kelas +'">'+ value.nama_kelas +'</option>';
                                });
                                $("#filter_kode_kelas").html(kelasOptions).prop('disabled', false);

                                if ($("#filter_guru_id").length) {
                                    var guruOptions = '<option value="">Semua Guru</option>';
                                    $.each(data.guru, function(key, value) {
                                        guruOptions += '<option value="'+ value.id +'">'+ value.nama_guru +'</option>';
                                    });
                                    $("#filter_guru_id").html(guruOptions).prop('disabled', false);
                                }
                            } else {
                                alert("Error: " + data.message);
                            }
                        },
                        error: function() {
                            alert("Terjadi kesalahan saat mengambil data.");
                            $("#filter_kode_kelas").html('<option value="">Semua Kelas</option>').prop('disabled', false);
                            $("#filter_guru_id").html('<option value="">Semua Guru</option>').prop('disabled', false);
                        }
                    });
                } else {
                    $("#filter_kode_kelas").html('<option value="">Semua Kelas</option>');
                    if ($("#filter_guru_id").length) {
                        $("#filter_guru_id").html('<option value="">Semua Guru</option>');
                    }
                }
            });
        });
    </script>
@endpush

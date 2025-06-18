<link rel="stylesheet" href="{{ asset('assets/css/timeline-agenda.css') }}">
<ul class="timeline-agenda">
@foreach ($agendakegiatan as $d)
    <li class="timeline-agenda-item">
        <span class="timeline-agenda-dot">
            <i class="ti ti-calendar-event"></i>
        </span>
        <div class="timeline-agenda-card">
            <div class="timeline-agenda-title">{{ $d->nama_kegiatan }}</div>
            <div class="timeline-agenda-desc">{!! truncateString(strip_tags($d->uraian_kegiatan), 40) !!}</div>
            <div class="timeline-agenda-date"><i class="ti ti-calendar"></i> {{ DateToIndo($d->tanggal) }}</div>
            <div class="timeline-agenda-meta">
                <span><i class="ti ti-user"></i> {{ $d->name }}</span>
                <span><i class="ti ti-building"></i> {{ $d->nama_dept }}</span>
            </div>
        </div>
    </li>
@endforeach
</ul>

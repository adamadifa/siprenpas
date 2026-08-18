@php
    $total = count($kegiatan_ibadah);
    $checked = $kegiatan_ibadah->filter(function($item) {
        return !empty($item->id_kegiatan_ibadah);
    })->count();
    $percent = $total > 0 ? round(($checked / $total) * 100) : 0;
@endphp

<!-- Progress Indicator Data -->
<input type="hidden" id="ibadah-progress-percent" value="{{ $percent }}">
<input type="hidden" id="ibadah-progress-text" value="{{ $checked }} dari {{ $total }} kegiatan selesai">

<div class="row g-4">
    @forelse ($kegiatan_ibadah->groupBy('kategori_ibadah') as $kategori => $items)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden">
                <div class="card-header border-0 py-3 d-flex align-items-center justify-content-between" style="background-color: #f8f9fa;">
                    <h6 class="fw-bold mb-0 d-flex align-items-center gap-2" style="color: #064e3b;">
                        <i class="ti ti-heart-handshake fs-5"></i>
                        <span>{{ $kategori }}</span>
                    </h6>
                    <span class="badge bg-label-success rounded-pill small fw-bold px-2 py-1">
                        {{ $items->whereNotNull('id_kegiatan_ibadah')->count() }}/{{ $items->count() }}
                    </span>
                </div>
                <div class="card-body p-3">
                    <div class="d-flex flex-column gap-2">
                        @foreach ($items as $d)
                            @php
                                $isChecked = !empty($d->id_kegiatan_ibadah);
                            @endphp
                            <div class="d-flex align-items-center justify-content-between p-3 rounded-3 border hover-bg-light" 
                                 style="border-color: #f1f3f5 !important; background-color: {{ $isChecked ? '#f3fdf6' : '#ffffff' }};">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" 
                                         style="width: 34px; height: 34px; background-color: {{ $isChecked ? '#e6f4ea' : '#f8f9fa' }}; color: {{ $isChecked ? '#064e3b' : '#a1a1a1' }}; border: 1px solid {{ $isChecked ? 'rgba(6,78,59,0.1)' : 'rgba(0,0,0,0.05)' }};">
                                        <i class="ti ti-{{ $isChecked ? 'check' : 'circle-dot' }} fs-5"></i>
                                    </div>
                                    <div>
                                        <span class="fw-bold text-dark small d-block" style="font-size: 0.9rem; letter-spacing: -0.1px;">{{ $d->nama_kegiatan }}</span>
                                    </div>
                                </div>
                                <div class="form-check form-switch m-0 p-0">
                                    <input type="checkbox" class="form-check-input checklist cursor-pointer" 
                                           data-id="{{ $d->id }}" data-kode="{{ $d->kode_checklist_ibadah }}" 
                                           id="cb-{{ $d->id }}" {{ $isChecked ? 'checked' : '' }} 
                                           style="width: 38px; height: 20px; margin-left: 0;">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5 bg-white rounded-3 shadow-sm">
            <div class="mb-3 text-muted">
                <i class="ti ti-clipboard-off fs-1 opacity-50 text-success"></i>
            </div>
            <h5 class="fw-bold text-dark">Belum Ada Daftar Kegiatan Ibadah</h5>
            <p class="text-muted small">Hubungi admin untuk mendaftarkan kategori dan butir kegiatan ibadah harian.</p>
        </div>
    @endforelse
</div>

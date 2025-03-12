@foreach ($kegiatan_ibadah as $d)
    <div class="item">
        <div class="detail">
            <div class="avatar avatar-sm me-4">
                <h4 class="font-weight-bold">{{ $d->nama_kegiatan }}</h4>
                <span class="text-muted">{{ $d->kategori_ibadah }}</span></span>
            </div>
        </div>
        <div class="checkbox-wrapper-19">
            <input type="checkbox" class="checklist" data-id="{{ $d->id }}" data-kode="{{ $d->kode_checklist_ibadah }}"
                id="cbtest-{{ $loop->iteration }}" {{ !empty($d->id_kegiatan_ibadah) ? 'checked' : '' }} />
            <label for="cbtest-{{ $loop->iteration }}" class="check-box">
        </div>
    </div>
@endforeach

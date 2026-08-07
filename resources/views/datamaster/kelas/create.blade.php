<form action="{{ route('kelas.store') }}" method="POST" id="formKelas">
    @csrf
    <div class="form-group mb-3">
        <label class="form-label fw-bold">Nama Kelas <span class="text-danger">*</span></label>
        <input type="text" name="nama_kelas" id="nama_kelas" class="form-control" placeholder="Contoh: A, B, C">
        <div class="invalid-feedback" id="error-nama_kelas" style="display:none"></div>
    </div>
    <div class="form-group mb-3">
        <label class="form-label fw-bold">Jenjang / Unit <span class="text-danger">*</span></label>
        <select name="kode_unit" id="kode_unit" class="form-select">
            <option value="">Pilih Unit</option>
            @foreach ($unit as $u)
                <option value="{{ $u->kode_unit }}">{{ strtoupper($u->nama_unit) }}</option>
            @endforeach
        </select>
        <div class="invalid-feedback" id="error-kode_unit" style="display:none"></div>
    </div>
    <div class="form-group mb-3">
        <label class="form-label fw-bold">Tingkat <span class="text-danger">*</span></label>
        <select name="tingkat" id="tingkat" class="form-select">
            <option value="">Pilih Tingkat</option>
        </select>
        <div class="invalid-feedback" id="error-tingkat" style="display:none"></div>
    </div>
    <div class="form-group mb-3" id="wali_kelas_group" style="display: none;">
        <label class="form-label fw-bold">Wali Kelas (Opsional)</label>
        <select name="guru_id" id="guru_id" class="form-select">
            <option value="">Pilih Wali Kelas</option>
            @foreach ($gurus as $g)
                <option value="{{ $g->id }}">{{ $g->nama_guru }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <button class="btn btn-primary w-100" type="submit">
            <i class="ti ti-send me-1"></i> Simpan Data
        </button>
    </div>
</form>

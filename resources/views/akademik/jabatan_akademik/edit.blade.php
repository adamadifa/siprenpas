<form action="{{ route('jabatan-akademik.update', Crypt::encrypt($jabatan_akademik->kode_jabatan)) }}" method="POST" id="formeditJabatan">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-12">
            <x-input-with-icon label="Nama Jabatan" value="{{ $jabatan_akademik->nama_jabatan }}" name="nama_jabatan" icon="ti ti-id" />
            <x-input-with-icon label="Urutan" value="{{ $jabatan_akademik->urutan }}" name="urutan" icon="ti ti-list-numbers" />
            <div class="form-check mt-3">
                <input class="form-check-input" type="checkbox" value="1" id="tampil_di_raport_edit" name="tampil_di_raport" {{ $jabatan_akademik->tampil_di_raport == 1 ? 'checked' : '' }}>
                <label class="form-check-label" for="tampil_di_raport_edit">
                    Tampil di Raport (Tanda Tangan)
                </label>
            </div>
            <div class="form-group mb-3 mt-3">
                <button class="btn btn-primary w-100"><i class="ti ti-send me-1"></i> Update Data</button>
            </div>
        </div>
    </div>
</form>

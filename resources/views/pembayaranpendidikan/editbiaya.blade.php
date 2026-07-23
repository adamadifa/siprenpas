<form action="" id="formEditBiaya">
    @csrf
    <input type="hidden" name="no_pendaftaran" value="{{ Crypt::encrypt($pendaftaran->no_pendaftaran) }}">
    <input type="hidden" name="old_kode_biaya" value="{{ Crypt::encrypt($old_kode_biaya) }}">

    <div class="alert alert-warning py-2 small d-flex align-items-center mb-4">
        <i class="ti ti-alert-triangle fs-4 me-2"></i>
        <div>
            Mengubah konfigurasi biaya akan <strong>menghapus rencana SPP, potongan, dan mutasi</strong> yang telah dikonfigurasi pada biaya lama.
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label fw-bold">Pilih Konfigurasi Biaya Baru</label>
        <select name="new_kode_biaya" id="new_kode_biaya" class="form-select" required>
            <option value="">-- Pilih Konfigurasi Biaya --</option>
            @foreach ($available_biayas as $biaya)
                <option value="{{ $biaya->kode_biaya }}" {{ $biaya->kode_biaya == $old_kode_biaya ? 'selected' : '' }}>
                    {{ $biaya->kode_biaya }} - {{ $biaya->asrama == 1 ? 'Asrama' : 'Non-Asrama/Reguler' }} {{ $biaya->is_pindahan == 1 ? '(Pindahan)' : '' }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="modal-footer pb-0 px-0">
        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary" id="btnSimpanEditBiaya">Simpan Perubahan</button>
    </div>
</form>

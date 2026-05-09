<div class="row">
    <div class="col-12">
        <div class="card shadow-none border-0">
            <div class="card-body p-0">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Tanggal</label>
                        <input type="text" id="modal_tanggal" class="form-control flatpickr-date" value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Unit</label>
                        <select id="modal_kode_unit" class="form-select select2-modal">
                            <option value="">Pilih Unit</option>
                            @foreach ($units as $u)
                                <option value="{{ $u->kode_unit }}">{{ $u->nama_unit }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Kelas</label>
                        <select id="modal_kode_kelas" class="form-select select2-modal">
                            <option value="">Pilih Kelas</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <hr>
                        <h6 class="mb-2">Pilih Mata Pelajaran</h6>
                        <div id="list-jadwal-modal">
                            <div class="alert alert-info py-2 small">Pilih tanggal, unit, dan kelas untuk melihat jadwal</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        // Initialize Select2 for modal
        $('.select2-modal').select2({
            dropdownParent: $('#mdlInputPresensi')
        });

        // Initialize Flatpickr for modal
        $('#modal_tanggal').flatpickr({
            dateFormat: "Y-m-d",
        });

        function loadJadwalModal() {
            var tanggal = $('#modal_tanggal').val();
            var kode_unit = $('#modal_kode_unit').val();
            var kode_kelas = $('#modal_kode_kelas').val();

            if (tanggal && kode_unit && kode_kelas) {
                $('#list-jadwal-modal').html('<div class="text-center py-3"><div class="spinner-border spinner-border-sm text-primary" role="status"></div> Loading...</div>');
                $.ajax({
                    url: "{{ route('presensi-mapel.get-jadwal') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        tanggal: tanggal,
                        kode_unit: kode_unit,
                        kode_kelas: kode_kelas
                    },
                    success: function(respond) {
                        var html = '';
                        if (respond.length > 0) {
                            respond.forEach(function(item) {
                                html += `
                                    <div class="card border mb-2 shadow-none hover-shadow transition">
                                        <div class="card-body p-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-1 fw-bold">${item.mapel.nama_matpel}</h6>
                                                    <p class="mb-0 small text-muted">
                                                        <i class="ti ti-user me-1"></i>${item.guru.karyawan.nama_lengkap} <br>
                                                        <i class="ti ti-clock me-1"></i>${item.jam_mulai.substring(0,5)} - ${item.jam_selesai.substring(0,5)} (Jam ke-${item.jam_ke})
                                                    </p>
                                                </div>
                                                <a href="/presensi-mapel/${item.id_encrypted}/${tanggal}/input" class="btn btn-primary btn-sm">
                                                    Pilih
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                `;
                            });
                        } else {
                            html = '<div class="alert alert-warning py-2 small text-center">Tidak ada jadwal untuk hari ini di kelas tersebut</div>';
                        }
                        $('#list-jadwal-modal').html(html);
                    }
                });
            }
        }

        $('#modal_kode_unit').change(function() {
            var kode_unit = $(this).val();
            if (kode_unit) {
                $.ajax({
                    url: "{{ route('jadwal-pelajaran.get-data-by-unit') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        kode_unit: kode_unit
                    },
                    success: function(res) {
                        var opt = '<option value="">Pilih Kelas</option>';
                        res.kelas.forEach(function(item) {
                            opt += `<option value="${item.kode_kelas}">${item.nama_kelas}</option>`;
                        });
                        $('#modal_kode_kelas').html(opt);
                        loadJadwalModal();
                    }
                });
            }
        });

        $('#modal_kode_kelas, #modal_tanggal').change(function() {
            loadJadwalModal();
        });
    });
</script>

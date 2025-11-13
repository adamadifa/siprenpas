<form action="{{ route('laporanmsdm.cetakpresensi') }}" method="POST" target="_blank" id="formPresensi">
    @csrf
    @if (auth()->user()->kode_unit != 'U06')
        <input type="hidden" name="kode_unit" value="{{ auth()->user()->kode_unit }}">
    @else
        <div class="form-group mb-3">
            <select name="kode_unit" id="kode_unit" class="form-select select2Kodeunitpresensi">
                <option value="">Semua Unit</option>
                @foreach ($unit as $d)
                    <option value="{{ $d->kode_unit }}">{{ textUpperCase($d->nama_unit) }}</option>
                @endforeach
            </select>
        </div>
    @endif

    <div class="form-group mb-3">
        <select name="npp" id="nik_presensi" class="form-select select2Nikpresensi">
            <option value="">Semua Karyawan</option>
        </select>
    </div>
    <div class="row">
        <div class="col">
            <div class="form-group mb-3">
                <select name="bulan" id="bulan" class="form-select">
                    <option value="">Bulan</option>
                    @foreach ($list_bulan as $d)
                        <option {{ date('m') == $d['kode_bulan'] ? 'selected' : '' }} value="{{ $d['kode_bulan'] }}">
                            {{ $d['nama_bulan'] }}</option>
                    @endforeach
                </select>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="co">
            <div class="form-group mb-3">
                <select name="tahun" id="tahun" class="form-select">
                    <option value="">Tahun</option>
                    @for ($t = $start_year; $t <= date('Y'); $t++)
                        <option {{ date('Y') == $t ? 'selected' : '' }} value="{{ $t }}">{{ $t }}
                        </option>
                    @endfor
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-10 col-md-12 col-sm-12">
            <button type="submit" name="submitButton" class="btn btn-primary w-100" id="submitButton">
                <i class="ti ti-printer me-1"></i> Cetak
            </button>
        </div>
        <div class="col-lg-2 col-md-12 col-sm-12">
            <button type="submit" name="exportButton" class="btn btn-success w-100" id="exportButton">
                <i class="ti ti-download"></i>
            </button>
        </div>
    </div>
</form>
@push('myscript')
    <script>
        $(document).ready(function() {
            // Inisialisasi Select2 untuk unit dan karyawan
            if ($('.select2Kodeunitpresensi').length) {
                $('.select2Kodeunitpresensi').each(function() {
                    var $this = $(this);
                    $this.wrap('<div class="position-relative"></div>').select2({
                        placeholder: 'Pilih Unit',
                        dropdownParent: $this.parent(),
                        allowClear: true
                    });
                });
            }

            if ($('.select2Nikpresensi').length) {
                $('.select2Nikpresensi').each(function() {
                    var $this = $(this);
                    $this.wrap('<div class="position-relative"></div>').select2({
                        placeholder: 'Pilih Karyawan',
                        dropdownParent: $this.parent(),
                        allowClear: true
                    });
                });
            }

            // Function untuk load karyawan berdasarkan unit
            function loadKaryawanByUnit(kodeUnit) {
                var selectKaryawan = $('#nik_presensi');

                // Reset select karyawan
                selectKaryawan.empty();
                selectKaryawan.append('<option value="">Semua Karyawan</option>');

                // Jika unit dipilih, ambil data karyawan
                if (kodeUnit) {
                    // Tampilkan loading
                    selectKaryawan.prop('disabled', true);
                    selectKaryawan.html('<option value="">Memuat data...</option>');

                    // AJAX request ke controller
                    $.ajax({
                        url: '{{ route('karyawan.get-by-unit') }}',
                        method: 'GET',
                        data: {
                            kode_unit: kodeUnit
                        },
                        success: function(response) {
                            selectKaryawan.prop('disabled', false);
                            selectKaryawan.empty();
                            selectKaryawan.append('<option value="">Semua Karyawan</option>');

                            if (response.success && response.data.length > 0) {
                                $.each(response.data, function(index, karyawan) {
                                    selectKaryawan.append(
                                        $('<option></option>')
                                        .attr('value', karyawan.npp)
                                        .text(karyawan.nama + ' - ' + karyawan.jabatan)
                                    );
                                });
                            } else {
                                selectKaryawan.append('<option value="">Tidak ada karyawan</option>');
                            }
                        },
                        error: function(xhr, status, error) {
                            selectKaryawan.prop('disabled', false);
                            selectKaryawan.empty();
                            selectKaryawan.append('<option value="">Error memuat data</option>');
                            console.error('Error:', error);
                        }
                    });
                } else {
                    // Jika unit tidak dipilih, reset select karyawan
                    selectKaryawan.prop('disabled', false);
                }
            }

            // Handle change event pada select unit
            $('#kode_unit').on('change', function() {
                var kodeUnit = $(this).val();
                loadKaryawanByUnit(kodeUnit);
            });

            // Load karyawan saat halaman pertama kali dimuat jika unit sudah dipilih
            // Handle untuk select unit atau hidden input
            var kodeUnitAwal = $('#kode_unit').val();
            if (kodeUnitAwal) {
                loadKaryawanByUnit(kodeUnitAwal);
            } else {
                // Cek apakah ada hidden input untuk kode_unit
                var hiddenKodeUnit = $('input[name="kode_unit"]').val();
                if (hiddenKodeUnit) {
                    loadKaryawanByUnit(hiddenKodeUnit);
                }
            }
        });
    </script>
@endpush

@extends('layouts.app')
@section('titlepage', 'Ajukan Pembiayaan')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-4">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md rounded-circle d-flex align-items-center justify-content-center" style="background-color: #e6f4ea; color: #064e3b">
                        <i class="ti ti-file-plus fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-1 fw-extrabold" style="color: #064e3b; letter-spacing: -0.5px;">Ajukan Pembiayaan</h4>
                        <p class="text-muted mb-0 small">Lengkapi formulir pengajuan pembiayaan koperasi Anda</p>
                    </div>
                </div>
                <div class="d-flex flex-column align-items-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('pembiayaan.pinjamansaya') }}" class="text-muted">
                                    <i class="ti ti-cash me-1"></i> Pinjaman Saya
                                </a>
                            </li>
                            <li class="breadcrumb-item active fw-medium" style="color: #064e3b">
                                <i class="ti ti-file-plus me-1"></i> Ajukan Pembiayaan
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    .step-header {
        position: relative;
    }
    .step-dot {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background-color: #f1f3f5;
        color: #6c757d;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        transition: all 0.2s ease;
    }
    .step-dot.active {
        background-color: #064e3b;
        color: #ffffff;
        box-shadow: 0 4px 8px rgba(6, 78, 59, 0.2);
    }
    .step-dot.completed {
        background-color: #28a745;
        color: #ffffff;
    }
    .step-line {
        flex-grow: 1;
        height: 3px;
        background-color: #e9ecef;
    }
    .step-line.active {
        background-color: #064e3b;
    }
</style>

<div class="row">
    <!-- Left side: Employee profile card -->
    <div class="col-lg-12">
        <!-- Employee Profile Summary Card -->
        @if(!empty($karyawan))
            <div class="card border-0 shadow-sm mb-4 rounded-3 overflow-hidden text-white" style="background: linear-gradient(135deg, #064e3b 0%, #043e2f 100%);">
                <div class="card-body p-4">
                    <div class="row align-items-center g-4">
                        <div class="col-auto">
                            <div class="avatar avatar-xl bg-white rounded-3 d-flex align-items-center justify-content-center" style="width: 70px; height: 70px; box-shadow: 0 4px 10px rgba(0,0,0,0.15);">
                                <i class="ti ti-user-check fs-2" style="color: #064e3b;"></i>
                            </div>
                        </div>
                        <div class="col-md">
                            <h4 class="fw-bold mb-1 text-white">{{ $karyawan->nama_lengkap }}</h4>
                            <p class="text-white-50 mb-0 small">NPP: <span class="fw-semibold text-white">{{ $karyawan->npp }}</span></p>
                        </div>
                        <div class="col-md-auto ms-md-auto">
                            <div class="d-flex flex-wrap gap-2">
                                <div class="d-flex align-items-center gap-3 px-3 py-2 rounded-3" style="background: rgba(255, 255, 255, 0.12) !important; border: 1px solid rgba(255, 255, 255, 0.08);">
                                    <i class="ti ti-briefcase text-white fs-4 flex-shrink-0"></i>
                                    <div style="line-height: 1.1;">
                                        <span class="text-white-50 text-uppercase d-block mb-1" style="font-size: 0.6rem; letter-spacing: 0.5px; font-weight: 500;">Jabatan</span>
                                        <span class="fw-bold text-white small">{{ strtoupper($karyawan->nama_jabatan) }}</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-3 px-3 py-2 rounded-3" style="background: rgba(255, 255, 255, 0.12) !important; border: 1px solid rgba(255, 255, 255, 0.08);">
                                    <i class="ti ti-hierarchy-2 text-white fs-4 flex-shrink-0"></i>
                                    <div style="line-height: 1.1;">
                                        <span class="text-white-50 text-uppercase d-block mb-1" style="font-size: 0.6rem; letter-spacing: 0.5px; font-weight: 500;">Departemen</span>
                                        <span class="fw-bold text-white small">{{ strtoupper($karyawan->nama_dept) }}</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-3 px-3 py-2 rounded-3" style="background: rgba(255, 255, 255, 0.12) !important; border: 1px solid rgba(255, 255, 255, 0.08);">
                                    <i class="ti ti-building text-white fs-4 flex-shrink-0"></i>
                                    <div style="line-height: 1.1;">
                                        <span class="text-white-50 text-uppercase d-block mb-1" style="font-size: 0.6rem; letter-spacing: 0.5px; font-weight: 500;">Unit Kerja</span>
                                        <span class="fw-bold text-white small">{{ strtoupper($karyawan->nama_unit) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Main Form Area -->
    <div class="col-lg-12">
        <div class="card border-0 shadow-sm rounded-3 bg-white p-4">
            <!-- Step Indicators -->
            <div class="d-flex align-items-center justify-content-between mb-4 mx-auto" style="max-width: 500px;">
                <div class="d-flex align-items-center gap-2">
                    <div class="step-dot active" id="dot-1">1</div>
                    <span class="fw-bold text-dark small">Data Diri & Alamat</span>
                </div>
                <div class="step-line" id="line-1"></div>
                <div class="d-flex align-items-center gap-2">
                    <div class="step-dot" id="dot-2">2</div>
                    <span class="fw-bold text-muted small" id="lbl-2">Pengajuan Pembiayaan</span>
                </div>
            </div>

            <!-- Error Banner -->
            <div id="form-error-banner" class="alert alert-danger d-none border-0 shadow-sm mb-4"></div>

            <form id="formPembiayaan" action="{{ route('pembiayaan.storepinjaman') }}" method="POST" autocomplete="off">
                @csrf
                <input type="hidden" name="no_anggota" id="no_anggota" value="{{ $anggota->no_anggota }}" />

                <!-- STEP 1: Data Diri & Alamat -->
                <div class="form-step-section" id="step-1-form">
                    <div class="row g-3">
                        <div class="col-12"><h5 class="fw-bold text-dark mb-2">A. Data Diri Pemohon</h5></div>
                        <div class="col-md-6">
                            <x-input-with-icon-label icon="ti ti-credit-card" label="Nomor Identitas (NIK)" name="nik" value="{{ $anggota->nik }}" readonly="true" />
                        </div>
                        <div class="col-md-6">
                            <x-input-with-icon-label icon="ti ti-user" label="Nama Lengkap" name="nama_lengkap" value="{{ $anggota->nama_lengkap }}" readonly="true" />
                        </div>
                        <div class="col-md-6">
                            <x-input-with-icon-label icon="ti ti-map-pin" label="Tempat Lahir" name="tempat_lahir" value="{{ $anggota->tempat_lahir }}" />
                        </div>
                        <div class="col-md-6">
                            <x-input-with-icon-label icon="ti ti-calendar" label="Tanggal Lahir" name="tanggal_lahir" datepicker="flatpickr-date" value="{{ $anggota->tanggal_lahir }}" />
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">Jenis Kelamin</label>
                                <select name="jenis_kelamin" id="jenis_kelamin" class="form-select">
                                    <option value="L" {{ $anggota->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-Laki</option>
                                    <option value="P" {{ $anggota->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">Pendidikan Terakhir</label>
                                <select name="pendidikan_terakhir" id="pendidikan_terakhir" class="form-select">
                                    @foreach ($pendidikan as $p)
                                        <option value="{{ $p }}" {{ $anggota->pendidikan_terakhir == $p ? 'selected' : '' }}>{{ $p }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">Status Pernikahan</label>
                                <select name="status_pernikahan" id="status_pernikahan" class="form-select">
                                    <option value="M" {{ $anggota->status_pernikahan == 'M' ? 'selected' : '' }}>Menikah</option>
                                    <option value="BM" {{ $anggota->status_pernikahan == 'BM' ? 'selected' : '' }}>Belum Menikah</option>
                                    <option value="JD" {{ $anggota->status_pernikahan == 'JD' ? 'selected' : '' }}>Janda/Duda</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <x-input-with-icon-label icon="ti ti-phone" label="Nomor HP Aktif" name="no_hp" value="{{ $anggota->no_hp }}" />
                        </div>

                        <div class="col-12 mt-4"><h5 class="fw-bold text-dark mb-2">B. Data Alamat Tempat Tinggal</h5></div>
                        <div class="col-12">
                            <x-textarea-label name="alamat" label="Alamat Lengkap" value="{{ $anggota->alamat }}" />
                        </div>
                        <div class="col-md-6">
                            <x-select-label label="Provinsi" name="id_province" :data="$provinsi" key="id" textShow="name" select2="select2Provinsi" upperCase="true" value="{{ $anggota->id_province }}" />
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">Kabupaten / Kota</label>
                                <select name="id_regency" id="id_regency" class="select2Regency form-select">
                                    <option value="">Kabupaten / Kota</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">Kecamatan</label>
                                <select name="id_district" id="id_district" class="select2District form-select">
                                    <option value="">Kecamatan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">Desa / Kelurahan</label>
                                <select name="id_village" id="id_village" class="select2Village form-select">
                                    <option value="">Desa / Kelurahan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <x-input-with-icon-label icon="ti ti-mailbox" label="Kode Pos" name="kode_pos" value="{{ $anggota->kode_pos }}" />
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">Status Tinggal</label>
                                <select name="status_tinggal" id="status_tinggal" class="form-select">
                                    <option value="MS" {{ $anggota->status_tinggal == 'MS' ? 'selected' : '' }}>Milik Sendiri</option>
                                    <option value="MK" {{ $anggota->status_tinggal == 'MK' ? 'selected' : '' }}>Milik Keluarga</option>
                                    <option value="SK" {{ $anggota->status_tinggal == 'SK' ? 'selected' : '' }}>Sewa / Kontrak</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12 d-flex justify-content-end gap-2 mt-4">
                            <button type="button" class="btn btn-primary px-4 d-flex align-items-center gap-2" id="btn-next-step" style="height: 38px; background-color: #064e3b; border-color: #064e3b; border-radius: 8px;">
                                <span>Selanjutnya</span>
                                <i class="ti ti-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- STEP 2: Rencana Pembiayaan -->
                <div class="form-step-section d-none" id="step-2-form">
                    <div class="row g-3">
                        <div class="col-12"><h5 class="fw-bold text-dark mb-2">C. Detail Pengajuan Pembiayaan</h5></div>
                        
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">Jenis Pembiayaan</label>
                                <select name="kode_pembiayaan" id="kode_pembiayaan" class="form-select">
                                    <option value="">Pilih Jenis Pembiayaan</option>
                                    @foreach ($jenis_pembiayaan as $j)
                                        <option value="{{ $j->kode_pembiayaan }}" data-persentase="{{ $j->persentase }}">{{ $j->jenis_pembiayaan }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <x-input-with-icon-label icon="ti ti-cash" label="Jumlah Pembiayaan (Rp)" name="jumlah" id="jumlah_input" placeholder="Masukkan jumlah pinjaman" />
                        </div>

                        <div class="col-md-6">
                            <x-input-with-icon-label icon="ti ti-percent" label="Persentase Jasa / Bunga (%)" name="persentase" id="persentase_input" readonly="true" />
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">Jangka Waktu (Tenor Bulan)</label>
                                <select name="jangka_waktu" id="jangka_waktu_input" class="form-select">
                                    <option value="6">6 Bulan</option>
                                    <option value="12" selected>12 Bulan</option>
                                    <option value="18">18 Bulan</option>
                                    <option value="24">24 Bulan</option>
                                    <option value="36">36 Bulan</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <x-input-with-icon-label icon="ti ti-scale" label="Jumlah Total Pengembalian" name="jumlah_pengembalian" id="jumlah_pengembalian_input" readonly="true" />
                        </div>

                        <div class="col-md-6">
                            <x-input-with-icon-label icon="ti ti-list" label="Keperluan Pembiayaan" name="keperluan" placeholder="Contoh: Pembelian Laptop Kerja" />
                        </div>

                        <div class="col-md-6">
                            <x-input-with-icon-label icon="ti ti-shield" label="Jaminan Pembiayaan" name="jaminan" placeholder="Contoh: Ijazah Asli / BPKB Motor" />
                        </div>

                        <!-- Repayment Summary Card -->
                        <div class="col-12 mt-3">
                            <div class="card bg-light border-0 p-3 rounded-3">
                                <h6 class="fw-bold mb-3 d-flex align-items-center gap-2" style="color: #064e3b;">
                                    <i class="ti ti-calculator"></i>
                                    Simulasi Rencana Angsuran
                                </h6>
                                <div class="row g-2">
                                    <div class="col-sm-6 d-flex justify-content-between border-bottom py-1 text-secondary">
                                        <span>Pokok Pinjaman</span>
                                        <span class="fw-bold text-dark font-monospace" id="sim-pokok">Rp 0</span>
                                    </div>
                                    <div class="col-sm-6 d-flex justify-content-between border-bottom py-1 text-secondary">
                                        <span>Total Jasa Koperasi</span>
                                        <span class="fw-bold text-dark font-monospace" id="sim-jasa">Rp 0</span>
                                    </div>
                                    <div class="col-sm-12 d-flex justify-content-between py-2 text-success" style="font-size: 1.1rem;">
                                        <span class="fw-bold">Estimasi Angsuran Per Bulan</span>
                                        <span class="fw-extrabold font-monospace" id="sim-angsuran">Rp 0 / Bulan</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 d-flex justify-content-end gap-2 mt-4">
                            <button type="button" class="btn btn-outline-secondary px-4 d-flex align-items-center gap-2" id="btn-prev-step" style="height: 38px; border-radius: 8px;">
                                <i class="ti ti-arrow-left"></i>
                                <span>Kembali</span>
                            </button>
                            <button type="submit" class="btn btn-success px-4 d-flex align-items-center gap-2" id="btn-submit-form" style="height: 38px; background-color: #064e3b; border-color: #064e3b; border-radius: 8px;">
                                <i class="ti ti-check"></i>
                                <span>Kirim Pengajuan</span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('myscript')
<script>
    $(function() {
        // Handle step transition
        $('#btn-next-step').click(function() {
            // Basic step 1 validation
            const nik = $('#nik').val();
            const nama = $('#nama_lengkap').val();
            const phone = $('#no_hp').val();
            const alamat = $('textarea[name="alamat"]').val();

            if (!phone || !alamat) {
                $('#form-error-banner').removeClass('d-none').text('Harap lengkapi semua kolom bertanda wajib (Alamat, No HP)');
                window.scrollTo({top: 0, behavior: 'smooth'});
                return;
            }

            $('#form-error-banner').addClass('d-none');
            $('#step-1-form').addClass('d-none');
            $('#step-2-form').removeClass('d-none');
            
            $('#dot-1').removeClass('active').addClass('completed').html('<i class="ti ti-check text-white"></i>');
            $('#dot-2').addClass('active');
            $('#lbl-2').removeClass('text-muted').addClass('fw-bold text-dark');
            $('#line-1').addClass('active');
        });

        $('#btn-prev-step').click(function() {
            $('#step-2-form').addClass('d-none');
            $('#step-1-form').removeClass('d-none');
            
            $('#dot-1').addClass('active').removeClass('completed').text('1');
            $('#dot-2').removeClass('active');
            $('#lbl-2').addClass('text-muted').removeClass('fw-bold text-dark');
            $('#line-1').removeClass('active');
        });

        // Auto calculation logic
        function calculateInstallments() {
            // Get raw amount
            let rawAmount = $('#jumlah_input').val() || '0';
            rawAmount = parseFloat(rawAmount.replace(/[^0-9]/g, '')) || 0;
            
            // Get interest rate
            const rawRate = parseFloat($('#persentase_input').val()) || 0;
            
            // Get tenor
            const tenor = parseInt($('#jangka_waktu_input').val()) || 12;

            if (rawAmount > 0) {
                const totalJasa = rawAmount * (rawRate / 100);
                const totalRepayment = rawAmount + totalJasa;
                const monthlyInstallment = Math.round(totalRepayment / tenor);

                // Update input field
                $('#jumlah_pengembalian_input').val(formatRupiah(totalRepayment.toString(), 'Rp. '));

                // Update simulation text displays
                $('#sim-pokok').text(formatRupiah(rawAmount.toString(), 'Rp '));
                $('#sim-jasa').text(formatRupiah(totalJasa.toString(), 'Rp '));
                $('#sim-angsuran').text(formatRupiah(monthlyInstallment.toString(), 'Rp ') + ' / Bulan');
            } else {
                $('#jumlah_pengembalian_input').val('');
                $('#sim-pokok').text('Rp 0');
                $('#sim-jasa').text('Rp 0');
                $('#sim-angsuran').text('Rp 0 / Bulan');
            }
        }

        // Auto-detect percentage when choosing loan type
        $('#kode_pembiayaan').change(function() {
            const selectedOption = $(this).find('option:selected');
            const rate = selectedOption.attr('data-persentase') || '0';
            $('#persentase_input').val(rate);
            calculateInstallments();
        });

        // Trigger on inputs keyup/change
        $('#jumlah_input').on('keyup input', function() {
            // Format to rupiah visual input
            $(this).val(formatRupiah($(this).val(), ''));
            calculateInstallments();
        });

        $('#jangka_waktu_input').change(function() {
            calculateInstallments();
        });

        // Helper to format currency
        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^0-9]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                var separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? prefix + rupiah : '');
        }

        // Form Submit Validation
        $('#formPembiayaan').submit(function(e) {
            const code = $('#kode_pembiayaan').val();
            const amount = $('#jumlah_input').val();
            if (!code || !amount) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Silakan pilih Jenis Pembiayaan dan masukkan Jumlah Pembiayaan terlebih dahulu!'
                });
                return false;
            }
        });

        // Load Regencies dynamically based on selected Province
        $('#id_province').change(function() {
            var id_province = $(this).val();
            if (id_province) {
                $.ajax({
                    type: 'POST',
                    url: '/regency/getregency',
                    data: {
                        _token: "{{ csrf_token() }}",
                        id_province: id_province
                    },
                    cache: false,
                    success: function(respond) {
                        $('#id_regency').html(respond);
                        // Trigger next select resets
                        $('#id_district').html('<option value="">Kecamatan</option>');
                        $('#id_village').html('<option value="">Desa / Kelurahan</option>');
                        
                        // Set selected if exists in user data
                        var userRegency = "{{ $anggota->id_regency }}";
                        if (userRegency) {
                            $('#id_regency').val(userRegency).trigger('change');
                        }
                    }
                });
            }
        });

        $('#id_regency').change(function() {
            var id_regency = $(this).val();
            if (id_regency) {
                $.ajax({
                    type: 'POST',
                    url: '/district/getdistrict',
                    data: {
                        _token: "{{ csrf_token() }}",
                        id_regency: id_regency
                    },
                    cache: false,
                    success: function(respond) {
                        $('#id_district').html(respond);
                        $('#id_village').html('<option value="">Desa / Kelurahan</option>');
                        
                        var userDistrict = "{{ $anggota->id_district }}";
                        if (userDistrict) {
                            $('#id_district').val(userDistrict).trigger('change');
                        }
                    }
                });
            }
        });

        $('#id_district').change(function() {
            var id_district = $(this).val();
            if (id_district) {
                $.ajax({
                    type: 'POST',
                    url: '/village/getvillage',
                    data: {
                        _token: "{{ csrf_token() }}",
                        id_district: id_district
                    },
                    cache: false,
                    success: function(respond) {
                        $('#id_village').html(respond);
                        
                        var userVillage = "{{ $anggota->id_village }}";
                        if (userVillage) {
                            $('#id_village').val(userVillage);
                        }
                    }
                });
            }
        });

        // Trigger chain load initially
        var initialProv = "{{ $anggota->id_province }}";
        if (initialProv) {
            $('#id_province').val(initialProv).trigger('change');
        }
    });
</script>
@endpush

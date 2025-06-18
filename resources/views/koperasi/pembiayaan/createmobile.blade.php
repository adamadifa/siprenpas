@extends('layouts.mobile.app')
@section('content')
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_blue.css">

    <style>
        /* Step Indicator */
        .step-indicator {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .step-indicator .circle {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #e0e0e0;
            color: #888;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin: 0 8px;
            transition: all 0.2s;
        }

        .step-indicator .active {
            background: var(--fimobile-green, #3ac79b);
            color: #fff;
            box-shadow: 0 2px 8px #3ac79b33;
        }

        /* Material Input */
        .md-group {
            position: relative;
            margin-bottom: 22px;
        }

        .md-input,
        .md-select,
        .md-textarea {
            width: 100%;
            border: none;
            border-bottom: 2px solid #ccc;
            outline: none;
            background: transparent;
            font-size: 1em;
            padding: 10px 0 8px 0;
            transition: border-color 0.2s;
            color: #222;
        }

        .md-input:focus,
        .md-select:focus,
        .md-textarea:focus {
            border-bottom: 2px solid #1976d2;
        }

        .md-input:disabled {
            background: #f3f3f3;
            color: #999;
        }

        .md-select {
            appearance: none;
            -webkit-appearance: none;
            background: url('data:image/svg+xml;utf8,<svg fill="gray" height="20" viewBox="0 0 24 24" width="20" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/></svg>') no-repeat right 6px center/18px 18px;
        }

        .md-textarea {
            min-height: 38px;
            resize: vertical;
        }

        .md-btn {
            width: 100%;
            background: var(--fimobile-green, #3ac79b);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 1.1em;
            font-weight: 600;
            padding: 12px 0;
            margin-top: 16px;
            box-shadow: 0 2px 8px #3ac79b33;
            transition: background 0.2s;
        }

        .md-btn:active {
            background: #237a62;
        }

        .step-indicator {
            margin-top: 10px;
        }

        .d-flex {
            display: flex;
        }

        .justify-content-between {
            justify-content: space-between;
        }

        .w-49 {
            width: 49%;
        }

        .d-none {
            display: none;
        }

        body,
        .appContent {
            background: #e3f2fd !important;
        }

        .form-step {
            display: none;
        }

        .form-step.active {
            display: block;
        }

        .form-mobile-label {
            font-weight: 600;
            margin-bottom: 4px;
        }

        .form-mobile-input {
            border-radius: 10px;
            margin-bottom: 14px;
        }

        .form-mobile-select {
            border-radius: 10px;
            margin-bottom: 14px;
        }

        .form-mobile-textarea {
            border-radius: 10px;
            margin-bottom: 14px;
        }

        /* Custom flatpickr override untuk warna utama */
        .flatpickr-calendar {
            border-radius: 12px;
            border: 1.5px solid #32745e;
            box-shadow: 0 2px 16px #32745e22;
            z-index: 1050 !important;
        }

        .appHeader,
        .header-section,
        .mobile-header {
            z-index: 2000 !important;
        }

        .flatpickr-months .flatpickr-month {
            background: #32745e;
            color: #fff;
            border-radius: 12px 12px 0 0;
        }

        .flatpickr-current-month .flatpickr-monthDropdown-months,
        .flatpickr-current-month input.cur-year {
            background: transparent;
            color: #fff;
        }

        .flatpickr-weekdays {
            background: #32745e;
            color: #fff;
        }

        .flatpickr-weekday {
            background: #32745e !important;
            color: #fff !important;
            border: none;
        }

        .flatpickr-days {
            background: #fff;
        }

        .flatpickr-day.selected,
        .flatpickr-day.startRange,
        .flatpickr-day.endRange,
        .flatpickr-day.selected.inRange,
        .flatpickr-day.startRange.inRange,
        .flatpickr-day.endRange.inRange,
        .flatpickr-day.selected:focus,
        .flatpickr-day.selected:hover {
            background: #32745e;
            border-color: #32745e;
            color: #fff;
        }

        .flatpickr-day.today {
            border-color: #32745e;
        }

        .flatpickr-next-month,
        .flatpickr-prev-month {
            fill: #fff;
        }

        .flatpickr-monthDropdown-months .flatpickr-monthDropdown-month {
            color: #222;
        }

        .flatpickr-next-month,
        .flatpickr-prev-month {
            fill: #fff;
        }
    </style>
    <div id="header-section">
        <div class="appHeader bg-primary text-light">
            <div class="left">
                <a href="javascript:;" class="headerButton goBack">
                    <ion-icon name="chevron-back-outline"></ion-icon>
                </a>
            </div>
            <div class="pageTitle">Ajukan Pembiayaan</div>
            <div class="right"></div>
        </div>
    </div>
    <div id="content-section" style="margin-top: 70px; padding-bottom:120px; padding-left:16px; padding-right:16px;">
        <div class="step-indicator">
            <div class="circle step-circle-1 active">1</div>
            <div class="circle step-circle-2">2</div>
            <div class="circle step-circle-3">3</div>
        </div>
        <div id="step-error" class="alert-error"
            style="display:none;background:#ffebee;color:#b71c1c;padding:10px 16px;margin-bottom:16px;border-radius:6px;font-size:0.98em;">
        </div>
        <form id="formPembiayaan" action="{{ route('pembiayaan.store') }}" method="POST" autocomplete="off">
            @csrf
            <!-- STEP 1: Data Pribadi -->
            <div class="form-step step-1 active">

                <div class="md-group">
                    <label class="form-mobile-label" for="nik">Nomor Identitas</label>
                    <input type="text" class="md-input" id="nik" name="nik"
                        value="{{ old('nik', isset($anggota) ? $anggota->nik : '') }}" placeholder="Nomor Identitas">
                </div>
                <div class="md-group">
                    <label class="form-mobile-label" for="nama_lengkap">Nama Lengkap</label>
                    <input type="text" class="md-input" id="nama_lengkap" name="nama_lengkap"
                        value="{{ old('nama_lengkap', isset($anggota) ? $anggota->nama_lengkap : '') }}"
                        placeholder="Nama Lengkap">
                </div>
                <div class="md-group">
                    <label class="form-mobile-label" for="tempat_lahir">Tempat Lahir</label>
                    <input type="text" class="md-input" id="tempat_lahir" name="tempat_lahir"
                        value="{{ old('tempat_lahir', isset($anggota) ? $anggota->tempat_lahir : '') }}"
                        placeholder="Tempat Lahir">
                </div>
                <div class="md-group">
                    <label class="form-mobile-label" for="tanggal_lahir">Tanggal Lahir</label>
                    <input type="text" class="md-input" id="tanggal_lahir" name="tanggal_lahir"
                        value="{{ old('tanggal_lahir', isset($anggota) ? $anggota->tanggal_lahir : '') }}"
                        placeholder="Tanggal Lahir">
                </div>
                <div class="md-group">
                    <label class="form-mobile-label" for="jenis_kelamin">Jenis Kelamin</label>
                    <select name="jenis_kelamin" id="jenis_kelamin" class="md-select">
                        <option value="">Jenis Kelamin</option>
                        <option value="L"
                            {{ old('jenis_kelamin', isset($anggota) ? $anggota->jenis_kelamin : '') == 'L' ? 'selected' : '' }}>
                            Laki - Laki</option>
                        <option value="P"
                            {{ old('jenis_kelamin', isset($anggota) ? $anggota->jenis_kelamin : '') == 'P' ? 'selected' : '' }}>
                            Perempuan</option>
                    </select>
                </div>
                <div class="md-group">
                    <label class="form-mobile-label" for="pendidikan_terakhir">Pendidikan Terakhir</label>
                    <select name="pendidikan_terakhir" id="pendidikan_terakhir" class="md-select">
                        <option value="">Pendidikan Terakhir</option>
                        @foreach ($pendidikan as $p)
                            <option value="{{ $p }}"
                                {{ old('pendidikan_terakhir', isset($anggota) ? $anggota->pendidikan_terakhir : '') == $p ? 'selected' : '' }}>
                                {{ $p }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="md-group">
                    <label class="form-mobile-label" for="status_pernikahan">Status Pernikahan</label>
                    <select name="status_pernikahan" id="status_pernikahan" class="md-select">
                        <option value="">Status Pernikahan</option>
                        <option value="M"
                            {{ old('status_pernikahan', isset($anggota) ? $anggota->status_pernikahan : '') == 'M' ? 'selected' : '' }}>
                            Menikah</option>
                        <option value="BM"
                            {{ old('status_pernikahan', isset($anggota) ? $anggota->status_pernikahan : '') == 'BM' ? 'selected' : '' }}>
                            Belum Menikah</option>
                        <option value="JD"
                            {{ old('status_pernikahan', isset($anggota) ? $anggota->status_pernikahan : '') == 'JD' ? 'selected' : '' }}>
                            Janda/Duda</option>
                    </select>
                </div>
                <div class="md-group">
                    <label class="form-mobile-label" for="jml_tanggungan">Jumlah Tanggungan</label>
                    <input type="number" class="md-input" id="jml_tanggungan" name="jml_tanggungan"
                        value="{{ old('jml_tanggungan', isset($anggota) ? $anggota->jml_tanggungan : '') }}"
                        placeholder="Jumlah Tanggungan">
                </div>
                <div class="md-group">
                    <label class="form-mobile-label" for="nama_pasangan">Nama Pasangan</label>
                    <input type="text" class="md-input" id="nama_pasangan" name="nama_pasangan"
                        value="{{ old('nama_pasangan', isset($anggota) ? $anggota->nama_pasangan : '') }}"
                        placeholder="Nama Pasangan">
                </div>
                <div class="md-group">
                    <label class="form-mobile-label" for="pekerjaan_pasangan">Pekerjaan Pasangan</label>
                    <input type="text" class="md-input" id="pekerjaan_pasangan" name="pekerjaan_pasangan"
                        value="{{ old('pekerjaan_pasangan', isset($anggota) ? $anggota->pekerjaan_pasangan : '') }}"
                        placeholder="Pekerjaan Pasangan">
                </div>
                <div class="md-group">
                    <label class="form-mobile-label" for="nama_ibu">Nama Ibu</label>
                    <input type="text" class="md-input" id="nama_ibu" name="nama_ibu"
                        value="{{ old('nama_ibu', isset($anggota) ? $anggota->nama_ibu : '') }}" placeholder="Nama Ibu">
                </div>
                <div class="md-group">
                    <label class="form-mobile-label" for="nama_saudara">Nama Saudara</label>
                    <input type="text" class="md-input" id="nama_saudara" name="nama_saudara"
                        value="{{ old('nama_saudara', isset($anggota) ? $anggota->nama_saudara : '') }}"
                        placeholder="Nama Saudara">
                </div>
                <div class="md-group">
                    <label class="form-mobile-label" for="no_hp">No. HP</label>
                    <input type="text" class="md-input" id="no_hp" name="no_hp"
                        value="{{ old('no_hp', isset($anggota) ? $anggota->no_hp : '') }}" placeholder="No. HP">
                </div>
                <button type="button" class="md-btn" id="nextStep1">Selanjutnya</button>
            </div>
            <!-- STEP 2: Data Alamat -->
            <div class="form-step step-2">
                <div class="md-group">
                    <label class="form-mobile-label" for="alamat">Alamat</label>
                    <textarea class="md-textarea" id="alamat" name="alamat" placeholder="Alamat">{{ old('alamat', isset($anggota) ? $anggota->alamat : '') }}</textarea>
                </div>
                <div class="md-group">
                    <label class="form-mobile-label" for="id_province">Provinsi</label>
                    <select name="id_province" class="md-select select2Provinsi" id="id_province">
                        <option value="">Provinsi</option>
                        @foreach ($provinsi as $prov)
                            <option {{ $anggota->id_province == $prov->id ? 'selected' : '' }}
                                value="{{ $prov->id }}">{{ strtoupper($prov->name) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="md-group">
                    <label class="form-mobile-label" for="id_regency">Kabupaten / Kota</label>
                    <select name="id_regency" id="id_regency" class="md-select select2Regency">
                        <option value="">Kabupaten / Kota</option>
                    </select>
                </div>
                <div class="md-group">
                    <label class="form-mobile-label" for="id_district">Kecamatan</label>
                    <select name="id_district" id="id_district" class="md-select select2District">
                        <option value="">Kecamatan</option>
                    </select>
                </div>
                <div class="md-group">
                    <label class="form-mobile-label" for="id_village">Desa / Kelurahan</label>
                    <select name="id_village" id="id_village" class="md-select select2Village">
                        <option value="">Desa / Kelurahan</option>
                    </select>
                </div>
                <div class="md-group">
                    <label class="form-mobile-label" for="kode_pos">Kode Pos</label>
                    <input type="text" class="md-input" id="kode_pos" name="kode_pos"
                        value="{{ old('kode_pos', isset($anggota) ? $anggota->kode_pos : '') }}" placeholder="Kode Pos">
                </div>
                <div class="md-group">
                    <label class="form-mobile-label" for="status_tinggal">Status Tinggal</label>
                    <select name="status_tinggal" id="status_tinggal" class="md-select">
                        <option value="">Status Tinggal</option>
                        <option value="MS"
                            {{ old('status_tinggal', isset($anggota) ? $anggota->status_tinggal : '') == 'MS' ? 'selected' : '' }}>
                            Milik Sendiri</option>
                        <option value="MK"
                            {{ old('status_tinggal', isset($anggota) ? $anggota->status_tinggal : '') == 'MK' ? 'selected' : '' }}>
                            Milik Keluarga</option>
                        <option value="SK"
                            {{ old('status_tinggal', isset($anggota) ? $anggota->status_tinggal : '') == 'SK' ? 'selected' : '' }}>
                            Sewa / Kontrak</option>
                    </select>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="button" class="md-btn" style="background:#b0bec5;color:#222;"
                        id="prevStep2">Sebelumnya</button>
                    <button type="button" class="md-btn" id="nextStep2">Selanjutnya</button>
                </div>
            </div>
            <!-- STEP 3: Data Pembiayaan -->
            <div class="form-step step-3">
                <div class="md-group">
                    <label class="form-mobile-label" for="kode_pembiayaan">Jenis Pembiayaan</label>
                    <select name="kode_pembiayaan" id="kode_pembiayaan" class="md-select">
                        <option value="">Jenis Pembiayaan</option>
                        @foreach ($jenis_pembiayaan as $d)
                            <option value="{{ $d->kode_pembiayaan }}" persentase="{{ $d->persentase }}">
                                {{ $d->jenis_pembiayaan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="md-group">
                    <label class="form-mobile-label" for="persentase">Persentase (%)</label>
                    <input type="text" class="md-input" name="persentase" id="persentase" value="0"
                        placeholder="Persentase (%)" readonly>
                </div>
                <div class="md-group">
                    <label class="form-mobile-label" for="jangka_waktu">Jangka Waktu</label>
                    <select name="jangka_waktu" id="jangka_waktu" class="md-select">
                        <option value="">Jangka Waktu</option>
                        @for ($i = 1; $i <= 20; $i++)
                            <option value="{{ $i }}">{{ $i }} Bulan</option>
                        @endfor
                    </select>
                </div>
                <div class="md-group">
                    <label class="form-mobile-label" for="jumlah">Jumlah Pembiayaan</label>
                    <input type="text" class="md-input text-right" name="jumlah" id="jumlah"
                        value="{{ old('jumlah') }}" placeholder="Jumlah Pembiayaan">
                </div>
                <div class="md-group">
                    <label class="form-mobile-label" for="jumlah_pengembalian">Jumlah Pengembalian</label>
                    <input type="text" class="md-input text-right" name="jumlah_pengembalian"
                        id="jumlah_pengembalian" value="{{ old('jumlah_pengembalian') }}"
                        placeholder="Jumlah Pengembalian" readonly>
                </div>
                <div class="md-group">
                    <label class="form-mobile-label" for="keperluan">Keperluan</label>
                    <textarea class="md-textarea" id="keperluan" name="keperluan" placeholder="Keperluan">{{ old('keperluan') }}</textarea>
                </div>
                <div class="md-group">
                    <label class="form-mobile-label" for="jaminan">Jaminan</label>
                    <input type="text" class="md-input" id="jaminan" name="jaminan" value="{{ old('jaminan') }}"
                        placeholder="Jaminan">
                </div>
                <div class="d-flex justify-content-between">
                    <button type="button" class="md-btn" style="background:#b0bec5;color:#222;"
                        id="prevStep3">Sebelumnya</button>
                    <button class="md-btn" id="btnSimpan" type="submit">
                        <ion-icon name="send-outline" class="me-1"></ion-icon>
                        Submit
                    </button>
                </div>
            </div>
        </form>
    </div>
    <script>
        // Step form logic & validation
        const steps = document.querySelectorAll('.form-step');
        const circles = document.querySelectorAll('.step-indicator .circle');
        let currentStep = 0;

        function showStep(idx) {
            steps.forEach((s, i) => s.classList.toggle('active', i === idx));
            circles.forEach((c, i) => c.classList.toggle('active', i === idx));
            currentStep = idx;
        }

        function validateStep(stepIdx) {
            const step = steps[stepIdx];
            let valid = true;
            step.querySelectorAll('.md-input, .md-select, .md-textarea').forEach(el => {
                // skip disabled fields
                if (el.disabled) return;
                // Cari/siapkan container error
                let errDiv = el.parentNode.querySelector('.field-error');
                if (!errDiv) {
                    errDiv = document.createElement('div');
                    errDiv.className = 'field-error';
                    errDiv.style.color = '#b71c1c';
                    errDiv.style.fontSize = '0.88em';
                    errDiv.style.marginTop = '2px';
                    errDiv.style.marginBottom = '2px';
                    el.parentNode.appendChild(errDiv);
                }
                // Cek kosong
                let isEmpty = (el.tagName === 'SELECT' && (!el.value || el.value === '')) ||
                    (el.tagName === 'TEXTAREA' && !el.value.trim()) ||
                    (el.tagName === 'INPUT' && !el.value.trim());
                if (isEmpty) {
                    el.style.borderColor = 'red';
                    errDiv.innerText = 'Wajib diisi';
                    errDiv.style.display = 'block';
                    valid = false;
                } else {
                    el.style.borderColor = '';
                    errDiv.innerText = '';
                    errDiv.style.display = 'none';
                }
            });
            return valid;
        }

        // Fungsi untuk pasang event listener pada input aktif di step saat ini
        function attachFieldListeners(stepIdx) {
            const step = steps[stepIdx];
            step.querySelectorAll('.md-input, .md-select, .md-textarea').forEach(function(el) {
                el.addEventListener('input', function() {
                    if (el.value && el.style.borderColor === 'red') {
                        el.style.borderColor = '';
                        let errDiv = el.parentNode.querySelector('.field-error');
                        if (errDiv) {
                            errDiv.innerText = '';
                            errDiv.style.display = 'none';
                        }
                    }
                });
                el.addEventListener('change', function() {
                    if (el.value && el.style.borderColor === 'red') {
                        el.style.borderColor = '';
                        let errDiv = el.parentNode.querySelector('.field-error');
                        if (errDiv) {
                            errDiv.innerText = '';
                            errDiv.style.display = 'none';
                        }
                    }
                });
            });
        }
        // Pasang listener awal untuk step 0
        attachFieldListeners(0);

        function showStepError(msg) {
            const err = document.getElementById('step-error');
            err.innerText = msg;
            err.style.display = 'block';
        }

        function hideStepError() {
            const err = document.getElementById('step-error');
            err.innerText = '';
            err.style.display = 'none';
        }

        document.getElementById('nextStep1').onclick = function() {
            console.log('Klik Next Step 1');
            if (!validateStep(0)) {
                console.log('Validasi step 1 gagal');
                showStepError('Semua field pada langkah ini wajib diisi!');
                attachFieldListeners(0);
                return;
            }
            hideStepError();
            showStep(1);
            setTimeout(() => attachFieldListeners(1), 100);
        };
        document.getElementById('prevStep2').onclick = function() {
            showStep(0);
        };
        document.getElementById('nextStep2').onclick = function() {
            if (!validateStep(1)) {
                showStepError('Semua field pada langkah ini wajib diisi!');
                attachFieldListeners(1);
                return;
            }
            hideStepError();
            showStep(2);
            setTimeout(() => attachFieldListeners(2), 100);
        };

        document.getElementById('prevStep3').onclick = function() {
            showStep(1);
        };
        // Validasi semua field saat submit
        document.getElementById('formPembiayaan').addEventListener('submit', function(e) {
            let allValid = true;
            // Cek semua step
            steps.forEach((step, idx) => {
                step.querySelectorAll('.md-input, .md-select, .md-textarea').forEach(el => {
                    if (el.disabled) return;
                    let errDiv = el.parentNode.querySelector('.field-error');
                    if (!errDiv) {
                        errDiv = document.createElement('div');
                        errDiv.className = 'field-error';
                        errDiv.style.color = '#b71c1c';
                        errDiv.style.fontSize = '0.88em';
                        errDiv.style.marginTop = '2px';
                        errDiv.style.marginBottom = '2px';
                        el.parentNode.appendChild(errDiv);
                    }
                    let isEmpty = (el.tagName === 'SELECT' && (!el.value || el.value === '')) ||
                        (el.tagName === 'TEXTAREA' && !el.value.trim()) ||
                        (el.tagName === 'INPUT' && !el.value.trim());
                    if (isEmpty) {
                        el.style.borderColor = 'red';
                        errDiv.innerText = 'Wajib diisi';
                        errDiv.style.display = 'block';
                        allValid = false;
                    } else {
                        el.style.borderColor = '';
                        errDiv.innerText = '';
                        errDiv.style.display = 'none';
                    }
                });
            });
            if (!allValid) {
                showStepError('Semua field wajib diisi sebelum submit!');
                // Scroll ke step pertama yang error
                for (let i = 0; i < steps.length; i++) {
                    let hasError = steps[i].querySelector('.field-error[style*="display: block"]');
                    if (hasError) {
                        showStep(i);
                        hasError.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                        break;
                    }
                }
                e.preventDefault();
                return false;
            } else {
                hideStepError();
            }
        });
        // Inisialisasi flatpickr untuk semua input tanggal
        document.addEventListener('DOMContentLoaded', function() {
            if (window.flatpickr) {
                document.querySelectorAll('input[name="tanggal"], input[name="tanggal_lahir"]')
                    .forEach(function(el) {
                        flatpickr(el, {
                            dateFormat: 'Y-m-d',
                            allowInput: true,
                            theme: 'material_blue',
                            position: 'below', // Selalu tampil di bawah input
                        });
                    });
            }
        });
        // Flatpickr JS
        if (!window.flatpickrLoaded) {
            var script = document.createElement('script');
            script.src = 'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.js';
            script.onload = function() {
                window.flatpickrLoaded = true;
            };
            document.head.appendChild(script);
        }
    </script>
@endsection
@push('myscript')
    <script>
        $(function() {

            let id_province = "{{ $anggota->id_province }}";
            let id_regency = "{{ $anggota->id_regency }}";
            let id_district = "{{ $anggota->id_district }}";
            let id_village = "{{ $anggota->id_village }}";

            function getRegency(id_province, id_regency) {
                $.ajax({
                    type: 'POST',
                    url: '/regency/getregencybyprovince',
                    data: {
                        _token: "{{ csrf_token() }}",
                        id_province: id_province,
                        id_regency: id_regency
                    },
                    cache: false,
                    success: function(respond) {
                        console.log(respond);
                        $(document).find("#formPembiayaan").find("#id_regency").html(respond);
                    }
                });
            }

            function getDistrict(id_regency, id_district) {
                $.ajax({
                    type: 'POST',
                    url: '/district/getdistrictbyregency',
                    data: {
                        _token: "{{ csrf_token() }}",
                        id_regency: id_regency,
                        id_district: id_district
                    },
                    cache: false,
                    success: function(respond) {
                        console.log(respond);
                        $(document).find("#formPembiayaan").find("#id_district").html(respond);
                    }
                });
            }

            function getVillage(id_district, id_village) {
                $.ajax({
                    type: 'POST',
                    url: '/village/getvillagebydistrict',
                    data: {
                        _token: "{{ csrf_token() }}",
                        id_district: id_district,
                        id_village: id_village
                    },
                    cache: false,
                    success: function(respond) {
                        console.log(respond);
                        $(document).find("#formPembiayaan").find("#id_village").html(respond);
                    }
                });
            }

            $("#id_province").change(function() {
                id_province = $(this).val();
                getRegency(id_province, id_regency);
            });

            $("#id_regency").change(function() {
                id_regency = $(this).val();
                getDistrict(id_regency, id_district);
            });

            $("#id_district").change(function() {
                id_district = $(this).val();
                getVillage(id_district, id_village);
            });

            getRegency(id_province, id_regency);
            getDistrict(id_regency, id_district);
            getVillage(id_district, id_village);

            function convertToRupiah(number) {
                if (number) {
                    var rupiah = "";
                    var numberrev = number
                        .toString()
                        .split("")
                        .reverse()
                        .join("");
                    for (var i = 0; i < numberrev.length; i++)
                        if (i % 3 == 0) rupiah += numberrev.substr(i, 3) + ".";
                    return (
                        rupiah
                        .split("", rupiah.length - 1)
                        .reverse()
                        .join("")
                    );
                } else {
                    return number;
                }
            }
            $(document).on('change', '#kode_pembiayaan', function() {
                let persentase = $('option:selected', this).attr('persentase');
                $(document).find("#formPembiayaan").find("#persentase").val(persentase);
                let jml = $(document).find("#formPembiayaan").find("#jumlah").val();
                let jumlah = jml.replace(/\./g, '');
                var jumlah_pengembalian = parseInt(jumlah) + (parseInt(jumlah) * (parseInt(persentase) /
                    100));
                if (jumlah == "" || jumlah === 0) {
                    jumlah_pengembalian = 0;
                } else {
                    jumlah_pengembalian = jumlah_pengembalian;
                }
                $(document).find("#formPembiayaan").find("#jumlah_pengembalian").val(convertToRupiah(
                    jumlah_pengembalian));
            });

            $(document).on('keyup keydown', '#jumlah', function() {
                let persentase = $(document).find("#formPembiayaan").find("#persentase").val();
                let jml = $(document).find("#formPembiayaan").find("#jumlah").val();
                let jumlah = jml.replace(/\./g, '');
                var jumlah_pengembalian = parseInt(jumlah) + (parseInt(jumlah) * (parseInt(persentase) /
                    100));
                if (jumlah == "" || jumlah === 0) {
                    jumlah_pengembalian = 0;
                } else {
                    jumlah_pengembalian = jumlah_pengembalian;
                }
                $(document).find("#formPembiayaan").find("#jumlah_pengembalian").val(convertToRupiah(
                    jumlah_pengembalian));
            })
        });
    </script>
@endpush

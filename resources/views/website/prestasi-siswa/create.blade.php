@extends('layouts.app')
@section('titlepage', 'Tambah Prestasi Siswa')

@section('content')
@section('navigasi')
    <span>Prestasi Siswa</span>
@endsection

<div class="row">
    <div class="col-lg-8 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Tambah Prestasi Siswa</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('prestasi-siswa.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label for="nama_siswa_search" class="form-label">Pilih Siswa (Opsional)</label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('nama_siswa') is-invalid @enderror" id="nama_siswa_search"
                                        placeholder="Cari siswa..." readonly>
                                    <input type="hidden" id="id_siswa" name="id_siswa" value="{{ old('id_siswa') }}">
                                    <button class="btn btn-success" type="button" id="btnSearchSiswa">
                                        <i class="ti ti-search"></i> Cari Siswa
                                    </button>
                                    <button class="btn btn-outline-danger" type="button" id="btnClearSiswa">
                                        <i class="ti ti-x"></i> Clear
                                    </button>
                                </div>
                                <small class="form-text text-muted">Klik tombol "Cari Siswa" untuk memilih dari database, atau kosongkan untuk input
                                    manual di bawah</small>
                                @error('id_siswa')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label for="kode_unit" class="form-label">Unit <span class="text-danger">*</span></label>
                                <select class="form-select @error('kode_unit') is-invalid @enderror" id="kode_unit" name="kode_unit" required>
                                    <option value="">Pilih Unit</option>
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->kode_unit }}" {{ old('kode_unit') == $unit->kode_unit ? 'selected' : '' }}>
                                            {{ $unit->nama_unit }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kode_unit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label for="nama_siswa" class="form-label">Nama Siswa <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama_siswa') is-invalid @enderror" id="nama_siswa" name="nama_siswa"
                                    value="{{ old('nama_siswa') }}" required>
                                @error('nama_siswa')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label for="prestasi" class="form-label">Prestasi <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('prestasi') is-invalid @enderror" id="prestasi" name="prestasi" rows="3" required>{{ old('prestasi') }}</textarea>
                                @error('prestasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label for="tingkat" class="form-label">Tingkat <span class="text-danger">*</span></label>
                                <select class="form-select @error('tingkat') is-invalid @enderror" id="tingkat" name="tingkat" required>
                                    <option value="">Pilih Tingkat</option>
                                    <option value="kecamatan" {{ old('tingkat') == 'kecamatan' ? 'selected' : '' }}>Kecamatan</option>
                                    <option value="kabupaten" {{ old('tingkat') == 'kabupaten' ? 'selected' : '' }}>Kabupaten</option>
                                    <option value="nasional" {{ old('tingkat') == 'nasional' ? 'selected' : '' }}>Nasional</option>
                                </select>
                                @error('tingkat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label for="foto" class="form-label">Foto</label>
                                <input type="file" class="form-control @error('foto') is-invalid @enderror" id="foto" name="foto"
                                    accept="image/*">
                                <small class="form-text text-muted">Format: JPG, PNG, GIF. Maksimal 2MB</small>
                                @error('foto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="">Pilih Status</option>
                                    <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Aktif</option>
                                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Nonaktif</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy me-1"></i> Simpan
                                </button>
                                <a href="{{ route('prestasi-siswa.index') }}" class="btn btn-secondary">
                                    <i class="ti ti-arrow-left me-1"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Pilih Siswa -->
<div class="modal fade" id="modalPilihSiswa" tabindex="-1" aria-labelledby="modalPilihSiswaLabel" aria-hidden="true" data-bs-backdrop="static"
    data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPilihSiswaLabel">Pilih Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <div class="input-group">
                        <input type="text" class="form-control" id="searchSiswaInput" placeholder="Cari siswa berdasarkan nama atau NISN...">
                        <button type="button" class="btn btn-primary" id="btnSearchSiswaModal">
                            <i class="ti ti-search"></i> Cari
                        </button>
                    </div>
                </div>
                <div id="siswaTableBody">
                    <!-- Data siswa akan dimuat di sini -->
                </div>
                <div id="siswaPagination" class="d-flex justify-content-center mt-3">
                    <!-- Pagination akan dimuat di sini -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .spinner-border {
        width: 3rem;
        height: 3rem;
    }

    .input-group .form-control {
        border-right: none;
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }

    .input-group .btn {
        border-left: none;
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }

    .input-group .form-control:focus {
        border-color: #696cff;
        box-shadow: 0 0 0 0.2rem rgba(105, 108, 255, 0.25);
    }

    .input-group .form-control:focus+.btn {
        border-color: #696cff;
    }
</style>
@endpush

@push('myscript')
<script>
    $(function() {
        // Load data siswa saat modal dibuka
        $('#btnSearchSiswa').click(function() {
            $('#modalPilihSiswa').modal('show');
            loadSiswaData();
        });

        // Clear pilihan siswa
        $('#btnClearSiswa').click(function() {
            $('#id_siswa').val('');
            $('#nama_siswa_search').val('');
            $('#nama_siswa').val('');
        });

        // Search siswa di modal
        $('#btnSearchSiswaModal').click(function() {
            loadSiswaData();
        });

        // Search siswa dengan enter key
        $('#searchSiswaInput').keypress(function(e) {
            if (e.which == 13) {
                loadSiswaData();
            }
        });

        // Load data siswa
        function loadSiswaData(page = 1) {
            var search = $('#searchSiswaInput').val();

            // Show loading state
            $('#siswaTableBody').html(`
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-3 text-muted">Memuat data siswa...</p>
                </div>
            `);

            $.ajax({
                url: '{{ route('prestasi-siswa.search-siswa') }}',
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    search: search,
                    page: page
                },
                success: function(response) {
                    $('#siswaTableBody').html(response.html);
                    $('#siswaPagination').html(response.pagination);

                    // Add fade-in animation to cards
                    $('.student-card').each(function(index) {
                        $(this).css({
                            'opacity': '0',
                            'transform': 'translateY(20px)'
                        }).delay(index * 100).animate({
                            'opacity': '1',
                            'transform': 'translateY(0)'
                        }, 300);
                    });
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', xhr, status, error);
                    $('#siswaTableBody').html(`
                        <div class="text-center py-5">
                            <div class="text-danger">
                                <i class="ti ti-alert-circle" style="font-size: 3rem;"></i>
                                <h5 class="mt-3 mb-2">Terjadi Kesalahan</h5>
                                <p class="mb-0">Gagal memuat data siswa</p>
                            </div>
                        </div>
                    `);
                }
            });
        }

        // Pilih siswa dari modal dengan klik card
        $(document).on('click', '.clickable-card', function() {
            var idSiswa = $(this).data('id');
            var namaSiswa = $(this).data('nama');
            var nisn = $(this).data('nisn');

            $('#id_siswa').val(idSiswa);
            $('#nama_siswa_search').val(namaSiswa + ' - ' + nisn);
            $('#nama_siswa').val(namaSiswa);

            // Tutup modal secara manual
            $('#modalPilihSiswa').modal('hide');
        });



        // Pagination
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            loadSiswaData(page);
        });
    });
</script>
@endpush

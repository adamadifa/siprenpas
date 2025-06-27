<form action="#" id="frmTambahSiswa">
    <div class="row mb-3">
        <div class="col">
            <div class="d-flex justify-content-between">
                <button class="btn btn-primary" id="tambahkansemua"><i class="ti ti-plus me-1"></i> Tambahkan Semua
                </button>
                <button class="btn btn-danger" id="batalkansemua"><i class="ti ti-circle-minus me-1"></i> Batalkan Semua
                </button>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <x-input-with-icon label="Nama Siswa" name="nama_siswa" icon="ti ti-user" />
        </div>
    </div>

    <div class="row">
        <div class="col">
            <table class="table table-bordered table-striped table-hover" id="tabelsiswa">
                <thead class="table-dark">
                    <tr>
                        <th>No.</th>
                        <th>ID</th>
                        <th>NIS</th>
                        <th>Nama Siswa</th>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody id="loadsiswa">

                </tbody>
            </table>
        </div>
    </div>
</form>

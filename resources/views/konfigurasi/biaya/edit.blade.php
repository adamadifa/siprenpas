<form action="{{ route('biaya.update', Crypt::encrypt($biaya->kode_biaya)) }}" method="POST" id="formBiaya">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col">
            <table class="table">
                <tr>
                    <th>Jenjang / Unit</th>
                    <td>{{ $biaya->nama_unit }}</td>
                </tr>
                <tr>
                    <th>Tingkat</th>
                    <td>{{ $biaya->tingkat }}</td>
                </tr>
                <tr>
                    <th>Tahun Ajaran</th>
                    <td>{{ $biaya->tahun_ajaran }}</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_pindahan" value="1" id="is_pindahan" {{ $biaya->is_pindahan ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_pindahan"> Apakah Paket Biaya Pindahan? </label>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="divider text-start">
        <div class="divider-text">Detail Biaya</div>
    </div>
    <div class="row mb-2">
        <div class="col-lg-6 col-sm-12 col-md-12">
            <x-select label="Jenis Biaya" name="kode_jenis_biaya" :data="$jenisbiaya" key="kode_jenis_biaya" textShow="jenis_biaya" upperCase="true" />
        </div>
        <div class="col-lg-4 col-sm-12 col-md-12">
            <x-input-with-icon icon="ti ti-file-description" label="Jumlah Biaya" textalign="right" name="jumlah" money="true" />
        </div>
        <div class="col-lg-2 col-sm-12 col-md-12">
            <a href="#" class="btn btn-primary w-100" id="tambahbiaya">
                <i class="ti ti-plus"></i>
            </a>
        </div>
    </div>
    <table class="table table-bordered" id="tabledetail">
        <thead class="table-dark">
            <tr>
                <th>Kode</th>
                <th>Jenis Biaya</th>
                <th style="width: 25%">Jumlah</th>
                <th>#</th>
            </tr>
        </thead>
        <tbody id="loaddetail">
            @foreach ($detail as $d)
                <tr id="index_{{ $d->kode_jenis_biaya }}">
                    <td>
                        <input type="hidden" name="kode_jenis_biaya[]" value="{{ $d->kode_jenis_biaya }}">
                        {{ $d->kode_jenis_biaya }}
                    </td>
                    <td>{{ textUpperCase($d->jenis_biaya) }}</td>
                    <td>
                        <input type="text" name="jml[]" class="noborder-form text-end money" value="{{ formatAngka($d->jumlah) }}">
                    </td>
                    <td class="text-center">
                        <a href="#" kode_jenis_biaya="{{ $d->kode_jenis_biaya }}" class="delete"><i class="ti ti-trash text-danger"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot class="table-dark">
            <tr>
                <td colspan="2" class="text-start fw-bold">Total Biaya</td>
                <td class="text-end fw-bold" id="totalbiaya"></td>
                <td></td>
            </tr>
        </tfoot>
    </table>
    <div class="row mt-2">
        <div class="col-12">
            <div class="form-check mt-3 mb-3">
                <input class="form-check-input agreement" name="aggrement" value="aggrement" type="checkbox" value="" id="defaultCheck3">
                <label class="form-check-label" for="defaultCheck3"> Yakin Akan Disimpan ? </label>
            </div>
            <div class="form-group" id="saveButton">
                <button class="btn btn-primary w-100" type="submit" id="btnSimpan">
                    <ion-icon name="send-outline" class="me-1"></ion-icon>
                    Submit
                </button>
            </div>
        </div>
    </div>
</form>

<script>
    $(function() {
        const form = $("#formBiaya");
        $(".money").maskMoney();
        $("#kode_unit").change(function() {
            const kode_unit = $(this).val();
            $.ajax({
                type: "POST",
                url: "{{ route('unit.gettingkatbyunit') }}",
                cache: false,
                data: {
                    _token: "{{ csrf_token() }}",
                    kode_unit: kode_unit
                },
                success: function(respond) {
                    $("#tingkat").html(respond);
                }
            });
        });

        function addBiaya() {
            const biaya = form.find("#kode_jenis_biaya :selected");
            const kode_jenis_biaya = $(biaya).val();
            const jenis_biaya = $(biaya).text();
            const jumlah = form.find("#jumlah").val();

            let listbiaya = `
                  <tr id="index_${kode_jenis_biaya}">
                      <td>
                          <input type="hidden" name="kode_jenis_biaya[]" value="${kode_jenis_biaya}" />
                          ${kode_jenis_biaya}
                      </td>
                      <td>${jenis_biaya}</td>
                      <td class="text-end">
                          <input type="hidden" name="jml[]" value="${jumlah}" />
                          ${jumlah}
                      </td>
                      <td class="text-center">
                          <a href="#" kode_jenis_biaya="${kode_jenis_biaya}" class="delete"><i class="ti ti-trash text-danger"></i></a>
                      </td>
                  </tr>
              `;

            $("#loaddetail").prepend(listbiaya);

            form.find("#kode_jenis_biaya").val("");
            form.find("#jumlah").val("");
            getTotalBiaya();
        }

        function getTotalBiaya() {
            let totalbiaya = 0;
            $("#loaddetail tr").each(function() {
                let jumlah = $(this).find("input[name='jml[]']").val();
                // Hilangkan simbol titik pada jumlah
                jumlah = jumlah.replace(/\./g, '');
                totalbiaya += parseInt(jumlah) || 0;
            });
            $("#totalbiaya").text(totalbiaya.toLocaleString('id-ID'));
        }
        getTotalBiaya();
        $("#tambahbiaya").click(function(e) {
            e.preventDefault();
            const kode_jenis_biaya = form.find("#kode_jenis_biaya").val();
            const jumlah = form.find("#jumlah").val();
            const cekdetail = form.find('#tabledetail').find('#index_' + kode_jenis_biaya).length;
            if (kode_jenis_biaya == "") {
                Swal.fire({
                    title: "Oops!",
                    text: "Silahkan Pilih dulu Jenis Biaya !",
                    icon: "warning",
                    showConfirmButton: true,
                    didClose: (e) => {
                        form.find("#kode_jenis_biaya").focus();
                    },

                });
            } else if (jumlah == "" || jumlah === "0") {
                Swal.fire({
                    title: "Oops!",
                    text: "Jumlah Tidak Boleh 0 Atau Kosong !",
                    icon: "warning",
                    showConfirmButton: true,
                    didClose: (e) => {
                        form.find("#jumlah").focus();
                    },

                });
            } else if (cekdetail > 0) {
                Swal.fire({
                    title: "Oops!",
                    text: "Data Sudah Ada !",
                    icon: "warning",
                    showConfirmButton: true,
                    didClose: (e) => {
                        form.find("#kode_jenis_biaya").focus();
                    },
                });
            } else {
                addBiaya();
            }
        });

        form.on('click', '.delete', function(e) {
            e.preventDefault();
            var kode_jenis_biaya = $(this).attr("kode_jenis_biaya");
            event.preventDefault();
            Swal.fire({
                title: `Apakah Anda Yakin Ingin Menghapus Data Ini ?`,
                text: "Jika dihapus maka data akan hilang permanent.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                showCancelButton: true,
                confirmButtonColor: "#554bbb",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Hapus Saja!"
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $(`#index_${kode_jenis_biaya}`).remove();
                }
            });
        });



        form.find("#saveButton").hide();

        form.find('.agreement').change(function() {
            if (this.checked) {
                form.find("#saveButton").show();
            } else {
                form.find("#saveButton").hide();
            }
        });

        form.submit(function() {
            const kode_unit = form.find("#kode_unit").val();
            const tingkat = form.find("#tingkat").val();
            const detail = form.find('#loaddetail tr').length;
            if (kode_unit == "") {
                Swal.fire({
                    title: "Oops!",
                    text: "Tingkat Harus Diisi !",
                    icon: "warning",
                    showConfirmButton: true,
                    didClose: (e) => {
                        form.find("#kode_unit").focus();
                    },
                });

                return false;
            } else if (tingkat == "") {
                Swal.fire({
                    title: "Oops!",
                    text: "Tingkat harus Diisi !",
                    icon: "warning",
                    showConfirmButton: true,
                    didClose: (e) => {
                        form.find("#tingkat").focus();
                    },
                });

                return false;
            } else if (detail == "0") {
                Swal.fire({
                    title: "Oops!",
                    text: "Detail Biaya Masih Kosong !",
                    icon: "warning",
                    showConfirmButton: true,
                    didClose: (e) => {
                        form.find("#kode_biaya").focus();
                    },
                });
                return false;
            }
        });
    });
</script>

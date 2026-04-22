<form action="#" id="formDetailbayar" method="POST">
    @csrf
    <input type="hidden" name="no_pendaftaran" id="no_pendaftaran" value="{{ Crypt::encrypt($no_pendaftaran) }}">
    <x-input-with-icon label="Auto" icon="ti ti-barcode" name="no_bukti" placeholeder="Auto" disabled />
    <x-input-with-icon label="Tanggal" icon="ti ti-calendar" name="tanggal" datepicker="flatpickr-date" />
    <hr>

    <div class="row mt-3">
        <div class="col-lg-5 col-md-5 col-sm-12">
            <div class="form-group mb3">
                <select name="kode_biaya" id="kode_biaya" class="form-select select2Kodebiaya">
                    <option value="">Pilih Biaya</option>
                    @foreach ($biaya as $d)
                        <option value="{{ $d->kode_jenis_biaya . '|' . $d->kode_biaya }}">{{ $d->jenis_biaya }}
                            {{ in_array($d->kode_jenis_biaya, ['B01', 'B07']) ? $d->tahun_ajaran : '' }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col">
            <x-input-with-icon label="Sisa Tagihan" icon="ti ti-moneybag" name="sisa_tagihan" disabled="true"
                money="true" textalign="right" />
        </div>
        <div class="col">
            <x-input-with-icon label="Jumlah Bayar" icon="ti ti-moneybag" name="jumlah" money="true"
                textalign="right" />
        </div>
    </div>
    <div class="row">
        <div class="col">
            <x-textarea name="keterangan" label="Keterangan" />
        </div>
    </div>
    <div class="row">
        <div class="col">
            <a href="#" id="btnTambahdetailbayar" class="btn text-white w-100" style="background-color: #ff9f43"><i
                    class="ti ti-plus me-1"></i>Tambah</a>
        </div>
    </div>

    <style>
        .card-merged {
            border-radius: 12px !important;
            overflow: hidden !important;
            border: none !important;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
        }
        .card-merged .card-header {
            background-color: #064e3b !important;
            padding: 0.75rem 1.15rem !important;
            border-bottom: none !important;
        }
        .table-compact {
            font-size: 0.875rem !important;
        }
        .table-compact th, .table-compact td {
            padding-left: 1.15rem !important;
            padding-right: 1.15rem !important;
            padding-top: 0.5rem !important;
            padding-bottom: 0.5rem !important;
        }
    </style>
    <div class="row mt-3">
        <div class="col">
            <div class="card card-merged">
                <div class="card-header d-flex align-items-center gap-2">
                    <i class="ti ti-list text-white fs-5"></i>
                    <h6 class="card-title mb-0 text-white small">Item Pembayaran</h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0 text-nowrap table-compact" id="tableDetailbayar">
                        <thead style="background-color: #064e3b">
                            <tr>
                                <th class="text-white py-3">Jenis Biaya</th>
                                <th class="text-white py-3 text-end">Jumlah</th>
                                <th class="text-white py-3">Keterangan</th>
                                <th class="text-white py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="detailbayar"></tbody>
                        <tfoot style="background-color: #f8f9fa" class="border-top border-dark">
                            <tr>
                                <td class="text-end fw-bold py-3">Total Bayar</td>
                                <td class="text-end fw-bold py-3 text-success" id="totalbayar"></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12">
            <div class="form-group mb-3">
                <select name="metode_pembayaran" id="metode_pembayaran" class="form-select">
                    <option value="">Pilih Metode Pembayaran</option>
                    <option value="TF">TRANSFER</option>
                    <option value="TN">TUNAI</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col">
            <button class="btn text-white w-100" type="submit" id="btnSimpan" style="background-color: #064e3b"><i
                    class="ti ti-send me-1"></i>Simpan</button>
        </div>
    </div>
</form>
<style>
    .flatpickr-calendar {
        z-index: 9999 !important;
    }
</style>
<script>
    $(function() {
        let sisatagihan;

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
        $("#jumlah").maskMoney();
        $(".flatpickr-date").flatpickr({

        });

        const select2Kodebiaya = $('.select2Kodebiaya');
        if (select2Kodebiaya.length) {
            select2Kodebiaya.each(function() {
                var $this = $(this);
                $this.wrap('<div class="position-relative"></div>').select2({
                    placeholder: 'Pilih Biaya',
                    dropdownParent: $this.parent(),

                });
            });
        }


        function getsisatagihan() {
            let biaya = $("#formDetailbayar").find("#kode_biaya").val().split("|");
            let kode_jenis_biaya = biaya[0];
            let kode_biaya = biaya[1];
            let no_pendaftaran = $("#formDetailbayar").find("#no_pendaftaran").val();


            $.ajax({
                type: 'POST',
                url: "{{ route('pembayaranpendidikan.getsisatagihan') }}",
                cache: false,
                data: {
                    _token: "{{ csrf_token() }}",
                    no_pendaftaran: no_pendaftaran,
                    kode_jenis_biaya: kode_jenis_biaya,
                    kode_biaya: kode_biaya
                },
                success: function(data) {
                    $("#formDetailbayar").find("#sisa_tagihan").val(convertToRupiah(data
                        .sisatagihan));
                    sisatagihan = data.sisatagihan;
                }
            });


        }

        $("#kode_biaya").change(function() {
            if ($(this).val() != "") {
                getsisatagihan();
            }
        })

    });
</script>

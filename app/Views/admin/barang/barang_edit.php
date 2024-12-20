<!-- Modal -->
<div class="modal fade" id="modalEdit" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">


            <form action="<?=base_url()?>barangEditSimpan" class="formsimpan" id="formTambah"
                enctype="multipart/form-data">
                <?=csrf_field();?>

                <input type="hidden" name="brgid" id="brgid" value="<?=$brgid?>">
                <input type="hidden" name="brgbarcodelama" id="brgbarcodelama" value="<?=$brgbarcode?>">

                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-12 col-xl-6">
                            <div class="form-group">
                                <label for="">Barcode</label>
                                <input type="number" name="brgbarcode" id="brgbarcode" class="form-control" value="<?=$brgbarcode?>" minlength="13" maxlength="13" placeholder="Masukan Barcode..." autocomplete="off">
                                <div class="invalid-feedback errorBarangBarcode"></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-12 col-xl-6">
                            <div class="form-group">
                                <label for="">Nama Barang</label>
                                <input type="text" name="brgnama" id="brgnama" class="form-control" value="<?=$brgnama?>" placeholder="Masukan Nama Barang..." autocomplete="off">
                                <div class="invalid-feedback errorBarangNama"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-12 col-xl-6">
                            <div class="form-group">
                                <label for="">Kategori</label>
                                <div class="input-group">
                                    <select class="custom-select" name="brgkatid" id="brgkatid" aria-label="Example select with button addon">
                                        <option value="" selected>-- Pilih Kategori --</option>
                                        <option value="">-------------</option>
                                        <?php foreach ($tampilKategori as $rowKat): ?>
                                            <option value="<?=$rowKat['katid']?>" <?=($rowKat['katid'] == $brgkatid) ? "selected" : ""?>><?=$rowKat['katnama']?></option>
                                        <?php endforeach?>
                                    </select>
                                    <div class="invalid-feedback errorBarangKategori"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-12 col-xl-6">
                            <div class="form-group">
                                <label for="">Satuan</label>
                                <div class="input-group">
                                    <select class="custom-select" name="brgsatid" id="brgsatid" aria-label="Example select with button addon">
                                        <option value="" selected>-- Pilih Satuan --</option>
                                        <option value="">-------------</option>
                                        <?php foreach ($tampilSatuan as $rowSat): ?>
                                            <option value="<?=$rowSat['satid']?>" <?=($rowSat['satid'] == $brgsatid) ? "selected" : ""?>><?=$rowSat['satnama']?></option>
                                        <?php endforeach?>
                                    </select>
                                    <div class="invalid-feedback errorBarangSatuan"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-12 col-xl-6">
                            <div class="form-group">
                                <label for="">Harga Modal</label>
                                <input type="text" name="brgmodal" id="brgmodal" class="form-control" value="<?=$brgmodal?>" placeholder="Masukan Harga Satuan..." autocomplete="off">
                                <div class="invalid-feedback errorHargaModal"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-12 col-xl-6">
                            <div class="form-group">
                                <label for="">Isi Satuan</label>
                                <input type="text" name="brgsatisi" id="brgsatisi" class="form-control" value="<?=$brgsatisi?>" placeholder="Masukan Isi Satuan..." autocomplete="off">
                                <div class="invalid-feedback errorBarangSatuanIsi"></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-12 col-xl-6">
                            <div class="form-group">
                                <label for="">Harga Satuan</label>
                                <input type="text" name="brgharga" id="brgharga" class="form-control" value="<?=$brgharga?>" placeholder="Masukan Harga Satuan..." autocomplete="off">
                                <div class="invalid-feedback errorBarangHarga"></div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-success" id="tombolsimpan"
                        autocomplete="off">Simpan</button>
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" id="batal">Batal</button>
                </div>


            </form>

        </div>
    </div>
</div>



<script src="<?=base_url('assets/dist/js/autoNumeric.js')?>"></script>
<script>
    $(document).ready(function() {

        // autonumerik harga
        $('#brgmodal').autoNumeric('init', {
            mDec: 2,
            aDec: ',',
            aSep: '.',
        })
        $('#brgmodal').keyup(function(e) {
            let brgmodal = $('#brgmodal').autoNumeric('get');

        });

        // autonumerik harga
        $('#brgharga').autoNumeric('init', {
            mDec: 2,
            aDec: ',',
            aSep: '.',
        })
        $('#brgharga').keyup(function(e) {
            let brgharga = $('#brgharga').autoNumeric('get');

        });


        $('.formsimpan').submit(function(e) {
            e.preventDefault();

            var formData = new FormData($('#formTambah')[0]);

            $.ajax({
                type: "post",
                url: '<?=base_url()?>barangEditSimpan',
                data: formData,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(response) {
                    if (response.error) {
                        let err = response.error;

                        if (err.errBarangBarcode) {
                            $('#brgbarcode').addClass('is-invalid');
                            $('.errorBarangBarcode').html(err.errBarangBarcode);
                        } else {
                            $('#brgbarcode').removeClass('is-invalid');
                            $('#brgbarcode').addClass('is-valid');
                        }

                        if (err.errBarangNama) {
                            $('#brgnama').addClass('is-invalid');
                            $('.errorBarangNama').html(err.errBarangNama);
                        } else {
                            $('#brgnama').removeClass('is-invalid');
                            $('#brgnama').addClass('is-valid');
                        }

                        if (err.errBarangKategori) {
                            $('#brgkatid').addClass('is-invalid');
                            $('.errorBarangKategori').html(err.errBarangKategori);
                        } else {
                            $('#brgkatid').removeClass('is-invalid');
                            $('#brgkatid').addClass('is-valid');
                        }

                        if (err.errBarangSatuan) {
                            $('#brgsatid').addClass('is-invalid');
                            $('.errorBarangSatuan').html(err.errBarangSatuan);
                        } else {
                            $('#brgsatid').removeClass('is-invalid');
                            $('#brgsatid').addClass('is-valid');
                        }

                        if (err.errBarangSatuanIsi) {
                            $('#brgsatisi').addClass('is-invalid');
                            $('.errorBarangSatuanIsi').html(err.errBarangSatuanIsi);
                        } else {
                            $('#brgsatisi').removeClass('is-invalid');
                            $('#brgsatisi').addClass('is-valid');
                        }

                        if (err.errBarangHarga) {
                            $('#brgharga').addClass('is-invalid');
                            $('.errorBarangHarga').html(err.errBarangHarga);
                        } else {
                            $('#brgharga').removeClass('is-invalid');
                            $('#brgharga').addClass('is-valid');
                        }
                    }

                    if (response.sukses) {
                        swal.fire(
                            'Berhasil',
                            response.sukses,
                            'success'
                        ).then((result) => {
                            window.location.reload();
                        })
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });

            return false;
        });

        $('#batal').click(function(e) {
            e.preventDefault();
            window.location.reload();
        });

    });
</script>
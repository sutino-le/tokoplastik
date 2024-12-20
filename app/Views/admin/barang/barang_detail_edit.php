<!-- Modal -->
<div class="modal fade" id="modalEdit" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">


            <form action="<?= base_url() ?>editHargaTambahanSimpan" class="formeditsimpan" id="formEdit"
                enctype="multipart/form-data">
                <?= csrf_field(); ?>

                <input type="hidden" name="edit_bth_id" id="edit_bth_id" value="<?= $bth_id ?>">
                <input type="hidden" name="edit_bth_brgid" id="edit_bth_brgid" value="<?= $bth_brgid ?>">
                <input type="hidden" name="edit_bth_barcodelama" id="edit_bth_barcodelama" value="<?= $bth_barcode ?>">

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
                                <input type="number" name="edit_bth_barcode" id="edit_bth_barcode" class="form-control" value="<?= $bth_barcode ?>" minlength="13" maxlength="13" placeholder="Masukan Barcode..." autocomplete="off">
                                <div class="invalid-feedback errorEditBTHBarcode"></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-12 col-xl-6">
                            <div class="form-group">
                                <label for="">Satuan</label>
                                <select class="form-control" name="edit_bth_satuan" id="edit_bth_satuan">
                                    <option value="" selected>-- Pilih Satuan --</option>
                                    <option value="">-------------</option>
                                    <?php foreach ($tampilSatuan as $rowSat): ?>
                                        <option value="<?= $rowSat['satid'] ?>" <?= ($bth_satuan == $rowSat['satid']) ? "selected" : "" ?>><?= $rowSat['satnama'] ?></option>
                                    <?php endforeach ?>
                                </select>
                                <div class="invalid-feedback errorEditBTHSatuan"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-12 col-xl-6">
                            <div class="form-group">
                                <label for="">Min</label>
                                <input type="text" name="edit_bth_isi_min" id="edit_bth_isi_min" class="form-control" value="<?= $bth_isi_min ?>" placeholder="Isi Min" autocomplete="off">
                                <div class="invalid-feedback errorEditBTHMin"></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-12 col-xl-6">
                            <div class="form-group">
                                <label for="">Max</label>
                                <input type="text" name="edit_bth_isi_max" id="edit_bth_isi_max" class="form-control" value="<?= $bth_isi_max ?>" placeholder="Isi Max" autocomplete="off">
                                <div class="invalid-feedback errorEditBTHMax"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-12 col-xl-6">
                            <div class="form-group">
                                <label for="">Konversi ke Satuan Ecer</label>
                                <input type="text" name="edit_bth_konversi_isi_min" id="edit_bth_konversi_isi_min" class="form-control" value="<?= $bth_konversi_isi_min ?>" placeholder="Konversi" autocomplete="off">
                                <div class="invalid-feedback errorEditBTHKonversi"></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-12 col-xl-6">
                            <div class="form-group">
                                <label for="">Harga / Satuan Ecer</label>
                                <input type="text" name="edit_bth_harga" id="edit_bth_harga" class="form-control" placeholder="Harga" value="<?= $bth_harga ?>" autocomplete="off">
                                <div class="invalid-feedback errorEditBTHHarga"></div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-success" id="tombolsimpan"
                        autocomplete="off">Simpan</button>
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" id="bataledit">Batal</button>
                </div>


            </form>

        </div>
    </div>
</div>



<script src="<?= base_url('assets/dist/js/autoNumeric.js') ?>"></script>
<script>
    $(document).ready(function() {


        // autonumerik bth_harga
        $('#edit_bth_harga').autoNumeric('init', {
            mDec: 2,
            aDec: ',',
            aSep: '.',
        })
        $('#edit_bth_harga').keyup(function(e) {
            let edit_bth_harga = $('#edit_bth_harga').autoNumeric('get');

        });


        $('.formeditsimpan').submit(function(e) {
            e.preventDefault();

            var formData = new FormData($('#formEdit')[0]);

            $.ajax({
                type: "post",
                url: '<?= base_url() ?>editHargaTambahanSimpan',
                data: formData,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(response) {
                    if (response.error) {
                        let err = response.error;

                        if (err.errEditBTHBarcode) {
                            $('#edit_bth_barcode').addClass('is-invalid');
                            $('.errorEditBTHBarcode').html(err.errEditBTHBarcode);
                        } else {
                            $('#edit_bth_barcode').removeClass('is-invalid');
                            $('#edit_bth_barcode').addClass('is-valid');
                        }

                        if (err.errEditBTHSatuan) {
                            $('#edit_bth_satuan').addClass('is-invalid');
                            $('.errorEditBTHSatuan').html(err.errEditBTHSatuan);
                        } else {
                            $('#edit_bth_satuan').removeClass('is-invalid');
                            $('#edit_bth_satuan').addClass('is-valid');
                        }

                        if (err.errEditBTHMin) {
                            $('#edit_bth_isi_min').addClass('is-invalid');
                            $('.errorEditBTHMin').html(err.errEditBTHMin);
                        } else {
                            $('#edit_bth_isi_min').removeClass('is-invalid');
                            $('#edit_bth_isi_min').addClass('is-valid');
                        }

                        if (err.errEditBTHMax) {
                            $('#edit_bth_isi_max').addClass('is-invalid');
                            $('.errorEditBTHMax').html(err.errEditBTHMax);
                        } else {
                            $('#edit_bth_isi_max').removeClass('is-invalid');
                            $('#edit_bth_isi_max').addClass('is-valid');
                        }

                        if (err.errEditBTHKonversi) {
                            $('#edit_bth_konversi_isi_min').addClass('is-invalid');
                            $('.errorEditBTHKonversi').html(err.errEditBTHKonversi);
                        } else {
                            $('#edit_bth_konversi_isi_min').removeClass('is-invalid');
                            $('#edit_bth_konversi_isi_min').addClass('is-valid');
                        }

                        if (err.errEditBTHHarga) {
                            $('#edit_bth_harga').addClass('is-invalid');
                            $('.errorEditBTHHarga').html(err.errEditBTHHarga);
                        } else {
                            $('#edit_bth_harga').removeClass('is-invalid');
                            $('#edit_bth_harga').addClass('is-valid');
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

        $('#bataledit').click(function(e) {
            e.preventDefault();
            window.location.reload();
        });

    });
</script>
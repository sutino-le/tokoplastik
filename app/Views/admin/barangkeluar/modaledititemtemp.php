<!-- Modal -->
<div class="modal fade" id="modalEditItem" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">


            <form action="<?= base_url() ?>modalEditItemBarangKeluarSimpan" class="tomboledititemsimpan" id="tomboledititemsimpan"
                enctype="multipart/form-data">
                <?= csrf_field(); ?>

                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Qty Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">

                    <input type="hidden" name="editiddetail" id="editiddetail" value="<?= $iddetail ?>">
                    <input type="hidden" name="brgid" id="brgid" value="<?= $brgid ?>">
                    <input type="hidden" name="brgharga" id="brgharga" value="<?= $brgharga ?>">



                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="">Nama Produk</label>
                                <input type="text" name="brgnama" id="brgnama" class="form-control" value="<?= $brgnama ?>" readonly>
                                <div class="invalid-feedback errorBarangNama"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="">Satuan</label>
                                <select name="satuanharga" id="satuanharga" class="form-control">
                                    <option value="">Pilih Satuan</option>
                                    <option value="">-----------</option>
                                    <option value="<?= $brgharga ?>"><?= $satlabel ?> (Harga Ecer Rp. <?= number_format($brgharga) ?>/<?= $satlabel ?>)</option>
                                    <?php foreach ($hargaTambahan as $rowHarga): ?>
                                        <option value="<?= $rowHarga['bth_harga'] ?>">
                                            <?= $rowHarga['satlabel'] ?> (<?= $rowHarga['bth_isi_min'] ?> - <?= $rowHarga['bth_isi_max'] ?> <?= $rowHarga['satlabel'] ?> Rp.
                                            <?= number_format($rowHarga['bth_harga']) ?>/<?= $satlabel ?> (<?= number_format(($rowHarga['bth_konversi_isi_min'] * $rowHarga['bth_harga']) / $rowHarga['bth_isi_min']) ?>/<?= $rowHarga['satlabel'] ?>))

                                        </option>
                                    <?php endforeach ?>
                                </select>
                                <div class="invalid-feedback errorSatuanHarga"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="">Qty</label>
                                <input type="number" class="form-control" name="editjml" id="editjml" autofocus>
                                <div class="invalid-feedback errorJumlah"></div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-success" id="tomboledititemsimpan"
                        autocomplete="off">Simpan</button>
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" id="batal">Batal</button>
                </div>


            </form>

        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#modalEditItem').on('shown.bs.modal', function() {
            $('#editjml').trigger('focus');
        });

        $('.tomboledititemsimpan').submit(function(e) {
            e.preventDefault();

            var formData = new FormData($('#tomboledititemsimpan')[0]);

            $.ajax({
                type: "post",
                url: '<?= base_url() ?>modalEditItemBarangKeluarSimpan',
                data: formData,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(response) {
                    if (response.error) {
                        let err = response.error;

                        if (err.errSatuanHarga) {
                            $('#satuanharga').addClass('is-invalid');
                            $('.errorSatuanHarga').html(err.errSatuanHarga);
                        } else {
                            $('#satuanharga').removeClass('is-invalid');
                            $('#satuanharga').addClass('is-valid');
                        }

                        if (err.errJumlah) {
                            $('#editjml').addClass('is-invalid');
                            $('.errorJumlah').html(err.errJumlah);
                        } else {
                            $('#editjml').removeClass('is-invalid');
                            $('#editjml').addClass('is-valid');
                        }
                    }

                    if (response.sukses) {

                        Swal.fire({
                            title: 'Berhasil',
                            icon: 'success',
                            text: response.sukses
                        }).then((result) => {
                            $('#modalEditItem').modal('hide');
                            ambilTotalHargaTemp();
                            tampilDataTemp();
                            kosong()
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
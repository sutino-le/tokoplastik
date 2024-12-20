<!-- Modal -->
<div class="modal fade" id="modalTambah" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">


            <form action="<?= base_url() ?>satuanTambahSimpan" class="formsimpan" id="formTambah"
                enctype="multipart/form-data">
                <?= csrf_field(); ?>

                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="staticBackdropLabel">Input Satuan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="">Nama Satuan</label>
                                <input type="text" name="satnama" id="satnama" class="form-control"
                                    placeholder="Masukan Nama Satuan..." autocomplete="off">
                                <div class="invalid-feedback errorSatuanNama"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="">Singkatan</label>
                                <input type="text" name="satlabel" id="satlabel" class="form-control"
                                    placeholder="Masukan Singkatan..." autocomplete="off">
                                <div class="invalid-feedback errorSatuanLabel"></div>
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



<script src="<?= base_url('assets/dist/js/autoNumeric.js') ?>"></script>
<script>
    $(document).ready(function() {
        $('#modalTambah').on('shown.bs.modal', function() {
            $('#satnama').trigger('focus');
        });
    });



    function kosong() {
        $('#satnama').val('');
        $('#satlabel').val('');
    }

    $(document).ready(function() {


        // autonumerik harga
        $('#brg_harga').autoNumeric('init', {
            mDec: 2,
            aDec: ',',
            aSep: '.',
        })
        $('#brg_harga').keyup(function(e) {
            let brg_harga = $('#brg_harga').autoNumeric('get');

        });


        $('.formsimpan').submit(function(e) {
            e.preventDefault();

            var formData = new FormData($('#formTambah')[0]);

            $.ajax({
                type: "post",
                url: '<?= base_url() ?>satuanTambahSimpan',
                data: formData,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(response) {
                    if (response.error) {
                        let err = response.error;

                        if (err.errSatuanNama) {
                            $('#satnama').addClass('is-invalid');
                            $('.errorSatuanNama').html(err.errSatuanNama);
                        } else {
                            $('#satnama').removeClass('is-invalid');
                            $('#satnama').addClass('is-valid');
                        }

                        if (err.errSatuanLabel) {
                            $('#satlabel').addClass('is-invalid');
                            $('.errorSatuanLabel').html(err.errSatuanLabel);
                        } else {
                            $('#satlabel').removeClass('is-invalid');
                            $('#satlabel').addClass('is-valid');
                        }
                    }

                    if (response.sukses) {
                        $('#modalTambah').modal('hide');
                        swal.fire(
                            'Berhasil',
                            response.sukses,
                            'success'
                        ).then((result) => {
                            $.ajax({
                                type: "post",
                                url: "<?= base_url() ?>satuanTambah",
                                dataType: "json",
                                success: function(response) {
                                    if (response.data) {
                                        $('.viewmodal').html(response.data).show();
                                        $('#modalTambah').modal('show');

                                    }
                                },
                                error: function(xhr, ajaxOptions, thrownError) {
                                    alert(xhr.status + '\n' + thrownError);
                                }
                            });
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
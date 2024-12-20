<!-- Modal -->
<div class="modal fade" id="modalEdit" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">


            <form action="<?= base_url() ?>kategoriEditSimpan" class="formsimpan" id="formTambah"
                enctype="multipart/form-data">
                <?= csrf_field(); ?>

                <input type="hidden" name="katid" id="katid" value="<?= $katid ?>">

                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-xl-12">
                            <div class="form-group">
                                <label for="">Nama Kategori</label>
                                <input type="text" name="katnama" id="katnama" class="form-control"
                                    value="<?= $katnama ?>" placeholder="Masukan Nama Kategori..." autocomplete="off">
                                <div class="invalid-feedback errorKategoriNama"></div>
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
    function kosong() {
        $('#katnama').val('');
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
                url: '<?= base_url() ?>kategoriEditSimpan',
                data: formData,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(response) {
                    if (response.error) {
                        let err = response.error;

                        if (err.errKategoriNama) {
                            $('#katnama').addClass('is-invalid');
                            $('.errorKategoriNama').html(err.errKategoriNama);
                        } else {
                            $('#katnama').removeClass('is-invalid');
                            $('#katnama').addClass('is-valid');
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
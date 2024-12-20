<!-- Modal -->
<div class="modal fade" id="modalEdit" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">


            <form action="<?= base_url() ?>levelEditSimpan" class="formsimpan">
                <?= csrf_field(); ?>

                <input type="hidden" name="levelid" id="levelid" value="<?= $levelid ?>">

                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Level</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-xl-12">
                            <div class="form-group">
                                <label for="">Nama Level</label>
                                <input type="text" name="levelnama" id="levelnama" class="form-control" value="<?= $levelnama ?>" placeholder=" Masukan Nama Level..." autocomplete="off">
                                <div class="invalid-feedback errorLevelNama"></div>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-success" id="tombolsimpan" autocomplete="off">Simpan</button>
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" id="batal">Batal</button>
                </div>


            </form>

        </div>
    </div>
</div>



<script>
    $(document).ready(function() {
        $('.formsimpan').submit(function(e) {
            e.preventDefault();

            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                success: function(response) {
                    if (response.error) {
                        let err = response.error;

                        if (err.errLevelNama) {
                            $('#levelnama').addClass('is-invalid');
                            $('.errorLevelNama').html(err.errLevelNama);
                        } else {
                            $('#levelnama').removeClass('is-invalid');
                            $('#levelnama').addClass('is-valid');
                        }
                    }

                    if (response.sukses) {
                        $('#modalEdit').modal('hide');
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
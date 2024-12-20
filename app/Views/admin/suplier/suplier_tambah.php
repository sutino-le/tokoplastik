<!-- Modal -->
<div class="modal fade" id="modalTambah" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">


            <form action="<?= base_url() ?>suplierTambahSimpan" class="formsimpan" id="formTambah"
                enctype="multipart/form-data">
                <?= csrf_field(); ?>

                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="staticBackdropLabel">Input Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="">Nama Suplier</label>
                        <input type="text" name="supnama" id="supnama" class="form-control" placeholder="Masukan Nama Suplier">
                        <div class="invalid-feedback errorSuplierNama"></div>
                    </div>

                    <div class="form-group">
                        <label for="">No. Telp/Hp</label>
                        <input type="text" name="suptelp" id="suptelp" class="form-control" placeholder="Masukan No. Telp">
                        <div class="invalid-feedback errorSupTelp"></div>
                    </div>

                    <div class="form-group">
                        <label for="">Alamat</label>
                        <input type="text" name="supalamat" id="supalamat" class="form-control" placeholder="Masukan Alamat">
                        <div class="invalid-feedback errorSupAlamat"></div>
                    </div>

                    <div class="form-group">
                        <label for="">NPWP</label>
                        <input type="text" name="supnpwp" id="supnpwp" class="form-control" placeholder="Masukan NPWP">
                        <div class="invalid-feedback errorSupNpwp"></div>
                    </div>

                    <div class="form-group">
                        <label for="">Rekening</label>
                        <input type="text" name="suprekening" id="suprekening" class="form-control" placeholder="Masukan Rekening">
                        <div class="invalid-feedback errorSupRekening"></div>
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
            $('#supnama').trigger('focus');
        });
    });



    function kosong() {
        $('#supnama').val('');
    }

    $(document).ready(function() {


        $('.formsimpan').submit(function(e) {
            e.preventDefault();

            var formData = new FormData($('#formTambah')[0]);

            $.ajax({
                type: "post",
                url: '<?= base_url() ?>suplierTambahSimpan',
                data: formData,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(response) {
                    if (response.error) {
                        let err = response.error;

                        if (err.errSuplierNama) {
                            $('#supnama').addClass('is-invalid');
                            $('.errorSuplierNama').html(err.errSuplierNama);
                        } else {
                            $('#supnama').removeClass('is-invalid');
                            $('#supnama').addClass('is-valid');
                        }
                    }

                    if (response.sukses) {
                        Swal.fire({
                            title: 'Berhasil',
                            text: response.sukses,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ya, Ambil !'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $('#namasuplier').val(response.namasuplier);
                                $('#idsuplier').val(response.idsuplier);
                                $('#modalTambah').modal('hide');
                            } else {
                                $('#modalTambah').modal('hide');
                            }
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
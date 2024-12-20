<!-- Modal -->
<div class="modal fade" id="modalpembayaran" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">


            <form action="<?= base_url() ?>modalPembayaranBarangMasukSimpan" class="formsimpan" id="formTambah"
                enctype="multipart/form-data">
                <?= csrf_field(); ?>

                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="staticBackdropLabel">Proses Pembayaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="">No. Faktur</label>
                        <input type="text" name="nofaktur" id="nofaktur" class="form-control" value="<?= $nofaktur ?>"
                            readonly>
                        <input type="hidden" name="tglfaktur" value="<?= $tglfaktur ?>">
                        <input type="hidden" name="jenis" value="<?= $jenis ?>">
                        <input type="hidden" name="idsuplier" value="<?= $idsuplier ?>">
                    </div>

                    <div class="form-group">
                        <label for="">Total Bayar</label>
                        <input type="text" name="totalbayar" id="totalbayar" class="form-control" value="<?= $totalharga ?>"
                            readonly>
                    </div>

                    <div class="form-group">
                        <label for="">Jumlah Bayar</label>
                        <input type="text" name="jumlahuang" id="jumlahuang" class="form-control" autocomplete="off">
                    </div>

                    <div class="form-group">
                        <label for="">Kembali</label>
                        <input type="text" name="sisauang" id="sisauang" class="form-control" readonly>
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


<script src="<?= base_url('dist/js/autoNumeric.js') ?>"></script>
<script>
    $(document).ready(function() {
        $('#modalpembayaran').on('shown.bs.modal', function() {
            $('#jumlahuang').trigger('focus');
        });



        $('#totalbayar').autoNumeric('init', {
            mDec: 0,
            aDec: ',',
            aSep: '.',
        })

        $('#jumlahuang').autoNumeric('init', {
            mDec: 0,
            aDec: ',',
            aSep: '.',
        })

        $('#sisauang').autoNumeric('init', {
            mDec: 0,
            aDec: ',',
            aSep: '.',
        })

        $('#jumlahuang').keyup(function(e) {
            let totalbayar = $('#totalbayar').autoNumeric('get');
            let jumlahuang = $('#jumlahuang').autoNumeric('get');

            let sisauang;

            if (parseInt(jumlahuang) < parseInt(totalbayar)) {
                sisauang = 0;
            } else {
                sisauang = parseInt(jumlahuang) - parseInt(totalbayar);
            }

            $('#sisauang').autoNumeric('set', sisauang);

        });


        $('.formsimpan').submit(function(e) {
            e.preventDefault();

            var formData = new FormData($('#formTambah')[0]);

            $.ajax({
                type: "post",
                url: '<?= base_url() ?>modalPembayaranBarangMasukSimpan',
                data: formData,
                contentType: false,
                processData: false,
                dataType: "json",
                beforeSend: function() {
                    $('.btnsimpan').prop('disabled', true);
                    $('.btnsimpan').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('.btnsimpan').prop('disabled', false);
                    $('.btnsimpan').html('Simpan');
                },
                success: function(response) {
                    if (response.sukses) {
                        Swal.fire({
                            title: 'Cetak Faktur?',
                            text: response.sukses + ", cetak faktur!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ya, cetak!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                let windowCetak = window.open(response.cetakfaktur,
                                    "Cetak Faktur Pembelian",
                                    "width=1000, height=600");

                                windowCetak.focus();
                                window.location.reload();
                            } else {
                                window.location.reload();
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

    });
</script>
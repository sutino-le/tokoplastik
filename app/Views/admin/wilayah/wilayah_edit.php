<!-- Modal -->
<div class="modal fade" id="modalEdit" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">


            <form action="<?= base_url() ?>wilayahEditSimpan" class="formsimpan">
                <?= csrf_field(); ?>

                <input type="hidden" name="id_wilayah" id="id_wilayah" value="<?= $id_wilayah ?>">

                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Wilayah</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">


                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-12 col-xl-6">
                            <div class="form-group">
                                <label for="">Kelurahan</label>
                                <input type="text" name="kelurahan" id="kelurahan" class="form-control"
                                    placeholder="Masukan Kelurahan..." value="<?= $kelurahan ?>" autocomplete="off">
                                <div class="invalid-feedback errorKelurahan"></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-12 col-xl-6">
                            <div class="form-group">
                                <label for="">kecamatan</label>
                                <input type="text" name="kecamatan" id="kecamatan" class="form-control"
                                    placeholder="Masukan kecamatan..." value="<?= $kecamatan ?>" autocomplete="off">
                                <div class="invalid-feedback errorkecamatan"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-12 col-xl-6">
                            <div class="form-group">
                                <label for="">Kota/Kabupaten</label>
                                <input type="text" name="kota_kabupaten" id="kota_kabupaten" class="form-control"
                                    placeholder="Masukan Kota/Kabupaten..." value="<?= $kota_kabupaten ?>" autocomplete="off">
                                <div class="invalid-feedback errorKotaKabupaten"></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-12 col-xl-6">
                            <div class="form-group">
                                <label for="">Propinsi</label>
                                <input type="text" name="propinsi" id="propinsi" class="form-control"
                                    placeholder="Masukan Propinsi..." value="<?= $propinsi ?>" autocomplete="off">
                                <div class="invalid-feedback errorPropinsi"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-12 col-xl-6">
                            <div class="form-group">
                                <label for="">Kode POS</label>
                                <input type="text" name="kodepos" id="kodepos" class="form-control"
                                    placeholder="Masukan Kode POS..." value="<?= $kodepos ?>" autocomplete="off">
                                <div class="invalid-feedback errorKodePos"></div>
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

                        if (err.errKelurahan) {
                            $('#kelurahan').addClass('is-invalid');
                            $('.errorKelurahan').html(err.errKelurahan);
                        } else {
                            $('#kelurahan').removeClass('is-invalid');
                            $('#kelurahan').addClass('is-valid');
                        }

                        if (err.errKecamatan) {
                            $('#kecamatan').addClass('is-invalid');
                            $('.errorKecamatan').html(err.errKecamatan);
                        } else {
                            $('#kecamatan').removeClass('is-invalid');
                            $('#kecamatan').addClass('is-valid');
                        }

                        if (err.errKotaKabupaten) {
                            $('#kota_kabupaten').addClass('is-invalid');
                            $('.errorKotaKabupaten').html(err.errKotaKabupaten);
                        } else {
                            $('#kota_kabupaten').removeClass('is-invalid');
                            $('#kota_kabupaten').addClass('is-valid');
                        }

                        if (err.errPropinsi) {
                            $('#propinsi').addClass('is-invalid');
                            $('.errorPropinsi').html(err.errPropinsi);
                        } else {
                            $('#propinsi').removeClass('is-invalid');
                            $('#propinsi').addClass('is-valid');
                        }

                        if (err.errKodePos) {
                            $('#kodepos').addClass('is-invalid');
                            $('.errorKodePos').html(err.errKodePos);
                        } else {
                            $('#kodepos').removeClass('is-invalid');
                            $('#kodepos').addClass('is-valid');
                        }
                    }

                    if (response.sukses) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.sukses
                        }).then((resul) => {
                            if (resul.isConfirmed) {
                                window.location.href = '<?= base_url() ?>wilayah';
                            }
                        });
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
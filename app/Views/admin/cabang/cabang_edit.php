<?= $this->extend('admin/layout/layout'); ?>

<?= $this->section('isi') ?>



<div class="card">
    <div class="card-header bg-primary">
        <h3 class="card-title"><b><?= $title ?></b></h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>


        <form action="<?= base_url() ?>cabangEditSimpan" class="formsimpan">
            <?= csrf_field(); ?>

            <input type="hidden" name="cabang_id" id="cabang_id" value="<?= $cabang_id ?>">


    </div>
    <div class="card-body">

        <div class="row">
            <div class="col-12 col-sm-6 col-md-12 col-xl-6">
                <div class="form-group">
                    <label for="">Nama Cabang</label>
                    <input type="text" name="cabang_nama" id="cabang_nama" class="form-control" value="<?= $cabang_nama ?>" placeholder="Masukan Nama Cabang..." autocomplete="off">
                    <div class="invalid-feedback errorCabangNama"></div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-12 col-xl-6">
                <div class="form-group">
                    <label for="">No. HP</label>
                    <input type="text" name="cabang_hp" id="cabang_hp" class="form-control" value="<?= $cabang_hp ?>" placeholder="Masukan No. HP..." autocomplete="off">
                    <div class="invalid-feedback errorCabangHP"></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-xl-12">
                <div class="form-group">
                    <label for="">Alamat & RT/RW</label>
                    <input type="text" name="cabang_alamat" id="cabang_alamat" class="form-control" value="<?= $cabang_alamat ?>" placeholder="Masukan Alamat, RT/RW..." autocomplete="off">
                    <div class="invalid-feedback errorCabangAlamat"></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-xl-12">
                <div class="form-group">
                    <label for="">Pilih Daerah</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Kode Wilayah" name="kelurahanpilih" id="kelurahanpilih" value="<?= $cabang_alamatid ?>" readonly>
                        <div class="input-group-append">
                            <button class="btn btn-outline-success" type="button" id="tombolCariWilayah" onclick="wilayahCari()" title="Cari Wilayah"><i class="fas fa-search"></i></button>
                        </div>
                        <div class="invalid-feedback errorCabangAlamatID"></div>
                        <input type="hidden" name="cabang_alamatid" id="useralamatid" value="<?= $cabang_alamatid ?>">
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-xl-12">
                <div class="form-group">
                    <label for="">Lokasi</label>
                    <input type="text" name="lokasialamat" id="lokasialamat" class="form-control" value="<?= $kelurahan . ', ' . $kecamatan . ', ' . $kota_kabupaten . ', ' . $propinsi ?>" placeholder="Masukan Alamat..." readonly>
                    <div class="invalid-feedback errorCabangAlamatID"></div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-xl-12">
                <button type="submit" class="btn btn-sm btn-success" id="tombolsimpan">Simpan</button>
                <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" id="batal">Batal</button>
            </div>
        </div>


    </div>

    </form>

</div>


<div class="viewmodal" style="display: none;"></div>


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

                        if (err.errCabangNama) {
                            $('#cabang_nama').addClass('is-invalid');
                            $('.errorCabangNama').html(err.errCabangNama);
                        } else {
                            $('#cabang_nama').removeClass('is-invalid');
                            $('#cabang_nama').addClass('is-valid');
                        }

                        if (err.errCabangHP) {
                            $('#cabang_hp').addClass('is-invalid');
                            $('.errorCabangHP').html(err.errCabangHP);
                        } else {
                            $('#cabang_hp').removeClass('is-invalid');
                            $('#cabang_hp').addClass('is-valid');
                        }

                        if (err.errCabangAlamat) {
                            $('#cabang_alamat').addClass('is-invalid');
                            $('.errorCabangAlamat').html(err.errCabangAlamat);
                        } else {
                            $('#cabang_alamat').removeClass('is-invalid');
                            $('#cabang_alamat').addClass('is-valid');
                        }

                        if (err.errCabangAlamatID) {
                            $('#kelurahanpilih').addClass('is-invalid');
                            $('.errorCabangAlamatID').html(err.errCabangAlamatID);
                        } else {
                            $('#kelurahanpilih').removeClass('is-invalid');
                            $('#kelurahanpilih').addClass('is-valid');
                        }

                        if (err.errCabangAlamatID) {
                            $('#lokasialamat').addClass('is-invalid');
                            $('.errorCabangAlamatID').html(err.errCabangAlamatID);
                        } else {
                            $('#lokasialamat').removeClass('is-invalid');
                            $('#lokasialamat').addClass('is-valid');
                        }
                    }

                    if (response.sukses) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.sukses
                        }).then((resul) => {
                            if (resul.isConfirmed) {
                                window.location.href = '<?= base_url() ?>cabang';
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
            window.location.href = '<?= base_url() ?>cabang';
        });

    });


    function wilayahCari() {
        $.ajax({
            type: "post",
            url: "<?= base_url() ?>wilayahCari",
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('.viewmodal').html(response.data).show();
                    $('#modalDataWilayah').modal('show');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    }



    $(document).ready(function() {
        $('#kelurahanpilih').click(function(e) {
            e.preventDefault();
            wilayahCari();
        });
    });
</script>


<?= $this->endSection('isi') ?>
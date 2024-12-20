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


        <form action="<?= base_url() ?>userEditProfilSimpan" class="formsimpan">
            <?= csrf_field(); ?>

            <input type="hidden" name="userid" id="userid" value="<?= $userid ?>">


    </div>
    <div class="card-body">

        <div class="row">
            <div class="col-12 col-sm-6 col-md-12 col-xl-6">
                <div class="form-group">
                    <label for="">ID User</label>
                    <input type="text" name="userid" id="userid" class="form-control" placeholder="Masukan ID User..."
                        value="<?= $userid ?>" readonly>
                    <div class="invalid-feedback errorUserID"></div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-12 col-xl-6">
                <div class="form-group">
                    <label for="">Nama User</label>
                    <input type="text" name="usernama" id="usernama" class="form-control"
                        placeholder="Masukan Nama User..." value="<?= $usernama ?>" autocomplete="off">
                    <div class="invalid-feedback errorUserNama"></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-sm-6 col-md-12 col-xl-6">
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="email" name="useremail" id="useremail" class="form-control"
                        placeholder="Masukan Email..." value="<?= $useremail ?>" autocomplete="off">
                    <div class="invalid-feedback errorUserEmail"></div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-12 col-xl-6">
                <div class="form-group">
                    <label for="">No. HP</label>
                    <input type="text" name="userhp" id="userhp" class="form-control" placeholder="Masukan No. HP..."
                        value="<?= $userhp ?>" autocomplete="off">
                    <div class="invalid-feedback errorUserHP"></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-xl-12">
                <div class="form-group">
                    <label for="">Alamat & RT/RW</label>
                    <input type="text" name="useralamat" id="useralamat" class="form-control"
                        placeholder="Masukan Alamat, RT/RW..." value="<?= $useralamat ?>" autocomplete="off">
                    <div class="invalid-feedback errorUserAlamat"></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-xl-12">
                <div class="form-group">
                    <label for="">Pilih Daerah</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Kode Wilayah" name="kelurahanpilih"
                            id="kelurahanpilih" value="<?= $useralamatid ?>" readonly>
                        <div class="input-group-append">
                            <button class="btn btn-outline-success" type="button" id="tombolCariWilayah"
                                onclick="wilayahCari()" title="Cari Wilayah"><i class="fas fa-search"></i></button>
                        </div>
                        <div class="invalid-feedback errorUserAlamatID"></div>
                        <input type="hidden" name="useralamatid" id="useralamatid" value="<?= $useralamatid ?>">
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-xl-12">
                <div class="form-group">
                    <label for="">Lokasi</label>
                    <input type="text" name="lokasialamat" id="lokasialamat" class="form-control"
                        value="<?= $kelurahan . ', ' . $kecamatan . ', ' . $kota_kabupaten . ', ' . $propinsi ?>"
                        placeholder="Masukan Alamat..." readonly>
                    <div class="invalid-feedback errorUserAlamatID"></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-sm-6 col-md-12 col-xl-6">
                <div class="form-group">
                    <label for="">Kata Sandi</label>
                    <input type="password" name="userpassword" id="userpassword" class="form-control"
                        placeholder="Masukan Kata Sandi..." value="<?= $userpassword ?>" autocomplete="off">
                    <div class="invalid-feedback errorUserPassword"></div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-12 col-sm-6 col-md-12 col-xl-6">
                <button type="submit" class="btn btn-sm btn-success" id="tombolsimpan">Simpan</button>
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

                        if (err.errUserID) {
                            $('#userid').addClass('is-invalid');
                            $('.errorUserID').html(err.errUserID);
                        } else {
                            $('#userid').removeClass('is-invalid');
                            $('#userid').addClass('is-valid');
                        }

                        if (err.errUserNama) {
                            $('#usernama').addClass('is-invalid');
                            $('.errorUserNama').html(err.errUserNama);
                        } else {
                            $('#usernama').removeClass('is-invalid');
                            $('#usernama').addClass('is-valid');
                        }

                        if (err.errUserEmail) {
                            $('#useremail').addClass('is-invalid');
                            $('.errorUserEmail').html(err.errUserEmail);
                        } else {
                            $('#useremail').removeClass('is-invalid');
                            $('#useremail').addClass('is-valid');
                        }

                        if (err.errUserHP) {
                            $('#userhp').addClass('is-invalid');
                            $('.errorUserHP').html(err.errUserHP);
                        } else {
                            $('#userhp').removeClass('is-invalid');
                            $('#userhp').addClass('is-valid');
                        }

                        if (err.errUserAlamat) {
                            $('#useralamat').addClass('is-invalid');
                            $('.errorUserAlamat').html(err.errUserAlamat);
                        } else {
                            $('#useralamat').removeClass('is-invalid');
                            $('#useralamat').addClass('is-valid');
                        }

                        if (err.errUserAlamatID) {
                            $('#kelurahanpilih').addClass('is-invalid');
                            $('.errorUserAlamatID').html(err.errUserAlamatID);
                        } else {
                            $('#kelurahanpilih').removeClass('is-invalid');
                            $('#kelurahanpilih').addClass('is-valid');
                        }

                        if (err.errUserAlamatID) {
                            $('#lokasialamat').addClass('is-invalid');
                            $('.errorUserAlamatID').html(err.errUserAlamatID);
                        } else {
                            $('#lokasialamat').removeClass('is-invalid');
                            $('#lokasialamat').addClass('is-valid');
                        }

                        if (err.errUserPassword) {
                            $('#userpassword').addClass('is-invalid');
                            $('.errorUserPassword').html(err.errUserPassword);
                        } else {
                            $('#userpassword').removeClass('is-invalid');
                            $('#userpassword').addClass('is-valid');
                        }
                    }

                    if (response.sukses) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.sukses
                        }).then((resul) => {
                            if (resul.isConfirmed) {
                                window.location.reload();
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
            window.location.href = '<?= base_url() ?>user';
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
</script>


<?= $this->endSection('isi') ?>
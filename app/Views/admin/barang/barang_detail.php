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





    </div>
    <div class="card-body">

        <table style="width: 100%;" id="detailbarang"
            class="table table-sm table-bordered table-hover dataTable dtr-inline collapsed responsive">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Barcode</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Satuan</th>
                    <th>Isi dari Satuan</th>
                    <th>Konversi ke <?= $satlabel ?></th>
                    <th>Harga/<?= $satlabel ?></th>
                    <th>Total Harga</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td><?= $brgbarcode ?></td>
                    <td><?= $brgnama ?></td>
                    <td><?= $katnama ?></td>
                    <td><?= $satlabel ?></td>
                    <td><b><?= $brgsatisi ?></b> <?= $satlabel ?></td>
                    <td><b><?= $brgsatisi ?></b> <?= $satlabel ?></td>
                    <td align="right"><?= number_format($brgharga) ?></td>
                    <td align="right"><?= number_format($brgharga * 1) ?></td>
                    <td>
                        <div style="display: flex; gap: 5px;">
                            <button type="button" class="btn btn-sm btn-info" onclick="editHargaBarang('<?= $brgid ?>')" title="Edit"><i class='fas fa-edit'></i></button>
                            <button type="button" class="btn btn-sm btn-danger" onclick="hapus('<?= $brgid ?>')" title="Hapus" <?= ($cekTambahanHarga == "") ? "" : "disabled" ?>><i class='fas fa-trash-alt'></i></button>
                        </div>
                    </td>
                </tr>
                <?php
                $no = 2;
                foreach ($tampilTambahan as $rowTambahan):
                ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $rowTambahan['bth_barcode'] ?></td>
                        <td><?= $rowTambahan['brgnama'] ?></td>
                        <td><?= $rowTambahan['katnama'] ?></td>
                        <td><?= $rowTambahan['satlabel'] ?></td>
                        <td><b><?= $rowTambahan['bth_isi_min'] ?></b> <?= $rowTambahan['satlabel'] ?></td>
                        <td><b><?= $rowTambahan['bth_konversi_isi_min'] ?></b> <?= $satlabel ?></td>
                        <td align="right"><?= number_format($rowTambahan['bth_harga']) ?></td>
                        <td align="right"><?= number_format($rowTambahan['bth_harga'] * $rowTambahan['bth_konversi_isi_min']) ?></td>
                        <td>
                            <div style="display: flex; gap: 5px;">
                                <button type="button" class="btn btn-sm btn-info" onclick="editHargaTambahan('<?= $rowTambahan['bth_id'] ?>')" title="Edit"><i class='fas fa-edit'></i></button>
                                <button type="button" class="btn btn-sm btn-danger" onclick="hapusHargaTambahan('<?= $rowTambahan['bth_id'] ?>')" title="Hapus"><i class='fas fa-trash-alt'></i></button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>

        <form action="<?= base_url() ?>hargaTambahSimpan" class="formsimpan">
            <?= csrf_field(); ?>

            <input type="hidden" name="brgid" id="brgid" value="<?= $brgid ?>">


            <hr style="border: 1px solid blue;">

            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-xl-12">
                    <label for="">Tambah Harga untuk menambahakan lebih dari 1 harga atau harga Grosir.</label>
                </div>
            </div>


            <hr style="border: 0px solid secondary;">

            <!-- Container untuk Harga Tambahan -->

            <div id="bth_hargaContainer">
                <div class="row">
                    <div class="col-12 col-sm-3 col-md-12 col-xl-3">
                        <div class="form-group">
                            <label for="">Barcode</label>
                            <input type="number" name="bth_barcode" id="bth_barcode" class="form-control" minlength="13" maxlength="13" value="<?= $barcodeterakhir ?>" placeholder="Masukan Barcode..." autocomplete="off">
                            <div class="invalid-feedback errorBTHBarcode"></div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-3 col-md-12 col-xl-3">
                        <label for="">Satuan</label>
                        <select class="form-control" name="bth_satuan" id="bth_satuan">
                            <option value="" selected>-- Pilih Satuan --</option>
                            <option value="">-------------</option>
                            <?php foreach ($tampilSatuan as $rowSat): ?>
                                <option value="<?= $rowSat['satid'] ?>"><?= $rowSat['satnama'] ?></option>
                            <?php endforeach ?>
                        </select>
                        <div class="invalid-feedback errorBTHSatuan"></div>
                    </div>
                    <div class="col-12 col-sm-3 col-md-12 col-xl-3">
                        <label for="">Min</label>
                        <input type="text" name="bth_isi_min" id="bth_isi_min" class="form-control" placeholder="Isi Min" autocomplete="off">
                        <div class="invalid-feedback errorBTHMin"></div>
                    </div>
                    <div class="col-12 col-sm-3 col-md-12 col-xl-3">
                        <label for="">Max</label>
                        <input type="text" name="bth_isi_max" id="bth_isi_max" class="form-control" placeholder="Isi Max" autocomplete="off">
                        <div class="invalid-feedback errorBTHMax"></div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-12 col-sm-3 col-md-12 col-xl-3">
                        <label for="">Konversi</label>
                        <input type="text" name="bth_konversi_isi_min" id="bth_konversi_isi_min" class="form-control" placeholder="Konversi" autocomplete="off">
                        <div class="invalid-feedback errorBTHKonversi"></div>
                    </div>
                    <div class="col-12 col-sm-3 col-md-12 col-xl-3">
                        <label for="">Harga/Satuan</label>
                        <input type="text" name="bth_harga" id="bth_harga" class="form-control" placeholder="Harga" autocomplete="off">
                        <div class="invalid-feedback errorBTHHarga"></div>
                    </div>
                    <div class="col-12 col-sm-3 col-md-12 col-xl-3">
                        <label for="">#</label>
                        <br>
                        <button type="submit" class="btn btn-success removeRow" title="Tambah Harga"><i class="fas fa-plus"></i></button>
                    </div>

                </div>
            </div>


            <hr style="border: 1px solid blue;">


            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-xl-12">
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" id="batal">Kembali</button>
                </div>
            </div>



        </form>


    </div>

</div>


<div class="viewmodal" style="display: none;"></div>


<script src="<?= base_url('assets/dist/js/autoNumeric.js') ?>"></script>

<!-- Summernote -->
<script src="<?= base_url('assets/plugins/summernote/summernote-bs4.min.js') ?>"></script>

<script>
    $(document).ready(function() {
        var table = $('#detailbarang').dataTable({});



        // autonumerik bth_harga
        $('#bth_harga').autoNumeric('init', {
            mDec: 2,
            aDec: ',',
            aSep: '.',
        })
        $('#bth_harga').keyup(function(e) {
            let bth_harga = $('#bth_harga').autoNumeric('get');

        });

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

                        if (err.errBTHBarcode) {
                            $('#bth_barcode').addClass('is-invalid');
                            $('.errorBTHBarcode').html(err.errBTHBarcode);
                        } else {
                            $('#bth_barcode').removeClass('is-invalid');
                            $('#bth_barcode').addClass('is-valid');
                        }

                        if (err.errBTHSatuan) {
                            $('#bth_satuan').addClass('is-invalid');
                            $('.errorBTHSatuan').html(err.errBTHSatuan);
                        } else {
                            $('#bth_satuan').removeClass('is-invalid');
                            $('#bth_satuan').addClass('is-valid');
                        }

                        if (err.errBTHMin) {
                            $('#bth_isi_min').addClass('is-invalid');
                            $('.errorBTHMin').html(err.errBTHMin);
                        } else {
                            $('#bth_isi_min').removeClass('is-invalid');
                            $('#bth_isi_min').addClass('is-valid');
                        }

                        if (err.errBTHMax) {
                            $('#bth_isi_max').addClass('is-invalid');
                            $('.errorBTHMax').html(err.errBTHMax);
                        } else {
                            $('#bth_isi_max').removeClass('is-invalid');
                            $('#bth_isi_max').addClass('is-valid');
                        }

                        if (err.errBTHKonversi) {
                            $('#bth_konversi_isi_min').addClass('is-invalid');
                            $('.errorBTHKonversi').html(err.errBTHKonversi);
                        } else {
                            $('#bth_konversi_isi_min').removeClass('is-invalid');
                            $('#bth_konversi_isi_min').addClass('is-valid');
                        }

                        if (err.errBTHHarga) {
                            $('#bth_harga').addClass('is-invalid');
                            $('.errorBTHHarga').html(err.errBTHHarga);
                        } else {
                            $('#bth_harga').removeClass('is-invalid');
                            $('#bth_harga').addClass('is-valid');
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
            window.location.href = '<?= base_url() ?>barang';
        });

    });




    function editHargaBarang(id) {
        $.ajax({
            type: "post",
            url: "<?= base_url() ?>barangEdit/" + id,
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('.viewmodal').html(response.data).show();
                    $('#modalEdit').modal('show');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    }

    function editHargaTambahan(id) {
        $.ajax({
            type: "post",
            url: "<?= base_url() ?>editHargaTambahan/" + id,
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('.viewmodal').html(response.data).show();
                    $('#modalEdit').modal('show');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    }

    function hapusHargaTambahan(bth_id) {

        Swal.fire({
            title: 'Hapus Data!',
            text: "Apakah Anda yakin ingin menghapus ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= base_url() ?>hargaTambahHapus/" + bth_id,
                    dataType: "json",
                    success: function(response) {
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
            }
        })
    }



    function hapus(brgid) {

        Swal.fire({
            title: 'Hapus Data!',
            text: "Apakah Anda yakin ingin menghapus ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= base_url() ?>barangHapus/" + brgid,
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) {
                            swal.fire(
                                'Berhasil',
                                response.sukses,
                                'success'
                            ).then((result) => {
                                window.location.href = '<?= base_url() ?>barang';
                            })
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + '\n' + thrownError);
                    }
                });
            }
        })
    }
</script>


<?= $this->endSection('isi') ?>
<?= $this->extend('admin/layout/layout'); ?>

<?= $this->section('isi') ?>

<style>
    .list-group-flush {
        height: 550px;
        overflow-y: auto;
    }
</style>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" />
<div class='card'>
    <div class='card-header bg-info'>
        <div class='row'>
            <div class='col'>
                <a href="<?= base_url() ?>barangmasuk" type="button" class="btn btn-sm btn-warning" id="tambahBarangMasuk"><i class="fas fa-arrow-alt-circle-left"></i>
                    Kembali</a> &nbsp; <b><?= $title ?></b>
            </div>
        </div>
    </div>

    <div class="body">

        <ul class='list-group list-group-flush'>
            <li class='list-group-item'>

                <table class="table table-striped table-sm">
                    <tr>
                        <input type="hidden" id="nofaktur" value="<?= $nofaktur ?>">
                        <td style="width:20%;">No. PO</td>
                        <td style="width:10%;">:</td>
                        <td style="width:20%;"><?= $nofaktur ?></td>
                        <td rowspan="3" style="width:50%; font-weight:bold; color:red; font-size:20pt; text-align:center; vertical-align:middle;" id="lbTotalHarga"></td>
                    </tr>
                    <tr>
                        <td>Tanggal</td>
                        <td>:</td>
                        <td><?= $tanggal ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>



                <div class="row">

                    <div class="col-12 col-sm-4 col-md-12 col-xl-4">
                        <div class="form-group">
                            <label for="">Kode Barang</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Kode Barang" name="kodebarang" id="kodebarang" autofocus>
                                <input type="hidden" id="iddetail">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary" type="button" id="tombolCariBarang" title="Cari Barang"><i class="fas fa-search"></i></button>
                                </div>
                                <div class="invalid-feedback errorIdDetail"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-12 col-xl-6">
                        <div class="form-group">
                            <label for="">Nama Barang</label>
                            <input type="text" class="form-control" name="namabarang" id="namabarang" readonly>
                        </div>
                    </div>

                    <div class="col-12 col-sm-2 col-md-12 col-xl-2">
                        <div class="form-group">
                            <label for="">Harga Jual</label>
                            <input type="text" class="form-control" name="hargajual" id="hargajual" readonly>
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-12 col-sm-1 col-md-12 col-xl-1">
                        <div class="form-group">
                            <label for="">Qty</label>
                            <input type="number" class="form-control" name="jml" id="jml" value="1">
                        </div>
                    </div>

                    <div class="col-12 col-sm-3 col-md-12 col-xl-3">
                        <div class="form-group">
                            <label for="">Harga Beli</label>
                            <input type="text" class="form-control" name="hargabeli" id="hargabeli" autocomplete="off">
                            <div class="invalid-feedback errorHargaBeli"></div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-12 col-xl-6">
                        <div class="form-group">
                            <label for="">Keterangan</label>
                            <input type="text" class="form-control" name="detketerangan" id="detketerangan">
                            <div class="invalid-feedback errorKeterangan"></div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-2 col-md-12 col-xl-2">
                        <div class="form-group">
                            <label for="">#</label>
                            <div class="input-group">
                                <button type="button" class="btn btn-success" title="Simpan Item" id="tombolSimpanItem">
                                    <i class="fas fa-plus-square"></i>
                                </button>

                                <button type="button" class="btn btn-sm btn-primary" style="display: none;" title="Edit Item" id="tombolEditItem"><i class="fa fa-edit"></i></button>
                                &nbsp;
                                <button type="button" class="btn btn-sm btn-default" style="display: none;" title="Batalkan" id="tombolBatal"><i class="fa fa-sync-alt"></i></button>
                            </div>
                        </div>
                    </div>

                </div>


                <div class="row">
                    <div class="col-lg-12 tampilDataDetail">

                    </div>
                </div>



            </li>
        </ul>

    </div>

    <div class='card-footer'>
        <div class='row'>
            <div class='col text-right'>
                <button type="submit" class="btn btn-sm btn-success" id="tombolSelesaiTransaksi"><i class="fa fa-save"></i>
                    Selesaikan Faktur</button>
            </div>
        </div>
    </div>

</div>

<div class="viewmodal" style="display: none;"></div>


<script src="<?= base_url('assets/dist/js/autoNumeric.js') ?>"></script>

<script>
    $(document).ready(function() {
        // autonumerik prodisi
        $('#hargabeli').autoNumeric('init', {
            mDec: 2,
            aDec: ',',
            aSep: '.',
        })
        $('#hargabeli').keyup(function(e) {
            let hargabeli = $('#hargabeli').autoNumeric('get');

        });


        $('#tambahBarang').click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: "<?= base_url() ?>produkTambah",
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
        });


        $('#tombolCariBarang').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= base_url() ?>modalCariBarang",
                dataType: "json",
                success: function(response) {
                    if (response.data) {
                        $('.viewmodal').html(response.data).show();
                        $('#modalcaribarang').modal('show');
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });
        });



    });



    function kosong() {
        $('#iddetail').val('');
        $('#kodebarang').val('');
        $('#namabarang').val('');
        $('#hargajual').val('');
        $('#hargabeli').val('');
        $('#jml').val('1');
        $('#detketerangan').val('');
        $('#kodebarang').focus();
    }



    function ambilDataBarang() {

        let kodebarang = $('#kodebarang').val();
        if (kodebarang.length == 0) {
            swal.fire('Error', 'Kode barang harus diinput', 'error');
            kosong();
        } else {
            $.ajax({
                type: "post",
                url: "<?= base_url() ?>ambilDataBarang",
                data: {
                    kodebarang: kodebarang
                },
                dataType: "json",
                success: function(response) {
                    if (response.error) {
                        swal.fire('Error', response.error, 'error');
                        kosong();
                    }

                    if (response.sukses) {
                        let data = response.sukses;

                        $('#namabarang').val(data.namabarang);
                        $('#hargajual').val(data.hargajual);

                        $('#jml').focus();
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });
        }

    }

    function ambilTotalHarga() {
        let nofaktur = $('#nofaktur').val();
        $.ajax({
            type: "post",
            url: "<?= base_url() ?>ambilTotalHargaBarangMasuk",
            data: {
                nofaktur: nofaktur
            },
            dataType: "json",
            success: function(response) {
                $('#lbTotalHarga').html(response.totalharga);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    }


    function tampilDataDetail() {
        let faktur = $('#nofaktur').val();
        $.ajax({
            type: "post",
            url: "<?= base_url() ?>tampilDataDetailBarangMasuk",
            data: {
                nofaktur: faktur
            },
            dataType: "json",
            beforeSend: function() {
                $('.tampilDataDetail').html("<i class='fas fa-spin fa-spinner'></i>");
            },
            success: function(response) {
                if (response.data) {
                    $('.tampilDataDetail').html(response.data);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    }



    function simpanItem() {
        let nofaktur = $('#nofaktur').val();
        let kodebarang = $('#kodebarang').val();
        let namabarang = $('#namabarang').val();
        let hargabeli = $('#hargabeli').val();
        let hargajual = $('#hargajual').val();
        let jml = $('#jml').val();
        let detketerangan = $('#detketerangan').val();


        $.ajax({
            type: "post",
            url: "<?= base_url() ?>simpanDetailBarangMasuk",
            data: {
                nofaktur: nofaktur,
                kodebarang: kodebarang,
                namabarang: namabarang,
                hargabeli: hargabeli,
                hargajual: hargajual,
                jml: jml,
                detketerangan: detketerangan
            },
            dataType: "json",
            success: function(response) {

                if (response.error) {
                    let err = response.error;

                    if (err.errKodeBarang) {
                        $('#kodebarang').addClass('is-invalid');
                        $('.errorKodeBarang').html(err.errKodeBarang);
                    } else {
                        $('#kodebarang').removeClass('is-invalid');
                        $('#kodebarang').addClass('is-valid');
                    }

                    if (err.errHargaBeli) {
                        $('#hargabeli').addClass('is-invalid');
                        $('.errorHargaBeli').html(err.errHargaBeli);
                    } else {
                        $('#hargabeli').removeClass('is-invalid');
                        $('#hargabeli').addClass('is-valid');
                    }

                    if (err.errKeterangan) {
                        $('#detketerangan').addClass('is-invalid');
                        $('.errorKeterangan').html(err.errKeterangan);
                    } else {
                        $('#detketerangan').removeClass('is-invalid');
                        $('#detketerangan').addClass('is-valid');
                    }
                }

                if (response.sukses) {
                    tampilDataDetail();
                    ambilTotalHarga();
                    kosong();
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    }

    $(document).ready(function() {
        ambilTotalHarga();
        tampilDataDetail();

        $('#tombolEditItem').click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: "<?= base_url() ?>editItemBarangMasuk",
                data: {
                    iddetail: $('#iddetail').val(),
                    jml: $('#jml').val(),
                    hargabeli: $('#hargabeli').val(),
                    detketerangan: $('#detketerangan').val(),
                },
                dataType: "json",
                success: function(response) {
                    if (response.error) {
                        let err = response.error;

                        if (err.errIdDetail) {
                            $('#iddetail').addClass('is-invalid');
                            $('.errorIdDetail').html(err.errIdDetail);
                        } else {
                            $('#iddetail').removeClass('is-invalid');
                            $('#iddetail').addClass('is-valid');
                        }

                        if (err.errHargaBeli) {
                            $('#hargabeli').addClass('is-invalid');
                            $('.errorHargaBeli').html(err.errHargaBeli);
                        } else {
                            $('#hargabeli').removeClass('is-invalid');
                            $('#hargabeli').addClass('is-valid');
                        }

                        if (err.errKeterangan) {
                            $('#detketerangan').addClass('is-invalid');
                            $('.errorKeterangan').html(err.errKeterangan);
                        } else {
                            $('#detketerangan').removeClass('is-invalid');
                            $('#detketerangan').addClass('is-valid');
                        }
                    }


                    if (response.sukses) {
                        swal.fire(
                            'Berhasil',
                            response.sukses,
                            'success'
                        ).then((result) => {
                            tampilDataDetail();
                            ambilTotalHarga();
                            kosong();
                            $('#tombolBatal').fadeOut();
                            $('#tombolEditItem').fadeOut();
                            $('#kodebarang').prop('readonly', false);
                            $('#tombolCari').prop('disabled', false);
                            $('#tombolCariBarang').prop('disabled', false);
                            $('#tombolSimpanItem').fadeIn();
                        })
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });
        });

        $('#tombolSimpanItem').click(function(e) {
            e.preventDefault();
            simpanItem();
        });

        $('#tombolSelesaiTransaksi').click(function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Selesaikan Edit?',
                text: "Apakah ingin selesaikan transaksi !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Selesai!',
                cancelButtonText: 'Batal!'
            }).then((result) => {
                if (result.isConfirmed) {
                    location.href = ('<?= base_url() ?>barangmasuk');
                }
            })
        });
    });
</script>


<?= $this->endSection('isi') ?>
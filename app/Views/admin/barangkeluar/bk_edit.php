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
                <a href="<?= base_url() ?>barangkeluar" type="button" class="btn btn-sm btn-warning"><i class="fas fa-arrow-alt-circle-left"></i>
                    Kembali</a> &nbsp; <b><?= $title ?></b>
            </div>
        </div>
    </div>

    <div class="body">

        <ul class='list-group list-group-flush'>
            <li class='list-group-item'>

                <table class="table table-striped table-sm">
                    <tr>
                        <input type="hidden" id="noinvoice" value="<?= $noinvoice ?>">
                        <td style="width:20%;">No. Invoice</td>
                        <td style="width:10%;">:</td>
                        <td style="width:20%;"><?= $noinvoice ?></td>
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

                    <div class="col-12 col-sm-3 col-md-12 col-xl-3">
                        <div class="form-group">
                            <label for="">Kode Barang</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Kode Barang" name="kodebarang" id="kodebarang" autofocus>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary" type="button" id="tombolCariBarang" title="Cari Barang"><i class="fas fa-search"></i></button>
                                </div>
                                <div class="invalid-feedback errorKodeBarang"></div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="brgid" id="brgid" class="form-control">
                    <input type="hidden" name="usercabang" id="usercabang" value="<?= session()->usercabang ?>" class="form-control">

                    <div class="col-12 col-sm-4 col-md-12 col-xl-4">
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

                    <div class="col-12 col-sm-1 col-md-12 col-xl-1">
                        <div class="form-group">
                            <label for="">Qty</label>
                            <input type="number" class="form-control" name="jml" id="jml" value="1">
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
                    Selesaikan Invoice</button>
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
                url: "<?= base_url() ?>modalCariBarangJual",
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
        $('#kodebarang').val('');
        $('#namabarang').val('');
        $('#hargajual').val('');
        $('#jml').val('1');
        $('#kodebarang').focus();



        $('#kodebarang').removeClass('is-invalid');

    }



    function ambilDataBarangJual() {

        let kodebarang = $('#kodebarang').val();
        if (kodebarang.length == 0) {
            swal.fire('Error', 'Kode barang harus diinput', 'error');
            kosong();
        } else {
            $.ajax({
                type: "post",
                url: "<?= base_url() ?>ambilDataBarangJual",
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

                        $('#brgid').val(data.brgid);
                        $('#namabarang').val(data.namabarang);
                        $('#hargajual').val(data.hargajual);


                        simpanItem();
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });
        }

    }

    function ambilTotalHarga() {
        let noinvoice = $('#noinvoice').val();
        $.ajax({
            type: "post",
            url: "<?= base_url() ?>ambilTotalHargaBarangKeluar",
            data: {
                noinvoice: noinvoice
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
        let noinvoice = $('#noinvoice').val();
        $.ajax({
            type: "post",
            url: "<?= base_url() ?>tampilDataDetailBarangKeluar",
            data: {
                noinvoice: noinvoice
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

        let noinvoice = $('#noinvoice').val();
        let brgid = $('#brgid').val();
        let kodebarang = $('#kodebarang').val();
        let namabarang = $('#namabarang').val();
        let hargajual = $('#hargajual').val();
        let jml = $('#jml').val();
        let usercabang = $('#usercabang').val();


        $.ajax({
            type: "post",
            url: "<?= base_url() ?>simpanItemBarangKeluarDetail",
            data: {
                noinvoice: noinvoice,
                brgid: brgid,
                kodebarang: kodebarang,
                namabarang: namabarang,
                hargajual: hargajual,
                jml: jml,
                usercabang: usercabang,
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
                }

                if (response.sukses) {
                    ambilTotalHarga();
                    tampilDataDetail();
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
                    location.href = ('<?= base_url() ?>barangkeluar');
                }
            })
        });
    });
</script>


<?= $this->endSection('isi') ?>
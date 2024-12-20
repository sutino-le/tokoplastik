<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InoArt Developer</title>

    <link href="<?=base_url()?>upload/logovertikal.png" rel="icon">
    <link href="<?=base_url()?>upload/logovertikal.png" rel="apple-touch-icon">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?=base_url()?>assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?=base_url()?>assets/dist/css/adminlte.min.css">
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- DataTables -->
    <link rel="stylesheet" href="<?=base_url()?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet"
        href="<?=base_url()?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">


    <!-- Sweet alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
        integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <style>
        .list-group-flush {
            height: 400px;
            overflow-y: auto;
        }
    </style>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" />



</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="<?=base_url()?>upload/logovertikal.png" alt="logovertikal" height="60"
                width="60">
        </div>

        <!-- Navbar -->
        <nav class="navbar navbar-expand navbar-white navbar-light fixed-top">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="<?=base_url()?>barangkeluar" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="<?=base_url()?>barangKeluarTambah" class="nav-link">Transaksi Kasir</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="<?=base_url()?>laporanKasir" class="nav-link">Laporan Kasir</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?=base_url()?>logout" role="button">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->



        <!-- Main content -->
        <section class="content mt-5">
            <div class="container-fluid  bg-info text-white">
                <!-- Small boxes (Stat box) -->

                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0"></h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">

                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->


                <!-- Small boxes (Stat box) -->
                <div class="row">

                    <div class="col-lg-12 col-12">
                        <!-- small box -->
                        <div class="small-box bg-white">
                            <div class="inner">

                                <div class="row">
                                    <div class="col-12 col-sm-4 col-md-12 col-xl-4">
                                        <div class="form-group">
                                            <label for="usernama">Kasir</label>
                                            <input type="text" readonly class="form-control-plaintext" name="usernama" id="usernama" value="<?=session()->usernama?>">
                                            <input type="hidden" name="userid" id="userid" value="<?=session()->userid?>">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4 col-md-12 col-xl-4">
                                        <div class="form-group">
                                            <label for="tglinvoice">Tanggal</label>
                                            <input type="date" name="tglinvoice" id="tglinvoice" class="form-control" value="<?=date("Y-m-d")?>">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4 col-md-12 col-xl-4">
                                        <div class="form-group">
                                            <label for="noinvoice">Invoice</label>
                                            <input type="number" name="noinvoice" id="noinvoice" value="<?=$noinvoice?>" class="form-control" readonly>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="userid" id="userid" value="<?=session()->userid?>" class="form-control">

                                <div class="row">
                                    <div class="col-12 col-sm-4 col-md-12 col-xl-4">
                                        <label for="namabarang">Barcode</label>
                                        <div class="form-group row">
                                            <div class="input-group mr-3 ml-3">
                                                <input type="text" name="kodebarang" id="kodebarang" class="form-control" placeholder="Barcode Barang" aria-label="Barcode Barang" aria-describedby="basic-addon2" autocomplete="off" autofocus>
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-primary" type="button" id="tombolCariBarang" title="Cari Barang"><i class="fas fa-search"></i></button>
                                                </div>
                                                <div class="invalid-feedback errorKodeBarang"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4 col-md-12 col-xl-4">
                                        <div class="form-group ">
                                            <label for="namabarang">Nama Barang</label>
                                            <input type="text" name="namabarang" id="namabarang" class="form-control" placeholder="Nama Barang" readonly>

                                            <input type="hidden" name="brgid" id="brgid" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4 col-md-12 col-xl-4">
                                        <div class="form-group">
                                            <label for="hargajual">Harga</label>
                                            <input type="text" name="hargajual" id="hargajual" class="form-control" placeholder="Harga" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-sm-4 col-md-12 col-xl-4">
                                        <div class="form-group">
                                            <label for="jml">Qty</label>
                                            <input type="number" class="form-control" name="jml" id="jml" value="1">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4 col-md-12 col-xl-4">
                                        <div class="form-group">
                                            <label for="tombol">#</label>
                                            <br>
                                            <button type="button" class="btn btn-success" title="Simpan Item" id="tombolSimpanItem">
                                                <i class="fas fa-plus-square"></i> Tambah
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4 col-md-12 col-xl-4">
                                        <table class="table table-striped table-sm table-responsive">
                                            <tr>
                                                <td style="width:50%; font-weight:bold; color:red; font-size:20pt; text-align:center; vertical-align:middle;" id="totalharga">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="hidden" name="totalbayar" id="totalbayar">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center">
                                                    <button type="submit" class="btn btn-sm btn-success" id="tombolSelesaiTransaksi" style=" font-weight:bold; font-size:20pt; text-align:center; vertical-align:middle;"><i class="fa fa-save"></i>
                                                        Selesaikan Transaksi</button>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>


                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->

                </div>
                <!-- /.row (main row) -->


                <div class="row">

                    <div class="col-12 col-sm-12 col-md-12 col-xl-12">
                        <div class="small-box bg-white">
                            <div class="inner">



                                <ul class='list-group list-group-flush'>
                                    <li class='list-group-item'>

                                        <div class="row">
                                            <div class="col-lg-12 tampilDataTemp">

                                            </div>
                                        </div>

                                    </li>
                                </ul>


                            </div>
                        </div>
                    </div>
                </div>


            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->





        <div class="viewmodal" style="display: none;"></div>


        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->


    <!-- Bootstrap 4 -->
    <script src="<?=base_url()?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?=base_url()?>assets/dist/js/adminlte.min.js"></script>



    <!-- DataTables  & Plugins -->
    <script src="<?=base_url()?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?=base_url()?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?=base_url()?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?=base_url()?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="<?=base_url()?>assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?=base_url()?>assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="<?=base_url()?>assets/plugins/jszip/jszip.min.js"></script>
    <script src="<?=base_url()?>assets/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="<?=base_url()?>assets/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="<?=base_url()?>assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="<?=base_url()?>assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="<?=base_url()?>assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <!-- Page specific script -->
    <!-- Select2 -->


    <script src="<?=base_url('assets/dist/js/autoNumeric.js')?>"></script>

    <script>
        function buatNoInvoice() {
            let tanggal = $('#tglinvoice').val();

            $.ajax({
                type: "post",
                url: "<?=base_url()?>buatNoInvoiceBarangKeluar",
                data: {
                    tanggal: tanggal
                },
                dataType: "json",
                success: function(response) {
                    $('#noinvoice').val(response.noinvoice);
                    tampilDataTemp();
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });

        }


        $(document).ready(function() {

            // autonumerik prodisi
            $('#hargajual').autoNumeric('init', {
                mDec: 2,
                aDec: ',',
                aSep: '.',
            })
            $('#hargajual').keyup(function(e) {
                let hargajual = $('#hargajual').autoNumeric('get');

            });

            $('#tombolCariBarang').click(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "<?=base_url()?>modalCariBarangJual",
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

        function tampilDataTemp() {
            let faktur = $('#noinvoice').val();
            $.ajax({
                type: "post",
                url: "<?=base_url()?>tampilDataTempBarangKeluar",
                data: {
                    noinvoice: faktur
                },
                dataType: "json",
                beforeSend: function() {
                    $('.tampilDataTemp').html("<i class='fas fa-spin fa-spinner'></i>");
                },
                success: function(response) {
                    if (response.data) {
                        $('.tampilDataTemp').html(response.data);

                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });
        }


        function ambilDataBarangJual() {

            let kodebarang = $('#kodebarang').val();
            if (kodebarang.length == 0) {
                swal.fire('Error', 'Kode barang harus diinput', 'error');
                kosong();
            } else {
                $.ajax({
                    type: "post",
                    url: "<?=base_url()?>ambilDataBarangJual",
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



        function ambilTotalHargaTemp() {
            let noinvoice = $('#noinvoice').val();
            $.ajax({
                type: "post",
                url: "<?=base_url()?>ambilTotalHargaBarangKeluarTemp",
                data: {
                    noinvoice: noinvoice
                },
                dataType: "json",
                success: function(response) {
                    $('#totalharga').html(response.totalharga);
                    $('#totalbayar').val(response.totalbayar);
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });
        }






        function kosong() {
            $('#kodebarang').val('');
            $('#brgid').val('');
            $('#namabarang').val('');
            $('#hargajual').val('');
            $('#jml').val('1');
            $('#kodebarang').focus();



            $('#kodebarang').removeClass('is-invalid');

        }

        function simpanItem() {
            let noinvoice = $('#noinvoice').val();
            let brgid = $('#brgid').val();
            let kodebarang = $('#kodebarang').val();
            let namabarang = $('#namabarang').val();
            let hargajual = $('#hargajual').val();
            let jml = $('#jml').val();
            let userid = $('#userid').val();


            $.ajax({
                type: "post",
                url: "<?=base_url()?>simpanItemBarangKeluar",
                data: {
                    noinvoice: noinvoice,
                    brgid: brgid,
                    kodebarang: kodebarang,
                    namabarang: namabarang,
                    hargajual: hargajual,
                    jml: jml,
                    userid: userid,
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
                        ambilTotalHargaTemp();
                        tampilDataTemp();
                        kosong();
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });
        }


        $(document).ready(function() {
            ambilTotalHargaTemp();
            tampilDataTemp();
            $('#tglinvoice').change(function(e) {
                buatNoInvoice();
            });

            $('#kodebarang').keydown(function(e) {
                if (e.keyCode == 13) {
                    e.preventDefault();
                    ambilDataBarangJual();
                }
            });

            $('#tombolSimpanItem').click(function(e) {
                e.preventDefault();
                simpanItem();
            });


            // tombol selesaikan transaksi
            $('#tombolSelesaiTransaksi').click(function(e) {
                e.preventDefault();


                let totalharga = $('#totalbayar').val();

                if (totalharga.length == 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Maaf, Belum ada transaksi'
                    })
                } else {
                    $.ajax({
                        type: "post",
                        url: "<?=base_url()?>modalPembayaranBarangKeluar",
                        data: {
                            noinvoice: $('#noinvoice').val(),
                            tglinvoice: $('#tglinvoice').val(),
                            userid: $('#userid').val(),
                            totalharga: totalharga,
                        },
                        dataType: "json",
                        success: function(response) {
                            if (response.error) {
                                swal.fire('Error', response.error, 'error');
                                kosong();
                            }

                            if (response.data) {
                                $('.viewmodal').html(response.data).show();
                                $('#modalpembayaran').modal('show');
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(xhr.status + '\n' + thrownError);
                        }
                    });
                }



            });



        });
    </script>
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>

</body>

</html>
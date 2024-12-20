<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InoArt Developer</title>

    <link href="<?= base_url() ?>upload/logovertikal.png" rel="icon">
    <link href="<?= base_url() ?>upload/logovertikal.png" rel="apple-touch-icon">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/dist/css/adminlte.min.css">
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- DataTables -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">


    <!-- Sweet alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
        integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>



</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="<?= base_url() ?>upload/logovertikal.png" alt="logovertikal" height="60"
                width="60">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light fixed-top">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="<?= base_url() ?>main" class="nav-link">Home</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url() ?>logout" role="button">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="<?= base_url() ?>main" class="brand-link">
                <img src="<?= base_url() ?>upload/logovertikal.png" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">InoArt Developer</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="<?= base_url() ?>assets/dist/img/user2-160x160.jpg" class="img-circle elevation-2"
                            alt="User Image">
                    </div>
                    <div class="info">
                        <a href="<?= base_url() ?>userEditProfil/<?= session()->userid ?>"
                            class="d-block"><?= session()->usernama ?></a>
                    </div>
                </div>

                <!-- SidebarSearch Form -->
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <?php
                if (session()->level == 1) {

                    $dashboard = "show";

                    // setting
                    $setting = "show";
                    $wilayah = "show";
                    $levels = "show";
                    $users = "show";
                    $cabang = "show";

                    // master
                    $master = "show";
                    $kategori = "show";
                    $satuan = "show";
                    $barang = "show";

                    // purchasing
                    $purchasing = "show";
                    $barangmasuk = "show";
                    $databarangmasuk = "show";

                    // masterkeluar
                    $masterkeluar = "show";
                    $barangkeluar = "show";
                    $databarangkeluar = "show";

                    // stockbarang
                    $stockbarang = "show";

                    // kasir
                    $kasir = "show";
                    $bukakasir = "show";
                    $laporankasir = "show";
                } else if (session()->level == 2) {

                    $dashboard = "show";

                    // setting
                    $setting = "none";
                    $wilayah = "none";
                    $levels = "none";
                    $users = "none";
                    $cabang = "none";

                    // master
                    $master = "show";
                    $kategori = "show";
                    $satuan = "show";
                    $barang = "show";

                    // purchasing
                    $purchasing = "show";
                    $barangmasuk = "show";
                    $databarangmasuk = "show";

                    // masterkeluar
                    $masterkeluar = "show";
                    $barangkeluar = "show";
                    $databarangkeluar = "show";

                    // stockbarang
                    $stockbarang = "show";

                    // kasir
                    $kasir = "show";
                    $bukakasir = "show";
                    $laporankasir = "show";
                } else {

                    $dashboard = "none";

                    // setting
                    $setting = "none";
                    $wilayah = "none";
                    $levels = "none";
                    $users = "none";
                    $cabang = "none";

                    // master
                    $master = "none";
                    $kategori = "none";
                    $satuan = "none";
                    $barang = "none";

                    // purchasing
                    $purchasing = "none";
                    $barangmasuk = "none";
                    $databarangmasuk = "none";

                    // masterkeluar
                    $masterkeluar = "none";
                    $barangkeluar = "none";
                    $databarangkeluar = "none";

                    // kasir
                    $kasir = "none";
                    $bukakasir = "none";
                    $laporankasir = "none";
                }
                ?>
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="<?= base_url() ?>main" class="nav-link  <?= ($menu == 'dashboard') ? 'active' : '' ?>">
                                <i class="fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>

                        <!-- Setting -->
                        <li class="nav-item <?= ($menu == 'setting') ? 'menu-open' : '' ?>"
                            style="display: <?= $setting ?>;">
                            <a href="#" class="nav-link <?= ($menu == 'setting') ? 'active' : '' ?>">
                                <i class="fas fa-cog text-info"></i>
                                <p>
                                    Setting
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview ml-2">
                                <li class="nav-item" style="display: <?= $wilayah ?>;">
                                    <a href="<?= base_url() ?>wilayah"
                                        class="nav-link <?= ($submenu == 'wilayah') ? 'active' : '' ?>">
                                        <i class="fas fa-map-marked-alt nav-icon text-info"></i>
                                        <p>Wilayah</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview ml-2">
                                <li class="nav-item" style="display: <?= $levels ?>;">
                                    <a href="<?= base_url() ?>level"
                                        class="nav-link <?= ($submenu == 'level') ? 'active' : '' ?>">
                                        <i class="fas fa-network-wired nav-icon text-info"></i>
                                        <p>Levels</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview ml-2">
                                <li class="nav-item" style="display: <?= $cabang ?>;">
                                    <a href="<?= base_url() ?>cabang"
                                        class="nav-link <?= ($submenu == 'cabang') ? 'active' : '' ?>">
                                        <i class="fab fa-hubspot nav-icon text-info"></i>
                                        <p>Cabang</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview ml-2">
                                <li class="nav-item" style="display: <?= $users ?>;">
                                    <a href="<?= base_url() ?>user"
                                        class="nav-link <?= ($submenu == 'user') ? 'active' : '' ?>">
                                        <i class="fas fa-user nav-icon text-info"></i>
                                        <p>Users</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- master -->
                        <li class="nav-item <?= ($menu == 'master') ? 'menu-open' : '' ?>" style="display: <?= $master ?>;">
                            <a href="#" class="nav-link <?= ($menu == 'master') ? 'active' : '' ?>">
                                <i class="fas fa-cogs text-warning"></i>
                                <p>
                                    Master
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview ml-2">
                                <li class="nav-item" style="display: <?= $kategori ?>;">
                                    <a href="<?= base_url() ?>kategori"
                                        class="nav-link <?= ($submenu == 'kategori') ? 'active' : '' ?>">
                                        <i class="fas fa-code-branch nav-icon text-warning"></i>
                                        <p>Kategori</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview ml-2">
                                <li class="nav-item" style="display: <?= $satuan ?>;">
                                    <a href="<?= base_url() ?>satuan"
                                        class="nav-link <?= ($submenu == 'satuan') ? 'active' : '' ?>">
                                        <i class="fas fa-coins nav-icon text-warning"></i>
                                        <p>Satuan</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview ml-2">
                                <li class="nav-item" style="display: <?= $barang ?>;">
                                    <a href="<?= base_url() ?>barang"
                                        class="nav-link <?= ($submenu == 'barang') ? 'active' : '' ?>">
                                        <i class="fas fa-luggage-cart nav-icon text-warning"></i>
                                        <p>Barang</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- purchasing -->
                        <li class="nav-item <?= ($menu == 'purchasing') ? 'menu-open' : '' ?>"
                            style="display: <?= $purchasing ?>;">
                            <a href="#" class="nav-link <?= ($menu == 'purchasing') ? 'active' : '' ?>">
                                <i class="fas fa-shipping-fast text-success"></i>
                                <p>
                                    Purchasing
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview ml-2">
                                <li class="nav-item" style="display: <?= $barangmasuk ?>;">
                                    <a href="<?= base_url() ?>barangmasuk"
                                        class="nav-link <?= ($submenu == 'barangmasuk') ? 'active' : '' ?>">
                                        <i class="fas fa-sign-in-alt nav-icon text-success"></i>
                                        <p>Barang Masuk</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview ml-2">
                                <li class="nav-item" style="display: <?= $databarangmasuk ?>;">
                                    <a href="<?= base_url() ?>databarangmasuk"
                                        class="nav-link <?= ($submenu == 'databarangmasuk') ? 'active' : '' ?>">
                                        <i class="fas fa-file-import nav-icon text-success"></i>
                                        <p>Detail Barang Masuk</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- barang keluar -->
                        <li class="nav-item <?= ($menu == 'masterkeluar') ? 'menu-open' : '' ?>"
                            style="display: <?= $masterkeluar ?>;">
                            <a href="#" class="nav-link <?= ($menu == 'masterkeluar') ? 'active' : '' ?>">
                                <i class="fas fa-shopping-basket text-danger"></i>
                                <p>
                                    Barang Keluar
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview ml-2">
                                <li class="nav-item" style="display: <?= $barangkeluar ?>;">
                                    <a href="<?= base_url() ?>barangkeluar"
                                        class="nav-link <?= ($submenu == 'barangkeluar') ? 'active' : '' ?>">
                                        <i class="fas fa-sign-out-alt nav-icon text-danger"></i>
                                        <p>Barang Keluar</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview ml-2">
                                <li class="nav-item" style="display: <?= $databarangkeluar ?>;">
                                    <a href="<?= base_url() ?>databarangkeluar"
                                        class="nav-link <?= ($submenu == 'databarangkeluar') ? 'active' : '' ?>">
                                        <i class="fas fas fa-file-export nav-icon text-danger"></i>
                                        <p>Laporan Penjualan</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Stock -->
                        <li class="nav-item">
                            <a href="<?= base_url() ?>stockbarang"
                                class="nav-link  <?= ($menu == 'stockbarang') ? 'active' : '' ?>">
                                <i class="fas fa-database text-warning"></i>
                                <p>
                                    Stock Barang
                                </p>
                            </a>
                        </li>


                        <hr style="height:2px;border-width:0;color:white;background-color:white">


                        <!-- Kasir -->
                        <li class="nav-item <?= ($menu == 'kasir') ? 'menu-open' : '' ?>" style="display: <?= $kasir ?>;">
                            <a href="#" class="nav-link <?= ($menu == 'kasir') ? 'active' : '' ?>">
                                <i class="fas fa-cash-register text-warning"></i>
                                <p>
                                    Kasir
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview ml-2">
                                <li class="nav-item" style="display: <?= $bukakasir ?>;">
                                    <a href="<?= base_url() ?>barangKeluarTambah"
                                        class="nav-link <?= ($submenu == 'bukakasir') ? 'active' : '' ?>">
                                        <i class="fas fa-cash-register  nav-icon text-warning"></i>
                                        <p>Transaksi</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview ml-2">
                                <li class="nav-item" style="display: <?= $laporankasir ?>;">
                                    <a href="<?= base_url() ?>laporanKasir"
                                        class="nav-link <?= ($submenu == 'laporankasir') ? 'active' : '' ?>">
                                        <i class="fas fa-file-export nav-icon text-warning"></i>
                                        <p>Laporan Kasir</p>
                                    </a>
                                </li>
                            </ul>
                        </li>


                        <hr style="height:2px;border-width:0;color:white;background-color:white">


                        <!-- backup -->
                        <li class="nav-item <?= ($menu == 'backup') ? 'menu-open' : '' ?>">
                            <a href="<?= base_url() ?>backup" class="nav-link <?= ($menu == 'backup') ? 'active' : '' ?>"><i
                                    class="fas fa-cloud-download-alt text-primary"></i>
                                Backup</a>
                        </li>




                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper mt-5">
            <!-- Content Header (Page header) -->
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

            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <?= $this->renderSection('isi'); ?>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Copyright &copy; <?= date('Y') ?> <a href="https://inoartdev.com/">InoArt Developer</a>.</strong>
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0
            </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->


    <!-- Bootstrap 4 -->
    <script src="<?= base_url() ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url() ?>assets/dist/js/adminlte.min.js"></script>



    <!-- DataTables  & Plugins -->
    <script src="<?= base_url() ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/jszip/jszip.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="<?= base_url() ?>assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <!-- Page specific script -->
    <!-- Select2 -->
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
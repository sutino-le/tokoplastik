<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kasir</title>

    <link href="<?= base_url() ?>upload/logovertikal.png" rel="icon">
    <link href="<?= base_url() ?>upload/logovertikal.png" rel="apple-touch-icon">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body onload="window.print();">

    <div class="container-fluid">

        <center>
            <h1>Laporan Penjualan</h1>
            <h3>ID Kasir : <?= $userid ?></h3>
            <p>Tanggal : <?= date('d F Y', strtotime($tanggal)) ?></p>
        </center>
        <table class="table table-sm table-bordered table-striped">
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Tanggal</th>
                <th>Modal</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Diskon</th>
                <th>Total Harga</th>
                <th>Laba-Rugi</th>
            </tr>
            <?php
            $no = 1;
            $totalPenjualan = 0;
            $totalModal = 0;
            $totalLaba = 0;
            foreach ($tampilLaporanKasir->getResultArray() as $row):
            ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row['brgnama'] ?></td>
                    <td><?= date('d-m-Y', strtotime($row['tglinvoice'])) ?></td>
                    <td align="right"><?= number_format($row['brgmodal']) ?></td>
                    <td align="right"><?= number_format($row['dethargajual']) ?></td>
                    <td align="center"><?= $row['detjml'] ?></td>
                    <td align="right"><?= number_format($row['detdiskon']) ?></td>
                    <td align="right"><?= number_format($row['detsubtotal']) ?></td>
                    <td align="right">
                        <?php
                        $labarugi = $row['detsubtotal'] - ($row['brgmodal'] * $row['detjml']);
                        echo number_format($labarugi);
                        ?>
                    </td>
                </tr>
            <?php
                $totalPenjualan += $row['detsubtotal'];
                $totalModal += ($row['brgmodal'] * $row['detjml']);
                $totalLaba += $labarugi;
            endforeach
            ?>
            <tr>
                <td align="right" colspan="7"> <b>Sub Total :</b></td>
                <td align="right"><b><?= number_format($totalPenjualan) ?></b></td>
                <td align="right"><b><?= number_format($totalLaba) ?></b></td>
            </tr>
            <tr>
                <td align="right" colspan="7"> <b>Diskon Toko :</b></td>
                <td align="right"><b><?= number_format($totalDiskon) ?></b></td>
                <td align="right"></td>
            </tr>
            <tr>
                <td align="right" colspan="7"> <b>Total Penjualan :</b></td>
                <td align="right"><b><?= number_format($totalPenjualan - $totalDiskon) ?></b></td>
                <td></td>
            </tr>
            <tr>
                <td align="right" colspan="7"> <b>Total Modal :</b></td>
                <td align="right"><b><?= number_format($totalModal) ?></b></td>
                <td></td>
            </tr>
            <tr>
                <td align="right" colspan="7"> <b>Total Laba :</b></td>
                <td align="right"><b><?= number_format(($totalPenjualan - $totalDiskon) - $totalModal) ?></b></td>
                <td align="right"></td>
            </tr>
        </table>



    </div>

</body>

</html>
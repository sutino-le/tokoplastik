<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Invoice</title>
</head>

<body onload="window.print();">
    <table border="0" style="width: 100%;">
        <tr style="text-align: center;">
            <td colspan="4">
                <h3 style="height: 2px;"><?= $cabang_nama ?></h3>
                <p><?= $cabang_alamat ?>, <?= $kelurahan ?>, <?= $kecamatan ?><br><i><?= $cabang_hp ?></i></p>
                <hr style="border: 0; border-top: 1px solid #000;">
            </td>
        </tr>
        <tr style="text-align: left;">
            <td>No. Inv.</td>
            <td colspan="3">: <?= $invoice ?></td>
        </tr>
        <tr style="text-align: left;">
            <td>Tgl. Inv.</td>
            <td colspan="3">: <?= date("d/m/Y", strtotime($tanggal)) ?></td>
        </tr>
        <tr style="text-align: left;">
            <td>Kasir</td>
            <td colspan="3">: <?= $namaUser ?></td>
        </tr>
        <tr style="text-align: center;">
            <td colspan="4">
                <hr style="border: 0; border-top: 1px dashed #000;">
            </td>
        </tr>
        <tr style="text-align: center;">
            <td colspan="4">
                <table style="width: 100%; text-align:left; font-size: 10pt;">
                    <?php
                    $servername = "localhost";
                    $database = "tokoplastik";
                    $username = "root";
                    $password = "";

                    // Create connection
                    $koneksi = mysqli_connect($servername, $username, $password, $database);

                    $totalhargabayar = 0;
                    foreach ($detailbarang->getResultArray() as $row):

                        $hargajual = $row['dethargajual'];
                        $brgid = $row['brgid'];

                        // Ambil semua data harga (min, max, dan asli) dalam satu query
                        $query = mysqli_query($koneksi, "SELECT * FROM barang_tambahharga JOIN satuan ON barang_tambahharga.bth_satuan = satuan.satid WHERE barang_tambahharga.bth_brgid = '$brgid' ORDER BY barang_tambahharga.bth_id ASC ");

                        $hasilMin = null;
                        $hasilMax = null;
                        $hasilAsli = null;

                        // Iterasi hasil query untuk menentukan min, max, dan asli
                        while ($data = mysqli_fetch_assoc($query)) {
                            if (!$hasilMin) {
                                $hasilMin = $data;
                            }
                            // Data pertama sebagai harga min
                            $hasilMax = $data; // Data terakhir sebagai harga max
                            if ($data['bth_harga'] == $hargajual) {
                                $hasilAsli = $data;
                            }
                            // Harga asli
                        }

                        // Validasi jika data tidak ditemukan
                        if (!$hasilMin || !$hasilMax || !$hasilAsli) {
                            // Ganti die dengan logika default jika data tidak lengkap
                            $jumlahbaru = $row['detjml'];
                            $satuanbaru = $row['satlabel'];
                            $hargajualbaru = $row['dethargajual'];
                        } else {
                            // Logika perhitungan jumlah, satuan, dan harga jual baru
                            if ($row['detjml'] < $hasilMax['bth_konversi_isi_min']) {
                                if (fmod($row['detjml'], $hasilMin['bth_konversi_isi_min']) == 0) {
                                    $jumlahbaru = $row['detjml'] / $hasilMin['bth_konversi_isi_min'];
                                    $satuanbaru = $hasilMin['satlabel'];
                                    $hargajualbaru = $hasilAsli['bth_harga'] * $hasilMin['bth_konversi_isi_min'];
                                } else {
                                    $jumlahbaru = $row['detjml'];
                                    $satuanbaru = $row['satlabel'];
                                    $hargajualbaru = $row['dethargajual'];
                                }
                            } else if ($row['detjml'] >= $hasilMax['bth_konversi_isi_min']) {
                                if (fmod($row['detjml'], $hasilMax['bth_konversi_isi_min']) == 0) {
                                    $jumlahbaru = $row['detjml'] / $hasilMax['bth_konversi_isi_min'];
                                    $satuanbaru = $hasilMax['satlabel'];
                                    $hargajualbaru = $hasilAsli['bth_harga'] * $hasilMax['bth_konversi_isi_min'];
                                } else {
                                    $jumlahbaru = $row['detjml'];
                                    $satuanbaru = $row['satlabel'];
                                    $hargajualbaru = $row['dethargajual'];
                                }
                            }
                        }

                    ?>
                        <tr>
                            <td colspan="5"><?= $row['brgnama'] ?></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td><?= number_format($jumlahbaru, 0, ",", ".") . ' ' . $satuanbaru ?></td>
                            <td>x</td>
                            <td>@ <?= number_format($hargajualbaru, 0, ",", ".") ?></td>
                            <td style="text-align: right;"><?= number_format($row['detsubtotal'], 0, ",", ".") ?></td>
                        </tr>
                        <?php
                        if ($row['detdiskon'] == 0) {
                        ?>
                        <?php
                        } else {
                        ?>
                            <tr>
                                <td></td>
                                <td colspan="2">Disc @ <?= number_format($row['detdiskon'], 0, ",", ".") ?></td>
                                <td></td>
                            </tr>
                        <?php
                        }
                        ?>

                    <?php
                        $totalhargabayar += $row['detsubtotal'];
                    endforeach;
                    ?>
                </table>
            </td>
        </tr>
        <tr style="text-align: center;">
            <td colspan="4">
                <hr style="border: 0; border-top: 1px dashed #000;">
            </td>
        </tr>
        <tr style="text-align: left;">
            <td colspan="2" align="right">Sub Total</td>
            <td>: Rp. </td>
            <td style="text-align: right;"><?= number_format($totalhargabayar, 0, ",", ".") ?></td>
        </tr>
        <tr style="text-align: left;">
            <td colspan="2" align="right">Disc. Toko</td>
            <td>: Rp. </td>
            <td style="text-align: right;"><?= number_format($disctoko, 0, ",", ".") ?></td>
        </tr>
        <tr style="text-align: center;">
            <td colspan="4">
                <hr style="border: 0; border-top: 1px dashed #000;">
            </td>
        </tr>
        <tr style="text-align: left;">
            <td colspan="2" align="right">Total Bayar</td>
            <td>: Rp. </td>
            <td style="text-align: right;"><?= number_format(($totalhargabayar - $disctoko), 0, ",", ".") ?></td>
        </tr>
        <tr style="text-align: left;">
            <td colspan="2" align="right">Bayar</td>
            <td>: Rp. </td>
            <td style="text-align: right;"><?= number_format($jumlahuang, 0, ",", ".") ?></td>
        </tr>
        <tr style="text-align: center;">
            <td colspan="4">
                <hr style="border: 0; border-top: 1px dashed #000;">
            </td>
        </tr>
        <tr style="text-align: left;">
            <td colspan="2" align="right">Kembali</td>
            <td>: Rp. </td>
            <td style="text-align: right;"><?= number_format($jumlahuang - ($totalhargabayar - $disctoko), 0, ",", ".") ?></td>
        </tr>
        <tr style="text-align: center;">
            <td colspan="4">
                <hr style="border: 0; border-top: 1px solid #000;">
                <h5>* Barang yg sudah dibeli tidak dapat ditukar atau dikembalikan *</h5>
                <h3 style="height: 2px;">*** Terima kasih***</h3>
                <h5 style="height: 2px;">Atas kedatanganya..semoga puas</h5>
                <h5 style="height: 2px;"><?= date('d/m/Y H:i:s') ?></h5>
            </td>
        </tr>
    </table>
</body>

</html>
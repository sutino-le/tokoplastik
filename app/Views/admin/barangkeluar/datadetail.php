<table class="table table-sm table-hover table-bordered" style="width: 100%;">
    <thead>
        <tr>
            <th>No.</th>
            <th>Nama Barang</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Discount</th>
            <th>Sub.Total</th>
            <th>#</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($tampildata->getResultArray() as $row) :
        ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['brgnama']; ?></td>
                <td align="right"><?= number_format($row['dethargajual'], 0, ",", "."); ?></td>
                <td align="right"><?= number_format($row['detjml'], 0, ",", "."); ?></td>
                <td align="right"><?= number_format($row['detdiskon'], 0, ",", "."); ?></td>
                <td align="right"><?= number_format($row['detsubtotal'], 0, ",", "."); ?></td>
                <td>
                    <button type="button" class="btn btn-sm btn-success" onclick="editItem('<?= $row['iddetail'] ?>')" title="Edit Qty"><i
                            class="fa fa-edit"></i></button>
                    <button type="button" class="btn btn-sm btn-danger" onclick="hapusItem('<?= $row['iddetail'] ?>')"><i
                            class="fa fa-trash-alt"></i></button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<script>
    function hapusItem(iddetail) {
        Swal.fire({
            title: 'Hapus Item ?',
            text: "Yakin ingin menghapus Item ini !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: "<?= base_url() ?>hapusItemBarangKeluarDet",
                    data: {
                        iddetail: iddetail
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) {
                            swal.fire('Berhasil', response.sukses, 'success');
                            ambilTotalHarga();
                            tampilDataDetail();
                            kosong();
                        }
                    }
                });
            }
        })
    }

    function editItem(iddetail) {
        $.ajax({
            url: "<?= base_url() ?>modalEditItemBarangKeluarDetail/" + iddetail,
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('.viewmodal').html(response.data).show();
                    $('#modalEditItem').modal('show');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    }
</script>
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

        <button type="button" class="btn btn-sm btn-primary" id="tambahLevel"><i class="fas fa-plus-circle"></i>
            Tambah Level</button>

        <hr>

        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID</th>
                    <th>Level</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($dataLevel->getResultArray() as $rowLevel) :
                ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $rowLevel['levelid'] ?></td>
                        <td><?= $rowLevel['levelnama'] ?></td>
                        <td>
                            <button type="button" class="btn btn-sm btn-info" onclick="edit(<?= $rowLevel['levelid'] ?>)"
                                title="Edit"><i class='fas fa-edit'></i></button>
                            <button type="button" class="btn btn-sm btn-danger" onclick="hapus(<?= $rowLevel['levelid'] ?>)"
                                title="Hapus" <?= ($rowLevel['userid'] == '') ? '' : 'disabled' ?>><i
                                    class='fas fa-trash-alt'></i></button>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>

    </div>
</div>


<div class="viewmodal" style="display: none;"></div>

<script>
    $(document).ready(function() {

        $('#tambahLevel').click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: "<?= base_url() ?>levelTambah",
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

    });


    function edit(levelid) {
        $.ajax({
            type: "post",
            url: "<?= base_url() ?>levelEdit/" + levelid,
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

    function hapus(levelid) {

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
                    url: "<?= base_url() ?>levelHapus/" + levelid,
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
</script>

<?= $this->endSection('isi') ?>
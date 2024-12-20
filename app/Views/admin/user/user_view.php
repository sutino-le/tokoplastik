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

        <button type="button" class="btn btn-sm btn-primary" id="tambahUser"><i class="fas fa-plus-circle"></i>
            Tambah User</button>

        <hr>

        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>HP</th>
                    <th>Alamat</th>
                    <th>Status</th>
                    <th>Level</th>
                    <th>Cabang</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($dataUser->getResultArray() as $rowUser) :
                ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $rowUser['userid'] ?></td>
                        <td><?= $rowUser['usernama'] ?></td>
                        <td><?= $rowUser['useremail'] ?></td>
                        <td><?= $rowUser['userhp'] ?></td>
                        <td><?= $rowUser['useralamat'] ?></td>
                        <td><?= $rowUser['userstatus'] ?></td>
                        <td><?= $rowUser['levelnama'] ?></td>
                        <td><?= $rowUser['cabang_nama'] ?></td>
                        <td>
                            <div style="display: flex; gap: 5px;">
                                <button type="button" class="btn btn-sm btn-info" onclick="edit('<?= $rowUser['userid'] ?>')"
                                    title="Edit"><i class='fas fa-edit'></i></button>
                                <button type="button" class="btn btn-sm btn-danger" onclick="hapus('<?= $rowUser['userid'] ?>')"
                                    title="Hapus" <?= ($rowUser['userid'] == 'Administrator') ? 'disabled' : '' ?>><i
                                        class='fas fa-trash-alt'></i></button>
                            </div>
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

        $('#tambahUser').click(function(e) {
            e.preventDefault();
            window.location.href = '<?= base_url() ?>userTambah';
        });

    });




    function edit(userid) {
        window.location.href = '<?= base_url() ?>userEdit/' + userid;
    }

    function hapus(userid) {

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
                    url: "<?= base_url() ?>userHapus/" + userid,
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
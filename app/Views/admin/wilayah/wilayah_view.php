<?= $this->extend('admin/layout/layout'); ?>

<?= $this->section('isi') ?>



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
    integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>


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

        <button type="button" class="btn btn-sm btn-primary" id="tambahWilayah"><i class="fas fa-plus-circle"></i>
            Tambah Wilayah</button>

        <hr>

        <table style="width: 100%;" id="datatabelwilayah"
            class="table table-sm table-bordered table-hover dataTable dtr-inline collapsed responsive">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kelurahan</th>
                    <th>Kecamatan</th>
                    <th>Kota/Kabupaten</th>
                    <th>Propinsi</th>
                    <th>Kodepos</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>

    </div>
</div>


<div class="viewmodal" style="display: none;"></div>

<script>
    function listDataWilayah() {
        var table = $('#datatabelwilayah').dataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?= base_url() ?>listDataWilayah",
                "type": "POST",
            },
            "colomnDefs": [{
                "targets": [0, 6],
                "orderable": false,
            }, ],
        });
    }

    $(document).ready(function() {
        listDataWilayah();
    });


    $(document).ready(function() {

        $('#tambahWilayah').click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: "<?= base_url() ?>wilayahTambah",
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


    function edit(id_wilayah) {
        $.ajax({
            type: "post",
            url: "<?= base_url() ?>wilayahEdit/" + id_wilayah,
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

    function hapus(id_wilayah) {

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
                    url: "<?= base_url() ?>wilayahHapus/" + id_wilayah,
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
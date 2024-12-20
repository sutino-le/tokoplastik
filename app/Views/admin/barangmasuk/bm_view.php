<?= $this->extend('admin/layout/layout'); ?>

<?= $this->section('isi') ?>



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
    integrity="sha512-aVKKRRi/Q/YV+3mjoKBsE3x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
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

        <a href="<?= base_url() ?>barangMasukTambah" type="button" class="btn btn-sm btn-primary"><i class="fas fa-plus-circle"></i>
            Tambah Barang Masuk</a>

        <hr>

        <div class="row m-2">
            <div class="col-12 col-sm-2 col-md-12 col-xl-2 mb-1">
                <label for="">Filter Data</label>
            </div>
            <div class="col-12 col-sm-3 col-md-12 col-xl-3 mb-1">
                <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger"
                    name="idsup" id="idsup">
                    <option value="">Pilih Suplier</option>
                    <option value="">------------</option>
                    <?php foreach ($tampilsuplier as $rowsuplier) : ?>
                        <option value="<?= $rowsuplier['supid'] ?>"><?= $rowsuplier['supnama'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="col-12 col-sm-3 col-md-12 col-xl-3 mb-1">
                <input type="date" name="tglawal" id="tglawal" class="form-control">
            </div>
            <div class="col-12 col-sm-3 col-md-12 col-xl-3 mb-1">
                <input type="date" name="tglakhir" id="tglakhir" class="form-control">
            </div>
            <div class="col-12 col-sm-1 col-md-12 col-xl-1 mb-1">
                <button type="button" class="btn btn-block btn-primary" id="tombolTampil"><i class="fas fa-search"></i></button>
            </div>
        </div>

        <hr>

        <table style="width: 100%;" id="dataBarangMasuk"
            class="table table-sm table-bordered table-hover dataTable dtr-inline collapsed responsive">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Faktur</th>
                    <th>Tanggal</th>
                    <th>Nama Suplier</th>
                    <th>Total Harga</th>
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
    function listDataBarangMasuk() {
        var table = $('#dataBarangMasuk').dataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?= base_url() ?>listDataBarangMasuk",
                "type": "POST",
                "data": {
                    idsup: $('#idsup').val(),
                    tglawal: $('#tglawal').val(),
                    tglakhir: $('#tglakhir').val(),
                }
            },
            columnDefs: [{
                    orderable: false,
                    targets: [0, 5]
                } // Disable sorting untuk kolom ke-0 dan ke-3
            ]
        });
    }

    $(document).ready(function() {
        listDataBarangMasuk();

        $('#tombolTampil').click(function(e) {
            e.preventDefault();
            listDataBarangMasuk();
        });
    });



    function cetak(faktur) {
        let windowCetak = window.open('<?= base_url() ?>cetakfaktur/' + faktur, "Cetak Faktur",
            "width=1300, height=600");

        windowCetak.focus();
    }



    function edit(faktur) {
        window.location.href = ('<?= base_url() ?>barangMasukEdit/') + faktur;
    }



    function hapus(faktur) {
        Swal.fire({
            title: 'Hapus Faktur?',
            text: "Apakah ingin menghapus transaksi !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: "<?= base_url() ?>hapusTransaksiBarangMasuk",
                    data: {
                        faktur: faktur
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) {
                            swal.fire(
                                'Berhasil',
                                response.sukses,
                                'success'
                            ).then((result) => {
                                listDataBarangMasuk();
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
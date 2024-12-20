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

        <div class="row mb-4">
            <div class="col col-4 text-right">
                <label for="">Filter Data :</label>
            </div>
            <div class="col col-3">
                <div class="form-group">
                    <label for="">Nama Kasir</label>
                    <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" name="invuserid" id="invuserid">
                        <option value="">Pilih Kasir</option>
                        <option value="">------------</option>
                        <?php foreach ($dataKasir->getResultArray() as $rowKasir) : ?>
                            <option value="<?= $rowKasir['invuserid'] ?>"><?= $rowKasir['usernama'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            <div class="col col-2">
                <div class="form-group">
                    <label for="">Tanggal Awal</label>
                    <input type="date" name="tglawal" id="tglawal" class="form-control">
                </div>
            </div>
            <div class="col col-2">
                <div class="form-group">
                    <label for="">Tanggal Akhir</label>
                    <input type="date" name="tglakhir" id="tglakhir" class="form-control">
                </div>
            </div>
            <div class="col col-1">
                <div class="form-group">
                    <label for="">#</label>
                    <br>
                    <button type="button" class="btn btn-success" id="tombolTampil" title="Tampilkan"><i class="fas fa-search"></i></button>
                    <!-- <button type="button" class="btn btn-secondary" id="tombolDownload" title="Download"><i class="	fas fa-cloud-download-alt"></i></button> -->
                </div>
            </div>
        </div>

        <table style="width: 100%;" id="dataBarangKeluar" class="table table-sm table-bordered table-hover dataTable dtr-inline collapsed">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Tanggal Masuk</th>
                    <th>Jumlah</th>
                    <th>TotalHarga</th>
                    <th>Nama Suplier</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>


    </div>
</div>


<div class="viewmodal" style="display: none;"></div>

<script>
    function listDataBarangKeluar() {
        var table = $('#dataBarangKeluar').dataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?= base_url() ?>detailListDataBarangKeluar",
                "type": "POST",
                "data": {
                    invuserid: $('#invuserid').val(),
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

    function downloadDataDetailBarangMasuk() {
        $.ajax({
            type: "post",
            url: "<?= base_url() ?>downloadDetailListDataBarangKeluar",
            data: {
                invuserid: $('#invuserid').val(),
                tglawal: $('#tglawal').val(),
                tglakhir: $('#tglakhir').val(),
            },
            dataType: "json",
            success: function(response) {

            }
        });
    }

    $(document).ready(function() {
        listDataBarangKeluar();

        $('#tombolTampil').click(function(e) {
            e.preventDefault();
            listDataBarangKeluar();
        });

        $('#tombolDownload').click(function(e) {
            e.preventDefault();
            downloadDataDetailBarangMasuk();
        });
    });
</script>


<?= $this->endSection('isi') ?>
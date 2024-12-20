<?=$this->extend('admin/layout/layout');?>

<?=$this->section('isi')?>



<div class="card">
    <div class="card-header bg-primary">
        <h3 class="card-title"><b><?=$title?></b></h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">



        <div class="row mb-4">
            <div class="col col-6">
                <div class="form-group">
                    <button type="button" class="btn btn-success" id="tombolDownload" title="Download"><i class="fas fa-print"></i> Lihat Laporan</button>
                </div>
            </div>
        </div>


        <table style="width: 100%;" id="dataBarangKeluar" class="table table-sm table-bordered table-hover dataTable dtr-inline collapsed">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Tanggal</th>
                    <th>Modal</th>
                    <th>Harga Jual</th>
                    <th>Jumlah</th>
                    <th>Diskon</th>
                    <th>TotalHarga</th>
                    <th>Kasir</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>


    </div>
</div>

<input type="hidden" name="invuserid" id="invuserid" value="<?=session()->userid?>">
<input type="hidden" name="tglawal" id="tglawal" value="<?=date('Y-m-d')?>">
<input type="hidden" name="tglakhir" id="tglakhir" value="<?=date('Y-m-d')?>">


<div class="viewmodal" style="display: none;"></div>


<script src="<?=base_url('assets/dist/js/autoNumeric.js')?>"></script>
<script>
    function laporanDataBarangKeluar() {
        var table = $('#dataBarangKeluar').dataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?=base_url()?>detailLaporanDataBarangKeluar",
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

    function downloadLaporanDataBarangKeluar() {

        let invuserid = $('#invuserid').val();
        let tglawal = $('#tglawal').val();
        let tglakhir = $('#tglakhir').val();


        // Construct the URL for the download
        let windowCetak = window.open('<?=base_url()?>downloadLaporanDataBarangKeluar/' + invuserid, "Cetak Laporan",
            "width=1300, height=600");

        // Open the URL in a new tab
        windowCetak.focus();
    }



    $(document).ready(function() {
        laporanDataBarangKeluar();

        $('#tombolTampil').click(function(e) {
            e.preventDefault();
            laporanDataBarangKeluar();
        });

        $('#tombolDownload').click(function(e) {
            e.preventDefault();
            downloadLaporanDataBarangKeluar();
        });
    });
</script>



<?=$this->endSection('isi')?>
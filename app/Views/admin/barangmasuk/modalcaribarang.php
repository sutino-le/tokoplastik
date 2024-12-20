<!-- Modal -->
<div class="modal fade" id="modalcaribarang" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Data Cari Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <table style="width: 100%;" id="databarang"
                    class="table table-sm table-bordered table-hover dataTable dtr-inline collapsed responsive">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    function listDataBarang() {
        var table = $('#databarang').dataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?= base_url() ?>listCariDataBarang",
                "type": "POST",
            },
            columnDefs: [{
                    orderable: false,
                    targets: [0, 4]
                } // Disable sorting untuk kolom ke-0 dan ke-3
            ]
        });
    }

    function pilih(id) {
        $('#kodebarang').val(id);
        $('#modalcaribarang').on('hidden.bs.modal', function(event) {
            ambilDataBarang();
        });

        $('#modalcaribarang').modal('hide');
    }

    $(document).ready(function() {
        listDataBarang();
    });
</script>
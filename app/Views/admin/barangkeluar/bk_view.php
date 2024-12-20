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

        <a href="<?= base_url() ?>barangKeluarTambah" type="button" class="btn btn-sm btn-primary"><i class="fas fa-plus-circle"></i>
            Tambah Barang Keluar</a>

        <hr>

        <div class="row mb-2">
            <div class="col">
                <label for="">Filter Data</label>
            </div>
            <div class="col">
                <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger"
                    name="userid" id="userid">
                    <option value="">Pilih Kasir</option>
                    <option value="">------------</option>
                    <?php foreach ($tampilUser as $rowsUser) : ?>
                        <option value="<?= $rowsUser['userid'] ?>"><?= $rowsUser['usernama'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="col">
                <input type="date" name="tglawal" id="tglawal" class="form-control">
            </div>
            <div class="col">
                <input type="date" name="tglakhir" id="tglakhir" class="form-control">
            </div>
            <div class="col">
                <button type="button" class="btn btn-block btn-primary" id="tombolTampil">Tampilkan</button>
            </div>
        </div>

        <hr>

        <table style="width: 100%;" id="dataBarangKeluar"
            class="table table-sm table-bordered table-hover dataTable dtr-inline collapsed responsive">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Invoice</th>
                    <th>Tanggal</th>
                    <th>Nama Kasir</th>
                    <th>Total</th>
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
    function listDataBarangKeluar() {
        var table = $('#dataBarangKeluar').dataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?= base_url() ?>listDataBarangKeluar",
                "type": "POST",
                "data": {
                    idsup: $('#userid').val(),
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
        listDataBarangKeluar();

        $('#tombolTampil').click(function(e) {
            e.preventDefault();
            listDataBarangKeluar();
        });
    });



    function cetak(invoice) {
        let windowCetak = window.open('<?= base_url() ?>cetakinvoice/' + invoice, "Cetak Invoice",
            "width=1300, height=600");

        windowCetak.focus();
    }



    function edit(invoice) {
        window.location.href = ('<?= base_url() ?>barangKeluarEdit/') + invoice;
    }



    function hapus(invoice) {
        Swal.fire({
            title: 'Hapus Invoice?',
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
                    url: "<?= base_url() ?>hapusTransaksiBarangKeluar",
                    data: {
                        invoice: invoice
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) {
                            swal.fire(
                                'Berhasil',
                                response.sukses,
                                'success'
                            ).then((result) => {
                                listDataBarangKeluar();
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
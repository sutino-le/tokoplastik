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

        <form action="<?= base_url() ?>barangTambahSimpan" class="formsimpan">
            <?= csrf_field(); ?>

            <div class="row">
                <div class="col-12 col-sm-6 col-md-12 col-xl-6">
                    <div class="form-group">
                        <label for="">Barcode</label>
                        <input type="number" name="brgbarcode" id="brgbarcode" class="form-control" minlength="13" maxlength="13" placeholder="Masukan Barcode..." autocomplete="off">
                        <div class="invalid-feedback errorBarangBarcode"></div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-12 col-xl-6">
                    <div class="form-group">
                        <label for="">Nama Barang</label>
                        <input type="text" name="brgnama" id="brgnama" class="form-control" placeholder="Masukan Nama Barang..." autocomplete="off">
                        <div class="invalid-feedback errorBarangNama"></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-sm-6 col-md-12 col-xl-6">
                    <div class="form-group">
                        <label for="">Kategori</label>
                        <div class="input-group">
                            <select class="custom-select" name="brgkatid" id="brgkatid" aria-label="Example select with button addon">
                                <option value="" selected>-- Pilih Kategori --</option>
                                <option value="">-------------</option>
                                <?php foreach ($tampilKategori as $rowKat): ?>
                                    <option value="<?= $rowKat['katid'] ?>"><?= $rowKat['katnama'] ?></option>
                                <?php endforeach ?>
                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-outline-success" id="tambahKategori" type="button" title="Tambah Kategori"><i class="fas fa-plus"></i></button>
                            </div>
                            <div class="invalid-feedback errorBarangKategori"></div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-12 col-xl-6">
                    <div class="form-group">
                        <label for="">Satuan</label>
                        <div class="input-group">
                            <select class="custom-select" name="brgsatid" id="brgsatid" aria-label="Example select with button addon">
                                <option value="" selected>-- Pilih Satuan --</option>
                                <option value="">-------------</option>
                                <?php foreach ($tampilSatuan as $rowSat): ?>
                                    <option value="<?= $rowSat['satid'] ?>"><?= $rowSat['satnama'] ?></option>
                                <?php endforeach ?>
                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-outline-success" id="tambahSatuan" type="button" title="Tambah Satuan"><i class="fas fa-plus"></i></button>
                            </div>
                            <div class="invalid-feedback errorBarangSatuan"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-sm-6 col-md-12 col-xl-6">
                    <div class="form-group">
                        <label for="">Isi Satuan</label>
                        <input type="text" name="brgsatisi" id="brgsatisi" class="form-control" placeholder="Masukan Isi Satuan..." autocomplete="off">
                        <div class="invalid-feedback errorBarangSatuanIsi"></div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-12 col-xl-6">
                    <div class="form-group">
                        <label for="">Harga Satuan</label>
                        <input type="text" name="brgharga" id="brgharga" class="form-control" placeholder="Masukan Harga Satuan..." autocomplete="off">
                        <div class="invalid-feedback errorBarangHarga"></div>
                    </div>
                </div>
            </div>

            <hr style="border: 1px solid blue;">

            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-xl-12">
                    <label for="">Tambah Harga untuk menambahakan lebih dari 1 harga atau harga Grosir.</label>

                    <button type="button" class="btn btn-outline-success addRow" title="Tambah Harga Tambahan"><i class="fas fa-plus"></i> Tambah Harga Grosir</button>
                </div>
            </div>


            <hr style="border: 0px solid secondary;">

            <!-- Container untuk Harga Tambahan -->

            <div id="bth_hargaContainer">
                <div class="row mb-2 bth_hargaRow">

                </div>
            </div>


            <hr style="border: 1px solid blue;">


            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-xl-12">
                    <button type="submit" class="btn btn-sm btn-success" id="tombolsimpan">Simpan</button>
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" id="batal">Batal</button>
                </div>
            </div>



        </form>


    </div>

</div>


<div class="viewmodal" style="display: none;"></div>


<script src="<?= base_url('assets/dist/js/autoNumeric.js') ?>"></script>

<!-- Summernote -->
<script src="<?= base_url('assets/plugins/summernote/summernote-bs4.min.js') ?>"></script>

<script>
    // Event listener untuk tombol tambah baris harga tambahan
    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('addRow')) {
            e.preventDefault();

            // Buat elemen baris baru
            const newRow = document.createElement('div');
            newRow.classList.add('row', 'mb-2', 'bth_hargaRow');

            newRow.innerHTML = `
                    <div class="col-12 col-sm-2 col-md-12 col-xl-2">
                        <label for="">Satuan</label>
                        <select class="form-control" name="bth_satuan[]" id="bth_satuan">
                            <option value="" selected>-- Pilih Satuan --</option>
                            <option value="">-------------</option>
                            <?php foreach ($tampilSatuan as $rowSat): ?>
                                <option value="<?= $rowSat['satid'] ?>"><?= $rowSat['satnama'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="col-12 col-sm-2 col-md-12 col-xl-2">
                    <label for="">Min</label>
                        <input type="text" name="bth_isi_min[]" id="bth_isi_min" class="form-control" placeholder="Isi Min" autocomplete="off">
                    </div>
                    <div class="col-12 col-sm-2 col-md-12 col-xl-2">
                    <label for="">Max</label>
                        <input type="text" name="bth_isi_max[]" id="bth_isi_max" class="form-control" placeholder="Isi Max" autocomplete="off">
                    </div>
                    <div class="col-12 col-sm-2 col-md-12 col-xl-2">
                    <label for="">Konversi</label>
                        <input type="text" name="bth_konversi_isi_min[]" id="bth_konversi_isi_min" class="form-control" placeholder="Konversi" autocomplete="off">
                    </div>
                    <div class="col-12 col-sm-2 col-md-12 col-xl-2">
                    <label for="">Harga</label>
                        <input type="text" name="bth_harga[]" id="bth_harga" class="form-control" placeholder="Harga" autocomplete="off">
                    </div>
                    <div class="col-12 col-sm-2 col-md-12 col-xl-2">
                    <label for="">#</label>
                    <br>
                        <button type="button" class="btn btn-outline-danger removeRow" title="Hapus Harga Tambahan"><i class="fas fa-minus"></i></button>
                    </div>
            `;

            // Tambahkan baris baru ke dalam container
            document.getElementById('bth_hargaContainer').appendChild(newRow);
        }

        // Event listener untuk tombol hapus baris
        if (e.target && e.target.classList.contains('removeRow')) {
            e.preventDefault();
            e.target.closest('.bth_hargaRow').remove();
        }
    });




    $(document).ready(function() {


        // autonumerik brgharga
        $('#brgharga').autoNumeric('init', {
            mDec: 2,
            aDec: ',',
            aSep: '.',
        })
        $('#brgharga').keyup(function(e) {
            let brgharga = $('#brgharga').autoNumeric('get');

        });

        $('.formsimpan').submit(function(e) {
            e.preventDefault();

            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                success: function(response) {
                    if (response.error) {
                        let err = response.error;

                        if (err.errBarangBarcode) {
                            $('#brgbarcode').addClass('is-invalid');
                            $('.errorBarangBarcode').html(err.errBarangBarcode);
                        } else {
                            $('#brgbarcode').removeClass('is-invalid');
                            $('#brgbarcode').addClass('is-valid');
                        }

                        if (err.errBarangNama) {
                            $('#brgnama').addClass('is-invalid');
                            $('.errorBarangNama').html(err.errBarangNama);
                        } else {
                            $('#brgnama').removeClass('is-invalid');
                            $('#brgnama').addClass('is-valid');
                        }

                        if (err.errBarangKategori) {
                            $('#brgkatid').addClass('is-invalid');
                            $('.errorBarangKategori').html(err.errBarangKategori);
                        } else {
                            $('#brgkatid').removeClass('is-invalid');
                            $('#brgkatid').addClass('is-valid');
                        }

                        if (err.errBarangSatuan) {
                            $('#brgsatid').addClass('is-invalid');
                            $('.errorBarangSatuan').html(err.errBarangSatuan);
                        } else {
                            $('#brgsatid').removeClass('is-invalid');
                            $('#brgsatid').addClass('is-valid');
                        }

                        if (err.errBarangSatuanIsi) {
                            $('#brgsatisi').addClass('is-invalid');
                            $('.errorBarangSatuanIsi').html(err.errBarangSatuanIsi);
                        } else {
                            $('#brgsatisi').removeClass('is-invalid');
                            $('#brgsatisi').addClass('is-valid');
                        }

                        if (err.errBarangHarga) {
                            $('#brgharga').addClass('is-invalid');
                            $('.errorBarangHarga').html(err.errBarangHarga);
                        } else {
                            $('#brgharga').removeClass('is-invalid');
                            $('#brgharga').addClass('is-valid');
                        }
                    }

                    if (response.sukses) {
                        Swal.fire({
                            title: 'Berhasil',
                            text: response.sukses +
                                ", Apakah ingin menambah Barang ?",
                            icon: 'success',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ya',
                            cancelButtonText: 'Tidak'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '<?= base_url() ?>barangTambah';
                            } else {
                                window.location.href = '<?= base_url() ?>barang';
                            }
                        })
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });

            return false;
        });



        $('#batal').click(function(e) {
            e.preventDefault();
            window.location.href = '<?= base_url() ?>barang';
        });

    });


    $(document).ready(function() {

        $('#tambahKategori').click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: "<?= base_url() ?>kategoriTambah",
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

    $(document).ready(function() {

        $('#tambahSatuan').click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: "<?= base_url() ?>satuanTambah",
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
</script>


<?= $this->endSection('isi') ?>
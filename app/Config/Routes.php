<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Auth
$routes->get('/auth', 'AdminAuth::index');
$routes->post('/cekUser', 'AdminAuth::cekUser');
$routes->get('/logout', 'AdminAuth::logout');

// Main
$routes->get('/main', 'AdminMain::index');

// backup
$routes->get('/backup', 'Backup::index');

// wilayah
$routes->get('/wilayah', 'AdminWilayah::index');
$routes->post('/listDataWilayah', 'AdminWilayah::listDataWilayah');
$routes->post('/wilayahTambah', 'AdminWilayah::wilayahTambah');
$routes->post('/wilayahTambahSimpan', 'AdminWilayah::wilayahTambahSimpan');
$routes->post('/wilayahEdit/(:any)', 'AdminWilayah::wilayahEdit/$1');
$routes->post('/wilayahEditSimpan', 'AdminWilayah::wilayahEditSimpan');
$routes->get('/wilayahHapus/(:any)', 'AdminWilayah::wilayahHapus/$1');

// level
$routes->get('/level', 'AdminLevel::index');
$routes->post('/levelTambah', 'AdminLevel::levelTambah');
$routes->post('/levelTambahSimpan', 'AdminLevel::levelTambahSimpan');
$routes->post('/levelEdit/(:any)', 'AdminLevel::levelEdit/$1');
$routes->post('/levelEditSimpan', 'AdminLevel::levelEditSimpan');
$routes->get('/levelHapus/(:any)', 'AdminLevel::levelHapus/$1');

// user
$routes->get('/user', 'AdminUser::index');
$routes->get('/userTambah', 'AdminUser::userTambah');
$routes->post('/userTambahSimpan', 'AdminUser::userTambahSimpan');
$routes->get('/userEdit/(:any)', 'AdminUser::userEdit/$1');
$routes->post('/userEditSimpan', 'AdminUser::userEditSimpan');
$routes->get('/userHapus/(:any)', 'AdminUser::userHapus/$1');
$routes->post('/wilayahCari', 'AdminUser::wilayahCari');
$routes->post('/listModalWilayah', 'AdminUser::listModalWilayah');

$routes->get('/userEditProfil/(:any)', 'AdminUser::userEditProfil/$1');
$routes->post('/userEditProfilSimpan', 'AdminUser::userEditProfilSimpan');

// cabang
$routes->get('/cabang', 'AdminCabang::index');
$routes->post('/listDataCabang', 'AdminCabang::listDataCabang');
$routes->get('/cabangTambah', 'AdminCabang::cabangTambah');
$routes->post('/cabangTambahSimpan', 'AdminCabang::cabangTambahSimpan');
$routes->get('/cabangEdit/(:any)', 'AdminCabang::cabangEdit/$1');
$routes->post('/cabangEditSimpan', 'AdminCabang::cabangEditSimpan');
$routes->get('/cabangHapus/(:any)', 'AdminCabang::cabangHapus/$1');

// suplier
$routes->get('/suplier', 'AdminSuplier::index');
$routes->post('/suplierTambah', 'AdminSuplier::suplierTambah');
$routes->post('/suplierTambahSimpan', 'AdminSuplier::suplierTambahSimpan');
$routes->post('/suplierHapus', 'AdminSuplier::suplierHapus');

// kategori
$routes->get('/kategori', 'AdminKategori::index');
$routes->post('/listDataKategori', 'AdminKategori::listDataKategori');
$routes->post('/kategoriTambah', 'AdminKategori::kategoriTambah');
$routes->post('/kategoriTambahSimpan', 'AdminKategori::kategoriTambahSimpan');
$routes->post('/kategoriEdit/(:any)', 'AdminKategori::kategoriEdit/$1');
$routes->post('/kategoriEditSimpan', 'AdminKategori::kategoriEditSimpan');
$routes->get('/kategoriHapus/(:any)', 'AdminKategori::kategoriHapus/$1');

// satuan
$routes->get('/satuan', 'AdminSatuan::index');
$routes->post('/listDataSatuan', 'AdminSatuan::listDataSatuan');
$routes->post('/satuanTambah', 'AdminSatuan::satuanTambah');
$routes->post('/satuanTambahSimpan', 'AdminSatuan::satuanTambahSimpan');
$routes->post('/satuanEdit/(:any)', 'AdminSatuan::satuanEdit/$1');
$routes->post('/satuanEditSimpan', 'AdminSatuan::satuanEditSimpan');
$routes->get('/satuanHapus/(:any)', 'AdminSatuan::satuanHapus/$1');

// barang
$routes->get('/barang', 'AdminBarang::index');
$routes->post('/listDataBarang', 'AdminBarang::listDatabarang');
$routes->get('/barangTambah', 'AdminBarang::barangTambah');
$routes->post('/barangTambahSimpan', 'AdminBarang::barangTambahSimpan');
$routes->post('/barangEdit/(:any)', 'AdminBarang::barangEdit/$1');
$routes->post('/barangEditSimpan', 'AdminBarang::barangEditSimpan');
$routes->get('/barangHapus/(:any)', 'AdminBarang::barangHapus/$1');
$routes->get('/barangDetail/(:any)', 'AdminBarang::barangDetail/$1');
$routes->post('/hargaTambahSimpan', 'AdminBarang::hargaTambahSimpan');
$routes->post('/editHargaTambahan/(:any)', 'AdminBarang::editHargaTambahan/$1');
$routes->post('/editHargaTambahanSimpan', 'AdminBarang::editHargaTambahanSimpan');
$routes->get('/hargaTambahHapus/(:any)', 'AdminBarang::hargaTambahHapus/$1');

// barangmasuk
$routes->get('/barangmasuk', 'AdminBarangMasuk::index');
$routes->post('/listDataBarangMasuk', 'AdminBarangMasuk::listDataBarangMasuk');

$routes->post('/buatNoFakturBarangMasuk', 'AdminBarangMasuk::buatNoFakturBarangMasuk');
$routes->get('/barangMasukTambah', 'AdminBarangMasuk::barangMasukTambah');

$routes->get('/modalCariDataSuplier', 'AdminBarangMasuk::modalCariDataSuplier');
$routes->post('/listCariDataSuplier', 'AdminBarangMasuk::listCariDataSuplier');

$routes->get('/modalCariBarang', 'AdminBarangMasuk::modalCariBarang');
$routes->post('/listCariDataBarang', 'AdminBarangMasuk::listCariDataBarang');
$routes->post('/ambilDataBarang', 'AdminBarangMasuk::ambilDataBarang');

$routes->post('/simpanItemBarangMasuk', 'AdminBarangMasuk::simpanItemBarangMasuk');

$routes->post('/tampilDataTempBarangMasuk', 'AdminBarangMasuk::tampilDataTempBarangMasuk');
$routes->get('/modalEditItemBarangMasuk/(:any)', 'AdminBarangMasuk::modalEditItemBarangMasuk/$1');
$routes->post('/modalEditItemBarangMasukSimpan', 'AdminBarangMasuk::modalEditItemBarangMasukSimpan');
$routes->post('/hapusItemBarangMasukTemp', 'AdminBarangMasuk::hapusItemBarangMasukTemp');

$routes->post('/modalPembayaranBarangMasuk', 'AdminBarangMasuk::modalPembayaranBarangMasuk');
$routes->post('/modalPembayaranBarangMasukSimpan', 'AdminBarangMasuk::modalPembayaranBarangMasukSimpan');

$routes->get('/cetakfaktur/(:any)', 'AdminBarangMasuk::cetakfaktur/$1');

$routes->post('/hapusTransaksiBarangMasuk', 'AdminBarangMasuk::hapusTransaksiBarangMasuk');

$routes->get('/barangMasukEdit/(:any)', 'AdminBarangMasuk::barangMasukEdit/$1');
$routes->post('/ambilTotalHargaBarangMasuk', 'AdminBarangMasuk::ambilTotalHargaBarangMasuk');
$routes->post('/tampilDataDetailBarangMasuk', 'AdminBarangMasuk::tampilDataDetailBarangMasuk');
$routes->post('/hapusItemDetailBarangMasuk', 'AdminBarangMasuk::hapusItemDetailBarangMasuk');
$routes->post('/editItemBarangMasuk', 'AdminBarangMasuk::editItemBarangMasuk');
$routes->post('/simpanDetailBarangMasuk', 'AdminBarangMasuk::simpanDetailBarangMasuk');

// detail barangmasuk
$routes->get('/databarangmasuk', 'AdminBarangMasuk::databarangmasuk');
$routes->post('/detailListDataBarangMasuk', 'AdminBarangMasuk::detailListDataBarangMasuk');
$routes->post('/downloadDetailListDataBarangMasuk', 'AdminBarangMasuk::downloadDetailListDataBarangMasuk');

// barangkeluar
$routes->get('/barangkeluar', 'AdminBarangKeluar::index');
$routes->post('/listDataBarangKeluar', 'AdminBarangKeluar::listDataBarangKeluar');

$routes->get('/barangKeluarTambah', 'AdminBarangKeluar::barangKeluarTambah');
$routes->post('/buatNoInvoiceBarangKeluar', 'AdminBarangKeluar::buatNoInvoiceBarangKeluar');

$routes->get('/modalCariBarangJual', 'AdminBarangKeluar::modalCariBarangJual');
$routes->post('/listCariDataBarangJual', 'AdminBarangKeluar::listCariDataBarangJual');
$routes->post('/ambilDataBarangJual', 'AdminBarangKeluar::ambilDataBarangJual');

$routes->post('/tampilDataTempBarangKeluar', 'AdminBarangKeluar::tampilDataTempBarangKeluar');
$routes->post('/hapusItemBarangKeluarTemp', 'AdminBarangKeluar::hapusItemBarangKeluarTemp');
$routes->get('/modalEditItemBarangKeluar/(:any)', 'AdminBarangKeluar::modalEditItemBarangKeluar/$1');
$routes->post('/modalEditItemBarangKeluarSimpan', 'AdminBarangKeluar::modalEditItemBarangKeluarSimpan');

$routes->post('/simpanItemBarangKeluar', 'AdminBarangKeluar::simpanItemBarangKeluar');
$routes->post('/ambilTotalHargaBarangKeluarTemp', 'AdminBarangKeluar::ambilTotalHargaBarangKeluarTemp');

$routes->post('/modalPembayaranBarangKeluar', 'AdminBarangKeluar::modalPembayaranBarangKeluar');
$routes->post('/modalPembayaranBarangKeluarSimpan', 'AdminBarangKeluar::modalPembayaranBarangKeluarSimpan');

$routes->get('/cetakinvoice/(:any)', 'AdminBarangKeluar::cetakinvoice/$1');

$routes->get('/barangKeluarEdit/(:any)', 'AdminBarangKeluar::barangKeluarEdit/$1');
$routes->post('/ambilTotalHargaBarangKeluar', 'AdminBarangKeluar::ambilTotalHargaBarangKeluar');
$routes->post('/tampilDataDetailBarangKeluar', 'AdminBarangKeluar::tampilDataDetailBarangKeluar');
$routes->post('/hapusItemBarangKeluarDet', 'AdminBarangKeluar::hapusItemBarangKeluarDet');
$routes->get('/modalEditItemBarangKeluarDetail/(:any)', 'AdminBarangKeluar::modalEditItemBarangKeluarDetail/$1');
$routes->post('/modalEditItemBarangKeluarDetailSimpan', 'AdminBarangKeluar::modalEditItemBarangKeluarDetailSimpan');

$routes->post('/simpanItemBarangKeluarDetail', 'AdminBarangKeluar::simpanItemBarangKeluarDetail');

$routes->post('/hapusTransaksiBarangKeluar', 'AdminBarangKeluar::hapusTransaksiBarangKeluar');

$routes->get('/databarangkeluar', 'AdminBarangKeluar::databarangkeluar');
$routes->post('/detailListDataBarangKeluar', 'AdminBarangKeluar::detailListDataBarangKeluar');
$routes->post('/downloadDetailListDataBarangKeluar', 'AdminBarangKeluar::downloadDetailListDataBarangKeluar');

// stockbarang
$routes->get('/stockbarang', 'AdminStock::index');
$routes->post('/listDataStockBarang', 'AdminStock::listDataStockBarang');

// kasir
$routes->get('/laporanKasir', 'AdminBarangKeluar::laporanKasir');
$routes->post('/detailLaporanDataBarangKeluar', 'AdminBarangKeluar::detailLaporanDataBarangKeluar');
$routes->get('/downloadLaporanDataBarangKeluar/(:any)', 'AdminBarangKeluar::downloadLaporanDataBarangKeluar/$1');

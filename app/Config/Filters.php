<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseConfig
{
    /**
     * Configures aliases for Filter classes to
     * make reading things nicer and simpler.
     *
     * @var array<string, class-string|list<class-string>> [filter_name => classname]
     *                                                     or [filter_name => [classname1, classname2, ...]]
     */
    public array $aliases = [
        'csrf' => CSRF::class,
        'toolbar' => DebugToolbar::class,
        'honeypot' => Honeypot::class,
        'invalidchars' => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'filterAdmin' => \App\Filters\FilterAdmin::class,
        'filterKasir' => \App\Filters\FilterKasir::class,
    ];

    /**
     * List of filter aliases that are always
     * applied before and after every request.
     *
     * @var array<string, array<string, array<string, string>>>|array<string, list<string>>
     */
    public array $globals = [
        'before' => [
            // 'honeypot',
            // 'csrf',
            // 'invalidchars',
            'filterAdmin' => [
                'except' => [
                    '/',
                    '/auth',
                    '/cekUser',
                    '/logout',
                ],
            ],
            'filterKasir' => [
                'except' => [
                    '/',
                    '/auth',
                    '/cekUser',
                    '/logout',
                ],
            ],
        ],
        'after' => [
            'toolbar',
            // 'honeypot',
            // 'secureheaders',
            'filterAdmin' => [
                'except' => [
                    '/',
                    '/auth',
                    '/cekUser',
                    '/logout',
                    '/main',
                    '/backup',

                    // wilayah
                    '/wilayah',
                    '/listDataWilayah',
                    '/wilayahTambah',
                    '/wilayahTambahSimpan',
                    '/wilayahEdit/*',
                    '/wilayahEditSimpan',
                    '/wilayahHapus/*',

                    // Level
                    '/level',
                    '/levelTambah',
                    '/levelTambahSimpan',
                    '/levelEdit/*',
                    '/levelEditSimpan',
                    '/levelHapus/*',

                    // User
                    '/user',
                    '/userTambah',
                    '/userTambahSimpan',
                    '/userEdit/*',
                    '/userEditSimpan',
                    '/userHapus/*',
                    '/wilayahCari',
                    '/listModalWilayah',

                    '/userEditProfil/*',
                    '/userEditProfilSimpan',

                    // cabang
                    '/cabang',
                    '/listDataCabang',
                    '/cabangTambah',
                    '/cabangTambahSimpan',
                    '/cabangEdit/*',
                    '/cabangEditSimpan',
                    '/cabangHapus/*',

                    // suplier
                    '/suplier',
                    '/suplierTambah',
                    '/suplierTambahSimpan',
                    '/suplierHapus',

                    // Kategori
                    '/kategori',
                    '/listDataKategori',
                    '/kategoriTambah',
                    '/kategoriTambahSimpan',
                    '/kategoriEdit/*',
                    '/kategoriEditSimpan',
                    '/kategoriHapus/*',

                    // satuan
                    '/satuan',
                    '/listDataSatuan',
                    '/satuanTambah',
                    '/satuanTambahSimpan',
                    '/satuanEdit/*',
                    '/satuanEditSimpan',
                    '/satuanHapus/*',

                    // barang
                    '/barang',
                    '/listDataBarang',
                    '/barangTambah',
                    '/barangTambahSimpan',
                    '/barangEdit/*',
                    '/barangEditSimpan',
                    '/barangHapus/*',
                    '/barangDetail/*',
                    '/hargaTambahSimpan',
                    '/editHargaTambahan/*',
                    '/editHargaTambahanSimpan',
                    '/hargaTambahHapus/*',

                    // barangmasuk
                    '/barangmasuk',
                    '/listDataBarangMasuk',

                    '/buatFakturBarangMasuk',
                    '/buatNoFakturBarangMasuk',
                    '/barangMasukTambah',

                    '/modalCariDataSuplier',
                    '/listCariDataSuplier',

                    '/modalCariBarang',
                    '/listCariDataBarang',
                    '/ambilDataBarang',

                    '/simpanItemBarangMasuk',

                    '/tampilDataTempBarangMasuk',
                    '/modalEditItemBarangMasuk/*',
                    '/modalEditItemBarangMasukSimpan',
                    '/hapusItemBarangMasukTemp',

                    '/modalPembayaranBarangMasuk',
                    '/modalPembayaranBarangMasukSimpan',

                    '/cetakfaktur/*',

                    '/hapusTransaksiBarangMasuk',

                    '/barangMasukEdit/*',
                    '/ambilTotalHargaBarangMasuk',
                    '/tampilDataDetailBarangMasuk',
                    '/hapusItemDetailBarangMasuk',
                    '/editItemBarangMasuk',
                    '/simpanDetailBarangMasuk',

                    // detail barangmasuk
                    '/databarangmasuk',
                    '/detailListDataBarangMasuk',
                    '/downloadDetailListDataBarangMasuk',

                    // barangkeluar
                    '/barangkeluar',
                    '/listDataBarangKeluar',

                    '/barangKeluarTambah',
                    '/buatInvoiceBarangKeluar',
                    '/buatNoInvoiceBarangKeluar',

                    '/modalCariBarangJual',
                    '/listCariDataBarangJual',
                    '/ambilDataBarangJual',

                    '/tampilDataTempBarangKeluar',
                    '/hapusItemBarangKeluarTemp',
                    '/modalEditItemBarangKeluar/*',
                    '/modalEditItemBarangKeluarSimpan',

                    '/simpanItemBarangKeluar',
                    '/ambilTotalHargaBarangKeluarTemp',

                    '/modalPembayaranBarangKeluar',
                    '/modalPembayaranBarangKeluarSimpan',

                    '/cetakinvoice/*',

                    '/barangKeluarEdit/*',
                    '/ambilTotalHargaBarangKeluar',
                    '/tampilDataDetailBarangKeluar',
                    '/hapusItemBarangKeluarDet',
                    '/modalEditItemBarangKeluarDetail/*',
                    '/modalEditItemBarangKeluarDetailSimpan',

                    '/simpanItemBarangKeluarDetail',

                    '/hapusTransaksiBarangKeluar',

                    '/databarangkeluar',
                    '/detailListDataBarangKeluar',
                    '/downloadDetailListDataBarangKeluar',

                    // stockbarang
                    '/stockbarang',
                    '/listDataStockBarang',

                    // kasir
                    '/laporanKasir',
                    '/detailLaporanDataBarangKeluar',
                    '/downloadLaporanDataBarangKeluar/*',
                ],
            ],
            'filterKasir' => [
                'except' => [
                    '/',
                    '/auth',
                    '/cekUser',
                    '/logout',
                    '/main',
                    '/backup',

                    // wilayah
                    '/wilayah',
                    '/listDataWilayah',
                    '/wilayahTambah',
                    '/wilayahTambahSimpan',
                    '/wilayahEdit/*',
                    '/wilayahEditSimpan',
                    '/wilayahHapus/*',

                    // Level
                    '/level',
                    '/levelTambah',
                    '/levelTambahSimpan',
                    '/levelEdit/*',
                    '/levelEditSimpan',
                    '/levelHapus/*',

                    // User
                    '/user',
                    '/userTambah',
                    '/userTambahSimpan',
                    '/userEdit/*',
                    '/userEditSimpan',
                    '/userHapus/*',
                    '/wilayahCari',
                    '/listModalWilayah',

                    '/userEditProfil/*',
                    '/userEditProfilSimpan',

                    // cabang
                    '/cabang',
                    '/listDataCabang',
                    '/cabangTambah',
                    '/cabangTambahSimpan',
                    '/cabangEdit/*',
                    '/cabangEditSimpan',
                    '/cabangHapus/*',

                    // suplier
                    '/suplier',
                    '/suplierTambah',
                    '/suplierTambahSimpan',
                    '/suplierHapus',

                    // Kategori
                    '/kategori',
                    '/listDataKategori',
                    '/kategoriTambah',
                    '/kategoriTambahSimpan',
                    '/kategoriEdit/*',
                    '/kategoriEditSimpan',
                    '/kategoriHapus/*',

                    // satuan
                    '/satuan',
                    '/listDataSatuan',
                    '/satuanTambah',
                    '/satuanTambahSimpan',
                    '/satuanEdit/*',
                    '/satuanEditSimpan',
                    '/satuanHapus/*',

                    // barang
                    '/barang',
                    '/listDataBarang',
                    // '/barangTambah',
                    '/barangTambahSimpan',
                    '/barangEdit/*',
                    '/barangEditSimpan',
                    '/barangHapus/*',
                    '/barangDetail/*',
                    '/hargaTambahSimpan',
                    '/editHargaTambahan/*',
                    '/editHargaTambahanSimpan',
                    '/hargaTambahHapus/*',

                    // barangmasuk
                    '/barangmasuk',
                    '/listDataBarangMasuk',

                    '/buatFakturBarangMasuk',
                    '/buatNoFakturBarangMasuk',
                    // '/barangMasukTambah',

                    '/modalCariDataSuplier',
                    '/listCariDataSuplier',

                    '/modalCariBarang',
                    '/listCariDataBarang',
                    '/ambilDataBarang',

                    '/simpanItemBarangMasuk',

                    '/tampilDataTempBarangMasuk',
                    '/modalEditItemBarangMasuk/*',
                    '/modalEditItemBarangMasukSimpan',
                    '/hapusItemBarangMasukTemp',

                    '/modalPembayaranBarangMasuk',
                    '/modalPembayaranBarangMasukSimpan',

                    '/cetakfaktur/*',

                    // '/hapusTransaksiBarangMasuk',

                    // '/barangMasukEdit/*',
                    '/ambilTotalHargaBarangMasuk',
                    '/tampilDataDetailBarangMasuk',
                    '/hapusItemDetailBarangMasuk',
                    '/editItemBarangMasuk',
                    '/simpanDetailBarangMasuk',

                    // detail barangmasuk
                    '/databarangmasuk',
                    '/detailListDataBarangMasuk',
                    '/downloadDetailListDataBarangMasuk',

                    // barangkeluar
                    '/barangkeluar',
                    '/listDataBarangKeluar',

                    '/barangKeluarTambah',
                    '/buatInvoiceBarangKeluar',
                    '/buatNoInvoiceBarangKeluar',

                    '/modalCariBarangJual',
                    '/listCariDataBarangJual',
                    '/ambilDataBarangJual',

                    '/tampilDataTempBarangKeluar',
                    '/hapusItemBarangKeluarTemp',
                    '/modalEditItemBarangKeluar/*',
                    '/modalEditItemBarangKeluarSimpan',

                    '/simpanItemBarangKeluar',
                    '/ambilTotalHargaBarangKeluarTemp',

                    '/modalPembayaranBarangKeluar',
                    '/modalPembayaranBarangKeluarSimpan',

                    '/cetakinvoice/*',

                    // '/barangKeluarEdit/*',
                    '/ambilTotalHargaBarangKeluar',
                    '/tampilDataDetailBarangKeluar',
                    '/hapusItemBarangKeluarDet',
                    '/modalEditItemBarangKeluarDetail/*',
                    '/modalEditItemBarangKeluarDetailSimpan',

                    '/simpanItemBarangKeluarDetail',

                    // '/hapusTransaksiBarangKeluar',

                    '/databarangkeluar',
                    '/detailListDataBarangKeluar',
                    '/downloadDetailListDataBarangKeluar',

                    // stockbarang
                    '/stockbarang',
                    '/listDataStockBarang',

                    // kasir
                    '/laporanKasir',
                    '/detailLaporanDataBarangKeluar',
                    '/downloadLaporanDataBarangKeluar/*',
                ],
            ],
        ],
    ];

    /**
     * List of filter aliases that works on a
     * particular HTTP method (GET, POST, etc.).
     *
     * Example:
     * 'post' => ['foo', 'bar']
     *
     * If you use this, you should disable auto-routing because auto-routing
     * permits any HTTP method to access a controller. Accessing the controller
     * with a method you don't expect could bypass the filter.
     */
    public array $methods = [];

    /**
     * List of filter aliases that should run on any
     * before or after URI patterns.
     *
     * Example:
     * 'isLoggedIn' => ['before' => ['account/*', 'profiles/*']]
     */
    public array $filters = [];
}
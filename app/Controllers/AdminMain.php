<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelBarangKeluar;
use App\Models\ModelBarangMasuk;
use CodeIgniter\HTTP\ResponseInterface;

class AdminMain extends BaseController
{
    public function index()
    {
        // Total Pembelian
        $modelBarangMasuk = new ModelBarangMasuk();
        $totalPembelian = $modelBarangMasuk->totalPembelian();

        // Total Penjualan
        $modelbarangkeluar = new ModelBarangKeluar();
        $totalPenjualan = $modelbarangkeluar->totalPenjualan();



        $data = [
            'menu'                      => 'dashboard',
            'submenu'                   => '',
            'title'                     => 'Dashboard',
            'totalPembelian'            => "Rp. " . number_format($totalPembelian, 0, ",", "."),
            'totalPenjualan'            => "Rp. " . number_format($totalPenjualan, 0, ",", "."),
        ];
        return view('admin/layout/dashboard', $data);
    }
}

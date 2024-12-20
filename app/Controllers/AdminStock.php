<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelCabang;
use App\Models\ModelStockPagination;
use Config\Services;

class AdminStock extends BaseController
{
    public function index()
    {
        $modelCabang = new ModelCabang();

        $data = [
            'menu' => 'stockbarang',
            'submenu' => 'stockbarang',
            'title' => 'Data Stock Barang',
            'tampilCabang' => $modelCabang->findAll(),

        ];
        return view('admin/stockbarang/stock_view', $data);

    }

    public function listDataStockBarang()
    {

        $cabang_id = $this->request->getPost('cabang_id');

        $request = Services::request();
        $datamodel = new ModelStockPagination($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables($cabang_id);
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $tombolCetak = "<button type=\"button\" class=\"btn btn-sm btn-info\" onclick=\"cetak('" . $list->stock_id . "')\" title=\"Cetak\"><i class='fas fa-print'></i></button>";
                $tombolHapus = "<button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"hapus('" . $list->stock_id . "')\" title=\"Hapus\"><i class='fas fa-trash-alt'></i></button>";
                $tombolEdit = "<button type=\"button\" class=\"btn btn-sm btn-primary\" onclick=\"edit('" . $list->stock_id . "')\" title=\"Edit\"><i class='fas fa-edit'></i></button>";

                $row[] = $no;
                $row[] = $list->cabang_nama;
                $row[] = $list->brgnama;
                $row[] = $list->stock_jumlah;
                $row[] = '';
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $datamodel->count_all($cabang_id),
                "recordsFiltered" => $datamodel->count_filtered($cabang_id),
                "data" => $data,
            ];
            echo json_encode($output);
        }
    }
}
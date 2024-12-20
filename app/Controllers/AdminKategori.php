<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelKategori;
use App\Models\ModelKategoriPagination;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

class AdminKategori extends BaseController
{
    public function index()
    {
        $data = [
            'menu'      => 'master',
            'submenu'   => 'kategori',
            'title'     => 'Data Kategori',
        ];
        return view('admin/kategori/kategori_view', $data);
    }

    // list data kategori
    public function listDataKategori()
    {
        $request = Services::request();
        $datamodel = new ModelKategoriPagination($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $tombolEdit = "<button type=\"button\" class=\"btn btn-sm btn-info\" onclick=\"edit('" . $list->katid . "')\" title=\"Edit\"><i class='fas fa-edit'></i></button>";
                $tombolHapus = "<button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"hapus('" . $list->katid . "')\" title=\"Hapus\"><i class='fas fa-trash-alt'></i></button>";


                // if ($list->subkat_katid == null) {
                //     $tombol = $tombolEdit . ' ' . $tombolHapus;
                // } else {
                //     $tombol = $tombolEdit;
                // }

                $row[] = $no;
                $row[] = $list->katnama;
                $row[] = $tombolEdit . ' ' . $tombolHapus;
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $datamodel->count_all(),
                "recordsFiltered" => $datamodel->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    // form tambah kategori
    public function kategoriTambah()
    {

        $json = [
            'data' => view('admin/kategori/kategori_tambah')
        ];

        echo json_encode($json);
    }

    // kategori simpan
    public function kategoriTambahSimpan()
    {
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'katnama' => [
                    'rules'     => 'required',
                    'label'     => 'Nama Kategori',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
            ]);

            if (!$valid) {
                $json = [
                    'error' => [
                        'errKategoriNama'                   => $validation->getError('katnama'),
                    ]
                ];
            } else {

                $katnama                   = $this->request->getPost('katnama');

                $modelKategori = new ModelKategori();

                $modelKategori->insert([
                    'katnama'              => $katnama,
                ]);

                $json = [
                    'sukses'        => 'Data berhasil disimpan'
                ];
            }


            echo json_encode($json);
        }
    }

    // form edit kategori
    public function kategoriEdit($katid)
    {
        $modelKategori = new ModelKategori();

        $modelKategori        = $modelKategori->find($katid);


        if ($modelKategori) {
            $data = [
                'katid'                => $modelKategori['katid'],
                'katnama'              => $modelKategori['katnama'],
            ];

            $json = [
                'data' => view('admin/kategori/kategori_edit', $data)
            ];
        }
        echo json_encode($json);
    }

    // kategori edit simpan
    public function kategoriEditSimpan()
    {
        if ($this->request->isAJAX()) {


            $katid                   = $this->request->getPost('katid');
            $katnama                 = $this->request->getPost('katnama');

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'katnama' => [
                    'rules'     => 'required',
                    'label'     => 'Nama Kategori',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
            ]);

            if (!$valid) {
                $json = [
                    'error' => [
                        'errKategoriNama'                   => $validation->getError('katnama'),
                    ]
                ];
            } else {


                $modelKategori = new ModelKategori();

                $cekData = $modelKategori->find($katid);

                $modelKategori->update($katid, [
                    'katnama'              => $katnama,
                ]);


                $json = [
                    'sukses'        => 'Data berhasil disimpan'
                ];
            }

            echo json_encode($json);
        }
    }

    // kategori hapus
    public function kategoriHapus($katid)
    {
        $modelKategori = new ModelKategori();
        $modelKategori->delete($katid);

        $json = [
            'sukses' => 'Data berhasil dihapus'
        ];


        echo json_encode($json);
    }
}

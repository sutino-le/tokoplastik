<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelSatuan;
use App\Models\ModelSatuanPagination;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

class AdminSatuan extends BaseController
{
    public function index()
    {
        $data = [
            'menu'      => 'master',
            'submenu'   => 'satuan',
            'title'     => 'Data Satuan',
        ];
        return view('admin/satuan/satuan_view', $data);
    }

    // list data satuan
    public function listDataSatuan()
    {
        $request = Services::request();
        $datamodel = new ModelSatuanPagination($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $tombolEdit = "<button type=\"button\" class=\"btn btn-sm btn-info\" onclick=\"edit('" . $list->satid . "')\" title=\"Edit\"><i class='fas fa-edit'></i></button>";
                $tombolHapus = "<button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"hapus('" . $list->satid . "')\" title=\"Hapus\"><i class='fas fa-trash-alt'></i></button>";


                // if ($list->subkat_satid == null) {
                //     $tombol = $tombolEdit . ' ' . $tombolHapus;
                // } else {
                //     $tombol = $tombolEdit;
                // }

                $row[] = $no;
                $row[] = $list->satnama;
                $row[] = $list->satlabel;
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

    // form tambah satuan
    public function satuanTambah()
    {

        $json = [
            'data' => view('admin/satuan/satuan_tambah')
        ];

        echo json_encode($json);
    }

    // satuan simpan
    public function satuanTambahSimpan()
    {
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'satnama' => [
                    'rules'     => 'required',
                    'label'     => 'Nama',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'satlabel' => [
                    'rules'     => 'required',
                    'label'     => 'Singkatan',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
            ]);

            if (!$valid) {
                $json = [
                    'error' => [
                        'errSatuanNama'                   => $validation->getError('satnama'),
                        'errSatuanLabel'                   => $validation->getError('satlabel'),
                    ]
                ];
            } else {

                $satnama                    = $this->request->getPost('satnama');
                $satlabel                   = $this->request->getPost('satlabel');

                $modelSatuan = new ModelSatuan();

                $modelSatuan->insert([
                    'satnama'               => $satnama,
                    'satlabel'              => $satlabel,
                ]);

                $json = [
                    'sukses'        => 'Data berhasil disimpan'
                ];
            }


            echo json_encode($json);
        }
    }

    // form edit satuan
    public function satuanEdit($satid)
    {
        $modelSatuan = new ModelSatuan();

        $modelSatuan        = $modelSatuan->find($satid);


        if ($modelSatuan) {
            $data = [
                'satid'                => $modelSatuan['satid'],
                'satnama'              => $modelSatuan['satnama'],
                'satlabel'             => $modelSatuan['satlabel'],
            ];

            $json = [
                'data' => view('admin/satuan/satuan_edit', $data)
            ];
        }
        echo json_encode($json);
    }

    // satuan edit simpan
    public function satuanEditSimpan()
    {
        if ($this->request->isAJAX()) {


            $satid                   = $this->request->getPost('satid');
            $satnama                 = $this->request->getPost('satnama');
            $satlabel                = $this->request->getPost('satlabel');

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'satnama' => [
                    'rules'     => 'required',
                    'label'     => 'Nama',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'satlabel' => [
                    'rules'     => 'required',
                    'label'     => 'Singkatan',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
            ]);

            if (!$valid) {
                $json = [
                    'error' => [
                        'errSatuanNama'                   => $validation->getError('satnama'),
                        'errSatuanLabel'                  => $validation->getError('satlabel'),
                    ]
                ];
            } else {


                $modelSatuan = new ModelSatuan();

                $cekData = $modelSatuan->find($satid);

                $modelSatuan->update($satid, [
                    'satnama'              => $satnama,
                    'satlabel'             => $satlabel,
                ]);


                $json = [
                    'sukses'        => 'Data berhasil disimpan'
                ];
            }

            echo json_encode($json);
        }
    }

    // satuan hapus
    public function satuanHapus($satid)
    {
        $modelSatuan = new ModelSatuan();
        $modelSatuan->delete($satid);

        $json = [
            'sukses' => 'Data berhasil dihapus'
        ];


        echo json_encode($json);
    }
}

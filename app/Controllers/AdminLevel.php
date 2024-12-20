<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelLevel;
use CodeIgniter\HTTP\ResponseInterface;

class AdminLevel extends BaseController
{
    public function index()
    {
        $modelLevel = new ModelLevel();
        $data = [
            'menu'      => 'setting',
            'submenu'   => 'level',
            'title'     => 'Data Level',
            'dataLevel' => $modelLevel->dataLevel(),
        ];
        return view('admin/level/level_view', $data);
    }

    // form tambah level
    public function levelTambah()
    {

        $json = [
            'data' => view('admin/level/level_tambah')
        ];

        echo json_encode($json);
    }

    // level simpan
    public function levelTambahSimpan()
    {
        if ($this->request->isAJAX()) {
            $levelnama      = $this->request->getPost('levelnama');

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'levelnama' => [
                    'rules'     => 'required',
                    'label'     => 'Level',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
            ]);

            if (!$valid) {
                $json = [
                    'error' => [
                        'errLevelNama'      => $validation->getError('levelnama'),
                    ]
                ];
            } else {
                $modelLevel = new ModelLevel();

                $modelLevel->insert([
                    'levelnama'        => $levelnama,
                ]);

                $json = [
                    'sukses'        => 'Data berhasil disimpan'
                ];
            }


            echo json_encode($json);
        }
    }

    // form edit level
    public function levelEdit($levelid)
    {
        $modelLevel = new ModelLevel();

        $cekDataSub        = $modelLevel->find($levelid);


        if ($cekDataSub) {
            $data = [
                'levelid'          => $cekDataSub['levelid'],
                'levelnama'        => $cekDataSub['levelnama'],
            ];

            $json = [
                'data' => view('admin/level/level_edit', $data)
            ];
        }
        echo json_encode($json);
    }

    // level edit simpan
    public function levelEditSimpan()
    {
        if ($this->request->isAJAX()) {
            $levelid      = $this->request->getPost('levelid');
            $levelnama      = $this->request->getPost('levelnama');

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'levelnama' => [
                    'rules'     => 'required',
                    'label'     => 'Level',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
            ]);

            if (!$valid) {
                $json = [
                    'error' => [
                        'errLevelNama'      => $validation->getError('levelnama'),
                    ]
                ];
            } else {
                $modelLevel = new ModelLevel();

                $modelLevel->update($levelid, [
                    'levelnama'        => $levelnama,
                ]);

                $json = [
                    'sukses'        => 'Data berhasil dirubah'
                ];
            }


            echo json_encode($json);
        }
    }

    // level hapus
    public function levelHapus($levelid)
    {
        $modelLevel = new ModelLevel();
        $modelLevel->delete($levelid);

        $json = [
            'sukses' => 'Data berhasil dihapus'
        ];


        echo json_encode($json);
    }
}

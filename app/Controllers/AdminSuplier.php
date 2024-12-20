<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelSuplier;
use CodeIgniter\HTTP\ResponseInterface;

class AdminSuplier extends BaseController
{
    public function index()
    {
        //
    }



    // suplierTambah
    public function suplierTambah()
    {

        $json = [
            'data' => view('admin/suplier/suplier_tambah'),
        ];

        echo json_encode($json);
    }

    // suplierTambahSimpan
    public function suplierTambahSimpan()
    {
        $supnama        = $this->request->getPost('supnama');
        $suptelp        = $this->request->getPost('suptelp');
        $supalamat      = $this->request->getPost('supalamat');
        $supnpwp        = $this->request->getPost('supnpwp');
        $suprekening    = $this->request->getPost('suprekening');

        $validation = \Config\Services::validation();
        $valid = $this->validate([
            'supnama' => [
                'rules'     => 'required',
                'label'     => 'Nama Suplier',
                'errors'    => [
                    'required'  => '{field} tidak boleh kosong'
                ]
            ],
            // 'suptelp' => [
            //     'rules'     => 'required|is_unique[suplier.suptelp]',
            //     'label'     => 'Nomor Telp/Hp',
            //     'errors'    => [
            //         'required'  => '{field} tidak boleh kosong',
            //         'is_unique' => '{field} tidak boleh ada yang sama'
            //     ]
            // ],
            // 'supalamat' => [
            //     'rules'     => 'required',
            //     'label'     => 'Alamat',
            //     'errors'    => [
            //         'required'  => '{field} tidak boleh kosong'
            //     ]
            // ],
            // 'supnpwp' => [
            //     'rules'     => 'numeric',
            //     'label'     => 'NPWP',
            //     'errors'    => [
            //         'numeric'  => '{field} tidak boleh kosong'
            //     ]
            // ],
            // 'suprekening' => [
            //     'rules'     => 'numeric',
            //     'label'     => 'Rekening',
            //     'errors'    => [
            //         'numeric'  => '{field} tidak boleh kosong'
            //     ]
            // ]
        ]);

        if (!$valid) {
            $json = [
                'error' => [
                    'errSuplierNama'        => $validation->getError('supnama'),
                    // 'errSupTelp'        => $validation->getError('suptelp'),
                    // 'errSupAlamat'      => $validation->getError('supalamat'),
                    // 'errSupNpwp'        => $validation->getError('supnpwp'),
                    // 'errSupRekening'    => $validation->getError('suprekening'),
                ]
            ];
        } else {
            $modelSuplier = new ModelSuplier();

            $modelSuplier->insert([
                'supnama'       => $supnama,
                'suptelp'       => $suptelp,
                'supalamat'     => $supalamat,
                'supnpwp'       => $supnpwp,
                'suprekening'   => $suprekening
            ]);

            $rowData = $modelSuplier->ambilDataTerakhir()->getRowArray();

            $json = [
                'sukses'        => 'Data Suplier berhasil disimpan, ambil data terakhir ?',
                'namasuplier' => $rowData['supnama'],
                'idsuplier'   => $rowData['supid']
            ];
        }

        echo json_encode($json);
    }



    public function suplierHapus()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');

            $modelSuplier = new ModelSuplier();

            $modelSuplier->delete($id);

            $json = [
                'sukses' => 'Data Suplier berhasil dihapus'
            ];

            echo json_encode($json);
        } else {
            exit('Maaf, gagal menampilkan data');
        }
    }
}

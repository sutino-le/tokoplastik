<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelCabang;
use App\Models\ModelCabangPagination;
use App\Models\ModelWilayah;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

class AdminCabang extends BaseController
{
    public function index()
    {
        $data = [
            'menu'      => 'setting',
            'submenu'   => 'cabang',
            'title'     => 'Data Cabang',
        ];
        return view('admin/cabang/cabang_view', $data);
    }

    // listDataCabang
    public function listDataCabang()
    {
        $request = Services::request();
        $datamodel = new ModelCabangPagination($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $tombolEdit = "<button type=\"button\" class=\"btn btn-sm btn-info\" onclick=\"edit('" . $list->cabang_id . "')\" title=\"Edit\"><i class='fas fa-edit'></i></button>";
                $tombolHapus = "<button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"hapus('" . $list->cabang_id . "')\" title=\"Hapus\"><i class='fas fa-trash-alt'></i></button>";


                // if ($list->subkat_cabang_id == null) {
                //     $tombol = $tombolEdit . ' ' . $tombolHapus;
                // } else {
                //     $tombol = $tombolEdit;
                // }

                $row[] = $no;
                $row[] = $list->cabang_nama;
                $row[] = $list->cabang_alamat . ', Kel. ' . $list->kelurahan . ', Kec. ' . $list->kecamatan . ', ' . $list->kota_kabupaten . ' - ' . $list->propinsi;
                $row[] = $list->cabang_hp;
                $row[] = "<div style=\"display: flex; gap: 5px;\">" . $tombolEdit . ' ' . $tombolHapus . "</div>";
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

    // cabangTambah
    public function cabangTambah()
    {

        $data = [
            'menu'      => 'setting',
            'submenu'   => 'cabang',
            'title'     => 'Input Cabang',
        ];

        return view('admin/cabang/cabang_tambah', $data);
    }

    // cabangTambahSimpan
    public function cabangTambahSimpan()
    {
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'cabang_nama' => [
                    'rules'     => 'required',
                    'label'     => 'Nama',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'cabang_alamat' => [
                    'rules'     => 'required',
                    'label'     => 'Alamat',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'cabang_alamatid' => [
                    'rules'     => 'required',
                    'label'     => 'Lokasi',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'cabang_hp' => [
                    'rules'     => 'required',
                    'label'     => 'No. HP',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
            ]);

            if (!$valid) {
                $json = [
                    'error' => [
                        'errCabangNama'         => $validation->getError('cabang_nama'),
                        'errCabangAlamat'       => $validation->getError('cabang_alamat'),
                        'errCabangAlamatID'     => $validation->getError('cabang_alamatid'),
                        'errCabangHP'           => $validation->getError('cabang_hp'),
                    ]
                ];
            } else {

                $cabang_nama                = $this->request->getPost('cabang_nama');
                $cabang_alamat              = $this->request->getPost('cabang_alamat');
                $cabang_alamatid            = $this->request->getPost('cabang_alamatid');
                $cabang_hp                  = $this->request->getPost('cabang_hp');


                $modelCabang = new ModelCabang();

                $modelCabang->insert([
                    'cabang_nama'           => $cabang_nama,
                    'cabang_alamat'         => $cabang_alamat,
                    'cabang_alamatid'       => $cabang_alamatid,
                    'cabang_hp'             => $cabang_hp,
                ]);

                $json = [
                    'sukses'        => 'Data berhasil disimpan'
                ];
            }


            echo json_encode($json);
        }
    }

    // cabangEdit
    public function cabangEdit($cabang_id)
    {
        $modelCabang = new ModelCabang();
        $cekDataCabang  = $modelCabang->find($cabang_id);
        $id = $cekDataCabang['cabang_alamatid'];

        $modelWilayah = new ModelWilayah();
        $cekDataWilayah        = $modelWilayah->find($id);

        $data = [
            'menu'                  => 'setting',
            'submenu'               => 'cabang',
            'title'                 => 'Edit Cabang',
            'cabang_id'             => $cekDataCabang['cabang_id'],
            'cabang_nama'           => $cekDataCabang['cabang_nama'],
            'cabang_alamat'         => $cekDataCabang['cabang_alamat'],
            'cabang_alamatid'       => $cekDataCabang['cabang_alamatid'],
            'cabang_hp'             => $cekDataCabang['cabang_hp'],
            'kelurahan'             => $cekDataWilayah['kelurahan'],
            'kecamatan'             => $cekDataWilayah['kecamatan'],
            'kota_kabupaten'        => $cekDataWilayah['kota_kabupaten'],
            'propinsi'              => $cekDataWilayah['propinsi'],
        ];

        return view('admin/cabang/cabang_edit', $data);
    }

    // cabangEditSimpan
    public function cabangEditSimpan()
    {
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'cabang_nama' => [
                    'rules'     => 'required',
                    'label'     => 'Nama',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'cabang_alamat' => [
                    'rules'     => 'required',
                    'label'     => 'Alamat',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'cabang_alamatid' => [
                    'rules'     => 'required',
                    'label'     => 'Lokasi',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'cabang_hp' => [
                    'rules'     => 'required',
                    'label'     => 'No. HP',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
            ]);

            if (!$valid) {
                $json = [
                    'error' => [
                        'errCabangNama'         => $validation->getError('cabang_nama'),
                        'errCabangAlamat'       => $validation->getError('cabang_alamat'),
                        'errCabangAlamatID'     => $validation->getError('cabang_alamatid'),
                        'errCabangHP'           => $validation->getError('cabang_hp'),
                    ]
                ];
            } else {
                $cabang_id                  = $this->request->getPost('cabang_id');
                $cabang_nama                = $this->request->getPost('cabang_nama');
                $cabang_alamat              = $this->request->getPost('cabang_alamat');
                $cabang_alamatid            = $this->request->getPost('cabang_alamatid');
                $cabang_hp                  = $this->request->getPost('cabang_hp');


                $modelCabang = new ModelCabang();

                $modelCabang->update($cabang_id, [
                    'cabang_nama'           => $cabang_nama,
                    'cabang_alamat'         => $cabang_alamat,
                    'cabang_alamatid'       => $cabang_alamatid,
                    'cabang_hp'             => $cabang_hp,
                ]);

                $json = [
                    'sukses'        => 'Data berhasil disimpan'
                ];
            }


            echo json_encode($json);
        }
    }

    // cabangHapus
    public function cabangHapus($cabang_id)
    {
        $modelCabang = new ModelCabang();
        $modelCabang->delete($cabang_id);

        $json = [
            'sukses' => 'Data berhasil dihapus'
        ];


        echo json_encode($json);
    }
}

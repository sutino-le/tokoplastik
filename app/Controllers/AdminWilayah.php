<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelWilayah;
use App\Models\ModelWilayahPagination;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

class AdminWilayah extends BaseController
{
    public function index()
    {
        $data = [
            'menu'      => 'setting',
            'submenu'   => 'wilayah',
            'title'     => 'Data Wilayah',
        ];
        return view('admin/wilayah/wilayah_view', $data);
    }

    // list data wilayah
    public function listDataWilayah()
    {
        $request = Services::request();
        $datamodel = new ModelWilayahPagination($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $tombolEdit = "<button type=\"button\" class=\"btn btn-sm btn-info\" onclick=\"edit('" . $list->id_wilayah . "')\" title=\"Edit\"><i class='fas fa-edit'></i></button>";
                $tombolHapus = "<button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"hapus('" . $list->id_wilayah . "')\" title=\"Hapus\"><i class='fas fa-trash-alt'></i></button>";

                if ($list->userid == null) {
                    $tombol = $tombolEdit . ' ' . $tombolHapus;
                } else {
                    $tombol = $tombolEdit;
                }

                $row[] = $no;
                $row[] = $list->kelurahan;
                $row[] = $list->kecamatan;
                $row[] = $list->kota_kabupaten;
                $row[] = $list->propinsi;
                $row[] = $list->kodepos;
                $row[] = "<div style=\"display: flex; gap: 5px;\">" . $tombol . "</div>";
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

    // form tambah wilayah
    public function wilayahTambah()
    {

        $json = [
            'data' => view('admin/wilayah/wilayah_tambah')
        ];

        echo json_encode($json);
    }

    // level simpan
    public function wilayahTambahSimpan()
    {
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'kelurahan' => [
                    'rules'     => 'required',
                    'label'     => 'Kelurahan',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'kecamatan' => [
                    'rules'     => 'required',
                    'label'     => 'Kecamatan',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'kota_kabupaten' => [
                    'rules'     => 'required',
                    'label'     => 'Kota / Kabupaten',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'propinsi' => [
                    'rules'     => 'required',
                    'label'     => 'Propinsi',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'kodepos' => [
                    'rules'     => 'required',
                    'label'     => 'Kode POS',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
            ]);

            if (!$valid) {
                $json = [
                    'error' => [
                        'errKelurahan'          => $validation->getError('kelurahan'),
                        'errKecamatan'          => $validation->getError('kecamatan'),
                        'errKotaKabupaten'      => $validation->getError('kota_kabupaten'),
                        'errPropinsi'           => $validation->getError('propinsi'),
                        'errKodePos'            => $validation->getError('kodepos'),
                    ]
                ];
            } else {

                $kelurahan          = $this->request->getPost('kelurahan');
                $kecamatan          = $this->request->getPost('kecamatan');
                $kota_kabupaten     = $this->request->getPost('kota_kabupaten');
                $propinsi           = $this->request->getPost('propinsi');
                $kodepos            = $this->request->getPost('kodepos');


                $modelWilayah = new ModelWilayah();

                $modelWilayah->insert([
                    'kelurahan'         => $kelurahan,
                    'kecamatan'         => $kecamatan,
                    'kota_kabupaten'    => $kota_kabupaten,
                    'propinsi'          => $propinsi,
                    'kodepos'           => $kodepos,
                ]);

                $json = [
                    'sukses'        => 'Data berhasil disimpan'
                ];
            }


            echo json_encode($json);
        }
    }

    // form edit level
    public function wilayahEdit($id_wilayah)
    {
        $modelWilayah = new ModelWilayah();

        $cekDatawilayah        = $modelWilayah->find($id_wilayah);


        if ($cekDatawilayah) {
            $data = [
                'id_wilayah'            => $cekDatawilayah['id_wilayah'],
                'kelurahan'             => $cekDatawilayah['kelurahan'],
                'kecamatan'             => $cekDatawilayah['kecamatan'],
                'kota_kabupaten'        => $cekDatawilayah['kota_kabupaten'],
                'propinsi'              => $cekDatawilayah['propinsi'],
                'kodepos'               => $cekDatawilayah['kodepos'],
            ];

            $json = [
                'data' => view('admin/wilayah/wilayah_edit', $data)
            ];
        }
        echo json_encode($json);
    }

    // level edit simpan
    public function wilayahEditSimpan()
    {
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'kelurahan' => [
                    'rules'     => 'required',
                    'label'     => 'Kelurahan',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'kecamatan' => [
                    'rules'     => 'required',
                    'label'     => 'Kecamatan',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'kota_kabupaten' => [
                    'rules'     => 'required',
                    'label'     => 'Kota / Kabupaten',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'propinsi' => [
                    'rules'     => 'required',
                    'label'     => 'Propinsi',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'kodepos' => [
                    'rules'     => 'required',
                    'label'     => 'Kode POS',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
            ]);

            if (!$valid) {
                $json = [
                    'error' => [
                        'errKelurahan'          => $validation->getError('kelurahan'),
                        'errKecamatan'          => $validation->getError('kecamatan'),
                        'errKotaKabupaten'      => $validation->getError('kota_kabupaten'),
                        'errPropinsi'           => $validation->getError('propinsi'),
                        'errKodePos'            => $validation->getError('kodepos'),
                    ]
                ];
            } else {
                $id_wilayah         = $this->request->getPost('id_wilayah');
                $kelurahan          = $this->request->getPost('kelurahan');
                $kecamatan          = $this->request->getPost('kecamatan');
                $kota_kabupaten     = $this->request->getPost('kota_kabupaten');
                $propinsi           = $this->request->getPost('propinsi');
                $kodepos            = $this->request->getPost('kodepos');


                $modelWilayah = new ModelWilayah();

                $modelWilayah->update($id_wilayah, [
                    'kelurahan'         => $kelurahan,
                    'kecamatan'         => $kecamatan,
                    'kota_kabupaten'    => $kota_kabupaten,
                    'propinsi'          => $propinsi,
                    'kodepos'           => $kodepos,
                ]);

                $json = [
                    'sukses'        => 'Data berhasil dirubah'
                ];
            }


            echo json_encode($json);
        }
    }

    // level hapus
    public function wilayahHapus($id_wilayah)
    {
        $modelWilayah = new ModelWilayah();
        $modelWilayah->delete($id_wilayah);

        $json = [
            'sukses' => 'Data berhasil dihapus'
        ];


        echo json_encode($json);
    }
}

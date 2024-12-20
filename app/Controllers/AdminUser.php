<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelCabang;
use App\Models\ModelLevel;
use App\Models\ModelUser;
use App\Models\ModelWilayah;
use App\Models\ModelWilayahPagination;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

class AdminUser extends BaseController
{
    public function index()
    {
        $modelUser = new ModelUser();
        $data = [
            'menu'      => 'setting',
            'submenu'   => 'user',
            'title'     => 'Data User',
            'dataUser'  => $modelUser->dataUser(),
        ];
        return view('admin/user/user_view', $data);
    }

    // form tambah user
    public function userTambah()
    {
        $modelLevel = new ModelLevel();
        $modelCabang = new ModelCabang();

        $data = [
            'menu'          => 'setting',
            'submenu'       => 'user',
            'title'         => 'Input User',
            'dataLevel'     => $modelLevel->findAll(),
            'dataCabang'    => $modelCabang->findAll()
        ];

        return view('admin/user/user_tambah', $data);
    }

    // modal cari wilayah
    public function wilayahCari()
    {
        if ($this->request->isAJAX()) {
            $json = [
                'data' => view('admin/wilayah/wilayah_cari')
            ];

            echo json_encode($json);
        } else {
            exit('Maaf, gagal menampilkan data');
        }
    }

    public function listModalWilayah()
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

                $tombolPilih = "<button type=\"button\" class=\"btn btn-sm btn-info\" onclick=\"pilih('" . $list->id_wilayah . "', '" . $list->kelurahan . "', '" . $list->kecamatan . "', '" . $list->kota_kabupaten . "', '" . $list->propinsi . "')\" title=\"Pilih\"><i class='fas fa-hand-point-up'></i></button>";

                $row[] = $no;
                $row[] = $list->kelurahan;
                $row[] = $list->kecamatan;
                $row[] = $list->kota_kabupaten;
                $row[] = $list->propinsi;
                $row[] = $list->kodepos;
                $row[] = $tombolPilih;
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

    // user simpan
    public function userTambahSimpan()
    {
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'userid' => [
                    'rules'     => 'required',
                    'label'     => 'ID',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'usernama' => [
                    'rules'     => 'required',
                    'label'     => 'Nama',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'useremail' => [
                    'rules'     => 'required',
                    'label'     => 'Email',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'userhp' => [
                    'rules'     => 'required',
                    'label'     => 'No. HP',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'useralamat' => [
                    'rules'     => 'required',
                    'label'     => 'Alamat',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'lokasialamat' => [
                    'rules'     => 'required',
                    'label'     => 'Wilayah',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'userpassword' => [
                    'rules'     => 'required',
                    'label'     => 'Kata Sandi',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'userlevel' => [
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
                        'errUserID'         => $validation->getError('userid'),
                        'errUserNama'       => $validation->getError('usernama'),
                        'errUserEmail'      => $validation->getError('useremail'),
                        'errUserHP'         => $validation->getError('userhp'),
                        'errUserAlamat'     => $validation->getError('useralamat'),
                        'errUserAlamatID'   => $validation->getError('lokasialamat'),
                        'errUserPassword'   => $validation->getError('userpassword'),
                        'errUserLevel'      => $validation->getError('userlevel'),
                    ]
                ];
            } else {

                $userid             = $this->request->getPost('userid');
                $usernama           = $this->request->getPost('usernama');
                $useremail          = $this->request->getPost('useremail');
                $userhp             = $this->request->getPost('userhp');
                $useralamat         = $this->request->getPost('useralamat');
                $useralamatid       = $this->request->getPost('useralamatid');
                $userpassword       = $this->request->getPost('userpassword');
                $userlevel          = $this->request->getPost('userlevel');
                $usercabang         = $this->request->getPost('usercabang');


                $modelUser = new ModelUser();

                $modelUser->insert([
                    'userid'            => $userid,
                    'usernama'          => $usernama,
                    'useremail'         => $useremail,
                    'userhp'            => $userhp,
                    'useralamat'        => $useralamat,
                    'useralamatid'      => $useralamatid,
                    'userstatus'        => 'Aktif',
                    'userpassword'      => $userpassword,
                    'userlevel'         => $userlevel,
                    'usercabang'        => $usercabang,
                ]);

                $json = [
                    'sukses'        => 'Data berhasil disimpan'
                ];
            }


            echo json_encode($json);
        }
    }

    // form edit user
    public function userEdit($userid)
    {
        $modelUser = new ModelUser();
        $modelLevel = new ModelLevel();
        $modelWilayah = new ModelWilayah();
        $modelCabang = new ModelCabang();

        $cekDataUser        = $modelUser->find($userid);
        $id = $cekDataUser['useralamatid'];

        $cekDataWilayah        = $modelWilayah->find($id);


        $data = [
            'menu'              => 'setting',
            'submenu'           => 'user',
            'title'             => 'Edit User',
            'userid'            => $cekDataUser['userid'],
            'usernama'          => $cekDataUser['usernama'],
            'useremail'         => $cekDataUser['useremail'],
            'userhp'            => $cekDataUser['userhp'],
            'useralamat'        => $cekDataUser['useralamat'],
            'useralamatid'      => $cekDataUser['useralamatid'],
            'kelurahan'         => $cekDataWilayah['kelurahan'],
            'kecamatan'         => $cekDataWilayah['kecamatan'],
            'kota_kabupaten'    => $cekDataWilayah['kota_kabupaten'],
            'propinsi'          => $cekDataWilayah['propinsi'],
            'userstatus'        => $cekDataUser['userstatus'],
            'userpassword'      => $cekDataUser['userpassword'],
            'userlevel'         => $cekDataUser['userlevel'],
            'usercabang'        => $cekDataUser['usercabang'],
            'dataLevel'         => $modelLevel->findAll(),
            'dataCabang'        => $modelCabang->findAll()
        ];

        return view('admin/user/user_edit', $data);
    }

    // user edit simpan
    public function userEditSimpan()
    {
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'userid' => [
                    'rules'     => 'required',
                    'label'     => 'ID',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'usernama' => [
                    'rules'     => 'required',
                    'label'     => 'Nama',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'useremail' => [
                    'rules'     => 'required',
                    'label'     => 'Email',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'userhp' => [
                    'rules'     => 'required',
                    'label'     => 'No. HP',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'useralamat' => [
                    'rules'     => 'required',
                    'label'     => 'Alamat',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'lokasialamat' => [
                    'rules'     => 'required',
                    'label'     => 'Wilayah',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'userpassword' => [
                    'rules'     => 'required',
                    'label'     => 'Kata Sandi',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'userlevel' => [
                    'rules'     => 'required',
                    'label'     => 'Level',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'userstatus' => [
                    'rules'     => 'required',
                    'label'     => 'Status',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
            ]);

            if (!$valid) {
                $json = [
                    'error' => [
                        'errUserID'         => $validation->getError('userid'),
                        'errUserNama'       => $validation->getError('usernama'),
                        'errUserEmail'      => $validation->getError('useremail'),
                        'errUserHP'         => $validation->getError('userhp'),
                        'errUserAlamat'     => $validation->getError('useralamat'),
                        'errUserAlamatID'   => $validation->getError('lokasialamat'),
                        'errUserPassword'   => $validation->getError('userpassword'),
                        'errUserLevel'      => $validation->getError('userlevel'),
                        'errUserStatus'     => $validation->getError('userstatus'),
                    ]
                ];
            } else {

                $userid             = $this->request->getPost('userid');
                $usernama           = $this->request->getPost('usernama');
                $useremail          = $this->request->getPost('useremail');
                $userhp             = $this->request->getPost('userhp');
                $useralamat         = $this->request->getPost('useralamat');
                $useralamatid       = $this->request->getPost('useralamatid');
                $userpassword       = $this->request->getPost('userpassword');
                $userlevel          = $this->request->getPost('userlevel');
                $userstatus         = $this->request->getPost('userstatus');
                $usercabang         = $this->request->getPost('usercabang');


                $modelUser = new ModelUser();

                $modelUser->update($userid, [
                    'usernama'          => $usernama,
                    'useremail'         => $useremail,
                    'userhp'            => $userhp,
                    'useralamat'        => $useralamat,
                    'useralamatid'      => $useralamatid,
                    'userstatus'        => $userstatus,
                    'userpassword'      => $userpassword,
                    'userlevel'         => $userlevel,
                    'usercabang'        => $usercabang,
                ]);

                $json = [
                    'sukses'        => 'Data berhasil dirubah'
                ];
            }


            echo json_encode($json);
        }
    }

    // user hapus
    public function userHapus($userid)
    {
        $modelUser = new ModelUser();
        $modelUser->delete($userid);

        $json = [
            'sukses' => 'Data berhasil dihapus'
        ];


        echo json_encode($json);
    }

    // form edit user
    public function userEditProfil($userid)
    {
        $modelUser = new ModelUser();
        $modelLevel = new ModelLevel();
        $modelWilayah = new ModelWilayah();

        $cekDataUser        = $modelUser->find($userid);
        $id = $cekDataUser['useralamatid'];

        $cekDataWilayah        = $modelWilayah->find($id);


        $data = [
            'menu'              => 'setting',
            'submenu'           => 'user',
            'title'             => 'Edit User',
            'userid'            => $cekDataUser['userid'],
            'usernama'          => $cekDataUser['usernama'],
            'useremail'         => $cekDataUser['useremail'],
            'userhp'            => $cekDataUser['userhp'],
            'useralamat'        => $cekDataUser['useralamat'],
            'useralamatid'      => $cekDataUser['useralamatid'],
            'kelurahan'         => $cekDataWilayah['kelurahan'],
            'kecamatan'         => $cekDataWilayah['kecamatan'],
            'kota_kabupaten'    => $cekDataWilayah['kota_kabupaten'],
            'propinsi'          => $cekDataWilayah['propinsi'],
            'userstatus'        => $cekDataUser['userstatus'],
            'userpassword'      => $cekDataUser['userpassword'],
            'userlevel'         => $cekDataUser['userlevel'],
            'dataLevel'         => $modelLevel->findAll()
        ];

        return view('admin/user/user_edit_profil', $data);
    }

    // user edit simpan
    public function userEditProfilSimpan()
    {
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'userid' => [
                    'rules'     => 'required',
                    'label'     => 'ID',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'usernama' => [
                    'rules'     => 'required',
                    'label'     => 'Nama',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'useremail' => [
                    'rules'     => 'required',
                    'label'     => 'Email',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'userhp' => [
                    'rules'     => 'required',
                    'label'     => 'No. HP',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'useralamat' => [
                    'rules'     => 'required',
                    'label'     => 'Alamat',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'lokasialamat' => [
                    'rules'     => 'required',
                    'label'     => 'Wilayah',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'userpassword' => [
                    'rules'     => 'required',
                    'label'     => 'Kata Sandi',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
            ]);

            if (!$valid) {
                $json = [
                    'error' => [
                        'errUserID'         => $validation->getError('userid'),
                        'errUserNama'       => $validation->getError('usernama'),
                        'errUserEmail'      => $validation->getError('useremail'),
                        'errUserHP'         => $validation->getError('userhp'),
                        'errUserAlamat'     => $validation->getError('useralamat'),
                        'errUserAlamatID'   => $validation->getError('lokasialamat'),
                        'errUserPassword'   => $validation->getError('userpassword'),
                    ]
                ];
            } else {

                $userid             = $this->request->getPost('userid');
                $usernama           = $this->request->getPost('usernama');
                $useremail          = $this->request->getPost('useremail');
                $userhp             = $this->request->getPost('userhp');
                $useralamat         = $this->request->getPost('useralamat');
                $useralamatid       = $this->request->getPost('useralamatid');
                $userpassword       = $this->request->getPost('userpassword');


                $modelUser = new ModelUser();

                $modelUser->update($userid, [
                    'usernama'          => $usernama,
                    'useremail'         => $useremail,
                    'userhp'            => $userhp,
                    'useralamat'        => $useralamat,
                    'useralamatid'      => $useralamatid,
                    'userpassword'      => $userpassword,
                ]);

                $json = [
                    'sukses'        => 'Data berhasil dirubah',
                ];
            }


            echo json_encode($json);
        }
    }
}

<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelUser;
use CodeIgniter\HTTP\ResponseInterface;

class AdminAuth extends BaseController
{
    public function index()
    {
        return view('admin/auth/auth');
    }

    // cek user
    function cekUser()
    {
        if ($this->request->isAJAX()) {
            $userid = $this->request->getPost('userid');
            $userpassword = $this->request->getPost('userpassword');

            $validation = \Config\Services::validation();



            $valid = $this->validate([
                'userid'    => [
                    'label'     => 'User',
                    'rules'     => 'required',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'userpassword'    => [
                    'label'     => 'Password',
                    'rules'     => 'required',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ]
            ]);

            if (!$valid) {
                $json = [
                    'error' => [
                        'errUserID'     => $validation->getError('userid'),
                        'errPassword'   => $validation->getError('userpassword'),
                    ]
                ];
            } else {
                $modelUser  = new ModelUser();

                $cekUser = $modelUser->find($userid);

                if ($cekUser == null) {
                    $json = [
                        'error' => [
                            'errDatabase'     => 'Maaf, ID atau Password salah!!!',
                        ]
                    ];
                } else {
                    $passwordUser = $cekUser['userpassword'];
                    if ($userpassword == $passwordUser) {

                        // simpan session
                        $simpan_session = [
                            'userid'        => $userid,
                            'usernama'      => $cekUser['usernama'],
                            'level'         => $cekUser['userlevel'],
                            'usercabang'    => $cekUser['usercabang'],
                        ];
                        session()->set($simpan_session);

                        $json = [
                            'sukses' => 'Anda berhasil melukan login...'
                        ];
                    } else {
                        $json = [
                            'error' => [
                                'errDatabase'     => 'Maaf, ID atau Password salah!!!',
                            ]
                        ];
                    }
                }
            }

            return json_encode($json);
        }
    }

    // logout
    public function Logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}

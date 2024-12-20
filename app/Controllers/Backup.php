<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Backup extends BaseController
{
    public function index()
    {
        $data = [
            'menu'          => 'backup',
            'submenu'       => '',
        ];
        return view('backup/viewdata', $data);
    }
}

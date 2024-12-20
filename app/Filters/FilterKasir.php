<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class FilterKasir implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (session()->level == '') {
            return redirect()->to('/');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        if (session()->level == 2) {
            echo "<script>alert('Bukan Otoritas Anda'); window.location.href='" . base_url('/main') . "';</script>";
            return;
        }
    }
}

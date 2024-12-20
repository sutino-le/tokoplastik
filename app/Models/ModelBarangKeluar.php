<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelBarangKeluar extends Model
{
    protected $table            = 'barangkeluar';
    protected $primaryKey       = 'invoice';
    protected $allowedFields    = ['invoice', 'tglinvoice', 'invuserid', 'totalharga', 'disctoko', 'jumlahuang', 'sisauang', 'bkuser'];



    public function noInvoice($tanggalSekarang)
    {
        return $this->table('barangkeluar')->select('max(invoice) as noinvoice')->where('tglinvoice', $tanggalSekarang)->get();
    }

    public function dataKasir()
    {
        return $this->table('barangkeluar')->join('user', 'userid=invuserid', 'left')->groupby('barangkeluar.invuserid')->get();
    }

    function ambilTotalDiskon($userid, $tglawal)
    {
        $query = $this->table('barangkeluar')
            ->getWhere([
                'invuserid' => $userid,
                'tglinvoice' => $tglawal
            ]);

        $totalDiskon = 0;
        foreach ($query->getResultArray() as $r) :
            $totalDiskon += $r['disctoko'];
        endforeach;
        return $totalDiskon;
    }





    function totalPenjualan()
    {
        $query = $this->table('barangkeluar')
            ->get();

        $totalPenjualan = 0;
        foreach ($query->getResultArray() as $r) :
            $totalPenjualan += $r['totalharga'];
        endforeach;
        return $totalPenjualan;
    }
}

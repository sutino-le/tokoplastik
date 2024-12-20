<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelBarangKeluarDetail extends Model
{
    protected $table            = 'barangkeluar_detail';
    protected $primaryKey       = 'iddetail';
    protected $allowedFields    = ['detinvoice', 'detbrgid', 'dethargajual', 'detdiskon', 'detjml', 'detsubtotal', 'detcabang'];


    public function tampilDataDetail($invoice)
    {
        return $this->table('barangkeluar_detail')
            ->join('barang', 'detbrgid=brgid')
            ->join('satuan', 'brgsatid=satid')
            ->where('detinvoice', $invoice)->get();
    }

    function ambilTotalHarga($noinvoice)
    {
        $query = $this->table('barangkeluar_detail')->join('barang', 'detbrgid=brgid')->getWhere([
            'detinvoice' => $noinvoice
        ]);

        $totalHarga = 0;
        foreach ($query->getResultArray() as $r) :
            $totalHarga += $r['detsubtotal'];
        endforeach;
        return $totalHarga;
    }


    public function cariItemBarangDetail($iddetail)
    {
        return $this->table('barangkeluar_detail')
            ->join('barang', 'brgid=detbrgid', 'left')
            ->join('satuan', 'brgsatid=satid')
            ->where('iddetail', $iddetail)
            ->get();
    }




    public function cekItemBarangDetail($noinvoice, $brgid)
    {
        return $this->table('barangkeluar_detail')
            ->join('barang', 'brgid=detbrgid', 'left')
            ->join('satuan', 'brgsatid=satid')
            ->where('detinvoice', $noinvoice)
            ->where('detbrgid', $brgid)
            ->get();
    }


    public function cekItemKeluarDetail($noinvoice, $kodebarang)
    {
        return $this->table('barangkeluar_detail')
            ->join('barang', 'detbrgid=brgid')
            ->join('satuan', 'brgsatid=satid')
            ->where('detinvoice', $noinvoice)
            ->where('detbrgid', $kodebarang)
            ->get();
    }

    public function dataBarangKeluar()
    {
        return $this->table('barangkeluar_detail')->join('barang', 'brgid=detbrgid', 'left')->groupby('barangkeluar_detail.detbrgid')->get();
    }


    public function downloadLaporanKasir($userid, $tglawal, $tglakhir)
    {
        return $this->table('barangkeluar_detail')->join('barang', 'detbrgid=brgid')->join('barangkeluar', 'invoice=detinvoice')->join('user', 'userid=invuserid')->where('invuserid', $userid)->where('tglinvoice', $tglawal)->get();
    }
}

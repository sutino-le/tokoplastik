<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelBarangKeluarTemp extends Model
{
    protected $table            = 'barangkeluar_temp';
    protected $primaryKey       = 'iddetail';
    protected $allowedFields    = ['detinvoice', 'detbrgid', 'dethargajual', 'detdiskon', 'detjml', 'detsubtotal', 'detcabang'];


    public function tampilDataTemp($noinvoice)
    {
        return $this->table('barangkeluar_temp')->join('barang', 'detbrgid=brgid')->where('detinvoice', $noinvoice)->get();
    }


    public function cariItemBarangTemp($iddetail)
    {
        return $this->table('barangkeluar_temp')
            ->join('barang', 'brgid=detbrgid', 'left')
            ->join('satuan', 'brgsatid=satid')
            ->where('iddetail', $iddetail)
            ->get();
    }

    function ambilTotalHarga($noinvoice)
    {
        $query = $this->table('barangkeluar_temp')->join('barang', 'detbrgid=brgid')->getWhere([
            'detinvoice' => $noinvoice
        ]);

        $totalHarga = 0;
        foreach ($query->getResultArray() as $r) :
            $totalHarga += $r['detsubtotal'];
        endforeach;
        return $totalHarga;
    }


    public function cekItemKeluarTemp($noinvoice, $brgid)
    {
        return $this->table('barangkeluar_temp')->join('barang', 'detbrgid=brgid')->where('detinvoice', $noinvoice)->where('detbrgid', $brgid)->get();
    }
}

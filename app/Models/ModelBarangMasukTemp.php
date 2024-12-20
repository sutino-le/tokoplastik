<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelBarangMasukTemp extends Model
{
    protected $table            = 'barangmasuk_temp';
    protected $primaryKey       = 'iddetail';
    protected $allowedFields    = ['detfaktur', 'detbrgid', 'dethargamasuk', 'dethargajual', 'detjml', 'detsubtotal', 'detketerangan', 'detcabang'];


    public function tampilDataTemp($nofaktur)
    {
        return $this->table('barangmasuk_temp')->join('barang', 'detbrgid=brgid')->where('detfaktur', $nofaktur)->get();
    }


    public function cariItemBarangTemp($iddetail)
    {
        return $this->table('barangmasuk_temp')
            ->join('barang', 'detbrgid=brgid', 'left')
            ->where('iddetail', $iddetail)
            ->get();
    }
}

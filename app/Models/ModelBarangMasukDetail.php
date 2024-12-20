<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelBarangMasukDetail extends Model
{
    protected $table            = 'barangmasuk_detail';
    protected $primaryKey       = 'iddetail';
    protected $allowedFields    = ['detfaktur', 'detbrgid', 'dethargamasuk', 'dethargajual', 'detjml', 'detsubtotal', 'detketerangan', 'detcabang'];



    function ambilTotalHarga($nofaktur)
    {
        $query = $this->table('barangmasuk_detail')->join('barang', 'detbrgid=brgid')->getWhere([
            'detfaktur' => $nofaktur
        ]);

        $totalHarga = 0;
        foreach ($query->getResultArray() as $r) :
            $totalHarga += $r['detsubtotal'];
        endforeach;
        return $totalHarga;
    }

    public function tampilDataDetail($nofaktur)
    {
        return $this->table('barangmasuk_detail')->join('barang', 'detbrgid=brgid')
            ->join('satuan', 'brgsatid=satid')
            ->where('detfaktur', $nofaktur)->get();
    }

    public function dataBarangMasuk()
    {
        return $this->table('barangmasuk_detail')->join('barang', 'detbrgid=brgid', 'left')->groupby('barangmasuk_detail.detbrgid')->get();
    }


    public function downloadDataDetailBarangMasuk($brgkode, $tglawal, $tglakhir)
    {
        return $this->table('barangmasuk_detail')->join('barang', 'detbrgid=brgid', 'left')->join('barangmasuk', 'detfaktur=faktur', 'left')->join('suplier', 'idsup=supid', 'left')->where('detbrgid', $brgkode)->where('tglfaktur >=', $tglawal)->where('tglfaktur <=', $tglakhir)->where('detbrgid >=', $tglawal)->get();
    }
}

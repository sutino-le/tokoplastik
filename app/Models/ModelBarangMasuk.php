<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelBarangMasuk extends Model
{
    protected $table            = 'barangmasuk';
    protected $primaryKey       = 'faktur';
    protected $allowedFields    = ['faktur', 'tglfaktur', 'jenis', 'idsup', 'totalharga', 'jumlahuang', 'sisauang', 'bmuser'];




    public function noFaktur($tanggalSekarang)
    {
        return $this->table('barangmasuk')->select('max(faktur) as nofaktur')->where('tglfaktur', $tanggalSekarang)->get();
    }




    function totalPembelian()
    {
        $query = $this->table('barangmasuk')
            ->get();

        $totalPembelian = 0;
        foreach ($query->getResultArray() as $r) :
            $totalPembelian += $r['totalharga'];
        endforeach;
        return $totalPembelian;
    }
}

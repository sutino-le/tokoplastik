<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelStock extends Model
{
    protected $table = 'stock';
    protected $primaryKey = 'stock_id';
    protected $allowedFields = ['stock_brgid', 'stock_jumlah', 'stock_cabang'];

    public function cekBarang($brgid, $userCabang)
    {
        return $this->table('stock')
            ->where('stock_brgid', $brgid)
            ->where('stock_cabang', $userCabang)
            ->get();
    }

}

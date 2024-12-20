<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelSuplier extends Model
{
    protected $table            = 'suplier';
    protected $primaryKey       = 'supid';
    protected $allowedFields    = ['supnama', 'suptelp', 'supalamat', 'supnpwp', 'suprekening'];


    public function ambilDataTerakhir()
    {
        return $this->table('suplier')->limit(1)->orderBy('supid', 'Desc')->get();
    }
}

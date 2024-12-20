<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelCabang extends Model
{
    protected $table            = 'cabang';
    protected $primaryKey       = 'cabang_id';
    protected $allowedFields    = ['cabang_nama', 'cabang_alamat', 'cabang_alamatid', 'cabang_hp'];
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelKategori extends Model
{
    protected $table            = 'kategori';
    protected $primaryKey       = 'katid';
    protected $allowedFields    = [
        'katnama',
    ];

    // Dates
    protected $useTimestamps = false;



    public function dataKategori()
    {
        return $this->table('kategori')
            ->orderBy('katnama')
            ->get();
    }
}

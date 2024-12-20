<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelSatuan extends Model
{
    protected $table            = 'satuan';
    protected $primaryKey       = 'satid';
    protected $allowedFields    = [
        'satnama',
        'satlabel',
    ];

    // Dates
    protected $useTimestamps = false;

    public function dataSatuan()
    {
        return $this->table('satuan')
            ->orderBy('satnama')
            ->get();
    }
}

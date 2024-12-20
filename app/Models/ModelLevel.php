<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLevel extends Model
{
    protected $table            = 'level';
    protected $primaryKey       = 'levelid';
    protected $allowedFields    = ['levelnama'];


    // Dates
    protected $useTimestamps = false;

    public function dataLevel()
    {
        return $this->table('level')
            ->join('user', 'levelid=userlevel', 'left')
            ->groupBy('levelid', 'ASC')
            ->get();
    }
}

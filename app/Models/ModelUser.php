<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelUser extends Model
{
    protected $table            = 'user';
    protected $primaryKey       = 'userid';
    protected $allowedFields    = [
        'userid',
        'usernama',
        'useremail',
        'userhp',
        'useralamat',
        'useralamatid',
        'userstatus',
        'userpassword',
        'userlevel',
        'usercabang'
    ];


    // Dates
    protected $useTimestamps = false;

    public function dataUser()
    {
        return $this->table('user')
            ->join('level', 'userlevel=levelid', 'left')
            ->join('wilayah', 'useralamatid=id_wilayah', 'left')
            ->join('cabang', 'usercabang=cabang_id', 'left')
            ->get();
    }

    public function dataInvoice($userid)
    {
        return $this->table('user')
            ->join('level', 'userlevel=levelid', 'left')
            ->join('wilayah', 'useralamatid=id_wilayah', 'left')
            ->join('cabang', 'usercabang=cabang_id', 'left')
            ->where('userid', $userid)
            ->get();
    }
}

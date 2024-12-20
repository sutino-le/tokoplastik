<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class ModelBarangMasukPagination extends Model
{
    protected $table = "barangmasuk";
    protected $column_order = array(null, 'faktur', 'tglfaktur', 'idsup', null);
    protected $column_search = array('faktur', 'tglfaktur', 'idsup');
    protected $order = array('faktur' => 'ASC');
    protected $request;
    protected $db;
    protected $dt;

    function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
    }
    private function _get_datatables_query($idsup, $tglawal, $tglakhir)
    {
        if ($tglawal == '' && $tglakhir == '') {
            $this->dt = $this->db->table($this->table)->join('suplier', 'idsup=supid', 'left');
        } else {
            $this->dt = $this->db->table($this->table)->join('suplier', 'idsup=supid', 'left')->like('idsup', $idsup)->where('tglfaktur >=', $tglawal)->where('tglfaktur <=', $tglakhir);
        }
        $i = 0;
        foreach ($this->column_search as $item) {
            if ($this->request->getPost('search')['value']) {
                if ($i === 0) {
                    $this->dt->groupStart();
                    $this->dt->like($item, $this->request->getPost('search')['value']);
                } else {
                    $this->dt->orLike($item, $this->request->getPost('search')['value']);
                }
                if (count($this->column_search) - 1 == $i)
                    $this->dt->groupEnd();
            }
            $i++;
        }

        if ($this->request->getPost('order')) {
            $this->dt->orderBy($this->column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->dt->orderBy(key($order), $order[key($order)]);
        }
    }
    function get_datatables($idsup, $tglawal, $tglakhir)
    {
        $this->_get_datatables_query($idsup, $tglawal, $tglakhir);
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }
    function count_filtered($idsup, $tglawal, $tglakhir)
    {
        $this->_get_datatables_query($idsup, $tglawal, $tglakhir);
        return $this->dt->countAllResults();
    }
    public function count_all($idsup, $tglawal, $tglakhir)
    {
        if ($tglawal == '' && $tglakhir == '') {
            $tbl_storage = $this->db->table($this->table)->join('suplier', 'idsup=supid', 'left');
        } else {
            $tbl_storage = $this->db->table($this->table)->join('suplier', 'idsup=supid', 'left')->like('idsup', $idsup)->where('tglfaktur >=', $tglawal)->where('tglfaktur <=', $tglakhir);
        }

        return $tbl_storage->countAllResults();
    }
}

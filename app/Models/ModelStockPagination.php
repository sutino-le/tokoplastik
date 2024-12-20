<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class ModelStockPagination extends Model
{
    protected $table = "stock";
    protected $column_order = array(null, 'stock_cabang', 'stock_brgid', 'stock_jumlah', null);
    protected $column_search = array('stock_cabang', 'stock_brgid', 'stock_jumlah', 'brgnama');
    protected $order = array('stock_cabang' => 'ASC');
    protected $request;
    protected $db;
    protected $dt;

    public function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
    }
    private function _get_datatables_query($cabang_id)
    {
        if ($cabang_id == "") {
            $this->dt = $this->db->table($this->table)->join('barang', 'brgid=stock_brgid', 'left')->join('cabang', 'cabang_id=stock_cabang', 'left');
        } else {
            $this->dt = $this->db->table($this->table)->join('barang', 'brgid=stock_brgid', 'left')->join('cabang', 'cabang_id=stock_cabang', 'left')->where('stock_cabang', $cabang_id);
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
                if (count($this->column_search) - 1 == $i) {
                    $this->dt->groupEnd();
                }

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
    public function get_datatables($cabang_id)
    {
        $this->_get_datatables_query($cabang_id);
        if ($this->request->getPost('length') != -1) {
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        }

        $query = $this->dt->get();
        return $query->getResult();
    }
    public function count_filtered($cabang_id)
    {
        $this->_get_datatables_query($cabang_id);
        return $this->dt->countAllResults();
    }
    public function count_all($cabang_id)
    {
        if ($cabang_id == "") {
            $tbl_storage = $this->db->table($this->table)->join('barang', 'brgid=stock_brgid', 'left')->join('cabang', 'cabang_id=stock_cabang', 'left');
        } else {
            $tbl_storage = $this->db->table($this->table)->join('barang', 'brgid=stock_brgid', 'left')->join('cabang', 'cabang_id=stock_cabang', 'left')->where('stock_cabang', $cabang_id);
        }

        return $tbl_storage->countAllResults();
    }
}

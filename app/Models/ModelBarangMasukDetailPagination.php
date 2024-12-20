<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class ModelBarangMasukDetailPagination extends Model
{
    protected $table = "barangmasuk_detail";
    protected $column_order = array(null, 'brgnama', 'tglfaktur', 'detjml', 'detsubtotal', 'supnama', null);
    protected $column_search = array('brgnama', 'tglfaktur', 'detjml');
    protected $order = array('brgnama' => 'ASC');
    protected $request;
    protected $db;
    protected $dt;

    function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
    }
    private function _get_datatables_query($brgid, $tglawal, $tglakhir)
    {
        if ($tglawal == '' && $tglakhir == '') {
            $this->dt = $this->db->table($this->table)->join('barang', 'detbrgid=brgid', 'left')->join('barangmasuk', 'detfaktur=faktur', 'left')->join('suplier', 'idsup=supid', 'left');
        } else  if ($tglawal == $tglakhir) {
            $this->dt = $this->db->table($this->table)->join('barang', 'detbrgid=brgid', 'left')->join('barangmasuk', 'detfaktur=faktur', 'left')->join('suplier', 'idsup=supid', 'left')->where('detbrgid', $brgid)->where('tglfaktur', $tglawal);
        } else {
            $this->dt = $this->db->table($this->table)->join('barang', 'detbrgid=brgid', 'left')->join('barangmasuk', 'detfaktur=faktur', 'left')->join('suplier', 'idsup=supid', 'left')->where('detbrgid', $brgid)->where('tglfaktur >=', $tglawal)->where('tglfaktur <=', $tglakhir);
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
    function get_datatables($brgid, $tglawal, $tglakhir)
    {
        $this->_get_datatables_query($brgid, $tglawal, $tglakhir);
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }
    function count_filtered($brgid, $tglawal, $tglakhir)
    {
        $this->_get_datatables_query($brgid, $tglawal, $tglakhir);
        return $this->dt->countAllResults();
    }
    public function count_all($brgid, $tglawal, $tglakhir)
    {
        if ($tglawal == '' && $tglakhir == '') {
            $tbl_storage = $this->db->table($this->table)->join('barang', 'detbrgid=brgid', 'left')->join('barangmasuk', 'detfaktur=faktur', 'left')->join('suplier', 'idsup=supid', 'left');
        } else if ($tglawal == $tglakhir) {
            $tbl_storage = $this->db->table($this->table)->join('barang', 'detbrgid=brgid', 'left')->join('barangmasuk', 'detfaktur=faktur', 'left')->join('suplier', 'idsup=supid', 'left')->where('detbrgid', $brgid)->where('tglfaktur', $tglawal);
        } else {
            $tbl_storage = $this->db->table($this->table)->join('barang', 'detbrgid=brgid', 'left')->join('barangmasuk', 'detfaktur=faktur', 'left')->join('suplier', 'idsup=supid', 'left')->where('detbrgid', $brgid)->where('tglfaktur >=', $tglawal)->where('tglfaktur <=', $tglakhir);
        }

        return $tbl_storage->countAllResults();
    }
}

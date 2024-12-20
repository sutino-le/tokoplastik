<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelBarang extends Model
{
    protected $table            = 'barang';
    protected $primaryKey       = 'brgid';
    protected $allowedFields    = ['brgbarcode', 'brgnama', 'brgkatid', 'brgmodal', 'brgsatid', 'brgsatisi', 'brgharga', 'brggambar'];


    public function cekBarcode($barcode)
    {
        return $this->table('barang')
            ->where('brgbarcode', $barcode)
            ->get();
    }


    public function detailBarang($brgid)
    {
        return $this->table('barang')
            ->join('kategori', 'brgkatid=katid')
            ->join('satuan', 'brgsatid=satid')
            ->where('brgid', $brgid)
            ->get();
    }

    public function cekSatuanHarga($brgid, $satuanharga)
    {
        return $this->table('barang')
            ->where('brgid', $brgid)
            ->where('brgharga', $satuanharga)
            ->get()->getRowArray(); // Ambil satu baris data sebagai array
    }
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelBarangTambahHarga extends Model
{
    protected $table            = 'barang_tambahharga';
    protected $primaryKey       = 'bth_id';
    protected $allowedFields    = ['bth_brgid', 'bth_barcode', 'bth_satuan', 'bth_isi_min', 'bth_isi_max', 'bth_konversi_isi_min', 'bth_harga'];



    public function dataTambahan($brgid)
    {
        return $this->table('barang_tambahharga')
            ->join('barang', 'bth_brgid=brgid', 'left')
            ->join('kategori', 'brgkatid=katid', 'left')
            ->join('satuan', 'bth_satuan=satid', 'left')
            ->where('bth_brgid', $brgid)
            ->orderBy('bth_id', 'ASC')
            ->get();
    }

    public function dataTambahanDetail($brgid)
    {
        return $this->table('barang_tambahharga')
            ->join('barang', 'bth_brgid=brgid', 'left')
            ->join('kategori', 'brgkatid=katid', 'left')
            ->join('satuan', 'bth_satuan=satid', 'left')
            ->where('bth_brgid', $brgid)
            ->groupBy('bth_id')
            ->get();
    }

    public function cekBarcodeTerakhir()
    {
        return $this->table('barang_tambahharga')
            ->orderBy('bth_barcode', 'DESC')
            ->get();
    }



    public function cekBarcode($barcode)
    {
        return $this->table('barang_tambahharga')
            ->where('bth_barcode', $barcode)
            ->get();
    }

    public function cekHarga($brgid, $totaljumlah)
    {
        return $this->table('barang_tambahharga')
            ->where('bth_brgid', $brgid)
            ->where('bth_konversi_isi_min <=', $totaljumlah) // Batas bawah
            ->orderBy('bth_konversi_isi_min', 'DESC') // Mengambil nilai terbesar <= $totaljumlah
            ->get(1) // Ambil satu data saja
            ->getRowArray(); // Kembalikan sebagai array
    }



    public function cekSatuanGrosir($brgid, $satuanharga)
    {
        return $this->table('barang_tambahharga')
            ->where('bth_brgid', $brgid)
            ->where('bth_harga', $satuanharga)
            ->get()->getRowArray(); // Ambil satu baris data sebagai array
    }
}

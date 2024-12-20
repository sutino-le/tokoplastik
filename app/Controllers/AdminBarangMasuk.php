<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelBarang;
use App\Models\ModelBarangMasuk;
use App\Models\ModelBarangMasukDetail;
use App\Models\ModelBarangMasukDetailPagination;
use App\Models\ModelBarangMasukPagination;
use App\Models\ModelBarangMasukTemp;
use App\Models\ModelBarangPagination;
use App\Models\ModelStock;
use App\Models\ModelSuplier;
use App\Models\ModelSuplierPagination;
use App\Models\ModelUser;
use Config\Services;

class AdminBarangMasuk extends BaseController
{
    public function index()
    {
        $modelSuplier = new ModelSuplier();

        $data = [
            'menu' => 'purchasing',
            'submenu' => 'barangmasuk',
            'title' => 'Data Barang Masuk',
            'tampilsuplier' => $modelSuplier->findAll(),

        ];
        return view('admin/barangmasuk/bm_view', $data);
    }

    // list data barang masuk
    public function listDataBarangMasuk()
    {

        $idsup = $this->request->getPost('idsup');
        $tglawal = $this->request->getPost('tglawal');
        $tglakhir = $this->request->getPost('tglakhir');

        $request = Services::request();
        $datamodel = new ModelBarangMasukPagination($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables($idsup, $tglawal, $tglakhir);
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $tombolCetak = "<button type=\"button\" class=\"btn btn-sm btn-info\" onclick=\"cetak('" . $list->faktur . "')\" title=\"Cetak\"><i class='fas fa-print'></i></button>";
                $tombolHapus = "<button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"hapus('" . $list->faktur . "')\" title=\"Hapus\"><i class='fas fa-trash-alt'></i></button>";
                $tombolEdit = "<button type=\"button\" class=\"btn btn-sm btn-primary\" onclick=\"edit('" . $list->faktur . "')\" title=\"Edit\"><i class='fas fa-edit'></i></button>";

                $row[] = $no;
                $row[] = $list->faktur;
                $row[] = $list->tglfaktur;
                $row[] = $list->supnama;
                $row[] = number_format($list->totalharga, 0, ",", ".");
                $row[] = "<div style=\"display: flex; gap: 5px;\">" . $tombolCetak . ' ' . $tombolHapus . ' ' . $tombolEdit . "</div>";
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $datamodel->count_all($idsup, $tglawal, $tglakhir),
                "recordsFiltered" => $datamodel->count_filtered($idsup, $tglawal, $tglakhir),
                "data" => $data,
            ];
            echo json_encode($output);
        }
    }

    // buat nomor faktur
    private function buatFakturBarangMasuk()
    {
        $usercabang = session()->usercabang;
        $tanggalSekarang = date("Y-m-d");
        $barangMasuk = new ModelBarangMasuk();

        $hasil = $barangMasuk->noFaktur($tanggalSekarang)->getRowArray();
        $data = $hasil['nofaktur'];

        if ($data == "") {
            $nomorterakhir = '0000';
        } else {
            $nomorterakhir = $data;
        }

        $lastNoUrut = substr($nomorterakhir, -4);
        // nomor urut ditambah 1
        $nextNoUrut = intval($lastNoUrut) + 1;
        // membuat format nomor transaksi berikutnya
        $noFaktur = $usercabang . date('ymd', strtotime($tanggalSekarang)) . sprintf('%04s', $nextNoUrut);
        return $noFaktur;
    }

    // buatNoFakturBarangMasuk
    public function buatNoFakturBarangMasuk()
    {
        $usercabang = session()->usercabang;
        $tanggalSekarang = $this->request->getPost('tanggal');
        $barangMasuk = new ModelBarangMasuk();

        $hasil = $barangMasuk->noFaktur($tanggalSekarang)->getRowArray();
        $data = $hasil['nofaktur'];

        if ($data == "") {
            $nomorterakhir = '0000';
        } else {
            $nomorterakhir = $data;
        }

        $lastNoUrut = substr($nomorterakhir, -4);
        // nomor urut ditambah 1
        $nextNoUrut = intval($lastNoUrut) + 1;
        // membuat format nomor transaksi berikutnya
        $noFaktur = $usercabang . date('ymd', strtotime($tanggalSekarang)) . sprintf('%04s', $nextNoUrut);

        $json = [
            'nofaktur' => $noFaktur,
        ];

        echo json_encode($json);
    }

    // barangMasukTambah
    public function barangMasukTambah()
    {

        $data = [
            'menu' => 'keluarmasuk',
            'submenu' => 'barangmasuk',
            'title' => 'Input Barang Masuk',
            'nofaktur' => $this->buatFakturBarangMasuk(),

        ];
        return view('admin/barangmasuk/bm_input', $data);
    }

    // modal cari supplier
    public function modalCariDataSuplier()
    {
        if ($this->request->isAJAX()) {
            $json = [
                'data' => view('admin/barangmasuk/modalcarisuplier'),
            ];

            echo json_encode($json);
        } else {
            exit('Maaf, gagal menampilkan data');
        }
    }

    // list data supplier
    public function listCariDataSuplier()
    {
        $request = Services::request();
        $datamodel = new ModelSuplierPagination($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $tombolPilih = "<button type=\"button\" class=\"btn btn-sm btn-info\" onclick=\"pilih('" . $list->supid . "', '" . $list->supnama . "')\" title=\"Pilih\"><i class='fas fa-hand-point-up'></i></button>";
                $tombolHapus = "<button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"hapus('" . $list->supid . "', '" . $list->supnama . "')\" title=\"Hapus\"><i class='fas fa-trash-alt'></i></button>";

                $row[] = $no;
                $row[] = $list->supnama;
                $row[] = $list->suptelp;
                $row[] = $list->supalamat;
                $row[] = "<div style=\"display: flex; gap: 5px;\">" . $tombolPilih . " " . $tombolHapus . "</div>";
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $datamodel->count_all(),
                "recordsFiltered" => $datamodel->count_filtered(),
                "data" => $data,
            ];
            echo json_encode($output);
        }
    }

    // modal cari barang
    public function modalCariBarang()
    {
        if ($this->request->isAJAX()) {
            $json = [
                'data' => view('admin/barangmasuk/modalcaribarang'),
            ];

            echo json_encode($json);
        }
    }

    // list cari barang
    public function listCariDataBarang()
    {
        $request = Services::request();
        $datamodel = new ModelBarangPagination($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $tombolPilih = "<button type=\"button\" class=\"btn btn-sm btn-info\" onclick=\"pilih('" . $list->brgid . "')\" title=\"Pilih\"><i class='fas fa-hand-point-up'></i></button>";

                $row[] = $no;
                $row[] = $list->brgid;
                $row[] = $list->brgnama;
                $row[] = number_format($list->brgharga, 0, ",", ".");
                $row[] = $tombolPilih;
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $datamodel->count_all(),
                "recordsFiltered" => $datamodel->count_filtered(),
                "data" => $data,
            ];
            echo json_encode($output);
        }
    }

    // ambil data barang
    public function ambilDataBarang()
    {
        if ($this->request->isAJAX()) {
            $kodebarang = $this->request->getPost('kodebarang');

            $modelBarang = new ModelBarang();
            $cekData = $modelBarang->find($kodebarang);

            if ($cekData == null) {
                $json = [
                    'error' => 'Maaf, Data barang tidak ditemukan',
                ];
            } else {
                $data = [
                    'namabarang' => $cekData['brgnama'],
                    'hargajual' => number_format($cekData['brgharga']),
                ];

                $json = [
                    'sukses' => $data,
                ];
            }

            echo json_encode($json);
        } else {
            exit('Maaf, gagal menampilkan data');
        }
    }

    // simpan item barang masuk temp
    public function simpanItemBarangMasuk()
    {
        if ($this->request->isAJAX()) {

            $userid = session()->userid;
            $modelUser = new ModelUser();
            $cekModelUser = $modelUser->find($userid);
            $userCabang = $cekModelUser['usercabang'];

            $nofaktur = $this->request->getPost('nofaktur');
            $brgid = $this->request->getPost('kodebarang');
            $namabarang = $this->request->getPost('namabarang');
            $hargabeli = str_replace(".", "", $this->request->getPost('hargabeli'));
            $hargajual = str_replace(".", "", $this->request->getPost('hargajual'));
            $jml = $this->request->getPost('jml');
            $detketerangan = $this->request->getPost('detketerangan');

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'kodebarang' => [
                    'label' => 'Kode Barang',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
                'hargabeli' => [
                    'label' => 'Harga Beli',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
                'detketerangan' => [
                    'label' => 'Keterangan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
            ]);

            if (!$valid) {
                $json = [
                    'error' => [
                        'errKodeBarang' => $validation->getError('kodebarang'),
                        'errHargaBeli' => $validation->getError('hargabeli'),
                        'errKeterangan' => $validation->getError('detketerangan'),
                    ],
                ];
            } else {

                $modelBarangMasukTemp = new ModelBarangMasukTemp();

                $modelBarangMasukTemp->insert([
                    'detfaktur' => $nofaktur,
                    'detbrgid' => $brgid,
                    'dethargamasuk' => $hargabeli,
                    'dethargajual' => $hargajual,
                    'detjml' => $jml,
                    'detsubtotal' => intval($jml) * intval($hargabeli),
                    'detketerangan' => $detketerangan,
                    'detcabang' => $userCabang,
                ]);

                if ($modelBarangMasukTemp) {

                    $modelStock = new ModelStock();
                    $cekBarang = $modelStock->cekBarang($brgid, $userCabang)->getRowArray();

                    if (empty($cekBarang)) {
                        $modelStock->insert([
                            'stock_brgid' => $brgid,
                            'stock_jumlah' => 0,
                            'stock_cabang' => $userCabang,
                        ]);

                    }
                }

                $json = [
                    'sukses' => 'Item berhasil ditambahkan',
                ];
            }

            echo json_encode($json);
        }
    }

    // tampil data temp
    public function tampilDataTempBarangMasuk()
    {
        if ($this->request->isAJAX()) {
            $nofaktur = $this->request->getPost('nofaktur');

            $modelBarangMasukTemp = new ModelBarangMasukTemp();
            $dataTemp = $modelBarangMasukTemp->tampilDataTemp($nofaktur);

            $data = [
                'tampildata' => $dataTemp,
            ];

            $json = [
                'data' => view('admin/barangmasuk/datatemp', $data),
            ];

            echo json_encode($json);
        } else {
            exit('Maaf, gagal menampilkan data');
        }
    }

    // modal edit qty item data temp
    public function modalEditItemBarangMasuk($iddetail)
    {
        if ($this->request->isAJAX()) {

            $modelBarangMasukTemp = new ModelBarangMasukTemp();
            $cekData = $modelBarangMasukTemp->cariItemBarangTemp($iddetail)->getRowArray();

            $array = [
                'iddetail' => $cekData['iddetail'],
                'brgnama' => $cekData['brgnama'],
                'dethargamasuk' => $cekData['dethargamasuk'],
            ];

            $json = [
                'data' => view('admin/barangmasuk/modaledititemtemp', $array),
            ];

            echo json_encode($json);
        }
    }

    // edit qty item simpan
    public function modalEditItemBarangMasukSimpan()
    {
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'editjml' => [
                    'rules' => 'required',
                    'label' => 'Jumlah',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
            ]);

            if (!$valid) {
                $json = [
                    'error' => [
                        'errJumlah' => $validation->getError('editjml'),
                    ],
                ];
            } else {

                $editiddetail = $this->request->getPost('editiddetail');
                $editjml = $this->request->getPost('editjml');
                $dethargamasuk = $this->request->getPost('dethargamasuk');

                $modelBarangMasukTemp = new ModelBarangMasukTemp();

                $modelBarangMasukTemp->update($editiddetail, [
                    'detjml' => $editjml,
                    'detsubtotal' => intval($editjml) * intval($dethargamasuk),
                ]);

                $json = [
                    'sukses' => 'Data berhasil disimpan',
                ];
            }

            echo json_encode($json);
        }
    }

    // Hapus item barang masuk dari data temp
    public function hapusItemBarangMasukTemp()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('iddetail');
            $modelBarangMasukTemp = new ModelBarangMasukTemp();
            $modelBarangMasukTemp->delete($id);

            $json = [
                'sukses' => 'Item berhasil dihapus',
            ];

            echo json_encode($json);
        }
    }

    // modal pembayaran atau selesai transaksi
    public function modalPembayaranBarangMasuk()
    {
        if ($this->request->isAJAX()) {
            $nofaktur = $this->request->getPost('nofaktur');
            $tglfaktur = $this->request->getPost('tglfaktur');
            $jenis = $this->request->getPost('jenis');
            $idsuplier = $this->request->getPost('idsuplier');
            $totalharga = $this->request->getPost('totalharga');

            $modelTemp = new ModelBarangMasukTemp();

            $cekdata = $modelTemp->tampilDataTemp($nofaktur);

            if ($cekdata->getNumRows() > 0) {
                $data = [
                    'nofaktur' => $nofaktur,
                    'tglfaktur' => $tglfaktur,
                    'jenis' => $jenis,
                    'idsuplier' => $idsuplier,
                    'totalharga' => $totalharga,
                ];

                $json = [
                    'data' => view('admin/barangmasuk/modalpembayaran', $data),
                ];
            } else {
                $json = [
                    'error' => 'Maaf, item belum ada',
                ];
            }

            echo json_encode($json);
        }
    }

    // simpan pembayaran
    public function modalPembayaranBarangMasukSimpan()
    {
        if ($this->request->isAJAX()) {
            $bmuser = session()->userid;
            $nofaktur = $this->request->getPost('nofaktur');
            $tglfaktur = $this->request->getPost('tglfaktur');
            $jenis = $this->request->getPost('jenis');
            $idsuplier = $this->request->getPost('idsuplier');
            $totalbayar = str_replace(".", "", $this->request->getPost('totalbayar'));
            $jumlahuang = str_replace(".", "", $this->request->getPost('jumlahuang'));
            $sisauang = str_replace(".", "", $this->request->getPost('sisauang'));

            $ModelBarangMasuk = new ModelBarangMasuk();

            //simpan ke table barang keluar
            $ModelBarangMasuk->insert([
                'faktur' => $nofaktur,
                'tglfaktur' => $tglfaktur,
                'jenis' => $jenis,
                'idsup' => $idsuplier,
                'totalharga' => $totalbayar,
                'jumlahuang' => $jumlahuang,
                'sisauang' => $sisauang,
                'bmuser' => $bmuser,
            ]);

            $modelTemp = new ModelBarangMasukTemp();
            $dataTemp = $modelTemp->getWhere(['detfaktur' => $nofaktur]);

            $fieldDetail = [];
            foreach ($dataTemp->getResultArray() as $row) {
                $fieldDetail[] = [
                    'detfaktur' => $row['detfaktur'],
                    'detbrgid' => $row['detbrgid'],
                    'dethargamasuk' => $row['dethargamasuk'],
                    'dethargajual' => $row['dethargajual'],
                    'detjml' => $row['detjml'],
                    'detsubtotal' => $row['detsubtotal'],
                    'detketerangan' => $row['detketerangan'],
                    'detcabang' => $row['detcabang'],
                ];
            }

            $modelDetail = new ModelBarangMasukDetail();
            $modelDetail->insertBatch($fieldDetail);

            // hapus temp barang masuk berdasarkan faktur
            $modelTemp->where(['detfaktur' => $nofaktur]);
            $modelTemp->delete();

            $json = [
                'sukses' => 'Transaksi berhasil disimpan',
                'cetakfaktur' => site_url('cetakfaktur/' . $nofaktur),
            ];

            echo json_encode($json);
        }
    }

    // cetakfaktur
    public function cetakFaktur($faktur)
    {
        $modelBarangMasuk = new ModelBarangMasuk();
        $modelDetail = new ModelBarangMasukDetail();
        $ModelSuplier = new ModelSuplier();

        $cekData = $modelBarangMasuk->find($faktur);
        $dataSuplier = $ModelSuplier->find($cekData['idsup']);

        $namaSuplier = ($dataSuplier != null) ? $dataSuplier['supnama'] : '-';
        if ($cekData != null) {
            $data = [
                'faktur' => $faktur,
                'tanggal' => $cekData['tglfaktur'],
                'namasuplier' => $namaSuplier,
                'jumlahuang' => $cekData['jumlahuang'],
                'sisauang' => $cekData['sisauang'],
                'jenispo' => $cekData['jenis'],
                'detailbarang' => $modelDetail->tampilDataDetail($faktur),
            ];

            return view('admin/barangmasuk/cetakfaktur', $data);
        } else {
            return redirect()->to(site_url('barangMasukTambah'));
        }
    }

    // hapus data transaksi
    public function hapusTransaksiBarangMasuk()
    {
        if ($this->request->isAJAX()) {
            $faktur = $this->request->getPost('faktur');

            $modelDetail = new ModelBarangMasukDetail();
            $modelBarangMasuk = new ModelBarangMasuk();

            // hapus detail
            $modelDetail->where(['detfaktur' => $faktur]);
            $modelDetail->delete();
            $modelBarangMasuk->delete($faktur);

            $json = [
                'sukses' => 'Barang keluar berhasil dihapus',
            ];

            echo json_encode($json);
        }
    }

    // edit barang masuk
    public function barangMasukEdit($faktur)
    {
        $modelBarangMasuk = new ModelBarangMasuk();
        $rowData = $modelBarangMasuk->find($faktur);

        $modelSuplier = new ModelSuplier();
        $rowSuplier = $modelSuplier->find($rowData['idsup']);

        if ($rowData['idsup'] == 0) {
            $suplier = '';
        } else {
            $suplier = $rowSuplier['supnama'];
        }

        $data = [
            'menu' => 'keluarmasuk',
            'submenu' => 'barangmasuk',
            'title' => 'Edit Barang Masuk',
            'nofaktur' => $faktur,
            'tanggal' => $rowData['tglfaktur'],
            'namasuplier' => $suplier,
        ];

        return view('admin/barangmasuk/bm_edit', $data);
    }

    // ambil total harga detail
    public function ambilTotalHargaBarangMasuk()
    {
        if ($this->request->isAJAX()) {
            $nofaktur = $this->request->getPost('nofaktur');

            $modelDetail = new ModelBarangMasukDetail();

            $totalHarga = $modelDetail->ambilTotalHarga($nofaktur);

            $json = [
                'totalharga' => "Rp. " . number_format($totalHarga, 0, ",", "."),
            ];

            echo json_encode($json);
        }
    }

    // tampil data deteail
    public function tampilDataDetailBarangMasuk()
    {
        if ($this->request->isAJAX()) {
            $nofaktur = $this->request->getPost('nofaktur');

            $modelDetailBarangMasuk = new ModelBarangMasukDetail();
            $dataDetail = $modelDetailBarangMasuk->tampilDataDetail($nofaktur);

            $data = [
                'tampildata' => $dataDetail,
            ];

            $json = [
                'data' => view('admin/barangmasuk/datadetail', $data),
            ];

            echo json_encode($json);
        } else {
            exit('Maaf, gagal menampilkan data');
        }
    }

    // hapus item detail
    public function hapusItemDetailBarangMasuk()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('iddetail');
            $modelBarangMasukDetail = new ModelBarangMasukDetail();
            $modelBarangMasuk = new ModelBarangMasuk();

            $rowData = $modelBarangMasukDetail->find($id);
            $noFaktur = $rowData['detfaktur'];

            $modelBarangMasukDetail->delete($id);

            $totalHarga = $modelBarangMasukDetail->ambilTotalHarga($noFaktur);

            //Lakukan update total di tabel pembelian
            $modelBarangMasuk->update($noFaktur, [
                'totalharga' => $totalHarga,
            ]);

            $json = [
                'sukses' => 'Item berhasil dihapus',
            ];

            echo json_encode($json);
        }
    }

    // simpan edit item barang masuk detail
    public function editItemBarangMasuk()
    {
        if ($this->request->isAJAX()) {
            $iddetail = $this->request->getPost('iddetail');
            $jml = $this->request->getPost('jml');
            $hargabeli = str_replace(".", "", $this->request->getPost('hargabeli'));
            $detketerangan = $this->request->getPost('detketerangan');

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'iddetail' => [
                    'label' => 'Kode Barang',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
                'hargabeli' => [
                    'label' => 'Harga Beli',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
                'detketerangan' => [
                    'label' => 'Keterangan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
            ]);

            if (!$valid) {
                $json = [
                    'error' => [
                        'errIdDetail' => $validation->getError('iddetail'),
                        'errHargaBeli' => $validation->getError('hargabeli'),
                        'errKeterangan' => $validation->getError('detketerangan'),
                    ],
                ];
            } else {

                $modelDetailBarangMasuk = new ModelBarangMasukDetail();
                $modelBarangMasuk = new ModelBarangMasuk();

                $rowData = $modelDetailBarangMasuk->find($iddetail);
                $noFaktur = $rowData['detfaktur'];

                $jumlah = (float) $jml;
                $harga = (float) $hargabeli;

                //lakukan update pada detail
                $modelDetailBarangMasuk->update($iddetail, [
                    'dethargamasuk' => $hargabeli,
                    'detjml' => $jml,
                    'detsubtotal' => $harga * $jumlah,
                    'detketerangan' => $detketerangan,
                ]);

                //ambil total harga
                $totalHarga = $modelDetailBarangMasuk->ambilTotalHarga($noFaktur);
                //update pembelian
                $modelBarangMasuk->update($noFaktur, [
                    'totalharga' => $totalHarga,
                ]);

                $json = [
                    'sukses' => 'Item berhasil di update',
                ];
            }

            echo json_encode($json);
        }
    }

    // simpan item barang masuk detail
    public function simpanDetailBarangMasuk()
    {
        if ($this->request->isAJAX()) {
            if (session()->usercabang == "") {
                $usercabang = '';
            } else {
                $usercabang = session()->usercabang;
            }
            $nofaktur = $this->request->getPost('nofaktur');
            $kodebarang = $this->request->getPost('kodebarang');
            $namabarang = $this->request->getPost('namabarang');
            $hargabeli = str_replace(".", "", $this->request->getPost('hargabeli'));
            $hargajual = str_replace(".", "", $this->request->getPost('hargajual'));
            $jml = $this->request->getPost('jml');
            $detketerangan = $this->request->getPost('detketerangan');

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'kodebarang' => [
                    'label' => 'Kode Barang',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
                'hargabeli' => [
                    'label' => 'Harga Beli',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
                'detketerangan' => [
                    'label' => 'Keterangan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
            ]);

            if (!$valid) {
                $json = [
                    'error' => [
                        'errKodeBarang' => $validation->getError('kodebarang'),
                        'errHargaBeli' => $validation->getError('hargabeli'),
                        'errKeterangan' => $validation->getError('detketerangan'),
                    ],
                ];
            } else {

                $jumlah = (float) $jml;
                $harga = (float) $hargabeli;

                $modelBarangMasuk = new ModelBarangMasuk();
                $modelBarangMasukDetail = new ModelBarangMasukDetail();

                //ambil total harga
                $totalHarga = $modelBarangMasukDetail->ambilTotalHarga($nofaktur);
                //update pembelian

                $modelBarangMasukDetail->insert([
                    'detfaktur' => $nofaktur,
                    'detbrgid' => $kodebarang,
                    'dethargamasuk' => $hargabeli,
                    'dethargajual' => $hargajual,
                    'detjml' => $jml,
                    'detsubtotal' => $jumlah * $harga,
                    'detketerangan' => $detketerangan,
                    'detcabang' => $usercabang,
                ]);

                if ($modelBarangMasukDetail) {
                    $modelBarangMasuk->update($nofaktur, [
                        'totalharga' => $totalHarga,
                    ]);

                    $json = [
                        'sukses' => 'Item berhasil ditambahkan',
                    ];
                }
            }

            echo json_encode($json);
        }
    }

    // data detail barang masuk
    public function databarangmasuk()
    {

        $modelBarangMasuk = new ModelBarangMasukDetail();
        $data = [
            'menu' => 'purchasing',
            'submenu' => 'databarangmasuk',
            'title' => 'Data Detail Barang Masuk',
            'tampilBarangMasuk' => $modelBarangMasuk->dataBarangMasuk(),
        ];
        return view('admin/barangmasuk/bm_detail', $data);
    }

    // list data detail barang masuk
    public function detailListDataBarangMasuk()
    {

        $brgid = $this->request->getPost('brgid');
        $tglawal = $this->request->getPost('tglawal');
        $tglakhir = $this->request->getPost('tglakhir');

        $request = Services::request();
        $datamodel = new ModelBarangMasukDetailPagination($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables($brgid, $tglawal, $tglakhir);
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                // $tombolCetak = "<button type=\"button\" class=\"btn btn-sm btn-info\" onclick=\"cetak('" . $list->iddetail . "')\" title=\"Cetak\"><i class='fas fa-print'></i></button>";
                // $tombolHapus = "<button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"hapus('" . $list->iddetail . "')\" title=\"Hapus\"><i class='fas fa-trash-alt'></i></button>";
                // $tombolEdit = "<button type=\"button\" class=\"btn btn-sm btn-primary\" onclick=\"edit('" . $list->iddetail . "')\" title=\"Edit\"><i class='fas fa-edit'></i></button>";

                $row[] = $no;
                $row[] = $list->brgnama;
                $row[] = $list->tglfaktur;
                $row[] = $list->detjml;
                $row[] = number_format($list->detsubtotal, 0, ",", ".");
                $row[] = $list->supnama;
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $datamodel->count_all($brgid, $tglawal, $tglakhir),
                "recordsFiltered" => $datamodel->count_filtered($brgid, $tglawal, $tglakhir),
                "data" => $data,
            ];
            echo json_encode($output);
        }
    }

    public function downloadDetailListDataBarangMasuk()
    {
        if ($this->request->isAJAX()) {
            $brgid = $this->request->getPost('brgid');
            $tglawal = $this->request->getPost('tglawal');
            $tglakhir = $this->request->getPost('tglakhir');

            $dataPembelian = new ModelBarangMasukDetail();
            $rowData = $dataPembelian->downloadDataDetailBarangMasuk($brgid, $tglawal, $tglakhir);
        }
    }
}

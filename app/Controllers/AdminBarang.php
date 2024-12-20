<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelBarang;
use App\Models\ModelBarangPagination;
use App\Models\ModelBarangTambahHarga;
use App\Models\ModelKategori;
use App\Models\ModelSatuan;
use App\Models\ModelStock;
use App\Models\ModelUser;
use Config\Services;

class AdminBarang extends BaseController
{
    public function index()
    {
        $data = [
            'menu' => 'master',
            'submenu' => 'barang',
            'title' => 'Data Barang',
        ];
        return view('admin/barang/barang_view', $data);
    }

    // listDataBarang
    public function listDataBarang()
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

                $tombolEdit = "<button type=\"button\" class=\"btn btn-sm btn-info\" onclick=\"edit('" . $list->brgid . "')\" title=\"Edit\"><i class='fas fa-edit'></i></button>";
                $tombolHapus = "<button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"hapus('" . $list->brgid . "')\" title=\"Hapus\"><i class='fas fa-trash-alt'></i></button>";
                $tombolDetail = "<button type=\"button\" class=\"btn btn-sm btn-warning\" onclick=\"detail('" . $list->brgid . "')\" title=\"Detail Harga\"><i class='fas fa-tags'></i></button>";

                if (!empty($list->bth_brgid)) {
                    $tombol = $tombolEdit . ' ' . $tombolDetail;
                } else {
                    $tombol = $tombolEdit . ' ' . $tombolHapus . ' ' . $tombolDetail;
                }

                $row[] = $no;
                $row[] = $list->brgbarcode;
                $row[] = $list->brgnama;
                $row[] = $list->katnama;
                $row[] = $list->brgmodal;
                $row[] = $list->satnama;
                $row[] = number_format($list->brgharga);

                // // Menampilkan data harga sebagai string gabungan
                // if (is_array($cekHargaTambahan) && count($cekHargaTambahan) > 0) {
                //     $hargaDetails = [];
                //     foreach ($cekHargaTambahan as $harga) {
                //         $hargaDetails[] = '' .
                //             $harga['bth_isi_min'] . '-' . $harga['bth_isi_max'] . ' ' . $harga['satlabel'] . ' (' . $harga['bth_isi_min'] . ' ' . $harga['satlabel'] . ' isi ' . $harga['bth_konversi_isi_min'] . ' ' . $list->satlabel . ') : Harga ' . number_format($harga['bth_harga']) . '/' . $list->satlabel;
                //     }
                //     $row[] = implode('<br>', $hargaDetails); // Gabungkan semua harga dengan pemisah <br> untuk tampilan multi-baris
                // } else {
                //     $row[] = '-'; // Jika tidak ada data harga
                // }

                $row[] = "";
                $row[] = "<div style=\"display: flex; gap: 5px;\">" . $tombol . "</div>";
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

    // barangTambah
    public function barangTambah()
    {
        $modelKategori = new ModelKategori();
        $modelSatuan = new ModelSatuan();

        $data = [
            'menu' => 'master',
            'submenu' => 'barang',
            'title' => 'Tambah Barang',
            'tampilKategori' => $modelKategori->dataKategori()->getResultArray(),
            'tampilSatuan' => $modelSatuan->dataSatuan()->getResultArray(),
        ];

        return view('admin/barang/barang_tambah', $data);
    }

    // barangTambahSimpan
    public function barangTambahSimpan()
    {
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'brgbarcode' => [
                    'rules' => 'required|min_length[13]|max_length[13]',
                    'label' => 'Barcode',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'min_length' => '{field} harus terdiri dari setidaknya {param} digit',
                        'max_length' => '{field} tidak boleh lebih dari {param} digit',
                    ],
                ],
                'brgnama' => [
                    'rules' => 'required',
                    'label' => 'Nama Barang',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
                'brgkatid' => [
                    'rules' => 'required',
                    'label' => 'Kategori',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
                'brgsatid' => [
                    'rules' => 'required',
                    'label' => 'Satuan',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
                'brgsatisi' => [
                    'rules' => 'required',
                    'label' => 'Isi Satuan',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
                'brgharga' => [
                    'rules' => 'required',
                    'label' => 'Harga',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
            ]);

            if (!$valid) {
                $json = [
                    'error' => [
                        'errBarangBarcode' => $validation->getError('brgbarcode'),
                        'errBarangNama' => $validation->getError('brgnama'),
                        'errBarangKategori' => $validation->getError('brgkatid'),
                        'errBarangSatuan' => $validation->getError('brgsatid'),
                        'errBarangSatuanIsi' => $validation->getError('brgsatisi'),
                        'errBarangHarga' => $validation->getError('brgharga'),
                    ],
                ];
            } else {
                $modelBarang = new ModelBarang();
                $modelBarangTambahHarga = new ModelBarangTambahHarga();

                $barcode = $this->request->getPost('brgbarcode');
                $cekBarcode = $modelBarang->cekBarcode($barcode)->getRowArray();
                $cekBarcodeBarangTambag = $modelBarangTambahHarga->cekBarcode($barcode)->getRowArray();

                if (!empty($cekBarcode)) {
                    $json = [
                        'error' => [
                            'errBarangBarcode' => 'Barcode sudah ada',
                        ],
                    ];
                } else if (!empty($cekBarcodeBarangTambag)) {
                    $json = [
                        'error' => [
                            'errBarangBarcode' => 'Barcode sudah ada',
                        ],
                    ];
                } else {
                    $barangData = [
                        'brgbarcode' => $this->request->getPost('brgbarcode'),
                        'brgnama' => $this->request->getPost('brgnama'),
                        'brgkatid' => $this->request->getPost('brgkatid'),
                        'brgsatid' => $this->request->getPost('brgsatid'),
                        'brgsatisi' => $this->request->getPost('brgsatisi'),
                        'brgharga' => str_replace(".", "", $this->request->getPost('brgharga')),
                    ];

                    // Insert main item data
                    $modelBarang->insert($barangData);
                    $brgId = $modelBarang->insertID(); // Get the inserted ID for foreign key in additional prices

                    // Check if additional prices are submitted
                    $additionalPrices = $this->request->getPost('bth_satuan');
                    if ($additionalPrices && is_array($additionalPrices)) {
                        $pricesData = [];
                        foreach ($additionalPrices as $index => $satuan) {
                            // Collect each row data for bulk insert
                            $pricesData[] = [
                                'bth_brgid' => $brgId,
                                'bth_barcode' => '',
                                'bth_satuan' => $satuan,
                                'bth_isi_min' => $this->request->getPost('bth_isi_min')[$index],
                                'bth_isi_max' => $this->request->getPost('bth_isi_max')[$index],
                                'bth_konversi_isi_min' => $this->request->getPost('bth_konversi_isi_min')[$index],
                                'bth_harga' => $this->request->getPost('bth_harga')[$index],
                            ];
                        }
                        // Bulk insert additional prices data
                        $modelBarangTambahHarga->insertBatch($pricesData);
                    }

                    if ($brgId) {
                        $barcodeCek = $this->request->getPost('brgbarcode');

                        $cekModelBarang = new ModelBarang();
                        $cekBarangBarcode = $cekModelBarang->cekBarcode($barcodeCek)->getRowArray();

                        $userid = session()->userid;
                        $modelUser = new ModelUser();
                        $cekModelUser = $modelUser->find($userid);
                        $userCabang = $cekModelUser['usercabang'];

                        $cekBarangID = $cekBarangBarcode['brgid'];

                        $modelStock = new ModelStock();
                        $modelStock->insert([
                            'stock_brgid' => $cekBarangID,
                            'stock_jumlah' => 0,
                            'stock_cabang' => $userCabang,
                        ]);
                    }

                    $json = [
                        'sukses' => 'Data berhasil disimpan',
                    ];
                }
            }

            echo json_encode($json);
        }
    }

    // barangEdit
    public function barangEdit($brgid)
    {
        $modelKategori = new ModelKategori();
        $modelSatuan = new ModelSatuan();
        $modelBarang = new ModelBarang();

        $modelBarang = $modelBarang->find($brgid);

        if ($modelBarang) {
            $data = [
                'brgid' => $modelBarang['brgid'],
                'brgbarcode' => $modelBarang['brgbarcode'],
                'brgnama' => $modelBarang['brgnama'],
                'brgkatid' => $modelBarang['brgkatid'],
                'brgmodal' => $modelBarang['brgmodal'],
                'brgsatid' => $modelBarang['brgsatid'],
                'brgsatisi' => $modelBarang['brgsatisi'],
                'brgharga' => $modelBarang['brgharga'],
                'brggambar' => $modelBarang['brggambar'],
                'tampilKategori' => $modelKategori->dataKategori()->getResultArray(),
                'tampilSatuan' => $modelSatuan->dataSatuan()->getResultArray(),
            ];

            $json = [
                'data' => view('admin/barang/barang_edit', $data),
            ];
        }
        echo json_encode($json);
    }

    // barangEditSimpan
    public function barangEditSimpan()
    {
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'brgbarcode' => [
                    'rules' => 'required|min_length[13]|max_length[13]',
                    'label' => 'Barcode',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'min_length' => '{field} harus terdiri dari setidaknya {param} digit',
                        'max_length' => '{field} tidak boleh lebih dari {param} digit',
                    ],
                ],
                'brgnama' => [
                    'rules' => 'required',
                    'label' => 'Nama Barang',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
                'brgkatid' => [
                    'rules' => 'required',
                    'label' => 'Kategori',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
                'brgsatid' => [
                    'rules' => 'required',
                    'label' => 'Satuan',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
                'brgsatisi' => [
                    'rules' => 'required',
                    'label' => 'Isi Satuan',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
                'brgharga' => [
                    'rules' => 'required',
                    'label' => 'Harga',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
            ]);

            if (!$valid) {
                $json = [
                    'error' => [
                        'errBarangBarcode' => $validation->getError('brgbarcode'),
                        'errBarangNama' => $validation->getError('brgnama'),
                        'errBarangKategori' => $validation->getError('brgkatid'),
                        'errBarangSatuan' => $validation->getError('brgsatid'),
                        'errBarangSatuanIsi' => $validation->getError('brgsatisi'),
                        'errBarangHarga' => $validation->getError('brgharga'),
                    ],
                ];
            } else {

                $brgid = $this->request->getPost('brgid');
                $brgbarcodelama = $this->request->getPost('brgbarcodelama');
                $brgbarcode = $this->request->getPost('brgbarcode');
                $brgnama = $this->request->getPost('brgnama');
                $brgkatid = $this->request->getPost('brgkatid');
                $brgsatid = $this->request->getPost('brgsatid');
                $brgsatisi = $this->request->getPost('brgsatisi');
                $brgharga = str_replace(".", "", $this->request->getPost('brgharga'));
                $brgmodal = str_replace(".", "", $this->request->getPost('brgmodal'));

                $modelBarang = new ModelBarang();

                $barcode = $this->request->getPost('brgbarcode');
                $cekBarcode = $modelBarang->cekBarcode($barcode)->getRowArray();

                if ($brgbarcodelama == $brgbarcode) {
                    $modelBarang->update($brgid, [
                        'brgbarcode' => $brgbarcode,
                        'brgnama' => $brgnama,
                        'brgkatid' => $brgkatid,
                        'brgmodal' => $brgmodal,
                        'brgsatid' => $brgsatid,
                        'brgsatisi' => $brgsatisi,
                        'brgharga' => $brgharga,
                    ]);

                    $json = [
                        'sukses' => 'Data berhasil disimpan',
                    ];
                } else {
                    if (!empty($cekBarcode)) {
                        $json = [
                            'error' => [
                                'errBarangBarcode' => 'Barcode sudah ada',
                            ],
                        ];
                    } else {
                        $modelBarang->update($brgid, [
                            'brgbarcode' => $brgbarcode,
                            'brgnama' => $brgnama,
                            'brgkatid' => $brgkatid,
                            'brgmodal' => $brgmodal,
                            'brgsatid' => $brgsatid,
                            'brgsatisi' => $brgsatisi,
                            'brgharga' => $brgharga,
                        ]);

                        $json = [
                            'sukses' => 'Data berhasil disimpan',
                        ];
                    }
                }
            }

            echo json_encode($json);
        }
    }

    // barangHapus
    public function barangHapus($brgid)
    {
        $modelBarang = new ModelBarang();
        $modelBarang->delete($brgid);

        $modelHargaTambah = new ModelBarangTambahHarga();
        // hapus berdasarkan kodebarang
        $modelHargaTambah->where(['bth_brgid' => $brgid]);
        $modelHargaTambah->delete();

        $json = [
            'sukses' => 'Data berhasil dihapus',
        ];

        echo json_encode($json);
    }

    // barangDetail
    public function barangDetail($brgid)
    {
        $modelSatuan = new ModelSatuan();
        $modelBarang = new ModelBarang();
        $modelBarangTambahHarga = new ModelBarangTambahHarga();

        $detailBarang = $modelBarang->detailBarang($brgid)->getRowArray();
        $cekTambahan = $modelBarangTambahHarga->dataTambahanDetail($brgid)->getRowArray();
        if (!empty($cekTambahan)) {
            $cekTambahanHarga = $cekTambahan['bth_id'];
        } else {
            $cekTambahanHarga = "";
        }

        $cekBarcodeTerakhir = $modelBarangTambahHarga->cekBarcodeTerakhir()->getRowArray();
        if (!empty($cekBarcodeTerakhir)) {
            $cekBarcode = $cekBarcodeTerakhir['bth_barcode'] + 1;
        } else {
            $cekBarcode = '2024110100001';
        }

        if ($detailBarang) {
            $data = [
                'menu' => 'master',
                'submenu' => 'barang',
                'title' => 'Detail Harga Barang',
                'brgid' => $detailBarang['brgid'],
                'brgbarcode' => $detailBarang['brgbarcode'],
                'brgnama' => $detailBarang['brgnama'],
                'brgkatid' => $detailBarang['brgkatid'],
                'katnama' => $detailBarang['katnama'],
                'brgmodal' => $detailBarang['brgmodal'],
                'brgsatid' => $detailBarang['brgsatid'],
                'satnama' => $detailBarang['satnama'],
                'satlabel' => $detailBarang['satlabel'],
                'brgsatisi' => $detailBarang['brgsatisi'],
                'brgharga' => $detailBarang['brgharga'],
                'brggambar' => $detailBarang['brggambar'],
                'cekTambahanHarga' => $cekTambahanHarga,
                'barcodeterakhir' => $cekBarcode,
                'tampilSatuan' => $modelSatuan->dataSatuan()->getResultArray(),
                'tampilTambahan' => $modelBarangTambahHarga->dataTambahanDetail($brgid)->getResultArray(),
            ];

            return view('admin/barang/barang_detail', $data);
        }
    }

    // hargaTambahSimpan
    public function hargaTambahSimpan()
    {
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'bth_barcode' => [
                    'rules' => 'required|min_length[13]|max_length[13]',
                    'label' => 'Barcode',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'min_length' => '{field} harus terdiri dari setidaknya {param} digit',
                        'max_length' => '{field} tidak boleh lebih dari {param} digit',
                    ],
                ],
                'bth_satuan' => [
                    'rules' => 'required',
                    'label' => 'Satuan',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
                'bth_isi_min' => [
                    'rules' => 'required',
                    'label' => 'Isi',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
                'bth_isi_max' => [
                    'rules' => 'required',
                    'label' => 'Batas dari Isi',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
                'bth_konversi_isi_min' => [
                    'rules' => 'required',
                    'label' => 'Konversi',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
                'bth_harga' => [
                    'rules' => 'required',
                    'label' => 'Harga',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
            ]);

            if (!$valid) {
                $json = [
                    'error' => [
                        'errBTHBarcode' => $validation->getError('bth_barcode'),
                        'errBTHSatuan' => $validation->getError('bth_satuan'),
                        'errBTHMin' => $validation->getError('bth_isi_min'),
                        'errBTHMax' => $validation->getError('bth_isi_max'),
                        'errBTHKonversi' => $validation->getError('bth_konversi_isi_min'),
                        'errBTHHarga' => $validation->getError('bth_harga'),
                    ],
                ];
            } else {
                $brgid = $this->request->getPost('brgid');
                $bth_barcode = $this->request->getPost('bth_barcode');
                $bth_satuan = $this->request->getPost('bth_satuan');
                $bth_isi_min = $this->request->getPost('bth_isi_min');
                $bth_isi_max = $this->request->getPost('bth_isi_max');
                $bth_konversi_isi_min = $this->request->getPost('bth_konversi_isi_min');
                $bth_harga = str_replace(".", "", $this->request->getPost('bth_harga'));

                $modelBarang = new ModelBarang();
                $modelBarangTambahHarga = new ModelBarangTambahHarga();

                $cekBarcodeBarang = $modelBarang->cekBarcode($bth_barcode)->getRowArray();
                $cekBarcodeTambahan = $modelBarangTambahHarga->cekBarcode($bth_barcode)->getRowArray();

                if (!empty($cekBarcodeBarang)) {
                    $json = [
                        'error' => [
                            'errBTHBarcode' => 'Barcode sudah ada',
                        ],
                    ];
                } else if (!empty($cekBarcodeTambahan)) {
                    $json = [
                        'error' => [
                            'errBTHBarcode' => 'Barcode sudah ada',
                        ],
                    ];
                } else {
                    $modelBarangTambahHarga->insert([
                        'bth_brgid' => $brgid,
                        'bth_barcode' => $bth_barcode,
                        'bth_satuan' => $bth_satuan,
                        'bth_isi_min' => $bth_isi_min,
                        'bth_isi_max' => $bth_isi_max,
                        'bth_konversi_isi_min' => $bth_konversi_isi_min,
                        'bth_harga' => $bth_harga,
                    ]);

                    $json = [
                        'sukses' => 'Data berhasil disimpan',
                    ];
                }
            }

            echo json_encode($json);
        }
    }

    // editHargaTambahan
    public function editHargaTambahan($id)
    {
        $modelSatuan = new ModelSatuan();
        $modelBarangTambahHarga = new ModelBarangTambahHarga();

        $modelBTH = $modelBarangTambahHarga->find($id);

        if ($modelBTH) {
            $data = [
                'bth_id' => $modelBTH['bth_id'],
                'bth_brgid' => $modelBTH['bth_brgid'],
                'bth_barcode' => $modelBTH['bth_barcode'],
                'bth_satuan' => $modelBTH['bth_satuan'],
                'bth_isi_min' => $modelBTH['bth_isi_min'],
                'bth_isi_max' => $modelBTH['bth_isi_max'],
                'bth_konversi_isi_min' => $modelBTH['bth_konversi_isi_min'],
                'bth_harga' => $modelBTH['bth_harga'],
                'tampilSatuan' => $modelSatuan->dataSatuan()->getResultArray(),
            ];

            $json = [
                'data' => view('admin/barang/barang_detail_edit', $data),
            ];
        }
        echo json_encode($json);
    }

    // editHargaTambahanSimpan
    public function editHargaTambahanSimpan()
    {
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'edit_bth_barcode' => [
                    'rules' => 'required|min_length[13]|max_length[13]',
                    'label' => 'Barcode',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'min_length' => '{field} harus terdiri dari setidaknya {param} digit',
                        'max_length' => '{field} tidak boleh lebih dari {param} digit',
                    ],
                ],
                'edit_bth_satuan' => [
                    'rules' => 'required',
                    'label' => 'Satuan',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
                'edit_bth_isi_min' => [
                    'rules' => 'required',
                    'label' => 'Isi',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
                'edit_bth_isi_max' => [
                    'rules' => 'required',
                    'label' => 'Batas dari Isi',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
                'edit_bth_konversi_isi_min' => [
                    'rules' => 'required',
                    'label' => 'Konversi',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
                'edit_bth_harga' => [
                    'rules' => 'required',
                    'label' => 'Harga',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
            ]);

            if (!$valid) {
                $json = [
                    'error' => [
                        'errEditBTHBarcode' => $validation->getError('edit_bth_barcode'),
                        'errEditBTHSatuan' => $validation->getError('edit_bth_satuan'),
                        'errEditBTHMin' => $validation->getError('edit_bth_isi_min'),
                        'errEditBTHMax' => $validation->getError('edit_bth_isi_max'),
                        'errEditBTHKonversi' => $validation->getError('edit_bth_konversi_isi_min'),
                        'errEditBTHHarga' => $validation->getError('edit_bth_harga'),
                    ],
                ];
            } else {
                $bth_id = $this->request->getPost('edit_bth_id');
                $bth_brgid = $this->request->getPost('edit_bth_brgid');
                $bth_barcodelama = $this->request->getPost('edit_bth_barcodelama');
                $bth_barcode = $this->request->getPost('edit_bth_barcode');
                $bth_satuan = $this->request->getPost('edit_bth_satuan');
                $bth_isi_min = $this->request->getPost('edit_bth_isi_min');
                $bth_isi_max = $this->request->getPost('edit_bth_isi_max');
                $bth_konversi_isi_min = $this->request->getPost('edit_bth_konversi_isi_min');
                $bth_harga = str_replace(".", "", $this->request->getPost('edit_bth_harga'));

                $modelBarang = new ModelBarang();
                $modelBarangTambahHarga = new ModelBarangTambahHarga();

                $cekBarcodeBarang = $modelBarang->cekBarcode($bth_barcode)->getRowArray();
                $cekBarcodeTambahan = $modelBarangTambahHarga->cekBarcode($bth_barcode)->getRowArray();

                if ($bth_barcodelama == $bth_barcode) {
                    $modelBarangTambahHarga->update($bth_id, [
                        'bth_brgid' => $bth_brgid,
                        'bth_barcode' => $bth_barcode,
                        'bth_satuan' => $bth_satuan,
                        'bth_isi_min' => $bth_isi_min,
                        'bth_isi_max' => $bth_isi_max,
                        'bth_konversi_isi_min' => $bth_konversi_isi_min,
                        'bth_harga' => $bth_harga,
                    ]);

                    $json = [
                        'sukses' => 'Data berhasil disimpan',
                    ];
                } else {
                    if (!empty($cekBarcodeBarang)) {
                        $json = [
                            'error' => [
                                'errEditBTHBarcode' => 'Barcode sudah ada',
                            ],
                        ];
                    } else if (!empty($cekBarcodeTambahan)) {
                        $json = [
                            'error' => [
                                'errEditBTHBarcode' => 'Barcode sudah ada',
                            ],
                        ];
                    } else {
                        $modelBarangTambahHarga->update($bth_id, [
                            'bth_brgid' => $bth_brgid,
                            'bth_barcode' => $bth_barcode,
                            'bth_satuan' => $bth_satuan,
                            'bth_isi_min' => $bth_isi_min,
                            'bth_isi_max' => $bth_isi_max,
                            'bth_konversi_isi_min' => $bth_konversi_isi_min,
                            'bth_harga' => $bth_harga,
                        ]);

                        $json = [
                            'sukses' => 'Data berhasil disimpan',
                        ];
                    }
                }
            }

            echo json_encode($json);
        }
    }

    // hargaTambahHapus
    public function hargaTambahHapus($bth_id)
    {
        $modelHargaTambah = new ModelBarangTambahHarga();
        $modelHargaTambah->delete($bth_id);

        $json = [
            'sukses' => 'Data berhasil dihapus',
        ];

        echo json_encode($json);
    }
}

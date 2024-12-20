<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelBarang;
use App\Models\ModelBarangCariJualPagination;
use App\Models\ModelBarangKeluar;
use App\Models\ModelBarangKeluarDetail;
use App\Models\ModelBarangKeluarDetailPagination;
use App\Models\ModelBarangKeluarPagination;
use App\Models\ModelBarangKeluarTemp;
use App\Models\ModelBarangTambahHarga;
use App\Models\ModelStock;
use App\Models\ModelUser;
use Config\Services;

class AdminBarangKeluar extends BaseController
{
    public function index()
    {
        $modelUser = new ModelUser();

        $data = [
            'menu' => 'masterkeluar',
            'submenu' => 'barangkeluar',
            'title' => 'Data Barang Masuk',
            'tampilUser' => $modelUser->findAll(),

        ];
        return view('admin/barangkeluar/bk_view', $data);
    }

    public function listDataBarangKeluar()
    {

        $userid = $this->request->getPost('userid');
        $tglawal = $this->request->getPost('tglawal');
        $tglakhir = $this->request->getPost('tglakhir');

        $request = Services::request();
        $datamodel = new ModelBarangKeluarPagination($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables($userid, $tglawal, $tglakhir);
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $tombolCetak = "<button type=\"button\" class=\"btn btn-sm btn-info\" onclick=\"cetak('" . $list->invoice . "')\" title=\"Cetak\"><i class='fas fa-print'></i></button>";
                $tombolHapus = "<button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"hapus('" . $list->invoice . "')\" title=\"Hapus\"><i class='fas fa-trash-alt'></i></button>";
                $tombolEdit = "<button type=\"button\" class=\"btn btn-sm btn-primary\" onclick=\"edit('" . $list->invoice . "')\" title=\"Edit\"><i class='fas fa-edit'></i></button>";

                $row[] = $no;
                $row[] = $list->invoice;
                $row[] = $list->tglinvoice;
                $row[] = $list->usernama;
                $row[] = number_format($list->totalharga, 0, ",", ".");
                $row[] = $tombolCetak . ' ' . $tombolHapus . ' ' . $tombolEdit;
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $datamodel->count_all($userid, $tglawal, $tglakhir),
                "recordsFiltered" => $datamodel->count_filtered($userid, $tglawal, $tglakhir),
                "data" => $data,
            ];
            echo json_encode($output);
        }
    }

    // buat nomor invoice
    private function buatInvoiceBarangKeluar()
    {
        $usercabang = session()->usercabang;
        $tanggalSekarang = date("Y-m-d");
        $barangKeluar = new ModelBarangKeluar();

        $hasil = $barangKeluar->noInvoice($tanggalSekarang)->getRowArray();
        $data = $hasil['noinvoice'];

        if ($data == "") {
            $nomorterakhir = '0000';
        } else {
            $nomorterakhir = $data;
        }

        $lastNoUrut = substr($nomorterakhir, -4);
        // nomor urut ditambah 1
        $nextNoUrut = intval($lastNoUrut) + 1;
        // membuat format nomor transaksi berikutnya
        $noInvoice = $usercabang . date('ymd', strtotime($tanggalSekarang)) . sprintf('%04s', $nextNoUrut);
        return $noInvoice;
    }

    // buat nomor invoice berdasarkan tanggal
    public function buatNoInvoiceBarangKeluar()
    {
        $usercabang = session()->usercabang;
        $tanggalSekarang = $this->request->getPost('tanggal');
        $barangKeluar = new ModelBarangKeluar();

        $hasil = $barangKeluar->noInvoice($tanggalSekarang)->getRowArray();
        $data = $hasil['noinvoice'];

        if ($data == "") {
            $nomorterakhir = '0000';
        } else {
            $nomorterakhir = $data;
        }

        $lastNoUrut = substr($nomorterakhir, -4);
        // nomor urut ditambah 1
        $nextNoUrut = intval($lastNoUrut) + 1;
        // membuat format nomor transaksi berikutnya
        $noInvoice = $usercabang . date('ymd', strtotime($tanggalSekarang)) . sprintf('%04s', $nextNoUrut);

        $json = [
            'noinvoice' => $noInvoice,
        ];

        echo json_encode($json);
    }

    // barangKeluarTambah
    public function barangKeluarTambah()
    {

        $data = [
            'menu' => 'kasir',
            'submenu' => 'bukakasir',
            'title' => 'Input Barang Keluar',
            'noinvoice' => $this->buatInvoiceBarangKeluar(),

        ];
        return view('admin/barangkeluar/bk_input', $data);
    }

    // modal cari barang
    public function modalCariBarangJual()
    {
        if ($this->request->isAJAX()) {
            $json = [
                'data' => view('admin/barangkeluar/modalcaribarang'),
            ];

            echo json_encode($json);
        }
    }

    // list cari barang
    public function listCariDataBarangJual()
    {
        $request = Services::request();
        $datamodel = new ModelBarangCariJualPagination($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $tombolPilih = "<button type=\"button\" class=\"btn btn-sm btn-info\" onclick=\"pilih('" . $list->brgbarcode . "')\" title=\"Pilih\"><i class='fas fa-hand-point-up'></i></button>";

                $row[] = $no;
                $row[] = $list->brgbarcode;
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
    public function ambilDataBarangJual()
    {
        if ($this->request->isAJAX()) {
            $kodebarang = $this->request->getPost('kodebarang');

            $modelBarang = new ModelBarang();
            $cekData = $modelBarang->cekBarcode($kodebarang)->getRowArray();

            if (!$cekData) { // Simplified null check
                $json = [
                    'error' => 'Maaf, Data barang tidak ditemukan',
                ];
            } else {
                $data = [
                    'brgid' => $cekData['brgid'],
                    'namabarang' => $cekData['brgnama'],
                    'hargajual' => number_format($cekData['brgharga'], 0, ',', '.'), // Added formatting for better currency style
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

    // tampil data temp
    public function tampilDataTempBarangKeluar()
    {
        if ($this->request->isAJAX()) {
            $noinvoice = $this->request->getPost('noinvoice');

            $modelBarangKeluarTemp = new ModelBarangKeluarTemp();
            $dataTemp = $modelBarangKeluarTemp->tampilDataTemp($noinvoice);

            $data = [
                'tampildata' => $dataTemp,
            ];

            $json = [
                'data' => view('admin/barangkeluar/datatemp', $data),
            ];

            echo json_encode($json);
        } else {
            exit('Maaf, gagal menampilkan data');
        }
    }

    // simpan item barang keluar temp
    public function simpanItemBarangKeluar()
    {
        if ($this->request->isAJAX()) {
            $noinvoice = $this->request->getPost('noinvoice');
            $brgid = $this->request->getPost('brgid');
            $kodebarang = $this->request->getPost('kodebarang');
            $namabarang = $this->request->getPost('namabarang');
            $hargajual = str_replace(".", "", $this->request->getPost('hargajual'));
            $jml = $this->request->getPost('jml');
            $usercabang = $this->request->getPost('usercabang');

            $userid = session()->userid;
            $modelUser = new ModelUser();
            $cekModelUser = $modelUser->find($userid);
            $userCabang = $cekModelUser['usercabang'];

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'kodebarang' => [
                    'label' => 'Kode Barang',
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
                    ],
                ];
            } else {

                $modelBarangKeluarTemp = new ModelBarangKeluarTemp();

                $cekdata = $modelBarangKeluarTemp->cekItemKeluarTemp($noinvoice, $brgid);
                if ($cekdata->getNumRows() > 0) {
                    $cekItem = $modelBarangKeluarTemp->cekItemKeluarTemp($noinvoice, $brgid)->getRowArray();

                    $iddetail = $cekItem['iddetail'];
                    $detjml = $cekItem['detjml'];
                    $totaljumlah = $jml + $detjml;

                    $modelBarangTambahHarga = new ModelBarangTambahHarga();
                    $cekHarga = $modelBarangTambahHarga->cekHarga($brgid, $totaljumlah);

                    if (!empty($cekHarga)) {
                        $hargaBaru = $cekHarga['bth_harga'];
                    } else {
                        $hargaBaru = $cekItem['dethargajual'];
                    }

                    $modelBarangKeluarTemp->update($iddetail, [
                        'dethargajual' => $hargaBaru,
                        'detjml' => $totaljumlah,
                        'detsubtotal' => intval($totaljumlah) * intval($hargaBaru),
                    ]);

                    $json = [
                        'sukses' => 'Item berhasil ditambahkan',
                    ];
                } else {
                    $modelBarangKeluarTemp->insert([
                        'detinvoice' => $noinvoice,
                        'detbrgid' => $brgid,
                        'dethargajual' => $hargajual,
                        'detdiskon' => '',
                        'detjml' => $jml,
                        'detsubtotal' => intval($jml) * intval($hargajual),
                        'detcabang' => $userCabang,
                    ]);

                    if ($modelBarangKeluarTemp) {

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
            }

            echo json_encode($json);
        }
    }

    // Hapus item barang keluar dari data temp
    public function hapusItemBarangKeluarTemp()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('iddetail');
            $modelBarangKeluarTemp = new ModelBarangKeluarTemp();
            $modelBarangKeluarTemp->delete($id);

            $json = [
                'sukses' => 'Item berhasil dihapus',
            ];

            echo json_encode($json);
        }
    }

    // modal edit qty item data temp
    public function modalEditItemBarangKeluar($iddetail)
    {
        if ($this->request->isAJAX()) {

            $modelBarangKeluarTemp = new ModelBarangKeluarTemp();
            $cekData = $modelBarangKeluarTemp->cariItemBarangTemp($iddetail)->getRowArray();

            $modelBarangTambahHarga = new ModelBarangTambahHarga();
            $cekDataHarga = $modelBarangTambahHarga->dataTambahan($cekData['brgid'])->getResultArray();

            $array = [
                'iddetail' => $cekData['iddetail'],
                'brgid' => $cekData['brgid'],
                'brgnama' => $cekData['brgnama'],
                'brgsatid' => $cekData['brgsatid'],
                'satlabel' => $cekData['satlabel'],
                'brgharga' => $cekData['brgharga'],
                'hargaTambahan' => $cekDataHarga,
            ];

            $json = [
                'data' => view('admin/barangkeluar/modaledititemtemp', $array),
            ];

            echo json_encode($json);
        }
    }

    // edit qty item simpan
    public function modalEditItemBarangKeluarSimpan()
    {
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'satuanharga' => [
                    'rules' => 'required',
                    'label' => 'Satuan Harga',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
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
                        'errSatuanHarga' => $validation->getError('satuanharga'),
                        'errJumlah' => $validation->getError('editjml'),
                    ],
                ];
            } else {

                $editiddetail = $this->request->getPost('editiddetail');
                $brgid = $this->request->getPost('brgid');
                $brgharga = $this->request->getPost('brgharga');
                $satuanharga = $this->request->getPost('satuanharga');
                $editjml = $this->request->getPost('editjml');

                $modelBarang = new ModelBarang();
                $cekSatuanEcer = $modelBarang->cekSatuanHarga($brgid, $satuanharga);

                if (!empty($cekSatuanEcer)) {
                    $modelBarangKeluarTemp = new ModelBarangKeluarTemp();
                    $cekTemp = $modelBarangKeluarTemp->find($editiddetail);

                    $modelBarangTambahHarga = new ModelBarangTambahHarga();
                    $cekHarga = $modelBarangTambahHarga->cekHarga($cekTemp['detbrgid'], $editjml);

                    if (!empty($cekHarga)) {
                        $hargaBaru = $cekHarga['bth_harga'];
                    } else {
                        $hargaBaru = $cekTemp['dethargajual'];
                    }

                    $modelBarangKeluarTemp->update($editiddetail, [
                        'dethargajual' => $hargaBaru,
                        'detjml' => $editjml,
                        'detsubtotal' => intval($editjml) * intval($hargaBaru),
                    ]);

                    $json = [
                        'sukses' => 'Item berhasil ditambahkan',
                    ];
                } else {
                    $modelBarangTambahHarga = new ModelBarangTambahHarga();
                    $cekSatuanGrosir = $modelBarangTambahHarga->cekSatuanGrosir($brgid, $satuanharga);
                    if (!empty($cekSatuanGrosir)) {

                        if ($editjml < $cekSatuanGrosir['bth_isi_min']) {
                            $json = [
                                'error' => [
                                    'errJumlah' => 'Jumlah tidak boleh kurang dari ' . $cekSatuanGrosir['bth_isi_min'],
                                ],
                            ];
                        } else if ($editjml > $cekSatuanGrosir['bth_isi_max']) {
                            $json = [
                                'error' => [
                                    'errJumlah' => 'Jumlah tidak boleh lebih dari ' . $cekSatuanGrosir['bth_isi_max'],
                                ],
                            ];
                        } else if ($cekSatuanGrosir['bth_isi_min'] == 1) {
                            $jumlahbaru = intval($editjml) * intval($cekSatuanGrosir['bth_konversi_isi_min']);
                            $hargaBaru = $cekSatuanGrosir['bth_harga'];

                            $modelBarangKeluarTemp = new ModelBarangKeluarTemp();

                            $modelBarangKeluarTemp->update($editiddetail, [
                                'dethargajual' => $hargaBaru,
                                'detjml' => $jumlahbaru,
                                'detsubtotal' => intval($jumlahbaru) * intval($hargaBaru),
                            ]);

                            $json = [
                                'sukses' => 'Item berhasil ditambahkan',
                            ];
                        } else {
                            $jumlahbaru = (intval($editjml) / intval($cekSatuanGrosir['bth_isi_min'])) * intval($cekSatuanGrosir['bth_konversi_isi_min']);
                            $hargaBaru = $cekSatuanGrosir['bth_harga'];

                            $modelBarangKeluarTemp = new ModelBarangKeluarTemp();

                            $modelBarangKeluarTemp->update($editiddetail, [
                                'dethargajual' => $hargaBaru,
                                'detjml' => $jumlahbaru,
                                'detsubtotal' => intval($jumlahbaru) * intval($hargaBaru),
                            ]);

                            $json = [
                                'sukses' => 'Item berhasil ditambahkan',
                            ];
                        }
                    } else {
                        $jumlahbaru = $editjml;
                        $hargaBaru = $brgharga;

                        $modelBarangKeluarTemp = new ModelBarangKeluarTemp();

                        $modelBarangKeluarTemp->update($editiddetail, [
                            'dethargajual' => $hargaBaru,
                            'detjml' => $jumlahbaru,
                            'detsubtotal' => intval($jumlahbaru) * intval($hargaBaru),
                        ]);

                        $json = [
                            'sukses' => 'Item berhasil ditambahkan',
                        ];
                    }
                }
            }
            echo json_encode($json);
        }
    }

    public function ambilTotalHargaBarangKeluarTemp()
    {
        if ($this->request->isAJAX()) {
            $noinvoice = $this->request->getPost('noinvoice');

            $modelBarangKeluarTemp = new ModelBarangKeluarTemp();

            $totalHarga = $modelBarangKeluarTemp->ambilTotalHarga($noinvoice);

            $json = [
                'totalharga' => "Rp. " . number_format($totalHarga, 0, ",", "."),
                'totalbayar' => $totalHarga,
            ];

            echo json_encode($json);
        }
    }

    // modal pembayaran atau selesai transaksi
    public function modalPembayaranBarangKeluar()
    {
        if ($this->request->isAJAX()) {
            $noinvoice = $this->request->getPost('noinvoice');
            $tglinvoice = $this->request->getPost('tglinvoice');
            $userid = $this->request->getPost('userid');
            $totalharga = str_replace(".", "", $this->request->getPost('totalharga'));

            $modelTemp = new ModelBarangKeluarTemp();

            $cekdata = $modelTemp->tampilDataTemp($noinvoice);

            if ($cekdata->getNumRows() > 0) {
                $data = [
                    'noinvoice' => $noinvoice,
                    'tglinvoice' => $tglinvoice,
                    'userid' => $userid,
                    'totalharga' => $totalharga,
                ];

                $json = [
                    'data' => view('admin/barangkeluar/modalpembayaran', $data),
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
    public function modalPembayaranBarangKeluarSimpan()
    {
        if ($this->request->isAJAX()) {
            $noinvoice = $this->request->getPost('noinvoice');
            $tglinvoice = $this->request->getPost('tglinvoice');
            $invuserid = $this->request->getPost('userid');
            $totalbayar = str_replace(".", "", $this->request->getPost('totalbayar'));
            $disctoko = str_replace(".", "", $this->request->getPost('disctoko'));
            $jumlahuang = str_replace(".", "", $this->request->getPost('jumlahuang'));
            $sisauang = str_replace(".", "", $this->request->getPost('sisauang'));

            $ModelBarangKeluar = new ModelBarangKeluar();

            //simpan ke table barang keluar
            $ModelBarangKeluar->insert([
                'invoice' => $noinvoice,
                'tglinvoice' => $tglinvoice,
                'invuserid' => $invuserid,
                'totalharga' => $totalbayar,
                'disctoko' => $disctoko,
                'jumlahuang' => $jumlahuang,
                'sisauang' => $sisauang,
            ]);

            $modelTemp = new ModelBarangKeluarTemp();
            $dataTemp = $modelTemp->getWhere(['detinvoice' => $noinvoice]);

            $fieldDetail = [];
            foreach ($dataTemp->getResultArray() as $row) {
                $fieldDetail[] = [
                    'detinvoice' => $row['detinvoice'],
                    'detbrgid' => $row['detbrgid'],
                    'dethargajual' => $row['dethargajual'],
                    'detdiskon' => $row['detdiskon'],
                    'detjml' => $row['detjml'],
                    'detsubtotal' => $row['detsubtotal'],
                    'detcabang' => $row['detcabang'],
                ];
            }

            $modelDetail = new ModelBarangKeluarDetail();
            $modelDetail->insertBatch($fieldDetail);

            // hapus temp barang masuk berdasarkan faktur
            $modelTemp->where(['detinvoice' => $noinvoice]);
            $modelTemp->delete();

            $json = [
                'sukses' => 'Transaksi berhasil disimpan',
                'cetakinvoice' => site_url('cetakinvoice/' . $noinvoice),
            ];

            echo json_encode($json);
        }
    }

    // cetakinvoice
    public function cetakinvoice($invoice)
    {
        $modelBarangKeluar = new ModelBarangKeluar();
        $modelDetail = new ModelBarangKeluarDetail();
        $modelUser = new ModelUser();

        $cekData = $modelBarangKeluar->find($invoice);
        $dataUser = $modelUser->dataInvoice($cekData['invuserid'])->getRowArray();

        $namaUser = ($dataUser != null) ? $dataUser['usernama'] : '-';

        if ($cekData != null) {
            $data = [
                'invoice' => $invoice,
                'tanggal' => $cekData['tglinvoice'],
                'namaUser' => $namaUser,
                'cabang_nama' => $dataUser['cabang_nama'],
                'cabang_alamat' => $dataUser['cabang_alamat'],
                'kelurahan' => $dataUser['kelurahan'],
                'kecamatan' => $dataUser['kecamatan'],
                'kota_kabupaten' => $dataUser['kota_kabupaten'],
                'cabang_hp' => $dataUser['cabang_hp'],
                'jumlahuang' => $cekData['jumlahuang'],
                'sisauang' => $cekData['sisauang'],
                'disctoko' => $cekData['disctoko'],
                'detailbarang' => $modelDetail->tampilDataDetail($invoice),
            ];

            return view('admin/barangkeluar/cetakinvoice', $data);
        } else {
            return redirect()->to(site_url('barangKeluarTambah'));
        }
    }

    // hapus data transaksi
    public function hapusTransaksiBarangKeluar()
    {
        if ($this->request->isAJAX()) {
            $invoice = $this->request->getPost('invoice');

            $modelDetail = new ModelBarangKeluarDetail();
            $modelBarangKeluar = new ModelBarangKeluar();

            // hapus detail
            $modelDetail->where(['detinvoice' => $invoice]);
            $modelDetail->delete();
            $modelBarangKeluar->delete($invoice);

            $json = [
                'sukses' => 'Barang keluar berhasil dihapus',
            ];

            echo json_encode($json);
        }
    }

    // edit barang keluar
    public function barangKeluarEdit($invoice)
    {
        $modelBarangKeluar = new ModelBarangKeluar();
        $rowData = $modelBarangKeluar->find($invoice);

        $modelUser = new ModelUser();
        $rowUser = $modelUser->find($rowData['invuserid']);

        if ($rowData['invuserid'] == 0) {
            $user = '';
        } else {
            $user = $rowUser['usernama'];
        }

        $data = [
            'menu' => 'keluarmasuk',
            'submenu' => 'barangkeluar',
            'title' => 'Edit Barang Keluar',
            'noinvoice' => $invoice,
            'tanggal' => $rowData['tglinvoice'],
            'namauser' => $user,
        ];

        return view('admin/barangkeluar/bk_edit', $data);
    }

    public function ambilTotalHargaBarangKeluar()
    {
        if ($this->request->isAJAX()) {
            $noinvoice = $this->request->getPost('noinvoice');

            $modelDetail = new ModelBarangKeluarDetail();

            $totalHarga = $modelDetail->ambilTotalHarga($noinvoice);

            $json = [
                'totalharga' => "Rp. " . number_format($totalHarga, 0, ",", "."),
            ];

            echo json_encode($json);
        }
    }

    public function tampilDataDetailBarangKeluar()
    {
        if ($this->request->isAJAX()) {
            $noinvoice = $this->request->getPost('noinvoice');

            $modelDetailBarangKeluar = new ModelBarangKeluarDetail();
            $dataDetail = $modelDetailBarangKeluar->tampilDataDetail($noinvoice);

            $data = [
                'tampildata' => $dataDetail,
            ];

            $json = [
                'data' => view('admin/barangkeluar/datadetail', $data),
            ];

            echo json_encode($json);
        } else {
            exit('Maaf, gagal menampilkan data');
        }
    }

    public function hapusItemBarangKeluarDet()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('iddetail');
            $modelBarangKeluarDetail = new ModelBarangKeluarDetail();
            $modelBarangKeluar = new ModelBarangKeluar();

            $rowData = $modelBarangKeluarDetail->find($id);
            $noInvoice = $rowData['detinvoice'];

            $modelBarangKeluarDetail->delete($id);

            $totalHarga = $modelBarangKeluarDetail->ambilTotalHarga($noInvoice);

            //Lakukan update total di tabel pembelian
            $modelBarangKeluar->update($noInvoice, [
                'totalharga' => $totalHarga,
            ]);

            $json = [
                'sukses' => 'Item berhasil dihapus',
            ];

            echo json_encode($json);
        }
    }

    // modal edit qty item data detail
    public function modalEditItemBarangKeluarDetail($iddetail)
    {
        if ($this->request->isAJAX()) {

            $modelBarangKeluarDetail = new ModelBarangKeluarDetail();
            $cekData = $modelBarangKeluarDetail->cariItemBarangDetail($iddetail)->getRowArray();

            $modelBarangTambahHarga = new ModelBarangTambahHarga();
            $cekDataHarga = $modelBarangTambahHarga->dataTambahan($cekData['brgid'])->getResultArray();

            $array = [
                'iddetail' => $cekData['iddetail'],
                'brgid' => $cekData['brgid'],
                'brgnama' => $cekData['brgnama'],
                'brgsatid' => $cekData['brgsatid'],
                'satlabel' => $cekData['satlabel'],
                'brgharga' => $cekData['brgharga'],
                'detinvoice' => $cekData['detinvoice'],
                'hargaTambahan' => $cekDataHarga,
            ];

            $json = [
                'data' => view('admin/barangkeluar/modaledititemdetail', $array),
            ];

            echo json_encode($json);
        }
    }

    // edit qty item detail simpan
    public function modalEditItemBarangKeluarDetailSimpan()
    {
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'satuanharga' => [
                    'rules' => 'required',
                    'label' => 'Satuan Harga',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
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
                        'errSatuanHarga' => $validation->getError('satuanharga'),
                        'errJumlah' => $validation->getError('editjml'),
                    ],
                ];
            } else {
                $editiddetail = $this->request->getPost('editiddetail');
                $brgid = $this->request->getPost('brgid');
                $brgharga = $this->request->getPost('brgharga');
                $satuanharga = $this->request->getPost('satuanharga');
                $editjml = $this->request->getPost('editjml');
                $detinvoice = $this->request->getPost('detinvoice');

                $modelBarang = new ModelBarang();
                $cekSatuanEcer = $modelBarang->cekSatuanHarga($brgid, $satuanharga);

                if (!empty($cekSatuanEcer)) {
                    $modelBarangKeluarDetail = new ModelBarangKeluarDetail();
                    $cekTemp = $modelBarangKeluarDetail->find($editiddetail);

                    $modelBarangTambahHarga = new ModelBarangTambahHarga();
                    $cekHarga = $modelBarangTambahHarga->cekHarga($cekTemp['detbrgid'], $editjml);

                    if (!empty($cekHarga)) {
                        $hargaBaru = $cekHarga['bth_harga'];
                    } else {
                        $hargaBaru = $cekTemp['dethargajual'];
                    }

                    $modelBarangKeluarDetail->update($editiddetail, [
                        'dethargajual' => $hargaBaru,
                        'detjml' => $editjml,
                        'detsubtotal' => intval($editjml) * intval($hargaBaru),
                    ]);

                    $json = [
                        'sukses' => 'Item berhasil ditambahkan',
                    ];
                } else {
                    $modelBarangTambahHarga = new ModelBarangTambahHarga();
                    $cekSatuanGrosir = $modelBarangTambahHarga->cekSatuanGrosir($brgid, $satuanharga);
                    if (!empty($cekSatuanGrosir)) {

                        if ($editjml < $cekSatuanGrosir['bth_isi_min']) {
                            $json = [
                                'error' => [
                                    'errJumlah' => 'Jumlah tidak boleh kurang dari ' . $cekSatuanGrosir['bth_isi_min'],
                                ],
                            ];
                        } else if ($editjml > $cekSatuanGrosir['bth_isi_max']) {
                            $json = [
                                'error' => [
                                    'errJumlah' => 'Jumlah tidak boleh lebih dari ' . $cekSatuanGrosir['bth_isi_max'],
                                ],
                            ];
                        } else if ($cekSatuanGrosir['bth_isi_min'] == 1) {
                            $jumlahbaru = intval($editjml) * intval($cekSatuanGrosir['bth_konversi_isi_min']);
                            $hargaBaru = $cekSatuanGrosir['bth_harga'];

                            $modelBarangKeluarDetail = new ModelBarangKeluarTemp();

                            $modelBarangKeluarDetail->update($editiddetail, [
                                'dethargajual' => $hargaBaru,
                                'detjml' => $jumlahbaru,
                                'detsubtotal' => intval($jumlahbaru) * intval($hargaBaru),
                            ]);

                            $totalHarga = $modelBarangKeluarDetail->ambilTotalHarga($detinvoice);

                            $modelBarangKeluar = new ModelBarangKeluar();
                            //Lakukan update total di tabel pembelian
                            $modelBarangKeluar->update($detinvoice, [
                                'totalharga' => $totalHarga,
                            ]);

                            $json = [
                                'sukses' => 'Item berhasil ditambahkan',
                            ];
                        } else {
                            $jumlahbaru = (intval($editjml) / intval($cekSatuanGrosir['bth_isi_min'])) * intval($cekSatuanGrosir['bth_konversi_isi_min']);
                            $hargaBaru = $cekSatuanGrosir['bth_harga'];

                            $modelBarangKeluarDetail = new ModelBarangKeluarDetail();

                            $modelBarangKeluarDetail->update($editiddetail, [
                                'dethargajual' => $hargaBaru,
                                'detjml' => $jumlahbaru,
                                'detsubtotal' => intval($jumlahbaru) * intval($hargaBaru),
                            ]);

                            $totalHarga = $modelBarangKeluarDetail->ambilTotalHarga($detinvoice);

                            $modelBarangKeluar = new ModelBarangKeluar();
                            //Lakukan update total di tabel pembelian
                            $modelBarangKeluar->update($detinvoice, [
                                'totalharga' => $totalHarga,
                            ]);

                            $json = [
                                'sukses' => 'Item berhasil ditambahkan',
                            ];
                        }
                    } else {
                        $jumlahbaru = $editjml;
                        $hargaBaru = $brgharga;

                        $modelBarangKeluarDetail = new ModelBarangKeluarDetail();

                        $modelBarangKeluarDetail->update($editiddetail, [
                            'dethargajual' => $hargaBaru,
                            'detjml' => $jumlahbaru,
                            'detsubtotal' => intval($jumlahbaru) * intval($hargaBaru),
                        ]);

                        $totalHarga = $modelBarangKeluarDetail->ambilTotalHarga($detinvoice);

                        $modelBarangKeluar = new ModelBarangKeluar();
                        //Lakukan update total di tabel pembelian
                        $modelBarangKeluar->update($detinvoice, [
                            'totalharga' => $totalHarga,
                        ]);

                        $json = [
                            'sukses' => 'Item berhasil ditambahkan',
                        ];
                    }
                }
            }

            echo json_encode($json);
        }
    }

    // simpan item barang keluar detail
    public function simpanItemBarangKeluarDetail()
    {
        if ($this->request->isAJAX()) {

            $noinvoice = $this->request->getPost('noinvoice');
            $brgid = $this->request->getPost('brgid');
            $kodebarang = $this->request->getPost('kodebarang');
            $namabarang = $this->request->getPost('namabarang');
            $hargajual = str_replace(".", "", $this->request->getPost('hargajual'));
            $jml = $this->request->getPost('jml');
            $usercabang = $this->request->getPost('usercabang');

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'kodebarang' => [
                    'label' => 'Kode Barang',
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
                    ],
                ];
            } else {
                $modelBarangKeluarDetail = new ModelBarangKeluarDetail();

                $cekdata = $modelBarangKeluarDetail->cekItemBarangDetail($noinvoice, $brgid);
                if ($cekdata->getNumRows() > 0) {
                    $cekItem = $modelBarangKeluarDetail->cekItemBarangDetail($noinvoice, $brgid)->getRowArray();

                    $iddetail = $cekItem['iddetail'];
                    $detjml = $cekItem['detjml'];
                    $totaljumlah = $jml + $detjml;

                    $modelBarangTambahHarga = new ModelBarangTambahHarga();
                    $cekHarga = $modelBarangTambahHarga->cekHarga($brgid, $totaljumlah);

                    if (!empty($cekHarga)) {
                        $hargaBaru = $cekHarga['bth_harga'];
                    } else {
                        $hargaBaru = $cekItem['dethargajual'];
                    }

                    $modelBarangKeluarDetail->update($iddetail, [
                        'dethargajual' => $hargaBaru,
                        'detjml' => $totaljumlah,
                        'detsubtotal' => intval($totaljumlah) * intval($hargaBaru),
                    ]);

                    $totalHarga = $modelBarangKeluarDetail->ambilTotalHarga($noinvoice);

                    $modelBarangKeluar = new ModelBarangKeluar();
                    //Lakukan update total di tabel pembelian
                    $modelBarangKeluar->update($noinvoice, [
                        'totalharga' => $totalHarga,
                    ]);

                    $json = [
                        'sukses' => 'Item berhasil ditambahkan',
                    ];
                } else {

                    $modelBarangKeluarDetail = new ModelBarangKeluarDetail();
                    $modelBarangKeluarDetail->insert([
                        'detinvoice' => $noinvoice,
                        'detbrgid' => $brgid,
                        'dethargajual' => $hargajual,
                        'detdiskon' => '',
                        'detjml' => $jml,
                        'detsubtotal' => intval($jml) * intval($hargajual),
                        'detcabang' => $usercabang,
                    ]);

                    $totalHarga = $modelBarangKeluarDetail->ambilTotalHarga($noinvoice);

                    $modelBarangKeluar = new ModelBarangKeluar();
                    //Lakukan update total di tabel pembelian
                    $modelBarangKeluar->update($noinvoice, [
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

    public function databarangkeluar()
    {

        $modelBarangKeluar = new ModelBarangKeluarDetail();
        $barangKeluar = new ModelBarangKeluar();
        $data = [
            'menu' => 'masterkeluar',
            'submenu' => 'databarangkeluar',
            'title' => 'Data Detail Barang Keluar',
            'tampilBarangKeluar' => $modelBarangKeluar->dataBarangKeluar(),
            'dataKasir' => $barangKeluar->dataKasir(),
        ];
        return view('admin/barangkeluar/bk_detail', $data);
    }

    public function detailListDataBarangKeluar()
    {

        $invuserid = $this->request->getPost('invuserid');
        $tglawal = $this->request->getPost('tglawal');
        $tglakhir = $this->request->getPost('tglakhir');

        $request = Services::request();
        $datamodel = new ModelBarangKeluarDetailPagination($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables($invuserid, $tglawal, $tglakhir);
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
                $row[] = $list->tglinvoice;
                $row[] = $list->detjml;
                $row[] = number_format($list->detsubtotal, 0, ",", ".");
                $row[] = $list->usernama;
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $datamodel->count_all($invuserid, $tglawal, $tglakhir),
                "recordsFiltered" => $datamodel->count_filtered($invuserid, $tglawal, $tglakhir),
                "data" => $data,
            ];
            echo json_encode($output);
        }
    }

    public function laporanKasir()
    {

        $modelBarangKeluar = new ModelBarangKeluarDetail();
        $barangKeluar = new ModelBarangKeluar();
        $data = [
            'menu' => 'kasir',
            'submenu' => 'laporankasir',
            'title' => 'Data Detail Barang Keluar',
            'tampilBarangKeluar' => $modelBarangKeluar->dataBarangKeluar(),
            'dataKasir' => $barangKeluar->dataKasir(),
        ];
        return view('admin/barangkeluar/bk_laporankasir', $data);
    }

    public function detailLaporanDataBarangKeluar()
    {

        $invuserid = $this->request->getPost('invuserid');
        $tglawal = $this->request->getPost('tglawal');
        $tglakhir = $this->request->getPost('tglakhir');

        $request = Services::request();
        $datamodel = new ModelBarangKeluarDetailPagination($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables($invuserid, $tglawal, $tglakhir);
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
                $row[] = date('d-m-Y', strtotime($list->tglinvoice));
                $row[] = number_format($list->brgmodal, 0, ",", ".");
                $row[] = number_format($list->dethargajual, 0, ",", ".");
                $row[] = $list->detjml;
                $row[] = number_format($list->detdiskon, 0, ",", ".");
                $row[] = number_format($list->detsubtotal, 0, ",", ".");
                $row[] = $list->usernama;
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $datamodel->count_all($invuserid, $tglawal, $tglakhir),
                "recordsFiltered" => $datamodel->count_filtered($invuserid, $tglawal, $tglakhir),
                "data" => $data,
            ];
            echo json_encode($output);
        }
    }

    public function downloadLaporanDataBarangKeluar($userid)
    {
        $tglawal = date('Y-m-d');
        $tglakhir = date('Y-m-d');
        $modelBarangKeluarDetail = new ModelBarangKeluarDetail();
        $modelBarangKeluar = new ModelBarangKeluar();
        $totalDiskon = $modelBarangKeluar->ambilTotalDiskon($userid, $tglawal);

        $data = [
            'tampilLaporanKasir' => $modelBarangKeluarDetail->downloadLaporanKasir($userid, $tglawal, $tglakhir),
            'userid' => $userid,
            'tanggal' => $tglawal,
            'totalDiskon' => $totalDiskon,
        ];

        return view('admin/barangkeluar/downloadlaporankasir', $data);
    }
}

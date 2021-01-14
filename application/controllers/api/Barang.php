<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

class Barang extends MY_Controller
{
    public function __construct()
    {
        parent::__construct(); {
            $this->load->model('Barang_model', 'barang');
            // $this->methods['index_get']['limit'] = 30;
            $this->is_logged_in();
        }
    }

    public function index_get()
    {
        $kode = $this->get('KODE');
        if ($kode === null) {
            $barang = $this->barang->getBarang();
        } else {
            $barang = $this->barang->getBarang($kode);
        }

        if ($barang) {
            $this->response([
                'status' => true,
                'data' => $barang,
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'kode not found',
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_post()
    {
        $this->login_post();
        $data = [
            'KODE' => $this->input->post('KODE'),
            'NAMA' => $this->input->post('NAMA'),
            'SATUAN' => $this->input->post('SATUAN'),
            'STOK' => $this->input->post('STOK'),
            'MIN_STOK' => $this->input->post('MIN_STOK'),
            'MAX_STOK' => $this->input->post('MAX_STOK'),
            'HARGA_BELI' => $this->input->post('HARGA_BELI'),
            'HARGA_JUAL' => $this->input->post('HARGA_JUAL'),
            'IS_UPDATE_HARGA_JUAL' => $this->input->post('IS_UPDATE_HARGA_JUAL'),
            'GOLONGAN_ID' => $this->input->post('GOLONGAN_ID'),
            'LOKASI_ID' => $this->input->post('LOKASI_ID'),
            'SUPPLIER_ID' => $this->input->post('SUPPLIER_ID'),
            'KODE_BARCODE' => $this->input->post('KODE_BARCODE'),
            'URUT' => $this->input->post('URUT'),
            'STOK_AWAL' => $this->input->post('STOK_AWAL'),
            'DISKON_RP' => $this->input->post('DISKON_RP'),
            'GARANSI' => $this->input->post('GARANSI'),
            'SUB_GOLONGAN_ID' => $this->input->post('SUB_GOLONGAN_ID'),
            'BIJI1' => $this->input->post('BIJI1'),
            'SATUAN2' => $this->input->post('SATUAN2'),
            'BIJI2' => $this->input->post('BIJI2'),
            'SATUAN3' => $this->input->post('SATUAN3'),
            'BIJI3' => $this->input->post('BIJI3'),
            'SATUAN4' => $this->input->post('SATUAN4'),
            'BIJI4' => $this->input->post('BIJI4'),
            'TGL_TRANSAKSI' => date_format(date_create($this->input->post('TGL_TRANSAKSI')), 'Y-m-d'),
            'DISKON_GENERAL' => $this->input->post('DISKON_GENERAL'),
            'DISKON_SILVER' => $this->input->post('DISKON_SILVER'),
            'DISKON_GOLD' => $this->input->post('DISKON_GOLD'),
            'POIN' => $this->input->post('POIN'),
            'IS_WAJIB_ISI_IMEI' => $this->input->post('IS_WAJIB_ISI_IMEI'),
            'GUNA' => $this->input->post('GUNA'),
            'FOTO' => $this->input->post('FOTO'),
            'MARGIN' => $this->input->post('MARGIN'),
        ];

        if ($this->barang->addBarang($data) > 0) {
            $this->response([
                'status' => true,
                'data' => $data,
                'message' => 'barang baru berhasil ditambah!'
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'status' => false,
                'message' => 'failed to create new data!',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_put()
    {
        $kode = $this->put('KODE');
        $data = [
            'NAMA' => $this->put('NAMA'),
            'SATUAN' => $this->put('SATUAN'),
            'STOK' => $this->put('STOK'),
            'MIN_STOK' => $this->put('MIN_STOK'),
            'MAX_STOK' => $this->put('MAX_STOK'),
            'HARGA_BELI' => $this->put('HARGA_BELI'),
            'HARGA_JUAL' => $this->put('HARGA_JUAL'),
            'IS_UPDATE_HARGA_JUAL' => $this->put('IS_UPDATE_HARGA_JUAL'),
            'GOLONGAN_ID' => $this->put('GOLONGAN_ID'),
            'LOKASI_ID' => $this->put('LOKASI_ID'),
            'SUPPLIER_ID' => $this->put('SUPPLIER_ID'),
            'KODE_BARCODE' => $this->put('KODE_BARCODE'),
            'URUT' => $this->put('URUT'),
            'STOK_AWAL' => $this->put('STOK_AWAL'),
            'DISKON_RP' => $this->put('DISKON_RP'),
            'GARANSI' => $this->put('GARANSI'),
            'SUB_GOLONGAN_ID' => $this->put('SUB_GOLONGAN_ID'),
            'BIJI1' => $this->put('BIJI1'),
            'SATUAN2' => $this->put('SATUAN2'),
            'BIJI2' => $this->put('BIJI2'),
            'SATUAN3' => $this->put('SATUAN3'),
            'BIJI3' => $this->put('BIJI3'),
            'SATUAN4' => $this->put('SATUAN4'),
            'BIJI4' => $this->put('BIJI4'),
            'TGL_TRANSAKSI' => date_format(date_create($this->put('TGL_TRANSAKSI')), 'Y-m-d'),
            'DISKON_GENERAL' => $this->put('DISKON_GENERAL'),
            'DISKON_SILVER' => $this->put('DISKON_SILVER'),
            'DISKON_GOLD' => $this->put('DISKON_GOLD'),
            'POIN' => $this->put('POIN'),
            'IS_WAJIB_ISI_IMEI' => $this->put('IS_WAJIB_ISI_IMEI'),
            'GUNA' => $this->put('GUNA'),
            'FOTO' => $this->put('FOTO'),
            'MARGIN' => $this->put('MARGIN'),
        ];

        if ($kode === null) {
            $this->response([
                'status' => false,
                'message' => 'Provide a code!',
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if ($this->barang->editBarang($data, $kode)) {
                $this->response([
                    'status' => true,
                    'data' => $data,
                    'message' => 'barang berhasil diedit!'
                ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'failed to edit!',
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    public function index_delete()
    {
        $kode = $this->delete('KODE');

        if ($kode === null) {
            $this->response([
                'status' => false,
                'message' => 'Provide a code!',
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if ($this->barang->deleteBarang($kode)) {
                $this->response([
                    'status' => true,
                    'message' => 'barang ' . $kode . ' deleted!'
                ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'kode not found!',
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }
}

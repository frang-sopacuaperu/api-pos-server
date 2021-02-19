<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends MY_Controller
{
    public function __construct()
    {
        parent::__construct(); {
            $this->load->model('Barang_model', 'barang');
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
            ], 200);
        } else {
            $this->response([
                'status' => false,
                'message' => $this->lang->line('id'),
            ], 200);
        }
    }

    public function index_post()
    {
        $data = [
            'KODE' => $this->input->post('KODE'),
            'NAMA' => $this->input->post('NAMA'),
            'STOK' => $this->input->post('STOK'),
            'MIN_STOK' => $this->input->post('MIN_STOK'),
            'MAX_STOK' => $this->input->post('MAX_STOK'),
            'HARGA_BELI' => $this->input->post('HARGA_BELI'),
            'GOLONGAN_ID' => $this->input->post('GOLONGAN_ID'),
            'LOKASI_ID' => $this->input->post('LOKASI_ID'),
            'SUPPLIER_ID' => $this->input->post('SUPPLIER_ID'),
            'KODE_BARCODE' => $this->input->post('KODE_BARCODE'),
            'URUT' => $this->input->post('URUT'),
            'STOK_AWAL' => $this->input->post('STOK_AWAL'),
            'DISKON_RP' => $this->input->post('DISKON_RP'),
            'GARANSI' => $this->input->post('GARANSI'),
            'SUB_GOLONGAN_ID' => $this->input->post('SUB_GOLONGAN_ID'),
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

        $data2 = [
            'KODE_SATUAN' => 1,
            'BARANG_ID' => $this->input->post('BARANG_ID'),
            'HARGA_KE' => 1,
            'JUMLAH_R1' => 0,
            'JUMLAH_R2' => 0,
            'HARGA_JUAL' => 0,
        ];

        if ($this->barang->addBarang($data, $data2) > 0) {
            $this->response([
                'status' => true,
                'data' => $data, $data2,
                'message' => $this->lang->line('post')
            ], 201);
        } else {
            $this->response([
                'status' => false,
                'message' => $this->lang->line('fail'),
            ], 200);
        }
    }

    public function index_put()
    {
        $kode = $this->put('KODE');
        $data = [
            'NAMA' => $this->put('NAMA'),
            'STOK' => $this->put('STOK'),
            'MIN_STOK' => $this->put('MIN_STOK'),
            'MAX_STOK' => $this->put('MAX_STOK'),
            'HARGA_BELI' => $this->put('HARGA_BELI'),
            'GOLONGAN_ID' => $this->put('GOLONGAN_ID'),
            'LOKASI_ID' => $this->put('LOKASI_ID'),
            'SUPPLIER_ID' => $this->put('SUPPLIER_ID'),
            'KODE_BARCODE' => $this->put('KODE_BARCODE'),
            'URUT' => $this->put('URUT'),
            'STOK_AWAL' => $this->put('STOK_AWAL'),
            'DISKON_RP' => $this->put('DISKON_RP'),
            'GARANSI' => $this->put('GARANSI'),
            'SUB_GOLONGAN_ID' => $this->put('SUB_GOLONGAN_ID'),
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
                'message' => $this->lang->line('null'),
            ], 200);
        } else {
            if ($this->barang->editBarang($data, $kode)) {
                $this->response([
                    'status' => true,
                    'data' => $data,
                    'message' => $this->lang->line('put')
                ], 200);
            } else {
                $this->response([
                    'status' => false,
                    'message' => $this->lang->line('fail-put'),
                ], 200);
            }
        }
    }

    public function index_delete()
    {
        $kode = $this->delete('KODE');

        if ($kode === null) {
            $this->response([
                'status' => false,
                'message' => $this->lang->line('null'),
            ], 200);
        } else {
            if ($this->barang->deleteBarang($kode)) {
                $this->response([
                    'status' => true,
                    'message' => $this->lang->line('delete')
                ], 200);
            } else {
                $this->response([
                    'status' => false,
                    'message' => $this->lang->line('id'),
                ], 200);
            }
        }
    }
}

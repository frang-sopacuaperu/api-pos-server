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

        $kode_satuan = $this->input->post('KODE_SATUAN');
        $harga_jual = $this->input->post('HARGA_JUAL');
        $harga_ke = 1;
        $jumlah_r1 = $this->input->post('JUMLAH_R1');
        $jumlah_r2 = $this->input->post('JUMLAH_R2');
        $data2 = array();
        foreach ($harga_jual as $key => $val) {
            $data2[] = array(
                'BARANG_ID' => $data['KODE'],
                'KODE_SATUAN' =>   $kode_satuan[$key],
                'HARGA_KE' =>   $harga_ke,
                'JUMLAH_R1' =>   $jumlah_r1[$key],
                'JUMLAH_R2' =>   $jumlah_r2[$key],
                'HARGA_JUAL' =>   $harga_jual[$key],
            );
        }

        if ($this->barang->addBarang($data, $data2)) {
            $this->response([
                'status' => true,
                'data' => $data,
                'message' => $this->lang->line('post')
            ], 200);
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

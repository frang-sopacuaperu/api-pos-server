<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Supplier extends MY_Controller
{
    public function __construct()
    {
        parent::__construct(); {
            $this->load->model('Supplier_model', 'supplier');
        }
    }

    public function index_get()
    {
        $kode = $this->get('KODE');
        if ($kode === null) {
            $supplier = $this->supplier->getSupplier();
        } else {
            $supplier = $this->supplier->getSupplier($kode);
        }

        if ($supplier) {
            $this->response([
                'status' => true,
                'data' => $supplier,
            ], 200);
        } else {
            $this->response([
                'status' => false,
                'message' => $this->lang->line('id'),
            ], 404);
        }
    }

    public function index_post()
    {
        $data = [
            'KODE' => $this->input->post('KODE'),
            'NAMA' => $this->input->post('NAMA'),
            'ALAMAT' => $this->input->post('ALAMAT'),
            'KONTAK' => $this->input->post('KONTAK'),
            'NPWP' => $this->input->post('NPWP'),
            'JATUH_TEMPO' => $this->input->post('JATUH_TEMPO'),
            'URUT' => $this->input->post('URUT'),
            'WILAYAH_ID' => $this->input->post('WILAYAH_ID'),
            'DEF' => $this->input->post('DEF'),
            'ALAMAT2' => $this->input->post('ALAMAT2'),
            'KODE_BARCODE' => $this->input->post('KODE_BARCODE'),
            'PLAFON_HUTANG' => $this->input->post('PLAFON_HUTANG'),
            'TOTAL_HUTANG' => $this->input->post('TOTAL_HUTANG'),
            'TOTAL_PELUNASAN_HUTANG' => $this->input->post('TOTAL_PELUNASAN_HUTANG'),
            'TELEPON' => $this->input->post('TELEPON'),
        ];

        if ($this->supplier->addSupplier($data) > 0) {
            $this->response([
                'status' => true,
                'data' => $data,
                'message' => $this->lang->line('post')
            ], 201);
        } else {
            $this->response([
                'status' => false,
                'message' => $this->lang->line('fail'),
            ], 400);
        }
    }

    public function index_put()
    {
        $kode = $this->put('KODE');
        $data = [
            'NAMA' => $this->put('NAMA'),
            'ALAMAT' => $this->put('ALAMAT'),
            'KONTAK' => $this->put('KONTAK'),
            'NPWP' => $this->put('NPWP'),
            'JATUH_TEMPO' => $this->put('JATUH_TEMPO'),
            'URUT' => $this->put('URUT'),
            'WILAYAH_ID' => $this->put('WILAYAH_ID'),
            'DEF' => $this->put('DEF'),
            'ALAMAT2' => $this->put('ALAMAT2'),
            'KODE_BARCODE' => $this->put('KODE_BARCODE'),
            'PLAFON_HUTANG' => $this->put('PLAFON_HUTANG'),
            'TOTAL_HUTANG' => $this->put('TOTAL_HUTANG'),
            'TOTAL_PELUNASAN_HUTANG' => $this->put('TOTAL_PELUNASAN_HUTANG'),
            'TELEPON' => $this->put('TELEPON'),
        ];

        if ($kode === null) {
            $this->response([
                'status' => false,
                'message' => $this->lang->line('null'),
            ], 400);
        } else {
            if ($this->supplier->editSupplier($data, $kode)) {
                $this->response([
                    'status' => true,
                    'data' => $data,
                    'message' => $this->lang->line('put')
                ], 200);
            } else {
                $this->response([
                    'status' => false,
                    'message' => $this->lang->line('fail-put'),
                ], 400);
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
            ], 400);
        } else {
            if ($this->supplier->deleteSupplier($kode)) {
                $this->response([
                    'status' => true,
                    'message' => $this->lang->line('delete')
                ], 200);
            } else {
                $this->response([
                    'status' => false,
                    'message' => $this->lang->line('id'),
                ], 400);
            }
        }
    }
}

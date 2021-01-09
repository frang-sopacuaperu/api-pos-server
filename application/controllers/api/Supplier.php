<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Supplier extends REST_Controller
{
    public function __construct()
    {
        parent::__construct(); {
            $this->load->model('Supplier_model', 'supplier');
            // $this->methods['index_get']['limit'] = 30;
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
                'message' => 'supplier baru berhasil ditambah!'
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
                'message' => 'Provide a code!',
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if ($this->supplier->editSupplier($data, $kode)) {
                $this->response([
                    'status' => true,
                    'data' => $data,
                    'message' => 'supplier berhasil diedit!'
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
            if ($this->supplier->deleteSupplier($kode)) {
                $this->response([
                    'status' => true,
                    'message' => 'supplier ' . $kode . ' deleted!'
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

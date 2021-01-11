<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Jual extends REST_Controller
{
    public function __construct()
    {
        parent::__construct(); {
            $this->load->model('Jual_model', 'jual');
            // $this->methods['index_get']['limit'] = 30;
        }
    }

    public function index_get()
    {
        $nota = $this->get('NOTA');
        if ($nota === null) {
            $jual = $this->jual->getJual();
        } else {
            $jual = $this->jual->getJual($nota);
        }

        if ($jual) {
            $this->response([
                'status' => true,
                'data' => $jual,
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'nota not found',
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_post()
    {
        $data = [
            'NOTA' => $this->input->post('NOTA'),
            'CUSTOMER_ID' => $this->input->post('CUSTOMER_ID'),
            'SALESMAN_ID' => $this->input->post('SALESMAN_ID'),
            'STATUS_NOTA' => $this->input->post('STATUS_NOTA'),
            'STATUS_BAYAR' => $this->input->post('STATUS_BAYAR'),
            'TANGGAL' => date_format(date_create($this->input->post('TANGGAL')), 'Y-m-d'),
            'TEMPO' => date_format(date_create($this->input->post('TEMPO')), 'Y-m-d'),
            'DISKON' => $this->input->post('DISKON'),
            'PPN' => $this->input->post('PPN'),
            'KETERANGAN' => $this->input->post('KETERANGAN'),
            'USER_ADMIN' => $this->input->post('USER_ADMIN'),
            'URUT' => $this->input->post('URUT'),
            'OPERATOR' => $this->input->post('OPERATOR'),
            'NOTA_BELI' => $this->input->post('NOTA_BELI'),
            'LOKASI_ID' => $this->input->post('LOKASI_ID'),
            'TOTAL_NOTA' => $this->input->post('TOTAL_NOTA'),
            'TOTAL_PELUNASAN_NOTA' => $this->input->post('TOTAL_PELUNASAN_NOTA'),
            'PROFIT' => $this->input->post('PROFIT'),
        ];

        if ($this->jual->addJual($data) > 0) {
            $this->response([
                'status' => true,
                'data' => $data,
                'message' => 'penjualan baru berhasil ditambah!'
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
        $nota = $this->put('NOTA');
        $data = [
            'CUSTOMER_ID' => $this->put('CUSTOMER_ID'),
            'SALESMAN_ID' => $this->put('SALESMAN_ID'),
            'STATUS_NOTA' => $this->put('STATUS_NOTA'),
            'STATUS_BAYAR' => $this->put('STATUS_BAYAR'),
            'TANGGAL' => date_format(date_create($this->put('TANGGAL')), 'Y-m-d'),
            'TEMPO' => date_format(date_create($this->put('TEMPO')), 'Y-m-d'),
            'DISKON' => $this->put('DISKON'),
            'PPN' => $this->put('PPN'),
            'KETERANGAN' => $this->put('KETERANGAN'),
            'USER_ADMIN' => $this->put('USER_ADMIN'),
            'URUT' => $this->put('URUT'),
            'OPERATOR' => $this->put('OPERATOR'),
            'NOTA_BELI' => $this->put('NOTA_BELI'),
            'LOKASI_ID' => $this->put('LOKASI_ID'),
            'TOTAL_NOTA' => $this->put('TOTAL_NOTA'),
            'TOTAL_PELUNASAN_NOTA' => $this->put('TOTAL_PELUNASAN_NOTA'),
            'PROFIT' => $this->put('PROFIT'),
        ];

        if ($nota === null) {
            $this->response([
                'status' => false,
                'message' => 'Provide a nota!',
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if ($this->jual->editJual($data, $nota)) {
                $this->response([
                    'status' => true,
                    'data' => $data,
                    'message' => 'data penjualan berhasil diedit!'
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
        $nota = $this->delete('NOTA');

        if ($nota === null) {
            $this->response([
                'status' => false,
                'message' => 'Provide a nota!',
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if ($this->jual->deleteJual($nota)) {
                $this->response([
                    'status' => true,
                    'message' => 'data penjualan nota ' . $nota . ' deleted!'
                ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'nota not found!',
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }
}

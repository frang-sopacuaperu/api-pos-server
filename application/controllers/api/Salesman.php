<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Salesman extends REST_Controller
{
    public function __construct()
    {
        parent::__construct(); {
            $this->load->model('Salesman_model', 'sales');
            // $this->methods['index_get']['limit'] = 30;
        }
    }

    public function index_get()
    {
        $kode = $this->get('KODE');
        if ($kode === null) {
            $sales = $this->sales->getSalesman();
        } else {
            $sales = $this->sales->getSalesman($kode);
        }

        if ($sales) {
            $this->response([
                'status' => true,
                'data' => $sales,
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
            'TELEPON' => $this->input->post('TELEPON'),
            'ALAMAT2' => $this->input->post('ALAMAT2'),
            'TELEPON2' => $this->input->post('TELEPON2'),
            'NO_REKENING' => $this->input->post('NO_REKENING'),
            'URUT' => $this->input->post('URUT'),
            'PLAFON_PIUTANG' => $this->input->post('PLAFON_PIUTANG'),
            'TOTAL_PIUTANG' => $this->input->post('TOTAL_PIUTANG'),
            'TOTAL_PEMBAYARAN_PIUTANG' => $this->input->post('TOTAL_PEMBAYARAN_PIUTANG'),
            'TOTAL_NOTA_PENJUALAN' => $this->input->post('TOTAL_NOTA_PENJUALAN'),
            'TOTAL_ITEM_PENJUALAN' => $this->input->post('TOTAL_ITEM_PENJUALAN'),
            'OPERATOR_ID' => $this->input->post('OPERATOR_ID'),
        ];

        if ($this->sales->addSalesman($data) > 0) {
            $this->response([
                'status' => true,
                'data' => $data,
                'message' => 'sales baru berhasil ditambah!'
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
            'TELEPON' => $this->put('TELEPON'),
            'ALAMAT2' => $this->put('ALAMAT2'),
            'TELEPON2' => $this->put('TELEPON2'),
            'NO_REKENING' => $this->put('NO_REKENING'),
            'URUT' => $this->put('URUT'),
            'PLAFON_PIUTANG' => $this->put('PLAFON_PIUTANG'),
            'TOTAL_PIUTANG' => $this->put('TOTAL_PIUTANG'),
            'TOTAL_PEMBAYARAN_PIUTANG' => $this->put('TOTAL_PEMBAYARAN_PIUTANG'),
            'TOTAL_NOTA_PENJUALAN' => $this->put('TOTAL_NOTA_PENJUALAN'),
            'TOTAL_ITEM_PENJUALAN' => $this->put('TOTAL_ITEM_PENJUALAN'),
            'OPERATOR_ID' => $this->put('OPERATOR_ID'),
        ];

        if ($kode === null) {
            $this->response([
                'status' => false,
                'message' => 'Provide a code!',
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if ($this->sales->editSalesman($data, $kode)) {
                $this->response([
                    'status' => true,
                    'data' => $data,
                    'message' => 'sales berhasil diedit!'
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
            if ($this->sales->deleteSalesman($kode)) {
                $this->response([
                    'status' => true,
                    'message' => 'sales ' . $kode . ' deleted!'
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

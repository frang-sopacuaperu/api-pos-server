<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Hutang extends REST_Controller
{
    public function __construct()
    {
        parent::__construct(); {
            $this->load->model('Hutang_model', 'hutang');
            // $this->methods['index_get']['limit'] = 30;
        }
    }

    public function index_get()
    {
        $nomor = $this->get('NO_PELUNASAN');
        if ($nomor === null) {
            $hutang = $this->hutang->getHutang();
        } else {
            $hutang = $this->hutang->getHutang($nomor);
        }

        if ($hutang) {
            $this->response([
                'status' => true,
                'data' => $hutang,
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'nomor not found',
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_post()
    {
        $data = [
            'NO_PELUNASAN' => $this->input->post('NO_PELUNASAN'),
            'SUPPLIER_ID' => $this->input->post('SUPPLIER_ID'),
            'TANGGAL' => date_format(date_create($this->input->post('TANGGAL')), 'Y-m-d'),
            'KETERANGAN' => $this->input->post('KETERANGAN'),
            'URUT' => $this->input->post('URUT'),
            'OPERATOR' => $this->input->post('OPERATOR'),
        ];

        if ($this->hutang->addHutang($data) > 0) {
            $this->response([
                'status' => true,
                'data' => $data,
                'message' => 'hutang baru berhasil ditambah!'
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
        $nomor = $this->put('NO_PELUNASAN');
        $data = [
            'SUPPLIER_ID' => $this->put('SUPPLIER_ID'),
            'TANGGAL' => date_format(date_create($this->put('TANGGAL')), 'Y-m-d'),
            'KETERANGAN' => $this->put('KETERANGAN'),
            'URUT' => $this->put('URUT'),
            'OPERATOR' => $this->put('OPERATOR'),
        ];

        if ($nomor === null) {
            $this->response([
                'status' => false,
                'message' => 'Provide a code!',
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if ($this->hutang->editHutang($data, $nomor)) {
                $this->response([
                    'status' => true,
                    'data' => $data,
                    'message' => 'hutang berhasil diedit!'
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
        $nomor = $this->delete('NO_PELUNASAN');

        if ($nomor === null) {
            $this->response([
                'status' => false,
                'message' => 'Provide a code!',
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if ($this->hutang->deleteHutang($nomor)) {
                $this->response([
                    'status' => true,
                    'message' => 'hutang ' . $nomor . ' deleted!'
                ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'nomor not found!',
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }
}

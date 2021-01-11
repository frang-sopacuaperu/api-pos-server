<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Piutang extends REST_Controller
{
    public function __construct()
    {
        parent::__construct(); {
            $this->load->model('Piutang_model', 'piutang');
            // $this->methods['index_get']['limit'] = 30;
        }
    }

    public function index_get()
    {
        $nomor = $this->get('NO_PELUNASAN');
        if ($nomor === null) {
            $piutang = $this->piutang->getPiutang();
        } else {
            $piutang = $this->piutang->getPiutang($nomor);
        }

        if ($piutang) {
            $this->response([
                'status' => true,
                'data' => $piutang,
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
            'CUSTOMER_ID' => $this->input->post('CUSTOMER_ID'),
            'TANGGAL' => date_format(date_create($this->input->post('TANGGAL')), 'Y-m-d'),
            'KETERANGAN' => $this->input->post('KETERANGAN'),
            'URUT' => $this->input->post('URUT'),
            'OPERATOR' => $this->input->post('OPERATOR'),
        ];

        if ($this->piutang->addPiutang($data) > 0) {
            $this->response([
                'status' => true,
                'data' => $data,
                'message' => 'piutang baru berhasil ditambah!'
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
            'CUSTOMER_ID' => $this->put('CUSTOMER_ID'),
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
            if ($this->piutang->editPiutang($data, $nomor)) {
                $this->response([
                    'status' => true,
                    'data' => $data,
                    'message' => 'piutang berhasil diedit!'
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
            if ($this->piutang->deletePiutang($nomor)) {
                $this->response([
                    'status' => true,
                    'message' => 'piutang ' . $nomor . ' deleted!'
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

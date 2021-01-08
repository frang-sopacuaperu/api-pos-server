<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class SubGolongan extends REST_Controller
{
    public function __construct()
    {
        parent::__construct(); {
            $this->load->model('SubGolongan_model', 'subgolongan');
            // $this->methods['index_get']['limit'] = 30;
        }
    }

    public function index_get()
    {
        $kode = $this->get('KODE');
        if ($kode === null) {
            $subgolongan = $this->subgolongan->getSubGolongan();
        } else {
            $subgolongan = $this->subgolongan->getSubGolongan($kode);
        }

        if ($subgolongan) {
            $this->response([
                'status' => true,
                'data' => $subgolongan,
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
            'KETERANGAN' => $this->input->post('KETERANGAN'),
        ];

        if ($this->subgolongan->addSubGolongan($data) > 0) {
            $this->response([
                'status' => true,
                'data' => $data,
                'message' => 'subgolongan baru berhasil ditambah!'
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
            'KETERANGAN' => $this->put('KETERANGAN'),
        ];

        if ($kode === null) {
            $this->response([
                'status' => false,
                'message' => 'Provide a code!',
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if ($this->subgolongan->editSubGolongan($data, $kode)) {
                $this->response([
                    'status' => true,
                    'data' => $data,
                    'message' => 'subgolongan ' . $kode . ' berhasil diedit!'
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
            if ($this->subgolongan->deleteSubGolongan($kode)) {
                $this->response([
                    'status' => true,
                    'message' => 'subgolongan ' . $kode . ' deleted!'
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

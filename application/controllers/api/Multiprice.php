<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Multiprice extends REST_Controller
{
    public function __construct()
    {
        parent::__construct(); {
            $this->load->model('Multiprice_model', 'multiprice');
            // $this->methods['index_get']['limit'] = 30;
        }
    }

    public function index_get()
    {
        $id = $this->get('BARANG_ID');
        if ($id === null) {
            $multiprice = $this->multiprice->getMultiprice();
        } else {
            $multiprice = $this->multiprice->getMultiprice($id);
        }

        if ($multiprice) {
            $this->response([
                'status' => true,
                'data' => $multiprice,
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'id not found',
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_post()
    {
        $data = [
            'BARANG_ID' => $this->input->post('BARANG_ID'),
            'HARGA_KE' => $this->input->post('HARGA_KE'),
            'JUMLAH' => $this->input->post('JUMLAH'),
            'HARGA_JUAL' => $this->input->post('HARGA_JUAL'),
        ];

        if ($this->multiprice->addMultiprice($data) > 0) {
            $this->response([
                'status' => true,
                'data' => $data,
                'message' => 'multiprice baru berhasil ditambah!'
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
        $id = $this->put('BARANG_ID');
        $data = [
            'HARGA_KE' => $this->put('HARGA_KE'),
            'JUMLAH' => $this->put('JUMLAH'),
            'HARGA_JUAL' => $this->put('HARGA_JUAL'),
        ];

        if ($id === null) {
            $this->response([
                'status' => false,
                'message' => 'Provide an id!',
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if ($this->multiprice->editMultiprice($data, $id)) {
                $this->response([
                    'status' => true,
                    'data' => $data,
                    'message' => 'multiprice berhasil diedit!'
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
        $id = $this->delete('BARANG_ID');

        if ($id === null) {
            $this->response([
                'status' => false,
                'message' => 'Provide an id!',
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if ($this->multiprice->deleteMultiprice($id)) {
                $this->response([
                    'status' => true,
                    'message' => 'multiprice ' . $id . ' deleted!'
                ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'id not found!',
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }
}

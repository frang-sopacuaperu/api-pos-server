<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Lokasi extends REST_Controller
{
    public function __construct()
    {
        parent::__construct(); {
            $this->load->model('Lokasi_model', 'lokasi');
            // $this->methods['index_get']['limit'] = 30;
        }
    }

    public function index_get()
    {
        $kode = $this->get('KODE');
        if ($kode === null) {
            $lokasi = $this->lokasi->getLokasi();
        } else {
            $lokasi = $this->lokasi->getLokasi($kode);
        }

        if ($lokasi) {
            $this->response([
                'status' => true,
                'data' => $lokasi,
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
            'DEF' => $this->input->post('DEF'),
        ];

        if ($this->lokasi->addLokasi($data) > 0) {
            $this->response([
                'status' => true,
                'data' => $data,
                'message' => 'lokasi baru berhasil ditambah!'
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
            if ($this->lokasi->editLokasi($data, $kode)) {
                $this->response([
                    'status' => true,
                    'data' => $data,
                    'message' => 'lokasi berhasil diedit!'
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
            if ($this->lokasi->deleteLokasi($kode)) {
                $this->response([
                    'status' => true,
                    'message' => 'lokasi ' . $kode . ' deleted!'
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

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Golongan extends MY_Controller
{
    public function __construct()
    {
        parent::__construct(); {
            $this->load->model('Golongan_model', 'golongan');
        }
    }

    public function index_get()
    {
        $kode = $this->get('KODE');
        if ($kode === null) {
            $golongan = $this->golongan->getGolongan();
        } else {
            $golongan = $this->golongan->getGolongan($kode);
        }

        if ($golongan) {
            $this->response([
                'status' => true,
                'data' => $golongan,
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
            'KETERANGAN' => $this->input->post('KETERANGAN'),
        ];

        if ($this->golongan->addGolongan($data) > 0) {
            $this->response([
                'status' => true,
                'data' => $data,
                'message' => $this->lang->line('post')
            ], 201);
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
            'KETERANGAN' => $this->put('KETERANGAN'),
        ];

        if ($kode === null) {
            $this->response([
                'status' => false,
                'message' => $this->lang->line('null'),
            ], 200);
        } else {
            if ($this->golongan->editGolongan($data, $kode)) {
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
            if ($this->golongan->deleteGolongan($kode)) {
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

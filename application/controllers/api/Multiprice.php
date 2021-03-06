<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Multiprice extends MY_Controller
{
    public function __construct()
    {
        parent::__construct(); {
            $this->load->model('Multiprice_model', 'multiprice');
        }
    }

    public function index_get()
    {
        $id = $this->get('KODE');
        if ($id === null) {
            $multiprice = $this->multiprice->getMultiprice();
        } else {
            $multiprice = $this->multiprice->getMultiprice($id);
        }

        if ($multiprice) {
            $this->response([
                'status' => true,
                'data' => $multiprice,
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
            'KODE_SATUAN' => $this->input->post('KODE_SATUAN'),
            'BARANG_ID' => $this->input->post('BARANG_ID'),
            'HARGA_KE' => $this->input->post('HARGA_KE'),
            'JUMLAH_R1' => $this->input->post('JUMLAH_R1'),
            'JUMLAH_R2' => $this->input->post('JUMLAH_R2'),
            'HARGA_JUAL' => $this->input->post('HARGA_JUAL'),
        ];

        if ($this->multiprice->addMultiprice($data) > 0) {
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
        $id = $this->put('KODE');
        $data = [
            'KODE_SATUAN' => $this->put('KODE_SATUAN'),
            'BARANG_ID' => $this->put('BARANG_ID'),
            'HARGA_KE' => $this->put('HARGA_KE'),
            'JUMLAH_R1' => $this->put('JUMLAH_R1'),
            'JUMLAH_R2' => $this->put('JUMLAH_R2'),
            'HARGA_JUAL' => $this->put('HARGA_JUAL'),
        ];

        if ($id === null) {
            $this->response([
                'status' => false,
                'message' => $this->lang->line('null'),
            ], 400);
        } else {
            if ($this->multiprice->editMultiprice($data, $id)) {
                $this->response([
                    'status' => true,
                    'data' => $data,
                    'message' => $this->lang->line('put')
                ], 200);
            } else {
                $this->response([
                    'status' => false,
                    'message' => $this->lang->line('delete'),
                ], 400);
            }
        }
    }

    public function index_delete()
    {
        $id = $this->delete('KODE');

        if ($id === null) {
            $this->response([
                'status' => false,
                'message' => $this->lang->line('null'),
            ], 400);
        } else {
            if ($this->multiprice->deleteMultiprice($id)) {
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

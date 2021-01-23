<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Hutang extends MY_Controller
{
    public function __construct()
    {
        parent::__construct(); {
            $this->load->model('Hutang_model', 'hutang');
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
                'message' => $this->lang->line('null'),
            ], 400);
        } else {
            if ($this->hutang->editHutang($data, $nomor)) {
                $this->response([
                    'status' => true,
                    'data' => $data,
                    'message' => $this->lang->line('put')
                ], 200);
            } else {
                $this->response([
                    'status' => false,
                    'message' => $this->lang->line('fail-put'),
                ], 400);
            }
        }
    }

    public function index_delete()
    {
        $nomor = $this->delete('NO_PELUNASAN');

        if ($nomor === null) {
            $this->response([
                'status' => false,
                'message' => $this->lang->line('null'),
            ], 400);
        } else {
            if ($this->hutang->deleteHutang($nomor)) {
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

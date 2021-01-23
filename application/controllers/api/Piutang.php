<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Piutang extends MY_Controller
{
    public function __construct()
    {
        parent::__construct(); {
            $this->load->model('Piutang_model', 'piutang');
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
            'CUSTOMER_ID' => $this->put('CUSTOMER_ID'),
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
            if ($this->piutang->editPiutang($data, $nomor)) {
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
            if ($this->piutang->deletePiutang($nomor)) {
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

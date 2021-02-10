<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customer extends MY_Controller
{
    public function __construct()
    {
        parent::__construct(); {
            $this->load->model('Customer_model', 'customer');
        }
    }

    public function index_get()
    {
        $kode = $this->get('KODE');
        if ($kode === null) {
            $customer = $this->customer->getCustomer();
        } else {
            $customer = $this->customer->getCustomer($kode);
        }

        if ($customer) {
            $this->response([
                'status' => true,
                'data' => $customer,
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
            'NAMA' => $this->input->post('NAMA'),
            'ALAMAT' => $this->input->post('ALAMAT'),
            'KONTAK' => $this->input->post('KONTAK'),
            'NPWP' => $this->input->post('NPWP'),
            'JATUH_TEMPO' => $this->input->post('JATUH_TEMPO'),
            'URUT' => $this->input->post('URUT'),
            'WILAYAH_ID' => $this->input->post('WILAYAH_ID'),
            'DEF' => $this->input->post('DEF'),
            'ALAMAT2' => $this->input->post('ALAMAT2'),
            'KODE_BARCODE' => $this->input->post('KODE_BARCODE'),
            'PLAFON_PIUTANG' => $this->input->post('PLAFON_PIUTANG'),
            'TOTAL_PIUTANG' => $this->input->post('TOTAL_PIUTANG'),
            'TOTAL_PEMBAYARAN_PIUTANG' => $this->input->post('TOTAL_PEMBAYARAN_PIUTANG'),
            'KOTA' => $this->input->post('KOTA'),
            'TELEPON' => $this->input->post('TELEPON'),
            'JENIS_ANGGOTA' => $this->input->post('JENIS_ANGGOTA'),
        ];

        if ($this->customer->addCustomer($data) > 0) {
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
            'NAMA' => $this->put('NAMA'),
            'ALAMAT' => $this->put('ALAMAT'),
            'KONTAK' => $this->put('KONTAK'),
            'NPWP' => $this->put('NPWP'),
            'JATUH_TEMPO' => $this->put('JATUH_TEMPO'),
            'URUT' => $this->put('URUT'),
            'WILAYAH_ID' => $this->put('WILAYAH_ID'),
            'DEF' => $this->put('DEF'),
            'ALAMAT2' => $this->put('ALAMAT2'),
            'KODE_BARCODE' => $this->put('KODE_BARCODE'),
            'PLAFON_PIUTANG' => $this->put('PLAFON_PIUTANG'),
            'TOTAL_PIUTANG' => $this->put('TOTAL_PIUTANG'),
            'TOTAL_PEMBAYARAN_PIUTANG' => $this->put('TOTAL_PEMBAYARAN_PIUTANG'),
            'KOTA' => $this->put('KOTA'),
            'TELEPON' => $this->put('TELEPON'),
            'JENIS_ANGGOTA' => $this->put('JENIS_ANGGOTA'),
        ];

        if ($kode === null) {
            $this->response([
                'status' => false,
                'message' => $this->lang->line('null'),
            ], 200);
        } else {
            if ($this->customer->editCustomer($data, $kode)) {
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
            if ($this->customer->deleteCustomer($kode)) {
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

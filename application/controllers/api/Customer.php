<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \Firebase\JWT\JWT;;

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
        $secret_key = $this->privateKey();
        $token = null;

        $authHeader = $this->input->get_request_header('Authorization');

        $arr = explode(" ", $authHeader);

        $token = $arr[1];

        if ($token) {
            try {
                $decoded = JWT::decode($token, $secret_key, array('HS256'));

                if ($decoded) {
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
                            'message' => 'kode not found',
                        ], 404);
                    }
                }
            } catch (\Exception $e) {
                $output = [
                    'message' => 'Access denied',
                    "error" => $e->getMessage()
                ];

                return $this->response($output, 401);
            }
        }
    }

    public function index_post()
    {
        $secret_key = $this->privateKey();
        $token = null;

        $authHeader = $this->input->get_request_header('Authorization');

        $arr = explode(" ", $authHeader);

        $token = $arr[1];

        if ($token) {
            try {
                $decoded = JWT::decode($token, $secret_key, array('HS256'));

                if ($decoded) {
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
                            'message' => 'customer baru berhasil ditambah!'
                        ], 201);
                    } else {
                        $this->response([
                            'status' => false,
                            'message' => 'failed to create new data!',
                        ], 400);
                    }
                }
            } catch (\Exception $e) {
                $output = [
                    'message' => 'Access denied',
                    "error" => $e->getMessage()
                ];

                return $this->response($output, 401);
            }
        }
    }

    public function index_put()
    {
        $secret_key = $this->privateKey();
        $token = null;

        $authHeader = $this->input->get_request_header('Authorization');

        $arr = explode(" ", $authHeader);

        $token = $arr[1];

        if ($token) {
            try {
                $decoded = JWT::decode($token, $secret_key, array('HS256'));

                if ($decoded) {
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
                            'message' => 'Provide a code!',
                        ], 400);
                    } else {
                        if ($this->customer->editCustomer($data, $kode)) {
                            $this->response([
                                'status' => true,
                                'data' => $data,
                                'message' => 'customer berhasil diedit!'
                            ], 200);
                        } else {
                            $this->response([
                                'status' => false,
                                'message' => 'failed to edit!',
                            ], 400);
                        }
                    }
                }
            } catch (\Exception $e) {
                $output = [
                    'message' => 'Access denied',
                    "error" => $e->getMessage()
                ];

                return $this->response($output, 401);
            }
        }
    }

    public function index_delete()
    {
        $secret_key = $this->privateKey();
        $token = null;

        $authHeader = $this->input->get_request_header('Authorization');

        $arr = explode(" ", $authHeader);

        $token = $arr[1];

        if ($token) {
            try {
                $decoded = JWT::decode($token, $secret_key, array('HS256'));

                if ($decoded) {
                    $kode = $this->delete('KODE');

                    if ($kode === null) {
                        $this->response([
                            'status' => false,
                            'message' => 'Provide a code!',
                        ], 400);
                    } else {
                        if ($this->customer->deleteCustomer($kode)) {
                            $this->response([
                                'status' => true,
                                'message' => 'customer ' . $kode . ' deleted!'
                            ], 200);
                        } else {
                            $this->response([
                                'status' => false,
                                'message' => 'kode not found!',
                            ], 400);
                        }
                    }
                }
            } catch (\Exception $e) {
                $output = [
                    'message' => 'Access denied',
                    "error" => $e->getMessage()
                ];

                return $this->response($output, 401);
            }
        }
    }
}

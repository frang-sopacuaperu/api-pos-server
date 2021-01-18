<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \Firebase\JWT\JWT;

class Beli extends MY_Controller
{
    public function __construct()
    {
        parent::__construct(); {
            $this->load->model('Beli_model', 'beli');
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
                    $nota = $this->get('NOTA');
                    if ($nota === null) {
                        $beli = $this->beli->getBeli();
                    } else {
                        $beli = $this->beli->getBeli($nota);
                    }

                    if ($beli) {
                        $this->response([
                            'status' => true,
                            'data' => $beli,
                        ], 200);
                    } else {
                        $this->response([
                            'status' => false,
                            'message' => 'nota not found',
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
                        'NOTA' => $this->input->post('NOTA'),
                        'LOKASI_ID' => $this->input->post('LOKASI_ID'),
                        'SUPPLIER_ID' => $this->input->post('SUPPLIER_ID'),
                        'STATUS_NOTA' => $this->input->post('STATUS_NOTA'),
                        'STATUS_BAYAR' => $this->input->post('STATUS_BAYAR'),
                        'TANGGAL' => date_format(date_create($this->input->post('TANGGAL')), 'Y-m-d'),
                        'TEMPO' => date_format(date_create($this->input->post('TEMPO')), 'Y-m-d'),
                        'DISKON' => $this->input->post('DISKON'),
                        'PPN' => $this->input->post('PPN'),
                        'KETERANGAN' => $this->input->post('KETERANGAN'),
                        'USER_ADMIN' => $this->input->post('USER_ADMIN'),
                        'URUT' => $this->input->post('URUT'),
                        'OPERATOR' => $this->input->post('OPERATOR'),
                        'NOTA_JUAL' => $this->input->post('NOTA_JUAL'),
                        'TOTAL_NOTA' => $this->input->post('TOTAL_NOTA'),
                        'TOTAL_PELUNASAN_NOTA' => $this->input->post('TOTAL_PELUNASAN_NOTA'),
                        'PROFIT' => $this->input->post('PROFIT'),
                    ];

                    if ($this->beli->addBeli($data) > 0) {
                        $this->response([
                            'status' => true,
                            'data' => $data,
                            'message' => 'pembelian baru berhasil ditambah!'
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
                    $nota = $this->put('NOTA');
                    $data = [
                        'LOKASI_ID' => $this->put('LOKASI_ID'),
                        'SUPPLIER_ID' => $this->put('SUPPLIER_ID'),
                        'STATUS_NOTA' => $this->put('STATUS_NOTA'),
                        'STATUS_BAYAR' => $this->put('STATUS_BAYAR'),
                        'TANGGAL' => date_format(date_create($this->put('TANGGAL')), 'Y-m-d'),
                        'TEMPO' => date_format(date_create($this->put('TEMPO')), 'Y-m-d'),
                        'DISKON' => $this->put('DISKON'),
                        'PPN' => $this->put('PPN'),
                        'KETERANGAN' => $this->put('KETERANGAN'),
                        'USER_ADMIN' => $this->put('USER_ADMIN'),
                        'URUT' => $this->put('URUT'),
                        'OPERATOR' => $this->put('OPERATOR'),
                        'NOTA_JUAL' => $this->put('NOTA_JUAL'),
                        'TOTAL_NOTA' => $this->put('TOTAL_NOTA'),
                        'TOTAL_PELUNASAN_NOTA' => $this->put('TOTAL_PELUNASAN_NOTA'),
                        'PROFIT' => $this->put('PROFIT'),
                    ];

                    if ($nota === null) {
                        $this->response([
                            'status' => false,
                            'message' => 'Provide a nota!',
                        ], 400);
                    } else {
                        if ($this->beli->editBeli($data, $nota)) {
                            $this->response([
                                'status' => true,
                                'data' => $data,
                                'message' => 'data pembelian berhasil diedit!'
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
                    $nota = $this->delete('NOTA');

                    if ($nota === null) {
                        $this->response([
                            'status' => false,
                            'message' => 'Provide a nota!',
                        ], 400);
                    } else {
                        if ($this->beli->deleteBeli($nota)) {
                            $this->response([
                                'status' => true,
                                'message' => 'data pembelian nota ' . $nota . ' deleted!'
                            ], 200);
                        } else {
                            $this->response([
                                'status' => false,
                                'message' => 'nota not found!',
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

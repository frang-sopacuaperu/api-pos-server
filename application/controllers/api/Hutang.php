<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \Firebase\JWT\JWT;

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
        $secret_key = $this->privateKey();
        $token = null;

        $authHeader = $this->input->get_request_header('Authorization');

        $arr = explode(" ", $authHeader);

        $token = $arr[1];

        if ($token) {
            try {
                $decoded = JWT::decode($token, $secret_key, array('HS256'));

                if ($decoded) {
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
                            'message' => 'nomor not found',
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
                            'message' => 'hutang baru berhasil ditambah!'
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
                            'message' => 'Provide a code!',
                        ], 400);
                    } else {
                        if ($this->hutang->editHutang($data, $nomor)) {
                            $this->response([
                                'status' => true,
                                'data' => $data,
                                'message' => 'hutang berhasil diedit!'
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
                    $nomor = $this->delete('NO_PELUNASAN');

                    if ($nomor === null) {
                        $this->response([
                            'status' => false,
                            'message' => 'Provide a code!',
                        ], 400);
                    } else {
                        if ($this->hutang->deleteHutang($nomor)) {
                            $this->response([
                                'status' => true,
                                'message' => 'hutang ' . $nomor . ' deleted!'
                            ], 200);
                        } else {
                            $this->response([
                                'status' => false,
                                'message' => 'nomor not found!',
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

<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \Firebase\JWT\JWT;

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
        $secret_key = $this->privateKey();
        $token = null;

        $authHeader = $this->input->get_request_header('Authorization');

        $arr = explode(" ", $authHeader);

        $token = $arr[1];

        if ($token) {
            try {
                $decoded = JWT::decode($token, $secret_key, array('HS256'));

                if ($decoded) {
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
                        ], 200);
                    } else {
                        $this->response([
                            'status' => false,
                            'message' => 'id not found',
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
                        ], 400);
                    } else {
                        if ($this->multiprice->editMultiprice($data, $id)) {
                            $this->response([
                                'status' => true,
                                'data' => $data,
                                'message' => 'multiprice berhasil diedit!'
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
                    $id = $this->delete('BARANG_ID');

                    if ($id === null) {
                        $this->response([
                            'status' => false,
                            'message' => 'Provide an id!',
                        ], 400);
                    } else {
                        if ($this->multiprice->deleteMultiprice($id)) {
                            $this->response([
                                'status' => true,
                                'message' => 'multiprice ' . $id . ' deleted!'
                            ], 200);
                        } else {
                            $this->response([
                                'status' => false,
                                'message' => 'id not found!',
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

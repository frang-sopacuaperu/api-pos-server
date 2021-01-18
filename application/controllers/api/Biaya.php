<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \Firebase\JWT\JWT;

class Biaya extends MY_Controller
{
    public function __construct()
    {
        parent::__construct(); {
            $this->load->model('Biaya_model', 'biaya');
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
                        $biaya = $this->biaya->getBiaya();
                    } else {
                        $biaya = $this->biaya->getBiaya($kode);
                    }

                    if ($biaya) {
                        $this->response([
                            'status' => true,
                            'data' => $biaya,
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
                        'KETERANGAN' => $this->input->post('KETERANGAN'),
                    ];

                    if ($this->biaya->addBiaya($data) > 0) {
                        $this->response([
                            'status' => true,
                            'data' => $data,
                            'message' => 'biaya baru berhasil ditambah!'
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
                        'KETERANGAN' => $this->put('KETERANGAN'),
                    ];

                    if ($kode === null) {
                        $this->response([
                            'status' => false,
                            'message' => 'Provide a code!',
                        ], 400);
                    } else {
                        if ($this->biaya->editBiaya($data, $kode)) {
                            $this->response([
                                'status' => true,
                                'data' => $data,
                                'message' => 'biaya berhasil diedit!'
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
                        if ($this->biaya->deleteBiaya($kode)) {
                            $this->response([
                                'status' => true,
                                'message' => 'biaya ' . $kode . ' deleted!'
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

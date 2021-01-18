<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \Firebase\JWT\JWT;

class User extends MY_Controller
{
    public function __construct()
    {
        parent::__construct(); {
            $this->load->model('User_model', 'user');
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
                    $nama = $this->get('NAMA');
                    if ($nama === null) {
                        $user = $this->user->getUser();
                    } else {
                        $user = $this->user->getUser($nama);
                    }

                    if ($user) {
                        $this->response([
                            'status' => true,
                            'data' => $user,
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
                    $key = $this->_generate_key();

                    $data = [
                        'NAMA' => $this->input->post('NAMA'),
                        'PASS' => password_hash($this->input->post('PASS'), PASSWORD_DEFAULT),
                        'my_key' => $key,
                        'IS_AKTIF' => 1,
                        'GROUP_HAK_AKSES_ID' => 2,
                        'ALAMAT' => $this->input->post('ALAMAT'),
                        'WILAYAH_ID' => $this->input->post('WILAYAH_ID'),
                        'TELEPON' => $this->input->post('TELEPON'),
                        'NO_REKENING' => $this->input->post('NO_REKENING'),
                        'GAJI_POKOK' => $this->input->post('GAJI_POKOK'),
                        'IS_SHOW_INFO_HUTANG_PIUTANG' => $this->input->post('IS_SHOW_INFO_HUTANG_PIUTANG'),
                        'IS_SHOW_PROFIT' => $this->input->post('IS_SHOW_PROFIT'),
                        'IS_ALLOW_UPDATE_PLAFON' => $this->input->post('IS_ALLOW_UPDATE_PLAFON'),
                    ];

                    if ($this->user->addUser($data) > 0) {
                        $this->response([
                            'status' => true,
                            'data' => $data,
                            'message' => 'user baru berhasil ditambah!'
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
                    $nama = $this->put('NAMA');
                    $data = [
                        'PASS' => password_hash($this->put('PASS'), PASSWORD_DEFAULT),
                        'IS_AKTIF' => $this->put('IS_AKTIF'),
                        'GROUP_HAK_AKSES_ID' => $this->put('GROUP_HAK_AKSES_ID'),
                        'ALAMAT' => $this->put('ALAMAT'),
                        'WILAYAH_ID' => $this->put('WILAYAH_ID'),
                        'TELEPON' => $this->put('TELEPON'),
                        'NO_REKENING' => $this->put('NO_REKENING'),
                        'GAJI_POKOK' => $this->put('GAJI_POKOK'),
                        'IS_SHOW_INFO_HUTANG_PIUTANG' => $this->put('IS_SHOW_INFO_HUTANG_PIUTANG'),
                        'IS_SHOW_PROFIT' => $this->put('IS_SHOW_PROFIT'),
                        'IS_ALLOW_UPDATE_PLAFON' => $this->put('IS_ALLOW_UPDATE_PLAFON'),
                    ];

                    if ($nama === null) {
                        $this->response([
                            'status' => false,
                            'message' => 'Provide a name!',
                        ], 400);
                    } else {
                        if ($this->user->editUser($data, $nama)) {
                            $this->response([
                                'status' => true,
                                'data' => $data,
                                'message' => 'user berhasil diedit!'
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
                    $nama = $this->delete('NAMA');

                    if ($nama === null) {
                        $this->response([
                            'status' => false,
                            'message' => 'Provide a name!',
                        ], 400);
                    } else {
                        if ($this->user->deleteUser($nama)) {
                            $this->response([
                                'status' => true,
                                'nama' => $nama,
                                'message' => 'user deleted!'
                            ], 200);
                        } else {
                            $this->response([
                                'status' => false,
                                'message' => 'nama not found!',
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

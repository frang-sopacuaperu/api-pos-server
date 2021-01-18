<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \Firebase\JWT\JWT;

class Submenu extends MY_Controller
{
    public function __construct()
    {
        parent::__construct(); {
            $this->load->model('Submenu_model', 'submenu');
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
                    $id = $this->get('MENU_ID_LEVEL2');
                    if ($id === null) {
                        $submenu = $this->submenu->getSubMenu();
                    } else {
                        $submenu = $this->submenu->getSubMenu($id);
                    }

                    if ($submenu) {
                        $this->response([
                            'status' => true,
                            'data' => $submenu,
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
                        'MENU_ID_LEVEL1' => $this->input->post('MENU_ID_LEVEL1'),
                        'MENU_NAME' => $this->input->post('MENU_NAME'),
                        'MENU_CAPTION' => $this->input->post('MENU_CAPTION'),
                        'STATUS' => $this->input->post('STATUS'),
                    ];

                    if ($this->submenu->addSubMenu($data) > 0) {
                        $this->response([
                            'status' => true,
                            'data' => $data,
                            'message' => 'Submenu baru berhasil ditambah!'
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
                    $id = $this->put('MENU_ID_LEVEL2');
                    $data = [
                        'MENU_NAME' => $this->put('MENU_NAME'),
                        'MENU_ID_LEVEL1' => $this->put('MENU_ID_LEVEL1'),
                        'STATUS' => $this->put('STATUS'),
                    ];
                    if ($this->submenu->editSubMenu($data, $id) > 0) {
                        $this->response([
                            'status' => true,
                            'message' => 'Submenu berhasil diedit!'
                        ], 200);
                    } else {
                        $this->response([
                            'status' => false,
                            'message' => 'failed to edit!',
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
                    $id = $this->delete('MENU_ID_LEVEL2');

                    if ($id === null) {
                        $this->response([
                            'status' => false,
                            'message' => 'Provide an id!',
                        ], 400);
                    } else {
                        if ($this->submenu->deleteSubMenu($id) > 0) {
                            # ok
                            $this->response([
                                'status' => true,
                                'id' => $id,
                                'message' => 'Submenu deleted!'
                            ], 200);
                        } else {
                            # id not found
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

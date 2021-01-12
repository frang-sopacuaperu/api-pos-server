<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class AUTH_Controller extends REST_Controller
{
    public function login()
    {
        $this->_login();
    }

    private function _login()
    {
        $nama = $this->input->post('NAMA');
        $pass = $this->input->post('PASS');

        $user = $this->db->get_where('user_admin', [
            'NAMA' => $nama
        ])->row_array();

        if ($user) {
            if ($user['IS_AKTIF'] == 1) {
                if (password_verify($pass, $user['PASS'])) {
                    $data = [
                        'NAMA' => $user['NAMA'],
                        'GROUP_HAK_AKSES_ID' => $user['GROUP_HAK_AKSES_ID']
                    ];
                    $this->session->set_userdata($data);
                    $this->response([
                        'status' => true,
                        'data' => $user,
                    ], REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => false,
                        'message' => 'password anda salah!',
                    ], REST_Controller::HTTP_NOT_FOUND);
                }
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'akun anda belum aktif, hubungi admin!',
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        } else {
            $this->response([
                'status' => false,
                'message' => 'akun tidak terdaftar, daftar dulu!',
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
}

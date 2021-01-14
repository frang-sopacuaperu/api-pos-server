<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

class Auth extends MY_Controller
{
    public function __construct()
    {
        parent::__construct(); {
            $this->load->model('Auth_model', 'auth');
        }
    }

    public function register_post()
    {

        $data = [
            'NAMA' => $this->input->post('NAMA'),
            'PASS' => password_hash($this->input->post('PASS'), PASSWORD_DEFAULT),
            'MY_KEY' => $this->_generate_key(),
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

        if ($this->auth->register($data) > 0) {
            $this->response([
                'status' => true,
                'data' => $data,
                'message' => 'registrasi berhasil!'
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'status' => false,
                'message' => 'failed to register!',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function masuk_post()
    {
        $this->login_post();
    }
}

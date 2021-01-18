<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;
use \Firebase\JWT\JWT;

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
                'message' => 'registrasi berhasil, tolong catat MY_KEY anda sebagai API_KEY untuk mengakses menu!'
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'status' => false,
                'message' => 'failed to register!',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }



    public function login_post()
    {

        $nama = $this->input->post('NAMA');
        $pass = $this->input->post('PASS');

        $cek_login = $this->auth->cek_login($nama);

        $user = $this->db->get_where('user_admin', [
            'NAMA' => $nama
        ])->row_array();

        if ($user) {
            if ($user['IS_AKTIF'] == 1) {

                if (password_verify($pass, $cek_login['PASS'])) {
                    # code...
                    $secret_key = $this->privateKey();
                    $issuer_claim = "THE_CLAIM"; // this can be the servername. Example: https://domain.com
                    $audience_claim = "THE_AUDIENCE";
                    $issuedat_claim = time(); // issued at
                    $notbefore_claim = $issuedat_claim + 10; //not before in seconds
                    $expire_claim = $issuedat_claim + 3600; // expire time in seconds
                    $token = array(
                        "iss" => $issuer_claim,
                        "aud" => $audience_claim,
                        "iat" => $issuedat_claim,
                        "nbf" => $notbefore_claim,
                        "exp" => $expire_claim,
                        "data" => array(
                            "NAMA" => $cek_login['NAMA'],
                            "MY_KEY" => $cek_login['MY_KEY'],
                            "IS_AKTIF" => $cek_login['IS_AKTIF'],
                            "GROUP_HAK_AKSES_ID" => $cek_login['GROUP_HAK_AKSES_ID'],
                            "ALAMAT" => $cek_login['ALAMAT'],
                            "WILAYAH_ID" => $cek_login['WILAYAH_ID'],
                            "TELEPON" => $cek_login['TELEPON'],
                            "NO_REKENING" => $cek_login['NO_REKENING'],
                            "GAJI_POKOK" => $cek_login['GAJI_POKOK'],
                            "IS_SHOW_INFO_HUTANG_PIUTANG" => $cek_login['IS_SHOW_INFO_HUTANG_PIUTANG'],
                            "IS_SHOW_PROFIT" => $cek_login['IS_SHOW_PROFIT'],
                            "IS_ALLOW_UPDATE_PLAFON" => $cek_login['IS_ALLOW_UPDATE_PLAFON'],
                        )
                    );
                    $token = JWT::encode($token, $secret_key);

                    $output = [
                        'status' => 200,
                        'message' => 'sukses login',
                        'token' => $token,
                        'nama' => $nama,
                        'expired-at' => $expire_claim
                    ];
                    return $this->response($output, 200);
                }
                if ($pass == null) {
                    $output = [
                        'status' => 401,
                        'message' => 'password tidak boleh kosong!',
                        'nama' => $nama,
                    ];
                    return $this->response($output, 400);
                } else {
                    $output = [
                        'status' => 401,
                        'message' => 'password salah!',
                        'nama' => $nama,
                    ];
                    return $this->response($output, 401);
                }
            } else {
                $output = [
                    'status' => 401,
                    'message' => 'user ini tidak aktif/ di-non-aktifkan, hubungi admin!',
                    'nama' => $nama,
                ];
                return $this->response($output, 403);
            }
        }
        if ($nama == null) {
            $output = [
                'status' => 401,
                'message' => 'nama tidak boleh kosong!',
                'nama' => $nama,
            ];
            return $this->response($output, 400);
        } else {
            $output = [
                'status' => 401,
                'message' => 'user ini tidak terdaftar!',
                'nama' => $nama,
            ];
            return $this->response($output, 403);
        }
    }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;
use \Firebase\JWT\JWT;

class Auth extends REST_Controller
{
    public function __construct()
    {
        parent::__construct(); {
            $this->load->model('Auth_model', 'auth');
        }
    }

    public function privateKey()
    {
        $privateKey = <<<EOD
            -----BEGIN RSA PRIVATE KEY-----
            MIICXAIBAAKBgQC8kGa1pSjbSYZVebtTRBLxBz5H4i2p/llLCrEeQhta5kaQu/Rn
            vuER4W8oDH3+3iuIYW4VQAzyqFpwuzjkDI+17t5t0tyazyZ8JXw+KgXTxldMPEL9
            5+qVhgXvwtihXC1c5oGbRlEDvDF6Sa53rcFVsYJ4ehde/zUxo6UvS7UrBQIDAQAB
            AoGAb/MXV46XxCFRxNuB8LyAtmLDgi/xRnTAlMHjSACddwkyKem8//8eZtw9fzxz
            bWZ/1/doQOuHBGYZU8aDzzj59FZ78dyzNFoF91hbvZKkg+6wGyd/LrGVEB+Xre0J
            Nil0GReM2AHDNZUYRv+HYJPIOrB0CRczLQsgFJ8K6aAD6F0CQQDzbpjYdx10qgK1
            cP59UHiHjPZYC0loEsk7s+hUmT3QHerAQJMZWC11Qrn2N+ybwwNblDKv+s5qgMQ5
            5tNoQ9IfAkEAxkyffU6ythpg/H0Ixe1I2rd0GbF05biIzO/i77Det3n4YsJVlDck
            ZkcvY3SK2iRIL4c9yY6hlIhs+K9wXTtGWwJBAO9Dskl48mO7woPR9uD22jDpNSwe
            k90OMepTjzSvlhjbfuPN1IdhqvSJTDychRwn1kIJ7LQZgQ8fVz9OCFZ/6qMCQGOb
            qaGwHmUK6xzpUbbacnYrIM6nLSkXgOAwv7XXCojvY614ILTK3iXiLBOxPu5Eu13k
            eUz9sHyD6vkgZzjtxXECQAkp4Xerf5TGfQXGXhxIX52yH+N2LtujCdkQZjXAsGdm
            B2zNzvrlgRmgBrklMTrMYgm1NPcW+bRLGcwgW2PTvNM=
            -----END RSA PRIVATE KEY-----
            EOD;
        return $privateKey;
    }

    public function _generate_key()
    {
        do {
            // Generate a random salt
            $salt = base_convert(bin2hex($this->security->get_random_bytes(64)), 16, 36);

            // If an error occurred, then fall back to the previous method
            if ($salt === FALSE) {
                $salt = hash('sha256', time() . mt_rand());
            }

            $new_key = substr($salt, 0, config_item('rest_key_length'));
            $time = strtotime("+1 minutes");
            $new_key .= '.' . $time;
        } while ($this->_key_exists($new_key));

        return $new_key;
    }

    public function _key_exists($key)
    {
        return $this->rest->db
            ->where(config_item('rest_key_column'), $key)
            ->count_all_results(config_item('rest_keys_table')) > 0;
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

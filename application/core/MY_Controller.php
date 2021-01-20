<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
require_once APPPATH . '/libraries/JWT.php';
require_once APPPATH . '/libraries/BeforeValidException.php';
require_once APPPATH . '/libraries/ExpiredException.php';
require_once APPPATH . '/libraries/SignatureInvalidException.php';

use \Firebase\JWT\JWT;



class MY_Controller extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->lang->load('my_lang');
        // $token = $this->input->get_request_header('Authorization');
        // $expired_at = explode('.', $token[1]);
        // if ($expired_at < strtotime(time())) {
        //     $this->response([
        //         'status' => false,
        //         'message' => 'login first!',
        //     ], REST_Controller::HTTP_NOT_FOUND);
        // }
        $token = null;

        $token = $this->input->get_request_header('Authorization');

        $exp = explode(" ", $token[1]);

        if ($exp == false) {
            $output = [
                'message' => 'Access denied',
            ];

            return $this->response($output, 401);
        }
    }

    public function cek_login($nama)
    {
        $query = $this->db->get_where('user_admin')->result_array();

        if ($query > 0) {
            $result = $this->db->get_where('user_admin', ['NAMA' => $nama])->row_array();
        } else {
            $result = array();
        }
        return $result;
    }

    public function login_post()
    {

        $nama = $this->input->post('NAMA');
        $pass = $this->input->post('PASS');

        $cek_login = $this->cek_login($nama);

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

    // public function is_logged_in()
    // {
    //     $nama = $this->input->post('NAMA');
    //     if (!$nama) {
    //         $this->response([
    //             'status' => false,
    //             'message' => $this->lang->line('login'),
    //         ], REST_Controller::HTTP_NOT_FOUND);
    //     } else {
    //         if ($nama !== $nama) {
    //             $this->response([
    //                 'status' => false,
    //                 'message' => 'blocked!',
    //             ], REST_Controller::HTTP_NOT_FOUND);
    //         }
    //     }
    // }

    // public function login_post()
    // {
    //     $this->is_logged_in();
    //     $this->_login();
    // }

    // public function _token_exp()
    // {
    //     session_start();

    //     $timeout = 3600;
    //     $_SESSION['expires_by'] = time() + $timeout;
    // }

    // public function _login()
    // {
    //     $nama = $this->input->post('NAMA');
    //     $pass = $this->input->post('PASS');
    //     $data = array();
    //     $is_verified = false;

    //     $user = $this->db->get_where('user_admin', [
    //         'NAMA' => $nama
    //     ])->row_array();

    //     if ($user === null) {
    //         $this->response([
    //             'status' => false,
    //             'message' => 'Invalid Credentials!',
    //         ], 400);
    //     }
    //     if ($pass === null) {
    //         $this->response([
    //             'status' => false,
    //             'message' => 'Invalid Credentials!',
    //         ], 400);
    //     } else {
    //         if ($user) {
    //             if ($user['IS_AKTIF'] == 1) {
    //                 if (password_verify($pass, $user['PASS'])) {
    //                     $data = [
    //                         'NAMA' => $user['NAMA'],
    //                         'GROUP_HAK_AKSES_ID' => $user['GROUP_HAK_AKSES_ID']
    //                     ];
    //                     unset($user['PASS']);
    //                     unset($user['MY_KEY']);

    //                     $is_verified = true;
    //                 }
    //             }
    //         }

    //         if ($is_verified) {
    //             $expired_time = strtotime("+30 minutes");
    //             $key = $this->_generate_key();

    //             if (time() < $expired_time) {

    //                 $this->response([
    //                     'status' => true,
    //                     'user' => $user,
    //                     'token' => $key,
    //                     'message' => 'Token masih aktif!',
    //                 ], REST_Controller::HTTP_OK);
    //             } else {
    //                 $data = [
    //                     'my_key' => $key,
    //                 ];
    //                 $this->db->insert('user_admin', $data);
    //                 $this->db->affected_rows();
    //                 $this->response([
    //                     'status' => true,
    //                     'token' => $key,
    //                     'message' => 'Token baru berhasil dibuat!',
    //                 ], REST_Controller::HTTP_OK);
    //             }
    //         } else {
    //             $this->response([
    //                 'status' => false,
    //                 'message' => 'invalid credentials!',
    //             ], 401);
    //         }
    //     }
    // }

    // private function generate_api_token()
    // {
    //     $length = '30';
    //     $token = bin2hex(random_bytes($length));
    // }
}

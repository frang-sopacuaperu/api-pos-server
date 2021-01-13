<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class AUTH_Controller extends REST_Controller
{

    private function is_logged_in()
    {
        if (!$this->session->userdata('NAMA')) {
            $this->response([
                'status' => false,
                'message' => 'login first!',
            ], REST_Controller::HTTP_NOT_FOUND);
        } else {
            $GROUP_HAK_AKSES_ID = $this->session->userdata('GROUP_HAK_AKSES_ID');
            $menu2 = $this->uri->segment(1);

            $queryMenu2 = $this->db->get_where('menu_level2', ['MENU_CAPTION' => $menu2])->row_array();

            $menu2_id = $queryMenu2['MENU_ID_LEVEL2'];

            $userAccess = $this->db->get_where('hak_akses_form', [
                'ID' => $GROUP_HAK_AKSES_ID,
                'AKSES' => $menu2_id
            ]);

            if ($userAccess->num_rows() < 1) {
                $this->response([
                    'status' => false,
                    'message' => 'blocked!',
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        }
    }

    public function login()
    {
        $this->is_logged_in();
        $this->_login();
    }

    private function _token_exp()
    {
        session_start();

        $timeout = 3600;
        $_SESSION['expires_by'] = time() + $timeout;
    }

    private function _generate_key()
    {
        do {
            // Generate a random salt
            $salt = base_convert(bin2hex($this->security->get_random_bytes(64)), 16, 36);

            // If an error occurred, then fall back to the previous method
            if ($salt === FALSE) {
                $salt = hash('sha256', time() . mt_rand());
            }

            $new_key = substr($salt, 0, config_item('rest_key_length'));
        } while ($this->_key_exists($new_key));

        return $new_key;
    }

    private function _key_exists($key)
    {
        return $this->rest->db
            ->where(config_item('rest_key_column'), $key)
            ->count_all_results(config_item('rest_keys_table')) > 0;
    }

    private function _login()
    {
        $nama = $this->input->post('NAMA');
        $pass = $this->input->post('PASS');

        $user = $this->db->get_where('user_admin', [
            'NAMA' => $nama
        ])->row_array();

        if ($user === null) {
            $this->response([
                'status' => false,
                'message' => 'nama tidak boleh kosong!',
            ], REST_Controller::HTTP_NOT_FOUND);
        }
        if ($pass === null) {
            $this->response([
                'status' => false,
                'message' => 'password tidak boleh kosong!',
            ], REST_Controller::HTTP_NOT_FOUND);
        } else {
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
                            'message' => 'Berhasil, anda sudah login!',
                        ], REST_Controller::HTTP_OK);
                    } else {
                        $this->response([
                            'status' => false,
                            'message' => 'nama atau password anda salah!',
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

            $expired_time = $_SESSION['expires_by'];
            $key = $this->_generate_key();

            if (time() < $expired_time) {
                return $this->_token_exp();
                $this->response([
                    'status' => true,
                    'message' => 'Token masih aktif!',
                ], REST_Controller::HTTP_OK);
            } else {
                session_destroy();
                $data = [
                    'my_key' => $key,
                ];
                $this->db->insert('user_admin', $data);
                return $this->db->affected_rows();
                $this->response([
                    'status' => true,
                    'message' => 'Token baru berhasil dibuat!',
                ], REST_Controller::HTTP_OK);
            }
        }
    }
}

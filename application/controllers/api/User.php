<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class User extends REST_Controller
{
    public function __construct()
    {
        parent::__construct(); {
            $this->load->model('User_model', 'user');
            // $this->methods['index_get']['limit'] = 30;
        }
    }

    public function index_get()
    {
        $id = $this->get('GROUP_HAK_AKSES_ID');
        if ($id === null) {
            $user = $this->user->getUser();
        } else {
            $user = $this->user->getUser($id);
        }

        if ($user) {
            $this->response([
                'status' => true,
                'data' => $user,
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'id not found',
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    private function _generate_key()
    {
        do {
            // Generate a random salt
            $salt = base_convert(bin2hex($this->security->get_random_bytes(7)), 12, 24);

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

    public function index_post()
    {
        // $key = $this->get('my_key');
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
            'NO_REKENING' => $this->input->post('NO_REKENING')
        ];

        if ($this->user->addUser($data) > 0) {
            $this->response([
                'status' => true,
                'data' => $data,
                'message' => 'user baru berhasil ditambah!'
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'status' => false,
                'message' => 'failed to create new data!',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_put()
    {
        $id = $this->put('MENU_ID_LEVEL2');
        $data = [
            'MENU_NAME' => $this->put('MENU_NAME'),
            'MENU_ID_LEVEL1' => $this->put('MENU_ID_LEVEL1'),
            'STATUS' => $this->put('STATUS'),
        ];
        if ($this->user->editUser($data, $id) > 0) {
            $this->response([
                'status' => true,
                'message' => 'user berhasil diedit!'
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'failed to edit!',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_delete()
    {
        $id = $this->delete('MENU_ID_LEVEL2');

        if ($id === null) {
            $this->response([
                'status' => false,
                'message' => 'Provide an id!',
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if ($this->user->deleteUser($id) > 0) {
                # ok
                $this->response([
                    'status' => true,
                    'id' => $id,
                    'message' => 'user deleted!'
                ], REST_Controller::HTTP_OK);
            } else {
                # id not found
                $this->response([
                    'status' => false,
                    'message' => 'id not found!',
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }
}

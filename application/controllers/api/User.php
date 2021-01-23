<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
                'message' => $this->lang->line('id'),
            ], 404);
        }
    }

    public function index_post()
    {
        $data = [
            'NAMA' => $this->input->post('NAMA'),
            'PASS' => password_hash($this->input->post('PASS'), PASSWORD_DEFAULT),
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
                'message' => $this->lang->line('post')
            ], 201);
        } else {
            $this->response([
                'status' => false,
                'message' => $this->lang->line('fail'),
            ], 400);
        }
    }

    public function index_put()
    {
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
                'message' => $this->lang->line('null'),
            ], 400);
        } else {
            if ($this->user->editUser($data, $nama)) {
                $this->response([
                    'status' => true,
                    'data' => $data,
                    'message' => $this->lang->line('put')
                ], 200);
            } else {
                $this->response([
                    'status' => false,
                    'message' => $this->lang->line('fail-put'),
                ], 400);
            }
        }
    }

    public function index_delete()
    {
        $nama = $this->delete('NAMA');

        if ($nama === null) {
            $this->response([
                'status' => false,
                'message' => $this->lang->line('null'),
            ], 400);
        } else {
            if ($this->user->deleteUser($nama)) {
                $this->response([
                    'status' => true,
                    'nama' => $nama,
                    'message' => $this->lang->line('delete')
                ], 200);
            } else {
                $this->response([
                    'status' => false,
                    'message' => $this->lang->line('id'),
                ], 400);
            }
        }
    }
}

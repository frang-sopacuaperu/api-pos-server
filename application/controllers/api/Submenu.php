<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
                'message' => $this->lang->line('id'),
            ], 404);
        }
    }

    public function index_post()
    {
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
        $id = $this->put('MENU_ID_LEVEL2');
        $data = [
            'MENU_NAME' => $this->put('MENU_NAME'),
            'MENU_ID_LEVEL1' => $this->put('MENU_ID_LEVEL1'),
            'STATUS' => $this->put('STATUS'),
        ];
        if ($this->submenu->editSubMenu($data, $id) > 0) {
            $this->response([
                'status' => true,
                'message' => $this->lang->line('put')
            ], 200);
        } else {
            $this->response([
                'status' => false,
                'message' => $this->lang->line('fail-put'),
            ], 400);
        }
    }

    public function index_delete()
    {
        $id = $this->delete('MENU_ID_LEVEL2');

        if ($id === null) {
            $this->response([
                'status' => false,
                'message' => $this->lang->line('null'),
            ], 400);
        } else {
            if ($this->submenu->deleteSubMenu($id) > 0) {
                $this->response([
                    'status' => true,
                    'id' => $id,
                    'message' => $this->lang->line('delete')
                ], 200);
            } else {
                # id not found
                $this->response([
                    'status' => false,
                    'message' => $this->lang->line('id'),
                ], 400);
            }
        }
    }
}

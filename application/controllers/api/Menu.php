<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends MY_Controller
{
    public function __construct()
    {
        parent::__construct(); {
            $this->load->model('Menu_model', 'menu');
        }
    }

    public function index_get()
    {
        $id = $this->get('MENU_ID_LEVEL1');
        if ($id === null) {
            $menu = $this->menu->getMenu();
        } else {
            $menu = $this->menu->getMenu($id);
        }

        if ($menu) {
            $this->response([
                'status' => true,
                'data' => $menu,
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

        if ($this->menu->addMenu($data) > 0) {
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
        $id = $this->put('MENU_ID_LEVEL1');
        $data = [
            'MENU_NAME' => $this->put('MENU_NAME'),
            'MENU_CAPTION' => $this->put('MENU_CAPTION'),
            'STATUS' => $this->put('STATUS'),
        ];
        if ($this->menu->editMenu($data, $id) > 0) {
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
        $id = $this->delete('MENU_ID_LEVEL1');

        if ($id === null) {
            $this->response([
                'status' => false,
                'message' => $this->lang->line('null'),
            ], 400);
        } else {
            if ($this->menu->deleteMenu($id) > 0) {
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

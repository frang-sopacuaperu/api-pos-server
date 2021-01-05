<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Submenu extends REST_Controller
{
    public function __construct()
    {
        parent::__construct(); {
            $this->load->model('Submenu_model', 'submenu');
            // $this->methods['index_get']['limit'] = 30;
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
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'id not found',
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_post()
    {
        if ($this->submenu->addSubMenu() > 0) {
            $this->response([
                'status' => true,
                'message' => 'Submenu baru berhasil ditambah!'
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
        if ($this->submenu->editSubMenu($data, $id) > 0) {
            $this->response([
                'status' => true,
                'message' => 'Submenu berhasil diedit!'
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
            if ($this->submenu->deleteSubMenu($id) > 0) {
                # ok
                $this->response([
                    'status' => true,
                    'id' => $id,
                    'message' => 'Submenu deleted!'
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

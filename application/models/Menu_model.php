<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Menu_model extends CI_Model
{

    public function getMenu($id = null)
    {
        if ($id === null) {
            return $this->db->get('menu_level1')->result_array();
        } else {
            return $this->db->get_where('menu_level1', ['MENU_ID_LEVEL1' => $id])->result_array();
        }
    }

    public function addMenu($data)
    {
        $this->db->insert('menu_level1', $data);
        return $this->db->affected_rows();
    }

    public function editMenu($data, $id)
    {
        $this->db->update('menu_level1', $data, ['MENU_ID_LEVEL1' => $id]);
        return $this->db->affected_rows();
    }

    public function deleteMenu($id)
    {
        $this->db->delete('menu_level1', ['MENU_ID_LEVEL1' => $id]);
        return $this->db->affected_rows();
    }
}

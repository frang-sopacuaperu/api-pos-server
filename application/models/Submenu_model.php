<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Submenu_model extends CI_Model
{

    public function getSubMenu($id = null)
    {
        if ($id === null) {
            return $this->db->get('menu_level2')->result_array();
        } else {
            return $this->db->get_where('menu_level2', ['MENU_ID_LEVEL2' => $id])->result_array();
        }
    }

    public function addSubMenu($data)
    {
        $this->db->insert('menu_level2', $data);
        return $this->db->affected_rows();
    }

    public function editSubMenu($data, $id)
    {
        $this->db->update('menu_level2', $data, ['MENU_ID_LEVEL2' => $id]);
        return $this->db->affected_rows();
    }

    public function deleteSubMenu($id)
    {
        $this->db->delete('menu_level2', ['MENU_ID_LEVEL2' => $id]);
        return $this->db->affected_rows();
    }
}

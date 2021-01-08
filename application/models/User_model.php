<?php


defined('BASEPATH') or exit('No direct script access allowed');


class User_model extends CI_Model
{

    public function getUser($id = null)
    {
        if ($id === null) {
            return $this->db->get('user_admin')->result_array();
        } else {
            return $this->db->get_where('user_admin', ['GROUP_HAK_AKSES_ID' => $id])->result_array();
        }
    }

    public function addUser($data)
    {
        $this->db->insert('user_admin', $data);
        return $this->db->affected_rows();
    }

    public function editUser($data, $nama)
    {
        $this->db->update('user_admin', $data, ['NAMA' => $nama]);
        return $this->db->affected_rows();
    }

    public function deleteUser($nama)
    {
        $this->db->delete('user_admin', ['NAMA' => $nama]);
        return $this->db->affected_rows();
    }
}

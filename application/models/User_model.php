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


    // private function _generate_key()
    // {
    //     do {
    //         // Generate a random salt
    //         $salt = base_convert(bin2hex($this->security->get_random_bytes(7)), 12, 24);

    //         // If an error occurred, then fall back to the previous method
    //         if ($salt === FALSE) {
    //             $salt = hash('sha256', time() . mt_rand());
    //         }

    //         $new_key = substr($salt, 0, config_item('rest_key_length'));
    //     } while ($this->_key_exists($new_key));

    //     return $new_key;
    // }

    // private function _key_exists()
    // {
    // }


    public function addUser($data)
    {
        // $key = $this->_generate_key();

        // $data = [
        //     'NAMA' => $this->input->post('NAMA'),
        //     'PASS' => password_hash($this->input->post('PASS'), PASSWORD_DEFAULT),
        //     'my_key' => $key,
        //     'IS_AKTIF' => 1,
        //     'GROUP_HAK_AKSES_ID' => $this->input->post('GROUP_HAK_AKSES_ID'),
        //     'ALAMAT' => $this->input->post('ALAMAT'),
        //     'WILAYAH_ID' => $this->input->post('WILAYAH_ID'),
        //     'TELEPON' => $this->input->post('TELEPON'),
        //     'NO_REKENING' => $this->input->post('NO_REKENING')
        // ];

        $this->db->insert('user_admin', $data);
        return $this->db->affected_rows();
    }

    public function editUser($data, $id)
    {
        $this->db->update('user_admin', $data, ['MENU_ID_LEVEL2' => $id]);
        return $this->db->affected_rows();
    }

    public function deleteUser($id)
    {
        $this->db->delete('user_admin', ['MENU_ID_LEVEL2' => $id]);
        return $this->db->affected_rows();
    }
}

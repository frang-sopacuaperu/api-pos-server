<?php


defined('BASEPATH') or exit('No direct script access allowed');


class Auth_model extends CI_Model
{

    public function register($data)
    {
        $this->db->insert('user_admin', $data);
        return $this->db->affected_rows();
    }

    public function cek_login($nama)
    {
        $query = $this->db->get_where('user_admin')->result_array();

        if ($query > 0) {
            $result = $this->db->get_where('user_admin', ['NAMA' => $nama])->row_array();
        } else {
            $result = array();
        }
        return $result;
    }
}

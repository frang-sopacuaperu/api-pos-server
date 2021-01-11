<?php


defined('BASEPATH') or exit('No direct script access allowed');


class Jual_model extends CI_Model
{

    public function getJual($nota = null)
    {
        if ($nota === null) {
            return $this->db->get('jual')->result_array();
        } else {
            return $this->db->get_where('jual', ['NOTA' => $nota])->result_array();
        }
    }

    public function addJual($data)
    {
        $this->db->insert('jual', $data);
        return $this->db->affected_rows();
    }

    public function editJual($data, $nota)
    {
        $this->db->update('jual', $data, ['NOTA' => $nota]);
        return $this->db->affected_rows();
    }

    public function deleteJual($nota)
    {
        $this->db->delete('jual', ['NOTA' => $nota]);
        return $this->db->affected_rows();
    }
}

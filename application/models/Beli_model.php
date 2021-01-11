<?php


defined('BASEPATH') or exit('No direct script access allowed');


class Beli_model extends CI_Model
{

    public function getBeli($nota = null)
    {
        if ($nota === null) {
            return $this->db->get('beli')->result_array();
        } else {
            return $this->db->get_where('beli', ['NOTA' => $nota])->result_array();
        }
    }

    public function addBeli($data)
    {
        $this->db->insert('beli', $data);
        return $this->db->affected_rows();
    }

    public function editBeli($data, $nota)
    {
        $this->db->update('beli', $data, ['NOTA' => $nota]);
        return $this->db->affected_rows();
    }

    public function deleteBeli($nota)
    {
        $this->db->delete('beli', ['NOTA' => $nota]);
        return $this->db->affected_rows();
    }
}

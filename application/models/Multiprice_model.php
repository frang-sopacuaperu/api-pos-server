<?php


defined('BASEPATH') or exit('No direct script access allowed');


class Multiprice_model extends CI_Model
{

    public function getMultiprice($id = null)
    {
        if ($id === null) {
            return $this->db->get('multi_price')->result_array();
        } else {
            return $this->db->get_where('multi_price', ['BARANG_ID' => $id])->result_array();
        }
    }

    public function addMultiprice($data)
    {
        $this->db->insert('multi_price', $data);
        return $this->db->affected_rows();
    }

    public function editMultiprice($data, $id)
    {
        $this->db->update('multi_price', $data, ['BARANG_ID' => $id]);
        return $this->db->affected_rows();
    }

    public function deleteMultiprice($id)
    {
        $this->db->delete('multi_price', ['BARANG_ID' => $id]);
        return $this->db->affected_rows();
    }
}

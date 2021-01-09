<?php


defined('BASEPATH') or exit('No direct script access allowed');


class Customer_model extends CI_Model
{

    public function getCustomer($kode = null)
    {
        if ($kode === null) {
            return $this->db->get('customer')->result_array();
        } else {
            return $this->db->get_where('customer', ['KODE' => $kode])->result_array();
        }
    }

    public function addCustomer($data)
    {
        $this->db->insert('customer', $data);
        return $this->db->affected_rows();
    }

    public function editCustomer($data, $kode)
    {
        $this->db->update('customer', $data, ['KODE' => $kode]);
        return $this->db->affected_rows();
    }

    public function deleteCustomer($kode)
    {
        $this->db->delete('customer', ['KODE' => $kode]);
        return $this->db->affected_rows();
    }
}

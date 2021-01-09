<?php


defined('BASEPATH') or exit('No direct script access allowed');


class Salesman_model extends CI_Model
{

    public function getSalesman($kode = null)
    {
        if ($kode === null) {
            return $this->db->get('salesman')->result_array();
        } else {
            return $this->db->get_where('salesman', ['KODE' => $kode])->result_array();
        }
    }

    public function addSalesman($data)
    {
        $this->db->insert('salesman', $data);
        return $this->db->affected_rows();
    }

    public function editSalesman($data, $kode)
    {
        $this->db->update('salesman', $data, ['KODE' => $kode]);
        return $this->db->affected_rows();
    }

    public function deleteSalesman($kode)
    {
        $this->db->delete('salesman', ['KODE' => $kode]);
        return $this->db->affected_rows();
    }
}

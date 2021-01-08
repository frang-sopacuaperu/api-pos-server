<?php


defined('BASEPATH') or exit('No direct script access allowed');


class Wilayah_model extends CI_Model
{

    public function getWilayah($kode = null)
    {
        if ($kode === null) {
            return $this->db->get('wilayah')->result_array();
        } else {
            return $this->db->get_where('wilayah', ['KODE' => $kode])->result_array();
        }
    }

    public function addWilayah($data)
    {
        $this->db->insert('wilayah', $data);
        return $this->db->affected_rows();
    }

    public function editWilayah($data, $kode)
    {
        $this->db->update('wilayah', $data, ['KODE' => $kode]);
        return $this->db->affected_rows();
    }

    public function deleteWilayah($kode)
    {
        $this->db->delete('wilayah', ['KODE' => $kode]);
        return $this->db->affected_rows();
    }
}

<?php


defined('BASEPATH') or exit('No direct script access allowed');


class Golongan_model extends CI_Model
{

    public function getGolongan($kode = null)
    {
        if ($kode === null) {
            return $this->db->get('golongan')->result_array();
        } else {
            return $this->db->get_where('golongan', ['KODE' => $kode])->result_array();
        }
    }

    public function addGolongan($data)
    {
        $this->db->insert('golongan', $data);
        return $this->db->affected_rows();
    }

    public function editGolongan($data, $kode)
    {
        $this->db->update('golongan', $data, ['KODE' => $kode]);
        return $this->db->affected_rows();
    }

    public function deleteGolongan($kode)
    {
        $this->db->delete('golongan', ['KODE' => $kode]);
        return $this->db->affected_rows();
    }
}

<?php


defined('BASEPATH') or exit('No direct script access allowed');


class SubGolongan_model extends CI_Model
{

    public function getSubGolongan($kode = null)
    {
        if ($kode === null) {
            return $this->db->get('sub_golongan')->result_array();
        } else {
            return $this->db->get_where('sub_golongan', ['KODE' => $kode])->result_array();
        }
    }

    public function addSubGolongan($data)
    {
        $this->db->insert('sub_golongan', $data);
        return $this->db->affected_rows();
    }

    public function editSubGolongan($data, $kode)
    {
        $this->db->update('sub_golongan', $data, ['KODE' => $kode]);
        return $this->db->affected_rows();
    }

    public function deleteSubGolongan($kode)
    {
        $this->db->delete('sub_golongan', ['KODE' => $kode]);
        return $this->db->affected_rows();
    }
}

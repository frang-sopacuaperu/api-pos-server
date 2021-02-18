<?php


defined('BASEPATH') or exit('No direct script access allowed');


class Satuan_model extends CI_Model
{

    public function getSatuan($kode = null)
    {
        if ($kode === null) {
            return $this->db->get('satuan')->result_array();
        } else {
            return $this->db->get_where('satuan', ['KODE' => $kode])->result_array();
        }
    }

    public function addSatuan($data)
    {
        $this->db->insert('satuan', $data);
        return $this->db->affected_rows();
    }

    public function editSatuan($data, $kode)
    {
        $this->db->update('satuan', $data, ['KODE' => $kode]);
        return $this->db->affected_rows();
    }

    public function deleteSatuan($kode)
    {
        $this->db->delete('satuan', ['KODE' => $kode]);
        return $this->db->affected_rows();
    }
}

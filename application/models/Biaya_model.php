<?php


defined('BASEPATH') or exit('No direct script access allowed');


class Biaya_model extends CI_Model
{

    public function getBiaya($kode = null)
    {
        if ($kode === null) {
            return $this->db->get('biaya')->result_array();
        } else {
            return $this->db->get_where('biaya', ['KODE' => $kode])->result_array();
        }
    }

    public function addBiaya($data)
    {
        $this->db->insert('biaya', $data);
        return $this->db->affected_rows();
    }

    public function editBiaya($data, $kode)
    {
        $this->db->update('biaya', $data, ['KODE' => $kode]);
        return $this->db->affected_rows();
    }

    public function deleteBiaya($kode)
    {
        $this->db->delete('biaya', ['KODE' => $kode]);
        return $this->db->affected_rows();
    }
}

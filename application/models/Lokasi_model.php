<?php


defined('BASEPATH') or exit('No direct script access allowed');


class Lokasi_model extends CI_Model
{

    public function getLokasi($kode = null)
    {
        if ($kode === null) {
            return $this->db->get('lokasi')->result_array();
        } else {
            return $this->db->get_where('lokasi', ['KODE' => $kode])->result_array();
        }
    }

    public function addLokasi($data)
    {
        $this->db->insert('lokasi', $data);
        return $this->db->affected_rows();
    }

    public function editLokasi($data, $kode)
    {
        $this->db->update('lokasi', $data, ['KODE' => $kode]);
        return $this->db->affected_rows();
    }

    public function deleteLokasi($kode)
    {
        $this->db->delete('lokasi', ['KODE' => $kode]);
        return $this->db->affected_rows();
    }
}

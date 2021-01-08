<?php


defined('BASEPATH') or exit('No direct script access allowed');


class Jasa_model extends CI_Model
{

    public function getJasa($kode = null)
    {
        if ($kode === null) {
            return $this->db->get('jasa')->result_array();
        } else {
            return $this->db->get_where('jasa', ['KODE' => $kode])->result_array();
        }
    }

    public function addJasa($data)
    {
        $this->db->insert('jasa', $data);
        return $this->db->affected_rows();
    }

    public function editJasa($data, $kode)
    {
        $this->db->update('jasa', $data, ['KODE' => $kode]);
        return $this->db->affected_rows();
    }

    public function deleteJasa($kode)
    {
        $this->db->delete('jasa', ['KODE' => $kode]);
        return $this->db->affected_rows();
    }
}

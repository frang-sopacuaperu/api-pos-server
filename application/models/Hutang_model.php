<?php


defined('BASEPATH') or exit('No direct script access allowed');


class Hutang_model extends CI_Model
{

    public function getHutang($nomor = null)
    {
        if ($nomor === null) {
            return $this->db->get('pelunasan_hutang')->result_array();
        } else {
            return $this->db->get_where('pelunasan_hutang', ['NO_PELUNASAN' => $nomor])->result_array();
        }
    }

    public function addHutang($data)
    {
        $this->db->insert('pelunasan_hutang', $data);
        return $this->db->affected_rows();
    }

    public function editHutang($data, $nomor)
    {
        $this->db->update('pelunasan_hutang', $data, ['NO_PELUNASAN' => $nomor]);
        return $this->db->affected_rows();
    }

    public function deleteHutang($nomor)
    {
        $this->db->delete('pelunasan_hutang', ['NO_PELUNASAN' => $nomor]);
        return $this->db->affected_rows();
    }
}

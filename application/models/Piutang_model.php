<?php


defined('BASEPATH') or exit('No direct script access allowed');


class Piutang_model extends CI_Model
{

    public function getPiutang($nomor = null)
    {
        if ($nomor === null) {
            return $this->db->get('pelunasan_piutang')->result_array();
        } else {
            return $this->db->get_where('pelunasan_piutang', ['NO_PELUNASAN' => $nomor])->result_array();
        }
    }

    public function addPiutang($data)
    {
        $this->db->insert('pelunasan_piutang', $data);
        return $this->db->affected_rows();
    }

    public function editPiutang($data, $nomor)
    {
        $this->db->update('pelunasan_piutang', $data, ['NO_PELUNASAN' => $nomor]);
        return $this->db->affected_rows();
    }

    public function deletePiutang($nomor)
    {
        $this->db->delete('pelunasan_piutang', ['NO_PELUNASAN' => $nomor]);
        return $this->db->affected_rows();
    }
}

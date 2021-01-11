<?php


defined('BASEPATH') or exit('No direct script access allowed');


class Barang_model extends CI_Model
{

    public function getBarang($kode = null)
    {
        if ($kode === null) {
            return $this->db->get('barang')->result_array();
        } else {
            return $this->db->get_where('barang', ['KODE' => $kode])->result_array();
        }
    }

    public function addBarang($data)
    {
        $this->db->insert('barang', $data);
        return $this->db->affected_rows();
    }

    public function editBarang($data, $kode)
    {
        $this->db->update('barang', $data, ['KODE' => $kode]);
        return $this->db->affected_rows();
    }

    public function deleteBarang($kode)
    {
        $this->db->delete('barang', ['KODE' => $kode]);
        return $this->db->affected_rows();
    }
}

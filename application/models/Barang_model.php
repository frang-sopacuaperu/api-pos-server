<?php


defined('BASEPATH') or exit('No direct script access allowed');


class Barang_model extends CI_Model
{

    public function getBarang($kode = null)
    {
        if ($kode === null) {
            $query = "SELECT `barang`.*, `golongan`.`KETERANGAN` as `ket_gol`, `sub_golongan`.`KETERANGAN` as `ket_subgol`
                      FROM `barang`
                      JOIN `golongan` ON `barang`.`GOLONGAN_ID` = `golongan`.`KODE`
                      JOIN `sub_golongan` ON `barang`.`SUB_GOLONGAN_ID` = `sub_golongan`.`KODE`
            ";

            return $this->db->query($query)->result_array();
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

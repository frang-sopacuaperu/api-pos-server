<?php


defined('BASEPATH') or exit('No direct script access allowed');


class Barang_model extends CI_Model
{

    public function getBarang($kode = null)
    {
        if ($kode === null) {
            $query = "SELECT `barang`.*, `golongan`.`KETERANGAN` as `ket_gol`, `sub_golongan`.`KETERANGAN` as `ket_subgol`
                            --  ,`multi_price`.`BARANG_ID` as `id_bar`
                      FROM `barang`
                      JOIN `golongan` ON `barang`.`GOLONGAN_ID` = `golongan`.`KODE`
                      JOIN `sub_golongan` ON `barang`.`SUB_GOLONGAN_ID` = `sub_golongan`.`KODE`
                    --   JOIN `multi_price` ON `barang`.`KODE` = `multi_price`.`BARANG_ID`
            ";

            return $this->db->query($query)->result_array();
        } else {
            return $this->db->get_where('barang', ['KODE' => $kode])->result_array();
        }
    }

    public function addBarang($data, $data2)
    {
        $this->db->insert('barang', $data);

        // get kode barang
        $barang_id = $data['KODE'];

        $this->db->insert_batch('multi_price', $data2);

        return $this->getBarang($barang_id);
        // return $this->db->affected_rows();
    }

    public function editBarang($data, $data2, $kode)
    {
        $this->db->update('barang', $data, ['KODE' => $kode]);

        $barang_id = $data['KODE'];

        $this->db->update_batch('multi_price', $data2);

        return $this->getBarang($barang_id);
        // return $this->db->affected_rows();
    }

    public function deleteBarang($kode)
    {
        $this->db->delete('barang', ['KODE' => $kode]);
        return $this->db->affected_rows();
    }
}

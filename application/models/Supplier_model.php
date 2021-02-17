<?php


defined('BASEPATH') or exit('No direct script access allowed');


class Supplier_model extends CI_Model
{

    public function getSupplier($kode = null)
    {
        if ($kode === null) {
            $query = "SELECT `supplier`.*, `wilayah`.`KETERANGAN`
                      FROM `supplier`
                      JOIN `wilayah` ON `supplier`.`WILAYAH_ID` = `wilayah`.`KODE`
            ";

            return $this->db->query($query)->result_array();
        } else {
            return $this->db->get_where('supplier', ['KODE' => $kode])->result_array();
        }
    }

    public function addSupplier($data)
    {
        $this->db->insert('supplier', $data);
        return $this->db->affected_rows();
    }

    public function editSupplier($data, $kode)
    {
        $this->db->update('supplier', $data, ['KODE' => $kode]);
        return $this->db->affected_rows();
    }

    public function deleteSupplier($kode)
    {
        $this->db->delete('supplier', ['KODE' => $kode]);
        return $this->db->affected_rows();
    }
}

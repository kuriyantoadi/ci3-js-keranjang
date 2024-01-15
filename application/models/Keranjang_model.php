<?php
class Keranjang_model extends CI_Model {
    
    public function tambah_ke_keranjang($data) {
        return $this->db->insert('tb_keranjang', $data);
    }

    public function get_keranjang() {
        return $this->db->get('tb_keranjang')->result_array();
    }

    public function cek_id_barang($id_barang) {
        $this->db->where('id_barang', $id_barang);
        $query = $this->db->get('tb_keranjang');

        return $query->num_rows() > 0;
    }

    public function keranjang_hapus($id_barang)
    {
        $this->db->where('id_barang',$id_barang);
        $this->db->delete('tb_keranjang');
    }


}

<?php
class Keranjang_model extends CI_Model {
    
    public function tambah_ke_keranjang($data) {
        return $this->db->insert('keranjang', $data);
    }

    public function get_keranjang() {
        return $this->db->get('keranjang')->result_array();
    }


}

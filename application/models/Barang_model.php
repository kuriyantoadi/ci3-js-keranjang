<?php
class Barang_model extends CI_Model {
    
    public function get_barang() {
        return $this->db->get('barang')->result_array();
    }

}

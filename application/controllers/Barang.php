<?php
class Barang extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Barang_model');
        $this->load->model('Keranjang_model');
    }

    public function index() {
        $data['barang'] = $this->Barang_model->get_barang();
        $this->load->view('daftar_barang', $data);
    }

    public function tampil_keranjang() {
        // Mengambil data barang dari model
        $data_keranjang= $this->Keranjang_model->get_keranjang();

        // Mengirim data sebagai respons JSON
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data_keranjang));
    }

    public function tambah_ke_keranjang() {
        $data = array(
            'nama_barang' => $this->input->post('nama_barang'),
            'harga' => $this->input->post('harga'),
            'jumlah' => $this->input->post('jumlah')
        );

        $result = $this->Keranjang_model->tambah_ke_keranjang($data);

        if ($result) {
            echo json_encode(['message' => 'Barang berhasil ditambahkan ke keranjang.']);
        } else {
            echo json_encode(['message' => 'Gagal menambahkan barang ke keranjang.']);
        }
    }
}

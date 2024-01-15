<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabel Barang dan Keranjang</title>
    <style>
        /* Menambahkan sedikit gaya untuk mempercantik tampilan */
        table {
            width: 50%;
            margin-bottom: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        #keranjang {
            width: 50%;
        }
    </style>
</head>
<body>

<h2>Daftar Barang</h2>
<table border="1" id="tabelBarang">
    <thead>
        <tr>
            <th>Nama Barang</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th></th> <!-- Kolom untuk tombol tambah -->
        </tr>
    </thead>
    <tbody>
        <!-- Baris-baris barang -->
        <?php foreach ($barang as $item): ?>
        <tr>
            <td><?= $item['nama_barang']; ?></td>
            <td><?= $item['harga']; ?></td>
            <td><input type="number" id="jumlahBarang<?= $item['id_barang']; ?>" value="1" min="1"></td>
            <td><button class="tambahBarang" onclick="tambahKeKeranjang('<?= $item['nama_barang']; ?>', <?= $item['harga']; ?>, 'jumlahBarang<?= $item['id_barang']; ?>', <?= $item['id_barang']; ?>)">Tambah</button></td>
        </tr>
        <?php endforeach; ?>
        <!-- Tambah baris-baris barang lainnya sesuai kebutuhan -->
    </tbody>
</table>

<h2>Keranjang</h2>
<table border="1" id="tabelKeranjang">
    <thead>
        <tr>
            <th>Id Barang</th>
            <th>Nama Barang</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Pilihan</th>
        </tr>
    </thead>
    <tbody id="tabelKeranjang">
        <!-- Baris-baris keranjang -->
    </tbody>
</table>

<script>
    // Fungsi untuk menambahkan barang ke keranjang
    function tambahKeKeranjang(namaBarang, harga, inputId, idBarang) {
        var jumlah = document.getElementById(inputId).value;

        // Kirim data ke server PHP untuk disimpan di database
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '<?= base_url('barang/tambah_ke_keranjang'); ?>', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                const result = JSON.parse(xhr.responseText);
                console.log(result);

                // Refresh data keranjang setelah menambah barang
                fetchData();
            }
        };
        xhr.send('nama_barang=' + encodeURIComponent(namaBarang) + '&harga=' + harga + '&jumlah=' + jumlah + '&id_barang=' + idBarang);
    }


    // Fungsi untuk mendapatkan data barang dari server
    async function fetchData() {
        const response = await fetch('<?= base_url('barang/tampil_keranjang'); ?>');
        const data = await response.json();

        const tabelKeranjang = document.getElementById('tabelKeranjang').getElementsByTagName('tbody')[0];
        tabelKeranjang.innerHTML = '';

        data.forEach((tampil_kolom) => {
            const row = tabelKeranjang.insertRow();
            row.insertCell(0).textContent = tampil_kolom.id_barang;
            row.insertCell(1).textContent = tampil_kolom.nama_barang;
            row.insertCell(2).textContent = tampil_kolom.harga;
            row.insertCell(3).textContent = tampil_kolom.jumlah; // Ganti indeks ke-1 dengan ke-2
            
            // awal mode hapus 
            // Mendapatkan nilai id_barang dari PHP
            var id_barang = tampil_kolom.id_barang;

            // Mendapatkan nilai base_url dari PHP
            var base_url = '<?= base_url(); ?>';

            // Membuat link untuk tombol hapus
            var deleteLink = base_url + 'Barang/keranjang_hapus/' + id_barang;

            // Membuat elemen tombol hapus dengan Bootstrap styling
            var deleteButton = document.createElement('button');
            deleteButton.className = 'btn btn-danger'; // Menambahkan kelas Bootstrap untuk warna merah (danger)
            deleteButton.textContent = 'Hapus Barang';

            // Menambahkan tombol ke dalam sel ke-4 di baris tabel
            var cell = row.insertCell(4);
            cell.appendChild(deleteButton);

            // Menambahkan event listener untuk menampilkan konfirmasi sebelum menghapus
            deleteButton.addEventListener('click', function(event) {
                // Tampilkan alert konfirmasi
                if (!confirm('Apakah Anda yakin ingin menghapus barang ini?')) {
                    event.preventDefault(); // Mencegah tindakan default tombol jika pembatalan diklik
                } else {
                    // Jika konfirmasi diterima, navigasi ke tautan penghapusan
                    window.location.href = deleteLink;
                }
            });

            // akhir mode hapus

        });
    }
    fetchData();   
    

</script>

</body>
</html>

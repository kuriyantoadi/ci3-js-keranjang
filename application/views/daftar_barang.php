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
            <td><input type="number" id="jumlahBarang<?= $item['id']; ?>" value="1" min="1"></td>
            <td><button class="tambahBarang" onclick="tambahKeKeranjang('<?= $item['nama_barang']; ?>', <?= $item['harga']; ?>, 'jumlahBarang<?= $item['id']; ?>')">Tambah</button></td>
        </tr>
        <?php endforeach; ?>
        <!-- Tambah baris-baris barang lainnya sesuai kebutuhan -->
    </tbody>
</table>

<h2>Keranjang</h2>
<table border="1" id="tabelKeranjang">
    <thead>
        <tr>
            <th>Nama Barang</th>
            <th>Harga</th>
            <th>Jumlah</th>
        </tr>
    </thead>
    <tbody id="tabelKeranjang">
        <!-- Baris-baris keranjang -->
    </tbody>
</table>

<script>
    // Fungsi untuk menambahkan barang ke keranjang
    function tambahKeKeranjang(namaBarang, harga, inputId) {
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
        xhr.send('nama_barang=' + encodeURIComponent(namaBarang) + '&harga=' + harga + '&jumlah=' + jumlah);
    }

    // Fungsi untuk mendapatkan data barang dari server
    async function fetchData() {
        const response = await fetch('<?= base_url('barang'); ?>/tampil_barang');
        const data = await response.json();

        const tabelBarang = document.getElementById('tabelBarang').getElementsByTagName('tbody')[0];
        tabelBarang.innerHTML = '';

        data.forEach((barang) => {
            const row = tabelBarang.insertRow();
            row.insertCell(0).textContent = barang.nama_barang;
            row.insertCell(1).textContent = barang.harga;
            row.insertCell(2).innerHTML = `<input type="number" id="jumlahBarang${barang.id}" value="1" min="1">`;
            row.insertCell(3).innerHTML = `<button class="tambahBarang" onclick="tambahKeKeranjang('${barang.nama_barang}', ${barang.harga}, 'jumlahBarang${barang.id}')">Tambah</button>`;
        });
    }

    async function fetchData() {
        const response = await fetch('<?= base_url('barang/tampil_keranjang'); ?>');
        const data = await response.json();

        const tabelKeranjang = document.getElementById('tabelKeranjang').getElementsByTagName('tbody')[0];
        tabelKeranjang.innerHTML = '';

        data.forEach((barang) => {
            const row = tabelKeranjang.insertRow();
            row.insertCell(0).textContent = barang.nama_barang;
            row.insertCell(1).textContent = barang.harga;
            row.insertCell(1).textContent = barang.jumlah;
        });
    }

    // Memanggil fungsi fetchData untuk mendapatkan data barang
    fetchData();

</script>

</body>
</html>

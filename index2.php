<?php
include("koneksi.php");

$result = mysqli_query($koneksi, "SELECT * FROM `produk` ORDER BY id DESC");
?>

<html>
<head>
    <title>Homepage</title>
    <style>
        body {
            background-color: #121212;
            color: #ffffff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 50px auto;
            padding: 20px;
            background-color: #fffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.5);
        }
        h1 {
            text-align: center;
        }
        a {
            color: #bb86fc;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px 0;
            background-color: #bb86fc;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            text-align: center;
            cursor: pointer;
            text-decoration: none;
        }
        .button:hover {
            background-color: #9b59c6;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #2e2e2e;
            text-align: left;
        }
        th {
            background-color: #333333;
        }
        td img {
            max-width: 100px;
            max-height: 100px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Product List</h1>
        <a href="tambah.php" class="button">Add New Product</a>
        <a href="product.php" class="button">Back to Homepage</a>
        <table>
            <tr>
                <th>Nama Barang</th>
                <th>Harga Barang</th>
                <th>Gambar Barang</th>
                <th>Update</th>
                <th>Delete</th>
            </tr>
            <?php
// Fungsi untuk format harga
function formatHarga($harga) {
    return "Rp " . number_format($harga, 0, ',', '.');
}

while($user_data = mysqli_fetch_array($result)) {
    $hargaFormatted = formatHarga($user_data['harga_produk']);
    echo "<tr>";
    echo "<td>".$user_data['nama_barang']."</td>";
    echo "<td>".$hargaFormatted."</td>"; // Format harga
    echo "<td><img src='images/".$user_data['gambar_produk']."' alt='Gambar Barang'></td>";
    echo "<td><a href='edit.php?id=$user_data[id]'>Edit</a></td>";
    echo "<td><a href='hapus.php?id=$user_data[id]'>Delete</a></td>";
    echo "</tr>";
}
?>

        </table>
    </div>
</body>
</html>

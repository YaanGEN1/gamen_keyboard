<?php
session_start();
include("koneksi.php"); // Pastikan untuk mengimpor koneksi database

// Fungsi untuk format harga
function formatHarga($harga)
{
    return "Rp " . number_format($harga, 0, ',', '.');
}

// Proses penghapusan dari keranjang
if (isset($_POST['hapus_item'])) {
    $index_hapus = $_POST['index']; // Ambil index dari POST
    if (isset($_SESSION['keranjang'][$index_hapus])) {

        // Cek apakah 'id' ada dalam item yang akan dihapus
        if (isset($_SESSION['keranjang'][$index_hapus]['id'])) {
            $id = $_SESSION['keranjang'][$index_hapus]['id'];

            // Hapus produk dari database
            $query = "DELETE FROM keranjang WHERE id = '$id' LIMIT 1";
            if (!mysqli_query($koneksi, $query)) {
                echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
            }
        }

        // Hapus produk dari session keranjang
        unset($_SESSION['keranjang'][$index_hapus]);
        
        // Reindex array untuk menjaga urutan yang konsisten
        $_SESSION['keranjang'] = array_values($_SESSION['keranjang']);
    }
}


// Proses penambahan ke keranjang menggunakan POST
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id']) && isset($_POST['nama']) && isset($_POST['harga'])) {
    $id = $_POST['id'];  
    $nama_barang = $_POST['nama'];
    $harga_barang = $_POST['harga'];

    // Buat session untuk keranjang jika belum ada
    if (!isset($_SESSION['keranjang'])) {
        $_SESSION['keranjang'] = [];
    }

    // Tambahkan produk ke dalam session keranjang
    $_SESSION['keranjang'][] = [
        'id' => $id,
        'nama' => $nama_barang,
        'harga' => $harga_barang,
        'jumlah' => 1
    ];
}

// Proses update jumlah
if (isset($_POST['update_jumlah']) && $_POST['update_jumlah'] == "true") {
    $index = $_POST['index'];
    $new_quantity = (int) $_POST['jumlah'];

    // Update jumlah produk di session keranjang
    if (isset($_SESSION['keranjang'][$index])) {
        $_SESSION['keranjang'][$index]['jumlah'] = $new_quantity;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <style>
        .cart-container {
            margin: 20px;
        }

        .cart-table {
            width: 100%;
            border-collapse: collapse;
        }

        .cart-table th,
        .cart-table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        .cart-table th {
            background-color: #f4f4f4;
        }

        .btn-checkout {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #FF2D00;
            color: #ffffff;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-checkout:hover {
            background-color: #ff4400;
        }

        .btn-hapus {
            padding: 5px 10px;
            background-color: #FF0000;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-hapus:hover {
            background-color: #cc0000;
        }
    </style>
</head>

<body>
    <div class="cart-container">
        <h2>Isi Keranjang Anda</h2>
        <?php if (!empty($_SESSION['keranjang'])): ?>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Initialize total amount variable
                    $total = 0;

                    // Loop through the session cart items
                    if (isset($_SESSION['keranjang']) && count($_SESSION['keranjang']) > 0) {
                        foreach ($_SESSION['keranjang'] as $index => $item) {
                            // Calculate subtotal for each item
                            $subtotal = $item['harga'] * $item['jumlah'];

                            // Add subtotal to the total
                            $total += $subtotal;
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['nama']); ?></td>
                                <td><?php echo "Rp " . number_format($item['harga'], 0, ',', '.'); ?></td>
                                <td>
                                    <!-- Update form to modify quantity -->
                                    <form method="POST" action="">
                                        <input type="number" name="jumlah" value="<?php echo htmlspecialchars($item['jumlah']); ?>"
                                            min="1" onchange="this.form.submit()">
                                        <input type="hidden" name="index" value="<?php echo $index; ?>">
                                        <input type="hidden" name="update_jumlah" value="true">
                                    </form>
                                </td>
                                <td><?php echo "Rp " . number_format($subtotal, 0, ',', '.'); ?></td>
                                <td>
                                    <form method="POST" action="">
                                        <input type="hidden" name="index" value="<?php echo $index; ?>">
                                        <input type="hidden" name="hapus_item" value="true">
                                        <button type="submit" class="btn-hapus">Hapus</button>
                                    </form>
                                </td>

                            </tr>
                            <?php
                        }
                    } else {
                        // If cart is empty
                        echo "<tr><td colspan='5'>Keranjang kosong</td></tr>";
                    }
                    ?>
                    <tr>
                        <td colspan="3">Total</td>
                        <td><?php echo "Rp " . number_format($total, 0, ',', '.'); ?></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            <a href='cart.php' class='btn-checkout'>Pembayaran</a>
        <?php else: ?>
            <p>Keranjang Anda kosong. Silakan <a href='product.php'>tambahkan beberapa produk terlebih dahulu</a>.</p>
            <a href='index.php' class='btn-checkout'>Kembali ke Halaman Home</a>
        <?php endif; ?>
    </div>
</body>

</html>
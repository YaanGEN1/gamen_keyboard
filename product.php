<?php
session_start();
include("koneksi.php");

// Ambil input pencarian dari form, jika ada
$search_query = isset($_GET['search']) ? $_GET['search'] : '';

// Jika ada pencarian, gunakan query untuk mencari produk, jika tidak, tampilkan semua produk
if (!empty($search_query)) {
    $result = mysqli_query($koneksi, "SELECT * FROM produk WHERE nama_barang LIKE '%$search_query%' ORDER BY id DESC");
} else {
    $result = mysqli_query($koneksi, "SELECT * FROM produk ORDER BY id DESC");
}

// Proses penambahan ke keranjang
if (isset($_POST['tambah_keranjang'])) {
    $nama_barang = $_POST['nama'];
    $harga_barang = $_POST['harga'];
    $gambar_produk = $_POST['gambar'];
    $jumlah_barang = 1; // Default jumlah barang

    // Buat session untuk keranjang jika belum ada
    if (!isset($_SESSION['keranjang'])) {
        $_SESSION['keranjang'] = [];
    }

    // Tambahkan produk ke dalam session keranjang
    $_SESSION['keranjang'][] = [
        'nama' => $nama_barang,
        'harga' => $harga_barang,
        'jumlah' => $jumlah_barang,
        'gambar' => $gambar_produk
    ];

    // Masukkan produk ke dalam tabel keranjang di database
    $query = "INSERT INTO keranjang (nama_produk, harga, jumlah, gambar, user_id) VALUES ('$nama_barang', '$harga_barang', '$jumlah_barang', '$gambar_produk', '1')";
    if (!mysqli_query($koneksi, $query)) {
        echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
    }
}

// Hitung total produk di keranjang untuk ditampilkan
$total_produk = isset($_SESSION['keranjang']) ? count($_SESSION['keranjang']) : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Produk</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="footer.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.2.1/css/fontawesome.min.css">
    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- CSS untuk search bar -->
    <style>
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .search-container {
            display: flex;
            align-items: center;
        }

        .search-container form {
            display: flex;
            margin-left: 10px;
        }

        .search-container input[type="text"] {
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 30px 0 0 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            outline: none;
            transition: all 0.3s ease;
        }

        .search-container input[type="text"]:focus {
            border-color: #FF2D00;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .search-container button {
            padding: 12px 15px;
            border: none;
            border-radius: 0 30px 30px 0;
            background-color: #FF2D00;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .search-container button i {
            margin-right: 5px;
        }

        .search-container button:hover {
            background-color: #ff4400;
        }

        .btn-keranjang {
            display: inline-block;
            margin-top: 10px;
            padding: 5px 10px;
            background-color: #FF2D00;
            color: #ffffff;
            font-size: 14px;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .btn-keranjang:hover {
            background-color: #ff4400;
        }

        .navbar a span {
            background-color: #FF2D00;
            color: #fff;
            border-radius: 50%;
            padding: 3px 8px;
            font-size: 12px;
            margin-left: 5px;
            vertical-align: middle;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <!-- Navbar -->
        <div class="container">
            <div class="navbar">
                <div class="logo">
                    <img src="images/Razer beta.png" width="125px">
                </div>

                <!-- Search Bar -->
                <div class="search-container">
                    <form action="product.php" method="GET">
                        <input type="text" placeholder="Cari produk..." name="search" value="<?php echo htmlspecialchars($search_query); ?>">
                        <button type="submit">
                        <i class="fa fa-search"></i></button>
                    </form>
                </div>

                <nav>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <?php if (isset($_SESSION['level']) && $_SESSION['level'] !== 'admin'): ?>
                            <li>
                                <a href="isikeranjang.php">
                                    <img src="images/Keranjang.png" alt=""
                                        style="width: 20px; height: 20px; vertical-align: middle; margin-right: 5px;">
                                    <span><?php echo $total_produk; ?></span> <!-- Tampilkan jumlah produk di keranjang -->
                                </a>
                            <?php endif; ?>
                        <?php if (isset($_SESSION['level']) && $_SESSION['level'] == 'admin'): ?>
                        <li><a href="index2.php">Tambah</a></li>
                        <?php endif; ?>
                        <li><a href="https://wa.me/6281936932988">Kontak</a></li>
                        <li class="dropdown">
                        <?php if (isset($_SESSION['username'])) { ?>
                            <a href="#" class="dropbtn"><?php echo $_SESSION['username']; ?> &#9662;</a>
                            <div class="dropdown-content">
                                <a href="profil.php">Profil</a>
                            </div>
                        <?php } else { ?>
                            <a href="login.php" class="dropbtn">MASUK</a>
                        <?php } ?>
                    </li>
                    </ul>
                </nav>
            </div>
            <br><br><br>
            <div class="row">
                <div class="small-container">
                    <h2 class="title">List Produk</h2>
                </div>
                <div class="row">
                    <?php
                    // Fungsi untuk format harga
                    function formatHarga($harga) {
                        return "Rp " . number_format($harga, 0, ',', '.');
                    }

                    // Tampilkan produk berdasarkan hasil pencarian atau semua produk
                    while($produk_data = mysqli_fetch_array($result)) {
                        $kategori = isset($produk_data['kategori']) ? $produk_data['kategori'] : 'unknown';
                        $hargaFormatted = formatHarga($produk_data['harga_produk']);
                        echo "<div class='col-4 category-{$kategori}'>";
                        echo "<form method='POST' action=''>";
                        echo "<img src='images/{$produk_data['gambar_produk']}' alt='{$produk_data['nama_barang']}'>";
                        echo "<h4>{$produk_data['nama_barang']}</h4>";
                        echo "<p>{$hargaFormatted}</p>";
                        echo "<input type='hidden' name='nama' value='{$produk_data['nama_barang']}'>";
                        echo "<input type='hidden' name='harga' value='{$produk_data['harga_produk']}'>";
                        echo "<input type='hidden' name='gambar' value='{$produk_data['gambar_produk']}'>";
                        echo "<button type='submit' name='tambah_keranjang' class='btn-keranjang'>Tambah ke Keranjang</button>";
                        echo "</form>";
                        echo "</div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", () => {
        const darkModeStatus = localStorage.getItem("darkMode");

        if (darkModeStatus === "enabled") {
            document.body.classList.add("dark-mode");
        } else {
            document.body.classList.remove("dark-mode");
        }
    });
    </script>
</body>
</html>

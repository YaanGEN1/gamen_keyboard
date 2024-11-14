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
    <title>Razer Mouse</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="footer.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.2.1/css/fontawesome.min.css">
    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
</head>

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
</style>

<body>
    <!-- Header -->
    <div class="header">
        <div class="container">
            <div class="navbar">
                <div class="logo">
                    <img src="images/Razer beta.png" width="125px">
                </div>
                <!-- Search Bar -->
                <div class="search-container">
                    <form action="product.php" method="GET">
                        <input type="text" placeholder="Cari produk..." name="search"
                            value="<?php echo htmlspecialchars($search_query); ?>">
                        <button type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </form>
                </div>
                <nav>
                    <ul>
                        <li><a href="product.php">Produk</a></li>
                        <?php if (isset($_SESSION['level']) && $_SESSION['level'] !== 'admin'): ?>
                            <li>
                                <a href="isikeranjang.php">
                                    <img src="images/Keranjang.png" alt=""
                                        style="width: 20px; height: 20px; vertical-align: middle; margin-right: 5px;">
                                    <span><?php echo $total_produk; ?></span> <!-- Tampilkan jumlah produk di keranjang -->
                                </a>
                            <?php endif; ?>
                        </li>
                        <li><a href="https://wa.me/6281936932988">Chat</a></li>
                        <li class="dropdown">
                            <?php if (isset($_SESSION['username'])) { ?>
                                <a href="#" class="dropbtn"><?php echo $_SESSION['username']; ?> &#9662;</a>
                                <div class="dropdown-content">
                                    <a href="profil.php">Profil</a>
                                    <a href="about.php">Tentang</a>
                                    <!-- <a href="pesanan.php">Pesanan</a> -->
                                </div>
                            <?php } else { ?>
                                <a href="login.php" class="dropbtn">MASUK</a>
                            <?php } ?>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-2 promo-content">
                <h1>Nikmati pengalaman gaming <br>Menggunakan Razer Deathadder V2 Mini</h1>
                <p>Ditenagai oleh sensor Pixart PAW3359<br>yang mencapai 8500dpi (300ips)</p>
                <a href="https://www.razer.com/ca-en/gaming-mice/razer-deathadder-v2-mini" class="btn">Lihat Sekarang
                    &#8594;</a>
            </div>
            <div class="col-2 promo-image">
                <img src="images/image1.png">
            </div>
        </div>

        <style>
            .promo-content {
                margin-left: 100px;
                /* Menambahkan margin agar teks lebih ke kanan */
            }

            .promo-image {
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .promo-content h1 {
                font-size: 36px;
                font-weight: 700;
                color: #fff;
                margin-bottom: 20px;
            }

            .promo-content p {
                font-size: 18px;
                color: #fff;
                margin-bottom: 30px;
            }

            .promo-content .btn {
                background-color: #00FF00;
                padding: 10px 20px;
                text-decoration: none;
                color: #000;
                border-radius: 5px;
            }

            .promo-content .btn:hover {
                background-color: #00cc00;
            }
        </style>

        <!-- List Produk -->
        <div class="small-container">
            <h2 class="title">List Produk</h2>
            <div class="row">
                <?php
                // Fungsi untuk format harga
                function formatHarga($harga)
                {
                    return "Rp " . number_format($harga, 0, ',', '.');
                }

                // Tampilkan produk berdasarkan hasil pencarian atau semua produk
                while ($produk_data = mysqli_fetch_array($result)) {
                    $kategori = isset($produk_data['kategori']) ? $produk_data['kategori'] : 'unknown';
                    $hargaFormatted = formatHarga($produk_data['harga_produk']);
                    echo "<div class='col-4 category-{$kategori}'>";

                    // Check if user is logged in
                    if (isset($_SESSION['username'])) {
                        // If logged in, allow product to be added to the cart
                        echo "<form method='POST' action=''>";
                        echo "<img src='images/{$produk_data['gambar_produk']}' alt='{$produk_data['nama_barang']}'>";
                        echo "<h4>{$produk_data['nama_barang']}</h4>";
                        echo "<p>{$hargaFormatted}</p>";
                        echo "<input type='hidden' name='nama' value='{$produk_data['nama_barang']}'>";
                        echo "<input type='hidden' name='harga' value='{$produk_data['harga_produk']}'>";
                        echo "<input type='hidden' name='gambar' value='{$produk_data['gambar_produk']}'>";
                        echo "<button type='submit' name='tambah_keranjang' class='btn-keranjang'>Tambah ke Keranjang</button>";
                        echo "</form>";
                    } else {
                        // If not logged in, show alert and prevent form submission
                        echo "<img src='images/{$produk_data['gambar_produk']}' alt='{$produk_data['nama_barang']}'>";
                        echo "<h4>{$produk_data['nama_barang']}</h4>";
                        echo "<p>{$hargaFormatted}</p>";
                        echo "<button type='button' onclick='alertLogin()' class='btn-keranjang'>Tambah ke Keranjang</button>";
                    }

                    echo "</div>";
                }
                ?>

            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="container-fluid bg-dark text-secondary mt-5 pt-5">
        <div class="row px-xl-5 pt-5">
            <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
                <h5 class="text-secondary text-uppercase mb-4"></h5>
                <p class="mb-4">Toko ini menjual mouse</p>
                <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>NGANTUK</p>
                <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>MAGER</p>
                <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i>085234020830</p>
            </div>
            <div class="d-flex">
                <a class="btn btn-primary btn-square mr-2" href="#"><i class="fab fa-twitter"></i></a>
                <a class="btn btn-primary btn-square mr-2" href="#"><i class="fab fa-facebook-f"></i></a>
                <a class="btn btn-primary btn-square mr-2" href="#"><i class="fab fa-linkedin-in"></i></a>
                <a class="btn btn-primary btn-square" href="#"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
        <div class="row border-top mx-xl-5 py-4" style="border-color: rgba(256, 256, 256, .1) !important;">
            <div class="col-md-6 px-xl-0">
                <p class="mb-md-0 text-center text-md-left text-secondary">
                    &copy; <a class="text-primary" href="#">Domain</a>. All Rights Reserved. Designed by
                    <a class="text-primary" href="https://www.youtube.com/@t.a.gchannel">.</a>
                </p>
            </div>
            <div class="col-md-6 px-xl-0 text-center text-md-right">
                <img class="img-fluid" src="img/payments.png" alt="">
            </div>
        </div>
    </div>
    <!-- Footer End -->

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

    <script>
        function alertLogin() {
            alert("Silakan login terlebih dahulu untuk menambah produk ke keranjang.");
            window.location.href = 'login.php'; // Redirect to login page
        }
    </script>
</body>

</html>
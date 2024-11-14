<?php
session_start();

// Periksa apakah pengguna sudah login, jika tidak, arahkan ke halaman login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<?php
include("koneksi.php");

// Ambil input pencarian dari form
$search_query = isset($_GET['search']) ? $_GET['search'] : '';

if (!empty($search_query)) {
    // Query untuk mencari produk berdasarkan nama
    $result = mysqli_query($koneksi, "SELECT * FROM produk WHERE nama_barang LIKE '%$search_query%'");
} else {
    // Jika tidak ada input pencarian, tampilkan semua produk
    $result = mysqli_query($koneksi, "SELECT * FROM produk ORDER BY id DESC");
}
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
    display: flex; /* Use flexbox for layout */
    align-items: center; /* Center items vertically */
}

.search-container input[type="text"] {
    padding: 10px;
    border: none;
    border-radius: 10px 0 0 10px;
    width: 600px; /* Increase this value to extend the search bar */
    min-width: 400px; /* Set a minimum width */
}

.search-container button {
    padding: 10px;
    border: none;
    border-radius: 0 10px 10px 0;
    background-color: #FF2D00;
    color: white;
    cursor: pointer;
    height: 100%; /* Ensure the button matches the height of the input */
}

.search-container button {
    padding: 10px;
    border: none;
    border-radius: 0 10px 10px 0;
    background-color: #FF2D00;
    color: white;
    cursor: pointer;
    height: 100%; /* Match height to input */
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
                    <form action="search.php" method="GET">
                        <input type="text" placeholder="Cari produk..." name="search">
                        <label for="category-filter"></label>
                        <select id="category-filter" onchange="filterByCategory(this.value)">
                            <option value="all">SEMUA</option>
							<option value="ram">RAM</option>
							<option value="ssd">SSD</option>
							<option value="vga">VGA</option>
							<option value="cpu">CPU</option>
                            <option value="mobo">MOBO</option>
                        </select>
                        <button type="submit">Cari</button>
                    </form>
                </div>

                <nav>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <a href="#" id="cart-icon" onclick="addToCart('Razer Viper V3', 3000)">
                        <img src="images/Keranjang.png" alt="" style="width: 20px; height: 20px; vertical-align: middle; margin-right: 5px;">
                        </a>
                        <li><a href="index2.php">Tambah</a></li>
                        <li><a href="https://wa.me/6281936932988">Kontak</a></li>
                        <li class="dropdown">

    <a href="#" class="dropbtn">AKUN &#9662;</a>
    <div class="dropdown-content">
        <a href="profil.php">Profil</a>
        <a href="settings.php">Settings</a>
        <a href="logout.php">Logout</a>
    </div>
</li>

                    </ul>
                </nav>
            </div>
            <div class="row">
                <div class="small-container"></br></br></br></br>
                    <h2 class="title">List Produk</h2>
  			</div>
			<div class="row">
            </div>
    <div class="row">

    <?php
// Fungsi untuk format harga
function formatHarga($harga) {
    return "Rp " . number_format($harga, 0, ',', '.');
}

while($produk_data = mysqli_fetch_array($result)) {
    $kategori = isset($produk_data['kategori']) ? $produk_data['kategori'] : 'unknown';
    $hargaFormatted = formatHarga($produk_data['harga_produk']);
    echo "<div class='col-4 category-{$kategori}'>";
    echo "<a href='cart.php?nama={$produk_data['nama_barang']}&harga={$produk_data['harga_produk']}&jumlah=1'>";
    echo "<img src='images/{$produk_data['gambar_produk']}' alt='{$produk_data['nama_barang']}'>";
    echo "</a>";
    echo "<h4>{$produk_data['nama_barang']}</h4>";
    echo "<p>{$hargaFormatted}</p>"; // Format harga
    echo "</div>";
}
?>

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

<!------footer------>

<div class="container-fluid bg-dark text-secondary mt-5 pt-5">
        <div class="row px-xl-5 pt-5">
            <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
                <h5 class="text-secondary text-uppercase mb-4">Get In Touch</h5>
                <p class="mb-4">Toko ini menjual mouse</p>
                <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>Jalan Teknik Lingkungan Blok i No.13</p>
                <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>tagchannel23@gmail.com</p>
                <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i>085234020830</p>
            </div>
                        <div class="d-flex">
                            <a class="btn btn-primary btn-square mr-2" href="#"><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-primary btn-square mr-2" href="#"><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-primary btn-square mr-2" href="#"><i class="fab fa-linkedin-in"></i></a>
                            <a class="btn btn-primary btn-square" href="#"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row border-top mx-xl-5 py-4" style="border-color: rgba(256, 256, 256, .1) !important;">
            <div class="col-md-6 px-xl-0">
                <p class="mb-md-0 text-center text-md-left text-secondary">
                    &copy; <a class="text-primary" href="#">Domain</a>. All Rights Reserved. Designed
                    by
                    <a class="text-primary" href="https://htmlcodex.com">HTML Codex</a>
                </p>
            </div>
            <div class="col-md-6 px-xl-0 text-center text-md-right">
                <img class="img-fluid" src="img/payments.png" alt="">
            </div>
        </div>
    </div>
    <!-- Footer End -->

</body>
</html>
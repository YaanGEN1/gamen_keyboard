<?php
session_start();
include("koneksi.php");

// Ambil input pencarian dari form, jika ada
$search_query = isset($_GET['search']) ? $_GET['search'] : '';

// Tentukan jumlah maksimal produk yang ditampilkan sebelum tombol "Lihat Lebih Banyak" muncul
$limit = 15; // 3 baris dengan 3 kolom per baris

// Jika ada pencarian, gunakan query untuk mencari produk
if (!empty($search_query)) {
    $result = mysqli_query($koneksi, "SELECT * FROM produk WHERE nama_barang LIKE '%$search_query%' ORDER BY id DESC LIMIT $limit");
    $total_result = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM produk WHERE nama_barang LIKE '%$search_query%'");
} else {
    $result = mysqli_query($koneksi, "SELECT * FROM produk ORDER BY id DESC LIMIT $limit");
    $total_result = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM produk");
}

// Ambil total produk dari query
$total_data = mysqli_fetch_assoc($total_result);
$total_products = $total_data['total'];
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Razer mouse</title>
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
    <!-- Modal Login/Register -->
<div id="loginModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div class="modal-tabs">
            <button class="tab-button active" onclick="showTab('login')">Login</button>
            <button class="tab-button" onclick="showTab('register')">Register</button>
        </div>
        <div id="login" class="tab-content">
            <h2>Login</h2>
            <form action="cek_login.php" method="post">
                <?php
                if (isset($_GET['pesan']) && $_GET['pesan'] == "gagal") {
                    echo "<div class='alert'>Username dan Password tidak sesuai!</div>";
                }
                ?>
                <div class="input-container">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="input-container">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="input-container">
                    <input type="submit" value="Login">
                </div>
            </form>
        </div>
        <div id="register" class="tab-content" style="display: none;">
            <h2>Register</h2>
            <form action="cek_Register.php" method="post">
                <?php
                if (isset($_GET['pesan']) && $_GET['pesan'] == "gagal") {
                    echo "<div class='alert'>Username dan Password tidak sesuai!</div>";
                }
                ?>
                <div class="input-container">
                    <label for="username">Username:</label>
                    <input type="text" id="reg-username" name="username" required>
                </div>
                <div class="input-container">
                    <label for="user_email">Email:</label>
                    <input type="text" id="user_email" name="user_email" required>
                </div>
                <div class="input-container">
                    <label for="password">Password:</label>
                    <input type="password" id="reg-password" name="password" required>
                </div>
                <div class="input-container">
                    <input type="submit" value="Daftar">
                </div>
            </form>
        </div>
    </div>
</div>

<div class="header">
    <div class="container">
        <div class="navbar">
            <div class="logo">
                <img src="images/logo.png" width="125px">
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
                    <li><a href="product.php">Produk</a></li>
                    <li><a href="cart.php">Keranjang</a></li>
                    <li><a href="https://wa.me/6281936932988">Chat</a></li>
                    <li class="dropdown">
                        <?php if (isset($_SESSION['username'])) { ?>
                            <a href="#" class="dropbtn"><?php echo $_SESSION['username']; ?> &#9662;</a>
                            <div class="dropdown-content">
                                <a href="profil.php">Profil</a>
                                <a href="about.php">Tentang</a>
                                <a href="pesanan.php">Pesanan</a>
                            </div>
                        <?php } else { ?>
                            <a href="javascript:void(0);" class="dropbtn">MASUK</a>
                        <?php } ?>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="row">
    <div class="col-2">
        <h1>Nikmati pengalaman gaming <br>Menggunakan Razer Deathadder V2 Mini</h1>
        <p>Ditenagai oleh sensor Pixart PAW3359<br>yang mencapai 8500dpi (300ips)</p>
        <a href="https://www.razer.com/ca-en/gaming-mice/razer-deathadder-v2-mini" class="btn">Lihat Sekarang &#8594;</a>

        <video width="560" height="315" autoplay loop controls>
    <source src="videos/RazerV2mini.mp4" type="video/mp4">
    Browser Anda tidak mendukung pemutar video HTML5.
</video>

    </div>
    <div class="col-2">
        <img src="images/image1.png" >
    </div>
</div>


    
 
<!------- featured category ------->
<div class="categories">
    <div class="small-container">
        <div class="row">
            <div class="col-3">
                <img src="images/category-1.jpg">
            </div>
            <div class="col-3">
                <img src="images/category-2.jpg">
            </div>
            <div class="col-3">
                <img src="images/category-3.jpg">
            </div>
        </div>
    </div>
    
</div>

<div class="row">
            <div class="small-container">
                <h2 class="title">List Produk</h2>
            </div>
            <div class="row" id="product-list">

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
                    echo "<a href='cart.php?nama={$produk_data['nama_barang']}&harga={$produk_data['harga_produk']}&jumlah=1'>";
                    echo "<img src='images/{$produk_data['gambar_produk']}' alt='{$produk_data['nama_barang']}'>";
                    echo "</a>";
                    echo "<h4>{$produk_data['nama_barang']}</h4>";
                    echo "<p>{$hargaFormatted}</p>"; // Format harga
                    echo "</div>";
                }
                ?>
            </div>

            <?php if ($total_products > $limit) { ?>
                <!-- Tombol Lihat Lebih Banyak akan muncul jika total produk lebih dari batas -->
                <div class="row">
                    <div class="small-container">
                        <button id="load-more" class="btn" onclick="window.location.href='product.php?search=<?php echo $search_query; ?>'">Lihat Lebih Banyak &#8594;</button>
                    </div>
                </div>
            <?php } ?>
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

<script>
    function showTab(tabName) {
    var tabs = document.querySelectorAll('.tab-content');
    var buttons = document.querySelectorAll('.tab-button');

    tabs.forEach(function(tab) {
        tab.style.display = 'none';
    });
    buttons.forEach(function(button) {
        button.classList.remove('active');
    });

    document.getElementById(tabName).style.display = 'block';
    document.querySelector('.tab-button[onclick="showTab(\'' + tabName + '\')"]').classList.add('active');
}

document.addEventListener("DOMContentLoaded", function() {
    var modal = document.getElementById("loginModal");
    var btn = document.querySelector(".dropbtn");
    var span = document.getElementsByClassName("close")[0];

    btn.onclick = function() {
        modal.style.display = "block";
    }

    span.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    // Initialize with login tab
    showTab('login');
});

</script>


<!------footer------>

<div class="container-fluid bg-dark text-secondary mt-5 pt-5">
        <div class="row px-xl-5 pt-5">
            <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
                <h5 class="text-secondary text-uppercase mb-4">WEBSITE VERSION : V1.2 beta</h5>
                <p class="mb-4">Toko ini menjual mouse</p>
                <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>kepo lu</p>
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
                    <a class="text-primary" href="https://www.youtube.com/@t.a.gchannel">T.A.G Channel X ChatGPT</a>
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

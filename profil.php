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

// Tambahkan kode dari profil.php
if (!isset($_SESSION['username']) || !isset($_SESSION['level'])) {
    header("Location: index.php");
    exit();
}

$nama_pengguna = $_SESSION['username'];
$query = "SELECT email, password, alamat, no_telp, tanggal_lahir FROM login_akun WHERE username='$nama_pengguna'";
$result_profil = mysqli_query($koneksi, $query);
$user_data = mysqli_fetch_assoc($result_profil);
$email_pengguna = $user_data['email'];
$password_pengguna = $user_data['password'];
$alamat_pengguna = $user_data['alamat'];
$no_telp_pengguna = $user_data['no_telp'];
$tanggal_lahir_pengguna = $user_data['tanggal_lahir'];

// Menangani update profil
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $alamat = $_POST['alamat'];
    $no_telp = $_POST['no_telp'];
    $tanggal_lahir = $_POST['tanggal_lahir'];

    $update_query = "UPDATE login_akun SET alamat='$alamat', no_telp='$no_telp', tanggal_lahir='$tanggal_lahir' WHERE username='$nama_pengguna'";
    mysqli_query($koneksi, $update_query);
    header("Location: profil.php"); // Refresh halaman
    exit();
}

// Menangani logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Razer Store</title>
    <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="profil.css">
    <link rel="stylesheet" href="dark-mode.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.2.1/css/fontawesome.min.css">
    <script src="dark-mode.js" defer></script>
</head>

<body>
<div class="header">
    <div class="container">
        <div class="navbar">
            <div class="logo">
                <img src="images/Razer beta.png" width="125px">
            </div>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="https://wa.me/6281936932988">Chat</a></li>
                </ul>
            </nav>
        </div>
        <script src="script.js" defer></script>
        
        <!-- Popup Window -->
        <div id="logoutPopup" class="popup-overlay" style="display: none;">
            <div class="popup-content">
                <h2>Apakah Anda ingin LOGOUT?</h2>
                <button id="confirmLogout" class="btn-confirm">Iya</button>
                <button id="cancelLogout" class="btn-cancel">Tidak</button>
            </div>
        </div>

        <!-- Profil Pengguna -->
        <div class="row">
            <div id="profile" class="container">
                <h1>Profil Anda</h1>
                <div class="profile-info">
                    <p>Username: <input type="text" name="alamat" value="<?php echo $nama_pengguna; ?>"></p>
                    <br>
                    <p>Email: <input type="text" name="alamat" value="<?php echo $email_pengguna; ?>"></p>
                    <p>Password:
                    <div class="password-container">
                    <input type="password" value="<?php echo $password_pengguna; ?>" id="passwordField" readonly>
                    </div>
                    </p>
                    <button type="button" onclick="togglePassword()" id="toggleButton">Lihat Password</button>

                    <form method="POST" action="profil.php">
                        <p>Alamat: <input type="text" name="alamat" value="<?php echo $alamat_pengguna; ?>"></p>
                        <p>No. Telepon: <input type="text" name="no_telp" value="<?php echo $no_telp_pengguna; ?>"></p>
                        <p>Tanggal Lahir: <input type="date" name="tanggal_lahir" value="<?php echo $tanggal_lahir_pengguna; ?>"></p>
                        <br>
                        <button type="submit">Simpan Perubahan</button>
                    </form>
                    <?php if ($_SESSION['level'] == 'admin'): ?>
                        <p>Anda masuk sebagai Admin</p>
                    <?php else: ?>
                        <p>Anda masuk sebagai User</p>
                    <?php endif; ?>
                </div>

                <div class="dark-mode-toggle">
                    <p>Lebih baik di nyalain</p>
                    <span id="darkModeLabel">Dark Mode (BETA)</span>
                    <label class="switch">
                        <input type="checkbox" id="darkModeSwitch">
                        <span class="slider round"></span>
                    </label>
                </div>

                <a href="logout.php" class="btn-logout">LOGOUT</a>
                <a href="updateprofiladmin.php" class="btn-back">Ganti User/Email/Password</a>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    var passwordField = document.getElementById("passwordField");
    var toggleButton = document.getElementById("toggleButton");
    var passwordFieldType = passwordField.getAttribute("type");
    if (passwordFieldType === "password") {
        passwordField.setAttribute("type", "text");
        toggleButton.innerText = "Sembunyikan";
    } else {
        passwordField.setAttribute("type", "password");
        toggleButton.innerText = "Lihat";
    }
}

document.addEventListener("DOMContentLoaded", () => {
    const darkModeSwitch = document.getElementById("darkModeSwitch");
    const darkModeStatus = localStorage.getItem("darkMode");

    if (darkModeStatus === "enabled") {
        document.body.classList.add("dark-mode");
        darkModeSwitch.checked = true;
    } else {
        document.body.classList.remove("dark-mode");
        darkModeSwitch.checked = false;
    }

    darkModeSwitch.addEventListener("change", () => {
        if (darkModeSwitch.checked) {
            document.body.classList.add("dark-mode");
            localStorage.setItem("darkMode", "enabled");
        } else {
            document.body.classList.remove("dark-mode");
            localStorage.setItem("darkMode", "disabled");
        }
    });
});

// Logout Popup Logic
document.addEventListener("DOMContentLoaded", function() {
    const logoutButton = document.getElementById("logoutButton");
    const logoutPopup = document.getElementById("logoutPopup");
    const confirmLogout = document.getElementById("confirmLogout");
    const cancelLogout = document.getElementById("cancelLogout");

    // Menampilkan popup ketika tombol LOGOUT diklik
    logoutButton.addEventListener("click", function(event) {
        event.preventDefault(); // Mencegah aksi default dari href
        logoutPopup.style.display = "flex"; // Tampilkan modal
    });

    // Menghandle tombol "Iya" pada modal
    confirmLogout.addEventListener("click", function() {
        // Redirect ke halaman logout atau lakukan logout
        window.location.href = "process_logout.php"; // Ganti sesuai dengan action logout
    });

    // Menghandle tombol "Tidak" pada modal
    cancelLogout.addEventListener("click", function() {
        logoutPopup.style.display = "none"; // Sembunyikan modal
    });
});
</script>

</body>
</html>

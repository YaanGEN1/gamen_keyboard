<?php
session_start();
include 'koneksi.php';

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username']) || !isset($_SESSION['level'])) {
    // Jika tidak, redirect pengguna ke halaman login
    header("Location: login.php");
    exit();
}

// Ambil nilai nama pengguna dari sesi
$nama_pengguna = $_SESSION['username'];

// Query untuk mengambil detail pengguna dari database
$query = "SELECT username, email, password FROM login_akun WHERE username='$nama_pengguna'";
$result = mysqli_query($koneksi, $query);
$user_data = mysqli_fetch_assoc($result);
$email_pengguna = $user_data['email'];
$password_pengguna = $user_data['password'];
$old_username = $user_data['username'];

// Proses update data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_username = $_POST['username'];
    $new_email = $_POST['email'];
    $new_password = $_POST['password'];

    $update_query = "UPDATE login_akun SET username='$new_username', email='$new_email', password='$new_password' WHERE username='$old_username'";
    if (mysqli_query($koneksi, $update_query)) {
        $_SESSION['username'] = $new_username; // Update session username
        $old_username = $new_username;
        $email_pengguna = $new_email;
        $password_pengguna = $new_password;
        $update_message = "Data berhasil diperbarui";
    } else {
        $update_message = "Gagal memperbarui data";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SStoreDrive</title>
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
                    <li><a href="profil.php">Kembali</a></li>
                </ul>
            </nav>
        </div>
        <script src="script.js" defer></script>
        <!-- Popup Window -->
        <div id="logoutPopup" class="popup-overlay">
            <div class="popup-content">
            <h2>Apakah Anda ingin LOGOUT?</h2>
                <button id="confirmLogout" class="btn-confirm">Iya</button>
                <button id="cancelLogout" class="btn-cancel">Tidak</button>
            </div>
        </div>

<div class="container">
    <h1>Ganti Profil</h1>
    <div class="profile-info">
        <?php if (isset($update_message)) { echo "<p>$update_message</p>"; } ?>
        <form action="" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo $old_username; ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $email_pengguna; ?>" required>

            <label for="password">Password:</label>
            <div class="password-container">
                <input type="password" id="passwordField" name="password" value="<?php echo $password_pengguna; ?>" required>
            </div>

            <div class="btn-container">
    <button type="submit" class="btn-update">Perbarui</button>
    <button type="button" onclick="togglePassword()" id="toggleButton" class="btn-toggle">Lihat</button>
</div>

        </form>

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
</script>

</body>
</html>

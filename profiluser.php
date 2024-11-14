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
$query = "SELECT email, password FROM login_akun WHERE username='$nama_pengguna'";
$result = mysqli_query($koneksi, $query);
$user_data = mysqli_fetch_assoc($result);
$email_pengguna = $user_data['email'];
$password_pengguna = $user_data['password'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna</title>
    <link rel="stylesheet" href="profil.css">
</head>
<body>

<div class="container">
    <h1>Profil Anda</h1>
    <div class="profile-info">
        <p>Nama Pengguna: <?php echo $nama_pengguna; ?></p>
        <p>Email: <?php echo $email_pengguna; ?></p>
        <p>Password: 
            <div class="password-container">
                <input type="password" value="<?php echo $password_pengguna; ?>" id="passwordField" readonly>
                <button type="button" onclick="togglePassword()" id="toggleButton">Lihat</button>
            </div>
        </p>
        <?php if ($_SESSION['level'] == 'admin'): ?>
            <p>Anda masuk sebagai Admin</p>
        <?php else: ?>
            <p>Anda masuk sebagai User</p>
        <?php endif; ?>
        <a href="user.php" class="btn-back">Kembali ke Homepage</a>
        <a href="updateprofiluser.php" class="btn-back">Ganti User/Email/Password</a>
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

<?php
session_start();
include 'koneksi.php';

$username = $_POST['username'];
$password = $_POST['password'];
$login = mysqli_query($koneksi, "SELECT * FROM login_akun WHERE username='$username' AND password='$password'");
$cek = mysqli_num_rows($login);

if ($cek > 0) {
    $data = mysqli_fetch_assoc($login);
    if ($data['level'] == "admin") {
        $_SESSION['username'] = $username;
        $_SESSION['level'] = "admin";
        header("Location: admin.php");
    } else if ($data['level'] == "user") {
        $_SESSION['username'] = $username;
        $_SESSION['level'] = "user";
        header("Location: index.php");
    }
} else {
    header("Location: index.php?pesan=gagal");
}
?>
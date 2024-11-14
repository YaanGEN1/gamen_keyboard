<?php
session_start();

if ($_POST['logout'] == 'yes') {
    // Hancurkan semua variabel sesi
    $_SESSION = array();

    // Hancurkan sesi
    session_destroy();

    // Hapus cookie login jika ada
    if (isset($_COOKIE['login'])) {
        setcookie('login', '', time() - 3600, '/');
    }

    // Redirect pengguna ke halaman login atau halaman lain yang sesuai
    header("Location: index.php");
    exit();
} else {
    // Jika pengguna memilih untuk tidak logout, arahkan kembali ke halaman utama
    header("Location: index.php");
    exit();
}
?>

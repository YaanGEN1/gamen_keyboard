<?php
include("koneksi.php");

// Mengambil nilai 'id' dari URL menggunakan $_GET
$id = $_GET['id'];

// Lakukan pengecekan koneksi
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Lakukan penghapusan data dari database
$result = mysqli_query($koneksi, "DELETE FROM produk WHERE id = $id");

if ($result) {
    // Redirect kembali ke halaman index.php setelah penghapusan berhasil
    header("location: index2.php");
} else {
    echo "Error: " . mysqli_error($koneksi);
}

// Tutup koneksi database
mysqli_close($koneksi);
?>

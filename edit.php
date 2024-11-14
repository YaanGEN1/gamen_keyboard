<?php
// Include file koneksi ke database
include("koneksi.php");

// Periksa apakah formulir telah disubmit untuk mengupdate data produk, lalu redirect ke halaman utama setelah mengupdate
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama_barang'];
    $harga = $_POST['harga_barang'];

    // Handle image upload
    $gambar = $_FILES['gambar_barang']['name'];
    $gambar_tmp = $_FILES['gambar_barang']['tmp_name'];
    move_uploaded_file($gambar_tmp, "upload/apache" . $gambar);

    // Update data produk, termasuk gambar jika diunggah
    if (!empty($gambar)) {
        $result = mysqli_query($koneksi, "UPDATE produk SET nama_barang='$nama', gambar_produk='$gambar', harga_produk='$harga' WHERE id=$id");
    } else {
        $result = mysqli_query($koneksi, "UPDATE produk SET nama_barang='$nama', harga_produk='$harga' WHERE id=$id");
    }

    // Redirect ke halaman utama untuk menampilkan data produk yang telah diupdate
    header("Location: index2.php");
}

// Dapatkan ID produk dari parameter GET
$id = $_GET['id'];

// Dapatkan data produk berdasarkan ID
$result = mysqli_query($koneksi, "SELECT * FROM produk WHERE id=$id");

while ($produk_data = mysqli_fetch_array($result)) {
    $nama = $produk_data['nama_barang'];
    $gambar = $produk_data['gambar_produk'];
    $harga = $produk_data['harga_produk'];
}   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Produk</title>
    <style>
        body {
            background-color: #1e1e1e;
            color: #cfcfcf;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        
        .container {
            background-color: #2c2c2c;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.5);
            width: 400px;
            max-height: 80vh; /* Limit the height of the container */
            overflow: auto; /* Enable scrolling if content exceeds the height */
        }

        .container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #ffffff;
        }

        a {
            color: #4CAF50;
            text-decoration: none;
            font-size: 16px;
        }

        a:hover {
            text-decoration: underline;
        }

        table {
            width: 100%;
            margin-top: 20px;
        }

        table tr td {
            padding: 10px 0;
        }

        input[type="text"], input[type="file"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            box-sizing: border-box;
            border: 2px solid #555;
            background-color: #3b3b3b;
            color: #cfcfcf;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #008CBA;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            margin-top: 10px;
        }

        input[type="submit"]:hover {
            background-color: #007bb5;
        }

        .preview-container {
            margin-top: 20px;
            text-align: center;
            overflow: hidden; /* Hide overflow to prevent large images from overflowing */
            max-height: 300px; /* Set a max-height for the preview area */
        }

        .preview-container img {
            max-width: 100%;
            height: auto; /* Maintain aspect ratio */
            max-height: 100%; /* Limit image height to container's height */
            object-fit: contain; /* Ensure the image fits within the container without distortion */
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="index2.php">Home</a>
        <h2>Edit Data Produk</h2>
        <form name="update_produk" method="post" action="edit.php" enctype="multipart/form-data">
            <table border="0">
                <tr>
                    <td>Nama Barang</td>
                    <td><input type="text" name="nama_barang" value="<?php echo htmlspecialchars($nama); ?>"></td>
                </tr>
                <tr>
                    <td>Gambar Barang</td>
                    <td>
                        <div class="preview-container">
                            <img id="imagePreview" src="upload/apache<?php echo htmlspecialchars($gambar); ?>" alt="Gambar Barang">
                        </div>
                        <br>
                        <input type="file" name="gambar_barang" id="gambar_barang" onchange="previewImage()">
                    </td>
                </tr>
                <tr>
                    <td>Harga Barang</td>
                    <td><input type="text" name="harga_barang" value="<?php echo htmlspecialchars($harga); ?>"></td>
                </tr>
                <tr>
                    <td><input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>"></td>
                    <td><input type="submit" name="update" value="Update"></td>
                </tr>
            </table>
        </form>
    </div>

    <script>
        function previewImage() {
            const fileInput = document.getElementById('gambar_barang');
            const preview = document.getElementById('imagePreview');
            const file = fileInput.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
            }

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>
</html>

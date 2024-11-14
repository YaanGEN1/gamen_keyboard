<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Produk</title>
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

        a button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            border-radius: 5px;
            cursor: pointer;
        }

        a button:hover {
            background-color: #45a049;
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
            max-height: 300px; /* Set a max-height for the preview area */
            overflow: auto; /* Enable scrolling if the image is larger */
        }

        .preview-container img {
            max-width: 100%;
            height: auto; /* Maintain aspect ratio */
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Tambah Data Produk</h2>
        <a href="index.php"><button>Ke Halaman Utama</button></a>
        <br /><br />

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nama = $_POST['nama'];
            $harga = $_POST['harga'];
            include_once("koneksi.php");

            // Menghilangkan format dari harga yang diinputkan
            $harga = str_replace(['Rp ', '.'], '', $harga);
            $harga = (int)$harga;

            if (isset($_FILES['gambar'])) {
                $file_name = $_FILES['gambar']['name'];
                $file_tmp = $_FILES['gambar']['tmp_name'];

                $upload_directory = "upload/";

                if (!file_exists($upload_directory)) {
                    mkdir($upload_directory, 0777, true);
                }

                $destination = $upload_directory . "apache" . $file_name;

                if (move_uploaded_file($file_tmp, $destination)) {
                    $result = mysqli_query($koneksi, "INSERT INTO produk (nama_barang, harga_produk, gambar_produk) VALUES ('$nama', '$harga', '$file_name')");
                    if ($result) {
                        echo "<script>
                                alert('Produk berhasil ditambahkan.');
                                window.location.href = 'index2.php';
                             </script>";
                    } else {
                        echo "Error: " . mysqli_error($koneksi);
                    }
                } else {
                    echo "Error saat mengunggah file.";
                }
            }
        }
        ?>

        <form action="tambah.php" method="post" name="form1" enctype="multipart/form-data">
            <table border="0">
                <tr>
                    <td>Nama</td>
                    <td><input type="text" name="nama"></td>
                </tr>
                <tr>
                    <td>Harga</td>
                    <td><input type="text" name="harga"></td>
                </tr>
                <tr>
                    <td>Gambar</td>
                    <td><input type="file" name="gambar" id="gambar" onchange="previewImage()"></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" name="submit" value="Tambah"></td>
                </tr>
            </table>
        </form>

        <div class="preview-container">
            <img id="imagePreview" src="" alt="Preview Gambar" style="display: none;">
        </div>
    </div>

    <script>
        function previewImage() {
            const fileInput = document.getElementById('gambar');
            const preview = document.getElementById('imagePreview');
            const file = fileInput.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = '';
                preview.style.display = 'none';
            }
        }
    </script>
</body>
</html>

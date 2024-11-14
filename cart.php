<?php
session_start();

// Periksa apakah pengguna sudah login, jika tidak, arahkan ke halaman login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran</title>
    <link rel="stylesheet" href="cart.css">
    <style>
        :root {
            --dark-blue: #121212;
            --light-gray: #2e2e2e;
            --gray: #3c3c3c;
            --white: #ffffff;
            --purple: #bb86fc;
            --light-purple: #9b59c6;
        }

        * {
            margin: 0;
            padding: 0;
            text-decoration: none;
            list-style-type: none;
            box-sizing: border-box;
            font-family: 'Tahoma'; 
        }

        body {
            background-color: var(--dark-blue);
            color: var(--white);
            font-size: 15pt;
        }

        header {
            background-color: var(--gray);
            color: var(--white);
            padding: 20px;
        }

        header h1 {
            margin: 0;
        }

        main {
            padding: 20px;
        }

        fieldset {
            border: none;
            padding: 0;
            margin: 0;
            background-color: var(--light-gray);
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        legend {
            font-weight: bold;
            color: var(--purple);
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: var(--white);
        }

        input[type="text"],
        input[type="email"],
        input[type="month"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid var(--gray);
            background-color: var(--light-gray);
            color: var(--white);
            box-sizing: border-box;
            margin-bottom: 20px;
        }

        input[type="submit"] {
            background-color: var(--purple);
            color: var(--white);
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
        }

        input[type="submit"]:hover {
            background-color: var(--light-purple);
        }

        .cart-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .cart-table th,
        .cart-table td {
            padding: 12px;
            border: 1px solid var(--gray);
            text-align: left;
        }

        .cart-table th {
            background-color: var(--gray);
        }

        .cart-table tbody tr {
            background-color: var(--light-gray);
        }

        .cart-table td input[type="number"] {
            width: 60px;
            padding: 5px;
            text-align: center;
            border: 1px solid var(--gray);
            background-color: var(--dark-blue);
            color: var(--white);
        }
    </style>
</head>

        <form method="post" class="form" action="order.php" target="_blank">
            <fieldset>
                <legend>Isi data berikut untuk pemesanan barang</legend><br>
                <label for="name">Nama:</label>
                <input type="text" id="name" name="name" required><br>
                <label for="address">Alamat:</label>
                <textarea id="address" name="address" rows="4" cols="50" required></textarea><br>
                <label for="kode_pos">Kode POS:</label>
                <input type="text" id="kode_pos" name="kode_pos" required><br>
            </fieldset>
            <fieldset>
                <legend>Metode Pembayaran</legend><br>
                <label for="payment-method">Pilih Metode Pembayaran:</label>
                <select id="payment-method" name="payment_method" required>
                    <option value="gopay">GOPAY</option>
                    <option value="ovo">OVO</option>
                    <option value="shopeepay">ShopeePay</option>
                    <option value="credit_card">Credit Card</option>
                </select><br>
                <label for="payment-number">Masukkan Nomor:</label>
                <input type="text" id="payment-number" name="payment_number" required><br>
            </fieldset>
            <input type="submit" value="Pesan">
            <a href="product.php" class="button">Kembali</a>
        </form>
    </main>

    <footer>
        <!-- Konten footer tetap sama seperti yang Anda berikan -->
    </footer>

    <!-- JavaScript untuk menghitung subtotal -->
    <script>
    // Fungsi untuk mendapatkan nilai parameter dari URL
    function getParameterByName(name, url) {
        if (!url) url = window.location.href;
        name = name.replace(/[\[\]]/g, "\\$&");
        var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, " "));
    }

    // Cek apakah ada parameter produk dalam URL
    const namaProduk = getParameterByName('nama');
    const hargaProduk = getParameterByName('harga');

    // Jika ada parameter produk, tambahkan produk ke keranjang dengan JavaScript
    if (namaProduk && hargaProduk) {
        const cartTable = document.querySelector('.cart-table tbody');
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td>
                <div class="cart-info">
                    <div>
                        <p>${namaProduk}</p>
                    </div>
                </div>
            </td>
            <td>
                <input type="number" min="1" value="1" onchange="updateSubtotal(this, ${hargaProduk})">
            </td>
            <td class="subtotalProduk">Rp${parseInt(hargaProduk).toLocaleString()}</td>
        `;
        cartTable.appendChild(newRow);
        calculateTotal();
    }

    function updateSubtotal(input, price) {
        const row = input.closest('tr');
        const quantity = parseInt(input.value);
        const subtotal = price * quantity;
        row.querySelector('.subtotalProduk').textContent = 'Rp' + subtotal.toLocaleString();
        calculateTotal();
    }

    function calculateTotal() {
        const subtotals = document.querySelectorAll('.cart-table tbody .subtotalProduk');
        let total = 0;
        subtotals.forEach(subtotal => {
            total += parseFloat(subtotal.textContent.replace('Rp', '').replace(/\./g, ''));
        });
        document.getElementById('totalBelanja').textContent = 'Rp' + total.toLocaleString();
    }

    // Panggil calculateTotal saat halaman dimuat
    calculateTotal();
    </script>
</body>
</html>

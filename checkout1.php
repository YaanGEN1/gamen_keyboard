<!DOCTYPE html>
<html>
<head>
	<title>Pemesanan</title>
	<link rel="stylesheet" type="text/css" href="checkout.css">
</head>
<body>
	<main>
		<?php
		session_start();
		$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
		?>
		<form method="post" class="form" action="order.html" target="_blank">
			<fieldset>
				<legend>Detail Barang</legend><br>
				<?php foreach ($cart as $item): ?>
					<p>Nama Barang: <?= $item['nama'] ?></p>
					<p>Harga Barang: Rp<?= number_format($item['harga'], 0, ',', '.') ?></p>
					<label for="jumlah_<?= $item['nama'] ?>">Jumlah:</label>
					<input type="number" id="jumlah_<?= $item['nama'] ?>" name="jumlah[<?= $item['nama'] ?>]" value="1" min="1" required><br>
				<?php endforeach; ?>
			</fieldset>
			<fieldset>
				<legend>isi data berikut untuk pemesanan barang</legend><br>
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
		</form>
	</main>
</body>
</html>

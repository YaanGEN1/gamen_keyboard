<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style_login.css">
</head>
<body>

    <div class="container">
        <div class="card">
        <form action="cek_login.php" method="post">
        <?php
    if(isset($_GET['pesan'])){
        if($_GET['pesan']=="gagal"){
            echo "<div class='alert'>
                Username dan Password tidak sesuai!</div>";
        }
    }
    ?>
            <h2>Login</h2>
            <div class="input-container">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-container">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="input-container">
                <input type="submit" value="Login">
            </div>
        </form>
        <p>Belum punya akun? <a href="Register.php">Daftar di sini</a></p>
        </div>
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="logout.css">
    <title>Logout</title>
</head>
<body>
    <h1>Apakah Anda yakin ingin logout?</h1>
    <form action="process_logout.php" method="post">
        <button type="submit" name="logout" value="yes">Ya</button>
        <button type="button" onclick="window.location.href='profil.php'">Tidak</button>
    </form>
</body>
</html>

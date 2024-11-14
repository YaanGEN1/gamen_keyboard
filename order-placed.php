<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order Placed</title>

    <style>
        #mainBox {
            max-width: 400px;
            margin: auto;
        }

        #mainBox>img {
            width: 100%;
        }

        @media screen and (max-width: 480px) {
            #mainBox {
                margin: 20vh auto auto;
            }
        }
    </style>
</head>

<body>

    <div id="mainBox">
        <img src="images/order-placed.gif" alt="order placed">
    </div>
    <center>
        <h1>Barang anda sudah sampai</h1>
      </center>
      


    <script type="text/javascript">
        setTimeout(() => {
            window.location.href = "index.php"
        }, 4000);
    </script>
</body>

</html>

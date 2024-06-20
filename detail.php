<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Menu - Neco Cafe</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css" rel="stylesheet">
    <!-- <link href="assets/css/style.css" rel="stylesheet"> -->
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container mt-5">
        <h1>Detail Item Menu</h1>
        <?php
        $item_name = "Kopi Latte"; // Ambil data dari database atau query parameter
        $item_description = "Kopi dengan susu dan foam.";
        $item_price = 30000;
        $item_image = "assets/latte.jpg";

        echo "
        <div class='card'>
            <img src='$item_image' class='card-img-top' alt='$item_name'>
            <div class='card-body'>
                <h5 class='card-title'>$item_name</h5>
                <p class='card-text'>$item_description</p>
                <p class='card-text'>Rp " . number_format($item_price, 0, ',', '.') . "</p>
            </div>
        </div>
        ";
        ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

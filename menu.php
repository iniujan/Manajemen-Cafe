<?php
session_start();
require_once('db.php');

if (isset($_POST['add_to_cart'])) {
    $item_name = $_POST['item_name'];
    $item_price = $_POST['item_price'];
    $item_id = $_POST['item_id'];


    $item = [
        'name' => $item_name,
        'price' => $item_price,
        'quantity' => 1,
        'id' => $item_id
    ];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Check if the item already exists in the cart
    $found = false;
    foreach ($_SESSION['cart'] as &$cart_item) {
        if ($cart_item['name'] === $item_name) {
            $cart_item['quantity'] += 1;
            $found = true;
            break;
        }
    }

    if (!$found) {
        array_push($_SESSION['cart'], $item);
    }
}

$query = "SELECT menu.*,kategori.nama_kategori FROM menu, kategori WHERE menu.kategori_id = kategori.id";

$stmt = $conn->query($query);

$menu_items = $stmt->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - Neco Cafe</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css" rel="stylesheet">
    <!-- <link href="assets/css/style.css" rel="stylesheet"> -->
</head>
<style>
.card {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.card img {
    height: 200px;
    object-fit: cover;
}

body {
    /* font-family: var(--font-family); */
    background-color: var(--background-color);
}

.container {
    margin-top: 20px;
}

.container-content {
    margin-bottom: 4rem;
    /* Sesuaikan nilai sesuai kebutuhan Anda */
    border: 1px solid #f8f9fa;
    /* Warna dan lebar border dapat disesuaikan */
    padding: 1rem;
    /* Opsional: Tambahkan padding jika diperlukan */
}

h1 {
    color: var(--primary-color);
}

p {
    color: var(--secondary-color);
}

/* Additional styles for centering content */
.text-center {
    text-align: center;
}

/* Style for buttons */
.btn-primary {
    margin-left: 85%;
}

/* Style for modal */
.modal-content {
    border-radius: 5px;
}

/* Style for the badge in the navbar */
.navbar-brand {
    position: relative;
}

.badge {
    position: absolute;
    top: -10px;
    right: -10px;
    font-size: 12px;
}
</style>
<body>
    <?php 
        if(isset($_SESSION['role'])){
            require_once('waitress/navbar.php');
        }else{
            require_once('navbar.php');
        }
    ?>
    <div class="container mt-5">
        <h1>Menu</h1>
        <div class="row">
            <?php foreach ($menu_items as $item): ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="images/<?php echo $item['gambar'] ?>" class="card-img-top" alt="<?= $item['nama_menu'] ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= $item['nama_menu'] ?></h5>
                            <p class="card-text"><?= $item['nama_kategori'] ?></p>
                            <p class="card-text">Rp <?= number_format($item['harga'], 0, ',', '.') ?></p>
                            <form method="POST">
                                <input type="hidden" name="item_name" value="<?= $item['nama_menu'] ?>">
                                <input type="hidden" name="item_price" value="<?= $item['harga'] ?>">
                                <input type="hidden" name="item_id" value="<?= $item['id'] ?>">
                                <button type="submit" name="add_to_cart" class="btn btn-primary">+</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <a href="cart.php" class="btn btn-secondary">Lihat Keranjang</a>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

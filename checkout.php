<?php
session_start();
require_once('db.php');

$query = "select * from meja";
$stmt = $conn->query($query);
$tables = $stmt->fetch_all(MYSQLI_ASSOC);

$query = "select * from metode_pembayaran";
$stmt = $conn->query($query);
$payment_method = $stmt->fetch_all(MYSQLI_ASSOC);

$query = "select * from promo";
$stmt = $conn->query($query);
$promo = $stmt->fetch_all(MYSQLI_ASSOC);


if (isset($_GET['discount'])) {
    $id = $_GET['discount'];
    $query = "select * from promo where id = $id";
    $stmt = $conn->query($query);
    $discount = $stmt->fetch_assoc();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Neco Cafe</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css" rel="stylesheet">
    <!-- <link href="assets/css/style.css" rel="stylesheet"> -->
</head>

<body>
    <?php
    if (isset($_SESSION['role'])) {
        require_once('waitress/navbar.php');
    } else {
        require_once('navbar.php');
    }
    ?>
    <div class="container mt-5">
        <form action="process_checkout.php" method="post">
            <h1>Checkout</h1>
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="table_number">Table Number:</label>
                <select class="form-control" name="table_number" id="table_number">
                    <?php foreach ($tables as $key => $table) {
                    ?>
                        <option value="<?php echo $table['id'] ?>"><?php echo $table['nomor_meja'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="promo">Promo Code:</label>
                <select onchange="promoOnChanged()" class="form-control" name="promo" id="promo">
                    <option value="none">None</option>
                    <?php foreach ($promo as $key => $value) { ?>
                        <option value="<?php echo $value['id'] ?>" <?php if (isset($_GET['discount']) && $discount['id'] == $value['id']) echo 'selected' ?>><?php echo $value['kode'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <a id="discountBtn" href="checkout.php" class="btn btn-primary">Apply</a>
            <h2>Order Summary</h2>
            <ul>
                <?php
                $total = 0;
                foreach ($_SESSION['cart'] as $item) :
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                ?>
                    <li><?= $item['name'] ?> - Rp <?= number_format($item['price'], 0, ',', '.') ?> x <?= $item['quantity'] ?> = Rp <?= number_format($subtotal, 0, ',', '.') ?></li>
                <?php endforeach; ?>
            </ul>
            <p><strong>Subtotal: Rp <?= number_format($total, 0, ',', '.') ?></strong></p>
            <?php
            if (isset($_GET['discount'])) {
                $diskon_persen = $discount['diskon_persen'] / 100;
                $diskon = $total * $diskon_persen;
                $total = $total - $diskon;
            ?>
                <p><strong>Discount: -Rp <?= number_format($diskon, 0, ',', '.') ?></strong></p>
            <?php } ?>
            <p><strong>Total: Rp <?= number_format($total, 0, ',', '.') ?></strong></p>
            <div class="form-group">
                <label for="payment_method">Payment Method:</label>
                <select class="form-control" id="payment_method" name="payment_method" required>
                    <?php foreach ($payment_method as $key => $method) {
                    ?>
                        <option value="<?php echo $method['id'] ?>"><?php echo $method['metode'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <input style="display: none;" name="total" value="<?php echo $total ?>">
            <button type="submit" class="btn btn-primary">Pay</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>

    </script>
    <script>
        function promoOnChanged() {
            var btn = document.getElementById("discountBtn");
            var field = document.getElementById("promo");
            btn.href = "checkout.php?discount=" + field.value;
        }
    </script>
</body>

</html>
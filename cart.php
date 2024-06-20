<?php
session_start();

if (isset($_POST['update_cart'])) {
    foreach ($_POST['quantities'] as $index => $quantity) {
        if ($quantity == 0) {
            unset($_SESSION['cart'][$index]);
        } else {
            $_SESSION['cart'][$index]['quantity'] = $quantity;
        }
    }
    $_SESSION['cart'] = array_values($_SESSION['cart']); // Reindex the array
}

if (isset($_POST['remove_item'])) {
    $index = $_POST['remove_item'];
    unset($_SESSION['cart'][$index]);
    $_SESSION['cart'] = array_values($_SESSION['cart']); // Reindex the array
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - Neco Cafe</title>
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
        <h1>Shopping Cart</h1>
        <?php if (!empty($_SESSION['cart'])) : ?>
            <form method="POST" id="cartForm">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total = 0;
                        foreach ($_SESSION['cart'] as $index => $item) :
                            $subtotal = $item['price'] * $item['quantity'];
                            $total += $subtotal;
                        ?>
                            <tr>
                                <td><?= $item['name'] ?></td>
                                <td>Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                                <td>
                                    <input type="number" name="quantities[<?= $index ?>]" value="<?= $item['quantity'] ?>" min="0" class="form-control">
                                </td>
                                <td>Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
                                <td>
                                    <button type="button" onclick="confirmDelete(<?= $index ?>)" class="btn btn-danger">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="3"><strong>Total</strong></td>
                            <td><strong>Rp <?= number_format($total, 0, ',', '.') ?></strong></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                <button type="submit" name="update_cart" class="btn btn-primary">Update Cart</button>
                <a href="checkout.php" class="btn btn-secondary">Checkout</a>
                <input type="hidden" name="remove_item" id="remove_item_input">
            </form>
        <?php else : ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function confirmDelete(index) {
            if (confirm('Are you sure you want to delete this item?')) {
                document.getElementById('remove_item_input').value = index;
                document.getElementById('cartForm').submit();
            }
        }
    </script>
</body>

</html>

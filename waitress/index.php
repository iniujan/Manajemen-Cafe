<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Neco Cafe</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css" rel="stylesheet">
    <!-- <link href="assets/css/style.css" rel="stylesheet"> -->
</head>

<body>
    <?php include "../db.php"; ?>

    <?php if (isset($_SESSION['checkout_success'])) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Thank You! Your order has been successfully processed.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php unset($_SESSION['checkout_success']); ?>
    <?php endif; ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="">Neco Cafe</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="../menu.php">Menu</a></li>
                <li class="nav-item"><a class="nav-link" href="waitress/list_pesanan.php">List Order</a></li>
                <li class="nav-item"><a class="nav-link" href="../login.php" onclick="confirmLogout()">Logout</a></li>
            </ul>
        </div>
    </nav>
    <div class="container mt-5">
        <h1>Welcome to Neco Cafe</h1>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function confirmLogout() {
            if (confirm('Are you sure you want to logout?')) {
                window.location.href = 'resto/login.php';
            }
        }
    </script>
</body>

</html>

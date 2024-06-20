<!-- <?php session_start(); ?> -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php">Neco Cafe</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item"><a class="nav-link" href="menu.php">Menu</a></li>
            <li class="nav-item"><a class="nav-link" href="promosi.php">Promotion</a></li>
            <li class="nav-item"><a class="nav-link" href="kontak.php">Contact</a></li>
            <li class="nav-item"><a class="nav-link" href="testimoni.php">Rate</a></li>
            <li class="nav-item"><a class="nav-link" href="blog.php">Blog</a></li>
            <li class="nav-item"><a class="nav-link" href="event.php">Event</a></li>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="cart.php">
                    <img src="assets/images/cart.jpg" alt="Cart" style="width: 24px;">
                    <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
                        <span class="badge badge-danger"><?= count($_SESSION['cart']) ?></span>
                    <?php endif; ?>
                </a>
            </li>
        </ul>
    </div>
</nav>

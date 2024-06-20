<?php
require_once "../db.php";

$query = "SELECT pesanan.id, pesanan.nama, pesanan.email, meja.nomor_meja,
        pesanan.tanggal_pesanan, pembayaran.total_harga FROM pesanan, meja, 
        pembayaran where pesanan.meja_id = meja.id AND pembayaran.pesanan_id = pesanan.id";
$stmt = $conn->query($query);
$list_pesanan = $stmt->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Pesanan</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css" rel="stylesheet">
    <style>
        .order-item {
            margin-bottom: 30px;
            padding: 20px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .order-item h5 {
            color: #007bff;
        }
        .order-item img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <?php require_once "navbar.php" ?>
    <div class="container mt-5">
        <h2 class="mb-4">Daftar Pesanan</h2>
        <div class="list-group">

            <!-- Pesanan 1 -->
             <?php foreach ($list_pesanan as $key => $pesanan) {
             ?>
            <div class="list-group-item order-item">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">User Name: <?php echo $pesanan['nama'] ?></h5>
                    <small>Order Time: <?php echo $pesanan['tanggal_pesanan'] ?></small>
                </div>
                <p class="mb-1">Email: <?php echo $pesanan['email'] ?></p>
                <p class="mb-1">Table: <?php echo $pesanan['nomor_meja'] ?></p>
                <ul class="list-group mb-3">
                    <?php 
                    $query = "SELECT menu.nama_menu, menu.gambar, menu.harga, detailpesanan.jumlah FROM menu, detailpesanan WHERE detailpesanan.menu_id = menu.id AND detailpesanan.pesanan_id = ".$pesanan['id'];
                    $stmt = $conn->query($query);
                    $menus = $stmt->fetch_all(MYSQLI_ASSOC);
                    foreach ($menus as $key => $menu) {
                    ?>
                    <li class="list-group-item d-flex align-items-center">
                        <img src="../images/<?php echo $menu['gambar'] ?>" class="mr-3" alt="<?php echo $menu['nama_menu'] ?>">
                        <div class="d-flex flex-column">
                            <span>Menu <?php echo $key+1 ?>: <?php echo $menu['nama_menu'] ?></span>
                            <span>Harga: Rp<?= number_format($menu['harga'], 0, ',', '.') ?></span>
                            <span>Kuantitas: <?php echo $menu['jumlah'] ?></span>
                        </div>
                    </li>
                    <?php } ?>
                </ul>
                <h6>Total Harga: Rp<?= number_format($pesanan['total_harga'], 0, ',', '.') ?></h6>
            </div>
            <?php } ?>

            

           

        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
session_start();
include 'db.php';
require('fpdf186/fpdf.php'); // Include FPDF library

class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Struk Belanja - Neco Cafe', 0, 1, 'C');
        $this->Ln(10);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $table_number = $_POST['table_number'];
    $payment_method = $_POST['payment_method'];
    $total_price = $_POST['total'];
    // $menu = $_POST['menu'];

    if ($_POST['promo'] != 'none') {
        $promo = $_POST['promo'];
    }

    $query = "INSERT INTO pesanan (nama, email, meja_id) VALUES ('$name', '$email', '$table_number')";

    if (isset($_SESSION['id'])) {
        $id = $_SESSION['id'];
        $query = "INSERT INTO pesanan (nama, email, meja_id, pelayan_id) VALUES ('$name', '$email', '$table_number', '$id')";
    }

    $stmt = $conn->prepare($query);
    $stmt->execute();
    $order_id = $stmt->insert_id;
    $stmt->close();

    foreach ($_SESSION['cart'] as $item) {
        $stmt = $conn->prepare("INSERT INTO detailpesanan (pesanan_id, menu_id, jumlah) VALUES ('$order_id', '" . $item['id'] . "', '" . $item['quantity'] . "')");
        $stmt->execute();
        $stmt->close();
    }
    $stmt = $conn->prepare("INSERT INTO pembayaran (pesanan_id, total_harga, id_metode) VALUES ('$order_id', '$total_price', '$payment_method')");

    if ($_POST['promo'] != 'none') {
        $stmt = $conn->prepare("INSERT INTO pembayaran (pesanan_id, total_harga, id_metode, id_promo) VALUES ('$order_id', '$total_price', '$payment_method', '$promo')");
    }

    $stmt->execute();
    $stmt->close();

    // Create PDF



    // exit();
    $data = [
        'name'=> $name,
        'email'=> $email,
        'table_number'=> $table_number,
        'payment_method' => $payment_method,
        'total_price' => $total_price,
        'cart' => $_SESSION['cart'],
    ];

    if ($_POST['promo'] != 'none') {
        $data['promo'] = $promo;
    }
    

    $_SESSION['data_cetak'] = $data;

    unset($_SESSION["cart"]);

}

if (isset($_GET["cetak"])) {
    $data = $_SESSION['data_cetak'];
    unset($_SESSION['data_cetak']);

    $pdf = new PDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', '', 12);

    $pdf->Cell(0, 10, 'Nama: ' . $data['name'], 0, 1);
    $pdf->Cell(0, 10, 'Email: ' . $data['email'], 0, 1);
    $query = "SELECT * FROM meja WHERE id = '".$data['table_number']."'";
    $table = $conn->query($query)->fetch_assoc();
    $pdf->Cell(0, 10, 'Nomor Meja: ' . $table["nomor_meja"], 0, 1);

    $pdf->Ln(10);
    $pdf->Cell(0, 10, 'Ringkasan Pesanan:', 0, 1);
    $pdf->Ln(5);

    $total = 0;
    foreach ($data['cart'] as $item) {
        $subtotal = $item['price'] * $item['quantity'];
        $total += $subtotal;
        $pdf->Cell(0, 10, $item['name'] . ' - Rp ' . number_format($item['price'], 0, ',', '.') . ' x ' . $item['quantity'] . ' = Rp ' . number_format($subtotal, 0, ',', '.'), 0, 1);
    }

    if (isset($data['promo'])) {
        $promo = $data['promo'];
        $stmt = "SELECT * FROM promo WHERE id = $promo";
        $stmt = $conn->query($stmt);
        $discount = $stmt->fetch_assoc();
        $diskon_persen = $discount['diskon_persen'] / 100;
        $diskon = $total * $diskon_persen;
        $total = $total - $diskon;
        $pdf->Cell(0, 10, 'Discount: -Rp ' . number_format($diskon, 0, ',', '.'), 0, 1);
    }

    $pdf->Ln(5);
    $pdf->Cell(0, 10, 'Total: Rp ' . number_format($total, 0, ',', '.'), 0, 1);

    $pdf->Ln(10);
    $query = "SELECT * FROM metode_pembayaran WHERE id = '".$data['payment_method']."'";
    $method = $conn->query($query)->fetch_assoc();
    $pdf->Cell(0, 10, 'Metode Pembayaran: ' . $method["metode"], 0, 1);

    $pdf->Output('D', 'struk_belanja.pdf');
    
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proses Checkout - Neco Cafe</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css" rel="stylesheet">
    <!-- <link href="assets/css/style.css" rel="stylesheet"> -->
</head>

<body>
    <?php if (isset($_SESSION['role'])) {
        require_once('waitress/navbar.php');
    } else {
        require_once('navbar.php');
    } ?>
    <div class="container mt-5">
        <h1>Checkout Berhasil</h1>
        <p>Pesanan Anda telah berhasil diproses. Terima kasih!</p>
        <a href="?cetak=1" class="btn btn-primary">Download Struk</a>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
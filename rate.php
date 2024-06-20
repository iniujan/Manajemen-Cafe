<?php
session_start();
require "koneksi.php"; // Pastikan path ke file koneksi benar

$ratings = [];
$message = "";

// Menangani penambahan rating
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST["nama"];
    $rate = $_POST["rate"];

    $sql = "INSERT INTO rate (nama, rate) VALUES ('$nama', '$rate')";
    if (mysqli_query($koneksi, $sql)) {
        $message = "New Rate added successfully";
    } else {
        $message = "Error: " . $sql . "<br>" . mysqli_error($koneksi);
    }
}

// Mengambil semua rating dari database
$sql = "SELECT * FROM rate";
$result = mysqli_query($koneksi, $sql);
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $ratings[] = $row;
    }
}
?>

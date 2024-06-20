<?php

session_start();
require_once "../../koneksi.php";

if (isset($_POST["kategori"])) {
    $kategori = $_POST["kategori"];
    
    // Masukkan data pengguna baru ke dalam database
    $query = "INSERT INTO kategori (`nama_kategori`) VALUES ('".$kategori."')";
    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('kategori berhasil ditambahkan'); window.location='category.php';</script>";
    } else {
        echo "<script>alert('kategori gagal ditambahkan'); window.location='category.php';</script>";
    }
}
<?php
session_start();
include "../../koneksi.php";

if (isset($_POST["id"])) {
    $id = $_POST["id"];

    // Masukkan data pengguna baru ke dalam database
    $query = "DELETE FROM kategori WHERE id = '".$id."'";
    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('kategori berhasil dihapus'); window.location='category.php';</script>";
    } else {
        echo "<script>alert('kategori gagal dihapus'); window.location='category.php';</script>";
    }
}

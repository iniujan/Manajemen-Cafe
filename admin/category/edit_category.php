<?php 
session_start();
include "../../koneksi.php";

if (isset($_POST["category"])) {
    $category = $_POST["category"];
    $id = $_POST["id"];

    foreach ($category as $index => $value) {
        $query = "UPDATE kategori SET nama_kategori = '".$value."' WHERE id = '".$id[$index]."'";
        if (mysqli_query($koneksi, $query)) {
            
        } else {
            echo "<script>alert('Kategori gagal diedit'); window.location='category.php';</script>";
        }
    }

    echo "<script>alert('Kategori berhasil diedit'); window.location='category.php';</script>";
}
?>
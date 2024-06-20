<?php
include "../../koneksi.php";
session_start();

$data = $_POST["id"];


foreach ($data as $id) {
    $query = "DELETE FROM menu WHERE id = $id";
    if ($koneksi->query($query) === false) {
        echo "Error: " . $query . "<br>" . $koneksi->error;
    } 
}
header("Location: menu.php");

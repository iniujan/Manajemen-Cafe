<?php
$host = "localhost:3307";
$username = "root";
$password = "";
$database = "db_neco";
$koneksi = mysqli_connect($host, $username, $password, $database);
if ($koneksi) {
    echo "";
} else {
    echo "Server Not Connected";
}



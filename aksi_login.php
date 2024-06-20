<?php
session_start();
require "koneksi.php";

if (isset($_POST["login"])) {
    $username = $_POST["uname"];
    $password = $_POST["psw"];

    $cekuser = mysqli_query($koneksi, "select * from users where username='$username' and password='$password'");
    $hitung = mysqli_num_rows($cekuser);

    if ($hitung > 0) {
        $ambilDataRole =  mysqli_fetch_array($cekuser);
        $role = $ambilDataRole['role'];

        if ($role == 'admin') {
            $_SESSION['log'] = 'Logged';
            $_SESSION['role'] = 'admin';
            $_SESSION['id'] = $ambilDataRole['id'];
            header('location:admin');
        } else if ($role == 'waitress') {
            $_SESSION['log'] = 'Logged';
            $_SESSION['role'] = 'waitress';
            $_SESSION['id'] = $ambilDataRole['id'];
            header('location:waitress');
        } else {
            echo "<script>alert('Incorrect Username or Password'); window.location='login.php';</script>";
        }
    } else {
        echo "Data not found";
    }
}

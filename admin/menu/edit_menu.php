<?php
include "../../koneksi.php";
session_start();

$id = $_GET['id'];

$query = "SELECT * FROM menu WHERE id = $id";
$menu = $koneksi->query($query)->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $kategori = $_POST['kategori'];
    $price = $_POST['price'];

    if ($_FILES['image']['name'] != "") {
        // Direktori tempat menyimpan gambar yang diunggah
        $target_dir = '../../images/';

        // Ambil informasi file yang diunggah
        $file = $_FILES['image'];
        $file_name = $file['name'];
        $file_tmp = $file['tmp_name'];
        $file_size = $file['size'];
        $file_error = $file['error'];

        // Ekstrak ekstensi file
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        // Nama baru untuk file yang diunggah
        $new_file_name = uniqid('img_', true) . '.' . $file_ext;
        $target_file = $target_dir . $new_file_name;

        

        // Validasi file
        $allowed_ext = array('jpg', 'jpeg', 'png', 'gif');
        if (in_array($file_ext, $allowed_ext)) {
            if ($file_error === 0) {
                if ($file_size <= 2 * 1024 * 1024) { // Batas ukuran file 2MB
                    // Pindahkan file ke direktori tujuan
                    if (move_uploaded_file($file_tmp, $target_file)) {
                        $query = "UPDATE menu SET nama_menu = '$name', kategori_id = '$kategori', harga = '$price', gambar = '$new_file_name' WHERE id = '$id'";
                        if ($koneksi->query($query) === TRUE) {
                            header("Location: menu.php");
                        } else {
                            echo "Error: " . $query . "<br>" . $koneksi->error;
                        }
                    } else {
                        echo "Terjadi kesalahan saat mengunggah file.";
                    }
                } else {
                    echo "Ukuran file terlalu besar. Maksimal 2MB.";
                }
            } else {
                echo "Terjadi kesalahan saat mengunggah file. Kode error: " . $file_error;
            }
        } else {
            echo "Ekstensi file tidak diizinkan. Hanya JPG, JPEG, PNG, dan GIF yang diperbolehkan.";
        }
    } else {
        $query = "UPDATE menu SET nama_menu = '$name', kategori_id = '$kategori', harga = '$price' WHERE id = '$id'";
        if($koneksi->query($query) == true){
            header("location: menu.php");
        }else{
            echo "Error: " . $query . "<br>" . $koneksi->error;
        }
        
    }

    
}
require_once "../header.php";
?>
<!DOCTYPE html>
< lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Menu</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {

            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            margin-top: 30px;
        }
        .table img {
            max-width: 100px;
            max-height: 100px;
        }
        .btn-add-new {
            background-color: #ff69b4;
            color: #fff;
        }
        .btn-add-new:hover {
            background-color: #ff1493;
            color: #fff;
        }
        .btn-warning {
            background-color: #ff69b4;
            border-color: #ff69b4;
        }
        .btn-warning:hover {
            background-color: #ff1493;
            border-color: #ff1493;
        }
        .btn-danger {
            background-color: #ff69b4;
            border-color: #ff69b4;
        }
        .btn-danger:hover {
            background-color: #ff1493;
            border-color: #ff1493;
        }
    </style>
</head>


    <div class="container">
        <h1 class="text-center mb-5">Edit Menu Item</h1>
        <form action="edit_menu.php?id=<?php echo $id ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $menu['nama_menu']  ?>" required>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" class="form-control" id="price" name="price" value="<?php echo $menu["harga"] ?>" required>
            </div>
            <div class="form-group">
                <label for="kategori">Kategori</label>
                <select class="form-control" name="kategori" id="kategori" >
                    <?php 
                    $query = "SELECT * FROM kategori";
                    $data = $koneksi->query($query)->fetch_all(MYSQLI_ASSOC);
                    foreach ($data as $value) {
                    ?>
                    <option value="<?php echo $value['id']?>" <?php if ($menu["kategori_id"] == $value['id']) { 
                        echo "selected";
                    }?>><?php echo $value['nama_kategori']?> </option>
                    <?php 
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="image_url">Image URL</label>
                <input type="file" class="form-control" id="image_url" name="image" >
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
    <?php require_once "../footer.php"; ?>
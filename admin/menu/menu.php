<?php
session_start();
include "../../koneksi.php";
require_once "../header.php";
?>
<!DOCTYPE html>
< lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Menu</title>
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
        <h1 class="text-center mb-5">Restaurant Menu</h1>
        <div class="mb-3">
            <a href="create_menu.php" class="btn btn-add-new">Add New Menu</a>
        </div>
        <form action="delete_menu.php" method="post" style="display: inline;">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Image</th>
                        <th scope="col">Name</th>
                        <th scope="col">Category</th>
                        <th scope="col">Price</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT menu.*, kategori.nama_kategori FROM menu, kategori WHERE menu.kategori_id = kategori.id;";
                    $menu_items = $koneksi->query($query);
                    $menu_items = $menu_items->fetch_all(MYSQLI_ASSOC);
                    foreach ($menu_items as $index => $item) {
                    ?>
                        <tr>
                            <th scope="row"><?php echo $index + 1 ?></th>
                            <td><img src="../../images/<?php echo $item['gambar']; ?>" alt="<?php echo $item['nama_menu']; ?>"></td>
                            <td><?php echo $item['nama_menu']; ?></td>
                            <td><?php echo $item['nama_kategori']; ?></td>
                            <td><?php echo $item['harga']; ?></td>
                            <td>
                                <a href="edit_menu.php?id=<?php echo $item['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <input type="checkbox" name="id[]" value="<?php echo $item['id']; ?>">
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
        </form>
    </div>
 <?php require_once "../footer.php"; ?>
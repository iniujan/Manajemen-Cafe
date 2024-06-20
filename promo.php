<?php
session_start();
require "../koneksi.php"; // Naik satu tingkat ke direktori utama untuk mengakses koneksi.php

// Periksa apakah pengguna sudah login dan apakah perannya adalah admin
if (!isset($_SESSION['log']) || $_SESSION['role'] != 'admin') {
    header('location:../login.php'); // Naik satu tingkat untuk mengakses login.php
    exit();
}

// Menambah promo
if (isset($_POST["create_promo"])) {
    $code = $_POST["code"];
    $discount = $_POST["discount"];
    $description = $_POST["description"];


    // Masukkan data pengguna baru ke dalam database
    $query = "INSERT INTO promo (`kode`, `diskon_persen`, `desc`) VALUES ('$code', '$discount', '$description')";
    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Promo berhasil dibuat'); window.location='promo.php';</script>";
    } else {
        echo "<script>alert('Gagal membuat promo'); window.location='promo.php';</script>";
    }
}

// Mengedit promo
if (isset($_POST["edit_promo"])) {
    $code = $_POST["code"];
    $discount = $_POST["discount"];
    $description = $_POST["description"];
    $id = $_POST["id"];

    // Mengupdate promo
    $query = "UPDATE promo SET `kode` = '$code', `diskon_persen` = '$discount', `desc` = '$description' WHERE  id = '$id' ";
    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Promo berhasil diedit'); window.location='promo.php';</script>";
    } else {
        echo "<script>alert('Gagal mengedit promo'); window.location='promo.php';</script>";
    }
}



// Menghapus data dari database
if (isset($_GET["delete"])) {
    $id = $_GET["id"];

    $query = "DELETE from promo WHERE id = '$id'";
    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Promo berhasil dihapus'); window.location='promo.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus promo'); window.location='promo.php';</script>";
    }
}

?>
 <?php require_once "header.php"; ?>



    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            padding: 16px;
            border: 1px solid #ccc;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            max-width: 850px;
        }

        input {
            padding: 8px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        .input-disabled {
            border: none;
            background-color: white;
        }

        button {
            padding-right: 14px;
            padding-top: 8px;
            padding-bottom: 8px;
            background-color: #04AA6D;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            opacity: 0.8;
        }
    </style>
    <div class="container">
        <button type="button" class="btn btn-primary text-end mb-3" style="margin-left: 85%;" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Add Promo
        </button>
        <form action="edit_category.php" method="post">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Code</th>
                        <th scope="col">Discount(%)</th>
                        <th scope="col">Description</th>
                        <th scope="col"></th>
                        <th scope="col">Handle</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM promo";
                    $dt_query = $koneksi->query($query);
                    $dt_query = $dt_query->fetch_all(MYSQLI_ASSOC);
                    foreach ($dt_query as $index => $promo) {
                    ?>
                        <tr>
                            <td scope="row"><?php echo $index + 1 ?></td>
                            <td id="code"><?php echo $promo['kode'] ?></td>
                            <td id="discount"><?php echo $promo['diskon_persen'] ?></td>
                            <td id="description"><?php echo $promo['desc'] ?></td>
                            <td><input id="id" name="id" type="hidden" value="<?php echo $promo['id'] ?>" disabled></td>
                            <td>
                                <div>
                                    <button class="btn btn-warning" type="button" onclick="editHandler(this)" data-bs-toggle="modal" data-bs-target="#editModal">Edit</button>
                                        <a href="promo.php?id=<?php echo $promo['id']?>&delete=1" class="btn btn-danger">Delete</a>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <button style="margin-left: 92%;" type="submit" class="btn btn-primary text-right">Save</button>
        </form>

        <!-- modal  -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <form action="promo.php" method="post">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Add Promo</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div>
                                <label for="code"><b>Code</b></label>
                                <input class="form-control" type="text" placeholder="Enter Code" name="code" required>
                            </div>
                            <div>
                                <label for="discount"><b>discount</b></label>
                                <input class="form-control" type="number" placeholder="Enter Discount(%)" name="discount" required>
                            </div>
                            <div>
                                <label for="description"><b>Description</b></label>
                                <textarea name="description" id="description" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="create_promo" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
        <!-- end modal  -->

         <!-- edit modal  -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <form action="promo.php" method="post">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Waitress</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div>
                                <label for="code"><b>Code</b></label>
                                <input id="edit-code" class="form-control" type="text" placeholder="Enter Code" name="code" required>
                            </div>
                            <div>
                                <label for="discount"><b>discount</b></label>
                                <input id="edit-discount" class="form-control" type="number" placeholder="Enter Discount(%)" name="discount" required>
                            </div>
                            <div>
                                <label for="description"><b>Description</b></label>
                                <textarea id="edit-description" name="description" id="description" class="form-control"></textarea>
                            </div>
                            <input style="display: none;" id="edit-id" class="form-control" type="text" name="id" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="edit_promo" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
        <!-- end modal  -->

    </div>
    <script>
        function editHandler(el) {
            var parent = el.parentNode.parentNode.parentNode;
            var code = parent.querySelector('#code');
            var discount = parent.querySelector('#discount');
            var description = parent.querySelector('#description');
            var id = parent.querySelector('#id');

            var codeField = document.getElementById('edit-code');
            var discountField = document.getElementById('edit-discount');
            var idField = document.getElementById('edit-id');
            var descriptionField = document.getElementById('edit-description');

            codeField.value = code.innerHTML.trim();
            discountField.value = discount.innerHTML.trim();
            idField.value = id.value;
            descriptionField.value = description.innerHTML.trim();
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<?php require_once "footer.php"; ?>

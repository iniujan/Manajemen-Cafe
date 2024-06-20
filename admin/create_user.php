<?php
session_start();
require "../koneksi.php"; // Naik satu tingkat ke direktori utama untuk mengakses koneksi.php

// Periksa apakah pengguna sudah login dan apakah perannya adalah admin
if (!isset($_SESSION['log']) || $_SESSION['role'] != 'admin') {
    header('location:../login.php'); // Naik satu tingkat untuk mengakses login.php
    exit();
}

if (isset($_POST["create_user"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $role = 'waitress'; // Selalu menetapkan peran sebagai waitress

    // Masukkan data pengguna baru ke dalam database
    $query = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";
    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Akun berhasil dibuat'); window.location='create_user.php';</script>";
    } else {
        echo "<script>alert('Gagal membuat akun'); window.location='create_user.php';</script>";
    }
}

if (isset($_POST["edit_user"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $role = $_POST["role"];
    $id = $_POST["id"];

    // Masukkan data pengguna baru ke dalam database
    $query = "UPDATE users SET username = '$username', password = '$password', role = '$role' WHERE id = '$id'";
    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Akun berhasil diedit'); window.location='create_user.php';</script>";
    } else {
        echo "<script>alert('Gagal mengedit akun'); window.location='create_user.php';</script>";
    }
}

if (isset($_GET["delete"])) {
    $id = $_GET["id"];

    // Hapus data pengguna dari database
    $query = "DELETE FROM users WHERE id = '$id'";
    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Akun berhasil dihapus'); window.location='create_user.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus akun'); window.location='create_user.php';</script>";
    }
}

require_once "header.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Waitress</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
</head>
<body>
    <div class="container">
        <button type="button" class="btn btn-primary text-end mb-3" style="margin-left: 85%;" data-toggle="modal" data-target="#exampleModal">
            Add Waitress
        </button>
        <table class="table table-sm">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Username</th>
                    <th scope="col">Password</th>
                    <th scope="col">Role</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM users WHERE role = 'waitress'";
                $dt_query = $koneksi->query($query);
                $dt_query = $dt_query->fetch_all(MYSQLI_ASSOC);
                foreach ($dt_query as $index => $user) {
                ?>
                    <tr>
                        <td><?php echo $index + 1 ?></td>
                        <td><?php echo $user['username'] ?></td>
                        <td><?php echo $user['password'] ?></td>
                        <td><?php echo $user['role'] ?></td>
                        <td>
                            <button class="btn btn-warning" type="button" onclick="editHandler('<?php echo $user['username'] ?>', '<?php echo $user['password'] ?>', '<?php echo $user['role'] ?>', '<?php echo $user['id'] ?>')" data-toggle="modal" data-target="#editModal">Edit</button>
                            <a href="create_user.php?id=<?php echo $user['id'] ?>&delete=1" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Modal Add -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <form action="create_user.php" method="post">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Add Waitress</h1>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div>
                                <label for="username"><b>Username</b></label>
                                <input class="form-control" type="text" placeholder="Enter Username" name="username" required>
                            </div>
                            <div>
                                <label for="password"><b>Password</b></label>
                                <input class="form-control" type="password" placeholder="Enter Password" name="password" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" name="create_user" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Modal Edit -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <form action="create_user.php" method="post">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Waitress</h1>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div>
                                <label for="username"><b>Username</b></label>
                                <input id="username-edit" class="form-control" type="text" placeholder="Enter Username" name="username" required>
                            </div>
                            <div>
                                <label for="password"><b>Password</b></label>
                                <input id="password-edit" class="form-control" type="password" placeholder="Enter Password" name="password" required>
                            </div>
                            <div>
                                <input id="id-edit" style="display: none;" class="form-control" type="text" placeholder="Enter Password" name="id" required>
                            </div>
                            <div>
                                <label for="role"><b>Role</b></label>
                                <select class="form-control" name="role" id="role-edit">
                                    <option value="admin">Admin</option>
                                    <option value="waitress">Waitress</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" name="edit_user" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function editHandler(username, password, role, id) {
            document.getElementById('username-edit').value = username;
            document.getElementById('password-edit').value = password;
            document.getElementById('id-edit').value = id;
            document.getElementById('role-edit').value = role;
        }
    </script>
</body>
</html>

<?php require_once "footer.php"; ?>

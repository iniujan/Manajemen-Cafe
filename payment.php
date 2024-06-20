<?php
session_start();
include "../koneksi.php";

if (isset($_POST["create_payment"])) {
    $payment = $_POST["payment"];

    // Masukkan data pengguna baru ke dalam database
    $query = "INSERT INTO metode_pembayaran (`metode`) VALUES ('" . $payment . "')";
    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Berhasil ditambahkan'); window.location='payment.php';</script>";
    } else {
        echo "<script>alert('Gagal ditambahkan'); window.location='payment.php';</script>";
    }
}

if (isset($_POST["edit_payment"])) {
    $payment = $_POST["payment"];
    $id = $_POST["id"];

    foreach ($payment as $index => $value) {
        $query = "UPDATE metode_pembayaran SET metode = '".$value."' WHERE id = '".$id[$index]."'";
        if (mysqli_query($koneksi, $query)) {
            
        } else {
            echo "<script>alert('gagal diedit'); window.location='payment.php';</script>";
        }
    }

    echo "<script>alert('berhasil diedit'); window.location='payment.php';</script>";
}

if (isset($_GET["delete"])) {
    $id = $_GET["id"];

    // Masukkan data pengguna baru ke dalam database
    $query = "DELETE from metode_pembayaran WHERE id = '$id' ";
    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Berhasil dihapus'); window.location='payment.php';</script>";
    } else {
        echo "<script>alert('Gagal dihapus'); window.location='payment.php';</script>";
    }
}

require_once "header.php";
?>
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
        <form action="payment.php" method="post" style="margin-bottom: 14px;">
            <input type="text" name="payment" required>
            <button type="submit" class="btn btn-success" name="create_payment">Add</button>
        </form>
        <form action="payment.php" method="post">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Payment Method</th>
                        <th scope="col"></th>
                        <th scope="col">Handle</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="display: none;">
                        <td scope="row">0</td>
                        <td><input id="payment" class="input-disabled" name="payment[]" type="text" value="test" disabled></td>
                        <td><input id="id" name="id[]" type="hidden" value="test" disabled></td>
                        <td>
                            <div>
                                <button type="button" onclick="editHandler(this)" class="button">Edit</button>
                                <form action="delete_category.php" method="post" style="display: inline;">
                                    <input id="id" name="id" type="hidden" value="test">
                                    <button type="submit" class="button">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php
                    $query = "SELECT * FROM metode_pembayaran";
                    $dt_query = $koneksi->query($query);
                    $dt_query = $dt_query->fetch_all(MYSQLI_ASSOC);
                    foreach ($dt_query as $index => $payment) {
                    ?>
                        <tr>
                            <td scope="row"><?php echo $index + 1 ?></td>
                            <td><input id="payment" class="input-disabled" name="payment[]" type="text" value=<?php echo '"' . $payment['metode'] . '"' ?> disabled></td>
                            <td><input id="id" name="id[]" type="hidden" value=<?php echo '"' . $payment['id'] . '"' ?> disabled></td>
                            <td>
                                <div>
                                    <button type="button" onclick="editHandler(this)" class="btn btn-warning">Edit</button>
                                    <form action="delete_category.php" method="post" style="display: inline;">
                                        <input id="id" name="id" type="hidden" value=<?php echo '"' . $payment['id'] . '"' ?>>
                                        <a href="payment.php?delete=1&id=<?php echo $payment['id'] ?>" class="btn btn-danger">Delete</a>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <button name="edit_payment" type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
    <script>
        function editHandler(el) {
            var parent = el.parentNode.parentNode.parentNode;
            var payment = parent.querySelector('#payment');
            var id = parent.querySelector('#id');

            id.removeAttribute('disabled');
            payment.removeAttribute('disabled');
            payment.style.border = "1px solid black";
        }
    </script>
 <?php require_once "footer.php"; ?>
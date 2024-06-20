<?php
session_start();
include "../koneksi.php";

if (isset($_POST["create_table"])) {
    $table = $_POST["table"];
    $capacity = $_POST["capacity"];

    // Masukkan data pengguna baru ke dalam database
    $query = "INSERT INTO meja (`nomor_meja`, `kapasitas`) VALUES ('$table', '$capacity')";
    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Berhasil ditambahkan'); window.location='table.php';</script>";
    } else {
        echo "<script>alert('Gagal ditambahkan'); window.location='table.php';</script>";
    }
}

if (isset($_POST["edit_table"])) {
    $tables = $_POST["table"];
    $capacities = $_POST["capacity"];
    $ids = $_POST["id"];

    foreach ($tables as $index => $value) {
        $query = "UPDATE meja SET nomor_meja = '$value', kapasitas = '{$capacities[$index]}' WHERE id = '{$ids[$index]}'";
        if (mysqli_query($koneksi, $query)) {
            // Successfully updated
        } else {
            echo "<script>alert('gagal diedit'); window.location='table.php';</script>";
        }
    }

    echo "<script>alert('berhasil diedit'); window.location='table.php';</script>";
}

if (isset($_GET["delete"])) {
    $id = $_GET["id"];

    // Masukkan data pengguna baru ke dalam database
    $query = "DELETE FROM meja WHERE id = '$id' ";
    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Berhasil dihapus'); window.location='table.php';</script>";
    } else {
        echo "<script>alert('Gagal dihapus'); window.location='table.php';</script>";
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
    <form action="table.php" method="post" style="margin-bottom: 14px;">
        <input type="number" name="table" placeholder="Table Number" required>
        <input type="number" name="capacity" placeholder="Capacity" required>
        <button type="submit" class="btn btn-success" name="create_table">Add</button>
    </form>
    <form action="table.php" method="post">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Table Number</th>
                    <th scope="col">Capacity</th>
                    <th scope="col"></th>
                    <th scope="col">Handle</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM meja";
                $dt_query = $koneksi->query($query);
                $dt_query = $dt_query->fetch_all(MYSQLI_ASSOC);
                foreach ($dt_query as $index => $table) {
                ?>
                    <tr>
                        <td><?php echo $index + 1 ?></td>
                        <td><input class="input-disabled" name="table[]" type="text" value="<?php echo $table['nomor_meja'] ?>" disabled></td>
                        <td><input class="input-disabled" name="capacity[]" type="text" value="<?php echo $table['kapasitas'] ?>" disabled></td>
                        <td><input name="id[]" type="hidden" value="<?php echo $table['id'] ?>" disabled></td>
                        <td>
                            <div>
                                <button type="button" onclick="editHandler(this)" class="btn btn-warning">Edit</button>
                                <a href="table.php?delete=1&id=<?php echo $table['id'] ?>" class="btn btn-danger">Delete</a>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <button name="edit_table" type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
<script>
    function editHandler(el) {
        var parent = el.parentNode.parentNode.parentNode;
        var table = parent.querySelector('input[name="table[]"]');
        var capacity = parent.querySelector('input[name="capacity[]"]');
        var id = parent.querySelector('input[name="id[]"]');

        id.removeAttribute('disabled');
        table.removeAttribute('disabled');
        capacity.removeAttribute('disabled');
        table.style.border = "1px solid black";
        capacity.style.border = "1px solid black";
    }
</script>
<?php require_once "footer.php"; ?>
`
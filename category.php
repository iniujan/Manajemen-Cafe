<?php
session_start();
include "../../koneksi.php";
require_once "../header.php";
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
        <form action="create_category.php" method="post" style="margin-bottom: 14px;">
            <input type="text" name="kategori" required>
            <button type="submit">Add</button>
        </form>
        <form action="edit_category.php" method="post">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Category</th>
                        <th scope="col"></th>
                        <th scope="col">Handle</th>
                    </tr>
                </thead>
                <tbody>
                     <tr style="display: none;">
                            <td scope="row">0</td>
                            <td><input id="category" class="input-disabled" name="category[]" type="text" value="test" disabled></td>
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
                    $query = "SELECT * FROM kategori";
                    $dt_query = $koneksi->query($query);
                    $dt_query = $dt_query->fetch_all(MYSQLI_ASSOC);
                    foreach ($dt_query as $index => $kategori) {
                    ?>
                        <tr>
                            <td scope="row"><?php echo $index + 1 ?></td>
                            <td><input id="category" class="input-disabled" name="category[]" type="text" value=<?php echo '"' . $kategori['nama_kategori'] . '"' ?> disabled></td>
                            <td><input id="id" name="id[]" type="hidden" value=<?php echo '"' . $kategori['id'] . '"' ?> disabled></td>
                            <td>
                                <div>
                                    <button type="button" onclick="editHandler(this)" class="button">Edit</button>
                                    <form action="delete_category.php" method="post" style="display: inline;">
                                        <input id="id" name="id" type="hidden" value=<?php echo '"' . $kategori['id'] . '"' ?>>
                                        <button type="submit" class="button">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <button type="submit">Save</button>
        </form>
    </div>
    <script>
        function editHandler(el) {
            var parent = el.parentNode.parentNode.parentNode;
            var category = parent.querySelector('#category');
            var id = parent.querySelector('#id');

            id.removeAttribute('disabled');
            category.removeAttribute('disabled');
            category.style.border = "1px solid black";
        }
    </script>
<?php require_once "../footer.php"; ?>

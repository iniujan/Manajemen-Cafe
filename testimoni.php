<?php
session_start();
require "koneksi.php"; // Pastikan path ke file koneksi benar

$ratings = [];
$message = "";

// Menangani penambahan rating
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST["nama"];
    $rate = $_POST["rate"];

    $sql = "INSERT INTO rate (nama, rate) VALUES ('$nama', '$rate')";
    if (mysqli_query($koneksi, $sql)) {
        $message = "New Rate added successfully";
    } else {
        $message = "Error: " . $sql . "<br>" . mysqli_error($koneksi);
    }
}

// Mengambil semua rating dari database
$sql = "SELECT * FROM rate";
$result = mysqli_query($koneksi, $sql);
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $ratings[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rating - Neco Cafe</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css" rel="stylesheet">
    <!-- <link href="assets/css/style.css" rel="stylesheet"> -->
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h3 class="text-center">Rating System</h3>
                <?php if (!empty($message)): ?>
                    <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
                <?php endif; ?>
                <form action="testimoni.php" method="post" class="mt-4">
                    <div class="form-group">
                        <label for="nama">Name</label>
                        <input type="text" name="nama" id="nama" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Rate</label>
                        <div class="rateyo" id="rate" data-rateyo-rating="4" data-rateyo-num-stars="5" data-rateyo-score="3"></div>
                        <span class="result">0</span>
                        <input type="hidden" name="rate">
                    </div>
                    <button type="submit" name="add" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-8 offset-md-2">
                <h3 class="text-center">Customer Rating</h3>
                <?php if (!empty($ratings)): ?>
                    <?php foreach ($ratings as $rating): ?>
                        <div class="card mt-3">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($rating['nama']); ?></h5>
                                <div class="rateyo" data-rateyo-rating="<?php echo htmlspecialchars($rating['rate']); ?>" data-rateyo-read-only="true"></div>
                                <p class="card-text">Rating: <?php echo htmlspecialchars($rating['rate']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center">Belum ada testimoni.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
    <script>
        $(function () {
            $(".rateyo").rateYo().on("rateyo.change", function (e, data) {
                var rate = data.rating;
                $(this).parent().find('.result').text('rate: ' + rate);
                $(this).parent().find('input[name=rate]').val(rate); // add rating value to input field
            });
        });
    </script>
</body>
</html>
